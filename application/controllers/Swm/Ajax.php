<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax extends CI_Controller
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

  function bindletternv(){
    $token =  $this->encrypt->decode($this->input->post('token'));
    $explodedtoken = explode('|',$token);

    $wheredata = $this->db->where('sf.trans_no = "'.$explodedtoken[0].'" AND sf.cnt = "'.$explodedtoken[1].'"');
    $joindata = $this->db->join('dms_company AS dc','dc.emb_id = sf.lgu_patrolled_id','left');
    $selectdata = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.report_number, sf.lgu_patrolled_id, sf.lgu_patrolled_name, dc.province_name, sf.violations_observed_desc, sf.barangay_name',$joindata,$wheredata);

    $explodedvo = explode(';',trim($selectdata[0]['violations_observed_desc']));

    $orderby = $this->db->order_by('svo.voorder ASC');
    for ($i=0; $i < count($explodedvo); $i++) {
      if(!empty($explodedvo[$i])){
        $wherevo = $this->db->or_where('svo.section = "'.$explodedvo[$i].'"');
      }
    }

    $selectvo = $this->Embismodel->selectdata('sweet_violations_observed AS svo','svo.prohibited_act, svo.section','',$wherevo);

    $wherestmnt = '';
    $rncntr = 0;
    for ($rn=0; $rn < $selectdata[0]['report_number']; $rn++) {
      $rncntr++;
      $whrstmntcon = ($selectdata[0]['report_number'] == $rncntr) ? '' : ' OR ';
      $wherestmnt .= 'sf.report_number = "'.$rncntr.'"'.$whrstmntcon;
    }
    $wheremonitoringhistory = $this->db->where('('.$wherestmnt.')');

    $wheremonitoringhistory = $this->db->where('sf.trans_no = "'.$explodedtoken[0].'" ORDER BY sf.report_number ASC');
    $selectmonitoringhistory = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.date_patrolled, sf.time_patrolled, sf.report_number','',$wheremonitoringhistory);

    $counter = 0;
    $sizeofarray = sizeof($selectmonitoringhistory);
    for ($s=0; $s < sizeof($selectmonitoringhistory); $s++) {
      if(!empty($selectmonitoringhistory[$s]['report_number'])){
        $counter++;
        if($counter == $sizeofarray){
          $cmnd = '';
        }else if($counter == ($sizeofarray-1)){
          $cmnd = ' and ';
        }else{
          $cmnd = ', ';
        }
        $a = $selectmonitoringhistory[$s]['report_number'];
        $rn = $a.substr(date('jS', mktime(0,0,0,1,($a%10==0?9:($a%100>20?$a%10:$a%100)),2000)),-2).' monitoring';
        $datemonitored .= date('F d, Y', strtotime($selectmonitoringhistory[$s]['date_patrolled'])).' at '.date("h:i a", strtotime($selectmonitoringhistory[$s]['time_patrolled'])).' ( '.$rn.' )'.$cmnd;
      }
    }

    if(!empty($explodedtoken[0]) AND !empty($selectdata[0]['lgu_patrolled_id'])){
      $this->session->set_userdata('iisno', $explodedtoken[0]);
      $this->session->set_userdata('iisnoen', $this->input->post('token'));
      $this->session->set_userdata('embid', $selectdata[0]['lgu_patrolled_id']);
      $this->session->set_userdata('brgyname', $selectdata[0]['barangay_name']);
      $this->session->set_userdata('lguname', $selectdata[0]['lgu_patrolled_name']);
      $this->session->set_userdata('lguprov', ucwords(strtolower($selectdata[0]['province_name'])));
      $this->session->set_userdata('datemonitored', $datemonitored);

      if((count($explodedvo)) > 0){
        $this->session->set_userdata('voconcat', $selectdata[0]['violations_observed_desc']);
      }
    }
    $arraydata = array('iisno' => $explodedtoken[0], 'embid' => $selectdata[0]['lgu_patrolled_id'], 'brgyname' => $selectdata[0]['barangay_name'], 'lguprov' => ucwords(strtolower($selectdata[0]['province_name'])), 'datemonitored' => $datemonitored, );
    $arraymerge = array_merge($arraydata, ['vodata' => $selectvo]);
    echo json_encode($arraymerge);
  }

  function setltrdtnv(){
    $token =  date("F d, Y", strtotime($this->input->post('token')));
    if(!empty($token)){
      $this->session->set_userdata('ltrdt', $token);
      echo json_encode(array('ltrdt' => $token, ));
    }
  }

  function prfxltr(){
    $token =  strtoupper($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('prfxltr', $token);
      echo json_encode(array('prfxltr' => $token, ));
    }else{
      $this->session->set_userdata('prfxltr', '');
      echo json_encode(array('prfxltr' => '___', ));
    }
  }

  function fnmltr(){
    $token =  strtoupper($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('fnmltr', $token);
      echo json_encode(array('fnmltr' => $token, ));
    }else{
      $this->session->set_userdata('fnmltr', '');
      echo json_encode(array('fnmltr' => '___', ));
    }
  }

  function miltr(){
    $token =  strtoupper($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('miltr', $token);
      echo json_encode(array('miltr' => $token, ));
    }else{
      $this->session->set_userdata('miltr', '');
      echo json_encode(array('miltr' => '___', ));
    }
  }

  function lnltr(){
    $token =  strtoupper($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('lnltr', $token);
      echo json_encode(array('lnltr' => $token, 'ulnltr' => ucwords(strtolower($this->input->post('token'))), ));
    }else{
      $this->session->set_userdata('lnltr', '');
      echo json_encode(array('lnltr' => '___', 'ulnltr' => '___', ));
    }
  }

  function sfxltr(){
    $token =  strtoupper($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('sfxltr', $token);
      echo json_encode(array('sfxltr' => $token, ));
    }else{
      $this->session->set_userdata('sfxltr', '');
      echo json_encode(array('sfxltr' => '', ));
    }
  }

  function desltr(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('desltr', $token);
      echo json_encode(array('desltr' => $token, 'udesltr' => ucwords(strtolower($this->input->post('token'))), ));
    }else{
      $this->session->set_userdata('desltr', '');
      echo json_encode(array('desltr' => '______________________', 'udesltr' => '___', ));
    }
  }

  function mctyltr(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('mctyltr', $token);
      echo json_encode(array('mctyltr' => $token, ));
    }else{
      $this->session->set_userdata('mctyltr', '');
      echo json_encode(array('mctyltr' => '______________________', ));
    }
  }

  function swmoe(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('swmoe', $token);
      echo json_encode(array('swmoe' => $token, ));
    }else{
      $this->session->set_userdata('swmoe', '');
      echo json_encode(array('swmoe' => '______________________', ));
    }
  }

  function swrmvl(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('swrmvl', $token);
      echo json_encode(array('swrmvl' => $token, ));
    }else{
      $this->session->set_userdata('swrmvl', '');
      echo json_encode(array('swrmvl' => 'two (2) weeks on or before', ));
    }
  }

  function swmcinf(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('swmcinf', $token);
      echo json_encode(array('swmcinf' => $token, ));
    }else{
      $this->session->set_userdata('swmcinf', '');
      echo json_encode(array('swmcinf' => '______________________', ));
    }
  }

  function ccon(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('ccon', $token);
      echo json_encode(array('ccon' => $token, ));
    }else{
      $this->session->set_userdata('ccon', '');
      echo json_encode(array('ccon' => '', ));
    }
  }

  function ccoa(){
    $token =  ($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('ccoa', $token);
      echo json_encode(array('ccoa' => $token, ));
    }else{
      $this->session->set_userdata('ccoa', '');
      echo json_encode(array('ccoa' => '', ));
    }
  }

  function swm_frapprvlfnc(){
    $token =  $this->encrypt->decode($this->input->post('token'));
    if(!empty($token)){
      $this->session->set_userdata('swm_frapprvl', $token);
    }else{
      $this->session->set_userdata('swm_frapprvl', '');
    }
  }

  function formdata(){

    if(!empty($_POST['routeto']) AND !empty($_POST['bindletterselectize']) AND !empty($_POST['letter_date']) AND !empty($_POST['prefix']) AND !empty($_POST['firstname']) AND !empty($_POST['lastname']) AND !empty($_POST['designation']) AND !empty($_POST['lgu_name']) AND !empty($_POST['span_wrmvl']) AND !empty($_POST['swm_oe']) AND !empty($_POST['swm_ci'])){

      date_default_timezone_set("Asia/Manila");

      $ip_address = $this->input->ip_address();
      $date_out = date('Y-m-d H:i:s');

      $explodedata = explode('|', $this->encrypt->decode($_POST['bindletterselectize']));
      $trans_no = $explodedata[0];
      $transcnt = $explodedata[1];

      $wheredata = array('sfl.trans_no' => $trans_no, 'sfl.cnt' => $transcnt,);
      $selectdata = $this->Embismodel->selectdata('sweet_form_log AS sfl','sfl.trans_no, sfl.report_number, sfl.subject, sfl.date_patrolled, sfl.time_patrolled, sfl.lgu_patrolled_id, sfl.lgu_patrolled_name, sfl.violations_observed_desc, sfl.barangay_name, sfl.street, sfl.latitude, sfl.longitude',$wheredata);

      $prefix = (!empty($_POST['prefix'])) ? $_POST['prefix'].' ' : '';
      $middleinitial = (!empty($_POST['middleinitial'])) ? $_POST['middleinitial'].' ' : '';
      $suffix = (!empty($_POST['suffix'])) ? ' '.$_POST['suffix'] : '';
      $address_to = $prefix.$_POST['firstname'].' '.$middleinitial.$_POST['lastname'].$suffix;

      $exploderoutedata = explode('|', $this->encrypt->decode($_POST['routeto']));

      $where    = $this->db->where('acs.token',$exploderoutedata[0]);
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
      $et_where = array('et.token' => $selectdata[0]['trans_no'],);
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

      $letterdata = array(
                         'trans_no' => $selectdata[0]['trans_no'],
                         'report_number' => $selectdata[0]['report_number'],
                         'userid' => $this->session->userdata('userid'),
                         'name' => $this->session->userdata('name'),
                         'region' => $this->session->userdata('region'),
                         'subject' => $selectdata[0]['subject'],
                         'date_created' => date('Y-m-d'),
                         'date_patrolled' => $selectdata[0]['date_patrolled'],
                         'time_patrolled' => $selectdata[0]['time_patrolled'],
                         'lgu_patrolled_id' => $selectdata[0]['lgu_patrolled_id'],
                         'lgu_patrolled_name' => $selectdata[0]['lgu_patrolled_name'],
                         'violations_observed_desc' => $selectdata[0]['violations_observed_desc'],
                         'barangay_name' => $selectdata[0]['barangay_name'],
                         'street' => $selectdata[0]['street'],
                         'latitude' => $selectdata[0]['latitude'],
                         'longitude' => $selectdata[0]['longitude'],
                         'letter_date' => $_POST['letter_date'],
                         'address_to' => $address_to,
                         'address_to_prefix' => $_POST['prefix'],
                         'address_to_fname' => $_POST['firstname'],
                         'address_to_mname' => $_POST['middleinitial'],
                         'address_to_sname' => $_POST['lastname'],
                         'address_to_suffix' => $_POST['suffix'],
                         'designation' => $_POST['designation'],
                         'muncity' => $_POST['lgu_name'],
                         'waste_removal' => $_POST['span_wrmvl'],
                         'swm_email' => $_POST['swm_oe'],
                         'swm_contactinfo' => $_POST['swm_ci'],
                         'cc_office' => $_POST['office_name'],
                         'cc_address' => $_POST['office_address'],
                         'status' => 'On-Process',
                         'assigned_to' => $receiver[0]['userid'],
                         'assigned_name' => $exploderoutedata[1],
                        );
      $insertdata = $this->Embismodel->insertdata('sweet_nov_letter', $letterdata);

      $where_contact_info = array('sci.region' => $this->session->userdata('region'), );
      $select_contact_info = $this->Embismodel->selectdata('sweet_contact_info AS sci','sci.email, sci.contact_info',$where_contact_info);

      if(!empty($select_contact_info[0]['email'])){
        $setdata = array('email' => $_POST['swm_oe'], 'contact_info' => $_POST['swm_ci'], );
        $wheredata = array('region' => $this->session->userdata('region'), );
        $update_contact_info = $this->Embismodel->updatedata($setdata, 'sweet_contact_info', $wheredata);
      }else{
        $data = array('region' => $this->session->userdata('region'), 'email' => $_POST['swm_oe'], 'contact_info' => $_POST['swm_ci'], );
        $insert_contact_info = $this->Embismodel->inserdata('sweet_contact_info', $data);
      }

      $where_nov_cc = array('snc.region' => $this->session->userdata('region'), );
      $select_nov_cc = $this->Embismodel->selectdata('sweet_nov_cc AS snc','snc.office_name, snc.office_address',$where_nov_cc);

      if(!empty($select_nov_cc[0]['office_name'])){
        $setdata = array('office_name' => $_POST['office_name'], 'office_address' => $_POST['office_address'], );
        $wheredata = array('region' => $this->session->userdata('region'), );
        $update_cc = $this->Embismodel->updatedata($setdata, 'sweet_nov_cc', $wheredata);
      }else{
        $datacc = array('region' => $this->session->userdata('region'), 'office_name' => $_POST['office_name'], 'office_address' => $_POST['office_address'], );
        $insertdatacc = $this->Embismodel->insertdata('sweet_nov_cc', $datacc);
      }

      $swal_arr = array(
         'title'     => 'SUCCESS!',
         'text'      => 'NOV letter successfully submitted.',
         'type'      => 'success',
       );
       $this->session->set_flashdata('swal_arr', $swal_arr);

       $fieldsdata = array('status' => 'success', );
       $arraymerge = array_merge(['postdata' => $fieldsdata]);
       echo json_encode($arraymerge);

    }else{
      $fieldsdata = array(
                          'bindletterselectize' => $_POST['bindletterselectize'],
                          'letter_date'         => $_POST['letter_date'],
                          'prefix'              => $_POST['prefix'],
                          'firstname'           => $_POST['firstname'],
                          'lastname'            => $_POST['lastname'],
                          'designation'         => $_POST['designation'],
                          'lgu_name'            => $_POST['lgu_name'],
                          'span_wrmvl'          => $_POST['span_wrmvl'],
                          'swm_oe'              => $_POST['swm_oe'],
                          'swm_ci'              => $_POST['swm_ci'],
                          'status'              => 'failed',
                         );
      $arraymerge = array_merge(['postdata' => $fieldsdata]);
      echo json_encode($arraymerge);
    }
  }

  function chngvw(){
    $token =  $this->encrypt->decode($this->input->post('token'));
    $this->session->set_userdata('chngvw', $token);
    echo json_encode(array('chngvw' => $token, ));
  }

  function tom(){
    $tkn = explode('|',$this->encrypt->decode($this->input->post('token')));
    $token = $tkn[0];
    $cnt = $tkn[1];

    $wheredata = $this->db->where('sf.trans_no = "'.$token.'" AND sf.cnt = "'.$cnt.'"');
    $joindata = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no','left');
    $selectdata = $this->Embismodel->selectdata('sweet_form_log AS sf','sfa.attachment_name, sf.region, sf.date_created, sf.photo_remarks, sf.report_number, sf.type_of_monitoring, sf.date_of_first_monitoring, sf.date_of_second_monitoring, sf.date_of_last_monitoring, sf.date_of_issuance_of_notice, sf.number_dumping, sf.number_activity',$joindata,$wheredata);

    $wheretom = $this->db->where('stm.tomid != "" ORDER BY stm.tomorder ASC');
    $selecttom = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stm','stm.tomid, stm.tomtitle, stm.cat','',$wheretom);

    if($selectdata[0]['report_number'] >= '2'){
      $reportnumberdata = ($selectdata[0]['report_number']-1);
      $whereprevdata = $this->db->where('sf.trans_no = "'.$token.'" AND sf.report_number = "'.$reportnumberdata.'" AND sfa.report_number = "'.$reportnumberdata.'"');
      $joinprevdata = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no','left');
      $selectprevdata = $this->Embismodel->selectdata('sweet_form_log AS sf','sfa.attachment_name, sf.region, sf.date_created, sf.photo_remarks, sf.report_number',$joinprevdata,$whereprevdata);

      $attachmentleft = "https://iis.emb.gov.ph/iis-images/sweet_report/".date('Y', strtotime($selectprevdata[0]['date_created']))."/".$selectprevdata[0]['region']."/".$token."/".$selectprevdata[0]['attachment_name'];
    }

    $attachmentright = "https://iis.emb.gov.ph/iis-images/sweet_report/".date('Y', strtotime($selectdata[0]['date_created']))."/".$selectdata[0]['region']."/".$token."/".$selectdata[0]['attachment_name'];
    ?>
    <table>
      <tr>
        <td style="width:5%;text-align:center;">I.</td>
        <td style="text-align:left;">Type of Monitoring (pls. check, fill up as appropriate)</td>
      </tr>
    </table>
    <table>
      <?php for ($tm=0; $tm < sizeof($selecttom); $tm++) {
        $ifchecked = ($selecttom[$tm]['tomid'] == $selectdata[0]['type_of_monitoring']) ? '<img src="https://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">' : '<img src="https://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
      ?>
      <tr>
        <td style="padding-top: 10px;width:6%;text-align:right;"><?php echo $ifchecked; ?></td>
        <td style="padding-top: 10px;text-align:left;"><?php echo $selecttom[$tm]['tomtitle']; ?></td>
      </tr>
        <?php if($selecttom[$tm]['cat'] == 'b.'){ ?>
          <?php if(!empty($selectdata[0]['date_of_last_monitoring']) AND $selectdata[0]['type_of_monitoring'] == '2'){ ?>
            <tr>
              <td style="width:6%;text-align:right;"></td>
              <td style="text-align:left;padding-left:20px;">Date of first monitoring: <?php echo  $fm = ($selectdata[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_first_monitoring'])).'</u>' : '_____________'; ?></td>
            </tr>
            <tr>
              <td style="width:6%;text-align:right;"></td>
              <td style="text-align:left;padding-left:20px;">Date of second monitoring: <?php echo  $sm = ($selectdata[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_second_monitoring'])).'</u>' : '_____________'; ?></td>
            </tr>
            <tr>
              <td style="width:6%;text-align:right;"></td>
              <td style="text-align:left;padding-left:20px;">Date of last monitoring: <?php echo  $lm = ($selectdata[0]['type_of_monitoring'] == '2' AND !empty($selectdata[0]['date_of_last_monitoring'])) ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_last_monitoring'])).'</u>' : '_____________'; ?></td>
            </tr>
          <?php }else{ ?>
            <tr>
              <td style="width:6%;text-align:right;"></td>
              <td style="text-align:left;padding-left:20px;">Date of first monitoring: <?php echo  $fm = ($selectdata[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_first_monitoring'])).'</u>' : '_____________'; ?></td>
            </tr>
            <tr>
              <td style="width:6%;text-align:right;"></td>
              <td style="text-align:left;padding-left:20px;">Date of last monitoring: <?php echo  $sm = ($selectdata[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_second_monitoring'])).'</u>' : '_____________'; ?></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if($selecttom[$tm]['cat'] == 'c.'){ ?>
          <tr>
            <td style="width:6%;text-align:right;"></td>
            <td style="text-align:left;padding-left:20px;">Date of first monitoring: <?php echo  $fm = ($selectdata[0]['type_of_monitoring'] == '3') ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_first_monitoring'])).'</u>' : '_____________'; ?></td>
          </tr>
          <tr>
            <td style="width:6%;text-align:right;"></td>
            <td style="text-align:left;padding-left:20px;">Date of last monitoring: <?php echo  $lm = ($selectdata[0]['type_of_monitoring'] == '3' AND !empty($selectdata[0]['date_of_last_monitoring'])) ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_last_monitoring'])).'</u>' : '_____________'; ?></td>
          </tr>
          <tr>
            <td style="width:6%;text-align:right;"></td>
            <td style="text-align:left;padding-left:20px;">Date of issuance of last Notice: <?php echo $diln = ($selectdata[0]['type_of_monitoring'] == '3' AND !empty($selectdata[0]['date_of_issuance_of_notice'])) ? '<u>'.date('F d, Y', strtotime($selectdata[0]['date_of_issuance_of_notice'])).'</u>' : '_____________'; ?></td>
          </tr>
          <tr>
            <td style="width:6%;text-align:right;"></td>
            <td style="text-align:left;padding-left:20px;">Number of times <b><i>same site</i></b> is found with illegal dumping: <?php echo  $nd = ($selectdata[0]['type_of_monitoring'] == '3') ? '<u>'.$selectdata[0]['number_dumping'].'</u>' : '_____________'; ?></td>
          </tr>
          <tr>
            <td style="width:6%;text-align:right;"></td>
            <td style="text-align:left;padding-left:20px;">Number of times <b><i>same site</i></b> is found with open burning activity: <?php echo  $na = ($selectdata[0]['type_of_monitoring'] == '3') ? '<u>'.$selectdata[0]['number_activity'].'</u>' : '_____________'; ?></td>
          </tr>

        <?php } ?>
      <?php } ?>
    </table>
    <br>
    <table>
      <tr>
        <td style="width:5%;text-align:center;">II.</td>
        <td style="text-align:left;">Photo documentation/pictures</td>
      </tr>
    </table>
    <img style="border:1px solid #000; width:355px; height: 355px;" src="<?php echo $attachmentleft; ?>">&nbsp;<img style="border:1px solid #000; width:355px; height: 355px;" src="<?php echo $attachmentright; ?>"><br>

    <table>
       <tr>
          <td style="width:50%;text-align:center;"><b>Figure 1</b></td>
          <td style="width:50%;text-align:center;"><b>Figure 2</b></td>
       </tr>
    </table><br>
    <table>
       <tr>
          <td style="vertical-align:top;width:1%;color:#FFF;">.</td>
          <td style="vertical-align:top;text-align:justify;width:47%;"><b>Figure 1:</b>&nbsp;<span><?php echo $selectprevdata[0]['photo_remarks']; ?></span></td>
          <td style="vertical-align:top;width:1%;color:#FFF;">.</td>
          <td style="vertical-align:top;text-align:justify;width:47%;"><b>Figure 2:</b>&nbsp;<span><?php echo $selectdata[0]['photo_remarks']; ?></span></td>
       </tr>
    </table><br><br>
    <?php
  }

}

?>
