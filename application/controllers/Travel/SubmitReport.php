<?php

class SubmitReport extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->model('Travelordermodel');
    $this->load->library('session');
    $this->load->helper('url');
    date_default_timezone_set("Asia/Manila");
  }

  function index(){

    date_default_timezone_set("Asia/Manila");
    if(!empty($this->input->post('travel_details'))){

      $region          = $this->session->userdata('region');
      $sender_id       = $this->session->userdata('token');
      $ip_address = $this->input->ip_address();
      $travel_no       = $this->encrypt->decode($this->input->post('travel_details'));

      $wheretravel = $this->db->where('tt.toid = "'.$travel_no.'"');
      $jointravel  = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
      $querytravel = $this->Embismodel->selectdata('to_trans AS tt','','',$jointravel,$wheretravel);

      $wheretransx = $this->db->where('etl.trans_no = "'.$querytravel[0]['trans_no'].'"');
      $transx = $this->Embismodel->selectdata('er_transactions_log AS etl','MAX(route_order) AS mro','',$wheretransx);

      $wherelog  = $this->db->where('et.trans_no = "'.$querytravel[0]['trans_no'].'" AND et.route_order = "1"');
      $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);

      //Sender
      $wheresender   = $this->db->where('acs.userid = "'.$this->session->userdata('userid').'" AND acs.verified = "1"');
      $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.title,acs.fname,acs.sname,acs.suffix,acs.divno,acs.secno','',$wheresender);
      $smname = (!empty($qrysender[0]['mname'])) ? $qrysender[0]['mname'][0].". " : "";
      $ssuffix = (!empty($qrysender[0]['suffix'])) ? " ".$qrysender[0]['suffix'] : "";
      $sprefix = (!empty($qrysender[0]['title'])) ? $qrysender[0]['title']." " : "";
      $sname = $sprefix.$qrysender[0]['fname']." ".$smname.$qrysender[0]['sname'].$ssuffix;

        $date_out  = date('Y-m-d H:i:s');

        $path = 'dms/'.date('Y').'/'.$region.'/';
        if(!is_dir('uploads/'.$path.'/'.$querytravel[0]['trans_no'])) {
          mkdir('uploads/'.$path.'/'.$querytravel[0]['trans_no'], 0777, TRUE);
        }

         $error = array();

         $config = array(
              'upload_path'   => 'uploads/'.$path.'/'.$querytravel[0]['trans_no'].'/',
              'allowed_types' => 'pdf|csv|xls|ppt|doc|docx|xlsx|mp4|m4a|jpeg|jpg|png|gif|mp3|zip|text|txt',
              'max_size'			 => '100000',
              'overwrite'     => TRUE,
          );

         $this->load->library('upload',$config);
         $counter = 0;
         for($i=0; $i < count($_FILES['report_file']['name']); $i++)
         {
             $_FILES['file']['name']= $_FILES['report_file']['name'][$i];
             $_FILES['file']['type']= $_FILES['report_file']['type'][$i];
             $_FILES['file']['tmp_name']= $_FILES['report_file']['tmp_name'][$i];
             $_FILES['file']['error']= $_FILES['report_file']['error'][$i];
             $_FILES['file']['size']= $_FILES['report_file']['size'][$i];

             $att_token1 = fmod($querytravel[0]['trans_no'], 1000000);

             $ea_w = array(
               'ea.trans_no'     => $querytravel[0]['trans_no'],
               'ea.route_order'  => ($transx[0]['mro']+1),
             );
             $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);

             $att_token = $region.date('Y').'-FT'.($transx[0]['mro']+1).'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);

             $config['file_name'] = $att_token;

             $this->upload->initialize($config);

             if($this->upload->do_upload('file')) {
               $erattach_insert = array(
                 'trans_no'      => $querytravel[0]['trans_no'],
                 'route_order'   => ($transx[0]['mro']+1),
                 'file_id'       => ($ea_q[0]['max_fileid']+1), // order_by
                 'token'         => $att_token,
                 'file_name'     => $_FILES['file']['name'],
               );
               $uploadvar = $this->Embismodel->insertdata('er_attachments', $erattach_insert);
               if($counter == 0){
                 $set = array(
                   'tt.travel_report_route_no' => ($transx[0]['mro']+1),
                 );

                 $where = array( 'tt.er_no' => $querytravel[0]['trans_no']);
                 $result = $this->Embismodel->updatedata( $set, 'to_trans AS tt', $where );

                 $trans_log_insert = array(
                   'trans_no'              => $querytravel[0]['trans_no'],
                   'route_order'           => ($transx[0]['mro']+1),
                   'subject'               => $translog[0]['subject']." with TRAVEL REPORT",
                   'sender_divno'          => $qrysender[0]['divno'],
                   'sender_secno'          => $qrysender[0]['secno'],
                   'sender_id'             => $sender_id,
                   'sender_name'           => $sname,
                   'sender_region'         => $region,
                   'sender_ipadress'       => $ip_address,
                   'receiver_id'           => '',
                   'receiver_name'         => '',
                   'receiver_region'       => '',
                   'type'                  => $translog[0]['type'],
                   'status'                => '24',
                   'status_description'    => 'for filing / closed',
                   'action_taken'          => 'Travel Report Submission',
                   'date_in'               => $date_out,
                   'date_out'              => $date_out,
                 );
                 $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);
                  // echo $this->db->last_query(); exit;

                 $set = array(
                   'et.route_order'        => ($transx[0]['mro']+1),
                   'status'                => '24',
                   'status_description'    => 'for filing / closed',
                   'et.receive'            => 0,
                   'et.sender_id'          => $qrysender[0]['token'],
                   'et.sender_name'        => ucwords($qrysender[0]['fname']." ".$qrysender[0]['sname']),
                   'et.receiver_division'  => '',
                   'et.receiver_section'   => '',
                   'receiver_region'       => '',
                   'et.receiver_id'        => '',
                   'et.receiver_name'      => '',
                   'et.action_taken'       => 'Travel Report Submission',
                 );

                 $where = array( 'et.trans_no' => $querytravel[0]['trans_no']);
                 $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
                 $counter++;
               }
             }else {
               // Show error on uploading
               $uploadError = array('error' => $this->upload->display_errors());
             }
         }

         $swal_arr = array(
          'title'     => 'SUCCESS!',
          'text'      => 'Travel report successfully saved.',
          'type'      => 'success',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);
        redirect(base_url('Travel/Dashboard'));
    }
  }

}

?>
