
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

  public function view_est_list(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'crs'
      );

      // DB table to use

      $table ="establishment";

      // Table's primary key

      $primaryKey = 'est_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(

           array( 'db' => '`cer`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
             if ($row['status'] == '0') {
               $status  = 'FOR APPROVAL';
             }elseif ($row['status'] == '1') {
                $status  = 'APPROVED';
             }elseif ($row['status'] == '5') {
              $status  = 'FOR APPROVAL/REQUESTED';
             }else {
               $status  = 'DISAPPROVED';
             }
             return $status;
             }),

            // array( 'db' => '`est`.`barangay_id`', 'dt'   => 'barangay_id', 'field' => 'barangay_id'),
            array( 'db' => '`ct`.`name`', 'dt'    => 'name', 'field' => 'name'),
            array( 'db' => '`brgy`.`name`', 'dt'    => 'name', 'field' => 'name'),
            array( 'db' => '`pl`.`name`', 'dt'   => 'name','field' => 'name'),
              // for city

              array( 'db' => '`pl`.`name`', 'dt'     => '1', 'field' => 'name', 'formatter'=>function($x,$row){
                return $row['1'];
                }),
                // for barranggay
                array( 'db' => '`pl`.`name`', 'dt'     => '2', 'field' => 'name', 'formatter'=>function($x,$row){
                  return $row['2'];
                  }),
                  // for province
              array( 'db' => '`pl`.`name`', 'dt'     => '3', 'field' => 'name', 'formatter'=>function($x,$row){
                return $row['3'];
                }),


            array( 'db' => '`cer`.`requested`', 'dt'    => 'requested', 'field' => 'requested'),
            array( 'db' => '`cer`.`client_id`', 'dt'   => 'client_id', 'field' => 'client_id'),
            array( 'db' => '`est`.`establishment`', 'dt'   => 'establishment', 'field' => 'establishment'),
            array( 'db' => '`est`.`est_street`', 'dt'   => 'est_street', 'field' => 'est_street'),
            array( 'db' => '`est`.`est_barangay`', 'dt'   => 'est_barangay', 'field' => 'est_barangay'),
            array( 'db' => '`est`.`date_created`', 'dt'   => 'date_created_sort', 'field' => 'date_created_sort'),
            array( 'db' => '`est`.`date_created`', 'dt'    => 'date_created', 'field' => 'date_created','formatter'=>function($x,$row){
              return date("M j, Y", strtotime($row['date_created']));
            }),
            array( 'db' => '`est`.`est_province`', 'dt'    => 'est_province', 'field' => 'est_province'),
            array( 'db' => '`est`.`est_city`', 'dt'    => 'est_city', 'field' => 'est_city'),
            array( 'db' => '`est`.`est_region`', 'dt'    => 'est_region', 'field' => 'est_region'),
            array( 'db' => '`est`.`plant_manager`', 'dt'    => 'plant_manager', 'field' => 'plant_manager'),
            array( 'db' => '`est`.`plant_manager_phone_no`', 'dt'    => 'plant_manager_phone_no', 'field' => 'plant_manager_phone_no'),
            array( 'db' => '`est`.`pollution_officer`', 'dt'    => 'pollution_officer', 'field' => 'pollution_officer'),
            array( 'db' => '`est`.`pollution_officer_phone_no`', 'dt'    => 'pollution_officer_phone_no', 'field' => 'pollution_officer_phone_no'),
            array( 'db' => '`est`.`pollution_officer_fax_no`', 'dt'    => 'pollution_officer_fax_no', 'field' => 'pollution_officer_fax_no'),
            array( 'db' => '`est`.`pollution_officer_email`', 'dt'    => 'pollution_officer_email', 'field' => 'pollution_officer_email'),

            array( 'db' => '`acc`.`last_name`', 'dt'    => 'last_name', 'field' => 'last_name'),
            array( 'db' => '`acc`.`username`', 'dt'    => 'username', 'field' => 'username'),
            array( 'db' => '`acc`.`first_name`', 'dt'    => 'client_name', 'field' => 'first_name','formatter' =>function($x,$row){
              return $row['first_name'].' '.$row['last_name'];
              }),
            // array( 'db' => '`cl`.`city`', 'dt'    => 'city', 'field' => 'city'),
            array( 'db' => '`est`.`est_id`', 'dt'    => 'est_id', 'field' => 'est_id','formatter'=>function($x,$row){
              return $this->encrypt->encode($row['est_id']);
            }),
            // array( 'db' => '`cer`.`req_id`', 'dt'    => 'req_id', 'field' => 'req_id','formatter'=>function($x,$row){
            //   return $this->encrypt->encode($row['req_id']);
            // }),
              array( 'db' => '`cer`.`req_id`', 'dt'    => 'req_id', 'field' => 'req_id'),
              // array( 'db' => '`cer`.`req_id`', 'dt'    => 'req_id', 'field' => 'req_id','formatter'=>function($x,$row){
              //   return $this->encrypt->encode($row['req_id']);
              // }),

        );
                  // print_r($columns);exit;

      // Include SQL query processing class

    $this->load->view('includes/common/ssp.customized.class.php');



        $joinQuery  = "FROM crs.establishment as est
        LEFT JOIN crs.client_est_requests as cer ON est.cnt = cer.req_id
        LEFT JOIN crs.acc as acc ON acc.client_id = cer.client_id
        LEFT JOIN embis.dms_province AS pl ON pl.id = est.est_province
        LEFT JOIN embis.dms_city as ct ON ct.id = est.est_city
        LEFT JOIN embis.dms_barangay as brgy ON brgy.id = est.est_barangay
        ";
        // $joinQuery  = "FROM crs.client_est_requests as cer
        // LEFT JOIN crs.establishment as est ON est.est_id = cer.est_id
        // ";

        // $extraWhere = 'est.status  = "0" AND est.est_region = "'.$this->session->userdata('region').'"';
          // $extraWhere = '';
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
            $sessreg_id = '15';
      }else {
      $sessreg_id =  $this->session->userdata('region_id');
      }

      // echo $sessreg_id;
          // $extraWhere = 'est.est_region = "'.$sessreg_id.'" AND cer.deleted = "0"
          //               AND cer.status IN ("0","2","5")';
      // $extraWhere = 'cer.status !=1 AND cer.deleted = 0 AND est.est_region = "'.$sessreg_id.'  "';
      $extraWhere = 'cer.status NOT IN ("1","2") AND cer.deleted = 0 AND est.est_region = "'.$sessreg_id.'  "';
                        #0 for pending 2 for disapproved 5 for requested

          // $extraWhere = '';
            // }
        $groupBy = 'cer.req_id';
          // $groupBy = '';
        $having = null;
        // echo $this->db->last_query();
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }
  // for disapproved establishment client request
  public function disapproved_company_lists(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'crs'
      );

      // DB table to use

      $table ="establishment";

      // Table's primary key

      $primaryKey = 'est_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(

           array( 'db' => '`cer`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
               $status  = 'DISAPPROVED';
             return $status;
             }),

            // array( 'db' => '`est`.`barangay_id`', 'dt'   => 'barangay_id', 'field' => 'barangay_id'),
            array( 'db' => '`ct`.`name`', 'dt'    => 'name', 'field' => 'name'),
            array( 'db' => '`brgy`.`name`', 'dt'    => 'name', 'field' => 'name'),
            array( 'db' => '`pl`.`name`', 'dt'   => 'name','field' => 'name'),
              // for city

              array( 'db' => '`pl`.`name`', 'dt'     => '1', 'field' => 'name', 'formatter'=>function($x,$row){
                return $row['1'];
                }),
                // for barranggay
                array( 'db' => '`pl`.`name`', 'dt'     => '2', 'field' => 'name', 'formatter'=>function($x,$row){
                  return $row['2'];
                  }),
                  // for province
              array( 'db' => '`pl`.`name`', 'dt'     => '3', 'field' => 'name', 'formatter'=>function($x,$row){
                return $row['3'];
                }),


            array( 'db' => '`cer`.`requested`', 'dt'    => 'requested', 'field' => 'requested'),
            array( 'db' => '`cer`.`client_id`', 'dt'   => 'client_id', 'field' => 'client_id'),
            array( 'db' => '`est`.`establishment`', 'dt'   => 'establishment', 'field' => 'establishment'),
            array( 'db' => '`est`.`est_street`', 'dt'   => 'est_street', 'field' => 'est_street'),
            array( 'db' => '`est`.`est_barangay`', 'dt'   => 'est_barangay', 'field' => 'est_barangay'),
            array( 'db' => '`est`.`est_province`', 'dt'    => 'est_province', 'field' => 'est_province'),
            array( 'db' => '`est`.`est_city`', 'dt'    => 'est_city', 'field' => 'est_city'),
            array( 'db' => '`est`.`est_region`', 'dt'    => 'est_region', 'field' => 'est_region'),
            array( 'db' => '`est`.`plant_manager`', 'dt'    => 'plant_manager', 'field' => 'plant_manager'),
            array( 'db' => '`est`.`plant_manager_phone_no`', 'dt'    => 'plant_manager_phone_no', 'field' => 'plant_manager_phone_no'),
            array( 'db' => '`est`.`pollution_officer`', 'dt'    => 'pollution_officer', 'field' => 'pollution_officer'),
            array( 'db' => '`est`.`pollution_officer_phone_no`', 'dt'    => 'pollution_officer_phone_no', 'field' => 'pollution_officer_phone_no'),
            array( 'db' => '`est`.`pollution_officer_fax_no`', 'dt'    => 'pollution_officer_fax_no', 'field' => 'pollution_officer_fax_no'),
            array( 'db' => '`est`.`pollution_officer_email`', 'dt'    => 'pollution_officer_email', 'field' => 'pollution_officer_email'),
            array( 'db' => '`acc`.`last_name`', 'dt'    => 'last_name', 'field' => 'last_name'),
            array( 'db' => '`acc`.`first_name`', 'dt'    => 'client_name', 'field' => 'first_name','formatter' =>function($x,$row){
              return $row['first_name'].' '.$row['last_name'];
              }),
            array( 'db' => '`est`.`est_id`', 'dt'    => 'est_id', 'field' => 'est_id','formatter'=>function($x,$row){
              return $this->encrypt->encode($row['est_id']);
            }),
              array( 'db' => '`cer`.`req_id`', 'dt'    => 'req_id', 'field' => 'req_id'),
              //array( 'db' => '`accr`.`fname`', 'dt'    => 'fname', 'field' => 'fname'),
              array( 'db' => '`accr`.`fname`', 'dt'    => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
                if ($row['fname'] == '') {
                  $evaluator = "CRS Admin";
                }else {
                  $evaluator = $row['fname'];
                }
                return $evaluator;
              }),
              array( 'db' => '`est`.`date_created`', 'dt'    => 'date_created', 'field' => 'date_created','formatter'=>function($x,$row){
                return date("M j, Y", strtotime($row['date_created']));
              }),
                  array( 'db' => '`est`.`date_created`', 'dt'    => 'date_created_sort', 'field' => 'date_created'),
              // array( 'db' => '`accr`.`fname`', 'dt'    => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
              //       return $row['fname'].' '$row['sname'];
              // }),

        );
    $this->load->view('includes/common/ssp.customized.class.php');
        $joinQuery  = "FROM crs.establishment as est
        LEFT JOIN crs.client_est_requests as cer ON est.cnt = cer.req_id
        LEFT JOIN crs.acc as acc ON acc.client_id = cer.client_id
        LEFT JOIN embis.dms_province AS pl ON pl.id = est.est_province
        LEFT JOIN embis.dms_city as ct ON ct.id = est.est_city
        LEFT JOIN embis.dms_barangay as brgy ON brgy.id = est.est_barangay
        LEFT JOIN crs.client_request_disapprove as crd ON crd.req_id = cer.req_id
        LEFT JOIN embis.acc_credentials as accr ON accr.userid = crd.disapproved_by
        ";
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
            $sessreg_id = '15';
      }else {
      $sessreg_id =  $this->session->userdata('region_id');
      }

      $extraWhere = 'cer.status = 2 AND cer.deleted = 0 AND est.est_region = "'.$sessreg_id.'"';
        $groupBy = 'cer.req_id';
          // $groupBy = '';
        $having = null;
        // echo $this->db->last_query();
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }

  // for approved companies from client request
  public function approved_company_lists(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
      );

      // DB table to use

      $table ="approved_client_req";

      // Table's primary key

      $primaryKey = 'client_req_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
            array( 'db' => '`dcomp`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
            array( 'db' => '`dcomp`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
            array( 'db' => '`dcomp`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
            array( 'db' => '`dcomp`.`province_name`', 'dt'   => 'province_name', 'field' => 'province_name'),
            array( 'db' => '`dcomp`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
            array( 'db' => '`dcomp`.`province_name`', 'dt'    => 'comp_address', 'field' => 'province_name','formatter'=>function($x,$row){
              return $row['barangay_name'].' , '.$row['city_name'].' , '.$row['province_name'];
              }),
            array( 'db' => '`ac`.`fname`', 'dt'   => 'fname', 'field' => 'fname'),
            array( 'db' => '`acc`.`email`', 'dt'   => 'client_email', 'field' => 'email'),
            array( 'db' => '`acc`.`first_name`', 'dt'   => 'first_name', 'field' => 'first_name'),
            array( 'db' => '`acc`.`last_name`', 'dt'   => 'last_name', 'field' => 'last_name'),
            array( 'db' => '`acc`.`last_name`', 'dt'    => 'client_name', 'field' => 'last_name','formatter'=>function($x,$row){
              return $row['first_name'].' '.$row['last_name'];
            }),
            array( 'db' => '`ac`.`sname`', 'dt'    => 'approved_by', 'field' => 'sname','formatter'=>function($x,$row){
              return $row['fname'].' , '.$row['sname'];
            }),
            array( 'db' => '`est`.`date_created`', 'dt'    => 'date_created', 'field' => 'date_created','formatter'=>function($x,$row){
              return date("M j, Y", strtotime($row['date_created']));
            }),
            array( 'db' => '`acr`.`date_approved`', 'dt'    => 'date_approved', 'field' => 'date_approved','formatter'=>function($x,$row){
              return date("M j, Y", strtotime($row['date_approved']));
            }),
              array( 'db' => '`acr`.`client_req_id`', 'dt'   => 'client_req_id', 'field' => 'client_req_id'),

          );
        $this->load->view('includes/common/ssp.customized.class.php');
        $this->db->cache_on();
        $joinQuery  = "FROM embis.approved_client_req as acr
        INNER JOIN embis.dms_company as dcomp ON acr.company_id = dcomp.company_id
        INNER JOIN embis.acc_credentials as ac ON ac.userid = acr.approved_by
        INNER JOIN crs.acc as acc ON acr.client_id = acc.client_id
        INNER JOIN crs.establishment as est ON est.cnt = acr.req_id
        ";
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
            $sessreg_id = 'NCR';
      }else {
      $sessreg_id =  $this->session->userdata('region');
      }

      // if($_GET['client']) {
      //    $extraWhere = 'acr.deleted = 0 AND dcomp.region_name = "'.$sessreg_id.'" AND acc.client_id = "'.$_GET['client_id'].'"';
      //  }else {
      //    $extraWhere = 'acr.deleted = 0 AND dcomp.region_name = "'.$sessreg_id.'"';
      //  }

        if ($_GET['company']) {
           $extraWhere = 'acr.deleted = 0 AND dcomp.region_name = "'.$sessreg_id.'" AND dcomp.company_id = "'.$_GET['company'].'"';
        }elseif ($_GET['client']){
           $extraWhere = 'acr.deleted = 0 AND dcomp.region_name = "'.$sessreg_id.'" AND acc.client_id = "'.$_GET['client'].'"';
        }else {
        $extraWhere = 'acr.deleted = 0 AND dcomp.region_name = "'.$sessreg_id.'"';
      }
      // $extraWhere = 'acr.deleted = 0 AND dcomp.region_name = "'.$sessreg_id.'"'
      // echo $extraWhere;exit;
      $groupBy = 'acr.client_req_id';
        // $extraWhere = '';
          // $groupBy = '';
        $having = null;
        // echo $this->db->last_query();
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }
  // for approved companies from client request
  public function client_binded_companies(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => 'crs'
      );

      // DB table to use

      $table ="client_binded_companies";

      // Table's primary key

      $primaryKey = 'id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
            array( 'db' => '`cbc`.`client_id`', 'dt'   => 'client_id', 'field' => 'client_id'),
            array( 'db' => '`cbc`.`id`', 'dt'   => 'id', 'field' => 'id'),
            array( 'db' => '`cbc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
            array( 'db' => '`cbc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
            array( 'db' => '`cbc`.`client_req_id`', 'dt'   => 'client_req_id', 'field' => 'client_req_id'),
            array( 'db' => '`cbc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
            array( 'db' => '`cbc`.`first_name`', 'dt'   => 'first_name', 'field' => 'first_name'),
            array( 'db' => '`cbc`.`last_name`', 'dt'   => 'last_name', 'field' => 'last_name'),
            array( 'db' => '`cbc`.`email`', 'dt'   => 'email', 'field' => 'email'),
            array( 'db' => '`cbc`.`approved_by`', 'dt'   => 'approved_by', 'field' => 'approved_by'),
            array( 'db' => '`cbc`.`date_approved`', 'dt'    => 'date_approved', 'field' => 'date_approved','formatter'=>function($x,$row){
              return date("M j, Y", strtotime($row['date_approved']));
            }),
            array( 'db' => '`cbc`.`date_submitted`', 'dt'    => 'date_submitted', 'field' => 'date_submitted','formatter'=>function($x,$row){
              return date("M j, Y", strtotime($row['date_submitted']));
            }),
            array( 'db' => '`cbc`.`client_req_id`', 'dt'   => 'client_req_id', 'field' => 'client_req_id'),

          );
        $this->load->view('includes/common/ssp.customized.class.php');
        $joinQuery  = "FROM crs.client_binded_companies as cbc";
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
            $sessreg_id = 'NCR';
      }else {
      $sessreg_id =  $this->session->userdata('region');
      }

      $extraWhere = 'cbc.deleted = 0 AND cbc.region = "'.$sessreg_id.'"';
      $groupBy = '';
      $having = null;
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }
  // for approved COMPANIES
  public function all_company_lists(){

      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
      );

      // DB table to use

      $table ="dms_company";

      // Table's primary key

      $primaryKey = 'company_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
          array( 'db' => '`dc`.`province_name`', 'dt'   => 'province_name', 'field' => 'province_name'),
          array( 'db' => '`dc`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
          array( 'db' => '`dc`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
          array( 'db' => '`dc`.`street`', 'dt'   => 'street', 'field' => 'street'),
          array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
          array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
          array( 'db' => '`dc`.`input_date`', 'dt'    => 'input_date', 'field' => 'input_date'),
        );
                  // print_r($columns);exit;

      // Include SQL query processing class

    $this->load->view('includes/common/ssp.customized.class.php');



        $joinQuery  = "FROM embis.dms_company as dc ";

        // $extraWhere = 'fc.status  = "0" AND fc.facility_region = "'.$this->session->userdata('region').'"';
          // $extraWhere = '';
      if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
          $extraWhere = 'dc.region_name = "NCR" AND dc.deleted = "0"';
      }else {
          $extraWhere = 'dc.region_name = "'.$this->session->userdata('region').'" AND dc.deleted = "0"';
      }

        // $extraWhere = '';
        $groupBy = '';
        $having = null;
        // echo $this->db->last_query();
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }

  public function iis_resend_hwms_credentials(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => 'embis'
      );

      // DB table to use

      $table ="approved_client_req";

      // Table's primary key

      $primaryKey = 'client_req_id';


       $columns = array(
        array( 'db' => '`acr`.`client_req_id`', 'dt'      => 'client_req_id', 'field' => 'client_req_id'),
        array( 'db' => '`dcomp`.`emb_id`', 'dt'      => 'emb_id', 'field' => 'emb_id'),
        array( 'db' => '`dcomp`.`company_name`', 'dt'      => 'company_name', 'field' => 'company_name'),
        array( 'db' => '`acc`.`first_name`', 'dt'      => 'first_name', 'field' => 'first_name'),
        array( 'db' => '`acc`.`email`', 'dt'      => 'email', 'field' => 'email'),
          array( 'db' => '`dcomp`.`barangay_name`', 'dt'      => 'barangay_name', 'field' => 'barangay_name'),
            array( 'db' => '`dcomp`.`city_name`', 'dt'      => 'city_name', 'field' => 'city_name'),
        array( 'db' => '`dcomp`.`province_name`', 'dt'      => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){
          return $row['barangay_name'].' , '.$row['city_name'].' , '.$row['province_name'];
        }),
        array( 'db' => '`acc`.`last_name`', 'dt'      => 'client_name', 'field' => 'last_name','formatter'=>function($x,$row){
          return $row['first_name'].' '.$row['last_name'];
        }),
        array( 'db' => '`rhc`.`status`', 'dt'      => 'status', 'field' => 'status','formatter'=>function($x,$row){
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

          $this->load->view('includes/common/ssp.customized.class.php');
        $joinQuery  = "FROM approved_client_req as acr
                      LEFT JOIN crs.acc as acc ON acc.client_id = acr.client_id
                      LEFT JOIN embis.dms_company as dcomp ON acr.company_id = dcomp.company_id
                      LEFT JOIN crs.resend_hwms_credentials as rhc ON rhc.req_id = acr.req_id
                        ";

        // $embisdb = $this->load->database('embis',TRUE);
        // $where1 = array('rgnid' => $this->session->userdata('region'), );
        // $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where1)->get()->result_array();

        if(!empty($_GET['company'])){
          $extraWhere = "acr.deleted = 0 AND dcomp.region_name = '".$this->session->userdata('region')."' AND dcomp.company_id = ".$_GET['company']."";
        }else {
          $extraWhere = "acr.deleted = 0 AND dcomp.region_name = '".$this->session->userdata('region')."'";
        }

        $groupBy = '';
        $having = null;
        // echo $this->db->last_query();
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }
}



?>
