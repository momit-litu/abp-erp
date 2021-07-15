// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	$('.form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass	: 'iradio_flat-green'
	});

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
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		$("#user_profile_image").attr("src", profile_image_url+"/no-user-image.png");
		$('#attachment_table >tr').remove();
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
				$("#student_number").html((data['student_no']!=null)?data['student_no']:"");
                $("#student_name").html('<h5>'+data['name']+'</h5>');
                $("#student_contact").html(data['contact_no']);
				$("#student_emergency_contact").html(data['emergency_contact']);
                $("#email_div").html(data['email']);
                $("#student_DOB").html(data['date_of_birth']);
                $("#student_address").html(data['address']);

				$("#nid_div").html((data['nid_no']!=null)?data['nid_no']:"");
				$("#current_emplyment_div").html((data['current_emplyment']!=null)?data['current_emplyment']:"");
				$("#last_qualification_div").html(data['last_qualification']);
				$("#passing_year_div").html(data['passing_year']);

                if (data['remarks']!=null && data['remarks']!="") {
                    $("#remarks_details").html('<b>Remarks:</b>'+data['remarks']);
                }
                else{
                    $("#remarks_div").html('');
                    $("#remarks_details").html("");
                }

				var course_list_html = "";
				if(!jQuery.isEmptyObject(response['courses'])){
					course_list_html +=`
						<h6><b>Course Information</b></h6>
						<table class="table table-bordered table-hover batches_table" style="width:100% !important">
							<thead>
								<tr> 									
									<th>Course Title</th>	
									<th>Batch</th>										
									<th class="text-center">Start Date </th>
									<th class="text-center">End Date</th>
									<th class="text-center">Credit Hr.</th>
									<th class="text-center">Semister</th>												
									<th class="text-center">Status</th>
								</tr>
							</thead>
							<tbody>`;


					$.each(response['courses'], function(i,course){
						course_list_html +=`
								<tr> 									
									<td>`+course['course_name']+`</td>	
									<td>`+course['batch_name']+`</td>										
									<td class="text-center">`+course['start_date']+`</td>	
									<td class="text-center">`+course['end_date']+`</td>	
									<td class="text-center">`+course['total_credit_hour']+`</td>	
									<td class="text-center">`+course['semester_no']+`</td>										
									<td class="text-center">`+course['running_status']+`</td>	
								</tr>
						`;
					});
					course_list_html +=`
							</tbody>
						</table>
					`;
				}
				$("#course_list").html(course_list_html);
                //console.log(profile_image_url)
                if (data["user_profile_image"]!=null && data["user_profile_image"]!="") {
                    $(".student_profile_image").html('<img style="width:100%" src="'+profile_image_url+'/'+data["user_profile_image"]+'" alt="User Image" class="img img-responsive">');
                }
                else{
                    $(".student_profile_image").html('<img  style="width:100%" src="'+profile_image_url+'/no-user-image.png" alt="User Image" class="img img-responsive">');
                }

                if(data['status']=='Active'){
                    $("#status_div").html('<span class="badge badge-success">Active</span>');
                }
                else{
                    $("#status_div").html('<span class="badge badge-danger">In-active</span>');
                } //alert(profile_image_url);
				if(data['type']=='Enrolled'){
                    $("#type_div").html('<span class="badge badge-info">Enrolled</span>');
                }
                else{
                    $("#type_div").html('<span class="badge badge-warning">Non-Enrolled</span>');
                } //alert(profile_image_url);
				var attachment_html = "";
				if(data['documents'].length >0){
					$.each(data['documents'], function(i,document){ 
						attachment_html += "<a clas='formData' target='_blank'  href='"+profile_image_url+"/documents/"+document['document_name']+"' >"+document['document_name']+"</a><br>";
					});
				}
				$('#attachment_div').html(attachment_html);
				
            }
        });
    }

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

	studentPayments = function studentPayments(id){
		var courseHtml = "";		
		var tab_content = "";
		$.ajax({
			url: url+'/payment-schedule/'+id,
			cache: false,
			success: function(response){
				var data = JSON.parse(response);
			//	var data = response['payments'];
				var modalHtml = "";
				if(!jQuery.isEmptyObject(data['batchStudents'])){
					$.each(data['batchStudents'], function(i,batch_student){ 
						var installment_tr = "";
						active= (i==0)?"active":"";
						courseHtml += `
							<a data-toggle="tab" href="#tab-`+batch_student['id']+`" class="mr-1 ml-1 border-0 btn-transition `+active+` btn btn-outline-primary course-tab" id="course-tab-`+batch_student['id']+`">`+batch_student['batch']['course']['title']+`</a>												
						`;

						if(!jQuery.isEmptyObject(batch_student['payments'])){
							$.each(batch_student['payments'], function(j,payment){ 	
								var invoice_no = (payment['invoice_no'] == null)?"":`<a href="javascript:void(0)" onclick="paymentInvoice(`+payment['id']+`)" >`+payment['invoice_no']+`</a>`;

								var payment_status = (payment['payment_status']=='Paid')?"<button class='btn btn-xs btn-success' disabled>Paid</button>":"<button class='btn btn-xs btn-danger' disabled>Due</button>";
	
								installment_tr += 
								`<tr>
									<th class="text-center">`+payment['installment_no']+`</th>
									<td class="text-center">`+payment['last_payment_date']+`</td>
									<td class="text-right">`+payment['payable_amount']+`</td>
									<td class="text-center">`+invoice_no+`</td>
									<th class="text-center">`+payment_status+`</th>
								</tr>`;
							});
						}
						
						if( batch_student['batch']['running_status'] == 'Completed')
							batch_status = " <button class='btn btn-xs btn-success' disabled>Completed</button>";
						else if( batch_student['batch']['running_status'] == 'Running')
							batch_status = " <button class='btn btn-xs btn-primary' disabled>Running</button>";
						else
							batch_status = " <button class='btn btn-xs btn-info' disabled>Upcoming</button>";
						
						feeHtml = (batch_student['batch']['fees'] == batch_student['batch']['discounted_fees'])?`<span><b class="text-dark">`+batch_student['batch']['discounted_fees']+`</b></span>`:`<span class="pr-2"><b class="text-danger"><del>`+batch_student['batch']['fees']+`</del></b></span><span><b class="text-dark">`+batch_student['batch']['discounted_fees']+`</b></span>`;
						
						tab_content += `
						<div class="tab-pane `+active+`" id="tab-`+batch_student['id']+`" role="tabpanel">
							<div class="row">
								<div class="col-md-6">
									<div class="card-shadow-primary profile-responsive card-border mb-3 card">
										<ul class="list-group list-group-flush">
											<li class="bg-warm-flame list-group-item">
												<div class="widget-content p-0">
													<div class="widget-content-wrapper">					
														<div class="widget-content-left">
															<div class="widget-heading text-dark opacity-7"><h5>`+batch_student['batch']['course']['code']+` - `+batch_student['batch']['course']['title']+`</h5></div>
															<div class="widget-heading text-dark opacity-7">Batch `+batch_student['batch']['batch_name']+batch_status+`</div>
															<div class="widget-subheading opacity-10">Course Fee: `+feeHtml+`</div>
														</div>												
													</div>
												</div>
											</li>
											<li class="p-0 list-group-item">
												<div class="grid-menu grid-menu-2col">
													<div class="no-gutters row">
														<div class="col-sm-6">
															<button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-info">
																<h5><strong>`+(batch_student['total_payable'])+`</strong></h5>
																Payable Fee
															</button>
														</div>
														<div class="col-sm-6">
															<button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-success">
																<h5><strong>`+batch_student['total_paid']+`</strong></h5>
																Total Paid
															</button>
														</div>
														<div class="col-sm-6">
															<button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-danger">
																<h5 ><strong>`+batch_student['balance']+`</strong></h5>
																Balance
															</button>
														</div>
														
														<div class="col-sm-6">
															<button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-danger">
																<h5><strong>`+batch_student['payments'].length+`</strong></h5>
																Installment
															</button>
														</div>												
													</div>
												</div>
											</li>
										</ul>
									</div>								
								</div>
								<div class="col-md-6">
									<table class="mb-0 table-bordered table table-sm ">
										<thead>
										<tr>
											<th class="text-center">Inst. No</th>
											<th class="text-center">Payment Date</th>
											<th class="text-right" width="100">Amount</th>
											<th class="text-center">Invoice</th>
											<th class="text-center">Status</th>											
										</tr>
										</thead>
										<tbody>									
											`+installment_tr+`											
										</tbody>
									</table>
								</div>							
							</div>
						</div>
						`;
						//alert(tab_content)
					});
				}
				//$('#course_tabs').html(courseHtml);				
				//$('#schedule_details').html(tab_content);
				
				var paymentModalHtml =`

					<div class="btn-actions-pane-left">
						<div class="nav" id="course_tabs">
						`+courseHtml+`						
						</div>
					</div>

					<div class="tab-content" id="schedule_details">
					`+tab_content+`
					</div>				

				`;
				$('#myModalLabelLg').html('Payment Status');
				$('#modalBodyLg').html(paymentModalHtml);
				$("#generic_modal_lg").modal();			
			}
		});	
	}
});