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
                                    <div class="position-relative form-group"><label for="exampleEmail" class="">Email</label><input name="email" id="exampleEmail" placeholder="Email here..." type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"></div>
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