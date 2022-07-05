<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Batch;
use App\Models\Level;
use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\NotificationTemplate;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;


class TemplateController extends Controller
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
		$data['module_name']	= "Notifications";
		$data['sub_module']		= "Template";
		
		$data['categories'] 		= TemplateCategory::all();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 117; 
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('notification.template',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 117; 
		$delete_action_id 	= 117; 
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

		$templates = NotificationTemplate::with('tempCategory')->where('status','Active')->get();		
		//dd($templates);
        $return_arr = array();
        foreach($templates as $template){
            $data['status'] 	=($template->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] 		= $template->id;			
            $data['title'] 		= $template->title;
			$data['details'] 	= $template->details; 
			$data['type'] 		= $template->type;
			$data['category']	= $template->tempCategory->category_name;
			
			$data['actions'] =" <button title='View' onclick='templateView(".$template->id.")' id='view_" . $template->id . "' class='btn btn-xs btn-info btn-hover-shine' ><i class='lnr-eye'></i></button>&nbsp;";
		    if($edit_permisiion>0){
                $data['actions'] .="<button title='Edit' onclick='templateEdit(".$template->id.")' id=edit_" . $template->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion>0) {
                $data['actions'] .=" <button title='Delete' onclick='templateDelete(".$template->id.")' id='delete_" . $template->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
            }

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

	
	public function getPlaceholders($id)
    {	
        $templateCategory = TemplateCategory::find($id);
		return json_encode(array('placeholders'=>$templateCategory->placeholders));
    }

	
    public function createOrEdit(Request $request)
    {
		$admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,117);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data =  $this->editTemplate($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data =  $this->createTemplate($request->all());
		}
        return $response_data;
    }

    public function show($id)
    {
		if($id=="") return 0;		
        $template = NotificationTemplate::with('tempCategory')->findOrFail($id);
		return json_encode(array('template'=>$template));
    }

    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$course = Course::with('batches')->findOrFail($id);
		$is_deletable = (count($course->batches)==0)?1:0; // 1:deletabe, 0:not-deletable
		if(empty($course)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Course found"));
		}
		try {			
			DB::beginTransaction();
			if($is_deletable){
				CourseUnit::where('course_id', $course->id)->delete();
				$course->delete();
				$return['message'] = "Course Deleted successfully";
			}
			else{
				$course->status = 'Inactive';
				$course->update();
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
	
	private function createTemplate($request){
		try {
            $rule = [
                'title' 		=> 'required', 
				'template_type' => 'required',
			//	'details' 		=> 'required',
				'category' 		=> 'required',
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code']= "0";
				$return['errors'] 		= $validation->errors();
				return json_encode($return);
            }
            else{
				//dd($request);
				DB::beginTransaction();
                $notificationTemplate = NotificationTemplate::create([
					'title'				=>  $request['title'],
					'type'				=>  $request['template_type'],
                    'details' 			=>  ($request['template_type']=='Email')?$request['email_details']:$request['sms_details'],
					'category' 			=>  $request['category'],					
                    'status' 			=> (isset($request['status']))?'Active':'Inactive'
                ]);
				DB::commit();
				$return['response_code']= 1;
				$return['message'] 		= "Notification template saved successfully";
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

	private function editTemplate($request, $id){
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$notificationTemplate = NotificationTemplate::findOrFail($id);
			if(empty($notificationTemplate)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Template found"));
			}

            $rule = [
                'title' 		=> 'required', 
				'template_type'	=> 'required',
				//'details' 		=> 'required',
				'category' 		=> 'required',
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code']= "0";
				$return['errors'] 		= $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				$notificationTemplate->details 		=($request['template_type']=='Email')?$request['email_details']:$request['sms_details'];
				$notificationTemplate->type			= $request['template_type'];
				$notificationTemplate->title 		= $request['title'];
				$notificationTemplate->category 	= $request['category'];
				$notificationTemplate->status 		= (isset($request['status']))?$request['status']:'Inactive';
				$notificationTemplate->update();
				
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Notification Template Updated successfully";
				return json_encode($return);
            }
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code']= 0;
			$return['errors'] 		= "Failed to update !".$e->getMessage();
			return json_encode($return);
		}
	}
}
