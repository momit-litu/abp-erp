@extends('layout.master')
@section('content')

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="admin_user_list_button" data-toggle="tab" href="#user_list_div">
                           <b> Centre List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" href="#entry_form_div" id="admin_user_add_button">
	                           <b> Add Centre</b>
	                        </a>
	                    </li>
                    @endif
                </ul>
                <div class="tab-content">
				<!-- PANEL FOR OVERVIEW-->
					<div id="user_list_div" class="tab-pane in active">
						<div class="row no-margin-row">
							<!-- List of Categories -->
							<div class="panel panel-default">
								<div class="panel-body">
									<table class="table table-bordered table-hover centers_table" id="centers_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>ID</th>
												<th>Centre Code</th>
												<th>Centre Name</th>										
												<th>Head of Centre</th>
												<th>Contact No.</th>
												<th>Email</th>
												<th>Liaision Officer</th>
												<th  class="text-center">Total Q.</th>	
												<th class="hidden-xs text-center">Approved?</th>												
												<th class="hidden-xs text-center">Status</th>
												<th  class="text-center">Actions</th>
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
							<form id="center_form" name="center_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-10 col-sm-12">
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Code<span class="required">*</span></label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="text" id="code" name="code" required class="form-control col-md-6"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Short Name</label>
										<div class="col-md-4 col-sm-4  col-xs-6">
											<input type="text" id="short_name" name="short_name"  class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Centre Name <span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="name" name="name" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Address <span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="address" name="address" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Website</label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="website" name="website" class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Head Of Centre</label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="proprietor_name" name="proprietor_name" class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Contact No. <span class="required">*</span></label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="text" id="mobile_no" name="mobile_no" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Email <span class="required">*</span></label>
										<div class="col-md-4 col-sm-4  col-xs-6">
											<input type="text" id="email" name="email" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Liaision Officer <span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="liaison_office" name="liaison_office" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Liaision Officer Address <span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="liaison_office_address" name="liaison_office_address" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Agreed Minimum Invoice (£)</label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="agreed_minimum_invoice" name="agreed_minimum_invoice"  class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Date of Approval</label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="date" id="date_of_approval" name="date_of_approval"  class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Date of Review</label>
										<div class="col-md-4 col-sm-4  col-xs-6">
											<input type="date" id="date_of_review" name="date_of_review" class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Approval Status<span class="required">*</span></label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<select id="approval_status" name="approval_status" class="form-control col-lg-12">
												<option value="Pending">Pending</option>
												<option value="Approved">Approved</option>
												<option value="Rejected">Rejected</option>
											</select>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Active?</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
										</div>
									</div>

									<div class="ln_solid"></div>
								</div>
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" ></label>
										<div class="col-md-10 col-sm-10 col-xs-12"><b> Search and add Qualification for this center</b></div>
									</div>

									<div class="form-group ">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" ></label>
										<div class="col-md-10 col-sm-10 col-xs-12 well">
											<input type="text" id="qualification_name" name="qualification_name" autocomplete="off" placeholder="Search qualifications by code or qualification name" class="form-control col-lg-12 bordered" />
											<p>&nbsp;</p>
											<div class='' id="qualification_list_table">
												<table class="table table-bordered table-hover qualification_table" id="qualification_table" style="width:100% !important"> 
													<thead>
														<tr>
															<th>Q. Code</th>
															<th>Title</th>											
															<th class="text-center">Level </th>
															<th class="text-center">TQT</th>
															<th class="text-center">No of Units</th>
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
										<button type="submit" id="save_center" class="btn btn-success">Save</button>                    
										<button type="button" id="clear_button" class="btn btn-warning">Clear</button>
										<button type="button" id="cancel_button" class="btn btn-danger">Cancel</button>
									@endif                         
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
	<script>
		var profile_image_url = "<?php echo asset('assets/images/user/admin'); ?>";
		alert(profile_image_url);
	</script>
		<script type="text/javascript" src="{{ asset('assets/js/page-js/center/center.js')}}"></script>

@endsection




