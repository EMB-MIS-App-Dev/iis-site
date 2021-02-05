<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);
/*
* segment 1 - dms
* segment 2 - documents
* segment 3 - actions (add, route, revise)
*/
class Main extends CI_Controller
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

      $this->thisdata['user'] = array(
         'id'      => $this->session->userdata('userid'),
         'token'   => $this->session->userdata('token'),
         'region'  => $this->session->userdata('region'),
         'secno'   => $this->session->userdata('secno'),
         'divno'   => $this->session->userdata('divno'),
      );
   }

   function index()
   {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('payment/includes/custom_header');

      $this->thisdata['region_selection'] = $this->Embismodel->selectdata('acc_region', '*', '');

      $this->load->view('payment/dashboard', $this->thisdata);
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

   private function validate_session()
   {
      $where_ucred = array(
         'userid'   => $this->thisdata['user']['id'],
         'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->thisdata['user']['region'] || $session_ucred['secno'] != $this->thisdata['user']['secno'] || $session_ucred['divno'] != $this->thisdata['user']['divno']) {
         $this->thisdata['user'] = array(
            'id'      => $session_ucred['userid'],
            'token'   => $session_ucred['token'],
            'region'  => $session_ucred['region'],
            'secno'   => $session_ucred['secno'],
            'divno'   => $session_ucred['divno'],
         );
      }
   }

   function op_form()
   {
      $this->load->view('payment/order_of_payment');
   }

   function utilities()
   {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('payment/includes/custom_header');

      $this->load->view('payment/utilities');
   }

   function op()
   {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');

      $this->thisdata['orderpayment'] = $this->Embismodel->selectdata( 'op_main_list', '*', array('id' => $this->uri->segment(4), "creator_id" => $this->thisdata['user']['id']) );
      if(empty($this->thisdata['orderpayment'])) { redirect("Payment/Main"); exit; }

      $this->thisdata['op_no'] = $this->uri->segment(4);
      $this->thisdata['item_list'] = $this->Embismodel->selectdata('op_item_list', '*', array('region' => $this->thisdata['user']['region']) );
      $this->thisdata['categories'] = $this->Embismodel->selectdata('op_categories', '*', '');

      $this->load->view('payment/op', $this->thisdata);
   }

   function op_create()
   {
      redirect( base_url('payment/main/op/'.$data[0]['op_number']) );

      exit;
      $data = array(
         'date_created' => date('Y-m-d H:i:s'),
         'creator_id'   => $this->thisdata['user']['id'],
         'region'       =>  $this->thisdata['user']['region'],
      );
      $op_result = $this->Embismodel->insertdata( 'op_main_list', $data );

      if($op_result) {
         $data = $this->db->query('SELECT op.* FROM op_main_list op JOIN (SELECT MAX(id) AS mxid FROM op_main_list WHERE creator_id = "'.$this->thisdata["user"]["id"].'" GROUP BY creator_id ) AS op2 ON op.id = op2.mxid')->result_array();
         redirect( base_url('payment/main/op/'.$data[0]['op_number']) );
      }
      else {
         echo 'ERROR'; exit;
      }
   }

   function op_submit()
   {
      $this->validate_session();

      $post = $this->input->post();
      $op_no = $this->uri->segment(4);

      $data = array(
         "op_token" => $this->thisdata['user']['region'].date('Y').'-'.$post["category"].'-'.$op_no,
         "category" => $post["category"],
         "trans_no" => $post["trans_no"],
         "payor_name" => $post["payor_name"],
         "address" => $post["address"],
         "region" => $this->thisdata['user']["region"],
      );

      echo "<pre>".print_r($data, TRUE)."</pre>"; exit;

      $op_result = $this->Embismodel->updatedata( $data, 'op_main_list', array('id' => $op_no) );

      if($op_result) {
         redirect(base_url('payment/main'));
      }
      else {
         echo 'ERROR'; exit;
      }
   }
}
?>
