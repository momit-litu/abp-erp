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
							<span class="d-inline-block">Batch Management</span>
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
					<button type="button" onclick='batchAdd()' title="Add New Batch" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New Batch
					</button>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover batches_table" id="batches_table" style="width:100% !important">
					<thead>
						<tr> 
							<th>ID</th>
							<th>Batch</th>
							<th>Course Title</th>											
							<th>Start Date </th>
							<th>End Date</th>
							<th>Student Limit</th>
							<th>Enrolled Student</th>
							<th>Pending Enrolment</th>												
							<th class="hidden-xs">Status</th>
							<th class="hidden-xs">Active?</th>
							<th class="text-center" width="100">Actions</th>
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Batch</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="batch_form" autocomplete="off" name="batch_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-12">
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label class="">Batch <span class="required">*</span></label>
												<input type="text" id="batch_name" name="batch_name" required class="form-control col-lg-12"/>
											</div>
										</div>										
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  >Course Name<span class="required">*</span></label>	
												<input type="text" id="course_name" required name="course_name" class="form-control col-lg-12" />
												<input type="hidden" id="course_id" required name="course_id"  />
											</div>
										</div>
									</div>	
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  >Class Time</label>
												<input type="text" id="class_schedule" name="class_schedule" class="form-control col-lg-12 " required />
											</div>
										</div>
									</div>	
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  >Start Date<span class="required">*</span></label>
												<input type="date" id="start_date" name="start_date" class="form-control col-lg-12 datepicker" required />
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label>End Date</label>
												<input type="date" id="end_date" name="end_date" class="form-control col-lg-12 datepicker" />
											</div>
										</div>
									</div>	
									<div class="form-row">							
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Student Limit<span class="required">*</span></label>
												<input type="text" id="student_limit" required name="student_limit"  class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label class="">Running Status </label>
												<select id="running_status" name="running_status" class="form-control col-lg-12">
													<option value="Upcoming">Upcoming</option>
													<option value="Running">Running</option>
													<option value="Completed">Completed</option>		
											</select>
											</div>
										</div>
									</div>								
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Details</label>
												<input type="text" id="details" name="details" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label>Registration Fee<span class="required">*</span></label>
												<input type="text" id="fees" name="fees"  class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label> Onetime payment (Discount Fees)</label>
												<input type="text" id="discounted_fees" name="discounted_fees"  class="form-control col-lg-12"/>
											</div>
										</div>
									</div>
									<div class="form-row">									
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="company_name" class="">Active?</label>
												<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="company_name" class="">Featured?</label>
												<input type="checkbox" id="featured" name="featured" value="1" class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="company_name" class="">Draft?</label>
												<input type="checkbox" id="draft" name="draft" value="1" class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label for="company_name" class="">Show Seat Limit?</label>
												<input type="checkbox" id="show_seat_limit" name="show_seat_limit" value="1" class="form-control col-lg-12"/>
											</div> 
										</div>
									</div>
									<br>
									<hr>  
									<div class="form-row bg-gray ">
										<div class="col-md-4"><b>Installment plan Details</b></div><br>
										<div class="col-md-8 text-right">
											<button type="button"  id="plan_add_button" title="Add Installment Plan" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary ">
												<i class="fa fa-plus"></i>
												Add Installment Plan
											</button>
											<button type="button"  id="plan_clear_button" title="Clear Installment Plan" data-placement="bottom" class="btn-shadow mr-3 btn btn-danger ">												
												Clear
											</button>
										</div>
										<br>											
										<table class="table table-bordered  plan_table table-sm table-stripe" id="plan_table" style="width:100% !important"> 
											<thead>
												<tr  class="bg-light">
													<th>Plan Name</th>									
													<th>Duration (Month)</th>		
													<th>Total Inst. No</th>				
													<th>Total Payable</th>
													<th></th>
												</tr>												
											</thead>
											<tbody>
												
											</tbody>
										</table>
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
						<button type="submit" id="save_batch" class="btn btn-success  btn-lg btn-block">Save</button>
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
<script type="text/javascript" src="{{ asset('assets/js/page-js/batch/batch.js')}}"></script>
@endsection


