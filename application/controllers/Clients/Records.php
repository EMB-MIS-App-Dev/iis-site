<?php

/**
 *
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class Records extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

  }

    function index(){
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
        $sessreg_id = 'NCR';
      }else {
        $sessreg_id =  $this->session->userdata('region');
      }
      $query['comp_per_reg'] = $this->db->select('dcomp.company_name,dcomp.company_id')
      ->from('dms_company as dcomp')->
      where('region_name',$sessreg_id)->get()->result_array();
        // $query['comp_per_reg'] = $this->Embismodel->selectdata('dms_city AS cty','dcomp.company_name,dcomp.company_name',$wherecity);
      $this->load->view('clients/client_list',$query);
    }
    function client_comp_list(){
      $client_id = $this->input->post('client_id',TRUE);
      $query = $this->db->select('dcomp.company_name,dcomp.emb_id,dcomp.company_id,acr.client_id,acc.first_name,acc.last_name,acc.contact_no,acc.email')
      ->from('approved_client_req as acr')
      ->join('dms_company as dcomp','dcomp.company_id = acr.company_id')
      ->join('crs.acc','acc.client_id = acr.client_id')
      ->where('acr.client_id',$client_id)
      ->where('acr.deleted', 0)
      ->get()->result();
      echo json_encode($query);
    }
  public function client_list(){

      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => 'crs'
      );

      // DB table to use

      $table ="acc";

      // Table's primary key

      $primaryKey = 'client_id';

       $columns = array(
          array( 'db' => '`acc`.`username`', 'dt'   => 'username', 'field' => 'username'),
          array( 'db' => '`acc`.`first_name`', 'dt'    => 'full_name', 'field' => 'first_name','formatter'=>function($x,$row){
            return $row['first_name']." ".$row['last_name'];
            }),
          array( 'db' => '`acc`.`email`', 'dt'   => 'email', 'field' => 'email'),
          array( 'db' => '`acc`.`contact_no`', 'dt'   => 'contact_no', 'field' => 'contact_no'),
            array( 'db' => '`acc`.`client_id`', 'dt'   => 'client_id', 'field' => 'client_id'),

        );
        // exit;
                  // print_r($columns);exit;

      // Include SQL query processing class
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
            $sessreg_id = '15';
      }else {
      $sessreg_id =  $this->session->userdata('region_id');
    }

    $this->load->view('includes/common/ssp.customized.class.php');
    $joinQuery  = "FROM crs.acc";
    $extraWhere = 'deleted="0" AND verified = "1" AND role_id = "2"';
    $groupBy = '';
    $having = null;
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
  }

  function remove_comp_rights(){
    $company_id = $this->input->post('company_id',TRUE);
    $this->db->set('deleted',1);
    $this->db->where('acr.company_id',$company_id);
    $query = $this->db->update('approved_client_req as acr');
    echo $company_id;
  }
}
