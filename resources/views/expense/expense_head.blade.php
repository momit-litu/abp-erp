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
								<i class="pe-7s-cash icon-gradient bg-mean-fruit"></i>
							</span>
                                <span class="d-inline-block">Expense Head Management</span>
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
                        <button type="button" onclick='actionAdd()' title="Add a new action" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
                            <i class="fa fa-plus"></i>
                            Add New Expense Head
                        </button>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="table table-bordered table-hover expense_head_table" id="expense_head_table" style="width:100% !important">
                        <thead>
                        <tr>

                            <th> ID</th>
                            <th> Expense Head Name</th>
                            <th>Expense Category Name</th>
                            <th class="hidden-xs">Status</th>
                            <th width='80'>Actions</th>
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
                    <h5 class="modal-title" id="form-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="expense_head_form" name="expense_head_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="edit_id" id="edit_id">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6" >Expense Head Name<span class="required">*</span></label>
                                            <div class="col-md-12  col-xs-6">
                                                <input type="text" id="expense_head_name" name="expense_head_name" class="form-control col-lg-12" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6" >Parent Category</label>
                                            <div class="col-md-12  col-xs-6">
                                                <select class="form-control col-lg-12"  name="expense_category_id" id="expense_category_id">
                                                    <option value=""  selected>Select Expense Category Name</option>
                                                    @foreach($parentExpneseHead as $parentHead)
                                                        <option value="{{$parentHead->id}}">{{$parentHead->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6" >Is Active</label>
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <input type="checkbox" id="is_active" name="is_active" checked="checked" class="form-control col-lg-12"/>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
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
                                <button type="submit" id="save_expense_head" class="btn btn-success  btn-lg btn-block">Save</button>

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
    <script type="text/javascript" src="{{ asset('assets/js/page-js/expense/expense_head.js')}}"></script>
@endsection



