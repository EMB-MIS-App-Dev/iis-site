<?php

/**
 *
 */
class User_Manuals extends CI_Controller
{

function index(){
  $this->load->view('includes/common/header');
  $this->load->view('includes/common/sidebar');
  $this->load->view('includes/common/nav');
  $this->load->view('includes/common/footer');
  $this->load->view('user_manuals');
}

}
