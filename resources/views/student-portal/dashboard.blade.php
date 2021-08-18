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
                    <a href="{{url('portal/courses/Running')}}" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-info" data-original-title="Example Tooltip">
                        Ongoing
                    </a>
                    <a href="{{url('portal/courses/Upcoming')}}" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-info" data-original-title="Example Tooltip">
                        Upcoming
                    </a>
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
                                        <a href="{{ url('portal/course/'.$batch->id)}}" class="btn-icon btn btn-success btn-sm">View Profile</a>
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
                                <!--   <div class="widget-chart widget-chart-hover"> -->
                                <div class="widget-chart ">
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
                                <div class="widget-chart">
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
                                <div class="widget-chart">
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
                                <div class="widget-chart">
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
                    <div class="card-body"> 
                        <h5 class="card-title">Ongoing course list <span></span>&nbsp;
                            @if(count($data['running_batches'])>0)
                                <a href="{{url('portal/courses/Running')}}" class=" mb-2 mr-2 btn-hover-shine btn btn-info btn-sm" >Show All</a>
                            @endif
                        </h5>
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
                                        <div class="dropdown-menu-header-inner  bg-happy-green">
                                            <div class="menu-header-content">
                                                <div class="fixed-title-height">
												<h5 class="menu-header-title">{{$batch->course->short_name. $batch->batch_name }}</h5>
												<h6 class="menu-header-subtitle">{{ $batch->course->title }}</h6>
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
                                        @if($batch->students->count()>0)
                                            <button href="javascript:void(0)" class="btn btn-warning btn-sm  disabled" disabled >Registered already</button>
                                        @else
                                            <a href="{{ url('portal/course/'.$batch->id) }}" class="btn-shadow-primary btn btn-success btn-sm">Register</a>
                                        @endif
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
            <div class="col-md-12">
                <div class="main-card mb-3 card ">
                    <div class="card-body"> 
                        <h5 class="card-title">Upcoming course list <span></span>&nbsp;
                            @if(count($data['upcoming_batches'])>0)
                            <a href="{{url('portal/courses/Upcoming')}}" class=" mb-2 mr-2 btn-hover-shine btn btn-info btn-sm" >Show All</a>
                            @endif
                        </h5>
					
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
                                                <div class="fixed-title-height">
												<h5 class="menu-header-title">{{$batch->course->short_name. $batch->batch_name }}</h5>
												<h6 class="menu-header-subtitle">{{ $batch->course->title }}</h6>
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
                                        @if($batch->students->count()>0)
                                            <button href="javascript:void(0)" class="btn btn-warning btn-sm  disabled" disabled >Registered already</button>
                                        @else
                                            <a href="{{ url('portal/course/'.$batch->id) }}" class="btn-shadow-primary btn btn-success btn-sm">Register</a>
                                        @endif
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

