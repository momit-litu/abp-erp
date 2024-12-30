@extends('auth.layout.login-master')
@section('login-content')
<div class="app-container">
    <div class="h-100">
        <div class="h-100 no-gutters row">
		  @include('auth.left-column')
            <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                    <div class="app-logo"><img src="{{ asset('assets/images/logo-inverse.png')}}" /> </div>
                    <h4 class="mb-0">
                        <span class="d-block">Welcome back,</span>
                        <span>Please sign in to your account.</span></h4>
                    <h6 class="mt-3">No account? <a href="{{url('/auth/register')}}" class="text-primary">Sign up now</a></h6>
                    <div class="divider row"></div>
                    <div>
                        <form class="form-login" action="{{ url('auth/post/login') }}" method="post">
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
                                    <div class="position-relative form-group"><label for="exampleEmail" class="">Email</label><input name="email" id="exampleEmail" placeholder="Email here..." type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="examplePassword" class="">Password</label><input name="password" id="examplePassword" placeholder="Password here..." type="password" class="form-control @error('password') is-invalid @enderror"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <!-- Add the CAPTCHA -->
                                <div class="form-group">                                   
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Keep me logged in</label></div>
                            <div class="divider row"></div>
                            <div class="d-flex align-items-center">
                                <div class="ml-auto">
                                    <a href="{{url('/auth/forget/password')}}" class="btn-lg btn btn-link">Recover Password</a>
                                    <a href="{{url('/auth/forget/password-otp')}}" class="btn-lg btn btn-link">Login with OTP</a>
								    <button class="btn btn-primary btn-lg">Login to Dashboard</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add the CAPTCHA script -->
{!! NoCaptcha::renderJs() !!}
@endsection