<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_company extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    $this->load->library('session');
    $this->load->helper('url');
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
        if ($_SESSION['region'] == 'CO') {
          $this->form_validation->set_rules('region_id','Region','required');
        }
        if (!empty($this->input->post('comp_type'))) {
          $this->form_validation->set_rules('compname','Company name','required');
        }
        if (!empty($this->input->post('comp_branch'))) {
          $this->form_validation->set_rules('project_name','Project name','required');
          $this->form_validation->set_rules('main_comp','Main Company','required');
        }
        $this->form_validation->set_rules('comp_tel','Company tel. #','required');
        $this->form_validation->set_rules('project_type','Project Type','required');
        $this->form_validation->set_rules('prov_id','Province','required');
        $this->form_validation->set_rules('cityid','City','required');
        $this->form_validation->set_rules('brgyid','Baranggay','required');
        $this->form_validation->set_rules('category','Category','required');

    if($this->form_validation->run() == false){}else{$data = $this->input->post();$this->add_company($data);}

    $region = $_SESSION['region'];
    $wheredeletedcomp = array('deleted' => 0, );
    $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
    'dc.company_id,dc.company_name,dc.province_name,dc.city_name,dc.city_name,dc.barangay_name,dc.emb_id',$wheredeletedcomp);
    $queryindex['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    '');
    $queryindex['region_data'] = $this->Embismodel->selectdata('acc_region AS acrg',
    'acrg.rgnnum,acrg.rgnnam,acrg.rgnid','');

    if ($_SESSION['region'] == 'CO') {
      $region  = $this->input->post('rgnnum');
    }else {
      $region = $_SESSION['region'];
    }
    $wherergn = array('acr.rgnnum' => $region, );
    $queryrgn = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnid,acr.rgnnum,acr.rgnnam',$wherergn);
    $rgnid = $queryrgn[0]['rgnid'];

    $provorder = $this->db->order_by("dp.name", "asc");
    $wherergnid = array('dp.region_id' => $rgnid,);
    $queryindex['provinces'] = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid,$provorder);
    $this->load->view('company/add_company',$queryindex);
  }

  function select_province(){
    if ($_SESSION['region'] == 'CO') {
      $region  = $this->input->post('rgnnum');
    }else {
      $region = $_SESSION['region'];
    }
    $wherergn = array('acr.rgnnum' => $region, );
    $queryrgn = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnid,acr.rgnnum,acr.rgnnam',$wherergn);
    $rgnid = $queryrgn[0]['rgnid'];
    $provorder = $this->db->order_by("dp.name", "asc");
    $wherergnid = array('dp.region_id' => $rgnid,);
    $queryindex = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid,$provorder);
    echo "<select class='form-control' name='prov_id'  onchange=select_province(this.value) >";
    echo "<option>--</option>";
    foreach ($queryindex as $key => $provalue) {
      echo "<option value=".$provalue['id'].">".$provalue['name']."</option>";
    }
    echo "</select>";
}


function select_province_1(){
  $region  = $this->input->post('rgnnum');
  $wherergn = array('acr.rgnnum' => $region, );
  $queryrgn = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnid,acr.rgnnum,acr.rgnnam',$wherergn);
  $rgnid = $queryrgn[0]['rgnid'];

  $provorder = $this->db->order_by("dp.name", "asc");
  $wherergnid = array('dp.region_id' => $rgnid,);
  $queryindex = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid,$provorder);
  echo "<select class='form-control' name='prov_id'  onchange=select_province(this.value) >";
  echo "<option>--</option>";
  foreach ($queryindex as $key => $provalue) {
    echo "<option value=".$provalue['id'].">".$provalue['name']."</option>";
  }
  echo "</select>";
}


function select_city(){
  $provid = $this->input->post('provid');
  $cityorder = $this->db->order_by("dc.name", "asc");
  $wherergnid = array('dc.province_id' => $provid,);
  $queryprov = $this->Embismodel->selectdata('dms_city AS dc','dc.name,dc.psgc,dc.province_id,dc.id',$wherergnid,$cityorder);

  echo "<select class='form-control' name='cityid'  onchange=select_comp_city(this.value)>";
  echo "<option>--</option>";
  foreach ($queryprov as $key => $cityvalue) {
    echo "<option value=".$cityvalue['id'].">".$cityvalue['name']."</option>";
  }
  echo "</select>";
}

function select_barangay(){
  $cityid = $this->input->post('cityid');
  $brgyorder = $this->db->order_by("db.name", "asc");
  $wherebrgyid = array('db.city_id' => $cityid,);
  $querybrgy = $this->Embismodel->selectdata('dms_barangay AS db','db.id,db.name,db.city_id',$wherebrgyid,$brgyorder);

  echo "<select class='form-control' name='brgyid'";
  echo "<option>--</option>";
  foreach ($querybrgy as $key => $brgyvalue) {
    echo "<option value=".$brgyvalue['id'].">".$brgyvalue['name']."</option>";
  }
  echo "</select>";

}
function category(){
   $proid = $this->input->post('proid');
   $querycategory = $this->db->query("SELECT * FROM project_category_d AS pd WHERE pd.proid =$proid UNION ALL SELECT * FROM project_category_eis AS pe WHERE pe.proid = $proid UNION ALL SELECT * FROM project_category_iee AS pi WHERE pi.proid = $proid UNION ALL SELECT * FROM dms_project_category_a AS da WHERE da.proid = $proid")->result_array();
   // echo json_encode($querycategory);
   echo "<select class='form-control' name='category'>";
   echo "<option value='0'>--</option><option value='0'>Not in list</option>";
   foreach ($querycategory as $key => $catvalue) {
     echo "<option value=".$catvalue['proid'].">".$catvalue['pd']."</option>";
   }
   echo "</select>";

}

function remarks(){
 $proid = $this->input->post('proid');
 $query_remarks = $this->db->query("SELECT * FROM project_type_remarks AS pr WHERE pr.proid =$proid")->result_array();
 echo json_encode($query_remarks);
}

function add_company($data){
  $userid = $_SESSION['userid'];
  $region = $_SESSION['region'];
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

  if ($region === 'CO') {
    $region = $this->input->post('region_id');
  }else {
    if ($data['jurisdiction'] == 2) {
      $region = $data['region_id'];
    }else {
      $region = $_SESSION['region'];
    }
  }
  $whereregion = array('rg.rgnnum' => $region, );
  $queryrgname = $this->Embismodel->selectdata('acc_region AS rg','rg.rgnnum,rg.rgnid',$whereregion);
  $rgname = $queryrgname[0]['rgnnum'];

  $wherprojecttype = array('dpt.proid' => $data['project_type'], );
  $queryprojtype = $this->Embismodel->selectdata('dms_project_type AS dpt',
  'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
  $wherprojecttype);
  $project_name = $queryprojtype[0]['prj'];

  $base  = $queryprojtype[0]['base'].$queryprojtype[0]['chap'].$queryprojtype[0]['part'].$queryprojtype[0]['branch'];

// for Attachment
$year = date('y');
$this->db->select_max('cnt');
$result = $this->db->get('dms_company');
if ($result->num_rows() > 0)
{
  $res = $result->result_array();
  $reslt = $res[0]['cnt'];
  $maxsupid = $reslt + 1; //column 1
  $compdata = $data['project_type'].$base;
  // $number = intval('00000') + $maxsupid;
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

  $attchranmame = $token;

  $attachment_token = date('Y').'-'.$this->input->post('attachment_token');
  $datetoday = date('Y-m-d');
  $datacomp = array(
    'company_id'         => $company_id,
    'company_name'       => strtoupper($companyname),
    'establishment_name' => $data['estnam'],
    'date_established'   => $data['date_estab'],
    'emb_id'             => $emb_id,
    'company_type'       => $company_type,
    // 'house_no'           => $data['hsno'],
    'street'             => $data['street'],
    'category'           => $data['category'],
    'barangay_id'        => $data['brgyid'],
    'barangay_name'      => $brgyname,
    'city_id'            => $data['cityid'],
    'city_name'          => $ctyname,
    'province_id'        => $data['prov_id'],
    'province_name'      => $provname,
    'region_name'        => $rgname,
    'latitude'           => $data['lat'],
    'longitude'          => $data['long'],
    'project_type'       => $data['project_type'],
    'category'           => $data['category'],
    'status'             => 0, /*0 active /1 inactve*/
    'email'              => $data['comp_email'],
    'contact_no'         => $data['comp_tel'],
    'input_staff'        => $userid,
    'input_date'         => $datetoday,
    'psi_code_no'        => $data['psi_code_no'],
    'psi_descriptor'     => $data['psi_descriptor'],
    'token'              => $token,
    'attachment_token'   => $attachment_token,
    'project_name'       => $project_name,
    'comp_specification' => 0, /*0 local company /1 international company*/
    'ceo_sname'                 => $data['ceo_sname'],
    'ceo_fname'                 => $data['ceo_fname'],
    'ceo_mname'                 => $data['ceo_mname'],
    'ceo_fax_no'                => $data['ceo_fax_no'],
    'ceo_suffix'                => $data['ceo_suffix'],
    'ceo_contact_num'           => $data['ceo_contact_num'],
    'ceo_email'                 => $data['ceo_email'],
    'plant_manager_name'        => $data['plant_manager_name'],
    'plant_manager_email'       => $data['plant_manager_email'],
    'plant_manager_coe'         => $data['plant_manager_coe'],
    'plant_manager_tel_num'     => $data['plant_manager_tel_num'],
    'plant_manager_fax_num'     => $data['plant_manager_fax_num'],
    'plant_manager_mobile_num'  => $data['plant_manager_mobile_num'],
    'pco'                       => $data['pco'],
    'pco_email'                 => $data['pco_email'],
    'pco_coe'                   => $data['pco_coe'],
    'pco_tel_num'               => $data['pco_tel_num'],
    'pco_fax_num'               => $data['pco_fax_num'],
    'pco_mobile_num'            => $data['pco_mobile_num'],
    'dp_num'                    => $data['dp_num'],
    'po_num'                    => $data['po_num'],
    'ecc_num'                   => $data['ecc_num'],
    'managing_head'             => $data['managing_head'],
    'managing_head_email'       => $data['managing_head_email'],
    'managing_head_tel_no'      => $data['managing_head_tel_no'],
    'managing_head_fax_no'      => $data['managing_head_fax_no'],
    'managing_head_mobile_no'   => $data['managing_head_mobile_no'],
    'add_type'                  => 1, #1 if added in ADD Company module
    'jurisdiction'              => $data['jurisdiction'], #1 if in jurisdisction 2 if not
    'jurisdiction_region'       => $this->session->userdata('region'), #on what region added in outside jurisdiction
  );
  $query  =  $this->Embismodel->insertdata('dms_company',$datacomp);

  if ($query) {
    if (!is_dir('uploads/permits/'.$company_id))
    mkdir('uploads/permits/'.$company_id, 0777, TRUE);
    // echo $company_id;exit;

    $config['upload_path']   = 'uploads/permits/'.$company_id;
    $config['allowed_types'] = '*';
    $config['max_size']      = '50000'; // max_size in kb

    if (!empty($_FILES['dp_file']['name'])) {
      // echo "1";exit;
      $filenamedp = $_FILES['dp_file']['name'];
      $newNamedp = "dp_file".".".pathinfo($filenamedp, PATHINFO_EXTENSION);
      $dpfilename = 'uploads/permits/'.$company_id.'/'.$newNamedp;
      (!empty($newNamedp)) ? $this->db->set('dp_attch',$newNamedp) : '';
      $this->db->where('company_id',$company_id);
      $query = $this->db->update('dms_company');

      (file_exists($dpfilename)) ? unlink($dpfilename) : '';

      if ($query) {
        $config['file_name']      = $newNamedp;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('dp_file')) {
           $error = array('error' => $this->upload->display_errors());
           echo $error;exit;
        }else {
          $this->upload->data("dp_file");
        }
      }

      }

      if (!empty($_FILES['po_file']['name'])) {

        $filenamepo = $_FILES['po_file']['name'];
        $newNamepo = "po_file".".".pathinfo($filenamepo, PATHINFO_EXTENSION);
        $pofilename = 'uploads/permits/'.$company_id.'/'.$newNamepo;
        (!empty($newNamepo)) ? $this->db->set('po_attch',$newNamepo) : '';
        $this->db->where('company_id',$company_id);
        $query = $this->db->update('dms_company');

        (file_exists($pofilename)) ? unlink($pofilename) : '';

        if ($query) {
          $config['file_name']      = $newNamepo;
          $this->load->library('upload',$newNamepo);
          $this->upload->initialize($config);

          if (!$this->upload->do_upload('po_file')) {
             $error = array('error' => $this->upload->display_errors());
              echo $error;exit;
          }else {
            $this->upload->data("po_file");
          }

        }

      }

      if (!empty($_FILES['ecc_file']['name'])) {
        $filenameecc = $_FILES['ecc_file']['name'];
        $newNameecc = "ecc_file".".".pathinfo($filenameecc, PATHINFO_EXTENSION);
        $eccfilename = 'uploads/permits/'.$company_id.'/'.$newNameecc;
        (!empty($newNameecc)) ? $this->db->set('ecc_attch',$newNameecc) : '';
        $this->db->where('company_id',$company_id);
        $query = $this->db->update('dms_company');

        (file_exists($eccfilename)) ? unlink($eccfilename) : '';

        if ($query) {
          $config['file_name']      = $newNameecc;
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if (!$this->upload->do_upload('ecc_file')) {
             $error = array('error' => $this->upload->display_errors());
              echo $error;exit;
          }else {
            $this->upload->data("ecc_file");
          }

        }
      }

       $comp_adrs = trim(ucwords($data['street'].' '.strtolower($brgyname.' '.$ctyname.', '.$provname)));
       $univ_vars = array(
         'company_id'     => $company_id,
         'token'          => $token,
         'company_name'   => $companyname,
         'address'        => $comp_adrs,
         'project_type'   => $data['project_type'],
         'status'         => 0,
       );
       $this->Embismodel->insertdata('dms_universe', $univ_vars);

    $this->session->set_flashdata('messsage', $emb_id);

    // for email sent
    if (!empty($data['comp_email']) || $data['comp_email'] != '') {
      $this->load->config('email');
      $this->load->library('email');
      $from 	= $this->config->item('smtp_user');
      $to 	  = $data['comp_email'];
      $subject    = 'Environmental Management Bureau Online Services';
      $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***.

      We would like inform you that your Establishment (".strtoupper($companyname).") has been ADDED IN ENVIRONMENTAL MANAGEMENT BUREAU ONLINE SYSTEM.
      If you have concerns, email us at r7support@emb.gov.ph";

      $this->email->set_newline("\r\n");
      $this->email->from($from,'EMB SUPPORT');
      $this->email->to($to);
      $this->email->cc(''.$data['comp_email'].','.$data['ceo_email'].','.$data['plant_manager_email'].'');
      $this->email->subject($subject);
      $this->email->message($email_body);

    if (! $this->email->send()) {
      show_error($this->email->print_debugger());
    } else {
        redirect("Company/Add_company");
    }
  }



  }else {
  echo "<script>alert('error')</script>";
  }
}

function fileUpload()
{

  $region = $_SESSION['region'];
  if ($region === 'CO') {
    $region = $this->input->post('region_id');
  }else {
    $region = $_SESSION['region'];
  }

  $whereregion = array('rg.rgnnum' => $region, );
  $queryrgname = $this->Embismodel->selectdata('acc_region AS rg','rg.rgnnum,rg.rgnid',$whereregion);
  $rgname = $queryrgname[0]['rgnnum'];
  $attachment_token = date('Y').'-'.$this->input->post('attachment_token');

  if(!is_dir('uploads/'.'company'.'/'.date('Y').'/'.$rgname.'/'.$attachment_token)) {
    mkdir('uploads/'.'company'.'/'.date('Y').'/'.$rgname.'/'.$attachment_token, 0777, TRUE);
  }

  if(!empty($_FILES['file']['name'] )) {
    // Set preference
    $config = array(
      'upload_path'   => 'uploads/'.'company'.'/'.date('Y').'/'.$rgname.'/'.$attachment_token,
      'allowed_types' => '*',
      'max_size'      => '20480', // max_size in kb
      'file_name'     => $_FILES['file']['name'],
      'overwrite'     => FALSE,
    );
    //Load upload library
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    // File upload
    if(!$this->upload->do_upload('file')) {
      // Show error on uploading
      $uploadError = array('error' => $this->upload->display_errors());
    }
    else {
      // Get data about the file
      $uploadData = $this->upload->data();
      $data = array(
        'attachment_token' => $attachment_token,
        'photo_name' => $_FILES['file']['name'],
        'date_uploaded' => date('Y-m-d H:i:s'),
        'uploaded_by' => $this->session->userdata('userid',TRUE),
        'region' => $this->session->userdata('region',TRUE),
       );
      $query_attch = $this->db->insert('dms_company_photo',$data);
      // for deleting file
      $path = 'uploads/'.'company'.'/'.date('Y').'/'.$rgname.'/'.$attachment_token.'/'.$_FILES['file']['name'];
      echo $path;
    }
  }
}
function removeuploadedfile(){
  $filetobedeleted = $this->input->post('file_to_be_deleted');
  $replaced = str_replace(' ','_',$filetobedeleted);
  $this->load->helper("file");
  unlink($replaced);
}
 // for deleting companies
 function delete_company(){
    $token = $this->input->post('token');
     // function updatedata($data,$table,$where){
     $where = array('dc.token' => $token);
     $data = array('dc.deleted' => 1, );
     $querydelete = $this->Embismodel->updatedata($data,'dms_company as dc',$where);
     // START DMS_UNIVERSE UPDATE (0 - SHOW, 1 = HIDE)
      if($querydelete) {
        $univ_vars = array(
          'set'   => array( 'du.company_name' => $token ),
          'where' => array( 'du.status' => 1 ),
        );
        $result = $this->Embismodel->updatedata( $univ_vars['set'], 'dms_universe AS du', $univ_vars['where'] );
      }
     // END DMS_UNIVERSE UPDATE
 }
  function international_company(){

     $this->load->view('includes/common/header');
     $this->load->view('includes/common/sidebar');
     $this->load->view('includes/common/nav');
     $this->load->view('includes/common/footer');

     $this->load->helper(array('form', 'url'));
     $this->load->library('form_validation');
     if (!empty($this->input->post('comp_type'))) {
       $this->form_validation->set_rules('compname','Company name','required');
     }
     if (!empty($this->input->post('comp_branch'))) {
       $this->form_validation->set_rules('project_name','Project name','required');
       $this->form_validation->set_rules('main_comp','Main Company','required');
     }
    $this->form_validation->set_rules('comp_tel','Company tel. #','required');
    $this->form_validation->set_rules('project_type','Project Type','required');
    $this->form_validation->set_rules('int_comp_address','Company Address','required');
    $this->form_validation->set_rules('category','Category','required');

   if($this->form_validation->run() == false){}else{$data = $this->input->post();$this->add_international_company($data);}
   $queryindex['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
   'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
   '');
          // 'dc.company_name,dc.region_name,dc.company_id','');
   // $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
   //  'dc.*','');
    $wheredeletedcomp = array('deleted' => 0, );
    $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
    'dc.company_id,dc.company_name,dc.province_name,dc.city_name,dc.city_name,dc.barangay_name,dc.emb_id',$wheredeletedcomp);

     $this->load->view('company/add_international_company',$queryindex);
   }
  function add_international_company($data){
    // echo "<pre>";
    // print_r($data);exit;
    $userid = $_SESSION['userid'];
    $region = $_SESSION['region'];

    $wherprojecttype = array('dpt.proid' => $data['project_type'], );
    $queryprojtype = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    $wherprojecttype);
    $project_name = $queryprojtype[0]['prj'];

    $base  = $queryprojtype[0]['base'].$queryprojtype[0]['chap'].$queryprojtype[0]['part'].$queryprojtype[0]['branch'];


    $year = date('y');
    $this->db->select_max('cnt');
    $result = $this->db->get('dms_company');
    if ($result->num_rows() > 0)
    {
      $res = $result->result_array();
      $reslt = $res[0]['cnt'];
      $maxsupid = $reslt + 1; //column 1
      $compdata = $data['project_type'].$base;
      // $number = intval('00000') + $maxsupid;
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

      $attchranmame = $token;

      $datetoday = date('Y-m-d');
      $datacomp = array(
        'emb_id'             => $emb_id,
        'company_id'         => $company_id,
        'company_name'       => $companyname,
        'input_staff'        => $userid,
        'input_date'         => $datetoday,
        'token'              => $token,
        'region_name'        => $_SESSION['region'],
        'project_name'       => $project_name,
        'establishment_name' => $data['estnam'],
        'date_established'   => $data['date_estab'],
        'company_type'       => $company_type,
        'category'           => $data['category'],
        'latitude'           => $data['lat'],
        'longitude'          => $data['long'],
        'project_type'       => $data['project_type'],
        'category'           => $data['category'],
        'email'              => $data['comp_email'],
        'int_comp_address'   => $data['int_comp_address'],
        'contact_no'         => $data['comp_tel'],
        'comp_specification' => 1, /*0 local company /1 international company*/
        'status'             => 0, /*0 active /1 inactve*/
      );

      $query  =  $this->Embismodel->insertdata('dms_company',$datacomp);

      $personneldata = array(
        'company_id'         => $company_id,
        'designation_id'     => 1,
        'fname'         => $data['fname'],
        'mname'         => $data['mname'],
        'sname'         => $data['sname'],
        'suffix'        => $data['suffix'],
        'sex'           => $data['sex'],
        'contact_no'    => $data['pertel'],
        'email'         => $data['per_email'],
       );
     $query2 =  $this->Embismodel->insertdata('dms_personnel',$personneldata);
     // START DMS_UNIVERSE INSERT
     if($query) {
        $comp_adrs = trim(ucwords($data['int_comp_address']));
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
     // $compphotodata = array(
     //   '' => $attch_name, );
     //   $query2 =  $this->Embismodel->insertdata('dms_company_photo',$compphotodata);
      $subfolder = 'company';
     if (!empty($_FILES['compic']['name'])) {
           $fileinsertdata = array();
           foreach ($_FILES['compic']['name'] as $id => $key) {
             $fileinsertdata = array(
               'company_id' => $company_id,
               'photo_name' => $key,
             );
             $query3 = $this->Embismodel->insertdata('dms_company_photo',$fileinsertdata);

           }
             $this->uploadImage($attchranmame,$subfolder,$rgname);
     }
      if ($query && $query2) {

        $this->session->set_flashdata('messsage', $emb_id);
        redirect("Company/Add_company/international_company?data=1");
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

     function add_company_index_sample(){
       $this->load->view('includes/common/header');
       $this->load->view('includes/common/sidebar');
       $this->load->view('includes/common/nav');
       $this->load->view('includes/common/footer');

         $this->load->helper(array('form', 'url'));
         $this->load->library('form_validation');
           if ($_SESSION['region'] == 'CO') {
             $this->form_validation->set_rules('region_id','Region','required');
           }
           if (!empty($this->input->post('comp_type'))) {
             $this->form_validation->set_rules('compname','Company name','required');
           }
           if (!empty($this->input->post('comp_branch'))) {
             $this->form_validation->set_rules('project_name','Project name','required');
             $this->form_validation->set_rules('main_comp','Main Company','required');
           }
           $this->form_validation->set_rules('comp_tel','Company tel. #','required');
           $this->form_validation->set_rules('project_type','Project Type','required');
           $this->form_validation->set_rules('prov_id','Province','required');
           $this->form_validation->set_rules('cityid','City','required');
           $this->form_validation->set_rules('brgyid','Baranggay','required');
           $this->form_validation->set_rules('category','Category','required');

       if($this->form_validation->run() == false){}else{$data = $this->input->post();$this->add_company_1($data);}

       $region = $_SESSION['region'];
       $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
       'dc.*','');
       $queryindex['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
       'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
       '');
       $queryindex['region_data'] = $this->Embismodel->selectdata('acc_region AS acrg',
       'acrg.rgnnum,acrg.rgnnam,acrg.rgnid','');

       if ($_SESSION['region'] == 'CO') {
         $region  = $this->input->post('rgnnum');
       }else {
         $region = $_SESSION['region'];
       }
       $wherergn = array('acr.rgnnum' => $region, );
       $queryrgn = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnid,acr.rgnnum,acr.rgnnam',$wherergn);
       $rgnid = $queryrgn[0]['rgnid'];

       $provorder = $this->db->order_by("dp.name", "asc");
       $wherergnid = array('dp.region_id' => $rgnid,);
       $queryindex['provinces'] = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid,$provorder);
       $this->load->view('company/add_company_sample',$queryindex);
     }

     function add_company_1($data){
       // echo "<pre>";print_r($data);exit;
       // echo "<pre>";print_r($_FILES);exit;
       $userid = $_SESSION['userid'];
       $region = $_SESSION['region'];
       // $data = $this->input->post();

       $wherebrgy = array('brgy.id' => $data['brgyid'], );
       $querybrgyname = $this->Embismodel->selectdata('dms_barangay AS brgy','brgy.name,brgy.id',$wherebrgy);
       $brgyname = $querybrgyname[0]['name'];

       $wherecity = array('cty.id' => $data['cityid'], );
       $queryctyname = $this->Embismodel->selectdata('dms_city AS cty','cty.name,cty.id',$wherecity);
       $ctyname = $queryctyname[0]['name'];


       $whereprov = array('dp.id' => $data['prov_id'], );
       $queryprovname = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.id',$whereprov);
       $provname = $queryprovname[0]['name'];

       // $data['mailadd']
       if (!empty($data['mailadd'])) {
         $mailadd =  $data['mailadd'];
       }else {
         $mailadd = $provname.','. $ctyname.','.$brgyname;
       }
         // echo $mailadd;exit;
       if ($region === 'CO') {
         $region = $this->input->post('region_id');
       }else {
         $region = $_SESSION['region'];
       }
       $whereregion = array('rg.rgnnum' => $region, );
       $queryrgname = $this->Embismodel->selectdata('acc_region AS rg','rg.rgnnum,rg.rgnid',$whereregion);
       $rgname = $queryrgname[0]['rgnnum'];

       $wherprojecttype = array('dpt.proid' => $data['project_type'], );
       $queryprojtype = $this->Embismodel->selectdata('dms_project_type AS dpt',
       'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
       $wherprojecttype);
       $project_name = $queryprojtype[0]['prj'];

       $base  = $queryprojtype[0]['base'].$queryprojtype[0]['chap'].$queryprojtype[0]['part'].$queryprojtype[0]['branch'];

     // for Attachment
     $year = date('y');
     $this->db->select_max('cnt');
     $result = $this->db->get('dms_company');
     if ($result->num_rows() > 0)
     {
       $res = $result->result_array();
       $reslt = $res[0]['cnt'];
       $maxsupid = $reslt + 1; //column 1
       $compdata = $data['project_type'].$base;
       // $number = intval('00000') + $maxsupid;
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

       $attchranmame = $token;

       $attachment_token = date('Y').'-'.$this->input->post('attachment_token');
       $datetoday = date('Y-m-d');
       $datacomp = array(
         'company_id'         => $company_id,
         'company_name'       => strtoupper($companyname),
         'establishment_name' => $data['estnam'],
         'date_established'   => $data['date_estab'],
         'emb_id'             => $emb_id,
         'company_type'       => $company_type,
         // 'house_no'           => $data['hsno'],
         'street'             => $data['street'],
         'category'           => $data['category'],
         'barangay_id'        => $data['brgyid'],
         'barangay_name'      => $brgyname,
         'city_id'            => $data['cityid'],
         'city_name'          => $ctyname,
         'province_id'        => $data['prov_id'],
         'province_name'      => $provname,
         'region_name'        => $rgname,
         'latitude'           => $data['lat'],
         'longitude'          => $data['long'],
         'project_type'       => $data['project_type'],
         'category'           => $data['category'],
         'status'             => 0, /*0 active /1 inactve*/
         'email'              => $data['comp_email'],
         'contact_no'         => $data['comp_tel'],
         'input_staff'        => $userid,
         'input_date'         => $datetoday,
         'psi_code_no'        => $data['psi_code_no'],
         'psi_descriptor'     => $data['psi_descriptor'],
         'token'              => $token,
         'attachment_token'   => $attachment_token,
         'project_name'       => $project_name,
         'comp_specification' => 0, /*0 local company /1 international company*/
         'ceo_sname'                 => $data['ceo_sname'],
         'ceo_fname'                 => $data['ceo_fname'],
         'ceo_mname'                 => $data['ceo_mname'],
         'ceo_fax_no'                => $data['ceo_fax_no'],
         'ceo_suffix'                => $data['ceo_suffix'],
         'ceo_contact_num'           => $data['ceo_contact_num'],
         'ceo_email'                 => $data['ceo_email'],
         'plant_manager_name'        => $data['plant_manager_name'],
         'plant_manager_email'       => $data['plant_manager_email'],
         'plant_manager_coe'         => $data['plant_manager_coe'],
         'plant_manager_tel_num'     => $data['plant_manager_tel_num'],
         'plant_manager_fax_num'     => $data['plant_manager_fax_num'],
         'plant_manager_mobile_num'  => $data['plant_manager_mobile_num'],
         'pco'                       => $data['pco'],
         'pco_email'                 => $data['pco_email'],
         'pco_coe'                   => $data['pco_coe'],
         'pco_tel_num'               => $data['pco_tel_num'],
         'pco_fax_num'               => $data['pco_fax_num'],
         'pco_mobile_num'            => $data['pco_mobile_num'],
         'dp_num'                    => $data['dp_num'],
         'po_num'                    => $data['po_num'],
         'ecc_num'                   => $data['ecc_num'],
         'add_type'                  => 1, #1 if added in ADD Company module
         'jurisdiction'              => $data['jurisdiction'] #1 if in jurisdisction 2 if not

       );
       $query  =  $this->Embismodel->insertdata('dms_company',$datacomp);

       if ($query) {
         if (!is_dir('uploads/permits/'.$company_id))
         mkdir('uploads/permits/'.$company_id, 0777, TRUE);
         // echo $company_id;exit;

         $config['upload_path']   = 'uploads/permits/'.$company_id;
         $config['allowed_types'] = '*';
         $config['max_size']      = '50000'; // max_size in kb

         if (!empty($_FILES['dp_file']['name'])) {
           // echo "1";exit;
           $filenamedp = $_FILES['dp_file']['name'];
           $newNamedp = "dp_file".".".pathinfo($filenamedp, PATHINFO_EXTENSION);
           $dpfilename = 'uploads/permits/'.$company_id.'/'.$newNamedp;
           (!empty($newNamedp)) ? $this->db->set('dp_attch',$newNamedp) : '';
           $this->db->where('company_id',$company_id);
           $query = $this->db->update('dms_company');

           (file_exists($dpfilename)) ? unlink($dpfilename) : '';

           if ($query) {
             $config['file_name']      = $newNamedp;
             $this->load->library('upload',$config);
             $this->upload->initialize($config);

             if (!$this->upload->do_upload('dp_file')) {
                $error = array('error' => $this->upload->display_errors());
                echo $error;exit;
             }else {
               $this->upload->data("dp_file");
             }
           }

           }

           if (!empty($_FILES['po_file']['name'])) {

             $filenamepo = $_FILES['po_file']['name'];
             $newNamepo = "po_file".".".pathinfo($filenamepo, PATHINFO_EXTENSION);
             $pofilename = 'uploads/permits/'.$company_id.'/'.$newNamepo;
             (!empty($newNamepo)) ? $this->db->set('po_attch',$newNamepo) : '';
             $this->db->where('company_id',$company_id);
             $query = $this->db->update('dms_company');

             (file_exists($pofilename)) ? unlink($pofilename) : '';

             if ($query) {
               $config['file_name']      = $newNamepo;
               $this->load->library('upload',$newNamepo);
               $this->upload->initialize($config);

               if (!$this->upload->do_upload('po_file')) {
                  $error = array('error' => $this->upload->display_errors());
                   echo $error;exit;
               }else {
                 $this->upload->data("po_file");
               }

             }

           }

           if (!empty($_FILES['ecc_file']['name'])) {
             $filenameecc = $_FILES['ecc_file']['name'];
             $newNameecc = "ecc_file".".".pathinfo($filenameecc, PATHINFO_EXTENSION);
             $eccfilename = 'uploads/permits/'.$company_id.'/'.$newNameecc;
             (!empty($newNameecc)) ? $this->db->set('ecc_attch',$newNameecc) : '';
             $this->db->where('company_id',$company_id);
             $query = $this->db->update('dms_company');

             (file_exists($eccfilename)) ? unlink($eccfilename) : '';

             if ($query) {
               $config['file_name']      = $newNameecc;
               $this->load->library('upload',$config);
               $this->upload->initialize($config);

               if (!$this->upload->do_upload('ecc_file')) {
                  $error = array('error' => $this->upload->display_errors());
                   echo $error;exit;
               }else {
                 $this->upload->data("ecc_file");
               }

             }
           }




            $comp_adrs = trim(ucwords($data['street'].' '.strtolower($brgyname.' '.$ctyname.', '.$provname)));
            $univ_vars = array(
              'company_id'     => $company_id,
              'token'          => $token,
              'company_name'   => $companyname,
              'address'        => $comp_adrs,
              'project_type'   => $data['project_type'],
              'status'         => 0,
            );
            $this->Embismodel->insertdata('dms_universe', $univ_vars);

         $this->session->set_flashdata('messsage', $emb_id);
         // redirect("Company/Add_company");




         // for email sent
         if (!empty($data['comp_email']) || $data['comp_email'] != '') {
           $this->load->config('email');
           $this->load->library('email');
           $from 	= $this->config->item('smtp_user');
           $to 	  = $data['comp_email'];
           $subject    = 'Environmental Management Bureau Online Services';
           $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***.

           We would like inform you that your Establishment (".strtoupper($companyname).") has been registered IN ENVIRONMENTAL MANAGEMENT BUREAU ONLINE SERVICES.
           If you have concerns, email us at r7support@emb.gov.ph";

           $this->email->set_newline("\r\n");
           $this->email->from($from,'EMB SUPPORT');
           $this->email->to($to);
           $this->email->cc(''.$data['comp_email'].','.$data['ceo_email'].','.$data['plant_manager_email'].'');
           $this->email->subject($subject);
           $this->email->message($email_body);

         if (! $this->email->send()) {
           show_error($this->email->print_debugger());
         } else {
             redirect("Company/Add_company");
         }
       }

       }else {
       echo "<script>alert('error')</script>";
       }
     }
     // for adding main company
     function add_main_company(){

       $query = $this->db->select('company_id,company_name,emb_id')->from('dms_company')->where('company_id',$this->input->post('main_company_id',TRUE))->get()->result_array();
       if ($query) {
           echo json_encode($query);exit;
       }else {
          echo "<script>alert('something's wrong , Please contact administrator - r7support@emb.gov.ph')</script>";
       }
     }
}
