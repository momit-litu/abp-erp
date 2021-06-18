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
                                <span class="d-inline-block">Course Categories</span>
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
                    <div class="page-title-actions">
                        <button type="button" onclick='courseCategoryAdd()' title="Add a new Admin User" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
                            <i class="fa fa-plus"></i>
                            Add New Course Category
                        </button>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="table table-bordered table-hover learners_table" id="courseCategories_table" style="width:100% !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>description</th>
                            <th class="hidden-xs">Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="entry-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Course Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="courseCategory_form" autocomplete="off" name="courseCategory_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="title" class="">Title<span class="required">*</span></label>
                                                    <input type="text" id="title" name="title" required class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label>Is Active</label>
                                                    <input type="checkbox" id="is_active" name="is_active" checked="checked" value="1" class="form-control col-lg-12"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label>Description</label>
                                                    <textarea rows="2" cols="100" id="description" name="description" class="form-control col-lg-12"></textarea>
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
                                <button type="submit" id="save_courseCategory" class="btn btn-success  btn-lg btn-block">Save</button>
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
    <div class="modal fade" id="courseCategory-view-modal" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"><i class="fa fa-user"></i> Course Category Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-8 col-xs-12">
                                    <div class="" >
                                        <span id="student_name"></span>
                                        <p><div id="status_div"></div></p>
                                        <div id="group_div"></div></p>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">

                                        <p title="Birthday"><span><i class="lnr-phone-handset"></i></span><span id="student_DOB"></span></p>
                                        <p title="Phone"><span><i class="lnr-phone-handset"></i></span><span id="student_contact"></span></p>
                                        <p title="Email"><span ><i class="lnr-envelope"></i></span><span id="email_div"></span></p>
                                        <p title="Address"><span ></span><span id="student_address"></span></p>

                                    </div>
                                    <!-- <div class="col-md-6">
                                       <p title="NID NO"><span class="glyphicon glyphicon-credit-card one" style="width:50px;"></span><span id="nid_div"></span></p>
                                     <p title="Address"><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span><span id="address_div"></span></p>
                                     </div>-->
                                    <hr>
                                    <div class="col-md-12">
                                        <div id="remarks_details">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
<script type="text/javascript" src="{{ asset('assets/js/page-js/courseCategories/courseCategories.js')}}"></script>

@endsection


