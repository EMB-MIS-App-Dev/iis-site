<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sweet_postactions extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->model('Travelordermodel');
    $this->load->model('Sweetreportmodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');
    $this->load->library('form_validation');

  }

  function process_sweet_report(){

    date_default_timezone_set("Asia/Manila");
    $trans_no_token = $this->encrypt->decode($this->input->post('trans_no'));
    $report_number  = $this->encrypt->decode($this->input->post('report_number'));
    $region   = $this->session->userdata('region');
    $userid   = $this->session->userdata('userid');

    $ip_address = $this->input->ip_address();

    if(isset($_POST['Approve'])){

        $whereform  = $this->db->where('sf.trans_no',$trans_no_token);
        $joinform   = $this->db->join('er_transactions AS et','et.token = sf.trans_no','left');
        $selectform = $this->Embismodel->selectdata('sweet_form AS sf','sf.*,et.trans_no','',$joinform,$whereform);

        $route_order = $selectform[0]['route_order']-1;

        $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($selectform[0]['userid']);
        $where_route_assigned  = $this->db->where('sf.route_order',$route_order);
        $where_route_assigned  = $this->db->where('sf.region',$region);
        $where_route_assigned  = $this->db->where('sf.token',$sweet_func_token);
        $join_route_assigned   = $this->db->join('acc_credentials AS acs','acs.userid = sf.assigned_to','left');
        $route_assigned        = $this->Embismodel->selectdata('sweet_func AS sf','sf.*,acs.fname,acs.sname','',$join_route_assigned,$where_route_assigned);

        $trans_no   = $selectform[0]['trans_no'];
        $assignedto = $route_assigned[0]['assigned_to'];

        //Receiver
        $wherereceiver = $this->db->where('acs.userid',$assignedto);
        $wherereceiver = $this->db->where('af.stat','1');
        $wherereceiver = $this->db->where('acs.verified','1');
        $join          = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
        $join          = $this->db->join('acc_xdvsion AS xn','xn.divno = af.divno','left');
        $join          = $this->db->join('acc_xsect AS xt','xt.secno = af.secno','left');
        $receiver      = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.designation,acs.title,acs.fname,acs.sname,acs.suffix,acs.region,xn.divno,xn.divname,xt.sect,xt.secno','',$join,$wherereceiver);

        $rmname = (!empty($receiver[0]['mname'])) ? $receiver[0]['mname'][0].". " : "";
        $rsuffix = (!empty($receiver[0]['suffix'])) ? " ".$receiver[0]['suffix'] : "";
        $rprefix = (!empty($receiver[0]['title'])) ? $receiver[0]['title']." " : "";
        $rname = $rprefix.$receiver[0]['fname']." ".$rmname.$receiver[0]['sname'].$rsuffix;
        //Receiver

        //Sender
        $wheresender   = $this->db->where('acs.userid = "'.$this->session->userdata('userid').'" AND acs.verified = "1"');
        $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.title,acs.fname,acs.sname,acs.suffix,acs.divno,acs.secno','',$wheresender);
        $smname = (!empty($qrysender[0]['mname'])) ? $qrysender[0]['mname'][0].". " : "";
        $ssuffix = (!empty($qrysender[0]['suffix'])) ? " ".$qrysender[0]['suffix'] : "";
        $sprefix = (!empty($qrysender[0]['title'])) ? $qrysender[0]['title']." " : "";
        $sname = $sprefix.$qrysender[0]['fname']." ".$smname.$qrysender[0]['sname'].$ssuffix;
        //Sender

        $wherelog  = $this->db->where('et.trans_no = "'.$trans_no.'" AND et.route_order = (SELECT MAX(et2.route_order) FROM er_transactions_log AS et2 WHERE et2.trans_no = "'.$trans_no.'")');
        $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);


      if($route_order < '1' OR $route_order == '0'){ //last route
        $statusform         = "Signed Document";
        $route_status       = "5";
        $status_description = "signed document";
        $action_taken       = 'Signed Document ('.$selectform[0]['report_type'].')';
        $receiver_divno     = "";
        $receiver_secno     = "";
        $receiver_id        = "";
        $receiver_name      = "";
        $receiver_region    = "";

      }else{
        $statusform         = 'On-Process';
        $route_status       = $translog[0]['status'];
        $status_description = $translog[0]['status_description'];
        $action_taken       = $translog[0]['action_taken'];
        $receiver_divno     = $receiver[0]['divno'];
        $receiver_secno     = $receiver[0]['secno'];
        $receiver_id        = $receiver[0]['token'];
        $receiver_name      = $rname;
        $receiver_region    = $receiver[0]['region'];

      }
    }

    if(isset($_POST['Disapprove']) AND !empty($_POST['return_reason'])){

        $return_reason = $_POST['return_reason'];
        $whereform  = $this->db->where('sf.trans_no',$trans_no_token);
        $joinform   = $this->db->join('er_transactions AS et','et.token = sf.trans_no','left');
        $selectform = $this->Embismodel->selectdata('sweet_form AS sf','sf.*,et.trans_no','',$joinform,$whereform);

        $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($selectform[0]['userid']);
        $maxrouteorder = $this->Sweetreportmodel->max_func($sweet_func_token);
        if($selectform[0]['route_order'] == $maxrouteorder){
          $assignedto = $selectform[0]['userid'];
        }else{
          $route_order = $selectform[0]['route_order']+1;
          $where_route_assigned  = $this->db->where('sf.route_order = "'.$route_order.'" AND sf.region = "'.$region.'" AND sf.token = "'.$sweet_func_token.'"');
          $join_route_assigned   = $this->db->join('acc_credentials AS acs','acs.userid = sf.assigned_to','left');
          $route_assigned        = $this->Embismodel->selectdata('sweet_func AS sf','sf.*,acs.fname,acs.sname','',$join_route_assigned,$where_route_assigned);
          $assignedto = $route_assigned[0]['assigned_to'];
        }

        // echo $assignedto; exit;

        $trans_no   = $selectform[0]['trans_no'];

        //Receiver
        $wherereceiver = $this->db->where('acs.userid',$assignedto);
        $wherereceiver = $this->db->where('af.stat','1');
        $wherereceiver = $this->db->where('acs.verified','1');
        $join          = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
        $join          = $this->db->join('acc_xdvsion AS xn','xn.divno = af.divno','left');
        $join          = $this->db->join('acc_xsect AS xt','xt.secno = af.secno','left');
        $receiver      = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.designation,acs.title,acs.fname,acs.sname,acs.suffix,acs.region,xn.divno,xn.divname,xt.sect,xt.secno','',$join,$wherereceiver);
        $rmname = (!empty($receiver[0]['mname'])) ? $receiver[0]['mname'][0].". " : "";
        $rsuffix = (!empty($receiver[0]['suffix'])) ? " ".$receiver[0]['suffix'] : "";
        $rprefix = (!empty($receiver[0]['title'])) ? $receiver[0]['title']." " : "";
        $rname = $rprefix.$receiver[0]['fname']." ".$rmname.$receiver[0]['sname'].$rsuffix;
        //Receiver

        //Sender
        $wheresender   = $this->db->where('acs.userid = "'.$this->session->userdata('userid').'" AND acs.verified = "1"');
        $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.title,acs.fname,acs.sname,acs.suffix,acs.divno,acs.secno','',$wheresender);
        $smname = (!empty($qrysender[0]['mname'])) ? $qrysender[0]['mname'][0].". " : "";
        $ssuffix = (!empty($qrysender[0]['suffix'])) ? " ".$qrysender[0]['suffix'] : "";
        $sprefix = (!empty($qrysender[0]['title'])) ? $qrysender[0]['title']." " : "";
        $sname = $sprefix.$qrysender[0]['fname']." ".$smname.$qrysender[0]['sname'].$ssuffix;
        //Sender

        $wherelog  = $this->db->where('et.trans_no = "'.$trans_no.'" AND et.route_order = (SELECT MAX(et2.route_order) FROM er_transactions_log AS et2 WHERE et2.trans_no = "'.$trans_no.'")');
        $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);

        $statusform         = 'For return - '.$return_reason;
        $route_status       = '9';
        $status_description = 'For return';
        $action_taken       = 'Pls. for review - '.$return_reason;
        $receiver_divno     = $receiver[0]['divno'];
        $receiver_secno     = $receiver[0]['secno'];
        $receiver_id        = $receiver[0]['token'];
        $receiver_name      = $rname;
        $receiver_region    = $receiver[0]['region'];

    }

     if(isset($_POST['Approve']) OR (isset($_POST['Disapprove']) AND !empty($_POST['return_reason']))){

        //Route form
        $data = array(
          'status'        => $statusform,
          'route_order'   => !empty($route_order) ? $route_order : 0,
          'assigned_to'   => $assignedto,
          'assigned_name' => $receiver_name,
        );

        $where_update_form = array(
          'sf.trans_no' => $trans_no_token,
        );

        $update_form = $this->Embismodel->updatedata($data, 'sweet_form AS sf', $where_update_form);

        $datasfl = array(
          'status'        => $statusform,
          'route_order'   => !empty($route_order) ? $route_order : 0,
          'assigned_to'   => $assignedto,
          'assigned_name' => $receiver_name,
        );

        $where_update_formsfl = array(
          'sfl.trans_no'      => $trans_no_token,
          'sfl.report_number' => $report_number,
        );

        $update_formsfl = $this->Embismodel->updatedata($datasfl, 'sweet_form_log AS sfl', $where_update_formsfl);

        if(empty($_POST['return_reason'])){
          $insert_sweet_route_log = array(
                                          'trans_no'      => $trans_no_token,
                                          'report_number' => $report_number,
                                          'assigned_to'   => $this->session->userdata('userid'),
                                          'designation'   => $this->session->userdata('designation'),
                                          'name'          => $sname,
                                         );
          $sweet_route_log = $this->Embismodel->insertdata('sweet_route_log', $insert_sweet_route_log);
        }

        $date_out  = date('Y-m-d H:i:s');

        $data_log = array(
          'trans_no'              => $translog[0]['trans_no'],
          'route_order'           => $translog[0]['route_order']+1,
          'subject'               => $translog[0]['subject'],
          'sender_divno'          => $qrysender[0]['divno'],
          'sender_secno'          => $qrysender[0]['secno'],
          'sender_id'             => $this->session->userdata('token'),
          'sender_name'           => $sname,
          'sender_region'         => $translog[0]['sender_region'],
          'sender_ipadress'       => $ip_address,
          'receiver_divno'        => $receiver_divno,
          'receiver_secno'        => $receiver_secno,
          'receiver_id'           => $receiver_id,
          'receiver_name'         => $receiver_name,
          'receiver_region'       => $receiver_region,
          'type'                  => $translog[0]['type'],
          'status'                => $route_status,
          'status_description'    => $status_description,
          'action_taken'          => $action_taken,
          'date_in'               => $date_out,
          'date_out'              => $date_out,
        );

        $etl_update = $this->Embismodel->insertdata( 'er_transactions_log', $data_log );

        $set = array(
          'et.route_order'        => $translog[0]['route_order']+1,
          'status'                => $route_status,
          'status_description'    => $status_description,
          'et.receive'            => 0,
          'et.sender_id'          => $qrysender[0]['token'],
          'et.sender_name'        => $sname,
          'et.receiver_division'  => $receiver[0]['divname'],
          'et.receiver_section'   => $receiver[0]['sect'],
          'receiver_region'       => $receiver[0]['region'],
          'et.receiver_id'        => $receiver_id,
          'et.receiver_name'      => $receiver_name,
          'et.action_taken'       => $action_taken,
        );

        $where = array( 'et.trans_no' => $trans_no);
        $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

        if($result){
          if(isset($_POST['Approve'])){
            $swal_arr = array(
               'title'     => 'SUCCESS!',
               'text'      => 'Sweet report successfully approved.',
               'type'      => 'success',
             );
             $this->session->set_flashdata('swal_arr', $swal_arr);
            echo "<script>window.location.href='".base_url()."Swm/Sweet'</script>";
          }

          if(isset($_POST['Disapprove'])){
            $swal_arr = array(
               'title'     => 'SUCCESS!',
               'text'      => 'Sweet report successfully returned.',
               'type'      => 'success',
             );
             $this->session->set_flashdata('swal_arr', $swal_arr);
            echo "<script>window.location.href='".base_url()."Swm/Sweet'</script>";
          }
        }
      }

  }

  function assignswuser(){
    $token = ($this->input->post('token', TRUE));
    $func  = $this->encrypt->decode($this->input->post('func', TRUE));
    if(!empty($token) AND !empty($func)){
      foreach ($token as $key => $value) {
        $whereuserid = array('acs.token' => $value);
        $selectuserid = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid',$whereuserid);
        if(!empty($selectuserid[0]['userid'])){
          $data = array(
                        'userid'     => $selectuserid[0]['userid'],
                        'func_token' => $func,
                        'date_added' => date('Y-m-d'),
                       );
          $this->Embismodel->insertdata('sweet_func_user',$data);
        }
      }
    }
  }

  function rmvassngmntsw(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    if(!empty($token)){
      $this->db->where('userid', $token);
      $this->db->delete('sweet_func_user');
    }
  }

  function rmvtemplatesw(){
    $token = ($this->input->post('token', TRUE));
    if(!empty($token)){
      // $this->db->where('token', $token);
      // $this->db->delete('sweet_func');
      $setdata = array('stat' => '2', );
      $wheredata = array('token' => $token, );
      $updatedata = $this->Embismodel->updatedata($setdata,'sweet_func',$wheredata);
    }
  }

  function assigntemplatesw(){
    $tokenval = $this->session->userdata('userid').rand();
    $token = ($this->input->post('token', TRUE));
    $hname = ($this->input->post('hname', TRUE));

    $whereexist = array('sf.func_name' => $hname, 'sf.stat' => '1');
    $ifexist = $this->Embismodel->selectdata('sweet_func AS sf','sf.func_name',$whereexist);

    $cnt=0;
    if(empty($ifexist[0]['func_name'])){
      foreach ($token as $key => $value) {
        $whereuserid = array('acs.token' => $value);
        $selectuserid = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, acs.designation',$whereuserid);
        $prefix = (!empty($selectuserid[0]['title'])) ? $selectuserid[0]['title']." " : "";
        $mname = (!empty($selectuserid[0]['mname'])) ? $selectuserid[0]['mname'][0].". " : "";
        $suffix = (!empty($selectuserid[0]['suffix'])) ? " ".$selectuserid[0]['suffix'] : "";
        $name = $prefix.ucwords($selectuserid[0]['fname']." ".$mname.$selectuserid[0]['sname']).$suffix;
        if(!empty($selectuserid[0]['userid']) AND !empty($hname)){
          $cnt++;
          $data = array(
                          'token'       => $tokenval,
                          'date_added'  => date("Y-m-d"),
                          'func_name'   => $hname,
                          'region'      => $this->session->userdata('region'),
                          'assigned_to' => $selectuserid[0]['userid'],
                          'name'        => trim($name),
                          'designation' => trim($selectuserid[0]['designation']),
                          'route_order' => $cnt,
                          'stat'        => '1',
                       );
          $this->Embismodel->insertdata('sweet_func',$data);
        }
      }
    }else{
      echo $hname;
    }
  }

  function swsavelgudata(){
    if(!empty($_POST['swofficer']) AND (count($_POST['swlgu'])) > 0){

      $whereuserid = $this->db->where('acs.token = "'.$_POST['swofficer'].'" AND acs.verified = "1"');
      $selectuserid = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$whereuserid);
      $prefix = (!empty($selectuserid[0]['title'])) ? $selectuserid[0]['title']." " : "";
      $mname = (!empty($selectuserid[0]['mname'])) ? $selectuserid[0]['mname'][0].". " : "";
      $suffix = (!empty($selectuserid[0]['suffix'])) ? " ".$selectuserid[0]['suffix'] : "";
      $name = $prefix.$selectuserid[0]['fname']." ".$mname.$selectuserid[0]['sname'].$suffix;

      $cntr = 0;
      for ($i=0; $i < count($_POST['swlgu']); $i++) {

        $wherecompany = $this->db->where('dc.emb_id = "'.$_POST['swlgu'][$i].'"');
        $selectcompany = $this->Embismodel->selectdata('dms_company AS dc','dc.company_name','',$wherecompany);

        $wheredata = array(
                           'userid'   => $selectuserid[0]['userid'],
                           'name'     => $name,
                           'emb_id'   => $_POST['swlgu'][$i],
                           'lgu_name' => $selectcompany[0]['company_name'],
                           'region'   => $this->session->userdata('region'),
                          );
        $insertdata = $this->Embismodel->insertdata('sweet_lgu_assigned',$wheredata);
        if($insertdata){ $cntr++;
          if($cntr == '1'){
            echo json_encode(array('status' => 'success', ));
          }
        }
      }
    }else{
      echo json_encode(array('status' => 'failed', ));
    }
  }

  function rmvassignedlgu(){
    $cnt = $this->encrypt->decode($_POST['cnt']);
    if(!empty($cnt)){
      $wheredata = array('cnt' => $cnt, );
      $deletedata = $this->Embismodel->deletedata('sweet_lgu_assigned',$wheredata);
      echo json_encode(array('status' => 'success', ));
    }else{
      echo json_encode(array('status' => 'failed', ));
    }
  }

  function process_novletter(){
    date_default_timezone_set("Asia/Manila");

    $trans_no = $this->encrypt->decode($_POST['token']);

    $rn = $this->encrypt->decode($_POST['rn']);
    $cnt = $this->encrypt->decode($_POST['cnt']);
    $assignedto = $this->encrypt->decode($_POST['assignedto']);
    $trans_status = $this->encrypt->decode($_POST['trans_status']);

    if(!empty($trans_no) AND !empty($rn) AND !empty($trans_status)){

      $wherestatus = $this->db->where('es.id = "'.$trans_status.'"');
      $selectstatus = $this->Embismodel->selectdata('er_status AS es','','',$wherestatus);

      $ip_address = $this->input->ip_address();

      $wheresender   = $this->db->where('acs.userid = "'.$this->session->userdata('userid').'" AND acs.verified = "1"');
      $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.title,acs.fname,acs.sname,acs.suffix,acs.divno,acs.secno,acs.region','',$wheresender);
      $smname = (!empty($qrysender[0]['mname'])) ? $qrysender[0]['mname'][0].". " : "";
      $ssuffix = (!empty($qrysender[0]['suffix'])) ? " ".$qrysender[0]['suffix'] : "";
      $sprefix = (!empty($qrysender[0]['title'])) ? $qrysender[0]['title']." " : "";
      $sname = $sprefix.$qrysender[0]['fname']." ".$smname.$qrysender[0]['sname'].$ssuffix;

      $wherereceiver = $this->db->where('acs.userid',$assignedto);
      $wherereceiver = $this->db->where('af.stat','1');
      $wherereceiver = $this->db->where('acs.verified','1');
      $join          = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
      $join          = $this->db->join('acc_xdvsion AS xn','xn.divno = af.divno','left');
      $join          = $this->db->join('acc_xsect AS xt','xt.secno = af.secno','left');
      $receiver      = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.token,acs.designation,acs.title,acs.fname,acs.sname,acs.suffix,acs.region,xn.divno,xn.divname,xt.sect,xt.secno','',$join,$wherereceiver);

      $prefix = (!empty($receiver[0]['title'])) ? $receiver[0]['title'].' ': '';
      $mname = (!empty($receiver[0]['mname'])) ? $receiver[0]['mname'][0].'. ': '';
      $suffix = (!empty($receiver[0]['suffix'])) ? ' '.$receiver[0]['suffix']: '';
      $name = $prefix.$receiver[0]['fname'].' '.$mname.$receiver[0]['sname'].$suffix;

      $assigneduserid = $receiver[0]['userid'];
      $receiver_name = $name;

      if($trans_status == '5'){
        $assigneduserid = '';
        $receiver_name = '';
        $action_taken = 'Signed Document (NOV Letter)';
        $status_taken = 'Signed Document';
      }else{
        $action_taken = $_POST['remarks'];
        if($trans_status == '6'){
          $status_taken = 'Disapproved';
        }if($trans_status == '15'){
          $status_taken = 'On-Process';
        }if($trans_status == '20'){
          $status_taken = 'Returned';
        }
      }

      $datanovletter = array(
        'status' => $status_taken,
        'assigned_to'  => ((!empty($assignedto)) ? $assignedto : '-'),
        'assigned_name' => $receiver_name,
      );

      $wherenovletter = array(
        'trans_no' => $trans_no,
        'report_number' => $rn,
        'cnt' => $cnt,
      );

      $updatenovletter = $this->Embismodel->updatedata($datanovletter, 'sweet_nov_letter', $wherenovletter);

      $date_out  = date('Y-m-d H:i:s');

      $et_where = array('et.token' => $trans_no);
      $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', 'et.trans_no, et.route_order, et.trans_no, et.subject, et.type', $et_where );

      $set = array(
        'et.route_order'        => $er_trans_query[0]['route_order']+1,
        'status'                => $selectstatus[0]['id'],
        'status_description'    => $selectstatus[0]['name'],
        'et.receive'            => 0,
        'et.sender_id'          => $qrysender[0]['token'],
        'et.sender_name'        => $sname,
        'et.receiver_division'  => $receiver[0]['divname'],
        'et.receiver_section'   => $receiver[0]['sect'],
        'receiver_region'       => $receiver[0]['region'],
        'et.receiver_id'        => $receiver[0]['token'],
        'et.receiver_name'      => $receiver_name,
        'et.action_taken'       => $action_taken,
      );

      $where = array( 'et.trans_no' => $er_trans_query[0]['trans_no']);
      $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

      $data_log = array(
        'trans_no'              => $er_trans_query[0]['trans_no'],
        'route_order'           => $er_trans_query[0]['route_order']+1,
        'subject'               => $er_trans_query[0]['subject'],
        'sender_divno'          => $qrysender[0]['divno'],
        'sender_secno'          => $qrysender[0]['secno'],
        'sender_id'             => $qrysender[0]['token'],
        'sender_name'           => $sname,
        'sender_region'         => $qrysender[0]['region'],
        'sender_ipadress'       => $ip_address,
        'receiver_divno'        => ((!empty($receiver[0]['divno'])) ? $receiver[0]['divno'] : ''),
        'receiver_secno'        => ((!empty($receiver[0]['secno'])) ? $receiver[0]['secno'] : ''),
        'receiver_id'           => ((!empty($receiver[0]['token'])) ? $receiver[0]['token'] : ''),
        'receiver_name'         => ((!empty($receiver[0]['token'])) ? $receiver_name : ''),
        'receiver_region'       => ((!empty($receiver[0]['region'])) ? $receiver[0]['region'] : ''),
        'type'                  => $er_trans_query[0]['type'],
        'status'                => $selectstatus[0]['id'],
        'status_description'    => $selectstatus[0]['name'],
        'action_taken'          => $action_taken,
        'date_in'               => $date_out,
        'date_out'              => $date_out,
      );

      $etl_update = $this->Embismodel->insertdata( 'er_transactions_log', $data_log );

      $swal_arr = array(
         'title'     => 'SUCCESS!',
         'text'      => 'NOV letter successfully processed.',
         'type'      => 'success',
       );
       $this->session->set_flashdata('swal_arr', $swal_arr);
      echo "<script>window.location.href='".base_url()."Swm/Sweet'</script>";
    }
  }
}
