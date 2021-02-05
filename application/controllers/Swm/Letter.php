<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Letter extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->library('Pdf');

  }

  function pdf($tokenget = ''){

    $token = $this->encrypt->decode($tokenget);

    $where_nov = $this->db->where('snl.cnt = "'.$token.'"');
    $join_nov = $this->db->join('dms_company AS dc','dc.emb_id = snl.lgu_patrolled_id','left');
    $select_nov = $this->Embismodel->selectdata('sweet_nov_letter AS snl', 'snl.*, dc.province_name','',$join_nov,$where_nov);

    $whereheader  = $this->db->where('oudh.region = "'.$select_nov[0]['region'].'" AND oudh.office = "'.$this->session->userdata('office').'" AND oudh.cnt = (SELECT MAX(oudhh.cnt) FROM office_uploads_document_header AS oudhh WHERE oudhh.region = "'.$select_nov[0]['region'].'"  AND oudhh.office = "'.$this->session->userdata('office').'")');
    $selectheader = $this->Embismodel->selectdata('office_uploads_document_header AS oudh','oudh.*','',$whereheader);

    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetTitle('NOV LETTER - '.$select_nov[0]['trans_no'].'');
    $pdf->SetMargins(10, 5, 10, 0);

    $pdf->SetCreator(PDF_CREATOR);

    // Add a page
    $pdf->AddPage();


      $html ='
        <table style="width:100%;">
          <tr>
            <td><img class="head" src="http://iis.emb.gov.ph/iis-images/document-header/'.$selectheader[0]['file_name'].'"></td>
          </tr>
        </table>';

      $html .='
        <table style="width:100%;font-family:arial,sans-serif;;">
          <tr style="font-weight:bold;font-size:10px;">
            <td style="width:6%;">ID #:</td>
            <td style="border-bottom: 1px solid #000;width:25%;">'.$select_nov[0]['lgu_patrolled_id'].'</td>
          </tr>
          <tr style="font-weight:bold;font-size:10px;">
            <td style="width:6%;">IIS #:</td>
            <td style="border-bottom: 1px solid #000;width:25%;">'.$select_nov[0]['trans_no'].'</td>
          </tr>
        </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;;">
        <tr style="font-weight:bold;font-size:10px;">
          <td style="width:20%;">'.date('F d, Y', strtotime($select_nov[0]['date_created'])).'</td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;;">
        <tr style="font-weight:bold;font-size:10px;">
          <td style="width:50%;">'.$select_nov[0]['address_to'].'</td>
        </tr>
        <tr style="font-size:10px;">
          <td style="width:50%;">'.$select_nov[0]['designation'].'</td>
        </tr>
        <tr style="font-size:10px;">
          <td style="width:50%;">'.$select_nov[0]['muncity'].'</td>
        </tr>
        <tr style="font-size:10px;">
          <td style="width:50%;">Province of '.ucwords(strtolower($select_nov[0]['province_name'])).'</td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;;">
        <tr style="font-weight:bold;font-size:10px;text-align:center;">
          <td style="width:100%;"><u>SUBJECT: NOTICE OF VIOLATION ON RA 9003 (SWEET-ENMO REPORT)</u></td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;;">
        <tr style="font-weight:bold;font-size:10px;">
          <td style="width:50%;">Dear '.$select_nov[0]['designation'].' '.$addressto = ((!empty($select_nov[0]['address_to_suffix'])) ? $select_nov[0]['address_to_sname'].' '.$select_nov[0]['address_to_suffix'] : $select_nov[0]['address_to_sname']).',</td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;line-height: 1.5;">
        <tr style="font-size:10px;text-align:justify;">
          <td style="width:100%;">In order to strengthen the implementation of Republic Act 9003, otherwise known as the "Ecological Solid Waste Management Act of 2000", the DENR-Environmental Management Bureau established the <b>SOLID WASTE ENFORCEMENT AND EDUCATORS PROGRAM - ENVIRONMENTAL MONITORING OFFICERS</b>. This aims to monitor the compliance of LGUs specifically on the following prohibited acts under Chapter VI of RA 9003, or the Penal Provisions:</td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;line-height: 1.5;">
        <tr style="font-size:10px;">
          <td style="border:1px solid #000;width:70%;text-align:center;"><b>Prohibited Act</b></td>
          <td style="border:1px solid #000;width:30%;text-align:center;"><b>Section Chapter VI, RA 9003</b></td>
        </tr>';

        $explodevo = explode(';', $select_nov[0]['violations_observed_desc']);
        $orderbyvo = $this->db->order_by('svo.voorder','ASC');
        for ($vo=0; $vo < count($explodevo); $vo++) {
          if(!empty(trim($explodevo[$vo]))){
            $wherevo = $this->db->or_where('svo.section = "'.$explodevo[$vo].'"');
          }
        }
        $selectvo = $this->Embismodel->selectdata('sweet_violations_observed AS svo','','',$wherevo,$orderbyvo);

        for ($vd=0; $vd < sizeof($selectvo); $vd++) {
          $html .=
          '<tr style="font-size:10px;">
              <td style="border:1px solid #000;width:70%;">'.$selectvo[$vd]['prohibited_act'].'</td>
              <td style="border:1px solid #000;width:30%;text-align:center;">'.$selectvo[$vd]['section'].';</td>
            </tr>';
        }

      $html .='</table><br><br>';

      $wherestmnt = '';
      $rncntr = 0;
      for ($rn=0; $rn < $select_nov[0]['report_number']; $rn++) {
        $rncntr++;
        $whrstmntcon = ($select_nov[0]['report_number'] == $rncntr) ? '' : ' OR ';
        $wherestmnt .= 'sf.report_number = "'.$rncntr.'"'.$whrstmntcon;
      }
      $wheremonitoringhistory = $this->db->where('('.$wherestmnt.')');

      $wheremonitoringhistory = $this->db->where('sf.trans_no = "'.$select_nov[0]['trans_no'].'" ORDER BY sf.report_number ASC');
      $selectmonitoringhistory = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.date_patrolled, sf.time_patrolled, sf.report_number','',$wheremonitoringhistory);

      $datemonitored = '';
      $counter = 0;
      $sizeofarray = sizeof($selectmonitoringhistory);
      for ($s=0; $s < sizeof($selectmonitoringhistory); $s++) {
        if(!empty($selectmonitoringhistory[$s]['report_number'])){
          $counter++;
          if($counter == $sizeofarray){
            $cmnd = '';
          }else if($counter == ($sizeofarray-1)){
            $cmnd = ' and ';
          }else{
            $cmnd = ', ';
          }
          $a = $selectmonitoringhistory[$s]['report_number'];
          $rn = $a.substr(date('jS', mktime(0,0,0,1,($a%10==0?9:($a%100>20?$a%10:$a%100)),2000)),-2).' monitoring';
          $datemonitored .= date('F d, Y', strtotime($selectmonitoringhistory[$s]['date_patrolled'])).' at '.date("h:i a", strtotime($selectmonitoringhistory[$s]['time_patrolled'])).' ( '.$rn.' )'.$cmnd;
        }
      }

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;line-height: 1.5;">
        <tr style="font-size:10px;text-align:justify;">
          <td style="width:100%;">On <b>'.$datemonitored.'</b> our <b>SWEET - EnMOs</b> spotted its <b>violation</b> along <b>Barangay road and open spaces</b> (photos attached). This is a violation of Chapter VI of RA 9003 and City/Municipal SWM Ordinance (as applicable).</td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;line-height: 1.5;">
        <tr style="font-size:10px;text-align:justify;">
          <td style="width:100%;">Thus, you are directed to remove the said solid wastes and to closely monitor and apprehend illegal dumping of wastes within <b>'.$select_nov[0]['waste_removal'].'</b>. Kindly email said official report to <b>'.$select_nov[0]['swm_email'].'</b>. Please see enclosed some pictures recently taken in the affected area.</td>
        </tr>
      </table><br><br>';

      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;line-height: 2.0;">
        <tr style="font-size:10px;text-align:justify;">
          <td style="width:100%;">As our partner in implementing RA 9003, we look forward to your cooperation in the protection of our environment.</td>
        </tr>
        <tr style="font-size:10px;text-align:justify;">
          <td style="width:100%;">Should any further assistance be needed, please feel free to call or fax us at <b>'.$select_nov[0]['swm_contactinfo'].'</b>.</td>
        </tr><br>
        <tr style="font-size:10px;text-align:justify;">
          <td style="width:100%;">Very truly yours,</td>
        </tr>
      </table><br><br><br>';


        $whererd = $this->db->where('af.stat = "1" AND acs.verified = "1" AND af.func = "Regional Director" AND oue.status = "Active" AND af.region = "'.$select_nov[0]['region'].'"');
        $joinrd  = $this->db->join('office_uploads_esignature AS oue','oue.userid = acs.userid','left');
        $joinrd = $this->db->join('acc_function AS af','af.userid = acs.userid','left');
        $selectrd = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, acs.designation, oue.file_name, oue.swm_nov_height, oue.swm_nov_width, oue.swm_nov_yaxis, oue.swm_nov_xaxis','',$joinrd,$whererd);
        $prefix = (!empty($selectrd[0]['title'])) ? $selectrd[0]['title'].' ' : '';
        $mname = (!empty($selectrd[0]['mname'])) ? $selectrd[0]['mname'][0].'. ' : '';
        $suffix = (!empty($selectrd[0]['suffix'])) ? ' '.$selectrd[0]['suffix'] : '';
        $rdname = $prefix.$selectrd[0]['fname'].' '.$mname.$selectrd[0]['sname'].$suffix;
      if($select_nov[0]['status'] == 'Signed Document'){
        $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectrd[0]['file_name'].'', $selectrd[0]['swm_nov_xaxis'], $selectrd[0]['swm_nov_yaxis'], $selectrd[0]['swm_nov_width'], $selectrd[0]['swm_nov_height'], '', '', '', false, 300, '', false, false, '', false, false, false);
      }
      $html .=
      '<table style="width:100%;font-family:arial,sans-serif;line-height: 1.5;">
        <tr style="font-size:10px;font-weight:bold;">
          <td style="width:100%;"><u>'.$rdname.'</u></td>
        </tr>
        <tr style="font-size:10px;">
          <td style="width:100%;"><i>'.$selectrd[0]['designation'].'</i></td>
        </tr>
      </table><br><br>';

      if(!empty($select_nov[0]['cc_office']) AND !empty($select_nov[0]['cc_address'])){
        $html .=
        '<table style="width:100%;font-family:arial,sans-serif;line-height: 1.5;">
          <tr style="font-size:9px;">
            <td style="width:100%;">Cc:</td>
          </tr>
          <tr style="font-size:9px;">
            <td style="width:100%;">'.$select_nov[0]['cc_office'].'</td>
          </tr>
          <tr style="font-size:9px;">
            <td style="width:100%;">'.$select_nov[0]['cc_address'].'</td>
          </tr>
        </table>';
      }

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->AddPage();

    $wherelog = $this->db->where('sfl.trans_no = "'.$select_nov[0]['trans_no'].'" AND sfl.report_number = "'.$select_nov[0]['report_number'].'"');
    $selectsweetlog = $this->Embismodel->selectdata('sweet_form_log AS sfl','','',$wherelog);

    $html ='
      <table style="width:100%;">
        <tr>
          <td><img class="head" src="http://iis.emb.gov.ph/iis-images/document-header/'.$selectheader[0]['file_name'].'"></td>
        </tr>
      </table><br><br>';

    $html .='
      <table style="width:100%;font-family:arial,sans-serif;">
        <tr style="font-size:10px;">
          <td style="width:3%;">I.</td>
          <td>Type of Monitoring (pls. check, fill up as appropriate)</td>
        </tr>
      </table><br><br>';

    $orderstm = $this->db->order_by('stm.tomorder','ASC');
    $querystm = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stm','stm.*','',$orderstm);

    for($stm=0; $stm < sizeof($querystm); $stm++){

      $arraylisttom = explode(";",$selectsweetlog[0]['type_of_monitoring']);

      if(in_array($querystm[$stm]['tomid'], $arraylisttom)){
        $ifcheckedtom = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">';
      }else{
        $ifcheckedtom = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
      }

      if($querystm[$stm]['tomid'] == '2'){
        $dtfm = ($selectsweetlog[0]['type_of_monitoring'] == '2') ? date('F d, Y', strtotime($selectsweetlog[0]['date_of_first_monitoring'])) : "";
        $dtsm = ($selectsweetlog[0]['type_of_monitoring'] == '2') ? date('F d, Y', strtotime($selectsweetlog[0]['date_of_second_monitoring'])) : "";
        $dtlm = ($selectsweetlog[0]['type_of_monitoring'] == '2') ? date('F d, Y', strtotime($selectsweetlog[0]['date_of_last_monitoring'])) : "";

          $htmlva  ='<table style="width:100%;font-family:arial,sans-serif;">';
          $htmlva .='<tr style="font-size:10px;">
                      <td style="width:160px;"><ul><li>Date of first monitoring:</li></ul></td>
                      <td style="border-bottom: 1px solid black;width:170px;text-align:center;">'.$dtfm.'</td>
                      <td></td>
                    </tr>';
          if($selectsweetlog[0]['report_number'] == 2){
          $htmlva .='<tr style="font-size:10px;">
                      <td style="width:160px;"><ul><li>Date of last monitoring:</li></ul></td>
                      <td style="border-bottom: 1px solid black;width:170px;text-align:center;">'.$dtsm.'</td>
                      <td></td>
                    </tr>';
          }else{
          $htmlva .='<tr style="font-size:10px;">
                      <td style="width:160px;"><ul><li>Date of second monitoring:</li></ul></td>
                      <td style="border-bottom: 1px solid black;width:170px;text-align:center;">'.$dtsm.'</td>
                      <td></td>
                    </tr>';
          $htmlva .='<tr style="font-size:10px;">
                      <td style="width:160px;"><ul><li>Date of last monitoring:</li></ul></td>
                      <td style="border-bottom: 1px solid black;width:170px;text-align:center;">'.$dtlm.'</td>
                      <td></td>
                    </tr>';
          }
          $htmlva .='</table><br>';
      }else{
          $htmlva = '';
      }

      if($querystm[$stm]['tomid'] == '3'){
        $dtfm = ($selectsweetlog[0]['type_of_monitoring'] == '3') ? date('F d, Y', strtotime($selectsweetlog[0]['date_of_first_monitoring'])) : "";
        $dtlm = ($selectsweetlog[0]['type_of_monitoring'] == '3') ? date('F d, Y', strtotime($selectsweetlog[0]['date_of_last_monitoring'])) : "";
        $dtn  = ($selectsweetlog[0]['type_of_monitoring'] == '3' AND !empty($selectsweetlog[0]['date_of_issuance_of_notice'])) ? date('F d, Y', strtotime($selectsweetlog[0]['date_of_issuance_of_notice'])) : "";
        $nd   = ($selectsweetlog[0]['type_of_monitoring'] == '3') ? $selectsweetlog[0]['number_dumping'] : "";
        $na   = ($selectsweetlog[0]['type_of_monitoring'] == '3') ? $selectsweetlog[0]['number_activity'] : "";
          $htmlvan ='
          <table style="width:100%;font-family:arial,sans-serif;">
            <tr style="font-size:10px;">
              <td style="width:160px;"><ul><li>Date of first monitoring:</li></ul></td>
              <td style="border-bottom: 1px solid black;text-align:center;width:170px;">'.$dtfm.'</td>
              <td></td>
            </tr>
            <tr style="font-size:10px;">
              <td style="width:160px;"><ul><li>Date of last monitoring:</li></ul></td>
              <td style="border-bottom: 1px solid black;text-align:center;width:170px;">'.$dtlm.'</td>
              <td></td>
            </tr>
            <tr style="font-size:10px;">
              <td style="width:200px;"><ul><li>Date of issuance of last Notice:</li></ul></td>
              <td style="border-bottom: 1px solid black;text-align:center;width:130px;">'.$dtn.'</td>
              <td></td>
            </tr>
            <tr style="font-size:10px;">
              <td style="width:327px;"><ul><li>Number of times <b><i>same site</i></b> is found with illegal dumping:</li></ul></td>
              <td style="border-bottom: 1px solid black;text-align:center;width:50px;">'.$nd.'</td>
              <td></td>
            </tr>
            <tr style="font-size:10px;">
              <td style="width:327px;"><ul><li>Number of times <b><i>same site</i></b> is found with open burning activity:</li></ul></td>
              <td style="border-bottom: 1px solid black;text-align:center;width:50px;">'.$na.'</td>
              <td></td>
            </tr>
          </table><br><br>';
      }else{
          $htmlvan = '';
      }

      $html .='
      <table style="width:100%;font-family:arial,sans-serif;">
       <tr style="font-size:10px;">
        <td style="width:20px;">'.$ifcheckedtom.'</td>
        <td style="width:300px;">'.$querystm[$stm]['tomtitle'].'</td>
       </tr>
      </table>'.$htmlva.$htmlvan;

    }

    $html .='
      <table style="width:100%;font-family:arial,sans-serif;">
        <tr style="font-size:10px;">
          <td style="width:3%;">II.</td>
          <td>Photo documentation/pictures</td>
        </tr>
      </table><br><br>';

      $report_number = $selectsweetlog[0]['report_number'] - 1;
      $whereattachmentsleft = $this->db->where('sfa.trans_no = "'.$selectsweetlog[0]['trans_no'].'" AND sfa.report_number = "'.$report_number.'"');
      $joinattachmentsleft = $this->db->join('sweet_form_log AS sfl','sfl.trans_no = sfa.trans_no','left');
      $queryattachmentsleft = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*,sfl.photo_remarks,sfl.date_created,sfl.region','',$joinattachmentsleft,$whereattachmentsleft);
      $attachmentpathleft   = "http://iis.emb.gov.ph/iis-images/sweet_report/".date("Y", strtotime($queryattachmentsleft[0]['date_created']))."/".$queryattachmentsleft[0]['region']."/".$queryattachmentsleft[0]['trans_no']."/".$queryattachmentsleft[0]['attachment_name'];

      $whereattachments = $this->db->where('sfa.trans_no = "'.$selectsweetlog[0]['trans_no'].'" AND sfa.report_number = "'.$selectsweetlog[0]['report_number'].'"');
      $queryattachments = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*','',$whereattachments);
      $attachmentpath   = "http://iis.emb.gov.ph/iis-images/sweet_report/".date("Y", strtotime($selectsweetlog[0]['date_created']))."/".$selectsweetlog[0]['region']."/".$selectsweetlog[0]['trans_no']."/".$queryattachments[0]['attachment_name'];

      $html .='&nbsp;&nbsp;<img style="border:1px solid #000; width:260px; height: 260px;" src="'.$attachmentpathleft.'">&nbsp;<img style="border:1px solid #000; width:260px; height: 260px;" src="'.$attachmentpath.'"><br>';

      $html .=' <table style="width:100%;font-family:arial,sans-serif;">
                 <tr style="font-size:10px;">
                  <td style="width:50%;text-align:center;"><b>Figure 1</b></td>
                  <td style="width:50%;text-align:center;"><b>Figure 2</b></td>
                 </tr>
                </table><br><br>';

      $html .='<table style="width:100%;font-family:arial,sans-serif;">
               <tr style="font-size:10px;">
               <td style="width:1%;">.</td>
                <td style="text-align:justify;width:49%;"><b>Figure 1:</b>&nbsp;<span>'.($queryattachmentsleft[0]['photo_remarks']).'</span></td>
                <td style="text-align:justify;width:50%;"><b>Figure 2:</b>&nbsp;<span>'.($selectsweetlog[0]['photo_remarks']).'</span></td>
               </tr>
              </table><br><br>';

    $pdf->writeHTML($html, true, false, true, false, '');
    //Close and output PDF document
    $pdf->Output();
  }
}
