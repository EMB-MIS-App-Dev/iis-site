<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Form_Data extends CI_Controller
  {
    private $thisdata;
    function __construct()
    {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      $this->thisdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
    }

    function index()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      echo 'index';
      // $this->load->view('superadmin/pds/personal_info');
    }

    private function array_debug($data='') { $data['data'] = $data; $this->load->view('Dms/debug', $data); }

    private function _alert($alert_data="", $redirect_page="", $code="", $type="")
    {
      $asd = '';
      if(empty($alert_data)) {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'You have Accessed an Unidentified Page and have been Redirected to this Page. '.$code,
          'type'      => 'warning',
        );
      }
      else {
        if(!empty($code)) {
          $alert_data['text'] = $alert_data['text'].' '.$code;
        }
      }
      if(empty($type)) {
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
      }
      else {
        $this->session->set_flashdata('swal_alert_data', $alert_data);
      }

      if(empty($redirect_page)) {
        $redirect_page = base_url('dms/documents/all');
      }
      redirect($redirect_page);
    }

    private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

    private function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->thisdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->thisdata['user']['region'] || $session_ucred['secno'] != $this->thisdata['user']['secno'] || $session_ucred['divno'] != $this->thisdata['user']['divno']) {
        $this->thisdata = array(
          'user_id'     => $session_ucred['userid'],
          'user_region' => $session_ucred['region'],
          'user_token'  => $session_ucred['token'],
        );
        $this->thisdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

    function pds_children()
    {
      $post = $this->input->post();

      $children_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "name" => $post["name"],
        "date_of_birth" => $post["date_of_birth"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_children', $children_insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function update_pds_children()
    {
      $post = $this->input->post();

      $update['name'] = $post["name"];
      if(!empty($post["date_of_birth"])) {
        $update['date_of_birth'] = $post["date_of_birth"];
      }

      $this->db->trans_start();
      $this->db->update('pds_children', $update, array("id" => $post['id'], "userid" => $this->thisdata['user']['id']) );
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function delete_pds_children()
    {
      $post = $this->input->post();

      $this->db->trans_start();
      $this->db->delete('pds_children', array("id" => $post['id'], "userid" => $this->thisdata['user']['id']) );
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function delete_educpage()
    {
      $post = $this->input->post();

      $this->db->trans_start();
      $this->db->delete($post['table'], array("id" => $post['id'], "userid" => $this->thisdata['user']['id']) );
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function delete_workpage()
    {
      $post = $this->input->post();

      $this->db->trans_start();
      $this->db->delete($post['table'], array("id" => $post['id'], "userid" => $this->thisdata['user']['id']) );
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function pds_educational_background()
    {
      $post = $this->input->post('post');

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "level" => $post["level"],
        "name_of_school" => $post["name_of_school"],
        "basic_education_degree_course" => $post["basic_education_degree_course"],
        "attendance_from" => $post["attendance_from"],
        "attendance_to" => $post["attendance_to"],
        "highest_level_unit_earned" => $post["highest_level_unit_earned"],
        "year_graduated" => $post["year_graduated"],
        "scholarship_honor_received" => $post["scholarship_honor_received"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_educational_background', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function pds_civil_service()
    {
      $post = $this->input->post('post');

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "eligibility_description" => $post["eligibility_description"],
        "rating" => $post["rating"],
        "date_of_examination" => $post["date_of_examination"],
        "place_of_examination" => $post["place_of_examination"],
        "license_no" => $post["license_no"],
        "date_of_validity" => $post["date_of_validity"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_civil_service', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
          print_r($post);
      }
      else {
          echo 'success';
      }
    }

    function pds_work_experience()
    {
      $post = $this->input->post('post');

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "inclusive_dates_from" => $post["inclusive_dates_from"],
        "inclusive_dates_to" => $post["inclusive_dates_to"],
        "position_title" => $post["position_title"],
        "company" => $post["company"],
        "monthly_salary" => $post["monthly_salary"],
        "salary_grade_and_step" => $post["salary_grade_and_step"],
        "status_of_appointment" => $post["status_of_appointment"],
        "is_government" => $post["is_government"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_work_experience', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function pds_voluntary_work()
    {
      $post = $this->input->post('post');

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "name_address_of_organization" => $post["name_address_of_organization"],
        "inclusive_dates_from" => $post["inclusive_dates_from"],
        "inclusive_dates_to" => $post["inclusive_dates_to"],
        "no_of_hours" => $post["no_of_hours"],
        "position_nature_of_work" => $post["position_nature_of_work"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_voluntary_work', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function pds_learning_development()
    {
      $post = $this->input->post('post');

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "title" => $post["title"],
        "inclusive_dates_from" => $post["inclusive_dates_from"],
        "inclusive_dates_to" => $post["inclusive_dates_to"],
        "no_of_hours" => $post["no_of_hours"],
        "type_of_ld" => $post["type_of_ld"],
        "conducted_by" => $post["conducted_by"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_learning_development', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function pds_other_info()
    {
      $post = $this->input->post('post');

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "skills_and_hobbies" => $post["skills_and_hobbies"],
        "non_academic_distinctions" => $post["non_academic_distinctions"],
        "membership" => $post["membership"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_other_info', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }

    function pds_person_references()
    {
      $post = $this->input->post();

      $insert = array(
        "userid" => $this->thisdata['user']['id'],
        "name" => $post["name"],
        "address" => $post["address"],
        "tel_no" => $post["tel_no"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_person_references', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
          echo 'success';
      }
    }
  }
?>
