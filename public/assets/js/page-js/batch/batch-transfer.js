// All the Setting related js functions will be here
$(document).ready(function () {
	//batch transfer

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
			if($('#course_id').val()!="")
			getCurrentBatch();
		},
	});
	$("#student_name").on('click',function(){ 
		$('#from_batch_name').val('');
		$('#from_batch_id').val('');
		$('#to_batch_name').val('');
		$('#to_batch_id').val('');
		$(this).val("");
		$(this).next().val("");
	});

	getCurrentBatch = function getCurrentBatch(){	
		if($.trim($('#student_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select student","#student_name");
		}
		else if($.trim($('#course_name').val()) == "" || $.trim($('#course_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter course name","#course_name");
		}
		else{
			let student_id = $('#student_id').val();
			let course_id = $('#course_id').val();
			$.ajax({
				url: url+'/batch-current/'+course_id+'/'+student_id,
				cache: false,
				type:'post',
				success: function(batch){	
					if(!jQuery.isEmptyObject(batch)){
						$('#from_batch_name').val(batch['batch_no']);
						$('#from_batch_id').val(batch['batch_student_id']);
					}
				}
			});
		}
	}
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
			if($('#student_id').val()!="")
				getCurrentBatch();
		},
	});

	$("#course_name").on('click',function(){ 
		$('#from_batch_name').val('');
		$('#from_batch_id').val('');
		$('#to_batch_name').val('');
		$('#to_batch_id').val('');
		$(this).val("");
		$(this).next().val("");
	});

	$("#to_batch_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/batch-autosuggest/'+$('#course_id').val(),
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
		minLength: 1,
		select: function(event, ui) {
			var id = ui.item.id;
			$(this).next().val(id);
		},
	});
	$("#to_batch_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
	});
	
	transfer_datatable = $('#transfer_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/batch-transfers",
		"aoColumns": [ 
			{ mData: 'id'}, 
			{ mData: 'student_name'},
			{ mData: 'course_name' },
			{ mData: 'from_batch_name' , className: "text-center"}, 
			{ mData: 'to_batch_name', className: "text-center"},
			{ mData: 'transfer_date', className: "text-center"},
			{ mData: 'fee', className: "text-right"},	
			{ mData: 'status', className: "text-center"},	
			{ mData: 'actions' , className: "text-center"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "50px", "targets":[ 8 ]},
        ],
	});

	transferAdd = function transferAdd(){
		installment_plan=1;
		$("#clear_button").trigger('click');
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Transfer');
		$("#save_batch").html('Save');	
		$('#entry-form').modal('show');
	}
	
	//Entry And Update Function For Module
	$("#save_transfer").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#transfer_form')[0]);

		if($.trim($('#student_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select student","#student_name");
		}
		else if($.trim($('#course_name').val()) == "" || $.trim($('#course_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter course name","#course_name");
		}
		else if($.trim($('#from_batch_name').val()) == ""){  
			success_or_error_msg('#form_submit_error','danger',"Please select student and course properly","#from_batch_name");
		}
		else if($.trim($('#to_batch_name').val()) == "" || $.trim($('#to_batch_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select to batch","#to_batch_name");
		}
		else if($.trim($('#from_batch_name').val()) == $.trim($('#to_batch_name').val())){  
			success_or_error_msg('#form_submit_error','danger',"Please select select different batch","#to_batch_name");
		}
		else if($.trim($('#transfer_fee').val()) == "" || !($.isNumeric($('#transfer_fee').val())) || $('#transfer_fee').val()<0){
			success_or_error_msg('#form_submit_error','danger',"Please enter fees properly","#transfer_fee");
		}
		else{
			$.ajax({
				url: url+"/batch-transfer",
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
						toastr['success']( 'Batch transfer Saved Successfully', 'Success!!!');
						$('.modal').modal('hide');					
						transfer_datatable.ajax.reload();
						clear_form();
						$("#save_transfer").html('Save');
					}
					$(window).scrollTop();
				}
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
	});
	
	//transfer detail View
	transferView = function transferView(id){	
		$.ajax({
			url: url+'/batch-transfer/'+id,
			cache: false,
			success: function(response){
				var response 	= JSON.parse(response);
				var data 		= response['trasferedStudent'];

				var statusHtml 	= (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
				var modalHtml  = "";
				
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_name']+"</div></div>";

				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['course_name']+"</div></div>";

				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>From Batch :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['from_batch_name']+"</div></div>";

				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>To Batch :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['to_batch_name']+"</div></div>";

				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Transfer Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['transfer_date']+"</div></div>";

				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Transfer Fee :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['fee']+"Tk.</div></div>";					
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong> Details :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['remarks']+"</div></div>";
				
				modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";

				modalHtml += "</tbody></table></div></div>";
				$('#myModalLabelLg').html('Batch transfer Details');
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}

});

