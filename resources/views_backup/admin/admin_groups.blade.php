
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
								<i class="pe-7s-menu icon-gradient bg-mean-fruit"></i>
							</span>
							<span class="d-inline-block">User Group Management</span>
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
					<button type="button" onclick='groupAdd()' title="Add a new Group" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New User Group
					</button>
				</div>    
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover" id="admin_group" style="width:100% !important"> 
					<thead>
						<tr>
							<th>ID</th>
							<th>Group Name</th>
							<th>Type</th>
							<th class="hidden-xs">Status</th>
							<th width="100">Actions</th>
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New User Group</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="save_group_form" name="admin_user_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="edit_id" id="edit_id">
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group"><label for="company_name" class="">Group Name</label>
												<input type="text" id="group_name" name="group_name" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group"><label for="type" class="">User Type</label>
												<select class="form-control" id="type" name="type">
													<option value="1" >Admin User </option>
													<option value="2" >Student User </option>
												</select>
											</div>
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-6" >Is Active</label>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <input type="checkbox" name="is_active" id="is_active" value="1" checked="checked">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
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
						<button type="submit" id="save_group" class="btn btn-success  btn-lg btn-block ">Save</button>                    
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


<div class="modal fade" id="permission-modal" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form-title"> Permission Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="action_select_form" name="action_select_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="group_id" id="group_id">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div id="action_select" class="col-md-12"></div>
									</div>
									<div class="ln_solid"></div>
								</div>								
							</div>
							<div class="form-group">
								<div class="col-md-12 col-xs-12">
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
						<button type="submit" id="save_permission" class="btn btn-success  btn-lg btn-block ">Save</button>                    
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
		const user_type = "Admin";
	</script>
	<script src="{{ asset('assets/js/page-js/admin/user.js')}}"></script>
@endsection






