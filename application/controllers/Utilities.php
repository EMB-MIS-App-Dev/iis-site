<?php

/**
 *
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class Utilities extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    $this->load->library('session');
    $this->load->helper('url');
  }

  function add_city(){

  }
}
