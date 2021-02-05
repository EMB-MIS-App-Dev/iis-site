<style>
  .card-body {
    font-size: 13px;
  }
  .error {
    font-size: 12px !important;
  }

  .set_error{
    color: red;
  }
  label {
    color: #000;
  }
  div#content-wrapper {
    display: flex !important;
    flex-direction: column-reverse !important;
    max-height: 100vh;
    overflow: auto;
  }
</style>

        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

          <h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-file"> </i> NEW LOG </h6>

        </div>

        <?php echo form_open_multipart(base_url().'Logs/Form/save_attachment'); ?>

        <!-- Card Body -->
          <div class="card-body">

                <div class="table-responsive" style="min-height: 800px !important">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab">
                          <div class="col-xl-12 col-lg-12" style="padding:0px;">
                            <div class="trans-layout card">
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0">Form</h6>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Transaction No.:</label>
                                    <input type="text" class="form-control" value="<?= $selectlogs[0]['trans_token']; ?>" readonly="">
                                    <input type="hidden" name="cl_trans_token" class="form-control" value="<?= $this->encrypt->encode($selectlogs[0]['trans_token']); ?>">
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>CLIENT INFORMATION</b></label>
                                  </div>
                                  <div class="col-md-3">
                                    <label>Client name:</label>
                                    <input type="text" class="form-control" value="<?php echo $selectlogs[0]['cl_full_name']; ?>" disabled>
                                  </div>
                                  <div class="col-md-3" style="margin-top:5px;">
                                    <label>Contact No.:</label>
                                    <input type="text" class="form-control" value="<?php echo $selectlogs[0]['cl_contact_no']; ?>" disabled>
                                  </div>
                                  <div class="col-md-3" style="margin-top:5px;">
                                    <label>Address:</label>
                                    <input type="text" class="form-control" value="<?php echo $selectlogs[0]['cl_address']; ?>" disabled>
                                  </div>
                                  <div class="col-md-3" style="margin-top:5px;">
                                    <label>Email Address:</label>
                                    <input type="text" class="form-control" value="<?php echo $selectlogs[0]['cl_email_address']; ?>" disabled>
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>COMPANY PRESENTED & PURPOSE</b></label>
                                  </div>
                                  <?php if($selectlogs[0]['emb_id'] == 'Not in the list of company'){ ?>
                                    <div class="col-md-4">
                                      <label>Company Address:</label>
                                      <input type="text" class="form-control" value="<?php echo trim($selectlogs[0]['company_address']); ?>" disabled>
                                    </div>
                                    <div class="col-md-4">
                                      <label>Company Conctact:</label>
                                      <input type="text" class="form-control" value="<?php echo trim($selectlogs[0]['company_contact']); ?>" disabled>
                                    </div>
                                    <div class="col-md-4">
                                      <label>Company Email:</label>
                                      <input type="text" class="form-control" value="<?php echo trim($selectlogs[0]['company_email']); ?>" disabled>
                                    </div>
                                  <?php } ?>
                                  <div class="col-md-12">
                                    <label>Company Name:</label><?php echo form_error('cl_company'); ?>
                                    <input type="text" class="form-control" value="<?php echo trim($selectlogs[0]['cl_company_name']); ?>" disabled>
                                  </div>
                                  <div class="col-md-12" style="margin-top:5px;">
                                    <label>Purpose:</label><?php echo form_error('cl_purpose'); ?>
                                    <textarea name="cl_purpose" class="form-control" disabled><?php echo $selectlogs[0]['cl_purpose']; ?></textarea>
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>OTHER INFORMATION</b></label><?php echo form_error('cl_other_info'); ?>
                                    <textarea name="cl_other_info" class="form-control" placeholder="such as: Medical Record, Travel History, etc. or N/A" disabled><?php echo $selectlogs[0]['cl_other_info']; ?></textarea>
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>ATTACHMENTS</b></label>
                                  </div>
                                  <div class="col-md-12">
                                    <label>Client Picture:</label>
                                    <input type="file" class="form-control" name="cl_picture" accept="image/*" capture="camera" required/>
                                  </div>
                                  <div class="col-md-12" style="margin-top:5px;">
                                    <label>Government issued ID:</label>
                                    <input type="file" class="form-control" name="cl_valid_id" accept="image/*" capture="camera" required/>
                                  </div>
                                </div>
                              </div><br><br><br><br><br><br>
                              <!-- Card Body -->
                            </div>

                          </div>
                        </div>

                    </div>

                </div>

          </div>
          <!-- Card Body -->
          <div class="card-footer">
            <div class=" float-right">
              <button type="submit" name="cl_save_attachment_button" class="btn btn-success btn-icon-split"><span class="text"> <i class="fas fa-share-square"></i> Save</span></button> <br /><br />
            </div>
          </div>

        </form>
