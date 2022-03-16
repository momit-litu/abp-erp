
//All the common view 

//Invoice details view
paymentInvoice = function paymentInvoice(id){	
    $.ajax({
        url: url+'/payment/'+id,
        cache: false,
        success: function(response){
            var response = JSON.parse(response);
            var data = response['payment'];
            var settings = response['settings'];
            var invoiceDetails = response['invoiceDetails'];
            var modalHtml = "";
            var invoiceHtml =
            `<div class="modal-body printable" id="modalBody">
                <table class="discount" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                <td>
                    <img  class="f-fallback email-masthead_name"src="`+logo+`" style="max-width:140px" /> 
                    </td>
                <td align="right">
                    <h1 class="align-right" style="text-transform:uppercase">Money Receipt</h1>
                </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right">                                   
                            <p class="align-right" >`+settings['company_name']+`<br>
                            `+settings['address']+`<br>
                            Mobile : +880`+settings['admin_mobile']+`<br>
                            www.abpbd.org</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                <td colspan="2">
                    <table class="" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="" align="left">
                        <p >Bill to,<br>
                            `+data['student_name']+`
                        <br>Registration No : 
                        `+data['student_no']+`
                        <br>
                            `+data['student_email']+`,<br>
                            `+data['address']+`
                        </p>
                        </td>
                        <td class=""  colspan="2" align="right">
                        <p  style="text-align:right !important">
                            Invoice Number :  `+data['invoice_no']+`<br>                                
                            Invoice Date :  `+data['paid_date']+`<br>
                           Payment Due  :   `+data['last_payment_date']+`<br>
                           <!--  <b>Amount Due (BDT):   ৳ `+data['paid_amount']+`</b> -->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <th class="" align="left">
                        <p ><b>Course</b></p>
                        </th>
                        <th class="" align="center">
                            <p ><b>Course Fee</b></p>
                        </th>
                        <th class="" align="right">
                        <p  style="text-align:right !important"><b>Amount</b></p>
                        </th>
                    </tr>
                    <tr>
                        <td width="50%" class="" ><span >`+data['only_course_name']+`</span><br> Batch :`+data['batch_name']+`<br>Enrollment ID: `+data['batch_student_enrollment_id']+`</td>
                        <td width="20%" align="right" class="purchase_item" ><span>৳ `+invoiceDetails['actual_fees']+`</span></td>
                        <td class="align-right" width="20%" align="right" ><span >৳ `+invoiceDetails['actual_fees']+`</span></td>
                    </tr> `; 

                    if(invoiceDetails['discount']>0)
                        invoiceHtml +=`<tr>
                            <td width="50%" class="" ><span >Discount</span></td>
                            <td width="20%" align="right" class="purchase_item" ><span>(৳ `+invoiceDetails['discount']+`)</span></td>
                            <td class="align-right" width="20%" align="right" ><span >(৳ `+invoiceDetails['discount']+`)</span></td>
                        </tr> `;
7
                    invoiceHtml +=` <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><b>Total</b></td>
                        <td class="align-right" width="20%" align="right" ><span >৳ `+invoiceDetails['total_payable']+`</span></td>
                    </tr>`;
                    if(!jQuery.isEmptyObject(invoiceDetails['payments'])){
                        $.each(invoiceDetails['payments'], function(i,payment){ 
                            if(payment['payment_status'] == 'Paid'){
                                invoiceHtml += `<tr>
                                    <td colspan="2" align="right"><p>Payment of `+payment['paid_date']+`</p></td>
                                    <td class="align-right" width="20%" align="right" ><span >৳ `+payment['paid_amount']+`</span></td>
                                </tr>`;
                            }
                        });
                    }
                invoiceHtml +=` <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><b>Amount Due (BDT)</b></td>
                        <td class="align-right" width="20%" align="right" ><b >৳ `+invoiceDetails['balance']+`</b></td>
                    </tr>
                `;                        
                invoiceHtml +=` </table>
                </td>
                </tr>
                <tr>
                <td colspan="2"> 
                    <br>
                    <br> 
                    <p style="text-align:left !important; font-size:12px">
                    Notes/Terms:<br>
                    1. Fees are not refundable.<br>
                    2. Course fees are not transferable.<br>
                    3. Course registration is valid for 12 months (PGD), for short course 4 months 
                    </p>
                </td>
                </tr>
                <tr>
                <td colspan="2"> 
                    <br>
                    <br> 
                    <p style="text-align:center !important; font-size:12px">No signature required for electronic invoice </p>
                </td>
                </tr>
            </table>
            </div>
            `;	
            
            $('#myModalLabelLg').html("Invoice #"+data['invoice_no']);
            $('#modalBodyLg').html(invoiceHtml);
            if(user_type == 'Admin'){
                $('.print-button-lg').show();
                $('.email-button-lg').show();
                $('.download-button-lg').show();
            }            
            $('.email-button-lg').attr('onClick','emailInvoice('+id+')')
            $('.download-button-lg').attr('onClick','downloadInvoice('+id+')')
            $("#generic_modal_lg").modal();

        }
    });
}

//email invoice to customer Module
emailInvoice = function emailInvoice(id){
    $.ajax({
        url: url+'/email/payment-invoice/'+id,
        cache: false,
        success: function(response){
            if(response){
                toastr['success']( 'Email Sent successfully', 'Success!!!');
            }
            else{					
                toastr['error']('Email not sent', 'Faild!!!');
            }
        }
    });
}

//download invoice

downloadInvoice = function downloadInvoice(id){
    window.open(url+'/download-invoice/'+id, '_blank');
    //window.location.href= url+'/download-invoice/'+id;
	
	/*$.ajax({
        url: url+'/download-invoice/'+id,
        cache: false,
        success: function(response){
				alert(response)
            if(response){
                toastr['success']( 'Email Sent successfully', 'Success!!!');
            }
            else{					
                toastr['error']('Email not sent', 'Faild!!!');
            }
        }
    });*/
}


//student detail View
studentView = function studentView(id){
    var user_id = id;
    $.ajax({
        url: url+'/student/'+user_id,
        success: function(response){
            var response = JSON.parse(response);
            console.log(response)
            var data = response['student'];

            $("#student-view-modal").modal();
            $("#student_number").html((data['student_no']!=null)?data['student_no']:"");
            $("#student_name_vw").html('<h5>'+data['name']+'</h5>');
            $("#student_contact").html(data['contact_no']);
            $("#student_emergency_contact").html(data['emergency_contact']);
            $("#email_div").html(data['email']);
            $("#student_DOB").html(data['date_of_birth']);
            $("#student_address").html(data['address']);

            $("#nid_div").html((data['nid_no']!=null)?data['nid_no']:"");
            $("#current_emplyment_div").html((data['current_emplyment']!=null)?data['current_emplyment']:"")+" "+(data['current_emplyment']!=null)?data['current_designation']:"";
            $("#last_qualification_div").html(data['last_qualification']);
            $("#passing_year_div").html(data['passing_year']);

            if (data['remarks']!=null && data['remarks']!="") {
                $("#remarks_details").html('<b>Remarks:</b>'+data['remarks']);
            }
            else{
                $("#remarks_div").html('');
                $("#remarks_details").html("");
            }

            var course_list_html = "";
            if(!jQuery.isEmptyObject(response['courses'])){
                course_list_html +=`
                    <h6><b>Course Information</b></h6>
                    <table class="table table-bordered table-hover batches_table" style="width:100% !important">
                        <thead>
                            <tr> 									
                                <th>Course Title</th>	
                                <th>Batch</th>
                                <th class='text-center'>Enrollment ID</th>										
                                <th class="text-center">Start Date </th>
                                <th class="text-center">Semester</th>											
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>`;


                $.each(response['courses'], function(i,course){
                    course_list_html +=`
                            <tr> 									
                                <td>`+course['course_name']+`</td>	
                                <td>`+course['batch_name']+`</td>	
                                <td>`+course['student_enrollment_id']+`</td>										
                                <td class="text-center">`+course['start_date']+`</td>	
                                <td class="text-center">`+course['semester_no']+`</td>										
                                <td class="text-center">`+course['running_status']+`</td>	
                            </tr>
                    `;
                });
                course_list_html +=`
                        </tbody>
                    </table>
                `;
            }
            $("#course_list").html(course_list_html);
            //console.log(profile_image_url)
            if (data["user_profile_image"]!=null && data["user_profile_image"]!="") {
                $(".student_profile_image").html('<img style="width:100%" src="'+profile_image_url+'/'+data["user_profile_image"]+'" alt="User Image" class="img img-responsive">');
            }
            else{
                $(".student_profile_image").html('<img  style="width:100%" src="'+profile_image_url+'/user.png" alt="User Image" class="img img-responsive">');
            }

            if(data['status']=='Active'){
                $("#status_div").html('<span class="badge badge-success">Active</span>');
            }
            else{
                $("#status_div").html('<span class="badge badge-danger">In-active</span>');
            } //alert(profile_image_url);
            if(data['type']=='Enrolled'){
                $("#type_div").html('<span class="badge badge-info">Enrolled</span>');
            }
            else{
                $("#type_div").html('<span class="badge badge-warning">Non-Enrolled</span>');
            } //alert(student_document_url);
            var attachment_html = "";
            if(data['documents'].length >0){
                $.each(data['documents'], function(i,document){ 
                    attachment_html += "<a clas='formData' target='_blank'  href='"+student_document_url+"documents/"+document['document_name']+"' >"+document['document_name']+"</a><br>";
                });
            }
            $('#attachment_div').html(attachment_html);
            
        }
    });
}

// Student Payment History view
studentPayments = function studentPayments(id){
    var courseHtml = "";		
    var tab_content = "";
    $.ajax({
        url: url+'/payment-schedule/'+id,
        cache: false,
        success: function(response){
            var data = JSON.parse(response);
        //	var data = response['payments'];
            var modalHtml = "";
            if(!jQuery.isEmptyObject(data['batchStudents'])){
                $.each(data['batchStudents'], function(i,batch_student){ 
                    var installment_tr = "";
                    active= (i==0)?"active":"";
                    let tabVisibility = ( batch_student['current_batch'] == 'Transfered')?"d-none":"";
                    courseHtml += `
							<a data-toggle="tab" href="#tab-`+batch_student['id']+`" class="mr-1 ml-1 border-0 btn-transition `+active+` btn btn-outline-primary course-tab `+tabVisibility+`" id="course-tab-`+batch_student['id']+`">`+batch_student['batch']['course']['title']+`</a>												
						`;

                    if(!jQuery.isEmptyObject(batch_student['payments'])){
                        $.each(batch_student['payments'], function(j,payment){ 	
                            var invoice_no = (payment['invoice_no'] == null)?"":`<a href="javascript:void(0)" onclick="paymentInvoice(`+payment['id']+`)" >`+payment['invoice_no']+`</a>`;

                            var payment_status = (payment['payment_status']=='Paid')?"<button class='btn btn-xs btn-success' disabled>Paid</button>":"<button class='btn btn-xs btn-danger' disabled>Due</button>";
                            let installment_no_td = (payment['installment_no']==0)?"Transfer Fee":payment['installment_no'];
                            installment_tr += 
                            `<tr>
                                <th class="text-center">`+installment_no_td+`</th>
                                <td class="text-center">`+payment['last_payment_date']+`</td>
                                <td class="text-right">`+payment['payable_amount']+`</td>
                                <td class="text-center">`+invoice_no+`</td>
                                <th class="text-center">`+payment_status+`</th>
                            </tr>`;
                        });
                    }
                    
                    if( batch_student['batch']['running_status'] == 'Completed')
                        batch_status = " <button class='btn btn-xs btn-success' disabled>Completed</button>";
                    else if( batch_student['batch']['running_status'] == 'Running')
                        batch_status = " <button class='btn btn-xs btn-primary' disabled>Running</button>";
                    else
                        batch_status = " <button class='btn btn-xs btn-info' disabled>Upcoming</button>";

                    let transferedStatus = "";
                    if( batch_student['prev_batch_student_id'] != null){
                        transferedStatus = "<br><span class='text-danger text-uppercase'> Transfered from Batch <a data-toggle='tab' href='#tab-"+batch_student['prev_batch_student_id']+"' class='mr-1 ml-1 border-0 btn-transition btn btn-primary course-tab show' id='course-tab-"+batch_student['prev_batch_student_id']+"'>"+batch_student['prev_batch']['batch']['batch_name']+"</a></span>";
                    }
                    if( batch_student['current_batch'] == 'Transfered'){
                        transferedStatus = "<br><span class='text-danger text-uppercase'> Transfered</span>";
                    }

                    feeHtml = (batch_student['batch']['fees'] == batch_student['batch']['discounted_fees'])?`<span><b class="text-dark">`+batch_student['batch']['discounted_fees']+`</b></span>`:`<span class="pr-2"><b class="text-danger"><del>`+batch_student['batch']['fees']+`</del></b></span><span><b class="text-dark">`+batch_student['batch']['discounted_fees']+`</b></span>`;
                    
                    tab_content += `
                    <div class="tab-pane `+active+`" id="tab-`+batch_student['id']+`" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                                    <ul class="list-group list-group-flush">
                                        <li class="bg-warm-flame list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">					
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading text-dark opacity-7"><h6>`+batch_student['batch']['course']['code']+` - `+batch_student['batch']['course']['title']+`</h6></div>
                                                        <div class="widget-heading text-dark opacity-7">Batch `+batch_student['batch']['batch_name']+batch_status+transferedStatus+`</div>
                                                        <div class="widget-subheading opacity-10">Course Fee: `+feeHtml+`</div>
                                                    </div>												
                                                </div>
                                            </div>
                                        </li>
                                        <li class="p-0 list-group-item">
                                            <div class="grid-menu grid-menu-2col">
                                                <div class="no-gutters row">
                                                    <div class="col-sm-6">
                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-info">
                                                            <h5><strong>`+(batch_student['total_payable'])+`</strong></h5>
                                                            Payable Fee
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-success">
                                                            <h5><strong>`+batch_student['total_paid']+`</strong></h5>
                                                            Total Paid
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-danger">
                                                            <h5 ><strong>`+batch_student['balance']+`</strong></h5>
                                                            Balance
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">
                                                        <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link disabled text-danger">
                                                            <h5><strong>`+batch_student['payments'].length+`</strong></h5>
                                                            Installment
                                                        </button>
                                                    </div>												
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>								
                            </div>
                            <div class="col-md-6">
                                <table class="mb-0 table-bordered table table-sm ">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Inst. No</th>
                                        <th class="text-center">Payment Date</th>
                                        <th class="text-right" width="100">Amount</th>
                                        <th class="text-center">Invoice</th>
                                        <th class="text-center">Status</th>											
                                    </tr>
                                    </thead>
                                    <tbody>									
                                        `+installment_tr+`											
                                    </tbody>
                                </table>
                            </div>							
                        </div>
                    </div>
                    `;
                    //alert(tab_content)
                });
            }
            //$('#course_tabs').html(courseHtml);				
            //$('#schedule_details').html(tab_content);
            
            var paymentModalHtml =`

                <div class="btn-actions-pane-left">
                    <div class="nav" id="course_tabs">
                    `+courseHtml+`						
                    </div>
                </div>

                <div class="tab-content" id="schedule_details">
                `+tab_content+`
                </div>				

            `;
            $('#myModalLabelLg').html('Payment Status');
            $('#modalBodyLg').html(paymentModalHtml);
            $("#generic_modal_lg").modal();			
        }
    });	
}

//Batch detail View
batchView = function batchView(id){	
    $.ajax({
        url: url+'/batch/'+id,
        cache: false,
        success: function(response){
            var response = JSON.parse(response);
            var data = response['batch'];
            var statusHtml = (data['status']=="Active")?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In-active</span>';
            if(data['running_status']=="Completed")
                runningStatusHtml = '<span class="badge badge-primary">Completed</span>'
            else if(data['running_status']=="Running")
                runningStatusHtml =  '<span class="badge badge-success">Running</span>';
            else if(data['running_status']=="Upcoming")
                runningStatusHtml =  '<span class="badge badge-info">Upcoming</span>';

            var end_date 	= (data['end_date'] ==null)?"":data['end_date'];
            var details 	= (data['details'] ==null)?"":data['details'];
            var modalHtml  ="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Batch Code :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['batch_name']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Course Title :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['course']['title']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Start Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['start_date']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>End Date :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+end_date+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Student limit :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['student_limit']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Total Enrolled Student :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+data['total_enrolled_student']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong> Details :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+details+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Registration Fee :</strong></div>"+"<div class='col-lg-9 col-md-8'>£"+data['fees']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Discount Fee :</strong></div>"+"<div class='col-lg-9 col-md-8'>£"+data['discounted_fees']+"</div></div>";
                modalHtml +="<div class='row margin-top-5'><div class='col-lg-3 col-md-4 '><strong>Status :</strong></div>"+"<div class='col-lg-9 col-md-8'>"+runningStatusHtml+statusHtml+"</div></div>";

            modalHtml +="<div class='row '>&nbsp;<br><div class='col-lg-12'><strong>Payment Details:</strong></div>"+"<div class='col-lg-12'>";
            modalHtml +="<table class='table table-bordered' style='width:100% !important'> <thead><tr><th>Plan Name</th><th class='text-center'>Total Inst. No</th><th class='text-center'>Duration (Month)</th><th class='text-right'>		Total Payable</th></tr></thead><tbody>";
            if(!jQuery.isEmptyObject(data['batch_fees'])){
                $.each(data['batch_fees'], function(i,dta){ 
                    var installment_duration = (dta['installment_duration']==0)?'':dta['installment_duration']; 
                    modalHtml 	+= "<tr class='table-active'><td>"+dta['plan_name']+"</td>"+"<td class='text-center'>"+dta['total_installment']+"</td>"+"<td class='text-center'>"+installment_duration+"</td>"+"<td class='text-right'>"+dta['payable_amount']+"</td>"+"</tr>";
                    if(dta['plan_name']!='Onetime'){
                        modalHtml 	+= "<tr><td colspan='2' class='text-right'><b>Installment Details</b></td><td colspan='2'><table class='table table-bordered table-sm' style='width:100% !important'> <thead class='thead-light'><tr><th class='text-center'>Inst. No</th><th class='text-right'>Amount</th></tr></thead><tbody>";
                        if(!jQuery.isEmptyObject(dta['installments'])){
                            $.each(dta['installments'], function(i,dt){ 
                                modalHtml 	+= "<tr><td class='text-center'>"+dt['installment_no']+"</td><td class='text-right'>"+dt['amount']+"</td></tr>";
                            });

                        }
                        modalHtml 	+="</tbody></table></td></tr>";
                    }
                });
            }
            modalHtml += "</tbody></table></div></div>";
            $('#myModalLabelLg').html('Batch Details');
            $('#modalBodyLg').html(modalHtml);
            $("#generic_modal_lg").modal();				
        }
    });
}


playPromoVideo = function playPromoVideo(link) {
    var body =`<video width="100%" height="100%" controls>
                <source src="`+link+`" type="video/mp4">
                Your browser does not support HTML video.
                </video>`;

    $('#myModalLabelLg').html('Promo Video');
    $('#modalBodyLg').html(body);
    $("#generic_modal_lg").modal('show');
}