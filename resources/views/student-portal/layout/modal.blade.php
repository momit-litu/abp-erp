<!-- Modal -->

<div class="modal fade" id="student-view-modal" >
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="form-title"><i class="fa fa-user"></i> Student Details</h5>
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
                                  <div class="student_profile_image">

                                  </div>
                              </div>
                              <hr>
                              <p>Attachments:</p>                                    
                              <div id='attachment_div'></div>                             
                          </div>
                          <div class="col-md-8 col-xs-12">
                              <div class="" >
                                  <h5><span id="student_number"></span></h5>
                                  <span id="student_name"></span>
                                  <p><div id="status_div"></div><span id="type_div"></span></p>
                                  <div id="group_div"></div></p>
                              </div>
                              <hr>
                              <div class="col-md-12">
                                  <p title="NID NO"><span class="lnr-license" style="width:50px;"> </span><span id="nid_div"></span></p>
                                  <p title="Birthday"><span><i class="lnr-calendar-full"></i> </span><span id="student_DOB"></span></p>
                                  <p title="Phone"><span><i class="lnr-phone-handset"></i> </span><span id="student_contact"></span></p>
                                  <p title="Phone"><span><i class="lnr-phone-handset"></i> </span><span id="student_emergency_contact"></span></p>
                                  <p title="Email"><span ><i class="lnr-envelope"></i> </span><span id="email_div"></span></p>
                                  <p title="Address"><span ><i class="fa fa-address-card"></i> </span><span id="student_address"></span></p>
                              </div>
                              <hr>
                              <div class="col-md-12">                                       
                               <p>Current Employment : <span id="current_emplyment_div"></span></p>
                               <p>Last Qualification : <span id="last_qualification_div"></span></p>
                               <p>Passing Year : <span id="passing_year_div"></span></p>
                               </div>
                              <hr>
                              <div class="col-md-12">
                                  <div id="remarks_details">
                                  </div>
                                  <hr>
                              </div>                                 
                          </div>
                          <br> <br><br> <br>
                         
                          <div id="course_list" class="col-md-12"></div>   
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
      <div class="modal-header">
				<h5 class="modal-title" id="myModalLabelLg"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
      
      <div class="modal-body " > 
        <div class="main-card mb-3 card">
					<div class="card-body printable" id="modalBodyLg">
          </div>
        </div>
      </div>
      <div class="modal-footer hidden-print">
        <button class="btn btn-info  email-button-lg" style="display:none"  ><i class="fa fa-envelope"></i></i></span> Email</button>

        <button class="btn btn-primary  print-button-lg" style="display:none"  onclick="printWindow()"><i class="pe-7s-print"></i> Print</button>
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

<div class="modal fade" id="registration-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg-->
    <div class="modal-content">
      <div class="modal-header">
                <h5 class="modal-title">Registration Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      
      <div class="modal-body " > 
        <div class="main-card mb-3 card">
              <div class="card-body printable">
                <div class="card-body">
        
                  <div id="smartwizard" class="sw-main sw-theme-default">
                      <ul class="forms-wizard nav nav-tabs step-anchor">
                          <li class="nav-item active">
                              <a href="#step-1" class="nav-link">
                                  <em>1</em><span>Account Information</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#step-2" class="nav-link">
                                  <em>2</em><span>Payment Information</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#step-3" class="nav-link">
                                  <em>3</em><span>Confirmation</span>
                              </a>
                          </li>
                      </ul>

                      <div class="form-wizard-content sw-container tab-content" style="min-height: 353.583px;">
                          <div id="step-1" class="tab-pane step-content" style="display: block;">
                              <div class="form-row">
                                  <div class="col-md-6">
                                      <div class="position-relative form-group"><label for="exampleEmail55">Email</label><input name="email" id="exampleEmail55" placeholder="with a placeholder" type="email" class="form-control">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="position-relative form-group"><label for="examplePassword22">Password</label><input name="password" id="examplePassword22" placeholder="password placeholder" type="password" class="form-control"></div>
                                  </div>
                              </div>
                              <div class="position-relative form-group"><label for="exampleAddress">Address</label><input name="address" id="exampleAddress" placeholder="1234 Main St" type="text" class="form-control"></div>
                              <div class="position-relative form-group"><label for="exampleAddress2">Address 2</label><input name="address2" id="exampleAddress2" placeholder="Apartment, studio, or floor" type="text" class="form-control">
                              </div>
                              <div class="form-row">
                                  <div class="col-md-6">
                                      <div class="position-relative form-group"><label for="exampleCity">City</label><input name="city" id="exampleCity" type="text" class="form-control"></div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="position-relative form-group"><label for="exampleState">State</label><input name="state" id="exampleState" type="text" class="form-control"></div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="position-relative form-group"><label for="exampleZip">Zip</label><input name="zip" id="exampleZip" type="text" class="form-control"></div>
                                  </div>
                              </div>
                              <div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Check me out</label></div>
                          </div>
                          <div id="step-2" class="tab-pane step-content">
                              <div id="accordion" class="accordion-wrapper mb-3">
                                  <div class="card">
                                      <div id="headingOne" class="card-header">
                                          <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block">
                                              <span class="form-heading">Account Information<p>Enter your user informations below</p></span>
                                          </button>
                                      </div>
                                      <div data-parent="#accordion" id="collapseOne" aria-labelledby="headingOne" class="collapse show">
                                          <div class="card-body">
                                              <div class="form-row">
                                                  <div class="col-md-6">
                                                      <div class="position-relative form-group">
                                                          <label for="exampleEmail2">Email</label>
                                                          <input name="email" id="exampleEmail2" placeholder="with a placeholder" type="email" class="form-control">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="position-relative form-group">
                                                          <label for="examplePassword">Password</label>
                                                          <input name="password" id="examplePassword" placeholder="password placeholder" type="password" class="form-control">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="position-relative form-group">
                                                  <label for="exampleAddress">Address</label><input name="address" id="exampleAddress" placeholder="1234 Main St" type="text" class="form-control"></div>
                                              <div class="position-relative form-group"><label for="exampleAddress2">Address 2</label><input name="address2" id="exampleAddress2" placeholder="Apartment, studio, or floor" type="text" class="form-control"></div>
                                              <div class="form-row">
                                                  <div class="col-md-6">
                                                      <div class="position-relative form-group"><label for="exampleCity">City</label><input name="city" id="exampleCity" type="text" class="form-control"></div>
                                                  </div>
                                                  <div class="col-md-4">
                                                      <div class="position-relative form-group"><label for="exampleState">State</label><input name="state" id="exampleState" type="text" class="form-control"></div>
                                                  </div>
                                                  <div class="col-md-2">
                                                      <div class="position-relative form-group"><label for="exampleZip">Zip</label><input name="zip" id="exampleZip" type="text" class="form-control"></div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div id="step-3" class="tab-pane step-content">
                              <div class="no-results">
                                  <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                      <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                                      <span class="swal2-success-line-tip"></span>
                                      <span class="swal2-success-line-long"></span>
                                      <div class="swal2-success-ring"></div>
                                      <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                                      <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                                  </div>
                                  <div class="results-subtitle mt-4">Finished!</div>
                                  <div class="results-title">You arrived at the last form wizard step!</div>
                                  <div class="mt-3 mb-3"></div>
                                  <div class="text-center">
                                      <button class="btn-shadow btn-wide btn btn-success btn-lg">Finish</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="divider"></div>
                  <div class="clearfix">
                      <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button>
                      <button type="button" id="next-btn" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Next</button>
                      <button type="button" id="prev-btn" class="btn-shadow float-right btn-wide btn-pill mr-3 btn btn-outline-secondary">Previous</button>
                  </div>
              </div>
              </div>
        </div>
      </div>
      <div class="modal-footer hidden-print">
        <button class="btn btn-info  email-button-lg" style="display:none"  ><i class="fa fa-envelope"></i></i></span> Email</button>

        <button class="btn btn-primary  print-button-lg" style="display:none"  onclick="printWindow()"><i class="pe-7s-print"></i> Print</button>
        <button type="button" class="btn btn-danger hidden-print" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

