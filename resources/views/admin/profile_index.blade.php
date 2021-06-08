@extends('layout.master')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bils/profile.css') }}">
	<style type="text/css" media="screen">
		hr{
			margin:0;
		}
	</style>
@endsection
@section('content')

	<!--MESSAGE-->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div id="form_submit_error" class="text-center" style="display:none"></div>
	</div>
	<!--END MESSAGE-->

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="my_profile_tab" data-toggle="tab" href="#my_profile_info_div">
                           <b> My Profile</b>
                        </a>
                    </li>
                    <li class="hidden" id="edit_profile_menu_tab">
                        <a data-toggle="tab" href="#edit_profile" id="edit_profile_tab">
                           <b> Edit Profile</b>
                        </a>
                    </li>
                    <li class="hidden" id="change_pass_menu_tab">
                        <a data-toggle="tab" href="#change_pass" id="change_pass_tab">
                           <b> Change Password</b>
                        </a>
                    </li>
					<li>
                        <a id="notification_tab" data-toggle="tab" href="#all_notification_div">
                           <b>Notifications</b>
                        </a>
                    </li>
                </ul>
				
                <div class="tab-content">
                    <!-- PANEL FOR OVERVIEW-->
                    <div id="my_profile_info_div" class="tab-pane in active">
						<div class="row no-margin-row">
							<div class="container portfolio">
								<div class="bio-info">
									<div class="row">
										<div class="col-md-4 col-xs-6">
											<div class="row">
												<div class="col-md-12">
													<div class="bio-image">														
														<img src="{{asset('assets/images/user/admin')}}/{{ ($user->user_profile_image=="")?'no-user-image.png':$user->user_profile_image }}" class="img-thumbnail user_profile_img">
													</div>
												</div>
											</div>	
										</div>
										<div class="col-md-4  col-xs-6">
											<table class="table table-condensed table-hover">
												<thead>
												<tr><th>Personal Information</th></tr>
												</thead>
												<tbody>
													<tr><td class="text-left"><b>{{$user->first_name.' '.$user->last_name}}</b></td></tr>
													<tr><td class="text-left">
														@if ($user->status==1)
														<button disabled class='btn btn-xs btn-success'>Active</button>
														@else
														<button disabled class='btn btn-xs btn-danger'>In-Active</button></td>
														@endif
													</tr>
													<tr><td class="text-left"><i class='fa fa-phone'></i>{{$user->contact_no}}</td></tr>
													<tr><td class="text-left"><i class='fa fa-envelope'></i>{{$user->email}}</td></tr>
												
													<tr><td class="text-left">Details: {{$user->remarks}}</td></tr>
												</tbody>
											</table>
											<br>
											
											<br>
											<button class='btn btn-info' onclick='edit_profile()'>Edit Profile</button>
											<button class='btn btn-danger' onclick='change_password()'>Change Password</button>
										</div>
										<div class="col-md-4  col-xs-6 text-left">
											@if($qualifications != "")
												<h4>Approved Qualification list:</h4>
												<ul class="list-unstyled">
												@foreach ($qualifications as $qualification)
													 <li><b> >> {{"(".$qualification->code.") ".$qualification->title}}</b></li>
												@endforeach
												</ul>
											@endif
										</div>
									</div>	
								</div>
							</div>
                        </div>
                    </div>
                    <!--END PANEL FOR OVERVIEW -->
                    <div id="all_notification_div" class="tab-pane in">
						<div class="row no-margin-row">
							<!-- List of Categories -->
							<div class="panel panel-default">
								<div class="panel-body">
									<table class="table table-bordered table-hover notification_table" id="notification_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>Message</th>
												<th class="text-center" style="width:150px !important">Date</th>
												<th class="hidden-xs" style="width:120px !important">Status</th>
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
                    <!-- PANEL FOR CHANGE PASSWORD -->
                    <div id="edit_profile" class="tab-pane in">
                        <div class="row no-margin-row">
							<form id="my_profile_form" name="my_profile_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
								@csrf
								<div class="row">
								<div class="col-md-9">
									<input type="hidden" name="edit_profile_id" id="edit_profile_id" value="{{$user->id}}">
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">First Name<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="first_name" name="first_name" value="{{$user->first_name}}" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Last Name</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="last_name" name="last_name" value="{{$user->last_name}}" class="form-control col-lg-12" />
										</div>
									</div>
								<!--	<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Designation</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="designation_name" name="designation_name"  class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Department</label>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<input type="text" id="department_name" name="department_name"  class="form-control col-lg-12"/>
										</div>						
									</div>  -->
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Contact No<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="contact_no" name="contact_no" value="{{$user->contact_no}}" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Email<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="email" id="email" name="email" required value="{{$user->email}}" class="form-control col-lg-12"/>
										</div>
									</div>
									<!--<div class="form-group"> 
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Address</label>
										<div class="col-md-10 col-sm-10  col-xs-6">
											<input type="text" id="address" name="address" class="form-control col-lg-12" />
										</div>
									</div>-->	
									<br/>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Remarks</label>
										<div class="col-md-10 col-sm-10 col-xs-12">
											<textarea rows="2" cols="100" id="remarks" name="remarks" value="{{$user->remarks}}" class="form-control col-lg-12"></textarea> 
										</div>
									</div>
									<div class="ln_solid"></div>
								</div>
								<div class="col-md-3 text-center">									
									<img src="{{asset('assets/images/user/admin')}}/{{ ($user->user_profile_image=="")?'no-user-image.png':$user->user_profile_image }}" width="70%" height="70%" class="img-thumbnail">
									<span class="btn btn-light-grey btn-file">
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Update image</span>
										<input type="file" name="user_profile_image" id="user_profile_image" value="">
									</span>
								</div>
								</div>
								<div class="form-group">
									<input type="hidden" name="id" id="id">
								<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
								<div class="col-md-4 col-sm-4 col-xs-12">									
									
									<button type="submit" id="update_profile_info" class="btn btn-success">Update</button>                                       
									<button type="button" id="cancle_admin_update" class="btn btn-danger hidden">Cancle</button>              
								</div>
								 
							</div>
							</form>		
                        </div>
                    </div>
                    <!-- END PANEL FOR CHANGE PASSWORD -->

                    <div id="change_pass" class="tab-pane in">
                        <div class="row no-margin-row">
							<form id="change_password_form" name="change_password_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
								@csrf
								<div class="row">
									<div class="col-md-9">
										<input type="hidden" name="change_pass_id" id="change_pass_id"  value="{{$user->id}}">
										<div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-6">Current Password<span class="required">*</span></label>
											<div class="col-md-4 col-sm-4 col-xs-6">
												<input type="password" id="current_password" name="current_password" class="form-control col-lg-12"/>
											</div>
											
										</div>
										  
										<div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-6">New Password<span class="required">*</span></label>
											<div class="col-md-4 col-sm-4 col-xs-6">
												<input type="password" id="new_password" name="new_password" class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="form-group"> 
											<label class="control-label col-md-2 col-sm-2 col-xs-6">Confirm Password<span class="required">*</span></label>
											<div class="col-md-4 col-sm-4 col-xs-6">
												<input type="password" id="confirm_password" name="confirm_password" class="form-control col-lg-12"/>
											</div>
										</div>
									</div>
								
								</div>
								<div class="form-group">
									
								<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<button type="submit" id="update_password" class="btn btn-success">Update Password</button>                   
									<button type="button" id="cancle_admin_update" class="btn btn-danger hidden">Cancle</button>              
								</div>
								 
							</div>
							</form>		
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!--END PAGE CONTENT-->
    
@endsection


@section('JScript')

	<script>
		var profile_image_url = "<?php echo asset('assets/images/user/admin'); ?>";
	</script>

	<script src="{{ asset('assets/js/page-js/admin/profile.js')}}"></script>

@endsection


