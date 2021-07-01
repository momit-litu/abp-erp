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
         expense_head_datatable = $('#expense_detail_table').DataTable({
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

