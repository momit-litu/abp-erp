<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Center;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HasPermission;
use Auth;
use DB;

class StudentController extends Controller
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
		$data['module_name']	= "Students";
		$data['sub_module']		= "Students";

		// action permissions
        $admin_user_id  		= Auth::user()->id;
		$data['userType']		= Auth::user()->type;
        $add_action_id  		= 39; // Student entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('learner.index',$data);
    }

	//learnetr list by ajax
	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$userType 			= Auth::user()->type;
		$edit_action_id 	= 40; // learner edit
		$delete_action_id 	= 41; // learner delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	    $learnerSql = Learner::Select('id','center_id','first_name', 'last_name', 'email', 'contact_no', 'address','nid_no','user_profile_image','remarks','status')
							->with('center');
		if($userType=='Center'){
			$centerId = Auth::user()->center_id;
			$learnerSql->where('center_id',$centerId);
		}

		$learners = $learnerSql->orderBy('created_at','desc')->get();

        $return_arr = array();
        foreach($learners as $learner){
            $data['actions']	= "";
            $data['status'] 	= ($learner->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] 		= $learner->id;
			$data['first_name'] = $learner->first_name;
			$data['last_name'] 	= $learner->last_name ;
            $data['email'] 		= $learner->email;
			$data['contact_no'] = $learner->contact_no;
			$data['address'] 	= $learner->address;
			$data['center_name']= $learner->center->name;
			//dd( $learner->id;die;
			$image_path = asset('assets/images/learner');
			$data['user_profile_image'] = ($learner->user_profile_image!="" || $learner->user_profile_image!=null)?'<img height="40" width="50" src="'.$image_path.'/'.$learner->user_profile_image.'" alt="image" />':'<img height="40" width="50" src="'.$image_path.'/no-user-image.png'.'" alt="image" />';

            $data['actions']	="<button title='View' onclick='learnerView(".$learner->id.")' id='view_" . $learner->id . "' class='btn btn-xs btn-primary' ><i class='clip-zoom-in'></i></button>&nbsp;";
			if($edit_permisiion>0){
                $data['actions'] .="<button onclick='learnerEdit(".$learner->id.")' id=edit_" . $learner->id . "  class='btn btn-xs btn-green module-edit' ><i class='clip-pencil-3'></i></button>";
            }
            if ($delete_permisiion>0) {
                $data['actions'] .=" <button onclick='learnerDelete(".$learner->id.")' id='delete_" . $learner->id . "' class='btn btn-xs btn-danger' ><i class='clip-remove'></i></button>";
            }
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    public function show($id)
    {
		if($id=="") return 0;
        $learner = Learner::with('center')->findOrFail($id);
		return json_encode(array('learner'=>$learner));
    }

	public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}
		$learner = Learner::with('registrations')->findOrFail($id);
		//dd($learner);
		$is_deletable = (count($learner->registrations)==0)?1:0; // 1:deletabe, 0:not-deletable
		if(empty($learner)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No learner found"));
		}
		try {
			DB::beginTransaction();
			if($is_deletable){
				$learner->delete();
				$return['message'] = "Learner Deleted successfully";
			}
			else{
				$learner->status = 'Inactive';
				$learner->update();
				$return['message'] = "Deletation is not possible, but deactivated the learner";
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

	public function learnerAutoComplete(){
		$term = $_REQUEST['term'];

		$data = Learner::select('id', 'first_name', 'last_name', 'email')
				       ->where([
                    ['status', '=', 'Active'],
                    ['first_name','like','%'.$term.'%']
                ])
				->orwhere([
                    ['status', '=', 'Active'],
                    ['last_name','like','%'.$term.'%']
                ])
				->orwhere([
                    ['status', '=', 'Active'],
                    ['email','like','%'.$term.'%']
                ])
			->get();



		$data_count = $data->count();

		if($data_count>0){
			foreach ($data as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["first_name"]." ". $row["last_name"]." (".$row["email"].")");
			}
		}
		else {
			$json[] = array('id' => "0",'label' => "Not Found !!!");
		}
		return json_encode($json);

	}

    public function createOrEdit(Request $request)
    {
		$admin_user_id 		= Auth::user()->id;
		$userType 			= Auth::user()->type;
        $entry_permission 	= $this->PermissionHasOrNot($admin_user_id,39);
		$update_permission 	= $this->PermissionHasOrNot($admin_user_id,40);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != "" && $update_permission){

			$response_data =  $this->editLearner($request->all(), $request->input('edit_id'), $request->file('user_profile_image') );
		}
		// new entry
		else if($entry_permission && $userType=='Center'){
			$response_data =  $this->createLearner($request->all(), $request->file('user_profile_image'));
		}
		else{
			$return['response_code'] = 0;
			$return['errors'] = "You are not authorized to insert a learner";
			$response_data = json_encode($return);
		}

        return $response_data;
    }


	private function createLearner($request, $photo){
		//dd($request);
		$centerId = Auth::user()->center_id;
		//$center = Center::select('id')->where('id',$centerId)->first();
		try {
            $rule = [
                'first_name'=> 'required|string',
                'email' 	=> 'required|email',
				'contact_no'=> 'required',
				'date_of_birth'=> 'required'
			];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				$emailVerification = Learner::where('email',$request['email'])->first();
	            if(isset($emailVerification->id)){
					$return['response_code'] 	= "0";
					$return['errors'][] = $request['email']." is already exists";
					return json_encode($return);
				}

				$profileImage = "";
				$LearnerImage = $photo;
				if (isset($LearnerImage)){
					$image_name 	= time();
					$ext 			= $LearnerImage->getClientOriginalExtension();
					$image_full_name= $image_name.'.'.$ext;
					$upload_path 	= 'assets/images/learner/';
					$success		= $LearnerImage->move($upload_path,$image_full_name);
					$profileImage 	= $image_full_name;
				}

                Learner::create([
                    'first_name'=>  $request['first_name'],
                    'last_name' =>  $request['last_name'],
					'center_id'	=>  $centerId,
					'email' 	=>  $request['email'],
					'contact_no'=>  $request['contact_no'],
					'address'	=>  $request['address'],
					'nid_no' 	=>  $request['nid_no'],
					'date_of_birth'=>  $request['date_of_birth'],
					'remarks' 	=>  $request['remarks'],
					'user_profile_image' => $profileImage,
                    'status' 	=> (isset($request['status']))?'Active':'Inactive'
                ]);
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Learner saved successfully";
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

	private function editLearner($request, $id, $photo){
		//dd($request);
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}
			// if learner already is in a registration then need the hard update permission
			// only edopro admin can edit
			// $hardUpdate_permission = $this->PermissionHasOrNot($admin_user_id,42);
			$learner = Learner::findOrFail($id);

			if(empty($learner)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No learner found"));
			}

            $rule = [
                'first_name'=> 'required|string',
                'email' 	=> 'required|email',
				'contact_no'=> 'required',
				'date_of_birth'=> 'required'
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['result'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				$emailVerification = Learner::where([['email',$request['email']],['id','!=',$id]])->first();
	            if(isset($emailVerification->id)){
					$return['response_code'] 	= "0";
					$return['errors'][] = $request['email']." is already exists";
					return json_encode($return);
				}

				$learner->first_name 	= $request['first_name'];
				$learner->last_name 	= $request['last_name'];
				$learner->email 		= $request['email'];
				$learner->contact_no 	= $request['contact_no'];
				$learner->address 		= $request['address'];
				$learner->nid_no 		= $request['nid_no'];
				$learner->date_of_birth = $request['date_of_birth'];
				$learner->remarks 		= $request['remarks'];
				$learner->status 		=  (isset($request['status']))?"Active":'Inactive';

				$LearnerImage = $photo;
				if (isset($LearnerImage)){
					$image_name 	= time();
					$ext 			= $LearnerImage->getClientOriginalExtension();
					$image_full_name= $image_name.'.'.$ext;
					$upload_path 	= 'assets/images/learner/';
					$success		= $LearnerImage->move($upload_path,$image_full_name);
					$learner->user_profile_image = $image_full_name;
				}
				$learner->update();

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Learner Updated successfully";
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
