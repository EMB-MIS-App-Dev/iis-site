<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Ajax_trans extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->model('Administrativemodel');
		$this->load->library('session');
	}

	function trmsusrsdm(){
		$region = $this->session->userdata('region');
		$where = $this->db->where('acs.verified = "1" AND af.stat = "1" AND af.stat = "1" AND acs.verified = "1" AND acs.region = "'.$region.'" AND acs.userid != "1" ORDER BY af.func_order ASC, acs.fname ASC');
		$employee_list_active = $this->Administrativemodel->select_employees($where);

	?>
		<div class="row">
			<div class="col-md-12" id="demppntr_"></div>
			<div class="col-md-12">
				<label>Select employee/s to change hierarchy of superiors&nbsp;<span style="color:red;">(single / multiple selection)</span>:</label>
				<select id="dtransuserselectize" class="form-control" name="employeeselected[]" onchange=trnorws('<?php echo $this->encrypt->encode('1'); ?>','');>
					<option value="">-</option>
					<?php for ($i=0; $i < sizeof($employee_list_active); $i++) {
						$mname = !empty($employee_list_active[$i]['mname']) ? $employee_list_active[$i]['mname'][0].". " : '';
						$suffix = !empty($employee_list_active[$i]['suffix']) ? " ".$employee_list_active[$i]['suffix'] : '';
						$prefix = !empty($employee_list_active[$i]['title']) ? $employee_list_active[$i]['title']." " : '';
						$name = $prefix.ucwords($employee_list_active[$i]['fname']." ".$mname." ".$employee_list_active[$i]['sname']).$suffix;
					?>
						<optgroup label="<?php echo $employee_list_active[$i]['func']; ?>">
							<option value="<?php echo $this->encrypt->encode($employee_list_active[$i]['userid']); ?>"><?php echo $name; ?></option>
						</optgroup>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12" id="trnorws_"></div>
		</div>
		<script type="text/javascript">$('#dtransuserselectize').selectize({	maxItems: null });</script>
	<?php }

	function trnorws(){
		$token = $this->encrypt->decode($this->input->post('token',TRUE));
		$nr = $this->encrypt->decode($this->input->post('nr',TRUE));
		if($token == '1'){ ?>
		<div class="col-md-12" style="padding:0px;">
			<label>Select number of rows:</label>
			<select class="form-control" id="trnrowsselectize" onchange="trnorws('<?php echo $this->encrypt->encode('2'); ?>',this.value);" required="">
				<option value="">-</option>
				<?php for ($i=1; $i < 10; $i++) { ?>
					<option value="<?php echo $this->encrypt->encode($i); ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</div>
		<script type="text/javascript">$('#trnrowsselectize').selectize();</script>
	<?php }if($token == '2'){
		$region = $this->session->userdata('region');
		$where = $this->db->where('(af.stat = "1" AND acs.verified = "1" AND acs.region = "'.$region.'") OR (af.func = "Director" OR af.func = "Assistant Director") ORDER BY af.func_order ASC, acs.fname ASC');
		$employee_list_active = $this->Administrativemodel->select_employees($where);
		if($region != 'CO'){ $var = '1'; }else{ $var = '1'; } //$var = '3'; }else{ $var = '2';
		$wheredirector = $this->db->where('acs.verified = "1" AND af.stat = "1" AND af.func = "Director"');
		$joindirector = $this->db->join('acc_function AS af','acs.userid = af.userid','left');
		$selectdirector = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joindirector,$wheredirector);
		if(!empty($selectdirector[0]['mname'])){ $mname = $selectdirector[0]['mname'][0].". "; }else{ $mname = ""; }
		if(!empty($selectdirector[0]['suffix'])){ $suffix = " ".$selectdirector[0]['suffix']; }else{ $suffix = ""; }
		if(!empty($selectdirector[0]['title'])){ $prefix = $selectdirector[0]['title']." "; }else{ $prefix = ""; }
		$directorname = $prefix.ucwords($selectdirector[0]['fname']." ".$mname.$selectdirector[0]['sname']).$suffix;

		$whereadirector = $this->db->where('acs.verified = "1" AND af.stat = "1" AND af.func = "Assistant Director"');
		$joinadirector = $this->db->join('acc_function AS af','acs.userid = af.userid','left');
		$selectadirector = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinadirector,$whereadirector);
		if(!empty($selectadirector[0]['mname'])){ $amname = $selectadirector[0]['mname'][0].". "; }else{ $amname = ""; }
		if(!empty($selectadirector[0]['suffix'])){ $asuffix = " ".$selectadirector[0]['suffix']; }else{ $asuffix = ""; }
		if(!empty($selectadirector[0]['title'])){ $aprefix = $selectadirector[0]['title']." "; }else{ $aprefix = ""; }
		$adname = $aprefix.ucwords($selectadirector[0]['fname']." ".$amname.$selectadirector[0]['sname']).$asuffix;

	?>
		<div class="row">
			<div class="col-md-10">
				<label>Hierarchy of Superiors</label><span style="float:right;color:#000;margin-top:6px;cursor:pointer;" class="fa fa-undo" onclick="trnorws('<?php echo $this->encrypt->encode('1'); ?>','');"></span>
			</div>
			<div class="col-md-2">
				<label>Hierarchy</label>
			</div>
			<!-- <div class="col-md-10">
				<select class="form-control" name="employee[]" readonly="" required>
					<option value="<?php echo $this->encrypt->encode($selectdirector[0]['userid']); ?>"><?php echo $directorname; ?></option>
				</select>
			</div>
			<div class="col-md-2">
				<input type="text" class="form-control" value="1" readonly="">
				<input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode('1'); ?>" required="" readonly="">
			</div>
			<?php if($region != 'CO'){ ?>
			<div class="col-md-10" style="margin-top:5px;">
				<select class="form-control" name="employee[]" readonly="" required>
					<option value="<?php echo $this->encrypt->encode($selectadirector[0]['userid']); ?>"><?php echo $adname; ?></option>
				</select>
			</div>
			<div class="col-md-2" style="margin-top:5px;">
				<input type="text" class="form-control" value="2" required="" readonly="">
				<input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode('2'); ?>" required="" readonly="">
			</div>
		<?php } ?> -->
			<?php for ($rws=$var; $rws < $nr+1; $rws++) { ?>
				<div class="col-md-10" style="margin-top:5px;">
					<select id="dthrchy<?php echo $rws; ?>" name="employee[]" class="form-control">
						<option value="">-</option>
						<?php for ($i=0; $i < sizeof($employee_list_active); $i++) {
							$mname = !empty($employee_list_active[$i]['mname']) ? $employee_list_active[$i]['mname'][0].". " : '';
							$suffix = !empty($employee_list_active[$i]['suffix']) ? " ".$employee_list_active[$i]['suffix'] : '';
							$prefix = !empty($employee_list_active[$i]['title']) ? $employee_list_active[$i]['title']." " : '';
							$name = $prefix.ucwords($employee_list_active[$i]['fname']." ".$mname." ".$employee_list_active[$i]['sname']).$suffix;
						?>
							<optgroup label="<?php echo $employee_list_active[$i]['func']; ?>">
								<option value="<?php echo $this->encrypt->encode($employee_list_active[$i]['userid']); ?>"><?php echo $name; ?></option>
							</optgroup>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-2" style="margin-top:5px;">
					<input type="text" class="form-control" value="<?php echo $rws; ?>" readonly>
					<input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode($rws); ?>" required="" readonly="">
				</div>
			<script type="text/javascript">$('#dthrchy<?php echo $rws; ?>').selectize();</script>
			<?php } ?>
		</div>
	<?php	}
	}
}
?>
