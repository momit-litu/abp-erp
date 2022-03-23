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
							<span class="d-inline-block">Payment Management</span>
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
					<button type="button" onclick='paymentAdd()' title="Add New Payment" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New Payment
					</button>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover payments_table" id="payments_table" style="width:100% !important">
					<thead>
						<tr> 
							<th>ID</th>
							<th>Student Name</th>
							<th>Course Title</th>	
							<th>Batch</th>	
							<th>Installment</th>
							<th>Payment Month</th>												
							<th>Payment Date </th>
							<th>Type</th>
							<th>Amount</th>	
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
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Payment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="payment_form" autocomplete="off" name="payment_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-12">
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label class="">Student Name <span class="required">*</span></label>
												<input type="text" id="student_name" required name="student_name" class="form-control col-lg-12" />
												<input type="hidden" id="student_id" required name="student_id"  />
											</div>
										</div>										
									</div> 
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  >Course & Batch<span class="required">*</span></label>
												<select id="course_name" required name="course_name" class="form-control col-lg-12">
													
												</select>
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label>Installment<span class="required">*</span></label>
												<select id="installment_no" required name="installment_no" class="form-control col-lg-12">								
												</select>												
											</div>
										</div>
									</div>	
									<div class="form-row">							
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="" class="">Amount<span class="required">*</span></label>
												<input type="text" id="paid_amount" readonly required name="paid_amount"  class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  >Payment Date<span class="required">*</span></label>
												<input type="date" id="paid_date" name="paid_date" class="form-control col-lg-12 datepicker" required />
											</div>
										</div>
									</div>	 
									<div class="form-row">							 
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Reference Number</label>
												<input type="text" id="payment_refference_no" required name="payment_refference_no"  class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label class="">Payment Status </label>
												<select id="receive_status" name="receive_status" class="form-control col-lg-12">
													<option value="Received">Received</option>
													<option value="Not Received">Not Received</option>	
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
											<label>	<strong>Attachment</strong></label>
											<hr>
											<input type="file" class="form-control col-lg-12" name="attachment"  data-show-upload="true" data-show-caption="true" id="attachment" value="" >
											<div id="attachment_div"></div>
										</div>
									</div>
									<hr>  						
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
						<button type="submit" id="save_payment" class="btn btn-success  btn-lg btn-block">Save</button>
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
<script type="text/javascript" src="{{ asset('assets/js/page-js/payment/payment.js')}}"></script>
@endsection


