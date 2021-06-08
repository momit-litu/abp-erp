@extends('layout.master')
@section('content')

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="admin_user_list_button" data-toggle="tab" href="#user_list_div">
                           <b> Qualification List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" href="#entry_form_div" id="admin_user_add_button">
	                           <b> Add Qualification</b>
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
									<table class="table table-bordered table-hover qualifications_table" id="qualifications_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>ID</th>
												<th>Qualification Code</th>
												<th>Qualification Title</th>											
												<th>Level </th>
												<th>TQT</th>
												<th>GLH</th>
												<th>No of Units</th>												
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
							<form id="qualification_form" name="qualification_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-10 col-sm-12">
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Qualification Code<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="code" name="code" required class="form-control col-md-6"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Qualification Title<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="title" name="title" required class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >TQT<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" readonly id="tqt" name="tqt" required value="0" autocomplete="off" class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Qualification Credit Hour<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" readonly id="total_credit_hour" name="total_credit_hour" autocomplete="off" required value="0" class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >GLH<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" readonly id="glh" name="glh" required value="0" autocomplete="off" class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Qualification Level<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<select id="level_id" name="level_id" class="form-control col-lg-12">
												@foreach($levels as $level )
												<option value="{{$level->id}}">{{$level->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Registration Fee (£)<span class="required">*</span></label>
										<div class="col-md-9 col-sm-9  col-xs-6">
											<input type="text" id="registration_fees" name="registration_fees"  class="form-control col-lg-12"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" >Active?</label>
										<div class="col-md-4 col-sm-4 col-xs-6">
											<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
										</div>
										<label class="control-label col-md-3" ></label>
									</div>
									<div class="ln_solid"></div>
								</div>
								<div class="col-md-10 col-sm-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" ></label>
										<div class="col-md-9 col-sm-9 col-xs-12"><b> Search and add Units for this qualification</b></div>
									</div>
									
									<div class="form-group ">
										<label class="control-label col-md-3 col-sm-3 col-xs-6" ></label>
										<div class="col-md-9 col-sm-9 col-xs-12 well">
											<input type="text" id="unit_name" name="unit_name" autocomplete="off" placeholder="Search units by code or unit name" class="form-control col-lg-12 bordered" />
											</br>
											<div class='' id="unit_list_table">
												<table class="table table-bordered table-hover unit_table" id="unit_table" style="width:100% !important"> 
													<thead>
														<tr>
															<th>Unit Code</th>
															<th>Name</th>											
															<th>GLH</th>
															<th>TUT</th>
															<th>Type</th>
															<th>Assessment Type</th>
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
							<div class="ln_solid"></br></br></br></div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									@if($actions['add_permisiion']>0)
										<button type="submit" id="save_qualification" class="btn btn-success">Save</button>                    
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
	<script type="text/javascript" src="{{ asset('assets/js/page-js/qualification/qualification.js')}}"></script>
@endsection


