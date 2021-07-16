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
			{ mData: 'installment', className: "text-center"},
			{ mData: 'payment_month', className: "text-center"},
			{ mData: 'paid_date', className: "text-center"},
			{ mData: 'payment_status', className: "text-center"},			
			{ mData: 'paid_amount', className: "text-right"},
			{ mData: 'actions', className: "text-left"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "120px", "targets":[ 8 ]},
        ],
		"initComplete": function () {
            this.api().columns().every( function (key) {
				var column = this;
				console.log(column[0]);	
			
				if(column[0] == 2 || column[0] == 4 ||  column[0] == 6  ){
					var select = $('<select><option value=""></option></select>')
						.appendTo( $(column.header()) )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				}
            } );
        }
	});
	
//Batch detail View
	batchView = function batchView(id){	
		$.ajax({
			url: url+'/batch/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['batch'];
				var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
				if(data['running_status']=="Completed")
					runningStatusHtml = '<span class="badge badge-primary">Completed</span>'
				else if(data['running_status']=="Running")
					runningStatusHtml =  '<span class="badge badge-success">Running</span>';
				else if(data['running_status']=="Upcoming")
					runningStatusHtml =  '<span class="badge badge-info">Upcoming</span>';

				var end_date 	= (data['end_date'] ==null)?"":data['end_date'];
				var details 	= (data['details'] ==null)?"":data['details'];
				var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch Code :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch_name']+"</div></div>";
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
				if(!jQuery.isEmptyObject(data['batch_fees'])){
					$.each(data['batch_fees'], function(i,dta){ 
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
				$('#myModalLabelLg').html('Batch Details');
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}

	//autosuggest
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		}
	});
	
	
	$("#course_name").on('change',function(){
		id = $(this).val();
		$.ajax({
			url: url+'/student-installment/'+id,
			cache: false,
			success: function(response){
				var option ="";
				var response = JSON.parse(response);
				var data = response['installments'];
				if(!jQuery.isEmptyObject(data)){					
					$.each(data, function(i,installment){ 
						option += `<option value="`+installment['id']+`">`+installment['detail']+`</option>`;
					});
				}
				else{
					option +=`<option value="">No Installment found!</option>`;
				}
				$('#installment_no').html(option);
			}
		});
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
		appendTo : $('#entry-form'),
		minLength: 2,
		select: function(event, ui) {
			var id = ui.item.id;
			$(this).next().val(id);
			getPaymentBatchCourseDetails(id);
		},
	});

	$("#payment_student_name").autocomplete({ 
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

		if($.trim($('#student_name').val()) == "" || $.trim($('#student_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Student","#student_name");
		}
		else if($.trim($('#course_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Enter Course name","#course_name");
		}
		else if($.trim($('#installment_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Installment","#installment_no");
		}
		else if($.trim($('#paid_date').val()) == ""){  
			success_or_error_msg('#form_submit_error','danger',"Please Enter Paid date","#paid_date");
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
						$('#installment_no').html("");
						$('#course_name').html("");
						$('#attachment_div').html("");
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
		$('#attachment_div').html("");
		$('#installment_no').html("");
		$('#course_name').html("");
	});
	

	
	//Payment detail View
	paymentView = function paymentView(id){	
		$.ajax({
			url: url+'/payment/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['payment'];
				var modalHtml = "";
				if(data['payment_status']=="Paid")
				{
					var paymentStatusHtml = '<span class="badge badge-success">Paid</span> ';
					var paidstatusHtml = (data['paid_type']=="Cash")?'<span class="badge badge-info">Cash</span> ':'<span class="badge badge-info">SSL</span> ';
					var statusHtml = (data['receive_status']=="Received")?'<span class="badge badge-success">Received</span> ':'<span class="badge badge-danger">Not Received</span> ';
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Invoice No :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['invoice_no']+"</div></div>";
				}
				else{
					var paymentStatusHtml = '<span class="badge badge-danger">Due</span> ';
					var paidstatusHtml = "";
					var statusHtml = "";
				}
				
								
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+paymentStatusHtml+paidstatusHtml+statusHtml+"</div></div>";
				modalHtml  +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_name']+"</div></div>";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course & Batch :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['course_name']+"</div></div>";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Installment :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['installment_no']+"</div></div>";
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Payable Amount :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['payable_amount']+"</div></div>";
			
				if(data['payment_status']=="Paid"){	
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Paid Amount :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['paid_amount']+"</div></div>";	
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Refference No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['payment_refference_no']+"</div></div>";
				}
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Payment Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['last_payment_date']+"</div></div>";	
				if(data['payment_status']=="Paid"){				
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Paid Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['paid_date']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong> Details :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['details']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong> Attachment :</strong></div>"+"<div class='col-lg-9 col-md-8'><a target='_blank' href='"+payment_attachment_url+"/"+data['attachment']+"'>"+data['attachment']+"</a></div></div>";
				}
				
					
				$('#myModalLabelLg').html('Installment Details');
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
	
	paymentInvoice = function paymentInvoice(id){	
		$.ajax({
			url: url+'/payment/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['payment'];
				var modalHtml = "";
				
				var invoiceHtml =
				`<div class="modal-body printable" id="modalBody">
					<div class="row">
						<div class="col-md-6 text-left"><img src="`+logo+`"></div>
						<div class="col-md-6 text-right">
							<h3>Invoice</h3>
							<h5>ABPBD</h5>
							<p>Registered No. 10475324</p>
						</div>
					</div>
					<div class="row padding-top-bottom-20 ">
						<div class="col-md-8 text-left">
							<p>To</p>
							<p><strong>`+data['student_email']+`</strong></p>
							<p>`+data['address']+`</p>
							<p>Email: `+data['email']+`</p>
							<p>Phone: `+data['contact_no']+`</p>
						</div>
						<div class="col-md-4 text-right">
							<p>Invoice No.</p>
							<p>`+data['invoice_no']+`</p>
						</div>
					</div>
					<table class="table" style="width:100% !important">
					<thead>
						<tr>
							<th class="text-left">Course Details</th>
							<th class="text-center">Installment No</th>
							<th class="text-right">Paid Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-left">`+data['course_name']+`</td>
							<td class="text-center">`+data['installment_no']+`</td>
							<td class="text-right">Tk`+data['paid_amount']+`</td>
						</tr>
					</tbody>
					</table>
					<div class="col-md-12 ">
						<div class="col-md-6 text-left">
							<br>
							<p>Made payment in favour of 'ABPBD'</p>
						</div>
					</div>
				</div>
				`;	
				
				$('#myModalLabelLg').html("Invoice #"+data['invoice_no']);
				$('#modalBodyLg').html(invoiceHtml);
				$('.print-button-lg').show()
				$("#generic_modal_lg").modal();

			}
		});
	}

	//Edit function for Module
	paymentEdit = function paymentEdit(id){
		var edit_id = id;
		$("#clear_button").trigger('click');
		$("#admin_user_add_button").html("<b> Edit Payment</b>");		
		$.ajax({
			url: url+'/payment/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['payment'];
				if(data['payment_status']=='Paid'){
					fee =  data['paid_amount'];		
					date = data['paid_date'];		
				}	
				else{
					fee = data['payable_amount'];	
					date = data['last_payment_date'];			
				}
				
				$("#save_payment").html('Update');
				$("#student_id").val(data['student_id']);
				$("#student_name").val(data['student_name']);
				$("#course_name").html("<option value='"+data['course_id']+"'>"+data['course_name']+"</option>");
				$("#installment_no").html("<option value='"+data['installment_no_value']+"'>Install No. "+data['installment_no']+" ("+fee+")"+"</option>");
				$("#paid_amount").val(fee);
				$("#paid_date").val(date);
				$("#receive_status").val(data['receive_status']);
				$("#payment_refference_no").val(data['payment_refference_no']);
				$('#attachment_div').html("<a target='_blank' href='"+payment_attachment_url+"/"+data['attachment']+"'>"+data['attachment']+"</a>");
				$("#edit_id").val(data['id']);
				$("#details").val(data['details']);
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
							toastr['error']( response['errors'], 'Faild!!!');
						}
						else{
							toastr['success']( response['message'], 'Success!!!');
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

	installmentAdd = function installmentAdd(id){
		$("#clear_button").trigger('click');
		$('#student_enrollment_id').val(id);
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Installment');
		$('#entry-form').modal('show');
	}

	
	var activeTab ="";
	$("#show_schedule").on('click',function(){
		if($('#payment_student_id').val() == "") return false;
		var courseHtml = "";		
		var tab_content = "";
		$.ajax({
			url: url+'/payment-schedule/'+$('#payment_student_id').val(),
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
								
								var actions = (payment['payment_status']!='Paid')?`
								<button type="button"   class="border-0 btn-transition btn btn-outline-primary btn-xs" onClick="editSchedule(`+payment['id']+`)"  ><i class="lnr-pencil"></i></button>

								<button type="button"   class="border-0 btn-transition btn btn-outline-danger btn-xs" onClick="deleteSchedule(`+payment['id']+`)" ><i class="fa fa-trash-alt"></i></button>`:"";
								
								installment_tr += 
								`<tr>
									<th class="text-center">`+payment['installment_no']+`</th>
									<td class="text-center">`+payment['last_payment_date']+`</td>
									<td class="text-right">`+payment['payable_amount']+`</td>
									<td class="text-center">`+invoice_no+`</td>
									<th class="text-center">`+payment_status+`</th>
									<td class="text-center">`+actions+`</td>
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
								<div class="col-md-4">
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
								<div class="col-md-8">
									<table class="mb-0 table-bordered table table-sm ">
										<thead>
										<tr>
											<th class="text-center">Installment No</th>
											<th class="text-center">Payment Date</th>
											<th class="text-right" width="100">Amount</th>
											<th class="text-center">Invoice</th>
											<th class="text-center">Status</th>
											<th class="text-center">
												<button type="button" onclick="installmentAdd(`+batch_student['id']+`)" title="Add New installment" data-placement="bottom" class="btn-shadow mr-3 btn btn-success">
													<i class="fa fa-plus"></i>
													Installment
												</button>
											</th>
										</tr>
										</thead>
										<tbody>									
											`+installment_tr+`
											<tr>
												<td colspan="2" class="text-right"><b>Total Payable Amount</b></td>
												<td>
													<input type="text" class="form-control text-right total_payable_sum" disabled value="`+batch_student['total_payable']+`">
												</td>
												<td colspan="3"></td>
											</tr>
											<tr>
												<td colspan="2"  class="text-right"><b>Original Payable Amount</b></td>
												<td>
													<input type="text" class="form-control text-right total_payable_original" disabled value="`+batch_student['total_payable']+`">
												</td>
												<td colspan="3"></td>
											</tr>
										</tbody>
									</table>
									
								</div>							
							</div>
						</div>
						`;
						//alert(tab_content)
					});
				}
				$('#course_tabs').html(courseHtml);				
				$('#schedule_details').html(tab_content);
				//alert(activeTab)
				if(activeTab != "") $('#'+activeTab).trigger('click');
			}
		});		
	});

		//Entry And Update Function For Module
	$("#save_schedule").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#schedule_form')[0]);

		 if($.trim($('#payable_amount').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter amount","#payable_amount");
		}
		else if($.trim($('#last_payment_date').val()) == ""){  
			success_or_error_msg('#form_submit_error','danger',"Please select payment date","#last_payment_date");
		}
		else{
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
						activeTab = $('#course_tabs > .active').attr('id');
						$("#show_schedule").trigger('click');
						toastr['success']( 'Schedule Saved Successfully', 'Success!!!');
						$('.modal').modal('hide');				
						clear_form();
					}
				}
			});
		}
	});

	editSchedule = function editSchedule(id){
		var edit_id = id;
		$("#clear_button").trigger('click');
		$("#admin_user_add_button").html("<b> Edit Payment</b>");		
		$.ajax({
			url: url+'/payment/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['payment'];				
				$("#save_payment").html('Update');
				$("#course_name").html("<option value='"+data['course_id']+"'>"+data['course_name']+"</option>");
				$("#installment_no").html("<option value='"+data['installment_no_value']+"'>Install No. "+data['installment_no']+" ("+data['payable_amount']+")"+"</option>");
				$("#payable_amount").val(data['payable_amount']);
				$("#last_payment_date").val(data['last_payment_date']);			
				$("#edit_id").val(data['id']);
				$('#entry-form').modal('show');
			}
		});
	}
	
	//EDIT schedule
	deleteSchedule = function deleteSchedule(id){
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
							toastr['error']( response['errors'], 'Faild!!!');
						}
						else{
							activeTab = $('#course_tabs > .active').attr('id');
							$("#show_schedule").trigger('click');
							toastr['success']( 'Schedule deleted successfully', 'Success!!!');
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

