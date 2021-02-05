<?php

/**
 *
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class Edit_company extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('Embismodel');
  }

  public function data($company_id = ''){
    // echo $this->input->post('main_region');exit;

    $this->my_data['drafted_comp_data'] = $this->db->select('*')->from('dms_company')->where('company_id',$company_id)->get()->result_array();

    $this->my_data['main_company'] = $this->db->select('company_id,company_name,region_name')->from('dms_company')->where('deleted',0)->where('company_id',$this->my_data['drafted_comp_data'][0]['company_type'])->get()->result_array();
    $main_company_sess = array(
      'main_company_region' => $this->my_data['main_company'][0]['region_name'],
      'main_company_id'     => $this->my_data['main_company'][0]['company_id'],
     );
    $this->session->set_userdata($main_company_sess);
    // echo "<pre>";print_r(  $this->my_data['main_company']);exit;
    $this->my_data['queryproject_type'] = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    '');
    $proid = $this->my_data['drafted_comp_data'][0]['project_type'];
    $this->my_data['category'] = $this->db->query("SELECT * FROM project_category_d AS pd WHERE pd.proid = $proid UNION ALL SELECT * FROM project_category_eis AS pe WHERE pe.proid = $proid UNION ALL SELECT * FROM project_category_iee AS pi WHERE pi.proid = $proid UNION ALL SELECT * FROM dms_project_category_a AS da WHERE da.proid = $proid")->result_array();

    $whererg = array('acrg.rgnnum !=' => 'CO',);
    $this->my_data['region'] = $this->Embismodel->selectdata('acc_region AS acrg',
    'acrg.rgnnum,acrg.rgnnam,acrg.rgnid',$whererg);

    $whereg = array('acrg.rgnnum' => $this->my_data['drafted_comp_data'][0]['region_name'], );
    $regionid = $this->Embismodel->selectdata('acc_region AS acrg',
    'acrg.rgnnum,acrg.rgnnam,acrg.rgnid',$whereg);

    $provorder = $this->db->order_by("dp.name", "asc");
    $wherergnid = array('dp.region_id' => $regionid[0]['rgnid'],);
    $this->my_data['province'] = $this->Embismodel->selectdata('dms_province AS dp','dp.name,dp.psgc,dp.region_id,dp.id',$wherergnid,$provorder);

    $cityorder = $this->db->order_by("dc.name", "asc");
    $wherecityid = array('dc.province_id' => $this->my_data['drafted_comp_data'][0]['province_id'],);
    $this->my_data['city'] = $this->Embismodel->selectdata('dms_city AS dc','dc.name,dc.psgc,dc.province_id,dc.id',$wherecityid,$cityorder);
    // for baranggay
    $brgyorder = $this->db->order_by("db.name", "asc");
    $wherebrgyid = array('db.city_id' => $this->my_data['drafted_comp_data'][0]['city_id'],);
    $this->my_data['baranggay'] = $this->Embismodel->selectdata('dms_barangay AS db','db.id,db.name,db.city_id',$wherebrgyid,$brgyorder);

    // $this->load->view('includes/common/footer');
      $this->_show_view('company/edit_company');
    // if ($this->session->userdata('userid') == 157) {
    //     $this->_show_view('company/edit_company');
    // }else {
    //   $this->_show_view('under_dev');
    // }

  }

  function update_company(){
    $userid = $_SESSION['userid'];
    $region = $_SESSION['region'];
    $data = $this->input->post();

    $wherebrgy = array('brgy.id' => $data['brgyid'], );
    $querybrgyname = $this->Embismodel->selectdata('dms_barangay AS brgy','brgy.name,brgy.id',$wherebrgy);
    $brgyname = $querybrgyname[0]['name'];
    // echo $brgyname;exit;
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
    // if ($region === 'CO') {
    //   $region = $this->input->post('region_id');
    // }else {
    //   ($data['jurisdiction'] == 2)  ? $region = $data['region_id'] : $region = $_SESSION['region'];
    // }
      // $region = $this->input->post('region_id');
    // echo $data['jurisdiction'];
    // echo $region;exit;
    // $whereregion = array('rg.rgnnum' => $region, );
    // $queryrgname = $this->Embismodel->selectdata('acc_region AS rg','rg.rgnnum,rg.rgnid',$whereregion);
    // $rgname = $queryrgname[0]['rgnnum'];

    $wherprojecttype = array('dpt.proid' => $data['project_type'], );
    $queryprojtype = $this->Embismodel->selectdata('dms_project_type AS dpt',
    'dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header',
    $wherprojecttype);
    $project_name = $queryprojtype[0]['prj'];

    $base  = $queryprojtype[0]['base'].$queryprojtype[0]['chap'].$queryprojtype[0]['part'].$queryprojtype[0]['branch'];
    // $prodata = $data['project_type'];
    // $exprodata = explode(",",$prodata);
    // $project_type = $exprodata[0];

  // for Attachment

    if (!empty($data['comp_type'])) {
      $company_type = $data['company_id'];
      $companyname  = $data['compname'];
    }

    if (!empty($data['comp_branch'])) {
      $company_type = $data['main_comp'];
      $companyname  = $data['project_name'];
    }

    // echo $company_type ;exit;
    // $attch_name = $_FILES['compic']['name'];

    $datetoday = date('Y-m-d');
    $datacomp = array(
      'company_id'         => $data['company_id'],
      'company_name'       => strtoupper($companyname),
      'establishment_name' => $data['estnam'],
      'date_established'   => $data['date_estab'],
      'company_type'       => $company_type,
      // 'house_no'           => $data['hsno'],
      'street'             => $data['street'],
      'category'           => $data['category'],
      'barangay_id'        => $data['brgyid'],
      'province_name'      => $provname,
      // 'region_name'        => $rgname,
      'barangay_name'      => $brgyname,
      'city_id'            => $data['cityid'],
      'city_name'          => $ctyname,
      'province_id'        => $data['prov_id'],
      'latitude'           => $data['lat'],
      'longitude'          => $data['long'],
      'project_type'       => $data['project_type'],
      'category'           => $data['category'],
      'status'             => 0, /*0 active /1 inactve*/
      'email'              => $data['comp_email'],
      'contact_no'         => $data['comp_tel'],
      'input_staff'        => $userid,
      'input_date'         => $data['input_date'],
      'psi_code_no'        => $data['psi_code_no'],
      'psi_descriptor'        => $data['psi_descriptor'],
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
    );
    $this->db->where('company_id',$data['company_id']);
    $query  =  $this->db->update('dms_company',$datacomp);
// echo $this->db->last_query();exit;
    if ($query) {
      // echo "string";exit;
      $this->session->set_flashdata('update_messsage',$data['emb_id']);
      if (!is_dir('uploads/permits/'.$data['company_id']))
      mkdir('uploads/permits/'.$data['company_id'], 0777, TRUE);
      // echo $data['company_id'];exit;

      $config['upload_path']   = 'uploads/permits/'.$data['company_id'];
      $config['allowed_types'] = '*';
      $config['max_size']      = '50000'; // max_size in kb

      if (!empty($_FILES['dp_file']['name'])) {
        $filenamedp = $_FILES['dp_file']['name'];
        $newNamedp = "dp_file".".".pathinfo($filenamedp, PATHINFO_EXTENSION);
        $dpfilename = 'uploads/permits/'.$data['company_id'].'/'.$newNamedp;
        (!empty($newNamedp)) ? $this->db->set('dp_attch',$newNamedp) : '';
        $this->db->where('company_id',$data['company_id']);
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
          $pofilename = 'uploads/permits/'.$data['company_id'].'/'.$newNamepo;
          (!empty($newNamepo)) ? $this->db->set('po_attch',$newNamepo) : '';
          $this->db->where('company_id',$data['company_id']);
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
          $eccfilename = 'uploads/permits/'.$data['company_id'].'/'.$newNameecc;
          (!empty($newNameecc)) ? $this->db->set('ecc_attch',$newNameecc) : '';
          $this->db->where('company_id',$data['company_id']);
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

      redirect("Company/Edit_company/data/".$data['company_id']."");
    }else {
    echo "<script>alert('error')</script>";
    }
  }

  function update_main_company(){
    // EMBNCR-1345200-331
    $this->db->set('company_type',$this->input->post('company_type'));
    $this->db->where('company_id',$this->input->post('company_id'));
    $query = $this->db->update('dms_company');
    // echo $this->db->last_query();exit;
    if ($query) {
        $msg = 'success';
    }else {
        $msg = 'error';
    }
    echo $msg;
  }
  public function _show_view($content)
  {
    $this->load->view('includes/common/header', @$this->my_data);
    $this->load->view('includes/common/sidebar', @$this->my_data);
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);
  }
}
