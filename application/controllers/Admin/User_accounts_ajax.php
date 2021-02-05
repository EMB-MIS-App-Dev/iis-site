<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class User_accounts_ajax extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->model('Administrativemodel');

		$this->load->library('session');
	}

	function dc_user_assignment(){
		$user_region = $this->session->userdata('region');
		$divno 		   = $this->input->post('divno');
		// echo $divno;
		if($divno != '14' AND $divno != '17'){

				$where       = $this->db->where('an.divno', $divno);
				$where       = $this->db->where('an.func', 'Division Chief');
				$where       = $this->db->where('an.stat', '1');
				$where       = $this->db->where('acs.verified', '1');
				$where       = $this->db->where('an.region', $user_region);
				$join        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
				$join        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
				$queryselect = $this->Embismodel->selectdata('embis.acc_function AS an','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,acs.plantilla_itemno,pn.planpstn_desc,an.func','',$where,$join);

				if(!empty($queryselect[0]['mname'])){ $mname = $queryselect[0]['mname'][0].". ";  }else{ $mname = ""; }
				if(!empty($queryselect[0]['suffix'])){ $suffix = " ".$queryselect[0]['suffix'];  }else{ $suffix = ""; }
				if(!empty($queryselect[0]['title'])){ $title = $queryselect[0]['title']." ";  }else{ $title = ""; }
				$full_name   = utf8_encode(strtolower($queryselect[0]['fname']." ".$mname.$queryselect[0]['sname']));
				$full_nm     = str_replace('Ã±', '&ntilde;', $full_name);
				$name = $title.ucwords(str_replace('ã±', '&ntilde;', $full_nm)).$suffix;

				if($queryselect[0]['plantilla_itemno'] == 'Chief' || $queryselect[0]['plantilla_itemno'] == 'Supervising' || $queryselect[0]['plantilla_itemno'] == 'Senior'){
					if(!empty($queryselect[0]['plantilla_itemno'])){
						$plantilla_itemno = $queryselect[0]['plantilla_itemno']." ";  }else{ $plantilla_itemno = ""; }
						$plantilla        = $plantilla_itemno.$queryselect[0]['planpstn_desc'];
				}else{
					if(!empty($queryselect[0]['plantilla_itemno'])){
						$plantilla_itemno = " ".$queryselect[0]['plantilla_itemno'];  }else{ $plantilla_itemno = ""; }
						$plantilla        = $queryselect[0]['planpstn_desc'].$plantilla_itemno;
				}

				$orderbystf       = $this->db->order_by('acs.fname','ASC');
				$wherestaff       = $this->db->where('an.region = "'.$user_region.'" AND acs.verified = "1" AND an.stat = "1" AND an.func = "Staff" AND an.divno = "'.$divno.'" AND (an.secno = "" OR an.secno = "0")');
				$joinstaff        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
				$joinstaff        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
				$queryselectstf   = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,acs.plantilla_itemno,pn.planpstn_desc','',$wherestaff,$joinstaff,$orderbystf);
				// echo $this->db->last_query(); exit;

				$whereadc       = $this->db->where('an.divno', $divno);
				$whereadc       = $this->db->where('an.func', 'Assistant Division Chief');
				$whereadc       = $this->db->where('an.stat', '1');
				$whereadc       = $this->db->where('acs.verified', '1');
				$whereadc       = $this->db->where('an.region', $user_region);
				$joinadc        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
				$joinadc        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
				$queryselectadc = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,acs.plantilla_itemno,pn.planpstn_desc','',$whereadc,$joinadc);
				if(!empty($queryselectadc[0]['mname'])){ $mname = $queryselectadc[0]['mname'][0].". ";  }else{ $mname = ""; }
				if(!empty($queryselectadc[0]['suffix'])){ $suffix = " ".$queryselectadc[0]['suffix'];  }else{ $suffix = ""; }
				if(!empty($queryselectadc[0]['title'])){ $title = $queryselectadc[0]['title']." ";  }else{ $title = ""; }

				$full_nameadc   = utf8_encode(strtolower($queryselectadc[0]['fname']." ".$mname.$queryselectadc[0]['sname']));
				$nmadc     = str_replace('Ã±', '&ntilde;', $full_nameadc);
				$nameadc        = $title.ucwords(str_replace('ã±', '&ntilde;', $nmadc)).$suffix;

				if($queryselectadc[0]['plantilla_itemno'] == 'Chief' || $queryselectadc[0]['plantilla_itemno'] == 'Supervising' || $queryselectadc[0]['plantilla_itemno'] == 'Senior'){
					if(!empty($queryselectadc[0]['plantilla_itemno'])){
						$plantilla_itemnoadc = $queryselectadc[0]['plantilla_itemno']." ";  }else{ $plantilla_itemnoadc = ""; }
						$plantillaadc        = $plantilla_itemnoadc.$queryselectadc[0]['planpstn_desc'];
				}else{
					if(!empty($queryselectadc[0]['plantilla_itemno'])){
						$plantilla_itemnoadc = " ".$queryselectadc[0]['plantilla_itemno'];  }else{ $plantilla_itemnoadc = ""; }
						$plantillaadc        = $queryselectadc[0]['planpstn_desc'].$plantilla_itemnoadc;
				}

				$wheresctry       = $this->db->where('an.region = "'.$user_region.'" AND an.stat = "1" AND an.func = "Secretary" AND an.divno = "'.$divno.'" AND (an.secno = "" OR an.secno = "0")');
				$joinsctry        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
				$joinsctry        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
				$queryselectsctry = $this->Embismodel->selectdata('embis.acc_function AS an','an.func,acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,acs.plantilla_itemno,pn.planpstn_desc','',$wheresctry,$joinsctry);


				if($this->session->userdata('region') != 'CO'){
					// $qrysections = $this->db->query("SELECT `xt`.*, `xn`.`divname` FROM `embis`.`acc_xsect` AS `xt`
					// 	LEFT JOIN `embis`.`acc_xdvsion` AS `xn` ON `xn`.`divno` = `xt`.`divno`
					// 	WHERE  ORDER BY `xt`.`sect` ASC")->result_array();

					$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
					$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);

					for ($ns=0; $ns < sizeof($not_sect); $ns++) {
						$wheredv   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
					}
					$wheredv     = $this->db->where('xt.divno = "'.$divno.'" AND (xt.region = "R" OR xt.region = "'.$this->session->userdata('region').'") AND xt.secno != "69"');
					$orderbydv   = $this->db->order_by('xt.sect', 'ASC');
					$joindv      = $this->db->join('embis.acc_xdvsion AS xn', 'xn.divno = xt.divno', 'left');
					$qrysections = $this->Embismodel->selectdata('embis.acc_xsect AS xt','xt.*,xn.divname','',$wheredv,$joindv,$orderbydv);
					// echo $this->db->last_query();
				}else{
					$orderbydv   = $this->db->order_by('xt.sect', 'ASC');
					$wheredv     = $this->db->where('xt.divno', $divno);
					$wheredv     = $this->db->where('xt.region',$this->session->userdata('region'));
					$wheredv     = $this->db->where('xt.secno !=', '69');
					$joindv      = $this->db->join('embis.acc_xdvsion AS xn', 'xn.divno = xt.divno', 'left');
					$qrysections = $this->Embismodel->selectdata('embis.acc_xsect AS xt','xt.*,xn.divname','',$wheredv,$joindv,$orderbydv);
				}
					// echo $this->db->last_query(); exit;

			$orderbysc   = $this->db->order_by('acs.fname','ASC');
			$wheresc     = $this->db->where('an.divno', $divno);
			$wheresc     = $this->db->where('an.func', 'Section Chief');
			$wheresc     = $this->db->where('xn.cat !=', 'Division');
			$wheresc     = $this->db->where('an.stat', '1');
			$wheresc     = $this->db->where('acs.verified', '1');
			$wheresc     = $this->db->where('an.region', $user_region);
			$joinsc      = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
			$joinsc      = $this->db->join('embis.acc_xdvsion AS xn', 'xn.divno = an.divno', 'left');
			$joinsc      = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
			$queryselectsc = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,an.func,acs.plantilla_itemno,acs.plantilla_pos,pn.planpstn_desc','',$wheresc,$joinsc,$orderbysc);

		}
		else{

			if($divno == '14'){
				$secno 		   = '98';
				$orderby     = $this->db->order_by('acs.fname','ASC');
				$where       = $this->db->where('an.secno', $secno);
				$where       = $this->db->where('an.func', 'Staff');
				$where       = $this->db->where('an.stat', '1');
				$where       = $this->db->where('acs.verified', '1');
				$where       = $this->db->where('an.region', $user_region);
				$join        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
				$join        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
				$queryselect = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,an.func,acs.plantilla_itemno,pn.planpstn_desc','',$where,$join,$orderby);
				// echo $this->db->last_query(); exit;
			}

			if($divno == '17'){
				$secno 		   = '101';
				$orderby     = $this->db->order_by('acs.fname','ASC');
				$where       = $this->db->where('an.secno', $secno);
				$where       = $this->db->where('an.func', 'Staff');
				$where       = $this->db->where('an.stat', '1');
				$where       = $this->db->where('acs.verified', '1');
				$where       = $this->db->where('an.region', $user_region);
				$join        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
				$join        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
				$queryselect = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,an.func,acs.plantilla_itemno,pn.planpstn_desc','',$where,$join,$orderby);
				// echo $this->db->last_query(); exit;
			}
		}
	?>
	<?php if($divno != '14' AND $divno != '17'){ ?>
		<div class="row" style="padding-left:2px;padding-right:2px;">
			<?php if($queryselect[0]['userid'] != ''){ ?>
				<?php for ($i=0; $i < sizeof($queryselect); $i++) {
					if(!empty($queryselect[$i]['mname'])){ $mname = $queryselect[$i]['mname'][0].". ";  }else{ $mname = ""; }
					if(!empty($queryselect[$i]['suffix'])){ $suffix = " ".$queryselect[$i]['suffix'];  }else{ $suffix = ""; }
					if(!empty($queryselect[$i]['title'])){ $title = $queryselect[$i]['title']." ";  }else{ $title = ""; }
					$name 		 = strtolower($queryselect[$i]['fname']." ".$mname.$queryselect[$i]['sname']);

					if($queryselect[$i]['plantilla_itemno'] == 'Chief' || $queryselect[$i]['plantilla_itemno'] == 'Supervising' || $queryselect[$i]['plantilla_itemno'] == 'Senior'){
						if(!empty($queryselect[$i]['plantilla_itemno'])){
							$plantilla_itemno = $queryselect[$i]['plantilla_itemno']." ";
						}else{
							$plantilla_itemno = "";
						}
							if(!empty($queryselect[$i]['planpstn_desc'])){
								$plantilla        = $plantilla_itemno.$queryselect[$i]['planpstn_desc'];
							}else{
								$plantilla 	  = "--";
							}
					}else{
						if(!empty($queryselect[$i]['plantilla_itemno'])){
							$plantilla_itemno = " ".$queryselect[$i]['plantilla_itemno'];
						}else{
							$plantilla_itemno = "";
						}

						if(!empty($queryselect[$i]['planpstn_desc'])){
							$plantilla        = $queryselect[$i]['planpstn_desc'].$plantilla_itemno;
						}else{
							$plantilla 		  = "--";
						}
					}
				?>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;"><?php echo $queryselect[$i]['func']; ?></span></label>
					<input type="text" class="form-control" value="<?php echo $title.ucwords($name).$suffix; ?>" disabled>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
					<input type="text" class="form-control" title="<?php echo ucwords($queryselect[$i]['designation']); ?>" value="<?php echo $queryselect[$i]['designation']; ?>" disabled>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
					<input type="text" class="form-control" title="<?php echo $plantilla; ?>" value="<?php echo $plantilla; ?>" disabled>
				</div>
				<?php } ?>
			<?php } ?>

			<?php if($queryselectadc[0]['userid'] != ''){ //Assistant Division Chief ?>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;">Assistant Division Chief</span></label>
					<input type="text" class="form-control" value="<?php echo $nameadc; ?>" disabled>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
					<input type="text" class="form-control" title="<?php echo $queryselectadc[0]['designation']; ?>" value="<?php echo $queryselectadc[0]['designation']; ?>" disabled>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
					<input type="text" class="form-control" title="<?php echo $plantillaadc; ?>" value="<?php echo $plantillaadc; ?>" disabled>
				</div>
			<?php } ?>

			<?php if($queryselectsctry[0]['userid'] != ''){  //Division Secretary ?>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;"><?php echo $queryselectsctry[0]['func']; ?></span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
			<?php
				for ($qs=0; $qs < sizeof($queryselectsctry); $qs++) {
				if(!empty($queryselectsctry[$qs]['mname'])){ $mname = $queryselectsctry[$qs]['mname'][0].". ";  }else{ $mname = ""; }
				if(!empty($queryselectsctry[$qs]['suffix'])){ $suffix = " ".$queryselectsctry[$qs]['suffix'];  }else{ $suffix = ""; }
				if(!empty($queryselectsctry[$qs]['title'])){ $title = $queryselectsctry[$qs]['title']." ";  }else{ $title = ""; }

				$full_namesctry   = utf8_encode(strtolower($queryselectsctry[$qs]['fname']." ".$mname.$queryselectsctry[$qs]['sname']));
				$nmsctry          = str_replace('Ã±', '&ntilde;', $full_namesctry);
				$namesctry        = $title.ucwords(str_replace('ã±', '&ntilde;', $nmsctry)).$suffix;

				if($queryselectsctry[$qs]['plantilla_itemno'] == 'Chief' || $queryselectsctry[$qs]['plantilla_itemno'] == 'Supervising' || $queryselectsctry[$qs]['plantilla_itemno'] == 'Senior'){
					if(!empty($queryselectsctry[$qs]['plantilla_itemno'])){
						$plantilla_itemnosctry = $queryselectsctry[$qs]['plantilla_itemno']." ";  }else{ $plantilla_itemnosctry = ""; }
						$plantillasctry        = $plantilla_itemnosctry.$queryselectsctry[$qs]['planpstn_desc'];
				}else{
					if(!empty($queryselectsctry[$qs]['plantilla_itemno'])){
						$plantilla_itemnosctry = " ".$queryselectsctry[$qs]['plantilla_itemno'];  }else{ $plantilla_itemnosctry = ""; }
						$plantillasctry        = $queryselectsctry[$qs]['planpstn_desc'].$plantilla_itemnosctry;
				}
			?>
				<div class="col-md-4" style="margin-top: 10px;">
					<input type="text" class="form-control" value="<?php echo $namesctry; ?>" disabled>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<input type="text" class="form-control" title="<?php echo ucwords($queryselectsctry[$qs]['designation']); ?>" value="<?php echo $queryselectsctry[$qs]['designation']; ?>" disabled>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<input type="text" class="form-control" title="<?php echo $plantillasctry; ?>" value="<?php echo $plantillasctry; ?>" disabled>
				</div>
			<?php } } ?>

			<?php if($queryselectsc[0]['userid'] != '' AND $divno != '1'){ ?>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;"><?php echo $queryselectsc[0]['func'] ?></span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
				<?php for ($i=0; $i < sizeof($queryselectsc); $i++) {
					if(!empty($queryselectsc[$i]['mname'])){ $mname = $queryselectsc[$i]['mname'][0].". ";  }else{ $mname = ""; }
					if(!empty($queryselectsc[$i]['suffix'])){ $suffix = " ".$queryselectsc[$i]['suffix'];  }else{ $suffix = ""; }
					if(!empty($queryselectsc[$i]['title'])){ $title = $queryselectsc[$i]['title']." ";  }else{ $title = ""; }
					$namesc 		 = strtolower($queryselectsc[$i]['fname']." ".$mname.$queryselectsc[$i]['sname']);

					if($queryselectsc[$i]['plantilla_itemno'] == 'Chief' || $queryselectsc[$i]['plantilla_itemno'] == 'Supervising' || $queryselectsc[$i]['plantilla_itemno'] == 'Senior'){
						if(!empty($queryselectsc[$i]['plantilla_itemno'])){
							$plantilla_itemnosc = $queryselectsc[$i]['plantilla_itemno']." ";
						}else{
							$plantilla_itemnosc = "";
						}
							if(!empty($queryselectsc[$i]['planpstn_desc'])){
								$plantillasc        = $plantilla_itemnosc.$queryselectsc[$i]['planpstn_desc'];
							}else{
								$plantillasc 	  = "";
							}
					}else{
						if(!empty($queryselectsc[$i]['plantilla_itemno'])){
							$plantilla_itemnosc = " ".$queryselectsc[$i]['plantilla_itemno'];
						}else{
							$plantilla_itemnosc = "";
						}

						if(!empty($queryselectsc[$i]['planpstn_desc'])){
							$plantillasc        = $queryselectsc[$i]['planpstn_desc'].$plantilla_itemnosc;
						}else{
							$plantillasc 		  = "";
						}
					}
				?>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" value="<?php echo $title.ucwords($namesc).$suffix; ?>" disabled>
					</div>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" title="<?php echo ucwords($queryselectsc[$i]['designation']); ?>" value="<?php echo $queryselectsc[$i]['designation']; ?>" disabled>
					</div>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" title="<?php echo $plantillasc; ?>" value="<?php echo $plantillasc; ?>" disabled>
					</div>
				<?php } ?>
	  	<?php } ?>

			<?php if($queryselectstf[0]['userid'] != ''){ //Division Staffs  ?>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;">Staff</span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
				<?php for ($stf=0; $stf < sizeof($queryselectstf); $stf++){
					if(!empty($queryselectstf[$stf]['mname'])){ $mnamestf = $queryselectstf[$stf]['mname'][0].". ";  }else{ $mnamestf = ""; }
					if(!empty($queryselectstf[$stf]['suffix'])){ $suffixstf = " ".$queryselectstf[$stf]['suffix'];  }else{ $suffixstf = ""; }
					if(!empty($queryselectstf[$stf]['title'])){ $title = $queryselectstf[$stf]['title']." ";  }else{ $title = ""; }

					$full_namestf   = utf8_encode(strtolower($queryselectstf[$stf]['fname']." ".$mnamestf.$queryselectstf[$stf]['sname']));
					$nmestf         = str_replace('Ã±', '&ntilde;', $full_namestf);
					$namestf        = $title.ucwords(str_replace('ã±', '&ntilde;', $nmestf)).$suffixstf;

					if($queryselectstf[$stf]['plantilla_itemno'] == 'Chief' || $queryselectstf[$stf]['plantilla_itemno'] == 'Supervising' || $queryselectstf[$stf]['plantilla_itemno'] == 'Senior'){
						if(!empty($queryselectstf[$stf]['plantilla_itemno'])){
							$plantilla_itemnostf = $queryselectstf[$stf]['plantilla_itemno']." ";  }else{ $plantilla_itemnostf = ""; }
							$plantillastf        = $plantilla_itemnostf.$queryselectstf[$stf]['planpstn_desc'];
					}else{
						if(!empty($queryselectstf[$stf]['plantilla_itemno'])){
							$plantilla_itemnostf = " ".$queryselectstf[$stf]['plantilla_itemno'];
						}else{
							$plantilla_itemnostf = "";
						}
							$plantillastf        = $queryselectstf[$stf]['planpstn_desc'].$plantilla_itemnostf;
					}
				?>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" value="<?php echo $namestf; ?>" disabled>
					</div>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" title="<?php echo ucwords($queryselectstf[$stf]['designation']); ?>" value="<?php echo $queryselectstf[$stf]['designation']; ?>" disabled>
					</div>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" title="<?php echo $plantillastf; ?>" value="<?php echo $plantillastf; ?>" disabled>
					</div>
				<?php } ?>
			<?php } ?>

		</div>
		<?php if($qrysections[0]['secno'] != ''){ ?>
			<button style="color:#FFF;background-color:#08507E;" class="btn btn-default btn-sm" id="buttonassignsec">
				Section/Unit
			</button>
			<?php for($i=0; $i < sizeof($qrysections); $i++){ ?>
				<button onclick="user_assignment(<?php echo $qrysections[$i]['secno']; ?>);" style="border-color:#08507E;" class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapsenormal<?php echo $qrysections[$i]['secno']; ?>" aria-expanded="false" aria-controls="collapsenormal<?php echo $qrysections[$i]['secno']; ?>" id="buttonassignsec">
				<?php echo $qrysections[$i]['sect']; ?>
					<span class="fa fa-caret-down" id="btncaretsub"></span>
					<span style="float:right;margin-right:5px;color:#000;"><?php echo $qrysections[$i]['divname']; ?></span>
				</button>
				<div class="collapse" id="collapsenormal<?php echo $qrysections[$i]['secno']; ?>">
				<div class="card card-body" style="margin-top:10px;padding-left:2px;padding-right:2px;border:none;">
					<div id="user_assignment_<?php echo $qrysections[$i]['secno']; ?>"></div>
				</div>
				</div>
			<?php } ?>
		<?php } ?>
  <?php }
	else{ ?>
		<div class="row" style="padding-left:0px;padding-right:0px;">

		<?php if($queryselect[0]['userid'] != ''){ ?>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;">Staff</span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
				<?php for ($i=0; $i < sizeof($queryselect); $i++) {
					if(!empty($queryselect[$i]['mname'])){ $mname = $queryselect[$i]['mname'][0].". ";  }else{ $mname = ""; }
					if(!empty($queryselect[$i]['suffix'])){ $suffix = " ".$queryselect[$i]['suffix'];  }else{ $suffix = ""; }
					if(!empty($queryselect[$i]['title'])){ $title = $queryselect[$i]['title']." ";  }else{ $title = ""; }
					$name 		 = strtolower($queryselect[$i]['fname']." ".$mname.$queryselect[$i]['sname']);

					if($queryselect[$i]['plantilla_itemno'] == 'Chief' || $queryselect[$i]['plantilla_itemno'] == 'Supervising' || $queryselect[$i]['plantilla_itemno'] == 'Senior'){
						if(!empty($queryselect[$i]['plantilla_itemno'])){
							$plantilla_itemno = $queryselect[$i]['plantilla_itemno']." ";
						}else{
							$plantilla_itemno = "";
						}
							if(!empty($queryselect[$i]['planpstn_desc'])){
								$plantilla        = $plantilla_itemno.$queryselect[$i]['planpstn_desc'];
							}else{
								$plantilla 	  = "";
							}
					}else{
						if(!empty($queryselect[$i]['plantilla_itemno'])){
							$plantilla_itemno = " ".$queryselect[$i]['plantilla_itemno'];
						}else{
							$plantilla_itemno = "";
						}

						if(!empty($queryselect[$i]['planpstn_desc'])){
							$plantilla        = $queryselect[$i]['planpstn_desc'].$plantilla_itemno;
						}else{
							$plantilla 		  = "";
						}
					}
				?>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" value="<?php echo $title.ucwords($name).$suffix; ?>" disabled>
					</div>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" title="<?php echo ucwords($queryselect[$i]['designation']); ?>" value="<?php echo $queryselect[$i]['designation']; ?>" disabled>
					</div>
					<div class="col-md-4" style="margin-top: 10px;">
						<input type="text" class="form-control" title="<?php echo $plantilla; ?>" value="<?php echo $plantilla; ?>" disabled>
					</div>
				<?php } ?>

		<?php }else{ ?>
			<!-- <br><center><i style="color:red;">No data found</i></center><br> -->
		<?php } ?>
			</div>
	<?php } ?>
		<?php
	}

	function user_assignment(){
		$user_region = $this->session->userdata('region');
		$secno 		   = $this->input->post('secno');

		$orderby     = $this->db->order_by('acs.fname','ASC');
		$where       = $this->db->where('an.secno', $secno);
		$where       = $this->db->where('an.func', 'Staff');
		$where       = $this->db->where('an.stat', '1');
		$where       = $this->db->where('acs.verified', '1');
		$where       = $this->db->where('an.region', $user_region);
		$join        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
		$join        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
		$queryselect = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,an.func,acs.plantilla_itemno,pn.planpstn_desc','',$where,$join,$orderby);

		$secno 		        = $this->input->post('secno');
		$orderbysctry     = $this->db->order_by('acs.fname','ASC');
		$wheresctry       = $this->db->where('an.secno', $secno);
		$wheresctry       = $this->db->where('an.func', 'Secretary');
		$wheresctry       = $this->db->where('an.stat', '1');
		$wheresctry       = $this->db->where('acs.verified', '1');
		$wheresctry       = $this->db->where('an.region', $user_region);
		$joinsctry        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
		$joinsctry        = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
		$queryselectsctry = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,an.func,acs.plantilla_itemno,pn.planpstn_desc','',$wheresctry,$joinsctry,$orderby);

		$orderbysc   = $this->db->order_by('acs.fname','ASC');
		$wheresc     = $this->db->where('an.secno = "'.$secno.'" AND (an.func = "Section Chief" OR an.func = "Unit Chief") AND an.stat = "1" AND acs.verified = "1" AND an.region = "'.$user_region.'"');
		$joinsc      = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = an.userid', 'left');
		$joinsc      = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
		$queryselectsc = $this->Embismodel->selectdata('embis.acc_function AS an','acs.title,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix,acs.divno,acs.designation,an.func,acs.plantilla_itemno,acs.plantilla_pos,pn.planpstn_desc','',$wheresc,$joinsc,$orderbysc);

		?>

		<?php if(!empty($queryselectsc[0]['userid'])){ ?>
			<div class="row" style="padding-left:0px;padding-right:0px;">
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;"><?php echo $queryselectsc[0]['func']; ?></span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
				<?php
					for($i=0; $i<sizeof($queryselectsc); $i++){
						if(!empty($queryselectsc[$i]['mname'])){  $mname  = $queryselectsc[$i]['mname'][0].". "; }else{ $mname = ""; }
						if(!empty($queryselectsc[$i]['suffix'])){ $suffix = " ".$queryselectsc[$i]['suffix'];    }else{ $suffix = ""; }
						if(!empty($queryselectsc[$i]['title'])){ $title = $queryselectsc[$i]['title']." ";    }else{ $title = ""; }
						$namestf = utf8_encode(strtolower($queryselectsc[$i]['fname']." ".$mname.$queryselectsc[$i]['sname']));
						$namesff = str_replace('Ã±', '&ntilde;', $namestf);
						$name    = ucwords(str_replace('ã±', '&ntilde;', $namesff)).$suffix;
						if($i > '0'){
							$style = "margin-top:10px";
						}else{
							$style = "";
						}

						if(empty($queryselectsc[$i]['plantilla_itemno']) AND empty($queryselectsc[$i]['plantilla_pos'])){
							$plantillasc = "";
						}else{
							if($queryselectsc[$i]['plantilla_itemno'] == 'Chief' || $queryselectsc[$i]['plantilla_itemno'] == 'Supervising' || $queryselectsc[$i]['plantilla_itemno'] == 'Senior'){
								if(!empty($queryselectsc[$i]['plantilla_itemno'])){
									$plantilla_itemnosc = $queryselectsc[$i]['plantilla_itemno']." ";  }else{ $plantilla_itemnosc = ""; }
									$plantillasc        = $plantilla_itemnosc.$queryselectsc[$i]['planpstn_desc'];
							}else{
								if(!empty($queryselectsc[$i]['plantilla_itemno'])){
									$plantilla_itemnosc = " ".$queryselectsc[$i]['plantilla_itemno'];  }else{ $plantilla_itemnosc = ""; }
									$plantillasc        = $queryselectsc[$i]['planpstn_desc'].$plantilla_itemnosc;
							}
						}
				?>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $title.$name; ?>" disabled>
					</div>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo ucwords($queryselectsc[$i]['designation']); ?>" disabled>
					</div>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $plantillasc; ?>" disabled>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

		<?php if($queryselectsctry[0]['userid'] != ''){ ?>
			<div class="row" style="padding-left:0px;padding-right:0px;">
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;">Section Secretary</span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
				<?php
					for($i=0; $i<sizeof($queryselectsctry); $i++){
						if(!empty($queryselectsctry[$i]['mname'])){  $mname  = $queryselectsctry[$i]['mname'][0].". "; }else{ $mname = ""; }
						if(!empty($queryselectsctry[$i]['suffix'])){ $suffix = " ".$queryselectsctry[$i]['suffix'];    }else{ $suffix = ""; }
						if(!empty($queryselectsctry[$i]['title'])){ $title = $queryselectsctry[$i]['title']." ";    }else{ $title = ""; }
						$namestf = utf8_encode(strtolower($queryselectsctry[$i]['fname']." ".$mname.$queryselectsctry[$i]['sname']));
						$namesff = str_replace('Ã±', '&ntilde;', $namestf);
						$name    = ucwords(str_replace('ã±', '&ntilde;', $namesff)).$suffix;
						if($i > '0'){
							$style = "margin-top:10px";
						}else{
							$style = "";
						}
						if($queryselectsctry[$i]['plantilla_itemno'] == 'Chief' || $queryselectsctry[$i]['plantilla_itemno'] == 'Supervising' || $queryselectsctry[$i]['plantilla_itemno'] == 'Senior'){

						if(!empty($queryselectsctry[$i]['plantilla_itemno'])){
								$plantilla_itemnosctry = $queryselectsctry[$i]['plantilla_itemno']." ";  }else{ $plantilla_itemnosctry = ""; }
								$plantillasctry        = $plantilla_itemnosctry.$queryselectsctry[$i]['planpstn_desc'];
						}else{
							if(!empty($queryselectsctry[$i]['plantilla_itemno'])){
								$plantilla_itemnosctry = " ".$queryselectsctry[$i]['plantilla_itemno'];  }else{ $plantilla_itemnosctry = ""; }
								$plantillasctry        = $queryselectsctry[$i]['planpstn_desc'].$plantilla_itemnosctry;
						}
				?>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $title.$name; ?>" disabled>
					</div>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo ucwords($queryselectsctry[$i]['designation']); ?>" disabled>
					</div>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $plantillasctry; ?>" disabled>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

		<?php if($queryselect[0]['userid'] != ''){ ?>
			<div class="row">
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Name<span style="float:right;margin-right:5px;font-size:8pt;margin-top:3px;"><?php echo $queryselect[0]['func']; ?></span></label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Designation</label>
				</div>
				<div class="col-md-4" style="margin-top: 10px;">
					<label id="labelname">Plantilla Position</label>
				</div>
				<?php
					for($i=0; $i<sizeof($queryselect); $i++){
						if(!empty($queryselect[$i]['mname'])){  $mname  = $queryselect[$i]['mname'][0].". "; }else{ $mname = ""; }
						if(!empty($queryselect[$i]['suffix'])){ $suffix = " ".$queryselect[$i]['suffix'];    }else{ $suffix = ""; }
						if(!empty($queryselect[$i]['title'])){ $title = $queryselect[$i]['title']." ";    }else{ $title = ""; }
						$namestf = utf8_encode(strtolower($queryselect[$i]['fname']." ".$mname.$queryselect[$i]['sname']));
						$namesff = str_replace('Ã±', '&ntilde;', $namestf);
						$name    = ucwords(str_replace('ã±', '&ntilde;', $namesff)).$suffix;
						if($i > '0'){
							$style = "margin-top:10px";
						}else{
							$style = "";
						}
						if($queryselect[$i]['plantilla_itemno'] == 'Chief' || $queryselect[$i]['plantilla_itemno'] == 'Supervising' || $queryselect[$i]['plantilla_itemno'] == 'Senior'){
						if(!empty($queryselect[$i]['plantilla_itemno'])){
							$plantilla_itemno = $queryselect[$i]['plantilla_itemno']." ";  }else{ $plantilla_itemno = ""; }
							$plantilla        = $plantilla_itemno.$queryselect[$i]['planpstn_desc'];
						}else{
							if(!empty($queryselect[$i]['plantilla_itemno'])){
								$plantilla_itemno = " ".$queryselect[$i]['plantilla_itemno'];  }else{ $plantilla_itemno = ""; }
								$plantilla        = $queryselect[$i]['planpstn_desc'].$plantilla_itemno;
						}
				?>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $title.$name; ?>" disabled>
					</div>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $queryselect[$i]['designation']; ?>" disabled>
					</div>
					<div class="col-md-4" style="<?php echo $style; ?>;">
						<input type="text" class="form-control" value="<?php echo $plantilla; ?>" disabled>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

		<?php if($queryselect[0]['userid'] == '' && empty($queryselectsc[0]['userid'])){ ?>
				<!-- <center><i style="color:red;">No data found</i></center> -->
		<?php } ?>

	<?php
	}

	function sec_details(){
		$div_token 	   = $this->encrypt->decode($this->input->post('div_token'));
		$wheredivision = $this->db->where('xn.token',$div_token);
		$querydivision = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divno','',$wheredivision);

		if($this->session->userdata('region') == 'CO'){ $region = 'CO'; }else{ $region = 'R'; }
		$region_name = $this->session->userdata('region');
		$divno         = $querydivision[0]['divno'];

		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.divno = "'.$divno.'" AND (xt.region = "'.$region.'" OR xt.region = "'.$region_name.'")');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$querysection     = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);
		// echo $this->db->last_query();
	?>

		<label>Section</label>
		<select class="form-control" id="nsection_selectize_assign" name="section" required="">
			<option></option>
			<option value="N/A">N/A</option>
			<?php for($i=0; $i<sizeof($querysection); $i++){ ?>
				<option value="<?php echo $this->encrypt->encode($querysection[$i]['secno']); ?>"><?php echo $querysection[$i]['sect']; ?></option>
			<?php } ?>
		</select>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#nsection_selectize_assign').selectize();
			});
		</script>
	<?php
	}

	function transfer_sec_details(){
		$div_token 	   = $this->encrypt->decode($this->input->post('div_token'));
		$token 	   = ($this->input->post('token'));

		$wheredivision = $this->db->where('xn.token',$div_token);
		$querydivision = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divno','',$wheredivision);

		if($this->session->userdata('region') == 'CO'){ $region = 'CO'; }else{ $region = 'R'; }
		$region_name = $this->session->userdata('region');
		$divno         = $querydivision[0]['divno'];

		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.divno = "'.$divno.'" AND (xt.region = "'.$region.'" OR xt.region = "'.$region_name.'")');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$querysection     = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);
		// echo $this->db->last_query();
	?>

		<label>Section</label>
		<select class="form-control" id="nsection_selectize_assign<?php echo $token; ?>" name="dflt_user_section" required="">
			<option></option>
			<option value="<?php echo $this->encrypt->encode('N/A'); ?>">N/A</option>
			<?php for($i=0; $i<sizeof($querysection); $i++){ ?>
				<option value="<?php echo $this->encrypt->encode($querysection[$i]['secno']); ?>"><?php echo $querysection[$i]['sect']; ?></option>
			<?php } ?>
		</select>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#nsection_selectize_assign<?php echo $token; ?>').selectize();
			});
		</script>
	<?php
	}

	function rplctransfer_sec_details_(){
		$div_token 	   = $this->encrypt->decode($this->input->post('div_token'));
		$token 	   = ($this->input->post('token'));

		$wheredivision = $this->db->where('xn.token',$div_token);
		$querydivision = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divno','',$wheredivision);

		if($this->session->userdata('region') == 'CO'){ $region = 'CO'; }else{ $region = 'R'; }
		$region_name = $this->session->userdata('region');
		$divno         = $querydivision[0]['divno'];

		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.divno = "'.$divno.'" AND (xt.region = "'.$region.'" OR xt.region = "'.$region_name.'")');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$querysection     = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);
		// echo $this->db->last_query();
	?>

		<label>Section</label>
		<select class="form-control" id="nsection_selectize_assign<?php echo $token; ?>" name="rplc_user_section" required="">
			<option></option>
			<option value="<?php echo $this->encrypt->encode('N/A'); ?>">N/A</option>
			<?php for($i=0; $i<sizeof($querysection); $i++){ ?>
				<option value="<?php echo $this->encrypt->encode($querysection[$i]['secno']); ?>"><?php echo $querysection[$i]['sect']; ?></option>
			<?php } ?>
		</select>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#nsection_selectize_assign<?php echo $token; ?>').selectize();
			});
		</script>
	<?php
	}

	function edit_sec_details_modal(){
		$div_token 	   = $this->encrypt->decode($this->input->post('div_token'));
		$wheredivision = $this->db->where('xn.divno',$div_token);
		$querydivision = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divno','',$wheredivision);

		if($this->session->userdata('region') == 'CO'){ $region = 'CO'; }else{ $region = 'R'; }
		$region_name = $this->session->userdata('region');

		$divno         = $querydivision[0]['divno'];

		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.divno = "'.$divno.'" AND (xt.region = "'.$region.'" OR xt.region = "'.$region_name.'")');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$querysection     = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);

	?>

		<label>Section</label>
		<select class="form-control" id="section_selectize_assign" name="section" required="">
			<option></option>
			<option value="N/A">N/A</option>
			<?php for($i=0; $i<sizeof($querysection); $i++){ ?>
				<option value="<?php echo $this->encrypt->encode($querysection[$i]['secno']); ?>"><?php echo $querysection[$i]['sect']; ?></option>
			<?php } ?>
		</select>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#section_selectize_assign').selectize();
			});
		</script>
	<?php
	}

	function rule_rows(){
		$number 			= $this->encrypt->decode($this->input->post('number'));
		$user_region 		= $this->session->userdata('region');

		// $whereuseraccounts	= $this->db->or_where('af.func = "Director" OR af.func = "Assistant Director"');
		if($user_region != 'CO'){
			$whereuseraccounts	= $this->db->where('(af.stat = "1" AND acs.verified != "2" AND af.func != "Administrator" AND acs.region = "'.$user_region.'") OR (af.func = "Director" OR af.func = "Assistant Director") ORDER BY af.func_order ASC, acs.fname ASC');
		}else{
			if($_SESSION['superadmin_rights'] == 'yes'){
				$whereuseraccounts	= $this->db->where('af.stat = "1" AND acs.verified != "2" AND af.func != "Administrator" AND acs.region = "'.$user_region.'" ORDER BY af.func_order ASC, acs.fname ASC');
			}else{
				$whereuseraccounts	= $this->db->where('(af.stat = "1" AND acs.verified != "2" AND af.func != "Administrator" AND acs.region = "'.$user_region.'" AND (acs.office = "'.$this->session->userdata('office').'" AND af.func = "Regional Executive Director")) OR (af.func = "Director" OR af.func = "Assistant Director") ORDER BY af.func_order ASC, acs.fname ASC');
			}
		}

		// $order_byaccounts  	= $this->db->order_by('acs.fname', 'ASC');
		$joinuseraccounts   = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
		$joinuseraccounts   = $this->db->join('embis.acc_function AS af', 'af.userid = acs.userid', 'left');
		$useraccounts       = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.*,af.func','',$joinuseraccounts,$whereuseraccountss);

		// $whererdexist  = $this->db->where('af.region',$user_region);
		// $whererdexist  = $this->db->where('af.stat','1');
		// $whererdexist  = $this->db->where('acs.verified','1');
		// $whererdexist  = $this->db->where('af.func','Regional Director');
		// $joinrdexist   = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
		// $selectrdexist = $this->Embismodel->selectdata('acc_function AS af','acs.title,acs.userid, acs.fname, acs.mname, acs.sname, acs.suffix','',$joinrdexist,$whererdexist);
		if($user_region != 'CO'){
			$var = '1'; //$var = '3';
		}else{
			$var = '1'; //$var = '2';
		}

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
			<div class="row" style="margin-top:10px;">
						<!-- <div class="col-md-10">
		            <label>Name</label>
		            <select class="form-control" name="employee[]" readonly="">
		            	<option value="<?php echo $this->encrypt->encode($selectdirector[0]['userid']); ?>"><?php echo $directorname; ?></option>
		            </select>
		      	</div>
		      	<div class="col-md-2">
		            <label>Hierarchy <span class="fa fa-info-circle" style="color:orange;" title="Highest to lowest ranking superior"></span></label>
		            <input type="text" class="form-control" value="1" required="" readonly="">
		            <input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode('1'); ?>" required="" readonly="">
		      	</div>
		      	<?php if($user_region != 'CO'){ ?>
		      	<div class="col-md-10" style="margin-top:10px;">
		            <select class="form-control" name="employee[]" readonly="">
		            	<option value="<?php echo $this->encrypt->encode($selectadirector[0]['userid']); ?>"><?php echo $adname; ?></option>
		            </select>
		      	</div>
		      	<div class="col-md-2" style="margin-top:10px;">
		      		<input type="text" class="form-control" value="2" required="" readonly="">
		            <input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode('2'); ?>" required="" readonly="">
		      	</div>
						<?php } ?> -->

						<?php
							// if(!empty($selectrdexist[0]['userid'])){
							// 	$mname = !empty($selectrdexist[0]['mname']) ? $selectrdexist[0]['mname'][0].". " : '';
							// 	$suffix = !empty($selectrdexist[0]['suffix']) ? " ".$selectrdexist[0]['suffix'] : '';
							// 	$prefix = !empty($selectrdexist[0]['title']) ? $selectrdexist[0]['title']." " : '';
							// 	$nmstr  = str_replace('Ã±', '&ntilde;', $selectrdexist[0]['fname']." ".$mname.$selectrdexist[0]['sname']);
							// 	$rdname = $prefix.ucwords(str_replace('ã±', '&ntilde;', $nmstr)).$suffix;

						?>


		      	<?php //} ?>
				<?php for ($i=$var; $i <=$number && $i <= 9; $i++) { ?>
					<div class="col-md-10" style="margin-top:10px;">
			            <select id="employee_selectize_rule<?php echo $i; ?>" class="form-control" name="employee[]" required>
			                <option></option>
			              <?php
			                for ($a=0; $a < sizeof($useraccounts); $a++) {
			                  if(!empty($useraccounts[$a]['mname'])){ $mname = $useraccounts[$a]['mname'][0].". "; }else{ $mname = ""; }
			                  if(!empty($useraccounts[$a]['suffix'])){ $suffix = " ".$useraccounts[$a]['suffix']; }else{ $suffix = ""; }
												$prefix = !empty($useraccounts[$a]['title']) ? $useraccounts[$a]['title']." " : '';
												$nmstr   = str_replace('Ã±', '&ntilde;', $useraccounts[$a]['fname']." ".$mname.$useraccounts[$a]['sname']);
												$empname = $prefix.ucwords(str_replace('ã±', '&ntilde;', $nmstr)).$suffix;
			              ?>
			                <optgroup label="<?php echo $useraccounts[$a]['office'].' - '.$useraccounts[$a]['func']; ?>">
			                	<option value="<?php echo $this->encrypt->encode($useraccounts[$a]['userid']); ?>"><?php echo $empname; ?></option>
			                </optgroup>
			              <?php } ?>
			            </select>
			      	</div>
			      	<div class="col-md-2" style="margin-top:10px;">
			            <input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode($i); ?>" required="" readonly="">
			            <input type="text" class="form-control" value="<?php echo $i; ?>" required="" readonly="">
			      	</div>

			      	<script>
						$(document).ready( function(){
							$('#employee_selectize_rule<?php echo $i; ?>').selectize();
						});
					</script>
				<?php } ?>
			</div>
		<?php
	}

	function ruledetails(){
		$rulename = $this->encrypt->decode($this->input->post('rulename'));
		$mode     = $this->input->post('mode');
		if(!empty($rulename)){
			if($rulename == 'notinthelist'){ ?>
				<hr>
				<div class="row">
					<div class="col-md-12">
            <label>Select number of rows:: <span style="color: red; font-size: 9pt;">(custom)</span></label>
            <select class="form-control" id="no_rows_selectize" onchange="rule_rows(this.value,<?php echo $mode; ?>);" name="no_rows" required="">
              <option></option>
              <option value="<?php echo $this->encrypt->encode('1'); ?>">1</option>
              <option value="<?php echo $this->encrypt->encode('2'); ?>">2</option>
              <option value="<?php echo $this->encrypt->encode('3'); ?>">3</option>
              <option value="<?php echo $this->encrypt->encode('4'); ?>">4</option>
              <option value="<?php echo $this->encrypt->encode('5'); ?>">5</option>
              <option value="<?php echo $this->encrypt->encode('6'); ?>">6</option>
              <option value="<?php echo $this->encrypt->encode('7'); ?>">7</option>
              <option value="<?php echo $this->encrypt->encode('8'); ?>">8</option>
              <option value="<?php echo $this->encrypt->encode('9'); ?>">9</option>
            </select>
          </div>
					<?php if($mode == '1'){ ?>
          	<!-- <div id="rule_rows_body" class="col-md-12"></div> -->
						<div id="rule_rows_body_two" class="col-md-12"></div>
					<?php }else if($mode == '2'){ ?>
						<div id="edit_rule_rows_body" class="col-md-12"></div>
					<?php }else if($mode == '3'){ ?>
						<div id="rule_rows_body_two" class="col-md-12"></div>
					<?php } ?>
				</div> <?php
			}else{
					$ordeby   = $this->db->order_by('rule_order','ASC');
					$where    = $this->db->where('ar.rule_name',$rulename);
					$where    = $this->db->where('ar.region',$this->session->userdata('region'));
					$join     = $this->db->join('acc_credentials AS ac','ac.userid = rule_userid', 'left');
					$query    = $this->Embismodel->selectdata('embis.acc_rule AS ar','ac.userid,ac.title,ac.fname,ac.mname,ac.sname,ac.suffix,ar.rule_order','',$where,$join,$ordeby); ?>
					<hr>
					<div class="row">
							<div class="col-md-10" style="margin-top:10px;margin-bottom:-10px;">
				              <label>Employee Name</label>
				            </div>
				            <div class="col-md-2" style="margin-top:10px;margin-bottom:-10px;">
				              <label>Hierarchy</label>
				            </div>

						<?php for ($i=0; $i < sizeof($query); $i++) {
							if(!empty($query[$i]['mname'])){ $mname = $query[$i]['mname'][0].". "; }else{ $mname = ""; }
							if(!empty($query[$i]['suffix'])){ $suffix = " ".$query[$i]['suffix']; }else{ $suffix = ""; }
							if(!empty($query[$i]['title'])){ $title = $query[$i]['title']." "; }else{ $title = ""; }
						?>
							<div class="col-md-10" style="margin-top:10px;">
				              <select class="form-control" name="employee[]" required readonly>
				                <option value="<?php echo $this->encrypt->encode($query[$i]['userid']); ?>"><?php echo $title.ucwords($query[$i]['fname']." ".$mname.$query[$i]['sname']).$suffix; ?></option>
				           	  </select>
				            </div>
				            <div class="col-md-2" style="margin-top:10px;">
											<input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode($query[$i]['rule_order']); ?>" required>
											<input type="text" class="form-control" value="<?php echo $query[$i]['rule_order']; ?>" required readonly>
				            </div>
						<?php } ?>
					</div>
			<?php } ?>
		<?php } ?>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#no_rows_selectize').selectize();
			});
		</script>
	<?php
	}

	function under_sec_employee(){
		$secno 			= $this->input->post('secno');
		$user_region 	= $this->session->userdata('region');
		$qryemployees   = $this->db->query("SELECT `acs`.`token`, `acs`.`fname`, `acs`.`mname`, `acs`.`sname`, `acs`.`suffix`
			FROM `embis`.`acc_credentials` AS `acs`
			LEFT JOIN `embis`.`acc_function` AS `an` ON `an`.`userid` = `acs`.`userid`
			WHERE `an`.`region` = '$user_region' AND `an`.`secno` = '$secno'
			AND (`an`.`func` = 'Section Chief' OR `an`.`func` = 'Staff' OR `an`.`func` = 'Secretary')
			AND `an`.`stat` = '1' ORDER BY `acs`.`fname` ASC")->result(); //echo $this->db->last_query(); exit; ?>

		<label>Employee</label>
		<select id="employee_settings_selectize" class="form-control" name="employee" required>
			<option></option>
				<?php
					for($i=0; $i < sizeof($qryemployees); $i++){
						if(!empty($qryemployees[$i]->mname)){
							$mname  = $qryemployees[$i]->mname[0].". "; }else{ $mname = ""; }
						if(!empty($qryemployees[$i]->suffix)){
							$suffix = " ".$qryemployees[$i]->suffix; }else{ $suffix = ""; }
							$name   = ucwords($qryemployees[$i]->fname." ".$mname.$qryemployees[$i]->sname).$suffix;
				?>
					<option value="<?php echo $qryemployees[$i]->token; ?>"><?php echo $name; ?></option>
				<?php } ?>
		</select>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#employee_settings_selectize').selectize();
			});
		</script>
	<?php
	}

	function edit_plantilla_details(){
		$planpstn_id = $this->input->post('planpstn_id');
		$where       = $this->db->where('ap.planpstn_id',$planpstn_id);
		$query       = $this->Embismodel->selectdata('embis.acc_plantillapostn AS ap','*','',$where); ?>
		<div class="row">
			<div class="col-md-12">
				<label>Plantilla Position</label>
				<input type="text" class="form-control" name="planpstn_desc" value="<?php echo $query[0]['planpstn_desc']; ?>" required>
			</div>
			<div class="col-md-12" style="margin-top:5px;">
				<label>Plantilla Abbreviation</label>
				<input type="text" class="form-control" name="planpstn_code" value="<?php echo $query[0]['planpstn_code']; ?>" required>
				<input type="hidden" class="form-control" name="planpstn_id" value="<?php echo $query[0]['planpstn_id']; ?>" required>
			</div>
		</div>
		<?php
	}

	function edit_details(){
		$secno = $this->encrypt->decode($this->input->post('secno'));
		$where = $this->db->where('xt.secno',$secno);
		$join  = $this->db->join('embis.acc_xdvsion AS xn', 'xn.divno = xt.divno', 'left');
		$query = $this->Embismodel->selectdata('embis.acc_xsect AS xt','xt.*,xn.divname','',$join,$where);

		$urgn  = $this->session->userdata('region'); if($urgn == 'CO'){ $type = "co"; }else{ $type = "region"; }
		$whrdv = $this->db->where('xn.divno !=',$query[0]['divno']);
		$whrdv = $this->db->where('xn.type',$type);
		$order = $this->db->order_by('xn.divname','ASC');
		$qrydv = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.*','',$whrdv,$order);?>

		<div class="row">
			<div class="col-md-12">
				<label>Division</label>
				<select id="edit_divname" name="divno" class="form-control" required>
					<option value="<?php echo $query[0]['divno']; ?>"><?php echo $query[0]['divname']; ?></option>
					<?php for($i=0; $i<sizeof($qrydv); $i++){ ?>
						<option value="<?php echo $qrydv[$i]['divno']; ?>"><?php echo $qrydv[$i]['divname']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12" style="margin-top:5px;">
				<label>Section</label>
				<input type="text" class="form-control" name="secname" value="<?php echo $query[0]['sect']; ?>" required>
				<input type="hidden" class="form-control" name="secno" value="<?php echo $this->encrypt->encode($secno); ?>" required>
			</div>
			<div class="col-md-12" style="margin-top:5px;">
				<label>Section Code</label>
				<input type="text" class="form-control" name="secode" value="<?php echo $query[0]['secode']; ?>" required>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready( function(){
				$('#edit_divname').selectize();
			});
		</script>
	<?php
	}

	function employee_settings_comment(){
		$user_action_token = $this->input->post('token');
		$where             = $this->db->where('acs.token',$user_action_token);
		$queryselect       = $this->Embismodel->selectdata('embis.acc_settings AS acs','*','',$where);
		if($queryselect[0]['acc_id'] == '1'){ ?>
			<label>Comment</label>
			<textarea class="form-control" name="comment" required></textarea>
		<?php
		}
	}

	function admin_change_region(){
		$val = $this->encrypt->decode($this->input->post('val'));
		$ofc = $this->encrypt->decode($this->input->post('ofc'));
		// echo $val.' '.$ofc; exit;
		$userid = $this->session->userdata('userid');
		$this->session->set_userdata('region', $val);
		if(!empty($ofc)){
			$this->session->set_userdata('office', $ofc);
			$data_fnctn    = array('region' => $this->session->userdata('region'), 'office' => $this->session->userdata('office'),);
		}else{
			$data_fnctn    = array('region' => $this->session->userdata('region'),);
		}
		$wherefnctnregion    = array('acc_function.userid' => $this->session->userdata('userid'));
		$updatefunctnregion  = $this->Embismodel->updatedata($data_fnctn,'acc_function',$wherefnctnregion);

		$data_acc_credentials    = array('region' => $this->session->userdata('region'), 'office' => $this->session->userdata('office'),);
		$whereacc_credentials    = array('acc_credentials.userid' => $this->session->userdata('userid'));
		$updateacc_credentials   = $this->Embismodel->updatedata($data_acc_credentials,'acc_credentials',$whereacc_credentials);
	}

	function edit_account_modal_dtls(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$where = $this->db->where('acs.userid',$token);
		$join  = $this->db->join('embis.acc_credentials AS acs','acs.userid = acc.userid','left');
		$query = $this->Embismodel->selectdata('embis.acc','acc.username,acs.email,acc.raw_password','',$join,$where);
		?>

		<div class="row">
			<div class="col-md-12">
				<label>Username</label>
				<input type="text" class="form-control" name="username" value="<?php echo $query[0]['username']; ?>">
				<input type="hidden" class="form-control" name="token" value="<?php echo $this->encrypt->encode($token); ?>">
			</div>
			<div class="col-md-12" style="margin-top:5px;">
				<label>Email</label>
				<input type="email" class="form-control" name="email" value="<?php echo $query[0]['email']; ?>">
			</div>
			<?php if($this->session->userdata('superadmin_rights') == 'yes'){ ?>
			<div class="col-md-12" style="margin-top:5px;">
				<label>Password</label>
				<input type="text" class="form-control" name="password" value="<?php echo $query[0]['raw_password']; ?>">
			</div>
			<?php } ?>
		</div>

  <?php
	}

	function resetpassword(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));

		$whereun  = $this->db->where('acc.userid',$token);
		$join     = $this->db->join('embis.acc_credentials AS acs','acs.userid = acc.userid','left');
		$qryun    = $this->Embismodel->selectdata('embis.acc','acc.userid,acc.username,acs.email','',$join,$whereun);

		if($qryun[0]['userid'] != ''){

			$arr           = str_split('ABCDEFGHIJKLMNOP'); shuffle($arr);
			$arrr          = array_slice($arr, 0, 6);
			$raw_password  = implode('', $arrr);
			$en_password   = password_hash($raw_password,PASSWORD_DEFAULT);

			$data_action_a   = array(
				'acc.raw_password' => $this->encrypt->encode($raw_password),
				'acc.en_password'  => $en_password,
				'acc.cpass'        => '0',
			);

			$whereactiona   = array('acc.userid' => $token);
			$updateacca     = $this->Embismodel->updatedata($data_action_a,'acc',$whereactiona);
			$raw_username		= str_replace('ñ', '&ntilde;', $qryun[0]['username']);
			error_reporting(0);

			$this->load->config('email');
	    $this->load->library('email');

	    $from 	 = $this->config->item('smtp_user');
	    $to 	   = $qryun[0]['email'];
	    $subject = 'Environmental Management Bureau User Credentials';
			$message = '
Your account has been reset. Please refer below for your user credentials.

Username: '.$raw_username.' Password: '.$raw_password.'

Login to this link: http://iis.emb.gov.ph/';

	        $this->email->set_newline("\r\n");
	        $this->email->from($from);
	        $this->email->to($to);
	        $this->email->subject($subject);
	        $this->email->message($message);

					if ($this->email->send()) {
						echo "<script>alert('Successfully assigned.')</script>";
						echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
					} else {
						show_error($this->email->print_debugger());
					}
		}
	}

	function encryptpassword(){
		$token     = $this->encrypt->encode($this->input->post('token', TRUE));
		$usertoken = $this->encrypt->decode($this->input->post('usertoken', TRUE));

		if(!empty($token) AND !empty($usertoken)){
			$data_action_a   = array(
			'acc.raw_password' => $token,
			);

			$whereactiona   = array('acc.userid' => $usertoken);
			$updateacca     = $this->Embismodel->updatedata($data_action_a,'acc',$whereactiona);
		}
	}

	function view_user_accounts_modal(){
		$user_region = $this->session->userdata('region');
		$userid = $this->encrypt->decode($this->input->post('userid', TRUE));
		$wheresuperiors = $this->db->where('tf.userid',$userid);
		$joinsuperiors  = $this->db->join('embis.acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$querysuperiors = $this->Embismodel->selectdata('embis.to_func AS tf','tf.*,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinsuperiors,$wheresuperiors);
	?>
      		<div class="modal-body">
      			<form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/update_user_account" method="post">
				<div class="row" id="edithierarchy_body">
					<div class="col-md-10">
						<label>Name</label>
					</div>
					<div class="col-md-2">
						<label>Hierarchy</label>
					</div>
					<?php
						$cnt = 0;
						for ($i=0; $i < sizeof($querysuperiors) ; $i++) { $cnt++;
						if(!empty($querysuperiors[$i]['mname'])){ $mname = $querysuperiors[$i]['mname'][0].". "; }else{ $mname = ""; }
						if(!empty($querysuperiors[$i]['suffix'])){ $suffix = " ".$querysuperiors[$i]['suffix']; }else{ $suffix = ""; }
						if(!empty($querysuperiors[$i]['title'])){ $prefix = $querysuperiors[$i]['title']." "; }else{ $prefix = ""; }
						$name = ucwords($prefix.$querysuperiors[$i]['fname']." ".$mname.$querysuperiors[$i]['sname']).$suffix;
					?>
						<div class="col-md-10" style="margin-bottom:5px;">
							<select class="form-control" disabled>
								<option value="<?php echo $this->encrypt->encode($querysuperiors[$i]['userid']); ?>"><?php echo $name; ?></option>
							</select>
						</div>
						<div class="col-md-2" style="margin-bottom:5px;">
							<input type="text" class="form-control" style="font-size:8pt;" value="<?php echo $cnt; ?>" disabled>
						</div>
					<?php } ?>

					<div class="col-md-12"><hr>
						<a href="#" style="float:right;font-size:9pt;" onclick="edithierarchy('<?php echo $this->encrypt->encode($userid); ?>');" class="btn btn-warning btn-sm">Edit</a>
					</div>
				</div>
				</form>
			</div>



	<?php
	}

	function edithierarchy(){
		$userid = $this->input->post('token');
		$wheresuperiors = $this->db->where('tf.userid',$this->encrypt->decode($this->input->post('token')));
		$joinsuperiors  = $this->db->join('embis.acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$querysuperiors = $this->Embismodel->selectdata('embis.to_func AS tf','tf.*,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinsuperiors,$wheresuperiors);
	?>
			<div class="col-md-10">
				<label>Name</label>
			</div>
			<div class="col-md-2">
				<label>Hierarchy</label>
			</div>
			<?php
				$cnt = 0;
				for ($i=0; $i < sizeof($querysuperiors) ; $i++) { $cnt++;
				if(!empty($querysuperiors[$i]['mname'])){ $mname = $querysuperiors[$i]['mname'][0].". "; }else{ $mname = ""; }
				if(!empty($querysuperiors[$i]['suffix'])){ $suffix = " ".$querysuperiors[$i]['suffix']; }else{ $suffix = ""; }
				if(!empty($querysuperiors[$i]['title'])){ $prefix = $querysuperiors[$i]['title']." "; }else{ $prefix = ""; }
				$name = ucwords($prefix.$querysuperiors[$i]['fname']." ".$mname.$querysuperiors[$i]['sname']).$suffix;
			?>
				<div class="col-md-10" style="margin-bottom:5px;">
					<select class="form-control" disabled>
						<option value="<?php echo $this->encrypt->encode($querysuperiors[$i]['userid']); ?>"><?php echo $name; ?></option>
					</select>
				</div>
				<div class="col-md-2" style="margin-bottom:5px;">
					<input type="text" class="form-control" style="font-size:8pt;" value="<?php echo $cnt; ?>" disabled>
				</div>
			<?php } ?>
			<input type="hidden" class="form-control" name="token" value="<?php echo $userid; ?>" required>
			<div class="col-md-12"><hr>
				<center><label style="font-weight: bold;">SELECT NEW HIERARCHY OF SUPERIORS</label></center>
				<label>Select number of rows:</label>
	            <select class="form-control" id="no_rows_edit_selectize" onchange="rule_rows_edit(this.value);" name="no_rows" required="">
	              <option value=""></option>
	              <option value="1">1</option>
	              <option value="2">2</option>
	              <option value="3">3</option>
	              <option value="4">4</option>
	              <option value="5">5</option>
	              <option value="6">6</option>
	              <option value="7">7</option>
	              <option value="8">8</option>
	              <option value="9">9</option>
	            </select>
			</div>
			<div id="rule_rows_edit_body" class="col-md-12"></div>
			<div class="col-md-12"><hr>
				<button type="submit" style="float: right;" class="btn btn-success btn-sm">Submit</button>
				<button type="button" style="float: right;margin-right: 2px;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
			<script type="text/javascript">
				$(document).ready( function(){
					$('#no_rows_edit_selectize').selectize();
				});
			</script>
	<?php
	}

	function edit_rule_rows(){
		$number 			= $this->input->post('number');
		$user_region 		= $this->session->userdata('region');

		$order_byaccounts	= $this->db->order_by('acs.fname', 'ASC');
		// $whereuseraccounts	= $this->db->where('acs.region', $user_region);
		// $whereuseraccounts	= $this->db->where('af.func !=', 'Administrator');
		// $whereuseraccounts	= $this->db->where('af.func !=', 'Director');
		// $whereuseraccounts	= $this->db->where('acs.verified', '1');
		$whereuseraccounts	= $this->db->where('(af.stat = "1" AND acs.verified = "1" AND af.func != "Administrator" AND acs.region = "'.$user_region.'") OR (af.func = "Director" OR af.func = "Assistant Director")');

		$joinuseraccounts   = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
		$joinuseraccounts   = $this->db->join('embis.acc_function AS af', 'af.userid = acs.userid', 'left');
		$useraccounts       = $this->Embismodel->selectdata('embis.acc_credentials AS acs','*','',$whereuseraccounts,$joinuseraccounts,$order_byaccounts);
		if($user_region != 'CO'){ $var = '1'; }else{ $var = '1'; } //$var = '3'; }else{ $var = '2';

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
			<div class="row" style="margin-top: 5px;">
				<!-- <div class="col-md-10">
		            <label>Name</label>
		            <select class="form-control" name="employee[]" readonly="">
		            	<option value="<?php echo $this->encrypt->encode($selectdirector[0]['userid']); ?>"><?php echo $directorname; ?></option>
		            </select>
		      	</div>
		      	<div class="col-md-2">
		            <label>Hierarchy <span class="fa fa-info-circle" style="color:orange;" title="Highest to lowest ranking superior"></span></label>
								<input type="text" class="form-control" value="1" readonly="">
		            <input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode('1'); ?>" required="" readonly="">
		      	</div>
						<?php if($user_region != 'CO'){ ?>
			      	<div class="col-md-10" style="margin-top:10px;">
			            <select class="form-control" name="employee[]" readonly="">
			            	<option value="<?php echo $this->encrypt->encode($selectadirector[0]['userid']); ?>"><?php echo $adname; ?></option>
			            </select>
			      	</div>
			      	<div class="col-md-2" style="margin-top:10px;">
			      		<input type="text" class="form-control" value="2" required="" readonly="">
			            <input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode('2'); ?>" required="" readonly="">
			      	</div>

		      	<?php } ?> -->
				<?php for ($i=$var; $i <=$number && $i <= 9; $i++) { ?>
					<div class="col-md-10" style="margin-top:10px;">
			            <select id="employee_selectize_rule<?php echo $i; ?>" class="form-control" name="employee[]" required>
			                <option></option>
			              <?php
			                for ($a=0; $a < sizeof($useraccounts); $a++) {
			                  if(!empty($useraccounts[$a]['mname'])){ $mname = $useraccounts[$a]['mname'][0].". "; }else{ $mname = ""; }
			                  if(!empty($useraccounts[$a]['suffix'])){ $suffix = " ".$useraccounts[$a]['suffix']; }else{ $suffix = ""; }
												if(!empty($useraccounts[$a]['title'])){ $prefix = $useraccounts[$a]['title']." "; }else{ $prefix = ""; }
			              ?>
			                <option value="<?php echo $this->encrypt->encode($useraccounts[$a]['userid']); ?>"><?php echo $prefix.ucwords($useraccounts[$a]['fname']." ".$mname.$useraccounts[$a]['sname']).$suffix; ?></option>
			              <?php } ?>
			            </select>
			      	</div>
			      	<div class="col-md-2" style="margin-top:10px;">
									<input type="text" class="form-control" value="<?php echo ($i); ?>"readonly="">
			            <input type="hidden" class="form-control" name="order[]" value="<?php echo $this->encrypt->encode($i); ?>" required="" readonly="">
			      	</div>

			      	<script>
						$(document).ready( function(){
							$('#employee_selectize_rule<?php echo $i; ?>').selectize();
						});
					</script>
				<?php } ?>
			</div>
		<?php
	}


	function edit_user_accounts_modal(){
		$userid = $this->encrypt->decode($this->input->post('userid', TRUE));

		$where_acc       = $this->db->where('acs.userid',$userid);
		$select_acc      = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.fname,acs.mname,acs.sname,acs.suffix','',$where_acc);
		if(!empty($select_acc[0]['mname'])){ $mname = $select_acc[0]['mname'][0].". "; }else{ $mname = ""; }
		if(!empty($select_acc[0]['suffix'])){ $suffix = " ".$select_acc[0]['suffix']; }else{ $suffix = ""; }
		$nmfull      = ($select_acc[0]['fname']." ".$mname.$select_acc[0]['sname']);
		$nmstr       = str_replace('Ã±', '&ntilde;', $nmfull);
		$name 			 = ucwords(str_replace('ã±', '&ntilde;', $nmstr)).$suffix;

		$order_by_desig  = $this->db->order_by('au.ordr','ASC');
		$select_desig    = $this->Embismodel->selectdata('embis.acc_usertype AS au','*','',$order_by_desig);

		$user_region = $this->session->userdata('region');

		if($user_region == "CO"){ $type = "co"; }else{ $type = "region"; }
		$orderby_division= $this->db->order_by('xn.cat','ASC');
		$where_division  = $this->db->where('(xn.type = "'.$type.'" OR xn.type = "'.$user_region.'") AND xn.office = "'.$this->session->userdata('office').'"');
		$select_division = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','*','',$where_division,$orderby_division);

		$orderby_plntlia = $this->db->order_by('pn.planpstn_desc','ASC');
		$select_plntlia  = $this->Embismodel->selectdata('embis.acc_plantillapostn AS pn','*','',$orderby_plntlia);

		$orderby_rank    = $this->db->order_by('rk.cnt','ASC');
		$select_rank     = $this->Embismodel->selectdata('embis.acc_rank AS rk','*','',$orderby_rank);

		$orderby_rule    = $this->db->order_by('ar.rule_name','ASC');
		$where_rule      = $this->db->where('ar.region',$user_region);
		$select_rule     = $this->Embismodel->selectdata('embis.acc_rule AS ar','DISTINCT(rule_name)','',$orderby_rule);

	?>

	<form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/add_function" method="post">
		<div class="modal-body">
			<div class="row">
			  <div class="col-md-6">
					<label>Designation</label>
					<select id="edit_user_function_selectize" class="form-control" name="function" required>
							<option></option>
						<?php for ($i=0; $i < sizeof($select_desig); $i++) { ?>
							<option value="<?php echo $this->encrypt->encode($select_desig[$i]['token']); ?>"><?php echo $select_desig[$i]['dsc']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6">
					<label>Employee</label>
					<input type="text" class="form-control" value="<?php echo $name; ?>" disabled>
					<input type="hidden" class="form-control" name="employee_userid" value="<?php echo $this->encrypt->encode($userid); ?>">
				</div>
				<div class="col-md-12" style="margin-top:10px;">
					<label>Division</label>
					<select class="form-control" id="edit_division_selectize_assign" name="division" onchange="edit_sec_details(this.value);" required>
						<option></option>
						<?php for ($i=0; $i < sizeof($select_division); $i++) { ?>
							<optgroup label="<?php echo $select_division[$i]['cat']; ?>">
								<option value="<?php echo $this->encrypt->encode($select_division[$i]['token']); ?>"><?php echo $select_division[$i]['divname']; ?></option>
							</optgroup>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12" id="edit_sec_user_val_body" style="margin-top:10px;">
					<label>Section</label>
					<select class="form-control" disabled>
						<option></option>
					</select>
				</div>
				<div class="col-md-6" style="margin-top:10px;">
					<label>Designation/Position Title</label>
					<input type="text" class="form-control" name="designation" required>
				</div>
				<div class="col-md-6" style="margin-top:10px;">
					<label>Start Date</label>
					<input type="date" class="form-control" name="start_date" value="<?php echo date("Y-m-d"); ?>" required>
				</div>
				<div class="col-md-6" style="margin-top:10px;">
					<label>Plantilla Position</label>
					<select id="edit_plantilla_selectize" class="form-control" name="plantilla_pos">
						<option></option>
						<?php for($i=0; $i < sizeof($select_plntlia); $i++){ ?>
							<option value="<?php echo $select_plntlia[$i]['planpstn_id']; ?>"><?php echo $select_plntlia[$i]['planpstn_desc']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6" style="margin-top:10px;">
					<label>Plantilla Rank</label>
					<select id="edit_rank_selectize" class="form-control" name="rank">
						<option></option>
						<?php for($i=0; $i < sizeof($select_rank); $i++){ ?>
							<option value="<?php echo $select_rank[$i]['rank_desc']; ?>"><?php echo $select_rank[$i]['rank_desc']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12" style="margin-top:10px;">
					<label>Select Immediate Supervisor of Employee <span class="fa fa-info-circle" style="color:orange;" title="Highest to lowest ranking superior"></span></label>
					<select id="edit_rule_selectize" onchange="edit_ruledetails(this.value,2);" class="form-control" required>
						<option></option>
						<option value="<?php echo $this->encrypt->encode('notinthelist'); ?>">Not in the list?</option>
						<optgroup label="Template/s">
						<?php for($i=0; $i < sizeof($select_rule); $i++){ ?>
							<option value="<?php echo $this->encrypt->encode($select_rule[$i]['rule_name']); ?>"><?php echo $select_rule[$i]['rule_name']; ?></option>
						<?php } ?>
						</optgroup>
					</select>
				</div>
				<div id="edit_ruledetails_body" class="col-md-12" style="margin-top:10px;"></div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-success btn-sm">Submit</button>
		</div>
	</form>
	<script type="text/javascript">
		$(document).ready( function(){
			$('#edit_user_function_selectize').selectize();
			$('#edit_division_selectize_assign').selectize();
			$('#edit_plantilla_selectize').selectize();
			$('#edit_rank_selectize').selectize();
			$('#edit_rule_selectize').selectize();
		});
	</script>
	<?php
	}

	function edit_user_accounts_details_modal(){
		$userid = $this->encrypt->decode($this->input->post('userid', TRUE));
		if($this->session->userdata('region') == 'CO'){ $region = 'co'; }else{ $region = 'region'; }
		$where  = $this->db->where('acs.userid = "'.$userid.'"');
		$join   = $this->db->join('embis.acc_plantillapostn AS ap','ap.planpstn_id = acs.plantilla_pos','left');
		$join   = $this->db->join('embis.acc_xdvsion AS xn','xn.divno = acs.divno','left');
		$join   = $this->db->join('embis.acc_xsect AS xt','xt.secno = acs.secno','left');
		$query  = $this->Embismodel->selectdata('embis.acc_credentials AS acs','*,ap.planpstn_desc,ap.planpstn_id,xn.divno,xn.divname,xt.secno,xt.sect','',$join,$where);
		// echo $this->db->last_query();
		$order_by_qryplantilla  = $this->db->order_by('acc_plantillapostn.planpstn_desc','ASC');
		$whereqryplantiila      = $this->db->where('acc_plantillapostn.planpstn_id !=',$query[0]['planpstn_id']);
		$qryplantilla           = $this->Embismodel->selectdata('embis.acc_plantillapostn','*','',$whereqryplantiila,$order_by_qryplantilla);

		$order_by_qryrank = $this->db->order_by('acc_rank.rank_id','ASC');
		$where_qryrank    = $this->db->where('acc_rank.rank_desc !=',$query[0]['plantilla_itemno']);
		$qryrank          = $this->Embismodel->selectdata('embis.acc_rank','*','',$where_qryrank,$order_by_qryrank);

		if($this->session->userdata('region') == 'CO'){ $region_name = 'CO'; }else{ $region_name = 'R'; }

		$wherefunction  = $this->db->where('af.userid = "'.$userid.'" AND af.stat = "1" ORDER BY af.cnt ASC');
		$joinfunction   = $this->db->join('acc_xdvsion AS ad','ad.divno = af.divno','left');
		$joinfunction   = $this->db->join('acc_xsect AS at','at.secno = af.secno','left');
		$queryfunction  = $this->Embismodel->selectdata('acc_function AS af','af.userid,af.dt_strt,af.func,ad.divname,at.sect,af.cnt','',$joinfunction,$wherefunction);
		// echo $this->db->last_query();
	?>
	<form class="" action="<?php echo base_url(); ?>Admin/Submissions/Useraccounts_postdata/edit_user_accounts_details_modal" method="post">
		<div class="modal-body">
			<div class="row">
				<input type="hidden" class="form-control" name="token" value="<?php echo $this->input->post('userid', TRUE); ?>">
				<div class="col-md-2">
					<label>Prefix</label>
					<input type="text" class="form-control" name="prefix_name" value="<?php echo $query[0]['title']; ?>">
				</div>
				<div class="col-md-3">
					<label>Firstname</label>
					<input type="text" class="form-control" name="first_name" value="<?php echo $query[0]['fname']; ?>" required>
				</div>
				<div class="col-md-2">
					<label>Middlename</label>
					<input type="text" class="form-control" name="middle_name" value="<?php echo $query[0]['mname']; ?>">
				</div>
				<div class="col-md-3">
					<label>Lastname</label>
					<input type="text" class="form-control" name="last_name" value="<?php echo $query[0]['sname']; ?>" required>
				</div>
				<div class="col-md-2">
					<label>Suffix</label>
					<input type="text" class="form-control" name="suffix_name" placeholder="e.g Jr., Sr., II, III, CESO" value="<?php echo $query[0]['suffix']; ?>">
				</div>
				<div class="col-md-12" style="margin-top:5px;">
					<label>Designation / Position Title</label>
					<input type="text" class="form-control" name="designation" value="<?php echo $query[0]['designation']; ?>" required>
				</div>
				<div class="col-md-6" style="margin-top:5px;">
					<label>Plantilla Position</label>
					<select id="edit_user_accounts_details_plantilla_selectize" class="form-control" name="plantilla_pos">
						<option value="<?php echo $query[0]['planpstn_id']; ?>"><?php echo $query[0]['planpstn_desc']; ?></option>
						<?php for($i=0; $i < sizeof($qryplantilla); $i++){ ?>
							<option value="<?php echo $qryplantilla[$i]['planpstn_id']; ?>"><?php echo $qryplantilla[$i]['planpstn_desc']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6" style="margin-top:5px;">
					<label>Plantilla Rank</label>
					<select id="edit_user_accounts_details_rank_selectize" class="form-control" name="rank">
						<option value="<?php echo $query[0]['plantilla_itemno']; ?>"><?php echo $query[0]['plantilla_itemno']; ?></option>
						<?php for($i=0; $i < sizeof($qryrank); $i++){ ?>
							<option value="<?php echo $qryrank[$i]['rank_desc']; ?>"><?php echo $qryrank[$i]['rank_desc']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12">
					<label>Email</label>
					<input type="text" class="form-control" name="email_address" value="<?php echo $query[0]['email']; ?>" required><hr>
				</div>
				<div class="col-md-12">
					<center><label style="font-weight: bold;background-color:#0B4F84;color:#FFF;padding: 3px 15px 3px 15px;width:100%;">USER FUNCTION</label></center>
					<button type="button" class="btn btn-success btn-sm" style="float:right;" onclick=edturfnctn('<?php echo $this->encrypt->encode('1'); ?>','','<?php echo $this->input->post('userid', TRUE); ?>','');>Add New Function</button><br><br>
					<div style="display: block;overflow-x: auto;white-space: nowrap;">
						<table id="function_list_user" class="table table-striped table-hover" style="zoom:90%;width:100%!important;">
							<thead>
								<tr>
									<th></th>
									<th style="width:100px;">Date assigned</th>
									<th>Designation</th>
									<th>Division</th>
									<th>Section</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$row = 0;
									for ($af=0; $af < sizeof($queryfunction); $af++) {
										if(!empty($queryfunction[$af]['userid'])){
											$row++;
											$divname = !empty($queryfunction[$af]['divname']) ? $queryfunction[$af]['divname'] : "N/A" ;
											$secname = !empty($queryfunction[$af]['sect']) ? $queryfunction[$af]['sect'] : "N/A" ;
											$btn = "<button type='button' class='btn btn-warning btn-sm' onclick=edturfnctn('".$this->encrypt->encode('2')."','".$this->encrypt->encode($queryfunction[$af]['cnt'])."','','".$row."');>Edit</button>";
											if($row != 1){
												$btn .= "&nbsp;<button type='button' class='btn btn-danger btn-sm' onclick=edtrmvdnctn('".$this->encrypt->encode($queryfunction[$af]['cnt'])."');>Remove</button>";
											}
											$ifprimary = ($row == '1') ? '<span title="Primary Function (Editable)">PF</span>' : '<span title="Sub Function (Editable/Removable)">SF</span>';
								?>
									<tr>
										<td><?php echo $ifprimary; ?></td>
										<td><?php echo date("M d, Y", strtotime($queryfunction[$af]['dt_strt'])); ?></td>
										<td><?php echo $queryfunction[$af]['func']; ?></td>
										<td><?php echo $divname; ?></td>
										<td><?php echo $secname; ?></td>
										<td><?php echo $btn; ?></td>
									</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-12" id="edtdtlsfnctnur"></div>
				<script type="text/javascript">
					$(document).ready(function() {
					   var table =  $('#function_list_user').DataTable({
					        "lengthMenu": [[5, 15, 50, -1], [5, 15, 50, "All"]]
					    } );


					});
				</script>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-success btn-sm">Submit</button>
		</div>
	</form>
	<script type="text/javascript">
		$(document).ready( function(){
			$('#edit_user_accounts_details_plantilla_selectize').selectize();
			$('#edit_user_accounts_details_rank_selectize').selectize();
		});
	</script>
	<?php
	}

	function edturfnctn(){
		$div   = $this->input->post('div', TRUE);
		$token = $this->input->post('token', TRUE);
		$usertoken = $this->input->post('userid', TRUE);
		$row = $this->input->post('row', TRUE);

		if($this->session->userdata('region') == 'CO'){ $region = 'co'; }else{ $region = 'region'; }
		if($this->session->userdata('region') == 'CO'){ $region_name = 'CO'; }else{ $region_name = 'R'; }

		$where = $this->db->where('af.stat = "1" AND af.cnt = "'.$this->encrypt->decode($token).'"');
		$join  = $this->db->join('acc_xdvsion AS an','an.divno = af.divno','left');
		$join  = $this->db->join('acc_xsect AS xt','xt.secno = af.secno','left');
		$query = $this->Embismodel->selectdata('acc_function AS af','af.userid,af.func,an.divno,an.divname,xt.secno,xt.sect','',$join,$where);

		$order_by_qrydiv  = $this->db->order_by('xn.divname','ASC');
		$where_qrydiv     = $this->db->where('xn.divno != "'.$query[0]['divno'].'" AND (xn.type = "'.$region.'" OR xn.type = "'.$this->session->userdata('region').'") AND xn.office = "'.$this->session->userdata('office').'"');
		$qrydiv           = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','*','',$where_qrydiv,$order_by_qrydiv);

		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.divno = "'.$query[0]['divno'].'" AND (xt.region = "'.$region_name.'" OR xt.region = "'.$this->session->userdata('region').'") AND xt.secno != "'.$query[0]['secno'].'"');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$qrysec           = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);

		if($this->session->userdata('superadmin_rights') == 'yes'){
			$whereutype				= $this->db->where('acc_usertype.dsc != "'.$query[0]['func'].'"');
		}else{
			$whereutype				= $this->db->where('acc_usertype.typeid != "1" AND acc_usertype.typeid != "2" AND acc_usertype.typeid != "7" AND acc_usertype.dsc != "'.$query[0]['func'].'"');
			if($_SESSION['office'] == 'DENR'){
				$whereutype				  = $this->db->where('acc_usertype.typeid !=', '2');
			}else{
				$whereutype				  = $this->db->where('acc_usertype.typeid !=', '11');
			}
		}
		$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
		$queryusertype    = $this->Embismodel->selectdata('embis.acc_usertype','*','',$whereutype,$order_by);
	?>

	<?php if($this->encrypt->decode($div) == '1'){ ?>
		<div class="row">
			<div class="col-md-12">
				<center><label style="font-weight: bold;background-color:#114D95;color:#FFF;padding: 3px 15px 3px 15px;margin-top:15px;width: 100%;">NEW USER FUNCTION</label></center>
			</div>
			<div class="col-md-2">
				<label>Designation</label>
				<select id="edit_designation_selectize" class="form-control" required>
					<option value=""></option>
					<?php for($ut=0; $ut < sizeof($queryusertype); $ut++){ ?>
						<option value="<?php echo $this->encrypt->encode($queryusertype[$ut]['dsc']); ?>">
							<?php echo $queryusertype[$ut]['dsc']; ?>
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<label>Division</label>
				<select id="edit_division_selectize" onchange="edit_sec_details_modal(this.value);" class="form-control" required="">
					<option value=""></option>
					<?php for($i=0; $i < sizeof($qrydiv); $i++){ ?>
						<option value="<?php echo $this->encrypt->encode($qrydiv[$i]['divno']); ?>"><?php echo $qrydiv[$i]['divname']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4" id="edit_sec_details_modal_body">
				<label>Section</label>
				<input type="text" class="form-control" value="Please select division" disabled>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-success btn-sm" onclick=sbmtedtfntnnw("<?php echo $usertoken; ?>",$('#edit_designation_selectize').val(),$('#edit_division_selectize').val(),$('#section_selectize_assign').val()); style="width: 100%;margin-top: 33px;height: 45%;">Submit</button>
			</div>
		</div>
	<?php } ?>

	<?php if($this->encrypt->decode($div) == '2'){ ?>
		<div class="row">
			<div class="col-md-12">
				<center><label style="font-weight: bold;background-color:#114D95;color:#FFF;padding: 3px 15px 3px 15px;margin-top:15px;width: 100%;">EDIT USER FUNCTION<br><span>*Editing user function only changes the user details, it does not affect hierarchy of superiors*</span></label></center>
			</div>
			<div class="col-md-2">
				<label>Designation</label>
				<select id="edit_designation_selectize" class="form-control" required>
					<option value="<?php echo $this->encrypt->encode($query[0]['func']); ?>"><?php echo $query[0]['func']; ?></option>
					<?php for($ut=0; $ut < sizeof($queryusertype); $ut++){ ?>
						<option value="<?php echo $this->encrypt->encode($queryusertype[$ut]['dsc']); ?>">
							<?php echo $queryusertype[$ut]['dsc']; ?>
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<label>Division</label>
				<select id="edit_division_selectize" onchange="edit_sec_details_modal(this.value);" class="form-control" required="">
					<option value="<?php echo $this->encrypt->encode($query[0]['divno']); ?>"><?php echo $query[0]['divname']; ?></option>
					<?php for($i=0; $i < sizeof($qrydiv); $i++){ ?>
						<option value="<?php echo $this->encrypt->encode($qrydiv[$i]['divno']); ?>"><?php echo $qrydiv[$i]['divname']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4" id="edit_sec_details_modal_body">
				<label>Section</label>
				<select id="section_selectize_assign" class="form-control">
					<option value="<?php echo $this->encrypt->encode($query[0]['secno']); ?>" selected><?php echo $query[0]['sect']; ?></option>
					<option value="-">N/A</option>
					<?php for($i=0; $i < sizeof($qrysec); $i++){ ?>
						<option value="<?php echo $this->encrypt->encode($qrysec[$i]['secno']); ?>">
							<?php echo $qrysec[$i]['sect']; ?>
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-success btn-sm" onclick=sbmtedtfntn("<?php echo $token; ?>",$('#edit_designation_selectize').val(),$('#edit_division_selectize').val(),$('#section_selectize_assign').val(),"<?php echo $row; ?>"); style="width: 100%;margin-top: 33px;height: 45%;">Submit</button>
			</div>
		</div>
	<?php } ?>


		<script type="text/javascript">
			$(document).ready( function(){
				$('#section_selectize_assign').selectize();
				$('#edit_division_selectize').selectize();
				$('#edit_designation_selectize').selectize();
			});
		</script>
	<?php
	}

	function sbmtedtfntn(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$func  = $this->encrypt->decode($this->input->post('des', TRUE));
		$div   = $this->encrypt->decode($this->input->post('div', TRUE));
		$sec   = $this->encrypt->decode($this->input->post('sec', TRUE));
		$row   = ($this->input->post('row', TRUE));

		$whereut  = array('au.dsc' => $func);
		$selectut = $this->Embismodel->selectdata('acc_usertype AS au','au.ordr',$whereut);

		$wheredv  = array('an.divno' => $div);
		$selectdv = $this->Embismodel->selectdata('acc_xdvsion AS an','an.divname,an.divcode',$wheredv);

		$wheresc  = array('xt.secno' => $sec);
		$selectsc = $this->Embismodel->selectdata('acc_xsect AS xt','xt.sect',$wheresc);

		$wherefctn  = array('af.cnt' => $token);
		$selectfctn = $this->Embismodel->selectdata('acc_function AS af','af.userid',$wherefctn);

		if(!empty($token) AND !empty($func) AND !empty($selectut[0]['ordr']) AND !empty($div) AND !empty($selectdv[0]['divname'])){
			$data  = array(
											'func' 	     => $func,
											'func_order' => $selectut[0]['ordr'],
											'secno'      => $sec,
											'divno'      => $div,
											'div_nam'    => $selectdv[0]['divname'],
											'region'     => $this->session->userdata('region'),
									  );

			$where   = array('acc_function.cnt' => $token);
			$update  = $this->Embismodel->updatedata($data,'acc_function',$where);

			if($row == '1'){ //IT MEANS PRIMARY FUNCTION
				$dataacs = array(
													'division' => $selectdv[0]['divcode'],
													'divno'    => $div,
													'section'  => $selectsc[0]['sect'],
													'secno'    => $sec,
											  );
				$whereacs = array('userid' => $selectfctn[0]['userid']);
				$updateacs = $this->Embismodel->updatedata($dataacs,'acc_credentials',$whereacs);
			}
		}
	}

	function sbmtedtfntnnw(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$func  = $this->encrypt->decode($this->input->post('des', TRUE));
		$div   = $this->encrypt->decode($this->input->post('div', TRUE));
		$sec   = $this->encrypt->decode($this->input->post('sec', TRUE));

		$whereut  = array('au.dsc' => $func);
		$selectut = $this->Embismodel->selectdata('acc_usertype AS au','au.ordr',$whereut);

		$wheredv  = array('an.divno' => $div);
		$selectdv = $this->Embismodel->selectdata('acc_xdvsion AS an','an.divname',$wheredv);

		if(!empty($token) AND !empty($func) AND !empty($selectut[0]['ordr']) AND !empty($div) AND !empty($selectdv[0]['divname'])){
			$data 	= array(
								'acc_function.userid'     => $token,
								'acc_function.dt_strt'    => date("Y-m-d"),
								'acc_function.func'       => $func,
								'acc_function.func_order' => $selectut[0]['ordr'],
								'acc_function.secno'      => $sec,
								'acc_function.divno'      => $div,
								'acc_function.div_nam'    => $selectdv[0]['divname'],
								'acc_function.region'     => $this->session->userdata('region'),
								'acc_function.stat'       => '1',
			         );

			$insertfunction = $this->Embismodel->insertdata('embis.acc_function',$data);
		}
	}

	function edtrmvdnctn(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		if(!empty($token)){
			$data  = array(
									'stat' 	     => '0',
							 );
			$where   = array('acc_function.cnt' => $token);
			$update  = $this->Embismodel->updatedata($data,'acc_function',$where);
		}
	}

	function delete_line_of_authority_token(){
		$description = $this->input->post('description');
		echo '<input type="hidden" class="form-control" name="token" value="'.$description.'">';
	}

	function edit_line_of_authority_token(){
		$description = $this->input->post('description');
		$name = $this->encrypt->decode($this->input->post('description'));
		echo '<input type="hidden" class="form-control" name="token" value="'.$description.'">'; ?>
		<div class="row">
			<div class="col-md-12">
				<label>Description</label>
				<input type="text" class="form-control" name="description" value="<?php echo $name; ?>">
			</div>
		</div>
	<?php
	}

	function view_line_of_authority_token(){
		$description_decode = $this->encrypt->decode($this->input->post('description'));
		$where              = $this->db->where('ar.rule_name',$description_decode);
		$where              = $this->db->where('ar.region',$this->session->userdata('region'));
		$order_by           = $this->db->order_by('ar.rule_order','ASC');
		$join               = $this->db->join('embis.acc_credentials AS acs','acs.userid = ar.rule_userid','left');
		$query              = $this->Embismodel->selectdata('embis.acc_rule AS ar','ar.*,acs.fname,acs.mname,acs.sname,acs.suffix','',$where,$order_by);
		?>
		<div class="row">
			<div class="col-md-10">
				<label>Name</label>
			</div>
			<div class="col-md-2">
				<label>Hierarchy</label>
			</div>
			<?php for ($i=0; $i <sizeof($query) ; $i++) {
				if(!empty($query[$i]['mname'])){ $mname = $query[$i]['mname'][0].". ";  }else{ $mname = ""; }
				if(!empty($query[$i]['suffix'])){ $suffix = " ".$query[$i]['suffix'];  }else{ $suffix = ""; }
				$full_name   = utf8_encode(strtolower($query[$i]['fname']." ".$mname.$query[$i]['sname']));
				$flnm        = str_replace('Ã±', '&ntilde;', $full_name);
				$name 			 = ucwords(str_replace('ã±', '&ntilde;', $flnm)).$suffix;
		  ?>
				<div class="col-md-10" style="margin-bottom:5px;">
					<input type="text" class="form-control" name="description" value="<?php echo $name; ?>" disabled>
				</div>
				<div class="col-md-2" style="margin-bottom:5px;">
					<input type="text" class="form-control" name="description" value="<?php echo $query[$i]['rule_order']; ?>" disabled>
				</div>
			<?php } ?>
		</div>
	<?php
	}

	function acc_rights(){
		$column = $this->encrypt->decode($this->input->post('column'));
		$token  = $this->input->post('token');
		$userid = $this->encrypt->decode($this->input->post('userid'));
		if($column == "superadmin_rights"){
			$data    = array('superadmin_rights' => $token,);
		}else if($column == "hr_rights"){
			$data    = array('hr_rights' => $token,);
		}else if($column == "account_credentials_rights"){
			$data    = array('account_credentials_rights' => $token,);
		}else if($column == "company_rights"){
			$data    = array('company_rights' => $token,);
		}else if($column == "to_rights"){
			$data    = array('to_rights' => $token,);
		}else if($column == "to_ticket_request"){
			$data    = array('to_ticket_request' => $token,);
		}else if($column == "to_ticket_chief_accountant"){
			$data    = array('to_ticket_chief_accountant' => $token,);
		}else if($column == "dms_all_view_attachment"){
			$data    = array('dms_all_view_attachment' => $token,);
		}else if($column == "to_assistant_or_laborers"){
			$data    = array('to_assistant_or_laborers' => $token,);
		}else if($column == "to_view_all_approved"){
			$data    = array('to_view_all_approved' => $token,);
		}else if($column == "client_rights"){
			$data    = array('client_rights' => $token,);
		}else if($column == "loginas"){
			$data    = array('loginas' => $token,);
		}else if($column == "trans_qrcode"){
			$data    = array('trans_qrcode' => $token,);
		}else if($column == "qrcode_docs"){
			$data    = array('qrcode_docs' => $token,);
		}else if($column == "trans_regionalprc"){
			$data    = array('trans_regionalprc' => $token,);
		}else if($column == "trans_multiprc"){
			$data    = array('trans_multiprc' => $token,);
		}else if($column == "client_log"){
			$data    = array('client_log' => $token,);
		}else if($column == "access_regions"){
			$data    = array('access_regions' => $token,);
		}else if($column == "add_user_rights_with_role"){
			$data    = array('add_user_rights_with_role' => $token,);
		}else if($column == "rec_officer"){
			$data    = array('rec_officer' => $token,);
		}else if($column == "trans_deletion"){
			$data    = array('trans_deletion' => $token,);
		}else if($column == "view_pab_trans"){
			$data    = array('view_pab_trans' => $token,);
		}else if($column == "access_offices"){
			$data    = array('access_offices' => $token,);
		}else if($column == "access_sweet_settings"){
			$data    = array('access_sweet_settings' => $token,);
		}else if($column == "view_monitoring_report"){
			$data    = array('view_monitoring_report' => $token,);
		}else if($column == "view_eia"){
			$data    = array('view_eia' => $token,);
		}else if($column == "view_haz"){
			$data    = array('view_haz' => $token,);
		}else if($column == "view_chem"){
			$data    = array('view_chem' => $token,);
		}else if($column == "view_confidential_tab"){
			$data    = array('view_confidential_tab' => $token,);
		}else if($column == "set_confidential_tag"){
			$data    = array('set_confidential_tag' => $token,);
		}else if($column == "add_event"){
			$data    = array('add_event' => $token,);
		}else if($column == "access_pbsbur"){
			$data    = array('access_pbsbur' => $token,);
		}else if($column == "add_bulletin"){
			$data    = array('add_bulletin' => $token,);
		}else if($column == "support_admin"){
			$data    = array('support_admin' => $token,);
		}else if($column == "inbox_monitoring"){
			$data    = array('inbox_monitoring' => $token,);
		}else if($column == "universe_admin"){
			$data    = array('universe_admin' => $token,);
		}

		$where    = array('acc_rights.userid' => $userid);
		$update   = $this->Embismodel->updatedata($data,'acc_rights',$where);
	}

	function changeview(){
		$token = $this->encrypt->decode($this->input->post('token'));
		if($token != ''){
			if($token == '3'){ $token = ""; }
			$this->session->set_userdata('employee_view', $token);
		}
	}

	function administrative_tab(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$this->session->set_userdata('admin_tab', $token);
		echo $token;
	}

	function loginas(){
		$token = $this->encrypt->decode($this->input->post('token'));
		$values      = $this->db->where('acc.userid', $token);
		$join        = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = acc.userid', 'left');
		$join        = $this->db->join('embis.acc_function AS xc', 'xc.userid = acs.userid', 'left');
		$join        = $this->db->join('embis.acc_region AS ar', 'ar.rgnnum = acs.region', 'left');
		$queryselect = $this->Embismodel->selectdata('embis.acc','acc.userid,acc.acc_status,acc.username,acc.en_password,acs.verified,acs.region,acs.division,acs.section,acs.designation,xc.func,xc.divno,xc.secno,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.token,ar.rgnid,xc.office','',$values,$join);
		$mname  = (!empty($queryselect[0]['mname'])) ? $queryselect[0]['mname'][0].". " : "";
		$suffix = (!empty($queryselect[0]['suffix'])) ? " ".$queryselect[0]['suffix'] : "";
		$prefix = (!empty($queryselect[0]['title'])) ? $queryselect[0]['title']." " : "";
		$name = $prefix.$queryselect[0]['fname']." ".$mname.$queryselect[0]['sname'].$suffix;
		$data = array(
			'userid'      => $queryselect[0]['userid'],
			'region'      => $queryselect[0]['region'],
			'region_id'   => $queryselect[0]['rgnid'],
			'division'    => $queryselect[0]['division'],
			'divno'       => $queryselect[0]['divno'],
			'section'     => $queryselect[0]['section'],
			'secno'       => $queryselect[0]['secno'],
			'designation' => $queryselect[0]['designation'],
			'func'        => $queryselect[0]['func'],
			'office'      => $queryselect[0]['office'],
			'name'        => $name,
			'token'       => $queryselect[0]['token'],
			'form_trial'  => 0,
			'real_user'   => $this->session->userdata('userid'),
		);
		$this->session->set_userdata($data);
		$this->Embismodel->selectdatarights();

		// $wheretofunc = $this->db->where('tf.userid',$queryselect[0]['userid']);
		// $wheretofunc = $this->db->where('tf.route_order','1');
		// $querytofunc = $this->Embismodel->selectdata('embis.to_func AS tf','*','',$wheretofunc);
		//
		// $this->session->set_userdata('tofunc', $querytofunc[0]['userid']);
	}

	function emp_action_res(){
		$user_region  = $this->session->userdata('region');
		$token = $this->input->post('token', TRUE);
		$order = $this->db->order_by('acs.verified DESC, acs.fname ASC');
		if($token == '3AMNCZXCZXC23123'){ //REMOVE ASSIGNMENT
			$where = $this->db->where('acs.verified = "2"');
		}else if($token == '2ASDJBASJBSADASv'){ //DEACTIVATE ASSIGNMENT
			$where = $this->db->where('(acs.verified = "1" OR acs.verified = "0")');
		}else if($token == '1ASJDNJASVBAS'){ //ACTIVATE
			$where = $this->db->where('acs.verified = "1"');
		}

		$where = $this->db->where('acs.userid != "1" AND acs.region = "'.$user_region.'" AND acs.office = "'.$this->session->userdata('office').'"');
		$query = $this->Embismodel->selectdata('acc_credentials AS acs','','',$where,$order);
		// echo $this->db->last_query();
	?>

			<label>Employee List</label>
			<select name="employee_token" id="employee_list_selectize" class="form-control" onchange="chkhierarchy(this.value,$('#action_selectize').val());" required>
						<option value=""></option>
				<?php
						for($i=0; $i<sizeof($query); $i++){
							if(!empty($query[$i]['mname'])){
								$mname  = $query[$i]['mname'][0].". "; }else{ $mname = ""; }
							if(!empty($query[$i]['suffix'])){
								$suffix = " ".$query[$i]['suffix']; }else{ $suffix = ""; }
								$prefix = !empty($query[$i]['title']) ? $query[$i]['title']." " : "";
								$name   = utf8_encode(strtolower($prefix.$query[$i]['fname']." ".$mname.$query[$i]['sname']));
								$full_name = str_replace('ã±', '&ntilde;', $name).$suffix;
							if($query[$i]['verified'] == '0'){
								$status = "To be assigned";
							}else if($query[$i]['verified'] == '1'){
								$status = "Active Employees";
							}else if($query[$i]['verified'] == '2'){
								$status = "Deactivated Employees";
							}
				?>
					<optgroup label="<?php echo $status; ?>">
						<option value="<?php echo $query[$i]['token']; ?>">&nbsp;&nbsp;<?php echo ucwords(str_replace('Ã±', '&ntilde;',$full_name)); ?></option>
					</optgroup>
				<?php } ?>
			</select>
			<script type="text/javascript">
				$(document).ready( function(){
					$('#employee_list_selectize').selectize();
				});
			</script>
	<?php
	}

	function chkhierarchy(){
		$token = $this->input->post('token', TRUE);
		$action = $this->input->post('action', TRUE);
		$where        = $this->db->where('acs.token = "'.$token.'" GROUP BY tf.assigned_to');
		$join         = $this->db->join('acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$chkpersonnel = $this->Embismodel->selectdata('to_func AS tf','tf.assigned_to','',$join,$where);

		$orderemp     = $this->db->order_by('acs.fname','ASC');
		$whereemp     = $this->db->where('acs.token !=',$token);
		$whereemp     = $this->db->where('acs.verified','1');
		$whereemp     = $this->db->where('acs.region',$this->session->userdata('region'));
		$employeelist = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$whereemp);
		?>
			<?php
				if(!empty($chkpersonnel[0]['assigned_to']) AND ($action == '2ASDJBASJBSADASv' OR $action == '1ASJDNJASVBAS')){ ?>
						<label>The employee you selected has under personnel, please select employee replacement:</label>
						<select id="employee_replacement" class="form-control" name="employee_replacement" required>
							<option value="">-</option>
							<?php
								for ($i=0; $i < sizeof($employeelist); $i++) {
									$mname  = (!empty($employeelist[$i]['mname'])) ? $employeelist[$i]['mname'][0].". " : "";
									$suffix = (!empty($employeelist[$i]['suffix'])) ? " ".$employeelist[$i]['suffix'] : "";
									$prefix = (!empty($employeelist[$i]['title'])) ? $employeelist[$i]['title']." " : "";
									$name = ucwords($prefix.$employeelist[$i]['fname']." ".$mname.$employeelist[$i]['sname'].$suffix);
							?>

										<option value="<?php echo $this->encrypt->encode($employeelist[$i]['userid']); ?>"><?php echo $name; ?></option>

							<?php } ?>
						</select>
						<script type="text/javascript">
							$(document).ready( function(){
								$('#employee_replacement').selectize();
							});
						</script>
			<?php } ?>
		<?php
	}

	function notapplicablesecorunit(){
		$region = $this->session->userdata('region');
		$order  = $this->db->order_by('ax.sect','ASC');
		$where  = array('axna.region' => $region);
		$join   = $this->db->join('acc_xsect AS ax','ax.secno = axna.secno','left');
		$select = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','ax.secno,ax.sect',$where,$join,$order);

		for ($not=0; $not < sizeof($select); $not++) {
			$wherext    = $this->db->where('axt.secno != "'.$select[$not]['secno'].'"');
		}
		$wherext    = $this->db->where('axt.secno != "69" AND (axt.region = "'.$region.'" OR axt.region = "R")');
		$orderby    = $this->db->order_by('axt.sect','ASC');
		$selectsect = $this->Embismodel->selectdata('acc_xsect AS axt','axt.secno,axt.sect,axt.region','',$wherext,$orderby);
			// echo $this->db->last_query();
	?>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<label style="color:red;">Select section or unit to be removed: </label>
			</div>
			<div class="col-md-10">
				<select id="xt_selectize" class="form-control" required>
					<option value=""></option>
						<?php for ($st=0; $st < sizeof($selectsect); $st++) {
							$optgroup = $selectsect[$st]['region'] == $region ? "List of added section or unit": "List of default section or unit";
							echo '<optgroup label="'.$optgroup.'">';
							echo '<option value="'.$this->encrypt->encode($selectsect[$st]['secno']).'">'.$selectsect[$st]['sect'].'</option>';
							echo '</optgroup>';
						} ?>
				</select>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-success btn-sm" onclick=rmvsecorunitbtn($('#xt_selectize').val()); style="width:100%;height:34px;">Submit</button>
			</div>
			<div class="col-md-12">
				<hr>
			</div>
			<div class="col-md-12">
				<center><label style="font-weight: bold;background-color:#0B4F84;color:#FFF;padding: 3px 15px 3px 15px;width:100%;">REMOVED SECTION/UNIT LIST</label></center>
				<table id="notapplicabletable" class="table table-striped table-hover" style="zoom:80%;">
					<thead>
						<tr>
							<th>Section/Unit</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i=0; $i < sizeof($select); $i++) {
							if(!empty($select[$i]['sect'])){
								echo "<tr>";
										echo "<td>".$select[$i]['sect']."</td>";
										echo "<td><button class='btn btn-success btn-sm' onclick=rstrbtnntapp('".$this->encrypt->encode($select[$i]['secno'])."');>Restore</button></td>";
								echo "</tr>";
							}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" style="float: right;margin-right: 2px;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#notapplicabletable').DataTable({
		        "lengthMenu": [[5, 15, 50, -1], [5, 15, 50, "All"]]
		    } );
				$('#xt_selectize').selectize();
		} );
	</script>
	<?php
	}

	function rmvsecorunitbtn(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		if(!empty($token)){
			$data  = array(
											'region' => $this->session->userdata('region'),
											'secno'  => $token,
										);
			$insert = $this->Embismodel->insertdata('embis.acc_xsect_not_applicable',$data);
		}
	}

	function rstrbtnntapp(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		if(!empty($token)){
			$data  = array(
											'region' => $this->session->userdata('region'),
											'secno'  => $token,
										);
			$delete = $this->Embismodel->deletedata('embis.acc_xsect_not_applicable',$data);
		}
	}

	function mdluptsadmn(){
		$where         = $this->db->where('sul.module = "User Accounts" ORDER BY date_added DESC');
		$selectupdates = $this->Embismodel->selectdata('system_update_logs AS sul','','',$where);
	?>
	<div class="table-responsive">
		<table id="administrative_updates" class="table table-striped table-hover" style="zoom:80%;">
			<thead>
				<tr>
					<td><b>Date Added</b></td>
					<td><b>Feature</b></td>
					<td><b>Update Description / Functionality</b></td>
					<td><b>Location</b></td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i < sizeof($selectupdates); $i++) { ?>
					<tr>
						<td><?php echo date("M d, Y - l", strtotime($selectupdates[$i]['date_added'])); ?></td>
						<td><?php echo $selectupdates[$i]['feature_title']; ?></td>
						<td><?php echo $selectupdates[$i]['description']; ?></td>
						<td><?php echo $selectupdates[$i]['location']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#administrative_updates').dataTable( {
			  "ordering": false
			});
		});
	</script>
	<?php
	}

	function chkdfltexstfnc(){
		$region = $this->session->userdata('region');
		$dflt_token = $this->encrypt->decode($this->input->post('token', TRUE));
		$chkdlft = $this->Administrativemodel->assigned_hierarchy($dflt_token);
		if($chkdlft[0]['func'] == 'Unit Chief' OR $chkdlft[0]['func'] == 'Section Chief'){
			$func = '(af.func = "Section Chief" OR af.func = "Unit Chief") AND';
		}else if($chkdlft[0]['func'] == 'Staff' OR $chkdlft[0]['func'] == 'Secretary'){
			$func = '(af.func = "Staff" OR af.func = "Secretary") AND';
		}else{
			$func = 'af.func = "'.$chkdlft[0]['func'].'" AND';
		}
		$where = $this->db->where('acs.userid != "'.$dflt_token.'" AND '.$func.' af.stat = "1" AND acs.verified = "1" AND acs.region = "'.$region.'" ORDER BY af.func_order ASC, acs.fname ASC');
		$employee_list_active = $this->Administrativemodel->select_employees($where);

	?>
		<?php if(!empty($chkdlft[0]['userid'])) { ?>
			<label>Please select another user to swap:</label>
			<select id="rplcmntselectize" class="form-control" name="rplc_user" onchange="chkdfltexstfncundrrplc(this.value,$('#dfltuserselectize').val()); chkdfltexstfncundr(this.value,$('#dfltuserselectize').val()); undrprsnnlt($('#dfltuserselectize').val(),$('#rplcmntselectize').val(),'b');" required>
				<option value=""-></option>
				<?php for ($lg=0; $lg < sizeof($employee_list_active) ; $lg++) {
						$mname = !empty($employee_list_active[$lg]['mname']) ? $employee_list_active[$lg]['mname'][0].". " : '';
						$suffix = !empty($employee_list_active[$lg]['suffix']) ? " ".$employee_list_active[$lg]['suffix'] : '';
						$prefix = !empty($employee_list_active[$lg]['title']) ? $employee_list_active[$lg]['title']." " : '';
						$name = $prefix.ucwords($employee_list_active[$lg]['fname']." ".$mname." ".$employee_list_active[$lg]['sname']).$suffix;
					?>
					<optgroup label="<?php echo $employee_list_active[$lg]['func']; ?>">
						<option value="<?php echo $this->encrypt->encode($employee_list_active[$lg]['userid']); ?>"><?php echo $name; ?></option>
					</optgroup>
					<?php } ?>
			</select>
			<script type="text/javascript">
				$('#rplcmntselectize').selectize();
			</script>
			<div id="_chkdfltexstfnc_"></div>
		<?php } ?>
	<?php
	}

	function chkdfltexstfncundr(){
		$region = $this->session->userdata('region');
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$other_token = $this->encrypt->decode($this->input->post('other_token', TRUE));

		$wherefunction = $this->db->where('af.userid = "'.$other_token.'" AND af.stat = "1"');
		$joinfunction = $this->db->join('acc_xsect AS xt','xt.secno = af.secno','left');
		$joinfunction = $this->db->join('acc_xdvsion AS ax','ax.divno = af.divno','left');
		$joinfunction = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
		$selectfunction = $this->Embismodel->selectdata('acc_function AS af','af.func,acs.designation,ax.divno,ax.token,ax.divname,xt.secno,xt.sect','',$joinfunction,$wherefunction);

		if($region == 'CO'){ $region_div = 'co'; }else{ $region_div = 'region'; }
		$orderbydiv	= $this->db->order_by('acc_xdvsion.divname','ASC');
		if(!empty($selectfunction[0]['token'])){
			$wherediv   = $this->db->where('acc_xdvsion.token !=',$selectfunction[0]['token']);
		}
		$wherediv   = $this->db->where('acc_xdvsion.type',$region_div);
		$division   = $this->Embismodel->selectdata('embis.acc_xdvsion','*','',$wherediv,$orderbydiv);

		if($this->session->userdata('region') == 'CO'){ $region_name = 'CO'; }else{ $region_name = 'R'; }
		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.secno != "'.$selectfunction[0]['secno'].'" AND xt.divno = "'.$selectfunction[0]['divno'].'" AND (xt.region = "'.$region_name.'" OR xt.region = "'.$region.'")');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$querysection     = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);

		if($_SESSION['superadmin_rights'] == 'yes'){
			$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
			$whereutype				  = $this->db->where('acc_usertype.dsc !=', $selectfunction[0]['func']);
		}else{
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '1');
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '7');
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '2');
			$whereutype				  = $this->db->where('acc_usertype.dsc !=', $selectfunction[0]['func']);
			$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
		}
		$usertype  = $this->Embismodel->selectdata('embis.acc_usertype','*','',$whereutype,$order_by);

		$wherechk = $this->db->where('tf.userid = "'.$other_token.'" ORDER BY tf.route_order ASC');
		$joinchk = $this->db->join('acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$chkhierarchy = $this->Embismodel->selectdata('to_func AS tf','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$wherechk);
	?>
		<div class="form-group" id="trnsfr-form-header">
			<label>New User Function</label>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>Function</label>
					<select id="_trnsfrfnctnselectize<?php echo $other_token; ?>" class="form-control" name="dflt_user_function" required>
						<option value="<?php echo $this->encrypt->encode($selectfunction[0]['func']); ?>"><?php echo $selectfunction[0]['func']; ?></option>
						<?php for ($a=0; $a < sizeof($usertype); $a++) { ?>
							<option value="<?php echo $this->encrypt->encode($usertype[$a]['dsc']); ?>"><?php echo $usertype[$a]['dsc']; ?></option>
					  <?php } ?>
					</select>
				</div>
				<div class="col-md-6">
					<label>Position Title</label>
					<input type="text" class="form-control" name="dflt_designation" value="" required>
				</div>
				<div class="col-md-6">
					<label>Division</label>
					<select id="_trnsfdvsnselectize<?php echo $other_token; ?>" class="form-control" name="dflt_user_division" onchange="transfer_sec_details(this.value,'<?php echo $other_token; ?>');" required>
						<option value="<?php echo $this->encrypt->encode($selectfunction[0]['token']); ?>"><?php echo $selectfunction[0]['divname']; ?></option>
						<?php for ($i=0; $i < sizeof($division); $i++) { ?>
							<optgroup label="<?php echo $division[$i]['cat']; ?>">
								<option value="<?php echo $this->encrypt->encode($division[$i]['token']); ?>"><?php echo $division[$i]['divname']; ?></option>
							</optgroup>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6" id="transfer_sec_details_<?php echo $other_token; ?>">
					<label>Section</label>
					<select id="_trnsfsctnselectize<?php echo $other_token; ?>" class="form-control" name="dflt_user_section">
						<option value="<?php echo $this->encrypt->encode($selectfunction[0]['secno']); ?>"><?php echo $selectfunction[0]['sect']; ?></option>
						<?php for ($sc=0; $sc < sizeof($querysection); $sc++) { ?>
							<optgroup label="<?php echo $querysection[$sc]['cat']; ?>">
								<option value="<?php echo $this->encrypt->encode($querysection[$sc]['secno']); ?>"><?php echo $querysection[$sc]['sect']; ?></option>
							</optgroup>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group" id="trnsfr-form-header">
			<label>Current Hierarchy of Superiors</label>
		</div>
		<div class="form-group">
			<div class="row" id="dlfthrchy_">
				<?php
					$cnt = 0;
					for ($chkh=0; $chkh < sizeof($chkhierarchy); $chkh++) {
						$suffix = (!empty($chkhierarchy[$chkh]['suffix'])) ? ' '.$chkhierarchy[$chkh]['suffix'] : '';
						$prefix = (!empty($chkhierarchy[$chkh]['title'])) ? $chkhierarchy[$chkh]['title'].' ' : '';
						$mname = (!empty($chkhierarchy[$chkh]['mname'])) ? $chkhierarchy[$chkh]['mname'][0].'. ' : '';
						$name = $prefix.ucwords($chkhierarchy[$chkh]['fname']." ".$mname.$chkhierarchy[$chkh]['sname']).$suffix;
						$cnt++;
				?>
					<div class="col-md-10" style="margin-top:5px;">
						<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
					</div>
					<div class="col-md-2" style="margin-top:5px;">
						<input type="text" class="form-control" value="<?php echo $cnt; ?>" readonly>
					</div>
				<?php } ?>
				<div class="col-md-12" style="margin-top:5px;">
					<button type="button" style="float:right;" class="btn btn-warning btn-sm" onclick=transhrchyslct('<?php echo $this->encrypt->encode('1'); ?>','','');>Change Hierarchy</button>
				</div>
			</div>
		</div>
		<script type="text/javascript"> $('#_trnsfdvsnselectize<?php echo $other_token; ?>').selectize(); $('#_trnsfrfnctnselectize<?php echo $other_token; ?>').selectize(); $('#_trnsfsctnselectize<?php echo $other_token; ?>').selectize();</script>
	<?php
	}

	function chkdfltexstfncundrrplc(){
		$region = $this->session->userdata('region');
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$other_token = $this->encrypt->decode($this->input->post('other_token', TRUE));

		$wherefunction = $this->db->where('af.userid = "'.$token.'" AND af.stat = "1"');
		$joinfunction = $this->db->join('acc_xsect AS xt','xt.secno = af.secno','left');
		$joinfunction = $this->db->join('acc_xdvsion AS ax','ax.divno = af.divno','left');
		$joinfunction = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
		$selectfunction = $this->Embismodel->selectdata('acc_function AS af','af.func,acs.designation,ax.divno,ax.token,ax.divname,xt.secno,xt.sect','',$joinfunction,$wherefunction);

		if($region == 'CO'){ $region_div = 'co'; }else{ $region_div = 'region'; }
		$orderbydiv	= $this->db->order_by('acc_xdvsion.divname','ASC');
		if(!empty($selectfunction[0]['token'])){
			$wherediv   = $this->db->where('acc_xdvsion.token !=',$selectfunction[0]['token']);
		}
		$wherediv   = $this->db->where('acc_xdvsion.type',$region_div);
		$division   = $this->Embismodel->selectdata('embis.acc_xdvsion','*','',$wherediv,$orderbydiv);

		if($this->session->userdata('region') == 'CO'){ $region_name = 'CO'; }else{ $region_name = 'R'; }
		$where_not_sect = $this->db->where('axna.region = "'.$this->session->userdata('region').'"');
		$not_sect       = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axna','axna.*','',$where_not_sect);
		for ($ns=0; $ns < sizeof($not_sect); $ns++) {
			$where_qrysec   = $this->db->where('xt.secno != "'.$not_sect[$ns]['secno'].'"');
		}
		$where_qrysec     = $this->db->where('xt.secno != 69 AND xt.secno != "'.$selectfunction[0]['secno'].'" AND xt.divno = "'.$selectfunction[0]['divno'].'" AND (xt.region = "'.$region_name.'" OR xt.region = "'.$region.'")');
		$order_by_qrysec  = $this->db->order_by('xt.sect','ASC');
		$querysection     = $this->Embismodel->selectdata('embis.acc_xsect AS xt','*','',$where_qrysec,$order_by_qrysec);

		if($_SESSION['superadmin_rights'] == 'yes'){
			$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
			$whereutype				  = $this->db->where('acc_usertype.dsc !=', $selectfunction[0]['func']);
		}else{
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '1');
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '7');
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '2');
			$whereutype				  = $this->db->where('acc_usertype.dsc !=', $selectfunction[0]['func']);
			$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
		}
		$usertype  = $this->Embismodel->selectdata('embis.acc_usertype','*','',$whereutype,$order_by);

		$wherechk = $this->db->where('tf.userid = "'.$token.'" ORDER BY tf.route_order ASC');
		$joinchk = $this->db->join('acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$chkhierarchy = $this->Embismodel->selectdata('to_func AS tf','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$wherechk);
	?>
		<div class="form-group" id="trnsfr-form-header">
			<label>New User Function</label>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>Function</label>
					<select id="trnsfrfnctnselectize<?php echo $token; ?>" class="form-control" name="rplc_user_function" required>
						<option value="<?php echo $this->encrypt->encode($selectfunction[0]['func']); ?>"><?php echo $selectfunction[0]['func']; ?></option>
						<?php for ($a=0; $a < sizeof($usertype); $a++) { ?>
							<option value="<?php echo $this->encrypt->encode($usertype[$a]['dsc']); ?>"><?php echo $usertype[$a]['dsc']; ?></option>
					  <?php } ?>
					</select>
				</div>
				<div class="col-md-6">
					<label>Position Title</label>
					<input type="text" class="form-control" name="rplc_designation" value="" required>
				</div>
				<div class="col-md-6">
					<label>Division</label>
					<select id="trnsfdvsnselectize<?php echo $token; ?>" class="form-control" name="rplc_user_division" onchange="_transfer_sec_details_(this.value,'<?php echo $token; ?>');" required>
						<option value="<?php echo $this->encrypt->encode($selectfunction[0]['token']); ?>"><?php echo $selectfunction[0]['divname']; ?></option>
						<?php for ($i=0; $i < sizeof($division); $i++) { ?>
							<optgroup label="<?php echo $division[$i]['cat']; ?>">
								<option value="<?php echo $this->encrypt->encode($division[$i]['token']); ?>"><?php echo $division[$i]['divname']; ?></option>
							</optgroup>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6" id="_transfer_sec_details_<?php echo $token; ?>">
					<label>Section</label>
					<select id="trnsfsctnselectize<?php echo $token; ?>" class="form-control" name="rplc_user_section">
						<option value="<?php echo $this->encrypt->encode($selectfunction[0]['secno']); ?>"><?php echo $selectfunction[0]['sect']; ?></option>
						<?php for ($sc=0; $sc < sizeof($querysection); $sc++) { ?>
							<optgroup label="<?php echo $querysection[$sc]['cat']; ?>">
								<option value="<?php echo $this->encrypt->encode($querysection[$sc]['secno']); ?>"><?php echo $querysection[$sc]['sect']; ?></option>
							</optgroup>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group" id="trnsfr-form-header">
			<label>Current Hierarchy of Superiors</label>
		</div>
		<div class="form-group">
			<div class="row" id="_dlfthrchy_">
				<?php
					$cnt = 0;
					for ($chkh=0; $chkh < sizeof($chkhierarchy); $chkh++) {
						$suffix = (!empty($chkhierarchy[$chkh]['suffix'])) ? ' '.$chkhierarchy[$chkh]['suffix'] : '';
						$prefix = (!empty($chkhierarchy[$chkh]['title'])) ? $chkhierarchy[$chkh]['title'].' ' : '';
						$mname = (!empty($chkhierarchy[$chkh]['mname'])) ? $chkhierarchy[$chkh]['mname'][0].'. ' : '';
						$name = $prefix.ucwords($chkhierarchy[$chkh]['fname']." ".$mname.$chkhierarchy[$chkh]['sname']).$suffix;
						$cnt++;
				?>
					<div class="col-md-10" style="margin-top:5px;">
						<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
					</div>
					<div class="col-md-2" style="margin-top:5px;">
						<input type="text" class="form-control" value="<?php echo $cnt; ?>" readonly>
					</div>
				<?php } ?>
				<div class="col-md-12" style="margin-top:5px;">
					<button type="button" style="float:right;" class="btn btn-warning btn-sm" onclick=transhrchyslct_('<?php echo $this->encrypt->encode('1'); ?>','','');>Change Hierarchy</button>
				</div>
			</div>
		</div>
		<script type="text/javascript"> $('#trnsfdvsnselectize<?php echo $token; ?>').selectize(); $('#trnsfrfnctnselectize<?php echo $token; ?>').selectize(); $('#trnsfsctnselectize<?php echo $token; ?>').selectize();</script>
	<?php
	}

	function transhrchyslct(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$val = $this->encrypt->decode($this->input->post('val', TRUE));
		$user = $this->encrypt->decode($this->input->post('user', TRUE));

		$wherechk = $this->db->where('af.stat = "1" AND af.userid = "'.$user.'"');
		$selectchk = $this->Embismodel->selectdata('acc_function AS af','af.func','',$wherechk);

		$region = $this->session->userdata('region');
		$where = $this->db->where('acs.userid != "'.$user.'" AND af.stat = "1" AND acs.verified = "1" AND acs.region = "'.$region.'" ORDER BY af.func_order ASC, acs.fname ASC');
		$employee_list_active = $this->Administrativemodel->select_employees($where);
	?>
		<?php if($token == '1') { ?>
			<div class="col-md-12">
				<label>Select number of rows: </label><button type="button" class="btn btn-info btn-sm" onclick="undothierchy($('#dfltuserselectize').val());" style="float:right;margin-top:6px;height:23px;"><i class="fa fa-undo"></i>&nbsp;Undo</button>
				<select class="form-control" id="trnsfrrowsselectize" onchange=transhrchyslct('<?php echo $this->encrypt->encode('2'); ?>',this.value,$('#dfltuserselectize').val()); required="">
					<option></option>
					<?php for ($i=1; $i < 10; $i++) { ?>
						<option value="<?php echo $this->encrypt->encode($i); ?>"><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12" id="rowsrslt_"></div>
			<script type="text/javascript">$('#trnsfrrowsselectize').selectize();</script>
		<?php
				}else if($token == '2'){

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

					$whererd = $this->db->where('acs.verified = "1" AND af.stat = "1" AND af.func = "Regional Director" AND acs.region = "'.$region.'"');
					$joinrd = $this->db->join('acc_function AS af','acs.userid = af.userid','left');
					$selectrd = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinrd,$whererd);
					if(!empty($selectrd[0]['mname'])){ $rdmname = $selectrd[0]['mname'][0].". "; }else{ $rdmname = ""; }
					if(!empty($selectrd[0]['suffix'])){ $rdsuffix = " ".$selectrd[0]['suffix']; }else{ $rdsuffix = ""; }
					if(!empty($selectrd[0]['title'])){ $rdprefix = $selectrd[0]['title']." "; }else{ $rdprefix = ""; }
					$rdname = $rdprefix.ucwords($selectrd[0]['fname']." ".$rdmname.$selectrd[0]['sname']).$rdsuffix;
					if($region == 'CO'){ $thorder = 1; }else{ if($selectchk[0]['func'] == 'Regional Director'){ $thorder = 2; }else{ $thorder = 3; } }
				?>
						<div class="row">
							<div class="col-md-10" style="margin-top:5px;">
								<select class="form-control" name="dflt_employee[]" readonly>
									<option value="<?php echo $this->encrypt->encode($selectdirector[0]['userid']); ?>"><?php echo $directorname; ?></option>
								</select>
							</div>
							<div class="col-md-2" style="margin-top:5px;">
									<input type="hidden" class="form-control" name="dflt_order[]" value="<?php echo $this->encrypt->encode('1'); ?>" required="" readonly="">
									<input type="text" class="form-control" value="<?php echo '1'; ?>" required="" readonly="">
							</div>
							<?php if($region != 'CO'){ ?>
								<div class="col-md-10" style="margin-top:5px;">
									<select class="form-control" name="dflt_employee[]" readonly>
										<option value="<?php echo $this->encrypt->encode($selectadirector[0]['userid']); ?>"><?php echo $adname; ?></option>
									</select>
								</div>
								<div class="col-md-2" style="margin-top:5px;">
										<input type="hidden" class="form-control" name="dflt_order[]" value="<?php echo $this->encrypt->encode('2'); ?>" required="" readonly="">
										<input type="text" class="form-control" value="<?php echo '2'; ?>" required="" readonly="">
								</div>
								<?php if($selectchk[0]['func'] != 'Regional Director'){ //if emp selected is not rd ?>
									<div class="col-md-10" style="margin-top:5px;">
										<select class="form-control" name="dflt_employee[]" readonly>
											<option value="<?php echo $this->encrypt->encode($selectrd[0]['userid']); ?>"><?php echo $rdname; ?></option>
										</select>
									</div>
									<div class="col-md-2" style="margin-top:5px;">
											<input type="hidden" class="form-control" name="dflt_order[]" value="<?php echo $this->encrypt->encode('3'); ?>" required="" readonly="">
											<input type="text" class="form-control" value="<?php echo '3'; ?>" required="" readonly="">
									</div>
								<?php } ?>
							<?php } ?>
							<?php for ($i=$thorder; $i < $val; $i++) { $thorder++; ?>
									<div class="col-md-10" style="margin-top:5px;">
							            <select id="thempselectize<?php echo $i; ?>" class="form-control" name="dflt_employee[]" required>
							                <option value="">-</option>
							              <?php
							                for ($a=0; $a < sizeof($employee_list_active); $a++) {
							                  if(!empty($employee_list_active[$a]['mname'])){ $mname = $employee_list_active[$a]['mname'][0].". "; }else{ $mname = ""; }
							                  if(!empty($employee_list_active[$a]['suffix'])){ $suffix = " ".$employee_list_active[$a]['suffix']; }else{ $suffix = ""; }
																if(!empty($employee_list_active[$a]['title'])){ $prefix = $employee_list_active[$a]['title']." "; }else{ $prefix = ""; }
							                  $nmstr   = str_replace('Ã±', '&ntilde;', $employee_list_active[$a]['fname']." ".$mname.$employee_list_active[$a]['sname']);
							                  $empname = $prefix.ucwords(str_replace('ã±', '&ntilde;', $nmstr)).$suffix;
							              ?>
							                <optgroup label="<?php echo $employee_list_active[$a]['func']; ?>">
							                	<option value="<?php echo $this->encrypt->encode($employee_list_active[$a]['userid']); ?>"><?php echo $empname; ?></option>
							                </optgroup>
							              <?php } ?>
							            </select>
						        </div>
						        <div class="col-md-2" style="margin-top:5px;">
						            <input type="hidden" class="form-control" name="dflt_order[]" value="<?php echo $this->encrypt->encode($thorder); ?>" required="" readonly="">
						            <input type="text" class="form-control" value="<?php echo $thorder; ?>" required="" readonly="">
						        </div>
								<script type="text/javascript"> $('#thempselectize<?php echo $i; ?>').selectize(); </script>
							<?php } ?>
						</div>
		<?php } ?>
	<?php
	}

	function transhrchyslct_(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$val = $this->encrypt->decode($this->input->post('val', TRUE));
		$user = $this->encrypt->decode($this->input->post('user', TRUE));

		$wherechk = $this->db->where('af.stat = "1" AND af.userid = "'.$user.'"');
		$selectchk = $this->Embismodel->selectdata('acc_function AS af','af.func','',$wherechk);

		$region = $this->session->userdata('region');
		$where = $this->db->where('acs.userid != "'.$user.'" AND af.stat = "1" AND acs.verified = "1" AND acs.region = "'.$region.'" ORDER BY af.func_order ASC, acs.fname ASC');
		$employee_list_active = $this->Administrativemodel->select_employees($where);
	?>
		<?php if($token == '1') { ?>
			<div class="col-md-12">
				<label>Select number of rows: </label><button type="button" class="btn btn-info btn-sm" onclick="undothierchy_($('#dfltuserselectize').val());" style="float:right;margin-top:6px;height:23px;"><i class="fa fa-undo"></i>&nbsp;Undo</button>
				<select class="form-control" id="trnsfrrowsselectize_" onchange=transhrchyslct_('<?php echo $this->encrypt->encode('2'); ?>',this.value,$('#dfltuserselectize').val()); required="">
					<option></option>
					<?php for ($i=1; $i < 10; $i++) { ?>
						<option value="<?php echo $this->encrypt->encode($i); ?>"><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12" id="_rowsrslt_"></div>
			<script type="text/javascript">$('#trnsfrrowsselectize_').selectize();</script>
		<?php
				}else if($token == '2'){
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

					$whererd = $this->db->where('acs.verified = "1" AND af.stat = "1" AND af.func = "Regional Director" AND acs.region = "'.$region.'"');
					$joinrd = $this->db->join('acc_function AS af','acs.userid = af.userid','left');
					$selectrd = $this->Embismodel->selectdata('acc_credentials AS acs','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinrd,$whererd);
					if(!empty($selectrd[0]['mname'])){ $rdmname = $selectrd[0]['mname'][0].". "; }else{ $rdmname = ""; }
					if(!empty($selectrd[0]['suffix'])){ $rdsuffix = " ".$selectrd[0]['suffix']; }else{ $rdsuffix = ""; }
					if(!empty($selectrd[0]['title'])){ $rdprefix = $selectrd[0]['title']." "; }else{ $rdprefix = ""; }
					$rdname = $rdprefix.ucwords($selectrd[0]['fname']." ".$rdmname.$selectrd[0]['sname']).$rdsuffix;
					if($region == 'CO'){ $thorder = 1; }else{ if($selectchk[0]['func'] == 'Regional Director'){ $thorder = 2; }else{ $thorder = 3; } }
				?>
						<div class="row">
							<div class="col-md-10" style="margin-top:5px;">
								<select class="form-control" name="rplc_employee[]" readonly>
									<option value="<?php echo $this->encrypt->encode($selectdirector[0]['userid']); ?>"><?php echo $directorname; ?></option>
								</select>
							</div>
							<div class="col-md-2" style="margin-top:5px;">
									<input type="hidden" class="form-control" name="rplc_order[]" value="<?php echo $this->encrypt->encode('1'); ?>" required="" readonly="">
									<input type="text" class="form-control" value="<?php echo '1'; ?>" required="" readonly="">
							</div>
							<?php if($region != 'CO'){ ?>
								<div class="col-md-10" style="margin-top:5px;">
									<select class="form-control" name="rplc_employee[]" readonly>
										<option value="<?php echo $this->encrypt->encode($selectadirector[0]['userid']); ?>"><?php echo $adname; ?></option>
									</select>
								</div>
								<div class="col-md-2" style="margin-top:5px;">
										<input type="hidden" class="form-control" name="rplc_order[]" value="<?php echo $this->encrypt->encode('2'); ?>" required="" readonly="">
										<input type="text" class="form-control" value="<?php echo '2'; ?>" required="" readonly="">
								</div>
								<?php if($selectchk[0]['func'] != 'Regional Director'){ //if emp selected is not rd ?>
									<div class="col-md-10" style="margin-top:5px;">
										<select class="form-control" name="rplc_employee[]" readonly>
											<option value="<?php echo $this->encrypt->encode($selectrd[0]['userid']); ?>"><?php echo $rdname; ?></option>
										</select>
									</div>
									<div class="col-md-2" style="margin-top:5px;">
											<input type="hidden" class="form-control" name="rplc_order[]" value="<?php echo $this->encrypt->encode('3'); ?>" required="" readonly="">
											<input type="text" class="form-control" value="<?php echo '3'; ?>" required="" readonly="">
									</div>
								<?php } ?>
							<?php } ?>
							<?php for ($i=$thorder; $i < $val; $i++) { $thorder++; ?>
									<div class="col-md-10" style="margin-top:5px;">
							            <select id="_thempselectize<?php echo $i; ?>" class="form-control" name="rplc_employee[]" required>
							                <option value="">-</option>
							              <?php
							                for ($a=0; $a < sizeof($employee_list_active); $a++) {
							                  if(!empty($employee_list_active[$a]['mname'])){ $mname = $employee_list_active[$a]['mname'][0].". "; }else{ $mname = ""; }
							                  if(!empty($employee_list_active[$a]['suffix'])){ $suffix = " ".$employee_list_active[$a]['suffix']; }else{ $suffix = ""; }
																if(!empty($employee_list_active[$a]['title'])){ $prefix = $employee_list_active[$a]['title']." "; }else{ $prefix = ""; }
							                  $nmstr   = str_replace('Ã±', '&ntilde;', $employee_list_active[$a]['fname']." ".$mname.$employee_list_active[$a]['sname']);
							                  $empname = $prefix.ucwords(str_replace('ã±', '&ntilde;', $nmstr)).$suffix;
							              ?>
							                <optgroup label="<?php echo $employee_list_active[$a]['func']; ?>">
							                	<option value="<?php echo $this->encrypt->encode($employee_list_active[$a]['userid']); ?>"><?php echo $empname; ?></option>
							                </optgroup>
							              <?php } ?>
							            </select>
						        </div>
						        <div class="col-md-2" style="margin-top:5px;">
						            <input type="hidden" class="form-control" name="rplc_order[]" value="<?php echo $this->encrypt->encode($thorder); ?>" required="" readonly="">
						            <input type="text" class="form-control" value="<?php echo $thorder; ?>" required="" readonly="">
						        </div>
								<script type="text/javascript"> $('#_thempselectize<?php echo $i; ?>').selectize(); </script>
							<?php } ?>
						</div>
		<?php } ?>
	<?php
	}

	function undothierchy(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$wherechk = $this->db->where('tf.userid = "'.$token.'" ORDER BY tf.route_order ASC');
		$joinchk = $this->db->join('acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$chkhierarchy = $this->Embismodel->selectdata('to_func AS tf','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$wherechk);
	?>
		<?php
			$cnt = 0;
			for ($chkh=0; $chkh < sizeof($chkhierarchy); $chkh++) {
				$suffix = (!empty($chkhierarchy[$chkh]['suffix'])) ? ' '.$chkhierarchy[$chkh]['suffix'] : '';
				$prefix = (!empty($chkhierarchy[$chkh]['title'])) ? $chkhierarchy[$chkh]['title'].' ' : '';
				$mname = (!empty($chkhierarchy[$chkh]['mname'])) ? $chkhierarchy[$chkh]['mname'][0].'. ' : '';
				$name = $prefix.ucwords($chkhierarchy[$chkh]['fname']." ".$mname.$chkhierarchy[$chkh]['sname']).$suffix;
				$cnt++;
		?>
			<div class="col-md-10" style="margin-top:5px;">
				<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
			</div>
			<div class="col-md-2" style="margin-top:5px;">
				<input type="text" class="form-control" value="<?php echo $cnt; ?>" readonly>
			</div>
		<?php } ?>
		<div class="col-md-12" style="margin-top:5px;">
			<button type="button" style="float:right;" class="btn btn-warning btn-sm" onclick=transhrchyslct('<?php echo $this->encrypt->encode('1'); ?>','','');>Change Hierarchy</button>
		</div>
	<?php
	}

	function undothierchy_(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		$wherechk = $this->db->where('tf.userid = "'.$token.'" ORDER BY tf.route_order ASC');
		$joinchk = $this->db->join('acc_credentials AS acs','acs.userid = tf.assigned_to','left');
		$chkhierarchy = $this->Embismodel->selectdata('to_func AS tf','acs.userid,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$wherechk);
	?>
		<?php
			$cnt = 0;
			for ($chkh=0; $chkh < sizeof($chkhierarchy); $chkh++) {
				$suffix = (!empty($chkhierarchy[$chkh]['suffix'])) ? ' '.$chkhierarchy[$chkh]['suffix'] : '';
				$prefix = (!empty($chkhierarchy[$chkh]['title'])) ? $chkhierarchy[$chkh]['title'].' ' : '';
				$mname = (!empty($chkhierarchy[$chkh]['mname'])) ? $chkhierarchy[$chkh]['mname'][0].'. ' : '';
				$name = $prefix.ucwords($chkhierarchy[$chkh]['fname']." ".$mname.$chkhierarchy[$chkh]['sname']).$suffix;
				$cnt++;
		?>
			<div class="col-md-10" style="margin-top:5px;">
				<input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
			</div>
			<div class="col-md-2" style="margin-top:5px;">
				<input type="text" class="form-control" value="<?php echo $cnt; ?>" readonly>
			</div>
		<?php } ?>
		<div class="col-md-12" style="margin-top:5px;">
			<button type="button" style="float:right;" class="btn btn-warning btn-sm" onclick=transhrchyslct_('<?php echo $this->encrypt->encode('1'); ?>','','');>Change Hierarchy</button>
		</div>
	<?php
	}

	function undrprsnnlt(){
		$dflt = $this->encrypt->decode($this->input->post('dflt', TRUE));
		$rplcmnt = $this->encrypt->decode($this->input->post('rplcmnt', TRUE));
		$val = ($this->input->post('val', TRUE));

		$wheredfltname = $this->db->where('acs.userid = "'.$dflt.'"');
		$dfltname = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$wheredfltname);
		$suffix = (!empty($dfltname[0]['suffix'])) ? ' '.$dfltname[0]['suffix'] : '';
		$prefix = (!empty($dfltname[0]['title'])) ? $dfltname[0]['title'].' ' : '';
		$mname = (!empty($dfltname[0]['mname'])) ? $dfltname[0]['mname'][0].'. ' : '';
		$dfltname = $prefix.ucwords($dfltname[0]['fname']." ".$mname.$dfltname[0]['sname']).$suffix;

		$whererplcname = $this->db->where('acs.userid = "'.$rplcmnt.'"');
		$rplcname = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$whererplcname);
		$suffix = (!empty($rplcname[0]['suffix'])) ? ' '.$rplcname[0]['suffix'] : '';
		$prefix = (!empty($rplcname[0]['title'])) ? $rplcname[0]['title'].' ' : '';
		$mname = (!empty($rplcname[0]['mname'])) ? $rplcname[0]['mname'][0].'. ' : '';
		$rplcname = $prefix.ucwords($rplcname[0]['fname']." ".$mname.$rplcname[0]['sname']).$suffix;

		$wheredflt = $this->db->where('tf.assigned_to = "'.$dflt.'" AND af.stat = "1" ORDER BY af.func_order ASC, acs.fname ASC');
		$joindflt = $this->db->join('acc_function AS af','af.userid = tf.userid','left');
		$joindflt = $this->db->join('acc_credentials AS acs','acs.userid = tf.userid','left');
		$dflth = $this->Embismodel->selectdata('to_func AS tf','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,af.func','',$joindflt,$wheredflt);

		$whererplc = $this->db->where('tf.assigned_to = "'.$rplcmnt.'" AND af.stat = "1" ORDER BY af.func_order ASC, acs.fname ASC');
		$joinrplc = $this->db->join('acc_function AS af','af.userid = tf.userid','left');
		$joinrplc = $this->db->join('acc_credentials AS acs','acs.userid = tf.userid','left');
		$rplch = $this->Embismodel->selectdata('to_func AS tf','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,af.func','',$joinrplc,$whererplc);
		if(!empty($dflt) AND !empty($rplcmnt) AND $val == 'b'){ ?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" id="trnsfr-form-header">
						<label>Under Personnel</label>
					</div>
					<div class="form-group" style="margin-top:5px;">
						<div class="col-md-12" style="text-align:center;">
							<label style="color:#000;"><b><u><?php echo $rplcname; ?></u>'s</b>&nbsp;under personnel will be transferred to <b><u><?php echo $dfltname; ?></u></b></label>
						</div>
						<select id="vwundrprsnlselectize" class="form-control">
							<option value="">Personnel (Viewing only)</option>
						<?php
							for ($l=0; $l < sizeof($dflth); $l++) {
								$suffix = (!empty($dflth[$l]['suffix'])) ? ' '.$dflth[$l]['suffix'] : '';
								$prefix = (!empty($dflth[$l]['title'])) ? $dflth[$l]['title'].' ' : '';
								$mname = (!empty($dflth[$l]['mname'])) ? $dflth[$l]['mname'][0].'. ' : '';
								$leftname = $prefix.ucwords($dflth[$l]['fname']." ".$mname.$dflth[$l]['sname']).$suffix;
						?>
								<optgroup label="<?php echo $dflth[$l]['func']; ?>">
									<option value="<?php echo $leftname; ?>" disabled><?php echo $leftname; ?></option>
								</optgroup>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group" id="trnsfr-form-header">
						<label>Under Personnel</label>
					</div>
					<div class="form-group" style="margin-top:5px;">
						<div class="col-md-12" style="text-align:center;">
							<label style="color:#000;"><b><u><?php echo $dfltname; ?></u>'s</b>&nbsp;under personnel will be transferred to <b><u><?php echo $rplcname; ?></u></b></label>
						</div>
						<select id="rvwundrprsnlselectize" class="form-control">
							<option value="">Personnel (Viewing only)</option>
						<?php
							for ($r=0; $r < sizeof($rplch); $r++) {
								$suffix = (!empty($rplch[$r]['suffix'])) ? ' '.$rplch[$r]['suffix'] : '';
								$prefix = (!empty($rplch[$r]['title'])) ? $rplch[$r]['title'].' ' : '';
								$mname = (!empty($rplch[$r]['mname'])) ? $rplch[$r]['mname'][0].'. ' : '';
								$rightname = $prefix.ucwords($rplch[$r]['fname']." ".$mname.$rplch[$r]['sname']).$suffix;
						?>
								<optgroup label="<?php echo $rplch[$r]['func']; ?>">
									<option value="<?php echo $rightname; ?>" disabled><?php echo $rightname; ?></option>
								</optgroup>
						<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				$("#vwundrprsnlselectize").selectize();
				$("#rvwundrprsnlselectize").selectize();
			</script>
		<?php
		}
	}

	function rmvusrbtnusrlst(){
		$token = $this->encrypt->decode($this->input->post('token', TRUE));
		
		if(!empty($token)){
			$data_fnctns   = array(
				'verified' 	   => '2',
			);

			$wherefnctns   = array('acc_credentials.userid' => $token);
			$updatefunctns = $this->Embismodel->updatedata($data_fnctns,'acc_credentials',$wherefnctns);

			$data_action   = array(
				'acc_status' => '0',
			);

			$whereaction   = array('acc.userid' => $token);
			$updatefunctn  = $this->Embismodel->updatedata($data_action,'acc',$whereaction);

			echo json_encode(array('status' => 'success', ));
		}else{
			echo json_encode(array('status' => 'failed', ));
		}
	}

}

?>
