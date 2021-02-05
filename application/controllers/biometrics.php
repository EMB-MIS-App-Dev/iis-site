
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class biometrics extends CI_Controller
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

    function index(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, OPTIONS");

      $timid   = $this->encrypt->decode($_POST['tokenone']);
      $region_staff   = $this->encrypt->decode($_POST['tokentwo']);
      $time    = $this->encrypt->decode($_POST['tokenthree']);
      $date    = $this->encrypt->decode($_POST['tokenfour']);
      $sent    = $this->encrypt->decode($_POST['tokenfive']);
      $region  = $this->encrypt->decode($_POST['tokensix']);
      $fname   = $this->encrypt->decode($_POST['tokenseven']);
      $mname   = $this->encrypt->decode($_POST['tokeneight']);
      if(!empty($mname)){ $mn = $mname." "; }else{ $mn = ""; }
      $sname   = $this->encrypt->decode($_POST['tokennine']);

      echo $fname.$mn.$sname;

      if($timid != '' AND $region_staff != '' AND $time != '' AND $date != '' AND $sent != '' AND $region != ''){

        if($region == 'R7'){ $table = 'embis.biometrics_r7'; }
          $data        = array(
                        'biometrics_r7.token_no'       => $region."-".$timid,
                        'biometrics_r7.region'         => $region,
                        'biometrics_r7.staff'          => $region."-".$region_staff,
                        'biometrics_r7.name'           => $fname." ".$mn.$sname,
                        'biometrics_r7.punch_time'     => $time,
                        'biometrics_r7.punch_date'     => $date,
                   );

          $insert = $this->Embismodel->insertdata($table,$data);

          if($insert){
            echo "Inserted";
          }

      }
      

    }

  }
?>
