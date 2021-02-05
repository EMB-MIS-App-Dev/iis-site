<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Serverside extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->helper('url');
    $this->load->helper('security');

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
  }
  public function user_list(){

      // Database connection info
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
        array( 'db' => '`acc`.`last_name`', 'dt'      => 'last_name', 'field' => 'last_name'),
        array( 'db' => '`acc`.`region`', 'dt'      => 'region', 'field' => 'region'),
        array( 'db' => '`acc`.`first_name`', 'dt'      => 'client_name', 'field' => 'first_name','formatter'=>function($x,$row){
          return $row['first_name'].' '.$row['last_name'];
        }),
        array( 'db' => '`acc`.`raw_password`', 'dt'      => 'raw_password', 'field' => 'raw_password','formatter'=>function($x,$row){
          return $this->encrypt->decode($row['raw_password']);
        }),
        array( 'db' => '`acc`.`email`', 'dt'          => 'email', 'field' => 'email'),
        array( 'db' => '`acc`.`client_id`', 'dt'          => 'client_id', 'field' => 'client_id'),
        array( 'db' => '`acc`.`username`', 'dt'          => 'username', 'field' => 'username'),
          array( 'db' => '`res`.`status`', 'dt'      => 'status', 'field' => 'status','formatter'=>function($x,$row){
            if ($row['status'] == '' || $row['status'] == 0) {
              $status = 'pending';
            }else {
            $status = 'sent';
            }
            return $status;
          }),
        );
                  // print_r($columns);exit;

      // Include SQL query processing class

          $this->load->view('common/ssp.customized.class.php');
        $joinQuery  = "FROM crs.acc acc LEFT JOIN crs.resend_email as res ON res.client_id = acc.client_id";

        // $embisdb = $this->load->database('embis',TRUE);
        // $where1 = array('rgnid' => $this->session->userdata('region'), );
        // $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where1)->get()->result_array();
        $extraWhere = "deleted = 0";
        $groupBy = '';
        $having = null;
        // echo $this->db->last_query();
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->load->database();
      $this->db->close();
  }

// for smr list
public function view_admin_smr_list(){
  // Database connection info
  $dbDetails = array(
    'host' => $this->session->userdata('host'),
    'user' => $this->session->userdata('user'),
    'pass' => $this->session->userdata('pass'),
    'db'   => 'smr'
  );
  // DB table to use

  $table ="smr";

  // Table's primary key

  $primaryKey = 'smr_id';

  // Array of database columns which should be read and sent back to DataTables.
  // The `db` parameter represents the column name in the database.
  // The `dt` parameter represents the DataTables column identifier.x
   $columns = array(
      array( 'db' => '`s`.`smr_id`', 'dt'    => 'smr_id', 'field' => 'smr_id'),
      array( 'db' => '`dcomp`.`barangay_name`',    'dt'    => 'barangay_name',     'field' => 'barangay_name'),
      array( 'db' => '`dcomp`.`company_name`',    'dt'    => 'company_name',     'field' => 'company_name'),
      array( 'db' => '`dcomp`.`city_name`',    'dt'    => 'city_name',     'field' => 'city_name'),
      array( 'db' => '`dcomp`.`province_name`',    'dt'    => 'province_name',     'field' => 'province_name','formatter' => function($x, $row){
          return $row['barangay_name'].' , '.$row['city_name'].' , '.$row['province_name'];
      }),
      array( 'db' => '`s`.`ref_no`',           'dt'    => 'ref_no',         'field' => 'ref_no'),
      array( 'db' => '`s`.`date_created`',    'dt'    => 'date_created',     'field' => 'date_created'),
      array( 'db' => '`s`.`date_submitted`',     'dt'    => 'date_submitted',   'field' => 'date_submitted','formatter'=>function($x,$row){
        return date("M j, Y", strtotime($row['date_submitted']));
      }),
      array( 'db' => '`ss`.`status_name`',     'dt'    => 'status_name',    'field' => 'status_name'),
      array( 'db' => '`s`.`date_evaluated`',     'dt'    => 'date_evaluated',   'field' => 'date_evaluated','formatter'=>function($x,$row){
        return date("M j, Y", strtotime($row['date_evaluated']));
      }),
      array( 'db' => '`s`.`date_created`',     'dt'    => 'date_created',   'field' => 'date_created','formatter'=>function($x,$row){
        return date("M j, Y", strtotime($row['date_created']));
      }),
      array( 'db' => '`s`.`evaluator`',    'dt'    => 'evaluator',     'field' => 'evaluator'),
      array( 'db' => '`dcomp`.`pco`',    'dt'    => 'pco',     'field' => 'pco'),
      array( 'db' => '`dcomp`.`ceo_email`', 'dt'    => 'ceo_email',   'field' => 'ceo_email'),


      //
    );
  // Include SQL query processing class

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery  = "FROM smr s
    LEFT JOIN embis.dms_company dcomp ON dcomp.company_id = s.facility_id
    LEFT JOIN smr_status_list ss ON ss.status_id = s.smr_status ";
    // $joinQuery = "FROM dms_company as dcomp ";
    // $extraWhere = 'fc.status  = "0"';
    // $extraWhere = 's.deleted=0  AND s.smr_status <> 1 AND dcomp.region_name = "'.$this->session->userdata('region').'" ';
      $extraWhere = 's.deleted=0  AND s.smr_status = 1 AND dcomp.region_name = "'.$this->session->userdata('region').'" ';
    $groupBy = '';
    $having = null;

  echo json_encode(
      SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
  );
  // $this->load->database();
  $this->db->close();
}
}



?>
