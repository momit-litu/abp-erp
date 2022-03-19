<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Exception;
use App\Models\Batch;
use App\Models\Level;
use App\Models\Course;
use App\Models\Setting;
use App\Models\Student;
use App\Models\BatchFee;
use App\Models\BatchStudent;
use App\Services\SMSService;
use Illuminate\Http\Request;
use App\Mail\customerInvoice;
use App\Traits\HasPermission;

use Illuminate\Http\Response;
use App\Models\StudentPayment;
use App\Models\BatchFeesDetail;
use App\Traits\StudentNotification;
use App\Models\NotificationTemplate;


use App\Models\StudentRevisePayment;
use Illuminate\Support\Facades\File;

class NotificationController extends Controller
{
    use HasPermission;
    use StudentNotification; 
    public $SMSService;
    public $studentPayment;
	
	public function __construct(Request $request, SMSService $SMSService)
    {
        $this->SMSService = $SMSService;
        $this->studentPayment =new StudentPayment();
        $this->page_title   = $request->route()->getName();
        $description        = \Request::route()->getAction();
        $this->page_desc    = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }
     
    public function sendSMSIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Notifications";
		$data['sub_module']		= "Bulk SMS";
		
		//$data['courses'] 		=StudentPayment::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 96; // Payment entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;
        if(!$add_permisiion )  return redirect()->back();

        $data['smsTemplates'] = NotificationTemplate::where('type','sms')->get();
        
		return view('notification.bulk-sms',$data);
    }
    
    public function sendSMS(Request $request)
    {
		//dd($request->all());
        try {
            $rule = [ 
				'message_body' => 'required',
            ];
            $validation = \Validator::make($request->all(), $rule);

            if($validation->fails()){
                $return['response_code'] 	= "0";
				$return['errors'] 			= $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
                $mobileNos          = array();
                $allStudents        = array();
                $selectedStudents   = array();

                // SMS for due payment only
                if($request->sms_template ==1){
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $lastDate = Date('Y-m-d');
                    $studentStatusCondition = "";
                    $studentCondition = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 
					else if($all_student_type == 'enrolled'){						
						if(isset($request->dont_send_dropout))
							$studentStatusCondition = " AND dropout = 'No' " ; 
						if(isset($request->dont_send_disabled))
							$studentStatusCondition = " AND s.status = 'Active' AND bs.status = 'Active' " ; 
					}

                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition =   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition =   " AND s.id IN($studentIds)" ; 
                    }
                    $paymentStudentSql = "
                                        SELECT 
                                        sp.payable_amount, sp.last_payment_date, s.contact_no, s.name
                                        from student_payments sp
                                        LEFT JOIN batch_students AS bs ON bs.id=sp.student_enrollment_id
                                        LEFT JOIN students s on s.id = bs.student_id
                                        WHERE sp.payment_status='Unpaid' and sp.last_payment_date<'$lastDate'
                                        $studentStatusCondition
                                        $studentCondition";
					
                    $studentPayments = DB::select($paymentStudentSql);
                    $responseText   = "";
                    foreach($studentPayments as $details){                  
                        $mobileNo = $details->contact_no;
                        $replacableArray = ["[student_name]","[payment_amount]","[payment_date]"];
                        $replaceByArray = [$details->name, $details->payable_amount, $details->last_payment_date];
                        $smsBody    = str_replace($replacableArray,$replaceByArray,$request->message_body);
                        $smsParam = array(
                            'commaSeperatedReceiverNumbers'=>$mobileNo,
                            'smsText'=>$smsBody,
                        );
                       
                        $response       = json_decode($this->SMSService->sendSMS($smsParam), true);
                        if($response['status']=="FAILED")
                            $responseText .= $mobileNo." - Not Sent , ";
                    }
                    $message = "SMS sent successfully. ".$responseText;
                }
                else if($request->sms_template ==3){ 
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $monthYear   = Date('Y-m');
                   // $toDate     = Date('Y-m').'-8';
                    $studentStatusCondition = "";
                    $studentCondition       = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 
					else if($all_student_type == 'enrolled'){						
						if(isset($request->dont_send_dropout))
							$studentStatusCondition = " AND dropout = 'No' " ; 
						if(isset($request->dont_send_disabled))
							$studentStatusCondition = " AND s.status = 'Active' AND bs.status = 'Active' " ; 
					}
					
                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition =   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition =   " AND s.id IN($studentIds)" ; 
                    }
                    $paymentStudentSql = "
                                        SELECT 
                                        sp.payable_amount, sp.last_payment_date, s.contact_no, s.name
                                        from student_payments sp
                                        LEFT JOIN batch_students AS bs ON bs.id=sp.student_enrollment_id
                                        LEFT JOIN students s on s.id = bs.student_id
                                        WHERE sp.payment_status='Unpaid' and DATE_FORMAT(sp.last_payment_date,'%Y-%m') ='$monthYear'
                                        $studentStatusCondition
                                        $studentCondition
                                    ";
					//echo $paymentStudentSql;die;
                    $studentPayments = DB::select($paymentStudentSql);
                    $responseText   = "";
                    if(count($studentPayments)>0){
                        foreach($studentPayments as $details){                  
                            $mobileNo = $details->contact_no;
                            $replacableArray = ["[student_name]","[month]"];
                            $replaceByArray = [$details->name, date('F')];
                            $smsBody    = str_replace($replacableArray,$replaceByArray,$request->message_body);
                            $smsParam = array(
                                'commaSeperatedReceiverNumbers'=>$mobileNo,
                                'smsText'=>$smsBody,
                            );
                            // echo $mobileNo.'---';
                            $response       = json_decode($this->SMSService->sendSMS($smsParam), true);
                            if($response['status']=="FAILED")
                                $responseText .= $mobileNo." - Not Sent , ";
                        }
                        $message = "SMS sent successfully. ".$responseText;
                    }
                    else 
                        $message = "No record found.";
                }
                else if($request->sms_template ==2){					
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";

					$studentSql = " SELECT s.contact_no, s.id AS student_id, NAME AS student_name, student_no
                                    FROM students s ";
                    $studentCondition = " WHERE contact_no IS NOT null ";
                    					
					if($all_student_type == 'active')
                        $studentCondition .= " AND status ='Active' ";
                    else if($all_student_type == 'inactive')
                        $studentCondition .= " AND status ='Inactive' ";
                    else if($all_student_type == 'Pending')
                        $studentCondition .= " AND registration_completed ='No' ";                   
                    else if($all_student_type == 'enrolled'){
						$studentCondition .= " AND type ='Enrolled' ";  						
						if(isset($request->dont_send_disabled))
							$studentCondition .= " AND s.status = 'Active' " ; 
					}					
                    else if($all_student_type == 'nonenrolled')
                        $studentCondition .= " AND type ='Non-enrolled' ";  
					else 
                        $studentCondition .= " AND registration_completed ='Yes' ";
					
                    if($request->sms_batch_id != null){
                            $studentSql .=  " LEFT JOIN batch_students AS bs ON bs.student_id=s.id  "; 
                            $studentCondition .= " AND bs.batch_id=".$request->sms_batch_id;  
                         }
                    else if(isset($request->student_ids)){
						$studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition .=   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition .=   " AND s.id IN($studentIds)" ; 	
                    } 
					
                    $studentSql .=$studentCondition;
                    $students   = DB::select($studentSql);
                    $responseText   = "";
                    foreach($students as $details){                  
                        $mobileNo = $details->contact_no;
                        $smsBody    = str_replace('[student_name]',$details->student_name,$request->message_body);
                        $smsParam = array(
                            'commaSeperatedReceiverNumbers'=>$mobileNo,
                            'smsText'=>$smsBody,
                        );

                        $response       = json_decode($this->SMSService->sendSMS($smsParam), true);
                        if($response['status']=="FAILED")
                         $responseText .= $mobileNo." - Not Sent , ";
                    }
                    $message = "SMS sent successfully. ".$responseText;
                }
                // SMS for non template SMS or generic template body to any student or bulk students
                else{ 
					$all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $studentSql = " SELECT s.contact_no, s.id AS student_id, NAME AS stuudent_name, student_no
                                    FROM students s ";
                    $studentCondition = " WHERE contact_no IS NOT null ";
                    if($all_student_type == 'active')
                        $studentCondition .= " AND status ='Active' ";
                    else if($all_student_type == 'inactive')
                        $studentCondition .= " AND status ='Inactive' ";

                    if($all_student_type == 'Pending')
                        $studentCondition .= " AND registration_completed ='No' ";
                    else 
                        $studentCondition .= " AND registration_completed ='Yes' ";
                    
                    if($all_student_type == 'enrolled'){
						$studentCondition .= " AND type ='Enrolled' ";  						
						if(isset($request->dont_send_disabled))
							$studentCondition .= " AND s.status = 'Active' " ; 
					}						
                    else if($all_student_type == 'nonenrolled')
                        $studentCondition .= " AND type ='Non-enrolled' ";  

                    if($request->sms_batch_id != null){
                            $studentSql .=  " LEFT JOIN batch_students AS bs ON bs.student_id=s.id  "; 
                            $studentCondition .= " AND bs.batch_id=".$request->sms_batch_id;  
                         }
                    else if(isset($request->student_ids)){
						$studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition .=   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition .=   " AND s.id IN($studentIds)" ; 	
                    } 
                    $studentSql .=$studentCondition;
                    $students   = DB::select($studentSql);
                    $studentsContacts =  array_column($students, 'contact_no');
                    $mobileNos  = implode(',',  $studentsContacts);
                   // $smsBody    = str_replace('[student_name]')
                    $smsParam   = array(
                        'commaSeperatedReceiverNumbers'=>$mobileNos,
                        'smsText'=>$request->message_body,
                    );
                    //dd($smsParam);
                    $response = json_decode($this->SMSService->sendSMS($smsParam), true);
                    if($response['status']=="FAILED") throw new Exception($response['message']);
                    $message = "SMS sent successfully.";
                }

				DB::commit();
				$return['response_code'] 	= 1;
				$return['message'] 			= $message;
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['message'] 			= $e->getMessage();
			return json_encode($return);
		}
    }

    public function sendPaymentDueSMS(Request $request)
    {
        try {
            $rule = [ 
				'payment_id' => 'required',
                'details' 	 => 'required',
            ];
            $validation = \Validator::make($request->all(), $rule);

            if($validation->fails()){
                $return['response_code']    = "0";
				$return['errors']           = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();                
                $paymentDetails = $this->studentPayment->getPaymentDetailByPaymentId($request->payment_id);
                
                $mobileNo = $paymentDetails['contact_no'];
                $smsParam = array(
                    'commaSeperatedReceiverNumbers'=>$mobileNo,
                    'smsText'=>$request->details,
                );
                $response = json_decode($this->SMSService->sendSMS($smsParam), true);
                If($response['status']=="FAILED") throw new Exception($response['message']);
				DB::commit();
				$return['response_code']    = 1;
				$return['message']          = "SMS sent successfully";
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] = 0;
			$return['message']       = $e->getMessage();
			return json_encode($return);
		}
    }

    // not using yet ???
    public function sendDuePaymentEmail(Request $request)
    {
        try {
            $rule = [ 
				'payment_id' => 'required',
                'details' 	 => 'required',
            ];
            $validation = \Validator::make($request->all(), $rule);

            if($validation->fails()){
                $return['response_code']    = "0";
				$return['errors']           = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
                $this->duePaymentEmail($request->payment_id); 
                
				DB::commit();
				$return['response_code']    = 1;
				$return['message']          = "Sent successfully";
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] = 0;
			$return['message']       = $e->getMessage();
			return json_encode($return);
		}
    }

	public function sendOtp($mobileNo, $otp){
		$otpNotificationTemplate = NotificationTemplate::where('type','sms')->where('category',4)->first();

		$details  = $otpNotificationTemplate->details." ".$otp;
		$smsParam = array(
			'commaSeperatedReceiverNumbers'=>$mobileNo,
			'smsText'=>$details,
		);
		$response = json_decode($this->SMSService->sendSMS($smsParam), true);
		If($response['status']=="FAILED") return false;
		return true;
	}

    // Email
    public function sendEmailIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Notifications";
		$data['sub_module']		= "Bulk Email";

        $admin_user_id  		= Auth::user()->id;
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,95 );
        $data['actions']['add_permisiion']= $add_permisiion;
        if(!$add_permisiion )  return redirect()->back();

        $settings   = Setting::first();
        $fromEmails = explode(',',$settings->admin_email);
        $data['fromEmails']		= $fromEmails;

        $data['emailTemplates'] = NotificationTemplate::where('type','email')->get();
        
		return view('notification.bulk-email',$data);
    }
    
    public function sendEmail(Request $request)
    {
        try {
            $rule = [ 
				'message_body' => 'required',
            ];
            $validation = \Validator::make($request->all(), $rule);

            if($validation->fails()){
                $return['response_code'] 	= "0";
				$return['errors'] 			= $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
                $allStudents        = array();
                $selectedStudents   = array();
                $title				= $request->title;
                $emailBody          = $request->message_body;
                $fromEmail          = $request->email_from_address;
            
                // Email for due payment only
                if($request->email_template_category ==1){
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $lastDate = Date('Y-m-d');
                    $studentStatusCondition = "";
                    $studentCondition = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 
					else if($all_student_type == 'enrolled'){						
						if(isset($request->dont_send_dropout))
							$studentStatusCondition = " AND dropout = 'No' " ; 
						if(isset($request->dont_send_disabled))
							$studentStatusCondition = " AND s.status = 'Active' AND bs.status = 'Active'"; 
					}

                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition =   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition =   " AND s.id IN($studentIds)" ; 
                    }
                    $paymentStudentSql = "
                        SELECT sp.id AS payment_id, sp.payable_amount, sp.last_payment_date as payment_date, s.email, s.name, 
                        sp.installment_no as installment_no, sp.payable_amount as payment_amount, CONCAT(c.title ,', Batch: ',b.batch_name) AS course_name
                        FROM student_payments sp
                        LEFT JOIN batch_students AS bs ON bs.id=sp.student_enrollment_id
                        LEFT JOIN students s ON s.id = bs.student_id
                        LEFT JOIN batches b ON b.id = bs.batch_id
                        LEFT JOIN courses c ON c.id = b.course_id
                        WHERE sp.payment_status='Unpaid' and sp.last_payment_date<'$lastDate'
                        $studentStatusCondition
                        $studentCondition
                    ";
					//echo $paymentStudentSql;die;
                    $studentPayments = DB::select($paymentStudentSql);
                    if(count($studentPayments)>0){
                        foreach($studentPayments as $details){                  
                            $replacableArray = ["[student_name]","[payment_date]","[payment_amount]","[course_name]","[installment_no]"];
                            $replaceByArray = [$details->name, $details->payment_date, $details->payment_amount, $details->course_name,$details->installment_no];
                            $emaiBody    = str_replace($replacableArray,$replaceByArray,$request->message_body);
                            $emails[] = array(
                                'title'		=> $title,
                                'address'	=> $details->email,
                                'body'		=> $emaiBody,
                                'from'		=> $fromEmail,
                            );
                        }
                        $response = $this->bulkEmail($emails); 				 
                        if($response['response_code']=="0") throw new Exception($response['message']);
                        $message = "Email sent successfully.";
                    }
                    else 
                        $message = "No record found.";


                    /*
                    foreach($studentPayments as $details){     
                        $this->monthlyPaymentEmail($details->payment_id);
                    }                    
                    $message = "Email sent successfully.";*/
                }
                //Upcoming due
                else if($request->email_template_category ==3){ 
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $monthYear   = Date('Y-m');
                   // $toDate     = Date('Y-m').'-8';
                    $studentStatusCondition = "";
                    $studentCondition       = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 
					else if($all_student_type == 'enrolled'){						
						if(isset($request->dont_send_dropout))
							$studentStatusCondition = " AND dropout = 'No' " ; 
						if(isset($request->dont_send_disabled))
							$studentStatusCondition = " AND s.status = 'Active' AND bs.status = 'Active' " ; 
					}
					
                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition =   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition =   " AND s.id IN($studentIds)" ; 
                    }
                    $paymentStudentSql = "
                        SELECT sp.id AS payment_id, sp.payable_amount, sp.last_payment_date, s.email, s.name, 
                        sp.installment_no as installment_no, sp.payable_amount as payment_amount, MONTHNAME(CURRENT_DATE()) AS month, CONCAT(c.title ,', Batch: ',b.batch_name) AS course_name
                        FROM student_payments sp
                        LEFT JOIN batch_students AS bs ON bs.id=sp.student_enrollment_id
                        LEFT JOIN students s ON s.id = bs.student_id
                        LEFT JOIN batches b ON b.id = bs.batch_id
                        LEFT JOIN courses c ON c.id = b.course_id
                        WHERE sp.payment_status='Unpaid' and DATE_FORMAT(sp.last_payment_date,'%Y-%m') ='$monthYear'
                        $studentStatusCondition
                        $studentCondition
                    ";

                    $studentPayments = DB::select($paymentStudentSql);
                    if(count($studentPayments)>0){
                        foreach($studentPayments as $details){                  
                            $replacableArray = ["[student_name]","[month]","[payment_amount]","[course_name]","[installment_no]"];
                            $replaceByArray = [$details->name, $details->month, $details->payment_amount, $details->course_name,$details->installment_no];
                            $emaiBody    = str_replace($replacableArray,$replaceByArray,$request->message_body);
                            $emails[] = array(
                                'title'		=> $title,
                                'address'	=> $details->email,
                                'body'		=> $emaiBody,
                                'from'		=> $fromEmail,
                            );
                        }
                        $response = $this->bulkEmail($emails); 				 
                        if($response['response_code']=="0") throw new Exception($response['message']);
                        $message = "Email sent successfully.";
                    }
                    else 
                        $message = "No record found.";
                }
                // student type
                else if($request->email_template_category ==2){
                    $studentSql = " SELECT s.email, s.id AS student_id, NAME AS student_name,       student_no  FROM students s ";
                    $studentCondition = " WHERE email IS NOT null ";
                    
					if($request->all_student_type == 'active')
                        $studentCondition .= " AND status ='Active' ";
                    else if($request->all_student_type == 'inactive')
                        $studentCondition .= " AND status ='Inactive' ";
		
                    if($request->all_student_type == 'Pending')
                        $studentCondition .= " AND registration_completed ='No' ";
                    else 
                        $studentCondition .= " AND registration_completed ='Yes' ";
                    
                    if($request->all_student_type == 'enrolled'){
						$studentCondition .= " AND type ='Enrolled' ";  						
						if(isset($request->dont_send_disabled))
							$studentCondition .= " AND s.status = 'Active' " ; 
					}					
                    else if($request->all_student_type == 'nonenrolled')
                        $studentCondition .= " AND type ='Non-enrolled' ";  

                    if($request->sms_batch_id != null){
                            $studentSql .=  " LEFT JOIN batch_students AS bs ON bs.student_id=s.id  "; 
                            $studentCondition .= " AND bs.batch_id=".$request->sms_batch_id;  
                         }
                    else if(isset($request->student_ids)){
						$studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition .=   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition .=   " AND s.id IN($studentIds)" ; 	
                    } 
                    $studentSql .=$studentCondition;
                    $students   = DB::select($studentSql);
                    $responseText   = "";
                    foreach($students as $details){            
                        $emaiBody    = str_replace('[student_name]',$details->student_name,$request->message_body);
                        $emails[] = array(
                            'title'		=> $title,
                            'address'	=> $details->email,
                            'body'		=> $emaiBody,
                            'from'		=> $fromEmail,
                        );
                    }
                    $response = $this->bulkEmail($emails); 				 
                    if($response['response_code']=="0") throw new Exception($response['message']);
                    $message = "Email sent successfully.";
                }
                 // Email for welcome 
                if($request->email_template_category ==5){
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $lastDate = Date('Y-m-d');
                    $studentStatusCondition = "";
                    $studentCondition = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 
					else if($all_student_type == 'enrolled'){						
						if(isset($request->dont_send_dropout))
							$studentStatusCondition = " AND dropout = 'No' " ; 
						if(isset($request->dont_send_disabled))
							$studentStatusCondition = " AND s.status = 'Active' AND bs.status = 'Active'"; 
					}

                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition =   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition =   " AND s.id IN($studentIds)" ; 
                    }
                    $batchStudentSql = "
                        SELECT bs.id as b_student_id,  s.email, s.name, CONCAT(c.title ,', Batch: ',b.batch_name) AS course_name
                        FROM batch_students bs
                        LEFT JOIN students s ON s.id = bs.student_id
                        LEFT JOIN batches b ON b.id = bs.batch_id
                        LEFT JOIN courses c ON c.id = b.course_id
                        WHERE bs.welcome_email ='Not-sent' AND bs.`status`='Active' 
                        $studentStatusCondition
                        $studentCondition
                    ";
                    $batchStudents = DB::select($batchStudentSql);
                    if(count($batchStudents)>0){
                        foreach($batchStudents as $details){                  
                            $replacableArray = ["[student_name]","[course_name]"];
                            $replaceByArray = [$details->name,  $details->course_name];
                            $emaiBody    = str_replace($replacableArray,$replaceByArray,$request->message_body);
                            $emails[] = array(
                                'bStudentId'=>$details->b_student_id,
                                'title'		=> $title,
                                'address'	=> $details->email,
                                'body'		=> $emaiBody,
                                'from'		=> $fromEmail,
                            );
                        }
                        $response = $this->bulkEmail($emails); 				 
                        if($response['response_code']=="0") throw new Exception($response['message']);
                        foreach($emails as $email){
                            $batchStudent = BatchStudent::find($email['bStudentId']);
                            $batchStudent->welcome_email = 'Sent';
                            $batchStudent->save();
                        }
                        $message = "Email sent successfully.";
                    }
                    else 
                        $message = "No record found.";
                }
                // Email for non template SMS or generic template body to any student or bulk students
                else{
                     
                    $studentSql = " SELECT s.email, s.id AS student_id, NAME AS student_name, student_no
                                    FROM students s ";
                    $studentCondition = " WHERE email IS NOT null ";
                    if($request->all_student_type == 'active')
                        $studentCondition .= " AND status ='Active' ";
                    else if($request->all_student_type == 'inactive')
                        $studentCondition .= " AND status ='Inactive' ";

                    if($request->all_student_type == 'Pending')
                        $studentCondition .= " AND registration_completed ='No' ";
                    else 
                        $studentCondition .= " AND registration_completed ='Yes' ";
                    
                    if($request->all_student_type == 'enrolled'){
						$studentCondition .= " AND type ='Enrolled' ";  						
						if(isset($request->dont_send_disabled))
							$studentCondition .= " AND s.status = 'Active' " ; 
					}						
                    else if($request->all_student_type == 'nonenrolled')
                        $studentCondition .= " AND type ='Non-enrolled' ";  

                    if($request->sms_batch_id != null){
                            $studentSql .=  " LEFT JOIN batch_students AS bs ON bs.student_id=s.id  "; 
                            $studentCondition .= " AND bs.batch_id=".$request->sms_batch_id;  
                         }
                    else if(isset($request->student_ids)){
						$studentIds = implode(',',  $request->student_ids);
						if(isset($request->dont_send_selective))
							$studentCondition .=   " AND s.id NOT IN($studentIds)" ; 
						else
							$studentCondition .=   " AND s.id IN($studentIds)" ; 	
                    } 
                    $studentSql .=$studentCondition;
                    $students   = DB::select($studentSql);
					
					foreach($students as $student){
                        if($student->email!=""){
                            
                            $emailBody    = str_replace('[student_name]',$student->student_name,$emailBody); 
                            //echo $emaiBody;die;                       
                            $emails[] = array(
                                'title'		=> $title,
                                'address'	=> $student->email,
                                'body'		=> $emailBody,
                                'from'		=> $fromEmail,
                            );
                        }
					}

					$response = $this->bulkEmail($emails); 				 
                    if($response['response_code']=="0") throw new Exception($response['message']);
                    $message = "Email sent successfully.";
                }

				DB::commit();
				$return['response_code'] 	= 1;
				$return['message'] 			= $message;
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['message'] 			= $e->getMessage();
			return json_encode($return);
		}
    }



}
