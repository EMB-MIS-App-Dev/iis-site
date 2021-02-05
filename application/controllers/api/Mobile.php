
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Mobile extends CI_Controller
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

    function dtr(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, OPTIONS");

      $token = $_GET['token']; //userid
      $api_key = $_GET['api_key'];
      if($api_key == "qwerty"){

        $wheredata = $this->db->where('acs.token = "'.trim($token).'"');
        $selectdata = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$wheredata);

        $mname = !empty($selectdata[0]['mname']) ? $selectdata[0]['mname'][0].'. ' : '';
  			$suffix = !empty($selectdata[0]['suffix']) ? ' '.$selectdata[0]['suffix'] : '';
  			$title = !empty($selectdata[0]['title']) ? $selectdata[0]['title'].' ' : '';
  			$name = $title.$selectdata[0]['fname'].' '.$mname.$selectdata[0]['sname'].$suffix;

        echo json_encode(array($name,date('F d, Y - h:ia')));
      }else{
        echo json_encode(array('Invalid api key'));
      }

    }

  }
