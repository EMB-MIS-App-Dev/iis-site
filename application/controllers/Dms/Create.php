<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Create extends CI_Controller
  {
    private $data;
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

      $this->dmsdata = array(
        'user_id'     => $this->session->userdata('userid'),
        'user_region' => $this->session->userdata('region'),
        'user_token'  => $this->session->userdata('token'),
      );

      $this->dmsdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
    }

    function index()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('includes/common/dms_styles');

      $this->load->view('Dms/include/custom_head');
      $this->load->view('Dms/include/custom_foot');

      if($this->uri->segment(1) != 'dms' && $this->uri->segment(2) != 'documents' && $this->uri->segment(3) != 'new') {
        redirect(base_url('error_404'));
      }
      if($this->uri->segment(2) === 'documents' && !empty($this->uri->segment(3)) && $this->uri->segment(3) == 'new') { // ADD XSS_CLEAN
        $this->router();
      }
      else {
        redirect(base_url('dms/documents/all'));
      }
    }

    private function router() // MAINLY FOR URI SEGMENT CHECKING ONLY
    {
      $this->dmsdata['tips'] = $this->Embismodel->selectdata('er_options', '*', array( 'userid' => $this->dmsdata['user']['id'] ) );

      switch ($this->uri->segment(3)) {
        case 'new': // SEPARATE TO ANOTHER DMS CONTROLLER FILE
            if( !empty($this->uri->segment(4)) ) {
              $this->new_transaction();
              // PUT AFTER FUNCTION TO RECEIVE DATA
              $this->load->view('Dms/include/modals');
              $this->load->view('Dms/include/multiselect_personnel_modals');
              $this->load->view('Dms/tips', $this->dmsdata);
            }
            else {
              $this->_alert('', '', '[CRTE-TRNS]');
            }
          break;

        default:
            $this->_alert('', '', '[SEG-THR]');
          break;
      }
    }

    private function array_debug($data='') { $data['data'] = $data; $this->load->view('Dms/debug', $data); }

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

    private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->dmsdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->dmsdata['user']['region'] || $session_ucred['secno'] != $this->dmsdata['user']['secno'] || $session_ucred['divno'] != $this->dmsdata['user']['divno']) {
        $this->dmsdata = array(
          'user_id'     => $session_ucred['userid'],
          'user_region' => $session_ucred['region'],
          'user_token'  => $session_ucred['token'],
        );
        $this->dmsdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

// ----------------------------------------------------------------- VIEWS -------------------------------------------------------------------- //

    // ------------------------------- DOCUMENTS (MAIN) ----------------------------------

    private function new_transaction()
    {
      /*
      * segment 4 - entry
      * segment 5 - trans_no
      * segment 6 - main_multi_cntr
      * segment 7 - multi_cntr
      */
      $encrpty = trim($this->uri->segment(4));
      $data = array(
        'trans_no'        => $this->uri->segment(4),
        'enc_key'         => $this->encrypt->encode($encrpty),
        'user_region'     => $this->dmsdata['user_region'],
        'user_token'      => $this->dmsdata['user_token'],
      );
      $data['user'] = $this->dmsdata['user'];
      // VERIFY IF TRANSACTION IS INDEED ROUTED TO USER
      $rslt_trans = '';
      $where_trans = array(
        'trans_no'        => $this->uri->segment(4),
        'sender_id'     => $this->dmsdata['user_token'],
      );
      $rslt_trans = $this->Embismodel->selectdata('er_transactions', '*', $where_trans);
      // EMPTY RESULT
      // if(!$rslt_trans) { $this->_alert('', base_url('dms/documents/inbox'), '[RTE-RES-TRNS]'); exit; }
      // DID NOT RECEIVED
      $didnt_receive['alert_data'] = array( 'title' => 'ERROR', 'text' => 'Please Mark As "RECEIVED" the Transsaction with no. <b>'.$rslt_trans[0]['token'].'</b> First Before Processing. If problem persists, Please Contact System Administrator.', 'type' => 'error');
      // if($rslt_trans[0]['receive'] != 1) { $this->_alert($didnt_receive['alert_data'], base_url('dms/documents/inbox'), '[TRNS-NRCV]'); exit; }
      // CHECK IF RECEIVER MATCHES TRANS. LOG HISTORY RECEIVER
      $where_trans['route_order'] = $rslt_trans[0]['route_order'];
      $rslt_trans_log_connect = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trans);
      // EMPTY RESULT
      $etlog_mismatch['alert_data'] = array( 'title' => 'ERROR', 'text' => 'The System has Identified a Data Mismatch to the Transaction with IIS No. <b>'.$rslt_trans[0]['token'].'</b>. Please Contact System Administrator.', 'type' => 'error');
      // if(!$rslt_trans_log_connect) { $this->_alert($etlog_mismatch['alert_data'], base_url('dms/documents/inbox'), '[RTE-RES-TLOG]'); exit; }
      // CHECK IF RECEIVER RECEIVED THE TRANSACTION
      $where_trans_log = array(
        'trans_no'            => $data['trans_no'],
        // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
        'route_order'	        => $rslt_trans[0]['route_order']+1,
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'sender_id'	          => $this->dmsdata['user']['token'],
      );
      $rslt_trans_log = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trans);
      // EMPTY RESULT
      $etlog_mismatch['alert_data'] = array( 'title' => 'ERROR', 'text' => 'The System has Identified a Data Mismatch to the Transaction with IIS No. <b>'.$rslt_trans[0]['token'].'</b>. Please Contact System Administrator.', 'type' => 'error');
      // if(!$rslt_trans_log) { $this->_alert($etlog_mismatch['alert_data'], base_url('dms/documents/inbox'), '[RTE-RESRCV-TLOG]'); exit; }
      // CHECK STATUS (DRAFT, CLOSED, CLAIMED, SENT VIA COURIER)
      $status_end['alert_data'] = array( 'title' => 'ERROR', 'text' => 'the Transsaction with no. <b>'.$rslt_trans[0]['token'].'</b> Has an End Status. If data is incorrect, Please Contact System Administrator.', 'type' => 'error');
      // if(in_array($rslt_trans[0]['status'], array(0, 18, 19, 24))) { $this->_alert($status_end['alert_data'], base_url('dms/documents/inbox'), '[TRNS-STAT-END]'); exit; }
      // GET SELECT DROPDOWNS
      $data['trans_data'] = $rslt_trans;
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*');
      $data['system'] = $this->Embismodel->selectdata('er_systems', '*', '', $this->db->order_by('system_order', 'asc'));
      $data['trans_type'] = $this->Embismodel->selectdata('er_type', '*', array( 'sysid' => $data['trans_data'][0]['system'] ), $this->db->order_by('sysid asc, ssysid asc, header desc'));
      $data['status'] = $this->Embismodel->selectdata('er_status', '*', array('id !=' => 1), $this->db->order_by('status_order', 'asc'));
      $data['action'] = $this->Embismodel->selectdata('er_action', '*');
      // FOR MULTI-SELECT PERSONNEL USE, MIGHT DELETE LATER
      $div_uloctype = $this->dmsdata['user']['region']=='CO' ? 'co' : 'region';
      $div_uloctype2 = strtolower($this->dmsdata['user']['region']);
      $where_data_division = $this->db->where('type IN ("'.$div_uloctype.'", "'.$div_uloctype2.'") AND office = "EMB"');
      $data['division'] = $this->Embismodel->selectdata( 'acc_xdvsion', '*', '', $where_data_division );
      // VIEWING OF COMPANY DETAILS
      $data['company_details'] = $this->Embismodel->selectdata('dms_company ', '*', array( 'token' => $data['trans_data'][0]['company_token'] ) );
      // USED FOR FUNCTION SELECTION WHEN USER HAS MULTIPLE FUNCTIONS
      $where_afunc = array('userid' => $this->dmsdata['user']['id'], 'stat' => 1 );
      $data['function'] = $this->Embismodel->selectdata('acc_function', '*', $where_afunc);
      // LIMITS AVAILABLE SELECTION OF ASSIGNED PERSONNEL
      // $this->assigned_slctn();
      // SUB-SYSTEM TYPES VIEW APPEND TO MAIN VIEW
      $data['add_input'] = $this->add_inputs();
      // NO NEED, MIGHT DELETE LATER
      $where_inthread = $this->db->where('trans_no = "'.$data['trans_no'].'" AND ( sender_id = "'.$data['user']['token'].'" OR receiver_id =  "'.$data['user']['token'].'" )');
      $data['prnl_inthread'] = $this->Embismodel->selectdata('er_transactions_log', 'trans_no', '', $where_inthread );
      $data['courier_type'] = $this->Embismodel->selectdata('er_courier AS ec', '*');
      // // TRANSACTION HISTORY
      // $data['history'] = $this->transaction_history();

      $where_attchmnts = array(
        'trans_no'            => $data['trans_no'],
        // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
        'route_order'	        => $rslt_trans[0]['route_order']+1,
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'deleted'             => 0,
      );
      $data['attachments'] = $this->Embismodel->selectdata('er_attachments', '*', $where_attchmnts);

      $data['recall'] = $this->Embismodel->selectdata( 'er_selection_recall', '*', array('userid' => $this->dmsdata['user']['id']) );

      $data['revert'] = $this->Embismodel->selectdata( 'acc_credentials', '*', array('token' => $rslt_trans[0]['sender_id']) );
      // echo '<pre>'.print_r($data['revert']).'</pre>';
      // print_r($rslt_trans);

      // echo $data['multicnt'] = explode('-', $data['main_multi_cntr']);
      $this->load->view('Dms/new_transaction', $data);
      // $this->validate_form('Dms/func/route_transaction1', $data);
    }

// ------------------------------------------- FORM VALIDATIONS ------------------------------------------ //
    private function validate_form($site="", $data="")
    {
      $data['fvalid_error'] = 0;
      if(empty($site)) {
        $alert_data = array(
          'title'     => 'ERROR',
          'text'      => 'Route Site Destination Not Set, Causes might be a Network Interruption. Please check the site, or Contact System Administrator. [VF-EMPST]',
          'type'      => 'error',
        );
        $this->_alert($alert_data);
      }

      if(isset($_POST['process_transaction']))
      {
        $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');

        $this->form_validation->set_rules('system', 'System', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('company', 'Company', 'required');
        // END STATUS
        if(!in_array($this->input->post('status'), array('17', '18', '19', '24', '27')))
        {
          // MULTIPLE
          if (!empty(($this->input->post('asgnto_multiple')))) {
            // $this->form_validation->set_rules('asgnto_multiple_input', 'Assign To- Multiple Personnel', 'required');
          }
          else {
            $this->form_validation->set_rules('division', 'Assign To- Division', 'required');
            $this->form_validation->set_rules('section', 'Assign To- Section', 'required');
            $this->form_validation->set_rules('receiver', 'Assign To- Receiver', 'required');
          }
        }
        $this->form_validation->set_rules('action', 'Action', 'required');
        // FIRST TRANSACTION ROUTE

        $this->dmsdata['atchx_rt'] = $data['trans_data'][0]['route_order'];
        if($data['trans_data'][0]['route_order'] == 0) {
          $this->form_validation->set_rules('attachment', 'Attachment', 'callback_attachment_exists');
        }

                // if($this->dmsdata['user']['token'] == '515e12d4a186a84')
                // {
                //   // echo $route;
                //   print_r($data['trans_data']); exit;
                // }

        // TRANSACTION STATUS "FOR FILING / CLOSED"
        if($this->input->post('status') == 24)
        {
          // RECORDS SECTION
          if( in_array($data['user']['secno'], array(77,166,176,195,223,231,232,235,255,279,316 )) )
          {
            $this->form_validation->set_rules('records_location', 'Rec. Only- File Location', 'required');
          }
          $this->form_validation->set_rules('attachment', 'Attachment', 'callback_attachment_exists');
        }
        // SENT VIA COURIER
        if($this->input->post('status') == '19') {
          $this->form_validation->set_rules('courier_type', '', 'required_courier');
        }

        $this->form_validation->set_message('required', '"%s" field is empty <br />');
        $this->form_validation->set_message('attachment_exists', '"%s" field is empty <br />');
        $this->form_validation->set_message('required_courier', '( For "Sent Via Courier", Courier Type is Required )' );

        if($this->form_validation->run() == FALSE)
        {
          $this->form_validation->error_array();
          $data['fvalid_error'] = 1;
          $this->load->view($site, $data);
        }
        else {
          $this->process_transaction();
        }
      }
      else {
        $this->load->view($site, $data);
      }
    }

// ------------------------------------------- FORM DATA ------------------------------------------ //

    private function prc_personnel_fullname($token="")
    {
      $result = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $token ) )[0];

      return !empty($result) ? $result['fname'].' '
        .$this->_is_empty($result['mname'][0], '', '. ')
        .$result['sname']
        .$this->_is_empty($result['suffix'], '') : '--';
    }

    private function process_transaction()
    {
      /*
      * segment 4 - entry
      * segment 5 - trans_no
      * segment 6 - main_multi_cntr
      * segment 7 - multi_cntr
      */
      $post = $this->input->post();
      $enc_key = $this->encrypt->decode($post['enc_key']);
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

      if($enc_data[0] != $this->uri->segment(4) || $enc_data[1] != $this->uri->segment(5) || $enc_data[2] != $this->uri->segment(6)) {
        if(empty($site)) {
          $this->_alert($datamod_sig['alert_data'], $datamod_sig['redirect'], '[ENC-TNO-PRC]');
        }
      }
      $data = array(
        'entry'           => $this->uri->segment(4),
        'trans_no'        => $this->uri->segment(5),
        'main_multi_cntr' => $this->uri->segment(6),
        'multi_cntr'      => $this->uri->segment(7),
      );
      // CHECK SESSION'S USER DATA MATCHES DATABASE DATA
      $this->validate_session();
      // VERIFY IF TRANSACTION IS INDEED ROUTED TO USER
      $rslt_trans = '';
      $where_trans = array(
        'trans_no'    => $data['trans_no'],
        'receiver_id' => $this->dmsdata['user']['token'],
      );
      // CHECK WHICH TABLE TO LOOK
      if($data['entry'] == 1) {
        if($data['main_multi_cntr'] == 1 && $data['multi_cntr'] == 1) {
          $data['main_multi_cntr'] = '';
          $data['multi_cntr'] = 1;
          $rslt_trans = $this->Embismodel->selectdata('er_transactions', '*', $where_trans);
        }
      }
      else {
        $where_trans['main_multi_cntr'] = $this->uri->segment(6);
        $where_trans['multi_cntr'] = $this->uri->segment(7);
        $rslt_trans = $this->Embismodel->selectdata('er_transactions_multi', '*', $where_trans);
      }
      // EMPTY RESULT
      if(!$rslt_trans) { $this->_alert('', base_url('dms/documents/inbox'), '[RTE-RES-TRNS]'); exit; }
      // CHECK INTEGRITY OF COMPANY
      $company_integ_check = $this->Embismodel->selectdata( 'dms_company', 'token', array('token' => $post['company'], 'deleted' => 0) );
      // EMPTY RESULT
      if(!$company_integ_check) { $this->_alert($company_fail['alert_data'], $company_fail['redirect']); exit; }
      // CHECK TRANSACTION ROUTE ORDER TO HISTORY
      $where_trans_log = array(
        'trans_no'            => $data['trans_no'],
        // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
        'route_order'	        => $rslt_trans[0]['route_order']+1,
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'sender_id'	          => $this->dmsdata['user']['token'],
      );
      $rslt_trans_log = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trans_log);
      // EMPTY RESULT
      if(!$rslt_trans_log) { $data['trns_error'] += $data['trans_no']; $data['trns_error_type'] = '[TRNSLOG-TO-TRNS]'; $error_ncntr++; break; }

      if(empty($this->input->post('asgnto_multiple'))) { //SINGLE
        // CHECK INTEGRITY OF RECEIVER
        $post['section'] = $this->_is_empty($post['section'], 0);
        $rcvr_uid = $this->Embismodel->selectdata( 'acc_credentials', 'userid', array('token' => $post['receiver'], 'verified' => 1) )[0];
        $func_check = $this->Embismodel->selectdata( 'acc_function', '*', array('divno' => $post['division'], 'secno' => $post['section'], 'userid' => $rcvr_uid['userid'] ) );
        // EMPTY RESULT
        if(!in_array($post['status'], array(18, 19, 24)) && !$func_check) { $this->_alert($asgnto_fail['alert_data'], $asgnto_fail['redirect']); exit; }
      }
      else {
        if(!in_array($post['status'], array(18, 19, 24)) && (empty($post['multislct_prsnl']) || count($post['multislct_prsnl']) < 2)) { $this->_alert($multi_asgnto_fail['alert_data'], $multi_asgnto_fail['redirect']); exit; }
      }
      /* START OF PROCESSING */
      $data['trnsctn'] = $rslt_trans;
      $data['trnsctn_log'] = $rslt_trans_log;
      $pinfo['company'] = $this->Embismodel->selectdata('dms_company', '*', array('token' => $post['company'], 'deleted' => 0) );
      $pinfo['systems'] = $this->Embismodel->selectdata('er_systems', '*', array('id' => $post['system'] ) );
      $pinfo['type'] = $this->Embismodel->selectdata('er_type', '*', array('id' => $post['type'] ) ); // DOT NOT PUT [0], USED ON ersystems_addedtable FUNCTION
      $pinfo['status'] = $this->Embismodel->selectdata( 'er_status', '*', array( 'id' => $post['status'] ) );
      $pinfo['sender'] = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $this->dmsdata['user']['token'] ) )[0];
      $pinfo['receiver'] = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $post['receiver'] ) )[0];

      $data['snder'] = $this->prc_personnel_fullname($this->dmsdata['user']['token']);
      $data['rcver'] = $this->prc_personnel_fullname($post['receiver']);
      $data['region'] = $this->_is_empty($post['region'], $this->dmsdata['user']['region']);
      $data['date_in'] = date('Y-m-d H:i:s');
      $data['date_out'] = date('Y-m-d H:i:s');
      $data['records_location'] = $this->_is_empty($post['records_location'], $data['trnsctn'][0]['records_location']);
      $data['qr_code_token'] = $this->_is_empty($post['qr_code_token'], $data['trnsctn'][0]['qr_code_token']);
      $data['tag_doc_type'] = $this->_is_empty($post['tag_doc_type'], $data['trnsctn'][0]['tag_doc_type']);
      $data['courier_type'] = $this->_is_empty($post['courier_type'], $data['trnsctn'][0]['courier_type']);
      $data['tracking_no'] = $this->_is_empty($post['tracking_no'], $data['trnsctn'][0]['tracking_no']);

      // APPROVED BY D
      $data['stat_dsc'] = ($post['status'] == 5 && $data['user_token'] == '25dde3133d1748') ? 'signed by the Director' : $pinfo['status'][0]['name'];

      /* ---------------------------------   MULTIPLE ROUTING  -------------------------------------------------*/
      if(!empty($post['multislct_prsnl']) && count($post['multislct_prsnl']) > 1)
      {
        $where['er_transmulti'] = array(
          'trans_no'            => $data['trans_no'],
          // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
          'route_order'	        => $data['trnsctn'][0]['route_order']+1,
          'main_multi_cntr'	    => $data['main_multi_cntr'],
          'multi_cntr'          => $data['multi_cntr'],
          'sender_id'	          => $this->dmsdata['user']['token'],
        );

        $pinfo['er_translog'] = $this->Embismodel->selectdata('er_transactions_log', 'date_in', $where['er_transmulti'] )[0];
        foreach ($post['multislct_prsnl'] as $key => $value) {
          /*
          * 0- receiver_region
          * 1- receiver_divno
          * 2- receiver_secno
          * 3- receiver_id
          * 4- receiver_name
          * 5- remarks
          */
          $data['multiprsnl'][$key] = explode(';', $value); // for json post data (multiple personnel data, separated with ";")
          $mtrns_rcvr = array(
            'divno'      => $this->_is_empty($data['multiprsnl'][$key][1], ''),
            'secno'      => $this->_is_empty($data['multiprsnl'][$key][2], ''),
            'id'         => $this->_is_empty($data['multiprsnl'][$key][3], 0),
            'name'       => $this->_is_empty($data['multiprsnl'][$key][4], '--'),
            'region'     => $this->_is_empty($data['multiprsnl'][$key][0], $this->dmsdata['user']['region']),
            'remarks'    => $this->_is_empty($data['multiprsnl'][$key][5], $post['remarks']),
          );

          $ins_mtrns_etrlog = array(
            'trans_no'            => $data['trans_no'],
            'main_route_order'    => $data['trnsctn_log'][0]['route_order'],
            'route_order'	        => 1,
            'multiprc'	          => 0,
            'main_multi_cntr'	    => trim($this->_is_empty($data['main_multi_cntr'], $data['multi_cntr'], '-'.$data['multi_cntr'])),
            'multi_cntr'          => $key+1,
            'subject'	            => $post['subject'],
            'sender_divno'        => $this->dmsdata['user']['divno'],
            'sender_secno'        => $this->dmsdata['user']['secno'],
            'sender_id'	          => $this->dmsdata['user']['token'],
            'sender_name'	        => ucwords($data['snder']),
            'sender_region'	      => $this->dmsdata['user']['region'],
            'sender_ipadress'	    => $this->input->ip_address(),
            'receiver_divno'      => $mtrns_rcvr['divno'],
            'receiver_secno'      => $mtrns_rcvr['secno'],
            'receiver_id'	        => $mtrns_rcvr['id'],
            'receiver_name'	      => ucwords($mtrns_rcvr['name']),
            'receiver_region'	    => $mtrns_rcvr['region'],
            'type'                => $post['type'],
            'status'              => $post['status'],
            'status_description'	=> $data['stat_dsc'],
            'action_taken'        => $post['action'],
            'remarks'             => $mtrns_rcvr['remarks'],
            'date_in'             => $this->_is_empty($pinfo['er_translog']['date_in'], $data['date_in']),
            'date_out'            => $data['date_out'],
          );
          $mtrnslog_insert = $this->Embismodel->insertdata( 'er_transactions_log', $ins_mtrns_etrlog );
          // $update_er_translog FAILED
          if(!$mtrnslog_insert){ $this->_alert($query_fail['alert_data'], $query_fail['redirect'], '[M-INS-ETRLOG]'); exit; }

          $ins_mtrns_etrans = array(
            'trans_no'            => $data['trans_no'],
            'token'               => $data['trnsctn'][0]['token'],
            'main_route_order'    => $data['trnsctn_log'][0]['route_order'],
            'route_order'	        => 1,
            'multiprc'	          => 0,
            'main_multi_cntr'	    => trim($this->_is_empty($data['main_multi_cntr'], $data['multi_cntr'], '-'.$data['multi_cntr'])),
            'multi_cntr'          => $key+1,
            'company_token'       => $post['company'],
            'company_name'        => $pinfo['company'][0]['company_name'],
            'emb_id'              => $pinfo['company'][0]['emb_id'],
            'subject'	            => $post['subject'],
            'system'              => $data['trnsctn'][0]['system'],
            'type'                => $post['type'],
            'type_description'    => $pinfo['type'][0]['name'],
            'status'              => $post['status'],
            'status_description'	=> $data['stat_dsc'],
            'receive'             => 0,
            'sender_id'	          => $this->dmsdata['user']['token'],
            'sender_name'	        => ucwords($data['snder']),
            'receiver_division'   => $mtrns_rcvr['divno'],
            'receiver_section'    => $mtrns_rcvr['secno'],
            'receiver_region'	    => $mtrns_rcvr['region'],
            'receiver_id'	        => $mtrns_rcvr['id'],
            'receiver_name'	      => ucwords($mtrns_rcvr['name']),
            'action_taken'        => $post['action'],
            'remarks'             => $mtrns_rcvr['remarks'],
            'start_date'          => $data['trnsctn'][0]['start_date'],
            'records_location'    => $data['records_location'],
            // 'qr_code_token'       => $data['qr_code_token'],
            'courier_type'        => $data['courier_type'],
            'tracking_no'         => $data['tracking_no'],
            // 'tag_doc_type'        => $data['tag_doc_type'],
            'region'              => $data['trnsctn'][0]['region'],
            // 'end_date'=>,
            // 'rec_by'=>,
            // 'migrated'=>,
          );
          $mtransmult_insert = $this->Embismodel->insertdata( 'er_transactions_multi', $ins_mtrns_etrans );
          // echo $this->db->last_query(); exit;
          // $update_er_translog FAILED
          if(!$mtransmult_insert){ $this->_alert($query_fail['alert_data'], $query_fail['redirect'], '[M-INS-ETRANS]'); exit; }
        }
      }

      /*---------------------------- UPDATE er_transactions_log etl -THIS ROUTE_ORDER TO CORRESPONDING ROUTE_ORDER ---------------------------------------*/
      // SINGLE - DEFAULT
      $update['er_translog'] = array(
        'subject'	            => trim($post['subject']),
        'sender_divno'        => $this->dmsdata['user']['divno'],
        'sender_secno'        => $this->dmsdata['user']['secno'],
        'sender_name'	        => ucwords($data['snder']),
        'sender_region'	      => $this->dmsdata['user']['region'],
        'sender_ipadress'	    => $this->input->ip_address(),
        'receiver_divno'      => $post['division'],
        'receiver_secno'      => $post['section'],
        'receiver_id'	        => $post['receiver'],
        'receiver_name'	      => ucwords($data['rcver']),
        'receiver_region'	    => $data['region'],
        'type'                => $post['type'],
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
        'company_token'       => $post['company'],
        'company_name'        => $pinfo['company'][0]['company_name'],
        'emb_id'              => $pinfo['company'][0]['emb_id'],
        'subject'	            => $post['subject'],
        'system'              => $data['trnsctn'][0]['system'],
        'type'                => $post['type'],
        'type_description'    => $pinfo['type'][0]['name'],
        'receive'             => 0,
        'sender_id'	          => $this->dmsdata['user']['token'],
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
        'qr_code_token'       => $data['qr_code_token'],
        'courier_type'        => $data['courier_type'],
        'tracking_no'         => $data['tracking_no'],
        'tag_doc_type'        => $data['tag_doc_type'],
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

      $where['er_translog'] = array(
        'trans_no'            => $data['trans_no'],
        // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
        'route_order'	        => $data['trnsctn'][0]['route_order']+1,
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'sender_id'	          => $this->dmsdata['user']['token'],
      );
      $update_er_translog = $this->Embismodel->updatedata( $update['er_translog'], 'er_transactions_log', $where['er_translog'] );
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

      if($result) {
        if(!empty($post['system']) && !empty($post['type'])) {
          // SUBCATEGORIES OF SUBTYPES
          $system_table_check = $this->ersystems_addedtable($data);
          // ERROR / EMPTY RESULT
          // if(!$system_table_check){ $this->_alert($systemtable_fail['alert_data'], $systemtable_fail['redirect']); exit; }
        }
      }
      $prc_success_ova = array(
        'title'     => 'SUCCESS',
        'text'      => '[IIS Reference No.] '.$data['trnsctn'][0]['token'].'<br />Your Transaction has been Successfully Saved.<br />Thank you!',
        'type'      => 'success',
      );

      $this->dmsdata['dms']['options'] = $this->Embismodel->selectdata('acc_options', '*', array('userid' => $this->dmsdata['user']['id']) )[0];

      $custom_redirect = empty($this->dmsdata['dms']['options']['inbox_prc']) ? 'inbox' :
                          $this->dmsdata['dms']['options']['inbox_prc'] == 'all_transactions' ? 'all' :
                          $this->dmsdata['dms']['options']['inbox_prc'] == 'draft'? 'drafts' :
                          $this->dmsdata['dms']['options']['inbox_prc'];

      $this->_alert($prc_success_ova, base_url('dms/documents/'.$custom_redirect), '', 'swal_alert_data');

      redirect( base_url('dms/documents/'.$custom_redirect));
    }

    private function ersystems_addedtable($data="")
    {
        if(!empty($post['appli_type']))
        {
          $where['sub_type'] = array(
            'est.id'      => $post['appli_type'],
            'est.ssysid'  => $post['type']
          );
          $sub_type = $this->Embismodel->selectdata('er_sub_type AS est', '', $where['sub_type'] );
          $subtype_dsc = $sub_type[0]['dsc'];
        }
        else {
          $subtype_dsc = '';
        }

        switch ($post['system']) {
          case 1: // ORD
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_ord AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_ord AS esa',
              'table_ins' => 'er_system_ord',
              'insert'    => array(
                'trans_no'            => $data['trans_no'],
                'sub_system'          => $post['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $post['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_no'],
              )
            );
            break;

          case 2: // ADMINISTRATIVE
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_admin AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_admin AS esa',
              'table_ins' => 'er_system_admin',
              'insert'    => array(
                'trans_no'            => $data['trans_no'],
                'sub_system'          => $post['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $post['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
                ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_no'],
              )
            );
            break;

          case 4: // PERMITTING
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_permit AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'    => 'er_system_permit AS esa',
              'table_ins'   => 'er_system_permit',
              'insert'      => array(
                'trans_no'              => $data['trans_no'],
                'sub_system'            => $post['type'],
                'sub_desc'              => $data['type'][0]['name'],
                'subtype_id'            => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'          => $subtype_dsc,
                'permit_no'             => (!empty($post['permit_no'])) ? $post['permit_no'] : '',
                'consultant_id'         => '',
                'consultant_name'       => '',
                'exp_start_date'        => (!empty($post['exp_start_date'])) ? $post['exp_start_date'] : '0000-00-00',
                'exp_end_date'          => (!empty($post['exp_end_date'])) ? $post['exp_end_date'] : '0000-00-00',
              ),
              'set'         => array(
                'esa.sub_system'        => $post['type'],
                'esa.sub_desc'          => $data['type'][0]['name'],
                'esa.subtype_id'        => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'      => $subtype_dsc,
                'esa.permit_no'         => (!empty($post['permit_no'])) ? $post['permit_no'] : '',
                'esa.consultant_id'     => '',
                'esa.consultant_name'   => '',
                'esa.exp_start_date'    => (!empty($post['exp_start_date'])) ? $post['exp_start_date'] : '0000-00-00',
                'esa.exp_end_date'      => (!empty($post['exp_end_date'])) ? $post['exp_end_date'] : '0000-00-00',
                ),
              'where'       => array(
                'esa.trans_no'          => $data['trans_no'],
              )
            );
            break;

          case 10: // LAB
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_lab AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_lab AS esa',
              'table_ins' => 'er_system_lab',
              'insert'    => array(
                'trans_no'            => $data['trans_no'],
                'sub_system'          => $post['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $post['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_no'],
              )
            );
            break;

          case 11: // EEIU
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_eeiu AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_eeiu AS esa',
              'table_ins' => 'er_system_eeiu',
              'insert'    => array(
                'trans_no'            => $data['trans_no'],
                'sub_system'          => $post['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $post['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_no'],
              )
            );
            break;

          case 12: // RECORDS
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_rec AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_rec AS esa',
              'table_ins' => 'er_system_rec',
              'insert'    => array(
                'trans_no'            => $data['trans_no'],
                'sub_system'          => $post['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
                'type_no'             => (!empty($post['type_no'])) ? trim($post['type_no']) : '',
              ),
              'set'       => array(
                'esa.sub_system'      => $post['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
                'esa.type_no'         => (!empty($post['type_no'])) ? trim($post['type_no']) : '',
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_no'],
              )
            );
            break;

          case 13: // LEGAL
            $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
            $esa = $this->Embismodel->selectdata('er_system_legal AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_legal AS esa',
              'table_ins' => 'er_system_legal',
              'insert'    => array(
                'trans_no'            => $data['trans_no'],
                'sub_system'          => $post['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $post['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_no'],
              )
            );
            break;

          default:
            $esa = '';
            break;
        }

        if(!empty($esa)) {
          $result = $this->Embismodel->updatedata( $esa_vars['set'] , $esa_vars['table_up'], $esa_vars['where'] );
        }
        else {
          $result = $this->Embismodel->insertdata( $esa_vars['table_ins'], $esa_vars['insert'] );
        }

        return $result;
    }

// ----------------------------------------------- OLD ----------------------------------

    private function check_db_connection()
    {
      $this->load->dbutil(); // LOAD DB UTILITY
      if ($this->dbutil->database_exists('database_name')) {
          // some code...
      }
      $result = $this->dbutil->optimize_table('table_name');
      if ($result !== FALSE) {
          print_r($result);
      }
      if ($this->dbutil->repair_table('table_name')) {
          echo 'Success!';
      }
      $query = $this->db->query("SELECT * FROM mytable");
      $delimiter = ",";
      $newline = "\r\n";
      $enclosure = '"';
      echo $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure); // NEEDS FILE HELPER
    }

    private function settings_options($page)
    {
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems', '', '', $this->db->order_by('system_order', 'asc'));
      $this->dmsdata['sub_system'] = $this->Embismodel->selectdata('er_type', '', array('sys_show' => 0));
      $this->load->view('Dms/Settings/'.$page, $this->dmsdata);
      // CUSTOM SETTINGS VIEW
      $this->load->view('Dms/Settings/settings_modal');
      $this->load->view('Dms/Settings/custom_foot');
    }

    function settings_system()
    {
      $loop_success = 0;
      $post_data = $this->input->post();

      switch ($post_data['modal_id']) {
        case 1: // SYSTEMS (ER_SYSTEMS)
          $max_id = $this->Embismodel->selectdata('er_systems', 'MAX(id) max_id', '')[0]['max_id'];
          foreach ($post_data['name'] as $key => $name) {
            if(!empty($name))
            {
              $er_system['ins'] = array(
                'id'           => !empty($max_id) ? $max_id+1 : 1,
                'system_code'  => $post_data['system_code'][$key],
                'name'         => $name,
                'system_order' => !empty($max_id) ? $max_id+1 : 1,
              );
              $er_system['data'] = $this->Embismodel->insertdata('er_systems', $er_system['ins']);
              $result = ($er_system['data']) ? true : false;
            }
          }
          break;
        case 2: // SUB SYSTEMS (ER_TYPE)
          $max_id = $this->Embismodel->selectdata('er_type', 'MAX(id) max_id', '')[0]['max_id'];
          foreach ($post_data['name'] as $key => $name) {
            if(!empty($name) && !empty($post_data['sysid']))
            {
              $er_subsystem['ins'] = array(
                'id'      => !empty($max_id) ? $max_id+1 : 1,
                'name'    => $name,
                'header'  => $post_data['header'][$key],
                'sysid'   => $post_data['sysid'],
                'ssysid'  => $post_data['ssysid'][$key],
              );
              $er_subsystem['data'] = $this->Embismodel->insertdata('er_type', $er_subsystem['ins']);
              $result = ($er_subsystem['data']) ? true : false;
            }
          }
          break;

        default:
          // code...
          break;
      }

      if($result)
      {
        $alert_data = array(
          'title'     => 'Success',
          'text'      => 'Successfully Added New System Data.',
          'type'      => 'success',
        );
        $this->session->set_flashdata('swal_alert_data', $alert_data);
      }
      else {
        $alert_data = array(
          'title'     => 'Error',
          'text'      => 'An error occurred when adding New System Data.',
          'type'      => 'error',
        );
        $this->session->set_flashdata('swal_alert_data', $alert_data);
      }
      redirect(base_url('dms/custom/test/debug/settings/options'));
    }

    function add_trans_company()
    {
      $this->dmsdata['region'] = $this->Embismodel->selectdata('acc_region AS ar', '', '');
      $this->load->view('Dms/func/add_trans_company', $this->dmsdata);
    }

    function acknowledgeLetter()
    {
      if(empty($this->session->userdata('trans_session'))){
        redirect(base_url('Dms/Dms/notfound'));
      }
      else {
        $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

        $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

        // $header_where = array( 'ou.region' =>   $this->dmsdata['trans_data'][0]['region'] );
        $header_where = $this->db->where('ou.region = "'.$this->session->userdata('region').'" AND ou.cnt = (SELECT max(cnt) FROM office_uploads_document_header AS oh WHERE oh.region = "'.$this->session->userdata('region').'")');
        $header = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '', '', $header_where);

        $this->dmsdata['header'] = 'no-header.png';
        if(!empty($header)) {
          $this->dmsdata['header'] = $header[0]['file_name'];
        }

        // $footer_where = array( 'ouf.region' =>   $this->dmsdata['trans_data'][0]['region'] );
        $footer_where = $this->db->where('ouf.region = "'.$this->session->userdata('region').'" AND ouf.cnt = (SELECT max(cnt) FROM office_uploads_document_footer AS of WHERE of.region = "'.$this->session->userdata('region').'")');
        $this->dmsdata['footer'] = $this->Embismodel->selectdata('office_uploads_document_footer AS ouf', '', '', $footer_where);

        $translog_where = array(
          'etl.trans_no'    => $this->dmsdata['trans_session'],
          'etl.route_order' => 1
        );
        $this->dmsdata['trans_log'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $translog_where);

        if($this->dmsdata['trans_data'][0]['route_order'] != 0) {
          $this->load->view('Dms/func/ackno_letter', $this->dmsdata);
        }
        else {
           redirect(base_url('Dms/Dms/notfound'));
        }
      }
    }

    function dispositionForm()
    {
      if(empty($this->session->userdata('trans_session'))){
        redirect(base_url('Dms/Dms/notfound'));
      }
      else {
        $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

        $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

        // $translog_where = array(
        //   'etl.trans_no'    => $this->dmsdata['trans_session']
        // );

        // $this->dmsdata['trans_log'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $translog_where );

        // $header_where = array( 'ou.region' =>   $this->dmsdata['trans_data'][0]['region'] );
        $header_where = $this->db->where('ou.region = "'.$this->session->userdata('region').'" AND ou.cnt = (SELECT max(cnt) FROM office_uploads_document_header AS oh WHERE oh.region = "'.$this->session->userdata('region').'")');
        $header = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '','', $header_where);

        $this->dmsdata['header'] = 'no-header.png';
        if(!empty($header)) {
          $this->dmsdata['header'] = $header[0]['file_name'];
        }

        $this->dmsdata['trans_log'] = $this->db->query('SELECT * FROM er_transactions_log AS etl WHERE etl.trans_no = '.$this->dmsdata['trans_session'].' AND (etl.receiver_id != "" OR etl.type = 84)')->result_array();

        if($this->dmsdata['trans_data'][0]['route_order'] != 0) {
          $this->load->view('Dms/func/dispo_form', $this->dmsdata);
        }
        else {
           redirect(base_url('Dms/Dms/notfound'));
        }
      }
    }

    function dispositionFormBlank()
    {
      if(empty($this->session->userdata('trans_session'))){
        redirect(base_url('Dms/Dms/notfound'));
      }
      else {
        $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

        $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

        $this->dmsdata['trans_log'] = $this->db->query('SELECT * FROM er_transactions_log AS etl WHERE etl.trans_no = '.$this->dmsdata['trans_session'].' AND (etl.receiver_id != "" OR etl.type = 84)')->result_array();

        // $header_where = array( 'ou.region' => $this->dmsdata['trans_data'][0]['region'] );
        $header_where = $this->db->where('ou.region = "'.$this->session->userdata('region').'" AND ou.cnt = (SELECT max(cnt) FROM office_uploads_document_header AS oh WHERE oh.region = "'.$this->session->userdata('region').'")');
        $header = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '', '', $header_where);

        $this->dmsdata['header'] = 'no-header.png';
        if(!empty($header)) {
          $this->dmsdata['header'] = $header[0]['file_name'];
        }

        if($this->dmsdata['trans_data'][0]['route_order'] != 0) {
          $this->load->view('Dms/func/dispo_form_blank', $this->dmsdata);
        }
        else {
           redirect(base_url('Dms/Dms/notfound'));
        }
      }
    }

    // ===========================================        DB STATEMENT FUNCTIONS           =================================================== //

    function add_inputs_tbdb($data='')
    {
      if(!empty($data['post_data']['system']) && !empty($data['post_data']['type']))
      {
        if(!empty($data['post_data']['appli_type']))
        {
          $where['sub_type'] = array(
            'est.id'      => $data['post_data']['appli_type'],
            'est.ssysid'  => $data['post_data']['type']
          );
          $sub_type = $this->Embismodel->selectdata('er_sub_type AS est', '', $where['sub_type'] );
          $subtype_dsc = $sub_type[0]['dsc'];
        }
        else {
          $subtype_dsc = '';
        }

        switch ($data['post_data']['system']) {
          case 1: // ORD
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_ord AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_ord AS esa',
              'table_ins' => 'er_system_ord',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 2: // ADMINISTRATIVE
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_admin AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_admin AS esa',
              'table_ins' => 'er_system_admin',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
                ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 4: // PERMITTING
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_permit AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'    => 'er_system_permit AS esa',
              'table_ins'   => 'er_system_permit',
              'insert'      => array(
                'trans_no'              => $data['trans_session'],
                'sub_system'            => $data['post_data']['type'],
                'sub_desc'              => $data['type'][0]['name'],
                'subtype_id'            => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'          => $subtype_dsc,
                'permit_no'             => (!empty($data['post_data']['permit_no'])) ? $data['post_data']['permit_no'] : '',
                'consultant_id'         => '',
                'consultant_name'       => '',
                'exp_start_date'        => (!empty($data['post_data']['exp_start_date'])) ? $data['post_data']['exp_start_date'] : '0000-00-00',
                'exp_end_date'          => (!empty($data['post_data']['exp_end_date'])) ? $data['post_data']['exp_end_date'] : '0000-00-00',
              ),
              'set'         => array(
                'esa.sub_system'        => $data['post_data']['type'],
                'esa.sub_desc'          => $data['type'][0]['name'],
                'esa.subtype_id'        => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'      => $subtype_dsc,
                'esa.permit_no'         => (!empty($data['post_data']['permit_no'])) ? $data['post_data']['permit_no'] : '',
                'esa.consultant_id'     => '',
                'esa.consultant_name'   => '',
                'esa.exp_start_date'    => (!empty($data['post_data']['exp_start_date'])) ? $data['post_data']['exp_start_date'] : '0000-00-00',
                'esa.exp_end_date'      => (!empty($data['post_data']['exp_end_date'])) ? $data['post_data']['exp_end_date'] : '0000-00-00',
                ),
              'where'       => array(
                'esa.trans_no'          => $data['trans_session'],
              )
            );
            break;

          case 10: // LAB
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_lab AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_lab AS esa',
              'table_ins' => 'er_system_lab',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 11: // EEIU
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_eeiu AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_eeiu AS esa',
              'table_ins' => 'er_system_eeiu',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 12: // RECORDS
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_rec AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_rec AS esa',
              'table_ins' => 'er_system_rec',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
                'type_no'             => (!empty($data['post_data']['type_no'])) ? trim($data['post_data']['type_no']) : '',
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
                'esa.type_no'         => (!empty($data['post_data']['type_no'])) ? trim($data['post_data']['type_no']) : '',
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 13: // LEGAL
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_legal AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_legal AS esa',
              'table_ins' => 'er_system_legal',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          default:
            $esa = '';
            break;
        }

        if(!empty($esa)) {
          $result = $this->Embismodel->updatedata( $esa_vars['set'] , $esa_vars['table_up'], $esa_vars['where'] );
        }
        else {
          $result = $this->Embismodel->insertdata( $esa_vars['table_ins'], $esa_vars['insert'] );
        }
      }
    }

    function delete_transaction()
    {
      if(isset($_POST['delete_trans_btn']))
      {
        $data['post_data'] = $this->input->post('multidlte_trans_no');

        foreach ($data['post_data'] as $key => $value) {
          $trans_vars = array(
            'table' => 'er_transactions AS et',
            'set'   => array( 'et.status'   => 0, ),
            'where' => array( 'et.trans_no' => $value ),
          );
          $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        }

        if(count($data['post_data']) > 1) {
          $trans_no = 'Numbers : ';
          foreach ($data['post_data'] as $key => $value) {
            $trans_no .= $value.', ';
          }
        }
        else {
          $trans_no = 'No. '.$data['post_data'][0];
        }
        if($result)
        {
          $swal_arr = array(
            'title'     => '- Deleted -',
            'text'      => 'IIS '.$trans_no.' deleted successfully.',
            'type'      => 'success',
          );
          $this->session->set_flashdata('swal_arr', $swal_arr);
        }
      }
      else {
        $swal_arr = array(
          'title'     => '- ErRoR -',
          'text'      => 'There was an error upon deletion on DMS - Revisions. Please contact System Administrator.',
          'type'      => 'error',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);
      }
      redirect(base_url('Dms/Dms/revisions'));
    }

    function confidential_transaction()
    {
      if(isset($_POST['confidential_trans_btn']))
      {
        $data['post_data'] = $this->input->post('multiconfidential_trans_no');

        foreach ($data['post_data'] as $key => $value) {

          $confi_trans = array(
            'table'   => 'er_transactions AS et',
            'select'  => 'et.tag_doc_type',
            'where'   => array( 'et.trans_no' => $value ),
          );
          $confi_result = $this->Embismodel->selectdata( $confi_trans['table'], $confi_trans['select'], $confi_trans['where'] );

          $confi_set = ($confi_result[0]['tag_doc_type'] == 0) ? 1 : 0;

          $trans_vars = array(
            'table' => 'er_transactions AS et',
            'set'   => array( 'et.tag_doc_type' => $confi_set ),
            'where' => array( 'et.trans_no' => $value ),
          );
          $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        }

        if(count($data['post_data']) > 1) {
          $trans_no = 'Numbers : ';
          foreach ($data['post_data'] as $key => $value) {
            $trans_no .= $value.', ';
          }
        }
        else {
          $trans_no = 'No. '.$data['post_data'][0];
        }
        if($result)
        {
          $swal_arr = array(
            'title'     => '- SET/UNSET -',
            'text'      => 'IIS '.$trans_no.' set/unset successfully.',
            'type'      => 'success',
          );
          $this->session->set_flashdata('swal_arr', $swal_arr);
        }
      }
      else {
        $swal_arr = array(
          'title'     => '- ErRoR -',
          'text'      => 'There was an error upon deletion on DMS - Revisions. Please contact System Administrator.',
          'type'      => 'error',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);
      }
      redirect(base_url('Dms/Dms/revisions'));
    }

    function update_transrec()
    {
      if(isset($_POST['relocate_transrec']))
      {
        $data['post_data'] = $this->input->post();
        $trans_vars = array(
          'table' => 'er_transactions AS et',
          'set'   => array( 'et.records_location' => $data['post_data']['transrec_location'] ),
          'where' => array( 'et.trans_no'         => $data['post_data']['transrec_no'] ),
        );
        $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        if($result)
        {
          $swal_arr = array(
            'title'     => '- Updated -',
            'text'      => 'Record of IIS No. '.$data['post_data']['transrec_no'].' updated successfully.',
            'type'      => 'success',
          );
          $this->session->set_flashdata('swal_arr', $swal_arr);
        }
      }
      else {
        $swal_arr = array(
          'title'     => '- ErRoR -',
          'text'      => 'There was an error upon updating data in DMS - Records. Please contact System Administrator.',
          'type'      => 'error',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);
      }

        redirect(base_url('Dms/Dms/records'));
    }

    function filter_query()
    {
      $where['fltr_comp'] = ($this->dmsdata['user_region'] == 'CO') ? '' : array( 'dc.region_name' => $this->dmsdata['user_region'] );
      $this->dmsdata['fltr_comp'] = $this->Embismodel->selectdata('dms_company AS dc', 'emb_id, company_id, company_name, establishment_name, token', $where['fltr_comp'], $this->db->order_by('dc.company_name', 'asc'));
      $this->dmsdata['fltr_systm'] = $this->Embismodel->selectdata('er_systems AS esy', '', '', $this->db->order_by('esy.system_order', 'asc'));
      $this->dmsdata['fltr_stat'] = $this->Embismodel->selectdata('er_status AS est', '', '');

      $where['prsnl_cred'] = array('ac.region' => $this->dmsdata['user_region'], 'ac.verified' => 1);
      $this->dmsdata['fltr_prsnl'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['prsnl_cred'] );

      $this->dmsdata['modal'] = 'dms_filter';

      $this->load->view('Dms/func/onclick_modals', $this->dmsdata);
    }

    function multipersonnels()
    {
      $rcvr = $this->input->post('receiver');
      $cnt = 0;
      $data[] = '';
      foreach ($rcvr as $key => $value) {
        if(!empty($value)) {
          foreach ($this->input->post() as $postkey => $postvalue) {
            $data[$cnt][$postkey] = $postvalue[$key];
          }
          $where['multiprsnl'] = array('ac.token' => $value);
          $multiprsnl = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['multiprsnl'] );

          $division = (!empty($multiprsnl[0]['division'])) ? '|'.$multiprsnl[0]['division'] : '';

          $section = '';
          if(!empty($multiprsnl[0]['secno']))
          {
            $sec_where = array( 'axs.secno'  => $multiprsnl[0]['secno'] );
            $section = $this->Embismodel->selectdata('acc_xsect AS axs', '', $sec_where);
            $section = '|'.$section[0]['secode'];
          }

          $data[$cnt]['name'] = trim(ucwords($multiprsnl[0]['fname'].' '.substr($multiprsnl[0]['mname'], 0, 1).' '.$multiprsnl[0]['sname'].' '.$multiprsnl[0]['suffix']));
          $data[$cnt]['prsnl'] = trim(ucwords($multiprsnl[0]['fname'].' '.$multiprsnl[0]['sname'].' '.$multiprsnl[0]['suffix']).' - '.$multiprsnl[0]['region'].$division.$section);
          $cnt++;
        }
      }
      echo json_encode($data);
    }

    // ====================================================        COMMON METHODS           =========================================================== //


    private function assigned_slctn()
    {
      $reg_type = (!empty($this->dmsdata['trans_data'][0]['receiver_region'])) ? $this->dmsdata['trans_data'][0]['receiver_region'] : $this->dmsdata['user_region'];

      $reg_type = ($reg_type == 'CO') ? 'co' : 'region';
      // $div_where = array('adv.type' => $reg_type, 'adv.office' =>'EMB' );
      $div_where = $this->db->where('adv.office = "'.$this->session->userdata('office').'" AND (adv.type = "'.$reg_type.'" OR adv.type = "'.$this->session->userdata('region').'")');
      // if($this->dmsdata['function'][0]['func'] == 'Administrator') {
      //   $div_where = array('adv.type' => $reg_type );
      // }
      // else {
      //   $div_where = array(
      //     'adv.type'  => $reg_type,
      //     'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //   );
      // }


      // switch ($this->dmsdata['function'][0]['func']) {
      //   case 'Administrator':
      //   case 'Sample User':
      //     $div_where = array('adv.type' => $reg_type );
      //     break;

      //   case 'Director':
      //   case 'Assistant Director':
      //     $div_where = array('adv.type' => $reg_type );
      //     break;

      //   case 'Division Chief':
      //   case 'Assistant Division Chief':
      //     $div_where = array('adv.type' => $reg_type );
      //     break;

      //   case 'Section Chief':
      //     $div_where = array(
      //       'adv.type'  => $reg_type,
      //       'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //     );
      //     break;

      //   default:
      //     if(!empty($this->dmsdata['credentials'][0]['secno']))
      //     {
      //       if($this->dmsdata['user_region'] == 'CO')
      //       {
      //         switch ($this->dmsdata['credentials'][0]['divno']) {
      //           case 14: // OFFICE OF THE DIRECTOR
      //             $div_where = array('adv.type' => $reg_type );
      //             break;

      //           default:
      //             $div_where = array(
      //               'adv.type'  => $reg_type,
      //               'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //             );
      //             break;
      //         }
      //       }
      //       else {
      //         switch ($this->dmsdata['credentials'][0]['divno']) {
      //           case 1: // OFFICE OF THE REGIONAL DIRECTOR
      //             $div_where = array('adv.type' => $reg_type );
      //             break;

      //           default:
      //             $div_where = array(
      //               'adv.type'  => $reg_type,
      //               'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //             );
      //             break;
      //         }
      //       }
      //     }
      //     else {
      //       $div_where = array(
      //         'adv.type'  => $reg_type,
      //         'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //       );
      //     }
      //     break;
      // }

      $this->dmsdata['division'] = $this->Embismodel->selectdata('acc_xdvsion AS adv', '', '', $div_where);
      // print_r($this->dmsdata['division']); exit;
      // }
    }

    private function add_inputs()
    {
      if(!empty($this->dmsdata['trans_data'][0]['type']))
      {
        $est_vars = '';
        switch ($this->dmsdata['trans_data'][0]['system']) {
          case 1: $est_vars = array( 'table' => 'er_system_ord AS est' ); break; // ORD
          case 2: $est_vars = array( 'table' => 'er_system_admin AS est' ); break; // ADMINISTRATIVE
          case 3: $est_vars = array( 'table' => 'er_system_finance AS est' ); break; // FINANCIAL
          case 4: $est_vars = array( 'table' => 'er_system_permit AS est' ); break; // PERMITTING
          case 12: $est_vars = array( 'table' => 'er_system_rec AS est' ); break; // RECORDS
          case 13: $est_vars = array( 'table' => 'er_system_legal AS est' ); break; // RECORDS
          default: $est_vars = array( 'table' => '' ); break; // DEFAULT
        }

        if(!empty($est_vars['table']))
        {
          $est_vars += array(
            'where' => array( 'est.trans_no' => $this->dmsdata['trans_session'] )
          );
          $this->dmsdata['system_types'] = $this->Embismodel->selectdata($est_vars['table'], '', $est_vars['where']);

          $est_vars['where'] = array( 'est.ssysid'  => $this->dmsdata['system_types'][0]['sub_system'] );
          $this->dmsdata['sub_types'] = $this->Embismodel->selectdata('er_sub_type AS est', '', $est_vars['where']);
        }

        return $this->load->view('Dms/func/updateinputs', $this->dmsdata, TRUE);
      }
    }

    function attachment_exists($route)
    {
        $data = array(
          'entry'           => $this->uri->segment(4),
          'trans_no'        => $this->uri->segment(5),
          'main_multi_cntr' => $this->uri->segment(6),
          'multi_cntr'      => $this->uri->segment(7),
        );

      if(!empty($this->dmsdata['atchx_rt']))
      {
        $ea_where = array(
          'ea.trans_no'         => $data['trans_no'],
          'ea.route_order'      => $this->dmsdata['atchx_rt']+1,
          'ea.main_multi_cntr'  => $data['entry']!=1?$data['main_multi_cntr']:'',
          'ea.multi_cntr'       => $data['multi_cntr'],
        );
      }
      else {
        $ea_where = array(
          'ea.trans_no'         => $data['trans_no'],
          'ea.route_order'      => $this->dmsdata['atchx_rt']+1,
          'ea.main_multi_cntr'  => $data['entry']!=1?$data['main_multi_cntr']:'',
          'ea.deleted'          => 0,
        );
      }
      $ea_slct = $this->Embismodel->selectdata( 'er_attachments AS ea', '', $ea_where );


              // if($this->dmsdata['user']['token'] == '515e12d4a186a84')
              // {
              //   echo $this->db->last_query(); exit;
              // }

      // if($route_order == 1) {
        if(!$ea_slct) {
          return false;
        }
        else {
          return true;
        }
      // }
      // else {
      //   return true;
      // }
    }

    function ajax_attachment_exists()
    {
      echo 'true';
    }

    // ============================================        AJAX FUNCTIONS           ===================================================== //

    function additional_inputs()
    {
      $data = $this->input->post();

      $type_where = array( 'et.id' => $data['subsystem'] );
      $data['type'] = $this->Embismodel->selectdata('er_type AS et', '', $type_where);

      if($data['system'] == 6)
      {
        $subtype_vars = array(
          'table' => 'er_sub_swm AS ess',
          'where' => array( 'ess.ssysid'  => $data['subsystem'] ),
          'order' => 'ess.ssysid asc',
        );
      }
      else {
        $subtype_vars = array(
          'table' => 'er_sub_type AS est',
          'where' => array(
            'est.sysid'   => $data['system'],
            'est.ssysid'  => $data['subsystem']
          ),
          'order' => 'est.sysid asc, est.ssysid asc',
        );
      }

      $data['sub_types'] = $this->Embismodel->selectdata( $subtype_vars['table'], '', $subtype_vars['where'], $subtype_vars['order'] );

      $this->load->view('Dms/func/addinputs', $data);
    }

    function view_transaction()
    {
      $this->dmsdata['post_data'] = $this->input->post();

      // query of transaction's data (single)
      // !empty($this->dmsdata['post_data']['multiprc']) &&
      if($this->dmsdata['post_data']['multiprc'] > 0) {
        $trans_where = array(
          'etm.trans_no'     => $this->dmsdata['post_data']['trans_no'],
          'etm.receiver_id'  => $this->dmsdata['user_token'],
        );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions_multi AS etm', '', $trans_where);
      }
      else {
        $trans_where = array( 'et.trans_no' => $this->dmsdata['post_data']['trans_no'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);
      }

      // query of system
      $type_where = array('es.id' => $this->dmsdata['trans_data'][0]['system'] );
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS es', '', $type_where);

      // query of company details
      $dcomp_where = array( 'dcd.token' => $this->dmsdata['trans_data'][0]['company_token'] );
      $this->dmsdata['company_details'] = $this->Embismodel->selectdata('dms_company AS dcd', '', $dcomp_where);

      $this->dmsdata['prepAddr'] = str_replace(' ', '+', $this->dmsdata['company_details'][0]['company_name']);
      $this->dmsdata['prepAddr'] .= '+'.str_replace(' ', '+', $this->dmsdata['company_details'][0]['city_name'].'+'.$this->dmsdata['company_details'][0]['province_name']);

      $this->dmsdata['geocode'] = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$this->dmsdata['prepAddr'].'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');

      $this->dmsdata['geocode'] = json_decode($this->dmsdata['geocode']);

      // query of transaction's data (multiple)
      $trans_where = array( 'etrns.trans_no' => $this->dmsdata['post_data']['trans_no'] );
      $this->dmsdata['trans_multi'] = $this->Embismodel->selectdata('er_transactions_multi AS etrns', '', $trans_where);

      // checks personnel if he/she is in the this transaction's log
      $where['inthread'] = $this->db->where('etl.trans_no = "'.$this->dmsdata['post_data']['trans_no'].'" AND ( etl.sender_id = "'.$this->dmsdata['user_token'].'" OR etl.receiver_id =  "'.$this->dmsdata['user_token'].'" )');
      $this->dmsdata['prnl_inthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['inthread'] );

      $this->dmsdata['special_view'] = FALSE;
      //special viewing (mon.rep, eia, haz, chem)
      if( $this->dmsdata['trans_data'][0]['type'] == 23 && $this->dmsdata['user_rights']['view_monitoring_report'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      if( in_array($this->dmsdata['trans_data'][0]['type'], array(1, 2,3,74)) && $this->dmsdata['user_rights']['view_eia'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      if( in_array($this->dmsdata['trans_data'][0]['type'], array(7,8,9,10,76)) && $this->dmsdata['user_rights']['view_chem'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      if( in_array($this->dmsdata['trans_data'][0]['type'], array(6,32,33,34,47,48,77,98,105,112,113)) && $this->dmsdata['user_rights']['view_haz'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      // if( in_array($this->dmsdata['trans_data'][0]['type'], array(4,5,27,75)) && $this->dmsdata['user_rights']['view_airwater'] == 'yes')
      // {
      //  $this->dmsdata['special_view'] = TRUE;
      // }

      // query of transaction's log
      $history_where = array(
        'etl.trans_no'          => $this->dmsdata['post_data']['trans_no'],
        'etl.main_multi_cntr'   => '',
       );
      $history_order = $this->db->order_by('etl.main_route_order ASC, etl.route_order ASC, etl.multi_cntr ASC');
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );
      // query of attachments
      foreach ($this->dmsdata['trans_history'] as $key => $value) {
        $ea_where = array(
          'eat.trans_no'    => $value['trans_no'],
          'eat.route_order' => $value['route_order'],
          'eat.deleted'      => 0,
        );
        $ea_order = $this->db->order_by('eat.route_order', 'desc');
        $this->dmsdata['attachment_view'][$key] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where, $ea_order );

        $from_name['axd_where'] = array( 'axd.divno' => $value['sender_divno'] );
        $from_name['div'] = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $from_name['axd_where'] );
        $from_div = (!empty($from_name['div'])) ?  $from_name['div'][0]['divcode'] : '';

        $from_name['axs_where'] = array( 'axs.secno' => $value['sender_secno'] );
        $from_name['sec'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $from_name['axs_where'] );
        $from_sec = (!empty($from_name['sec'])) ? '|'.$from_name['sec'][0]['secode'] : '';

        $this->dmsdata['from_name'][$key] = $from_div.$from_sec.' - ';

        $receiver_name['axd_where'] = array( 'axd.divno' => $value['receiver_divno'] );
        $receiver_name['div'] = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $receiver_name['axd_where'] );
        $receiver_div = (!empty($receiver_name['div'])) ?  $receiver_name['div'][0]['divcode'] : '';

        $receiver_name['axs_where'] = array( 'axs.secno' => $value['receiver_secno'] );
        $receiver_name['sec'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $receiver_name['axs_where'] );
        $receiver_sec = (!empty($receiver_name['sec'])) ? '|'.$receiver_name['sec'][0]['secode'] : '';

        $this->dmsdata['receiver_name'][$key] = $receiver_div.$receiver_sec.' - ';

        if($value['multiprc'] > 0)
        {
          $where['etml'] = array(
            'etml.trans_no'           => $value['trans_no'],
            'etml.main_route_order'   => $value['route_order'],
            'etml.route_order'        => 1,
            'etml.main_multi_cntr'    => $value['multi_cntr'],
          );
          $this->dmsdata['multitrans_histo'] = $this->Embismodel->selectdata('er_transactions_log AS etml', '', $where['etml'] );
        }
      }

      $this->load->view('Dms/func/view_transaction', $this->dmsdata);
    }

    //balhin rah unya
    function multitrans_history()
    {
      $mt_order = explode('_', $this->input->post('multitrans'));

      $trans_where = array( 'etm.trans_no' => $mt_order[1], );
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions_multi AS etm', '', $trans_where);

      $data = array(
        'trans_no'          => $mt_order[1],
        'main_route_order'  => $mt_order[2],
        'main_multi_cntr'   => $mt_order[3],
        'multi_cntr'        => $mt_order[4],
      );
      // query of transaction's log
      $history_where = array(
        'etl.trans_no'          => $data['trans_no'],
        'etl.main_route_order'  => $data['main_route_order'],
        'etl.main_multi_cntr'   => $data['main_multi_cntr'],
        'etl.multi_cntr'        => $data['multi_cntr'],
      );
      $history_order = $this->db->order_by('etl.route_order ASC, etl.multiprc ASC');
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );

      $where['inthread'] = $this->db->where('etl.trans_no = "'.$data['trans_no'].'" AND etl.main_multi_cntr = "'.$data['main_multi_cntr'].'" AND etl.multi_cntr = "'.$data['multi_cntr'].'" AND ( etl.sender_id = "'.$this->dmsdata['user_token'].'" OR etl.receiver_id =  "'.$this->dmsdata['user_token'].'" )');

      $this->dmsdata['prnl_inthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['inthread'] );

      $where['onlowerthread'] = $this->db->where('etl.trans_no = "'.$data['trans_no'].'" AND ( etl.sender_id = "'.$this->dmsdata['user_token'].'" OR etl.receiver_id =  "'.$this->dmsdata['user_token'].'" )');
      $this->dmsdata['onlowerthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['onlowerthread'] );

      // CHECK IF USER IS UNDER THIS MULTIPLE ROUTE ROW
      $this->dmsdata['prnl_onlowerthread'] = '';

      $muti_histo_mmccheck = mb_strlen($data['main_multi_cntr'], 'UTF-8');
      foreach ($this->dmsdata['onlowerthread'] as $key => $value)
      {
        $onlowerthread_mmccheck = substr($value['main_multi_cntr'], 0, $muti_histo_mmccheck);

        if($data['main_multi_cntr'] == $onlowerthread_mmccheck && $value['main_multi_cntr'][$muti_histo_mmccheck+1] == $data['multi_cntr'])
        {
          $this->dmsdata['prnl_onlowerthread']=1;
          break;
        }
      }


      $x_mcnt = explode('-', $mt_order[3]);
      $x_mcntr = '';
      $i=1;

      while($i < count($x_mcnt)) {
        $x_mcntr .= $x_mcnt[$i];
        if($i+1 < count($x_mcnt)) {
          $x_mcntr .= '-';
        }
        $i++;
      }

      // query of attachments
      foreach ($this->dmsdata['trans_history'] as $key => $value) {

        $from_name['axd_where'] = array( 'axd.divno' => $value['sender_divno'] );
        $from_name['div'] = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $from_name['axd_where'] );
        $from_div = (!empty($from_name['div'])) ?  $from_name['div'][0]['divcode'] : '';

        $from_name['axs_where'] = array( 'axs.secno' => $value['sender_secno'] );
        $from_name['sec'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $from_name['axs_where'] );
        $from_sec = (!empty($from_name['sec'])) ? '|'.$from_name['sec'][0]['secode'] : '';

        $this->dmsdata['from_name'][$key] = $from_div.$from_sec.' - ';

        $receiver_name['axd_where'] = array( 'axd.divno' => $value['receiver_divno'] );
        $receiver_name['div'] = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $receiver_name['axd_where'] );
        $receiver_div = (!empty($receiver_name['div'])) ?  $receiver_name['div'][0]['divcode'] : '';

        $receiver_name['axs_where'] = array( 'axs.secno' => $value['receiver_secno'] );
        $receiver_name['sec'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $receiver_name['axs_where'] );
        $receiver_sec = (!empty($receiver_name['sec'])) ? '|'.$receiver_name['sec'][0]['secode'] : '';

        $this->dmsdata['receiver_name'][$key] = $receiver_div.$receiver_sec.' - ';

        if($key == 0)
        {
          $etm_hist_0_where = array(
            'eat.trans_no'          => $data['trans_no'],
            'eat.route_order'       => $data['main_route_order'],
            'eat.main_multi_cntr'   => $x_mcntr,
            'eat.multi_cntr'        => $x_mcnt[$i-1],
            'eat.deleted'           => 0,
          );
          $etm_hist_0_order = $this->db->order_by(' eat.route_order desc, eat.file_id desc');
          $this->dmsdata['attachment_view'][0] = $this->Embismodel->selectdata('er_attachments AS eat', '', $etm_hist_0_where, $etm_hist_0_order );
        }
        else {
          $ea_where = array(
            'eat.trans_no'          => $value['trans_no'],
            // 'eat.main_route_order'  => $data['main_route_order'], // UNCOMMENT IF NAGKAKA.ANO NA NAMN
            'eat.route_order'       => $value['route_order'],
            'eat.main_multi_cntr'   => $data['main_multi_cntr'],
            'eat.multi_cntr'        => $data['multi_cntr'],
            'eat.deleted'           => 0,
          );
          $ea_order = $this->db->order_by(' eat.route_order desc, eat.file_id desc');
          $this->dmsdata['attachment_view'][$key] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where, $ea_order );
        }

        if($value['multiprc'] > 0)
        {
          $where['etml'] = array(
            'etml.trans_no'           => $value['trans_no'],
            'etml.main_route_order'   => $value['route_order'],
            'etml.route_order'        => 1,
            'etml.main_multi_cntr'    => (!empty($value['main_multi_cntr'])) ? $value['main_multi_cntr'].'-'.$value['multi_cntr'] : $value['multi_cntr'],
          );
          $this->dmsdata['multitrans_histo'] = $this->Embismodel->selectdata('er_transactions_log AS etml', '', $where['etml'] );

        }
      }
      $this->load->view('Dms/func/multitrans_view', $this->dmsdata);
    }

    private function receive_transaction()
    {
      $data =  array(
        'trans_no'      => $this->input->post('trans_no'),
        'multiprc'      => $this->input->post('multiprc'),
        'region'        => $this->session->userdata('region'),
        'sender_divno'  => $this->dmsdata['user_func']['divno'],
        'sender_secno'  => $this->dmsdata['user_func']['secno'],
        'sender_id'     => $this->session->userdata('token'),
        'date_in'       => date('Y-m-d H:i:s'),
      );

      if(!empty($data['multiprc'])) {
        $table['trnsctn'] = 'er_transactions_multi AS etrns';
      }
      else {
        $table['trnsctn'] = 'er_transactions AS etrns';
      }

      $where['trnsctn'] = array(
        'etrns.trans_no'     => $data['trans_no'],
        'etrns.receiver_id'  => $data['sender_id'],
      );
      $res['trnsctn'] = $this->Embismodel->selectdata($table['trnsctn'], '', $where['trnsctn'] );

      $acsender_where = array('ac.token' => $data['sender_id'] );
      $res['sndr'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acsender_where );

      $mname = (!empty($res['sndr'][0]['mname']) ) ? ' '.$res['sndr'][0]['mname'][0].'. ' : ' ';
      $suffix = (!empty($res['sndr'][0]['suffix']) ) ? ' '.$res['sndr'][0]['suffix'] : '';

      $sender = $res['sndr'][0]['fname'].$mname.$res['sndr'][0]['sname'].$suffix;

      // CHECK IF TRANSACTION ALREADY RECEIVED BY USER
      $where['etl_check'] = array(
        'etl.trans_no'          => $this->input->post('trans_no'),
        'etl.main_route_order'  => !empty($res['trnsctn'][0]['main_route_order']) ? $res['trnsctn'][0]['main_route_order'] : '',
        'etl.route_order'       => $res['trnsctn'][0]['route_order']+1,
        'etl.main_multi_cntr'   => !empty($res['trnsctn'][0]['main_multi_cntr']) ? $res['trnsctn'][0]['main_multi_cntr'] : '',
        'etl.multi_cntr'        => !empty($res['trnsctn'][0]['multi_cntr']) ? $res['trnsctn'][0]['multi_cntr'] : 1, // default is 1
        'etl.multiprc'          => $this->input->post('multiprc'),
        'etl.sender_id'         => $data['sender_id'],
      );
      $res['etl_check'] = $this->Embismodel->selectdata('er_transactions_log etl', '', $where['etl_check'] );

      if(empty($res['etl_check']))
      {
        $trans_log_insert = array(
          'trans_no'          => $res['trnsctn'][0]['trans_no'],
          'main_route_order'  => !empty($res['trnsctn'][0]['main_route_order']) ? $res['trnsctn'][0]['main_route_order'] : '',
          'route_order'       => $res['trnsctn'][0]['route_order']+1,
          'multiprc'          => 0,
          'main_multi_cntr'   => !empty($res['trnsctn'][0]['main_multi_cntr']) ? $res['trnsctn'][0]['main_multi_cntr'] : '',
          'multi_cntr'        => !empty($res['trnsctn'][0]['multi_cntr']) ? $res['trnsctn'][0]['multi_cntr'] : 1, // default is 1
          'sender_divno'      => $data['sender_divno'],
          'sender_secno'      => $data['sender_secno'],
          'sender_id'         => $data['sender_id'],
          'sender_name'       => $sender,
          'sender_ipadress'   => $this->input->ip_address(),
          'sender_region'     => $this->dmsdata['user_region'],
          'date_in'           => $data['date_in'],
        );
        $result = $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

        if($result)
        {
          $set['trnsctn'] = array( 'etrns.receive' => 1, );
          if(!empty($data['multiprc']))
          {
            $where['trnsctn'] = array(
              'etrns.trans_no'          => $data['trans_no'],
              'etrns.receiver_id'       => $data['sender_id'],
              'etrns.main_route_order'  => !empty($res['trnsctn'][0]['main_route_order']) ? $res['trnsctn'][0]['main_route_order'] : '',
              'etrns.route_order'       => $res['trnsctn'][0]['route_order'],
              'etrns.multiprc'          => 0,
              'etrns.main_multi_cntr'   => !empty($res['trnsctn'][0]['main_multi_cntr']) ? $res['trnsctn'][0]['main_multi_cntr'] : '',
              'etrns.multi_cntr'        => $res['trnsctn'][0]['multi_cntr'], // default is 1
            );
          }
          else {
            $where['trnsctn'] = array(
              'etrns.trans_no'    => $data['trans_no'],
              'etrns.receiver_id' => $data['sender_id'],
            );
          }
          $result = $this->Embismodel->updatedata( $set['trnsctn'], $table['trnsctn'], $where['trnsctn'] );
        }
      }
      else {
        $result = true;
      }

      if($result)
      {
        $res['error'] = 0;
        $res['site'] = base_url('Dms/Dms/inbox');
      }

      echo json_encode($res);
    }

    // File upload
    function fileUpload()
    {
      // TRANSACTION COUNTER
      $this->dmsdata['cnt'] = (!empty($this->dmsdata['cnt'])) ? $this->dmsdata['cnt']++ : 1;
      $data = array(
        'user_token'        => $this->dmsdata['user_token'],
        'trans_region'      => $this->input->post('region'),
        'trans_session'     => $this->input->post('trans_session'),
        'main_route_order'  => !empty($this->input->post('main_route_order')) ? trim($this->input->post('main_route_order')) : '',
        'route_order'       => $this->input->post('route_order')+1,
        // 'main_multi_cntr'   => !empty($this->input->post('main_multi_cntr')) ? trim($this->input->post('main_multi_cntr')) : '',
        'main_multi_cntr'   => !empty($this->session->userdata('main_multi_cntr')) ? trim($this->session->userdata('main_multi_cntr')) : '',
        'multi_cntr'        => !empty($this->session->userdata('multi_cntr')) ? $this->session->userdata('multi_cntr') : 1,
      );

      $path = 'dms/'.date('Y').'/'.$data['trans_region'].'/';
      $folder = $data['trans_session'];

      if(!is_dir('uploads/'.$path.'/'.$folder)) {
        mkdir('uploads/'.$path.'/'.$folder, 0777, TRUE);
      }
      // else {
      //
      // }

      $mcntr = '';
      $m_addpath = '';

      if(!empty($data['main_multi_cntr']))
      {
        // make folder for sub/branch trans_no
        // $m_cnt = explode('-', $data['main_multi_cntr']);
        // for ($i=0; $i < count($m_cnt); $i++) {
        //   $m_addpath .= $m_cnt[$i];
        //   if($i < count($m_cnt)-1) {
        //     $m_addpath .= '/';
        //   }
        // }

        // if(!is_dir('uploads/'.$path.'/'.$folder.'/'.$m_addpath)) {
        //   mkdir('uploads/'.$path.'/'.$folder.'/'.$m_addpath, 0777, TRUE);
        // }
        // rename and include mcntr to new attachment name
        // multiple user routing file coding
        $mcntr = '-RC'.$data['main_route_order'].'MC'.$data['main_multi_cntr'].'-'.$data['multi_cntr'];
      }

      $region_where = array('ar.rgnnum' => $data['trans_region'] );
      $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

      $trans_where = array('et.trans_no' => $data['trans_session'] );
      $trans_data = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where );
      $date = date('Y', strtotime($trans_data[0]['start_date']));

      $att_token1 = fmod($data['trans_session'], 1000000);

      // select,insert, update and delete queries from er_attachments db must include multi_cntr
      $ea_w = array(
        'ea.trans_no'           => $data['trans_session'],
        'ea.main_route_order'   => $data['main_route_order'],
        'ea.route_order'        => $data['route_order'],
        'ea.main_multi_cntr'    => $data['main_multi_cntr'],
        'ea.multi_cntr'         => $data['multi_cntr'],
        'ea.deleted'            => 0,
      );
      $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);
      // total file coding
      $att_token = $data['trans_region'].$date.$mcntr.'-FT'.$data['route_order'].'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);

      if(!empty($_FILES['file']['name'])) {
        // Set preference
        $config = array(
          'upload_path'   => 'uploads/'.$path.'/'.$folder, // .'/'.$m_addpath
          'allowed_types' => '*',
          'max_size'      => '20480', // max_size in kb
          'file_name'     => $att_token,
          'overwrite'     => FALSE,
        );
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if(!$this->upload->do_upload('file')) {
          // Show error on uploading
          $uploadError = array('error' => $this->upload->display_errors());
        }
        else {
          // Get data about the file
          $uploadData = $this->upload->data();
          $erattach_insert = array(
            'trans_no'          => $data['trans_session'],
            'main_route_order'  => $data['main_route_order'],
            'route_order'       => $data['route_order'],
            'main_multi_cntr'   => $data['main_multi_cntr'],
            'multi_cntr'        => $data['multi_cntr'],
            'file_id'           => $ea_q[0]['max_fileid']+1, // order_by
            'token'             => $att_token,
            'file_name'         => $_FILES['file']['name'],
          );
          $this->Embismodel->insertdata('er_attachments', $erattach_insert);
        }
      }
    }

    // File Delete
    function fileDelete()
    {
      $error = 1;
      // TRANSACTION COUNTER
      $this->dmsdata['cnt'] = (!empty($this->dmsdata['cnt'])) ? $this->dmsdata['cnt']++ : 1;
      $data = array(
        'user_token'        => $this->dmsdata['user_token'],
        'trans_region'      => $this->input->post('region'),
        'trans_session'     => $this->input->post('trans_session'),
        'main_route_order'  => !empty($this->input->post('main_route_order')) ? trim($this->input->post('main_route_order')) : '',
        'route_order'       => $this->input->post('route_order')+1,
        'main_multi_cntr'   => !empty($this->input->post('main_multi_cntr')) ? trim($this->input->post('main_multi_cntr')) : '',
        'multi_cntr'        => !empty($this->input->post('multi_cntr')) ? $this->input->post('multi_cntr') : 1,
        'file_name'         => $this->input->post('file_name'),
        'file_token'        => $this->input->post('file_token'),
      );

      $where = array( 'et.trans_no' => $data['trans_session'] );
      $et_query = $this->Embismodel->selectdata('er_transactions AS et', '', $where);

      // echo "<pre>"; print_r($data);

      $path = 'dms/'.date('Y', strtotime($et_query[0]['start_date'])).'/'.$et_query[0]['region'];
      $folder = $data['trans_session'];

      $whole_path = 'uploads/'.$path.'/'.$folder.'/'.$data['file_token'].'.'.pathinfo($data['file_name'], PATHINFO_EXTENSION);
      // echo $whole_path;
      if(!empty($data['file_token']))
      {
        // chown($whole_path, 777);

        if (unlink($whole_path)) {
            echo 'success';

            // $ea_w = array(
            //   'trans_no'           => $data['trans_session'],
            //   'main_route_order'   => $data['main_route_order'],
            //   'route_order'        => $data['route_order'],
            //   'main_multi_cntr'    => $data['main_multi_cntr'],
            //   'multi_cntr'         => $data['multi_cntr'],
            //   'file_name'          => $data['file_name'],
            //   'token'              => $data['file_token'],
            // );
            // $ea_q = $this->Embismodel->deletedata('er_attachments', $ea_w);

            $ea_set = array(
              'deleted'           => 1,
            );
            $ea_w = array(
              'trans_no'           => $data['trans_session'],
              'main_route_order'   => $data['main_route_order'],
              'route_order'        => $data['route_order'],
              'main_multi_cntr'    => $data['main_multi_cntr'],
              'multi_cntr'         => $data['multi_cntr'],
              'file_name'          => $data['file_name'],
              'token'              => $data['file_token'],
            );
            $ea_q = $this->Embismodel->updatedata( $ea_set, 'er_attachments', $ea_w);

            if($ea_q) {
              echo 'delete success';
            }
            else  {
              echo 'delete failed';
            }

        } else {
            echo 'fail';
            $error = 0;
        }
      }
      return json_encode($error);
    }

    function transtable_filter()
    {
      $data['site'] = 'all_transactions';
      if($this->input->post('type') == 'filter') {
        $data['filter'] = array(
          'fltr_comp' => (!empty($this->input->post('filter_company'))) ? $this->input->post('filter_company') : '',
          'fltr_type' => (!empty($this->input->post('filter_transtype'))) ? $this->input->post('filter_transtype') : '',
          'fltr_stat' => (!empty($this->input->post('filter_status'))) ? $this->input->post('filter_status') : '',
        );
      }
      else {
        $data['filter'] = '';
      }

      $this->session->set_userdata( 'trans_filter', $data['filter']);
      echo json_encode($data);
    }

    function trans_qrcode()
    {
      $trans_stat = $this->input->post('trns_stat',TRUE);
      $token      = $this->encrypt->decode($this->input->post('token',TRUE));
      if(($this->session->userdata('trans_qrcode') == 'yes' OR $this->session->userdata('superadmin_rights') == 'yes')){
        $wheretrans    = $this->db->where('et.token = "'.$token.'"');
        $selecttrans   = $this->Embismodel->selectdata('er_transactions AS et','et.qr_code_token','',$wheretrans);
        $random        = str_split('QWERTYUIOP12345678'); shuffle($random);
        $randomkey     = array_slice($random, 0, 18);
        $key = implode('', $randomkey);
        $paded = str_pad($key, 18, '0', STR_PAD_LEFT);
        $delimited = '';
        if(empty($selecttrans[0]['qr_code_token'])){
          for($i = 0; $i < 18; $i++) {
           $delimited .= $paded[$i];
           if($i == 2 || $i == 5 || $i == 8 || $i == 11 || $i == 14) {
               $delimited .= '-';
           }
          }
        }else{
          $delimited = $selecttrans[0]['qr_code_token'];
        }
        echo "<label>Please copy and paste QR Code into the document to be routed:</label><br>";
        echo "<input type='hidden' class='form-control' name='qr_code' value='".$delimited."' readonly>";
        echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fiis.emb.gov.ph/verify?token=".$delimited."%2F&choe=UTF-8' style='width:150px;'>";
      }
    }

    function run_select_region()
    {
      $region_name = '';
      $div_where = '';

      if(!empty($this->input->post('region_name'))) {
        $type = ($this->input->post('region_name') == 'CO') ? 'co' : 'region';
        $div_where = array( 'axd.type'  => $type, );
      }
      else {
        $type = ($this->univdata['user_cred']['region'] == 'CO') ? 'co' : 'region';
        $div_where = array( 'axd.type'  => $type, 'axd.office' =>'EMB' );
      }

      $division = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $div_where);
      echo json_encode($division);
    }

    function run_select_division()
    {
      $division_name = !empty($this->input->post('division_name')) ? $this->input->post('division_name') : $this->univdata['user_cred']['divno'];
      $region = (!empty($this->input->post('region_name'))) ? $this->input->post('region_name') : $this->univdata['user_cred']['region'];

      $where['axsna_xsect'] = array('axsna.region' => $region);
      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axsna', '', $where['axsna_xsect'] );
      $xsct = '0';

      if(!empty($exclude_sect))
      {
        foreach($exclude_sect as $key => $value) {
          if(count($exclude_sect)-1 == $key)
          {
            $xsct .= $value['secno'];
          }
          else {
            $xsct .= $value['secno'].',';
          }
        }
      }

      if($region != 'CO') {
        $where['xsect'] = $this->db->where('axs.divno = "'.$division_name.'" AND ( axs.region = "'.$region.'" OR axs.region = "R" ) AND axs.secno NOT IN ('.$xsct.')');
      }
      else {
        $where['xsect'] = $this->db->where('axs.divno = "'.$division_name.'" AND axs.region = "'.$region.'"');
      }
      $division = $this->Embismodel->selectdata('acc_xsect AS axs', '', '', $where['xsect']);
      echo json_encode($division);
    }

    function bulk_download()
    {
      $this->load->library('zip');

      $this->zip->clear_data();
      $value= $this->uri->segment(4);
      $x = explode('_', $value);

      $trans_no_calculated = !empty($x[4]) ? $x[0] : $x[0] - 10000000;

      $where['bulkdl'] = array(
        'eat.trans_no'        => $x[0],
        'eat.main_multi_cntr' => !empty($x[1]) ? $x[1] : '',
        'eat.route_order'     => $x[2],
        'eat.multi_cntr'      => $x[3],
      );
      $bulkdl = $this->Embismodel->selectdata('er_attachments eat', 'eat.token, eat.file_name', $where['bulkdl']);
      $where['ertrans'] = array(
        'et.trans_no'        => $x[0],
      );
      $ertrans = $this->Embismodel->selectdata('er_transactions et', '', $where['ertrans']);

      foreach ($bulkdl as $key => $value) {
        $this->zip->read_file(trim('./uploads/dms/'.date('Y', strtotime($ertrans[0]['start_date'])).'/'.$x[4].'/'.$trans_no_calculated.'/'.$value['token'].'.'.pathinfo($value['file_name'], PATHINFO_EXTENSION)));
      }

      $this->zip->download('iisfiles.zip');
    }

  }
?>
