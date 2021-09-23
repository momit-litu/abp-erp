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
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use App\Models\StudentPayment;
use App\Models\BatchFeesDetail;
use Illuminate\Support\Facades\File;
use App\Traits\StudentNotification;


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
		$edit_action_id 	= 83; // Batch edit
		$delete_action_id 	= 84; // Batch delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	    $batches = Batch::with('course')->with('batch_fees')
							->orderBy('created_at','desc')
							->get();
		//dd($batches);	
        $return_arr = array();
        foreach($batches as $batch){
            $data['id'] 		= $batch->id;            
			$data['batch_name'] = $batch->batch_name; 
            $data['course_name']= "<a href='javascript:void(0)' onclick='showCourse(".$batch->course_id.")' />".$batch->course->title."</a>";
            $data['start_date'] = $batch->start_date; 
			$data['end_date']   = $batch->end_date;
			$data['student_limit'] 		    = $batch->student_limit;
			$data['total_enrolled_student'] = $batch->total_enrolled_student;

            $data['running_status'] 	= "";
            if($batch->running_status == 'Completed')
                $data['running_status'] 	= "<button class='btn btn-xs btn-primary' disabled>Completed</button>";
            else if($batch->running_status == 'Running')    
                $data['running_status'] 	= "<button class='btn btn-xs btn-success' disabled>Running</button>";
            else if($batch->running_status == 'Upcoming')    
                $data['running_status'] 	=  "<button class='btn btn-xs btn-info' disabled>Upcoming</button>";

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
        try {
            if($request['batch_id'] == "" || $request['student_id'] =="" || $request['batch_fees_id']==""){
                $return['response_code'] = "0";
                $return['errors'] = 'Validation failed';
                 return json_encode($return);
            }
            else{	
                $studentEnrollmentCheck = BatchStudent::where('batch_id',$request['batch_id'] )->where('student_id', $request['student_id'])->first();
                if($studentEnrollmentCheck){
                    $return['response_code'] = "0";
                    $return['errors'] = 'Student already enrolled in thos batch';
                     return json_encode($return);
                }

                $batchFee  = BatchFee::with('batch','installments')->findOrFail($request['batch_fees_id']);
               // dd($batchFee);
               
				$batchStudent = BatchStudent::create([
                    'batch_id' 	    =>  $request['batch_id'],
                    'student_id'	=>  $request['student_id'],
                    'batch_fees_id' =>  $request['batch_fees_id'],
                    'total_payable' =>  $batchFee->payable_amount,
                    'balance'       =>  $batchFee->payable_amount,
                ]);
                if($batchStudent){
                    $enrollment             = BatchStudent::with('batch', 'batch.course')->find($batchStudent->id);

                    $lastEnrollmentIdSQL       = BatchStudent::where('batch_id', $enrollment->batch_id)
                                                    ->where('student_enrollment_id','!=','')->orderBy('created_at', 'desc')->first();
                    $lastEnrollmentId = (!empty($lastEnrollmentIdSQL))?$lastEnrollmentIdSQL->student_enrollment_id:0;
                    $student_enrollment_id =  $enrollment->batch->course->short_name_id. $enrollment->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);

                    $enrollment->student_enrollment_id = $student_enrollment_id ;
                    $enrollment->save();

                    $batchFee->batch->total_enrolled_student = ($batchFee->batch->total_enrolled_student)+1;
                    $batchFee->batch->update();
                    foreach($batchFee->installments as $key => $installment){
                        if($key == 0) 
                            $last_payment_date= date('Y-m-d');
                        else if($key==1)                            
                            $last_payment_date  = date('Y-m-d', strtotime($batchFee->batch->start_date. ' + '.$batchFee->installment_duration.' month'));
                        else
                            $last_payment_date  = date('Y-m-d', strtotime($last_payment_date. ' + '.$batchFee->installment_duration.' month'));

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
        $is_deletable = (count($batchStudent->payments)==0)?1:0; // 1:deletabe, 0:not-deletable
        
        if(empty($batchStudent)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No record found"));
		}
		try {			
			DB::beginTransaction();
			if($is_deletable){
				StudentPayment::where('student_enrollment_id', $batchStudent->id)->delete();
				$batchStudent->delete();
                $batch = Batch::findOrFail($request['batch_id']);
                $batch->total_enrolled_student = (($batch->total_enrolled_student)-1);
                $batch->update();
                $return['total_enrolled_student'] =$batch->total_enrolled_student;
				$return['message'] = "Student removed successfully";
                $return['response_code'] = 1;		
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
            if($batchStudent->student_enrollment_id ==""){
                $lastEnrollmentIdSQL       = BatchStudent::where('id', $batchStudent->id)
                ->where('student_enrollment_id','!=','')->orderBy('created_at', 'desc')->first();
                $lastEnrollmentId = (!empty($lastEnrollmentIdSQL))?$lastEnrollmentIdSQL->student_enrollment_id:0;
                $student_enrollment_id =  $batchStudent->batch->course->short_name_id. $batchStudent->batch->batch_name. str_pad((substr($lastEnrollmentId,-3)+1),3,'0',STR_PAD_LEFT);
                $batchStudent->student_enrollment_id = $student_enrollment_id ;
            }
            $batchStudent->update();
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
                    'details' 		=>  $request['details'],
                    'running_status'=>  $request['running_status'],
                    'status'        => (isset($request['status']))?'Active':'Inactive',
                    'featured'      => (isset($request['featured']))?'Yes':'No'
                    
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
                $Batch->discounted_fees = ($request['discounted_fees'])?$request['discounted_fees']:$request['fees'];
                $Batch->fees 			= $request['fees'];
                $Batch->student_limit 	= $request['student_limit'];
                $Batch->details 		= $request['details'];
                $Batch->running_status 	= $request['running_status'];
                $Batch->status 			= (isset($request['status']))?$request['status']:'Inactive';
                $Batch->featured 		= (isset($request['featured']))?$request['featured']:'No';
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

}
