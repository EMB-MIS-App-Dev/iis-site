<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Complist_server_side extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');

  }

  public function complist_server_side_data(){
      // $accid = $this->session->userdata('accid');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
      );

      // DB table to use

      $table ="dms_company";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(

           // array( 'db' => '`acc`.`sname`', 'dt'     => 'sname', 'field' => 'sname', 'formatter'=>function($x,$row){
           //   $fullname = $row['sname']." ".$row['fname'];
           //   return $fullname;
           //   }),
            // array( 'db' => '`dc`.`barangay_id`', 'dt'   => 'barangay_id', 'field' => 'barangay_id'),
            array( 'db' => '`dc`.`cnt`', 'dt'   => 'cnt', 'field' => 'cnt'),
            // echo date("d.m.Y H:i:s", strtotime($date));
            // array( 'db' => '`dc`.`input_date`', 'dt'   => 'input_date', 'field' => 'input_date'),
            array( 'db' => '`dc`.`input_date`', 'dt'    => 'input_date', 'field' => 'input_date','formatter'=>function($x,$row){

                return date("M j, Y", strtotime($row['input_date']));
              }),
                array( 'db' => '`dc`.`establishment_name`', 'dt'   => 'establishment_name', 'field' => 'establishment_name'),
            array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
            array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
            array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
            array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
            array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
            // array( 'db' => '`dc`.`category`', 'dt'    => 'category', 'field' => 'category'),
            array( 'db' => '`dc`.`category`', 'dt'    => 'category', 'field' => 'category','formatter'=>function($x,$row){
              if ($row['company_type'] == $row['company_id'] || $row['company_type'] == 0) {
                $category = 'MAIN';
              }else {
                $category = 'BRANCH - '.$row['company_type'];
              }

              return $category;
              }),
            array( 'db' => '`dc`.`project_type`', 'dt'    => 'project_type', 'field' => 'project_type'),
            array( 'db' => '`dc`.`token`', 'dt'   => 'token', 'field' => 'token'),
            array( 'db' => '`dc`.`province_id`', 'dt'   => 'province_id', 'field' => 'province_id'),
            array( 'db' => '`dc`.`city_id`', 'dt'   => 'city_id', 'field' => 'city_id'),
            array( 'db' => '`dc`.`project_name`', 'dt'    => 'project_name', 'field' => 'project_name'),
            // array( 'db' => '`dc`.`project_name`', 'dt'    => 'project_name', 'field' => 'project_name'),
        );
                  // print_r($columns);exit;

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        // $joinQuery = "FROM embis.dms_company AS dc LEFT JOIN embis.dms_project_type AS dpt ON dc.project_type=dpt.proid WHERE dc.deleted = 0";
        // $joinQuery = "FROM embis.acc_credentials AS acc
        //                JOIN embis.supp_main AS sp ON sp.userid=acc.userid";
        $joinQuery="FROM embis.dms_company AS dc";
        // $extraWhere = 'dc.region_name  = "'.$_SESSION['region'].'" AND dc.deleted  = 0 OR dc.jurisdiction = 2';
        $extraWhere = 'dc.region_name  = "'.$_SESSION['region'].'" AND dc.deleted  = 0';
        $groupBy = '';
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->load->database();
      $this->db->close();
  }

  public function main_company_list(){
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
            'db'   => 'embis'
        );
        $table ="dms_company";
        $primaryKey = 'cnt';
         $columns = array(
             array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
              array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
              array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
              array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
              array( 'db' => '`dc`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
                array( 'db' => '`dc`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
            // array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
            array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){


              return $row['province_name'].','.$row['city_name'].','.$row['barangay_name'];
              }),
          );

          $this->load->view('includes/common/ssp.customized.class.php');
          $joinQuery="FROM embis.dms_company AS dc";
          if($_GET['region']) {
            $extraWhere = 'dc.region_name  = "'.$_GET['region'].'" AND dc.deleted  = 0';
          }else {
            $extraWhere = 'dc.region_name  = "'.$_SESSION['main_company_region'].'" AND dc.deleted  = 0 AND dc.company_id  = "'.$_SESSION['main_company_id'].'"';
           }
          $groupBy = '';
          $having = null;

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
  public function add_main_company_list(){
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
            'db'   => 'embis'
        );
        $table ="dms_company";
        $primaryKey = 'cnt';
         $columns = array(
             array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
              array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
              array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
              array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
              array( 'db' => '`dc`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
                array( 'db' => '`dc`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
            // array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
            array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){


              return $row['province_name'].','.$row['city_name'].','.$row['barangay_name'];
              }),
          );

          $this->load->view('includes/common/ssp.customized.class.php');
          $joinQuery="FROM embis.dms_company AS dc";
          if($_GET['region']) {
            $extraWhere = 'dc.region_name  = "'.$_GET['region'].'" AND dc.deleted  = 0';
          }else {
            $extraWhere = 'dc.deleted  = 0 ';
           }
          $groupBy = '';
          $having = null;

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
  public function all_company_list(){
          $dbDetails = array(
            'host' => $this->session->userdata('host'),
            'user' => $this->session->userdata('user'),
            'pass' => $this->session->userdata('pass'),
            'db'   => 'embis'
          );
          $table ="dms_company";
          $primaryKey = 'cnt';
           $columns = array(
               array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
                array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
                array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
                array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
                  array( 'db' => '`dc`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
                    array( 'db' => '`dc`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
                // array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
                array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){


                  return $row['province_name'].','.$row['city_name'].','.$row['barangay_name'];
                  }),
            );

            $this->load->view('includes/common/ssp.customized.class.php');
            $joinQuery="FROM embis.dms_company AS dc";
            if($_GET['region']) {
              $extraWhere = 'dc.region_name  = "'.$_GET['region'].'" AND dc.deleted  = 0';
            }else {
              $extraWhere = 'dc.deleted  = 0 ';
             }
            $groupBy = '';
            $having = null;

          echo json_encode(
              SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
          );
          $this->load->database();
          $this->db->close();
    }

  public function view_all_complist_server_side_data(){

      // $accid = $this->session->userdata('accid');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
      );

      // DB table to use

      $table ="dms_company";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(

           // array( 'db' => '`acc`.`sname`', 'dt'     => 'sname', 'field' => 'sname', 'formatter'=>function($x,$row){
           //   $fullname = $row['sname']." ".$row['fname'];
           //   return $fullname;
           //   }),
            // array( 'db' => '`dc`.`barangay_id`', 'dt'   => 'barangay_id', 'field' => 'barangay_id'),
            array( 'db' => '`dc`.`cnt`', 'dt'   => 'cnt', 'field' => 'cnt'),
            // echo date("d.m.Y H:i:s", strtotime($date));
            // array( 'db' => '`dc`.`input_date`', 'dt'   => 'input_date', 'field' => 'input_date'),
            array( 'db' => '`dc`.`input_date`', 'dt'    => 'input_date', 'field' => 'input_date','formatter'=>function($x,$row){

                return date("M j, Y", strtotime($row['input_date']));
              }),
                array( 'db' => '`dc`.`establishment_name`', 'dt'   => 'establishment_name', 'field' => 'establishment_name'),
            array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
            array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
            array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
            array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
            array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
            // array( 'db' => '`dc`.`category`', 'dt'    => 'category', 'field' => 'category'),
            array( 'db' => '`dc`.`category`', 'dt'    => 'category', 'field' => 'category','formatter'=>function($x,$row){
              if ($row['company_type'] == $row['company_id'] ) {
                $category = 'MAIN';
              }else {
                $category = 'BRANCH - '.$row['company_type'];
              }

              return $category;
              }),
            array( 'db' => '`dc`.`project_type`', 'dt'    => 'project_type', 'field' => 'project_type'),
            array( 'db' => '`dc`.`token`', 'dt'   => 'token', 'field' => 'token'),
            array( 'db' => '`dc`.`province_id`', 'dt'   => 'province_id', 'field' => 'province_id'),
            array( 'db' => '`dc`.`city_id`', 'dt'   => 'city_id', 'field' => 'city_id'),
            array( 'db' => '`dc`.`project_name`', 'dt'    => 'project_name', 'field' => 'project_name'),
            // array( 'db' => '`dc`.`project_name`', 'dt'    => 'project_name', 'field' => 'project_name'),
        );
                  // print_r($columns);exit;

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        // $joinQuery = "FROM embis.dms_company AS dc LEFT JOIN embis.dms_project_type AS dpt ON dc.project_type=dpt.proid WHERE dc.deleted = 0";
        // $joinQuery = "FROM embis.acc_credentials AS acc
        //                JOIN embis.supp_main AS sp ON sp.userid=acc.userid";
        $joinQuery="FROM embis.dms_company AS dc";
        // $extraWhere = 'dc.region_name  = "'.$_SESSION['region'].'" AND dc.deleted  = 0 OR dc.jurisdiction = 2';
        $extraWhere = '';
        $groupBy = '';
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->load->database();
      $this->db->close();
  }

}
?>
