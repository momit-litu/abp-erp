<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Validator;
use \App\Models\User;
use \App\Models\Course;
use \App\Models\Student;
use App\Models\UserGroup;
use App\Models\WebAction;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
//use \App\Models\StudentCourse;
use App\Models\UserGroupMember;
use App\Models\BatchStudent;

use App\Models\UserGroupPermission;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
	use HasPermission;

    public function __construct(Request $request)
    {
        $this->page_title 	= $request->route()->getName();
        $description 		= \Request::route()->getAction();
        $this->page_desc 	= isset($description['desc']) ? $description['desc'] : $this->page_title;
		if($request->type != "Admin" && $request->type != "Student"){
			//not working right now
			return redirect()->route('Dashboard');
		}
	}

	public function index()
    {
        $page_title 		= $this->page_title;
		$data['module_name']= "Dashboard";
		$data['sub_module']	= "";
		$data['studentName']= "";
		$admin_user_id 		= Auth::user()->id;
		$userType 			= Auth::user()->type;

		if($userType == 'Student'){
			return  redirect('portal');
		}
		else{
			return view('admin.dashbord', array('page_title'=>$page_title, 'data'=>$data,/*'dashboardComponents'=>$dashboardComponents*/));
		}

        
    }

	public function welcome(){
		$page_title = $this->page_title;
		$data['module_name']= "Dashboard";
		$data['sub_module']	= "";
		$data['studentName']	= "";
		$admin_user_id 		= Auth::user()->id;
		$userType 			= Auth::user()->type;
        return view('welcome', $data);
	}

	//admin users management
	public function adminUserManagement(Request $request){
		$userType = $request->type;
		$data['page_title'] = $this->page_title;
		$data['module_name']= "Users";
		$data['sub_module']	= "$userType Users";
		$data['user_type']	= $userType;
		//action permissions
		$admin_user_id 		   = Auth::user()->id;
		$add_action_id 	   	   = ($request->type=='Admin')?2:35; // Admin/Center User add
		$add_permisiion 	   = $this->PermissionHasOrNot($admin_user_id,$add_action_id );

		$data['actions']['add_permisiion']= $add_permisiion;
        return view('admin.index', $data);
	}

	//admin users list
	public function ajaxAdminList(Request $request){
		$userType = 'Admin';
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= ($request->type=='Admin')?3:36; // Admin/Student User edit
		$delete_action_id 	= ($request->type=='Admin')?4:37; // Admin/Student User delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);
		/*echo User::Select('user_profile_image', 'id', DB::raw('CONCAT(first_name," ", ifnull(last_name,"")) as name'),  'email', 'status')
							->where('type','=',$userType)
							->orderBy('created_at','desc')->toSql();die;*/
		$image_path = asset('assets/images/user/admin');
		$adminUser 	= User::Select('user_profile_image', 'id', DB::raw('CONCAT(first_name," ", ifnull(last_name,"")) as name'),  'email', 'status')
							->where('type','=',$userType)
							->orderBy('created_at','desc')
							->get();
		$return_arr = array();
		foreach($adminUser as $user){
			$groups =  DB::table('user_group_members as ugm')
						->leftJoin('user_groups as ug', 'ugm.group_id', '=', 'ug.id')
						->select(DB::raw('group_concat("", ug.group_name, "") AS group_name'))
						->where('ugm.user_id', $user->id)
						->where('ugm.status', 1)
						->get();
			$user['groups_name'] = $groups[0]->group_name;

			if ($user->user_profile_image!="" || $user->user_profile_image!=null) {
				$user['user_profile_image'] = '<img height="40" width="50" src="'.$image_path.'/'.$user->user_profile_image.'" alt="image" />';
			}else{
				$user['user_profile_image'] = '<img height="40" width="50" src="'.$image_path.'/no-user-image.png'.'" alt="image" />';
			}

			if($user->status == 0){			$user['status']="<button class='btn btn-xs btn-warning' disabled>In-active</button>";}
			else if($user->status == 1){	$user['status']="<button class='btn btn-xs btn-success' disabled>Active</button>";}

			$user['actions']		=" <button title='View' onclick='admin_user_view(".$user->id.")' id='view_" . $user->id . "' class='btn btn-xs btn-info btn-hover-shine admin-user-view' ><i class='lnr-eye'></i></button>";
			if($edit_permisiion>0){
				$user['actions'] 	.=" <button title='Edit' onclick='admin_user_edit(".$user->id.")' id=edit_" . $user->id . " class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
			}
			if ($delete_permisiion > 0) {
					$user['actions'] .=" <button title='Delete' onclick='delete_admin_user(".$user->id.")' id='delete_" . $user->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
			}
			$return_arr[] = $user;
		}
		return json_encode(array('data'=>$return_arr));
	}

	//Admin User Entry And Update
	public function ajaxAdminEntry(Request $request){

		if ($request->id != ''){
			$user 		= User::find($request->id);
			$rule = [
				'first_name' 		=> 'Required|max:220',
				'contact_no' 		=> 'Required|max:11|unique:users,contact_no,'. $user->id,
				'email' 			=> 'Required|email|unique:users,email,'. $user->id,
				'user_profile_image'=> 'mimes:jpeg,jpg,png,svg',
			];
		}else{
			$rule = [
				'first_name' 		=> 'Required|max:220',
				'contact_no' 		=> 'Required|max:11|unique:users,contact_no',
				'email' 			=> 'Required|email|unique:users',
				'user_profile_image'=> 'mimes:jpeg,jpg,png,svg'
			];
		}

        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()) {
			$return['result'] = "0";
			$return['errors'] = $validation->errors();
			return json_encode($return);
        }
		else{
			//Insert
			if ($request->id == ''){
				//Email duplicate Check
	            $email_verification = User::where('email',$request->email)->first();
	            if(isset($email_verification->id)){
					$return['result'] 	= "0";
					$return['errors'][] = $request->email." is already exists";
					return json_encode($return);
				}
			}
			//update
			else{
				//Email duplicate Check
				$email_verification = User::where([['email',$request->email],['id', '!=', $request->id]])->first();
           		if(isset($email_verification->id)){
					$return['result'] 	= "0";
					$return['errors'][] = $request->email." is already exists";
					return json_encode($return);
				}
			}
			try{
				DB::beginTransaction();
				$status 	= ($request->is_active)?1:0;
				//dd($request->all());
				$data = [
					'first_name'	=> $request->first_name,
					'last_name'		=> $request->last_name,
					'contact_no'	=> $request->contact_no,
					'email'			=> $request->email,
					'status'		=> $status,
					'remarks'		=> $request->remarks,
				];
				//if admin user Image provided
				$admin_image = $request->file('user_profile_image');
				if (isset($admin_image)){
					$image_name 				= time();
					$ext 						= $admin_image->getClientOriginalExtension();
					$image_full_name 			= $image_name.'.'.$ext;
					$upload_path 				= 'assets/images/user/admin/';
					$success					= $admin_image->move($upload_path,$image_full_name);
					$data['user_profile_image'] = $image_full_name;
				}

				if ($request->id == '') {
					$password 	= ($request->password =="")?bcrypt('1234'):bcrypt($request->password);
					$data['password'] = $password;
					$response 	= User::create($data);
					$user_id 	= $response->id;

					//insert all the group and the admin user's data into user group member with value 0 (no permission)
					$user_groups = UserGroup::select('id')->where('type',1)->get();
					foreach ($user_groups as $user_group ) {
						$group_member_data 				= new UserGroupMember();
						$group_member_data->group_id	= $user_group['id'];
						$group_member_data->user_id		= $user_id;
						$group_member_data->status		= 0;
						$group_member_data->save();
					}

					$group = $request->input('group');
					// assign the user 'in selected groups and give the permission by (1)
					if ($group!="") {
						foreach ($group as $group ) {
							$group_entry =  UserGroupMember::where('group_id', $group)->where('user_id', $user_id)->update(['status'=>1]);
						}
					}
				}
				else if($request->id != ''){
					if($request->password != ""){
						$data['password'] = bcrypt($request->password);
					}

					$user 		= User::find($request->id);
					$old_image 	= $user->user_profile_image;
					if (isset($admin_image) && $old_image!="") {
						$delete_img = $upload_path.$old_image;
						unlink($delete_img);
					}
					$user->update($data);


					$group = $request->input('group');

					## First don't permission then permission
					$do_not_permit = DB::table('user_group_members')
									->where('user_id',$request->id)
									->update(['status'=>'0']);
					## Set Admin Use Group Member
					if ($group!="") {
						foreach ($group as $group ) {
							if (isset($group)) {
								$status = '1';
								$group_member_details = DB::table('user_group_members')
														->where('user_id',$request->id)
														->where('group_id',$group)
														->update(['status'=>$status]);
							}
						}
					}
				}
				DB::commit();
				$return['result'] = "1";
				return json_encode($return);
			}
			catch (\Exception $e){
				DB::rollback();
				$return['result'] 	= "0";
				$return['errors'][] = "Failed to save";
				return json_encode($return);
			}
		}
	}


	//Admin user delete
	public function adminDestroy($id){
		User::where('id',$id)->update(['status'=>0]);
		return json_encode(array(
			"deleteMessage"=>"Deleted Successful"
		));
	}

	//Admin User View
	public function adminUserView($id){
		$user 	= User::find($id);
		$groups = DB::table('user_group_members as ugm')
					->leftJoin('user_groups as ug', 'ugm.group_id', '=', 'ug.id')
					->select(DB::raw('group_concat("", ug.group_name, "") AS group_name'))
					->where('ugm.user_id', $id)
					->where('ugm.status', 1)
					->get();
		return json_encode(array(
			'user'=>$user,
			'groups'=>$groups,
		));
	}

	//Admin User Data for edit and get group
	public function adminUserEdit(Request $request, $id){
		$user_id = $id;
		$data = User::find($user_id);
		$userType = ($request->type == 'Admin')?1:2;
		$user_group_member_details = DB::table('user_groups as ug')
									->leftJoin('user_group_members as ugm','ug.id','=','ugm.group_id')
									->where('ug.type',$userType)
									->where('ugm.user_id',$user_id)
									->select('ug.id as id','ug.group_name as group_name','ugm.user_id as user_id','ugm.status as status')
									->get();
		return json_encode(array(
			"data"=>$data,
			"user_group_member_details"=>$user_group_member_details
		));
	}

	//Admin User Groups
	public function admin_user_groups(){
		$data['page_title'] = $this->page_title;
		$data['module_name']= "Settings";
		$data['sub_module']	= "Admin User Groups";
		// action permissions
        $admin_user_id  = Auth::user()->id;
        $add_action_id  = 17;
        $add_permisiion = $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

        return view('admin.admin_groups', $data);
	}

	function loadUserGroups(Request $request){
		$userType = ($request->type == 'Admin')?1:2;
		$admin_user_id  = Auth::user()->id;
		$groups 		= UserGroup::where('type',$userType)->get();

	/*	$groups = UserGroupMember::leftJoin('user_groups', 'user_groups.id', '=', 'user_group_members.group_id')
									->where('user_id',$admin_user_id)
									->select('user_groups.id', 'user_groups.group_name')
									->get();*/

		//$return_arr = array();

		return json_encode(array('data'=>$groups));
	}


	//Entry Admin User Group And App User Grou
	public function admin_groups_entry_or_update(Request $request){
		$rule = [
            'group_name' => 'Required|max:50',
        ];

        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()) {
			$return['result'] = "0";
			$return['errors'] = $validation->errors();
			return json_encode($return);
        }
		else{
			try{
				DB::beginTransaction();
				$status 	= ($request->is_active)?1:0;

				$data = [
					'group_name'=>$request->group_name,
					'type'		=>$request->type,
					'status'	=>$status,
				];

				if ($request->edit_id == '') {

					$response = UserGroup::create($data);
					// Get group id
					$group_id = $response->id;

					if ($request->type=='1') {
						// Get Admin User
						$admin_user_id = User::Select('id')->orderBy('id')->get();

						// Assign Admin user Group for all Admin user with status 0
						foreach($admin_user_id as $admin_user_id){
							$admin_user_group_member 			= new UserGroupMember();
							$admin_user_group_member->user_id 	= $admin_user_id['id'];
							$admin_user_group_member->group_id 	= $group_id;
							$admin_user_group_member->status 	= '0';
							$admin_user_group_member->save();
							//echo $admin_user_id;
						}

						// Get Action id
						$action_id = WebAction::Select('id')->get();
						//Save permission
						foreach ($action_id as $action_id) {
							$user_group_permissions = new UserGroupPermission();
							$user_group_permissions->group_id=$group_id;
							$user_group_permissions->action_id=$action_id['id'];
							$user_group_permissions->status='0';
							$user_group_permissions->save();
						}
					}
				}
				else{
					$data = UserGroup::find($request->edit_id);
					$data->group_name = $request->group_name;
					$data->type = $request->type;
					$data->update();
				}
				DB::commit();
				$return['result'] = "1";
				return json_encode($return);
			}
			catch (\Exception $e){
				DB::rollback();
				$return['result'] = "0";
				$return['errors'][] ="Faild to save";
				return json_encode($return);
			}
		}
	}

	//Admin Group show
	public function admin_groups_list(){
		$admin_user_id 				= Auth::user()->id;
		$edit_action_id 			= 18;
		$delete_action_id 			= 19;
		$give_permission_action_id 	= 20;
		$edit_permisiion  			= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion			= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);
		$give_permission 			= $this->PermissionHasOrNot($admin_user_id,$give_permission_action_id);

		$admin_group_list 	= UserGroup::Select('id', 'group_name', 'type','status')->orderBy('group_name')->get();
		$return_arr 		= array();
		foreach($admin_group_list as $admin_group_list){
			$admin_group_list['type']	=($admin_group_list->type == 1)?"Admin User":"Student User";
			$admin_group_list['status']	=($admin_group_list->status == 1)?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>In-active</button>";

			$admin_group_list['actions'] = "";
			if($give_permission>0){
				$admin_group_list['actions'] .="<button title='Permission' onclick='group_permission(".$admin_group_list->id.")' id=permission_" . $admin_group_list->id . " class='btn btn-xs btn-hover-shine btn-warning' ><i class='fa fa-key'></i></button>";
			}
			if($edit_permisiion>0){
				$admin_group_list['actions'] .=" <button title='Edit' onclick='admin_group_edit(".$admin_group_list->id.")' id=edit_" . $admin_group_list->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
			}
			if ($delete_permisiion>0) {
				$admin_group_list['actions'] .=" <button title='Delete' onclick='admin_group_delete(".$admin_group_list->id.")' id='delete_" . $admin_group_list->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
			}

			$return_arr[] = $admin_group_list;
		}
		return json_encode(array('data'=>$return_arr));
	}

	//Admin Group Edit
	public function admin_group_edit($id){
		$data = UserGroup::Select('id','group_name','type','status')->where('id',$id)->first();
		return json_encode($data);
	}

	//admin group delete
	public function admin_group_delete($id){
		UserGroup::find($id)->delete();
		return json_encode(array(
			"deleteMessage"=>"Deleted Successful"
		));
	}

	public function load_user_groups(){
		$user_groups = UserGroup::Select('id','group_name')
			->where('status','1')
			->where('type','1')
			->orderBy('group_name')
			->get();
		return json_encode(array('data'=>$user_groups));
    }

    public function load_actions_for_group_permission($id){
    	$group_id = $id;

    	$permission_details = DB::table('user_group_permissions as up')
    							->leftJoin('actions as wa', 'up.action_id', '=', 'wa.id')
    							->leftJoin('menus as m','wa.module_id','=','m.id')
    							->where('up.group_id',$group_id)
    							->where('wa.status','1')
								->orderBy('module_name','asc')
    							->select('up.*', 'wa.activity_name', 'm.module_name')
    							->get();

		return json_encode(array('data'=>$permission_details));
    }

    public function permission_action_entry_update(Request $request){
		$permission_action = $request->input('permission_action');
		$group_id = $request->group_id;

		try{
			DB::beginTransaction();

			$data_for_permission_action_update = DB::table('user_group_permissions')
															->where('group_id',$group_id)
															->update(['status'=>'0']);

			if($permission_action!=""){
				foreach ($permission_action as $permission_action ) {

					if (isset($permission_action)) {
						$status = '1';
						$data_for_permission_action_update = DB::table('user_group_permissions')
															->where('group_id',$group_id)
															->where('action_id',$permission_action)
															->update(['status'=>$status]);
					}
				}
			}

			DB::commit();
			$return['result'] = "1";
			return json_encode($return);
		}
		catch (\Exception $e){
			DB::rollback();
			$return['result'] = "0";
			$return['errors'][] ="Faild to save";
			return json_encode($return);
		}


    }

//**************************** personal profile*******************************

    public function profileIndex(){
    	$data['page_title'] = $this->page_title;
		$id 				= Auth::user()->id;
		$user 				= User::find($id);
    	$data['user']		= $user;
		if(Auth::user()->type=='Student' && $user->student_id){
			//$studentCourses = Student::with('courses')->findOrFail($user->student_id);
			$student = Student::with('documents')->findOrFail($user->student_id);
			$batchStudent = new BatchStudent();
			$courses = $batchStudent->getBatchesByStudentId($student->id);
			$data['student']		= $student;
			$data['courses']		= $courses;
			return view('student-portal.profile_index',$data);
		}

		//$data['courses'] =$courses;
		return view('admin.profile_index',$data);
    }

    public function profileInfo(){
    	$id 			= Auth::user()->id;
    	$profile_info 	= User::get()->where('id',$id);
		
    	return  json_encode($profile_info);
    }

    public function updateProfile(Request $request){
		$user 		= User::find($request->edit_profile_id);
		$rule = [
			'first_name' 		=> 'Required|max:220',
            'contact_no' 		=> 'Required|max:11|unique:users,contact_no,'. $user->id,
            'email' 			=> 'Required|email|unique:users,email,'. $user->id,
            'user_profile_image'=> 'mimes:jpeg,jpg,png,svg',
        ];
		
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()) {
			$return['result'] = "0";
			$return['errors'] = $validation->errors();
			return json_encode($return);
        }
		else{
			if ($request->edit_profile_id != ''){
				#EmailCheck
	            $email_verification = User::where([['email',$request->email],['id', '!=', $request->edit_profile_id]])->first();
           		if(isset($email_verification->id)){
					$return['result'] 	= "0";
					$return['errors'][] = $request->email." is already exists";
					return json_encode($return);
				}
			}
			try{
				DB::beginTransaction();
				
				$data = [
					'first_name'	=> $request->first_name,
					'contact_no'	=> $request->contact_no,
					'email'			=> $request->email,
				];
				if($user->type=='Student')
					$studentData = [
						'name'			=> $request->first_name,
						'contact_no'	=> $request->contact_no,
						'email'			=> $request->email
					];
				

				//if admin user Image provided
				$admin_image = $request->file('user_profile_image');
				if (isset($admin_image)){
					$image_name 				= time();
					$ext 						= $admin_image->getClientOriginalExtension();
					$image_full_name 			= $image_name.'.'.$ext;
					$upload_path 				= ($user->type=='Admin')?'assets/images/user/admin/':'assets/images/user/student/';
					$success					= $admin_image->move($upload_path,$image_full_name);
					$data['user_profile_image'] = $image_full_name;
				
					if($user->type=='Student'){					
						$student = Student::find($user->student_id);
						$student->user_profile_image = $image_full_name;
						$student->save();
					}
				}
				$old_image 	= $user->user_profile_image;
				$user->update($data);

				if($user->type=='Student'){ 
					$student	=Student::where('id',$user->student_id)->first();
					$student->update($studentData);
				}
				
				if (isset($admin_image) && $old_image!="") {
					$delete_img = $upload_path.$old_image;
					//unlink($delete_img);
				}
				DB::commit();
				$return['result'] = "1";
				return json_encode($return);
			}
			catch (\Exception $e){
				DB::rollback();
				$return['result'] 	= "0";
				$return['errors'][] ="Faild to save! ".$e;
				return json_encode($return);
			}
		}
	}

	public function updatePassword(Request $request){
		$rule = [
          //  'current_password' => 'Required|max:255',
			'new_password' => 'Required|max:255',
			'confirm_password' => 'Required|max:255',
        ];
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()) {
			$return['result'] = "0";
			$return['errors'] = $validation->errors();
			return json_encode($return);
        }
        else{
			try{
				DB::beginTransaction();
				$id = $request->change_pass_id;
				$user = User::find($id);
				if ($request->new_password == $request->confirm_password) {
					$user->password = bcrypt($request->new_password);
					$user->update();
					DB::commit();
					$return['result'] = "1";
					return json_encode($return);
				}else{
					$return['result'] = "0";
					$return['errors'][] ="Wrong Password..!";
					return json_encode($return);
				}
			}
			catch (\Exception $e){
				DB::rollback();
				$return['result'] = "0";
				$return['errors'][] =$e." Faild to save";
				return json_encode($return);
			}
		}
	}

	public function updateNotification(){
		$user = Auth::user();
		$user->unreadNotifications->markAsRead();
	}

	public function notificationHome($page){
		$page_no= ($page == 'latest')?1:$page;
        $limit 	= 10;
        $start 	= ($page_no*$limit)-$limit;
        $end   	= $limit;

		$user = User::find(Auth::user()->id);
		$notifications = $user->notifications()->offset($start)->limit($end)->get();

		$data['totalUnreadNotifications']= count($user->unreadNotifications);
		$data['notifications']=$notifications;
		return json_encode($data);
	}

	public function notificationRead($id){
		$user = User::find(Auth::user()->id);
		//$user->unreadNotifications->markAsRead();
		$user->unreadNotifications->where('id', $id)->markAsRead();
	}

	public function ajaxNotificationList(){
		$user = User::find(Auth::user()->id);
		$notifications = $user->notifications;

		$return_arr = array();
		foreach($notifications as $notification){
			//dd($notification->data['Type']);
			$function= "";
			if($notification->data['Type'] == 'Students') $function = "viewStudent(".$notification->data['Id'].")".';';
			if($notification->data['Type'] == 'Payments') $function = "paymentInvoice(".$notification->data['Id'].")".';';
			if($notification->data['Type'] == 'Courses') $function = "redirectCourseView(".$notification->data['Id'].")".';';

			$seenMessage 	= ($notification->read_at==null)?"notificationSeen('".$notification->id."')":"";

			$notification['status']	=(is_null($notification->read_at))?"<strong class='text-danger'>Unread</strong>":"Read";
			$notification['type'] 	= $notification->notifiable_type;
			$message = '<div style="cursor:pointer" onClick="'.$function.$seenMessage.'">';

			$message .= (!is_null($notification->read_at))?$notification->data['Message']:"<strong class='text-danger'>".$notification->data['Message']."</strong>";
			$message .= "</div>";
			$notification['message']= $message;
			$notification['date']	= date("Y-m-d h:m", strtotime($notification->created_at));
			
			/*if(is_null($notification->read_at))
				$notification['actions'] .="<button onclick='notificationSeen(".$notification->id.")' id=edit_" . $notification->id . "  class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            else 
				$notification['actions'] .="";*/
			
			$return_arr[] 			= $notification;
		}
		return json_encode(array('data'=>$return_arr));
	}
}

