// All the Setting related js functions will be here
$(document).ready(function () {
	$( ".draggable" ).draggable();
	
	$("#sms_template").on('change',function(){
		var edit_id = $(this).val();
		$.ajax({
			url: url+'/template/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['template'];	
				//details = $(data['details']).text();			
				$('#message_body').val(data['details']);	
			}
		});	
	});

	$("#email_template").on('change',function(){
		var edit_id = $(this).val();
		$.ajax({
			url: url+'/template/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['template'];				
				$("#title").val(data['title']);
				$("#email_template_category").val(data['category']);				
				details = (data['details'] != null)?data['details']:"";
				editors.message_body.setData(details);
			}
		});		
	});

	$("#template_type").on('change',function(){
		var message_type = $(this).val();
		if(message_type == 'Email'){
			$('#sms_details_div').addClass('d-none');
			$('#email_details_div').removeClass('d-none');
		}
		else{
			$('#sms_details_div').removeClass('d-none');
			$('#email_details_div').addClass('d-none')
		}
	});
	
	
	getPaymentBatchTemplateDetails = function getPaymentBatchTemplateDetails(id){	
		$.ajax({
			url: url+'/student-course-batch-autosuggest/'+id,
			cache: false,
			success: function(response){
				var option ="";
				var response = JSON.parse(response);
				var data = response['templates'];
				if(!jQuery.isEmptyObject(data)){
					option +=`<option value="">Select template and batch</option>`;
					$.each(data, function(i,template){ 
						option += `<option value="`+template['id']+`">`+template['detail']+`</option>`;
					});
				}
				else{
					option +=`<option value="">No template found!</option>`;
				}
				$('#template_name').html(option);
			}
		});
	}

	addReceipants = function addReceipants(id, name){
		var selected_receipant_div = `
			<div class="widget-content p-0" style="float: left" id="receipant_div_`+id+`">
				<div class="widget-content-wrapper" >
					<div class="widget-content-left">
						<input type="hidden" name="student_ids[]" value="`+id+`" />
						<div class="widget-heading">`+name+`</div>
					</div>
					<div class="widget-content-right widget-content-actions">
						<button class="border-0 btn-transition btn btn-outline-danger" onClick="$('#receipant_div_`+id+`').remove();">
							<i class="fa fa-trash"></i>
						</button>
					</div>
				</div>
			</div>`;
			$('#selected_receipants').append(selected_receipant_div);
	}

	$("#sms_student_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/student-autosuggest',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					term: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		//appendTo : $('#entry-form'),
		minLength: 2,
		select: function(event, ui) {
			var id = ui.item.id;
			var name = ui.item.label;			
			addReceipants(id, name);
			$(this).val("");
		},
	});

	$("#all_student_type").on('change',function(){
		if($(this).val()=='enrolled')
			$('#do_not_send_div').css('display','block');
		else
			$('#do_not_send_div').css('display','none');	
	});

	$("#sms_student_name").on('click',function(){
		$(this).val("");
	});
	
	$("#sms_batch_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/course-batch-autosuggest',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					term: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 2,
		select: function(event, ui) {
			var id = ui.item.id;
			$(this).next().val(id);
		},
	});
	
	$("#sms_batch_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
	});

	//Entry And Update Function For Module
	$("#sent_sms_submit").on('click',function(event){
		event.preventDefault();
		var formData = new FormData($('#sms_form')[0]);

		if($.trim($('#message_body').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter message body","#message_body");
		}
		else if($.trim($('#payment_type').val()) == "" && $.trim($('#all_student_type').val()) == "" && $.trim($('#sms_batch_name').val()) == "" &&   $.trim($('#selected_receipants').html()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select student","#sms_student_name");
		}
		else{
			// validate the installment details
			$.ajax({
				url: url+"/sms/send",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
					var response = JSON.parse(data);
					if(response['response_code'] == 0){				
						toastr['error']( response['message'], 'Failed!!!!');
					}
					else{
						toastr['success'](response['message'], 'Success!!!');
						$('#selected_receipants').html("");
						clear_form();
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){		
		$('#selected_receipants').html("");
		$('#do_not_send_div').css('display','none');
		clear_form();
	});


	// template
	templateAdd = function templateAdd(){
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Template');
		$('#entry-form').modal('show');
	}


	templates_table = $('#templates_table').DataTable({
		"destroy": true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/templates",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'title'},
			{ mData: 'category', className: "text-center"},
			{ mData: 'type', className: "text-center"},			
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "100px", "targets":[ 3 ]},
			{ "width": "100px", "targets":[ 4 ]},
			{ "width": "120px", "targets":[ 5 ]},
        ],
	});

	$('#category').on('change', function(){
		$.ajax({
			url: url+'/get-template-placeholders/'+$(this).val(),
			type: "get",
			dataType: "json",
			async:false,
			success: function(data) {
				$('#placeholders_main_div').css('display','block');
				$('#placeholders_div').html(data['placeholders']);
			}
		});
	})
			
			
	// title details edit_id placeholders category template_type status
	$("#save_template").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		editors.email_details.updateSourceElement();				

		var formData = new FormData($('#template_form')[0]);

		if($.trim($('#title').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Title","#title");
		}
		else{
			$.ajax({
				url: url+"/template",
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
						toastr['success']( 'Template Saved Successfully', 'Success!!!');
						$('.modal').modal('hide')
					
						templates_table.ajax.reload();
						clear_form();
						$("#save_template").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Template detail View
	templateView = function templateView(id){	
		$.ajax({
			url: url+'/template/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['template'];
				var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';

				modalHtml  ="";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Template Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['title']+"</div></div>";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Type :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['type']+"</div></div>";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Category :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['temp_category']['category_name']+"</div></div>";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Details :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['details']+"</div></div>";

				modalHtml += "</tbody></table></div></div>";
				$('#myModalLabelLg').html(data['title']);
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
		
	//Edit function for Module
	templateEdit = function templateEdit(id){
		var edit_id = id;
		$('#unit_table tr:gt(0)').remove();
		$("#admin_user_add_button").html("<b> Edit Template</b>");
		
		$.ajax({
			url: url+'/template/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['template'];				
				$("#save_template").html('Update');
				$("#edit_id").val(data['id']);
				$("#title").val(data['title']);
				$("#category").val(data['category']);
				$("#template_type").val(data['type']);
				$('#category').trigger('change');
				$("#template_type").trigger('change');				
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				
				details = (data['details'] != null)?data['details']:"";
				if($("#template_type").val() == 'Email'){					
					editors.email_details.setData(details);
				}
				else{
					$("#sms_details").val(details);
				}
				

				$('#entry-form').modal('show');
			}
		});
	}

	//Delete Module
	templateDelete = function templateDelete(id){
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
					url: url+'/template/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							toastr['error']( response['message'], 'Faild!!!');
						}
						else{
							toastr['success']( response['message'], 'Success!!!');
							template_datatable.ajax.reload();
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

	// $('#custom_signeture_div').hide();
	// $("#default_signeture").click(function(){
	// 	if($(this).prop("checked") == true){
	// 		$('#custom_signeture').val("");
	// 		$('#custom_signeture_div').hide();
	// 	}
	// 	else
	// 	$('#custom_signeture_div').show();
	// })
	
	$("#sent_email_submit").on('click',function(event){
		event.preventDefault();
		editors.message_body.updateSourceElement();
		var formData = new FormData($('#sms_form')[0]);
	
		if($.trim($('#message_body').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter message email body","#message_body");
		}
		else if($.trim($('#payment_type').val()) == "" && $.trim($('#all_student_type').val()) == "" && $.trim($('#sms_batch_name').val()) == "" &&   $.trim($('#selected_receipants').html()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select student","#sms_student_name");
		}
		else{
			$.blockUI({message:$("#email-progress"),   timeout: 1000000 });
			// validate the installment details
			$.ajax({
				url: url+"/email/send",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
					$.unblockUI();
					var response = JSON.parse(data);
					if(response['response_code'] == 0){				
						toastr['error']( response['message'], 'Failed!!!!');
					}
					else{
						toastr['success'](response['message'], 'Success!!!');
						$('#selected_receipants').html("");
						clear_form();
					}
					$(window).scrollTop();
				 }
			});
		}
	});
	//email

});

