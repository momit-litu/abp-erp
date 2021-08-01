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
                    <div>{{ $batch->course->title }}
                        <div class="page-title-subheading">
                           {{$batch->course->short_name. $batch->batch_name }}
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-info disabled">
                       {{ $batch->running_status }}
                    </button>
                    <button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-success disabled" data-original-title="Example Tooltip">
                       {{ ($batch->total_enrolled_student < $batch->student_limit)?'Registration Available ':'Batch Full' }}
                    </button>
                </div>    
            </div>
        </div> 
        <div class="row">
            
            <div class="col-md-3">
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title"></h5>
                        <div class="thumbnail text-center photo_view_postion_b" >
                            <div class="student_profile_image" >
                                <img style="width:100%" src="{{ ($batch->course->course_profile_image)?asset('assets/images/courses/'.$batch->course->course_profile_image):asset('assets/images/courses').'/no-user-image.png' }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="main-card mb-3 card">
                    <div class="no-gutters row">
                        <div class="col-md-4">
                            <div class="widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-right ml-0 mr-3">
                                        <div class="widget-numbers text-success">1896</div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Cirtified Student</div>
                                        <div class="widget-subheading">need to provide some slogan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-right ml-0 mr-3">
                                        <div class="widget-numbers text-warning">14</div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Completed Batch</div>
                                        <div class="widget-subheading">need to provide some slogan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-right ml-0 mr-3">
                                        <div class="widget-numbers text-danger">2</div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Open Batch</div>
                                        <div class="widget-subheading">Batch 15 , Bach 16</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Details</h5>
                                <p>
                                    {{ strip_tags($batch->course->objective) }}
                                </p>
                        <div class="row">
                            <div class="col-md-5">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Alina Mcloughlin</div>
                                                    <div class="widget-subheading">A short profile description</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div role="group" class="btn-group-sm btn-group">
                                                        <button type="button" class="btn-shadow btn btn-primary">Hire</button>
                                                        <button type="button" class="btn-shadow btn btn-primary">Fire</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">                               
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Ruben Tillman</div>
                                                    <div class="widget-subheading">Etiam sit amet orci eget eros faucibus</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="badge badge-danger">NEW</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Vinnie Wagstaff</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <button class="btn-pill btn-hover-shine btn btn-focus btn-sm">Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">                                                    
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Ella-Rose Henry</div>
                                                    <div class="widget-subheading">Lorem ipsum dolor sit amet, consectetuer</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary"><span class="count-up-wrapper">$101</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <br>
                                    <button type="button" title="registration" data-placement="bottom" class="btn-shadow mr-3 btn btn-success btn-lg col-md-12"  data-toggle="modal" data-target="#registration-modal">
                                        Register to this course
                                    </button>
                                </li>
                                </ul>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-5">
                                <h5 class="card-title">Fees Details</h5>
                                <div class="card mb-3 widget-chart widget-chart2 bg-focus text-left">
                                    <div class="widget-chart-content text-white">
                                        <div class="widget-chart-flex">
                                            <div class="widget-title">Onetime Payment</div>
                                            <div class="widget-subtitle text-warning"><del>{{ ($batch->fees > $batch->discounted_fees)?$batch->fees:$batch->fees }}</del></div>
                                        </div>
                                        <div class="widget-chart-flex">
                                            <div class="widget-numbers">{{ $batch->discounted_fees }}
                                            </div>
                                            <!--<div class="widget-description ml-auto text-warning"><span class="pr-1">45</span>
                                                <i class="fa fa-angle-up "></i>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="tabs-animated-shadow tabs-animated nav">
                                        @foreach($batch->batch_fees as $key=>$batch_fee)		
											@if($batch_fee->plan_name != "Onetime")
											<li class="nav-item">
												<a role="tab" class="nav-link {{($key==1)?'active':''}}" id="tab-c-0" data-toggle="tab" href="#tab-animated-{{$key}}">
													<span>{{ $batch_fee->plan_name}}</span>
												</a>
											</li>
											@endif
										@endforeach
										
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                                            <table class="mb-0 table-bordered table table-sm ">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Installment No</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-right">Amount</th>                                                    
                                                </tr>
                                                </thead>
                                                <tbody>									
                                                    <tr>
                                                        <th class="text-center">1</th>
                                                        <td class="text-center">6</td>
                                                        <td class="text-right">11000</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">2</th>
                                                        <td class="text-center">6</td>
                                                        <td class="text-right">11000</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">3</th>
                                                        <td class="text-center">6</td>
                                                        <td class="text-right">11000</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-right"><b>Total Payable Amount</b></td>
                                                        <td class="text-right"><b>
                                                         33,000 </b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                

                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title">More Details:</h5>
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-0" class="nav-link active">Units</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-1" class="nav-link ">Semester Details</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-2" class="nav-link show ">Requirements</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-3" class="nav-link show ">Require Experience</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-4" class="nav-link  show">Assessment</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-5" class="nav-link  show">Grading System</a></li>
                            
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-eg11-0" role="tabpanel">
                                @foreach($batch->course->units as $key=>$unit)		
                                      &nbsp; &nbsp; Unit {{$key+1}}: {{ strip_tags($unit->name) }} ({{$unit->tut}})</br>
								@endforeach
                            </div>
                            <div class="tab-pane" id="tab-eg11-1" role="tabpanel"><p>  		 <?php echo $batch->course->semester_details; ?></p></div>
                            <div class="tab-pane show" id="tab-eg11-2" role="tabpanel"><p>   <?php echo $batch->course->requirements; ?> </p></div>
                            <div class="tab-pane  show" id="tab-eg11-3" role="tabpanel"><p>  <?php echo $batch->course->experience_required; ?> </p></div>
                            <div class="tab-pane  show" id="tab-eg11-4" role="tabpanel"><p>  <?php echo $batch->course->assessment; ?></p></div>
                            <div class="tab-pane  show" id="tab-eg11-5" role="tabpanel"><p>  <?php echo $batch->course->grading_system; ?> </p></div>
                            <div class="tab-pane  show" id="tab-eg11-6" role="tabpanel"><p>
                            </p></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                
            </div>
            <div class="col-md-12">
                
            </div>
        </div>             
    </div>  
    
</div>

@endsection


@section('JScript')
    <script type="text/javascript" src="{{ asset('assets/js/page-js/setting/setting.js')}}"></script>
@endsection

