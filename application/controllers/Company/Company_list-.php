<?php

class Company_list extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->model('Attachment');
    $this->Embismodel->selectdatarights();
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('company/company_list');
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

    $this->load->view('company/admin_company_list',$queryindex);
    $this->load->view('modals/Company/company_modals');
      $this->load->view('modals/Company/company_view_ticket');

  }

  function editcompany(){

    $token = $this->input->post('token');
    $provid = $this->input->post('provid');
    $cityid = $this->input->post('cityid');
    $proid = $this->input->post('proid');
    // echo $cityid;exit;
    $region = $_SESSION['region'];
      // function selectdata($table = '' ,$select = '', $where = '' ){
    // echo $token;
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
      // $wherereg = array(
      //   'dc.company_id' => ,
      //  );
      // $wherereg = '`dc`.`company_id` = '.$queryindex['company_data'][0]['company_id'].'';
      $wherereg = '';
    }else {
      $wherereg = "`dc`.`company_id` = '".$queryindex['company_data'][0]['company_id']."' AND `dc`.`region_name` = '".$region."'";
    }
    $queryindex['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
    'dc.company_name,dc.region_name,dc.company_id',$wherereg);
    //echo $this->db->last_query();
    //echo "<pre>";print_r($queryindex['companies']);exit;

    // echo $this->db->last_query();exit;
    $queryindex['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    '');
    // for provincedata

    $region = $queryindex['company_data'][0]['region_name'];
    $wherergn = array('acr.rgnnum' => $region, );

    $queryrgn = $this->Embismodel->selectdata('acc_region AS acr','acr.rgnid,acr.rgnnum,acr.rgnnam',$wherergn);
    $rgnid = $queryrgn[0]['rgnid'];
    $wherergnid = array('dp.region_id' => $rgnid);
    $queryindex['select_province'] = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid);
    // echo $this->db->last_query();exit;
    // for city

    $wherergnid = array('dc.province_id' => $provid,);
    $queryindex['select_city'] = $this->Embismodel->selectdata('dms_city AS dc','dc.name,dc.psgc,dc.province_id,dc.id',$wherergnid);

    // for barranggay
    $wherebrgyid = array('db.city_id' => $cityid,);
    $queryindex['select_brgy'] = $this->Embismodel->selectdata('dms_barangay AS db','db.id,db.name,db.city_id',$wherebrgyid);

    // for category
    $queryindex['category'] = $this->db->query("SELECT * FROM project_category_d AS pd WHERE pd.proid =$proid UNION ALL SELECT * FROM project_category_eis AS pe WHERE pe.proid = $proid UNION ALL SELECT * FROM project_category_iee AS pi WHERE pi.proid = $proid UNION ALL SELECT * FROM dms_project_category_a AS da WHERE da.proid = $proid")->result_array();
    // echo $this->db->last_query();
    // echo "<pre>";print_r($querycategory);exit;
    // echo "<pre>";print_r($queryindex['category']);exit;
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
        // echo "<pre>";print_r($_POST);exit;
      $userid = $_SESSION['userid'];
      // $region = $_SESSION['region'];
      $datetoday = date('Y-m-d');
      $attch_name = $_FILES['compic']['name'];
      // $updatedata = $this->input->post();  // unction updatedata($updatedata,$table,$where){
      // echo "<pre>";
      // print_r($updatedata);
      // exit;
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
        // code...
        // echo "1";
          $company_type = $querytoken[0]['company_id'];
        // $compname     = $updatedata['compname'];
          $compname     = $this->input->post('compname',TRUE);
        // echo $compname;
      }else {
        // echo "2";
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

      $wherephotoid = array('dcphto.company_id' => $queryindex['company_data'][0]['company_id'], );
      $queryindex['comphoto_data'] = $this->Embismodel->selectdata('dms_company_photo AS dcphto','dcphto.photo_name',$wherephotoid);

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
   function  draft_company_list(){
       $this->load->view('includes/common/header');
       $this->load->view('includes/common/sidebar');
       $this->load->view('includes/common/nav');
       $this->load->view('includes/common/footer');
       $this->load->view('company/draft_complist');
       $this->load->view('modals/Company/company_modals');
     }
    function  add_client_as_user_data(){
           // $this->load->view('includes/common/footer');
        $smrdb = $this->load->database('smr',TRUE);
        $userid = $this->encrypt->decode($this->input->post('user_id',TRUE));

        $region = $this->input->post('region',TRUE);
        ($_SESSION['region'] === 'CO' || $_SESSION['userid'] == 1)?$wherereg = "`dc`.`region_name` = 'NCR'":$wherereg = "`dc`.`region_name` = '".$_SESSION['region']."'";

        $queryclient['companies'] = $this->Embismodel->selectdata('dms_company AS dc',
        'dc.company_name,dc.region_name,dc.company_id',$wherereg);

        // echo $this->db->last_query();exit;
        $queryclient['clientdata']=  $smrdb->select('uattch.name,uattch.facility_id')->from('user_attch_id as uattch')->where('uattch.facility_id',$userid)->get()->result_array();
        // echo $userid;
        // print_r($queryclient['clientdata']);exit;
        $queryclient['userid'] = $userid;



         return $this->load->view('modals/Company/client_id_data',$queryclient);
        // echo "</div>";
      }

    // function  select_comp_per_region(){
    //   // $region = $this->input->post('region',TRUE);
    //   ($_SESSION['region'] === 'CO' || $_SESSION['userid'] == 1)?$wherereg = "`dc`.`region_name` = 'NCR'":$wherereg = "`dc`.`region_name` = '".$_SESSION['region']."'";
    //
    //   $companies = $this->Embismodel->selectdata('dms_company AS dc',
    //   'dc.company_name,dc.region_name,dc.company_id',$wherereg);
    //
    //   echo "<select class='form-control' name='company'>";
    //   echo "<option> -- </option>";
    //   foreach ($companies as $key => $compval) {
    //     echo "<option value=".$compval['company_id'].">".$compval['company_name']."</option>";
    //   }
    //   echo "</select>";
    //
    // }
    function  add_client_as_user_per_company(){
        $companyid =  $this->input->post('company',TRUE);
        $smrdb = $this->load->database('smr',TRUE);
        $userid = $this->input->post('userid',TRUE);
        // verified user credentials
        $smrdb->set('verified', 1);
        $smrdb->set('verified_by', $_SESSION['userid']);
        $smrdb->where('user_id', $userid);
        $query = $smrdb->update('users');
        // for inserting as personnel on company
        if (!empty($companyid)) {
          // code...
          $data = $smrdb->select('uc.*')->from('users as uc')->where('uc.user_id',$userid)->get()->result_array();
          $datapersonnnel = array(
            'fname'       => $data[0]['first_name'],
            'mname'       => '',
            'sname'       => $data[0]['last_name'],
            'suffix'      => '',
            'sex'         => '',
            'contact_no'  => $data[0]['contact_no'],
            'email'       => $data[0]['email'],
            'company_id'  => $companyid,
            'client_id'   => $userid,
          );

          $query2  =  $this->Embismodel->insertdata('dms_personnel',$datapersonnnel);
        }

        if ($query || $query2) {
          echo "<script>alert('SUCCESS!, ACCOUNT CREDENTIALS SENT TO ".$data[0]['email']."'); location.href='javascript: history.go(-1)';</script>";

           if (filter_var($data[0]['email'], FILTER_VALIDATE_EMAIL))
           $querysend = $this->send_user_notification($data);
           // echo $query;
        }

      }
    function  send_user_notification($data){
          $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://p3plcpnl0194.prod.phx3.secureserver.net',
            'smtp_port' => 465,
            'smtp_timeout' => 30,
            'smtp_user' => 'smr.online.services@er.emb7-denr.com',
            'smtp_pass' => 'SmrEmb1234@',
            'mailtype' => 'html',
            'wordwrap' => TRUE,
            'charset' => 'utf-8',
          );

        $email_body = "<br>***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***<br><br>";
        $email_body .= "Thank you for registering! <br><br>";
        $email_body .= "Your account has been approved by the system admin. Below is your account credentials:<br><br>";
        $email_body .= "Username:".$data[0]['username']."<br><br>";
        $email_body .= "Password:".$data[0]['raw_password']."<br><br>";

        $this->load->library('email',$config);
        $this->email->from('r7support@emb.gov.ph', 'EMB SUPPORT');
        $this->email->to($data[0]['email']);
        $this->email->cc('');
        $this->email->bcc('');

        $this->email->subject('EMB Online Registration');
        $this->email->message($email_body);

          // $this->email->send();
          if ( ! $this->email->send())
            echo "Email is not sent!!";
            echo $this->email->print_debugger(); die();
    }

}
