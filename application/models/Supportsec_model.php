<?php

class Supportsec extends CI_Model
{
    function __construct()
    {
      parent::__construct();
      $this->load->helper(array('form', 'url'));
    }

    public function get_datatables($table, $column_order, $select = "*", $where = "", $join = array(), $limit, $offset, $search, $order,$group = ''){
      $this->db->from($table);
      $columns = $this->db->list_fields($table);
      if($select){ $this->db->select($select); }
      if($where){ $this->db->where($where); }
      if($join){
            foreach($join as $key => $value){
                if(strpos($value,':') !== false){
                    $joiner = explode(":",$value);
                    $this->db->join($key,$joiner[0],$joiner[1]);
                } else {
                    $this->db->join($key,$value);
                }
            }
      }
      if($search){
        $this->db->group_start();
        foreach ($column_order as $item)
        {
          $this->db->or_like($item, $search['value']);
        }
        $this->db->group_end();
      }
      if($group)
        $this->db->group_by($group);

      if($order)
        $this->db->order_by($column_order[$order['0']['column']], $order['0']['dir']);

        $temp = clone $this->db;
        $data['count'] = $temp->count_all_results();

      if($limit != -1)
        $this->db->limit($limit, $offset);

      $query = $this->db->get();
      $data['data'] = $query->result();

      $this->db->from($table);
      $data['count_all'] = $this->db->count_all_results();
      return $data;
  }

}
