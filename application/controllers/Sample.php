<?php

/**
 *
 */
class Sample extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
  }
  function index(){
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    $this->load->library('OnlineUsers');
echo "<pre>";
    print_r($this->onlineusers);
    exit;
    $this->load->view('login');
  }
}
