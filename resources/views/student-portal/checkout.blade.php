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
                    <div>Checkout
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
        <div class="col-md-12">
            <div class="app-inner-layout__content card col-md-12">
                <div class="mb-3">
                    <div class="card-body">
                        <h5 class="card-title"> Payment Details</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <p><span><b>Student :</b></span> {{$student->student_no. " - ".$student->name }}</p>
                                <p><b>Course :</b> {{$payment->enrollment->batch->course->title. " (".$payment->enrollment->batch->course->short_name.")"}}</p>
                                <p><b>Batch :</b> {{$payment->enrollment->batch->batch_name}}</p>
                                <p><b>Installment No. :</b> {{$payment->installment_no}}</p>
                                <p><b>Payable Amount : </b> <span class="h6 "><b>{{$payment->payable_amount}}</b> Taka</span></p>
                            </div>  
                            <div class="col-md-8">
                                <!--<h6>Payment Method</h6> -->
                                <h6 class="card-title"> Payment Options</h6>
                                <fieldset class="position-relative form-group">
                                    <input type="hidden" id="payment_id" name="payment_id" value="{{$payment->id}}" />
                                    <input type="hidden" id="payment_amount" name="payment_amount" value="{{$payment->payable_amount}}" />
                                    
                                    <button class="your-button-class" id="sslczPayBtn"
                                        token="if you have any token validation"
                                        postdata="{{$payment->id}}"
                                        order="{{$payment->id}}"
                                        endpoint="{{url('portal/sslcommerz/pay-via-ajax')}}">Make Payment
                                    </button>
                                    
                                   
                                    <div class="position-relative form-check">
                                        <label class="form-check-label"><input name="payment_gateway"  value="bkash" type="radio" class="form-check-input"> Bkash</label>
                                    </div>
                                    <div class="col-md-12 payment_gateway_div alert alert-info" style="display: none" id="bkash_div">    
                                        <p> Bkash No : <b>{{$data['settings']['bkash_mobile_no']}}</b> </p>   
                                        <p>Please send the amount to the above bkash number. Dont forget to put the reference number.<br>
                                        Reference Number Format : <b>Student No.  Course Short Name  Batch No. </b>  </p>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">Bkash Reference No.</label>
                                                    <input  type="text"
                                                    required id="bkash_mobile_no"  name="bkash_mobile_no"  class="form-control col-md-6" />
                                                </div>
                                            </div>
                                        </div>                           
                                    </div>
                                    <div class="position-relative form-check">
                                        <label class="form-check-label"><input name="payment_gateway"  value="rocket" type="radio" class="form-check-input"> Rocket</label>
                                    </div>
                                    <div class="col-md-12 payment_gateway_div alert alert-info" style="display: none" id="rocket_div">    
                                        <p> Rocket No : <b>{{$data['settings']['rocket_mobile_no']}}</b> </p>   
                                        <p>Please send the amount to the above rocket number. Dont forget to put the reference number.<br>
                                        Reference Number Format : <b>Student No.  Course Short Name  Batch No. </b>  </p>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">Rocket Reference No.</label>
                                                    <input  type="text"
                                                    required id="rocket_mobile_no"  name="rocket_mobile_no"  class="form-control col-md-6" />
                                                </div>
                                            </div>
                                        </div>                           
                                    </div>
                                    <br>
                                    <button onClick="makePayment({{$payment->id}},{{$payment->payable_amount}})" id="make_payment_btn" class="btn btn-primary" >Make Payment</button>
                                </fieldset>
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

