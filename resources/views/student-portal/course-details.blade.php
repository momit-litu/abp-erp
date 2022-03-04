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
                    <div>{{ $batch->course->title.' ('.$batch->course->short_name. $batch->batch_name.')' }}
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
                                        @if($batch->students->count()>0)
                                            <a href="{{url('portal/courses/my/'.$batch->running_status)}}">My Course List </a>
                                        @else
                                        <a href="{{url('portal/courses/'.$batch->running_status)}}">Course List </a>
                                        @endif
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">

                    @if(!Auth::check() && $batch->total_enrolled_student<$batch->student_limit)
                    <button type="button" id="start_registration_sm" title="registration" data-placement="bottom" class="btn-shadow mr-3 btn btn-success btn-lg ">
                        Register
                   </button>
                    @elseif($batch->students->count()==0 && $batch->total_enrolled_student<$batch->student_limit)
                        <button type="button" id="start_registration" title="registration" data-placement="bottom" class="btn-shadow mr-3 btn btn-success btn-lg">
                            Register
                        </button>
                    @endif

                    <button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-info disabled">
                       {{ $batch->running_status }}
                    </button>
                    @if($batch->students->count()>0)
						@if(Auth::check())
							<button href="javascript:void(0)" class="btn btn-warning btn-sm  disabled" disabled >Enrolled</button>
						@endif
					@else
                        <button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn  {{ ($batch->total_enrolled_student<$batch->student_limit)?'btn-success':'btn-danger' }} disabled" data-original-title="Example Tooltip">
                            {{ ($batch->total_enrolled_student < $batch->student_limit)?'Registration Available ':'Registration Closed' }}
                        </button>
                    @endif                  
                </div>    
            </div>
        </div> 
        <div class="row">
            
           <!-- <div class="col-md-3">
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title"></h5>
                        <div class="thumbnail text-center photo_view_postion_b" >
                            <div class="student_profile_image" >
                                <img style="width:100%" src="{{ ($batch->course->course_profile_image)?asset('assets/images/courses/'.$batch->course->course_profile_image):asset('assets/images').'/no_image.png' }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="col-md-12">
                <!--iv class="main-card mb-3 card">
                    <div class="no-gutters row">
                        <div class="col-md-4">
                            <div class="widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-right ml-0 mr-3">
                                        <div class="widget-numbers text-success"> {{ $batch->student_limit}}</div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Seat</div>
                                        <div class="widget-subheading">No of seat may increase</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-right ml-0 mr-3">
                                        <div class="widget-numbers text-warning">{{$batch->total_enrolled_student}}</div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Enrolled Student</div>
                                        <div class="widget-subheading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-right ml-0 mr-3">
                                        <div class="widget-numbers text-danger"> 
                                            <span  class=" {{ ($batch->total_enrolled_student<$batch->student_limit)?'text-success':'text-danger' }}">{{ ($batch->student_limit-$batch->total_enrolled_student) }}</span>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            <span  class=" {{ ($batch->total_enrolled_student<$batch->student_limit)?'text-success':'text-danger' }}">
                                                {{ ($batch->total_enrolled_student<$batch->student_limit)?"Available":"Booked" }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            -->
                <div class="main-card mb-3 card">
                    <div class="card-body">
					@if(Auth::check())
                        @if($batch->students->count()==1 && $batch->students[0]->pivot->status =='Inactive')
                            <div class="alert alert-danger ">
                                <button class="btn btn-sm btn-danger disabled">Registration Pending</button><br>
                                You registration to this course is still pending. Please make the payment to enroll.
                            </div>
                        @elseif($batch->students->count()>0 && $batch->students[0]->pivot->status =='Active')
                            <div class="alert alert-warning ">
                                <h6>Student Course Enrollment ID : <b>{{ $batch->students[0]->pivot->student_enrollment_id}}</b></h6>
                            </div>
                        @endif
					 @endif	
                        <h5 class="card-title">Details</h5>
                        <p>
                            {{ strip_tags($batch->course->objective) }}
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Course Title</div>
                                                    <div class="widget-subheading">{{ $batch->course->title.' ('.$batch->course->short_name.')' }}</div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">                               
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Batch</div>
                                                    <div class="widget-subheading">{{ $batch->batch_name}}</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    @if($batch->running_status=='Running')
                                                        <div class="badge badge-info">{{ $batch->running_status}}</div>
                                                    @elseif($batch->running_status=='Completed')
                                                        <div class="badge badge-success">{{ $batch->running_status}}</div>
                                                    @elseif($batch->running_status=='Upcooming')
                                                        <div class="badge badge-warning">{{ $batch->running_status}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @if($batch->show_seat_limit=='Yes' )
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Total Seat :  {{ $batch->student_limit}}</div>
                                                        <div class="widget-subheading"> Available : {{ ($batch->student_limit-$batch->total_enrolled_student) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endIf   
                                    
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Start Date</div>
                                                    <div class="widget-subheading">{{ $batch->start_date}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Class Time</div>
                                                    <div class="widget-subheading">{{ $batch->class_schedule}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @if($batch->end_date!='')
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">End Date</div>
                                                    <div class="widget-subheading">{{ $batch->end_date}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                   <!-- <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Trainer</div>
                                                    <div class="widget-subheading">{{  $batch->course->trainers}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li> -->
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Total Credit Hour</div>
                                                    <div class="widget-subheading">{{  $batch->course->tqt}}</div>
                                                </div>                                               
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Study Mode</div>
                                                    <div class="widget-subheading">{{  $batch->course->study_mode}}</div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <br>

                                    @if(!Auth::check() && $batch->total_enrolled_student<$batch->student_limit)
										<button type="button" id="start_registration" title="registration" data-placement="bottom" class="btn-shadow mr-3 btn btn-success btn-lg col-md-12">
                                            Register for this course
                                       </button>
								    @elseif($batch->students->count()==0 && $batch->total_enrolled_student<$batch->student_limit)
                                        <button type="button" id="start_registration" title="registration" data-placement="bottom" class="btn-shadow mr-3 btn btn-success btn-lg col-md-12">
                                            Register for this course
                                        </button>
                                    @endif

                                </li>
                                </ul>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5"> 
                                
                                @if(Auth::check() && count($batch->books) > 0)
                                    <span class="card-title">Sent Books : </span>
                                    @foreach($batch->books as $book)
                                        <span class="badge badge-success">{{ $book->book_no }}</span>
                                    @endforeach
                                    <p>&nbsp;</p>                                
                                @endif

                                @if(Auth::check() && $batch->payments != "")
                                    <h5 class="card-title">Payment Details</h5>
                                    <div class="card mb-3 widget-chart widget-chart2 bg-focus text-left">
                                        <div class="widget-chart-content text-white">
                                            <div class="widget-chart-flex">
                                                <div class="widget-title">Total Payable
                                                    <div class="text-warning"><del>{{ ($batch->students[0]->pivot->total_payable < $batch->discounted_fees)?$batch->students[0]->pivot->total_payable:"" }}</del></div>
                                                </div>  
                                                <div class="widget-subtitle">Total Paid
                                                    <div class="text-dark">{{ ($batch->students[0]->pivot->total_payable <  $batch->discounted_fees)?".":"" }}
                                                    </div>    
                                                </div>                                              
                                            </div>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers widget-numbers ">{{ $batch->students[0]->pivot->total_payable }}
                                                </div>
                                                <div class="widget-description  widget-numbers">
                                                    @if($batch->payments[0]->payment_status == 'Paid')
                                                        <span class="text-success">{{ $batch->students[0]->pivot->total_paid}}</span>
                                                    @else
                                                        <span class="text-danger">{{ $batch->students[0]->pivot->total_paid}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">                                     
                                        <table class="mb-0 table-bordered table table-sm ">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Ins. No</th>
                                                <th class="text-center">Month</th>
                                                <th class="text-right">Amount</th> 
                                                <th class="text-center">Staus</th> 
                                                <th class="text-center"></th>                                                   
                                            </tr>
                                            </thead>
                                            <tbody>	
                                                @foreach($batch->payments as $key=>$payment)		
                                                    <tr>
                                                        <th class="text-center">{{$payment->installment_no}}</th>
                                                        <td class="text-center">{{$payment->last_payment_date}}</td>
                                                        <td class="text-right">{{$payment->payable_amount}}</td>
                                                        <td class="text-center">
                                                            @if(strtotime($payment->last_payment_date)< strtotime(date('Y-m-d')) && $payment->payment_status != 'Paid')
                                                                <span class='text-danger'>Due</span>
                                                            @elseif(strtotime($payment->last_payment_date)>= strtotime(date('Y-m-d')) && $payment->payment_status != 'Paid')
                                                                <span class='text-warning'>Upcoming</span>
                                                            @else
                                                                <span class='text-success'>Paid</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($payment['payment_status'] != 'Paid')
                                                                <a type="button" class="border-0 btn-transition btn btn-primary btn-sm" href="{{ url('portal/checkout/'.$payment['id'])}}">Pay</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h5 class="card-title">Fee Details</h5>
                                    <div class="card mb-3 widget-chart widget-chart2 bg-focus text-left">
                                        <div class="widget-chart-content text-white">
                                            <div class="widget-chart-flex">
                                                <div class="widget-title">Onetime Payment</div>
                                                <div class="widget-subtitle text-warning"><del>{{ ($batch->fees > $batch->discounted_fees)?$batch->fees:$batch->fees }}</del></div>
                                            </div>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers">{{ $batch->discounted_fees }}
                                                </div>
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
                                            @foreach($batch->batch_fees as $key=>$batch_fee)
                                            @if($batch_fee->plan_name != "Onetime")
                                            <div class="tab-pane {{($key==1)?'active':''}}" id="tab-animated-{{$key}}" role="tabpanel">
                                                <table class="mb-0 table-bordered table table-sm ">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Instalment No</th>
                                                        <th class="text-right">Amount</th>                                               
                                                    </tr>
                                                    </thead>
                                                    <tbody>										
                                                        @foreach($batch_fee->installments as $k=>$installment)
                                                        <tr>
                                                            <th class="text-center">{{$installment->installment_no}}</th>   
                                                            <td class="text-right">{{$installment->amount}}</td> 
                                                        </tr>
                                                        @endforeach 
                                                        <tr>
                                                            <td class="text-right"><b>Total Payable Amount</b></td>
                                                            <td class="text-right"><b>
                                                           {{$batch_fee->installments->sum('amount')}}</b>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif
                                            @endforeach                                       
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="card-title">More Details:</h5>
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-0" class="nav-link active">Units</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-1" class="nav-link ">Semester Details</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-2" class="nav-link show ">Admission requirements</a></li>
                           
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-4" class="nav-link  show">Assessment</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-5" class="nav-link  show">Grading System</a></li>
                            
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-eg11-0" role="tabpanel">
                                @foreach($batch->course->units as $key=>$unit)		
                                      &nbsp; &nbsp; Unit {{$key+1}}: {{ strip_tags($unit->name) }}</br>
								@endforeach
                            </div>
                            <div class="tab-pane" id="tab-eg11-1" role="tabpanel"><p>  		 <?php echo $batch->course->semester_details; ?></p></div>
                            <div class="tab-pane show" id="tab-eg11-2" role="tabpanel"><p>   <?php echo $batch->course->requirements; ?> </p></div>                            
                            <div class="tab-pane  show" id="tab-eg11-4" role="tabpanel"><p>  <?php echo $batch->course->assessment; ?></p></div>
                            <div class="tab-pane  show" id="tab-eg11-5" role="tabpanel"><p>  <?php echo $batch->course->grading_system; ?> </p></div>
                            <div class="tab-pane  show" id="tab-eg11-6" role="tabpanel"><p>
                            </p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>             
    </div>  
</div>

@endsection


@section('JScript')
    <script type="text/javascript" src="{{ asset('assets/js/page-js/student-portal/student-portal.js')}}"></script>
@endsection

