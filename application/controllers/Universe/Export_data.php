<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Export_data extends CI_Controller
  {
    private $univdata;
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

      $this->univdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
    }

    function index()
    {
      $result = $this->db->query('SELECT et.token, et.company_name, et.emb_id, et.type_description, etl.subject, etl.sender_name, etl.sender_region, etl.receiver_name, etl.receiver_region, etl.status_description, etl.action_taken, etl.remarks, etl.date_in, etl.date_out FROM er_transactions_log etl JOIN er_transactions et ON (et.trans_no = etl.trans_no) WHERE etl.trans_no = et.trans_no AND etl.route_order != 0 AND etl.status != 0 AND etl.multiprc != 1 AND et.type NOT IN (0, 83, 51) AND YEAR(etl.date_in) = "'.date("Y").'" AND (etl.sender_region = "'.$this->univdata['user']['region'].'" OR etl.receiver_region = "'.$this->univdata['user']['region'].'") AND etl.sender_id != "15dde182bae172" AND etl.receiver_id NOT IN ("", "15dde182bae172")  ')->result_array();


      echo $this->db->last_query(); exit;

      // $this->load->view('unverse/export/trans_per_month');
    }

    // private function validate_session()
    // {
    //   $where_ucred = array(
    //     'userid'   => $this->univdata['user']['id'],
    //     'verified' => 1,
    //   );
    //   $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];
    //
    //   if($session_ucred['region'] != $this->univdata['user']['region'] || $session_ucred['secno'] != $this->univdata['user']['secno'] || $session_ucred['divno'] != $this->univdata['user']['divno']) {
    //     $this->univdata['user'] = array(
    //       'id'      => $session_ucred['userid'],
    //       'token'   => $session_ucred['token'],
    //       'region'  => $session_ucred['region'],
    //       'secno'   => $session_ucred['secno'],
    //       'divno'   => $session_ucred['divno'],
    //     );
    //   }
    // }

    // private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

    // private function prc_personnel_fullname($token="")
    // {
    //   $result = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $token ) )[0];
    //
    //   return !empty($result) ? $result['fname'].' '
    //     .$this->_is_empty($result['mname'][0], '', '. ')
    //     .$result['sname']
    //     .$this->_is_empty($result['suffix'], '') : '';
    // }

  } // CLASS END
?>
