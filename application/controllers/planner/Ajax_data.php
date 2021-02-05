<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);
/*
* segment 1 - dms
* segment 2 - documents
* segment 3 - actions (add, route, revise)
*/
class Ajax_data extends CI_Controller
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

   private function validate_session()
   {
      $where_ucred = array(
         'userid'   => $this->thisdata['user']['id'],
         'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->thisdata['user']['region'] || $session_ucred['secno'] != $this->thisdata['user']['secno'] || $session_ucred['divno'] != $this->thisdata['user']['divno']) {
         $this->thisdata['user'] = array(
            'id'      => $session_ucred['userid'],
            'token'   => $session_ucred['token'],
            'region'  => $session_ucred['region'],
            'secno'   => $session_ucred['secno'],
            'divno'   => $session_ucred['divno'],
         );
      }
   }

   private function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

   private function user_fullname($user_id="")
   {
      $result = $this->db->where('userid ='.$user_id)->from('acc_credentials')->get()->row(0);

      return !empty($result) ? $this->_is_empty($result->title, '', ' ')
      .$result->fname.' '
      .$this->_is_empty($result->mname[0], '', '. ')
      .$result->sname.' '
      .$this->_is_empty($result->suffix, '') : '-unregistered-';
   }

   function psched_list()
   {
      $post = $this->input->post();
      $region = $this->thisdata['user']['region'];
      $start = $post['start'];
      $end = $post['end'];
      $data = array();
      $today = date('Y-m-d');
      $color = '';

      $sched_list = $this->db->where('(start_date BETWEEN "'.$start.'" AND "'.$end.'")')->from('psched_list')->get()->result_array();

      foreach ($sched_list as $key => $sched) {
         $start = $sched['start_date'];
         $end = $sched['end_date'];

         $hosts_id = $this->db->select('user_id')->where('sched_id = "'.$sched["id"].'" AND user_func = "Host"')->from('psched_userlist')->get()->result_array();
         $host_list = '';
         foreach ($hosts_id as $host) {
            $host_list .= '<input class="form-control" value="'.$this->user_fullname($host['user_id']).'" readonly />';
         }

         $participants_id = $this->db->select('user_id')->where('sched_id = "'.$sched["id"].'" AND user_func = "Participant"')->from('psched_userlist')->get()->result_array();
         $participant_list = '';
         foreach ($participants_id as $participant) {
            $participant_list .= '<input class="form-control" value="'.$this->user_fullname($participant['user_id']).'" readonly />';
         }

         if(($today >= $start) && ($today <= $end)) {
            $color = '#1CC88A'; //In-progress
         }
         else if($today > $end) {
            $color = '#264159'; //Completed
         }
         else {
            $color = '#3788D8'; // Upcoming
         }

         $data[] = array(
            'id'           => $sched["id"],
            'title'        => str_replace("&ntilde;", "ñ", $sched["activities"]),
            'start'        => $start,
            'end'          => date('Y-m-d', strtotime($end.'+ 1 days')),
            'color'        => $color,
            'start_date'   => date('M j, Y', strtotime($start)),
            'end_date'     => date('M j, Y', strtotime($end)),
            'location'     => $sched["location"],
            'hosts'        => $host_list,
            'participants' => $participant_list,
            'status'       => $sched["status"],
            'remarks'      => $sched["remarks"],
         );
      }
      // print_r($data);
      echo json_encode($data);
   }

   function get_region()
   {
      $region_list = $this->db->where('rgnid != "17"')->from('acc_region')->get()->result_array();
      // $region_option = '<option value="all">All Regions</option>';
      $region_option = '';
      foreach ($region_list as $key => $region) {
         if($region['rgnnum'] == $this->thisdata['user']['region']) {
            $region_option .= '<option value="'.$region['rgnnum'].'" selected>'.$region['rgnnam'].'</option>';
         }
         else {
            $region_option .= '<option value="'.$region['rgnnum'].'">'.$region['rgnnam'].'</option>';
         }
      }
      echo $region_option;
   }

   function get_division()
   {
      $this->validate_session();
      $data = array(
         // 'division'  => $this->input->post('selected'),
         'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->thisdata['user']['region'],
      );

      // if($data['region'] == 'all') {
      //    $division_option = '<option value="all" selected>-all-</option>';
      // }
      // else {
         $type = ($data['region'] == 'CO') ? 'co' : 'region';
         $type2 = trim(strtolower($data['region']));

         $func = $this->db->where('stat = 1 AND userid ="'.$this->thisdata['user']['id'].'"')->from('acc_function')->get()->result_array();
         $get_division = $this->db->where('type IN("'.$type.'","'.$type2.'") AND divno != 15 AND office = "EMB" ')->from('acc_xdvsion')->get()->result_array();
         // echo $this->db->last_query(); exit;
         $division_option = '<option value="" selected>--</option>';
         foreach ($get_division as $key => $division) {
            $division_option .= '<option value="'.$division['divno'].';'.$division['divname'].'">'.$division['divname'].'</option>';
         }
      // }
      echo $division_option;
   }

   function get_section()
   {
      $post_division = explode(';', $this->input->post('division'));
      $data = array(
         // 'section'   => $this->input->post('selected'),
         'division'  => $post_division[0],
         'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->thisdata['user']['region'],
      );
      $sec_slctd = '';
      $this->validate_session();

      if($data['division'] === '') {
         $section_option = '<option value="" selected>--</option>';
      }
      // else if($data['region'] === 'all' || $data['division'] === 'all') {
      //    $section_option = '<option value="all" selected>-all-</option>';
      // }
      else {
         $exclude_sect = $this->db->where(array('region' => $data['region']))->from('acc_xsect_not_applicable')->get()->result_array();
         $xsct = '0';
         if(!empty($exclude_sect))
         {
            foreach($exclude_sect as $key => $value) {
               if(count($exclude_sect)-1 == $key) {
                  $xsct .= $value['secno'];
               }
               else {
                  $xsct .= $value['secno'].',';
               }
            }
         }
         if($region != 'CO') {
            $this->db->where('secno != 345 AND divno = "'.$data['division'].'" AND ( region = "'.$data['region'].'" OR region = "R" ) AND secno NOT IN ('.$xsct.')');
         }
         else {
            $this->db->where('secno != 345 AND divno = "'.$data['division'].'" AND region = "'.$data['region'].'"');
         }
         $section_list = $this->db->from('acc_xsect')->get()->result_array();

         $section_option = '<option value="" selected>--</option>';

         $division_details = $this->db->where('divno ='.$data['division'])->from('acc_xdvsion')->get()->row(0);

         $section_option .= '<option value="-1" '.$sec_slctd.'>'.$division_details->divcode.' - Head</option>';

         foreach ($section_list as $key => $section) {
            if(!empty($data['section']) && $data['section'] == $section['secno']) {
               $section_option .= '<option value="'.$section['secno'].';'.$section['sect'].'" selected>'.$section['sect'].'</option>';
            }
            else {
               $section_option .= '<option value="'.$section['secno'].';'.$section['sect'].'">'.$section['sect'].'</option>';
            }
         }
      }
      echo $section_option;
   }

   function get_personnel()
   {
      $post_section = explode(';', $this->input->post('section'));
      $post_division = explode(';', $this->input->post('division'));
      $data = array(
         // 'personnel' => $this->input->post('selected'),
         'section'   => (!empty($post_section[0]) && $post_section[0] != -1) ? $post_section[0] : 0,
         'division'  => $post_division[0],
         'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->thisdata['user']['region'],
      );
      $this->validate_session();

      $this->db->where(array('stat' => 1, 'secno' => $data['section'], 'divno' => $data['division'], 'region' => $data['region']));
      $this->db->group_by("userid");
      $func_list = $this->db->from('acc_function')->get()->result_array();

      if($post_section == '') {
         $personnel_option = '<option value="" selected>--</option>';
      }
      // else if($data['region'] === 'all' || $data['division'] === 'all' || $data['section'] === 'all') {
      //    $personnel_option = '<option value="all" selected>-all-</option>';
      // }
      else {
         $personnel_option = '<option value="" selected>--</option>';
         foreach ($func_list as $key => $func) {
            $this->db->where(array('userid' => $func['userid'], 'verified' => 1));
            $this->db->group_by("userid");
            $personnel = $this->db->from('acc_credentials')->get()->result_array();

            if(!empty($personnel)) {
               if(in_array($personnel[0]['token'], array('5715e58cf2dac134')) ) {
                  $personnel_option .= '<option value="'.$personnel[0]['token'].'" disabled class="asgn-on-leave">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'<span> [ON-LEAVE]</span> </option>';
               }
               else if(in_array($personnel[0]['token'], array('4635e4286ea323ec')) ) {
                  $personnel_option .= '<option value="'.$personnel[0]['token'].'" disabled class="asgn-on-leave">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'<span > [PAUSED-ROUTING]</span> </option>';
               }
               else if( !empty($data['personnel']) && trim($data['personnel']) == $personnel[0]['token'] ) {
                  $personnel_option .= '<option value="'.$personnel[0]['token'].'" selected>'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'</option>';
               }
               else {
                  $personnel_option .= '<option value="'.$personnel[0]['token'].'">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'</option>';
               }
            }
         }
      }
      echo $personnel_option;
   }

   function add_new_schedule()
   {
      $insert = array(
         "created_by"      => $this->thisdata['user']['id'],
         "created_date"    => date('Y-m-d H:i:s'),
         "creator_region"  => $this->thisdata['user']['region'],
      );

      $this->db->trans_start();
      $this->db->insert('psched_list', $insert);
      $this->db->trans_complete();

      if($this->db->trans_status() === FALSE) {
         echo 'failed';
      }
      else {
         $psched_list = $this->db->where('created_by = "'.$this->thisdata['user']['id'].'"')->order_by('id', 'DESC')->from('psched_list')->get()->row(0);
         echo $psched_list->id;
      }
   }

} // CLASS END
?>
