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
								<i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
							</span>
                                <span class="d-inline-block">Certificates</span>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-md-10">
                                    <div class="position-relative form-group">
                                        <label class="control-label" >Course & Batch</label>
                                        <input type="text" id="batch_name" name="batch_name" class="form-control col-lg-12" />
                                        <input type="hidden" id="batch_id" name="batch_id"/>
                                    </div>
                                </div>
                                <div class="col-md-2 text-right">
                                    <div class="position-relative form-group">
                                        <label class="control-label" >&nbsp;</label>
                                        <div class="col-md-8">
                                            <button id="show_batch_certificate" class="btn btn-info btn-lg">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card" id="certificate_div" style="display: none" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <div id="student_certificate_table_filter" class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control form-control-sm text-left" placeholder="" id="student_certificate_table_search">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="certificate_table_div" >
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div></div>
	<div class="modal fade" id="entry-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
							<div id="course_info_details"></div>
                            <form id="certificate_form" autocomplete="off" name="certificate_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <input type="hidden" name="edit_id" id="edit_id">
                                &nbsp;<br>
								<strong>Result Details:</strong>
									<div class='row '>
                                        <div class="col-lg-12">
                                        <div id="certificate_div_edit">
                                        </div>
                                        <div class="form-row alert alert-success">	
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label class="">Certificate Status </label>
                                                    <select id="certificate_status" name="certificate_status" class="form-control col-lg-12">
                                                        @foreach ($certificateStates as $certificateState)
                                                        <option value="{{$certificateState->id}}">{{$certificateState->name}}</option>
                                                        @endforeach                                         
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="certificate_no" class="">Certificate No.</label>
                                                    <input type="text" id="certificate_no"  name="certificate_no"  class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>
									</div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="form_submit_error" class="text-center" style="display:none"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="display: flex; flex-direction: row;">
                        <div class="col-md-3 text-left">
                            @if($actions['add_permisiion']>0)
                            <button type="submit" id="save_certificate" class="btn btn-success  btn-lg btn-block">Save</button>
                        @endif
                        </div>
                        <div class="col-md-9 text-right">
                            <button type="button" id="clear_button" class="btn btn-warning">Clear</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="feedback-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="feedback_form" autocomplete="off" name="feedback_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <input type="hidden" name="batch_student_id" id="batch_student_id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label class="">Feedback <span class="required">*</span></label>
                                                    <textarea  rows="4" id="feedback_details" required name="feedback_details"  class="form-control col-lg-12"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="form_submit_error" class="text-center" style="display:none"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="display: flex; flex-direction: row;">
                        <div class="col-md-3 text-left">
                            @if($actions['add_permisiion']>0)
                            <button type="submit" id="save_feedback" class="btn btn-success  btn-lg btn-block">Save</button>
                        @endif
                        </div>
                        <div class="col-md-9 text-right">
                            <button type="button" id="clear_button" class="btn btn-warning">Clear</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('JScript')
    <script type="text/javascript" src="{{ asset('assets/js/page-js/result/result.js')}}"></script>
@endsection


