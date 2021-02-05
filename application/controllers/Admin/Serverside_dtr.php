<?php



defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 */

class Serverside_dtr extends CI_Controller

{

  function __construct() {

    parent::__construct();
    $this->load->library('session');

  }

  function dtr(){
    $datetoday = $_POST['datetoday'];
    $filterdate = $_POST['filterdate'];
    // Database connection info
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_dtr_horizontal";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                    array( 'db' => '`adh`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                      return $this->encrypt->encode($row['cnt']);
                    }),
                    array( 'db' => '`adh`.`order_by`', 'dt' => 'order_by', 'field' => 'order_by'),
                    array( 'db' => '`adh`.`punch_date`', 'dt' => 'punch_date', 'field' => 'punch_date'),
                    array( 'db' => '`adh`.`in`', 'dt' => 'in', 'field' => 'in','formatter'=>function($x,$row){
                      if(empty($row['in'])){
                        $am_in = '--:--';
                      }else{
                        $am_in = $row['in'] == '00:00' ? '--:--' : $row['in'];
                      }
                      return $am_in;
                    }),
                    array( 'db' => '`adh`.`out`', 'dt' => 'out', 'field' => 'out','formatter'=>function($x,$row){
                      if(empty($row['out'])){
                        $am_out = '--:--';
                      }else{
                        $am_out = $row['out'] == '00:00' ? '--:--' : $row['out'];
                      }
                      return $am_out;
                    }),
                    array( 'db' => '`adh`.`am_hrsworked`', 'dt' => 'am_hrsworked', 'field' => 'am_hrsworked','formatter'=>function($x,$row){
                      $con_i = (date('i',strtotime($row['am_hrsworked'])) > 0 AND date('i',strtotime($row['am_hrsworked'])) > 1) ? 's' : '';
                      $con_h = (date('h',strtotime($row['am_hrsworked'])) > 0 AND date('h',strtotime($row['am_hrsworked'])) > 1 AND date('h',strtotime($row['am_hrsworked'])) != '12') ? 's' : '';
                      $hrs = (date('h',strtotime($row['am_hrsworked'])) == '12') ? '00' : date('h',strtotime($row['am_hrsworked']));
                      if(empty($row['am_hrsworked'])){
                        $am_hrsworked = '--:--';
                      }else{
                        if($row['am_hrsworked'] == '00:00:00'){
                          $am_hrsworked = '--:--';
                        }else{
                          $am_hrsworked = $hrs.' hour'.$con_h.' and '.date('i',strtotime($row['am_hrsworked'])).' minute'.$con_i;
                        }
                      }
                     return $am_hrsworked;
                     }),
                     array( 'db' => '`adh`.`in_pm`', 'dt' => 'in_pm', 'field' => 'in_pm','formatter'=>function($x,$row){
                       if(empty($row['in_pm'])){
                         $pm_in = '--:--';
                       }else{
                         $pm_in = $row['in_pm'] == '00:00' ? '--:--' : $row['in_pm'];
                       }
                       return $pm_in;
                     }),
                     array( 'db' => '`adh`.`out_pm`', 'dt' => 'out_pm', 'field' => 'out_pm','formatter'=>function($x,$row){
                       if(empty($row['out_pm'])){
                         $pm_out = '--:--';
                       }else{
                         $pm_out = $row['out_pm'] == '00:00' ? '--:--' : $row['out_pm'];
                       }
                       return $pm_out;
                     }),
                    array( 'db' => '`adh`.`pm_hrsworked`', 'dt' => 'pm_hrsworked', 'field' => 'pm_hrsworked','formatter'=>function($x,$row){
                      $con_ipm = (date('i',strtotime($row['pm_hrsworked'])) > 0 AND date('i',strtotime($row['pm_hrsworked'])) > 1) ? 's' : '';
                      $con_hpm = (date('h',strtotime($row['pm_hrsworked'])) > 0 AND date('h',strtotime($row['pm_hrsworked'])) > 1 AND date('h',strtotime($row['pm_hrsworked'])) != '12') ? 's' : '';
                      $hrspm = (date('h',strtotime($row['pm_hrsworked'])) == '12') ? '00' : date('h',strtotime($row['pm_hrsworked']));
                      if(empty($row['pm_hrsworked'])){
                        $pm_hrsworked = '--:--';
                      }else{
                        if($row['pm_hrsworked'] == '00:00:00'){
                          $pm_hrsworked = '--:--';
                        }else{
                          $pm_hrsworked = $hrspm.' hour'.$con_hpm.' and '.date('i',strtotime($row['pm_hrsworked'])).' minute'.$con_ipm;
                        }
                      }

                       return $pm_hrsworked;
                     }),
                     array( 'db' => '`adh`.`total_hrsworked`', 'dt' => 'total_hrsworked', 'field' => 'total_hrsworked','formatter'=>function($x,$row){
                       $con_h = (date('h',strtotime($row['total_hrsworked'])) > 0 AND date('h',strtotime($row['total_hrsworked'])) > 1) ? 's' : '';
                       $con_i = (date('i',strtotime($row['total_hrsworked'])) > 0 AND date('i',strtotime($row['total_hrsworked'])) > 1) ? 's' : '';
                       if(empty($row['total_hrsworked'])){
                         $total_hrsworked = '--:--';
                       }else{
                         if($row['total_hrsworked'] == '00:00:00'){
                           $total_hrsworked = '--:--';
                         }else{
                           $total_hrsworked = date('g',strtotime($row['total_hrsworked'])).' hour'.$con_h.' and '.date('i',strtotime($row['total_hrsworked'])).' minute'.$con_i;
                         }
                       }
                        return $total_hrsworked;
                      }),
                      array( 'db' => '`adh`.`with_attachments`', 'dt' => 'with_attachments', 'field' => 'with_attachments'),
                      array( 'db' => '`adh`.`with_attachments`', 'dt' => 10, 'field' => 'with_attachments','formatter'=>function($x,$row){
                        if($row['with_attachments'] == ''){
                          $attachments = '--';
                        }else{
                          $attachments = $row[10];
                        }
                        return $attachments;
                      }),
                      array( 'db' => '`adh`.`attachment_file`', 'dt' => 'attachment_file', 'field' => 'attachment_file'),
                      array( 'db' => '`adh`.`statcol`', 'dt' => 'statcol', 'field' => 'statcol'),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM embis.acc_dtr_horizontal AS adh";
      $extraWhere = "adh.stat = 'Active' AND adh.staff = '".$this->session->userdata('userid')."'";
      if(!empty($datetoday)){
        $extraWhere .= " AND adh.punch_date = '".$datetoday."'";
      }
      if(!empty($filterdate)){
        $filterconverted = date('F', strtotime($filterdate));
        $extraWhere .= " AND adh.punch_date LIKE '%".$filterconverted."%'";
      }
      $groupBy    = null;
      $having     = null;

    echo json_encode(
        SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
    $this->db->close();
  }

  function routed(){
    $routedtome = $_POST['routedtome'];
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_dtr_routed";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                   array( 'db' => '`adr`.`trans_no`', 'dt' => 'trans_no', 'field' => 'trans_no'),
                   array( 'db' => '`adr`.`dtr_span`', 'dt' => 'dtr_span', 'field' => 'dtr_span'),
                   array( 'db' => '`adr`.`date_submitted`', 'dt' => 'date_submitted', 'field' => 'date_submitted'),
                   array( 'db' => '`adr`.`status`', 'dt' => 'status', 'field' => 'status','formatter'=>function($x,$row){
                     if($row['status'] == 'For checking'){
                       // $status = "<img src='".base_url()."../iis-images/status-icons/onprocess.gif' height='25' width='25'/>&nbsp;<span style='color:#E76A24;'>For approval</span>";
                       $status = "For approval";
                     }else if($row['status'] == 'Approved'){
                       $status = $row['status'];
                     }else{
                       $status = $row['status'];
                     }
                     return $status;
                   }),
                   array( 'db' => '`adr`.`routedto_name`', 'dt' => 'routedto_name', 'field' => 'routedto_name'),
                   array( 'db' => '`adr`.`trans_no`', 'dt' => 5, 'field' => 'trans_no','formatter'=>function($x,$row){
                     return $this->encrypt->encode($row['trans_no']);
                   }),
                   array( 'db' => '`adr`.`staff_name`', 'dt' => 'staff_name', 'field' => 'staff_name'),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM embis.acc_dtr_routed AS adr LEFT JOIN embis.er_transactions AS et ON et.token = adr.trans_no";
      if(!empty($routedtome)){
        $extraWhere = "adr.routedto_userid = '".$this->session->userdata('userid')."' AND et.status != 0 AND adr.status = 'For approval'";
      }else{
        $extraWhere = "adr.staff = '".$this->session->userdata('userid')."' AND et.status != 0";
      }

      $groupBy    = "adr.trans_no";
      $having     = null;

    echo json_encode(
        SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
    $this->db->close();
  }

  function routedpayroll(){
    $routedtome = $_POST['routedtome'];
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_dtr_routed";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                   array( 'db' => '`adr`.`trans_no`', 'dt' => 'trans_no', 'field' => 'trans_no'),
                   array( 'db' => '`adr`.`staff_name`', 'dt' => 'staff_name', 'field' => 'staff_name'),
                   array( 'db' => '`adr`.`dtr_span`', 'dt' => 'dtr_span', 'field' => 'dtr_span'),
                   array( 'db' => '`adr`.`p_days_worked`', 'dt' => 'p_days_worked', 'field' => 'p_days_worked'),
                   array( 'db' => '`adr`.`p_daily_rate`', 'dt' => 'p_daily_rate', 'field' => 'p_daily_rate'),
                   array( 'db' => '`adr`.`p_gross_income`', 'dt' => 'p_gross_income', 'field' => 'p_gross_income'),
                   array( 'db' => '`adr`.`p_total_deductions`', 'dt' => 'p_total_deductions', 'field' => 'p_total_deductions'),
                   array( 'db' => '`adr`.`p_total_addon`', 'dt' => 'p_total_addon', 'field' => 'p_total_addon'),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM embis.acc_dtr_routed AS adr LEFT JOIN embis.er_transactions AS et ON et.token = adr.trans_no";
      if(!empty($routedtome)){
        $extraWhere = "adr.routedto_userid = '".$this->session->userdata('userid')."' AND et.status != 0 AND adr.status = 'For payroll'";
      }

      $groupBy    = "adr.trans_no";
      $having     = null;

    echo json_encode(
        SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
    $this->db->close();
  }

  function dtr_credeb(){
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_dtr_credeb";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                   array( 'db' => '`adc`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                     return $this->encrypt->encode($row['cnt']);
                   }),
                   array( 'db' => '`adc`.`item`', 'dt' => 'item', 'field' => 'item'),
                   array( 'db' => '`adc`.`type`', 'dt' => 'type', 'field' => 'type'),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM embis.acc_dtr_credeb AS adc";
      $extraWhere = "adc.region = '".$this->session->userdata('region')."'";
      $groupBy    = "";
      $having     = null;

    echo json_encode(
        SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
    $this->db->close();
  }

  function dtr_allapproved_payroll(){
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_dtr_routed";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                   array( 'db' => '`adr`.`trans_no`', 'dt' => 0, 'field' => 'trans_no','formatter'=>function($x,$row){
                     return $this->encrypt->encode($row['trans_no']);
                   }),
                   array( 'db' => '`adr`.`trans_no`', 'dt' => 'trans_no', 'field' => 'trans_no'),
                   array( 'db' => '`adr`.`date_submitted`', 'dt' => 'date_submitted', 'field' => 'date_submitted'),
                   array( 'db' => '`adr`.`staff_name`', 'dt' => 'staff_name', 'field' => 'staff_name'),
                   array( 'db' => '`adr`.`dtr_span`', 'dt' => 'dtr_span', 'field' => 'dtr_span'),
                   array( 'db' => '`adr`.`status`', 'dt' => 'status', 'field' => 'status'),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM embis.acc_dtr_routed AS adr LEFT JOIN embis.er_transactions AS et ON et.token = adr.trans_no";
      $extraWhere = "adr.region = '".$this->session->userdata('region')."' AND adr.status = 'Approved' AND et.status != 0";
      $groupBy    = "adr.trans_no";
      $having     = null;

    echo json_encode(
        SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
    $this->db->close();
  }

  function dtr_addtional_info(){
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_additional_info";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                   array( 'db' => '`adi`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                     return $this->encrypt->encode($row['userid']);
                   }),
                   array( 'db' => '`adi`.`name`', 'dt' => 'name', 'field' => 'name'),
                   array( 'db' => '`adi`.`daily_rate`', 'dt' => 'daily_rate', 'field' => 'daily_rate'),
                   array( 'db' => '`adi`.`add_on_total`', 'dt' => 'add_on_total', 'field' => 'add_on_total','formatter'=>function($x,$row){
                     return (!empty($row['add_on_total']) ? $row['add_on_total'] : '--');
                   }),
                   array( 'db' => '`adi`.`deduction_total`', 'dt' => 'deduction_total', 'field' => 'deduction_total','formatter'=>function($x,$row){
                     return (!empty($row['deduction_total']) ? $row['deduction_total'] : '--');
                   }),
                   array( 'db' => '`adi`.`userid`', 'dt' => 5, 'field' => 'add_on_total','formatter'=>function($x,$row){
                     return $this->encrypt->encode($row['userid']);
                   }),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM embis.acc_additional_info AS adi LEFT JOIN embis.acc_credentials AS acs ON acs.userid = adi.userid";
      $extraWhere = "acs.region = '".$this->session->userdata('region')."'";
      $groupBy    = null;
      $having     = null;

    echo json_encode(
        SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
    $this->db->close();
  }



}

?>
