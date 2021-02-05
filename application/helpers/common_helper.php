<?php

function received_transaction_count() {
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $userid = $CI->session->userdata('userid');
  $embisdb = $CI->load->database('default', TRUE);

  $query = $embisdb->select('din.total')->from('vw_dms_inbox_notif as din')
                   ->where('din.userid',$userid)->get()->result_array();

  return $query[0]['total']!=0?$query[0]['total']:0;
  // return '-';
}


function company_request_notification(){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $regionid = $CI->session->userdata('region_id');
  $crsdb =   $CI->load->database('crs',TRUE);

  if ($regionid == '18') {
        $sessreg_id = '15';
  }else {
  $sessreg_id =  $CI->session->userdata('region_id');
  }
$query = $crsdb->select('cnt')->from('comp_req_notif')->where('est_region',$sessreg_id)->get()->num_rows();
                          // echo $crsdb->last_query();
  return $query;
}

function dp_permit($company_id = ''){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $regionid = $CI->session->userdata('region_id');
  $embisdb =   $CI->load->database('default',TRUE);
  $query = $embisdb->select('dcomp.*')->from('dms_company as dcomp')
                   ->where('dcomp.company_id',$company_id)->get()->result_array();
  if ($query[0]['add_type'] == 1) {
    $eccurl_file = 'uploads/';
  }elseif ($query[0]['add_type'] == 2) {
    $eccurl_file = '../../crs/uploads/';
  }
  return $eccurl_file;
}
function po_permit($company_id = ''){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $regionid = $CI->session->userdata('region_id');
  $embisdb =   $CI->load->database('embis',TRUE);
  $query = $embisdb->select('dcomp.*')->from('dms_company as dcomp')
                   ->where('dcomp.company_id',$company_id)->get()->num_rows();

  return $company_id;
}
function ecc_permit($company_id = ''){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $regionid = $CI->session->userdata('region_id');
  $embisdb =   $CI->load->database('embis',TRUE);
  $query = $embisdb->select('dcomp.*')->from('dms_company as dcomp')
                   ->where('dcomp.company_id',$company_id)->get()->num_rows();

  return $company_id;
}

// function travel_order_count($cat = '') {
//   $sTag = "";
//   $CI =& get_instance();
//   $sessions = $CI->load->library('session');
//   $embisdb = $CI->load->database('default', TRUE);
//   $total = '';
//   $ticketissuance = '';
//   if($CI->session->userdata('superadmin_rights') == 'yes' || $CI->session->userdata('to_ticket_request') == "yes" || $CI->session->userdata('to_view_all_approved') == "yes" || $CI->session->userdata('to_approver') == "yes"){
//     $queryforapproval = $embisdb->select('COUNT(et.trans_no) AS cnt')
//                                 ->from('er_transactions AS et')
//                                 ->where('et.receiver_id = "'.$CI->session->userdata('token').'" AND (et.action_taken = "For approval" OR et.action_taken = "Pls. for approval") AND et.status != "0"')->get()->result_array();
//     if($CI->session->userdata('to_ticket_request') == "yes" || $CI->session->userdata('superadmin_rights') == 'yes'){
//       $queryforticketissuance = $embisdb->select('COUNT(tt.er_no) AS cnt')
//                                         ->from('to_trans AS tt')
//                                         ->join('to_ticket_request AS ttr','ttr.er_no = tt.er_no','left')
//                                         ->join('er_transactions AS et','et.trans_no = tt.er_no','left')
//                                         ->where('tt.region = "'.$CI->session->userdata('region').'" AND tt.travel_type = "Air"  AND (tt.status = "Approved" OR tt.status = "Signed Document") AND et.status != 0 AND et.action_taken != "Issued Ticket"')->get()->result_array();
//       $ticketissuance = $queryforticketissuance[0]['cnt'];
//     }
//
//     $total = $queryforapproval[0]['cnt'] + $ticketissuance;
//
//     if($cat == 'all'){
//       return $total;
//     }else if($cat == 'forapproval'){
//       return $queryforapproval[0]['cnt'];
//     }else if($cat == 'ticketreq'){
//       return $ticketissuance;
//     }
//   }
// }

function to_forapproval(){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $userid = $CI->session->userdata('userid');
  $embisdb = $CI->load->database('default', TRUE);

  $queryforapproval = $embisdb->select('tfn.cnt')
                              ->from('to_forapproval_notif AS tfn')
                              ->where('tfn.userid = "'.$userid.'"')->get()->result_array();

  return $queryforapproval[0]['cnt'];
}

function to_ticketrequest(){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $region = $CI->session->userdata('region');
  $embisdb = $CI->load->database('default', TRUE);

  $queryticket = $embisdb->select('ttrn.cnt')
                        ->from('to_ticket_request_notif AS ttrn')
                        ->where('ttrn.region = "'.$region.'"')->get()->result_array();

  return $queryticket[0]['cnt'];
}

function to_total_count(){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $userid = $CI->session->userdata('userid');
  $region = $CI->session->userdata('region');
  $embisdb = $CI->load->database('default', TRUE);

  $ticketissuance = '';
  if($CI->session->userdata('superadmin_rights') == 'yes' || $CI->session->userdata('to_ticket_request') == "yes" || $CI->session->userdata('to_view_all_approved') == "yes" || $CI->session->userdata('to_approver') == "yes"){
    $queryforapproval = $embisdb->select('tfn.cnt')
                                ->from('to_forapproval_notif AS tfn')
                                ->where('tfn.userid = "'.$userid.'"')->get()->result_array();
    if($CI->session->userdata('to_ticket_request') == "yes" || $CI->session->userdata('superadmin_rights') == 'yes'){
      $queryticket = $embisdb->select('ttrn.cnt')
                            ->from('to_ticket_request_notif AS ttrn')
                            ->where('ttrn.region = "'.$region.'"')->get()->result_array();
      $ticketissuance = $queryticket[0]['cnt'];
    }
  }
  return $queryforapproval[0]['cnt'] + $ticketissuance;
}

function myschedules() {
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $embisdb = $CI->load->database('default', TRUE);
  $total = 0;
  $queryschedules   = $embisdb->select('sl.cnt, sl.participants, sl.date_schedule')
                              ->from('schedule_list AS sl')
                              ->where('sl.status = "Active" AND (sl.sched_status != "done" OR sl.sched_status != "postponed") AND sl.participants LIKE "%'.$CI->session->userdata('userid').'%"')->get()->result_array();
  for ($i=0; $i < sizeof($queryschedules); $i++) {
    $explodedata = explode('|', $queryschedules[$i]['participants']);
    for ($p=0; $p < count($explodedata); $p++) {
      if($explodedata[$p] == $CI->session->userdata('userid') AND $queryschedules[$i]['date_schedule'] >=  date('Y-m-d')){
        $total++;
      }
    }
  }
  return $total;
}

// function swmnotif() {
//   $sTag = "";
//   $CI =& get_instance();
//   $sessions = $CI->load->library('session');
//   $embisdb = $CI->load->database('default', TRUE);
//   $total = 0;
//   $queryschedules   = $embisdb->select('COUNT(sf.trans_no) AS mcnt')
//                               ->from('sweet_form AS sf')
//                               ->join('er_transactions AS et','et.token = sf.trans_no','left')
//                               ->where('sf.assigned_to = "'.$CI->session->userdata('userid').'" AND sf.status = "On-Process" AND et.status != "0"')->get()->result_array();
//   return $queryschedules[0]['mcnt'];
// }

function swm_forapproval_cnt(){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $userid = $CI->session->userdata('userid');
  $embisdb = $CI->load->database('default', TRUE);

  $queryforapproval    = $embisdb->select('sfn.cnt')
                              ->from('swm_forapproval_notif AS sfn')
                              ->where('sfn.userid = "'.$userid.'"')->get()->result_array();


  $queryforapprovalnov = $embisdb->select('sfnn.cnt')
                              ->from('swm_forapproval_nov_notif AS sfnn')
                              ->where('sfnn.userid = "'.$userid.'"')->get()->result_array();

  return $queryforapproval[0]['cnt'] + $queryforapprovalnov[0]['cnt'];
}


function all_company_list ($company_id){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $embisdb = $CI->load->database('default', TRUE);
  $companies = $embisdb->select('company_id,company_name')->from('dms_company')->where('deleted',0)->get()->result_array();
    echo '<select class="form-control" name="main_comp" id="main_comp_id">';
    echo '<option value="">SELECT MAIN COMPANY</option>';
    foreach ($companies as $key => $valuecmop) {
      if ($company_id == $valuecmop['company_id']) {
        echo '<option selected value="'.$valuecmop['company_id'].'">'.$valuecmop['company_name'].'</option>';
      }
      echo '<option value="'.$valuecmop['company_id'].'">'.$valuecmop['company_name'].'</option>';
    }
    echo '</select>';
$embisdb->close();

}

function region_list ($company_id){
  $sTag = "";
  $CI =& get_instance();
  $sessions = $CI->load->library('session');
  $embisdb = $CI->load->database('default', TRUE);
  $region = $embisdb->select('rgnnum,rgnid,rgnnam')->from('acc_region')->get()->result_array();
    echo '<select class="form-control" name="change_region" id="change_region_function">';
    echo '<option value="">SELECT REGION</option>';
    foreach ($region as $key => $valuereg) {
      if ($company_id == $valuereg['rgnnum']) {
        echo '<option selected value="'.$valuereg['rgnnum'].'">'.$valuereg['rgnnam'].'</option>';
      }
      echo '<option value="'.$valuereg['rgnnum'].'">'.$valuereg['rgnnam'].'</option>';
    }
    echo '</select>';
$embisdb->close();

}
