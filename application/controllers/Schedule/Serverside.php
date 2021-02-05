<?php



defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 */

class Serverside extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->library('session');

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

      $table ="schedule_list";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                       array( 'db' => '`sl`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                         return $this->encrypt->encode($row['cnt']);
                       }),
                      array( 'db' => '`sl`.`subject`', 'dt' => 'subject', 'field' => 'subject'),
                      array( 'db' => '`sl`.`date_schedule`', 'dt' => 'date_schedule', 'field' => 'date_schedule','formatter'=>function($x,$row){
                        return date('F d, Y', strtotime($row['date_schedule']));
                      }),
                      array( 'db' => '`sl`.`location`', 'dt' => 'location', 'field' => 'location'),
                      array( 'db' => '`sl`.`remarks`', 'dt' => 'remarks', 'field' => 'remarks','formatter'=>function($x,$row){
                        return substr($row['remarks'],0,150);
                      }),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`schedule_list` AS `sl`";

        $extraWhere = "`sl`.`status` = 'Active'";

        $wheredata   = $this->db->where('sl.status = "Active"');
        $querydata   = $this->Embismodel->selectdata('schedule_list AS sl','sl.participants, sl.cnt, sl.accountable','',$wheredata);
        $cntwhra = '';
    		$cntra = 0;
    		for ($ea=0; $ea < sizeof($querydata); $ea++) {
    			$explodeaccountable = explode('|', $querydata[$ea]['accountable']);
    			for ($ap=0; $ap < count($explodeaccountable); $ap++) {
    				if($explodeaccountable[$ap] == $this->session->userdata('userid')){
    					$cntra++;
    					$concnta = (!empty($explodeaccountable[$ap]) AND $cntra != 1) ? ' OR ': '';
    					$cona = (!empty($explodeaccountable[$ap]) AND $cntra == 1) ? ' AND ': '';
    					$cntwhra .= $cona.$concnta.'cnt = '.$querydata[$ea]['cnt'];
    				}
    			}
    		}

        if($cntra > 0){
          $extraWhere .= "$cntwhra";
        }

        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      $this->db->close();
  }

}
?>
