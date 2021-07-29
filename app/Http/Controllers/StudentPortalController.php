<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Session;
use DB;
use \App\Models\User;
use App\Models\UserGroup;
use App\Models\UserGroupMember;
use App\Models\UserGroupPermission;
use App\Models\WebAction;
use \App\Models\Course;
use \App\Models\StudentCourse;
use \App\Models\Student;

use App\Traits\HasPermission;


class StudentPortalController extends Controller
{
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
        $student	  		= Student::find($studentId);
        $data['student']=$student;
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
        return view('student-portal.course-details', array('page_title'=>$page_title, 'data'=>$data,'student'=>$student));
    }

}
