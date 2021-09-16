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
									<div class="col-md-4 col-xs-6">
										<div class="row">
											<div class="col-md-12">
												<div class="bio-image">														
													<img src="{{ ($user->user_profile_image!="")? asset('assets/images/user/student/'.$user->user_profile_image):asset('assets/images/user/user.png') }}" class="img-thumbnail user_profile_img">
												</div>
											</div>
										</div>	
									</div>
									<div class="col-md-8  col-xs-6">
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
												<tr><td class="text-left"><i class='fa fa-phone'></i>{{$user->contact_no}}</td></tr>
												<tr><td class="text-left"><i class='fa fa-envelope'></i>{{$user->email}}</td></tr>
											</tbody>
										</table>
										<br>
										
										<br>
										<button class='btn btn-info' onclick='edit_profile()'>Edit Profile</button>
										<button class='btn btn-danger' onclick='change_password()'>Change Password</button>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="tab-pane show " id="edit_profile" role="tabpanel">						
						<form id="my_profile_form" name="my_profile_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<div class="row">
								<div class="col-md-9">
									<input type="hidden" name="edit_profile_id" id="edit_profile_id" value="{{$user->id}}">
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Full Name <span class="required">*</span></label>
												<input type="text" id="first_name" name="first_name" value="{{$user->first_name}}" required class="form-control col-lg-12"/>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Contact No. <span class="required">*</span></label>
												<input type="text" id="contact_no" name="contact_no" value="{{$user->contact_no}}" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="short_name" class="">Email</label>
												<input type="email" id="email" name="email" required value="{{$user->email}}" class="form-control col-lg-12"/>
											</div>
										</div>
									</div>						
									<br/>									
									<div class="ln_solid"></div>
								</div>
								<div class="col-md-3 text-center">									
									<img src="{{asset('assets/images/user')}}/{{ ($user->user_profile_image=="")?'user.png':$user->user_profile_image }}" width="70%" height="70%" class="img-thumbnail">
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
					<div class="tab-pane show" id="change_pass" role="tabpanel">
							<form id="change_password_form" autocomplete="off" name="change_password_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
								@csrf
								<div class="row">
									<div class="col-md-8">
										<input type="hidden" name="change_pass_id" id="change_pass_id"  value="{{$user->id}}">
										<div class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="company_name" class="">Current Password <span class="required">*</span></label>
													<input type="password" id="current_password" name="current_password" class="form-control col-lg-12"/>
												</div>
											</div>
										</div>
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
											<button type="button" id="cancle_admin_update" class="btn btn-danger hidden">Cancle</button>              
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
