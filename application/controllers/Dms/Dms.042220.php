
<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  error_reporting(E_ALL);
  // error_reporting(0);

  class Dms extends CI_Controller
  {
    private $dmsdata;

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


      $where['cred']      = array('ac.token' => $this->session->userdata('token'));
      $globvar['cred']    = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred']);

      $where['rights']    = array('ar.userid' => $this->session->userdata('userid'));
      $globvar['rights']  = $this->Embismodel->selectdata('acc_rights AS ar', '', $where['rights']);

      $where['func']      = array('af.userid' => $this->session->userdata('userid'));
      $globvar['func']    = $this->Embismodel->selectdata('acc_function AS af', '', $where['func']);

      // GLOBAL USER VARIABLES
      $this->dmsdata = array(
        'user_token'    => $globvar['cred'][0]['token'],
        'user_region'   => $globvar['cred'][0]['region'],
        'user_rights'   => $globvar['rights'][0],
        'user_func'     => $globvar['func'][0],
      );

      $tfltr = $this->session->userdata('trans_filter');
      $this->dmsdata['trans_filter'] = '';
      $this->dmsdata['trans_filter'] = (!empty($tfltr['fltr_comp'])) ? 'et.company_token = "'.$tfltr['fltr_comp'].'" AND ' : '';
      $this->dmsdata['trans_filter'] .= (!empty($tfltr['fltr_type'])) ? 'et.type = "'.$tfltr['fltr_type'].'" AND ' : '';
      $this->dmsdata['trans_filter'] .= (!empty($tfltr['fltr_stat'])) ? 'et.status = "'.$tfltr['fltr_stat'].'" AND ' : '';
    }

    function _dms_view($content)
  	{
      $this->session->set_userdata( 'trans_session', '' );

      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('includes/common/dms_styles');

  		if ( ! empty($content)) {
  			$this->load->view($content, $this->dmsdata);
      }
      $this->load->view('Dms/func/modals');
  	}

    function _dms_update($content)
  	{
      if ( ! $this->session->userdata('trans_session')) {
        redirect(base_url('Dms/Dms/all_transactions'));
      }
      else {
        $et_where = array( 'et.trans_no'   => $this->session->userdata('trans_session') );
        $trans_check = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where);

        if(empty($trans_check[0]['trans_no']))
        {
          redirect(base_url('Dms/Dms/all_transactions'));
        }
        else {
          $this->load->view('includes/common/header');
          $this->load->view('includes/common/sidebar');
          $this->load->view('includes/common/nav');
          $this->load->view('includes/common/footer');
          $this->load->view('includes/common/dms_styles');

      		if ( ! empty($content)) {
      			$this->load->view($content, $this->dmsdata);
          }

          $this->load->view('Dms/func/modals');
        }
      }
  	}

    function all_transactions()
    {
      $this->_dms_view('Dms/all_transactions');
    }

    function inbox()
    {
      $this->_dms_view('Dms/inbox');
    }

    function outbox()
    {
      $this->_dms_view('Dms/outbox');
    }

    function drafts()
    {
      $this->_dms_view('Dms/drafts');
    }

    function records()
    {
      $this->_dms_view('Dms/records');
    }

    function claim()
    {
      $this->_dms_view('Dms/claim');
    }

    function revisions()
    {
      $this->_dms_view('Dms/revisions');
    }

    function set_trans_session()
    {
      $this->session->set_userdata( 'trans_session', $this->input->post('trans_no') );
      $this->session->set_userdata( 'main_route_order', !empty($this->input->post('main_route_order')) ? $this->input->post('main_route_order') : '' );
    }

    function add_transaction()
    {
      $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

      $this->dmsdata['region'] = $this->Embismodel->selectdata('acc_region AS ar', '', '');
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS esy', '', '', $this->db->order_by('esy.system_order', 'asc'));
      $this->dmsdata['status'] = $this->Embismodel->selectdata('er_status AS est', '', '');
      $where['company'] = array('dc.deleted' => 0, );
      $this->dmsdata['company_list'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['company'], $this->db->order_by('dc.company_name', 'asc'));
      $this->dmsdata['action'] = $this->Embismodel->selectdata('er_action AS ea', '', '');

      $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session']);
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

      $accred_where = array('ac.token' => $this->dmsdata['user_token'] );
      $this->dmsdata['credentials'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $accred_where);

      $afunc_where = array('af.userid' => $this->dmsdata['credentials'][0]['userid'] );
      $this->dmsdata['function'] = $this->Embismodel->selectdata('acc_function AS af', '', $afunc_where);

      $route_order = ($this->dmsdata['trans_data'][0]['route_order'] == 0) ? 1 : $this->dmsdata['trans_data'][0]['route_order'];
      $ea_where = array(
        'ea.trans_no'     => $this->dmsdata['trans_session'],
        'ea.route_order'  => $route_order,
      );
      $this->dmsdata['attachments'] = $this->Embismodel->selectdata('er_attachments AS ea', '', $ea_where);

      $this->dmsdata['courier_type'] = $this->Embismodel->selectdata('er_courier AS ec', '', '');

      $this->assigned_slctn();

      $this->validate_form('Dms/func/add_transaction');
    }

    function update_transaction()
    {
      $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

      $this->dmsdata['region'] = $this->Embismodel->selectdata('acc_region AS ar', '', '');
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS esy', '', '', $this->db->order_by('esy.system_order', 'asc'));
      $this->dmsdata['status'] = $this->Embismodel->selectdata('er_status AS est', '', '');
      $where['company'] = array('dc.deleted' => 0, );
      $this->dmsdata['company_list'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['company']);
      $this->dmsdata['action'] = $this->Embismodel->selectdata('er_action AS ea', '', '');

      $accred_where = array('ac.token' => $this->dmsdata['user_token']);
      $this->dmsdata['credentials'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $accred_where);

      $afunc_where = array('af.userid' => $this->dmsdata['credentials'][0]['userid'] );
      $this->dmsdata['function'] = $this->Embismodel->selectdata('acc_function AS af', '', $afunc_where);

      $this->assigned_slctn();

      $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

      $this->dmsdata['trans_cred'] = '';
      // if(!empty($this->dmsdata['trans_data'][0]['receiver_section']))
      // {
        $cred_where = array(
          'ac.region'   => $this->dmsdata['trans_data'][0]['region'],
          'ac.divno'    => $this->dmsdata['trans_data'][0]['receiver_division'],
          'ac.secno'    => ($this->dmsdata['trans_data'][0]['receiver_section'] != 0) ? $this->dmsdata['trans_data'][0]['receiver_section'] : '',
          'ac.verified' => 1
        );
        $this->dmsdata['trans_cred'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $cred_where);
      // }

      $sec_where = array( 'axs.divno' => $this->dmsdata['trans_data'][0]['receiver_division'] );
      $this->dmsdata['section'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $sec_where);

      $dcomp_where = array( 'dcd.token' => $this->dmsdata['trans_data'][0]['company_token'] );
      $this->dmsdata['company_details'] = $this->Embismodel->selectdata('dms_company AS dcd', '', $dcomp_where);

      $route_order = ($this->dmsdata['trans_data'][0]['route_order'] == 0) ? 1 : $this->dmsdata['trans_data'][0]['route_order'];
      $ea_where = array(
        'ea.trans_no'     => $this->dmsdata['trans_session'],
        'ea.route_order'  => $route_order,
      );
      $this->dmsdata['attachments'] = $this->Embismodel->selectdata('er_attachments AS ea', '', $ea_where);

      $type_vars = array(
        'where' => array(
          'et.sysid'    => $this->dmsdata['trans_data'][0]['system'],
          'et.sys_show' => 0,
        ),
        'order' => $this->db->order_by('et.sysid asc, et.ssysid asc, et.header desc')
      );
      $this->dmsdata['trans_type'] = $this->Embismodel->selectdata('er_type AS et', '', $type_vars['where'], $type_vars['order']);

      $this->dmsdata['courier_type'] = $this->Embismodel->selectdata('er_courier AS ec', '', '');

      $this->add_inputs();

      $this->validate_form('Dms/func/input_transaction');
    }

    function revise_transaction()
    {
      $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

      $this->dmsdata['region'] = $this->Embismodel->selectdata('acc_region AS ar', '', '');
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS esy', '', '', $this->db->order_by('esy.system_order', 'asc'));
      $this->dmsdata['status'] = $this->Embismodel->selectdata('er_status AS est', '', '');
      $where['company'] = array('dc.deleted' => 0, );
      $this->dmsdata['company_list'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['company']);
      $this->dmsdata['action'] = $this->Embismodel->selectdata('er_action AS ea', '', '');

      $accred_where = array('ac.token' => $this->dmsdata['user_token']);
      $this->dmsdata['credentials'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $accred_where);

      $afunc_where = array('af.userid' => $this->dmsdata['credentials'][0]['userid'] );
      $this->dmsdata['function'] = $this->Embismodel->selectdata('acc_function AS af', '', $afunc_where);

      $this->assigned_slctn();

      $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

      $this->dmsdata['trans_cred'] = '';
      // if(!empty($this->dmsdata['trans_data'][0]['receiver_section']))
      // {
        $cred_where = array(
          'ac.region'   => $this->dmsdata['trans_data'][0]['region'],
          'ac.divno'    => $this->dmsdata['trans_data'][0]['receiver_division'],
          'ac.secno'    => ($this->dmsdata['trans_data'][0]['receiver_section'] != 0) ? $this->dmsdata['trans_data'][0]['receiver_section'] : '',
          'ac.verified' => 1,
        );
        $this->dmsdata['trans_cred'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $cred_where);
      // }

      $sec_where = array( 'axs.divno' => $this->dmsdata['trans_data'][0]['receiver_division'] );
      $this->dmsdata['section'] = $this->Embismodel->selectdata('acc_xsect AS axs', '', $sec_where);

      $dcomp_where = array( 'dcd.token' => $this->dmsdata['trans_data'][0]['company_token'] );
      $this->dmsdata['company_details'] = $this->Embismodel->selectdata('dms_company AS dcd', '', $dcomp_where);

      $route_order = ($this->dmsdata['trans_data'][0]['route_order'] == 0) ? 1 : $this->dmsdata['trans_data'][0]['route_order'];
      $ea_where = array(
        'ea.trans_no'     => $this->dmsdata['trans_session'],
        'ea.route_order'  => $route_order,
      );
      $this->dmsdata['attachments'] = $this->Embismodel->selectdata('er_attachments AS ea', '', $ea_where);

      $type_vars = array(
        'where' => array(
          'et.sysid'    => $this->dmsdata['trans_data'][0]['system'],
          'et.sys_show' => 0,
        ),
        'order' => $this->db->order_by('et.sysid asc, et.ssysid asc, et.header desc')
      );
      $this->dmsdata['trans_type'] = $this->Embismodel->selectdata('er_type AS et', '', $type_vars['where'], $type_vars['order']);

      $this->add_inputs();

      $history_where = array( 'etl.trans_no' => $this->dmsdata['trans_session'] );
      $history_order = $this->db->order_by('etl.route_order', 'desc' );
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );

      $ea_where = array( 'eat.trans_no' => $this->dmsdata['trans_session'] );
      $this->dmsdata['attachment_view'] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where );

      $this->dmsdata['courier_type'] = $this->Embismodel->selectdata('er_courier AS ec', '', '');

      $this->validate_form('Dms/func/revise_transaction');
    }

    function route_transaction()
    {
      $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

      $this->dmsdata['region'] = $this->Embismodel->selectdata('acc_region AS ar', '', '');
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS esy', '', '', $this->db->order_by('esy.system_order', 'asc'));
      $this->dmsdata['status'] = $this->Embismodel->selectdata('er_status AS est', '', '');
      $where['company'] = array('dc.deleted' => 0, );
      $this->dmsdata['company_list'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['company']);
      $this->dmsdata['action'] = $this->Embismodel->selectdata('er_action AS ea', '', '');

      $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

      $cred_where = array('ac.region' => $this->dmsdata['trans_data'][0]['region'], 'ac.verified' => 1 );
      $this->dmsdata['trans_cred'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $cred_where);

      $accred_where = array('ac.token' => $this->dmsdata['user_token']);
      $this->dmsdata['credentials'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $accred_where);

      $dcomp_where = array( 'dcd.token' => $this->dmsdata['trans_data'][0]['company_token'] );
      $this->dmsdata['company_details'] = $this->Embismodel->selectdata('dms_company AS dcd', '', $dcomp_where);

      $afunc_where = array('af.userid' => $this->dmsdata['credentials'][0]['userid'] );
      $this->dmsdata['function'] = $this->Embismodel->selectdata('acc_function AS af', '', $afunc_where);

      $route_order = ($this->dmsdata['trans_data'][0]['route_order'] == 0) ? 1 : $this->dmsdata['trans_data'][0]['route_order'];
      $ea_where = array(
        'ea.trans_no'     => $this->dmsdata['trans_session'],
        'ea.route_order'  => $route_order+1,
      );
      $this->dmsdata['attachments'] = $this->Embismodel->selectdata('er_attachments AS ea', '', $ea_where);

      $this->assigned_slctn();

      $type_vars = array(
        'where' => array(
          'et.sysid'    => $this->dmsdata['trans_data'][0]['system'],
          'et.sys_show' => 0,
        ),
        'order' => $this->db->order_by('et.sysid asc, et.ssysid asc, et.header desc')
      );
      $this->dmsdata['trans_type'] = $this->Embismodel->selectdata('er_type AS et', '', $type_vars['where'], $type_vars['order']);

      $this->add_inputs();

      $history_where = array( 'etl.trans_no' => $this->dmsdata['trans_session'] );
      $history_order = $this->db->order_by('etl.route_order', 'desc' );
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );

      $ea_where = array( 'eat.trans_no' => $this->dmsdata['trans_session'] );
      $this->dmsdata['attachment_view'] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where );

      $this->dmsdata['courier_type'] = $this->Embismodel->selectdata('er_courier AS ec', '', '');

      $this->validate_form('Dms/func/route_transaction');
    }

    function acknowledgeLetter()
    {
      if(empty($this->session->userdata('trans_session'))){
        redirect(base_url('Dms/Dms/notfound'));
      }
      else {
        $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

        $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

        $trans_where = array( 'ou.region' =>   $this->dmsdata['trans_data'][0]['region'] );
        $this->dmsdata['header'] = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '', $trans_where);

        $translog_where = array(
          'etl.trans_no'    => $this->dmsdata['trans_session'],
          'etl.route_order' => 1
        );
        $this->dmsdata['trans_log'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $translog_where);

        if($this->dmsdata['trans_data'][0]['route_order'] != 0) {
          // redirect('Dms/func/ackno_letter.php?trans_no='.$this->encryption->encrypt($this->dmsdata['trans_session']);
          // $this->load->view('Dms/func/ackno_letter.php?trans_no='.$this->encryption->encrypt($this->dmsdata['trans_session']), $this->dmsdata);
          $this->load->view('Dms/func/ackno_letter', $this->dmsdata);
        }
        else {
           redirect(base_url('Dms/Dms/notfound'));
        }
      }
    }

    function dispositionForm()
    {
      if(empty($this->session->userdata('trans_session'))){
        redirect(base_url('Dms/Dms/notfound'));
      }
      else {
        $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

        $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

        $trans_where = array( 'ou.region' =>   $this->dmsdata['trans_data'][0]['region'] );
        $this->dmsdata['header'] = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '', $trans_where);

        // $translog_where = array(
        //   'etl.trans_no'    => $this->dmsdata['trans_session']
        // );

        // $this->dmsdata['trans_log'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $translog_where );

        $this->dmsdata['trans_log'] = $this->db->query('SELECT * FROM er_transactions_log AS etl WHERE etl.trans_no = '.$this->dmsdata['trans_session'].' AND (etl.receiver_id != "" OR etl.type = 84)')->result_array();

        if($this->dmsdata['trans_data'][0]['route_order'] != 0) {
          $this->load->view('Dms/func/dispo_form', $this->dmsdata);
        }
        else {
           redirect(base_url('Dms/Dms/notfound'));
        }
      }
    }

    function dispositionFormBlank()
    {
      if(empty($this->session->userdata('trans_session'))){
        redirect(base_url('Dms/Dms/notfound'));
      }
      else {
        $this->dmsdata['trans_session'] = $this->session->userdata('trans_session');

        $trans_where = array( 'et.trans_no' => $this->dmsdata['trans_session'] );
        $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

        $trans_where = array( 'ou.region' =>   $this->dmsdata['trans_data'][0]['region'] );
        $this->dmsdata['header'] = $this->Embismodel->selectdata('office_uploads_document_header AS ou', '', $trans_where);

        $this->dmsdata['trans_log'] = $this->db->query('SELECT * FROM er_transactions_log AS etl WHERE etl.trans_no = '.$this->dmsdata['trans_session'].' AND (etl.receiver_id != "" OR etl.type = 84)')->result_array();

        if($this->dmsdata['trans_data'][0]['route_order'] != 0) {
          $this->load->view('Dms/func/dispo_form_blank', $this->dmsdata);
        }
        else {
           redirect(base_url('Dms/Dms/notfound'));
        }
      }
    }

    // ===========================================        DB STATEMENT FUNCTIONS           =================================================== //

    function validate_form($site)
    {
      if(isset($_POST['process_transaction']))
      {
        $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');

        $this->form_validation->set_rules('system', '', 'required');
        $this->form_validation->set_rules('type', '', 'required');
        $this->form_validation->set_rules('subject', '', 'required');
        $this->form_validation->set_rules('status', '', 'required');
        $this->form_validation->set_rules('company', '', 'required');

        // if(!empty(($this->input->post('asgnto_multiple')))
        // {
        //   $this->form_validation->set_rules('division[]', '', 'required');
        //   $this->form_validation->set_rules('section[]', '', 'required');
        //   $this->form_validation->set_rules('receiver[]', '', 'required');
        // } else
        if (empty(($this->input->post('asgnto_multiple'))))
        {
          if(!in_array($this->input->post('status'), array('17', '18', '19', '24', '27'))) // END STATUS
          {
            $this->form_validation->set_rules('division', '', 'required');
            $this->form_validation->set_rules('section', '', 'required');
            $this->form_validation->set_rules('receiver', '', 'required');
          }
        }

        $this->form_validation->set_rules('action', '', 'required');

        // FIRST TRANSACTION ROUTE
        if($this->dmsdata['trans_data'][0]['route_order'] == 0) {
          $this->form_validation->set_rules('attachment', '', 'callback_attachment_exists');
        }

        // TRANSACTION STATUS "FOR FILING / CLOSED"
        if($this->input->post('status') == 24)
        {
          // RECORDS SECTION
          if($this->dmsdata['user_func']['secno'] == '77')
          {
            $this->form_validation->set_rules('records_location', '', 'required');
          }
          $this->form_validation->set_rules('attachment', '', 'callback_attachment_exists');
        }
        // SENT VIA COURIER
        if($this->input->post('status') == '19') {
          $this->form_validation->set_rules('courier_type', '', 'required_courier');
        }

        $this->form_validation->set_message('required', '( required )' );
        $this->form_validation->set_message('attachment_exists', '( required )' );
        $this->form_validation->set_message('required_courier', '( For "Sent Via Courier", Courier Type is Required )' );

        if($this->form_validation->run() == FALSE)
        {
          $this->_dms_update($site);
        }
        else {
          $this->process_transaction();
        }
      }
      else if(isset($_POST['save_draft']))
      {
        $this->save_draft();
      }
      else {
        $this->_dms_update($site);
      }
    }

    function create_transaction()
    {
      $region_where = array('ar.rgnnum' => $this->dmsdata['user_region'] );
      $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

      $newtrans_data = array(
        'table'   => 'er_transactions AS et',
        'select'  => 'MAX(et.trans_no) AS max_trans_no',
        'where'   => array('region' => $this->dmsdata['user_region'] ), // where clause for region
      );
      $new_transaction = $this->Embismodel->selectdata( $newtrans_data['table'], $newtrans_data['select'], $newtrans_data['where']);

      $current_yr = date("Y");
      $trans_rgn = $region_data[0]['rgnid'] * 1000000;

      if(sizeof($new_transaction) != 0) {
        $max_id = $new_transaction[0]['max_trans_no'];

        $transaction_yr = intval($max_id / 100000000);

        if($transaction_yr == $current_yr) {
          $trans_no = $max_id + 1;
        }
        else {
          $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
        }
      }
      else {
        $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
      }

      $trans_token = $this->dmsdata['user_region'].'-'.$current_yr.'-'.sprintf('%06d', fmod($trans_no, 1000000));

      $date_in = date('Y-m-d H:i:s');

      $acwhere = array('ac.token' => $this->dmsdata['user_token'] );
      $credq = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acwhere );

      $mname = ' ';
      if(!empty($credq[0]['mname']) )
        $mname = ' '.$credq[0]['mname'][0].'. ';

      $suffix = '';
      if(!empty($credq[0]['suffix']) )
        $suffix = ' '.$credq[0]['suffix'];

      $sender_name = ucwords($credq[0]['fname'].$mname.$credq[0]['sname']).$suffix;

      $ins_translog = array(
        'trans_no'        => $trans_no,
        'route_order'     => 1,
        'sender_id'       => $this->dmsdata['user_token'],
        'sender_name'     => $sender_name,
        'sender_ipadress' => $this->input->ip_address(),
        'sender_region'   => $this->dmsdata['user_region'],
        'date_in'         => $date_in,
      );
      $this->Embismodel->insertdata('er_transactions_log', $ins_translog);

      $start_date = date('Y-m-d');

      $ins_trans = array(
        'trans_no'    => $trans_no,
        'token'       => $trans_token,
        'region'      => $this->dmsdata['user_region'],
        'sender_id'   => $this->dmsdata['user_token'],
        'start_date'  => $start_date,
      );
      $this->Embismodel->insertdata('er_transactions', $ins_trans);

      $this->session->set_userdata( 'trans_session', $trans_no );

      redirect(base_url('Dms/Dms/add_transaction'));
    }

    function save_draft()
    {
      $data = array(
        'user_token'    => $this->dmsdata['user_token'],
        'user_region'   => $this->dmsdata['user_region'],
        'trans_session' => $this->session->userdata('trans_session'),
        'start_date'    => date('Y-m-d'),
        'post_data'     => $this->input->post(),
      );

      $where['trans'] = array('et.trans_no' => $data['trans_session']);
      $data['trnsctn'] = $this->Embismodel->selectdata('er_transactions AS et', '', $where['trans'] );

      $where['comp'] = array('dc.token' => $data['post_data']['company'] );
      $data['company'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['comp'] );

      $where['type'] = array('et.id' => $data['post_data']['type'] );
      $data['type'] = $this->Embismodel->selectdata('er_type AS et', '', $where['type'] );

      $where['status'] = array('es.id' => $data['post_data']['status'] );
      $data['status'] = $this->Embismodel->selectdata('er_status AS es', '', $where['status'] );

      $where['cred_snder'] = array('ac.token' => $data['user_token'] );
      $data['cred_snder'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred_snder'] );

      $snder_mname = (!empty($data['cred_snder'][0]['mname'])) ? ' '.$data['cred_snder'][0]['mname'][0].'. ' : ' ';
      $snder_suffix = (!empty($data['cred_snder'][0]['suffix'])) ? ' '.$data['cred_snder'][0]['suffix'] : '';
      $data['snder'] = $data['cred_snder'][0]['fname'].$snder_mname.$data['cred_snder'][0]['sname'].$snder_suffix;

      $where['cred_rcver'] = array('ac.token' => $data['post_data']['receiver'] );
      $data['cred_rcver'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred_rcver'] );

      $rcver_mname = (!empty($data['cred_rcver'][0]['mname']) ) ? ' '.$data['cred_rcver'][0]['mname'][0].'. ' : ' ';
      $rcver_suffix = (!empty($data['cred_rcver'][0]['suffix']) ) ? ' '.$data['cred_rcver'][0]['suffix'] : '';
      $data['rcver'] = $data['cred_rcver'][0]['fname'].$rcver_mname.$data['cred_rcver'][0]['sname'].$rcver_suffix;

      $trans_vars = array(
        'table' => 'er_transactions AS et',
        'set'   => array(
          'et.company_token'      => $data['post_data']['company'],
          'et.company_name'       => $data['company'][0]['company_name'],
          'et.emb_id'             => $data['company'][0]['emb_id'],
          'et.subject'            => $data['post_data']['subject'],
          'et.system'             => $data['post_data']['system'],
          'et.type'               => $data['post_data']['type'],
          'et.type_description'   => $data['type'][0]['name'],
          'et.step'               => 0,
          'et.status'             => $data['post_data']['status'],
          'et.status_description' => $data['status'][0]['name'],
          'et.receive'            => 0,
          // 'et.sender_id'          => $data['user_token'],
          // 'et.sender_name'        => $data['snder'],
          'et.receiver_division'  => $data['post_data']['division'],
          'et.receiver_section'   => $data['post_data']['section'],
          'et.receiver_region'    => $data['cred_rcver'][0]['region'],
          'et.receiver_id'        => $data['post_data']['receiver'],
          'et.receiver_name'      => $data['rcver'],
          'et.action_taken'       => $data['post_data']['action'],
          'et.remarks'            => $data['post_data']['remarks'],
          'et.start_date'         => $data['start_date'],
        ),
        'where' => array(
          'et.trans_no'           => $data['trans_session'],
        ),
      );
      $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );

      $translog_vars = array(
        'table' => 'er_transactions_log AS etl',
        'set'   => array(
          'etl.subject'             => $data['post_data']['subject'],
          'etl.receiver_id'         => (!empty($data['post_data']['receiver'])) ? $data['post_data']['receiver'] : 0,
          'etl.receiver_name'       => (!empty($data['rcver'])) ? $data['rcver'] : '--',
          'etl.receiver_region'     => $data['cred_rcver'][0]['region'],
          'etl.type'                => $data['post_data']['type'],
          'etl.status'              => $data['post_data']['status'],
          'etl.status_description'  => $data['status'][0]['name'],
          'etl.action_taken'        => $data['post_data']['action'],
          'etl.remarks'             => $data['post_data']['remarks'],
        ),
        'where' => array(
          'etl.trans_no'            => $data['post_data']['trans_no'],
          'etl.route_order'         => $data['trnsctn'][0]['route_order'],
        ),
      );
      $result = $this->Embismodel->updatedata( $translog_vars['set'], $translog_vars['table'], $translog_vars['where'] );

      // SUBCATEGORIES OF SUBTYPES
      $this->add_inputs_tbdb($data);

      if($result)
      {
        $swal_arr = array(
          'title'     => 'SUCCESS!',
          'text'      => 'IIS No. '.$data['trnsctn'][0]['token'].' saved successfully.',
          'type'      => 'success',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);

        redirect(base_url('Dms/Dms/drafts'));
      }
    }

    function process_transaction()
    {
      $result = '';
      $data = array(
        'user_token'        => $this->dmsdata['user_token'],
        'user_region'       => $this->dmsdata['user_region'],
        'trans_session'     => $this->session->userdata('trans_session'),
        'main_route_order'  => $this->session->userdata('main_route_order'),
        'start_date'        => date('Y-m-d'),
        'date_in'           => date('Y-m-d H:i:s'),
        'date_out'          => date('Y-m-d H:i:s'),
        'post_data'         => $this->input->post(),
      );

      $where['trans'] = array(
        'etrans.trans_no'         => $data['trans_session'],
        'etrans.main_route_order' => $data['main_route_order'],
      );

      if(!empty($data['main_route_order'])) {
        $table['trans'] = 'er_transactions_multi AS etrans';
      }
      else{
        $table['trans'] = 'er_transactions AS etrans';
      }
      $data['trnsctn'] = $this->Embismodel->selectdata( $table['trans'], '', $where['trans'] );

      $where['comp'] = array('dc.token' => $data['post_data']['company'] );
      $data['company'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['comp'] );

      $where['type'] = array('et.id' => $data['post_data']['type'] );
      $data['type'] = $this->Embismodel->selectdata('er_type AS et', '', $where['type'] );

      $where['status'] = array('es.id' => $data['post_data']['status'] );
      $data['status'] = $this->Embismodel->selectdata('er_status AS es', '', $where['status'] );

      $where['cred_snder'] = array('ac.token' => $data['user_token'] );
      $data['cred_snder'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred_snder'] );

      $snder_mname = (!empty($data['cred_snder'][0]['mname'])) ? ' '.$data['cred_snder'][0]['mname'][0].'. ' : ' ';
      $snder_suffix = (!empty($data['cred_snder'][0]['suffix'])) ? ' '.$data['cred_snder'][0]['suffix'] : '';
      $data['snder'] = $data['cred_snder'][0]['fname'].$snder_mname.$data['cred_snder'][0]['sname'].$snder_suffix;

      $where['cred_rcver'] = array('ac.token' => $data['post_data']['receiver'] );
      $data['cred_rcver'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['cred_rcver'] );

      $rcver_mname = (!empty($data['cred_rcver'][0]['mname']) ) ? ' '.$data['cred_rcver'][0]['mname'][0].'. ' : ' ';
      $rcver_suffix = (!empty($data['cred_rcver'][0]['suffix']) ) ? ' '.$data['cred_rcver'][0]['suffix'] : '';
      $data['rcver'] = $data['cred_rcver'][0]['fname'].$rcver_mname.$data['cred_rcver'][0]['sname'].$rcver_suffix;

      // APPROVED BY D
      $stat_dsc = ($data['post_data']['status'] == 5 && $data['user_token'] == '25dde3133d1748') ? 'signed by the Director' : $data['status'][0]['name'];

      if(!empty($data['trnsctn'][0]['multiprc']) || !empty($data['main_route_order']))
      {
        if(!empty($this->input->post('asgnto_multiple'))) // equal to 'multiple'
        {
          // get er_transactions_multi['main_route_order']
          // add concatenation of ';' and er_transactions_multi['route_order']
          //
        }
        else // equal to 0
        {
          // get er_transactions_multi['main_route_order']
          $translog_vars = array(
            'set'   => array(
              'etl.subject'             => $data['post_data']['subject'],
              'etl.sender_id'           => $data['user_token'],
              'etl.sender_ipadress'     => $this->input->ip_address(),
              'etl.receiver_id'         => (!empty($data['post_data']['receiver'])) ? $data['post_data']['receiver'] : 0,
              'etl.receiver_name'       => (!empty($data['rcver'])) ? $data['rcver'] : '--',
              'etl.receiver_region'     => $data['cred_rcver'][0]['region'],
              'etl.type'                => $data['post_data']['type'],
              'etl.status'              => $data['post_data']['status'],
              'etl.status_description'  => $stat_dsc,
              'etl.action_taken'        => $data['post_data']['action'],
              'etl.remarks'             => $data['post_data']['remarks'],
              'etl.date_out'            => $data['date_out'],
            ),
            'where' => array(
              'etl.trans_no'            => $data['trnsctn'][0]['trans_no'],
              'etl.main_route_order'    => $data['trnsctn'][0]['main_route_order'],
              'etl.route_order'         => $data['trnsctn'][0]['route_order']+1,
              'etl.sender_id'           => $data['user_token'],
            ),
          );
          $result = $this->Embismodel->updatedata( $translog_vars['set'], 'er_transactions_log AS etl', $translog_vars['where'] );

          $trans_vars = array(
            'table' => 'er_transactions AS et',
            'set'   => array(
              'et.route_order'        => $data['trnsctn'][0]['route_order']+1,
              'et.company_token'      => $data['post_data']['company'],
              'et.company_name'       => $data['company'][0]['company_name'],
              'et.emb_id'             => $data['company'][0]['emb_id'],
              'et.subject'            => $data['post_data']['subject'],
              'et.system'             => $data['post_data']['system'],
              'et.type'               => $data['post_data']['type'],
              'et.type_description'   => $data['type'][0]['name'],
              'et.status'             => $data['post_data']['status'],
              'et.status_description' => $stat_dsc,
              'et.receive'            => 0,
              'et.sender_id'          => $data['user_token'],
              'et.sender_name'        => $data['snder'],
              'et.receiver_division'  => (!empty($data['post_data']['division'])) ? $data['post_data']['division'] : $data['cred_snder'][0]['divno'],
              'et.receiver_section'   => $data['post_data']['section'],
              'receiver_region'       => (!empty($data['cred_rcver'][0]['region'])) ? $data['cred_rcver'][0]['region'] : $data['cred_snder'][0]['region'],
              'et.receiver_id'        => (!empty($data['post_data']['receiver'])) ? $data['post_data']['receiver'] : 0,
              'et.receiver_name'      => (!empty($data['rcver'])) ? $data['rcver'] : '--',
              'et.action_taken'       => $data['post_data']['action'],
              'et.remarks'            => $data['post_data']['remarks'],
              'et.records_location'   => !empty($data['post_data']['records_location']) ? $data['post_data']['records_location'] : '',
              'et.qr_code_token'      => !empty($data['post_data']['qr_code']) ? $data['post_data']['qr_code'] : '',
            ),
            'where' => array(
              'et.trans_no' => $data['post_data']['trans_no'],
            ),
          );
          $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        }
      }
      else // equal to 0
      {
        if(!empty($this->input->post('asgnto_multiple'))) // equal to 'multiple'
        {
          $where['etlog_slct'] = array(
            'etl.trans_no'         => $data['trnsctn'][0]['trans_no'],
            'etl.main_route_order' => $data['trnsctn'][0]['main_route_order'],
            'etl.route_order'      => $data['trnsctn'][0]['route_order']+1,
          );
          $etlog_slct = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $where['etlog_slct']);

          foreach ($data['post_data']['multislct_prsnl'] as $key => $value) {
            $data['multiprsnl'][$key]  = explode(';', $value);

            $etl_insert = array(
                'trans_no'            => $data['trnsctn'][0]['trans_no'],
                'main_route_order'    => $data['trnsctn'][0]['route_order'],
                'route_order'         => 1,
                'multi_cntr'          => $key+1,
                'subject'             => $data['post_data']['subject'],
                'sender_id'           => $data['user_token'],
                'sender_name'         => $data['snder'],
                'sender_region'       => $data['user_region'],
                'sender_ipadress'     => $this->input->ip_address(),
                'receiver_id'         => (!empty($data['multiprsnl'][$key][3])) ? $data['multiprsnl'][$key][3] : 0,
                'receiver_name'       => (!empty($data['multiprsnl'][$key][4])) ? $data['multiprsnl'][$key][4] : '--',
                'receiver_region'     => (!empty($data['multiprsnl'][$key][0])) ? $data['multiprsnl'][$key][0] : $data['cred_snder'][0]['region'],
                'type'                => $data['post_data']['type'],
                'status'              => $data['post_data']['status'],
                'status_description'  => $stat_dsc,
                'action_taken'        => $data['post_data']['action'],
                'remarks'             => $data['post_data']['remarks'],
                'date_in'             => (!empty($etlog_slct[0]['date_in'])) ? $etlog_slct[0]['date_in'] : $data['date_in'],
                'date_out'            => $data['date_out'],
            );

            $result = $this->Embismodel->insertdata( 'er_transactions_log', $etl_insert );

            if($result) {
              $where['etlog_dlte'] = array(
                'trans_no'         => $data['trnsctn'][0]['trans_no'],
                'main_route_order' => $data['trnsctn'][0]['main_route_order'],
                'route_order'      => $data['trnsctn'][0]['route_order']+1,
              );
              $result = $this->Embismodel->deletedata( 'er_transactions_log', $where['etlog_dlte'] );
            }

            $insert['er_trans_multi'] = array (
              'trans_no'            => $data['trnsctn'][0]['trans_no'],
              'token'               => $data['trnsctn'][0]['token'],
              'main_route_order'    => $data['trnsctn'][0]['route_order'],
              'route_order'         => 1,
              'multiprc'            => 0,
              'multi_cntr'          => $key+1,
              'company_token'       => $data['post_data']['company'],
              'company_name'        => $data['company'][0]['company_name'],
              'emb_id'              => $data['company'][0]['emb_id'],
              'subject'             => $data['post_data']['subject'],
              'system'              => $data['post_data']['system'],
              'type'                => $data['post_data']['type'],
              'type_description'    => $data['type'][0]['name'],
              'status'              => $data['post_data']['status'],
              'status_description'  => $stat_dsc,
              'receive'             => 0,
              'sender_id'           => $data['user_token'],
              'sender_name'         => $data['snder'],
              'receiver_division'   => (!empty($data['multiprsnl'][$key][1])) ? $data['multiprsnl'][$key][1] : $data['cred_snder'][0]['divno'],
              'receiver_section'    => $data['multiprsnl'][$key][2],
              'receiver_region'     => (!empty($data['multiprsnl'][$key][0])) ? $data['multiprsnl'][$key][0] : $data['cred_snder'][0]['region'],
              'receiver_id'         => (!empty($data['multiprsnl'][$key][3])) ? $data['multiprsnl'][$key][3] : 0,
              'receiver_name'       => (!empty($data['multiprsnl'][$key][4])) ? $data['multiprsnl'][$key][4] : '--',
              'action_taken'        => $data['post_data']['action'],
              'remarks'             => $data['post_data']['remarks'],
              'start_date'          => $data['trnsctn'][0]['start_date'],
              'records_location'    => !empty($data['post_data']['records_location']) ? $data['post_data']['records_location'] : '',
              'region'              => $data['trnsctn'][0]['region'],
            );

            // echo '<pre>'; print_r($insert['er_trans_multi']);
            $result = $this->Embismodel->insertdata( 'er_transactions_multi', $insert['er_trans_multi'] );

            $translog_vars = array(
              'set'   => array( 'et.multiprc' => 1 ),
              'where' => array(
                'et.trans_no'         => $data['trnsctn'][0]['trans_no'],
                'et.route_order'      => $data['trnsctn'][0]['route_order'],
              ),
            );
            $result = $this->Embismodel->updatedata( $translog_vars['set'], 'er_transactions AS et', $translog_vars['where'] );
          }
          // echo $result;
           // exit;
        }
        else // equal to 0 (normal flow)
        {
          $translog_vars = array(
            'set'   => array(
              'etl.subject'             => $data['post_data']['subject'],
              'etl.sender_id'           => $data['user_token'],
              'etl.sender_ipadress'     => $this->input->ip_address(),
              'etl.receiver_id'         => (!empty($data['post_data']['receiver'])) ? $data['post_data']['receiver'] : 0,
              'etl.receiver_name'       => (!empty($data['rcver'])) ? $data['rcver'] : '--',
              'etl.receiver_region'     => $data['cred_rcver'][0]['region'],
              'etl.type'                => $data['post_data']['type'],
              'etl.status'              => $data['post_data']['status'],
              'etl.status_description'  => $stat_dsc,
              'etl.action_taken'        => $data['post_data']['action'],
              'etl.remarks'             => $data['post_data']['remarks'],
              'etl.date_out'            => $data['date_out'],
            ),
            'where' => array(
              'etl.trans_no'            => $data['post_data']['trans_no'],
              'etl.route_order'         => $data['trnsctn'][0]['route_order']+1,
              'etl.sender_id'           => $data['user_token'],
            ),
          );
          $result = $this->Embismodel->updatedata( $translog_vars['set'], 'er_transactions_log AS etl', $translog_vars['where'] );

          $trans_vars = array(
            'table' => 'er_transactions AS et',
            'set'   => array(
              'et.route_order'        => $data['trnsctn'][0]['route_order']+1,
              'et.company_token'      => $data['post_data']['company'],
              'et.company_name'       => $data['company'][0]['company_name'],
              'et.emb_id'             => $data['company'][0]['emb_id'],
              'et.subject'            => $data['post_data']['subject'],
              'et.system'             => $data['post_data']['system'],
              'et.type'               => $data['post_data']['type'],
              'et.type_description'   => $data['type'][0]['name'],
              'et.status'             => $data['post_data']['status'],
              'et.status_description' => $stat_dsc,
              'et.receive'            => 0,
              'et.sender_id'          => $data['user_token'],
              'et.sender_name'        => $data['snder'],
              'et.receiver_division'  => (!empty($data['post_data']['division'])) ? $data['post_data']['division'] : $data['cred_snder'][0]['divno'],
              'et.receiver_section'   => $data['post_data']['section'],
              'receiver_region'       => (!empty($data['cred_rcver'][0]['region'])) ? $data['cred_rcver'][0]['region'] : $data['cred_snder'][0]['region'],
              'et.receiver_id'        => (!empty($data['post_data']['receiver'])) ? $data['post_data']['receiver'] : 0,
              'et.receiver_name'      => (!empty($data['rcver'])) ? $data['rcver'] : '--',
              'et.action_taken'       => $data['post_data']['action'],
              'et.remarks'            => $data['post_data']['remarks'],
              'et.records_location'   => !empty($data['post_data']['records_location']) ? $data['post_data']['records_location'] : '',
              'et.qr_code_token'      => !empty($data['post_data']['qr_code']) ? $data['post_data']['qr_code'] : '',
            ),
            'where' => array(
              'et.trans_no' => $data['post_data']['trans_no'],
            ),
          );
          $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        }
      }


      if($result) {
        // SUBCATEGORIES OF SUBTYPES
        $this->add_inputs_tbdb($data);
        // UNIVERSE DATA
        $this->universe_insert($data);
      }

      if($result)
      {
        $swal_arr = array(
          'title'     => 'SUCCESS!',
          'text'      => 'IIS No. '.$data['trnsctn'][0]['token'].' processing successful.',
          'type'      => 'success',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);

        redirect( base_url('Dms/Dms/outbox'));
      }
    }

    function add_inputs_tbdb($data='')
    {
      if(!empty($data['post_data']['system']) && !empty($data['post_data']['type']))
      {
        if(!empty($data['post_data']['appli_type']))
        {
          $where['sub_type'] = array(
            'est.id'      => $data['post_data']['appli_type'],
            'est.ssysid'  => $data['post_data']['type']
          );
          $sub_type = $this->Embismodel->selectdata('er_sub_type AS est', '', $where['sub_type'] );
          $subtype_dsc = $sub_type[0]['dsc'];
        }
        else {
          $subtype_dsc = '';
        }

        switch ($data['post_data']['system']) {
          case 1: // ORD
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_ord AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_ord AS esa',
              'table_ins' => 'er_system_ord',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 2: // ADMINISTRATIVE
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_admin AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_admin AS esa',
              'table_ins' => 'er_system_admin',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
                ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 4: // PERMITTING
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_permit AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'    => 'er_system_permit AS esa',
              'table_ins'   => 'er_system_permit',
              'insert'      => array(
                'trans_no'              => $data['trans_session'],
                'sub_system'            => $data['post_data']['type'],
                'sub_desc'              => $data['type'][0]['name'],
                'subtype_id'            => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'          => $subtype_dsc,
                'permit_no'             => (!empty($data['post_data']['permit_no'])) ? $data['post_data']['permit_no'] : '',
                'consultant_id'         => '',
                'consultant_name'       => '',
                'exp_start_date'        => (!empty($data['post_data']['exp_start_date'])) ? $data['post_data']['exp_start_date'] : '0000-00-00',
                'exp_end_date'          => (!empty($data['post_data']['exp_end_date'])) ? $data['post_data']['exp_end_date'] : '0000-00-00',
              ),
              'set'         => array(
                'esa.sub_system'        => $data['post_data']['type'],
                'esa.sub_desc'          => $data['type'][0]['name'],
                'esa.subtype_id'        => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'      => $subtype_dsc,
                'esa.permit_no'         => (!empty($data['post_data']['permit_no'])) ? $data['post_data']['permit_no'] : '',
                'esa.consultant_id'     => '',
                'esa.consultant_name'   => '',
                'esa.exp_start_date'    => (!empty($data['post_data']['exp_start_date'])) ? $data['post_data']['exp_start_date'] : '0000-00-00',
                'esa.exp_end_date'      => (!empty($data['post_data']['exp_end_date'])) ? $data['post_data']['exp_end_date'] : '0000-00-00',
                ),
              'where'       => array(
                'esa.trans_no'          => $data['trans_session'],
              )
            );
            break;

          case 10: // LAB
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_lab AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_lab AS esa',
              'table_ins' => 'er_system_lab',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 11: // EEIU
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_eeiu AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_eeiu AS esa',
              'table_ins' => 'er_system_eeiu',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 12: // RECORDS
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_rec AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_rec AS esa',
              'table_ins' => 'er_system_rec',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          case 13: // LEGAL
            $esa_where = array( 'esa.trans_no' => $data['trans_session'] );
            $esa = $this->Embismodel->selectdata('er_system_legal AS esa', '', $esa_where );

            $esa_vars = array(
              'table_up'  => 'er_system_legal AS esa',
              'table_ins' => 'er_system_legal',
              'insert'    => array(
                'trans_no'            => $data['trans_session'],
                'sub_system'          => $data['post_data']['type'],
                'sub_desc'            => $data['type'][0]['name'],
                'subtype_id'          => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'subtype_desc'        => $subtype_dsc,
              ),
              'set'       => array(
                'esa.sub_system'      => $data['post_data']['type'],
                'esa.sub_desc'        => $data['type'][0]['name'],
                'esa.subtype_id'      => (!empty($data['post_data']['appli_type'])) ? $data['post_data']['appli_type'] : 0,
                'esa.subtype_desc'    => $subtype_dsc,
              ),
              'where'     => array(
                'esa.trans_no'        => $data['trans_session'],
              )
            );
            break;

          default:
            $esa = '';
            break;
        }

        if(!empty($esa)) {
          $result = $this->Embismodel->updatedata( $esa_vars['set'] , $esa_vars['table_up'], $esa_vars['where'] );
        }
        else {
          $result = $this->Embismodel->insertdata( $esa_vars['table_ins'], $esa_vars['insert'] );
        }
      }
    }

    function universe_insert($data='')
    {
      switch ($data['post_data']['type']) {
        case 1: $type = 'ecc'; break;
        case 2: $type = 'cnc'; break;
        case 3: $type = 'luc'; break;
        case 4: $type = 'dp'; break;
        case 5: $type = 'po'; break;
        case 27: $type = 'pco'; break;
        case 8: $type = 'sqi'; break;
        case 7: $type = 'piccs'; break;
        case 10: $type = 'ccoic'; break;
        case 9: $type = 'ccoreg'; break;
        case 34: $type = 'cot'; break;
        case 33: $type = 'mnfst'; break;
        case 32: $type = 'ptt'; break;
        case 47: $type = 'tsd'; break;
        case 6: $type = 'hwgen'; break;
        case 48: $type = 'trc'; break;
        default: $type = ''; break;
      }

      if(!empty($type))
      {
        $set_in = 'du.'.$type;
        $univ_vars = array(
          'table' => 'dms_universe AS du',
          'set'   => array( $set_in   => $data['post_data']['status'] ),
          'where' => array('du.token' => $data['post_data']['company']),
        );
        $result = $this->Embismodel->updatedata($univ_vars['set'], $univ_vars['table'], $univ_vars['where']);
      }
    }

    function delete_transaction()
    {
      if(isset($_POST['delete_trans_btn']))
      {
        $data['post_data'] = $this->input->post('multidlte_trans_no');

        foreach ($data['post_data'] as $key => $value) {
          $trans_vars = array(
            'table' => 'er_transactions AS et',
            'set'   => array( 'et.status'   => 0, ),
            'where' => array( 'et.trans_no' => $value ),
          );
          $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        }

        if(count($data['post_data']) > 1) {
          $trans_no = 'Numbers : ';
          foreach ($data['post_data'] as $key => $value) {
            $trans_no .= $value.', ';
          }
        }
        else {
          $trans_no = 'No. '.$data['post_data'][0];
        }
        if($result)
        {
          $swal_arr = array(
            'title'     => '- Deleted -',
            'text'      => 'IIS '.$trans_no.' deleted successfully.',
            'type'      => 'success',
          );
          $this->session->set_flashdata('swal_arr', $swal_arr);
        }
      }
      else {
        $swal_arr = array(
          'title'     => '- ErRoR -',
          'text'      => 'There was an error upon deletion on DMS - Revisions. Please contact System Administrator.',
          'type'      => 'error',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);
      }
      redirect(base_url('Dms/Dms/revisions'));
    }

    function update_transrec()
    {
      if(isset($_POST['relocate_transrec']))
      {
        $data['post_data'] = $this->input->post();
        $trans_vars = array(
          'table' => 'er_transactions AS et',
          'set'   => array( 'et.records_location' => $data['post_data']['transrec_location'] ),
          'where' => array( 'et.trans_no'         => $data['post_data']['transrec_no'] ),
        );
        $result = $this->Embismodel->updatedata( $trans_vars['set'], $trans_vars['table'], $trans_vars['where'] );
        if($result)
        {
          $swal_arr = array(
            'title'     => '- Updated -',
            'text'      => 'Record of IIS No. '.$data['post_data']['transrec_no'].' updated successfully.',
            'type'      => 'success',
          );
          $this->session->set_flashdata('swal_arr', $swal_arr);
        }
      }
      else {
        $swal_arr = array(
          'title'     => '- ErRoR -',
          'text'      => 'There was an error upon updating data in DMS - Records. Please contact System Administrator.',
          'type'      => 'error',
        );
        $this->session->set_flashdata('swal_arr', $swal_arr);
      }

        redirect(base_url('Dms/Dms/records'));
    }

    function doReceive()
    {
      $trans_log_insert = array(
        'trans_no'        => $er_trans_query[0]['trans_no'],
        'route_order'     => $er_trans_query[0]['route_order']+1,
        'sender_id'       => $sender_id,
        'sender_name'     => $sender_name,
        'sender_ipadress' => $this->input->ip_address(),
        'sender_region'   => $this->dmsdata['user_region'],
        'date_in'         => $date_in,
      );
      $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

      $et_set = array( 'et.receive' => 1, );
      $et_update_where = array( 'et.trans_no' => $data['trans_no'] );
      $result = $this->Embismodel->updatedata( $et_set, 'er_transactions AS et', $et_update_where );
    }

    function filter_query()
    {
      $where['fltr_comp'] = ($this->dmsdata['user_region'] == 'CO') ? '' : array( 'dc.region_name' => $this->dmsdata['user_region'] );
      $this->dmsdata['fltr_comp'] = $this->Embismodel->selectdata('dms_company AS dc', '', $where['fltr_comp'], $this->db->order_by('dc.company_name', 'asc'));
      $this->dmsdata['fltr_systm'] = $this->Embismodel->selectdata('er_systems AS esy', '', '', $this->db->order_by('esy.system_order', 'asc'));
      $this->dmsdata['fltr_stat'] = $this->Embismodel->selectdata('er_status AS est', '', '');

      $where['prsnl_cred'] = array('ac.region' => $this->dmsdata['user_region'], 'ac.verified' => 1);
      $this->dmsdata['fltr_prsnl'] = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['prsnl_cred'] );

      $this->dmsdata['modal'] = 'dms_filter';

      $this->load->view('Dms/func/onclick_modals', $this->dmsdata);
    }

    function multipersonnels()
    {
      $rcvr = $this->input->post('receiver');

      $data[] = '';
      foreach ($rcvr as $key => $value) {
        if(!empty($value)) {
          foreach ($this->input->post() as $postkey => $postvalue) {
            $data[$key][$postkey] = $postvalue[$key];
          }
          $where['multiprsnl'] = array('ac.token' => $value);
          $multiprsnl = $this->Embismodel->selectdata('acc_credentials AS ac', '', $where['multiprsnl'] );

          $division = (!empty($multiprsnl[0]['division'])) ? '|'.$multiprsnl[0]['division'] : '';

          $section = '';
          if(!empty($multiprsnl[0]['secno']))
          {
            $sec_where = array( 'axs.secno'  => $multiprsnl[0]['secno'] );
            $section = $this->Embismodel->selectdata('acc_xsect AS axs', '', $sec_where);
            $section = '|'.$section[0]['secode'];
          }

          $data[$key]['name'] = trim(ucwords($multiprsnl[0]['fname'].' '.substr($multiprsnl[0]['mname'], 0, 1).' '.$multiprsnl[0]['sname'].' '.$multiprsnl[0]['suffix']));
          $data[$key]['prsnl'] = trim(ucwords($multiprsnl[0]['fname'].' '.$multiprsnl[0]['sname'].' '.$multiprsnl[0]['suffix']).' - '.$multiprsnl[0]['region'].$division.$section);
        }
      }
      echo json_encode($data);
    }

    // ====================================================        COMMON METHODS           =========================================================== //


    function assigned_slctn()
    {
      $reg_type = (!empty($this->dmsdata['trans_data'][0]['receiver_region'])) ? $this->dmsdata['trans_data'][0]['receiver_region'] : $this->dmsdata['user_region'];

      $reg_type = ($reg_type == 'CO') ? 'co' : 'region';
      $div_where = array('adv.type' => $reg_type );
      // if($this->dmsdata['function'][0]['func'] == 'Administrator') {
      //   $div_where = array('adv.type' => $reg_type );
      // }
      // else {
      //   $div_where = array(
      //     'adv.type'  => $reg_type,
      //     'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //   );
      // }


      // switch ($this->dmsdata['function'][0]['func']) {
      //   case 'Administrator':
      //   case 'Sample User':
      //     $div_where = array('adv.type' => $reg_type );
      //     break;

      //   case 'Director':
      //   case 'Assistant Director':
      //     $div_where = array('adv.type' => $reg_type );
      //     break;

      //   case 'Division Chief':
      //   case 'Assistant Division Chief':
      //     $div_where = array('adv.type' => $reg_type );
      //     break;

      //   case 'Section Chief':
      //     $div_where = array(
      //       'adv.type'  => $reg_type,
      //       'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //     );
      //     break;

      //   default:
      //     if(!empty($this->dmsdata['credentials'][0]['secno']))
      //     {
      //       if($this->dmsdata['user_region'] == 'CO')
      //       {
      //         switch ($this->dmsdata['credentials'][0]['divno']) {
      //           case 14: // OFFICE OF THE DIRECTOR
      //             $div_where = array('adv.type' => $reg_type );
      //             break;

      //           default:
      //             $div_where = array(
      //               'adv.type'  => $reg_type,
      //               'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //             );
      //             break;
      //         }
      //       }
      //       else {
      //         switch ($this->dmsdata['credentials'][0]['divno']) {
      //           case 1: // OFFICE OF THE REGIONAL DIRECTOR
      //             $div_where = array('adv.type' => $reg_type );
      //             break;

      //           default:
      //             $div_where = array(
      //               'adv.type'  => $reg_type,
      //               'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //             );
      //             break;
      //         }
      //       }
      //     }
      //     else {
      //       $div_where = array(
      //         'adv.type'  => $reg_type,
      //         'adv.divno' => $this->dmsdata['function'][0]['divno'],
      //       );
      //     }
      //     break;
      // }

      $this->dmsdata['division'] = $this->Embismodel->selectdata('acc_xdvsion AS adv', '', $div_where);
      // print_r($this->dmsdata['division']); exit;
      // }
    }

    function add_inputs()
    {
      if(!empty($this->dmsdata['trans_data'][0]['type']))
      {
        $est_vars = '';
        switch ($this->dmsdata['trans_data'][0]['system']) {
          case 1: $est_vars = array( 'table' => 'er_system_ord AS est' ); break; // ORD
          case 2: $est_vars = array( 'table' => 'er_system_admin AS est' ); break; // ADMINISTRATIVE
          case 3: $est_vars = array( 'table' => 'er_system_finance AS est' ); break; // FINANCIAL
          case 4: $est_vars = array( 'table' => 'er_system_permit AS est' ); break; // PERMITTING
          case 12: $est_vars = array( 'table' => 'er_system_rec AS est' ); break; // RECORDS
          case 13: $est_vars = array( 'table' => 'er_system_legal AS est' ); break; // RECORDS
          default: $est_vars = array( 'table' => '' ); break; // DEFAULT
        }

        if(!empty($est_vars['table']))
        {
          $est_vars += array(
            'where' => array( 'est.trans_no' => $this->dmsdata['trans_session'] )
          );
          $this->dmsdata['system_types'] = $this->Embismodel->selectdata($est_vars['table'], '', $est_vars['where']);

          $est_vars['where'] = array( 'est.ssysid'  => $this->dmsdata['system_types'][0]['sub_system'] );
          $this->dmsdata['sub_types'] = $this->Embismodel->selectdata('er_sub_type AS est', '', $est_vars['where']);
        }

        $this->dmsdata['add_input'] = $this->load->view('Dms/func/updateinputs', $this->dmsdata, TRUE);
      }
    }

    function attachment_exists()
    {
      $route_order = $this->dmsdata['trans_data'][0]['route_order']+1;
      $ea_where = array(
        'ea.trans_no'     => $this->dmsdata['trans_session'],
        'ea.route_order'  => $route_order,
      );
      $ea_slct = $this->Embismodel->selectdata( 'er_attachments AS ea', '', $ea_where );

      // if($route_order == 1) {
        if(!$ea_slct) {
          return false;
        }
        else {
          return true;
        }
      // }
      // else {
      //   return true;
      // }
    }

    // ============================================        AJAX FUNCTIONS           ===================================================== //

    function additional_inputs()
    {
      $data = $this->input->post();

      $type_where = array( 'et.id' => $data['subsystem'] );
      $data['type'] = $this->Embismodel->selectdata('er_type AS et', '', $type_where);

      if($data['system'] == 6)
      {
        $subtype_vars = array(
          'table' => 'er_sub_swm AS ess',
          'where' => array( 'ess.ssysid'  => $data['subsystem'] ),
          'order' => 'ess.ssysid asc',
        );
      }
      else {
        $subtype_vars = array(
          'table' => 'er_sub_type AS est',
          'where' => array(
            'est.sysid'   => $data['system'],
            'est.ssysid'  => $data['subsystem']
          ),
          'order' => 'est.sysid asc, est.ssysid asc',
        );
      }

      $data['sub_types'] = $this->Embismodel->selectdata( $subtype_vars['table'], '', $subtype_vars['where'], $subtype_vars['order'] );

      $this->load->view('Dms/func/addinputs', $data);
    }

    function view_transaction()
    {
      $this->dmsdata['post_data'] = $this->input->post();

      $trans_where = array( 'et.trans_no' => $this->dmsdata['post_data']['trans_no'] );
      $this->dmsdata['trans_data'] = $this->Embismodel->selectdata('er_transactions AS et', '', $trans_where);

      $type_where = array('es.id' => $this->dmsdata['trans_data'][0]['system'] );
      $this->dmsdata['system'] = $this->Embismodel->selectdata('er_systems AS es', '', $type_where);

      $history_where = array( 'etl.trans_no' => $this->dmsdata['post_data']['trans_no'] );
      $history_order = $this->db->order_by('etl.route_order', 'desc');
      $this->dmsdata['trans_history'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', $history_where, $history_order );

      foreach ($this->dmsdata['trans_history'] as $key => $value) {
        $ea_where = array(
          'eat.trans_no'    => $value['trans_no'],
          'eat.route_order' => $value['route_order'],
        );
        $ea_order = $this->db->order_by('eat.route_order', 'desc');
        $this->dmsdata['attachment_view'][$key] = $this->Embismodel->selectdata('er_attachments AS eat', '', $ea_where, $ea_order );
      }

      $where['inthread'] = array(
        'etl.trans_no'  => $this->dmsdata['post_data']['trans_no'],
        'etl.sender_id' => $this->dmsdata['user_token']
      );
      $where['inthread'] = $this->db->where($where['inthread']);
      $where['or_inthread'] = $this->db->or_where('etl.receiver_id', $this->dmsdata['user_token'] );
      $this->dmsdata['prnl_inthread'] = $this->Embismodel->selectdata('er_transactions_log AS etl', '', '', $where['inthread'], $where['or_inthread'] );



      $dcomp_where = array( 'dcd.token' => $this->dmsdata['trans_data'][0]['company_token'] );
      $this->dmsdata['company_details'] = $this->Embismodel->selectdata('dms_company AS dcd', '', $dcomp_where);

      $this->load->view('Dms/func/view_transaction', $this->dmsdata);
    }

    function receive_transaction()
    {
      $data = $this->input->post();

      $region = $this->session->userdata('region');
      $region_id = 8;
      $sender_id = $this->session->userdata('token');

      $date_in = date('Y-m-d H:i:s');

      $et_where = array('et.trans_no' => $data['trans_no'] );
      $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where );

      $acsender_where = array('ac.token' => $sender_id );
      $senderq = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acsender_where );

      $mname = ' ';
      if(!empty($senderq[0]['mname']) )
        $mname = ' '.$senderq[0]['mname'][0].'. ';

      $suffix = '';
      if(!empty($senderq[0]['suffix']) )
        $suffix = ' '.$senderq[0]['suffix'];

      $sender_name = $senderq[0]['fname'].$mname.$senderq[0]['sname'].$suffix;

      $trans_log_insert = array(
        'trans_no'        => $er_trans_query[0]['trans_no'],
        'route_order'     => $er_trans_query[0]['route_order']+1,
        'sender_id'       => $sender_id,
        'sender_name'     => $sender_name,
        'sender_ipadress' => $this->input->ip_address(),
        'sender_region'   => $this->dmsdata['user_region'],
        'date_in'         => $date_in,
      );
      $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

      $et_set = array( 'et.receive' => 1, );
      $et_update_where = array( 'et.trans_no' => $data['trans_no'] );
      $result = $this->Embismodel->updatedata( $et_set, 'er_transactions AS et', $et_update_where );

      if($result)
      {
        $res['error'] = 0;
        $res['site'] = base_url('Dms/Dms/inbox');
      }

      echo json_encode($res);
    }
    // File upload
    function fileUpload()
    {
      // TRANSACTION COUNTER
      $this->dmsdata['cnt'] = (!empty($this->dmsdata['cnt'])) ? $this->dmsdata['cnt']++ : 1;
      $data = array(
        'user_token'        => $this->dmsdata['user_token'],
        'trans_region'      => $this->input->post('region'),
        'trans_session'     => $this->input->post('trans_session'),
        'main_route_order'  => $this->input->post('main_route_order'),
        'route_order'       => $this->input->post('route_order')+1,
      );

      $path = 'dms/'.date('Y').'/'.$data['trans_region'].'/';
      $folder = $data['trans_session'];

      // $old = umask(0);
      if(!is_dir('uploads/'.$path.'/'.$folder)) {
        mkdir('uploads/'.$path.'/'.$folder, 0777, TRUE);
      }
      // umask($old);

      $region_where = array('ar.rgnnum' => $data['trans_region'] );
      $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

      $att_token1 = fmod($data['trans_session'], 1000000);

      $ea_w = array(
        'ea.trans_no'     => $data['trans_session'],
        'ea.route_order'  => $data['route_order'],
      );
      $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);
      $main_ro = (!empty($data['main_route_order'])) ? '-MR'.str_replace(';', '', $data['main_route_order']) : '';
      $att_token = $data['trans_region'].date('Y').$main_ro.'-FT'.$data['route_order'].'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);

      if(!empty($_FILES['file']['name'])) {
        // Set preference
        $config = array(
          'upload_path'   => 'uploads/'.$path.'/'.$folder,
          'allowed_types' => '*',
          'max_size'      => '20480', // max_size in kb
          'file_name'     => $att_token,
          'overwrite'     => FALSE,
        );
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if(!$this->upload->do_upload('file')) {
          // Show error on uploading
          $uploadError = array('error' => $this->upload->display_errors());
        }
        else {
          // Get data about the file
          $uploadData = $this->upload->data();
          $erattach_insert = array(
            'trans_no'      => $data['trans_session'],
            'route_order'   => $data['route_order'],
            'file_id'       => $ea_q[0]['max_fileid']+1, // order_by
            'token'         => $att_token,
            'file_name'     => $_FILES['file']['name'],
          );
          $this->Embismodel->insertdata('er_attachments', $erattach_insert);
        }
      }
    }

    function system_select()
    {
      $system = $this->input->post('system');
      $type_vars = array(
        'where' => array(
          'et.sysid'    => $system,
          'et.id !='    => 83,
          'et.sys_show' => 0,
        ),
        'order' => $this->db->order_by('et.sysid asc, et.ssysid asc, et.header desc'),
      );
      $typeq = $this->Embismodel->selectdata('er_type AS et', '', $type_vars['where'], $type_vars['order']);
      echo json_encode($typeq);
    }

    function select_region()
    {
      $region_name = '';
      $div_where = '';

      if(!empty($this->input->post('region_name'))) {
        $type = ($this->input->post('region_name') == 'CO') ? 'co' : 'region';
        $div_where = array( 'axd.type'  => $type, );
      }

      $division = $this->Embismodel->selectdata('acc_xdvsion AS axd', '', $div_where);
      echo json_encode($division);
    }

    function select_division()
    {
      $division_name = $this->input->post('division_name');
      $region = (!empty($this->input->post('region_name'))) ? $this->input->post('region_name') : $this->session->userdata('region');

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
      // echo $xsct;

      if($region != 'CO') {
        $where['xsect'] = $this->db->where('axs.divno = "'.$division_name.'" AND ( axs.region = "'.$region.'" OR axs.region = "R" ) AND axs.secno NOT IN ('.$xsct.')');
      }
      else {
        $where['xsect'] = $this->db->where('axs.divno = "'.$division_name.'" AND axs.region = "'.$region.'"');
      }

      $division = $this->Embismodel->selectdata('acc_xsect AS axs', '', '', $where['xsect']);

        // echo $this->db->last_query();

      echo json_encode($division);
    }

    function select_section()
    {
      $region = (!empty($this->input->post('region_name'))) ? $this->input->post('region_name') : $this->session->userdata('region');
      $section_name = (!empty($this->input->post('section_name'))) ? $this->input->post('section_name') : '';
      $division_name = $this->input->post('division_name');


      $sec_where = array('ac.verified' => 1, 'ac.secno' => $section_name, 'ac.divno' => $division_name, 'ac.region' => $region);
      $personnel = $this->Embismodel->selectdata('acc_credentials AS ac', '', $sec_where);
      // echo $this->db->last_query();
      echo json_encode($personnel);
    }

    function company_list()
    {
      $where = array('dc.status' => '0' );
      $companyq = $this->Embismodel->selectdata('dms_company AS dc', '', $where);
      echo json_encode($companyq);
    }

    function company_details()
    {
      $company_token = $this->input->post('company_token');
      $where = array('dc.token' => $company_token );
      $company_details = $this->Embismodel->selectdata('dms_company AS dc', '', $where);
      echo json_encode($company_details);
    }

    function transtable_filter()
    {
      $data['site'] = 'all_transactions';
      if($this->input->post('type') == 'filter') {
        $data['filter'] = array(
          'fltr_comp' => (!empty($this->input->post('filter_company'))) ? $this->input->post('filter_company') : '',
          'fltr_type' => (!empty($this->input->post('filter_transtype'))) ? $this->input->post('filter_transtype') : '',
          'fltr_stat' => (!empty($this->input->post('filter_status'))) ? $this->input->post('filter_status') : '',
        );
      }
      else {
        $data['filter'] = '';
      }

      $this->session->set_userdata( 'trans_filter', $data['filter']);
      echo json_encode($data);
    }

    function trans_qrcode(){
      $trans_stat = $this->input->post('trns_stat',TRUE);
      $token      = $this->encrypt->decode($this->input->post('token',TRUE));
      if($trans_stat == '5' AND ($this->session->userdata('trans_qrcode') == 'yes' OR $this->session->userdata('superadmin_rights') == 'yes')){
        $wheretrans    = $this->db->where('et.token = "'.$token.'"');
        $selecttrans   = $this->Embismodel->selectdata('er_transactions AS et','et.qr_code_token','',$wheretrans);
        $random        = str_split('QWERTYUIOP12345678'); shuffle($random);
        $randomkey     = array_slice($random, 0, 18);
        $key = implode('', $randomkey);
        $paded = str_pad($key, 18, '0', STR_PAD_LEFT);
        $delimited = '';
        if(empty($selecttrans[0]['qr_code_token'])){
          for($i = 0; $i < 18; $i++) {
           $delimited .= $paded[$i];
           if($i == 2 || $i == 5 || $i == 8 || $i == 11 || $i == 14) {
               $delimited .= '-';
           }
          }
        }else{
          $delimited = $selecttrans[0]['qr_code_token'];
        }


        echo "<label>Please copy and paste QR Code into the document to be routed:</label><br>";
        echo "<input type='hidden' class='form-control' name='qr_code' value='".$delimited."' readonly>";
        echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fiis.emb.gov.ph/verify?token=".$delimited."%2F&choe=UTF-8' style='width:150px;'>";
      }

    }
  }
?>
