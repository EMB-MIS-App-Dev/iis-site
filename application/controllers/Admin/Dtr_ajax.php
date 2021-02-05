<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Dtr_ajax extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
    date_default_timezone_set("Asia/Manila");
	}

  function timelog(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
		$button = $this->encrypt->decode($this->input->post('button', TRUE));
    if($token == 'punch_in'){ $punch_cat = 'IN'; }
    if($token == 'punch_out'){ $punch_cat = 'OUT'; }
    if(!empty($token) AND !empty($punch_cat)){

      $punchin = ($token == 'punch_in') ? date('h:i A') : '';
      $punchout = ($token == 'punch_out') ? date('h:i A') : '';

			$wheredata = array('staff' => $this->session->userdata('userid'), 'punch_date' => date('F d, Y'), );
      $selectdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','',$wheredata);

			if(!empty($punchin) AND empty($selectdata[0]['in']) AND $button == '1') {
				$data = array(
                      'staff'        => $this->session->userdata('userid'),
											'order_by'     => date('d'),
											'punch_date_s' => date('Y-m-d'),
                      'punch_date'   => date('F d, Y'),
                      'in'           => $punchin,
                      'out'          => '',
											'region'       => $this->session->userdata('region'),
                      'stat'         => 'Active',
											'statcol'      => 'wfh',
                     );
        $insertdata = $this->Embismodel->insertdata('acc_dtr_horizontal', $data);
			}else if(!empty($punchin) AND empty($selectdata[0]['in_pm']) AND $button == '3') {
				$wheredatah = array('staff' => $this->session->userdata('userid'), 'punch_date' => date('F d, Y'), );
				$setdatah = array('in_pm' => $punchin, );
				$updatedata = $this->Embismodel->updatedata($setdatah, 'acc_dtr_horizontal', $wheredatah);
			}
			if(!empty($punchout) AND empty($selectdata[0]['out']) AND $button == '2'){
				$inam = new DateTime(date('H:i', strtotime($selectdata[0]['in'])));
				$outam = new DateTime(date('H:i', strtotime($punchout)));
				$intervalam = $inam->diff($outam);
				$am_hrsworked = $intervalam->h.':'.$intervalam->i;

				$wheredatah = array('staff' => $this->session->userdata('userid'), 'punch_date' => date('F d, Y'), );
				$setdatah = array('out' => $punchout, 'am_hrsworked' => $am_hrsworked,);
				$updatedata = $this->Embismodel->updatedata($setdatah, 'acc_dtr_horizontal', $wheredatah);

			}else if(!empty($punchout) AND empty($selectdata[0]['out_pm']) AND $button == '4') {
				$inpm = new DateTime(date('H:i', strtotime($selectdata[0]['in_pm'])));
				$outpm = new DateTime(date('H:i', strtotime($punchout)));
				$intervalpm = $inpm->diff($outpm);
				$pm_hrsworked = $intervalpm->h.':'.$intervalpm->i;

				$wheredatah = array('staff' => $this->session->userdata('userid'), 'punch_date' => date('F d, Y'), );
				$setdatah = array('out_pm' => $punchout, 'pm_hrsworked' => $pm_hrsworked, );
				$updatedata = $this->Embismodel->updatedata($setdatah, 'acc_dtr_horizontal', $wheredatah);
			}
      echo json_encode(array('status' => 'success', ));
    }
  }

	function filterdtr(){
		$token = $this->input->post('token', TRUE);
		$this->session->set_userdata('filterdtr', $token);
		echo json_encode(array('status' => 'success', ));
	}

	function chkbtntime(){
		$wheredata = $this->db->where('adh.punch_date_s = "'.date('Y-m-d').'" AND adh.staff = "'.$this->session->userdata('userid').'"');
		$checkdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','','',$wheredata);

		if(empty($checkdata[0]['punch_date_s']) AND empty($checkdata[0]['in']) AND empty($checkdata[0]['out']) AND empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm'])){
			echo json_encode(array('stat' => '1', ));
		}

		if(!empty($checkdata[0]['in']) AND empty($checkdata[0]['out']) AND empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm'])){
			echo json_encode(array('stat' => '2', ));
		}

		if(!empty($checkdata[0]['out']) AND empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm']) AND !empty($checkdata[0]['in'])){
			echo json_encode(array('stat' => '3', ));
		}

		if(!empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm']) AND !empty($checkdata[0]['in']) AND !empty($checkdata[0]['out'])){
			echo json_encode(array('stat' => '4', ));
		}

		if(!empty($checkdata[0]['out_pm']) AND !empty($checkdata[0]['in']) AND !empty($checkdata[0]['out']) AND !empty($checkdata[0]['in_pm'])){
			echo json_encode(array('stat' => '5', ));
		}
	}

	// function chkbtntimetwo(){
	// 	$wheredata = $this->db->where('adh.punch_date_s = "'.date('Y-m-d').'" AND adh.staff = "'.$this->session->userdata('userid').'"');
	// 	$checkdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','','',$wheredata);
	//
	// 	if(empty($checkdata[0]['punch_date_s']) AND empty($checkdata[0]['in']) AND empty($checkdata[0]['out']) AND empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm'])){
	// 		echo json_encode(array('stat' => '1', ));
	// 	}
	//
	// 	if(!empty($checkdata[0]['in']) AND empty($checkdata[0]['out']) AND empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm'])){
	// 		echo json_encode(array('stat' => '2', ));
	// 	}
	//
	// 	if(!empty($checkdata[0]['out']) AND empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm']) AND !empty($checkdata[0]['in'])){
	// 		echo json_encode(array('stat' => '3', ));
	// 	}
	//
	// 	if(!empty($checkdata[0]['in_pm']) AND empty($checkdata[0]['out_pm']) AND !empty($checkdata[0]['in']) AND !empty($checkdata[0]['out'])){
	// 		echo json_encode(array('stat' => '4', ));
	// 	}
	//
	// 	if(!empty($checkdata[0]['out_pm']) AND !empty($checkdata[0]['in']) AND !empty($checkdata[0]['out']) AND !empty($checkdata[0]['in_pm'])){
	// 		echo json_encode(array('stat' => '5', ));
	// 	}
	// }

	function timenow(){
		$time = date('h:i A');
		echo json_encode(array('result' => $time, ));
	}
}
