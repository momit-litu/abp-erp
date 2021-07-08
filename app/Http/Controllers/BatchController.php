<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Level;
use App\Models\Course;
use App\Models\Batch;
use App\Models\BatchFee;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;


class BatchController extends Controller
{
    use HasPermission;
	public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }
	
    public function index()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Courses";
		$data['sub_module']		= "Batches";
		
		$data['courses'] 		=Course::where('status','Active')->get();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 82; // Course entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('batch.index',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 83; // Course edit
		$delete_action_id 	= 84; // Course delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	   $batches = Batch::with('course')->with('fees')
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
		   if($edit_permisiion>0){
                $data['actions'] .="<button onclick='batchEdit(".$batch->id.")' id=edit_" . $batch->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion>0) {
                $data['actions'] .=" <button onclick='batchDelete(".$batch->id.")' id='delete_" . $batch->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
            }

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

}
