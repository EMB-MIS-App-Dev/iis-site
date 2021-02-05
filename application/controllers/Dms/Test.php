<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Test extends CI_Controller
  {
    private $dmsdata;
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

      $this->dmsdata = array(
        'user_id'     => $this->session->userdata('userid'),
        'user_region' => $this->session->userdata('region'),
        'user_token'  => $this->session->userdata('token'),
      );

      $this->dmsdata['user'] = array(
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
      $this->load->view('includes/common/dms_styles');

      $this->load->view('Dms/include/custom_head');
      $this->load->view('Dms/include/custom_foot');

      $this->transaction_history123();
    }

    function bulk_download_test()
    {
      $this->load->library('zip');

      $this->zip->clear_data();
      $value= $this->uri->segment(4);
      $x = explode('_', $value);

      $trans_no_calculated = !empty($x[4]) ? $x[0] : $x[0] - 10000000;

      $where['bulkdl'] = array(
        'eat.trans_no'        => $x[0],
        'eat.main_multi_cntr' => !empty($x[1]) ? $x[1] : '',
        'eat.route_order'     => $x[2],
        'eat.multi_cntr'      => $x[3],
      );
      $bulkdl = $this->Embismodel->selectdata('er_attachments eat', 'eat.token, eat.file_name', $where['bulkdl']);
      $where['ertrans'] = array(
        'et.trans_no'        => $x[0],
      );
      $ertrans = $this->Embismodel->selectdata('er_transactions et', '', $where['ertrans']);

      foreach ($bulkdl as $key => $value) {
        $this->zip->read_file(trim('./uploads/dms/'.date('Y', strtotime($ertrans[0]['start_date'])).'/'.$x[4].'/'.$trans_no_calculated.'/'.$value['token'].'.'.pathinfo($value['file_name'], PATHINFO_EXTENSION)));
      }

      $this->zip->download('iisfiles.zip');
    }

    private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

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

// -- start history

    function view_transaction11()
    {
      $this->dmsdata['post_data'] = $this->input->post();

      // query of transaction's data (single)
      // !empty($this->dmsdata['post_data']['multiprc']) &&
      if($this->dmsdata['post_data']['multiprc'] > 0) {
        $trans_where = array(
          'etm.trans_no'     => $this->dmsdata['post_data']['trans_no'],
          'etm.receiver_id'  => $this->dmsdata['user_token'],
        );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions_multi AS etm', '', $trans_where);
      }
      else {
        $trans_where = array( 'et.trans_no' => $this->dmsdata['post_data']['trans_no'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);
      }

      // query of system
      $type_where = array('es.id' => $this->dmsdata['trans_data'][0]['system'] );
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS es', '', $type_where);

      // query of company details
      $dcomp_where = array( 'dcd.token' => $this->dmsdata['trans_data'][0]['company_token'] );
      $this->dmsdata['company_details'] = $this->Embismodel->selectdata('dms_company AS dcd', '', $dcomp_where);

      $this->dmsdata['prepAddr'] = str_replace(' ', '+', $this->dmsdata['company_details'][0]['company_name']);
      $this->dmsdata['prepAddr'] .= '+'.str_replace(' ', '+', $this->dmsdata['company_details'][0]['city_name'].'+'.$this->dmsdata['company_details'][0]['province_name']);

      $this->dmsdata['geocode'] = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$this->dmsdata['prepAddr'].'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');

      $this->dmsdata['geocode'] = json_decode($this->dmsdata['geocode']);

      // query of transaction's data (multiple)
      $trans_where = array( 'etrns.trans_no' => $this->dmsdata['post_data']['trans_no'] );
      $this->dmsdata['trans_multi'] = $this->Embismodel->selectdata('er_transactions_multi AS etrns', '', $trans_where);

      // checks personnel if he/she is in the this transaction's log
      $where['inthread'] = $this->db->where('etl.trans_no = "'.$this->dmsdata['post_data']['trans_no'].'" AND ( etl.sender_id = "'.$this->dmsdata['user_token'].'" OR etl.receiver_id =  "'.$this->dmsdata['user_token'].'" )');
      $this->dmsdata['prnl_inthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['inthread'] );

      $this->dmsdata['special_view'] = FALSE;
      //special viewing (mon.rep, eia, haz, chem)
      if( $this->dmsdata['trans_data'][0]['type'] == 23 && $this->dmsdata['user_rights']['view_monitoring_report'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      if( in_array($this->dmsdata['trans_data'][0]['type'], array(1, 2,3,74)) && $this->dmsdata['user_rights']['view_eia'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      if( in_array($this->dmsdata['trans_data'][0]['type'], array(7,8,9,10,76)) && $this->dmsdata['user_rights']['view_chem'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      if( in_array($this->dmsdata['trans_data'][0]['type'], array(6,32,33,34,47,48,77,98,105,112,113)) && $this->dmsdata['user_rights']['view_haz'] == 'yes')
      {
       $this->dmsdata['special_view'] = TRUE;
      }
      // if( in_array($this->dmsdata['trans_data'][0]['type'], array(4,5,27,75)) && $this->dmsdata['user_rights']['view_airwater'] == 'yes')
      // {
      //  $this->dmsdata['special_view'] = TRUE;
      // }

      // query of transaction's log
      $history_where = array(
        'etl.trans_no'          => $this->dmsdata['post_data']['trans_no'],
        'etl.main_multi_cntr'   => '',
       );
      $history_order = $this->db->order_by('etl.main_route_order ASC, etl.route_order ASC, etl.multi_cntr ASC');
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );
      // query of attachments
      foreach ($this->dmsdata['trans_history'] as $key => $value) {
        $ea_where = array(
          'eat.trans_no'    => $value['trans_no'],
          'eat.route_order' => $value['route_order'],
          'eat.deleted'      => 0,
        );
        $ea_order = $this->db->order_by('eat.route_order', 'desc');
        $this->dmsdata['attachment_view'][$key] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where, $ea_order );

        $from_name['axd_where'] = array( 'axd.divno' => $value['sender_divno'] );
        $from_name['div'] = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $from_name['axd_where'] );
        $from_div = (!empty($from_name['div'])) ?  $from_name['div'][0]['divcode'] : '';

        $from_name['axs_where'] = array( 'axs.secno' => $value['sender_secno'] );
        $from_name['sec'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $from_name['axs_where'] );
        $from_sec = (!empty($from_name['sec'])) ? '|'.$from_name['sec'][0]['secode'] : '';

        $this->dmsdata['from_name'][$key] = $from_div.$from_sec.' - ';

        $receiver_name['axd_where'] = array( 'axd.divno' => $value['receiver_divno'] );
        $receiver_name['div'] = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $receiver_name['axd_where'] );
        $receiver_div = (!empty($receiver_name['div'])) ?  $receiver_name['div'][0]['divcode'] : '';

        $receiver_name['axs_where'] = array( 'axs.secno' => $value['receiver_secno'] );
        $receiver_name['sec'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $receiver_name['axs_where'] );
        $receiver_sec = (!empty($receiver_name['sec'])) ? '|'.$receiver_name['sec'][0]['secode'] : '';

        $this->dmsdata['receiver_name'][$key] = $receiver_div.$receiver_sec.' - ';

        if($value['multiprc'] > 0)
        {
          $where['etml'] = array(
            'etml.trans_no'           => $value['trans_no'],
            // 'etml.main_route_order'   => $value['route_order'],
            'etml.route_order'        => 1,
            'etml.main_multi_cntr'    => $value['multi_cntr'],
          );
          $this->dmsdata['multitrans_histo'] = $this->Embismodel->selectdata('er_transactions_log AS etml', '', $where['etml'] );
        }
      }

      $this->load->view('Dms/func/view_transaction1', $this->dmsdata);
    }

    private function transaction_history123()
    {
      $data = array(
        'entry'           => 2,
        'trans_no'        => 202018022682,
        'main_multi_cntr' => '1-6-1-1',
        'multi_cntr'      => 12,
      );

      $result = array();
      if($data['entry'] != 1)
      {
        $data['multicnt'] = explode('-', $data['main_multi_cntr']);
        for ($index=0; $index < count($data['multicnt'])+1; $index++)  {
          $history = array(
            'where' => array(
              'trans_no'          => $data['trans_no'],
              'main_multi_cntr'   => $index == 0 ? 0 : ($index==1 ? $data['multicnt'][$index-1] : substr($data['main_multi_cntr'],0,($index)+$index)),
              'multi_cntr'        => count($data['multicnt'])==$index ? $data['multi_cntr'] : $data['multicnt'][$index],
            ),
            'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
          );
          $result['trans_history'][$index] = $this->Embismodel->selectdata( 'er_transactions_log', '*', $history['where'], $history['order'] );

          foreach ($result['trans_history'][$index] as $key => $value)
          {
            // if($this->dmsdata['user']['token'] == '515e12d4a186a84')
            // {
              if($value['route_order'] == 1 && !empty($value['main_multi_cntr']))
              {
                $data['sub_multicnt'] = explode('-', $value['main_multi_cntr']);
                $sub_mtcount_cnt = count($data['sub_multicnt']);
                // CHECK WHICH TABLE TO LOOK
                if($sub_mtcount_cnt==1)
                {
                  $history_ertrans_multiprc_check = array(
                    'where' => array(
                      'trans_no'  => $data['trans_no'],
                      'multiprc'  => 1,
                    ),
                    'table' => 'er_transactions',
                  );
                }
                else {
                  $history_ertrans_multiprc_check = array(
                    'where' => array(
                      'trans_no'          => $data['trans_no'],
                      'multiprc'          => 1,
                      'main_multi_cntr'   => $sub_mtcount_cnt==1 ? 0 : ($sub_mtcount_cnt==2 ? $data['sub_multicnt'][0] : substr($value['main_multi_cntr'],0,($index-1)+$index)),
                      'multi_cntr'        => end($data['sub_multicnt']),
                    ),
                    'table'               => 'er_transactions_multi',
                  );
                }
                $result_ertrans_multi_multiprc_check = $this->Embismodel->selectdata( $history_ertrans_multiprc_check['table'], '*', $history_ertrans_multiprc_check['where'] )[0];

                if($result_ertrans_multi_multiprc_check)
                {
                  $history = array(
                    'where' => array(
                      'trans_no'          => $data['trans_no'],
                      'route_order'       => $result_ertrans_multi_multiprc_check['route_order'],
                      'main_multi_cntr'   => $sub_mtcount_cnt==1? '' : $result_ertrans_multi_multiprc_check['main_multi_cntr'],
                      'multi_cntr'        => $this->_is_empty($result_ertrans_multi_multiprc_check['multi_cntr'], 1),
                      'deleted'           => 0,
                    ),
                    'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
                  );
                  $result['attachments'][$index][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
                }
                else {
                  $history = array(
                    'where' => array(
                      'trans_no'          => $data['trans_no'],
                      'route_order'       => $value['route_order'],
                      'main_multi_cntr'   => $value['main_multi_cntr'],
                      'multi_cntr'        => $value['multi_cntr'],
                      'deleted'           => 0,
                    ),
                    'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
                  );
                  $result['attachments'][$index][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
                }
              }
              else {
                $history = array(
                  'where' => array(
                    'trans_no'          => $data['trans_no'],
                    'route_order'       => $value['route_order'],
                    'main_multi_cntr'   => $value['main_multi_cntr'],
                    'multi_cntr'        => $value['multi_cntr'],
                    'deleted'           => 0,
                  ),
                  'order' => $this->db->order_by('main_multi_cntr ASC, multi_cntr ASC, route_order ASC'),
                );
                $result['attachments'][$index][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
              }
            // }

            // XDIVISION AND XSECT QUERIES FOR SENDER AND RECEIVER
            $sender['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['sender_divno'], 'office' => 'EMB' ) )[0];
            $sender['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['sender_secno']) )[0];
            $receiver['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['receiver_divno'], 'office' => 'EMB' ) )[0];
            $receiver['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['receiver_secno']) )[0];
            // SENDER REGION, DIVISION, SECTION CODES
            $result['ds_sender'][$index][$key] = (!empty($value['sender_region'])) ? $value['sender_region'] : '';
            $result['ds_sender'][$index][$key] .= (!empty($sender['div'])) ?  '|'.$sender['div']['divcode'] : '';
            $result['ds_sender'][$index][$key] .= (!empty($sender['sec'])) ? '|'.$sender['sec']['secode'] : '';
            // RECEIVER REGION, DIVISION, SECTION CODES
            $result['ds_receiver'][$index][$key] = (!empty($value['receiver_region'])) ? $value['receiver_region'] : '';
            $result['ds_receiver'][$index][$key] .= (!empty($receiver['div'])) ?  '|'.$receiver['div']['divcode'] : '';
            $result['ds_receiver'][$index][$key] .= (!empty($receiver['sec'])) ? '|'.$receiver['sec']['secode'] : '';
          }
        }
      }
      else {
        $history = array(
          'where' => array(
            'trans_no'          => $data['trans_no'],
            'main_multi_cntr'   => '',
            'multi_cntr'        => 1,
          ),
          'order' => $this->db->order_by('route_order ASC'),
        );
        $result['trans_history'][0] = $this->Embismodel->selectdata( 'er_transactions_log', '*', $history['where'], $history['order'] );

        foreach ($result['trans_history'][0] as $key => $value)
        {
          $history = array(
            'where' => array(
              'trans_no'          => $value['trans_no'],
              'route_order'       => $value['route_order'],
              'main_multi_cntr'   => '',
              'multi_cntr'        => 1,
              'deleted'           => 0,
            ),
            'order' => $this->db->order_by('route_order ASC'),
          );
          $result['attachments'][0][$key] = $this->Embismodel->selectdata( 'er_attachments', '*', $history['where'], $history['order'] );
          // XDIVISION AND XSECT QUERIES FOR SENDER AND RECEIVER
          $sender['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['sender_divno'], 'office' => 'EMB' ) )[0];
          $sender['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['sender_secno']) )[0];
          $receiver['div'] = $this->Embismodel->selectdata( 'acc_xdvsion', 'divcode', array( 'divno' => $value['receiver_divno'], 'office' => 'EMB' ) )[0];
          $receiver['sec'] = $this->Embismodel->selectdata( 'acc_xsect', 'secode', array('secno' => $value['receiver_secno']) )[0];
          // SENDER DIVISION AND SECTION CODES
          $result['ds_sender'][0][$key] = (!empty($value['sender_region'])) ? $value['sender_region'] : '';
          $result['ds_sender'][0][$key] .= (!empty($sender['div'])) ?  '|'.$sender['div']['divcode'] : '';
          $result['ds_sender'][0][$key] .= (!empty($sender['sec'])) ? '|'.$sender['sec']['secode'] : '';
          // RECEIVER DIVISION AND SECTION CODES
          $result['ds_receiver'][0][$key] = (!empty($value['receiver_region'])) ? $value['receiver_region'] : '';
          $result['ds_receiver'][0][$key] .= (!empty($receiver['div'])) ?  '|'.$receiver['div']['divcode'] : '';
          $result['ds_receiver'][0][$key] .= (!empty($receiver['sec'])) ? '|'.$receiver['sec']['secode'] : '';
        }
      }

      echo '<pre>'.print_r($result['trans_history'], TRUE).'</pre>';

      $this->load->view('Dms/func/test1', $result);
    }

// -- end history

  }
?>
