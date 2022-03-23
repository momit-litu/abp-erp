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
							<span class="d-inline-block">Expense Report</span>
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
				<form id="collection_status_form" name="expense_status_form" enctype="multipart/form-data" class="form form-horizontal form-label-left ba">
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
								<label class="control-label" >Category</label>
								<select class="form-control col-lg-12"  name="expense_category_id" id="expense_category_id">
									<option value=""  selected>Select Expense Category</option>
									@foreach($parentExpneseHead as $parentHead)
										<option value="{{$parentHead->id}}">
											{{($parentHead->parent!=null)?$parentHead->parent->category_name." -> ".$parentHead->category_name:$parentHead->category_name}}
									</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label class="control-label" >Expense Head</label>
								<input type="text" id="expense_name" autocomplete="off" name="course_name" class="form-control col-lg-12" placeholder="Expense Head Name" />
								<input type="hidden" id="expense_head_id" required name="expense_head_id" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-1">
							<div class="position-relative form-group">
								<label class="control-label" >&nbsp;</label>
								<div class="col-md-8">
									@if($actions['view_permisiion']>0)
										<button type="submit" id="show_expense_status_report" class="btn btn-success btn-lg">Show</button>      
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
					<table class="table table-bordered table-hover expense_table" id="expense_table" style="width:100% !important"> 
						<thead>
							<tr>
								<th>Category Name</th>												
								<th>Expense Head</th>										
								<th>Expense Date</th>	
								<th>Details</th>
								<th>Status</th>		
								<th class="text-right">Amount</th>									
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


