<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Data_Tables extends CI_Controller
  {
    private $sql_details;
    private $univdata = '';

    function __construct()
    {
      parent::__construct();

      $this->load->model('Embismodel');
      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('encrypt');

      $this->sql_details = array(
         'user' => $this->session->userdata('user'),
         'pass' => $this->session->userdata('pass'),
         'db'   => $this->session->userdata('db'),
         'host' => $this->session->userdata('host'),
       );

      date_default_timezone_set("Asia/Manila");
    }

    function getGlobData() {

    }

    function permitting()
    {
        /*
         * @license MIT - http://datatables.net/license_mit
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         */

       // SQL server connection information
       $sql_details = $this->sql_details;

       // DB table to use
       $table = "dms_universe";

       // Table's primary key
       $primaryKey = 'company_id';

      $columns = array(
          array('db' => '`du`.`company_id`', 'dt' => 'company_id', 'field' => 'company_id'),
          array('db' => '`du`.`company_name`', 'dt' => 'company_name', 'field' => 'company_name'),
          array('db' => '`du`.`company_id`', 'dt' => 'enc_compid', 'field' => 'company_id', 'formatter' => function($x, $row){
            return $this->encrypt->encode($row['company_id']);
          }),
          array('db' => '`du`.`address`', 'dt' => 'address', 'field' => 'address'),
          array('db' => '`du`.`project_type`', 'dt' => 'project_type', 'field' => 'project_type'),
          array('db' => '`du`.`status`', 'dt' => 'status', 'field' => 'status'),

          array('db' => '`du`.`ecc`', 'dt' => 'ecc', 'field' => 'ecc'  ),
          array('db' => '`du`.`cnc`', 'dt' => 'cnc', 'field' => 'cnc' ),
          array('db' => '`du`.`luc`', 'dt' => 'luc', 'field' => 'luc' ),
          array('db' => '`du`.`dp`', 'dt' => 'dp', 'field' => 'dp' ),
          array('db' => '`du`.`po`', 'dt' => 'po', 'field' => 'po' ),
          array('db' => '`du`.`pco`', 'dt' => 'pco', 'field' => 'pco'  ),
          array('db' => '`du`.`sqi`', 'dt' => 'sqi', 'field' => 'sqi' ),
          array('db' => '`du`.`piccs`', 'dt' => 'piccs', 'field' => 'piccs' ),
          array('db' => '`du`.`ccoic`', 'dt' => 'ccoic', 'field' => 'ccoic' ),
          array('db' => '`du`.`ccoreg`', 'dt' => 'ccoreg', 'field' => 'ccoreg' ),
          array('db' => '`du`.`cot`', 'dt' => 'cot', 'field' => 'cot'  ),
          array('db' => '`du`.`mnfst`', 'dt' => 'mnfst', 'field' => 'mnfst' ),
          array('db' => '`du`.`ptt`', 'dt' => 'ptt', 'field' => 'ptt' ),
          array('db' => '`du`.`tsd`', 'dt' => 'tsd', 'field' => 'tsd' ),
          array('db' => '`du`.`hwgen`', 'dt' => 'hwgen', 'field' => 'hwgen' ),
          array('db' => '`du`.`trc`', 'dt' => 'trc', 'field' => 'trc' ),
      );

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = "FROM dms_universe AS du ";
      $extraWhere = "";
      $groupBy = null;
      $having = null;

      echo json_encode(
          SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
      );
      $this->db->close();
    }

    function monitoring()
    {
        /*
         * @license MIT - http://datatables.net/license_mit
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         */

       // SQL server connection information
       $sql_details = $this->sql_details;

       // DB table to use
       $table = "dms_universe";

       // Table's primary key
       $primaryKey = 'company_id';

      $columns = array(
          array('db' => '`du`.`company_id`', 'dt' => 'company_id', 'field' => 'company_id'),
          array('db' => '`du`.`company_name`', 'dt' => 'company_name', 'field' => 'company_name'),
          array('db' => '`du`.`address`', 'dt' => 'address', 'field' => 'address'),
          array('db' => '`du`.`project_type`', 'dt' => 'project_type', 'field' => 'project_type'),
          array('db' => '`du`.`status`', 'dt' => 'status', 'field' => 'status'),

          array('db' => '`du`.`ecc`', 'dt' => 'ecc', 'field' => 'ecc'  ),
          array('db' => '`du`.`cnc`', 'dt' => 'cnc', 'field' => 'cnc' ),
          array('db' => '`du`.`luc`', 'dt' => 'luc', 'field' => 'luc' ),
          array('db' => '`du`.`dp`', 'dt' => 'dp', 'field' => 'dp' ),
          array('db' => '`du`.`po`', 'dt' => 'po', 'field' => 'po' ),
          array('db' => '`du`.`pco`', 'dt' => 'pco', 'field' => 'pco'  ),
          array('db' => '`du`.`sqi`', 'dt' => 'sqi', 'field' => 'sqi' ),
          array('db' => '`du`.`piccs`', 'dt' => 'piccs', 'field' => 'piccs' ),
          array('db' => '`du`.`ccoic`', 'dt' => 'ccoic', 'field' => 'ccoic' ),
          array('db' => '`du`.`ccoreg`', 'dt' => 'ccoreg', 'field' => 'ccoreg' ),
          array('db' => '`du`.`cot`', 'dt' => 'cot', 'field' => 'cot'  ),
          array('db' => '`du`.`mnfst`', 'dt' => 'mnfst', 'field' => 'mnfst' ),
          array('db' => '`du`.`ptt`', 'dt' => 'ptt', 'field' => 'ptt' ),
          array('db' => '`du`.`tsd`', 'dt' => 'tsd', 'field' => 'tsd' ),
          array('db' => '`du`.`hwgen`', 'dt' => 'hwgen', 'field' => 'hwgen' ),
          array('db' => '`du`.`trc`', 'dt' => 'trc', 'field' => 'trc' ),
      );

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = "FROM dms_universe AS du ";
      $extraWhere = "";
      $groupBy = null;
      $having = null;

      echo json_encode(
          SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
      );
      $this->db->close();
    }

    function accomp_all()
    {
      // Custom PHP includes
      $ufunc = $this->input->post('ufunc');
      // $user_func = $this->input->post('user_func');
      $filter = $this->session->userdata('accomp_filter');
      // echo '<pre>';
      // print_r($filter);
      $where['cred'] = array(
        'ac.token'    => $this->session->userdata('token'),
        'ac.verified' => 1
      );
      $globvar['cred'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred']);

      $where['func'] = array(
        'af.userid' => $this->session->userdata('userid'),
        'af.stat'   => 1
      );
      $globvar['func'] = $this->Embismodel->selectdata('acc_function AS af', '', $where['func']);

      // GET SELECTED FUNCTION
      if(!empty($ufunc)) {
        $globvar['func'] = $this->Embismodel->selectdata( 'acc_function AS af', '*', array('af.userid' => $this->session->userdata('userid'), 'af.stat' => 1, 'af.cnt' => $ufunc ) );
      }

      $univdata = array(
        'user_cred'   => $globvar['cred'][0],
        'user_func'   => $globvar['func'],
      );

      $data = array(
        'date' => date("Y-m-d"),
      );

      // SQL server connection information
      $sql_details = $this->sql_details;

      // DB table to use
      $table = "er_transactions_log";

      // Table's primary key
      $primaryKey = 'trans_no';

      $columns = array(
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
          array( 'db' => 'ac.region', 'dt' => 'region', 'field' => 'region' ),
          array( 'db' => 'ac.division', 'dt' => 'division', 'field' => 'division' ),
          array( 'db' => 'ac.section', 'dt' => 'section', 'field' => 'section', 'formatter' => function($x, $row) {
            return !empty($row['section']) ? $row['section'] : '--';
          } ),
          array( 'db' => 'etl.status_description',  'dt' => 'status_description', 'field' => 'status_description' ),
          array( 'db' => 'etl.trans_no',  'dt' => 'trans_no', 'field' => 'trans_no' ),
          array( 'db' => 'et.token',  'dt' => 'token', 'field' => 'token' ),
          array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject' ),
          array( 'db' => 'et.multiprc',  'dt' => 'multiprc', 'field' => 'multiprc' ),
          array( 'db' => 'et.type_description',  'dt' => 'type_description', 'field' => 'type_description' ),
          array( 'db' => 'etl.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row) {
            return !empty($x) ? date("F j, Y, g:i a", strtotime($x)) : '--';
          }),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM er_transactions_log etl JOIN er_transactions et ON (et.trans_no = etl.trans_no) JOIN acc_credentials ac ON (ac.token = etl.sender_id)';

      $extraWhere = 'et.route_order != 0 AND ';

      if(!empty($filter['region'])) {
        $extraWhere .= '(ac.region = "'.$filter['region'].'") AND ';
      }
      if(!empty($filter['division'])) {
        $extraWhere .= '(ac.divno = "'.$filter['division'].'") AND ';
      }
      if(!empty($filter['section'])) {
        $extraWhere .= '(ac.secno = "'.$filter['section'].'") AND ';
      }

      if(!empty($filter['start_date']) && !empty($filter['end_date'])) {
        $extraWhere .= '(etl.date_out BETWEEN "'.$filter['start_date'].'" AND "'.$filter['end_date'].'") AND ';
      }
      else {
        // $extraWhere .= 'DATE(etl.date_in) = "'.$data['date'].'" AND ';
        $extraWhere .= 'DATE(etl.date_out) = "'.$data['date'].'" AND ';
      }

      switch ($univdata['user_func'][0]['func']) {
        case 'Administrator':
        case 'Director':
        case 'Assistant Director':
          $extraWhere .= '1';
          break;

        case 'Regional Director':
          $extraWhere .= '(ac.region = "'.$univdata['user_cred']['region'].'")';
          break;

        case 'Division Chief':
        case 'Assistant Division Chief':
          $extraWhere .= 'ac.region = "'.$univdata['user_cred']['region'].'" AND ac.divno = '.$univdata['user_cred']['divno'].'';
          break;

        case 'Section Chief':
        case 'Unit Chief':
        case 'Assistant Section Chief':
          $extraWhere .= 'ac.region = "'.$univdata['user_func'][0]['region'].'" AND ac.divno = "'.$univdata['user_func'][0]['divno'].'" AND ac.secno = "'.$univdata['user_func'][0]['secno'].'"';
          break;

        default:
          if(in_array($univdata['user_cred']['userid'], array('51', '125', '111')) || $this->session->userdata('universe_admin') == "yes") {
              $extraWhere .= '1';
          }
          else {
            $extraWhere .= 'ac.token = "'.$univdata['user_cred']['token'].'" ';
          }
          break;
      }
      // echo $extraWhere;

      $groupBy = null;
      $having = null;
      // echo $this->db->last_query();

      echo json_encode(
          SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );

    }

    function user_logs()
    {
      // Custom PHP includes
      // $user_region = $this->input->post('user_region');
      // $user_func = $this->input->post('user_func');
      $filter = $this->session->userdata('accomp_filter');
      // echo '<pre>';
      // print_r($filter);
      $where['cred'] = array(
        'ac.token'    => $this->session->userdata('token'),
        'ac.verified' => 1
      );
      $globvar['cred'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred']);

      $where['func'] = array(
        'af.userid' => $this->session->userdata('userid'),
        'af.stat'   => 1
      );
      $globvar['func'] = $this->Embismodel->selectdata('acc_function AS af', '', $where['func']);

      $univdata = array(
        'user_cred'   => $globvar['cred'][0],
        'user_func'   => $globvar['func'],
      );

      $data = array(
        'date' => date("Y-m-d"),
      );

      // SQL server connection information
      $sql_details = $this->sql_details;

      // DB table to use
      $table = "acc_credentials";

      // Table's primary key
      $primaryKey = 'userid';

      $columns = array(
          array( 'db' => 'ac.title', 'dt' => 'title', 'field' => 'title' ),
          array( 'db' => 'ac.fname', 'dt' => 'fname', 'field' => 'fname' ),
          array( 'db' => 'ac.mname', 'dt' => 'mname', 'field' => 'mname' ),
          array( 'db' => 'ac.sname', 'dt' => 'sname', 'field' => 'sname' ),
          array( 'db' => 'ac.suffix', 'dt' => 'suffix', 'field' => 'suffix' ),
          array( 'db' => 'ac.region', 'dt' => 'region', 'field' => 'region' ),
          array( 'db' => 'al.log_date',  'dt' => 'log_date', 'field' => 'log_date', 'formatter' => function($x, $row) {
            return !empty($x) ? date("F j, Y, g:i a", strtotime($x)) : '--';
          }),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM acc_credentials ac JOIN (SELECT als.userid, als.log_date FROM acc_logs als WHERE als.log_stat = 0 GROUP BY als.userid, CAST(als.log_date AS DATE) ORDER BY als.log_date ASC) al ON (ac.userid = al.userid)';

      $extraWhere = 'ac.userid != 1 AND ac.verified = 1 AND ';

      if(!empty($filter['region'])) {
        $extraWhere .= '(ac.region = "'.$filter['region'].'") AND ';
      }
      if(!empty($filter['division'])) {
        $extraWhere .= '(ac.divno = "'.$filter['division'].'") AND ';
      }
      if(!empty($filter['section'])) {
        $extraWhere .= '(ac.secno = "'.$filter['section'].'") AND ';
      }

      if(!empty($filter['start_date']) && !empty($filter['end_date'])) {
        $extraWhere .= '(al.log_date BETWEEN "'.$filter['start_date'].'" AND "'.$filter['end_date'].'") AND ';
      }
      else {
        $extraWhere .= 'DATE(al.log_date) = "'.$data['date'].'" AND ';
      }

      switch ($univdata['user_func'][0]['func']) {
        case 'Administrator':
        case 'Director':
        case 'Assistant Director':
          $extraWhere .= '1';
          break;

        // case 'Regional Director':
        //   $extraWhere .= '(ac.region = "'.$univdata['user_cred']['region'].'")';
        //   break;
        //
        // case 'Division Chief':
        // case 'Assistant Division Chief':
        //   $extraWhere .= 'ac.region = "'.$univdata['user_cred']['region'].'" AND ac.divno = '.$univdata['user_cred']['divno'].'';
        //   break;
        //
        // case 'Section Chief':
        // case 'Assistant Section Chief':
        //   $extraWhere .= 'ac.region = "'.$univdata['user_cred']['region'].'" AND ac.divno = "'.$univdata['user_cred']['divno'].'" AND ac.secno = '.$univdata['user_cred']['secno'].'';
        //   break;
        //
        default:
          if(in_array($univdata['user_cred']['userid'], array('51', '125', '111')) || $this->session->userdata('universe_admin') == "yes") {
              $extraWhere .= '1';
          }
          else {
            $extraWhere .= '(ac.region = "'.$univdata['user_cred']['region'].'")';
          }
          break;
      }

      $groupBy = null;
      $having = null;
      // echo $this->db->last_query();

      echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );

    }

    function dms_monitoring()
    {
      // Custom PHP includes
      $user_region = $this->input->post('user_region');
      // $filter = $this->session->userdata('accomp_filter');

      // SQL server connection information
      $sql_details = $this->sql_details;

      // DB table to use
      $table = "acc_credentials";

      // Table's primary key
      $primaryKey = 'userid';

      $columns = array(
          array( 'db' => 'ac.token', 'dt' => 'token', 'field' => 'token' ),
          array( 'db' => 'ac.title', 'dt' => 'title', 'field' => 'title' ),
          array( 'db' => 'ac.fname', 'dt' => 'fname', 'field' => 'fname' ),
          array( 'db' => 'ac.mname', 'dt' => 'mname', 'field' => 'mname' ),
          array( 'db' => 'ac.sname', 'dt' => 'sname', 'field' => 'sname' ),
          array( 'db' => 'ac.suffix', 'dt' => 'suffix', 'field' => 'suffix' ),
          array( 'db' => 'ac.region', 'dt' => 'region', 'field' => 'region' ),
          array( 'db' => 'dinv.total',  'dt' => 'total', 'field' => 'total' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = 'FROM acc_credentials ac LEFT JOIN vw_dms_inbox_notif dinv ON (ac.userid = dinv.userid)';

      $extraWhere = 'ac.userid != 1 AND ac.verified = 1 AND ac.region = "'.$user_region.'"';

      $groupBy = null;
      $having = null;

      echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
    }

    function inbox_monitoring_userlist()
    {
      // Custom PHP includes
      $user_token = $this->input->post('token');
      // $filter = $this->session->userdata('accomp_filter');

      // SQL server connection information
      $sql_details = $this->sql_details;

      // DB table to use
      $table = "vw_dms_inbox_table5";

      // Table's primary key
      $primaryKey = 'trans_no';

      $columns = array(
          array( 'db' => 'vw.token', 'dt' => 'token', 'field' => 'token' ),
          array( 'db' => 'vw.subject', 'dt' => 'subject', 'field' => 'subject', 'formatter' => function($d, $row) {
            $sub = substr($d, 0, 60);
            return "<span title='".htmlspecialchars(stripslashes($d))."'>".htmlspecialchars(stripslashes($sub))."..."."</span>";
          } ),
          array( 'db' => 'vw.type_description', 'dt' => 'type_description', 'field' => 'type_description' ),
          array( 'db' => 'vw.status_description', 'dt' => 'status_description', 'field' => 'status_description' ),
          array( 'db' => 'etl.date_out', 'dt' => 'date_out', 'field' => 'date_out' ),
      );
      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery = "FROM vw_dms_inbox_table5 vw JOIN er_transactions_log etl ON (etl.trans_no = vw.trans_no AND etl.route_order = vw.route_order AND etl.multi_cntr = vw.multi_cntr AND etl.main_multi_cntr = vw.main_multi_cntr )";
      $extraWhere = 'vw.route_order != 0 AND vw.status NOT IN(0, 24, 18, 19) AND vw.receiver_id = "'.$user_token.'" AND vw.multiprc != 1 AND vw.type NOT IN (83, 51)';
      $groupBy = null;
      $having = null;

      echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      $this->db->close();
    }
  }
?>
