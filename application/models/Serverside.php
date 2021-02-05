<?php

class Serverside extends CI_Model
{
    function __construct() {
        parent::__construct();

    }

    function allposts_count($table)
    {
        $query = $this
                ->db
                ->get($table);

        return $query->num_rows();

    }

    function allposts($limit,$start,$col,$dir,$table)
    {
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($table);

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }

    }

    function posts_search($limit,$start,$search,$col,$dir,$table,$columnstosearch)
    {

        $query = $this
                ->db
                ->like($columnstosearch[1],$search)
                ->or_like($columnstosearch[2],$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($table);


        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }
    }

    function posts_search_count($search,$table,$columnstosearch)
    {
        $query = $this
                ->db
                ->like($columnstosearch[1],$search)
                ->or_like($columnstosearch[2],$search)
                ->get($table);

        return $query->num_rows();
    }

}
