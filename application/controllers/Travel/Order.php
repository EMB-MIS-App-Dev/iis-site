<?php

class Order extends CI_Controller
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

    if(empty($this->session->userdata('userid'))){ echo "<script>alert('Please login. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; }

    $token = $this->encrypt->decode($this->input->get('token'));

    $where = $this->db->where('tt.token',$token);
    $join  = $this->db->join('acc_credentials AS acs','acs.userid = tt.userid','left');
    $join  = $this->db->join('acc_xdvsion AS xn','xn.divno = tt.divno','left');
    $join  = $this->db->join('acc_xsect AS xt','xt.secno = tt.secno','left');
    $join  = $this->db->join('acc_plantillapostn AS pn','pn.planpstn_id = tt.plantilla_pos','left');
    $query = $this->Embismodel->selectdata('to_trans AS tt','*,acs.fname,acs.mname,acs.sname,acs.suffix,xn.divname,xt.sect,pn.planpstn_desc','',$where);

    if(empty($query[0]['toid'])){ echo "<script>alert('Please re-login. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."Index/logout_user'</script>"; }

    if(!empty($query[0]['mname'])){ $mname = $query[0]['mname'][0].". "; }else{ $mname = ""; }
    if(!empty($query[0]['suffix'])){ $suffix = " ".$query[0]['suffix']; }else{ $suffix = ""; }
    $name = ucwords($query[0]['fname']." ".$mname.$query[0]['sname'].$suffix);

    if(!empty($query[0]['divcode'])){ $divcode = ucwords($query[0]['divcode']); }else{ $divcode = "N/A"; }
    if(!empty($query[0]['sect'])){ $sect = ucwords($query[0]['sect']); }else{ $sect = "N/A"; }

    if(!empty($query[0]['planpstn_desc'])){
      if($query[0]['plantilla_itemno'] == 'Chief' || $query[0]['plantilla_itemno'] == 'Supervising'){
        if(!empty($query[0]['plantilla_itemno'])){
            $plantilla_itemno = $query[0]['plantilla_itemno']." ";  }else{ $plantilla_itemno = ""; }
            $position         = $plantilla_itemno.$query[0]['planpstn_desc'];
      }else{
          if(!empty($query[0]['plantilla_itemno'])){
            $plantilla_itemno = " ".$query[0]['plantilla_itemno'];  }else{ $plantilla_itemno = ""; }
            $position         = $query[0]['planpstn_desc'].$plantilla_itemno;
      }
    }else{
      $position = $query[0]['designation'];
    }

    $wheredest = $this->db->where('td.er_no',$query[0]['er_no']);
    $querydest = $this->Embismodel->selectdata('to_destination AS td','*','',$wheredest);

    $destination = "";
    for($i=0; $i<sizeof($querydest); $i++){
        if(sizeof($querydest) === $i+1){ $con = ""; }else{ $con = ", "; }
        $destination .= $querydest[$i]['location'].$con;
    }

    if(!empty($query[0]['per_diem'])){ $per_diem = ucwords($query[0]['per_diem']); }else{ $per_diem = "N/A"; }
    if(!empty($query[0]['assistant'])){ $assistant = ucwords($query[0]['assistant']); }else{ $assistant = "N/A"; }

    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 5, 10, 0);

    $pdf->SetCreator(PDF_CREATOR);

    // Add a page
    $pdf->AddPage();

    if($query[0]['travel_type'] == 'Land'){
      $html =
      '
        <img class="head" src="'.base_url().'/uploads/templates/headCO.gif">
        <br><br>
        <table style="width:100%;font-family:times;text-align:center;">
          <tr style="font-weight:bold;font-size:13px;">
            <td>TRAVEL ORDER</td>
          </tr>
          <tr>
            <td style="font-size:12px;">('.$query[0]['toid'].')</td>
          </tr>
        </table>
        <br><br><br>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Name</td>
            <td style="width:2%;">:</td>
            <td style="width:43%;font-weight:bold;">'.$name.'</td>
            <td style="width:15%;">Section</td>
            <td style="width:2%;">:</td>
            <td style="width:22%;font-weight:bold;">'.$sect.'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Position</td>
            <td style="width:2%;">:</td>
            <td style="width:43%;font-weight:bold;">'.$position.'</td>
            <td style="width:15%;">Division</td>
            <td style="width:2%;">:</td>
            <td style="width:22%;font-weight:bold;">'.$divcode.'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Departure Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['departure_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Arrival Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['arrival_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Official Station</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$query[0]['official_station'].'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Destination</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$destination.'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;font-weight:bold;">Purpose of Travel</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:98%;"><br></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:98%;height:85px;text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$query[0]['travel_purpose'].'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:30%;">Per diems/Expenses Allowed</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$per_diem.'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:30%;">Assistant or Laborers Allowed</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$assistant.'</td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;font-weight:bold;">Appropriations to which travel should be charge</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:30%;">Remarks of Special Instruction</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$query[0]['remarks'].'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:30%;">Date of Submission</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['report_submission'])).'</td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;font-weight:bold;">Certification:</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:98%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that the travel is necessary and is connected with the functions of the official/Employee and this Division/Section/Unit.</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;">Approved:</td>
          </tr>
        </table>
        <br>
        <table>
          <tr>
            <td style="text-align:center;top:100%;"><img class="head" src="'.base_url().'/uploads/templates/directoresig.PNG" style="width:150px;"></td>
            <td style="text-align:center;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$query[0]['toid'].'%2F&choe=UTF-8" style="width:100px;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
          <tr style="font-size:8px;text-align:justify;font-weight:bold;">
            <td style="width:98%;">Subject to the condition that (1)official/employee concerned has no outstanding cash advance on previous travel, (2)he/she shall settle the cash advance that may be given him/her present hereto within thirty (30) Days after date of return to permanent station and, (3)other applicable provisions of COA Circular N0.96-004,dated April 19,1996.</td>
          </tr>
        </table>
      ';
    }else if($query[0]['travel_type'] == 'Air'){
      $html =
      '
        <img class="head" src="'.base_url().'/uploads/templates/headCO.gif">
        <br>
        <table style="width:100%;font-family:times;text-align:center;">
          <tr style="font-weight:bold;font-size:13px;">
            <td>TRAVEL ORDER</td>
          </tr>
          <tr>
            <td style="font-size:12px;">('.$query[0]['toid'].')</td>
          </tr>
        </table>
        <br><br>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:100%;">To: <b><u>Engr. William P. Cunado</u></b>, <i><b>Office of the Director.</b></i></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:100%;text-align:center;">You are hereby directed to travel on Official Business via <b><u>Philippine Airlines</u></b>.</td>
          </tr>
        </table>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Official Station</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$query[0]['official_station'].'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Destination</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$destination.'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['departure_date']))." - ".date("M d, Y", strtotime($query[0]['arrival_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Purpose</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.ucfirst($query[0]['travel_purpose']).'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;"></td>
            <td style="width:50%;text-align:center;">It is understood that a report shall be submitted upon</td>
            <td style="width:35%;"></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:15%;"></td>
            <td style="width:50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;completion of this travel.</td>
            <td style="width:35%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved by:</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:15%;"></td>
            <td style="width:50%;"></td>
            <td style="text-align:right;"><img class="head" src="'.base_url().'/uploads/templates/directoresig2.PNG" style="width:150px;"></td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>

        <table style="font-family:times;">
          <tr style="font-weight:bold;font-size:13px;text-align:center;line-height:200%;">
            <td>TRANSPORTATION ORDER</td>
          </tr>
        </table>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['departure_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">To</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">Philippine Airlines Ticket Office</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;"></td>
            <td style="width:2%;"></td>
            <td style="width:82%;">Please issue plane ticket to:&nbsp;&nbsp;<u style="font-weight:bold;">Engr. William P. Cunado</u></td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;"></td>
            <td style="width:2%;"></td>
            <td style="width:82%;">in the amount of <u style="font-weight:bold;">Eight Million Eight Hundred Eighty Eight Thousand Eight Hundred Eighty Eight pesos only</u> chargeable against <u style="font-weight:bold;">EMB FUNDS</u>. </td>
          </tr>
          <tr>
            <td style="width:100%;"><br></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:100%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved by:</td>
          </tr>
          <tr>
            <td style="text-align:right;"><img class="head" src="'.base_url().'/uploads/templates/directoresig2.PNG" style="width:150px;"></td>
          </tr>

          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:100%;"><br></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:100%;">IN CASE OF CREDIT: Certification as to Availability of Funds</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:60%;"></td>
            <td style="width:40%;border-bottom-width: 1px;"><b style="text-align:center;">Stephen Roie Lee</b></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:60%;"></td>
            <td style="width:40%;"><span style="text-align:center;">Chief Accountant</span></td>
          </tr>

        </table>

        <table style="font-family:times;">
          <tr style="font-weight:bold;font-size:13px;text-align:center;line-height:200%;">
            <td><u>AUTHORIZATION</u></td>
          </tr>
        </table>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td>I hereby authorized the Chief Accountant to deduct the corresponding amount of the unliquidated cash advance from my succeeding salary for my failure to liquidate this travel within the prescribed thirty-day (30) period upon return to my permanent station pursuant to Item 5.1.2 COA Circular 97-002 dated February 10, 1997 and Sec. 16 EO No. 246 dated May 29, 1995. </td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:100%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved by:</td>
          </tr>
          <tr>
            <td style="text-align:right;"><img class="head" src="'.base_url().'/uploads/templates/directoresig2.PNG" style="width:150px;"></td>
          </tr>
        </table>

      ';
    }

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output();
  }

  function travel_new_trans(){
    $this->session->unset_userdata('toattachmentchecker');
    date_default_timezone_set("Asia/Manila");
    $region          = $this->session->userdata('region');
    $sender_id       = $this->session->userdata('token');

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
      'start_date'  => $start_date,
    );
    $this->Embismodel->insertdata('er_transactions', $trans_insert);

    $this->session->set_userdata('travel_trans_no', $trans_no);
    $this->session->set_userdata('travel_trans_no_token', $trans_token);

    redirect(base_url().'Travel/Order/form');
  }

  function form(){
      $region      = $this->session->userdata('region');
      $trans_no    = $this->session->userdata('travel_trans_no');
      $trans_token = $this->session->userdata('travel_trans_no_token');

      $this->load->view('includes/common/header');
      $this->load->view('includes/common/sidebar');
      $this->load->view('includes/common/nav');
      $this->load->view('includes/common/footer');
      $this->load->library('user_agent');

      $data['browser'] = $this->agent->browser();

      $route_order_max = $this->Travelordermodel->route_order_max();

      $routeto            = "";
      $assignedto         = "";
      $data['assignedto'] = $assignedto;
      $data['routeto']    = $routeto;

      if(!empty($route_order_max[0]['assigned_to']) AND $route_order_max[0]['assigned_to'] != $this->session->userdata('userid')){
        $routeto = $route_order_max[0]['assigned_to'];
      }else{
        $routeto = "";
      }

        $where = $this->db->where('acs.userid',$routeto);
        $query = $this->Embismodel->selectdata('acc_credentials AS acs','*','',$where);

        if(!empty($query[0]['mname'])){  $mname  = $query[0]['mname'][0].". "; }else{ $mname = ""; }
        if(!empty($query[0]['suffix'])){ $suffix = " ".$query[0]['suffix'];  }else{ $suffix = ""; }
        $assignedto = ucwords($query[0]['fname']." ".$mname.$query[0]['sname'].$suffix);

        $data['assignedto'] = $assignedto;
        $data['routeto']    = $routeto;

      $orderbycomp          = $this->db->order_by('comp.company_name','ASC');
      $wherecomp            = $this->db->where('comp.deleted !=','1');
      $data['companylist']  = $this->Embismodel->selectdata('dms_company AS comp','comp.company_name,comp.company_id','',$wherecomp,$orderbycomp);

      $orderbytolaborers    = $this->db->order_by('acs.fname','ASC');
      $wheretolaborers      = $this->db->where('ar.to_assistant_or_laborers','yes');
      $wheretolaborers      = $this->db->where('ar.region',$region);
      $jointolaborers       = $this->db->join('acc_credentials AS acs','acs.userid = ar.userid','left');
      $data['laborers']     = $this->Embismodel->selectdata('acc_rights AS ar','ar.to_assistant_or_laborers,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix','',$jointolaborers,$wheretolaborers,$orderbytolaborers);

      $where           = $this->db->where('ts.region',$region);
      $offstationdata  = $this->Embismodel->selectdata('to_set_official_station AS ts','*','',$where);
      if(!empty($offstationdata[0]['dsc'])){ $offstat = $offstationdata[0]['dsc']; }
      else{
        $likeemb    = $this->db->like('company_name','Environmental Management Bureau');
        if($region == 'CO'){
          $whereemb   = $this->db->where('dc.emb_id','EMBNCR-1053620-0001');
        }else{
          $whereemb   = $this->db->where('dc.region_name',$region);
        }
        $queryemb   = $this->Embismodel->selectdata('dms_company AS dc','dc.token,dc.company_name,dc.emb_id','',$whereemb,$likeemb);

        if(!empty($queryemb[0]['company_name'])){
          $offstat = $queryemb[0]['company_name'];
        }else{
          $offstat = "";
        }

      }
      $data['official_station'] = $offstat;

      $this->load->view('travelorder/form',$data);
    }

  function process_travel(){
    date_default_timezone_set("Asia/Manila");
    //TRAVEL DETAILS
    $trans_no    = $this->input->post('token');
    $region      = $this->session->userdata('region');
    $where       = $this->db->where('tt.er_no',$trans_no);
    $qryaccounts = $this->Embismodel->selectdata('to_trans AS tt','*','',$where);
    $travelcat = ($qryaccounts[0]['travel_cat'] == 'Yes') ? 'Regional' : 'National';

    $wheretrans       = $this->db->where('et.trans_no',$trans_no);
    $qrytrans = $this->Embismodel->selectdata('er_transactions AS et','et.status','',$wheretrans);

    if($qrytrans[0]['status'] == '24'){
      echo "<script>alert('This account already given an action to this transaction.')</script>";
      echo "<script>window.location.href='".base_url()."Dms/Dms/inbox'</script>";
      exit;
    }

    if($qryaccounts[0]['assignedto'] != $this->session->userdata('userid')){
      echo "<script>alert('This account already given an action to this transaction.')</script>";
      echo "<script>window.location.href='".base_url()."Dms/Dms/inbox'</script>";
      exit;
    }

    $wheredest   = $this->db->where('td.er_no',$trans_no);
    $qrydest     = $this->Embismodel->selectdata('to_destination AS td','*','',$wheredest);

    //TRAVEL DETAILS

    if($qryaccounts[0]['er_no'] != $trans_no){
      echo "<script>window.location.href='".base_url()."'</script>";
    }else{
      $this->session->set_userdata('process_trans_no_travel', $trans_no);
    }

    //FUNCTION
    $wherehead   = $this->db->where('af.userid',$qryaccounts[0]['userid']);
    $wherehead   = $this->db->where('af.stat','1');
    $qryhead     = $this->Embismodel->selectdata('acc_function AS af','af.func,af.userid','',$wherehead);
    //FUNCTION

    //IF DISAPPROVED
    $whereaction  = $this->db->where('et.trans_no',$trans_no);
    $queryaction  = $this->Embismodel->selectdata('er_transactions AS et','et.action_taken,et.status,et.token','',$whereaction);
    //IF DISAPPROVED

      $routedtoname = "";

      $route_order    = $this->db->query("SELECT tt.route_order,tt.assignedto FROM embis.to_trans AS tt WHERE tt.er_no = '$trans_no'")->result_array();
      if($route_order[0]['route_order'] <= '1'){ $route_order_no = '1'; }else{ $route_order_no = $route_order[0]['route_order']-1; }

      $whereroutename  = $this->db->where('tf.route_order',$route_order_no);
      $whereroutename  = $this->db->where('tf.assigned_to',$route_order[0]['assignedto']);
      $queryroutename  = $this->Embismodel->selectdata('to_func AS tf','tf.assigned_to, tf.route_order','',$whereroutename);

      //Routed to
      $whereroute   = $this->db->where('acs.userid',$queryroutename[0]['assigned_to']);
      $routedto     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.fname,acs.mname,acs.sname,acs.suffix','',$whereroute);
      if(!empty($routedto[0]['mname'])){  $mname = $routedto[0]['mname'][0].". "; }else{ $mname = ""; }
      if(!empty($routedto[0]['suffix'])){ $suffix = " ".$routedto[0]['suffix'];   }else{ $suffix = ""; }
      $routedtoname = ucwords($routedto[0]['fname']." ".$mname.$routedto[0]['sname'].$suffix);

      $trans_no = $qryaccounts[0]['er_no'];
      $whereattachments  = $this->db->where('ea.trans_no',$trans_no);
      $trans_attachments = $this->Embismodel->selectdata('er_attachments AS ea','ea.*','',$whereattachments);

      $wheretime = $this->db->where('etl.trans_no = "'.$trans_no.'" AND etl.route_order = (SELECT MIN(route_order) FROM er_transactions_log AS etl WHERE etl.trans_no = "'.$trans_no.'")');
      $querytime = $this->Embismodel->selectdata('er_transactions_log AS etl','etl.date_in','',$wheretime);

      $whereheader  = $this->db->where('oudh.region = "'.$this->session->userdata('region').'" AND oudh.office = "'.$this->session->userdata('office').'" AND oudh.cnt = (SELECT MAX(oudhh.cnt) FROM office_uploads_document_header AS oudhh WHERE oudhh.region = "'.$this->session->userdata('region').'" AND oudhh.office = "'.$this->session->userdata('office').'")');
      $selectheader = $this->Embismodel->selectdata('office_uploads_document_header AS oudh','oudh.file_name','',$whereheader);
    ?>

    <style type="text/css">
      #form-style{
        margin-top:5px;
      }
    </style>
    <?php if($queryaction[0]['status'] == '6'){ ?>
    <form class="" action="<?php echo base_url(); ?>Travel/Submitform/travel_acknowledgement" method="post">
    <?php }else{ ?>
    <form class="" action="<?php echo base_url(); ?>Travel/Submitform/process_travel" method="post">
    <?php } ?>
      <div class="modal-body">
        <div class="row">
          <?php if(!empty($selectheader[0]['file_name'])){ ?>
            <div class="col-md-12">
              <label>IIS No.:</label>
              <input type="text" class="form-control" value="<?php echo $queryaction[0]['token']; ?>" readonly>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-6">
              <label>Name:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['name']; ?>" readonly>
            </div>
            <div class="col-md-6">
              <label>Designation:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['designation']; ?>" readonly>
            </div>
            <div class="col-md-6" id="form-style">
              <label>Travel Category:</label>
              <input type="text" class="form-control" value="<?php echo $travelcat; ?>" readonly>
            </div>
            <div class="col-md-6" id="form-style">
              <label>Travel Type:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['travel_type']; ?>" readonly>
            </div>
            <div class="col-md-12" id="form-style">
              <label>Date Applied:</label>
              <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($querytime[0]['date_in'])); ?>" readonly>
            </div>
            <div class="col-md-6" id="form-style">
              <label>Date of Departure:</label>
              <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($qryaccounts[0]['departure_date'])); ?>" readonly>
            </div>
            <div class="col-md-6" id="form-style">
              <label>Arrival Date:</label>
              <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($qryaccounts[0]['arrival_date'])); ?>" readonly>
            </div>
            <div class="col-md-12" id="form-style">
              <label>Official Station:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['official_station']; ?>" readonly>
            </div>

            <?php
              $destination = "";
              for($i=0; $i<sizeof($qrydest); $i++){
                if(sizeof($qrydest) === $i+1){ $con = ""; }else{ $con = ", "; }
                $destination .= $qrydest[$i]['location'].$con;
            } ?>

            <div class="col-md-12" id="form-style">
              <label>Destination:</label>
              <input type="text" class="form-control" value="<?php echo ucwords($destination); ?>" readonly>
            </div>
            <div class="col-md-12" id="form-style">
              <label>Purpose of Travel:</label>
              <textarea class="form-control" readonly><?php echo $qryaccounts[0]['travel_purpose']; ?></textarea>
            </div>
            <div class="col-md-6" id="form-style">
              <label>Per Diems/ Expenses Allowed:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['per_diem']; ?>" readonly>
            </div>
            <div class="col-md-6" id="form-style">
              <label>Assistant or laborers Allowed:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['assistant']; ?>" readonly>
            </div>
            <div class="col-md-4" id="form-style">
              <label>Remarks of Special Instruction:</label>
              <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['remarks']; ?>" readonly>
            </div>
            <div class="col-md-4" id="form-style">
              <label>Date of Report Submission:</label>
              <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($qryaccounts[0]['report_submission'])); ?>" readonly>
            </div>
            <div class="col-md-4" id="form-style">
              <label id="viewtitle">Attachment</label>
              <?php if($trans_attachments[0]['trans_no'] != ''){ ?>
               <div class="dropdown">
                <a style="width:100%;" class="btn btn-info btn-sm dropdown-toggle" href="#" role="button" id="dropdownTravelAttachment" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 View Attachment
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownTravelAttachment" style="width:100%;">
                    <?php for ($i=0; $i < sizeof($trans_attachments) ; $i++) {
                      $att_name = str_replace(' ', '_', trim($trans_attachments[$i]['file_name']));
                      $att = $trans_attachments[$i]['token'];
                      $att = "<a style='text-align:center;' class='dropdown-item' title='".$att_name."' href='".base_url('uploads/dms/'.date('Y').'/'.$qryaccounts[0]['region'].'/'.$trans_no.'/'.$trans_attachments[$i]['token'].'.'.pathinfo($att_name, PATHINFO_EXTENSION))."' target='_blank'>".$trans_attachments[$i]['token']."</a>";
                      echo $att;
                      }
                    ?>
                </div>
              </div>
              <?php }else{ ?>
                <input style="width:100%;" type="text" class="btn btn-danger btn-sm" value="No Attached File" disabled>
              <?php } ?>
            </div>
            <?php if($queryaction[0]['status'] == '6'){ ?>
            <div class="col-md-12"><hr></div>
            <div class="col-md-12" id="form-style">
              <label>Disapproval Remarks:</label>
              <textarea class="form-control" disabled=""><?php echo $queryaction[0]['action_taken']; ?></textarea>
            </div>
            <?php } ?>
          </div>
        <?php }else{ ?>
          <div class="col-md-12">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">No document header detected. Please contact EMB - MIS. Thank you!</h6></center>
          </div>
        <?php } ?>
      </div>

      <div class="modal-footer">
        <?php if(!empty($selectheader[0]['file_name'])){ ?>
          <?php if($queryaction[0]['status'] == '6'){ ?>
            <button type="submit" class="btn btn-success btn-sm">Acknowledge</button>
          <?php }else{ ?>
            <button type="button" onclick="disapprove(<?php echo $trans_no; ?>);" class="btn btn-danger btn-sm">Disapprove</button>
            <button type="submit" class="btn btn-success btn-sm">Approve</button>
          <?php } ?>
        <?php }else{ ?>
          <button type="button" class="btn btn-danger btn-sm" disabled>Disapprove</button>
          <button type="button" class="btn btn-success btn-sm" disabled>Approve</button>
        <?php } ?>

      </div>
    </form>

  <?php
  }

  function disapprove_travel(){

    //TRAVEL DETAILS
    $trans_no    = $this->input->post('token');
    $region      = $this->session->userdata('region');

    ?>

    <style type="text/css">
      #form-style{
        margin-top:5px;
      }
    </style>

  <form class="" action="<?php echo base_url(); ?>Travel/Submitform/process_travel" method="post">
    <div class="modal-body">
      <div class="row">
          <div class="col-md-12">
            <label>Are you sure to disapprove this travel application? Please provide reason below.</label>
            <textarea class="form-control" name="disapproval_reason" required=""></textarea>
          </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" onclick="process_travel(<?php echo $trans_no; ?>);" class="btn btn-danger btn-sm">Back</button>
      <button type="submit" class="btn btn-success btn-sm">Confirm</button>
    </div>
  </form>

  <?php
  }

  function coordinates_lat(){
    error_reporting(0);
    $comp_id      = trim($this->input->post('value', TRUE));
    $latitude = "";
    // echo $comp_id;
    $region       = $this->session->userdata('region');
    $select       = $this->db->query('SELECT latitude, barangay_name, city_name, province_name FROM dms_company WHERE company_name LIKE "%'.$comp_id.'%"')->result_array();
      if(!empty($select[0]['latitude']) AND $select[0]['latitude'] != 0){
        $latitude = $select[0]['latitude'];
      }else{
        if(!empty($select[0]['barangay_name'])){ $barangay_name = $select[0]['barangay_name']." "; }else{ $barangay_name = ""; }
        if(!empty($select[0]['city_name'])){ $city_name = $select[0]['city_name']." "; }else{ $city_name = ""; }
        if(!empty($select[0]['province_name'])){ $province_name = $select[0]['province_name']; }else{ $province_name = ""; }
        $addrs = $barangay_name.$city_name.$province_name;

        // Get lat and long by address
          $address = $comp_id." ".$addrs; // Google HQ
          $prepAddr = str_replace(' ','+',$address);
          // echo $prepAddr;
          $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');
          $output= json_decode($geocode);

          $latitude = $output->results[0]->geometry->location->lat;
      }
      //echo $this->db->last_query(); exit;


    ?>

      <label>Latitude: <span id="requiredto">(required)</span></label>
      <a class="btn btn-sm btn-info" href="https://www.google.com/maps/search/<?php echo $comp_id." ".$addrs; ?>" target="_blank" style="float:right;font-size:7pt;margin-right:15px;color:#FFF;" title="Locate destination to get latitude and longitude"><span class="fa fa-map-marker"></span> Check Geo Coordinates</a>
      <input type="text"  name="latitude[]" class="form-control" value="<?php echo $latitude; ?>" required="" minlength="5">

  <?php
  }

  function coordinates_lat_input(){
    error_reporting(0);
    $destination      = trim($this->input->post('value', TRUE));
    // Get lat and long by address
    $address = $destination; // Google HQ
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');
    $output= json_decode($geocode);

    $latitude = $output->results[0]->geometry->location->lat;

  ?>

      <label>Latitude: <span id="requiredto">(required)</span></label>
      <a class="btn btn-sm btn-info" href="https://www.google.com/maps/search/<?php echo $destination; ?>" target="_blank" style="float:right;font-size:7pt;margin-right:15px;color:#FFF;" title="Locate destination to get latitude and longitude"><span class="fa fa-map-marker"></span> Check Geo Coordinates</a>
      <input type="text"  name="latitude[]" class="form-control" value="<?php echo $latitude; ?>" required="" minlength="5">

  <?php
  }

  function coordinates_lon(){
    error_reporting(0);
    $comp_id      = trim($this->input->post('value', TRUE));
    $region       = $this->session->userdata('region');
    $select       = $this->db->query('SELECT longitude, barangay_name, city_name, province_name FROM dms_company WHERE company_name LIKE "%'.$comp_id.'%"')->result_array();

    //echo $this->db->last_query(); exit;
      if(!empty($select[0]['barangay_name'])){ $barangay_name = $select[0]['barangay_name']." "; }else{ $barangay_name = ""; }
      if(!empty($select[0]['city_name'])){ $city_name = $select[0]['city_name']." "; }else{ $city_name = ""; }
      if(!empty($select[0]['province_name'])){ $province_name = $select[0]['province_name']; }else{ $province_name = ""; }
      $addrs = $barangay_name.$city_name.$province_name;
      $longitude= "";
      // Get lat and long by address
        $address = $comp_id." ".$addrs; // Google HQ
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');
        $output= json_decode($geocode);

        if(!empty($select[0]['longitude'])){
          $longitude = $select[0]['longitude'];
        }else{
          $longitude = $output->results[0]->geometry->location->lng;
        }
    ?>
      <label>Longitude: <span id="requiredto">(required)</span></label>
      <input type="text"  name="longitude[]" class="form-control" value="<?php echo $longitude; ?>" required="" minlength="5">

  <?php
  }

  function coordinates_lon_input(){
    error_reporting(0);
    $destination      = trim($this->input->post('value', TRUE));
    // Get lat and long by address
    $address = $destination; // Google HQ
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyAnuAfDgC46Vy3Aq-ej6_zXrw6YbvHDgDA&token=35779');
    $output= json_decode($geocode);

    $longitude = $output->results[0]->geometry->location->lng;

  ?>
      <label>Longitude: <span id="requiredto">(required)</span></label>
      <input type="text"  name="longitude[]" class="form-control" placeholder="e.g 123.456789" value="<?php echo $longitude; ?>" required="" minlength="5">

  <?php
  }

  function add_row_destination(){
    $travelcat            = $this->input->post('travelcat');
    $no_of_rows           = $this->input->post('value');
    $optlabel = ($travelcat == 'Yes') ? 'Company / Establishment List within region' : 'All Company / Establishment List';
    $orderbycomp          = $this->db->order_by('comp.company_name','ASC');
    if($travelcat == 'Yes'){
      $wherecomp            = $this->db->where('comp.region_name',$this->session->userdata('region'));
    }
    $wherecomp            = $this->db->where('comp.deleted !=','1');
    $companylist          = $this->Embismodel->selectdata('dms_company AS comp','comp.company_name,comp.company_id','',$wherecomp,$orderbycomp); ?>
      <div class="row">
      <?php for ($a=0; $a < $no_of_rows; $a++) { ?>
      <table style="width: 100%;">
        <tbody>
        <tr>
          <td>
            <div class="col-md-12">
              <div class="row" id="ifnotinthelistbody">
                <div class="col-md-4">
                  <label>Destination: <span id="requiredto">(required)</span></label>
                  <select id="selectize_destination<?php echo $a; ?>" class="form-control" name="destination[]" onchange="notinthelist2($(this),this.value),coordinates_lat($(this),this.value);coordinates_lon($(this),this.value);" required="">
                    <option value=""></option>
                    <option value="ifnotinthelist">Not in the list?</option>
                    <optgroup label="<?php echo $optlabel; ?>">
                    <?php for($i=0; $i<sizeof($companylist); $i++){ ?>
                      <option value="<?php echo $companylist[$i]['company_name']; ?>"><?php echo ucwords($companylist[$i]['company_name']); ?></option>
                    <?php } ?>
                    </optgroup>
                  </select>
                </div>
                <div class="col-md-3" id="latitude">
                  <label>Latitude: <span id="requiredto">(required)</span></label>
                  <input type="text" class="form-control" disabled="">
                </div>
                <div class="col-md-5" id="longitude">
                  <label>Longitude: <span id="requiredto">(required)</span></label>
                  <input type="text" class="form-control" disabled="">
                </div>

              </div>
            </div>
          </td>
        </tr>
        </tbody>
      </table>

      <script type="text/javascript">
        $(document).ready( function(){
          $('#selectize_destination<?php echo $a; ?>').selectize();
        });
      </script>

      <?php } ?>
      </div>
  <?php
  }

  function notinthelist(){
    error_reporting(0);
    $row = $this->input->post('row');
   ?>
    <div class="col-md-4">
     <label>Input destination: <span id="requiredto">(One destination per row only)</span></label><span class="fa fa-undo" onclick="return_destination_dropdown($(this),$('#add_more_row').val(),$('#travel_cat_selectize').val());" title="Return to company list" style="float:right;font-size:10pt;margin-top:5px;color:#000;"></span>
      <input type="text" class="form-control" name="destination[]" onchange="input_coordinates_lat($(this),this.value); input_coordinates_lon($(this),this.value);" placeholder="* company name / establishment name with  barangay, city, province *" required="">
    </div>
    <div class="col-md-3" id="latitude">
      <label>Latitude:</label>
      <input type="text" class="form-control" name="latitude[]" disabled="">
    </div>
    <div class="col-md-3" id="longitude">
      <label>Longitude:</label>
      <input type="text" class="form-control" name="longitude[]" disabled="">
    </div>
    <div class="col-md-2">
      <label>Add More Row:</label>
      <input type="number" id="add_more_row" onkeyup="add_row_destination(this.value,$('#travel_cat_selectize').val());" onclick="add_row_destination(this.value,$('#travel_cat_selectize').val());"  class="form-control" value="<?php echo $row; ?>">
    </div>
  <?php
  }

  function notinthelist2(){
    error_reporting(0);
    $row = $this->input->post('row');
   ?>
    <div class="col-md-4">
     <label>Input destination: <span id="requiredto">(One destination per row only)</span></label><span class="fa fa-undo" onclick="return_destination_dropdown2($(this),$('#add_more_row').val(),$('#travel_cat_selectize').val(),'<?php echo rand(); ?>');" title="Return to company list" style="float:right;font-size:10pt;margin-top:5px;color:#000;"></span>
      <input type="text" class="form-control" name="destination[]" onchange="input_coordinates_lat($(this),this.value); input_coordinates_lon($(this),this.value);" placeholder="* company name / establishment name with  barangay, city, province *" required="">
    </div>
    <div class="col-md-4" id="latitude">
      <label>Latitude:</label>
      <input type="text" class="form-control" name="latitude[]" disabled="">
    </div>
    <div class="col-md-4" id="longitude">
      <label>Longitude:</label>
      <input type="text" class="form-control" name="longitude[]" disabled="">
    </div>
  <?php
  }

  function return_destination_dropdown(){
    $row                  = $this->input->post('row');
    $travelcat            = $this->input->post('travelcat');
    $optlabel             = ($travelcat == 'Yes') ? 'Company / Establishment List within region' : 'All Company / Establishment List';
    $orderbycomp          = $this->db->order_by('comp.company_name','ASC');
    if($travelcat == 'Yes'){
      $wherecomp            = $this->db->where('comp.region_name',$this->session->userdata('region'));
    }
    $wherecomp            = $this->db->where('comp.deleted !=','1');
    $companylist          = $this->Embismodel->selectdata('dms_company AS comp','comp.company_name,comp.company_id','',$wherecomp,$orderbycomp); ?>
    <div class="col-md-4">
     <label>Destination: <span id="requiredto">(required)</span></label>
      <select id="selectize_dest" class="form-control" name="destination[]" onchange="notinthelist($(this),this.value,$('#add_more_row').val()); coordinates_lat($(this),this.value);coordinates_lon($(this),this.value);" required="">
        <option value=""></option>
        <option value="ifnotinthelist">Not in the list?</option>
        <optgroup label="<?php echo $optlabel; ?>">
          <?php for($i=0; $i<sizeof($companylist); $i++){ ?>
            <option value="<?php echo $companylist[$i]['company_name']; ?>"><?php echo ucwords($companylist[$i]['company_name']); ?></option>
          <?php } ?>
        </optgroup>
      </select>
    </div>
    <div class="col-md-3" id="latitude">
      <label>Latitude:</label>
      <input type="text" class="form-control" name="latitude[]" disabled="">
    </div>
    <div class="col-md-3" id="longitude">
      <label>Longitude:</label>
      <input type="text" class="form-control" name="longitude[]" disabled="">
    </div>
    <div class="col-md-2">
      <label>Add More Row:</label>
      <input type="number" id="add_more_row" onkeyup="add_row_destination(this.value);"  class="form-control" value="<?php echo $row; ?>">
    </div>

    <script type="text/javascript">
        $(document).ready( function(){
          $('#selectize_dest').selectize();
        });
    </script>

  <?php
  }

  function return_destination_dropdown2(){
    $row                  = $this->input->post('row');
    $travelcat            = $this->input->post('travelcat');
    $rand                 = $this->input->post('rand');
    $optlabel             = ($travelcat == 'Yes') ? 'Company / Establishment List within region' : 'All Company / Establishment List';
    $orderbycomp          = $this->db->order_by('comp.company_name','ASC');
    if($travelcat == 'Yes'){
      $wherecomp            = $this->db->where('comp.region_name',$this->session->userdata('region'));
    }
    $wherecomp            = $this->db->where('comp.deleted !=','1');
    $companylist          = $this->Embismodel->selectdata('dms_company AS comp','comp.company_name,comp.company_id','',$wherecomp,$orderbycomp); ?>
    <div class="col-md-4">
     <label>Destination: <span id="requiredto">(required)</span></label>
      <select id="selectize_dest<?php echo $rand; ?>" class="form-control" name="destination[]" onchange="notinthelist2($(this),this.value,$('#add_more_row').val()); coordinates_lat($(this),this.value);coordinates_lon($(this),this.value);" required="">
        <option value=""></option>
        <option value="ifnotinthelist">Not in the list?</option>
        <optgroup label="<?php echo $optlabel; ?>">
          <?php for($i=0; $i<sizeof($companylist); $i++){ ?>
            <option value="<?php echo $companylist[$i]['company_name']; ?>"><?php echo ucwords($companylist[$i]['company_name']); ?></option>
          <?php } ?>
        </optgroup>
      </select>
    </div>
    <div class="col-md-4" id="latitude">
      <label>Latitude:</label>
      <input type="text" class="form-control" name="latitude[]" disabled="">
    </div>
    <div class="col-md-4" id="longitude">
      <label>Longitude:</label>
      <input type="text" class="form-control" name="longitude[]" disabled="">
    </div>

    <script type="text/javascript">
        $(document).ready( function(){
          $('#selectize_dest<?php echo $rand; ?>').selectize();
        });
    </script>

  <?php
  }

  function view_travel(){
    error_reporting(0);
    $token      = $this->encrypt->decode($this->input->post('token'));
    $region     = $this->session->userdata('region');
    $where      = $this->db->where('tt.token',$token);
    $join       = $this->db->join('acc_credentials AS acs','acs.userid = tt.assignedto','left');
    $select     = $this->Embismodel->selectdata('to_trans AS tt','tt.*,acs.fname,acs.mname,acs.sname,acs.suffix','',$where);
    if($select[0]['travel_cat'] == "Yes"){ $travel_cat = "Regional"; }else{ $travel_cat = "National"; }
    if(!empty($select[0]['per_diem'])){ $per_diem = $select[0]['per_diem']; }else{ $per_diem = "N/A"; }
    if(!empty($select[0]['assistant'])){ $assistant = $select[0]['assistant']; }else{ $assistant = "N/A"; }

    $mname   = !empty($select[0]['mname']) ?  $select[0]['mname'][0].". " : "";
    $suffix  = !empty($select[0]['suffix']) ?  " ".$select[0]['suffix'] : "";
    $nm      = ucwords($select[0]['fname']." ".$mname.$select[0]['sname'].$suffix);
    $nm2     = str_replace('Ã±', '&ntilde;', $nm);
    $name    =str_replace('ã±', '&ntilde;', $nm2);

    $destination = str_replace('Array', '', $select[0]['destination']);

    $trans_no = $select[0]['er_no'];
    $querymax   = $this->db->query("SELECT MAX(route_order)-1 AS mro	FROM `embis`.`er_transactions_log` AS `etl` WHERE `etl`.`trans_no` = '$trans_no'")->result_array();

    $wherereason= $this->db->where('etl.trans_no = "'.$trans_no.'" AND etl.status_description = "disapproved / denied"');
    $queryer_trans= $this->Embismodel->selectdata('er_transactions_log AS etl','etl.action_taken,etl.status,etl.status_description,etl.date_in,etl.receiver_name','',$wherereason);


    $trans_no = $select[0]['er_no'];
    $whereattachments  = $this->db->where('ea.trans_no',$trans_no);
    $trans_attachments = $this->Embismodel->selectdata('er_attachments AS ea','ea.*','',$whereattachments);

    $wheretime = $this->db->where('etl.trans_no = "'.$trans_no.'" AND etl.route_order = (SELECT MIN(route_order) FROM er_transactions_log AS etl WHERE etl.trans_no = "'.$trans_no.'")');
    $querytime = $this->Embismodel->selectdata('er_transactions_log AS etl','etl.date_in','',$wheretime);
    ?>

    <style type="text/css">
    #details-style{
      margin-top: 5px;
    }
    label#viewtitle {
      font-size: 9pt;
      font-weight: bold;
    }
    textarea#viewtextarea {
        color: #000;
        font-size: 9pt;
    }
    </style>

    <div class="row">
      <?php if ($select[0]['status'] == 'On-Process') { ?>
        <div class="col-md-6" id="details-style">
          <label id="viewtitle">For Approval of:</label>
          <input type="text" class="form-control" disabled="" value="<?php echo $name; ?>"><hr>
        </div>
        <div class="col-md-6" id="details-style">
          <label id="viewtitle">Status:</label>
          <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['status']; ?>"><hr>
        </div>
      <?php } ?>
      <?php if($queryer_trans[0]['status'] == '6'){ ?>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Disapproval Reason:</label>
        <textarea class="form-control" disabled="" rows="7"><?php echo $queryer_trans[0]['action_taken']; ?></textarea><hr>
      </div>
      <?php } ?>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Name:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['name']; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Designation:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['designation']; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Travel Number:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['toid']; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Travel Category:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $travel_cat; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Travel Type:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['travel_type']; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Date Applied:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo date("M d, Y", strtotime($querytime[0]['date_in'])); ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Departure Date and Arrival Date:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo date("M d, Y", strtotime($select[0]['departure_date']))." - ".date("M d, Y", strtotime($select[0]['arrival_date'])); ?>">
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Official Station:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['official_station']; ?>">
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Destination:</label>
        <textarea id="viewtextarea" class="form-control" disabled="" rows="4"><?php echo $destination; ?></textarea>
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Purpose:</label>
        <textarea id="viewtextarea" class="form-control" disabled="" rows="7"><?php echo $select[0]['travel_purpose']; ?></textarea>
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Per diems/Expenses Allowed:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $per_diem; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Assistant or Laborers Allowed:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $assistant; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Remarks of Special Instruction:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['remarks']; ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Date of Submission:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo date("F d, Y", strtotime($select[0]['report_submission'])); ?>">
      </div>
      <div class="col-md-4" id="details-style">
        <label id="viewtitle">Attachment</label>
        <?php if($trans_attachments[0]['trans_no'] != ''){ ?>
         <div class="dropdown">
          <a style="width:100%;" class="btn btn-info btn-sm dropdown-toggle" href="#" role="button" id="dropdownTravelAttachment" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           View Attachment
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownTravelAttachment" style="width:100%;">
              <?php for ($i=0; $i < sizeof($trans_attachments) ; $i++) {
                $att_name = str_replace(' ', '_', trim($trans_attachments[$i]['file_name']));
                $att = $trans_attachments[$i]['token'];
                $trans_no_1 = $trans_no;
                if($select[0]['region'] == 'CO'){
                  if(date("Y-m-d", strtotime($queryer_trans[0]['date_in'])) < '2020-02-16' && date("Y-m-d", strtotime($queryer_trans[0]['date_in'])) > '2020-01-01') {
                    $trans_no_1 = $trans_no - 10000000;
                  }
                }
                $att = "<a style='text-align:center;' class='dropdown-item' title='".$att_name."' href='".base_url('uploads/dms/'.date('Y', strtotime($querytime[0]['date_in'])).'/'.$select[0]['region'].'/'.$trans_no_1.'/'.$trans_attachments[$i]['token'].'.'.pathinfo($att_name, PATHINFO_EXTENSION))."' target='_blank'>".$trans_attachments[$i]['token']."</a>";
                echo $att;
                }
              ?>
          </div>
        </div>
        <?php }else{ ?>
          <input style="width:100%;" type="text" class="btn btn-danger btn-sm" value="No Attached File" disabled>
        <?php } ?>
      </div>
    </div>

  <?php
  }

  function ticket_travel(){
    $token      = $this->encrypt->decode($this->input->post('token'));
    $region     = $this->session->userdata('region');
    $where      = $this->db->where('tt.token',$token);
    $select['to_trans'] = $this->Embismodel->selectdata('to_trans AS tt','*','',$where);

    $wherecheckaccountant = $this->db->where('ac.region',$region);
    $wherecheckaccountant = $this->db->where('ac.to_ticket_chief_accountant','yes');
    $checkaccountant       = $this->Embismodel->selectdata('acc_rights AS ac','ac.userid','',$wherecheckaccountant);

    if(!empty($checkaccountant[0]['userid'])){
      $this->load->view('travelorder/function/transportation_order',$select);
    }else{ ?>
     <div class="modal-body">
       <div class="row">
         <div class="col-md-12" id="details-style">
           <center><h5 style="font-weight: bold;color: red;padding: 20px 0px 20px 0px;">Chief accountant not assigned. <br><h6 style="font-weight:normal;color:#000;">Please contact MIS. Thank you.</h6></h5></center>
         </div>
       </div>
     </div>
     <div class="modal-footer">
         <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
     </div>
    <?php
    }


  }



  function calendar_details(){
    $token      = $this->input->post('token');
    $where      = $this->db->where('et.status !=','0');
    $where      = $this->db->where('tt.token',$token);
    $join       = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
    $select     = $this->Embismodel->selectdata('to_trans AS tt','*,et.token','',$join,$where);
    if($select[0]['travel_cat'] == "Yes"){ $travel_cat = "Regional"; }else{ $travel_cat = "National"; }
    if(!empty($select[0]['per_diem'])){ $per_diem = $select[0]['per_diem']; }else{ $per_diem = "N/A"; }
    if(!empty($select[0]['assistant'])){ $assistant = $select[0]['assistant']; }else{ $assistant = "N/A"; }

    $destination = str_replace('Array', '', $select[0]['destination']);

    $trans_no = $select[0]['er_no'];
    $querymax   = $this->db->query("SELECT MAX(route_order)-1 AS mro  FROM `embis`.`er_transactions_log` AS `etl` WHERE `etl`.`trans_no` = '$trans_no'")->result_array();

    $wherereason= $this->db->where('etl.trans_no',$trans_no);
    $wherereason= $this->db->where('etl.route_order',$querymax[0]['mro']);
    $queryreason= $this->Embismodel->selectdata('er_transactions AS etl','etl.action_taken,etl.status','',$wherereason);
    ?>

    <style type="text/css">
    #details-style{
      margin-top: 5px;
    }
    label#viewtitle {
      font-size: 9pt;
      font-weight: bold;
    }
    input.form-control {
      font-size: 9pt;
      color: #000;
    }
    textarea#viewtextarea {
        color: #000;
        font-size: 9pt;
    }
    </style>

    <div class="row">
      <div class="col-md-3" id="details-style">
        <label id="viewtitle">Transaction No:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['token']; ?>">
      </div>
      <div class="col-md-3" id="details-style">
        <label id="viewtitle">Travel Number:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['toid']; ?>">
      </div>
      <div class="col-md-3" id="details-style">
        <label id="viewtitle">Travel Category:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $travel_cat; ?>">
      </div>
      <div class="col-md-3" id="details-style">
        <label id="viewtitle">Travel Type:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['travel_type']; ?>">
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Name:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['name']; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Departure Date and Arrival Date:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo date("M d, Y", strtotime($select[0]['departure_date']))." - ".date("M d, Y", strtotime($select[0]['arrival_date'])); ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Official Station:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['official_station']; ?>">
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Destination:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $destination; ?>">
      </div>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Purpose:</label>
        <textarea id="viewtextarea" class="form-control" disabled="" rows="7"><?php echo $select[0]['travel_purpose']; ?></textarea>
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Per diems/Expenses Allowed:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $per_diem; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Assistant or Laborers Allowed:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $assistant; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Remarks of Special Instruction:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo $select[0]['remarks']; ?>">
      </div>
      <div class="col-md-6" id="details-style">
        <label id="viewtitle">Date of Submission:</label>
        <input type="text" class="form-control" disabled="" value="<?php echo date("M d, Y", strtotime($select[0]['report_submission'])); ?>">
      </div>
      <?php if($queryreason[0]['status'] == '6'){ ?>
      <div class="col-md-12" id="details-style">
        <label id="viewtitle">Disapproval Reason:</label>
        <textarea class="form-control" disabled="" rows="7"><?php echo $queryreason[0]['action_taken']; ?></textarea>
      </div>
      <?php } ?>
    </div>

  <?php
  }

  function traveltype(){
    $type  = $this->input->post('type');

    ?>

    <label>Do you want to request a vehicle?</label>


  <?php
  }

  function fileUpload()
  {
    $trans_no = $this->session->userdata('travel_trans_no');

    $region   = $this->session->userdata('region');

    $path = 'dms/'.date('Y').'/'.$region.'/';
    $folder = $trans_no;

    if(!is_dir('uploads/'.$path.'/'.$folder)) {
      mkdir('uploads/'.$path.'/'.$folder, 0777, TRUE);
    }

      $region_where = array('ar.rgnnum' => $region );
      $region_data = $this->Embismodel->selectdata('acc_region AS ar', '*', $region_where );

      $att_token1 = fmod($trans_no, 1000000);

      $ea_w = array(
        'ea.trans_no'     => $trans_no,
        'ea.route_order'  => 1,
      );
      $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);

      $att_token = $region.date('Y').'-FT'.'1'.'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);

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
          'trans_no'      => $trans_no,
          'route_order'   => 1,
          'file_id'       => $ea_q[0]['max_fileid']+1, // order_by
          'token'         => $att_token,
          'file_name'     => $_FILES['file']['name'],
        );
        $this->Embismodel->insertdata('er_attachments', $erattach_insert);
      }
    }
  }

  function view_trans_travel_details(){
    $trans_no = $this->encrypt->decode($this->input->post('token'));

    $region      = $this->session->userdata('region');
    $where       = $this->db->where('tt.er_no',$trans_no);
    $qryaccounts = $this->Embismodel->selectdata('to_trans AS tt','*','',$where);
    $travelcat = ($qryaccounts[0]['travel_cat'] == 'Yes') ? 'Regional' : 'National';

    $wheredest   = $this->db->where('td.er_no',$trans_no);
    $qrydest     = $this->Embismodel->selectdata('to_destination AS td','*','',$wheredest);

    //IF DISAPPROVED
    $whereaction  = $this->db->where('et.trans_no',$trans_no);
    $queryaction  = $this->Embismodel->selectdata('er_transactions AS et','et.action_taken,et.status,et.token','',$whereaction);
    //IF DISAPPROVED
  ?>
    <style type="text/css">
      #form-style{
        margin-top:5px;
      }
    </style>
        <div class="row" style="padding: 5px 12px 0px 12px;">
          <div class="col-md-12" id="form-style">
            <label>Name:</label> <span style="float: right;font-style: italic !important;color:#08507E;">* To view attached documents, please view transaction history *</span>
            <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['name']; ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Travel Category:</label>
            <input type="text" class="form-control" value="<?php echo $travelcat; ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Travel Type:</label>
            <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['travel_type']; ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Date of Departure:</label>
            <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($qryaccounts[0]['departure_date'])); ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Arrival Date:</label>
            <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($qryaccounts[0]['arrival_date'])); ?>" readonly>
          </div>
          <div class="col-md-12" id="form-style">
            <label>Official Station:</label>
            <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['official_station']; ?>" readonly>
          </div>

          <?php
            $destination = "";
            for($i=0; $i<sizeof($qrydest); $i++){
              if(sizeof($qrydest) === $i+1){ $con = ""; }else{ $con = ", "; }
              $destination .= $qrydest[$i]['location'].$con;
          } ?>

          <div class="col-md-12" id="form-style">
            <label>Destination:</label>
            <input type="text" class="form-control" value="<?php echo ucwords($destination); ?>" readonly>
          </div>
          <div class="col-md-12" id="form-style">
            <label>Purpose of Travel:</label>
            <textarea class="form-control" readonly><?php echo $qryaccounts[0]['travel_purpose']; ?></textarea>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Per Diems/ Expenses Allowed:</label>
            <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['per_diem']; ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Assistant or laborers Allowed:</label>
            <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['assistant']; ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Remarks of Special Instruction:</label>
            <input type="text" class="form-control" value="<?php echo $qryaccounts[0]['remarks']; ?>" readonly>
          </div>
          <div class="col-md-6" id="form-style">
            <label>Date of Report Submission:</label>
            <input type="text" class="form-control" value="<?php echo date("M d, Y", strtotime($qryaccounts[0]['report_submission'])); ?>" readonly>
          </div>

          <?php if($queryaction[0]['status'] == '6'){ ?>
          <div class="col-md-12"><hr></div>
          <div class="col-md-12" id="form-style">
            <label>Disapproval Remarks:</label>
            <textarea class="form-control" disabled=""><?php echo $queryaction[0]['action_taken']; ?></textarea>
          </div>
          <?php } ?>
        </div>
  <?php
  }

  function notinlist_labor(){
  ?>
    <label>Please input Assistant or laborers Allowed:</label><span class="fa fa-undo" onclick="return_laborers_dropdown();" title="Return to list" style="float:right;font-size:10pt;margin-top:5px;color:#000;"></span>
    <input type="text" name="assistant[]" placeholder="input 'N/A' if not applicable" class="form-control" required="">
  <?php
  }

  function return_laborers_dropdown(){
    $orderbytolaborers    = $this->db->order_by('acs.fname','ASC');
    $wheretolaborers      = $this->db->where('ar.to_assistant_or_laborers','yes');
    $jointolaborers       = $this->db->join('acc_credentials AS acs','acs.userid = ar.userid','left');
    $laborers             = $this->Embismodel->selectdata('acc_rights AS ar','ar.to_assistant_or_laborers,acs.userid,acs.fname,acs.mname,acs.sname,acs.suffix','',$jointolaborers,$wheretolaborers,$orderbytolaborers);
  ?>
    <label>Assistant or laborers Allowed:</label>
    <select class="form-control" name="assistant" id="travel_assistant_selectize_two" onchange="notinlist_labor(this.value);" required="">
      <option value=""></option>
      <option value="ifnotinlist_labor">Not in the list?</option>
      <?php for($i=0; $i<sizeof($laborers); $i++){
        if(!empty($laborers[$i]['mname'])){ $mname = $laborers[$i]['mname'][0].". "; }else{ $mname = ""; }
        if(!empty($laborers[$i]['suffix'])){ $suffix = " ".$laborers[$i]['suffix']; }else{ $suffix = ""; }
        $laborer_name = ucwords($laborers[$i]['fname']." ".$mname.$laborers[$i]['sname'].$suffix)
      ?>
        <option value="<?php echo $laborer_name; ?>"><?php echo $laborer_name; ?></option>
      <?php } ?>
    </select>

    <script type="text/javascript">
      $(document).ready( function(){
        $('#travel_assistant_selectize_two').selectize();
      });
    </script>

  <?php
  }

  function add_travel_report(){
    $wheredata  = $this->db->where('tt.userid = "'.$this->session->userdata('userid').'" AND (tt.status = "Signed Document" OR tt.status = "Approved") AND et.status != "0" ORDER BY tt.departure_date DESC');
    $joindata   = $this->db->join('er_transactions AS et','et.trans_no = tt.er_no','left');
    $selectdata = $this->Embismodel->selectdata('to_trans AS tt','tt.*','',$joindata,$wheredata);

  ?>
  <form action="<?= base_url(); ?>Travel/SubmitReport" method="post" enctype="multipart/form-data">
    <div class="modal-body">
      <div class="col-md-12">
        <label>Search Travel Details:</label>
        <select id="travel_details_selectize" class="form-control" name="travel_details" required="">
          <option value=""></option>
          <?php for ($i=0; $i < sizeof($selectdata); $i++) { if(!empty($selectdata[$i]['toid'])){ ?>
            <optgroup label="<?= date("M d, Y", strtotime($selectdata[$i]['departure_date']))." - ".date("M d, Y", strtotime($selectdata[$i]['departure_date']))." - ".$selectdata[$i]['toid']; ?>">
              <option value="<?= $this->encrypt->encode($selectdata[$i]['toid']); ?>">
                <?= "[".date("M d, Y", strtotime($selectdata[$i]['departure_date']))." - ".date("M d, Y", strtotime($selectdata[$i]['departure_date']))."] - ".$selectdata[$i]['toid']." - ".str_replace("Array", "", $selectdata[$i]['destination'])." - ".$selectdata[$i]['travel_purpose']; ?>
              </option>
            </optgroup>
          <?php } } ?>
        </select>
      </div>
      <div class="col-md-12">
        <label>Attachment: <span style="font-style: italic; color: red;">( One or multiple attachments )</span></label>
        <input type="file" class="form-control" name="report_file[]" accept="application/msword, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*" multiple="" required="">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-success btn-sm">Submit</button>
    </div>
  </form>
     <script type="text/javascript">
      $(document).ready( function(){
        $('#travel_details_selectize').selectize();
      });
    </script>
  <?php
  }

  function trvlrprtattchmnt(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $route_order = ($this->input->post('route_order', TRUE));
    $wheretravel  = $this->db->where('tt.token = "'.$token.'"');
    $selecttravel = $this->Embismodel->selectdata('to_trans AS tt','','',$wheretravel);
    $wheredata  = $this->db->where('ea.trans_no = "'.$selecttravel[0]['er_no'].'" AND ea.route_order = "'.$route_order.'"');
    $joindata   = $this->db->join('er_transactions AS et','et.trans_no = ea.trans_no','left');
    $selectdata = $this->Embismodel->selectdata('er_attachments AS ea','ea.*,et.start_date,et.region','',$joindata,$wheredata);
    // echo $this->db->last_query();
  ?>
    <?php for ($i=0; $i < sizeof($selectdata); $i++) {
      $path_file = base_url()."uploads/dms/".date("Y", strtotime($selectdata[$i]['start_date']))."/".$selectdata[$i]['region']."/".$selecttravel[0]['er_no']."/".$selectdata[$i]['token'].'.'.pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION);
  ?>
      <li style="padding: 5px 15px 5px 15px;"><a target="_blank" href="<?php echo $path_file; ?>" title="<?php echo $selectdata[$i]['file_name']; ?>"><?php echo $selectdata[$i]['token']; ?></a></li>
    <?php } ?>

  <?php
  }

  function touploadattachments(){

    $trans_no = $this->encrypt->decode($this->input->post('token'));

    $region   = $this->session->userdata('region');

    $path = 'dms/'.date('Y').'/'.$region;
    $folder = $trans_no;

    if(!is_dir('uploads/'.$path.'/'.$folder)) {
      mkdir('uploads/'.$path.'/'.$folder, 0777, TRUE);
    }

    if((count($_FILES['supporting_docs']['name'])) >= '1'){
      $error = array();

      $config = array(
        'upload_path'   => 'uploads/'.$path.'/'.$folder.'/',
        'allowed_types' => 'pdf|csv|xls|ppt|doc|docx|xlsx|mp4|m4a|jpeg|jpg|png|gif|mp3|zip|text|txt',
        'max_size'			 => '100000',
        'overwrite'     => FALSE,
      );

      $this->load->library('upload',$config);
      // Set preference
      $counter = 0;
      $pathurl = "";
      for ($i=0; $i < count($_FILES['supporting_docs']['name']); $i++) {
        $_FILES['file']['name']      = $_FILES['supporting_docs']['name'][$i];
        $_FILES['file']['type']      = $_FILES['supporting_docs']['type'][$i];
        $_FILES['file']['tmp_name']  = $_FILES['supporting_docs']['tmp_name'][$i];
        $_FILES['file']['error']     = $_FILES['supporting_docs']['error'][$i];
        $_FILES['file']['size']      = $_FILES['supporting_docs']['size'][$i];

        $att_token1 = fmod($trans_no, 1000000);

        $ea_w = array(
          'ea.trans_no'     => $trans_no,
          'ea.route_order'  => 1,
        );
        $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);

        $att_token = $region.date('Y').'-FT'.'1'.'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);

        $config['file_name'] = $att_token;

        $this->upload->initialize($config);

        if($this->upload->do_upload('file')){

          $erattach_insert = array(
            'trans_no'      => $trans_no,
            'route_order'   => 1,
            'file_id'       => $ea_q[0]['max_fileid']+1, // order_by
            'token'         => $att_token,
            'file_name'     => $_FILES['file']['name'],
          );
          $this->Embismodel->insertdata('er_attachments', $erattach_insert);

          chmod($config['upload_path'].$att_token.'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION),0777,TRUE);
          $counter++;
          $this->session->set_userdata('toattachmentchecker', $counter);
        }
      }

      if($counter > 0){
        $responsemerge = array_merge(['status' => 'success']);
        echo json_encode($responsemerge);
      }else{
        $responsemerge = array_merge(['status' => 'failed']);
        echo json_encode($responsemerge);
      }

    }else{
      $responsemerge = array_merge(['status' => 'failed']);
      echo json_encode($responsemerge);
    }

    clearstatcache();
  }

  function viewtouploadedfiles(){
    $wheredata = array('ea.trans_no' => $this->encrypt->decode($this->input->post('token')), );
    $selectdata = $this->Embismodel->selectdata('er_attachments AS ea','ea.token, ea.file_name, ea.cnt',$wheredata);
    ?>
      <div class="row">
        <?php for ($i=0; $i < sizeof($selectdata); $i++) {
          if(!empty($selectdata[$i]['token'])){
         $path = 'uploads/dms/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/'.$selectdata[$i]['token'].".".pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION); ?>
        <div class="col-md-12" style="display:flex;">
          <a class="form-control" href="<?php echo base_url().$path; ?>" target="_blank" style="width:100%;">
            <label>Filename:&nbsp;<?php echo $selectdata[$i]['file_name']; ?></label>
          </a>
          <button type="button" onclick="removeuploadedto('<?php echo $this->input->post('token'); ?>','<?php echo $selectdata[$i]['token'].".".pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION); ?>','<?php echo $this->encrypt->encode($selectdata[$i]['cnt']); ?>');" class="btn btn-danger btn-sm" style="width: 25%;margin-left: 10px;height: 39px;">
            <span class="fa fa-trash"></span>&nbsp;Remove file</button>
        </div>
      <?php }else{
        echo '<label class="form-control">No uploaded file(s)</label>';
      }} ?>
      </div>
    <?php
  }

  function removeuploadedto(){
    if(!empty($this->input->post('filename'))){
      $wheredata = array('trans_no' => $this->encrypt->decode($this->input->post('token')), 'cnt' => $this->encrypt->decode($this->input->post('cnt')),);
      $deletedata = $this->Embismodel->deletedata('er_attachments',$wheredata);
      if($deletedata){
        unlink('uploads/dms/'.date('Y').'/'.$this->session->userdata('region').'/'.$this->encrypt->decode($this->input->post('token')).'/'.$this->input->post('filename'));
      }
      echo json_encode(array('status' => 'success', 'token' => $this->input->post('token'), ));
    }
  }

  function stcmpvw(){
    $token = $this->input->post('token', TRUE);
    $optlabel = ($token == 'Yes') ? 'Company / Establishment List within region' : 'All Company / Establishment List';
    $orderbycomp  = $this->db->order_by('comp.company_name','ASC');
    if($token == 'Yes'){
      $wherecomp  = $this->db->where('comp.region_name',$this->session->userdata('region'));
    }
    $wherecomp    = $this->db->where('comp.deleted !=','1');
    $companylist  = $this->Embismodel->selectdata('dms_company AS comp','comp.company_name,comp.company_id','',$wherecomp,$orderbycomp);
    if(!empty($token)){
      ?>
        <div class="col-md-4">
          <label>Destination: <span id="requiredto">(required)</span></label>
          <select id="selectize_attachment" class="form-control" name="destination[]" onchange="notinthelist($(this),this.value,$('#add_more_row').val()); coordinates_lat($(this),this.value);coordinates_lon($(this),this.value);">
            <option value=""></option>
            <option value="ifnotinthelist">Not in the list?</option>
            <optgroup label="<?php echo $optlabel; ?>">
              <?php for($i=0; $i<sizeof($companylist); $i++){ ?>
                <option value="<?php echo $companylist[$i]['company_name']; ?>"><?php echo ucwords($companylist[$i]['company_name']); ?></option>
              <?php } ?>
            </optgroup>
          </select>
        </div>
        <div class="col-md-3" id="latitude">
          <label>Latitude: <span id="requiredto">(required)</span></label>
          <input type="text" class="form-control" disabled="">
        </div>
        <div class="col-md-3" id="longitude">
          <label>Longitude: <span id="requiredto">(required)</span></label>
          <input type="text" class="form-control" disabled="">
        </div>
        <div class="col-md-2">
          <label>Add More Row:</label>
          <select class="form-control" onchange="add_row_destination(this.value,$('#travel_cat_selectize').val());" id="add_more_row_two">
            <?php for ($i=0; $i < 11; $i++) {
              echo '<option value="'.$i.'">'.$i.'</option>';
            } ?>
          </select>
        </div>
        <script type="text/javascript">
          $('#selectize_attachment').selectize();
          $('#add_more_row_two').selectize();
        </script>
      <?php
    }
  }

  function view_travel_format(){
    $token = $this->encrypt->decode($_POST['token']);
    if($token == '1'){
      echo '<a type="button" class="btn btn-info btn-sm" target="_blank" style="font-size: 7pt;margin-left:5px;" href="https://iis.emb.gov.ph/iis-images/travel/format-1.pdf">View Format</a>';
    }else if($token == '2'){
      echo '<a type="button" class="btn btn-info btn-sm" target="_blank" style="font-size: 7pt;margin-left:5px;" href="https://iis.emb.gov.ph/iis-images/travel/format-2.pdf">View Format</a>';
    }else if($token == '3'){
      echo '<a type="button" class="btn btn-info btn-sm" target="_blank" style="font-size: 7pt;margin-left:5px;" href="https://iis.emb.gov.ph/iis-images/travel/format-3.pdf">View Format</a>';
    }
  }

  function checkdate(){
    date_default_timezone_set("Asia/Manila");
    $token = $this->input->post('token');
    $whereregionrights = $this->db->where('arr.region = "'.$this->session->userdata('region').'"');
    $checkregionrights = $this->Embismodel->selectdata('acc_rights_region AS arr','','',$whereregionrights);
    $datetoday = date('Y-m-d');
    if($checkregionrights[0]['to_lock_dates'] == 'yes' AND $this->session->userdata('userid') != '1587' AND $this->session->userdata('userid') != '160'){
      $yesterday = date('Y-m-d', strtotime($datetoday .' -1 day'));
      if(strtotime($token) >= strtotime($yesterday) OR $token == $datetoday){
        echo json_encode(array('status' => 'success', ));
      }else{
        echo json_encode(array('status' => 'failed', ));
      }
    }else{
      echo json_encode(array('status' => 'success', ));
    }
  }

}
