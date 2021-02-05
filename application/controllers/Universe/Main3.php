<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Main3 extends CI_Controller
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
      $this->load->view('includes/common/univ_styles');

      // $data['yearly_transactions'] = $this->db->query('SELECT COUNT(*) AS counter FROM ( SELECT trans_no, sender_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND YEAR(date_in) = "'.date("Y").'" AND sender_id != "15dde182bae172" UNION ALL SELECT trans_no, receiver_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND YEAR(date_in) = "'.date("Y").'" AND sender_id != "15dde182bae172" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux WHERE ux.region = "'.$this->thisdata['user']['region'].'" ')->result_array();
      //
      // $data['newly_created'] = $this->db->query('SELECT COUNT(DISTINCT(trans_no)) AS counter FROM er_transactions_log WHERE route_order = 1 AND status != 0 AND type != 0 AND sender_id != "15dde182bae172" AND sender_region = "'.$this->thisdata['user']['region'].'" AND DATE(date_in) = "'.date("Y-m-d",strtotime("-1 days")).'" ')->result_array();
      //
      // $data['daily_transactions'] = $this->db->query('SELECT COUNT(*) AS counter FROM ( SELECT trans_no, sender_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND DATE(date_in) = "'.date("Y-m-d",strtotime("-1 days")).'" AND sender_id != "15dde182bae172" AND sender_region = "'.$this->thisdata['user']['region'].'" UNION ALL SELECT trans_no, receiver_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND DATE(date_in) = "'.date("Y-m-d",strtotime("-1 days")).'" AND receiver_region = "'.$this->thisdata['user']['region'].'" AND sender_region != "'.$this->thisdata['user']['region'].'" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux WHERE ux.region = "'.$this->thisdata['user']['region'].'" ')->result_array();

      // $data['ecc'] = $ this->db->query('SELECT COUNT(GUID) AS counter FROM online_ecc ')->result_array();

      $region = ($this->thisdata['user']['region'] == 'CO') ? '1' : 'region = "'.$this->thisdata['user']['region'].'"';
      $data['transporter'] = $this->db->query('SELECT COUNT(application_id) AS counter FROM online_transporter WHERE '.$region.' ')->result_array()[0];
      $data['registered_tsd'] = $this->db->query('SELECT COUNT(application_id) AS counter FROM online_registered_tsd WHERE '.$region.' ')->result_array()[0];
      $data['hw_generators'] = $this->db->query('SELECT COUNT(id) AS counter FROM online_hw_generators WHERE '.$region.' ')->result_array()[0];
      
      $ecc['approved'] = $this->db->query('SELECT COUNT(GUID) AS counter FROM online_ecc WHERE Status = "Approved" ')->result_array();
      echo "<pre>".print_r($data, TRUE)."</pre>";
      //
      // Cordillera Administrative Region
      // National Capital Region
      // Region 1
      // Region 10
      // Region 11
      // Region 12
      // Region 13
      // Region 2
      // Region 3
      // Region 4A
      // Region 4B
      // Region 5
      // Region 6
      // Region 7
      // Region 8
      // Region 9
      //
      echo 'registered_tsd= '.$data['registered_tsd'][0]['counter'];
      exit;

      $data['user'] = $this->thisdata['user'];

      // $this->load->view('universe/statistics_test_2', $data);
    }

  }
?>
