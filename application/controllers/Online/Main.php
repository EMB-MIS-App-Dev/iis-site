<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Main extends CI_Controller
  {
    private $thisdata;
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

      $this->thisdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );

      $this->thisdata['date_retrieved'] = $this->db->query('SELECT odr.* FROM online_data_retrieval odr JOIN (SELECT MAX(id) AS mxid FROM online_data_retrieval GROUP BY updated_db ) AS odr2 ON odr.id = odr2.mxid')->result_array();
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

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->thisdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->thisdata['user']['region'] || $session_ucred['secno'] != $this->thisdata['user']['secno'] || $session_ucred['divno'] != $this->thisdata['user']['divno']) {
        $this->thisdata = array(
          'user_id'     => $session_ucred['userid'],
          'user_region' => $session_ucred['region'],
          'user_token'  => $session_ucred['token'],
        );
        $this->thisdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

    function data_datetime($table)
    {
      $date = $this->thisdata['date_retrieved'][array_search($table, array_column($this->thisdata['date_retrieved'], "updated_db"))]['datetime_updated'];
      return date("M d Y, H:i:s", strtotime($date));
    }

    function ecc()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('online/includes/custom_header');

      $this->thisdata['region_selection'] = [ "ARM", "CAR", "NCR", "R01", "R02", "R03", "R05", "R06", "R07", "R08", "R09", "R10", "R11", "R12", "R13", "R18", "R4A", "R4B" ];

      $this->thisdata['status'] = [ "Approved", "Denied", "For Appropriate Action", "For Approval", "For Clarification of Information", "For Evaluation", "For Payment of ECC Application", "For Recommendation", "For Review", "For Screening", "For Submission of Additional Information", "For Submission of Basic Requirements" ];

      $this->thisdata['data_datetime'] = $this->data_datetime('ecc');

      $this->load->view('online/ecc', $this->thisdata);
    }

    function transporter()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('online/includes/custom_header');

      $this->thisdata['region_selection'] = [ "Cordillera Administrative Region", "National Capital Region", "Region 1", "Region 10", "Region 11", "Region 12", "Region 13", "Region 2", "Region 3", "Region 4A", "Region 4B", "Region 5", "Region 6", "Region 7", "Region 8", "Region 9" ];

      $this->thisdata['data_datetime'] = $this->data_datetime('transporter');

      $this->load->view('online/transporter', $this->thisdata);
    }

    function hw_generators()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('online/includes/custom_header');

      $this->thisdata['region_selection'] = [ "Cordillera Administrative Region", "National Capital Region", "Region 1", "Region 10", "Region 11", "Region 12", "Region 13", "Region 2", "Region 3", "Region 4A", "Region 4B", "Region 5", "Region 6", "Region 7", "Region 8", "Region 9" ];

      $this->thisdata['data_datetime'] = $this->data_datetime('hw_generators');

      $this->load->view('online/hw_generators', $this->thisdata);
    }

    function registered_tsd()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('online/includes/custom_header');

      $this->thisdata['region_selection'] = [ "Cordillera Administrative Region", "National Capital Region", "Region 1", "Region 10", "Region 11", "Region 12", "Region 13", "Region 2", "Region 3", "Region 4A", "Region 4B", "Region 5", "Region 6", "Region 7", "Region 8", "Region 9" ];

      $this->thisdata['data_datetime'] = $this->data_datetime('registered_tsd');

      $this->load->view('online/registered_tsd', $this->thisdata);
    }

    function pcb()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('online/includes/custom_header');

      $this->thisdata['pcb_table']['region'] = !empty( $this->input->get('region') ) ? $this->input->get('region') : $this->thisdata['user']['region'];
      switch ($this->thisdata['pcb_table']['region']) {
        case 'NCR':
        case 'CAR':
        case 'ARMM':
          $this->thisdata['pcb_table']['region'] = 'R'.$this->thisdata['pcb_table']['region'];
          break;
        case 'CO':
          $this->thisdata['pcb_table']['region'] = 'RNCR';
          break;
      }
    
      // $this->thisdata['region_selection'] = [ "Cordillera Administrative Region", "National Capital Region", "Region 1", "Region 10", "Region 11", "Region 12", "Region 13", "Region 2", "Region 3", "Region 4A", "Region 4B", "Region 5", "Region 6", "Region 7", "Region 8", "Region 9" ];

      // $this->thisdata['data_datetime'] = $this->data_datetime('pcb');

      $this->load->view('online/pcb', $this->thisdata);
    }
  }
?>
