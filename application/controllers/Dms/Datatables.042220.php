<?php

class Datatables extends CI_Controller
{
  private $sql_details = array(
     'user' => 'iis',
     'pass' => 'agentx3mbvii158459',
     'db'   => 'embis',
     'host' => 'localhost'
   );

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->library('form_validation');

    // Datatables Custom Views
    $this->load->view('Dms/func/datecount.php');
  }

  function all_transactions()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    // Custom PHP includes
    // $func = $this->input->post('func'); // if FUNC is DIRECTOR, conditional statement(s)
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');

    // SQL server connection information
    $sql_details = $this->sql_details;

    // DB table to use
    $table = "er_transactions";

    // Table's primary key
    $primaryKey = 'trans_no';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
      array( 'db' => 'et.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
      array( 'db' => 'et.token', 'dt' => 'token', 'field' => 'token' ),
      array( 'db' => 'et.multiprc', 'dt' => 'multiprc', 'field' => 'multiprc' ),
      array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
      array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id'),
      array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
        $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
        return $subject;
      }),
      array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
      array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
      array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
      array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
      array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
      array( 'db' => 'etl.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
        return ($row['date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
      } ),
      array( 'db' => 'et.receiver_name',  'dt' => 'receiver_name', 'field' => 'receiver_name' ),
      array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
        return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
      }),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et JOIN (SELECT etl1.trans_no, etl1.main_route_order, etl1.route_order, etl1.date_out FROM er_transactions_log AS etl1) AS etl ON (etl.trans_no = et.trans_no AND etl.route_order = et.route_order)';
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND etl.main_route_order = "" AND ( et.receiver_region = "'.$user_region.'" OR et.region = "'.$user_region.'" ) AND  '.$filter.' 1';
    // $extraWhere = 'et.route_order != 0 AND et.status != 0 AND etl.main_route_order = "" AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND  '.$filter.' 1';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );

  }

  function drafts()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    // Custom PHP includes
    $user_token = $this->input->post('user_token');
    $user_region = $this->input->post('user_region');

    // SQL server connection information
    $sql_details = $this->sql_details;

    // DB table to use
    $table = "er_transactions";

    // Table's primary key
    $primaryKey = 'trans_no';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
        array( 'db' => 'et.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
        array( 'db' => 'et.token', 'dt' => 'token', 'field' => 'token' ),
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.receiver_name',  'dt' => 'receiver_name', 'field' => 'receiver_name' ),
        array( 'db' => 'et.remarks',  'dt' => 'remarks', 'field' => 'remarks' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et';
    $extraWhere = 'et.route_order = 0 AND et.sender_id LIKE "%'.$user_token.'%" AND et.region LIKE "%'.$user_region.'%" ';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );

  }

  function inbox()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

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
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'etl_in.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
          return ($row['date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
        } ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'etl_out.date_in',  'dt' => 'date_in', 'field' => 'date_in', 'formatter' => function($x, $row){
          return ($row['date_in'] != '0000-00-00' && !empty($row['date_in'])) ? date("F j, Y, g:i a", strtotime($row['date_in'])) : '-';
        } ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
        }),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et LEFT JOIN (SELECT ietm.trans_no, ietm.receiver_id, ietm.receive FROM er_transactions_multi AS ietm WHERE ietm.status != 0 AND ietm.receiver_id = "'.$user_token.'" AND ietm.status != 24 GROUP BY ietm.trans_no) AS etm ON etm.trans_no = et.trans_no LEFT JOIN (SELECT etl1.trans_no, etl1.route_order, etl1.date_out FROM er_transactions_log AS etl1) AS etl_in ON (etl_in.trans_no = et.trans_no AND etl_in.route_order = et.route_order) LEFT JOIN (SELECT etl2.trans_no, etl2.route_order, etl2.date_in FROM er_transactions_log AS etl2) AS etl_out ON (etl_out.trans_no = et.trans_no AND etl_out.route_order = et.route_order+1)';
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND ( et.receiver_id = "'.$user_token.'" OR etm.receiver_id = "'.$user_token.'") AND et.status != 24';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );

  }

  function outbox()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

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
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          return $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'etl.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
          return ($row['date_out'] != '0000-00-00 00:00:00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
          } ),
        array( 'db' => 'et.receiver_name',  'dt' => 'receiver_name', 'field' => 'receiver_name' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
        }),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    // $joinQuery = 'FROM er_transactions AS et JOIN (SELECT trans_no, date_out FROM er_transactions_log WHERE sender_id = "'.$user_token.'" GROUP BY trans_no ) AS etl ON etl.trans_no = et.trans_no ';
    $joinQuery = 'FROM er_transactions AS et JOIN (SELECT etl1.trans_no, etl1.date_out FROM er_transactions_log AS etl1 JOIN (SELECT etl2.trans_no, MAX(etl2.route_order) AS max_route_order FROM er_transactions_log AS etl2 WHERE etl2.sender_id = "'.$user_token.'" AND etl2.receiver_id != "" GROUP BY etl2.trans_no) AS etl3 ON (etl3.trans_no = etl1.trans_no AND etl1.route_order = etl3.max_route_order) ) AS etl ON etl.trans_no = et.trans_no';
    $extraWhere = 'et.route_order != 0 AND et.status != 0';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );

  }

  function records()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    // Custom PHP includes
    $user_token = $this->input->post('user_token');
    $user_region = $this->input->post('user_region');

    // SQL server connection information
    $sql_details = $this->sql_details;

    // DB table to use
    $table = "er_transactions";

    // Table's primary key
    $primaryKey = 'trans_no';

    $columns = array(
        array( 'db' => 'et.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
        array( 'db' => 'et.token', 'dt' => 'token', 'field' => 'token' ),
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          return $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status',  'dt' => 'status', 'field' => 'status' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'et.records_location',  'dt' => 'records_location', 'field' => 'records_location' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
        }),
        array( 'db' => 'etl.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
          return ($row['date_out'] != '0000-00-00' && !empty($row['date_out'])) ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
        } ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et JOIN (SELECT etl1.trans_no, etl1.route_order, etl1.date_out FROM er_transactions_log AS etl1) AS etl ON (etl.trans_no = et.trans_no AND etl.route_order = et.route_order)';
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type != 83 AND et.region LIKE "%'.$user_region.'%" AND (et.records_location != "" OR et.status = 24) ';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
  }

  function claim()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

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
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          return $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."....."."</span>";
        }),
        array( 'db' => 'et.start_date',  'dt' => 'start_date', 'field' => 'start_date' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et';
    $extraWhere = 'et.route_order != 0 AND et.receiver_id = "'.$user_token.'" AND et.status != 24';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
  }

  function revisions()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    // Custom PHP includes
    $user_region = $this->input->post('user_region');
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
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          return $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
        }),
        array( 'db' => 'et.start_date',  'dt' => 'start_date', 'field' => 'start_date' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et';
     $extraWhere = 'et.route_order != 0 AND et.status != 0 AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) ';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );

  }

  function view_transaction()
  {
    $this->load->view('modals/view_transaction.php');
  }
}
