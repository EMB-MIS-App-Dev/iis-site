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

  public function emp_with_to_table(){

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

      $table ="to_trans";

      // Table's primary key

      $primaryKey = 'tocnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`tt`.`userid`', 'dt' => 'userid', 'field' => 'userid'),
                      array( 'db' => '`tt`.`name`', 'dt' => 'name', 'field' => 'name'),
                      array( 'db' => '`tt`.`section`', 'dt' => 'section', 'field' => 'section'),
                      array( 'db' => '`tt`.`division`', 'dt' => 'division', 'field' => 'division'),
                      array( 'db' => '`tt`.`arrival_date`', 'dt'    => 'arrival_date', 'field' => 'arrival_date','formatter'=>function($x,$row){
                        return date("M j, Y", strtotime($row['arrival_date']));
                      }),
                      array( 'db' => '`tt`.`departure_date`', 'dt'    => 'departure_date', 'field' => 'departure_date','formatter'=>function($x,$row){
                        return date("M j, Y", strtotime($row['departure_date']));
                      }),
                        // array( 'db' => '`tt`.`departure_date`', 'dt' => 'departure_date', 'field' => 'departure_date'),
                      array( 'db' => '`tt`.`destination`', 'dt' => 'destination', 'field' => 'destination'),
                      array( 'db' => '`tt`.`travel_purpose`', 'dt' => 'travel_purpose', 'field' => 'travel_purpose'),
                      array( 'db' => '`tt`.`travel_purpose`', 'dt' => 'travel_purpose', 'field' => 'travel_purpose'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = "FROM `embis`.`to_trans` as tt";
        if (!empty($_GET['dep_date']) || !empty($_GET['arr_date'])) {
        $extraWhere = 'tt.region = "'.$this->session->userdata('region').'" AND tt.departure_date >= "'.$_GET['dep_date'].'" AND tt.arrival_date <= "'.$_GET['arr_date'].'" ORDER BY tt.departure_date  ASC';
        // echo $extraWhere;exit;
        }else {
        $extraWhere = 'tt.region = "'.$this->session->userdata('region').'" ORDER BY tt.departure_date ASC';
        }
        // echo "<pre>";print_r($columns);exit;
        // echo $extraWhere;exit;


        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();
  }




}
?>
