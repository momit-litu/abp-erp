@extends('layout.master')
@section('content')

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="admin_user_list_button" data-toggle="tab" href="#user_list_div">
                           <b> Unit List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" href="#entry_form_div" id="admin_user_add_button">
	                           <b> Add Unit</b>
	                        </a>
	                    </li>
                    @endif
                </ul>
                <div class="tab-content">
				<!-- PANEL FOR OVERVIEW-->
					<div id="user_list_div" class="tab-pane in active">
						<div class="row no-margin-row">
								<div class="panel-body">
									<table class="table table-bordered table-hover units_table" id="units_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>ID</th>
												<th>Unit Code</th>
												<th>Unit Name</th>	
												<th>GLH </th>												
												<th>TUT </th>
												<th>Assessment Type </th>											
												<th class="hidden-xs">Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
				
							<!-- END Categoreis -->
						</div>
					</div>
                    <!--END PANEL FOR OVERVIEW -->
                   
                    <!-- PANEL FOR CHANGE PASSWORD -->
                    <div id="entry_form_div" class="tab-pane in">
                        <div class="row no-margin-row">
							<form id="location_form" name="location_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
							<div class="col-md-9 col-sm-12">
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Unit Code <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9  col-xs-6">
										<input type="text" id="unit_code" name="unit_code" required class="form-control col-md-6"/>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Unit Name <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9  col-xs-6">
										<input type="text" id="name" name="name" required class="form-control col-lg-12"/>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Guided Learning Hours <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9  col-xs-6">
										<input type="text" id="glh" name="glh" required class="form-control col-lg-12"/>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Total Unit Time <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9  col-xs-6">
										<input type="text" id="tut" name="tut" required class="form-control col-lg-12"/>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Credit Hours <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9  col-xs-6">
										<input type="text" id="credit_hour" name="credit_hour" required class="form-control col-lg-12"/>
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Assessment Type <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9  col-xs-6">
										<select id="assessment_type" name="assessment_type" class="form-control col-lg-12">
											<option value="Internal">Internal</option>
											<option value="External">External</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-6" >Active? </label>
									<div class="col-md-4 col-sm-4 col-xs-6">
										<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
									</div>
								</div>
								<div class="ln_solid"></div>
							</div>
							
							</div>
							<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								@if($actions['add_permisiion']>0)
									<button type="submit" id="save_unit" class="btn btn-success">Save</button>                    
									<button type="button" id="clear_button" class="btn btn-warning">Clear</button>
									<button type="button" id="cancel_button" class="btn btn-danger">Cancel</button>
								@endif                         
							</div>
							 <div class="col-md-6 col-sm-6 col-xs-12">
								<div id="form_submit_error" class="text-center" style="display:none"></div>
							 </div>
						</div>
						</form>	
                        </div>
                    </div>
                    <!-- END PANEL FOR CHANGE PASSWORD -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--END PAGE CONTENT-->
@endsection
@section('JScript')
	<script type="text/javascript" src="{{ asset('assets/js/page-js/qualification/unit.js')}}"></script>
@endsection


