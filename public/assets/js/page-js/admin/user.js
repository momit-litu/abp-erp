// All the user related js functions will be here
$(document).ready(function () {	
	// for get site url

	var url = $('.site_url').val();
	const user_type = "Admin";
	// icheck for the inputs
	$('.form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass	: 'iradio_flat-green'
	});	
	
	adminUserAdd = function adminUserAdd(){
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Admin User');
		$("#clear_button").show();
		$("#save_admin_info").html('Save');	
		$('#entry-form').modal('show');
	}
		
	//function for data table
	admin_datatable = $('#admin_user_table').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"ajax": url+"/admin/ajax/admin-list?type="+user_type,
		"aoColumns": [
			{ mData: 'user_profile_image', className: "text-center"}, 
			{ mData: 'name' },
			{ mData: 'email'},
			{ mData: 'groups_name'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
		"columnDefs": [
			{ "width": "130px", "targets":[ 5 ]},
        ],
		/*'rowCallback': function (nRow, aData, iDisplayIndex) {
			nRow.id = aData[0];
			nRow.className = "danger";
			return nRow;
		},*/
	});
	
		
	// Admin User Entry And Update
	$('#save_admin_info').click(function(event){		
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		
		var formData = new FormData($('#admin_user_form')[0]);
		//formData.append("q","insert_or_update");
		if($.trim($('#first_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please insert first name","#first_name");			
		}
		else if($.trim($('#contact_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please insert contact no","#contact_no");			
		}
		else if($.trim($('#email').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please insert Email","#email");			
		}	
		else{
			$.ajax({
				url: url+"/admin/admin-user-entry",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					var response = JSON.parse(data);				
					if(response['result'] == '0'){
						var errors	= response['errors'];					
						resultHtml = '<ul>';
							$.each(errors,function (k,v) {
							resultHtml += '<li>'+ v + '</li>';
						});
						resultHtml += '</ul>';
						toastr['error']( 'Failed!!!!', resultHtml);
					}
					else{				
						toastr['success']( 'Saved Successfully', 'Admin User '+$('#first_name').val());
						$('.modal').modal('hide')
						clear_form();
						admin_datatable.ajax.reload();
						$("#save_admin_info").html("save");
						$("#user_image").attr("src", "src");
						$("#id").val('');
					}
					$(window).scrollTop();
				 }	
			});
		}	
	})
	
	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
	});	


	
	//Admin User Edit
	admin_user_edit = function admin_user_edit(id){
		var edit_id = id;
		$.ajax({
			url: url+'/admin/edit/'+edit_id+"?type="+user_type,
			cache: false,
			success: function(response){
				var data = JSON.parse(response);
				var emp_data = data['data'];
				var user_group_member_details = data['user_group_member_details'];
				$("#save_admin_info").html('Update');
				$("#cancle_admin_update").removeClass('hidden');
				$("#first_name").val(emp_data['first_name']);
				$("#last_name").val(emp_data['last_name']);
				$("#id").val(emp_data['id']);
				$("#contact_no").val(emp_data['contact_no']);
				$("#email").val(emp_data['email']);
				/*$("#address").val(emp_data['address']);*/
				$("#remarks").val(emp_data['remarks']);
				if(emp_data["user_profile_image"]==null) emp_data['user_profile_image'] = 'no-user-image.png';
				
				$("#user_image").attr("src", profile_image_url+"/"+emp_data["user_profile_image"]);
				(emp_data['status']==0)?$("#is_active").iCheck('uncheck'):$("#is_active").iCheck('check');
				/*get group for edit*/
				if(!jQuery.isEmptyObject(user_group_member_details)){
					var html = '<table class="table table-bordered"><thead><tr class="headings"><th class="column-title text-center" class="col-md-8 col-sm-8 col-xs-8" >Group Name</th><th class="col-md-2 col-sm-2 col-xs-12"><input type="checkbox" id="check-all" class="tableflat">Select All</th></tr></thead>';
						html += '<tr><td colspan="2"><div class="form-row">';
						$.each(user_group_member_details, function(i,row){
							if (row['status']=='0') {
								html += '<div class="col-md-3" style="margin-top:5px;"><input type="checkbox" name="group[]"  class="tableflat"  value="'+row["id"]+'"/> '+row["group_name"]+'</div>';
							}
							else{
								html += '<div class="col-md-3" style="margin-top:5px;"><input checked type="checkbox" name="group[]"  class="tableflat"  value="'+row["id"]+'"/> '+row["group_name"]+'</div>';
							}
						});
						html += '</div></td></tr>';
					html +='</table>';	
				}
				$('#group_select').html(html);
				$('#admin_user_form').iCheck({
						checkboxClass: 'icheckbox_flat-green',
						radioClass: 'iradio_flat-green'
				});			
				$('#admin_user_form input#check-all').on('ifChecked', function () {				
					$("#admin_user_form .tableflat").iCheck('check');
				});
				$('#admin_user_form input#check-all').on('ifUnchecked', function () {
					$("#admin_user_form .tableflat").iCheck('uncheck');
				});

				$("#form-title").html('<i class="lnr-pencil"></i> Edit User #'+emp_data['id']+' '+emp_data['first_name']+' </h5>');
				$('#entry-form').modal('show');
			}
		});
	}
		
		
	//Admin User View
	 admin_user_view = function admin_user_view(id){	
		var user_id = id;
		$.ajax({
			url: url+'/admin/admin-view/'+user_id+"?type="+user_type,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['user'];
				var groups = response['groups'];

				$("#profile_modal").modal();
				$("#name_div").html('<h5>'+data['first_name']+" "+data['last_name']+'</h5>');
				$("#contact_div").html(data['contact_no']);
				$("#email_div").html(data['email']);
				
				$("#group_div").html('<span class="badge badge-warning">'+groups[0]["group_name"]+'</span>');
				if (data['remarks']!=null && data['remarks']!="") {
					$("#remarks_details").html('<b>Remarks:</b>'+data['remarks']);
				}
				else{
					$("#remarks_div").html('');
					$("#remarks_details").html("");
				}
				
				if (data["user_profile_image"]!=null && data["user_profile_image"]!="") {
					$(".profile_image").html('<img style="width:100%" src="'+profile_image_url+'/'+data["user_profile_image"]+'" alt="User Image" class="img img-responsive">');
				}
				else{
					$(".profile_image").html('<img  style="width:100%" src="'+profile_image_url+'/no-user-image.png" alt="User Image" class="img img-responsive">');
				}
				
				
				if(data['status']==1){
					$("#status_div").html('<span class="badge badge-success">Active</span>');
				}
				else{
					$("#status_div").html('<span class="badge badge-danger">In-active</span>');
				} //alert(profile_image_url);
			}
		});
	}
		
			
	//Delete Admin-user	
	delete_admin_user = function delete_admin_user(id){
		var delete_id = id;
		swal({
			title: "Are you sure?",
			text: "The user will be in-active!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: url+'/admin/delete/'+delete_id,
					cache: false,
					success: function(response){
						var response = JSON.parse(response);
						swal(response['deleteMessage'], {
						icon: "success",
						});
						admin_datatable.ajax.reload();
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


	//Admin User & App User Group (Entry And update)
	$('#save_group').click(function(event){		
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		
		var formData = new FormData($('#save_group_form')[0]);
		if($.trim($('#group_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Group Name","#group_name");			
		}
		else if($.trim($('#type').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Type","#type");			
		}
		else{
			$.ajax({
				url: url+"/admin/admin-group-entry",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					var response = JSON.parse(data);
				
					if(response['result'] == '0'){
						var errors	= response['errors'];					
						resultHtml = '<ul>';
						$.each(errors,function (k,v) {
							resultHtml += '<li>'+ v + '</li>';
						});
						resultHtml += '</ul>';
						toastr['error']( 'Failed!!!!', resultHtml);
					}
					else{	
						toastr['success']( 'Saved Successfully', 'User Group '+$('#group_name').val());
						admin_group.ajax.reload();
						clear_form();
						$('.modal').modal('hide');
						$("#clear_button").show();
						$("#form-title").html('<i class="fa fa-plus"></i> Add  New User Group</h5>');
						$("#save_group").html('Save');
						$("#edit_id").val('');
					}
					$(window).scrollTop();
				 }	
			});
		}	
	})


	
	groupAdd = function groupAdd(){
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New User Group');
		$("#clear_button").show();
		$("#save_module").html('Save');	
		$('#entry-form').modal('show');
	}
	//Admin User Group list
	admin_group = $('#admin_group').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"ajax": url+"/admin/admin-group-list",
		"aoColumns": [ 
			{ mData: 'id'},
			{ mData: 'group_name' },
			{ mData: 'type'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
	});


	//Admin Group Edit
	admin_group_edit = function admin_group_edit(id){
		var edit_id = id;
		$.ajax({
			url: url+'/admin/admin-group-edit/'+edit_id,
			cache: false,
			success: function(response){
				var data = JSON.parse(response);
				$("#save_group").html('Update');
				$("#clear_button").hide();
				$("#edit_id").val(data['id']);
				$("#group_name").val(data['group_name']);
				$("#type").val(data['type']).change();
				if(data['status']=='1'){
					$("#is_active").iCheck('check');
				}
				else{
					$("#is_active").iCheck('uncheck');
				}
				$("#form-title").html('<i class="lnr-pencil"></i> Edit User Group #'+data['id']+' '+data['group_name']+' </h5>');
				$('#entry-form').modal('show');
			}
		});
	}




	//Delete Admin-user	
	admin_group_delete = function admin_group_delete(id){
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
					url: url+'/admin/admin-group-delete/'+delete_id,
					cache: false,
					success: function(response){
						var response = JSON.parse(response);
						swal(response['deleteMessage'], {
						icon: "success",
						});
						admin_group.ajax.reload();
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


	//Load User Groups
	$.ajax({
		url: url+"/load-user-groups"+"?type="+user_type,
		dataType: 'json',
		success: function(response) {
		var data = response.data;	
			if(!jQuery.isEmptyObject(data)){
				var html = '<table class="table table-bordered"><thead><tr class="headings"><th class="column-title" class="col-md-8 col-sm-8 col-xs-8" >Admin User Groups</th><th class="col-md-2 col-sm-2 col-xs-12"> <input type="checkbox" id="check-all" class="tableflat">All?</th></tr></thead>';
					html += '<tr><td colspan="2"><div class="form-row">';
					
					$.each(data, function(i,data){
						html += '<div class="col-md-3" style="margin-top:5px;"><input type="checkbox" name="group[]"  class="tableflat check_permission"  value="'+data["id"]+'"/> '+data["group_name"]+'</div>';
					});
					html += '</div></td></tr>';
				html +='</table>';	
			}
			$('#group_select').html(html);
			$('#admin_user_form').iCheck({
					checkboxClass: 'icheckbox_flat-green',
					radioClass: 'iradio_flat-green'
			});						
			$('#admin_user_form input#check-all').on('ifChecked', function () {				
				$("#admin_user_form .tableflat").iCheck('check');
			});
			$('#admin_user_form input#check-all').on('ifUnchecked', function () {				
				$("#admin_user_form .tableflat").iCheck('uncheck');
			});
		}
	});


	/*------------------------Permission Panel Hide Start--------------------------*/
	permission_panale_hide = function permission_panale_hide(){
		$("#permission_list").addClass('hide');
	}
	$("#user_group_management_tab").click(function(){
		permission_panale_hide();
	});
	/*------------------------Permission Panel Hide End--------------------------*/
	

	/*------------------------Permission Panel Open Start--------------------------*/
	group_permission = function group_permission(id){
		$("#group_id").val(id);
		load_actions_for_group_permission(id);
		$('#permission-modal').modal('show');
		
	}
	/*------------------------Permission Panel Open End--------------------------*/
	

	/*------------------------Load Permission Actions--------------------------*/
	load_actions_for_group_permission = function load_actions_for_group_permission(id){
		var group_id_for_selected_action = id;
		$.ajax({
		url: url+"/admin/load-actions-for-group-permission/"+group_id_for_selected_action,
		dataType: 'json',
		success: function(response) {
		var data = response.data;	
			
			
			if(!jQuery.isEmptyObject(data)){
				var html = '<table class="table table-bordered"><thead><tr class="headings"><th class="column-title text-left" class="col-md-8 col-sm-8 col-xs-8" > Actions List (This group will get the permission to access the selected actions)</th><th class="col-md-2 col-sm-2 col-xs-12"><input type="checkbox" id="check-all" class="tableflat">Select All</th></tr></thead>';
					html += '<tr><td colspan="2" >';
					prev_module = "";
					$.each(data, function(i,data){
						console.log(data);
						if(prev_module !=  data["module_name"]) {
							html += '<div class="col-md-12 " style="margin-top:15px; padding:5px 15px; border-bottom:1px solid #ddd"><b>'+data["module_name"]+'</b></div>';
							prev_module = data["module_name"];
							html += '<div class="form-row">	';
						}
						if(data['status']==1){
							html += '<div class="col-md-3"  style="margin-top:5px;" ><input type="checkbox" checked name="permission_action[]" class="tableflat"  value="'+data["action_id"]+'"/> '+data["activity_name"]+'</div>';
						}
						else{
							html += '<div class="col-md-3"  style="margin-top:5px;" ><input type="checkbox"  name="permission_action[]" class="tableflat"  value="'+data["action_id"]+'"/> '+data["activity_name"]+'</div>';
						}
					});
				html += '</td></tr>';
				html +='</table>';	
			}
			
			$('#action_select').html(html);
			$('#action_select_form').iCheck({
					checkboxClass: 'icheckbox_flat-green',
					radioClass: 'iradio_flat-green'
			});									
			
			$('#action_select_form input#check-all').on('ifChecked', function () {
				$("#action_select_form .tableflat").iCheck('check');
			});
			$('#action_select_form input#check-all').on('ifUnchecked', function () {
				$("#action_select_form .tableflat").iCheck('uncheck');
			});
		}
	});
	}
	/*------------------------Load Permission Actions End--------------------------*/


	/*------------------------Entry And Update Permission Actions Start--------------------------*/
	$('#save_permission').click(function(event){		
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		var formData = new FormData($('#action_select_form')[0]);	
		$.ajax({
			url: url+"/admin/permission-action-entry-update",
			type:'POST',
			data:formData,
			async:false,
			cache:false,
			contentType:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
			
				if(response['result'] == '0'){
					var errors	= response['errors'];					
					resultHtml = '<ul>';
						$.each(errors,function (k,v) {
						resultHtml += '<li>'+ v + '</li>';
					});
					resultHtml += '</ul>';
					toastr['error']( 'ERROR!!!!', resultHtml);
				}
				else{	
					toastr['success']( 'Saved Successfully', 'User Group Permission');	
					$('.modal').modal('hide')		
					clear_form();
				}
			 }	
		});
	});
	/*----------------------Entry And Update Permission Actions Start------------------------*/	
});