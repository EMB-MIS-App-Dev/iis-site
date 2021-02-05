<?php

class Data_Tables extends CI_Controller
{
  private $sql_details;
  private $dtdata;

  function __construct()
  {
    parent::__construct();

    $this->load->model('Embismodel');
    $this->load->library('encryption');

    $this->sql_details = array(
       'user' => $this->session->userdata('user'),
       'pass' => $this->session->userdata('pass'),
       'db'   => $this->session->userdata('db'),
       'host' => $this->session->userdata('host'),
     );

     $this->dtdata['user'] = array(
       'id'      => $this->session->userdata('userid'),
       'token'   => $this->session->userdata('token'),
       'region'  => $this->session->userdata('region'),
       'secno'   => $this->session->userdata('secno'),
       'divno'   => $this->session->userdata('divno'),
     );

    // Datatables Custom Views
    $this->load->view('Dms/func/datecount.php');
  }

  function data_test()
  {
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "er_systems";
    // Table's primary key
    $primaryKey = 'id';

    $columns = array(
      array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
      array( 'db' => 'system_code', 'dt' => 'system_code', 'field' => 'system_code' ),
      array( 'db' => 'name', 'dt' => 'name', 'field' => 'name' ),
      array( 'db' => 'system_order',  'dt' => 'system_order', 'field' => 'system_order' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_systems ';
    $extraWhere = null;
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function system()
  {
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "er_systems";
    // Table's primary key
    $primaryKey = 'id';

    $columns = array(
      array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
      array( 'db' => 'system_code', 'dt' => 'system_code', 'field' => 'system_code' ),
      array( 'db' => 'name', 'dt' => 'name', 'field' => 'name' ),
      array( 'db' => 'system_order',  'dt' => 'system_order', 'field' => 'system_order' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_systems ';
    $extraWhere = null;
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function sub_system()
  {
    // Custom PHP includes
    $sysid = $this->input->post('sysid');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "er_type";
    // Table's primary key
    $primaryKey = 'id';

    $columns = array(
      array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
      array( 'db' => 'name', 'dt' => 'name', 'field' => 'name' ),
      array( 'db' => 'header', 'dt' => 'header', 'field' => 'header' ),
      array( 'db' => 'sysid',  'dt' => 'sysid', 'field' => 'sysid' ),
      array( 'db' => 'ssysid',  'dt' => 'ssysid', 'field' => 'ssysid' ),
      array( 'db' => 'sys_show',  'dt' => 'sys_show', 'field' => 'sys_show' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_type';
    $extraWhere = (!empty($sysid)) ? 'sysid = '.$sysid : '';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function subsys_types()
  {
    $ssysid = $this->input->post('ssysid');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "er_sub_type";
    // Table's primary key
    $primaryKey = 'id';

    $columns = array(
      array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
      array( 'db' => 'dsc', 'dt' => 'dsc', 'field' => 'dsc' ),
      array( 'db' => 'title', 'dt' => 'title', 'field' => 'title' ),
      array( 'db' => 'header', 'dt' => 'header', 'field' => 'header' ),
      array( 'db' => 'sysid',  'dt' => 'sysid', 'field' => 'sysid' ),
      array( 'db' => 'ssysid',  'dt' => 'ssysid', 'field' => 'ssysid' ),
      array( 'db' => 'subcat1',  'dt' => 'subcat1', 'field' => 'subcat1' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM er_sub_type';
    $extraWhere = (!empty($ssysid)) ? 'ssysid = '.$ssysid : '';
    $groupBy = null;
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

    $joinQuery = 'FROM er_transactions et JOIN er_transactions_log etl_sent ON (etl_sent.trans_no = et.trans_no AND etl_sent.route_order = et.route_order AND etl_sent.main_multi_cntr = "") JOIN (SELECT etl1.trans_no FROM er_transactions_log AS etl1 FORCE INDEX (dt_stat_ro_type_region_idx) WHERE etl1.sender_region = "'.$user_region.'" OR etl1.receiver_region = "'.$user_region.'" GROUP BY etl1.trans_no) AS etl ON (etl.trans_no = et.trans_no) ';

    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.tag_doc_type = 0 AND ( et.type != 21 AND et.system != 17 ) AND '.$filter.' 1';

    $groupBy = 'et.trans_no';
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
    $table = "vw_dms_inbox_table5";
    // Table's primary key
    $primaryKey = 'trans_no';

    $columns = array(
        array( 'db' => 'vw.trans_no', 'dt' => 'enc_tkey', 'field' => 'trans_no', 'formatter' => function($d, $row) {
          $encrypty = $row['entry'].';'.$d.';'.$row['main_multi_cntr'].';'.$row['multi_cntr'].';'.$row['route_order'];
          return $this->encrypt->encode($encrypty);
        } ),
        array( 'db' => 'vw.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no'),
        array( 'db' => 'vw.token', 'dt' => 'token', 'field' => 'token'),
        array( 'db' => 'vw.entry', 'dt' => 'entry', 'field' => 'entry'),
        array( 'db' => 'vw.route_order', 'dt' => 'route_order', 'field' => 'route_order' ),
        array( 'db' => 'vw.main_multi_cntr', 'dt' => 'main_multi_cntr', 'field' => 'main_multi_cntr' ),
        array( 'db' => 'vw.multiprc', 'dt' => 'multiprc' ),
        array( 'db' => 'vw.company_name', 'dt' => 'company_name', 'field' => 'company_name', 'formatter' => function($d, $row) {
          return htmlspecialchars(stripslashes($d));
        } ),
        array( 'db' => 'vw.emb_id', 'dt' => 'emb_id', 'field' => 'emb_id', 'formatter' => function($d, $row) {
          return htmlspecialchars(stripslashes($d));
        } ),
        array( 'db' => 'vw.subject', 'dt' => 'subject', 'field' => 'subject', 'formatter' => function($d, $row) {
          $sub = substr($d, 0, 60);
          return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        } ),
        // array( 'db' => 'vw.type', 'dt' => 'type', 'field' => 'type' ),
        array( 'db' => 'vw.type_description', 'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'vw.receive', 'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'vw.status_description', 'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'vw.action_taken', 'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'etl.date_out', 'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($d, $row){
          return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y, g:i a", strtotime($d)) : '--';
        } ),
        array( 'db' => 'etl.sender_name', 'dt' => 'sender_name', 'field' => 'sender_name', 'formatter' => function($d, $row){
          return (!empty($d)) ? $d : '--';
        } ),
        array( 'db' => 'vw.remarks', 'dt' => 'remarks', 'field' => 'remarks', 'formatter' => function($d, $row) {
          $sub = substr($d, 0, 60);
          return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        } ),
        array( 'db' => 'vw.multi_cntr', 'dt' => 'multi_cntr', 'field' => 'multi_cntr' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');
    // AND etl.main_route_order = vw.main_route_order
    $joinQuery = "FROM vw_dms_inbox_table5 vw JOIN er_transactions_log etl ON (etl.trans_no = vw.trans_no AND etl.route_order = vw.route_order AND etl.multi_cntr = vw.multi_cntr AND etl.main_multi_cntr = vw.main_multi_cntr )";
    $extraWhere = 'vw.route_order != 0 AND vw.status NOT IN(0, 24, 18, 19) AND vw.receiver_id = "'.$user_token.'" AND vw.multiprc != 1 AND vw.type NOT IN (83, 51)';
    $groupBy = null;
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
    $extraWhere = 'et.route_order = 0 AND et.sender_id LIKE "%'.$user_token.'%" AND et.region LIKE "%'.$user_region.'%" AND et.deleted != 1 ';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();

  }

  function planning_monreport()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "dms_company";
    // Table's primary key
    $primaryKey = 'emb_id';

    $columns = array(
      array( 'db' => 'dc.company_name', 'dt' => 'company_name', 'field' => 'company_name' ),
      array( 'db' => 'dc.emb_id', 'dt' => 'emb_id', 'field' => 'emb_id' ),
      array( 'db' => 'dc.psi_code_no', 'dt' => 'psi_code_no', 'field' => 'psi_code_no' ),
      array( 'db' => 'dc.project_name', 'dt' => 'full_project_name', 'field' => 'project_name' ),
      array( 'db' => 'dc.project_name', 'dt' => 'project_name', 'field' => 'project_name', 'formatter' => function($d, $row) {
        $sub = substr($d, 0, 60);
        return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
      }  ),
      array( 'db' => 'dc.barangay_name', 'dt' => 'barangay_name', 'field' => 'barangay_name' ),
      array( 'db' => 'dc.city_name', 'dt' => 'city_name', 'field' => 'city_name' ),
      array( 'db' => 'dc.province_name', 'dt' => 'province_name', 'field' => 'province_name' ),
      array( 'db' => 'dc.longitude', 'dt' => 'longitude', 'field' => 'longitude' ),
      array( 'db' => 'dc.latitude', 'dt' => 'latitude', 'field' => 'latitude' ),
      array( 'db' => 'et.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
      array( 'db' => 'et.token', 'dt' => 'token', 'field' => 'token' ),
      array( 'db' => 'et.subject', 'dt' => 'subject', 'field' => 'subject', 'formatter' => function($d, $row) {
        // $sub = substr($d, 0, 60);
        return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($d))."..."."</span>";
      }  ),
      array( 'db' => 'et.start_date', 'dt' => 'start_date', 'field' => 'start_date', 'formatter' => function($d, $row){
        return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y", strtotime($d)) : '--';
      }  ),
      array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks' ),
      array( 'db' => 'et.status', 'dt' => 'status', 'field' => 'status' ),
      array( 'db' => 'et.status_description', 'dt' => 'status_description', 'field' => 'status_description' ),
      array( 'db' => 'et.action_taken', 'dt' => 'action_taken', 'field' => 'action_taken' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM dms_company dc JOIN (SELECT et1.company_token, et1.company_name, et1.trans_no, et1.token, et1.start_date, et1.subject, et1.action_taken, et1.remarks, et1.status, et1.status_description FROM er_transactions et1 WHERE et1.system = 5 GROUP BY et1.company_token ORDER BY et1.start_date DESC) AS et ON (et.company_token = dc.token) ';

    $extraWhere='';
    if(!empty($start_date) && !empty(!empty($end_date))) {
      $extraWhere .= '(et.start_date BETWEEN "'.$start_date.'" AND "'.$end_date.'") AND ';
    }

    if ($this->dtdata['user']['region'] == 'CO') {
      $extraWhere .= 'dc.deleted = 0';
    }
    else {
      $extraWhere .= 'dc.deleted = 0 AND dc.region_name = "'.$this->dtdata['user']['region'].'"';
    }
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function planning_permreport()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "dms_company";
    // Table's primary key
    $primaryKey = 'emb_id';

    $columns = array(
      array( 'db' => 'dc.company_name', 'dt' => 'company_name', 'field' => 'company_name' ),
      array( 'db' => 'dc.emb_id', 'dt' => 'emb_id', 'field' => 'emb_id' ),
      array( 'db' => 'dc.psi_code_no', 'dt' => 'psi_code_no', 'field' => 'psi_code_no' ),
      array( 'db' => 'dc.project_name', 'dt' => 'full_project_name', 'field' => 'project_name' ),
      array( 'db' => 'dc.project_name', 'dt' => 'project_name', 'field' => 'project_name', 'formatter' => function($d, $row) {
        $sub = substr($d, 0, 60);
        return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
      }   ),
      array( 'db' => 'dc.barangay_name', 'dt' => 'barangay_name', 'field' => 'barangay_name' ),
      array( 'db' => 'dc.city_name', 'dt' => 'city_name', 'field' => 'city_name' ),
      array( 'db' => 'dc.province_name', 'dt' => 'province_name', 'field' => 'province_name' ),
      array( 'db' => 'dc.longitude', 'dt' => 'longitude', 'field' => 'longitude' ),
      array( 'db' => 'dc.latitude', 'dt' => 'latitude', 'field' => 'latitude' ),
      array( 'db' => 'et.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no' ),
      array( 'db' => 'et.token', 'dt' => 'token', 'field' => 'token' ),
      array( 'db' => 'et.type_description', 'dt' => 'type_description', 'field' => 'type_description' ),
      array( 'db' => 'esp.permit_no', 'dt' => 'permit_no', 'field' => 'permit_no' ),
      array( 'db' => 'etl_a.date_out', 'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($d, $row){
        return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y", strtotime($d)) : '--';
      } ),
      array( 'db' => 'et.subject', 'dt' => 'subject', 'field' => 'subject', 'formatter' => function($d, $row) {
        // $sub = substr($d, 0, 60);
        return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($d))."..."."</span>";
      }  ),
      array( 'db' => 'et.start_date', 'dt' => 'start_date', 'field' => 'start_date', 'formatter' => function($d, $row){
        return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y", strtotime($d)) : '--';
      }  ),
      array( 'db' => 'et.remarks', 'dt' => 'remarks', 'field' => 'remarks' ),
      array( 'db' => 'et.status', 'dt' => 'status', 'field' => 'status' ),
      array( 'db' => 'et.status_description', 'dt' => 'status_description', 'field' => 'status_description' ),
      array( 'db' => 'et.action_taken', 'dt' => 'action_taken', 'field' => 'action_taken' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    // er_transactions JOIN er_transactions_log(date_forwarded)
    $joinQuery = 'FROM dms_company dc JOIN (SELECT et1.company_token, et1.company_name, et1.trans_no, et1.token, et1.type, et1.type_description, et1.start_date, et1.subject, et1.action_taken, et1.remarks, et1.status, et1.status_description FROM er_transactions et1 WHERE et1.system = 4 GROUP BY et1.company_token ORDER BY et1.start_date DESC) AS et ON (et.company_token = dc.token) LEFT JOIN er_system_permit esp ON (esp.trans_no = et.trans_no AND esp.sub_system = et.type) LEFT JOIN (SELECT etl_a1.trans_no, etl_a1.date_out FROM er_transactions_log etl_a1 WHERE etl_a1.status IN (5, 24) GROUP BY etl_a1.trans_no ORDER BY etl_a1.date_out) etl_a ON (etl_a.trans_no = et.trans_no) ';

    $extraWhere='';
    if(!empty($start_date) && !empty(!empty($end_date))) {
      $extraWhere .= '(et.start_date BETWEEN "'.$start_date.'" AND "'.$end_date.'") AND ';
    }
    if($this->dtdata['user']['region'] == 'CO') {
      $extraWhere .= 'dc.deleted = 0';
    }
    else {
      $extraWhere .= 'dc.deleted = 0 AND dc.region_name = "'.$this->dtdata['user']['region'].'"';
    }

    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function file_transfer()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    $filter = $this->input->post('filter');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "dms_company";
    // Table's primary key
    $primaryKey = 'emb_id';

    $columns = array(
      array( 'db' => 'dc.company_name', 'dt' => 'company_name', 'field' => 'company_name', 'formatter' => function($d, $row) {
        return trim($d);
      } ),
      array( 'db' => 'dc.emb_id', 'dt' => 'emb_id', 'field' => 'emb_id' ),
      array( 'db' => 'dc.psi_code_no', 'dt' => 'psi_code_no', 'field' => 'psi_code_no', 'formatter' => function($d, $row) {
        return !empty($d) ? $d : '-';
      } ),
      array( 'db' => 'dc.project_name', 'dt' => 'project_name', 'field' => 'project_name', 'formatter' => function($d, $row) {
        $sub = substr($d, 0, 60);
        return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
      } ),
      array( 'db' => 'dc.barangay_name', 'dt' => 'barangay_name', 'field' => 'barangay_name' ),
      array( 'db' => 'dc.city_name', 'dt' => 'city_name', 'field' => 'city_name' ),
      array( 'db' => 'dc.province_name', 'dt' => 'province_name', 'field' => 'province_name' ),
      array( 'db' => 'dc.longitude', 'dt' => 'longitude', 'field' => 'longitude' ),
      array( 'db' => 'dc.latitude', 'dt' => 'latitude', 'field' => 'latitude' ),
      array( 'db' => 'et.tno_cnt', 'dt' => 'tno_cnt', 'field' => 'tno_cnt', 'formatter' => function($d, $row) {
        return !empty($d) ? $d : 0;
      } ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');

    $joinQuery = 'FROM dms_company dc LEFT JOIN (SELECT vw.company_token, COUNT(vw.trans_no) AS tno_cnt FROM vw_dms_inbox_table5 vw WHERE vw.status != 0 AND vw.multiprc != 1 AND vw.type NOT IN (83, 51) GROUP BY vw.company_token ) AS et ON (dc.token = et.company_token) ';

    $extraWhere = 'dc.deleted = 0 '; // $user_region
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

  function add_company()
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
      // array( 'db' => 'dc.project_name',  'dt' => 'project_fullname', 'field' => 'project_name'),
      array( 'db' => 'dc.project_name',  'dt' => 'project_name', 'field' => 'project_name', 'formatter' => function($d, $row) {
        return htmlspecialchars(stripslashes($d));
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

  function revisions()
  {
    // Custom PHP includes
    $user_region = $this->input->post('user_region');
    // SQL server connection information
    $sql_details = $this->sql_details;
    // DB table to use
    $table = "vw_dms_inbox_table5";
    // Table's primary key
    $primaryKey = 'trans_no';

    $columns = array(
        array( 'db' => 'vw.trans_no', 'dt' => 'enc_tkey', 'field' => 'trans_no', 'formatter' => function($d, $row) {
          $encrypty = $row['entry'].';'.$d.';'.$row['main_multi_cntr'].';'.$row['multi_cntr'].';'.$row['route_order'];
          return $this->encrypt->encode($encrypty);
        } ),
        array( 'db' => 'vw.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no'),
        array( 'db' => 'vw.token', 'dt' => 'token', 'field' => 'token'),
        array( 'db' => 'vw.entry', 'dt' => 'entry', 'field' => 'entry'),
        array( 'db' => 'vw.route_order', 'dt' => 'route_order', 'field' => 'route_order' ),
        array( 'db' => 'vw.main_multi_cntr', 'dt' => 'main_multi_cntr', 'field' => 'main_multi_cntr' ),
        array( 'db' => 'vw.multiprc', 'dt' => 'multiprc' ),
        array( 'db' => 'vw.company_name', 'dt' => 'company_name', 'field' => 'company_name', 'formatter' => function($d, $row) {
          return htmlspecialchars(stripslashes($d));
        } ),
        array( 'db' => 'vw.emb_id', 'dt' => 'emb_id', 'field' => 'emb_id', 'formatter' => function($d, $row) {
          return htmlspecialchars(stripslashes($d));
        } ),
        array( 'db' => 'vw.subject', 'dt' => 'subject', 'field' => 'subject', 'formatter' => function($d, $row) {
          $sub = substr($d, 0, 60);
          return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        } ),
        // array( 'db' => 'vw.type', 'dt' => 'type', 'field' => 'type' ),
        array( 'db' => 'vw.type_description', 'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'vw.receive', 'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'vw.status_description', 'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'vw.action_taken', 'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'etl.date_out', 'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($d, $row){
          return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y, g:i a", strtotime($d)) : '--';
        } ),
        array( 'db' => 'etl.sender_name', 'dt' => 'sender_name', 'field' => 'sender_name', 'formatter' => function($d, $row){
          return (!empty($d)) ? $d : '--';
        } ),
        array( 'db' => 'vw.remarks', 'dt' => 'remarks', 'field' => 'remarks', 'formatter' => function($d, $row) {
          $sub = substr($d, 0, 60);
          return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        } ),
        array( 'db' => 'vw.multi_cntr', 'dt' => 'multi_cntr', 'field' => 'multi_cntr' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');
    // AND etl.main_route_order = vw.main_route_order
    $joinQuery = "FROM vw_dms_inbox_table5 vw JOIN er_transactions_log etl ON (etl.trans_no = vw.trans_no AND etl.route_order = vw.route_order AND etl.multi_cntr = vw.multi_cntr AND etl.main_multi_cntr = vw.main_multi_cntr AND (etl.sender_region = '".$user_region."' OR etl.sender_region = '".$user_region."') )";
    $extraWhere = 'vw.route_order != 0 AND vw.multiprc != 1 AND vw.type NOT IN (83, 51)';
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

    $joinQuery = 'FROM er_transactions AS et JOIN (SELECT etl1.trans_no, etl1.route_order, etl1.date_out, etl1.sender_secno FROM er_transactions_log AS etl1) AS etl ON (etl.trans_no = et.trans_no AND etl.route_order = et.route_order)';
    $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type != 83 AND et.region LIKE "%'.$user_region.'%" AND (et.records_location != "" OR et.status = 24) AND etl.sender_secno IN (77, 166, 176, 195, 223, 231, 232, 235, 255, 27, 316) ';
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
    $table = "vw_dms_inbox_table5";
    // Table's primary key
    $primaryKey = 'trans_no';

    $columns = array(
        array( 'db' => 'vw.trans_no', 'dt' => 'enc_tkey', 'field' => 'trans_no', 'formatter' => function($d, $row) {
          $encrypty = $row['entry'].';'.$d.';'.$row['main_multi_cntr'].';'.$row['multi_cntr'].';'.$row['route_order'];
          return $this->encrypt->encode($encrypty);
        } ),
        array( 'db' => 'vw.trans_no', 'dt' => 'trans_no', 'field' => 'trans_no'),
        array( 'db' => 'vw.token', 'dt' => 'token', 'field' => 'token'),
        array( 'db' => 'vw.entry', 'dt' => 'entry', 'field' => 'entry'),
        array( 'db' => 'vw.route_order', 'dt' => 'route_order', 'field' => 'route_order' ),
        array( 'db' => 'vw.main_multi_cntr', 'dt' => 'main_multi_cntr', 'field' => 'main_multi_cntr' ),
        array( 'db' => 'vw.multiprc', 'dt' => 'multiprc' ),
        array( 'db' => 'vw.company_name', 'dt' => 'company_name', 'field' => 'company_name', 'formatter' => function($d, $row) {
          return htmlspecialchars(stripslashes($d));
        } ),
        array( 'db' => 'vw.emb_id', 'dt' => 'emb_id', 'field' => 'emb_id', 'formatter' => function($d, $row) {
          return htmlspecialchars(stripslashes($d));
        } ),
        array( 'db' => 'vw.subject', 'dt' => 'subject', 'field' => 'subject', 'formatter' => function($d, $row) {
          $sub = substr($d, 0, 60);
          return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        } ),
        // array( 'db' => 'vw.type', 'dt' => 'type', 'field' => 'type' ),
        array( 'db' => 'vw.type_description', 'dt' => 'type_description', 'field' => 'type_description' ),
        array( 'db' => 'vw.receive', 'dt' => 'receive', 'field' => 'receive' ),
        array( 'db' => 'vw.status_description', 'dt' => 'status_description', 'field' => 'status_description' ),
        array( 'db' => 'vw.action_taken', 'dt' => 'action_taken', 'field' => 'action_taken' ),
        array( 'db' => 'etl.date_out', 'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($d, $row){
          return ($d != '0000-00-00' && !empty($d)) ? date("F j, Y, g:i a", strtotime($d)) : '--';
        } ),
        array( 'db' => 'etl.sender_name', 'dt' => 'sender_name', 'field' => 'sender_name', 'formatter' => function($d, $row){
          return (!empty($d)) ? $d : '--';
        } ),
        array( 'db' => 'vw.remarks', 'dt' => 'remarks', 'field' => 'remarks', 'formatter' => function($d, $row) {
          $sub = substr($d, 0, 60);
          return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
        } ),
        array( 'db' => 'vw.multi_cntr', 'dt' => 'multi_cntr', 'field' => 'multi_cntr' ),
    );

    $this->load->view('includes/common/ssp.customized.class.php');
    // AND etl.main_route_order = vw.main_route_order
    $joinQuery = "FROM vw_dms_inbox_table5 vw JOIN er_transactions_log etl ON (etl.trans_no = vw.trans_no AND etl.route_order = vw.route_order AND etl.multi_cntr = vw.multi_cntr AND etl.main_multi_cntr = vw.main_multi_cntr )";
    $extraWhere = 'vw.route_order != 0 AND vw.status IN (18, 24) AND vw.sender_id = "'.$user_token.'" AND vw.multiprc != 1 AND vw.type NOT IN (83, 51)';
    $groupBy = null;
    $having = null;

    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
    );
    $this->db->close();
  }

   function migrate()
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

     $joinQuery = 'FROM er_transactions AS et JOIN (SELECT etl1.trans_no, etl1.route_order, etl1.date_out, etl1.sender_secno FROM er_transactions_log AS etl1) AS etl ON (etl.trans_no = et.trans_no AND etl.route_order = et.route_order)';
     $extraWhere = 'et.route_order != 0 AND et.status != 0 AND et.type != 83 AND et.region LIKE "%'.$user_region.'%" AND et.migrated = 1 ';
     $groupBy = null;
     $having = null;

     echo json_encode(
         SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
     );
     $this->db->close();
   }

}
