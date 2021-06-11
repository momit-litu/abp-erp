<!-- Modal -->



<div class="modal fade " id="admin_user_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-body">
            <div id="order-div">
                <div class="title text-center">
                    <h4 class="text-info" id="modal_title"></h4><hr>
                </div>
                <div class="done_registration ">
                    <div class="doc_content">
                        <div class="col-md-12">
                            <div class="" style="text-align:left;">
                                <div class="byline">
                                    <span id="modal_body"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>


</div>
{{-- End Modal --}}

<div class="modal fade" id="generic_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document"> <!-- modal-lg-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">set the titel</h4>
      </div>
      <div class="modal-body printable" id="modalBody">
			Set the body
      </div>
      <div class="modal-footer">
	   <button class="btn btn-primary hidden-print print-button" style="display:none"  onclick="printWindow()"><span  class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
       <button type="button" class="btn btn-danger hidden-print" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="generic_modal_lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg-->
    <div class="modal-content">
      <div class="modal-header hidden-print">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelLg">set the titel</h4>
      </div>
      <div class="modal-body" id="modalBodyLg"> 
			Set the body
      </div>
      <div class="modal-footer hidden-print">
		<button class="btn btn-primary  print-button-lg" style="display:none"  onclick="printWindow()"><span  class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
		<button class="btn btn-primary hidden-print" id="print-button-t" style="display:none"  onclick="printTranscript()"><span  class="glyphicon glyphicon-print" aria-hidden="true"></span> Print Transcript</button>
		<button class="btn btn-primary hidden-print" id="print-button-c" style="display:none"  onclick="printCertificate()"><span  class="glyphicon glyphicon-print" aria-hidden="true"></span> Print Certificate</button>
		<button type="button" class="btn btn-danger hidden-print" data-dismiss="modal">Close</button>
	  </div>
    </div>
  </div>
</div>

<!-- Profile Modal -->

<div class="modal fade" id="profile_modal" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form-title"><i class="fa fa-user"></i> User Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<div class="row">
              <div class="col-md-4 col-xs-12">
                <div class="thumbnail text-center photo_view_postion_b" >
                  <div class="profile_image">
  
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-xs-12">
                <div class="" >
                <span id="name_div"></span>
                <p><div id="status_div"></div></p>
                <div id="group_div"></div></p>
                </div>
                <hr>
                <div class="col-md-12">
  
                <p title="Phone"><span><i class="lnr-phone-handset"></i></span><span id="contact_div"></span></p>
                <p title="Email"><span ><i class="lnr-envelope"></i></span><span id="email_div"></span></p>
  
                </div>
               <!-- <div class="col-md-6">
                  <p title="NID NO"><span class="glyphicon glyphicon-credit-card one" style="width:50px;"></span><span id="nid_div"></span></p>
                <p title="Address"><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span><span id="address_div"></span></p>
                </div>-->
                <hr>
              <div class="col-md-12">
                <div id="remarks_details">
  
                </div>
               </div>
  
              </div>
            </div>
					</div>
				</div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
		</div>
	</div>
</div>

