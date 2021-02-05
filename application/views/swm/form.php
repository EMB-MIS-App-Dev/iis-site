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

              <h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-plus"> </i> Create SWEET Report</h6>

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
                                    <input class="form-control" name="trans_no" value="<?php echo $this->session->userdata('trans_no_token'); ?>" readonly />
                                  </div>
                              </div>
                              <br>
                              <div class="col-xl-12 col-lg-12" style="padding:0px;">
                                <div class="trans-layout card">
                                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0"><i class="fa fa-file"></i> Unclean Report</h6>
                                  </div>
                                  <!-- Card Body -->
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <label>Travel Order:</label><?php echo form_error('travel_no'); ?>
                                        <select class="form-control" id="travel_cat_selectize" name="travel_no" onchange="swmnoto(this.value);">
                                          <option value="<?php echo !empty($this->session->userdata('travel_no_session')) ? $this->session->userdata('travel_no_session') : ''; ?>"><?php echo !empty($this->session->userdata('travel_no_session')) ? $travel_no_selected : ''; ?>
                                          </option>
                                          <option value="<?php echo $this->encrypt->encode('NTOR'); ?>">NO TRAVEL ORDER</option>
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
                                        <label>Assigned to / will be routed to:</label>
                                        <input type="text" class="form-control" value="<?php echo $name; ?>" readonly="">
                                      </div>

                                      <div class="col-md-12" id="swmnoto_"></div>

                                      <div class="col-md-12"><hr></div>

                                      <div class="col-md-12">
                                        <label>This report is for the month of:</label><?php echo form_error('month_monitoring'); ?>
                                        <input type="month" class="form-control" name="month_monitoring" value="<?php echo set_value('month_monitoring'); ?>">
                                      </div>
                                      <div class="col-md-6" style="margin-top:10px;">
                                        <label>I. Date Patrolled:</label><?php echo form_error('date_patrolled'); ?>
                                        <input type="date" name="date_patrolled" class="form-control" value="<?php echo set_value('date_patrolled'); ?>">
                                      </div>
                                      <div class="col-md-6" style="margin-top:10px;">
                                        <label>Time Patrolled:</label><?php echo form_error('time_patrolled'); ?>
                                        <input type="time" name="time_patrolled" class="form-control" value="<?php echo set_value('time_patrolled'); ?>">
                                      </div>
                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>II. LGU Patrolled:</label><?php echo form_error('lgu_patrolled'); ?>
                                        <select class="form-control" onchange="sw_lgu_patrolled(this.value);" name="lgu_patrolled" id="lgu_patrolled_selectize">
                                          <option value="<?php echo !empty($this->session->userdata('lgu_patrolled_session')) ? ($this->session->userdata('lgu_patrolled_session')) : ''; ?>">
                                          <?php echo !empty($this->session->userdata('lgu_patrolled_session')) ? ($company_name) : ''; ?>
                                          </option>
                                          <?php for($i=0; $i<sizeof($query_lgu); $i++){ ?>
                                            <option value="<?php echo $this->encrypt->encode($query_lgu[$i]['emb_id']); ?>">
                                              <?php echo strtoupper($query_lgu[$i]['lgu_name']); ?>
                                            </option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>III. Violation(s) Observed:</label>
                                        <table class="table table-bordered" style="text-align: center; width: 100%;">
                                            <tr>
                                              <td><b>&nbsp;Check (<span class="fa fa-check"></span>) as appropriate</b></td>
                                              <td><b>Prohibited Act</b></td>
                                              <td><b>Section Chapter VI, RA 9003</b></td>
                                            </tr>
                                            <?php
                                              $arrsetval = array();
                                              $arraythree = set_value('three[]');
                                              if(!empty($arraythree)){
                                                foreach ($arraythree as $key => $value) {
                                                  $arrsetval[$key] =  str_replace(';','',$this->encrypt->decode($value));

                                                }
                                              }
                                              $arrayvo = !empty($arrsetval) ? $arrsetval : array('' => '');
                                              for ($vo=0; $vo < sizeof($swvo); $vo++) {
                                                $ifchecked = (in_array($swvo[$vo]['section'], $arrayvo)) ? "checked" : "";
                                            ?>
                                              <tr>
                                                <td>
                                                   <label class="container_sw">
                                                      <input type="checkbox"  name="three[]" value="<?php echo $this->encrypt->encode($swvo[$vo]['section'].";"); ?>"
                                                      <?php echo $ifchecked; ?>>
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
                                      <div class="col-md-12">
                                        <label class="mainftsweet">IV. <span class="mainftsweet" style="margin-left: 10px;">Exact Location and type of area where violations(s) was/were observed (fill up and check as appropriate):</span></label>
                                      </div>
                                      <div class="col-md-4" id="sw_barangay_div">
                                        <?php if(empty($this->session->userdata('sw_barangay_session'))){ ?>
                                          <label class="address">Barangay:</label>
                                          <input type="text" placeholder="Please select LGU Patrolled" class="form-control" disabled="">
                                        <?php }else{ ?>
                                          <label>Barangay:</label><?php echo form_error('sw_barangay'); ?>
                                          <select class="form-control" id="sw_barangay_selectize" name="sw_barangay">
                                            <option value="<?php echo $this->session->userdata('sw_barangay_session'); ?>"><?php echo $selectedbrgy; ?></option>
                                            <?php for ($i=0; $i < sizeof($qrybrgy); $i++) { ?>
                                              <option value="<?php echo $this->encrypt->encode($qrybrgy[$i]['id']); ?>"><?php echo $qrybrgy[$i]['name']; ?></option>
                                            <?php } ?>
                                          </select>
                                        <?php } ?>
                                      </div>
                                      <div class="col-md-4">
                                        <label class="address">Street:</label><?php echo form_error('sw_street'); ?>
                                        <input type="text" name="sw_street" class="form-control" value="<?php echo set_value('sw_street'); ?>">
                                      </div>
                                      <div class="col-md-2">
                                        <label class="address">Latitude:</label><?php echo form_error('sw_latitude'); ?>
                                        <input type="text" name="sw_latitude" class="form-control" id="sw_latitude" placeholder="e.g. 10.319265" onchange="chkcoordinatessw($('#sw_latitude').val(),$('#sw_longitude').val());" value="<?php echo set_value('sw_latitude'); ?>">
                                      </div>
                                      <div class="col-md-2">
                                        <div id="chkcoordinatessw_"></div>
                                        <label class="address">Longitude:</label><?php echo form_error('sw_longitude'); ?>
                                        <input type="text" name="sw_longitude" class="form-control" id="sw_longitude" placeholder="e.g. 123.909439" onchange="chkcoordinatessw($('#sw_latitude').val(),$('#sw_longitude').val());" value="<?php echo set_value('sw_longitude'); ?>">
                                      </div>
                                      <div class="col-md-12" style=""><hr>
                                        <center><label class="mainftsweet" style="color:#000;font-size: 15px;margin: 15px 0px 15px 0px;"><b>TYPE OF AREA/PUBLIC PLACE</b></label></center>
                                      </div>
                                          <?php for ($i=0; $i < sizeof($swtoa); $i++) { ?>
                                            <div class="col-md-3 toa">
                                                <label class="container_sw">
                                                  <input type="checkbox"  name="four[]" value="<?php echo ($swtoa[$i]['toatitle']).";"; ?>">
                                                  <span class="checkmark toa"></span><?php echo $swtoa[$i]['toatitle']; ?>
                                                </label>
                                            </div>
                                          <?php } ?>
                                           <div class="col-md-3 toa" id="sw_others_div">
                                                <label class="container_sw">
                                                  <input type="checkbox"  onclick="sw_others(this.value);" value="<?php echo $this->encrypt->encode('others'); ?>">
                                                  <span class="checkmark toa"></span>Others
                                                </label>
                                            </div>
                                      </div><br/><br/>

                                        <?php
                                          $accessibilitydecrypted = $this->encrypt->decode($this->session->userdata('accessibility_session'));
                                          $access_checkedy = ( $accessibilitydecrypted == 'Yes' AND !empty($accessibilitydecrypted)) ? 'checked' : '';
                                          $access_checkedn = ($accessibilitydecrypted == 'No' AND !empty($accessibilitydecrypted)) ? 'checked' : ((empty($accessibilitydecrypted) ? 'checked' : ''));
                                        ?>

                                        <div class="col-md-12" style="display:flex;">
                                          <label class="address" style="margin-right: 20px;">Accessible by heavy equipment(s)?</label>
                                          <label class="container_radio" style="width:5%!important;margin:0px!important;">
                                            <input type="radio" value="<?php echo $this->encrypt->encode('Yes'); ?>" name="accessibility" <?php echo $access_checkedy; ?>>
                                            <span class="checkmark toa"></span>Yes
                                          </label>
                                          <label class="container_radio" style="width:5%!important;margin:0px!important;">
                                            <input type="radio" value="<?php echo $this->encrypt->encode('No'); ?>" name="accessibility" <?php echo $access_checkedn; ?>>
                                            <span class="checkmark toa"></span>No
                                          </label>
                                        </div>

                                      <hr>
                                      <div class="col-md-12" style="padding-bottom:10px;">
                                        <label class="mainftsweet">V. <span class="mainftsweet" style="margin-left: 10px;">Type of Monitoring Activity (pls. check, fill up as appropriate)</span></label>
                                      </div>

                                     <?php for ($tom=0; $tom < sizeof($swtom) ; $tom++) {
                                      if($swtom[$tom]['tomid'] == '1'){
                                        if(!empty($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')))){
                                          if($swtom[$tom]['tomid'] == $this->encrypt->decode($this->session->userdata('type_of_monitoring_session'))){
                                              $is_checked = "checked";
                                          }else{
                                              $is_checked = "";
                                          }
                                        }else{
                                          if($tom == 0){ $is_checked = "checked"; }else{ $is_checked = ""; }
                                        }

                                      ?>
                                        <div class="col-md-6" style="padding-bottom:10px;">
                                          <label class="container_radio">
                                            <span class="radio_text"><?php echo $swtom[$tom]['tomtitle']; ?></span>
                                            <input type="radio" name="type_of_monitoring" onclick="swtom(this.value,<?php echo $swtom[$tom]['tomid']; ?>);" value="<?php echo $this->encrypt->encode($swtom[$tom]['tomid']); ?>" <?php echo $is_checked; ?>>
                                            <span class="checkmark"></span>
                                          </label>
                                        </div>

                                      <?php } } ?>

                                       <div class="row" id="swtom_div" style="margin: 0px 50px 0px 50px !important;">
                                          <?php
                                            if($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')) == 2){
                                              ?>
                                                <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                                  <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                                  <input type="date" class="form-control" name="dtfm"  value="<?php echo set_value('dtfm'); ?>">
                                                </div>
                                                <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                                  <label>Date of second monitoring:</label><?php echo form_error('dtsm'); ?>
                                                  <input type="date" class="form-control" name="dtsm" value="<?php echo set_value('dtsm'); ?>">
                                                </div>
                                                <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                                  <label>Date of last monitoring:</label><?php echo form_error('dtlm'); ?>
                                                  <input type="date" class="form-control" name="dtlm"  value="<?php echo set_value('dtlm'); ?>">
                                                </div>
                                              <?php
                                              }else if($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')) == 3){
                                              ?>
                                                <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                                  <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                                  <input type="date" class="form-control" name="dtfm"  value="<?php echo set_value('dtfm'); ?>">
                                                </div>
                                                <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                                  <label>Date of last monitoring:</label><?php echo form_error('dtlm'); ?>
                                                  <input type="date" class="form-control" name="dtlm"  value="<?php echo set_value('dtlm'); ?>">
                                                </div>
                                                <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                                  <label>Date of issuance of last Notice:</label><?php echo form_error('dtiln'); ?>
                                                  <input type="date" class="form-control" name="dtiln"  value="<?php echo set_value('dtiln'); ?>">
                                                </div>
                                                <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                                  <label>Number of times same site is found with illegal dumping:</label><?php echo form_error('nil'); ?>
                                                  <input type="text" class="form-control" name="nil"  value="<?php echo set_value('nil'); ?>">
                                                </div>
                                                <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                                  <label>Number of times same site is found with open burning activity:</label><?php echo form_error('noa'); ?>
                                                  <input type="text" class="form-control" name="noa"  value="<?php echo set_value('noa'); ?>">
                                                </div>
                                              <?php
                                            }
                                          ?>
                                        </div>

                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>VI. Photo documentation/picture of the site:</label>
                                        <?php if($chkgeocam > 0){ ?>
                                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#geocamphotosmodal" onclick="viewgeocamphotos();">Geocam Photo(s)</button>
                                        <?php } ?>
                                        <div style="display: flex;" id="swdvphotoattachment_">
                                          <?php if(!empty($this->session->userdata('swsite_photo'))){ ?>
                                            <a href="<?= $this->session->userdata('swsite_photo'); ?>" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>
                                            <button type="button" style="width: 135px; margin-left: 10px;" onclick="swchangephoto('<?php echo $this->encrypt->encode($this->session->userdata('trans_no_token')); ?>','<?php echo $this->session->userdata('swsite_photo'); ?>');" class="btn btn-warning btn-sm">
                                                 <span class="fa fa-edit"></span>&nbsp;Change photo
                                            </button>
                                          <?php }else{ ?>
                                            <input class="form-control" type='file' name="site_photo[]" id="site_photo" accept="image/*"/>
                                            <button type="button" style="width: 135px; margin-left: 10px;" onclick="swuploadphoto('<?php echo $this->encrypt->encode($this->session->userdata('trans_no_token')); ?>');" class="btn btn-success btn-sm">
                                              <span class="fa fa-upload"></span>&nbsp;Upload photo
                                            </button>
                                          <?php } ?>
                                        </div>
                                        <div class="progress" id="swsitephoto_" style="display:none; margin-top:5px;">
                      									  <div class="progress-bar progress-bar-striped progress-bar-animated" id="swsitephotouploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      											<span id="swsitephotoprogresspercentage_"></span>
                      										</div>
                      									</div>
                                      </div>

                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>Total land area covered by the solid waste (sq. m.):</label><?php echo form_error('ttlarea'); ?>
                                      <input type="text" class="form-control" name="ttlarea" value="<?php echo set_value('ttlarea'); ?>">
                                    </div>
                                    <div class="col-md-12" style="margin-top:10px;"><label style="float:right;">Characters left:&nbsp;<span id="charactercount" style="color: red;">1400</span></label>
                                      <label>Photo remarks:</label><?php echo form_error('photo_remarks'); ?>
                                      <textarea class="form-control photo" name="photo_remarks" id="photo_remarks" onkeyup="jstextarea($('#photo_remarks').val(),$('#additional_remarks').val());"><?php echo set_value('photo_remarks'); ?></textarea>
                                    </div>
                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>VII. Additional Findings / Remarks:</label><?php echo form_error('additional_remarks'); ?>
                                      <textarea class="form-control remarks" id="additional_remarks" onkeyup="jstextarea($('#photo_remarks').val(),$('#additional_remarks').val());" name="additional_remarks"><?php echo set_value('additional_remarks'); ?></textarea>
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
                                          $arrayatbu = !empty($arrsetvala) ? $arrsetvala : array('' => '');
                                          for ($atbu=0; $atbu < sizeof($swatbu) ; $atbu++) {
                                          $checked = (in_array($swatbu[$atbu]['atbutitle'], $arrayatbu)) ? "checked" : "";
                                          $rgnnamevar = $swatbu[$atbu]['atbuid'] == '4' ? $rgnname : "";
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
                  <button type="submit" name="submit_button" class="btn btn-success btn-icon-split"><span class="text"> <i class="fas fa-share-square"></i> Process</span></button> <br /><br />
                </div>
              </div>

            </form>

            <div class="modal fade" id="geocamphotosmodal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document" style="max-width:90%!important;">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="useraccountsModalLabel">Geocam Photo(s)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                    <div id="viewgeocamphotos_"></div>
                </div>
              </div>
            </div>

            <script type="text/javascript">
              $('#lgu_patrolled_selectize').selectize();
              $('#sw_barangay_selectize').selectize();
              $('#travel_cat_selectize').selectize();


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


              function jstextarea(stringone, stringtwo){

                console.log(stringone.length);
                console.log(stringtwo.length);

                var characters_inputted = stringone.length + stringtwo.length;
                var characters_left = 1400 - characters_inputted;
                var count = characters_left >= 0 ? characters_left : 0;
                $('#charactercount').text(count);

                var photo_max_length   = 1400 - stringtwo.length;

                var remarks_max_length = 1400 - stringone.length;

                document.getElementsByClassName("form-control photo")[0].setAttribute("maxlength", photo_max_length);
                document.getElementsByClassName("form-control remarks")[0].setAttribute("maxlength", remarks_max_length);
              }
            </script>
