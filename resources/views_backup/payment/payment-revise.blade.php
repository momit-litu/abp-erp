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
							<span class="d-inline-block">Payment Revise Management</span>
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
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover payments_table" id="revise_table" style="width:100% !important">
					<thead>
						<tr> 
							<th>ID</th>
							<th>Student Name</th>
							<th>Course Title</th>	
							<th>Request Details</th>
							<th>Date</th>	
							<th>Status</th>													
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
				<h5 class="modal-title" id="form-title">Update payment revise request</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="revise_form" autocomplete="off" name="revise_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-12">
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label class="">Student Name </label>
												<div id="student_name_div"></div>
											</div>
										</div>										
									</div> 
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label class="">Course </label>
												<div id="course_name_div"></div>
											</div>
										</div>										
									</div> 
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label class="">Details</label>
												<div id="revise_details_div"></div>
											</div>
										</div>										
									</div> 
									<div class="form-row">							 
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label class="">Status </label>
												<select id="revise_status" name="revise_status" class="form-control col-lg-12">
													<option value="Approved">Approved</option>
													<option value="Pending">Pending</option>	
													<option value="Rejected">Rejected</option>
											</select>
											</div>
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
						<button type="submit" id="update_revise" class="btn btn-success  btn-lg btn-block">Update</button>
					</div>
					<div class="col-md-9 text-right">					
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('JScript')	
<script type="text/javascript" src="{{ asset('assets/js/page-js/payment/payment.js')}}"></script>
@endsection


