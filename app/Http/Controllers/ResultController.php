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
use App\Models\ResultState;
use App\Models\StudentBook;
use App\Models\BatchStudent;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use App\Models\StudentPayment;
use App\Models\BatchFeesDetail;
use App\Models\BatchStudentUnit;
use App\Models\CertificateState;
use App\Models\CertificateFeedback;
use App\Traits\StudentNotification;
use Illuminate\Support\Facades\File;

use App\Exports\ResultExport;
use App\Imports\ResultImport;
use Illuminate\Support\Facades\DB as FacadesDB;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    use HasPermission;
    use StudentNotification;
	public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }
    
    
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

    public function index()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Academic";
		$data['sub_module']		= "Results";
		
		$data['courses'] 		=Batch::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,120 );
        $data['actions']['add_permisiion']= $add_permisiion;
		return view('result.result-index',$data);
    }

    public function showList($batchId)
    {        
/*        
        $allBatchStrudents = BatchStudent::with('batch.course.units')->get();
        foreach($allBatchStrudents as $allBatchStrudent){
            foreach($allBatchStrudent->batch->course->units as $unit){
                $batchStudentUnit = BatchStudentUnit::create([
                    'batch_student_id'=>  $allBatchStrudent->id,
                    'unit_id'         =>  $unit->id,
                    'created_by'      =>  Auth::user()->id
                ]);  
            }
        }
*/
        $admin_user_id 		= Auth::user()->id;
        $edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,120);  
        $sql = "SELECT student_no, student_id, student_name,student_enrollment_id,student_status,
                GROUP_CONCAT(student_result_details) student_result_details, batch_student_id, balance, result_published_status, certificate_status
                FROM (
                        SELECT  s.student_no as student_no, s.name AS student_name, bs.student_enrollment_id, bs.status AS student_status, s.id as student_id, bs.id as batch_student_id, balance, result_published_status, cs.name as certificate_status,
                        CONCAT(bsu.id,'@', u.unit_code, '@',ifnull(rs.name,''), '@',ifnull(bsu.score,'')) AS student_result_details
                        FROM batch_students bs 
                        left join batch_student_units bsu ON bsu.batch_student_id=bs.id
                        LEFT JOIN units u ON u.id = bsu.unit_id
                        LEFT JOIN students s ON s.id = bs.student_id
                        left join result_states rs ON rs.id = bsu.result 
                        left join certificate_states cs ON cs.id = bs.certificate_status
                        WHERE bs.batch_id=$batchId  AND bs.status = 'Active'
                        ORDER BY bs.id ASC
                )A
                GROUP BY student_name 
                ORDER BY  student_enrollment_id asc ";
    
        $studentResults   = DB::select($sql);
        $table  = "";
        if(count($studentResults) > 0){
            $tableHead = $tableBody = "";
            $once= 1;
            foreach ($studentResults as $studentResult) {   
                $batch_student_id =  $studentResult->batch_student_id;
                $tableBody .= "<tr role='row'>";
                $tableBody .= "<td><a href='javascript:void(0)' onclick='studentView(".$studentResult->student_id.")' />".$studentResult->student_no."</a></td>";
                $tableBody .= "<td><a href='javascript:void(0)' onclick='studentView(".$studentResult->student_id.")' />".$studentResult->student_name."</a></td>";
                $tableBody .= "<td>".$studentResult->student_enrollment_id."</td>";
                $statusHtml = ($studentResult->student_status =="Active")?"<button class='btn btn-xs btn-success' disabled >$studentResult->student_status</button>":"<button class='btn btn-xs btn btn-danger' disabled>$studentResult->student_status</button>";
               
                $paymenthHtml= ($studentResult->balance == 0)?"<button class='btn btn-xs btn-success' disabled >Paid</button>":"<button class='btn btn-xs btn btn-warning' disabled>Due</button>";
            
                $tillSDatePayment = StudentPayment::select(DB::raw('SUM(payable_amount - paid_amount) AS balance'))
                                        ->where('last_payment_date', '<=' ,Date('Y-m-d'))
                                        ->where('student_enrollment_id',$batch_student_id)
                                        ->first();
               
                $paymentTillDateHtml = ($tillSDatePayment['balance'])?"<button class='btn btn-xs btn btn-warning' disabled>Due</button>":"<button class='btn btn-xs btn-success' disabled >Paid</button>";


                $tableBody .=  "<td class='text-center '>$statusHtml</td>                                
                                <td class='text-center '>$paymenthHtml</td>
                                <td class='text-center '>$paymentTillDateHtml</td>
                                ";


                $resultInfoArr        = explode(',',$studentResult->student_result_details);
                foreach($resultInfoArr as $resultInfo){
                    $singleResultArr    = explode('@',$resultInfo);
                   // $studentResultId  = $singleResultArr[0];
                    $studentUnitCode  = $singleResultArr[1];
                    $studentResult    = ($singleResultArr[2]!="")?"<span class='text-success'>$singleResultArr[2]</span>":"<span class='text-danger'>NP</span>";
                    $tableBody .= "<td class='text-center'>".$studentResult."</td>";                   
                    if($once)$tableHead .=  "<th class='text-center'>".$studentUnitCode."</th>";
                }
                $once =0;
                $tableBody .= "<td class='text-center'><button title='Result Details' onclick='viewResult(".$batch_student_id.")' id='view_" . $batch_student_id. "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
                if($edit_permisiion>0){
                    $tableBody .="<button title='Edit' onclick='editResult(".$batch_student_id.")' id=edit_" .$batch_student_id. "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>&nbsp;";
                }
                $tableBody .= "</td></tr>";
            }
            $table = "
                <table class='table table-bordered table-hover dataTable no-footer' id='student_result_table'  style='width:100% !important' >
                <thead>
                    <tr>
                        <th width='80'>Student No.</th>
                        <th>Student Name</th>
                        <th width='100'>Enrollment Id</th>                        
                        <th width='80' class='text-center'>Status</th>                        
                        <th width='80' class='text-center'>Paymemt Status</th>
                        <th width='80' class='text-center'>Paymemt Status till date</th>
                        $tableHead
                        <th width='120'></th>
                    </tr>
                </thead>
                <tbody>
                    $tableBody
                </tbody>
            </table>
            ";
        }
        else{
            $table = '<div class="col-md-12 alert alert-danger text-center">No record found.</div>';
        }

        return $table; 
    }

    public function csvResult($batchId, $type)
    {
        $filename = 'result'.Time().'.xlsx';
        return Excel::download(new ResultExport($batchId, $type), $filename);
    }

    
    public function saveCSVResult(Request $request)
    {
        try {
            $rule = [
                'csv_result_file' => 'required|mimes:xlsx'
            ];
            $validation = \Validator::make($request->all(), $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['response_code'] = 0;
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $csv = $request->file('csv_result_file');
                if (isset($csv) && $csv!="") {
                    $ext        = $csv->getClientOriginalExtension();
                    $csv_full_name = $csv->getClientOriginalName().'_'.time() . '.' . $ext;
                    $upload_path = 'assets/images/results/';
                    $success = $csv->move($upload_path, $csv_full_name);
                    Excel::import(new ResultImport, $upload_path.$csv_full_name);
                }  
            }
            DB::commit();
            $return['response_code']    = 1;
            $return['message']          = "CSV Upload successfully";
            return json_encode($return);
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    public function show($id)
    {
		if($id=="") return 0;	
        $result = BatchStudent::with('student','batch','batch.course','batch_student_units','batch_student_units.unit','batch_student_units.result','certificate_status','batch_student_feedback','batch_student_feedback.createdBy')
        ->findOrFail($id);
        $resultStatus = ResultState::all();
        return json_encode(array('result'=>$result , 'resultStatus'=>$resultStatus));
       
    }

    public function updateResult(Request $request)
    {
       //dd($request->all());
		$admin_user_id 	  = Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,120);
		try 
        {
            DB::beginTransaction();
            if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
                $batchStudentId = $request->input('edit_id');
                $scores         = $request->input('score');
                $show           = ($request->has('show'))?$request->input('show'):'';
               
                $batchStudent   = BatchStudent::with('batch_student_units')->find($batchStudentId);
                foreach($batchStudent->batch_student_units as $unitResult){
                    if(is_numeric($scores[$unitResult->id]) || isset($show[$unitResult->id])){
                        $result = ResultState::where('heighest_mark','>=',$scores[$unitResult->id])->where('lowest_mark','<=',$scores[$unitResult->id])->first();
                        $unitResult->score   = $scores[$unitResult->id];
                        $unitResult->result  = $result->id;
                        $unitResult->show    = isset($show[$unitResult->id])?1:0;
                        $unitResult->save();
                    }
                }

                if($batchStudent->balance == 0 ) {
                    $unPublishedResult  =  BatchStudentUnit::where('batch_student_id',$batchStudentId)->whereNull('result')->first();
                    if(empty($unPublishedResult))
                        $batchStudent->certificate_status = 2;
                }
                $batchStudent->update();
            }

            DB::commit();
            $return['response_code'] = 1;
            $return['message'] = "Result saved successfully";
            return json_encode($return);
        } 
        catch (\Exception $e){
            DB::rollback();
            $return['response_code'] 	= 0;
            $return['errors'] = "Failed to save !".$e->getMessage();
            return json_encode($return);
        }
    }

    public function publishResult($id)
    {
		if($id=="") return 0;	
        $result = BatchStudent::findOrFail($id);
        $result->result_published_status = 'Published';
        $result->save();
        return true;
       
    }

    public function certificateIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Academic";
		$data['sub_module']		= "Certificates";
		
		$data['courses'] 		=Batch::where('status','Active')->get();
        $data['certificateStates'] =CertificateState::all();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,123 );
        $data['actions']['add_permisiion']= $add_permisiion;
		return view('result.certificate-index',$data);
    }

    public function certificateShowList($batchId)
    {        
        $admin_user_id 		= Auth::user()->id;
        $edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,123);     
        $return_arr         = array(); 
        $sql = "  SELECT s.student_no AS student_no, s.name AS student_name, bs.student_enrollment_id, 
                bs.status AS student_status, s.id AS student_id, bs.id AS batch_student_id, balance,
                result_published_status, certificate_status, certificate_no, 
                cs.name AS certificate_status, GROUP_CONCAT(feedback,' (', u.first_name ,' @',date_format(cf.created_at,'%Y-%m-%d'),') <br>') AS feedbacks
                FROM batch_students bs
                LEFT JOIN students s ON s.id = bs.student_id
                LEFT JOIN certificate_states cs ON cs.id = bs.certificate_status
                LEFT JOIN certificate_feedback cf ON cf.batch_student_id=bs.id
                LEFT JOIN users u ON u.id = cf.created_by
                WHERE bs.batch_id=$batchId AND bs.status = 'Active'
                GROUP BY bs.id
                ORDER BY bs.student_enrollment_id ASC";
             //   echo $sql;die;

        $studentResults   = DB::select($sql);
        $table  = "";
        if(count($studentResults) > 0){
            $tableHead = $tableBody = "";
            $once= 1;
            foreach ($studentResults as $studentResult) {   
                $batch_student_id =  $studentResult->batch_student_id;
                $tableBody .= "<tr role='row'>";
                $tableBody .= "<td><a href='javascript:void(0)' onclick='studentView(".$studentResult->student_id.")' />".$studentResult->student_no."</a></td>";
                $tableBody .= "<td><a href='javascript:void(0)' onclick='studentView(".$studentResult->student_id.")' />".$studentResult->student_name."</a></td>";
                $tableBody .= "<td>".$studentResult->student_enrollment_id."</td>";
                $statusHtml = ($studentResult->student_status =="Active")?"<button class='btn btn-xs btn-success' disabled >$studentResult->student_status</button>":"<button class='btn btn-xs btn btn-danger' disabled>$studentResult->student_status</button>";
               
                $paymenthHtml= ($studentResult->balance == 0)?"<button class='btn btn-xs btn-success' disabled >Paid</button>":"<button class='btn btn-xs btn btn-warning' disabled>Due</button>";


                $tableBody .=  "<td class='text-center '>$statusHtml</td>                                
                                <td class='text-center '>$paymenthHtml</td>
                                <td class='text-center '><button class='btn btn-xs btn-info' disabled >$studentResult->certificate_status</button></td>
                                <td class='text-center '>$studentResult->certificate_no</td>
                                <td class='text-center '>$studentResult->feedbacks</td>
                                ";
                $tableBody .= "<td class='text-center'><button title='Result Details' onclick='viewResult(".$batch_student_id.")' id='view_" . $batch_student_id. "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
                
                if($edit_permisiion>0){
                    $tableBody .="<button title='Edit' onclick='editCertificate(".$batch_student_id.")' id=edit_" .$batch_student_id. "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>&nbsp;";
                }
                $tableBody .="<button title='Add feedback' onclick='addFeedback(".$batch_student_id.")' id=add_feedback_" .$batch_student_id. "  class='btn btn-xs btn-hover-shine  btn-success' ><i class='fa fa-plus'></i></button>&nbsp;";

                $tableBody .= "</td></tr>";
            }
            $table = "
                <table class='table table-bordered table-hover dataTable no-footer' id='student_result_table'  style='width:100% !important' >
                <thead>
                    <tr>
                        <th width='80'>Student No.</th>
                        <th>Student Name</th>
                        <th width='100'>Enrollment Id</th>                        
                        <th width='80' class='text-center'>Status</th>                        
                        <th width='80' class='text-center'>Paymemt Status</th>
                        <th width='80' class='text-center'>Certificate Status</th>
                        <th width='80' class='text-center'>Certificate No.</th>
                        <th width='80' class='text-center'>Feedback</th>
                        <th width='120'></th>
                    </tr>
                </thead>
                <tbody>
                    $tableBody
                </tbody>
            </table>
            ";
        }
        else{
            $table = '<div class="col-md-12 alert alert-danger text-center">No record found.</div>';
        }
        return $table; 
    }
    
    public function updateCertificate(Request $request)
    {

       // dd($request->all());
		$admin_user_id 	  = Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,123);
		try 
        {
            DB::beginTransaction();
            if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
                $batchStudentId = $request->input('edit_id');  
                $batchStudent   = BatchStudent::with('batch_student_units')->find($batchStudentId);
                $batchStudent->certificate_no       =  $request->input('certificate_no');
                $batchStudent->certificate_status   =  $request->input('certificate_status');
                $batchStudent->save();
            }

            DB::commit();
            $return['response_code'] = 1;
            $return['message'] = "Certificate saved successfully";
            return json_encode($return);
        } 
        catch (\Exception $e){
            DB::rollback();
            $return['response_code'] 	= 0;
            $return['errors'] = "Failed to save !".$e->getMessage();
            return json_encode($return);
        }
    }

    
    public function saveFeedback(Request $request)
    {
        try {
            $rule = [
                'feedback_details' => 'required',	
                'batch_student_id' => 'required',		
            ];
            $validation = \Validator::make($request->all(), $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['response_code'] = 0;
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $data = [                   
                    'feedback'          => $request['feedback_details'],
                    'batch_student_id'  => $request['batch_student_id'],
                    'created_by'        => Auth::user()->id
                ];
                CertificateFeedback::create($data);
                
                DB::commit();
                $return['response_code']    = 1;
                $return['message']          = "Feedback saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    
}
