<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Test_Controller extends CI_Controller
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

    function disposition_form()
    {
        $this->load->library('Pdf');

        $header_where = $this->db->where('ou.region = "'.$this->session->userdata('region').'" AND ou.cnt = (SELECT max(cnt) FROM office_uploads_document_header AS oh WHERE oh.region = "'.$this->session->userdata('region').'")');
        $header = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '*','', $header_where);

        $trans = $this->Embismodel->selectdata( 'er_transactions', '*', array('trans_no' => $this->uri->segment(3)) );
        $trans_log = $this->Embismodel->selectdata( 'er_transactions_log', '*', array('trans_no' => $this->uri->segment(3)) );

        $data['trans'] = $trans;
        $data['trans_log'] = $trans_log;

        $data['header'] = 'no-header.png';

        if(!empty($header)) {
          $data['header'] = $header[0]['file_name'];
        }

        $this->load->view('Dms/func/ddpos', $data);
    }

  }
?>
