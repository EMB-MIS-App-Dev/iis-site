
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Pbs extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->load->model('Embismodel');
      $this->load->library('session');

      $this->load->helper(array('form', 'url'));

      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");
    }

    function ptsapiauth(){
      $usertoken = $this->encrypt->encode($this->input->get('token', TRUE));
      $data = array('userid' => $this->session->userdata('userid'), 'token' => $usertoken,'date' => date('Y-m-d'),);
      $insertdata = $this->Embismodel->insertdata('acc_auth',$data);
      // echo "<script>window.location.href='".base_url().'pbsapi/?token='.$usertoken.'&token_id='.$this->input->get('token', TRUE)."'</script>";
      echo "<script>window.location.href='http://122.3.242.36/ptaas/?token=".$usertoken."&token_id=".$this->input->get('token', TRUE)."'</script>";
    }

    function burapiauth(){
      $usertoken = $this->encrypt->encode($this->input->get('token', TRUE));
      $data = array('userid' => $this->session->userdata('userid'), 'token' => $usertoken,'date' => date('Y-m-d'),);
      $insertdata = $this->Embismodel->insertdata('acc_auth',$data);
      // echo "<script>window.location.href='".base_url().'pbsapi/?token='.$usertoken.'&token_id='.$this->input->get('token', TRUE)."'</script>";
      echo "<script>window.location.href='https://122.3.242.36/bur/?token=".$usertoken."&token_id=".$this->input->get('token', TRUE)."'</script>";
    }

    function json(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, OPTIONS");

      // if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") { redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); exit; }

      $usertokenencrypted = $this->input->get('token', TRUE);
      $index = $this->input->get('token_id', TRUE);

      $wheredata = array('aa.token' => $usertokenencrypted, );
      $verifytoken = $this->Embismodel->selectdata('acc_auth AS aa','aa.token,aa.date',$wheredata);

      if(isset($_GET['token_id']) && !is_null($_GET['token_id'])){
        if($_GET['token'] == $verifytoken[0]['token'] AND $verifytoken[0]['date'] == date('Y-m-d')){
          // $whereinfo = array('acs.token' => $_GET['token_id'], );
          $whereinfo = $this->db->where('acs.token = "'.$_GET['token_id'].'"');
          $joininfo = $this->db->join('acc_rights AS ars','ars.userid = acs.userid','left');
          $selectinfo = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.token, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, acs.region, acs.designation, ars.access_pbsbur','',$joininfo,$whereinfo);
          $user_role = ($selectinfo[0]['access_pbsbur'] == 'yes') ? 'Admin' : 'Normal User' ;
          $data = array(
                        'user_token' => $selectinfo[0]['token'],
                        'employee_id' => $selectinfo[0]['userid'],
                        'prefix' => $selectinfo[0]['title'],
                        'first_name' => $selectinfo[0]['fname'],
                        'middle_name' => $selectinfo[0]['mname'],
                        'last_name' => $selectinfo[0]['sname'],
                        'suffix' => $selectinfo[0]['suffix'],
                        'region' => $selectinfo[0]['region'],
                        'designation' => $selectinfo[0]['designation'],
                        'user_role' => $user_role,
                        );
        }
      }
      echo json_encode($data);
    }

  }
