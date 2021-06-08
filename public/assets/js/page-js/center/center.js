// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	// icheck for the inputs
	$('#center_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});


	//for show centers list
	 center_datatable = $('#centers_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/centers",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'code'},
			{ mData: 'name' },
			{ mData: 'proprietor_name'},			
			{ mData: 'mobile_no'},
			{ mData: 'email'},
			{ mData: 'liaison_office'},
			{ mData: 'total_qualification', className: "text-center"},
			{ mData: 'approval_status', className: "text-center"},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-left"},
		],
		"columnDefs": [
            { "targets": [ 0 ], "visible": false},
			{ "width": "130px", "targets":[ 10 ]},
        ],
		"fixedColumns": true
		
	});
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
				var trHtml = "<tr>"+"<td><input type='hidden' name='qualification_ids[]' value='"+data['id']+"' />"+data['code']+"</td>"+"<td>"+data['title']+"</td>"+"<td class='text-center'>"+data['level']['name']+"</td>"+"<td class='text-center'>"+data['tqt']+"</td>"+"<td class='text-center'>"+data['units'].length+"</td>"+"<td><button onclick='$(this).parent().parent().remove();' class='btn btn-xs btn-danger'><i class='clip-close'></i></button></td>"+"</tr>";
				$('#qualification_table').append(trHtml);
			}
		});
	}
	
	$("#qualification_name").autocomplete({ 
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/qualifications-autosuggest/Admin',
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
			$("#qualification_name").val("");
			var callGetQualificationDetails =1;
			if($("[name='qualification_ids[]']").length>0){
				$("[name='qualification_ids[]']").each(function(){
					if($(this).val() == id) callGetQualificationDetails =0
				})
			}
			if(callGetQualificationDetails)	getQualificationDetails(id);
		},
		close: function( event, ui ) {
			$("#qualification_name").trigger("click");
		}
	});

	$("#qualification_name").on('click',function(){
		$(this).val("");
	});

	//Entry And Update Function For Module
	$("#save_center").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		var formData = new FormData($('#center_form')[0]);	
		if($.trim($('#code').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please Insert Centre code","#code");
		}
		else if($.trim($('#name').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter Centre name","#name");
		}
		else if($.trim($('#short_name').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter short name/username","#short_name");
		}
		else if($.trim($('#address').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter address","#address");
		}
		else if($.trim($('#mobile_no').val()) == "" || !($.isNumeric($('#mobile_no').val()))){
			success_or_error_msg('#master_message_div','danger',"Please enter a valid mobile no","#mobile_no");
		}
		else if($.trim($('#liaison_office').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter Liaision Officer","#liaison_office");
		}else if($.trim($('#email').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter email","#email");
		} 
		else{
			$.ajax({
				url: url+"/center",
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
						center_datatable.ajax.reload();
						clear_form();
						$("#clear_button").show();
						$("#save_center").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
		$('#qualification_table tr:gt(0)').remove();
	});
	
	$("#admin_user_list_button, #cancel_button").on('click',function(){
		clear_form();
		$("#clear_button").show();
		$('#qualification_table tr:gt(0)').remove();
		$("#save_center").html('Save');
		$("#admin_user_add_button").html("<b> Add Center</b>");
	});
	
	//Center detail View
	 centerView = function centerView(id){	
		$.ajax({
			url: url+'/center/'+id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['center'];
				var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
				 
				if(data['approval_status']=="Approved"){
					approveStatusHtml = '<span class="badge badge-success">Approved</span>';
				}
				else if(data['approval_status']=="Pending"){
					approveStatusHtml = '<span class="badge badge-warning">Pending</span>';
				}
				else{
					approveStatusHtml = '<span class="badge badge-danger">Rejected</span>';
				}

				var date_of_approval 	= (data['date_of_approval'] && data['date_of_approval']!="null")?data['date_of_approval']:"&nbsp;";		
				var date_of_review 		= (data['date_of_review'] && data['date_of_review']!="null")?data['date_of_review']:"&nbsp;";	
				var website = (data['website'] && data['website']!="null")?data['website']:"&nbsp;";	
				
				var modalHtml  ="<div class='col-lg-6 margin-top-5'><div class='col-md-6 '><strong>Centre Code :</strong></div>"+"<div class=' col-md-6'>"+data['code']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'>&nbsp;</div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Centre Name :</strong></div>"+"<div class=' col-md-6'>"+data['name']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'>&nbsp;</div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Website :</strong></div>"+"<div class=' col-md-6'>"+website+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'>&nbsp;</div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Short Name :</strong></div>"+"<div class=' col-md-6'>"+data['short_name']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Head of Centre :</strong></div>"+"<div class=' col-md-6'>"+data['proprietor_name']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Address :</strong></div>"+"<div class=' col-md-6'>"+data['address']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Contact No. :</strong></div>"+"<div class=' col-md-6'>"+data['mobile_no']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Agreed Minimum Invoice:</strong></div>"+"<div class=' col-md-6'>"+data['agreed_minimum_invoice']+"</div></div>";					
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Email :</strong></div>"+"<div class=' col-md-6'>"+data['email']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Date Of Approval :</strong></div>"+"<div class=' col-md-6'>"+date_of_approval+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Liaision Officer :</strong></div>"+"<div class=' col-md-6'>"+data['liaison_office']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Date Of Review :</strong></div>"+"<div class=' col-md-6'>"+date_of_review+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Liaision Officer Address :</strong></div>"+"<div class=' col-md-6'>"+data['liaison_office_address']+"</div></div>";
					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Approve Status :</strong></div>"+"<div class=' col-md-6'>"+approveStatusHtml+"</div></div>";

					modalHtml +="<div class='col-lg-6  margin-top-5'><div class='col-md-6 '><strong>Status :</strong></div>"+"<div class=' col-md-6'>"+statusHtml+"</div></div>";

				modalHtml +="<div class='col-lg-12 '>&nbsp;<br><div class='col-lg-12'><strong>Qualification Details :</strong></div>"+"<div class='col-lg-12'>";
				modalHtml +="<table class='table table-bordered table-hover ' style='width:100% !important'> <thead><tr><th>Q. Code</th><th>Title</th><th class='text-center'>Level </th><th class='text-center'>TQT</th><th class='text-center'>No of Units</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['qualifications'])){
					var trHtml = "";
					$.each(data['qualifications'], function(i,data){  
						modalHtml 	+= "<tr><td>"+data['code']+"</td>"+"<td>"+data['title']+"</td>"+"<td class='text-center'>"+data['level_id']+"</td>"+"<td class='text-center'>"+data['tqt']+"</td>"+"<td class='text-center'>"+data['units'].length+"</td>"+"</tr>";
					})
				}
				 modalHtml += "</tbody></table></div></div>";
				
				$('#myModalLabelLg').html("Centre details of #"+data['code']);
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
		
	//Edit function for Module
	centerEdit = function centerEdit(id){
		var edit_id = id;
		$("#clear_button").trigger('click');
		$("#admin_user_add_button").html("<b> Edit Centre</b>");
		
		$.ajax({
			url: url+'/center/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['center'];
				
				$("#admin_user_add_button").trigger('click');
				
				$("#save_center").html('Update');
				$("#clear_button").hide();
				$("#code").val(data['code']);
				$("#name").val(data['name']);
				$("#short_name").val(data['short_name']);
				$("#website").val(data['website']);
				$("#address").val(data['address']);
				$("#proprietor_name").val(data['proprietor_name']);
				$("#mobile_no").val(data['mobile_no']);
				$("#liaison_office").val(data['liaison_office']);
				$("#liaison_office_address").val(data['liaison_office_address']);
				$("#email").val(data['email']);
				$("#agreed_minimum_invoice").val(data['agreed_minimum_invoice']);
				$("#date_of_approval").val(data['date_of_approval']);
				$("#date_of_review").val(data['date_of_review']);
				$("#approval_status").val(data['approval_status']);
				$("#edit_id").val(data['id']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				//console.log(data['qualifications'])
				if(!jQuery.isEmptyObject(data['qualifications'])){
					var trHtml = "";
					$.each(data['qualifications'], function(i,data){  
						trHtml 	+= "<tr><td><input type='hidden' name='qualification_ids[]' value='"+data['id']+"' />"+data['code']+"</td>"+"<td>"+data['title']+"</td>"+"<td class='text-center'>"+data['level_id']+"</td>"+"<td class='text-center'>"+data['tqt']+"</td>"+"<td class='text-center'>"+data['units'].length+"</td>"+"<td><button onclick='$(this).parent().parent().remove();' class='btn btn-xs btn-danger'><i class='clip-close'></i></button></td></tr>";
					})
					$('#qualification_table').append(trHtml);
				}	
			}
		});
	}

	//Delete Module
	centerDelete = function centerDelete(id){
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
					url: url+'/center/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							success_or_error_msg('#master_message_div',"danger",response['errors']);
						}
						else{
							success_or_error_msg('#master_message_div',"success",response['message']);
							center_datatable.ajax.reload();
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

