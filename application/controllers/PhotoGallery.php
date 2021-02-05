<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PhotoGallery extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Embismodel');
    $this->load->helper('directory');
  }
	public function index()	{

    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    // $query['images'] = $this->db->query('SELECT * FROM ')->get()->result_array();
    $where = array('user_id' => $this->session->userdata('userid'), );
    $query['images'] = $this->Embismodel->selectdata('mobile_db.survey_details as sd',
    'sd.*',$where);
    // echo $this->db->error();
    // echo $this->db->last_query();
		$this->load->view('photo_gallery',$query);

	}

}
