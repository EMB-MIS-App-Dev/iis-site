
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Usersettings extends CI_Controller
  {
    private $usetdata;

    function __construct()
    {
      parent::__construct();

      // USER SESSION CHECK
      if ( ! $this->session->userdata('token')) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel');
      $this->load->library('session');

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');

      $this->load->library('upload');

      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");
    }

    function _settings_view($content)
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');

      $select = array(
        'ao.userid'     => $this->session->userdata('userid'),
      );
      $this->usetdata['acc_options'] = $this->Embismodel->selectdata('acc_options ao', '', $select);

      if ( ! empty($content)) {
        $this->load->view($content, $this->usetdata);
      }
    }

    function settings()
    {
      $this->_settings_view('Usersettings/settings');
    }

    function set_settings() {
      $data = $this->input->post();

      $select = array(
        'ao.userid'     => $this->session->userdata('userid'),
      );
      $ao_slct = $this->Embismodel->selectdata('acc_options ao', '', $select);

      $insert = array(
        'userid'     => $this->session->userdata('userid'),
        'sys_theme'  => !empty($data['sys_theme']) ? $data['sys_theme'] : '',
        'save_draft' => !empty($data['save_draft']) ? $data['save_draft'] : '',
        'inbox_prc'  => !empty($data['inbox_prc']) ? $data['inbox_prc'] : '',
        'draft_prc'  => !empty($data['draft_prc']) ? $data['draft_prc'] : '',
      );

      if(empty($ao_slct))
      {
        $ao_insrt = $this->Embismodel->insertdata('acc_options', $insert);
      }
      else {
        $update = array(
          'ao.sys_theme'  => !empty($data['sys_theme']) ? $data['sys_theme'] : '',
          'ao.save_draft' => !empty($data['save_draft']) ? $data['save_draft'] : '',
          'ao.inbox_prc'  => !empty($data['inbox_prc']) ? $data['inbox_prc'] : '',
          'ao.draft_prc'  => !empty($data['draft_prc']) ? $data['draft_prc'] : '',
        );
        $where = array(
          'ao.userid'     => $this->session->userdata('userid'),
        );
        $ao_updt = $this->Embismodel->updatedata($update, 'acc_options ao', $where);
      }

      $this->session->set_userdata('acc_options', $insert);

      echo "<script>alert('Saved.'); window.location.href='".base_url('Usersettings/Usersettings/settings')."';</script>";
    }

  }
?>
