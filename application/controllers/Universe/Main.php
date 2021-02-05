<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Main extends CI_Controller
  {
    private $univdata;

    function __construct()
    {
      parent::__construct();

      $this->load->model('Embismodel');
      $this->load->library('session');

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');

      $this->load->library('upload');

      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      // GLOBAL USER VARIABLES
      $this->univdata = array(
        'user_cred'     => $globvar['cred'][0],
        'user_rights'   => $globvar['rights'][0],
        'user_func'     => $globvar['func'],
      );
    }
    
    function index()
    {
      echo 'asdasdasda';
    }

    function _univ_view($content)
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('universe/func/foot');
      $this->load->view('includes/common/univ_styles');

  		if ( ! empty($content)) {
  			$this->load->view($content, $this->univdata);

        $this->load->view('Dms/func/modals');
        $this->load->view('universe/func/modals');
      }
    }

    function permitting()
    {
      $this->_univ_view('universe/permitting');
    }

    function monitoring()
    {
      $this->_univ_view('universe/monitoring');
    }

    function accomp_all()
    {
      $this->univdata['filter'] = !empty($this->session->userdata('accomp_all')) ? $this->session->userdata('accomp_all') : '';

      $this->univdata['region'] = $this->Embismodel->selectdata('acc_region AS ar', '', '');

      $this->_univ_view('universe/accomp_all');
    }

    // -----------------------------------------

    function accomp_filter()
    {
      $data['site'] = 'accomp_all';
      if($this->input->post('type') == 'filter') {
        $data['filter'] = array(
          'region'      => (!empty($this->input->post('region'))) ? $this->input->post('region') : '',
          'division'    => (!empty($this->input->post('division'))) ? $this->input->post('division') : '',
          'section'     => (!empty($this->input->post('section'))) ? $this->input->post('section') : '',
          'start_date'  => (!empty($this->input->post('start_date'))) ? $this->input->post('start_date') : '',
          'end_date'    => (!empty($this->input->post('end_date'))) ? $this->input->post('end_date') : '',
        );
      }
      else {
        $data['filter'] = '';
      }

      $this->session->set_userdata( 'accomp_filter', $data['filter']);
      echo json_encode($data);
    }

    // -----------------------------------------    RETURN DATA FUNCTIONS   ----------------------------------------- //

    function select_region()
    {
      $region_name = '';
      $div_where = '';

      if(!empty($this->input->post('region_name'))) {
        $type = ($this->input->post('region_name') == 'CO') ? 'co' : 'region';
        $div_where = array( 'axd.type'  => $type, );
      }
      else {
        $type = ($this->univdata['user_cred']['region'] == 'CO') ? 'co' : 'region';
        $div_where = array( 'axd.type'  => $type, );
      }

      $division = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $div_where);
      echo json_encode($division);
    }

    function select_division()
    {
      $division_name = !empty($this->input->post('division_name')) ? $this->input->post('division_name') : $this->univdata['user_cred']['divno'];
      $region = (!empty($this->input->post('region_name'))) ? $this->input->post('region_name') : $this->univdata['user_cred']['region'];

      $where['axsna_xsect'] = array('axsna.region' => $region);
      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable AS axsna', '', $where['axsna_xsect'] );
      $xsct = '0';

      if(!empty($exclude_sect))
      {
        foreach($exclude_sect as $key => $value) {
          if(count($exclude_sect)-1 == $key)
          {
            $xsct .= $value['secno'];
          }
          else {
            $xsct .= $value['secno'].',';
          }
        }
      }

      if($region != 'CO') {
        $where['xsect'] = $this->db->where('axs.divno = "'.$division_name.'" AND ( axs.region = "'.$region.'" OR axs.region = "R" ) AND axs.secno NOT IN ('.$xsct.')');
      }
      else {
        $where['xsect'] = $this->db->where('axs.divno = "'.$division_name.'" AND axs.region = "'.$region.'"');
      }
      $division = $this->Embismodel->selectdata('acc_xsect AS axs', '', '', $where['xsect']);
      echo json_encode($division);
    }

    function select_section()
    {
      $region = (!empty($this->input->post('region_name'))) ? $this->input->post('region_name') : $this->univdata['user_cred']['region'];
      $section_name = (!empty($this->input->post('section_name'))) ? $this->input->post('section_name') : 0;
      $division_name = !empty($this->input->post('division_name')) ? $this->input->post('division_name') : $this->univdata['user_cred']['divno'];

      $af_where = array('af.stat' => 1, 'af.secno' => $section_name, 'af.divno' => $division_name, 'af.region' => $region);
      $func_grp = $this->db->group_by("userid");
      $func = $this->Embismodel->selectdata('acc_function AS af', '', $af_where, $func_grp);
      $personnel = '';
      foreach ($func as $key => $value) {
        $sec_where = array(
          'ac.userid'   => $value['userid'],
          'ac.verified' => 1
        );
        $personnel1_grp = $this->db->group_by("userid");
        $personnel1 = $this->Embismodel->selectdata('acc_credentials AS ac', '', $sec_where, $personnel1_grp);
        if(!empty($personnel1)) {
          $personnel[] = $personnel1[0];
        }
      }

      echo json_encode($personnel);
    }
  }
?>
