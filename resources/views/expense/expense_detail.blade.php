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
                                <span class="d-inline-block">Expense Management</span>
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
                        <button type="button" onclick='expenseAdd()' title="Add a new expense" data-placement="bottom" class="btn-shadow mr-3 btn btn-primary">
                            <i class="fa fa-plus"></i>
                            Add New Expense
                        </button>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="table table-bordered table-hover expense_detail_table" id="expense_detail_table" style="width:100% !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Expense Head</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Payment Status</th>
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
                    <h5 class="modal-title" id="form-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="expense_detail_form" name="expense_detail_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="edit_id" id="edit_id">            
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label  class="">Expense Head Name<span class="required">*</span></label>
                                                    <select class="form-control col-lg-12"  name="expense_head_id" id="expense_head_id">
                                                        <option value=""  selected>Select Expense Head Name</option>
                                                        @foreach($parentExpneseHead as $parentHead)
                                                            <option value="{{$parentHead->id}}">{{$parentHead->expense_head_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label  class="">Amount<span class="required">*</span></label>
                                                    <input type="text" id="amount" name="amount" class="form-control col-lg-12" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label  class="">Payment Status<span class="required">*</span></label>
                                                    <select class="form-control col-lg-12" id="payment_status" name="payment_status" >
                                                        <option value="Due">Due</option>
                                                        <option value="Partial">Partial</option>
                                                        <option value="Paid">Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label  >Details</label>
                                                <textarea type="text" id="details" name="details" class="form-control col-lg-12" ></textarea>
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label  >Is Active</label>
                                                <input type="checkbox" id="is_active" name="is_active" checked="checked" class="form-control col-lg-12"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label  >Attachment</label>
                                                <input type="file" id="attachment" name="attachment" class="form-control col-lg-12" />
                                                <div class="attached-file"></div>
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
                                <button type="submit" id="save_expense_detail" class="btn btn-success  btn-lg btn-block">Save</button>

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
    <div class="modal fade" id="expense-detail-view-modal" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-title"><i class="fa fa-user"></i> Expense Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                        <div class="thumbnail text-center photo_view_postion_b" >
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="" >

                                            <span id="expense_head_name"></span>
                                            <p><div id="status_div"></div></p>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <p><span id="amount"></span></p>
                                            <p><span id="details"></span></p>
                                            <p><span id="payment_status"></span></p>
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

    <script>
        const expense_attachment_url = "<?php echo asset('assets/images/expense'); ?>";
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/page-js/expense/expense.js')}}"></script>
@endsection



