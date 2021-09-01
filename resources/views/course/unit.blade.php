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
							<span class="d-inline-block">Unit Management</span>
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
					<button type="button" onclick='unitAdd()' title="Add a new Unit" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New Unit
					</button>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover admin_user_table" id="units_table" style="width:100% !important">
					<thead>
						<tr>
							<th>ID</th>
							<th>Unit Code</th>
							<th>Unit Name</th>	
							<th>GLH </th>												
							<th>TUT </th>
							<th>Assessment Type </th>											
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Unit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="unit_form" autocomplete="off" name="unit_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-12">
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Unit Code <span class="required">*</span></label>
												<input type="text" id="unit_code" name="unit_code" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="short_name" class="">Unit Name</label>
												<input type="text" id="name" name="name" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Guided Learning Hours<span class="required">*</span></label>
												<input type="text" id="glh" name="glh" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="short_name" class="">Total Unit Time<span class="required">*</span> </label>
												<input type="text" id="tut" name="tut" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Total Credit<span class="required">*</span></label>
												<input type="text" id="credit_hour" name="credit_hour" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="short_name" class="">Assessment Type  </label>
												<select id="assessment_type" name="assessment_type" class="form-control col-lg-12">
												<option value="Internal">Internal</option>
												<option value="External">External</option>
											</select>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Active?</label>
												<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
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
						@if($actions['add_permisiion']>0)
						<button type="submit" id="save_unit" class="btn btn-success  btn-lg btn-block">Save</button>

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
	<script type="text/javascript" src="{{ asset('assets/js/page-js/course/unit.js')}}"></script>
@endsection


