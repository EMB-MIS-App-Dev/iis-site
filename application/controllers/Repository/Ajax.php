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
	}

  function index(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $random        = str_split('QWERTYUIOP12345678!@'); shuffle($random);
    $randomkey     = array_slice($random, 0, 10);
    $key = "EMB-".implode('', $randomkey).$token;
		$key_link = "iis.emb.gov.ph/verify?token=".$key;

    $where_doc_type  = $this->db->where('et.sysid = "12" GROUP BY name ORDER BY name ASC ');
    $select_doc_type = $this->Embismodel->selectdata('er_type AS et','','',$where_doc_type);

    $where_rec_emp   = $this->db->where('(af.userid = "468" AND af.stat = "1") OR af.secno = "77" AND af.stat = "1" AND af.region = "'.$this->session->userdata('region').'"  ORDER BY af.func_order ASC, acs.fname ASC');
    $join_rec_emp    = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
    $select_rec_emp  = $this->Embismodel->selectdata('acc_function AS af','acs.userid, acs.fname, acs.mname, acs.sname, acs.suffix, af.func','',$where_rec_emp);
    if($token == $this->session->userdata('userid')){ ?>
      <style media="screen">
        #qr_span{
          font-size: 8pt;
        }
      </style>
      <form action="Repository/Postdata" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <b><label>Step 1: <span id="qr_span">Copy QR Code and Paste to the document</span></label></b><br>
            <input type="hidden" name="token" value="<?= $this->encrypt->encode($key); ?>">
            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2F<?= $key_link; ?>%2F&choe=UTF-8" style="width:150px;">
          </div>
          <div class="col-md-5">
            <b><label>Step 2: <span id="qr_span">Please indicate type of document and subject</span></label></b><br>
            <label>Type of Document</label>
            <select id="doc_type_selectize" class="form-control" name="doc_type" required>
              <option value=""></option>
              <?php for ($i=0; $i < sizeof($select_doc_type); $i++) { ?>
                <option value="<?php echo $this->encrypt->encode($select_doc_type[$i]['id']); ?>"><?php echo $select_doc_type[$i]['name']; ?></option>
              <?php } ?>
            </select>
            <label>Subject</label>
            <input type="text" class="form-control" name="subject" required>
          </div>
          <div class="col-md-4">
            <b><label>Step 3: <span id="qr_span">Attachment</span></label></b><br>
            <label>Please attach file with QR Code already</label>
            <input type="file" class="form-control" name="file[]" multiple>
          </div>
          <div class="col-md-12">
            <b><label>Step 4: <span id="qr_span">Route document to Records</span></label></b><br>
            <label>Please select employee</label>
            <select id="records_employee_selectize" class="form-control" name="employee_token">
              <option value=""></option>
              <?php for ($emp=0; $emp < sizeof($select_rec_emp); $emp++) {
                $mname = !empty($select_rec_emp[$emp]['mname']) ? $select_rec_emp[$emp]['mname'][0].". " : "" ;
                $suffix = !empty($select_rec_emp[$emp]['suffix']) ? " ".$select_rec_emp[$emp]['suffix'] : "" ;
                $name = ucwords($select_rec_emp[$emp]['fname']." ".$mname.$select_rec_emp[$emp]['sname'].$suffix);
                ?>
                <optgroup label="<?php echo $select_rec_emp[$emp]['func']; ?>">
                  <option value="<?php echo $this->encrypt->encode($select_rec_emp[$emp]['userid']); ?>"><?php echo $name; ?></option>
                </optgroup>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
      </div>
      </form>
      <script type="text/javascript">
          $(document).ready( function(){
            $('#doc_type_selectize').selectize();
            $('#records_employee_selectize').selectize();
          });
      </script>
    <?php
    }
  }

  function rpvwattmnt(){
    $token = ($this->input->post('token', TRUE));

		$orderdata  = $this->db->order_by('et.date_out','desc');
    $wheredata  = $this->db->where('ea.trans_no = "'.$token.'" AND et.route_order = ea.route_order');
    $joindata   = $this->db->join('er_transactions_log AS et','et.trans_no = ea.trans_no','left');
    $selectdata = $this->Embismodel->selectdata('er_attachments AS ea','ea.*,et.date_in,et.date_out,et.receiver_region,et.sender_name','',$wheredata,$orderdata);

		for ($i=0; $i < sizeof($selectdata); $i++) {
			if($_SESSION['superadmin_rights'] == 'yes'){
				$path_file = base_url()."uploads/dms/".date("Y", strtotime($selectdata[$i]['date_in']))."/".$selectdata[$i]['receiver_region']."/".$token."/".$selectdata[$i]['token'].'.'.pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION);
					echo '<li style="padding: 5px 15px 5px 15px;width: 250px;"><a title="Date attached: '.date("M d, Y", strtotime($selectdata[$i]['date_out'])).'" target="_blank" href="'.$path_file.'">'.substr($selectdata[$i]['token'],0,6).'.'.pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION).'</a> <span style="font-style: italic;color:#000;"> - by '.$selectdata[$i]['sender_name'].'</span></li>';
			}else{
					echo '<li style="padding: 5px 15px 5px 15px;width: 250px;"><a title="Date attached: '.date("M d, Y", strtotime($selectdata[$i]['date_out'])).'">'.substr($selectdata[$i]['token'],0,6).'.'.pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION).'</a> <span style="font-style: italic;color:#000;"> - by '.$selectdata[$i]['sender_name'].'</span></li>';
			}

		 } ?>
  <?php
  }
}
