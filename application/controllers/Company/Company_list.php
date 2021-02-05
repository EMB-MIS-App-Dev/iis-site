<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Company_list extends CI_Controller
{


  function __construct()
  {

    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->model('Attachment');
    $this->load->helper('url');
    $this->Embismodel->selectdatarights();
  }
  function carousel(){
    $attachment_token = $this->input->get('attachment_token');
    $query['company_photo'] = $this->db->select('dcp.*,dcomp.company_name')->from('dms_company_photo as dcp')->join('dms_company as dcomp','dcomp.attachment_token = dcp.attachment_token')->where('dcp.attachment_token',$attachment_token)->get()->result_array();
    $this->load->view('includes/common/carousel',$query);
  }

function for_approval_company_request(){
  $this->load->view('includes/common/header');
  $this->load->view('includes/common/sidebar');
  $this->load->view('includes/common/nav');
  $this->load->view('includes/common/footer');
  $this->load->view('modals/Company/company_modals');
  $this->load->view('company/for_approval_company_request');
  // if ($this->session->userdata('userid') == 157) {
  // }else {
  //     $this->load->view('maintenance');
  // }
}

function disapproved_company_request(){
  $this->load->view('includes/common/header');
  $this->load->view('includes/common/sidebar');
  $this->load->view('includes/common/nav');
  $this->load->view('includes/common/footer');
  $this->load->view('modals/Company/company_modals');
  $this->load->view('company/disapproved_company_request');
}

  function approved_company_request(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $where = array('deleted' => 0, );
    $group = $this->db->group_by("email");
    $queryindex['user_list'] = $this->Embismodel->selectdata('crs.acc',
    'client_id,first_name,last_name,email',$where,$group);
    $this->load->view('company/approved_company_request',$queryindex);
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $where = array('region_id' => $this->session->userdata('region_id'), );
    $queryindex['province_data'] = $this->Embismodel->selectdata('dms_province',
    '',$where);
    $this->load->view('company/company_list',$queryindex);
    $this->load->view('modals/Company/company_modals');
    $this->load->view('modals/Company/company_view_ticket');
  }

  function admin_complist_serverside(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $queryindex['region_data'] = $this->Embismodel->selectdata('acc_region AS acrg',
    'acrg.rgnnum,acrg.rgnnam,acrg.rgnid','');
    if ($this->session->userdata('userid') != 157) {
      $this->load->view('company/admin_company_list',$queryindex);
    }else {
        $this->load->view('company/admin_company_list_test',$queryindex);
    }


    $this->load->view('modals/Company/company_modals');
    $this->load->view('modals/Company/company_view_ticket');

  }


  function view_all_complist_server_side_data(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('company/view_all_companies');
  }
  function editcompany(){

    $token = $this->input->post('token');
    $provid = $this->input->post('provid');
    $cityid = $this->input->post('cityid');
    $proid = $this->input->post('proid');
    $region = $_SESSION['region'];
    $where = array('dcmp.token' => $token);
    $queryindex['company_data'] = $this->Embismodel->selectdata('dms_company AS dcmp',
      'dcmp.emb_id,dcmp.barangay_id,dcmp.province_id,dcmp.city_id,dcmp.company_type,
      dcmp.company_id,dcmp.company_name,dcmp.establishment_name,dcmp.date_established,
      dcmp.house_no,dcmp.street,dcmp.barangay_name,dcmp.city_name,dcmp.province_name,
      dcmp.region_name,dcmp.latitude,dcmp.longitude,dcmp.project_type,dcmp.category,
      dcmp.status,dcmp.email,dcmp.contact_no,dcmp.input_staff,dcmp.input_date,
      dcmp.mailing_add,dcmp.token',$where);

    $wherephotoid = array('dcphto.company_id' => $queryindex['company_data'][0]['company_id'], );
    $queryindex['comphoto_data'] = $this->Embismodel->selectdata('dms_company_photo AS dcphto','dcphto.photo_name',$wherephotoid);
    if ($region === 'CO' || $_SESSION['userid'] == 1) {
      $wherereg = '';
    }else {
      $wherereg = "`dc`.`company_id` = '".$queryindex['company_data'][0]['company_id']."' AND `dc`.`region_name` = '".$region."'";
    }
    $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
    'dc.company_name,dc.region_name,dc.company_id',$wherereg);

    $queryindex['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    '');

    $region = $queryindex['company_data'][0]['region_name'];
    $wherergn = array('acr.rgnnum' => $region, );

    $queryrgn = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnid,acr.rgnnum,acr.rgnnam',$wherergn);
    $rgnid = $queryrgn[0]['rgnid'];
    $wherergnid = array('dp.region_id' => $rgnid);
    $queryindex['select_province'] = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid);

    $wherergnid = array('dc.province_id' => $provid,);
    $queryindex['select_city'] = $this->Embismodel->selectdata('dms_city AS dc','dc.name,dc.psgc,dc.province_id,dc.id',$wherergnid);

    // for barranggay
    $wherebrgyid = array('db.city_id' => $cityid,);
    $queryindex['select_brgy'] = $this->Embismodel->selectdata('dms_barangay AS db','db.id,db.name,db.city_id',$wherebrgyid);

    // for category
    $queryindex['category'] = $this->db->query("SELECT * FROM project_category_d AS pd WHERE pd.proid =$proid UNION ALL SELECT * FROM project_category_eis AS pe WHERE pe.proid = $proid UNION ALL SELECT * FROM project_category_iee AS pi WHERE pi.proid = $proid UNION ALL SELECT * FROM dms_project_category_a AS da WHERE da.proid = $proid")->result_array();
    return $this->load->view('company/edit_company_data',$queryindex);
  }

  function category(){
   $proid = $this->input->post('proid');
   $querycategory = $this->db->query("SELECT * FROM project_category_d AS pd WHERE pd.proid =$proid UNION ALL SELECT * FROM project_category_eis AS pe WHERE pe.proid = $proid UNION ALL SELECT * FROM project_category_iee AS pi WHERE pi.proid = $proid UNION ALL SELECT * FROM dms_project_category_a AS da WHERE da.proid = $proid")->result_array();
   echo json_encode($querycategory);
  }

  function remarks(){
   $proid = $this->input->post('proid');
   $query_remarks = $this->db->query("SELECT * FROM project_type_remarks AS pr WHERE pr.proid =$proid")->result_array();
   echo json_encode($query_remarks);
  }


    function update_company(){
      $userid = $_SESSION['userid'];
      $datetoday = date('Y-m-d');
      $attch_name = $_FILES['compic']['name'];
      $wherebrgy = array('brgy.id' => $this->input->post('brgyid',TRUE), );
      $querybrgyname = $this->Embismodel->selectdata('dms_barangay AS brgy','brgy.name,brgy.id',$wherebrgy);
      $brgyname = $querybrgyname[0]['name'];

      $wherecity = array('cty.id' => $this->input->post('cityid',TRUE), );
      $queryctyname = $this->Embismodel->selectdata('dms_city AS cty','cty.name,cty.id',$wherecity);
      $ctyname = $queryctyname[0]['name'];

      $whereembid = array('dcmp.emb_id' => $this->input->post('emb_id_name',TRUE), );
      $querytoken = $this->Embismodel->selectdata('dms_company AS dcmp','dcmp.token,dcmp.region_name,dcmp.company_id',$whereembid);
      $token = $querytoken[0]['token'];
      $region_name = $querytoken[0]['region_name'];


      $whereprov = array('dp.id' => $this->input->post('prov_id',TRUE), );
      $queryprovname = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.id',$whereprov);
      $provname = $queryprovname[0]['name'];

      $wherprojecttype = array('dpt.proid' => $this->input->post('project_type',TRUE), );
      $queryprojtype = $this->Embismodel->selectdata('dms_project_type AS dpt',
      'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
      $wherprojecttype);
      $project_name = $queryprojtype[0]['prj'];

      $this->db->select_max('cnt');
      $result = $this->db->get('dms_company');
      if ($result->num_rows() > 0)
      {
          $res = $result->result_array();
          $reslt = $res[0]['cnt'];
          $maxsupid = $reslt + 1; //column 1
      }

      if ($this->input->post('comp_type',TRUE) == '1') {
          $company_type = $querytoken[0]['company_id'];
          $compname     = $this->input->post('compname',TRUE);
      }else {
        $company_type = $this->input->post('main_comp',TRUE);
        $compname     = $_POST['project_name'];
      }

        $datacomp = array(
        'company_name'       => $compname,
        'establishment_name' => $this->input->post('estnam',TRUE),
        'date_established'   => $this->input->post('date_estab',TRUE),
        'company_type'       => $company_type,
        'company_id'         => $querytoken[0]['company_id'],
        'house_no'           => $this->input->post('hsno',TRUE),
        'street'             => $this->input->post('street',TRUE),
        'category'           => $this->input->post('category',TRUE),
        'barangay_id'        => $this->input->post('brgyid',TRUE),
        'barangay_name'      => $brgyname,
        'city_id'            => $this->input->post('cityid',TRUE),
        'city_name'          => $ctyname,
        'province_id'        => $this->input->post('prov_id',TRUE),
        'province_name'      => $provname,
        'region_name'        => $region_name,
        'latitude'           => $this->input->post('lat',TRUE),
        'longitude'          => $this->input->post('long',TRUE),
        'project_type'       => $this->input->post('project_type',TRUE),
        'category'           => $this->input->post('category',TRUE),
        'email'              => $this->input->post('comp_email',TRUE),
        'contact_no'         => $this->input->post('comp_tel',TRUE),
        'input_staff'        => $userid,
        'input_date'         => $datetoday,
        'mailing_add'        => $this->input->post('mailadd',TRUE),
        'project_name'       => $project_name,
      );

      $wherecompanyupdata = array(
        'token' => $this->input->post('token',TRUE),
      );

      $queryupdate = $this->Embismodel->updatedata($datacomp,'dms_company',$wherecompanyupdata);
      // START DMS_UNIVERSE UPDATE
      if($queryupdate) {
        $adrs = trim(ucwords($this->input->post('hsno',TRUE).' '.$this->input->post('street',TRUE).' '.strtolower($brgyname.' '.$ctyname.', '.$provname)));
        $univ_vars = array(
          'set' => array(
            'du.company_name' => $compname,
            'du.address'      => $adrs,
            'du.project_type' => $this->input->post('project_type',TRUE),
          ),
          'where' => array( 'du.token' => $this->input->post('token',TRUE)),
          'order' => $this->db->order_by('du.company_name', 'asc'),
        );
        $result = $this->Embismodel->updatedata( $univ_vars['set'], 'dms_universe AS du', $univ_vars['where'], $univ_vars['order'] );
     }
  // END DMS_UNIVERSE UPDATE
      $token     = $this->input->post('token');
      $subfolder = 'company';
      if ($queryupdate) {
        $subfolder = 'company';
        $attach = $this->uploadImage($token,$subfolder,$region_name);
        $this->session->set_flashdata('messsage', 'SUCCESSFULY UPDATED');
        if ($_SESSION['region'] === 'CO') {
            redirect("Company/Company_list/admin_complist_serverside");
        }else {
          redirect("Company/Company_list");
        }
      }else {
        echo "<script>alert('error')</script>";
      }
  }

  function view_company(){
    $token = $this->input->post('token');
    $where = array('dcmp.token' => $token);
    $queryindex['company_data'] = $this->Embismodel->selectdata('dms_company AS dcmp',
      'dcmp.emb_id,dcmp.barangay_id,dcmp.province_id,dcmp.city_id,dcmp.company_type,
      dcmp.company_id,dcmp.company_name,dcmp.establishment_name,dcmp.date_established,
      dcmp.house_no,dcmp.street,dcmp.barangay_name,dcmp.city_name,dcmp.province_name,
      dcmp.region_name,dcmp.latitude,dcmp.longitude,dcmp.project_type,dcmp.category,
      dcmp.status,dcmp.email,dcmp.contact_no,dcmp.input_staff,dcmp.input_date,
      dcmp.mailing_add,dcmp.token,dcmp.project_name',$where);

      $where1 = array('dcmp.company_id' => $queryindex['company_data'][0]['company_type']);
      $queryindex['company_data_main'] = $this->Embismodel->selectdata('dms_company AS dcmp',
        'dcmp.emb_id,dcmp.barangay_id,dcmp.province_id,dcmp.city_id,dcmp.company_type,
        dcmp.company_id,dcmp.company_name,dcmp.establishment_name,dcmp.date_established,
        dcmp.house_no,dcmp.street,dcmp.barangay_name,dcmp.city_name,dcmp.province_name,
        dcmp.region_name,dcmp.latitude,dcmp.longitude,dcmp.project_type,dcmp.category,
        dcmp.status,dcmp.email,dcmp.contact_no,dcmp.input_staff,dcmp.input_date,
        dcmp.mailing_add,dcmp.token,dcmp.project_name',$where1);


  return $this->load->view('company/view_company_data',$queryindex);
  }

  function uploadImage($token,$subfolder,$rgname) {
      if (!is_dir('uploads/'.$subfolder.'/'.$rgname.'/'.$token)) {
        mkdir('uploads/'.$subfolder.'/'.$rgname.'/'.$token, 0777, TRUE);
      }else {
        echo "exist";
      }
      foreach ($_FILES as $key => $v) {
         for (   $i = 0; $i < count($v['name']); $i++ ){
             $_FILES['files']['name']      = $v['name'][$i];
             $_FILES['files']['type']      = $v['type'][$i];
             $_FILES['files']['tmp_name']  = $v['tmp_name'][$i];
             $_FILES['files']['error']     = $v['error'][$i];
             $_FILES['files']['size']      = $v['size'][$i];
             $config['upload_path']   = 'uploads/'.$subfolder.'/'.$rgname.'/'.$token;
             $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
             $config['max_size']      = '50000'; // max_size in kb
             $config['file_name']     =  $v['name'][$i];
             $config['overwrite']     =  FALSE;
             $this->load->library('upload',$config);
             $this->upload->initialize($config);
             if(! $this->upload->do_upload('files')){
                 $error = array('error' => $this->upload->display_errors());
             }else{
               $data = $this->upload->data();
             }
         }
       }
   }

       // deleting establishment client request
    function delete_client_est_request(){
      $reqid = $this->input->post('request_id',TRUE);
      $crsdb = $this->load->database('crs',TRUE);
      $crsdb->where('req_id' , $reqid);
      $crsdb->set('deleted',1);
      $query = $crsdb->update('client_est_requests');
    }
     // for assigning company to a client if existing in emb
    function  emb_assign_existing_comp(){

        $crsdb = $this->load->database('crs',TRUE);
        $req_id =  $this->encrypt->decode($this->input->post('req_id',TRUE));
        $ext_est_id =  $this->encrypt->decode($this->input->post('est_data',TRUE));
        // echo $req_id;echo "<br>";
        // echo $ext_est_id;exit;
        $reqdata = $crsdb->select('cer.client_id,cer.est_id')->from('client_est_requests as cer')->where('req_id',$req_id)->get()->result_array();
        $userdata = $crsdb->select('acc.first_name,acc.last_name,acc.contact_no,acc.email,acc.client_id')->from('acc')->where('acc.client_id',$reqdata[0]['client_id'])->get()->result_array();

        if (!empty($req_id)) {
          $crsdb->where('req_id' , $req_id);
          $crsdb->update('client_est_requests', array(
            'status' => 1,
            'approved_by'   =>  $this->session->userdata('userid'),
            'date_approved' => date('Y-m-d'),
            'deleted'       =>  0,
          ));
        }

          if (!empty($ext_est_id)) {
            $data1 = array(
            'req_id'       => $req_id,
            'approved_by'  => $this->session->userdata('userid'),
            'company_id'   => $ext_est_id,
            'client_id'    => $userdata[0]['client_id'],
            'date_approved' => date('Y-m-d'),
            );
             $query = $this->Embismodel->insertdata('approved_client_req',$data1);
             // for inserting affiliated client to companies
             $client_data = $this->db->select('first_name,last_name,email,client_id')->from('crs.acc')->where('client_id',$userdata[0]['client_id'])->get()->result_array();
             $client_est_requests_data = $this->db->select('date_submitted')->from('crs.client_est_requests')->where('req_id',$req_id)->get()->result_array();
             $company_data = $this->db->select('*')->from('embis.dms_company')->where('company_id',$ext_est_id)->get()->result_array();
             $crsdb->set('client_id', $userdata[0]['client_id']);
             $crsdb->set('company_name', strtoupper($company_data[0]['company_name']));
             $crsdb->set('first_name', $client_data[0]['first_name']);
             $crsdb->set('last_name', $client_data[0]['last_name']);
             $crsdb->set('email', $client_data[0]['email']);
             $crsdb->set('approved_by', $this->session->userdata('username'));
             $crsdb->set('date_approved', date('Y-m-d'));
             $crsdb->set('date_submitted', $client_est_requests_data[0]['date_submitted']);
             $crsdb->set('client_req_id', $req_id);
             $crsdb->set('emb_id', $company_data[0]['emb_id']);
             $crsdb->set('region', $company_data[0]['region_name']);
             $crsdb->set('company_id',$company_data[0]['company_id']);
             $querycrs = $crsdb->insert('client_binded_companies');

             if ($query) {
               // 1 if inputed from client - 2 if inputed from EMB
               if ($this->input->post('company_req_update_option') == 1) {
                $establishment_data = $crsdb->select('*')->from('establishment')->where('cnt',$req_id)->get()->result_array();
                $region = $this->db->select('*')->from('acc_region')->where('rgnid',$establishment_data[0]['est_region'])->get()->result_array();
                $province = $this->db->select('*')->from('dms_province')->where('id',$establishment_data[0]['est_province'])->get()->result_array();
                (!empty($establishment_data[0]['main_company_id']) || $establishment_data[0]['main_company_id'] != '') ? $mainid = $establishment_data[0]['main_company_id']: $mainid = $ext_est_id;
                  if (count($establishment_data) > 0)
                    $this->db->set('req_id',$establishment_data[0]['est_id']);
                    $this->db->set('company_type',$mainid);
                    $this->db->set('company_name',strtoupper($establishment_data[0]['establishment']));
                    $this->db->set('project_type',$establishment_data[0]['project_type']);
                    $this->db->set('contact_no',$establishment_data[0]['comp_tel']);
                    $this->db->set('email',$establishment_data[0]['comp_email']);
                    $this->db->set('street',$establishment_data[0]['est_street']);
                    $this->db->set('region_id',$establishment_data[0]['est_region']);
                    $this->db->set('region_name',$region[0]['rgnnum']);
                    $this->db->set('province_id',$establishment_data[0]['est_province']);
                    $this->db->set('province_name',$province[0]['name']);
                    $this->db->set('city_id',$establishment_data[0]['est_city']);
                    $this->db->set('barangay_id',$establishment_data[0]['est_barangay']);
                    $this->db->set('psi_code_no',$establishment_data[0]['psi_code_no']);
                    $this->db->set('psi_descriptor',$establishment_data[0]['psi_descriptor']);
                    $this->db->set('ceo_fname',$establishment_data[0]['ceo_first_name']);
                    $this->db->set('ceo_sname',$establishment_data[0]['ceo_last_name']);
                    $this->db->set('ceo_contact_num',$establishment_data[0]['ceo_phone_no']);
                    $this->db->set('ceo_fax_no',$establishment_data[0]['ceo_fax_no']);
                    $this->db->set('ceo_mname',$establishment_data[0]['ceo_mi']);
                    $this->db->set('ceo_suffix',$establishment_data[0]['ceo_sufx']);
                    $this->db->set('ceo_email',$establishment_data[0]['ceo_email']);
                    $this->db->set('plant_manager_name',$establishment_data[0]['plant_manager']);
                    $this->db->set('plant_manager_coe',$establishment_data[0]['plant_manager_coa_no']);
                    $this->db->set('plant_manager_email',$establishment_data[0]['plant_manager_email']);
                    $this->db->set('plant_manager_mobile_num',$establishment_data[0]['plant_manager_phone_no']);
                    $this->db->set('plant_manager_fax_num',$establishment_data[0]['plant_manager_fax_no']);
                    $this->db->set('plant_manager_mobile_num',$establishment_data[0]['plant_manager_mobile_no']);
                    $this->db->set('pco',$establishment_data[0]['pollution_officer']);
                    $this->db->set('pco_coe',$establishment_data[0]['pollution_officer_coa_no']);
                    $this->db->set('pco_email',$establishment_data[0]['pollution_officer_email']);
                    $this->db->set('pco_fax_num',$establishment_data[0]['pollution_officer_fax_no']);
                    $this->db->set('pco_mobile_num',$establishment_data[0]['pollution_officer_mobile_no']);
                    $this->db->set('dp_num',$establishment_data[0]['dp_num']);
                    $this->db->set('po_num',$establishment_data[0]['po_num']);
                    $this->db->set('ecc_num',$establishment_data[0]['ecc_num']);
                    $this->db->set('po_attch',$establishment_data[0]['po_attch']);
                    $this->db->set('dp_attch',$establishment_data[0]['dp_attch']);
                    $this->db->set('ecc_attch',$establishment_data[0]['ecc_attch']);
                    $this->db->set('longitude',$establishment_data[0]['longitude']);
                    $this->db->set('latitude',$establishment_data[0]['latitude']);
                    $this->db->set('managing_head',$establishment_data[0]['managing_head']);
                    $this->db->set('managing_head_email',$establishment_data[0]['managing_head_email']);
                    $this->db->set('managing_head_fax_no',$establishment_data[0]['managing_head_fax_no']);
                    $this->db->set('managing_head_mobile_no',$establishment_data[0]['managing_head_mobile_no']);
                    $this->db->set('managing_head_tel_no',$establishment_data[0]['managing_head_tel_no']);
                    $this->db->where('company_id',$ext_est_id);
                    $this->db->update('dms_company');
               }
               $companydata = $this->db->select('dc.*')->from('dms_company as dc')->where('dc.company_id',$ext_est_id)->get()->result_array();
               $date_text = date("F-d-Y", strtotime($companydata[0]['input_date']));
               $this->session->set_flashdata('ext_est_msg', 'added');
               $this->load->config('email');
               $this->load->library('email');
               $from 	 = $this->config->item('smtp_user');
               $to 	  = $userdata[0]['email'];
               $subject = 'Environmental Management Bureau Online Services';
               $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***


   COMPANY REGISTRATION STATUS

   Your  request Establishment

   ".$companydata[0]['company_name']."

   has been approved by the system admin with

   Company Reference ID: ".$companydata[0]['emb_id']."
   Date Approved: ".$date_text."
   Applicant of Company Reference ID: ".$userdata[0]['first_name'].' '.$userdata[0]['last_name']."

   Your company is now active on EMB online systems. You can now process transactions under your company.

   Thank you for registering!";

               $this->email->set_newline("\r\n");
               $this->email->from($from,'EMB SUPPORT');
               $this->email->to($to);
                $this->email->cc('crs.emb.2020@gmail.com');
               $this->email->subject($subject);
               $this->email->message($email_body);
                if (! $this->email->send()) {
                  show_error($this->email->print_debugger());
                } else {
                  echo "<script>alert('Successfully assigned.')</script>";
                  echo "<script>window.location.href='".base_url()."company/for_approval'</script>";
                }
             }
          }

      }
      // for assigning user from existing company requested by client
      function  emb_assign_requested_comp(){
          $crsdb = $this->load->database('crs',TRUE);
          $req_id= $this->input->post('req_id',TRUE);

          $acc_data = $crsdb->select('*')->from('client_est_requests as cer')->where('req_id',$req_id)->where('requested','1')->get()->result_array();
          $companydata = $this->db->select('dcomp.*')->from('dms_company as dcomp')->where('company_id',$acc_data[0]['est_id'])->get()->result_array();
        $user_id = $acc_data[0]['client_id'];
          if (!empty($req_id)) {
            $crsdb->where('req_id' , $req_id);
            $crsdb->update('client_est_requests', array(
              'status' => 1,
              'approved_by'   =>  $this->session->userdata('userid'),
              'date_approved' =>  $datetoday = date('Y-m-d'),
              'deleted'       =>  0,
            ));
          }
          $company_id  = $acc_data[0]['est_id'];
          $system_inquery = $acc_data[0]['system_inquery'];
            $data = $crsdb->select('*')->from('acc')->where('acc.client_id',$user_id)->get()->result_array();
          if (!empty($company_id)) {
            $data1 = array(
            'req_id'         => $req_id,
            'approved_by'    => $this->session->userdata('userid'),
            'company_id'     => $company_id,
            'client_id'      => $user_id,
            'system_inquery' => $system_inquery,
            'date_approved'  =>  $datetoday = date('Y-m-d'),
            );
             $query = $this->Embismodel->insertdata('approved_client_req',$data1);
             $company_data = $this->db->select('*')->from('embis.dms_company')->where('company_id',$company_id)->get()->result_array();
             $crsdb->set('client_id', $data[0]['client_id']);
             $crsdb->set('company_name', strtoupper($company_data[0]['company_name']));
             $crsdb->set('first_name', $data[0]['first_name']);
             $crsdb->set('last_name', $data[0]['last_name']);
             $crsdb->set('email', $data[0]['email']);
             $crsdb->set('approved_by', $this->session->userdata('username'));
             $crsdb->set('date_approved', date('Y-m-d'));
             $crsdb->set('date_submitted', $acc_data[0]['date_submitted']);
             $crsdb->set('client_req_id', $req_id);
             $crsdb->set('emb_id', $company_data[0]['emb_id']);
             $crsdb->set('region', $company_data[0]['region_name']);
             $crsdb->set('company_id',$company_data[0]['company_id']);
             $querycrs = $crsdb->insert('client_binded_companies');

             if ($query){

              $date_text = date("F-d-Y", strtotime($companydata[0]['input_date']));
               $this->load->config('email');
               $this->load->library('email');
               $from 	 = $this->config->item('smtp_user');
               $to 	  = $data[0]['email'];
               $subject = 'Environmental Management Bureau Online Services';
               $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***.


COMPANY REGISTRATION STATUS

Your  requested Establishment

".$companydata[0]['company_name']."

 has been approved by the system admin with

 Company Reference ID: ".$companydata[0]['emb_id']."
 Date Approved: ".$date_text."
 Applicant of Company Reference ID: ".$data[0]['first_name'].' '.$data[0]['last_name']."

Your company is now active on EMB online systems.

You can now process transactions under your company.

Thank you for registering!";

               $this->email->set_newline("\r\n");
               $this->email->from($from,'EMB SUPPORT');
               $this->email->to($to);
               $this->email->cc('crs.emb.2020@gmail.com');
               $this->email->subject($subject);
               $this->email->message($email_body);

               if (! $this->email->send()) {
                 show_error($this->email->print_debugger());
               } else {
                 echo "<script>alert('Successfully assigned.')</script>";
                 echo "<script>window.location.href='".base_url()."company/for_approval'</script>";
               }
             }

          }

        }

        // valid id's per user
        function user_attch_id(){
          $crsdb = $this->load->database('crs',TRUE);
          $userid = $this->input->post('user_id',TRUE);
          $wherephotoid = array('uattch.user_id' => $userid, );
          $query['user_data'] = $crsdb->select('uattch.name,uattch.user_id,acc.*')->from('acc_attch_id AS uattch')
                        ->join('acc', 'uattch.user_id = acc.client_id')->where($wherephotoid)->get()->result_array();
          $query['region_name'] = $this->db->select('*')->from('acc_region')->
          where('rgnid',$query['user_data'][0]['region'])->get()->result_array();
          echo json_encode($query);
        }
        // showing selected company
      function selected_company_data(){
        $query = $this->db->select('dcomp.region_name,dcomp.province_name,dcomp.city_name,dcomp.barangay_name')->from('dms_company as dcomp')->where('company_id',$this->encrypt->decode($this->input->post('company_id')))->where('deleted','0')->get()->result_array();
        echo json_encode($query);
      }

      function export_companies_per_region(){
        // echo "string";exit;
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load(APPPATH."company_list.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
          $where = array(
            'region_name' => $this->session->userdata('region'),'deleted' => 0,
          );
          $querydata = $this->Embismodel->selectdata('dms_company AS dcomp','dcomp.emb_id,dcomp.company_name,dcomp.input_date,dcomp.province_name,dcomp.city_name,dcomp.barangay_name,dcomp.project_name,dcomp.longitude,dcomp.latitude',$where);
          $output = array_slice($querydata, $this->input->post('expo_start',TRUE), $this->input->post('expo_end',TRUE));
          $contentStartRow = 2;
          $currentContentRow = 2;

          for ($i=0; $i < sizeof($output); $i++) {

            $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow+1,1);
            if(!empty($output[$i]['emb_id'])){
              $sheet->setCellValue('A'.$currentContentRow, $output[$i]['emb_id']);
              $sheet->setCellValue('B'.$currentContentRow, $output[$i]['company_name']);
              $sheet->setCellValue('C'.$currentContentRow, $output[$i]['input_date']);
              $sheet->setCellValue('D'.$currentContentRow, $output[$i]['province_name'].','.$output[$i]['city_name'].','.$output[$i]['barangay_name']);
              $sheet->setCellValue('E'.$currentContentRow, $output[$i]['project_name']);
              $sheet->setCellValue('F'.$currentContentRow, $output[$i]['longitude']);
              $sheet->setCellValue('G'.$currentContentRow, $output[$i]['latitude']);
              $currentContentRow++;
            }
          }

          $writer = new Xlsx($spreadsheet); // instantiate Xlsx

          $filename = 'Data'; // set filename for excel file to be exported
          header('Content-Type: application/vnd.ms-excel'); // generate excel file
          header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
          header('Cache-Control: max-age=0');
          $writer->save('php://output');	// download file

      }

      function export_companies_per_project_type(){
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load(APPPATH."export_company_data.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        $where = array('region_name' => $this->session->userdata('region'),'deleted' => 0);
        $this->db->where_in('project_type', ['105','104','131']);
        $this->db->where_in('city_name', ['CITY OF NAGA','MINGLANILLA','CITY OF TALISAY','CEBU CITY (Capital)','LAPU-LAPU CITY (OPON)','MANDAUE CITY','CORDOVA','CONSOLACION','LILOAN','COMPOSTELA','DANAO CITY']);
        $querydata = $this->Embismodel->selectdata('dms_company AS dcomp','dcomp.company_name,dcomp.province_name,dcomp.city_name,dcomp.barangay_name,dcomp.project_name',$where);
        $output = array_slice($querydata, $this->input->post('expo_start',TRUE), $this->input->post('expo_end',TRUE));
        $contentStartRow = 2;
        $currentContentRow = 2;
          for ($i=0; $i < sizeof($output); $i++) {
            $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow+1,1);
            if(!empty($output[$i]['company_name'])){
              $sheet->setCellValue('A'.$currentContentRow, $output[$i]['company_name']);
              $sheet->setCellValue('B'.$currentContentRow, $output[$i]['project_name']);
              $sheet->setCellValue('C'.$currentContentRow, $output[$i]['province_name']);
              $sheet->setCellValue('D'.$currentContentRow, $output[$i]['city_name']);
              $sheet->setCellValue('E'.$currentContentRow, $output[$i]['barangay_name']);
              $currentContentRow++;
            }
          }

          $writer = new Xlsx($spreadsheet); // instantiate Xlsx

          $filename = 'Company_list'; // set filename for excel file to be exported

          header('Content-Type: application/vnd.ms-excel'); // generate excel file
          header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');	// download file

      }


}
