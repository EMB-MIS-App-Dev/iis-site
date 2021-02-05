
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Test extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->load->model('Embismodel');
      $this->load->library('session');

      $this->load->helper(array('form', 'url'));

      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");
    }

    function json_company(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, OPTIONS");

      if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") { redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); exit; }

      $emb_id      = $this->input->get('emb_id', TRUE);
      $api_key     = $this->input->get('api_key', TRUE);

      $api_key_dev = "x";

      if($api_key == $api_key_dev){

        $where = "";

        if (isset($emb_id) && !is_null($emb_id)){

          $whr   = $this->db->where('cp.emb_id',$emb_id);
          $qry   = $this->Embismodel->selectdata('embis.dms_company AS cp','cp.company_type,cp.company_id','',$whr);


          $whraf = $this->db->where('acr.company_id = "'.$qry[0]['company_id'].'" GROUP BY acr.client_id');
          $jnaf = $this->db->join('crs.acc','acc.client_id = acr.client_id','left');
          $afltd = $this->Embismodel->selectdata('approved_client_req AS acr','CONCAT(UPPER(first_name)," ",UPPER(last_name)) AS name',$jnaf,$whraf);

          (!empty($afltd[0]['name'])) ? $afltdarray = $afltd : $afltdarray = array();

          $array = array();
          if($qry[0]['company_type'] != $qry[0]['company_id']){ //if with main

            $branch_id   = $qry[0]['company_id'];
            $querybranch = $this->db->query('SELECT `cp`.`emb_id`, `cp`.`company_name`, `cp`.`establishment_name`, `cp`.`date_established`, `cp`.`house_no`, `cp`.`street`, `cp`.`barangay_name`, `cp`.`city_name`, `cp`.`province_name`, `cp`.`region_name`, `cp`.`latitude`, `cp`.`longitude`, `cp`.`email`, `cp`.`contact_no`, `cp`.`project_name`, `cp`.`int_comp_address`, `cp`.`input_date`
              FROM `embis`.`dms_company` AS `cp` LEFT JOIN `dms_project_type` AS `cy` ON `cy`.`proid` = `cp`.`project_type`
              WHERE `cp`.`company_id` = '.$branch_id.'');
            $querybh = $querybranch->row();

            $querymain = $this->db->query('SELECT `dy`.`emb_id`, `dy`.`company_name`, `dy`.`establishment_name`, `dy`.`date_established`, `dy`.`house_no`, `dy`.`street`, `dy`.`barangay_name`, `dy`.`city_name`, `dy`.`province_name`, `dy`.`region_name`, `dy`.`latitude`, `dy`.`longitude`, `dy`.`email`, `dy`.`contact_no`, `dy`.`project_name`, `dy`.`int_comp_address`, `dy`.`input_date`
              FROM `embis`.`dms_company` AS `cp`
              LEFT JOIN `dms_company` AS `dy` ON `dy`.`company_id` = `cp`.`company_type`
              LEFT JOIN `dms_project_type` AS `cyy` ON `cyy`.`proid` = `dy`.`project_type` WHERE `cp`.`emb_id` = "'.$emb_id.'"');
              $querymn = $querymain->row();

              foreach ($querybh as $key => $res){
                $query[$key] = $res;
              }

              $query = array_merge($query, ['main' => $querymn], ['affiliated' => $afltdarray]);


          }else{
            $querymain = $this->db->query('SELECT `dy`.`emb_id`, `dy`.`company_name`, `dy`.`establishment_name`, `dy`.`date_established`, `dy`.`house_no`, `dy`.`street`, `dy`.`barangay_name`, `dy`.`city_name`, `dy`.`province_name`, `dy`.`region_name`, `dy`.`latitude`, `dy`.`longitude`, `dy`.`email`, `dy`.`contact_no`, `dy`.`project_name`, `dy`.`int_comp_address`, `dy`.`input_date`
              FROM `embis`.`dms_company` AS `cp`
              LEFT JOIN `dms_company` AS `dy` ON `dy`.`company_id` = `cp`.`company_type`
              LEFT JOIN `dms_project_type` AS `cyy` ON `cyy`.`proid` = `dy`.`project_type` WHERE `cp`.`emb_id` = "'.$emb_id.'"');
              $querymn = $querymain->row();
              foreach ($querymn as $key => $res){
                $query[$key] = $res;
              }
              $query = array_merge($query, ['affiliated' => $afltdarray]);
          }

        } else {
          $querymain = $this->db->query('SELECT `dy`.`emb_id`, `dy`.`company_name`, `dy`.`establishment_name`, `dy`.`date_established`, `dy`.`house_no`, `dy`.`street`, `dy`.`barangay_name`, `dy`.`city_name`, `dy`.`province_name`, `dy`.`region_name`, `dy`.`latitude`, `dy`.`longitude`, `dy`.`email`, `dy`.`contact_no`, `dy`.`project_name`, `dy`.`int_comp_address`, `dy`.`input_date`
              FROM `embis`.`dms_company` AS `cp`
              LEFT JOIN `dms_company` AS `dy` ON `dy`.`company_id` = `cp`.`company_type`
              LEFT JOIN `dms_project_type` AS `cyy` ON `cyy`.`proid` = `dy`.`project_type`');
          $querymn = $querymain->row();
          foreach ($querymn as $key => $res){
            $query[$key] = $res;
          }
          $query = array_merge($query, ['affiliated' => $afltdarray]);
        }
        echo json_encode($query);


      }else{
        echo "Invalid API Key. <br> Please contact webmaster.";
      }

    }

  }
?>
