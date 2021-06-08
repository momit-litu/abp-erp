// All the Setting related js functions will be here
$(document).ready(function () {
	// for get site url
	var url = $('.site_url').val();

	// icheck for the inputs
	$('#learner_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});


	//for show learners list
	 learner_datatable = $('#learners_table').DataTable({
		destroy: true,
		"order": [[ 0, 'desc' ]],
		"processing": true,
		"serverSide": false,
		"ajax": url+"/learners",
		"aoColumns": [
			{ mData: 'id'},
			{ mData: 'user_profile_image', className: "text-center"}, 
			{ mData: 'center_name' },
			{ mData: 'first_name'},
			{ mData: 'last_name'},
			{ mData: 'email'},			
			{ mData: 'contact_no'},
			{ mData: 'address'},
			{ mData: 'status', className: "text-center"},
			{ mData: 'actions' , className: "text-left"},
		],
		"columnDefs": [
            { "targets": [ 0 ],  "visible": false },
			{ "width": "130px", "targets":[ 9 ]},
        ],
	});
	
	if(user_type == 'Center'){
		var column = learner_datatable.column(1);
		column.visible( ! column.visible() );
		var column2 = learner_datatable.column(2);
		column2.visible( ! column2.visible() );
	}
	//autosuggest
	$.ajaxSetup({
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		}
	});
	
	//Entry And Update Function For Module
	$("#save_learner").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#learner_form')[0]);

		if($.trim($('#first_name').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter first name","#first_name");
		}
		else if($.trim($('#email').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter email","#email");
		}
		else if($.trim($('#contact_no').val()) == "" || !($.isNumeric($('#contact_no').val()))){
			success_or_error_msg('#master_message_div','danger',"Please enter contact no","#contact_no");
		}
		else if($.trim($('#date_of_birth').val()) == ""){
			success_or_error_msg('#master_message_div','danger',"Please enter date of birth","#date_of_birth");
		}
		else{
			$.ajax({
				url: url+"/learner",
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
						learner_datatable.ajax.reload();
						clear_form();
						$("#clear_button").show();
						$("#save_learner").html('Save');
					}
					$(window).scrollTop();
				 }
			});
		}
	});

	//Clear form
	$("#clear_button").on('click',function(){
		$("#user_image").attr("src", learner_image_url+"/no-user-image.png");	
		clear_form();
	});
	

	$("#admin_user_list_button, #cancel_button").on('click',function(){
		$("#user_image").attr("src", learner_image_url+"/no-user-image.png");	
		clear_form();
		$("#clear_button").show();
		$("#save_learner").html('Save');
		$("#admin_user_add_button").html("<b> Add Learner</b>");
	});
	
	
	//Learner detail View
	learnerView = function learnerView(id){	
		$.ajax({
			url: url+'/learner/'+id,
			cache: false,
			success: function(response){
				var response 	= JSON.parse(response);
				var data 		= response['learner'];
				var statusHtml 	= (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
				var address 	= (data['address'])?data['address']:'';
				var nid_no 		= (data['nid_no'])?data['nid_no']:'';
				var remarks 	= (data['remarks'])?data['remarks']:'';
				
				if (data["user_profile_image"]!=null && data["user_profile_image"]!="") {
					var photo ='<img src="'+learner_image_url+'/'+data["user_profile_image"]+'" alt="Learner Image" class="img img-responsive">';
				}
				else{
					var photo ='<img src="'+learner_image_url+'/no-user-image.png" alt="Learner Image" class="img img-responsive">';
				}

				var modalHtml  ="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 '><div class='thumbnail text-center photo_view_postion_b' ><div class='profile_image'>"+photo+"</div></div></div><div class='col-lg-8 '>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>First Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['first_name']+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Last Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['last_name']+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Date of Birth :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['date_of_birth']+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Email :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['email']+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Contact No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['contact_no']+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Address :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+address+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>National ID No. :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+nid_no+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Centre :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['center']['name']+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";
					modalHtml +="<div class='col-lg-12  margin-top-5 '><div class='col-lg-3 col-md-4 '><strong>Remarks :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+remarks+"</div></div>";
					modalHtml +="</div></div>";
				/*modalHtml +="<div class='col-lg-12 '>&nbsp;<br><div class='col-lg-12'><strong>Unit Details :</strong></div>"+"<div class='col-lg-12'>";
				modalHtml +="<table class='table table-bordered table-hover ' style='width:100% !important'> <thead><tr><th>Code</th><th>Name</th><th>GLH</th><th>Type</th><th>Assesment Type</th></tr></thead><tbody>";
				if(!jQuery.isEmptyObject(data['units'])){
					var trHtml = "";
					$.each(data['units'], function(i,data){  
						modalHtml 	+= "<tr><td>"+data['unit_code']+"</td>"+"<td>"+data['name']+"</td>"+"<td>"+data['glh']+"</td>"+"<td>"+data['pivot']['type']+"</td>"+"<td>"+data['assessment_type']+"</td>"+"</tr>";
					})
				}
				 modalHtml += "</tbody></table></div></div>";*/
				
				$('#myModalLabelLg').html("Details of "+data['first_name']+" "+data['last_name']);
				$('#modalBodyLg').html(modalHtml);
				$("#generic_modal_lg").modal();				
			}
		});
	}
		
	//Edit function for Module
	learnerEdit = function learnerEdit(id){
		var edit_id = id;
		$("#clear_button").trigger('click');
		$("#admin_user_add_button").html("<b> Edit Learner</b>");
		
		$.ajax({
			url: url+'/learner/'+edit_id,
			cache: false,
			success: function(response){
				var response = JSON.parse(response);
				var data = response['learner'];
				
				$("#admin_user_add_button").trigger('click');
				
				$("#save_learner").html('Update');
				$("#clear_button").hide();
				
				$("#first_name").val(data['first_name']);
				$("#last_name").val(data['last_name']);
				$("#email").val(data['email']);
				$("#contact_no").val(data['contact_no']);
				$("#address").val(data['address']);
				$("#nid_no").val(data['nid_no']);
				$("#date_of_birth").val(data['date_of_birth']);				
				$("#remarks").val(data['remarks']);
				$("#edit_id").val(data['id']);
				(data['status']=='Inactive')?$("#status").iCheck('uncheck'):$("#status").iCheck('check');
				
				var photo = (data["user_profile_image"]!=null && data["user_profile_image"]!="")?data["user_profile_image"]:'no-user-image.png'; 
				$("#user_image").attr("src", learner_image_url+"/"+photo);	
			}
		});
	}

	//Delete Module
	learnerDelete = function learnerDelete(id){
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
					url: url+'/learner/delete/'+delete_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							success_or_error_msg('#master_message_div',"danger",response['errors']);
						}
						else{
							success_or_error_msg('#master_message_div',"success",response['message']);
							learner_datatable.ajax.reload();
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

