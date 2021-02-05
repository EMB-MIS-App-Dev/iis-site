<?php

/**
 *
 */
class Utilities extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('encrypt');
    $this->load->helper('url');
    $this->load->helper('security');
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
  }
  // function index(){
  //   echo "1";
  // }
  function client_binded_companies($region){
    // echo $region;exit;
    $query = $this->db->query("INSERT INTO crs.client_binded_companies (client_id, first_name, last_name,email,date_submitted,client_req_id,approved_by,
      company_name,date_approved,emb_id,region,company_id)
      SELECT acc.client_id,acc.first_name,acc.last_name,acc.email,est.date_created,
      acr.client_req_id,
      ac.username,
      dcomp.company_name,dcomp.input_date,dcomp.emb_id,dcomp.region_name,dcomp.company_id
      		FROM embis.approved_client_req as acr
              INNER JOIN embis.dms_company as dcomp ON acr.company_id = dcomp.company_id
              INNER JOIN embis.acc as ac ON ac.userid = acr.approved_by
              INNER JOIN crs.acc as acc ON acr.client_id = acc.client_id
              INNER JOIN crs.establishment as est ON est.cnt = acr.req_id
              WHERE dcomp.region_name = '.$region.'
               LIMIT 5;
      ");
    //   WHERE NOT EXISTS (
    //   SELECT region_name FROM crs.client_binded_companies WHERE dcomp.region_name = '.$region.'
    // )
  if ($query){
    echo "success";
    echo $this->db->last_query();
  }else {
    echo "<pre>";print_r($this->db->error());
  }

  }
}
