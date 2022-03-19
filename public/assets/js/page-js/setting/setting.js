// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	// icheck for the inputs
	$('.form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});


	// Update General Setting
	$('#save_general_setting').click(function(event){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#general_setting')[0]);
		if($.trim($('#company_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Company Name","#company_name");
		}
		else if($.trim($('#short_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Short Name","#short_name");
		}
		else if($.trim($('#site_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Site Name","#site_name");
		}
		/*else if($.trim($('#admin_email').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Insert Admin Email","#admin_email");
		}*/
		else if($.trim($('#admin_mobile').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Insert Admin Mobile","#admin_mobile");
		}
		else{
			$.ajax({
				url: url+"/general/setting-update",
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
						//load_data("");
						clear_form();
					}
					else{
						toastr['success']( 'Updated Successfully', 'General Settings ');
					}
					$(window).scrollTop();
				 }
			});
		}
	});


	//for show menus list
	 menu_datatable = $('#menus_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/module/menu-list",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'module_name' },
			{ mData: 'menu_title'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
	});

	load_menu = function load_menu(){
		//Getting Parrent Menu
		$.ajax({
			url : url+"/module/get-parent-menu",
			cache: false,
			dataType: 'json',
			success: function(response){
				
				//console.log(response);
				var data = response.data;
				var option = '';
				$.each(data,function(index,row){
					option +="<option>";
					option += row.module_name;
					option += "</option>";
				})
				
				$("#existed_menu").html(option);
				//console.log(data[0]['module_name']);
			}
		});
	}
	load_menu();
	
	//Entry And Update Function For Module
	$("#save_module").on('click',function(){

		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#web_module_form')[0]);

		if($.trim($('#module_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Module Name","#module_name");
		}
		else if($.trim($('#menu_title').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Menu Title","#menu_title");
		}
		else{
			$.ajax({
				url: url+"/module/module-entry",
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
						toastr['error']( 'Failed!!!!', resultHtml);
					}
					else{
						toastr['success']( 'Save Successfully', 'Module '+$('#menu_title').val());
						menu_datatable.ajax.reload();
						clear_form();
						$('.modal').modal('hide')
						$("#clear_button").show();
						$("#form-title").html('<i class="fa fa-plus"></i> Add  New Student</h5>');
						$("#save_module").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
		//console.log(formData);
	});


	//Clear form
	$("#clear_button").on('click',function(){
		clear_form();
		$("#parent_id").remove();
	});

	moduleAdd = function moduleAdd(){
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Module');
		$("#clear_button").show();
		$("#save_module").html('Save');	
		$('#entry-form').modal('show');
	}
	//Edit function for Module
	moduleEdit = function moduleEdit(id){
		var edit_id = id;
		$.ajax({
			url: url+'/module/edit/'+edit_id,
			cache: false,
			success: function(response){
				var data = JSON.parse(response);
				$("#form-title").html('<i class="lnr-pencil"></i> Edit Module #'+data['id']+' '+data['module_name']+' </h5>');
				$("#save_module").html('Update');
				$("#clear_button").hide();
				$("#module_name").val(data['module_name']);
				$("#edit_id").val(data['id']);
				$("#parent_id").val(data['parent_id']);
				$("#menu_title").val(data['menu_title']);
				$("#menu_url").val(data['menu_url']);
				$("#menu_icon_class").val(data['menu_icon_class']);
				$('#entry-form').modal('show');
			}
		});
	}


	//Delete Module
	moduleDelete = function moduleDelete(id){
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
					url: url+'/module/delete/'+delete_id,
					cache: false,
					success: function(response){
						var response = JSON.parse(response);
						if (response['parentmessage']) {
							swal(response['parentmessage'], {
								icon: "warning",
							});
						}
						else{
							swal(response['deleteMessage'], {
								icon: "success",
							});
							menu_datatable.ajax.reload();
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


	//Entry and Update Web Action
	$('#save_web_action').click(function(event){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});
		var formData = new FormData($('#web_action_form')[0]);
		if($.trim($('#module_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Module Name","#module_name");
		}
		else if($.trim($('#activity_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Action Name","#activity_name");
		}
		else{
			$.ajax({
				url: url+"/web-action/web-action-entry",
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
						toastr['error']( 'Failed!!!!', resultHtml);
					}
					else{
						toastr['success']( 'Save Successfully', 'Action '+$('#activity_name').val());
						web_actions_table.ajax.reload();
						clear_form();
						$('.modal').modal('hide')
						$("#form-title").html('<i class="fa fa-plus"></i> Add  New Action</h5>');
						$("#clear_button").show();
						$("#save_web_action").html("Save");
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	actionAdd = function actionAdd(){
		$("#form-title").html('<i class="fa fa-plus"></i> Add  New Action');
		$("#clear_button").show();
		$("#save_web_action").html('Save');	
		$('#entry-form').modal('show');
	}

	//Web Action Show
	web_actions_table = $('#web_actions_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/web-action/action-lists",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'activity_name' },
			{ mData: 'module_name' },
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-center"},
		],
	});


	//Web Actions Edit
	web_action_edit = function web_action_edit(id){
		var edit_id = id;
		$.ajax({
			url: url+'/web-action/edit/'+edit_id,
			cache: false,
			success: function(response){
				var data = JSON.parse(response);
				$("#form-title").html('<i class="lnr-pencil"></i> Edit Action #'+data['id']+' '+data['activity_name']+' </h5>');
				$("#save_web_action").html('Update');
				$("#clear_button").hide();
				$("#activity_name").val(data['activity_name']);
				$("#edit_id").val(data['id']);
				$("#is_menu").val(data['is_menu']);				
				$("#module_name").val(data['module_id']).change();
				(data['status']==0)?$("#is_active").iCheck('uncheck'):$("#is_active").iCheck('check');
				$('#entry-form').modal('show');
			}
		});
	}

	/*----- Comon Function Start -----*/
	cancle_btn_show = function cancle_btn_show(){
		$("#cancle_btn").removeClass('hidden');
	}
	cancle_function = function cancle_function(){
		$("#cancle_btn").click(function() {
			$("#cancle_btn").addClass('hidden');
			clear_form();
			success_function();
		});
	}
	success_function = function success_function(){
		$("#cancle_btn").addClass('hidden');
		$(".save").html("Save");
		clear_form();
	}
	/*----- Comon Function End -----*/


});

