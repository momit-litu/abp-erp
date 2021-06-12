// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

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
			{ mData: 'first_name'},
			{ mData: 'last_name'},
			{ mData: 'email'},
			{ mData: 'contact_no'},
			{ mData: 'address'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-left"},
		],
	});

	//autosuggest
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		}
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


		if($.trim($('#first_name').val()) == ""){
            success_or_error_msg('#form_submit_error','danger',"Please enter first name","#first_name");
		}
		if($.trim($('#last_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter first name","#first_name");
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
						success_or_error_msg('#form_submit_error',"danger",resultHtml);
					}
					else{
						$("#admin_user_list_button").trigger('click');
						success_or_error_msg('#master_message_div',"success",response['message']);
						student_datatable.ajax.reload();
						clear_form();
						$("#clear_button").show();
						$("#save_student").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		$("#user_profile_image").attr("src", profile_image_url+"/no-user-image.png");
		clear_form();
	});



	//student detail View
    studentView = function admin_user_view(id){
        var user_id = id;
        $.ajax({
            url: url+'/student/'+user_id,
            success: function(response){
                var response = JSON.parse(response);
                console.log(response)
                var data = response['student'];

                $("#student-view-modal").modal();
                $("#student_name").html('<h5>'+data['first_name']+" "+data['last_name']+'</h5>');
                $("#student_contact").html(data['contact_no']);
                $("#email_div").html(data['email']);
                $("#student_DOB").html(data['date_of_birth']);

                $("#student_address").html(data['address']);


                if (data['remarks']!=null && data['remarks']!="") {
                    $("#remarks_details").html('<b>Remarks:</b>'+data['remarks']);
                }
                else{
                    $("#remarks_div").html('');
                    $("#remarks_details").html("");
                }

                console.log(profile_image_url)
                if (data["user_profile_image"]!=null && data["user_profile_image"]!="") {
                    $(".student_profile_image").html('<img style="width:100%" src="'+profile_image_url+'/'+data["user_profile_image"]+'" alt="User Image" class="img img-responsive">');
                }
                else{
                    $(".student_profile_image").html('<img  style="width:100%" src="'+profile_image_url+'/no-user-image.png" alt="User Image" class="img img-responsive">');
                }


                if(data['status']==1){
                    $("#status_div").html('<span class="badge badge-success">Active</span>');
                }
                else{
                    $("#status_div").html('<span class="badge badge-danger">In-active</span>');
                } //alert(profile_image_url);
            }
        });
    }

	//Edit function for Module

    studentAdd = function studentAdd(){
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Admin User');
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
				$("#first_name").val(data['first_name']);
				$("#last_name").val(data['last_name']);
				$("#email").val(data['email']);
				$("#contact_no").val(data['contact_no']);
				$("#address").val(data['address']);
				$("#nid").val(data['nid_no']);
				$("#date_of_birth").val(data['date_of_birth']);
				$("#remarks").val(data['remarks']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');

				var photo = (data["user_profile_image"]!=null && data["user_profile_image"]!="")?data["user_profile_image"]:'no-user-image.png';
				$("#user_image").attr("src", profile_image_url+"/"+photo);

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
							success_or_error_msg('#master_message_div',"danger",response['errors']);
						}
						else{
							success_or_error_msg('#master_message_div',"success",response['message']);
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

