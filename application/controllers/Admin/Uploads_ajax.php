<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Uploads_ajax extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

  function remove_esig_info(){
    $userid = $this->encrypt->decode($this->input->post('token'));

    $wherename  = $this->db->where('acs.userid',$userid);
    $selectname = $this->Embismodel->selectdata('acc_credentials AS acs','acs.*','',$wherename);
    $mname  = !empty($selectname[0]['mname']) ?  $selectname[0]['mname'][0].". " : "";
    $suffix = !empty($selectname[0]['suffix']) ?  " ".$selectname[0]['suffix'] : "";
    $name   = ucwords($selectname[0]['fname']." ".$mname.$selectname[0]['sname'].$suffix);
  ?>
  <form action="<?php echo base_url(); ?>Admin/Submissions/Filesuploads_postdata/remove_esignature" method="post">
    <div class="modal-body">
        <div class="col-md-12" style="text-align:center;color:#000;">
            <label>Are you sure to remove <u><b><?php echo $name; ?></b></u> e-Signature?</label>
            <input type="hidden" name="token" value="<?php echo $this->input->post('token'); ?>">
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-success btn-sm">Confirm</button>
    </div>
  </form>
  <?php
  }

	function edit_esig(){
		$userid = $this->encrypt->decode($this->input->post('token'));
		$wheredata = $this->db->where('af.stat = "1" AND oue.userid = "'.$userid.'" AND oue.status = "Active"');
		$joindata = $this->db->join('acc_function AS af','af.userid = oue.userid','left');
		$selectdata = $this->Embismodel->selectdata('office_uploads_esignature AS oue','oue.*,af.func',$joindata,$wheredata);

		$whereswevaluators = array('sf.assigned_to' => $userid, );
		$selectswevaluators = $this->Embismodel->selectdata('sweet_func AS sf','sf.assigned_to',$whereswevaluators);

		$whereswofficer = array('sfu.userid' => $userid, );
		$selectswofficer = $this->Embismodel->selectdata('sweet_func_user AS sfu','sfu.userid',$whereswofficer);

		?>
		<form id="uoptionsform" enctype="multipart/form-data">
		<div class="modal-body">
			<input type="hidden" name="token" value="<?php echo $this->input->post('token'); ?>">
			<div class="row">
				<div class="col-md-12">
						<label><b>TRAVEL ORDER (Authorization)</b></label>
				</div>
				<div class="col-md-6">
						<label>Height:</label>
						<input type="text" class="form-control" name="to_height_a" value="<?php echo $selectdata[0]['to_height_a']; ?>" <?php echo $disabled; ?>>
				</div>
				<div class="col-md-6">
						<label>Width:</label>
						<input type="text" class="form-control" name="to_width_a" value="<?php echo $selectdata[0]['to_width_a']; ?>" <?php echo $disabled; ?>>
				</div>
				<div class="col-md-6">
						<label>Y-Axis (top-bottom):</label>
						<input type="text" class="form-control" name="to_yaxis_a" value="<?php echo $selectdata[0]['to_yaxis_a']; ?>" <?php echo $disabled; ?>>
				</div>
				<div class="col-md-6">
						<label>X-Axis (left-right):</label>
						<input type="text" class="form-control" name="to_xaxis_a" value="<?php echo $selectdata[0]['to_xaxis_a']; ?>" <?php echo $disabled; ?>>
				</div>
				<div class="col-md-12">
					<hr>
				</div>
				<?php if(!empty($selectswevaluators[0]['assigned_to']) OR !empty($selectswofficer[0]['userid']) OR ($selectdata[0]['func'] == 'Director' OR $selectdata[0]['func'] == 'Regional Director' OR $selectdata[0]['func'] == 'Regional Executive Director')){ ?>
					<?php if($selectdata[0]['func'] == 'Director' OR $selectdata[0]['func'] == 'Regional Director' OR $selectdata[0]['func'] == 'Regional Executive Director'){ ?>
					<div class="col-md-12">
							<label><b>TRAVEL ORDER (National View)</b></label>
					</div>
					<div class="col-md-6">
							<label>Height:</label>
							<input type="text" class="form-control" name="to_height_n" value="<?php echo $selectdata[0]['to_height_n']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-6">
							<label>Width:</label>
							<input type="text" class="form-control" name="to_width_n" value="<?php echo $selectdata[0]['to_width_n']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-6">
							<label>Y-Axis (top-bottom):</label>
							<input type="text" class="form-control" name="to_yaxis_n" value="<?php echo $selectdata[0]['to_yaxis_n']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-6">
							<label>X-Axis (left-right):</label>
							<input type="text" class="form-control" name="to_xaxis_n" value="<?php echo $selectdata[0]['to_xaxis_n']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-12"><hr>
							<label><b>TRAVEL ORDER (Regional View)</b></label>
					</div>
					<div class="col-md-6">
							<label>Height:</label>
							<input type="text" class="form-control" name="to_height_r" value="<?php echo $selectdata[0]['to_height_r']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-6">
							<label>Width:</label>
							<input type="text" class="form-control" name="to_width_r" value="<?php echo $selectdata[0]['to_width_r']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-6">
							<label>Y-Axis (top-bottom):</label>
							<input type="text" class="form-control" name="to_yaxis_r" value="<?php echo $selectdata[0]['to_yaxis_r']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-6">
							<label>X-Axis (left-right):</label>
							<input type="text" class="form-control" name="to_xaxis_r" value="<?php echo $selectdata[0]['to_xaxis_r']; ?>" <?php echo $disabled; ?>>
					</div>
					<div class="col-md-12">
						<hr>
					</div>
					<?php } ?>

					<?php if(!empty($selectswevaluators[0]['assigned_to'])  OR !empty($selectswofficer[0]['userid'])){ ?>
					<div class="col-md-12">
							<label><b>SWEET REPORT</b></label>
					</div>
					<div class="col-md-6">
							<label>Height:</label>
							<input type="text" class="form-control" name="swm_height" value="<?php echo $selectdata[0]['swm_height']; ?>">
					</div>
					<div class="col-md-6">
							<label>Width:</label>
							<input type="text" class="form-control" name="swm_width" value="<?php echo $selectdata[0]['swm_width']; ?>">
					</div>
					<div class="col-md-6">
							<label>Y-Axis (top-bottom):</label>
							<input type="text" class="form-control" name="swm_yaxis" value="<?php echo $selectdata[0]['swm_yaxis']; ?>">
					</div>
					<div class="col-md-6">
							<label>X-Axis (left-right):</label>
							<input type="text" class="form-control" name="swm_xaxis" value="<?php echo $selectdata[0]['swm_xaxis']; ?>">
					</div>
					<?php } ?>
				<?php }else{ ?>
					<div class="col-md-12" style="text-align: center;">
							<label style="font-size: 15px;font-style:italic;">---------------------</label>
					</div>
				<?php } ?>
				<?php if($selectdata[0]['func'] == 'Regional Director'){ ?>
					<div class="col-md-12">
							<label><b>SWM NOV LETTER</b></label>
					</div>
					<div class="col-md-6">
							<label>Height:</label>
							<input type="text" class="form-control" name="swm_nov_height" value="<?php echo $selectdata[0]['swm_nov_height']; ?>">
					</div>
					<div class="col-md-6">
							<label>Width:</label>
							<input type="text" class="form-control" name="swm_nov_width" value="<?php echo $selectdata[0]['swm_nov_width']; ?>">
					</div>
					<div class="col-md-6">
							<label>Y-Axis (top-bottom):</label>
							<input type="text" class="form-control" name="swm_nov_yaxis" value="<?php echo $selectdata[0]['swm_nov_yaxis']; ?>">
					</div>
					<div class="col-md-6">
							<label>X-Axis (left-right):</label>
							<input type="text" class="form-control" name="swm_nov_xaxis" value="<?php echo $selectdata[0]['swm_nov_xaxis']; ?>">
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			<?php if(!empty($selectswevaluators[0]['assigned_to']) OR !empty($selectswofficer[0]['userid']) OR ($selectdata[0]['func'] == 'Director' OR $selectdata[0]['func'] == 'Regional Director' OR $selectdata[0]['func'] == 'Regional Executive Director')){ ?>
			<button type="button" class="btn btn-success btn-sm" onclick="usavedata();">Save</button>
			<?php } ?>
		</div>
		</form>
		<?php
	}

	function usavedata(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		if(!empty($token)){
			$setdata = array(
												'to_height_a' => $_POST['to_height_a'],
												'to_width_a' => $_POST['to_width_a'],
												'to_yaxis_a' => $_POST['to_yaxis_a'],
												'to_xaxis_a' => $_POST['to_xaxis_a'],
												'to_height_r' => $_POST['to_height_r'],
												'to_width_r' => $_POST['to_width_r'],
												'to_yaxis_r' => $_POST['to_yaxis_r'],
												'to_xaxis_r' => $_POST['to_xaxis_r'],
												'to_height_n' => $_POST['to_height_n'],
												'to_width_n' => $_POST['to_width_n'],
												'to_yaxis_n' => $_POST['to_yaxis_n'],
												'to_xaxis_n' => $_POST['to_xaxis_n'],
												'swm_height' => $_POST['swm_height'],
												'swm_width' => $_POST['swm_width'],
												'swm_yaxis' => $_POST['swm_yaxis'],
												'swm_xaxis' => $_POST['swm_xaxis'],
												'swm_nov_height' => $_POST['swm_nov_height'],
												'swm_nov_width' => $_POST['swm_nov_width'],
												'swm_nov_yaxis' => $_POST['swm_nov_yaxis'],
												'swm_nov_xaxis' => $_POST['swm_nov_xaxis'],
										  );
			 $wheredata = array('userid' => $token, 'status' => 'Active',);
			$updatedata = $this->Embismodel->updatedata($setdata,'office_uploads_esignature',$wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

}

?>
