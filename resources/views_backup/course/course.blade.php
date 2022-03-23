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
							<span class="d-inline-block">Course Management</span>
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
				<div class="page-title-actions">
					<button type="button" onclick='courseAdd()' title="Add New Course" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
						<i class="fa fa-plus"></i>
						Add New Course
					</button>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-body">
				<table class="table table-bordered table-hover courses_table" id="courses_table" style="width:100% !important">
					<thead>
						<tr>
							<th>ID</th>
							<th>Course ID</th>
							<th>Course Title</th>											
							<th>Level </th>
							<th>TQT</th>
							<th>GLH</th>
							<th>No of Units</th>												
							<th class="hidden-xs">Status</th>
							<th class="text-center" width="80">Actions</th>
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
<div class="modal fade" id="entry-form" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<form id="course_form" autocomplete="off" name="course_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
							@csrf
							<input type="hidden" name="edit_id" id="edit_id">
							<div class="row">
								<div class="col-md-12">
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label class="">Course ID <span class="required">*</span></label>
												<input type="text" id="code" name="code" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label  >Short Name<span class="required">*</span></label>
												<input type="text" id="short_name" name="short_name" class="form-control col-lg-12" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="position-relative form-group">
												<label >Short Name For ID<span class="required">*</span></label>
												<input type="text" id="short_name_id" name="short_name_id" class="form-control col-lg-12" />
											</div>
										</div>
										
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  >Course Title<span class="required">*</span></label>
												<input type="text" id="title" name="title" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  >Objective<span class="required">*</span></label>
												<textarea name="objective" id="objective" class='ckeditor'></textarea>
											</div>
										</div>
									</div>					
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">TQT<span class="required">*</span></label>
												<input type="text" id="tqt" name="tqt" value="0" required class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  class="">Course Credit Hour <span class="required">*</span></label>
												<input type="text" id="total_credit_hour" name="total_credit_hour" class="form-control  col-lg-12"  value="0" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">GLH<span class="required">*</span></label>
												<input type="text" id="glh" name="glh" required   value="0" class="form-control col-lg-12"/>
											</div>
										</div>	 
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  class="">Course Level<span class="required">*</span>  </label>
												<select id="level_id" name="level_id" class="form-control col-lg-12">
													@foreach($levels as $level )
													<option value="{{$level->id}}">{{$level->name}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Registration Fee<span class="required">*</span></label>
												<input type="text" id="registration_fees" name="registration_fees"  class="form-control col-lg-12"/>
											</div>
										</div>	
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label class="">Mode of Study </label>
												<select id="study_mode" name="study_mode" class="form-control col-lg-12">
												<option value="Online">Online</option>
												<option value="Campus">On-Campus</option>
											</select>
											</div>
										</div>									
									</div>
									<hr>
									<div class="form-row bg-gray ">
										<div class="col-md-12"><b> Search and add Units for this course</b></div><br>
										<input type="text" id="unit_name" name="unit_name" autocomplete="off" placeholder="Search units by code or unit name" class="form-control col-lg-12 bordered" />
										<br>											
										<table class="table table-bordered table-hover unit_table" id="unit_table" style="width:100% !important"> 
											<thead>
												<tr>
													<th>Unit Code</th>
													<th>Name</th>										
													<th>GLH</th>
													<th>TUT</th>
													<th>Type</th>
													<th>Assessment Type</th>
													<th width='80' ></th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Trainers<span class="required">*</span></label>
												<input type="text" id="trainers" name="trainers" class="form-control col-lg-12" />
											</div>
										</div>
									</div>  
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Accredited By</label>
												<textarea name="accredited_by" id="accredited_by" class='ckeditor'></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Awarder by<span class="required">*</span></label>
												<input type="text" id="awarder_by" name="awarder_by" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  class="">Semester<span class="required">*</span></label>												
												<input type="text" id="semester_no" name="semester_no" min="1" max="2" class="form-control col-lg-12">
											</div>
										</div> 
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label  class="">Programme Duration<span class="required">*</span></label>
												<input type="text" id="programme_duration" name="programme_duration" class="form-control col-lg-12" />
											</div>
										</div>
									</div>	
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label class="">Semester Details</label>
												<textarea name="semester_details" id="semester_details"></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Assesment</label>
												<textarea name="assessment" id="assessment"></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Grading System<span class="required">*</span></label>
												<textarea name="grading_system" id="grading_system"></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Requirements<span class="required">*</span></label>
												<textarea name="requirements" id="requirements"></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Experience Required</label>
												<textarea name="experience_required" id="experience_required"></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<label  class="">Youtube Video Link</label>
												<input type="text" id="youtube_video_link" name="youtube_video_link" class="form-control col-lg-12" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<div class="position-relative form-group">
												<label for="company_name" class="">Active?</label>
												<input type="checkbox" id="status" name="status" checked="checked" value="1" class="form-control col-lg-12"/>
											</div>
										</div>
										<div class="col-md-2"></div>
										<div class="col-md-4">		
											<label>Cover Photo</label>									
											<img src="{{asset('assets/images/courses')}}/no-user-image.png" width="50%" height="50%" class="img-thumbnail" id="course_image">
											<span class="btn btn-light-grey btn-file">
												<span class="fileupload-new"><i class="fa fa-picture-o"></i> </span>
												<input type="file" class="form-control col-lg-12" name="course_profile_image" id="course_profile_image" value="">
											</span>
										</div>
									</div>
																		
								</div>							
							</div>
							<div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="form_submit_error" class="text-center" style="display:none"></div>
                                </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="col-md-12" style="display: flex; flex-direction: row;">
					<div class="col-md-3 text-left">
						@if($actions['add_permisiion']>0)
						<button type="submit" id="save_course" class="btn btn-success  btn-lg btn-block">Save</button>

					@endif
					</div>
					<div class="col-md-9 text-right">
						<button type="button" id="clear_button" class="btn btn-warning">Clear</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection
@section('JScript')	

<script type="text/javascript">
	const course_profile_image = "<?php echo asset('assets/images/courses/'); ?>";
	createEditor('objective');
	createEditor('accredited_by');
	createEditor('semester_details');
	createEditor('assessment');
	createEditor('grading_system');
	createEditor('requirements');
	createEditor('experience_required');
</script>	
<script type="text/javascript" src="{{ asset('assets/js/page-js/course/course.js')}}"></script>
@endsection


