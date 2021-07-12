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
                                    <div class="slide-img-bg" style="background-image: url({{ asset('assets/theme/assets/images/originals/city.jpg')}}"></div>
                                    <div class="slider-content"><h3>Perfect Balance</h3>
                                        <p>ArchitectUI is like a dream. Some think it's too good to be true! Extensive collection of unified React Boostrap Components and Elements.</p></div>
                                </div>
                            </div>
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                    <div class="slide-img-bg" style="background-image: url({{ asset('assets/theme/assets/images/originals/citynights.jpg')}}"></div>
                                    <div class="slider-content"><h3>Scalable, Modular, Consistent</h3>
                                        <p>Easily exclude the components you don't require. Lightweight, consistent Bootstrap based styles across all elements and components</p></div>
                                </div>
                            </div>
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-sunny-morning" tabindex="-1">
                                    <div class="slide-img-bg" style="background-image: url({{ asset('assets/theme/assets/images/originals/cityDARK.jpg')}}"></div>
                                    <div class="slider-content"><h3>Complex, but lightweight</h3>
                                        <p>We've included a lot of components that cover almost all use cases for any type of application.</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                    <div class="mx-auto app-login-box col-sm-12 col-md-8 col-lg-6">
                        <div class="app-logo"><img src="{{ asset('assets/images/logo-inverse.png')}}" /> </div>
                        <div class="box-login btn-squared ">
                            <h3>Set New Password </h3>
                            <p>
                                Please set your new password.
                            </p>
                            <form class="form-login" action="{{ url('auth/forget/password/'.$user_info->id.'/verify') }}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                @if($errors->count() > 0 )
                                    <div class="alert alert-danger btn-squared">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <h6>The following errors have occurred:</h6>
                                        <ul>
                                            @foreach( $errors->all() as $message )
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if(Session::has('message'))
                                    <div class="alert alert-success btn-squared" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                                @if(Session::has('errormessage'))
                                    <div class="alert alert-danger btn-squared" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ Session::get('errormessage') }}
                                    </div>
                                @endif

                                <fieldset>
                                    <input type="hidden" name="user_id" value="{{isset($user_info->id)?$user_info->id:''}}">
                                    <input type="hidden" name="token" value="{{isset($user_info->id)?$user_info->id:''}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group form-actions">
                            <span class="input-icon">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                    </div>
                                <input type="password" class="form-control lock" name="password" placeholder="New Password">
                                </div>
                            </span>
                                    </div>

                                    <div class="form-group form-actions">
                            <span class="input-icon">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                    </div>
                                <input type="password" class="form-control lock" name="confirm_password" placeholder="Confirm New Password">
                                </div>
                            </span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success pull-right btn-squared">
                                            Confirm <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
