<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sweet extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->model('Sweetreportmodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');
    $this->load->library('form_validation');
  }

  function index(){
    $where  = $this->db->where('sf.userid = "'.$this->session->userdata('userid').'" AND et.status != "0" GROUP BY sf.lgu_patrolled_name ORDER BY date_created DESC');
    $join   = $this->db->join('er_transactions AS et','et.token = sf.trans_no','left');
    $select['lgu_patrolled'] = $this->Embismodel->selectdata('sweet_form AS sf','lgu_patrolled_name','',$join,$where);
    // echo $this->db->last_query();
    $wheretr  = $this->db->where('sfl.userid = "'.$this->session->userdata('userid').'" AND et.status != "0" GROUP BY lgu_patrolled_name');
    $join   = $this->db->join('er_transactions AS et','et.token = sfl.trans_no','left');
    $select['total_reports'] = $this->Embismodel->selectdata('sweet_form_log AS sfl','lgu_patrolled_name, COUNT(lgu_patrolled_name) AS total_reports','',$join,$wheretr);

    $wheretrm  = $this->db->where('sfl.userid = "'.$this->session->userdata('userid').'" AND type_of_monitoring = "1" AND et.status != "0" GROUP BY lgu_patrolled_name');
    $join   = $this->db->join('er_transactions AS et','et.token = sfl.trans_no','left');
    $select['total_reports_rm'] = $this->Embismodel->selectdata('sweet_form_log AS sfl','lgu_patrolled_name, COUNT(lgu_patrolled_name) AS total_reports','',$join,$wheretrm);

    $wheretva  = $this->db->where('sfl.userid = "'.$this->session->userdata('userid').'" AND type_of_monitoring = "2" AND et.status != "0" GROUP BY lgu_patrolled_name');
    $join   = $this->db->join('er_transactions AS et','et.token = sfl.trans_no','left');
    $select['total_reports_va'] = $this->Embismodel->selectdata('sweet_form_log AS sfl','lgu_patrolled_name, COUNT(lgu_patrolled_name) AS total_reports','',$join,$wheretva);

    $wheretvan  = $this->db->where('sfl.userid = "'.$this->session->userdata('userid').'" AND type_of_monitoring = "3" AND et.status != "0" GROUP BY lgu_patrolled_name');
    $join   = $this->db->join('er_transactions AS et','et.token = sfl.trans_no','left');
    $select['total_reports_van'] = $this->Embismodel->selectdata('sweet_form_log AS sfl','lgu_patrolled_name, COUNT(lgu_patrolled_name) AS total_reports','',$join,$wheretvan);

    //RETURNED DOCS
    $where  = $this->db->where('sf.assigned_to = "'.$this->session->userdata('userid').'" AND et.status != "0" ORDER BY date_created DESC');
    $join   = $this->db->join('er_transactions AS et','et.token = sf.trans_no','left');
    $selectfor_action = $this->Embismodel->selectdata('sweet_form AS sf','sf.trans_no','',$join,$where);
    $select['check_for_action'] = $selectfor_action[0]['trans_no'];

    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');
    $this->load->view('swm/sweetreport',$select);
    $this->load->view('swm/modals',$select);
  }

  function sweet_new_trans(){
    date_default_timezone_set("Asia/Manila");
    $region          = $this->session->userdata('region');
    $sender_id       = $this->session->userdata('token');
    // echo $this->session->userdata('token'); exit;

    $region_where = array('ar.rgnnum' => $region );
    $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

    $wheretransaction= $this->db->where('et.region', $region);
    $new_transaction = $this->Embismodel->selectdata('er_transactions AS et', 'MAX(et.trans_no) AS max_trans_no', '', $wheretransaction);

    // echo $this->db->last_query(); exit;

    $current_yr = date("Y");
    $trans_rgn = $region_data[0]['rgnid'] * 1000000;
    // add statements for same region selection for transaction number identifiers

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

    $trans_token = $region.'-'.$current_yr.'-'.sprintf('%06d', ($trans_no - ((int)($trans_no / 1000000)*1000000)));


    $date_in = date('Y-m-d H:i:s');

    $acwhere = array('ac.token' => $sender_id );
    $credq = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acwhere );

    $mname = ' ';
    if(!empty($credq[0]['mname']) )
      $mname = ' '.$credq[0]['mname'][0].'. ';

    $suffix = '';
    if(!empty($credq[0]['suffix']) )
      $suffix = ' '.$credq[0]['suffix'];

    $sender_name = ucwords($credq[0]['fname'].$mname.$credq[0]['sname']).$suffix;
    $trans_log_insert = array(
      'trans_no'        => $trans_no,
      'route_order'     => 0,
      'sender_divno'    => $credq[0]['divno'],
      'sender_secno'    => $credq[0]['secno'],
      'sender_id'       => $sender_id,
      'sender_name'     => $sender_name,
      'sender_ipadress' => '',
      'sender_region'   => $region,
      'date_in'         => $date_in,
    );
    $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

    $start_date = date('Y-m-d');

    $trans_insert = array(
      'trans_no'    => $trans_no,
      'token'       => $trans_token,
      'route_order' => 0,
      'region'      => $region,
      'sender_id'   => $sender_id,
      'sender_name'     => $sender_name,
      'start_date'  => $start_date,
    );
    $this->Embismodel->insertdata('er_transactions', $trans_insert);

    $this->session->unset_userdata('lgu_patrolled_session');
    $this->session->unset_userdata('sw_barangay_session');
    $this->session->unset_userdata('travel_no_session');
    $this->session->unset_userdata('type_of_monitoring_session');
    $this->session->unset_userdata('swsite_photo');
    $this->session->unset_userdata('accessibility_session');

    $this->session->set_userdata('trans_no', $trans_no);
    $this->session->set_userdata('trans_no_token', $trans_token);

    redirect(base_url().'Swm/Sweet/form');
  }

  function form(){

    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');

    $region_name        = $this->session->userdata('region');

    $orderbyswtoa       = $this->db->order_by('stoa.toaorder','ASC');
    $query['swtoa']     = $this->Embismodel->selectdata('sweet_type_of_area AS stoa','*','',$orderbyswtoa);

    $orderbyswvo        = $this->db->order_by('svo.voorder','ASC');
    $query['swvo']      = $this->Embismodel->selectdata('sweet_violations_observed AS svo','*','',$orderbyswvo);

    $orderbyswtom       = $this->db->order_by('stom.tomorder','ASC');
    $query['swtom']     = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stom','*','',$orderbyswtom);

    $orderbyatbu        = $this->db->order_by('satbu.atbuorder','ASC');
    $query['swatbu']    = $this->Embismodel->selectdata('sweet_actions_to_be_undertaken AS satbu','*','',$orderbyatbu);

    $query['chkgeocam'] = $this->db->query('SELECT * FROM `mobile_db`.`survey_details` AS `sd` WHERE `sd`.`user_id` = "'.$this->session->userdata('userid').'"')->num_rows();

    if(!empty($this->session->userdata('sw_barangay_session'))){

      $emb_id = $this->encrypt->decode($this->session->userdata('lgu_patrolled_session'));
      $where  = $this->db->where('dy.emb_id',$emb_id);
      $qry  = $this->Embismodel->selectdata('embis.dms_company AS dy','dy.city_id,dy.company_name','',$where);

      $query['company_name'] = $qry[0]['company_name'];

      $city_id = !empty($qry[0]['city_id']) ? $qry[0]['city_id'] : '';

      $orderbrgy = $this->db->order_by('dy.name','ASC');
      $wherebrgy = $this->db->where('dy.city_id',$city_id);
      $wherebrgy = $this->db->where('dy.id !=',$this->session->userdata('sw_barangay_session'));
      $query['qrybrgy']      = $this->Embismodel->selectdata('embis.dms_barangay AS dy','dy.id,dy.name','',$wherebrgy,$orderbrgy);

      $whereselectedbrgy     = $this->db->where('dy.id',$this->encrypt->decode($this->session->userdata('sw_barangay_session')));
      $qryselectedbrgy       = $this->Embismodel->selectdata('embis.dms_barangay AS dy','dy.id,dy.name','',$whereselectedbrgy);
      $query['selectedbrgy'] = $qryselectedbrgy[0]['name'];

    }

    !empty($emb_id) ? $where_lgu = $this->db->where('sla.emb_id !=',$emb_id) : '';
    $where_lgu          = $this->db->where('sla.region',$region_name);
    $where_lgu          = $this->db->where('sla.userid',$this->session->userdata('userid'));
    $query['query_lgu'] = $this->Embismodel->selectdata('sweet_lgu_assigned AS sla','sla.emb_id,sla.lgu_name','',$where_lgu);

    if(!empty($this->session->userdata('travel_no_session'))){
      $travel_no = $this->encrypt->decode($this->session->userdata('travel_no_session'));
      $orderbytravel      = $this->db->order_by('tt.departure_date','ASC');
      $wheretravel        = $this->db->where('tt.userid',$this->session->userdata('userid'));
      $wheretravel        = $this->db->where('et.status !=','0');
      $jointravel         = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
      $query['travels']   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$wheretravel,$orderbytravel);

      $whr   = $this->db->where('tt.toid',$travel_no);
      $qry   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$whr);
      $query['travel_no_selected'] = $qry[0]['toid']." - ".str_replace('Array','',$qry[0]['destination']);
        // echo $this->db->last_query();
    }else{
      $orderbytravel      = $this->db->order_by('tt.departure_date','ASC');
      $wheretravel        = $this->db->where('tt.userid',$this->session->userdata('userid'));
      $wheretravel        = $this->db->where('et.status !=','0');
      $jointravel         = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
      $query['travels']   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$orderbytravel);
    }

    $whereregion_num = $this->db->where('ar.rgnnum',$this->session->userdata('region'));
    $queryregion_num = $this->Embismodel->selectdata('acc_region AS ar','ar.*','',$whereregion_num);
    $query['region_num'] = $queryregion_num[0]['rgnnumeral'];
    $query['rgnname']    = $queryregion_num[0]['rgnname'];

    $sweet_token = $this->Sweetreportmodel->sweet_func_user($this->session->userdata('userid'));

    $queryrouteto       = $this->db->query("SELECT MAX(sf.route_order) AS mro, acs.fname, acs.mname, acs.sname, acs.suffix FROM sweet_func sf LEFT JOIN acc_credentials acs ON acs.userid=sf.assigned_to
    WHERE sf.token='$sweet_token' AND sf.region='$region_name' AND sf.route_order = (SELECT MAX(sfc.route_order) FROM sweet_func AS sfc WHERE sfc.token='$sweet_token')")->result_array();

    $mname  = !empty($queryrouteto[0]['mname']) ? $queryrouteto[0]['mname'][0].". " : "";
    $suffix = !empty($queryrouteto[0]['suffix']) ? " ".$queryrouteto[0]['suffix'] : "";
    $concat = $queryrouteto[0]['fname']." ".$mname.$queryrouteto[0]['sname'].$suffix;
    $query['name'] = $concat;

    $this->load->view('swm/form',$query);

  }

  function update(){
    $this->session->unset_userdata('lgu_patrolled_session');
    $this->session->unset_userdata('sw_barangay_session');
    $this->session->unset_userdata('travel_no_session');
    $this->session->unset_userdata('type_of_monitoring_session');

    $this->session->unset_userdata('report_status');
    $this->session->unset_userdata('rn');
    $this->session->unset_userdata('sw_token');
    $this->session->unset_userdata('sw_fdsw');
    $this->session->unset_userdata('sw_location');
    $this->session->unset_userdata('sw_latitude');
    $this->session->unset_userdata('sw_longitude');
    $this->session->unset_userdata('updtswupdtsite_photo');

    $this->session->set_userdata('report_status', $_POST['report_status']);
    $this->session->set_userdata('rn', $_POST['rn']);
    $this->session->set_userdata('sw_token', $_POST['token']);
    $this->session->set_userdata('sw_fdsw', $_POST['sw_fdsw']);
    $this->session->set_userdata('sw_location', $_POST['sw_location']);
    $this->session->set_userdata('sw_latitude', $_POST['sw_latitude']);
    $this->session->set_userdata('sw_longitude', $_POST['sw_longitude']);

    redirect(base_url().'Swm/Sweet/updateform');
  }

  function updateform(){

      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->view('swm/modals');

      $trans_no           = $this->encrypt->decode($this->session->userdata('sw_token'));

      $region_name        = $this->session->userdata('region');
      $userid             = $this->session->userdata('userid');

      $orderbyswtoa       = $this->db->order_by('stoa.toaorder','ASC');
      $query['swtoa']     = $this->Embismodel->selectdata('sweet_type_of_area AS stoa','*','',$orderbyswtoa);

      $orderbyswvo        = $this->db->order_by('svo.voorder','ASC');
      $query['swvo']      = $this->Embismodel->selectdata('sweet_violations_observed AS svo','*','',$orderbyswvo);

      $orderbyswtom       = $this->db->order_by('stom.tomorder','ASC');
      $query['swtom']     = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stom','*','',$orderbyswtom);

      $orderbyatbu        = $this->db->order_by('satbu.atbuorder','ASC');
      $query['swatbu']    = $this->Embismodel->selectdata('sweet_actions_to_be_undertaken AS satbu','*','',$orderbyatbu);

      $whereregion_num = $this->db->where('ar.rgnnum',$this->session->userdata('region'));
      $queryregion_num = $this->Embismodel->selectdata('acc_region AS ar','ar.*','',$whereregion_num);
      $query['region_num'] = $queryregion_num[0]['rgnnumeral'];
      $query['rgnname']    = $queryregion_num[0]['rgnname'];

      if(!empty($this->session->userdata('travel_no_session'))){
      $travel_no = $this->encrypt->decode($this->session->userdata('travel_no_session'));
      $orderbytravel      = $this->db->order_by('tt.departure_date','ASC');
      $wheretravel        = $this->db->where('tt.userid',$this->session->userdata('userid'));
      $wheretravel        = $this->db->where('et.status !=','0');
      $jointravel         = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
      $query['travels']   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$wheretravel,$orderbytravel);

      $whr   = $this->db->where('tt.toid',$travel_no);
      $qry   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$whr);
      $query['travel_no_selected'] = $qry[0]['toid']." - ".str_replace('Array','',$qry[0]['destination']);
        // echo $this->db->last_query();
      }else{
        $orderbytravel      = $this->db->order_by('tt.departure_date','ASC');
        $wheretravel        = $this->db->where('tt.userid',$this->session->userdata('userid'));
        $wheretravel        = $this->db->where('et.status !=','0');
        $jointravel         = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
        $query['travels']   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$orderbytravel);
      }

      $wheresweetform     = $this->db->where('sf.trans_no',$trans_no);
      $joinsweetform      = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no=sf.trans_no','left');
      $query['sweet_form']= $this->Embismodel->selectdata('sweet_form AS sf','sf.*,sfa.attachment_name','',$joinsweetform,$wheresweetform);

      $query['tom'] = $this->Embismodel->selectdata('embis.sweet_type_of_monitoring AS stom','','');

      $sweet_token = $this->Sweetreportmodel->sweet_func_user($userid);

      $queryrouteto       = $this->db->query("SELECT MAX(sf.route_order) AS mro, acs.fname, acs.mname, acs.sname, acs.suffix FROM sweet_func sf LEFT JOIN acc_credentials acs ON acs.userid=sf.assigned_to WHERE sf.token='$sweet_token' AND sf.region='$region_name' AND sf.route_order = (SELECT MAX(sfa.route_order) FROM sweet_func sfa WHERE sfa.token='$sweet_token' AND sfa.region='$region_name')")->result_array();

      $mname  = !empty($queryrouteto[0]['mname']) ? $queryrouteto[0]['mname'][0].". " : "";
      $suffix = !empty($queryrouteto[0]['suffix']) ? " ".$queryrouteto[0]['suffix'] : "";
      $concat = $queryrouteto[0]['fname']." ".$mname.$queryrouteto[0]['sname'].$suffix;
      $strtnm = str_replace('Ã±', '&ntilde;', $concat);
      $query['name'] = ucwords(str_replace('ã±', '&ntilde;', $strtnm));

      $this->load->view('swm/updateform',$query);
  }

  function edit(){
    $this->session->unset_userdata('lgu_patrolled_session');
    $this->session->unset_userdata('edit_barangay_session');
    $this->session->unset_userdata('edit_trans_no_session');
    $this->session->unset_userdata('type_of_monitoring_session');
    $this->session->unset_userdata('travel_no_session');
    $this->session->unset_userdata('edit_report_status_session');
    $this->session->unset_userdata('edit_report_number_session');

    $this->session->unset_userdata('edit_sw_fdsw_session');
    $this->session->unset_userdata('edit_sw_location_session');
    $this->session->unset_userdata('edit_sw_latitude_session');
    $this->session->unset_userdata('edit_sw_longitude_session');

    $this->editform();
  }

  function editform(){

      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');

      $trans_no            = !empty($this->session->userdata('edit_trans_no_session')) ? $this->encrypt->decode($this->session->userdata('edit_trans_no_session')) : $this->encrypt->decode($this->input->get('token'));

      $region_name         = $this->session->userdata('region');
      $userid              = $this->session->userdata('userid');

      $orderbyswtoa        = $this->db->order_by('stoa.toaorder','ASC');
      $query['swtoa']      = $this->Embismodel->selectdata('sweet_type_of_area AS stoa','*','',$orderbyswtoa);

      $orderbyswvo         = $this->db->order_by('svo.voorder','ASC');
      $query['swvo']       = $this->Embismodel->selectdata('sweet_violations_observed AS svo','*','',$orderbyswvo);

      $orderbyswtom        = $this->db->order_by('stom.tomorder','ASC');
      $query['swtom']      = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stom','*','',$orderbyswtom);

      $orderbyatbu         = $this->db->order_by('satbu.atbuorder','ASC');
      $query['swatbu']     = $this->Embismodel->selectdata('sweet_actions_to_be_undertaken AS satbu','*','',$orderbyatbu);

      $whereregion_num     = $this->db->where('ar.rgnnum',$this->session->userdata('region'));
      $queryregion_num     = $this->Embismodel->selectdata('acc_region AS ar','ar.*','',$whereregion_num);
      $query['region_num'] = $queryregion_num[0]['rgnnumeral'];
      $query['rgnname']    = $queryregion_num[0]['rgnname'];

      $wheresweetform      = $this->db->where('sf.trans_no',$trans_no);
      $joinsweetform       = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no=sf.trans_no','left');
      $query['sweet_form'] = $this->Embismodel->selectdata('sweet_form AS sf','sf.*,sfa.attachment_name','',$joinsweetform,$wheresweetform);
      ///////////////////////////////////////////////////////////////////////////


      if(!empty($this->session->userdata('travel_no_session'))){
      $travel_no = $this->encrypt->decode($this->session->userdata('travel_no_session'));

      $whr   = $this->db->where('tt.toid = "'.$travel_no.'"');
      $qry   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$whr);
      $query['travel_no_selected'] = $qry[0]['toid'];
      // echo $travel_no; exit;
      }

      $orderbytravel      = $this->db->order_by('tt.departure_date','ASC');
      $wheretravel        = $this->db->where('tt.userid = "'.$query['sweet_form'][0]['userid'].'"');
      $wheretravel        = $this->db->where('et.status !=','0');
      $jointravel         = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
      $query['travels']   = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$orderbytravel);
      ///////////////////////////////////////////////////////////////////////////

      $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($query['sweet_form'][0]['userid']);
      if($userid == $query['sweet_form'][0]['userid']){
        $queryrouteto       = $this->db->query("SELECT MAX(sf.route_order) AS mro, acs.fname, acs.mname, acs.sname, acs.suffix FROM sweet_func sf LEFT JOIN acc_credentials acs ON acs.userid=sf.assigned_to WHERE sf.token='".$sweet_func_token."' AND sf.region='".$region_name."'")->result_array();
      }else{
        if($query['sweet_form'][0]['route_order'] <= '1'){
          $route_order = '1';
        }else{
          $route_order = $query['sweet_form'][0]['route_order']-1;
        }
        $queryrouteto       = $this->db->query("SELECT MAX(sf.route_order) AS mro, acs.fname, acs.mname, acs.sname, acs.suffix FROM sweet_func sf LEFT JOIN acc_credentials acs ON acs.userid=sf.assigned_to WHERE sf.token='".$sweet_func_token."' AND sf.region='".$region_name."' AND sf.route_order = '".$route_order."'")->result_array();
      }

      $mname  = !empty($queryrouteto[0]['mname']) ? $queryrouteto[0]['mname'][0].". " : "";
      $suffix = !empty($queryrouteto[0]['suffix']) ? " ".$queryrouteto[0]['suffix'] : "";
      $concat = $queryrouteto[0]['fname']." ".$mname.$queryrouteto[0]['sname'].$suffix;
      $strtnm = str_replace('Ã±', '&ntilde;', $concat);
      $query['name'] = ucwords(str_replace('ã±', '&ntilde;', $strtnm));

      ///////////////////////////////////////////////////////////////////////////

      if(!empty($this->session->userdata('edit_lgu_patrolled_session'))){
      $lgu_id = $this->encrypt->decode($this->session->userdata('edit_lgu_patrolled_session'));

      $whr   = $this->db->where('dy.emb_id = "'.$lgu_id.'"');
      $qry   = $this->Embismodel->selectdata('dms_company AS dy','dy.company_name','',$whr);
      $query['lgu_name_selected'] = $qry[0]['company_name'];
      }

      $where_lgu          = $this->db->where('sla.region',$region_name);
      $where_lgu          = $this->db->where('sla.userid',$this->session->userdata('userid'));
      $query['query_lgu'] = $this->Embismodel->selectdata('sweet_lgu_assigned AS sla','sla.emb_id,sla.lgu_name','',$where_lgu);

      ///////////////////////////////////////////////////////////////////////////

      if(!empty($this->session->userdata('edit_barangay_session'))){
      $brgy_id = $this->encrypt->decode($this->session->userdata('edit_barangay_session'));

      $whr   = $this->db->where('db.id = "'.$brgy_id.'"');
      $qry   = $this->Embismodel->selectdata('dms_barangay AS db','db.name','',$whr);
      $query['brgy_name_selected'] = $qry[0]['name'];
      }

      $wherelguedit = array('dc.emb_id' => $query['sweet_form'][0]['lgu_patrolled_id']);
      $querylguedit = $this->Embismodel->selectdata('dms_company AS dc','city_id',$wherelguedit);

      $city_id      = $querylguedit[0]['city_id'];

      $orderbrgy        = $this->db->order_by('dy.name','ASC');
      $wherebrgy        = $this->db->where('dy.city_id = "'.$city_id.'"');
      $query['qrybrgy'] = $this->Embismodel->selectdata('embis.dms_barangay AS dy','dy.id,dy.name','',$wherebrgy,$orderbrgy);

      ///////////////////////////////////////////////////////////////////////////

      $query['tom'] = $this->Embismodel->selectdata('embis.sweet_type_of_monitoring AS stom','','');

      ///////////////////////////////////////////////////////////////////////////

      $query_attachment['previous_attachment']= base_url()."../"."iis-images/sweet_report/".date("Y", strtotime($query['sweet_form'][0]['date_created']))."/".$query['sweet_form'][0]['region']."/".$query['sweet_form'][0]['trans_no']."/".$query['sweet_form'][0]['attachment_name'];

      $this->load->view('swm/editform',$query);
      $this->load->view('swm/modals',$query_attachment);

  }
  function validate(){

    if(isset($_POST['submit_button'])){
      $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
      $this->form_validation->set_rules('trans_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('travel_no', '', 'required', array('required' => 'This field is required.'));

      (isset($_POST['inspectionmethod'])) ? $this->form_validation->set_rules('inspectionmethod', '', 'required', array('required' => 'This field is required.')) : '';

      $this->form_validation->set_rules('month_monitoring', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('date_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('time_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('lgu_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('sw_street', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('sw_latitude', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('sw_longitude', '', 'required', array('required' => 'This field is required.'));

      (isset($_POST['dtfm'])) ? $this->form_validation->set_rules('dtfm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtsm'])) ? $this->form_validation->set_rules('dtsm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtlm'])) ? $this->form_validation->set_rules('dtlm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtiln'])) ? $this->form_validation->set_rules('dtiln') : '';
      (isset($_POST['nil'])) ? $this->form_validation->set_rules('nil') : '';
      (isset($_POST['noa'])) ? $this->form_validation->set_rules('noa') : '';

      $this->form_validation->set_rules('ttlarea', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('photo_remarks', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('additional_remarks');

      !empty($_POST['lgu_patrolled'])      ? $this->session->set_userdata('lgu_patrolled_session', ($_POST['lgu_patrolled'])) : '';
      !empty($_POST['sw_barangay'])        ? $this->session->set_userdata('sw_barangay_session', $_POST['sw_barangay']) : '';
      !empty($_POST['travel_no'])          ? $this->session->set_userdata('travel_no_session', $_POST['travel_no']) : '';
      !empty($_POST['type_of_monitoring']) ? $this->session->set_userdata('type_of_monitoring_session', $_POST['type_of_monitoring']) : '';
      !empty($_POST['accessibility'])      ? $this->session->set_userdata('accessibility_session', $_POST['accessibility']) : '';

      $this->form_validation->set_rules('three[]');
      $this->form_validation->set_rules('four[]');
      $this->form_validation->set_rules('atbu[]');

      if ($this->form_validation->run() == FALSE)
      {
          $this->form();
      }
      else
      {
         if(!empty($this->session->userdata('swsite_photo'))){
           $data = $this->input->post();
           $this->save_data($data);
         }else{
           $this->form();
           echo "<script>alert('Please attach a photo.')</script>";
         }
      }
    }

    if(isset($_POST['submit_update_button'])){
      $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
      $this->form_validation->set_rules('trans_no', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('report_status', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('rn', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('sw_token', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('travel_no', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('date_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('time_patrolled', '', 'required', array('required' => 'This field is required.'));

      (isset($_POST['dtfm'])) ? $this->form_validation->set_rules('dtfm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtsm'])) ? $this->form_validation->set_rules('dtsm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtlm'])) ? $this->form_validation->set_rules('dtlm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtiln'])) ? $this->form_validation->set_rules('dtiln') : '';
      (isset($_POST['nil'])) ? $this->form_validation->set_rules('nil') : '';
      (isset($_POST['noa'])) ? $this->form_validation->set_rules('noa') : '';

      isset($_POST['travel_no'])          ? $this->session->set_userdata('travel_no_session', $_POST['travel_no']) : '';
      isset($_POST['type_of_monitoring']) ? $this->session->set_userdata('type_of_monitoring_session', $_POST['type_of_monitoring']) : '';

      $this->form_validation->set_rules('photo_remarks', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('additional_remarks');

      $photo_remarks      = isset($_POST['photo_remarks']) ? strlen($_POST['photo_remarks']) : "";
      $additional_remarks = isset($_POST['additional_remarks']) ? strlen($_POST['additional_remarks']) : "";
      $characters_left    = 1400 - ($photo_remarks + $additional_remarks);

      (isset($_POST['photo_remarks']) OR isset($_POST['additional_remarks'])) ? $this->session->set_userdata('characters_left', $characters_left) : '';

      $this->form_validation->set_rules('three[]');
      $this->form_validation->set_rules('atbu[]');

      if ($this->form_validation->run() == FALSE)
      {
          $this->updateform();
      }
      else
      {
        if(!empty($this->session->userdata('updtswupdtsite_photo'))){
          $data = $this->input->post();
          $this->update_save_data($data);
        }else{
          $this->form();
          echo "<script>alert('Please attach a photo.')</script>";
        }
      }
    }

    if(isset($_POST['submit_edit_button'])){
      $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
      $this->form_validation->set_rules('trans_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('travel_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('assignedtodmy', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('month_monitoring', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('date_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('time_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('lgu_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('street', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('latitude', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('longitude', '', 'required', array('required' => 'This field is required.'));

      isset($_POST['type_of_monitoring']) ? $this->session->set_userdata('type_of_monitoring_session', $_POST['type_of_monitoring']) : '';

      (isset($_POST['dtfm'])) ? $this->form_validation->set_rules('dtfm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtsm'])) ? $this->form_validation->set_rules('dtsm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtlm'])) ? $this->form_validation->set_rules('dtlm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtiln'])) ? $this->form_validation->set_rules('dtiln', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['nil'])) ? $this->form_validation->set_rules('nil', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['noa'])) ? $this->form_validation->set_rules('noa', '', 'required', array('required' => 'This field is required.')) : '';

      $this->form_validation->set_rules('ttlarea', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('photo_remarks', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('additional_remarks');

      !empty($_POST['lgu_patrolled']) ? $this->session->set_userdata('edit_lgu_patrolled_session', ($_POST['lgu_patrolled'])) : '';
      !empty($_POST['barangay'])      ? $this->session->set_userdata('edit_barangay_session', $_POST['barangay']) : '';
      !empty($_POST['travel_no'])     ? $this->session->set_userdata('travel_no_session', $_POST['travel_no']) : '';
      !empty($_POST['trans_no'])      ? $this->session->set_userdata('edit_trans_no_session', $_POST['trans_no']) : '';
      !empty($_POST['report_status']) ? $this->session->set_userdata('edit_report_status_session', $_POST['report_status']) : '';
      !empty($_POST['report_number']) ? $this->session->set_userdata('edit_report_number_session', $_POST['report_number']) : '';
      !empty($_POST['sw_fdsw']) ? $this->session->set_userdata('edit_sw_fdsw_session', $_POST['sw_fdsw']) : '';
      !empty($_POST['sw_location']) ? $this->session->set_userdata('edit_sw_location_session', $_POST['sw_location']) : '';
      !empty($_POST['sw_latitude']) ? $this->session->set_userdata('edit_sw_latitude_session', $_POST['sw_latitude']) : '';
      !empty($_POST['sw_longitude']) ? $this->session->set_userdata('edit_sw_longitude_session', $_POST['sw_longitude']) : '';

      $this->form_validation->set_rules('three[]');
      $this->form_validation->set_rules('four[]');
      $this->form_validation->set_rules('atbu[]');


      if ($this->form_validation->run() == FALSE)
      {
          $this->editform();
      }
      else
      {
         $data = $this->input->post();
         $this->save_edit_data($data);
      }
    }

    if(isset($_POST['submit_save_button'])){
      $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
      $this->form_validation->set_rules('trans_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('travel_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('assignedtodmy', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('month_monitoring', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('date_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('time_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('lgu_patrolled', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('street', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('latitude', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('longitude', '', 'required', array('required' => 'This field is required.'));

      isset($_POST['type_of_monitoring']) ? $this->session->set_userdata('type_of_monitoring_session', $_POST['type_of_monitoring']) : '';

      (isset($_POST['dtfm'])) ? $this->form_validation->set_rules('dtfm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtsm'])) ? $this->form_validation->set_rules('dtsm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtlm'])) ? $this->form_validation->set_rules('dtlm', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['dtiln'])) ? $this->form_validation->set_rules('dtiln', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['nil'])) ? $this->form_validation->set_rules('nil', '', 'required', array('required' => 'This field is required.')) : '';
      (isset($_POST['noa'])) ? $this->form_validation->set_rules('noa', '', 'required', array('required' => 'This field is required.')) : '';

      $this->form_validation->set_rules('ttlarea', '', 'required', array('required' => 'This field is required.'));

      $this->form_validation->set_rules('photo_remarks', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('additional_remarks');

      !empty($_POST['lgu_patrolled']) ? $this->session->set_userdata('edit_lgu_patrolled_session', ($_POST['lgu_patrolled'])) : '';
      !empty($_POST['barangay'])      ? $this->session->set_userdata('edit_barangay_session', $_POST['barangay']) : '';
      !empty($_POST['travel_no'])     ? $this->session->set_userdata('travel_no_session', $_POST['travel_no']) : '';
      !empty($_POST['trans_no'])      ? $this->session->set_userdata('edit_trans_no_session', $_POST['trans_no']) : '';
      !empty($_POST['report_status']) ? $this->session->set_userdata('edit_report_status_session', $_POST['report_status']) : '';
      !empty($_POST['report_number']) ? $this->session->set_userdata('edit_report_number_session', $_POST['report_number']) : '';
      !empty($_POST['sw_fdsw']) ? $this->session->set_userdata('edit_sw_fdsw_session', $_POST['sw_fdsw']) : '';
      !empty($_POST['sw_location']) ? $this->session->set_userdata('edit_sw_location_session', $_POST['sw_location']) : '';
      !empty($_POST['sw_latitude']) ? $this->session->set_userdata('edit_sw_latitude_session', $_POST['sw_latitude']) : '';
      !empty($_POST['sw_longitude']) ? $this->session->set_userdata('edit_sw_longitude_session', $_POST['sw_longitude']) : '';

      $this->form_validation->set_rules('three[]');
      $this->form_validation->set_rules('four[]');
      $this->form_validation->set_rules('atbu[]');


      if ($this->form_validation->run() == FALSE)
      {
          $this->editform();
      }
      else
      {
         $data = $this->input->post();
         $this->save_button_edit_data($data);
      }
    }



  }
  // public function check_inputs($str){
  //   if(empty($_FILES['site_photo']['name'])){
  //      $this->form_validation->set_message('check_inputs', 'Please choose a file to upload.');
  //      return FALSE;
  //   }else{
  //      return TRUE;
  //   }
  //
  // }
  function save_data($data){
    date_default_timezone_set("Asia/Manila");
    $userid   = $this->session->userdata('userid');
    $region   = $this->session->userdata('region');

    $wherelgu_name = $this->db->where('dy.emb_id',$this->encrypt->decode($data['lgu_patrolled']));
    $lgu_name      = $this->Embismodel->selectdata('dms_company AS dy','dy.company_name','',$wherelgu_name);

    $wherebrgy     = $this->db->where('dby.id',$this->encrypt->decode($data['sw_barangay']));
    $brgyname      = $this->Embismodel->selectdata('dms_barangay AS dby','dby.name','',$wherebrgy);

    $violations_observed_desc = "";
    $countvo = 0;
    if(!empty($_POST['three'])){
      foreach ($_POST['three'] as $key => $value) {
        $violations_observed_desc .= $this->encrypt->decode($value);
        $countvo++;
      }
    }

    $type_of_area_desc = "";
    $counttom = 0;

    if(!empty($_POST['four'])){
      foreach ($_POST['four'] as $key => $valuetom) {
        $type_of_area_desc .= ($valuetom);
        $counttom++;
      }
    }

    $atbu_desc = "";
    $countatbu = 0;

    if(!empty($_POST['atbu'])){
      foreach ($_POST['atbu'] as $key => $valueatbu) {
        $atbu_desc .= $this->encrypt->decode($valueatbu);
        $countatbu++;
      }
    }

    if($this->encrypt->decode($data['type_of_monitoring']) == '1'){ $type_of_monitoring_desc = 'Regular Monitoring'; }
    else if($this->encrypt->decode($data['type_of_monitoring']) == '2'){ $type_of_monitoring_desc = 'Validation of Action'; }
    else if($this->encrypt->decode($data['type_of_monitoring']) == '3'){ $type_of_monitoring_desc = 'Validation of Action by the LGU after issuance of NOV'; }

    $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($userid);
    $route_assigned     = $this->Sweetreportmodel->route_assigned($sweet_func_token,$userid);


    if(!empty($route_assigned[0]['assigned_to'])){
      !empty($route_assigned[0]['mname']) ? $mname = $route_assigned[0]['mname'][0].". " : $mname = "";
      !empty($route_assigned[0]['suffix']) ? $suffix = " ".$route_assigned[0]['suffix'] : $suffix = "";
      !empty($route_assigned[0]['title']) ? $prefix = $route_assigned[0]['title']." " : $prefix = "";
      $assigned_name = $prefix.$route_assigned[0]['fname']." ".$mname.$route_assigned[0]['sname'].$suffix;

      !empty($route_assigned[0]['umname']) ? $umname = $route_assigned[0]['umname'][0].". " : $umname = "";
      !empty($route_assigned[0]['usuffix']) ? $usuffix = " ".$route_assigned[0]['usuffix'] : $usuffix = "";
      !empty($route_assigned[0]['utitle']) ? $uprefix = $route_assigned[0]['utitle']." " : $uprefix = "";
      $user_name = $uprefix.$route_assigned[0]['ufname']." ".$umname.$route_assigned[0]['usname'].$usuffix;
    }

    $photo_remarks = !empty($data['photo_remarks']) ? str_replace("<br>", "", $data['photo_remarks']) : "";
    $additional_remarks = !empty($data['additional_remarks']) ? str_replace("<br>", "", $data['additional_remarks']) : "";

    $mro = $this->Sweetreportmodel->report_order($data['month_monitoring'],$type_of_monitoring_desc);
    $whereheader  = $this->db->where('oudh.region = "'.$this->session->userdata('region').'" AND oudh.office = "'.$this->session->userdata('office').'" AND oudh.cnt = (SELECT MAX(oudhh.cnt) FROM office_uploads_document_header AS oudhh WHERE oudhh.region = "'.$this->session->userdata('region').'" AND oudhh.office = "'.$this->session->userdata('office').'")');
    $selectheader = $this->Embismodel->selectdata('office_uploads_document_header AS oudh','oudh.file_name','',$whereheader);

    $insert_sweet_table = array(
      'trans_no'                    => $this->session->userdata('trans_no_token'),
      'header'                      => $selectheader[0]['file_name'],
      'region'                      => $this->session->userdata('region'),
      'travel_no'                   => $this->encrypt->decode($data['travel_no']),
      'inspection_method'           => !empty($_POST['inspectionmethod']) ? $data['inspectionmethod'] : '',
      'userid'                      => $this->session->userdata('userid'),
      'creator_name'                => $user_name,
      'month_monitoring'            => date("F", strtotime($data['month_monitoring'])),
      'date_created'                => date("Y-m-d"),
      'report_order'                => $mro,
      'subject'                     => $mro.". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
      'report_type'                 => "Unclean",
      'date_patrolled'              => $data['date_patrolled'],
      'time_patrolled'              => $data['time_patrolled'],
      'lgu_patrolled_id'            => $this->encrypt->decode($data['lgu_patrolled']),
      'lgu_patrolled_name'          => $lgu_name[0]['company_name'],
      'violations_observed_no'      => $countvo,
      'violations_observed_desc'    => $violations_observed_desc,
      'barangay_id'                 => $this->encrypt->decode($data['sw_barangay']),
      'barangay_name'               => $brgyname[0]['name'],
      'street'                      => $data['sw_street'],
      'latitude'                    => $data['sw_latitude'],
      'longitude'                   => $data['sw_longitude'],
      'type_of_area_no'             => $counttom,
      'type_of_area_desc'           => $type_of_area_desc,
      'accessibility'               => $this->encrypt->decode($_POST['accessibility']),
      'if_others_tom'               => !empty($_POST['if_toa_others']) ? $data['if_toa_others'] : '',
      'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
      'type_of_monitoring_desc'     => $type_of_monitoring_desc,
      'date_of_first_monitoring'    => $data['date_patrolled'],
      'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
      'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
      'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
      'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
      'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
      'total_land_area'             => $data['ttlarea'],
      'photo_remarks'               => $photo_remarks,
      'additional_remarks'          => $additional_remarks,
      'actions_undertaken_no'       => $countatbu,
      'actions_undertaken_desc'     => $atbu_desc,
      'final_disposal'              => '',
      'fd_location'                 => '',
      'fd_latitude'                 => '',
      'fd_longitude'                => '',
      'status'                      => "On-Process",
      'route_order'                 => $route_assigned[0]['route_order'],
      'assigned_to'                 => $route_assigned[0]['assigned_to'],
      'assigned_name'               => $assigned_name,
      'report_number'               => '1',
      'sw_token'                    => $this->encrypt->encode($this->session->userdata('trans_no_token')),
    );

    $sweet_form_insert = $this->Embismodel->insertdata('sweet_form', $insert_sweet_table);

    $insert_sweet_table_log = array(
      'trans_no'                    => $this->session->userdata('trans_no_token'),
      'header'                      => $selectheader[0]['file_name'],
      'region'                      => $this->session->userdata('region'),
      'travel_no'                   => $this->encrypt->decode($data['travel_no']),
      'inspection_method'           => !empty($_POST['inspectionmethod']) ? $data['inspectionmethod'] : '',
      'userid'                      => $this->session->userdata('userid'),
      'creator_name'                => $user_name,
      'month_monitoring'            => date("F", strtotime($data['month_monitoring'])),
      'date_created'                => date("Y-m-d"),
      'report_order'                => $mro,
      'subject'                     => $mro.". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
      'report_type'                 => "Unclean",
      'date_patrolled'              => $data['date_patrolled'],
      'time_patrolled'              => $data['time_patrolled'],
      'lgu_patrolled_id'            => $this->encrypt->decode($data['lgu_patrolled']),
      'lgu_patrolled_name'          => $lgu_name[0]['company_name'],
      'violations_observed_no'      => $countvo,
      'violations_observed_desc'    => $violations_observed_desc,
      'barangay_id'                 => $this->encrypt->decode($data['sw_barangay']),
      'barangay_name'               => $brgyname[0]['name'],
      'street'                      => $data['sw_street'],
      'latitude'                    => $data['sw_latitude'],
      'longitude'                   => $data['sw_longitude'],
      'type_of_area_no'             => $counttom,
      'type_of_area_desc'           => $type_of_area_desc,
      'accessibility'               => $this->encrypt->decode($_POST['accessibility']),
      'if_others_tom'               => !empty($_POST['if_toa_others']) ? $data['if_toa_others'] : '',
      'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
      'type_of_monitoring_desc'     => $type_of_monitoring_desc,
      'date_of_first_monitoring'    => $data['date_patrolled'],
      'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
      'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
      'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
      'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
      'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
      'total_land_area'             => $data['ttlarea'],
      'photo_remarks'               => $photo_remarks,
      'additional_remarks'          => $additional_remarks,
      'actions_undertaken_no'       => $countatbu,
      'actions_undertaken_desc'     => $atbu_desc,
      'final_disposal'              => '',
      'fd_location'                 => '',
      'fd_latitude'                 => '',
      'fd_longitude'                => '',
      'status'                      => "On-Process",
      'route_order'                 => $route_assigned[0]['route_order'],
      'assigned_to'                 => $route_assigned[0]['assigned_to'],
      'assigned_name'               => $assigned_name,
      'report_number'               => '1',
      'sw_token'                    => $this->encrypt->encode($this->session->userdata('trans_no_token')),
    );

    $sweet_form_insert_log = $this->Embismodel->insertdata('sweet_form_log', $insert_sweet_table_log);

    $insert_sweet_route_log = array(
                                    'trans_no'      => $this->session->userdata('trans_no_token'),
                                    'report_number' => '1',
                                    'assigned_to'   => $route_assigned[0]['assigned_to'],
                                    'designation'   => $route_assigned[0]['designation'],
                                    'name'          => $assigned_name,
                                   );
    $sweet_route_log = $this->Embismodel->insertdata('sweet_route_log', $insert_sweet_route_log);

    $ip_address = $this->input->ip_address();

    if($sweet_form_insert){
        $where    = $this->db->where('acs.userid',$route_assigned[0]['assigned_to']);
        $where    = $this->db->where('acs.verified','1');
        $join     = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
        $join     = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
        $receiver = $this->Embismodel->selectdata('acc_credentials AS acs','xn.divno,xn.divname,xt.secno,xt.sect,acs.region,acs.userid,acs.fname,acs.sname,acs.token','',$where);
        $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
        $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
        $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
        $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
        $receiverdivno = (!empty($receiver[0]['divno'])) ? $receiver[0]['divno'] : '';
        $receiversecno = (!empty($receiver[0]['secno'])) ? $receiver[0]['secno'] : '';

        $date_out = date('Y-m-d H:i:s');
        $et_where = array('et.trans_no' => $this->session->userdata('trans_no'));
        $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where );

        $trans_set = array(
          'route_order'         => "1",
          'subject'             => $mro.". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
          'sender_ipadress'     => $ip_address,
          'receiver_divno'      => $receiverdivno,
          'receiver_secno'      => $receiversecno,
          'receiver_id'         => $receiver[0]['token'],
          'receiver_name'       => $receiver_name,
          'receiver_region'     => $receiver[0]['region'],
          'type'                => "51",
          'status'              => "15",
          'status_description'  => "For Approval",
          'action_taken'        => "Pls. for approval (Unclean)",
          'date_out'            => $date_out,
        );

        $trans_update_where = array(
          'etl.trans_no'    => $this->session->userdata('trans_no'),
        );

        $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

        // $likeemb    = $this->db->like('company_name','Environmental Management Bureau');
        $whereemb   = $this->db->where('dc.region_name',$region);
        $whereemb   = $this->db->where('dc.emb_id',$this->encrypt->decode($data['lgu_patrolled']));
        $queryemb   = $this->Embismodel->selectdata('dms_company AS dc','dc.token,dc.company_name,dc.emb_id','',$whereemb);

        $set = array(
          'et.route_order'        => "1",
          'et.company_token'      => $queryemb[0]['token'],
          'et.company_name'       => $queryemb[0]['company_name'],
          'et.emb_id'             => $queryemb[0]['emb_id'],
          'et.subject'            => $mro.". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
          'et.system'             => "9",
          'et.type'               => "51",
          'et.type_description'   => "SWEET REPORT",
          'et.status'             => "15",
          'et.status_description' => "For Approval",
          'et.receive'            => 0,
          'et.receiver_division'  => $receiver[0]['divname'],
          'et.receiver_section'   => $receiver[0]['sect'],
          'receiver_region'       => $receiver[0]['region'],
          'et.receiver_id'        => $receiver[0]['token'],
          'et.receiver_name'      => $receiver_name,
          'et.action_taken'       => "Pls. for approval (Unclean)",
          'et.remarks'            => "None",
          'et.end_date'           => $date_out,
        );

        $where = array( 'et.trans_no' => $this->session->userdata('trans_no'));
        $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
    }
    $swal_arr = array(
       'title'     => 'SUCCESS!',
       'text'      => 'Sweet report successfully inserted.',
       'type'      => 'success',
     );
     $this->session->set_flashdata('swal_arr', $swal_arr);
    redirect(base_url()."Swm/Sweet");

  }
  function update_save_data($data){

    date_default_timezone_set("Asia/Manila");
    $sender   = $this->session->userdata('token');
    $userid   = $this->session->userdata('userid');
    $region   = $this->session->userdata('region');

    $sw_token = $this->encrypt->decode($data['sw_token']);

    $violations_observed_desc = "";
    $countvo = 0;
    if(!empty($_POST['three'])){
      foreach ($_POST['three'] as $key => $value) {
        $violations_observed_desc .= $this->encrypt->decode($value);
        $countvo++;
      }
    }

    $atbu_desc = "";
    $countatbu = 0;

    if(!empty($_POST['atbu'])){
      foreach ($_POST['atbu'] as $key => $valueatbu) {
        $atbu_desc .= $this->encrypt->decode($valueatbu);
        $countatbu++;
      }
    }

    if($this->encrypt->decode($data['type_of_monitoring']) == '2'){ $type_of_monitoring_desc = 'Validation of Action'; }
    else if($this->encrypt->decode($data['type_of_monitoring']) == '3'){ $type_of_monitoring_desc = 'Validation of Action by the LGU after issuance of NOV'; }

    $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($userid);
    $route_assigned     = $this->Sweetreportmodel->route_assigned($sweet_func_token,$userid);

    if(!empty($route_assigned[0]['assigned_to'])){
      !empty($route_assigned[0]['mname']) ? $mname = $route_assigned[0]['mname'][0].". " : $mname = "";
      !empty($route_assigned[0]['suffix']) ? $suffix = " ".$route_assigned[0]['suffix'] : $suffix = "";
      !empty($route_assigned[0]['title']) ? $prefix = $route_assigned[0]['title']." " : $prefix = "";
      $assigned_name = $prefix.$route_assigned[0]['fname']." ".$mname.$route_assigned[0]['sname'].$suffix;

      !empty($route_assigned[0]['umname']) ? $umname = $route_assigned[0]['umname'][0].". " : $umname = "";
      !empty($route_assigned[0]['usuffix']) ? $usuffix = " ".$route_assigned[0]['usuffix'] : $usuffix = "";
      !empty($route_assigned[0]['utitle']) ? $uprefix = $route_assigned[0]['utitle']." " : $uprefix = "";
      $user_name = $uprefix.$route_assigned[0]['ufname']." ".$umname.$route_assigned[0]['usname'].$usuffix;
    }

    $photo_remarks = !empty($data['photo_remarks']) ? str_replace("<br>", "", $data['photo_remarks']) : "";
    $additional_remarks = !empty($data['additional_remarks']) ? str_replace("<br>", "", $data['additional_remarks']) : "";

    $wherepreviousreport  = $this->db->where('sf.trans_no',$sw_token);
    $selectpreviousreport = $this->Embismodel->selectdata('sweet_form AS sf','month_monitoring,report_order','',$wherepreviousreport);

    $mro   = $this->Sweetreportmodel->report_order($selectpreviousreport[0]['month_monitoring'],$type_of_monitoring_desc);

    $wheremaxrn = $this->db->where('sf.trans_no',$sw_token);
    $maxrn = $this->Embismodel->selectdata('sweet_form AS sf','MAX(report_number) AS mrn','',$wheremaxrn);

    $mxrn = $maxrn[0]['mrn'] + 1;



    $data = array(
            'travel_no'                   => $this->encrypt->decode($data['travel_no']),
            'date_created'                => date("Y-m-d"),
            'subject'                     => $selectpreviousreport[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($selectpreviousreport[0]['month_monitoring']))." - ".$type_of_monitoring_desc,
            'report_type'                 => $this->encrypt->decode($data['report_status']),
            'date_patrolled'              => $data['date_patrolled'],
            'time_patrolled'              => $data['time_patrolled'],
            'violations_observed_no'      => $countvo,
            'violations_observed_desc'    => $violations_observed_desc,
            'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
            'type_of_monitoring_desc'     => $type_of_monitoring_desc,
            'date_of_first_monitoring'    => !empty($_POST['dtfm']) ? $data['dtfm'] : '',
            'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
            'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
            'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
            'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
            'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
            'photo_remarks'               => $photo_remarks,
            'additional_remarks'          => $additional_remarks,
            'actions_undertaken_no'       => $countatbu,
            'actions_undertaken_desc'     => $atbu_desc,
            'final_disposal'              => !empty($this->session->userdata('sw_fdsw')) ? $this->session->userdata('sw_fdsw') : '',
            'fd_location'                 => !empty($this->session->userdata('sw_location')) ? $this->session->userdata('sw_location') : '',
            'fd_latitude'                 => !empty($this->session->userdata('sw_latitude')) ? $this->session->userdata('sw_latitude') : '',
            'fd_longitude'                => !empty($this->session->userdata('sw_longitude')) ? $this->session->userdata('sw_longitude') : '',
            'status'                      => "On-Process",
            'route_order'                 => $route_assigned[0]['route_order'],
            'assigned_to'                 => $route_assigned[0]['assigned_to'],
            'assigned_name'               => $assigned_name,
            'report_number'               => $mxrn,
          );

    $update_sweet_form_where = array( 'sf.trans_no' => $sw_token);

    $update_sweet_form = $this->Embismodel->updatedata( $data, 'sweet_form AS sf', $update_sweet_form_where );

    $whereupdatedreport  = $this->db->where('sf.trans_no',$sw_token);
    $selectupdatedreport = $this->Embismodel->selectdata('sweet_form AS sf','*','',$whereupdatedreport);

    $insert_sweet_table = array(
      'trans_no'                    => $sw_token,
      'header'                      => $selectupdatedreport[0]['header'],
      'region'                      => $selectupdatedreport[0]['region'],
      'travel_no'                   => $selectupdatedreport[0]['travel_no'],
      'userid'                      => $selectupdatedreport[0]['userid'],
      'creator_name'                => $selectupdatedreport[0]['creator_name'],
      'month_monitoring'            => $selectupdatedreport[0]['month_monitoring'],
      'date_created'                => $selectupdatedreport[0]['date_created'],
      'report_order'                => $selectupdatedreport[0]['report_order'],
      'subject'                     => $selectupdatedreport[0]['subject'],
      'report_type'                 => $selectupdatedreport[0]['report_type'],
      'date_patrolled'              => $selectupdatedreport[0]['date_patrolled'],
      'time_patrolled'              => $selectupdatedreport[0]['time_patrolled'],
      'lgu_patrolled_id'            => $selectupdatedreport[0]['lgu_patrolled_id'],
      'lgu_patrolled_name'          => $selectupdatedreport[0]['lgu_patrolled_name'],
      'violations_observed_no'      => $selectupdatedreport[0]['violations_observed_no'],
      'violations_observed_desc'    => $selectupdatedreport[0]['violations_observed_desc'],
      'barangay_id'                 => $selectupdatedreport[0]['barangay_id'],
      'barangay_name'               => $selectupdatedreport[0]['barangay_name'],
      'street'                      => $selectupdatedreport[0]['street'],
      'latitude'                    => $selectupdatedreport[0]['latitude'],
      'longitude'                   => $selectupdatedreport[0]['longitude'],
      'type_of_area_no'             => $selectupdatedreport[0]['type_of_area_no'],
      'type_of_area_desc'           => $selectupdatedreport[0]['type_of_area_desc'],
      'if_others_tom'               => $selectupdatedreport[0]['if_others_tom'],
      'type_of_monitoring'          => $selectupdatedreport[0]['type_of_monitoring'],
      'type_of_monitoring_desc'     => $selectupdatedreport[0]['type_of_monitoring_desc'],
      'date_of_first_monitoring'    => $selectupdatedreport[0]['date_of_first_monitoring'],
      'date_of_second_monitoring'   => $selectupdatedreport[0]['date_of_second_monitoring'],
      'date_of_last_monitoring'     => $selectupdatedreport[0]['date_of_last_monitoring'],
      'date_of_issuance_of_notice'  => $selectupdatedreport[0]['date_of_issuance_of_notice'],
      'number_dumping'              => $selectupdatedreport[0]['number_dumping'],
      'number_activity'             => $selectupdatedreport[0]['number_activity'],
      'total_land_area'             => $selectupdatedreport[0]['total_land_area'],
      'photo_remarks'               => $selectupdatedreport[0]['photo_remarks'],
      'additional_remarks'          => $selectupdatedreport[0]['additional_remarks'],
      'actions_undertaken_no'       => $selectupdatedreport[0]['actions_undertaken_no'],
      'actions_undertaken_desc'     => $selectupdatedreport[0]['actions_undertaken_desc'],
      'final_disposal'              => $selectupdatedreport[0]['final_disposal'],
      'fd_location'                 => $selectupdatedreport[0]['fd_location'],
      'fd_latitude'                 => $selectupdatedreport[0]['fd_latitude'],
      'fd_longitude'                => $selectupdatedreport[0]['fd_longitude'],
      'status'                      => $selectupdatedreport[0]['status'],
      'route_order'                 => $selectupdatedreport[0]['route_order'],
      'assigned_to'                 => $selectupdatedreport[0]['assigned_to'],
      'assigned_name'               => $selectupdatedreport[0]['assigned_name'],
      'report_number'               => $selectupdatedreport[0]['report_number'],
      'sw_token'                    => $selectupdatedreport[0]['sw_token'],
    );

    $sweet_form_insert = $this->Embismodel->insertdata('sweet_form_log', $insert_sweet_table);

    $ip_address = $this->input->ip_address();
    if($sweet_form_insert){
        $where    = $this->db->where('acs.userid',$route_assigned[0]['assigned_to']);
        $where    = $this->db->where('acs.verified','1');
        $join     = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
        $join     = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
        $receiver = $this->Embismodel->selectdata('acc_credentials AS acs','xn.divno,xn.divname,xt.secno,xt.sect,acs.region,acs.userid,acs.fname,acs.sname,acs.token','',$where);
        $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
        $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
        $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
        $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
        $receiverdivno = (!empty($receiver[0]['divno'])) ? $receiver[0]['divno'] : '';
        $receiversecno = (!empty($receiver[0]['secno'])) ? $receiver[0]['secno'] : '';

        $date_out = date('Y-m-d H:i:s');
        $et_where = array('et.token' => $sw_token);
        $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where );

        $set = array(
          'et.route_order'        => $er_trans_query[0]['route_order']+1,
          'et.subject'            => $selectupdatedreport[0]['subject'],
          'et.status'             => "15",
          'et.status_description' => "For Approval",
          'et.receive'            => 0,
          'et.sender_id'          => $sender,
          'et.sender_name'        => $user_name,
          'et.receiver_division'  => $receiver[0]['divname'],
          'et.receiver_section'   => $receiver[0]['sect'],
          'receiver_region'       => $receiver[0]['region'],
          'et.receiver_id'        => $receiver[0]['token'],
          'et.receiver_name'      => $receiver_name,
          'et.action_taken'       => "Pls. for approval (".$selectupdatedreport[0]['report_type'].")",
          'et.remarks'            => "None",
        );

        $where = array( 'et.trans_no' => $er_trans_query[0]['trans_no']);
        $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

        $insert_er_trans_log_table = array(
          'trans_no'            => $er_trans_query[0]['trans_no'],
          'route_order'         => $er_trans_query[0]['route_order']+1,
          'subject'             => $selectupdatedreport[0]['subject'],
          'sender_divno'        => $route_assigned[0]['divno'],
          'sender_secno'        => $route_assigned[0]['secno'],
          'sender_id'           => $sender,
          'sender_name'         => $user_name,
          'sender_region'       => $selectupdatedreport[0]['region'],
          'sender_ipadress'     => $ip_address,
          'receiver_divno'      => $receiverdivno,
          'receiver_secno'      => $receiversecno,
          'receiver_id'         => $receiver[0]['token'],
          'receiver_name'       => $receiver_name,
          'receiver_region'     => $receiver[0]['region'],
          'type'                => "51",
          'status'              => "15",
          'status_description'  => "For Approval",
          'action_taken'        => "Pls. for approval (".$selectupdatedreport[0]['report_type'].")",
          'date_in'             => $date_out,
          'date_out'            => $date_out,
        );

        $sweet_form_insert = $this->Embismodel->insertdata('er_transactions_log', $insert_er_trans_log_table);
    }

    $swal_arr = array(
       'title'     => 'SUCCESS!',
       'text'      => 'Sweet report successfully inserted.',
       'type'      => 'success',
     );
     $this->session->set_flashdata('swal_arr', $swal_arr);
    redirect(base_url()."Swm/Sweet");

  }
  function save_edit_data($data){
    date_default_timezone_set("Asia/Manila");
    $userid   = $this->session->userdata('userid');
    $region   = $this->session->userdata('region');

    $trans_no = $this->encrypt->decode($data['trans_no']);

    $et_where = array('et.token' => $trans_no);
    $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', 'trans_no,route_order', $et_where );

    $whereinsertcnt    = $this->db->where('sf.trans_no',$this->encrypt->decode($data['trans_no']));
    $selectinsertcnt   = $this->Embismodel->selectdata('sweet_form AS sf','sf.route_order,sf.userid,sf.report_order,sf.report_type,sf.date_created,sf.cnt','',$whereinsertcnt);

    $wherelgu_name = $this->db->where('dy.emb_id',$this->encrypt->decode($data['lgu_patrolled']));
    $lgu_name      = $this->Embismodel->selectdata('dms_company AS dy','dy.company_name','',$wherelgu_name);

    $wherebrgy     = $this->db->where('dby.id',$this->encrypt->decode($data['barangay']));
    $brgyname      = $this->Embismodel->selectdata('dms_barangay AS dby','dby.name','',$wherebrgy);

    $violations_observed_desc = "";
    $countvo = 0;
    if(!empty($data['three'])){
      foreach ($data['three'] as $key => $value) {
        $violations_observed_desc .= $this->encrypt->decode($value);
        $countvo++;
      }
    }

    $type_of_area_desc = "";
    $counttom = 0;

    if(!empty($data['four'])){
      foreach ($data['four'] as $key => $valuetom) {
        $type_of_area_desc .= ($valuetom);
        $counttom++;
      }
    }

    $atbu_desc = "";
    $countatbu = 0;

    if(!empty($data['atbu'])){
      foreach ($data['atbu'] as $key => $valueatbu) {
        $atbu_desc .= $this->encrypt->decode($valueatbu);
        $countatbu++;
      }
    }

    if($this->encrypt->decode($data['type_of_monitoring']) == '1'){ $type_of_monitoring_desc = 'Regular Monitoring'; }
    else if($this->encrypt->decode($data['type_of_monitoring']) == '2'){ $type_of_monitoring_desc = 'Validation of Action'; }
    else if($this->encrypt->decode($data['type_of_monitoring']) == '3'){ $type_of_monitoring_desc = 'Validation of Action by the LGU after issuance of NOV'; }

    $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($selectinsertcnt[0]['userid']);
    $route_assigned     = $this->Sweetreportmodel->route_assigned($sweet_func_token,$selectinsertcnt[0]['userid'],$selectinsertcnt[0]['route_order']);

    if(!empty($route_assigned[0]['assigned_to'])){
      !empty($route_assigned[0]['mname']) ? $mname = $route_assigned[0]['mname'][0].". " : $mname = "";
      !empty($route_assigned[0]['suffix']) ? $suffix = " ".$route_assigned[0]['suffix'] : $suffix = "";
      !empty($route_assigned[0]['title']) ? $prefix = $route_assigned[0]['title']. " " : $prefix = "";
      $assigned_name = $prefix.$route_assigned[0]['fname']." ".$mname.$route_assigned[0]['sname'].$suffix;

      !empty($route_assigned[0]['umname']) ? $umname = $route_assigned[0]['umname'][0].". " : $umname = "";
      !empty($route_assigned[0]['usuffix']) ? $usuffix = " ".$route_assigned[0]['usuffix'] : $usuffix = "";
      !empty($route_assigned[0]['utitle']) ? $uprefix = " ".$route_assigned[0]['utitle'] : $uprefix = "";
      $user_name = $uprefix.$route_assigned[0]['ufname']." ".$umname.$route_assigned[0]['usname'].$usuffix;
    }

    $photo_remarks = !empty($data['photo_remarks']) ? str_replace("<br>", "", $data['photo_remarks']) : "";
    $additional_remarks = !empty($data['additional_remarks']) ? str_replace("<br>", "", $data['additional_remarks']) : "";

    $mro = $this->Sweetreportmodel->report_order($data['month_monitoring'],$type_of_monitoring_desc);


    $update_sweet_table = array(
      // 'trans_no'                    => $this->encrypt->decode($data['trans_no']),
      // 'region'                      => $this->session->userdata('region'),
      'travel_no'                   => $this->encrypt->decode($data['travel_no']),
      // 'userid'                      => $this->session->userdata('userid'),
      // 'creator_name'                => $user_name,
      'month_monitoring'            => date("F", strtotime($data['month_monitoring'])),
      // 'date_created'                => date("Y-m-d"),
      // 'report_order'                => $mro,
      'subject'                     => $selectinsertcnt[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
      'report_type'                 => $this->encrypt->decode($data['report_status']),
      'date_patrolled'              => $data['date_patrolled'],
      'time_patrolled'              => $data['time_patrolled'],
      'lgu_patrolled_id'            => $this->encrypt->decode($data['lgu_patrolled']),
      'lgu_patrolled_name'          => $lgu_name[0]['company_name'],
      'violations_observed_no'      => $countvo,
      'violations_observed_desc'    => $violations_observed_desc,
      'barangay_id'                 => $this->encrypt->decode($data['barangay']),
      'barangay_name'               => $brgyname[0]['name'],
      'street'                      => $data['street'],
      'latitude'                    => $data['latitude'],
      'longitude'                   => $data['longitude'],
      'type_of_area_no'             => $counttom,
      'type_of_area_desc'           => $type_of_area_desc,
      'if_others_tom'               => !empty($_POST['if_toa_others']) ? $data['if_toa_others'] : '',
      'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
      'type_of_monitoring_desc'     => $type_of_monitoring_desc,
      'date_of_first_monitoring'    => !empty($_POST['dtfm']) ? $data['dtfm'] : $data['date_patrolled'],
      'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
      'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
      'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
      'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
      'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
      'total_land_area'             => $data['ttlarea'],
      'photo_remarks'               => $photo_remarks,
      'additional_remarks'          => $additional_remarks,
      'actions_undertaken_no'       => $countatbu,
      'actions_undertaken_desc'     => $atbu_desc,
      'final_disposal'              => !empty(($data['sw_fdsw'])) ? ($data['sw_fdsw']) : '',
      'fd_location'                 => !empty(($data['sw_location'])) ? ($data['sw_location']) : '',
      'fd_latitude'                 => !empty(($data['sw_latitude'])) ? ($data['sw_latitude']) : '',
      'fd_longitude'                => !empty(($data['sw_longitude'])) ? ($data['sw_longitude']) : '',
      'status'                      => "On-Process",
      'route_order'                 => $route_assigned[0]['route_order'],
      'assigned_to'                 => $route_assigned[0]['assigned_to'],
      'assigned_name'               => $assigned_name,
    );

    $trans_update_where = array(
      'trans_no'    => $this->encrypt->decode($data['trans_no']),
    );

    $update_form = $this->Embismodel->updatedata( $update_sweet_table, 'sweet_form', $trans_update_where );

    $update_sweet_table_log = array(
      'travel_no'                   => $this->encrypt->decode($data['travel_no']),
      'month_monitoring'            => date("F", strtotime($data['month_monitoring'])),
      // 'date_created'                => date("Y-m-d"),
      'subject'                     => $selectinsertcnt[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
      'report_type'                 => $this->encrypt->decode($data['report_status']),
      'date_patrolled'              => $data['date_patrolled'],
      'time_patrolled'              => $data['time_patrolled'],
      'lgu_patrolled_id'            => $this->encrypt->decode($data['lgu_patrolled']),
      'lgu_patrolled_name'          => $lgu_name[0]['company_name'],
      'violations_observed_no'      => $countvo,
      'violations_observed_desc'    => $violations_observed_desc,
      'barangay_id'                 => $this->encrypt->decode($data['barangay']),
      'barangay_name'               => $brgyname[0]['name'],
      'street'                      => $data['street'],
      'latitude'                    => $data['latitude'],
      'longitude'                   => $data['longitude'],
      'type_of_area_no'             => $counttom,
      'type_of_area_desc'           => $type_of_area_desc,
      'if_others_tom'               => !empty($_POST['if_toa_others']) ? $data['if_toa_others'] : '',
      'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
      'type_of_monitoring_desc'     => $type_of_monitoring_desc,
      'date_of_first_monitoring'    => !empty($_POST['dtfm']) ? $data['dtfm'] : '',
      'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
      'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
      'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
      'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
      'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
      'total_land_area'             => $data['ttlarea'],
      'photo_remarks'               => $photo_remarks,
      'additional_remarks'          => $additional_remarks,
      'actions_undertaken_no'       => $countatbu,
      'actions_undertaken_desc'     => $atbu_desc,
      'final_disposal'              => !empty(($data['sw_fdsw'])) ? ($data['sw_fdsw']) : '',
      'fd_location'                 => !empty(($data['sw_location'])) ? ($data['sw_location']) : '',
      'fd_latitude'                 => !empty(($data['sw_latitude'])) ? ($data['sw_latitude']) : '',
      'fd_longitude'                => !empty(($data['sw_longitude'])) ? ($data['sw_longitude']) : '',
      'status'                      => "On-Process",
      'route_order'                 => $route_assigned[0]['route_order'],
      'assigned_to'                 => $route_assigned[0]['assigned_to'],
      'assigned_name'               => $assigned_name,
    );

    $trans_update_where_log = array(
      'trans_no'      => $this->encrypt->decode($data['trans_no']),
      'report_number' => $this->encrypt->decode($data['report_number']),

    );

    $update_form_log = $this->Embismodel->updatedata( $update_sweet_table_log, 'sweet_form_log', $trans_update_where_log );

    $ip_address = $this->input->ip_address();

        $where    = $this->db->where('acs.userid',$route_assigned[0]['assigned_to']);
        $where    = $this->db->where('acs.verified','1');
        $join     = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
        $join     = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
        $receiver = $this->Embismodel->selectdata('acc_credentials AS acs','xn.divno,xn.divname,xt.secno,xt.sect,acs.region,acs.userid,acs.fname,acs.sname,acs.token','',$where);
        $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
        $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
        $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
        $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
        $receiverdivno = (!empty($receiver[0]['divno'])) ? $receiver[0]['divno'] : '';
        $receiversecno = (!empty($receiver[0]['secno'])) ? $receiver[0]['secno'] : '';

        $senderwhere = array('ac.token' => $this->session->userdata('token'));
        $sender = $this->Embismodel->selectdata('acc_credentials AS ac', '', $senderwhere );

        $suffix = '';
        if(!empty($sender[0]['suffix']) )
          $suffix = ' '.$sender[0]['suffix'];

        $sender_name = ucwords($sender[0]['fname']." ".$sender[0]['sname']).$suffix;

        $date_out = date('Y-m-d H:i:s');

        // $likeemb    = $this->db->like('company_name','Environmental Management Bureau');
        $whereemb   = $this->db->where('dc.emb_id',$this->encrypt->decode($data['lgu_patrolled']));
        $whereemb   = $this->db->where('dc.region_name',$region);
        $queryemb   = $this->Embismodel->selectdata('dms_company AS dc','dc.token,dc.company_name,dc.emb_id','',$whereemb,$likeemb);

         $set = array(
          'et.route_order'        => $er_trans_query[0]['route_order']+1,
          'et.subject'            => $selectinsertcnt[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
          'et.status'             => "15",
          'et.status_description' => "For Approval",
          'et.receive'            => 0,
          'et.sender_id'          => $this->session->userdata('token'),
          'et.sender_name'        => $sender_name,
          'et.receiver_division'  => $receiver[0]['divname'],
          'et.receiver_section'   => $receiver[0]['sect'],
          'receiver_region'       => $receiver[0]['region'],
          'et.receiver_id'        => $receiver[0]['token'],
          'et.receiver_name'      => $receiver_name,
          'et.action_taken'       => "Pls. for approval (".$this->encrypt->decode($data['report_status']).")",
          'et.remarks'            => "None",
          'et.start_date'         => $date_out,
        );

        $where = array( 'et.trans_no' => $er_trans_query[0]['trans_no']);
        $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

        $insert_er_trans_log_table = array(
          'trans_no'            => $er_trans_query[0]['trans_no'],
          'route_order'         => $er_trans_query[0]['route_order']+1,
          'subject'             => $selectinsertcnt[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
          'sender_divno'        => $route_assigned[0]['divno'],
          'sender_secno'        => $route_assigned[0]['secno'],
          'sender_id'           => $this->session->userdata('token'),
          'sender_name'         => $sender_name,
          'sender_region'       => $this->session->userdata('region'),
          'sender_ipadress'     => $ip_address,
          'receiver_divno'      => $receiverdivno,
          'receiver_secno'      => $receiversecno,
          'receiver_id'         => $receiver[0]['token'],
          'receiver_name'       => $receiver_name,
          'receiver_region'     => $receiver[0]['region'],
          'type'                => "51",
          'status'              => "15",
          'status_description'  => "For Approval",
          'action_taken'        => "Pls. for approval (".$this->encrypt->decode($data['report_status']).")",
          'date_in'             => $date_out,
          'date_out'            => $date_out,
        );

        $this->Embismodel->insertdata('er_transactions_log', $insert_er_trans_log_table);

     $swal_arr = array(
       'title'     => 'SUCCESS!',
       'text'      => 'Sweet report successfully edited.',
       'type'      => 'success',
     );
     $this->session->set_flashdata('swal_arr', $swal_arr);
    redirect(base_url()."Swm/Sweet");

  }

  function save_button_edit_data($data){
      date_default_timezone_set("Asia/Manila");
      $userid   = $this->session->userdata('userid');
      $region   = $this->session->userdata('region');

      $trans_no = $this->encrypt->decode($data['trans_no']);

      $et_where = array('et.token' => $trans_no);
      $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', 'trans_no,route_order', $et_where );

      $whereinsertcnt    = $this->db->where('sf.trans_no',$this->encrypt->decode($data['trans_no']));
      $selectinsertcnt   = $this->Embismodel->selectdata('sweet_form AS sf','sf.route_order,sf.userid,sf.report_order,sf.report_type,sf.date_created,sf.cnt','',$whereinsertcnt);

      $wherelgu_name = $this->db->where('dy.emb_id',$this->encrypt->decode($data['lgu_patrolled']));
      $lgu_name      = $this->Embismodel->selectdata('dms_company AS dy','dy.company_name,dy.emb_id,dy.token','',$wherelgu_name);

      $wherebrgy     = $this->db->where('dby.id',$this->encrypt->decode($data['barangay']));
      $brgyname      = $this->Embismodel->selectdata('dms_barangay AS dby','dby.name','',$wherebrgy);

      $violations_observed_desc = "";
      $countvo = 0;
      if(!empty($data['three'])){
        foreach ($data['three'] as $key => $value) {
          $violations_observed_desc .= $this->encrypt->decode($value);
          $countvo++;
        }
      }

      $type_of_area_desc = "";
      $counttom = 0;

      if(!empty($data['four'])){
        foreach ($data['four'] as $key => $valuetom) {
          $type_of_area_desc .= ($valuetom);
          $counttom++;
        }
      }

      $atbu_desc = "";
      $countatbu = 0;

      if(!empty($data['atbu'])){
        foreach ($data['atbu'] as $key => $valueatbu) {
          $atbu_desc .= $this->encrypt->decode($valueatbu);
          $countatbu++;
        }
      }

      if($this->encrypt->decode($data['type_of_monitoring']) == '1'){ $type_of_monitoring_desc = 'Regular Monitoring'; }
      else if($this->encrypt->decode($data['type_of_monitoring']) == '2'){ $type_of_monitoring_desc = 'Validation of Action'; }
      else if($this->encrypt->decode($data['type_of_monitoring']) == '3'){ $type_of_monitoring_desc = 'Validation of Action by the LGU after issuance of NOV'; }

      $sweet_func_token   = $this->Sweetreportmodel->sweet_func_user($selectinsertcnt[0]['userid']);
      $route_assigned     = $this->Sweetreportmodel->route_assigned($sweet_func_token,$selectinsertcnt[0]['userid'],$selectinsertcnt[0]['route_order']);

      if(!empty($route_assigned[0]['assigned_to'])){
        !empty($route_assigned[0]['mname']) ? $mname = $route_assigned[0]['mname'][0].". " : $mname = "";
        !empty($route_assigned[0]['suffix']) ? $suffix = " ".$route_assigned[0]['suffix'] : $suffix = "";
        !empty($route_assigned[0]['title']) ? $prefix = $route_assigned[0]['title']. " " : $prefix = "";
        $assigned_name = $prefix.$route_assigned[0]['fname']." ".$mname.$route_assigned[0]['sname'].$suffix;

        !empty($route_assigned[0]['umname']) ? $umname = $route_assigned[0]['umname'][0].". " : $umname = "";
        !empty($route_assigned[0]['usuffix']) ? $usuffix = " ".$route_assigned[0]['usuffix'] : $usuffix = "";
        !empty($route_assigned[0]['utitle']) ? $uprefix = " ".$route_assigned[0]['utitle'] : $uprefix = "";
        $user_name = $uprefix.$route_assigned[0]['ufname']." ".$umname.$route_assigned[0]['usname'].$usuffix;
      }

      $photo_remarks = !empty($data['photo_remarks']) ? str_replace("<br>", "", $data['photo_remarks']) : "";
      $additional_remarks = !empty($data['additional_remarks']) ? str_replace("<br>", "", $data['additional_remarks']) : "";

      $mro = $this->Sweetreportmodel->report_order($data['month_monitoring'],$type_of_monitoring_desc);


      $update_sweet_table = array(
        // 'trans_no'                    => $this->encrypt->decode($data['trans_no']),
        // 'region'                      => $this->session->userdata('region'),
        'travel_no'                   => $this->encrypt->decode($data['travel_no']),
        // 'userid'                      => $this->session->userdata('userid'),
        // 'creator_name'                => $user_name,
        'month_monitoring'            => date("F", strtotime($data['month_monitoring'])),
        // 'report_order'                => $mro,
        'subject'                     => $selectinsertcnt[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
        'report_type'                 => $this->encrypt->decode($data['report_status']),
        'date_patrolled'              => $data['date_patrolled'],
        'time_patrolled'              => $data['time_patrolled'],
        'lgu_patrolled_id'            => $this->encrypt->decode($data['lgu_patrolled']),
        'lgu_patrolled_name'          => $lgu_name[0]['company_name'],
        'violations_observed_no'      => $countvo,
        'violations_observed_desc'    => $violations_observed_desc,
        'barangay_id'                 => $this->encrypt->decode($data['barangay']),
        'barangay_name'               => $brgyname[0]['name'],
        'street'                      => $data['street'],
        'latitude'                    => $data['latitude'],
        'longitude'                   => $data['longitude'],
        'type_of_area_no'             => $counttom,
        'type_of_area_desc'           => $type_of_area_desc,
        'if_others_tom'               => !empty($_POST['if_toa_others']) ? $data['if_toa_others'] : '',
        'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
        'type_of_monitoring_desc'     => $type_of_monitoring_desc,
        'date_of_first_monitoring'    => !empty($_POST['dtfm']) ? $data['dtfm'] : $data['date_patrolled'],
        'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
        'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
        'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
        'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
        'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
        'total_land_area'             => $data['ttlarea'],
        'photo_remarks'               => $photo_remarks,
        'additional_remarks'          => $additional_remarks,
        'actions_undertaken_no'       => $countatbu,
        'actions_undertaken_desc'     => $atbu_desc,
        'final_disposal'              => !empty(($data['sw_fdsw'])) ? ($data['sw_fdsw']) : '',
        'fd_location'                 => !empty(($data['sw_location'])) ? ($data['sw_location']) : '',
        'fd_latitude'                 => !empty(($data['sw_latitude'])) ? ($data['sw_latitude']) : '',
        'fd_longitude'                => !empty(($data['sw_longitude'])) ? ($data['sw_longitude']) : '',
        // 'status'                      => "On-Process",
      );

      $trans_update_where = array(
        'trans_no'    => $this->encrypt->decode($data['trans_no']),
      );

      $update_form = $this->Embismodel->updatedata( $update_sweet_table, 'sweet_form', $trans_update_where );

      $update_sweet_table_log = array(
        'travel_no'                   => $this->encrypt->decode($data['travel_no']),
        'month_monitoring'            => date("F", strtotime($data['month_monitoring'])),
        'subject'                     => $selectinsertcnt[0]['report_order'].". ".$route_assigned[0]['usname']." - Month"." of ".date("F", strtotime($data['month_monitoring']))." - ".$type_of_monitoring_desc,
        'report_type'                 => $this->encrypt->decode($data['report_status']),
        'date_patrolled'              => $data['date_patrolled'],
        'time_patrolled'              => $data['time_patrolled'],
        'lgu_patrolled_id'            => $this->encrypt->decode($data['lgu_patrolled']),
        'lgu_patrolled_name'          => $lgu_name[0]['company_name'],
        'violations_observed_no'      => $countvo,
        'violations_observed_desc'    => $violations_observed_desc,
        'barangay_id'                 => $this->encrypt->decode($data['barangay']),
        'barangay_name'               => $brgyname[0]['name'],
        'street'                      => $data['street'],
        'latitude'                    => $data['latitude'],
        'longitude'                   => $data['longitude'],
        'type_of_area_no'             => $counttom,
        'type_of_area_desc'           => $type_of_area_desc,
        'if_others_tom'               => !empty($_POST['if_toa_others']) ? $data['if_toa_others'] : '',
        'type_of_monitoring'          => $this->encrypt->decode($data['type_of_monitoring']),
        'type_of_monitoring_desc'     => $type_of_monitoring_desc,
        'date_of_first_monitoring'    => !empty($_POST['dtfm']) ? $data['dtfm'] : '',
        'date_of_second_monitoring'   => !empty($_POST['dtsm']) ? $data['dtsm'] : '',
        'date_of_last_monitoring'     => !empty($_POST['dtlm']) ? $data['dtlm'] : '',
        'date_of_issuance_of_notice'  => !empty($_POST['dtiln']) ? $data['dtiln'] : '',
        'number_dumping'              => !empty($_POST['nil']) ? $data['nil'] : '',
        'number_activity'             => !empty($_POST['noa']) ? $data['noa'] : '',
        'total_land_area'             => $data['ttlarea'],
        'photo_remarks'               => $photo_remarks,
        'additional_remarks'          => $additional_remarks,
        'actions_undertaken_no'       => $countatbu,
        'actions_undertaken_desc'     => $atbu_desc,
        'final_disposal'              => !empty(($data['sw_fdsw'])) ? ($data['sw_fdsw']) : '',
        'fd_location'                 => !empty(($data['sw_location'])) ? ($data['sw_location']) : '',
        'fd_latitude'                 => !empty(($data['sw_latitude'])) ? ($data['sw_latitude']) : '',
        'fd_longitude'                => !empty(($data['sw_longitude'])) ? ($data['sw_longitude']) : '',
        // 'status'                      => "On-Process",
      );

      $trans_update_where_log = array(
        'trans_no'      => $this->encrypt->decode($data['trans_no']),
        'report_number' => $this->encrypt->decode($data['report_number']),

      );

      $update_form_log = $this->Embismodel->updatedata( $update_sweet_table_log, 'sweet_form_log', $trans_update_where_log );

     //  $set = array(
     //   'et.company_token'      => $lgu_name[0]['token'],
     //   'et.company_name'       => $lgu_name[0]['company_name'],
     //   'et.emb_id'             => $lgu_name[0]['emb_id'],
     //   'et.status'             => "15",
     //   'et.status_description' => "For Approval",
     //   'et.receive'            => 0,
     //   'et.action_taken'       => "Pls. for approval (".$this->encrypt->decode($data['report_status']).")",
     //   'et.remarks'            => "None",
     // );
     //
     // $where = array( 'et.trans_no' => $er_trans_query[0]['trans_no']);
     // $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

       $swal_arr = array(
         'title'     => 'SUCCESS!',
         'text'      => 'Sweet report successfully saved.',
         'type'      => 'success',
       );
       $this->session->set_flashdata('swal_arr', $swal_arr);
      redirect(base_url()."Swm/Sweet");
  }

  function Clearsessionnov(){
    $this->session->unset_userdata('swm_frapprvl');
    $this->session->unset_userdata('iisno');
    $this->session->unset_userdata('iisnoen');
    $this->session->unset_userdata('lguname');
    $this->session->unset_userdata('embid');
    $this->session->unset_userdata('ltrdt');
    $this->session->unset_userdata('prfxltr');
    $this->session->unset_userdata('fnmltr');
    $this->session->unset_userdata('miltr');
    $this->session->unset_userdata('lnltr');
    $this->session->unset_userdata('sfxltr');
    $this->session->unset_userdata('desltr');
    $this->session->unset_userdata('mctyltr');
    $this->session->unset_userdata('brgyname');
    $this->session->unset_userdata('lguprov');
    $this->session->unset_userdata('datemonitored');
    $this->session->unset_userdata('ccon');
    $this->session->unset_userdata('ccoa');
    $this->session->unset_userdata('swrmvl');
    $this->session->unset_userdata('swmoe');
    $this->session->unset_userdata('swmcinf');
    $this->session->unset_userdata('chngvw');
    $this->session->unset_userdata('voconcat');
    redirect(base_url()."Swm/Sweet/DraftNOV");
  }

  function DraftNOV(){

    date_default_timezone_set("Asia/Manila");
    $whereheader  = $this->db->where('oudh.region = "'.$this->session->userdata('region').'" AND oudh.office = "'.$this->session->userdata('office').'" AND oudh.cnt = (SELECT MAX(oudhh.cnt) FROM office_uploads_document_header AS oudhh WHERE oudhh.region = "'.$this->session->userdata('region').'"  AND oudhh.office = "'.$this->session->userdata('office').'")');
        $query['selectheader'] = $this->Embismodel->selectdata('office_uploads_document_header AS oudh','file_name','',$whereheader);

    $whereselectsweetrans = $this->db->where('sf.userid = "'.$this->session->userdata('userid').'" AND er.status != "0" AND sf.report_type = "Unclean" AND sf.type_of_monitoring != "1"');
    $joinselectsweetrans = $this->db->join('er_transactions AS er','er.token = sf.trans_no','left');
    $query['selectsweettrans'] = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.trans_no, sf.month_monitoring, sf.lgu_patrolled_name, sf.type_of_monitoring_desc, sf.cnt, sf.barangay_name, sf.date_patrolled, sf.date_of_first_monitoring, sf.date_of_second_monitoring, sf.date_of_last_monitoring','',$joinselectsweetrans,$whereselectsweetrans);

    $whereswmemail = $this->db->where('soe.region = "'.$this->session->userdata('region').'"');
    $selectswmemail = $this->Embismodel->selectdata('sweet_contact_info AS soe','soe.email, soe.contact_info','',$whereswmemail);

    $whereswmcc = $this->db->where('snc.region = "'.$this->session->userdata('region').'"');
    $selectswmcc = $this->Embismodel->selectdata('sweet_nov_cc AS snc','snc.office_name, snc.office_address','',$whereswmcc);

    $wheretom = $this->db->where('stm.tomid != "" ORDER BY stm.tomorder ASC');
    $query['selecttom'] = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stm','stm.tomid, stm.tomtitle, stm.cat','',$wheretom);

    $sweet_token = $this->Sweetreportmodel->sweet_func_user($this->session->userdata('userid'));

    $explodedata = explode('|',$this->session->userdata('swm_frapprvl'));
    if(!empty($explodedata[0])){
      $wherertdata = $this->db->where('acs.token != "'.$explodedata[0].'"');
    }

    $wherertdata = $this->db->where('sf.token="'.$sweet_token.'" AND sf.region="'.$this->session->userdata('region').'" AND acs.verified = "1" AND af.stat = "1" ORDER BY af.func_order ASC, acs.fname ASC');
    $joinrtdata = $this->db->join('acc_credentials AS acs','acs.userid = sf.assigned_to','left');
    $joinrtdata = $this->db->join('acc_function AS af','af.userid = sf.assigned_to','left');
    $query['queryrouteto'] = $this->Embismodel->selectdata('sweet_func AS sf','acs.userid, acs.token, acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, af.func','',$joinrtdata,$wherertdata);

    $query['iisno'] = (!empty($this->session->userdata('iisno'))) ? $this->session->userdata('iisno') : '';
    $query['iisnoen'] = (!empty($this->session->userdata('iisnoen'))) ? $this->session->userdata('iisnoen') : '';
    $query['iisnoselectize'] = (!empty($this->session->userdata('iisno'))) ? $this->session->userdata('iisno').' - '.$this->session->userdata('lguname') : '';
    $query['embid'] = (!empty($this->session->userdata('embid'))) ? $this->session->userdata('embid') : '';
    $query['ltrdt'] = (!empty($this->session->userdata('ltrdt'))) ? $this->session->userdata('ltrdt') : date("F d, Y");
    $query['prfxltr'] = (!empty($this->session->userdata('prfxltr'))) ? $this->session->userdata('prfxltr') : '___';
    $query['fnmltr'] = (!empty($this->session->userdata('fnmltr'))) ? $this->session->userdata('fnmltr') : '___';
    $query['miltr'] = (!empty($this->session->userdata('miltr'))) ? $this->session->userdata('miltr') : '';
    $query['lnltr'] = (!empty($this->session->userdata('lnltr'))) ? $this->session->userdata('lnltr') : '___';
    $query['sfxltr'] = (!empty($this->session->userdata('sfxltr'))) ? $this->session->userdata('sfxltr') : '';
    $query['desltr'] = (!empty($this->session->userdata('desltr'))) ? $this->session->userdata('desltr') : '_________';
    $query['mctyltr'] = (!empty($this->session->userdata('mctyltr'))) ? $this->session->userdata('mctyltr') : '_________';
    $query['brgyname'] = (!empty($this->session->userdata('brgyname'))) ? $this->session->userdata('brgyname') : '_________';
    $query['lguprov'] = (!empty($this->session->userdata('lguprov'))) ? $this->session->userdata('lguprov') : '_________';
    $query['datemonitored'] = (!empty($this->session->userdata('datemonitored'))) ? $this->session->userdata('datemonitored') : '_________';
    $query['ccon'] = (!empty($this->session->userdata('ccon'))) ? $this->session->userdata('ccon') : $selectswmcc[0]['office_name'];
    $query['ccoa'] = (!empty($this->session->userdata('ccoa'))) ? $this->session->userdata('ccoa') : $selectswmcc[0]['office_address'];
    $query['swrmvl'] = (!empty($this->session->userdata('swrmvl'))) ? $this->session->userdata('swrmvl') : 'two (2) weeks on or before '.date('F d, Y');
    $query['swmemail'] = (!empty($this->session->userdata('swmoe'))) ? $this->session->userdata('swmoe') : $selectswmemail[0]['email'];
    $query['swmcontactinfo'] = (!empty($this->session->userdata('swmcinf'))) ? $this->session->userdata('swmcinf') : $selectswmemail[0]['contact_info'];
    $query['chngvwf'] = (!empty($this->session->userdata('chngvw')) AND $this->session->userdata('chngvw') == '1') ? 'display:block;' : (empty($this->session->userdata('chngvw')) ? 'display:block;' : 'display:none;');
    $query['chngvws'] = (!empty($this->session->userdata('chngvw')) AND $this->session->userdata('chngvw') == '2') ? 'display:block;' : 'display:none;';
    if(!empty($this->session->userdata('voconcat'))){
      $explodedvo = explode(';',trim($this->session->userdata('voconcat')));

      $orderby = $this->db->order_by('svo.voorder ASC');
      for ($i=0; $i < count($explodedvo); $i++) {
        if(!empty($explodedvo[$i])){
          $wherevo = $this->db->or_where('svo.section = "'.$explodedvo[$i].'"');
        }
      }
      $query['vo'] = $this->Embismodel->selectdata('sweet_violations_observed AS svo','svo.prohibited_act, svo.section','',$wherevo);
    }

    if(!empty($this->session->userdata('iisnoen'))){
      $tkn = explode('|',$this->encrypt->decode($this->session->userdata('iisnoen')));
      $tokenvo = $tkn[0];
      $cntvo = $tkn[1];
    }else{
      $tokenvo = '';
      $cntvo = '';
    }

    $wheredatavo = $this->db->where('sf.trans_no = "'.$tokenvo.'" AND sf.cnt = "'.$cntvo.'"');
    $joindatavo = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no AND sfa.report_number = sf.report_number','left');
    $query['selectdatavo'] = $this->Embismodel->selectdata('sweet_form_log AS sf','sfa.attachment_name, sf.region, sf.date_created, sf.photo_remarks, sf.report_number, sf.type_of_monitoring, sf.date_of_first_monitoring, sf.date_of_second_monitoring, sf.date_of_last_monitoring, sf.date_of_issuance_of_notice, sf.number_dumping, sf.number_activity',$joindatavo,$wheredatavo);

    if($query['selectdatavo'][0]['report_number'] >= '2'){
      $reportnumberdata = ($query['selectdatavo'][0]['report_number']-1);
      $whereprevdata = $this->db->where('sf.trans_no = "'.$tokenvo.'" AND sf.report_number = "'.$reportnumberdata.'" AND sfa.report_number = "'.$reportnumberdata.'"');
      $joinprevdata = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no','left');
      $selectprevdata = $this->Embismodel->selectdata('sweet_form_log AS sf','sfa.attachment_name, sf.region, sf.date_created, sf.photo_remarks, sf.report_number',$joinprevdata,$whereprevdata);

      $query['photo_remarks_left'] = $selectprevdata[0]['photo_remarks'];
      $query['attachmentleft'] = "https://iis.emb.gov.ph/iis-images/sweet_report/".date('Y', strtotime($selectprevdata[0]['date_created']))."/".$selectprevdata[0]['region']."/".$tokenvo."/".$selectprevdata[0]['attachment_name'];
    }

    $query['photo_remarks_right'] = $query['selectdatavo'][0]['photo_remarks'];
    $query['attachmentright'] = "https://iis.emb.gov.ph/iis-images/sweet_report/".date('Y', strtotime($query['selectdatavo'][0]['date_created']))."/".$query['selectdatavo'][0]['region']."/".$tokenvo."/".$query['selectdatavo'][0]['attachment_name'];

    $wherenovrd = $this->db->where('af.region = "'.$this->session->userdata('region').'" AND af.func = "Regional Director" AND af.stat = "1" AND acs.verified = "1"');
    $joinnovrd = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
    $querynov_rd = $this->Embismodel->selectdata('acc_function AS af','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, acs.designation','',$joinnovrd,$wherenovrd);
    $rdnovtitle = (!empty($querynov_rd[0]['title'])) ? $querynov_rd[0]['title']." " : "";
    $rdnovmname = (!empty($querynov_rd[0]['mname'])) ? $querynov_rd[0]['mname'][0]." " : "";
    $rdnovsuffix = (!empty($querynov_rd[0]['suffix'])) ? " ".$querynov_rd[0]['suffix'] : "";
    $query['rdnovname'] = strtoupper($rdnovtitle.$querynov_rd[0]['fname']." ".$rdnovmname.$querynov_rd[0]['sname']).$rdnovsuffix;
    $query['rdnovdesignation'] = $querynov_rd[0]['designation'];

    $this->load->view('swm/draftnov',$query);
  }

  function removenov(){

    ?>
      <div class="modal-body">
          <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure to remove this NOV letter?</h6></center>
      </div>
      <div class="modal-footer">
        <a href="<?php echo base_url(); ?>Swm/Sweet/removenovpost/<?php echo $_POST['cnt']; ?>" style="float:left;" class="btn btn-success btn-sm">Confirm</a>
      </div>
    <?php
  }
  function removenovpost($tokenget){
    if(!empty($tokenget)){
      $where = array('cnt' => $tokenget, );
      $set = array('status' => 'Removed', );
      $updatedata = $this->Embismodel->updatedata($set, 'sweet_nov_letter', $where);
      if($updatedata){
        $swal_arr = array(
           'title'     => 'SUCCESS!',
           'text'      => 'NOV letter successfully removed.',
           'type'      => 'success',
         );
         $this->session->set_flashdata('swal_arr', $swal_arr);
        redirect(base_url()."Swm/Sweet");
      }
    }else{
      $swal_arr = array(
         'title'     => 'Error!',
         'text'      => 'NOV letter failed to remove.',
         'type'      => 'error',
       );
       $this->session->set_flashdata('swal_arr', $swal_arr);
      redirect(base_url()."Swm/Sweet");
    }
  }

  function Sweetmap(){
    $token = (!empty($_GET['token'])) ? $this->encrypt->decode($_GET['token']) : '';
    if(!empty($token)){
      $wheredata = $this->db->where('sf.trans_no = "'.$token.'"');
    }
    if($this->session->userdata('superadmin_rights') == 'yes'){
      $wheredata = $this->db->where('et.status != "0" AND sf.status = "Signed Document"');
    }else if($this->session->userdata('divno') == '13'){
      $wheredata = $this->db->where('et.status != "0" AND sf.status = "Signed Document"');
    }else{
      $wheredata = $this->db->where('et.region = "'.$this->session->userdata('region').'" AND et.status != "0" AND sf.status = "Signed Document"');
    }
    $joindata = $this->db->join('er_transactions AS et','et.token = sf.trans_no','left');
    $joindata = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no AND sfa.report_number = sf.report_number','left');
    $queryselect['data'] = $this->Embismodel->selectdata('sweet_form AS sf','sf.creator_name, sf.report_type, sf.date_created, sf.region, sfa.attachment_name, sf.trans_no, sf.latitude, sf.longitude, sf.cnt, sf.lgu_patrolled_id, sf.lgu_patrolled_name, sf.barangay_name, sf.street, sf.type_of_area_desc','',$joindata,$wheredata);
    // echo $this->db->last_query(); exit;
    $this->load->view('swm/sweetmap',$queryselect);
  }

  function Sweetmapall(){
    $token = (!empty($_GET['token'])) ? $this->encrypt->decode($_GET['token']) : '';
    if(!empty($token)){
      $wheredata = $this->db->where('sf.trans_no = "'.$token.'"');
    }
    if($this->session->userdata('superadmin_rights') == 'yes'){
      $wheredata = $this->db->where('et.status != "0" AND sf.status = "Signed Document"');
    }else{
      $wheredata = $this->db->where('et.status != "0" AND sf.status = "Signed Document"');
    }
    $joindata = $this->db->join('er_transactions AS et','et.token = sf.trans_no','left');
    $joindata = $this->db->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no AND sfa.report_number = sf.report_number','left');
    $queryselect['data'] = $this->Embismodel->selectdata('sweet_form AS sf','sf.creator_name, sf.report_type, sf.date_created, sf.region, sfa.attachment_name, sf.trans_no, sf.latitude, sf.longitude, sf.cnt, sf.lgu_patrolled_id, sf.lgu_patrolled_name, sf.barangay_name, sf.street, sf.type_of_area_desc','',$joindata,$wheredata);
    // echo $this->db->last_query(); exit;
    $this->load->view('swm/sweetmap',$queryselect);
  }

  function swmnoto(){
    $noto = $this->encrypt->decode($_POST['noto']);
    if($noto == 'NTOR'){
      ?>
        <label>Please provide method of inspection below:</label>
        <textarea name="inspectionmethod" cols="40" class="form-control"><?php echo set_value('inspectionmethod'); ?></textarea>
      <?php
    }
  }
}
