<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Clients extends CI_Controller
{

    function __construct()
    {
      parent::__construct();
      $this->load->library('session');
      $this->load->helper('url');

    }

    function index(){
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $query['sort_by_company'] = $this->db->select('dcomp.company_id,dcomp.company_name,apr.req_id,apr.client_id')->from('approved_client_req as apr')->join('embis.dms_company as dcomp','dcomp.company_id = apr.company_id','left')->where('dcomp.region_name',$this->session->userdata('region'))->where('apr.req_id !=', 0)->get()->result_array();
      // echo $this->db->last_query();
      //   echo "<pre>";print_r($query);exit;
      $this->load->view('clients/resend_emails',$query);
    }
    function resend_verification_hwms(){
      $crsdb = $this->load->database('crs',TRUE);
      $client_req_id = $this->input->post('client_req_id',TRUE);

      $data = $crsdb->select('*')->from('client_binded_companies')->where('client_req_id',$client_req_id)->get()->result_array();

      if ($data) {

          $crsdb->set('status',1);
          $crsdb->set('req_id',$data['req_id']);
          $crsdb->set('client_id',$data['client_id']);
          $crsdb->set('apr_req_id',$data['client_req_id']);
          if ($query2 > 0) {
            $crsdb->where('client_id',$data['client_id']);
            $queryhwms = $crsdb->update('resend_hwms_credentials');
          }else {
            $queryhwms = $crsdb->insert('resend_hwms_credentials');
          }
          if ($queryhwms) {

            $this->load->library('email');
            $date_text = date("F-d-Y", strtotime($data[0]['date_approved']));
            $this->load->config('email');
            $this->load->library('email');
            $this->email->set_crlf( "\r\n" );
            // $from = $this->config->item('smtp_user','CRS Admin');


            $subject = 'Environmental Management Bureau Online Services';
            $email_body  = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***<br>";
            $email_body .= "COMPANY REGISTRATION STATUS!.  Your requested Establishment<br>";
            $email_body .= "".$data[0]['company_name']."<br><br>";
            $email_body .= "has been approved by the system admin with<br><br>";
            $email_body .= "Company Reference ID: ".$data[0]['emb_id']."<br>";
            $email_body .= "Applicant of Company Reference ID: ".$userdetails[0]['first_name'].' '.$userdetails[0]['last_name']."<br>";
            $email_body .= "Date Approved: ".$date_text."<br><br>";
            $email_body .= "Your company is now active on EMB online systems.<br>";
            $email_body .= "You can now process transactions under your company.<br>";
            $email_body .= "Thank you for registering!";
            $to 	 = $data[0]['email'];


            $this->email->set_newline("\r\n");
            $this->email->set_mailtype('html');
            // $this->email->from($from);
            $this->email->from('r7support@emb.gov.ph', 'CRS Support');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($email_body);

            if ($this->email->send()) {
              $msg['msg']='sent';
              $msg['email']= $data[0]['email'];
            }else {
              $msg['msg'] = $this->email->print_debugger();
              print_r($this->email->print_debugger());
              exit;
            }
            echo json_encode($msg);
          }
      }
    }
    function userlist(){
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('clients/client_list');
    }
    function resend_verification_email(){
      $client_id = $this->input->post('client_id',TRUE);
      $crsdb = $this->load->database('crs',TRUE);
      $query = $crsdb->select('*')->from('acc')->where('client_id',$client_id)->get()->result_array();
      $data = $query[0];
      // echo $this->encrypt->decode($data['raw_password']);
      // echo "<pre>";print_r($data);exit;
      if ($query) {
          $crsdb->set('verified',1);
          $crsdb->where('client_id',$data['client_id']);
          $crsdb->update('acc');

          $query2 = $crsdb->select('client_id')->from('resend_email')->where('client_id',$client_id)->get()->num_rows();
          $crsdb->set('status',1);
          $crsdb->set('email',$data['email']);
          $crsdb->set('client_id',$data['client_id']);
          if ($query2 > 0) {
            $crsdb->where('client_id',$data['client_id']);
            $crsdb->update('resend_email');
          }else {
            $crsdb->insert('resend_email');
          }

          $this->load->library('email');

          $this->load->config('email');
          $this->load->library('email');
          $this->email->set_crlf( "\r\n" );
          $from = $this->config->item('smtp_user');

          $to 	 = $data['email'];
          $subject = 'Verification Link';
          $message ="Hi, Please click link below to verify EMB online account.<br />";
          $message .="<a href='https://iis.emb.gov.ph/crs/Login/verify_user_registration/?user_code=".$data['user_code']."'>Verify Email Address.</a><br><br>";
          $message .="To view profile, click username and click 'profile' on navigation area. <br>Thank you.<br>";
          $message  .= "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***<br>";
          $to 	 = $data['email'];

          $this->email->set_newline("\r\n");
          $this->email->set_mailtype('html');
          // $this->email->from($from);
          $this->email->from('r7support@emb.gov.ph', 'CRS Support');
          $this->email->to($to);
          $this->email->subject($subject);
          $this->email->message($message);



        if ($this->email->send()) {
          $msg['msg']='sent';
        }else {
          $msg['msg'] = $this->email->print_debugger();
        }
        echo json_encode($msg);
      }
    }

    function unbind_client_establishment(){
      $client_req_id = $this->input->post('client_req_id',TRUE);
      $new_client = $this->input->post('new_client',TRUE);

      $old_client_id = $this->db->select('client_id')->from('crs.client_binded_companies')->where('client_req_id',$client_req_id)->get()->row();

      $new_client_data = $this->db->select('client_id,first_name,last_name,email,')->from('crs.acc')->where('deleted',0)->where('client_id',$new_client)->get()->row();

      if (!empty($client_req_id) || $client_req_id != '' && !empty($new_client) || $new_client != '') {
        // for updating approved_company in crs
        $this->db->set('first_name',$new_client_data->first_name);
        $this->db->set('last_name',$new_client_data->last_name);
        $this->db->set('client_id',$new_client_data->client_id);
        $this->db->set('email',$new_client_data->email);
        $this->db->where('client_req_id',$client_req_id);
        $query_cbc = $this->db->update('crs.client_binded_companies');

        // for updating approved_company in embis
        $this->db->set('client_id',$new_client_data->client_id);
        $this->db->where('req_id',$client_req_id);
        $this->db->where('client_id',$old_client_id->client_id);
        $query_acr = $this->db->update('embis.approved_client_req');

        if ($query_cbc && $query_acr){
          $this->db->set('date_unbinded',date('Y-m-d'));
          $this->db->set('unbinder',$this->session->userdata('userid'));
          $this->db->set('old_client_id',$old_client_id->client_id);
          $this->db->set('new_client_id',$new_client);
          $query = $this->db->insert('crs.unbinded_establishment_records');
          if ($query)
            echo "success";
        }else {
          echo "error!";
          print_r($this->db->error());
        }
      }else {
        echo "error";
      }
      // echo "<pre>";print_r($_POST);exit;
    }
}
