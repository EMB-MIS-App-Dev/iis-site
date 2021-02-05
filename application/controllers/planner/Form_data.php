<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);
/*
* segment 1 - dms
* segment 2 - documents
* segment 3 - actions (add, route, revise)
*/
class Form_data extends CI_Controller
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

   private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

   private function user_details($token="")
   {
      $result = $this->db->where('token = "'.$token.'"')->from('acc_credentials')->get()->row(0);
      if($result) {
         $data['no_error'] = true;
         $data['region'] = $result->region;
         $data['user_id'] = $result->userid;
         $data['full_name'] = !empty($result) ? $this->_is_empty($result->title, '', ' ')
                              .$result->fname.' '
                              .$this->_is_empty($result->mname[0], '', '. ')
                              .$result->sname.' '
                              .$this->_is_empty($result->suffix, '') : '-unregistered-';
      }
      else {
         $data['no_error'] = false;
      }
      return $data;
   }

   function psched_userlist()
   {
      $post = $this->input->post('post');
      $sched_id = $this->input->post('sched_id');

      $region = $post['region'];
      $division = explode(';', $post['division']);
      $section = explode(';', $post['section']);
      $personnel_list = $post['personnel'];
      $insert = array();

      // if($region == 'all') {
      //    $personnel_list = $this->db->where('func.stat = 1 AND cred.verified = 1')->get()->result_array();
      //    $id_all = true;
      // }
      // else if($division[0] == 'all') {
      //    $personnel_list = $this->db->where('func.stat = 1 AND cred.verified = 1 AND cred.region = "'.$region.'"')->get()->result_array();
      //    $id_all = true;
      // }
      // else if($section[0] == 'all') {
      //    $personnel_list = $this->db->where('func.stat = 1 AND cred.verified = 1 AND cred.region = "'.$region.'" AND func.divno = "'.$division[0].'"')->get()->result_array();
      //    $id_all = true;
      // }
      // else {
      //    ->join('acc_xdvsion div', 'func.userid = div.userid')
      //    $personnel_list = $this->db->where('func.stat = 1 AND cred.verified = 1 AND cred.region = "'.$region.'" AND func.divno = "'.$division[0].'"')->get()->result_array();
      // }

      if($section[0] == -1) {
         $section[0] = 0;
         $section[1] = $division[1].' - HEAD';
      }

      foreach ($personnel_list as $key => $personnel) {
         // if($id_all) {
            // $user_details = $this->user_details($personnel['token']);
         // } else {
            $user_details = $this->user_details($personnel);
         // }

         if(!empty($user_details['full_name'])) {
            $insert[$key] = array(
               "sched_id"        => $sched_id,
               "user_id"         => $user_details['user_id'],
               "full_name"       => $user_details['full_name'],
               "div_no"          => $division[0],
               "div_name"        => $division[1],
               "sec_no"          => $section[0],
               "sec_name"        => $section[1],
               "region"          => $post['region'],
               "user_func"       => $post['user_func'],
            );
         }
      }
      // print_r($insert); exit;

      $this->db->trans_start();
      $this->db->insert_batch('psched_userlist', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
   }


} // CLASS END
?>
