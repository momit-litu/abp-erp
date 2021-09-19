@extends('auth.layout.login-master')
@section('login-content')
<div class="app-container">
    <div class="h-100">
        <div class="h-100 no-gutters row">
            <div class="d-none d-lg-block col-lg-4">
                <div class="slider-light">
                    <div class="slick-slider">
                        <div>
                            <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-plum-plate" tabindex="-1">
                                <div class="slide-img-bg" style="background-image: url({{ asset('assets/theme/assets/images/originals/1st.jpg')}}"></div>
                                <div class="slider-content"><h3>Easy Access</h3>
                                    <p>Connect with mobile apps from anywhere.</p></div>
                            </div>
                        </div>
                        <div>
                            <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                <div class="slide-img-bg" style="background-image: url({{ asset('assets/theme/assets/images/originals/2nd.jpg')}}"></div>
                                <div class="slider-content"><h3>Online Payment</h3>
                                    <p>Easy payment system through card, bkash and rocket payment </p></div>
                            </div>
                        </div>
                        <div>
                            <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                <div class="slide-img-bg" style="background-image: url({{ asset('assets/theme/assets/images/originals/3rd.jpg')}}"></div>
                                <div class="slider-content"><h3>Connecting Profesisonals</h3>
                                    <p>Here you have the opportunity to blade with different professionals people.</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                    <div class="app-logo"><img src="{{ asset('assets/images/logo-inverse.png')}}" /> </div>
                    <h4 class="mb-0">
                        <span class="d-block">Welcome</span>
                        <span>It only takes a few seconds to create your account.</span></h4>
                    <div class="divider row"></div>
                    <div>
                        <form class="form-register" action="{{ url('auth/register') }}" method="post">
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
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="exampleEmail" class="">Name<span class="text-danger">*</span></label><input name="name" id="name" placeholder="Name here..." type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" ></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="exampleEmail" class="">Email<span class="text-danger">*</span></label><input  recuired name="email" id="email" placeholder="Email here..." type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" ></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="examplePassword" class="">Contact No <span class="text-danger">*</span></label><input recuired name="contact" id="contact" placeholder="Contact No here..." type="text" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" ></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="examplePassword" class="">Password<span class="text-danger">*</span></label><input  recuired name="password" id="password" placeholder="Password here..." type="password" class="form-control @error('password') is-invalid @enderror" ></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="examplePassword" class="">Confirm Password<span class="text-danger">*</span></label><input  recuired name="confirm_password" id="confirm_password" placeholder="Confirm Password ..." type="password" class="form-control @error('confirm_password') is-invalid @enderror"></div>
                                </div>
                            </div>
                            <div class="mt-3 position-relative form-check"><input name="terms_condition" id="terms_condition" type="checkbox" class="form-check-input @error('terms_condition') is-invalid @enderror"><label for="exampleCheck" class="form-check-label" >Accept our <a data-toggle="modal" data-target="#terms-modal" href="javascript:void(0)">Terms and Conditions</a>.</label></div>
                            <div class="divider row"></div>
                            <div class="mt-4 d-flex align-items-center"><h5 class="mb-0">Already have an account? <a href="{{url('/login')}}" class="text-primary">Sign in</a></h5>
                                <div class="ml-auto">
                                    <button type="submit" class="btn btn-primary btn-lg">Registration</button>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection