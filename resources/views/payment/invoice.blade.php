					<table class="discount" width="100%" cellpadding="0" cellspacing="0" role="presentation">
						<tr>
						  <td>
							<img  class="f-fallback email-masthead_name" src="{{ asset('assets/images/admin-upload/')."/".$settings['logo']}}" style="min-width:100px;max-width:140px " /> 
							</td>
						  <td align="right">
							  <h1 class="align-right" style="text-transform:uppercase">Money Receipt</h1>
						  </td>
						</tr>
						<tr>
						  <td></td>
						  <td align="right">                                   
								<p class="align-right" style="font-size:12px">{{$settings['company_name']}}<br>
								  {{$settings['address']}}<br>
								  Mobile : +880{{$settings['admin_mobile']}}<br>
								  www.abpbd.org</p>
						  </td>
						</tr>
						<tr>
						  <td colspan="2">
							<table class="purchase_content" width="100%" cellpadding="0" cellspacing="0" style="font-size:12px">
							  <tr>
								<th class="purchase_heading" align="left">
								  <p class="f-fallback">Bill to,<br>
									{{$invoice['only_student_name']}}
									<br>Registration No : {{ $invoice['student_no']}}
								  </p>
								  <p class="f-fallback">
									{{$invoice['student_email']}},<br>
									{{$invoice['address']}}
								  </p>
								</th>
								<th class="purchase_heading"  colspan="2" align="right">
								  <p class="f-fallback" style="text-align:right !important">
									Invoice Number : {{$invoice['invoice_no']}}</p>
													<p class="f-fallback" style="text-align:right !important">
									Invoice Date : {{Date('Y-m-d')}}</p>
								  <p class="f-fallback" style="text-align:right !important">
									Payment Due :  {{Date('Y-m-d')}}</p>
													
								</th>
							  </tr>
							  <tr>
								<td colspan="3"><hr></td>
							</tr>
							  <tr>
								<th class="purchase_heading" align="left">
								  <p class="f-fallback"><b>Course</b></p>
								</th>
								<th class="purchase_heading" align="right">
									<p class="f-fallback"  style="text-align:right !important"><b>Course Fee</b></p>
								  </th>
								<th class="purchase_heading" align="right">
								  <p class="f-fallback" style="text-align:right !important"><b>Amount</b></p>
								</th>
							  </tr>
							  <tr>
								<td width="50%" class="purchase_item" style="font-size:12px"><span class="f-fallback">{{$invoice['only_course_name']}}</span><br>Batch : {{$invoice['batch_name']}}<br>Enrollment ID : {{$invoice['batch_student_enrollment_id']}}</td>
								<td width="20%" align="right" class="purchase_item" style="font-size:12px"><span class="f-fallback">৳{{$invoiceDetails['actual_fees']}}</span></td>
								
								<td class="align-right" width="20%" align="right" style="font-size:12px"><span class="f-fallback">৳ {{$invoiceDetails['total_payable']}}</span></td>
							</tr>
							  @if($invoiceDetails['discount']>0)
								<tr>
								  <td width="50%" class="" style="font-size:12px"><span class="f-fallback">Discount</span></td>
								  <td width="20%" style="font-size:12px" align="right" class="purchase_item" ><span class="f-fallback">(৳ {{$invoiceDetails['discount']}})</span></td>
								  <td class="align-right" style="font-size:12px" width="20%" align="right" ><span class="f-fallback" >(৳ {{$invoiceDetails['discount']}})</span></td>
							  </tr>
							 @endif
							 <tr>
							  <td colspan="3"><hr></td>
							</tr>
							<tr>
								<td colspan="2" align="right" style="font-size:12px"><b class="f-fallback">Total</b></td>
								<td class="align-right" width="20%" align="right" style="font-size:12px"><span class="f-fallback">৳ {{$invoiceDetails['total_payable']}}</span></td>
							</tr>
							@foreach($invoiceDetails['payments'] as $payment)
							  @if($payment['payment_status'] == 'Paid')
								  <tr>
									  <td colspan="2" align="right" style="font-size:12px"><span class="f-fallback">Payment of {{$payment['paid_date']}}</span></td>
									  <td class="align-right" width="20%" align="right" style="font-size:12px"><span class="f-fallback">৳ {{$payment['paid_amount']}}</span></td>
								  </tr>
							  @endif
							@endforeach
							<tr>
								<td colspan="3"><hr></td>
							</tr>
							<tr>
								<td colspan="2" align="right" style="font-size:12px"><b class="f-fallback">Amount Due (BDT)</b></td>
								<td class="align-right" width="20%" align="right" style="font-size:12px"><b class="f-fallback">৳ {{$invoiceDetails['balance']}}</b></td>
							</tr>
							</table>
						  </td>
						</tr>
						  <td colspan="2"> 
							<br>
							<br> 
							<p style="text-align:left !important; font-size:12px" class="f-fallback">
							Notes/Terms:<br>
							  1. Fees are not refundable.<br>
							  2. Course fees are not transferable.<br>
							  3. Course registration is valid for 12 months (PGD), for short course 4 months 
							</p>
						  </td>
						</tr>
					 </table>