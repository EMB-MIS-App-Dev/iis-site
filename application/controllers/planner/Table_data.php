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

   function psched_list()
   {
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "psched_list";
      // Table's primary key
      $primaryKey = 'id';

      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'created_by', 'dt' => 'created_by', 'field' => 'created_by' ),
         array( 'db' => 'created_date', 'dt' => 'created_date', 'field' => 'created_date' ),
         array( 'db' => 'activities', 'dt' => 'activities', 'field' => 'activities' ),
         array( 'db' => 'location', 'dt' => 'location', 'field' => 'location' ),
         array( 'db' => 'start_date', 'dt' => 'start_date', 'field' => 'start_date' ),
         array( 'db' => 'end_date', 'dt' => 'end_date', 'field' => 'end_date', 'formatter' => function($x, $row) {
            $start = date("M. j, Y", strtotime($row['start_date']));
            $end = date("M. j, Y", strtotime($x));
            return (!empty($x) && $x != '0000-00-00') ? $start.' - '.$end : $start;
         }),
         array( 'db' => 'compliance', 'dt' => 'compliance', 'field' => 'compliance' ),
         array( 'db' => 'status', 'dt' => 'status', 'field' => 'status' ),
         array( 'db' => 'remarks', 'dt' => 'remarks', 'field' => 'remarks' ),
         array( 'db' => 'area_scope', 'dt' => 'area_scope', 'field' => 'area_scope', 'formatter' => function($d, $row) {
            return implode(', ',explode(';',$d));
         } ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM psched_list';
      $extraWhere = null;
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }

   function accountable()
   {
      // SQL server connection information
      $sched_id = $this->input->post('sched_id');
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "psched_userlist";
      // Table's primary key
      $primaryKey = 'id';
      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'user_id', 'dt' => 'user_id', 'field' => 'user_id' ),
         array( 'db' => 'full_name', 'dt' => 'full_name', 'field' => 'full_name' ),
         array( 'db' => 'div_no', 'dt' => 'div_no', 'field' => 'div_no' ),
         array( 'db' => 'div_name', 'dt' => 'div_name', 'field' => 'div_name' ),
         array( 'db' => 'sec_no', 'dt' => 'sec_no', 'field' => 'sec_no' ),
         array( 'db' => 'sec_name', 'dt' => 'sec_name', 'field' => 'sec_name' ),
         array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
         array( 'db' => 'onevent_status', 'dt' => 'onevent_status', 'field' => 'onevent_status' ),
         array( 'db' => 'user_func', 'dt' => 'user_func', 'field' => 'user_func' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM psched_userlist';
      $extraWhere = 'user_func = "Accountable" AND sched_id = "'.$sched_id.'"';
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }

   function hosts()
   {
      // SQL server connection information
      $sched_id = $this->input->post('sched_id');
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "psched_userlist";
      // Table's primary key
      $primaryKey = 'id';
      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'user_id', 'dt' => 'user_id', 'field' => 'user_id' ),
         array( 'db' => 'full_name', 'dt' => 'full_name', 'field' => 'full_name' ),
         array( 'db' => 'div_no', 'dt' => 'div_no', 'field' => 'div_no' ),
         array( 'db' => 'div_name', 'dt' => 'div_name', 'field' => 'div_name' ),
         array( 'db' => 'sec_no', 'dt' => 'sec_no', 'field' => 'sec_no' ),
         array( 'db' => 'sec_name', 'dt' => 'sec_name', 'field' => 'sec_name' ),
         array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
         array( 'db' => 'onevent_status', 'dt' => 'onevent_status', 'field' => 'onevent_status' ),
         array( 'db' => 'user_func', 'dt' => 'user_func', 'field' => 'user_func' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM psched_userlist';
      $extraWhere = 'user_func = "Host" AND sched_id = "'.$sched_id.'"';
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }

   function participants()
   {
      // SQL server connection information
      $sched_id = $this->input->post('sched_id');
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "psched_userlist";
      // Table's primary key
      $primaryKey = 'id';
      $columns = array(
         array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
         array( 'db' => 'user_id', 'dt' => 'user_id', 'field' => 'user_id' ),
         array( 'db' => 'full_name', 'dt' => 'full_name', 'field' => 'full_name' ),
         array( 'db' => 'div_no', 'dt' => 'div_no', 'field' => 'div_no' ),
         array( 'db' => 'div_name', 'dt' => 'div_name', 'field' => 'div_name' ),
         array( 'db' => 'sec_no', 'dt' => 'sec_no', 'field' => 'sec_no' ),
         array( 'db' => 'sec_name', 'dt' => 'sec_name', 'field' => 'sec_name' ),
         array( 'db' => 'region', 'dt' => 'region', 'field' => 'region' ),
         array( 'db' => 'onevent_status', 'dt' => 'onevent_status', 'field' => 'onevent_status' ),
         array( 'db' => 'user_func', 'dt' => 'user_func', 'field' => 'user_func' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM psched_userlist';
      $extraWhere = 'user_func = "Participant" AND sched_id = "'.$sched_id.'"';
      $groupBy = null;
      $having = null;

      echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
   }
}
?>
