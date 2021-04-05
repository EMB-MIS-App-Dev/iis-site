<?php
class Ssomodel extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function enroll($data){
        $this->db->insert('sso_tb', $data);
    }

    public function fetch_subsys(){
        $query = $this->db->get('sso_tb');
        return $query->result_array();
    }

    public function rem_subsys($id){
        // $query = $this->db->get_where('sso_tb', array('sso_id' => $id));
        $this->db->where('sso_id', $id);
        $this->db->delete('sso_tb');
    }

    public function view_mobile($id){
        $query = $this->db->get_where('sso_number', array('iis_id' => $id));
        return $query->result_array();
    }

}
?>