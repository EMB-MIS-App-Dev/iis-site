<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->model('Sweetreportmodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');
    $this->load->library('form_validation');
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $selectdata['regions'] = $this->Embismodel->selectdata('acc_region AS ar','','');
    $this->load->view('swm/reports',$selectdata);
    $this->load->view('swm/modals');
  }
}
