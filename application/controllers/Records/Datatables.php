<?php

class Datatables extends CI_Controller
{
  private $sql_details;

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->library('form_validation');

    $this->sql_details = array(
       'user' => $this->session->userdata('user'),
       'pass' => $this->session->userdata('pass'),
       'db'   => $this->session->userdata('db'),
       'host' => $this->session->userdata('host'),
     );
  }

  function permits()
  {
    // Custom PHP includes
    $type = $this->input->post('type');
    $user_region = $this->session->userdata('region');

    $filter = array(
      'start_date'  => $this->input->post('start_date'),
      'end_date'    => $this->input->post('end_date'),
    );

    // $filter = $this->input->post('filter');
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
      array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
      array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id'),
      array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
        $sub=substr($row['subject'],0,60);
        $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        return $subject;
      }),
      array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
      array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
      array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
      array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
      array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
      array( 'db' => 'etl_sent.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
        return ($row['date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
      } ),
      array( 'db' => 'et.receiver_name',  'dt' => 'receiver_name', 'field' => 'receiver_name' ),
      array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
        $sub=substr($row['remarks'],0,60);
        $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        return $remarks;
      }),
    );

    $this->load->view('includes/common/ssp.customized.class.php');


    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    if(!empty($filter['start_date']) && !empty($filter['end_date'])) {
      $joinQuery .= 'JOIN (SELECT etl1.trans_no FROM er_transactions_log etl1 WHERE etl1.status = 5 AND ( etl1.date_out BETWEEN "'.$filter['start_date'].'" AND "'.$filter['end_date'].'")) AS etl ON (etl.trans_no = et.trans_no) ';
    }

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.region = "'.$user_region.'" AND ';

    if(!empty($type)) {
      $extraWhere .= 'et.type = "'.$type.'" AND ';
    }

    $extraWhere .= '1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
  }

}
?>
