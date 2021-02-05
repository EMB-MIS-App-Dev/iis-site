<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);
/*
* segment 1 - dms
* segment 2 - documents
* segment 3 - actions (add, route, revise)
*/
class Table_data extends CI_Controller
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

   function order_of_payment()
   {
      $region = empty($this->input->post('selected_region')) ? '' : $this->input->post('selected_region');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "order_of_payment";
      // Table's primary key
      $primaryKey = 'op_number';

      $columns = array(
         array( 'db' => 'op_number', 'dt' => 'op_number', 'field' => 'op_number' ),
         array( 'db' => 'trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
         array( 'db' => 'trans_type', 'dt' => 'trans_type', 'field' => 'trans_type' ),
         array( 'db' => 'region',  'dt' => 'region', 'field' => 'region' ),
         array( 'db' => 'emb_user_id',  'dt' => 'emb_user_id', 'field' => 'emb_user_id' ),
         array( 'db' => 'proponent_name',  'dt' => 'proponent_name', 'field' => 'proponent_name' ),
         array( 'db' => 'plant_address',  'dt' => 'plant_address', 'field' => 'plant_address' ),
         array( 'db' => 'account_no',  'dt' => 'account_no', 'field' => 'account_no' ),
         array( 'db' => 'item_count',  'dt' => 'item_count', 'field' => 'item_count' ),
         array( 'db' => 'amount',  'dt' => 'amount', 'field' => 'amount' ),
         array( 'db' => 'date',  'dt' => 'date', 'field' => 'date' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM order_of_payment ';
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

   function op_selected_items()
   {
      $op_no = $this->input->post('op_no');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "op_selected_items";
      // Table's primary key
      $primaryKey = 'id';

      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'op_no', 'dt' => 'op_no', 'field' => 'op_no' ),
         array( 'db' => 'account_no', 'dt' => 'account_no', 'field' => 'account_no' ),
         array( 'db' => 'item_desc', 'dt' => 'item_desc', 'field' => 'item_desc' ),
         array( 'db' => 'item_count', 'dt' => 'item_count', 'field' => 'item_count' ),
         array( 'db' => 'fund_code', 'dt' => 'fund_code', 'field' => 'fund_code' ),
         array( 'db' => 'item_amount', 'dt' => 'item_amount', 'field' => 'item_amount' ),
         array( 'db' => 'item_total_amount', 'dt' => 'item_total_amount', 'field' => 'item_total_amount' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM op_selected_items';
      $extraWhere = 'op_no = "'.$op_no.'"';
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }

   function op_categories()
   {
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "op_categories";
      // Table's primary key
      $primaryKey = 'id';

      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'category', 'dt' => 'category', 'field' => 'category' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM op_categories';
      $extraWhere = null;
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }

   function op_item_list()
   {
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "op_item_list";
      // Table's primary key
      $primaryKey = 'id';

      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'item_desciption', 'dt' => 'item_desciption', 'field' => 'item_desciption' ),
         array( 'db' => 'fund_code', 'dt' => 'fund_code', 'field' => 'fund_code' ),
         array( 'db' => 'account_no', 'dt' => 'account_no', 'field' => 'account_no' ),
         array( 'db' => 'amount', 'dt' => 'amount', 'field' => 'amount' ),
         array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM op_item_list';
      $extraWhere = null;
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }

   function op_signatories()
   {
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "op_signatories";
      // Table's primary key
      $primaryKey = 'id';

      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'user_id', 'dt' => 'user_id', 'field' => 'user_id' ),
         array( 'db' => 'name', 'dt' => 'name', 'field' => 'name' ),
         array( 'db' => 'title', 'dt' => 'title', 'field' => 'title' ),
         array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' )
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM op_signatories ';
      $extraWhere = null;
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }
}
?>
