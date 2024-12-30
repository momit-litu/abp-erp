<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Requests;
use App\Models\System;
use App\Models\Student;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use App\Models\UserGroupMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Traits\StudentNotification;
use Illuminate\Support\Facades\URL;
use App\Services\SMSService;

class AuthController extends Controller
{
    use StudentNotification; 
	public $SMSService;
    public function __construct(Request $request, SMSService $SMSService){
		$this->SMSService = $SMSService;
        $this->page_title 	= $request->route()->getName();
        $description 		= \Request::route()->getAction();
        $this->page_desc 	= isset($description['desc']) ? $description['desc'] : $this->page_title;
    }


    /**
     * Show admin login page for admin
     * checked Auth user, if failed get user data according to email.
     * checked user type, if "admin" redirect to dashboard
     * or redirect to login.
     *
     * @return HTML view Response.
     */
    public function authLogin()
    {	
		//session()->flush();	
	    \Session::put('redirect_to_2nd_prev_page', url()->previous());
        if (\Auth::check()) {
            \App\Models\User::LogInStatusUpdate("login");
            return redirect('dashboard');

        } else {
            $data['page_title'] = $this->page_title;
            $session_email		=\Session::get('email');
            if (!empty($session_email)) {
                $user_info=\DB::table('users')
                    ->where('email', $session_email)
                    ->select('email','name','user_profile_image')
                    ->first();
                $data['user_info']=$user_info;
            }
            return view('auth.login',$data);
        }
    }

    /**
     * Check Admin Authentication
     * checked validation, if failed redirect with error message
     * checked auth $credentials, if failed redirect with error message
     * checked user type, if "admin" change login status.
     *
     * @param  Request $request
     * @return Response.
     */
    public function authPostLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' 	=> 'required|email',
            'password' 	=> 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $remember_me = $request->has('remember_me') ? true : false;
        $credentials = [
            'email'	 	=> $request->input('email'),
            'password'	=>$request->input('password'),
            'status'	=> "1"
        ];

        if (\Auth::attempt($credentials,$remember_me)) {
            \Session::put('email', \Auth::user()->email);
            \Session::put('last_login', Auth::user()->last_login);

            if (\Session::has('pre_login_url') ) {
                $url = \Session::get('pre_login_url');
                \Session::forget('pre_login_url');
                return redirect($url);
            }else {
                \App\Models\User::LogInStatusUpdate(1);
                if(Auth::user()->type == 'Student'){
                    $student = Student::find(Auth::user()->student_id);
                    \Session::put('student_no', $student->student_no);
				   if (\Session::has('redirect_to_2nd_prev_page') ) {
						$redirect_to_2nd_prev_page = \Session::get('redirect_to_2nd_prev_page');
						\Session::forget('redirect_to_2nd_prev_page');
						return redirect($redirect_to_2nd_prev_page);
					}
					else				   
						return redirect()->back();
                }                    
                else
                    return redirect('dashboard');
            }
        } else {
            return redirect('auth/login')
                ->with('errormessage',"Incorrect combinations.Please try again.");
        }
    }

    /**
     * Admin logout
     * check auth login, if failed redirect with error message
     * get user data according to email
     * checked name slug, if found change login status and logout user.
     *
     * @param string $name_slug
     * @return Response.
     */
    public function authLogout($email)
    {
        if (\Auth::check()) {
            $user_info = \App\Models\User::where('email',\Auth::user()->email)->first();
           // print_r($user_info); die();
            if (!empty($user_info) && ($email==$user_info->email)) {
				\App\Models\User::LogInStatusUpdate(0);
                \Auth::logout();
                \Session::flush();
                return \Redirect::to('index');
            } else {
                return \Redirect::to('index');
            }
        } else {
            return \Redirect::to('index')->with('errormessage',"Error logout");
        }
    }



    /**
     * Send mail to user who forget his account password
     * check user name exist, if not found redirect to same page.
     *
     * @param  $request
     * @return Response.
     */

    public function forgetPasswordAuthPage()
    {
        if (\Auth::check()) {
            return redirect('auth/login')->with('errormessage', 'Whoops, looks like something went wrong!.');
        } else {
            $data['page_title'] = $this->page_title;
            return view('auth.forget-password',$data);
        }
    }
	
	
    public function authForgotPasswordConfirm(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }
        $email = $request->input('email');
        $user_email= \App\Models\User::where('email','=',$email)->first();
        if (!isset($user_email->id)) {
            return redirect('auth/forget/password')->with('errormessage',"Sorry email does not match!");
        }


        #UpdateRememberToken
        $token = System::RandomStringNum(16);
        \App\Models\User::where('id',$user_email->id)->update(['remember_token'=>$token]);

        $reset_url= url('auth/forget/password/'.$user_email->id.'/verify').'?token='.$token;
		//echo $reset_url;die;
        //return \Redirect::to($reset_url);

        $mail = System::ForgotPasswordEmail($user_email->id, $reset_url);

        return redirect('auth/forget/password')->with('message',"Please check your mail !.");
    }
	
 
	public function otpIndex()
    {
        if (\Auth::check()) {
            return redirect('auth/login')->with('errormessage', 'Whoops, looks like something went wrong!.');
        } else {
            $data['page_title'] = $this->page_title;
            return view('auth.otp-index',$data);
        }
    }
	

	public function otpSend(Request $request)
    {

        $v = \Validator::make($request->all(), [
            'mobile_no' => 'required|numeric',
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }
				
        $contact_no = $request->input('mobile_no');
        $user= \App\Models\User::where('contact_no','=',$contact_no)->first();
        if (!isset($user->id)) {
            return redirect('auth/forget/password-otp')->with('errormessage',"Sorry mobile number does not match!");
        }

        #send otp
        $otp = rand(100000, 999999);
        $otpUser = \App\Models\User::where('id',$user->id)->update(['otp'=>$otp]);
		if($otpUser){
			$smsController = new NotificationController($request,$this->SMSService );
			$sentOTP = $smsController->sendOtp($contact_no, $otp);
			if(!$sentOTP){
				 return redirect('auth/forget/password-otp')->with('errormessage',"OTP not sent! Try again");
			}
			session(['user_id' 		=> $user->id]);
			session(['mobile_no' 	=> $contact_no]);
			return redirect('auth/forget/password-otp/verify');
		}
		else{
			 return redirect('auth/forget/password-otp')->with('errormessage',"OTP not sent! Try again");
		}

    }
 
 	public function otpVerification(Request $request)
    {
		$data['user_id'] = $request->session()->get('user_id');
		$data['mobile_no'] = $request->session()->get('mobile_no');
		
		$request->session()->now('message', 'OTP sent. Check your mobile');
		//Session::flash('message', 'OTP sent. Check your mobile'); 
		return view('auth.otp-verify',$data);
    }
	
 
 
	public function otpVerificationPost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'otp' 		=> 'required',
			'user_id' 	=> 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
		
		$user = User::where('id',$request->user_id)->where('otp',$request->otp)->first();
        if(!empty($user)){
			$remember_me = true;
			$credentials = [
				'email'	 => $user->email,
				'otp'	 => $user->otp,
				'status'	=> "1"
			];
            //if (\Auth::attempt($credentials,$remember_me)) {
			if(Auth::loginUsingId($user->id)){
				
				$user->otp = "";
				$user->save();
				$request->session()->forget(['user_id', 'mobile_no']); 
				
				\Session::put('email', \Auth::user()->email);
				\Session::put('last_login', Auth::user()->last_login);

				\App\Models\User::LogInStatusUpdate(1);
				if(Auth::user()->type == 'Student'){
					$student = Student::find(Auth::user()->student_id);
					\Session::put('student_no', $student->student_no);
				}                    
				return redirect('/dashboard');
			}
		}
		else
		{
			session()->forget('message');
			return redirect('auth/forget/password-otp/verify')->with('errormessage',"Sorry OTP does not match!");
		}
	}
 
    public function registration()
    {
        if (\Auth::check()) {
            return redirect('/dashboard');
        } else {
            $data['page_title'] = $this->page_title;
            return view('auth.register',$data);
        }
    }


    public function registrationSave(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'name'      => 'Required',
            'email'     => 'Required|email|unique:users',
            'contact'   => 'Required|max:11|unique:users,contact_no',
            'password'  => 'required|min:4|',
            'confirm_password'  => 'required|same:password',
            'terms_condition'   =>'accepted',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($v->fails()) {
           // dd($v);
           // return redirect()->back()->withErrors($v)->withInput();
            return redirect()->back()->withErrors($v)->withInput($request->except('password'));
        }
        else{
              try{
                DB::beginTransaction();
                
                // save the student
                $student = Student::create([
                    'name'          => $request['name'],                   
                    'email'         => $request['email'],
                    'contact_no'    => $request['contact'],
                    'register_type' =>'Self',
                    'registration_completed'=>'Yes'
                ]);
                if($student){
                    $student->student_no = str_pad(($student->id+8000),6,'0',STR_PAD_LEFT);
                    $student->save();
                    // create a student type user
                    $studentUser = User::create([
                        'first_name'	=> $request['name'],
                        'contact_no'	=> $request['contact'],
                        'email'			=> $request['email'],
                        'password' 		=> bcrypt($request['password']),
                        'type'			=> 'Student',
                        'student_id'	=> $student->id,
                        'status'        =>1
                    ]);

                    $user_group = UserGroup::select('id')->where('type',2)->first();
                    $group_member_data 				= new UserGroupMember();
                    $group_member_data->group_id	= $user_group['id'];
                    $group_member_data->user_id		= $studentUser->id;
                    $group_member_data->status		= 1;
                    $group_member_data->save();
                }                
                DB::commit();
			 //  removed the registration validation as ABP asked to do that
             //  $this->registrationEmail($student->id);
				$this->registrationCompletedNotification($student);
				$this->registrationConfirmEmail($student->id);
				
                return redirect('portal/login')->with('message',"Registration completed. Now you can login. We also sent an email with login details");
              }
              catch (\Exception $e){
				DB::rollback();
                return redirect()->back()->with('errormessage',"Registration faild. Please try again");
			}
        }
    }

 //  removed the registration validation as ABP asked to do that
   /* public function registrationComplete($id)
    {
        $student = Student::where('registration_completed','No')->where('id',$id)->first();
        if(!empty($student)){
            $student->registration_completed = 'Yes';
            $student->update();
            
            $user = User::where('student_id', $student->id)->first();
            $user->status = '1';
            $user->update();
           
            $this->registrationCompletedNotification($student);
            $this->registrationConfirmEmail($student->id);

            return redirect('login')->with('message',"Registration completed. Now you can login");
        }
        return redirect('error')->with('errormessage',"Invalid request");
    }
*/
    
    public function errorRequest()
    {
        return view('auth.error');
    }

    /**
     * creating form for new password
     * update password according to user_id.
     *
     * @param int $users_id
     * @return HTML view Response.
     */
    public function authSystemForgotPasswordVerification($user_id)
    {
        $remember_token=isset($_GET['token'])?$_GET['token']:'';
        $user_info= \App\Models\User::where('id','=',$user_id)->first();

        if(!empty($remember_token)&&isset($user_info->id) && !empty($user_info->remember_token) && ($user_info->remember_token==$remember_token)){

            $data['user_info']=$user_info;
            $data['page_title'] = $this->page_title;
            return \View::make('auth.set-new-password',$data);

        } else return redirect('auth/forget/password')->with('errormessage',"Sorry invalid token!");

    }

    /**
     * Set new password according to user
     * check validation, if failed redirect same page with error message
     * change user password and update user table.
     *
     * @param Request $request
     * @return Response.
     */
    public function authSystemNewPasswordPost(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        $validator = \Validator::make($request->all(), [
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id =  \Request::input('user_id');

        $update_password=array(
            'password' => bcrypt($request->input('password')),
            'remember_token' => null,
            'updated_at' => $now
        );
        try {
            $update_pass=\App\Models\User::where('id', $user_id)->update($update_password);
            if($update_pass) {
                return redirect('auth/login')->with('message',"Password updated successfully !");
            }
        } catch(\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            return redirect('auth/login')->with('errormessage',"Password update failed  !");
        }

    }


    public function EmailVerificationPage($user_id)
    {
        $remember_token=isset($_GET['token'])?$_GET['token']:'';
        $user_info= \App\Models\User::where('id','=',$user_id)->first();

        if(!empty($remember_token)&&isset($user_info->id) && !empty($user_info->remember_token) && ($user_info->remember_token==$remember_token)){

            $data['user_info']=$user_info;
            $data['page_title'] = $this->page_title;
            return \View::make('partner.partner-set-new-password',$data);

        }else return redirect('/')->with('errormessage',"Sorry invalid token!");

    }


    public function EmailUpdateNewPassword(Request $request,$user_id)
    {
        $now = date('Y-m-d H:i:s');
        $validator = \Validator::make($request->all(), [
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id =  \Request::input('user_id');

        $update_password=array(
            'password' => bcrypt($request->input('password')),
            'remember_token' => null,
            'updated_at' => $now
        );
        try {
            $update_pass=\App\Models\User::where('id', $user_id)->update($update_password);

            if($update_pass) {
                return redirect('auth/login')->with('message',"Password updated successfully !");
            }
        } catch(\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            return redirect('auth/login')->with('errormessage',"Password update failed  !");
        }
    }
}
