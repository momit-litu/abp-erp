@extends('auth.layout.login-master')
@section('login-content')

<div class="app-container">
    <div class="h-100">
        <div class="h-100 no-gutters row">
             @include('auth.left-column')
            <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                <div class="mx-auto app-login-box col-sm-12 col-md-8 col-lg-6">
                    <div class="app-logo"><img src="{{ asset('assets/images/logo-inverse.png')}}" /> </div>
                    <h4>
                        <div>OTP Login</div>
                        <span>Use the form below to login with OTP</span></h4>
                    <div>
                        <form class="form-otp" action="{{url('auth/forget/password-otp/verify')}}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-row">
                                @if(Session::has('message'))
                                <div class="alert alert-success btn-squared col-md-12" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                                @endif
                                @if(Session::has('errormessage'))
                                <div class="alert alert-danger btn-squared  col-md-12" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('errormessage') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-row">
								<input type="hidden" name="user_id" id="user_id" value="{{$user_id}}" />								
                                <div class="col-md-12">
                                    <div class="position-relative form-group"><label for="exampleEmail" class="">OTP</label><input name="otp" id="otp" placeholder="enter otp here..." type="text" class="form-control @error('otp') is-invalid @enderror" value="{{ old('otp') }}"></div>
                                </div>
                            </div>				
                            <div class="mt-4 d-flex align-items-center"><h6 class="mb-0"><a href="{{url('/auth/login')}}" class="text-primary">Sign in existing account</a></h6>
                                <div class="ml-auto">
									<button class="btn btn-primary btn-lg">Verify</button>
                                </div>
                            </div>
                        </form>
						<form class="form-otp" action="{{url('auth/forget/password-otp')}}" method="post">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="mobile_no" id="mobile_no" value="{{$mobile_no}}" />
							<button class="btn btn-warning btn-sm">Send OTP again?</button>
						 </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection