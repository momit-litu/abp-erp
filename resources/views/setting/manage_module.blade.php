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
						Module/Menu List
					</div>
				</div>
				<div class="page-title-actions">
					<button type="button" onclick='moduleAdd()' title="Create a new menu" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add Menu/Module
					</button>
				</div>    
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-hover table-striped table-bordered" id="menus_table" style="width:100% !important"> 
					<thead>
						<tr>
							<th> ID</th>
							<th>Module Name</th>
							<th>Menu Title </th>
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Module</h5>
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="web_module_form" name="web_module_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<input type="hidden" name="id" id="id">
							<div class="row">
							<div class="col-md-12">
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Menu Name</label>
									<div class="col-md-12  col-xs-6">
										<input type="text" id="module_name" name="module_name" class="form-control col-lg-12" list="existed_menu" />
										<datalist id="existed_menu" class="dropdown">
											
										</datalist>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Menu Title</label>
									<div class="col-md-12  col-xs-6">
										<input type="text" id="menu_title" name="menu_title" class="form-control col-lg-12" />
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Menu URL</label>
									<div class="col-md-12  col-xs-6">
										<input type="text" id="menu_url" name="menu_url" class="form-control col-lg-12" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Parent Name</label>
									<div class="col-md-12  col-xs-6">
										<select class="form-control col-lg-12" id="parent_id"  name="parent_id">
											<option value="0"  selected>Select Parent Menu</option>
											@foreach($parentmenus as $menu)
												<option value="{{$menu->id}}">{{$menu->menu_title}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Icon Class</label>
									<div class="col-md-12  col-xs-6">
										<input type="text" id="menu_icon_class" name="menu_icon_class" class="form-control col-lg-12" />
									</div>
								</div>
								<div class="ln_solid"></div>
							</div>
							
							</div>
							<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
							<div class="col-md-4 col-sm-4 col-xs-12">
							
								                      
							</div>
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
						<button type="submit" id="save_module" class="btn btn-success  btn-lg btn-block">Save</button>                    
						
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
	var profile_image_url = "<?php echo asset('assets/images/user/admin'); ?>";
	$(document).ready(() => {
		//toastr['error']('sdfdsf', 'sfsdfsd fsdfsdf sdfdsf');
	});

</script>
	
	<script type="text/javascript" src="{{ asset('assets/js/page-js/setting/setting.js')}}"></script>
@endsection



