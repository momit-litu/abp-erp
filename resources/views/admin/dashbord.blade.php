@extends('layout.master')
@section('content')
<div class="app-main">   
	<div class="app-main__outer" style="margin-top: -60px;">
		<div class="app-main__inner">
		 <div class="app-page-title app-page-title-simple">
				<div class="page-title-wrapper">
					<div class="page-title-heading">
						<div>
							<div class="page-title-head center-elem">
								<span class="d-inline-block pr-2">
									<i class="lnr-apartment opacity-6"></i>
								</span>
								<span class="d-inline-block">Dashboard</span>
							</div>
							<div class="page-title-subheading opacity-10">
								<nav class="" aria-label="breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<i aria-hidden="true" class="fa fa-user"></i>&nbsp; &nbsp;<a>ABP Admin</a>
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="page-title-actions">
						<div class="d-inline-block pr-3">
							<select type="select" class="custom-select" id="select_report_period">
								<option value="today">Today</option>
								<option value="last_week">Last Week</option>
								<option value="last_month">Last Month</option>
								<option value="last_year">Last Year</option>
							</select>
						</div>
					</div>
				</div>
			</div>  
			
			<!--<div class="mbg-3 alert alert-warning alert-dismissible fade show" role="alert">
				<span class="pr-2">
					<i class="fa fa-question-circle"></i>
				</span>
				Attention!!! This dashboard example was created using only the available elements and components, no additional SCSS was written!
			</div>-->
			@if($dashboardComponents['dashboardRegistrationInfo'])
			<div class="row" id="registered_div"></div>
			@endif
			
			@if($dashboardComponents['dashboardPaymentScheduleInfo'])
			<div  id="payment_schedule_div"></div>
			@endif
	
			<div class="row">	
				@if($dashboardComponents['dashboardStudentRegistrationBarchart'])		
				<div class="col-sm-12 col-md-7 col-lg-8">
					<div class="mb-3 card">
						<div class="card-header-tab card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><strong>Student Registration</strong></div>
							<!--<div class="btn-actions-pane-right text-capitalize">
								<button class="btn btn-warning">Actions</button>
							</div>-->
						</div>
						<div class="pt-0 card-body">
							<div id="dashboard-chart"></div>
						</div>
					</div>
				</div>
				@endif

				@if($dashboardComponents['DashboardFinancialstatus'])		
				<div class="col-lg-12 col-xl-4">
					<div class="mb-3 card">
						<div class="rm-border pb-0 responsive-center card-header">
							<div><h5 class="menu-header-title text-capitalize">Financial Status</h5></div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-xl-12">
								<div class="no-shadow rm-border bg-transparent widget-chart text-left card">
									<div class="progress-circle-wrapper">
										<div class="circle-progress" id="collection_percentage">
											<small></small>
										</div>
									</div>
									<div class="widget-chart-content" id="collection_div"></div>
								</div>
							</div>
							<div class="col-lg-6 col-xl-12">
								<div class="card no-shadow rm-border bg-transparent widget-chart text-left mt-2">
									<div class="progress-circle-wrapper">
										<div class="circle-progress" id="paid_percentage">
											<small></small>
										</div>
									</div>
									<div class="widget-chart-content" id="expense_div"></div>
								</div>
							</div>
						</div>
						&nbsp;	&nbsp;&nbsp;&nbsp;
						<div class="card-body">
							<div class="text-center mt-3">
								<button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-success btn-lg">
								<span class="mr-2 opacity-7">
									<i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
								</span>
									<span class="mr-1">
										<a class="text-white" href="{{ url('financial-report') }}">View Complete Report</a>
										</span>
								</button>
							</div>
						</div>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>	
				@endif

		<!--	
			<div class="row">
				<div class="col-sm-12 col-lg-4">
					<div class="mb-3 card">
						<div class="card-header-tab card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal">Total Sales</div>
							<div class="btn-actions-pane-right text-capitalize actions-icon-btn">
								<div class="btn-group dropdown">
									<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
										<i class="lnr-cog btn-icon-wrapper"></i>
									</button>
									<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
										<h6 tabindex="-1" class="dropdown-header">Header</h6>
										<button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-inbox"> </i><span>Menus</span></button>
										<button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-file-empty"> </i><span>Settings</span></button>
										<button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-book"> </i><span>Actions</span></button>
										<div tabindex="-1" class="dropdown-divider"></div>
										<div class="p-1 text-right">
											<button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
											<button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div id="chart-col-1"></div>
						</div>
						<div class="p-0 d-block card-footer">
							<div class="grid-menu grid-menu-2col">
								<div class="no-gutters row">
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-car text-primary opacity-7 btn-icon-wrapper mb-2"> </i>
											Admin
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-bullhorn text-danger opacity-7 btn-icon-wrapper mb-2"> </i>
											Blog
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-bug text-success opacity-7 btn-icon-wrapper mb-2"> </i>
											Register
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-heart text-warning opacity-7 btn-icon-wrapper mb-2"> </i>
											Directory
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-lg-4">
					<div class="mb-3 card">
						<div class="card-header-tab card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal">Daily Sales</div>
							<div class="btn-actions-pane-right text-capitalize">
								<button class="btn-wide btn-outline-2x btn btn-outline-focus btn-sm">View All</button>
							</div>
						</div>
						<div class="card-body">
							<div id="chart-col-2"></div>
						</div>
						<div class="p-0 d-block card-footer">
							<div class="grid-menu grid-menu-2col">
								<div class="no-gutters row">
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-apartment text-dark opacity-7 btn-icon-wrapper mb-2"> </i>
											Overview
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-database text-dark opacity-7 btn-icon-wrapper mb-2"> </i>
											Support
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-printer text-dark opacity-7 btn-icon-wrapper mb-2"> </i>
											Activities
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
											<i class="lnr-store text-dark opacity-7 btn-icon-wrapper mb-2"> </i>
											Marketing
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-lg-4">
					<div class="mb-3 card">
						<div class="card-header-tab card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal">Total Expenses</div>
							<div class="btn-actions-pane-right text-capitalize">
								<button class="btn-wide btn-outline-2x btn btn-outline-primary btn-sm">View All</button>
							</div>
						</div>
						<div class="card-body">
							<div id="chart-col-3"></div>
						</div>
						<div class="p-0 d-block card-footer">
							<div class="grid-menu grid-menu-2col">
								<div class="no-gutters row">
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-success">
											<i class="lnr-lighter text-success opacity-7 btn-icon-wrapper mb-2"> </i>
											Accounts
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
											<i class="lnr-construction text-warning opacity-7 btn-icon-wrapper mb-2"> </i>
											Contacts
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-info">
											<i class="lnr-bus text-info opacity-7 btn-icon-wrapper mb-2"> </i>
											Products
										</button>
									</div>
									<div class="p-2 col-sm-6">
										<button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-alternate">
											<i class="lnr-gift text-alternate opacity-7 btn-icon-wrapper mb-2"> </i>
											Services
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		-->
		<!--
		<div class="col-sm-12 col-md-5 col-lg-4">
			<div class="mb-3 card">
				<div class="card-header-tab card-header">
					<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><strong>Payment Collection Status</strong></div>
				</div>
				<div class="p-0 card-body">
					<div id="chart-radial"></div>
					<div class="widget-content pt-0 w-100">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left pr-2 fsize-1">
									<div class="widget-numbers mt-0 fsize-3 text-warning">68%</div>
								</div>
								<div class="widget-content-right w-100">
									<div class="progress-bar-xs progress">
										<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100" style="width: 32%;"></div>
									</div>
								</div>
							</div>
							<div class="widget-content-left fsize-1">
								<div class="text-muted opacity-6">Last Month</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		-->
				@if($dashboardComponents['dashboardRegisteredStudents'])
				<div class="col-sm-12 col-md-6 col-lg-6" >
					<div class="main-card mb-3 card">
						<div class="card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><strong>Registered Students</strong>
							</div>
							<div class="btn-actions-pane-right">
								<a  class="btn-wide btn btn-primary btn-sm text-white" href="{{ url('student-report') }}">View Full Report</a>

							</div>
						</div>
						<div class="table-responsive">
							<table class="align-middle text-truncate mb-0 table table-borderless table-hover" id="reg_student_table">
								<thead>
								<tr>
									<th class="text-center">Reg. No.</th>
									<th class="text-left">Name</th>
									<th class="text-left">Email</th>
									<th class="text-left">Contact</th>
									<th class="text-center">Reg. By</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
				@if($dashboardComponents['dashboardEnrolledStudents'])
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="main-card mb-3 card">
						<div class="card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><strong>Enrolled Students</strong>
							</div>
							<div class="btn-actions-pane-right">
								<a  class="btn-wide btn btn-warning btn-sm text-white" href="{{ url('student-report') }}">View Full Report</a>								
							</div>
						</div>
						<div class="table-responsive">
							<table class="align-middle text-truncate mb-0 table table-borderless table-hover" id="enrolled_student_table">
								<thead>
								<tr>
									<th class="text-center">Name</th>
									<th class="text-center">Enrollment No</th>
									<th class="text-center">Course</th>
									<th class="text-center">Status</th>
								</tr>
								</thead>
								<tbody>																		
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
				@if($dashboardComponents['dashboardPayments'])	
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="main-card mb-3 card">
						<div class="card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><strong>Payments</strong>
							</div>
							<div class="btn-actions-pane-right">
								<a  class="btn-wide btn btn-danger btn-sm text-white" href="{{ url('payment-collection-report') }}">View Full Report</a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="align-middle text-truncate mb-0 table table-borderless table-hover" id="paymet_table">
								<thead>
								<tr>
									<th class="text-left">Student</th>
									<th class="text-left">Course</th>
									<th class="text-center">Type</th>
									<th class="text-right">Amount</th>
								</tr>
								</thead>
								<tbody>															
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
				@if($dashboardComponents['dashboardUpcomingBatches'])
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="main-card mb-3 card">
						<div class="card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><strong>Upcoming Batches</strong>
							</div>
							<div class="btn-actions-pane-right">
								<a  class="btn-wide btn btn-info btn-sm text-white" href="{{ url('batch-report') }}">View Full Report</a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="align-middle text-truncate mb-0 table table-borderless table-hover" id="upcoming_batch_table">
								<thead>
								<tr>
									<th class="text-left">Course</th>
									<th class="text-center">Batch No.</th>
									<th class="text-center">Start Date</th>
									<th class="text-right">Fee(Onetime)</th>
								</tr>
								</thead>
								<tbody>														
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>   
	</div>
</div>
@endsection
@section('JScript')
    <script type="text/javascript" src="{{ asset('assets/js/page-js/admin/dashboard.js')}}"></script>

<script>
    jQuery(document).ready(function() {
        Index.init();
        $("#select_report_period").on('change',function(){
            Index.init();
        });
    });
</script>
@endsection


