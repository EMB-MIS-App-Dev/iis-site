<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Main2 extends CI_Controller
  {
    private $univdata;
    function __construct()
    {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      // if ($this->session->userdata('superadmin_rights') != 'yes') {
      //  echo "<script>alert('Module under maintenance, Sorry for the inconvenience.'); window.location.href='".base_url()."';</script>";
      // }

      $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      $this->univdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
      $this->univdata['year_selected'] = !empty($this->input->get('year')) ? $this->input->get('year') : date('Y');
    }

    function index()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('includes/common/univ_styles');

      // $this->load->view('universe/include/custom_header');

      if($this->uri->segment(1) === 'universe' && !empty($this->uri->segment(2))) {
        $this->router();
      }
      else {
        redirect('universe/statistics');
      }
    }

    private function router() // MAINLY FOR URI SEGMENT CHECKING ONLY
    {
      switch ($this->uri->segment(2)) {
        case 'statistics':
            $this->load->view('universe/include/custom_footer');
            $this->statistics();
          break;

        case 'statistics-test':
            $this->load->view('universe/include/custom_footer');
            $this->statistics_test();
          break;

        case 'statistics-test-final':
            $this->load->view('universe/include/custom_footer');
            $this->statistics_test_final();
          break;

        case 'dms-monitoring':
            $this->load->view('universe/modal/modal');
            $this->dms_monitoring();
          break;

        default:
            redirect('universe/statistics');
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
        $redirect_page = base_url('error_404');
      }
      redirect($redirect_page);
    }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->univdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->univdata['user']['region'] || $session_ucred['secno'] != $this->univdata['user']['secno'] || $session_ucred['divno'] != $this->univdata['user']['divno']) {
        $this->univdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

// ----------------------------------------------------------------- VIEWS -------------------------------------------------------------------- //

    private function statistics()
    {
      $this->validate_session();

      $data['user'] = $this->univdata['user'];
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $data['year_selected'] = $this->univdata['year_selected'];
      $this->load->view('universe/statistics', $data);
    }

    private function statistics_test()
    {
      $this->validate_session();

      $data['user'] = $this->univdata['user'];

      $this->load->view('universe/statistics_test_2', $data);
    }

    private function statistics_test_final()
    {
      $this->validate_session();

      $data['user'] = $this->univdata['user'];
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');

      $this->load->view('universe/statistics_test_final', $data);
    }

    private function dms_monitoring()
    {
      $this->validate_session();

      $data['user'] = $this->univdata['user'];
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $this->load->view('universe/dms_monitoring', $data);
    }

  }
?>
