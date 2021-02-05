<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Universe extends CI_Controller
  {
    private $univdata;

    function __construct()
    {
      parent::__construct();

      $this->load->model('Embismodel');
      $this->load->library('session');

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');

      $this->load->library('upload');

      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      $where['cred']      = array('ac.token' => $this->session->userdata('token'));
      $globvar['cred']    = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred']);

      $where['rights']    = array('ar.userid' => $this->session->userdata('userid'));
      $globvar['rights']  = $this->Embismodel->selectdata('acc_rights AS ar', '', $where['rights']);

      $where['func']      = array('af.userid' => $this->session->userdata('userid'));
      $globvar['func']    = $this->Embismodel->selectdata('acc_function AS af', '', $where['func']);

      // GLOBAL USER VARIABLES
      $this->univdata = array(
        'user_cred'     => $globvar['cred'][0],
        'user_rights'   => $globvar['rights'][0],
        'user_func'     => $globvar['func'],
      );
    }
    function _univ_view($content)
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('includes/common/univ_styles');

  		if ( ! empty($content)) {
  			$this->load->view($content, $this->univdata);

        $this->load->view('Dms/func/modals');
        $this->load->view('universe/func/modals');
      }
    }

    
  }
?>
