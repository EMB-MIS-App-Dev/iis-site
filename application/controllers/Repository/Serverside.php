<?php



defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 */

class Serverside extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');

  }

  public function index(){

      $region = $this->session->userdata('region');

      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="er_repository";

      // Table's primary key

      $primaryKey = 'trans_no';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`et`.`trans_no`', 'dt' => 0, 'field' => 'trans_no'),
                      array( 'db' => '`et`.`token`', 'dt' => 'token', 'field' => 'token'),
                      array( 'db' => '`et`.`qr_code_token`', 'dt' => 'qr_code_token', 'field' => 'qr_code_token'),
                      array( 'db' => '`et`.`company_name`', 'dt' => 'company_name', 'field' => 'company_name'),
                      array( 'db' => '`et`.`emb_id`', 'dt' => 'emb_id', 'field' => 'emb_id'),
                      array( 'db' => '`et`.`type_description`', 'dt' => 'type_description', 'field' => 'type_description'),
                      array( 'db' => 'et.subject',  'dt' => 'subject', 'field' => 'subject', 'formatter' => function($x, $row) {
                        $subject = "<span title='".$row['subject']."'>".substr($row['subject'],0,60)."..."."</span>";
                        return $subject;
                      }),
                      array( 'db' => '`et`.`sender_name`', 'dt' => 'sender_name', 'field' => 'sender_name'),
                      array( 'db' => '`et`.`receiver_name`', 'dt' => 'receiver_name', 'field' => 'receiver_name'),
                      array( 'db' => '`et`.`trans_no`', 'dt' => 'trans_no', 'field' => 'trans_no','formatter'=>function($x,$row){
                        $trans_no = $this->encrypt->encode($row['trans_no']);
                        return $trans_no;
                      }),
                      array( 'db' => '`et`.`status_description`', 'dt' => 'status_description', 'field' => 'status_description'),
                      array( 'db' => 'etl.date_out',  'dt' => 'date_out', 'field' => 'date_out', 'formatter' => function($x, $row){
                        return ($row['date_out'] != '0000-00-00') ? date("F j, Y, g:i a", strtotime($row['date_out'])) : '-';
                      } ),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = 'FROM er_transactions AS et JOIN (SELECT etl1.trans_no, etl1.main_route_order, etl1.route_order, etl1.date_out FROM er_transactions_log AS etl1) AS etl ON (etl.trans_no = et.trans_no AND etl.route_order = et.route_order)';
        $extraWhere = 'et.route_order != 0 AND et.status != 0 AND etl.main_route_order = "" AND ( et.receiver_region = "'.$region.'" OR et.region = "'.$region.'" ) AND et.qr_code_token != ""';
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }

}
?>
