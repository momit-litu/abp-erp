<?php

namespace App\Http\Controllers;

use App\Models\BatchBook;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use App\Models\StudentPayment;
use Illuminate\Support\Facades\DB;
use App\Traits\StudentNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BatchBookController extends Controller
{
    use HasPermission;
    use StudentNotification;
    public $studentPayment;
    public function __construct(Request $request)
    {
        $this->studentPayment =new StudentPayment();
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
    }

    public function index()
    {
        $data['page_title'] 	= $this->page_title;
        $data['module_name']	= "Courses";
        $data['sub_module']		= "Books";

        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 116; // Payment entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

        return view('course.book',$data);
    }

    
    
    public function saveBook(Request $request)
    {
        try {
            $rule = [
                'book_name' => 'required',	
                'batch_id' => 'required',		
            ];
            $validation = \Validator::make($request->all(), $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['response_code'] = 0;
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $data = [                   
                    'batch_id'  => $request['batch_id'],
                    'book_no'   => $request['book_name'],
                    'status' => (isset($request['status'])) ? 'Active' : 'Inactive'
                ];
                //dd($data);
                $batchBook = BatchBook::create($data);

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Book saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }
}
