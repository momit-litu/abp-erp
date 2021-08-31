var url 			= $('.site_url').val();
var fade_logo_name 	= $('#fade_logo_name').val();
var fade_logo_url 	= url+"/assets/images/admin-upload/"+fade_logo_name;
var logo_name 		= $('#logo_name').val();
var logo 			= url+"/assets/images/admin-upload/"+logo_name;
const profile_image_url 		= url+"/assets/images/student/";
const payment_attachment_url 	= url+"/assets/images/payment/";

$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
	}
});


$('.form').iCheck({
	checkboxClass: 'icheckbox_flat-green',
	radioClass	: 'iradio_flat-green'
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
	var url = $('.site_url').val();
	var page =1;

	$('.openDropdown').on('click', function (event) {
		event.stopPropagation();
		//$(this).toggleClass('open');
	});


	set_notification_time_out_fn = () =>{
        setTimeout(function(){
            loadNotifications();
        }, 7000);
    }

	view_notification = () =>{
		if($.trim($('#notificationCount').html()) != 0){
			$.ajax({
				url: url+"/notification/view/",
				type: 'GET',
				async: true,
			})
		}
	}

	reload_notification = () =>{
		if($.trim($('#notificationCount').html()) != 0){
			page =1;
			loadNotifications();
		}
	}

	loadNotifications = () =>{
		$.ajax({
			url: url+'/notifications/'+page,
			type:'GET',
			async:true,
			success: function(response){
				response 					= JSON.parse(response);
				totalUnreadNotifications	= response['totalUnreadNotifications'];
				html = '';
				$.each(response['notifications'], function (key, notification) {
					created_at =  new Date(notification.created_at).toLocaleDateString('en-US', {
					  day: '2-digit',
					  month: '2-digit',
					  year: '2-digit',
					  hour: '2-digit',
					  minute: '2-digit',
					});

					var read_status_class 	= (notification.read_at==null)?"alert-danger":"";
					html +=' <li class="'+read_status_class+'"> ' +
							'<a href="javascript:void(0)"> ' +
								/*'<span class="label label-primary"><i class="fa fa-user"></i></span> ' +*/
								'<span class="message"> '+notification.data.Message+'</span> ' +
								'<span class="time"> '+created_at+'</span> ' +
							'</a> ' +
							'</li>'

				})

				$('#notificationCount').html(totalUnreadNotifications)
				if(page ==0)
					$('#notification_list').html(html)
				else
					$('#notification_list').append(html);
				//console.log(response)

			}
		})
		page++;
		//set_notification_time_out_fn()
	}

	loadNotifications();

	loadMoreNotofication = () =>{
		loadNotifications();
	}

	loadAllNotofication = () =>{
		window.location.href = url+"/notification";
	}

});


