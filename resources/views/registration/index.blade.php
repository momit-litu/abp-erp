@extends('layout.master')
@section('content')

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="admin_user_list_button" data-toggle="tab" class="result-tab" href="#user_list_div">
                           <b> Registration List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" class="result-tab" href="#entry_form_div" id="admin_user_add_button">
	                           <b> Add Registration</b>
	                        </a>
	                    </li>
                    @endif
					<li class="">
						<a data-toggle="tab" class="result-tab" href="#result_div" id="result_button" style="display: none;">
						   <b>Transcript</b>
						</a>
					</li>
                </ul>
                <div class="tab-content">
				<!-- PANEL FOR OVERVIEW-->
					<div id="user_list_div" class="tab-pane in active">
						<div class="row no-margin-row">
							<!-- List of Categories -->
							<div class="panel panel-default">
								<div class="panel-body">
									<table class="table table-bordered table-hover registrations_table" id="registrations_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>ID</th>
												<th>Reg. No.</th>
												<th>Centre name</th>										
												<th>Qualification Title</th>
												<th class="text-center">Units</th>
												<th class="text-center">No. of Learners</th>
												<th class="text-center">Registration status</th>
												<th class="text-center">Payment Status</th>												
												<th class="hidden-xs text-center">Status</th>
												<th>Invoice No.</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<!-- END Categoreis -->
						</div>
					</div>
                    <!--END PANEL FOR OVERVIEW -->
                   
                    <!-- PANEL FOR CHANGE PASSWORD -->
                    <div id="entry_form_div" class="tab-pane in">
                        <div class="row no-margin-row">
							<form id="registration_form" name="registration_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-10 col-sm-12">
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Registration No.</label>
										<div class="col-md-3 col-sm-3  col-xs-12">
											<input type="text" disabled id="registration_no" name="registration_no"  class="form-control col-md-12 bordered"  autocomplete="off" placeholder="Auto generated number"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Qualification<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-12">
											<input type="text" id="qualification_title" name="qualification_title" required class="form-control col-md-12 bordered"  autocomplete="off" placeholder="Search qualifications by code or qualification name"/>
											<input type="hidden" id="qualification_id" name="qualification_id"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Registration Fees (£) </label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="text" id="registration_fees" name="registration_fees" readonly autocomplete="off"  class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Payment Status</label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<select id="payment_status" name="payment_status" {{ ($userType=='Center')?'disabled':'' }} class="form-control col-lg-12">
												<option value="Due">Due</option>
												<option value="Paid">Paid</option>
												<!--<option value="Partial">Partial</option>-->
											</select>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Approval Status<span class="required">*</span></label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<select id="approval_status" name="approval_status"  class="form-control col-lg-12">
												<option value="Initiated">Initiated</option>
												@if($userType=='Center')												
												<option value="Requested">Requested</option>												
												@endif
												
												@if($userType=='Admin')
												<option value="Requested">Requested</option>
												<option value="Approved">Approved</option>
												<option value="Rejected">Rejected</option>
												@endif
											</select>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" ></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Active?<span class="required">*</span></label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" ></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6">Remarks</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<textarea rows="2" cols="100" id="remarks" name="remarks" class="form-control col-lg-12"></textarea> 
										</div>
									</div>

									<div class="ln_solid"></div>
								</div>
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" ></label>
										<div class="col-md-10 col-sm-10 col-xs-12"><b> Search and add learners for this registration</b></div>
									</div>

									<div class="form-group ">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" ></label>
										<div class="col-md-9 col-sm-9 col-xs-12 well">
											<div class="input-group">
											  <input type="text" id="learner_name" name="learner_name" autocomplete="off" placeholder="Search learners by name or email" class="form-control col-lg-12 bordered" />
											  <span class="input-group-btn">
												<button class="btn btn-primary" type="button"><i class='clip-plus-circle  '></i>Add New Larner</button>
											  </span>
											</div>											
											<p>&nbsp;</p>
											<div class='' id="qualification_list_table">
											<b>Total Learner (<badge id='total_learner'>0</badge>)</b>
												<table class="table table-bordered table-hover learner_table" id="learner_table" style="width:100% !important"> 
													<thead>
														<tr>
															<th></th>
															<th>ID</th>
															<th>First Name</th>
															<th>Last Name</th>
															<th>Email</th>											
															<th>Contact No. </th>
															<th></th>
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
							<div class="ln_solid"></br></div>

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									@if($actions['add_permisiion']>0)
										<button type="submit" id="save_registration" class="btn btn-success">Save</button>                    
										<button type="button" id="clear_button" class="btn btn-warning">Clear</button>
										<button type="button" id="cancel_button" class="btn btn-danger">Cancel</button>
									@endif                         
								</div>
							</div>
						</form>	
                        </div>
                    </div>
                    <!-- END PANEL FOR CHANGE PASSWORD -->
					
					<div id="result_div" class="tab-pane in">
						
					</div>
				</div>
            </div>
        </div>
    </div>
    </div>
    <!--END PAGE CONTENT-->
@endsection
@section('JScript')
	<script>
		const user_type 		= "<?php echo $userType; ?>";
		const learner_image_url = "<?php echo asset('assets/images/learner'); ?>";
		const logo_url 			= "<?php echo asset('assets/images/logo.png'); ?>";

		if(user_type=='Admin') $('#admin_user_add_button').hide();
	</script>
	<script type="text/javascript" src="{{ asset('assets/js/page-js/registration/registration.js')}}"></script>
@endsection


