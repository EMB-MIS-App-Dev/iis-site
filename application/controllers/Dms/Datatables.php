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

    // Datatables Custom Views
    $this->load->view('Dms/func/datecount.php');
  }

  function dttb_sample()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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
        return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
      }),
    );

    $this->load->view('includes/common/ssp.customized.class.php');


    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function denr_trans()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") JOIN (SELECT etl1.trans_no FROM er_transactions_log AS etl1 WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no) AS etl ON (etl.trans_no = et.trans_no) ';

    // $extraWhere = 'et.route_order != 0 AND et.status != 0 AND '.$filter.' 1';

    // $joinQuery = 'FROM er_transactions AS et JOIN (SELECT * FROM er_transactions_log etl1 WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no ) AS etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';
    //
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.tag_doc_type = 0 AND ( et.type != 21 AND et.system != 17 ) AND '.$filter.' 1';

    $groupBy = 'et.trans_no';
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
}

  function all_transactions()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") JOIN (SELECT etl1.trans_no FROM er_transactions_log AS etl1 WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no) AS etl ON (etl.trans_no = et.trans_no) ';

    // $extraWhere = 'et.route_order != 0 AND et.status != 0 AND '.$filter.' 1';

    // $joinQuery = 'FROM er_transactions AS et JOIN (SELECT * FROM er_transactions_log etl1 WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no ) AS etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';
    //
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.tag_doc_type = 0 AND ( et.type != 21 AND et.system != 17 ) AND '.$filter.' 1';

    $groupBy = 'et.trans_no';
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
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
          $sub=substr($row['subject'],0,60);
          $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.receiver_name',  'dt' => 'receiver_name', 'field' => 'receiver_name' ),
        array( 'db' => 'et.remarks',  'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          $sub=substr($row['remarks'],0,60);
          $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $remarks;
        } ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et';
    $extraWhere = 'et.route_order = 0 AND et.deleted != 1 AND et.sender_id LIKE "%'.$user_token.'%" AND et.region LIKE "%'.$user_region.'%" ';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();

  }

  function inbox()
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

  function outbox()
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
        array( 'db' => 'et.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
        array( 'db' => 'et.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id' ),
        array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
          $sub=substr($row['subject'],0,60);
          $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.multiprc',  'dt' => 'multiprc', 'field' => 'multiprc' ),
        array( 'db' => 'etl.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
          return ($row['date_out'] != '0000-00-00 00:00:00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
          } ),
        array( 'db' => 'et.receiver_name',  'dt' => 'receiver_name', 'field' => 'receiver_name' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          $sub=substr($row['remarks'],0,60);
          $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $remarks;
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
    $this->db->close();

  }

  function closed()
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

    $joinQuery = 'FROM er_transactions et JOIN (SELECT etl1.trans_no FROM er_transactions_log AS etl1 WHERE etl1.sender_id = "'.$user_token.'" AND etl1.status = 24 GROUP BY etl1.trans_no) AS etl ON (etl.trans_no = et.trans_no) LEFT JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
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
          $sub=substr($row['subject'],0,60);
          $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status',  'dt' => 'status', 'field' => 'status' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'et.records_location',  'dt' => 'records_location', 'field' => 'records_location' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          $sub=substr($row['remarks'],0,60);
          $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $remarks;
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
    $this->db->close();
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
          $sub=substr($row['subject'],0,60);
          $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          $sub=substr($row['remarks'],0,60);
          $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $remarks;
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
    $this->db->close();
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
          $sub=substr($row['subject'],0,60);
          $subject = "<span title='".htmlspecialchars(stripslashes($row['subject']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $subject;
        }),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'et.receive',  'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'et.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'et.action_taken',  'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'et.sender_name',  'dt' => 'sender_name', 'field' => 'sender_name' ),
        array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
          $sub=substr($row['remarks'],0,60);
          $remarks = "<span title='".htmlspecialchars(stripslashes($row['remarks']))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          return $remarks;
        }),
        array( 'db' => 'et.start_date',  'dt' => 'start_date', 'field' => 'start_date' ),
        array( 'db' => 'et.tag_doc_type',  'dt' => 'tag_doc_type', 'field' => 'tag_doc_type' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_transactions AS et';
     $extraWhere = 'et.route_order != 0 AND et.status != 0 AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) ';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();

  }

  function dar()
  {
    /*
     * @license MIT - http://datatables.net/license_mit
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $user_func = $this->input->post('user_func');
    $data = array(
      'date' => date("Y-m-d"),
    );

    // SQL server connection information
    $sql_details = $this->sql_details;

    // DB table to use
    $table = "er_transactions";

    // Table's primary key
    $primaryKey = 'trans_no';

    $columns = array(
        array( 'db' => 'ad.dar_id', 'dt' => 'dar_id', 'field' => 'dar_id' ),
        array( 'db' => 'ad.user_token', 'dt' => 'user_token', 'field' => 'user_token' ),
        array( 'db' => 'ac.fname', 'dt' => 'fname', 'field' => 'fname' ),
        array( 'db' => 'ac.mname', 'dt' => 'mname', 'field' => 'mname' ),
        array( 'db' => 'ac.sname', 'dt' => 'sname', 'field' => 'sname' ),
        array( 'db' => 'ac.suffix', 'dt' => 'suffix', 'field' => 'suffix' ),
        array( 'db' => 'ac.suffix', 'dt' => 'full_name', 'field' => 'suffix', 'formatter' => function($x, $row) {
          $mname = ' ';
          if($row['mname']) {
            $mname = ' '.$row['mname'][0].'. ';
          }
          $suffix = '';
          if($row['suffix']) {
            $suffix = ', '.$row['suffix'][0];
          }
          return ucwords($row['fname'].$mname.$row['sname'].$suffix);
        }),
        array( 'db' => 'ac.division', 'dt' => 'division', 'field' => 'division' ),
        array( 'db' => 'ac.section', 'dt' => 'section', 'field' => 'section', 'formatter' => function($x, $row) {
          return !empty($row['section']) ? $row['section'] : '--';
        } ),
        array( 'db' => 'ad.action',  'dt' => 'action', 'field' => 'action' ),
        array( 'db' => 'et.trans_no',  'dt' => 'trans_no', 'field' => 'trans_no' ),
        array( 'db' => 'et.token',  'dt' => 'token', 'field' => 'token' ),
        array( 'db' => 'et.multiprc',  'dt' => 'multiprc', 'field' => 'multiprc' ),
        array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'ad.date_in',  'dt' => 'date_in', 'field' => 'date_in', 'formatter' => function($x, $row) {
          return !empty($x) ? date("F j, Y, g:i a", strtotime($x)) : '--';
        }),
    );
    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM acc_dar ad JOIN acc_credentials ac ON (ad.user_token = ac.token) JOIN er_transactions et ON (ad.trans_no = et.trans_no)';
    $extraWhere = 'DATE(ad.date_in) = "'.$data['date'].'" ';

    $extraWhere .= ($user_func['func'] == 'Director') ? '' : 'AND ac.region = "'.$user_region.'"';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();

  }

  function pab_view()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    // MAKA ERROR ( OR et.region = "'.$user_region.'" )
    // AND et.type = 117 AND et.system = 15 AND etl_sent.sender_divno =2
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND (et.type = 21 OR et.system = 17) AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function deleted_trans()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status = 0  AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function rec_publish()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type IN(12, 78, 79)  AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function publish_mc()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type = 78 AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function publish_so()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type = 12 AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function publish_dao()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type = 79 AND ( et.receiver_region LIKE "%'.$user_region.'%" OR et.region LIKE "%'.$user_region.'%" ) AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function tracker()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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
        return $remarks = "<span title='".$row['remarks']."'>".substr($row['remarks'],0,60)."..."."</span>";
      }),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';

    // MAKA ERROR ( OR et.region = "'.$user_region.'" )
    // AND et.type = 117 AND et.system = 15 AND etl_sent.sender_divno =2
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND '.$filter.' 1';

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function confidential()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
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

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") JOIN (SELECT etl1.trans_no FROM er_transactions_log AS etl1 WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no) AS etl ON (etl.trans_no = et.trans_no) ';

    // $extraWhere = 'et.route_order != 0 AND et.status != 0 AND '.$filter.' 1';

    // $joinQuery = 'FROM er_transactions AS et JOIN (SELECT * FROM er_transactions_log etl1 WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no ) AS etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") ';
    //
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.tag_doc_type = 1 AND ( et.type != 21 AND et.system != 17 ) AND '.$filter.' 1';

    $groupBy = 'et.trans_no';
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function add_trans_company()
  {
    // Custom PHP includes
    $region = $this->input->post('region');
    // $filter = $this->input->post('filter');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "dms_company";
    // Table's primary key
    $primaryKey = 'cnt';

    $columns = array(
      array( 'db' => 'dc.cnt', 'dt' => 'cnt', 'field' => 'cnt' ),
      array( 'db' => 'dc.token', 'dt' => 'token', 'field' => 'token' ),
      array( 'db' => 'dc.emb_id',  'dt' => 'emb_id', 'field' => 'emb_id'),
      array( 'db' => 'dc.company_name',  'dt' => 'company_name', 'field' => 'company_name' ),
      array( 'db' => 'dc.establishment_name', 'dt' => 'establishment_name', 'field' => 'establishment_name' ),
      array( 'db' => 'dc.house_no',  'dt' => 'house_no', 'field' => 'house_no' ),
      array( 'db' => 'dc.street',  'dt' => 'street', 'field' => 'street' ),
      array( 'db' => 'dc.barangay_name',  'dt' => 'barangay_name', 'field' => 'barangay_name' ),
      array( 'db' => 'dc.city_name',  'dt' => 'city_name', 'field' => 'city_name' ),
      array( 'db' => 'dc.province_name',  'dt' => 'province_name', 'field' => 'province_name' ),
      array( 'db' => 'dc.region_name',  'dt' => 'region_name', 'field' => 'region_name' ),
      array( 'db' => 'dc.region_name',  'dt' => 'location', 'field' => 'region_name', 'formatter' => function($x, $row) {
        $location = $row['house_no'].' '.$row['street'].' '.$row['barangay_name'].' '.$row['city_name'].' '.$row['province_name'].' '.$row['region_name'];
        return $location;
      } ),
      array( 'db' => 'dc.project_name',  'dt' => 'project_name', 'field' => 'project_name', 'formatter' => function($x, $row) {
        $proj=substr($row['project_name'],0,60);
        $project_name = "<span title='".htmlspecialchars(stripslashes($row['project_name']))."'>".htmlspecialchars(stripslashes($proj))."..."."</span>";
        return $project_name;
      }),
    );
    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM dms_company dc';
    $extraWhere = 'dc.deleted = 0';
    if(!empty($region))
    {
      $extraWhere = 'dc.deleted = 0 AND dc.region_name ="'.$region.'"';
    }
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function view_transaction()
  {
    $this->load->view('modals/view_transaction.php');
  }
}
