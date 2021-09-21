<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HasPermission;
use Auth;
use DB;

class UnitController extends Controller
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
		$data['module_name']	= "Quialifications";
		$data['sub_module']		= "Units";
        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 22; // Unit entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

		return view('course.unit',$data);
    }
	
	//unit list by ajax
	public function showList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 23; // unit edit
		$delete_action_id 	= 24; // unit delete
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

	   $units = Unit::Select('id','unit_code', 'name', 'glh', 'tut', 'assessment_type', 'status')
							->orderBy('created_at','desc')
							->get();
        $return_arr = array();
        foreach($units as $unit){
            $data['actions'] = "";
            $data['status'] = ($unit->status == 'Active')?"<button class='btn btn-xs btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] = $unit->id;
			$data['unit_code'] = $unit->unit_code;
            $data['name'] = $unit->name;
			$data['glh'] = $unit->glh;
			$data['tut'] = $unit->tut;
			$data['assessment_type'] = $unit->assessment_type;

			if($edit_permisiion>0){
				$data['actions'] 	.=" <button title='Edit' onclick='unitEdit(".$unit->id.")' id=edit_" . $unit->id . " class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
			}
			if ($delete_permisiion > 0) {
					$data['actions'] .=" <button title='Delete' onclick='unitDelete(".$unit->id.")' id='delete_" . $unit->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
			}
            $return_arr[] = $data;
        }
        return json_encode(array('data'=>$return_arr));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrEdit(Request $request)
    {
		$admin_user_id 		= Auth::user()->id;
        $entry_permission 	= $this->PermissionHasOrNot($admin_user_id,22);

		// update
		if(!is_null($request->input('edit_id')) && $request->input('edit_id') != ""){
			$response_data 	=  $this->editUnit($request->all(), $request->input('edit_id') );
		}
		// new entry
		else{
			$response_data 	=  $this->createUnit($request->all());
		}
        return $response_data;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		if($id=="") return 0;		
        $unit = Unit::findOrFail($id);
		return json_encode(array('unit'=>$unit));
    }

    
    public function destroy($id)
    {
        if($id==""){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
		}			
		$unit = Unit::with('courses')->findOrFail($id);
		$is_deletable = (count($unit->courses)==0)?1:0; // 1:deletabe, 0:not-deletable
		if(empty($unit)){
			return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No unit found"));
		}
		try {			
			DB::beginTransaction();
			if($is_deletable){
				$unit->delete();
				$return['message'] = "Unit Deleted successfully";
			}
			else{
				$unit->status = 'Inactive';
				$unit->update();
				$return['message'] = "Deletation is not possible, but deactivated the unit";
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
	
	public function unitAutoComplete(){
		$term = $_REQUEST['term'];

		$data = Unit::select('id', 'unit_code', 'name')
		       ->where([
                    ['status', '=', 'Active'],
                    ['name','like','%'.$term.'%']
                ])
				->orwhere([
                    ['status', '=', 'Active'],
                    ['unit_code','like','%'.$term.'%']
                ])
			->get();
		$data_count = $data->count();

		if($data_count>0){
			foreach ($data as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["unit_code"]." - ".$row["name"],);
			}
		}
		else {
			$json[] = array('id' => "0",'label' => "Not Found !!!");
		}
		return json_encode($json);
		
	}
	
	private function createUnit($request){
		//dd($request);
		try {
            $rule = [
                'unit_code' => 'required|unique:units|string',
                'name' 		=> 'required|unique:units', 
				'glh' 		=> 'required',
				'tut' 		=> 'required',
				'credit_hour' 		=> 'required',				
				'assessment_type' 	=> 'required', 				
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				DB::beginTransaction();
                Unit::create([
                    'unit_code' =>  $request['unit_code'],
                    'name' 		=>  $request['name'],
					'glh' 		=>  $request['glh'],
					'tut' 		=>  $request['tut'],
					'credit_hour' =>  $request['credit_hour'],					
					'assessment_type' =>  $request['assessment_type'],
                    'status' 	=> (isset($request['status']))?$request['status']:'Inactive'
                ]);
				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Unit saved successfully";
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
	
	private function editUnit($request, $id){
		try {
			if($id==""){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! "));
			}			
			$unit = Unit::findOrFail($id);
			if(empty($unit)){
				return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No unit found"));
			}

            $rule = [
                'unit_code' => 'required|string',
                'name' 		=> 'required', 
				'glh' 		=> 'required',
				'tut' 		=> 'required',
				'credit_hour' 		=> 'required',	
				'assessment_type' => 'required', 				
            ];
            $validation = \Validator::make($request, $rule);

            if($validation->fails()){
                $return['response_code'] = "0";
				$return['errors'] = $validation->errors();
				return json_encode($return);
            }
            else{
				
				DB::beginTransaction();
				$unit->unit_code = $request['unit_code'];
				$unit->name = $request['name'];
				$unit->glh 	= $request['glh'];
				$unit->tut 	= $request['tut'];
				$unit->credit_hour 		= $request['credit_hour'];
				$unit->assessment_type = $request['assessment_type'];
				$unit->status =  (isset($request['status']))?'Active':'Inactive';
				$unit->update();

				DB::commit();
				$return['response_code'] = 1;
				$return['message'] = "Unit Updated successfully";
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
