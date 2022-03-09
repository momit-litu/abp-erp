$(document).ready(function () {
    

	$("#batch_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/course-batch-autosuggest',
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

	$("#batch_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
    });

	$("#show_batch_result").on('click',function(){
        if($('#batch_id').val()!=""){
            $.ajax({
                url: url+"/results/"+$('#batch_id').val(),
                type:'get',
                async:false,
                success: function(data){
                    $('#result_table_div').html(data);
                }
            });
            $('#result_div').css('display','block');
        }     
    })

    $("#save_book").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#book_form')[0]);
       
		if($.trim($('#book_name').val()) == "" || $.trim($('#book_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please enter book name","#book_name");
		}
		else{
            formData.append('batch_id', $('#batch_id').val());
			// validate the installment details
			$.ajax({
				url: url+"/book",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
                    var response = JSON.parse(data);
					if(response['response_code'] == 0){
                        success_or_error_msg('#form_submit_error','danger',response['errors'],"#book_name");
                    }
                    else{
                        $('#entry-form').modal('hide');
                        $("#show_batch_books").trigger('click');
                    }					
				 }
			});
		}
	});

    $("#student_result_table_search").on('keyup',function(){
          // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("student_result_table_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("student_result_table");
        tr = table.getElementsByTagName("tr");
      
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
		  td1 = tr[i].getElementsByTagName("td")[1];
		  td2 = tr[i].getElementsByTagName("td")[2];
          if (td) {
            txtValue = td.textContent || td.innerText;
			txtValue1 = td1.textContent || td1.innerText;
			txtValue2 = td2.textContent || td2.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              	tr[i].style.display = "";
            } 
			else  if (txtValue1.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} 
			else  if (txtValue2.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}  
			else {
              	tr[i].style.display = "none";
            }
          }
        }
    });
    
});


function viewResult(id){	
	$.ajax({
		url: url+'/result/'+id,
		cache: false,
		success: function(response){
			var response 	= JSON.parse(response);
			var data 		= response['result'];
			var statusHtml 	= (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
			
			var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student no :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['student_no']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student Name :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student']['name']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Enrollment Id :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_enrollment_id']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+statusHtml+"</div></div>";
			
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['course']['title']+"</div></div>";
			modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch:</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch']['batch_name']+"</div></div>";

			modalHtml +="<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Result Details:</strong></div>"+"<div class='col-lg-12'>";

			modalHtml +="<table class='table table-bordered' style='width:100% !important'> <thead><tr><th>Unit Name</th><th class='text-center'>Credit Hour</th><th class='text-center'>Score</th><th class='text-right'>Result</th></tr></thead><tbody>";

			if(!jQuery.isEmptyObject(data['batch_student_units'])){
				$.each(data['batch_student_units'], function(i,unit){ 
					let result = (unit['result']==null)?'Not Published':unit['result']['name'];
					let score = (unit['score']==null)?'Not Published':unit['score'];

					modalHtml 	+= "<tr class='table-active'><td>("+unit['unit']['unit_code']+")"+unit['unit']['name']+"</td>"+"<td class='text-center'>"+unit['unit']['credit_hour']+"</td>"+"<td class='text-center'>"+score+"</td>"+"<td class='text-center'>"+result+"</td>"+"</tr>";
				
				});
			}
			
			modalHtml += "</tbody></table></div></div>";
			$('#myModalLabelLg').html('Result Details Of '+data['student']['name']);
			$('#modalBodyLg').html(modalHtml);
			$("#generic_modal_lg").modal();				
		}
	});
}

