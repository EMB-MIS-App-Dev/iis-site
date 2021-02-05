<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Emb_support extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->model('Attachment');
    $this->load->library('session');
    $this->load->helper('url');
  }
  public function _show_view($content)
  {
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);

      $this->load->view('includes/common/footer');
  }

  public function index(){
    $where = array('sp_cat.region' => $this->session->userdata('region'), 'sp_cat.deleted ' => 0);
    $this->my_data['sp_category_list'] = 	$this->Embismodel->selectdata('sp_main_category AS sp_cat','sp_cat.*',$where,'');

    $where2 = array('smch.region' => $this->session->userdata('region'), );
    $this->my_data['sp_category_list_hardware'] = 	$this->Embismodel->selectdata('sp_main_category_hardware AS smch','smch.*',$where2,'');
    $sp_ticket_no = $this->encrypt->decode($_GET['sp_ticket_no']);
    // echo $sp_ticket_no;
    if (!empty($sp_ticket_no)) {
      $this->session->set_userdata('sp_ticket_no',$sp_ticket_no);
    }else {
      unset($_SESSION['sp_ticket_no']);
    }
    if ($this->session->userdata('support_admin') == 'yes') {
      // echo "1";
        $whereop = array('status' => 0,'region' =>  $this->session->userdata('region'),'deleted' =>  0);
        $this->my_data['open'] = $this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($whereop)->get()->num_rows();

        $wherepr = array('status' => 1,'region' =>  $this->session->userdata('region'),'deleted' =>  0);
        $this->my_data['processing'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($wherepr)->get()->num_rows();

        $whereat = array('status' => 2,'region' =>  $this->session->userdata('region'),'deleted' =>  0);
        $this->my_data['attended'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($whereat)->get()->num_rows();

        $wheresv = array('status' => 3,'region' =>  $this->session->userdata('region'),'deleted' =>  0);
        $this->my_data['solved'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($wheresv)->get()->num_rows();

        $wheresv = array('status' => 4,'region' =>  $this->session->userdata('region'),'deleted' =>  0);
        $this->my_data['pending'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($wheresv)->get()->num_rows();


        $this->my_data['total'] = $this->my_data['open']+$this->my_data['processing']+$this->my_data['attended']+$this->my_data['solved']+$this->my_data['pending'];
        $this->_show_view('support/emb/admin/view_tickets');

    }else {
      // echo "2";
      $whereop = array('status' => 0,'region' =>  $this->session->userdata('region'),'deleted' =>  0,'staff' =>  $this->session->userdata('userid'),);
      $this->my_data['open'] = $this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($whereop)->get()->num_rows();

      $wherepr = array('status' => 1,'region' =>  $this->session->userdata('region'),'deleted' =>  0,'staff' =>  $this->session->userdata('userid'),);
      $this->my_data['processing'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($wherepr)->get()->num_rows();

      $whereat = array('status' => 2,'region' =>  $this->session->userdata('region'),'deleted' =>  0,'staff' =>  $this->session->userdata('userid'),);
      $this->my_data['attended'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($whereat)->get()->num_rows();

      $wheresv = array('status' => 3,'region' =>  $this->session->userdata('region'),'deleted' =>  0,'staff' =>  $this->session->userdata('userid'),);
      $this->my_data['solved'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($wheresv)->get()->num_rows();

      $wheresv = array('status' => 4,'region' =>  $this->session->userdata('region'),'deleted' =>  0,'staff' =>  $this->session->userdata('userid'),);
      $this->my_data['pending'] = 	$this->db->select('*')->from('sp_ticket_assisstance AS sta')->where($wheresv)->get()->num_rows();

      $this->my_data['total'] = $this->my_data['open']+$this->my_data['processing']+$this->my_data['attended']+$this->my_data['solved']+$this->my_data['pending'];

      $regions = array('region',$this->session->userdata('region'));
      $this->my_data['divisions'] = $this->db->select('*')->from('acc_xdvsion')->where_in('type',$regions)->where('office','EMB')->get()->result_array();

      $this->my_data['sections'] = $this->db->select('*')->from('acc_xsect')->where('divno',$this->session->userdata('divno'))->get()->result_array();

      $this->_show_view('support/emb/user/dashboard');
    }
  }
function select_main_cat_name($id = ''){
  $where = array('sp_cat.cno' => $id, );
  $query = $this->Embismodel->selectdata('sp_main_category AS sp_cat','sp_cat.*',$where,'');
  return $query;
}
function select_sub_cat_name($id = ''){
  $where = array('ssc.csno' => $id, );
  $query = $this->Embismodel->selectdata('sp_sub_category AS ssc','ssc.*',$where,'');
  return $query;
}
function select_embis_user($id = ''){
  $where = array('acc.userid' => $id, );
  $query = $this->Embismodel->selectdata('acc_credentials AS acc','acc.*',$where,'');
  return $query;
}
  // for adding new ticket assistance
  public function add_new_ticket_assistance(){
    $main_name = $this->select_main_cat_name($this->input->post('sp_category_assistance',TRUE));
    $sub_cat_name = $this->select_sub_cat_name($this->input->post('sp_category_specification',TRUE));
    $staff_data = $this->select_embis_user($this->session->userdata('userid'));
    // echo "<pre>";print_r($staff_data);exit;
    $this->db->select_max('ticket_ass_id');
    $res1 = $this->db->get('sp_ticket_assisstance')->result_array();
    $maxid = $res1[0]['ticket_ass_id'] + 1;
    $ticket_no = $this->session->userdata('region').'-'.date("Y").'-'.$maxid;
    $this->db->set('staff',$this->session->userdata('userid'));
    $this->db->set('region', $this->session->userdata('region'));
    $this->db->set('ticket_date',date('Y-m-d'));
    $this->db->set('remarks',$this->input->post('remarks',TRUE));
    $this->db->set('sp_category',$this->input->post('sp_category_assistance',TRUE));
    $this->db->set('sp_category_specification',$this->input->post('sp_category_specification',TRUE));
    $this->db->set('ticket_no',$ticket_no );
    $this->db->set('ctype',$main_name[0]['ctype'] );
    $this->db->set('csdsc',$sub_cat_name[0]['csdsc'] );
    $this->db->set('fname',$staff_data[0]['fname'] );
    $this->db->set('sname',$staff_data[0]['sname'] );
    $query = $this->db->insert('sp_ticket_assisstance');
    $supp_ticket_id = $this->db->insert_id();
    if ($query) {
      $data_fwrd = $this->input->post();
      $this->submit_forward_to_sec_regional($data_fwrd,$supp_ticket_id);
      // if (!empty($_FILES['support_attach']['name'][0])) {
        $title = 'sp';
        $path = 'uploads/support/assistance/'.$supp_ticket_id;
        if ($this->upload_files($title,$path, $_FILES['support_attach']) === FALSE) {
          $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
        }else {
          foreach ($_FILES['support_attach']['name'] as $key => $file) {
            $file_new = str_replace(" ","_",$file);
              $fileinsertdata = array(
                'ticket_no_id'  => $supp_ticket_id,
                'name'     => $title.$key.'-'.$file_new,
              );
              $query3 = $this->db->insert('sp_attach_assistance', $fileinsertdata);
          }
        }

        $this->session->set_flashdata('add_new_ticket_assistance_msg',$ticket_no);
        redirect("Support/Emb_support");


    }else {
        echo "<pre>";print_r($this->db->error());
    }
  }
  private function upload_files($title,$path, $files){
      if (!is_dir($path))
      mkdir($path, 0777, TRUE);
          $config = array(
              'upload_path'   => $path,
              'allowed_types' => '*',
              'overwrite'     => 1,
          );
          $this->load->library('upload', $config);

          $images = array();

          foreach ($files['name'] as $key => $image) {
              $_FILES['images[]']['name']= $files['name'][$key];
              $_FILES['images[]']['type']= $files['type'][$key];
              $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
              $_FILES['images[]']['error']= $files['error'][$key];
              $_FILES['images[]']['size']= $files['size'][$key];

              $fileName = $image;

              $images[] = $fileName;

              $config['file_name'] = $title.$key.'-'.$fileName;

              $this->upload->initialize($config);

              if ($this->upload->do_upload('images[]')) {
                  $this->upload->data();
              } else {
                  return false;
              }
          }

          return $images;
  }
  // for selecting category
  public function sp_select_category(){
    $where = array('cno' => $this->input->post('category',TRUE),'status !=' => 3 );
    $order_by = $this->db->order_by('csdsc','ASC');
    $query['sp_category_spc'] = $this->Embismodel->selectdata('sp_sub_category AS scs','scs.*',$where,$order_by);

    $where2 = array('cno' => $this->input->post('category',TRUE), );
    $query['sp_category'] = $this->Embismodel->selectdata('sp_main_category AS sc','sc.*',$where2);
    // echo $this->db->last_query();exit;
    echo json_encode($query);
  }

  public function add_assistance_category(){

    $subcat = $this->input->post('sub_cat_assistance',TRUE);
    $this->db->set('ctype',$this->input->post('main_cat_assistance',TRUE));
    $this->db->set('date_added',date('Y-m-d'));
    $this->db->set('added_by',$this->session->userdata('userid'));
    $this->db->set('region',$this->session->userdata('region'));
    $query1 = $this->db->insert('sp_main_category');

      if ($query1)
        $this->db->select_max('cno');
        $res1 = $this->db->get('sp_main_category')->result_array();
        $result_max = $res1[0]['cno'];
        // echo $result_max;exit;
          if (!empty($result_max) ) {
            if (!empty($subcat))
              for ($i=0; $i < sizeof($subcat); $i++) {
                $this->db->set('csdsc',$subcat[$i]);
                $this->db->set('cno',$result_max);
                $query2 = $this->db->insert('sp_sub_category');
              }
          }
          if ($query2) {
            echo "<script>alert('Successfully added !')</script>";
          }else {
            echo $this->db->last_query();
            echo "error, Please contact Administrator!";
          }
          echo "<script>window.location.href='".base_url()."/Support/Emb_support/support_utility_list'</script>";

  }
  // for adding new sp_sub_category
  function add_sp_sub_category(){
    $data = array(
      'csdsc'      => $this->input->post('new_sub_cat_name'),
      'cno'        => $this->input->post('main_cat_id'),
      'date_added' => date('Y-m-d'),
    );
    $query = $this->db->insert('sp_sub_category',$data);
      if ($query) {
        echo "success";
      }else {
        echo "error";
      }
  }
  // for editing assistance sub category
  function update_sub_cat_assistance(){
    if ($this->input->post('sub_cat_status',TRUE) == 3) {
      $this->db->where('csno',$this->input->post('sub_cat_id',TRUE));
      $query = $this->db->delete('sp_sub_category');
    }else {
      $this->db->set('status',$this->input->post('sub_cat_status',TRUE));
      $this->db->where('csno',$this->input->post('sub_cat_id',TRUE));
      $query = $this->db->update('sp_sub_category');
    }
    if ($query) {
      echo "success";
    }else {
        echo "error";
    }
  }

  function update_sub_cat_assistance_name(){
    $this->db->set('csdsc',$this->input->post('new_name',TRUE));
    $this->db->where('csno',$this->input->post('sub_cat_id',TRUE));
    $query = $this->db->update('sp_sub_category');
    if ($query) {
      echo "success";
    }else {
      print_r($this->db->error());
        echo "error";
    }
  }

  public function save_edited_assintance_category(){
    $main_cat_assistance = $this->input->post('main_cat_assistance',TRUE);
    $sub_cat_assistance  = $this->input->post('sub-cat-assistance',TRUE);
    if (!empty($sub_cat_assistance) && array_filter($sub_cat_assistance))
        for ($i=0; $i < sizeof($sub_cat_assistance); $i++) {
          $this->db->set('csdsc',$sub_cat_assistance[$i]);
          $this->db->set('cno',$main_cat_assistance);
          $query = $this->db->insert('sp_sub_category');
        }

    if ($query) {
      echo "<script>alert('Successfully added !')</script>";
    }else {
      echo "error, Please contact Administrator!";
    }
    echo "<script>window.location.href='".base_url()."/Support/Emb_support/support_utility_list'</script>";
  }
  // for viewing support
  function view_support_request(){
      $supp_ticket_id = $this->input->post('supp_ticket_id');
       $query['support_details'] = $this->db->select('acr.userid,acr.fname,acr.mname,acr.region,acr.sname,sta.*,spc.*,ssc.*')->from('sp_ticket_assisstance AS sta')->join('acc_credentials as acr','acr.userid  = sta.staff')->join('sp_main_category as spc ','spc.cno  = sta.sp_category')->join('sp_sub_category as ssc','sta.sp_category_specification = ssc.csno')->where('sta.ticket_ass_id',$supp_ticket_id)->get()->result_array();
       $query['supp_date'] = date("M-j-Y",strtotime($query['support_details'][0]['date_added']));

       $where = array('ticket_ass_id' => $supp_ticket_id, );
       $query['resolution'] = $this->Embismodel->selectdata('sp_assistance_res AS sar','sar.*',$where);
       // echo $this->db->last_query();exit;

        $wheresp = array('scfsa.ticket_ass_id' => $supp_ticket_id, );
        $query['resolution_from_staff'] = $this->Embismodel->selectdata('sp_comment_from_staff_assistance AS scfsa','scfsa.*',$wheresp);

        $wrspattch = array('saa.ticket_no_id' => $supp_ticket_id, );
        $query['sp_attachments'] = $this->Embismodel->selectdata('sp_attach_assistance AS saa','saa.*',$wrspattch);

        $wherepr = array('spra.ticket_ass_id' => $supp_ticket_id, );
        $query['pending_reason'] = $this->Embismodel->selectdata('sp_pending_reason_assistance AS spra','spra.*',$wherepr);

        $wrspfrwd = array('sft.sp_ticket_id' => $supp_ticket_id,'sft.deleted' => 0 );
        $this->db->join('embis.acc_credentials acr','acr.userid = sft.from_user');
        $query['sp_forwaded_data'] = $this->Embismodel->selectdata('sp_forwarded_ticket AS sft','sft.*,acr.fname,acr.sname',$wrspfrwd);

      // echo $support_db->last_query();
      echo json_encode($query);
  }
  function add_res_from_staff_request(){
      $supp_ticket_id = $this->input->post('supp_ticket_id');
       $query['support_details'] = $this->db->select('acr.*,sta.*,spc.*,ssc.*')->from('sp_ticket_assisstance AS sta')->join('acc_credentials as acr','acr.userid  = sta.staff')->join('sp_main_category as spc ','spc.cno  = sta.sp_category')->join('sp_sub_category as ssc','sta.sp_category_specification = ssc.csno')->where('sta.ticket_ass_id',$supp_ticket_id)->get()->result_array();
       $query['supp_date'] = date("M-j-Y",strtotime($query['support_details'][0]['date_added']));
       $where = array('ticket_ass_id' => $supp_ticket_id, );
       $query['resolution'] = $this->Embismodel->selectdata('sp_assistance_res AS sar','sar.*',$where);
      // echo $support_db->last_query();
      echo json_encode($query);
  }

  public function save_comment_from_staff(){



    // if (isset($this->input->post('unresolved_btn'))) {
    //   // code...
    //   echo "2";
    // }
    // exit;
    // echo $ticket_no;exit;
    $this->db->set('staff',$this->session->userdata('userid'));
    $this->db->set('date',date('Y-m-d'));
    $this->db->set('comment',$this->input->post('add_res_from_staff_support_resolution',TRUE));
    $this->db->set('ticket_ass_id',$this->input->post('add_res_from_staff_supp_ticket_ass_id',TRUE));
    $query = $this->db->insert('sp_comment_from_staff_assistance');
    if ($query) {
      if (!empty($this->input->post('confirm_btn'))) {
          $this->db->set('status',3); #if status is solved or confirm from emb staff
      }
      if (!empty($this->input->post('unresolved_btn'))) {
          $this->db->set('status',5); #if status is unresolve or confirm from emb staff
      }
      $this->db->where('ticket_ass_id',$this->input->post('add_res_from_staff_supp_ticket_ass_id',TRUE));
      $q2 = $this->db->update('sp_ticket_assisstance');
        if ($q2)
          echo "<script>alert('Successfully saved !')</script>";
          echo "<script>window.location.href='".base_url()."/Support/Emb_support'</script>";
    }
  }
  // for proccessing module assistance
  public function process_ticket_request(){
    $supp_ticket_id = $this->input->post('supp_ticket_id');
    // echo $supp_ticket_id; exit;
    if (isset($supp_ticket_id) || !empty($supp_ticket_id))
      $this->db->where('ticket_ass_id',$supp_ticket_id);
      $this->db->set('status',1); #if 1 processing
      $this->db->set('mis_id',$this->session->userdata('userid')); #if 1 processing
      $query = $this->db->update('sp_ticket_assisstance');

      ($query) ? $msg = 'success' :  $msg = 'error';
      echo $msg;
  }

  // to be transfer to INVENTORY
  public function support_utility_list(){
    $this->_show_view('support/emb/admin/dashboard');
  }

// adding main category hardware
  public function add_hardware_category(){
    $this->db->set('name',strtoupper($this->input->post('main_cat_hardware',TRUE)));
    $this->db->set('date_added',date('Y-m-d'));
    $this->db->set('added_by',$this->session->userdata('userid'));
    $this->db->set('region',$this->session->userdata('region'));
    $query1 = $this->db->insert('sp_main_category_hardware');
    // echo $this->db->last_query();
    if ($query1) {
        echo "<script>alert('Successfully added !')</script>";
        echo "<script>window.location.href='".base_url()."/Support/Emb_support/support_utility_list'</script>";
    }
  }

  // getting main category hardware
  public function get_main_cat_hardware_data(){
    $where = array('sp_hardware_id' => $this->input->post('category',TRUE) );
    $query['sp_main_category_hardware'] = $this->Embismodel->selectdata('sp_main_category_hardware AS smch','smch.*',$where);

    $where = array('main_hardware_id' => $this->input->post('category',TRUE) );
    $query['sp_brand_per_hardware'] = $this->Embismodel->selectdata('sp_brand_per_hardware AS sbph','sbph.*',$where);
    echo json_encode($query);
  }

  public function view_support_request_borrow(){
      $supp_ticket_id = $this->input->post('tno');
      // echo $supp_ticket_id;exit;
       $query['support_details'] = $this->db->select('acr.*,stb.*,smch.*')->from('sp_ticket_borrow AS stb')->join('acc_credentials as acr','acr.userid  = stb.staff')->join('sp_main_category_hardware as smch ','smch.sp_hardware_id  = stb.hardware_id')->where('stb.tno',$supp_ticket_id)->get()->result_array();
       // echo "<pre>";print_r($query['support_details']);exit;
       $query['borrow_date'] = date("M-j-Y",strtotime($query['support_details'][0]['borrow_date']));
        $query['return_date'] = date("M-j-Y",strtotime($query['support_details'][0]['return_date']));

       $where = array('tno' => $supp_ticket_id, );
       $query['resolution'] = $this->Embismodel->selectdata('sp_assistance_res_borrow AS sarb','sarb.*',$where);

      // echo $support_db->last_query();
      echo json_encode($query);
  }
  // for adding brand per hardware
  public function add_brand_per_hardware_cat(){
      $main_cat_hardware = $this->input->post('main_cat_hardware',TRUE);
      $selected_brand_per_hardware= $this->input->post('selected_brand_per_hardware',TRUE);
      $brand_per_hardware = $this->input->post('brand_per_hardware',TRUE);
      if (!empty($brand_per_hardware) && array_filter($brand_per_hardware)){
        for ($i=0; $i < sizeof($brand_per_hardware); $i++) {
          $this->db->set('name',strtoupper($brand_per_hardware[$i]));
          $this->db->set('main_hardware_id',$main_cat_hardware);
          $query = $this->db->insert('sp_brand_per_hardware');
        }
      }
        // for adding model per brand
        $add_model_per_brand = $this->input->post('add_model_per_brand',TRUE);
        if (!empty($add_model_per_brand) && array_filter($add_model_per_brand)){
          for ($i=0; $i < sizeof($add_model_per_brand); $i++) {
            $this->db->set('name',strtoupper($add_model_per_brand[$i]));
            $this->db->set('main_cat_id',$main_cat_hardware);
            $this->db->set('brand_id',$selected_brand_per_hardware);
            $query = $this->db->insert('sp_brand_model');
          }
        }
        if ($query) {
            echo "<script>alert('Successfully added !')</script>";
            echo "<script>window.location.href='".base_url()."/Support/Emb_support/support_utility_list'</script>";
        }else {
          echo $this->db->last_query();
        }
  }

  public function get_models_per_brand(){
  $where = array(
    'main_cat_id' => $this->input->post('main_cat_id'),
    'brand_id' => $this->input->post('brand_id'),
   );
  $query['models_per_selected_brand'] = $this->Embismodel->selectdata('sp_brand_model AS sbm','sbm.*',$where);

  // for selected brand
  $where = array('sp_cat_brand_id' => $this->input->post('brand_id'));
  $query['brand_name_main_hardware'] = $this->Embismodel->selectdata('sp_brand_per_hardware AS sbph','sbph.*',$where);

  echo json_encode($query);
}

   public function process_ticket_request_borrow(){
       $tno = $this->input->post('tno');
       // echo $tno; exit;
       if (isset($tno) || !empty($tno))
           $this->db->where('tno',$tno);
           $this->db->set('status',1); #if 1 processing
           $this->db->set('mis_id',$this->session->userdata('userid')); #if 1 processing
           $query = $this->db->update('sp_ticket_borrow');

       ($query) ? $msg = 'success' :  $msg = 'error';
       echo $msg;
    }

  public function input_resolution_borrow(){


    $supp_ticket_id = $this->input->post('supp_ticket_id');
    // echo $supp_ticket_id;exit;
     $query['support_details'] = $this->db->select('acr.*,stb.*,smch.*')->from('sp_ticket_borrow AS stb')->join('acc_credentials as acr','acr.userid  = stb.staff')->join('sp_main_category_hardware as smch ','smch.sp_hardware_id  = stb.hardware_id')->where('stb.tno',$supp_ticket_id)->get()->result_array();
     // echo $this->db->last_query();
     // echo "<pre>";print_r($query['support_details']);exit;
     $query['borrow_date'] = date("M-j-Y",strtotime($query['support_details'][0]['borrow_date']));
    $query['return_date'] = date("M-j-Y",strtotime($query['support_details'][0]['return_date']));

    if ($query) {
      echo json_encode($query);
    }else {
      echo $this->db->error(); ;
    }
  }

 public function cancel_process_ticket(){
   $supp_ticket_id = $this->input->post('supp_ticket_id');
   $this->db->where('ticket_ass_id',$supp_ticket_id);
   $this->db->set('status',0); #if 2 processing
   $this->db->set('mis_id', 0); #if 1 processing
   $query = $this->db->update('sp_ticket_assisstance');

   ($query) ? $msg = 'success' :  $msg = 'error';
   echo $msg;
 }

 function cancel_emb_forward_ticket(){
   $supp_ticket_id = $this->input->post('supp_ticket_id');
   // echo $supp_ticket_id;exit;
   $this->db->where('ticket_ass_id',$supp_ticket_id);
   $this->db->set('status',0); #if 2 processing
   $this->db->set('forwarded',0);
   $this->db->set('region',$this->session->userdata('region'));
   $query = $this->db->update('sp_ticket_assisstance');

   if ($query) {
     $msg = 'success';
     $this->db->set('deleted',1);
     $this->db->where('sp_ticket_id',$supp_ticket_id);
     $query2 = $this->db->update('sp_forwarded_ticket');
   }else {
     $msg = 'error';
   }

    echo $msg;
 }

 public function cancel_process_ticket_borrow(){
   $supp_ticket_id = $this->input->post('supp_ticket_id');
   $this->db->where('tno',$supp_ticket_id);
   $this->db->set('status',0); #if 2 processing
   $this->db->set('mis_id', 0); #if 1 processing
   $query = $this->db->update('sp_ticket_borrow');

   ($query) ? $msg = 'success' :  $msg = 'error';
   echo $msg;
 }

 public function input_resolution(){
   $supp_ticket_id = $this->input->post('supp_ticket_id');
   $query['support_details'] = $this->db->select('acr.*,sta.*,spc.*,ssc.*')->from('sp_ticket_assisstance AS sta')->join('acc_credentials as acr','acr.userid  = sta.staff')->join('sp_main_category as spc ','spc.cno  = sta.sp_category')->join('sp_sub_category as ssc','sta.sp_category_specification = ssc.csno')->where('sta.ticket_ass_id',$supp_ticket_id)->get()->result_array();
   $query['supp_date'] = date("M-j-Y",strtotime($query['support_details'][0]['date_added']));

   $wrspattch = array('saa.ticket_no_id' => $supp_ticket_id, );
   $query['sp_attachment_container_solved'] = $this->Embismodel->selectdata('sp_attach_assistance AS saa','saa.*',$wrspattch);

   if ($query) {
     echo json_encode($query);
   }else {
     echo $this->db->error(); ;
   }
 }

 public function pending_process_ticket(){
   $supp_ticket_id = $this->input->post('supp_ticket_id');
   // echo $supp_ticket_id;exit;
   $query['support_details'] = $this->db->select('acr.userid,acr.fname,acr.mname,acr.region,acr.sname,sta.*,spc.*,ssc.*')->from('sp_ticket_assisstance AS sta')->join('acc_credentials as acr','acr.userid  = sta.staff')->join('sp_main_category as spc ','spc.cno  = sta.sp_category')->join('sp_sub_category as ssc','sta.sp_category_specification = ssc.csno')->where('sta.ticket_ass_id',$supp_ticket_id)->get()->result_array();
   $query['supp_date'] = date("M-j-Y",strtotime($query['support_details'][0]['date_added']));
   if ($query) {
     echo json_encode($query);
   }else {
     echo $this->db->error(); ;
   }
 }

 public function submit_reason_pending(){
     $this->db->set('ticket_ass_id',$this->input->post('emb_supp_pending_ticket_id_res'));
     $this->db->set('reason',$this->input->post('emb_support_pending_reason'));
     $this->db->set('date',date('Y-m-d'));
     $query = $this->db->insert('sp_pending_reason_assistance');

     if ($query)

       $this->db->where('ticket_ass_id',$this->input->post('emb_supp_pending_ticket_id_res'));
       $this->db->set('status', 4); #if solve 2
       $query1 = $this->db->update('sp_ticket_assisstance');

       if ($query1) {
         echo "<script>alert('The request ticket is set as Pending !')</script>";
         echo "<script>window.location.href='".base_url()."/Support/Emb_support'</script>";
       }
 }


 public function submit_resolution(){
     $this->db->set('ticket_ass_id',$this->input->post('emb_supp_ticket_id_res'));
     $this->db->set('resolution',$this->input->post('emb_support_resolution'));
     $this->db->set('date',date('Y-m-d'));
     $query = $this->db->insert('sp_assistance_res');

     if ($query)

       $this->db->where('ticket_ass_id',$this->input->post('emb_supp_ticket_id_res'));
       $this->db->set('status', 2); #if solve 2
       $query1 = $this->db->update('sp_ticket_assisstance');

       if ($query1) {
           $this->session->set_flashdata('submit_resolution_msg','SOLVED !');
           redirect("Support/Emb_support");
         // echo "<script>alert('SOLVED !.')</script>";
         // echo "<script>window.location.href='".base_url()."/Support/Emb_support'</script>";
       }
 }

 // for getting category borrow
 public function submit_resolution_borrow(){
     $this->db->set('tno',$this->input->post('borrow_emb_supp_ticket_id_res'));
     $this->db->set('status',$this->input->post('borrow_status'));
     $this->db->set('resolution',$this->input->post('borrow_emb_support_resolution'));
     $this->db->set('date',date('Y-m-d'));
     $query = $this->db->insert('sp_assistance_res_borrow');
     // echo $this->db->last_query();exit;
     if ($query)

       $this->db->where('tno',$this->input->post('borrow_emb_supp_ticket_id_res'));
       ($this->input->post('borrow_status') == 1) ? $status = 2 : $status = 3;
       $this->db->set('status', $status); #if solve 2
       $query1 = $this->db->update('sp_ticket_borrow');

       if ($query1) {
         echo "<script>alert('SOLVED !.')</script>";
         echo "<script>window.location.href='".base_url()."/Support/Emb_support'</script>";
       }
 }
 // getting main category hardware
 public function get_brand_per_hardware_borrow(){
   $where = array('main_hardware_id' => $this->input->post('category',TRUE) );
   $query = $this->Embismodel->selectdata('sp_brand_per_hardware AS sbph','sbph.*',$where);
   echo json_encode($query);
 }
 public function get_model_per_brand_borrow(){
   // echo $this->input->post('brand',TRUE);
   // error_reporting(0);
   // ini_set('display_errors', 0);
   $where = array(
     'brand_id' => $this->input->post('brand',TRUE),
     'main_cat_id' => $this->input->post('main_cat_id',TRUE));
   $query = $this->Embismodel->selectdata('sp_brand_model AS sbm','sbm.*',$where);
   echo json_encode($query);
 }

 public function add_new_ticket_borrow(){
   $this->db->select_max('tno');
   $res1 = $this->db->get('sp_ticket_borrow')->result_array();
   $maxid = $res1[0]['tno'] + 1;
   $ticket_no = $this->session->userdata('region').'-'.date("Y").'-'.$maxid;
   // echo $ticket_no;exit;
   $this->db->set('staff',$this->session->userdata('userid'));
   $this->db->set('region', $this->session->userdata('region'));
   $this->db->set('ticket_date',date('Y-m-d'));
   $this->db->set('quantity',$this->input->post('quantity',TRUE));
   $this->db->set('remarks',$this->input->post('remarks_borrow',TRUE));
   $this->db->set('hardware_id',$this->input->post('sp_category_borrow',TRUE));
   $this->db->set('brand_id',$this->input->post('sp_brand_borrow',TRUE));
   $this->db->set('model_id',$this->input->post('sp_model_borrow',TRUE) );
   $this->db->set('ticket_no',$ticket_no );
    $this->db->set('return_date',$this->input->post('return_date',TRUE) );
    $this->db->set('borrow_date',$this->input->post('borrow_date',TRUE) );
   $query = $this->db->insert('sp_ticket_borrow');
   if ($query) {
     echo "<script>alert('SUCCESS !.')</script>";
     echo "<script>window.location.href='".base_url()."/Support/Emb_support'</script>";
   }
 }
 public function faqs(){
   $this->_show_view('support/emb/faqs');
 }
 public function update_main_cat_assistance(){
    $this->db->set('ctype',$this->input->post('name',TRUE));
    $this->db->where('cno',$this->input->post('main_cat_id',TRUE));
    $query = $this->db->update('embis.sp_main_category');
    if ($query){
      $where = array('cno' => $this->input->post('main_cat_id',TRUE), );
      $data['cat_data'] = $this->Embismodel->selectdata('sp_main_category AS smc','smc.*',$where);
      $data['msg'] = 'success';
    }else {
        $data['msg'] = 'error';
    }
      echo json_encode($data);
 }

   public function main_cat_ast_active_inactive(){
     if ($this->input->post('status',TRUE) == 0) {
       $this->db->set('deleted',0);
     }
     if ($this->input->post('status',TRUE) == 1) {
      $this->db->set('deleted',1);
     }
     $this->db->where('cno',$this->input->post('main_cat_id',TRUE));
     $query = $this->db->update('embis.sp_main_category');

     if ($query){
       $where = array('cno' => $this->input->post('main_cat_id',TRUE), );
       $data['cat_data'] = $this->Embismodel->selectdata('sp_main_category AS smc','smc.*',$where);
       $data['msg'] = 'success';
     }else {
         $data['msg'] = 'error';
     }
     echo json_encode($data);
   }



function view_support_request_frwd(){
    $supp_ticket_id = $this->input->post('supp_ticket_id');
     $query['support_details'] = $this->db->select('acr.userid,acr.fname,acr.mname,acr.region,acr.sname,sta.*,spc.*,ssc.*')->from('sp_ticket_assisstance AS sta')->join('acc_credentials as acr','acr.userid  = sta.staff')->join('sp_main_category as spc ','spc.cno  = sta.sp_category')->join('sp_sub_category as ssc','sta.sp_category_specification = ssc.csno')->where('sta.ticket_ass_id',$supp_ticket_id)->get()->result_array();

     $query['supp_date'] = date("M-j-Y",strtotime($query['support_details'][0]['date_added']));

      $wrspattch = array('saa.ticket_no_id' => $supp_ticket_id, );
      $query['sp_attachments'] = $this->Embismodel->selectdata('sp_attach_assistance AS saa','saa.*',$wrspattch);
    // echo $support_db->last_query();
    echo json_encode($query);
}

function view_support_request_frwd_ch(){
    $supp_ticket_id = $this->input->post('supp_ticket_id');
     // $query['support_details'] = $this->db->select('sta.*')
     // ->from('sp_ticket_assisstance AS sta')
     // ->where('sta.ticket_ass_id',$supp_ticket_id)->get()->result_array();

     $where_sp = array('sta.ticket_ass_id' => $supp_ticket_id, );
      $query['support_details'] = $this->Embismodel->selectdata('sp_ticket_assisstance AS sta','sta.*',$where_sp);

      $wrspattch = array('saa.ticket_no_id' => $supp_ticket_id, );
      $query['sp_attachments'] = $this->Embismodel->selectdata('sp_attach_assistance AS saa','saa.*',$wrspattch);

      $query['supp_date'] = date("M-j-Y",strtotime($query['support_details'][0]['ticket_date']));

      $where_sp_frwd = array('sft.sp_ticket_id' => $supp_ticket_id,'deleted' => 0);
      $query['frwd_data'] = $this->Embismodel->selectdata('sp_forwarded_ticket AS sft','sft.*',$where_sp_frwd);

    echo json_encode($query);
}

function submit_reason_forward(){
  // echo "<pre>";print_r($_POST);exit;
  $this->db->set('forwarded_to','CO');
  $this->db->set('from_reg', $this->session->userdata('region'));
  $this->db->set('from_user',$this->session->userdata('userid'));
  $this->db->set('date_forwarded',date('Y-m-d'));
  $this->db->set('sp_ticket_id',$this->input->post('emb_forward_supp_pending_ticket_id_res',TRUE));
  $this->db->set('remarks',$this->input->post('emb_forward_support_pending_reason',TRUE));
  $query = $this->db->insert('sp_forwarded_ticket');
    if ($query)

    if ($query)
      $this->db->where('ticket_ass_id',$this->input->post('emb_forward_supp_pending_ticket_id_res',TRUE));
      $this->db->set('forwarded',1);
      $this->db->set('region','CO');
      $query1 = $this->db->update('sp_ticket_assisstance');
      if ($query1) {
        $this->session->set_flashdata('frwd_to_co','Success !');
        redirect("Support/Emb_support");
      }else {
        echo "<script>alert('SOMETHING WENT WRONG !.')</script>";
        echo "<script>window.location.href='".base_url()."/Support/Emb_support'</script>";
      }
  }

  public function select_division(){
  $regions = array('region',$this->input->post('region',TRUE));
  $query = $this->db->select('*')->from('acc_xdvsion')->where_in('type',$regions)->where('office','EMB')->get()->result_array();
  echo json_encode($query);
  }

  public function select_section(){
    $query = $this->db->select('*')->from('acc_xsect')->where('divno',$this->input->post('div_val',TRUE))->get()->result_array();
    echo json_encode($query);
  }

function get_division_data($id=''){
  $query = $this->db->select('*')->from('acc_xdvsion')->where('divno',$id)->get()->result_array();
  return $query[0];
}

function get_section_data($id=''){
    $query = $this->db->select('*')->from('acc_xsect')->where('secno',$id)->get()->result_array();
    return $query[0];
}

function get_staff_data($id=''){
  $query = $this->db->select('*')->from('acc_credentials')->where('userid',$id)->get()->result_array();
  return $query[0];
}
  public function submit_forward_to_sec(){
    $sec_data  = $this->get_section_data($this->input->post('supp_sec',TRUE));
    $div_data  = $this->get_division_data($this->input->post('supp_div',TRUE));
    $user_data = $this->get_staff_data($this->session->userdata('userid'));
    $this->db->set('ticket_ass_id',$this->input->post('ticket_ass_id',TRUE));
    $this->db->set('sp_forward_id',$this->input->post('fwrd_id',TRUE));
    $this->db->set('remarks',$this->input->post('emb_forward_to_ch_remarks',TRUE));
    $this->db->set('fwrd_to_region',$this->input->post('change_region',TRUE));
    $this->db->set('from_staff',$this->session->userdata('userid'));
    $this->db->set('date_fwrd',date('Y-m-d'));
    $this->db->set('from_name',$user_data['fname'].''.$user_data['sname']);
    $this->db->set('sec_id',$sec_data['secno']);
    $this->db->set('sec_name',$sec_data['secode']);
    $this->db->set('div_id',$div_data['divno']);
    $this->db->set('div_name',$div_data['divcode']);
    $query = $this->db->insert('sp_ticket_assisstance_sec');

    if ($query) {
      $this->db->set('forwarded',2);
      $this->db->where('ticket_ass_id',$this->input->post('ticket_ass_id',TRUE));
      $q2 = $this->db->update('sp_ticket_assisstance');
      if ($q2)
        $this->session->set_flashdata('frwd_to_sec','Success !');
        redirect("Support/Emb_support");
    }
  }

// ticket created from regional section
  public function submit_forward_to_sec_regional($post= '',$id){
    $sec_data  = $this->get_section_data($post['supp_sec']);
    $div_data  = $this->get_division_data($post['supp_div']);
    $user_data = $this->get_staff_data($this->session->userdata('userid'));
    $this->db->set('ticket_ass_id',$id);
    $this->db->set('sp_forward_id',$id);
    $this->db->set('remarks',$post['remarks']);
    $this->db->set('fwrd_to_region',$post['change_region']);
    $this->db->set('from_staff',$this->session->userdata('userid'));
    $this->db->set('date_fwrd',date('Y-m-d'));
    $this->db->set('from_name',$user_data['fname'].''.$user_data['sname']);
    $this->db->set('sec_id',$sec_data['secno']);
    $this->db->set('sec_name',$sec_data['secode']);
    $this->db->set('div_id',$div_data['divno']);
    $this->db->set('div_name',$div_data['divcode']);
    $this->db->insert('sp_ticket_assisstance_sec');

  }


}
