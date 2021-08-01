<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Validator;
use \App\Models\User;
use App\Models\Batch;
use \App\Models\Course;
use \App\Models\Student;
use App\Models\UserGroup;
use App\Models\WebAction;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use \App\Models\StudentCourse;
use App\Models\UserGroupMember;

use App\Traits\PortalHelperModel;
use App\Models\UserGroupPermission;



class StudentPortalController extends Controller
{
    use HasPermission;
    use PortalHelperModel;
    public function __construct(Request $request)
    {

        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
	}

	public function index()
    {
        $page_title = $this->page_title;
		$data['module_name']= "Dashboard";
		$data['sub_module']	= "";
		$data['studentName']	= "";

		$user_id 		= Auth::user()->id;
		$userType 		= Auth::user()->type;

		$studentId 		= Auth::user()->student_id;
        $student	  	= Student::find($studentId);
        $data['student']=$student;

    
        //get featured course list
        $featuredBatcheResponse = $this->courseList(1,5, 'Featured');
        $data['featured_batches_bg_color'] = ['bg-ripe-malin','bg-premium-dark','bg-sunny-morning','bg-plum-plate','bg-grow-early'];

        $data['featured_batches'] = $featuredBatcheResponse['batches'];

        //get ongoind course list
        $runningBatcheResponse = $this->courseList(1,4, 'Running');
        $data['running_batches'] = $runningBatcheResponse['batches'];

        //get upcomiong course list
        $upcomingBatcheResponse = $this->courseList(1,4, 'Upcoming');
        $data['upcoming_batches'] = $upcomingBatcheResponse['batches'];

        // get total active student
        //total cirtified students
        // total teachers will come from settings

        //dd($data);
        return view('student-portal.dashboard', array('page_title'=>$page_title, 'data'=>$data,'student'=>$student));
    }


    public function courseDetails($id)
    {
        $page_title = $this->page_title;
		$data['module_name']= "Dashboard";
		$data['sub_module']	= "";
		$data['studentName']	= "";
		$user_id 		= Auth::user()->id;
		$userType 		= Auth::user()->type;

		$studentId 		= Auth::user()->student_id;
        $student	  	= Student::find($studentId);
        
        
        $data['student']=$student;
        $batchDetails   = $this->courseDetailsByBatchId($id);
        
        return view('student-portal.course-details', array('page_title'=>$page_title, 'data'=>$data,'student'=>$student, 'batch'=>$batchDetails));
    }

}
