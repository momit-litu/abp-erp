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
							<span class="d-inline-block">Payment Collection Report</span>
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
			<div class="card-body report-form">
				<form id="collection_status_form" name="payment_collection_status_form" enctype="multipart/form-data" class="form form-horizontal form-label-left ba">
					@csrf
					<div class="form-row">							 
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label class="control-label" >From</label>
								<input type="date" id="from_date" name="from_date" class="form-control col-lg-12" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label class="control-label" >To</label>
								<input type="date" id="to_date" name="to_date" class="form-control col-lg-12" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label class="control-label" >Course & Batch</label>
								<input type="text" id="batch_name" name="batch_name" class="form-control col-lg-12" />
								<input type="hidden" id="batch_id" name="batch_id"/>
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label class="control-label" >Student</label>
								<input type="text" id="student_name" name="student_name" class="form-control col-lg-12" />
								<input type="hidden" id="student_id" name="student_id"/>
							</div>
						</div>
						<!--<div class="col-md-2"> 
							<div class="position-relative form-group">
								<label class="control-label" >Payment Status</label>
								<select class="form-control col-lg-12" id="payment_status"  name="payment_status" autocomplete="off"> 
									<option value="All"  selected>All</option>
									<option value="Paid">Paid</option>
									<option value="Unpaid" >Unpaid</option>
									<option value="Partial" >Partial</option>
								</select>
							</div>
						</div>-->
						<div class="col-md-1">
							<div class="position-relative form-group">
								<label class="control-label" >&nbsp;</label>
								<div class="col-md-8">
									@if($actions['view_permisiion']>0)
										<button type="submit" id="show_payment_collection_status_report" class="btn btn-success btn-lg">Show</button>      
									</div>              
								@endif 
							</div>								
						</div>
					</div>
				</form>		

			</div>
		</div>
		<div class="main-card mb-3 card" >
			<div class="card-body" >
				<div id='report-data' style="display: none">
					<table class="table table-bordered report-table-bordered table-hover payment_collection_table " id="payment_collection_table" style="width:100% !important"> 
						<thead>
							<tr>
								<th>Student</th>												
								<th>Course</th>										
								<th class="text-center">Installment</th>	
								<th class="text-center">Payment Month</th>	
								<th class="text-center">Paid Date</th>
								<th class="text-center">Payment type</th>
								<th class="text-center">Paid By</th>
								<th class="text-center">Reference No.</th>
								<th class="text-center">Invoice</th>	
								<!--<th class="text-center">Payment Status</th>-->
								<th class="text-right">Paid Amount</th>									
							</tr>
						</thead>
						<tbody>
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<!--<th></th>-->
								<th>Total</th>										
								<th class="text-right"></th>									
							</tr>
						</tfoot>
					</table>
				</div>		
			</div>
		</div>
	</div>
</div>
  
</div>


@endsection
@section('JScript')	
<script type="text/javascript" src="{{ asset('assets/js/page-js/report/report.js')}}"></script>
@endsection


