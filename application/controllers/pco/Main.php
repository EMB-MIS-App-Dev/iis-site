<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Main extends CI_Controller
  {
    private $dmsdata;
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

      $this->dmsdata = array(
        'user_id'     => $this->session->userdata('userid'),
        'user_region' => $this->session->userdata('region'),
        'user_token'  => $this->session->userdata('token'),
      );

      $this->dmsdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );
    }

    function index()
  	{
      if(empty($this->pco_data['account_id']))
      {
        echo '<script>alert("SESSION TIMEOUT")</script>';
      }
      // Common Views
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      // Custom Views
      $this->load->view('pco/includes/styles');
      $this->load->view('pco/includes/header');
      $this->load->view('Pco/func/modals');
      // Dynamic View Call
      if(!empty($this->uri->segment(4)))
      {
        // pass to router, sets global variables inside the function
        $this->router($this->uri->segment(3), $this->uri->segment(4));
      }
      else if(!empty($this->uri->segment(3)))
      {
        switch ($this->uri->segment(3)) {
          case 'new': $this->add_new_application(); break;
          default: $this->load->view('pco/index', $this->pco_data); break;
        }
      }
      else {
    		$this->load->view('pco/index', $this->pco_data);
      }
      // Custom Views
      $this->load->view('pco/includes/footer');
      $this->load->view('pco/includes/address');
  	}

    private function router($appli_id='', $seg_step='')
  	{
      $where_pco_appli = array (
        'appli_id'  => $appli_id,
        'user_id'   => $this->pco_data['user_id']
      );
      $get_pco_appli = $this->olsys_model->selectdata('pco_application', '', $where_pco_appli);

      if(!empty($get_pco_appli))
      {
        // IMPORTANT: SETS GLOBAL APPLI_ID AND STEP, TO BE USED ON ALL FUNCTIONS
        $this->pco_data['appli_id'] = $appli_id;
        $this->pco_data['step'] = $seg_step;
        $this->pco_data['main_step'] = $get_pco_appli[0]['step'];

        if($get_pco_appli[0]['step'] <= 7 && $seg_step <= $get_pco_appli[0]['step']) // APPLICABLE ONLY FOR STEPS 7 AND BELOW
        {
          $real_step = $seg_step;
        }
        else if($get_pco_appli[0]['step'] > 7) // APPLICABLE ONLY FOR STEPS ABOVE STEP 7
        {
          if($get_pco_appli[0]['step'] == 9) // RETURNED ( FOR UPDATING / EDITING )
          {
            if(in_array($seg_step, array(1,2,3,4,5,6,7)))
            {
              $real_step=$seg_step;
            }
          }
          else //  if()
          {
            $real_step=$seg_step;
          }
        }
        else // APPLICATION'S STEP AND SEGMENT'S STEP MISMATCH
        {
          $alert_data = array(
            'title'     => 'NOTE',
            'text'      => 'Cannot Proceed to Next Step. You are required to Finish this Step First. ',
            'type'      => 'warning',
          );
          $this->session->set_flashdata('bthead_alert_data', $alert_data);
          redirect( base_url('pco/application/'.$get_pco_appli[0]['appli_id'].'/'.$get_pco_appli[0]['step']) );
        }
        switch ($real_step) {
  		    case 1:
  		    case 9: $this->user_info(); break;
  		    case 2: $this->establishment_details(); break;
  		    case 3:
            $this->educatonal_attainment();
            $this->load->view('Pco/modals/estdtls_modal');
            break;
  		    case 4:
            $this->work_exp();
            $this->load->view('Pco/modals/workexp_modal');
            break;
  		    case 5:
            $this->trainsem_attended();
            $this->load->view('Pco/modals/tsatnd_modal');
            break;
  		    case 6:
          case 7: $this->other_req(); break;
          case '9': case '10': case '16': $this->user_info11(); break;
  		    default: $page = ''; break;
        }
      }
      else
      {
        redirect( base_url('show_404') );
      }
  	}

    private function add_new_application()
    {
      if(isset($_POST['create_trans_btn']))
      {
        $error = '';
        $limit = 10;
        // LIMITER FOR USERS CREATED/TRANSACTED PCO APPLICATIONS PER DAY
        $where['total_created_today'] = array(
          'user_id'       => $this->pco_data['user_id'],
          'date_created'  => date("Y-m-d")
        );
        $get_total_created_today = $this->olsys_model->selectdata('pco_application', 'COUNT(appli_id) total_created_today', $where['total_created_today']);
        if($get_total_created_today[0]['total_created_today'] >= $limit)
        {
          $error = 'maxed_created';
        }

        // LIMITER FOR USERS DRAFTS OF PCO APPLICATIONS
        $where['total_drafts'] = array(
          'user_id' => $this->pco_data['user_id'],
          'step <'  => 7
        );
        $get_drafts_total_no = $this->olsys_model->selectdata('pco_application', 'COUNT(appli_id) total_drafts', $where['total_drafts']);
        if($get_drafts_total_no[0]['total_drafts'] >= $limit)
        {
          $error = 'maxed_drafts';
        }

        if(empty($error))
        {
          $get_max_appli_id = $this->olsys_model->selectdata('pco_application', 'MAX(appli_id) max_appli_id', '');

          $data = array(
            'appli_id'      => !empty($get_max_appli_id[0]['max_appli_id']) ? $get_max_appli_id[0]['max_appli_id']+1 : 1,
            'user_id'       => $this->pco_data['user_id'],
            'step'          => 1,
            'stat_id'       => 1,
            'status'        => 'Draft',
            'date_created'  => date("Y-m-d H:i:s"),
          );
          $insert_pco_appli = $this->olsys_model->insertdata('pco_application', $data);

          if($insert_pco_appli)
          {
            $this->pco_data = array(
              'user_id'   => 1,
              'appli_id'  => $data['appli_id'],
              'step'      => $data['step'],
            );
            redirect( base_url('pco/application/'.$data['appli_id'].'/'.$data['step']) );
          }
          else // ERROR CIDIPADB: CANNOT INSERT DATA INTO PCO_APPLICATION DB
          {
            $alert_data = array(
              'title'     => '[E]RROR',
              'text'      => 'ERROR:[CIDIPADB] Unsuccessful Creation of PCO Application. Please contact System Administrator. Sorry for the Inconvenience.',
              'type'      => 'danger',
            );
            $this->session->set_flashdata('bthead_alert_data', $alert_data);
            redirect(base_url('pco/application'));
          }
        }
        else
        {
          if($error == 'maxed_drafts')
          {
            $alert_data = array(
              'title'     => 'WARNING',
              'text'      => 'You have reached the maximum number of UNPROCESSED DRAFTS in your account. <span style="font-weight: bold">Limited to only TEN(10) drafts per user.</span> Please reuse any of the existing drafts.',
              'type'      => 'danger',
            );
            $this->session->set_flashdata('bthead_alert_data', $alert_data);
            redirect(base_url('pco/application'));
          }
          // else if($error == 'maxed_created')
          else
          {
            $alert_data = array(
              'title'     => 'WARNING',
              'text'      => 'You have reached the maximum number of APPLICATIONS CREATED today. <span style="font-weight: bold">Limited to only TEN(10) applications per day, per user.</span> If you have any existing drafts, please reuse it.',
              'type'      => 'danger',
            );
            $this->session->set_flashdata('bthead_alert_data', $alert_data);
            redirect(base_url('pco/application'));
          }
        }

      }
      else // ERROR ANPBNDM/E: ADD NEW PCO BUTTON NAME DOES NOT MATCH / EXIST
      {
        $alert_data = array(
          'title'     => '[E]RROR',
          'text'      => 'ERROR:[ANPBNDM/E] Cannnot Add a New PCO Application. Please contact System Administrator. Sorry for the Inconvenience.',
          'type'      => 'success',
        );
        $this->session->set_flashdata('swal_alert_data', $alert_data);
        redirect(base_url('pco/application'));
      }
    }

  // ------------------------------------------   VIEW FUNCTIONS    ---------------------------------------------- //

    private function user_info()
    {
      $data = array(
        'appli_id'      => $this->pco_data['appli_id'],
        'step'          => $this->pco_data['step'],
        'sex_m_check'   => 'checked',
        'sex_f_check'   => '',
        'stat_f_check'  => '',
        'stat_o_check'  => 'checked',
      );

      // Application Info
      $where['application'] = array(
        'user_id'   => $this->pco_data['user_id'],
        'appli_id' => $data['appli_id'],
      );
      $data['application'] = $this->olsys_model->selectdata('pco_application', '', $where['application']);
      // User Information
      $where['user_info'] = array(
        'user_id'   => $this->pco_data['user_id'],
      );
      $data['user_info'] = $this->olsys_model->selectdata('user_info', '', $where['user_info']);

      if($data['user_info'][0]['sex'] == 1) {
        $data['sex_m_check'] ='';
        $data['sex_f_check'] ='checked';
      }
      if($data['user_info'][0]['employment_status'] == 1) {
        $data['stat_f_check'] ='checked';
        $data['stat_o_check'] ='';
      }

      $data['get_region'] = $this->olsys_model->selectdata('embis.acc_region', '', '');

      $this->validate_form('user_info', $data);
    }

    private function establishment_details()
    {
      $data = array(
        'appli_id'      => $this->pco_data['appli_id'],
        'step'          => $this->pco_data['step'],
        'category_a'    => '',
        'category_b'    => '',
      );

      // Application Info
      $where['application'] = array(
        'appli_id'    => $data['appli_id'],
        'account_id'  => $this->pco_data['account_id'],
        'user_id'     => $this->pco_data['user_id'],
      );
      $data['application'] = $this->olsys_model->selectdata('pco_application', '', $where['application']);
      // User Information
      $where['establishment_details'] = array(
        'establishment_id'   => $data['application'][0]['establishment_id'],
      );
      $data['establishment_details'] = $this->olsys_model->selectdata('establishment_details', '', $where['establishment_details']);

      $data['category_a'] = ($data['establishment_details'][0]['establishment_category'] == 1) ? 'selected' : '';
      $data['category_b'] = ($data['establishment_details'][0]['establishment_category'] == 2) ? 'selected' : '';

      $data['get_region'] = $this->olsys_model->selectdata('embis.acc_region', '', '');

      $this->validate_form('establishment_details', $data);
    }

    private function educatonal_attainment()
    {
      $data = array(
        'appli_id'          => $this->pco_data['appli_id'],
        'step'              => $this->pco_data['step'],
        'proflncse_n_check' => 'checked',
        'proflncse_y_check' => '',
        'educ_atn_chkempty' => 0, // check education_details if not empty
      );

      // Application Info
      $where['application'] = array(
        'appli_id'    => $data['appli_id'],
        'account_id'  => $this->pco_data['account_id'],
        'user_id'     => $this->pco_data['user_id'],
      );
      $data['application'] = $this->olsys_model->selectdata('pco_application', '', $where['application']);
      // User Information
      $where['educational_attainment'] = array(
        'user_id'   => $data['application'][0]['user_id'],
      );
      $data['educational_attainment'] = $this->olsys_model->selectdata('educational_attainment', '', $where['educational_attainment']);

      $where['education_details'] = array(
        'user_id'   => $data['application'][0]['user_id'],
      );
      $data['education_details'] = $this->olsys_model->selectdata('education_details', '', $where['education_details']);

      if($data['educational_attainment'][0]['received_prof_license'] == 1) {
        $data['proflncse_n_check'] ='';
        $data['proflncse_y_check'] ='checked';
      }

      $data['educ_atn_chkempty'] = !empty($data['education_details']) ? 1 : 0;

      $data['get_region'] = $this->olsys_model->selectdata('embis.acc_region', '', '');

      $this->validate_form('educatonal_attainment', $data);
    }

    private function work_exp()
    {
      $data = array(
        'appli_id'          => $this->pco_data['appli_id'],
        'step'              => $this->pco_data['step'],
        'work_exp_chkempty' => 0,
      );

      // Application Info
      $where['application'] = array(
        'appli_id'    => $data['appli_id'],
        'account_id'  => $this->pco_data['account_id'],
        'user_id'     => $this->pco_data['user_id'],
      );
      $data['application'] = $this->olsys_model->selectdata('pco_application', '', $where['application']);
      // User Information
      $where['work_exp'] = array(
        'user_id'   => $data['application'][0]['user_id'],
      );
      $data['work_exp'] = $this->olsys_model->selectdata('work_exp', '', $where['work_exp']);

      $data['get_region'] = $this->olsys_model->selectdata('embis.acc_region', '', '');

      $data['work_exp_chkempty'] = !empty($data['work_exp']) ? 1 : 0;

      $this->validate_form('work_exp', $data);
    }

    private function trainsem_attended()
    {
      $data = array(
        'appli_id'          => $this->pco_data['appli_id'],
        'step'              => $this->pco_data['step'],
        'quality_n_check'   => 'checked',
        'quality_y_check'   => '',
        'ts_attnd_chkempty' => 0,
      );

      $where['acc_info'] = array(
        'account_id'  => $this->pco_data['account_id'],
        'user_id'     => $this->pco_data['user_id'],
      );
      $data['acc_info'] = $this->olsys_model->selectdata('account_info', '', $where['acc_info']);

      // Application Info
      $where['application'] = array(
        'appli_id'    => $data['appli_id'],
        'account_id'  => $this->pco_data['account_id'],
        'user_id'     => $this->pco_data['user_id'],
      );
      $data['application'] = $this->olsys_model->selectdata('pco_application', '', $where['application']);
      // User Information
      $where['trainsem_attended'] = array(
        'user_id'   => $data['application'][0]['user_id'],
      );
      $data['trainsem_attended'] = $this->olsys_model->selectdata('trainsem_attended', '', $where['trainsem_attended']);

      $data['ts_attnd_chkempty'] = !empty($data['trainsem_attended']) ? 1 : 0;

      $data['get_region'] = $this->olsys_model->selectdata('embis.acc_region', '', '');

      if($data['acc_info'][0]['pco_training'] == 1) {
        $data['quality_n_check'] ='';
        $data['quality_y_check'] ='checked';
      }

      $this->validate_form('trainsem_attended', $data);
    }

    private function other_req()
    {
      $data = array(
        'appli_id'          => $this->pco_data['appli_id'],
        'step'              => $this->pco_data['step'],
        'adminc_n_check'    => 'checked',
        'adminc_y_check'    => '',
        'crimc_n_check'     => 'checked',
        'crimc_y_check'     => '',
      );

      // Application Info
      $where['application'] = array(
        'appli_id'    => $data['appli_id'],
        'account_id'  => $this->pco_data['account_id'],
        'user_id'     => $this->pco_data['user_id'],
      );
      $data['application'] = $this->olsys_model->selectdata('pco_application', '', $where['application']);
      // User Information
      $where['other_req'] = array(
        'user_id'   => $data['application'][0]['user_id'],
      );
      $data['other_req'] = $this->olsys_model->selectdata('other_req', '', $where['other_req']);

      $where['other_req_uploads'] = array(
        'user_id'   => $data['application'][0]['user_id'],
        'appli_id'  => $data['application'][0]['appli_id'],
      );
      $data['other_req_uploads'] = $this->olsys_model->selectdata('other_req_uploads', '', $where['other_req_uploads']);

      $data['get_region'] = $this->olsys_model->selectdata('embis.acc_region', '', '');

      if($data['other_req'][0]['administrative_case'] == 1) {
        $data['adminc_n_check'] ='';
        $data['adminc_y_check'] ='checked';
      }
      if($data['other_req'][0]['criminal_case'] == 1) {
        $data['crimc_n_check'] ='';
        $data['crimc_y_check'] ='checked';
      }

      $this->validate_form('other_req', $data);
    }

  // --------------------------------------    DB STORAGE FUNCTIONS    -------------------------------------- //

    private function validate_form($redirect, $data)
    {
      $data['step_header'] = $this->load->view('Pco/func/step_header', $this->pco_data, TRUE);

      $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');

      switch ($redirect) {
  	    case 'user_info':
          $this->form_validation->set_rules('last_name', 'Last Name', 'required');
          $this->form_validation->set_rules('first_name', 'First Name', 'required');
          $this->form_validation->set_rules('sex', 'Sex', 'required');

          $this->form_validation->set_rules('citizenship', 'Citizenship', 'required');
          $this->form_validation->set_rules('employment_status', 'Employment Status', 'required');
          $this->form_validation->set_rules('position', 'Current Position', 'required');
          $this->form_validation->set_rules('years_in_position', 'No. of Years in Current Position', 'required');

          $this->form_validation->set_rules('cel_no', 'Cellphone No', 'required');
          $this->form_validation->set_rules('email', 'Email', 'required');

          $this->form_validation->set_rules('region_id', 'Region', 'required');
          $this->form_validation->set_rules('prov_id', 'Province', 'required');
          $this->form_validation->set_rules('city_id', 'City', 'required');
          $this->form_validation->set_rules('brgy_id', 'Barangay', 'required');
          $this->form_validation->set_rules('zip_code', 'Zip Code', 'required');

          $this->form_validation->set_message('required', '"%s" field is empty <br />');

          if($this->form_validation->run() == FALSE) {
            $this->form_validation->error_array();
            $this->load->view('pco/user_info', $data);
          }
          else {
            $this->uinfo_form();
          }
          break;
  	    case 'establishment_details':
          $this->form_validation->set_rules('last_name', 'Last Name', 'required');
          $this->form_validation->set_rules('first_name', 'First Name', 'required');

          $this->form_validation->set_rules('establishment_name', 'establishment_name', 'required');
          $this->form_validation->set_rules('nature_of_business', 'nature_of_business', 'required');
          $this->form_validation->set_rules('establishment_category', 'establishment_category', 'required');

          $this->form_validation->set_rules('tel_no', 'tel_no', 'required');
          $this->form_validation->set_rules('fax_no', 'fax_no', 'required');

          $this->form_validation->set_rules('region_id', 'Region', 'required');
          $this->form_validation->set_rules('prov_id', 'Province', 'required');
          $this->form_validation->set_rules('city_id', 'City', 'required');
          $this->form_validation->set_rules('brgy_id', 'Barangay', 'required');
          $this->form_validation->set_rules('zip_code', 'zip_code', 'required');

          $this->form_validation->set_message('required', '"%s" field is empty <br />');

          if($this->form_validation->run() == FALSE) {
            $this->form_validation->error_array();
            $this->load->view('pco/establishment_details', $data);
          }
          else {
            $this->estdtls_form($data);
          }
          break;
  	    case 'educatonal_attainment':
          $this->form_validation->set_rules('received_prof_license', 'received_prof_license', 'required');

          if($this->input->post('received_prof_license') == 1)
          {
            $this->form_validation->set_rules('type_of_license', 'type_of_license', 'required');
            $this->form_validation->set_rules('prc_license_no', 'prc_license_no', 'required');
            $this->form_validation->set_rules('date_issued', 'date_issued', 'required');
            $this->form_validation->set_rules('validity', 'validity', 'required');
          }

          $this->form_validation->set_message('required', '"%s" field is empty <br />');

          if($this->form_validation->run() == FALSE) {
            $this->form_validation->error_array();
            $this->load->view('pco/educatonal_attainment', $data);
          }
          else {
            $this->educatnmnt_form($data);
          }
          break;
  	    case 'work_exp':
          $this->form_validation->set_rules('company11', 'company11', 'required');
          // $this->form_validation->set_rules('company', 'company', 'required');
          // $this->form_validation->set_rules('position', 'position', 'required');
          // $this->form_validation->set_rules('inclusive_date', 'inclusive_date', 'required');
          // $this->form_validation->set_rules('employment_status', 'employment_status', 'required');

          if($this->form_validation->run() == FALSE) {
            $this->form_validation->error_array();
            $this->load->view('pco/work_exp', $data);
          }
          else {
            $this->wrkxp_form();
          }
          break;
  	    case 'trainsem_attended':
          // $this->form_validation->set_rules('qualified', 'qualified', 'required');
          // $this->form_validation->set_rules('title', 'title', 'required');
          // $this->form_validation->set_rules('venue', 'venue', 'required');
          // $this->form_validation->set_rules('conductor', 'conductor', 'required');
          // $this->form_validation->set_rules('date_conducted', 'date_conducted', 'required');
          // $this->form_validation->set_rules('no_hours', 'no_hours', 'required');
          // $this->form_validation->set_rules('cert_no', 'cert_no', 'required');

          if($this->form_validation->run() == FALSE) {
            $this->form_validation->error_array();
            $this->load->view('pco/trainsem_attended', $data);
          }
          else {
            $this->trnsematnd_form($data);
          }
          break;
  	    case 'other_req':
          if($this->input->post('administrative_case') == 1 || $this->input->post('criminal_case') == 1)
          {
            $this->form_validation->set_rules('case_details', 'case_details', 'required');
          }
            // $this->form_validation->set_rules('title', 'title', 'required');
            // $this->form_validation->set_rules('venue', 'venue', 'required');
            // $this->form_validation->set_rules('conductor', 'conductor', 'required');
            // $this->form_validation->set_rules('date_conducted', 'date_conducted', 'required');
            // $this->form_validation->set_rules('no_hours', 'no_hours', 'required');
            // $this->form_validation->set_rules('cert_no', 'cert_no', 'required');

            if($this->form_validation->run() == FALSE) {
              $this->form_validation->error_array();
              $this->load->view('pco/other_req', $data);
            }
            else {
              $this->othrrq_form($data);
            }
          break;
  	    default: echo ''; break;
      }
    }

    private function uinfo_form()
    {
      $result = false;
      $post = $this->input->post();

      $prov_name = $this->olsys_model->selectdata('embis.dms_province edp', '', '', $this->db->where('edp.id = '.$post['prov_id']))[0]['name'];
      $city_name = $this->olsys_model->selectdata('embis.dms_city edc', '', '', $this->db->where('edc.id = '.$post['city_id']))[0]['name'];
      $brgy_name = $this->olsys_model->selectdata('embis.dms_barangay edb', '', '', $this->db->where('edb.id = '.$post['brgy_id']))[0]['name'];

      $user_info = array(
        'set'   => array(
          'first_name'         => $post['first_name'],
          'middle_name'        => $post['middle_name'],
          'last_name'          => $post['last_name'],
          'suffix'             => $post['suffix'],
          'sex'                => $post['sex'],
          'employment_status'  => $post['employment_status'],
          'citizenship'        => $post['citizenship'],
          'position'           => $post['position'],
          'years_in_position'  => $post['years_in_position'],
          'tel_no'             => $post['tel_no'],
          'cel_no'             => $post['cel_no'],
          'email'              => $post['email'],
          'region_id'          => $post['region_id'],
          'zip_code'           => $post['zip_code'],
          'prov_id'            => $post['prov_id'],
          'prov_name'          => $prov_name,
          'city_id'            => $post['city_id'],
          'city_name'          => $city_name,
          'brgy_id'            => $post['brgy_id'],
          'brgy_name'          => $brgy_name,
          'hsno_street'        => $post['hsno_street'],
        ),
        'where' => array(
          'user_id'            => $this->pco_data['user_id'],
        ),
      );
      $user_info['data'] = $this->olsys_model->updatedata( $user_info['set'], 'user_info', $user_info['where'] );

      if($user_info['data']) {

        if($this->pco_data['step'] == $this->pco_data['main_step'])
        {
          $pco_application = array(
            'set'   => array(
              'step'        => $this->pco_data['step']+1,
            ),
            'where' => array(
              'appli_id'    => $this->pco_data['appli_id'],
              'account_id'  => $this->pco_data['account_id'],
              'user_id'     => $this->pco_data['user_id'],
            ),
          );
          $pco_application['data'] = $this->olsys_model->updatedata($pco_application['set'], 'pco_application', $pco_application['where']);

          $result = ($pco_application['data']) ? true : false;
        }
        else {
          $result = true;
        }
      }

      if($result) {
        $redirect_step = ($this->pco_data['step'] == $this->pco_data['main_step']) ? $this->pco_data['step']+1 : $this->pco_data['step'];
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$redirect_step) );
      }
      else {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'Cannot Proceed to Next Step. Either there is(are) Empty Field(s), or a Bug in the system. ',
          'type'      => 'warning',
        );
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$this->pco_data['step']) );
      }
    }

    private function estdtls_form()
    {
      $result = false;
      $post = $this->input->post();

      $prov_name = $this->olsys_model->selectdata('embis.dms_province edp', '', '', $this->db->where('edp.id = '.$post['prov_id']))[0]['name'];
      $city_name = $this->olsys_model->selectdata('embis.dms_city edc', '', '', $this->db->where('edc.id = '.$post['city_id']))[0]['name'];
      $brgy_name = $this->olsys_model->selectdata('embis.dms_barangay edb', '', '', $this->db->where('edb.id = '.$post['brgy_id']))[0]['name'];

      $establishment_id = $this->olsys_model->selectdata('establishment_details', '', array('account_id' => 1, ))[0]['establishment_id'];
      if(!empty($establishment_id))
      {
        $user_info = array(
          'set'   => array(
            'first_name'              => $post['first_name'],
            'middle_name'             => $post['middle_name'],
            'last_name'               => $post['last_name'],
            'suffix'                  => $post['suffix'],

            'establishment_name'      => $post['establishment_name'],
            'nature_of_business'      => $post['nature_of_business'],
            'establishment_category'  => $post['establishment_category'],
            'tel_no'                  => $post['tel_no'],
            'fax_no'                  => $post['fax_no'],
            'website'                 => $post['website'],

            'region_id'               => $post['region_id'],
            'zip_code'                => $post['zip_code'],
            'prov_id'                 => $post['prov_id'],
            'prov_name'               => $prov_name,
            'city_id'                 => $post['city_id'],
            'city_name'               => $city_name,
            'brgy_id'                 => $post['brgy_id'],
            'brgy_name'               => $brgy_name,
            'hsno_street'             => $post['hsno_street'],
          ),
          'where' => array(
            'establishment_id'        => $establishment_id,
          ),
        );
        $user_info['data'] = $this->olsys_model->updatedata( $user_info['set'], 'establishment_details', $user_info['where'] );
      }
      else {
        $max_id = $this->olsys_model->selectdata('establishment_details', 'MAX(establishment_id) max_id', '')[0]['max_id'];
        $establishment_id = !empty($max_id) ? $max_id+1 : 1;
        $est_details['ins'] = array(
          'establishment_id'        => $establishment_id,
          'first_name'              => $post['first_name'],
          'middle_name'             => $post['middle_name'],
          'last_name'               => $post['last_name'],
          'suffix'                  => $post['suffix'],

          'establishment_name'      => $post['establishment_name'],
          'nature_of_business'      => $post['nature_of_business'],
          'establishment_category'  => $post['establishment_category'],
          'tel_no'                  => $post['tel_no'],
          'fax_no'                  => $post['fax_no'],
          'website'                 => $post['website'],

          'region_id'               => $post['region_id'],
          'zip_code'                => $post['zip_code'],
          'prov_id'                 => $post['prov_id'],
          'prov_name'               => $prov_name,
          'city_id'                 => $post['city_id'],
          'city_name'               => $city_name,
          'brgy_id'                 => $post['brgy_id'],
          'brgy_name'               => $brgy_name,
          'hsno_street'             => $post['hsno_street'],
        );
        $est_details['data'] = $this->olsys_model->insertdata('establishment_details', $est_details['ins'] );
      }

      if($est_details['data']) {

        if($this->pco_data['step'] == $this->pco_data['main_step'])
        {
          $pco_application = array(
            'set'   => array(
              'establishment_id'  => $establishment_id,
              'step'              => $this->pco_data['step']+1,
            ),
            'where' => array(
              'appli_id'          => $this->pco_data['appli_id'],
              'account_id'        => $this->pco_data['account_id'],
              'user_id'           => $this->pco_data['user_id'],
            ),
          );
          $pco_application['data'] = $this->olsys_model->updatedata($pco_application['set'], 'pco_application', $pco_application['where']);

          $result = ($pco_application['data']) ? true : false;
        }
        else {
          $result = true;
        }
      }

      if($result) {
        $redirect_step = ($this->pco_data['step'] == $this->pco_data['main_step']) ? $this->pco_data['step']+1 : $this->pco_data['step'];
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$redirect_step) );
      }
      else {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'Cannot Proceed to Next Step. Either there is(are) Empty Field(s), or a Bug in the system. ',
          'type'      => 'warning',
        );
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$this->pco_data['step']) );
      }
    }

    private function educatnmnt_form()
    {
      $result = false;
      $error_log = '';
      $post = $this->input->post();

      $eduatn_check = $this->olsys_model->selectdata('educational_attainment', '', array('user_id' => $this->pco_data['user_id']));
      // echo $this->db->last_query();
      // exit;
      if(!empty($eduatn_check))
      {
        $educ_atnmnt = array(
          'set'   => array(
            'received_prof_license'   => !empty($post['received_prof_license']) ? $post['received_prof_license'] : 0,
            'type_of_license'         => !empty($post['type_of_license']) ? $post['type_of_license'] : '',
            'prc_license_no'          => !empty($post['prc_license_no']) ? $post['prc_license_no'] : '',
            'date_issued'             => !empty($post['date_issued']) ? $post['date_issued'] : '',
            'validity'                => !empty($post['validity']) ? $post['validity'] : '',
          ),
          'where' => array(
            'user_id'                 => $this->pco_data['user_id'],
          ),
        );
        $educ_atnmnt['data'] = $this->olsys_model->updatedata( $educ_atnmnt['set'], 'educational_attainment', $educ_atnmnt['where'] );
      }
      else {
        $educ_atnmnt['ins'] = array(
          'user_id'                 => $this->pco_data['user_id'],
          'received_prof_license'   => !empty($post['received_prof_license']) ? $post['received_prof_license'] : 0,
          'type_of_license'         => !empty($post['type_of_license']) ? $post['type_of_license'] : '',
          'prc_license_no'          => !empty($post['prc_license_no']) ? $post['prc_license_no'] : '',
          'date_issued'             => !empty($post['date_issued']) ? $post['date_issued'] : '',
          'validity'                => !empty($post['validity']) ? $post['validity'] : '',
        );
        $educ_atnmnt['data'] = $this->olsys_model->insertdata( 'educational_attainment', $educ_atnmnt['ins'] );
      }

      if($educ_atnmnt['data'])
      {
        if($this->pco_data['step'] == $this->pco_data['main_step'])
        {
          $pco_application = array(
            'set'   => array(
              'step'        => $this->pco_data['step']+1,
            ),
            'where' => array(
              'appli_id'    => $this->pco_data['appli_id'],
              'account_id'  => $this->pco_data['account_id'],
              'user_id'     => $this->pco_data['user_id'],
            ),
          );
          $pco_application['data'] = $this->olsys_model->updatedata($pco_application['set'], 'pco_application', $pco_application['where']);

          $result = ($pco_application['data']) ? true : false;
        }
        else {
          $result = true;
        }
      }
      else {
        $error_log = 'EDAT-PRC';
      }

      if($result) {
        $redirect_step = ($this->pco_data['step'] == $this->pco_data['main_step']) ? $this->pco_data['step']+1 : $this->pco_data['step'];
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$redirect_step) );
      }
      else {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'Cannot Proceed to Next Step. Either there is(are) Empty Field(s), or a Bug in the system. ['.$error_log.']',
          'type'      => 'warning',
        );
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$this->pco_data['step']) );
      }
    }

    private function wrkxp_form()
    {
      $result = false;
      $error_log = '';
      $post = $this->input->post();

      if(false)
      {
        foreach ($post['company'] as $key => $value) {
          if(!empty($value) && !empty($post['position'][$key]))
          {
            $educ_atnmnt = array(
              'set'   => array(
                'user_id'           => $this->pco_data['user_id'],
                'company'           => $post['company'][$key],
                'position'          => $post['position'][$key],
                'inclusive_date'    => $post['inclusive_date'][$key],
                'employment_status' => $post['employment_status'][$key],
              ),
              'where' => array(
                'user_id'           => $this->pco_data['user_id'],
              ),
            );
            $educ_atnmnt['data'] = $this->olsys_model->updatedata( $educ_atnmnt['set'], 'work_exp', $educ_atnmnt['where'] );
          }
        }
      }
      else {
        foreach ($post['company'] as $key => $value) {
          if(!empty($value) && !empty($post['position'][$key]))
          {
            $workxp['ins'] = array(
              'user_id'           => $this->pco_data['user_id'],
              'company'           => $post['company'][$key],
              'position'          => $post['position'][$key],
              'inclusive_date'    => $post['inclusive_date'][$key],
              'employment_status' => $post['employment_status'][$key],
            );
            $workxp['data'] = $this->olsys_model->insertdata( 'work_exp', $workxp['ins'] );
          }
        }
      }

      if($workxp['data']) {

        if($this->pco_data['step'] == $this->pco_data['main_step'])
        {
          $pco_application = array(
            'set'   => array(
              'step'        => $this->pco_data['step']+1,
            ),
            'where' => array(
              'appli_id'    => $this->pco_data['appli_id'],
              'account_id'  => $this->pco_data['account_id'],
              'user_id'     => $this->pco_data['user_id'],
            ),
          );
          $pco_application['data'] = $this->olsys_model->updatedata($pco_application['set'], 'pco_application', $pco_application['where']);

          $result = ($pco_application['data']) ? true : false;
        }
        else {
          $result = true;
        }
      }
      else {
        $error_log = 'WXP-INS';
      }

      if($result) {
        $redirect_step = ($this->pco_data['step'] == $this->pco_data['main_step']) ? $this->pco_data['step']+1 : $this->pco_data['step'];
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$redirect_step) );
      }
      else {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'Cannot Proceed to Next Step. Either there is(are) Empty Field(s), or a Bug in the system. ['.$error_log.']',
          'type'      => 'warning',
        );
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$this->pco_data['step']) );
      }
    }

    private function trnsematnd_form()
    {
      $result = false;
      $error_log = '';
      $post = $this->input->post();

      if(false)
      {
        foreach ($post['company'] as $key => $value) {
          if(!empty($value) && !empty($post['position'][$key]))
          {
            $ts_attend = array(
              'set'   => array(
                'title'           => $post['title'][$key],
                'venue'           => $post['venue'][$key],
                'conductor'       => $post['conductor'][$key],
                'date_conducted'  => $post['date_conducted'][$key],
                'no_hours'        => $post['no_hours'][$key],
                'cert_no'         => $post['cert_no'][$key],
              ),
              'where' => array(
                'user_id'         => $this->pco_data['user_id'],
              ),
            );
            $ts_attend['data'] = $this->olsys_model->updatedata( $ts_attend['set'], 'work_exp', $ts_attend['where'] );
          }
        }
      }
      else {
        foreach ($post['title'] as $key => $value) {
          if(!empty($value) && !empty($post['venue'][$key]))
          {
            $ts_attend['ins'] = array(
              'user_id'         => $this->pco_data['user_id'],
              'title'           => $post['title'][$key],
              'venue'           => $post['venue'][$key],
              'conductor'       => $post['conductor'][$key],
              'date_conducted'  => $post['date_conducted'][$key],
              'no_hours'        => $post['no_hours'][$key],
              'cert_no'         => $post['cert_no'][$key],
            );
            $ts_attend['data'] = $this->olsys_model->insertdata( 'trainsem_attended', $ts_attend['ins'] );
          }
        }
      }


      $acc_info = array(
        'set'   => array(
          'pco_training'  => $post['title'][$key],
        ),
        'where' => array(
          'account_id'    => $this->pco_data['account_id'],
          'user_id'       => $this->pco_data['user_id'],
        ),
      );
      $acc_info['data'] = $this->olsys_model->updatedata( $acc_info['set'], 'account_info', $acc_info['where'] );


      if($ts_attend['data']) {

        if($this->pco_data['step'] == $this->pco_data['main_step'])
        {
          $pco_application = array(
            'set'   => array(
              'step'        => $this->pco_data['step']+1,
            ),
            'where' => array(
              'appli_id'    => $this->pco_data['appli_id'],
              'account_id'  => $this->pco_data['account_id'],
              'user_id'     => $this->pco_data['user_id'],
            ),
          );
          $pco_application['data'] = $this->olsys_model->updatedata($pco_application['set'], 'pco_application', $pco_application['where']);

          $result = ($pco_application['data']) ? true : false;
        }
        else {
          $result = true;
        }
      }
      else {
        $error_log = 'WXP-INS';
      }

      if($result) {
        $redirect_step = ($this->pco_data['step'] == $this->pco_data['main_step']) ? $this->pco_data['step']+1 : $this->pco_data['step'];
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$redirect_step) );
      }
      else {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'Cannot Proceed to Next Step. Either there is(are) Empty Field(s), or a Bug in the system. ['.$error_log.']',
          'type'      => 'warning',
        );
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
        redirect( base_url('pco/application/'.$this->pco_data['appli_id'].'/'.$this->pco_data['step']) );
      }
    }

    private function othrrq_form()
    {
    }

  }
?>
