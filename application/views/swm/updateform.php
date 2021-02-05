
    <style>

      /* Customize the label (the container_sw) */
      .container_sw {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      label.container_sw {
          width: 100%;
      }

      label.address {
          color: #000;
      }


      .col-md-3.toa {
          padding-left: 24px;
          margin-bottom: 15px;
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
      }

      label.container_sw {
          color: #000;
      }

      span.radio_text {
          color: #000;
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

      /* Hide the browser's default checkbox */
      .container_sw input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
      }

      /* Create a custom checkbox */
      .checkmark.toa {
          position: absolute;
          top: 0;
          left: 0px;
          height: 25px;
          width: 25px;
          background-color: #eee;
      }

      .checkmark.ra {
          position: absolute;
          top: 0;
          left: 0;
          height: 25px;
          width: 100%;
          background-color: #eee;
      }

      /* On mouse-over, add a grey background color */
      .container_sw:hover input ~ .checkmark {
        background-color: #ccc;
      }

      /* When the checkbox is checked, add a blue background */
      .container_sw input:checked ~ .checkmark {
        background-color: #2196F3;
      }

      /* Create the checkmark/indicator (hidden when not checked) */
      .checkmark:after {
        content: "";
        position: absolute;
        display: none;
      }

      /* Show the checkmark when checked */
      .container_sw input:checked ~ .checkmark:after {
        display: block;
      }

      /* Style the checkmark/indicator */
      .container_sw .checkmark:after {
        left: 10px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
      }

      td.tblcntr {
          text-align: left;
      }

      textarea {
        min-height: 100px;
      }


      .data-div {
        min-height: 870px;
      }
      .upload_div {
        border: 1px solid #EAECF4;
      }
      .upload_div a {
        font-size: 13px !important;
        padding: 5px;
        margin: 5px;
      }
      .card-body {
        font-size: 13px;
      }
      .modal-body {
        font-size: 14px;
      }
      .container_sw{
        margin: 0 auto;
        width: 100px;
      }
      .error {
        font-size: 12px !important;
      }



.set_error{
  color: red;
}
    </style>

            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary"><b>SWEET REPORT</b></h6>

            </div>

            <?php echo form_open_multipart(base_url().'Swm/Sweet/validate'); ?>

            <!-- Card Body -->
              <div class="card-body">

                    <div class="table-responsive" style="min-height: 800px !important">
                      <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Form</a>
                        </div>
                      </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab">
                              <div class="row">
                                  <div class="col-md-12"><br>
                                    <label>Transaction No.:</label><?php echo form_error('trans_no'); ?>
                                    <input class="form-control" name="trans_no" id="sw_trans_no" value="<?php echo $this->encrypt->decode($this->session->userdata('sw_token')); ?>" readonly />
                                    <?php echo form_error('report_status'); ?>
                                    <input type="hidden" class="form-control" name="report_status" value="<?php echo $this->session->userdata('report_status'); ?>">
                                    <?php echo form_error('rn'); ?>
                                    <input type="hidden" class="form-control" name="rn" value="<?php echo $this->session->userdata('rn'); ?>">
                                    <?php echo form_error('token'); ?>
                                    <input type="hidden" class="form-control" name="sw_token" value="<?php echo $this->session->userdata('sw_token'); ?>">
                                  </div>
                              </div>
                              <br>
                              <div class="col-xl-12 col-lg-12" style="padding:0px;">
                                <div class="trans-layout card">
                                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0" style="color:#08507E;"><i class="fa fa-file"></i> <?php echo $this->encrypt->decode($this->session->userdata('report_status')); ?> Report</h6>
                                    <h6 style="float:right;color:#08507E;">This report is for the month of <u style="font-weight: bold;"><?php echo $sweet_form[0]['month_monitoring']; ?></u></h6>
                                  </div>
                                  <!-- Card Body -->
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <label>Travel Order:</label><?php echo form_error('travel_no'); ?>
                                        <select class="form-control" id="travel_cat_selectize" name="travel_no">
                                          <option value="<?php echo !empty($this->session->userdata('travel_no_session')) ? ($this->session->userdata('travel_no_session')) : ''; ?>"><?php echo !empty($this->session->userdata('travel_no_session')) ? $travel_no_selected : ''; ?>
                                          </option>
                                          <?php for ($tl=0; $tl < sizeof($travels) ; $tl++) {
                                              if(($travels[$tl]['toid']) != ''){
                                          ?>
                                              <optgroup label="<?php echo date("M d, Y", strtotime($travels[$tl]['departure_date']))." - ". date("M d, Y", strtotime($travels[$tl]['arrival_date'])); ?>">
                                                <option value="<?php echo $this->encrypt->encode($travels[$tl]['toid']); ?>" >
                                                <?php echo $travels[$tl]['toid']." - ".str_replace("Array","",$travels[$tl]['destination']); ?></option>
                                              </optgroup>
                                            <?php } ?>
                                          <?php } ?>
                                        </select>
                                      </div>

                                      <div class="col-md-6">
                                        <label>Assigned to:</label>
                                        <input type="text" class="form-control" value="<?php echo $name; ?>" disabled="">
                                      </div>

                                      <div class="col-md-12"><hr></div>

                                      <div class="col-md-6" style="margin-top:10px;">
                                        <label>I. Date Patrolled:</label><?php echo form_error('date_patrolled'); ?>
                                        <input type="date" name="date_patrolled" class="form-control" id="sw_date_patrolled" onchange=swtom($('#sw_type_of_monitoring').val(),this.value,'<?php echo $this->encrypt->decode($this->session->userdata('rn')); ?>','<?php echo $sweet_form[0]['date_of_first_monitoring']; ?>',$('#sw_trans_no').val()); value="<?php echo set_value('date_patrolled'); ?>">
                                      </div>
                                      <div class="col-md-6" style="margin-top:10px;">
                                        <label>Time Patrolled:</label><?php echo form_error('time_patrolled'); ?>
                                        <input type="time" name="time_patrolled" class="form-control" value="<?php echo set_value('time_patrolled'); ?>">
                                      </div>
                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>II. LGU Patrolled:</label><?php echo form_error('lgu_patrolled'); ?>
                                        <input type="text" class="form-control" value="<?php echo str_replace('LGU','',$sweet_form[0]['lgu_patrolled_name']); ?>" disabled>
                                      </div>
                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>III. Violation(s) Observed:</label>&nbsp;<span style="color:orange;" class="fa fa-info-circle" title="<?= $ifcln = ($this->encrypt->decode($this->session->userdata('report_status')) == 'Clean') ? "If it is a clean report, checkboxes will disabled" : "If it is a clean report, checkboxes will disabled"; ?>"></span>
                                        <table class="table table-bordered" style="text-align: center; width: 100%;">
                                            <tr>
                                              <td><b>&nbsp;Check (<span class="fa fa-check"></span>) as appropriate</b></td>
                                              <td><b>Prohibited Act</b></td>
                                              <td><b>Section Chapter VI, RA 9003</b></td>
                                            </tr>
                                            <?php
                                              $enordis = ($this->encrypt->decode($this->session->userdata('report_status')) == 'Clean') ? "disabled" : '';
                                              $arrsetval = array();
                                              $arraythree = set_value('three[]');
                                              if(!empty($arraythree)){
                                                foreach ($arraythree as $key => $value) {
                                                  $arrsetval[$key] =  str_replace(';','',$this->encrypt->decode($value));

                                                }
                                              }
                                              // $selectedvo = explode(';', $sweet_form[0]['violations_observed_desc']);
                                              $arrayvo = !empty($arrsetval) ? $arrsetval : '';
                                              for ($vo=0; $vo < sizeof($swvo); $vo++) {
                                                $ifchecked = (in_array($swvo[$vo]['section'], $arrayvo)) ? "checked" : "";
                                            ?>
                                              <tr>
                                                <td>
                                                   <label class="container_sw">
                                                      <input type="checkbox"  name="three[]" value="<?php echo $this->encrypt->encode($swvo[$vo]['section'].";"); ?>" <?php echo $ifchecked; ?> <?php echo $enordis; ?>>
                                                      <span class="checkmark ra"></span>
                                                    </label>
                                                </td>
                                                <td class="tblcntr"><?php echo $swvo[$vo]['prohibited_act']; ?></td>
                                                <td><?php echo $swvo[$vo]['section']; ?></td>
                                              </tr>
                                              <tr>
                                            <?php } ?>
                                        </table>
                                      </div>
                                      <div class="row" style="padding: 0px 12px 0px 12px;">
                                      <div class="col-md-12">
                                        <label class="mainftsweet">IV. <span class="mainftsweet" style="margin-left: 10px;">Exact Location and type of area where violations(s) was/were observed (fill up and check as appropriate):</span></label>
                                      </div>
                                      <div class="col-md-4" id="sw_barangay_div">
                                          <label class="address">Barangay:</label>
                                          <input type="text" class="form-control" value="<?php echo $sweet_form[0]['barangay_name']; ?>" disabled="">
                                      </div>
                                          <div class="col-md-4">
                                            <label class="address">Street:</label>
                                            <input type="text" class="form-control" value="<?php echo $sweet_form[0]['street']; ?>" disabled="">
                                          </div>
                                          <div class="col-md-2">
                                            <label class="address">Latitude:</label>
                                            <input type="text" class="form-control"  value="<?php echo $sweet_form[0]['latitude']; ?>" disabled="">
                                          </div>
                                          <div class="col-md-2">
                                            <label class="address">Longitude:</label>
                                            <input type="text" class="form-control"  value="<?php echo $sweet_form[0]['longitude']; ?>" disabled="">
                                          </div>
                                          <div class="col-md-12" style=""><hr>
                                            <center><label class="mainftsweet" style="color:#000;font-size: 15px;margin: 15px 0px 15px 0px;"><b>TYPE OF AREA/PUBLIC PLACE</b></label></center>
                                          </div>

                                              <?php for ($i=0; $i < sizeof($swtoa); $i++) {
                                                 $arraylist = explode(";",$sweet_form[0]['type_of_area_desc']);
                                                 $checked = (in_array($swtoa[$i]['toatitle'], $arraylist)) ? "checked" : "disabled";
                                              ?>
                                                <div class="col-md-3 toa">
                                                    <label class="container_sw">
                                                      <input type="checkbox" value="<?php echo ($swtoa[$i]['toatitle']).";"; ?>" <?php echo $checked; ?>>
                                                      <span class="checkmark toa"></span><?php echo $swtoa[$i]['toatitle']; ?>
                                                    </label>
                                                </div>

                                              <?php } ?>

                                              <div class="col-md-3 toa" id="sw_others_div">
                                                <?php $otherschecked = !empty($sweet_form[0]['if_others_tom']) ? "" : "disabled";
                                                  if($sweet_form[0]['if_others_tom'] != ''){ ?>
                                                    <input type="text" value="<?php echo $sweet_form[0]['if_others_tom']; ?>" style="width:90%;border-radius: 2px;border: 1px solid #D1D3E2;color:#000;" disabled="">&nbsp;
                                                <?php }else{ ?>
                                                  <label class="container_sw">
                                                    <input type="checkbox"  onclick="sw_others(this.value);" value="<?php echo $this->encrypt->encode('others'); ?>" <?php echo $otherschecked; ?>>
                                                    <span class="checkmark toa"></span>Others
                                                  </label>
                                                <?php } ?>
                                              </div>

                                          </div>
                                      <hr>
                                      <div class="col-md-12" style="padding-bottom:10px;">
                                        <label class="mainftsweet">V. <span class="mainftsweet" style="margin-left: 10px;">Type of Monitoring Activity (pls. check, fill up as appropriate)</span></label>
                                      </div>

                                     <?php
                                        for ($tm=0; $tm < sizeof($tom); $tm++) {
                                          if($tom[$tm]['tomid'] != '1'){
                                            if(!empty($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')))){
                                              $arraytom = array($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')));
                                            }else{
                                              $arraytom = array('2');
                                            }
                                            $checked = (in_array($tom[$tm]['tomid'], $arraytom)) ? "checked" : ""; ?>
                                            <div class="col-md-12" style="padding-bottom:5px;">
                                                    <label class="container_radio">
                                                      <span class="radio_text"><?php echo $tom[$tm]['tomtitle']; ?></span>
                                                      <input type="radio" name="type_of_monitoring" id="sw_type_of_monitoring" onclick=swtom(this.value,$('#sw_date_patrolled').val(),'<?php echo $this->encrypt->decode($this->session->userdata('rn')); ?>','<?php echo $sweet_form[0]['date_of_first_monitoring']; ?>',$('#sw_trans_no').val());
                                                      value="<?php echo $this->encrypt->encode($tom[$tm]['tomid']); ?>" <?php echo $checked; ?>/>
                                                      <span class="checkmark"></span>
                                                    </label>
                                                  </div>
                                            <?php
                                          }
                                        }
                                      ?>

                                      <div class="col-md-12">
                                        <div class="row" id="swtom_div">
                                        <?php if($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')) == '2' OR $sweet_form[0]['type_of_monitoring'] == '2'){ ?>
                                          <?php if($this->encrypt->decode($this->session->userdata('rn')) >= '3'){ ?>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm"  value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of second monitoring:</label><?php echo form_error('dtsm'); ?>
                                              <input type="date" class="form-control" name="dtsm" value="<?php echo !empty(set_value('dtsm')) ? set_value('dtsm') : ''; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of last monitoring:</label><?php echo form_error('dtlm'); ?>
                                              <input type="date" class="form-control" name="dtlm"  value="<?php echo !empty(set_value('dtlm')) ? set_value('dtlm') : ''; ?>">
                                            </div>
                                          <?php }else{ ?>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm"  value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of second monitoring:</label><?php echo form_error('dtsm'); ?>
                                              <input type="date" class="form-control" name="dtsm"  value="<?php echo !empty(set_value('dtsm')) ? set_value('dtsm') : ''; ?>">
                                            </div>
                                          <?php } ?>
                                        <?php }else if($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')) == '3' OR $sweet_form[0]['type_of_monitoring'] == '3'){ ?>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm" value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of last monitoring:</label>
                                              <input type="date" class="form-control" name="dtlm" value="<?php echo !empty(set_value('dtlm')) ? set_value('dtlm') : ''; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of issuance of last Notice:</label>
                                              <input type="date" class="form-control" name="dtiln" value="<?php echo set_value('dtiln'); ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Number of times same site is found with illegal dumping:</label>
                                              <input type="text" class="form-control" name="nil" value="<?php echo set_value('nil'); ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Number of times same site is found with open burning activity:</label>
                                              <input type="text" class="form-control" name="noa" value="<?php echo set_value('noa'); ?>">
                                            </div>
                                        <?php }else if($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')) != '' OR $sweet_form[0]['type_of_monitoring'] == '1'){ ?>
                                          <?php if($this->encrypt->decode($this->session->userdata('rn')) >= '3'){ ?>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm"  value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of second monitoring:</label><?php echo form_error('dtsm'); ?>
                                              <input type="date" class="form-control" name="dtsm" value="<?php echo !empty(set_value('dtsm')) ? set_value('dtsm') : ''; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of last monitoring:</label><?php echo form_error('dtlm'); ?>
                                              <input type="date" class="form-control" name="dtlm"  value="<?php echo !empty(set_value('dtlm')) ? set_value('dtlm') : ''; ?>">
                                            </div>
                                          <?php }else{ ?>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm"  value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of second monitoring:</label><?php echo form_error('dtsm'); ?>
                                              <input type="date" class="form-control" name="dtsm"  value="<?php echo !empty(set_value('dtsm')) ? set_value('dtsm') : ''; ?>">
                                            </div>
                                          <?php } ?>
                                        <?php } ?>
                                        </div>
                                      </div>

                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>VI. Updated photo documentation / picture of the site:</label> <?php echo form_error('site_photo'); ?>
                                        <label style="float:right;">Previous report photo attachment:
                                           <a href="#" data-toggle='modal' data-target='#edit_viewattachment' onclick=viewattachmentbtn("<?= !empty($this->session->userdata('sw_token')) ? ($this->session->userdata('sw_token')) : ''; ?>");>View attachment</a>
                                        </label>
                                        <div style="display: flex;" id="updtswdvphotoattachment_">
                                          <?php if(!empty($this->session->userdata('updtswupdtsite_photo'))){ ?>
                                             <a href="<?php echo $this->session->userdata('updtswupdtsite_photo'); ?>" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>
                                             <button type="button" style="width: 135px; margin-left: 10px;" onclick=updtswchangephoto('<?php echo $this->session->userdata('sw_token'); ?>','<?php echo $sweet_form[0]['date_created']; ?>','<?php echo $this->session->userdata('rn'); ?>','<?php echo $this->session->userdata('updtswupdtsite_photo'); ?>'); class="btn btn-warning btn-sm">
                                                  <span class="fa fa-edit"></span>&nbsp;Change photo
                                             </button>'
                                          <?php }else{ ?>
                                            <input class="form-control" type='file' name="updtsite_photo[]" id="updtsite_photo" accept="image/*"/>
                                            <button type="button" style="width: 135px; margin-left: 10px;" onclick="updtswuploadphoto('<?php echo $this->session->userdata('sw_token'); ?>','<?php echo $sweet_form[0]['date_created']; ?>','<?php echo $this->session->userdata('rn'); ?>');" class="btn btn-success btn-sm">
                                              <span class="fa fa-upload"></span>&nbsp;Upload photo
                                            </button>
                                          <?php } ?>
                                        </div>
                                        <div class="progress" id="updtswsitephoto_" style="display:none; margin-top:5px;">
                      									  <div class="progress-bar progress-bar-striped progress-bar-animated" id="updtswsitephotouploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      											<span id="updtswsitephotoprogresspercentage_"></span>
                      										</div>
                      									</div>
                                      </div>

                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>Total land area covered by the solid waste (sq. m.):</label>
                                      <input type="text" class="form-control" value="<?php echo $sweet_form[0]['total_land_area']; ?>" disabled>
                                    </div>
                                    <?php if($this->encrypt->decode($this->session->userdata('report_status')) == 'Clean'){  ?>
                                      <div class="col-md-3" style="margin-top:10px;">
                                        <label>Final Disposal of Solid Waste:</label>
                                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('sw_fdsw'); ?>" readonly>
                                      </div>
                                      <div class="col-md-5" style="margin-top:10px;">
                                        <label>Location:</label>
                                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('sw_location'); ?>" readonly>
                                      </div>
                                      <div class="col-md-2" style="margin-top:10px;">
                                        <label>Latitude:</label>
                                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('sw_latitude'); ?>" readonly>
                                      </div>
                                      <div class="col-md-2" style="margin-top:10px;">
                                        <label>Longitude:</label>
                                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('sw_longitude'); ?>" readonly>
                                      </div>
                                    <?php } ?>
                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label style="float:right;">Characters left:&nbsp;
                                        <span id="charactercount" style="color: red;">
                                          <?php
                                            if(!empty($this->session->userdata('characters_left'))){
                                              $characters_left = $this->session->userdata('characters_left')-strlen($sweet_form[0]['photo_remarks']);
                                            }else{
                                              $characters_left = 1400-strlen($sweet_form[0]['photo_remarks']);
                                            }
                                              echo $characters_left;
                                          ?>
                                        </span>
                                      </label>
                                      <label>Photo remarks:</label><?php echo form_error('photo_remarks'); ?>
                                      <textarea class="form-control photo" name="photo_remarks" id="photo_remarks" onkeyup="jstextarea($('#photo_remarks').val(),$('#additional_remarks').val(),<?= $photo_remarks_fp = strlen($sweet_form[0]['photo_remarks']); ?>);"><?php echo set_value('photo_remarks'); ?></textarea>
                                    </div>
                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>VII. Additional Findings / Remarks:</label><?php echo form_error('additional_remarks'); ?>
                                      <textarea class="form-control remarks" id="additional_remarks" onkeyup="jstextarea($('#photo_remarks').val(),$('#additional_remarks').val(),<?= $photo_remarks_fp = strlen($sweet_form[0]['photo_remarks']); ?>);" name="additional_remarks"><?php echo set_value('additional_remarks'); ?></textarea>
                                    </div>
                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>VIII. Actions to be undertaken:</label>
                                      <?php
                                        $arrsetvala = array();
                                        $arrayau = set_value('atbu[]');
                                        if(!empty($arrayau)){
                                          foreach ($arrayau as $key => $value) {
                                            $arrsetvala[$key] =  str_replace('|','',$this->encrypt->decode($value));

                                          }
                                        }
                                        // $selectedatbu = explode("|", $sweet_form[0]['actions_undertaken_desc']);
                                        $arrayatbu = !empty($arrsetvala) ? $arrsetvala : '';

                                        for ($atbu=0; $atbu < sizeof($swatbu) ; $atbu++) {
                                          $rgnnamevar = $swatbu[$atbu]['atbuid'] == '4' ? $rgnname : "";
                                          $checked = (in_array($swatbu[$atbu]['atbutitle'], $arrayatbu))
                                      ? "checked" : "";
                                        ?>
                                        <div class="col-md-12" style="padding-bottom:10px;">
                                          <label class="container_sw">
                                            <span class="checkbox"><?php echo $swatbu[$atbu]['atbutitle']." ".$rgnnamevar." ".$swatbu[$atbu]['title_two']; ?><span style="color:red;">&nbsp;<?php echo $swatbu[$atbu]['title_three']; ?></span></span>
                                            <input type="checkbox" name="atbu[]" value="<?php echo $this->encrypt->encode($swatbu[$atbu]['atbutitle']."|"); ?>" <?php echo $checked; ?>>
                                            <span class="checkmark toa"></span>
                                          </label>
                                        </div>
                                      <?php } ?>
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
                  <button type="submit" name="submit_update_button" class="btn btn-success btn-icon-split"><span class="text"> <i class="fas fa-share-square"></i> Process</span></button> <br /><br />
                </div>
              </div>

            </form>

            <script type="text/javascript">
              $('#lgu_patrolled_selectize').selectize();
              $('#sw_barangay_selectize').selectize();
              $('#travel_cat_selectize').selectize();
              $('#semi_monthly_selectize').selectize();


              function readURL(input) {
                if (input.files && input.files[0]) {

                  var reader = new FileReader();

                  reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                  };

                  reader.readAsDataURL(input.files[0]);

                } else {
                  removeUpload();
                }
              }

              function removeUpload() {
                $('.file-upload-input').replaceWith($('.file-upload-input').clone());
                $('.file-upload-content').hide();
                $('.image-upload-wrap').show();
              }
              $('.image-upload-wrap').bind('dragover', function () {
                      $('.image-upload-wrap').addClass('image-dropping');
                  });
                  $('.image-upload-wrap').bind('dragleave', function () {
                      $('.image-upload-wrap').removeClass('image-dropping');
              });


              function jstextarea(stringone, stringtwo, strlenfp){

                console.log(stringone.length);
                console.log(stringtwo.length);
                var base_characters = 1400 - strlenfp;
                var characters_inputted = stringone.length + stringtwo.length;
                var characters_left = base_characters - characters_inputted;
                var count = characters_left >= 0 ? characters_left : 0;
                $('#charactercount').text(count);

                var photo_max_length   = base_characters - stringtwo.length;


                var remarks_max_length = base_characters - stringone.length;



                document.getElementsByClassName("form-control photo")[0].setAttribute("maxlength", photo_max_length);
                document.getElementsByClassName("form-control remarks")[0].setAttribute("maxlength", remarks_max_length);

              }
            </script>
