<?php

/**
 *
 */
class Travelordermodel extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
  }

  function acc_function(){
    $userid       = $this->session->userdata('userid');
    $query        = $this->db->query("SELECT *, acs.fname, acs.mname, acs.sname, acs.suffix  FROM acc_function AS af LEFT JOIN acc_credentials AS acs ON acs.userid = af.userid WHERE af.userid='$userid'")->result_array();
    return $query;
    $this->db->close();
  }

  function maxtocnt(){
    $user_region    = $this->session->userdata('region');
    $row            = $this->db->query("SELECT MAX(tocnt) AS `maxid` FROM `to_trans` WHERE region ='$user_region'")->result_array();
    $maxtocnt       = $row[0]['maxid']+1;
    return $maxtocnt;
    $this->db->close();
  }

  function travelnumber(){
    $user_region    = $this->session->userdata('region');
    $row            = $this->db->query("SELECT MAX(tocnt) AS `maxid` FROM `to_trans` WHERE region ='$user_region'")->result_array();
    $maxtocnt       = $row[0]['maxid']+1;
    $number         = sprintf('%06d',$maxtocnt);
    $year           = date('y');
    $tonumber       = "EMB".$user_region.$year.$number;
    return $tonumber;
    $this->db->close();
  }

  function name_of_user(){
    $userid       = $this->session->userdata('userid');
    $user         = $this->db->query("SELECT * FROM `acc_credentials` AS `acs` WHERE `acs`.`userid` = '$userid'")->result_array();
    if(!empty($user[0]['mname'])){  $mname  = $user[0]['mname'][0].". "; }else{ $mname = ""; }
    if(!empty($user[0]['suffix'])){ $suffix = " ".$user[0]['suffix']; }else{ $suffix = ""; }
      $user_name= ucwords($user[0]['fname']." ".$mname." ".$user[0]['sname'].$suffix);
    return $user_name;
    $this->db->close();
  }

  function user_credentials(){
    $user_region  = $this->session->userdata('region');
    $userid       = $this->session->userdata('userid');
    $query        = $this->db->query("SELECT `ad`.`divno`,`ad`.`divname`,`xt`.`secno`,`xt`.`sect`,`acs`.`region`,`acs`.`designation`,`acs`.`plantilla_pos`,`acs`.`plantilla_itemno`, `af`.`func`
                                      FROM `embis`.`acc_credentials` AS `acs`
                                      LEFT JOIN `embis`.`acc_xdvsion` AS `ad` ON `ad`.`divno`=`acs`.`divno`
                                      LEFT JOIN `embis`.`acc_xsect` AS `xt` ON `xt`.`secno`=`acs`.`secno`
                                      LEFT JOIN `embis`.`acc_function` AS `af` ON `af`.`userid`=`acs`.`userid`
                                      WHERE `acs`.`userid` = '$userid' AND `af`.`stat` = '1'")->result_array();
    return $query;
    $this->db->close();
  }

  function route_order_function_approval($trans_no = ''){
    $userid            = $this->session->userdata('userid');
    $route_order       = $this->db->query("SELECT tt.route_order,tt.userid FROM embis.to_trans AS tt WHERE tt.er_no = '$trans_no'")->result_array();
    if($route_order[0]['route_order'] <= '1'){ $route_order_no = '1'; }else{ $route_order_no = $route_order[0]['route_order']-1; }
      $to_userid = $route_order[0]['userid'];
      $route_assigned  = $this->db->query("SELECT tf.assigned_to FROM embis.to_func AS tf
                                           WHERE tf.userid = '$to_userid' AND tf.route_order = '$route_order_no'")->result_array();

    return $route_assigned[0]['assigned_to'];
    $this->db->close();
  }

  function route_order_function(){
    $userid            = $this->session->userdata('userid');
    $trans_no          = $this->session->userdata('travel_trans_no');
    // $route_order       = $this->db->query("SELECT tt.route_order FROM embis.to_trans AS tt WHERE tt.er_no = '$trans_no'")->result_array();
    // if(empty($route_order[0]['route_order'])){ $route_order_no = 1; }else{ $route_order_no = $route_order[0]['route_order']+1; }

    $route_assigned    = $this->db->query("SELECT tf.assigned_to FROM embis.to_func AS tf
                                           WHERE tf.userid = '$userid' AND tf.route_order =
                                           (SELECT MAX(tf2.route_order) FROM embis.to_func AS tf2 WHERE tf2.userid = '$userid')")->result_array();


    return $route_assigned[0]['assigned_to'];
    $this->db->close();
  }

  function to_trans_assigned_to(){
    $trans_no       = $this->session->userdata('travel_trans_no');
    $to_trans       = $this->db->query("SELECT tt.assignedto FROM embis.to_trans AS tt WHERE tt.er_no = '$trans_no'")->result_array();
    if(empty($to_trans[0]['assignedto'])){ $assignedto = ""; }else{ $assignedto = $to_trans[0]['assignedto']; }
    return $assignedto;
    $this->db->close();
  }

  function to_trans_route_order($trans_no = ''){
    $route_order    = $this->db->query("SELECT tt.route_order FROM embis.to_trans AS tt WHERE tt.er_no = '$trans_no'")->result_array();
    if($route_order[0]['route_order'] <= '1'){ $route_order_no = '1'; }else{ $route_order_no = $route_order[0]['route_order']-1; }
    return $route_order_no;
    $this->db->close();
  }

  function route_order_max(){
    $userid            = $this->session->userdata('userid');
    $route_order_max   = $this->db->query("SELECT tf.assigned_to, tf.route_order FROM embis.to_func AS tf
                                            WHERE tf.userid = '$userid' AND tf.route_order =
                                           (SELECT MAX(tf2.route_order) FROM embis.to_func AS tf2 WHERE tf2.userid = '$userid')")->result_array();
    return $route_order_max;
    $this->db->close();
  }

  function calendar(){
    $user_region  = $this->session->userdata('region');
    $currentyear  = date("Y");
    $currentmonth = date("m-Y");
    $prevmonth    = $currentmonth - 1;
    $lmnth        = $currentyear."-".$prevmonth;
    $rmnth        = $currentyear."-".$currentmonth;
    $query        = $this->db->query("SELECT user, toid, arrdate, depdate, color
                                      FROM embis.to_full
                                      WHERE status='3' ")->result_array();

    return $query;
    $this->db->close();
  }

  function to_trans_log_trans_order($trans_no = ''){
    $qryaccountsmx = $this->db->query("SELECT MAX(trans_order) AS mto FROM to_trans_log WHERE er_no = '$trans_no'")->result_array();
    if(!empty($qryaccountsmx[0]['mto'])){ $trans_order  = $qryaccountsmx[0]['mto']+1; } else{ $trans_order = 0; }
    return $trans_order;
    $this->db->close();
  }

}

?>
