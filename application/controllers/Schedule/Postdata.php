<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Postdata extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');
		date_default_timezone_set("Asia/Manila");
	}

  function create(){
    if(!empty($_POST['subject']) AND !empty($_POST['date_schedule']) AND sizeof($_POST['participants']) > 0){
      $participants = $this->session->userdata('userid').'|';
      $counter = 0;
      for ($i=0; $i < sizeof($_POST['participants']); $i++) {
        if(!empty($_POST['participants'][$i])){
          $counter++;
          $con = ($counter == sizeof($_POST['participants'])) ? '': '|';
          $participants .= $this->encrypt->decode($_POST['participants'][$i]).$con;
        }
      }
			$displayoptions = $this->encrypt->decode($this->input->post('displayoptions', TRUE));
			$display = ($displayoptions == 'Yes') ? 'national' : $this->session->userdata('region');
      $sched_data = array(
                          'subject'       => $_POST['subject'],
                          'location'      => $_POST['location'],
                          'date_schedule' => $_POST['date_schedule'],
													'time_schedule' => $_POST['time_schedule'],
                          'creator'       => $this->session->userdata('userid'),
                          'participants'  => $participants,
                          'status'        => 'Active',
                          'region'        => $display,
                         );
      $this->Embismodel->insertdata('schedule_list',$sched_data);
      $swal_arr = array(
         'title'     => 'SUCCESS!',
         'text'      => 'Schedule successfully created.',
         'type'      => 'success',
       );
       $this->session->set_flashdata('swal_arr', $swal_arr);
       redirect(base_url()."Schedule/Dashboard");
    }else{
      $swal_arr = array(
         'title'     => 'Error!',
         'text'      => 'Error occured!',
         'type'      => 'error',
       );
       $this->session->set_flashdata('swal_arr', $swal_arr);
       redirect(base_url()."Schedule/Dashboard");
    }
  }
}

?>
