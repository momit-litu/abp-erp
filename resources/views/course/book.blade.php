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
                                <span class="d-inline-block">Course Books</span>
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
                        <div class="col-10">
                            <div class="form-row">
                                <div class="col-md-11">
                                    <div class="position-relative form-group">
                                        <label class="control-label" >Course & Batch</label>
                                        <input type="text" id="batch_name" name="batch_name" class="form-control col-lg-12" />
                                        <input type="hidden" id="batch_id" name="batch_id"/>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="position-relative form-group">
                                        <label class="control-label" >&nbsp;</label>
                                        <div class="col-md-8">
                                            <button id="show_batch_books" class="btn btn-info btn-lg">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="position-relative form-group">
                                <label class="control-label" >&nbsp;</label>
                                <div class="col-md-12">
                                    <button style="display: none" id="add_books" onclick='showBooks()' class="btn btn-primary btn-lg">Add Book </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card" id="batch_books_div" style="display: none" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <div id="student_book_table_filter" class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control form-control-sm text-left" placeholder="" id="student_books_table_search">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="batch_books_table_div" >
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div></div>
    <div class="modal fade" id="entry-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-title"><i class="fa fa-plus"></i> Add  New Book </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form id="book_form" autocomplete="off" name="book_form" enctype="multipart/form-data" class="form form-horizontal form-label-left">
                                @csrf
                                <input type="hidden" name="edit_id" id="edit_id">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label class="">Book Name <span class="required">*</span></label>
                                                    <input type="text" id="book_name" required name="book_name" class="form-control col-lg-12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-check">				
                                                    <label class="form-check-label">
                                                        <input type="checkbox" checked class="form-check-input" name="status" value="1" > Active
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <br>
                                                @if($actions['add_permisiion']>0)
                                                    <button id="save_book" class="btn btn-success  btn-lg">Save</button>
                                                @endif
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered" id='books_table'>
                                            <tr>
                                                <th>Book Name</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
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

                        </div>
                        <div class="col-md-9 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                                <input type="hidden" name="student_book_id" id="student_book_id">
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
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <br>
                                                @if($actions['add_permisiion']>0)
                                                    <button id="save_feedback" class="btn btn-success  btn-lg">Save</button>
                                                @endif
                                                <p>&nbsp;</p>
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
    <script type="text/javascript" src="{{ asset('assets/js/page-js/course/book.js')}}"></script>
@endsection


