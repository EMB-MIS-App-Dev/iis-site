<?php

class PrintAir extends CI_Controller
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

    $join  = $this->db->join('acc_credentials AS acs','acs.userid = tt.userid','left');
    $join  = $this->db->join('acc_xdvsion AS xn','xn.divno = tt.divno','left');
    $join  = $this->db->join('acc_xsect AS xt','xt.secno = tt.secno','left');
    $join  = $this->db->join('acc_plantillapostn AS pn','pn.planpstn_id = tt.plantilla_pos','left');
    $join  = $this->db->join('to_ticket_request AS ttr','ttr.er_no = tt.er_no','left');
    $join  = $this->db->join('acc_credentials AS acs2','acs2.userid = ttr.accountant_id','left');
    $query = $this->Embismodel->selectdata('to_trans AS tt','tt.*,acs.fname,acs.mname,acs.sname,acs.suffix,acs.plantilla_itemno,xn.divname,xt.sect,pn.planpstn_desc,ttr.expiry_date,ttr.ticket_office,ttr.amount,acs2.fname AS fname2,acs2.mname AS mname2,acs2.sname AS sname2','',$join,$where);
    // echo $this->db->last_query();
    if(empty($query[0]['toid'])){ echo "<script>alert('Please re-login. Thank you.')</script>"; echo "<script>window.location.href='".base_url()."Index/logout_user'</script>"; }

    if(empty($query[0]['expiry_date'])){ echo "<script>alert('Ticket still not available.')</script>"; echo "<script>window.location.href='".base_url()."Travel/Dashboard'</script>"; }

    if(!empty($query[0]['mname'])){ $mname = $query[0]['mname'][0].". "; }else{ $mname = ""; }
    if(!empty($query[0]['suffix'])){ $suffix = " ".$query[0]['suffix']; }else{ $suffix = ""; }
    $name = ucwords($query[0]['fname']." ".$mname.$query[0]['sname'].$suffix);

    if(!empty($query[0]['mname2'])){ $mname2 = $query[0]['mname2'][0].". "; }else{ $mname2 = ""; }
    if(!empty($query[0]['suffix2'])){ $suffix2 = " ".$query[0]['suffix2']; }else{ $suffix2 = ""; }
    $nameaccountant = ucwords($query[0]['fname2']." ".$mname2.$query[0]['sname2'].$suffix2);

    if(!empty($query[0]['divcode'])){ $divcode = ucwords($query[0]['divcode']); }else{ $divcode = "N/A"; }
    if(!empty($query[0]['divname'])){ $divname = $query[0]['divname']; }else{ $divname = "N/A"; }
    if(!empty($query[0]['sect'])){ $sect = ucwords($query[0]['sect']); }else{ $sect = "N/A"; }

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

    if(!empty($query[0]['per_diem'])){ $per_diem = ucwords($query[0]['per_diem']); }else{ $per_diem = "N/A"; }
    if(!empty($query[0]['assistant'])){ $assistant = ucwords($query[0]['assistant']); }else{ $assistant = "N/A"; }

    if($query[0]['region'] == 'CO'){
      $wheredirector = $this->db->where('af.func','Director');
      $wheredirector = $this->db->where('af.stat','1');
      $wheredirector = $this->db->where('oue.status','Active');
      $joindirector  = $this->db->join('office_uploads_esignature AS oue','oue.userid = af.userid','left');
      $joindirector  = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
      $queryapprovedby = $this->Embismodel->selectdata('acc_function AS af','oue.*,acs.designation,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joindirector,$wheredirector);
      $fxaxis = (!empty($queryapprovedby[0]['to_xaxis_n'])) ? ($queryapprovedby[0]['to_xaxis_n']+93) : '153';
      $fyaxis = (!empty($queryapprovedby[0]['to_yaxis_n'])) ? ($queryapprovedby[0]['to_yaxis_n']-121) : '114';
      $width = (!empty($queryapprovedby[0]['to_width_n'])) ? $queryapprovedby[0]['to_width_n'] : '45';
      $height = (!empty($queryapprovedby[0]['to_height_n'])) ? $queryapprovedby[0]['to_height_n'] : '11';

      $sxaxis = (!empty($queryapprovedby[0]['to_xaxis_n'])) ? ($queryapprovedby[0]['to_xaxis_n']+93) : '153';
      $syaxis = (!empty($queryapprovedby[0]['to_yaxis_n'])) ? ($queryapprovedby[0]['to_yaxis_n']-58) : '114';
    }else{
      $whererd = $this->db->where('af.func','Regional Director');
      $whererd = $this->db->where('af.region',$query[0]['region']);
      $whererd = $this->db->where('af.stat','1');
      $whererd = $this->db->where('oue.status','Active');
      $joinrd  = $this->db->join('office_uploads_esignature AS oue','oue.userid = af.userid','left');
      $joindirector  = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
      $queryapprovedby = $this->Embismodel->selectdata('acc_function AS af','oue.*,acs.designation,acs.title,acs.fname,acs.mname,acs.sname,acs.suffix','',$joinrd,$whererd);
      $fxaxis = (!empty($queryapprovedby[0]['to_xaxis_n'])) ? ($queryapprovedby[0]['to_xaxis_n']+96) : '153';
      $fyaxis = (!empty($queryapprovedby[0]['to_yaxis_n'])) ? ($queryapprovedby[0]['to_yaxis_n']-109) : '114';
      $width = (!empty($queryapprovedby[0]['to_width_n'])) ? $queryapprovedby[0]['to_width_n'] : '45';
      $height = (!empty($queryapprovedby[0]['to_height_n'])) ? $queryapprovedby[0]['to_height_n'] : '11';

      $sxaxis = (!empty($queryapprovedby[0]['to_xaxis_n'])) ? ($queryapprovedby[0]['to_xaxis_n']+96) : '153';
      $syaxis = (!empty($queryapprovedby[0]['to_yaxis_n'])) ? ($queryapprovedby[0]['to_yaxis_n']-45) : '114';
    }

    $dtitle = !empty($queryapprovedby[0]['title']) ? $queryapprovedby[0]['title']." " : '';
    $dmname = !empty($queryapprovedby[0]['mname']) ? $queryapprovedby[0]['mname'][0].". " : '';
    $dsuffix = !empty($queryapprovedby[0]['suffix']) ? " ".$queryapprovedby[0]['suffix'] : '';
    $dnm = $dtitle.$queryapprovedby[0]['fname']." ".$dmname.$queryapprovedby[0]['sname'];
    $nameofhead = ucwords($dnm).$dsuffix;

    $path = 'iis.emb.gov.ph/embis/Travel/PrintAir?sub_token='.$token;
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 5, 10, 0);
    $pdf->SetTitle('TRAVEL ORDER - '.$query[0]['toid'].'');
    $pdf->SetCreator(PDF_CREATOR);

    // Add a page
    $pdf->AddPage();

      $html =
      '
        <img class="head" src="http://iis.emb.gov.ph/iis-images/headCO.gif">
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
            <td style="width:100%;">To: <b><u>'.$name.'</u></b>, <i><b>'.$divname.'.</b></i></td>
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
            <td style="width:82%;font-weight:bold;height:35px;">'.str_replace('Array','',$query[0]['destination']).'</td>
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
          <tr style="font-size:12px;line-height: 1.6;">
            <td style="width:99%;border-bottom-width: 1px;height:25 px;"></td>
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
          </tr>';
    $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryapprovedby[0]['file_name'].'', $fxaxis, $fyaxis, $width, $height, '', '', '', false, 300, '', false, false, '', false, false, false);
    $html .='
          <tr>
            <td style="width:347px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:50px;"></td>
            <td style="width:200px;text-align:center;font-size:11px;"><br><br>
            <u><b>'.$nameofhead.'</b></u><br>
            <i>'.$queryapprovedby[0]['designation'].'</i>
            </td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;border-bottom-width: 1px;"> </td>
          </tr>
        </table>

        <table style="font-family:times;" border="0">
          <tr style="font-weight:bold;font-size:13px;text-align:center;line-height:200%;">
            <td>TRANSPORTATION ORDER</td>
          </tr>
        </table>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Expiry Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['expiry_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">To</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.ucfirst($query[0]['ticket_office']).' Ticket Office</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;"></td>
            <td style="width:2%;"></td>
            <td style="width:82%;">Please issue travel ticket to:&nbsp;&nbsp;<u style="font-weight:bold;">'.$name.'</u></td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;"></td>
            <td style="width:2%;"></td>
            <td style="width:82%;">in the amount of <u style="font-weight:bold;">'.$query[0]['amount'].' pesos only</u> chargeable against <u style="font-weight:bold;">EMB FUNDS</u>. </td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:100%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved by:</td>
          </tr>';
    $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$queryapprovedby[0]['file_name'].'', $sxaxis, $syaxis, $width, $height, '', '', '', false, 300, '', false, false, '', false, false, false);
    $html .='
          <tr>
            <td style="width:347px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$path.'%2F&choe=UTF-8" style="width:50px;"></td>
            <td style="width:200px;text-align:center;font-size:11px;"><br><br>
            <u><b>'.$nameofhead.'</b></u><br>
            <i>'.$queryapprovedby[0]['designation'].'</i>
            </td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;border-bottom-width: 1px;"></td>
          </tr>
        </table>

        <table style="font-family:times;width:99%;" border="0">
          <tr style="font-size:11px;">
            <td style="width:100%;"><br></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:100%;">IN CASE OF CREDIT: Certification as to Availability of Funds</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:72%;"></td>
            <td style="width:28%;border-bottom-width: 0.5px;"><b style="text-align:center;">'.$nameaccountant.'</b></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:72%;"></td>
            <td style="width:28%;"><span style="text-align:center;"><i>Chief Accountant</i></span></td>
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
          <tr style="font-size:11px;">
            <td style="width:100%;"><br></td>
          </tr>
          <tr>
            <td style="width:72%;"></td>
            <td style="width:28%;border-bottom-width: 0.5px;font-size:11pt;"><b style="text-align:center;">'.$name.'</b></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:72%;"></td>
            <td style="width:28%;"><span style="text-align:center;"><i>'.$position.'</i></span></td>
          </tr>
        </table>

      ';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output();
  }


}
