$(document).ready(function () {
    
    bookEdit = function bookEdit(bookId){
        $('#edit_id').val(bookId);
        $('#book_name').val($('#book_name_'+bookId).html());
    }  
    
    showBooks = function showBooks(){
        if($('#batch_id').val()!=""){
            $("#edit_id").val('');
            $("#form-title").html('<i class="fa fa-plus"></i> Add  New Book');
            $('#entry-form').modal('show');
            $.ajax({
                url: url+"/batch-books/"+$('#batch_id').val(),
                type:'get',
                async:false,
                success: function(data){
                    var bookHtml = "";
                    if(!jQuery.isEmptyObject(data)){
                        $.each(data, function(i,book){ 
                            bookHtml += `
                                <tr>
                                    <td id="book_name_`+book['id']+`">`+book['name']+`</td>
                                    <td class="tect-center">`+book['status']+`</td>
                                    <td class="tect-center">`+book['action']+`</td>
                                </tr>`;
                        })
                        $('#books_table>tr').remove();
                        $('#books_table').append(bookHtml);
                    }
                }
            });
        }
         // books_table
    }
    

	exportSampleBook = function exportSampleBook(type){
		if($('#batch_id').val()!=""){
			window.open(window.location.href = url+"/book-csv/"+$('#batch_id').val()+"/"+type, '_blank');
        }
	}	

	uploadBook = function uploadBook(){
		$('#upload-book-form').modal('show');
	}	

	$("#save_csv").on('click',function(event){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#csv_form')[0]);
       
		// if($.trim($('#feedback_details').val()) == "" || $.trim($('#student_book_id').val()) == ""){
		// 	success_or_error_msg('#form_submit_error','danger',"Please put details","#feedback_details");
		// }
		// else{
		$.ajax({
			url: url+"/book-csv-upload",
			type:'POST',
			data:formData,
			async:false,
			cache:false,
			contentType:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response['response_code'] == 0){
					success_or_error_msg('#form_csv_submit_error','danger',response['errors'],"");
				}
				else{
					$('#upload-book-form').modal('hide');
					$("#show_batch_books").trigger('click');
				}					
			}
		});
		//}
	});

	
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
        $('#add_books').css('display','none');	
			
        $('#edit_id').val('');
        $('#book_name').val('');
        $('#books_table>tr').remove();
        $('#batch_books_div').css('display','none');
    });

    addFeedback = function addFeedback(studentBookId){
        $("#student_book_id").val(studentBookId);
        $('#feedback-form').modal('show');
    }

    $("#save_feedback").on('click',function(){
		event.preventDefault();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}
		});

		var formData = new FormData($('#feedback_form')[0]);
       
		if($.trim($('#feedback_details').val()) == "" || $.trim($('#student_book_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please put details","#feedback_details");
		}
		else{
			$.ajax({
				url: url+"/feedback",
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
                        $('#feedback-form').modal('hide');
                        $("#show_batch_books").trigger('click');
                    }					
				 }
			});
		}
	});
    

    sendBook = function sendBook(student_book_id){
        swal({
			title: "Confirm?",
			text: "You want to change the book sending status!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: url+'/book-send/'+student_book_id,
					cache: false,
					success: function(data){
						var response = JSON.parse(data);
						if(response['response_code'] == 0){
							toastr['error']( response['errors'], 'Faild!!!');
						}
						else{
							toastr['success']( response['message'], 'Success!!!');
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


	$("#show_batch_books").on('click',function(){
        if($('#batch_id').val()!=""){
            $('#add_books').css('display','block');	
            $.ajax({
                url: url+"/student-books/"+$('#batch_id').val(),
                type:'get',
                async:false,
                success: function(data){
                    $('#batch_books_table_div').html(data);
                }
            });
            $('#batch_books_div').css('display','block');
        }else{
            $('#add_books').css('display','none');					
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

    $("#student_books_table_search").on('keyup',function(){
          // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("student_books_table_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("student_books_table");
        tr = table.getElementsByTagName("tr");
      
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
    });
    
});
