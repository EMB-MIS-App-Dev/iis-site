<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Main extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel','emb');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      $this->ajaxdata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );

//       ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    }

    function index(){
      $where = array('region' => $this->session->userdata('region'), );
      $this->my_data['vhlist'] = $this->emb->selectdata('vh_list', '*', '');
      $this->db->join('vh_list as vh','vh.vhid = vha.vehicle');
      $this->my_data['getvhsched'] = $this->emb->selectdata('vh_assigned as vha', 'vha.*,vh.color', '');

      $where = array('accr.to_assistant_or_laborers' => 'yes','accr.region' => $this->session->userdata('region'), );
      $this->db->join('acc_credentials as acc',' acc.userid = accr.userid');
      $this->my_data['drlist'] = $this->emb->selectdata('acc_rights as accr', 'accr.to_assistant_or_laborers,acc.userid,acc.fname,acc.sname', $where);

      $this->_show_view('vehicle/calendar');
    }
    public function _show_view($content)
    {
      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      if ( ! empty($content))
        $this->load->view($content, @$this->my_data);
    }

    function get_driver_data($data=''){
      if (!empty($data['driver']))
        $query = $this->db
                  ->select('sname,fname')
                  ->from('acc_credentials')
                  ->where('userid',$data['driver'])
                  ->get()->row();
        return $query;
    }

    function get_vehicle_data($data=''){
      // echo "<pre>";print_r($data);exit;
      if (!empty($data['vehicle']))
        $query = $this->db
                  ->select('type,color')
                  ->from('vh_list')
                  ->where('vhid',$data['vehicle'])
                  ->get()->row();
        return $query;
    }
    function insert_vh_assign($data = ''){
      $maxid = 0;
        $row = $this->db->query('SELECT MAX(cnt) AS `maxid` FROM `vh_assigned`')->row();
        if ($row) {
            $maxid = $row->maxid+1;
        }

      $vehicle_data = $this->get_vehicle_data($data);
      $driver_data = $this->get_driver_data($data);
      // echo "<pre>";print_r($driver_data);exit;
      $as_ticket_no = "VH-".date('Y').'-'.$maxid;
      $this->db->set('as_ticket_no',$as_ticket_no);
      $this->db->set('date_assign',date('Y-m-d'));
      $this->db->set('assigner',$this->session->userdata('userid'));
      $this->db->set('vehicle',$data['vehicle']);
      $this->db->set('vehicle_name',$vehicle_data->type);
      $this->db->set('vh_color',$vehicle_data->color);
      $this->db->set('driver',$data['driver']);
      $this->db->set('driver_name',$driver_data->sname.' '.$driver_data->fname);
      $this->db->set('departure_date_vh_to',$data['departure_date_vh_to']);
      $this->db->set('arrival_date_vh_to',$data['arrival_date_vh_to']);
      $this->db->insert('vh_assigned');
      $lastid = $this->db->insert_id();
      return $lastid;
    }

    function submit_assign_vh(){
      $data = $this->input->post();
      // echo "<pre>";print_r($data);exit;
      $vh_id = $this->insert_vh_assign($data);
      if (!empty($vh_id))
        if(!empty($data['passenger']))
          foreach ($data['passenger'] as $key => $pass_val) {
            $this->db->set('vh_ass_id',$vh_id);
            $this->db->set('staff',$pass_val);
            $query = $this->db->insert('vh_assigned_passenger');
          }

          if (!empty($data['destination']))
            foreach ($data['destination'] as $key => $dest_val) {
              $this->db->set('vh_id',$vh_id);
              $this->db->set('destinations',$dest_val);
              $query = $this->db->insert('vh_destinations');
            }
          // ($query)?$msg='success':$msg='error';
          // echo $msg;
          $this->session->set_flashdata('success_vh_ticket','success');
          redirect("vehicle/tickets");

    }


    function calendar(){
      $data    = array();
      $region  = $this->session->userdata('region');
      $start   = $this->input->post('start');
      $end     = $this->input->post('end');


      $query   = $this->db->query("SELECT vha.driver_name,vha.date_assign,vha.vehicle,vha.vehicle_name,vhli.color,
        vha.departure_date_vh_to AS startdate,
        DATE_ADD(vha.arrival_date_vh_to, INTERVAL 1 DAY) AS enddate,
        vhp.staff,vhp.vh_ass_id,acc.fname,acc.sname
      FROM embis.vh_assigned as vha
      JOIN vh_assigned_passenger as vhp ON vhp.vh_ass_id = vha.cnt
      JOIN acc_credentials as acc ON acc.userid = vhp.staff
      JOIN vh_list as vhli ON vhli.vhid = vha.vehicle
      WHERE vha.departure_date_vh_to BETWEEN '$start' AND '$end'
      GROUP BY vhp.vh_ass_id
      ")->result_array();
        foreach($query as $row)
        {
         $data[] = array(
          'id'      => $row["vh_ass_id"],
          'title'   => str_replace("&ntilde;","ñ",$row["color"]." (".$row["vehicle_name"].")"),
          'start'   => $row["startdate"],
          'end'     => $row["enddate"],
          'color'   => "#3788D8",
          'depdate' => date ('M j, Y', strtotime ($row['departure_date_vh_to'])),
          'tomorrow'=> date ('M j, Y', strtotime ($row['today'])),
         );
        }
      echo json_encode($data);
    }

    function get_vh_travel_data(){
      if (!empty($this->input->post('vh_travel_id',TRUE)))

        $query['vh_data']   = $this->db->query("SELECT vha.as_ticket_no,vha.driver_name,vha.date_assign,vha.vehicle,vha.vehicle_name,vhli.color,vha.departure_date_vh_to,vha.arrival_date_vh_to
        FROM embis.vh_assigned as vha
        JOIN vh_list as vhli ON vhli.vhid = vha.vehicle
        WHERE vha.cnt = ".$this->input->post('vh_travel_id',TRUE)."
        ")->result_array();

        $query['vh_passenger']   = $this->db->query("SELECT vhp.staff,vhp.vh_ass_id,acc.fname,acc.sname
        FROM embis.vh_assigned_passenger as vhp
        JOIN acc_credentials as acc ON acc.userid = vhp.staff
        WHERE vhp.vh_ass_id = ".$this->input->post('vh_travel_id',TRUE)."
        ")->result_array();

        $query['vh_destinations']  = $this->db->query("SELECT vhd.* FROM embis.vh_destinations as vhd WHERE vhd.vh_id = ".$this->input->post('vh_travel_id',TRUE)."")->result_array();

        echo json_encode($query);
    }

    function get_driver_btw_date(){

        $q1 = $this->db->select("driver,vehicle")
                       ->from("embis.vh_assigned as vh")
                       ->where("vh.departure_date_vh_to >=", $this->input->post('dep_date',TRUE))
                       ->where("vh.arrival_date_vh_to <=", $this->input->post('arr_date',TRUE))
                       ->where("vh.region ",$this->session->userdata('region'))
                       ->get();
                       echo $this->db->last_query();exit;
          foreach (($q1->result_array()) as $dr) {
           $drarray[] = $dr['driver'];
          }
           $driver=implode(',',$drarray);

           // echo $driver;
         foreach (($q1->result_array()) as $vh) {
          $vharray[] = $vh['vehicle'];
         }
          $vehicle=implode(',',$vharray);
          echo   $vehicle;  exit;
          $query['avl_drivers'] = $this->db->query("SELECT acr.to_assistant_or_laborers,acc.fname,acc.sname,acc.userid FROM embis.acc_rights as acr LEFT JOIN acc_credentials as acc ON acc.userid = acr.userid WHERE acr.to_assistant_or_laborers = 'yes' AND acc.region = '{$this->session->userdata('region')}' AND acc.userid NOT IN ({$driver})")->result_array();

          $query['avl_vehicle'] = $this->db->query("SELECT * FROM embis.vh_list as vhl WHERE vhl.region = '{$this->session->userdata('region')}' AND vhl.vhid NOT IN ($vehicle)")->result_array();


          // $query['unavl_drivers'] = $this->db->query("SELECT acr.to_assistant_or_laborers,acc.fname,acc.sname,acc.userid FROM embis.acc_rights as acr LEFT JOIN acc_credentials as acc ON acc.userid = acr.userid WHERE acr.to_assistant_or_laborers = 'yes' AND acc.region = '{$this->session->userdata('region')}' AND acc.userid IN ({$driver})")->result_array();
          //
          // $query['unavl_vehicle'] = $this->db->query("SELECT * FROM embis.vh_list as vhl WHERE vhl.region = '{$this->session->userdata('region')}' AND vhl.vhid IN ($vehicle)")->result_array();

        echo json_encode($query);
    }
  }
