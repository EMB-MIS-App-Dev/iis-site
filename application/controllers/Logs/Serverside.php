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
      $userid = $this->session->userdata('userid');

      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="client_logs";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`cl`.`trans_token`', 'dt' => 'trans_token', 'field' => 'trans_token'),
                      array( 'db' => '`cl`.`trans_no`', 'dt' => 1, 'field' => 'trans_no'),
                      array( 'db' => '`cl`.`trans_no`', 'dt' => 2, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['trans_no']);
                      }),
                      array( 'db' => '`cl`.`cl_company_name`', 'dt' => 'cl_company_name', 'field' => 'cl_company_name'),
                      array( 'db' => '`cl`.`cl_full_name`', 'dt' => 'cl_full_name', 'field' => 'cl_full_name'),
                      array( 'db' => '`cl`.`cl_address`', 'dt' => 'cl_address', 'field' => 'cl_address'),
                      array( 'db' => '`cl`.`cl_contact_no`', 'dt' => 'cl_contact_no', 'field' => 'cl_contact_no'),
                      array( 'db' => '`cl`.`cl_purpose`', 'dt' => 'cl_purpose', 'field' => 'cl_purpose'),
                      array( 'db' => '`cl`.`cl_other_info`', 'dt' => 'cl_other_info', 'field' => 'cl_other_info'),
                      array( 'db' => '`cl`.`cl_emb_id`', 'dt' => 'cl_emb_id', 'field' => 'cl_emb_id'),
                      array( 'db' => '`cl`.`cl_datetimein`', 'dt' => 'cl_datetimein', 'field' => 'cl_datetimein','formatter'=>function($x,$row){
                        return date('M d, Y - h:i a', strtotime($row['cl_datetimein']));
                      }),
                      array( 'db' => '`cl`.`cl_datetimeout`', 'dt' => 'cl_datetimeout', 'field' => 'cl_datetimeout','formatter'=>function($x,$row){
                        $data = !empty($row['cl_datetimeout']) ? date('M d, Y - h:i a', strtotime($row['cl_datetimeout'])) : '';
                        return $data;
                      }),

                      array( 'db' => '`dc`.`email`', 'dt' => 'email', 'field' => 'email'),
                      array( 'db' => '`dc`.`contact_no`', 'dt' => 'contact_no', 'field' => 'contact_no'),
                      array( 'db' => '`dc`.`street`', 'dt' => 'street', 'field' => 'street'),
                      array( 'db' => '`dc`.`barangay_name`', 'dt' => 'barangay_name', 'field' => 'barangay_name'),
                      array( 'db' => '`dc`.`city_name`', 'dt' => 'city_name', 'field' => 'city_name'),
                      array( 'db' => '`dc`.`province_name`', 'dt' => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){
                        return ucwords($row['street']." ".$row['barangay_name']." ".$row['city_name']." ".$row['province_name']);
                      }),

                      array( 'db' => '`clc`.`company_address`', 'dt' => 'company_address', 'field' => 'company_address'),
                      array( 'db' => '`clc`.`company_contact`', 'dt' => 'company_contact', 'field' => 'company_contact'),
                      array( 'db' => '`clc`.`company_email`', 'dt' => 'company_email', 'field' => 'company_email'),

                      array( 'db' => '`cl`.`cl_frdobtn`', 'dt' => 'cl_frdobtn', 'field' => 'cl_frdobtn'),
                      array( 'db' => '`cl`.`cl_forigin`', 'dt' => 'cl_forigin', 'field' => 'cl_forigin'),
                      array( 'db' => '`cl`.`cl_fdtoftravel`', 'dt' => 'cl_fdtoftravel', 'field' => 'cl_fdtoftravel','formatter'=>function($x,$row){
                        return date("M d, Y", strtotime($row['cl_fdtoftravel']));
                      }),
                      array( 'db' => '`cl`.`cl_fdtofarrival`', 'dt' => 'cl_fdtofarrival', 'field' => 'cl_fdtofarrival','formatter'=>function($x,$row){
                        return date("M d, Y", strtotime($row['cl_fdtofarrival']));
                      }),

                      array( 'db' => '`cl`.`cl_srdobtn`', 'dt' => 'cl_srdobtn', 'field' => 'cl_srdobtn'),
                      array( 'db' => '`cl`.`cl_saddress`', 'dt' => 'cl_saddress', 'field' => 'cl_saddress'),
                      array( 'db' => '`cl`.`cl_comp_pos`', 'dt' => 'cl_comp_pos', 'field' => 'cl_comp_pos'),





                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`client_logs` AS `cl`
        LEFT JOIN `embis`.`er_transactions` AS `et` ON `et`.`trans_no`=`cl`.`trans_no`
        LEFT JOIN `embis`.`dms_company` AS `dc` ON `dc`.`emb_id`=`cl`.`cl_emb_id`
        LEFT JOIN `embis`.`client_logs_company` AS `clc` ON `clc`.`trans_no`=`cl`.`trans_no`";
        $extraWhere = "`et`.`region` = '".$region."'  AND `et`.`status` != 0";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );

  }

}
?>
