// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	// icheck for the inputs
	$('.form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
    expenseCategoryAdd = function expenseCategoryAdd(){
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Expense Category');
        $("#clear_button").show();
        $("#save_expense_category").html('Save');
        $('#entry-form').modal('show');
    }

	 expense_category_datatable = $('#expense_category_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/expense/expense-category-list",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'category_name' },
			{ mData: 'parent_name'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
        "columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "80px", "targets":[ 4 ]},
        ],
	});

    $("#save_expense_category").on('click',function(){
        event.preventDefault();
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($('#expense_category_form')[0]);

        if($.trim($('#expense_category_name').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Insert Expense Category","#expense_category_name");
        }
        else if($.trim($('#parent_id').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Select a Parent Id","#parent_id");
        }
        else{
            $.ajax({
                url: url+"/expense/expense-category",
                type:'POST',
                data:formData,
                async:false,
                cache:false,
                contentType:false,
                processData:false,
                success: function(data){
                    var response = JSON.parse(data);
                    if(response['response_code'] == 0){
                        var errors	= response['errors'];
                        resultHtml = '<ul>';
                        if(typeof(errors)=='string'){
                            resultHtml += '<li>'+ errors + '</li>';
                        }
                        else{
                            $.each(errors,function (k,v) {
                                resultHtml += '<li>'+ v + '</li>';
                            });
                        }
                        resultHtml += '</ul>';
                        toastr['error']( resultHtml, 'Failed!!!!');
                    }
                    else{
                        toastr['success']( 'Expense Category Saved Successfully','Success');
                        $('.modal').modal('hide')
                        expense_category_datatable.ajax.reload();
                        clear_form();
                        $("#save_module").html('Save');
                        $("#edit_id").val('');
                    }
                    $(window).scrollTop();
                }
            });
        }
    });


    $("#clear_button").on('click',function(){
        clear_form();
    });

    expenseCategoryEdit = function expenseCategoryEdit(id){
        var edit_id = id;
        $("#form-title").html('<i class="fa fa-plus"></i> Edit Expense Category');

        $.ajax({
            url: url+'/expense/expense-category-list/'+edit_id,
            cache: false,
            success: function(response){
                var response = JSON.parse(response);
                var data = response['expneseCategory'];

                $("#save_expense_category").html('Update');
                $("#clear_button").hide();
                $("#expense_category_name").val(data['category_name']);
                $("#parent_id").val(data['parent_id']);
                $("#edit_id").val(data['id']);
                (data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
                $('#entry-form').modal('show');
            }
        });
    }
    //Delete Module
    expenseCategoryDelete = function expenseCategoryDelete(id){
        var delete_id = id;
        swal({
            title: "Are you sure?",
            text: "You wants to delete item parmanently!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url+'/expense/expense-category-delete/'+delete_id,
                    cache: false,
                    success: function(data){
                        var response = JSON.parse(data);
                        if(response['response_code'] == 0){
                            success_or_error_msg('#master_message_div',"danger",response['errors']);
                        }
                        else{
                            success_or_error_msg('#master_message_div',"success",response['message']);
                            expense_category_datatable.ajax.reload();
                        }
                    }
                });
            }
            else {
                swal("Your Data is safe..!", {
                    icon: "warning",
                });
            }
        });
    }


    expenseHeadAdd = function expenseHeadAdd(){
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Expense Head');
        $("#clear_button").show();
        $("#save_expense_head").html('Save');
        $('#entry-form').modal('show');
    }


	//for show menus list
	 expense_head_datatable = $('#expense_head_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/expense/expense-head-list",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'expense_head_name' },
			{ mData: 'category_name'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
        "columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "80px", "targets":[ 4 ]},
        ],
	});

//Entry And Update Function For Module
    $("#save_expense_head").on('click',function(){
        event.preventDefault();
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($('#expense_head_form')[0]);

        if($.trim($('#expense_head_name').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Insert Expense Head","#expense_head_name");
        }
        else if($.trim($('#expense_category_id').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Select a Expense Category Id","#expense_category_id");
        }
        else{
            $.ajax({
                url: url+"/expense/expense-head",
                type:'POST',
                data:formData,
                async:false,
                cache:false,
                contentType:false,
                processData:false,
                success: function(data){
                    console.log(data);
                    var response = JSON.parse(data);
                    if(response['response_code'] == 0){
                        var errors	= response['errors'];
                        resultHtml = '<ul>';
                        if(typeof(errors)=='string'){
                            resultHtml += '<li>'+ errors + '</li>';
                        }
                        else{
                            $.each(errors,function (k,v) {
                                resultHtml += '<li>'+ v + '</li>';
                            });
                        }
                        resultHtml += '</ul>';
                        toastr['error']( resultHtml,'Failed!!!!');
                    }
                    else{
                        toastr['success']( 'Expense Head Saved Successfully', 'Success');
                        $('.modal').modal('hide')
                        expense_head_datatable.ajax.reload();
                        clear_form();
                        $("#save_module").html('Save');
                        $("#edit_id").val('');
                    }
                    $(window).scrollTop();
                }
            });
        }
    });


//Edit function for Module
    expenseHeadEdit = function expenseHeadEdit(id){
        var edit_id = id;
        $("#form-title").html('<i class="fa fa-plus"></i> Edit Expense Head');

        $.ajax({
            url: url+'/expense/expense-head-list/'+edit_id,
            cache: false,
            success: function(response){
                var response = JSON.parse(response);
                var data = response['expneseHead'];

                $("#save_expense_head").html('Update');
                $("#clear_button").hide();
                $("#expense_head_name").val(data['expense_head_name']);
                $("#expense_category_id").val(data['expense_category_id']);
                $("#edit_id").val(data['id']);
                (data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
                $('#entry-form').modal('show');
            }
        });
    }
    //Delete Module
    expenseHeadDelete = function expenseHeadDelete(id){
        var delete_id = id;
        swal({
            title: "Are you sure?",
            text: "You wants to delete item parmanently!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url+'/expense/expense-head-delete/'+delete_id,
                    cache: false,
                    success: function(data){
                        var response = JSON.parse(data);
                        if(response['response_code'] == 0){
                            success_or_error_msg('#master_message_div',"danger",response['errors']);
                        }
                        else{
                            success_or_error_msg('#master_message_div',"success",response['message']);
                            expense_head_datatable.ajax.reload();
                        }
                    }
                });
            }
            else {
                swal("Your Data is safe..!", {
                    icon: "warning",
                });
            }
        });
    }


    
    expenseAdd = function expenseAdd(){
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Expense Detail');
        $("#clear_button").show();
        $("#save_expense_detail").html('Save');
        $('#entry-form').modal('show');
    }


    expense_detail_datatable = $('#expense_detail_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/expense/expense-detail-list",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'expense_head_name' },
			{ mData: 'amount'},
			{ mData: 'details'},
			{ mData: 'payment_status'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
        "columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "80px", "targets":[ 6 ]},
        ],
	});

//Entry And Update Function For Module
    $("#save_expense_detail").on('click',function(){
        event.preventDefault();
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($('#expense_detail_form')[0]);

        if($.trim($('#expense_head_id').val()) == ""){
            success_or_error_msg('#form_submit_error','danger',"Please Insert Expense Head","#expense_head_id");
        }
        else if($.trim($('#amount').val()) == ""){
            success_or_error_msg('#form_submit_error','danger',"Please Select a Expense Amount","#amount");
        }
        else{
            $.ajax({
                url: url+"/expense/expense-detail",
                type:'POST',
                data:formData,
                async:false,
                cache:false,
                contentType:false,
                processData:false,
                success: function(data){
                    console.log(data);
                    var response = JSON.parse(data);
                    if(response['response_code'] == 0){
                        var errors	= response['errors'];
                        resultHtml = '<ul>';
                        if(typeof(errors)=='string'){
                            resultHtml += '<li>'+ errors + '</li>';
                        }
                        else{
                            $.each(errors,function (k,v) {
                                resultHtml += '<li>'+ v + '</li>';
                            });
                        }
                        resultHtml += '</ul>';
                        toastr['error'](  resultHtml,'Failed!!!!');
                    }
                    else{
                        toastr['success']( 'Expense Saved Successfully', ' Success');
                        $('.modal').modal('hide')
                        expense_detail_datatable.ajax.reload();
                        clear_form();
                        $("#save_module").html('Save');
                        $("#edit_id").val('');
                    }
                    $(window).scrollTop();
                }
            });
        }
    });

    expense_detail_view = function expense_detail_view(id){	
		$.ajax({
			url: url+'/expense/expense-detail-list/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['expense'];

				var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Expense Head  :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['expense_head']['expense_head_name']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Date: :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['created_at']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Amount :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['amount']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Details :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['details']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Payment Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['payment_status']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Attachment :</strong></div>"+"<div class='col-lg-9 col-md-8'><a target='_blank' href='"+expense_attachment_url+'/'+data["attachment"]+"'>"+data["attachment"]+"</a></div></div>";
					
				$('#myModalLabelLg').html('Expense Details');
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
   

    expenseDetailEdit = function expenseDetailEdit(id){
        var edit_id = id;
        $("#form-title").html('<i class="fa fa-plus"></i> Edit Expense Detail');

        $.ajax({
            url: url+'/expense/expense-detail-list/'+edit_id,
            cache: false,
            success: function(response){
                var response = JSON.parse(response);
                var data = response['expense'];
                console.log(data['attachment']);

                $("#save_expense_head").html('Update');
                $("#clear_button").hide();
                $("#expense_head_id").val(data['expense_head_id']);
                $("#amount").val(data['amount']);
    
                $(".attached-file").html("<a target='_blank' href='"+expense_attachment_url+'/'+data["attachment"]+"'>"+data["attachment"]+"</a>");
                $("#details").val(data['details']);
                $("#payment_status").val(data['payment_status']);
                $("#edit_id").val(data['id']);
                (data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
                $('#entry-form').modal('show');
            }
        });
    }
    //Delete Module
    expenseDetailDelete = function expenseDetailDelete(id){
        var delete_id = id;
        swal({
            title: "Are you sure?",
            text: "You wants to delete item parmanently!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url+'/expense/expense-detail-delete/'+delete_id,
                    cache: false,
                    success: function(data){
                        var response = JSON.parse(data);
                        if(response['response_code'] == 0){
                            success_or_error_msg('#master_message_div',"danger",response['errors']);
                        }
                        else{
                            success_or_error_msg('#master_message_div',"success",response['message']);
                            expense_detail_datatable.ajax.reload();
                        }
                    }
                });
            }
            else {
                swal("Your Data is safe..!", {
                    icon: "warning",
                });
            }
        });
    }



	/*----- Comon Function Start -----*/
	cancle_btn_show = function cancle_btn_show(){
		$("#cancle_btn").removeClass('hidden');
	}
	cancle_function = function cancle_function(){
		$("#cancle_btn").click(function() {
			$("#cancle_btn").addClass('hidden');
			clear_form();
			success_function();
		});
	}
	success_function = function success_function(){
		$("#cancle_btn").addClass('hidden');
		$(".save").html("Save");
		clear_form();
	}
	/*----- Comon Function End -----*/


});

