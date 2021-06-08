// All the user related js functions will be here
$(document).ready(function () {	
	
	// for get site url
	var url = $('.site_url').val();
	/*----- My Profile ------*/
	edit_profile = function edit_profile(){
		$("#edit_profile_menu_tab").removeClass('hidden');
		$("#edit_profile_tab").trigger('click');		
	}

	$('#update_profile_info').click(function(event){		
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#my_profile_form')[0]);

		if($.trim($('#first_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert First Name","#first_name");			
		}
		else if($.trim($('#contact_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert contact no","#contact_no");			
		}
		else if($.trim($('#email').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Select Email","#email");			
		}	
		else{
			
			$.ajax({
				url: url+"/profile/my-profile-update",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
					var response = JSON.parse(data);
				
					if(response['result'] == '0'){
						var errors	= response['errors'];					
						resultHtml = '<ul>';
							$.each(errors,function (k,v) {
							resultHtml += '<li>'+ v + '</li>';
						});
						resultHtml += '</ul>';
						success_or_error_msg('#master_message_div',"danger",resultHtml);
					}
					else{				
						success_or_error_msg('#master_message_div',"success","Update Successfully");
						$("#my_profile_tab").trigger('click');
						$("#edit_profile_menu_tab").addClass('hidden');
						profile_info();
					}
					$(window).scrollTop();
				 }	
			});
		}	
	});

	change_password = function change_password(){
		$.ajax({
			url: url+'/profile/my-profile-info',
			success: function(response){
				var response = JSON.parse(response);
				var data = response[0];
				$("#change_pass_menu_tab").removeClass('hidden');
				$("#change_pass_tab").trigger('click');
				$("#change_pass_id").val(data['id']);
			}
		});			
	}

	$('#update_password').click(function(event){		
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#change_password_form')[0]);

		if($.trim($('#current_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Current Password","#current_password");			
		}else if($.trim($('#new_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert New Password","#new_password");			
		}else if($.trim($('#confirm_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Confirm Password","#confirm_password");			
		}
		else{
			var new_password = $("#new_password").val();
			var confirm_password = $("#confirm_password").val();
			if (new_password==confirm_password) {
				$.ajax({
					url: url+"/profile/password-update",
					type:'POST',
					data:formData,
					async:false,
					cache:false,
					contentType:false,
					processData:false,
					success: function(data){
						var response = JSON.parse(data);
					
						if(response['result'] == '0'){
							var errors	= response['errors'];					
							resultHtml = '<ul>';
								$.each(errors,function (k,v) {
								resultHtml += '<li>'+ v + '</li>';
							});
							resultHtml += '</ul>';
							success_or_error_msg('#master_message_div',"danger",resultHtml);
						}
						else{				
							success_or_error_msg('#master_message_div',"success","Change Password Successfully");
							$("#my_profile_tab").trigger('click');
							$("#change_pass_menu_tab").addClass('hidden');
							profile_info();
						}
						$(window).scrollTop();
					}	
				});
			}
			else{
				success_or_error_msg('#master_message_div',"danger","New Password And Confirm Password Does Not Match");
			}			
		}	
	})
	
	notification_datatable = $('#notification_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/notifications/",
		"aoColumns": [			
			{ mData: 'message'},
			{ mData: 'date' , className: "text-center"},
			{ mData: 'status', className: "text-center"},
		],
		"columnDefs": [
			{ "width": "180px", "targets": 1 },
			{ "width": "120px", "targets": 2 },
        ],
		"fixedColumns": true
	});
	
	if (window.location.href.indexOf('notification') > 0) {
		$('#notification_tab').trigger('click');
	}

});


  

	 