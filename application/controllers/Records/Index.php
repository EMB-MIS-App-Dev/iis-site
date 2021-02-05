
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Index extends CI_Controller
  {
    private $data;

    function __construct()
    {
      parent::__construct();

      $this->load->model('Embismodel');
      $this->load->library('session');

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');

      $this->load->library('upload');

      $this->load->library('encryption');

      $this->load->helper('email');

      date_default_timezone_set("Asia/Manila");
    }

    function sampel()
    {
      if (valid_email('rey_efa@yahoo.com'))
      {
          echo 'email is valid';
      }
      else
      {
          echo 'email is not valid';
      }
    }

    function _records_view($tab)
  	{
      $this->session->set_userdata( 'current_tab', $tab );

      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('includes/common/dms_styles');

  		if ( !empty($tab) ) {
  			$this->load->view('Records/'.$tab, $this->data);
      }

      $this->load->view('Records/func/modals');
      $this->load->view('Dms/func/modals');
  	}

    function eia()
    {
      $where = array('et.sysid' => 4, 'et.ssysid ' => 1, 'et.header' => 0, 'et.sys_show' => 0 );
      $this->data['system_type'] = $this->Embismodel->selectdata('er_type et', '', $where);

      $this->_records_view('eia');
    }

    function air_water()
    {
      $where = array('et.sysid' => 4, 'et.ssysid ' => 2, 'et.header' => 0, 'et.sys_show' => 0 );
      $this->data['system_type'] = $this->Embismodel->selectdata('er_type et', '', $where);

      $this->_records_view('air_water');
    }

    function chemical()
    {
      $where = array('et.sysid' => 4, 'et.ssysid ' => 3, 'et.header' => 0, 'et.sys_show' => 0 );
      $this->data['system_type'] = $this->Embismodel->selectdata('er_type et', '', $where);

      $this->_records_view('chemical');
    }

    function hazwaste()
    {
      $where = array('et.sysid' => 4, 'et.ssysid ' => 4, 'et.header' => 0, 'et.sys_show' => 0 );
      $this->data['system_type'] = $this->Embismodel->selectdata('er_type et', '', $where);

      $this->_records_view('hazwaste');
    }

  }
?>
