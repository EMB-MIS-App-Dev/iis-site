<?php

/**
 *
 */
class Records extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

  }

    function index(){
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('smr/smr_records_view');
    }

  public function show_view($content)
  {
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/header', @$this->my_data);
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);
    $this->load->view('includes/common/footer');
  }


  public function smr_records(){

      $dbDetails = array(
          'host' => 'localhost',
          'user' => 'iis',
          'pass' => 'agentx3mbvii158459',
          'db'   => 'smr'
      );

      // DB table to use

      $table ="smr";

      // Table's primary key

      $primaryKey = 'smr_id';

       $columns = array(
           array( 'db' => '`dcomp`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
          array( 'db' => '`dcomp`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
          array( 'db' => '`smr`.`date_year`', 'dt'   => 'date_year', 'field' => 'date_year'),
          array( 'db' => '`smr`.`facility_id`', 'dt'    => 'smr_num_submitted', 'field' => 'facility_id','formatter'=>function($x,$row){
            ($this->session->userdata('region') == 'CO') ? $sesreg = 'NCR': $sesreg = $this->session->userdata('region') ;
            $smrdb = $this->load->database('smr',TRUE);
            $smrsubmitted = $smrdb->query("SELECT COUNT(smr.facility_id) as smr_num_submitted FROM smr LEFT JOIN embis.dms_company as dcomp ON dcomp.company_id =smr.facility_id WHERE smr.date_year = '2020' AND dcomp.region_name = '$sesreg'" )->result();
            return $smrsubmitted[0]->smr_num_submitted;
          }),
        );
        // exit;
                  // print_r($columns);exit;

      // Include SQL query processing class
    $this->load->view('includes/common/ssp.customized.class.php');
    $joinQuery  = "FROM smr.smr LEFT JOIN embis.dms_company as dcomp
    ON smr.facility_id = dcomp.company_id";
    ($this->session->userdata('region') == 'CO') ? $sesreg = 'NCR': $sesreg = $this->session->userdata('region') ;
    $extraWhere = 'smr.date_year = "2020" AND dcomp.region_name = "'.$sesreg.'"';
    // echo $extraWhere ;
    $groupBy = 'facility_id';
    $having = null;
      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
  }
}
