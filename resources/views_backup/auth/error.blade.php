@extends('auth.layout.login-master')

<div class="app-container">
	<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-12 row" style="
	padding:15%">
	@if(Session::has('errormessage'))
		<div class="alert alert-danger btn-squared  col-md-12 text-center" style="padding:50px" role="alert">			
			<h3>{{ Session::get('errormessage') }}</h3>
		</div>
	@endif
		<div class="alert alert-danger btn-squared  col-md-lg text-center" style="padding:50px" role="alert">
			<h1>NOT FOUND</h1>
		</div>
		<br>
		<div class="col-lg-12 text-center" style="padding:10px">
			<a class="btn btn-success " href="{{url('/')}}">Landing Page</a>		
		</div>
	</div>
</div>
