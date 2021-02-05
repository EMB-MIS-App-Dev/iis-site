<?php

class Data extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->library('session');

    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    $this->load->library('upload');

    $this->load->library('encryption');

    date_default_timezone_set("Asia/Manila");

    // Datatables Custom Views
    $this->load->view('Dms/func/datecount.php');
  }

  function set_trans_session($trans_no)
  {
    $this->session->set_userdata( 'trans_session', $this->input->post('trans_no') );
  }

  function receive_transaction()
  {
    $data =  array(
      'trans_no'      => $this->input->post('trans_no'),
      'multiprc'      => $this->input->post('multiprc'),
      'region'        => $this->session->userdata('region'),
      'sender_divno'  => $this->dmsdata['user_func']['divno'],
      'sender_secno'  => $this->dmsdata['user_func']['secno'],
      'sender_id'     => $this->session->userdata('token'),
      'date_in'       => date('Y-m-d H:i:s'),
    );
  }

  function charts()
  {

    // $chart['insert'] = array(
    //   'et.date1' => '2020-04-08',
    //   'et.date2' => '2020-04-11',
    // );
    $chart['where'] = $this->db->where('(DATE(et.start_date) BETWEEN "2020-04-08" AND "2020-04-11")');
    $chart = $this->Embismodel->selectdata('er_transactions et', '', '', $chart['where']);

    foreach ($chart as $key => $value) {
      $data[] = array('x' => $value['start_date'], 'y' => 1 );
    }

    echo json_encode($data);
  }

  function login_count()
  {
      $type = ($this->session->userdata('region') == 'CO') ? 'co' : 'region';
      $xdiv['where'] = array('xd.type' => $type );
      $xdiv = $this->Embismodel->selectdata('acc_xdvsion xd', '', $xdiv['where']);


      foreach ($xdiv as $key => $value) {
        $cred['where'] = array(
          'DATE(ac.timestamp)'  => date("Y-m-d"),
          'ac.divno'            => $value['divno'],
          'ac.region'           => $this->session->userdata('region'),
          'ac.verified'         => 1
         );
        $cred = $this->Embismodel->selectdata('acc_credentials ac', 'COUNT(ac.userid) maxcnt', $cred['where']);

        $data[] = array(
          'divno' => $value['divno'],
          'divname' => $value['divname'],
          'maxcnt' => $cred[0]['maxcnt'],
        );
      }

      echo json_encode($data);
  }

  function login_count_modal()
  {
      $divno = $this->input->post('divno');
      $region = $this->session->userdata('region');
      $where['axsna_xsect'] = array('axsna.region' => $region);
      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axsna', '', $where['axsna_xsect'] );
      $xsct = '0';

      if(!empty($exclude_sect))
      {
        foreach($exclude_sect as $key => $value) {
          if(count($exclude_sect)-1 == $key)
          {
            $xsct .= $value['secno'];
          }
          else {
            $xsct .= $value['secno'].',';
          }
        }
      }

      if($region != 'CO') {
        $where['xsect'] = $this->db->where('axs.divno = "'.$divno.'" AND ( axs.region = "'.$region.'" OR axs.region = "R" ) AND axs.secno NOT IN ('.$xsct.')');
      }
      else {
        $where['xsect'] = $this->db->where('axs.divno = "'.$divno.'" AND axs.region = "'.$region.'"');
      }
      $xsect = $this->Embismodel->selectdata('acc_xsect AS axs', '', '', $where['xsect']);

      $where['cred'] = array(
        'DATE(ac.timestamp)'  => date("Y-m-d"),
        'ac.secno'            => '',
        'ac.region'           => $region,
        'ac.divno'            => $divno
      );
      $cred = $this->Embismodel->selectdata('acc_credentials ac', 'COUNT(ac.userid) maxcnt', $where['cred']);

      $data[0] = array(
        'secno'   => 0,
        'sect'    => '- Main -',
        'divno'   => $divno,
        'maxcnt'  => !empty($cred[0]['maxcnt']) ? $cred[0]['maxcnt'] : 0
      );

      foreach ($xsect as $key => $value) {
        $where['cred'] = array(
          'DATE(ac.timestamp)'  => date("Y-m-d"),
          'ac.secno'            => $value['secno'],
          'ac.region'           => $region,
          'ac.divno'            => $divno
        );
        $cred = $this->Embismodel->selectdata('acc_credentials ac', 'COUNT(ac.userid) maxcnt', $where['cred']);

        $data[$key+1] = array(
          'secno'   => $value['secno'],
          'sect'    => $value['sect'],
          'divno'   => $divno,
          'maxcnt'  => $cred[0]['maxcnt']
        );
      }

      echo json_encode($data);
  }

  function login_count_accordion()
  {
      $secno = !empty($this->input->post('secno')) ? $this->input->post('secno') : '';
      $divno = $this->input->post('divno');
      $region = $this->session->userdata('region');
      $where = array(
        'DATE(ac.timestamp)'  => date("Y-m-d"),
        'ac.secno'            => $secno,
        'ac.divno'            => $divno,
        'ac.region'           => $region,
        'ac.verified'         => 1
      );
      // $where['xsect'] = $this->db->where('axs.divno = "'.$divno.'" AND axs.region = "'.$region.'"');
      $cred = $this->Embismodel->selectdata('acc_credentials ac', '', $where);

      foreach ($cred as $key => $value) {
        $mname = !empty($value['mname']) ? ' '.trim($value['mname'][0]).'. ' : ' ';
        $suffix = !empty($value['suffix']) ? ' '.trim($value['suffix']) : '';
        $data[] = array('name' => ucwords($value['fname'].$mname.$value['sname'].$suffix), 'timestamp' => date("H:i:s", strtotime($value['timestamp'])) );
      }

      echo json_encode($data);
  }

  function multiprc_to_user()
  {
      $trans_no = $this->input->post('trans_no');

      $mtno['where'] = array(
        'etm.trans_no'    => $trans_no,
        'etm.receiver_id' => $this->session->userdata('token'),
      );
      $mtno = $this->Embismodel->selectdata('er_transactions_multi etm', '', $mtno['where']);

      // echo $this->db->last_query();

      foreach ($mtno as $key => $value) {

        $embid = explode("-", $value['emb_id']);

        $data[] = array(
          'trans_no'            => $value['trans_no'],
          'token'               => $value['token'],
          'multiprc'            => $value['multiprc'],
          'main_multi_cntr'     => $value['main_multi_cntr'],
          'multi_cntr'          => $value['multi_cntr'],
          'company_name'        => $value['company_name'],
          'emb_id'              => $embid[0].'-'.$embid[2],
          'subject'             => $value['subject'],
          'type_description'    => $value['type_description'],
          'receive'             => $value['receive'],
          'status_description'  => $value['status_description'],
          'action_taken'        => $value['action_taken'],
          // 'date_forwarded'   => $value['date_forwarded'],
          'sender_name'         => ucwords($value['sender_name']),
          // 'date_received'    => $value['date_received'],
          'remarks'             => $value['remarks'],
        );
      }

      echo json_encode($data);
  }

  function r7iscon()
  {
    $id = $this->encrypt->encode($this->session->userdata('userid'));

    echo "<script>document.write(localStorage.setItem('uid', ".$id."));</script>";

    $user_email = "<script>document.write(localStorage.setItem('uid', ".$id."));</script>";

    redirect('http://7.emb.gov.ph/emb7is/');
  }

  function ddsample123()
  {
    $data = $this->input->post();
    print_r($data);
  }
}
