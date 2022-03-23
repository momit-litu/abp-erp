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


				@foreach($menus as $menu)		
					<li class="{{isset($module_name) && ($module_name==$menu['module_name']) ? 'mm-active' : ''}} ">
						<a href="{{$menu['menu_url'] === "" ? 'javascript:void(0)' : url($menu['menu_url'])}}"><i class="metismenu-icon {{$menu['menu_icon_class']}}"></i>
							{{$menu['menu_title']}}
							@if(isset($menu['sub_menus']))
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							@endif

						</a>
						@if(isset($menu['sub_menus']))				
							<ul>
								@foreach($menu['sub_menus'] as $sub_menu)		
								<li class="{{isset($sub_module) && ($sub_module==$sub_menu['menu_title']) ? 'mm-active' : ''}}">
									<a class="{{isset($sub_module) && ($sub_module==$sub_menu['menu_title']) ? 'mm-active' : ''}}"
									
									href="{{url($sub_menu['menu_url'])}}">
										{{$sub_menu['menu_title']}}
									</a>
								</li>
								@endforeach
							</ul>
						@endif				
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div> 