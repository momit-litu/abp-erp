<div class="app-sidebar sidebar-shadow">
	<div class="app-header__logo">
		<div class="logo-src"></div>
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
	<div class="scrollbar-sidebar">
		<div class="app-sidebar__inner">
			<ul class="vertical-nav-menu">
				<li class="{{isset($page_title) && ($page_title=='Dashboard') ? 'mm-active' : ''}} ">
					<a href="{{url('dashboard')}}">
						<i class="metismenu-icon pe-7s-home"></i>
						Dashboard
					</a>
				</li>
				<li>
					<a href="#">
						<i class="metismenu-icon pe-7s-notebook"></i>
						Courses
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul>
						<li>
							<a href="#">
								<i class="metismenu-icon"></i>
								Overall
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="{{url('portal/courses/Running')}}">
										<i class="metismenu-icon">
										</i>Ongoing
									</a>
								</li>
								<li>
									<a href="{{url('portal/courses/Upcoming')}}">
										<i class="metismenu-icon">
										</i>Upcoming
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">
								<i class="metismenu-icon"></i>
								My Course
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="{{url('portal/courses/my/Running')}}">
										<i class="metismenu-icon">
										</i>Registered
									</a>
								</li>
								<li>
									<a href="{{url('portal/courses/my/Completed')}}" >
										<i class="metismenu-icon">
										</i>Completed
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">
						<i class="metismenu-icon pe-7s-cash"></i>
						Payments
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul>
						<li>
							<a href="{{url('portal/payments/all')}}">
								<i class="metismenu-icon">
								</i>Payments
							</a>
						</li>
						<li>
							<a href="{{url('portal/revise-payments')}}">
								<i class="metismenu-icon">
								</i>Revise Payments
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">
						<i class="metismenu-icon pe-7s-user"></i>
						Account
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul>
						<li>
							<a href="{{url('/profile')}}">
								<i class="metismenu-icon">
								</i>Profile
							</a>
						</li>
						<li>
							<a href="{{ url('profile?tab=change_password') }}">Change Password </a>
						</li>
						<li>
							<a href="{{ url('profile?tab=notification') }}">Notifications</a>
						</li>	
						<li>
							<a href="{{url('auth/logout',isset(\Auth::user()->email) ? \Auth::user()->email : '')}}">
								<i class="clip-exit"></i>
								&nbsp;Log Out
							</a>
						</li>					
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div> 