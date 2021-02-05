<?php if(!empty($this->session->userdata('cl_second_page'))){ redirect(base_url()."Logs/Form/logattachment"); } ?>
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

  /* The container radio button */
  .container_radio {
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-left: 10px;
  }

  span.radio_text {
      color: #000;
      margin-left: -5px;
  }

  /* Hide the browser's default radio button */
  .container_radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  /* Create a custom radio button */
  .container_radio .checkmark {
    position: absolute;
    top: -4px;
    left: 0;
    height: 25px;
    width: 26px;
    background-color: #eee;
    border-radius: 50%;
  }

  /* On mouse-over, add a grey background color */
  .container_radio:hover input ~ .checkmark {
    background-color: #ccc;
  }

  /* When the radio button is checked, add a blue background */
  .container_radio input:checked ~ .checkmark {
    background-color: #2196F3;
  }

  /* Create the indicator (the dot/circle - hidden when not checked) */
  .container_radio .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the indicator (dot/circle) when checked */
  .container_radio input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the indicator (dot/circle) */
  .container_radio .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
  }
</style>

        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

          <h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-file"> </i> NEW LOG </h6>

        </div>

        <?php echo form_open_multipart(base_url().'Logs/Form/validate'); ?>

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
                                  <div class="col-md-6">
                                    <label>Transaction No.:</label>
                                    <input type="text" class="form-control" value="<?= $this->session->userdata('log_trans_no_token'); ?>" readonly="">
                                    <input type="hidden" name="cl_trans_no" class="form-control" value="<?= $this->encrypt->encode($this->session->userdata('log_trans_no')); ?>">
                                    <input type="hidden" name="cl_trans_token" class="form-control" value="<?= $this->encrypt->encode($this->session->userdata('log_trans_no_token')); ?>">
                                  </div>
                                  <div class="col-md-6">
                                    <label>Time in:</label><?php echo form_error('cl_timein'); ?>
                                    <input type="time" class="form-control" name="cl_timein" value="<?php echo set_value('cl_timein'); ?>">
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>CLIENT INFORMATION</b></label>
                                  </div>
                                  <div class="col-md-3">
                                    <label>First name:</label><?php echo form_error('cl_firstname'); ?>
                                    <input type="text" class="form-control" name="cl_firstname" value="<?php echo set_value('cl_firstname'); ?>">
                                  </div>
                                  <div class="col-md-3">
                                    <label>Middle name:</label>
                                    <input type="text" class="form-control" name="cl_middlename" value="<?php echo set_value('cl_middlename'); ?>">
                                  </div>
                                  <div class="col-md-3">
                                    <label>Last name:</label><?php echo form_error('cl_lastname'); ?>
                                    <input type="text" class="form-control" name="cl_lastname" value="<?php echo set_value('cl_lastname'); ?>">
                                  </div>
                                  <div class="col-md-3">
                                    <label>Suffix:</label>
                                    <input type="text" class="form-control" placeholder="e.g Jr., Sr., II, III" name="cl_suffix" value="<?php echo set_value('cl_suffix'); ?>">
                                  </div>
                                  <div class="col-md-12" style="margin-top:5px;">
                                    <label>Address:</label><?php echo form_error('cl_address'); ?>
                                    <input type="text" class="form-control" name="cl_address" placeholder="House No./Street Name, Barangay, City, Province" value="<?php echo set_value('cl_address'); ?>">
                                  </div>
                                  <div class="col-md-6" style="margin-top:5px;">
                                    <label>Contact no.:</label><?php echo form_error('cl_contact_no'); ?>
                                    <input type="text" class="form-control" name="cl_contact_no" value="<?php echo set_value('cl_contact_no'); ?>">
                                  </div>
                                  <div class="col-md-6" style="margin-top:5px;">
                                    <label>Email address:</label><?php echo form_error('cl_email_address'); ?>
                                    <input type="text" class="form-control" name="cl_email_address" value="<?php echo set_value('cl_email_address'); ?>">
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>COMPANY PRESENTED & PURPOSE</b></label>
                                  </div>
                                  <div class="col-md-12">
                                    <label>Company name:</label><?php echo form_error('cl_company'); ?>
                                    <select class="form-control" name="cl_company" id="cl_company_selectize" onchange="chkcmpcll(this.value);">
                                      <option value="<?= $selectedcomp_emb_id; ?>"><?= $selectedcomp; ?></option>
                                      <?php if($this->encrypt->decode($this->session->userdata('cl_company_session')) != 'notinthelist'){ ?>
                                        <option value="<?= $this->encrypt->encode('notinthelist'); ?>">Not in the list?</option>
                                      <?php } ?>
                                      <optgroup label="Company list">
                                        <?php for ($comp=0; $comp < sizeof($companies); $comp++) {
                                          echo '<option value="'.$this->encrypt->encode($companies[$comp]['emb_id']).'">'.$companies[$comp]['company_name'].'</option>';
                                        } ?>
                                      </optgroup>
                                    </select>
                                  </div>
                                  <div class="col-md-12" id="_chkcmpcll">
                                    <?php if($this->encrypt->decode($this->session->userdata('cl_company_session')) == 'notinthelist'){ ?>
                                      <hr><div class="row">
                                				<div class="col-md-12">
                                					<label>Please enter company name:</label><?php echo form_error('cl_cmpnm'); ?>
                                					<input type="text" name="cl_cmpnm" class="form-control" value="<?php echo set_value('cl_cmpnm'); ?>">
                                				</div>
                                				<div class="col-md-12" style="margin-top:5px;">
                                					<label>Company address:</label><?php echo form_error('cl_cmpaddress'); ?>
                                					<input type="text" name="cl_cmpaddress" class="form-control" placeholder="House No./Street Name, Barangay, City, Province" value="<?php echo set_value('cl_cmpaddress'); ?>">
                                				</div>
                                				<div class="col-md-6" style="margin-top:5px;">
                                					<label>Company contact no.:</label><?php echo form_error('cl_cntctno'); ?>
                                					<input type="text" name="cl_cntctno" class="form-control" value="<?php echo set_value('cl_cntctno'); ?>">
                                				</div>
                                				<div class="col-md-6" style="margin-top:5px;">
                                					<label>Company email address:</label><?php echo form_error('cl_emladd'); ?>
                                					<input type="email" name="cl_emladd" class="form-control" value="<?php echo set_value('cl_emladd'); ?>">
                                				</div>
                                			</div><hr>
                                    <?php } ?>
                                  </div>
                                  <div class="col-md-12" style="margin-top:5px;">
                                    <label>Company position:</label><?php echo form_error('cl_position'); ?>
                                    <input type="text" class="form-control" name="cl_position" value="<?php echo set_value('cl_position'); ?>">
                                  </div>
                                  <div class="col-md-12" style="margin-top:5px;">
                                    <label>Purpose:</label><?php echo form_error('cl_purpose'); ?>
                                    <textarea name="cl_purpose" class="form-control" rows="8" cols="80"><?php echo set_value('cl_purpose'); ?></textarea>
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>SAFETY AND HEALTH</b></label>
                                  </div>
                                  <div class="col-md-12">
                                    <?php
                                      if(!empty($this->session->userdata('cl_rdobtnf_session'))){
                                        $ychecked = ($this->encrypt->decode($this->session->userdata('cl_rdobtnf_session')) == 'Yes') ? 'checked' : '';
                                        $nchecked = ($this->encrypt->decode($this->session->userdata('cl_rdobtnf_session')) == 'No') ? 'checked' : '';
                                      }else{
                                        $nchecked = 'checked';
                                      }
                                    ?>
                                    <label>Have you originated from, transfer from or transit from any location abroad, in the past 90 days?</label>
                                    <label class="container_radio">
                                      <span class="radio_text">Yes</span>
                                      <input type="radio" name="cl_rdobtnf" onclick="cl_frdobtn(this.value);" value="<?php echo $this->encrypt->encode('Yes'); ?>" <?php echo $ychecked ?>>
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="container_radio">
                                      <span class="radio_text">No</span>
                                      <input type="radio" name="cl_rdobtnf" onclick="cl_frdobtn(this.value);" value="<?php echo $this->encrypt->encode('No'); ?>" <?php echo $nchecked ?>>
                                      <span class="checkmark"></span>
                                    </label>

                                  </div>
                                  <div class="col-md-12" id="cl_frdobtn_">
                                    <?php if($this->encrypt->decode($this->session->userdata('cl_rdobtnf_session')) == 'Yes'){ ?>
                                      <div class="row">
                                				<div class="col-md-4">
                                					<label>Origin:</label><?php echo form_error('cl_forgin'); ?>
                                					<input type="text" class="form-control" name="cl_forgin" value="<?php echo set_value('cl_forgin'); ?>">
                                				</div>
                                				<div class="col-md-4">
                                					<label>Date of travel:</label><?php echo form_error('cl_fdttrvl'); ?>
                                					<input type="date" class="form-control" name="cl_fdttrvl" value="<?php echo set_value('cl_fdttrvl'); ?>">
                                				</div>
                                				<div class="col-md-4">
                                					<label>Date of arrival:</label><?php echo form_error('cl_fdtarrvl'); ?>
                                					<input type="date" class="form-control" name="cl_fdtarrvl" value="<?php echo set_value('cl_fdtarrvl'); ?>">
                                				</div>
                                			</div>
                                    <?php } ?>
                                  </div>
                                  <div class="col-md-12"><hr>
                                    <?php
                                      if(!empty($this->session->userdata('cl_rdobtns_session'))){
                                        $ycheckeds = ($this->encrypt->decode($this->session->userdata('cl_rdobtns_session')) == 'Yes') ? 'checked' : '';
                                        $ncheckeds = ($this->encrypt->decode($this->session->userdata('cl_rdobtns_session')) == 'No') ? 'checked' : '';
                                      }else{
                                        $ncheckeds = 'checked';
                                      }
                                    ?>
                                    <label>Have travelled from a local City and Municipality aside from the address of this office, in the past 60 days?</label>
                                    <label class="container_radio">
                                      <span class="radio_text">Yes</span>
                                      <input type="radio" name="cl_rdobtns" onclick="cl_srdobtn(this.value);" value="<?php echo $this->encrypt->encode('Yes'); ?>" <?php echo $ycheckeds ?>>
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="container_radio">
                                      <span class="radio_text">No</span>
                                      <input type="radio" name="cl_rdobtns" onclick="cl_srdobtn(this.value);" value="<?php echo $this->encrypt->encode('No'); ?>" <?php echo $ncheckeds ?>>
                                      <span class="checkmark"></span>
                                    </label>
                                  </div>
                                  <div class="col-md-12" id="cl_srdobtn_">
                                    <?php if($this->encrypt->decode($this->session->userdata('cl_rdobtns_session')) == 'Yes'){ ?>
                                      <div class="row">
                                				<div class="col-md-12">
                                          <label>Exact address of origin:</label><?php echo form_error('cl_sorgin'); ?>
                                					<input type="text" class="form-control" name="cl_sorgin" placeholder="House No./Street Name, Barangay, City, Province" value="<?php echo set_value('cl_sorgin'); ?>">
                                				</div>
                                			</div>
                                    <?php } ?>
                                  </div>
                                  <div class="col-md-12"><hr></div>
                                  <div class="col-md-12">
                                    <label><b>OTHER INFORMATION</b></label><?php echo form_error('cl_other_info'); ?>
                                    <textarea name="cl_other_info" class="form-control" placeholder="such as: Medical Record, Travel History, etc. or N/A" rows="8" cols="80"><?php echo set_value('cl_other_info'); ?></textarea>
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
              <button type="submit" name="cl_save_button" class="btn btn-success btn-icon-split"><span class="text"> <i class="fas fa-share-square"></i> Proceed</span></button> <br /><br />
            </div>
          </div>

        </form>

        <script type="text/javascript">
          $('#cl_company_selectize').selectize();
        </script>
