<?php

/**
 *
 */
class Sweetreportmodel extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
  }

  function route_assigned($token = '', $useriddata = '', $routeorder = ''){
    $user_region  = $this->session->userdata('region');
    $userid       = $useriddata;
    if($userid == $this->session->userdata('userid')){ //Casehandler
      $route_assigned = $this->db->query("SELECT sf.route_order,sf.assigned_to,acs.designation,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs2.title AS utitle,acs2.fname AS ufname,acs2.mname AS umname,acs2.sname AS usname,acs2.suffix AS usuffix,acs2.divno,acs2.secno FROM embis.sweet_func AS sf
                                           LEFT JOIN embis.acc_credentials AS acs ON acs.userid=sf.assigned_to
                                           LEFT JOIN embis.acc_credentials AS acs2 ON acs2.userid = '$userid'
                                           WHERE sf.token = '$token' AND sf.region = '$user_region' AND sf.route_order =
                                          (SELECT MAX(sf2.route_order) FROM embis.sweet_func AS sf2 WHERE sf2.region = '$user_region' AND sf2.token = '$token')")->result_array();
    }else{ //Evaluator

      $route_order = ($routeorder <= '1') ? '1' : $routeorder-1;

      $route_assigned = $this->db->query("SELECT sf.route_order,sf.assigned_to,acs.designation,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix,acs2.title AS utitle,acs2.fname AS ufname,acs2.mname AS umname,acs2.sname AS usname,acs2.suffix AS usuffix,acs2.divno,acs2.secno FROM embis.sweet_func AS sf
                                           LEFT JOIN embis.acc_credentials AS acs ON acs.userid=sf.assigned_to
                                           LEFT JOIN embis.acc_credentials AS acs2 ON acs2.userid = '$userid'
                                           WHERE sf.token = '$token' AND sf.region = '$user_region' AND sf.route_order = '".$route_order."'")->result_array();
    }

    return $route_assigned;
    $this->db->close();
  }

  function sweet_func_user($userid = ''){
    $wheretoken  = $this->db->where('sfu.userid = "'.$userid.'"');
    $selecttoken = $this->Embismodel->selectdata('sweet_func_user AS sfu','sfu.func_token','',$wheretoken);

    return $selecttoken[0]['func_token'];
    $this->db->close();
  }

  function report_order($month_monitoring, $type_of_monitoring_desc){
    $month  = date("F", strtotime($month_monitoring));
    $region = $this->session->userdata('region');
    $userid = $this->session->userdata('userid');

    $selectmaxreportorder = $this->db->query("SELECT MAX(report_order) AS mro FROM sweet_form_log sf JOIN er_transactions et ON et.token = sf.trans_no WHERE sf.userid = '$userid' AND sf.month_monitoring = '$month' AND sf.type_of_monitoring_desc = '$type_of_monitoring_desc' AND sf.region = '$region' AND et.status != 0")->result_array();

    $mro = $selectmaxreportorder[0]['mro']+1;

    return $mro;
    $this->db->close();
  }

  function max_func($token){
    $region = $this->session->userdata('region');

    $selectmaxfunc = $this->db->query("SELECT MAX(route_order) AS mro FROM sweet_func sf WHERE sf.region = '$region' AND sf.token = '$token'")->result_array();

    $mro = $selectmaxfunc[0]['mro'];

    return $mro;
    $this->db->close();
  }

}

?>
