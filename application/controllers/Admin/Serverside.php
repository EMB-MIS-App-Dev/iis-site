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

  public function User_accounts_serverside(){

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

      $table ="acc_credentials";

      // Table's primary key

      $primaryKey = 'userid';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`as`.`userid`', 'dt' => 'userid', 'field' => 'userid'),
                      array( 'db' => '`as`.`fname`', 'dt' => 'fname', 'field' => 'fname'),
                      array( 'db' => '`as`.`mname`', 'dt' => 'mname', 'field' => 'mname'),
                      array( 'db' => '`as`.`sname`', 'dt' => 'sname', 'field' => 'sname'),
                      array( 'db' => '`as`.`region`', 'dt' => 'region', 'field' => 'region'),
                      array( 'db' => '`as`.`verified`', 'dt' => 'verified', 'field' => 'verified'),
                      array( 'db' => '`acc`.`username`', 'dt' => 'username', 'field' => 'username'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery = "FROM `embis`.`acc_credentials` AS `as`
                      LEFT JOIN `embis`.`acc` ON `acc`.`userid`=`as`.`userid`";
        $extraWhere = null;
        $groupBy = null;
        $having = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();
  }

  public function User_sections_serverside(){

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

      $table ="acc_xsect";

      // Table's primary key

      $primaryKey = 'secno';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      // array( 'db' => '`at`.`secno`', 'dt' => 'secno', 'field' => 'secno'),
                      array( 'db' => '`at`.`secno`', 'dt' => 'secno', 'field' => 'secno','formatter'=>function($x,$row){
                        $secno = $this->encrypt->encode($row['secno']);
                        return $secno;
                      }),
                      array( 'db' => '`an`.`divname`', 'dt' => 'divname', 'field' => 'divname'),
                      array( 'db' => '`at`.`sect`',  'dt' => 'sect',  'field' => 'sect'),
                      array( 'db' => '`s`.`cnt`',  'dt' => 'cnt',  'field' => 'cnt'),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`acc_xsect` AS `at`
                       LEFT JOIN `embis`.`acc_xdvsion` AS `an` ON `an`.`divno`=`at`.`divno`
                       LEFT JOIN
                        (SELECT `secno`,`cnt` FROM `acc_xsect_not_applicable` WHERE `region` = '".$region."') `s`
                        ON `at`.`secno` = `s`.`secno`";
        $extraWhere = "`at`.`region` = '".$region."' AND `at`.`secno` != '69' AND `an`.`office` = '".$office."'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();

  }

  public function User_plantilla_serverside(){
    $region = $this->session->userdata('region');

    // Database connection info
    $dbDetails = array(
        'host' => $this->session->userdata('host'),
        'user' => $this->session->userdata('user'),
        'pass' => $this->session->userdata('pass'),
        'db'   => $this->session->userdata('db')
    );

    // DB table to use

    $table ="acc_plantillapostn";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                    array( 'db' => '`ap`.`planpstn_id`', 'dt' => 'planpstn_id', 'field' => 'planpstn_id'),
                    array( 'db' => '`ap`.`planpstn_code`', 'dt' => 'planpstn_code', 'field' => 'planpstn_code'),
                    array( 'db' => '`ap`.`planpstn_desc`',  'dt' => 'planpstn_desc',  'field' => 'planpstn_desc'),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM `embis`.`acc_plantillapostn` AS `ap`";
      $extraWhere = null;
      $groupBy    = null;
      $having     = null;

    echo json_encode(
        SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
  }

  public function account_credentials_serverside(){

      $region            = $this->session->userdata('region');
      $superadmin_rights = $this->session->userdata('superadmin_rights');
      $office = $this->session->userdata('office');

      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );


      // DB table to use

      $table ="acc";

      // Table's primary key

      $primaryKey = 'userid';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

      if($superadmin_rights == 'yes'){
        $columns = array(
                       array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
                          $fname = ucwords($row['fname']);
                          return $fname;
                        }),
                       array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname','formatter'=>function($x,$row){
                         if($row['mname' != '']){ $mn = $row['mname'][0].". "; }else{ $mn = ""; }
                         $mname = ucwords($mn);
                         return $mname;
                       }),
                       array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname','formatter'=>function($x,$row){
                         $sname = ucwords($row['sname']);
                         return $sname;
                       }),
                       array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix','formatter'=>function($x,$row){
                         if($row['suffix' != '']){ $sfx = " ".$row['suffix']; }else{ $sfx = ""; }
                         $suffix = $sfx;
                         return $suffix;
                       }),
                       array( 'db' => '`ac`.`username`', 'dt' => 'username', 'field' => 'username','formatter'=>function($x,$row){
                         $username = $row['username'];
                         return $username;
                       }),
                       array( 'db' => '`ac`.`raw_password`', 'dt' => 'raw_password', 'field' => 'raw_password','formatter'=>function($x,$row){
                         $raw_password = $this->encrypt->decode($row['raw_password']);
                         return $raw_password;
                       }),
                       array( 'db' => '`ac`.`raw_password`', 'dt' => 6, 'field' => 'raw_password','formatter'=>function($x,$row){
                         $raw_password = ($row['raw_password']);
                         return $raw_password;
                       }),
                       array( 'db' => '`ac`.`raw_password`', 'dt' => 7, 'field' => 'raw_password','formatter'=>function($x,$row){
                         $raw_password = strlen($row['raw_password']);
                         return $raw_password;
                       }),
                       array( 'db' => '`acs`.`email`', 'dt' => 'email', 'field' => 'email'),
                       array( 'db' => '`acs`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                         $userid = $this->encrypt->encode($row['userid']);
                         return $userid;
                       }),
                   );
      }else{
        $columns = array(
                       array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
                          $fname = ucwords($row['fname']);
                          return $fname;
                        }),
                       array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname','formatter'=>function($x,$row){
                         if($row['mname' != '']){ $mn = $row['mname'][0].". "; }else{ $mn = ""; }
                         $mname = ucwords($mn);
                         return $mname;
                       }),
                       array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname','formatter'=>function($x,$row){
                         $sname = ucwords($row['sname']);
                         return $sname;
                       }),
                       array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix','formatter'=>function($x,$row){
                         if($row['suffix' != '']){ $sfx = " ".$row['suffix']; }else{ $sfx = ""; }
                         $suffix = $sfx;
                         return $suffix;
                       }),
                       array( 'db' => '`ac`.`username`', 'dt' => 'username', 'field' => 'username','formatter'=>function($x,$row){
                         $username = $row['username'];
                         return $username;
                       }),
                       array( 'db' => '`acs`.`email`', 'dt' => 'email', 'field' => 'email'),
                       array( 'db' => '`acs`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                         $userid = $this->encrypt->encode($row['userid']);
                         return $userid;
                       }),
                   );
      }


      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`acc` AS `ac`
                       LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid`=`ac`.`userid`";
        $extraWhere = "`ac`.`userid` != '1' AND `acs`.`region` = '".$region."'  AND `acs`.`office` = '".$office."' AND `ac`.`acc_status` = '1'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();

  }

  public function user_accounts_table_serverside(){

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

      $table ="acc";

      // Table's primary key

      $primaryKey = 'userid';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                      array( 'db' => '`acs`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                        $userid = $this->encrypt->encode($row['userid']);
                        return $userid;
                      }),
                      array( 'db' => '`acs`.`userid`', 'dt' => 1, 'field' => 'userid','formatter'=>function($x,$row){
                        $userid = ($row['userid']);
                        return $userid;
                      }),
                      array( 'db' => '`acs`.`title`', 'dt' => 'title', 'field' => 'title','formatter'=>function($x,$row){
                         if($row['title' != '']){ $title = $row['title']." "; }else{ $title = ""; }
                         return $title;
                       }),
                      array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
                         $fname = ucwords($row['fname'])." ";
                         return $fname;
                       }),
                      array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname','formatter'=>function($x,$row){
                        if($row['mname'] != ''){ $mn = $row['mname'][0].". "; }else{ $mn = ""; }
                        $mname = $mn;
                        return $mname;
                      }),
                      array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname','formatter'=>function($x,$row){
                        $sname = ucwords($row['sname'])." ";
                        return $sname;
                      }),
                      array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix','formatter'=>function($x,$row){
                        if($row['suffix' != '']){ $sfx = " ".$row['suffix']; }else{ $sfx = ""; }
                        $suffix = $sfx;
                        return $suffix;
                      }),
                      array( 'db' => '`acs`.`designation`', 'dt' => 'designation', 'field' => 'designation','formatter'=>function($x,$row){
                        if($row['designation'] != '' AND $row['designation'] != null){
                          $desig = $row['designation'];
                        }else{
                          $desig = "--";
                        }
                        return $desig;
                      }),
                      array( 'db' => '`acs`.`verified`', 'dt' => 8, 'field' => 'verified'),
                      array( 'db' => '`acs`.`verified`', 'dt' => 'verified', 'field' => 'verified','formatter'=>function($x,$row){
                        if($row[8] == 0){
                          $verified = "<span style='color:#cccc00;'>To be assigned</span>";
                        }else if($row[8] == 1){
                          $verified = "<span style='color:green;'>Assigned</span>";
                        }else if($row[8] == 2){
                          $verified = "<span style='color:red;'>Removed</span>";
                        }
                        return $verified;
                      }),
                      array( 'db' => '`xn`.`divname`', 'dt' => 'divname', 'field' => 'divname','formatter'=>function($x,$row){
                        if($row['divname'] != '' AND $row['divname'] != null){
                          $divname = $row['divname'];
                        }else{
                          $divname = "--";
                        }
                        return $divname;
                      }),
                      array( 'db' => '`acs`.`section`', 'dt' => 'section', 'field' => 'section','formatter'=>function($x,$row){
                        if($row['section'] != '' AND $row['section'] != null){
                          $section = $row['section'];
                        }else{
                          $section = "--";
                        }
                        return $section;
                      }),
                  );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`acc_credentials` AS `acs`
                      LEFT JOIN `embis`.`acc_xdvsion` AS `xn` ON `xn`.`divno` = `acs`.`divno`";
        $extraWhere = "`acs`.`userid` != '1' AND `acs`.`region` = '".$region."' AND `acs`.`office` = '".$office."' AND `acs`.`verified` != '2'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();

  }

  public function Line_of_authority_table_serverside(){
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

    $table ="acc_plantillapostn";

    // Table's primary key

    $primaryKey = 'cnt';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database.
    // The `dt` parameter represents the DataTables column identifier.x

     $columns = array(
                   array( 'db' => '`ar`.`addedby`',  'dt' => 'addedby',  'field' => 'addedby'),
                   array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
                      $fname = ucwords($row['fname'])." ";
                      return $fname;
                    }),
                   array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname','formatter'=>function($x,$row){
                     if($row['mname'] != ''){ $mn = $row['mname'][0].". "; }else{ $mn = ""; }
                     $mname = $mn;
                     return $mname;
                   }),
                   array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname','formatter'=>function($x,$row){
                     $sname = ucwords($row['sname'])." ";
                     return $sname;
                   }),
                   array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix','formatter'=>function($x,$row){
                     if($row['suffix' != '']){ $sfx = " ".$row['suffix']; }else{ $sfx = ""; }
                     $suffix = $sfx;
                     return $suffix;
                   }),
                   array( 'db' => '`ar`.`rule_name`',  'dt' => 'rule_name',  'field' => 'rule_name'),
                   array( 'db' => '`ar`.`rule_name`', 'dt' => 5, 'field' => 'rule_name','formatter'=>function($x,$row){
                     $line_of_authority = $this->encrypt->encode($row[5]);
                     return $line_of_authority;
                   }),
                );

    // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');

      $joinQuery  = "FROM `embis`.`acc_rule` AS `ar`
                    LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid` = `ar`.`addedby`";
      $extraWhere = "`ar`.`rule_order` = '1' AND `ar`.`region` = '".$region."' AND `acs`.`office` = '".$office."'";
      $groupBy    = null;
      $having     = null;

    echo json_encode(
        SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
    );
  }

  public function account_rights_serverside(){

      $region            = $this->session->userdata('region');
      $superadmin_rights = $this->session->userdata('superadmin_rights');
      $office = $this->session->userdata('office');
      // Database connection info
      $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => $this->session->userdata('db')
      );

      // DB table to use

      $table ="acc_rights";

      // Table's primary key

      $primaryKey = 'userid';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x


        $columns = array(
                       array( 'db' => '`acs`.`fname`', 'dt' => 'fname', 'field' => 'fname','formatter'=>function($x,$row){
                          $fname = ucwords($row['fname']);
                          return $fname;
                        }),
                       array( 'db' => '`acs`.`mname`', 'dt' => 'mname', 'field' => 'mname','formatter'=>function($x,$row){
                         if($row['mname' != '']){ $mn = $row['mname'][0].". "; }else{ $mn = ""; }
                         $mname = ucwords($mn);
                         return $mname;
                       }),
                       array( 'db' => '`acs`.`sname`', 'dt' => 'sname', 'field' => 'sname','formatter'=>function($x,$row){
                         $sname = ucwords($row['sname']);
                         return $sname;
                       }),
                       array( 'db' => '`acs`.`suffix`', 'dt' => 'suffix', 'field' => 'suffix','formatter'=>function($x,$row){
                         if($row['suffix' != '']){ $sfx = " ".$row['suffix']; }else{ $sfx = ""; }
                         $suffix = $sfx;
                         return $suffix;
                       }),
                       array( 'db' => '`acs`.`userid`', 'dt' => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
                         $userid = $this->encrypt->encode($row['userid']);
                         return $userid;
                       }),
                       array( 'db' => '`ar`.`superadmin_rights`', 'dt' => 'superadmin_rights', 'field' => 'superadmin_rights'),
                       array( 'db' => '`ar`.`trans_qrcode`', 'dt' => 'trans_qrcode', 'field' => 'trans_qrcode'),
                       array( 'db' => '`ar`.`qrcode_docs`', 'dt' => 'qrcode_docs', 'field' => 'qrcode_docs'),
                       array( 'db' => '`ar`.`hr_rights`', 'dt' => 'hr_rights', 'field' => 'hr_rights'),
                       array( 'db' => '`ar`.`account_credentials_rights`', 'dt' => 'account_credentials_rights', 'field' => 'account_credentials_rights'),
                       array( 'db' => '`ar`.`company_rights`', 'dt' => 'company_rights', 'field' => 'company_rights'),
                       array( 'db' => '`ar`.`to_rights`', 'dt' => 'to_rights', 'field' => 'to_rights'),
                       array( 'db' => '`ar`.`to_ticket_request`', 'dt' => 'to_ticket_request', 'field' => 'to_ticket_request'),
                       array( 'db' => '`ar`.`to_ticket_chief_accountant`', 'dt' => 'to_ticket_chief_accountant', 'field' => 'to_ticket_chief_accountant'),
                       array( 'db' => '`ar`.`dms_all_view_attachment`', 'dt' => 'dms_all_view_attachment', 'field' => 'dms_all_view_attachment'),
                       array( 'db' => '`ar`.`to_assistant_or_laborers`', 'dt' => 'to_assistant_or_laborers', 'field' => 'to_assistant_or_laborers'),
                       array( 'db' => '`ar`.`to_view_all_approved`', 'dt' => 'to_view_all_approved', 'field' => 'to_view_all_approved'),
                       array( 'db' => '`ar`.`client_rights`', 'dt' => 'client_rights', 'field' => 'client_rights'),
                       array( 'db' => '`ar`.`loginas`', 'dt' => 'loginas', 'field' => 'loginas'),
                       array( 'db' => '`ar`.`trans_regionalprc`', 'dt' => 'trans_regionalprc', 'field' => 'trans_regionalprc'),
                       array( 'db' => '`ar`.`trans_multiprc`', 'dt' => 'trans_multiprc', 'field' => 'trans_multiprc'),
                       array( 'db' => '`ar`.`client_log`', 'dt' => 'client_log', 'field' => 'client_log'),
                       array( 'db' => '`ar`.`access_regions`', 'dt' => 'access_regions', 'field' => 'access_regions'),
                       array( 'db' => '`ar`.`add_user_rights_with_role`', 'dt' => 'add_user_rights_with_role', 'field' => 'add_user_rights_with_role'),
                       array( 'db' => '`ar`.`rec_officer`', 'dt' => 'rec_officer', 'field' => 'rec_officer'),
                       array( 'db' => '`ar`.`trans_deletion`', 'dt' => 'trans_deletion', 'field' => 'trans_deletion'),
                       array( 'db' => '`ar`.`view_pab_trans`', 'dt' => 'view_pab_trans', 'field' => 'view_pab_trans'),
                       array( 'db' => '`ar`.`access_offices`', 'dt' => 'access_offices', 'field' => 'access_offices'),
                       array( 'db' => '`ar`.`access_sweet_settings`', 'dt' => 'access_sweet_settings', 'field' => 'access_sweet_settings'),
                       array( 'db' => '`ar`.`view_monitoring_report`', 'dt' => 'view_monitoring_report', 'field' => 'view_monitoring_report'),
                       array( 'db' => '`ar`.`view_eia`', 'dt' => 'view_eia', 'field' => 'view_eia'),
                       array( 'db' => '`ar`.`view_haz`', 'dt' => 'view_haz', 'field' => 'view_haz'),
                       array( 'db' => '`ar`.`view_chem`', 'dt' => 'view_chem', 'field' => 'view_chem'),
                       array( 'db' => '`ar`.`view_confidential_tab`', 'dt' => 'view_confidential_tab', 'field' => 'view_confidential_tab'),
                       array( 'db' => '`ar`.`set_confidential_tag`', 'dt' => 'set_confidential_tag', 'field' => 'set_confidential_tag'),
                       array( 'db' => '`ar`.`add_event`', 'dt' => 'add_event', 'field' => 'add_event'),
                       array( 'db' => '`ar`.`access_pbsbur`', 'dt' => 'access_pbsbur', 'field' => 'access_pbsbur'),
                       array( 'db' => '`ar`.`add_bulletin`', 'dt' => 'add_bulletin', 'field' => 'add_bulletin'),
                       array( 'db' => '`ar`.`support_admin`', 'dt' => 'support_admin', 'field' => 'support_admin'),
                       array( 'db' => '`ar`.`inbox_monitoring`', 'dt' => 'inbox_monitoring', 'field' => 'inbox_monitoring'),
                       array( 'db' => '`ar`.`universe_admin`', 'dt' => 'universe_admin', 'field' => 'universe_admin'),
                   );

      // Include SQL query processing class

        $this->load->view('includes/common/ssp.customized.class.php');

        $joinQuery  = "FROM `embis`.`acc_rights` AS `ar`
                       LEFT JOIN `embis`.`acc_credentials` AS `acs` ON `acs`.`userid`=`ar`.`userid`";
        $extraWhere = "`ar`.`userid` != '1' AND `acs`.`region` = '".$region."' AND `acs`.`office` = '".$office."' AND `acs`.`verified` = '1'";
        $groupBy    = null;
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );
      // $this->db->close();

  }

}
?>
