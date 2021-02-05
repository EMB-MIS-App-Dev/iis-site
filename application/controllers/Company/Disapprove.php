<?php

/**
 *
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class Disapprove extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->model('Attachment');
  }
  function disaprove_client_request(){

    $crs  = $this->load->database('crs',TRUE);
    $req_id = $this->input->post('req_id',TRUE);
    // echo $req_id;exit;
    // $crc_query = $crs->query('SELECT company_token FROM crs.client_request_company AS crc WHERE crc.req_id='.$req_id.'')->result_array();
    $cer_query_new = $crs->query('SELECT cer.req_id,est.establishment,acc.email,acc.client_id FROM client_est_requests as cer
 LEFT JOIN establishment as est ON est.cnt = cer.req_id LEFT JOIN acc as acc ON acc.client_id = cer.client_id WHERE cer.req_id  = '.$req_id.'')->result_array();
 // echo "<pre>";print_r($cer_query_new);exit;
    // echo $facility_name;exit;
    $reason = $this->input->post('reason',TRUE);
// echo $req_id;exit;
    $crs->set('reason',$reason);
    $crs->set('req_id',$req_id);
    $crs->set('date',date('Y-m-d'));
    $crs->set('disapproved_by',$this->session->userdata('userid'));
    $query = $crs->insert('client_request_disapprove');

     if ($query) {

        $crs->set('status', 2); #disapproved
        $crs->where('req_id',$req_id);
        $clientreqquery = $crs->update('client_est_requests');

          if ($clientreqquery)
            echo "<script>alert('SUCCESS')</script>";
            echo "<script>window.location.href='".base_url()."Company/Company_list/for_approval_company_request'</script>";


            $this->load->config('email');
            $this->load->library('email');
            $from 	= $this->config->item('smtp_user');
            $to 	  = $cer_query_new[0]['email'];
    //         $subject = 'Environmental Management Bureau Online Services';
    // 		$message = 'Please refer below for your user credentials.
    // Username: '.$queryselectacs[0]['username'].' Password: '.$raw_password.'';
            $subject    = 'Environmental Management Bureau Online Services';
            $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***.

Your Establishment (".strtoupper($cer_query_new[0]['establishment']).") has been disapproved by the EMB - ".$this->session->userdata('region')." sytem administrator.

Because of the following reasons:
--------------------------------------------------------------
".$reason."";


            $this->email->set_newline("\r\n");
            $this->email->from($from,'EMB SUPPORT');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($email_body);

            if (! $this->email->send()) {
              // echo "<script>alert('Successfully assigned.')</script>";
              // echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
              show_error($this->email->print_debugger());
            } else {
              echo "send";
            }
        // for updating client request status
     }
  }
//   function disaprove_client_request(){
//
//     $crs  = $this->load->database('crs',TRUE);
//     $req_id = $this->encrypt->decode($this->input->post('req_id',TRUE));
//     $email = $this->encrypt->decode($this->input->post('email',TRUE));
//     $reqtoken = $this->encrypt->decode($this->input->post('reqtoken',TRUE));
//
//     $crc_query = $crs->query('SELECT company_token FROM crs.client_request_company AS crc WHERE crc.req_id='.$req_id.'')->result_array();
//
//     $dms_comp_query = $this->db->query('SELECT * FROM embis.dms_company AS dc WHERE dc.token="'.$reqtoken.'"')->result_array();
//     $facility_name        = $dms_comp_query[0]['company_name'];
//
//     // echo $facility_name;exit;
//     $reason = $this->input->post('reason',TRUE);
// // echo $req_id;exit;
//     $crs->set('reason',$reason);
//     $crs->set('reqid',$req_id);
//     $crs->set('disapproved_by',$this->session->userdata('userid'));
//     $query = $crs->insert('client_request_disapprove_reason');
//
//      if ($query) {
//
//         $crs->set('status', 2);
//         $crs->where('req_id',$req_id);
//         $clientreqquery = $crs->update('client_request_company');
//
//           if ($clientreqquery)
//             echo "<script>alert('SUCCESS')</script>";
//             echo "<script>window.location.href='".base_url()."Company/Company_list/for_approval_company_request'</script>";
//
//
//             $this->load->config('email');
//             $this->load->library('email');
//             $from 	= $this->config->item('smtp_user');
//             $to 	  = $email;
//     //         $subject = 'Environmental Management Bureau Online Services';
//     // 		$message = 'Please refer below for your user credentials.
//     // Username: '.$queryselectacs[0]['username'].' Password: '.$raw_password.'';
//             $subject    = 'Environmental Management Bureau Online Services';
//             $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***.
//
// Your Establishment (".strtoupper($facility_name).") has been disapproved by the EMB - ".$this->session->userdata('region')." sytem administrator.
//
// Because of the following reasons:
// --------------------------------------------------------------
// ".$reason."";
//
//
//             $this->email->set_newline("\r\n");
//             $this->email->from($from,'EMB SUPPORT');
//             $this->email->to($to);
//             $this->email->subject($subject);
//             $this->email->message($email_body);
//
//             if (! $this->email->send()) {
//               // echo "<script>alert('Successfully assigned.')</script>";
//               // echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
//               show_error($this->email->print_debugger());
//             } else {
//               echo "send";
//             }
//         // for updating client request status
//      }
//   }
  function disaprove_facility(){
    $crs  = $this->load->database('crs',TRUE);
    $req_id  = $this->input->post('req_id',TRUE);
    // echo $req_id;exit;
    $cleint_req_data = $crs->select('cer.client_id,cer.est_id')->from('client_est_requests as cer')->where('req_id',$req_id)->get()->result_array();
    $user_data = $crs->select('acc.email')->from('acc')->where('client_id',$cleint_req_data[0]['client_id'])->get()->result_array();
    $company_data = $crs->select('est.establishment,est.est_id')->from('establishment as est')->where('est_id',$cleint_req_data[0]['est_id'])->get()->result_array();
    // echo $req_id;
    // echo $this->db->last_query();
    // echo "<pre>";print_r($company_data);exit;
    // echo $req_id;
    // echo "<br>";
    //     echo $email;
    //     echo "<br>";
    //         echo $facility_name;exit;
    $reason       = $this->input->post('reasonfacility',TRUE);

    $crs->set('reason',$reason);
    $crs->set('req_id',$req_id);
    $crs->set('disapproved_by',$this->session->userdata('userid'));
    $query = $crs->insert('client_new_req_disapproved');

    // echo $facility_name;exit;
    if ($query) {

       $crs->set('status', 2);
       $crs->where('req_id',$req_id);
       $clientreqquery = $crs->update('client_est_requests');

         if ($clientreqquery)
           echo "<script>alert('SUCCESS')</script>";
           echo "<script>window.location.href='".base_url()."Company/Company_list/for_approval_company_request'</script>";


           $this->load->config('email');
           $this->load->library('email');
           $from 	= $this->config->item('smtp_user');
           $to 	  = $user_data[0]['email'];
   //         $subject = 'Environmental Management Bureau Online Services';
   // 		$message = 'Please refer below for your user credentials.
   // Username: '.$queryselectacs[0]['username'].' Password: '.$raw_password.'';
           $subject    = 'Environmental Management Bureau Online Services';
           $email_body = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***.

Your request Establishment (".strtoupper($company_data[0]['establishment']).") has been disapproved by the EMB-".$this->session->userdata('region')." sytem administrator.

Because of the following reasons:
----------------------------------------------------------------
".$reason."";


           $this->email->set_newline("\r\n");
           $this->email->from($from,'EMB SUPPORT');
           $this->email->to($to);
           $this->email->subject($subject);
           $this->email->message($email_body);

           if (! $this->email->send()) {
             // echo "<script>alert('Successfully assigned.')</script>";
             // echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
             show_error($this->email->print_debugger());
           } else {
             echo "send";
           }
       // for updating client request status
    }
  }
  function view_disapprove_client_request(){
    // echo "string";
    $crs = $this->load->database('crs',TRUE);
    $request_id = $this->input->post('request_id');
    $cleint_req_data = $crs->select('crd.disapproved_by,crd.reason,crd.req_id,crd.client_disapproved_id')
    ->from('client_request_disapprove as crd')->where('req_id',$request_id)->order_by('client_disapproved_id','DESC')->limit(1)->get()->result_array();
    // echo "<pre>";print_r($cleint_req_data);exit;
    $cleint_req_userid= $crs->select('cer.client_id')
    ->from('client_est_requests as cer')->where('req_id',$request_id)->get()->result_array();
    $userdetails= $crs->select('acc.*')
    ->from('acc as acc')->where('client_id',$cleint_req_userid[0]['client_id'])->get()->result_array();
    // echo "<pre>";print_r($cleint_req_userid);exit;
    $users_attch_data = $crs->select('*')
                ->from('acc_attch_id as uattch')
                ->where('uattch.user_id',$cleint_req_userid[0]['client_id'])
                ->get()->result_array();
                // echo "<pre>";print_r($users_attch_data);exit;

    if (empty($cleint_req_data[0]['reason'])) {
      echo "Isang Makalikasang Pagbati!
       Upon the evaluation of your request, we regret to inform you that your application is disproved.  The refusal might be one of the following reason(s):
       1. The name indicated in the authorization letter does not match with the submitted Company ID and/or Government-issued ID.
       Kindly  resubmit your request with the appropriate attached document.
       Thank you!
       ";
    }else {
      echo $cleint_req_data[0]['reason'];
      echo "<hr>";
      echo "<div class='col-md-12'>";
        echo '<div class="h6  text-gray-800" >Client Name: '.$userdetails[0]['first_name'].' '.$userdetails[0]['last_name'].' </div>';
      echo "<div class='row'>";
      echo "<div class='col-md-6'>";
        echo '<div class="h6 mb-0 font-weight-bold text-gray-800" >ATTACHMENT:</div>';
      echo '<div class="dropdown show"> <a class="btn btn-secondary dropdown-toggle" style="width:50%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a> <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

      foreach ($users_attch_data as $key => $uval) {
         $attchname = str_replace(' ', '_', $uval['name']);
          $subfolder = $uval['type'] == '1' ? 'gov_id' : 'company_id';
          echo '<a target="_blank" class="dropdown-item" href="../../../crs/uploads/user_attch_id/'.$subfolder.'/'.$uval['user_id'].'/'.$attchname.'">'.$attchname.'</a>';
      }
        echo "</div>";
          echo "</div>";
      echo "</div>";
      echo "<div class='col-md-6'>";
      echo '<div class="h6 mb-0 font-weight-bold text-gray-800" >AUTHORIZATION LETTER</div>';
      echo "<a target='_blank' href='../../../../crs/uploads/authorization_letter/".$request_id."/authorization_letter.pdf'><i class='fa fa-eye' aria-hidden='true' style='padding-left:10px'></i></a>";
      echo "</div>";
        echo "</div>";
      echo "</div>";
    }
  }
}
