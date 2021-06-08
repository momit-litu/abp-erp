@extends('layout.master')
@section('content')

    <!--PAGE CONTENT -->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                    <li class="active">
                        <a id="certificate_list_button" data-toggle="tab" class="result-tab" href="#user_list_div">
                           <b> Learner Cirtificate List</b>
                        </a>
                    </li>
                    @if($actions['add_permisiion']>0)
	                    <li class="">
	                        <a data-toggle="tab" class="result-tab" href="#entry_form_div"  id="save_certificate_button">
	                           <b> Assign Cirtificate No.</b>
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
									<table class="table table-bordered table-hover certificate_table" id="certificate_table" style="width:100% !important"> 
										<thead>
											<tr>
												<th>ID</th>
												<th>Centre name</th>	
												<th>Reg. No.</th>
												<th>Invoice No.</th>																					
												<th>Qualification Title</th>
												<th>Learner name</th>
												<th>Result</th>
												<th>Certificate No.</th>
												<th class="text-center">Print status</th>										
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
						<form id="certificate_form" name="certificate_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
						@csrf
                        <div class="row no-margin-row">	
							<div id="result_div"></div>
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-10 col-sm-12">
								<br><br>
									<div class="form-group"> 
										<label class="control-label col-md-4 col-sm-4 col-xs-6" ><strong>Assign Certificate No</h4></strong></label>
										<div class="col-md-8 col-sm-8  col-xs-6">
											<input type="text"  id="certificate_no" name="certificate_no"  class="form-control col-md-12 bordered"  autocomplete="off"/></br></br></br>
											@if($actions['add_permisiion']>0)
												 <button type="submit" id="save_certificate" class="btn btn-lg btn-success">Save Cetificate No</button>                   
											@endif 
										</div>
									</div>								
								</div>
							</div>
						</div>
						</form>
                    </div>
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
		const logo_url 			= "<?php echo asset('assets/images/logo.png') ; ?>";
		const plugin_url 		= "<?php echo asset('assets/plugins') ; ?>";
	</script>
	<script type="text/javascript" src="{{ asset('assets/js/page-js/registration/registration.js')}}"></script>
@endsection


