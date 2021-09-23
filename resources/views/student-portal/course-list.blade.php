@extends('student-portal.layout.master')
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-notebook  icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>{{  $data['type'] }} ABP Courses
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


        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card ">
                    <div class="card-body"> 
                        <h5 class="card-title">{{ $data['type'] }} course list</h5>
                        <div class="row">
							@if(count($data['batches'])==0)
							<div class="col-md-12 col-xs-12 alert alert-warning fade show">
								Unfortunately not found any course
							</div>
							@else
                            @foreach($data['batches'] as $batch)
                            <div class="col-md-3 col-xs-12">
                                <div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner {{ $data['background'] }}">
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
                                        <p class="mb-0"><span>Credit Hour</span> : &nbsp;{{ $batch->course->total_credit_hour}}</p>
                                        <p class="mb-0">Total Unit  &nbsp; &nbsp;&nbsp;: &nbsp;{{ count($batch->course->units) }}</p>
                                        <p >Semister No : {{ $batch->course->semester_no}}</p>
										<p class="text-success mb-0">Start Date : {{ $batch->start_date}}</p>
										<!--<p class="mb-0">Total Seat : {{ $batch->student_limit}}</p>
										<p  class="mb-0 {{ ($batch->total_enrolled_student<$batch->student_limit)?'text-success':'text-danger' }}">Available : {{ ($batch->student_limit-$batch->total_enrolled_student) }}</p>-->
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
                                        @if($batch->students->count()>0 && $batch->students[0]->getOriginal()['pivot_status'] =='Active')
                                            <button href="javascript:void(0)" class="btn btn-warning btn-sm  disabled" disabled >Enrolled</button>
                                        @elseif($batch->students->count()>0 && $batch->students[0]->getOriginal()['pivot_status'] =='Inactive')
                                            <a href="{{ url('portal/course/'.$batch->id) }}" class="btn-shadow-primary btn btn-danger btn-sm">Pending</a>
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

