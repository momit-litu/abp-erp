<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src"><img src="{{ asset('assets/images/admin-upload/')."/".$site_settings['logo']}}" style="max-width:40px" /> </div>
        
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="close"></button>
            </div>
        </div>
        <div class="app-header-right">
            <div class="header-dots">
                <!--
                <div class="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-primary"></span>
                            <i class="icon text-primary ion-android-apps"></i>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-plum-plate">
                                <div class="menu-header-image" style="background-image: url('assets/theme/assets/images/dropdown-header/abstract4.jpg');"></div>
                                <div class="menu-header-content text-white">
                                    <h5 class="menu-header-title">Grid Dashboard</h5>                                        
                                </div>
                            </div>
                        </div>
                        <div class="grid-menu grid-menu-xl grid-menu-3col">
                            <div class="no-gutters row">
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-world icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Automation
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-piggy icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"> </i>
                                        Reports
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-config icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"> </i>
                                        Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            -->
                <div class="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-success" id="notification_span"></span>
                            <i class="icon text-success icon-anim-pulse ion-android-notifications" id="notification_i"></i>
                            <!--<span class="badge badge-pill badge-danger">2</span>-->
                            <span class="badge badge-dot badge-dot-sm badge-danger" style="display:none" id="notification_span_badge">Notifications</span>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header mb-0">
                            <div class="dropdown-menu-header-inner bg-deep-blue">
                                <div class="menu-header-image opacity-1" style="background-image: url('assets/theme/assets/images/dropdown-header/city3.jpg');"></div>
                                <div class="menu-header-content text-dark">
                                    <h5 class="menu-header-title">Notifications</h5>
                                    <h6 class="menu-header-subtitle">You have <b id="notificationCount" class='text-danger'></b> unread messages</h6>
                                </div>
                            </div>
                        </div>
                        <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered p-3">
                            <li class="nav-item">
                                <a role="tab" class="nav-link active" data-toggle="tab" href="#tab-messages-header">
                                    <span>Students</span> <span id="student_count"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" data-toggle="tab" href="#tab-events-header">
                                    <span>Payments</span>  <span id="payment_count"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" data-toggle="tab" href="#tab-errors-header">
                                    <span>Notice</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div class="notifications-box">
                                                <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate" id="student_notification_div">                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-events-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div class="ertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" id="payment_notification_div">
     
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-errors-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="no-results pt-3 pb-0">
                                            <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                                                <span class="swal2-success-line-tip"></span>
                                                <span class="swal2-success-line-long"></span>
                                                <div class="swal2-success-ring"></div>
                                                <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                                            </div>
                                            <!--<div class="results-subtitle">All caught up!</div>-->
                                            <div class="results-title">No Notice!</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn text-center nav-item">
                                <button class="mb-2 mr-2 btn  btn-sm btn-shadow btn-gradient-warning" onclick="loadMoreNotofication()">Load More</button>
                                <button class="mb-2 mr-2 btn  btn-sm btn-shadow btn-gradient-info" onclick="loadAllNotofication()">All Notification</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    @if(\Auth::check())
                                        @if((\Auth::user()->user_profile_image != ''))
                                            <img width="42px" height="42px;" src="{{ asset('assets/images/user/admin') }}/{{ Auth::user()->user_profile_image }}" class="rounded-circle" >
                                        @else
                                            <img width="42px" height="42px;" src="{{asset('assets/images/user/admin/small/profile.png')}}" class="rounded-circle" >
                                        @endif                                            
                                    @endif
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            <div class="menu-header-image opacity-2" style="background-image: url('assets/theme/assets/images/dropdown-header/city3.jpg');"></div>
                                            <div class="menu-header-content text-left">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">

                                                            @if(\Auth::check())
                                                                @if((\Auth::user()->user_profile_image != ''))
                                                                    <img width="42px" height="42px;" src="{{ asset('assets/images/user/admin') }}/{{ Auth::user()->user_profile_image }}" class="rounded-circle" >
                                                                @else
                                                                    <img width="42px" height="42px;" src="{{asset('assets/images/user/admin/small/profile.png')}}" class="rounded-circle" >
                                                                @endif                                            
                                                            @endif

                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">{{isset(\Auth::user()->first_name) ? \Auth::user()->first_name : ''}}
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-right mr-2">
                                                            @if(\Auth::check())
                                                                <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{url('auth/logout',isset(\Auth::user()->email) ? \Auth::user()->email : '')}}">
                                                                    <i class="clip-exit"></i>
                                                                    &nbsp;Log Out
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll-area-xs" style="height: 150px;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    @if(\Auth::check())
                                                    <a href="{{url('/profile')}}" class="nav-link">Profile</a>
                                                    @endif
                                                </li>
                                                <li class="nav-item">
                                                    @if(\Auth::check())
                                                    <a href="{{ url('profile?tab=change_password') }}" class="nav-link">Change Password </a>
                                                    @endif
                                                </li>
                                                <!-- <li class="nav-item">       
                                                    <a href="javascript:void(0);" class="nav-link">Messages
                                                        <div class="ml-auto badge badge-warning">512
                                                        </div>
                                                    </a>
                                                </li> --> 
                                                <li class="nav-item">
                                                    <a href="{{ url('profile?tab=notification') }}" class="nav-link">Notifications
                                                        <div class="ml-auto badge badge-danger" id="dropdown_notification_count">0
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                {{isset(\Auth::user()->first_name) ? \Auth::user()->first_name : ''}}
                            </div>
                            <div class="widget-subheading">
                                ABP Admin
                            </div>
                        </div>
                        <!--<div class="widget-content-right header-user-info ml-3">
                            <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                            </button>
                        </div>-->
                    </div>
                </div>
            </div>
   
        </div>
    </div>
</div> 