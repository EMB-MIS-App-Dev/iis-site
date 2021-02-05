<?php

class SubmitTicket extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->model('Travelordermodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('form_validation');
  }

  function index(){
    $datetoday     = date('Y-m-d');
    $expiry_date   = $this->input->post('expiry_date', TRUE);
    $ticket_office = $this->input->post('ticket_office', TRUE);
    $amount        = $this->input->post('amount', TRUE);
    $amount_figures= $this->input->post('amount_figures', TRUE);
    $er_no         = $this->encrypt->decode($this->input->post('er_no', TRUE));

    $wherechiefaccountant = $this->db->where('ar.to_ticket_chief_accountant','yes');
    $wherechiefaccountant = $this->db->where('ar.region', $this->session->userdata('region'));
    $chiefaccountant      = $this->Embismodel->selectdata('acc_rights AS ar','ar.userid','',$wherechiefaccountant);

    if(!empty($amount) AND !empty($expiry_date) AND !empty($ticket_office)){
      $data 		   = array(
          'to_ticket_request.er_no'         => $er_no,
          'to_ticket_request.issue_date'    => $datetoday,
          'to_ticket_request.expiry_date'   => $expiry_date,
          'to_ticket_request.ticket_office' => $ticket_office,
          'to_ticket_request.amount'        => $amount,
          'to_ticket_request.amount_figures'=> $amount_figures,
          'to_ticket_request.accountant_id' => $chiefaccountant[0]['userid'],
      );

      $insertfunction = $this->Embismodel->insertdata('embis.to_ticket_request',$data);

      //Trans logs
        $transx    = $this->db->query("SELECT MAX(route_order) AS mro FROM er_transactions_log WHERE trans_no = '$er_no'")->result_array();
        $wherelog  = $this->db->where('et.trans_no',$er_no);
        $wherelog  = $this->db->where('et.route_order','1');
        $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);

        $wheresender   = $this->db->where('acs.userid',$this->session->userdata('userid'));
        $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.fname,acs.sname,acs.region','',$wheresender);

        $whereer_trans = $this->db->where('et.trans_no',$er_no);
        $er_trans      = $this->Embismodel->selectdata('er_transactions AS et','*','',$whereer_trans);

        $to_trans_route_order = $this->Travelordermodel->to_trans_route_order($er_no);

        $date_out  = date('Y-m-d H:i:s');

        $set = array(
          'et.route_order'        => $transx[0]['mro']+1,
          'status'                => '5',
          'status_description'    => 'Approved',
          'et.receive'            => 0,
          'et.sender_id'          => $qrysender[0]['token'],
          'et.sender_name'        => ucwords($qrysender[0]['fname']." ".$qrysender[0]['sname']),
          'et.receiver_division'  => '',
          'et.receiver_section'   => '',
          'receiver_region'       => '',
          'et.receiver_id'        => '',
          'et.receiver_name'      => '',
          'et.action_taken'       => 'Issued Ticket',
        );

        $where = array( 'et.trans_no' => $er_no);
        $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where );

         $trans_log_insert = array(
           'trans_no'          => $er_no,
           'route_order'       => $transx[0]['mro']+1,
           'subject'           => $translog[0]['subject'],
           'sender_id'         => $qrysender[0]['token'],
           'sender_name'       => ucwords($qrysender[0]['fname']." ".$qrysender[0]['sname']),
           'sender_region'     => $qrysender[0]['region'],
           'sender_ipadress'   => '',
           'receiver_id'       => '',
           'receiver_name'     => '',
           'receiver_region'   => '',
           'type'              => $translog[0]['type'],
           'status'            => '5',
           'status_description'=> 'Approved',
           'action_taken'      => 'Issued Ticket',
           'date_in'           => $date_out,
           'date_out'          => $date_out,
         );
         $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

        if($insertfunction){
          $swal_arr = array(
           'title'     => 'SUCCESS!',
           'text'      => 'Ticket successfully issued.',
           'type'      => 'success',
         );
         $this->session->set_flashdata('swal_arr', $swal_arr);
          echo "<script>window.location.href='".base_url()."Travel/Ticket'</script>";
        }
    }

  }

}
