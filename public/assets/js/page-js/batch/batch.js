// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	// icheck for the inputs
	$('#batch_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});


	batchAdd = function batchAdd(){
		$('#unit_table tr:gt(0)').remove();
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Batch');
		$("#save_unit").html('Save');	
		$('#entry-form').modal('show');
	}

	batch_datatable = $('#batches_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/batches",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'batch_name'},
			{ mData: 'course_name' },
			{ mData: 'start_date', className: "text-center"},
			{ mData: 'end_date', className: "text-center"},			
			{ mData: 'student_limit', className: "text-center"},
			{ mData: 'total_enrolled_student', className: "text-center"},
			{ mData: 'running_status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "80px", "targets":[ 8 ]},
        ],
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
	
	var installment_plan =1;	

	planAdd = function planAdd(){
		installment_plan++;
		$("#plan_table>tbody").append("<tr class='table-active'><td><input type='text' name='plan_name[]'  class='form-control col-lg-12'/></td><td class='text-center'><input type='text'  name='total_installment[]' class='form-control col-lg-10'/></td><td class='text-center'><input type='text' name='installment_duration[]' class='form-control col-lg-10'/></td><td class='text-center'><input type='text' name='payable_amount[]' class='form-control col-lg-10'/></td></tr><tr><td colspan='2' class='text-right'><b>Installment Details</b></td><td colspan='2'><table class='table table-bordered table-sm installment_table' style='width:100% !important' id='"+installment_plan+"'> <thead class='thead-light'><tr><th>Inst. No</th><th>Amount</th><th><button type='button'  title='Add Installment' data-placement='bottom' class='btn-shadow mr-3 btn btn-primary btn-sm add_installment_row'><i class='fa fa-plus'></i></button></th></tr></thead><tbody></tbody></table></td></tr>");
		
		$("#"+installment_plan+">tbody").append("<tr><td class='text-center'><input type='text' name='installment_no["+installment_plan+"][]' class='form-control col-lg-10 input-sm'/></td><td class='text-center'><input type='text' name='installment_amount["+installment_plan+"][]'  class='form-control col-lg-10 input-sm'/></td><td><button type='button' title='Remove Installment' data-placement='bottom' class='btn-shadow mr-3 btn btn-danger btn-sm remove_installment_row'><i class='fa fa-trash'></i></button></td></tr>");


		$(".add_installment_row").on('click',function(){			
			var id = $(this).closest('table').attr('id');
			alert(id)
			$("#"+id+">tbody").append("<tr><td class='text-center'><input type='text'  name='installment_no["+id+"][]'  class='form-control col-lg-10 input-sm'/></td><td class='text-center'><input type='text'  name='installment_amount["+id+"][]'  class='form-control col-lg-10 input-sm'/></td><td><button type='button'  title='Remove Installment' data-placement='bottom' class='btn-shadow mr-3 btn btn-danger btn-sm remove_installment_row' onclick='$(this).parent().parent().remove()'><i class='fa fa-trash'></i></button></td></tr>");
		});
	

	}


	calculateTotalUnit = function calculateTotalUnit(glh, tch, tqt){
		var total_glh = parseFloat($('#glh').val())-parseFloat(glh);
		$('#glh').val(total_glh);
		var total_ch = parseFloat($('#total_credit_hour').val())-parseFloat(tch);
		$('#total_credit_hour').val(total_ch)
		var total_tqt = parseFloat($('#tqt').val())-parseFloat(tqt);
		$('#tqt').val(total_tqt);	
	}
	
	getUnitDetails = function getUnitDetails(id){
		$.ajax({
			url: url+'/unit/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['unit'];
				var trHtml = "<tr>"+"<td><input type='hidden' name='unit_ids[]' value='"+data['id']+"' />"+data['unit_code']+"</td>"+"<td>"+data['name']+"</td>"+"<td>"+data['glh']+"</td>"+"<td>"+data['tut']+"</td>"+"<td><select name='type[]' class='form-control col-lg-12'><option value='Optional'>Optional</option><option value='Mandatory'>Mandatory</option></select></td>"+"<td>"+data['assessment_type']+"</td>"+"<td><button onclick='$(this).parent().parent().remove(); calculateTotalUnit("+data['glh']+","+data['credit_hour']+","+data['tut']+")' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button></td>"+"</tr>";
				var total_glh = parseFloat($('#glh').val())+parseFloat(data['glh']);
				$('#glh').val(total_glh);
				var total_ch = parseFloat($('#total_credit_hour').val())+parseFloat(data['credit_hour']);
				$('#total_credit_hour').val(total_ch)
				var total_tqt = parseFloat($('#tqt').val())+parseFloat(data['tut']);
				$('#tqt').val(total_tqt);
				$('#unit_table').append(trHtml);
			}
		});
	}


	$("#unit_name").autocomplete({ 
		search: function() {
		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/units-autosuggest',
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
			$("#unit_name").val("");
			var callGetUnitDetails =1;
			if($("[name='unit_ids[]']").length>0){
				$("[name='unit_ids[]']").each(function(){
					if($(this).val() == id) callGetUnitDetails =0
				})
			}
			if(callGetUnitDetails)	getUnitDetails(id);
		},
		close: function( event, ui ) {
			$("#unit_name").trigger("click");
		}
	});

	$("#unit_name").on('click',function(){
		$(this).val("");
	});

	//Entry And Update Function For Module
	$("#save_batch").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#batch_form')[0]);

		if($.trim($('#code').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Batch code","#code");
		}
		else if($.trim($('#title').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter batch name","#title");
		}
		else if($.trim($('#tqt').val()) == "" || !($.isNumeric($('#tqt').val()))){
			success_or_error_msg('#form_submit_error','danger',"Please enter TQT","#tqt");
		}
		else if($.trim($('#total_credit_hour').val()) == "" || !($.isNumeric($('#total_credit_hour').val()))){
			success_or_error_msg('#form_submit_error','danger',"Please enter total credit hour","#total_credit_hour");
		}
		else if(parseFloat($('#glh').val()) > parseFloat($('#tqt').val())){
			success_or_error_msg('#form_submit_error','danger',"TQT cannot less than GLH","#tqt");
		}
		else if($.trim($('#registration_fees').val()) == "" || !($.isNumeric($('#registration_fees').val()))){
			success_or_error_msg('#form_submit_error','danger',"Please enter registration fees","#registration_fees");
		}
		else{
			$.ajax({
				url: url+"/batch",
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
						toastr['success']( 'Batch Saved Successfully', 'Success!!!');
						$('.modal').modal('hide')
					
						batch_datatable.ajax.reload();
						clear_form();
						$('#unit_table tr:gt(0)').remove();
						$("#save_batch").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
		$('#unit_table tr:gt(0)').remove();
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

				var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch Code :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['code']+"</div></div>";
					modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['title']+"</div></div>";
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
		
	//Edit function for Module
	batchEdit = function batchEdit(id){
		var edit_id = id;
		$('#unit_table tr:gt(0)').remove();
		$("#admin_user_add_button").html("<b> Edit Batch</b>");
		
		$.ajax({
			url: url+'/batch/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['batch'];				
				$("#save_batch").html('Update');
				$("#short_name").val(data['short_name']);
				$("#trainers").val(data['trainers']);
				$("#code").val(data['code']);
				$("#title").val(data['title']);
				$("#tqt").val(data['tqt']);
				$("#total_credit_hour").val(data['total_credit_hour']);
				$("#level_id").val(data['level_id']);
				$("#registration_fees").val(data['registration_fees']);
				$("#edit_id").val(data['id']);
				$("#awarder_by").val(data['awarder_by']);
				$("#programme_duration").val(data['programme_duration']);
				$("#semester_no").val(data['semester_no']);
				$("#glh").val(data['glh']);
				$("#study_mode").val(data['study_mode']);
				$("#youtube_video_link").val(data['youtube_video_link']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				editors.objective.setData(data['objective']);
				editors.accredited_by.setData(data['accredited_by']);
				editors.semester_details.setData(data['semester_details']);
				editors.assessment.setData(data['assessment']);
				editors.grading_system.setData(data['grading_system']);
				editors.requirements.setData(data['requirements']);
				editors.experience_required.setData(data['experience_required']);

				var photo = (data["batch_profile_image"]!=null && data["batch_profile_image"]!="")?data["batch_profile_image"]:'no-user-image.png';
				$("#batch_image").attr("src", batch_profile_image+"/"+photo);

				if(!jQuery.isEmptyObject(data['units'])){
					var trHtml = "";
					var tota_glh =0;
					$.each(data['units'], function(i,data){ 
						var typeOption = (data['pivot']['type'] =='Optional')?"<option selected value='Optional'>Optional</option><option value='Mandatory'>Mandatory</option>":"<option value='Optional'>Optional</option><option selected value='Mandatory'>Mandatory</option>";				
						trHtml 	+= "<tr>"+"<td><input type='hidden' name='unit_ids[]' value='"+data['id']+"' />"+data['unit_code']+"</td>"+"<td>"+data['name']+"</td>"+"<td>"+data['glh']+"<td>"+data['tut']+"</td>"+"</td>"+"<td><select name='type[]' class='form-control col-lg-12'>"+typeOption+"</select></td>"+"<td>"+data['assessment_type']+"</td>"+"<td><button onclick='$(this).parent().parent().remove();  calculateTotalUnit("+data['glh']+","+data['credit_hour']+","+data['tut']+")' ' class='btn btn-xs btn-hover-shine btn-danger'><i class='fa fa-trash'></i></button></td>"+"</tr>";
						tota_glh += parseFloat(data['glh']);
					})
					$('#glh').val(tota_glh)
					$('#unit_table').append(trHtml);
				}	
				$('#entry-form').modal('show');
			}
		});
	}

	//Delete Module
	batchDelete = function batchDelete(id){
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
					url: url+'/batch/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							success_or_error_msg('#form_submit_error',"danger",response['errors']);
						}
						else{
							success_or_error_msg('#form_submit_error',"success",response['message']);
							batch_datatable.ajax.reload();
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

