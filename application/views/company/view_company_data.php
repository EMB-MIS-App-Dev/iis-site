
  <div class="modal-body">
    <div id="view_ticket_details">
      <div class="row">
        <!-- Company information -->
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-header py-3">
            <h6 class="m-0  text-primary">COMPANY INFORMATION</h6>
          </div>
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <!-- for min company details -->
              <div class="col-xl-12 mb-3 main_comp">
                <div class="h5 mb-0  text-gray-800">Company name:</div>
                <input type="text" name="compname" value="<?php echo $company_data[0]['company_name']; ?>" class="form-control" >
              </div>
              <div class="col-xl-12 mb-3">
                <div class="row">
                    <div class="col-xl-6">
                      <div class="h5 mb-0  text-gray-800">Establishment Name:</div>
                      <input type="text" name="estnam" value="<?php echo $company_data[0]['establishment_name']; ?>" class="form-control">
                    </div>
                    <div class="col-xl-6">
                      <div class="h5 mb-0  text-gray-800">Date Established:</div>
                      <input type="date" name="date_estab" value="<?php echo $company_data[0]['date_established']; ?>" class="form-control">
                    </div>
                </div>
              </div>
              <div class="col-xl-12 mb-3 main_comp">
                <div class="h5 mb-0  text-gray-800">Project type:</div>
                <input type="text" name="compname" value="<?php echo $company_data[0]['project_name']; ?>" class="form-control" >
              </div>
            <div class="col-xl-12 mb-3">
              <div class="row">
                  <div class="col-xl-6">
                    <div class="h5 mb-0  text-gray-800">Company Telephone #:</div>
                    <input type="textarea" name="comp_tel" value="<?php echo $company_data[0]['contact_no']; ?>" class="form-control" >
                  </div>
                  <div class="col-xl-6">
                    <div class="h5 mb-0  text-gray-800">Company Email Address</div>
                    <input type="emial" name="comp_email" value="<?php echo $company_data[0]['email']; ?>" class="form-control" >
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- comapny address -->
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-header py-3">
            <h6 class="m-0  text-primary">COMPANY ADDRESS</h6>
          </div>
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0  text-gray-800">Province:</div>
                <input type="text" name="hsno" value="<?php echo  $company_data[0]['province_name']; ?>" class="form-control">
              </div>

              <div class="col-xl-12 mb-3">
                <div class="row">
                    <div class="col-xl-6">
                      <div class="h5 mb-0  text-gray-800">CITY:</div>
                        <input type="text" name="hsno" value="<?php echo  $company_data[0]['city_name']; ?>" class="form-control">
                    </div>
                    <div class="col-xl-6">
                      <div class="h5 mb-0  text-gray-800">Brgy: </div>
                      <input type="text" name="hsno" value="<?php echo  $company_data[0]['barangay_name']; ?>" class="form-control">
                    </div>
                </div>
              </div>
              <div class="col-xl-12 mb-3">
                <div class="row">
                    <div class="col-xl-6">
                      <div class="h5 mb-0  text-gray-800">Street:</div>
                      <input type="text" name="street" value="<?php echo  $company_data[0]['street']; ?>" class="form-control">
                    </div>
                    <div class="col-xl-6">
                      <div class="h5 mb-0  text-gray-800">Hs No:</div>
                      <input type="text" name="hsno" value="<?php echo  $company_data[0]['house_no']; ?>" class="form-control">
                    </div>
                </div>

              </div>
              <div class="col-xl-12 mb-3">
                <div class="row">
                  <div class="col-xl-6">
                    <div class="h5 mb-0  text-gray-800">Latitude:</div>
                    <input type="text" name="lat" value="<?php echo  $company_data[0]['latitude']; ?>" class="form-control">
                  </div>
                  <div class="col-xl-6">
                    <div class="h5 mb-0  text-gray-800">Longitude:</div>
                    <input type="text" name="long" value="<?php echo  $company_data[0]['longitude']; ?>" class="form-control" >
                  </div>
                </div>
              </div>
            <!-- <div class="col-xl-12 mb-3">
                <div class="h5 mb-0  text-gray-800">Location Photo:</div>
                <?php //echo "<pre>";print_r($comphoto_data); ?>
                <a href="<?php //echo base_url(); ?>uploads/company/<?php //echo $company_data[0]['region_name'].'/'.$company_data[0]['token'].'/'.$comphoto_data[0]['photo_name']; ?>" class="btn btn-success btn-icon-split" target="_blank" id="current_comp_photo">
                          <span class="icon text-white-50">
                            <i class="fas fa-eye"></i>
                          </span>
                        </a>

                <input type="file" name="compic" value="" class="form-control" style="display:none" id="add_new_photo">
              </div> -->
                <div class="col-xl-12 mb-3">
                    <div class="h5 mb-0  text-gray-800">Enter Mailing Address:</div>
                    <input type="textarea" name="mailadd" value="<?php echo $company_data[0]['mailing_add']?>" class="form-control">
                  </div>
            </div>
          </div>
        </div>
      </div>
      <!-- President -->
      <!-- comapny address -->
      <?php if ($company_data[0]['company_id'] != $company_data[0]['company_type'] ): ?>
        <div class="col-xl-12 col-md-12 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3">
              <h6 class="m-0  text-primary">MAIN COMPANY</h6>
            </div>
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col-xl-12 mb-3">
                  <div class="row">
                      <div class="col-xl-6">
                        <div class="h5 mb-0  text-gray-800">EMB ID:</div>
                        <input type="textarea" name="comp_tel" value="<?php echo $company_data_main[0]['emb_id']; ?>" class="form-control" >
                      </div>
                      <div class="col-xl-6">
                        <div class="h5 mb-0  text-gray-800">Company Name:</div>
                        <input type="emial" name="comp_email" value="<?php echo $company_data_main[0]['company_name']; ?>" class="form-control" >
                      </div>
                  </div>
                  </div>

                  <div class="col-xl-12 mb-3">
                    <div class="row">
                      <div class="col-xl-4">
                        <div class="h5 mb-0  text-gray-800">Province:</div>
                        <input type="text" name="hsno" value="<?php echo  $company_data_main[0]['province_name']; ?>" class="form-control">
                      </div>
                        <div class="col-xl-4">
                          <div class="h5 mb-0  text-gray-800">CITY:</div>
                            <input type="text" name="hsno" value="<?php echo  $company_data_main[0]['city_name']; ?>" class="form-control">
                        </div>
                        <div class="col-xl-4">
                          <div class="h5 mb-0  text-gray-800">Brgy: </div>
                          <input type="text" name="hsno" value="<?php echo  $company_data_main[0]['barangay_name']; ?>" class="form-control">
                        </div>
                    </div>
                  </div>
                  <div class="col-xl-12 mb-3">
                      <div class="h5 mb-0  text-gray-800">Street:</div>
                      <input type="textarea" name="mailadd" value="<?php echo $company_data_main[0]['street']?>" class="form-control">
                    </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      </div>
    </div>
  </div>
