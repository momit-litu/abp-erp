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
							<span class="d-inline-block">Admin User Management</span>
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
					<button type="button" onclick='adminUserAdd()' title="Add a new Admin User" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New  Admin User
					</button>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover admin_user_table" id="admin_user_table" style="width:100% !important">
					<thead>
						<tr>
							<th width="100">Photo</th>
							<th width="">Name</th>
							<th width="">Email </th>
							<th width="">Groups </th>
							<th class="hidden-xs" width="10%">Status</th>
							<th width="80">Actions</th>
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Admin User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="admin_user_form" autocomplete="off" name="admin_user_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="id" id="id">
							<div class="row">
								<div class="col-md-9">
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">First Name<span class="required">*</span></label>
												<input type="text" id="first_name" name="first_name" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="short_name" class="">Last Name</label>
												<input type="text" id="last_name" name="last_name" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
								<!--
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Designation</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="designation_name" name="designation_name"  class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Department</label>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<input type="text" id="department_name" name="department_name"  class="form-control col-lg-12"/>
										</div>
									</div>
								-->
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
									<!--<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Address</label>
										<div class="col-md-10 col-sm-10  col-xs-6">
											<input type="text" id="address" name="address" class="form-control col-lg-12" />
										</div>
									</div>-->
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label>Password (Default: 1234)</label>
												<input type="password" id="password" name="password"  class="form-control col-lg-12"/>
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
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label>Select Admin Group</label>
										<div id="group_select" class="col-md-12"></div>
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
						@if($actions['add_permisiion']>0)
						<button type="submit" id="save_admin_info" class="btn btn-success  btn-lg btn-block">Save</button>

					@endif
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
	<script>
		const profile_image_url = "<?php echo asset('assets/images/user/admin'); ?>";
	</script>
	<script src="{{ asset('assets/js/page-js/admin/user.js')}}"></script>
@endsection


