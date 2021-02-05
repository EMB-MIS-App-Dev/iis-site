<?php



defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 */

class Sweet_serverside extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');

  }

  public function index(){

      $region           = $this->session->userdata('region');
      $userid           = $this->session->userdata('userid');
      $usertoken        = $this->session->userdata('token');
      $lgu_name         = $this->input->post('lgu_name', TRUE);

      $lgu_id           = $this->input->post('lgu_patrolled_id', TRUE);

      $returned_report  = $this->input->post('returned_report', TRUE);
      $evaluator        = $this->input->post('evaluator', TRUE);
      $ch               = $this->encrypt->decode($this->input->post('ch', TRUE));
      $lgu              = $this->encrypt->decode($this->input->post('lgu', TRUE));
      $default          = ($this->input->post('df', TRUE));
      $regionfilter     = ($this->input->post('regionfilter', TRUE));

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="to_trans";

      // Table's primary key

      $primaryKey = 'er_no';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`sf`.`trans_no`', 'dt' => 'trans_no', 'field' => 'trans_no'),
                      array( 'db' => '`sf`.`trans_no`', 'dt' => 1, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['trans_no']);
                      }),
                      array( 'db' => '`sf`.`creator_name`', 'dt' => 'creator_name', 'field' => 'creator_name'),
                      array( 'db' => '`sf`.`report_type`', 'dt' => 'report_type', 'field' => 'report_type'),
                      array( 'db' => '`sf`.`date_created`', 'dt' => 'date_created', 'field' => 'date_created','formatter'=>function($x,$row){
                        return date("M d, Y", strtotime($row['date_created']));
                      }),
                      array( 'db' => '`sf`.`subject`', 'dt' => 'subject', 'field' => 'subject'),
                      array( 'db' => '`sf`.`date_patrolled`', 'dt' => 5, 'field' => 'date_patrolled'),
                      array( 'db' => '`sf`.`time_patrolled`', 'dt' => 'time_patrolled', 'field' => 'time_patrolled'),
                      array( 'db' => '`sf`.`date_patrolled`', 'dt' => 'date_patrolled', 'field' => 'date_patrolled','formatter'=>function($x,$row){
                        return date("M d, Y", strtotime($row['date_patrolled']))." - ".date("h:i a", strtotime($row['time_patrolled']));
                      }),
                      array( 'db' => '`sf`.`lgu_patrolled_name`', 'dt' => 'lgu_patrolled_name', 'field' => 'lgu_patrolled_name'),
                      array( 'db' => '`sf`.`barangay_name`', 'dt' => 'barangay_name', 'field' => 'barangay_name'),
                      array( 'db' => '`sf`.`violations_observed_desc`', 'dt' => 'violations_observed_desc', 'field' => 'violations_observed_desc','formatter'=>function($x,$row){
                        $vod = (!empty($row['violations_observed_desc'])) ? str_replace(";", ";<br>", $row['violations_observed_desc']) : "-";
                        return $vod;
                      }),
                      array( 'db' => '`sf`.`total_land_area`', 'dt' => 'total_land_area', 'field' => 'total_land_area'),
                      array( 'db' => '`sf`.`type_of_monitoring_desc`', 'dt' => 'type_of_monitoring_desc', 'field' => 'type_of_monitoring_desc'),
                      array( 'db' => '`sf`.`actions_undertaken_desc`', 'dt' => 'actions_undertaken_desc', 'field' => 'actions_undertaken_desc','formatter'=>function($x,$row){
                        $aud = (!empty($row['actions_undertaken_desc'])) ? str_replace("|", "<br>", $row['actions_undertaken_desc']) : "-";
                        return $aud;
                      }),
                      array( 'db' => '`sf`.`status`', 'dt' => 'status', 'field' => 'status'),
                      array( 'db' => '`sf`.`assigned_name`', 'dt' => 'assigned_name', 'field' => 'assigned_name','formatter'=>function($x,$row){
                        $assigned_name = (!empty(trim($row['assigned_name']))) ? $row['assigned_name'] : "-";
                        return $assigned_name;
                      }),
                      array( 'db' => '`et`.`status_description`', 'dt' => 'status_description', 'field' => 'status_description'),
                      array( 'db' => '`sf`.`report_number`', 'dt' => 'report_number', 'field' => 'report_number'),
                      array( 'db' => '`sf`.`report_number`', 'dt' => 19, 'field' => 'report_number','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['report_number']);
                      }),
                      array( 'db' => '`sf`.`feedback`', 'dt' => 'feedback', 'field' => 'feedback'),
                      array( 'db' => '`sf`.`feedback_seen`', 'dt' => 'feedback_seen', 'field' => 'feedback_seen'),
                      array( 'db' => '`sf`.`region`', 'dt' => 'region', 'field' => 'region'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`sweet_form` AS `sf` LEFT JOIN `embis`.`er_transactions` AS `et` ON `et`.`token`=`sf`.`trans_no`";
        if($_SESSION['sw_selectswemployee'] == 'yes'){
          if($returned_report == $userid){ //RETURNED REPORT
            $extraWhere = '`sf`.`region` = "'.$region.'" AND `et`.`status` != 0 AND `sf`.`userid` = "'.$userid.'" AND `sf`.`assigned_to` = "'.$returned_report.'"';
          }else{
            $extraWhere = '`sf`.`region` = "'.$region.'" AND `et`.`status` != 0 AND `sf`.`userid` = "'.$userid.'" AND `sf`.`lgu_patrolled_name` = "'.$lgu_name.'"';
          }
        }

        if($_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['func'] == 'Regional Director'){
          if(empty($returned_report) AND !empty($lgu_name)){ //FILTER LGU
            $extraWhere = '`sf`.`region` = "'.$region.'" AND `et`.`status` != 0 AND `sf`.`userid` = "'.$userid.'" AND `sf`.`lgu_patrolled_name` = "'.$lgu_name.'"';
          }

          if(!empty($evaluator) && $default != 'default'){ //For evaluation
            $extraWhere = "`sf`.`region` = '".$region."' AND `et`.`status` != 0 AND  `sf`.`assigned_to` = '".$evaluator."' AND `sf`.`status` != 'Signed Document'";
          }else if(empty($lgu_name) && $returned_report != $userid){ //Default All
            $extraWhere = "`sf`.`region` = '".$region."' AND `et`.`status` != 0";
          }

          if(!empty($ch) AND $ch != 'All'){ //Filter by Casehandler chosen
            $extraWhere = "`sf`.`region` = '".$region."' AND `et`.`status` != 0 AND  `sf`.`userid` = '".$ch."'";
          }else if(!empty($ch) AND $ch == 'All'){ //Filter by Casehandler but all
            $extraWhere = "`sf`.`region` = '".$region."' AND `et`.`status` != 0";
          }

          if(!empty($lgu) AND $lgu != 'All'){ //Filter by LGU chosen
            $extraWhere = "`sf`.`region` = '".$region."' AND `et`.`status` != 0 AND  `sf`.`lgu_patrolled_id` = '".$lgu."'";
          }else if(!empty($lgu) AND $lgu == 'All'){ //Filter by LGU but all
            $extraWhere = "`sf`.`region` = '".$region."' AND `et`.`status` != 0";
          }

          if(!empty($regionfilter) AND $regionfilter == 'All'){
            $extraWhere = "`et`.`status` != 0 AND `sf`.`status` = 'Signed Document'";
          }else if(!empty($regionfilter) AND $regionfilter != 'All'){
            $extraWhere = "`sf`.`region` = '".$regionfilter."' AND `et`.`status` != 0 AND `sf`.`status` = 'Signed Document'";
          }
        }

        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

  public function sw_settings(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="sweet_func_user";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`acs`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['userid']);
                      }),
                      array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname'),
                      array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname'),
                      array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname'),
                      array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix','formatter'=>function($x,$row){
                        $mname  = !empty($row['mname']) ? $row['mname'][0].". " : "";
                        $suffix = !empty($row['suffix']) ? " ".$row['suffix'] : "";
                        return ucwords($row['fname']." ".$mname.$row['sname'].$suffix);
                      }),
                      array( 'db' => '`sfu`.`func_token`', 'dt' => 'func_token', 'field' => 'func_token'),
                      array( 'db' => '`sfu`.`date_added`', 'dt' => 'date_added', 'field' => 'date_added','formatter'=>function($x,$row){
                        return date('M d, Y', strtotime($row['date_added']));
                      }),
                      array( 'db' => '`sf`.`func_name`', 'dt' => 'func_name', 'field' => 'func_name'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`sweet_func_user` AS `sfu`
                      LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid`=`sfu`.`userid`
                      LEFT JOIN `embis`.`sweet_func` AS `sf` ON `sf`.`token`=`sfu`.`func_token`";
        $extraWhere = "`acs`.`region` = '".$this->session->userdata('region')."' AND `acs`.`verified` = 1";
        $groupBy    = "`acs`.`userid`";
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

  public function sw_template(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="sweet_func";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`sf`.`token`', 'dt' => 'token', 'field' => 'token'),
                      array( 'db' => '`sf`.`date_added`', 'dt' => 'date_added', 'field' => 'date_added','formatter'=>function($x,$row){
                        return date("M d, Y", strtotime($row['date_added']));
                      }),
                      array( 'db' => '`sf`.`func_name`', 'dt' => 'func_name', 'field' => 'func_name'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`sweet_func` AS `sf`";
        $extraWhere = "`sf`.`region` = '".$this->session->userdata('region')."' AND `sf`.`stat` = 1";
        $groupBy    = "`sf`.`token`";
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

  public function lgu_monitored(){

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="sweet_lgu_assigned";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`sla`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['cnt']);
                      }),
                      array( 'db' => '`sla`.`name`', 'dt' => 'name', 'field' => 'name'),
                      array( 'db' => '`sla`.`emb_id`', 'dt' => 'emb_id', 'field' => 'emb_id'),
                      array( 'db' => '`sla`.`lgu_name`', 'dt' => 'lgu_name', 'field' => 'lgu_name'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`sweet_lgu_assigned` AS `sla`";
        $extraWhere = "`sla`.`region` = '".$this->session->userdata('region')."'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

  public function nov(){

      $region    = $this->input->post('region');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="sweet_nov_letter";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`snl`.`trans_no`', 'dt' => 0, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row[0]);
                      }),
                      array( 'db' => '`snl`.`trans_no`', 'dt' => 1, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $row[1];
                      }),
                      array( 'db' => '`snl`.`report_number`', 'dt' => 2, 'field' => 'report_number','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['report_number']);
                      }),
                      array( 'db' => '`snl`.`cnt`', 'dt' => 3, 'field' => 'cnt','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['cnt']);
                      }),
                      array( 'db' => '`snl`.`name`', 'dt' => 'name', 'field' => 'name'),
                      array( 'db' => '`snl`.`date_created`', 'dt' => 'date_created', 'field' => 'date_created','formatter'=>function($x,$row){
                        return date("F d, Y", strtotime($row['date_created']));
                      }),
                      array( 'db' => '`snl`.`address_to`', 'dt' => 'address_to', 'field' => 'address_to'),
                      array( 'db' => '`snl`.`designation`', 'dt' => 'designation', 'field' => 'designation'),
                      array( 'db' => '`snl`.`subject`', 'dt' => 'subject', 'field' => 'subject'),
                      array( 'db' => '`snl`.`date_patrolled`', 'dt' => 'date_patrolled', 'field' => 'date_patrolled','formatter'=>function($x,$row){
                        return date("F d, Y", strtotime($row['date_patrolled']));
                      }),
                      array( 'db' => '`snl`.`lgu_patrolled_name`', 'dt' => 'lgu_patrolled_name', 'field' => 'lgu_patrolled_name'),
                      array( 'db' => '`snl`.`barangay_name`', 'dt' => 'barangay_name', 'field' => 'barangay_name'),
                      array( 'db' => '`snl`.`status`', 'dt' => 'status', 'field' => 'status'),
                      array( 'db' => '`snl`.`assigned_name`', 'dt' => 'assigned_name', 'field' => 'assigned_name'),
                      array( 'db' => '`snl`.`assigned_to`', 'dt' => 'assigned_to', 'field' => 'assigned_to'),
                      array( 'db' => '`snl`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`sweet_nov_letter` AS `snl`";
        $joinQuery  .= "LEFT JOIN `embis`.`er_transactions` AS `et` ON `et`.`token` = `snl`.`trans_no`";
        $extraWhere = "`et`.`status` != 0 AND `snl`.`region` = '".$region."' AND `snl`.`status` != 'Removed'";

        if($_SESSION['sw_selectswemployee'] == 'yes'){
          $extraWhere .= "AND `snl`.`userid` = '".$this->session->userdata('userid')."'";
        }

        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

  public function novforapproval(){

      $region    = $this->input->post('region');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="sweet_nov_letter";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`snl`.`trans_no`', 'dt' => 0, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['trans_no']);
                      }),
                      array( 'db' => '`snl`.`trans_no`', 'dt' => 1, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $row['trans_no'];
                      }),
                      array( 'db' => '`snl`.`report_number`', 'dt' => 'report_number', 'field' => 'report_number','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['report_number']);
                      }),
                      array( 'db' => '`snl`.`name`', 'dt' => 'name', 'field' => 'name'),
                      array( 'db' => '`snl`.`date_created`', 'dt' => 'date_created', 'field' => 'date_created','formatter'=>function($x,$row){
                        return date("F d, Y", strtotime($row['date_created']));
                      }),
                      array( 'db' => '`snl`.`address_to`', 'dt' => 'address_to', 'field' => 'address_to'),
                      array( 'db' => '`snl`.`designation`', 'dt' => 'designation', 'field' => 'designation'),
                      array( 'db' => '`snl`.`subject`', 'dt' => 'subject', 'field' => 'subject'),
                      array( 'db' => '`snl`.`date_patrolled`', 'dt' => 'date_patrolled', 'field' => 'date_patrolled','formatter'=>function($x,$row){
                        return date("F d, Y", strtotime($row['date_patrolled']));
                      }),
                      array( 'db' => '`snl`.`lgu_patrolled_name`', 'dt' => 'lgu_patrolled_name', 'field' => 'lgu_patrolled_name'),
                      array( 'db' => '`snl`.`barangay_name`', 'dt' => 'barangay_name', 'field' => 'barangay_name'),
                      array( 'db' => '`snl`.`status`', 'dt' => 'status', 'field' => 'status'),
                      array( 'db' => '`snl`.`assigned_name`', 'dt' => 'assigned_name', 'field' => 'assigned_name'),
                      array( 'db' => '`snl`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`sweet_nov_letter` AS `snl`";
        $joinQuery  .= "LEFT JOIN `embis`.`er_transactions` AS `et` ON `et`.`token` = `snl`.`trans_no`";
        $extraWhere = "`et`.`status` != 0 AND `snl`.`region` = '".$region."' AND `snl`.`assigned_to` = '".$this->session->userdata('userid')."' AND `snl`.`status` != 'Removed'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

}
?>
