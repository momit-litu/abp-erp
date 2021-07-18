@extends('layout.master')
@section('content')


    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-head center-elem">
							<span class="d-inline-block pr-2">
								<i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
							</span>
                                <span class="d-inline-block">Students</span>
                            </div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a>
                                                <i aria-hidden="true" class="fa fa-home"></i>&nbsp;ABP
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{url('dashboard')}}">Dashboards</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a href="{{\Request::url()}}">
                                                {{isset($page_title) ? $page_title : ''}}
                                            </a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <button type="button" onclick='studentAdd()' title="Add a new Admin User" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
                            <i class="fa fa-plus"></i>
                            Add New Student
                        </button>
                    </div>
                </div>
            </div>
			<div class='row'>
				<div class='col-lg-12'>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="table table-bordered table-hover learners_table" id="students_table" style="width:100% !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Student No.</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact No. </th>
                          <!-- <th>Address </th>-->
                            <th class="hidden-xs">Status</th>
                            <th width='80' class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
				</div>
				<div class='col-lg-2'>
					
				</div>
			</div>
		</div>
    </div>
    </div>
    <div class="modal fade" id="entry-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="student_form" autocomplete="off" name="student_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label for="first_name" class="">Student Number</label>
                                                    <input type="text" id="student_no" name="student_no"  class="form-control col-lg-4"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label for="first_name" class="">Full Name<span class="required">*</span></label>
                                                    <input type="text" id="name" name="name" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Contact No (WhatsApp)<span class="required">*</span></label>
                                                    <input type="text" id="contact_no" name="contact_no" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Ememergency Contact</label>
                                                    <input type="text" id="emergency_contact" name="emergency_contact" class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Email<span class="required">*</span></label>
                                                    <input type="email" id="email" name="email" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Date of Birth <span class="required">*</span></label>
                                                    <input type="date" id="date_of_birth" name="date_of_birth" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>                                           
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>NID No</label>
                                                    <input type="text" id="nid" name="nid" class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Postal  Address<span class="required">*</span></label>
                                                    <input type="text" id="address" name="address" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="short_name" class="">Mode of Study </label>
                                                    <select id="study_mode" name="study_mode" class="form-control col-lg-12">
                                                    <option value="Online">Online</option>
                                                    <option value="Campus">Campus</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="short_name" class="">Last Qualification </label>
                                                    <select id="last_qualification" name="last_qualification" class="form-control col-lg-12">
                                                    <option value="Masters bachelor">Masters bachelor</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">                                            
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Passing Year</label>
                                                    <input type="date" id="passing_year" name="passing_year"  class="form-control col-lg-12"/>
                                                    <input type="text" class="form-control" data-toggle="datepicker-year">
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Current Employment</label>
                                                    <input type="text" id="current_emplyment" name="current_emplyment" class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="short_name" class="">How do you know ABP?</label>
                                                    <select id="how_know" name="how_know" class="form-control col-lg-12">
                                                    <option value='From a Trainee of ABP'>From a Trainee of ABP</option>
                                                    <option value='From FaceBook'>From FaceBook</option>
                                                    <option value='By google search'>By google search</option>
                                                    <option value='From office colleague'>From office colleague</option>
                                                    <option value='From Email'>From Email</option>
                                                    <option value='Other'>Other</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Is Active</label>
                                                    <input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label>Remarks</label>
                                                    <textarea rows="2" cols="100" id="remarks" name="remarks" class="form-control col-lg-12"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label>	<strong>Certificate, Transcript and NID</strong></label>
                                                <hr>
                                                <input type="file" class="form-control col-lg-12" name="documents[]"  data-show-upload="true" data-show-caption="true" id="documents" value="" multiple>
                                                <table class="mb-0 table table-bordered" id='attachment_table'>                                                
                                                </table>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-4">
                                                <label><strong> Student Photo</strong></label>
                                                <hr>
                                                <img src="{{asset('assets/images/user/admin')}}/no-user-image.png" width="70%" height="70%" class="img-thumbnail" id="user_image">
                                                <span class="btn btn-light-grey btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-picture-o"></i> </span>
                                                    <input type="file" class="form-control col-lg-12" name="user_profile_image" id="user_profile_image" value="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="form_submit_error" class="text-center" style="display:none"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="display: flex; flex-direction: row;">
                        <div class="col-md-3 text-left">
                                <button type="submit" id="save_student" class="btn btn-success  btn-lg btn-block">Save</button>
                        </div>
                        <div class="col-md-9 text-right">
                            <button type="button" id="clear_button" class="btn btn-warning">Clear</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('JScript')
<script type="text/javascript" src="{{ asset('assets/js/page-js/student/student.js')}}"></script>
@endsection