<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Index extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
    date_default_timezone_set("Asia/Manila");
	}

  function index(){
		if ( !$this->session->userdata('logged_in'))
		{
				redirect('Index');
		}
    $region = $this->session->userdata('region');
    $whereusers = $this->db->where('acs.verified = "1" AND acs.userid != "1" AND acs.region = "'.$region.'" ORDER BY acs.timestamp DESC,acs.fname ASC');
    $data['queryusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','DISTINCT(acs.userid),acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp','',$whereusers);

		$whrmymessages = $this->db->where('mg.creator_userid ="'.$this->session->userdata('userid').'" AND mg.status = "Active" ORDER BY latest_datesent DESC, latest_timesent DESC');
		$data['mymessages'] = $this->Embismodel->selectdata('messenger_groups AS mg','mg.unseen_msgs_count,mg.token,mg.category,mg.chat_name,mg.recipient_userid,mg.recipient_fullname,mg.latest_datetime,mg.latest_sender,mg.latest_message,mg.date_created','',$whrmymessages);

    $this->load->view('includes/messages/includes/header');
    $this->load->view('includes/messages/includes/sidebar',$data);
		$this->load->view('includes/messages/index');
    $this->load->view('includes/messages/includes/footer');
  }

	function transmitdata(){
		$datetime = date("Y-m-d h:i:sa");
		$datesent = date("M d, Y");
		$time = date("h:i a");
		$msg = $this->input->post('msg', TRUE);
		$msgtoken = $this->input->post('token', TRUE);
		$token = $this->session->userdata('token');
		$userimage = $this->session->userdata('user_photo');
		$fullname = $this->session->userdata('name');

		$chk_wheretoken = array('mg.token' => $msgtoken,);
		$chkjoin = $this->db->join('messenger_content AS mc','mc.msg_token = mg.token','left');
		$chk_msgtoken = $this->Embismodel->selectdata('messenger_groups AS mg','mg.token,MAX(msg_order) AS mxo',$chk_wheretoken,$chkjoin);

		$chk_wheretokenuserid = array('acs.token' => $token,);
		$get_userdetails = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.token',$chk_wheretokenuserid);

		$prefix = (!empty($get_userdetails[0]['title'])) ? $get_userdetails[0]['title'] : '';
		$fname = (!empty($get_userdetails[0]['fname'])) ? $get_userdetails[0]['fname'] : '';
		$mname = (!empty($get_userdetails[0]['mname'])) ? $get_userdetails[0]['mname'] : '';
		$sname = (!empty($get_userdetails[0]['sname'])) ? $get_userdetails[0]['sname'] : '';
		$suffix = (!empty($get_userdetails[0]['suffix'])) ? $get_userdetails[0]['suffix'] : '';

		if(!empty($chk_msgtoken[0]['token'])){
			if(!empty($msg) AND !empty($msgtoken) AND !empty($token) AND !empty($fullname) AND !empty($datetime)){

				$content_token = uniqid().uniqid();
				$data = array(
										  'msg_token'       => $msgtoken,
											'msg_order'       => $chk_msgtoken[0]['mxo']+1,
											'message'         => $msg,
											'datetime_sent'   => $datetime,
											'datesent'  		  => $datesent,
											'timesent'  		  => $time,
											'by_photo'        => $this->session->userdata('user_photo'),
											'by'              => trim($fullname),
											'by_displayname'	=> $this->session->userdata('display_name'),
											'by_prefix'				=> $prefix,
											'by_fname'	      => $fname,
											'by_mname'	      => $mname,
											'by_sname'	      => $sname,
											'by_suffix'	      => $suffix,
											'by_userid'       => $get_userdetails[0]['userid'],
											'by_useridtoken'  => $get_userdetails[0]['token'],
											'status'          => 'Active',
											'token'           => $content_token,
										 );
				$this->Embismodel->insertdata('messenger_content',$data);

				$display_name = ($this->session->userdata('display_name') != '') ? $this->session->userdata('display_name') : $fullname;
				$data = array('msgtoken' => $msgtoken, 'msgtokenen' => $this->encrypt->encode($msgtoken),'msg' => $msg, 'token' => $token, 'timelog' => $time, 'userimage' => $userimage, 'fullname' => $display_name, 'content_token' => $content_token, 'uid' => $this->session->userdata('userid'));
				echo json_encode($data);

				$chk_unseen_msg = array('mg.token' => $msgtoken,'mg.creator_userid !=' => $this->session->userdata('userid'),);
				$chk_unseen = $this->Embismodel->selectdata('messenger_groups AS mg','mg.unseen_msgs_count',$chk_unseen_msg);
				$msgunseencount = $chk_unseen[0]['unseen_msgs_count']+1;

				$whrcontentmsg = $this->db->where('mc.msg_token = "'.$msgtoken.'"');
				$maxcontentmsg = $this->Embismodel->selectdata('messenger_content AS mc','MAX(cnt) AS mcnt','',$whrcontentmsg);

				$setdata = array(
												 'latest_datetime'   => $datetime,
												 'latest_datesent'   => date("Y-m-d"),
	 											 'latest_timesent'   => date("h:i:s"),
												 'latest_sender'     => trim($fullname),
												 'latest_message'    => $msg,
												 'seen_by'					 => $get_userdetails[0]['userid'].";",
												 'unseen_msgs_count' => $msgunseencount,
												 'status'            => 'Active',
											  );
				$wheredata = $this->db->where('token = "'.$msgtoken.'" AND ifremoved IS NULL');
				$this->Embismodel->updatedata($setdata,'messenger_groups','',$wheredata);
				$setdata = array(
												 'lastseen_msg_cnt'  => $maxcontentmsg[0]['mcnt'],
											  );
				$wheredata = array('token' => $msgtoken,'creator_userid' => $this->session->userdata('userid'),);
				$this->Embismodel->updatedata($setdata,'messenger_groups',$wheredata);
			}
		}
	}

	function messageoption(){
		$contenttoken = ($this->input->post('msgcnt', TRUE));
		$wheredata = array('mc.token' => $contenttoken,);
		$selectdata = $this->Embismodel->selectdata('messenger_content AS mc','mc.msg_token,mc.status',$wheredata);
			if(!empty($contenttoken)){ ?>
			<?php if($selectdata[0]['status'] == 'Active'){ ?>
				<a class="dropdown-item d-flex align-items-center" href="#" onclick="dltmsg('<?php echo $contenttoken; ?>','<?php echo $selectdata[0]['msg_token']; ?>','<?php echo $this->encrypt->encode($contenttoken); ?>');">
						Remove <span class="ml-auto fe-trash-2"></span>
				</a>
			<?php } if($selectdata[0]['status'] == 'Deleted'){ ?>
				<a class="dropdown-item d-flex align-items-center" href="#" onclick="rstrmsg('<?php echo $contenttoken; ?>','<?php echo $selectdata[0]['msg_token']; ?>','<?php echo $this->encrypt->encode($contenttoken); ?>');">
						Restore <span class="ml-auto fa fa-undo"></span>
				</a>
			<?php } ?>

		<?php }
	}

	function dltmsg(){
		$datetime = date("Y-m-d h:i:sa");
		$fullname = $this->session->userdata('name');
		$contenttoken = ($this->input->post('contenttoken', TRUE));
		$econtenttoken = $this->encrypt->decode($this->input->post('econtenttoken', TRUE));

		$msgtoken = ($this->input->post('msgtoken', TRUE));
		if(!empty($econtenttoken)){
			$ssetdata = array('latest_datetime'  => $datetime, 'latest_sender' => $fullname, 'latest_message'   => '<i>Message deleted</i>',);
			$wwheredata = array('token' => $msgtoken,);
			$this->Embismodel->updatedata($ssetdata,'messenger_groups',$wwheredata);

			$setdata = array('status' => 'Deleted',);
			$wheredata = array('token' => $econtenttoken,);
			$deleteupdatedata = $this->Embismodel->updatedata($setdata,'messenger_content',$wheredata);
			if($deleteupdatedata){
				$wheredata = array('mc.token' => $econtenttoken,);
				$selectdata = $this->Embismodel->selectdata('messenger_content AS mc','mc.token,mc.msg_token,mc.attachmenttitle,mc.by_photo',$wheredata);
				echo json_encode(array('status' => 'deleted', 'filetitle' => $selectdata[0]['attachmenttitle'], 'msg_token' => $selectdata[0]['msg_token'], 'contenttoken' => $selectdata[0]['token'], 'userimage' => $selectdata[0]['by_photo'],));
			}
		}
	}

	function rstrmsg(){
		$datetime = date("Y-m-d h:i:sa");
		$fullname = $this->session->userdata('name');
		$contenttoken = ($this->input->post('contenttoken', TRUE));
		$econtenttoken = $this->encrypt->decode($this->input->post('econtenttoken', TRUE));

		$wheredata = array('mc.token' => $econtenttoken,);
		$selectdata = $this->Embismodel->selectdata('messenger_content AS mc','mc.msg_token,mc.message,mc.attachmenttitle,mc.attachmentfile,mc.ext,mc.by,mc.token',$wheredata);

		$msgtoken = ($this->input->post('msgtoken', TRUE));
		if(!empty($econtenttoken)){
			$ssetdata = array('latest_datetime'  => $datetime, 'latest_sender' => $fullname, 'latest_message'   => $selectdata[0]['message'],);
			$wwheredata = array('token' => $msgtoken,);
			$this->Embismodel->updatedata($ssetdata,'messenger_groups',$wwheredata);

			$setdata = array('status' => 'Active',);
			$wheredata = array('token' => $econtenttoken,);
			$deleteupdatedata = $this->Embismodel->updatedata($setdata,'messenger_content',$wheredata);
			if($deleteupdatedata){
				$filetype = explode(';',$selectdata[0]['ext']);
				$filename = explode(';',$selectdata[0]['attachmentfile']);
				$filetitle = explode(';',$selectdata[0]['attachmenttitle']);
				$dataarray = array('status' => 'restored', 'msg_token' => $selectdata[0]['msg_token'], 'message' => $selectdata[0]['message'], 'sendername' => trim($selectdata[0]['by']), 'usertoken' => $this->session->userdata('token'), 'contenttoken' => $selectdata[0]['token'],);
				$responsemerge = array_merge($dataarray, ['filetitle' => $filetitle], ['filename' => $filename], ['filetype' => $filetype]);
				echo json_encode($responsemerge);
			}
		}
	}

	function kilid(){
		$whrmymessages = $this->db->where('mg.creator_userid ="'.$this->session->userdata('userid').'" AND (mg.status = "Active" OR mg.status = "Removed") ORDER BY latest_datesent DESC, latest_timesent DESC');
    $mymessages = $this->Embismodel->selectdata('messenger_groups AS mg','mg.status,mg.ifremoved,mg.chat_photo,mg.unseen_msgs_count,mg.token,mg.category,mg.chat_name,mg.recipient_userid,mg.recipient_fullname,mg.latest_datetime,mg.latest_sender,mg.latest_message,mg.date_created','',$whrmymessages);
		// echo $this->db->last_query();
		 for ($r=0; $r < sizeof($mymessages); $r++) {
			if(!empty($mymessages[$r]['latest_datetime'])){
				$datetime = (date("Y-m-d", strtotime($mymessages[$r]['latest_datetime'])) == date("Y-m-d")) ? date("h:i a", strtotime($mymessages[$r]['latest_datetime'])) : date("M d - h:i a", strtotime($mymessages[$r]['latest_datetime']));
			}else{
				$datetime = date("M d, Y", strtotime($mymessages[$r]['date_created']));
			}

			if(!empty($mymessages[$r]['latest_message']) AND $mymessages[$r]['status'] == 'Active' AND $mymessages[$r]['ifremoved'] != 'yes'){
				$message = ($mymessages[$r]['category'] == 'Single') ?  $mymessages[$r]['latest_message'] : str_replace(';',': ',$mymessages[$r]['latest_sender']).": ".$mymessages[$r]['latest_message'];
			}else if($mymessages[$r]['status'] == 'Active' AND $mymessages[$r]['latest_message'] == '' AND $mymessages[$r]['ifremoved'] != 'yes'){
				$message = "<i>No messages yet</i>";
			}else if($mymessages[$r]['ifremoved'] == 'yes'){
				$message = "<i>You've been removed to this group</i>";
			}

			if(!empty($mymessages[$r]['token'])){
				if($mymessages[$r]['category'] == 'Single'){
					$checkpath = base_url()."Messages/View/index/".$this->encrypt->encode($mymessages[$r]['token']);
				}else if($mymessages[$r]['category'] == 'Multiple'){
					$checkpath = base_url()."Messages/View/index/".$this->encrypt->encode($mymessages[$r]['token']);
				}

				$dp = (!empty($mymessages[$r]['chat_photo'])) ? $mymessages[$r]['chat_photo'] : base_url().'assets/images/default-user.png';

		?>
			<!-- Chat link -->
			<a class="text-reset nav-link p-0 mb-6" href="<?= $checkpath; ?>" style="margin-bottom:5px!important;">
					<div class="card card-active-listener">
							<div class="card-body">

									<div class="media">
											<div class="avatar mr-5">
													<img class="avatar-img" src="<?php echo $dp; ?>">
											</div>

											<div class="media-body overflow-hidden" id="message-card-left<?php echo $mymessages[$r]['token']; ?>">
													<div class="d-flex align-items-center mb-1">
															<h6 class="text-truncate mb-0 mr-auto"><?php echo $mymessages[$r]['chat_name']; ?></h6>
															<p class="small text-muted text-nowrap ml-4"><?php echo $datetime; ?></p>
													</div>
													<div class="text-truncate"><?php echo $message; ?></div>
											</div>
									</div>

							</div>

							<?php if($mymessages[$r]['unseen_msgs_count'] != ''){ ?>
								<div class="badge badge-circle badge-primary badge-border-light badge-top-right">
										<span><?php echo $mymessages[$r]['unseen_msgs_count']; ?></span>
								</div>
							<?php } ?>

					</div>
			</a>
			<!-- Chat link -->
		<?php } }
	}

}
