<?php

/**
 *
 */
class Notification extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
	}

	// function index(){
	//
  //   if($this->input->post('value') == 'tr' ){ //Travel order ticket request
  //     $region  = $this->session->userdata('region');
  //     $query   = $this->db->query("SELECT COUNT(`tt`.`er_no`) AS `cnterno`, `ttr`.`cnt`
  //        FROM `embis`.`to_trans` AS `tt`
  //        LEFT JOIN `embis`.`to_ticket_request` AS `ttr` ON `ttr`.`er_no`=`tt`.`er_no`
  //        LEFT JOIN `embis`.`er_transactions` AS `et` ON `et`.`trans_no`=`tt`.`er_no`
  //        WHERE `tt`.`travel_type` != 'Land' AND `et`.`status` != 0 AND `tt`.`region` = '$region' AND (`tt`.`status` = 'Approved' OR `tt`.`status` = 'Signed Document')")->result_array();
  //     $querywithticket = $this->db->query("SELECT COUNT(`tt`.`er_no`) AS `cnternow`, `ttr`.`cnt`
  //         FROM `embis`.`to_trans` AS `tt`
  //         LEFT JOIN `embis`.`to_ticket_request` AS `ttr` ON `ttr`.`er_no`=`tt`.`er_no`
  //         LEFT JOIN `embis`.`er_transactions` AS `et` ON `et`.`trans_no`=`tt`.`er_no`
  //         WHERE `tt`.`travel_type` != 'Land' AND `et`.`status` != 0 AND `tt`.`region` = '$region' AND `et`.`status` = '5' AND `ttr`.`cnt` != ''")->result_array();
	//
  //     $notif = $query[0]['cnterno']-$querywithticket[0]['cnternow'];
  //     if($notif == 0){ $value = "0"; }else{ $value = $notif; }
  //   }
	// 	// for clients notications
	// 	if ($this->session->userdata('client_rights') == 'yes' ){
	// 		// $value = 1;
	// 		if ($this->session->userdata('userid') == '1') {
	// 			$region = 'NCR';
	// 		}else {
	// 		 $region = $this->session->userdata('region_id',TRUE);
	// 		}
	//
	// 		$crsdb = $this->load->database('crs',TRUE);
	// 		$wherenotcom = array('cer.status' => 0,'est.est_region' => $region );
	// 		$compquery  	= $crsdb->select('cer.status,est.est_region')->from('establishment as est')->join('client_est_requests as cer','cer.est_id = est.est_id')->where($wherenotcom)->get();
	// 		$cnt_comp_req = $compquery->num_rows();
	// 		$cnt_client_total  = $cnt_comp_req;
	// 	}else {
	// 		$cnt_client_total = '0';
	// 	}
	//
	// 		$cntdata = array(
	// 		'compcnt' => $cnt_client_total,
	// 		);
	// 		$this->session->set_userdata($cntdata);
	//
  //   // echo $value+$cnt_client_total;
	//
	// 	//if user is online
	// 	if(!empty($this->session->userdata('userid'))){
	// 		date_default_timezone_set("Asia/Manila");
	// 		$datetime = date("Y-m-d H:i");
	// 		$set = array('acs.timestamp' => $datetime);
	// 		$update = $this->Embismodel->updatedata($set, 'acc_credentials AS acs', 'acs.userid = "'.$this->session->userdata('userid').'"');
	// 	}
  // }

	function bilangin_ang_abiso(){
				//if user is online
				if(!empty($this->session->userdata('userid'))){
					date_default_timezone_set("Asia/Manila");
					$datetime = date("Y-m-d H:i");
					$set = array('acs.timestamp' => $datetime);
					$update = $this->Embismodel->updatedata($set, 'acc_credentials AS acs', 'acs.userid = "'.$this->session->userdata('userid').'"');
				}

			$crsdb = $this->load->database('crs',TRUE);
			$embisdb = $this->load->database('default', TRUE);

			$rtcwhere = array('din.userid' => $this->session->userdata('userid'), );
			$receive_transaction_count = $this->Embismodel->selectdata('embis.vw_dms_inbox_notif as din','din.total',$rtcwhere);

			$sessreg_id = ($this->session->userdata('region_id') == '18') ? '15' : $this->session->userdata('region_id');
			$company_request_count =  $crsdb->select('cnt')->from('comp_req_notif')->where('est_region',$sessreg_id)->get()->num_rows();

		  $ticketissuance = '';
		  if($this->session->userdata('superadmin_rights') == 'yes' || $this->session->userdata('to_ticket_request') == "yes" || $this->session->userdata('to_view_all_approved') == "yes" || $this->session->userdata('to_approver') == "yes"){
		    $queryforapproval = $embisdb->select('tfn.cnt')
		                                ->from('to_forapproval_notif AS tfn')
		                                ->where('tfn.userid = "'.$this->session->userdata('userid').'"')->get()->result_array();
		    if($this->session->userdata('to_ticket_request') == "yes" || $this->session->userdata('superadmin_rights') == 'yes'){
		      $queryticket = $embisdb->select('ttrn.cnt')
		                            ->from('to_ticket_request_notif AS ttrn')
		                            ->where('ttrn.region = "'.$this->session->userdata('region').'"')->get()->result_array();
		      $ticketissuance = $queryticket[0]['cnt'];
		    }
		  }

			$toc = $queryforapproval[0]['cnt'] + $ticketissuance;

			$queryforapproval = $embisdb->select('tfn.cnt')
		                              ->from('to_forapproval_notif AS tfn')
		                              ->where('tfn.userid = "'.$this->session->userdata('region').'"')->get()->result_array();

			$queryticket = $embisdb->select('ttrn.cnt')
		                        ->from('to_ticket_request_notif AS ttrn')
		                        ->where('ttrn.region = "'.$this->session->userdata('region').'"')->get()->result_array();

			$queryforapproval    = $embisdb->select('sfn.cnt')
		                              ->from('swm_forapproval_notif AS sfn')
		                              ->where('sfn.userid = "'.$this->session->userdata('userid').'"')->get()->result_array();


		  $queryforapprovalnov = $embisdb->select('sfnn.cnt')
		                              ->from('swm_forapproval_nov_notif AS sfnn')
		                              ->where('sfnn.userid = "'.$this->session->userdata('userid').'"')->get()->result_array();

		  $sfc = $queryforapproval[0]['cnt'] + $queryforapprovalnov[0]['cnt'];

			$msctotal = 0;
		  $queryschedules   = $embisdb->select('sl.cnt, sl.participants, sl.date_schedule')
		                              ->from('schedule_list AS sl')
		                              ->where('sl.status = "Active" AND (sl.sched_status != "done" OR sl.sched_status != "postponed") AND sl.participants LIKE "%'.$this->session->userdata('userid').'%"')->get()->result_array();
		  for ($i=0; $i < sizeof($queryschedules); $i++) {
		    $explodedata = explode('|', $queryschedules[$i]['participants']);
		    for ($p=0; $p < count($explodedata); $p++) {
		      if($explodedata[$p] == $this->session->userdata('userid') AND $queryschedules[$i]['date_schedule'] >=  date('Y-m-d')){
		        $total++;
		      }
		    }
		  }
		  $msc = $msctotal;



			$region =  $this->session->userdata('region');
			$spc = $this->db->select('ticket_ass_id')->from('sp_ticket_assisstance')->where('region',$region)->where('status',0)->get()->num_rows();



			$data = array(
										'rtc'  => intval($receive_transaction_count[0]['total']),
										'crc'  => $company_request_count,
										'toc'  => $toc,
										'tofa' => $toc-$ticketissuance,
										'tot'  => intval($queryticket[0]['cnt']),
										'sfc'  => $sfc,
										'msc'  => $msc,
										'spc'  => $spc,
									 );
			echo json_encode($data);

	}


}
