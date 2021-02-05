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

  public function bulletinn(){

      $region = $this->session->userdata('region');
      $office = $this->session->userdata('office');
      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="bulletin";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`bn`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['cnt']);
                      }),
                      array( 'db' => '`bn`.`title`', 'dt' => 'title', 'field' => 'title'),
                      array( 'db' => '`bn`.`title`', 'dt' => 2, 'field' => 'title','formatter'=>function($x,$row){
                        return strlen($row['title']);
                      }),
                      array( 'db' => '`bn`.`datetime_posted`', 'dt' => 'datetime_posted', 'field' => 'datetime_posted'),
                      array( 'db' => '`bn`.`datetime_posted`', 'dt' => 4, 'field' => 'datetime_posted','formatter'=>function($x,$row){
                        return date('m/d/Y - h:ia', strtotime($row['datetime_posted']));
                      }),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = "FROM `embis`.`bulletin` AS `bn`
                      LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid`=`bn`.`userid`";

        $extraWhere = "bn.visibility = 'National' AND bn.status = 'published'";
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();
  }

  public function bulletinr(){

      $region = $this->session->userdata('region');
      $office = $this->session->userdata('office');
      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="bulletin";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`bn`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['cnt']);
                      }),
                      array( 'db' => '`bn`.`title`', 'dt' => 'title', 'field' => 'title'),
                      array( 'db' => '`bn`.`title`', 'dt' => 2, 'field' => 'title','formatter'=>function($x,$row){
                        return strlen($row['title']);
                      }),
                      array( 'db' => '`bn`.`datetime_posted`', 'dt' => 'datetime_posted', 'field' => 'datetime_posted'),
                      array( 'db' => '`bn`.`datetime_posted`', 'dt' => 4, 'field' => 'datetime_posted','formatter'=>function($x,$row){
                        return date('m/d/Y - h:ia', strtotime($row['datetime_posted']));
                      }),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = "FROM `embis`.`bulletin` AS `bn`
                      LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid`=`bn`.`userid`";

        // $extraWhere = "(bn.visibility = 'Regional' AND bn.region = '".$region."' AND bn.status = 'published') OR (bn.region = '".$region."' AND bn.status = 'published')";
        $extraWhere = "(bn.visibility = 'Regional' AND bn.region = '".$region."' AND bn.status = 'published')";
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();
  }
}
