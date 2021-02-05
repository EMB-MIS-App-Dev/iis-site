<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sweet_ajax extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->model('Sweetreportmodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');

  }

  function sw_barangay(){
    $emb_id = $this->encrypt->decode($this->input->post('token', TRUE));
    $where  = $this->db->where('dy.emb_id',$emb_id);
    $query  = $this->Embismodel->selectdata('embis.dms_company AS dy','dy.city_id','',$where);

    $city_id = !empty($query[0]['city_id']) ? $query[0]['city_id'] : '';

    $orderbrgy = $this->db->order_by('dy.name','ASC');
    $wherebrgy = $this->db->where('dy.city_id',$city_id);
    $qrybrgy   = $this->Embismodel->selectdata('embis.dms_barangay AS dy','dy.id,dy.name','',$wherebrgy,$orderbrgy);

  ?>
    <label>Barangay:</label>
    <select class="form-control" id="sw_barangay" name="sw_barangay" required="">
        <option value="" selected=""></option>
      <?php for ($i=0; $i < sizeof($qrybrgy); $i++) { ?>
        <option value="<?php echo $this->encrypt->encode($qrybrgy[$i]['id']); ?>"><?php echo $qrybrgy[$i]['name']; ?></option>
      <?php } ?>
    </select>
    <script type="text/javascript">
      $('#sw_barangay').selectize();
    </script>
  <?php
  }

  function sw_others(){
    $others = "";
    $others = $this->encrypt->decode($this->input->post('token', TRUE));
    if($others == 'others'){ ?>
      <input type="text" name="if_toa_others" placeholder="Please specify" style="width: 90%;" required="">&nbsp;
      <span style="color:#000;cursor:pointer;" class="fa fa-undo" onclick=sw_others("<?php echo $this->encrypt->encode('undo_others'); ?>");></span>
  <?php }else if($others == 'undo_others'){ ?>
      <label class="container_sw">
        <input type="checkbox"  onclick="sw_others(this.value);" value="<?php echo $this->encrypt->encode('others'); ?>">
        <span class="checkmark toa"></span>Others
      </label>
  <?php
    }
  }

  function swtom(){
    $tomid = $this->encrypt->decode($this->input->post('token', TRUE));
    $rn    = ($this->input->post('rn', TRUE));
    $dt_ptrl = ($this->input->post('dt_ptrl', TRUE));
    $trans_no = ($this->input->post('trans_no', TRUE));

    $wherelog  = array('sf.trans_no' => $trans_no );
    $selectlog = $this->Embismodel->selectdata('sweet_form AS sf','',$wherelog);

    $dt_ft = !empty($this->input->post('dt_ft')) ? ($this->input->post('dt_ft', TRUE)) : set_value('dtfm');
    $dt_sm = (!empty($selectlog[0]['date_of_second_monitoring'])) ? $selectlog[0]['date_of_second_monitoring'] : $dt_ptrl;

    if(!empty($selectlog[0]['date_of_last_monitoring'])){
      $nv_dt_lm = $selectlog[0]['date_of_last_monitoring'];
    }else if(!empty($selectlog[0]['date_of_second_monitoring'])){
      $nv_dt_lm = $selectlog[0]['date_of_second_monitoring'];
    }else{
      $nv_dt_lm = $dt_ptrl;
    }

    if($tomid == 2){
      if($rn >= '3'){
    ?>
      <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
        <label>Date of first monitoring:</label>
        <input type="date" class="form-control" name="dtfm" value="<?php echo $dt_ft; ?>">
      </div>
      <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
        <label>Date of second monitoring:</label>
        <input type="date" class="form-control" name="dtsm" value="<?php echo $dt_sm; ?>">
      </div>
      <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
        <label>Date of last monitoring:</label>
        <input type="date" class="form-control" name="dtlm" value="<?php echo $nv_dt_lm; ?>">
      </div>
    <?php }else{ ?>
      <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
        <label>Date of first monitoring:</label>
        <input type="date" class="form-control" name="dtfm" value="<?php echo $dt_ft; ?>">
      </div>
      <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
        <label>Date of second monitoring:</label>
        <input type="date" class="form-control" name="dtsm" value="<?php echo $nv_dt_lm; ?>">
      </div>
    <?php }
    }else if($tomid == 3){
    ?>
      <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
        <label>Date of first monitoring:</label>
        <input type="date" class="form-control" name="dtfm" value="<?php echo $dt_ft; ?>">
      </div>
      <div class="col-md-4" style="margin: 0px 0px 20px 0px;">
        <label>Date of last monitoring:</label>
        <input type="date" class="form-control" name="dtlm" value="<?php echo $nv_dt_lm; ?>">
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
    <?php
    }
  }

  function process_details(){
    $trans_no = $_POST['trans_no'];
    $rn = $this->encrypt->decode($_POST['rn']);

    $whereform  = $this->db->where('sf.trans_no = "'.$trans_no.'" AND sf.report_number = "'.$rn.'"');
    $selectform = $this->Embismodel->selectdata('sweet_form_log AS sf','*','',$whereform);

    $street = (!empty($selectform[0]['street'])) ? $selectform[0]['street'] : "-";

    $whereaddress = $this->db->where('dc.emb_id',$selectform[0]['lgu_patrolled_id']);
    $joinaddress  = $this->db->join('acc_region AS ar','ar.rgnnum = dc.region_name','left');
    $queryaddress = $this->Embismodel->selectdata('dms_company AS dc','dc.city_name, dc.province_name, ar.rgnnumeral, ar.rgnname','',$whereaddress);

    $methodofinspection = ($selectform[0]['travel_no'] == 'NTOR') ? 'No T.O - '.$selectform[0]['inspection_method']: 'With Approved Travel Order: '.$selectform[0]['travel_no'];
  ?>
    <style type="text/css">
      #qckvwsw{
        margin-top: 10px;
      }
      #checkqckvwswspan{
        color:#000;
        font-weight: normal;
        font-size: 12pt;
      }#checkqckvwswlabel{
        color:#256525;
        margin-left: 10px;
        font-size: 12pt;
      }
      label{
        color:#000;
      }
    </style>
    <form action="<?php echo base_url(); ?>Swm/Sweet_postactions/process_sweet_report" method="POST">
      <div id="disapproval-reason">
        <div class="modal-body">
          <div class="row">
            <?php if($selectform[0]['status'] != 'Approved' AND $selectform[0]['status'] != 'Signed Document' AND $selectform[0]['status'] != 'On-Process'){ ?>
              <div class="col-md-12" style="margin-top:15px;">
                <center><label style="font-weight: bold;background-color:#E74A3B;color:#FFF;padding: 3px 15px 3px 15px;width:100%;">REPORT STATUS: RETURNED</label></center>
              </div>
              <div class="col-md-12">
                <textarea class="form-control" readonly><?php echo $selectform[0]['status']; ?></textarea><hr>
              </div>
            <?php } ?>
            <div class="col-md-12">
              <label>Method of Inspection:</label>
              <textarea class="form-control" readonly><?php echo $methodofinspection; ?></textarea>
            </div>
            <div class="col-md-4">
              <label>Transaction No.:</label>
              <input type="text" class="form-control" value="<?php echo $trans_no; ?>" readonly>
              <input type="hidden" class="form-control" name="trans_no" value="<?php echo $this->encrypt->encode($trans_no); ?>">
              <input type="hidden" class="form-control" name="report_number" value="<?php echo $this->encrypt->encode($selectform[0]['report_number']); ?>">
            </div>
            <div class="col-md-4">
              <label>Type of Report:</label>
              <input type="text" class="form-control" value="<?= $selectform[0]['report_type']; ?>" disabled="">
            </div>
            <div class="col-md-4">
              <label>View Report:</label><br>
              <a href="<?php echo base_url().'swm/form?token='.$this->encrypt->encode($trans_no).'&rn='.$this->encrypt->encode($selectform[0]['report_number']); ?>" target="_blank" type="button" style="width:100%;" class="btn btn-sm btn-danger"><span class="fa fa-file"></span> PDF Report</a>
            </div>
            <?php if($selectform[0]['report_type'] == 'Clean'){ ?>
              <div class="col-md-6" id="qckvwsw">
                <label>Final Disposal of Solid Waste:</label><br>
                <input type="text" class="form-control" value="<?= $selectform[0]['final_disposal']; ?>" disabled="">
              </div>
              <div class="col-md-6" id="qckvwsw">
                <label>Location of Disposal:</label><br>
                <input type="text" class="form-control" value="<?= $selectform[0]['fd_location']; ?>" disabled="">
              </div>
              <div class="col-md-4" id="qckvwsw">
                <label>Latitude:</label><br>
                <input type="text" class="form-control" value="<?= $selectform[0]['fd_latitude']; ?>" disabled="">
              </div>
              <div class="col-md-4" id="qckvwsw">
                <label>Longitude:</label><br>
                <input type="text" class="form-control" value="<?= $selectform[0]['fd_longitude']; ?>" disabled="">
              </div>
              <div class="col-md-4" id="qckvwsw">
                <label>Check coordinates via Google map:</label><br>
                <a style="width:100%;height:35px;" class="btn btn-sm btn-info" href="https://www.google.com/maps/search/<?php echo $selectform[0]['fd_latitude'].",".$selectform[0]['fd_longitude']; ?>" target="_blank" title="Locate destination to get latitude and longitude"><span class="fa fa-map-marker"></span> Check Geo Coordinates</a>
              </div>
            <?php } ?>
            <div class="col-md-12" style="margin-top:15px;">
              <center><label style="font-weight: bold;background-color:#0B4F84;color:#FFF;padding: 3px 15px 3px 15px;width:100%;">REPORT DETAILS</label></center>
            </div>
            <div class="col-md-6">
              <label>Date Patrolled:</label>
              <input type="text" class="form-control" value="<?= date('F d, Y', strtotime($selectform[0]['date_patrolled'])); ?>" disabled="">
            </div>
            <div class="col-md-6">
              <label>Time Patrolled:</label>
              <input type="text" class="form-control" value="<?= date("h:i:s A", strtotime($selectform[0]['time_patrolled'])); ?>" disabled="">
            </div>
            <div class="col-md-4" id="qckvwsw">
              <label>LGU Patrolled:</label>
              <input type="text" class="form-control" value="<?= $selectform[0]['lgu_patrolled_name']; ?>" disabled="">
            </div>
            <div class="col-md-4" id="qckvwsw">
              <label>Province:</label>
              <input type="text" class="form-control" value="<?= trim($queryaddress[0]['province_name']); ?>" disabled="">
            </div>
            <div class="col-md-4" id="qckvwsw">
              <label>Region:</label>
              <input type="text" class="form-control" value="<?= trim($queryaddress[0]['rgnnumeral']); ?>" disabled="">
            </div>
            <div class="col-md-3" id="qckvwsw">
              <label>Street:</label>
              <input type="text" class="form-control" value="<?= $street; ?>" disabled="">
            </div>
            <div class="col-md-3" id="qckvwsw">
              <label>Barangay:</label>
              <input type="text" class="form-control" value="<?= ($selectform[0]['barangay_name']); ?>" disabled="">
            </div>
            <div class="col-md-3" id="qckvwsw">
              <label>Latitude:</label>
              <input type="text" class="form-control" value="<?= ($selectform[0]['latitude']); ?>" disabled="">
            </div>
            <div class="col-md-3" id="qckvwsw">
              <label>Longitude:</label>
              <input type="text" class="form-control" value="<?= ($selectform[0]['longitude']); ?>" disabled="">
            </div>
            <div class="col-md-12" style="margin-top: 15px;">
              <label style="margin-right: 30px;">Violation(s) Observed:</label>
                <?php
                  $vod = explode(";", $selectform[0]['violations_observed_desc']);
                  for ($vo=0; $vo < sizeof($vod); $vo++) {
                    if(!empty($vod[$vo])){
                      echo '<label class="fa fa-check" id="checkqckvwswlabel"><span id="checkqckvwswspan">'." ".$vod[$vo].";".'</span></label>';
                    }
                  }
                ?>
            </div>
            <div class="col-md-12" id="qckvwsw">
              <label style="margin-right: 1px;">Type of Area / Public Place:</label>
                <?php
                  $toa = explode(";", $selectform[0]['type_of_area_desc']);
                  for ($to=0; $to < sizeof($toa); $to++) {
                    if(!empty($toa[$to])){
                      echo '<label class="fa fa-check" id="checkqckvwswlabel"><span id="checkqckvwswspan">'." ".$toa[$to].";".'</span></label>';
                    }
                  }
                ?>
            </div>
            <div class="col-md-12" id="qckvwsw">
              <label>Type of Monitoring Activity:</label>
                <?php
                  echo '<label class="fa fa-check" id="checkqckvwswlabel"><span id="checkqckvwswspan">'." ".$selectform[0]['type_of_monitoring_desc'].";".'</span></label>';
                ?>
            </div>
            <?php
              if($selectform[0]['type_of_monitoring'] == '2'){
                if($selectform[0]['report_number'] >= '3'){
            ?>
                <div class="col-md-4">
                  <label style="color:#000;">First monitoring:</label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_first_monitoring'])); ?>" readonly>
                </div>
                <div class="col-md-4">
                  <label style="color:#000;">Second monitoring: </label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_second_monitoring'])); ?>" readonly>
                </div>
                <div class="col-md-4">
                  <label style="color:#000;">Last monitoring: </label>
                  <input type="text" class="form-control"value="<?= (!empty($selectform[0]['date_of_last_monitoring']) ? date("M d, Y", strtotime($selectform[0]['date_of_last_monitoring'])) : date("M d, Y", strtotime($selectform[0]['date_patrolled']))); ?>" readonly>
                </div>
              <?php }else{ ?>
                <div class="col-md-6">
                  <label style="color:#000;">First monitoring: </label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_first_monitoring'])); ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label style="color:#000;">Last monitoring: </label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_second_monitoring'])); ?>" readonly>
                </div>
              <?php } ?>
            <?php } ?>
            <?php
              if($selectform[0]['type_of_monitoring'] == '3'){
            ?>
                <div class="col-md-4">
                  <label style="color:#000;">First monitoring: </label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_first_monitoring'])); ?>" readonly>
                </div>
                <div class="col-md-4">
                  <label style="color:#000;">Last monitoring:</label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_second_monitoring'])); ?>" readonly>
                </div>
                <div class="col-md-4">
                  <label style="color:#000;">Date of issuance of last Notice:</label>
                  <input type="text" class="form-control"value="<?= date("M d, Y", strtotime($selectform[0]['date_of_issuance_of_notice'])); ?>" readonly>
                </div>
                <div class="col-md-6" id="qckvwsw">
                  <label style="color:#000;font-size:9pt;">Number of times same site is found with illegal dumping:</label>
                  <input type="text" class="form-control"value="<?= $selectform[0]['number_dumping']; ?>" readonly>
                </div>
                <div class="col-md-6" id="qckvwsw">
                  <label style="color:#000;font-size:9pt;">Number of times same site is found with open burning activity:</label>
                  <input type="text" class="form-control"value="<?= $selectform[0]['number_activity']; ?>" readonly>
                </div>
            <?php } ?>
            <?php
              $whereattachments = $this->db->where('sfa.trans_no = "'.$selectform[0]['trans_no'].'" AND sfa.report_number = "'.$selectform[0]['report_number'].'"');
              $queryattachments = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*','',$whereattachments);
              $attachmentpath   = base_url()."../iis-images/sweet_report/".date("Y", strtotime($selectform[0]['date_created']))."/".$selectform[0]['region']."/".$selectform[0]['trans_no']."/".$queryattachments[0]['attachment_name'];

              if($selectform[0]['report_number'] > 1){
                $report_numberleft = $selectform[0]['report_number'] - 1;
                $whereattachmentsleft = $this->db->where('sfa.trans_no = "'.$selectform[0]['trans_no'].'" AND sfa.report_number = "'.$report_numberleft.'"');
                $joinattachmentsleft  = $this->db->join('sweet_form_log as sfl','sfl.trans_no = sfa.trans_no AND sfl.report_number = sfa.report_number');
                $queryattachmentsleft = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*,sfl.date_created AS sfldate_created','',$joinattachmentsleft,$whereattachmentsleft);
                $attachmentpathleft   = base_url()."../iis-images/sweet_report/".date("Y", strtotime($queryattachmentsleft[0]['sfldate_created']))."/".$selectform[0]['region']."/".$selectform[0]['trans_no']."/".$queryattachmentsleft[0]['attachment_name'];

                $attachmentpathright  = base_url()."../iis-images/sweet_report/".date("Y", strtotime($queryattachmentsleft[0]['sfldate_created']))."/".$selectform[0]['region']."/".$selectform[0]['trans_no']."/".$queryattachments[0]['attachment_name'];

                $wheresweetleft = $this->db->where('sfl.trans_no = "'.$selectform[0]['trans_no'].'" AND sfl.report_number = "'.$report_numberleft.'"');
                $querysweetleft = $this->Embismodel->selectdata('sweet_form_log AS sfl','','',$wheresweetleft);
                // echo $this->db->last_query(); exit;
              }
            ?>
            <div class="col-md-12" id="qckvwsw">
              <label>Photo documentation/pictures of the same site taken during monitoring done on <b style="font-weight:normal;color:#000;"><?= date('F d, Y', strtotime($selectform[0]['date_patrolled'])); ?>.</b></label>
              <?php if(!empty($attachmentpathleft)){ ?>
                <img style="border:1px solid #000; width: 49%; height: 350px;" src="<?= $attachmentpathleft; ?>">&nbsp;<img style="border:1px solid #000; width: 49%; height: 350px;" src="<?= $attachmentpathright; ?>">
                <div class="row">
                  <div class="col-md-6">
                    <center><label style="font-weight: bold;color: #000;">Figure 1</label></center>
                  </div>
                  <div class="col-md-6">
                    <center><label style="font-weight: bold;color: #000;">Figure 2</label></center>
                  </div>
                </div>
                <label style="color:#000;"><b style="font-weight: bold;">Figure 1:</b> <?= $querysweetleft[0]['photo_remarks']; ?></label>
                <label style="color:#000;"><b style="font-weight: bold;">Figure 2:</b> <?= $selectform[0]['photo_remarks']; ?></label>
              <?php }else{ ?>
                <img style="border:1px solid #000; width: 100%; height: 350px;" src="<?= $attachmentpath; ?>">
                <center><label style="font-weight: bold;color: #000;">Figure 1</label></center>
                <label style="color:#000;"><b style="font-weight: bold;">Figure 1:</b> <?= $selectform[0]['photo_remarks']; ?></label>
              <?php } ?>
            </div>
             <div class="col-md-12" id="qckvwsw">
              <label>Additional Findings / Remarks:</label><br>
              <label style="color:#000;margin-left: 20px;">Estimated land area covered by solid waste (sq. m.): <u><?= $selectform[0]['total_land_area']; ?></u></label>
              <label style="color:#000;"><?= $selectform[0]['additional_remarks']; ?></label>
            </div>

            <div class="col-md-12" style="margin-top: 15px;">
              <label style="margin-right: 30px;">Actions to be undertaken:</label><br>
                <?php
                  $atbu = explode("|", $selectform[0]['actions_undertaken_desc']);
                  for ($au=0; $au < sizeof($atbu); $au++) {
                    if(!empty($atbu[$au])){
                      echo '<label class="fa fa-check" style="margin-left:22px!important;" id="checkqckvwswlabel"><span id="checkqckvwswspan">'." ".$atbu[$au]."".'</span></label><br>';
                    }
                  }
                ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <?php if($selectform[0]['route_order'] != '1'){ ?>
          <button type="button" style="float:left;" onclick=swedit_report_evaluator('<?php echo $this->encrypt->encode($trans_no); ?>'); data-dismiss="modal" data-toggle='modal' data-target='#edit_report' title='Edit Report' class='btn btn-warning btn-sm'>Edit Report</button>
          <?php } ?>
          <button type="button" onclick=returnsw('<?php echo $this->encrypt->encode($trans_no); ?>','<?php echo $this->encrypt->encode($selectform[0]['report_number']); ?>'); class="btn btn-danger btn-sm">Return to Sender</button>
          <button type="submit" name="Approve" class="btn btn-success btn-sm">Approve</button>
        </div>
      </div>
    </form>
  <?php
  }

  function returnsw(){
    $trans_no = $this->encrypt->decode($_POST['token']);
    $report_number = $this->encrypt->decode($_POST['rn']);
  ?>
    <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label>Transaction No.:</label>
            <input type="text" class="form-control" value="<?php echo $trans_no; ?>" readonly>
            <input type="hidden" class="form-control" name="trans_no" value="<?php echo $this->encrypt->encode($trans_no); ?>">
            <input type="hidden" class="form-control" name="report_number" value="<?php echo $report_number; ?>">
          </div>
          <div class="col-md-6">
            <label>View Report:</label><br>
            <a href="<?php echo base_url().'Swm/Form?token='.$this->encrypt->encode($trans_no).'&rn='.$this->encrypt->encode($report_number); ?>" target="_blank" type="button" style="width:100%;" class="btn btn-sm btn-danger"><span class="fa fa-file"></span> PDF Report</a>
          </div>
          <div class="col-md-12" style="margin-top: 5px;">
            <label>You are about to return this report. Please provide reason below.</label><br>
            <textarea class="form-control" name="return_reason" required=""></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick=sw_process_report('<?php echo ($trans_no); ?>'); class="btn btn-danger btn-sm">Back to Previous</button>
        <button type="submit" name="Disapprove" class="btn btn-success btn-sm">Confirm</button>
      </div>
  <?php
  }

  function swupdate_report(){
    $token = $this->encrypt->decode($_POST['token']);
    $rn = $this->encrypt->decode($_POST['rn']);
    $where = $this->db->where('sf.trans_no = "'.$token.'" AND sf.report_number = "'.$rn.'"');
    $query = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.*','',$where);

    $whereattachments = $this->db->where('sfa.trans_no',$query[0]['trans_no']);
    $whereattachments = $this->db->where('sfa.report_number',$query[0]['report_number']);
    $queryattachments = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*','',$whereattachments);
    $attachmentpath   = base_url()."../iis-images/sweet_report/".date("Y", strtotime($query[0]['date_created']))."/".$query[0]['region']."/".$query[0]['trans_no']."/".$queryattachments[0]['attachment_name'];

    if($query[0]['report_number'] > 1){
      $report_numberleft = $query[0]['report_number'] - 1;
      $whereattachmentsleft = $this->db->where('sfa.trans_no = "'.$query[0]['trans_no'].'" AND sfa.report_number = "'.$report_numberleft.'"');
      $queryattachmentsleft = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*','',$whereattachmentsleft);
      $attachmentpathleft   = base_url()."../iis-images/sweet_report/".date("Y")."/".$query[0]['region']."/".$query[0]['trans_no']."/".$queryattachmentsleft[0]['attachment_name'];

      $wheresweetleft = $this->db->where('sfl.trans_no = "'.$query[0]['trans_no'].'" AND sfl.report_number = "'.$report_numberleft.'"');
      $querysweetleft = $this->Embismodel->selectdata('sweet_form_log AS sfl','','',$wheresweetleft);
    }

    $maxreportnumber  = $this->db->query("SELECT report_number AS rn FROM sweet_form AS sf WHERE sf.trans_no = '$token'")->result_array();
    $maxrn            = $maxreportnumber[0]['rn']+1;
  ?>

      <form action="<?php echo base_url(); ?>Swm/Sweet/update" method="POST">
        <div class="modal-body">
          <div class="row" style="color:#000;">
           <div class="col-md-4">
              <label>Date Patrolled:</label> <input type="text" class="form-control" value="<?php echo date("F d, Y", strtotime($query[0]['date_patrolled'])); ?>" readonly>
            </div>
            <div class="col-md-4">
              <label>Time Patrolled:</label> <input type="text" class="form-control" value="<?php echo date("F d, Y", strtotime($query[0]['time_patrolled'])); ?>" readonly>
            </div>
            <div class="col-md-4">
              <label>LGU Patrolled:</label> <input type="text" class="form-control" value="<?php echo str_replace('LGU','',$query[0]['lgu_patrolled_name']); ?>" readonly>
            </div>
            <div class="col-md-12" style="margin-top:5px;">
              <label>Site address:</label>
              <input type="text" class="form-control" value="<?php echo ucwords($query[0]['street'].", ".$query[0]['barangay_name'].", ".str_replace('LGU','',$query[0]['lgu_patrolled_name'])); ?>" readonly><hr>
            </div>
            <div class="col-md-12" style="margin-top:5px;">
              <label>Site photo:</label><label style="float:right;">Type of report: <b><?php echo $query[0]['report_type']; ?></b></label>
            </div>
            <?php if(!empty($attachmentpathleft)){ ?>
              <div class="col-md-12">
                <img style="border:1px solid #000; width: 49%; height: 350px;" src="<?= $attachmentpathleft; ?>">&nbsp;<img style="border:1px solid #000; width: 50%; height: 350px;" src="<?= $attachmentpath; ?>">
                <div class="row">
                  <div class="col-md-6">
                    <center><label style="font-weight: bold;color: #000;">Figure 1</label></center>
                  </div>
                  <div class="col-md-6">
                    <center><label style="font-weight: bold;color: #000;">Figure 2</label></center>
                  </div>
                </div>
              </div>
            <?php }else{ ?>
              <div class="col-md-12">
                <img style="border:1px solid #000; width:100%; height: 380px;" src="<?php echo $attachmentpath; ?>"><hr>
              </div>
            <?php } ?>
            <div class="col-md-12">
              <input type="hidden" class="form-control" name="rn" value="<?php echo $this->encrypt->encode($maxrn); ?>">
              <label>What's the current status of the site?</label>
              <select id="type_of_report" name="report_status" onchange="fnldspsl(this.value);" required="">
                <option value=""></option>
                <option value="<?php echo $this->encrypt->encode('Unclean'); ?>">Still unclean</option>
                <option value="<?php echo $this->encrypt->encode('Clean'); ?>">It's already clean</option>
              </select>
              <input type="hidden" class="form-control" name="token" required="" value="<?php echo $this->encrypt->encode($token); ?>">
            </div>
            <div class="col-md-12" id="fnldspsl_bdy"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button href="" style="float:left;" class="btn btn-success btn-sm">Confirm</button>
        </div>
      </form>
      <script type="text/javascript">
        $('#type_of_report').selectize();
      </script>

  <?php
  }

  function lgufeedbackbtn(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $wheredata = $this->db->where('sff.trans_no = "'.$token.'" AND status = "Active" ORDER BY sff.cnt ASC');
    $joindata = $this->db->join('crs.acc AS ac','ac.client_id = sff.userid','left');
    $querydata = $this->Embismodel->selectdata('embis.sweet_form_feedback AS sff','sff.*, ac.first_name, ac.last_name, ac.salutation','',$joindata,$wheredata);

    $whereselect = $this->db->where('sf.trans_no = "'.$token.'"');
    $queryselect = $this->Embismodel->selectdata('embis.sweet_form AS sf','sf.trans_no, sf.userid, sf.creator_name, sf.lgu_patrolled_name, sf.street, sf.barangay_name','',$whereselect);

    if($queryselect[0]['userid'] == $this->session->userdata('userid')){
      $setdata = array('feedback_seen' => 'seen', );
      $wheredataa = array('trans_no' => $token, );
      $updatedata = $this->Embismodel->updatedata($setdata, 'sweet_form_feedback', $wheredataa);
    }

    ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <label>IIS No.: </label>
            <input type="text" class="form-control" value="<?= $queryselect[0]['trans_no']; ?>" readonly>
          </div>
          <div class="col-md-3">
            <label>Casehandler: </label>
            <input type="text" class="form-control" value="<?= $queryselect[0]['creator_name']; ?>" readonly>
          </div>
          <div class="col-md-3">
            <label>LGU Patrolled: </label>
            <input type="text" class="form-control" value="<?= str_replace("LGU", "", $queryselect[0]['lgu_patrolled_name']); ?>" readonly>
          </div>
          <div class="col-md-3">
            <label>Location: </label>
            <input type="text" class="form-control" value="<?= $queryselect[0]['street'].", ". $queryselect[0]['barangay_name']; ?>" readonly>
          </div>
          <div class="col-md-12">
            <hr>
              <table id="lgufeedbackdttbl" class="table table-striped table-hover" style="text-align:center; zoom: 70%;">
                <thead style="background-color:#5A5C69;">
                  <tr>
                    <td style="color:#FFF;font-weight:bold;">Report Type</td>
                    <td style="color:#FFF;font-weight:bold;">Feedback Date</td>
                    <td style="color:#FFF;font-weight:bold;">From</td>
                    <td style="color:#FFF;font-weight:bold;">Remarks</td>
                    <td style="color:#FFF;font-weight:bold;">Attachment(s)</td>
                  </tr>
                </thead>
                <tbody>
                  <?php for ($i=0; $i < sizeof($querydata); $i++) { ?>
                    <?php
                      $attachment = '';
                      $cntr = 0;
                      if(!empty($querydata[$i]['attachments'])){
                        $wheredataselect = $this->db->where('sf.trans_no = "'.$token.'"');
                        $queryselect = $this->Embismodel->selectdata('sweet_form AS sf','sf.date_created, sf.region','',$wheredataselect);
                        $explodedata = explode('|',$querydata[$i]['attachments']);
                        for ($a=0; $a < count($explodedata); $a++) {
                          if(!empty($explodedata[$a])){
                            $cntr++;
                            $attachment .= "<a style='width:100%;margin-bottom:5px;' href='".base_url()."../iis-images/sweet_report/".date('Y', strtotime($queryselect[0]['date_created']))."/".$queryselect[0]['region']."/".$token."/".$explodedata[$a]."' target='_blank' class='btn btn-info btn-sm'>Attachment&nbsp;#".$cntr."</a><br>";
                          }
                        }
                      }
                      $firstname = (!empty($querydata[$i]['first_name'])) ? $querydata[$i]['first_name'] : '';
                      $lastname = (!empty($querydata[$i]['last_name'])) ? $querydata[$i]['last_name'] : '';
                      $salutation = (!empty($querydata[$i]['salutation'])) ? ' '.$querydata[$i]['salutation'] : '';
                      $client_name = ucwords($firstname.' '.$lastname).$salutation;
                    ?>
                    <tr>
                      <td><?php echo $querydata[$i]['report_type']; ?></td>
                      <td><?php echo date('F d, Y - h:i a', strtotime($querydata[$i]['datefeedback'])); ?></td>
                      <td><?php echo $client_name; ?></td>
                      <td><?php echo $querydata[$i]['remarks']; ?></td>
                      <td><?php echo $attachment; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    <?php
  }

  function fnldspsl(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $orderbysw  = $this->db->order_by('ssw.cnt','ASC');
    $selectsw = $this->Embismodel->selectdata('sweet_solid_waste AS ssw','','',$orderbysw);
    if($token == 'Clean'){ ?>
            <div class="row">
              <div class="col-md-4" name="sw_fdsw" id="fdsw_bdy">
                <label>Final Disposal of Solid Waste:</label>
                <select class="form-control" id="fdsw_selectize" name="sw_fdsw" onchange="fdsw_(this.value);" required>
                  <option value="">-</option>
                  <?php for ($i=0; $i < sizeof($selectsw); $i++) { echo '<option value="'.$selectsw[$i]['dsc'].'">'.$selectsw[$i]['dsc'].'</option>';  } ?>
                </select>
              </div>
              <div class="col-md-8">
                <label>Location:</label>
                <input type="text" class="form-control" name="sw_location" required>
              </div>
              <div class="col-md-6">
                <label>Latitude:</label>
                <input type="text" class="form-control" name="sw_latitude" required>
              </div>
              <div class="col-md-6">
                <label>Longitude:</label><a style="float:right;font-size:8pt;" class="btn btn-sm btn-info" href="https://www.google.com/maps/search/" target="_blank" title="Locate destination to get latitude and longitude"><span class="fa fa-map-marker"></span> Check Geo Coordinates</a>
                <input type="text" class="form-control" name="sw_longitude" required>
              </div>
            </div>
            <script type="text/javascript">
                $('#fdsw_selectize').selectize();
            </script>
      <?php
    }
  }

  function fdsw_(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    echo '
          <label>Final Disposal of Solid Waste:</label><a href="#" onclick="rtrntolistsw();" style="float:right;font-size:9pt;margin-top:6px;color:#000;" title="Return to list" class="fa fa-undo"></a>
          <input type="text" class="form-control" placeholder="Please specify" name="sw_fdsw" required>
         ';
  }

  function rtrntolistsw(){
    $orderbysw  = $this->db->order_by('ssw.cnt','ASC');
    $selectsw = $this->Embismodel->selectdata('sweet_solid_waste AS ssw','','',$orderbysw); ?>
    <label>Final Disposal of Solid Waste:</label>
    <select class="form-control" id="fdsw_selectize" name="sw_fdsw" onchange="fdsw_(this.value);" required>
      <option value="">-</option>
      <?php for ($i=0; $i < sizeof($selectsw); $i++) { echo '<option value="'.$selectsw[$i]['dsc'].'">'.$selectsw[$i]['dsc'].'</option>';  } ?>
    </select>
    <script type="text/javascript">
        $('#fdsw_selectize').selectize();
    </script>
  <?php
  }

  function view_sw_history(){
    $token = $this->encrypt->decode($_POST['token']);
    $where_log  = $this->db->where('sfl.trans_no = "'.$token.'" ORDER BY date_created ASC, cnt ASC');
    $select_log = $this->Embismodel->selectdata('sweet_form_log AS sfl','*','',$where_log);

  ?>
    <div class="modal-body">
      <div class="row" style="margin:0px;">
        <div class="col-md-3" style="padding-left:0px;">
          <label>IIS No.: </label>
          <input type="text" class="form-control" value="<?= $select_log[0]['trans_no']; ?>" readonly>
        </div>
        <div class="col-md-3">
          <label>Casehandler: </label>
          <input type="text" class="form-control" value="<?= $select_log[0]['creator_name']; ?>" readonly>
        </div>
        <div class="col-md-3">
          <label>LGU Patrolled: </label>
          <input type="text" class="form-control" value="<?= str_replace("LGU", "", $select_log[0]['lgu_patrolled_name']); ?>" readonly>
        </div>
        <div class="col-md-3" style="padding-right:0px;">
          <label>Location: </label>
          <input type="text" class="form-control" value="<?= $select_log[0]['street'].", ". $select_log[0]['barangay_name']; ?>" readonly>
        </div>
      </div>
      <hr>
      <div class="table-responsive" style="padding: 10px 2px 0px 2px;">
        <table id="view_sw_history_table" class="table table-striped" style="zoom: 70%">
          <thead class="thead-dark">
            <tr>
              <th></th>
              <th  style="min-width: 125px;"> Date Created </th>
              <th> Date Patrolled </th>
              <th  style="min-width: 135px;"> Type of Report </th>
              <th  style="min-width: 180px;"> Type of Monitoring </th>
              <th  style="min-width: 180px;"> Violations Observed </th>
              <th  style="min-width: 150px;"> Est. Area (sq. m.) </th>
              <th> Actions to be undertaken </th>
              <th> Status </th>
              <th> Assigned </th>
            </tr>
          </thead>
          <tbody>
            <?php
              for ($i=0; $i < sizeof($select_log); $i++) {
                if($select_log[$i]['status'] == 'Signed Document'){
                  $status = "<img src='".base_url()."../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>".$select_log[$i]['status']."</span>";
                }else if($select_log[$i]['status'] == 'On-Process'){
                  $status = "<img src='".base_url()."../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>".$select_log[$i]['status']."</span>";
                }else{
                  $status = "<img src='".base_url()."../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                }
                $assigned = (trim($select_log[$i]['assigned_name']) != '') ? $select_log[$i]['assigned_name'] : "-";
            ?>
            <tr>
              <td><a title='View Report' class='btn btn-danger btn-sm' href='<?php echo base_url(); ?>swm/form?token=<?= $_POST['token']; ?>&rn=<?= $this->encrypt->encode($select_log[$i]['report_number']); ?>' target='_blank'><span class='fa fa-file'></span></a> </td>
              <td><?= date('M d, Y', strtotime($select_log[$i]['date_created'])); ?></td>
              <td><?= date('M d, Y', strtotime($select_log[$i]['date_patrolled']))." ".date('h:i a', strtotime($select_log[$i]['time_patrolled'])); ?></td>
              <td><?= $select_log[$i]['report_type']; ?></td>
              <td><?= "Month of ".$select_log[$i]['month_monitoring']." - ".$select_log[$i]['type_of_monitoring_desc']; ?></td>
              <td><?= !empty($select_log[$i]['violations_observed_desc']) ? str_replace(";", ";<br>", $select_log[$i]['violations_observed_desc']) : '-'; ?></td>
              <td><?= $select_log[$i]['total_land_area']; ?></td>
              <td><?= !empty($select_log[$i]['actions_undertaken_desc']) ? str_replace("|", "<br>", $select_log[$i]['actions_undertaken_desc']) : '-'; ?></td>
              <td><?= $status; ?></td>
              <td><?= $assigned; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
    </div>
  <?php
  }

  function swedit_report(){
      $token = $this->encrypt->decode($this->input->post('token', TRUE));
      $cat = $this->input->post('cat', TRUE);
      $wheredata  = $this->db->where('et.token = "'.$token.'"');
      $joindata   = $this->db->join('sweet_form AS sf','sf.trans_no = et.token','left');
      $selectdata = $this->Embismodel->selectdata('er_transactions AS et','et.action_taken,sf.report_number,sf.report_type,sf.final_disposal,sf.fd_location,sf.fd_latitude,sf.fd_longitude,et.status_description','',$joindata,$wheredata);
      $ifreporttype = ($selectdata[0]['report_type'] == 'Clean') ? "Unclean" : "Clean";

      $orderbysw  = $this->db->order_by('ssw.cnt','ASC');
      $selectsw = $this->Embismodel->selectdata('sweet_solid_waste AS ssw','','',$orderbysw);
      // echo $selectdata[0]['status_description'];
  ?>
    <form action="<?php echo base_url(); ?>Swm/Sweet/edit" method="GET">
      <div class="modal-body">
         <div class="row">
             <div class="col-md-12">
               <?php if($selectdata[0]['status_description'] == 'For return'){ ?>
                 <label>Evaluator comment:</label>
                 <textarea class="form-control" disabled=""><?= $selectdata[0]['action_taken']; ?></textarea>
               <?php } ?>
               <input type="hidden" name="token" value="<?php echo $this->input->post('token'); ?>" required>
               <input type="hidden" name="rn" value="<?php echo $this->encrypt->encode($selectdata[0]['report_number']); ?>" required>
               <input type="hidden" name="editcat" value="<?php echo $this->encrypt->encode($cat); ?>" required>
             </div>
           <div class="col-md-12" style="margin-top:5px;">
             <label>Report Status:</label>
             <select class="form-control" id="swedit_report_status" onchange="fnldspsl(this.value);" name="rs" required>
               <option value="<?php echo $this->encrypt->encode($selectdata[0]['report_type']); ?>"><?php echo $selectdata[0]['report_type']; ?></option>
               <option value="<?= $this->encrypt->encode($ifreporttype); ?>"><?= $ifreporttype; ?></option>
             </select>
           </div>
           <div class="col-md-12" id="fnldspsl_bdy">
             <?php if($selectdata[0]['report_type'] == 'Clean'){ ?>
               <div class="row">
                 <div class="col-md-4" name="sw_fdsw" id="fdsw_bdy">
                   <label>Final Disposal of Solid Waste:</label>
                   <select class="form-control" id="fdsw_selectize" name="sw_fdsw" onchange="fdsw_(this.value);" required>
                     <option value="<?php echo $selectdata[0]['final_disposal']; ?>"><?php echo $selectdata[0]['final_disposal']; ?></option>
                     <?php for ($i=0; $i < sizeof($selectsw); $i++) { echo '<option value="'.$selectsw[$i]['dsc'].'">'.$selectsw[$i]['dsc'].'</option>';  } ?>
                   </select>
                 </div>
                 <div class="col-md-8">
                   <label>Location:</label>
                   <input type="text" class="form-control" name="sw_location" value="<?php echo $selectdata[0]['fd_location']; ?>" required>
                 </div>
                 <div class="col-md-6">
                   <label>Latitude:</label>
                   <input type="text" class="form-control" name="sw_latitude" value="<?php echo $selectdata[0]['fd_latitude']; ?>" required>
                 </div>
                 <div class="col-md-6">
                   <label>Longitude:</label>
                   <input type="text" class="form-control" name="sw_longitude" value="<?php echo $selectdata[0]['fd_longitude']; ?>" required>
                 </div>
               </div>
               <script type="text/javascript">
                   $('#fdsw_selectize').selectize();
               </script>
            <?php } ?>
           </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" href="" style="float:left;font-size: 8pt;" class="btn btn-success btn-sm">Proceed</button>
      </div>
    </form>
    <script type="text/javascript">
      $('#swedit_report_status').selectize();
    </script>
  <?php
  }

  function swedit_report_evaluator(){
      $token = $this->encrypt->decode($this->input->post('token', TRUE));
      $wheredata  = $this->db->where('et.token = "'.$token.'"');
      $joindata   = $this->db->join('sweet_form AS sf','sf.trans_no = et.token','left');
      $selectdata = $this->Embismodel->selectdata('er_transactions AS et','et.action_taken,sf.report_type,sf.creator_name,sf.report_number,sf.final_disposal,sf.fd_location,sf.fd_latitude,sf.fd_longitude','',$joindata,$wheredata);
      $ifreporttype = ($selectdata[0]['report_type'] == 'Clean') ? "Unclean" : "Clean";

      $orderbysw  = $this->db->order_by('ssw.cnt','ASC');
      $selectsw = $this->Embismodel->selectdata('sweet_solid_waste AS ssw','','',$orderbysw);
  ?>
    <form action="<?php echo base_url(); ?>Swm/Sweet/edit" method="GET">
      <div class="modal-body">
         <div class="row">
          <div class="col-md-6">
             <label>Transaction No.:</label>
             <input type="text" class="form-control" value="<?= $token; ?>" disabled="">
           </div>
           <div class="col-md-6">
             <label>Casehandler:</label>
             <input type="text" class="form-control" value="<?= $selectdata[0]['creator_name']; ?>" disabled="">
             <input type="hidden" name="token" value="<?php echo $this->input->post('token'); ?>">
             <input type="hidden" name="rn" value="<?php echo $this->encrypt->encode($selectdata[0]['report_number']); ?>">
           </div>
           <div class="col-md-12" style="margin-top:5px;">
             <label>Report Status:</label>
             <select class="form-control" id="swedit_report_status" name="rs" onchange="fnldspsl(this.value);">
               <option value="<?php echo $this->encrypt->encode($selectdata[0]['report_type']); ?>"><?php echo $selectdata[0]['report_type']; ?></option>
               <option value="<?= $this->encrypt->encode($ifreporttype); ?>"><?= $ifreporttype; ?></option>
             </select>
           </div>
           <div class="col-md-12" id="fnldspsl_bdy">
             <?php if($selectdata[0]['report_type'] == 'Clean'){ ?>
               <div class="row">
                 <div class="col-md-4" name="sw_fdsw" id="fdsw_bdy">
                   <label>Final Disposal of Solid Waste:</label>
                   <select class="form-control" id="fdsw_selectize" name="sw_fdsw" onchange="fdsw_(this.value);" required>
                     <option value="<?php echo $selectdata[0]['final_disposal']; ?>"><?php echo $selectdata[0]['final_disposal']; ?></option>
                     <?php for ($i=0; $i < sizeof($selectsw); $i++) { echo '<option value="'.$selectsw[$i]['dsc'].'">'.$selectsw[$i]['dsc'].'</option>';  } ?>
                   </select>
                 </div>
                 <div class="col-md-8">
                   <label>Location:</label>
                   <input type="text" class="form-control" name="sw_location" value="<?php echo $selectdata[0]['fd_location']; ?>" required>
                 </div>
                 <div class="col-md-6">
                   <label>Latitude:</label>
                   <input type="text" class="form-control" name="sw_latitude" value="<?php echo $selectdata[0]['fd_latitude']; ?>" required>
                 </div>
                 <div class="col-md-6">
                   <label>Longitude:</label>
                   <input type="text" class="form-control" name="sw_longitude" value="<?php echo $selectdata[0]['fd_longitude']; ?>" required>
                 </div>
               </div>
            <?php } ?>
            <script type="text/javascript">
                $('#fdsw_selectize').selectize();
                $('#swedit_report_status').selectize();
            </script>
           </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" href="" style="float:left;font-size: 8pt;" class="btn btn-success btn-sm">Proceed</button>
      </div>
    </form>
  <?php
  }

  function viewattachmentbtn(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $wheresweetform     = $this->db->where('sf.trans_no = "'.$token.'" AND sfa.report_number = sf.report_number');
    $joinsweetform      = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no=sf.trans_no','left');
    $query = $this->Embismodel->selectdata('sweet_form AS sf','sf.*,sfa.attachment_name','',$joinsweetform,$wheresweetform);
     $previous_attachment = base_url()."../"."iis-images/sweet_report/".date("Y", strtotime($query[0]['date_created']))."/".$query[0]['region']."/".$query[0]['trans_no']."/".$query[0]['attachment_name'];
  ?>
     <div class="modal-body">
        <div class="col-md-12">
          <img src="<?php echo $previous_attachment; ?>" style="width:100%;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
  <?php
  }

  function prevviewattachmentbtn(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $reportnumber = $this->encrypt->decode($this->input->post('reportnumber', TRUE));
    $wheresweetform = $this->db->where('sfa.trans_no = "'.$token.'" AND sfa.report_number = "'.($reportnumber-1).'"');
    $joinsweetform  = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no=sf.trans_no','left');
    $query = $this->Embismodel->selectdata('sweet_form AS sf','sf.date_created, sf.trans_no, sf.region, sfa.attachment_name','',$joinsweetform,$wheresweetform);
    $previous_attachment = base_url()."../"."iis-images/sweet_report/".date("Y", strtotime($query[0]['date_created']))."/".$query[0]['region']."/".$query[0]['trans_no']."/".$query[0]['attachment_name'];
    ?>
       <div class="modal-body">
          <div class="col-md-12">
            <img src="<?php echo $previous_attachment; ?>" style="width:100%;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Close</button>
        </div>
    <?php
  }

  function filter_by_select(){
    $filter_by = $this->encrypt->decode($this->input->post('filter_by', TRUE));
    if($filter_by == 'Casehandler'){
      $selectname = "ch";
      $wheresweet  = $this->db->where('acs.verified = "1" GROUP BY sfu.userid');
      $joinsweet   = $this->db->join('acc_credentials AS acs','acs.userid = sfu.userid','left');
      $selectsweet = $this->Embismodel->selectdata('sweet_func_user AS sfu','acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinsweet,$wheresweet);
    }else if($filter_by == 'LGU'){
      $selectname = "lgu";
      $wherelgu  = $this->db->where('sla.region = "'.$this->session->userdata('region').'" GROUP BY sla.emb_id ORDER BY sla.lgu_name');
      $selectlgu = $this->Embismodel->selectdata('sweet_lgu_assigned AS sla','','',$wherelgu);
    }

    echo "<div class='row'>
            <div class='col-md-12'>
              <label> Name of ".$filter_by.":</label>
              <select class='form-control' id='filter_by_res_selectize' name='".$selectname."' required>
                <option value=''></option>";
                if($filter_by == 'Casehandler'){
                    echo "<option value='".$this->encrypt->encode('All')."'>All</option>";
                  for ($swusers=0; $swusers < sizeof($selectsweet); $swusers++) {
                    if(!empty($selectsweet[$swusers]['mname'])){ $mname = $selectsweet[$swusers]['mname'][0].". ";  }else{ $mname = ""; }
                    if(!empty($selectsweet[$swusers]['suffix'])){ $suffix = " ".$selectsweet[$swusers]['suffix'];  }else{ $suffix = ""; }
                    $name   = utf8_encode(strtolower($selectsweet[$swusers]['fname']." ".$mname.$selectsweet[$swusers]['sname'].$suffix));
                    $full_name = ucwords(str_replace('ã±', '&ntilde;', $name));
                    echo "<option value='".$this->encrypt->encode($selectsweet[$swusers]['userid'])."'>".$full_name."</option>";
                  }
                }else if($filter_by == 'LGU'){
                    echo "<option value='".$this->encrypt->encode('All')."'>All</option>";
                  for ($lgu=0; $lgu < sizeof($selectlgu); $lgu++) {
                    echo "<option value='".$this->encrypt->encode($selectlgu[$lgu]['emb_id'])."'>".strtoupper($selectlgu[$lgu]['lgu_name'])."</option>";
                  }
                }
    echo      "</select>
            </div>
          </div>";
  ?>
    <script type="text/javascript">
      $('#filter_by_res_selectize').selectize();
    </script>
  <?php
  }

  function assignsweet(){
    $whereexist = $this->db->where('acs.region = "'.$this->session->userdata('region').'"');
    $joinexist = $this->db->join('acc_credentials AS acs','acs.userid = sfu.userid','left');
    $swexist = $this->Embismodel->selectdata('sweet_func_user AS sfu','sfu.userid','',$joinexist,$whereexist);

    $whereexistsf = $this->db->where('sf.stat = "1" GROUP BY assigned_to');
    $swexistsf = $this->Embismodel->selectdata('sweet_func AS sf','sf.assigned_to','',$whereexistsf);
      for ($ext=0; $ext < sizeof($swexistsf); $ext++) {
        $wheresweet  =  $this->db->where('acs.userid != "'.$swexistsf[$ext]['assigned_to'].'"');
      }

      for ($est=0; $est < sizeof($swexist); $est++) {
        $wheresweet  =  $this->db->where('acs.userid != "'.$swexist[$est]['userid'].'"');
      }
    $wheresweet  = $this->db->where('(acs.verified = "1" AND  af.stat = "1" AND af.region = "'.$this->session->userdata('region').'" AND (af.func = "Staff" OR af.func = "Special Account" OR af.func = "Secretary" OR af.func = "Section Chief" OR af.func = "Unit Chief")) ORDER BY acs.fname');
    $joinsweet   = $this->db->join('acc_function AS af','acs.userid = af.userid','left');
    $sweetcasehandler = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinsweet,$wheresweet);
    $wherefuncsw = $this->db->where('sf.stat = "1" AND sf.region = "'.$this->session->userdata('region').'" GROUP BY sf.token');
    $sweetfunc = $this->Embismodel->selectdata('sweet_func AS sf','sf.func_name, sf.token','',$wherefuncsw);

  ?>
    <div class="row" style="margin:0px 0px 0px 0px;">
      <div class="col-md-6">
          <label>Select Casehandler(s):</label>
          <select class="form-control" id="casehandlers_selectize_settings">
            <option value="">-</option>
            <?php
              for ($swusers=0; $swusers < sizeof($sweetcasehandler); $swusers++) {
                if(!empty($sweetcasehandler[$swusers]['mname'])){ $mname = $sweetcasehandler[$swusers]['mname'][0].". ";  }else{ $mname = ""; }
                if(!empty($sweetcasehandler[$swusers]['suffix'])){ $suffix = " ".$sweetcasehandler[$swusers]['suffix'];  }else{ $suffix = ""; }
                if(!empty($select_sweetofficers[$swusers]['title'])){ $prefix = $select_sweetofficers[$swusers]['title']." ";  }else{ $prefix = ""; }
                $name   = $prefix.$sweetcasehandler[$swusers]['fname']." ".$mname.$sweetcasehandler[$swusers]['sname'].$suffix;
                echo "<option value='".($sweetcasehandler[$swusers]['token'])."'>".$name."</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-6">
          <label>Select Hierarchy Template</label>
          <select class="form-control" id="swfnc_selectize" onchange="functemplatesw(this.value);">
            <option value="">Select templates</option>
            <?php
              for ($fc=0; $fc < sizeof($sweetfunc); $fc++) {
                echo '<option value="'.$this->encrypt->encode($sweetfunc[$fc]['token']).'">'.$sweetfunc[$fc]['func_name'].'</option>';
              }
            ?>
          </select>
        </div>
        <div class="col-md-12" id="result_sw_bdy"></div>
      </div>
      <script type="text/javascript">
        $('#casehandlers_selectize_settings').selectize({
            maxItems: null
        });
        $('#swfnc_selectize').selectize();
      </script>
  <?php
  }

  function swassignlgutouser(){
    $where_sweetofficers = $this->db->where('acs.verified = "1" AND acs.region = "'.$this->session->userdata('region').'" ORDER BY fname ASC');
    $join_sweetofficers = $this->db->join('acc_credentials AS acs','acs.userid = sfu.userid','left');
    $select_sweetofficers = $this->Embismodel->selectdata('sweet_func_user AS sfu','acs.token, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$join_sweetofficers,$where_sweetofficers);

    $wherecompanies = $this->db->where('dc.region_name = "'.$this->session->userdata('region').'" AND dc.deleted != "1" ORDER BY dc.company_name ASC');
    $selectcompanies = $this->Embismodel->selectdata('dms_company AS dc','dc.company_name, dc.emb_id','',$wherecompanies);
    ?>
    <div class="row" style="margin:0px 0px 0px 0px;">
      <div class="col-md-6">
          <label>Select Casehandler:</label>
          <select class="form-control" id="sweetofficersselectize">
            <option value="">-</option>
            <?php
              for ($swusers=0; $swusers < sizeof($select_sweetofficers); $swusers++) {
                if(!empty($select_sweetofficers[$swusers]['mname'])){ $mname = $select_sweetofficers[$swusers]['mname'][0].". ";  }else{ $mname = ""; }
                if(!empty($select_sweetofficers[$swusers]['suffix'])){ $suffix = " ".$select_sweetofficers[$swusers]['suffix'];  }else{ $suffix = ""; }
                if(!empty($select_sweetofficers[$swusers]['title'])){ $prefix = $select_sweetofficers[$swusers]['title']." ";  }else{ $prefix = ""; }
                $name   = $prefix.$select_sweetofficers[$swusers]['fname']." ".$mname.$select_sweetofficers[$swusers]['sname'].$suffix;
                echo "<option value='".($select_sweetofficers[$swusers]['token'])."'>".$name."</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-6">
            <label>Select Company as LGU: <span style="color:red;font-style:italic;">(One or multiple selection)</span></label>
            <select class="form-control" id="sweetlguselectize">
              <option value="">-</option>
              <?php
                for ($swlgu=0; $swlgu < sizeof($selectcompanies); $swlgu++) {
                  echo "<option value='".$selectcompanies[$swlgu]['emb_id']."'>".$selectcompanies[$swlgu]['company_name']."</option>";
              }
              ?>
            </select>
        </div>
        <div class="col-md-12">
          <button type="button" style="float:right;" class="btn btn-success btn-sm" onclick="swsavelgudata();">Submit</button>
        </div>
    </div>
    <script type="text/javascript">
      $('#sweetlguselectize').selectize({
          maxItems: null
      });
      $('#sweetofficersselectize').selectize();
    </script>
    <?php
  }

  function swaddtemplate(){
  ?>
    <div class="row" style="margin:0px;">
      <div class="col-md-6">
        <label>Template Name</label>
        <input type="text" class="form-control" id="hname">
      </div>
      <div class="col-md-6">
        <label>Evaluator Hierarchy</label>
        <select class="form-control" id="no_rows_sw" onchange="no_of_rows_sw(this.value);">
          <option value="">No of employee</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
        </select>
      </div>
    </div>
    <div class="col-md-12" id="result_sw_bdy_template" style="padding:0px;"></div>
     <script type="text/javascript">
        $('#no_rows_sw').selectize();
      </script>
  <?php
  }

  function functemplatesw(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $wherefnc  = $this->db->where('sf.token = "'.$token.'" ORDER BY sf.route_order ASC');
    $joinfnc   = $this->db->join('acc_credentials AS acs','acs.userid = sf.assigned_to','left');
    $selectfnc = $this->Embismodel->selectdata('sweet_func AS sf','sf.route_order,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinfnc,$wherefnc);
    echo '<hr>';
    if(!empty($token)){
      for ($i=0; $i < sizeof($selectfnc); $i++) {
        if(!empty($selectfnc[$i]['mname'])){ $mname = $selectfnc[$i]['mname'][0].". ";  }else{ $mname = ""; }
        if(!empty($selectfnc[$i]['suffix'])){ $suffix = " ".$selectfnc[$i]['suffix'];  }else{ $suffix = ""; }
        $name   = utf8_encode(strtolower($selectfnc[$i]['fname']." ".$mname.$selectfnc[$i]['sname'].$suffix));
        $full_name = ucwords(str_replace('ã±', '&ntilde;', $name));
        echo '<div class="row" style="margin-top:5px;">
                <div class="col-md-10">
                  <input type="text" class="form-control" value="'.$full_name.'" style="font-size:9pt;" readonly>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control" value="'.$selectfnc[$i]['route_order'].'" style="font-size:9pt;" readonly>
                </div>
              </div>';
      }

        echo '<hr><div class="row" style="margin-top:5px;">
                <div class="col-md-12">
                  <button type="button" class="btn btn-success btn-sm" style="float:right;" onclick="assignswuser();">Submit</button>
                </div>
              </div>';
    }
  }

  function no_of_rows_sw(){
    $norows = ($this->input->post('norows', TRUE));
    $wheresweet   = $this->db->where('acs.verified = "1" AND  af.stat = "1" AND  af.userid != "1" AND af.region = "'.$this->session->userdata('region').'" ORDER BY acs.fname');
    $joinsweet    = $this->db->join('acc_function AS af','acs.userid = af.userid','left');
    $employeelist = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinsweet,$wheresweet);
    echo '<div class="col-md-12"><hr></div>';
    $cnt = 0;
    for ($i=0; $i < ($norows); $i++) {
      $cnt++;
      echo '<div class="row" style="margin:0px;">
            <div class="col-md-10">
            <select class="form-control" name="usertoken[]" id="rtdoc_selectize'.$i.'">
              <option value="">-</option>';
              for ($users=0; $users < sizeof($employeelist); $users++) {
                  if(!empty($employeelist[$users]['mname'])){ $mname = $employeelist[$users]['mname'][0].". ";  }else{ $mname = ""; }
                  if(!empty($employeelist[$users]['suffix'])){ $suffix = " ".$employeelist[$users]['suffix'];  }else{ $suffix = ""; }
                  $name   = utf8_encode(strtolower($employeelist[$users]['fname']." ".$mname.$employeelist[$users]['sname'].$suffix));
                  $ifn = str_replace('Ã±', '&ntilde;', $name);
                  $full_name = ucwords(str_replace('ã±', '&ntilde;', $ifn));
                  echo "<option value='".($employeelist[$users]['token'])."'>".$full_name."</option>";
              }
      echo '</select>
            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" value="'.$cnt.'" readonly>';

      echo '</div>
            </div>';
    ?>
      <script type="text/javascript">
        $('#rtdoc_selectize<?php echo $i; ?>').selectize();
      </script>
    <?php
    }
      echo '<div class="col-md-12">
            <hr><button type="button" class="btn btn-success btn-sm" style="float:right;" onclick="assigntemplatesw();">Submit</button>
            </div>';
  }

  function swuploadphoto(){
    if((count($_FILES['site_photo']['name'])) >= '1'){
      if(!is_dir('../iis-images/sweet_report')) {
        mkdir('../iis-images/sweet_report', 0777, TRUE);
      }

      if(!is_dir('../iis-images/sweet_report/'.date('Y'))) {
        mkdir('../iis-images/sweet_report/'.date('Y').'/', 0777, TRUE);
      }

      if(!is_dir('../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region'))) {
        mkdir('../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region'), 0777, TRUE);
      }

      if(!is_dir('../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')))) {
        mkdir('../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')), 0777, TRUE);
      }

      $error = array();

      $config = array(
           'upload_path'   => '../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/',
           'allowed_types' => 'jpeg|jpg|png|gif',
           'max_size'			 => '100000',
           'overwrite'     => TRUE,
       );

      $this->load->library('upload',$config);

      $counter = 0;

      for ($i=0; $i < count($_FILES['site_photo']['name']); $i++) {
        $_FILES['file']['name']      = $_FILES['site_photo']['name'][$i];
        $_FILES['file']['type']      = $_FILES['site_photo']['type'][$i];
        $_FILES['file']['tmp_name']  = $_FILES['site_photo']['tmp_name'][$i];
        $_FILES['file']['error']     = $_FILES['site_photo']['error'][$i];
        $_FILES['file']['size']      = $_FILES['site_photo']['size'][$i];

        $filename = "File-1".".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $filename;

        $this->upload->initialize($config);

        if($counter == 0){

          $whereoldphoto = array('sfa.trans_no' => $this->encrypt->decode($this->input->post('token')), 'report_number' => '1',);
          $selectoldphoto = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.attachment_name',$whereoldphoto);

          if(!empty($selectoldphoto[0]['attachment_name'])){
            unlink($config['upload_path'].$selectoldphoto[0]['attachment_name']);
          }

          if($this->upload->do_upload('file')){

              if(!empty($selectoldphoto[0]['attachment_name'])){
                $setdata = array('attachment_name' => $config['file_name'], );
                $wheredata = array('trans_no' => $this->encrypt->decode($this->input->post('token')), 'report_number' => '1', );
                $updatedata = $this->Embismodel->updatedata($setdata,'sweet_form_attachments',$wheredata);
              }else{
                $insert_attachments = array(
                  'trans_no'                 => $this->encrypt->decode($this->input->post('token')),
                  'attachment_name'          => $config['file_name'],
                  'report_number'            => '1',
                );
                $sweet_form_insert = $this->Embismodel->insertdata('sweet_form_attachments', $insert_attachments);
              }

              $counter++;
              $pathurl = base_url().'../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/'.$config['file_name'];
              $responsedata = array(
                                      'status' => 'uploaded',
                                      'image_uploaded' => $pathurl,
                                      'token' => $this->input->post('token'),
                                   );
              chmod($pathurl,0777,TRUE);
              $this->session->set_userdata('swsite_photo', $pathurl);
              echo json_encode($responsedata);

          }else{
            echo json_encode(array('status' => 'failed', 'image_uploaded' => '', ));
          }
        }
      }
    }else{
      echo json_encode(array('status' => 'empty', 'image_uploaded' => '', ));
    }


    clearstatcache();
  }

  function editswuploadphoto(){
    if((count($_FILES['edit_site_photo']['name'])) >= '1'){
      $error = array();

      $config = array(
           'upload_path'   => '../iis-images/sweet_report/'.date('Y',strtotime($_POST['reportdate'])).'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/',
           'allowed_types' => 'jpeg|jpg|png|gif',
           'max_size'			 => '100000',
           'overwrite'     => TRUE,
       );

      $this->load->library('upload',$config);

      $counter = 0;

      for ($i=0; $i < count($_FILES['edit_site_photo']['name']); $i++) {
        $_FILES['file']['name']      = $_FILES['edit_site_photo']['name'][$i];
        $_FILES['file']['type']      = $_FILES['edit_site_photo']['type'][$i];
        $_FILES['file']['tmp_name']  = $_FILES['edit_site_photo']['tmp_name'][$i];
        $_FILES['file']['error']     = $_FILES['edit_site_photo']['error'][$i];
        $_FILES['file']['size']      = $_FILES['edit_site_photo']['size'][$i];

        $filename = "File-".$this->encrypt->decode($this->input->post('reportnumber')).".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $filename;

        $this->upload->initialize($config);

        if($counter == 0){

          $whereoldphoto = array('sfa.trans_no' => $this->encrypt->decode($this->input->post('token')), 'report_number' => $this->encrypt->decode($this->input->post('reportnumber')),);
          $selectoldphoto = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.attachment_name',$whereoldphoto);

          if(!empty($selectoldphoto[0]['attachment_name'])){
            unlink($config['upload_path'].$selectoldphoto[0]['attachment_name']);
          }

          if($this->upload->do_upload('file')){

              $setdata = array('attachment_name' => $config['file_name'], );
              $wheredata = array('trans_no' => $this->encrypt->decode($this->input->post('token')), 'report_number' => $this->encrypt->decode($this->input->post('reportnumber')), );
              $updatedata = $this->Embismodel->updatedata($setdata,'sweet_form_attachments',$wheredata);

              $counter++;
              $pathurl = base_url().'../iis-images/sweet_report/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/'.$config['file_name'];
              $responsedata = array(
                                      'status' => 'uploaded',
                                      'image_uploaded' => $pathurl,
                                      'token' => $this->input->post('token'),
                                      'reportdate' => $this->input->post('reportdate'),
                                      'reportnumber' => $this->input->post('reportnumber'),

                                   );
              chmod($pathurl,0777,TRUE);
              $this->session->set_userdata('swedit_site_photo', $pathurl);
              echo json_encode($responsedata);

          }else{
            echo json_encode(array('status' => 'failed', 'image_uploaded' => '', ));
          }
        }
      }
    }else{
      echo json_encode(array('status' => 'empty', 'image_uploaded' => '', ));
    }
    clearstatcache();
  }

  function updtswuploadphoto(){
    if((count($_FILES['updtsite_photo']['name'])) >= '1'){
      $error = array();

      $config = array(
           'upload_path'   => '../iis-images/sweet_report/'.date('Y',strtotime($_POST['datecreated'])).'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/',
           'allowed_types' => 'jpeg|jpg|png|gif',
           'max_size'			 => '100000',
           'overwrite'     => TRUE,
       );

      $this->load->library('upload',$config);

      $counter = 0;

      for ($i=0; $i < count($_FILES['updtsite_photo']['name']); $i++) {
        $_FILES['file']['name']      = $_FILES['updtsite_photo']['name'][$i];
        $_FILES['file']['type']      = $_FILES['updtsite_photo']['type'][$i];
        $_FILES['file']['tmp_name']  = $_FILES['updtsite_photo']['tmp_name'][$i];
        $_FILES['file']['error']     = $_FILES['updtsite_photo']['error'][$i];
        $_FILES['file']['size']      = $_FILES['updtsite_photo']['size'][$i];

        $filename = "File-".$this->encrypt->decode($this->input->post('reportnumber')).".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $filename;

        $this->upload->initialize($config);

        if($counter == 0){

          $whereoldphoto = array('sfa.trans_no' => $this->encrypt->decode($this->input->post('token')), 'report_number' => $this->encrypt->decode($this->input->post('reportnumber')),);
          $selectoldphoto = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.attachment_name',$whereoldphoto);

          if(!empty($selectoldphoto[0]['attachment_name'])){
            unlink($config['upload_path'].$selectoldphoto[0]['attachment_name']);
          }

          if($this->upload->do_upload('file')){

              if(!empty($selectoldphoto[0]['attachment_name'])){
                $setdata = array('attachment_name' => $config['file_name'], );
                $wheredata = array('trans_no' => $this->encrypt->decode($this->input->post('token')), 'report_number' => $this->encrypt->decode($this->input->post('reportnumber')), );
                $updatedata = $this->Embismodel->updatedata($setdata,'sweet_form_attachments',$wheredata);
              }else{
                $insert_attachments = array(
                  'trans_no'                 => $this->encrypt->decode($this->input->post('token')),
                  'attachment_name'          => $config['file_name'],
                  'report_number'            => $this->encrypt->decode($this->input->post('reportnumber')),
                );
                $sweet_form_insert = $this->Embismodel->insertdata('sweet_form_attachments', $insert_attachments);
              }

              $counter++;
              $pathurl = base_url().'../iis-images/sweet_report/'.date('Y',strtotime($_POST['datecreated'])).'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/'.$config['file_name'];
              $responsedata = array(
                                      'status' => 'uploaded',
                                      'image_uploaded' => $pathurl,
                                      'token' => $this->input->post('token'),
                                      'datecreated' => $this->input->post('datecreated'),
                                      'reportnumber' => $this->input->post('reportnumber'),
                                   );
              chmod($pathurl,0777,TRUE);
              $this->session->set_userdata('updtswupdtsite_photo', $pathurl);
              echo json_encode($responsedata);

          }else{
            echo json_encode(array('status' => 'failed', 'image_uploaded' => '', ));
          }
        }
      }
    }else{
      echo json_encode(array('status' => 'empty', 'image_uploaded' => '', ));
    }
    clearstatcache();
  }

  function uactivetab(){
    $tabnumber =  $this->encrypt->decode($this->input->post('tabnumber',TRUE));
    if(!empty($tabnumber)){
      $this->session->set_userdata('uactivetabno', $tabnumber);
    }
  }

  function chkcoordinatessw(){
    $lat = $this->input->post('lat', TRUE);
    $long = $this->input->post('long', TRUE);
    if(!empty($lat) AND !empty($long)){
      echo '<a class="btn btn-sm btn-info" href="https://www.google.com/maps/search/'.$lat.','.$long.'" target="_blank" style="float:right;font-size:7pt;color:#FFF;" title="Check accuracy of inputted geo coordinates"><span class="fa fa-map-marker"></span> Check Geo Coordinates</a>';
    }
  }

  function procesnovletter(){
    $trans_no = $this->encrypt->decode($_POST['trans_no']);
    $report_number = $this->encrypt->decode($_POST['report_number']);
    $cnt = $_POST['cnt'];

    $gettoken = $this->encrypt->encode($cnt);
    $whereform  = $this->db->where('sf.trans_no = "'.$trans_no.'" AND sf.report_number = "'.$report_number.'"');
    $selectform = $this->Embismodel->selectdata('sweet_form_log AS sf','*','',$whereform);

    $wherefunc = $this->db->where('af.userid = "'.$this->session->userdata('userid').'" AND af.stat = "1"');
    $userfunc = $this->Embismodel->selectdata('acc_function AS af','af.func','',$wherefunc);

    if($userfunc[0]['func'] == 'Regional Director'){
      $wherestatus = $this->db->where('es.id = "5" OR es.id = "20" OR es.id = "15" OR es.id = "6" ORDER BY es.status_order ASC');
    }else{
      $wherestatus = $this->db->where('es.id = "20" OR es.id = "15" OR es.id = "6" ORDER BY es.status_order ASC');
    }
    $selectstatus = $this->Embismodel->selectdata('er_status AS es','','',$wherestatus);


  ?>
    <style type="text/css">
      label{
        color:#000;
      }
    </style>
    <form action="<?php echo base_url(); ?>Swm/Sweet_postactions/process_novletter" method="POST">
      <div id="disapproval-reason">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label>Transaction No.:</label>
              <input type="text" class="form-control" value="<?php echo $trans_no; ?>" readonly>
              <input type="hidden" name="token" class="form-control" value="<?php echo $_POST['trans_no']; ?>" required>
              <input type="hidden" name="rn" class="form-control" value="<?php echo $_POST['report_number']; ?>" required>
              <input type="hidden" name="cnt" class="form-control" value="<?php echo $this->encrypt->encode($cnt); ?>" required>
            </div>
            <div class="col-md-6">
              <label>View NOV Letter:</label><br>
              <a href="<?php echo base_url().'Swm/Letter/pdf/'.$gettoken; ?>" target="_blank" class="btn btn-danger btn-sm" style="width:100%;"><span class="fa fa-file"></span>&nbsp;PDF Letter</a>
            </div>
            <div class="col-md-12">
              <label>Transaction Status:</label><br>
              <select class="form-control" id="trnstatselectize" name="trans_status" onchange="divnovprcs($('#trnstatselectize').val(), '<?php echo $this->encrypt->encode($selectform[0]['userid']); ?>')" required>
                <option value="">-</option>
                <?php for ($st=0; $st < sizeof($selectstatus); $st++) { ?>
                  <option value="<?php echo $this->encrypt->encode($selectstatus[$st]['id']); ?>"><?php echo $selectstatus[$st]['name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12" id="divnovprcs_">
              <label>Route transaction to:</label><br>
              <select class="form-control" disabled>
                <option value="">-</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-danger btn-sm">Return to Sender</button> -->
          <button type="submit" name="Approve" class="btn btn-success btn-sm">Process</button>
        </div>
      </div>
    </form>
    <script type="text/javascript">
      $('#trnstatselectize').selectize();
    </script>
  <?php
  }

  function divnovprcs(){
    $stat = $this->encrypt->decode($this->input->post('stat', TRUE));
    $userid = $this->encrypt->decode($this->input->post('tkn', TRUE));

    $whererd = $this->db->where('af.stat = "1" AND acs.verified = "1" AND af.func = "Regional Director"');
    $joinrd = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
    $selectrd = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid','',$joinrd,$whererd);

    $whereusers = $this->db->where('(sfu.userid = "'.$userid.'" AND acs.userid != "'.$this->session->userdata('userid').'" AND acs.region = "'.$this->session->userdata('region').'") GROUP BY acs.userid ORDER BY af.func_order ASC');
    $joinusers = $this->db->join('sweet_func AS sf','sf.token = sfu.func_token','left');
    $joinusers = $this->db->join('acc_credentials AS acs','(`acs`.`userid` = `sf`.`assigned_to` OR `acs`.`userid` = "'.$userid.'" OR `acs`.`userid` = "'.$selectrd[0]['userid'].'")','left');
    $joinusers = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
    $selectusers = $this->Embismodel->selectdata('sweet_func_user AS sfu','acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$joinusers,$whereusers);

    $whererd = $this->db->where('acs.verified = "1" AND af.stat = "1" AND af.func = "Regional Director" AND af.region = "'.$this->session->userdata('region').'"');
    $joinrd = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
    $selectrd = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$joinrd,$whererd);

    if($stat == '15'){
      $label = 'Remarks:';
      $remarks = 'Pls. for approval (NOV Letter)';
    }
    if($stat == '6'){
      $label = 'Please provide reason of disapproval:';
      $remarks = '';
    }
    if($stat == '20'){
      $label = 'Please provide remarks:';
      $remarks = '';
    }

    ?>
      <div class="row">
        <div class="col-md-12">
          <?php if($stat == '5'){ ?>
            <input type="hidden" name="assignedto" value="">
          <?php }else{ ?>
            <label>Route transaction to:</label><br>
            <select class="form-control" name="assignedto" id="rttrnstoselectize" required>
              <option value="">-</option>
              <?php for ($i=0; $i < sizeof($selectusers); $i++) {
                $prefix = (!empty($selectusers[$i]['title'])) ? $selectusers[$i]['title'].' ': '';
                $mname = (!empty($selectusers[$i]['mname'])) ? $selectusers[$i]['mname'][0].'. ': '';
                $suffix = (!empty($selectusers[$i]['suffix'])) ? ' '.$selectusers[$i]['suffix']: '';
                $name = $prefix.$selectusers[$i]['fname'].' '.$mname.$selectusers[$i]['sname'].$suffix;
              ?>
                <option value="<?php echo $this->encrypt->encode($selectusers[$i]['userid']); ?>"><?php echo $name; ?></option>
              <?php } ?>
              <?php for ($rd=0; $rd < sizeof($selectrd); $rd++) {
                $prefixrd = (!empty($selectrd[$rd]['title'])) ? $selectrd[$rd]['title'].' ': '';
                $mnamerd = (!empty($selectrd[$rd]['mname'])) ? $selectrd[$rd]['mname'][0].'. ': '';
                $suffixrd = (!empty($selectrd[$rd]['suffix'])) ? ' '.$selectrd[$rd]['suffix']: '';
                $namerd = $prefixrd.$selectrd[$rd]['fname'].' '.$mnamerd.$selectrd[$rd]['sname'].$suffixrd;
              ?>
                <option value="<?php echo $this->encrypt->encode($selectrd[$rd]['userid']); ?>"><?php echo $namerd; ?></option>
              <?php } ?>
            </select>
          <?php } ?>
        </div>
        <?php if($stat != '5'){ ?>
          <div class="col-md-12">
            <label><?php echo $label; ?></label><br>
            <textarea name="remarks" class="form-control" rows="8" cols="80"><?php echo $remarks; ?></textarea>
          </div>
        <?php } ?>
      </div>

      <script type="text/javascript">
        $('#rttrnstoselectize').selectize();
      </script>
    <?php
  }

  function chklgufeedbacks(){
      $wheredatacnt = $this->db->where('sff.status = "Active" AND sff.feedback_seen IS NULL AND sf.userid = "'.$this->session->userdata('userid').'" AND et.status != "0" GROUP BY sff.cnt');
      $joindatacnt = $this->db->join('sweet_form_log AS sf','sf.trans_no = sff.trans_no','left');
      $joindatacnt = $this->db->join('er_transactions AS et','et.token = sff.trans_no','left');
      $chkfeedbackscnt = $this->Embismodel->selectdata('sweet_form_feedback AS sff','sf.trans_no','',$joindatacnt,$wheredatacnt);
      $mcnt = 0;
      for ($c=0; $c < sizeof($chkfeedbackscnt); $c++) {
        if(!empty($chkfeedbackscnt[$c]['trans_no'])){
          $mcnt++;
        }
      }
      $feedbacktext = ($mcnt > 1) ? 's' : '';

      $wheredata = $this->db->where('sff.status = "Active" AND sff.feedback_seen IS NULL AND sf.userid = "'.$this->session->userdata('userid').'" AND et.status != "0" GROUP BY sff.cnt');
      $joindata = $this->db->join('sweet_form_log AS sf','sf.trans_no = sff.trans_no','left');
      $joindata = $this->db->join('er_transactions AS et','et.token = sff.trans_no','left');
      $chkfeedbacks = $this->Embismodel->selectdata('sweet_form_feedback AS sff','sf.trans_no, sf.lgu_patrolled_name, sf.barangay_name, sf.street, sff.report_type','',$joindata,$wheredata);
      if($mcnt > 0){
    ?>
      <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapselgufeedback" aria-expanded="false" aria-controls="collapselgufeedback" style="font-size: 12pt;width: 100%;margin-bottom: 15px;text-align: left;">
        You have <b><?php echo $mcnt; ?></b> unread LGU feedback<?php echo $feedbacktext; ?>. (Click this button to view details)
        <span style="float: right;margin-top: 0px;font-size: 17pt;" class="fa fa-caret-down"></span>
      </button>
      <div class="collapse" id="collapselgufeedback">
        <div class="card card-body">
          <?php for ($i=0; $i < sizeof($chkfeedbacks); $i++) { ?>
            <div class="alert alert-dark" role="alert" style="margin: 10px;padding: 10px;">
              <?php echo 'From: '.$chkfeedbacks[$i]['lgu_patrolled_name'].' - '.$chkfeedbacks[$i]['street'].', '.$chkfeedbacks[$i]['barangay_name']; ?> (<?php echo $chkfeedbacks[$i]['report_type'].' site'; ?>)
              <button type="button" class="btn btn-info btn-sm" style="float:right;margin-right:5px;" onclick="lgufeedbackbtn('<?php echo $this->encrypt->encode($chkfeedbacks[$i]['trans_no']); ?>');" data-toggle="modal" data-target="#lgufeedbackmodal">View Feedback</button>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php
    }
  }

  function viewgeocamphotos(){
    $wheregeocam = $this->db->where('sd.user_id = "'.$this->session->userdata('userid').'"');
    $selectgeocam = $this->Embismodel->selectdata('mobile_db.survey_details AS sd','','',$wheregeocam);
    ?>
      <div class="modal-body">
        <table id="geocamtable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Photo</th>
              <th>Latitude</th>
              <th>Longitude</th>
              <th>Address</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i=0; $i < sizeof($selectgeocam); $i++) {
              if(!empty($selectgeocam[$i]['id'])){
            ?>
            <tr>
              <td><?php echo date('F d, Y', strtotime($selectgeocam[$i]['photo_taken'])); ?></td>
              <td><?php echo date('h:ia', strtotime($selectgeocam[$i]['photo_taken_time'])); ?></td>
              <td> <a href="<?php echo base_url().'../emb/images/'.$selectgeocam[$i]['image']; ?>" target="_blank"><?php echo $selectgeocam[$i]['image']; ?></a></td>
              <td><?php echo $selectgeocam[$i]['latitude']; ?></td>
              <td><?php echo $selectgeocam[$i]['longitude']; ?></td>
              <td><?php echo $selectgeocam[$i]['address']; ?></td>
            </tr>
          <?php } } ?>
          </tbody>
        </table>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#geocamtable').DataTable({
              "lengthMenu": [ [100, 500, -1], [100, 500, "All"] ]
            });
          } );
        </script>
      </div>
    <?php
  }

  function editnovltr(){
    $token = $this->encrypt->decode($_POST['token']);
    $reportnumber = $this->encrypt->decode($_POST['reportnumber']);

    $whereselectsweetrans = $this->db->where('sf.userid = "'.$this->session->userdata('userid').'" AND er.status != "0" AND sf.report_type = "Unclean" AND sf.type_of_monitoring != "1"');
    $joinselectsweetrans = $this->db->join('er_transactions AS er','er.token = sf.trans_no','left');
    $selectsweettrans = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.trans_no, sf.month_monitoring, sf.lgu_patrolled_name, sf.type_of_monitoring_desc, sf.cnt, sf.barangay_name, sf.date_patrolled, sf.date_of_first_monitoring, sf.date_of_second_monitoring, sf.date_of_last_monitoring','',$joinselectsweetrans,$whereselectsweetrans);

    $wherenovletter = $this->db->where('snl.trans_no = "'.$token.'" AND report_number = "'.$reportnumber.'"');
    $selectnovletter = $this->Embismodel->selectdata('sweet_nov_letter AS snl','','',$wherenovletter);

    $sweet_token = $this->Sweetreportmodel->sweet_func_user($this->session->userdata('userid'));

    $wherertdata = $this->db->where('sf.token="'.$sweet_token.'" AND sf.region="'.$this->session->userdata('region').'" AND acs.verified = "1" AND af.stat = "1" ORDER BY af.func_order ASC, acs.fname ASC');
    $joinrtdata = $this->db->join('acc_credentials AS acs','acs.userid = sf.assigned_to','left');
    $joinrtdata = $this->db->join('acc_function AS af','af.userid = sf.assigned_to','left');
    $queryrouteto = $this->Embismodel->selectdata('sweet_func AS sf','acs.userid, acs.token, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, af.func','',$joinrtdata,$wherertdata);

   ?>
    <div class="modal-body">
      <div class="row">
        <input type="hidden" id="edittoken" value="<?php echo $_POST['token']; ?>">
        <input type="hidden" id="editreportnumber" value="<?php echo $_POST['reportnumber']; ?>">
        <div class="col-md-12">
          <label>Letter date:</label>
          <input type="date" class="form-control" id="editletterdate" value="<?php echo date('Y-m-d', strtotime($selectnovletter[0]['letter_date'])); ?>">
        </div>
        <div class="col-md-12">
          <label>Address this letter to whom:</label>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" id="editprefix" value="<?php echo $selectnovletter[0]['address_to_prefix']; ?>" placeholder="Prefix">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" id="editfirstname" value="<?php echo $selectnovletter[0]['address_to_fname']; ?>" placeholder="First name">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" id="editmiddleinitial" value="<?php echo $selectnovletter[0]['address_to_mname']; ?>" placeholder="Middle Initial">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" id="editlastname" value="<?php echo $selectnovletter[0]['address_to_sname']; ?>" placeholder="Last name">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" id="editsuffix" value="<?php echo $selectnovletter[0]['address_to_suffix']; ?>" placeholder="Suffix">
        </div>
        <div class="col-md-6">
          <label>Designation:</label>
          <input type="text" class="form-control" id="editdesignation" value="<?php echo $selectnovletter[0]['designation']; ?>">
        </div>
        <div class="col-md-6">
          <label>Municipality / City:</label>
          <input type="text" class="form-control" id="editmuncity" value="<?php echo $selectnovletter[0]['muncity']; ?>">
        </div>
        <div class="col-md-12">
          <label>Span of waste removal:</label>
          <input type="text" class="form-control" id="editwasteremov" value="<?php echo $selectnovletter[0]['waste_removal']; ?>">
        </div>
        <div class="col-md-6">
          <label>SWM official email:</label>
          <input type="text" class="form-control" id="editemail" value="<?php echo $selectnovletter[0]['swm_email']; ?>">
        </div>
        <div class="col-md-6">
          <label>SWM contact information:</label>
          <input type="text" class="form-control" id="editcontactinfo" value="<?php echo $selectnovletter[0]['swm_contactinfo']; ?>">
        </div>
        <div class="col-md-12">
          <label>Route this letter to / for approval of:</label>
          <select class="form-control" id="swm_frapprvl">
            <option value=""></option>
            <?php
              for ($rt=0; $rt < sizeof($queryrouteto); $rt++) {
              $prefix = (!empty($queryrouteto[$rt]['title'])) ? $queryrouteto[$rt]['title'].' ' : '';
              $mname = (!empty($queryrouteto[$rt]['mname'])) ? $queryrouteto[$rt]['mname'][0].'. ' : '';
              $suffix = (!empty($queryrouteto[$rt]['suffix'])) ? ' '.$queryrouteto[$rt]['suffix'] : '';
              $name = $prefix.$queryrouteto[$rt]['fname'].' '.$mname.$queryrouteto[$rt]['sname'].$suffix;
            ?>
              <optgroup label="<?php echo $queryrouteto[$rt]['func']; ?>">
                <option value="<?php echo $this->encrypt->encode($queryrouteto[$rt]['userid'].'|'.$name); ?>"><?php echo $name; ?></option>
              </optgroup>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" onclick="editnovletterbutton($('#edittoken').val(),$('#editreportnumber').val(),$('#editprefix').val(),$('#editfirstname').val(),$('#editmiddleinitial').val(),$('#editlastname').val(),$('#editsuffix').val(),$('#editdesignation').val(),$('#editmuncity').val(),$('#editwasteremov').val(),$('#editemail').val(),$('#editcontactinfo').val(),$('#editletterdate').val(),$('#swm_frapprvl').val());" class="btn btn-success btn-sm">Proceed</button>
    </div>
    <script type="text/javascript">
      $('#editbindletterselectize').selectize();
      $('#swm_frapprvl').selectize();
    </script>
   <?php
  }

  function editnovletterbutton(){
    date_default_timezone_set("Asia/Manila");

    $ip_address = $this->input->ip_address();

    $token = $this->encrypt->decode($_POST['token']);
    $rn = $this->encrypt->decode($_POST['rn']);
    $px = !empty($_POST['px']) ? $_POST['px'].' ' : '';
    $fn = $_POST['fn'];
    $mi = !empty($_POST['mi']) ? $_POST['mi'].'. ' : '';
    $ln = $_POST['ln'];
    $sx = !empty($_POST['sx']) ? ' '.$_POST['sx'] : '';
    $dn = $_POST['dn'];
    $mc = $_POST['mc'];
    $wr = $_POST['wr'];
    $em = $_POST['em'];
    $ci = $_POST['ci'];
    $ld = $_POST['ld'];
    $route = $this->encrypt->decode($_POST['route']);
    $addressto = $px.$fn.' '.$mi.$ln.$sx;
    $explode = explode('|',$route);

    if(!empty($explode[0]) AND !empty($explode[1])){
      $setdata = array(
                       'letter_date' => $ld,
                       'address_to' => $addressto,
                       'address_to_prefix' => $_POST['px'],
                       'address_to_fname' => $fn,
                       'address_to_mname' => $_POST['mi'],
                       'address_to_sname' => $ln,
                       'address_to_suffix' => $_POST['sx'],
                       'designation' => $dn,
                       'muncity' => $mc,
                       'waste_removal' => $wr,
                       'swm_email' => $em,
                       'swm_contactinfo' => $ci,
                       'status' => 'On-Process',
                       'assigned_to' => $explode[0],
                       'assigned_name' => $explode[1],
                      );
      $wheredata = array('trans_no' => $token, 'report_number' => $rn, );
      $updatedata = $this->Embismodel->updatedata($setdata, 'sweet_nov_letter', $wheredata);

      $where    = $this->db->where('acs.userid',$explode[0]);
      $where    = $this->db->where('acs.verified','1');
      $join     = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
      $join     = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
      $receiver = $this->Embismodel->selectdata('acc_credentials AS acs','xn.divno,xn.divname,xt.secno,xt.sect,acs.region,acs.userid,acs.token,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$where);

      $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
      $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
      $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
      $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
      $receiverdivno = (!empty($receiver[0]['divno'])) ? $receiver[0]['divno'] : '';
      $receiversecno = (!empty($receiver[0]['secno'])) ? $receiver[0]['secno'] : '';

      $date_out = date('Y-m-d H:i:s');
      $et_where = array('et.token' => $token,);
      $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', 'et.trans_no, et.route_order, et.subject', $et_where );

      $set = array(
        'et.route_order'        => $er_trans_query[0]['route_order']+1,
        'et.status'             => "15",
        'et.status_description' => "For Approval",
        'et.receive'            => 0,
        'et.sender_id'          => $this->session->userdata('token'),
        'et.sender_name'        => $this->session->userdata('name'),
        'et.receiver_division'  => $receiver[0]['divname'],
        'et.receiver_section'   => $receiver[0]['sect'],
        'receiver_region'       => $receiver[0]['region'],
        'et.receiver_id'        => $receiver[0]['token'],
        'et.receiver_name'      => $receiver_name,
        'et.action_taken'       => "Pls. for approval (NOV Letter)",
        'et.remarks'            => "None",
      );

      $where = array( 'et.trans_no' => $er_trans_query[0]['trans_no']);
      $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

      $insert_er_trans_log_table = array(
        'trans_no'            => $er_trans_query[0]['trans_no'],
        'route_order'         => $er_trans_query[0]['route_order']+1,
        'subject'             => $er_trans_query[0]['subject'],
        'sender_divno'        => $this->session->userdata('divno'),
        'sender_secno'        => $this->session->userdata('secno'),
        'sender_id'           => $this->session->userdata('token'),
        'sender_name'         => $this->session->userdata('name'),
        'sender_region'       => $this->session->userdata('region'),
        'sender_ipadress'     => $ip_address,
        'receiver_divno'      => $receiverdivno,
        'receiver_secno'      => $receiversecno,
        'receiver_id'         => $receiver[0]['token'],
        'receiver_name'       => $receiver_name,
        'receiver_region'     => $receiver[0]['region'],
        'type'                => "51",
        'status'              => "15",
        'status_description'  => "For Approval",
        'action_taken'        => "Pls. for approval (NOV Letter)",
        'date_in'             => $date_out,
        'date_out'            => $date_out,
      );

      $insert_er_trans_log = $this->Embismodel->insertdata('er_transactions_log', $insert_er_trans_log_table);
    }

    if($updatedata){
      echo json_encode(array('status' => 'success', ));
    }else{
      echo json_encode(array('status' => 'failed', ));
    }
  }
}
?>
