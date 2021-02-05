<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Ajax_Data_Test extends CI_Controller
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
      $this->univdata['year_selected'] = !empty($this->input->get('year')) ? $this->input->get('year') : date('Y');
    }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->univdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->univdata['user']['region'] || $session_ucred['secno'] != $this->univdata['user']['secno'] || $session_ucred['divno'] != $this->univdata['user']['divno']) {
        $this->univdata['user'] = array(
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
                          WHERE receiver_region = "'.$this->univdata['user']['region'].'" AND (YEAR(date_in) = "'.$this->univdata['year_selected'].'" OR YEAR(date_out) = "'.$this->univdata['year_selected'].'") ')->result_array();

      echo $result[0]['cnt_tno'];
      // echo $this->db->last_query();
    }

    function count_of_personnel()
    {
      $result = $this->db->query('SELECT COUNT(DISTINCT(userid)) cnt_id FROM acc_function
                          WHERE stat = 1 AND region = "'.$this->univdata['user']['region'].'" ')->result_array();

      echo $result[0]['cnt_id'];
    }

    function count_of_section_unit()
    {
      $this->validate_session();
      $sect_region = $this->univdata['user']['region'] == 'CO' ? $this->univdata['user']['region'] : 'R';
      // $result = $this->db->query('SELECT COUNT(secno) cnt_secno FROM acc_xsect WHERE divno = "'.$this->univdata['user']['divno'].'" AND region = "'.$this->univdata['user']['region'].'" OR region = "'.$sect_region.'" ')->result_array();

      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable', '*', array('region' => $this->univdata['user']['region']) );
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

      $where['xsect'] = $this->db->where('divno = "'.$this->univdata['user']['divno'].'" AND ( region = "'.$this->univdata['user']['region'].'" OR region = "'.$sect_region.'" ) AND secno NOT IN ('.$xsct.') ');
      $result = $this->Embismodel->selectdata('acc_xsect', 'COUNT(secno) cnt_secno', '', $where['xsect']);


      echo $result[0]['cnt_secno'];
    }

    function trans_per_month_chart()
    {
      $result = $this->db->query('SELECT date_in, COUNT(DISTINCT(trans_no)) cnt_tno FROM er_transactions_log WHERE YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_region = "'.$this->univdata['user']['region'].'" GROUP BY MONTH(date_in)')->result_array();

      $documentsRouted = $this->db->query('SELECT date_in, COUNT(DISTINCT(trans_no)) cnt_tno FROM er_transactions_log WHERE YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_region = "'.$this->univdata['user']['region'].'" GROUP BY MONTH(date_in)')->result_array();

      $transactionsRouted = $this->db->query('SELECT date_in, COUNT(trans_no) AS cnt_tno FROM er_transactions_log WHERE YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_region = "'.$this->univdata['user']['region'].'" GROUP BY MONTH(date_in)')->result_array();

      foreach ($documentsRouted as $key => $value) {
        $json['doc_routed'][] = array('label' => date('F', strtotime($value['date_in'])), 'data' => $value['cnt_tno'] );
      }
      foreach ($transactionsRouted as $key => $value) {
        $json['trans_routed'][] = array('label' => date('F', strtotime($value['date_in'])), 'data' => $value['cnt_tno'] );
      }

      echo json_encode($json);
    }

    function trans_by_section_unit_chart()
    {
      $this->validate_session();
      $special_divnames = '';
      $special_divcode = '';
      $result = $this->db->query('SELECT COUNT(ux.trans_no) AS counter, ux.region, ux.divno, case when ux.secno is null or ux.secno = " " then "0" else ux.secno end as secno FROM (SELECT trans_no, sender_region AS region, sender_divno AS divno, sender_secno AS secno FROM er_transactions_log FORCE INDEX (trans_by_sender_x_receiver_idx) WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (0, 83, 51) AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_region = "'.$this->univdata['user']['region'].'" AND sender_divno = "'.$this->univdata['user']['divno'].'" AND sender_id != "15dde182bae172" UNION SELECT trans_no, receiver_region AS region, receiver_divno AS divno, receiver_secno AS secno FROM er_transactions_log FORCE INDEX (trans_by_sender_x_receiver_idx) WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (0, 83, 51) AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND receiver_region = "'.$this->univdata['user']['region'].'" AND receiver_divno = "'.$this->univdata['user']['divno'].'" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux GROUP BY 4 ')->result_array();

      foreach ($result as $key => $value) {
        if(empty($value['secno'])) {
          $div_data = $this->db->query('SELECT divno, divcode, divname FROM acc_xdvsion WHERE divno = "'.$value['divno'].'" ')->result_array();
          switch ($value['divno']) {
            case '14':
              $special_divnames = 'EMB Director';
              $special_divcode = 'EMB-D';
              break;

            case '17':
              $special_divnames = 'EMB Assistant Director';
              $special_divcode = 'EMB-AD';
              break;

            case '1':
              $special_divnames = 'EMB Regional Director';
              $special_divcode = 'EMB-RD';
              break;

            default:
              $special_divnames = $div_data[0]['divcode'].' Division Chief';
              $special_divcode = $div_data[0]['divcode'].'-DC';
              break;
          }
          $json[] = array('label' => $special_divnames, 'code' => $special_divcode, 'data' => (int)$value['counter'] );
        }
        else {
          $sec_data = $this->db->query('SELECT secode, sect FROM acc_xsect WHERE secno = "'.$value['secno'].'" ')->result_array();
          $json[] = array('label' => $sec_data[0]['sect'], 'code' => $sec_data[0]['secode'], 'data' => (int)$value['counter'] );
        }
      }

      echo json_encode($json);
    }

    function receivedTransactionsPerPersonnel()
    {
      $this->validate_session();
      $section_where = '';
      if(!empty($this->univdata['user']['secno'])) {
        $section_where = 'AND ac.secno = "'.$this->univdata['user']['secno'].'"';
      }
      $result = $this->db->query('SELECT ac.fname, ac.mname, ac.sname, ac.suffix, dinv.total FROM acc_credentials ac LEFT JOIN vw_dms_inbox_notif dinv ON (ac.userid = dinv.userid) WHERE ac.userid != 1 AND ac.verified = 1 AND ac.region = "'.$this->univdata['user']['region'].'" AND ac.divno = "'.$this->univdata['user']['divno'].'" '.$section_where.' ORDER BY dinv.total desc')->result_array();

      foreach ($result as $key => $value) {
        $json[] = array('name' => trim(ucwords($value['fname'].' '.$value['mname'][0].'. '.$value['sname'].' '.$value['suffix'])), 'count' => $value['total']);
      }
      echo json_encode($json);
    }

    function transactionsByDivision()
    {
      $this->validate_session();

      $div_type = $this->univdata['user']['region'] == 'CO' ? 'xd.type = "co"' : 'xd.type IN ("region", "'.strtolower($this->univdata['user']['region']).'")';

      $result = $this->db->query('SELECT COUNT(ux.trans_no) AS counter, ux.region, xd.divno, xd.divname, xd.divcode FROM (SELECT trans_no, sender_region AS region, sender_divno AS divno FROM er_transactions_log FORCE INDEX (trans_by_sender_x_receiver_idx) WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (0, 83, 51) AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_region = "'.$this->univdata['user']['region'].'" AND sender_id != "15dde182bae172" UNION SELECT trans_no, receiver_region AS region, receiver_divno AS divno FROM er_transactions_log FORCE INDEX (trans_by_sender_x_receiver_idx) WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (0, 83, 51) AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND receiver_region = "'.$this->univdata['user']['region'].'" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux JOIN acc_xdvsion xd ON xd.divno = ux.divno WHERE '.$div_type.' GROUP BY 3 ')->result_array();

      foreach ($result as $key => $value) {
        $json[] = array('label' => $value['divname'], 'code' => $value['divcode'], 'data' => (int)$value['counter'] );
      }

      echo json_encode($json);
    }

    function dms_monitoring_userlist()
    {
      $post_data['token'] = $this->input->post('token');
      echo $this->load->view('universe/modal/dms_monitoring_userlist', $post_data);
    }

    function transactionsByRegionChart()
    {
      $this->validate_session();

      $result = $this->db->query('SELECT COUNT(ux.trans_no) AS counter, ux.region, rg.rgnnum, rg.rgnnam FROM ( SELECT trans_no, sender_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (0, 83, 51) AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_id != "15dde182bae172" UNION SELECT trans_no, receiver_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type NOT IN (0, 83, 51) AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux JOIN acc_region rg ON ux.region = rg.rgnnum GROUP BY 2 ')->result_array();

      // echo $this->db->last_query(); exit;
      foreach ($result as $key => $value) {
        $json[] = array('label' => $value['rgnnam'], 'code' => $value['rgnnum'], 'data' => (int)$value['counter'] );
      }

      echo json_encode($json);
    }

    function statisticsHeader()
    {
      $totalTransactions = $this->db->query('SELECT COUNT(*) AS counter FROM ( SELECT trans_no, sender_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_id != "15dde182bae172" UNION ALL SELECT trans_no, receiver_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux WHERE ux.region = "'.$this->univdata['user']['region'].'" ')->result_array();

      $docsRouted = $this->db->query('SELECT COUNT(DISTINCT(ux.trans_no)) AS counter FROM ( SELECT trans_no, sender_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND sender_id != "15dde182bae172" UNION ALL SELECT trans_no, receiver_region AS region FROM er_transactions_log WHERE route_order != 0 AND status != 0 AND multiprc != 1 AND type != 0 AND YEAR(date_in) = "'.$this->univdata['year_selected'].'" AND receiver_id NOT IN ("", "15dde182bae172") ) AS ux WHERE ux.region = "'.$this->univdata['user']['region'].'" ')->result_array();

      $docsCreated = $this->db->query('SELECT COUNT(DISTINCT(trans_no)) AS counter FROM er_transactions_log WHERE route_order = 1 AND status != 0 AND multiprc != 1 AND type != 0 AND DATE(date_in) = "'.date("Y-m-d").'" AND sender_id != "15dde182bae172" AND receiver_id != "15dde182bae172" AND sender_region = "'.$this->univdata['user']['region'].'" ')->result_array();

       // $json = array(
       //   'total'    => $this->number_format_short($totalTransactions[0]['counter']),
       //   'routed'   => $this->number_format_short($docsRouted[0]['counter']),
       //   'created'  => $this->number_format_short($docsCreated[0]['counter']),
       // );

      $json = array(
        'total'    => array(
            'full'  => $totalTransactions[0]['counter'],
            'short' => $this->number_format_short($totalTransactions[0]['counter'])
        ),
        'routed'   => array(
            'full'  => $docsRouted[0]['counter'],
            'short' => $this->number_format_short($docsRouted[0]['counter'])
        ),
        'created'  => array(
            'full'  => $docsCreated[0]['counter'],
            'short' => $this->number_format_short($docsCreated[0]['counter'])
        ),
      );

       echo json_encode($json);
    }

    // Converts a number into a short version, eg: 1000 -> 1k
    // Based on: http://stackoverflow.com/a/4371114
    function number_format_short( $n, $precision = 1 ) {
    	if ($n < 900) {
    		// 0 - 900
    		$n_format = number_format($n, $precision);
    		$suffix = '';
    	} else if ($n < 900000) {
    		// 0.9k-850k
    		$n_format = number_format($n / 1000, $precision);
    		$suffix = 'K';
    	} else if ($n < 900000000) {
    		// 0.9m-850m
    		$n_format = number_format($n / 1000000, $precision);
    		$suffix = 'M';
    	} else if ($n < 900000000000) {
    		// 0.9b-850b
    		$n_format = number_format($n / 1000000000, $precision);
    		$suffix = 'B';
    	} else {
    		// 0.9t+
    		$n_format = number_format($n / 1000000000000, $precision);
    		$suffix = 'T';
    	}

      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
    	if ( $precision > 0 ) {
    		$dotzero = '.' . str_repeat( '0', $precision );
    		$n_format = str_replace( $dotzero, '', $n_format );
    	}

    	return $n_format . $suffix;
    }


  } // CLASS END
?>
