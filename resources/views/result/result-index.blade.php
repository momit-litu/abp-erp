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
                                <span class="d-inline-block">Results</span>
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
                                            <button id="show_batch_result" class="btn btn-info btn-lg">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card" id="result_div" style="display: none" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <div id="student_result_table_filter" class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control form-control-sm text-left" placeholder="" id="student_result_table_search">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="result_table_div" >
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div></div>

@endsection
@section('JScript')
    <script type="text/javascript" src="{{ asset('assets/js/page-js/result/result.js')}}"></script>
@endsection


