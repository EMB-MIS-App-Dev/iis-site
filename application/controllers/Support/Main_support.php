<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main_support extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->helper('url');
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('modals/Support/support_modals');
    $this->load->view('support/view_support');
  }
  function view_support_request(){
      $supp_ticket_id = $this->encrypt->decode($this->input->post('supp_ticket_id'));
      $support_db = $this->load->database('support',TRUE);
      $query['support_details'] = $support_db->select('*')->from('support')->where('support_id',$supp_ticket_id)->get()->result_array();
      $query['support_attachments'] = $support_db->select('*')->from('attachments')->where('supp_ticket_id',  $query['support_details'][0]['supp_ticket_id'])->get()->result_array();
      // echo $support_db->last_query();
      echo json_encode($query);
  }
  function res_view_support_request(){
      $supp_ticket_id = $this->encrypt->decode($this->input->post('supp_ticket_id'));
      // echo $supp_ticket_id;exit;
      $support_db = $this->load->database('support',TRUE);
      $query['support_details'] = $support_db->select('*')->from('support')->where('support_id',$supp_ticket_id)->get()->result_array();
      $query['support_attachments'] = $support_db->select('*')->from('attachments')->where('supp_ticket_id',  $query['support_details'][0]['supp_ticket_id'])->get()->result_array();
      $query['resolution'] = $support_db->select('*')->from('resolution')->where('support_id',  $supp_ticket_id)->get()->result_array();
      $query['res_support_attachments'] = $support_db->select('*')->from('res_attachments')->where('supp_ticket_id',  $supp_ticket_id)->get()->result_array();

      // echo $support_db->last_query();
      echo json_encode($query);
  }
  function process_ticket_request(){
      $supp_ticket_id = $this->encrypt->decode($this->input->post('supp_ticket_id'));
      $support_db = $this->load->database('support',TRUE);
      $support_db->set('support_id',$supp_ticket_id);
      $support_db->set('emb_emp_id',$this->session->userdata('userid'));
      $support_db->set('date_process',date('Y-m-d'));
      $support_db->set('status',0);
      $query = $support_db->insert('process_request');
      if ($query) {
        $support_db->where('support_id',$supp_ticket_id);
        $support_db->set('status',1); #if 2 processing
        $support_db->update('support');
        $msg = 'success';
      }else {
        $msg = 'error';
      }
      echo $msg;
  }

  function cancel_process_ticket(){
    $support_db = $this->load->database('support',TRUE);
    $supp_ticket_id = $this->encrypt->decode($this->input->post('supp_ticket_id'));
    // echo $supp_ticket_id;exit;
    $support_db->where('support_id',$supp_ticket_id);
    $support_db->set('status',0); #if 2 processing
    $query = $support_db->update('support');
    if ($query) {
      $support_db->where('support_id',$supp_ticket_id);
      $support_db->delete('process_request');

      $msg = 'success';
    }else {
      $msg = 'error';
    }
    echo $msg;
  }
  function input_resolution(){
    $supp_ticket_id = $this->encrypt->decode($this->input->post('supp_ticket_id'));
    $support_db = $this->load->database('support',TRUE);
    $query['support_details'] = $support_db->select('*')->from('support')->where('support_id',$supp_ticket_id)->get()->result_array();
    echo json_encode($query);
  }
  function submit_resolution(){
      $support_db = $this->load->database('support',TRUE);
      $support_db->set('support_id',$this->input->post('supp_ticket_id_res'));
      $support_db->set('resolution',$this->input->post('support_resolution'));
      $query = $support_db->insert('resolution');

      if ($query)

        $support_db->where('support_id',$this->input->post('supp_ticket_id_res'));
        $support_db->set('status', 2); #if solve 2
        $query1 = $support_db->update('support');

        if ($query1) {
          echo "<script>alert('SUCCESS.')</script>";
          echo "<script>window.location.href='".base_url()."/Support/Main_support'</script>";
        }
  }

  function fileUpload()
  {
    $supp_ticket_id = $this->input->post('supp_ticket_id');
    // echo $supp_ticket_id;exit;
    if(!is_dir('uploads/support/'.$supp_ticket_id)) {
      mkdir('uploads/support/'.$supp_ticket_id);
    }
    // echo "string";
    // exit;
    if(!empty($_FILES['file']['name'] )) {
      // Set preference
      $config = array(
        'upload_path'   => 'uploads/support/'.$supp_ticket_id,
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
          'name'   => $_FILES['file']['name'],
          'deleted' => 0,
          'date_attach' => date('Y-m-d H:i:s'),
          'supp_ticket_id' => $supp_ticket_id,
         );
         $support_db = $this->load->database('support',TRUE);
        $query_attch = $support_db->insert('res_attachments',$data);
        // for deleting file
        $path = 'uploads/support/'.$supp_ticket_id.'/'.$_FILES['file']['name'];
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
  // for inserting main suppot
  function insert_main_support(){
    $main_sub = $this->input->post('main_sub');
    $main_rem = $this->input->post('main_rem');
    $main_attch = $this->input->post('main_attch');
    $attch_name = $_FILES['main_attch']['name'];
    $year = date('y');
    $this->db->select_max('sup_main_id');
    $result = $this->db->get('supp_main');
    if ($result->num_rows() > 0)
    {
        $res = $result->result_array();
        $reslt = $res[0]['sup_main_id'];
        $maxsupid = $reslt + 1; //column 1
    }
    $attchranmame = $_SESSION['region'].$year.$maxsupid;
    $req_date = date('y-m-d');
    $userid = $_SESSION['userid'];
    if (!empty($_POST)) {
        $insertdata = array(
          'subject'     => $main_sub,
          'remarks'     => $main_rem,
          'attch_name'  => $attch_name,
          'req_date'    => $req_date,
          'userid'      => $userid,
          'ticket_num'  => $attchranmame,
          'status'      => 1,
        );
      $query = $this->Embismodel->insertdata('supp_main',$insertdata);
      if ($query) {
        $subfolder = 'support';
        $attach = $this->Attachment->uploadattch($attchranmame,$subfolder);
        echo "<script>alert('SUCCESS.')</script>";
        echo "<script>window.location.href='".base_url()."/Support/Main_support'</script>";
      }else {
        echo "<script>alert('ERROR')</script>";
      }
    }
  }

  // update ticket
  function update_ticket(){
      $sup_main_id = $this->input->post('sup_main_id');
      // function updatedata($data,$table,$where){
      $where = array('supp_main.sup_main_id' => $sup_main_id, );
      $data = array('supp_main.status' => 2,);
      $query = $this->Embismodel->updatedata($data,'supp_main',$where);
  }

function cancel_forward_ticket(){
  $support_db = $this->load->database('support',TRUE);
  $supp_ticket_id = $this->input->post('supp_ticket_id');
  $support_db->where('support_id',$supp_ticket_id);
  $support_db->set('status',0); #if 2 processing
  $query = $support_db->update('support');
  if ($query) {
    $msg = 'success';
  }else {
    $msg = 'error';
  }
  echo $msg;
}


}
