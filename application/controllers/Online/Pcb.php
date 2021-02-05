<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Pcb extends CI_Controller
  {
    private $onlinedata;
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

      $this->onlinedata['user'] = array(
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
      // $this->load->view('includes/common/univ_styles');
      $this->load->view('online/includes/custom_header');

      $this->onlinedata['pcb_table']['region'] = !empty( $this->input->get('region') ) ? $this->input->get('region') : $this->onlinedata['user']['region'];
      switch ($this->onlinedata['pcb_table']['region']) {
        case 'NCR':
        case 'CAR':
        case 'ARMM':
          $this->onlinedata['pcb_table']['region'] = 'R'.$this->onlinedata['pcb_table']['region'];
          break;
        case 'CO':
          $this->onlinedata['pcb_table']['region'] = 'RNCR';
          break;
      }
      $this->load->view('online/pcb', $this->onlinedata);
    }

    function pcb_data() {
        echo file_get_contents("http://pcb.emb.gov.ph/api/table/".$this->input->get('region')."TB");
    }

    private function array_debug($data='') { $data['data'] = $data; $this->load->view('Dms/debug', $data); }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->onlinedata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->onlinedata['user']['region'] || $session_ucred['secno'] != $this->onlinedata['user']['secno'] || $session_ucred['divno'] != $this->onlinedata['user']['divno']) {
        $this->onlinedata = array(
          'user_id'     => $session_ucred['userid'],
          'user_region' => $session_ucred['region'],
          'user_token'  => $session_ucred['token'],
        );
        $this->onlinedata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

  }
?>
