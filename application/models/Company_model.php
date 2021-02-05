<?php

/**
 *
 */
class Company_model extends CI_Model
{

  function __construct()
  {
  parent::__construct();
    $this->load->helper(array('form', 'url'));
  }

  public function approved_company_request_list(){
    $this->db->select('acr.company_id,acr.approved_by,ac.fname,ac.sname,
    dcomp.company_name,dcomp.city_name,dcomp.barangay_name,dcomp.province_name,
    ac.userid,  acc.first_name,  acc.last_name
    ');
    $this->db->from('embis.approved_client_req as acr');
    $this->db->join('embis.dms_company as dcomp ','acr.company_id = dcomp.company_id','inner');
    $this->db->join('embis.acc_credentials as ac ','ac.userid = acr.approved_by','inner');
    $this->db->join('crs.acc as acc','acr.client_id = acc.client_id','inner');
    $this->db->where('acr.deleted ', 0);
    $this->db->where('dcomp.region_name', "NCR");
    $query  = $this->db->get();
    $result = $query->result_array();
    echo $this->db->last_query();exit;
    if(empty($count)){
         return false;
     }
     else{
         return $result;
     }
     $this->db->close();
  }
}
