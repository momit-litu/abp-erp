<?php

namespace App\Http\Controllers;

use App\Registration;
use App\RegistrationLearner;
use App\Center;
use App\Qualification;
use App\User;
use App\LearnerResult;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HasPermission;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegistrationRequest;
use App\Notifications\CertificateClaim;


use Auth;
use DB;


class RegistrationController extends Controller
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
		$data['module_name']	= "Registrations";
		$data['sub_module']		= "Registrations";
		
		// action permissions
        $admin_user_id  		= Auth::user()->id;
		
        $add_action_id  		= 45; // Registration entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']	= $add_permisiion;
		$data['userType']					= Auth::user()->type;
		return view('registration.index',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$userType 			= Auth::user()->type;
		
		$edit_action_id 	= 45; // registration edit
		$delete_action_id 	= 46; // registration delete
		$result_action_id 	= 48; // registration delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);
		$result_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$result_action_id);
		
	    $registrationsSql = Registration::with('qualification', 'qualification.units')
							->with('center')->with('learners');
							
		if($userType=='Center'){
			$centerId = Auth::user()->center_id;
			$registrationsSql = $registrationsSql->where('center_id',$centerId);
		}
		else if($userType=='Admin'){
			$registrationsSql = $registrationsSql->where('approval_status', '!=','Initiated');
		}
		
		$registrations = $registrationsSql->orderBy('created_at','desc')->get();
        
		$return_arr = array();
        foreach($registrations as $registration){            
            $data['id'] 			= $registration->id;
			$data['registration_no']= $registration->registration_no;
			$data['center_name'] 	= $registration->center->name;
			$data['qualification_title']= $registration->qualification->title;
			$data['no_of_units'] 		= count($registration->qualification->units);
			$data['no_of_learners'] 	= count($registration->learners);
			$data['invoice_no'] 			= "<a href='javascript:void(0)' onclick='showInvoice(".$registration->id.")' />".$registration->invoice_no."</a>";			
			
			$data['approval_status'] = $registration->approval_status;
			/*
			if($registration->approval_status == 'Initiated'){
				$data['approval_status']  = "<button class='btn btn-xs btn-warning' disabled>Initiated</button>";
			}
			else if($registration->approval_status == 'Requested'){
				$data['approval_status']  = "<button class='btn btn-xs btn-info' disabled>Requested</button>";
			}
			else if($registration->approval_status == 'Approved'){
				$data['approval_status']  = "<button class='btn btn-xs btn-success' disabled>Approved</button>";
			}
			else {
				 $data['approval_status'] = "<button class='btn btn-xs btn-danger' disabled>Rejected</button>";
			}
			*/
			$data['payment_status']  = $registration->payment_status;
			/*if($registration->payment_status == 'Due'){
				$data['payment_status']  = "<button class='btn btn-xs btn-danger' disabled>Due</button>";
			}
			else if($registration->payment_status == 'Paid'){
				$data['payment_status']  = "<button class='btn btn-xs btn-success' disabled>Paid</button>";
			}
			else {
				 $data['payment_status'] = "<button class='btn btn-xs btn-warning' disabled>Partial</button>";
			}
			*/
			$data['status'] 	= ($registration->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
			
			$data['actions'] =" <button title='View' onclick='registrationView(".$registration->id.")' id='view_" . $registration->id . "' class='btn btn-xs btn-primary admin-user-view' ><i class='clip-zoom-in'></i></button>&nbsp;";
		    if($edit_permisiion>0){
				if($registration->approval_status != "Initiated" && $userType=='Center'){}
				else if($registration->payment_status != "Paid"){
					$data['actions'] .="<button onclick='registrationEdit(".$registration->id.")' id=edit_" . $registration->id . "  class='btn btn-xs btn-green module-edit' ><i class='clip-pencil-3'></i></button>";
				}
			}
            if ($delete_permisiion>0) {
				if($registration->approval_status != "Initiated" && $userType=='Center'){}
				else{
					$data['actions'] .=" <button onclick='registrationDelete(".$registration->id.")' id='delete_" . $registration->id . "' class='btn btn-xs btn-danger' ><i class='clip-remove'></i></button>";
				}
            }
			if ($result_permisiion>0 /*&& $userType=='Center'*/ && $registration->approval_status == 'Approved') {				
				$data['actions'] .=" <button onclick='setResut(".$registration->id.")' id='result_" . $registration->id . "' class='btn btn-xs btn-info' ><i class='clip-pie'></i></button>";
            }
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    public function createOrEdit(Request $request)
    {
		//dd($request->all());
		$admin_user_id 	= Auth::user()->id;
		$userType 		= Auth::user()->type;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,44);
		$edit_permission = $this->PermissionHasOrNot($admin_user_id,45);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != "" && $edit_permission){
			$response_data =  $this->editRegistration($request->all(), $request->input('edit_id') );
		}
		// new entry
		else if($entry_permission && $userType=='Center'){
			$response_data =  $this->createRegistration($request->all());
		}
		else{
			$return['response_code'] = 0;
			$return['errors'] = "You are not authorized to create a registration";
			$response_data = json_encode($return);
		}

        return $response_data;
    }

    public function show($id)
    {
		if($id=="") return 0;		
        $registration =Registration::with('qualification', 'qualification.units')->with('center')->with('learners')->findOrFail($id);
		return json_encode(array('registration'=>$registration));
    }

    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$registration = Registration::with('qualifications')->findOrFail($id);
		if(empty($registration)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No registration found"));
		}
		$is_deletable = (count($registration->approval_status)=="Initiated")?1:0; // 1:deletabe, 0:not-deletable
		
		try {			
			DB::beginTransaction();
	
			if($is_deletable){
				$registration->learners()->detach();
				$registration->delete();
				$return['message'] = "Registration Deleted successfully";
			}
			else{
				$registration->status = 'Inactive';
				$registration->update();			
				// registration active/inactive
				//sendStatusMail();

				$return['message'] = "Deletation is not possible, but deactivated the registration";
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

	public function transcript($id)
    {
        if($id=="") return 0;	
        $admin_user_id  	= Auth::user()->id;
        $result_action_id  	= 50; // Registration entry
		$claim_action_id  	= 51; // claim certificate
        $permissions['result_permisiion'] 	= $this->PermissionHasOrNot($admin_user_id,$result_action_id );
		$permissions['claim_permisiion'] 	= $this->PermissionHasOrNot($admin_user_id,$claim_action_id );

        $registration =Registration::with('qualification', 'qualification.units')->with('center')->with('learners')->findOrFail($id);
		
		$qualification 	= Qualification::with('units')->findOrFail($registration->qualification_id);
		$units 			= $qualification->units;
		
		$registedLearners = RegistrationLearner::with('learner')->with('results','results.unit')->where('registration_id',$id)->get();
		echo view('registration.transcript')->with(['permissions'=>$permissions,'registration' => $registration, 'registedLearners'=>$registedLearners]);
    }
	
	
	public function transcriptSave(Request $request)
    {
		$admin_user_id 	= Auth::user()->id;
		$userType 		= Auth::user()->type;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,50);
		
		if($entry_permission){			
			try {
				DB::beginTransaction();
				foreach($request->registedLearners as $registedLearnerId){
					if(isset($request->learnerResults[$registedLearnerId])){
						$lernerResults    = $request->learnerResults[$registedLearnerId];
						$passed = 1;
						foreach($lernerResults as $resultId=>$result){						
							if(($result=="F")) $passed = 0;
							if(($result=="NA")) $passed = 2;
							$learnerResult = LearnerResult::findOrFail($resultId);
							$learnerResult->result = $result;
							$learnerResult->passed = ($result=="F")?"No":"Yes";
							$learnerResult->save();
						}
						if($passed==1){
							$learnerResult = RegistrationLearner::findOrFail($registedLearnerId);
							$learnerResult->pass_status = "Pass";
							$learnerResult->save();
						}
						else if($passed == 2){
							$learnerResult = RegistrationLearner::findOrFail($registedLearnerId);
							$learnerResult->pass_status = "No Result";
							$learnerResult->save();
						}
						else if(!$passed){
							$learnerResult = RegistrationLearner::findOrFail($registedLearnerId);
							$learnerResult->pass_status = "Fail";
							$learnerResult->save();
						}
					}
				}	
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Saved successfully";
				return json_encode($return);
			} 
			catch (\Exception $e){
				DB::rollback();
				$return['response_code'] 	= 0;
				$return['errors'] = "Failed to save !".$e->getMessage();
				return json_encode($return);
			}	
		}
    }

	public function claimCirtificate($claimLearners)
    {
		$claimLearners 	= explode(',', (rtrim($claimLearners ,',')));
		$admin_user_id 	= Auth::user()->id;
		$userType 		= Auth::user()->type; 
        $claim_permission = $this->PermissionHasOrNot($admin_user_id,51);
		$center 		=  Center::where('id',Auth::user()->center_id)->first();
		//dd($center);
		if($claim_permission){			
			try {
				DB::beginTransaction();	
				foreach($claimLearners as $claimLearner){
					$registedLearner = RegistrationLearner::findOrFail($claimLearner);
					if($registedLearner->pass_status=="Pass" && $registedLearner->result_claim_date==""){
						$registedLearner->result_claim_date = date('Y-m-d');				
						$registedLearner->save();
					}
				}
				
				$notifyUsers = User::where('status','1')->where('type','Admin')->get();
				Notification::send($notifyUsers, new CertificateClaim(array('type'=>'Claimed', 'totalCertificateNo'=>count($claimLearners),'centerName'=>$center->name )));				

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Saved successfully";
				return json_encode($return);
			} 
			catch (\Exception $e){
				DB::rollback();
				$return['response_code'] 	= 0;
				$return['errors'] = "Failed to save !".$e->getMessage();
				return json_encode($return);
			}	
		}
    }
	
	private function createRegistration($request){
		//dd($request);
		try {
            $rule = [
                'qualification_id' 	=> 'required',				
               // 'learner_ids' => => "required|array|min:1",	
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				$maxId 			= Registration::max('id');
				$registrationNo = date('ym').str_pad(($maxId+1),6,0, STR_PAD_LEFT);
				
				// insert into registration
                $registration = Registration::create([
                    'qualification_id' 	=>  $request['qualification_id'],
					'registration_no' 	=>  $registrationNo,
					'center_id' 		=>  Auth::user()->center_id,
					'registration_fees' =>  $request['registration_fees'],
					'remarks' 			=>  $request['remarks'],
                    'status' 			=> (isset($request['status']))?$request['status']:'Inactive'
                ]);
				if(isset($request['learner_ids']) && count($request['learner_ids'])>0){
					$registration->learners()->attach($request['learner_ids']);
				}

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Registration saved successfully";
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

	private function editRegistration($request, $id){
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$registration = Registration::with('center')->findOrFail($id);

			if(empty($registration)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No registration found"));
			}

            $rule = [
               'qualification_id' 	=> 'required',						
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{

				DB::beginTransaction();
				$currentStatus 	= $registration->status;
				$status 		= (isset($request['status']))?'Active':'Inactive';
				$currentApproveStatus 	= $registration->approval_status;
								
				$registration->qualification_id	 = $request['qualification_id'];
				$registration->registration_fees = $request['registration_fees'];			
				$registration->remarks 			= $request['remarks'];
				$registration->payment_status 	= (isset($request['payment_status']))?$request['payment_status']:$registration->payment_status;
				$registration->approval_status 	= $request['approval_status'];
				$registration->status 	= $status ;

				if($request['approval_status'] == 'Requested' && $registration->invoice_no == ""){		
					$registration->invoice_no 	= 'INV-'.str_pad(($id+1),6,0, STR_PAD_LEFT);
				}
				$registration->update();
				if(isset($request['learner_ids']) && count($request['learner_ids'])>0){				
					$registration->learners()->sync($request['learner_ids']);
				}
				
				// insert into result table when a resistration is approved
				if($request['approval_status'] == 'Requested' && $currentApproveStatus == "Initiated"){	
					$notifyUsers = User::where('status','1')->where('type','Admin')->get();
					Notification::send($notifyUsers, new RegistrationRequest($registration));
				}
				else if($request['approval_status'] == 'Approved' && $currentApproveStatus == "Requested"){		
					$registration->ep_registration_date = Date('Y-m-d');
					$registration->update();	
					
					$notifyUsers = User::where('status','1')->where('center_id',$registration->center_id)->get();
					Notification::send($notifyUsers, new RegistrationRequest($registration));

					
					$qualification 	= Qualification::with('units')->findOrFail($registration->qualification_id);
					$units 			= $qualification->units;
					
					$registedLearners = RegistrationLearner::where('registration_id',$id)->get();
					if(count($registedLearners)>0){
						foreach($registedLearners as $registedLearner){
							foreach($units as $unit){
								LearnerResult::create([
									'registration_learner_id'=>$registedLearner->id,
									'unit_id'=>$unit->id,
								]);
							}
						}
					}
				}
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Registration Updated successfully";
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

	public function certificateIndex()
    {
        $data['page_title'] 	= $this->page_title;
		$data['module_name']	= "Certificates";
		$data['sub_module']		= "Certificates";
		

        $admin_user_id  		= Auth::user()->id;
		$data['userType']		= Auth::user()->type;
        $add_action_id  		= 53; // Cirtificate save
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('registration.certificate',$data);
    }

	public function showCertificateList(){
		$admin_user_id 		= Auth::user()->id;
		$userType 			= Auth::user()->type;
		
		$certificate_save_action_id 	= 53; // certificate save
		$certificate_save_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$certificate_save_action_id);
		
		$certificateLearnersSql = RegistrationLearner::with('learner', 'registration','registration.center', 'registration.qualification')
							->where('pass_status','Pass')
							->where('result_claim_date','!=','');
				
		if($userType=='Center'){
			$centerId = Auth::user()->center_id;
			$certificateLearnersSql = $certificateLearnersSql->with(['registration' => function ($query) use ($centerId) {
										$query->where('center_id', $centerId);
									 }]);			
		}
		else{
			$certificateLearnersSql = $certificateLearnersSql->with('registration');		
		}
		//echo $certificateLearnersSql->toSql();die;
		$certificateLearners = $certificateLearnersSql->orderBy('created_at','desc')->get();
		//dd($certificateLearners);
		$return_arr = array();
        foreach($certificateLearners as $certificateLearner){  
			if(!is_null($certificateLearner->registration)){		
				$data['id'] 			= $certificateLearner->id;
				$data['registration_no']= str_pad($certificateLearner->id, 6, '0', STR_PAD_LEFT);
				$data['invoice_no'] 	= "<a href='javascript:void(0)' onclick='showInvoice(".$certificateLearner->registration->id.")' />".$certificateLearner->registration->invoice_no."</a>";
				$data['center_name'] 	= $certificateLearner->registration->center->name;
				$data['qualification_title']= $certificateLearner->registration->qualification->title;
				$data['learner_name'] 		= $certificateLearner->learner->first_name." ".$certificateLearner->learner->last_name;
				$data['result'] 			= $certificateLearner->pass_status;
				$data['certificate_no'] 	= ($certificateLearner->certificate_no != "")?$certificateLearner->certificate_no:"";
				$data['print_status'] 		= $certificateLearner->is_printd;
				
				$data['actions'] =" <button title='View' onclick='certificateView(".$certificateLearner->id.")' id='view_" . $certificateLearner->id . "' class='btn btn-xs btn-primary admin-user-view' ><i class='clip-zoom-in'></i></button>&nbsp;";
				if($certificate_save_permisiion>0 && $certificateLearner->is_printd =='No'){
					$data['actions'] .="<button onclick='certificateEdit(".$certificateLearner->id.")' id=edit_" . $certificateLearner->id . "  class='btn btn-xs btn-green module-edit' ><i class='clip-pencil-3'></i></button>";
				}
				$return_arr[] = $data;
			}
        }
        return json_encode(array('data'=>$return_arr));
	}
	
	public function certificateShow($id)
    {
		$certificateLearnerSql = RegistrationLearner::with('results','results.unit','learner', 'registration','registration.center', 'registration.qualification', 'registration.qualification.level')
							->where('pass_status','Pass')
							->where('result_claim_date','!=','');				
		$certificateLearnerSql = $certificateLearnerSql->with('registration');		
		
		$certificateLearner = $certificateLearnerSql->orderBy('created_at','desc')->findOrFail($id);
		return json_encode(array('certificateLearner'=>$certificateLearner));
    }
	
	public function certificatePrint($id)
    {
		//echo "MOMIT";die;
		$certificateLearnerSql = RegistrationLearner::with('results','results.unit','learner', 'registration','registration.center', 'registration.qualification', 'registration.qualification.level')
							->where('pass_status','Pass')
							->where('result_claim_date','!=','');				
		$certificateLearnerSql = $certificateLearnerSql->with('registration');		
		
		$certificateLearner = $certificateLearnerSql->orderBy('created_at','desc')->findOrFail($id);
		$settings		= Setting::first();
		$images = [
			'signetureImage'=> asset('assets/images/admin-upload/'.$settings->certificate_signeture),
			'qrCodeImage' 	=> asset('assets/images/admin-upload/'.$settings->logo)
		];
		/* \QrCode::size(500)
			->format('png')
			->generate('codingdriver.com', public_path('images/qrcode.png'));
		*/	
		
		/*$qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->encoding('UTF-8')
                ->size(450)->generate($certificateLearner->certificate_no);
		*/	
		$totalCredit = 0;
		foreach($certificateLearner->results as $result){
			$totalCredit += $result->unit->credit_hour;
		}
		echo view('registration.certificate-print')->with(['certificateLearner'=>$certificateLearner,'images'=>$images, 'totalCredit'=>$totalCredit ]);
	}
	
	public function transcriptPrint($id)
    {
		$certificateLearnerSql = RegistrationLearner::with('results','results.unit','learner', 'registration','registration.center', 'registration.qualification', 'registration.qualification.level')
							->where('pass_status','Pass')
							->where('result_claim_date','!=','');				
		$certificateLearnerSql = $certificateLearnerSql->with('registration');		
		
		$certificateLearner = $certificateLearnerSql->orderBy('created_at','desc')->findOrFail($id);
		$settings		= Setting::first();
		$images = [
			'signetureImage'=> asset('assets/images/admin-upload/'.$settings->certificate_signeture),
			'qrCodeImage' 	=> asset('assets/images/admin-upload/'.$settings->logo)
		];
		/* \QrCode::size(500)
			->format('png')
			->generate('codingdriver.com', public_path('images/qrcode.png'));
		*/	
		
		/*$qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->encoding('UTF-8')
                ->size(450)->generate($certificateLearner->certificate_no);
		*/	
		$totalCredit = 0;
		foreach($certificateLearner->results as $result){
			$totalCredit += $result->unit->credit_hour;
		}
		echo view('registration.transcript-print')->with(['certificateLearner'=>$certificateLearner,'images'=>$images, 'totalCredit'=>$totalCredit ]);
	}
	
	
	public function certificateSave(Request $request)
    {
		$id = $request->edit_id;
		try{
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$registrationLearner = RegistrationLearner::with('learner')->findOrFail($id);

			if(empty($registrationLearner)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No record found"));
			}

			DB::beginTransaction();
			$registrationLearner->certificate_no 	= $request->certificate_no;
			$registrationLearner->save();								
			
			$center 	=  Center::where('id',$registrationLearner->learner->center_id)->first();
			$notifyUsers= User::where('center_id',$registrationLearner->learner->center_id)->get();
			Notification::send($notifyUsers, new CertificateClaim(array('type'=>'Given', 'learnerName'=>$registrationLearner->learner->first_name." ".$registrationLearner->learner->last_name )));				

			
			DB::commit();
			$return['response_code'] = 1;
			$return['message'] = "Registration Updated successfully";
			return json_encode($return);
            
        } 
		catch (\Exception $e){
			DB::rollback();
			$return['response_code'] 	= 0;
			$return['errors'] = "Failed to update !".$e->getMessage();
			return json_encode($return);
		}
    }
	
}
