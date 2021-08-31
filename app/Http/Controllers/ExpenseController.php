<?php

namespace App\Http\Controllers;


use DB;
use Auth;
use Session;
use Validator;
use App\Models\Expense;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Illuminate\Http\Response;
use App\Models\ExpneseCategory;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{
    use HasPermission;

    public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }

    public function categoryIndex()
    {
        $data['page_title'] = $this->page_title;
        $data['module_name'] = "Expenses";
        $data['sub_module'] = "Expense Category";

        $data['parentExpneseCategory'] = ExpneseCategory::whereNull('parent_id')->get();
        // action permissions
        $admin_user_id = Auth::user()->id;
        $add_action_id = 66;// Module Management
        $add_permisiion = $this->PermissionHasOrNot($admin_user_id, $add_action_id);
        $data['actions']['add_permisiion'] = $add_permisiion;
        return view('expense.expense_category', $data);
    }

    public function ajaxExpenseCategoryList()
    {
        $admin_user_id = Auth::user()->id;
        $edit_action_id = 68;
        $delete_action_id = 69;
        $edit_permisiion = $this->PermissionHasOrNot($admin_user_id, $edit_action_id);
        $delete_permisiion = $this->PermissionHasOrNot($admin_user_id, $delete_action_id);

        $expenseCategoryList = ExpneseCategory::Select('id', 'category_name', 'parent_id', 'status')->with('parent')->orderBy('created_at', 'desc')->get();

        $return_arr = array();
        foreach ($expenseCategoryList as $expenseCategory) {

            $expenseCategory['parent_name'] = (is_null($expenseCategory->parent_id)) ? "" : $expenseCategory->parent->category_name;

            $expenseCategory['status'] = ($expenseCategory->status == 'Active') ? "<button class='btn btn-xs btn-success' disabled>Active</button>" : "<button class='btn btn-xs btn-warning' disabled>In-active</button>";
            $expenseCategory['actions'] = "";

            if ($edit_permisiion > 0) {
                $expenseCategory['actions'] .= "<button onclick='expenseCategoryEdit(" . $expenseCategory->id . ")' id=edit_" . $expenseCategory->id . "  class='btn btn-xs btn-hover-shine  btn-primary module-edit'><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion > 0) {
                $expenseCategory['actions'] .= " <button onclick='expenseCategoryDelete(" . $expenseCategory->id . ")' id='delete_" . $expenseCategory->id . "' class='btn btn-xs btn-hover-shine btn-danger' ><i class='fa fa-trash'></i></button>";
            }
            $return_arr[] = $expenseCategory;

        }
        return json_encode(array('data' => $return_arr));
    }

    public function createOrEdit(Request $request)
    {
        $admin_user_id = Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id, 66);

        // update
        if (!is_null($request->input('edit_id')) && $request->input('edit_id') != "") {
            $response_data = $this->editExpenseCategory($request->all(), $request->input('edit_id'));
        } // new entry
        else {
            $response_data = $this->createExpenseCategory($request->all());
        }
        return $response_data;
    }

    public function show($id)
    {
        if ($id == "") return 0;
        $expneseCategory = ExpneseCategory::findOrFail($id);
        return json_encode(array('expneseCategory' => $expneseCategory));
    }

    public function destroy($id)
    {
        if ($id == "") {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
        }
        $expense = ExpneseCategory::with('child')->findOrFail($id);
        $is_deletable = (count($expense->child) == 0) ? 1 : 0; // 1:deletabe, 0:not-deletable
        if (empty($expense)) {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No Expense Category found"));
        }
        try {
            DB::beginTransaction();
            if ($is_deletable) {
                ExpneseCategory::where('parent_id', $expense->id)->delete();
                $expense->delete();
                $return['message'] = "Expense Category Deleted successfully";
            } else {
                $expense->status = 'Inactive';
                $expense->update();
                $return['message'] = "Deletation is not possible, but deactivated the Expense Category";
            }

            DB::commit();
            $return['response_code'] = 1;

            return json_encode($return);
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to delete !" . $e->getMessage();
            return json_encode($return);
        }
    }

    private function createExpenseCategory($request)
    {
        //dd($request);
        try {
            $rule = [
                'expense_category_name' => 'required',

            ];
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                ExpneseCategory::create([
                    'category_name' => $request['expense_category_name'],
                    'parent_id' => $request['parent_id'],
                    'status' => (isset($request['is_active'])) ? 'Active' : 'Inactive'
                ]);
                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Expense Category saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    private function editExpenseCategory($request, $id)
    {
        try {
            if ($id == "") {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
            }
            $expneseCategory = ExpneseCategory::findOrFail($id);
            if (empty($expneseCategory)) {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No Expense Category found"));
            }

            $rule = [
                'expense_category_name' => 'required',
            ];
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {

                DB::beginTransaction();
                $expneseCategory->category_name = $request['expense_category_name'];
                $expneseCategory->parent_id = $request['parent_id'];
                $expneseCategory->status = (isset($request['is_active'])) ? 'Active' : 'Inactive';
                //dd($expneseCategory);
                $expneseCategory->update();

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Expense Category Updated successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to update !" . $e->getMessage();
            return json_encode($return);
        }


    }

    // Expense Head

    public function expenseHeadIndex()
    {
        $data['page_title'] = $this->page_title;
        $data['module_name'] = "Expenses";
        $data['sub_module'] = "Expense Head";

        $data['parentExpneseHead'] = ExpneseCategory::where('status','Active')->get();
        // action permissions
        $admin_user_id = Auth::user()->id;
        $add_action_id = 73;// Module Management
        $add_permisiion = $this->PermissionHasOrNot($admin_user_id, $add_action_id);
        $data['actions']['add_permisiion'] = $add_permisiion;
        return view('expense.expense_head', $data);
    }

    public function ajaxExpenseHeadList()
    {
        $admin_user_id = Auth::user()->id;
        $edit_action_id = 75;
        $delete_action_id = 76;
        $edit_permisiion = $this->PermissionHasOrNot($admin_user_id, $edit_action_id);
        $delete_permisiion = $this->PermissionHasOrNot($admin_user_id, $delete_action_id);

        $expenseHeadList = ExpenseHead::with('expensecategory', 'expensecategory.parent')->orderBy('created_at', 'desc')->get();

        $return_arr = array();
        foreach ($expenseHeadList as $expenseHead) {
			//dd($expenseHead);
            $expenseHead['category_name'] = (is_null($expenseHead->expensecategory->parent)) ? $expenseHead->expensecategory->category_name:$expenseHead->expensecategory->parent->category_name." -> ".$expenseHead->expensecategory->category_name;


            $expenseHead['status'] = ($expenseHead->status == 'Active') ? "<button class='btn btn-xs btn-success' disabled>Active</button>" : "<button class='btn btn-xs btn-warning' disabled>In-active</button>";
            $expenseHead['actions'] = "";

            if ($edit_permisiion > 0) {
                $expenseHead['actions'] .= "<button onclick='expenseHeadEdit(" . $expenseHead->id . ")' id=edit_" . $expenseHead->id . "  class='btn btn-xs btn-hover-shine  btn-primary module-edit'><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion > 0) {
                $expenseHead['actions'] .= " <button onclick='expenseHeadDelete(" . $expenseHead->id . ")' id='delete_" . $expenseHead->id . "' class='btn btn-xs btn-hover-shine btn-danger' ><i class='fa fa-trash'></i></button>";
            }
            $return_arr[] = $expenseHead;

        }
        return json_encode(array('data' => $return_arr));
    }

    public function ExpensHeadcreateOrEdit(Request $request)
    {
        $admin_user_id = Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id, 73);

        // update
        if (!is_null($request->input('edit_id')) && $request->input('edit_id') != "") {
            $response_data = $this->editExpenseHead($request->all(), $request->input('edit_id'));
        } // new entry
        else {
            $response_data = $this->createExpenseHead($request->all());
        }
        return $response_data;
    }

    private function createExpenseHead($request)
    {
        //dd($request);
        try {
            $rule = [
                'expense_head_name' => 'required',

            ];
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                ExpenseHead::create([
                    'expense_head_name' => $request['expense_head_name'],
                    'expense_category_id' => $request['expense_category_id'],
                    'status' => (isset($request['is_active'])) ? 'Active': 'Inactive'
                ]);
                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Expense Head saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    private function editExpenseHead($request, $id)
    {
        try {
            if ($id == "") {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
            }
            $expneseHead = ExpenseHead::findOrFail($id);
            if (empty($expneseHead)) {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No Expense Head found"));
            }

            $rule = [
                'expense_head_name' => 'required',
            ];
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {

                DB::beginTransaction();
                $expneseHead->expense_head_name = $request['expense_head_name'];
                $expneseHead->expense_category_id = $request['expense_category_id'];
                $expneseHead->status = (isset($request['is_active'])) ? 'Active' : 'Inactive';
                $expneseHead->update();

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Expense Head Updated successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to update !" . $e->getMessage();
            return json_encode($return);
        }


    }

    public function showHead($id)
    {

        if ($id == "") return 0;
        $expenseHead = ExpenseHead::findOrFail($id);
        return json_encode(array('expneseHead' => $expenseHead));

    }

    public function destroyHead($id)
    {
        if ($id == "") {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
        }
        $expenseHead = ExpenseHead::findOrFail($id);
//        $is_deletable = (count($expenseHead->expensecategory)==0)?1:0; // 1:deletabe, 0:not-deletable
//        if(empty($expenseHead)){
//            return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Expense Head found"));
//        }
        try {
            DB::beginTransaction();
//            if($is_deletable){
            $expenseHead->delete();
            $return['message'] = "Expense Head Deleted successfully";
            // }
//            else{
//                $expenseHead->status = 'Inactive';
//                $expenseHead->update();
//                $return['message'] = "Deletation is not possible, but deactivated the Expense Head";
//            }

            DB::commit();
            $return['response_code'] = 1;

            return json_encode($return);
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to delete !" . $e->getMessage();
            return json_encode($return);
        }
    }

    // Expense Detail

    public function expenseDetailIndex()
    {
        $data['page_title'] = $this->page_title;
        $data['module_name'] = "Expenses";
        $data['sub_module'] = "Expenses";

        $data['parentExpneseHead'] = ExpenseHead::where('status','Active')->get();
        // action permissions
        $admin_user_id = Auth::user()->id;
        $add_action_id = 77;// Module Management
        $add_permisiion = $this->PermissionHasOrNot($admin_user_id, $add_action_id);
        $data['actions']['add_permisiion'] = $add_permisiion;
        return view('expense.expense_detail', $data);
    }

    public function ajaxExpenseDetailList()
    {
        $admin_user_id = Auth::user()->id;
        $edit_action_id = 79;
        $delete_action_id = 80;
        $edit_permisiion = $this->PermissionHasOrNot($admin_user_id, $edit_action_id);
        $delete_permisiion = $this->PermissionHasOrNot($admin_user_id, $delete_action_id);

        $expenseDetailList = Expense::with('expensehead','expenseHead.expensecategory','expenseHead.expensecategory.parent')->orderBy('created_at', 'desc')->get();
       // dd($expenseDetailList);
        $return_arr = array();
        foreach ($expenseDetailList as $expenseDetail) {
            $expenseDetail['expense_category_name'] = (is_null($expenseDetail->expensehead->expensecategory->parent)) ? $expenseDetail->expensehead->expensecategory->category_name:$expenseDetail->expensehead->expensecategory->parent->category_name." -> ".$expenseDetail->expensehead->expensecategory->category_name;
            $expenseDetail['expense_head_name'] = (is_null($expenseDetail->expense_head_id)) ? "" : $expenseDetail->expensehead->expense_head_name;
            $expenseDetail['status'] = ($expenseDetail->status == 'Active') ? "<button class='btn btn-xs btn-success' disabled>Active</button>" : "<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $expenseDetail['actions'] = "";


            $expenseDetail['actions']		=" <button title='View' onclick='expense_detail_view(".$expenseDetail->id.")' id='view_" . $expenseDetail->id . "' class='btn btn-xs btn-info btn-hover-shine admin-user-view' ><i class='lnr-eye'></i></button>";
            if ($edit_permisiion > 0) {
                $expenseDetail['actions'] .= " <button onclick='expenseDetailEdit(" . $expenseDetail->id . ")' id=edit_" . $expenseDetail->id . "  class='btn btn-xs btn-hover-shine  btn-primary module-edit'><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion > 0) {
                $expenseDetail['actions'] .= " <button onclick='expenseDetailDelete(" . $expenseDetail->id . ")' id='delete_" . $expenseDetail->id . "' class='btn btn-xs btn-hover-shine btn-danger' ><i class='fa fa-trash'></i></button>";
            }
            $return_arr[] = $expenseDetail;

        }
        return json_encode(array('data' => $return_arr));
    }

    public function ExpensDetailcreateOrEdit(Request $request)
    {

        $admin_user_id = Auth::user()->id;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id, 73);

        // update
        if (!is_null($request->input('edit_id')) && $request->input('edit_id') != "") {
            $response_data = $this->editExpenseDetail($request->all(), $request->input('edit_id'));
        } // new entry
        else {
            $response_data = $this->createExpenseDetail($request->all());
        }
        return $response_data;
    }

    private function createExpenseDetail($request)
    {
        //dd($request);
        try {
            $rule = [
                'expense_head_id' => 'required',
                'amount' => 'required',
				'expense_date' => 'required',
				
            ];
            $validation = \Validator::make($request, $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['response_code'] = 0;
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $Expense = Expense::create([
                    'expense_head_id'   => $request['expense_head_id'],
                    'amount'            => $request['amount'],
                    'details'           => $request['details'],
					'expense_date'      => $request['expense_date'],					
                    'payment_status'    => $request['payment_status'],
                    'status' => (isset($request['is_active'])) ? 'Active' : 'Inactive'
                ]);

              
                $photo = (isset($request['attachment']) && $request['attachment']!= "")?$request['attachment']:"";
                if ($photo!="") {
					$ext = $photo->getClientOriginalExtension();
                    $photoFullName = $photo->getClientOriginalName().time(). '.' . $ext;
                    $upload_path = 'assets/images/expense/';
                    $success = $photo->move($upload_path, $photoFullName);
					$Expense->attachment = $photoFullName;
					$Expense->update();
                }

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Expense Detail saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    private function editExpenseDetail($request, $id)
    {
        try {
            if ($id == "") {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
            }
            $expensedetail = Expense::findOrFail($id);
            if (empty($expensedetail)) {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No Expense Detail found"));
            }

            $rule = [
                'expense_head_id' => 'required',
                'amount' => 'required',
            ];
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {

                DB::beginTransaction();
                $expensedetail->expense_head_id = $request['expense_head_id'];
                $expensedetail->amount 			= $request['amount'];
				$expensedetail->expense_date 	= $request['expense_date'];
                $expensedetail->details 		= $request['details'];
                $expensedetail->payment_status 	= $request['payment_status'];
                $expensedetail->status 			= (isset($request['is_active'])) ? 'Active' : 'Inactive';
                $expensedetail->update();


                $photo = (isset($request['attachment']) && $request['attachment']!= "")?$request['attachment']:"";
                if ($photo != "") {
                    $old_image = $expensedetail->attachment;
                    $image_name = time();
                    $ext = $photo->getClientOriginalExtension();
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'assets/images/expense/';
                    $success = $photo->move($upload_path, $image_full_name);
                    $expensedetail->attachment = $image_full_name;
                    if(!is_null($old_image) && $expensedetail->attachment != $old_image){
                        File::delete($upload_path.$old_image); 
                    }
                }
                $expensedetail->update();

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Expense Head Updated successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to update !" . $e->getMessage();
            return json_encode($return);
        }


    }
    public function getDownload($id)
    {
        if ($id == "") return 0;
        $expenseDetail = Expense::findOrFail($id);
        $file='assets/images/expense/'.$expenseDetail->attachment;
        return response()->download($file);
    }
    public function showDetail($id)
    {
        if ($id == "") return 0;
         $expenseDetail = Expense::with('expenseHead','expenseHead.expensecategory','expenseHead.expensecategory.parent')->findOrFail($id);
        return json_encode(array('expense' => $expenseDetail));

    }

    public function destroyDetail($id)
    {
        if ($id == "") {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
        }
        $expenseDetail = Expense::findOrFail($id);
//        $is_deletable = (count($expenseHead->expensecategory)==0)?1:0; // 1:deletabe, 0:not-deletable
//        if(empty($expenseHead)){
//            return json_encode(array('response_code'=>0, 'errors'=>"Invalid request! No Expense Head found"));
//        }
        try {
            DB::beginTransaction();
//            if($is_deletable){
            $expenseDetail->delete();
            $return['message'] = "Expense Detail Deleted successfully";
            // }
//            else{
//                $expenseHead->status = 'Inactive';
//                $expenseHead->update();
//                $return['message'] = "Deletation is not possible, but deactivated the Expense Head";
//            }

            DB::commit();
            $return['response_code'] = 1;

            return json_encode($return);
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to delete !" . $e->getMessage();
            return json_encode($return);
        }
    }
	
	    public function expenseAutoComplete(Request $request){
		$term = $_REQUEST['term'];
		$user = Auth::user();
		$data = ExpenseHead::with('expensecategory', 'expensecategory.parent')
		       ->where([
                    ['status', '=', 'Active'],
                    ['expense_head_name','like','%'.$term.'%']
                ])->get();

		$data_count = $data->count();

		if($data_count>0){
			foreach ($data as $row) {
                $headName  = ($row['expensecategory']['parent']==null)?$row['expensecategory']['category_name'].' -> '. $row["expense_head_name"]:$row['expensecategory']['parent']['category_name']." -> ".$row['expensecategory']['category_name'].' -> '. $row["expense_head_name"];
				$json[] = array('id' => $row["id"],'label' => $headName);
			}
		}
		else {
			$json[] = array('id' => "0",'label' => "Not Found !!!");
		}
					//dd($json);
		return json_encode($json);

	}
	
}



