<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Batch;
use App\Models\Level;
use App\Models\Course;
use App\Models\CourseUnit;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;


class CourseController extends Controller
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
		$data['sub_module']		= "Courses";
		
		$data['levels'] 		=Level::all();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 22; // Course entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('Course.Course',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 27; // Course edit
		$delete_action_id 	= 28; // Course delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	   $Courses = Course::with('units')->with('level')
							->orderBy('created_at','desc')
							->get();
				
        $return_arr = array();
        foreach($Courses as $Course){
			$totalGlh =0;
			foreach($Course->units as $unit){
				$totalGlh += $unit['glh'];
			}
			
            $data['status'] 	= ($Course->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] 		= $Course->id;
			$data['code'] 		= $Course->code;
            $data['title'] 		= $Course->title;
			$data['tqt'] 		= $Course->tqt;
			//$data['registration_fees'] = $Course->registration_fees;
			$data['level'] 		= $Course->level->name;
			$data['glh'] 		= $totalGlh;
			$data['noOfUnits'] 	= count($Course->units);
			
			$data['actions'] =" <button title='View' onclick='courseView(".$Course->id.")' id='view_" . $Course->id . "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
		   if($edit_permisiion>0){
                $data['actions'] .="<button onclick='courseEdit(".$Course->id.")' id=edit_" . $Course->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            }
			
			$data['actions'] 	.=" <button title='Edit' onclick='courseBatch(".$Course->id.")' id=batch" . $Course->id . " class='btn btn-xs btn-hover-shine  btn-warning' ><i class='fa pe-7s-menu'></i></button>";

            if ($delete_permisiion>0) {
                $data['actions'] .=" <button onclick='courseDelete(".$Course->id.")' id='delete_" . $Course->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
            }

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

	
	public function showBatchList($id){
	   $batches = Batch::where('course_id',$id)
							->orderBy('created_at','desc')
							->get();
		//dd($batches);		
        $return_arr = array();
        foreach($batches as $batch){
			if($batch->running_status == 'Completed')
				$data['running_status'] 	= "<button class='btn btn-xs btn-primary' disabled>Completed</button>";
			else if($batch->running_status == 'Running')    
				$data['running_status'] 	= "<button class='btn btn-xs btn-success' disabled>Running</button>";
			else if($batch->running_status == 'Upcoming')    
				$data['running_status'] 	=  "<button class='btn btn-xs btn-info' disabled>Upcoming</button>";

			$data['batch_name'] 	= $batch->batch_name;
            $data['start_date'] 	= $batch->start_date;
			$data['end_date'] 		= ($batch->end_date ==null)?"":$batch->end_date;
			$data['fees'] 			= $batch->discounted_fees;
			$data['student_limit'] 	= $batch->student_limit;
			$data['total_enrolled_student'] = $batch->total_enrolled_student;
            $return_arr[] = $data;
        }
        return json_encode(array('batches'=>$return_arr));
	}

    public function createOrEdit(Request $request)
    {
		$admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,22);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data =  $this->editCourse($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data =  $this->createCourse($request->all());
		}

        return $response_data;
    }

    public function show($id)
    {
		if($id=="") return 0;		
        $Course = Course::with('units', 'level')->findOrFail($id);
		return json_encode(array('course'=>$Course));
    }

    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$Course = Course::with('centers')->findOrFail($id);
		$is_deletable = (count($Course->centers)==0)?1:0; // 1:deletabe, 0:not-deletable
		if(empty($Course)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Course found"));
		}
		try {			
			DB::beginTransaction();
			if($is_deletable){
				CourseUnit::where('course_id', $Course->id)->delete();
				$Course->delete();
				$return['message'] = "Course Deleted successfully";
			}
			else{
				$Course->status = 'Inactive';
				$Course->update();
				$return['message'] = "Deletation is not possible, but deactivated the Course";
			}
			DB::commit();
			$return['response_code'] = 1;
			
			return json_encode($return);

        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['message'] = "Failed to delete !".$e->getMessage();
			return json_encode($return);
		}
		
    }
	
	public function CourseAutoComplete(Request $request, $showtype){
		$term = $_REQUEST['term'];
		$user = Auth::user();
		if($showtype =='Student'){			
			$studentCourses = Student::with(['Courses'=>function($c) use ($term){
				$c->where([
                    ['Courses.status', '=', 'Active'],
                    ['title','like','%'.$term.'%']
                ]);
			}])->find($user->center_id);
			$data = $studentCourses->Courses;
		}
		else{
			$data = Course::select('id', 'code', 'title')
		       ->where([
                    ['status', '=', 'Active'],
                    ['title','like','%'.$term.'%']
                ])
				->orwhere([
                    ['status', '=', 'Active'],
                    ['code','like','%'.$term.'%']
                ])
			->get();
		}
		$data_count = $data->count();

		if($data_count>0){
			foreach ($data as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["code"]." - ".$row["title"],);
			}
		}
		else {
			$json[] = array('id' => "0",'label' => "Not Found !!!");
		}
					//dd($json);
		return json_encode($json);
		
	}
	

	
	private function createCourse($request){
		try {
            $rule = [
                'code' 	=> 'required|string',
                'title' => 'required', 
				'tqt' 	=> 'required',
				'total_credit_hour' 	=> 'required',
				'registration_fees' => 'required|numeric',
				'course_profile_image' => 'mimes:jpeg,jpg,png,svg|max:5000',
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				//dd($request);
				DB::beginTransaction();
                $Course = Course::create([
                    'code' 				=>  $request['code'],
					'short_name'		=>  $request['short_name'],
                    'title' 			=>  $request['title'],
					'objective' 		=>  $request['objective'],
					'tqt' 				=>  $request['tqt'],
					'glh' 				=>  $request['glh'],
					'study_mode' 		=>  $request['study_mode'],
					'trainers' 			=>  $request['trainers'],
					'accredited_by' 	=>  $request['accredited_by'],
					'awarder_by' 		=>  $request['awarder_by'],
					'semester_no' 		=>  $request['semester_no'],
					'programme_duration'=>  $request['programme_duration'],
					'semester_details' 	=>  $request['semester_details'],
					'assessment' 		=>  $request['assessment'],
					'grading_system' 	=>  $request['grading_system'],
					'requirements' 		=>  $request['requirements'],
					'experience_required'=>  $request['experience_required'],
					'youtube_video_link'=>  $request['youtube_video_link'],
					'total_credit_hour'	=>  $request['total_credit_hour'],
					'level_id' 			=>  $request['level_id'],
					'registration_fees' =>  $request['registration_fees'],
                    'status' 			=> (isset($request['status']))?'Active':'Inactive'
                ]);
				if(isset($request['unit_ids'])){
					foreach($request['unit_ids'] as $key=>$unit_id){
						CourseUnit::create([
							'unit_id' 		=>  $unit_id,
							'course_id' 	=>  $Course->id,
							'type' 			=>  $request['type'][$key],
						]);
					}
				}				
				$photo = (isset($request['course_profile_image']) && $request['course_profile_image']!= "")?$request['course_profile_image']:"";
                if ($photo!="") {
					$ext = $photo->getClientOriginalExtension();
                    $photoFullName = $photo->getClientOriginalName().time(). '.' . $ext;
                    $upload_path = 'assets/images/courses/';
                    $success = $photo->move($upload_path, $photoFullName);
					$Course->course_profile_image = $photoFullName;
					$Course->update();
                }
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Course saved successfully";
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

	private function editCourse($request, $id){
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$Course = Course::findOrFail($id);
			if(empty($Course)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Course found"));
			}

            $rule = [
                'code' 	=> 'required|string',
                'title' => 'required', 
				'tqt' 	=> 'required',
				'total_credit_hour' 	=> 'required',				
				'registration_fees' => 'required|numeric', 
				'course_profile_image' => 'mimes:jpeg,jpg,png,svg|max:5000',		
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();

				$Course->code 				= $request['code'];
				$Course->short_name 		= $request['short_name'];
				$Course->title 				= $request['title'];
				$Course->tqt 				= $request['tqt'];
				$Course->objective 			= $request['objective'];
				$Course->glh 				= $request['glh'];
				$Course->study_mode 		= $request['study_mode'];
				$Course->trainers 			= $request['trainers'];
				$Course->accredited_by 		= $request['accredited_by'];
				$Course->awarder_by 		= $request['awarder_by'];
				$Course->semester_no 		= $request['semester_no'];
				$Course->programme_duration = $request['programme_duration'];
				$Course->semester_details 	= $request['semester_details'];
				$Course->assessment 		= $request['assessment'];
				$Course->grading_system 	= $request['grading_system'];
				$Course->requirements 		= $request['requirements'];
				$Course->experience_required= $request['experience_required'];
				$Course->youtube_video_link = $request['youtube_video_link'];
				$Course->total_credit_hour  = $request['total_credit_hour'];
				$Course->level_id 			= $request['level_id'];
				$Course->registration_fees 	= $request['registration_fees'];
				$Course->status 			= (isset($request['status']))?$request['status']:'Inactive';
				$Course->update();
				
				if(isset($request['unit_ids']) && count($request['unit_ids'])>0){
					$CourseUnit = CourseUnit::where('course_id',$Course->id )->delete();
					foreach($request['unit_ids'] as $key=>$unit_id){
						CourseUnit::create([
							'unit_id' 		=>  $unit_id,
							'course_id' 	=>  $Course->id,
							'type' 			=>  $request['type'][$key],
						]);
					}
				}

				$photo = (isset($request['course_profile_image']) && $request['course_profile_image']!= "")?$request['course_profile_image']:"";
                if ($photo != "") {
                    $old_image = $Course->course_profile_image;
                    $image_name = time();
                    $ext = $photo->getClientOriginalExtension();
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'assets/images/courses/';
                    $success = $photo->move($upload_path, $image_full_name);
                    $Course->course_profile_image = $image_full_name;
                    if(!is_null($old_image) && $Course->course_profile_image != $old_image){
                        File::delete($upload_path.$old_image); 
                    }
                }
                $Course->update();
				
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Course Updated successfully";
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
