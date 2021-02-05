<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Index extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

  function index(){
    $this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
		$this->load->view('includes/common/footer');
    $this->load->view('repository/dashboard');
    $this->load->view('repository/modals');
  }
}
