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
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('includes/common/dms_styles');

      $this->load->view('Dms/include/custom_head');
      $this->load->view('Dms/include/custom_foot');

      if($this->uri->segment(1) != 'dms' && $this->uri->segment(2) != 'documents') {
         redirect(base_url('error_404'));
      }

      if($this->uri->segment(2) === 'documents' && !empty($this->uri->segment(3))) {
         // $this->dmsdata['er_options'] = $this->Embismodel->selectdata('er_options', '*', array('userid'=>$this->dmsdata['user']['id']))[0];
         $this->router();
      }
      else {
         $this->all_transactions();
      }
   }

   private function router() // MAINLY FOR URI SEGMENT CHECKING ONLY
   {
      switch ($this->uri->segment(3)) {
         case 'debug':
         if($this->uri->segment(4)=='Asd123')
         {
            $this->output->enable_profiler(TRUE);
            $this->array_debug($_SESSION);
         }
         break;

         case 'all':
         $this->load->view('Dms/func/modals');
         $this->all_transactions();
         break;

         case 'inbox':
         $this->inbox();
         $this->load->view('Dms/func/modals');
         // if($this->dmsdata['user']['token'] == '6255e67296c742c7') {
         $this->load->view('Dms/include/multiselect_modal');
         // }
         break;

         case 'inbox-test':
            $this->load->view('Dms/func/modals');
            $this->load->view('Dms/include/multiselect_modal');
            $data = array(
               'user_region'  => $this->dmsdata['user_region'],
               'user_token'   => $this->dmsdata['user_token'],
            );
            $data['user'] = $this->dmsdata['user'];
            $data['region'] = $this->Embismodel->selectdata('acc_region', '*');
            $div_uloctype = $this->dmsdata['user']['region']=='CO' ? 'co' : 'region';
            $data['division'] = $this->Embismodel->selectdata( 'acc_xdvsion', '*', array('type' => $div_uloctype, 'office' => 'EMB') );
            $data['action'] = $this->Embismodel->selectdata('er_action', '*');
            $this->load->view('Dms/inbox_test', $data);
         break;

         case 'outbox':
         // $this->load->view('Dms/include/header_alert');
         $this->load->view('Dms/func/modals');
         $this->outbox();
         break;

         case 'outbox-test':
         $this->load->view('Dms/include/header_alert');
         $this->load->view('Dms/func/modals');

         $data = array(
            'user_region'  => $this->dmsdata['user_region'],
            'user_token'   => $this->dmsdata['user_token'],
         );
         $this->load->view('Dms/outbox_test', $data);
         break;

         case 'drafts':
         $this->load->view('Dms/func/modals');
         $this->drafts();
         break;

         case 'planning':
         $this->load->view('Dms/func/modals');
         $this->planning_report();
         break;

         case 'devtools':
         if(!empty($this->uri->segment(4)) && $this->uri->segment(4) == 'filetransfer') {
            $this->trans_transfer();
         }
         break;

         case 'revisions':
         $this->load->view('Dms/func/modals');
         $this->revisions();
         break;

         case 'records':
         $this->load->view('Dms/func/modals');
         $this->records();
         break;

         case 'migrate':
         $this->load->view('Dms/func/modals');
         $this->migrate();
         break;

         case 'filed-closed':
         $this->load->view('Dms/func/modals');
         $this->load->view('Dms/modals/reopen');
         $this->dmsdata['filed_closed_tips'] = $this->Embismodel->selectdata('er_tips', '*', array( 'userid' => $this->dmsdata['user']['id'] ) );
         $this->load->view('Dms/modals/filed_closed_tips', $this->dmsdata);
         $this->closed();
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

   private function validate_session()
   {
      $where_ucred = array(
         'userid'   => $this->dmsdata['user']['id'],
         'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->dmsdata['user']['region'] || $session_ucred['secno'] != $this->dmsdata['user']['secno'] || $session_ucred['divno'] != $this->dmsdata['user']['divno']) {
         $this->dmsdata = array(
            'user_id'     => $session_ucred['userid'],
            'user_region' => $session_ucred['region'],
            'user_token'  => $session_ucred['token'],
         );
         $this->dmsdata['user'] = array(
            'id'      => $session_ucred['userid'],
            'token'   => $session_ucred['token'],
            'region'  => $session_ucred['region'],
            'secno'   => $session_ucred['secno'],
            'divno'   => $session_ucred['divno'],
         );
      }
   }

   // ----------------------------------------------------------------- VIEWS -------------------------------------------------------------------- //

   // ------------------------------- DOCUMENTS (MAIN) ----------------------------------
   private function all_transactions()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $this->load->view('Dms/all_transactions', $data);
   }

   private function inbox()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $data['user'] = $this->dmsdata['user'];
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*');
      $div_uloctype = $this->dmsdata['user']['region']=='CO' ? 'co' : 'region';
      $data['division'] = $this->Embismodel->selectdata( 'acc_xdvsion', '*', array('type' => $div_uloctype, 'office' => 'EMB') );
      $data['action'] = $this->Embismodel->selectdata('er_action', '*');
      $this->load->view('Dms/inbox1', $data);
   }

   private function outbox()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $this->load->view('Dms/outbox', $data);
   }

   private function drafts()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $this->load->view('Dms/drafts', $data);
   }

   private function revisions()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $this->load->view('Dms/revisions_new', $data);
   }

   // -------------------- PLANNING -----------------------
   private function planning_report()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $this->load->view('Dms/Planning/'.$this->uri->segment(4), $data);
      // if (is_file(APPPATH.'Dms/Planning/'.$this->uri->segment(4).EXT))
      // if ($this->load->view('Dms/Planning/'.$this->uri->segment(4), '', TRUE) !== '')
      // {
      //   $this->load->view('Dms/Planning/'.$this->uri->segment(4), $data);
      // }
      // else {
      //     $this->load->view('404');
      // }
   }

   // -------------------- MODIFICATION TOOLS -----------------------
   private function trans_transfer()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $this->load->view('Dms/mod/file_transfer', $data);
   }

   private function records()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $this->load->view('Dms/records', $data);
   }

   private function closed()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $this->load->view('Dms/closed_new', $data);
   }

   private function migrate()
   {
      $data = array(
         'user_region'  => $this->dmsdata['user_region'],
         'user_token'   => $this->dmsdata['user_token'],
      );
      $data['region'] = $this->Embismodel->selectdata('acc_region', '*', '');
      $this->load->view('Dms/migrate', $data);
   }

}
?>
