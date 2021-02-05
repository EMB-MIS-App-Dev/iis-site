<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Ajax_Data extends CI_Controller
  {
    private $ajaxdata;
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

      $this->ajaxdata['user'] = array(
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
        'userid'   => $this->ajaxdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->ajaxdata['user']['region'] || $session_ucred['secno'] != $this->ajaxdata['user']['secno'] || $session_ucred['divno'] != $this->ajaxdata['user']['divno']) {
        $this->ajaxdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

    private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

    private function prc_personnel_fullname($token="")
    {
      $result = $this->Embismodel->selectdata('acc_credentials', '*', array('token' => $token ) )[0];

      return !empty($result) ? $result['fname'].' '
        .$this->_is_empty($result['mname'][0], '', '. ')
        .$result['sname']
        .$this->_is_empty($result['suffix'], '') : '';
    }

    function total_transactions()
    {
      $result = $this->db->query('SELECT COUNT(DISTINCT(trans_no)) cnt_tno FROM er_transactions_log
                          WHERE receiver_region = "'.$this->ajaxdata['user']['region'].'" ')->result_array();

      echo $result[0]['cnt_tno'];
      // echo $this->db->last_query();
    }

    function count_of_personnel()
    {
      $result = $this->db->query('SELECT COUNT(DISTINCT(userid)) cnt_id FROM acc_function
                          WHERE stat = 1 AND region = "'.$this->ajaxdata['user']['region'].'" ')->result_array();

      echo $result[0]['cnt_id'];
    }

    function count_of_section_unit()
    {
      $this->validate_session();
      $sect_region = $this->ajaxdata['user']['region'] == 'CO' ? $this->ajaxdata['user']['region'] : 'R';
      // $result = $this->db->query('SELECT COUNT(secno) cnt_secno FROM acc_xsect WHERE divno = "'.$this->ajaxdata['user']['divno'].'" AND region = "'.$this->ajaxdata['user']['region'].'" OR region = "'.$sect_region.'" ')->result_array();

      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable', '*', array('region' => $this->ajaxdata['user']['region']) );
      $xsct = '0';
      if(!empty($exclude_sect))
      {
        foreach($exclude_sect as $key => $value) {
          if(count($exclude_sect)-1 == $key) {
            $xsct .= $value['secno'];
          }
          else {
            $xsct .= $value['secno'].',';
          }
        }
      }

      $where['xsect'] = $this->db->where('divno = "'.$this->ajaxdata['user']['divno'].'" AND ( region = "'.$this->ajaxdata['user']['region'].'" OR region = "'.$sect_region.'" ) AND secno NOT IN ('.$xsct.') ');
      $result = $this->Embismodel->selectdata('acc_xsect', 'COUNT(secno) cnt_secno', '', $where['xsect']);


      echo $result[0]['cnt_secno'];
    }

    function trans_per_month_by_div_chart()
    {
      $result = $this->db->query('SELECT date_in, COUNT(DISTINCT(trans_no)) cnt_tno FROM er_transactions_log WHERE YEAR(date_in) = "2020" AND sender_region = "'.$this->ajaxdata['user']['region'].'" GROUP BY MONTH(date_in)')->result_array();

      foreach ($result as $key => $value) {
        $json[] = array('label' => date('F', strtotime($value['date_in'])), 'data' => $value['cnt_tno'] );
      }
      echo json_encode($json);
    }

    function trans_by_section_unit_chart()
    {
      $this->validate_session();

      $result = $this->db->query('SELECT COUNT(ux.trans_no) AS counter, ux.region, ux.divno, case when ux.secno is null or ux.secno = " " then "0" else ux.secno end as secno FROM (SELECT trans_no, sender_region AS region, sender_divno AS divno, sender_secno AS secno FROM er_transactions_log FORCE INDEX (trans_by_sender_x_receiver_idx) WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (83, 51) AND YEAR(date_in) = "'.date("Y").'" AND sender_region = "'.$this->ajaxdata['user']['region'].'" AND sender_divno = "'.$this->ajaxdata['user']['divno'].'" UNION SELECT trans_no, receiver_region AS region, receiver_divno AS divno, receiver_secno AS secno FROM er_transactions_log FORCE INDEX (trans_by_sender_x_receiver_idx) WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (83, 51) AND YEAR(date_in) = "'.date("Y").'" AND receiver_region = "'.$this->ajaxdata['user']['region'].'" AND receiver_divno = "'.$this->ajaxdata['user']['divno'].'" ) AS ux GROUP BY 4 ')->result_array();

      foreach ($result as $key => $value) {
        if(empty($value['secno'])) {
          $div_data = $this->db->query('SELECT divcode, divname FROM acc_xdvsion WHERE divno = "'.$value['divno'].'" ')->result_array();
          $json[] = array('label' => $div_data[0]['divname'], 'code' => $div_data[0]['divcode'], 'data' => $value['counter'] );
        }
        else {
          $sec_data = $this->db->query('SELECT secode, sect FROM acc_xsect WHERE secno = "'.$value['secno'].'" ')->result_array();
          $json[] = array('label' => $sec_data[0]['sect'], 'code' => $sec_data[0]['secode'], 'data' => $value['counter'] );
        }
      }

      echo json_encode($json);
    }

    function chart()
    {
      $result = $this->db->query('SELECT sender_id, sender_name, COUNT(DISTINCT(trans_no)) cnt_tno FROM er_transactions_log
                        WHERE date_in BETWEEN "2020-08-01" AND "2020-09-01" AND sender_region = "'.$this->ajaxdata['user']['region'].'"
                        GROUP BY sender_id DESC ORDER BY cnt_tno DESC')->result_array();

      foreach ($result as $key => $value) {
        $json[] = $value;
      }
      echo json_encode($json);
    }

    function dms_monitoring_userlist()
    {
      $post_data['token'] = $this->input->post('token');
      echo $this->load->view('universe/modal/dms_monitoring_userlist', $post_data);
    }

  } // CLASS END
?>
