<?php

/**
 *
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class SMR extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('string');
    if ( ! $this->session->userdata('token')) {
      echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
    }
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $crsdb = $this->load->database('crs',TRUE);
    $crsdb->where('role_id !=' , 2);
    $query['user_roles'] = $crsdb->select('*')->from('user_roles')->get()->result_array();
    $region = $this->session->userdata('region');
    $query_evaluator = $this->db->select('user_id')->from('user_type')->get()->result_array();

    $ids = array();
    foreach ($query_evaluator as $key => $value) {
      $ids[$key] = $value['user_id'];
    }
    if (count($ids) == 0)
      $ids = '';

    $query['user_list'] = $this->db->select('acr.*,acc.acc_status')->from('acc_credentials as acr')->join('acc as acc','acc.userid = acr.userid')->where('acc.acc_status',1)->where('acr.region',$region)->where_not_in('acr.userid',$ids)->get()->result_array();

    $query['assign_user_list'] = $this->db->select('*')->from('acc_credentials')->where('region',$region)->where_in('userid',$ids)->get()->result_array();
    $this->load->view('clients/add_user_crs',$query);
  }

  function assign_user_list(){

        $dbDetails = array(
            'host' => '192.168.91.198:3306',
            'user' => 'overseer',
            'pass' => 'agentx3mbvii158459',
            'db'   => 'embis'
        );

        // DB table to use

        $table ="user_type";

        // Table's primary key

        $primaryKey = 'user_id';


         $columns = array(
           array( 'db' => '`acc`.`userid`', 'dt'    => 'userid', 'field' => 'userid','formatter'=>function($x,$row){
             return $this->encrypt->encode($row['userid']);
           }),
           array( 'db' => '`acc`.`sname`', 'dt'   => 'sname', 'field' => 'sname'),
              array( 'db' => '`acc`.`mname`', 'dt'   => 'mname', 'field' => 'mname'),
            array( 'db' => '`acc`.`fname`', 'dt'    => 'full_name', 'field' => 'fname','formatte  r'=>function($x,$row){
              return $row['fname'].' '.$row[0]['mname'].'.'.' '.$row['sname'];
            }),
              array( 'db' => '`acc`.`email`', 'dt'   => 'email', 'field' => 'email'),

              array( 'db' => '`ur`.`role_id`', 'dt'    => 'role_id', 'field' => 'role_id','formatter'=>function($x,$row){
                if ($row['role_id']  == 1) {
                  $role = 'Administrator';
                }elseif ($row['role_id']  == 3) {
                    $role = 'Evaluator';
                }elseif ($row['role_id']  == 4) {
                    $role = 'SMR Viewer';
                } else {
                  $role = 'Unassigned';
                }
                return $role;
              }),
          );
                    // print_r($columns);exit;

        // Include SQL query processing class

      $this->load->view('includes/common/ssp.customized.class.php');



          $joinQuery  = "FROM embis.user_type as ut
                        LEFT JOIN embis.acc_credentials as acc ON ut.user_id = acc.userid
                        LEFT JOIN crs.user_roles as ur ON ur.role_id = ut.role_id
                        ";

          // $extraWhere = 'fc.status  = "0" AND fc.facility_region = "'.$this->session->userdata('region').'"';
            // $extraWhere = '';
          $extraWhere = 'acc.region = "'.$this->session->userdata('region').'"';
          // $extraWhere = '';
          $groupBy = '';
          $having = null;
          // echo $this->db->last_query();
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );

  }

  function save_user_data(){
    $data  = $this->input->post();
    $this->db->set('user_id', $data['userid']);
    $this->db->set('role_id',$data['role_id']);
    $this->db->set('date_added',date('Y-m-d H:i:s'));
    $this->db->set('added_by',$this->session->userdata('userid'));
    $this->db->set('deleted',0);

      $query = $this->db->insert('user_type');

    if ($query) {

      $this->db->set('smr_stat', 1);
      $this->db->where('userid', $data['userid']);
      $this->db->update('acc');

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully added');
      window.location.href='https://iis.emb.gov.ph/embis/Clients/Smr/';
      </script>");
    }else {
      echo "alert('error !')";
    }
  }
  // remove emb employee rights - smr
  function remove_emb_emp_rights(){
    $userid = $this->encrypt->decode($this->input->post('client_id'));
    if (!empty($userid))
      $this->db->set('deleted',1);
      $this->db->where('user_id',$userid);
      $query = $this->db->delete('user_type');
  }

  function add_official_email(){
    $official_email = $this->input->post('official_email_data',TRUE);
    $official_email_id = $this->input->post('official_email_id',TRUE);
    $added_by = $this->session->userdata('userid');
    $region  =  $this->session->userdata('region');
    $datetoday = date('Y-m-d');
    $this->db->set('email',$official_email);
    $this->db->set('added_by',$added_by);
    $this->db->set('region',$region);
    $this->db->set('date_updated',$datetoday);

    if (!empty($official_email_id)) {
      $this->db->where('idofficial_emails',$official_email_id);
      $query = $this->db->update('official_emails');
    }else {
      $query = $this->db->insert('official_emails');
    }
    if ($query) {
      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully added');
      history.go(-1);
      </script>");
    }
  }

  function email_per_region(){
    $region  =  $this->session->userdata('region');
    $where = array('region' => $region,);
    $query_email = $this->db->select('*')->from('official_emails')->where($where)->get()->result_array();
      echo json_encode($query_email);
  }

  function resubmit_smr(){
    $data = $this->input->post();
      $this->db->set('date_submitted',$data['res_smr_id_date']);
      $this->db->set('is_submitted',1);
      $this->db->set('smr_status',3);
      $this->db->set('submitted_by',$this->session->userdata('userid'));
      $this->db->where('smr_id',$data['res_smr_id']);
      $query = $this->db->update('smr.smr');
      // echo $this->db->last_query();exit;
      ($query)? $msg = 'success':$msg = 'error';
      echo $msg;
  }
}
