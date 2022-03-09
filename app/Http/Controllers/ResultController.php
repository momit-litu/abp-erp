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
        $return_arr         = array(); 
        $sql = "SELECT student_no, student_id, student_name,student_enrollment_id,student_status,
                GROUP_CONCAT(student_result_details) student_result_details, batch_student_id
                FROM (
                        SELECT  s.student_no as student_no, s.name AS student_name, bs.student_enrollment_id, bs.status AS student_status, s.id as student_id, bs.id as batch_student_id,
                        CONCAT(bsu.id,'@', u.unit_code, '@',ifnull(rs.name,''), '@',ifnull(bsu.score,'')) AS student_result_details
                        FROM batch_students bs 
                        left join batch_student_units bsu ON bsu.batch_student_id=bs.id
                        LEFT JOIN units u ON u.id = bsu.unit_id
                        LEFT JOIN students s ON s.id = bs.student_id
                        left join result_states rs ON rs.id = bsu.result 
                        WHERE bs.batch_id=$batchId
                        ORDER BY bs.id ASC
                )A
                GROUP BY student_name 
                ORDER BY  student_name";
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
                $tableBody .= "<td class='text-center '>".$studentResult->student_status."</td>";

                $resultInfoArr        = explode(',',$studentResult->student_result_details);
                $studentResultInfoArr = array();
                foreach($resultInfoArr as $resultInfo){
                    $singleBookArr    = explode('@',$resultInfo);
                    $studentResultId  = $singleBookArr[0];
                    $studentUnitCode  = $singleBookArr[1];
                    $studentResult    = ($singleBookArr[2]!="")?"<span class='text-success'>$singleBookArr[2]</span>":"<span class='text-danger'>NP</span>";
                    $tableBody .= "<td class='text-center'>".$studentResult."</td>";                   
                    if($once)$tableHead .=  "<th class='text-center'>".$studentUnitCode."</th>";
                }
                $once =0;
                $tableBody .= "<td class='text-center'><button title='Result Details' onclick='viewResult(".$batch_student_id.")' id='view_" . $batch_student_id. "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
                if($edit_permisiion>0){
                    $tableBody .="<button title='Edit' onclick='resultEdit(".$batch_student_id.")' id=edit_" .$batch_student_id. "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
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
                        $tableHead
                        <th width='80'></th>
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

    public function show($id)
    {
		if($id=="") return 0;	
        $result = BatchStudent::with('student','batch','batch.course','batch_student_units','batch_student_units.unit','batch_student_units.result')->findOrFail($id);
        return json_encode(array('result'=>$result));
       
    }

    public function updateResult(Request $request)
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
}
