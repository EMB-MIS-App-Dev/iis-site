<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Revise extends CI_Controller
  {
    private $dmsdata;
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

      if( $this->session->userdata('superadmin_rights') != 'yes' && $this->session->userdata('trans_deletion') != 'yes' ) {
        echo "<script>alert('Unauthorized Access. Administrator and Regional Administrator Priviledged Accounts Only'); window.location.href='".base_url()."';</script>";
      };
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

      if($this->uri->segment(1) != 'dms' && $this->uri->segment(2) != 'documents' && $this->uri->segment(3) != 'revise') {
        redirect(base_url('error_404'));
      }
      if($this->uri->segment(2) === 'documents' && !empty($this->uri->segment(3)) && $this->uri->segment(3) == 'revise') { // ADD XSS_CLEAN
        $this->router();
      }
      else {
        redirect(base_url('dms/documents/all'));
      }
    }

    private function router() // MAINLY FOR URI SEGMENT CHECKING ONLY
    {
      switch ($this->uri->segment(3)) {
        case 'revise': // SEPARATE TO ANOTHER DMS CONTROLLER FILE
            if(!empty($this->uri->segment(4)) && !empty($this->uri->segment(5)) && !empty($this->uri->segment(6)) && !empty($this->uri->segment(7))) {
              $this->revise_transaction();
              // PUT AFTER FUNCTION TO RECEIVE DATA
              $this->load->view('Dms/include/modals');
              $this->load->view('Dms/include/multiselect_personnel_modals');
            }
            else {
              $this->_alert('', '', '[PRC-ROUTE]');
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

    private function revise_transaction()
    {
      /*
      * segment 4 - entry
      * segment 5 - trans_no
      * segment 6 - main_multi_cntr
      * segment 7 - multi_cntr
      */
      $encrpty = trim($this->uri->segment(4).';'.$this->uri->segment(5).';'.$this->uri->segment(6).';'.$this->uri->segment(7));
      $data = array(
        'entry'           => $this->uri->segment(4),
        'trans_no'        => $this->uri->segment(5),
        'enc_key'         => $this->encrypt->encode($encrpty),
        'user_region'     => $this->dmsdata['user_region'],
        'user_token'      => $this->dmsdata['user_token'],
      );
      $data['user'] = $this->dmsdata['user'];
      // VERIFY IF TRANSACTION IS INDEED ROUTED TO USER
      $rslt_trans = '';
      $where_trans = array(
        'trans_no'        => $this->uri->segment(5),
        'receiver_region' => $this->dmsdata['user']['region'],
      );

      if( $this->session->userdata('superadmin_rights') == 'yes' ) {
        $where_trans = array( 'trans_no' => $this->uri->segment(5) );
      }

      // CHECK WHICH TABLE TO LOOK
      if($this->uri->segment(4) == 1) {
        if($this->uri->segment(6) == 1 && $this->uri->segment(7) == 1) {
          $data['main_multi_cntr'] = '';
          $data['multi_cntr'] = 1;
          $rslt_trans = $this->Embismodel->selectdata('er_transactions', '*', $where_trans);
        }
      }
      else {
        if(!empty($this->uri->segment(4))) {
          $where_trans['main_multi_cntr'] = $data['main_multi_cntr'] = $this->uri->segment(6);
          $where_trans['multi_cntr'] = $data['multi_cntr'] = $this->uri->segment(7);
          $rslt_trans = $this->Embismodel->selectdata('er_transactions_multi', '*', $where_trans);
        }
        else {
          echo 'ERROR'; exit;
        }
      }

      if(!$rslt_trans) { $this->_alert('', base_url('dms/documents/inbox'), '[RTE-RES-TRNS]'); exit; }

      // echo '<pre>'.print_r($rslt_trans, TRUE).'</pre>';

      // CHECK IF RECEIVER MATCHES TRANS. LOG HISTORY RECEIVER
      $where_trans['route_order'] = $rslt_trans[0]['route_order'];
      $where_tlg_cnct = $where_trans;
      unset($where_tlg_cnct['receiver_region']);
      $rslt_trans_log_connect = $this->Embismodel->selectdata('er_transactions_log', '*', $where_tlg_cnct);

      // EMPTY RESULT
      $etlog_mismatch['alert_data'] = array( 'title' => 'ERROR', 'text' => 'The System has Identified a Data Mismatch to the Transaction with IIS No. <b>'.$rslt_trans[0]['token'].'</b>. Please Contact System Administrator.', 'type' => 'error');
      if(!$rslt_trans_log_connect) { $this->_alert($etlog_mismatch['alert_data'], base_url('dms/documents/inbox'), '[RTE-RES-TLOG]'); exit; }

      // CHECK IF RECEIVER RECEIVED THE TRANSACTION
      $where_trans_log = array(
        'trans_no'            => $data['trans_no'],
        // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
        'route_order'	        => $rslt_trans[0]['route_order'],
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'receiver_id'	        => $rslt_trans[0]['receiver_id'],
      );
      $rslt_trans_log = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trans_log);

      // EMPTY RESULT
      $etlog_mismatch['alert_data'] = array( 'title' => 'ERROR', 'text' => 'The System has Identified a Data Mismatch to the Transaction with IIS No. <b>'.$rslt_trans[0]['token'].'</b>. Please Contact System Administrator.', 'type' => 'error');
      if(!$rslt_trans_log) { $this->_alert($etlog_mismatch['alert_data'], base_url('dms/documents/inbox'), '[RTE-RESRCV-TLOG]'); exit; }

      // GET SELECT DROPDOWNS
      $data['trans_data'] = $rslt_trans;
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*');
      $data['system'] = $this->Embismodel->selectdata('er_systems', '*', '', $this->db->order_by('system_order', 'asc'));
      $data['trans_type'] = $this->Embismodel->selectdata( 'er_type', '*', array( 'sysid' => $data['trans_data'][0]['system'] ), $this->db->order_by('sysid asc, ssysid asc, header desc') );
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
      $data['history'] = $this->transaction_history();

      $where_attchmnts = array(
        'trans_no'            => $data['trans_no'],
        // 'main_route_order'    => $data['trnsctn'][0]['main_route_order'],
        'route_order'	        => $rslt_trans[0]['route_order']+1,
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'deleted'             => 0,
      );
      $data['attachments'] = $this->Embismodel->selectdata('er_attachments', '*', $where_attchmnts);
      $data['revert'] = $this->Embismodel->selectdata( 'acc_credentials', '*', array('token' => $rslt_trans[0]['sender_id']) );
      $data['qr_code_image'] = $this->trans_qrcode();

      $this->validate_form('Dms/revise_transaction', $data);
    }

    private function transaction_history()
    {
      $data = array(
        'entry'           => $this->uri->segment(4),
        'trans_no'        => $this->uri->segment(5),
        'main_multi_cntr' => $this->uri->segment(6),
        'multi_cntr'      => $this->uri->segment(7),
      );
      $result = array();
      if($data['entry'] != 1)
      {
        $data['multicnt'] = explode('-', $data['main_multi_cntr']);
        for ($index=0; $index < count($data['multicnt'])+1; $index++)  {
          $history = array(
            'where' => array(
              'trans_no'          => $data['trans_no'],
              'main_multi_cntr'   => $index == 0 ? 0 : ($index==1 ? $data['multicnt'][$index-1] : substr($data['main_multi_cntr'],0,($index)+$index)),
              'multi_cntr'        => count($data['multicnt'])==$index ? $data['multi_cntr'] : $data['multicnt'][$index],
            ),
            'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
          );
          $result['trans_history'][$index] = $this->Embismodel->selectdata( 'er_transactions_log', '*', $history['where'], $history['order'] );

          foreach ($result['trans_history'][$index] as $key => $value)
          {
            if($value['route_order'] == 1 && !empty($value['main_multi_cntr']))
            {
              $data['sub_multicnt'] = explode('-', $value['main_multi_cntr']);
              $sub_mtcount_cnt = count($data['sub_multicnt']);
              // CHECK WHICH TABLE TO LOOK
              if($sub_mtcount_cnt==1)
              {
                $history_ertrans_multiprc_check = array(
                  'where' => array(
                    'trans_no'  => $data['trans_no'],
                    'multiprc'  => 1,
                  ),
                  'table' => 'er_transactions',
                );
              }
              else {
                $history_ertrans_multiprc_check = array(
                  'where' => array(
                    'trans_no'          => $data['trans_no'],
                    'multiprc'          => 1,
                    'main_multi_cntr'   => $sub_mtcount_cnt==1 ? 0 : ($sub_mtcount_cnt==2 ? $data['sub_multicnt'][0] : substr($value['main_multi_cntr'],0,($index-1)+$index)),
                    'multi_cntr'        => end($data['sub_multicnt']),
                  ),
                  'table'               => 'er_transactions_multi',
                );
              }
              $result_ertrans_multi_multiprc_check = $this->Embismodel->selectdata( $history_ertrans_multiprc_check['table'], '*', $history_ertrans_multiprc_check['where'] )[0];

              if($result_ertrans_multi_multiprc_check)
              {
                $history = array(
                  'where' => array(
                    'trans_no'          => $data['trans_no'],
                    'route_order'       => $result_ertrans_multi_multiprc_check['route_order'],
                    'main_multi_cntr'   => $sub_mtcount_cnt==1? '' : $result_ertrans_multi_multiprc_check['main_multi_cntr'],
                    'multi_cntr'        => $this->_is_empty($result_ertrans_multi_multiprc_check['multi_cntr'], 1),
                    'deleted'           => 0,
                  ),
                  'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
                );
                $result['attachments'][$index][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
              }
              else {
                $history = array(
                  'where' => array(
                    'trans_no'          => $data['trans_no'],
                    'route_order'       => $value['route_order'],
                    'main_multi_cntr'   => $value['main_multi_cntr'],
                    'multi_cntr'        => $value['multi_cntr'],
                    'deleted'           => 0,
                  ),
                  'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
                );
                $result['attachments'][$index][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
              }
            }
            else {
              $history = array(
                'where' => array(
                  'trans_no'          => $data['trans_no'],
                  'route_order'       => $value['route_order'],
                  'main_multi_cntr'   => $value['main_multi_cntr'],
                  'multi_cntr'        => $value['multi_cntr'],
                  'deleted'           => 0,
                ),
                'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
              );
              $result['attachments'][$index][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
            }

            // XDIVISION AND XSECT QUERIES FOR SENDER AND RECEIVER
            $sender['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['sender_divno'], 'office' => 'EMB' ) )[0];
            $sender['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['sender_secno']) )[0];
            $receiver['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['receiver_divno'], 'office' => 'EMB' ) )[0];
            $receiver['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['receiver_secno']) )[0];
            // SENDER REGION, DIVISION, SECTION CODES
            $result['ds_sender'][$index][$key] = (!empty($value['sender_region'])) ? $value['sender_region'] : '';
            $result['ds_sender'][$index][$key] .= (!empty($sender['div'])) ?  '|'.$sender['div']['divcode'] : '';
            $result['ds_sender'][$index][$key] .= (!empty($sender['sec'])) ? '|'.$sender['sec']['secode'] : '';
            // RECEIVER REGION, DIVISION, SECTION CODES
            $result['ds_receiver'][$index][$key] = (!empty($value['receiver_region'])) ? $value['receiver_region'] : '';
            $result['ds_receiver'][$index][$key] .= (!empty($receiver['div'])) ?  '|'.$receiver['div']['divcode'] : '';
            $result['ds_receiver'][$index][$key] .= (!empty($receiver['sec'])) ? '|'.$receiver['sec']['secode'] : '';
          }
        }
      }
      else {
        $history = array(
          'where' => array(
            'trans_no'          => $data['trans_no'],
            'main_multi_cntr'   => '',
            'multi_cntr'        => 1,
          ),
          'order' => $this->db->order_by('route_order ASC'),
        );
        $result['trans_history'][0] = $this->Embismodel->selectdata( 'er_transactions_log', '*', $history['where'], $history['order'] );

        foreach ($result['trans_history'][0] as $key => $value)
        {
          $history = array(
            'where' => array(
              'trans_no'          => $value['trans_no'],
              'route_order'       => $value['route_order'],
              'main_multi_cntr'   => '',
              'multi_cntr'        => 1,
              'deleted'           => 0,
            ),
            'order' => $this->db->order_by('route_order ASC'),
          );
          $result['attachments'][0][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
          // XDIVISION AND XSECT QUERIES FOR SENDER AND RECEIVER
          $sender['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['sender_divno'], 'office' => 'EMB' ) )[0];
          $sender['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['sender_secno']) )[0];
          $receiver['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['receiver_divno'], 'office' => 'EMB' ) )[0];
          $receiver['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['receiver_secno']) )[0];
          // SENDER DIVISION AND SECTION CODES
          $result['ds_sender'][0][$key] = (!empty($value['sender_region'])) ? $value['sender_region'] : '';
          $result['ds_sender'][0][$key] .= (!empty($sender['div'])) ?  '|'.$sender['div']['divcode'] : '';
          $result['ds_sender'][0][$key] .= (!empty($sender['sec'])) ? '|'.$sender['sec']['secode'] : '';
          // RECEIVER DIVISION AND SECTION CODES
          $result['ds_receiver'][0][$key] = (!empty($value['receiver_region'])) ? $value['receiver_region'] : '';
          $result['ds_receiver'][0][$key] .= (!empty($receiver['div'])) ?  '|'.$receiver['div']['divcode'] : '';
          $result['ds_receiver'][0][$key] .= (!empty($receiver['sec'])) ? '|'.$receiver['sec']['secode'] : '';
        }
      }

      return $result;
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

      if(isset($_POST['reviseTransaction']))
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
          $this->revision_form($data);
        }
      }
      else {
        $this->load->view($site, $data);
      }
    }

// ------------------------------------------- FORM DATA ------------------------------------------ //

    private function personnel_fullname($token="")
    {
      $result = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $token ) )[0];

      return !empty($result) ? $result['fname'].' '
        .$this->_is_empty($result['mname'][0], '', '. ')
        .$result['sname']
        .$this->_is_empty($result['suffix'], '') : '--';
    }

    private function revision_form()
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
        'trans_no'        => $data['trans_no'],
        'receiver_region' => $this->dmsdata['user']['region'],
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
        'route_order'	        => $rslt_trans[0]['route_order'],
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'receiver_id'	        => $rslt_trans[0]['receiver_id'],
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

      $data['snder'] = $this->personnel_fullname($this->dmsdata['user']['token']);
      $data['rcver'] = $this->personnel_fullname($post['receiver']);
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
        'date_in'             => $data['date_in'],
        'date_out'            => $data['date_out'],
      );

      // SINGLE - DEFAULT
      $update['er_trans'] = array(
        'route_order'	        => $data['trnsctn_log'][0]['route_order']+1,
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

      $where['er_translog_rcv_exists'] = array(
        'trans_no'            => $data['trans_no'],
        'route_order'	        => $data['trnsctn'][0]['route_order']+1,
        'main_multi_cntr'	    => $data['main_multi_cntr'],
        'multi_cntr'          => $data['multi_cntr'],
        'sender_id'	          => $rslt_trans[0]['receiver_id'],
      );
      $rslt_trans_log_received = $this->Embismodel->selectdata('er_transactions_log', '*', $where['er_translog_rcv_exists']);

      if($rslt_trans_log_received) {
          $where['er_translog'] = array(
            'trans_no'            => $data['trans_no'],
            'route_order'	        => $data['trnsctn'][0]['route_order']+1,
            'main_multi_cntr'	    => $data['main_multi_cntr'],
            'multi_cntr'          => $data['multi_cntr'],
            'sender_id'	          => $this->dmsdata['user']['token'],
          );
          $update_er_translog = $this->Embismodel->updatedata( $update['er_translog'], 'er_transactions_log', $where['er_translog'] );
      }
      else {
        $insert['er_translog'] = array(
          'trans_no'	          => $data['trans_no'],
          'main_route_order'	  => $data['trnsctn_log'][0]['main_route_order'],
          'route_order'	        => $data['trnsctn'][0]['route_order']+1,
          'multiprc'	          => $data['trnsctn_log'][0]['multiprc'],
          'main_multi_cntr'	    => $data['main_multi_cntr'],
          'multi_cntr'	        => $data['multi_cntr'],
          'subject'	            => trim($post['subject']),
          'sender_id'	          => $this->dmsdata['user']['token'],
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
          'date_in'	            => $data['date_in'],
          'date_out'            => $data['date_out'],
        );
        $update_er_translog = $this->Embismodel->insertdata( 'er_transactions_log', $insert['er_translog'] );
      }

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

      // ---------- DEBUGGER -------------
      // echo $table_to_look;
      // echo "DEBUGGER"; echo "<pre>".print_r($update['er_trans'], TRUE)."</pre>"; exit;

      $update_er_transaction = $this->Embismodel->updatedata( $update['er_trans'], $table_to_look, $where['er_trans'] );
      // $update_er_translog FAILED
      if(!$update_er_transaction){ $this->_alert($query_fail['alert_data'], $query_fail['redirect'], '[UPDT-ETRANS]'); exit; }

      if($result) {
        if(!empty($post['system']) && !empty($post['type'])) {
          $system_table_check = $this->ersystems_addedtable($data);
        }
      }

      // FOR ER RECALL FUNCTION
      if($data['entry'] == 1) { // SOURCE IS SINGLE
        $er_recall = $this->Embismodel->selectdata('er_selection_recall', '*', array('userid' => $this->dmsdata['user']['id']) );
        if(!$er_recall) {
          $ins_ercall = array(
            'userid'           => $this->dmsdata['user']['id'],
            'token'            => $this->dmsdata['user']['token'],
            'company_id'       => $post['company'],
            'receiver_region'  => $data['region'],
            'receiver_divno'   => $post['division'],
            'receiver_secno'   => $post['section'],
            'receiver_id'      => $post['receiver'],
            'action_taken'     => $post['action'],
          );
          $res_recall = $this->Embismodel->insertdata( 'er_selection_recall', $ins_ercall );
        }
        else {
          $up_ercall = array(
            'company_id'       => $post['company'],
            'receiver_region'  => $data['region'],
            'receiver_divno'   => $post['division'],
            'receiver_secno'   => $post['section'],
            'receiver_id'      => $post['receiver'],
            'action_taken'     => $post['action'],
          );
         $res_recall = $this->Embismodel->updatedata( $up_ercall, 'er_selection_recall', array('userid' => $this->dmsdata['user']['id']) );
        }
      }

      $prc_success_ova = array(
        'title'     => 'SUCCESS',
        'text'      => '[IIS Reference No.] '.$data['trnsctn'][0]['token'].'<br />Your Transaction has been Successfully Saved.<br />Thank you!',
        'type'      => 'success',
      );

      $this->dmsdata['dms']['options'] = $this->Embismodel->selectdata('acc_options', '*', array('userid' => $this->dmsdata['user']['id']) )[0];

      $this->_alert($prc_success_ova, base_url('dms/documents/revisions'), '', 'swal_alert_data');

      redirect( base_url('dms/documents/revisions') );
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

    function trans_qrcode()
    {
      $trans_stat = $this->input->post('trns_stat',TRUE);
      $token      = $this->encrypt->decode($this->input->post('token',TRUE));
      // if(($this->session->userdata('trans_qrcode') == 'yes' OR $this->session->userdata('superadmin_rights') == 'yes')){
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
        // echo "<label>Please copy and paste QR Code into the document to be routed:</label><br>";
        // echo "<input type='hidden' class='form-control' name='qr_code' value='".$delimited."' readonly>";
        // echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fiis.emb.gov.ph/verify?token=".$delimited."%2F&choe=UTF-8' style='width:150px;'>";
        return $delimited;
      // }
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
  }
?>
