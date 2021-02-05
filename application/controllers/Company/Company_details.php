<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company_details extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    // $this->load->library('MY_Encrypt');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
  }

function index(){
  $compant_id = $this->input->get('compid',TRUE);
  $decodedprojectid = $this->encrypt->decode($compant_id);
  $where = array('dcmp.company_id' => $decodedprojectid, );
  $queryindex['company_data'] = $this->Embismodel->selectdata('dms_company AS dcmp',
    'dcmp.emb_id,dcmp.barangay_id,dcmp.province_id,dcmp.city_id,dcmp.company_type,
    dcmp.company_id,dcmp.company_name,dcmp.establishment_name,dcmp.date_established,
    dcmp.house_no,dcmp.street,dcmp.barangay_name,dcmp.city_name,dcmp.province_name,
    dcmp.region_name,dcmp.latitude,dcmp.longitude,dcmp.project_type,dcmp.category,
    dcmp.status,dcmp.email,dcmp.contact_no,dcmp.input_staff,dcmp.input_date,
    dcmp.mailing_add,dcmp.token,dcmp.project_name',$where);
  $this->load->view('company/company_details',$queryindex);
}
}
