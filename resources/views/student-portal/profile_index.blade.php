@extends('student-portal.layout.master')
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
							<span class="d-inline-block">Profile Details</span>
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
				<!--<div class="page-title-actions">
					<button type="button" onclick='unitAdd()' title="Add a new Unit" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New Unit
					</button>
				</div>-->
			</div>
		</div>
		<ul class="tabs-animated-shadow tabs-animated nav">
			<li class="nav-item">
				<a role="tab" class="nav-link show active" id="my_profile_tab" data-toggle="tab" href="#my_profile_info_div" aria-selected="false">
					<span>My Profile</span>
				</a>
			</li>
			<li class="nav-item" id="edit_profile_menu_tab">
				<a role="tab" class="nav-link show "  data-toggle="tab" href="#edit_profile" id="edit_profile_tab" aria-selected="true">
					<span>Edit Profile</span>
				</a>
			</li>
			<li class="nav-item" id="change_pass_menu_tab">
				<a role="tab" class="nav-link show" href="#change_pass" id="change_password" data-toggle="tab"  aria-selected="false">
					<span>Change Password</span>
				</a>
			</li>
			<li class="nav-item" >
				<a role="tab" class="nav-link show "  data-toggle="tab" href="#all_notification_div" id="notification" aria-selected="true">
					<span>Notification</span>
				</a>
			</li>
		</ul>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<div class="tab-content">
					<!--MESSAGE-->
					<div class="col-md-12">
						<div id="form_submit_error" class="text-center" style="display:none"></div>
					</div>
					<!--END MESSAGE-->
					
					<div class="tab-pane show active" id="my_profile_info_div" role="tabpanel">
						<div class="container portfolio">
							<div class="bio-info">
								<div class="row">
									<div class="col-md-3 col-xs-6">
										<div class="row">
											<div class="col-md-12">
												<div class="bio-image">														
													<img src="{{ ($user->user_profile_image!="")? asset('assets/images/user/student/'.$user->user_profile_image):asset('assets/images/user/user.png') }}" class="img-thumbnail user_profile_img">
												</div>
											</div>
											<div class="col-md-12">
												<hr>
												<label><strong>Attached Document</strong></label><br>												
												<hr>												
												<table class="mb-0 table table-bordered" id='attachment_table'>
													@if(count($student->documents)>0)
														@foreach($student->documents as $document)
															<tr><td><input type='text' class='d-none' name='std_docs[]' value='{{$document->id}}' /> <a clas='formData' target='_blank'  href='/assets/images/student/documents/{{ $document->document_name }}' >{{ $document->document_name }}</a></td></tr>
														@endforeach
													@endif
												</table>
											</div>
										</div>	
									</div>
									<div class="col-md-4  col-xs-6">
										<h4>Personal Information</h4>
										<table class="table table-condensed table-hover">
											<tbody>
												<tr><td class="text-left"><b>{{$user->first_name.' '.$user->last_name}}</b></td></tr>
												<tr><td class="text-left">
													@if ($user->status==1)
													<button disabled class='btn btn-xs btn-success'>Active</button>
													@else
													<button disabled class='btn btn-xs btn-danger'>In-Active</button></td>
													@endif
												</tr>
												<tr><td>Registration Number : <b> {{ \Session::get('student_no') }}</b></td></tr>
												<tr><td class="text-left"><i class='fa fa-address-card fa-lg'></i>&nbsp;{{$student->nid_no}}</td></tr>
												<tr><td class="text-left"><i class='fa fa-calendar fa-lg'></i>&nbsp;{{$student->date_of_birth}}</td></tr>
												<tr><td class="text-left"><i class='fa fa-phone fa-lg'></i>&nbsp;{{$user->contact_no}}</td></tr>
												@if($student->emergency_contact)
												<tr><td class="text-left"><i class='fa fa-phone fa-lg'></i>&nbsp;{{$student->emergency_contact}}</td></tr>
												@endif
												<tr><td class="text-left"><i class='fa fa-envelope fa-lg'></i>&nbsp;{{$user->email}}</td></tr>
												<tr><td class="text-left"><i class='fa fa-map-marker fa-lg'></i>&nbsp;{{$student->address}}</td></tr>
											</tbody>
										</table>
										<br>
										
										<br>
										<button class='btn btn-info' onclick='edit_profile()'>Edit Profile</button>
										<a role="tab" class=" btn btn-danger" href="#change_pass" id="change_passwordd" data-toggle="tab"  aria-selected="false">Change Password</a>
									</div>
									<div class="col-md-5  col-xs-6">
										<h4>&nbsp;</h4>
										<table class="table table-condensed table-hover">
											<tbody>
												<tr><td>&nbsp;<b></b></td></tr>
												<tr><td>&nbsp;<b></b></td></tr>
												<tr><td>Study Mode : <b> {{$student->study_mode}}</b></td></tr>
												{{-- <tr><td>Enrollment Status : <b> {{$student->type}}</b></td></tr> --}}
												<tr><td>&nbsp;<b></b></td></tr>
												<tr><td>Last Qualification : <b> {{$student->last_qualification}}</b></td></tr>
												<tr><td>Passing Year : <b> {{$student->passing_year}}</b></td></tr>
												<tr><td>Current Emplyment : <b> {{$student->current_emplyment}}</b></td></tr>
												<tr><td>Current Designation : <b> {{$student->current_designation}}</b></td></tr>
											</tbody>
										</table>
										<br>										
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="tab-pane show " id="edit_profile" role="tabpanel">						
						<!--<form id="my_profile_form" name="my_profile_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">-->
						<form id="student_form" autocomplete="off" name="student_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$student->id}}">
                            <div class="row">                                
                                <div class="col-md-12">
                                   <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="first_name" class="">Student Number</label>
                                            <input type="text" id="student_no" disabled name="student_no" value="{{ $student->student_no}}"  class="form-control col-lg-4"/>
                                        </div>
                                    </div>
                                </div>                                
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label for="first_name" class="">Full Name<span class="required text-danger">*</span></label>
                                                <input type="text" id="name" name="name"  value="{{ $student->name}}" required class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Contact No (WhatsApp)<span class="required text-danger">*</span></label>
                                                <input type="text" id="contact_no" name="contact_no" value="{{ $student->contact_no}}" required class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Ememergency Contact<span class="required">*</span></label>
                                                <input required type="text" id="emergency_contact" value="{{ $student->emergency_contact}}" name="emergency_contact" class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Email<span class="required text-danger">*</span></label>
                                                <input type="email" id="student_email" name="student_email" value="{{ $student->email}}" required class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Date of Birth <span class="required">*</span></label>
                                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $student->date_of_birth}}" required class="form-control col-lg-12"/>
                                            </div>
                                        </div>                                           
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>NID No<span class="required">*</span></label>
                                                <input type="text" required id="nid" name="nid" value="{{ $student->nid_no}}" class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Address<span class="required">*</span>
													<a  data-toggle="tooltip" data-placement="top" title="Books will be sent on this address">
                                                        <i class="pe-7s-info"> </i>
                                                      </a>
												</label>
                                                <input type="text" id="student_address_field" value="{{ $student->address}}" name="student_address_field" required class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="short_name" class="">Last Qualification  <span class="required">*</span></label>
                                                <input type="hidden" id="last_qualification_id" value="{{ $student->last_qualification}}"/>
												<select id="last_qualification" name="last_qualification" class="form-control col-lg-12">
                                                    <option value="">Selecet last qualification</option>
													<option value="Bachelor (Engineering & Technology)">Bachelor (Engineering & Technology)</option>
                                                    <option value="Bachelor's">Bachelor's</option>
                                                    <option value="Diploma">Diploma</option>
													<option value="SSC">SSC</option>
                                                    <option value="HSC">HSC</option>
                                                    <option value="Doctorate">Doctorate</option>
                                                    <option value="Fazil">Fazil</option>
                                                    <option value="Kamil">Kamil</option>
                                                    <option value="Master of Philosopy">Master of Philosopy</option>
                                                    <option value="Master's">Master's</option>
                                                    <option value="Others">Others</option>
												</select>
                                            </div>
                                        </div>
										<div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Passing Year</label>
                                                <input  type="text"  id="passing_year" name="passing_year" value="{{ $student->passing_year}}"  class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Current Employment Company</label>
                                                <input type="text" id="current_emplyment" name="current_emplyment" value="{{ $student->current_emplyment}}" class="form-control col-lg-12"/>
                                            </div>
                                        </div>
										<div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label>Current Designation</label>
                                                <input type="text" id="current_designation" name="current_designation" value="{{ $student->current_designation}}" class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label>Remarks</label>
                                                <textarea rows="2" cols="100" id="remarks" name="remarks" value="{{ $student->remarks}}" class="form-control col-lg-12"></textarea>
                                            </div>
                                        </div>
                                    </div>
									
									
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>	<strong>Certificate, Transcript and NID</strong></label><br>
											<small class="text-danger">Maximum file size : 2mb</small><br>
                                            <small class="text-danger">You have to select all the documents at a time</small>
                                            <hr>
                                            <input type="file" class="form-control col-lg-12" name="documents[]"  data-show-upload="true" data-show-caption="true" id="documents" value="" multiple>
                                            <table class="mb-0 table table-bordered" id='attachment_table'>
												@if(count($student->documents)>0)
													@foreach($student->documents as $document)
														<tr>
															<td>
																<input type='text' class='d-none' name='std_docs[]' value='{{$document->id}}' /> 
																	<a clas='formData' target='_blank'  href="{{ asset('assets') }}/images/student/documents/{{ $document->document_name }}" >{{ $document->document_name }}</a>
															</td>
															<td width='50'>
																<button class='border-0 btn-transition btn btn-outline-danger remove-doc' >
																	<i class='fa fa-trash-alt'></i>
																</button>
															</td>
														</tr>
													@endforeach
												@endif
                                            </table>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-4">
                                            <label><strong> Student Photo</strong></label><br>
											<small class="text-danger">Maximum Image size : 2mb, Image type : (jpeg,jpg,png)</small><br>
                                            <hr>
                                            <img src="{{asset('assets/images/user/student')}}/{{ ($student->user_profile_image)?$student->user_profile_image:'user.png'}}" width="70%" height="70%" class="img-thumbnail" id="user_image">
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
                                    <div id="student_form_submit_error" class="text-center" style="display:none"></div>
                                </div>
                            </div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
								<div class="col-md-4 col-sm-4 col-xs-12">				
									<button type="submit" id="update_student_profile_info" class="btn btn-success">Update</button>                                       
									<button type="button" id="Cancel_admin_update" class="btn btn-danger hidden">Cancel</button>              
								</div>
							</div>
                         </form>
					</div>
					<div class="tab-pane show" id="change_pass" role="tabpanel">
							<form id="change_password_form" autocomplete="off" name="change_password_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
								@csrf
								<div class="row">
									<div class="col-md-8">
										<input type="hidden" name="change_pass_id" id="change_pass_id"  value="{{$user->id}}">
										<!--<div class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="company_name" class="">Current Password <span class="required">*</span></label>
													<input type="password" id="current_password" name="current_password" class="form-control col-lg-12"/>
												</div>
											</div>
										</div>-->
										<div class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="short_name" class="">New  Password</label>
													<input type="password" id="new_password" name="new_password" class="form-control col-lg-12"/>
												</div>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="short_name" class="">Confirm  Password</label>
													<input type="password" id="confirm_password" name="confirm_password" class="form-control col-lg-12"/>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<button type="submit" id="update_password" class="btn btn-success">Update Password</button>                   
											<button type="button" id="Cancel_admin_update" class="btn btn-danger hidden">Cancel</button>              
										</div>
									</div>							
								</div>
							</form>		

					</div>
					<div class="tab-pane show" id="all_notification_div" role="tabpanel">
						<div class="panel panel-default">
							<div class="panel-body">
								<table class="table table-bordered table-hover notification_table" id="notification_table" style="width:100% !important"> 
									<thead>
										<tr>
											<th>Message</th>
											<th class="text-center" width="100">Date</th>
											<th class="text-center" width='80'>Status</th>						
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
		</div>
	</div>
</div>
</div>
 
@endsection

@section('JScript')
	<script src="{{ asset('assets/js/page-js/admin/profile.js')}}"></script>
@endsection
