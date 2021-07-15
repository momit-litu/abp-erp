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

	unitAdd = function unmitAdd(){
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Unit');
		$("#clear_button").show();
		$("#save_unit").html('Save');
		$('#entry-form').modal('show');
	}

	//for show units list
	 unit_datatable = $('#units_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/units",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'unit_code'},
			{ mData: 'name' },
			{ mData: 'glh'},
			{ mData: 'tut'},
			{ mData: 'assessment_type'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
	});



	//Entry And Update Function For Module
	$("#save_unit").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#unit_form')[0]);

		if($.trim($('#unit_code').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please Insert Unit code","#unit_code");
		}
		else if($.trim($('#name').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please Select a unit name","#name");
		}
		//
		else if($.trim($('#glh').val()) == "" || !($.isNumeric($('#glh').val()))){
			success_or_error_msg('#master_message_div','danger',"Please Select a GLI","#glh");
		}
		else if($.trim($('#tut').val()) == "" || !($.isNumeric($('#tut').val()))){
			success_or_error_msg('#master_message_div','danger',"Please Select a total unit time","#tut");
		}
		else if($.trim($('#credit_hour').val()) == "" || !($.isNumeric($('#credit_hour').val()))){
			success_or_error_msg('#master_message_div','danger',"Please Select a credit hour","#credit_hour");
		}
		else{
			$.ajax({
				url: url+"/unit",
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
						toastr['error']( 'Failed!!!!', resultHtml);
					}
					else{
						toastr['success']( 'Saved Successfully', 'Admin User '+$('#first_name').val());
						$('.modal').modal('hide')
						unit_datatable.ajax.reload();
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
	unitEdit = function unitEdit(id){
		var edit_id = id;
		$("#save_unit").html("<b> Edit Unit</b>");
		$.ajax({
			url: url+'/unit/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['unit'];

				$("#save_unit").html('Update');
				$("#clear_button").hide();
				$("#name").val(data['name']);
				$("#unit_code").val(data['unit_code']);
				$("#glh").val(data['glh']);
				$("#tut").val(data['tut']);
				$("#credit_hour").val(data['credit_hour']);
				$("#assessment_type").val(data['assessment_type']);
				$("#edit_id").val(data['id']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				$('#entry-form').modal('show');
			}
		});
	}


	//Delete Module
	unitDelete = function unitDelete(id){
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
					url: url+'/unit/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							toastr['error']( response['errors'], 'Error!!!');
						}
						else{
							toastr['success']( response['message'], 'Success!!!');
							unit_datatable.ajax.reload();
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
});

