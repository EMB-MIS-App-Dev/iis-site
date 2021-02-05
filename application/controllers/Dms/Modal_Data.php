<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Modal_Data extends CI_Controller
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

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->dmsdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->dmsdata['user']['region'] || $session_ucred['secno'] != $this->dmsdata['user']['secno'] || $session_ucred['divno'] != $this->dmsdata['user']['divno']) {
        $this->dmsdata['user'] = array(
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

    function view_transaction()
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

      // $this->dmsdata['geocode'] = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$this->dmsdata['prepAddr'].'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');

      // $this->dmsdata['geocode'] = json_decode($this->dmsdata['geocode']);

      // query of transaction's data (multiple)
      $trans_where = array( 'etrns.trans_no' => $this->dmsdata['post_data']['trans_no'] );
      $this->dmsdata['trans_multi'] = $this->Embismodel->selectdata('er_transactions_multi AS etrns', '', $trans_where);

      $this->load->view('Dms/modals/trans_view', $this->dmsdata);
    }

    function trans_history()
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

      $this->load->view('Dms/modals/view_history_content', $this->dmsdata);
    }

    //balhin rah unya
    function multitrans_history()
    {
      $mt_order = explode('_', $this->input->post('multitrans'));

      $trans_where = array( 'etm.trans_no' => $mt_order[1], );
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions_multi AS etm', '', $trans_where);

      $data = array(
        'trans_no'          => $mt_order[1],
        'main_route_order'  => $mt_order[2],
        'main_multi_cntr'   => $mt_order[3],
        'multi_cntr'        => $mt_order[4],
      );
      // query of transaction's log
      $history_where = array(
        'etl.trans_no'          => $data['trans_no'],
        'etl.main_route_order'  => $data['main_route_order'],
        'etl.main_multi_cntr'   => $data['main_multi_cntr'],
        'etl.multi_cntr'        => $data['multi_cntr'],
      );
      $history_order = $this->db->order_by('etl.route_order ASC, etl.multiprc ASC');
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );

      $where['inthread'] = $this->db->where('etl.trans_no = "'.$data['trans_no'].'" AND etl.main_multi_cntr = "'.$data['main_multi_cntr'].'" AND etl.multi_cntr = "'.$data['multi_cntr'].'" AND ( etl.sender_id = "'.$this->dmsdata['user_token'].'" OR etl.receiver_id =  "'.$this->dmsdata['user_token'].'" )');

      $this->dmsdata['prnl_inthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['inthread'] );

      $where['onlowerthread'] = $this->db->where('etl.trans_no = "'.$data['trans_no'].'" AND ( etl.sender_id = "'.$this->dmsdata['user_token'].'" OR etl.receiver_id =  "'.$this->dmsdata['user_token'].'" )');
      $this->dmsdata['onlowerthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['onlowerthread'] );

      // CHECK IF USER IS UNDER THIS MULTIPLE ROUTE ROW
      $this->dmsdata['prnl_onlowerthread'] = '';

      $muti_histo_mmccheck = mb_strlen($data['main_multi_cntr'], 'UTF-8');
      foreach ($this->dmsdata['onlowerthread'] as $key => $value)
      {
        $onlowerthread_mmccheck = substr($value['main_multi_cntr'], 0, $muti_histo_mmccheck);

        if($data['main_multi_cntr'] == $onlowerthread_mmccheck && $value['main_multi_cntr'][$muti_histo_mmccheck+1] == $data['multi_cntr'])
        {
          $this->dmsdata['prnl_onlowerthread']=1;
          break;
        }
      }


      $x_mcnt = explode('-', $mt_order[3]);
      $x_mcntr = '';
      $i=1;

      while($i < count($x_mcnt)) {
        $x_mcntr .= $x_mcnt[$i];
        if($i+1 < count($x_mcnt)) {
          $x_mcntr .= '-';
        }
        $i++;
      }

      // query of attachments
      foreach ($this->dmsdata['trans_history'] as $key => $value) {

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

        if($key == 0)
        {
          $etm_hist_0_where = array(
            'eat.trans_no'          => $data['trans_no'],
            'eat.route_order'       => $data['main_route_order'],
            'eat.main_multi_cntr'   => $x_mcntr,
            'eat.multi_cntr'        => $x_mcnt[$i-1],
            'eat.deleted'           => 0,
          );
          $etm_hist_0_order = $this->db->order_by(' eat.route_order desc, eat.file_id desc');
          $this->dmsdata['attachment_view'][0] = $this->Embismodel->selectdata('er_attachments AS eat', '', $etm_hist_0_where, $etm_hist_0_order );
        }
        else {
          $ea_where = array(
            'eat.trans_no'          => $value['trans_no'],
            // 'eat.main_route_order'  => $data['main_route_order'], // UNCOMMENT IF NAGKAKA.ANO NA NAMN
            'eat.route_order'       => $value['route_order'],
            'eat.main_multi_cntr'   => $data['main_multi_cntr'],
            'eat.multi_cntr'        => $data['multi_cntr'],
            'eat.deleted'           => 0,
          );
          $ea_order = $this->db->order_by(' eat.route_order desc, eat.file_id desc');
          $this->dmsdata['attachment_view'][$key] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where, $ea_order );
        }

        if($value['multiprc'] > 0)
        {
          $where['etml'] = array(
            'etml.trans_no'           => $value['trans_no'],
            'etml.main_route_order'   => $value['route_order'],
            'etml.route_order'        => 1,
            'etml.main_multi_cntr'    => (!empty($value['main_multi_cntr'])) ? $value['main_multi_cntr'].'-'.$value['multi_cntr'] : $value['multi_cntr'],
          );
          $this->dmsdata['multitrans_histo'] = $this->Embismodel->selectdata('er_transactions_log AS etml', '', $where['etml'] );

        }
      }
      $this->load->view('Dms/func/multitrans_view', $this->dmsdata);
    }

  } // CLASS END
?>
