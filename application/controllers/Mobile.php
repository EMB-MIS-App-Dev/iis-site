<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mobile extends CI_Controller
{

	function __construct()
	{
    parent::__construct();
    header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('Embismodel');
    	$this->load->library('session');
    date_default_timezone_set("Asia/Manila");
	}

	function index(){

    // $datas = $this->input->post('data');
    // $data= json_decode($datas);
    //
    // $this->login($data);
    // $this->dashboard()

  }
function auth(){
  // $query['user_auth'] = array('username' =>$_GET['username'] ,'password' =>$_GET['password'] );
  // echo "<pre>";print_r($query['user_auth']);exit;
  $this->load->view('includes/login/header');
  $this->load->view('login_mobile');
  $this->load->view('includes/login/footer');
}


  function login($datapost){

      // $un          = $this->input->post('username');
      // $pw          = $this->input->post('password');
      $encuname = $this->encrypt->encode($datapost->username);
      $decpass	= $this->encrypt->encode($datapost->password);

      if (!empty($encuname) && !empty($decpass)) {
        $un = $this->encrypt->decode($encuname);
        $pw = $this->encrypt->decode($decpass);
      }

      $usern       = str_replace('ñ', '&ntilde;', trim($un));
      $passw       = str_replace('ñ', '&ntilde;', trim($pw));
      $username    = str_replace('Ñ', '&ntilde;', trim($usern));
      $password    = str_replace('Ñ', '&ntilde;', trim($passw));

      $wheredecode = $this->db->where('acc.username',$username);
      $querydecode = $this->Embismodel->selectdata('embis.acc','*','',$wheredecode);

      $userid_decode = "";
      for ($i=0; $i <sizeof($querydecode) ; $i++) {
        if($querydecode[$i]['username'] == $username AND $this->encrypt->decode($querydecode[$i]['raw_password']) == $pw){
          $userid_decode = $querydecode[$i]['userid'];
        }
      }

      $values      = $this->db->where('acc.acc_status', '1');
      $values      = $this->db->where('acc.username', $this->db->escape_str($username));
      $values      = $this->db->where('acc.userid', $userid_decode);
      $join        = $this->db->join('embis.acc_credentials AS as', 'as.userid = acc.userid', 'left');
      $join        = $this->db->join('embis.acc_function AS xc', 'xc.userid = as.userid', 'left');
      $queryselect = $this->Embismodel->selectdata('embis.acc','xc.secno,xc.divno,acc.userid,acc.acc_status,acc.username,acc.en_password,acc.reset,as.verified,as.region,as.division,as.section,as.designation,xc.func,as.user_photo,as.display_name,as.title,as.fname,as.mname,as.sname,as.suffix,as.token,as.office','',$values,$join);
      // echo $this->db->last_query(); exit;

      $values2 = array('rgnnum' => $queryselect[0]['region'], );
      $queryselect_rgn = $this->db->select('acc_rgn.rgnid,acc_rgn.rgnnum')->from('embis.acc_region as acc_rgn')->where($values2)->get()->result_array();
      // echo $queryselect_rgn[0]['rgnid'];exit;
      if($queryselect != '' && password_verify($this->db->escape_str($password), $queryselect[0]['en_password'])){
        $mname = (!empty($queryselect[0]['mname'])) ? $queryselect[0]['mname'][0].". " : "";
        $suffix = (!empty($queryselect[0]['suffix'])) ? " ".$queryselect[0]['suffix'] : "";
        $prefix = (!empty($queryselect[0]['title'])) ? $queryselect[0]['title']." " : "";
        $name = $prefix.ucwords($queryselect[0]['fname']." ".$mname.$queryselect[0]['sname']).$suffix;
        $user_photo = (!empty($queryselect[0]['user_photo'])) ? base_url().'uploads/profilepictures/'.$queryselect[0]['token'].'/'.$queryselect[0]['user_photo'] : base_url().'assets/images/default-user.png' ;
        $data = array(
          'userid'        => $queryselect[0]['userid'],
          'display_name'  => $queryselect[0]['display_name'],
          'region'        => $queryselect_rgn[0]['rgnnum'],
          'region_id'     => $queryselect_rgn[0]['rgnid'],
          'office'        => $queryselect[0]['office'],
          'division'      => $queryselect[0]['division'],
          'section'       => $queryselect[0]['section'],
          'divno'         => $queryselect[0]['divno'],
          'secno'         => $queryselect[0]['secno'],
          'designation'   => $queryselect[0]['designation'],
          'func'          => $queryselect[0]['func'],
          'name'          => $name,
          'token'         => $queryselect[0]['token'],
          'user_photo'    => $user_photo,
          'form_trial'    => 0,
          'host' 				  => '192.168.91.198:3306',
          'user' 				  => 'overseer',
          'pass' 				  => 'agentx3mbvii158459',
          'db'   				  => 'embis',
           'logged_in'    => TRUE
        );
        $this->session->set_userdata($data);

        $cp_where = array('ac.userid' => $queryselect[0]['userid'] );
        $cpass = $this->Embismodel->selectdata('embis.acc AS ac', '', $cp_where);

        if($cpass[0]['cpass'] == 0) {
          redirect(base_url('index/changepass'));
        }

        $userid      = $this->session->userdata('userid');
        $region      = $this->session->userdata('region');
        $division    = $this->session->userdata('division');
        $section     = $this->session->userdata('section');
        $unit        = $this->session->userdata('unit');
        $designation = $this->session->userdata('designation');
        $func        = $this->session->userdata('func');

        $verified    = $queryselect[0]['verified'];
        $reset       = $queryselect[0]['reset'];

        $ip_address = $this->input->ip_address();
        $time = date("Y-m-d H:i");

        $data = array(
          'ip_address' => $ip_address,
          'timestamp'  => $time,
        );

        $where = array('userid' => $queryselect[0]['userid']);
        $this->Embismodel->updatedata( $data,'acc_credentials',$where);

        //USER OPTIONS
        $ao_where  = $this->db->where('ao.userid = "'.$queryselect[0]['userid'].'"');
        $acc_option = $this->Embismodel->selectdata('acc_options ao', '', '', $ao_where);
        if(!empty($acc_option)) {
          $this->session->set_userdata('acc_options', $acc_option[0]);
        }
        else {
          $this->session->set_userdata('acc_options', '');
        }


        if($userid != '' AND $verified != '0' AND $queryselect[0]['acc_status'] != '0'){
          if($queryselect[0]['verified'] == '1' AND $queryselect[0]['acc_status'] == '1'){
            // ACC LOGS

            $insert['acc_logs'] = array(
              'userid' 		=> $queryselect[0]['userid'],
              'log_stat' 	=> 0,
              'log_date' 	=> date('Y-m-d H:i:s'),
            );
            $result['acc_logs'] = $this->Embismodel->insertdata('acc_logs', $insert['acc_logs']);

            echo "".base_url()."dashboard";
          }
        }else if($userid != '' AND $verified != '0' AND $reset == ''){
          echo "'Your account still needs approval. Please contact HR / MIS. Thank you.";
          echo "".base_url()."'";
        }else if($userid != '' AND $queryselect[0]['acc_status'] != '0'){
          echo "'Your account has been temporarily deactivated. Please contact support. Thank you.";
          echo "".base_url()."";
        }

      }else{
        if($queryselect[0]['userid'] != '' AND $queryselect[0]['verified'] != '0' AND $queryselect[0]['reset'] != ''){
          echo "'Your account has been reset. Please check your email for your credentials.";
          echo "".base_url()."'";
        }else if($queryselect[0]['userid'] != '' AND $queryselect[0]['verified'] == '0' AND $queryselect[0]['reset'] != ''){
          echo "'Your account has been temporarily deactivated. Please contact support / MIS. Thank you.";
          echo "".base_url()."'";
        }else{
          echo "'Username and Password does not match.";
          echo "".base_url()."";
        }
      }
  }
}
