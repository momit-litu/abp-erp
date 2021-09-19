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
                <div class="mx-auto app-login-box col-sm-12 col-md-8 col-lg-6">
                    <div class="app-logo"><img src="{{ asset('assets/images/logo-inverse.png')}}" /> </div>
                    <h4>
                        <div>Forgot your Password?</div>
                        <span>Use the form below to recover it.</span></h4>
                    <div>
                        <form class="form-forgot" action="{{url('auth/forget/password')}}" method="post">
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
                                <div class="col-md-12">
                                    <div class="position-relative form-group"><label for="exampleEmail" class="">Email</label><input name="email" id="exampleEmail" placeholder="Email here..." type="email" class="form-control"></div>
                                </div>
                            </div>
                            <div class="mt-4 d-flex align-items-center"><h6 class="mb-0"><a href="{{url('/auth/login')}}" class="text-primary">Sign in existing account</a></h6>
                                <div class="ml-auto">
                                    <button class="btn btn-primary btn-lg">Recover Password</button>
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