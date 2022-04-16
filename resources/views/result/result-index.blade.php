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
                        <div class="col-md-9">
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
                        <div class="col-md-3 text-right">
                            <div class="position-relative form-group" id="upload_result" style="display: none !important">
                                <label class="control-label" >&nbsp;</label>
                                <div class="col-md-12">
                                    <div class="widget-content-right">
                                        <button class="border-0 btn-transition btn btn-outline-info" onclick="exportSampleResult('sample')" title="Download Sampl CSV">
                                            <i class="fa fa-file-excel"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="uploadResult()" title="Upload Result" >
                                            <i class="fa fa-upload"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-success" onclick="exportSampleResult('report')" title="Download Report">
                                            <i class="fa fa-download"></i>
                                        </button>
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
                            <form id="result_form" autocomplete="off" name="result_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <input type="hidden" name="edit_id" id="edit_id">
                                &nbsp;<br>
								<strong>Result Details:</strong>
                                <div class="col-lg-12">
									<div class='row '>
										<table class='table table-bordered' style='width:100% !important'> 
											<thead>
												<tr>
													<th>Unit Name</th>
													<th class='text-center'>Credit Hour</th>
													<th class='text-center'>Score</th>
												</tr>
											</thead>
											<tbody id="result_div_edit">
											</tbody>
										</table>
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
                            <button type="submit" id="save_result" class="btn btn-success  btn-lg btn-block">Save</button>
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
    <div class="modal fade" id="upload-result-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Upload CSV Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="csv_form" autocomplete="off" name="csv_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label class="">CSV File <span class="required">*</span></label>
                                                    <input name="csv_result_file" id="csv_result_file" type="file"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <br>
                                                @if($actions['add_permisiion']>0)
                                                    <button id="save_csv" class="btn btn-success  btn-lg">Upload Book Status</button>
                                                @endif
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="form_csv_submit_error" class="text-center" style="display:none"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="display: flex; flex-direction: row;">
                        <div class="col-md-3 text-left">

                        </div>
                        <div class="col-md-9 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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


