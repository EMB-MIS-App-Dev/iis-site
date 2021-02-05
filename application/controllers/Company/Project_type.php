<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project_type extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Serverside');
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->library('session');
    // $this->load->library('MY_Encrypt');
    $this->load->library('encrypt');
    $this->load->helper('url');
    $this->load->helper('security');
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('company/project_type');
  }
  function project_type_view(){
    $getproid =  $this->input->get('proid',TRUE);
    $decodedprojectid = $this->encrypt->decode($getproid);
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->session->set_userdata('project_type_id',$decodedprojectid);
    $where = array('dcmp.project_type' => $decodedprojectid);
    $queryindex['project_name'] = $this->Embismodel->selectdata('dms_company AS dcmp','dcmp.project_name,dcmp.project_type',$where);
    $this->load->view('company/project_type_content',$queryindex);
  }



  function project_type_serverside(){

    $columns = array(
                        0 =>'cnt',
                        1 =>'prj',
                        2 =>'numcompanies',
                    );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        // echo "<pre>";print_r($columns);exit;
        $dir = $this->input->post('order')[0]['dir'];
          // insert your table
        $totalData = $this->Serverside->allposts_count('dms_project_type');

        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value']))
        {
         $select  = $this->db->select('dpt.proid,dpt.prj,dpt.cnt, COUNT(dms_company.project_type) as numcompanies');

         $join = $this->db->join('dms_company', 'project_type = dpt.proid','left outer')
         ->group_by('proid');
          // $posts = $this->Serverside->allposts($limit,$start,$order,$dir,'dms_company as dcmp',$where,$select);
          $posts = $this->Serverside->allposts($limit,$start,$order,$dir,'dms_project_type as dpt',$select,$join);
          // echo $this->db->last_query();exit;
        }
        else {
            $search = $this->input->post('search')['value'];
              // insert your table

            $columnstosearch = array(
              '1' => 'prj',
              '2' => 'proid',
             );
             $select  = $this->db->select('dpt.proid,dpt.cnt,dpt.prj, COUNT(dms_company.project_type) as numcompanies');

             $join = $this->db->join('dms_company', 'project_type = dpt.proid','left outer')
             ->group_by('project_type');

            $posts =  $this->Serverside->posts_search($limit,$start,$search,$order,$dir,'dms_project_type as dpt',$columnstosearch,$select,$join);

            $totalFiltered = $this->Serverside->posts_search_count($search,'dms_project_type  as dpt',$columnstosearch,$select,$join);
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['numcompanies'] = $post->numcompanies;
                $nestedData['proid'] = $this->encrypt->encode($post->proid);
                $nestedData['cnt'] = $post->cnt;
                // echo $nestedData['proid'];
                // exit;
                // $nestedData['proid'] = $post->proid;
                $nestedData['prj'] = $post->prj;

                $data[] = $nestedData;

            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );
        echo json_encode($json_data);
  }



  function project_type_content(){
    // for columns
    $columns = array(
                            0 =>'emb_id',
                            1 =>'company_name',
                            // 2 =>'emb_id',
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        // echo "<pre>";print_r($columns);exit;
        $dir = $this->input->post('order')[0]['dir'];
          // insert your table
        $totalData = $this->Serverside->allposts_count('dms_company');

        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value']))
        {
            $where = $this->db->where('dcmp.project_type',$_SESSION['project_type_id']);
            $posts = $this->Serverside->allposts($limit,$start,$order,$dir,'dms_company as dcmp',$where);
        }
        else {
            $search = $this->input->post('search')['value'];
              // insert your table
            $columnstosearch = array(
              1 =>'emb_id',
              2 =>'company_name',
              // 2 =>'emb_id',
             );
            $where = $this->db->where('dcmp.project_type',$_SESSION['project_type_id']);
            $posts =  $this->Serverside->posts_search($limit,$start,$search,$order,$dir,'dms_company as dcmp',$columnstosearch ,$where);

            $totalFiltered = $this->Serverside->posts_search_count($search,'dms_company as dcmp',$columnstosearch ,$where);
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['emb_id'] = $post->emb_id;
                $nestedData['company_name'] = $post->company_name;
                $nestedData['company_id'] = $this->encrypt->encode($post->company_id);
                $nestedData['location'] = $post->barangay_id.','.$post->city_name.','.$post->province_name;
                // $nestedData['location'] = $post->prj;

                $data[] = $nestedData;

            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );
        echo json_encode($json_data);
  }
}
