<?php

/**
 *
 */
class Transmodel extends CI_Model
{

  function newtrans(){
    date_default_timezone_set("Asia/Manila");
    $region          = $this->session->userdata('region');
    $sender_id       = $this->session->userdata('token');
    // echo $this->session->userdata('token'); exit;

    $region_where = array('ar.rgnnum' => $region );
    $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

    $wheretransaction= $this->db->where('et.region', $region);
    $new_transaction = $this->Embismodel->selectdata('er_transactions AS et', 'MAX(et.trans_no) AS max_trans_no', '', $wheretransaction);

    // echo $this->db->last_query(); exit;

    $current_yr = date("Y");
    $trans_rgn = $region_data[0]['rgnid'] * 1000000;
    // add statements for same region selection for transaction number identifiers

    if(sizeof($new_transaction) != 0) {
      $max_id = $new_transaction[0]['max_trans_no'];

      $transaction_yr = intval($max_id / 100000000);

      if($transaction_yr == $current_yr) {
        $trans_no = $max_id + 1;
      }
      else {
        $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
      }
    }
    else {
      $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
    }

    $trans_token = $region.'-'.$current_yr.'-'.sprintf('%06d', ($trans_no - ((int)($trans_no / 1000000)*1000000)));


    $date_in = date('Y-m-d H:i:s');

    $acwhere = array('ac.token' => $sender_id );
    $credq = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acwhere );

    $mname = ' ';
    if(!empty($credq[0]['mname']) )
      $mname = ' '.$credq[0]['mname'][0].'. ';

    $suffix = '';
    if(!empty($credq[0]['suffix']) )
      $suffix = ' '.$credq[0]['suffix'];

    $sender_name = ucwords($credq[0]['fname'].$mname.$credq[0]['sname']).$suffix;
    $trans_log_insert = array(
      'trans_no'        => $trans_no,
      'route_order'     => 0,
      'sender_divno'    => $credq[0]['divno'],
      'sender_secno'    => $credq[0]['secno'],
      'sender_id'       => $sender_id,
      'sender_name'     => $sender_name,
      'sender_ipadress' => '',
      'sender_region'   => $region,
      'date_in'         => $date_in,
    );
    $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

    $start_date = date('Y-m-d');

    $trans_insert = array(
      'trans_no'    => $trans_no,
      'token'       => $trans_token,
      'route_order' => 0,
      'region'      => $region,
      'sender_id'   => $sender_id,
      'sender_name'     => $sender_name,
      'start_date'  => $start_date,
    );
    $this->Embismodel->insertdata('er_transactions', $trans_insert);

    return $trans_no;
    $this->db->close();
  }

}
