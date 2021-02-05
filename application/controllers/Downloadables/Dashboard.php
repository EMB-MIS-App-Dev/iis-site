<?php

// phpinfo();
/**
 *
 */
class Dashboard extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		date_default_timezone_set("Asia/Manila");
	}

  function index(){
    $this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('downloadables/dashboard');

  }
}
