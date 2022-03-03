$(document).ready(function () {
    
    bookEdit = function bookEdit(bookId){
        event.preventDefault();
        alert(bookId);
        $('#edit_id').val(bookId);
        $('#book_name').val($('#book_name_'+bookId).html());
    }
    
    
    
    showBooks = function showBooks(){
        if($('#batch_id').val()!=""){
            $("#clear_button").trigger('click');
            $("#form-title").html('<i class="fa fa-plus"></i> Add  New Book');
            $("#save_book").html('Save');
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
                                    <td>`+book['status']+`</td>
                                    <td >`+book['action']+`</td>
                                </tr>`;
                        })
                        $('#books_table').append(bookHtml);
                    }
                }
            });
        }
         // books_table
    }

    
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
    
	$("#show_batch_books").on('click',function(){
        if($('#batch_id').val()!=""){
            $('#add_books').css('display','block');
            
            /* 
            batch_books_datatable = $('#payments_table').DataTable({
                destroy: true,
                "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": false,
                "ajax": { 
                    "url" : url+"/payments",
                    "type": "POST",
                    "data" : {
                        "search_from_date": $("#search_from_date").val(),
                        "search_to_date":$("#search_to_date").val(),
                        "search_student_id":$('#search_student_id').val(),
                        "search_batch_id":$('#search_batch_id').val(),
                    }
                },
                "aoColumns": [
                    { mData: 'id'},
                    { mData: 'student_name'},
                    { mData: 'course_name' },
                    { mData: 'batch_name' ,  className: "text-center"},
                    { mData: 'installment', className: "text-center"},
                    { mData: 'payment_month', className: "text-center"},
                    { mData: 'paid_date', className: "text-center"},
                    { mData: 'payment_status', className: "text-center"},			
                    { mData: 'paid_amount', className: "text-right"},
                    { mData: 'actions', className: "text-left"},
                ],
                "columnDefs": [
                    { "targets": [ 0 ],  "visible": false },
                    { "width": "120px", "targets":[ 8 ]},
                ],
                "initComplete": function () {
                    this.api().columns().every( function (key) {
                        var column = this;		
                        if( column[0] == 3 || column[0] == 5 ||  column[0] == 7  ){
                            var select = $('<select><option value=""></option></select>')
                                .appendTo( $(column.header()) )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            });
        */
            $('#batch_books_table').css('display','block');
            $('#no_book_div').css('display','block');
            


        }else{
            $('#add_books').css('display','none');
            $('#no_book_div').css('display','none');
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
                        // load grid

                    }					
				 }
			});
		}
	});
});
