<?php

/**
 *
 */
class Administrativemodel extends CI_Model
{

  function assigned_hierarchy($userid){

    $this->db->select('tf.userid, tf.assigned_to, tf.route_order, af.func');
    $this->db->where('tf.userid = "'.$userid.'" AND af.stat = "1"');
    $this->db->from('to_func AS tf');
    $this->db->join('acc_function AS af','af.userid = tf.userid','left');
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result;
    $this->db->close();
  }

  function select_employees($where = ""){
    $this->db->select('DISTINCT(acs.userid), acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, af.func');
    $this->db->from('acc_credentials AS acs');
    $this->db->join('acc_function AS af','af.userid = acs.userid','left');
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result;
    $this->db->close();
  }

}
