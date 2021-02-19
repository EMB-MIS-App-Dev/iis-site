<?php

// phpinfo();
/**
 *
 */
class Index extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		date_default_timezone_set("Asia/Manila");
	}

	function index(){
	if(!empty($this->session->userdata('userid'))){
		$this->dashboard();
	}else{
		$this->load->view('includes/login/header');

		$this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
	  $this->form_validation->set_rules('username', '', 'trim|required', array('required' => 'This field is required.'));
		$this->form_validation->set_rules('password', '', 'trim|required', array('required' => 'This field is required.'));
		if ($this->form_validation->run() == FALSE){

			$this->load->view('login');
			// $this->load->view('maintenance');
		}else{
			$datapost = $this->input->post();
			$this->login($datapost);
		}
		$this->load->view('includes/login/footer');
	}
}
function index_2(){
		$this->load->view('login_test');
}
	function auth(){

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$token = $this->input->post('token');
		$userid = $this->input->post('userid');
		$newdata = [	'userid' =>$userid];
		$this->session->userdata($newdata);

	}

	function admin(){
		$this->load->view('includes/login/header');

		$this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
		$this->form_validation->set_rules('username', '', 'trim|required', array('required' => 'This field is required.'));
		$this->form_validation->set_rules('password', '', 'trim|required', array('required' => 'This field is required.'));
		if ($this->form_validation->run() == FALSE){
			$this->load->view('login');
		}else{
			$datapost = $this->input->post();
			$this->login($datapost);
		}
		$this->load->view('includes/login/footer');
	}

	function register(){
	$this->load->view('includes/login/header');
	$this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
  $this->form_validation->set_rules('fname', '', 'trim|required', array('required' => 'This field is required.'));
	$this->form_validation->set_rules('sname', '', 'trim|required', array('required' => 'This field is required.'));
	$this->form_validation->set_rules('email', '', 'trim|required', array('required' => 'This field is required.'));
	$this->form_validation->set_rules('region', '', 'trim|required', array('required' => 'This field is required.'));
	$this->form_validation->set_rules('tregion', '', 'trim|required', array('required' => 'This field is required.'));

	$queryselect['suffix']	  = $this->Embismodel->selectdata('embis.acc_suffix','*','');
	$queryselect['region']	  = $this->Embismodel->selectdata('embis.acc_region','*','');
	$queryselect['offices']	  = $this->Embismodel->selectdata('embis.acc_office','*','');
	$queryselect['division']	= $this->Embismodel->selectdata('embis.acc_xdvsion','*','');

	// $this->load->view('register',$queryselect);
	if ($this->form_validation->run() == FALSE){
	// $this->load->view('myform');
		$this->load->view('register',$queryselect);
	}else{
		$datapost = $this->input->post();
		$this->register_user($datapost);
	}
	$this->load->view('includes/login/footer');

}

	//change user password
	function changepass(){

		if(!empty($this->session->userdata('userid')))
		{
			$cp_where = array('ac.userid' => $this->session->userdata('userid') );
			$cpass = $this->Embismodel->selectdata('embis.acc AS ac', '', $cp_where);

			if($cpass[0]['cpass'] == 0)
			{
				$this->load->view('includes/login/header');
				$this->load->view('includes/login/footer');

				$this->load->view('changepass');
			}
			else {
				redirect(base_url());
			}
		}
		else {
			redirect(base_url());
		}
	}

	function division(){
		$division_id = $this->input->post('value');
		// function selectdata($table = '' ,$select = '', $where = '' ){
		$where = array('sec.divno' => $division_id, );
		$order_by = $this->db->order_by("sec.sect", "ASC");
		$queryselect = $this->Embismodel->selectdata('acc_xsect AS sec','sec.secno,sec.sect,sec.divno',$where);
		echo json_encode($queryselect);
	}

	function register_user($datapost){
		error_reporting(0);
		$dt_registered = date("Y-m-d");
		$ifn		       = strtolower($datapost['fname']);
		$imn		       = strtolower($datapost['mname']);
		$isn		       = strtolower($datapost['sname']);

		$ifname		     = ucwords($ifn);
		$imname		     = ucwords($imn);
		$isname		     = ucwords($isn);
		$suffix        = $datapost['extension'];
		$region		     = $datapost['region'];
		$whereifexists = $this->db->where('acs.verified !=','2');
		$whereifexists = $this->db->where('acs.fname',$ifname);
		$whereifexists = $this->db->where('acs.mname',$imname);
		$whereifexists = $this->db->where('acs.sname',$isname);
		$whereifexists = $this->db->where('acs.suffix',$suffix);
		$whereifexists = $this->db->where('acs.region',$region);
		$checkifexists = $this->Embismodel->selectdata('acc_credentials AS acs','*','',$whereifexists);
		// echo $this->db->last_query(); exit;
		if(!empty($checkifexists[0]['userid'])){
			echo "<script>alert('The credentials you supplied is already registered. Please contact Human Resource Personnel for your details. Thank you!')</script>";
			echo "<script>window.location.href='".base_url()."Index/register'</script>";
		}else{

			$ifname		     =str_replace('ñ', '&ntilde;', $ifname);
			$fname		     =str_replace('Ñ', '&ntilde;', $ifname);

			if(!empty(($datapost['mname']))){
				$imname		     =str_replace('ñ', '&ntilde;', $imname);
				$mname		     =str_replace('Ñ', '&ntilde;', $imname);
			}else{
				$mname				 ="";
			}

			$isname		     =str_replace('ñ', '&ntilde;', $isname);
			$sname		     =str_replace('Ñ', '&ntilde;', $isname);

			$email		     = $datapost['email'];

			$usern         = utf8_encode(strtolower($fname[0].$mname[0].$sname));

			$usernm		     = str_replace('ã±', '&ntilde;', $usern);
			$usernm		     = str_replace('Ñ', '&ntilde;', $usern);
			$username		   = trim(str_replace('ñ', '&ntilde;', $usernm));

			$raw_password  = "12345";
			$en_password   = password_hash($raw_password,PASSWORD_DEFAULT);

			$this->db->select_max('userid');
		    $result = $this->db->get('acc_credentials');
		    if ($result->num_rows() > 0)
		    {
		        $res = $result->result_array();
		        $reslt = $res[0]['userid'];
		        $maxuserid = $reslt + 1; //column 1
		    }

		    $token = $maxuserid.uniqid();

			$userdata = array(
				'userid' 	=> $maxuserid,
				'dt_registered' 	=> $dt_registered,
				'fname' 	=> $fname,
				'mname' 	=> $mname,
				'sname' 	=> $sname,
				'suffix' 	=> $suffix,
				'email' 	=> $email,
				'region' 	=> $region,
				'office' 	=> $datapost['tregion'],
				'verified' 	=> '0',
				'token' 	=> $token,
			);

			$query_credentials = $this->Embismodel->insertdata('acc_credentials',$userdata);


			$useracc = array(
				'userid' 	    => $maxuserid,
				'username' 	    => $username,
				'raw_password' 	=> $raw_password,
				'en_password' 	=> $en_password,
				'acc_status' 	=> '0',
			);

			$query_acc = $this->Embismodel->insertdata('acc',$useracc);

			if ($query_acc){
				if($query_credentials){
					echo "<script>alert('Please contact your HR for account approval.')</script>";
					echo "<script>window.location.href='".base_url()."'</script>";
				}else{
					echo "<script>alert('Error! Please contact the webmaster. Thank you.')</script>";
					echo "<script>window.location.href='".base_url()."Index/register'</script>";
				}
			}else {
				echo "<script>alert('Error! Please contact the webmaster. Thank you.')</script>";
				echo "<script>window.location.href='".base_url()."Index/register'</script>";
			}

		}

	}

	function cpass_user()
	{
		$userid = $this->session->userdata('userid');

		$data = $this->input->post();

		if($data['npass'] == $data['cnpass']) {
			$en_password = password_hash($data['cnpass'], PASSWORD_DEFAULT);

			$update = array(
				'ac.raw_password' => $this->encrypt->encode($data['cnpass']),
				'ac.en_password'  => $en_password,
				'ac.cpass' 				=> 1,
				'ac.reset' 				=> "",
			);
			$where = array('ac.userid' => $userid);
			$this->Embismodel->updatedata($update, 'acc AS ac', $where);
			echo "<script>alert('Successfully changed. Please login to continue.')</script>";
			echo "<script>window.location.href='".base_url()."'</script>";
		}
		else {
			echo "<script>alert('New Password and Confirm Password Does Not Match.')</script>";
			echo "<script>window.location.href='".base_url('index/changepass')."'</script>";
		}
	}

	function login($datapost){
			// $un          = $this->input->post('username');
			// $pw          = $this->input->post('password');
			$encuname = $this->encrypt->encode($datapost['username']);
			$decpass	= $this->encrypt->encode($datapost['password']);
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
				if($querydecode[$i]['username'] == $username AND $querydecode[$i]['raw_password'] == $pw){
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
					'host' 				  => 'localhost',
					'user' 				  => 'root',
					'pass' 				  => '',
					'db'   				  => 'embis',
					 'logged_in'    => TRUE,
					 'username'      => $queryselect[0]['username'],
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

	// ------------------------------------ ROUTE GOING TO DASHBOARD ------------------------------------
						$userid=$this->session->userdata('userid');
						echo "<script>window.location.href='".base_url()."emailtoken/$userid'</script>";
						// echo "<script>window.location.href='".base_url()."dashboard'</script>";
	// ------------------------------------ ROUTE GOING TO DASHBOARD ------------------------------------
					}
				}else if($userid != '' AND $verified != '0' AND $reset == ''){
					echo "<script>alert('Your account still needs approval. Please contact HR / MIS. Thank you.')</script>";
					echo "<script>window.location.href='".base_url()."'</script>";
				}else if($userid != '' AND $queryselect[0]['acc_status'] != '0'){
					echo "<script>alert('Your account temporarily deactivated. Please contact support. Thank you.')</script>";
					echo "<script>window.location.href='".base_url()."'</script>";
				}

			}else{
				if($queryselect[0]['userid'] != '' AND $queryselect[0]['verified'] != '0' AND $queryselect[0]['reset'] != ''){
					echo "<script>alert('Your account has been reset. Please check your email for your credentials.')</script>";
					echo "<script>window.location.href='".base_url()."'</script>";
				}else if($queryselect[0]['userid'] != '' AND $queryselect[0]['verified'] == '0' AND $queryselect[0]['reset'] != ''){
					echo "<script>alert('Your account temporarily deactivated. Please contact support / MIS. Thank you.')</script>";
					echo "<script>window.location.href='".base_url()."'</script>";
				}else{
					echo "<script>alert('Username and Password does not match.')</script>";
					echo "<script>window.location.href='".base_url()."'</script>";
				}
			}
	}


		function dashboard(){
			if ( !$this->session->userdata('logged_in'))
			{
					redirect('Index');
			}

			$this->load->library('session');
			$this->Embismodel->selectdatarights();
			$this->load->view('includes/common/header');
			$this->load->view('includes/common/sidebar');
			$this->load->view('includes/common/nav');
			$this->load->view('includes/common/footer');



			$date = date("Y-m-d");
			$whereonlineusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.verified = "1" AND acs.userid != "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY af.func ASC,acs.fname ASC');
			$joinonlineusers  = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
			$data['selectonlineusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func','',$joinonlineusers,$whereonlineusers);

			$whereonlineusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.verified = "1" AND acs.userid != "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY acs.timestamp DESC, acs.fname ASC');
			$joinonlineusers  = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
			$data['selectofflineusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func','',$joinonlineusers,$whereonlineusers);

			$wherebulletinnotif = $this->db->where('acs.userid = "'.$this->session->userdata('userid').'"');
			$data['bulletinnotif'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.bulletin_count_national, acs.bulletin_count_regional','',$wherebulletinnotif);


			$wheresupp = array('staff' => $this->session->userdata('userid'),'status' => 2);
			$data['supportdata'] = $this->Embismodel->selectdata('sp_ticket_assisstance AS sta','sta.*',$wheresupp);

			$this->load->view('dashboard',$data);
		}

		function bltnppot(){
			$where = $this->db->where('bp.region = "'.$this->session->userdata('region').'" AND bn.status = "published"');
			$joindata = $this->db->join('bulletin AS bn','bn.cnt = bp.bulletin_cnt');
			$chkdashboardpopout = $this->Embismodel->selectdata('bulletin_popout AS bp','','',$joindata,$where);

			$count = 0;
			$token = $this->encrypt->encode($chkdashboardpopout[0]['bulletin_cnt']);
			if(!empty($chkdashboardpopout[0]['cnt'])){
				if(!empty($chkdashboardpopout[0]['dontshow'])){
					$explodedata = explode('|',$chkdashboardpopout[0]['dontshow']);
					for ($i=0; $i < count($explodedata); $i++) {
						if($explodedata[$i] == $this->session->userdata('userid')){
							$count++;
							$token = "";
						}
					}
				}
			}
			if(!empty($chkdashboardpopout[0]['cnt'])){
				if($count > 0){
					echo json_encode(array('status' => 'hide', 'token' => $token, 'origin' => '', ));
				}else{
					echo json_encode(array('status' => 'show', 'token' => $token, 'origin' => $this->encrypt->encode('popout'),));
				}
			}else{
				echo json_encode(array('status' => 'hide', 'token' => $token, 'origin' => '', ));
			}
		}

		function dntshwbltn(){
			$wheredata = $this->db->where('bp.region = "'.$this->session->userdata('region').'"');
			$selectdata = $this->Embismodel->selectdata('bulletin_popout AS bp','','',$wheredata);
			$dntshow = "";
			if(!empty($selectdata[0]['region'])){
				$dntshow = $selectdata[0]['dontshow'].$this->session->userdata('userid').'|';
			}

			$setdata = array('dontshow' => $dntshow, );
			$whereupdate = array('region' => $this->session->userdata('region'), );
			$updatedata = $this->Embismodel->updatedata($setdata, 'bulletin_popout', $whereupdate);

			$setdata = array('bulletin_count_regional' => '', );
			$wheredata = array('userid' => $this->session->userdata('userid'), );
			$updatedata = $this->Embismodel->updatedata($setdata, 'acc_credentials', $wheredata);

			if($updatedata){
				echo json_encode(array('status' => 'dismiss', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}

		function dashboard_sample(){
			if ( !$this->session->userdata('logged_in'))
			{
					redirect('Index');
			}

			$this->load->library('session');
			$this->Embismodel->selectdatarights();
			$this->load->view('includes/common/header');
			$this->load->view('includes/common/sidebar');
			$this->load->view('includes/common/nav');
			$this->load->view('includes/common/footer');



			$date = date("Y-m-d");
			$whereonlineusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.verified = "1" AND acs.userid != "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY af.func ASC,acs.fname ASC');
			$joinonlineusers  = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
			$data['selectonlineusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func','',$joinonlineusers,$whereonlineusers);

			$whereonlineusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.verified = "1" AND acs.userid != "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY acs.timestamp DESC, acs.fname ASC');
			$joinonlineusers  = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
			$data['selectofflineusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func','',$joinonlineusers,$whereonlineusers);

			$wherebulletinnotif = $this->db->where('acs.userid = "'.$this->session->userdata('userid').'"');
			$data['bulletinnotif'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.bulletin_count_national, acs.bulletin_count_regional','',$wherebulletinnotif);


			$wheresupp = array('sta.staff' => $this->session->userdata('userid'), 'sta.status' => 2 );
		  $querysupp = $this->Embismodel->selectdata('sp_ticket_assisstance AS sta','sta.*',$wheresupp);
			(count($querysupp) > 0) ? $data['support'] = $querysupp : $data['support'] = [];
			$this->load->view('dashboard',$data);
		}

	function viewallonlineusers(){
			$whereonlineusers = $this->db->where('acs.verified = "1" AND acs.userid != "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY acs.region ASC,af.func ASC,acs.fname ASC');
			$joinonlineusers  = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
			$selectallonlineusers = $this->Embismodel->selectdata('acc_credentials AS acs','COUNT(acs.userid) AS cntou,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func,acs.region','',$joinonlineusers,$whereonlineusers);
			?>
				<div class="row">
				<?php $cntr = 0;
					for ($i=0; $i < sizeof($selectallonlineusers); $i++) {
						$mname = (!empty($selectallonlineusers[$i]['mname'])) ? $selectallonlineusers[$i]['mname'][0].'. ': '';
						$title = (!empty($selectallonlineusers[$i]['title'])) ? $selectallonlineusers[$i]['title'].' ': '';
						$suffix = (!empty($selectallonlineusers[$i]['suffix'])) ? ' '.$selectallonlineusers[$i]['suffix']: '';
						$name = $title.$selectallonlineusers[$i]['fname'].' '.$mname.$selectallonlineusers[$i]['sname'].$suffix;
						$datetime = date("Y-m-d H:i");
						$date = date("Y-m-d");
						$currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
						if ((date('H:i', strtotime($currenttimeminus5minutes)) < date('H:i', strtotime($selectallonlineusers[$i]['timestamp']))) AND (date('Y-m-d', strtotime($selectallonlineusers[$i]['timestamp'])) == $date)) { $cntr++;
				?>
						<div class="col-md-2">
							<label style="color:#858FB1;"><?php echo $cntr; ?></label>
						</div>
						<div class="col-md-8">
							<span class="fa fa-circle" style="font-size:10pt;color:#4BCB20;margin-right:20px;margin-left:10px;"></span><label style="color:#858FB1;"><?php echo $name; ?></label>
						</div>
						<div class="col-md-2">
							<label style="color:#858FB1;"><?php echo $selectallonlineusers[$i]['region']; ?></label>
						</div>
				<?php } } ?>
				</div>
			<?php
	}

	function viewallonlineusers_smr(){
		// $whereonlineusers = $this->db->where('acs.verified = "1" AND acs.userid != "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY acs.region ASC,af.func ASC,acs.fname ASC');
		// $joinonlineusers  = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
		// $selectallonlineusers = $this->Embismodel->selectdata('acc_credentials AS acs','COUNT(acs.userid) AS cntou,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func,acs.region','',$joinonlineusers,$whereonlineusers);
			// $date = date("Y-m-d");
			// echo $datetime;exit;
			$crsdb = $this->load->database('crs',TRUE);
			$selectallonlineusers = $crsdb->select('acc.username,acc.timestamp')->from('acc')->where('verified',1)->where('timestamp is NOT NULL', NULL, FALSE)->get()->result_array();

		?>
			<div class="row">
			<?php $cntr = 0;
				for ($i=0; $i < sizeof($selectallonlineusers); $i++) {
					// echo "<pre>";print_r($selectallonlineusers[$i]['username']);exit;
					$username = $selectallonlineusers[$i]['username'];
					$datetime = date("Y-m-d H:i");
					$date = date("Y-m-d");
					$currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
					if ((date('H:i', strtotime($currenttimeminus5minutes)) < date('H:i', strtotime($selectallonlineusers[$i]['timestamp']))) AND (date('Y-m-d', strtotime($selectallonlineusers[$i]['timestamp'])) == $date)) { $cntr++;
			?>
					<div class="col-md-2">
						<label style="color:#858FB1;"><?php echo $cntr; ?></label>
					</div>
					<div class="col-md-8">
						<span class="fa fa-circle" style="font-size:10pt;color:#4BCB20;margin-right:20px;margin-left:10px;"></span><label style="color:#858FB1;"><?php echo $username; ?></label>
					</div>
					<div class="col-md-2">
						<!-- <label style="color:#858FB1;"><?php echo $selectallonlineusers[$i]['region']; ?></label> -->
					</div>
			<?php } } ?>
			</div>
		<?php
	}

	function logout_user(){
		$this->session->sess_destroy();
		echo "<script>window.location.href='".base_url()."'</script>";
	}

	function error_404()
	{
		$this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
		$this->load->view('includes/common/footer');
		$this->load->view('404');
	}

	function bulletinupload(){
			$token = $this->encrypt->decode($this->input->post('token', TRUE));

			if((count($_FILES['bulletinfiles']['name'])) >= '1'){

				// $wheredraft = $this->db->where('bn.status = "draft" AND bn.userid = "'.$this->session->userdata('userid').'" AND bn.cnt = (SELECT MAX(btn.cnt) FROM bulletin AS btn WHERE btn.userid = "'.$this->session->userdata('userid').'")');
				// $selectdraft = $this->Embismodel->selectdata('bulletin AS bn','bn.cnt','',$wheredraft);
				//
				// if(empty($selectdraft[0]['cnt'])){
				// 	$data = array('region' => $this->session->userdata('region'), 'userid' => $this->session->userdata('userid'), 'status' => 'draft', );
				// 	$insertdraft = $this->Embismodel->insertdata('bulletin',$data);
				//
				// 	if($insertdraft){
				// 		$wheredraft = $this->db->where('bn.status = "draft" AND bn.userid = "'.$this->session->userdata('userid').'" AND bn.cnt = (SELECT MAX(btn.cnt) FROM bulletin AS btn WHERE btn.userid = "'.$this->session->userdata('userid').'")');
				// 		$selectdraft = $this->Embismodel->selectdata('bulletin AS bn','bn.cnt','',$wheredraft);
				// 	}
				// }

				if(!is_dir('uploads/bulletin')) {
					mkdir('uploads/bulletin', 0777, TRUE);
				}

				if(!is_dir('uploads/bulletin'.$this->session->userdata('region'))) {
					mkdir('uploads/bulletin/'.$this->session->userdata('region'), 0777, TRUE);
				}

				if(!is_dir('uploads/bulletin'.$this->session->userdata('region').'/'.$token)) {
					mkdir('uploads/bulletin/'.$this->session->userdata('region').'/'.$token, 0777, TRUE);
				}

			$error = array();

			$config = array(
					 'upload_path'   => 'uploads/bulletin/'.$this->session->userdata('region').'/'.$token.'/',
					 'allowed_types' => '*',
					 'max_size'			 => '100000',
					 'overwrite'     => TRUE,
			 );

			$this->load->library('upload',$config);

			$counter = 0;

			for ($i=0; $i < count($_FILES['bulletinfiles']['name']); $i++) {
				$_FILES['file']['name']      = $_FILES['bulletinfiles']['name'][$i];
				$_FILES['file']['type']      = $_FILES['bulletinfiles']['type'][$i];
				$_FILES['file']['tmp_name']  = $_FILES['bulletinfiles']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['bulletinfiles']['error'][$i];
				$_FILES['file']['size']      = $_FILES['bulletinfiles']['size'][$i];

				$filename = date('ymdhs').$i.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $filename;

				$this->upload->initialize($config);

				if($this->upload->do_upload('file')){

						$whereattachments = $this->db->where('bn.cnt = "'.$token.'"');
						$selectattachments = $this->Embismodel->selectdata('bulletin AS bn','bn.attachments','',$whereattachments);

					  $setdata = array('attachments' => $config['file_name']."|".$selectattachments[0]['attachments'], );
						$wheredata = array('cnt' => $token, );
						$updatebulletindraft = $this->Embismodel->updatedata($setdata, 'bulletin', $wheredata);
						$counter++;
						if($counter == '1'){
							echo json_encode(array('status' => 'success', 'token' => $token, 'attachmentcounter' => $this->encrypt->encode($counter),));
						}

				}else{
					echo json_encode(array('status' => 'failed',));
				}
			}
		}else{
			echo json_encode(array('status' => 'empty',));
		}

		clearstatcache();
	}

	function viewuploadedfilesbulletin(){
		$token = $_POST['token'];
		$wheredata = $this->db->where('bn.cnt = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('bulletin AS bn','bn.attachments,bn.region','',$wheredata);

		$explodedata = explode('|',$selectdata[0]['attachments']);
			if(!empty($selectdata[0]['attachments'])){
				echo "<hr>";
				echo "<label>Uploaded File(s):</label>";
				for ($i=0; $i < sizeof($explodedata); $i++) {
					if(!empty($explodedata[$i])){
					?>
						<div style="display:flex;margin-bottom: 5px;">
							<input type="text" class="form-control" value="<?php echo $explodedata[$i]; ?>" disabled>
							<a href="<?php echo base_url().'uploads/bulletin/'.$selectdata[0]['region'].'/'.$token.'/'.$explodedata[$i]; ?>" target="_blank" type="button" class="btn btn-info btn-sm" style="margin-left: 5px;width: 10%;"><span class="fa fa-eye"></span></a>
							<a href="#" type="button" class="btn btn-danger btn-sm" onclick="removeuploadedfilebulletin('<?php echo $this->encrypt->encode($token); ?>','<?php echo $this->encrypt->encode($explodedata[$i]); ?>');" style="margin-left: 5px;width: 10%;"><span class="fa fa-trash"></span></a>
						</div>
					<?php
					}
				}
			}
	}

	function removeuploadedfilebulletin(){
		$token = $this->encrypt->decode($_POST['token']);
		$wheredata = $this->db->where('bn.cnt = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('bulletin AS bn','bn.attachments,bn.region','',$wheredata);
		$explodedata = explode('|',$selectdata[0]['attachments']);

		// print_r($explodedata);  echo $this->encrypt->decode($_POST['file']); exit;
		$attachments = "";
		$cntr = 0;
		for ($i=0; $i < sizeof($explodedata); $i++) {
			if(!empty($explodedata[$i])){
				$cntr++;
				if($explodedata[$i] != $this->encrypt->decode($_POST['file'])){
					$attachments .= $explodedata[$i].'|';
				}
			}
		}

		$setdata = array('attachments' => $attachments, );
		$wheredata = array('cnt' => $token, );
		$updatedata = $this->Embismodel->updatedata($setdata,'bulletin',$wheredata);
		if($updatedata){
			unlink('uploads/bulletin/'.$selectdata[0]['region'].'/'.$token.'/'.$this->encrypt->decode($_POST['file']));
		}

		echo json_encode(array('token' => $token, 'etoken' => $_POST['token'],  'attachmentcntr' => $this->encrypt->encode($cntr), ));
	}

	function createnewinbulletin(){
		$wheredraft = $this->db->where('bn.status = "draft" AND bn.userid = "'.$this->session->userdata('userid').'" AND bn.cnt = (SELECT MAX(btn.cnt) FROM bulletin AS btn WHERE btn.userid = "'.$this->session->userdata('userid').'")');
		$selectdraft = $this->Embismodel->selectdata('bulletin AS bn','bn.cnt','',$wheredraft);

		if(empty($selectdraft[0]['cnt'])){
			$data = array('region' => $this->session->userdata('region'), 'userid' => $this->session->userdata('userid'), 'status' => 'draft', );
			$insertdraft = $this->Embismodel->insertdata('bulletin',$data);

			if($insertdraft){
				$wheredraft = $this->db->where('bn.status = "draft" AND bn.userid = "'.$this->session->userdata('userid').'" AND bn.cnt = (SELECT MAX(btn.cnt) FROM bulletin AS btn WHERE btn.userid = "'.$this->session->userdata('userid').'")');
				$selectdraft = $this->Embismodel->selectdata('bulletin AS bn','bn.cnt','',$wheredraft);
				if(!empty($selectdraft[0]['cnt'])){
					echo '<input type="hidden" id="bulletincnt" class="form-control" value="'.$this->encrypt->encode($selectdraft[0]['cnt']).'">';
				}else{
					echo '<input type="hidden" id="bulletincnt" class="form-control" value="'.$this->encrypt->encode('').'">';
				}
			}
		}else{
			echo '<input type="hidden" id="bulletincnt" class="form-control" value="'.$this->encrypt->encode($selectdraft[0]['cnt']).'">';
		}
	}

	function publishtobulletin(){

		$bulletincnt = $this->encrypt->decode($this->input->post('bltncnt'));
		$bulletinttl = $this->input->post('bltnttle');
		$bltnwhere = $this->input->post('bltnwhere');
		$bltnwhen = $this->input->post('bltnwhen');
		$attachmentcntr = $this->encrypt->decode($this->input->post('attchmntcntr'));
		$visibletonational = ($this->input->post('visibletonational') == 'false') ? 'Regional' : 'National';

		if(!empty($bulletincnt) AND !empty($bulletinttl) AND $attachmentcntr > 0){
			$setdata = array('title' => $bulletinttl, 'bulletin_where' => $bltnwhere, 'bulletin_when' => $bltnwhen, 'datetime_posted' => date('Y-m-d h:ia'), 'region' => $this->session->userdata('region'), 'status' => 'published', 'visibility' => $visibletonational,);
			$wheredata = array('cnt' => $bulletincnt, );
			$insertdata = $this->Embismodel->updatedata($setdata, 'bulletin', $wheredata);

			if($visibletonational == 'Regional'){
				$whereemployees = $this->db->where('acs.verified = "1" AND acs.region = "'.$this->session->userdata('region').'"');
				$selectregionalemployees = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.bulletin_count_regional','',$whereemployees);
				for ($i=0; $i < sizeof($selectregionalemployees); $i++) {
					$notifcountr = $selectregionalemployees[$i]['bulletin_count_regional'] + 1;
					$setdataregional = array('bulletin_count_regional' => $notifcountr, );
					$wheredataregional = array('userid' => $selectregionalemployees[$i]['userid'], 'region' => $this->session->userdata('region'), );
					$updateregionaemployees = $this->Embismodel->updatedata($setdataregional, 'acc_credentials', $wheredataregional);
				}
			}

			if($visibletonational == 'National'){
				$whereemployees = $this->db->where('acs.verified = "1"');
				$selectnationalemployees = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.bulletin_count_national','',$whereemployees);
				for ($i=0; $i < sizeof($selectnationalemployees); $i++) {
					$notifcountn = $selectnationalemployees[$i]['bulletin_count_national'] + 1;
					$setdatanational = array('bulletin_count_national' => $notifcountn, );
					$wheredatanational = array('userid' => $selectnationalemployees[$i]['userid'], );
					$updatenationalemployees = $this->Embismodel->updatedata($setdatanational, 'acc_credentials', $wheredatanational);
				}
			}

			$wherebtnppout = $this->db->where('bp.region = "'.$this->session->userdata('region').'"');
			$selectbltnppot = $this->Embismodel->selectdata('bulletin_popout AS bp','','',$wherebtnppout);

			if(!empty($selectbltnppot[0]['cnt'])){
				$setdatappot = array(
															'region' => $this->session->userdata('region'),
															'bulletin_cnt' => $bulletincnt,
															'dontshow' => '',
														);
				$wheredatappot = array('region' => $this->session->userdata('region'),);
				$updatedatabltnppot = $this->Embismodel->updatedata($setdatappot, 'bulletin_popout', $wheredatappot);
			}else{
				$datainsertppot = array(
															'region' => $this->session->userdata('region'),
															'bulletin_cnt' => $bulletincnt,
															'dontshow' => '',
														);
				$insertdata = $this->Embismodel->insertdata('bulletin_popout',$datainsertppot);
			}

			echo json_encode(array('status' => 'success', ));
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function checkdraft(){
		$wheredraft = $this->db->where('bn.status = "draft" AND bn.userid = "'.$this->session->userdata('userid').'" AND bn.cnt = (SELECT MAX(btn.cnt) FROM bulletin AS btn WHERE btn.userid = "'.$this->session->userdata('userid').'")');
		$selectdraft = $this->Embismodel->selectdata('bulletin AS bn','bn.title,bn.cnt,bn.attachments','',$wheredraft);
		if(!empty($selectdraft[0]['cnt'])){
			$explodedata = explode('|',$selectdraft[0]['attachments']);
			$countarray = count(array_filter($explodedata));
			echo json_encode(array('token' => $selectdraft[0]['cnt'], 'title' => $selectdraft[0]['title'], 'attachmentcnt' => $this->encrypt->encode($countarray),));
		}
	}

	function bulletin_details(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$wheredata = $this->db->where('bn.cnt = "'.$token.'"');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = bn.userid','left');
		$selectdata = $this->Embismodel->selectdata('bulletin AS bn','bn.datetime_posted, bn.bulletin_where, bn.bulletin_when, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, bn.attachments, bn.region, bn.title AS bntitle, bn.userid','',$joindata,$wheredata);
		$title = (!empty($selectdata[0]['title'])) ? $selectdata[0]['title']." " : "";
		$mname = (!empty($selectdata[0]['mname'])) ? $selectdata[0]['mname'][0].". " : "";
		$suffix = (!empty($selectdata[0]['suffix'])) ? " ".$selectdata[0]['suffix'] : "";
		$name = $title.$selectdata[0]['fname']." ".$mname.$selectdata[0]['sname'].$suffix;

		$explodedata = explode('|',$selectdata[0]['attachments']);

		?>
			<div class="row">
				<div class="col-md-6">
					<label>Posted by:</label>
					<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
				</div>
				<div class="col-md-6">
					<label>Date/Time posted:</label>
					<input type="text" class="form-control" value="<?php echo date('F d, Y - h:ia', strtotime($selectdata[0]['datetime_posted'])); ?>" readonly>
				</div>
				<div class="col-md-12"><hr>
					<label>What: (Subject)</label>
					<textarea class="form-control" rows="5" disabled><?php echo $selectdata[0]['bntitle']; ?></textarea>
				</div>
				<div class="col-md-8">
					<label>Where: (Venue)</label>
					<input type="text" class="form-control" value="<?php echo (!empty($selectdata[0]['bulletin_where'])) ? $selectdata[0]['bulletin_where'] : "---" ; ?>" readonly>
				</div>
				<div class="col-md-4">
					<label>When: (Date/Time Applicable)</label>
					<input type="text" class="form-control" value="<?php echo (!empty($selectdata[0]['bulletin_when'])) ? date('F d, Y - h:ia', strtotime($selectdata[0]['bulletin_when'])) : "---" ; ?>" readonly>
				</div>
				<div class="col-md-12">
					<?php if(!empty($selectdata[0]['attachments'])){
						echo "<hr>";
						echo "<label>Uploaded file(s):</label>";
						for ($i=0; $i < sizeof($explodedata); $i++) {
							if(!empty($explodedata[$i])){
							?>
								<?php if($this->session->userdata('superadmin_rights') == 'yes' OR $selectdata[0]['userid'] == $this->session->userdata('userid')){ ?>
									<div style="display:flex;margin-bottom: 5px;">
										<input type="text" class="form-control" value="<?php echo $explodedata[$i]; ?>" disabled>
										<a href="<?php echo base_url().'uploads/bulletin/'.$selectdata[0]['region'].'/'.$token.'/'.$explodedata[$i]; ?>" target="_blank" type="button" class="btn btn-info btn-sm" style="margin-left: 5px;width: 10%;"><span class="fa fa-eye"></span></a>
										<a href="#" type="button" class="btn btn-danger btn-sm" onclick="removeuploadedfilebulletin('<?php echo $this->encrypt->encode($token); ?>','<?php echo $this->encrypt->encode($explodedata[$i]); ?>');" style="margin-left: 5px;width: 10%;"><span class="fa fa-trash"></span></a>
									</div>
								<?php }else{ ?>
									<div style="display:flex;margin-bottom: 5px;">
										<input type="text" class="form-control" value="<?php echo $explodedata[$i]; ?>" disabled>
										<a href="<?php echo base_url().'uploads/bulletin/'.$selectdata[0]['region'].'/'.$token.'/'.$explodedata[$i]; ?>" target="_blank" type="button" class="btn btn-info btn-sm" style="margin-left: 5px;width: 10%;"><span class="fa fa-eye"></span></a>
									</div>
								<?php } ?>
							<?php
							}
						}
					} ?>
				</div>
			</div>
		<?php
	}

	function bulletinoptions(){
		$cnt = $this->input->post('cnt');
		$wheredata = $this->db->where('bltn.cnt = "'.$this->encrypt->decode($cnt).'"');
		$selectdata = $this->Embismodel->selectdata('bulletin AS bltn','bltn.userid','',$wheredata);

		$origin = $this->encrypt->decode($this->input->post('origin'));
		// echo "<pre>";
		// print_r($_POST);
		 ?>
			<div class="col-md-12">
				<?php if(!empty($origin)){ ?>
					<button type="button" class="btn btn-primary btn-sm" onclick="dntshwbltn();">Do not show this again</button>
				<?php } ?>
				<?php if($this->session->userdata('superadmin_rights') == 'yes' OR $this->session->userdata('userid') == $selectdata[0]['userid']){ ?>
				<button type="button" class="btn btn-danger btn-sm" onclick="removetobulletin('<?php echo $cnt; ?>');">Remove to Bulletin</button>
				<?php } ?>
			</div>
		<?php
	}

	function removetobulletin(){
		$cnt = $this->encrypt->decode($this->input->post('cnt'));
		if(!empty($cnt)){
			$setdata = array('status' => 'removed', );
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'bulletin', $wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success',));
			}else{
				echo json_encode(array('status' => 'failed',));
			}
		}else{
			echo json_encode(array('status' => 'failed',));
		}
	}

	function localbltnsn(){
		$setdata = array('bulletin_count_regional' => '', );
		$wheredata = array('userid' => $this->session->userdata('userid'), );
		$updatedata = $this->Embismodel->updatedata($setdata, 'acc_credentials', $wheredata);
	}
	function ntlbltnsn(){
		$setdata = array('bulletin_count_national' => '', );
		$wheredata = array('userid' => $this->session->userdata('userid'), );
		$updatedata = $this->Embismodel->updatedata($setdata, 'acc_credentials', $wheredata);
	}
}
