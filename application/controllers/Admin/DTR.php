<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class DTR extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->model('Transmodel');
		$this->load->model('Administrativemodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');
		date_default_timezone_set("Asia/Manila");
	}

  function index(){
    $this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
		$this->load->view('includes/common/footer');
		$whereusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.userid != "1" AND acs.verified = "1" ORDER BY fname ASC');
		$query['selectusers'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.fname, acs.mname, acs.sname, acs.suffix','',$whereusers);

		$orderbyusers = $this->db->order_by('acs.fname','asc');
		$whereusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.userid != "1" AND acs.verified = "1"');
		$query['users'] = $this->Administrativemodel->select_employees($whereusers,$orderbyusers);

		$wheredata = $this->db->where('adr.routedto_userid = "'.$this->session->userdata('userid').'" AND er.status != 0 AND adr.status = "For payroll" GROUP BY adr.trans_no');
		$joindata = $this->db->join('er_transactions AS er','er.token = adr.trans_no','left');
		$query['forpayroll'] = $this->Embismodel->selectdata('acc_dtr_routed AS adr','adr.*','',$joindata,$wheredata);


		$this->load->view('superadmin/dtr',$query);
		$this->load->view('superadmin/modals');
		// $this->output->enable_profiler(TRUE);
  }

	function Pdf($tokenget = ''){
		$tokendecoded = $this->encrypt->decode($tokenget);
		// echo $tokendecoded; exit;
		$explodetoken = explode('|',$tokendecoded);

		// $wheredata = $this->db->where('adh.staff = "'.$this->session->userdata('userid').'" AND adh.stat = "Active" AND adh.punch_date LIKE "'.date('F', strtotime($token)).'%"  AND adh.punch_date LIKE "%'.date('Y', strtotime($token)).'" ORDER BY adh.cnt ASC');
		$wheredata = $this->db->where('adh.staff = "'.$this->session->userdata('userid').'" AND adh.stat = "Active" AND adh.punch_date_s BETWEEN "'.$explodetoken[1].'" AND "'.$explodetoken[2].'" ORDER BY adh.cnt ASC');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = adh.staff','left');
		$queryselect = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.*, acs.fname, acs.mname, acs.sname, acs.suffix','',$joindata,$wheredata);

		$mname = (!empty($queryselect[0]['mname'])) ? $queryselect[0]['mname'][0].'. ' : '';
		$suffix = (!empty($queryselect[0]['suffix'])) ? ' '.$queryselect[0]['suffix'] : '';
		$name = $queryselect[0]['fname'].' '.$mname.$queryselect[0]['sname'].$suffix;

		$wheresupervisor = $this->db->where('acs.verified = "1" AND acs.userid = "'.$this->encrypt->decode($explodetoken[3]).'"');
		$querysupervisor = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, acs.designation','',$wheresupervisor);

		$smname = (!empty($querysupervisor[0]['mname'])) ? $querysupervisor[0]['mname'][0].'. ' : '';
		$ssuffix = (!empty($querysupervisor[0]['suffix'])) ? ' '.$querysupervisor[0]['suffix'] : '';
		$supervisorname = $querysupervisor[0]['fname'].' '.$smname.$querysupervisor[0]['sname'].$ssuffix;

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 15, 10, 15);
    $pdf->SetTitle('CSC Form 48');
    $pdf->SetCreator(PDF_CREATOR);
		$page_format = array('210', '330.2');

    $pdf->AddPage('P', $page_format, false, false);
		$html .= '
							<table style="font-size:10px;font-family:Serif;letter-spacing: 1px;">
								<tr style="font-weight:100;font-size:9px;">
									<td style="width:48%;">CSC Form 48</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">CSC Form 48</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:bold;">
									<td style="width:48%;">DAILY TIME RECORD</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">DAILY TIME RECORD</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;">(Environmental Management Bureau '.$this->session->userdata('region').')</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">(Environmental Management Bureau '.$this->session->userdata('region').')</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;font-size:9px;">
									<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;">'.strtoupper($name).'</td>
									<td style="width:4%;"></td>
									<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;">'.strtoupper($name).'</td>
								</tr>
								<tr style="text-align:center;font-weight:100;font-size:9px;">
									<td style="width:48%;">Name</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">Name</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="font-weight:100;font-size:9px;">
									<td style="width:17%;">For the month of:</td>
									<td style="width:31%;border-bottom:1px solid #000;font-weight:bold;text-align:center;">'.date("F d", strtotime($explodetoken[1])).' - '.date("d, Y", strtotime($explodetoken[2])).'</td>
									<td style="width:4%;"></td>
									<td style="width:17%;">For the month of:</td>
									<td style="width:31%;border-bottom:1px solid #000;font-weight:bold;text-align:center;">'.date("F d", strtotime($explodetoken[1])).' - '.date("d, Y", strtotime($explodetoken[2])).'</td>
								</tr>
								<tr style="font-weight:100;font-size:9px;">
									<td style="width:26%;">Office Hours (regular days):</td>
									<td style="width:22%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
									<td style="width:4%;"></td>
									<td style="width:26%;">Office Hours (regular days):</td>
									<td style="width:22%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
								</tr>
								<tr style="font-weight:100;font-size:9px;">
									<td style="width:21%;">Arrival and Departure:</td>
									<td style="width:27%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
									<td style="width:4%;"></td>
									<td style="width:21%;">Arrival and Departure:</td>
									<td style="width:27%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
								</tr>
								<tr style="font-weight:100;font-size:9px;">
									<td style="width:10%;">Saturdays:</td>
									<td style="width:38%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
									<td style="width:4%;"></td>
									<td style="width:10%;">Saturdays:</td>
									<td style="width:38%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
							</table>

							<table style="font-size:10px;font-family:Serif;">
								<tr style="font-weight:bold;font-size:9px;text-align:center;">
									<td style="width:20%;border:0.5px solid #000;">AM</td>
									<td style="width:14%;border:0.5px solid #000;">PM</td>
									<td style="width:14%;border:0.5px solid #000;">UNDERTIME</td>
									<td style="width:4%;"></td>
									<td style="width:20%;border:0.5px solid #000;">AM</td>
									<td style="width:14%;border:0.5px solid #000;">PM</td>
									<td style="width:14%;border:0.5px solid #000;">UNDERTIME</td>
								</tr>
								<tr style="font-weight:bold;font-size:7px;text-align:center;">
									<td style="width:6%;border:0.5px solid #000;">DAY</td>
									<td style="width:7%;border:0.5px solid #000;">IN</td>
									<td style="width:7%;border:0.5px solid #000;">OUT</td>
									<td style="width:7%;border:0.5px solid #000;">IN</td>
									<td style="width:7%;border:0.5px solid #000;">OUT</td>
									<td style="width:7%;border:0.5px solid #000;">HRS</td>
									<td style="width:7%;border:0.5px solid #000;">MINS</td>
									<td style="width:4%;"></td>
									<td style="width:6%;border:0.5px solid #000;">DAY</td>
									<td style="width:7%;border:0.5px solid #000;">IN</td>
									<td style="width:7%;border:0.5px solid #000;">OUT</td>
									<td style="width:7%;border:0.5px solid #000;">IN</td>
									<td style="width:7%;border:0.5px solid #000;">OUT</td>
									<td style="width:7%;border:0.5px solid #000;">HRS</td>
									<td style="width:7%;border:0.5px solid #000;">MINS</td>
								</tr>';
			$day = "1";
			//$queryselect
			for ($i=0; $i < 31; $i++) {
					$in = "";
					$out = "";
					$in_pm = "";
					$out_pm = "";
					$undertimeinsec = "";
					$undertimeinhrs = "";
					$undertimeinmins = "";
				for ($t=0; $t < sizeof($queryselect); $t++) {
					$qryday = ltrim(date('d', strtotime($queryselect[$t]['punch_date'])), '0');
					if(!empty($queryselect[$t]['in']) AND $qryday == $day) {
						$in = ($queryselect[$t]['in'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['in']));
						// $in = 'WFH';
					}
					if(!empty($queryselect[$t]['out']) AND $qryday == $day) {
						$out = ($queryselect[$t]['out'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['out']));
						// $out = 'WFH';
					}
					if(!empty($queryselect[$t]['in_pm']) AND $qryday == $day) {
						$in_pm = ($queryselect[$t]['in_pm'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['in_pm']));
						// $in_pm = 'WFH';
					}
					if(!empty($queryselect[$t]['out_pm']) AND $qryday == $day) {
						$out_pm = ($queryselect[$t]['out_pm'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['out_pm']));
						// $out_pm = 'WFH';
					}

					if($qryday == $day AND !empty($queryselect[$t]['total_hrsworked'])) {
						if(strtotime($queryselect[$t]['total_hrsworked']) >= strtotime('08:00:00')){
							$total_hrsworked = "08:00:00";
						}else{
							$total_hrsworked = $queryselect[$t]['total_hrsworked'];
						}

						sscanf($total_hrsworked, "%d:%d:%d", $thwhours, $thwminutes, $thwseconds);
						$total_hrsworked_seconds = isset($thwhours) ? $thwhours * 3600 + $thwminutes * 60 + $thwseconds : $thwminutes * 60 + $thwseconds;

						sscanf("08:00:00", "%d:%d:%d", $bhwhours, $bhwminutes, $bhwseconds);
						$basehrsworked_seconds = isset($bhwhours) ? $bhwhours * 3600 + $bhwminutes * 60 + $bhwseconds : $bhwminutes * 60 + $bhwseconds;

						$undertimeinsec = $basehrsworked_seconds - $total_hrsworked_seconds;

						$undertimeinhrs = gmdate("G", $undertimeinsec);
						$undertimeinmins = gmdate("i", $undertimeinsec);
					}
				}

					$html .='
										<tr style="font-size:10px;text-align:center;">
											<td style="width:6%;border:0.5px solid #000;">'.$day.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$in.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$out.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$in_pm.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$out_pm.'</td>
											<td style="width:7%;border:0.5px solid #000;"></td>
											<td style="width:7%;border:0.5px solid #000;"></td>
											<td style="width:4%;"></td>
											<td style="width:6%;border:0.5px solid #000;">'.$day.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$in.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$out.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$in_pm.'</td>
											<td style="width:7%;border:0.5px solid #000;">'.$out_pm.'</td>
											<td style="width:7%;border:0.5px solid #000;"></td>
											<td style="width:7%;border:0.5px solid #000;"></td>
										</tr>
									';

				$day++;
			}
			$html .='</table>';

			// $whereesiguser = $this->db->where('oue.userid = "'.$queryselect[0]['staff'].'" AND oue.status = "Active"');
			// $selectesiguser = $this->Embismodel->selectdata('office_uploads_esignature AS oue','oue.file_name, oue.to_xaxis_a, oue.to_yaxis_a, oue.to_width_a, oue.to_height_a','',$whereesiguser);
			//
			// $uxaxis = $selectesiguser[0]['to_xaxis_a'];
			// $uyaxis = $selectesiguser[0]['to_yaxis_a'];
			// $uwidth = $selectesiguser[0]['to_width_a'];
			// $uheight = $selectesiguser[0]['to_height_a'];
			//
			// $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectesiguser[0]['file_name'].'', ($uxaxis-50), ($uyaxis-55), $uwidth, $uheight, '', '', '', false, 300, '', false, false, '', false, false, false);
			// $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectesiguser[0]['file_name'].'', ($uxaxis+50), ($uyaxis-55), $uwidth, $uheight, '', '', '', false, 300, '', false, false, '', false, false, false);
			$html .='
							<table style="font-size:8px;font-family:Serif;">
								<tr style="font-weight:bold;">
									<td style="width:7%;">TOTAL</td>
									<td style="width:15%;border-bottom:1px solid #000;"></td>
									<td style="width:26%;"></td>
									<td style="width:4%;"></td>
									<td style="width:7%;">TOTAL</td>
									<td style="width:15%;border-bottom:1px solid #000;"></td>
									<td style="width:26%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:justify;font-weight:100;font-size:10px;">
									<td style="width:48%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby certify on my honor that the above is a true and correct report of work performed, record of which was made daily at the time and departure from office.</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby certify on my honor that the above is a true and correct report of work performed, record of which was made daily at the time and departure from office.</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="font-size:10px;text-align:center;font-weight:100;">
									<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;font-size:10px;">
									<td style="width:48%;">Employee Signature</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">Employee Signature</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;font-style:italic;font-size:10px;">
									<td style="width:48%;">Verified as to the prescribed office hours:</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">Verified as to the prescribed office hours:</td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-weight:100;">
									<td style="width:48%;"></td>
									<td style="width:4%;"></td>
									<td style="width:48%;"></td>
								</tr>
								<tr style="text-align:center;font-size:10px;font-weight:bold;">
									<td style="width:48%;">'.strtoupper($supervisorname).'</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">'.strtoupper($supervisorname).'</td>
								</tr>
								<tr style="text-align:center;font-size:9px;">
									<td style="width:48%;border-bottom:1px solid #000;">'.strtoupper($querysupervisor[0]['designation']).'</td>
									<td style="width:4%;"></td>
									<td style="width:48%;border-bottom:1px solid #000;">'.strtoupper($querysupervisor[0]['designation']).'</td>
								</tr>
								<tr style="text-align:center;font-weight:100;font-size:10px;">
									<td style="width:48%;">In-charge</td>
									<td style="width:4%;"></td>
									<td style="width:48%;">In-charge</td>
								</tr>
							</table>
							';

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output();
	}

	function PdfPrev(){
		// echo $tokendecoded; exit;
		$explodetoken = explode('$',$_GET['token']);
		// print_r($explodetoken); exit;
		// $wheredata = $this->db->where('adh.staff = "'.$this->session->userdata('userid').'" AND adh.stat = "Active" AND adh.punch_date LIKE "'.date('F', strtotime($token)).'%"  AND adh.punch_date LIKE "%'.date('Y', strtotime($token)).'" ORDER BY adh.cnt ASC');
		// $whereusersdata = $this->db->where('adh.stat = "Active" AND adh.punch_date_s BETWEEN "'.$explodetoken[1].'" AND "'.$explodetoken[2].'" AND adh.region = "'.$this->session->userdata('region').'" GROUP BY adh.staff');
		// $selectusers = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.staff','',$whereusersdata);
		// echo $this->db->last_query(); exit;
			$whereuser = $this->db->where('acs.token = "'.$explodetoken[0].'"');
		 	$selectuser = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid, acs.fname, acs.mname, acs.sname, acs.suffix','',$whereuser);

			$wheredata = $this->db->where('adh.staff = "'.$selectuser[0]['userid'].'" AND adh.stat = "Active" AND adh.punch_date_s BETWEEN "'.$explodetoken[1].'" AND "'.$explodetoken[2].'" ORDER BY adh.cnt ASC');
			$queryselect = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.*','',$wheredata);

			$mname = (!empty($selectuser[0]['mname'])) ? $selectuser[0]['mname'][0].'. ' : '';
			$suffix = (!empty($selectuser[0]['suffix'])) ? ' '.$selectuser[0]['suffix'] : '';
			$name = $selectuser[0]['fname'].' '.$mname.$selectuser[0]['sname'].$suffix;

			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->SetMargins(10, 15, 10, 15);
			$pdf->SetTitle('CSC Form 48');
			$pdf->SetCreator(PDF_CREATOR);
			$page_format = array('210', '330.2');

			$pdf->AddPage('P', $page_format, false, false);
			$html .= '
								<table style="font-size:10px;font-family:Serif;letter-spacing: 1px;">
									<tr style="font-weight:100;font-size:9px;">
										<td style="width:48%;">CSC Form 48</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">CSC Form 48</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:bold;">
										<td style="width:48%;">DAILY TIME RECORD</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">DAILY TIME RECORD</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;">(Environmental Management Bureau '.$this->session->userdata('region').')</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">(Environmental Management Bureau '.$this->session->userdata('region').')</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;font-size:9px;">
										<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;">'.strtoupper($name).'</td>
										<td style="width:4%;"></td>
										<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;">'.strtoupper($name).'</td>
									</tr>
									<tr style="text-align:center;font-weight:100;font-size:9px;">
										<td style="width:48%;">Name</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">Name</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="font-weight:100;font-size:9px;">
										<td style="width:17%;">For the month of:</td>
										<td style="width:31%;border-bottom:1px solid #000;font-weight:bold;text-align:center;">'.date("F d", strtotime($explodetoken[1])).' - '.date("d, Y", strtotime($explodetoken[2])).'</td>
										<td style="width:4%;"></td>
										<td style="width:17%;">For the month of:</td>
										<td style="width:31%;border-bottom:1px solid #000;font-weight:bold;text-align:center;">'.date("F d", strtotime($explodetoken[1])).' - '.date("d, Y", strtotime($explodetoken[2])).'</td>
									</tr>
									<tr style="font-weight:100;font-size:9px;">
										<td style="width:26%;">Office Hours (regular days):</td>
										<td style="width:22%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
										<td style="width:4%;"></td>
										<td style="width:26%;">Office Hours (regular days):</td>
										<td style="width:22%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
									</tr>
									<tr style="font-weight:100;font-size:9px;">
										<td style="width:21%;">Arrival and Departure:</td>
										<td style="width:27%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
										<td style="width:4%;"></td>
										<td style="width:21%;">Arrival and Departure:</td>
										<td style="width:27%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
									</tr>
									<tr style="font-weight:100;font-size:9px;">
										<td style="width:10%;">Saturdays:</td>
										<td style="width:38%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
										<td style="width:4%;"></td>
										<td style="width:10%;">Saturdays:</td>
										<td style="width:38%;border-bottom:1px solid #000;font-weight:bold;text-align:center;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
								</table>

								<table style="font-size:10px;font-family:Serif;">
									<tr style="font-weight:bold;font-size:9px;text-align:center;">
										<td style="width:20%;border:0.5px solid #000;">AM</td>
										<td style="width:14%;border:0.5px solid #000;">PM</td>
										<td style="width:14%;border:0.5px solid #000;">UNDERTIME</td>
										<td style="width:4%;"></td>
										<td style="width:20%;border:0.5px solid #000;">AM</td>
										<td style="width:14%;border:0.5px solid #000;">PM</td>
										<td style="width:14%;border:0.5px solid #000;">UNDERTIME</td>
									</tr>
									<tr style="font-weight:bold;font-size:7px;text-align:center;">
										<td style="width:6%;border:0.5px solid #000;">DAY</td>
										<td style="width:7%;border:0.5px solid #000;">IN</td>
										<td style="width:7%;border:0.5px solid #000;">OUT</td>
										<td style="width:7%;border:0.5px solid #000;">IN</td>
										<td style="width:7%;border:0.5px solid #000;">OUT</td>
										<td style="width:7%;border:0.5px solid #000;">HRS</td>
										<td style="width:7%;border:0.5px solid #000;">MINS</td>
										<td style="width:4%;"></td>
										<td style="width:6%;border:0.5px solid #000;">DAY</td>
										<td style="width:7%;border:0.5px solid #000;">IN</td>
										<td style="width:7%;border:0.5px solid #000;">OUT</td>
										<td style="width:7%;border:0.5px solid #000;">IN</td>
										<td style="width:7%;border:0.5px solid #000;">OUT</td>
										<td style="width:7%;border:0.5px solid #000;">HRS</td>
										<td style="width:7%;border:0.5px solid #000;">MINS</td>
									</tr>';
				$day = "1";
				//$queryselect
				for ($i=0; $i < 31; $i++) {
						$in = "";
						$out = "";
						$in_pm = "";
						$out_pm = "";
						$undertimeinsec = "";
						$undertimeinhrs = "";
						$undertimeinmins = "";
					for ($t=0; $t < sizeof($queryselect); $t++) {
						$qryday = ltrim(date('d', strtotime($queryselect[$t]['punch_date'])), '0');
						if(!empty($queryselect[$t]['in']) AND $qryday == $day) {
							$in = ($queryselect[$t]['in'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['in']));
							// $in = 'WFH';
						}
						if(!empty($queryselect[$t]['out']) AND $qryday == $day) {
							$out = ($queryselect[$t]['out'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['out']));
							// $out = 'WFH';
						}
						if(!empty($queryselect[$t]['in_pm']) AND $qryday == $day) {
							$in_pm = ($queryselect[$t]['in_pm'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['in_pm']));
							// $in_pm = 'WFH';
						}
						if(!empty($queryselect[$t]['out_pm']) AND $qryday == $day) {
							$out_pm = ($queryselect[$t]['out_pm'] == '00:00') ? '--' : date('h:i', strtotime($queryselect[$t]['out_pm']));
							// $out_pm = 'WFH';
						}

						if($qryday == $day AND !empty($queryselect[$t]['total_hrsworked'])) {
							if(strtotime($queryselect[$t]['total_hrsworked']) >= strtotime('08:00:00')){
								$total_hrsworked = "08:00:00";
							}else{
								$total_hrsworked = $queryselect[$t]['total_hrsworked'];
							}

							sscanf($total_hrsworked, "%d:%d:%d", $thwhours, $thwminutes, $thwseconds);
							$total_hrsworked_seconds = isset($thwhours) ? $thwhours * 3600 + $thwminutes * 60 + $thwseconds : $thwminutes * 60 + $thwseconds;

							sscanf("08:00:00", "%d:%d:%d", $bhwhours, $bhwminutes, $bhwseconds);
							$basehrsworked_seconds = isset($bhwhours) ? $bhwhours * 3600 + $bhwminutes * 60 + $bhwseconds : $bhwminutes * 60 + $bhwseconds;

							$undertimeinsec = $basehrsworked_seconds - $total_hrsworked_seconds;

							$undertimeinhrs = gmdate("G", $undertimeinsec);
							$undertimeinmins = gmdate("i", $undertimeinsec);
						}
					}

						$html .='
											<tr style="font-size:10px;text-align:center;">
												<td style="width:6%;border:0.5px solid #000;">'.$day.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$in.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$out.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$in_pm.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$out_pm.'</td>
												<td style="width:7%;border:0.5px solid #000;"></td>
												<td style="width:7%;border:0.5px solid #000;"></td>
												<td style="width:4%;"></td>
												<td style="width:6%;border:0.5px solid #000;">'.$day.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$in.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$out.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$in_pm.'</td>
												<td style="width:7%;border:0.5px solid #000;">'.$out_pm.'</td>
												<td style="width:7%;border:0.5px solid #000;"></td>
												<td style="width:7%;border:0.5px solid #000;"></td>
											</tr>
										';

					$day++;
				}
				$html .='</table>';

				// $whereesiguser = $this->db->where('oue.userid = "'.$queryselect[0]['staff'].'" AND oue.status = "Active"');
				// $selectesiguser = $this->Embismodel->selectdata('office_uploads_esignature AS oue','oue.file_name, oue.to_xaxis_a, oue.to_yaxis_a, oue.to_width_a, oue.to_height_a','',$whereesiguser);
				//
				// $uxaxis = $selectesiguser[0]['to_xaxis_a'];
				// $uyaxis = $selectesiguser[0]['to_yaxis_a'];
				// $uwidth = $selectesiguser[0]['to_width_a'];
				// $uheight = $selectesiguser[0]['to_height_a'];
				//
				// $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectesiguser[0]['file_name'].'', ($uxaxis-50), ($uyaxis-55), $uwidth, $uheight, '', '', '', false, 300, '', false, false, '', false, false, false);
				// $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectesiguser[0]['file_name'].'', ($uxaxis+50), ($uyaxis-55), $uwidth, $uheight, '', '', '', false, 300, '', false, false, '', false, false, false);
				$html .='
								<table style="font-size:8px;font-family:Serif;">
									<tr style="font-weight:bold;">
										<td style="width:7%;">TOTAL</td>
										<td style="width:15%;border-bottom:1px solid #000;"></td>
										<td style="width:26%;"></td>
										<td style="width:4%;"></td>
										<td style="width:7%;">TOTAL</td>
										<td style="width:15%;border-bottom:1px solid #000;"></td>
										<td style="width:26%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:justify;font-weight:100;font-size:10px;">
										<td style="width:48%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby certify on my honor that the above is a true and correct report of work performed, record of which was made daily at the time and departure from office.</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby certify on my honor that the above is a true and correct report of work performed, record of which was made daily at the time and departure from office.</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="font-size:10px;text-align:center;font-weight:100;">
										<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;font-weight:bold;border-bottom:1px solid #000;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;font-size:10px;">
										<td style="width:48%;">Employee Signature</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">Employee Signature</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;font-style:italic;font-size:10px;">
										<td style="width:48%;">Verified as to the prescribed office hours:</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">Verified as to the prescribed office hours:</td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-size:10px;font-weight:bold;">
										<td style="width:48%;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;"></td>
									</tr>
									<tr style="text-align:center;font-size:9px;">
										<td style="width:48%;border-bottom:1px solid #000;"></td>
										<td style="width:4%;"></td>
										<td style="width:48%;border-bottom:1px solid #000;"></td>
									</tr>
									<tr style="text-align:center;font-weight:100;font-size:10px;">
										<td style="width:48%;">In-charge</td>
										<td style="width:4%;"></td>
										<td style="width:48%;">In-charge</td>
									</tr>
								</table><br /><br /><br /><br />
								<table style="font-size:7pt;">
									<tr>
										<td style="color:#000000;">Environmental Management Bureau Integrated Information System</td>
										<td style="text-align:right;color:#000000;">'.date('F d, Y').'</td>
									</tr>
								</table>
								<br />
								';
			$path = 'iis.emb.gov.ph/embis/dtr/pdfprev/?token='.$_GET['token'];
			$pdf->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'d%2F&choe=UTF-8', 185, 290, 15, 15, '', '', '', false, 300, '', false, false, '', false, false, false);
			$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output();
	}

	function prevcscformbtn(){
		?>
			<div class="col-md-6">
				<label>From:</label>
				<input type="date" class="form-control" id="precscfrmbtnid" onchange="prevcscformbtnftr($('#precscfrmbtnid').val(),$('#precsctobtnid').val());">
			</div>
			<div class="col-md-6">
				<label>To:</label>
				<input type="date" class="form-control" id="precsctobtnid"  onchange="prevcscformbtnftr($('#precscfrmbtnid').val(),$('#precsctobtnid').val());">
			</div>
		<?php
	}

	function prevcscformbtnftr(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$token = $this->session->userdata('token').'$'.$from.'$'.$to;
		?>
			<a type="button" href="<?php echo base_url().'dtr/pdfprev/?token='.$token; ?>" target="_blank" class="btn btn-success btn-sm" style="width: 100%;"><span class="fa fa-eye"></span>&nbsp;Preview DTR (CSC Form 48)</a>
		<?php
	}

	function chktimelog(){
		$token = date('F d, Y', strtotime($this->input->post('token')));
		$wheredata = $this->db->where('adh.punch_date = "'.$token.'" AND adh.staff = "'.$this->session->userdata('userid').'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','','',$wheredata);

		// $selectcategory = $this->Embismodel->selectdata('acc_dtrcat AS adc','','');

		?>
			<div class="col-md-3">
				<label class="visibletext">* Time in (AM):</label>
				<input type="time" class="form-control" id="timeinam" value="<?php echo (empty($selectdata[0]['in']) OR $selectdata[0]['in'] == '00:00') ? '' : date('H:i', strtotime($selectdata[0]['in'])); ?>">
			</div>
			<div class="col-md-3">
				<label class="visibletext">* Time out (AM):</label>
				<input type="time" class="form-control" id="timeoutam" value="<?php echo (empty($selectdata[0]['out']) OR $selectdata[0]['out'] == '00:00') ? '' : date('H:i', strtotime($selectdata[0]['out'])); ?>">
			</div>
			<div class="col-md-3">
				<label class="visibletext">* Time in (PM):</label>
				<input type="time" class="form-control" id="timeinpm" value="<?php echo (empty($selectdata[0]['in_pm']) OR $selectdata[0]['in_pm'] == '00:00') ? '' : date('H:i', strtotime($selectdata[0]['in_pm'])); ?>">
			</div>
			<div class="col-md-3">
				<label class="visibletext">* Time out (PM):</label>
				<input type="time" class="form-control" id="timeoutpm" value="<?php echo (empty($selectdata[0]['out_pm']) OR $selectdata[0]['out_pm'] == '00:00') ? '' : date('H:i', strtotime($selectdata[0]['out_pm'])); ?>">
			</div>
			<div class="col-md-12"><hr /></div>
			<div class="col-md-12">
				<label class="visibletext">With attachment(s)? / Remarks:</label>
				<!-- <select class="form-control" id="dtrcatselectize" onchange="dtattachments(this.value,'<?php echo $this->encrypt->encode($token); ?>');">
					<option value=""></option>
					<?php for ($sc=0; $sc < sizeof($selectcategory); $sc++) { ?>
					<option value="<?php echo $selectcategory[$sc]['category_name']; ?>"><?php echo $selectcategory[$sc]['category_name'] ?></option>
					<?php } ?>
				</select> -->
				<textarea class="form-control" id="dtrcatselectize" rows="8" cols="80"><?php echo !empty($selectdata[0]['with_attachments']) ? $selectdata[0]['with_attachments'] : ''; ?></textarea>
			</div>
			<div class="col-md-12">
				<label class="visibletext">Upload attachment(s):</label>
				<div class="col-md-12" style="padding: 0px;display: flex;">
					<input type="file" class="form-control" name="dtrattachment[]" id="dtrattachment" multiple>
					<button type="button" class="btn btn-warning btn-sm" style="margin-left: 5px;width: 5%;" title="Upload file(s)" onclick="dtruploadattachment('<?php echo $this->encrypt->encode($token); ?>');"><span class="fa fa-upload"></span></button>
				</div>
				<div class="progress" id="dtruploadfile_" style="display:none; margin-top:5px;">
					<div class="progress-bar progress-bar-striped progress-bar-animated" id="dtruploadfileuploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
						<span id="dtruploadfileprogresspercentage_"></span>
					</div>
				</div>
			</div>
			<div class="col-md-12" id="dtrattached_"></div>
			<!-- <script type="text/javascript">
				$('#dtrcatselectize').selectize({	maxItems: null });;
			</script> -->
		<?php
	}

	function chkdtrattached(){
		$whereattachment = $this->db->where('adh.punch_date_s = "'.$this->input->post('token').'" AND adh.staff = "'.$this->session->userdata('userid').'"');
		$selectattachment = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.cnt,adh.attachment_file','',$whereattachment);
		$explodedata = explode('|',$selectattachment[0]['attachment_file']);
		$counter = 0;
		for ($i=0; $i < count($explodedata); $i++) { ?>
			<?php if(!empty($explodedata[$i])){ if($counter == 0){ echo '<hr/>'; } $counter++; ?>
			<div style="display:flex;margin-bottom: 5px;">
				<input type="text" class="form-control" value="<?php echo $explodedata[$i]; ?>" disabled="">
				<a href="<?php echo base_url(); ?>/uploads/dtr/<?php echo $this->session->userdata('region').'/'.$selectattachment[0]['cnt'].'/'.$explodedata[$i]; ?>" target="_blank" type="button" class="btn btn-info btn-sm" style="margin-left: 5px;width: 10%;"><span class="fa fa-eye"></span></a>
				<a href="#" type="button" class="btn btn-danger btn-sm" style="margin-left: 5px;width: 10%;" onclick="removeuploadedfiledtr('<?php echo $this->encrypt->encode($selectattachment[0]['cnt']); ?>','<?php echo $this->encrypt->encode($explodedata[$i]); ?>');"><span class="fa fa-trash"></span></a>
			</div>
			<?php } ?>
		<?php } ?>
		<input type="hidden" class="form-control" id="attachmentcounter" value="<?php echo $counter; ?>"> <?php
	}

	function dtrattachmentupload(){

		$category = $this->input->post('category', TRUE);
		$datelog = $this->encrypt->decode($this->input->post('datelog', TRUE));

		if((count($_FILES['dtrattachment']['name'])) >= '1'){
			$wherecnt = $this->db->where('adh.punch_date = "'.trim($datelog).'" AND adh.staff = "'.$this->session->userdata('userid').'"');
			$selectcnt = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.attachment_file, adh.cnt','',$wherecnt);

			$maxcnt = "";
			if(empty($selectcnt[0]['cnt'])){

				$data = array('staff' => $this->session->userdata('userid'), 'order_by' => date('d', strtotime($datelog)), 'punch_date_s' => date('Y-m-d', strtotime($datelog)), 'punch_date' => $datelog, 'region' => $this->session->userdata('region'), 'stat' => 'Active',);
				$insertdata = $this->Embismodel->insertdata('acc_dtr_horizontal',$data);

				$wheremaxcnt = $this->db->where('adh.staff = "'.$this->session->userdata('userid').'" AND adh.punch_date = "'.trim($datelog).'"');
				$selectmaxcnt = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.cnt','',$wheremaxcnt);
				$maxcnt = $selectmaxcnt[0]['cnt'];
			}else{
				$maxcnt = $selectcnt[0]['cnt'];
			}

			if(!is_dir('uploads/dtr')) {
				mkdir('uploads/dtr', 0777, TRUE);
			}

			if(!is_dir('uploads/dtr'.$this->session->userdata('region'))) {
				mkdir('uploads/dtr/'.$this->session->userdata('region'), 0777, TRUE);
			}

			if(!is_dir('uploads/dtr'.$this->session->userdata('region').'/'.$maxcnt)) {
				mkdir('uploads/dtr/'.$this->session->userdata('region').'/'.$maxcnt, 0777, TRUE);
			}

		$error = array();

		$config = array(
				 'upload_path'   => 'uploads/dtr/'.$this->session->userdata('region').'/'.$maxcnt.'/',
				 'allowed_types' => '*',
				 'max_size'			 => '100000',
				 'overwrite'     => TRUE,
		 );

		$this->load->library('upload',$config);

		$counter = 0;

		for ($i=0; $i < count($_FILES['dtrattachment']['name']); $i++) {
			$_FILES['file']['name']      = $_FILES['dtrattachment']['name'][$i];
			$_FILES['file']['type']      = $_FILES['dtrattachment']['type'][$i];
			$_FILES['file']['tmp_name']  = $_FILES['dtrattachment']['tmp_name'][$i];
			$_FILES['file']['error']     = $_FILES['dtrattachment']['error'][$i];
			$_FILES['file']['size']      = $_FILES['dtrattachment']['size'][$i];

			$filename = date('ymdhs').$i.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $filename;

			$this->upload->initialize($config);

			if($this->upload->do_upload('file')){

				  $whereattachments = $this->db->where('adh.cnt = "'.$maxcnt.'"');
					$selectattachments = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.attachment_file','',$whereattachments);

					$setdata = array('with_attachments' => $category, 'attachment_file' => $config['file_name']."|".$selectattachments[0]['attachment_file'],);
					$wheredata = array('cnt' => $maxcnt, );
					$update = $this->Embismodel->updatedata($setdata, 'acc_dtr_horizontal', $wheredata);

					$whrroutedexst = $this->db->where('adr.con_cnt = "'.$maxcnt.'"');
					$chkroutedexst = $this->Embismodel->selectdata('acc_dtr_routed AS adr','adr.con_cnt','',$whrroutedexst);

					if(!empty($chkroutedexst[0]['con_cnt'])){
						$rsetdata = array('with_attachments' => $category, 'attachment_file' => $config['file_name']."|".$selectattachments[0]['attachment_file'],);
						$rwheredata = array('con_cnt' => $chkroutedexst[0]['con_cnt'], );
						$updaterouted = $this->Embismodel->updatedata($rsetdata,'acc_dtr_routed',$rwheredata);
					}

					chmod($config['upload_path'], 0777, TRUE); ## this should change the permissions

					$counter++;
					if($counter == '1'){
						echo json_encode(array('status' => 'success', 'datelog' => date('Y-m-d', strtotime($datelog)),));
					}

			}else{
				echo json_encode(array('status' => 'failed', 'datelog' => date('Y-m-d', strtotime($datelog)),));
			}
		}
	}else{
		echo json_encode(array('status' => 'empty',));
	}

	clearstatcache();
	}

	function removeuploadedfiledtr(){
		$cnt = $this->encrypt->decode($_POST['token']);
		$file = $this->encrypt->decode($_POST['file']);

		$wheredata = $this->db->where('adh.cnt = "'.$cnt.'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.punch_date_s,adh.attachment_file','',$wheredata);
		$explodedata = explode('|',$selectdata[0]['attachment_file']);

		// print_r($explodedata);  echo $this->encrypt->decode($_POST['file']); exit;
		$attachments = "";
		$cntr = 0;
		$counter = 0;
		for ($i=0; $i < sizeof($explodedata); $i++) {
			if(!empty($explodedata[$i])){
				$cntr++;
				if($explodedata[$i] != $file){
					$counter++;
					$attachments .= $explodedata[$i].'|';
				}
			}
		}

		$setdata = array('attachment_file' => $attachments, );
		$wheredata = array('cnt' => $cnt, );
		$updatedata = $this->Embismodel->updatedata($setdata,'acc_dtr_horizontal',$wheredata);
		if($updatedata){
			unlink(base_url().'uploads/dtr/'.$this->session->userdata('region').'/'.$cnt.'/'.$file);
		}
		if($updatedata){
			echo json_encode(array('status' => 'success', 'datelog' => $selectdata[0]['punch_date_s'], 'attachmentcntr' => $counter,));
		}else{
			echo json_encode(array('status' => 'failed', 'datelog' => $selectdata[0]['punch_date_s'], 'attachmentcntr' => $counter,));
		}
	}

	function savetimelog(){
		$datelog = $this->input->post('datelog');
		$timeinam = $this->input->post('inam');
		$timeoutam = $this->input->post('outam');
		$timeinpm = $this->input->post('inpm');
		$timeoutpm = $this->input->post('outpm');
		$attachmentcounter = $this->input->post('attachmentcounter');
		$remarks = $this->input->post('remarks');

		// print_r($_POST); exit;
		if(!empty($this->session->userdata('userid')) AND !empty($datelog)){
			if($attachmentcounter == '0'){
				$wheredatacntr = array('punch_date' => date('F d, Y', strtotime($datelog)), 'staff' => $this->session->userdata('userid'), );
				$setdatacntr = array('with_attachments' => '', );
				$updateattachmentcntr = $this->Embismodel->updatedata($setdatacntr, 'acc_dtr_horizontal', $wheredatacntr);
			}
			$whereflexi = array('ado.region' => $this->session->userdata('region'), );
			$selectflexi = $this->Embismodel->selectdata('acc_dtr_options AS ado','',$whereflexi);

			$am_hrsworked = "";
			$am_secondsworked = "";

			if(!empty($timeinam)){
				sscanf(date('H:i:s', strtotime($timeinam)), "%d:%d:%d", $tihours, $timinutes, $tiseconds);
				$timein_am_seconds = isset($tihours) ? $tihours * 3600 + $timinutes * 60 + $tiseconds : $timinutes * 60 + $tiseconds;
			}else{
				$timein_am_seconds = '00:00';
			}

			sscanf(date('H:i:s', strtotime($selectflexi[0]['earliest_in'])), "%d:%d:%d", $eihours, $eiminutes, $eiseconds);
			$earliest_in_seconds = isset($eihours) ? $eihours * 3600 + $eiminutes * 60 + $eiseconds : $eiminutes * 60 + $eiseconds;

			if(strtotime($timeinam) < strtotime($selectflexi[0]['earliest_in']) AND !empty($timeinam)){ //if early in start hours should be adjusted
				$startsecondslapseam = ($earliest_in_seconds - $timein_am_seconds);
				$timein_am_seconds = $timein_am_seconds + $startsecondslapseam;
			}

			if(!empty($timeoutam)){
				sscanf(date('H:i:s', strtotime($timeoutam)), "%d:%d:%d", $tohours, $tominutes, $toseconds);
				$timeout_am_seconds = isset($tohours) ? $tohours * 3600 + $tominutes * 60 + $toseconds : $tominutes * 60 + $toseconds;
			}else{
				$timeout_am_seconds = '00:00';
			}

			if(strtotime($timeinam) > strtotime($selectflexi[0]['latest_in'])){ //if beyond lastest time in - automatic half day
				$timein_am_seconds = '00:00';
				$timeout_am_seconds = '00:00';
			}

			sscanf("12:00:00", "%d:%d:%d", $ltohours, $ltominutes, $ltoseconds);
			$timeoutam_limit_seconds = isset($ltohours) ? $ltohours * 3600 + $ltominutes * 60 + $ltoseconds : $ltominutes * 60 + $ltoseconds;

			if(strtotime($timeoutam) > strtotime('12:00') AND strtotime($timeinam) < strtotime($selectflexi[0]['latest_in']) AND !empty($timeoutam)){ //check if early out for lunch
				$endsecondslapseam = ($timeout_am_seconds - $timeoutam_limit_seconds);
				$timeout_am_seconds = $timeout_am_seconds - $endsecondslapseam;
			}

			$am_secondsworked = $timeout_am_seconds - $timein_am_seconds;

			// echo $am_secondsworked.' - '.$timeout_am_seconds.' - '.$timein_am_seconds; exit;

			$pm_hrsworked = "";
			$pm_secondsworked = "";

			if(!empty($timeinpm)){
				sscanf(date('H:i:s', strtotime($timeinpm)), "%d:%d:%d", $tiphours, $tipminutes, $tipseconds);
				$timein_pm_seconds = isset($tiphours) ? $tiphours * 3600 + $tipminutes * 60 + $tipseconds : $tipminutes * 60 + $tipseconds;
			}else{
				$timein_pm_seconds = "00:00";
			}

			sscanf("13:00:00", "%d:%d:%d", $lipmhours, $lipmminutes, $lipmseconds);
			$limittimeinpm_in_seconds = isset($lipmhours) ? $lipmhours * 3600 + $lipmminutes * 60 + $lipmseconds : $lipmminutes * 60 + $lipmseconds;

			if(strtotime($timeinpm) < strtotime('13:00') AND !empty($timeinpm)){ //check if early out for lunch
			  $startsecondslapsepm = ($limittimeinpm_in_seconds - $timein_pm_seconds);
			  $timein_pm_seconds = $timein_pm_seconds + $startsecondslapsepm;
			}

			if(!empty($timeoutpm)){
				sscanf(date('H:i:s', strtotime($timeoutpm)), "%d:%d:%d", $tophours, $topminutes, $topseconds);
				$timeout_pm_seconds = isset($tophours) ? $tophours * 3600 + $topminutes * 60 + $topseconds : $topminutes * 60 + $topseconds;
			}else{
				$timeout_pm_seconds = "00:00";
			}

			sscanf(date('H:i:s', strtotime($selectflexi[0]['latest_out'])), "%d:%d:%d", $lopmhours, $lopmminutes, $lopmseconds);
			$latestoutpm_in_seconds = isset($lopmhours) ? $lopmhours * 3600 + $lopmminutes * 60 + $lopmseconds : $lopmminutes * 60 + $lopmseconds;

			if(strtotime($timeoutpm) > strtotime($selectflexi[0]['latest_out']) AND !empty($timeoutpm)){ //check if early out for lunch
			  $endsecondslapsepm = ($latestoutpm_in_seconds - $timeout_pm_seconds);
			  $timeout_pm_seconds = $timeout_pm_seconds + $endsecondslapsepm;
			}

			$pm_secondsworked = $timeout_pm_seconds - $timein_pm_seconds;

			// echo $pm_secondsworked.' - '.$timeout_pm_seconds.' - '.$timein_pm_seconds; exit;

			$total_secondsworked = $am_secondsworked + $pm_secondsworked;

			$am_hrsworked = gmdate("H:i:s", $am_secondsworked);
			$pm_hrsworked = gmdate("H:i:s", $pm_secondsworked);
			$total_hrsworked = gmdate("H:i:s", $total_secondsworked);

			$wherechkdatelog = array('adh.punch_date' => date('F d, Y', strtotime($datelog)), 'adh.staff' => $this->session->userdata('userid'),);
			$chkdatelog = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.cnt',$wherechkdatelog);

			if(!empty($chkdatelog[0]['cnt'])){
				$setdata = array(
						             'order_by' 			 => date('d', strtotime($datelog)),
					               'in' 						 => !empty($timeinam) ? date('h:i A', strtotime($timeinam)) : '00:00',
												 'out'             => !empty($timeoutam) ? date('h:i A', strtotime($timeoutam)) : '00:00',
												 'am_hrsworked'    => $am_hrsworked,
												 'in_pm' 					 => !empty($timeinpm) ? date('h:i A', strtotime($timeinpm)) : '00:00',
												 'out_pm' 				 => !empty($timeoutpm) ? date('h:i A', strtotime($timeoutpm)) : '00:00',
												 'pm_hrsworked' 	 => $pm_hrsworked,
												 'total_hrsworked' => $total_hrsworked,
												 'region' 			   => $this->session->userdata('region'),
												 'with_attachments'=> $remarks,
											  );
			  $wheredata = array('punch_date' => date('F d, Y', strtotime($datelog)), 'staff' => $this->session->userdata('userid'), );
				$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_horizontal', $wheredata);

				if($updatedata){
					echo json_encode(array('status' => 'success', ));
				}
			}else{
				$data = array(
										 'staff' 					 => $this->session->userdata('userid'),
										 'order_by' 			 => date('d', strtotime($datelog)),
										 'punch_date_s' 	 => $datelog,
										 'punch_date' 		 => date('F d, Y', strtotime($datelog)),
			               'in' 						 => !empty($timeinam) ? date('h:i A', strtotime($timeinam)) : '00:00',
										 'out'             => !empty($timeoutam) ? date('h:i A', strtotime($timeoutam)) : '00:00',
										 'am_hrsworked'    => $am_hrsworked,
										 'in_pm' 					 => !empty($timeinpm) ? date('h:i A', strtotime($timeinpm)) : '00:00',
										 'out_pm' 				 => !empty($timeoutpm) ? date('h:i A', strtotime($timeoutpm)) : '00:00',
										 'pm_hrsworked' 	 => $pm_hrsworked,
										 'total_hrsworked' => $total_hrsworked,
										 'with_attachments'=> $remarks,
										 'region' 			   => $this->session->userdata('region'),
										 'stat' 			     => 'Active',
									  );
				$insertdata = $this->Embismodel->insertdata('acc_dtr_horizontal', $data);

				if($insertdata){
					echo json_encode(array('status' => 'success', ));
				}
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function chkdtroptions(){
		$wheredata = array('ado.region' => $this->session->userdata('region'),);
		$selectdata = $this->Embismodel->selectdata('acc_dtr_options AS ado','',$wheredata);
		?>
			<div class="col-md-6">
				<label class="visibletext">* Earliest Time in</label>
				<input type="time" class="form-control" value="<?php echo !empty($selectdata[0]['earliest_in']) ? (date('H:i', strtotime($selectdata[0]['earliest_in']))) : ''; ?>" id="earliest_timein_">
			</div>
			<div class="col-md-6">
				<label class="visibletext">* Latest Time in</label>
				<input type="time" class="form-control" value="<?php echo !empty($selectdata[0]['latest_in']) ? (date('H:i', strtotime($selectdata[0]['latest_in']))) : ''; ?>" id="latest_timein_">
			</div>
			<div class="col-md-12"><hr /></div>
			<div class="col-md-6">
				<label class="visibletext">* Earliest Time out</label>
				<input type="time" class="form-control" value="<?php echo !empty($selectdata[0]['earliest_out']) ? (date('H:i', strtotime($selectdata[0]['earliest_out']))) : ''; ?>" id="earliest_timeout_">
			</div>
			<div class="col-md-6">
				<label class="visibletext">* Latest Time out</label>
				<input type="time" class="form-control" value="<?php echo !empty($selectdata[0]['latest_out']) ? (date('H:i', strtotime($selectdata[0]['latest_out']))) : ''; ?>"  id="latest_timeout_">
			</div>
		<?php
	}

	function savetimelogoptions(){

		if(!empty($_POST['earliest_in']) AND !empty($_POST['latest_in']) AND !empty($_POST['earliest_out']) AND !empty($_POST['latest_out'])){
			if((strtotime($_POST['earliest_in']) > strtotime('5:00') AND strtotime($_POST['earliest_in']) < strtotime($_POST['latest_in'])) AND (strtotime($_POST['latest_in']) > strtotime($_POST['earliest_in']) AND strtotime($_POST['latest_in']) < strtotime('12:00'))){
				if((strtotime($_POST['earliest_out']) > strtotime('13:00') AND strtotime($_POST['earliest_out']) < strtotime($_POST['latest_out'])) AND (strtotime($_POST['latest_out']) > strtotime($_POST['earliest_out']) AND strtotime($_POST['latest_out']) < strtotime('24:00'))){
					$wheredata = array('ado.region' => $this->session->userdata('region'), );
					$selectdata = $this->Embismodel->selectdata('acc_dtr_options AS ado','ado.cnt',$wheredata);
					if(!empty($selectdata[0]['cnt'])){
						$setdata = array(
									           'earliest_in'  => date('h:i A', strtotime($_POST['earliest_in'])),
														 'latest_in'    => date('h:i A', strtotime($_POST['latest_in'])),
														 'earliest_out' => date('h:i A', strtotime($_POST['earliest_out'])),
														 'latest_out'   => date('h:i A', strtotime($_POST['latest_out'])),
													  );
						$uwheredata = array('region' => $this->session->userdata('region'), );
						$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_options', $uwheredata);
						if($updatedata){
							echo json_encode(array('status' => 'success', ));
						}
					}else{
						$data = array(
							            'region'       => $this->session->userdata('region'),
													'earliest_in'  => date('h:i A', strtotime($_POST['earliest_in'])),
													'latest_in'    => date('h:i A', strtotime($_POST['latest_in'])),
													'earliest_out' => date('h:i A', strtotime($_POST['earliest_out'])),
													'latest_out'   => date('h:i A', strtotime($_POST['latest_out'])),
												 );
						$insertdata = $this->Embismodel->insertdata('acc_dtr_options',$data);
						if($insertdata){
							echo json_encode(array('status' => 'success', ));
						}
					}
				}else{
					echo json_encode(array('status' => 'failedpm', ));
				}
			}else{
				echo json_encode(array('status' => 'failedam', ));
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function cscformrange(){
		if(!empty($_POST['firstrange']) AND !empty($_POST['secondrange']) AND !empty($_POST['surpervisorselectize'])){
			$daterange = $_POST['firstrange'].'|'.$_POST['secondrange'].'|'.$_POST['surpervisorselectize']; ?>
			<a href="<?php echo base_url(); ?>dtr/pdf/<?php echo (!empty($_SESSION['filterdtr'])) ? $this->encrypt->encode($_SESSION['filterdtr'].'|'.$daterange) : $this->encrypt->encode(date('Y-m').'|'.$daterange); ?>" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>&nbsp;Preview</a>
		<?php }else{ ?>
			<button type="button" class="btn btn-success btn-sm" disabled><span class="fa fa-eye"></span>&nbsp;Preview</button>
		<?php }
	}

	function viewdtrattachments(){
		$token = $this->encrypt->decode($_POST['token']);
		$wherefiles = $this->db->where('adh.cnt = "'.$token.'"');
		$selectfiles = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.with_attachments, adh.attachment_file, adh.region, adh.cnt','',$wherefiles);
		?>
			<div class="row">
				<div class="col-md-12">
					<label>Type of Attachment(s):</label>
					<input type="text" class="form-control" value="<?php echo str_replace(',',', ',$selectfiles[0]['with_attachments']); ?>" readonly>
				</div>
				<div class="col-md-12">
					<hr>
					<?php
					  $explodedata = explode('|',$selectfiles[0]['attachment_file']);
						for ($i=0; $i < count($explodedata); $i++) {
							if(!empty($explodedata[$i])){
				  ?>
					<div style="display:flex;margin-bottom: 5px;">
						<input type="text" class="form-control" value="<?php echo $explodedata[$i]; ?>" disabled="">
						<a href="<?php echo base_url().'uploads/dtr/'.$selectfiles[0]['region'].'/'.$selectfiles[0]['cnt'].'/'.$explodedata[$i]; ?>" target="_blank" type="button" class="btn btn-info btn-sm" style="margin-left: 5px;width: 10%;"><span class="fa fa-eye"></span></a>
					</div>
				<?php } } ?>
				</div>
			</div>
		<?php
	}

	function generatedtrrange(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$wheredata = $this->db->where('adh.staff = "'.$this->session->userdata('userid').'" AND adh.punch_date_s BETWEEN "'.$from.'" AND "'.$to.'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','','',$wheredata);

		if(!empty($selectdata[0]['cnt'])){
		?>
			<hr />
			<table class="table table-hover table-striped" id="dtrlogs_route_table" width="100%" cellspacing="0" style="margin-top:0px;font-weight: 100;zoom: 80%;text-align:center;">
				<thead>
					<tr>
						<th style="width: 8%;text-align: center;">
							<input type="checkbox" id="checkalldtrroute" onclick="checkalldtrroute();">
							<span>&nbsp;Check all</span>
						</th>
						<th>Date Log</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Total Hrs. Worked</th>
						<th>Undertime (mins)</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i=0; $i < sizeof($selectdata); $i++) {

						$con_h = (date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
						$con_i = (date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
						if(empty($selectdata[$i]['total_hrsworked'])){
							$total_hrsworked = '--:--';
						}else{
							if($selectdata[$i]['total_hrsworked'] == '00:00:00'){
								$total_hrsworked = '--:--';
							}else{
								$total_hrsworked = date('g',strtotime($selectdata[$i]['total_hrsworked'])).' hour'.$con_h.' and '.date('i',strtotime($selectdata[$i]['total_hrsworked'])).' minute'.$con_i;
							}
						}

						if(strtotime($selectdata[$i]['total_hrsworked']) >= strtotime('08:00:00')){
							$total_hrsworkedu = "08:00:00";
						}else{
							$total_hrsworkedu = $selectdata[$i]['total_hrsworked'];
						}

						sscanf($total_hrsworkedu, "%d:%d:%d", $thwhours, $thwminutes, $thwseconds);
						$total_hrsworked_seconds = isset($thwhours) ? $thwhours * 3600 + $thwminutes * 60 + $thwseconds : $thwminutes * 60 + $thwseconds;

						sscanf("08:00:00", "%d:%d:%d", $bhwhours, $bhwminutes, $bhwseconds);
						$basehrsworked_seconds = isset($bhwhours) ? $bhwhours * 3600 + $bhwminutes * 60 + $bhwseconds : $bhwminutes * 60 + $bhwseconds;

						$undertimeinsec = $basehrsworked_seconds - $total_hrsworked_seconds;
						$undertimetotal = $undertimeinsec / 60;

						$viewattachments = empty($selectdata[$i]['with_attachments']) ? '--' :
						'<div class="dropdown">
						  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%!important;" onclick=viewrouteddtrattachments("'.$this->encrypt->encode($selectdata[$i]['cnt']).'");>
						    View Attachment(s)
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%!important;" id="viewrouteddtrattachments_">

						  </div>
						</div>';
						?>
						<tr>
							<td style="width: 8%;text-align: center;">
								<input type="checkbox" class="token" name="token[]" value="<?php echo  $this->encrypt->encode($selectdata[$i]['cnt']); ?>">
							</td>
							<td><?php echo  $selectdata[$i]['punch_date']; ?></td>
							<td><?php echo  ($selectdata[$i]['in'] == '00:00') ? '--:--' : $selectdata[$i]['in']; ?></td>
							<td><?php echo  ($selectdata[$i]['out'] == '00:00') ? '--:--' : $selectdata[$i]['out']; ?></td>
							<td><?php echo  ($selectdata[$i]['in_pm'] == '00:00') ? '--:--' : $selectdata[$i]['in_pm']; ?></td>
							<td><?php echo  ($selectdata[$i]['out_pm'] == '00:00') ? '--:--' : $selectdata[$i]['out_pm']; ?></td>
							<td><?php echo  $total_hrsworked; ?></td>
							<td><?php echo  !empty($undertimetotal) ? $undertimetotal.' minute(s)' : '--'; ?></td>
							<td><?php echo $selectdata[$i]['with_attachments']; ?></td>
							<td><?php echo $viewattachments; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php
		}else{ ?>
			<hr />
			<center>
				<span>No data available</span>
			</center>
		<?php }
	}

	function cscform48(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$signatory = $this->input->post('signatory');
		$datetoday = date('Y-m');

		$data = $this->encrypt->encode($datetoday.'|'.$from.'|'.$to.'|'.$signatory);
		?>
			<label class="visibletext">CSC FORM 48:</label>
			<a href="<?php echo base_url().'dtr/pdf/'.$data; ?>" type="button" target="_blank" class="btn btn-danger btn-sm" style="width:100%;height:34px;" disabled><span class="fa fa-eye"></span>&nbsp;Preview to Print</a>
		<?php
	}

	function cscform48prev(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		?>
			<a type="button" class="btn btn-success btn-sm" style="color:#FFFFFF;width: 100%;margin-top: 30px;font-size: 12pt;" onclick="prevempdtrrng('<?php echo $this->encrypt->encode($from); ?>','<?php echo $this->encrypt->encode($to); ?>');">PREVIEW ALL DTR</a>
		<?php
	}

	function prevempdtrrng(){
		$from = $this->encrypt->decode($this->input->post('from'));
		$to = $this->encrypt->decode($this->input->post('to'));
		$whereusersdata = $this->db->where('adh.stat = "Active" AND adh.punch_date_s BETWEEN "'.$from.'" AND "'.$to.'" AND adh.region = "'.$this->session->userdata('region').'" GROUP BY adh.staff');
		$joindata = $this->db->join('acc_credentials AS acs','acs.userid = adh.staff','left');
		$selectusers = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','adh.staff, acs.fname, acs.mname, acs.sname, acs.suffix, acs.division, acs.section, acs.token','',$joindata,$whereusersdata);
		// echo $this->db->last_query(); exit;
		?><br /><hr />
			<table id="emptableprevdtr" class="table table-striped" style="width:100%;zoom: 85%;">
				<thead>
					<tr>
						<th>Employee Name</th>
						<th>Division</th>
						<th>Section</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < sizeof($selectusers); $i++) {
						if(!empty($selectusers[$i]['staff'])){
						 $mname = !empty($selectusers[$i]['mname']) ? $selectusers[$i]['mname'][0].'. ' : '';
						 $suffix = !empty($selectusers[$i]['suffix']) ? ' '.$selectusers[$i]['suffix'] : '';
						 $name = $selectusers[$i]['fname'].' '.$mname.$selectusers[$i]['sname'].$suffix;
						 $token = $selectusers[$i]['token'].'$'.$from.'$'.$to;
					?>
						<tr>
							<td><?php echo $name; ?></td>
							<td><?php echo $selectusers[$i]['division']; ?></td>
							<td><?php echo $selectusers[$i]['section']; ?></td>
							<td>
									<a type="button" href="<?php echo base_url().'dtr/pdfprev/?token='.$token; ?>" target="_blank" class="btn btn-success btn-sm" style="width: 100%;font-size: 12pt;">PREVIEW DTR</a>
							</td>
						</tr>
						<?php }?>
					<?php } ?>
				</tbody>
			</table>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#emptableprevdtr').DataTable();
				} );
			</script>
		<?php
	}

	function routedtrselected(){
		// echo "<pre>";
		// print_r($_POST);
		date_default_timezone_set("Asia/Manila");
		$from = $_POST['from'];
		$to = $_POST['to'];
		$routeto = $this->encrypt->decode($_POST['routeto']);
		$signatory = $this->encrypt->decode($_POST['signatory']);
		$dtr_span = date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to));
		$token = $_POST['token'][0];
		$explode = explode(',',$token);
		$datetoday = date('F d, Y h:ia');
		$cntrchkr = 0;
		for ($cc=0; $cc < count($explode); $cc++) {
			if(!empty($explode[$cc])){ $cntrchkr++; }
		}

		if($cntrchkr == 0){
			echo json_encode(array('status' => 'nodata', ));
		}else{
			$newtrans = $this->Transmodel->newtrans();

			if(!empty($newtrans)){
				$wheretranstoken = $this->db->where('er.trans_no = "'.$newtrans.'"');
				$selecttranstoken = $this->Embismodel->selectdata('er_transactions AS er','er.token, er.trans_no','',$wheretranstoken);
			}

			$whererouteto = $this->db->where('acs.userid = "'.$routeto.'"');
			$selectrouteto = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$whererouteto);
			$routetomname = !empty($selectrouteto[0]['mname']) ? $selectrouteto[0]['mname'][0].'. ' : '';
			$routetosuffix = !empty($selectrouteto[0]['suffix']) ? ' '.$selectrouteto[0]['suffix'] : '';
			$routetotitle = !empty($selectrouteto[0]['title']) ? ' '.$selectrouteto[0]['title'].' ' : '';
			$routetoname = $routetotitle.$selectrouteto[0]['fname'].' '.$routetomname.$selectrouteto[0]['sname'].$routetosuffix;

			$wheresignatory = $this->db->where('acs.userid = "'.$signatory.'"');
			$selectsignatory = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$wheresignatory);
			$signatorymname = !empty($selectsignatory[0]['mname']) ? $selectsignatory[0]['mname'][0].'. ' : '';
			$signatorysuffix = !empty($selectsignatory[0]['suffix']) ? ' '.$selectsignatory[0]['suffix'] : '';
			$signatorytitle = !empty($selectsignatory[0]['title']) ? ' '.$selectsignatory[0]['title'].' ' : '';
			$signatoryname = $signatorytitle.$selectsignatory[0]['fname'].' '.$signatorymname.$selectsignatory[0]['sname'].$signatorysuffix;

			$counter = 0;
			$totalundertimemins = 0;
			for ($i=0; $i < count($explode); $i++) {
				if(!empty($explode[$i])){

					$cnt = $this->encrypt->decode($explode[$i]);
					$wheredata = $this->db->where('adh.cnt = "'.$cnt.'"');
					$selectdata = $this->Embismodel->selectdata('acc_dtr_horizontal AS adh','','',$wheredata);

					if(strtotime($selectdata[0]['total_hrsworked']) >= strtotime('08:00:00')){
						$total_hrsworkedu = "08:00:00";
					}else{
						$total_hrsworkedu = $selectdata[0]['total_hrsworked'];
					}

					sscanf($total_hrsworkedu, "%d:%d:%d", $thwhours, $thwminutes, $thwseconds);
					$total_hrsworked_seconds = isset($thwhours) ? $thwhours * 3600 + $thwminutes * 60 + $thwseconds : $thwminutes * 60 + $thwseconds;

					sscanf("08:00:00", "%d:%d:%d", $bhwhours, $bhwminutes, $bhwseconds);
					$basehrsworked_seconds = isset($bhwhours) ? $bhwhours * 3600 + $bhwminutes * 60 + $bhwseconds : $bhwminutes * 60 + $bhwseconds;

					$undertimeinsec = $basehrsworked_seconds - $total_hrsworked_seconds;
					$undertimemins = $undertimeinsec / 60;
					$totalundertimemins += $undertimemins;
					$data = array(
												'trans_no' => $selecttranstoken[0]['token'],
											  'staff' => $selectdata[0]['staff'],
												'staff_name' => $_SESSION['name'],
												'order_by' => $selectdata[0]['order_by'],
												'punch_date_s' => $selectdata[0]['punch_date_s'],
												'punch_date' => $selectdata[0]['punch_date'],
												'in' => $selectdata[0]['in'],
												'out' => $selectdata[0]['out'],
												'am_hrsworked' => $selectdata[0]['am_hrsworked'],
												'in_pm' => $selectdata[0]['in_pm'],
												'out_pm' => $selectdata[0]['out_pm'],
												'pm_hrsworked' => $selectdata[0]['pm_hrsworked'],
												'total_hrsworked' => $selectdata[0]['total_hrsworked'],
												'undertime' => $undertimemins,
												'with_attachments' => $selectdata[0]['with_attachments'],
												'attachment_file' => $selectdata[0]['attachment_file'],
												'region' => $selectdata[0]['region'],
												'con_cnt' => $selectdata[0]['cnt'],
												'dtr_span' => $dtr_span,
												'date_submitted' => $datetoday,
												'status' => 'For approval',
												'routedto_userid' => $routeto,
												'routedto_name' => $routetoname,
												'signatory' => $signatoryname,
												'signatory_userid' => $signatory,
											 );
					$insertdata = $this->Embismodel->insertdata('acc_dtr_routed',$data);


					if($insertdata){
						$setdata = array('undertime_total' => $totalundertimemins, );
						$wheredata = array('trans_no' => $selecttranstoken[0]['token'],);
						$updatedata = $this->Embismodel->updatedata($setdata,'acc_dtr_routed',$wheredata);
						$counter++;
					}

					// echo "<pre>";
					// print_r($data);
				}
			}

			if($counter > 0){

				$datahistory = array(
														 'trans_no' => $selecttranstoken[0]['token'],
														 'staff' => $selectdata[0]['staff'],
														 'staff_name' => $_SESSION['name'],
														 'status' => 'For approval',
														 'routedto_userid' => $routeto,
														 'routedto_name' => $routetoname,
														 'date_routed' => $datetoday,
														);
				$insertdatahistory = $this->Embismodel->insertdata('acc_dtr_routed_history',$datahistory);

				$this->update_er_trans($selecttranstoken[0]['trans_no'],$routeto,$routetoname);


			 // print_r($datahistory);

				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}
	}

	function update_er_trans($trans_no,$routetouserid,$routetofullname){
		if(!empty($trans_no)){
			$ip_address = $this->input->ip_address();
			$random        = str_split('QWERTYUIOP12345678'); shuffle($random);
			$randomkey     = array_slice($random, 0, 18);
			$key = implode('', $randomkey);
			$paded = str_pad($key, 18, '0', STR_PAD_LEFT);
			$delimited = '';
			for($i = 0; $i < 18; $i++) {
			 $delimited .= $paded[$i];
			 if($i == 2 || $i == 5 || $i == 8 || $i == 11 || $i == 14) {
					 $delimited .= '-';
			 }
			}

			$whereusertoberouted = $this->db->where('acs.userid = "'.$routetouserid.'"');
			$selectusertoberouted = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token, acs.divno, acs.secno, acs.region','',$whereusertoberouted);

			$whereembdesig = $this->db->where('tcd.region = "'.$this->session->userdata('region').'"');
			$selectembdesig = $this->Embismodel->selectdata('to_company_designation AS tcd','','',$whereembdesig);

			$setdata = array(
											'route_order' => '1',
											'company_token' => $selectembdesig[0]['token'],
											'company_name' => $selectembdesig[0]['company_name'],
											'emb_id' => $selectembdesig[0]['emb_id'],
											'subject' => 'e-DAILY TIME RECORD - '.$_SESSION['name'],
											'system' => '2',
											'type' => '166',
											'type_description' => 'e-DAILY TIME RECORD',
											'status' => '15',
											'status_description' => 'for approval',
											'receive' => '0',
											'receiver_division' => $selectusertoberouted[0]['divno'],
											'receiver_section' => $selectusertoberouted[0]['secno'],
											'receiver_region' => $selectusertoberouted[0]['region'],
											'receiver_id' => $selectusertoberouted[0]['token'],
											'receiver_name' => $routetofullname,
											'action_taken' => 'Pls. for approval',
											'remarks' => '',
											'qr_code_token' => $delimited,
											);
			$wheredata = array(
											'trans_no' => $trans_no,
											);
			$updatedata = $this->Embismodel->updatedata($setdata, 'er_transactions',$wheredata);

			$setdatalog = array(
					                'route_order' => '1',
													'subject' => 'e-DAILY TIME RECORD - '.$_SESSION['name'],
													'sender_ipadress' => $ip_address,
													'receiver_divno' => $selectusertoberouted[0]['divno'],
													'receiver_secno' => $selectusertoberouted[0]['secno'],
													'receiver_id' => $selectusertoberouted[0]['token'],
													'receiver_name' => $routetofullname,
													'receiver_region' => $selectusertoberouted[0]['region'],
													'type' => '166',
													'status' => '15',
													'status_description' => 'for approval',
													'action_taken' => 'Pls. for approval',
													'remarks' => '',
													'date_out' => date('Y-m-d H:i:s'),
												 );
			$wheredatalog = array(
														'trans_no' => $trans_no,
						               );
			$updatedatalog = $this->Embismodel->updatedata($setdatalog,'er_transactions_log',$wheredatalog);
			// echo "<pre>";
			// print_r($setdata);
			// print_r($wheredata);
			// print_r($setdatalog);
			// print_r($wheredatalog);
		}
	}

	function routed_dtr_details(){
		$trans_no = $this->encrypt->decode($this->input->post('token'));
		$wheredata = $this->db->where('adr.trans_no = "'.$trans_no.'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_routed AS adr','',$wheredata);
	  ?>
			<div class="row">
				<div class="col-md-4">
					<label>IIS No.</label>
					<input type="text" class="form-control" value="<?php echo $selectdata[0]['trans_no']; ?>" readonly>
				</div>
				<div class="col-md-4">
					<label>Subject</label>
					<input type="text" class="form-control" value="<?php echo $selectdata[0]['dtr_span']; ?>" readonly>
				</div>
				<div class="col-md-4">
					<label>Date Submitted</label>
					<input type="text" class="form-control" value="<?php echo $selectdata[0]['date_submitted']; ?>" readonly>
				</div>
				<div class="col-md-12"><hr /></div>
			</div>
			<table id="dtr_routed_full_details" class="table table-striped" style="width:100%;zoom: 80%;font-weight: 100;text-align:center;">
				<thead>
					<tr>
						<th>Date log</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Hrs. Worked</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Hrs. Worked</th>
						<th>Total Hrs. Worked</th>
						<th>Undertime (mins)</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i=0; $i < sizeof($selectdata); $i++) {
						$timeinam = (empty($selectdata[$i]['in']) OR $selectdata[$i]['in'] == '00:00') ? '--:--': $selectdata[$i]['in'];
						$timeoutam = (empty($selectdata[$i]['out']) OR $selectdata[$i]['out'] == '00:00') ? '--:--': $selectdata[$i]['out'];

						$con_h_am = (date('h',strtotime($selectdata[$i]['am_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['am_hrsworked'])) > 1) ? 's' : '';
						$con_i_am = (date('i',strtotime($selectdata[$i]['am_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['am_hrsworked'])) > 1) ? 's' : '';
						$am_hrsworked = (empty($selectdata[$i]['am_hrsworked']) OR $selectdata[$i]['am_hrsworked'] == '00:00:00') ? '--:--':
						date('g',strtotime($selectdata[$i]['am_hrsworked'])).' hour'.$con_h_am.' and '.date('i',strtotime($selectdata[$i]['am_hrsworked'])).' minute'.$con_i_am;

						$timeinpm = (empty($selectdata[$i]['in_pm']) OR $selectdata[$i]['in_pm'] == '00:00') ? '--:--': $selectdata[$i]['in_pm'];
						$timeoutpm = (empty($selectdata[$i]['out_pm']) OR $selectdata[$i]['out_pm'] == '00:00') ? '--:--': $selectdata[$i]['out_pm'];

						$con_h_pm = (date('h',strtotime($selectdata[$i]['pm_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['pm_hrsworked'])) > 1) ? 's' : '';
						$con_i_pm = (date('i',strtotime($selectdata[$i]['pm_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['pm_hrsworked'])) > 1) ? 's' : '';
						$pm_hrsworked = (empty($selectdata[$i]['pm_hrsworked']) OR $selectdata[$i]['pm_hrsworked'] == '00:00:00') ? '--:--':
						date('g',strtotime($selectdata[$i]['pm_hrsworked'])).' hour'.$con_h_pm.' and '.date('i',strtotime($selectdata[$i]['pm_hrsworked'])).' minute'.$con_i_pm;

						$con_h = (date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
						$con_i = (date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
						$total_hrsworked = (empty($selectdata[$i]['total_hrsworked']) OR $selectdata[$i]['total_hrsworked'] == '00:00:00') ? '--:--' :
						date('g',strtotime($selectdata[$i]['total_hrsworked'])).' hour'.$con_h.' and '.date('i',strtotime($selectdata[$i]['total_hrsworked'])).' minute'.$con_i;
						$withattachments = empty($selectdata[$i]['with_attachments']) ? '--' : str_replace(',',', ',$selectdata[$i]['with_attachments']);
						$viewattachments = empty($selectdata[$i]['with_attachments']) ? '--' :
						'<div class="dropdown">
						  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%!important;" onclick=viewrouteddtrattachments("'.$this->encrypt->encode($selectdata[$i]['con_cnt']).'","'.$i.'");>
						    View Attachment(s)
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%!important;" id="viewrouteddtrattachments_'.$i.'">

						  </div>
						</div>';
				  ?>
						<tr>
							<td><?php echo $selectdata[$i]['punch_date']; ?></td>
							<td><?php echo $timeinam; ?></td>
							<td><?php echo $timeoutam; ?></td>
							<td><?php echo $am_hrsworked; ?></td>
							<td><?php echo $timeinpm; ?></td>
							<td><?php echo $timeoutpm; ?></td>
							<td><?php echo $pm_hrsworked; ?></td>
							<td><?php echo $total_hrsworked; ?></td>
							<td><?php echo ($selectdata[$i]['undertime'] == 0) ? '--' : $selectdata[$i]['undertime'].' minute(s)'; ?></td>
							<td><?php echo $withattachments; ?></td>
							<td><?php echo $viewattachments; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#dtr_routed_full_details').DataTable({
						responsive: true,
			      language: {
			        "infoFiltered": "",
			      },
						"lengthMenu": [[31, 50, 100, -1], [31, 50, 100, "All"]]
					});
				} );
			</script>
		<?php
	}

	function checkrouted_dtr_details(){
		$trans_no = $this->encrypt->decode($this->input->post('token'));
		$wheredata = $this->db->where('adr.trans_no = "'.$trans_no.'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_routed AS adr','',$wheredata);

		$wheredtrhist = $this->db->where('adh.trans_no = "'.$trans_no.'" AND adh.cnt = (SELECT MAX(adh2.cnt) FROM acc_dtr_routed_history AS adh2 WHERE adh2.trans_no = "'.$trans_no.'")');
		$selectdtrhist = $this->Embismodel->selectdata('acc_dtr_routed_history AS adh','adh.staff, adh.staff_name, adh.remarks','',$wheredtrhist);

		$orderbyusers = $this->db->order_by('acs.fname','asc');
		$whereusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.userid != "1"');
		$users = $this->Administrativemodel->select_employees($whereusers,$orderbyusers);
	  ?>
			<div class="row">
				<input type="hidden" class="form-control" value="<?php echo $this->encrypt->encode($selectdata[0]['trans_no']); ?>" id="checkrouted_dtr_token">
				<div class="col-md-6">
					<label>IIS No.</label>
					<input type="text" class="form-control" value="<?php echo $selectdata[0]['trans_no']; ?>" readonly>
				</div>
				<div class="col-md-6">
					<label>Date Submitted</label>
					<input type="text" class="form-control" value="<?php echo $selectdata[0]['date_submitted']; ?>" readonly>
				</div>
				<div class="col-md-6">
					<label>For the month of</label>
					<input type="text" class="form-control" value="<?php echo $selectdata[0]['dtr_span']; ?>" readonly>
				</div>
				<div class="col-md-6">
					<label>Employee</label>
					<input type="text" class="form-control" value="<?php echo $selectdtrhist[0]['staff_name']; ?>" readonly>
				</div>
				<?php if(!empty($selectdtrhist[0]['remarks'])){ ?>
					<div class="col-md-12">
						<label>Remarks</label>
						<textarea class="form-control" rows="8" cols="80" readonly><?php echo $selectdtrhist[0]['remarks']; ?></textarea>
					</div>
				<?php } ?>
				<div class="col-md-12"><hr /></div>
			</div>
			<table id="checkdtr_routed_full_details" class="table table-striped" style="width:100%;zoom: 90%;font-weight: 100;text-align:center;">
				<thead>
					<tr>
						<th>#</th>
						<th>Date log</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Hrs. Worked</th>
						<th>Time In</th>
						<th>Time Out</th>
						<th>Hrs. Worked</th>
						<th>Total Hrs. Worked</th>
						<th>Undertime (mins)</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $cntr = 0; for ($i=0; $i < sizeof($selectdata); $i++) { $cntr++;
						$timeinam = (empty($selectdata[$i]['in']) OR $selectdata[$i]['in'] == '00:00') ? '--:--': $selectdata[$i]['in'];
						$timeoutam = (empty($selectdata[$i]['out']) OR $selectdata[$i]['out'] == '00:00') ? '--:--': $selectdata[$i]['out'];

						$con_h_am = (date('h',strtotime($selectdata[$i]['am_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['am_hrsworked'])) > 1) ? 's' : '';
						$con_i_am = (date('i',strtotime($selectdata[$i]['am_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['am_hrsworked'])) > 1) ? 's' : '';
						$am_hrsworked = (empty($selectdata[$i]['am_hrsworked']) OR $selectdata[$i]['am_hrsworked'] == '00:00:00') ? '--:--':
						date('g',strtotime($selectdata[$i]['am_hrsworked'])).' hour'.$con_h_am.' and '.date('i',strtotime($selectdata[$i]['am_hrsworked'])).' minute'.$con_i_am;

						$timeinpm = (empty($selectdata[$i]['in_pm']) OR $selectdata[$i]['in_pm'] == '00:00') ? '--:--': $selectdata[$i]['in_pm'];
						$timeoutpm = (empty($selectdata[$i]['out_pm']) OR $selectdata[$i]['out_pm'] == '00:00') ? '--:--': $selectdata[$i]['out_pm'];

						$con_h_pm = (date('h',strtotime($selectdata[$i]['pm_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['pm_hrsworked'])) > 1) ? 's' : '';
						$con_i_pm = (date('i',strtotime($selectdata[$i]['pm_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['pm_hrsworked'])) > 1) ? 's' : '';
						$pm_hrsworked = (empty($selectdata[$i]['pm_hrsworked']) OR $selectdata[$i]['pm_hrsworked'] == '00:00:00') ? '--:--':
						date('g',strtotime($selectdata[$i]['pm_hrsworked'])).' hour'.$con_h_pm.' and '.date('i',strtotime($selectdata[$i]['pm_hrsworked'])).' minute'.$con_i_pm;

						$con_h = (date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
						$con_i = (date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
						$total_hrsworked = (empty($selectdata[$i]['total_hrsworked']) OR $selectdata[$i]['total_hrsworked'] == '00:00:00') ? '--:--' :
						date('g',strtotime($selectdata[$i]['total_hrsworked'])).' hour'.$con_h.' and '.date('i',strtotime($selectdata[$i]['total_hrsworked'])).' minute'.$con_i;

						$withattachments = empty($selectdata[$i]['with_attachments']) ? '--' : str_replace(',',', ',$selectdata[$i]['with_attachments']);
						$viewattachments = empty($selectdata[$i]['with_attachments']) ? '--' :
						'<div class="dropdown">
						  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%!important;" onclick=viewrouteddtrattachments("'.$this->encrypt->encode($selectdata[$i]['con_cnt']).'");>
						    View Attachment(s)
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%!important;" id="viewrouteddtrattachments_">

						  </div>
						</div>';
						// $undertime = ($selectdata[$i]['undertime'] == 0) ? 0 : $selectdata[$i]['undertime'];
				  ?>
						<tr>
							<td><?php echo $cntr; ?></td>
							<td><?php echo $selectdata[$i]['punch_date']; ?></td>
							<td><?php echo $timeinam; ?></td>
							<td><?php echo $timeoutam; ?></td>
							<td><?php echo $am_hrsworked; ?></td>
							<td><?php echo $timeinpm; ?></td>
							<td><?php echo $timeoutpm; ?></td>
							<td><?php echo $pm_hrsworked; ?></td>
							<td><?php echo $total_hrsworked; ?></td>

							<td><?php echo '<input type="number" onkeyup=alterundertime("'.$this->encrypt->encode($selectdata[$i]['cnt']).'",this.value,"'.$this->encrypt->encode($selectdata[$i]['trans_no']).'"); value="'.$selectdata[$i]['undertime'].'" />'; ?></td>
							<td><?php echo $withattachments; ?></td>
							<td><?php echo $viewattachments; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="row">
					<div class="col-md-12"><hr /></div>
					<div class="col-md-4">
						<label class="visibletext">* No of Days Worked:</label>
						<input type="number" class="form-control" id="dtrdaysworked" value="<?php echo $selectdata[0]['p_days_worked']; ?>">
					</div>
					<div class="col-md-4">
						<label class="visibletext">* Route document to:</label>
						<select class="form-control" id="rdocprocessselectize">
						  <option value="">-</option>
							<?php for ($i=0; $i < sizeof($users); $i++) {
								$mname = !empty($users[$i]['mname']) ? $users[$i]['mname'][0].'. ' : '';
								$suffix = !empty($users[$i]['suffix']) ? ' '.$users[$i]['suffix'] : '';
								$title = !empty($users[$i]['title']) ? $users[$i]['title'].' ' : '';
								$name = $title.$users[$i]['fname'].' '.$mname.$users[$i]['sname'].$suffix;
							?>
								<option value="<?php echo $this->encrypt->encode($users[$i]['userid']); ?>"><?php echo $name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="visibletext">* Status:</label>
						<select class="form-control" id="statusprocessselectize">
							<option value="">-</option>
							<option value="<?php echo $this->encrypt->encode('For approval'); ?>">For approval</option>
							<option value="<?php echo $this->encrypt->encode('For payroll'); ?>">For payroll</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="visibletext">Remarks:</label>
						<textarea id="remarksroutedtrr" class="form-control" rows="8" cols="80"></textarea>
					</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#checkdtr_routed_full_details').DataTable({
						responsive: true,
			      language: {
			        "infoFiltered": "",
			      },
						"lengthMenu": [[31, 50, 100, -1], [31, 50, 100, "All"]]
					});
				} );
				$('#rdocprocessselectize').selectize();
				$('#statusprocessselectize').selectize();
			</script>
	<?php }

	function approve_routed_dtr_details(){
		date_default_timezone_set("Asia/Manila");
		$datetoday = date('F d, Y h:ia');
		$trans_no = $this->encrypt->decode($this->input->post('token'));
		$routeto = $this->encrypt->decode($this->input->post('routeto'));
		$stat = $this->encrypt->decode($this->input->post('stat'));
		$remarks = ($this->input->post('remarks'));
		$daysworked = ($this->input->post('daysworked'));
		// echo json_encode(array('status' => 'success', )); exit;
		// echo $trans_no.' '.$routeto.' '.$stat.' '.$remarks; exit;

		if(!empty($trans_no) AND !empty($routeto) AND !empty($stat) AND !empty($daysworked)){
			$whereuserdetails = $this->db->where('acs.userid = "'.$routeto.'"');
			$selectuserdetails = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$whereuserdetails);

			$mname = !empty($selectuserdetails[0]['mname']) ? $selectuserdetails[0]['mname'][0].'. ' : '';
			$suffix = !empty($selectuserdetails[0]['suffix']) ? ' '.$selectuserdetails[0]['suffix'] : '';
			$title = !empty($selectuserdetails[0]['title']) ? $selectuserdetails[0]['title'].' ' : '';
			$routename = $title.$selectuserdetails[0]['fname'].' '.$mname.$selectuserdetails[0]['sname'].$suffix;

			$whereaddinfo = $this->db->where('adr.trans_no = "'.$trans_no.'" GROUP BY adr.trans_no');
			$joinaddinfo = $this->db->join('acc_additional_info AS aai','aai.userid = adr.staff','left');
			$selectaddinfo = $this->Embismodel->selectdata('acc_dtr_routed AS adr','aai.*','',$whereaddinfo);

			$setdata = array(
												'status' => $stat,
												'routedto_userid' => $routeto,
												'routedto_name' => $routename,
												'p_days_worked' => $daysworked,
												'p_daily_rate' => !empty($selectaddinfo[0]['daily_rate']) ? $selectaddinfo[0]['daily_rate'] : '',
												'p_total_addon' => !empty($selectaddinfo[0]['add_on_total']) ? $selectaddinfo[0]['add_on_total'] : '',
												'p_total_deductions' => !empty($selectaddinfo[0]['deduction_total']) ? $selectaddinfo[0]['deduction_total'] : '',
											);
			$wheredata = array('trans_no' => $trans_no, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_routed', $wheredata);

			if(!empty($selectaddinfo[0]['add_on_details'])){
				$explodeaddondetails = explode('||',$selectaddinfo[0]['add_on_details']);
				for ($aod=0; $aod < count($explodeaddondetails); $aod++) {
					if(!empty($explodeaddondetails[$aod])){
						$explodeaod = explode('|',$explodeaddondetails[$aod]);
						$aodinsert = array(
																'trans_no' => $trans_no,
																'add_on_details' => $explodeaod[0],
																'add_on_value' => $explodeaod[1],
															);
						$insertaod = $this->Embismodel->insertdata('acc_dtr_add_on_history',$aodinsert);
					}
				}
			}

			if(!empty($selectaddinfo[0]['deduction_details'])){
				$explodedeductiondetails = explode('||',$selectaddinfo[0]['deduction_details']);
				for ($ded=0; $ded < count($explodedeductiondetails); $ded++) {
					if(!empty($explodedeductiondetails[$ded])){
						$explodeaod = explode('|',$explodedeductiondetails[$ded]);
						$dedinsert = array(
																'trans_no' => $trans_no,
																'deduction_details' => $explodeaod[0],
																'deduction_value' => $explodeaod[1],
															);
						$insertded = $this->Embismodel->insertdata('acc_dtr_deduction_history',$dedinsert);
					}
				}
			}

			$data = array(
				            'trans_no' => $trans_no,
										'staff' => $_SESSION['userid'],
										'staff_name' => $_SESSION['name'],
										'status' => $stat,
										'routedto_userid' => $routeto,
										'routedto_name' => $routename,
										'date_routed' => $datetoday,
										'remarks' => $remarks,
									 );
			$insertdata = $this->Embismodel->insertdata('acc_dtr_routed_history', $data);



			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}else{
			echo json_encode(array('status' => 'missing fields', ));
		}
	}

	function alterundertime(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$val = $this->input->post('val');
		$transno = $this->encrypt->decode($this->input->post('transno'));
		// print_r($_POST); exit;
		if(!empty($token)){
			$setdata = array('undertime' => $val, );
			$wheredata = array('cnt' => $token, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_routed', $wheredata);

			$where = $this->db->where('adr.trans_no = "'.$transno.'"');
			$selectdata = $this->Embismodel->selectdata('acc_dtr_routed AS adr','adr.undertime','',$where);

			$undertime_total = "";
			for ($i=0; $i < sizeof($selectdata); $i++) {
				if(!empty($selectdata[$i]['undertime'] > 0)){
					$undertime_total += $selectdata[$i]['undertime'];
				}
			}

			$set = array('undertime_total' => $undertime_total, );
			$whr = array('trans_no' => $transno, );
			$updatetotal = $this->Embismodel->updatedata($set,'acc_dtr_routed',$whr);
		}
	}

	function viewrouteddtrattachments(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$whereattachment = $this->db->where('adr.con_cnt = "'.$token.'"');
		$selectattachment = $this->Embismodel->selectdata('acc_dtr_routed AS adr','adr.attachment_file, adr.region','',$whereattachment);
		$explodedata = explode('|',$selectattachment[0]['attachment_file']);
		for ($i=0; $i < count($explodedata); $i++) {
			if(!empty($explodedata[$i])){
		?>
			<a class="dropdown-item" target="_blank" href="<?php echo base_url().'uploads/dtr/'.$selectattachment[0]['region'].'/'.$token.'/'.$explodedata[$i]; ?>"><?php echo $explodedata[$i]; ?></a>
		<?php
		  }
		}
	}

	function returntosenderdtr(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$wheredata = $this->db->where('adr.trans_no = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_routed AS adr','',$wheredata);

		$whereroutehistory = $this->db->where('ah.staff != "'.$this->session->userdata('userid').'" AND ah.trans_no = "'.$token.'" GROUP BY ah.staff ORDER BY ah.cnt DESC');
		$selectroutehistory = $this->Embismodel->selectdata('acc_dtr_routed_history AS ah','ah.staff_name, ah.staff','',$whereroutehistory);
		 ?>
		<div class="row">
			<div class="col-md-4">
				<label>IIS No.</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['trans_no']; ?>" readonly>
			</div>
			<div class="col-md-4">
				<label>Subject</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['dtr_span']; ?>" readonly>
			</div>
			<div class="col-md-4">
				<label>Date Submitted</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['date_submitted']; ?>" readonly>
			</div>
			<div class="col-md-12"><hr /></div>
			<div class="col-md-12">
				<label>* Return to:</label>
				<select class="form-control" id="returnroutetoselectize">
				<?php for ($i=0; $i < sizeof($selectroutehistory); $i++) { ?>
					<option value="<?php echo $this->encrypt->encode($selectroutehistory[$i]['staff']); ?>"><?php echo $selectroutehistory[$i]['staff_name']; ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-12">
				<label>* Remarks:</label>
				<textarea id="checkerremarks" rows="8" cols="80" class="form-control"></textarea>
			</div>
		</div>
		<script type="text/javascript">
			$('#returnroutetoselectize').selectize();
		</script>
		<?php
	}

	function returntosenderfooter(){
		$token = ($this->input->post('token'));
		?>
			<button type="button" class="btn btn-danger btn-sm" onclick="checkrouted_dtr_details('<?php echo $token; ?>'); returntosenderfooterdefault('<?php echo $token; ?>');">Cancel</button>
			<button type="button" class="btn btn-success btn-sm" onclick="dtrroutereturndoc('<?php echo $token; ?>',$('#returnroutetoselectize').val(),$('#checkerremarks').val());">Process</button>
		<?php
	}

	function returntosenderfooterdefault(){
		$token = ($this->input->post('token'));
		?>
			<button type="button" class="btn btn-danger btn-sm" onclick="returntosenderdtr('<?php echo $token; ?>'); returntosenderfooter('<?php echo $token; ?>');">Return to Sender</button>
			<button type="button" class="btn btn-success btn-sm" onclick="approve_routed_dtr_details('<?php echo $token; ?>');">Approve</button>
		<?php
	}

	function dtrroutereturndoc(){
		date_default_timezone_set("Asia/Manila");
		$datetoday = date('F d, Y h:ia');
		$token = $this->encrypt->decode($this->input->post('token'));
		$routeto = $this->encrypt->decode($this->input->post('user'));
		$remarks = ($this->input->post('remarks'));


		if(!empty($token) AND !empty($routeto) AND !empty($remarks)){
			$whereuserdetails = $this->db->where('acs.userid = "'.$routeto.'"');
			$selectuserdetails = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$whereuserdetails);
			$mname = !empty($selectuserdetails[0]['mname']) ? $selectuserdetails[0]['mname'][0].'. ' : '';
			$suffix = !empty($selectuserdetails[0]['suffix']) ? ' '.$selectuserdetails[0]['suffix'] : '';
			$title = !empty($selectuserdetails[0]['title']) ? $selectuserdetails[0]['title'].' ' : '';
			$routename = $title.$selectuserdetails[0]['fname'].' '.$mname.$selectuserdetails[0]['sname'].$suffix.

			$setdata = array('status' => 'Returned', 'routedto_userid' => $routeto, 'routedto_name' => $routename,);
			$wheredata = array('trans_no' => $token, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_routed', $wheredata);

			$data = array(
				            'trans_no' => $token,
										'staff' => $_SESSION['userid'],
										'staff_name' => $_SESSION['name'],
										'status' => 'Returned',
										'routedto_userid' => $routeto,
										'routedto_name' => $routename,
										'date_routed' => $datetoday,
										'remarks' => $remarks,
									 );
			$insertdata = $this->Embismodel->insertdata('acc_dtr_routed_history', $data);
			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}else{
			echo json_encode(array('status' => 'missing fields', ));
		}
	}

	function editdtrfulldetails(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$wheredata = $this->db->where('adr.trans_no = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_routed AS adr','',$wheredata);

		$whereroutehistory = $this->db->where('ah.trans_no = "'.$token.'" AND ah.cnt = (SELECT MAX(adrh2.cnt) FROM acc_dtr_routed_history AS adrh2 WHERE adrh2.trans_no = "'.$token.'")');
		$selectroutehistory = $this->Embismodel->selectdata('acc_dtr_routed_history AS ah','ah.staff_name, ah.staff, ah.remarks','',$whereroutehistory);

		$orderbyusers = $this->db->order_by('acs.fname','asc');
		$whereusers = $this->db->where('acs.region = "'.$this->session->userdata('region').'" AND acs.userid != "1"');
		$users = $this->Administrativemodel->select_employees($whereusers,$orderbyusers);

		 ?>
		<div class="row">
			<input type="hidden" id="editdtrtranstoken" value="<?php echo $this->input->post('token'); ?>">
			<div class="col-md-6">
				<label class="visibletext">* Route document to:</label>
				<select class="form-control" id="routedocprocessselectize">
					<option value="<?php echo $this->encrypt->encode($selectroutehistory[0]['staff']); ?>"><?php echo $selectroutehistory[0]['staff_name']; ?></option>
					<?php for ($i=0; $i < sizeof($users); $i++) {
						$mname = !empty($users[$i]['mname']) ? $users[$i]['mname'][0].'. ' : '';
						$suffix = !empty($users[$i]['suffix']) ? ' '.$users[$i]['suffix'] : '';
						$title = !empty($users[$i]['title']) ? $users[$i]['title'].' ' : '';
						$name = $title.$users[$i]['fname'].' '.$mname.$users[$i]['sname'].$suffix;
					?>
						<option value="<?php echo $this->encrypt->encode($users[$i]['userid']); ?>"><?php echo $name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6">
				<label class="visibletext">* In-charge:</label>
				<select class="form-control" id="routedocprocessselectizesig">
					<option value="<?php echo $this->encrypt->encode($selectdata[0]['signatory_userid']); ?>"><?php echo $selectdata[0]['signatory']; ?></option>
					<?php for ($i=0; $i < sizeof($users); $i++) {
						$mname = !empty($users[$i]['mname']) ? $users[$i]['mname'][0].'. ' : '';
						$suffix = !empty($users[$i]['suffix']) ? ' '.$users[$i]['suffix'] : '';
						$title = !empty($users[$i]['title']) ? $users[$i]['title'].' ' : '';
						$name = $title.$users[$i]['fname'].' '.$mname.$users[$i]['sname'].$suffix;
					?>
						<option value="<?php echo $this->encrypt->encode($users[$i]['userid']); ?>"><?php echo $name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12">
				<label class="visibletext">Remarks</label>
				<textarea id="routedocremarks" class="form-control" rows="8" cols="80"></textarea>
			</div>
			<div class="col-md-12"><hr /></div>
			<div class="col-md-4">
				<label>IIS No.</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['trans_no']; ?>" readonly>
			</div>
			<div class="col-md-4">
				<label>Subject</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['dtr_span']; ?>" readonly>
			</div>
			<div class="col-md-4">
				<label>Date Submitted</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['date_submitted']; ?>" readonly>
			</div>
			<?php if($selectdata[0]['status'] == 'Returned'){ ?>
			<div class="col-md-12">
				<label>Sender Name</label>
				<input type="text" class="form-control" value="<?php echo $selectroutehistory[0]['staff_name']; ?>" readonly>
			</div>
			<div class="col-md-12">
				<label>Remarks</label>
				<textarea class="form-control" rows="8" cols="80" readonly><?php echo $selectroutehistory[0]['remarks']; ?></textarea>
			</div>
			<?php } ?>
			<div class="col-md-12"><hr></div>
			<div class="col-md-12">
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseprocessdtr" aria-expanded="false" aria-controls="collapseprocessdtr" style="width: 100%;margin-bottom: 5px;">
			    See more..
			  </button>
				<div class="collapse" id="collapseprocessdtr">
				  <div class="card card-body" style="border:none;">
						<table id="process_dtr_routed_full_details" class="table table-striped" style="width:100%;zoom: 80%;font-weight: 100;text-align:center;">
							<thead>
								<tr>
									<th>Date log</th>
									<th>Time In</th>
									<th>Time Out</th>
									<th>Hrs. Worked</th>
									<th>Time In</th>
									<th>Time Out</th>
									<th>Hrs. Worked</th>
									<th>Total Hrs. Worked</th>
									<th>Undertime (mins)</th>
									<th>Remarks</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i=0; $i < sizeof($selectdata); $i++) {
									$timeinam = (empty($selectdata[$i]['in']) OR $selectdata[$i]['in'] == '00:00') ? '--:--': $selectdata[$i]['in'];
									$timeoutam = (empty($selectdata[$i]['out']) OR $selectdata[$i]['out'] == '00:00') ? '--:--': $selectdata[$i]['out'];

									$con_h_am = (date('h',strtotime($selectdata[$i]['am_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['am_hrsworked'])) > 1) ? 's' : '';
									$con_i_am = (date('i',strtotime($selectdata[$i]['am_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['am_hrsworked'])) > 1) ? 's' : '';
									$am_hrsworked = (empty($selectdata[$i]['am_hrsworked']) OR $selectdata[$i]['am_hrsworked'] == '00:00:00') ? '--:--':
									date('g',strtotime($selectdata[$i]['am_hrsworked'])).' hour'.$con_h_am.' and '.date('i',strtotime($selectdata[$i]['am_hrsworked'])).' minute'.$con_i_am;

									$timeinpm = (empty($selectdata[$i]['in_pm']) OR $selectdata[$i]['in_pm'] == '00:00') ? '--:--': $selectdata[$i]['in_pm'];
									$timeoutpm = (empty($selectdata[$i]['out_pm']) OR $selectdata[$i]['out_pm'] == '00:00') ? '--:--': $selectdata[$i]['out_pm'];

									$con_h_pm = (date('h',strtotime($selectdata[$i]['pm_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['pm_hrsworked'])) > 1) ? 's' : '';
									$con_i_pm = (date('i',strtotime($selectdata[$i]['pm_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['pm_hrsworked'])) > 1) ? 's' : '';
									$pm_hrsworked = (empty($selectdata[$i]['pm_hrsworked']) OR $selectdata[$i]['pm_hrsworked'] == '00:00:00') ? '--:--':
									date('g',strtotime($selectdata[$i]['pm_hrsworked'])).' hour'.$con_h_pm.' and '.date('i',strtotime($selectdata[$i]['pm_hrsworked'])).' minute'.$con_i_pm;

									$con_h = (date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('h',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
									$con_i = (date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 0 AND date('i',strtotime($selectdata[$i]['total_hrsworked'])) > 1) ? 's' : '';
									$total_hrsworked = (empty($selectdata[$i]['total_hrsworked']) OR $selectdata[$i]['total_hrsworked'] == '00:00:00') ? '--:--' :
									date('g',strtotime($selectdata[$i]['total_hrsworked'])).' hour'.$con_h.' and '.date('i',strtotime($selectdata[$i]['total_hrsworked'])).' minute'.$con_i;
									$withattachments = empty($selectdata[$i]['with_attachments']) ? '--' : str_replace(',',', ',$selectdata[$i]['with_attachments']);
									$viewattachments = empty($selectdata[$i]['with_attachments']) ? '--' :
									'<div class="dropdown">
									  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%!important;" onclick=processviewrouteddtrattachments("'.$this->encrypt->encode($selectdata[$i]['con_cnt']).'");>
									    View Attachment(s)
									  </button>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%!important;" id="processviewrouteddtrattachments_">

									  </div>
									</div>';
							  ?>
									<tr>
										<td><?php echo $selectdata[$i]['punch_date']; ?></td>
										<td><?php echo $timeinam; ?></td>
										<td><?php echo $timeoutam; ?></td>
										<td><?php echo $am_hrsworked; ?></td>
										<td><?php echo $timeinpm; ?></td>
										<td><?php echo $timeoutpm; ?></td>
										<td><?php echo $pm_hrsworked; ?></td>
										<td><?php echo $total_hrsworked; ?></td>
										<td><?php echo ($selectdata[$i]['undertime'] == 0) ? '--' : $selectdata[$i]['undertime'].' minute(s)'; ?></td>
										<td><?php echo $withattachments; ?></td>
										<td><?php echo $viewattachments; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#process_dtr_routed_full_details').DataTable({
									responsive: true,
						      language: {
						        "infoFiltered": "",
						      },
									"lengthMenu": [[31, 50, 100, -1], [31, 50, 100, "All"]]
								});
							} );
						</script>
				  </div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$('#routedocprocessselectize').selectize();
			$('#routedocprocessselectizesig').selectize();
		</script>
		<?php
	}

	function processeditdtrrouted(){
		date_default_timezone_set("Asia/Manila");
		$datetoday = date('F d, Y h:ia');
		$routeto = $this->encrypt->decode($this->input->post('routeto'));
		$incharge = $this->encrypt->decode($this->input->post('incharge'));
		$token = $this->encrypt->decode($this->input->post('token'));
		$remarks = ($this->input->post('remarks'));

		if(!empty($routeto) AND !empty($incharge) AND !empty($token)){
			$whererouteto = $this->db->where('acs.userid = "'.$routeto.'"');
			$selectrouteto = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$whererouteto);
			$rmname = !empty($selectrouteto[0]['mname']) ? $selectrouteto[0]['mname'][0].'. ' : '';
			$rsuffix = !empty($selectrouteto[0]['suffix']) ? ' '.$selectrouteto[0]['suffix'] : '';
			$rtitle = !empty($selectrouteto[0]['title']) ? ' '.$selectrouteto[0]['title'].' ' : '';
			$rname = $rtitle.$selectrouteto[0]['fname'].' '.$rmname.$selectrouteto[0]['sname'].$rsuffix;

			$wheresignatory = $this->db->where('acs.userid = "'.$incharge.'"');
			$selectsignatory = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix','',$wheresignatory);
			$sgmname = !empty($selectsignatory[0]['mname']) ? $selectsignatory[0]['mname'][0].'. ' : '';
			$sgsuffix = !empty($selectsignatory[0]['suffix']) ? ' '.$selectsignatory[0]['suffix'] : '';
			$sgtitle = !empty($selectsignatory[0]['title']) ? ' '.$selectsignatory[0]['title'].' ' : '';
			$sgname = $sgtitle.$selectsignatory[0]['fname'].' '.$sgmname.$selectsignatory[0]['sname'].$sgsuffix;

			$setdata = array(
											'status' => 'For approval',
											'routedto_userid' => $routeto, 'routedto_name' => $rname,
											'signatory' => $sgname,
											'signatory_userid' => $incharge,
										  );
			$wheredata = array('trans_no' => $token, );
			$routeupdate = $this->Embismodel->updatedata($setdata, 'acc_dtr_routed', $wheredata);

			$data = array(
				            'trans_no' => $token,
										'staff' => $this->session->userdata('userid'),
										'staff_name' => $this->session->userdata('name'),
										'status' => 'For approval',
										'routedto_userid' => $routeto,
										'routedto_name' => $rname,
										'date_routed' => $datetoday,
										'remarks' => $remarks,
									 );
			$insertdata = $this->Embismodel->insertdata('acc_dtr_routed_history',$data);
			if($routeupdate){
				echo json_encode(array('status' => 'success', ));
			}
		}else{
			echo json_encode(array('status' => 'missing fields', ));
		}
	}

	function savecredeb(){
		$item = $this->input->post('item');
		$type = $this->encrypt->decode($this->input->post('type'));
		if(!empty($item) AND !empty($type)){
			$data = array(
									  'item' => $item,
										'type' => $type,
										'added_byuserid' => $this->session->userdata('userid'),
										'added_byname' => $this->session->userdata('name'),
										'date_added' => date('Y-m-d'),
										'region' => $this->session->userdata('region'),
									 );
			$insertdata = $this->Embismodel->insertdata('acc_dtr_credeb',$data);
			if($insertdata){
				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}else{
			echo json_encode(array('status' => 'missing fields', ));
		}
	}

	function editcredebbtm(){
		$cnt = $this->encrypt->decode($this->input->post('cnt'));
		if(!empty($cnt)){
			$wheredata = $this->db->where('adc.cnt = "'.$cnt.'"');
			$selectdata = $this->Embismodel->selectdata('acc_dtr_credeb AS adc','','',$wheredata);
			$option = (!empty($selectdata[0]['type']) AND $selectdata[0]['type'] == 'Deduction') ? 'Add-on' : 'Deduction'; ?>
				<div class="row">
					<div class="col-md-12">
						<label>Item</label>
						<input type="text" id="credebitem" class="form-control" value="<?php echo $selectdata[0]['item']; ?>">
						<input type="hidden" id="credebtoken" class="form-control" value="<?php echo $this->input->post('cnt'); ?>">
					</div>
					<div class="col-md-12">
						<label>Type</label>
						<select class="form-control" id="typecredebselectize">
							<option value="<?php echo $this->encrypt->encode($selectdata[0]['type']); ?>"><?php echo ($selectdata[0]['type']); ?></option>
							<option value="<?php echo $this->encrypt->encode($option); ?>"><?php echo $option; ?></option>
						</select>
					</div>
				</div>
				</div>
				<script type="text/javascript">
					$('#typecredebselectize').selectize();
				</script>
			<?php
		}
	}

	function saveeditedcredeb(){
		$item = $this->input->post('item');
		$cnt = $this->encrypt->decode($this->input->post('token'));
		$type = $this->encrypt->decode($this->input->post('type'));

		if(!empty($item) AND !empty($cnt) AND !empty($type)){
			$setdata = array(
												'item' => $item,
												'type' => $type,
												'added_byuserid' => $this->session->userdata('userid'),
												'added_byname' => $this->session->userdata('name'),
												'date_added' => date('Y-m-d'),
											);
			$wheredata = array('cnt' => $cnt, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_credeb', $wheredata);
			if($updatedata){
				echo json_encode(array('status' => 'success', ));
			}else{
				echo json_encode(array('status' => 'failed', ));
			}
		}else{
			echo json_encode(array('status' => 'missing fields', ));
		}
	}

	function dtrdyswrkd(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$val = $this->input->post('val');
		$dlyrt = $this->input->post('dlyrt');
		if(!empty($token) AND !empty($val)){
			$setdata = array('p_days_worked' => $val, );
			$wheredata = array('trans_no' => $token, );
			$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_routed', $wheredata);

			$grossincome = number_format($val * $dlyrt, 2);

			echo json_encode(array('gross_income' => $grossincome,'token' => $token, ));
		}
	}

	function dtrdlyrt(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$val = $this->input->post('val');
		$empname = $this->encrypt->decode($this->input->post('empname'));
		$transno = $this->encrypt->decode($this->input->post('transno'));
		$dyswrkd = $this->input->post('dyswrkd');

		if(!empty($token) AND !empty($val) AND !empty($empname) AND !empty($transno)){
			$wheredata = $this->db->where('adi.userid = "'.$token.'"');
			$chkdata = $this->Embismodel->selectdata('acc_additional_info AS adi','adi.userid','',$wheredata);
			if(!empty($chkdata[0]['userid'])){
				$setdata = array('daily_rate' => $val, );
				$wheredataupdate = array('userid' => $token, );
				$updatedata = $this->Embismodel->updatedata($setdata, 'acc_additional_info', $wheredataupdate);
			}else{

				$data = array(
											'userid' => $token,
											'name' => $empname,
											'daily_rate' => $val,
										 );
				$insertdata = $this->Embismodel->insertdata('acc_additional_info',$data);
			}

			if(!empty($transno)){
				$setdata = array('p_daily_rate' => $val, );
				$updtwhere = array('trans_no' => $transno, );
				$updatedata = $this->Embismodel->updatedata($setdata, 'acc_dtr_routed', $updtwhere);
			}

			$grossincome = number_format($dyswrkd * $val, 2);

			echo json_encode(array('gross_income' => $grossincome,'token' => $transno, ));
		}
	}

	function addondtr(){
		$token = ($this->input->post('token'));
		$transno = ($this->input->post('tkn'));
		$wheredata = $this->db->where('adc.type = "Add-on" AND adc.region = "'.$this->session->userdata('region').'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_credeb AS adc','adc.item','',$wheredata);
		?>
			<div class="row">
				<input type="hidden" class="form-control" id="dtrtoken" value="<?php echo $token; ?>">
				<input type="hidden" class="form-control" id="dtrtkn" value="<?php echo $transno; ?>">
				<div class="col-md-12">
					<label>Item</label>
					<select class="form-control" id="addondtritemselectize" onchange="newaddondtr(this.value);">
						<option value=""></option>
						<?php for ($i=0; $i < sizeof($selectdata); $i++) { ?>
							<option value="<?php echo $this->encrypt->encode($selectdata[$i]['item']); ?>"><?php echo $selectdata[$i]['item']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12" id="newaddondtr_"></div>
			</div>
			<script type="text/javascript">
				$('#addondtritemselectize').selectize();
			</script>
		<?php
	}

	function deductiondtr(){
		$token = ($this->input->post('token'));
		$transno = ($this->input->post('tkn'));
		$wheredata = $this->db->where('adc.type = "Deduction" AND adc.region = "'.$this->session->userdata('region').'"');
		$selectdata = $this->Embismodel->selectdata('acc_dtr_credeb AS adc','adc.item','',$wheredata);
		?>
			<div class="row">
				<input type="hidden" class="form-control" id="dtrtoken" value="<?php echo $token; ?>">
				<input type="hidden" class="form-control" id="dtrtkn" value="<?php echo $transno; ?>">
				<div class="col-md-12">
					<label>Item</label>
					<select class="form-control" id="deductiondtritemselectize" onchange="newdeductiondtr(this.value);">
						<option value=""></option>
						<?php for ($i=0; $i < sizeof($selectdata); $i++) { ?>
							<option value="<?php echo $this->encrypt->encode($selectdata[$i]['item']); ?>"><?php echo $selectdata[$i]['item']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12" id="newdeductiondtr_"></div>
			</div>
			<script type="text/javascript">
				$('#deductiondtritemselectize').selectize();
			</script>
		<?php
	}

	function addonchkr(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$transno = ($this->input->post('tkn'));

		$wheredata = $this->db->where('adi.userid = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','','',$wheredata);
		$explodedata = explode('||',$selectdata[0]['add_on_details']);

		?>
		<div class="row">
			<div class="col-md-12"><hr /></div>
			<div class="col-md-12">
				<label>Employee:</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['name']; ?>" readonly>
			</div>
			<?php if(!empty($selectdata[0]['add_on_total'])){ ?>
			<div class="col-md-12" id="addondiv_">
				<div class="row">
					<div class="col-md-12"><hr />
						<label>Current Add-on(s):</label>
					</div>
					<?php } ?>
					<?php for ($i=0; $i < count($explodedata); $i++) { $explodetwo = explode('|',$explodedata[$i]);  ?>
					 <?php if(!empty($explodetwo[0]) AND !empty($explodetwo[1])){ ?>
						<div class="col-md-6" style="margin-top:3px;">
			 				<input type="text" class="form-control" value="<?php echo $explodetwo[0]; ?>" readonly>
			 			</div>
						<div class="col-md-5" style="margin-top:3px;">
			 				<input type="text" class="form-control" value="<?php echo $explodetwo[1]; ?>" readonly>
			 			</div>
						<div class="col-md-1" style="margin-top:3px;">
			 				<button type="button" class="btn btn-danger btn-sm" style="width: 100%;height: 35px;" onclick="rmvaddon('<?php echo $this->input->post('token'); ?>','<?php echo $explodedata[$i]; ?>','<?php echo $transno; ?>');"><span class="fa fa-trash"></span></button>
			 			</div>
					 <?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
	}

	function deductionchkr(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$transno = ($this->input->post('tkn'));

		$wheredata = $this->db->where('adi.userid = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','','',$wheredata);
		$explodedata = explode('||',$selectdata[0]['deduction_details']);

		?>
		<div class="row">
			<div class="col-md-12"><hr /></div>
			<div class="col-md-12">
				<label>Employee:</label>
				<input type="text" class="form-control" value="<?php echo $selectdata[0]['name']; ?>" readonly>
			</div>
			<?php if(!empty($selectdata[0]['deduction_total'])){ ?>
			<div class="col-md-12" id="deductiondiv_">
				<div class="row">
					<div class="col-md-12"><hr />
						<label>Current Deduction(s):</label>
					</div>
					<?php for ($i=0; $i < count($explodedata); $i++) { $explodetwo = explode('|',$explodedata[$i]);?>
					 <?php if(!empty($explodetwo[0]) AND !empty($explodetwo[1])){ ?>
						<div class="col-md-6" style="margin-top:3px;">
			 				<input type="text" class="form-control" value="<?php echo $explodetwo[0]; ?>" readonly>
			 			</div>
						<div class="col-md-5" style="margin-top:3px;">
			 				<input type="number" class="form-control" value="<?php echo $explodetwo[1]; ?>" readonly>
			 			</div>
						<div class="col-md-1" style="margin-top:3px;">
			 				<button type="button" class="btn btn-danger btn-sm" style="width: 100%;height: 35px;" onclick="rmvdeduction('<?php echo $this->input->post('token'); ?>','<?php echo $explodedata[$i]; ?>','<?php echo $transno; ?>');"><span class="fa fa-trash"></span></button>
			 			</div>
					 <?php } ?>
					<?php } ?>
				</div>
			</div>
				<?php } ?>
		</div>
		<?php
	}

	function rmvaddon(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$val = ($this->input->post('val'));
		$transno = $this->encrypt->decode($this->input->post('transno'));

		$wheredata = $this->db->where('aai.userid = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('acc_additional_info AS aai','','',$wheredata);

		if(!empty($selectdata[0]['add_on_details'])){
			$details = "";
			$explodetotal = explode('|',$val);
			$total = str_replace(',','',$selectdata[0]['add_on_total']) - str_replace(',','',$explodetotal[1]);

			$explodedata = explode('||',$selectdata[0]['add_on_details']);
			for ($i=0; $i < count($explodedata); $i++) {
				if(!empty($explodedata[$i]) AND $explodedata[$i] != $val){
					$details .= $explodedata[$i].'||';
				}
			}

			$add_on_total = ($total > 0) ? number_format($total,2) : '';
			$add_on_details = ($details == '||') ? '' : $details;

			$setdatau = array('add_on_total' => $add_on_total, 'add_on_details' => $add_on_details, );
			$wheredatau = array('userid' => $token, );
			$updatedata = $this->Embismodel->updatedata($setdatau, 'acc_additional_info', $wheredatau);

			$updtset = array('p_total_addon' => $add_on_total, );
			$updtwhere = array('trans_no' => $transno, );
			$updtrouted = $this->Embismodel->updatedata($updtset, 'acc_dtr_routed', $updtwhere);

			$whereremoveaddonhistory = array('trans_no' => $transno, 'add_on_details' => trim($explodetotal[0]), 'add_on_value' => trim($explodetotal[1]), );
			$removeaddonhistory = $this->Embismodel->deletedata('acc_dtr_add_on_history',$whereremoveaddonhistory);

			echo json_encode(array('token' => $this->input->post('token'), 'transno' => $transno, 'total' => $add_on_total, ));
		}
	}

	function rmvdeduction(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$val = ($this->input->post('val'));
		$transno = $this->encrypt->decode($this->input->post('transno'));
		// echo $token.' '.$val.' '.$transno; exit;
		$wheredata = $this->db->where('aai.userid = "'.$token.'"');
		$selectdata = $this->Embismodel->selectdata('acc_additional_info AS aai','','',$wheredata);

		if(!empty($selectdata[0]['deduction_details'])){
			$details = "";
			$total = "";
			$explodetotal = explode('|',$val);
			$total = str_replace(',','',$selectdata[0]['deduction_total']) - str_replace(',','',$explodetotal[1]);

			$explodedata = explode('||',$selectdata[0]['deduction_details']);
			for ($i=0; $i < count($explodedata); $i++) {
				if(!empty($explodedata[$i]) AND $explodedata[$i] != $val){
					$details .= $explodedata[$i].'||';
				}
			}

			$deduction_total = ($total > 0) ? number_format($total,2) : '';
			$deduction_details = ($details == '||') ? '' : $details;
			// echo $token.' '.$transno.' '.$deduction_total.' '.$deduction_details.' '.$details; exit;
			$setdatau = array('deduction_total' => $deduction_total, 'deduction_details' => $deduction_details, );
			$wheredatau = array('userid' => $token, );
			$updatedata = $this->Embismodel->updatedata($setdatau, 'acc_additional_info', $wheredatau);

			$updtset = array('p_total_deductions' => $deduction_total, );
			$updtwhere = array('trans_no' => $transno, );
			$updtrouted = $this->Embismodel->updatedata($updtset, 'acc_dtr_routed', $updtwhere);

			$whereremovehistory = array('trans_no' => $transno, 'deduction_details' => trim($explodetotal[0]), );
			$removehistory = $this->Embismodel->deletedata('acc_dtr_deduction_history',$whereremovehistory);

			echo json_encode(array('token' => $this->input->post('token'), 'transno' => $this->input->post('transno'), 'trans_no' => $transno, 'total' => $deduction_total, ));
		}
	}


	function newaddondtr(){
		$token = $this->encrypt->decode($this->input->post('token'));
		?>
			<div class="row">
				<div class="col-md-12"><hr /></div>
				<div class="col-md-6">
					<input type="text" class="form-control" value="<?php echo $token; ?>" readonly>
				</div>
				<div class="col-md-5">
					<input type="number" class="form-control" id="addonvaldtr">
				</div>
				<div class="col-md-1">
					<button type="button" class="btn btn-success btn-sm" style="width:100%;height: 34px;" onclick="saveaddondtr($('#dtrtoken').val(),'<?php echo $this->input->post('token'); ?>',$('#addonvaldtr').val(), $('#dtrtkn').val());"><span class="fa fa-plus"></span></button>
				</div>
			</div>
		<?php
	}

	function newdeductiondtr(){
		$token = $this->encrypt->decode($this->input->post('token'));
		?>
			<div class="row">
				<div class="col-md-12"><hr /></div>
				<div class="col-md-6">
					<input type="text" class="form-control" value="<?php echo $token; ?>" readonly>
				</div>
				<div class="col-md-5">
					<input type="number" class="form-control" id="deductionvaldtr" autofocus>
				</div>
				<div class="col-md-1">
					<button type="button" class="btn btn-success btn-sm" style="width:100%;height: 34px;" onclick="savedeductiondtr($('#dtrtoken').val(),'<?php echo $this->input->post('token'); ?>',$('#deductionvaldtr').val(), $('#dtrtkn').val());"><span class="fa fa-plus"></span></button>
				</div>
			</div>
		<?php
	}

	function saveaddondtr(){
		$useridtoken = $this->encrypt->decode($this->input->post('usertoken'));
		$item = $this->encrypt->decode($this->input->post('token'));
		$addonval = number_format($this->input->post('addonval'),2);
		$transno = $this->encrypt->decode($this->input->post('transno'));

		$chkwheredata = $this->db->where('adi.userid = "'.$useridtoken.'" AND adi.add_on_details LIKE "%'.$item.'%"');
		$chkselectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','adi.add_on_details','',$chkwheredata);

		if(!empty($useridtoken) AND !empty($item) AND !empty($addonval) AND !empty($transno)){
			if(empty($chkselectdata[0]['add_on_details'])){
				$wheredata = $this->db->where('adi.userid = "'.$useridtoken.'"');
				$selectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','','',$wheredata);
				if(!empty($selectdata[0]['userid'])){
					$aot = str_replace(',','',$selectdata[0]['add_on_total']) + str_replace(',','',$addonval);
					$aod = $selectdata[0]['add_on_details'].$item.'|'.$addonval.'||';
					$setdata = array(
													 'add_on_total' => number_format($aot, 2),
													 'add_on_details' => $aod,
													);
					$whrdata = array('userid' => $useridtoken, );
					$updatedata = $this->Embismodel->updatedata($setdata, 'acc_additional_info', $whrdata);

					$updtset = array('p_total_addon' => number_format($aot, 2), );
					$updtwhere = array('trans_no' => $transno, );
					$updtrouted = $this->Embismodel->updatedata($updtset, 'acc_dtr_routed', $updtwhere);

					$whereaddonhistory = array('trans_no' => $transno, 'add_on_details' => $item, 'add_on_value' => $addonval, );
					$insertaddonhistory = $this->Embismodel->insertdata('acc_dtr_add_on_history',$whereaddonhistory);
					if($updatedata){
						echo json_encode(array('status' => 'success', 'token' => $this->input->post('usertoken'), 'res' => $transno, 'total' => number_format($aot, 2),));
					}
				}
			}else{
				echo json_encode(array('status' => 'existed', ));
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function savedeductiondtr(){
		$useridtoken = $this->encrypt->decode($this->input->post('usertoken'));
		$item = $this->encrypt->decode($this->input->post('token'));
		$addonval = number_format($this->input->post('addonval'),2);
		$transno = $this->encrypt->decode($this->input->post('transno'));

		// echo $useridtoken.' '.$item.' '.$addonval.' '.$transno; exit;

		if(!empty($useridtoken) AND !empty($item) AND !empty($addonval) AND !empty($transno)){
			$wheredata = $this->db->where('adi.userid = "'.$useridtoken.'"');
			$selectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','','',$wheredata);

			$wheredtr = $this->db->where('adr.trans_no = "'.$transno.'" GROUP BY adr.trans_no');
			$selectdtr = $this->Embismodel->selectdata('acc_dtr_routed AS adr','adr.undertime_total, adr.p_daily_rate','',$wheredtr);

			if(!empty($selectdata[0]['userid'])){

				$chkwheredata = $this->db->where('adi.userid = "'.$useridtoken.'" AND adi.deduction_details LIKE "%'.$item.'%"');
				$chkselectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','adi.deduction_details','',$chkwheredata);

				if(empty($chkselectdata[0]['deduction_details'])){
					$aot = str_replace(',','',$selectdata[0]['deduction_total']) + $addonval;
					$aod = $selectdata[0]['deduction_details'].$item.'|'.$addonval.'||';
					$undertime_deduction = $selectdtr[0]['undertime_total'] * $selectdtr[0]['p_daily_rate'] / 480;
					$total_deduction = $aot + $undertime_deduction;

					$setdata = array(
												   'deduction_total' => number_format($aot, 2),
													 'deduction_details' => $aod,
												  );
					$whrdata = array('userid' => $useridtoken, );
					$updatedata = $this->Embismodel->updatedata($setdata, 'acc_additional_info', $whrdata);

					$updtset = array('p_total_deductions' => number_format($aot, 2), );
					$updtwhere = array('trans_no' => $transno, );
					$updtrouted = $this->Embismodel->updatedata($updtset, 'acc_dtr_routed', $updtwhere);

					$whereinsertdeduction = array('trans_no' => $transno, 'deduction_details' => $item, 'deduction_value' => $addonval, );
					$insertdeduction = $this->Embismodel->insertdata('acc_dtr_deduction_history',$whereinsertdeduction);

					if($updatedata){
						echo json_encode(array('status' => 'success', 'token' => $this->input->post('usertoken'), 'res' => $transno, 'transno' => $this->input->post('transno'), 'total' => number_format($aot, 2), 'total_deductions' => number_format($total_deduction, 2),));
					}
				}else{
					echo json_encode(array('status' => 'existed', ));
				}
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function dtrsummary(){
	$token = $this->encrypt->decode($this->input->post('token'));
	$wheredata = $this->db->where('adr.trans_no = "'.$token.'" GROUP BY adr.trans_no');
	$selectdata = $this->Embismodel->selectdata('acc_dtr_routed AS adr','','',$wheredata);

	$gross_income = $selectdata[0]['p_days_worked'] * $selectdata[0]['p_daily_rate'];
	$total_compensation = $gross_income + $selectdata[0]['p_total_addon'];

	$whereaddons = array('ah.trans_no' => $token, );
	$selectaddons = $this->Embismodel->selectdata('acc_dtr_add_on_history AS ah','',$whereaddons);

	$wheredeductions = array('dh.trans_no' => $token, );
	$selectdeductions = $this->Embismodel->selectdata('acc_dtr_deduction_history AS dh','',$wheredeductions);

	$add_on = !empty($selectdata[0]['p_total_addon']) ? '₱'.number_format($selectdata[0]['p_total_addon'], 2) : '--';

	$undertime_deduction = $selectdata[0]['undertime_total'] * $selectdata[0]['p_daily_rate'] / 480;
	$undertimefinal = ($undertime_deduction > 0) ? '₱'.number_format($undertime_deduction, 2) : '--';
	$total_deductions_p = str_replace(',','',$selectdata[0]['p_total_deductions']);
	$total_deduction = $total_deductions_p + $undertime_deduction;
	$total_deductionfinal = ($total_deduction > 0) ? '₱'.number_format($total_deduction,2) : '--';

	$net_home_pay = $total_compensation - str_replace(',','',$total_deduction);
		?>
			<div class="row">
					<div class="col-md-12">
						<label>Employee:</label>
						<input type="text" class="form-control" value="<?php echo $selectdata[0]['staff_name']; ?>" readonly>
					</div>
					<div class="col-md-12"><hr /></div>
					<div class="col-md-6">
						<label>Gross Income:</label>
						<input type="text" class="form-control" value="<?php echo '₱'.number_format($gross_income, 2); ?>" readonly>
					</div>
					<div class="col-md-6">
						<label>Add-on(s):</label>
						<input type="text" class="form-control" value="<?php echo $add_on; ?>" readonly>
					</div>
					<?php if(!empty($selectaddons[0]['trans_no'])){ ?>
						<div class="col-md-12">
							<label>Add-on(s) Breakdown:</label>
						</div>
						<?php for ($ab=0; $ab < sizeof($selectaddons); $ab++) { ?>
							<div class="col-md-6" style="margin-bottom:5px;">
								<input type="text" class="form-control" value="<?php echo $selectaddons[$ab]['add_on_details']; ?>" readonly>
							</div>
							<div class="col-md-6" style="margin-bottom:5px;">
								<input type="text" class="form-control" value="<?php echo '₱'.number_format($selectaddons[$ab]['add_on_value'], 2); ?>" readonly>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="col-md-12">
						<label>Total Compensation:</label>
						<input type="text" class="form-control" value="<?php echo '₱'.number_format($total_compensation, 2); ?>" readonly>
					</div>
					<div class="col-md-12"><hr /></div>
					<?php if($undertime_deduction > 0){ ?>
						<div class="col-md-12">
							<label>Late / Undertime Total Breakdown:</label>
							<div class="row" style="margin: 0px;">
								<div class="col-md-4">
									<label>Late / Undertime Total:</label>
									<input type="text" class="form-control" value="<?php echo $selectdata[0]['undertime_total'].' minute(s) * '; ?>" readonly>
								</div>
								<div class="col-md-4">
									<label>Daily Rate:</label>
									<input type="text" class="form-control" value="<?php echo '₱'.$selectdata[0]['p_daily_rate']; ?>" readonly>
								</div>
								<div class="col-md-4">
									<label>8 hours in minutes:</label>
									<input type="text" class="form-control" value="<?php echo ' / 480'; ?>" readonly>
								</div>
							</div><hr />
						</div>
					<?php } ?>
					<div class="col-md-12">
						<label>Late / Undertime Deduction:</label>
						<input type="text" class="form-control" value="<?php echo $undertimefinal; ?>" readonly>
					</div>
					<?php if(!empty($selectdeductions[0]['trans_no'])){ ?>
						<div class="col-md-12">
							<label>Less Deduction(s):</label>
						</div>
						<?php for ($ded=0; $ded < sizeof($selectdeductions); $ded++) { ?>
							<div class="col-md-6" style="margin-bottom:5px;">
								<input type="text" class="form-control" value="<?php echo $selectdeductions[$ded]['deduction_details']; ?>" readonly>
							</div>
							<div class="col-md-6" style="margin-bottom:5px;">
								<input type="text" class="form-control" value="<?php echo '₱'.number_format($selectdeductions[$ded]['deduction_value'], 2); ?>" readonly>
							</div>
						<?php } ?>
					<?php } ?>
						<div class="col-md-12">
							<label>Total Deduction(s):</label>
							<input type="text" class="form-control" value="<?php echo $total_deductionfinal; ?>" readonly>
						</div>

					<div class="col-md-12"><hr /></div>
					<div class="col-md-12">
						<label>Net Take Home Pay:</label>
						<input type="text" class="form-control" value="<?php echo '₱'.number_format($net_home_pay, 2); ?>" readonly>
					</div>
			</div>
		<?php
	}

	function dtrpayrollapprove(){
		date_default_timezone_set("Asia/Manila");
		$datetoday = date('F d, Y h:ia');
		$token = $this->encrypt->decode($this->input->post('token'));
		$setdata = array('status' => 'Approved', );
		$wheredata = array('trans_no' => $token, );
		$updatedata = $this->Embismodel->updatedata($setdata,'acc_dtr_routed',$wheredata);

		$data = array(
									'trans_no' => $token,
									'staff' => $this->session->userdata('userid'),
									'staff_name' => $this->session->userdata('name'),
									'status' => 'Approved',
									'routedto_userid' => '',
									'routedto_name' => '',
									'date_routed' => $datetoday,
									'remarks' => '',
								 );
		$insertdata = $this->Embismodel->insertdata('acc_dtr_routed_history',$data);

		if($updatedata){
			echo json_encode(array('status' => 'success', ));
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function checknotif(){
		$selectforapproval = $this->db->select('adr.trans_no')
										 ->from('embis.acc_dtr_routed as adr')
										 ->join('embis.er_transactions AS et','et.token = adr.trans_no','left')
	                   ->where('adr.routedto_userid = "'.$this->session->userdata('userid').'" AND adr.status = "For Approval" AND et.status != "0" GROUP BY adr.trans_no')
										 ->get()->num_rows();

	  $selectforpayroll = $this->db->select('adr.trans_no')
										 ->from('embis.acc_dtr_routed as adr')
										 ->join('embis.er_transactions AS et','et.token = adr.trans_no','left')
	                   ->where('adr.routedto_userid = "'.$this->session->userdata('userid').'" AND et.status != "0" AND adr.status = "For Payroll" GROUP BY adr.trans_no')
										 ->get()->num_rows();


	  $selectapprovedpayroll = $this->db->select('adr.trans_no')
										 ->from('embis.acc_dtr_routed as adr')
										 ->join('embis.er_transactions AS et','et.token = adr.trans_no','left')
	                   ->where('adr.routedto_userid = "'.$this->session->userdata('userid').'" AND adr.status = "Approved" AND et.status != "0" GROUP BY adr.trans_no')
										 ->get()->num_rows();
	 	echo json_encode(array('forapproval' => $selectforapproval, 'forpayroll' => $selectforpayroll, 'allpayroll' => $selectapprovedpayroll, ));
	}

	function chkaddondtr(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$whereinfo = array('userid' => $token);
		$selectinfo = $this->Embismodel->selectdata('acc_additional_info AS adi','',$whereinfo);
		$explodedata = explode('||',$selectinfo[0]['add_on_details']);
		$wherecredeb = array('region' => $this->session->userdata('region'), 'type' => "Add-on", );
		$selectcredeb = $this->Embismodel->selectdata('acc_dtr_credeb AS adc','',$wherecredeb)
		?>
			<div class="row">
				<input type="hidden" id="usertokendtrchk" value="<?php echo $this->input->post('token'); ?>" readonly>
				<div class="col-md-12">
					<label>Item</label>
					<select class="form-control" onchange="chkaddondtradd(this.value);" id="addonselectizedinfo">
						<option value=""></option>
						<?php for ($ao=0; $ao < sizeof($selectcredeb); $ao++) { ?>
							<option value="<?php echo $this->encrypt->encode($selectcredeb[$ao]['item']); ?>"><?php echo $selectcredeb[$ao]['item']; ?></option>
						<?php } ?>
					</select>
					<hr />
				</div>
				<div class="col-md-12" id="chkaddondtradd_"></div>
				<div class="col-md-12">
					<label>Employee</label>
					<input type="text" class="form-control" value="<?php echo $selectinfo[0]['name']; ?>" readonly><hr />
				</div>
				<div class="col-md-12">
					<label>Current Add-on(s):</label>
				</div>
				<?php
					for ($i=0; $i < count($explodedata); $i++) {
						if(!empty($explodedata[$i])){
							$explodeindata = explode('|',$explodedata[$i]);
				?>
					<div class="col-md-6" style="margin-top:3px;">
						<input type="text" class="form-control" value="<?php echo $explodeindata[0]; ?>" readonly>
					</div>
					<div class="col-md-5" style="margin-top:3px;">
						<input type="text" class="form-control" value="<?php echo $explodeindata[1]; ?>" readonly>
					</div>
					<div class="col-md-1" style="margin-top:3px;">
						<button type="button" class="btn btn-danger btn-sm" style="width: 100%;height: 35px;" onclick="rmvaddondtrchk('<?php echo $this->input->post('token'); ?>','<?php echo $this->encrypt->encode($explodeindata[0].'|'.$explodeindata[1]); ?>');"><span class="fa fa-trash"></span></button>
					</div>
				<?php } } ?>
			</div>
			<script type="text/javascript">
				$('#addonselectizedinfo').selectize();
			</script>
		<?php
	}

	function rmvaddondtrchk(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$val = $this->encrypt->decode($this->input->post('val'));
		$explodeval = explode('|',$val);
		$whereinfo = array('userid' => $token);
		$selectinfo = $this->Embismodel->selectdata('acc_additional_info AS adi','',$whereinfo);
		$add_on_total = str_replace(',','',$selectinfo[0]['add_on_total']) - str_replace(',','',$explodeval[1]);

		$add_on_details = "";
		$explodedata = explode('||',$selectinfo[0]['add_on_details']);
		for ($i=0; $i < count($explodedata); $i++) {
			if(trim($explodedata[$i] != $val)){
				$add_on_details .= $explodedata[$i];
			}
		}
		$setdata = array('add_on_total' => number_format($add_on_total,2), 'add_on_details' => $add_on_details, );
		$wheredata = array('userid' => $token, );
		$updatedata = $this->Embismodel->updatedata($setdata,'acc_additional_info',$wheredata);
		if($updatedata){
			echo json_encode(array('status' => 'success', ));
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

	function chkaddondtradd(){
		$token = $this->encrypt->decode($this->input->post('token'));
		?>
			<div class="row">
				<div class="col-md-6" style="margin-top:3px;">
					<input type="text" class="form-control" value="<?php echo $token; ?>" readonly>
				</div>
				<div class="col-md-5" style="margin-top:3px;">
					<input type="number" class="form-control" id="addonvaldtrchk">
				</div>
				<div class="col-md-1" style="margin-top:3px;">
					<button type="button" class="btn btn-success btn-sm" onclick="saveaddondtradd($('#usertokendtrchk').val(),$('#addonselectizedinfo').val(),$('#addonvaldtrchk').val())" style="width: 100%;height: 35px;"><span class="fa fa-plus"></span></button>
				</div>
				<div class="col-md-12"><hr /></div>
			</div>
		<?php
	}

	function saveaddondtradd(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$item = $this->encrypt->decode($this->input->post('item'));
		$val = $this->input->post('val');
		$chkwheredata = $this->db->where('adi.userid = "'.$token.'" AND adi.add_on_details LIKE "%'.$item.'%"');
		$chkselectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','adi.add_on_details','',$chkwheredata);
		if(!empty($token) AND !empty($item) AND !empty($val)){
			if(empty($chkselectdata[0]['add_on_details'])){
				$wheredata = $this->db->where('adi.userid = "'.$token.'"');
				$selectdata = $this->Embismodel->selectdata('acc_additional_info AS adi','','',$wheredata);
				if(!empty($selectdata[0]['userid'])){
					$add_on_total = str_replace(',','',$val) + str_replace(',','',$selectdata[0]['add_on_total']);
					$add_on_details = $selectdata[0]['add_on_details'].$item.'|'.$val.'||';

					$setdata = array('add_on_total' => number_format($add_on_total,2), 'add_on_details' => $add_on_details, );
					$wheredata = array('userid' => $token, );
					$updatedata = $this->Embismodel->updatedata($setdata,'acc_additional_info',$wheredata);
					if($updatedata){
						echo json_encode(array('status' => 'success', ));
					}
				}else{
					$whereinfo = $this->db->where('acs.userid = "'.$token.'" AND acs.verified = "1"');
					$selectinfo = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.sname, acs.suffix','',$whereinfo);
					$mname = !empty($selectinfo[0]['mname']) ? $selectinfo[0]['mname'][0].'. ' : '';
					$title = !empty($selectinfo[0]['title']) ? $selectinfo[0]['title'].' ' : '';
					$suffix = !empty($selectinfo[0]['suffix']) ? ' '.$selectinfo[0]['suffix'] : '';
					$name = $title.$selectinfo[0]['fname'].' '.$mname.$selectinfo[0]['sname'].$suffix;
					$data = array('userid' => $token, 'name' => $name,  'add_on_total' => number_format($add_on_total,2),  'add_on_details' => $add_on_details, );
					$insertdata = $this->Embismodel->insertdata('acc_additional_info',$data);
					if($insertdata){
						echo json_encode(array('status' => 'success', ));
					}
				}
			}else{
				echo json_encode(array('status' => 'existed', ));
			}
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}
}

?>
