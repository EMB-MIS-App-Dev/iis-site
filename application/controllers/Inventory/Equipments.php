<?php

/**
 *
 */
  defined('BASEPATH') OR exit('No direct script access allowed');
class Equipments extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    $this->load->library('session');
    $this->load->helper('url');
  }

    // to be transfer to INVENTORY
  public function index(){
    $this->_show_view('inventory/equipments');
  }
  public function _show_view($content)
  {
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);

      $this->load->view('includes/common/footer');
  }
}
