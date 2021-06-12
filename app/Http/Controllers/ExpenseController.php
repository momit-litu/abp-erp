<?php

namespace App\Http\Controllers;

use App\Models\ExpneseCategory;
use Illuminate\Http\Request;
use Validator;
use Session;
use DB;
use Auth;
use App\Traits\HasPermission;

class ExpenseController extends Controller
{
    use HasPermission;
    public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }

	public function categoryIndex(){
		$data['page_title'] = $this->page_title;
		$data['module_name']= "Expenses";
		$data['sub_module']	= "Expense Category";
		
		$data['parentExpneseCategory']= ExpneseCategory::whereNull('parent_id')->get();
		// action permissions
        $admin_user_id  	= Auth::user()->id;
        $add_action_id  	= 66;// Module Management
        $add_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;
		return view('expense.expense_category',$data);
	}
	
	public function ajaxExpenseCategoryList(){
		$admin_user_id 		= Auth::user()->id;
		$edit_action_id 	= 68;
		$delete_action_id 	= 69;
		$edit_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$edit_action_id);
		$delete_permisiion 	= $this->PermissionHasOrNot($admin_user_id,$delete_action_id);

		$expenseCategoryList = ExpneseCategory::Select('id','category_name', 'parent_id', 'status')->orderBy('created_at','desc')->get();

		$return_arr = array();
		foreach($expenseCategoryList as $expenseCategory){
			$expenseCategory['status']=($expenseCategory->status == 1)?"<button class='btn btn-sm btn-success' disabled>Active</button>":"<button class='btn btn-xs btn-success' disabled>In-active</button>";
			$expenseCategory['actions'] = "";

			if($edit_permisiion>0){
				$expenseCategory['actions'] .="<button onclick='expenseCategoryEdit(".$expenseCategory->id.")' id=edit_" . $expenseCategory->id . "  class='btn btn-xs btn-hover-shine  btn-primary module-edit'><i class='lnr-pencil'></i></button>";
			}
			if ($delete_permisiion>0) {
				$expenseCategory['actions'] .=" <button onclick='expenseCategoryDelete(".$expenseCategory->id.")' id='delete_" . $expenseCategory->id . "' class='btn btn-xs btn-hover-shine btn-danger' ><i class='fa fa-trash'></i></button>";
			}
			$return_arr[] = $expenseCategory;
			
		}
		return json_encode(array('data'=>$return_arr));
	}
	

}
