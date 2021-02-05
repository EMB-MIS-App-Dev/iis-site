<?php

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->model('Travelordermodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');

  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('travelorder/dashboard');
    $this->load->view('travelorder/modals');

    // echo $this->db->last_query();
  }

  function Forapproval(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('travelorder/forapproval');
    $this->load->view('travelorder/modals');
  }

  function Forapprovalred(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('travelorder/forapprovalred');
    $this->load->view('travelorder/modals');
  }

  function Allapproved(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('travelorder/allapproved');
    $this->load->view('travelorder/modals');
  }

  function calendar(){
    $data    = array();
    $region  = $this->session->userdata('region');
    $start   = $this->input->post('start');
    $end     = $this->input->post('end');
    $query   = $this->db->query("SELECT to_trans.token, to_trans.userid, to_trans.name, toid, DATE_ADD(arrival_date, INTERVAL 1 DAY) AS enddate, departure_date, DATE_SUB(arrival_date, INTERVAL 1 DAY) AS tomorrow, arrival_date AS today
      FROM embis.to_trans LEFT JOIN embis.er_transactions AS et ON et.trans_no = to_trans.er_no WHERE et.status != 0 AND to_trans.region='$region' AND (to_trans.status='Approved' OR to_trans.status='Signed Document') AND (to_trans.departure_date BETWEEN '$start' AND '$end') GROUP BY et.trans_no")->result_array();

      foreach($query as $row)
      {
       $data[] = array(
        'id'      => $row["toid"],
        'token'   => $row["token"],
        'title'   => str_replace("&ntilde;","ñ",$row["name"]),
        'start'   => $row["departure_date"],
        'end'     => $row["enddate"],
        'color'   => "#3788D8",
        'depdate' => date ('M j, Y', strtotime ($row['departure_date'])),
        'tomorrow'=> date ('M j, Y', strtotime ($row['today'])),
       );
      }

    echo json_encode($data);

  }

}
