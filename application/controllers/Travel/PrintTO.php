<?php

class PrintTO extends CI_Controller
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

  function index($tokenget = ''){
    error_reporting(0);
    // if(empty($this->session->userdata('userid'))){ echo "<script>alert('Please login. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; }
    if(!empty($tokenget)){
      $token = $this->encrypt->decode($tokenget);
      if(empty($token)){ echo "<script>alert('Please provide valid token. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; }
      $where = $this->db->where('tt.token',$token);
    }

    if(!empty($this->input->get('sub_token'))){
      $token = str_replace('/','',$this->input->get('sub_token'));
      if(empty($token)){ echo "<script>alert('Please provide valid token. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; }
      $where = $this->db->where('tt.token',$token);
    }

    $where = $this->db->where('acs.verified','1');
    $join  = $this->db->join('acc_credentials AS acs','acs.userid = tt.userid','left');
    $join  = $this->db->join('acc_function AS af','af.userid = tt.userid','left');
    $join  = $this->db->join('acc_xdvsion AS xn','xn.divno = tt.divno','left');
    $join  = $this->db->join('acc_xsect AS xt','xt.secno = tt.secno','left');
    $join  = $this->db->join('acc_plantillapostn AS pn','pn.planpstn_id = tt.plantilla_pos','left');
    $query = $this->Embismodel->selectdata('to_trans AS tt','tt.*,acs.fname,acs.mname,acs.sname,acs.suffix,xn.divcode,xn.divname,xt.sect,xt.secode,pn.planpstn_desc,af.func','',$join,$where);
    // echo $this->db->last_query(); exit;

    if(empty($query[0]['toid'])){ echo "<script>alert('Please provide valid token. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; }

    if(!empty($query[0]['mname'])){ $mname = $query[0]['mname'][0].". "; }else{ $mname = ""; }
    if(!empty($query[0]['suffix'])){ $suffix = " ".$query[0]['suffix']; }else{ $suffix = ""; }
    $name = ucwords($query[0]['fname']." ".$mname.$query[0]['sname'].$suffix);

    if(!empty($query[0]['divcode'])){ $divcode = ucwords($query[0]['divcode']); }else{ $divcode = "N/A"; }
    if(!empty($query[0]['sect'])){ $sect = ucwords($query[0]['sect']); }else{ $sect = ""; }

    $sect_length = strlen($sect);
    if($sect_length <= 14 ){
        if($sect != ''){
          $section = ucwords($query[0]['sect']);
        }else{
          $section = "N/A";
        }
    }else{
        if($sect != ''){
          $section = strtoupper($query[0]['secode']);
        }else{
          $section = "N/A";
        }
    }

    if(!empty($query[0]['planpstn_desc'])){
      if($query[0]['plantilla_itemno'] == 'Chief' || $query[0]['plantilla_itemno'] == 'Supervising' || $query[0]['plantilla_itemno'] == 'Senior'){
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


    $destination = (strlen($query[0]['destination']) > 375) ? substr(str_replace("Array","",$query[0]['destination']), 0, 375) . '...' : str_replace("Array","",$query[0]['destination']);

    $remarks = (strlen($query[0]['remarks']) > 60) ? substr(str_replace("Array","",$query[0]['remarks']), 0, 60). '...' : $query[0]['remarks'];

    if(!empty($query[0]['per_diem'])){ $per_diem = ucwords($query[0]['per_diem']); }else{ $per_diem = "N/A"; }
    if(!empty($query[0]['assistant'])){ $assistant = ($query[0]['assistant']); }else{ $assistant = "N/A"; }

    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 5, 10, 0);
    $pdf->SetTitle('TRAVEL ORDER - '.$query[0]['toid'].'');
    $pdf->SetCreator(PDF_CREATOR);

    // Add a page
    // $pdf->AddPage();
    if($query[0]['region'] == 'R11' OR $query[0]['travel_format'] == '2' OR $query[0]['travel_format'] == '3'){
      $page_format = array('210', '330.2');
    }else{
      $page_format = array('210', '297');
    }

    $pdf->AddPage('P', $page_format, false, false);



      $html ='<img class="head" src="http://iis.emb.gov.ph/iis-images/document-header/'.$query[0]['toheader'].'">
                <table style="width:100%;font-family:times;text-align:center;">';
      if($query[0]['region'] != 'R11' AND $query[0]['region'] != 'R7' AND $query[0]['region'] != 'CO' AND $query[0]['region'] != 'R13' AND $query[0]['region'] != 'R4A'){
        $html .= '<tr style="font-size:12px;line-height: 20%;">
                  <td style="width:99%;"> <hr style="line-height: 80%;"></td>
                </tr>';
      }
      $html .= '<tr style="font-weight:bold;font-size:13px;">
                  <td>TRAVEL ORDER</td>
                </tr>
                <tr>
                  <td style="font-size:12px;">('.$query[0]['toid'].')</td>
                </tr>
              </table>
              <br><br>';

       $html .= '<table style="font-family:times;">
          <tr style="font-size:9px;">
            <td style="width:16%;">&nbsp;&nbsp;&nbsp;Name</td>
            <td style="width:2%;">:</td>
            <td style="width:40%;font-weight:bold;">'.$name.'</td>
            <td style="width:12%;">Division</td>
            <td style="width:2%;">:</td>
            <td style="width:25%;font-weight:bold;">'.$divcode.'</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:16%;">&nbsp;&nbsp;&nbsp;Position</td>
            <td style="width:2%;">:</td>
            <td style="width:40%;font-weight:bold;">'.$position.'</td>
            <td style="width:12%;">Section/Unit</td>
            <td style="width:2%;">:</td>
            <td style="width:25%;font-weight:bold;height:35px;">'.$section.'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:9px;">
            <td style="width:15%;">Departure Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['departure_date'])).'</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:15%;">Arrival Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['arrival_date'])).'</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:15%;">Official Station</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$query[0]['official_station'].'</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:15%;">Destination</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;height:70px;font-weight:bold;">'.$destination.'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:9px;">
            <td style="width:98%;font-weight:bold;">Purpose of Travel</td>
          </tr>
          <tr style="font-size:9px;">
            <td style="width:98%;"><br></td>
          </tr>
          <tr style="font-size:9px;">
            <td style="width:98%;height:80px;text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$query[0]['travel_purpose'].'</td>
          </tr>
          <tr style="font-size:12px;line-height:20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:9px;">
            <td style="width:23%;">Per diems/Expenses Allowed</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$per_diem.'</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:23%;">Assistant or Laborers Allowed</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$assistant.'</td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:9px;">
            <td style="width:98%;font-weight:bold;">Appropriations to which travel should be charge</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:23%;">Remarks of Special Instruction</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$remarks.'</td>
          </tr>
          <tr style="font-size:9px;line-height: 1.6;">
            <td style="width:23%;">Date of Submission</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['report_submission'])).'</td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:9px;">
            <td style="width:98%;font-weight:bold;">Certification:</td>
          </tr>
          <tr style="font-size:9px;text-align:center;">
            <td style="width:98%;">This is to certify that the travel is necessary and is connected with the functions of the official/Employee and this Division/Section/Unit.</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>';

      $wheredirector = $this->db->where('ttl.er_no = "'.$query[0]['er_no'].'" AND af.func = "Director" AND af.stat = "1" AND oue.status = "Active"');
      $joindirector  = $this->db->join('office_uploads_esignature AS oue','oue.userid = af.userid','left');
      $joindirector  = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
      $joindirector  = $this->db->join('to_trans_log AS ttl','ttl.assignedto = af.userid','left');
      $querydirector = $this->Embismodel->selectdata('acc_function AS af','oue.*,acs.designation,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joindirector,$wheredirector);
      $dtitle = !empty($querydirector[0]['title']) ? $querydirector[0]['title']." " : '';
      $dmname = !empty($querydirector[0]['mname']) ? $querydirector[0]['mname'][0].". " : '';
      $dsuffix = !empty($querydirector[0]['suffix']) ? " ".$querydirector[0]['suffix'] : '';
      $dnm = str_replace('ñ', 'Ñ', $dtitle.$querydirector[0]['fname']." ".$dmname.$querydirector[0]['sname']);
      $dname = strtoupper($dnm).$dsuffix;

      //'60', '238', 0, 11, D National Positioning default
      //'60', '231', 0, 11, D Regional Positioning default
      $nd_xaxis = (!empty($querydirector[0]['to_xaxis_n'])) ? $querydirector[0]['to_xaxis_n'] : '60';
      $nd_yaxis = (!empty($querydirector[0]['to_yaxis_n'])) ? $querydirector[0]['to_yaxis_n'] : '238';
      $nd_width = (!empty($querydirector[0]['to_width_n'])) ? $querydirector[0]['to_width_n'] : '0';
      $nd_height = (!empty($querydirector[0]['to_height_n'])) ? $querydirector[0]['to_height_n'] : '11';

      $rd_xaxis = (!empty($querydirector[0]['to_xaxis_r'])) ? $querydirector[0]['to_xaxis_r'] : '58';
      $rd_yaxis = (!empty($querydirector[0]['to_yaxis_r'])) ? $querydirector[0]['to_yaxis_r'] : '233';
      $rd_width = (!empty($querydirector[0]['to_width_r'])) ? $querydirector[0]['to_width_r'] : '0';
      $rd_height = (!empty($querydirector[0]['to_height_r'])) ? $querydirector[0]['to_height_r'] : '11';

      if($query[0]['func'] == 'Regional Director'){
        $whererd = $this->db->where('af.func = "Regional Director" AND af.region = "'.$query[0]['region'].'" AND af.stat = "1" AND oue.status = "Active" ');
        $joinrd  = $this->db->join('office_uploads_esignature AS oue','oue.userid = af.userid','left');
        $joinrd  = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
        $queryrd = $this->Embismodel->selectdata('acc_function AS af','oue.*,acs.userid,acs.designation,af.func,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinrd,$whererd);
      }else{
        $whererd = $this->db->where('ttl.er_no = "'.$query[0]['er_no'].'" AND af.func = "Regional Director" AND af.region = "'.$query[0]['region'].'" AND af.stat = "1" AND oue.status = "Active" GROUP BY ttl.assignedto');
        $joinrd  = $this->db->join('office_uploads_esignature AS oue','oue.userid = af.userid','left');
        $joinrd  = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
        $joinrd  = $this->db->join('to_trans_log AS ttl','ttl.assignedto = af.userid','left');
        $queryrd = $this->Embismodel->selectdata('acc_function AS af','oue.*,acs.userid,acs.designation,af.func,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinrd,$whererd);
      }

      // echo $this->db->last_query(); exit;
      $rdtitle = !empty($queryrd[0]['title']) ? $queryrd[0]['title']." " : '';
      $rdmname = !empty($queryrd[0]['mname']) ? $queryrd[0]['mname'][0].". " : '';
      $rdsuffix = !empty($queryrd[0]['suffix']) ? " ".$queryrd[0]['suffix'] : '';
      $rdnm = str_replace('ñ', 'Ñ', $rdtitle.$queryrd[0]['fname']." ".$rdmname.$queryrd[0]['sname']);
      $rdname = strtoupper($rdnm.$rdsuffix);
      // x - y - w - h
      // '50', '222', 0, 11, RD National Positioning default
      //'50', '232', 0, 11, RD Regional Positioning default
      $nrd_xaxis = (!empty($queryrd[0]['to_xaxis_n'])) ? $queryrd[0]['to_xaxis_n'] : '50';
      $nrd_yaxis = (!empty($queryrd[0]['to_yaxis_n'])) ? $queryrd[0]['to_yaxis_n'] : '222';
      $nrd_width = (!empty($queryrd[0]['to_width_n'])) ? $queryrd[0]['to_width_n'] : '0';
      $nrd_height = (!empty($queryrd[0]['to_height_n'])) ? $queryrd[0]['to_height_n'] : '11';

      $rrd_xaxis = (!empty($queryrd[0]['to_xaxis_r'])) ? $queryrd[0]['to_xaxis_r'] : '50';
      $rrd_yaxis = (!empty($queryrd[0]['to_yaxis_r'])) ? $queryrd[0]['to_yaxis_r'] : '232';
      $rrd_width = (!empty($queryrd[0]['to_width_r'])) ? $queryrd[0]['to_width_r'] : '0';
      $rrd_height = (!empty($queryrd[0]['to_height_r'])) ? $queryrd[0]['to_height_r'] : '11';

      $wherered = $this->db->where('ttl.er_no = "'.$query[0]['er_no'].'" AND af.func = "Regional Executive Director" AND af.region = "'.$query[0]['region'].'" AND af.stat = "1" AND oue.status = "Active" GROUP BY ttl.assignedto');
      $joinred  = $this->db->join('to_trans_log AS ttl','ttl.assignedto = af.userid','left');
      $joinred  = $this->db->join('office_uploads_esignature AS oue','oue.userid = ttl.assignedto','left');
      $joinred  = $this->db->join('acc_credentials AS acs','acs.userid = ttl.assignedto','left');
      $queryred = $this->Embismodel->selectdata('acc_function AS af','oue.*,acs.designation,af.func,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinred,$wherered);

      $redtitle = !empty($queryred[0]['title']) ? $queryred[0]['title']." " : '';
      $redmname = !empty($queryred[0]['mname']) ? $queryred[0]['mname'][0].". " : '';
      $redsuffix = !empty($queryred[0]['suffix']) ? " ".$queryred[0]['suffix'] : '';
      $rednm = str_replace('ñ', 'Ñ', $redtitle.$queryred[0]['fname']." ".$redmname.$queryred[0]['sname']);
      $redname = strtoupper($rednm.$redsuffix);

      $rred_xaxis = (!empty($queryred[0]['to_xaxis_r'])) ? $queryred[0]['to_xaxis_r'] : '60';
      $rred_yaxis = (!empty($queryred[0]['to_yaxis_r'])) ? $queryred[0]['to_yaxis_r'] : '235';
      $rred_width = (!empty($queryred[0]['to_width_r'])) ? $queryred[0]['to_width_r'] : '0';
      $rred_height = (!empty($queryred[0]['to_height_r'])) ? $queryred[0]['to_height_r'] : '11';

      $nred_xaxis = (!empty($queryred[0]['to_xaxis_n'])) ? $queryred[0]['to_xaxis_n'] : '60';
      $nred_yaxis = (!empty($queryred[0]['to_yaxis_n'])) ? $queryred[0]['to_yaxis_n'] : '235';
      $nred_width = (!empty($queryred[0]['to_width_n'])) ? $queryred[0]['to_width_n'] : '0';
      $nred_height = (!empty($queryred[0]['to_height_n'])) ? $queryred[0]['to_height_n'] : '11';

      $path = 'iis.emb.gov.ph/embis/Travel/PrintTO?sub_token='.$token;

      if(!empty($queryred[0]['userid'])){
        $html .='<br><br>
                <table style="font-family:times;">
                  <tr style="font-size:9px;">
                    <td style="width:98%;">Recommending approval:</td>
                  </tr>
                </table>
                <table style="font-family:times;">
                  ';
      }else{
        $html .='<br><br>
                <table style="font-family:times;">
                  <tr style="font-size:9px;">
                    <td style="width:98%;">Approved by:</td>
                  </tr>
                </table>
                <table style="font-family:times;">
                  ';
      }

        if($query[0]['travel_cat'] == 'No' AND $query[0]['region'] != 'CO'){ //National - Regions
            if($query[0]['status'] == 'On-Process'){ //If TO is still On process
              $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $nrd_xaxis, $nrd_yaxis-4, $nrd_width, $nrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
              $html .='
                <tr>
                  <td style="font-size:9px;font-family:times;text-align:center;width:350px;">
                    <br><br>
                    <u style="font-weight:bold;">'.$rdname.'</u><br>
                    <i>'.$queryrd[0]['designation'].'</i>
                    <br><br>
                    <u style="font-weight:bold;">'.$dname.'</u><br>
                    <i>'.$querydirector[0]['designation'].'</i>
                  </td>
                  <td style="text-align:center;width:150px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:100px;"></td>
                </tr>';
            }else{
              if($query[0]['userid'] == $queryrd[0]['userid']){ //Approved - If TO Creator is RD
                // $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$querydirector[0]['file_name'].'', $rd_xaxis, $rd_yaxis-4, $rd_width, $rd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                // $html .='
                //   <tr style="font-size:9px;font-family:times;text-align:center;">
                //   <td style="text-align:center;width:350px;"><br><br><br><br><u style="font-weight:bold;">'.$dname.'</u><br><i>'.$querydirector[0]['designation'].'</i></td>
                //     <td style="text-align:center;width:150px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:100px;"></td>
                //   </tr>';
                $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $rrd_xaxis, ($rrd_yaxis-6-4), $rrd_width, $rrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryred[0]['file_name'].'', $rred_xaxis, ($rred_yaxis+10-4), $rred_width, $rred_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                $pdf->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8', 145, 220, 35, 0, '', '', '', false, 300, '', false, false, '', false, false, false);
                $html .='
                  <tr><br>
                    <td style="font-size:9px;font-family:times;text-align:center;width:380px;">
                      <u style="font-weight:bold;">'.$rdname.'</u><br>
                      <i>'.$queryrd[0]['designation'].'</i><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-size:9px;font-family:times;width:380px;">
                      &nbsp;Approved by:<br>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-size:9px;font-family:times;text-align:center;width:380px;">
                      <u style="font-weight:bold;">'.$redname.'</u><br>
                      <i>'.$queryred[0]['designation'].'</i><br>
                    </td>
                  </tr>';
              }else{ //Approved - Normal User
                if(!empty($queryred[0]['userid'])){ //if RED is not empty
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $nrd_xaxis, $nrd_yaxis, $nrd_width, $nrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryred[0]['file_name'].'', ($nred_xaxis-33), ($nred_yaxis+9-4), $nred_width, $nred_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$querydirector[0]['file_name'].'', ($nd_xaxis+33), ($nd_yaxis+9-4), $nd_width, $nd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $pdf->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8', 145, 220, 35, 0, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $html .='
                    <tr><br>
                      <td style="font-size:9px;font-family:times;text-align:center;width:380px;">
                        <u style="font-weight:bold;">'.$rdname.'</u><br>
                        <i>'.$queryrd[0]['designation'].'</i><br>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size:9px;font-family:times;text-align:center;width:380px;">
                        &nbsp;Approved by:<br>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size:9px;font-family:times;text-align:center;width:190px;">
                        <u style="font-weight:bold;">'.$redname.'</u><br>
                        <i>'.$queryred[0]['designation'].'</i><br>
                      </td>
                      <td style="font-size:9px;font-family:times;text-align:center;width:190px;">
                        <u style="font-weight:bold;">'.$dname.'</u><br>
                        <i>'.$querydirector[0]['designation'].'</i><br>
                      </td>
                    </tr>';
                }else{
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $nrd_xaxis, $nrd_yaxis-4, $nrd_width, $nrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$querydirector[0]['file_name'].'', $nd_xaxis, $nd_yaxis-4, $nd_width, $nd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $html .='
                    <tr>
                      <td style="font-size:9px;font-family:times;text-align:center;width:350px;">
                        <br><br>
                        <u style="font-weight:bold;">'.$rdname.'</u><br>
                        <i>'.$queryrd[0]['designation'].'</i>
                        <br><br>
                        <u style="font-weight:bold;">'.$dname.'</u><br>
                        <i>'.$querydirector[0]['designation'].'</i>
                      </td>
                      <td style="text-align:center;width:150px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:100px;"></td>
                    </tr>';
                }
              }
            }


        }else{ //Regional
          if($query[0]['region'] != 'CO'){ //Regions
              // if($query[0]['userid'] == $queryrd[0]['userid']){ //If TO Creator is RD
              //   $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $rrd_xaxis, $rrd_yaxis, $rrd_width, $rrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
              //   $html .='
              //     <tr style="font-size:9px;font-family:times;text-align:center;">
              //     <td style="text-align:center;width:350px;"><br><br><br><br><u style="font-weight:bold;">'.$rdname.'</u><br><i>'.$queryrd[0]['designation'].'</i></td>
              //       <td style="text-align:center;width:150px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:100px;"></td>
              //     </tr>';
              // }else{
                if(!empty($queryred[0]['userid'])){ //if red is not empty
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $rrd_xaxis, ($rrd_yaxis-6-4), $rrd_width, $rrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryred[0]['file_name'].'', $rred_xaxis, ($rred_yaxis+10-4), $rred_width, $rred_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $pdf->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8', 145, 220, 35, 0, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $html .='
                    <tr><br>
                      <td style="font-size:9px;font-family:times;text-align:center;width:380px;">
                        <u style="font-weight:bold;">'.$rdname.'</u><br>
                        <i>'.$queryrd[0]['designation'].'</i><br>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size:9px;font-family:times;width:380px;">
                        &nbsp;Approved by:<br>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size:9px;font-family:times;text-align:center;width:380px;">
                        <u style="font-weight:bold;">'.$redname.'</u><br>
                        <i>'.$queryred[0]['designation'].'</i><br>
                      </td>
                    </tr>';
                }else{
                  $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryrd[0]['file_name'].'', $rrd_xaxis, $rrd_yaxis-2, $rrd_width, $rrd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
                  $html .='
                    <tr style="font-size:9px;font-family:times;text-align:center;">
                    <td style="text-align:center;width:350px;"><br><br><br><br><u style="font-weight:bold;">'.$rdname.'</u><br><i>'.$queryrd[0]['designation'].'</i></td>
                      <td style="text-align:center;width:150px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:100px;"></td>
                    </tr>';
                }
              // }

          }else{ //CO
            $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$querydirector[0]['file_name'].'', $rd_xaxis, ($rd_yaxis-4), $rd_width, $rd_height, '', '', '', false, 300, '', false, false, '', false, false, false);
            $html .='
              <tr style="font-size:9px;font-family:times;text-align:center;">
              <td style="text-align:center;width:350px;"><br><br><br><br><u style="font-weight:bold;">'.$dname.'</u><br><i>'.$querydirector[0]['designation'].'</i></td>
                <td style="text-align:center;width:150px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:100px;"></td>
              </tr>';
          }
        }

      if($query[0]['region'] == 'R11' OR $query[0]['travel_format'] == '2' OR $query[0]['travel_format'] == '3'){
        $whereuseresig = $this->db->where('ttl.userid = "'.$query[0]['userid'].'" AND ttl.er_no = "'.$query[0]['er_no'].'" AND ttl.region = "'.$query[0]['region'].'" AND oue.status = "Active" GROUP BY oue.file_name');
        $joinuseresig  = $this->db->join('to_trans_log AS ttl','ttl.userid = oue.userid','left');
        $queryuseresig = $this->Embismodel->selectdata('office_uploads_esignature AS oue','oue.file_name, oue.to_height_a, oue. to_width_a, oue.to_xaxis_a, oue.to_yaxis_a','',$joinuseresig,$whereuseresig);

        $useresig_xaxis = $queryuseresig[0]['to_xaxis_a'];
        $useresig_yaxis = $queryuseresig[0]['to_yaxis_a'];
        $useresig_width = $queryuseresig[0]['to_width_a'];
        $useresig_height = $queryuseresig[0]['to_height_a'];


        if(!empty($queryuseresig[0]['file_name'])){
          if($query[0]['travel_format'] == '3'){
            $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryuseresig[0]['file_name'].'', $useresig_xaxis, $useresig_yaxis+5, $useresig_width, $useresig_height, '', '', '', false, 300, '', false, false, '', false, false, false);
          }else{
            $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryuseresig[0]['file_name'].'', $useresig_xaxis, $useresig_yaxis-4, $useresig_width, $useresig_height, '', '', '', false, 300, '', false, false, '', false, false, false);
          }
        }
        $html .='
        </table>
        <br>
        <table style="font-family:times;">
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
          <tr style="font-size:9px;text-align:center;font-weight:bold;">
            <td style="width:98%;"><br><br>AUTHORIZATION<br></td>
          </tr>
        </table>';
        $html .='
        <br>
        <table style="font-family:times;">
          <tr style="font-size:8px;text-align:justify;font-weight:bold;">
            <td style="width:98%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby authorize the Accountant to deduct the corresponding amount of the unliquidated cash advance from my succeeding salary for my failure to liquidate this travel within the prescribed thirty-day period upon return to my permanent official station pursuant to Item 5-1-3 COA Circular 97-002 dated February 10, 1997 and Sec. 16 of EO No. 248 dated May 29, 1995.</td>
          </tr>
        </table>';

        if($query[0]['travel_format'] == '3'){
          $html .='
          <br><br>
          <table style="font-family:times;">
            <tr style="font-size:8px;text-align:justify;font-weight:bold;">
              <td style="width:98%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I further certify that I am fit to travel to the above-mentioned places and conducted the above mentioned purpose of travel. That I commit to abide to the basic safety/health protocol of wearing of mask at all times, regularly disinfecting my hands and washing with soap and water, and I will not expose to a group of more than five(5) people and voluntarily have my self quarantine if necessary.</td>
            </tr>
          </table>';
          $html .='
          <table style="font-family:times;">
            <tr><td style="width:98%;"><br></td></tr>
            <tr style="font-size:8px;text-align:justify;">
              <td style="width:30%;"></td>
              <td style="width:38%;"></td>
              <td style="width:30%;"></td>
            </tr>
            <tr style="font-size:8px;text-align:center;">
              <td style="width:30%;"></td>
              <td style="width:38%;border-top:1px solid #000;">Signature of Employee</td>
              <td style="width:30%;"></td>
            </tr>
          </table>';
        }else{
          $html .='
          <table style="font-family:times;">
            <tr><td style="width:98%;"><br><br></td></tr>
            <tr style="font-size:8px;text-align:justify;">
              <td style="width:30%;"></td>
              <td style="width:38%;"></td>
              <td style="width:30%;"></td>
            </tr>
            <tr style="font-size:8px;text-align:center;">
              <td style="width:30%;"></td>
              <td style="width:38%;border-top:1px solid #000;">Signature of Employee</td>
              <td style="width:30%;"></td>
            </tr>
          </table>';
        }

      }else{
        $html .='
        </table>
        <br>
        <table style="font-family:times;">
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
          <tr style="font-size:8px;text-align:justify;font-weight:bold;">
            <td style="width:98%;">Subject to the condition that (1)official/employee concerned has no outstanding cash advance on previous travel, (2)he/she shall settle the cash advance that may be given him/her present hereto within thirty (30) Days after date of return to permanent station and, (3)other applicable provisions of COA Circular N0.96-004,dated April 19,1996.</td>
          </tr>
        </table>';
      }

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output();
  }

}
