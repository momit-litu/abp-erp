var url 			= $('.site_url').val();

var fade_logo_name 	= $('#fade_logo_name').val();
var fade_logo_url 	= url+"/assets/images/admin-upload/"+fade_logo_name;
var logo_name 		= $('#logo_name').val();
var logo 			= url+"/assets/images/admin-upload/"+logo_name;

var user_name 		= ($('#user_name').length>0)?$('#user_name').val():"";
var user_id 		= ($('#user_id').length>0)?$('#user_id').val():"";
var user_type 		= ($('#user_type').length>0)?$('#user_type').val():"Student";

const profile_image_url 		= url+"/assets/images/user/student/";
const student_document_url 		= url+"/assets/images/student/";
const payment_attachment_url 	= url+"/assets/images/payment/";

$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
	}
});


$('.modal').on('hide.bs.modal', function (e) {
	clear_form();
  })

toastr.options = {
	"closeButton": true,
	"debug": false,
	"newestOnTop": true,
	"progressBar": true,
	"positionClass": "toast-top-right",
	"preventDuplicates": false,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
};


if($.trim($('#session_message').html())!=""){
	toastr[($.trim($('#session_message_code').html())==0)?'error':'success']($.trim($('#session_message').html()),  '');
}


// load the specific tab from url
var base_url = window.location.href
var url_info = base_url.split('?');

if(url_info.length>1){
	var url_param = url_info[1];
	var url_param_arr = url_param.split('=');
	if(url_param_arr[1].length>0 && url_param_arr[0]=='tab'){
		$('#'+url_param_arr[1]).trigger('click');
	}
}



const editors = {};

function createEditor( elementId ) {
    return ClassicEditor
        .create( document.getElementById( elementId ) )
        .then( editor => {
            editors[ elementId ] = editor;
        } )
        .catch( err => console.error( err.stack ) );
}

printWindow =  function printWindow() {
	window.print();
}	

// className: danger, success, info, primary, default, warning
function success_or_error_msg(div_to_show, class_name, message, field_id){
	$(div_to_show).addClass('alert alert-custom alert-'+class_name).html(message).show("slow");
	//$(window).scrollTop(200);
	var set_interval = setInterval(function(){
		$(div_to_show).removeClass('alert alert-custom alert-'+class_name).html("").hide( "slow" );
		if(field_id!=""){ $(field_id).focus();}
		clearInterval(set_interval);
	}, 5000);
}

function clear_form(){
	$('.form')[0].reset();
	$('.form').find('input[type=hidden]').each(function(){
        this.value = "";
    });
}


// Notifications
$(document).ready(function () {
	// for get site url
	var page =1;
	var latestNotificationId ="";

	$('.openDropdown').on('click', function (event) {
		event.stopPropagation();
		//$(this).toggleClass('open');
	});


	set_notification_time_out_fn = () =>{
        setTimeout(function(){
            loadNotifications('latest');
        }, 20000);
    }

	notificationSeen = (id) =>{
		totalUnreadNotifications =(totalUnreadNotifications>0)?(totalUnreadNotifications-1):totalUnreadNotifications;
		if($.trim($('#notificationCount').html()) != 0){
			$.ajax({
				url: url+"/notification/view/"+id,
				type: 'GET',
				async: true,
			})
		}
		$('#notificationCount').html(totalUnreadNotifications);
		if(totalUnreadNotifications == 0){
			$('#notification_span').removeClass('bg-success');
			$('#notification_span').addClass('bg-danger');
			$('#notification_i').removeClass('text-success');
			$('#notification_i').addClass('text-danger');
			$('#notification_span_badge').css('display','block');	
		}
	}

	reload_notification = () =>{
		if($.trim($('#notificationCount').html()) != 0){
			page =1;
			loadNotifications();
		}
	}

	redirectCourseView = (batch_id) =>{
		window.location.href = url+"/portal/course/"+batch_id;
	}
	
	var totalUnreadNotifications = 0;
	loadNotifications = (typepage) =>{
		$.ajax({
			url: url+'/notifications/'+typepage,
			type:'GET',
			async:true,
			success: function(response){
				response 				= JSON.parse(response);
				totalUnreadNotifications= response['totalUnreadNotifications'];
				studentNotificationHtml = '';
				paymentotificationHtml 	= '';
				courseNotificationHtml 	= '';

				if(!jQuery.isEmptyObject(response)){
					//$.each(response['notifications'], function (key, notification) {	
					for(var key =0; key < response['notifications'].length; key++){
						var notification = 	response['notifications'][key];					
						var notificationId 		= notification.id;
						
						if(latestNotificationId == notificationId) {
							break;
						}
						if(typepage ==1 && key==0) latestNotificationId = notificationId;

						var created_at =  new Date(notification.created_at).toLocaleDateString('en-US', {
						day: '2-digit',
						month: '2-digit',
						year: '2-digit',
						hour: '2-digit',
						minute: '2-digit',
						});					
						var read_status_class 	= (notification.read_at==null)?"danger":"success";
						var read_status 		= (notification.read_at==null)?"unread":"read";
						var seen_message_html 	= (notification.read_at==null)?"notificationSeen('"+notification.id+"')":"";
						
						if(notification.data.Type == 'Students'){
							studentNotificationHtml +=`
							<div class="vertical-timeline-item vertical-timeline-element">
								<div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-`+read_status_class+`"> </i></span>
									<div class="vertical-timeline-element-content bounce-in `+read_status+`" style="cursor:pointer" onclick="studentView(`+notification.data.Id+`); `+seen_message_html+`"            >
										<p>`+notification.data.Message+`<br><span class="text-`+read_status_class+`">`+created_at+`</span></p><span class="vertical-timeline-element-date"></span>
									</div>
								</div>
							</div>
							`;
						}
						else if(notification.data.Type == 'Payments'){
							paymentotificationHtml +=`
							<div class="vertical-timeline-item vertical-timeline-element">
								<div><span class="vertical-timeline-element-icon bounce-in" ><i class="badge badge-dot badge-dot-xl badge-`+read_status_class+`"> </i></span>
									<div class="vertical-timeline-element-content bounce-in `+read_status+`" style="cursor:pointer" onclick="paymentInvoice(`+notification.data.Id+`); `+seen_message_html+`">
										<p>`+notification.data.Message+`<br><span class="text-`+read_status_class+`">`+created_at+`</span></p><span class="vertical-timeline-element-date"></span>
									</div>
								</div>
							</div>
							`;
						}
						else if(notification.data.Type == 'Courses'){
							courseNotificationHtml +=`
							<div class="vertical-timeline-item vertical-timeline-element">
								<div><span class="vertical-timeline-element-icon bounce-in" ><i class="badge badge-dot badge-dot-xl badge-`+read_status_class+`"> </i></span>
									<div class="vertical-timeline-element-content bounce-in `+read_status+`" style="cursor:pointer" onclick="redirectCourseView(`+notification.data.Id+`); `+seen_message_html+`">
										<p>`+notification.data.Message+`<br><span class="text-`+read_status_class+`">`+created_at+`</span></p><span class="vertical-timeline-element-date"></span>
									</div>
								</div>
							</div>
							`;
						}	
					}//)
					
					$('#notificationCount').html(totalUnreadNotifications);
					$('#dropdown_notification_count').html(totalUnreadNotifications);

					if(totalUnreadNotifications>0){
						$('#notification_span').removeClass('bg-success');
						$('#notification_span').addClass('bg-danger');
						$('#notification_i').removeClass('text-success');
						$('#notification_i').addClass('text-danger');
						$('#notification_span_badge').css('display','block');	
					}
					if(typepage ==1){
						if($('#student_notification_div').length >0)
							$('#student_notification_div').html(studentNotificationHtml);
						if($('#course_notification_div').length >0)
							$('#course_notification_div').html(courseNotificationHtml);	

						$('#payment_notification_div').html(paymentotificationHtml);					
					}					
					else{
						if($('#student_notification_div').length >0)
							$('#student_notification_div').append(studentNotificationHtml);
						if($('#course_notification_div').length >0)
							$('#course_notification_div').append(courseNotificationHtml);

						$('#payment_notification_div').append(paymentotificationHtml);
					}	
					//console.log(response)
					$('.unread').on('click', function () {
						$(this).children().children().removeClass('text-danger');
						$(this).children().children().addClass('text-success');
						$(this).prev().children().removeClass('badge-danger');
						$(this).prev().children().addClass('badge-success');
					});
					//page++;
				}
			}
		})
		set_notification_time_out_fn();
	}
	if(user_id != ""){
		loadNotifications(page);
	}

	loadMoreNotofication = () =>{
		page++;
		loadNotifications(page);
	}

	loadAllNotofication = () =>{
		window.location.href = url+"/profile?tab=notification";
	}

});


