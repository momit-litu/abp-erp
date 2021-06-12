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
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="table table-bordered table-hover learners_table" id="students_table" style="width:100% !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact No. </th>
                            <th>Address </th>
                            <th class="hidden-xs">Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                                    <div class="col-md-9">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="first_name" class="">First Name<span class="required">*</span></label>
                                                    <input type="text" id="first_name" name="first_name" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="last_name" class="">Last Name</label>
                                                    <input type="text" id="last_name" name="last_name" class="form-control col-lg-12" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Contact No<span class="required">*</span></label>
                                                    <input type="text" id="contact_no" name="contact_no" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Email<span class="required">*</span></label>
                                                    <input type="email" id="email" name="email" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>NID No<span class="required">*</span></label>
                                                    <input type="text" id="nid" name="nid" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Address<span class="required">*</span></label>
                                                    <input type="text" id="address" name="address" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Date of Birth <span class="required">*</span></label>
                                                    <input type="date" id="date_of_birth" name="date_of_birth" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Is Active</label>
                                                    <input type="checkbox" id="is_active" name="is_active" checked="checked" value="1" class="form-control col-lg-12"/>
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
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <img src="{{asset('assets/images/user/admin')}}/no-user-image.png" width="70%" height="70%" class="img-thumbnail" id="user_image">

                                        <span class="btn btn-light-grey btn-file">
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span>
										<input type="file" name="user_profile_image" id="user_profile_image" value="">
									</span>
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

   {{-- <div class="app-main__outer">

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-md-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="admin_user_list_button" data-toggle="tab" href="#user_list_div">
                           <b> Student List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" href="#entry_form_div" id="admin_user_add_button">
	                           <b> Add Student</b>
	                        </a>
	                    </li>
                    @endif
                </ul>
                <div class="tab-content">
				<!-- PANEL FOR OVERVIEW-->
					<div id="user_list_div" class="tab-pane in active">
						<div class="row no-margin-row">
							<!-- List of Categories -->
							<div class="panel panel-default">
								<div class="panel-body">
									<table class="table table-bordered table-hover learners_table" id="students_table" style="width:100% !important">
										<thead>
											<tr>
												<th>ID</th>
												<th></th>
												<th>Centre Name </th>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Email</th>
												<th>Contact No. </th>
												<th>Address </th>
												<th class="hidden-xs">Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<!-- END Categoreis -->
						</div>
					</div>
                    <!--END PANEL FOR OVERVIEW -->

                    <!-- PANEL FOR CHANGE PASSWORD -->
                    <div id="entry_form_div" class="tab-pane in">
                        <div class="row no-margin-row">
							<form id="student_form" name="student_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-9">
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">First Name<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="first_name" name="first_name" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Last Name</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="last_name" name="last_name" class="form-control col-lg-12" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Contact No. <span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="contact_no" name="contact_no" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Email<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="email" id="email" name="email" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Address</label>
										<div class="col-md-10 col-sm-10  col-xs-6">
											<input type="text" id="address" name="address" class="form-control col-lg-12" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">National ID No. </label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="nid_no" name="nid_no"  class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Date of Birth</label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="date" id="date_of_birth" name="date_of_birth"  class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Active?</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="checkbox" id="status" name="status" checked="checked"  class="form-control col-lg-12"/>
										</div>
									</div>
									<br/>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Remarks</label>
										<div class="col-md-10 col-sm-10 col-xs-12">
											<textarea rows="2" cols="100" id="remarks" name="remarks" class="form-control col-lg-12"></textarea>
										</div>
									</div>
									<div class="ln_solid"></div>
								</div>
								<div class="col-md-3 text-center">
									<img src="{{asset('assets/images/user/admin')}}/no-user-image.png" width="70%" height="70%" class="img-thumbnail" id="user_image">

									<span class="btn btn-light-grey btn-file">
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span>
										<input type="file" name="user_profile_image" id="user_profile_image" value="">
									</span>
								</div>
							</div>
							<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								@if($actions['add_permisiion']>0)
									<button type="submit" id="save_student" class="btn btn-success">Save</button>
									<button type="button" id="clear_button" class="btn btn-warning">Clear</button>
									<button type="button" id="cancel_button" class="btn btn-danger">Cancel</button>
								@endif
							</div>
						</div>
						</form>
                        </div>
                    </div>
                    <!-- END PANEL FOR CHANGE PASSWORD -->
                </div>
            </div>
        </div>
    </div>
    </div>--}}
    <!--END PAGE CONTENT-->
@endsection
@section('JScript')
<script>
	const student_image_url = "<?php echo asset('assets/images/student'); ?>";
	const user_type = "<?php echo $userType; ?>";
</script>
<script type="text/javascript" src="{{ asset('assets/js/page-js/student/student.js')}}"></script>
<script>


    const editAddForm = $('.edit-add-form');
    editAddForm.validate({
        errorElement: "em",
        onkeyup: false,
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            element.parents(".form-group").addClass("has-feedback");

            if (element.parents(".form-group").length) {
                error.insertAfter(element.parents(".form-group").first().children().last());
            } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            $(element).closest('.help-block').remove();
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
        },
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true,
               // pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
            },

            institute_id: {
                required: true,
            },
            course_fee: {
                required: true,
                min: 1
            },
            cover_image: {
                accept: "image/*",
            },
            description: {
                required: true,
            },
            eligibility: {
                required: true,
            },
            prerequisite: {
                required: true,
            },


        },
        messages: {
            title_bn: {
                pattern: "This field is required in Bangla.",
            },
            code: {
                remote: "Code already in use!",
            }
        },
        submitHandler: function (htmlForm) {
            $('.overlay').show();
            htmlForm.submit();
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $(input).parent().find('.avatar-preview img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $(document).ready(function () {
        $('#cover_image').change(function () {
            readURL(this); //preview image
            editAddForm.validate().element("#cover_image");
        });
    })
</script>

@endsection


