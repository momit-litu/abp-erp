<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Batch;
use App\Models\Level;
use App\Models\Course;
use App\Models\Student;
use App\Models\BatchFee;
use App\Models\BatchStudent;
use Illuminate\Http\Request;
use App\Mail\customerInvoice;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use App\Models\StudentPayment;
use App\Models\BatchFeesDetail;

use App\Models\StudentRevisePayment;
use App\Traits\StudentNotification;
use Illuminate\Support\Facades\File;
use App\Models\NotificationTemplate;
use App\Services\SMSService;
use Exception;

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
		$data['sub_module']		= "SMS";
		
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
        try {
            $rule = [ 
				'message_body' => 'required',
            ];
            $validation = \Validator::make($request->all(), $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
                $mobileNos          = array();
                $allStudents        = array();
                $selectedStudents   = array();

                // SMS for due payment only
                if($request->sms_template =='Unpaid'){
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $lastDate = Date('Y-m-d');
                    $studentStatusCondition = "";
                    $studentCondition = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 

                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
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
                                        $studentCondition
                                    ";
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
                else if($request->sms_template =='upcoming-due'){ 
                    $all_student_type = ($request->all_student_type != null)?$request->all_student_type:"";
                    $monthYear   = Date('Y-m');
                   // $toDate     = Date('Y-m').'-8';
                    $studentStatusCondition = "";
                    $studentCondition       = "";

                    if($all_student_type == 'active')
                        $studentStatusCondition = " AND s.status = 'Active' " ;                   
                    else if($all_student_type == 'inactive')
                        $studentStatusCondition = " AND s.status = 'Inactive' " ; 

                    if($request->sms_batch_id != null){
                       $studentCondition =  " AND bs.batch_id=".$request->sms_batch_id ; 
                    }
                    else if(isset($request->student_ids)){
                        $studentIds = implode(',',  $request->student_ids);
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
                else if($request->sms_template =='student'){
                    $studentSql = " SELECT s.contact_no, s.id AS student_id, NAME AS student_name, student_no
                                    FROM students s ";
                    $studentCondition = " WHERE contact_no IS NOT null ";
                    if($request->all_student_type == 'active')
                        $studentCondition .= " AND status ='Active' ";
                    else if($request->all_student_type == 'inactive')
                        $studentCondition .= " AND status ='Inactive' ";

                    if($request->all_student_type == 'Pending')
                        $studentCondition .= " AND registration_completed ='No' ";
                    else 
                        $studentCondition .= " AND registration_completed ='Yes' ";
                    
                    if($request->all_student_type == 'enrolled')
                        $studentCondition .= " AND type ='Enrolled' ";   
                    else if($request->all_student_type == 'nonenrolled')
                        $studentCondition .= " AND type ='Non-enrolled' ";  

                    if($request->sms_batch_id != null){
                            $studentSql .=  " LEFT JOIN batch_students AS bs ON bs.student_id=s.id  "; 
                            $studentCondition .= " AND bs.batch_id=".$request->sms_batch_id;  
                         }
                    else if(isset($request->student_ids)){
                        $studentIds =   implode(",",$request->student_ids);
                        $studentCondition .= " AND id in($studentIds)";  
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
                    $studentSql = " SELECT s.contact_no, s.id AS student_id, NAME AS stuudent_name, student_no
                                    FROM students s ";
                    $studentCondition = " WHERE contact_no IS NOT null ";
                    if($request->all_student_type == 'active')
                        $studentCondition .= " AND status ='Active' ";
                    else if($request->all_student_type == 'inactive')
                        $studentCondition .= " AND status ='Inactive' ";

                    if($request->all_student_type == 'Pending')
                        $studentCondition .= " AND registration_completed ='No' ";
                    else 
                        $studentCondition .= " AND registration_completed ='Yes' ";
                    
                    if($request->all_student_type == 'enrolled')
                        $studentCondition .= " AND type ='Enrolled' ";   
                    else if($request->all_student_type == 'nonenrolled')
                        $studentCondition .= " AND type ='Non-enrolled' ";  

                    if($request->sms_batch_id != null){
                            $studentSql .=  " LEFT JOIN batch_students AS bs ON bs.student_id=s.id  "; 
                            $studentCondition .= " AND bs.batch_id=".$request->sms_batch_id;  
                         }
                    else if(isset($request->student_ids)){
                        $studentIds =   implode(",",$request->student_ids);
                        $studentCondition .= " AND id in($studentIds)";  
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

                    $response = json_decode($this->SMSService->sendSMS($smsParam), true);
                    if($response['status']=="FAILED") throw new Exception($response['message']);
                    $message = "SMS sent successfully.";
                }

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = $message;
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['message'] = $e->getMessage();
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
		$otpNotificationTemplate = NotificationTemplate::where('type','sms')->where('category','otp')->first();

		$details  = $otpNotificationTemplate->details." ".$otp;
		$smsParam = array(
			'commaSeperatedReceiverNumbers'=>$mobileNo,
			'smsText'=>$details,
		);
		$response = json_decode($this->SMSService->sendSMS($smsParam), true);
		If($response['status']=="FAILED") return false;
		return true;
	}

}
