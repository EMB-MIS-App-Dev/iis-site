<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_drafted_company extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('encrypt');
    $this->load->helper('url');
    $this->load->helper('security');
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
  }

  function index(){
    $fcid = $this->input->get('fcid',TRUE);
    $queryindex['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    '');
    $this->load->view('company/add_drafted_company',$queryindex);
  }

  function drafted_company_data(){

    $crsdb = $this->load->database('crs',TRUE);
    $query['dec_fc_data']= $crsdb->select('cer.*')->from('client_est_requests as cer')->where('req_id',$this->input->get('req_id',TRUE))->get()->result_array();

    if (count($query['dec_fc_data']) > 0) {
     $query['drafted_comp_data'] = $crsdb->select('*')
                    ->from('establishment as est')
                    ->where('est.cnt',$this->input->get('req_id',TRUE))
                    ->get()->result_array();

    $query['main_company_data'] = $this->db->select('company_name,company_id')
                   ->from('dms_company as dcomp')
                   ->where('dcomp.company_id',$query['drafted_comp_data'][0]['main_company_id'])
                   ->get()->result_array();

      $user_id = $query['dec_fc_data'][0]['client_id'];
      $query['users_data'] = $crsdb->select('*')
                    ->from('acc')
                    ->where('acc.client_id',$user_id)
                    ->where('acc.deleted',0)
                    ->get()->result_array();

      $query['users_attch_data'] = $crsdb->select('*')
                  ->from('acc_attch_id as uattch')
                  ->where('uattch.user_id',$user_id)
                  ->get()->result_array();

       // for project_type
       $query['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
       'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header','');

       // for category
       $proid = $query['drafted_comp_data'][0]['project_type'];
       $query['category'] = $this->db->query("SELECT * FROM project_category_d AS pd WHERE pd.proid = $proid UNION ALL SELECT * FROM project_category_eis AS pe WHERE pe.proid = $proid UNION ALL SELECT * FROM project_category_iee AS pi WHERE pi.proid = $proid UNION ALL SELECT * FROM dms_project_category_a AS da WHERE da.proid = $proid")->result_array();
       // for region

       $query['region'] = $this->Embismodel->selectdata('acc_region AS acrg',
       'acrg.rgnnum,acrg.rgnnam,acrg.rgnid','');

       // echo $rgnid;exit;
       $provorder = $this->db->order_by("dp.name", "asc");
       $wherergnid = array('dp.region_id' => $query['drafted_comp_data'][0]['est_region'],);
       $query['province'] = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid,$provorder);

       // for selecting city
       $cityorder = $this->db->order_by("dc.name", "asc");
       $wherecityid = array('dc.province_id' => $query['drafted_comp_data'][0]['est_province'],);
       $query['city'] = $this->Embismodel->selectdata('dms_city AS dc','dc.name,dc.psgc,dc.province_id,dc.id',$wherecityid,$cityorder);

       // for Barangay

       $brgyorder = $this->db->order_by("db.name", "asc");
       $wherebrgyid = array('db.city_id' => $query['drafted_comp_data'][0]['est_city'],);
       $query['baranggay'] = $this->Embismodel->selectdata('dms_barangay AS db','db.id,db.name,db.city_id',$wherebrgyid,$brgyorder);

       if ($_SESSION['region'] == 'CO' || $_SESSION['userid'] == '1') {
         $region  = 'NCR';
       }else {
         $region = $_SESSION['region'];
       }

       $wherecomp_per_reg = array('dcomp.deleted' => 0,'dcomp.region_name' => $region);
       $query['companies_per_reg'] = $this->Embismodel->selectdata('dms_company AS dcomp',
       '*',$wherecomp_per_reg);


    }else {
      echo "Opps, Something went wrong !";exit;
    }

    $this->load->view('company/drafted_company_data',$query);
    $this->load->view('modals/Company/company_modals');
  }


  function add_drafted_company(){
      $crsdb  = $this->load->database('crs',TRUE);
    $data = $this->input->post();
    $req_id = $this->encrypt->decode($data['req_id']);
    $client_id= $this->encrypt->decode($data['client_id']);
    $userid = $_SESSION['userid'];

    $wherebrgy = array('brgy.id' => $data['brgyid'], );
    $querybrgyname = $this->Embismodel->selectdata('dms_barangay AS brgy','brgy.name,brgy.id',$wherebrgy);
    $brgyname = $querybrgyname[0]['name'];

    $wherecity = array('cty.id' => $data['cityid'], );
    $queryctyname = $this->Embismodel->selectdata('dms_city AS cty','cty.name,cty.id',$wherecity);
    $ctyname = $queryctyname[0]['name'];


    $whereprov = array('dp.id' => $data['prov_id'], );
    $queryprovname = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.id',$whereprov);
    $provname = $queryprovname[0]['name'];

    if (!empty($data['mailadd'])) {
      $mailadd =  $data['mailadd'];
    }else {
      $mailadd = $provname.','. $ctyname.','.$brgyname;
    }

    if ($data['project_type'] == 0) {
        $project_name = 'UNCLASSIFIED';
    }else {
      $wherprojecttype = array('dpt.proid' => $data['project_type'], );
      $queryprojtype = $this->Embismodel->selectdata('dms_project_type AS dpt',
      'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
      $wherprojecttype);
      $project_name = $queryprojtype[0]['prj'];
    }

    $base  = $queryprojtype[0]['base'].$queryprojtype[0]['chap'].$queryprojtype[0]['part'].$queryprojtype[0]['branch'];

  // for Attachment
  $region = $data['region_id'];
  $year = date('y');
  $this->db->select_max('cnt');
  $result = $this->db->get('dms_company');
  if ($result->num_rows() > 0)
  {
    $res = $result->result_array();
    $reslt = $res[0]['cnt'];
    $maxsupid = $reslt + 1; //column 1
    $compdata = $data['project_type'].$base;
    $number = intval('00000') + $maxsupid;
    $sprinted = sprintf('%02d', $number);
    $emb_id = 'EMB'.$region.'-'.$compdata.'-'.$sprinted;
    $token = $region.$compdata.$maxsupid;
  }

    if (!empty($data['comp_type'])) {
      $company_id   = $maxsupid;
      $company_type = $maxsupid;
      $companyname  = $data['compname'];
    }
    if (!empty($data['comp_branch'])) {
      $company_id   = $maxsupid;
      $company_type = $data['main_comp'];
      $companyname  = $data['project_name'];
    }

    if (empty($data['category']) || $data['category'] == '') {
      $draf_catgory = 0;
    }else {
      $draf_catgory = $data['category'] ;
    }
    $attchranmame = $token;
    $datetoday = date('Y-m-d');
    $datacomp = array(
      'company_id'         => $maxsupid,
      // 'company_id'         => $company_id,
      'company_name'       => strtoupper($companyname),
      'establishment_name' => $data['estnam'],
      'date_established'   => $data['date_estab'],
      'emb_id'             => $emb_id,
      'company_type'       => $company_type,
      'house_no'           => $data['hsno'],
      'street'             => $data['street'],
      'category'           => $data['category'],
      'barangay_id'        => $data['brgyid'],
      'barangay_name'      => $brgyname,
      'city_id'            => $data['cityid'],
      'city_name'          => $ctyname,
      'province_id'        => $data['prov_id'],
      'province_name'      => $provname,
      'region_name'        => $data['region_id'],
      'latitude'           => $data['latitude'],
      'longitude'          => $data['longitude'],
      'project_type'       => $data['project_type'],
      'category'           => $draf_catgory,
      'status'             => 0, /*0 active /1 inactve*/
      'email'              => $data['comp_email'],
      'contact_no'         => $data['comp_tel'],
      'input_staff'        => $userid,
      'input_date'         => date('Y-m-d'),
      // 'comp_photo'         => $attch_name,
      // 'mailing_add'        => $mailadd,
      'token'              => $token,
      'project_name'       => $project_name,
      'psi_code_no'        => $data['psi_code_no'],
      'psi_descriptor'     => $data['psi_descriptor'],

      'ceo_sname'                 => $data['ceo_last_name'],
      'ceo_fname'                 => $data['ceo_first_name'],
      'ceo_mname'                 => $data['ceo_mi'],
      'ceo_contact_num'           => $data['ceo_phone_no'],
      'ceo_fax_no'                => $data['ceo_fax_no'],
      'ceo_email'                 => $data['ceo_email'],
      'plant_manager_name'        => $data['plant_manager_name'],
      'plant_manager_email'       => $data['plant_manager_email'],
      'plant_manager_coe'         => $data['plant_manager_coe'],
      'plant_manager_tel_num'     => $data['plant_manager_tel_num'],
      'plant_manager_fax_num'     => $data['plant_manager_fax_num'],
      'plant_manager_mobile_num'  => $data['plant_manager_mobile_num'],
      'pco'                       => $data['pollution_officer'],
      'pco_email'                 => $data['pco_email'],
      'pco_coe'                   => $data['pollution_officer_coa_no'],
      'pco_tel_num'               => $data['pollution_officer_phone_no'],
      'pco_fax_num'               => $data['pollution_officer_fax_no'],
      'pco_mobile_num'            => $data['pollution_officer_mobile_no'],


      'managing_head'             => $data['managing_head'],
      'managing_head_email'       => $data['managing_head_email'],
      'managing_head_fax_no'      => $data['managing_head_fax_no'],
      'managing_head_mobile_no'   => $data['managing_head_mobile_no'],
      'managing_head_tel_no'      => $data['managing_head_tel_no'],


      'dp_num'                    => $data['dp_num'],
      'po_num'                    => $data['po_num'],
      'ecc_num'                   => $data['ecc_num'],
      'dp_attch'                    => $data['dp_attch'],
      'po_attch'                    => $data['po_attch'],
      'ecc_attch'                   => $data['ecc_attch'],
      'add_type'                    => 2, #2 if added in from Client company request
      'req_id'                      => $req_id, #2 if added in from Client company request
    );

    $query  =  $this->Embismodel->insertdata('dms_company',$datacomp);

    if ($query) {
     $data1 = array(
     'req_id'       => $req_id,
     'approved_by'  => $this->session->userdata('userid'),
     'company_id'   => $company_id,
     'client_id'    => $client_id,
     'date_approved' =>  $datetoday = date('Y-m-d'),
     'system_inquery' =>  $data['system_inquery'],
     );
      $query = $this->Embismodel->insertdata('approved_client_req',$data1);

      $client_data = $this->db->select('first_name,last_name,email,client_id')->from('crs.acc')->where('client_id',$client_id)->get()->result_array();
      $client_est_requests_data = $this->db->select('date_submitted')->from('crs.client_est_requests')->where('req_id',$req_id)->get()->result_array();
      $this->db->set('client_id', $client_id);
      $this->db->set('company_name', strtoupper($companyname));
      $this->db->set('first_name', $client_data[0]['first_name']);
      $this->db->set('last_name', $client_data[0]['last_name']);
      $this->db->set('email', $client_data[0]['email']);
      $this->db->set('approved_by', $this->session->userdata('username'));
      $this->db->set('date_approved', date('Y-m-d'));
      $this->db->set('date_submitted', $client_est_requests_data[0]['date_submitted']);
      $this->db->set('client_req_id', $req_id);
      $this->db->set('emb_id', $emb_id);
      $this->db->set('region', $data['region_id']);
      $this->db->set('company_id',$company_id);
      $querycrs = $this->db->insert('crs.client_binded_companies');

     if ($query2) {
       $crsdb  = $this->load->database('crs',TRUE);
       $facilitydata = array(
          'status' => 1,
          'approved_by'   =>  $this->session->userdata('userid'),
          'date_approved' =>  $datetoday = date('Y-m-d'),
          'deleted'       =>  0,
        );
       $query3 = $crsdb->where('req_id',$req_id)->update('client_est_requests',$facilitydata);
     }
     // START DMS_UNIVERSE INSERT
     $comp_adrs = trim(ucwords($data['hsno'].' '.$data['street'].' '.strtolower($brgyname.' '.$ctyname.', '.$provname)));
     $cntunivcomp = $this->db->select('company_id')->from('dms_universe')->where('company_id',$company_id)->get()->num_rows();
     if ($cntunivcomp == 0)
       $univ_vars = array(
         'company_id'     => $company_id,
         'token'          => $token,
         'company_name'   => $companyname,
         'address'        => $comp_adrs,
         'project_type'   => $data['project_type'],
         'status'         => 0,
       );
       $this->Embismodel->insertdata('dms_universe', $univ_vars);
    }

    // END DMS_UNIVERSE INSERT

    $subfolder = 'company';
   if (!empty($_FILES['compic']['name'])) {
         $fileinsertdata = array();
         foreach ($_FILES['compic']['name'] as $id => $key) {
           $fileinsertdata = array(
             'photo_name' => $key,
           );
           $query3 = $this->Embismodel->insertdata('dms_company_photo',$fileinsertdata);

         }
           $this->uploadImage($attchranmame,$subfolder,$rgname);
   }

    if ($query) {
       $date_text = date("F-d-Y", strtotime(date('Y-m-d')));

      $req_id = $this->encrypt->decode($data['req_id']);
      $facilitydata = array(
               'status' => 1,
       );
      $query3 = $crsdb->where('req_id',$req_id)->update('client_est_requests',$facilitydata);
      $query4 = $crsdb->select('*')->from('acc')->where('client_id',$client_id)->get()->result_array();

      $this->load->config('email');
      $this->load->library('email');
      $from 	 = $this->config->item('smtp_user');
      $to 	   = $data['clientemail'];

      $subject = 'Environmental Management Bureau Online Services';
      $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***

COMPANY REGISTRATION STATUS!.  Your requested Establishment
".$companyname."
has been approved by the system admin with

Company Reference ID: ".$emb_id."
Date Approved: ".$date_text."
Applicant of Company Reference ID: ".$query4[0]['first_name'].' '.$query4[0]['last_name']."

Your company is now active on EMB online systems.
You can now process transactions under your company.
Thank you for registering!
";

      $this->email->set_newline("\r\n");
      $this->email->from($from,'EMB SUPPORT');
       $this->email->cc('crs.emb.2020@gmail.com');
      $this->email->to($to);
      $this->email->subject($subject);
      $this->email->message($email_body);

      if (! $this->email->send()) {
        show_error($this->email->print_debugger());
      } else {
        $this->session->set_flashdata('messsage', $emb_id);
        redirect("company/for_approval");
      }
    }else {
      echo "<script>alert('error')</script>";
    }
  }

  function uploadImage($attchranmame,$subfolder,$rgname) {
      if (!is_dir('uploads/'.$subfolder.'/'.$rgname.'/'.$attchranmame)) {
        mkdir('uploads/'.$subfolder.'/'.$rgname.'/'.$attchranmame, 0777, TRUE);
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
             $config['upload_path']   = 'uploads/'.$subfolder.'/'.$rgname.'/'.$attchranmame;
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

}
