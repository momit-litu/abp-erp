$(document).ready(function () {
    

	$("#batch_name").autocomplete({ 
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

	$("#batch_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
    });

	$("#show_batch_result").on('click',function(){
        if($('#batch_id').val()!=""){
            $.ajax({
                url: url+"/results/"+$('#batch_id').val(),
                type:'get',
                async:false,
                success: function(data){
                    $('#result_table_div').html(data);
                }
            });
            $('#result_div').css('display','block');
        }     
    })

    $("#save_book").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#book_form')[0]);
       
		if($.trim($('#book_name').val()) == "" || $.trim($('#book_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter book name","#book_name");
		}
		else{
            formData.append('batch_id', $('#batch_id').val());
			// validate the installment details
			$.ajax({
				url: url+"/book",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
                    var response = JSON.parse(data);
					if(response['response_code'] == 0){
                        success_or_error_msg('#form_submit_error','danger',response['errors'],"#book_name");
                    }
                    else{
                        $('#entry-form').modal('hide');
                        $("#show_batch_books").trigger('click');
                    }					
				 }
			});
		}
	});

    $("#student_result_table_search").on('keyup',function(){
          // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("student_result_table_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("student_result_table");
        tr = table.getElementsByTagName("tr");
      
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
		  td1 = tr[i].getElementsByTagName("td")[1];
		  td2 = tr[i].getElementsByTagName("td")[2];
          if (td) {
            txtValue = td.textContent || td.innerText;
			txtValue1 = td1.textContent || td1.innerText;
			txtValue2 = td2.textContent || td2.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              	tr[i].style.display = "";
            } 
			else  if (txtValue1.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} 
			else  if (txtValue2.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}  
			else {
              	tr[i].style.display = "none";
            }
          }
        }
    });
	
	$("#save_result").on('click',function(){
		event.preventDefault();
		var formData = new FormData($('#result_form')[0]);
		var validationError = 0;
		$('.score').each(function(){
			if( $(this).val()!='' && (!($.isNumeric($(this).val())) || $(this).val()<0)){
				validationError = 1;
				success_or_error_msg('#form_submit_error','danger',"Please enter score properly","#score_"+$(this).attr('id'));
			}
		})
		if($.trim($('#edit_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please resfresh and attempt again","edit_id");
		}
		else if(!validationError){
			$.ajax({
				url: url+"/result",
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
						toastr['success']( 'Result Saved Successfully', 'Success!!!');
						$('.modal').modal('hide');					
						$('#show_batch_result').trigger('click')
						clear_form();
					}
				}
			});
		}
	}); 

	// certificate
	$("#show_batch_certificate").on('click',function(){
        if($('#batch_id').val()!=""){
            $.ajax({
                url: url+"/certificates/"+$('#batch_id').val(),
                type:'get',
                async:false,
                success: function(data){
                    $('#certificate_table_div').html(data);
                }
            });
            $('#certificate_div').css('display','block');
        }     
    })

	$("#save_certificate").on('click',function(){
		event.preventDefault();
		var formData = new FormData($('#certificate_form')[0]);

		$.ajax({
			url: url+"/certificate",
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
					toastr['success']( 'Certificate updated Successfully', 'Success!!!');
					$('.modal').modal('hide');					
					$('#show_batch_certificate').trigger('click')
					clear_form();
				}
			}
		});

	}); 

	
	$("#save_feedback").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#feedback_form')[0]);
	
		if($.trim($('#feedback_details').val()) == "" || $.trim($('#batch_student_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please put details","#feedback_details");
		}
		else{
			$.ajax({
				url: url+"/cretificate-feedback",
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
						toastr['success']( 'Feedback saved Successfully', 'Success!!!');
						$('#feedback-form').modal('hide');
						$('#show_batch_certificate').trigger('click');
					}					
				}
			});
		}
	});

});

function viewResult(id){	
	$.ajax({
		url: url+'/result/'+id,
		cache: false,
		success: function(response){
			var response 	= JSON.parse(response);
			var data 		= response['result'];
			var statusHtml 	= (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
			var publishHtml = (data['status']=="Published")?'<span class="badge badge-success">Published</span>':'<span class="badge badge-danger">Not-published</span>';
			var certificatehHtml = '<span class="badge badge-info">'+data['certificate_status']['name']+'</span>';

			var feedbacks = "";
			if(!jQuery.isEmptyObject(data['batch_student_feedback'])){
				$.each(data['batch_student_feedback'], function(i,feedback){ 
					feedbacks += "<b>"+feedback['created_at']+"</b> : "+feedback['feedback']+"<br>";	
				})
			} 

			var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student no :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['student_no']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['name']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['course']['title']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['batch_name']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Enrollment Id :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_enrollment_id']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Result Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+publishHtml+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Certificate Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+certificatehHtml+"</div></div>";

			modalHtml +="<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Result Details:</strong></div>"+"<div class='col-lg-12'>";

			modalHtml +="<table class='table table-bordered' style='width:100% !important'> <thead><tr><th>Unit Name</th><th class='text-center'>Credit Hour</th><th class='text-center'>Score</th><th class='text-center'>Result</th></tr></thead><tbody>";

			if(!jQuery.isEmptyObject(data['batch_student_units'])){
				$.each(data['batch_student_units'], function(i,unit){ 					
					let result 	= (unit['result']==null)?"<span class='text-danger'>Not Published</span>":"<span class='text-success'>"+unit['result']['name']+"</span>";
					let score 	= (unit['score']==null)?"<span class='text-danger'>Not Published</span>":"<span class='text-success'>"+unit['score']+"</span>";

					modalHtml 	+= "<tr class='table-active'><td>("+unit['unit']['unit_code']+") "+unit['unit']['name']+"</td>"+"<td class='text-center'>"+unit['unit']['credit_hour']+"</td>"+"<td class='text-center'>"+score+"</td>"+"<td class='text-center'>"+result+"</td>"+"</tr>";
				
				});
			}
			var overallResult = (data['overall_result']==null)?"":data['overall_result']; 
			modalHtml += `
							<tr>
								<td colspan="3" class='text-right'><strong>Overall Result:</strong></dtdiv>
								<td  class='text-center'><b>`+overallResult+`</b></td>
							</tr>
							</tbody></table><br>
							<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Feedbacks:</strong></div>
							&nbsp;<br><div class='col-lg-12'>`+feedbacks+`</div>
						</div></div>`;
			$('#myModalLabelLg').html('Result of '+data['student']['name']);
			$('#modalBodyLg').html(modalHtml);
			$("#generic_modal_lg").modal();				
		}
	});
}

function editResult(id){	
	$.ajax({
		url: url+'/result/'+id,
		cache: false,
		success: function(response){
			$('#edit_id').val(id);
			var response 	= JSON.parse(response);
			var data 		= response['result'];
			var statusHtml 	= (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
			
			var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student no :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['student_no']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['name']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Enrollment Id :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_enrollment_id']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['course']['title']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['batch_name']+"</div></div>";
			$('#course_info_details').html(modalHtml);
			
			var resultHtml = "";
			if(!jQuery.isEmptyObject(data['batch_student_units'])){
				$.each(data['batch_student_units'], function(i,unit){ 						
					var resultOption = "";
					$.each(response['resultStatus'], function(i,resultStatus){ 	

						if(unit['result']!=null && unit['result']['id']==resultStatus['id'])
							resultOption +=`<option selected value="`+resultStatus['id']+`">`+resultStatus['name']+`</option>`;
						else
							resultOption +=`<option value="`+resultStatus['id']+`">`+resultStatus['name']+`</option>`;
					});
		
					var resultStateSelect = `<select name="studentResults[`+unit['id']+`]" class="form-control result">
												<option selected="" value="Null">Not Given</option>
												`+resultOption+`
										    </select>`;
					var resultScoreInput = `<input type='text' value='`+unit['score']+`' name='score[`+unit['id']+`]' id='score_`+unit['id']+`' class='score form-controll' />`

					resultHtml 	+= "<tr class='table-active'><td>("+unit['unit']['unit_code']+") "+unit['unit']['name']+"</td>"+"<td class='text-center'>"+unit['unit']['credit_hour']+"</td>"+"<td class='text-center'>"+resultScoreInput+"</td>"+"<td class='text-center'>"+resultStateSelect+"</td>"+"</tr>";
				});
			}
			$('#form-title').html('Result of '+data['student']['name']);
			$('#result_div_edit').html(resultHtml);
			$('#entry-form').modal('show');			
		}
	});
}

function publishResult(batch_student_id){
	swal({
		title: "Result Publish!",
		text: "Do you wants to publish result of this student?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url: url+'/result-publish/'+batch_student_id,
				cache: false,
				success: function(data){
					var response = JSON.parse(data);
					if(response['response_code'] == 0){
						toastr['error']( response['errors'], 'Faild!!!');
					}
					else{
						toastr['success']( response['message'], 'Success!!!');
						$('#show_batch_result').trigger('click')
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

function editCertificate(id){	
	$.ajax({
		url: url+'/result/'+id,
		cache: false,
		success: function(response){
			var response 	= JSON.parse(response);
			var data 		= response['result'];
			var statusHtml 	= (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
			var publishHtml = (data['status']=="Published")?'<span class="badge badge-success">Published</span>':'<span class="badge badge-danger">Not-published</span>';
			var certificatehHtml = '<span class="badge badge-info">'+data['certificate_status']['name']+'</span>';

			var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student no :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['student_no']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['name']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['course']['title']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['batch_name']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Enrollment Id :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_enrollment_id']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Result Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+publishHtml+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Certificate Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+certificatehHtml+"</div></div>";

			modalHtml +="<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Result Details:</strong></div>"+"<div class='col-lg-12'>";

			modalHtml +="<table class='table table-bordered' style='width:100% !important'> <thead><tr><th>Unit Name</th><th class='text-center'>Credit Hour</th><th class='text-center'>Score</th><th class='text-center'>Result</th></tr></thead><tbody>";

			if(!jQuery.isEmptyObject(data['batch_student_units'])){
				$.each(data['batch_student_units'], function(i,unit){ 					
					let result 	= (unit['result']==null)?"<span class='text-danger'>Not Published</span>":"<span class='text-success'>"+unit['result']['name']+"</span>";
					let score 	= (unit['score']==null)?"<span class='text-danger'>Not Published</span>":"<span class='text-success'>"+unit['score']+"</span>";

					modalHtml 	+= "<tr class='table-active'><td>("+unit['unit']['unit_code']+") "+unit['unit']['name']+"</td>"+"<td class='text-center'>"+unit['unit']['credit_hour']+"</td>"+"<td class='text-center'>"+score+"</td>"+"<td class='text-center'>"+result+"</td>"+"</tr>";
				
				});
			}
			var overallResult = (data['overall_result']==null)?"":data['overall_result']; 
			modalHtml += `
							<tr>
								<td colspan="3" class='text-right'><strong>Overall Result:</strong></dtdiv>
								<td  class='text-center'><b>`+overallResult+`</b></td>
							</tr>
							</tbody></table>
						</div></div>`;
						
			$('#edit_id').val(id);
			$('#certificate_status').val(data['certificate_status']['id']);
			$('#certificate_no').val(data['certificate_no']);
			$('#form-title').html('Result of '+data['student']['name']);
			$('#certificate_div_edit').html(modalHtml);
			$('#entry-form').modal('show');		

		}
	});
}

addFeedback = function addFeedback(batch_student_id){
	$("#batch_student_id").val(batch_student_id);
	$('#feedback-form').modal('show');
}







