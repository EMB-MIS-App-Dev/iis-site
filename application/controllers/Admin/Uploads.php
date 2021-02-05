<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Uploads extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
		$this->Embismodel->selectdatarights();
	}

  function index(){

    $wheredocumentheader = $this->db->where('oh.region = "'.$this->session->userdata('region').'" AND oh.office = "'.$this->session->userdata('office').'" AND oh.cnt = (SELECT max(cnt) FROM office_uploads_document_header AS ou WHERE ou.region = "'.$this->session->userdata('region').'" AND ou.office = "'.$this->session->userdata('office').'")');
    $querydocumentheader = $this->Embismodel->selectdata('office_uploads_document_header AS oh','*','',$wheredocumentheader);
    $passdata['header_name'] = $querydocumentheader[0]['file_name'];

		// Document Footer
		$wheredocumentfooter = $this->db->where('ouf.region = "'.$this->session->userdata('region').'" AND ouf.cnt = (SELECT max(mouf.cnt) FROM office_uploads_document_footer AS mouf WHERE mouf.region = "'.$this->session->userdata('region').'" AND mouf.office = "'.$this->session->userdata('office').'")');
    $querydocumentfooter = $this->Embismodel->selectdata('office_uploads_document_footer AS ouf','*','',$wheredocumentfooter);
    $passdata['footer_name'] = $querydocumentfooter[0]['file_name'];

    $whereactiveemployees         = $this->db->where('acs.verified','1');
    // $whereactiveemployees         = $this->db->where('oue.status',NULL);
    $whereactiveemployees         = $this->db->where('acs.region',$this->session->userdata('region'));
		$whereactiveemployees         = $this->db->where('acs.office',$this->session->userdata('office'));
    $whereactiveemployees         = $this->db->order_by('acs.fname',"asc");
    // $joinactiveemployees          = $this->db->join('office_uploads_esignature AS oue','oue.userid = acs.userid','left');
    $passdata['active_employees'] = $this->Embismodel->selectdata('acc_credentials AS acs','acs.*','',$whereactiveemployees);

		$whereregions                  = $this->db->where('acc_region.rgnnum !=',$this->session->userdata('region'));
		$passdata['regions']            = $this->Embismodel->selectdata('embis.acc_region','*','',$whereregions);

		$whereoffice                      = $this->db->where('acc_office.office_code !=',$this->session->userdata('office'));
		$passdata['office']            = $this->Embismodel->selectdata('embis.acc_office','*','',$whereoffice);
		// echo $this->db->last_query();

    $this->load->view('includes/common/header');
		$this->load->view('includes/common/sidebar');
		$this->load->view('includes/common/nav');
		$this->load->view('includes/common/footer');
		$this->load->view('superadmin/modal_uploads');
		$this->load->view('superadmin/uploads',$passdata);

  }

}
