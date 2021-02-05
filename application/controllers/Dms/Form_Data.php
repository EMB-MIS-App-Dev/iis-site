<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Form_Data extends CI_Controller
  {
    private $formdata;
    function __construct()
    {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      $this->formdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
    }

    private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->formdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->formdata['user']['region'] || $session_ucred['secno'] != $this->formdata['user']['secno'] || $session_ucred['divno'] != $this->formdata['user']['divno']) {
        $this->formdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

    private function _alert($alert_data="", $redirect_page="", $code="", $type="")
    {
      $asd = '';
      if(empty($alert_data)) {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'You have Accessed an Unidentified Page and have been Redirected to this Page. '.$code,
          'type'      => 'warning',
        );
      }
      else {
        if(!empty($code)) {
          $alert_data['text'] = $alert_data['text'].' '.$code;
        }
      }
      if(empty($type)) {
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
      }
      else {
        $this->session->set_flashdata('swal_alert_data', $alert_data);
      }

      if(empty($redirect_page)) {
        $redirect_page = base_url('dms/documents/all');
      }
      redirect($redirect_page);
    }

    function reopenTransaction()
    {
      /*
      * segment 4 - entry
      * segment 5 - trans_no
      * segment 6 - main_multi_cntr
      * segment 7 - multi_cntr
      */
      $post = $this->input->post();
      $enc_key = $this->encrypt->decode($post['reopen_enc_tkey']);
      // CHECK ENCRYPTED KEY POST DATA TO URI SEGMENT DATA
      $enc_data = explode(';', $enc_key);

      // DATA MOD SIGNATURE DEFAULT ALERT
      $datamod_sig = array(
        'alert_data'  => array( 'title' => 'ERROR', 'text' => 'There was a Change in Data, Reloading/Redirecting Page. <br>If this error persists, Contact System Administrator.', 'type' => 'error' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $company_fail = array(
        'alert_data'  => array( 'title' => 'ERROR', 'text' => 'It Appears that the selected Company is either Inactive, Still Awaiting Approval, or is Deleted. Please try again. <br>If this error persists,  Please Contact Administrator. [COMP-FAIL-PRC]', 'type' => 'error' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $asgnto_fail = array(
        'alert_data'  => array( 'title' => 'ERROR', 'text' => 'It Appears that the selected Personnel has either an Inactive Status, Still Awaiting Approval, Deleted, or Has Suddenly Change Division/Section. Please try again. <br>If this error persists, Please Contact Administrator. [USR-FAIL-PRC]', 'type' => 'error' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $multi_asgnto_fail = array(
        'alert_data'  => array( 'title' => 'ERROR', 'text' => 'You Have selected Multiple Personnel Processing, But The System has Either Received less than Two(2) Personnels, or Encountered Impersistent/Empty Data. Please re-select multiple Personnels and try processing again. <br>If this error persists, Please Contact Administrator. [M-USR-FAIL-PRC]', 'type' => 'error' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $query_fail = array(
        'alert_data'  => array( 'title' => 'ERROR', 'text' => 'The System Has Encountered an Interruption while Saving. Please check Internet Connection and Try Again. <br>If this error persists, Contact System Administrator.', 'type' => 'error' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $query_success = array(
        'alert_data'  => array( 'title' => 'SUCCESS', 'text' => 'test success.', 'type' => 'success' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $systemtable_fail = array(
        'alert_data'  => array( 'title' => 'ERROR', 'text' => 'Problem Encountered upon Saving Additional Sub-System Types. Please Contact Administrator. [SYSTB-FAIL-PRC]', 'type' => 'error' ),
        'redirect'    => base_url('dms/documents/process/'.$enc_data[0].'/'.$enc_data[1].'/'.$this->_is_empty($enc_data[2], 1).'/'.$enc_data[3]),
      );
      $data = array(
        'entry'           => $enc_data[0],
        'trans_no'        => $enc_data[1],
        'main_multi_cntr' => $enc_data[2],
        'multi_cntr'      => $enc_data[3],
        'route_order'     => $enc_data[4],
        'remarks'         => $post['remarks'],
      );

      // CHECK SESSION'S USER DATA MATCHES DATABASE DATA
      $this->validate_session();
      // VERIFY IF TRANSACTION IS INDEED ROUTED TO USER
      $rslt_trans = '';
      $where_trans = array(
        'trans_no'    => $data['trans_no'],
        'sender_id'   => $this->formdata['user']['token'],
      );

      // CHECK WHICH TABLE TO LOOK
      if(empty($data['main_multi_cntr'])) {
          $data['main_multi_cntr'] = '';
          $data['multi_cntr'] = 1;
          $rslt_trans = $this->Embismodel->selectdata('er_transactions', '*', $where_trans);
      }
      else {
        $where_trans['main_multi_cntr'] = $data['main_multi_cntr'];
        $where_trans['multi_cntr'] = $data['multi_cntr'];
        $rslt_trans = $this->Embismodel->selectdata('er_transactions_multi', '*', $where_trans);
      }
      // EMPTY RESULT
      if(!$rslt_trans) { $this->_alert('', base_url('dms/documents/filed-closed'), '[RTE-RES-TRNS]'); exit; }

      // CHECK TRANSACTION ROUTE ORDER TO HISTORY
      $where_trans_log = array(
        'trans_no'            => $data['trans_no'],
        'route_order'	        => $rslt_trans[0]['route_order'],
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'sender_id'	          => $this->formdata['user']['token'],
      );
      $rslt_trans_log = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trans_log);
      // EMPTY RESULT
      if(!$rslt_trans_log) { $data['trns_error'] += $data['trans_no']; $data['trns_error_type'] = '[TRNSLOG-TO-TRNS]'; $error_ncntr++; break; }

      /* START OF PROCESSING */
      $data['trnsctn'] = $rslt_trans;
      $data['trnsctn_log'] = $rslt_trans_log;
      $pinfo['company'] = $this->Embismodel->selectdata('dms_company', '*', array('token' => $data['trnsctn'][0]['company_token'], 'deleted' => 0) );
      $pinfo['systems'] = $this->Embismodel->selectdata('er_systems', '*', array('id' => $data['trnsctn'][0]['system'] ) );
      $pinfo['type'] = $this->Embismodel->selectdata('er_type', '*', array('id' => $data['trnsctn'][0]['type'] ) ); // DOT NOT PUT [0], USED ON ersystems_addedtable FUNCTION
      $pinfo['status'] = $this->Embismodel->selectdata( 'er_status', '*', array( 'id' => $data['trnsctn'][0]['status'] ) );
      $pinfo['sender'] = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $this->formdata['user']['token'] ) )[0];

      $data['snder'] = $this->personnel_fullname($this->formdata['user']['token']);
      $data['region'] = $this->formdata['user']['region'];
      $data['date_in'] = date('Y-m-d H:i:s');
      $data['date_out'] = date('Y-m-d H:i:s');
      $data['records_location'] = $data['trnsctn'][0]['records_location'];
      $data['qr_code_token'] = $data['trnsctn'][0]['qr_code_token'];
      $data['tag_doc_type'] = $data['trnsctn'][0]['tag_doc_type'];
      $data['courier_type'] = $data['trnsctn'][0]['courier_type'];
      $data['tracking_no'] = $data['trnsctn'][0]['tracking_no'];

      /*---------------------------- UPDATE er_transactions_log etl -THIS ROUTE_ORDER TO CORRESPONDING ROUTE_ORDER ---------------------------------------*/
      // SINGLE - DEFAULT
      $update['er_trans'] = array(
        'route_order'	        => $data['trnsctn_log'][0]['route_order']+1,
        'receive'             => 0,
        'receiver_division'   => $this->formdata['user']['divno'],
        'receiver_section'    => $this->formdata['user']['secno'],
        'receiver_region'	    => $this->formdata['user']['region'],
        'receiver_id'	        => $this->formdata['user']['token'],
        'receiver_name'	      => ucwords($data['snder']),
        'status'              => 3,
        'status_description'	=> 'active',
        'action_taken'        => 'For appropriate action.',
        'remarks'             => $post['remarks'],
      );

      if(!empty($this->input->post('asgnto_multiple'))) { // MULTIPLE
        $custom['er_translog'] = array(
          'multiprc'	          => 1,
          'receiver_divno'      => '',
          'receiver_secno'      => '',
          'receiver_id'         => 0,
          'receiver_name'       => '--',
          'receiver_region'     => '',
        );
        $update['er_translog'] = array_merge($update['er_translog'], $custom['er_translog']);

        $custom['er_trans'] = array(
          'multiprc'	          => 1,
          'receiver_division'   => '',
          'receiver_section'    => '',
          'receiver_region'     => '',
          'receiver_id'         => 0,
          'receiver_name'       => '--',
        );
        $update['er_trans'] = array_merge($update['er_trans'], $custom['er_trans']);
      }

      $insert['er_translog'] = array(
        'trans_no'	          => $data['trans_no'],
        'main_route_order'	  => $data['trnsctn_log'][0]['main_route_order'],
        'route_order'	        => $data['trnsctn'][0]['route_order']+1,
        'multiprc'	          => $data['trnsctn_log'][0]['multiprc'],
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'	        => $data['multi_cntr'],
        'subject'	            => trim($data['trnsctn'][0]['subject']),
        'sender_id'	          => $this->formdata['user']['token'],
        'sender_divno'        => $this->formdata['user']['divno'],
        'sender_secno'        => $this->formdata['user']['secno'],
        'sender_name'	        => ucwords($data['snder']),
        'sender_region'	      => $this->formdata['user']['region'],
        'sender_ipadress'	    => $this->input->ip_address(),
        'receiver_divno'      => $this->formdata['user']['divno'],
        'receiver_secno'      => $this->formdata['user']['secno'],
        'receiver_id'	        => $this->formdata['user']['token'],
        'receiver_name'	      => ucwords($data['snder']),
        'receiver_region'	    => $this->formdata['user']['region'],
        'type'                => $data['trnsctn'][0]['type'],
        'status'              => 3,
        'status_description'	=> 'active',
        'action_taken'        => 'For appropriate action.',
        'remarks'             => $post['remarks'],
        'date_in'	            => $data['date_in'],
        'date_out'            => $data['date_out'],
      );
      $update_er_translog = $this->Embismodel->insertdata( 'er_transactions_log', $insert['er_translog'] );
      // $update_er_translog FAILED
      if(!$update_er_translog){ $this->_alert($query_fail['alert_data'], $query_fail['redirect'], '[UPDT-ETRSLOG]'); exit; }

      // CHECK SOURCE TABLE TO LOOK
      if($data['entry'] == 1) { // SOURCE IS SINGLE
        $table_to_look = 'er_transactions';
        $where['er_trans'] = array(
          'trans_no'            => $data['trans_no'],
          'route_order'	        => $data['trnsctn'][0]['route_order'],
        );
      }
      else { // SOURCE  IS MULTIPLE
        $table_to_look = 'er_transactions_multi';
        $where['er_trans'] = array(
          'trans_no'            => $data['trans_no'],
          'route_order'	        => $data['trnsctn'][0]['route_order'],
          // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
          'multiprc'	          => 0,
          'main_multi_cntr'	    => $data['main_multi_cntr'],
          'multi_cntr'          => $data['multi_cntr'],
        );
      }
      $update_er_transaction = $this->Embismodel->updatedata( $update['er_trans'], $table_to_look, $where['er_trans'] );
      // $update_er_translog FAILED
      if(!$update_er_transaction){ $this->_alert($query_fail['alert_data'], $query_fail['redirect'], '[UPDT-ETRANS]'); exit; }

      $prc_success_ova = array(
        'title'     => 'SUCCESS',
        'text'      => '[IIS Reference No.] '.$data['trnsctn'][0]['token'].'<br />Your Transaction has been Successfully Reopened.<br />Thank you!',
        'type'      => 'success',
      );
      $this->formdata['dms']['options'] = $this->Embismodel->selectdata('acc_options', '*', array('userid' => $this->formdata['user']['id']) )[0];

      $this->_alert($prc_success_ova, base_url('dms/documents/filed-closed'), '', 'swal_alert_data');

      redirect( base_url('dms/documents/filed-closed') );
    }

    function transfer_trans_company()
    {
      $post=$this->input->post();

      $company = $this->Embismodel->selectdata( 'dms_company', 'token, emb_id, company_name', array('deleted' => 0, 'token' => $post['company']) )[0];

      if(isset($_POST['ttrnscomp_confirm']) && $company)
      {
        $rslt_etrns = $this->Embismodel->updatedata(array('company_token' => $post['company'], 'company_name' => $company['company_name']), 'er_transactions', array('deleted' => 0, 'token' => $post['company']) );
        $rslt_etrnsm = $this->Embismodel->updatedata(array('company_token' => $post['company'], 'company_name' => $company['company_name']), 'er_transactions_multi', array('deleted' => 0, 'token' => $post['company']) );
      }

      if($rslt_etrns && $rslt_etrnsm) {
          echo "<script>alert('Success.')</script>";
      }else {
        echo "<script>alert('Failed.');</script>";
      }
      echo "<script>window.location.href='".base_url('dms/documents/mod/filetransfer')."';</script>";
    }

    private function prc_personnel_fullname($token="")
    {
      $result = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $token ) )[0];

      return !empty($result) ? $result['fname'].' '
        .$this->_is_empty($result['mname'][0], '', '. ')
        .$result['sname']
        .$this->_is_empty($result['suffix'], '') : '--';
    }

    function multi_process_transaction()
    {
      $post = $this->input->post();
      $error_ncntr=0;
      $error['trns_error'];
      $error['trns_error_type'];

      foreach ($post['multitrans_no'] as $key => $value) {
        /*
        * segment 0 - entry
        * segment 1 - trans_no
        * segment 2 - main_multi_cntr
        * segment 3 - multi_cntr
        * segment 4 - route_order
        */
        // CHECK ENCRYPTED KEY POST DATA TO URI SEGMENT DATA
        $enc_key = $this->encrypt->decode($value);
        $enc_data = explode(';', $enc_key);
        $data = array(
          'entry'           => $enc_data[0],
          'trans_no'        => $enc_data[1],
          'main_multi_cntr' => $enc_data[2],
          'multi_cntr'      => $enc_data[3],
          'route_order'     => $enc_data[4],
        );

        // CHECK SESSION'S USER DATA MATCHES DATABASE DATA
        $this->validate_session();
        // VERIFY IF TRANSACTION IS INDEED ROUTED TO USER
        $rslt_trans = '';
        $where_trans = array(
          'trans_no'    => $data['trans_no'],
          'receiver_id' => $this->formdata['user']['token'],
        );

        // CHECK WHICH TABLE TO LOOK
        if($data['entry'] == 1) {
          $data['main_multi_cntr'] = '';
          $data['multi_cntr'] = 1;
          $rslt_trans = $this->Embismodel->selectdata('er_transactions', '*', $where_trans);
        }
        else {
          $where_trans['main_multi_cntr'] = $data['main_multi_cntr'];
          $where_trans['multi_cntr'] = $data['multi_cntr'];
          $rslt_trans = $this->Embismodel->selectdata('er_transactions_multi', '*', $where_trans);
        }

        // EMPTY RESULT
        if(!$rslt_trans) { $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[TRNS-CHK]'; $error_ncntr++; break; }
        // CHECK INTEGRITY OF RECEIVER
        $rcvr_uid = $this->Embismodel->selectdata( 'acc_credentials', 'userid', array('token' => $post['receiver'], 'verified' => 1) )[0];
        $psecx= !empty($post['section']) ? $post['section'] : '';
        $func_check = $this->Embismodel->selectdata( 'acc_function', '*', array('divno' => $post['division'], 'secno' => $psecx, 'userid' => $rcvr_uid['userid'] ) );
        // EMPTY RESULT

                        // echo $post['section'];
                        //   echo "<pre>".print_r($func_check, TRUE)."</pre>";
        if(!$func_check) { $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[RCVR-CHK]'; $error_ncntr++; break; }

        // CHECK STATUS (DRAFT, CLOSED, CLAIMED, SENT VIA COURIER)
        if(in_array($rslt_trans[0]['status'], array(0, 18, 19, 24))) { $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[TRNS-STAT-END]'; $error_ncntr++; break; }
        // CHECK IF TRANSACTION IS MARKED AS RECEIVED
        if($rslt_trans[0]['receive'] != 1) { $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[TRNS-NRCV]'; $error_ncntr++; continue; }
        // CHECK TRANSACTION ROUTE ORDER TO HISTORY
        $where_trans_log = array(
          'trans_no'            => $data['trans_no'],
          // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
          'route_order'	        => $rslt_trans[0]['route_order']+1,
          'main_multi_cntr'	    => $data['main_multi_cntr'],
          'multi_cntr'          => $data['multi_cntr'],
          'sender_id'	          => $this->formdata['user']['token'],
        );
        $rslt_trans_log = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trans_log);
        if(!$rslt_trans_log) { $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[TRNSLOG-CHK]'; $error_ncntr++; break; }

        /* ---------------------------------------------- START OF PROCESSING --------------------------------------------------- */
        $data['trnsctn'] = $rslt_trans;
        $data['trnsctn_log'] = $rslt_trans_log;
        $pinfo['status'] = $this->Embismodel->selectdata( 'er_status', '*', array( 'id' => $post['status'] ) );
        $pinfo['sender'] = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $this->formdata['user']['token'] ) )[0];
        $pinfo['receiver'] = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $post['receiver'] ) )[0];

        $data['snder'] = $this->prc_personnel_fullname($this->formdata['user']['token']);
        $data['rcver'] = $this->prc_personnel_fullname($post['receiver']);
        $data['region'] = $this->_is_empty($post['region'], $this->formdata['user']['region']);
        $data['date_in'] = date('Y-m-d H:i:s');
        $data['date_out'] = date('Y-m-d H:i:s');
        $data['records_location'] = $data['trnsctn'][0]['records_location'];
        $data['qr_code_token'] = $data['trnsctn'][0]['qr_code_token'];
        $data['tag_doc_type'] = $data['trnsctn'][0]['tag_doc_type'];
        $data['courier_type'] = $data['trnsctn'][0]['courier_type'];
        $data['tracking_no'] = $data['trnsctn'][0]['tracking_no'];

        // APPROVED BY D
        $data['stat_dsc'] = ($post['status'] == 5 && $data['user']['token'] == '25dde3133d1748') ? 'signed by the Director' : $pinfo['status'][0]['name'];

        /*---------------------------- UPDATE er_transactions_log etl -THIS ROUTE_ORDER TO CORRESPONDING ROUTE_ORDER ---------------------------------------*/
        // SINGLE - DEFAULT
        $update['er_translog'] = array(
          'subject'	            => trim($data['trnsctn'][0]['subject']),
          'sender_divno'        => $this->formdata['user']['divno'],
          'sender_secno'        => $this->formdata['user']['secno'],
          'sender_name'	        => ucwords($data['snder']),
          'sender_region'	      => $this->formdata['user']['region'],
          'sender_ipadress'	    => $this->input->ip_address(),
          'receiver_divno'      => $post['division'],
          'receiver_secno'      => $post['section'],
          'receiver_id'	        => $post['receiver'],
          'receiver_name'	      => ucwords($data['rcver']),
          'receiver_region'	    => $data['region'],
          'type'                => $data['trnsctn'][0]['type'], // edited 02-12-2020
          'status'              => $post['status'],
          'status_description'	=> $data['stat_dsc'],
          'action_taken'        => $post['action'],
          'remarks'             => $post['remarks'],
          'date_out'            => $data['date_out'],
        );

        // SINGLE - DEFAULT
        $update['er_trans'] = array(
          'route_order'	        => $data['trnsctn_log'][0]['route_order'],
          'multiprc'	          => 0,
          // 'company_token'       => $post['company'],
          // 'company_name'        => $pinfo['company'][0]['company_name'],
          // 'emb_id'              => $pinfo['company'][0]['emb_id'],
          // 'subject'	            => trim($data['trnsctn'][0]['subject']),
          // 'system'              => $data['trnsctn'][0]['system'],
          // 'type'                => $post['type'],
          // 'type_description'    => $pinfo['type'][0]['name'],
          'receive'             => 0,
          'sender_id'	          => $this->formdata['user']['token'],
          'sender_name'	        => ucwords($data['snder']),
          'receiver_division'   => $post['division'],
          'receiver_section'    => $post['section'],
          'receiver_region'	    => $data['region'],
          'receiver_id'	        => $post['receiver'],
          'receiver_name'	      => ucwords($data['rcver']),
          'status'              => $post['status'],
          'status_description'	=> $data['stat_dsc'],
          'action_taken'        => $post['action'],
          'remarks'             => $post['remarks'],
          'records_location'    => $data['records_location'],
          // 'qr_code_token'       => $data['qr_code_token'],
          'courier_type'        => $data['courier_type'],
          'tracking_no'         => $data['tracking_no'],
          // 'tag_doc_type'        => $data['tag_doc_type'],
        );

        $where['er_translog'] = array(
          'trans_no'            => $data['trans_no'],
          // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
          'route_order'	        => $data['trnsctn'][0]['route_order']+1,
          'main_multi_cntr'	    => $data['main_multi_cntr'],
          'multi_cntr'          => $data['multi_cntr'],
          'sender_id'	          => $this->formdata['user']['token'],
        );
        $update_er_translog = $this->Embismodel->updatedata( $update['er_translog'], 'er_transactions_log', $where['er_translog'] );
        // $update_er_translog FAILED
        if(!$update_er_translog){ $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[TRNS-LOG-UPDT]'; $error_ncntr++; break;  }

        // CHECK SOURCE TABLE TO LOOK
        if($data['entry'] == 1) { // SOURCE IS SINGLE
          $table_to_look = 'er_transactions';
          $where['er_trans'] = array(
            'trans_no'            => $data['trans_no'],
            'route_order'	        => $data['trnsctn'][0]['route_order'],
          );
        }
        else { // SOURCE IS MULTIPLE
          $table_to_look = 'er_transactions_multi';
          $where['er_trans'] = array(
            'trans_no'            => $data['trans_no'],
            'route_order'	        => $data['trnsctn'][0]['route_order'],
            // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
            'multiprc'	          => 0,
            'main_multi_cntr'	    => $data['main_multi_cntr'],
            'multi_cntr'          => $data['multi_cntr'],
          );
        }
        $update_er_transaction = $this->Embismodel->updatedata( $update['er_trans'], $table_to_look, $where['er_trans'] );
        // $update_er_translog FAILED
        if(!$update_er_transaction){ $data['trns_error'][] = $data['trans_no']; $data['trns_error_type'][] = '[ENT-TRNS-UPDT]'; $error_ncntr++; break; }
      }
      // echo "<pre>".print_r($update_er_translog,TRUE)."</pre>";
      // exit;
      if($error_ncntr > 0) {
        $iis_no = '';
        foreach ($data['trns_error'] as $key => $value) {
          $iis_no .= $value.', ';
          $dt_error .= $data['trns_error_type'][$key].', ';
        }
        $errorlog['alert_data'] = array( 'title' => 'ERROR', 'text' => 'Error on Transsaction with nos.: <b>'.$iis_no.'</b> Please Contact System Administrator. '.$dt_error, 'type' => 'error');
        if($rslt_trans[0]['receive'] != 1) { $this->_alert($errorlog['alert_data'], base_url('dms/documents/inbox'), ' [MULT-PRC-ER]'); }
      }

      // if($this->formdata['user']['token'] == '515e12d4a186a84')
      // {
      //   echo '<pre>'.print_r($post['multitrans_no']).'</pre>';
      //   echo '<pre>'.print_r($errorlog['alert_data']).'</pre>';
      //   exit;
      // }

      $prc_success_ova = array(
        'title'     => 'SUCCESS',
        'text'      => 'Your IIS Transactions has been Successfully Saved.<br />Thank you!',
        'type'      => 'success',
      );
      $this->_alert($prc_success_ova, base_url('dms/documents/inbox'), '', 'swal_alert_data');
      // redirect( base_url('dms/documents/inbox'));
    }

  }
?>
