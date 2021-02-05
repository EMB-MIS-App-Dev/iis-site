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

    function ecc()
    {
        $region = ($this->input->post('selected_region') == 'CO') ? '' : $this->input->post('selected_region');
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "online_ecc";
        // Table's primary key
        $primaryKey = 'GUID';

        $columns = array(
          array( 'db' => 'GUID', 'dt' => 'GUID', 'field' => 'GUID' ),
          array( 'db' => 'ProjectName', 'dt' => 'ProjectName', 'field' => 'ProjectName' ),
          array( 'db' => 'Address', 'dt' => 'Address', 'field' => 'Address' ),
          array( 'db' => 'Municipality',  'dt' => 'Municipality', 'field' => 'Municipality' ),
          array( 'db' => 'Province',  'dt' => 'Province', 'field' => 'Province' ),
          array( 'db' => 'Region',  'dt' => 'Region', 'field' => 'Region' ),
          array( 'db' => 'Representative',  'dt' => 'Representative', 'field' => 'Representative' ),
          array( 'db' => 'Designation',  'dt' => 'Designation', 'field' => 'Designation' ),
          array( 'db' => 'Status',  'dt' => 'Status', 'field' => 'Status' ),
          array( 'db' => 'ReferenceNo',  'dt' => 'ReferenceNo', 'field' => 'ReferenceNo' ),
          array( 'db' => 'DecisionDate',  'dt' => 'DecisionDate', 'field' => 'DecisionDate' ),
          array( 'db' => 'RoutedToOffice',  'dt' => 'RoutedToOffice', 'field' => 'RoutedToOffice' ),
          array( 'db' => 'RoutedTo',  'dt' => 'RoutedTo', 'field' => 'RoutedTo' ),
          array( 'db' => 'CreatedDate',  'dt' => 'CreatedDate', 'field' => 'CreatedDate' ),
          array( 'db' => 'ProponentName',  'dt' => 'ProponentName', 'field' => 'ProponentName' ),
          array( 'db' => 'MailingAddress',  'dt' => 'MailingAddress', 'field' => 'MailingAddress' ),
          array( 'db' => 'ContactPerson',  'dt' => 'ContactPerson', 'field' => 'ContactPerson' ),
          array( 'db' => 'Expr1',  'dt' => 'Expr1', 'field' => 'Expr1' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM online_ecc ';
        if(!empty($region)) {
          $extraWhere = "region ='".$region."'";
        }
        else {
          $extraWhere = null;
        }
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function hw_generators()
    {
        $region = ($this->input->post('selected_region') == 'CO') ? '' : $this->input->post('selected_region');
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "online_hw_generators";
        // Table's primary key
        $primaryKey = 'id';
        $columns = array(
          array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
          array( 'db' => 'case_handler', 'dt' => 'case_handler', 'field' => 'case_handler' ),
          array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
          array( 'db' => 'province',  'dt' => 'province', 'field' => 'province' ),
          array( 'db' => 'reference_code',  'dt' => 'reference_code', 'field' => 'reference_code' ),
          array( 'db' => 'sub_type',  'dt' => 'sub_type', 'field' => 'sub_type' ),
          array( 'db' => 'accepted_at',  'dt' => 'accepted_at', 'field' => 'accepted_at' ),
          array( 'db' => 'date_issued',  'dt' => 'date_issued', 'field' => 'date_issued' ),
          array( 'db' => 'company',  'dt' => 'company', 'field' => 'company' ),
          array( 'db' => 'address',  'dt' => 'address', 'field' => 'address' ),
          array( 'db' => 'latitude',  'dt' => 'latitude', 'field' => 'latitude' ),
          array( 'db' => 'longitude',  'dt' => 'longitude', 'field' => 'longitude' ),
          array( 'db' => 'pco_name',  'dt' => 'pco_name', 'field' => 'pco_name' ),
          array( 'db' => 'pco_accreditation_no',  'dt' => 'pco_accreditation_no', 'field' => 'pco_accreditation_no' ),
          array( 'db' => 'pco_date_of_accreditation',  'dt' => 'pco_date_of_accreditation', 'field' => 'pco_date_of_accreditation' ),
          array( 'db' => 'pco_email',  'dt' => 'pco_email', 'field' => 'pco_email' ),
          array( 'db' => 'telephone_number',  'dt' => 'telephone_number', 'field' => 'telephone_number' ),
          array( 'db' => 'no_employee',  'dt' => 'no_employee', 'field' => 'no_employee' ),
          array( 'db' => 'code',  'dt' => 'code', 'field' => 'code' ),
          array( 'db' => 'psic_no',  'dt' => 'psic_no', 'field' => 'psic_no' ),
          array( 'db' => 'description',  'dt' => 'description', 'field' => 'description' ),
          array( 'db' => 'details',  'dt' => 'details', 'field' => 'details' ),
          array( 'db' => 'catalogue',  'dt' => 'catalogue', 'field' => 'catalogue' ),
          array( 'db' => 'nature',  'dt' => 'nature', 'field' => 'nature' ),
          array( 'db' => 'waste_mgmt_practice',  'dt' => 'waste_mgmt_practice', 'field' => 'waste_mgmt_practice' ),
          array( 'db' => 'products',  'dt' => 'products', 'field' => 'products' ),
          array( 'db' => 'services',  'dt' => 'services', 'field' => 'services' ),
          array( 'db' => 'nature_business',  'dt' => 'nature_business', 'field' => 'nature_business' ),
          array( 'db' => 'permit_name',  'dt' => 'permit_name', 'field' => 'permit_name' ),
          array( 'db' => 'permit_no',  'dt' => 'permit_no', 'field' => 'permit_no' ),
          array( 'db' => 'permit_date_issued',  'dt' => 'permit_date_issued', 'field' => 'permit_date_issued' ),
          array( 'db' => 'permit_date_expiry',  'dt' => 'permit_date_expiry', 'field' => 'permit_date_expiry' ),
          array( 'db' => 'place_of_issuance',  'dt' => 'place_of_issuance', 'field' => 'place_of_issuance' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM online_hw_generators ';
        if(!empty($region)) {
          $extraWhere = "region ='".$region."'";
        }
        else {
          $extraWhere = null;
        }
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function registered_tsd()
    {
        $region = ($this->input->post('selected_region') == 'CO') ? '' : $this->input->post('selected_region');
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "online_registered_tsd";
        // Table's primary key
        $primaryKey = 'application_id';

        $columns = array(
          array( 'db' => 'application_id', 'dt' => 'application_id', 'field' => 'application_id' ),
          array( 'db' => 'case_handler', 'dt' => 'case_handler', 'field' => 'case_handler' ),
          array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
          array( 'db' => 'province',  'dt' => 'province', 'field' => 'province' ),
          array( 'db' => 'sub_type',  'dt' => 'sub_type', 'field' => 'sub_type' ),
          array( 'db' => 'application_type',  'dt' => 'application_type', 'field' => 'application_type' ),
          array( 'db' => 'date_application_recieved',  'dt' => 'date_application_recieved', 'field' => 'date_application_recieved' ),
          array( 'db' => 'expiry_date',  'dt' => 'expiry_date', 'field' => 'expiry_date' ),
          array( 'db' => 'reference_code',  'dt' => 'reference_code', 'field' => 'reference_code' ),
          array( 'db' => 'date_approved',  'dt' => 'date_approved', 'field' => 'date_approved' ),
          array( 'db' => 'company',  'dt' => 'company', 'field' => 'company' ),
          array( 'db' => 'establish_name',  'dt' => 'establish_name', 'field' => 'establish_name' ),
          array( 'db' => 'address',  'dt' => 'address', 'field' => 'address' ),
          array( 'db' => 'latitude',  'dt' => 'latitude', 'field' => 'latitude' ),
          array( 'db' => 'longitude',  'dt' => 'longitude', 'field' => 'longitude' ),
          array( 'db' => 'pco_name',  'dt' => 'pco_name', 'field' => 'pco_name' ),
          array( 'db' => 'pco_accreditation_no',  'dt' => 'pco_accreditation_no', 'field' => 'pco_accreditation_no' ),
          array( 'db' => 'pco_date_of_accreditation',  'dt' => 'pco_date_of_accreditation', 'field' => 'pco_date_of_accreditation' ),
          array( 'db' => 'pco_email',  'dt' => 'pco_email', 'field' => 'pco_email' ),
          array( 'db' => 'pco_tel_number',  'dt' => 'pco_tel_number', 'field' => 'pco_tel_number' ),
          array( 'db' => 'no_employee',  'dt' => 'no_employee', 'field' => 'no_employee' ),
          array( 'db' => 'permit_name',  'dt' => 'permit_name', 'field' => 'permit_name' ),
          array( 'db' => 'permit_no',  'dt' => 'permit_no', 'field' => 'permit_no' ),
          array( 'db' => 'permit_date_issued',  'dt' => 'permit_date_issued', 'field' => 'permit_date_issued' ),
          array( 'db' => 'permit_date_expiry',  'dt' => 'permit_date_expiry', 'field' => 'permit_date_expiry' ),
          array( 'db' => 'place_of_issuance',  'dt' => 'place_of_issuance', 'field' => 'place_of_issuance' ),
          array( 'db' => 'waste_code',  'dt' => 'waste_code', 'field' => 'waste_code' ),
          array( 'db' => 'waste_description',  'dt' => 'waste_description', 'field' => 'waste_description' ),
          array( 'db' => 'category',  'dt' => 'category', 'field' => 'category' ),
          array( 'db' => 'treatment_method',  'dt' => 'treatment_method', 'field' => 'treatment_method' ),
          array( 'db' => 'description_method',  'dt' => 'description_method', 'field' => 'description_method' ),
          array( 'db' => 'capacity',  'dt' => 'capacity', 'field' => 'capacity' ),
          array( 'db' => 'residual_management',  'dt' => 'residual_management', 'field' => 'residual_management' ),
          array( 'db' => 'total_storage',  'dt' => 'total_storage', 'field' => 'total_storage' ),
          array( 'db' => 'operating_condition',  'dt' => 'operating_condition', 'field' => 'operating_condition' ),
          array( 'db' => 'polution_control',  'dt' => 'polution_control', 'field' => 'polution_control' ),
          array( 'db' => 'name_of_disposal',  'dt' => 'name_of_disposal', 'field' => 'name_of_disposal' ),
          array( 'db' => 'disposal_address',  'dt' => 'disposal_address', 'field' => 'disposal_address' ),
          array( 'db' => 'disposal_capacity',  'dt' => 'disposal_capacity', 'field' => 'disposal_capacity' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM online_registered_tsd ';
        if(!empty($region)) {
          $extraWhere = "region ='".$region."'";
        }
        else {
          $extraWhere = null;
        }
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

    function transporter()
    {
        $region = ($this->input->post('selected_region') == 'CO') ? '' : $this->input->post('selected_region');
        // SQL server connection information
        $sql_details = $this->sql_details;
        // DB table to use
        $table = "online_transporter";
        // Table's primary key
        $primaryKey = 'application_id';

        $columns = array(
          array( 'db' => 'application_id', 'dt' => 'application_id', 'field' => 'application_id' ),
          array( 'db' => 'case_handler', 'dt' => 'case_handler', 'field' => 'case_handler' ),
          array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
          array( 'db' => 'province',  'dt' => 'province', 'field' => 'province' ),
          array( 'db' => 'application_type',  'dt' => 'application_type', 'field' => 'application_type' ),
          array( 'db' => 'reference',  'dt' => 'reference', 'field' => 'reference' ),
          array( 'db' => 'sub_type',  'dt' => 'sub_type', 'field' => 'sub_type' ),
          array( 'db' => 'date_application_recieved',  'dt' => 'date_application_recieved', 'field' => 'date_application_recieved' ),
          array( 'db' => 'date_approved',  'dt' => 'date_approved', 'field' => 'date_approved' ),
          array( 'db' => 'expiry_date',  'dt' => 'expiry_date', 'field' => 'expiry_date' ),
          array( 'db' => 'company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
          array( 'db' => 'address',  'dt' => 'address', 'field' => 'address' ),
          array( 'db' => 'latitude',  'dt' => 'latitude', 'field' => 'latitude' ),
          array( 'db' => 'longitude',  'dt' => 'longitude', 'field' => 'longitude' ),
          array( 'db' => 'pco_name',  'dt' => 'pco_name', 'field' => 'pco_name' ),
          array( 'db' => 'pco_accreditation_no',  'dt' => 'pco_accreditation_no', 'field' => 'pco_accreditation_no' ),
          array( 'db' => 'pco_date_of_accreditation',  'dt' => 'pco_date_of_accreditation', 'field' => 'pco_date_of_accreditation' ),
          array( 'db' => 'pco_email',  'dt' => 'pco_email', 'field' => 'pco_email' ),
          array( 'db' => 'pco_tel_number',  'dt' => 'pco_tel_number', 'field' => 'pco_tel_number' ),
          array( 'db' => 'no_employee',  'dt' => 'no_employee', 'field' => 'no_employee' ),
          array( 'db' => 'waste_code',  'dt' => 'waste_code', 'field' => 'waste_code' ),
          array( 'db' => 'waste_description',  'dt' => 'waste_description', 'field' => 'waste_description' ),
        );
        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM online_transporter ';
        if(!empty($region)) {
          $extraWhere = "region ='".$region."'";
        }
        else {
          $extraWhere = null;
        }
        $groupBy = null;
        $having = null;

        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        $this->db->close();
    }

  }
?>
