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
                /*
                "payment_type" => null
                "all_student_type" => null
                "sms_batch_name" => null
                "sms_batch_id" => null
                "sms_student_name" => "Litu (litu@gmail1.com)"
                "student_ids" => array:2 [
                    0 => "21"
                    1 => "32"
                ]
                */
                // when selected students
                $mobileNos = "";
                if(isset($request->student_ids))
                    $mobileNos =implode(',',  $request->student_ids);

        
                echo $mobileNos;
                dd($request->all());
                //$paymentDetails = $this->studentPayment->getPaymentDetailByPaymentId($request->payment_id);
               
                $mobileNo = $paymentDetails['contact_no'];
                $smsParam = array(
                    'commaSeperatedReceiverNumbers'=>$mobileNo,
                    'smsText'=>$request->message_body,
                );
                $response = json_decode($this->SMSService->sendSMS($smsParam), true);
                If($response['isError']) throw new Exception($response['message']);
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "SMS sent successfully";
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
                If($response['isError']) throw new Exception($response['message']);
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

}
