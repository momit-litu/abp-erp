@extends('student-portal.layout.master')
@section('content')
<div class="app-main__outer" style="width:100% !important; padding-left:0px">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-notebook  icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>ABP Courses
                        <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-info" data-original-title="Example Tooltip">
                        Ongoing
                    </button>
                    <button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-info" data-original-title="Example Tooltip">
                        Upcoming
                    </button>
                </div>    
            </div>
        </div> 
        <div class="row">
            <div class="col-md-8">
			
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title">Featured</h5>
                        <div class="slider-light">
                            <div class="slick-slider-inverted">
                                @foreach($data['featured_batches'] as $key=>$batch)
								<div class="p-5 {{ $data['featured_batches_bg_color'][$key] }}">
                                    <div class="slider-content">
                                        <h3>{{ $batch->course->title}}</h3>
                                        <p>
                                           {{ strip_tags($batch->course->objective) }}
                                        </p>
                                        <button class="btn-icon btn btn-success btn-sm">View Profile</button>
                                    </div>
                                </div>
								@endforeach
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
            <div class="col-md-4">
                <div class="main-card mb-3 card">
                    <div class="grid-menu grid-menu-2col">
                        <div class="no-gutters row">
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                   <!-- <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-primary"></div>
                                        <i class="lnr-cog text-primary"></i></div> -->
                                    <div class="widget-numbers">1220</div>
                                    <div class="widget-subheading">Total Students</div>
                                    <div class="widget-description text-success">
                                        <i class="fa fa-angle-up ">
                                        </i>
                                        <span class="pl-1">25% More than last year</span>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                    <!-- <div class="icon-wrapper rounded-circle">
                                         <div class="icon-wrapper-bg bg-primary"></div>
                                         <i class="lnr-cog text-primary"></i></div> -->
                                     <div class="widget-numbers">450</div>
                                     <div class="widget-subheading">Certified</div>
                                     <div class="widget-description text-success">
                                         <span class="pl-1">98% Success rate</span>
                                     </div> 
                                 </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                    <!-- <div class="icon-wrapper rounded-circle">
                                         <div class="icon-wrapper-bg bg-primary"></div>
                                         <i class="lnr-cog text-primary"></i></div> -->
                                     <div class="widget-numbers">19</div>
                                     <div class="widget-subheading">Teachers</div>
                                     <div class="widget-description text-success">
                                        
                                         <span class="pl-1">All the top class teachers</span>
                                     </div> 
                                 </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                    <!-- <div class="icon-wrapper rounded-circle">
                                         <div class="icon-wrapper-bg bg-primary"></div>
                                         <i class="lnr-cog text-primary"></i></div> -->
                                     <div class="widget-numbers">25</div>
                                     <div class="widget-subheading">Courses</div>
                                     <div class="widget-description text-success">
                                         <i class="fa fa-angle-up ">
                                         </i>
                                         <span class="pl-1">35 batches Ongoing</span>
                                     </div> 
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card ">
                    <div class="card-body"> <h5 class="card-title">Ongoing course list</h5>
                        <div class="row">
							@if(count($data['running_batches'])==0)
							<div class="col-md-12 col-xs-12 alert alert-warning fade show">
								Unfortunately not found any course
							</div>
							@else
							@foreach($data['running_batches'] as $batch)
                            <div class="col-md-3 col-xs-12">
                                <div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-plum-plate">
                                            <div class="menu-header-content">
                                                <div><h5 class="menu-header-title">PGDHRM</h5><h6 class="menu-header-subtitle">Post Graduation on Human Resource Management</h6></div>
                                                <div class="menu-header-btn-pane">
                                                    <button class="mr-2 btn btn-dark btn-sm">View Promo Video</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Course Hour:100hr</p>
                                        <p class="mb-0">Total Unit:40</p>
                                        <p class="text-success">Course Fee: 50,000</p>
                                    </div>
                                    <div class="card mb-3 widget-content" style="margin-bottom:0px !important;">
                                        <div class="widget-content-wrapper ">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Course Fee</div>
                                                <div class="widget-subheading">50,000</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-warning"><span> 40,000</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block text-center card-footer bg-light">
                                        <button class="btn-shadow-primary btn btn-success btn-sm">Interested?</button>
                                        <button class="btn-shadow-primary btn btn-primary btn-sm">Details</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
							@endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card ">
                    <div class="card-body"> 
					<h5 class="card-title">Upcoming course list</h5>
                                                <div class="row">
							@if(count($data['upcoming_batches'])==0)
							<div class="col-md-12 col-xs-12 alert alert-warning fade show">
								Unfortunately not found any course
							</div>
							@else
							@foreach($data['upcoming_batches'] as $batch)
                            <div class="col-md-3 col-xs-12">
                                <div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-plum-plate">
                                            <div class="menu-header-content">
                                                <div>
												<h5 class="menu-header-title">{{$batch->course->short_name. $batch->batch_name }}</h5>
												<h7 class="menu-header-subtitle">{{ $batch->course->title }}</h7>
												</div>
													<div class="menu-header-btn-pane">
                                                    <a class="mr-2 btn btn-dark btn-sm" target="_blank" href="{{ $batch->course->youtube_video_link}}">View Promo Video</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">Credit Hour : &nbsp;{{ $batch->course->total_credit_hour}}</p>
                                        <p class="mb-0">Total Unit : &nbsp;{{ count($batch->course->units) }}</p>
                                        <p >Semister No : {{ $batch->course->semester_no}}</p>
										<p class="text-success mb-0">Start Date : {{ $batch->start_date}}</p>
										<p class="mb-0">Total Seat : {{ $batch->student_limit}}</p>
										<p  class="mb-0 {{ ($batch->total_enrolled_student<$batch->student_limit)?'text-success':'text-danger' }}">Available : {{ ($batch->student_limit-$batch->total_enrolled_student) }}</p>
                                    </div>
                                    <div class="card mb-3 widget-content" style="margin-bottom:0px !important;">
                                        <div class="widget-content-wrapper ">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Course Fee</div>
                                                <div class="widget-subheading text-danger"><del>{{ ($batch->fees > $batch->discounted_fees)?$batch->fees:$batch->fees }}</del></div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-warning"><span> {{ $batch->discounted_fees }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block text-center card-footer bg-light">
                                        <a href="{{ url('portal/course/'.$batch->id) }}" class="btn-shadow-primary btn btn-success btn-sm">Register</a>
                                        <a href="{{ url('portal/course/'.$batch->id) }}" class="btn-shadow-primary btn btn-primary btn-sm">Details</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
							@endif
                        </div>
                    </div>
                </div>
            </div>
		</div>             
    </div>   
</div>
@endsection

@section('JScript')
    <script type="text/javascript" src="{{ asset('assets/js/page-js/setting/setting.js')}}"></script>
@endsection

