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

    private function array_debug($data='') { $data['data'] = $data; $this->load->view('Dms/debug', $data); }

    private function _alert($alert_data="", $redirect_page="", $code="", $type="")
    {
      $asd = '';
      if(empty($alert_data)) {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'You have Accessed an Unidentified Page and have been Redirected to this Page. '.$code,
          'type'      => 'warning',
        );
      }
      else {
        if(!empty($code)) {
          $alert_data['text'] = $alert_data['text'].' '.$code;
        }
      }
      if(empty($type)) {
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
      }
      else {
        $this->session->set_flashdata('swal_alert_data', $alert_data);
      }

      if(empty($redirect_page)) {
        $redirect_page = base_url('dms/documents/all');
      }
      redirect($redirect_page);
    }

    private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

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

    function pds_children()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_children";
        // Table's primary key
        $primaryKey = 'id';

        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'name', 'dt' => 'name', 'field' => 'name' ),
          array( 'db' => 'date_of_birth',  'dt' => 'date_of_birth', 'field' => 'date_of_birth', 'formatter' => function($d, $row){
            return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y", strtotime($d)) : '--';
          } ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_children ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_educational_background()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_educational_background";
        // Table's primary key
        $primaryKey = 'id';

        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'level', 'dt' => 'level', 'field' => 'level' ),
          array( 'db' => 'name_of_school', 'dt' => 'name_of_school', 'field' => 'name_of_school' ),
          array( 'db' => 'basic_education_degree_course', 'dt' => 'basic_education_degree_course', 'field' => 'basic_education_degree_course' ),
          array( 'db' => 'attendance_from', 'dt' => 'attendance_from', 'field' => 'attendance_from' ),
          array( 'db' => 'attendance_to', 'dt' => 'attendance_to', 'field' => 'attendance_to' ),
          array( 'db' => 'highest_level_unit_earned', 'dt' => 'highest_level_unit_earned', 'field' => 'highest_level_unit_earned' ),
          array( 'db' => 'year_graduated', 'dt' => 'year_graduated', 'field' => 'year_graduated' ),
          array( 'db' => 'scholarship_honor_received', 'dt' => 'scholarship_honor_received', 'field' => 'scholarship_honor_received' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_educational_background ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_civil_service()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_civil_service";
        // Table's primary key
        $primaryKey = 'id';

        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'eligibility_description', 'dt' => 'eligibility_description', 'field' => 'eligibility_description' ),
          array( 'db' => 'rating', 'dt' => 'rating', 'field' => 'rating' ),
          array( 'db' => 'date_of_examination', 'dt' => 'date_of_examination', 'field' => 'date_of_examination' ),
          array( 'db' => 'place_of_examination', 'dt' => 'place_of_examination', 'field' => 'place_of_examination' ),
          array( 'db' => 'license_no', 'dt' => 'license_no', 'field' => 'license_no' ),
          array( 'db' => 'date_of_validity', 'dt' => 'date_of_validity', 'field' => 'date_of_validity' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_civil_service ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_work_experience()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_work_experience";
        // Table's primary key
        $primaryKey = 'id';

        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'inclusive_dates_from', 'dt' => 'inclusive_dates_from', 'field' => 'inclusive_dates_from' ),
          array( 'db' => 'inclusive_dates_to', 'dt' => 'inclusive_dates_to', 'field' => 'inclusive_dates_to' ),
          array( 'db' => 'position_title', 'dt' => 'position_title', 'field' => 'position_title' ),
          array( 'db' => 'company', 'dt' => 'company', 'field' => 'company' ),
          array( 'db' => 'monthly_salary', 'dt' => 'monthly_salary', 'field' => 'monthly_salary' ),
          array( 'db' => 'salary_grade_and_step', 'dt' => 'salary_grade_and_step', 'field' => 'salary_grade_and_step' ),
          array( 'db' => 'status_of_appointment', 'dt' => 'status_of_appointment', 'field' => 'status_of_appointment' ),
          array( 'db' => 'is_government', 'dt' => 'is_government', 'field' => 'is_government' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_work_experience ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_voluntary_work()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_voluntary_work";
        // Table's primary key
        $primaryKey = 'id';

        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'name_address_of_organization', 'dt' => 'name_address_of_organization', 'field' => 'name_address_of_organization' ),
          array( 'db' => 'inclusive_dates_from', 'dt' => 'inclusive_dates_from', 'field' => 'inclusive_dates_from' ),
          array( 'db' => 'inclusive_dates_to', 'dt' => 'inclusive_dates_to', 'field' => 'inclusive_dates_to' ),
          array( 'db' => 'no_of_hours', 'dt' => 'no_of_hours', 'field' => 'no_of_hours' ),
          array( 'db' => 'position_nature_of_work', 'dt' => 'position_nature_of_work', 'field' => 'position_nature_of_work' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_voluntary_work ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_learning_development()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_learning_development";
        // Table's primary key
        $primaryKey = 'id';
        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'title', 'dt' => 'title', 'field' => 'title' ),
          array( 'db' => 'inclusive_dates_from', 'dt' => 'inclusive_dates_from', 'field' => 'inclusive_dates_from' ),
          array( 'db' => 'inclusive_dates_to', 'dt' => 'inclusive_dates_to', 'field' => 'inclusive_dates_to' ),
          array( 'db' => 'no_of_hours', 'dt' => 'no_of_hours', 'field' => 'no_of_hours' ),
          array( 'db' => 'type_of_ld', 'dt' => 'type_of_ld', 'field' => 'type_of_ld' ),
          array( 'db' => 'conducted_by', 'dt' => 'conducted_by', 'field' => 'conducted_by' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_learning_development ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_other_info()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_other_info";
        // Table's primary key
        $primaryKey = 'id';
        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'skills_and_hobbies', 'dt' => 'skills_and_hobbies', 'field' => 'skills_and_hobbies' ),
          array( 'db' => 'non_academic_distinctions', 'dt' => 'non_academic_distinctions', 'field' => 'non_academic_distinctions' ),
          array( 'db' => 'membership', 'dt' => 'membership', 'field' => 'membership' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_other_info ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function pds_person_references()
    {
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "pds_person_references";
        // Table's primary key
        $primaryKey = 'id';
        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'userid', 'dt' => 'userid', 'field' => 'userid' ),
          array( 'db' => 'name', 'dt' => 'name', 'field' => 'name' ),
          array( 'db' => 'address', 'dt' => 'address', 'field' => 'address' ),
          array( 'db' => 'tel_no', 'dt' => 'tel_no', 'field' => 'tel_no' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM pds_person_references ';
        $extraWhere = "userid ='".$this->thisdata['user']['id']."'";
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }
  }
?>
