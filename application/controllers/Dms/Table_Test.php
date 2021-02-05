<?php

class Table_Test extends CI_Controller
{
  private $sql_details;

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->library('encryption');
    // $this->load->library('Datatables');

    $this->sql_details = array(
       'user' => $this->session->userdata('user'),
       'pass' => $this->session->userdata('pass'),
       'db'   => $this->session->userdata('db'),
       'host' => $this->session->userdata('host'),
     );

    // Datatables Custom Views
    $this->load->view('Dms/func/datecount.php');
  }


    function inbox_test()
    {
      // Custom PHP includes
      $user_token = $this->input->post('user_token');
      // SQL server connection information
      $sql_details = $this->sql_details;
      // DB table to use
      $table = "er_transactions";
      // Table's primary key
      $primaryKey = 'trans_no';

      $columns = array(
          array( 'db' => 'et.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
          array( 'db' => 'et.token', 'dt' => 'token', 'field' => 'token' ),
          array( 'db' => 'et.multiprc', 'dt' => 'multiprc', 'field' => 'multiprc' ),
          array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name', 'formatter' => function($x, $row) {
            $company_name = htmlspecialchars(stripslashes($row['company_name']));
            return $company_name;
          } ),
          array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id', 'formatter' => function($x, $row) {
            $emb_id = htmlspecialchars(stripslashes($row['emb_id']));
            return $emb_id;
          }  ),
          array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
            $sub=substr($row['subject'],0,60);
            $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
            return $subject;
          }),
          array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
          array( 'db' => 'etm.m_receive',  'dt' => 'm_receive', 'field' => 'm_receive' ),
          array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
          array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
          array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
          array( 'db' => 'etm.etl_m_sent_date_out',  'dt' => 'date_forwarded1', 'field' => 'etl_m_sent_date_out'),
          array( 'db' => 'etl_sent.date_out',  'dt' => 'date_forwarded', 'field' => 'date_out', 'formatter' => function($x, $row){
            $etl_m_sent = ($row['etl_m_sent_date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['etl_m_sent_date_out'])) : '';
            $etl_sent = ($row['date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '';
            return (!empty($row['etl_m_sent_date_out'])) ? $etl_m_sent : (!empty($etl_sent) ? $etl_sent : '-');
          } ),
          array( 'db' => 'etm.m_sender_name', 'dt' => 'm_sender_name', 'field' => 'm_sender_name' ),
          array( 'db' => 'et.sender_name', 'dt' => 'sender_name', 'field' => 'sender_name', 'formatter' => function($x, $row){
            $main_name = !empty($row['sender_name']) ? $row['sender_name'] : '--';
            return (!empty($row['m_sender_name'])) ? $row['m_sender_name'] : $main_name;
          } ),
          // array( 'db' => 'etl_rcvd.date_in',  'dt' => 'date_received', 'field' => 'date_in', 'formatter' => function($x, $row){
          //   return ($row['date_in'] != '0000-00-00' && !empty($row['date_in'])) ? date("F j, Y, g:i a", strtotime($row['date_in'])) : '-';
          // } ),
          array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
            $sub=substr($row['remarks'],0,60);
            $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
            return $remarks;
          }),
          array( 'db' => 'etm.m_cntr', 'dt' => 'm_cntr', 'field' => 'm_cntr' ),
          array( 'db' => 'etm.main_multi_cntr',  'dt' => 'main_multi_cntr', 'field' => 'main_multi_cntr' ),
          array( 'db' => 'etm.multi_cntr',  'dt' => 'multi_cntr', 'field' => 'multi_cntr' ),

          // array( 'db' => 'etm.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
          // array( 'db' => 'etm.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
          // array( 'db' => 'etm.etl_m_sent_date_out',  'dt' => 'etl_m_sent_date_out', 'field' => 'etl_m_sent_date_out' ),
          // array( 'db' => 'etl_m_sent.date_out',  'dt' => 'date_forwarded', 'field' => 'date_out', 'formatter' => function($x, $row){
          //   return ($row['date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
          // } ),
          // array( 'db' => 'etm.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
          // array( 'db' => 'etm.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          //   return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
          // }),
      );

      $this->load->view('includes/common/ssp.customized.class.php');

      // er_transactions JOIN er_transactions_log(date_forwarded)
      $joinQuery = 'FROM er_transactions AS et JOIN er_transactions_log AS etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';
      // er_transactions_multi JOIN er_transactions_log(date_forwarded)
      $joinQuery .= 'LEFT JOIN (SELECT etm1.trans_no, etm1.route_order, etm1.main_multi_cntr, etm1.multi_cntr, etm1.sender_name AS m_sender_name, etm1.receive AS m_receive, etm1.receiver_id, etm1.status, COUNT(etm1.trans_no) AS m_cntr, etl_m_sent.date_out AS etl_m_sent_date_out FROM er_transactions_multi AS etm1 JOIN er_transactions_log AS etl_m_sent ON (etl_m_sent.trans_no = etm1.trans_no AND etl_m_sent.route_order = etm1.route_order AND etl_m_sent.main_multi_cntr = etm1.main_multi_cntr AND etl_m_sent.multi_cntr = etm1.multi_cntr) WHERE etm1.receiver_id = "'.$user_token.'" AND etm1.status != 24  GROUP BY etm1.trans_no ORDER BY etl_m_sent.date_out DESC) AS etm ON (etm.trans_no = et.trans_no)';

      // er_transactions_log(date_received)
      // $joinQuery .= 'LEFT JOIN (SELECT etl2.trans_no, etl2.route_order, etl2.date_in FROM er_transactions_log AS etl2) AS etl_rcvd ON (etl_rcvd.trans_no = et.trans_no AND etl_rcvd.route_order = et.route_order+1)';

      $extraWhere = 'et.route_order != 0 AND et.status != 0 AND (et.receiver_id = "'.$user_token.'" OR etm.receiver_id = "'.$user_token.'") AND et.status != 24 AND et.type != 83 AND et.type != 51 AND et.type != 166';
      $groupBy = null;
      $having = null;

      echo json_encode(
          SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
    }



 function outbox_test()
 {
   // Custom PHP includes
   $user_token = $this->input->post('user_token');
   $data = array('draw' => $this->input->post('draw'));

   $this->db->from('er_transactions')->where(array('sender_id' => '515e12d4a186a84'));

   if($this->input->post('start') != 0) {
     $this->db->limit($this->input->post('length'), $this->input->post('start'));
   }
   else {
     $this->db->limit($this->input->post('length'));
   }
   if(!empty($this->input->post('order'))) {
      foreach ($this->input->post('order') as $key => $order) {
         $this->db->order_by($order['column']+1, strtoupper($order['dir']));
      }
   }
   $trans_list = $this->db->get()->result_array();

   foreach ($trans_list as $key => $transaction) {
      $data['data'][$key] = array( 'trans_no' => $transaction['trans_no'], 'token' => $transaction['token'] );
   }

   $data["recordsFiltered"] = $this->db->select('COUNT(trans_no) AS recordsFiltered')->from('er_transactions')->where(array('sender_id' => '515e12d4a186a84'))->get()->row()->recordsFiltered;
   $data["post"] = $this->input->post();

   $this->db->close();
   echo json_encode($data);
 }

  function data_test()
  {
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "olsys_test.pco_application";
    // Table's primary key
    $primaryKey = 'appli_no';

    $columns = array(
      array( 'db' => 'ol.appli_no', 'dt' => 'appli_no', 'field' => 'appli_no' ),
      array( 'db' => 'ol.test', 'dt' => 'test', 'field' => 'test' ),
      array( 'db' => 'ol.idd', 'dt' => 'idd', 'field' => 'idd' ),
    );

    $this->load->view('includes/common/ssp.customized.class2.php');

    $joinQuery = 'FROM olsys_test.pco_application ol';
    $extraWhere = null;
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

}
