<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class View extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
    date_default_timezone_set("Asia/Manila");
	}

  function index($msgtoken = ''){
		if ( !$this->session->userdata('logged_in'))
		{
				redirect('Index');
		}
		$setdata = array('display_name' => $this->session->userdata('display_name'), 'creator_fullname' => $this->session->userdata('name'), );
		$wheredata = array('creator_userid' => $this->session->userdata('userid'), );
		$this->Embismodel->updatedata($setdata,'messenger_groups',$wheredata);

		$setdata = array('by_displayname' => $this->session->userdata('display_name'), 'by' => $this->session->userdata('name'), );
		$wheredata = array('by_userid' => $this->session->userdata('userid'), );
		$this->Embismodel->updatedata($setdata,'messenger_content',$wheredata);

		$region = $this->session->userdata('region');
    $whereusers = $this->db->where('acs.verified = "1" AND acs.userid != "'.$this->session->userdata('userid').'" AND acs.region = "'.$region.'" ORDER BY acs.timestamp DESC,acs.fname ASC');
    $data['queryusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','DISTINCT(acs.userid),acs.user_photo,acs.token,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp','',$whereusers);

    $wheremembers = $this->db->where('acs.verified = "1" AND af.stat = "1" AND mg.token = "'.$this->encrypt->decode($msgtoken).'" GROUP BY acs.userid ORDER BY acs.timestamp DESC, acs.fname DESC');
		$joinmembers = $this->db->join('acc_credentials AS acs','acs.userid = mg.creator_userid','left');
		$joinmembers = $this->db->join('acc_function AS af','af.userid = mg.creator_userid','left');
    $datacontent['members'] = $this->Embismodel->selectdata('messenger_groups AS mg','acs.user_photo,acs.token,acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,af.func','',$joinmembers,$wheremembers);

    $whrmymessages = $this->db->where('mg.creator_userid ="'.$this->session->userdata('userid').'" AND mg.status = "Active" ORDER BY latest_datesent DESC, latest_timesent DESC');
    $data['mymessages'] = $this->Embismodel->selectdata('messenger_groups AS mg','mg.unseen_msgs_count,mg.token,mg.category,mg.chat_name,mg.recipient_userid,mg.recipient_fullname,mg.latest_datetime,mg.latest_sender,mg.latest_message,mg.date_created','',$whrmymessages);

		$wherecntmsgcnt = array('mc.msg_token' => $this->encrypt->decode($msgtoken), );
		$cntmsgcnt = $this->Embismodel->selectdata('messenger_content AS mc','MAX(msg_order) AS msgcntntcnt',$wherecntmsgcnt);
		$datacontent['baserow'] = ($cntmsgcnt[0]['msgcntntcnt'] < 10) ? 0 : $cntmsgcnt[0]['msgcntntcnt']-10 ;
		$datacontent['countrows'] = $cntmsgcnt[0]['msgcntntcnt'];
		$token['countrows'] = $datacontent['baserow'];

		if($cntmsgcnt[0]['msgcntntcnt'] > 0){
			$whrmsgcntnt = $this->db->where('mc.msg_token ="'.$this->encrypt->decode($msgtoken).'" AND mc.msg_order BETWEEN "'.$datacontent['baserow'].'" AND "'.$datacontent['countrows'].'" ORDER BY mc.msg_order ASC');
		}else{
			$whrmsgcntnt = $this->db->where('mc.msg_token ="'.$this->encrypt->decode($msgtoken).'" ORDER BY mc.msg_order ASC');
		}
    $datacontent['messagecontent'] = $this->Embismodel->selectdata('messenger_content AS mc','','',$whrmsgcntnt);

		$whrlastseen = $this->db->where('mg.token ="'.$this->encrypt->decode($msgtoken).'"');
		$jnlastseen = $this->db->join('acc_credentials AS acs','acs.userid = mg.creator_userid','left');
    $datacontent['lastseen'] = $this->Embismodel->selectdata('messenger_groups AS mg','mg.lastseen_msg_cnt, mg.creator_fullname, acs.token, acs.user_photo, mg.creator_userid','',$jnlastseen,$whrlastseen);
		$datacontent['cnttoken'] = count($datacontent['lastseen']);

		$whrcontent = $this->db->where('mg.token ="'.$this->encrypt->decode($msgtoken).'" AND mg.creator_userid = "'.$this->session->userdata('userid').'"');
		$jncontent = $this->db->join('acc_credentials AS acs','acs.userid = mg.recipient_userid','left');
		$datacontent['contentheader'] = $this->Embismodel->selectdata('messenger_groups AS mg','mg.token, mg.chat_name, mg.chat_photo, mg.ifremoved, mg.lastseen_msg_cnt, mg.region_participants, mg.creator_userid, mg.category, mg.creator_fullname, acs.designation, acs.region, acs.timestamp','',$jncontent,$whrcontent);

		$token['ifremoved'] = $datacontent['contentheader'][0]['ifremoved'];
		$token['msgtoken'] = $msgtoken;
		$datacontent['msgtoken'] = $msgtoken;

    $this->load->view('includes/messages/includes/header');
    $this->load->view('includes/messages/includes/sidebar',$data);
		$this->load->view('includes/messages/includes/chatbody',$datacontent);
    $this->load->view('includes/messages/includes/footer',$token);
		$this->load->view('includes/messages/includes/modals');
  }

	function chkifcnvexst($data = ''){
		$datadecoded = explode('||', $this->encrypt->decode($data)); //[0] is recipient_userid, [1] is category "Group/Single"
		if(str_replace(';','',$datadecoded[0]) == $this->session->userdata('userid')){
				redirect(base_url()."Messages"); exit;
		}

		if($datadecoded[1] == 'Single'){
			$wchifexist = array('mg.creator_userid' => $this->session->userdata('userid'), 'category' => $datadecoded[1]);
			$chifexist = $this->Embismodel->selectdata('messenger_groups AS mg','',$wchifexist);

			$iftokenexist = "";
				for ($i=0; $i < sizeof($chifexist); $i++) {
					$recipient_userid = explode(';',$chifexist[$i]['recipient_userid']);
					for ($ru=0; $ru < sizeof($recipient_userid); $ru++) {
						if($recipient_userid[$ru] == str_replace(';','',$datadecoded[0])){
							$iftokenexist = $chifexist[$i]['token'];
							redirect(base_url()."Messages/View/index/".$this->encrypt->encode($chifexist[$i]['token']));
						}
					}
				}
			if(empty($iftokenexist)){
				$selectmaxgroupid = $this->db->query("SELECT MAX(group_id) AS mgid FROM messenger_groups")->result_array();
		    $mgid = $selectmaxgroupid[0]['mgid']+1;
		    $token = uniqid().$mgid;

				if(!empty($token)){
					$users = array($this->session->userdata('userid'),str_replace(';','',$datadecoded[0]));

					for ($usrs=0; $usrs < count($users); $usrs++) {
						if(!empty($users[$usrs])){
							if($users[$usrs] == $this->session->userdata('userid')){

								$creator_userid = $this->session->userdata('userid');
								$creator_fullname = $this->session->userdata('name');

								$recipient_userid = str_replace(';','',$datadecoded[0]);

								$wgetdetailsofrecipient = array('acs.userid' => $recipient_userid, );
								$getdetailsofrecipient = $this->Embismodel->selectdata('acc_credentials AS acs','acs.user_photo,acs.token,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix',$wgetdetailsofrecipient);
								$rmname = !empty($getdetailsofrecipient[0]['mname']) ? $getdetailsofrecipient[0]['mname'][0].". " : "";
								$rprefix = !empty($getdetailsofrecipient[0]['title']) ? $getdetailsofrecipient[0]['title']." " : "";
								$rsuffix = !empty($getdetailsofrecipient[0]['suffix']) ? " ".$getdetailsofrecipient[0]['suffix'] : "";
								$rfullaname = $rprefix.ucwords($getdetailsofrecipient[0]['fname']." ".$rmname.$getdetailsofrecipient[0]['sname']).$rsuffix;
								$ruserphoto = (!empty($getdetailsofrecipient[0]['user_photo'])) ? base_url().'uploads/profilepictures/'.$getdetailsofrecipient[0]['token'].'/'.$getdetailsofrecipient[0]['user_photo'] : base_url().'assets/images/default-user.png' ;

								$recipient_fullname = $rfullaname;
							}else{
								$creator_userid = $users[$usrs];

								$wgetdetailsofcreator = array('acs.userid' => $creator_userid, );
								$getdetailsofcreator = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix',$wgetdetailsofcreator);
								$cmname = !empty($getdetailsofcreator[0]['mname']) ? $getdetailsofcreator[0]['mname'][0].". " : "";
								$cprefix = !empty($getdetailsofcreator[0]['title']) ? $getdetailsofcreator[0]['title']." " : "";
								$csuffix = !empty($getdetailsofcreator[0]['suffix']) ? " ".$getdetailsofcreator[0]['suffix'] : "";
								$cfullaname = $cprefix.ucwords($getdetailsofcreator[0]['fname']." ".$cmname.$getdetailsofcreator[0]['sname']).$csuffix;

								$creator_fullname = $cfullaname;

								$recipient_userid = $this->session->userdata('userid');

								$wgetdetailsofrecipient = array('acs.userid' => $recipient_userid, );
								$getdetailsofrecipient = $this->Embismodel->selectdata('acc_credentials AS acs','acs.user_photo,acs.token,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix',$wgetdetailsofrecipient);
								$rmname = !empty($getdetailsofrecipient[0]['mname']) ? $getdetailsofrecipient[0]['mname'][0].". " : "";
								$rprefix = !empty($getdetailsofrecipient[0]['title']) ? $getdetailsofrecipient[0]['title']." " : "";
								$rsuffix = !empty($getdetailsofrecipient[0]['suffix']) ? " ".$getdetailsofrecipient[0]['suffix'] : "";
								$rfullaname = $rprefix.ucwords($getdetailsofrecipient[0]['fname']." ".$rmname.$getdetailsofrecipient[0]['sname']).$rsuffix;
								$ruserphoto = (!empty($getdetailsofrecipient[0]['user_photo'])) ? base_url().'uploads/profilepictures/'.$getdetailsofrecipient[0]['token'].'/'.$getdetailsofrecipient[0]['user_photo'] : base_url().'assets/images/default-user.png' ;

								$recipient_fullname = $rfullaname;
							}

							$data = array(
							              'token'               => $token,
							              'group_id'            => $mgid,
							              'category'            => $datadecoded[1],
							              'chat_name'           => trim($recipient_fullname),
														'chat_photo'          => trim($ruserphoto),
							              'creator_userid'      => $creator_userid,
							              'creator_fullname'    => trim($creator_fullname),
														'recipient_userid'	  => $recipient_userid.";",
														'recipient_fullname'  => trim($recipient_fullname).";",
							              'latest_datetime'     => '',
														'latest_sender'			  => '',
														'latest_message'		  => '',
							              'date_created'        => date("Y-m-d"),
							              'status'              => 'Inactive',
							             );
							$this->Embismodel->insertdata('messenger_groups',$data);
						}
					}

					redirect(base_url()."Messages/View/index/".$this->encrypt->encode($token));

				}
			}
		}


	}

	function creategroup(){
		$selectmaxgroupid = $this->db->query("SELECT MAX(group_id) AS mgid FROM messenger_groups")->result_array();
		$mgid = $selectmaxgroupid[0]['mgid']+1;
		$token = uniqid().$mgid;

		if (!empty($_FILES['files']['name'][0])) {
			if (!is_dir('uploads/messaging'.'/'.$token)) {
				mkdir('uploads/messaging'.'/'.$token, 0777, TRUE);
			}

			if (!is_dir('uploads/messaging'.'/'.$token.'/chatphoto')) {
				mkdir('uploads/messaging'.'/'.$token.'/chatphoto', 0777, TRUE);
			}

			$error = array();

			$config = array(
					 'upload_path'      => 'uploads/messaging'.'/'.$token.'/chatphoto'.'/',
					 'allowed_types'    => 'jpeg|jpg|png|gif',
					 'max_size'			    => '100000',
					 'overwrite'        => TRUE,
					 'file_ext_tolower' => TRUE,
			 );

			$this->load->library('upload',$config);
			$cntr = 0;
			for ($i=0; $i < count($_FILES['files']['name']); $i++) {
				$_FILES['file']['name']      = $_FILES['files']['name'][$i];
				$_FILES['file']['type']      = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name']  = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['files']['error'][$i];
				$_FILES['file']['size']      = $_FILES['files']['size'][$i];

				$filename = $token;
				$config['file_name'] = $filename;
				$this->upload->initialize($config);

				if($cntr == '0'){ //Limit to 1 upload only
					if($this->upload->do_upload('file')){
						$chatphoto = base_url().'uploads/messaging/'.$filename.'/chatphoto'.'/'.strtolower($filename.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
					}else{
						$chatphoto = base_url().'assets/images/default-user.png';
					}
					$cntr++;
				}
			}
		}else{
			$chatphoto = base_url().'assets/images/default-user.png';
		}
		clearstatcache();
		for ($i=0; $i < count($_POST['employee']); $i++) {
			if(!empty($_POST['employee'][$i])){
				$employee_userid = trim($this->encrypt->decode($_POST['employee'][$i]));
				$wheredata = $this->db->where('acs.userid = "'.$employee_userid.'" AND acs.verified = "1"');
				$selectdata = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','','',$wheredata);
				$mname = !empty($selectdata[0]['mname']) ? $selectdata[0]['mname'][0].". " : "";
				$prefix = !empty($selectdata[0]['title']) ? $selectdata[0]['title']." " : "";
				$suffix = !empty($selectdata[0]['suffix']) ? " ".$selectdata[0]['suffix'] : "";
				$fullname = $prefix.ucwords($selectdata[0]['fname']." ".$mname.$selectdata[0]['sname']).$suffix;

				$data = array(
											'token'               => $token,
											'group_id'            => $mgid,
											'category'            => 'Multiple',
											'chat_name'           => trim($_POST['group_name']),
											'chat_photo'          => $chatphoto,
											'region_participants' => trim($_POST['short_description']),
											'creator_userid'      => trim($this->encrypt->decode($_POST['employee'][$i])),
											'creator_fullname'    => trim($fullname),
											'recipient_userid'	  => '',
											'recipient_fullname'  => '',
											'latest_datetime'     => '',
											'latest_sender'			  => '',
											'latest_message'		  => '',
											'date_created'        => date("Y-m-d"),
											'status'              => 'Active',
										 );
				$this->Embismodel->insertdata('messenger_groups',$data);

			}
		}
		echo "<script>alert('Group and users successfully added.')</script>";
		echo "<script>window.location.href='".base_url()."Messages'</script>";
	}
}
