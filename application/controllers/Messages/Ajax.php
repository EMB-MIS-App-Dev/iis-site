<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Ajax extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
    date_default_timezone_set("Asia/Manila");
	}

  function pflvw(){
    $userid = $this->session->userdata('userid');

    $wheredata = $this->db->where('acs.verified = "1" AND acs.userid = "'.$userid.'"');
    $joindata = $this->db->join('acc_xdvsion AS ax','ax.divno = acs.divno','left');
    $joindata = $this->db->join('acc_region AS acr','acr.rgnnum = acs.region','left');
    $selectdata = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.designation,ax.divname,acs.section,acs.email,acr.rgnnumeral,acs.display_name','',$wheredata);
    $mname = ($selectdata[0]['mname']) ? $selectdata[0]['mname'][0].". " : "";
    $suffix = ($selectdata[0]['suffix']) ? " ".$selectdata[0]['suffix'] : "";
    $prefix = ($selectdata[0]['title']) ? $selectdata[0]['title']." " : "";
    $fullname = $prefix.ucwords($selectdata[0]['fname']." ".$mname.$selectdata[0]['sname']).$suffix;
		$dp = $this->session->userdata('user_photo');

  ?>
      <!-- Card -->
      <div class="card mb-6">
          <div class="card-body">
              <div class="text-center py-6">
                  <!-- Photo -->
                  <div class="avatar avatar-xl mb-5">
                      <img class="avatar-img" style="border: 4px solid#0D98C7;padding: 2px;" id="display-photo" src="<?php echo $dp; ?>" alt="">
                  </div>
									<form method="post" action="#" enctype="multipart/form-data">
										<input id="user-photo" class="d-none" onchange="document.getElementById('display-photo').src = window.URL.createObjectURL(this.files[0]); prevuploadbtn();"  type="file" name="files[]">
									</form>
									<h5 id="upload-button-head">
										<button type="button" class="btn btn-info btn-sm" onclick=document.getElementById("user-photo").click();>
											<span class="fa fa-edit"></span>
											Change Photo
										</button>
									</h5>
									<div class="progress" id="progressuseruploadphoto" style="display:none;">
									  <div class="progress-bar progress-bar-striped progress-bar-animated" id="userphotouploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
											<span id="userphotouploadprogresspercentage_"></span>
										</div>
									</div>
                  <h5><?php echo $fullname; ?></h5>
                  <p class="text-muted"><?php echo $selectdata[0]['designation']; ?></p>
              </div>
          </div>
      </div>
      <!-- Card -->

      <!-- Card -->
      <div class="card mb-6">
          <div class="card-body">
              <ul class="list-group list-group-flush">
								<?php if($_SESSION['userid'] == '1'){ ?>
                <li class="list-group-item px-0 py-6">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="small text-muted mb-0">Display Name</p>
                            <input type="text" class="form-control" id="dsplynamtxtbx" value="<?php echo $selectdata[0]['display_name']; ?>" disabled>
                            <div class="col-md-12" id="edtdsplynam_" style="margin-top:5px;padding:0px;">
                              <button type="button" class="btn btn-default btn-sm" style="background-color:#F6C23E;color:#FFF;width:100%;" onclick="edtinfousr('<?php echo $this->encrypt->encode('display_name'); ?>','edtdsplynam_','display_name');">Edit</button>
                            </div>
                        </div>
                    </div>
                </li>
								<?php } ?>
                <li class="list-group-item px-0 py-6">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="small text-muted mb-0">Division</p>
                            <p style="color:#000;"><?php echo $selectdata[0]['divname']; ?></p>
                        </div>
                        <i class="text-muted icon-sm fa fa-info-circle"></i>
                    </div>
                </li>
                <li class="list-group-item px-0 py-6">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="small text-muted mb-0">Section/Unit</p>
                            <p style="color:#000;"><?php echo $section = (!empty($selectdata[0]['section'])) ? $selectdata[0]['section'] : "N/A"; ?></p>
                        </div>
                        <i class="text-muted icon-sm"></i>
                    </div>
                </li>
                <li class="list-group-item px-0 py-6">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class="small text-muted mb-0">Email </p>
                            <p style="color:#000;"><?php echo $selectdata[0]['email']; ?></p>
                        </div>
                        <i class="text-muted icon-sm fe-mail"></i>
                    </div>
                </li>

                  <li class="list-group-item px-0 py-6">
                      <div class="media align-items-center">
                          <div class="media-body">
                              <p class="small text-muted mb-0">Region/Office</p>
                              <p style="color:#000;"><?php echo $selectdata[0]['rgnnumeral']; ?></p>
                          </div>
                          <i class="text-muted icon-sm fa fa-building"></i>
                      </div>
                  </li>
              </ul>
          </div>
      </div>
      <!-- Card -->
  <?php
  }

  function edtinfousr(){
    $editcat = $this->encrypt->decode($this->input->post('editcat'));
    if($editcat == 'display_name'){ ?>
      <div class="row">
        <div class="col-md-6">
          <button type="button" class="btn btn-default btn-sm" style="background-color:#F6C23E;color:#FFF;width:100%;margin-top:5px;" onclick="edtinfousr('<?php echo $this->encrypt->encode('undo_display_name'); ?>','edtdsplynam_','undo_display_name');">Undo</button>
        </div>
        <div class="col-md-6">
          <button type="button" class="btn btn-success btn-sm" style="color:#FFF;width:100%;margin-top:5px;" onclick="svinfousr($('#dsplynamtxtbx').val());">Save</button>
        </div>
      </div>
    <?php }if($editcat == 'undo_display_name'){ ?>
      <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-default btn-sm" style="background-color:#F6C23E;color:#FFF;width:100%;" onclick="edtinfousr('<?php echo $this->encrypt->encode('display_name'); ?>','edtdsplynam_','display_name');">Edit</button>
        </div>
      </div>
    <?php }
  }

  function svinfousr(){
    $userid = $this->session->userdata('userid');
    $txtbx = $this->input->post('txtbx', TRUE);
    if(!empty($userid)){
      $setdata = array('display_name' => $txtbx,);
      $wheredata = array('userid' => $userid, );
      $updatedata = $this->Embismodel->updatedata($setdata,'acc_credentials',$wheredata);
      if($updatedata){
        echo json_encode(array('status' => 'updated',));
      }
    }
  }

	function crtcht(){
		$region = $this->session->userdata('region');
		if($region != 'CO'){
			$whereusertype = $this->db->where('au.typeid != "" AND au.dsc != "Director" AND au.dsc != "Assistant Director" ORDER BY au.ordr');
		}else{
			$whereusertype = $this->db->where('au.typeid != "" AND au.dsc != "Regional Director" ORDER BY au.ordr');
		}

		$selectusertype = $this->Embismodel->selectdata('acc_usertype AS au','au.dsc','',$whereusertype);
    $whereusers = $this->db->where('af.stat = "1" AND acs.verified = "1" AND acs.userid != "'.$this->session->userdata('userid').'" AND acs.region = "'.$region.'" GROUP BY acs.userid ORDER BY acs.fname ASC');
		$joinusers = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
    $users = $this->Embismodel->selectdata('acc_credentials AS acs','DISTINCT(af.userid),acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.timestamp,acs.designation,af.func','',$joinusers,$whereusers);

	?>
		<!-- Search -->
		<!-- <form class="mb-6">
				<div class="input-group">
						<input type="text" class="form-control form-control-lg" placeholder="Search for messages or users..." aria-label="Search for messages or users...">
						<div class="input-group-append">
								<button class="btn btn-lg btn-ico btn-secondary btn-minimal" type="submit">
										<i class="fe-search"></i>
								</button>
						</div>
				</div>
		</form> -->
		<!-- Search -->

		<!-- Tabs -->
		<ul class="nav nav-tabs nav-justified mb-6" role="tablist">
				<li class="nav-item">
						<a href="#create-group-details" class="nav-link active" data-toggle="tab" role="tab" aria-selected="true">Details</a>
				</li>

				<li class="nav-item">
						<a href="#create-group-members" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">Members</a>
				</li>
		</ul>
		<!-- Tabs -->

		<!-- Create chat -->
		<div class="tab-content" role="tablist">

				<!-- Chat details -->
				<div id="create-group-details" class="tab-pane fade show active" role="tabpanel">

								<div class="form-group" style="text-align: center;">
									<div class="avatar avatar-xl mb-5">
											<img class="avatar-img" style="border: 4px solid#0D98C7;padding: 2px;" id="display-group-photo" src="<?php echo base_url().'assets/images/default-user.png'; ?>" alt="">
									</div>
									<input id="group-photo" class="d-none" onchange="document.getElementById('display-group-photo').src = window.URL.createObjectURL(this.files[0]); prevuploadbtngroup();"  type="file" name="files[]">
							  	<h5 id="upload-button-head-group">
										<button type="button" class="btn btn-info btn-sm" onclick=document.getElementById("group-photo").click();>
											<span class="fa fa-edit"></span>
											Add Chat Photo
										</button>
									</h5>
								</div>
								<div class="form-group">
										<label class="small" for="new-chat-title">Group Name</label>
										<input class="form-control form-control-lg" name="group_name" id="new-chat-title" type="text" placeholder="Group Name" required>
								</div>

								<div class="form-group">
										<label class="small" for="new-chat-title">Short Description</label>
										<input class="form-control form-control-lg" name="short_description" type="text" placeholder="Details" required>
								</div>

								<!-- <div class="form-group">
										<label class="small" for="new-chat-topic">Topic (optional)</label>
										<input class="form-control form-control-lg" name="new-chat-topic" id="new-chat-topic" type="text" placeholder="Group Topic">
								</div>

								<div class="form-group mb-0">
										<label class="small" for="new-chat-description">Description</label>
										<textarea class="form-control form-control-lg" name="new-chat-description" id="new-chat-description" rows="6" placeholder="Group Description"></textarea>
								</div> -->


				</div>
				<!-- Chat details -->

				<!-- Chat Members -->
				<div id="create-group-members" class="tab-pane fade" role="tabpanel">
						<nav class="list-group list-group-flush mb-n6">
							<?php $cntr = '0';
								for ($u=0; $u < sizeof($selectusertype); $u++) { ?>
									<div class="mb-6">
											<small class="text-uppercase"><?php echo $selectusertype[$u]['dsc']; ?></small>
									</div>
							<?php
									for ($i=0; $i < sizeof($users); $i++) {
										$mname = (!empty($users[$i]['mname'])) ? $users[$i]['mname'][0].". " : "";
										$suffix = (!empty($users[$i]['suffix'])) ? " ".$users[$i]['suffix'] : "";
										$prefix = (!empty($users[$i]['title'])) ? $users[$i]['title']." " : "";
										$name = $prefix.ucwords($users[$i]['fname']." ".$mname.$users[$i]['sname']).$suffix;
										if($selectusertype[$u]['dsc'] == $users[$i]['func']){
										if($cntr == '0'){ $cntr++;
											echo '<input type="checkbox" style="visibility:hidden;" name="employee[]" value="'.$this->encrypt->encode($this->session->userdata('userid')).'" checked>';
										}
							?>
								<!-- Friend -->
								<div class="card mb-6">
										<div class="card-body">

												<div class="media">


														<div class="avatar mr-5">
																<img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
														</div>


														<div class="media-body align-self-center mr-6">
																<h6 class="mb-0"><?php echo $name; ?></h6>
																<small class="text-muted"><?php echo $users[$i]['designation']; ?></small>
														</div>

														<div class="align-self-center ml-auto">
																<div class="custom-control custom-checkbox">
																		<input class="custom-control-input" id="id-user-<?php echo $users[$i]['userid']; ?>" type="checkbox" name="employee[]" value="<?php echo $this->encrypt->encode($users[$i]['userid']); ?>">
																		<label class="custom-control-label" for="id-user-<?php echo $users[$i]['userid']; ?>"></label>
																</div>
														</div>
												</div>

										</div>

										<!-- Label -->
										<label class="stretched-label" for="id-user-<?php echo $users[$i]['userid']; ?>"></label>
								</div>
								<!-- Friend -->
							<?php } } ?>
						<?php } ?>

						</nav>

				</div>
				<!-- Chat Members -->

		</div>
		<!-- Create chat -->
		<?php
	}

  function snmsg(){
    $msgtoken = $this->encrypt->decode($this->input->post('token', TRUE));
    if(!empty($msgtoken) AND !empty($this->session->userdata('userid'))){
      //getmax first for last seen message
      $$wheremaxcntmsg = $this->db->where('mc.msg_token = "'.$msgtoken.'" AND mc.cnt = (SELECT MAX(mc2.cnt) FROM messenger_content AS mc2 WHERE mc2.msg_token = "'.$msgtoken.'")');
      $selectmaxcntmsg = $this->Embismodel->selectdata('messenger_content AS mc','mc.cnt,mc.token,mc.by_useridtoken','',$wheremaxcntmsg);
      $dataset = "";
      $wheredataa = array('mg.token' => $msgtoken, 'creator_userid' => $this->session->userdata('userid'), );
      $selectdata = $this->Embismodel->selectdata('messenger_groups AS mg','mg.seen_by,mg.unseen_msgs_count',$wheredataa);
      $expld = explode(';',$selectdata[0]['seen_by']);
      if(!in_array($this->session->userdata('userid'), $expld)) { //insert userid to seen_by column if not yet placed
        if(!empty($selectdata[0]['seen_by'])){
          $seen_by = explode(';',$selectdata[0]['seen_by']);
          for ($i=0; $i < count($seen_by); $i++) {
            if(!empty($seen_by[$i]) AND $this->session->userdata('userid') != $seen_by[$i]){
              $dataset .= $seen_by[$i].";";
            }
          }
        }
        $dtset = (empty($dataset)) ? $this->session->userdata('userid').";" : $dataset.$this->session->userdata('userid').";";

        $setdata = array('seen_by' => $dtset,);
        $wheredata = array('token' => $msgtoken, );
        $updatedata = $this->Embismodel->updatedata($setdata,'messenger_groups',$wheredata);

        if($updatedata){
          $userimage = $this->session->userdata('user_photo');
          echo json_encode(array('status' => 'seen', 'msgtoken' => $msgtoken, 'sendertoken' => $selectmaxcntmsg[0]['by_useridtoken'], 'userimage' => $userimage, 'name' => $this->session->userdata('name'), 'token' => $selectmaxcntmsg[0]['token'], 'uid' => $this->session->userdata('userid'), ));
        }
      }
      if(!empty($selectdata[0]['unseen_msgs_count'])){ //mark unseen messages to seen
        $setdataself = array('unseen_msgs_count' => '', 'lastseen_msg_cnt' => $selectmaxcntmsg[0]['cnt'], );
        $wheredataself = array('token' => $msgtoken, 'creator_userid' => $this->session->userdata('userid'), );
        $updatedataself = $this->Embismodel->updatedata($setdataself,'messenger_groups',$wheredataself);
      }
    }
  }

	function ld(){
		$msgtoken = $this->encrypt->decode($this->input->post('msgtoken'));
		$baserow = $this->input->post('baserow');
		$newbaserow = $baserow - 1;
		$minusbaserow = $baserow - 10;
		$resbaserow = ($minusbaserow > 0) ? $minusbaserow : 0;

		$wheredata	= $this->db->where('mc.msg_token = "'.$msgtoken.'" AND mc.msg_order BETWEEN "'.$resbaserow.'" AND "'.$newbaserow.'" ORDER BY mc.msg_order DESC');
		$selectdata = $this->Embismodel->selectdata('messenger_content AS mc','mc.msg_token,mc.by,mc.message,mc.datesent,mc.timesent,mc.msg_order,mc.token,mc.by_useridtoken','',$wheredata);
		echo json_encode($selectdata);
	}

	function uploadfiles(){
		if(!empty($_POST['token']) AND !empty($_FILES['files']['name'])){

			$datetime = date("Y-m-d h:i:sa");
			$datesent = date("M d, Y");
			$time = date("h:i a");
			$msgtoken = $this->input->post('token', TRUE);
			$token = $this->session->userdata('token');

			$fullname = $this->session->userdata('name');

			$chk_wheretoken = array('mg.token' => $msgtoken,);
			$chkjoin = $this->db->join('messenger_content AS mc','mc.msg_token = mg.token','left');
			$chk_msgtoken = $this->Embismodel->selectdata('messenger_groups AS mg','mg.token,MAX(msg_order) AS mxo',$chk_wheretoken,$chkjoin);

			$chk_wheretokenuserid = array('acs.token' => $token,);
			$get_userdetails = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.token',$chk_wheretokenuserid);
			$userimage = $this->session->userdata('user_photo');

			$prefix = (!empty($get_userdetails[0]['title'])) ? $get_userdetails[0]['title'] : '';
			$fname = (!empty($get_userdetails[0]['fname'])) ? $get_userdetails[0]['fname'] : '';
			$mname = (!empty($get_userdetails[0]['mname'])) ? $get_userdetails[0]['mname'] : '';
			$sname = (!empty($get_userdetails[0]['sname'])) ? $get_userdetails[0]['sname'] : '';
			$suffix = (!empty($get_userdetails[0]['suffix'])) ? $get_userdetails[0]['suffix'] : '';

			if (!is_dir('uploads/messaging'.'/'.$_POST['token'])) {
	      mkdir('uploads/messaging'.'/'.$_POST['token'], 0777, TRUE);
	    }

			$error = array();

			$config = array(
					 'upload_path'   => 'uploads/messaging'.'/'.$_POST['token'].'/',
					 'allowed_types' => 'pdf|csv|xls|ppt|doc|docx|xlsx|mp4|m4a|jpeg|jpg|png|gif|mp3|zip|text|txt',
					 'max_size'			 => '100000',
					 'overwrite'     => FALSE,
			 );

			$this->load->library('upload',$config);

			$content_token = uniqid().uniqid();
			$display_name = ($this->session->userdata('display_name') != '') ? $this->session->userdata('display_name') : $fullname;

			$cntr = 0;
			$attachmentdata = '';
			$attachmentdatafile = '';
			$ext = '';
			$images = array();
			for ($i=0; $i < count($_FILES['files']['name']); $i++) {
				$_FILES['file']['name']      = $_FILES['files']['name'][$i];
				$_FILES['file']['type']      = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name']  = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['files']['error'][$i];
				$_FILES['file']['size']      = $_FILES['files']['size'][$i];

				$filename = date('ymdhis').$i;
				$config['file_name'] = $filename;
        $this->upload->initialize($config);

				if($this->upload->do_upload('file')){
					$cntr++;
					$response[$i]['upload_status'] = '0';
					$response[$i]['content_token']  = $content_token;
					$attachment[$i]  = $_FILES['file']['name'];
					$filetype[$i] = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					$file[$i]  = $filename.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					$attachmentdata .= $_FILES['files']['name'][$i].';';
					$attachmentdatafile .= $filename.';';
					$ext .= pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION).';';

				}else{
					$response[$i]['upload_status'] = '1';
					$response[$i]['content_token']  = '';
				}
					$response[$i]['user_token'] = $get_userdetails[0]['token'];
					$response[$i]['msg_token'] = $msgtoken;
					$response[$i]['userimage'] = $userimage;
					$response[$i]['timelog'] = $time;
					$response[$i]['fullname'] = trim($fullname);
			}

			if($cntr != '0'){
				$data = array(
											'msg_token'       => $msgtoken,
											'msg_order'       => $chk_msgtoken[0]['mxo']+1,
											'message'         => '',
											'attachmenttitle' => $attachmentdata,
											'attachmentfile'  => $attachmentdatafile,
											'ext'             => $ext,
											'datetime_sent'   => $datetime,
											'datesent'  		  => $datesent,
											'timesent'  		  => $time,
											'by_photo'				=> $userimage,
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

				$chk_unseen_msg = array('mg.token' => $msgtoken,'mg.creator_userid !=' => $this->session->userdata('userid'),);
				$chk_unseen = $this->Embismodel->selectdata('messenger_groups AS mg','mg.unseen_msgs_count',$chk_unseen_msg);
				$msgunseencount = $chk_unseen[0]['unseen_msgs_count']+1;
				$setdata = array(
												 'latest_datetime'   => $datetime,
												 'latest_datesent'   => date("Y-m-d"),
												 'latest_timesent'   => date("h:i:s"),
												 'latest_sender'     => trim($fullname),
												 'latest_message'    => 'shared a file',
												 'seen_by'					 => $get_userdetails[0]['userid'].";",
												 'unseen_msgs_count' => $msgunseencount,
												 'status'            => 'Active',
												);
				$wheredata = array('token' => $msgtoken,);
				$this->Embismodel->updatedata($setdata,'messenger_groups',$wheredata);
			}

			$responsemerge = array_merge($response, ['uploaded' => $attachment], ['filetype' => $filetype], ['filename' => $file]);
			echo json_encode($responsemerge);
			clearstatcache();

		}
	}

	function filescontent(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$whrmsgfiles = $this->db->where('mc.msg_token ="'.$token.'" AND mc.status = "Active" AND mc.attachmenttitle != "" ORDER BY mc.msg_order ASC');
		$messagefiles = $this->Embismodel->selectdata('messenger_content AS mc','mc.attachmenttitle,mc.attachmentfile,mc.ext,mc.datetime_sent,mc.by_sname','',$whrmsgfiles);
	?>
		<ul class="list-group list-group-flush list-group-no-border-first">
			<?php for ($fl=0; $fl < sizeof($messagefiles); $fl++) {
				$explodeattchfiles = explode(';',$messagefiles[$fl]['attachmentfile']);
					for ($fls=0; $fls < count($explodeattchfiles); $fls++) {
						if($explodeattchfiles[$fls] != ''){
							$explodeattchfilestitle = explode(';',$messagefiles[$fl]['attachmenttitle']);
							$explodeattchfilesext = explode(';',$messagefiles[$fl]['ext']);
							$file = base_url().'uploads/messaging/'.$token.'/'.$explodeattchfiles[$fls].'.'.$explodeattchfilesext[$fls];
							$sharedby = '<i>shared by</i> '.$messagefiles[$fl]['by_sname'];
							$shareddate = date("M d, Y", strtotime($messagefiles[$fl]['datetime_sent']));
							$explodeattchfilesext = ($explodeattchfilesext == ('png' OR 'jpeg' OR 'jpg' OR 'gif')) ? '<i class="fe-image"></i>' : '<i class="fe-paperclip"></i>';
			?>
				<!-- File -->
				<li class="list-group-item py-6">
						<div class="media">

								<div class="icon-shape bg-primary text-white mr-5">
										<?php echo $explodeattchfilesext; ?>
								</div>

								<div class="media-body align-self-center overflow-hidden">
										<h6 class="text-truncate mb-0">
												<a href="<?php echo $file; ?>" target="_blank" class="text-reset" title="<?php echo strtoupper($explodeattchfilestitle[$fls]); ?>"><?php echo strtoupper($explodeattchfilestitle[$fls]); ?></a>
										</h6>

										<ul class="list-inline small mb-0">
												<li class="list-inline-item">
														<span class="text-muted"><?php echo $sharedby." - ".$shareddate; ?></span>
												</li>
										</ul>
								</div>

						</div>
				</li>
				<!-- File -->
			<?php } } } ?>
		</ul>
	<?php
	}

	function angmahiwagangmensahe(){
			$wheredata = $this->db->where('mg.creator_userid = "'.$this->session->userdata('userid').'" ORDER BY latest_datesent DESC, latest_timesent DESC');
			$selectdata = $this->Embismodel->selectdata('messenger_groups AS mg','mg.token, mg.chat_name, mg.chat_photo, mg.recipient_userid','',$wheredata);
			$recipient = '';
			$title = '';
			$photo = '';
			$token = '';
			// for ($i=0; $i < sizeof($selectdata); $i++) {
			// 	$title[$i] = $selectdata[$i]['chat_name'];
			// 	$photo[$i] = $selectdata[$i]['chat_photo'];
			// 	$token[$i] = $this->encrypt->encode($selectdata[$i]['token']);
			// 	$recipient[$i] = $this->encrypt->encode($selectdata[$i]['recipient_userid']);
			// }
			$merge = array_merge(['title' => $title], ['photo' => $photo], ['token' => $token], ['recipient' => $recipient]);
			echo json_encode($merge);
	}

	function o_o(){
		$msgtoken = $this->encrypt->decode($this->input->post('token', TRUE));
		$rcpnt = str_replace(';','',$this->encrypt->decode($this->input->post('rcpnt', TRUE)));

		$wherecntn = $this->db->where('mg.token = "'.$msgtoken.'" AND mg.creator_userid != "'.$rcpnt.'"');
		$joincntn = $this->db->join('acc_credentials AS acs','acs.userid = "'.$rcpnt.'"','left');
		$selectcntn = $this->Embismodel->selectdata('messenger_groups AS mg','COUNT(mg.token) AS mcnt, mg.chat_name, mg.chat_photo, mg.category, acs.designation','',$joincntn,$wherecntn);

		$subtitle = ($selectcntn[0]['category'] == 'Multiple') ? ($selectcntn[0]['mcnt'])." members" : $selectcntn[0]['designation'];

		$wheredata = $this->db->where('mc.msg_token = "'.$msgtoken.'" ORDER BY msg_order ASC');
		$selectdata = $this->Embismodel->selectdata('messenger_content AS mc','mc.by AS sender, mc.by_photo AS photo, mc.by_useridtoken AS utoken, mc.message, mc.attachmenttitle AS atitle, mc.attachmentfile AS afile, mc.ext AS aext, mc.token AS ctoken','',$wheredata);
		$merge = array_merge(
													['responsedata' => $selectdata],
													['ssn_utoken' => $this->session->userdata('token')],
													['title' => $selectcntn[0]['chat_name']],
													['photo' => $selectcntn[0]['chat_photo']],
													['subtitle' => $subtitle]
												);
		echo json_encode($merge);
	}

	function uploaduserphoto(){
		if (!is_dir('uploads/profilepictures'.'/'.$this->session->userdata('token'))) {
			mkdir('uploads/profilepictures'.'/'.$this->session->userdata('token'), 0777, TRUE);
		}

		$error = array();

		$config = array(
				 'upload_path'      => 'uploads/profilepictures'.'/'.$this->session->userdata('token').'/',
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

			$filename = $this->session->userdata('token');
			$config['file_name'] = $filename;
			$this->upload->initialize($config);

			if($cntr == '0'){ //Limit to 1 upload only
				if($this->upload->do_upload('file')){
					$where = array('acs.userid' => $this->session->userdata('userid'), );
					$selectdata = $this->Embismodel->selectdata('acc_credentials AS acs','acs.user_photo',$where);
					if(!empty($selectdata[0]['user_photo'])){
						unlink('uploads/profilepictures'.'/'.$this->session->userdata('token').'/'.$selectdata[0]['user_photo']);
					}

					$setdata = array('by_photo' => base_url().'uploads/profilepictures'.'/'.$this->session->userdata('token').'/'.$filename.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), );
					$wheredata = array('by_userid' => $this->session->userdata('userid'), );
					$updatemsgscontent = $this->Embismodel->updatedata($setdata,'messenger_content',$wheredata);

					$setdata = array('chat_photo' => base_url().'uploads/profilepictures'.'/'.$this->session->userdata('token').'/'.$filename.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), );
					$wheredata = array('recipient_userid' => $this->session->userdata('userid').';', 'category' => 'Single',);
					$updatemsgsgroup = $this->Embismodel->updatedata($setdata,'messenger_groups',$wheredata);

					$setdata = array('user_photo' => $filename.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), );
					$wheredata = array('userid' => $this->session->userdata('userid'), );
					$update = $this->Embismodel->updatedata($setdata,'acc_credentials',$wheredata);
					if($update){
						$this->session->set_userdata('user_photo', base_url().'uploads/profilepictures'.'/'.$this->session->userdata('token').'/'.$filename.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
						echo json_encode(array('status' => 'success', ));
						$cntr++;
					}
				}else{
					echo json_encode(array('status' => 'failed', ));
				}
			}
		}

		clearstatcache();
	}

	function addusrtocht(){
		$msgtoken = $this->encrypt->decode($this->input->post('token',TRUE));
		$wheredata = array('mg.token' => $msgtoken, 'mg.status' => 'Active',);
		$selectdata = $this->Embismodel->selectdata('messenger_groups AS mg','mg.creator_userid',$wheredata);

		if($_SESSION['superadmin_rights'] == 'yes'){
			$whereactiveusers = $this->db->where('acs.region != ""');
		}else{
			$whereactiveusers = $this->db->where('acs.userid != "1" AND acs.region = "'.$this->session->userdata('region').'"');
		}

		for ($sa=0; $sa < sizeof($selectdata); $sa++) {
			$whereactiveusers = $this->db->where('acs.userid != "'.$selectdata[$sa]['creator_userid'].'"');
		}

		$whereactiveusers = $this->db->where('acs.verified = "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY af.func_order ASC, ar.rgnid ASC, acs.fname ASC');
		$joinactiveusers = $this->db->join('acc_region AS ar','ar.rgnnum = acs.region');
		$joinactiveusers = $this->db->join('acc_function AS af','af.userid = acs.userid');
		$activeusers = $this->Embismodel->selectdata('acc_credentials AS acs','acs.region,af.func,acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinactiveusers,$whereactiveusers);
	?>
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" id="addmsgtoken" value="<?php echo $this->input->post('token',TRUE); ?>">
				<label>Select user/s:</label>
				<select class="form-control" id="employee_msg_selectize">
					<option value="">-</option>
					<?php for ($au=0; $au < sizeof($activeusers); $au++) {
						$mname = (!empty($activeusers[$au]['mname'])) ? $activeusers[$au]['mname'][0].'. ' : '';
						$suffix = (!empty($activeusers[$au]['suffix'])) ? ' '.$activeusers[$au]['suffix'] : '';
						$prefix = (!empty($activeusers[$au]['title'])) ? $activeusers[$au]['title'].' ' : '';
						$name = $prefix.ucwords($activeusers[$au]['fname'].' '.$mname.$activeusers[$au]['sname']).$suffix;
					?>
						<optgroup label="<?php echo $activeusers[$au]['func']; ?>">
							<?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
								<option value="<?php echo $this->encrypt->encode($activeusers[$au]['userid']); ?>"><?php echo $activeusers[$au]['region'].' - '.$name; ?></option>
							<?php }else{ ?>
								<option value="<?php echo $this->encrypt->encode($activeusers[$au]['userid']); ?>"><?php echo $name; ?></option>
							<?php } ?>
						</optgroup>
					<?php } ?>
				</select>
			</div>
		</div>
	<script type="text/javascript">
			$('#employee_msg_selectize').selectize({
					maxItems: null
			});
	</script>
	<?php
	}

	function addusertochat(){
		$wheremsgroup = array('mg.creator_userid' => $this->session->userdata('userid'), 'mg.token' => $this->encrypt->decode($_POST['msgtoken']), );
		$selectmsgroup = $this->Embismodel->selectdata('messenger_groups AS mg','',$wheremsgroup);

		if(count($_POST['usertoken']) > 0){
			for ($i=0; $i < count($_POST['usertoken']); $i++) {
				if(!empty($this->encrypt->decode($_POST['usertoken'][$i]))){
					$wheredata = array('acs.verified' => '1',);
					$userdata = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix',$wheredata);
					$mname = !empty($userdata[0]['mname']) ? $userdata[0]['mname'][0].". " : "";
					$prefix = !empty($userdata[0]['title']) ? $userdata[0]['title']." " : "";
					$suffix = !empty($userdata[0]['suffix']) ? " ".$userdata[0]['suffix'] : "";
					$fullname = $prefix.ucwords($userdata[0]['fname']." ".$mname.$userdata[0]['sname']).$suffix;

					if(!empty($userdata[0]['userid'])){
						$data = array(
													'token'               => $selectmsgroup[0]['token'],
													'group_id'            => $selectmsgroup[0]['group_id'],
													'category'            => $selectmsgroup[0]['category'],
													'chat_name'           => $selectmsgroup[0]['chat_name'],
													'chat_photo'          => $selectmsgroup[0]['chat_photo'],
													'region_participants' => $selectmsgroup[0]['region_participants'],
													'creator_userid'      => $userdata[0]['userid'],
													'creator_fullname'    => trim($fullname),
													'recipient_userid'	  => $selectmsgroup[0]['recipient_userid'],
													'recipient_fullname'  => $selectmsgroup[0]['recipient_fullname'],
													'latest_datetime'     => $selectmsgroup[0]['latest_datetime'],
													'latest_datesent'     => $selectmsgroup[0]['latest_datesent'],
													'latest_timesent'     => $selectmsgroup[0]['latest_timesent'],
													'latest_sender'			  => $selectmsgroup[0]['latest_sender'],
													'latest_message'		  => $selectmsgroup[0]['latest_message'],
													'date_created'        => $selectmsgroup[0]['date_created'],
													'status'              => 'Active',
												 );
						$insertdata = $this->Embismodel->insertdata('messenger_groups',$data);
						if($insertdata){
							echo json_encode(array('status' => 'success', ));
						}
					}
				}
			}

		}else{
			echo json_encode(array('status' => 'failed', ));
		}

	}

	function rmvusrtocht(){
		$msgtoken = $this->encrypt->decode($this->input->post('token',TRUE));
		$wheredata = $this->db->where('mg.token = "'.$msgtoken.'" AND	acs.verified = "1" AND af.stat = "1" GROUP BY acs.userid ORDER BY af.func_order ASC, ar.rgnid ASC, acs.fname ASC');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = mg.creator_userid','left');
		$joindata = $this->db->join('acc_region AS ar','ar.rgnnum = acs.region');
		$joindata = $this->db->join('acc_function AS af','af.userid = mg.creator_userid','left');
		$selectdata = $this->Embismodel->selectdata('messenger_groups AS mg','acs.region,af.func,acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joindata,$wheredata);
		?>
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" id="rmvmsgtoken" value="<?php echo $this->input->post('token',TRUE); ?>">
				<label>Select user/s:</label>
				<select class="form-control" id="employeelisted_msg_selectize">
					<option value="">-</option>
					<?php for ($au=0; $au < sizeof($selectdata); $au++) {
						$mname = (!empty($selectdata[$au]['mname'])) ? $selectdata[$au]['mname'][0].'. ' : '';
						$suffix = (!empty($selectdata[$au]['suffix'])) ? ' '.$selectdata[$au]['suffix'] : '';
						$prefix = (!empty($selectdata[$au]['title'])) ? $selectdata[$au]['title'].' ' : '';
						$name = $prefix.ucwords($selectdata[$au]['fname'].' '.$mname.$selectdata[$au]['sname']).$suffix;
					?>
						<optgroup label="<?php echo $selectdata[$au]['func']; ?>">
							<?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
								<option value="<?php echo $this->encrypt->encode($selectdata[$au]['userid']); ?>"><?php echo $selectdata[$au]['region'].' - '.$name; ?></option>
							<?php }else{ ?>
								<option value="<?php echo $this->encrypt->encode($selectdata[$au]['userid']); ?>"><?php echo $name; ?></option>
							<?php } ?>
						</optgroup>
					<?php } ?>
				</select>
			</div>
		</div>
	<script type="text/javascript">
			$('#employeelisted_msg_selectize').selectize({
					maxItems: null
			});
	</script>
		<?php
	}

	function rmvusertochat(){
		if(count($_POST['usertoken']) > 0){
			for ($i=0; $i < count($_POST['usertoken']); $i++) {
				if(!empty($this->encrypt->decode($_POST['usertoken'][$i]))){
					$setdata = array('ifremoved' => 'yes', );
					$wheredata  = array(
													'token' => $this->encrypt->decode($_POST['msgtoken']),
													'creator_userid'  => $this->encrypt->decode($_POST['usertoken'][$i]),
												);
					$deletedata = $this->Embismodel->updatedata($setdata,'messenger_groups',$wheredata);
					if($deletedata){
						echo json_encode(array('status' => 'success', ));
					}
				}
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}

	}
}
