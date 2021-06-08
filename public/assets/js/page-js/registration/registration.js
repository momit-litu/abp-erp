// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();
	var certificateId = "";
	// icheck for the inputs
	$('#registration_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
	
	const zeroPad = (num, places) => String(num).padStart(places, '0')
	


	//for show registrations list
	 registration_datatable = $('#registrations_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/registrations",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'registration_no'},			
			{ mData: 'center_name'},			
			{ mData: 'qualification_title'},
			{ mData: 'no_of_units' , className: "text-center"},
			{ mData: 'no_of_learners' , className: "text-center"},			
			{ mData: 'approval_status', className: "text-center"},
			{ mData: 'payment_status', className: "text-center"},
			{ mData: 'status', className: "text-center"},
			{ mData: 'invoice_no' },
			{ mData: 'actions' , className: "text-left"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "130px", "targets":[ 10 ]},
        ],
		"initComplete": function () {
            this.api().columns().every( function (key) {
				var column = this;
				console.log(column[0]);	
			
				if(column[0] == 2 || column[0] == 3 ||  column[0] == 6 || column[0] == 7 ){
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
	
	
	if(user_type=='Center') {
		var column = registration_datatable.column(2);
		column.visible( ! column.visible() );
	}
	
	
	//autosuggest
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		}
	});
	

	
	getQualificationDetails = function getQualificationDetails(id){
		$.ajax({
			url: url+'/qualification/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['qualification'];
				$('#registration_fees').val(data['registration_fees']);

			}
		});
	}

	$("#qualification_title").autocomplete({ 
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/qualifications-autosuggest/Center',
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
			getQualificationDetails(id);
		}
	});
	

	getLearnerDetails = function getLearnerDetails(id){
		$.ajax({
			url: url+'/learner/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['learner'];
				
				if (data["user_profile_image"]!=null && data["user_profile_image"]!="") { 
					var photo ='<img src="'+learner_image_url+'/'+data["user_profile_image"]+'" alt="Learner Image" class="img img-responsive grid_profile_photo">'; 
				}
				else{
					var photo ='<img src="'+learner_image_url+'/no-user-image.png" alt="Learner Image" class="img img-responsive grid_profile_photo">';
				}
				
				
				var trHtml = "<tr>"+"<td><input type='hidden' name='learner_ids[]' value='"+data['id']+"' />"+photo+"</td>"+"<td>"+data['id']+"</td>"+"<td>"+data['first_name']+" </td><td>"+data['last_name']+"</td>"+"<td>"+data['email']+"</td>"+"<td>"+data['contact_no']+"</td>"+"<td><button onclick='$(this).parent().parent().remove(); remove_learner_from_total();' class='btn btn-xs btn-danger'><i class='clip-close'></i></button></td>"+"</tr>";
				$('#learner_table').append(trHtml);
			}
		});
	}
	
	remove_learner_from_total = function remove_learner_from_total(){
		var total_prev_learner = parseFloat($('#total_learner').html());
		$('#total_learner').html(total_prev_learner-1);
	}
	
	$("#learner_name").autocomplete({ 
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/learner-autosuggest',
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
			$("#learner_name").val("");
			var callGetQualificationDetails =1;
			if($("[name='learner_ids[]']").length>0){
				$("[name='learner_ids[]']").each(function(){
					if($(this).val() == id) callGetQualificationDetails =0
				})
			}
			if(callGetQualificationDetails)	getLearnerDetails(id);
			$('#total_learner').html(($("[name='learner_ids[]']").length)+1);
		},
		close: function( event, ui ) {
			$("#learner_name").trigger("click");
		}
	});

	$("#learner_name").on('click',function(){
		$(this).val("");
	});


	//Entry And Update Function For Module
	$("#save_registration").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		var formData = new FormData($('#registration_form')[0]);	
		if($.trim($('#qualification_id').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please select a qualification","#qualification_id");
		}
		else{
			$.ajax({
				url: url+"/registration",
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
						success_or_error_msg('#master_message_div',"danger",resultHtml);
					}
					else{
						$("#admin_user_list_button").trigger('click');
						success_or_error_msg('#master_message_div',"success",response['message']);
						registration_datatable.ajax.reload();
						clear_form();
						$("#clear_button").show();
						$("#save_registration").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
		$('#learner_table tr:gt(0)').remove();
		if(user_type=='Admin') $('#admin_user_add_button').hide();
	});
	
	$("#admin_user_list_button, #cancel_button").on('click',function(){
		clear_form();
		$("#clear_button").show();
		$('#learner_table tr:gt(0)').remove();
		$("#save_registration").html('Save');
		$("#admin_user_add_button").html("<b> Add Registration</b>");
		$('#result_button').hide();	
		if(user_type=='Admin') $('#admin_user_add_button').hide();
	});
	
	//Registration detail View
	registrationView = function registrationView(id){	
		$.ajax({
			url: url+'/registration/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['registration'];
				var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
				 
				if(data['approval_status']=="Initiated"){
					approveStatusHtml = '<span class="badge badge-warning">Initiated</span>';
				}
				else if(data['approval_status']=="Requested"){
					approveStatusHtml = '<span class="badge badge-info">Requested</span>';
				}
				else if(data['approval_status']=="Approved"){
					approveStatusHtml = '<span class="badge badge-success">Approved</span>';
				}
				else{
					approveStatusHtml = '<span class="badge badge-danger">Rejected</span>';
				}
				
				if(data['payment_status']=="Due"){
					paymentStatusHtml = '<span class="badge badge-danger">Due</span>';
				}
				else if(data['payment_status']=="Paid"){
					paymentStatusHtml = '<span class="badge badge-success">Requested</span>';
				}
				else if(data['payment_status']=="Partial"){
					paymentStatusHtml = '<span class="badge badge-warning">Approved</span>';
				}

				var remarks = (data['remarks'])?data['remarks']:"&nbsp;";				
				var center_registration_date = (data['center_registration_date'])?data['center_registration_date']:"&nbsp;";		
				var ed_registration_date 	= (data['ep_registration_date'])?data['ep_registration_date']:"&nbsp;";	
			
				var modalHtml  ="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Registration No. :</strong></div>"+"		<div class='col-lg-9 col-md-8'>"+data['registration_no']+		"</div></div>";
					if (data['invoice_no'])
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Invoice No. :</strong></div>"+"			<div class='col-lg-9 col-md-8'>"+data['invoice_no']+			"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Registration Status :</strong></div>"+"	<div class='col-lg-9 col-md-8'>"+approveStatusHtml+				"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Qualification Title :</strong></div>"+"	<div class='col-lg-9 col-md-8'>"+data['qualification']['title']+"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>No of units :</strong></div>"+"			<div class='col-lg-9 col-md-8'>"+data['qualification']['units'].length+"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Centre Name :</strong></div>"+"			<div class='col-lg-9 col-md-8'>"+data['center']['name']+		"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Registration Fee :</strong></div>"+"		<div class='col-lg-9 col-md-8'>£"+data['registration_fees']+		"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Payment Status :</strong></div>"+"		 <div class='col-lg-9 col-md-8'>"+paymentStatusHtml+			"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Center Registration Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+center_registration_date+	"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Approval date :</strong></div>"+"			<div class='col-lg-9 col-md-8'>"+ed_registration_date+			"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"				<div class='col-lg-9 col-md-8'>"+statusHtml+					"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Remarks:</strong></div>"+"				<div class='col-lg-9 col-md-8'>"+remarks+						"</div></div>";
					modalHtml +="<div class='col-lg-12 margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Total Learners:</strong></div>"+"			<div class='col-lg-9 col-md-8'>"+data['learners'].length+		"</div></div>";

				modalHtml +="<div class='col-lg-12 '>&nbsp;<br><div class='col-lg-12'><strong>Learner Details :</strong></div>"+"<div class='col-lg-12'>";
				modalHtml +="<table class='table table-bordered table-hover ' style='width:100% !important'> <thead><tr><th></th><th class='text-center'>Registration No.</th><th>First Name </th><th>Last Name </th><th>Email</th><th>Contact No.</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['learners'])){
					var trHtml = "";
					$.each(data['learners'], function(i,data){						
						if (data["user_profile_image"]!=null && data["user_profile_image"]!="") { 
							var photo ='<img src="'+learner_image_url+'/'+data["user_profile_image"]+'" alt="Learner Image" class="img img-responsive grid_profile_photo">'; 
						}
						else{
							var photo ='<img src="'+learner_image_url+'/no-user-image.png" alt="Learner Image" class="img img-responsive grid_profile_photo">';
						}
						modalHtml 	+= "<tr><td>"+photo+"</td>"+"<td class='text-center'>"+zeroPad(data['pivot']['id'], 6)+"</td>"+"<td>"+data['first_name']+"<td>"+data['last_name']+"</td>"+"<td>"+data['email']+"</td>"+"<td>"+data['contact_no']+"</td>"+"</tr>";
					})
				}
				 modalHtml += "</tbody></table></div></div>";
				
				$('#myModalLabelLg').html("Registration details of #"+data['registration_no']);
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
	printWindow =  function printWindow() {
		window.print();
	}	
	//Invoice View
	showInvoice = function showInvoice(id){	
		$.ajax({
			url: url+'/registration/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['registration'];
				var total_fees 	= (parseFloat(data['registration_fees'])*parseFloat(data['learners'].length));	
				var ep_registration_date = (data['ep_registration_date'])?data['ep_registration_date']:"&nbsp;";
				
				var modalHtml   ="<div class='col-lg-12 '><div class='col-lg-6 text-left'><image src='"+logo_url+"' /></div>"+"<div class='col-lg-6 text-right'><h3>Invoice</h3><h5>Edupro Limited</h5><p>Edupro Limited is registered in Englang No. 10475324</p></div></div>";
					modalHtml  +="<div class='col-lg-12 padding-top-bottom-20 '><div class='col-lg-8 text-left'><p>To</p><p><strong>"+data['center']['name']+"</strong></p><p>"+data['center']['address']+"</p><p>Email: "+data['center']['email']+"</p><p>Phone: "+data['center']['mobile_no']+"</p></div>"+"<div class='col-lg-4 text-right'><p>Invoice No.</p><p>"+data['invoice_no']+"</p></div></div>";
					modalHtml  +="<div class='col-lg-12 padding-top-bottom-20 '><div class='col-lg-8 text-left'><p><strong>Qualification Title: "+data['qualification']['title']+"</strong></p><p><strong>Center Registration Date: "+data['center_registration_date']+"</strong></p><p><strong>Edupro Registration Date: "+ep_registration_date+"</strong></p></div></div>";
					modalHtml  +="<table class='table' style='width:100% !important'> <thead><tr><th class='text-center'>No of Learners</th><th class='text-center'>Registration Fee </th><th class='text-center'>Total Fees</th></tr></thead><tbody>";
					modalHtml  +="<tr><td class='text-center'>"+data['learners'].length+"</td><td  class='text-center'>£"+data['registration_fees']+"</td><td class='text-center'>£"+total_fees+"</td></tr></table>";
					modalHtml  +="<div class='col-lg-12 '><div class='col-lg-6 text-left'><br><p>Make payment in favour of 'Edupro Ltd.'</p></div></div>";
				
				$('#myModalLabel').html("Invoice #"+data['invoice_no']);
				$('#modalBody').html(modalHtml);
				$('.print-button').show()
				$("#generic_modal").modal();				
			}
		});
	}
	
	//Edit function for Module
	registrationEdit = function registrationEdit(id){
		var edit_id = id;
		$("#clear_button").trigger('click');
		if(user_type=='Admin') $('#admin_user_add_button').show();
		$("#admin_user_add_button").html("<b> Edit Registration</b>");
		$("#admin_user_add_button").trigger('click');
		
		$.ajax({
			url: url+'/registration/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['registration'];
				
				
				$("#admin_user_add_button").trigger('click');
				
				$("#save_registration").html('Update');
				$("#clear_button").hide();
				
				$("#registration_no").val(data['registration_no']);
				$("#qualification_id").val(data['qualification_id']);
				$("#qualification_title").val(data['qualification']['title']);
				$("#registration_fees").val(data['registration_fees']);
				
				$("#remarks").val((data['remarks'])?data['remarks']:"");
				$("#payment_status").val(data['payment_status']);
				$("#approval_status").val(data['approval_status']);
							
				$("#edit_id").val(data['id']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				
				if(!jQuery.isEmptyObject(data['learners'])){
					var trHtml = "";
					$.each(data['learners'], function(i,data){  
						if (data["user_profile_image"]!=null && data["user_profile_image"]!="") { 
							var photo ='<img src="'+learner_image_url+'/'+data["user_profile_image"]+'" alt="Learner Image" class="img img-responsive grid_profile_photo">'; 
						}
						else{
							var photo ='<img src="'+learner_image_url+'/no-user-image.png" alt="Learner Image" class="img img-responsive grid_profile_photo">';
						}						
						trHtml 	+= "<tr><td><input type='hidden' name='learner_ids[]' value='"+data['id']+"' />"+photo+"</td>"+"<td>"+data['id']+"</td>"+"<td >"+data['first_name']+"</td ><td > "+data['last_name']+"</td>"+"<td>"+data['email']+"</td>"+"<td>"+data['contact_no']+"</td>"+"<td><button onclick='$(this).parent().parent().remove();remove_learner_from_total();' class='btn btn-xs btn-danger'><i class='clip-close'></i></button></td></tr>";
					})
					$('#learner_table').append(trHtml);
					$('#total_learner').html(($("[name='learner_ids[]']").length));
				}	
			}
		});
	}

	//Delete Module
	registrationDelete = function registrationDelete(id){
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
					url: url+'/registration/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							success_or_error_msg('#master_message_div',"danger",response['errors']);
						}
						else{
							success_or_error_msg('#master_message_div',"success",response['message']);
							registration_datatable.ajax.reload();
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

	setResut = function setResut(id){	
		$('#result_button').show();
		$("#result_button").trigger('click');	
		$.ajax({
			url: url+'/transcript/'+id,
			cache: false,
			success: function(response){
				$('#result_div').html(response);
				$('#result_form').iCheck({
					checkboxClass: 'icheckbox_flat-green',
				});
				//Entry And Update Function For Module
				$("#save_result").on('click',function(){
					event.preventDefault();
					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
						}
					});
					var formData = new FormData($('#result_form')[0]);	
					$.ajax({
						url: url+"/transcript",
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
								success_or_error_msg('#master_message_div',"danger",resultHtml);
							}
							else{
								$("#admin_user_list_button").trigger('click');
								success_or_error_msg('#master_message_div',"success",response['message']);
								registration_datatable.ajax.reload();
								clear_form();
								$("#clear_button").show();
								$("#save_registration").html('Save');
							}
							$(window).scrollTop();
						 }
					});		
				});
	
				
				$("#claim_certificate").on('click',function(){
					var claimLearners = "";
					$("[name='claimLearners[]']" ).each(function(){
						if($(this).is(':checked')){
							claimLearners += $(this).val()+",";
						}
                    })
					if(claimLearners == ""){
						success_or_error_msg('#master_message_div',"danger","Please select minimum one row");
						return false;
					}
					swal({
						title: "Are you sure?",
						text: "You will not be able to update the result anymore!",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					}).then((willDelete) => {
						if (willDelete) {
							$.ajax({
								url: url+'/claim-certificate/'+claimLearners,
								cache: false,
								success: function(data){
									var response = JSON.parse(data);
									if(response['response_code'] == 0){
										success_or_error_msg('#master_message_div',"danger",response['errors']);
									}
									else{
										success_or_error_msg('#master_message_div',"success",response['message']);
										$("#admin_user_list_button").trigger('click');
										clear_form();
										$("#clear_button").show();
										$("#save_registration").html('Save');
									}
								}
							});
						}
						else {
							swal("Kepp update the result sheet, and submit once confirmed!", {
							icon: "warning",
							});
						}
					});
				});				
			}
		});
	}


	//for show registrations list
	certificate_table = $('#certificate_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/certificates",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'center_name'},			
			{ mData: 'registration_no'},
			{ mData: 'invoice_no' },			
			{ mData: 'qualification_title'},
			{ mData: 'learner_name'},
			{ mData: 'result',  className: "text-center"},			
			{ mData: 'certificate_no', className: "text-center"},
			{ mData: 'print_status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			/*{ "width": "130px", "targets":[ 9 ]},*/
        ],
	});


	//Registration detail View
	certificateView = function certificateView(id){	
		certificateId = id;
		$.ajax({
			url: url+'/certificate/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['certificateLearner'];
				var certificate_no = (data['certificate_no'])?data['certificate_no']:"&nbsp;";			
				var modalHtml  ="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Registration No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+zeroPad(data['id'], 6)+"</div></div>";
					modalHtml +="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Learner Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['learner']['first_name']+" "+data['learner']['last_name']+"</div></div>";
					modalHtml +="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Qualification Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['registration']['qualification']['title']+"</div></div>";
					modalHtml +="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Centre name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['registration']['center']['name']+"</div></div>";
					modalHtml +="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Certificate No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+certificate_no+"</div></div>";
					modalHtml +="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Print Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['is_printd']+"</div></div>";

				modalHtml +="<div class='col-lg-12 '>&nbsp;<br><div class='col-lg-12'><strong>Transcript Details :</strong></div>"+"<div class='col-lg-12'>";
				modalHtml +="<table class='table table-bordered table-hover ' style='width:100% !important'> <thead><tr><th>Unit Code</th><th>Unit Name</th><th class='text-center'>GLH</th><th class='text-center'>Result</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['results'])){
					var trHtml = "";
					$.each(data['results'], function(i,data){  
						modalHtml 	+= "<tr><td>"+data['unit']['unit_code']+"</td>"+"<td>"+data['unit']['name']+"</td>"+"<td class='text-center'>"+data['unit']['glh']+"</td>"+"<td class='text-center'>"+data['result']+"</td>"+"</tr>";
					})
				}
				 modalHtml += "</tbody></table></div></div>";
				
				$('#myModalLabelLg').html("Certificate details of #"+data['learner']['first_name']+" "+data['learner']['last_name']);
				$('#modalBodyLg').html(modalHtml);
				if(user_type=='Admin'){
					$('#print-button-c').show();
					$('#print-button-t').show();
				}
				$("#generic_modal_lg").modal();				
			}
		});
	}
	
	certificateEdit = function certificateEdit(id){	
		$('#save_certificate_button').show();
		$('#save_certificate_button').trigger('click');
		
		$.ajax({
			url: url+'/certificate/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['certificateLearner'];
				$('#edit_id').val(data['id']);
				var certificate_no = (data['certificate_no'])?data['certificate_no']:"&nbsp;";	
				var html  ="<div class='col-lg-8 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Registration No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+zeroPad(data['id'], 6)+"</div></div>";
					html +="<div class='col-lg-10 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Learner Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['learner']['first_name']+" "+data['learner']['first_name']+"</div></div>";
					html +="<div class='col-lg-10 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Qualification Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['registration']['qualification']['title']+"</div></div>";
					html +="<div class='col-lg-10 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Centre name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['registration']['center']['name']+"</div></div>";
					html +="<div class='col-lg-10 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Certificate No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+certificate_no+"</div></div>";
					html +="<div class='col-lg-10 margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Print Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['is_printd']+"</div></div>";

				html +="<div class='col-lg-12 '>&nbsp;<br><div class='col-lg-12'><strong>Transcript Details :</strong></div>"+"<div class='col-lg-12'>";
				html +="<table class='table table-bordered table-hover ' style='width:100% !important'> <thead><tr><th>Unit Code</th><th>Unit Name</th><th class='text-center'>GLH</th><th class='text-center'>Result</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['results'])){
					var trHtml = "";
					$.each(data['results'], function(i,data){  
						html 	+= "<tr><td>"+data['unit']['unit_code']+"</td>"+"<td>"+data['unit']['name']+"</td>"+"<td class='text-center'>"+data['unit']['glh']+"</td>"+"<td class='text-center'><strong>"+data['result']+"</strong></td>"+"</tr>";
					})
				}
				html += "</tbody></table></div></div>";
				$('#result_div').html(html);
				$("#admin_user_add_button").trigger('click');
			}
		});
	}	
	
	printCertificate =  function printCertificate() {
		var responseCertificate= "";
		$.ajax({
			url: url+'/certificate/'+certificateId+'/print',
			cache: false,
			success: function(response){
				responseCertificate = response;
				$('#modalBodyLg').html(response);
				window.print();	
			}
		});
		/*alert('1')
		var printWindow = window.open('', '', 'height=800,width=800');
		printWindow.document.write('<html><head><title>Certificate Print</title>');
		printWindow.document.write('</head><body style="padding:10px">');
		printWindow.document.write('<link href="'+plugin_url+'/bootstrap/css/bootstrap.min.css" rel="stylesheet">');
		printWindow.document.write(responseCertificate);
		printWindow.document.write('</body></html>');
		printWindow.document.close();*
		//printWindow.print();*/
	}
	
	printTranscript =  function printTranscript() {
		var responseTranscript= "";
		$.ajax({
			url: url+'/certificate/'+certificateId+'/transcript-print',
			cache: false,
			success: function(response){
				responseTranscript = response;
				$('#modalBodyLg').html(response);
				window.print();	
			}
		});
		/*alert('1')
		var printWindow = window.open('', '', 'height=800,width=800');
		printWindow.document.write('<html><head><title>Certificate Print</title>');
		printWindow.document.write('</head><body style="padding:10px">');
		printWindow.document.write('<link href="'+plugin_url+'/bootstrap/css/bootstrap.min.css" rel="stylesheet">');
		printWindow.document.write(responseCertificate);
		printWindow.document.write('</body></html>');
		printWindow.document.close();*
		//printWindow.print();*/
	}
	
	
	$("#certificate_list_button").on('click',function(){
		$('#save_certificate_button').hide();
		$('#edit_id').val("");
		$('#certificate_no').val("");
		$('#result_div').html("");	
	});
	
	$("#save_certificate").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		var formData = new FormData($('#certificate_form')[0]);	
		if($.trim($('#certificate_no').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter certificate no","#certificate_no");
		}
		else{
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
						success_or_error_msg('#master_message_div',"danger",resultHtml);
					}
					else{
						$("#admin_user_list_button").trigger('click');
						success_or_error_msg('#master_message_div',"success",response['message']);
						certificate_table.ajax.reload();
						$("#certificate_list_button").trigger("click");
					}
				 }
			});
		}
	});
	
	
});

