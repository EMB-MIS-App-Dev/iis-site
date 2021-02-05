<?php



defined('BASEPATH') OR exit('No direct script access allowed');

/**

 *

 */

class Sp_server_side extends CI_Controller

{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');

  }

  public function sp_server_side_data(){

      // $accid = $this->session->userdata('accid');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
          'db'   => 'support'
      );

      // DB table to use

      $table ="support";

      // Table's primary key

      $primaryKey = 'support_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(

                      array( 'db' => '`sp`.`supp_ticket_id`', 'dt'   => 'supp_ticket_id', 'field' => 'supp_ticket_id'),
                      array( 'db' => '`sp`.`date`', 'dt'   => 'date', 'field' => 'date'),
                      array( 'db' => '`sp`.`email`', 'dt'     => 'email', 'field' => 'email'),
                      array( 'db' => '`sp`.`support_id`', 'dt'     => 'support_id', 'field' => 'support_id', 'formatter'=>function($x,$row){
                        return $this->encrypt->encode($row['support_id']);
                        }),
                      array( 'db' => '`pr`.`emb_emp_id`', 'dt'     => 'emb_emp_id', 'field' => 'emb_emp_id', 'formatter'=>function($x,$row){
                        if (empty($row['emb_emp_id'])) {
                          $emb_emp_id = 'waiting';
                        }else {

                          $query= $this->db->select('acc.username')->from('acc')->where('userid',$row['emb_emp_id'])->get()->result_array();
                          $emb_emp_id =$query[0]['username'];
                        }
                        // echo $status;exit;
                        return $emb_emp_id;
                        }),

                      array( 'db' => '`sp`.`contact_no`', 'dt'     => 'contact_no', 'field' => 'contact_no'),
                      array( 'db' => '`sp`.`name`', 'dt'     => 'name', 'field' => 'name'),
                      array( 'db' => '`sp`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                        // echo $row['status'];exit;
                        if ($row['status'] == 0) {
                          $status = 'open';
                          // <img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/>
                        }else if ($row['status'] == 1) {
                          $status = 'processing';
                          // <img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/>
                        }else if ($row['status'] == 2) {
                          $status = 'solved';
                        }
                        // echo $status;exit;
                        return $status;
                        }),
                      array( 'db' => '`sp`.`sys_remarks`', 'dt'    => 'remarks', 'field' => 'remarks'),
                      array( 'db' => '`sp`.`sys_inquiry`', 'dt'    => 'sys_inquiry', 'field' => 'sys_inquiry'),
                      array( 'db' => '`sp`.`system`', 'dt'    => 'sup_main_id', 'field' => 'sup_main_id'),
                  );
                  // print_r($columns);exit;

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = "FROM support.support AS sp
                       LEFT JOIN process_request as pr ON pr.support_id = sp.support_id
                       LEFT JOIN embis.acc as acc ON acc.userid = pr.emb_emp_id
                       ";
        $extraWhere = 'sp.sys_reg = "'.$this->session->userdata('region').'"';
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
  }
  // for emb support
  // assistance main categories
  public function emb_category_data(){

      // $accid = $this->session->userdata('accid');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => 'embis'
      );

      // DB table to use

      $table ="sp_main_category";

      // Table's primary key

      $primaryKey = 'cno';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                    array( 'db' => '`sca`.`cno`', 'dt'   => 'cno', 'field' => 'cno'),
                    array( 'db' => '`sca`.`ctype`', 'dt'   => 'ctype', 'field' => 'ctype'),
                    array( 'db' => '`sca`.`ctype`', 'dt'   => 'ctype', 'field' => 'ctype'),
                    array( 'db' => '`sca`.`date_added`', 'dt'   => 'date_added', 'field' => 'date_added'),
                    // array( 'db' => '`sca`.`status`', 'dt'     => 'status', 'field' => 'status'),
                    array( 'db' => '`sca`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                        if ($row['status'] == 1) {
                          $status = 'Active';
                        }else {
                            $status = 'Inactive';
                        }
                        return $status;
                      }),

                    array( 'db' => '`sca`.`deleted`', 'dt'   => 'deleted', 'field' => 'deleted'),
                  );
                  // print_r($columns);exit;

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery =  "FROM embis.sp_main_category AS sca ";
        $extraWhere = 'sca.region = "'.$this->session->userdata('region').'"';
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
  }
  // for hardware category
  public function emb_hardware_main_category(){

      // $accid = $this->session->userdata('accid');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => 'embis'
      );

      // DB table to use

      $table ="sp_main_category_hardware";

      // Table's primary key

      $primaryKey = 'sp_hardware_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                    array( 'db' => '`smch`.`sp_hardware_id`', 'dt'   => 'sp_hardware_id', 'field' => 'sp_hardware_id'),
                    array( 'db' => '`smch`.`name`', 'dt'   => 'name', 'field' => 'name'),
                    array( 'db' => '`smch`.`date_added`', 'dt'   => 'date_added', 'field' => 'date_added'),
                    array( 'db' => '`smch`.`deleted`', 'dt'   => 'deleted', 'field' => 'deleted'),
                    // array( 'db' => '`smch`.`status`', 'dt'     => 'status', 'field' => 'status'),
                    array( 'db' => '`smch`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                      if ($row['status'] == 1) {
                        $status = 'Active';
                      }else {
                          $status = 'Inactive';
                      }
                      return $status;
                      }),
                  );
                  // print_r($columns);exit;

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery =  "FROM embis.sp_main_category_hardware AS smch ";
        $extraWhere = 'smch.region = "'.$this->session->userdata('region').'"';
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
  }

  // ticket list for assistance

  public function for_assistance_table(){

      // $accid = $this->session->userdata('accid');

      // Database connection info
      $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => 'embis'
      );

      // DB table to use

      $table ="sp_ticket_assisstance";

      // Table's primary key

      $primaryKey = 'ticket_ass_id';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(

                    array( 'db' => '`sta`.`sname`', 'dt'   => 'sname', 'field' => 'sname'),
                    array( 'db' => '`sta`.`fname`', 'dt'   => 'staff', 'field' => 'fname','formatter'=>function($x,$row){
                      $staff = $row['fname'].' '.$row['sname'];
                        return $staff;
                      }),
                    array( 'db' => '`acc`.`username`', 'dt'   => 'agent', 'field' => 'username'),
                    array( 'db' => '`sta`.`mis_id`', 'dt'   => 'mis_id', 'field' => 'mis_id'),
                    array( 'db' => '`sta`.`ticket_no`', 'dt'   => 'ticket_no', 'field' => 'ticket_no'),
                    array( 'db' => '`sta`.`ticket_ass_id`', 'dt'   => 'ticket_ass_id', 'field' => 'ticket_ass_id'),
                    array( 'db' => '`sta`.`ticket_date`', 'dt'   => 'ticket_date', 'field' => 'ticket_date','formatter'=>function($x,$row){
                      return date("jMY",strtotime($row['ticket_date']));
                      }),
                    array( 'db' => '`sta`.`remarks`', 'dt'   => 'remarks', 'field' => 'remarks'),
                    // array( 'db' => '`sta`.`status`', 'dt'   => 'status', 'field' => 'status'),
                    array( 'db' => '`sta`.`status`', 'dt'   => 'status2', 'field' => 'status'),
                    array( 'db' => '`sta`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                      // echo $row['status'];exit;
                      if ($row['status'] == 0) {
                        $status = 'open';
                        // <img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/>
                      }else if ($row['status'] == 1) {
                        $status = 'processing';
                        // <img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/>
                      }else if ($row['status'] == 2) {
                        $status = 'attended';
                      }else if ($row['status'] == 3) {
                        $status = 'solved';
                      }else if ($row['status'] == 4) {
                        $status = 'pending';
                      }else if ($row['status'] == 5) {
                        $status = 'unresolved';
                      }
                      // echo $status;exit;
                      return $status;
                      }),
                    array( 'db' => '`sta`.`forwarded`', 'dt'   => 'forwarded', 'field' => 'forwarded','formatter'),

                    // array( 'db' => '`ssc`.`csdsc`', 'dt'   => 'csdsc', 'field' => 'csdsc','formatter'),
                    // array( 'db' => '`spc`.`ctype`', 'dt'   => 'ctype', 'field' => 'ctype','formatter'),
                    array( 'db' => '`sta`.`csdsc`', 'dt'   => 'csdsc', 'field' => 'csdsc'),
                    array( 'db' => '`sta`.`ctype`', 'dt'   => 'ctype', 'field' => 'ctype'),

                    array( 'db' => '`sta`.`region`', 'dt'   => 'region', 'field' => 'region'),
                    array( 'db' => '`sta`.`sp_category`', 'dt'   => 'sp_category', 'field' => 'sp_category','formatter'),
                    array( 'db' => '`sta`.`sp_category_specification`', 'dt'   => 'sp_category_specification', 'field' => 'sp_category_specification'),
                    array( 'db' => '`sft`.`from_reg`', 'dt'   => 'from_reg', 'field' => 'from_reg','formatter'),
                    array( 'db' => '`sft`.`remarks`', 'dt'   => 'remarks', 'field' => 'remarks','formatter'),
                  );
                  // print_r($columns);exit;

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery =  "FROM embis.sp_ticket_assisstance AS sta
          LEFT JOIN acc as acc ON acc.userid  = sta.mis_id
          LEFT JOIN sp_forwarded_ticket as sft ON sft.sp_ticket_id  = sta.ticket_ass_id
          ";

        if (!empty($this->session->userdata('sp_ticket_no'))) {
            $extraWhere = 'sta.region = "'.$this->session->userdata('region').'" AND sta.ticket_no="'.$this->session->userdata('sp_ticket_no').'" AND sft.deleted = 0';
        }else {
            $extraWhere = 'sta.region = "'.$this->session->userdata('region').'" OR sft.from_reg = "'.$this->session->userdata('region').'" AND sft.deleted = 0';
        }
        // echo $extraWhere;exit;
        $groupBy = 'sta.ticket_ass_id';
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
  }

    public function staff_for_assistance_table(){

        // $accid = $this->session->userdata('accid');

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
        );

        // DB table to use

        $table ="sp_ticket_assisstance";

        // Table's primary key

        $primaryKey = 'ticket_ass_id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database.
        // The `dt` parameter represents the DataTables column identifier.x

         $columns = array(
                      array( 'db' => '`sta`.`mis_id`', 'dt'   => 'mis_id', 'field' => 'mis_id'),
                      array( 'db' => '`sta`.`ticket_no`', 'dt'   => 'ticket_no', 'field' => 'ticket_no'),
                      array( 'db' => '`sta`.`ticket_ass_id`', 'dt'   => 'ticket_ass_id', 'field' => 'ticket_ass_id'),
                      array( 'db' => '`sta`.`ticket_date`', 'dt'   => 'ticket_date', 'field' => 'ticket_date','formatter'=>function($x,$row){
                        return date("jMY",strtotime($row['ticket_date']));
                        }),

                      array( 'db' => '`sta`.`remarks`', 'dt'   => 'remarks', 'field' => 'remarks'),
                      // array( 'db' => '`sta`.`status`', 'dt'   => 'status', 'field' => 'status'),
                      array( 'db' => '`sta`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                        // echo $row['status'];exit;
                        if ($row['status'] == 0) {
                          $status = 'open';
                          // <img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/>
                        }else if ($row['status'] == 1) {
                          $status = 'processing';
                          // <img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/>
                        }else if ($row['status'] == 2) {
                          $status = 'attended';
                        }elseif ($row['status'] == 3) {
                          $status = 'solved';
                        }elseif ($row['status'] == 4) {
                          $status = 'pending';
                        }elseif ($row['status'] == 5) {
                          $status = 'unresolved';
                        }
                        // echo $status;exit;
                        return $status;
                        }),
                      array( 'db' => '`sta`.`region`', 'dt'   => 'region', 'field' => 'region'),
                      array( 'db' => '`sta`.`forwarded`', 'dt'   => 'forwarded', 'field' => 'forwarded'),
                      array( 'db' => '`sta`.`sp_category`', 'dt'   => 'sp_category', 'field' => 'sp_category','formatter'),
                      array( 'db' => '`sta`.`sp_category_specification`', 'dt'   => 'sp_category_specification', 'field' => 'sp_category_specification'),

                      array( 'db' => '`sta`.`csdsc`', 'dt'   => 'csdsc', 'field' => 'csdsc','formatter'),
                      array( 'db' => '`sta`.`ctype`', 'dt'   => 'ctype', 'field' => 'ctype','formatter'),

                      array( 'db' => '`acr`.`sname`', 'dt'   => 'sname', 'field' => 'sname'),
                      array( 'db' => '`acr`.`fname`', 'dt'   => 'staff', 'field' => 'fname','formatter'=>function($x,$row){
                        $staff = mb_substr($row['fname'].'.',0, 1, "UTF-8").' '.$row['sname'];

                          return $staff;
                        }),

                      array( 'db' => '`acc`.`username`', 'dt'   => 'agent', 'field' => 'username'),
                    );
                    // print_r($columns);exit;

        // Include SQL query processing class

          $this->load->view('includes/common/ssp.customized.class.php');

          $joinQuery =  "FROM embis.sp_ticket_assisstance AS sta
            LEFT JOIN acc_credentials as acr ON acr.userid  = sta.staff
            LEFT JOIN acc as acc ON acc.userid  = sta.mis_id
            LEFT JOIN sp_forwarded_ticket as sft ON sft.sp_ticket_id  = sta.ticket_ass_id
            ";

          if (!empty($this->session->userdata('sp_ticket_no'))) {
          $extraWhere = 'sta.staff = '.$this->session->userdata('userid').' AND sta.ticket_no = "'.$this->session->userdata('sp_ticket_no').'"';
          }else {
          $extraWhere = 'sta.region = "'.$this->session->userdata('region').'" OR sft.from_reg = "'.$this->session->userdata('region').'" AND sta.staff = '.$this->session->userdata('userid').' ';
          }
          // echo $extraWhere
          $groupBy = 'sta.ticket_ass_id';
          $having = null;

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
    }


    public function edit_main_cat_assistance(){

        // $accid = $this->session->userdata('accid');

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
        );

        // DB table to use

        $table ="sp_sub_category";

        // Table's primary key

        $primaryKey = 'csno';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database.
        // The `dt` parameter represents the DataTables column identifier.x

         $columns = array(
                      array( 'db' => 'ssc.`csdsc`', 'dt'   => 'csdsc', 'field' => 'csdsc'),
                      array( 'db' => 'ssc.`csno`', 'dt'   => 'csno', 'field' => 'csno'),
                      array( 'db' => 'ssc.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                        if ($row['status'] == 1) {
                          $status = 'active';
                        }else if ($row['status'] == 2) {
                          $status = 'inactive';
                        }else if ($row['status'] == 3) {
                          $status = 'deleted';
                        }
                        return $status;
                        }),

                    );
        // Include SQL query processing class
          $this->load->view('includes/common/ssp.customized.class.php');

          $joinQuery =  "FROM embis.sp_sub_category AS ssc";
          if ($_GET['sp_main_cat_id']) {
             $extraWhere = 'ssc.cno ='.$_GET['sp_main_cat_id'].'';
          }else {
              $extraWhere = '';
          }
          // echo "string";
          // echo $extraWhere;
          $groupBy = 'ssc.csno';
          $having = null;

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
    }

    public function sec_support_table(){

        // $accid = $this->session->userdata('accid');

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => 'embis'
        );

        // DB table to use

        $table ="sp_ticket_assisstance_sec";

        // Table's primary key

        $primaryKey = 'ticket_ass_sec_id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database.
        // The `dt` parameter represents the DataTables column identifier.x

         $columns = array(
                      array( 'db' => '`sta`.`ticket_ass_id`', 'dt'   => 'ticket_ass_id', 'field' => 'ticket_ass_id'),
                      array( 'db' => '`sta`.`sp_forward_id`', 'dt'   => 'sp_forward_id', 'field' => 'sp_forward_id'),
                      array( 'db' => '`sta`.`fwrd_to_region`', 'dt'   => 'fwrd_to_region', 'field' => 'fwrd_to_region'),
                      array( 'db' => '`sta`.`from_name`', 'dt'   => 'from_name', 'field' => 'from_name'),
                      array( 'db' => '`sta`.`remarks`', 'dt'   => 'remarks', 'field' => 'remarks'),
                      array( 'db' => '`sta`.`sec_id`', 'dt'   => 'sec_id', 'field' => 'sec_id'),
                      array( 'db' => '`sta`.`sec_name`', 'dt'   => 'sec_name', 'field' => 'sec_name'),
                      array( 'db' => '`sta`.`ch_id`', 'dt'   => 'ch_id', 'field' => 'ch_id'),
                      array( 'db' => '`sta`.`date_fwrd`', 'dt'   => 'date_fwrd', 'field' => 'date_fwrd','formatter'=>function($x,$row){
                        return date("jMY",strtotime($row['ticket_date']));
                        }),

                          array( 'db' => '`stt`.`ticket_no`', 'dt'   => 'ticket_no', 'field' => 'ticket_no'),
                          array( 'db' => '`stt`.`ctype`', 'dt'   => 'ctype', 'field' => 'ctype'),
                          array( 'db' => '`stt`.`csdsc`', 'dt'   => 'csdsc', 'field' => 'csdsc'),
                          array( 'db' => '`stt`.`mis_id`', 'dt'   => 'mis_id', 'field' => 'mis_id'),
                          array( 'db' => '`stt`.`ticket_date`', 'dt'   => 'ticket_date', 'field' => 'ticket_date','formatter'=>function($x,$row){
                            return date("jMY",strtotime($row['ticket_date']));
                            }),

                            array( 'db' => '`stt`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
                              if ($row['status'] == 0) {
                                $status = 'open';
                              }else if ($row['status'] == 1) {
                                $status = 'processing';
                              }else if ($row['status'] == 2) {
                                $status = 'attended';
                              }elseif ($row['status'] == 3) {
                                $status = 'solved';
                              }elseif ($row['status'] == 4) {
                                $status = 'pending';
                              }elseif ($row['status'] == 5) {
                                $status = 'unresolved';
                              }
                              // echo $status;exit;
                              return $status;
                              }),
                            array( 'db' => '`acc`.`username`', 'dt'   => 'agent', 'field' => 'username'),
                    );
                    // print_r($columns);exit;

        // Include SQL query processing class

          $this->load->view('includes/common/ssp.customized.class.php');

          $joinQuery =  "FROM embis.sp_ticket_assisstance_sec as sta
          LEFT JOIN sp_ticket_assisstance as stt ON stt.ticket_ass_id = sta.ticket_ass_id
          LEFT JOIN acc as acc ON acc.userid  = stt.mis_id
          ";

          $extraWhere = 'sta.div_id = "'.$this->session->userdata('divno').'" AND sta.sec_id = "'.$this->session->userdata('secno').'" AND fwrd_to_region = "'.$this->session->userdata('region').'"';
          // echo $extraWhere;exit;
          $groupBy = 'sta.ticket_ass_id';
          $having = null;

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
    }
}
?>
