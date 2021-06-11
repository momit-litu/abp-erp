
@extends('layout.master')
@section('content')
<div class="app-main__outer">
	<div class="app-main__inner">
		<div class="app-page-title">
			<div class="page-title-wrapper">
				<div class="page-title-heading">
					<div>
						<div class="page-title-head center-elem">
							<span class="d-inline-block pr-2">
								<i class="pe-7s-menu icon-gradient bg-mean-fruit"></i>
							</span>
							<span class="d-inline-block">Genaral Settings</span>
						</div>
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
		<div class="main-card mb-3 card">
			<div class="card-body">
				<form id="general_setting" name="admin_user_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
					@csrf
					<div class="row">
						<input type="hidden" name="id" id="id" value="{{ $setting['id'] }}">
						<div class="col-md-9">

							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group"><label for="company_name" class="">Company Name</label>
										<input type="text" id="company_name" name="company_name" required class="form-control col-lg-12" value="{{ $setting['company_name'] }}" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group"><label for="short_name" class="">Short Name</label><input type="text" id="short_name" name="short_name" class="form-control col-lg-12" value="{{ $setting['short_name'] }}" />
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group"><label for="company_name" class="">Site Name</label>
										<input type="text" id="site_name" name="site_name"  class="form-control col-lg-12" value="{{ $setting['site_name'] }}" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group"><label for="short_name" class="">Admin Email</label>
										<input type="email" id="admin_email" name="admin_email"  class="form-control col-lg-12"value="{{ $setting['admin_email'] }}" />
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group"><label for="company_name" class="">Admin Mobile</label>
										<input type="text" id="admin_mobile" name="admin_mobile" required class="form-control col-lg-12" value="{{ $setting['admin_mobile'] }}"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group"><label for="short_name" class="">Site URL</label>
										<input type="text" id="site_url" name="site_url"  class="form-control col-lg-12" value="{{ $setting['site_url'] }}" />
									</div>
								</div>
							</div>
							<div class="position-relative form-group">
								<label for="admin_url" class="">Admin URL</label>
								<input type="text" id="admin_url" name="admin_url"  class="form-control col-lg-12" value="{{ $setting['admin_url'] }}" />
							</div>
							<div class="position-relative form-group">
								<label for="address" class="">Address</label>
								<input type="text" id="address" name="address" class="form-control col-lg-12" value="{{ $setting['address'] }}" />
							</div>
							<br/>
							<div class="ln_solid"></div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div id="form_submit_error" class="text-center" style="display:none"></div>
							 </div>
						</div>
						<div class="col-md-3 text-center">
							<img src="{{asset('assets/images/admin-upload/')}}/{{ ($setting['logo']=="")?'no-user-image.png':$setting['logo'] }}" width="70%" height="70%" class="img-thumbnail">
							<span class="btn btn-light-grey btn-file">
								<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Logo</span>
								<input type="file" name="logo" id="logo" value="">
							</span>
							<br><br>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
						@if($actions['update_permisiion']==1)
							<div class="col-md-3 col-sm-3 col-xs-12">
								<button type="submit" id="save_general_setting" class="btn btn-success btn-lg btn-block">Save</button>
							</div>
						@endif
					</div>
				</form>	
			</div>
		</div>           		
	</div>
</div>    
</div>
@endsection
@section('JScript')
	<script type="text/javascript" src="{{ asset('assets/js/page-js/setting/setting.js')}}"></script>
@endsection


