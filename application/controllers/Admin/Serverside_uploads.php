<?php



defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 */

class Serverside_uploads extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');

  }

  public function index(){

      $region = $this->session->userdata('region');
      $userid = $this->session->userdata('userid');
      $office = $this->session->userdata('office');

      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="office_uploads_esignature";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`acs`.`fname`', 'dt' => '0', 'field' => 'fname','formatter'=>function($x,$row){
                         $mname = !empty($row['mname']) ? $row['mname'][0].". " : "";
                         $suffix = !empty($row['suffix']) ? " ".$row['suffix'] : "";
                         $name  = ucwords($row[0]." ".$mname." ".$row[3].$suffix);
                         return $name;
                       }),
                      array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname'),
                      array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname'),
                      array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname'),
                      array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix'),
                      array( 'db' => '`oue`.`file_name`', 'dt' => 'file_name', 'field' => 'file_name'),
                      array( 'db' => '`acs`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                         $encrypt_userid  = $this->encrypt->encode($row['userid']);
                         return $encrypt_userid;
                       }),
                      array( 'db' => '`oue`.`to_height_r`', 'dt' => 'to_height_r', 'field' => 'to_height_r'),
                      array( 'db' => '`oue`.`to_width_r`', 'dt' => 'to_width_r', 'field' => 'to_width_r'),
                      array( 'db' => '`oue`.`to_yaxis_r`', 'dt' => 'to_yaxis_r', 'field' => 'to_yaxis_r'),
                      array( 'db' => '`oue`.`to_xaxis_r`', 'dt' => 'to_xaxis_r', 'field' => 'to_xaxis_r'),
                      array( 'db' => '`oue`.`to_height_n`', 'dt' => 'to_height_n', 'field' => 'to_height_n'),
                      array( 'db' => '`oue`.`to_width_n`', 'dt' => 'to_width_n', 'field' => 'to_width_n'),
                      array( 'db' => '`oue`.`to_yaxis_n`', 'dt' => 'to_yaxis_n', 'field' => 'to_yaxis_n'),
                      array( 'db' => '`oue`.`to_xaxis_n`', 'dt' => 'to_xaxis_n', 'field' => 'to_xaxis_n'),
                      array( 'db' => '`oue`.`swm_height`', 'dt' => 'swm_height', 'field' => 'swm_height'),
                      array( 'db' => '`oue`.`swm_width`', 'dt' => 'swm_width', 'field' => 'swm_width'),
                      array( 'db' => '`oue`.`swm_yaxis`', 'dt' => 'swm_yaxis', 'field' => 'swm_yaxis'),
                      array( 'db' => '`oue`.`swm_xaxis`', 'dt' => 'swm_xaxis', 'field' => 'swm_xaxis'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`office_uploads_esignature` AS `oue` LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid`=`oue`.`userid`";
        $extraWhere = "`acs`.`verified` = '1' AND `acs`.`region` = '".$region."' AND `oue`.`status` = 'Active' AND `acs`.`office` = '".$office."'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();

  }

}
?>
