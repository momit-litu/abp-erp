// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url


	//for show students list
	student_datatable = $('#students_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/students",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'user_profile_image', className: "text-center"},
			{ mData: 'student_no'},
			{ mData: 'first_name'},
			{ mData: 'email'},
			{ mData: 'contact_no'},
		//	{ mData: 'address'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-left"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "110px", "targets":[ 7 ]},
        ],
	});


	//Entry And Update Function For Module
	$("#save_student").on('click',function(){
		event.preventDefault();

		console.log('save_student')
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

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
		/*else if($.trim($('#date_of_birth').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter date of birth","#date_of_birth");
		}*/
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
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		$("#user_profile_image").attr("src", profile_image_url+"/user.png");
		$('#attachment_table >tr').remove();
		clear_form();
	});


	//Edit function for Module

    studentAdd = function studentAdd(){
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Student');
		if($('#attachment_table>tr').length>0) $('#attachment_table >tr').remove();
        $("#clear_button").show();
        $("#save_admin_info").html('Save');
        $('#entry-form').modal('show');
    }

	studentEdit = function studentEdit(id){
        console.log(id)
		var edit_id = id;
		$("#clear_button").trigger('click');
		$("#admin_user_add_button").html("<b> Edit Student</b>");

		$.ajax({
			url: url+'/student/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['student'];

				$("#save_student").html('Update');
				$("#clear_button").hide();
                $("#form-title").html('<i class="fa fa-plus"></i> Update Student');
                $('#entry-form').modal('show');
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
				var photo = (data["user_profile_image"]!=null && data["user_profile_image"]!="")?data["user_profile_image"]:'user.png';
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
	}

	//Delete Module
	studentDelete = function studentDelete(id){
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
					url: url+'/student/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							toastr['error']( response['message'], 'Faild!!!');
						}
						else{
							toastr['success'](response['message'], 'Success!!!');
							student_datatable.ajax.reload();
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