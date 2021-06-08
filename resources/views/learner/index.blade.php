@extends('layout.master')
@section('content')

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="admin_user_list_button" data-toggle="tab" href="#user_list_div">
                           <b> Learner List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" href="#entry_form_div" id="admin_user_add_button">
	                           <b> Add Learner</b>
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
									<table class="table table-bordered table-hover learners_table" id="learners_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>ID</th>
												<th></th>
												<th>Centre Name </th>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Email</th>											
												<th>Contact No. </th>
												<th>Address </th>											
												<th class="hidden-xs">Status</th>
												<th>Actions</th>
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
							<form id="learner_form" name="learner_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-9">
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">First Name<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="first_name" name="first_name" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Last Name</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="last_name" name="last_name" class="form-control col-lg-12" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Contact No. <span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="contact_no" name="contact_no" required class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Email<span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="email" id="email" name="email" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Address</label>
										<div class="col-md-10 col-sm-10  col-xs-6">
											<input type="text" id="address" name="address" class="form-control col-lg-12" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">National ID No. </label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="text" id="nid_no" name="nid_no"  class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Date of Birth</label>
										<div class="col-md-3 col-sm-3  col-xs-6">
											<input type="date" id="date_of_birth" name="date_of_birth"  class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6" >Active?</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="checkbox" id="status" name="status" checked="checked"  class="form-control col-lg-12"/>
										</div>
									</div>
									<br/>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-6">Remarks</label>
										<div class="col-md-10 col-sm-10 col-xs-12">
											<textarea rows="2" cols="100" id="remarks" name="remarks" class="form-control col-lg-12"></textarea> 
										</div>
									</div>
									<div class="ln_solid"></div>
								</div>
								<div class="col-md-3 text-center">
									<img src="{{asset('assets/images/user/admin')}}/no-user-image.png" width="70%" height="70%" class="img-thumbnail" id="user_image">

									<span class="btn btn-light-grey btn-file">
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span>
										<input type="file" name="user_profile_image" id="user_profile_image" value="">
									</span>
								</div>
							</div>
							<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								@if($actions['add_permisiion']>0)
									<button type="submit" id="save_learner" class="btn btn-success">Save</button>                    
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
	const learner_image_url = "<?php echo asset('assets/images/learner'); ?>";
	const user_type = "<?php echo $userType; ?>";
</script>
<script type="text/javascript" src="{{ asset('assets/js/page-js/learner/learner.js')}}"></script>
@endsection


