// All the user related js functions will be here
$(document).ready(function () {	
	
	// for get site url
	var url = $('.site_url').val();

	
	var last_qualification_id =  $.trim($('#last_qualification_id').val());
	if(last_qualification_id!='') $('#last_qualification').val(last_qualification_id)

	
	$("#current_emplyment").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/employement-autosuggest',
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
		appendTo : $('#student_form'),
		minLength: 2,
	});

	$("#current_designation").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/designation-autosuggest',
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
		appendTo : $('#student_form'),
		minLength: 2,
	});
	
	edit_profile = function edit_profile(){
		$("#edit_profile_menu_tab").removeClass('hidden');
		$("#edit_profile_tab").trigger('click');		
	}

	$('.remove-doc').on('click',function(even){
		even.preventDefault();
		swal({
			title: "Are you sure?",
			text: "You wants to delete the document parmanently!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$(this).closest('tr').remove();
			}
			else {
				swal("Your Data is safe..!", {
				icon: "warning",
				});
			}
		});						
	})

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
						toastr['error']( 'Failed!!!!', resultHtml);
					}
					else{				
						toastr['success']( 'Update Successful', 'Personal Information Updated');
						$("#my_profile_tab").trigger('click');
						$("#edit_profile_menu_tab").addClass('hidden');
						//profile_info();
						location.reload(); 
					}
					//$(window).scrollTop();
				 }	
			});
		}	
	});

	$("#update_student_profile_info").on('click',function(event){
		event.preventDefault();
		var formData = new FormData($('#student_form')[0]);
		var passing_year = $.trim($('#passing_year').val());
		if($.trim($('#name').val()) == ""){
            success_or_error_msg('#student_form_submit_error','danger',"Please enter Full name","#name");
		}
		else if($.trim($('#student_email').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter email","#student_email");
		}
		else if($.trim($('#contact_no').val()) == "" || !($.isNumeric($('#contact_no').val()))){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter contact no","#contact_no");
		}
		else if($.trim($('#emergency_contact').val()) == "" || !($.isNumeric($('#emergency_contact').val()))){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter emergency contact no","#emergency_contact");
		}
		else if($.trim($('#emergency_contact').val()) == "" || !($.isNumeric($('#emergency_contact').val()))){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter emergency contact no","#emergency_contact");
		}
		else if($.trim($('#date_of_birth').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter date of birth","#date_of_birth");
		}
		else if($.trim($('#nid').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter NID No","#nid");
		}
		else if($.trim($('#last_qualification').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter last qualification","#last_qualification");
		}
		else if( passing_year== "" || passing_year.length>4){
			success_or_error_msg('#student_form_submit_error','danger',"Please check  passing year","#passing_year");
		}
		else{
			$.ajax({
				url: url+"/portal/student-info",
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
						
						if(typeof(errors)=='string'){
							resultHtml = errors;
						}
						else{
							resultHtml = '<ul>';
							$.each(errors,function (k,v) {
								resultHtml += '<li>'+ v + '</li>';
							});
							resultHtml += '</ul>';
						}
						
						toastr['error'](resultHtml,  'Failed!!!!');
					}
					else{
						toastr['success']('Student information saved successfully',  'Success!!!');
					}
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

		/*if($.trim($('#current_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Current Password","#current_password");			
		}else*/ if($.trim($('#new_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert New Password","#new_password");			
		}else if($.trim($('#confirm_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Confirm Password","#confirm_password");	
		}
		else if($.trim($('#new_password').val()) != $.trim($('#confirm_password').val())){
			success_or_error_msg('#form_submit_error','danger',"Please insert same password","#confirm_password");	
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
							toastr['error']( 'Failed!!!!', resultHtml);
						}
						else{		
							toastr['success']( 'Update Successful', 'Password Changed');		
							$("#my_profile_tab").trigger('click');
							$("#change_pass_menu_tab").addClass('hidden');
							//profile_info();
							$("#new_password").val("");
							$("#confirm_password").val("");
							//$("#current_password").val("");
							
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
			{ "width": "120px", "targets": 1 },
			{ "width": "100px", "targets": 2 },
        ],
		"fixedColumns": true
	});
	
	if (window.location.href.indexOf('notification') > 0) {
		$('#notification_tab').trigger('click');
	}

});


  

	 