<?php

/**
 *
 */
class Embismodel extends CI_Model
{

  function insertdata($table,$data){
    if (!empty($data)) {
      $this->db->set($data);
    }
    if (!empty($table)) {
    $result =  $this->db->insert($table);
    }
    return $result;
    $this->db->close();
  }

  function selectdata($table = '' ,$select = '', $where = '' ){
     if (!empty($select)) {
       $this->db->select($select);
     }
     if (!empty($where)) {
       $this->db->where($where);
     }

     if (!empty($table)) {
       $this->db->from($table);
       $query  = $this->db->get();
       if($query){
         $result = $query->result_array();
       }
       if($result){
          $count  = count($result);
       }
     }
     // echo $this->db->last_query();
     // exit;
     if(empty($count)){
          return false;
      }
      else{
          return $result;
      }
      $this->db->close();
  }

  function updatedata($data,$table,$where){
    if (!empty($data)) {
      $this->db->set($data);
    }
    if (!empty($where)) {
    $this->db->where($where);
    }
    if (!empty($table)) {
      $result = $this->db->update($table);
    }
    return $result;
    $this->db->close();
  }

  function deletedata($table,$where){
    if (!empty($where)) {
    $this->db->where($where);
    }
    if (!empty($table)) {
      $result = $this->db->delete($table);
    }
    return $result;
    $this->db->close();
  }

  function selectdatarights(){
      $userid  = $this->session->userdata('userid');

      $query   = $this->db->query("SELECT *	FROM `embis`.`acc_rights` AS `ars` WHERE `ars`.`userid` = '$userid'")->result_array();

        if(!empty($query[0]['superadmin_rights']) && $query[0]['superadmin_rights'] == 'yes'){
          $this->session->set_userdata('superadmin_rights', $query[0]['superadmin_rights']);
        }else{
          $this->session->set_userdata('superadmin_rights', '');
        }

        if(!empty($query[0]['hr_rights']) && $query[0]['hr_rights'] == 'yes'){
          $this->session->set_userdata('hr_rights', $query[0]['hr_rights']);
        }else{
          $this->session->set_userdata('hr_rights', '');
        }

        if(!empty($query[0]['company_rights']) && $query[0]['company_rights'] == 'yes'){
        $this->session->set_userdata('company_rights', $query[0]['company_rights']);
        }else{
          $this->session->set_userdata('company_rights', '');
        }

        if(!empty($query[0]['to_ticket_request']) && $query[0]['to_ticket_request'] == 'yes'){
          $this->session->set_userdata('to_ticket_request', $query[0]['to_ticket_request']);
        }else{
          $this->session->set_userdata('to_ticket_request', '');
        }

        if(!empty($query[0]['account_credentials_rights']) && $query[0]['account_credentials_rights'] == 'yes'){
          $this->session->set_userdata('account_credentials_rights', $query[0]['account_credentials_rights']);
        }else{
          $this->session->set_userdata('account_credentials_rights', '');
        }

         if(!empty($query[0]['dms_all_view_attachment']) && $query[0]['dms_all_view_attachment'] == 'yes'){
          $this->session->set_userdata('dms_all_view_attachment', $query[0]['dms_all_view_attachment']);
        }else{
          $this->session->set_userdata('dms_all_view_attachment', '');
        }

        if(!empty($query[0]['to_assistant_or_laborers']) && $query[0]['to_assistant_or_laborers'] == 'yes'){
          $this->session->set_userdata('to_assistant_or_laborers', $query[0]['to_assistant_or_laborers']);
        }else{
          $this->session->set_userdata('to_assistant_or_laborers', '');
        }

        if(!empty($query[0]['to_view_all_approved']) && $query[0]['to_view_all_approved'] == 'yes'){
          $this->session->set_userdata('to_view_all_approved', $query[0]['to_view_all_approved']);
        }else{
          $this->session->set_userdata('to_view_all_approved', '');
        }
        if(!empty($query[0]['client_rights']) && $query[0]['client_rights'] == 'yes'){
          $this->session->set_userdata('client_rights', $query[0]['client_rights']);
        }else{
          $this->session->set_userdata('client_rights', '');
        }
        if(!empty($query[0]['loginas']) && $query[0]['loginas'] == 'yes'){
          $this->session->set_userdata('loginas', $query[0]['loginas']);
        }else{
          $this->session->set_userdata('loginas', '');
        }
        if(!empty($query[0]['trans_qrcode']) && $query[0]['trans_qrcode'] == 'yes'){
          $this->session->set_userdata('trans_qrcode', $query[0]['trans_qrcode']);
        }else{
          $this->session->set_userdata('trans_qrcode', '');
        }
        if(!empty($query[0]['qrcode_docs']) && $query[0]['qrcode_docs'] == 'yes'){
          $this->session->set_userdata('qrcode_docs', $query[0]['qrcode_docs']);
        }else{
          $this->session->set_userdata('qrcode_docs', '');
        }
        if(!empty($query[0]['trans_regionalprc']) && $query[0]['trans_regionalprc'] == 'yes'){
          $this->session->set_userdata('trans_regionalprc', $query[0]['trans_regionalprc']);
        }else{
          $this->session->set_userdata('trans_regionalprc', '');
        }
        if(!empty($query[0]['trans_multiprc']) && $query[0]['trans_multiprc'] == 'yes'){
          $this->session->set_userdata('trans_multiprc', $query[0]['trans_multiprc']);
        }else{
          $this->session->set_userdata('trans_multiprc', '');
        }
        if(!empty($query[0]['client_log']) && $query[0]['client_log'] == 'yes'){
          $this->session->set_userdata('client_log', $query[0]['client_log']);
        }else{
          $this->session->set_userdata('client_log', '');
        }

        if(!empty($query[0]['access_regions']) && $query[0]['access_regions'] == 'yes'){
          $this->session->set_userdata('access_regions', $query[0]['access_regions']);
        }else{
          $this->session->set_userdata('access_regions', '');
        }

        if(!empty($query[0]['add_user_rights_with_role']) && $query[0]['add_user_rights_with_role'] == 'yes'){
          $this->session->set_userdata('add_user_rights_with_role', $query[0]['add_user_rights_with_role']);
        }else{
          $this->session->set_userdata('add_user_rights_with_role', '');
        }

        if(!empty($query[0]['rec_officer']) && $query[0]['rec_officer'] == 'yes'){
          $this->session->set_userdata('rec_officer', $query[0]['rec_officer']);
        }else{
          $this->session->set_userdata('rec_officer', '');
        }

        if(!empty($query[0]['trans_deletion']) && $query[0]['trans_deletion'] == 'yes'){
          $this->session->set_userdata('trans_deletion', $query[0]['trans_deletion']);
        }else{
          $this->session->set_userdata('trans_deletion', '');
        }

        if(!empty($query[0]['view_pab_trans']) && $query[0]['view_pab_trans'] == 'yes'){
          $this->session->set_userdata('view_pab_trans', $query[0]['view_pab_trans']);
        }else{
          $this->session->set_userdata('view_pab_trans', '');
        }

        if(!empty($query[0]['access_offices']) && $query[0]['access_offices'] == 'yes'){
          $this->session->set_userdata('access_offices', $query[0]['access_offices']);
        }else{
          $this->session->set_userdata('access_offices', '');
        }

        if(!empty($query[0]['access_sweet_settings']) && $query[0]['access_sweet_settings'] == 'yes'){
          $this->session->set_userdata('access_sweet_settings', $query[0]['access_sweet_settings']);
        }else{
          $this->session->set_userdata('access_sweet_settings', '');
        }

        if(!empty($query[0]['view_monitoring_report']) && $query[0]['view_monitoring_report'] == 'yes'){
          $this->session->set_userdata('view_monitoring_report', $query[0]['view_monitoring_report']);
        }else{
          $this->session->set_userdata('view_monitoring_report', '');
        }
        if(!empty($query[0]['view_eia']) && $query[0]['view_eia'] == 'yes'){
          $this->session->set_userdata('view_eia', $query[0]['view_eia']);
        }else{
          $this->session->set_userdata('view_eia', '');
        }
        if(!empty($query[0]['view_haz']) && $query[0]['view_haz'] == 'yes'){
          $this->session->set_userdata('view_haz', $query[0]['view_haz']);
        }else{
          $this->session->set_userdata('view_haz', '');
        }
        if(!empty($query[0]['view_chem']) && $query[0]['view_chem'] == 'yes'){
          $this->session->set_userdata('view_chem', $query[0]['view_chem']);
        }else{
          $this->session->set_userdata('view_chem', '');
        }
        if(!empty($query[0]['view_confidential_tab']) && $query[0]['view_confidential_tab'] == 'yes'){
          $this->session->set_userdata('view_confidential_tab', $query[0]['view_confidential_tab']);
        }else{
          $this->session->set_userdata('view_confidential_tab', '');
        }
        if(!empty($query[0]['set_confidential_tag']) && $query[0]['set_confidential_tag'] == 'yes'){
          $this->session->set_userdata('set_confidential_tag', $query[0]['set_confidential_tag']);
        }else{
          $this->session->set_userdata('set_confidential_tag', '');
        }
        if(!empty($query[0]['add_event']) && $query[0]['add_event'] == 'yes'){
          $this->session->set_userdata('add_event', $query[0]['add_event']);
        }else{
          $this->session->set_userdata('add_event', '');
        }
        if(!empty($query[0]['access_pbsbur']) && $query[0]['access_pbsbur'] == 'yes'){
          $this->session->set_userdata('access_pbsbur', $query[0]['access_pbsbur']);
        }else{
          $this->session->set_userdata('access_pbsbur', '');
        }
        if(!empty($query[0]['add_bulletin']) && $query[0]['add_bulletin'] == 'yes'){
          $this->session->set_userdata('add_bulletin', $query[0]['add_bulletin']);
        }else{
          $this->session->set_userdata('add_bulletin', '');
        }
        if(!empty($query[0]['support_admin']) && $query[0]['support_admin'] == 'yes'){
          $this->session->set_userdata('support_admin', $query[0]['support_admin']);
        }else{
          $this->session->set_userdata('support_admin', '');
        }
        if(!empty($query[0]['inbox_monitoring']) && $query[0]['inbox_monitoring'] == 'yes'){
          $this->session->set_userdata('inbox_monitoring', $query[0]['inbox_monitoring']);
        }else{
          $this->session->set_userdata('inbox_monitoring', '');
        }
        if(!empty($query[0]['universe_admin']) && $query[0]['universe_admin'] == 'yes'){
          $this->session->set_userdata('universe_admin', $query[0]['universe_admin']);
        }else{
          $this->session->set_userdata('universe_admin', '');
        }

        ///SWEET
        $whereevaluator  = $this->db->where('sf.assigned_to = "'.$this->session->userdata('userid').'"');
        $selectevaluator = $this->Embismodel->selectdata('sweet_func AS sf','sf.assigned_to','',$whereevaluator);
        if(!empty($selectevaluator[0]['assigned_to'])){
            $this->session->set_userdata('sw_selectevaluator', 'yes');
        }else{
          $this->session->set_userdata('sw_selectevaluator', '');
        }

        //TRAVEL ORDER
        $whereapprover  = $this->db->where('tf.assigned_to = "'.$this->session->userdata('userid').'"');
        $selectapprover = $this->Embismodel->selectdata('to_func AS tf','tf.assigned_to','',$whereapprover);
        if(!empty($selectapprover[0]['assigned_to'])){
            $this->session->set_userdata('to_approver', 'yes');
        }else{
          $this->session->set_userdata('to_approver', '');
        }

        //If has hierarchy
				$wheretofunc = $this->db->where('tf.userid = "'.$this->session->userdata('userid').'"');
				$querytofunc = $this->Embismodel->selectdata('embis.to_func AS tf','tf.userid','',$wheretofunc);
        if(!empty($querytofunc[0]['userid'])){
            $this->session->set_userdata('tofunc', 'yes');
        }else{
          $this->session->set_userdata('tofunc', '');
        }

        $whereswemployee  = $this->db->where('sfu.userid = "'.$this->session->userdata('userid').'"');
        $selectswemployee = $this->Embismodel->selectdata('sweet_func_user AS sfu','sfu.userid','',$whereswemployee);
        if(!empty($selectswemployee[0]['userid'])){
            $this->session->set_userdata('sw_selectswemployee', 'yes');
        }else{
          $this->session->set_userdata('sw_selectswemployee', '');
        }

 }

  function countactive(){
    $user_region  = $this->session->userdata('region');
    $office  = $this->session->userdata('office');
    $query        = $this->db->query("SELECT *	FROM `embis`.`acc_credentials` AS `acs` WHERE `acs`.`verified` = '1' AND `acs`.`region` = '$user_region' AND `acs`.`office` = '$office'")->result_array();
    $count        = count($query);
    return $count;
    $this->db->close();
  }

  function employee_list(){
    $user_region  = $this->session->userdata('region');
    $query        = $this->db->query("SELECT *	FROM `embis`.`acc_credentials` AS `acs` WHERE `acs`.`userid` != '1' AND `acs`.`region` = '$user_region' ORDER BY `acs`.`verified` DESC, `acs`.`fname` ASC")->result_array();
    return $query;
    $this->db->close();
  }

  function employee_list_active(){
    $user_region  = $this->session->userdata('region');
    $office  = $this->session->userdata('office');
    if($this->session->userdata('userid') == '1' OR $this->session->userdata('userid') == '2' OR $this->session->userdata('userid') == '468' OR $this->session->userdata('userid') == '51' OR $this->session->userdata('userid') == '157' OR $this->session->userdata('userid') == '125'){
      $query        = $this->db->query("SELECT DISTINCT(acs.userid), acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, af.func	FROM `embis`.`acc_credentials` AS `acs`
      LEFT JOIN `embis`.`acc_function` AS `af` ON `af`.`userid`=`acs`.`userid`
      WHERE `af`.`stat` = '1' AND `acs`.`userid` != '1' AND `acs`.`verified` = '1' AND `acs`.`region` = '$user_region' AND `acs`.`office` = '$office'
      ORDER BY `acs`.`verified` DESC, `af`.`func_order` ASC, `acs`.`fname` ASC")->result_array();
    }else{
      $query        = $this->db->query("SELECT DISTINCT(acs.userid), acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, af.func	FROM `embis`.`acc_credentials` AS `acs`
      LEFT JOIN `embis`.`acc_function` AS `af` ON `af`.`userid`=`acs`.`userid`
      WHERE `af`.`stat` = '1' AND `acs`.`userid` != '1' AND `acs`.`userid` != '2' AND `acs`.`userid` != '468' AND `acs`.`userid` != '51' AND `acs`.`userid` != '157'
       AND `acs`.`userid` != '125' AND `acs`.`verified` = '1' AND `acs`.`region` = '$user_region' AND `acs`.`office` = '$office'
       ORDER BY `acs`.`verified` DESC, `af`.`func_order` ASC, `acs`.`fname` ASC")->result_array();
    }
    return $query;
    $this->db->close();
  }

  function user_actions(){
    if($this->session->userdata('superadmin_rights') == 'yes'){
      $query        = $this->db->query("SELECT *	FROM `embis`.`acc_settings` AS `acs` ORDER BY `acs`.`acc_desc` ASC")->result_array();
    }else{
      $query        = $this->db->query("SELECT *	FROM `embis`.`acc_settings` AS `acs` ORDER BY `acs`.`acc_desc` ASC")->result_array();
      // $query        = $this->db->query("SELECT *	FROM `embis`.`acc_settings` AS `acs` WHERE `acs`.`acc_id` = '1' ORDER BY `acs`.`acc_desc` ASC")->result_array();
    }

    return $query;
    $this->db->close();
  }

  function countnotassigned(){
    $user_region  = $this->session->userdata('region');
    $office  = $this->session->userdata('office');
    $query        = $this->db->query("SELECT *	FROM `embis`.`acc_credentials` AS `acs` WHERE `acs`.`verified` = '0' AND `acs`.`region` = '$user_region' AND `acs`.`office` = '$office'")->result_array();
    $count        = count($query);
    return $count;
    $this->db->close();
  }

}
