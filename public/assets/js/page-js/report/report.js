
$(document).ready(function () {

	$("#expense_name").autocomplete({
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/expense-autosuggest',
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
		appendTo : $('#entry_form_div'),
		minLength: 2,
		select: function(event, ui) {
			var id = ui.item.id;
			$(this).next().val(id);
		},
		change: function( event, ui ) {
			$(this).next().val( ui.item? ui.item.id : '' );
		}
	});
	$("#expense_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
	});

	$("#student_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/student-autosuggest',
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
	$("#student_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
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
	});

	
	$("#course_name").autocomplete({ 
		search: function() {		
		},
		source: function(request, response) {
			$.ajax({
				url: url+'/course-autosuggest/Admin',
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
			$(this).next().val(id);
		},
	});
	$("#course_name").on('click',function(){ 
		$(this).val("");
		$(this).next().val("");
	});


	

	$("#show_course_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Course Status  ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}

		course_datatable = $('#course_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						/*$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
						 */
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/course-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
				}
			},
			"aoColumns": [			
				{ mData: 'code', className: "text-center"},			
				{ mData: 'title' },						
				{ mData: 'noOfbatches', className: "text-center"},		
				{ mData: 'noOfstudents', className: "text-center"},	
				{ mData: 'noOfUnits', className: "text-center"},
				{ mData: 'tqt' , className: "text-center"},
				{ mData: 'level' , className: "text-center" },
				{ mData: 'glh' , className: "text-center"},		
			]
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_batch_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Batch Status  ';
		if($.trim($('#course_name').val()) != ""){
			report_heading += " of "+$('#course_name').val();
		}
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#running_status').val()) != "" && $.trim($('#running_status').val()) != "All" ){
			report_heading += " Status: "+$('#running_status').val();
		}

		batch_datatable = $('#batch_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/batch-report",
				"type": "POST",
				"data" : {
					"course_id": $("#course_id").val(),
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"running_status":$('#running_status').val(),
				}
			},
			"aoColumns": [			
				{ mData: 'batch_name'},			
				{ mData: 'course_name'},		
				{ mData: 'start_date' , className: "text-center"},		
				{ mData: 'end_date' , className: "text-center"},		
				{ mData: 'student_limit' , className: "text-center"},		
				{ mData: 'total_enrolled_student' , className: "text-center"},		
				{ mData: 'total_pending_student' , className: "text-center"},		
				{ mData: 'batch_fee' , className: "text-center" },		
				{ mData: 'running_status' , className: "text-center"},			
			]
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_student_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Batch Status  ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#type').val()) != "All"){
			report_heading += " Type: "+$('#type').val();
		}
		if($.trim($('#study_mode').val()) != "All"){
			report_heading += " Study Mode: "+$('#study_mode').val();
		}
		if($.trim($('#register_type').val()) != "All"){
			report_heading += " Registered: "+$('#register_type').val();
		}
		if($.trim($('#status').val()) != "All"){
			report_heading += " Status: "+$('#status').val();
		}

		student_datatable = $('#student_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/student-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"type":$('#type').val(),
					"register_type":$('#register_type').val(),
					"study_mode":$('#study_mode').val(),
					"status":$('#status').val(),
				}
			},
			"aoColumns": [			
				{ mData: 'student_no', className: "text-center"},			
				{ mData: 'first_name'},		
				{ mData: 'email' },		
				{ mData: 'contact_no' , className: "text-center"},		
				{ mData: 'emergency_contact' , className: "text-center"},		
				{ mData: 'nid_no' , className: "text-center"},		
				{ mData: 'date_of_birth' , className: "text-center" },		
				{ mData: 'study_mode' , className: "text-center"},
				{ mData: 'type' , className: "text-center"},
				{ mData: 'register_type' , className: "text-center"},				
				{ mData: 'status' , className: "text-center"},		
			]
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_payment_schedule_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Payment schedule report  ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#student_name').val()) != ""){
			report_heading += " Student: "+$('#student_name').val();
		}
		if($.trim($('#batch_name').val()) != ""){
			report_heading += " Course: "+$('#batch_name').val();
		}
		if($.trim($('#payment_status').val()) != "All"){
			report_heading += " Payment Status: "+$('#payment_status').val();
		}

		payment_schedule_datatable = $('#payment_schedule_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/payment-schedule-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"student_id":$('#student_id').val(),
					"batch_id":$('#batch_id').val(),
					"payment_status":$('#payment_status').val(),
				}
			},
			"aoColumns": [			
				{ mData: 'student_name',},			
				{ mData: 'course_name'},		
				{ mData: 'installment' , className: "text-center"},		
				{ mData: 'payment_month' , className: "text-center"},		
				{ mData: 'paid_date' , className: "text-center"},		
				{ mData: 'payment_status' , className: "text-center"},		
				{ mData: 'payable_amount' , className: "text-right" },					
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};	 
				// Total over this page
				data = api.column( 6, { page: 'current'} ).data();
				pageTotal = data.length ?
					data.reduce( function (a, b) {
							return intVal(a) + intVal(b);
					} ) :
					0;
	 
				// Update footer
				$( api.column( 6 ).footer() ).html(pageTotal);
			}
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_payment_collection_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Payment Collection ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#student_name').val()) != ""){
			report_heading += " Student: "+$('#student_name').val();
		}
		if($.trim($('#batch_name').val()) != ""){
			report_heading += " Course: "+$('#batch_name').val();
		}

		payment_collection_datatable = $('#payment_collection_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/payment-collection-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"student_id":$('#student_id').val(),
					"batch_id":$('#batch_id').val(),
				}
			},
			"aoColumns": [			
				{ mData: 'student_name',},			
				{ mData: 'course_name'},		
				{ mData: 'installment' , className: "text-center"},		
				{ mData: 'payment_month' , className: "text-center"},		
				{ mData: 'paid_date' , className: "text-center"},		
				{ mData: 'paid_type' , className: "text-center"},	
				{ mData: 'paid_by' , className: "text-center"},	
				{ mData: 'reference_no' , className: "text-center"},		
				{ mData: 'invoice_no' , className: "text-center"},				
				{ mData: 'paid_amount' , className: "text-right" },					
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};	 
				// Total over this page
				data = api.column( 9, { page: 'current'} ).data();
				pageTotal = data.length ?
					data.reduce( function (a, b) {
							return intVal(a) + intVal(b);
					} ) :
					0;
	 
				// Update footer
				$( api.column( 9 ).footer() ).html(pageTotal);
			}
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_schedule_collection_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Schedule Vs Collection ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#student_name').val()) != ""){
			report_heading += " Student: "+$('#student_name').val();
		}
		if($.trim($('#batch_name').val()) != ""){
			report_heading += " Course: "+$('#batch_name').val();
		}

		schedule_collection_datatable = $('#schedule_collection_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/schedule-collection-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"student_id":$('#student_id').val(),
					"batch_id":$('#batch_id').val(),
				}
			},
			"aoColumns": [			
				{ mData: 'student_name',},			
				{ mData: 'course_name'},		
				{ mData: 'installment' , className: "text-center"},		
				{ mData: 'payment_month' , className: "text-center"},		
				{ mData: 'paid_date' , className: "text-center"},		
				{ mData: 'paid_type' , className: "text-center"},	
				{ mData: 'paid_by' , className: "text-center"},			
				{ mData: 'invoice_no' , className: "text-center"},			
				{ mData: 'payment_status' , className: "text-center"},		
				{ mData: 'payable_amount' , className: "text-right" },			
				{ mData: 'paid_amount' , className: "text-right" },					
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};	 
				// Total over this page
				data = api.column( 8, { page: 'current'} ).data();
				payablePageTotal = data.length ?data.reduce( function (a, b) {	return intVal(a) + intVal(b);} ) :0;data = api.column( 9, { page: 'current'} ).data();
				pageTotal = data.length ?data.reduce( function (a, b) {	return intVal(a) + intVal(b);} ) :0;	 
				// Update footer
				$( api.column( 8 ).footer() ).html(payablePageTotal);
				$( api.column( 9 ).footer() ).html(pageTotal);
			}
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_expense_status_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Expense Status  ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#expense_head_id').val()) != ""){
			report_heading += " expense head:  "+$('#expense_name').val();
		}
		if($.trim($('#expense_category_id').val()) != ""){
			report_heading += " ("+$('#expense_category_id').val()+")";
		}
		expense_datatable = $('#expense_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/expense-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"expense_head_id":$("#expense_head_id").val(),
					"expense_category_id":$("#expense_category_id").val(),
				}
			},
			"aoColumns": [			
				{ mData: 'category'},			
				{ mData: 'head' },
				{ mData: 'date'},
				{ mData: 'details' },
				{ mData: 'payment_status'},
				{ mData: 'amount', className: "text-right"},			
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};	 
				// Total over this page
				data = api.column( 5, { page: 'current'} ).data();
				pageTotal = data.length ?
					data.reduce( function (a, b) {
							return intVal(a) + intVal(b);
					} ) :
					0;
	 
				// Update footer
				$( api.column( 5 ).footer() ).html(pageTotal);
			}
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_expense_income_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Expense Vs Income  ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		
		expense_income_table = $('#expense_income_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( 'font-size', 'inherit' );
					}
				}
			],
			"order": [[ 0, 'asc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/expense-income",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
				}
			},
			"aoColumns": [			
				{ mData: 'serial'},			
				{ mData: 'month' },
				{ mData: 'income' , className: "text-right"},
				{ mData: 'expense' , className: "text-right"},				
				{ mData: 'balance' , className: "text-right"},			
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};	 
				// Total over this page
				data = api.column( 2, { page: 'current'} ).data();
				expenseTotal = data.length ?
					data.reduce( function (a, b) {
							return intVal(a) + intVal(b);
					} ) :
					0;
				data = api.column( 3, { page: 'current'} ).data();
				incomeTotal = data.length ?
					data.reduce( function (a, b) {
							return intVal(a) + intVal(b);
					} ) :
					0;
				data = api.column( 4, { page: 'current'} ).data();
				balanceTotal = data.length ?
					data.reduce( function (a, b) {
							return intVal(a) + intVal(b);
					} ) :
					0;
	 
				// Update footer
				$( api.column( 2 ).footer() ).html(incomeTotal);
				$( api.column( 3 ).footer() ).html(expenseTotal);
				$( api.column( 4 ).footer() ).html(balanceTotal);
			}
		});
			
		$('#report-data').css('display','block');
	});

	$("#show_financial_report").on('click',function(){
		event.preventDefault();
		var report_heading = 'Schedule Vs Collection ';
		if($.trim($('#from_date').val()) != ""){
			report_heading += " from "+$('#from_date').val();
		}
		if($.trim($('#to_date').val()) != ""){
			report_heading += " To "+$('#to_date').val();
		}
		if($.trim($('#student_name').val()) != ""){
			report_heading += " Student: "+$('#student_name').val();
		}
		if($.trim($('#batch_name').val()) != ""){
			report_heading += " Course: "+$('#batch_name').val();
		}

		financial_datatable = $('#financial_table').DataTable({
			destroy: true,
			dom: 'Bfrtip',
			'paging': false,
			buttons: [
				{
					extend: 'excel',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'pdf',
					messageTop: report_heading,
					footer: true 
				},
				{
					extend: 'print',
					messageTop: "<h5>"+report_heading+"<br><p>&nbsp;</p></h5>",
					footer: true ,
					customize: function ( win ) {
						$(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.body).find('h1').next('div').css('text-align', 'center');
						$(win.document.body)
							.css( 'font-size', '10pt' )
							.prepend(
								'<img src="'+fade_logo_url+'" style="position:absolute; top:42%; left:39%;" />'
							);
	 
						$(win.document.body).find( 'table' )
							.addClass( 'compact' )
							.css( {
								//color: '#FF0000',
								//margin: '20px'
								/* Etc CSS Styles..*/
							} );
						$(win.document.body).find( 'td' )
						.css( {
							//border: '1px solid #FF0000',
							/* Etc CSS Styles..*/
						} );
					}
				}
			],
			"order": [[ 0, 'desc' ]],
			"processing": true,
			"serverSide": false,
			"ajax": { 
				"url" : url+"/financial-report",
				"type": "POST",
				"data" : {
					"from_date": $("#from_date").val(),
					"to_date":$("#to_date").val(),
					"student_id":$('#student_id').val(),
					"batch_id":$('#batch_id').val(),
				}
			},
			"aoColumns": [			
				{ mData: 'student_id',},			
				{ mData: 'course_name'},		
				{ mData: 'payable_amount' , className: "text-right"},		
				{ mData: 'paid_amount' , className: "text-right"},		
				{ mData: 'due_amount' , className: "text-right"},		
				{ mData: 'payment_type' , className: "text-center"},					
			],     
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};	 
				// Total over thi s page
				data = api.column(2, { page: 'current'} ).data();
				payableTotal = data.length ?data.reduce( function (a, b) {	return intVal(a) + intVal(b);} ) :0;

				data = api.column( 3, { page: 'current'} ).data();
				paidTotal = data.length ?data.reduce( function (a, b) {	return intVal(a) + intVal(b);} ) :0;

				data = api.column( 4, { page: 'current'} ).data();
				dueTotal = data.length ?data.reduce( function (a, b) {	return intVal(a) + intVal(b);} ) :0;
				// Update footer
				$( api.column( 2).footer() ).html(payableTotal);
				$( api.column( 3 ).footer() ).html(paidTotal);
				$( api.column( 4 ).footer() ).html(dueTotal);
			}
		});
			
		$('#report-data').css('display','block');
	});


	$("#clear_button").on('click',function(){
		clear_form();
	});

});

