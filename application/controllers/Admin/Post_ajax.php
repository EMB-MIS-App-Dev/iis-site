<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Post_ajax extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

  function check_hierarchy_name(){
    $token = $this->input->post('token', TRUE);
    $wheredata  = $this->db->where('ar.rule_name',$token);
    $selectdata = $this->Embismodel->selectdata('acc_rule AS ar','ar.rule_name','',$wheredata);
    echo json_encode($selectdata);
  }

	function index(){
		
	}

}
?>
