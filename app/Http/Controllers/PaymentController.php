<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
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
use App\Traits\StudentNotification;
use App\Models\NotificationTemplate;
use App\Models\StudentRevisePayment;
use Illuminate\Support\Facades\File;
use App\Notifications\newPaymentByStudent;

class PaymentController extends Controller
{
    use HasPermission;
    use StudentNotification; 
    public $studentPayment;
	public function __construct(Request $request)
    {
        $this->studentPayment =new StudentPayment();
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }
	
    public function index()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Payments";
		$data['sub_module']		= "Payment Collections";
		
		//$data['courses'] 		=StudentPayment::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 87; // Payment entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('payment.payment',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 88; // Batch edit
		$delete_action_id 	= 89; // Batch delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	   $payments = StudentPayment::with('enrollment','enrollment.student', 'enrollment.batch','enrollment.batch.course')
							->orderBy('created_at','desc')
							->get();
		//dd($payments);	
        $return_arr = array();
        foreach($payments as $payment){
            $data['id'] 		    = $payment->id;            
			$data['student_name']   =  "<a href='javascript:void(0)' onclick='studentView(".$payment->enrollment->student->id.")' />".$payment->enrollment->student->student_no.'-'.$payment->enrollment->student->name.' ('.$payment->enrollment->student->email.")</a>"; 
            $data['course_name']    = "<a href='javascript:void(0)' onclick='batchView(".$payment->enrollment->batch->id.")' />".$payment->enrollment->batch->course->title."</a>";
            $data['batch_name']      = $payment->enrollment->batch->batch_name; 
            $data['installment']      = $payment->installment_no; 
            $data['payment_month']  = ($payment->paid_date==null)?date('M y', strToTime($payment->last_payment_date)):date('M y', strToTime($payment->paid_date)); 
            $data['paid_date']      = $payment->paid_date; 
			$data['payment_status'] = ($payment->payment_status=='Paid')?$payment->payment_status:"Due";
			$data['paid_amount']    = ($payment->payment_status =='Paid')? "<span class='text-success'>".$payment->payable_amount."</span>":"<span class='text-danger'>".$payment->payable_amount."</span>";

     
			$data['actions'] =" <button title='View' onclick='paymentView(".$payment->id.")' id='view_" . $payment->id . "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
            if($payment->payment_status=='Paid'){
                $data['actions'] .=" <button title='View' onclick='paymentInvoice(".$payment->id.")' id='view_" . $payment->id . "' class='btn btn-xs btn-warning btn-hover-shine' ><i class='lnr-license'></i></button>&nbsp;";
            }

            if($payment->payment_status=='Unpaid'){
                $data['actions'] .=" <button title='View' onclick='paymentEdit(".$payment->id.")' id='edit_" . $payment->id . "' class='btn btn-xs btn-warning btn-hover-shine' ><i class='pe-7s-cash'></i></button>&nbsp;";
                $data['actions'] .=" <button title='View' onclick='paymentSMS(".$payment->id.")' id='sms_" . $payment->id . "' class='btn btn-xs btn-success btn-hover-shine' ><i class='lnr-envelope'></i></button>&nbsp;";
                
            }
            if($edit_permisiion>0 &&  $payment->payment_status=='Paid'){
                $data['actions'] .="<button onclick='paymentEdit(".$payment->id.")' id=edit_" . $payment->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion>0 &&  $payment->payment_status=='Paid') {
                $data['actions'] .=" <button onclick='paymentDelete(".$payment->id.")' id='delete_" . $payment->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
            }
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    
    public function studentInstallmentList($id)
    {
        $studentPayments = StudentPayment::where([['student_enrollment_id', $id],['payment_status','Unpaid']])->get();
        $return_arr = array();
        foreach($studentPayments as $payment){
            $data['id'] = $payment->id;
            $data['detail'] = "Installment No. - ".$payment->installment_no. ' ('.$payment->payable_amount.")";
            $return_arr[] = $data;
        }        
        return json_encode(array('installments'=>$return_arr));
    }


    public function courseBatchList( $id){
        //$data = BatchStudent::with('batch')->get();
        $batchStudents = BatchStudent::with('batch','batch.course')
        ->where([['status', '=', 'Active'], ['student_id',$id]])
        ->get();

        $return_arr = array();
        foreach($batchStudents as $batchStudent){
            $data['id'] = $batchStudent->id;
            $data['detail'] = $batchStudent->batch->course->title. ' - '.$batchStudent->batch->batch_name;
            $return_arr[] = $data;
        }        
        return json_encode(array('courses'=>$return_arr));	
	}


    public function createOrEdit(Request $request)
    {
        $admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,87);

        $edit_id    =  $request->edit_id;
        $payment_id =  $request->installment_no;
        //dd($request->all());
        if(isset($request->request_type) && $request->request_type =='schedule'){
            if($request->input('student_enrollment_id') != "" )
                $response_data = $this->studentPayment->addSchedule($request->all());
            else
                $response_data = $this->studentPayment->editSchedule($request->all()); 
        }
        else{
            if($edit_id == "" ||  $edit_id == $payment_id){
                $response_data =  $this->studentPayment->savePayment($request->all());
            }
            else{
                $removePaymentResponse =  $this->studentPayment->removePayment($request->input('edit_id'));
                if($removePaymentResponse){
                    $response_data =  $this->studentPayment->savePayment($request->all());
                }    
            }
        }
        return $response_data;
    }


    public function show($id)
    {
		if($id=="") return 0;
        $paymentDetails = $this->studentPayment->getPaymentDetailByPaymentId($id);
        // Payment due sms = 1
        $smsBody = NotificationTemplate::find(1);
        $studentName = $paymentDetails['only_student_name'];
        $payableAmount = $paymentDetails['payable_amount'];
        $lastPaymentDate = $paymentDetails['last_payment_date'];

        $smsBodyText = str_replace(array('[student_name]', '[payment_amount]','[payment_date]'), array($studentName,$payableAmount , $lastPaymentDate), $smsBody->details);
		return json_encode(array('payment'=>$paymentDetails, 'sms_body'=>$smsBodyText));
    }

    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}	
        $response = $this->studentPayment->removePayment($id);
		if($response) {	
            $return['response_code'] 	= 1;
			$return['message'] = "Payment removed successfully";
        } 
		else{
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to delete !";
		}
        return json_encode($return);
    }

    public function scheduleIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Payment Schedules";
		$data['sub_module']		= "Payment Schedules";
		
		//$data['students'] 		=Student::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 90; // Payment entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('payment.payment-schedule',$data);
    }

    public function scheduleShow($id)
    {
		if($id=="") return 0;
        $paymentDetails = $this->studentPayment->getPaymentDetailsByStudentId($id);
		return json_encode(array('batchStudents'=>$paymentDetails));
    }

	
    public function reviseIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Payments";
		$data['sub_module']		= "Revise Requests";

		return view('payment.payment-revise');
    }

	public function reviseShowList(){
	   $revisePayments = StudentRevisePayment::with('enrollment','enrollment.student', 'enrollment.batch','enrollment.batch.course')
        ->orderBy('created_at','desc')->get();

        $return_arr = array();
        foreach($revisePayments as $payment){
            $data['id'] 		 = $payment->id;            
			$data['student_name']=  "<a href='javascript:void(0)' onclick='studentView(".$payment->enrollment->student->id.")' />".$payment->enrollment->student->student_no.'-'.$payment->enrollment->student->name.' ('.$payment->enrollment->student->email.")</a>"; 
            $data['course_name'] = "<a href='javascript:void(0)' onclick='batchView(".$payment->enrollment->batch->id.")' />".$payment->enrollment->batch->course->title.' '.$payment->enrollment->batch->batch_name."</a>";
            $data['details']    = $payment->revise_details; 
            $data['date']       = $payment->created_at; 
			$data['status']     = $payment->revise_status;

            $data['actions'] =" <button title='View' onclick='reviseEdit(".$payment->id.")' id='edit_" . $payment->id . "' class='btn btn-xs btn-primary btn-hover-shine' ><i class='lnr-pencil'></i></button>&nbsp;";
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}


    public function reviseShow($id)
    {
		if($id=="") return 0;
        $revisePayment = StudentRevisePayment::with('enrollment','enrollment.student', 'enrollment.batch','enrollment.batch.course')->where('id',$id)->first();
		return json_encode(array('revisePayment'=>$revisePayment));
    }

    
    public function reviseUpdate(Request $request)
    {
        try {
            $rule = [ 
				'edit_id' 		=> 'required',
            ];
            $validation = \Validator::make($request->all(), $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
                $revisePayment = StudentRevisePayment::findOrFail($request->edit_id);
                $revisePayment->revise_status = $request->revise_status;
                $revisePayment->save();

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Unit saved successfully";
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to save !".$e->getMessage();
			return json_encode($return);
		}
    }

    public function emailInvoice($id)
    {
       // $batchStudent = BatchStudent::with('student','batch','batch.course')->find(33);
        //$this->courseEnrollmentNotificationForAdmin($batchStudent); 
       // $this->courseEnrollmentNotificationForStudent($batchStudent); 
       
       // die;
		if($id=="") return false;
        $this->invoiceEmail($id);          
		return true;
    }

    public function emailRevisedPayment($id)
    {
		if($id=="") return false;
        $this->paymentRevisedEmail($id); 

        // $this->monthlyPaymentEmail(48);
		return true;
    }
    


    
}

