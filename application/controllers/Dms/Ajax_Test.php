<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Ajax_Test extends CI_Controller
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

    function add_company_modal()
    {
      $data['region'] = $this->Embismodel->selectdata('acc_region AS ar', '*');
      $this->load->view('Dms/func/add_company_modal', $data);
    }

    function add_company_modal1()
    {
      $data['user_region'] = $this->input->post('user_region');
      $data['region'] = $this->Embismodel->selectdata('acc_region AS ar', '*');
      $this->load->view('Dms/func/add_company_modal1', $data);
    }

    function get_company_list()
    {
      $region = $this->input->post('region_id');
      $company = $this->Embismodel->selectdata( 'dms_company', 'token, emb_id, company_name', array('deleted' => 0, 'region_name' => $region) );
      echo '<option value="" selected>--</option>';
      foreach ($company as $key => $value) {
        echo '<option value="'.$value['token'].'">['.$value['emb_id'].']-'.$value['company_name'].'</option>';
      }
    }

    function show_comp_dtls()
    {
      $company_token = $this->input->post('company_token');
      $company = $this->Embismodel->selectdata( 'dms_company', 'token, emb_id, company_name, establishment_name, date_established, house_no, street, barangay_name, city_name, province_name, region_name, latitude, longitude', array('token' => $company_token) )[0];

      $address = $company['house_no'].' '.$company['street'].' '.$company['barangay_name'].' '.$company['city_name'].' '.$company['province_name'].' '.$company['region_name'];
      echo '
        <p><span style="font-weight:bold">EMB ID: </span>'.$company['emb_id'].'</p>
        <p><span style="font-weight:bold">Company Name: </span><br />'.$company['company_name'].'</p>
        <p><span style="font-weight:bold">Establishment Name: </span><br />'.$company['establishment_name'].'</p>
        <p><span style="font-weight:bold">Date Established: </span>'.$company['date_established'].'</p>
        <p><span style="font-weight:bold">Address: </span><br />'.trim($address).'</p>
        <p><span style="font-weight:bold">Latitude | Longitude: </span>'.trim($company['latitude'].', '.$company['longitude']).'</p>
      ';
    }

    function get_division()
    {
      $data = array(
        'division'  => $this->input->post('selected'),
        'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->ajaxdata['user']['region'],
      );

      $this->validate_session();

      $type = ($data['region'] == 'CO') ? 'co' : 'region';
      $type2 = strtolower($data['region']);

      $func = $this->Embismodel->selectdata('acc_function', 'func', array('stat' => 1, 'userid' => $this->ajaxdata['user']['id']));
      $restriction = 'divno IN (2, 6)';

      if($data['region'] == $this->ajaxdata['user']['region']) {
        $restriction = '1';
      }
      else {
        foreach ($func as $key => $value) {
          if(in_array($value['func'], array('Director', 'Assistant Director'))) {
            $restriction = '1';
            break;
          }
          else if($value['func'] == 'Regional Director')
          {
            $restriction = 'divno IN (1, 2, 6, 14, 17)';
            break;
          }
          else if($this->session->userdata('superadmin_rights') == 'yes')
          {
            $restriction = '1';
            break;
          }
        }
      }
      $where_div = $this->db->where('type IN("'.$type.'", "'.$type2.'") AND divno != 15 AND office = "EMB" AND '.$restriction);
      $get_division = $this->Embismodel->selectdata('acc_xdvsion', '*', '', $where_div);
      // echo $data['division'];
      echo '<option value="" selected>-select division-</option>';
      foreach ($get_division as $key => $value) {
        if(!empty($data['division']) && $data['division'] == $value['divno']) {
          echo '<option value="'.$value['divno'].'" selected>'.$value['divname'].'</option>';
        }
        else {
          echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
        }
      }
    }

    function get_section()
    {
      $data = array(
        'section'   => $this->input->post('selected'),
        'division'  => $this->input->post('division'),
        'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->ajaxdata['user']['region'],
      );
      $sec_slctd = '';
      $this->validate_session();
      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable', '*', array('region' => $data['region']) );
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
      // if($this->session->userdata('region') == $region || $this->session->userdata('func') == 'Director') {
        $restriction = '1';
      // }
      // else {
      //   $restriction = 'axs.secno IN (77, 166, 176, 195, 223, 231, 232, 235, 255, 279, 316)';
      // }
      if($region != 'CO') {
        $where['xsect'] = $this->db->where('secno != 345 AND divno = "'.$data['division'].'" AND ( region = "'.$data['region'].'" OR region = "R" ) AND secno NOT IN ('.$xsct.') AND '.$restriction);
      }
      else {
        $where['xsect'] = $this->db->where('secno != 345 AND divno = "'.$data['division'].'" AND region = "'.$data['region'].'" AND '.$restriction);
      }
      $get_section = $this->Embismodel->selectdata('acc_xsect', '*', '', $where['xsect']);

      echo '<option value="" selected>-select section-</option>';

      if($data['section'] == 0 && !empty($data['division'])) {
        $sec_slctd = 'selected';
      }
      echo '<option value="0" '.$sec_slctd.'>N/A</option>';

      foreach ($get_section as $key => $value) {
        if(!empty($data['section']) && $data['section'] == $value['secno']) {
          echo '<option value="'.$value['secno'].'" selected>'.$value['sect'].'</option>';
        }
        else {
          echo '<option value="'.$value['secno'].'">'.$value['sect'].'</option>';
        }
      }
    }

    function get_personnel()
    {
      $data = array(
        'personnel' => $this->input->post('selected'),
        'section'   => !empty($this->input->post('section')) ? $this->input->post('section') : 0,
        'division'  => $this->input->post('division'),
        'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->ajaxdata['user']['region'],
      );
      $this->validate_session();

      // 0- inactive, 1- active, 2- resigned, 3- retired, 4- on-leave

      $af_where = array('stat' => 1, 'secno' => $data['section'], 'divno' => $data['division'], 'region' => $data['region']);
      $func_grp = $this->db->group_by("userid");
      $func = $this->Embismodel->selectdata('acc_function', 'userid', $af_where, $func_grp);

      echo '<option value="" selected>-select personnel-</option>';
      foreach ($func as $key => $value) {
        $sec_where = array(
          'userid'   => $value['userid'],
          'verified' => 1
        );
        $personnel1_grp = $this->db->group_by("userid");
        $personnel = $this->Embismodel->selectdata('acc_credentials', 'token, fname, mname, sname', $sec_where, $personnel1_grp);
        if(!empty($personnel)) {
          if(in_array($personnel[0]['token'], array('5715e58cf2dac134')) ){
            echo '<option value="'.$personnel[0]['token'].'" disabled class="asgn-on-leave">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'<span > [ON-LEAVE]</span> </option>';
          }
          else if(in_array($personnel[0]['token'], array('4635e4286ea323ec')) ){
            echo '<option value="'.$personnel[0]['token'].'" disabled class="asgn-on-leave">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'<span > [PAUSED-ROUTING]</span> </option>';
          }
          else if( !empty($data['personnel']) && trim($data['personnel']) == $personnel[0]['token'] ) {
            echo '<option value="'.$personnel[0]['token'].'" selected>'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'</option>';
          }
          else {
            echo '<option value="'.$personnel[0]['token'].'">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'</option>';
          }
        }
      }
    }

    function receive_transaction()
    {
      $post = $this->input->post();
      $data =  array(
        'trans_no'          => $post['trans_no'],
        'entry'             => $post['entry'],
        'route_order'       => $post['route_order'],
        'main_multi_cntr'   => $post['main_multi_cntr'],
        'multi_cntr'        => $post['multi_cntr'],
        'region'            => $this->ajaxdata['user']['region'],
        'sender_divno'      => $this->ajaxdata['user']['divno'],
        'sender_secno'      => $this->ajaxdata['user']['secno'],
        'sender_id'         => $this->ajaxdata['user']['token'],
        'sender_region'     => $this->ajaxdata['user']['region'],
        'date_in'           => date('Y-m-d H:i:s'),
      );
      // CHECK TABLE TO LOOK AND WHERE PARAMS
      $where_trnsdata = array(
        'trans_no'     => $data['trans_no'],
        'receiver_id'  => $data['sender_id'],
        'route_order'  => $data['route_order'],
      );
      if($data['entry'] == 1) {
        $data['main_multi_cntr'] = '';
        $data['multi_cntr'] = 1;
        $table_to_look = 'er_transactions';
      }
      else {
        $where_trnsdata['main_multi_cntr'] = $data['main_multi_cntr'];
        $where_trnsdata['multi_cntr'] = $data['multi_cntr'];
        $table_to_look = 'er_transactions_multi';
      }
      $trans_data = $this->Embismodel->selectdata($table_to_look, '*', $where_trnsdata );
      if(!$trans_data){ echo 'ERROR [TRNS-D]'; return 'ERROR'; exit;} // EMPTY RESULT
      // CHECK IF USER MATCHES TRANSACTION LOG HISTORY RECEIVER
      $where_trnslog = array(
        'trans_no'          => $data['trans_no'],
        'route_order'       => $data['route_order'],
        'main_multi_cntr'   => $data['main_multi_cntr'],
        'multi_cntr'        => $data['multi_cntr'],
        'receiver_id'       => $data['sender_id'],
      );
      $translog_data = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trnslog );
      if(!$translog_data){ echo 'ERROR [TRNS-MTLOG]'; return 'ERROR'; exit;} // EMPTY RESULT
      // CHECK STATUS (DRAFT, CLOSED, CLAIMED, SENT VIA COURIER)
      if(in_array($trans_data[0]['status'], array(0, 18, 19, 24))) { echo 'ERROR [TRNS-STAT-END]'; return 'ERROR'; exit; }
      // CHECK IF TRANSACTION ALREADY RECEIVED BY USER
      $where_trnslog_ahead = array(
        'trans_no'          => $data['trans_no'],
        'route_order'       => $data['route_order']+1,
        'main_multi_cntr'   => $data['main_multi_cntr'],
        'multi_cntr'        => $data['multi_cntr'],
        'sender_id'         => $data['sender_id'],
      );
      $translog_ahead_data = $this->Embismodel->selectdata('er_transactions_log', '*', $where_trnslog_ahead );

      /* -------------------------------  INSERTS AND UPDATES START --------------------------------------- */
      if(!$translog_ahead_data) // ALREADY RECEIVED
      {
        $sender = $this->prc_personnel_fullname($data['sender_id']); // SENDER NAME
        $trans_log_insert = array(
          'trans_no'          => $data['trans_no'],
          'main_route_order'  => $this->_is_empty($trans_data[0]['main_route_order'], ''),
          'route_order'       => $data['route_order']+1,
          'multiprc'          => 0,
          'main_multi_cntr'   => $data['main_multi_cntr'],
          'multi_cntr'        => $data['multi_cntr'],
          'sender_divno'      => $data['sender_divno'],
          'sender_secno'      => $data['sender_secno'],
          'sender_id'         => $data['sender_id'],
          'sender_name'       => ucwords($sender),
          'sender_ipadress'   => $this->input->ip_address(),
          'sender_region'     => $data['sender_region'],
          'date_in'           => $data['date_in'],
        );
        $result_ova = $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);
        if(!$result_ova){ echo 'ERROR [TLOG-INS]'; return 'ERROR'; exit;} // EMPTY RESULT
      }
      // SET MAIN TRANS VIEW RECEIVE TO 1
      $update_er_trans = $this->Embismodel->updatedata( array('receive' => 1), $table_to_look, $where_trnsdata );
      if(!$update_er_trans){ echo 'ERROR [TRNS-RCV]'; return 'ERROR'; exit;} // EMPTY RESULT

      echo 'SUCCESS'; return 'SUCCESS';
    }

    function delete_drafts()
    {
      $trans_no = $this->input->post('trans_no');
      // CHECK TABLE TO LOOK AND WHERE PARAMS
      $result = $this->Embismodel->selectdata('er_transactions', '*', array('trans_no' => $trans_no) );
      if(!$result){ echo 'ERROR [TRNS-RTRV]'; return 'ERROR'; exit;} // EMPTY RESULT
      // SET MAIN TRANS VIEW DELETE TO 1
      $update_er_trans = $this->Embismodel->updatedata( array('deleted' => 1), 'er_transactions', array('trans_no' => $trans_no) );
      if(!$update_er_trans){ echo 'ERROR [TRNS-DLTE]'; return 'ERROR'; exit;} // EMPTY RESULT

      echo 'SUCCESS';
    }

    function file_upload()
    {
      $this->validate_session();
      // POST DATA
      $post = $this->input->post();
      $enc_key = $this->encrypt->decode($post['enc_key']);
      // echo 'asdasd1';
      $enc_data = explode(';', $enc_key);
      // echo 'asdasd2';
      $data = array(
        'entry'           => $enc_data[0],
        'trans_no'        => $enc_data[1],
        'main_multi_cntr' => $enc_data[0]==2 ? $enc_data[2] : '',
        'multi_cntr'      => $enc_data[3],
        'route_order'     => $post['route_order']+1,
        'user_token'      => $this->ajaxdata['user']['token'],
      );
      // TRANSACTION COUNTER
      $data['cnt'] = !empty($data['cnt']) ? $data['cnt']++ : 1;
      // QUERY TRANSACTION FOR MORE INFO
      $trans_data = $this->Embismodel->selectdata('er_transactions', 'region, start_date', array('trans_no' => $data['trans_no'] ) );
      // echo 'asdasd';
      // echo '<pre>'.print_r($data).'</pre>';

      $path = 'dms/'.date('Y', strtotime($trans_data[0]['start_date'])).'/'.$trans_data[0]['region'].'/';
      $folder = $data['trans_no'];
      // CREATE FOLDER, OR SET EXISTING FOLDER MOD TO 0777
      if(!is_dir('uploads/'.$path.'/'.$folder)) {
        mkdir('uploads/'.$path.'/'.$folder, 0777, TRUE);
      }
      else {
        chmod($whole_path, 0777); // chown
      }
      // NAMING CONVENTION FOR FILES OF MULTI-RCVR TRANSACTIONS
      $mcntr='';
      if(!empty($data['main_multi_cntr'])) {
        $mcntr = '-MC'.$data['main_multi_cntr'].'-'.$data['multi_cntr'];
      }
      // GET TRANSACTION NO. END DIGITS
      $end_no = fmod($data['trans_no'], 1000000);
      // select,insert, update and delete queries from er_attachments db must include multi_cntr
      $ea_w = array(
        'trans_no'           => $data['trans_no'],
        'route_order'        => $data['route_order'],
        'main_multi_cntr'    => $data['main_multi_cntr'],
        'multi_cntr'         => $data['multi_cntr'],
        'deleted'            => 0,
      );
      $ea_q = $this->Embismodel->selectdata('er_attachments', 'MAX(file_id) AS max_fileid', $ea_w);

      if($this->ajaxdata['user']['token'] == '515e12d4a186a84')
      {
        print_r($ea_w);
      }
      // total file coding
      $att_token = $trans_data[0]['region'].date('Y', strtotime($trans_data[0]['start_date'])).$mcntr.'-FT'.$data['route_order'].'N'.$end_no.'-File_'.($ea_q[0]['max_fileid']+1);

      if(!empty($_FILES['file']['name'])) {
        // Set preference
        $config = array(
          'upload_path'   => 'uploads/'.$path.'/'.$folder, // .'/'.$m_addpath
          'allowed_types' => '*',
          'max_size'      => '20480', // max_size in kb
          'file_name'     => $att_token,
          'overwrite'     => FALSE,
        );
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // File upload
        if(!$this->upload->do_upload('file')) {
          // Show error on uploading
          $uploadError = array('error' => $this->upload->display_errors());
          echo 'ERROR';
        }
        else {
          // echo 'error1';

          // Get data about the file
          $uploadData = $this->upload->data();
          $erattach_insert = array(
            'trans_no'          => $data['trans_no'],
            'route_order'       => $data['route_order'],
            'main_multi_cntr'   => $data['main_multi_cntr'],
            'multi_cntr'        => $data['multi_cntr'],
            'file_id'           => $ea_q[0]['max_fileid']+1, // order_by
            'token'             => $att_token,
            'file_name'         => $_FILES['file']['name'],
          );
          // print_r($erattach_insert);
          $this->Embismodel->insertdata('er_attachments', $erattach_insert);
          echo 'SUCCESS';
        }
      }
    }

    function showFiledClosedTips()
    {
      $showTipsInput = $this->input->post('input');
      $error = 0;
      if($showTipsInput)
      {
        $erOptionsSelect = $this->Embismodel->selectdata('er_tips', '*', array( 'userid' => $this->ajaxdata['user']['id'] ) );
        if($erOptionsSelect) {
          $erOptionsUpdate = $this->Embismodel->updatedata( array('filed_closed' => 1), 'er_tips', array('userid' => $this->ajaxdata['user']['id']) );
          $error = !$erOptionsUpdate ? 1 : 0;
        }
        else {
          $erOptionsValues = array(
            'userid'        => $this->ajaxdata['user']['id'],
            'filed_closed'  => 1,
          );
          $erOptionsInsert = $this->Embismodel->insertdata('er_tips', $erOptionsValues);
          $error = !$erOptionsInsert ? 1 : 0;
        }
      }
      echo json_encode($error);
    }

    function showTips()
    {
      $showTipsInput = $this->input->post('input');
      $error = 0;

      if($showTipsInput)
      {
        $erOptionsSelect = $this->Embismodel->selectdata('er_options', '*', array( 'userid' => $this->ajaxdata['user']['id'] ) );
        if($erOptionsSelect) {
          $erOptionsUpdate = $this->Embismodel->updatedata( array('display_tips' => 1), 'er_options', array('userid' => $this->ajaxdata['user']['id']) );
          $error = !$erOptionsUpdate ? 1 : 0;
        }
        else {
          $erOptionsValues = array(
            'userid'        => $this->ajaxdata['user']['id'],
            'display_tips'  => 1,
          );
          $erOptionsInsert = $this->Embismodel->insertdata('er_options', $erOptionsValues);
          $error = !$erOptionsInsert ? 1 : 0;
        }
      }

      echo json_encode($error);
    }

  } // CLASS END
?>
