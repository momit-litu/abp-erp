// All the Setting related js functions will be here

//sandbox
/*(function (window, document) {
	var loader = function () {
		var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
		script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
		tag.parentNode.insertBefore(script, tag);
	};
	window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
})(window, document);*/

//live
(function (window, document) {
	var loader = function () {
		var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
		script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
		tag.parentNode.insertBefore(script, tag);
	};

	window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
})(window, document);


$(document).ready(function () {
	
	$("#start_registration").on('click',function(){
		
		$('.step-content').css('display','none');
		$('#student-info').css('display','block');
		$('.nav-item').removeClass('active');
		$('#student-info-nav-item').addClass('active');
		$('#save_student').css('display','block');
		$('#enroll_student').css('display','none');
		if(user_id != ""){
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
					$("#student_email").val(data['email']);
					$("#contact_no").val(data['contact_no']);
					$("#emergency_contact").val(data['emergency_contact']);
					$("#student_address_field").val(data['address']);
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
					$("#user_image").attr("src", profile_image_url+photo);

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
		else{
			$('#registration-modal').modal('show');
		}
		
	});

	//Entry And Update Function For Module
	$("#save_student").on('click',function(){
		event.preventDefault();
		var formData = new FormData($('#student_form')[0]);

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
		else if($.trim($('#student_address_field').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter address","#student_address_field");
		}
		else if($.trim($('#last_qualification').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter last qualification","#last_qualification");
		}
		/*else if($.trim($('#passing_year').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter  passing year","#passing_year");
		}
		else if($.trim($('#current_emplyment').val()) == ""){
			success_or_error_msg('#student_form_submit_error','danger',"Please enter last current emplyment","#current_emplyment");
		}*/
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
						toastr['success']('Student information updated successfully',  'Success!!!');
						$('.step-content').css('display','none');
						$('#course-info').css('display','block');
						$('.nav-item').removeClass('active');
						$('#course-info-nav-item').addClass('active');
						$('#save_student').css('display','none');
						$('#enroll_student').css('display','block');
					}
				 }
			});
		}
	});

	//Entry And Update Function For Module
	$("#enroll_student").on('click',function(){
		event.preventDefault();
		var formData = new FormData($('#course_form')[0]);

		if($.trim($('#register_batch_id').val()) == ""){
			success_or_error_msg('#course_form_submit_error','danger',"Please refresh the page and try again","#register_batch_id");
		}
		else if($.trim($('#batch_fees_id').val()) == ""){
			success_or_error_msg('#course_form_submit_error','danger',"Please select a fee plan","#batch_fees_id");
		}
		else if(!$('#terms_condition:checked').length){
			success_or_error_msg('#course_form_submit_error','danger',"Please accept the terms and condition","");
		}
		else{
			$.ajax({
				url: url+"/portal/student-enroll",
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
						toastr['success']('Student registration has been successfull',  'Success!!!');
						$('.step-content').css('display','none');
						$('#success-info').css('display','block');
						$('.nav-item').removeClass('active');
						$('#success-info-nav-item').addClass('active');
						$('#save_student').css('display','none');
						$('#enroll_student').css('display','none');
						if(response['studentFirstPaymentId'])
							$('.first_payment_id').attr('href',url+'/portal/checkout/'+response['studentFirstPaymentId'])

					}
				}
			});
		}
	});

	$(".save_revise_request").on('click',function(){
		event.preventDefault();
		form_id = $(this).closest('form').attr('id');
		var formData = new FormData($('#'+form_id)[0]);

		if($.trim($('#'+form_id+' > #revise_payment_id').val()) == ""){
			return false;
		}
		else{
			$.ajax({
				url: url+"/portal/payment/revise",
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
						toastr['success']('Request has been successful',  'Success!!!');
						$('#revise_payment_details').val("")
					}
				}
			});
		}
	});

	$("input[name='payment_gateway']").on('click', function(){
		$('.payment_gateway_div').hide();	
		if($("input[name='payment_gateway']:checked").val() == "bkash"){	
			$('#bkash_div').show();
		}
		else if($("input[name='payment_gateway']:checked").val() == "rocket"){
			$('#rocket_div').show();
		}
	})

	makePayment = function(payment_id, amount){
		if($("input[name='payment_gateway']:checked").val() == "card"){
			$('#payment_amount').val(amount);
			$('#sslczPayBtn').attr('postdata',payment_id);
			$('#sslczPayBtn').attr('order',payment_id);
			$('#sslczPayBtn').trigger('click');
		}
		else if($("input[name='payment_gateway']:checked").val() == "bkash"){	
			alert('bkash')
		}
		else if($("input[name='payment_gateway']:checked").val() == "rocket"){
			alert('rocket')
		}		
	}
});