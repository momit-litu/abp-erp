<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Batch;
use App\Models\Level;
use App\Models\Course;
use App\Models\Setting;
use App\Models\Student;
use App\Models\BatchFee;
use App\Models\StudentBook;
use App\Models\BatchStudent;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use App\Models\StudentPayment;
use App\Models\BatchFeesDetail;
use App\Models\BatchStudentUnit;
use App\Traits\StudentNotification;
use Illuminate\Support\Facades\File;


class BatchController extends Controller
{
    use HasPermission;
    use StudentNotification;
	public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }
	
    public function index()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Batchs";
		$data['sub_module']		= "Batches";
		
		$data['courses'] 		=Batch::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 82; // Batch entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('batch.index',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,83);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,84);
        $draft_permisiion 	= $this->PermissionHasOrNot($admin_user_id,114);

	    $batchesQuery   = Batch::with('course','students')->with('batch_fees');

        if(!$draft_permisiion)
        $batchesQuery->where('draft','No');
        
        $batches        = $batchesQuery->orderBy('created_at','desc')->get();
        $return_arr     = array();

        foreach($batches as $batch){
            $total_pending_student =  $batch->students->filter(function ($item) {   
                if($item->getOriginal()['pivot_status'] =='Inactive'){
                   return 1;
                }
                   
            })->count();
           // echo $total_pending_student; die;
            $data['id'] 		= $batch->id;            
			$data['batch_name'] = $batch->batch_name; 
            $data['course_name']= "<a href='javascript:void(0)' onclick='showCourse(".$batch->course_id.")' />".$batch->course->title."</a>";
            $data['start_date'] = $batch->start_date; 
			$data['end_date']   = $batch->end_date;
			$data['student_limit'] 		    = $batch->student_limit;
			$data['total_enrolled_student'] = $batch->total_enrolled_student;
            $data['total_pending_student']  = $total_pending_student;
            

            $data['running_status'] 	= "";
            if($batch->running_status == 'Completed')
                $data['running_status'] 	= "<button class='btn btn-xs btn-primary' disabled>Completed</button>";
            else if($batch->running_status == 'Running')    
                $data['running_status'] 	= "<button class='btn btn-xs btn-success' disabled>Running</button>";
            else if($batch->running_status == 'Upcoming')    
                $data['running_status'] 	=  "<button class='btn btn-xs btn-info' disabled>Upcoming</button>";
            
            $data['status']   = ($batch->status=='Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
			$data['actions'] =" <button title='View' onclick='batchView(".$batch->id.")' id='view_" . $batch->id . "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
            $data['actions'] .=" <button title='Students' onclick='batchStudents(".$batch->id.")' id='view_" . $batch->id . "' class='btn btn-xs btn-warning btn-hover-shine' ><i class='lnr-users'></i></button>&nbsp;";
		   if($edit_permisiion>0){
                $data['actions'] .="<button title='Edit' onclick='batchEdit(".$batch->id.")' id=edit_" . $batch->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion>0) {
                $data['actions'] .=" <button title='Delete' onclick='batchDelete(".$batch->id.")' id='delete_" . $batch->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
            }

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    public function createOrEdit(Request $request)
    {
       // dd($request->all());
		$admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,22);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data =  $this->editBatch($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data =  $this->createBatch($request->all());
		}
        return $response_data;
    }

    public function show($id)
    {
		if($id=="") return 0;		
        $batch = Batch::with('course', 'batch_fees','batch_fees.installments')->findOrFail($id);
		return json_encode(array('batch'=>$batch));
    }

    public function studentShow($id)
    {
		if($id=="") return 0;		
        $batch = Batch::with('course', 'batch_fees','batch_fees.installments','students')->findOrFail($id);
        //dd($Batch->students);
		return json_encode(array('batch'=>$batch));
    }

    public function enrollStudent(Request $request)
    {
        try 
        {
            DB::beginTransaction();
            if($request['batch_id'] == "" || $request['student_id'] =="" || $request['batch_fees_id']==""){
                $return['response_code'] = "0";
                $return['errors'] = 'Validation failed';
                 return json_encode($return);
            }
            else{	
                $studentEnrollmentCheck = BatchStudent::where('batch_id',$request['batch_id'] )->where('student_id', $request['student_id'])->first();
                if($studentEnrollmentCheck){
                    $return['response_code'] = "0";
                    $return['errors'] = 'Student already enrolled in this batch';
                     return json_encode($return);
                }

                $batchFee  = BatchFee::with('batch','installments')->findOrFail($request['batch_fees_id']);
                
				$batchStudent = BatchStudent::create([
                    'batch_id' 	    =>  $request['batch_id'],
                    'student_id'	=>  $request['student_id'],
                    'batch_fees_id' =>  $request['batch_fees_id'],
                    'total_payable' =>  $batchFee->payable_amount,
                    'balance'       =>  $batchFee->payable_amount,
                ]);
                if($batchStudent){
                    $enrollment             = BatchStudent::with('batch', 'batch.course', 'batch.course.units','batch.books')->find($batchStudent->id);

                    $lastEnrollmentIdSQL    = DB::select("SELECT Max(SUBSTR(student_enrollment_id,-3,3)) as max_enrollmen_id FROM batch_students where student_enrollment_id != '' AND batch_id=".$request['batch_id']);

                    $lastEnrollmentId = (!is_null($lastEnrollmentIdSQL[0]->max_enrollmen_id))?$lastEnrollmentIdSQL[0]->max_enrollmen_id:0;

                    $student_enrollment_id =  $enrollment->batch->course->short_name_id. $enrollment->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);

                    $enrollment->student_enrollment_id = $student_enrollment_id ;
                    $enrollment->save();

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
                            'student_id'      =>  $request['student_id']
                        ]);  
                    }

                    $batchFee->batch->total_enrolled_student = ($batchFee->batch->total_enrolled_student)+1;
                    $batchFee->batch->update();
                    $settings = Setting::first();

                    foreach($batchFee->installments as $key => $installment){
                        if($key == 0) 
                            $last_payment_date= $batchFee->batch->start_date;
                        else if($key==1)                            
                            $last_payment_date  = date('Y-m', strtotime($batchFee->batch->start_date. ' + '.$batchFee->installment_duration.' month'))."-".$settings->bill_date;
                        else
                            $last_payment_date  = date('Y-m', strtotime($last_payment_date. ' + '.$batchFee->installment_duration.' month'))."-".$settings->bill_date;

                        $studentPayment = StudentPayment::create([
                            'student_enrollment_id' =>  $batchStudent->id,
                            'installment_no'        =>  $installment->installment_no,
                            'payable_amount'        =>  $installment->amount,
                            'last_payment_date'     =>  $last_payment_date,
                        ]); 
                    }

                }
             }				
            DB::commit();
            $this->enrollmentEmail($batchStudent->id); 
            $batchStudent = BatchStudent::with('student','batch','batch.course')->find($batchStudent->id);
            $this->courseEnrollmentNotificationForStudent($batchStudent); 

            $return['response_code'] = 1;
            $return['total_enrolled_student'] = $batchFee->batch->total_enrolled_student;
            $return['student'] = Student::findOrFail($request['student_id']);
            $return['message'] = "Batch saved successfully";
            return json_encode($return);
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to save !".$e->getMessage();
			return json_encode($return);
		}

    }
    
    public function removeStudent(Request $request)
    {
        if($request['batch_id']=="" || $request['student_id']==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}
        $batchStudent = BatchStudent::with(['payments'=>function($p){
            $p->where('paid_amount','>',0);
        }])->where([['batch_id',$request['batch_id']], ['student_id',$request['student_id']]])->first();
       
        
        if(empty($batchStudent)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No record found"));
		}
		try {			
			DB::beginTransaction();
                if(count($batchStudent->payments)==0){
                    StudentPayment::where('student_enrollment_id',$batchStudent->id)->delete();
                    $batchStudent->delete();                   
                    $return['message'] = "Deletaed successfully";
                    $return['response_code'] = 1;
                    $batch                              = Batch::find($request['batch_id']);
                    $currentTotalEnrolledStudent        = $batch->total_enrolled_student-1;
                    $batch->total_enrolled_student      = $currentTotalEnrolledStudent;
                    $batch->update();
                    $return['total_enrolled_student']   = $currentTotalEnrolledStudent;

                }
                else{
                    $batchStudent->status = 'Inactive';
                    $batchStudent->update();
                    $return['status'] = 'Inactive';
                    $return['message'] = "Deletation is not possible, but deactivated the student";
                    $return['response_code'] = 2;
                }

			DB::commit();
			return json_encode($return);
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to delete !".$e->getMessage();
			return json_encode($return);
		}
    }

    public function reAddStudent(Request $request)
    {
        if($request['batch_id']=="" || $request['student_id']==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}
        $batchStudent = BatchStudent::where([['batch_id',$request['batch_id']], ['student_id',$request['student_id']]])->first();
               
        if(empty($batchStudent)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No record found"));
		}
		try {			
			DB::beginTransaction();
			$batchStudent->status = 'Active';
            if($batchStudent->student_enrollment_id == ""){
                $lastEnrollmentIdSQL = BatchStudent::where('batch_id', $request['batch_id'])
                ->where('student_enrollment_id','!=','')->orderBy('created_at', 'desc')->first();

                $lastEnrollmentId = (!empty($lastEnrollmentIdSQL))?$lastEnrollmentIdSQL->student_enrollment_id:0;
                $student_enrollment_id =  $batchStudent->batch->course->short_name_id. $batchStudent->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);
                $batchStudent->student_enrollment_id = $student_enrollment_id ;
            }
            $batchStudent->update();

            $batch                              = Batch::find($request['batch_id']);
            $currentTotalEnrolledStudent        = $batch->total_enrolled_student+1;
            $batch->total_enrolled_student      = $currentTotalEnrolledStudent;
            $batch->update();

			DB::commit();
            $return['message'] = "Student status updated";
			$return['response_code'] = 1;
			return json_encode($return);

        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to delete !".$e->getMessage();
			return json_encode($return);
		}
    }

    public function dropoutStudent(Request $request)
    {
        if($request['batch_id']=="" || $request['student_id']==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}
        $batchStudent = BatchStudent::with('payments')->where([['batch_id',$request['batch_id']], ['student_id',$request['student_id']]])->first();
               
        if(empty($batchStudent)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No record found"));
		}
		try {			
			DB::beginTransaction();
			$batchStudent->dropout  = ($batchStudent->dropout == 'Yes')?'No':'Yes';
            $batchStudent->status   = ($batchStudent->dropout == 'Yes')?'Inactive':'Active';
            $batchStudent->update();
            if($batchStudent->dropout == 'Yes'){
                $batch                              = Batch::find($request['batch_id']);
                $currentTotalEnrolledStudent        = $batch->total_enrolled_student-1;
                $batch->total_enrolled_student      = $currentTotalEnrolledStudent;
                $batch->update();
                foreach($batchStudent->payments as $key => $payment){
                    $studentPayment = StudentPayment::find($payment->id);
                    if($studentPayment->payment_status =='Unpaid'){
                        $studentPayment->status = 'Inactive';
                        $studentPayment->save();
                    }
                }
                
            }
            else{
                $batch                              = Batch::find($request['batch_id']);
                $currentTotalEnrolledStudent        = $batch->total_enrolled_student+1;
                $batch->total_enrolled_student      = $currentTotalEnrolledStudent;
                $batch->update();
                foreach($batchStudent->payments as $key => $payment){
                    $studentPayment = StudentPayment::find($payment->id);
                    if($studentPayment->payment_status =='Unpaid'){
                        $studentPayment->status = 'Active';
                        $studentPayment->save();
                    }
                }
            }

            $message  =  ($batchStudent->dropout == 'Yes')?'Student dropout successfull':'Student dropout Cancelled';
            $responseCode  =  ($batchStudent->dropout == 'Yes')?1:2;

			DB::commit();
            $return['message'] = $message;
			$return['response_code'] = $responseCode;
			return json_encode($return);

        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to dropout !".$e->getMessage();
			return json_encode($return);
		}
    }
     
    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$Batch = Batch::with('students')->findOrFail($id);		
		if(empty($Batch)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Batch found"));
		}
        $is_deletable = (count($Batch->students)==0)?1:0; // 1:deletabe, 0:not-deletable
		try {			
			DB::beginTransaction();
			if($is_deletable){
				$batchFee = BatchFee::/*with('installments')->*/where('batch_id', $Batch->id)->first();
                $batchFee->installments()->delete();
                $batchFee->delete();
				$Batch->delete();
				$return['message'] = "Batch Deleted successfully";
			}
			else{
				$Batch->status = 'Inactive';
				$Batch->update();
				$return['message'] = "Deletation is not possible, but deactivated the Batch";
			}
			DB::commit();
			$return['response_code'] = 1;
			
			return json_encode($return);

        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to delete !".$e->getMessage();
			return json_encode($return);
		}
		
    }

    private function createBatch($request){
        $admin_user_id 		= Auth::user()->id;
		try {
            $rule = [
                'batch_name' 	=> 'required|string',
                'course_id' => 'required', 
				'start_date' 	=> 'required',
				'fees' => 'required|numeric'
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				
				DB::beginTransaction();
                $batch = Batch::create([
                    'batch_name' 	=>  $request['batch_name'],
                    'course_id'		=>  $request['course_id'],
                    'start_date' 	=>  $request['start_date'],
                    'end_date' 		=>  $request['end_date'],
                    'fees' 			=>  $request['fees'],
                    'discounted_fees'=>($request['discounted_fees'])?$request['discounted_fees']:$request['fees'],
                    'student_limit' =>  $request['student_limit'],
                    'class_schedule'=>  $request['class_schedule'],                    
                    'details' 		=>  $request['details'],
                    'running_status'=>  $request['running_status'],
                    'status'        => (isset($request['status']))?'Active':'Inactive',
                    'featured'      => (isset($request['featured']))?'Yes':'No',
                    'draft'         => (isset($request['draft']))?'Yes':'No',
                    'show_seat_limit'=> (isset($request['show_seat_limit']))?'Yes':'No' ,
                    'created_by'    => $admin_user_id
                ]);
                if($batch){               
                    // for the onetime payment plan
                    $oneTimeBatchFee = BatchFee::create([
                        'plan_name' =>  'Onetime',
                        'batch_id' 	=>  $batch->id,
                        'installment_duration' => 0,
                        'total_installment' =>  1,
                        'payable_amount' =>  ($request['discounted_fees'])?$request['discounted_fees']:$request['fees'],
                        'payment_type'  => 'Onetime'
                    ]);
                    if($oneTimeBatchFee){
                        BatchFeesDetail::create([
                            'batch_fees_id'     =>  $oneTimeBatchFee->id,
                            'installment_no'    =>  1,
                            'amount' => ($request['discounted_fees'])?$request['discounted_fees']:$request['fees']
                        ]);
                    }
                    // for the installment payment plan
                    if(isset($request['plan_name']) && !empty($request['plan_name'])){
                        foreach($request['plan_name'] as $key=>$plan_name){
                            if(!is_null($plan_name)){
                                $batchFee = BatchFee::create([
                                    'plan_name' =>  $plan_name,
                                    'batch_id' 	=>  $batch->id,
                                    'total_installment' =>  $request['total_installment'][$key],
                                    'installment_duration' =>  $request['installment_duration'][$key],
                                    'payable_amount' =>  $request['payable_amount'][$key],
                                    'payment_type'  => 'Installment'
                                ]);
                                if(isset($request['installment_no'][$key+1]) && !empty($request['installment_no'][$key+1])){
                                    foreach($request['installment_no'][$key+1] as $k=>$installment){
                                        if(!is_null($request['installment_amount'][$key+1][$k])){
                                            BatchFeesDetail::create([
                                                'batch_fees_id'     =>  $batchFee->id,
                                                'installment_no'    =>  $installment,
                                                'amount' =>  $request['installment_amount'][$key+1][$k]
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }				
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Batch saved successfully";
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

	private function editBatch($request, $id){
       // dd($request);
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$Batch = Batch::findOrFail($id);
			if(empty($Batch)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Batch found"));
			}

            $rule = [
                'batch_name' 	=> 'required|string',
                'course_id' => 'required', 
				'start_date' 	=> 'required',
				'fees' => 'required|numeric'
            ];

            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();

                $Batch->batch_name 	    = $request['batch_name'];
                $Batch->course_id 		= $request['course_id'];
                $Batch->start_date 		= $request['start_date'];
                $Batch->end_date 		= $request['end_date'];
                $Batch->class_schedule 	= $request['class_schedule'];
                $Batch->discounted_fees = ($request['discounted_fees'])?$request['discounted_fees']:$request['fees'];
                $Batch->fees 			= $request['fees'];
                $Batch->student_limit 	= $request['student_limit'];
                $Batch->details 		= $request['details'];
                $Batch->running_status 	= $request['running_status'];
                $Batch->status 			= (isset($request['status']))?$request['status']:'Inactive';
                $Batch->featured 		= (isset($request['featured']))?$request['featured']:'No';
                $Batch->show_seat_limit = (isset($request['show_seat_limit']))?$request['show_seat_limit']:'No';
                $Batch->draft 		    = (isset($request['draft']))?$request['draft']:'No';
                
                $Batch->update();

                 // for the onetime payment plan
                 $oneTimeBatchFee = BatchFee::where('batch_id',$Batch->id)->where('payment_type','Onetime')->first();
                 $oneTimeBatchFee->payable_amount = ($request['discounted_fees'])?$request['discounted_fees']:$request['fees'];
                 $oneTimeBatchFee->update();

                 $oneTimeBatchFeedetails = BatchFeesDetail::where('batch_fees_id',$oneTimeBatchFee->id)->first();
                 $oneTimeBatchFeedetails->amount = ($request['discounted_fees'])?$request['discounted_fees']:$request['fees'];
                 $oneTimeBatchFeedetails->update();

                  // for the installment payment plan
                  if(isset($request['plan_name']) && !empty($request['plan_name'])){
                    foreach($request['plan_name'] as $key=>$plan_name){
                        if(!is_null($plan_name)){
                            if(!is_null($request['plan_id'][$key])){
                                $oldBatchFee = BatchFee::where('id',$request['plan_id'][$key])->first();
                                $oldBatchFee->payable_amount        = $request['payable_amount'][$key];
                                $oldBatchFee->total_installment     = $request['total_installment'][$key];
                                $oldBatchFee->installment_duration  = $request['installment_duration'][$key];
                                $oldBatchFee->update();
                                
                                $oneTimeBatchFeedetails = BatchFeesDetail::where('batch_fees_id',$oldBatchFee->id)->delete();
                                if(isset($request['installment_no'][$key+1]) && !empty($request['installment_no'][$key+1])){
                                    foreach($request['installment_no'][$key+1] as $k=>$installment){
                                        if(!is_null($request['installment_amount'][$key+1][$k])){
                                            BatchFeesDetail::create([
                                                'batch_fees_id'     =>  $oldBatchFee->id,
                                                'installment_no'    =>  $installment,
                                                'amount' =>  $request['installment_amount'][$key+1][$k]
                                            ]);
                                        }
                                    }
                                }
                            }
                            else{
                                $batchFee = BatchFee::create([
                                    'plan_name' =>  $plan_name,
                                    'batch_id' 	=>  $Batch->id,
                                    'total_installment' =>  $request['total_installment'][$key],
                                    'installment_duration' =>  $request['installment_duration'][$key],
                                    'payable_amount' =>  $request['payable_amount'][$key],
                                    'payment_type'  => 'Installment'
                                ]);
                                if(isset($request['installment_no'][$key+1]) && !empty($request['installment_no'][$key+1])){
                                    foreach($request['installment_no'][$key+1] as $k=>$installment){
                                        BatchFeesDetail::create([
                                            'batch_fees_id'     =>  $batchFee->id,
                                            'installment_no'    =>  $installment,
                                            'amount' =>  $request['installment_amount'][$key+1][$k]
                                        ]);
                                    }
                                }
                            }                            
                        }
                    }
                }
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Batch Updated successfully";
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to update !".$e->getMessage();
			return json_encode($return);
		}
	}


    // batch transfer 
    
    
    public function getCurrentBatch($courseId, $studentId)
    {
        if($courseId && $studentId){
            $currentBatch = BatchStudent::whereHas('batch', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            })
            ->with('batch')
            ->where('student_id',$studentId)
            ->where('current_batch','Yes')
            ->first();
            if($currentBatch){
                $returnArr = [
                    'batch_student_id'  => $currentBatch->id,
                    'batch_no'          => $currentBatch->batch->batch_name
                ];
                return $returnArr;
            }
            else return false;  
        }
    }

    public function transferIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Batchs";
		$data['sub_module']		= "Batch Transfer";
		
		$data['courses'] 		=Batch::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 118; // Batch transfer entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;
		return view('batch.transfer-index',$data);
    }

	public function transferShowList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,118);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,118);

        $trasferedStudents = BatchStudent::with('batch', 'batch.course','prev_batch.batch','student')
                                ->whereNotNull('prev_batch_student_id')
                                ->where('current_batch','Yes')
                                ->orderBy('created_at','desc')
                                ->get();
        //dd($trasferedStudent);
        foreach($trasferedStudents as $trasferedStudent){
            $data['id'] 		    = $trasferedStudent->id;            
			$data['student_name']   = "<a href='javascript:void(0)' onclick='showStudent(".$trasferedStudent->student_id.")' />". $trasferedStudent->student->name."</a>";
            $data['course_name']= "<a href='javascript:void(0)' onclick='showCourse(".$trasferedStudent->batch->course_id.")' />".$trasferedStudent->batch->course->title."</a>";
            $data['from_batch_name'] = $trasferedStudent->batch->batch_name; 
            $data['to_batch_name']   = $trasferedStudent->prev_batch->batch->batch_name; 

            $data['transfer_date']   = (!is_null($trasferedStudent->transfer_date))?$trasferedStudent->transfer_date:'';   
			$data['fee']             = number_format($trasferedStudent->transfer_fee,2);
            $data['status']          =   ($trasferedStudent->status=='Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            
            $data['actions']         = " <button title='View' onclick='transferView(".$trasferedStudent->id.")' id='view_" . $trasferedStudent->id . "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    public function transferShow($id)
    {
		if($id=="") return 0;		
        $trasferedStudent = BatchStudent::with('batch', 'batch.course','prev_batch.batch','student')->find($id);

        $return['id'] 		        = $trasferedStudent->id;            
        $return['student_name']     = "<a href='javascript:void(0)' onclick='showStudent(".$trasferedStudent->student_id.")' />". $trasferedStudent->student->name."</a>";
        $return['course_name']= "<a href='javascript:void(0)' onclick='showCourse(".$trasferedStudent->batch->course_id.")' />".$trasferedStudent->batch->course->title."</a>";
        $return['from_batch_name']  = $trasferedStudent->batch->batch_name; 
        $return['to_batch_name']    = $trasferedStudent->prev_batch->batch->batch_name; 

        $return['transfer_date']    = (!is_null($trasferedStudent->transfer_date))?$trasferedStudent->transfer_date:'';   
        $return['fee']              = number_format($trasferedStudent->transfer_fee,2);
        $return['remarks']          = (!is_null($trasferedStudent->remarks))?$trasferedStudent->remarks:'';  
        $return['status']           = $trasferedStudent->status;  

        return json_encode(array('trasferedStudent'=>$return));
    }

    public function transferCreateOrEdit(Request $request)
    {
       // dd($request->all());
		$admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,118);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data =  $this->editBatchTransfer($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data =  $this->createBatchtransfer($request->all());
		}
        return $response_data;
    }

    private function createBatchtransfer($request){
        $admin_user_id 		= Auth::user()->id;
		try {
            $rule = [
                'student_id' 	=> 'required',
                'course_id'     => 'required', 
				'from_batch_id' => 'required',
				'to_batch_id'   => 'required'
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{				
				DB::beginTransaction();

                $courseId   = $request['course_id'];
                $studentId  = $request['student_id'];
                $fromBatchId= $request['from_batch_id'];
                $toBatchId  = $request['to_batch_id'];
                $transferFee= ($request['transfer_fee']!="")?$request['transfer_fee']:0;

                $currentBatch = BatchStudent::with('batch','batch_fee','payments','batch_student_units')->where('id',$fromBatchId)->first();
              
                $currentBatch->status        = 'Inactive';
                $currentBatch->current_batch = 'Transfered'; 
                $currentBatch->transfer_date = ($request['transfer_date'])?$request['transfer_date']:NULL;
                $currentBatch->save();

                // update prev batch total enrollment
                $batch                              = Batch::find($request['from_batch_id']);
                $currentTotalEnrolledStudent        = $batch->total_enrolled_student-1;
                $batch->total_enrolled_student      = $currentTotalEnrolledStudent;
                $batch->update();

				$batchStudent = BatchStudent::create([
                    'batch_id' 	    =>  $toBatchId,
                    'student_id'	=>  $studentId,
                    'batch_fees_id' =>  $currentBatch->batch_fees_id,
                    'total_payable' =>  $currentBatch->total_payable+$transferFee,
                    'total_paid'    =>  $currentBatch->total_paid,
                    'balance'       =>  $currentBatch->balance+$transferFee,
                    'prev_batch_student_id'=>$fromBatchId,
                    'remarks'       =>  $request['remarks'],
                    'transfer_fee'  =>  $transferFee,
                    'transfer_date' =>  $request['transfer_date']
                ]);
                //dd($currentBatch);
                if($batchStudent){
                    // update current  batch total enrollment
                    $batch                              = Batch::find($request['to_batch_id']);
                    $currentTotalEnrolledStudent        = $batch->total_enrolled_student-1;
                    $batch->total_enrolled_student      = $currentTotalEnrolledStudent;
                    $batch->update();

                    $enrollment             = BatchStudent::with('batch', 'batch.course', 'batch.course.units','batch.books')->find($batchStudent->id);
                   
                    $lastEnrollmentIdSQL    = DB::select("SELECT Max(SUBSTR(student_enrollment_id,-3,3)) as max_enrollmen_id FROM batch_students where student_enrollment_id != '' AND batch_id=".$request['to_batch_id']);

                    $lastEnrollmentId = (!is_null($lastEnrollmentIdSQL[0]->max_enrollmen_id))?$lastEnrollmentIdSQL[0]->max_enrollmen_id:0;

                    $student_enrollment_id =  $enrollment->batch->course->short_name_id. $enrollment->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);

                    $enrollment->student_enrollment_id = $student_enrollment_id ;
                    $enrollment->save();

                    // save payments info for new batch
                    foreach($currentBatch->payments as $key => $payment){
                        StudentPayment::create([
                            'student_enrollment_id' =>  $batchStudent->id,
                            'installment_no'        =>  $payment->installment_no,
                            'payable_amount'        =>  $payment->payable_amount,
                            'last_payment_date'     =>  $payment->last_payment_date,
                            'payment_status'        =>  $payment->payment_status,
                            'paid_type'             =>  $payment->paid_type,
                            'paid_amount'           =>  $payment->paid_amount,
                            'paid_date'             =>  $payment->paid_date,
                            'payment_refference_no' =>  $payment->payment_refference_no,
                            'invoice_no'            =>  $payment->invoice_no,
                            'details'               =>  $payment->details.' '.($payment->paid_amount>0)?" Paid against old batch":"",
                            'paid_by'               =>  $payment->paid_by,
                        ]); 
                        // update  payments info for old batch
                        $oldStudentPayment = StudentPayment::find($payment->id);
                        $oldStudentPayment->status = 'Inactive';
                        $oldStudentPayment->save();
                    }
                    // transfer fee
                    if($transferFee){
                        StudentPayment::create([
                            'student_enrollment_id' =>  $batchStudent->id,
                            'installment_no'        =>  0,
                            'payable_amount'        =>  $transferFee,
                            'last_payment_date'     =>  date('Y-m-d')
                        ]); 
                    }   
                               
                    // save into student batch units
                    foreach($currentBatch->batch_student_units as $key => $batchStudentUnitData){
                        $batchStudentUnit = BatchStudentUnit::find($batchStudentUnitData->id);
                        $batchStudentUnit->batch_student_id= $batchStudent->id;
                        $batchStudentUnit->save();
                    }

                    // save into student batch book
                    foreach($enrollment->batch->books as $book){
                        $checkExistingBook = StudentBook::where('batch_student_id',$currentBatch->id)->where('batch_book_id',$book->id)->first();

                        if(!empty($checkExistingBook)){
                            $checkExistingBook->batch_student_id =  $batchStudent->id;
                            $checkExistingBook->save();
                        }
                        else{
                            $studentBook = StudentBook::create([
                                'batch_student_id'=>  $batchStudent->id,
                                'batch_book_id'   =>  $book->id,
                                'student_id'      =>  $request['student_id']
                            ]);                            
                        }
                    }
                }  
                
                $this->batchTransferNotificationForStudent($batchStudent->id); 

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Batch saved successfully";
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

}
