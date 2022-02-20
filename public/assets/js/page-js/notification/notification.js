// All the Setting related js functions will be here
$(document).ready(function () {


	$("#sms_template").on('change',function(){
		$('#message_body').val($('#sms_template_div_'+$(this).find('option:selected').attr('id')).html());	
	});

	getPaymentBatchCourseDetails = function getPaymentBatchCourseDetails(id){	
		$.ajax({
			url: url+'/student-course-batch-autosuggest/'+id,
			cache: false,
			success: function(response){
				var option ="";
				var response = JSON.parse(response);
				var data = response['courses'];
				if(!jQuery.isEmptyObject(data)){
					option +=`<option value="">Select course and batch</option>`;
					$.each(data, function(i,course){ 
						option += `<option value="`+course['id']+`">`+course['detail']+`</option>`;
					});
				}
				else{
					option +=`<option value="">No course found!</option>`;
				}
				$('#course_name').html(option);
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
		$('#message_body').val($('#sms_template_div_'+$(this).find('option:selected').attr('id')).html());	
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
		clear_form();
	});
});

