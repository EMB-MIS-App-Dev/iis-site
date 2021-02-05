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
                                    <input type="text" class="form-control" id="sw_trans_no" value="<?= !empty($this->session->userdata('edit_trans_no_session')) ? $this->encrypt->decode($this->session->userdata('edit_trans_no_session')) : $this->encrypt->decode($this->input->get('token')); ?>" readonly />
                                    <input type="hidden" class="form-control" name="trans_no" value="<?= !empty($this->session->userdata('edit_trans_no_session')) ? ($this->session->userdata('edit_trans_no_session')) : ($this->input->get('token')); ?>" readonly />
                                    <input type="hidden" class="form-control" name="report_status" value="<?= !empty($this->session->userdata('edit_report_status_session')) ? ($this->session->userdata('edit_report_status_session')) : ($this->input->get('rs')); ?>" readonly />
                                    <input type="hidden" class="form-control" name="report_number" id="report_number_" value="<?= !empty($this->session->userdata('edit_report_number_session')) ? ($this->session->userdata('edit_report_number_session')) : ($this->input->get('rn')); ?>" readonly />
                                    <input type="hidden" class="form-control" name="sw_fdsw" value="<?= !empty($this->session->userdata('edit_sw_fdsw_session')) ? ($this->session->userdata('edit_sw_fdsw_session')) : ($this->input->get('sw_fdsw')); ?>" readonly>
                                    <input type="hidden" class="form-control" name="sw_location" value="<?= !empty($this->session->userdata('edit_sw_location_session')) ? ($this->session->userdata('edit_sw_location_session')) : ($this->input->get('sw_location')); ?>" readonly>
                                    <input type="hidden" class="form-control" name="sw_latitude" value="<?= !empty($this->session->userdata('edit_sw_latitude_session')) ? ($this->session->userdata('edit_sw_latitude_session')) : ($this->input->get('sw_latitude')); ?>" readonly>
                                    <input type="hidden" class="form-control" name="sw_longitude" value="<?= !empty($this->session->userdata('edit_sw_longitude_session')) ? ($this->session->userdata('edit_sw_longitude_session')) : ($this->input->get('sw_longitude')); ?>" readonly>
                                    <?php $tomrs = !empty($this->session->userdata('edit_report_status_session')) ? $this->encrypt->decode($this->session->userdata('edit_report_status_session')) : $this->encrypt->decode($this->input->get('rs')); ?>
                                  </div>
                              </div>
                              <br>
                              <div class="col-xl-12 col-lg-12" style="padding:0px;">
                                <div class="trans-layout card">
                                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0" style="color:#08507E;"><i class="fa fa-file"></i> <?= !empty($this->session->userdata('edit_report_status_session')) ? $this->encrypt->decode($this->session->userdata('edit_report_status_session')) : $this->encrypt->decode($this->input->get('rs')); ?> Report</h6>
                                  </div>
                                  <!-- Card Body -->
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-12" style="margin-bottom:10px;">
                                        <label>This report is for the month of: </label><?php echo form_error('month_monitoring'); ?>
                                        <input type="month" class="form-control" name="month_monitoring" value="<?php echo !empty(set_value('month_monitoring')) ? set_value('month_monitoring') : date("Y-m", strtotime($sweet_form[0]['month_monitoring'])); ?>">
                                      </div>
                                      <div class="col-md-6">
                                        <label>Travel Order:</label><?php echo form_error('travel_no'); ?>
                                        <select class="form-control" id="travel_cat_selectize" name="travel_no">
                                          <option value="<?php echo !empty($this->session->userdata('travel_no_session')) ? ($this->session->userdata('travel_no_session')) : $this->encrypt->encode($sweet_form[0]['travel_no']); ?>"><?php echo !empty($this->session->userdata('travel_no_session')) ? $travel_no_selected : $sweet_form[0]['travel_no']; ?>
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
                                        <label>Assigned to:</label><?php echo form_error('assignedtodmy'); ?>
                                        <input type="text" class="form-control" name="assignedtodmy" value="<?php echo !empty(set_value('assignedtodmy')) ? set_value('assignedtodmy') : $name; ?>" readonly>
                                      </div>

                                      <div class="col-md-12"><hr></div>

                                      <div class="col-md-6" style="margin-top:10px;">
                                        <label>I. Date Patrolled:</label><?php echo form_error('date_patrolled'); ?>
                                        <input type="date" name="date_patrolled" id="sw_date_patrolled" class="form-control" value="<?php echo !empty(set_value('date_patrolled')) ? set_value('date_patrolled') : $sweet_form[0]['date_patrolled']; ?>" required>
                                      </div>
                                      <div class="col-md-6" style="margin-top:10px;">
                                        <label>Time Patrolled:</label><?php echo form_error('time_patrolled'); ?>
                                        <input type="time" name="time_patrolled" class="form-control" value="<?php echo !empty(set_value('time_patrolled')) ? set_value('time_patrolled') : $sweet_form[0]['time_patrolled']; ?>" required>
                                      </div>
                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>II. LGU Patrolled:</label><?php echo form_error('lgu_patrolled'); ?>
                                        <select class="form-control" id="lgu_patrolled_selectize" name="lgu_patrolled">
                                          <option value="<?php echo !empty($this->session->userdata('edit_lgu_patrolled_session')) ? ($this->session->userdata('edit_lgu_patrolled_session')) : $this->encrypt->encode($sweet_form[0]['lgu_patrolled_id']); ?>"><?php echo !empty($this->session->userdata('edit_lgu_patrolled_session')) ? strtoupper($lgu_name_selected) : strtoupper($sweet_form[0]['lgu_patrolled_name']); ?>
                                          </option>
                                          <?php
                                            for ($lgu=0; $lgu < sizeof($query_lgu) ; $lgu++) {
                                              if(($query_lgu[$lgu]['emb_id']) != ''){
                                                echo '<option value="'.$this->encrypt->encode($query_lgu[$lgu]['emb_id']).'">'.strtoupper($query_lgu[$lgu]['lgu_name']).'</option>';
                                              }
                                            }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>III. Violation(s) Observed:</label>&nbsp;<span style="color:orange;" class="fa fa-info-circle" title="<?= $ifcln = ($tomrs == 'Clean') ? "If it is a clean report, checkboxes will disabled" : "If it is a clean report, checkboxes will disabled"; ?>"></span>
                                        <table class="table table-bordered" style="text-align: center; width: 100%;">
                                            <tr>
                                              <td><b>&nbsp;Check (<span class="fa fa-check"></span>) as appropriate</b></td>
                                              <td><b>Prohibited Act</b></td>
                                              <td><b>Section Chapter VI, RA 9003</b></td>
                                            </tr>
                                            <?php
                                              $enordis = ($tomrs == 'Clean') ? "disabled" : '';
                                              $arrsetval = array();
                                              $arraythree = set_value('three[]');
                                              if(!empty($arraythree)){
                                                foreach ($arraythree as $key => $value) {
                                                  $arrsetval[$key] =  str_replace(';','',$this->encrypt->decode($value));

                                                }
                                              }
                                              $selectedvo = explode(';', $sweet_form[0]['violations_observed_desc']);
                                              $arrayvo = !empty($arrsetval) ? $arrsetval : $selectedvo;

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
                                          <label class="mainftsweet">IV.
                                            <span class="mainftsweet" style="margin-left: 10px;">
                                              Exact Location and type of area where violations(s) was/were observed (fill up and check as appropriate):
                                            </span>
                                          </label>
                                        </div>

                                        <div class="col-md-4" id="sw_barangay_div">
                                          <label class="address">Barangay:</label>
                                          <select class="form-control" id="sw_barangay_selectize" name="barangay">
                                            <option value="<?php echo !empty($this->session->userdata('edit_barangay_session')) ? $this->session->userdata('edit_barangay_session') : $this->encrypt->encode($sweet_form[0]['barangay_id']); ?>">
                                              <?php echo !empty($this->session->userdata('edit_barangay_session')) ? $brgy_name_selected : $sweet_form[0]['barangay_name']; ?>
                                            </option>
                                            <?php for ($brgy=0; $brgy < sizeof($qrybrgy) ; $brgy++) {
                                              if(($qrybrgy[$brgy]['id']) != ''){
                                                echo '<option value="'.$this->encrypt->encode($qrybrgy[$brgy]['id']).'">'.$qrybrgy[$brgy]['name'].'</option>';
                                              }
                                            } ?>
                                          </select>
                                        </div>

                                        <div class="col-md-4">
                                          <label class="address">Street:</label>
                                          <input type="text" class="form-control" name="street" value="<?php echo !empty(set_value('street')) ? set_value('street') : $sweet_form[0]['street']; ?>">
                                        </div>

                                        <div class="col-md-2">
                                          <label class="address">Latitude:</label>
                                          <input type="text" class="form-control"  name="latitude" value="<?php echo !empty(set_value('latitude')) ? set_value('latitude') : $sweet_form[0]['latitude']; ?>">
                                        </div>

                                        <div class="col-md-2">
                                          <label class="address">Longitude:</label>
                                          <input type="text" class="form-control"  name="longitude" value="<?php echo !empty(set_value('longitude')) ? set_value('longitude') : $sweet_form[0]['longitude']; ?>">
                                        </div>

                                        <div class="col-md-12" style=""><hr>
                                          <center><label class="mainftsweet" style="color:#000;font-size: 15px;margin: 15px 0px 15px 0px;"><b>TYPE OF AREA/PUBLIC PLACE</b></label></center>
                                        </div>

                                          <?php
                                              $arrsetvalf = array();
                                              $arrayfour = set_value('four[]');
                                              if(!empty($arrayfour)){
                                                foreach ($arrayfour as $key => $value) {
                                                  $arrsetvalf[$key] =  str_replace(';','',($value));

                                                }
                                              }
                                              $selectedtoa = explode(";",$sweet_form[0]['type_of_area_desc']);
                                              $arraytoa = !empty($arrsetvalf) ? $arrsetvalf : $selectedtoa;

                                              $dv = "";
                                              for ($i=0; $i < sizeof($swtoa); $i++) {
                                              $checked = (in_array($swtoa[$i]['toatitle'], $arraytoa)) ? "checked" : "";
                                              $dv.= '<div class="col-md-3 toa">
                                                        <label class="container_sw">
                                                          <input type="checkbox" name="four[]" value="'.$swtoa[$i]['toatitle'].";".'" '.$checked.'>
                                                          <span class="checkmark toa"></span>'.$swtoa[$i]['toatitle'].'
                                                        </label>
                                                    </div>';
                                              }

                                              echo $dv;

                                              $otherschecked = !empty($sweet_form[0]['if_others_tom']) ? "" : "";
                                              $do= '<div class="col-md-3 toa" id="sw_others_div">';
                                                      if($sweet_form[0]['if_others_tom'] != ''){
                                              $do.=  '<input type="text" value="'.$sweet_form[0]['if_others_tom'].'" style="width:90%;border-radius:2px;border:1pxsolid #D1D3E2;color:#000;" disabled="">&nbsp;';
                                                      }else{
                                              $do.=  '<label class="container_sw">
                                                        <input type="checkbox"  onclick="sw_others(this.value);" value="'.$this->encrypt->encode('others').'" '.$otherschecked.'>
                                                        <span class="checkmark toa"></span>Others
                                                      </label>';
                                                    }
                                              $do.=  '</div>';

                                              echo $do;
                                            ?>
                                      </div><hr>

                                      <div class="col-md-12" style="padding-bottom:10px;">
                                        <label class="mainftsweet">V.
                                          <span class="mainftsweet" style="margin-left: 10px;">Type of Monitoring Activity (pls. check, fill up as appropriate)</span>
                                        </label>
                                      </div>

                                      <?php
                                      $report_number = !empty($this->session->userdata('edit_report_number_session')) ? $this->encrypt->decode($this->session->userdata('edit_report_number_session')) : $this->encrypt->decode($this->input->get('rn'));

                                        for ($tm=0; $tm < sizeof($tom); $tm++) {
                                          if($report_number > '1'){
                                            if(($tom[$tm]['tomid']) != '1'){
                                              if(!empty($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')))){
                                                $arraytom = array($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')));
                                              }else{
                                                $arraytom = array($sweet_form[0]['type_of_monitoring']);
                                              }
                                              $checked = (in_array($tom[$tm]['tomid'], $arraytom)) ? "checked" : "";  ?>
                                              <div class="col-md-12" style="padding-bottom:5px;">
                                                      <label class="container_radio">
                                                        <span class="radio_text"><?php echo $tom[$tm]['tomtitle']; ?></span>
                                                        <input type="radio" name="type_of_monitoring" id="sw_type_of_monitoring" onclick=swtom(this.value,$('#sw_date_patrolled').val(),'<?php echo $sweet_form[0]['report_number']; ?>','<?php echo $sweet_form[0]['date_of_first_monitoring']; ?>',$('#sw_trans_no').val());
                                                        value="<?php echo $this->encrypt->encode($tom[$tm]['tomid']); ?>" <?php echo $checked; ?>/>
                                                        <span class="checkmark"></span>
                                                      </label>
                                                    </div>
                                              <?php
                                            }
                                          }else{
                                            if(($tom[$tm]['tomid']) == '1'){
                                              echo '<div class="col-md-12" style="padding-bottom:5px;">
                                                      <label class="container_radio">
                                                        <span class="radio_text">'.$tom[$tm]['tomtitle'].'</span>
                                                        <input type="radio" name="type_of_monitoring" onclick=swtom(this.value,"'.$tom[$tm]['tomid'].'","'.$sweet_form[0]['report_number'].'","'.$sweet_form[0]['date_patrolled'].'");
                                                        value="'.$this->encrypt->encode($tom[$tm]['tomid']).'" checked>
                                                        <span class="checkmark"></span>
                                                      </label>
                                                    </div>';
                                            }
                                          }

                                        }

                                        if(!empty($sweet_form[0]['date_of_last_monitoring'])){
                                          $nv_dt_lm = $sweet_form[0]['date_of_last_monitoring'];
                                        }else if(!empty($sweet_form[0]['date_of_second_monitoring'])){
                                          $nv_dt_lm = $sweet_form[0]['date_of_second_monitoring'];
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
                                              <input type="date" class="form-control" name="dtsm" value="<?php echo !empty(set_value('dtsm')) ? set_value('dtsm') : $sweet_form[0]['date_of_second_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of last monitoring:</label><?php echo form_error('dtlm'); ?>
                                              <input type="date" class="form-control" name="dtlm"  value="<?php echo !empty(set_value('dtlm')) ? set_value('dtlm') : $nv_dt_lm; ?>">
                                            </div>
                                          <?php }else{ ?>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm"  value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of second monitoring:</label><?php echo form_error('dtsm'); ?>
                                              <input type="date" class="form-control" name="dtsm"  value="<?php echo !empty(set_value('dtsm')) ? set_value('dtsm') : $sweet_form[0]['date_of_second_monitoring']; ?>">
                                            </div>
                                          <?php } ?>
                                        <?php }else if($this->encrypt->decode($this->session->userdata('type_of_monitoring_session')) == '3' OR $sweet_form[0]['type_of_monitoring'] == '3'){ ?>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of first monitoring:</label><?php echo form_error('dtfm'); ?>
                                              <input type="date" class="form-control" name="dtfm" value="<?php echo !empty(set_value('dtfm')) ? set_value('dtfm') : $sweet_form[0]['date_of_first_monitoring']; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of last monitoring:</label>
                                              <input type="date" class="form-control" name="dtlm" value="<?php echo !empty(set_value('dtlm')) ? set_value('dtlm') : $nv_dt_lm; ?>">
                                            </div>
                                            <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
                                              <label>Date of issuance of last Notice:</label>
                                              <input type="date" class="form-control" name="dtiln" value="<?php echo !empty(set_value('dtiln')) ? set_value('dtiln') : $sweet_form[0]['date_of_issuance_of_notice']; ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Number of times same site is found with illegal dumping:</label>
                                              <input type="text" class="form-control" name="nil" value="<?php echo !empty(set_value('nil')) ? set_value('nil') : $sweet_form[0]['number_dumping']; ?>">
                                            </div>
                                            <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                              <label>Number of times same site is found with open burning activity:</label>
                                              <input type="text" class="form-control" name="noa" value="<?php echo !empty(set_value('noa')) ? set_value('noa') : $sweet_form[0]['number_activity']; ?>">
                                            </div>
                                        <?php } ?>
                                        </div>
                                      </div>

                                      <div class="col-md-12" style="margin-top:10px;">
                                        <label>VI. Updated photo documentation / picture of the site:</label>
                                        <label style="float:right;">Previously attached:
                                          <a href="#" data-toggle='modal' data-target='#edit_viewattachment' onclick=viewattachmentbtn("<?= !empty($this->session->userdata('edit_trans_no_session')) ? ($this->session->userdata('edit_trans_no_session')) : ($this->input->get('token')); ?>");>View attachment</a>
                                        </label>

                                        <?php if($report_number > 1){ ?>
                                          <label style="float:right;margin-right:10px;">Previous report photo attachment:
                                            <a href="#" data-toggle='modal' data-target='#prevviewattachment' onclick=prevviewattachmentbtn("<?= !empty($this->session->userdata('edit_trans_no_session')) ? ($this->session->userdata('edit_trans_no_session')) : ($this->input->get('token')); ?>","<?php echo $this->encrypt->encode($report_number); ?>");>View attachment</a>
                                          </label>
                                        <?php } ?>

                                        <div style="display:flex;" id="sitephotobtns_">
                                          <input type='file' class="form-control" disabled="">
                                          <button type="button" onclick="enable_upload_btn('<?= !empty($this->session->userdata('edit_trans_no_session')) ? ($this->session->userdata('edit_trans_no_session')) : ($this->input->get('token')); ?>','<?php echo !empty(set_value('month_monitoring')) ? set_value('month_monitoring') : date("Y-m", strtotime($sweet_form[0]['month_monitoring'])); ?>',$('#report_number_').val());" style="width: 135px; margin-left: 10px;" class="btn btn-warning btn-sm">
                                            <span class="fa fa-edit"></span>&nbsp;Edit Attachment</button>
                                        </div>
                                        <div class="progress" id="sweditsitephoto_" style="display:none; margin-top:5px;">
                      									  <div class="progress-bar progress-bar-striped progress-bar-animated" id="sweditsitephotouploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      											<span id="sweditsitephotoprogresspercentage_"></span>
                      										</div>
                      									</div>
                                      </div>

                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>Total land area covered by the solid waste (sq. m.):</label><?php echo form_error('ttlarea'); ?>
                                      <input type="text" class="form-control" name="ttlarea" value="<?php echo !empty(set_value('ttlarea')) ? set_value('ttlarea') : $sweet_form[0]['total_land_area']; ?>">
                                    </div>

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
                                      <textarea class="form-control photo" name="photo_remarks" id="photo_remarks" onkeyup="jstextarea($('#photo_remarks').val(),$('#additional_remarks').val(),<?= $photo_remarks_fp = strlen($sweet_form[0]['photo_remarks']); ?>);"><?php echo set_value('photo_remarks'); ?><?php echo !empty(set_value('photo_remarks')) ? (set_value('photo_remarks')) : $sweet_form[0]['photo_remarks']; ?>
                                      </textarea>
                                    </div>
                                    <div class="col-md-12" style="margin-top:10px;">
                                      <label>VII. Additional Findings / Remarks:</label><?php echo form_error('additional_remarks'); ?>
                                      <textarea class="form-control remarks" name="additional_remarks" id="additional_remarks" onkeyup="jstextarea($('#photo_remarks').val(),$('#additional_remarks').val(),<?= $photo_remarks_fp = strlen($sweet_form[0]['photo_remarks']); ?>);"><?php echo set_value('additional_remarks'); ?><?= $sweet_form[0]['additional_remarks']; ?>
                                      </textarea>
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
                                        $selectedatbu = explode("|", $sweet_form[0]['actions_undertaken_desc']);
                                        $arrayatbu = !empty($arrsetvala) ? $arrsetvala : $selectedatbu;

                                      for ($atbu=0; $atbu < sizeof($swatbu) ; $atbu++) {
                                      $rgnnamevar = $swatbu[$atbu]['atbuid'] == '4' ? $rgnname : "";
                                      $checked = (in_array($swatbu[$atbu]['atbutitle'], $arrayatbu))
                                      ? "checked" : "";
                                      echo '<div class="col-md-12" style="padding-bottom:10px;">
                                              <label class="container_sw">
                                                <span class="checkbox">'.$swatbu[$atbu]['atbutitle']." ".$rgnnamevar." ".$swatbu[$atbu]['title_two'].'<span style="color:red;">&nbsp;'.$swatbu[$atbu]['title_three'].'</span>
                                                <input type="checkbox" name="atbu[]" value="'.$this->encrypt->encode($swatbu[$atbu]['atbutitle']."|").'" '.$checked.'>
                                                <span class="checkmark toa"></span>
                                              </label>
                                            </div>';
                                      } ?>
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
                  <?php if($this->encrypt->decode($this->input->get('editcat')) == '1'){ ?>
                    <button type="submit" name="submit_save_button" class="btn btn-primary btn-icon-split"><span class="text"> <i class="fas fa-save"></i> Save</span></button> <br /><br />
                  <?php }else{ ?>
                    <button type="submit" name="submit_edit_button" class="btn btn-success btn-icon-split"><span class="text"> <i class="fas fa-share-square"></i> Process</span></button> <br /><br />
                  <?php } ?>
                </div>
              </div>

            </form>

            <script type="text/javascript">
              $('#lgu_patrolled_selectize').selectize();
              $('#sw_barangay_selectize').selectize();
              $('#travel_cat_selectize').selectize();
              $('#semi_monthly_selectize').selectize();


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
