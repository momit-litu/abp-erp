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
                    <div>Payment
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
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="app-inner-layout__wrapper row-fluid no-gutters row">
                            <div class="app-inner-layout__content card col-md-12">
                                <div class="pb-5 pl-5 pr-5 pt-3">
                                    <div class="dropdown-menu nav p-0 dropdown-menu-inline dropdown-menu-rounded dropdown-menu-hover-primary">
                                        @foreach ($batchStudents as $key=>$batch_student)
                                            <a data-toggle="tab" href="#tab-{{ $batch_student['id'] }}" class="mr-1 ml-1 border-0 btn-transition {{ ($key==0?'active':'') }} btn btn-outline-primary course-tab" id="course-tab-{{ $batch_student['id'] }}">{{ $batch_student['batch']['course']['title'] }} </a>	   
                                        @endforeach                                   
                                    </div>
                                    <div class="mobile-app-menu-btn mb-3">
                                        <button type="button" class="hamburger hamburger--elastic"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
                                    </div>
                                    <div class="tab-content">
                                        <div class="divider"></div>
                                        <br>
                                        @foreach ($batchStudents as $key=>$batch_student)
                                        <div class="tab-pane  {{ ($key==0?'active':'') }} " id="tab-{{ $batch_student['id'] }}" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="bg-warm-flame list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-wrapper">					
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading text-dark opacity-7"><h5>{{ $batch_student['batch']['course']['code'].'-'.$batch_student['batch']['course']['title'] }}</h5></div>
                                                                            <div class="widget-heading text-dark opacity-7">Batch {{$batch_student['batch']['batch_name']}}</div>
                                                                            <div class="widget-subheading opacity-10">Course Fee: 

                                                                            @if($batch_student['batch']['fees'] == $batch_student['batch']['discounted_fees'])
                                                                                <span><b class='text-dark'>{{ $batch_student['batch']['discounted_fees']}}+</b></span>
                                                                            @else        
                                                                                <span class='pr-2'><b class='text-danger'><del>{{$batch_student['batch']['fees']}}+</del></b></span><span><b class='text-dark'>{{$batch_student['batch']['discounted_fees']}}</b></span>
                                                                            @endif
                                                                            </div>
                                                                        </div>								
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="p-0 list-group-item">
                                                                <div class="grid-menu grid-menu-2col">
                                                                    <div class="no-gutters row">
                                                                        <div class="col-sm-6">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-info">
                                                                                <h5><strong>{{$batch_student['total_payable']}}</strong></h5>
                                                                                Payable Fee
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-success">
                                                                                <h5><strong>{{$batch_student['total_paid']}}</strong></h5>
                                                                                Total Paid
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-danger">
                                                                                <h5><strong>{{$batch_student['balance']}}</strong></h5>
                                                                                Balance
                                                                            </button>
                                                                        </div>
                                                                        
                                                                        <div class="col-sm-6">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-danger">
                                                                                <h5><strong>{{--$batch_student['payments'].count() --}}</strong></h5>
                                                                                
                                                                                Installment
                                                                            </button>
                                                                        </div>								
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>								
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="mb-0 table-bordered table table-sm ">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Installment No</th>
                                                            <th class="text-center">Payment Date</th>
                                                            <th class="text-right" width="100">Amount</th>
                                                            <th class="text-center">Invoice</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>	
                                                            @foreach ($batch_student['payments'] as $j=>$payment)		
                                                            <tr>
                                                                <th class="text-center">{{$payment['installment_no']}}</th>
                                                                <td class="text-center">{{$payment['last_payment_date']}}</td>
                                                                <td class="text-right">{{$payment['payable_amount']}}</td>
                                                                <td class="text-center">
                                                                    @if($payment['invoice_no'] == null)
                                                                        <a href="javascript:void(0)" onclick="paymentInvoice({{$payment['id']}})" >{{$payment['invoice_no']}}</a>
                                                                    @endif
                                                                </td>
                                                                <th class="text-center">
                                                                    @if($payment['payment_status'] == 'Paid')
                                                                    <button class='btn btn-xs btn-success' disabled>Paid</button>
                                                                    @else 
                                                                    <button class='btn btn-xs btn-danger' disabled>Due</button>
                                                                    @endif
                                                                </th>
                                                                <td class="text-center">
                                                                    @if($payment['payment_status'] != 'Paid')
                                                                    <button type="button" class="border-0 btn-transition btn btn-primary btn-sm" onclick="makePayment({{$payment['id']}}, {{$payment['payable_amount']}})">Pay</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="main-card mb-3 card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Payment Revise Request</h5>
                                                            <p class="text-danger">
                                                               If you want to change or customise the payment options. please write us with details. 
                                                            </p>
                                                            <div class="card-body">   
                                                                <form id="revise_form" autocomplete="off" name="payment_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                                                    @csrf
                                                                    <input type="hidden" name="revise_payment_id" id="revise_payment_id" value="{{$payment['id']}}" >
                                                                    <div class="row">                     
                                                                        <div class="form-row">
                                                                            <div class="col-md-12">
                                                                                <div class="position-relative form-group">
                                                                                    <label for="" class=""></label>
                                                                                    <textarea 
                                                                                    required id="revise_payment_details"  name="revise_payment_details"  class="form-control col-md-12"></textarea>
                                                                                </div>
                                                                                <button id="save_revise_request" class="btn btn-primary" >Request Revise Payment</button>
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
                                        @endforeach            
                                    </div>
                                </div>
                            </div>
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

