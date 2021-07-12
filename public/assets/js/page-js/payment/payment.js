// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	// icheck for the inputs
	$('#payment_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});


	paymentAdd = function paymentAdd(){
		$("#clear_button").trigger('click');
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Payment');
		$("#save_payment").html('Save');	
		$('#entry-form').modal('show');
	}

	payment_datatable = $('#payments_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/payments",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'student_name'},
			{ mData: 'course_name' },
			{ mData: 'paid_date', className: "text-center"},
			{ mData: 'paid_type', className: "text-center"},			
			{ mData: 'paid_amount', className: "text-right"},
		],
		/*"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "110px", "targets":[ 8 ]},
        ],*/
	});
	
	//autosuggest
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		}
	});
	
	showCourse = function showCourse(id){
		$.ajax({
			url: url+'/course/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['course'];
				var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';

				var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course Code :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['code']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['title']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Level :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['level']['name']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>TQT :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['tqt']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Total Credit Hour :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['total_credit_hour']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Registration Fee :</strong></div>"+"<div class='col-lg-9 col-md-8'>£"+data['registration_fees']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";

				modalHtml +="<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Unit Details :</strong></div>"+"<div class='col-lg-12'>";
				modalHtml +="<table class='table table-bordered table-hover ' style='width:100% !important'> <thead><tr><th>Unit Code</th><th>Name</th><th class='text-center'>GLH</th><th class='text-center'>Credit Hours</th><th class='text-center'>Type</th><th class='text-center'>Assessment Type</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['units'])){
					var trHtml = "";
					$.each(data['units'], function(i,data){  
						modalHtml 	+= "<tr><td>"+data['unit_code']+"</td>"+"<td>"+data['name']+"</td>"+"<td class='text-center'>"+data['glh']+"</td>"+"<td class='text-center'>"+data['credit_hour']+"</td>"+"<td class='text-center'>"+data['pivot']['type']+"</td>"+"<td class='text-center'>"+data['assessment_type']+"</td>"+"</tr>";
					})
				}
				modalHtml += "</tbody></table></div></div>";
				$('#myModalLabelLg').html(data['title']);
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
	
	addIns = function addIns(id, arg){
		var installment_id = (arg.installment_id.length>0)?arg.installment_id:'';
		var installment_no = (arg.installment_no.length>0)?arg.installment_no:'';
		var installment_amount = (arg.installment_amount.length>0)?arg.installment_amount:'';

		$("#"+id+">tbody").append("<tr><td class='text-center'><input type='hidden'  name='installment_id["+id+"][]' value='"+installment_id+"'/><input type='text' required  name='installment_no["+id+"][]' value='"+installment_no+"'  class='form-control col-lg-10 input-sm'/></td><td class='text-center'><input type='text' required  value='"+installment_amount+"'  name='installment_amount["+id+"][]'  class='form-control col-lg-10 input-sm'/></td><td class='text-center'><button type='button'  title='Remove Installment' data-placement='bottom' class='border-0 btn-transition btn btn-outline-danger btn-xs remove_installment_row' onclick='$(this).parent().parent().remove()'><i class='fa fa-trash-alt'></i></button></td></tr>");
	}

	clearPlan = function clearPlan(id){
		$('.tr_'+id).remove();
	}

	callAddIns = function callAddIns(id){
		var insData = {
			installment_id:"",
			installment_no: "", 
			installment_amount: ""
		};
		addIns(id, insData);
	}
	

	var installment_plan =1;	

	addPlan = function addPlan(id, arg){
		//alert('addplan-'+id)				
		var plan_id = (arg.plan_id.length>0)?arg.plan_id:'';
		var plan_name = (arg.plan_name.length>0)?arg.plan_name:'';
		var total_installment = (arg.total_installment.length>0)?arg.total_installment:'';
		var installment_duration = (arg.installment_duration.length>0)?arg.installment_duration:'';
		var payable_amount = (arg.payable_amount.length>0)?arg.payable_amount:'';

		return  `<tr class="table-active tr_`+id+`"><td><input type="hidden" name="plan_id[]" value="`+plan_id+`"><input type="text" name="plan_name[]" required class="form-control col-lg-12" value="`+plan_name+`"/></td><td class="text-center"><input type="text" required name="installment_duration[]" value="`+installment_duration+`" class="form-control col-lg-10"/></td><td class="text-center plnme"><input type="text" required name="total_installment[]" value="`+total_installment+`" class="form-control col-lg-10"/></td><td class="text-center"><input type="text" required name="payable_amount[]" value="`+payable_amount+`" class="form-control col-lg-10"/></td><td class="text-center"><div role="group" class="btn-group-sm btn-group btn-group-toggle" data-toggle="buttons"><button type="button"  title="Add Installment" data-placement="bottom" class="btn-shadow btn mr-3 btn-success btn-xs" onClick="callAddIns(`+id+`)"><i class="fa fa-plus"></i></button><button type="button"  title="Remove plan" data-placement="bottom" class="btn-shadow btn btn-danger btn-xs" onClick="clearPlan(`+id+`)"><i class="fa fa-trash"></i></button></td></tr>`+
		`<tr class="tr_`+id+`"><td colspan='2' class='text-right'><b>Installment Details</b></td><td colspan='3'><table class='table table-bordered table-sm installment_table' style='width:100% !important' id='`+id+`'> <thead class='thead-light'><tr><th>Inst. No</th><th>Amount</th></tr></thead><tbody></tbody></table></td></tr>`;
	}

	$("#plan_add_button").on('click',function(){	
		var planData = {
			plan_id:"",
			plan_name: "", 
			total_installment: "",
			installment_duration: "",
			payable_amount: "",
		};
		var html = addPlan(installment_plan, planData);
		$("#plan_table>tbody").append(html);
		var insData = {
			installment_id:"",
			installment_no: "", 
			installment_amount: ""
		};
		addIns(installment_plan, insData );
		installment_plan++;

	});
	//$("#plan_add_button").trigger('click');

	$("#plan_clear_button").on('click',function(){	
		$("#plan_table>tbody").html('');
	});
	

	$("#course_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/course-autosuggest/Admin',
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
		appendTo : $('#entry-form'),
		minLength: 2,
		select: function(event, ui) {
			var id = ui.item.id;
			$(this).next().val(id);
		},
	});

	//Entry And Update Function For Module
	$("#save_payment").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#payment_form')[0]);

		if($.trim($('#payment_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Payment","#payment_name");
		}
		else if($.trim($('#course_name').val()) == "" || $.trim($('#course_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter Course name","#course_name");
		}
		else if($.trim($('#start_date').val()) == ""){  
			success_or_error_msg('#form_submit_error','danger',"Please enter start date","#start_date");
		}
		else if($.trim($('#student_limit').val()) == "" || !($.isNumeric($('#student_limit').val()))){
			success_or_error_msg('#form_submit_error','danger',"Please enter total student imit","#student_limit");
		}
		else if($.trim($('#fees').val()) == "" || !($.isNumeric($('#fees').val()))){
			success_or_error_msg('#form_submit_error','danger',"Please enter fees","#fees");
		}
		else{
			// validate the installment details
			$.ajax({
				url: url+"/payment",
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
						toastr['success']( 'Payment Saved Successfully', 'Success!!!');
						$('.modal').modal('hide');					
						payment_datatable.ajax.reload();
						clear_form();
						$('#unit_table tr:gt(0)').remove();
						$("#save_payment").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
		$("#plan_table>tbody").html('');
	});
	

	
	//Payment detail View
	paymentView = function paymentView(id){	
		$.ajax({
			url: url+'/payment/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['payment'];
				var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
				if(data['running_status']=="Completed")
					 runningStatusHtml = '<span class="badge badge-primary">Completed</span>'
				else if(data['running_status']=="Running")
					runningStatusHtml =  '<span class="badge badge-success">Running</span>';
				else if(data['running_status']=="Upcoming")
					runningStatusHtml =  '<span class="badge badge-info">Upcoming</span>';

				var end_date 	= (data['end_date'] ==null)?"":data['end_date'];
				var details 	= (data['details'] ==null)?"":data['details'];
				var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Payment Code :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['payment_name']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['course']['title']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Start Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['start_date']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>End Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+end_date+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student limit :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_limit']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Total Enrolled Student :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['total_enrolled_student']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong> Details :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+details+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Registration Fee :</strong></div>"+"<div class='col-lg-9 col-md-8'>£"+data['fees']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Discount Fee :</strong></div>"+"<div class='col-lg-9 col-md-8'>£"+data['discounted_fees']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+runningStatusHtml+statusHtml+"</div></div>";

				modalHtml +="<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Payment Details:</strong></div>"+"<div class='col-lg-12'>";
				modalHtml +="<table class='table table-bordered' style='width:100% !important'> <thead><tr><th>Plan Name</th><th class='text-center'>Total Inst. No</th><th class='text-center'>Duration (Month)</th><th class='text-right'>		Total Payable</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['payment_fees'])){
					$.each(data['payment_fees'], function(i,dta){ 
						var installment_duration = (dta['installment_duration']==0)?'':dta['installment_duration']; 
						modalHtml 	+= "<tr class='table-active'><td>"+dta['plan_name']+"</td>"+"<td class='text-center'>"+dta['total_installment']+"</td>"+"<td class='text-center'>"+installment_duration+"</td>"+"<td class='text-right'>"+dta['payable_amount']+"</td>"+"</tr>";
						if(dta['plan_name']!='Onetime'){
							modalHtml 	+= "<tr><td colspan='2' class='text-right'><b>Installment Details</b></td><td colspan='2'><table class='table table-bordered table-sm' style='width:100% !important'> <thead class='thead-light'><tr><th class='text-center'>Inst. No</th><th class='text-right'>Amount</th></tr></thead><tbody>";
							if(!jQuery.isEmptyObject(dta['installments'])){
								$.each(dta['installments'], function(i,dt){ 
									modalHtml 	+= "<tr><td class='text-center'>"+dt['installment_no']+"</td><td class='text-right'>"+dt['amount']+"</td></tr>";
								});

							}
							modalHtml 	+="</tbody></table></td></tr>";
						}
					});
				}
				modalHtml += "</tbody></table></div></div>";
				$('#myModalLabelLg').html('Payment Details');
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}

	paymentStudents = function paymentStudents(id){	
		$.ajax({
			url: url+'/payment-students/'+id,
			cache: false,
			success: function(response){
				var modalHtml ="";
				var response = JSON.parse(response);
				var data = response['payment'];
				var stuents = data['students']
				
				modalHtml +=`<div id="accordion" class="accordion-wrapper mb-3">
								<div class="card">
									<div id="headingOne" class="card-header text-right">
										<button type="button" class='btn btn-primary col-md-12' data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
											<h5 class="m-0 p-0">Enroll a student in this payment </h5>
										</button>
									</div>
									<div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse text-left">
										<div class="card-body">
											<div class="col-md-12">
												<div class="form-row">
													<div class="col-md-7">
														<div class="position-relative form-group">
															<label class="">Student<span class="required">*</span></label>
															<input type="text" id="student_name" name="student_name" required class="form-control col-lg-12"/>
															<input type="hidden" id="student_id" required name="student_id"  />
															<input type="hidden" id="payment_id" required name="payment_id" value="`+data['id']+`"  />
														</div>
													</div>	
													<div class="col-md-3">
														<div class="position-relative form-group">
															<label class="">Fee Payment Plan<span class="required">*</span></label>
															<select id="payment_fees_id" name="payment_fees_id" class="form-control col-lg-12">`;
																$.each(data['payment_fees'], function(i,dta){ 
				modalHtml +=										`<option value="`+dta['id']+`">`+dta['plan_name']+` (`+dta['payable_amount']+`)</option>`;
																});
				modalHtml +=								`</select> 										
														</div>
													</div>
													<div class="col-md-2">
														<div class="position-relative form-group">
															<label class="">&nbsp;<span class="required"></span></label>
																<button type="button" id="save_student" class="btn btn-success  btn-lg btn-block">
																	<i class="fa fa-plus"></i>Add
																</button>
														</div>
													</div>									
												</div>
											</div>
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="no-gutters row">
								<div class="col-md-12 col-lg-6">
									<ul class="list-group list-group-flush">
										<li class="bg-transparent list-group-item">
											<div class="widget-content p-0">
												<div class="widget-content-outer">
													<div class="widget-content-wrapper">
														<div class="widget-content-left">
															<div class="widget-heading">Student Limit</div>
															<div class="widget-subheading">At most no of student can be enrolled </div>
														</div>
														<div class="widget-content-right">
															<div class="widget-numbers text-success">`+data['student_limit']+`</div>
														</div>
													</div>
												</div>
											</div>
										</li>										
									</ul>
								</div>
								<div class="col-md-12 col-lg-6">
									<ul class="list-group list-group-flush">
										<li class="bg-transparent list-group-item">
											<div class="widget-content p-0">
												<div class="widget-content-outer">
													<div class="widget-content-wrapper">
														<div class="widget-content-left">
															<div class="widget-heading">Enrolled Students</div>
															<div class="widget-subheading">No of student already enrolled</div>
														</div>
														<div class="widget-content-right">
															<div class="widget-numbers text-primary" id="total_enrolled_student">`+data['total_enrolled_student']+`</div>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>				
							`;
				modalHtml +="<table id='student_table' class='table table-bordered table-sm' style='width:100% !important'> <thead><tr><th></th><th>Student No.</th><th>Full Name</th><th class='text-left'>Email</th><th class='text-center'>Contact No.</th><th class='text-center'>Status</th><th></th></tr></thead><tbody>";

				if(!jQuery.isEmptyObject(data['students'])){
					$.each(data['students'], function(i,student){ 
						if(student['pivot']['status'] == 'Active') {
							student_status = "<button class='btn btn-xs btn-success' disabled>"+student['pivot']['status']+"</button>";
							std_button = "<button type='button'  title='Remove Student' data-placement='bottom' class='border-0 btn-transition btn btn-outline-danger btn-xs remove-student' ><i class='fa fa-trash-alt'></i></button>";
						}
						else {
							student_status = "<button class='btn btn-xs btn-danger' disabled>"+student['pivot']['status']+"</button>";
							std_button = "<button type='button'  title='Add Student' data-placement='bottom' class='border-0 btn-transition btn btn-outline-success btn-xs add-student' ><i class='fa fa-check'></i></button>";
						}

						modalHtml 	+= "<tr><td>"+(i+1)+"</td><td>"+student['student_no']+"</td>"+"<td>"+student['name']+"</td>"+"<td class='text-left'>"+student['email']+"</td>"+"<td class='text-left'>"+student['contact_no']+"</td>"+"<td class='text-left'>"+student_status+"<td>"+std_button+"<input type='hidden' id='student_"+student['id']+"' value="+student['id']+" /></td></tr>";
					})
				}
				modalHtml += "</tbody></table>";
				$('#myModalLabelLg').html('Student details of payment  #'+data['payment_name']+" ("+data['course']['title']+")");
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();	
				

				$("#student_name").autocomplete({ 
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
					appendTo : $('#generic_modal_lg'),
					minLength: 2,
					select: function(event, ui) {
						var id = ui.item.id;
						$(this).next().val(id);
					},
				});

				var student_data_table = $('#student_table').DataTable({
					responsive: true,
					paging:     false,
					"info": false
				});
				
				$('#save_student').on('click',function(){
					event.preventDefault();
					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
						}
					});					
					if( $.trim($('#payment_id').val()) == "" || $.trim($('#student_name').val()) == "" || $.trim($('#student_name').val()) == ""){
						return false;
					}					
					else{
						$.ajax({
							url: url+"/payment-student",
							type:'POST',
							data:{payment_id:$('#payment_id').val(), student_id:$('#student_id').val(),payment_fees_id:$('#payment_fees_id').val()
							},
							async:false,
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
									var student = response['student'];
									toastr['success']( 'Student Enrollment Saved Successfully', 'Success!!!');
									student_status = ("<button class='btn btn-xs btn-success' disabled>"+student['status']+"</button>");
									student_data_table.row.add([response['total_enrolled_student'],student['student_no'],student['name'],student['email'], student['contact_no'], student_status,"<button type='button'  title='Remove Student' data-placement='bottom' class='border-0 btn-transition btn btn-outline-danger btn-xs remove-student'><i class='fa fa-trash-alt'></i></button><input type='hidden' id='student_"+student['id']+"' value="+student['id']+" />"]).draw();
			
									$('#total_enrolled_student').html(response['total_enrolled_student']);
									$('#student_name').val("");
									$('#student_id').val("");
								}
								$(window).scrollTop();
							 }
						});
					}
				});	


				$('.remove-student').on('click',function(){
					var id = $(this).next('input').val();
					var row = $(this)
					event.preventDefault();
					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
						}
					});					
					if( $.trim($('#payment_id').val()) == "" || id == ""){
						return false;
					}					
					else{
						$.ajax({
							url: url+"/payment-student/delete",
							type:'POST',
							data:{payment_id:$('#payment_id').val(), student_id:id},
							async:false,
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
								else if(response['response_code'] ==2){
									row.removeClass('btn-outline-danger');
									row.removeClass('remove-student');
									row.addClass('btn-outline-success');
									row.removeClass('add-student');
									row.html("<i class='fa fa-check'></i>");
									row.parent().prev('td').html("<button class='btn btn-xs btn-danger' disabled>Inactive</button>");
									
									toastr['success']( response['message'], 'Success!!!');
									$('#total_enrolled_student').html(response['total_enrolled_student']);
								}
								else{
									row.closest('tr').remove();
									toastr['success']( response['message'], 'Success!!!');
									$('#total_enrolled_student').html(response['total_enrolled_student']);
								}
								$(window).scrollTop();
							 }
						});
					}
				})

				$('.add-student').on('click',function(){
					var id = $(this).next('input').val();
					var add_std_biutton =  $(this);
					event.preventDefault();
					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
						}
					});					
					if( $.trim($('#payment_id').val()) == "" || id == ""){
						return false;
					}					
					else{
						$.ajax({
							url: url+"/payment-student/update",
							type:'POST',
							data:{payment_id:$('#payment_id').val(), student_id:id},
							async:false,
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
									add_std_biutton.removeClass('btn-outline-success');
									add_std_biutton.removeClass('add-student');
									add_std_biutton.addClass('btn-outline-danger');
									add_std_biutton.removeClass('remove-student');
									add_std_biutton.html("<i class='fa fa-trash-alt'></i>");
									add_std_biutton.parent().prev('td').html("<button class='btn btn-xs btn-success' disabled>Active</button>");
									toastr['success']( 'Student Added Successfully', 'Success!!!');
								}
								$(window).scrollTop();
							 }
						});
					}
				})

				
			}
		});
	}
	
	
	

	//Edit function for Module
	paymentEdit = function paymentEdit(id){
		var edit_id = id;
		installment_plan =1;
		$("#clear_button").trigger('click');
		$('#unit_table tr:gt(0)').remove();
		$("#admin_user_add_button").html("<b> Edit Payment</b>");
		
		$.ajax({
			url: url+'/payment/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['payment'];				
				$("#save_payment").html('Update');
				$("#payment_name").val(data['payment_name']);
				$("#course_id").val(data['course_id']);
				$("#course_name").val(data['course']['title']);
				$("#start_date").val(data['start_date']);
				$("#end_date").val(data['end_date']);
				$("#fees").val(data['fees']);
				$("#discounted_fees").val(data['discounted_fees']);
				$("#student_limit").val(data['student_limit']);
				$("#edit_id").val(data['id']);
				$("#details").val(data['details']);
				$("#running_status").val(data['running_status']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				if(!jQuery.isEmptyObject(data['payment_fees'])){
					$.each(data['payment_fees'], function(i,dta){
							if(dta['plan_name']!='Onetime'){ 
							var planData = {
								plan_id: dta['id'].toString(), 
								plan_name: dta['plan_name'], 
								total_installment: dta['total_installment'].toString(), 
								installment_duration:dta['installment_duration'].toString(), 
								payable_amount: dta['payable_amount'].toString(),
							};
							
							var html = addPlan(installment_plan, planData);
							$("#plan_table>tbody").append(html);						
							if(!jQuery.isEmptyObject(dta['installments'])){
								$.each(dta['installments'], function(j,dt){							
									var insData = {
										installment_id: dt['id'].toString(), 
										installment_no: dt['installment_no'].toString(), 
										installment_amount: dt['amount'].toString(), 
									};
									console.log(insData);
									addIns(installment_plan, insData );
								});
							}
							installment_plan++;
						}												
					})
				}
				$('#entry-form').modal('show');
			}
		});
	}

	//Delete Module
	paymentDelete = function paymentDelete(id){
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
					url: url+'/payment/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							success_or_error_msg('#form_submit_error',"danger",response['errors']);
						}
						else{
							success_or_error_msg('#form_submit_error',"success",response['message']);
							payment_datatable.ajax.reload();
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

