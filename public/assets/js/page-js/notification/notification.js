// All the Setting related js functions will be here
$(document).ready(function () {
	$("#sms_template").on('change',function(){
		$('#message_body').val($('#sms_template_div_'+$(this).find('option:selected').attr('id')).html());	
	});
	$("#email_template").on('change',function(){
		editors.message_body.setData($('#email_template_div_'+$(this).find('option:selected').attr('id')).html());	
	});
	
	getPaymentBatchTemplateDetails = function getPaymentBatchTemplateDetails(id){	
		$.ajax({
			url: url+'/student-template-batch-autosuggest/'+id,
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
				url: url+'/template-batch-autosuggest',
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
	$("#sent_sms_submit").on('click',function(){
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

	// title details edit_id placeholders category template_type status
	$("#save_template").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		editors.details.updateSourceElement();
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
				$("#short_name").val(data['short_name']);
				$("#short_name_id").val(data['short_name_id']);
				$("#trainers").val(data['trainers']);
				$("#code").val(data['code']);
				$("#title").val(data['title']);
				$("#tqt").val(data['tqt']);
				$("#total_credit_hour").val(data['total_credit_hour']);
				$("#level_id").val(data['level_id']);
				$("#registration_fees").val(data['registration_fees']);
				$("#edit_id").val(data['id']);
				$("#awarder_by").val(data['awarder_by']);
				$("#programme_duration").val(data['programme_duration']);
				$("#semester_no").val(data['semester_no']);
				$("#glh").val(data['glh']);
				$("#study_mode").val(data['study_mode']);
				$("#youtube_video_link").val(data['youtube_video_link']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');


				objective 			= (data['objective'] != null)?data['objective']:"";
				accredited_by 		= (data['accredited_by'] != null)?data['accredited_by']:"";
				semester_details 	= (data['semester_details'] != null)?data['semester_details']:"";
				assessment 			= (data['assessment'] != null)?data['assessment']:"";
				grading_system 		= (data['grading_system'] != null)?data['grading_system']:"";
				requirements 		= (data['requirements'] != null)?data['requirements']:"";
				experience_required = (data['experience_required'] != null)?data['experience_required']:"";

				editors.objective.setData(objective);
				editors.accredited_by.setData(accredited_by);
				editors.semester_details.setData(semester_details);
				editors.assessment.setData(assessment);
				editors.grading_system.setData(grading_system);
				editors.requirements.setData(requirements);
				editors.experience_required.setData(experience_required);

				var photo = (data["template_profile_image"]!=null && data["template_profile_image"]!="")?data["template_profile_image"]:'no-user-image.png';
				$("#template_image").attr("src", template_profile_image+"/"+photo);

				if(!jQuery.isEmptyObject(data['units'])){
					var trHtml = "";
					var tota_glh =0;
					$.each(data['units'], function(i,data){ 
						var typeOption = (data['pivot']['type'] =='Optional')?"<option selected value='Optional'>Optional</option><option value='Mandatory'>Mandatory</option>":"<option value='Optional'>Optional</option><option selected value='Mandatory'>Mandatory</option>";				
						trHtml 	+= "<tr>"+"<td><input type='hidden' name='unit_ids[]' value='"+data['id']+"' />"+data['unit_code']+"</td>"+"<td>"+data['name']+"</td>"+"<td>"+data['glh']+"<td>"+data['tut']+"</td>"+"</td>"+"<td><select name='type[]' class='form-control col-lg-12'>"+typeOption+"</select></td>"+"<td>"+data['assessment_type']+"</td>"+"<td><button onclick='$(this).parent().parent().remove();  calculateTotalUnit("+data['glh']+","+data['credit_hour']+","+data['tut']+")' ' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button></td>"+"</tr>";
						tota_glh += parseFloat(data['glh']);
					})
					$('#glh').val(tota_glh)
					$('#unit_table').append(trHtml);
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

	
	$("#sent_email_submit").on('click',function(){
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

