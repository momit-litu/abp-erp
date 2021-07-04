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
    actionAdd = function actionAdd(){
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Expense Detail');
        $("#clear_button").show();
        $("#save_expense_detail").html('Save');
        $('#entry-form').modal('show');
    }


	//for show menus list
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
			{ mData: 'expense_attach'},
			{ mData: 'payment_status'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
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
            success_or_error_msg('#master_message_div','danger',"Please Insert Expense Head","#expense_head_id");
        }
        else if($.trim($('#amount').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Select a Expense Amount","#amount");
        }
        else if($.trim($('#details').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Select a Expense Details","#details");
        }
        else if($.trim($('#attachment').val()) == ""){
            success_or_error_msg('#master_message_div','danger',"Please Select a Expense Attachment","#attachment");
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
                        toastr['error']( 'Failed!!!!', resultHtml);
                    }
                    else{
                        toastr['success']( 'Saved Successfully', 'Admin User '+$('#first_name').val());
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


    //Clear form
    $("#clear_button").on('click',function(){
        clear_form();
    });
//Edit function for Module
        expenseDetailEdit = function expenseDetailEdit(id){
        var edit_id = id;
        $("#form-title").html('<i class="fa fa-plus"></i> Edit Expense Detail');

        $.ajax({
            url: url+'/expense/expense-detail-list/'+edit_id,
            cache: false,
            success: function(response){
                var response = JSON.parse(response);
                var data = response['expneseHead'];

                $("#save_expense_head").html('Update');
                $("#clear_button").hide();
                $("#expense_head_id").val(data['expense_head_id']);
                $("#amount").val(data['amount']);
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

