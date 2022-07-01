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
							<span class="d-inline-block">Send SMS</span>
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
											{{ isset($page_title) ? $page_title : '' }}
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
				<form id="sms_form" autocomplete="off" name="sms_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
					@csrf
					<div class="row">
						<div class="col-md-12 col-sm-12">	
							<div class="form-row">							
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class="">Message Template</label>
										<select name="sms_template" id="sms_template" class="form-control col-lg-12">
											<option value="">Select a SMS template</option>
											@foreach ($smsTemplates as $template)
											<option value="{{$template->id}}">{{$template->title}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>	
							<div class="form-row">							
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class="">Message Body</label>
										<textarea  rows="4" id="message_body" required name="message_body"  class="form-control col-lg-12"></textarea>
									</div>
								</div>
							</div>		
							<div class="form-row">							
								<!--<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">Payment type</label>
										<select name="payment_type" id="payment_type" class="form-control col-lg-12">
											<option value="">Select payment type</option>
											<option value="All">All</option>
											<option value="Due">Due</option>
											<option value="Paid">Paid</option>
										</select>
									</div>
								</div>-->
								<div class="col-md-4">
									<div class="position-relative form-group">
										<label for="" class="">All Student?</label>
										<select name="all_student_type" id="all_student_type" class="form-control col-lg-12">
											<option value="">Select all students type</option>
											<option value="all">All students</option>
											<option value="active">All active students</option>
											<option value="inactive">All in-active students</option>
											<option value="Pending">All Pending Registration students</option>
											<option value="enrolled">All current enrolled students</option>
											<option value="nonenrolled">All current non-enrolled students</option>											
										</select>
									</div>
								</div>
							</div>	
							<div class="form-row" style='display:none' id="do_not_send_div">							
								<div class="col-md-12">
									<label for="" class="">Dont Send To</label> 
									<div class="position-relative form-check">							
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="dont_send_dropout" value="1" > Dropout
										</label>
									</div>
									<div class="position-relative form-check">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="dont_send_disabled" value="1" > Temporary Disabled
										</label>
									</div>
									<div class="position-relative form-check">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="dont_send_selective" value="1" > Selective Student?
										</label>									
									</div>
									<br>
								</div>
							</div>											
							<div class="form-row">		
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class="">All Student in a Course & Batch ?</label>
										<input type="text" id="sms_batch_name"  name="sms_batch_name" class=" mr-2 form-control col-md-12" />
										<input type="hidden" id="sms_batch_id"  name="sms_batch_id" />
									</div>
								</div>
							</div>
							<div class="form-row">							 
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class="">Selective Students? (Multiselect)</label>
										<input type="text" id="sms_student_name" required  multiselect name="sms_student_name" class=" mr-2 form-control col-md-12" />
										
									</div>
								</div>
								<div class="col-md-12">
									<div class="position-relative form-group">
										<div id="selected_receipants">							
										</div>
									</div>
								</div>
							</div>	
							<hr><br>	 					
						</div>							
					</div>
					<div class="form-group">
						<div class="col-md-8 col-sm-12 col-xs-12">
							<div id="form_submit_error" class="text-center" style="display:none"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8 col-sm-12" style="display: flex; flex-direction: row;">
							<div class="col-md-12 text-left">
								@if($actions['add_permisiion']>0)
									<button type="submit" id="sent_sms_submit" class="btn btn-success">Sent SMS</button>								
								@endif
								<button type="button" id="clear_button" class="btn btn-danger">Clear</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
  
</div>


@endsection
@section('JScript')	
<script type="text/javascript" src="{{ asset('assets/js/page-js/notification/notification.js')}}"></script>
@endsection


