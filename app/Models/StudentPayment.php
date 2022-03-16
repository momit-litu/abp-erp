<?php

namespace App\Models;

use App\Models\BatchStudent;
use App\Models\BatchStudentUnit;
use Illuminate\Support\Facades\DB;
use App\Traits\StudentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use StudentNotification; 
    protected $fillable= [
        'id', 'student_enrollment_id', 'installment_no','payable_amount','paid_amount', 'payment_status',  'paid_type', 'last_payment_date',  'paid_date', 'payment_refference_no', 'receive_status','details',  'attachment', 'invoice_no', 'payment_received_by','paid_by','status'
    ];

    public function enrollment(){
        return $this->hasOne('App\Models\BatchStudent','id','student_enrollment_id');
    }
    public function paidBy(){
      return $this->hasOne('App\Models\User','id','payment_received_by');
  }

    public function getPaymentDetailByPaymentId($id)
    {

        $payment = StudentPayment::with('paidBy','enrollment','enrollment.student', 'enrollment.batch','enrollment.batch.course')->where('id',$id)->orderBy('created_at','desc')->first();
        //dd($payment);
        $return_arr['id']                       =  $payment->id;
        $return_arr['student_id']               =  $payment->enrollment->student->id;
        $return_arr['student_no']               =  $payment->enrollment->student->student_no;
        $return_arr['batch_student_enrollment_id']    =   $payment->enrollment->student_enrollment_id;
        $return_arr['student_enrollment_id']    =  $payment->student_enrollment_id;        
        $return_arr['only_student_name']        =  $payment->enrollment->student->name;
        $return_arr['student_name']             =  $payment->enrollment->student->name.' ('.$payment->enrollment->student->email.')';
        $return_arr['student_email']            =  $payment->enrollment->student->email;
        $return_arr['contact_no']               =  $payment->enrollment->student->contact_no;
        $return_arr['address']                  =  (is_null($payment->enrollment->student->address))?'':$payment->enrollment->student->address;        
        $return_arr['course_id']                =  $payment->enrollment->batch->course->id;
        $return_arr['course_name']              =  $payment->enrollment->batch->course->title.' '.$payment->enrollment->batch->batch_name;
        $return_arr['batch_name']               =  $payment->enrollment->batch->batch_name;
        $return_arr['only_course_name']         =  $payment->enrollment->batch->course->title;
        $return_arr['installment_no_value']     =  $payment->id;
        $return_arr['installment_no']           =  $payment->installment_no;
        $return_arr['payable_amount']           =  $payment->payable_amount;
        $return_arr['paid_type']                =  $payment->paid_type;
        $return_arr['last_payment_date']        =  $payment->last_payment_date;
        $return_arr['receive_status']           =  $payment->receive_status; 
        $return_arr['paid_amount']              =  $payment->paid_amount;
        $return_arr['paid_date']                =  ($payment->paid_date == null)?"":$payment->paid_date;
        $return_arr['paid_by']                  =  $payment->paid_by;
        $return_arr['paid_by_name']             =  ($payment->paidBy!= null)? "Admin (".$payment->paidBy->first_name.' '.$payment->paidBy->last_name.")":"Student";
        $return_arr['details']                  =  ($payment->details == null)?"":$payment->details;
        $return_arr['payment_refference_no']    =  ($payment->payment_refference_no == null)?"":$payment->payment_refference_no; 
        $return_arr['invoice_no']               =  ($payment->invoice_no == null)?"":$payment->invoice_no; 
        $return_arr['payment_status']           =  $payment->payment_status;
        $return_arr['attachment']               =  ($payment->attachment == null)?"":$payment->attachment; ;
        return $return_arr;
    }

    public function getNextInvoiceNo(){
        $lastInvoiceNo = $this->select(\DB::raw('MAX(SUBSTRING(invoice_no, 5,6)) as invoice_no'))->first();
        $invoiceNo = (empty($lastInvoiceNo))?'INV-'.str_pad('2000',6,0, STR_PAD_LEFT):'INV-'.str_pad(($lastInvoiceNo->invoice_no+1),6,0, STR_PAD_LEFT);
        return $invoiceNo ;
    }

    public function updateStudentFees($student_enrollment_id){
        $totalPayable = $this->where('student_enrollment_id',$student_enrollment_id)->sum('payable_amount');
        $totalPaid    = $this->where('student_enrollment_id',$student_enrollment_id)->sum('paid_amount');
        $totalPaid    = floatval($totalPaid);
        $totalPayable = floatval($totalPayable);

        $batchStudent = BatchStudent::find($student_enrollment_id);
        $batchStudent->total_payable = $totalPayable;
        $batchStudent->total_paid = $totalPaid;
        $batchStudent->balance    = ($totalPayable-$totalPaid);
  
        if(($totalPayable-$totalPaid) == 0 ) {
            $unPublishedResult  =  BatchStudentUnit::where('batch_student_id',$student_enrollment_id)->whereNull('result')->first();
            if(empty($unPublishedResult))
                $batchStudent->certificate_status = 2;
        }
        $batchStudent->update();

    }

    public function removePayment($id){         	
        $studentPayment = $this->findOrFail($id);
        if(empty($studentPayment)){
          return false;
        }
        $student_batch_id = $studentPayment->student_enrollment_id;
        if($studentPayment->payment_status=='Paid'){
            if(!is_null($studentPayment->attachment)){
                $payment_file_path = 'assets/images/payment/';
                File::delete($payment_file_path.$studentPayment->attachment); 
            }
            
            $studentPayment->invoice_no     =  Null;
            $studentPayment->paid_amount    =  0;
            $studentPayment->payment_status =  'Unpaid';
            $studentPayment->paid_date      =  Null;
            $studentPayment->payment_refference_no  =  Null;
            $studentPayment->receive_status         =  'Not Received';
            $studentPayment->details                =  Null;
            $studentPayment->attachment             =  Null;
            $studentPayment->update();
        }
        else{
            $studentPayment->delete();
        }
        $this->updateStudentFees($student_batch_id);    
        return true;
    }

    public function savePayment($request){
        try {            
            if($request['installment_no']==""){
              return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
            }			
            $studentPayment = $this->with('enrollment','enrollment.student')->findOrFail($request['installment_no']);
            if(empty($studentPayment)){
              return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No payment information found"));
            }
            else if($studentPayment->payable_amount!=$request['paid_amount']){
              return json_encode(array('response_code'=>0, 'errors'=>"Payment amount must equal to payable"));
            }

            $rule = [
                'student_id'  	=> 'required|string',
                'course_name'   => 'required', 
                'installment_no'=> 'required',
                'paid_amount'   => 'required|numeric',
                'paid_date' 	  => 'required',
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            }
            else{
                DB::beginTransaction();
                $studentPayment->invoice_no     =  $this->getNextInvoiceNo();
                $studentPayment->paid_amount    =  $request['paid_amount'];
                $studentPayment->payment_status =  'Paid';
                $studentPayment->paid_date      =  $request['paid_date'];
                $studentPayment->payment_refference_no  =  $request['payment_refference_no'];
                $studentPayment->receive_status         =  $request['receive_status'];
                $studentPayment->paid_type              =  $request['paid_type'];
                
                $studentPayment->paid_by                =  'Admin';
                $studentPayment->payment_received_by    =  \Auth::user()->id;
                $studentPayment->details                =  $request['details'];

                if($studentPayment->update()){
                  $this->updateStudentFees($studentPayment->student_enrollment_id);     
                  if($studentPayment->enrollment->status == 'Inactive'){
                    $enrollment             = BatchStudent::with('batch', 'batch.course')->find($studentPayment->enrollment->id);
                    $enrollment->status     = "Active";
                    $lastEnrollmentIdSQL    = BatchStudent::where('batch_id', $enrollment->batch_id)
                                            ->where('student_enrollment_id','!=','')->orderBy('created_at', 'desc')->first();
                    $lastEnrollmentId = (!empty($lastEnrollmentIdSQL))?$lastEnrollmentIdSQL->student_enrollment_id:0;
                    $student_enrollment_id =  $enrollment->batch->course->short_name_id. $enrollment->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);

                    $enrollment->student_enrollment_id = $student_enrollment_id ;
                    $enrollment->save();
                  }
                }
                                  
                $photo = (isset($request['attachment']) && $request['attachment']!= "")?$request['attachment']:"";
                if ($photo!="") {
                    $ext = $photo->getClientOriginalExtension();
                        $photoFullName = time().$photo->getClientOriginalName();
                        $upload_path = 'assets/images/payment/';
                        $success = $photo->move($upload_path, $photoFullName);
                    $studentPayment->attachment = $photoFullName;
                    $studentPayment->update();
                }
                DB::commit();
                $payment = $this->with('enrollment','enrollment.student')->find($studentPayment->id);
                $this->studentPaymentPaidNotification($payment);
                $this->invoiceEmail($payment->id);
                $return['response_code'] = 1;
                $return['message'] = "Payment saved successfully";
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

    public function getPaymentDetailsByStudentId($student_id)
    {

      $studentPayments = BatchStudent::with('payments','revise_requests','batch','batch.course','prev_batch','prev_batch.batch')->where('student_id',$student_id)/*->where('current_batch', 'Yes')*/->orderBy('id', 'DESC')->get()->toArray();
     // dd($studentPayments);
      return $studentPayments;
    }

    
    public function addSchedule($request){
        if($request['student_enrollment_id']==""){
            return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
          }         
          try { 
                DB::beginTransaction(); 
                $maxInstallmentNo = $this->where('student_enrollment_id',$request['student_enrollment_id'])->max('installment_no');

                $schedule = StudentPayment::create([
                    'student_enrollment_id' =>  $request['student_enrollment_id'],
                    'installment_no'        =>  floatval($maxInstallmentNo)+1,
                    'payable_amount'        =>  $request['payable_amount'],
                    'last_payment_date'     =>  $request['last_payment_date'],
                ]); 
                
                $this->updateStudentFees($request['student_enrollment_id']);
                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Schedule saved successfully";
                return json_encode($return);
          } 
          catch (\Exception $e){
            DB::rollback();
            $return['response_code'] 	= 0;
            $return['errors'] = "Failed to save !". $e;
            return json_encode($return);
          }    
    }

    public function editSchedule($request){
        if($request['edit_id']==""){
            return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
          }			
          $studentPayment = $this->findOrFail($request['edit_id']);

          if(empty($studentPayment)){
            return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No payment information found"));
          }
          try { 
                DB::beginTransaction();   
                $studentPayment->payable_amount       =  $request['payable_amount'];
                $studentPayment->last_payment_date    =  $request['last_payment_date'];
                $studentPayment->update();
                $this->updateStudentFees($studentPayment->student_enrollment_id);
                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Schedule saved successfully";
                return json_encode($return);
          } 
          catch (\Exception $e){
            DB::rollback();
            $return['response_code'] 	= 0;
            $return['errors'] = "Failed to save !". $e;
            return json_encode($return);
          }    
    }
    
}
