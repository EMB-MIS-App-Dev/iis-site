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
    $this->load->helper('url');
    $this->load->library('Pdf');
		date_default_timezone_set("Asia/Manila");
	}

  function schedule_details(){
    $cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'"');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = sl.creator','left');
		$querydata = $this->Embismodel->selectdata('schedule_list AS sl','sl.*, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$wheredata);

		$ctitle = (!empty($querydata[0]['title'])) ? $querydata[0]['title'].' ' : '';
		$cmname = (!empty($querydata[0]['mname'])) ? $querydata[0]['mname'][0].'. ' : '';
		$csuffix = (!empty($querydata[0]['suffix'])) ? ' '.$querydata[0]['suffix'] : '';
		$cname = $ctitle.$querydata[0]['fname'].' '.$cmname.$querydata[0]['sname'].$csuffix;

		$explodedata = explode('|', $querydata[0]['participants']);
		?>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label>Subject</label>
						<input type="text" class="form-control" value="<?php echo $querydata[0]['subject']; ?>" readonly>
					</div>
					<div class="col-md-6">
						<label>Location</label>
						<input type="text" class="form-control" value="<?php echo $querydata[0]['location']; ?>" readonly>
					</div>
					<div class="col-md-3">
						<label>Date Schedule</label>
						<input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($querydata[0]['date_schedule'])); ?>" readonly>
					</div>
					<div class="col-md-3">
						<label>Time Schedule</label>
						<input type="text" class="form-control" value="<?php echo date('h:i a', strtotime($querydata[0]['time_schedule'])); ?>" readonly>
					</div>
					<div class="col-md-12">
						<label>Schedule Host</label>
						<input type="text" class="form-control" value="<?php echo $cname; ?>" readonly>
					</div>
					<div class="col-md-12">
						<label style="margin:0px;">Participants</label>
					</div>
					<div class="col-md-12" style="overflow-y: scroll;padding: 0px;max-height: 500px !important;">
						<div class="row" style="margin:0px;">
							<?php
								if(!empty($cnt)){
									$counter = 0;
									$wheredatausers = '';
									for ($i=0; $i < count($explodedata); $i++) {
										if(!empty($explodedata[$i])){
											$counter++;
											$conand = ($counter == '1') ? " AND ": "";
											$con = ($counter == count($explodedata)) ? '': ' OR ';
											$wheredatausers .= $conand.'`acs`.`userid` = "'.$explodedata[$i].'"'.$con;
										}
									}
										$whereparticipants  = $this->db->where('acs.verified = "1" AND af.stat = "1"'.$wheredatausers.' GROUP BY af.userid ORDER BY fname ASC');
										$joinparticipants   = $this->db->join('acc_function AS af','af.userid = acs.userid', 'left');
										$joinparticipants   = $this->db->join('acc_xdvsion AS an','an.divno = af.divno', 'left');
										$selectparticipants = $this->Embismodel->selectdata('acc_credentials AS acs','af.func, acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divcode','',$joinparticipants,$whereparticipants);

										for ($p=0; $p < sizeof($selectparticipants); $p++) {
											$title = (!empty($selectparticipants[$p]['title'])) ? $selectparticipants[$p]['title'].' ' : '';
											$mname = (!empty($selectparticipants[$p]['mname'])) ? $selectparticipants[$p]['mname'][0].'. ' : '';
											$suffix = (!empty($selectparticipants[$p]['suffix'])) ? ' '.$selectparticipants[$p]['suffix'] : '';
											$name = $title.$selectparticipants[$p]['fname'].' '.$mname.$selectparticipants[$p]['sname'].$suffix;

											$wherestat = $this->db->where('sl.cnt = "'.$cnt.'" AND sl.status = "Active"');
											$selectstat = $this->Embismodel->selectdata('schedule_list AS sl','sl.participated','',$wherestat);
											$explodeparticipated = explode('|',$selectstat[0]['participated']);
											$condition = FALSE;
											for ($pd=0; $pd < count($explodeparticipated); $pd++) {
												if(!empty($explodeparticipated[$pd]) AND $selectparticipants[$p]['userid'] == $explodeparticipated[$pd]){
													$condition = TRUE;
												}
											}

											$wheretimelogs = $this->db->where('slt.cnt = "'.$cnt.'" AND slt.userid = "'.$selectparticipants[$p]['userid'].'"');
											$selecttimelogs = $this->Embismodel->selectdata('schedule_list_timelogs AS slt','slt.userid, slt.time_in','',$wheretimelogs);

							?>

								<?php if($querydata[0]['date_schedule'] >  date('Y-m-d')){ //Upcoming schedules ?>
									<div class="col-md-12">
										<input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo $selectparticipants[$p]['func']; ?>" value="<?php echo $name; ?>" readonly>
									</div>
								<?php }else{ //Today or past schedules ?>
									 <?php if($querydata[0]['creator'] == $this->session->userdata('userid')){ //if Schedule host ?>
											<?php if($condition){ //if present ?>
												<div class="col-md-12" style="display:flex;">
					 								<span class="dot" title="Attended" style="height: 20px;width: 22px;background-color: #1CC88A;border-radius: 50%;margin: 11px 10px 11px 10px;"></span>
					 								<input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo "Time-in: ".date('h:ia', strtotime($selecttimelogs[0]['time_in'])); ?>" value="<?php echo $name; ?>" readonly>
					 							</div>
											<?php }else{ ?>
												<?php if($querydata[0]['date_schedule'] == date('Y-m-d') AND $querydata[0]['sched_status'] == 'success'){ //Mark as present button ?>
													<div class="col-md-10">
														 <input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo $selectparticipants[$p]['func']; ?>" value="<?php echo $name; ?>" readonly>
													 </div>
													 <div class="col-md-2" style="padding-left:0px;">
														 <button type="button" class="btn btn-success btn-sm" onclick="chkparticipants('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>','<?php echo $this->encrypt->encode($selectparticipants[$p]['userid']); ?>');" style="width:100%;height: 90%;margin-top:5px;">Mark as Present</button>
													 </div>
												<?php }else{ //not present ?>
													<div class="col-md-12" style="display:flex;">
						 								<span class="dot" title="Not Available" style="height: 20px;width: 22px;background-color: #E74A3B;border-radius: 50%;margin: 11px 10px 11px 10px;"></span>
						 								<input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo $selectparticipants[$p]['func']; ?>" value="<?php echo $name; ?>" readonly>
						 							</div>
												<?php } ?>
											<?php } ?>
					 				 <?php }else{ //not schedule host ?>
										 <?php if($condition){ //if present ?>
											<div class="col-md-12" style="display:flex;">
												<span class="dot" title="Attended" style="height: 20px;width: 22px;background-color: #1CC88A;border-radius: 50%;margin: 11px 10px 11px 10px;"></span>
												<input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo "Time-in: ".date('h:ia', strtotime($selecttimelogs[0]['time_in'])); ?>" value="<?php echo $name; ?>" readonly>
											</div>
										 <?php }else{ //not present ?>
												<div class="col-md-12" style="display:flex;">
													<span class="dot" title="Not Available" style="height: 20px;width: 22px;background-color: #E74A3B;border-radius: 50%;margin: 11px 10px 11px 10px;"></span>
													<input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo $selectparticipants[$p]['func']; ?>" value="<?php echo $name; ?>" readonly>
												</div>
										 <?php } ?>
					 				 <?php } ?>
								<?php } ?>
							<?php } }  ?>
							<?php if($querydata[0]['sched_status'] == 'postponed'){ ?>
								<div class="col-md-12"><hr>
									<label>The Schedule Host marked this schedule as postponed:</label>
									<textarea class="form-control" rows="8" cols="80" disabled><?php echo $querydata[0]['remarks']; ?></textarea>
								</div>
							<?php } ?>
							<?php if($querydata[0]['sched_status'] == 'done'){ ?>
								<?php
									if(!empty($cnt)){
										$countera = 0;
										$wheredatausersa = '';
										$explodedataa = explode('|', $querydata[0]['accountable']);
										for ($i=0; $i < count($explodedataa); $i++) {
											if(!empty($explodedataa[$i])){
												$countera++;
												$conanda = ($countera == '1') ? " AND ": "";
												$cona = ($countera == count($explodedataa)) ? '': ' OR ';
												$wheredatausersa .= $conanda.'`acs`.`userid` = "'.$explodedataa[$i].'"'.$cona;
											}
										}
										$whereparticipantsa  = $this->db->where('acs.verified = "1" AND af.stat = "1"'.$wheredatausersa.' GROUP BY af.userid ORDER BY fname ASC');
										$joinparticipantsa   = $this->db->join('acc_function AS af','af.userid = acs.userid', 'left');
										$joinparticipantsa   = $this->db->join('acc_xdvsion AS an','an.divno = af.divno', 'left');
										$selectparticipantsa = $this->Embismodel->selectdata('acc_credentials AS acs','af.func, acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divcode','',$joinparticipantsa,$whereparticipantsa);
									}
							  ?>
								<?php if($countera > 0){ ?>
								<div class="col-md-12"><hr>
									<label>Accountable Personnel:</label>
									<?php for ($p=0; $p < sizeof($selectparticipantsa); $p++) {
										$titlea = (!empty($selectparticipantsa[$p]['title'])) ? $selectparticipantsa[$p]['title'].' ' : '';
										$mnamea = (!empty($selectparticipantsa[$p]['mname'])) ? $selectparticipantsa[$p]['mname'][0].'. ' : '';
										$suffixa = (!empty($selectparticipantsa[$p]['suffix'])) ? ' '.$selectparticipantsa[$p]['suffix'] : '';
										$namea = $titlea.$selectparticipantsa[$p]['fname'].' '.$mnamea.$selectparticipantsa[$p]['sname'].$suffixa;
									?>
									<input type="text" class="form-control" style="margin-top: 5px;" title="<?php echo $selectparticipantsa[$p]['func']; ?>" value="<?php echo $namea; ?>" readonly>
									<?php } ?>
								</div>
								<?php } ?>
								<div class="col-md-12">
									<label>Schedule Agreements / Meeting Minutes:</label>
									<textarea class="form-control" rows="8" cols="80" disabled><?php echo $querydata[0]['remarks']; ?></textarea>
								</div>
							<?php } ?>
						</div>
					</div>
					</div>
			 </div>
			 <?php if($querydata[0]['creator'] == $this->session->userdata('userid') OR $_SESSION['superadmin_rights'] == 'yes'){ ?>
				 <div class="modal-footer" style="display:block !important;">
					 <?php if($querydata[0]['sched_status'] != 'postponed' AND $querydata[0]['sched_status'] != 'done' AND $querydata[0]['date_schedule'] ==  date('Y-m-d') AND $querydata[0]['creator'] == $this->session->userdata('userid')){ ?>
					 <button type="button" class="btn btn-danger btn-sm" style="float:right;" onclick="schedstat('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>');">Postpone Schedule</button>
					 <?php } ?>
					 <?php if(empty($querydata[0]['sched_status']) AND $querydata[0]['date_schedule'] ==  date('Y-m-d')){ ?>
					 <button type="button" class="btn btn-success btn-sm" style="float:right;"  onclick="startsched('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>');">Start Activity</button>
			 		 <?php } ?>
					 <?php if($querydata[0]['sched_status'] == 'success'){ ?>
					 <button type="button" class="btn btn-success btn-sm" style="float:right;" onclick="agreementsorminutes('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>');">Add Schedule Agreements / Meeting Minutes</button>
			 		 <?php } ?>
					 <?php if($_SESSION['superadmin_rights'] == 'yes' OR $querydata[0]['creator'] == $this->session->userdata('userid')){ ?>
					 <button type="button" class="btn btn-info btn-sm" style="margin:0px;" onclick="duplicatesched('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>');">Duplicate Schedule</button>
					 <button type="button" class="btn btn-warning btn-sm" style="margin:0px;" onclick="editsched('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>');">Edit Schedule</button>
					 <?php } ?>
					 <?php if($_SESSION['superadmin_rights'] == 'yes' AND $querydata[0]['status'] == 'Active'){ ?>
					 <button type="button" class="btn btn-danger btn-sm" style="margin:0px;" onclick="removesched('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>');">Remove Schedule</button>
			 		 <?php } ?>
				 </div>
			<?php } ?>
		<?php
  }

	function sched_status(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'" AND status = "Active"');
		$selectdata = $this->Embismodel->selectdata('schedule_list AS sl','sl.sched_status, sl.date_schedule','',$wheredata);
		if($selectdata[0]['sched_status'] == 'success' AND $selectdata[0]['date_schedule'] ==  date('Y-m-d')){
			$status = 'In-progress'; $color = "#1CC88A";
		}
		if($selectdata[0]['sched_status'] == 'done' AND $selectdata[0]['date_schedule'] !=  date('Y-m-d')){
			$status = 'Completed'; $color = "#1CC88A";
		}
		if($selectdata[0]['sched_status'] == 'postponed'){
			$status = 'Postponed'; $color = "#E74A3B";
		}

		if(($selectdata[0]['sched_status'] == '') AND $selectdata[0]['date_schedule'] <  date('Y-m-d')){
			$status = 'Cancelled'; $color = "#E74A3B";
		}
		?>
			<div style="height: 20px;width: 22px;background-color: <?php echo $color; ?>;border-radius: 50%;"></div><span>&nbsp;<?php echo $status; ?></span>
		<?php
	}

	function chkparticipants(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$userid = $this->encrypt->decode($this->input->post('id', TRUE));

		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'" AND status = "Active"');
		$selectdata = $this->Embismodel->selectdata('schedule_list AS sl','sl.participated','',$wheredata);

		$addparticipants = (!empty($selectdata[0]['participated'])) ? $selectdata[0]['participated']: '';

		$con = (!empty($selectdata[0]['participated'])) ? $addparticipants.'|': '';

		$datalog = array('cnt' => $cnt, 'userid' => $userid, 'time_in' => date("Y-m-d h:ia"), );
		$insertdata = $this->Embismodel->insertdata('schedule_list_timelogs', $datalog);

		$setdata = array('participated' => $con.$userid, );
		$wheredata = array('cnt' => $cnt, );
		$updatedata = $this->Embismodel->updatedata($setdata,'schedule_list',$wheredata);

		if($updatedata){
			echo json_encode(array('status' => 'success', 'token' => $this->input->post('token', TRUE),));
		}
	}

	function schedstat(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'"');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = sl.creator','left');
		$querydata = $this->Embismodel->selectdata('schedule_list AS sl','sl.*, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$joindata,$wheredata);
		?>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label>Subject</label>
						<input type="text" class="form-control" value="<?php echo $querydata[0]['subject']; ?>" readonly>
					</div>
					<div class="col-md-6">
						<label>Location</label>
						<input type="text" class="form-control" value="<?php echo $querydata[0]['location']; ?>" readonly>
					</div>
					<div class="col-md-6">
						<label>Date Schedule</label>
						<input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($querydata[0]['date_schedule'])); ?>" readonly>
					</div>
					<div class="col-md-12">
						<label>* Please provide postponement reason below:</label>
						<textarea rows="8" cols="80" class="form-control" id="postponementreason"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" onclick="schedule_details('<?php echo $this->input->post('token', TRUE); ?>');">Cancel</button>
				<button type="button" class="btn btn-success btn-sm" onclick="postponesched('<?php echo $this->input->post('token', TRUE); ?>',$('#postponementreason').val());">Done</button>
			</div>
		<?php
	}

	function postponesched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$postponementreason = $this->input->post('reason', TRUE);

		if(!empty($postponementreason) AND !empty($cnt)){
			$setdata = array('sched_status' => 'postponed', 'remarks' => $postponementreason, );
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'schedule_list', $wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}
		}
	}

	function startsched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		if(!empty($cnt)){
			$setdata = array('sched_status' => 'success', 'remarks' => '', );
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'schedule_list', $wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success', 'token' => $this->input->post('token', TRUE), ));
			}
		}
	}

	function agreementsorminutes(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'"');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = sl.creator','left');
		$querydata = $this->Embismodel->selectdata('schedule_list AS sl','sl.*, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$joindata,$wheredata);

		$explodedata = explode('|', $querydata[0]['participants']);
		$counter = 0;
		$wheredatausers = '';
		for ($i=0; $i < count($explodedata); $i++) {
			if(!empty($explodedata[$i])){
				$counter++;
				$conand = ($counter == '1') ? " AND ": "";
				$con = ($counter == count($explodedata)) ? '': ' OR ';
				$wheredatausers .= $conand.'`acs`.`userid` = "'.$explodedata[$i].'"'.$con;
			}
		}
			$whereparticipants  = $this->db->where('acs.verified = "1" AND af.stat = "1"'.$wheredatausers.' GROUP BY af.userid ORDER BY fname ASC');
			$joinparticipants   = $this->db->join('acc_function AS af','af.userid = acs.userid', 'left');
			$joinparticipants   = $this->db->join('acc_xdvsion AS an','an.divno = af.divno', 'left');
			$selectparticipants = $this->Embismodel->selectdata('acc_credentials AS acs','af.func, acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divcode','',$joinparticipants,$whereparticipants);

		?>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label>Subject</label>
						<input type="text" class="form-control" value="<?php echo $querydata[0]['subject']; ?>" readonly>
					</div>
					<div class="col-md-6">
						<label>Location</label>
						<input type="text" class="form-control" value="<?php echo $querydata[0]['location']; ?>" readonly>
					</div>
					<div class="col-md-6">
						<label>Date Schedule</label>
						<input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($querydata[0]['date_schedule'])); ?>" readonly>
					</div>
					<div class="col-md-12">
						<label>Accountable Personnel:</label>
						<select class="form-control" id="accountable_selectize">
							<option value="">-</option>
							<?php for ($p=0; $p < sizeof($selectparticipants); $p++) {
								$title = (!empty($selectparticipants[$p]['title'])) ? $selectparticipants[$p]['title'].' ' : '';
								$mname = (!empty($selectparticipants[$p]['mname'])) ? $selectparticipants[$p]['mname'][0].'. ' : '';
								$suffix = (!empty($selectparticipants[$p]['suffix'])) ? ' '.$selectparticipants[$p]['suffix'] : '';
								$name = $title.$selectparticipants[$p]['fname'].' '.$mname.$selectparticipants[$p]['sname'].$suffix;
							?>
								<option value="<?php echo $this->encrypt->encode($selectparticipants[$p]['userid']); ?>"><?php echo $name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-12">
						<label>* Please provide schedule agreements / meeting minutes:</label>
						<textarea rows="8" cols="80" class="form-control" id="details"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" onclick="schedule_details('<?php echo $this->input->post('token', TRUE); ?>');">Cancel</button>
				<button type="button" class="btn btn-success btn-sm" onclick="addagreementsorminutes('<?php echo $this->input->post('token', TRUE); ?>',$('#accountable_selectize').val(),$('#details').val());">Done</button>
			</div>
			<script type="text/javascript">
				$('#accountable_selectize').selectize({
					maxItems: null
				});
			</script>
		<?php
	}

	function addagreementsorminutes(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$details = $this->input->post('details', TRUE);
		if(!empty($cnt) AND !empty($details)){
			$accountable = "";
			$counter = 0;
			for ($i=0; $i < count($_POST['accountable']); $i++) {
				if(!empty($_POST['accountable'][$i])){
					$counter++;
					$con = ($counter == '1') ? "": "|";
					$accountable .= $con.$this->encrypt->decode($_POST['accountable'][$i]);
				}
			}

			$setdata = array('sched_status' => 'done', 'remarks' => $details, 'accountable' => $accountable, );
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'schedule_list', $wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}
		}
	}

	function viewparticipants(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		if($token == 'national'){ ?>
			<button type='button' class='btn btn-info btn-sm' onclick='viewparticipants("<?php echo $this->encrypt->encode('regional'); ?>"); viewparticipantsselectize("<?php echo $this->encrypt->encode('regional'); ?>");' >Switch to Regional View of Personnel</button>
		<?php }
		if($token == 'regional'){ ?>
			<button type='button' class='btn btn-info btn-sm' onclick='viewparticipants("<?php echo $this->encrypt->encode('national'); ?>"); viewparticipantsselectize("<?php echo $this->encrypt->encode('national'); ?>");'>Switch to National View of Personnel</button>
		<?php }
	}

	function viewparticipantss(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		if($token == 'national'){ ?>
			<button type='button' class='btn btn-info btn-sm' onclick='viewparticipantss("<?php echo $this->encrypt->encode('regional'); ?>"); viewparticipantsselectizee("<?php echo $this->encrypt->encode('regional'); ?>");' >Switch to Regional View of Personnel</button>
		<?php }
		if($token == 'regional'){ ?>
			<button type='button' class='btn btn-info btn-sm' onclick='viewparticipantss("<?php echo $this->encrypt->encode('national'); ?>"); viewparticipantsselectizee("<?php echo $this->encrypt->encode('national'); ?>");'>Switch to National View of Personnel</button>
		<?php }
	}

	function viewparticipantsselectize(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$order_byaccounts	= $this->db->order_by('acs.region ASC, an.divname ASC, at.sect ASC, af.func_order, acs.fname ASC');
		if($token == 'regional'){
			$whereuseraccounts = $this->db->where('acs.region', $this->session->userdata('region'));
		}
		$whereuseraccounts = $this->db->where('acs.office', $this->session->userdata('office'));
		$whereuseraccounts = $this->db->where('acs.designation !=', 'Administrator');
		$whereuseraccounts = $this->db->where('acs.verified', '1');
		$whereuseraccounts = $this->db->where('af.stat', '1');
    $whereuseraccounts = $this->db->where('acs.userid !=', $this->session->userdata('userid'));
		$joinuseraccounts  = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
		$joinuseraccounts  = $this->db->join('embis.acc_function AS af', 'af.userid = acs.userid', 'left');
    $joinuseraccounts  = $this->db->join('embis.acc_xdvsion AS an', 'an.divno = af.divno', 'left');
    $joinuseraccounts  = $this->db->join('embis.acc_xsect AS at', 'at.secno = af.secno', 'left');
		$useraccounts      = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.region, acs.userid,  acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divname, at.sect','',$whereuseraccounts,$joinuseraccounts,$order_byaccounts);
		?>
		<select id="participants_selectizee" class="form-control" name="participants[]" required>
			<option value="">-</option>
			<?php for ($a=0; $a < sizeof($useraccounts); $a++) {
				$title = (!empty($useraccounts[$a]['title'])) ? $useraccounts[$a]['title'].' ': '';
				$mname = (!empty($useraccounts[$a]['mname'])) ? $useraccounts[$a]['mname'][0].'. ': '';
				$suffix = (!empty($useraccounts[$a]['suffix'])) ? ' '.$useraccounts[$a]['suffix']: '';
				$name = $title.$useraccounts[$a]['fname'].' '.$mname.$useraccounts[$a]['sname'].$suffix;
				$section = (!empty($useraccounts[$a]['sect'])) ? ' ('.$useraccounts[$a]['sect'].')': '';
				if($token == 'regional'){
					$regionname = '';
				}else{
					$regionname = $useraccounts[$a]['region'].' - ';
				}
			?>
				<optgroup label="<?php echo $regionname.$useraccounts[$a]['divname'].$section; ?>">
					<option value="<?php echo $this->encrypt->encode($useraccounts[$a]['userid']); ?>"><?php echo $name; ?></option>
				</optgroup>
			<?php } ?>
		</select>
		<script type="text/javascript">
		  $('#participants_selectizee').selectize({
		      maxItems: null
		  });
		</script>
		<?php
	}

	function removesched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		if(!empty($cnt)){
			$setdata = array('status' => 'Removed', );
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'schedule_list', $wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}
		}
	}

	function duplicatesched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'"');
		$querydata = $this->Embismodel->selectdata('schedule_list AS sl','','',$wheredata);
		?>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<label>Subject</label>
					<input type="text" class="form-control" value="<?php echo $querydata[0]['subject']; ?>" readonly>
				</div>
				<div class="col-md-6">
					<label>Location</label>
					<input type="text" class="form-control" value="<?php echo $querydata[0]['location']; ?>" readonly>
				</div>
				<div class="col-md-3">
					<label>Date Schedule</label>
					<input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($querydata[0]['date_schedule'])); ?>" readonly>
				</div>
				<div class="col-md-3">
					<label>Time Schedule</label>
					<input type="text" class="form-control" value="<?php echo date('h:i a', strtotime($querydata[0]['time_schedule'])); ?>" readonly>
				</div>
				<div class="col-md-12" style="text-align: center;">
					<label>*Same participants will be added to this new schedule*</label>
				</div>
				<div class="col-md-12"><hr>
					<label>Please select date range and time for new schedule:</label>
				</div>
				<div class="col-md-6">
					<input type="date" id="startdate" onchange="rmvdisablesched('<?php echo $querydata[0]['date_schedule']; ?>');" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="date" id="enddate" onchange="verifydatesched();" class="form-control" disabled>
				</div>
				<div class="col-md-12">
					<label>Time</label>
					<input type="time" id="timesched" class="form-control">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm" onclick="schedule_details('<?php echo $this->input->post('token', TRUE); ?>');">Cancel</button>
			<button type="button" class="btn btn-success btn-sm" onclick="addnewsched('<?php echo $this->input->post('token', TRUE); ?>',$('#startdate').val(),$('#enddate').val(),$('#timesched').val());">Proceed</button>
		</div>
		<?php
	}

	function editsched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'"');
		$querydata = $this->Embismodel->selectdata('schedule_list AS sl','','',$wheredata);
		$explodedata = explode('|', $querydata[0]['participants']);
		?>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<label>Subject</label>
					<input type="text" class="form-control" id="subject" value="<?php echo $querydata[0]['subject']; ?>">
				</div>
				<div class="col-md-6">
					<label>Location</label>
					<input type="text" class="form-control" id="location" value="<?php echo $querydata[0]['location']; ?>">
				</div>
				<div class="col-md-3">
					<label>Date Schedule</label>
					<input type="date" class="form-control" id="date_schedule" value="<?php echo date('Y-m-d', strtotime($querydata[0]['date_schedule'])); ?>">
				</div>
				<div class="col-md-3">
					<label>Time Schedule</label>
					<input type="time" class="form-control" id="time_schedule" value="<?php echo $querydata[0]['time_schedule']; ?>">
				</div>
				<div class="col-md-12">
					<label style="margin:0px;">Participants</label>
				</div>
				<div class="col-md-12" style="overflow-y: scroll;padding: 0px;max-height: 500px !important;">
					<div class="row" style="margin:0px;">
						<?php
								$counter = 0;
								$wheredatausers = '';
								for ($i=0; $i < count($explodedata); $i++) {
									if(!empty($explodedata[$i])){
										$counter++;
										$conand = ($counter == '1') ? " AND ": "";
										$con = ($counter == count($explodedata)) ? '': ' OR ';
										$wheredatausers .= $conand.'`acs`.`userid` = "'.$explodedata[$i].'"'.$con;
									}
								}
									$whereparticipants  = $this->db->where('acs.verified = "1" AND af.stat = "1"'.$wheredatausers.' GROUP BY af.userid ORDER BY fname ASC');
									$joinparticipants   = $this->db->join('acc_function AS af','af.userid = acs.userid', 'left');
									$joinparticipants   = $this->db->join('acc_xdvsion AS an','an.divno = af.divno', 'left');
									$selectparticipants = $this->Embismodel->selectdata('acc_credentials AS acs','af.func, acs.userid, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divcode','',$joinparticipants,$whereparticipants);

									for ($p=0; $p < sizeof($selectparticipants); $p++) {
										$title = (!empty($selectparticipants[$p]['title'])) ? $selectparticipants[$p]['title'].' ' : '';
										$mname = (!empty($selectparticipants[$p]['mname'])) ? $selectparticipants[$p]['mname'][0].'. ' : '';
										$suffix = (!empty($selectparticipants[$p]['suffix'])) ? ' '.$selectparticipants[$p]['suffix'] : '';
										$name = $title.$selectparticipants[$p]['fname'].' '.$mname.$selectparticipants[$p]['sname'].$suffix;
						?>

						<?php
						  $explodedataparticipated = explode('|', $querydata[0]['participated']);
							$chkcounter = 0;
							for ($cp=0; $cp < count($explodedataparticipated); $cp++) {
								if($selectparticipants[$p]['userid'] == $explodedataparticipated[$cp]){
									 $chkcounter++;
								}
							}
						?>
						<?php if($chkcounter == 0){ ?>
						<div class="col-md-8" style="margin-bottom:5px;">
							<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-success btn-sm" onclick="chkparticipantsedit('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>','<?php echo $this->encrypt->encode($selectparticipants[$p]['userid']); ?>');" style="width:100%;height: 90%;margin-bottom:5px;">Mark as Present</button>
						</div>
					<?php }else{ ?>
						<div class="col-md-10" style="margin-bottom:5px;">
							<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
						</div>
					<?php } ?>
						<div class="col-md-2" style="padding-left:0px;margin-bottom:5px;">
							<button type="button" class="btn btn-danger btn-sm" style="width:100%;height: 100%;" onclick="removepartcipant('<?php echo $this->encrypt->encode($querydata[0]['cnt']); ?>','<?php echo $this->encrypt->encode($selectparticipants[$p]['userid']); ?>');">Remove</button>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-12"><hr>
					<label>Add more participants</label>
					<div id="participantsview_" style="float: right;margin-top: 2px;">
						<button type="button" class="btn btn-info btn-sm" onclick="viewparticipantss('<?php echo $this->encrypt->encode('national'); ?>'); viewparticipantsselectizee('<?php echo $this->encrypt->encode('national'); ?>');">Switch to National View of Personnel</button>
					</div>
					<div id="participantsviewselectizee_">
						<select class="form-control" id="addmoreparticipants_selectize">
							<option value="">-</option>
							<?php
							$order_byaccounts	 = $this->db->order_by('an.divname ASC, at.sect ASC, acs.fname ASC');
							$whereuseraccounts = $this->db->where('acs.region', $this->session->userdata('region'));
							$whereuseraccounts = $this->db->where('acs.office', $this->session->userdata('office'));
							$whereuseraccounts = $this->db->where('acs.designation !=', 'Administrator');
							$whereuseraccounts = $this->db->where('acs.verified', '1');
							$whereuseraccounts = $this->db->where('acs.userid !=', $this->session->userdata('userid'));
							$joinuseraccounts  = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
							$joinuseraccounts  = $this->db->join('embis.acc_xdvsion AS an', 'an.divno = acs.divno', 'left');
							$joinuseraccounts  = $this->db->join('embis.acc_xsect AS at', 'at.secno = acs.secno', 'left');
							$useraccounts = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.userid,  acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divname, at.sect','',$whereuseraccounts,$joinuseraccounts,$order_byaccounts);
								for ($a=0; $a < sizeof($useraccounts); $a++) {
									$title = (!empty($useraccounts[$a]['title'])) ? $useraccounts[$a]['title'].' ': '';
									$mname = (!empty($useraccounts[$a]['mname'])) ? $useraccounts[$a]['mname'][0].'. ': '';
									$suffix = (!empty($useraccounts[$a]['suffix'])) ? ' '.$useraccounts[$a]['suffix']: '';
									$name = $title.$useraccounts[$a]['fname'].' '.$mname.$useraccounts[$a]['sname'].$suffix;
									$section = (!empty($useraccounts[$a]['sect'])) ? ' ('.$useraccounts[$a]['sect'].')': '';
								?>
									<optgroup label="<?php echo $useraccounts[$a]['divname'].$section; ?>">
										<option value="<?php echo $this->encrypt->encode($useraccounts[$a]['userid']); ?>"><?php echo $name; ?></option>
									</optgroup>
								<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm" onclick="schedule_details('<?php echo $this->input->post('token', TRUE); ?>');">Cancel</button>
			<button type="button" class="btn btn-success btn-sm" onclick="saveeditedsched('<?php echo $this->input->post('token', TRUE); ?>',$('#addmoreparticipants_selectize').val(),$('#subject').val(),$('#location').val(),$('#date_schedule').val(),$('#time_schedule').val());">Save</button>
		</div>
		<script type="text/javascript">
			$('#addmoreparticipants_selectize').selectize({
		      maxItems: null
		  });
		</script>
		<?php
	}

	function addnewsched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$startdate = $this->input->post('startdate', TRUE);
		$enddate = $this->input->post('enddate', TRUE);
		$timesched = $this->input->post('timesched', TRUE);

		if(!empty($cnt) AND !empty($startdate) AND !empty($startdate) AND !empty($timesched)){
			$wheredata = $this->db->where('sl.cnt = "'.$cnt.'"');
			$querydata = $this->Embismodel->selectdata('schedule_list AS sl','','',$wheredata);

			$rangeweek = $this->rangeWeek($querydata[0]['date_schedule']);

			$firstdayofweek = date('Y-m-d', strtotime($rangeweek['start']));
			$lastdayofweek = date('Y-m-d', strtotime($rangeweek['end']));

			$getinputteddaterange = $this->getinputteddaterange($startdate,$enddate);
			// echo "<pre>";
			// print_r($getinputteddaterange);
			$counter = 0;
			for($i=0; $i < count($getinputteddaterange); $i++) {
				$datesfrominput = date('Y-m-d', strtotime($getinputteddaterange[$i]));
				if(($datesfrominput >= $firstdayofweek) AND ($datesfrominput <= $lastdayofweek)){ // check if dates are in week range

				}else{
					$counter++;
				}

			}

			if($counter == 0){
				for ($a=0; $a < count($getinputteddaterange); $a++) {
					$dateschedule = date('Y-m-d', strtotime($querydata[0]['date_schedule']));
					$newdateschedule = date('Y-m-d', strtotime($getinputteddaterange[$a]));

					if($dateschedule != $newdateschedule){

						$wherechkduplicate = $this->db->where('sl.subject = "'.$querydata[0]['subject'].'" AND sl.location = "'.$querydata[0]['location'].'" AND sl.date_schedule = "'.$getinputteddaterange[$a].'"');
						$chkduplicate = $this->Embismodel->selectdata('schedule_list AS sl','sl.cnt','',$wherechkduplicate);

						if(empty($chkduplicate[0]['cnt'])){
							$data = array(
													  'subject'       => $querydata[0]['subject'],
														'location'      => $querydata[0]['location'],
														'date_schedule' => $getinputteddaterange[$a],
														'time_schedule' => $timesched,
														'creator'       => $querydata[0]['creator'],
														'participants'  => $querydata[0]['participants'],
														'sched_status'  => '',
														'status'        => 'Active',
														'region'        => $querydata[0]['region'],
														'has_dup'       => $cnt,
													 );
							$insertdata = $this->Embismodel->insertdata('schedule_list', $data);
						}
					}
				}
				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}

	}

	function removepartcipant(){
		$userid = $this->encrypt->decode($this->input->post('token', TRUE));
		$cnt = $this->encrypt->decode($this->input->post('cnt', TRUE));

		$wheredata = $this->db->where('sl.cnt = "'.$cnt.'" AND sl.status = "Active"');
		$querydata = $this->Embismodel->selectdata('schedule_list AS sl','sl.participants','',$wheredata);

		$explodedata = explode('|',$querydata[0]['participants']);
		$participants = "";
		$counter = 0;
		for ($i=0; $i < count($explodedata); $i++) {
			if($explodedata[$i] != $userid){
				$counter++;
				$con = ($counter == '1') ? '' : '|';
				$participants .= $con.$explodedata[$i];
			}
		}

		if(!empty($participants)){
			$setdata = array('participants' => $participants, );
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'schedule_list', $wheredata);

			echo json_encode(array('status' => 'success', ));
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function saveeditedsched(){
		$cnt = $this->encrypt->decode($this->input->post('token', TRUE));
		$subject = $this->input->post('subject', TRUE);
		$location = $this->input->post('location', TRUE);
		$date_schedule = $this->input->post('date_schedule', TRUE);
		$time_schedule = $this->input->post('time_schedule', TRUE);
		if(!empty($cnt) AND !empty($subject) AND !empty($location) AND !empty($date_schedule) AND !empty($time_schedule)){
			$setdata = array('subject' => $subject, 'location' => $location, 'date_schedule' => $date_schedule, 'time_schedule' => $time_schedule,);
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'schedule_list', $wheredata);

			$participants = '';
			if(count($_POST['moreparticipants']) > 0){
				$wheredata = $this->db->where('sl.cnt = "'.$cnt.'" AND sl.status = "Active"');
				$querydata = $this->Embismodel->selectdata('schedule_list AS sl','sl.participants','',$wheredata);

				for ($i=0; $i < count($_POST['moreparticipants']); $i++) {
					$participants .= '|'.$this->encrypt->decode($_POST['moreparticipants'][$i]);
				}

				$updatedparticipants = $querydata[0]['participants'].$participants;

				$setdatap = array('participants' => $updatedparticipants);
				$wheredatap = array('cnt' => $cnt, );
				$updatedatap = $this->Embismodel->updatedata($setdatap, 'schedule_list', $wheredatap);
			}
			echo json_encode(array('status' => 'success', ));
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function rangeWeek($datestr = '') {
	   $dt = strtotime ($datestr);
	   return array (
	     "start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('last monday', $dt)),
	     "end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
	   );
  }

	function getinputteddaterange($start, $end, $format = 'Y-m-d') {
	    $array = array();
	    $interval = new DateInterval('P1D');

	    $realEnd = new DateTime($end);
	    $realEnd->add($interval);

	    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	    foreach($period as $date) {
	        $array[] = $date->format($format);
	    }

	    return $array;
	}

}

?>
