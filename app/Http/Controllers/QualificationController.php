<?php

namespace App\Http\Controllers;

use App\Center;
use App\Qualification;
use App\QualificationUnit;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HasPermission;
use Auth;
use DB;


class QualificationController extends Controller
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
		$data['module_name']	= "Qualifications";
		$data['sub_module']		= "Qualifications";
		
		$data['levels'] 		=Level::all();
		// action permissions
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 22; // Qualification entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('qualification.qualification',$data);
    }

	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 27; // qualification edit
		$delete_action_id 	= 28; // qualification delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	   $qualifications = Qualification::with('units')->with('level')
							->orderBy('created_at','desc')
							->get();
				
        $return_arr = array();
        foreach($qualifications as $qualification){
			$totalGlh =0;
			foreach($qualification->units as $unit){
				$totalGlh += $unit['glh'];
			}
			
            $data['status'] 	= ($qualification->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] 		= $qualification->id;
			$data['code'] 		= $qualification->code;
            $data['title'] 		= $qualification->title;
			$data['tqt'] 		= $qualification->tqt;
			//$data['registration_fees'] = $qualification->registration_fees;
			$data['level'] 		= $qualification->level->name;
			$data['glh'] 		= $totalGlh;
			$data['noOfUnits'] 	= count($qualification->units);
			
			$data['actions'] =" <button title='View' onclick='qualificationView(".$qualification->id.")' id='view_" . $qualification->id . "' class='btn btn-xs btn-primary admin-user-view' ><i class='clip-zoom-in'></i></button>&nbsp;";
		   if($edit_permisiion>0){
                $data['actions'] .="<button onclick='qualificationEdit(".$qualification->id.")' id=edit_" . $qualification->id . "  class='btn btn-xs btn-green module-edit' ><i class='clip-pencil-3'></i></button>";
            }
            if ($delete_permisiion>0) {
                $data['actions'] .=" <button onclick='qualificationDelete(".$qualification->id.")' id='delete_" . $qualification->id . "' class='btn btn-xs btn-danger' ><i class='clip-remove'></i></button>";
            }

            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    public function createOrEdit(Request $request)
    {
		$admin_user_id 		= Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id,22);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data =  $this->editQualification($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data =  $this->createQualification($request->all());
		}

        return $response_data;
    }

    public function show($id)
    {
		if($id=="") return 0;		
        $qualification = Qualification::with('units', 'level')->findOrFail($id);
		return json_encode(array('qualification'=>$qualification));
    }

    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$qualification = Qualification::with('centers')->findOrFail($id);
		$is_deletable = (count($qualification->centers)==0)?1:0; // 1:deletabe, 0:not-deletable
		if(empty($qualification)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No qualification found"));
		}
		try {			
			DB::beginTransaction();
			if($is_deletable){
				QualificationUnit::where('qualification_id', $qualification->id)->delete();
				$qualification->delete();
				$return['message'] = "Qualification Deleted successfully";
			}
			else{
				$qualification->status = 'Inactive';
				$qualification->update();
				$return['message'] = "Deletation is not possible, but deactivated the qualification";
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
	
	public function qualificationAutoComplete(Request $request, $showtype){
		$term = $_REQUEST['term'];
		$user = Auth::user();
		if($showtype =='Center'){			
			$centerQualifications = Center::with(['qualifications'=>function($c) use ($term){
				$c->where([
                    ['qualifications.status', '=', 'Active'],
                    ['title','like','%'.$term.'%']
                ]);
			}])->find($user->center_id);
			$data = $centerQualifications->qualifications;
		}
		else{
			$data = Qualification::select('id', 'code', 'title')
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
	
	private function createQualification($request){
		//dd($request);
		try {
            $rule = [
                'code' 	=> 'required|string',
                'title' => 'required', 
				'tqt' 	=> 'required',
				'total_credit_hour' 	=> 'required',
				'registration_fees' => 'required|numeric', 				
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
                $qualification = Qualification::create([
                    'code' 		=>  $request['code'],
                    'title' 	=>  $request['title'],
					'tqt' 		=>  $request['tqt'],
					'total_credit_hour'	=>  $request['total_credit_hour'],
					'level_id' 	=>  $request['level_id'],
					'registration_fees' =>  $request['registration_fees'],
                    'status' 	=> (isset($request['status']))?'Active':'Inactive'
                ]);
				if(isset($request['unit_ids'])){
					foreach($request['unit_ids'] as $key=>$unit_id){
						QualificationUnit::create([
							'unit_id' 		=>  $unit_id,
							'qualification_id' 	=>  $qualification->id,
							'type' 			=>  $request['type'][$key],
						]);
					}
				}
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Qualification saved successfully";
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

	private function editQualification($request, $id){
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$qualification = Qualification::findOrFail($id);
			if(empty($qualification)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No qualification found"));
			}

            $rule = [
                'code' 	=> 'required|string',
                'title' => 'required', 
				'tqt' 	=> 'required',
				'total_credit_hour' 	=> 'required',				
				'registration_fees' => 'required|numeric', 			
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
				$qualification->code = $request['code'];
				$qualification->title = $request['title'];
				$qualification->tqt = $request['tqt'];
				$qualification->total_credit_hour = $request['total_credit_hour'];
				$qualification->level_id = $request['level_id'];
				$qualification->registration_fees = $request['registration_fees'];
				$qualification->status =  (isset($request['status']))?$request['status']:'Inactive';
				$qualification->update();
				
				if(isset($request['unit_ids']) && count($request['unit_ids'])>0){
					$qualificationUnit = QualificationUnit::where('qualification_id',$qualification->id )->delete();
					foreach($request['unit_ids'] as $key=>$unit_id){
						QualificationUnit::create([
							'unit_id' 		=>  $unit_id,
							'qualification_id' 	=>  $qualification->id,
							'type' 			=>  $request['type'][$key],
						]);
					}
				}
				
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Qualification Updated successfully";
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
