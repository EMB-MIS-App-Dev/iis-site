<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Table_Data extends CI_Controller
  {
    private $thisdata;
    function __construct()
    {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");
      // DATABASE
      $this->sql_details = array(
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db'),
        'host' => $this->session->userdata('host'),
      );
      // USER DETAILS SESSION
      $this->thisdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
    }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->thisdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->thisdata['user']['region'] || $session_ucred['secno'] != $this->thisdata['user']['secno'] || $session_ucred['divno'] != $this->thisdata['user']['divno']) {
        $this->thisdata = array(
          'user_id'     => $session_ucred['userid'],
          'user_region' => $session_ucred['region'],
          'user_token'  => $session_ucred['token'],
        );
        $this->thisdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

    function application()
    {
      $user_id = $this->input->post('user_id');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "pco_application";
      // Table's primary key
      $primaryKey = 'appli_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database, while the `dt`
      // parameter represents the DataTables column identifier
      $columns = array(
      array( 'db' => '`pa`.`appli_id`', 'dt' => 'appli_id', 'field' => 'appli_id' ),
      array( 'db' => '`pa`.`user_id`', 'dt' => 'user_id', 'field' => 'user_id' ),
      array( 'db' => '`pa`.`appli_token`', 'dt' => 'appli_token', 'field' => 'appli_token' ),
      array( 'db' => '`pa`.`step`',     'dt' => 'step',     'field' => 'step' ),
      array( 'db' => '`pa`.`stat_id`', 'dt' => 'stat_id', 'field' => 'stat_id' ),
      array( 'db' => '`pa`.`status`',   'dt' => 'status',   'field' => 'status' ),
      array( 'db' => '`pa`.`remarks`',  'dt' => 'remarks',  'field' => 'remarks' ),
      array( 'db' => '`pa`.`action`',  'dt' => 'action',  'field' => 'action' ),
      array( 'db' => '`pa`.`date_created`',  'dt' => 'date_submitted',  'field' => 'date_created', 'formatter' => function($d, $row){
        return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y, g:i a", strtotime($d)) : '--';
      }  ),
      );

      $this->load->view('includes/common/ssp.customized.class2.php');

      $joinQuery = "FROM pco_application pa ";
      $extraWhere = " pa.stat_id != 0 AND pa.user_id = ".$user_id." ";
      // echo SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere );
      echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
    }

    function educatonal_attainment()
    {
      $user_id = $this->input->post('user_id');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "pco_application";
      // Table's primary key
      $primaryKey = 'user_id';
      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database, while the `dt`
      // parameter represents the DataTables column identifier
      $columns = array(
      array( 'db' => '`user_id`', 'dt' => 'user_id', 'field' => 'user_id' ),
      array( 'db' => '`school`', 'dt' => 'school', 'field' => 'school' ),
      array( 'db' => '`address`', 'dt' => 'address',     'field' => 'address' ),
      array( 'db' => '`inclusive_date`', 'dt' => 'inclusive_date', 'field' => 'inclusive_date' ),
      array( 'db' => '`degree_units_earned`',   'dt' => 'degree_units_earned',   'field' => 'degree_units_earned' ),
      array( 'db' => '`cnt`',   'dt' => 'cnt',   'field' => 'cnt' ),
      );

      // $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = "FROM education_details ";
      $extraWhere = " user_id = ".$user_id." ";

      echo json_encode(
      SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
    }

    function work_exp()
    {
      $user_id = $this->input->post('user_id');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "work_exp";
      // Table's primary key
      $primaryKey = 'user_id';
      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database, while the `dt`
      // parameter represents the DataTables column identifier
      $columns = array(
      array( 'db' => '`user_id`', 'dt' => 'user_id', 'field' => 'user_id' ),
      array( 'db' => '`company`', 'dt' => 'company', 'field' => 'company' ),
      array( 'db' => '`position`', 'dt' => 'position',     'field' => 'position' ),
      array( 'db' => '`inclusive_date`', 'dt' => 'inclusive_date', 'field' => 'inclusive_date' ),
      array( 'db' => '`employment_status`',   'dt' => 'employment_status',   'field' => 'employment_status' ),
      array( 'db' => '`cnt`',   'dt' => 'cnt',   'field' => 'cnt' ),
      );

      // $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = "FROM work_exp ";
      $extraWhere = " user_id = ".$user_id." ";

      echo json_encode(
      SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
    }

    function trainsem_attended()
    {
      $user_id = $this->input->post('user_id');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "trainsem_attended";
      // Table's primary key
      $primaryKey = 'user_id';
      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database, while the `dt`
      // parameter represents the DataTables column identifier
      $columns = array(
      array( 'db' => '`user_id`', 'dt' => 'user_id', 'field' => 'user_id' ),
      array( 'db' => '`qualified`', 'dt' => 'qualified', 'field' => 'qualified' ),
      array( 'db' => '`title`', 'dt' => 'title',     'field' => 'title' ),
      array( 'db' => '`venue`', 'dt' => 'venue', 'field' => 'venue' ),
      array( 'db' => '`conductor`',   'dt' => 'conductor',   'field' => 'conductor' ),
      array( 'db' => '`date_conducted`',   'dt' => 'date_conducted',   'field' => 'date_conducted' ),
      array( 'db' => '`no_hours`',   'dt' => 'no_hours',   'field' => 'no_hours' ),
      array( 'db' => '`cert_no`',   'dt' => 'cert_no',   'field' => 'cert_no' ),
      array( 'db' => '`cnt`',   'dt' => 'cnt',   'field' => 'cnt' ),
      );

      // $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = "FROM trainsem_attended ";
      $extraWhere = " user_id = ".$user_id." ";

      echo json_encode(
      SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
    }
  }
?>
