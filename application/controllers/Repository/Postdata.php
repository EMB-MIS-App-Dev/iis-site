<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Postdata extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

  function index(){

    date_default_timezone_set("Asia/Manila");
    if(!empty($this->input->post('doc_type')) AND !empty($this->input->post('employee_token'))){

      $region          = $this->session->userdata('region');
      $sender_id       = $this->session->userdata('token');

      $region_where = array('ar.rgnnum' => $region );
      $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

      $wheretransaction= $this->db->where('et.region', $region);
      $new_transaction = $this->Embismodel->selectdata('er_transactions AS et', 'MAX(et.trans_no) AS max_trans_no', '', $wheretransaction);

      // echo $this->db->last_query(); exit;

      $current_yr = date("Y");
      $trans_rgn = $region_data[0]['rgnid'] * 1000000;
      // add statements for same region selection for transaction number identifiers

      if(sizeof($new_transaction) != 0) {
        $max_id = $new_transaction[0]['max_trans_no'];

        $transaction_yr = intval($max_id / 100000000);

        if($transaction_yr == $current_yr) {
          $trans_no = $max_id + 1;
        }
        else {
          $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
        }
      }
      else {
        $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
      }

      $trans_token = $region.'-'.$current_yr.'-'.sprintf('%06d', ($trans_no - ((int)($trans_no / 1000000)*1000000)));


      $date_in = date('Y-m-d H:i:s');

      $acwhere = array('ac.token' => $sender_id );
      $credq = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acwhere );

      $mname = ' ';
      if(!empty($credq[0]['mname']) )
        $mname = ' '.$credq[0]['mname'][0].'. ';

      $suffix = '';
      if(!empty($credq[0]['suffix']) )
        $suffix = ' '.$credq[0]['suffix'];

      $sender_name = ucwords($credq[0]['fname'].$mname.$credq[0]['sname']).$suffix;

      $likeemb    = $this->db->like('company_name','Environmental Management Bureau');
      if($region == 'CO'){
        $whereemb   = $this->db->where('dc.emb_id','EMBNCR-1053620-0001');
      }else{
        $whereemb   = $this->db->where('dc.region_name',$region);
      }
      $queryemb   = $this->Embismodel->selectdata('dms_company AS dc','dc.token,dc.company_name,dc.emb_id','',$whereemb,$likeemb);

      $wheretrans_type = $this->db->where('et.id = "'.$this->encrypt->decode($this->input->post('doc_type')).'"');
      $querytrans_type = $this->Embismodel->selectdata('er_type AS et','et.id,et.name','',$wheretrans_type);

      $where    = $this->db->where('acs.userid',$this->encrypt->decode($this->input->post('employee_token')));
      $join     = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
      $join     = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
      $receiver = $this->Embismodel->selectdata('acc_credentials AS acs','xn.divname,xt.sect,acs.region,acs.userid,acs.fname,acs.sname,acs.token','',$where);


      $date_out = date('Y-m-d H:i:s');

      $trans_log_insert = array(
        'trans_no'            => $trans_no,
        'route_order'         => "1",
        'subject'             => $this->input->post('subject'),
        'sender_id'           => $sender_id,
        'sender_name'         => $sender_name,
        'sender_region'       => $region,
        'sender_ipadress'     => $this->input->ip_address(),
        'receiver_id'         => $receiver[0]['token'],
        'receiver_name'       => ucwords($receiver[0]['fname']." ".$receiver[0]['sname']),
        'receiver_region'     => $receiver[0]['region'],
        'type'                => $querytrans_type[0]['id'],
        'status'              => "16",
        'status_description'  => "for releasing",
        'action_taken'        => "For appropriate action.",
        'date_in'             => $date_out,
        'date_out'            => $date_out,
      );
      $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

      $start_date = date('Y-m-d');

      $trans_insert = array(
        'trans_no'           => $trans_no,
        'token'              => $trans_token,
        'route_order'        => 1,
        'company_token'      => $queryemb[0]['token'],
        'company_name'       => $queryemb[0]['company_name'],
        'emb_id'             => $queryemb[0]['emb_id'],
        'subject'            => $this->input->post('subject'),
        'system'             => "12",
        'type'               => $querytrans_type[0]['id'],
        'type_description'   => $querytrans_type[0]['name'],
        'status'             => "16",
        'status_description' => "for releasing",
        'receive'            => 0,
        'sender_id'          => $sender_id,
        'sender_name'        => $sender_name,
        'receiver_division'  => $receiver[0]['divname'],
        'receiver_section'   => $receiver[0]['sect'],
        'receiver_region'    => $receiver[0]['region'],
        'receiver_id'        => $receiver[0]['token'],
        'receiver_name'      => ucwords($receiver[0]['fname']." ".$receiver[0]['sname']),
        'action_taken'        => "For appropriate action.",
        'start_date'         => $start_date,
        'region'             => $region,
      );
      $insert_trans = $this->Embismodel->insertdata('er_transactions', $trans_insert);

      if($insert_trans){

        $path = 'dms/'.date('Y').'/'.$region.'/';
        if(!is_dir('uploads/'.$path.'/'.$trans_no)) {
          mkdir('uploads/'.$path.'/'.$trans_no, 0777, TRUE);
        }

         $this->load->library('upload');
         $files = $_FILES;
         $cnt_files = count($_FILES['file']['name']);

         for($i=0; $i<$cnt_files; $i++)
         {
             $att_token1 = fmod($trans_no, 1000000);

             $ea_w = array(
               'ea.trans_no'     => $trans_no,
               'ea.route_order'  => 1,
             );
             $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);

             $att_token = $region.date('Y').'-FT'.'1'.'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);

             $_FILES['file']['name']= $files['file']['name'][$i];
             $_FILES['file']['type']= $files['file']['type'][$i];
             $_FILES['file']['tmp_name']= $files['file']['tmp_name'][$i];
             $_FILES['file']['error']= $files['file']['error'][$i];
             $_FILES['file']['size']= $files['file']['size'][$i];

             $this->upload->initialize($this->set_upload_options($path,$att_token,$trans_no));
             if(!$this->upload->do_upload('file')) {
               // Show error on uploading
               $uploadError = array('error' => $this->upload->display_errors());
             }
             else {


               $erattach_insert = array(
                 'trans_no'      => $trans_no,
                 'route_order'   => 1,
                 'file_id'       => $ea_q[0]['max_fileid']+1, // order_by
                 'token'         => $att_token,
                 'file_name'     => $_FILES['file']['name'],
               );
               $this->Embismodel->insertdata('er_attachments', $erattach_insert);
            }
         }

         $report_insert = array(
           'trans_no'           => $trans_no,
           'trans_token'        => $trans_token,
           'type'               => $querytrans_type[0]['id'],
           'type_description'   => $querytrans_type[0]['name'],
           'subject'            => $this->input->post('subject'),
           'token'              => $this->encrypt->decode($this->input->post('token')),
           'added_by'           => $this->session->userdata('userid'),
           'added_by_name'      => $sender_name,
           'date_added'         => $start_date,
           'region'             => $region,
         );
         $this->Embismodel->insertdata('er_repository', $report_insert);
         echo "<script>alert('Successfully added.')</script>";
         echo "<script>window.location.href='".base_url()."Repository'</script>";
      }

    }
  }

  private function set_upload_options($path = "", $att_token = "", $trans_no = "")
  {
      //upload an image options
      $config = array();
      $config['upload_path'] = 'uploads/'.$path.$trans_no;
      $config['allowed_types'] = '*';
      $config['max_size']      = '20480';
      $config['file_name']     = $att_token;
      $config['overwrite']     = FALSE;

      return $config;
  }
}

?>
