var Index = function () {
	/*
    // function to initiate Chart 2
    var runChart2 = function (response) {
       var data_pie = [];
		series = Math.floor(Math.random() * 6) + 3;
		data_pie[0] = {
			label: "Paid",
			data: (response.totalPaidNo*response.totalBillNo)/100,
			color: '#3c763d',
		};
		data_pie[1] = {
			label: "Due",
			data: (response.totalDueNo*response.totalBillNo)/100,
			color: '#a94442',
		};
		
        $.plot('#placeholder-h2', data_pie, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    tilt: 0.5,
                    label: {
                        show: true,
                        radius: 1,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.8
                        }
                    },
                    combine: {
                        color: '#999',
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: true
            }
        });

        function labelFormatter(label, series) {
            return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }
    };
     // function to initiate Sparkline
	var runCategories = function (response) {
         var data_category = [];
		$.each(response.wardWiseCustomer , function (k,value){
			//alert(value.no_of_customer);
			data_category[k] = ["Ward "+value.ward.name, value.no_of_customer];
		});
		
        $.plot("#placeholder5", [data_category], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.6,
                    align: "center",
                    fillColor: "#398439",
                    lineWidth: 0,
                }
            },
            xaxis: {
                mode: "categories",
                tickLength: 0
            }
        });
    };
	
	*/
	
	var setDashboardRegistrationContent = function(data){
		var registere_div_html = `
			<div class="col-sm-6 col-md-3">
				<div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card card-btm-border card-shadow-primary border-primary">
					<div class="widget-chat-wrapper-outer">
						<div class="widget-chart-content"><h6 class="widget-subheading">Registered </h6>
							<div class="widget-chart-flex">
								<div class="widget-numbers mb-0 w-100">
									<div class="widget-chart-flex">
										<div class="fsize-4">				
											`+(parseFloat(data['selfRegistered'])+parseFloat(data['selfRegistered']))+`
										</div>
										<div class="ml-auto">
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
												<small  class="text-default pl-2 text-small">Admin: <b>	`+data['adminRegistered']+`</b></small >
											</div>
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">						
												<small  class="text-default pl-2">Self:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>`+data['selfRegistered']+`</b></small >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-primary border-warning card ">
					<div class="widget-chat-wrapper-outer">
						<div class="widget-chart-content"><h6 class="widget-subheading">Enrolled </h6>
							<div class="widget-chart-flex">
								<div class="widget-numbers mb-0 w-100">
									<div class="widget-chart-flex">
										<div class="fsize-4">				
										`+(data['selfEnrolled']+data['adminEnrolled'])+`
										</div>
										<div class="ml-auto">
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
												<small  class="text-default pl-2 text-small">Admin: <b>`+data['adminEnrolled']+`</b></small >
											</div>
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">						
												<small  class="text-default pl-2">Self:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>`+data['selfEnrolled']+`</b></small >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-primary border-success card ">
					<div class="widget-chat-wrapper-outer">
						<div class="widget-chart-content"><h6 class="widget-subheading">Pending Enrolled </h6>
							<div class="widget-chart-flex">
								<div class="widget-numbers mb-0 w-100">
									<div class="widget-chart-flex">
										<div class="fsize-4">				
										`+(data['selfPending']+data['adminPending'])+`
										</div>
										<div class="ml-auto">
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
												<small  class="text-default pl-2 text-small">Admin: <b>`+data['adminPending']+`</b></small >
											</div>
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">						
												<small  class="text-default pl-2">Self:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>`+data['selfPending']+`</b></small >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-primary border-danger card ">
					<div class="widget-chat-wrapper-outer">
						<div class="widget-chart-content"><h6 class="widget-subheading">Dropout </h6>
							<div class="widget-chart-flex">
								<div class="widget-numbers mb-0 w-100">
									<div class="widget-chart-flex">
										<div class="fsize-4">				
										`+data['dropout']+`
										</div>
										<div class="ml-auto">
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
												&nbsp;
											</div>
											<div class="widget-title ml-auto font-size-lg font-weight-normal text-muted">						
												&nbsp;
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>`;
		$('#registered_div').html(registere_div_html);
	}

	var setDashboardPaymentScheduleContent = function(data){
		var payment_schedule_div_html = `
			<div class="main-card mb-3 card bg-default">
				<div class="no-gutters row">
					<div class="col-md-4 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-right ml-0 mr-3">
									<div class="widget-numbers text-success">`+data['schedulePaymentsNo']+`</div>
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">No. of Scheduled Payments</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-right ml-0 mr-3">
									<div class="widget-numbers text-warning">`+data['receivedPaymetsNo']+`</div>
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">No of Received Payments</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-right ml-0 mr-3">
									<div class="widget-numbers text-danger">`+data['duePaymentsNo']+`</div>
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">No. of Due Payments</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>`;
		$('#payment_schedule_div').html(payment_schedule_div_html);
	}

	var setDashboardRegistrationbarchartContent = function(data){
		if (document.getElementById('dashboard-chart')) {
			if(!jQuery.isEmptyObject(data)){
				lebels_arr 		= new Array();
				registered_arr 	= new Array();
				enrolled_arr 	= new Array();
				$.each(data, function(month,students){  
					lebels_arr.push(month);
					let students_arr = students.split('*');
					registered_arr.push(parseFloat(students_arr[0]));
					enrolled_arr.push(parseFloat(students_arr[1]));
				});
			}
			
			var barchartOptions = {
				chart: {
					height: 397,
					type: 'line',
					toolbar: {
						show: false,
					}
				},
				series: [{
					name: 'Registered Students',
					type: 'column',
					data: registered_arr //[402, 12, 30, 40, 80, 22, 70, 10, 21, 01, 40, 45]
				}, {
					name: 'Enrolled Students',
					type: 'line',
					data: enrolled_arr //[409, 12, 25, 40, 80, 13, 60, 10, 21, 01, 30, 45]
				}],
				stroke: {
					width: [0, 4]
				},
				labels: lebels_arr, //["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				//labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
				xaxis: {
					type: 'category'
				},
				yaxis: [{
					title: {
						text: 'Registered Students',
					},
			
				}, {
					opposite: true,
					title: {
						text: 'Enrolled Students'
					}
				}]
			
			};
			var dashboardBarChart = new ApexCharts(document.querySelector("#dashboard-chart"),barchartOptions);
            dashboardBarChart.render();
        }
	}

	var setDashboardFinancialStatusContent = function(data){
		let collection_div_html = `
			<div class="widget-subheading">Collections</div>
			<div class="widget-numbers text-success"><span>`+data['collections']+`</span></div>
			<div class="widget-description text-focus">
				Due
				<span class="text-danger pl-1">
					<span class="pl-1">`+data['scheduleAmount']+`</span>
				</span>
			</div>
		`;
		$('#collection_div').html(collection_div_html);

		let expense_div_html = `
			<div class="widget-subheading">Expenses</div>
			<div class="widget-numbers text-danger"><span>`+data['expenses']+`</span></div>
			<div class="widget-description opacity-8 text-focus">
				Paid
				<span class="text-info pl-1 pr-1">
				<span class="pl-1">`+data['totalPayment']+`</span>
				</span>
			</div>
		`;
		$('#expense_div').html(expense_div_html);


		$('#collection_percentage').circleProgress({
			value: data['collectionsRatio'],
			size:90,
			lineCap: 'round',
			fill: {gradient: ['#3ac47d', '#3ac47d']}
	
		}).on('circle-animation-progress', function (event, progress, stepValue) {
			$(this).find('small').html('<span>' + stepValue.toFixed(2).substr(2) + '%<span>');
		});
	

		$('#paid_percentage').circleProgress({
			value: data['expensesPaymentRatio'],
			size: 90,
			lineCap: 'round',
			fill: {gradient: ['#ff1e41', '#ff8130']}	
		}).on('circle-animation-progress', function (event, progress, stepValue) {
			$(this).find('small').html('<span>' + stepValue.toFixed(2).substr(2) + '%<span>');
		});
	}

	var setDashboardRegisteredStudentsContent = function(data){
		var reg_student_table_html = ``;
		if(!jQuery.isEmptyObject(data)){
			$.each(data, function(i,student){  
				let register_type_html = (student['register_type']=='Admin')?"<div class='badge badge-pill badge-success'>Admin</div>":"<div class='badge badge-pill badge-info'>Self</div>";
				
				reg_student_table_html +=`
					<tr>									
						<td class="text-center">`+student['student_no']+`</td>
						<td class="text-left"><a href="javascript:void(0)" onclick="studentView(`+student['id']+`)">`+student['name']+`</a></td>
						<td class="text-left">`+student['email']+`</td>
						<td class="text-left">`+student['contact_no']+`	</td>
						<td class="text-center">`+register_type_html+`</td>
					</tr>`;
			});
		}
		$('#reg_student_table tbody').html(reg_student_table_html);
	}
	
	var setDashboardEnrolledStudentsContent = function(data){
		var enrolled_student_table_html = ``;
		if(!jQuery.isEmptyObject(data)){
			$.each(data, function(i,student){  
				let status_html = (student['status']=='Pending')?"<div class='badge badge-pill badge-danger'>Pending</div>":"<div class='badge badge-pill badge-success'>Enrolled</div>";
				
				enrolled_student_table_html +=`
					<tr>							
						<td class="text-left"><a href="javascript:void(0)"  onclick="studentView(`+student['student_id']+`)">`+student['student_name']+`</a></td>
						<td class="text-center">`+student['student_enrollment_id']+`</td>
						<td class="text-left"><a href="javascript:void(0)"  onclick="batchView(`+student['batch_id']+`)">`+student['course']+`</a></td> 
						<td class="text-center">`+status_html+`</td>
					</tr>`;
			});
		}
		$('#enrolled_student_table tbody').html(enrolled_student_table_html);
	}

	var setDashboardPaymentsStudentsContent = function(data){
		var paymet_table_html = ``;
		if(!jQuery.isEmptyObject(data)){
			$.each(data, function(i,payment){  
				let status_html = (payment['paid_type']=='Cash')?"<div class='badge badge-pill badge-success'>Cash</div>":"<div class='badge badge-pill badge-warning'>"+payment['paid_type']+"</div>";
				
				paymet_table_html +=`
					<tr>							
						<td class="text-left"><a href="javascript:void(0)"  onclick="studentView(`+payment['student_id']+`)">`+payment['student_name']+`</a></td>
						<td class="text-left"><a href="javascript:void(0)"  onclick="batchView(`+payment['batch_id']+`)">`+payment['course']+`</a></td>
						<td class="text-center">`+status_html+`</td>
						<td class="text-right">`+payment['paid_amount']+`</td>
					</tr>`;
			});
		}
		$('#paymet_table tbody').html(paymet_table_html);
	}

	var setDashboardUpcomingBatchesContent = function(data){
		var upcoming_batch_table_html = ``;
		if(!jQuery.isEmptyObject(data)){
			$.each(data, function(i,payment){  
				upcoming_batch_table_html +=`
					<tr>							
						<td class="text-left"><a href="javascript:void(0)"  onclick="batchView(`+payment['batch_id']+`)">`+payment['course']+`</a></td>
						<td class="text-center">`+payment['batch_name']+`</td>
						<td class="text-center">`+payment['start_date']+`</td>
						<td class="text-right">`+payment['fee']+`</td>
					</tr>`;
			});
		}
		$('#upcoming_batch_table tbody').html(upcoming_batch_table_html);
	}

	return {
        init: function () {
			$.ajax({
				url: url+'/dashboard-content/'+$('#select_report_period').val(),
				cache: false,
				success: function(response){
					var response 	= JSON.parse(response);
					var data		= response['data'];
					if(typeof data['registrationInfo'] !== 'undefined') setDashboardRegistrationContent(data['registrationInfo']);
					if(typeof data['paymentScheduleInfo'] !== 'undefined') setDashboardPaymentScheduleContent(data['paymentScheduleInfo']);

					if(typeof data['studentRegistrationBarchartData'] !== 'undefined') setDashboardRegistrationbarchartContent(data['studentRegistrationBarchartData']);
					if(typeof data['financialStatusInfo'] !== 'undefined') setDashboardFinancialStatusContent(data['financialStatusInfo']);

					if(typeof data['registeredStudents'] !== 'undefined') setDashboardRegisteredStudentsContent(data['registeredStudents']);
					if(typeof data['enrolledStudents'] !== 'undefined') setDashboardEnrolledStudentsContent(data['enrolledStudents']);
					if(typeof data['payments'] !== 'undefined') setDashboardPaymentsStudentsContent(data['payments']);
					if(typeof data['upcomingBatches'] !== 'undefined') setDashboardUpcomingBatchesContent(data['upcomingBatches']);

					// runChart2(data);
					// runCategories(data);
				}
			});
        }
    };
}();