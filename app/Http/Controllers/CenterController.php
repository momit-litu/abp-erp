<?php

namespace App\Http\Controllers;

use App\Center;
use App\User;
use App\UserGroup;
use App\UserGroupMember;
use App\CenterQualification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HasPermission;
use Auth;
use DB;
 use Illuminate\Support\Facades\Mail;
 use App\Mail\CenterRegistrationNotification;

class CenterController extends Controller
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
		//mail test
		//$center = Center::first();
		//Mail::to('momit.litu@gmail.com')->send(new CenterRegistrationNotification($center,'Inactive'));
		
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Centres";
		$data['sub_module']		= "Centres";
		
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 30; // Center entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('center.center',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 31; // center edit
		$delete_action_id 	= 32; // center delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	   $centers = Center::with('qualifications')
							->orderBy('created_at','desc')
							->get();
				
        $return_arr = array();
        foreach($centers as $center){
            $data['status'] 	= ($center->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] 		= $center->id;
			$data['code'] 		= $center->code;
            $data['name'] 		= $center->name."(".$center->short_name.")";
			$data['proprietor_name']= $center->proprietor_name;
			$data['mobile_no'] 	= $center->mobile_no;
			$data['email'] 		= $center->email;
			$data['liaison_office'] = $center->liaison_office;
			$data['total_qualification'] = count($center->qualifications);
			if($center->approval_status == 'Pending'){
				$data['approval_status']  = "<button class='btn btn-xs btn-warning' disabled>Pending</button>";
			}
			else if($center->approval_status == 'Approved'){
				$data['approval_status']  = "<button class='btn btn-xs btn-success' disabled>Approved</button>";
			}
			else {
				 $data['approval_status'] = "<button class='btn btn-xs btn-danger' disabled>Rejected</button>";
			}
			
			$data['actions'] =" <button title='View' onclick='centerView(".$center->id.")' id='view_" . $center->id . "' class='btn btn-xs btn-primary admin-user-view' ><i class='clip-zoom-in'></i></button>&nbsp;";
		    if($edit_permisiion>0){
                $data['actions'] .="<button onclick='centerEdit(".$center->id.")' id=edit_" . $center->id . "  class='btn btn-xs btn-green module-edit' ><i class='clip-pencil-3'></i></button>";
            }
            if ($delete_permisiion>0) {
                $data['actions'] .=" <button onclick='centerDelete(".$center->id.")' id='delete_" . $center->id . "' class='btn btn-xs btn-danger' ><i class='clip-remove'></i></button>";
            }

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    public function createOrEdit(Request $request)
    {
		//dd($request->all());
		$admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,30);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data =  $this->editCenter($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data =  $this->createCenter($request->all());
		}

        return $response_data;
    }

    public function show($id)
    {
		if($id=="") return 0;		
        $center = Center::with('qualifications','qualifications.units')->findOrFail($id);
		return json_encode(array('center'=>$center));
    }

    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$center = Center::with('learners')->findOrFail($id);
		if(empty($center)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No centre found"));
		}
		$is_deletable = (count($center->learners)==0)?1:0; // 1:deletabe, 0:not-deletable
		
		try {			
			DB::beginTransaction();
	
			if($is_deletable){
				CenterQualification::where('center_id','=',$id)->delete();
				$user = User::with('user_groups')->where('center_id','=',$id)->first();
				UserGroupMember::where('user_id','=',$user->id)->delete();
				$user->delete();
				$center->delete();
				//sendDeletationCenterMail 
				$return['message'] = "Center Deleted successfully";
			}
			else{
				$center->status = 'Inactive';
				$center->update();			

				$user = User::where('center_id','=',$id)->first();
				$user->status = 0;
				$user->save();
				// center active/inactive
				//sendStatusMail();

				$return['message'] = "Deletation is not possible, but deactivated the centre";
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
	
	private function createCenter($request){
		//dd($request);
		try {
            $rule = [
                'code' 	=> 'required|string',
                'short_name' => 'required', 
				'address' 	=> 'required',
				'mobile_no' 	=> 'required',
				'email' 	=> 'required|email',
				'liaison_office' 	=> 'required',
				'liaison_office_address' 	=> 'required',
				'agreed_minimum_invoice' => 'numeric', 				
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				// insert into center
                $center = Center::create([
                    'code' 				=>  $request['code'],
                    'short_name'		=>  $request['short_name'],
					'website'			=>  $request['website'],
					'name' 				=>  $request['name'],
					'address' 			=>  $request['address'],
					'proprietor_name'	=>  $request['proprietor_name'],
					'mobile_no' 		=>  $request['mobile_no'],
					'email' 			=>  $request['email'],
					'liaison_office' 	=>  $request['liaison_office'],
					'liaison_office_address' =>  $request['liaison_office_address'],
					'agreed_minimum_invoice' =>  $request['agreed_minimum_invoice'],
					'date_of_approval'	=>  $request['date_of_approval'],
					'date_of_review' 	=>  $request['date_of_review'],
					'approval_status' 	=>  $request['approval_status'],					
                    'status' 			=> (isset($request['status']))?$request['status']:'Inactive'
                ]);
				foreach($request['qualification_ids'] as $key=>$qualification_id){
					CenterQualification::create([
						'qualification_id' 	=>  $qualification_id,
						'center_id' 		=>  $center->id,
					]);
				}
				
				// create a new centrer admin user
				$emailVerification = User::where([['email',$request['email']]])->first();
           		if(isset($emailVerification->id)){
					$return['response_code'] 	= "0";
					$return['errors'][] = $request['email']." is already exists";
					return json_encode($return);
				}
				//echo "momit.--".$center->id;die;
				$centerAdmin = User::create([
					'first_name'	=> $request['name'],
					'contact_no'	=> $request['mobile_no'],
					'email'			=> $request['email'],
					'password' 		=> bcrypt('1234'),
					'type'			=> 'Center',
					'center_id'		=> $center->id
				]);
				//dd($centerAdmin);
				
				//insert center user group permission
				$user_groups = UserGroup::select('id')->where('type',2)->get();					
				foreach ($user_groups as $user_group ) {							
					$group_member_data 				= new UserGroupMember();
					$group_member_data->group_id	= $user_group['id'];
					$group_member_data->user_id		= $centerAdmin->id;
					$group_member_data->status		= 1;
					$group_member_data->save();
				}
				
				// if approve status is approved, a mail will send to center admin
				/*if($center->approval_status == 'Approved'){
					Mail::to($center->email)->send(new CenterRegistrationNotification($center, 'Approve'));
				}*/

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Centre saved successfully";
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

	private function editCenter($request, $id){
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$center = Center::findOrFail($id);

			if(empty($center)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No centre found"));
			}

            $rule = [
                'code' 		=> 'required|string',
                'short_name'=> 'required', 
				'address' 	=> 'required',
				'mobile_no'	=> 'required',
				'email' 	=> 'required|email',
				'liaison_office' 		=> 'required',
				'liaison_office_address'=> 'required',
				'agreed_minimum_invoice'=> 'numeric', 				
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				$currentStatus 		= $center->status;
				$currentApprovalStatus = $center->approval_status;
				$status = (isset($request['status']))?'Active':'Inactive';
				$center->code 		= $request['code'];
				$center->short_name = $request['short_name'];
				$center->website 	= $request['website'];				
				$center->name 		= $request['name'];
				$center->address 	= $request['address'];
				$center->proprietor_name 	= $request['proprietor_name'];
				$center->mobile_no 	= $request['mobile_no'];
				$center->email 		= $request['email'];
				$center->liaison_office 	= $request['liaison_office'];
				$center->liaison_office_address = $request['liaison_office_address'];
				$center->agreed_minimum_invoice = $request['agreed_minimum_invoice'];
				$center->date_of_approval 	= $request['date_of_approval'];
				$center->date_of_review 	= $request['date_of_review'];
				$center->approval_status 	= $request['approval_status'];
				$center->status 	= $status ;
				$center->update();
				
				if(count($request['qualification_ids'])>0){
					$centerQualification = CenterQualification::where('center_id',$center->id )->delete();
					if($centerQualification){
						foreach($request['qualification_ids'] as $key=>$qualification_id){
							CenterQualification::create([
								'qualification_id' 	=>  $qualification_id,
								'center_id' 		=>  $center->id,
							]);
						}
					}
				}
				
				//Email duplicate Check
				$emailVerification = User::where([['email',$request['email']],['center_id', '!=', $center->id]])->first();
           		if(isset($emailVerification->id)){
					$return['response_code'] 	= "0";
					$return['message'][] = $request['email']." is already exists";
					return json_encode($return);
				}
				// if status changed to active or inactive
				if($currentStatus != $status){
					$user = User::where('center_id','=',$center->id)->first();
					$user->status = ($status=='Active')?1:0;
					$user->save();
					/*
					if($status=='Active') 
						Mail::to($center->email)->send(new CenterRegistrationNotification($center, 'Active'));
					else 
						Mail::to($center->email)->send(new CenterRegistrationNotification($center, 'Inactive'));
					*/
				}
				// if approve status changed to approved / rejected , a mail will send to center admin
				/*if($currentApprovalStatus != $request['approval_status'] && $request['approval_status'] == 'Approved'){
					Mail::to($center->email)->send(new CenterRegistrationNotification($center, 'Approve'));
				}else if($currentApprovalStatus != $request['approval_status'] && $request['approval_status'] == 'Rejected'){
					Mail::to($center->email)->send(new CenterRegistrationNotification($center, 'Reject'));
				} 
				*/

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Centre Updated successfully";
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