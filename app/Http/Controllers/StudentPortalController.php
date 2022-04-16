<?php
namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Validator;
use \App\Models\User;
use App\Models\Batch;
use \App\Models\Course;
use App\Models\Setting;
use \App\Models\Student;
use App\Models\BatchFee;
use App\Models\BatchStudentUnit;
use App\Models\StudentBook;
use App\Models\UserGroup;
use App\Models\WebAction;
use App\Models\BatchStudent;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use \App\Models\StudentCourse;
use App\Models\StudentPayment;
use App\Models\StudentDocument;
use App\Models\UserGroupMember;
use App\Traits\PortalHelperModel;
use App\Models\UserGroupPermission;
use App\Models\StudentRevisePayment;
use Illuminate\Support\Facades\File;
use App\Notifications\newPaymentByStudent;
use App\Traits\StudentNotification;



class StudentPortalController extends Controller
{
    use HasPermission;
    use PortalHelperModel;
    use StudentNotification;
	
    public function __construct(Request $request)
    {
        $this->studentPayment   = new StudentPayment();
        $this->page_title       = $request->route()->getName();
        $description            = \Request::route()->getAction();
        $this->page_desc        = isset($description['desc']) ? $description['desc'] : $this->page_title;
	}

	public function index()
    {
        $page_title             = $this->page_title;
		$data['module_name']    = "Dashboard";

		if (Auth::check()){
			$studentId 		        = Auth::user()->student_id;
			$student	  	        = Student::find($studentId);
			$data['student']        = $student;
		}
		else 
			$data['student']        = "";

    
        //get featured course list
        $featuredBatcheResponse     = $this->courseList(1,5, 'Featured');
        $data['featured_batches_bg_color'] = ['bg-ripe-malin','bg-premium-dark','bg-sunny-morning','bg-plum-plate','bg-grow-early'];

        $data['featured_batches']   = $featuredBatcheResponse['batches'];

        //get ongoind course list
        $runningBatcheResponse      = $this->courseList(1,4, 'Running');
        $data['running_batches']    = $runningBatcheResponse['batches'];

        //get upcomiong course list
        $upcomingBatcheResponse     = $this->courseList(1,4, 'Upcoming');
        $data['upcoming_batches']   = $upcomingBatcheResponse['batches'];

        // get total active student
        //total cirtified students
        // total teachers will come from settings

        //dd($data);
        return view('student-portal.dashboard', array('page_title'=>$page_title, 'data'=>$data/*,'student'=>$student*/));
    }
    
	public function showCourseList($type)
    {
        if($type != 'Running' && $type != 'Upcoming' && $type != 'Completed'){
            return redirect()->back();
        }
        $page_title         = $this->page_title;
        $batcheResponse     = $this->courseList(1,50, $type);
        $data['type']       = $type;
        $data['batches']    = $batcheResponse['batches'];
        $data['background'] = ($type == 'Running')?"bg-happy-green":"bg-plum-plate";

        return view('student-portal.course-list', array('page_title'=>$page_title, 'data'=>$data));
    }

    public function showMyCourseList($type)
    {
        if($type != 'Running'  && $type != 'Upcoming' &&  $type != 'Completed' && $type != 'Registered'){
            return redirect()->back();
        }
       // echo $type;die;
        $page_title          = $this->page_title;
        $batcheResponse      = $this->courseList(1,50, $type, 'my');
        $data['batches']     = $batcheResponse['batches'];
        $data['type']        = $type;

        return view('student-portal.my-course-list', array('page_title'=>$page_title, 'data'=>$data));
    }
    
    public function courseDetails($id)
    {
        $page_title = $this->page_title;
		$data['module_name']= "Dashboard";
		if (Auth::check()){
			$studentId 		= Auth::user()->student_id;
			$student	  	= Student::find($studentId);
		}
		else
			$student = "";
        
        $data['student']=$student;
        $batchDetails   = $this->courseDetailsByBatchId($id);

        if(!$batchDetails){
            return redirect()->back();
        }
        return view('student-portal.course-details', array('page_title'=>$page_title, 'data'=>$data,'student'=>$student, 'batch'=>$batchDetails));
    }

    public function studentShow()
    {
        $studentId 		= Auth::user()->student_id; 
        $student = Student::with('documents')->findOrFail($studentId);
        $batchStudent = new BatchStudent();
        $courses = $batchStudent->getBatchesByStudentId($student->id);
        return json_encode(array('student' => $student, 'courses'=>$courses));
    }
   
    public function studentEdit(Request $request)
    {
        if (!is_null($request->input('id')) && $request->input('id') != "") {
            $response_data = $this->editStudent($request->all(), $request->input('id'), $request->file('user_profile_image') , $request->file('documents') );
        } // new entry
		else{
			$response_data = $this->saveStudent($request->all(), $request->input('id'), $request->file('user_profile_image') , $request->file('documents') );
		}
       /* else {
            $return['response_code'] = 0;
            $return['errors'] = "Please check the information properly or refresh the page and try again";
            $response_data = json_encode($return);
        }*/
        return $response_data;
    }

    public function studentEnroll(Request $request)
    { 

        $studentId 		= Auth::user()->student_id; 
        try {
            if($request['register_batch_id'] == "" || $request['batch_fees_id']==""){
                $return['response_code'] = "0";
                $return['errors'] = 'Validation failed';
                 return json_encode($return);
            }
            else{	
                $studentEnrollmentCheck = BatchStudent::where('batch_id',$request['register_batch_id'] )->where('student_id', $studentId)->first();
                if($studentEnrollmentCheck){
                    $return['response_code'] = "0";
                    $return['errors'] = 'Student already enrolled in this batch';
                     return json_encode($return);
                }

                $batchFee  = BatchFee::with('batch','installments')->findOrFail($request['batch_fees_id']);
               // dd($batchFee);
				$batchStudent = BatchStudent::create([
                    'batch_id' 	    =>  $request['register_batch_id'],
                    'student_id'	=>  $studentId,
                    'batch_fees_id' =>  $request['batch_fees_id'],
                    'total_payable' =>  $batchFee->payable_amount,
                    'balance'       =>  $batchFee->payable_amount,
                    'status'        => 'Inactive',
                ]);
                if($batchStudent){
                    $enrollment = BatchStudent::with('batch', 'batch.course', 'batch.course.units','batch.books')->find($batchStudent->id);

                   /* $enrollment             = BatchStudent::with('batch', 'batch.course')->find($batchStudent->id);

                    $lastEnrollmentIdSQL    = DB::select("SELECT Max(SUBSTR(student_enrollment_id,-3,3)) as max_enrollmen_id FROM batch_students where student_enrollment_id != '' AND batch_id=".$request['batch_id']);

                    $lastEnrollmentId = (!is_null($lastEnrollmentIdSQL[0]->max_enrollmen_id))?$lastEnrollmentIdSQL[0]->max_enrollmen_id:0;

                    $student_enrollment_id =  $enrollment->batch->course->short_name_id. $enrollment->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);

                    $enrollment->student_enrollment_id = $student_enrollment_id ;
                    $enrollment->save();*/

                    // save into student batch units
                    foreach($enrollment->batch->course->units as $unit){
                        $batchStudentUnit = BatchStudentUnit::create([
                            'batch_student_id'=>  $batchStudent->id,
                            'unit_id'         =>  $unit->id,
                            'created_by'      =>  Auth::user()->id
                        ]);  
                    }

                    // save into student batch book
                    foreach($enrollment->batch->books as $book){
                        $studentBook = StudentBook::create([
                            'batch_student_id'=>  $batchStudent->id,
                            'batch_book_id'   =>  $book->id,
                            'student_id'      =>  $studentId
                        ]);  
                    }

                    $batchFee->batch->total_enrolled_student = ($batchFee->batch->total_enrolled_student)+1;
                    $batchFee->batch->update();
                    $settings = Setting::first();

                    foreach($batchFee->installments as $key => $installment){
                        if($key == 0) 
                            $last_payment_date= date('Y-m-d');
                        else if($key==1){
                            $last_payment_date  = date('Y-m', strtotime($batchFee->batch->start_date. ' + '.$batchFee->installment_duration.' month'))."-".$settings->bill_date;
                        }                       
                           
                        else
                            $last_payment_date  = date('Y-m', strtotime($last_payment_date. ' + '.$batchFee->installment_duration.' month'))."-".$settings->bill_date;
                        $studentPayment = StudentPayment::create([
                            'student_enrollment_id' =>  $batchStudent->id,
                            'installment_no'        =>  $installment->installment_no,
                            'payable_amount'        =>  $installment->amount,
                            'last_payment_date'     =>  $last_payment_date,
                        ]); 
                        
                        if($key == 0) 
                            $studentFirstPaymentId = $studentPayment->id;
                    }
                }
             }				
            DB::commit();
            
            // Notifications nd email
           
            $batchStudent = BatchStudent::with('student','batch','batch.course')->find($batchStudent->id);
            $this->courseEnrollmentNotificationForAdmin($batchStudent); 
            $this->courseEnrollmentNotificationForStudent($batchStudent); 
            $this->enrollmentEmail($batchStudent->id); 

            $return['response_code'] = 1;
            $return['message'] = "Registration successfully";
            $return['studentFirstPaymentId'] = $studentFirstPaymentId; 
            return json_encode($return);
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to register !".$e->getMessage();
			return json_encode($return);
		}

    }

    private function saveStudent($request, $id, $photo, $documents)
    {

       // $student = Student::find(62);
        //$this->registrationCompletedNotification($student);
        //$this->registrationConfirmEmail($student->id);

        //die;
        
        try {
            $rule = [
                'name' => 'required|string',
                'date_of_birth' => 'required',
                'student_address_field' => 'required',
                'contact_no' => 'Required|max:11|unique:users,contact_no',
                'student_email' => 'Required|email',
                'user_profile_image' => 'mimes:jpeg,jpg,png,svg|max:2000',
                'documents.*' => 'max:2000',
				'password'  => 'required|min:4|',
				'confirm_password'  => 'required|same:password',
            ];			
			
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {

                DB::beginTransaction();

                $emailVerification = Student::where([['email', $request['student_email']]])->first();
                if (isset($emailVerification->id)) {
                    $return['response_code'] = "0";
                    $return['errors'][] = $request['student_email'] . " is already exists";
                    return json_encode($return);
                }
  				// save the student
                $student = Student::create([
                    'name'          => $request['name'],                   
                    'email'         => $request['student_email'],
                    'contact_no'    => $request['contact_no'],
					'emergency_contact' => $request['emergency_contact'],
					'address'       => $request['student_address_field'],
					'nid_no'        => $request['nid'],
					'date_of_birth' => $request['date_of_birth'],
					'study_mode'        => $request['study_mode'],
					'current_emplyment' => $request['current_emplyment'],
					'current_designation' => $request['current_designation'],
					'last_qualification'  => $request['last_qualification'],
					'how_know'  	=> $request['how_know'],
					'passing_year'  => $request['passing_year'],
                    'register_type' =>'Self',
                    'registration_completed'=>'Yes'
                ]);
                if($student){
                    $student->student_no = str_pad(($student->id+8000),6,'0',STR_PAD_LEFT);
                    $student->save();
                    // create a student type user
                    $user = User::create([
                        'first_name'	=> $request['name'],
                        'contact_no'	=> $request['contact_no'],
                        'email'			=> $request['student_email'],
                        'password' 		=> bcrypt($request['password']),
                        'type'			=> 'Student',
                        'student_id'	=> $student->id,
                        'status'        =>1
                    ]);
                    $user_group = UserGroup::select('id')->where('type',2)->first();
                    $group_member_data 				= new UserGroupMember();
                    $group_member_data->group_id	= $user_group['id'];
                    $group_member_data->user_id		= $user->id;
                    $group_member_data->status		= 1;
                    $group_member_data->save();
                }  

               
                $StudentImage = $photo;
                if (isset($StudentImage) && $StudentImage!="") {
                    $old_image = $student->user_profile_image;
                    $image_name = time();
                    $ext = $StudentImage->getClientOriginalExtension();
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'assets/images/user/student/';
                    $success = $StudentImage->move($upload_path, $image_full_name);
                    $student->user_profile_image = $image_full_name;
                    $user->user_profile_image = $image_full_name;
                }
                $student->update();
                $user->update();

                if (isset($documents) && !empty($documents)) {
                    foreach($documents as $document) {
                        $ext = $document->getClientOriginalExtension();
                        $documentFullName = $document->getClientOriginalName().time(). '.' . $ext;
                        $upload_path = 'assets/images/student/documents/';
                        $success = $document->move($upload_path, $documentFullName);

                        $studentDocument = StudentDocument::create([
                            'student_id'	=> $student->id,
                            'document_name'	=> $documentFullName,
                            'type'	        => $ext,
                        ]);
                    }
                }
                DB::commit();
				
				// auto login
				$remember_me = true;
				$credentials = [
					'email'	 	=> $request['student_email'],
					'password'	=> $request['password'],
					'status'	=> "1"
				];

				if (\Auth::attempt($credentials,$remember_me)) {
					\Session::put('email', \Auth::user()->email);
					\Session::put('last_login', Auth::user()->last_login);

					if (\Session::has('pre_login_url') ) {
						$url = \Session::get('pre_login_url');
						\Session::forget('pre_login_url');
					}else {
						\App\Models\User::LogInStatusUpdate(1);
						if(Auth::user()->type == 'Student'){
							$student = Student::find(Auth::user()->student_id);
							\Session::put('student_no', $student->student_no);
						}                    
					}
				}
				
				$this->registrationCompletedNotification($student);
				$this->registrationConfirmEmail($student->id);
			
                $return['response_code'] = 1;
				$return['student_id'] = $student->id;
                $return['message'] = "Student registration successful";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to insert !" . $e->getMessage();
            return json_encode($return);
        }
    }
   
    private function editStudent($request, $id, $photo, $documents)
    {
        //dd($request);
        try {
            if ($id == "") {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
            }

            $student = Student::with('documents','user')->findOrFail($id);
            $user    = User::where('student_id',$id)->firstOrFail();
            $oldDoc  = (isset($request['std_docs']))?json_decode(json_encode($request['std_docs']), true):"";

            if (empty($student)) {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No student found"));
            }

            $rule = [
                'name' => 'required|string',
                'date_of_birth' => 'required',
                'student_address_field' => 'required',
                'contact_no' => 'Required|max:13',
                'student_email' => 'Required|email',
                'user_profile_image' => 'mimes:jpeg,jpg,png,svg|max:2000',
                'documents.*' => 'max:2000',
            ];
            $validation = \Validator::make($request, $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $currentStatus 		= $student->status;

                $emailVerification = Student::where([['email', $request['student_email']], ['id', '!=', $id]])->first();
                if (isset($emailVerification->id)) {
                    $return['response_code'] = "0";
                    $return['errors'][] = $request['student_email'] . " is already exists";
                    return json_encode($return);
                }

                $student->name 		= $request['name'];
                $student->email 	= $request['student_email'];
                $student->contact_no= $request['contact_no'];
                $student->emergency_contact = $request['emergency_contact'];
                $student->address 	= $request['student_address_field'];
                $student->nid_no 	= $request['nid'];
                $student->date_of_birth = $request['date_of_birth'];
                if(isset($request['study_mode'])) $student->study_mode= $request['study_mode'];
                $student->current_emplyment 	= $request['current_emplyment'];
				$student->current_designation 	= $request['current_designation'];
				
                $student->last_qualification = $request['last_qualification'];
                if(isset($request['how_know'])) $student->how_know = $request['how_know'];
                $student->passing_year = $request['passing_year'];
                $student->registration_completed = "Yes";

               
                $student->update();

                $user->first_name 	= $request['name'];
                $user->email 		= $request['student_email'];
                $user->contact_no	= $request['contact_no'];
                $user->remarks 		= $request['remarks'];
               // $user->status = (isset($request['status'])) ? "Active" : 'Inactive';

                $StudentImage = $photo;
                if (isset($StudentImage) && $StudentImage!="") {
                    $old_image 	= $student->user_profile_image;
                    $image_name = time();
                    $ext 		= $StudentImage->getClientOriginalExtension();
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path= 'assets/images/user/student/';
                    $success 	= $StudentImage->move($upload_path, $image_full_name);
                    $student->user_profile_image = $image_full_name;
                    $user->user_profile_image = $image_full_name;
                    if(!is_null($old_image) && $user->user_profile_image != $old_image){
                        File::delete($upload_path.$old_image);
                    }
                }
                $student->update();
                $user->update();

                if (isset($documents) && !empty($documents)) {
                    foreach($documents as $document) {
                        $ext 				= $document->getClientOriginalExtension();
                        $documentFullName 	= $document->getClientOriginalName().time(). '.' . $ext;
                        $upload_path 		= 'assets/images/student/documents/';
                        $success 			= $document->move($upload_path, $documentFullName);

                        $studentDocument = StudentDocument::create([
                            'student_id'	=> $student->id,
                            'document_name'	=> $documentFullName,
                            'type'	        => $ext,
                        ]);
                    }
                }

                $deletedSDocs = $student->documents->except($oldDoc);
                foreach($deletedSDocs as $deletedSDoc){
                    $path = 'assets/images/student/documents/';
                    File::delete($path.$deletedSDoc->document_name);
                    $deletedSDoc->delete();
                }


                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Student Updated successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to update !" . $e->getMessage();
            return json_encode($return);
        }
    }
   
	public function showPaymentList($type)
    {
        if($type != 'all' && $type != 'upcoming'){
            return redirect()->back();
        }
        $page_title = $this->page_title;
        $studentId 		= Auth::user()->student_id; 
        $paymentDetails = $this->studentPayment->getPaymentDetailsByStudentId($studentId);
        $batcheResponse = $this->courseList(1,50, $type);
        $data['type']   = $type;

        return view('student-portal.payment-list', array('page_title'=>$page_title, 'batchStudents'=>$paymentDetails,  'data'=>$data));
    }  
   
    public function savePaymentRevise(Request $request)
    {    
        //dd($request->all());    
        $studentId 		= Auth::user()->student_id; 
        try {
            if($request['revise_payment_id'] == "" || $request['revise_payment_details']==""){
                $return['response_code'] = "0";
                $return['errors'] = 'Please enter details';
                 return json_encode($return);
            }
            else{	

                $batchFee  = StudentPayment::findOrFail($request['revise_payment_id']);
				$studentRevisePayment = StudentRevisePayment::create([
                    'student_enrollment_id' =>  $batchFee->student_enrollment_id,
                    'revise_details'        =>  $request['revise_payment_details']
                ]);
                
             }				
            DB::commit();
            $return['response_code'] = 1;
            $return['message'] = "";
            return json_encode($return);
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to register !".$e->getMessage();
			return json_encode($return);
		}

    }
  
    public function checkoutShow($id)
    {
        $page_title = $this->page_title;
		$data['module_name']= "Dashboard";
		$studentId 		= Auth::user()->student_id;
        $student	  	= Student::find($studentId);
        $settings	  	= Setting::first();
        $data['settings']= $settings;
        $payment        = StudentPayment::with('enrollment','enrollment.batch','enrollment.batch.course')->where('payment_status',"!=","Paid")->find($id);
    
        if(!$payment){
            return redirect()->back();
        }
        return view('student-portal.checkout', array('page_title'=>$page_title, 'data'=>$data,'student'=>$student, 'payment'=>$payment ));
    }

    public function sslPaymentSuccess(Request $request)
    {     
        try { 
            $tran_id    = $request->input('tran_id');
            $amount     = $request->input('amount');

            DB::beginTransaction();
            $payment = StudentPayment::with('enrollment','enrollment.student')->where('payment_refference_no',$tran_id)->where('payment_status','!=','Paid')->first();
            $studentPayment = new StudentPayment;

            if (!empty($payment)) {
                //$payment_status =  (intval($payment->paid_amount+$amount) == intval($payment->payable_amount))?"Paid":"Partal";
                $payment_status          =  "Paid";
                $payment->paid_type      =  'SSL';
                $payment->paid_amount    =  $amount;//$payment->paid_amount + $amount;
                $payment->payment_status =  $payment_status;
                $payment->paid_date      =  date('Y-m-d');
                $payment->paid_by        =  'Self';
                $payment->invoice_no     = $studentPayment->getNextInvoiceNo();

                if($payment->update()){
                    $studentPayment->updateStudentFees($payment->student_enrollment_id); 
                    if($payment->enrollment->status == 'Inactive'){
                        $enrollment             = BatchStudent::with('batch', 'batch.course')->find($payment->enrollment->id);
                        $enrollment->status     = "Active";
      
                        $lastEnrollmentIdSQL    = DB::select("SELECT Max(SUBSTR(student_enrollment_id,-3,3)) as max_enrollmen_id FROM batch_students where student_enrollment_id != '' AND batch_id=".$enrollment->batch_id);

                        $lastEnrollmentId = (!is_null($lastEnrollmentIdSQL[0]->max_enrollmen_id))?$lastEnrollmentIdSQL[0]->max_enrollmen_id:0;

                        $student_enrollment_id =  $enrollment->batch->course->short_name_id. $enrollment->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);

                        $enrollment->student_enrollment_id = $student_enrollment_id ;
                        $enrollment->save();

                        $student = Student::find($enrollment->student_id);
                        if($student->type =='Non-enrolled'){
                            $student->type ='Enrolled';
                            $student->save();
                        }
                    }
                }                   
                else
                    throw new Exception('Something wrong!! Please contact with ABP admin');
            }
            else{
                throw new Exception('Something wrong!! Your payment process is failed');
            }

            $this->studentPaymentPaidNotification($payment);
            $this->invoiceEmail($payment->id);  
            DB::commit();

            return redirect('portal/course/'.$payment->enrollment->batch_id)->with('message','Payment received successfully')->with('response_code',1);
        }
        catch (\Exception $e){
            DB::rollback();
            $message   = "Failed !".$e->getMessage();
            return redirect('portal/checkout/'.$payment->id)->with('message',$message)->with('response_code',0);
        }        
    }

    public function sslPaymentFail(Request $request)
    {    
        $tran_id    = $request->input('tran_id');
        $payment = StudentPayment::with('enrollment','enrollment.student')->where('payment_refference_no',$tran_id)->first();
        
        if (!empty($payment)) {
            $payment->payment_refference_no = $tran_id;
            $payment->update();
            return redirect('portal/checkout/'.$payment->id)->with('message',"Your payment process is failed")->with('response_code',0);
        }
        else
            return redirect('portal/dashboard')->with('message',"Your payment process is failed")->with('response_code',0);
    }
   
    public function terms()
    {
        $page_title  = $this->page_title;
        return view('student-portal.terms', array('page_title'=>$page_title));
    }

    public function employementAutoComplete(Request $request){
		$term = $_REQUEST['term'];
        $data = Student::where([
                    ['status', '=', 'Active'],
                    ['current_emplyment','like','%'.$term.'%']
                ])->groupBy('current_emplyment')->get();

		$data_count = $data->count();

		if($data_count>0){
			foreach ($data as $row) {
				$json[] = array('id' => $row["current_emplyment"],'label' => $row["current_emplyment"]);
			}
            return json_encode($json);
		}
		
	}

    public function designationAutoComplete(Request $request){
		$term = $_REQUEST['term'];
        $data = Student::where([
                    ['status', '=', 'Active'],
                    ['current_designation','like','%'.$term.'%']
                ])->groupBy('current_designation')->get();
		$data_count = $data->count();

		if($data_count>0){
			foreach ($data as $row) {
				$json[] = array('id' => $row["current_designation"],'label' => $row["current_designation"]);
			}
            return json_encode($json);
		}		
		
	}

}
