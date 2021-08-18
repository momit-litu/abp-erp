// All the Setting related js functions will be here
$(document).ready(function () {
	
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		}
	});

	

	
	$("#start_registration").on('click',function(){
		$.ajax({
			url: url+'/portal/student-info/',
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['student'];
                $('#registration-modal').modal('show');
				$("#id").val(data['id']);
				$("#name").val(data['name']);
				$("#student_no").val(data['student_no']);
				$("#email").val(data['email']);
				$("#contact_no").val(data['contact_no']);
				$("#emergency_contact").val(data['emergency_contact']);
				$("#address").val(data['address']);
				$("#nid").val(data['nid_no']);
				$("#date_of_birth").val(data['date_of_birth']);
				$("#study_mode").val(data['study_mode']);
				$("#type").val(data['type']);
				$("#current_emplyment").val(data['current_emplyment']);
				$("#last_qualification").val(data['last_qualification']);
				$("#how_know").val(data['how_know']);
				$("#passing_year").val(data['passing_year']);
				$("#remarks").val(data['remarks']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				$('#student_form').iCheck({
						checkboxClass: 'icheckbox_flat-green',
						radioClass: 'iradio_flat-green'
				});	
				var photo = (data["user_profile_image"]!=null && data["user_profile_image"]!="")?data["user_profile_image"]:'no-user-image.png';
				$("#user_image").attr("src", profile_image_url+"/"+photo);

				var attachment_html = "";
				if(data['documents'].length >0){
					$.each(data['documents'], function(i,document){ 
						attachment_html +="<tr><td><input type='text' class='d-none' name='std_docs[]' value='"+document['id']+"' /> <a clas='formData' target='_blank'  href='"+profile_image_url+"/documents/"+document['document_name']+"' >"+document['document_name']+"</a></td><td width='50'><button class='border-0 btn-transition btn btn-outline-danger remove-doc'><i class='fa fa-trash-alt'></i></button></td></tr>";
					});
				}
				$('#attachment_table').append(attachment_html);
				$('.remove-doc').on('click',function(){
					$(this).closest('tr').remove();
				})
			}
		});
	});

	//Entry And Update Function For Module
	$("#save_student").on('click',function(){
		event.preventDefault();
		var formData = new FormData($('#student_form')[0]);


		if($.trim($('#name').val()) == ""){
            success_or_error_msg('#form_submit_error','danger',"Please enter Full name","#name");
		}
		else if($.trim($('#email').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter email","#email");
		}
		else if($.trim($('#contact_no').val()) == "" || !($.isNumeric($('#contact_no').val()))){
			success_or_error_msg('#form_submit_error','danger',"Please enter contact no","#contact_no");
		}
		else if($.trim($('#date_of_birth').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter date of birth","#date_of_birth");
		}
		else{
			$.ajax({
				url: url+"/student",
                type:'POST',
                data:formData,
                async:false,
                cache:false,
                contentType:false,
                processData:false,
				success: function(data){
				    console.log(data)
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
						toastr['error'](resultHtml,  'Failed!!!!');
					}
					else{
						toastr['success']('Student saved successfully',  'Success!!!');
						$('.modal').modal('hide')
						student_datatable.ajax.reload();
						clear_form();
						$("#save_student").html('Save');
						$("#user_image").attr("src", "src");
						$("#id").val('');
					}
				 }
			});
		}
	});
});