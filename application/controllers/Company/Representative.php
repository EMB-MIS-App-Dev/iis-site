<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Representative extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->model('Attachment');
  }
  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');

    $region = $_SESSION['region'];
    if ($region === 'CO') {
     $wherereg = '';
    }else {
      $wherereg = array('dc.region_name' => $region, );
    }
    $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
    'dc.company_name,dc.region_name,dc.company_id',$wherereg);

    $this->load->view('company/add_representative',$queryindex);
  }
  function add_representative(){
    $redata = $this->input->post();
    $data = array(
      'lname'        => $redata['lname'],
      'fname'        => $redata['fname'],
      'mname'        => $redata['mname'],
      'sex'          => $redata['sex'],
      'per_email'    => $redata['per_num'],
      'per_number'   => $redata['per_email'],
      'designation'  => $redata['designation'],
      'comp_id'      => $redata['main_comp'],
      'project_type' => $redata['project_name'],
    );
    $queryrepresentative = $this->Embismodel->insertdata('dms_representative',$data);
    if ($queryrepresentative) {
      echo "<script>alert('success')</script>";
      echo "<script>window.location.href='".base_url()."Company/Representative/'</script>";
    }else {
        echo "<script>alert('error')</script>";
    }
  }
}
