<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use Auth;
use DB;


class CourseCategoryController extends Controller
{

    use HasPermission;

    public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;
        $this->view = '';
    }

    public function index()
    {
        //dd('sadfas');
        $data['page_title'] = $this->page_title;
        $data['module_name'] = "Course";
        $data['sub_module'] = "Course Category";

        // action permissions
        $admin_user_id = Auth::user()->id;
        $data['userType'] = Auth::user()->type;
        $add_action_id = 39; // TODO Student entry action id will replace by category entry id
        $add_permisiion = $this->PermissionHasOrNot($admin_user_id, $add_action_id);
        $data['actions']['add_permisiion'] = $add_permisiion;

        //dd($data);

        return view('courseCategory.index', $data);
    }

    //learnetr list by ajax
    public function showList()
    {
        //dd('sadfsadf');
        $admin_user_id = Auth::user()->id;
        $userType = Auth::user()->type;
        $edit_action_id = 40; // TODO Student edit action id will replace by category entry id
        $delete_action_id = 41; // TODO Student delete action id will replace by category entry id
        $edit_permisiion = $this->PermissionHasOrNot($admin_user_id, $edit_action_id);
        $delete_permisiion = $this->PermissionHasOrNot($admin_user_id, $delete_action_id);

        $Sql = CourseCategory::Select('id', 'title', 'description','status');

        $courseCategories = $Sql->orderBy('created_at', 'desc')->get();

        $return_arr = array();
        foreach ($courseCategories as $courseCategory) {
            $data['actions'] = "";
            $data['status'] = ($courseCategory->status == '1') ? "<button class='btn btn-xs btn-success' disabled>Active</button>" : "<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] = $courseCategory->id;
            $data['title'] = $courseCategory->title;
            $data['description'] = $courseCategory->description;

            $data['actions'] = "<button title='View' onclick='courseCategoryView(" . $courseCategory->id . ")' id='view_" . $courseCategory->id . "' class='btn btn-xs btn-info btn-hover-shine admin-user-view' ><i class='lnr-eye'></i></button>";
            if ($edit_permisiion > 0) {
                $data['actions'] .= "<button title='Edit' onclick='CourseCategoryEdit(" . $courseCategory->id . ")' id=edit_" . $courseCategory->id . " class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
            }
            if ($delete_permisiion > 0) {
                $data['actions'] .= " <button title='Delete' onclick='courseCategoryDelete(" . $courseCategory->id . ")' id='delete_" . $courseCategory->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
            }
            $return_arr[] = $data;
        }
        return json_encode(array('data' => $return_arr));
    }

    public function show($id)
    {
        if ($id == "") return 0;
        $courseCategory = CourseCategory::findOrFail($id);
        return json_encode(array('courseCategory' => $courseCategory));
    }

    public function destroy($id)
    {
        if ($id == "") {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
        }
        $courseCategory = CourseCategory::findOrFail($id);
        //dd($student);
        $is_deletable = /*(count($student->registrations) == 0)*/ true ? 1 : 0; // 1:deletabe, 0:not-deletable
        if (empty($courseCategory)) {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No Course Category found"));
        }
        try {
            DB::beginTransaction();
            if ($is_deletable) {
                $courseCategory->delete();
                $return['message'] = "Course Category Deleted successfully";
            } else {
                $courseCategory->status = 'Inactive';
                $courseCategory->update();
                $return['message'] = "Deletation is not possible, but deactivated the Course Category";
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


    public function createOrEdit(Request $request)
    {
        dd('asdfsaf');
        $admin_user_id = Auth::user()->id;
        $userType = Auth::user()->type;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id, 39); //TODO permission should have to update
        $update_permission = $this->PermissionHasOrNot($admin_user_id, 40); // TODO permission should have to update

        // update

        //dd($request);

        //dd($entry_permission, $update_permission);
        if (!is_null($request->input('id')) && $request->input('id') != "" && $update_permission) {

            $response_data = $this->editCourseCategory($request->all(), $request->input('id'));
        } // new entry
        else if ($entry_permission) {
            $response_data = $this->createCourseCategory($request->all());
        } else {
            $return['response_code'] = 0;
            $return['errors'] = "You are not authorized to insert a Course Category";
            $response_data = json_encode($return);
        }

        return $response_data;
    }


    private function createCourseCategory($request)
    {
        //dd($request);
        try {
            $rule = [
                'title' => 'required|string',
                'description' => 'required|string',
            ];
            $validation = \Validator::make($request, $rule);
            //dd('dsafjdsf', $request);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();


                $courseCategoryCreate = CourseCategory::create([
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'created_by' => Auth::user()->id,
                    'status' => (isset($request['status'])) ? 'Active' : 'Inactive'
                ]);
                //dd($student->id);

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Course Category saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    private function editCourseCategory($request, $id)
    {
        //dd($request);
        try {
            if ($id == "") {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
            }
            // if Student already is in a registration then need the hard update permission
            // only edopro admin can edit
            // $hardUpdate_permission = $this->PermissionHasOrNot($admin_user_id,42);
            $courseCategory = CourseCategory::findOrFail($id);

            if (empty($courseCategory)) {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No Course Category found"));
            }

            $rule = [
                'title' => 'required|string',
                'description' => 'required|string',
            ];
            $validation = \Validator::make($request, $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['result'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();

                $courseCategory->title = $request['title'];
                $courseCategory->description = $request['description'];
                $courseCategory->created_by = Auth::user()->id;

                $courseCategory->update();

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Course Category Updated successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to update !" . $e->getMessage();
            return json_encode($return);
        }
    }
}

