<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);
/*
* segment 1 - dms
* segment 2 - documents
* segment 3 - actions (add, route, revise)
*/
class Form_Data extends CI_Controller
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
      echo 'index';
      // $this->load->view('superadmin/pds/personal_info');
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

   function delete_utilities()
   {
      $post = $this->input->post();

      $this->db->trans_start();
      $this->db->delete($post['table'], array("id" => $post['id']) );
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         echo 'success';
      }
   }

   function delete_op_selected_items()
   {
      $post = $this->input->post();

      $this->db->trans_start();
      $this->db->delete('op_selected_items', array( "id" => $post['id'], "op_no" => $post['op_no']) );
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         echo 'success';
      }
   }

   function op_selected_items()
   {
      $post = $this->input->post('post');

      $data = $this->db->where('id = "'.$post['item_id'].'"')->from('op_item_list')->get()->row(0);
      $insert = array(
         "op_no" => $post["op_no"],
         "account_no" => $data->account_no,
         "item_id" => $data->item_id,
         "item_desc" => $data->item_desciption,
         "item_count" => $post['item_count'],
         "fund_code" => $data->fund_code,
         "item_amount" => $data->amount,
         "item_total_amount" => $data->amount * $post['item_count'],
      );

      $this->db->trans_start();
      $this->db->insert('op_selected_items', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         echo 'success';
      }
   }

   function op_categories()
   {
      $post = $this->input->post('post');
      $insert = array(
         "category" => $post["category"],
      );

      $this->db->trans_start();
      $this->db->insert('op_categories', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         echo 'success';
      }
   }

   function op_item_list()
   {
      $post = $this->input->post('post');
      $insert = array(
         "item_desciption" => $post["item_desciption"],
         "fund_code" => $post["fund_code"],
         "account_no" => $post["account_no"],
         "amount" => $post["amount"],
         "region" => $this->thisdata["user"]["region"],
      );

      $this->db->trans_start();
      $this->db->insert('op_item_list', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         echo 'success';
      }
   }

   function op_signatories()
   {
      $post = $this->input->post('post');
      $insert = array(
         // "user_id" => $post["user_id"],
         "name" => $post["name"],
         "title" => $post["title"],
         "region" => $this->thisdata["user"]["region"],
      );

      $this->db->trans_start();
      $this->db->insert('op_signatories', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         echo 'success';
      }
   }

}
?>
