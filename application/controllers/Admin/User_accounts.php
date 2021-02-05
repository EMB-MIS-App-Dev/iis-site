<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class User_accounts extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
		$this->Embismodel->selectdatarights();
	}

	//user list
	function User_list(){

		$user_region = $this->session->userdata('region');

		//FOR D
		$whered     = $this->db->where('as.region', $user_region);
		$orderbyd   = $this->db->order_by("as.sname", "ASC");
		$queryselect['region_director'] = $this->Embismodel->selectdata('embis.acc_credentials AS as','as.token,as.fname,as.mname,as.sname,as.suffix','',$whered,$orderbyd);

		// $wherechkd  = $this->db->where('af.region', $user_region);
		$wherechkd  = $this->db->where('af.func', 'Director');
		$wherechkd  = $this->db->where('af.stat', '1');
		$joinchkd   = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = af.userid', 'left');
		$joinchkd   = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
		$queryselectchkd = $this->Embismodel->selectdata('embis.acc_function AS af','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.userid,acs.designation,pn.planpstn_desc,acs.plantilla_itemno','',$wherechkd,$joinchkd);

			if(!empty($queryselectchkd[0]['mname'])){
				$dmname  = $queryselectchkd[0]['mname'][0].". ";
			}else{
				$dmname  = "";
			}

			if(!empty($queryselectchkd[0]['suffix'])){
				$dsuffix = " ".$queryselectchkd[0]['suffix'];
			}else{
				$dsuffix = "";
			}

			$dprefix = (!empty($queryselectchkd[0]['title'])) ? $queryselectchkd[0]['title']." " : "";

		$queryselect['d_assigned'] = $dprefix.$queryselectchkd[0]['fname']." ".$dmname.$queryselectchkd[0]['sname'].$dsuffix;
		$queryselect['d_desig']    = $queryselectchkd[0]['designation'];

		if($queryselectchkd[0]['plantilla_itemno'] == 'Chief' || $queryselectchkd[0]['plantilla_itemno'] == 'Supervising' || $queryselectchkd[0]['plantilla_itemno'] == 'Senior'){
			if(!empty($queryselectchkd[0]['plantilla_itemno'])){
				$rank = $queryselectchkd[0]['plantilla_itemno']." "; }else{ $rank = ""; }
			$queryselect['plantilla']  = $rank.$queryselectchkd[0]['planpstn_desc'];
		}else{
			if(!empty($queryselectchkd[0]['plantilla_itemno'])){
				$rank = " ".$queryselectchkd[0]['plantilla_itemno']; }else{ $rank = ""; }
			$queryselect['plantilla']  = $queryselectchkd[0]['planpstn_desc'].$rank;
		}

		//FOR D

		//FOR AD

		$wheread     = $this->db->where('as.region', $user_region);
		$orderbyad   = $this->db->order_by("as.sname", "ASC");
		$queryselect['region_director'] = $this->Embismodel->selectdata('embis.acc_credentials AS as','as.token,as.fname,as.mname,as.sname,as.suffix','',$wheread,$orderbyad);

		// $wherechkad  = $this->db->where('af.region', $user_region);
		$wherechkad  = $this->db->where('af.func', 'Assistant Director');
		$wherechkad  = $this->db->where('af.office', $this->session->userdata('office'));
		$wherechkad  = $this->db->where('af.stat', '1');
		$joinchkad   = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = af.userid', 'left');
		$joinchkad   = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
		$queryselectchkad = $this->Embismodel->selectdata('embis.acc_function AS af','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.userid,acs.designation,pn.planpstn_desc,acs.plantilla_itemno','',$wherechkad,$joinchkad);

			if(!empty($queryselectchkad[0]['mname'])){
				$dmname  = $queryselectchkad[0]['mname'][0].". ";
			}else{
				$dmname  = "";
			}

			if(!empty($queryselectchkad[0]['suffix'])){
				$dsuffix = " ".$queryselectchkad[0]['suffix'];
			}else{
				$dsuffix = "";
			}

			$dprefix = (!empty($queryselectchkad[0]['title'])) ? $queryselectchkad[0]['title']." " : "";

		$queryselect['ad_assigned'] = $dprefix.$queryselectchkad[0]['fname']." ".$dmname.$queryselectchkad[0]['sname'].$dsuffix;
		$queryselect['ad_desig']    = $queryselectchkad[0]['designation'];

		if($queryselectchkad[0]['plantilla_itemno'] == 'Chief' || $queryselectchkad[0]['plantilla_itemno'] == 'Supervising' || $queryselectchkad[0]['plantilla_itemno'] == 'Senior'){
			if(!empty($queryselectchkad[0]['plantilla_itemno'])){
				$rank = $queryselectchkad[0]['plantilla_itemno']." "; }else{ $rank = ""; }
			$queryselect['ad_plantilla']  = $rank.$queryselectchkad[0]['planpstn_desc'];
		}else{
			if(!empty($queryselectchkad[0]['plantilla_itemno'])){
				$rank = " ".$queryselectchkad[0]['plantilla_itemno']; }else{ $rank = ""; }
			$queryselect['ad_plantilla']  = $queryselectchkad[0]['planpstn_desc'].$rank;
		}

		//FOR AD

		//FOR RD
		$whererd     = $this->db->where('as.region', $user_region);
		$orderbyrd   = $this->db->order_by("as.sname", "ASC");
		$queryselect['region_director'] = $this->Embismodel->selectdata('embis.acc_credentials AS as','as.token,as.fname,as.mname,as.sname,as.suffix','',$whererd,$orderbyrd);

		$wherechkrd  = $this->db->where('af.region', $user_region);
		$wherechkrd  = $this->db->where('af.func', 'Regional Director');
		$wherechkrd  = $this->db->where('af.stat', '1');
		$joinchkrd   = $this->db->join('embis.acc_credentials AS acs', 'acs.userid = af.userid', 'left');
		$joinchkrd   = $this->db->join('embis.acc_plantillapostn AS pn', 'pn.planpstn_id = acs.plantilla_pos', 'left');
		$queryselectchkrd = $this->Embismodel->selectdata('embis.acc_function AS af','acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs.userid,acs.designation,pn.planpstn_desc,acs.plantilla_itemno','',$wherechkrd,$joinchkrd);

			if(!empty($queryselectchkrd[0]['mname'])){
				$rdmname  = $queryselectchkrd[0]['mname'][0].". ";
			}else{
				$rdmname  = "";
			}

			if(!empty($queryselectchkrd[0]['suffix'])){
				$rdsuffix = " ".$queryselectchkrd[0]['suffix'];
			}else{
				$rdsuffix = "";
			}

			$rdprefix = (!empty($queryselectchkrd[0]['title'])) ? $queryselectchkrd[0]['title']." " : "";

		$queryselect['rd_assigned'] = $rdprefix.$queryselectchkrd[0]['fname']." ".$rdmname.$queryselectchkrd[0]['sname'].$rdsuffix;
		$queryselect['rd_desig'] = $queryselectchkrd[0]['designation'];
		if(!empty($queryselectchkrd[0]['plantilla_itemno'])){ $rank = " ".$queryselectchkrd[0]['plantilla_itemno']; }else{ $rank = ""; }
		$queryselect['plantilla_rd']  = $queryselectchkrd[0]['planpstn_desc'].$rank;
		//FOR RD

		//FOR DC
		$wherechkdiv  = $this->db->where('an.func', 'Division Chief');
		$wherechkdiv  = $this->db->where('an.stat', '1');
		$wherechkdiv  = $this->db->where('an.region', $user_region);
		$queryselectchkwherediv     = $this->Embismodel->selectdata('embis.acc_function an','an.divno','',$wherechkdiv);

		for ($i=0; $i < sizeof($queryselectchkwherediv) ; $i++) {
			$whereuseracc_div       = $this->db->where('ax.divno !=', $queryselectchkwherediv[$i]['divno']);
		}
			$whereuseracc_div       = $this->db->where('ax.type', $user_region);

			$order_by               = $this->db->order_by('ax.divname', 'ASC');

		$queryselect['useracc_div'] = $this->Embismodel->selectdata('embis.acc_xdvsion ax','*','',$whereuseracc_div,$order_by);

		if($user_region == 'CO'){ $region_div = 'co'; }else{ $region_div = 'region'; }
		$wherechkdv  = $this->db->where('(xn.type = "'.$region_div.'" OR xn.type = "'.$user_region.'")');
		$wherechkdv  = $this->db->where('xn.divno !=', '14');
		$wherechkdv  = $this->db->where('xn.divno !=', '17');
		$wherechkdv  = $this->db->where('xn.office', $this->session->userdata('office'));
		$orderbydv   = $this->db->order_by('xn.divname', 'ASC');
		if($user_region != 'CO'){
		$wherechkdv  = $this->db->or_where('xn.cat', 'Office of the Regional Director');
		}
		$likedv      = $this->db->like('xn.divname', 'division');
		$queryselect['qrydivision'] = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divno, xn.divname, xn.divcode','',$wherechkdv,$likedv,$orderbydv);
		$queryselect['div_divno'] 	= $queryselect['qrydivision'][0]['divno'];
		// echo $this->db->last_query(); exit;

		//D STAFF
		$wherechkdvod  = $this->db->where('xn.type', $region_div);
		$wherechkdvod  = $this->db->where('xn.office', $this->session->userdata('office'));
		$orderbydvod   = $this->db->order_by('xn.divname', 'ASC');
		$notlikedvod   = $this->db->not_like('xn.divname', 'division');
		$joindvod      = $this->db->join('embis.acc_xsect AS xt','xt.divno = xn.divno','left');
		$queryselect['qrydivisionOD'] = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divno, xn.divname, xn.divcode, xt.sect','',$joindvod,$wherechkdvod,$orderbydvod);

		//FOR DC

		// $wheredirector            = $this->db->where('acc_function.region',$user_region);
		$wheredirector            = $this->db->where('acc_function.office',$this->session->userdata('office'));
		$wheredirector            = $this->db->where('acc_function.stat','1');
		$wheredirector            = $this->db->where('acc_function.func','Director');
		$queryselectdirector      = $this->Embismodel->selectdata('embis.acc_function','*','',$wheredirector);
		$queryselect['director']  = $queryselectdirector[0]['userid'];

		// $wheread            = $this->db->where('acc_function.region',$user_region);
		$wheread            = $this->db->where('acc_function.office',$this->session->userdata('office'));
		$wheread            = $this->db->where('acc_function.stat','1');
		$wheread            = $this->db->where('acc_function.func','Assistant Director');
		$queryselectad      = $this->Embismodel->selectdata('embis.acc_function','*','',$wheread);
		$queryselect['assistant_director']  = $queryselectad[0]['userid'];

		$whererdirector            = $this->db->where('acc_function.office',$this->session->userdata('office'));
		$whererdirector            = $this->db->where('acc_function.region',$user_region);
		$whererdirector            = $this->db->where('acc_function.stat','1');
		$whererdirector            = $this->db->where('acc_function.func','Regional Director');
		$queryselectrdirector      = $this->Embismodel->selectdata('embis.acc_function','*','',$whererdirector);
		$queryselect['regional_director']  = $queryselectrdirector[0]['userid'];

		$queryselect['suffix']	  = $this->Embismodel->selectdata('embis.acc_suffix','*','');
		$queryselect['region']	  = $this->Embismodel->selectdata('embis.acc_region','*','');

		if($user_region == 'CO'){ $region_div = 'co'; }else{ $region_div = 'region'; }
		$orderbydiv				  			= $this->db->order_by('acc_xdvsion.divname','ASC');
		$wherediv                 = $this->db->where('acc_xdvsion.office = "'.$this->session->userdata('office').'" AND (acc_xdvsion.type = "'.$region_div.'" OR acc_xdvsion.type = "'.strtolower($user_region).'")');
		$queryselect['division']  = $this->Embismodel->selectdata('embis.acc_xdvsion','*','',$wherediv,$orderbydiv);

		if($_SESSION['superadmin_rights'] == 'yes'){
			$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
			$queryselect['usertype']  = $this->Embismodel->selectdata('embis.acc_usertype','*','',$order_by);
		}else{
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '1');
			$whereutype				  = $this->db->where('acc_usertype.typeid !=', '7');
			if($_SESSION['office'] == 'DENR'){
				$whereutype				  = $this->db->where('acc_usertype.typeid !=', '2');
			}else{
				$whereutype				  = $this->db->where('acc_usertype.typeid !=', '11');
			}
			$order_by				  = $this->db->order_by('acc_usertype.ordr','ASC');
			$queryselect['usertype']  = $this->Embismodel->selectdata('embis.acc_usertype','*','',$whereutype,$order_by);
		}

		$wherenotequals               = $this->db->where('acc_function.region',$user_region);
		$wherenotequals               = $this->db->where('acc_function.stat', '1');
		$queryselectnotequals         = $this->Embismodel->selectdata('embis.acc_function','*','',$wherenotequals);


			for($i=0; $i < sizeof($queryselectnotequals); $i++){
				$whereuseraccounts         = $this->db->where('acs.userid !=',$queryselectnotequals[$i]['userid']);
			}

		$order_byaccounts			         = $this->db->order_by('acs.fname', 'ASC');
		$whereuseraccounts			       = $this->db->where('acs.region', $user_region);
		$whereuseraccounts			       = $this->db->where('acs.office', $this->session->userdata('office'));
		$whereuseraccounts			       = $this->db->where('acs.designation !=', 'Administrator');
		$whereuseraccounts			       = $this->db->where('acs.verified !=', '2');
		$joinuseraccounts              = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
		$queryselect['useraccounts']   = $this->Embismodel->selectdata('embis.acc_credentials AS acs','*','',$whereuseraccounts,$joinuseraccounts,$order_byaccounts);
		// echo $this->db->last_query(); exit;
		$order_bysettings			       = $this->db->order_by('ass.acc_desc', 'ASC');
		$queryselect['settings']  	       = $this->Embismodel->selectdata('embis.acc_settings AS ass','*','',$order_bysettings);

		$queryselect['countactive']        = $this->Embismodel->countactive();
		$queryselect['countnotassigned']   = $this->Embismodel->countnotassigned();

		$queryselect['employee_list']      = $this->Embismodel->employee_list();

		$queryselect['employee_list_active']      = $this->Embismodel->employee_list_active();
		// echo $this->db->last_query(); exit;

		$queryselect['user_actions']       = $this->Embismodel->user_actions();

		$order_by_qryplantilla             = $this->db->order_by('acc_plantillapostn.planpstn_desc','ASC');
		$queryselect['qryplantilla']       = $this->Embismodel->selectdata('embis.acc_plantillapostn','*','',$order_by_qryplantilla);

		$order_by_qryrank                  = $this->db->order_by('acc_rank.rank_id','ASC');
		$queryselect['qryrank']            = $this->Embismodel->selectdata('embis.acc_rank','*','',$order_by_qryrank);

		$queryselect['rule_name']      = $this->db->query("SELECT DISTINCT rule_name FROM embis.acc_rule AS ar WHERE ar.region = '$user_region' ORDER BY rule_name ASC")->result_array();

		$whereregions                      = $this->db->where('acc_region.rgnnum !=',$user_region);
		$queryselect['regions']            = $this->Embismodel->selectdata('embis.acc_region','*','',$whereregions);

		$whereoffice                      = $this->db->where('acc_office.office_code !=',$this->session->userdata('office'));
		$queryselect['office']            = $this->Embismodel->selectdata('embis.acc_office','*','',$whereoffice);

		$order_byaccountsright			       = $this->db->order_by('acs.fname', 'ASC');
		$whereuseraccountsright			       = $this->db->where('acs.region', $user_region);
		$whereuseraccountsright			       = $this->db->where('acs.office', $this->session->userdata('office'));
		$whereuseraccountsright			       = $this->db->where('acs.designation !=', 'Administrator');
		$whereuseraccountsright			       = $this->db->where('acs.verified', '1');
		$whereuseraccountsright			       = $this->db->where('ar.superadmin_rights', null);
		$joinuseraccountsright                 = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
		$joinuseraccountsright                 = $this->db->join('embis.acc_rights AS ar', 'ar.userid = acs.userid', 'left');
		$queryselect['useraccounts_right']     = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.*,ar.superadmin_rights','',$whereuseraccountsright,$joinuseraccountsright,$order_byaccountsright);
		// echo $this->db->last_query(); exit;

		if($_SESSION['superadmin_rights'] == 'yes'){
			$wheretrans = $this->db->where('af.stat = "1" AND acs.userid != "1" AND acs.verified = "1" AND acs.region = "'.$user_region.'" ORDER BY acs.verified DESC, af.func_order ASC, acs.fname ASC');
		}else{
			$wheretrans = $this->db->where('af.stat = "1" AND acs.userid != "1" AND af.func != "Director" AND af.func != "Regional Director" AND af.func != "Assistant Director" AND acs.verified = "1" AND acs.region = "'.$user_region.'" ORDER BY acs.verified DESC, af.func_order ASC, acs.fname ASC');
		}

		$jointrans = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
		$queryselect['employee_list_active_trans']      = $this->Embismodel->selectdata('acc_credentials AS acs','DISTINCT(acs.userid), acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, af.func','',$jointrans,$wheretrans);

		$this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
		$this->load->view('includes/common/footer');
		$this->load->view('superadmin/user_accounts',$queryselect);
		$this->load->view('superadmin/modals',$queryselect);
	}

}
