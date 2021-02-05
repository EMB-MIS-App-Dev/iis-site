<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Dashboard extends CI_Controller
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

  function index(){

		if(empty($this->session->userdata('userid'))){
			redirect('Index');
		}
    $order_byaccounts			         = $this->db->order_by('an.divname ASC, at.sect ASC, acs.fname ASC');
		$whereuseraccounts			       = $this->db->where('acs.region', $this->session->userdata('region'));
		$whereuseraccounts			       = $this->db->where('acs.office', $this->session->userdata('office'));
		$whereuseraccounts			       = $this->db->where('acs.designation !=', 'Administrator');
		$whereuseraccounts			       = $this->db->where('acs.verified', '1');
    $whereuseraccounts			       = $this->db->where('acs.userid !=', $this->session->userdata('userid'));
		$joinuseraccounts              = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
    $joinuseraccounts              = $this->db->join('embis.acc_xdvsion AS an', 'an.divno = acs.divno', 'left');
    $joinuseraccounts              = $this->db->join('embis.acc_xsect AS at', 'at.secno = acs.secno', 'left');
		$queryselect['useraccounts']   = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.userid,  acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, an.divname, at.sect','',$whereuseraccounts,$joinuseraccounts,$order_byaccounts);

		$wheredata   = $this->db->where('sl.status = "Active"');
    $querydata   = $this->Embismodel->selectdata('schedule_list AS sl','sl.participants, sl.cnt, sl.accountable','',$wheredata);

		$cntwhr = '';
		$cntr = 0;
		for ($e=0; $e < sizeof($querydata); $e++) {
			$explodeparticipants = explode('|', $querydata[$e]['participants']);
			for ($ep=0; $ep < count($explodeparticipants); $ep++) {
				if($explodeparticipants[$ep] == $this->session->userdata('userid')){
					$cntr++;
					$concnt = (!empty($explodeparticipants[$ep]) AND $cntr != 1) ? ' OR ': '';
					$con = (!empty($explodeparticipants[$ep]) AND $cntr == 1) ? ' OR ': '';
					$cntwhr .= $con.$concnt.'cnt = '.$querydata[$e]['cnt'];
				}
			}
		}

		$where = $this->db->where('sl.status = "Active" AND sl.creator = "'.$this->session->userdata('userid').'"'.$cntwhr);
		$queryselect['chkdatesched'] = $this->Embismodel->selectdata('schedule_list AS sl','sl.date_schedule,sl.subject,sl.cnt,sl.sched_status,sl.creator','',$where);


		$cntwhra = '';
		$cntra = 0;
		for ($ea=0; $ea < sizeof($querydata); $ea++) {
			$explodeaccountable = explode('|', $querydata[$ea]['accountable']);
			for ($ap=0; $ap < count($explodeaccountable); $ap++) {
				if($explodeaccountable[$ap] == $this->session->userdata('userid')){
					$cntra++;
					$concnta = (!empty($explodeaccountable[$ap]) AND $cntra != 1) ? ' OR ': '';
					$cona = (!empty($explodeaccountable[$ap]) AND $cntra == 1) ? ' AND ': '';
					$cntwhra .= $cona.$concnta.'cnt = '.$querydata[$ea]['cnt'];
				}
			}
		}

		if($cntra > 0){
			$whereaccountable = $this->db->where('sl.status = "Active"'.$cntwhra);
			$queryselect['chkaccntable'] = $this->Embismodel->selectdata('schedule_list AS sl','COUNT(sl.cnt)','',$whereaccountable);
		}else{
			$queryselect['chkaccntable'] = 0;
		}

    $this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
		$this->load->view('includes/common/footer');
    $this->load->view('Schedule/dashboard',$queryselect);
    $this->load->view('Schedule/modals',$queryselect);
  }

	function nationalcalendar(){
    $data    = array();
    $start   = $this->input->post('start');
    $end     = $this->input->post('end');
    $where   = $this->db->where('sl.region = "national" AND sl.status = "Active" AND (sl.date_schedule BETWEEN "'.$start.'" AND "'.$end.'")');
    $query   = $this->Embismodel->selectdata('schedule_list AS sl','','',$where);

    for ($i=0; $i < sizeof($query); $i++) {
			if(($query[$i]['sched_status'] == 'success') AND $query[$i]['date_schedule'] ==  date('Y-m-d')){
        $color = "#1CC88A";
      }else if(($query[$i]['sched_status'] == 'done') AND $query[$i]['date_schedule'] ==  date('Y-m-d')){
        $color = "#264159";
      }else if(($query[$i]['sched_status'] == 'success' OR $query[$i]['sched_status'] == 'done') AND $query[$i]['date_schedule'] !=  date('Y-m-d')){
        $color = "#264159";
      }else if($query[$i]['sched_status'] == 'postponed'){
        $color = "#E74A3B";
      }else if(($query[$i]['sched_status'] == '') AND $query[$i]['date_schedule'] <  date('Y-m-d')){
        $color = "#E74A3B";
      }else{
				$color = "#3788D8";
			}

      $data[] = array(
       'cnt'         => $this->encrypt->encode($query[$i]["cnt"]),
       'title'       => $query[$i]["subject"],
       'start'       => $query[$i]["date_schedule"],
       'end'         => $query[$i]["date_schedule"],
       'color'       => $color,
      );
    }

    echo json_encode($data);

  }

  function calendar(){
    $data    = array();
    $start   = $this->input->post('start');
    $end     = $this->input->post('end');
    $where   = $this->db->where('(sl.region = "'.$this->session->userdata('region').'" OR sl.region = "national") AND sl.status = "Active" AND (sl.date_schedule BETWEEN "'.$start.'" AND "'.$end.'")');
    $query   = $this->Embismodel->selectdata('schedule_list AS sl','','',$where);

    for ($i=0; $i < sizeof($query); $i++) {
			if(($query[$i]['sched_status'] == 'success') AND $query[$i]['date_schedule'] ==  date('Y-m-d')){
        $color = "#1CC88A";
      }else if(($query[$i]['sched_status'] == 'done') AND $query[$i]['date_schedule'] ==  date('Y-m-d')){
        $color = "#264159";
      }else if(($query[$i]['sched_status'] == 'success' OR $query[$i]['sched_status'] == 'done') AND $query[$i]['date_schedule'] !=  date('Y-m-d')){
        $color = "#264159";
      }else if($query[$i]['sched_status'] == 'postponed'){
        $color = "#E74A3B";
      }else if(($query[$i]['sched_status'] == '') AND $query[$i]['date_schedule'] <  date('Y-m-d')){
        $color = "#E74A3B";
      }else{
				$color = "#3788D8";
			}

      $data[] = array(
       'cnt'     => $this->encrypt->encode($query[$i]["cnt"]),
       'title'   => $query[$i]["subject"],
       'start'   => $query[$i]["date_schedule"],
       'end'     => $query[$i]["date_schedule"],
       'color'   => $color,
      );
    }

    echo json_encode($data);

  }

	function my_schedules(){
    $data        = array();
    $start       = $this->input->post('start');
    $end         = $this->input->post('end');
    $wheredata   = $this->db->where('sl.status = "Active" AND (sl.date_schedule BETWEEN "'.$start.'" AND "'.$end.'")');
    $querydata   = $this->Embismodel->selectdata('schedule_list AS sl','sl.participants, sl.cnt','',$wheredata);

		$cntwhr = '';
		$cntr = 0;
		$con = '';
		for ($e=0; $e < sizeof($querydata); $e++) {
			$explodeparticipants = explode('|', $querydata[$e]['participants']);
			for ($ep=0; $ep < count($explodeparticipants); $ep++) {
				if($explodeparticipants[$ep] == $this->session->userdata('userid')){
					$cntr++;
					$concnt = (!empty($explodeparticipants[$ep]) AND $cntr != 1) ? ' OR ': '';
					$con = (!empty($explodeparticipants[$ep]) AND $cntr == 1) ? ' OR ': '';
					$cntwhr .= $con.$concnt.'cnt = '.$querydata[$e]['cnt'];
				}
			}
		}

		$where = $this->db->where('sl.status = "Active" AND sl.creator = "'.$this->session->userdata('userid').'"'.$cntwhr);
		$query = $this->Embismodel->selectdata('schedule_list AS sl','','',$where);

    for ($i=0; $i < sizeof($query); $i++) {
      $explodeparticipants = explode('|',$query[$i]['participants']);
      for ($p=0; $p < count($explodeparticipants); $p++) {
        if($explodeparticipants[$p] == $this->session->userdata('userid')){
					if(($query[$i]['sched_status'] == 'success') AND $query[$i]['date_schedule'] ==  date('Y-m-d')){
		        $color = "#1CC88A";
		      }else if(($query[$i]['sched_status'] == 'done') AND $query[$i]['date_schedule'] ==  date('Y-m-d')){
		        $color = "#264159";
		      }else if(($query[$i]['sched_status'] == 'success' OR $query[$i]['sched_status'] == 'done') AND $query[$i]['date_schedule'] !=  date('Y-m-d')){
		        $color = "#264159";
		      }else if($query[$i]['sched_status'] == 'postponed'){
		        $color = "#E74A3B";
		      }else if(($query[$i]['sched_status'] == '') AND $query[$i]['date_schedule'] <  date('Y-m-d')){
		        $color = "#E74A3B";
		      }else{
						$color = "#3788D8";
					}
          $data[] = array(
           'cnt'     => $this->encrypt->encode($query[$i]["cnt"]),
           'title'   => $query[$i]["subject"],
           'start'   => $query[$i]["date_schedule"],
           'end'     => $query[$i]["date_schedule"],
           'color'   => $color,
          );
        }
      }
    }

    echo json_encode($data);

  }

}

?>
