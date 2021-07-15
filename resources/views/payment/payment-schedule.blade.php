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
							<span class="d-inline-block">Payment Schedule Management</span>
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
			<div class="card-body"><h5 class="card-title">Search Student</h5>
				<div>
					<div class="form-row">							 
						<div class="col-md-6">
							<div class="position-relative form-group">
								<input type="text" id="payment_student_name" required name="payment_student_name" class=" mr-2 form-control col-md-12" />
							<input type="hidden" id="payment_student_id" required name="payment_student_id"  />
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn-primary btn-lg" id="show_schedule" >Show Payment Schedule</button>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card" >
			<div class="card-header">
				<div class="btn-actions-pane-left">
					<div class="nav" id="course_tabs">						
					</div>
				</div>
			</div>
			<div class="card-body" >
				<div class="tab-content" id="schedule_details">	
				</div>				
			</div>
			<div class="d-block text-right card-footer"></div>
		</div>
	</div>
</div>
  
</div>
<div class="modal fade" id="entry-form" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Edit Payment schedule</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="schedule_form" autocomplete="off" name="schedule_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<input type="hidden" name="student_enrollment_id" id="student_enrollment_id">	
							<input type="text" style="display:none" name="request_type" id="request_type" value="schedule">
							<div class="row">
								<div class="col-md-12">									
									<div class="form-row">							
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="" class="">Amount<span class="required">*</span></label>
												<input type="text" id="payable_amount" required name="payable_amount"  class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  >Payment Date<span class="required">*</span></label>
												<input type="date" id="last_payment_date" name="last_payment_date" class="form-control col-lg-12 datepicker" required />
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
						@if($actions['add_permisiion']>0)
						<button type="submit" id="save_schedule" class="btn btn-success  btn-lg btn-block">Save</button>
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
	const logo = "<?php echo asset('assets/images/logo-inverse.png'); ?>";
	const payment_attachment_url = "<?php echo asset('assets/images/payment'); ?>";
</script>	
<script type="text/javascript" src="{{ asset('assets/js/page-js/payment/payment.js')}}"></script>
@endsection


