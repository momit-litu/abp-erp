@extends('layout.master')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bils/profile.css') }}">
	<style type="text/css" media="screen">
		hr{
			margin:0;
		}
	</style>
@endsection
@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
            </div>
            <div>Student List </div>
        </div>
        <div class="page-title-actions">
            <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" title="Create a new student" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
                <i class="fa fa-plus"></i>
                New Student
            </button>
        </div>    
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
    </div>
</div>		

@endsection


@section('JScript')

	<script>
		var profile_image_url = "<?php echo asset('assets/images/user/admin'); ?>";
        $(document).ready(() => {

            setTimeout(function () {

                $('#example').DataTable({
                    responsive: true
                });

                $('#example2').DataTable({
                    scrollY:        '292px',
                    scrollCollapse: true,
                    paging:         false,
                    "searching": false,
                    "info": false
                });

            }, 2000);

            });
        alert('FUNNY');
	</script>
	<script src="{{ asset('assets/js/page-js/admin/profile.js')}}"></script>

@endsection


