<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use DB;
use Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use App\Traits\HasPermission;
use App\Models\StudentDocument;
use App\Models\UserGroupMember;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;


class StudentController extends Controller
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
        $data['page_title'] = $this->page_title;
        $data['module_name'] = "Students";
        $data['sub_module'] = "Students";

        // action permissions
        $admin_user_id = Auth::user()->id;
        $data['userType'] = Auth::user()->type;
        $add_action_id = 39; // Student entry
        $add_permisiion = $this->PermissionHasOrNot($admin_user_id, $add_action_id);
        $data['actions']['add_permisiion'] = $add_permisiion;

        //dd($data);

        return view('student.index', $data);
    }

    //learnetr list by ajax
    public function showList()
    {
        $admin_user_id = Auth::user()->id;
        $userType = Auth::user()->type;
        $edit_action_id = 40; // Student edit
        $delete_action_id = 41; // Student delete
        $edit_permisiion = $this->PermissionHasOrNot($admin_user_id, $edit_action_id);
        $delete_permisiion = $this->PermissionHasOrNot($admin_user_id, $delete_action_id);

        $studentSql = Student::Select('id', 'name','student_no', 'email', 'contact_no', 'address', 'nid_no', 'user_profile_image', 'remarks', 'status');

        $students = $studentSql->orderBy('created_at', 'desc')->get();

        $return_arr = array();
        foreach ($students as $student) {
            $data['actions'] = "";
            $data['status'] = ($student->status == 'Active') ? "<button class='btn btn-xs btn-success' disabled>Active</button>" : "<button class='btn btn-xs btn-danger' disabled>Inactive</button>";
            $data['id'] = $student->id;
            $data['first_name'] = $student->name;
            $data['student_no'] = $student->student_no;
            $data['email'] = $student->email;
            $data['contact_no'] = $student->contact_no;
            //$data['address'] = $student->address;
            //dd( $student->id;die;
            $image_path = asset('assets/images/student');
            $data['user_profile_image'] = ($student->user_profile_image != "" || $student->user_profile_image != null) ? '<img height="40" width="50" src="' . $image_path . '/' . $student->user_profile_image . '" alt="image" />' : '<img height="40" width="50" src="' . $image_path . '/no-user-image.png' . '" alt="image" />';


			$data['actions']		=" <button title='View' onclick='studentView(".$student->id.")' id='view_" . $student->id . "' class='btn btn-xs btn-info btn-hover-shine admin-user-view' ><i class='lnr-eye'></i></button>";
			if($edit_permisiion>0){
				$data['actions'] 	.=" <button title='Edit' onclick='studentEdit(".$student->id.")' id=edit_" . $student->id . " class='btn btn-xs btn-hover-shine  btn-primary' ><i class='lnr-pencil'></i></button>";
			}
			if ($delete_permisiion > 0) {
					$data['actions'] .=" <button title='Delete' onclick='studentDelete(".$student->id.")' id='delete_" . $student->id . "' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button>";
			}


            $return_arr[] = $data;
        }
        return json_encode(array('data' => $return_arr));
    }

    public function show($id)
    {
        if ($id == "") return 0;
        $student = Student::with('documents')->findOrFail($id);
        return json_encode(array('student' => $student));
    }

    public function destroy($id)
    {
        if ($id == "") {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
        }
        $student = Student::with('documents','user')->findOrFail($id);
        //dd($student);
        $is_deletable = /*(count($student->registrations) == 0)*/ true ? 1 : 0; // 1:deletabe, 0:not-deletable
        if (empty($student)) {
            return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No student found"));
        }
        try {
            DB::beginTransaction();
            if ($is_deletable) {
                if(!empty($student->documents)){
                    foreach($student->documents as $deletedSDoc){
                        $path = 'assets/images/student/documents/';
                        File::delete($path.$deletedSDoc->document_name);
                        $deletedSDoc->delete();
                    }
                }
                if($student->user_profile_image != null){
                    $path = 'assets/images/student/';
                    File::delete($path.$student->user_profile_image);
                }

                $user = User::where('student_id',$student->id)->firstOrFail();
                UserGroupMember::where('user_id',$user->id)->delete();
                $user->delete();
                $student->delete();
                $return['message'] = "Student Deleted successfully";
                $return['response_code'] = 1;
            } else {
                $student->status = 'Inactive';
                $student->update();
                $return['message'] = "Deletation is not possible, but deactivated the student";
                $return['response_code'] = 0;
            }
            DB::commit();
            return json_encode($return);
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['message'] = "Failed to delete !" . $e->getMessage();
            return json_encode($return);
        }

    }

    public function studentAutoComplete()
    {
        $term = $_REQUEST['term'];

        $data = Student::select('id', 'first_name', 'last_name', 'email')
            ->where([
                ['status', '=', 'Active'],
                ['first_name', 'like', '%' . $term . '%']
            ])
            ->orwhere([
                ['status', '=', 'Active'],
                ['last_name', 'like', '%' . $term . '%']
            ])
            ->orwhere([
                ['status', '=', 'Active'],
                ['email', 'like', '%' . $term . '%']
            ])
            ->get();


        $data_count = $data->count();

        if ($data_count > 0) {
            foreach ($data as $row) {
                $json[] = array('id' => $row["id"], 'label' => $row["first_name"] . " " . $row["last_name"] . " (" . $row["email"] . ")");
            }
        } else {
            $json[] = array('id' => "0", 'label' => "Not Found !!!");
        }
        return json_encode($json);

    }

    public function createOrEdit(Request $request)
    {
        $admin_user_id = Auth::user()->id;
        $userType = Auth::user()->type;
        $entry_permission = $this->PermissionHasOrNot($admin_user_id, 39);
        $update_permission = $this->PermissionHasOrNot($admin_user_id, 40);

        if (!is_null($request->input('id')) && $request->input('id') != "" && $update_permission) {
            $response_data = $this->editStudent($request->all(), $request->input('id'), $request->file('user_profile_image') , $request->file('documents') );
        } // new entry
        else if ($entry_permission) {
            $response_data = $this->createStudent($request->all(), $request->file('user_profile_image'), $request->file('documents') );
        } else {
            $return['response_code'] = 0;
            $return['errors'] = "You are not authorized to insert a student";
            $response_data = json_encode($return);
        }

        return $response_data;
    }


    private function createStudent($request, $photo, $documents)
    {
        try {
            $rule = [
                'name' => 'required|string',
                'date_of_birth' => 'required',
                'address' => 'required',
                'contact_no' => 'Required|max:13',
                'email' => 'Required|email',
                'user_profile_image' => 'mimes:jpeg,jpg,png,svg|max:5000',
                'documents.*' => 'max:5000',
            ];
            $validation = \Validator::make($request, $rule);

            if ($validation->fails()) {
                $return['response_code'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $emailVerification = Student::where('email', $request['email'])->first();
                if (isset($emailVerification->id)) {
                    $return['response_code'] = "0";
                    $return['errors'][] = $request['email'] . " is already exists";
                    return json_encode($return);
                }

                $profileImage = "";
                $StudentImage = $photo;

                if (isset($StudentImage)) {
                    $image_name = time();
                    $ext = $StudentImage->getClientOriginalExtension();
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'assets/images/student/';
                    $success = $StudentImage->move($upload_path, $image_full_name);
                    $profileImage = $image_full_name;
                }

                // save the student
                $student = Student::create([
                    'name' => $request['name'],
                    'student_no' => $request['student_no'],
                    'email' => $request['email'],
                    'contact_no' => $request['contact_no'],
                    'emergency_contact' => $request['emergency_contact'],
                    'address' => $request['address'],
                    'nid_no' => $request['nid'],
                    'date_of_birth' => $request['date_of_birth'],
                    'study_mode' => $request['study_mode'],
                    'remarks' => $request['remarks'],
                    'current_emplyment' => $request['current_emplyment'],
                    'last_qualification' => $request['last_qualification'],
                    'how_know' => $request['how_know'],
                    'passing_year' => $request['passing_year'],
                    'user_profile_image' => $profileImage,
                    'status' => (isset($request['status'])) ? 'Active' : 'Inactive'
                ]);

                // create a student type user
                $studentUser = User::create([
					'first_name'	=> $request['name'],
					'contact_no'	=> $request['contact_no'],
					'email'			=> $request['email'],
					'password' 		=> bcrypt('1234'),
					'type'			=> 'Student',
					'student_id'	=> $student->id,
				]);

                //insert student user group permission
				$user_groups = UserGroup::select('id')->where('type',2)->get();
				foreach ($user_groups as $user_group ) {
					$group_member_data 				= new UserGroupMember();
					$group_member_data->group_id	= $user_group['id'];
					$group_member_data->user_id		= $studentUser->id;
					$group_member_data->status		= 1;
					$group_member_data->save();
				}

                if (isset($documents) && !empty($documents)) {
                    foreach($documents as $document) {
                        $ext = $document->getClientOriginalExtension();
                        $documentFullName = $document->getClientOriginalName().time(). '.' . $ext;
                        $upload_path = 'assets/images/student/documents/';
                        $success = $document->move($upload_path, $documentFullName);

                        $studentDocument = StudentDocument::create([
                            'student_id'	=> $student->id,
                            'document_name'	=> $documentFullName,
                            'type'	        => $ext,
                        ]);
                    }
                }

                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Student saved successfully";
                return json_encode($return);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['response_code'] = 0;
            $return['errors'] = "Failed to save !" . $e->getMessage();
            return json_encode($return);
        }
    }

    private function editStudent($request, $id, $photo, $documents)
    {
        //dd($request);
        try {
            if ($id == "") {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! "));
            }
            // if Student already is in a registration then need the hard update permission
            // only edopro admin can edit
            // $hardUpdate_permission = $this->PermissionHasOrNot($admin_user_id,42);
            $student = Student::with('documents','user')->findOrFail($id);
            $user = User::where('student_id',$id)->firstOrFail();
            $oldDoc  =json_decode(json_encode($request['std_docs']), true) ;

            if (empty($student)) {
                return json_encode(array('response_code' => 0, 'errors' => "Invalid request! No student found"));
            }

            $rule = [
                'name' => 'required|string',
                'date_of_birth' => 'required',
                'address' => 'required',
                'contact_no' => 'Required|max:13',
                'email' => 'Required|email',
                'user_profile_image' => 'mimes:jpeg,jpg,png,svg|max:5000',
                'documents.*' => 'max:5000',
            ];
            $validation = \Validator::make($request, $rule);
            //dd($request);

            if ($validation->fails()) {
                $return['result'] = "0";
                $return['errors'] = $validation->errors();
                return json_encode($return);
            } else {
                DB::beginTransaction();
                $currentStatus 		= $student->status;

                $emailVerification = Student::where([['email', $request['email']], ['id', '!=', $id]])->first();
                if (isset($emailVerification->id)) {
                    $return['response_code'] = "0";
                    $return['errors'][] = $request['email'] . " is already exists";
                    return json_encode($return);
                }

                $student->student_no = $request['student_no'];
                $student->name = $request['name'];
                $student->email = $request['email'];
                $student->contact_no = $request['contact_no'];
                $student->emergency_contact = $request['emergency_contact'];
                $student->address = $request['address'];
                $student->nid_no = $request['nid'];
                $student->date_of_birth = $request['date_of_birth'];
                $student->study_mode = $request['study_mode'];
                $student->current_emplyment = $request['current_emplyment'];
                $student->last_qualification = $request['last_qualification'];
                $student->how_know = $request['how_know'];
                $student->passing_year = $request['passing_year'];
                $student->status = (isset($request['status'])) ? "Active" : 'Inactive';
                $student->update();

                $user->first_name = $request['name'];
                $user->email = $request['email'];
                $user->contact_no = $request['contact_no'];
                $user->remarks = $request['remarks'];
                $user->status = (isset($request['status'])) ? "Active" : 'Inactive';

                $StudentImage = $photo;
                if (isset($StudentImage) && $StudentImage!="") {
                    $old_image = $student->user_profile_image;
                    $image_name = time();
                    $ext = $StudentImage->getClientOriginalExtension();
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'assets/images/student/';
                    $success = $StudentImage->move($upload_path, $image_full_name);
                    $student->user_profile_image = $image_full_name;
                    $user->user_profile_image = $image_full_name;
                    if(!is_null($old_image) && $user->user_profile_image != $old_image){
                        File::delete($upload_path.$old_image);
                    }
                }
                $student->update();
                $user->update();

                if (isset($documents) && !empty($documents)) {
                    foreach($documents as $document) {
                        $ext = $document->getClientOriginalExtension();
                        $documentFullName = $document->getClientOriginalName().time(). '.' . $ext;
                        $upload_path = 'assets/images/student/documents/';
                        $success = $document->move($upload_path, $documentFullName);

                        $studentDocument = StudentDocument::create([
                            'student_id'	=> $student->id,
                            'document_name'	=> $documentFullName,
                            'type'	        => $ext,
                        ]);
                    }
                }



                $deletedSDocs = $student->documents->except($oldDoc);
                foreach($deletedSDocs as $deletedSDoc){
                    $path = 'assets/images/student/documents/';
                    File::delete($path.$deletedSDoc->document_name);
                    $deletedSDoc->delete();
                }


                DB::commit();
                $return['response_code'] = 1;
                $return['message'] = "Student Updated successfully";
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
