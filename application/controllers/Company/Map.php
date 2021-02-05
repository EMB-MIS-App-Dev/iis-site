<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Map extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    // USER SESSION CHECK
    if ( empty($this->session->userdata('token')) ) {
      echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
    }

    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->helper('url');
  }

  function index(){
    $token = (!empty($_GET['token'])) ? $this->encrypt->decode($_GET['token']) : ''; // pass company_name

    if(!empty($_GET['rtoken'])){
      // echo $this->encrypt->decode($_GET['rtoken']); exit;
      if($this->encrypt->decode($_GET['rtoken']) == 'ALL'){
        $wheredata = $this->db->where('(longitude != 0 OR latitude != 0)');
      }else{
        $wheredata = $this->db->where('region_name = "'.$this->encrypt->decode($_GET['rtoken']).'" AND (longitude != 0 OR latitude != 0)');
      }

    }else{
      if($_SESSION['superadmin_rights'] == 'yes'){
        $wheredata = $this->db->where('(longitude != 0 OR latitude != 0)');
      }else{
        $rgn = $this->session->userdata('region') == 'CO' ? 'NCR' : $this->session->userdata('region');
        $wheredata = $this->db->where('region_name = "'.$rgn.'" AND (longitude != 0 OR latitude != 0)');
      }

      if(!empty($token))
      {
        $wheredata = $this->db->where('region_name = "'.$rgn.'" AND (longitude != 0 OR latitude != 0) AND company_name = "'.$token.'"');
      }
    }

    $queryselect['data'] = $this->Embismodel->selectdata( 'dms_company', 'emb_id, barangay_id, province_id, city_id, company_type, company_id, company_name, establishment_name, date_established, house_no, street, barangay_name, city_name, province_name, region_name, latitude, longitude, project_type, category, status, email, contact_no, input_staff, input_date, mailing_add, deleted, token, project_name, cnt', '', $wheredata );

    $queryselect['region'] = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnnum','');

    $this->load->view('company/map', $queryselect);
  }
}
