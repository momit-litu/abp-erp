<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StudentPayment;
use App\Traits\HasPermission;
use App\Traits\StudentNotification;
use Illuminate\Http\Request;
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
        $data['module_name']	= "Books";
        $data['sub_module']		= "Books Information";

        $admin_user_id  		= Auth::user()->id;
        $add_action_id  		= 116; // Payment entry
        $add_permisiion 		= $this->PermissionHasOrNot($admin_user_id,$add_action_id );
        $data['actions']['add_permisiion']= $add_permisiion;

        return view('book.book',$data);
    }
}
