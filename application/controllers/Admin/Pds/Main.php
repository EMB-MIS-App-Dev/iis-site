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
      $this->load->view('superadmin/pds/navigation');

      $this->load->view('superadmin/pds/dashboard');
    }

    function personal_info()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('superadmin/pds/navigation');

      $this->load->view('superadmin/pds/personal_info');
    }

    function family_background()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('superadmin/pds/navigation');

      $this->load->view('superadmin/pds/family_background');
    }

    function educational_background()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('superadmin/pds/navigation');

      $data['educ_levels'] = $this->db->get('pds_education_levels')->result_array();

      $this->load->view('superadmin/pds/educational_background', $data);
    }

    function works_learnings_other_info()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('superadmin/pds/navigation');

      $this->load->view('superadmin/pds/works_learnings_other_info');
    }

    function affinities()
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('superadmin/pds/navigation');

      $this->load->view('superadmin/pds/affinities');
    }

    function form()
    {
      $this->load->library('Pdf');
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/footer');

      $data['personal_info'] = $this->db->where('userid = '.$this->thisdata['user']['id'])->from('pds_personal_info')->get()->row(0);
      $data['residential'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND address_type = "RESIDENTIAL"')->from('pds_address')->get()->row(0);
      $data['permanent'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND address_type = "PERMANENT"')->from('pds_address')->get()->row(0);
      $data['family'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_family_background')->get()->row(0);
      $data['children'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_children')->get()->result_array();
      $data['elementary'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND level = "ELEMENTARY"')->from('pds_educational_background')->get()->result_array();
      $data['secondary'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND level = "SECONDARY"')->from('pds_educational_background')->get()->result_array();
      $data['vocational'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND level = "VOCATIONAL / TRADE COURSE"')->from('pds_educational_background')->get()->result_array();
      $data['college'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND level = "COLLEGE"')->from('pds_educational_background')->get()->result_array();
      $data['graduate_studies'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'" AND level = "GRADUATE STUDIES"')->from('pds_educational_background')->get()->result_array();
      $data['eligibility'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_civil_service')->get()->result_array();
      $data['work_experience'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_work_experience')->get()->result_array();
      $data['voluntary_work'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_voluntary_work')->get()->result_array();
      $data['learning_development'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_learning_development')->get()->result_array();
      $data['other_info'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_other_info')->get()->result_array();
      $data['references'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_person_references')->get()->result_array();
      $data['affinities'] = $this->db->where('userid = "'.$this->thisdata['user']['id'].'"')->from('pds_affinities')->get()->result_array()[0];
      $this->load->view('superadmin/pds/form', $data);
    }

    function formToPdf() {

    }

    private function router() // MAINLY FOR URI SEGMENT CHECKING ONLY
    {
      switch ($this->uri->segment(3)) {
        case 'process': // SEPARATE TO ANOTHER DMS CONTROLLER FILE
            if(!empty($this->uri->segment(4)) && !empty($this->uri->segment(5)) && !empty($this->uri->segment(6)) && !empty($this->uri->segment(7))) {
              $this->route_transaction();
              // PUT AFTER FUNCTION TO RECEIVE DATA
              $this->load->view('Dms/include/modals');
              // $this->load->view('Dms/func/route_modals');
              $this->load->view('Dms/include/multiselect_personnel_modals');
            }
            else {
              $this->_alert('', '', '[PRC-ROUTE]');
            }
          break;

        default:
            $this->_alert('', '', '[SEG-THR]');
          break;
      }
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

    // ------------------------------------------- FORM VALIDATIONS ------------------------------------------ //
    private function validate_form($site="", $data="")
    {
      $data['fvalid_error'] = 0;
      if(empty($site)) {
        $alert_data = array(
          'title'     => 'ERROR',
          'text'      => 'Route Site Destination Not Set, Causes might be a Network Interruption. Please check the site, or Contact System Administrator. [VF-EMPST]',
          'type'      => 'error',
        );
        $this->_alert($alert_data);
      }

      if(isset($_POST['process_transaction']))
      {
        $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');

        $this->form_validation->set_rules('system', 'System', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('company', 'Company', 'required');
        // END STATUS
        if(!in_array($this->input->post('status'), array('17', '18', '19', '24', '27')))
        {
          // MULTIPLE
          if (!empty(($this->input->post('asgnto_multiple')))) {
            // $this->form_validation->set_rules('asgnto_multiple_input', 'Assign To- Multiple Personnel', 'required');
          }
          else {
            $this->form_validation->set_rules('division', 'Assign To- Division', 'required');
            $this->form_validation->set_rules('section', 'Assign To- Section', 'required');
            $this->form_validation->set_rules('receiver', 'Assign To- Receiver', 'required');
          }
        }
        $this->form_validation->set_rules('action', 'Action', 'required');
        // FIRST TRANSACTION ROUTE

        $this->dmsdata['atchx_rt'] = $data['trans_data'][0]['route_order'];
        if($data['trans_data'][0]['route_order'] == 0) {
          $this->form_validation->set_rules('attachment', 'Attachment', 'callback_attachment_exists');
        }

                // if($this->dmsdata['user']['token'] == '515e12d4a186a84')
                // {
                //   // echo $route;
                //   print_r($data['trans_data']); exit;
                // }

        // TRANSACTION STATUS "FOR FILING / CLOSED"
        if($this->input->post('status') == 24)
        {
          // RECORDS SECTION
          if( in_array($data['user']['secno'], array(77,166,176,195,223,231,232,235,255,279,316 )) )
          {
            $this->form_validation->set_rules('records_location', 'Rec. Only- File Location', 'required');
          }
          $this->form_validation->set_rules('attachment', 'Attachment', 'callback_attachment_exists');
        }
        // SENT VIA COURIER
        if($this->input->post('status') == '19') {
          $this->form_validation->set_rules('courier_type', '', 'required_courier');
        }

        $this->form_validation->set_message('required', '"%s" field is empty <br />');
        $this->form_validation->set_message('attachment_exists', '"%s" field is empty <br />');
        $this->form_validation->set_message('required_courier', '( For "Sent Via Courier", Courier Type is Required )' );

        if($this->form_validation->run() == FALSE)
        {
          $this->form_validation->error_array();
          $data['fvalid_error'] = 1;
          $this->load->view($site, $data);
        }
        else {
          $this->process_transaction();
        }
      }
      else {
        $this->load->view($site, $data);
      }
    }

    function submit1()
    {
      $post = $this->input->post();

      $personal_info_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "surname" => $post["surname"],
        "first_name" => $post["first_name"],
        "middle_name" => $post["middle_name"],
        "name_extension" => $post["name_extension"],
        "date_of_birth" => $post["date_of_birth"],
        "place_of_birth" => $post["place_of_birth"],
        "sex" => $post["sex"],
        "civil_status" => $post["civil_status"],
        "height" => $post["height"],
        "weight" => $post["weight"],
        "blood_type" => $post["blood_type"],
        "gsis_id" => $post["gsis_id"],
        "pag_ibig_id" => $post["pag_ibig_id"],
        "philhealth_no" => $post["philhealth_no"],
        "sss_no" => $post["sss_no"],
        "tin_no" => $post["tin_no"],
        "agency_employee_no" => $post["agency_employee_no"],
        "citizenship" => $post["citizenship"],
        "has_dual_citizenship" => $post["has_dual_citizenship"],
        "indicate_country" => $post["indicate_country"],
        "telephone_no" => $post["telephone_no"],
        "cellphone_no" => $post["cellphone_no"],
        "email_address" => $post["email_address"],
      );

      $r_address_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "address_type" => "RESIDENTIAL",
        "house_block_lot_no" => $post["r_house_block_lot_no"],
        "street" => $post["r_street"],
        "subdivision_village" => $post["r_subdivision_village"],
        "barangay_id" => $post["r_barangay_id"],
        "barangay" => $post["r_barangay"],
        "city_id" => $post["r_city_id"],
        "city_municipality" => $post["r_city_municipality"],
        "province_id" => $post["r_province_id"],
        "province" => $post["r_province"],
        "zip_code" => $post["r_zip_code"],
      );

      $p_address_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "address_type" => "PERMANENT",
        "house_block_lot_no" => $post["p_house_block_lot_no"],
        "street" => $post["p_street"],
        "subdivision_village" => $post["p_subdivision_village"],
        "barangay_id" => $post["p_barangay_id"],
        "barangay" => $post["p_barangay"],
        "city_id" => $post["p_city_id"],
        "city_municipality" => $post["p_city_municipality"],
        "province_id" => $post["p_province_id"],
        "province" => $post["p_province"],
        "zip_code" => $post["p_zip_code"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_personal_info', $personal_info_insert);
      $this->db->insert('pds_address', $r_address_insert);
      $this->db->insert('pds_address', $p_address_insert);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
          echo 'failed';
      }
      else {
        echo 'success';
        redirect(base_url('Admin/Pds/Main/family_background'));
      }
    }

    function submit2()
    {
      $post = $this->input->post();

      $family_background_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "spouse_surname" => $post["spouse_surname"],
        "spouse_first_name" => $post["spouse_first_name"],
        "spouse_middle_name" => $post["spouse_middle_name"],
        "spouse_name_extension" => $post["spouse_name_extension"],
        "spouse_occupation" => $post["spouse_occupation"],
        "employer_business_name" => $post["employer_business_name"],
        "business_address" => $post["business_address"],
        "telephone_no" => $post["telephone_no"],
        "father_surname" => $post["father_surname"],
        "father_first_name" => $post["father_first_name"],
        "father_middle_name" => $post["father_middle_name"],
        "father_name_extension" => $post["father_name_extension"],
        "mother_surname" => $post["mother_surname"],
        "mother_first_name" => $post["mother_first_name"],
        "mother_middle_name" => $post["mother_middle_name"],
      );

      $children_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "name" => $post["name"],
        "birth_date" => $post["birth_date"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_family_background', $family_background_insert);
      $this->db->insert('pds_children', $children_insert);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
          echo 'failed';
      } else {
        echo 'success';
        redirect(base_url('Admin/Pds/Main/educational_background'));
      }
    }

    function submit3()
    {
      $post = $this->input->post();

      $affinities_insert = array(
        "userid" => $this->thisdata['user']['id'],
        "with_third_degree_affinity" => $post["with_third_degree_affinity"],
        "with_fourth_degree_affinity" => $post["with_fourth_degree_affinity"],
        "affinities" => $post["affinities"],
        "with_administrative_offense" => $post["with_administrative_offense"],
        "administrative_offense" => $post["administrative_offense"],
        "is_criminally_charged" => $post["is_criminally_charged"],
        "date_filed" => $post["date_filed"],
        "status_of_case" => $post["status_of_case"],
        "is_convicted" => $post["is_convicted"],
        "conviction_details" => $post["conviction_details"],
        "was_separated_from_service" => $post["was_separated_from_service"],
        "separated_from_service" => $post["separated_from_service"],
        "is_candidate" => $post["is_candidate"],
        "candidate_details" => $post["candidate_details"],
        "has_resigned_from_government" => $post["has_resigned_from_government"],
        "resigned_government" => $post["resigned_government"],
        "is_immigrant" => $post["is_immigrant"],
        "immigrant_country" => $post["immigrant_country"],
        "is_indigenous" => $post["is_indigenous"],
        "indigenous_details" => $post["indigenous_details"],
        "is_disabled" => $post["is_disabled"],
        "disability_id" => $post["disability_id"],
        "is_solo_parent" => $post["is_solo_parent"],
        "solo_parent_id" => $post["solo_parent_id"],
        "government_id" => $post["government_id"],
        "secondary_id" => $post["secondary_id"],
        "date_place_of_issuance" => $post["date_place_of_issuance"],
      );

      $this->db->trans_start();
      $this->db->insert('pds_affinities', $affinities_insert);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
          echo 'failed';
      } else {
        echo 'success';
        redirect(base_url('Admin/Pds/Main'));
      }
    }
  }
?>
