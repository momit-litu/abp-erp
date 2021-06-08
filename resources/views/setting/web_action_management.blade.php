@extends('layout.master')
@section('content')
<div class="app-main__outer">
	<div class="app-main__inner">
		<div class="app-page-title">
			<div class="page-title-wrapper">
				<div class="page-title-heading">
					<div class="page-title-icon">
						<i class="pe-7s-menu icon-gradient bg-mean-fruit"></i>
					</div>
					<div>
						Web Action Management
					</div>
				</div>
				<div class="page-title-actions">
					<button type="button" onclick='actionAdd()' title="Add a new action" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New Action
					</button>
				</div>    
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover menus_table" id="web_actions_table" style="width:100% !important">
					<thead>
					<tr>

						<th> ID</th>
						<th> Activity Name</th>
						<th>Module Name</th>
						<th class="hidden-xs">Status</th>
						<th width='80'>Actions</th>
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Action</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="web_action_form" name="web_action_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" name="edit_id" id="edit_id">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Module Name<span class="required">*</span></label>
										<div class="col-md-12  col-xs-6">
											<select class="form-control col-lg-12" id="module_name"  name="module_name">
												<option value=""  selected>Select Module Name</option>
												@foreach($menus as $menu)
													<option value="{{$menu->id}}">{{$menu->menu_title}}</option>
												@endforeach
											</select>
										</div>
									</div>										
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Action Name<span class="required">*</span></label>
										<div class="col-md-12  col-xs-6">
											<input type="text" id="activity_name" name="activity_name" class="form-control col-lg-12" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Is Menu?<span class="required">*</span></label>
										<div class="col-md-12  col-xs-6">
											<select class="form-control col-lg-12"  name="is_menu" id="is_menu">
												<option value=""  selected>Select Menu Name</option>
												@foreach($menus as $menu)
													<option value="{{$menu->id}}">{{$menu->menu_title}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Is Active</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="checkbox" id="is_active" name="is_active" checked="checked" class="form-control col-lg-12"/>
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
						<button type="submit" id="save_web_action" class="btn btn-success  btn-lg btn-block">Save</button>                    
						
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
	<script type="text/javascript" src="{{ asset('assets/js/page-js/setting/setting.js')}}"></script>
@endsection



