<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Form extends CI_Controller
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

  function index(){
    if(!empty($this->input->get('swtoken'))){
      $explodedata = explode('$33p',$this->input->get('swtoken'));
      $wheresweet = $this->db->where('sf.trans_no = "'.$this->encrypt->decode($explodedata[0]).'" AND sf.report_number = "'.str_replace('/','',$explodedata[1]).'"');
    }else{
      if(!empty($this->input->get('cnt'))){
        $trans_no = $this->input->get('token');
        $report_number = $this->input->get('rn');
        $cnt = $this->input->get('cnt');
        $wheresweet = $this->db->where('sf.trans_no = "'.$trans_no.'" AND sf.report_number = "'.$report_number.'" AND sf.cnt = "'.$cnt.'"');
      }else{
        $trans_no = $this->encrypt->decode($this->input->get('token'));
        $report_number = $this->encrypt->decode($this->input->get('rn'));
        $wheresweet = $this->db->where('sf.trans_no = "'.$trans_no.'" AND sf.report_number = "'.$report_number.'"');
      }
    }

    $querysweet = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.*','',$wheresweet);

    $qraddress = 'iis.emb.gov.ph/embis/Swm/Form?swtoken='.$querysweet[0]['sw_token'].'$33p'.$report_number;

    $street = (!empty($querysweet[0]['street'])) ? $querysweet[0]['street'] : "-";

    $whereaddress = $this->db->where('dc.emb_id',$querysweet[0]['lgu_patrolled_id']);
    $joinaddress  = $this->db->join('acc_region AS ar','ar.rgnnum = dc.region_name','left');
    $queryaddress = $this->Embismodel->selectdata('dms_company AS dc','dc.city_name, dc.province_name, ar.rgnnumeral, ar.rgnname','',$whereaddress);

    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 5, 10, 0);

    $pdf->SetCreator(PDF_CREATOR);

    // Add a page
    $pdf->AddPage();


      $html =
      '
        <img class="head" src="http://iis.emb.gov.ph/iis-images/document-header/'.$querysweet[0]['header'].'">
        <br><br>
        <table style="width:100%;font-family:times;text-align:center;">
          <tr style="font-weight:bold;font-size:12px;">
            <td>SWEET-EnMOs FIELD INVESTIGATION REPORT</td>
          </tr>
          <tr>
            <td style="font-size:12px;"></td>
          </tr>
        </table>
        <br><br>

        <table style="width:100%;font-family:arial,sans-serif;font-size:10px;">
           <tr>
            <td style="width:450px;"><br><br><br>I.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Patrolled:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('F d, Y', strtotime($querysweet[0]['date_patrolled'])).'<br>II.&nbsp;&nbsp;&nbsp;&nbsp;Time Patrolled:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("h:i:s A", strtotime($querysweet[0]['time_patrolled'])).'
            </td>
            <td style="width:75px;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2F'.$qraddress.'%2F&choe=UTF-8" style="width:100px;"></td>
          </tr>
        </table>
        <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="width:20px;">II.</td>
            <td style="width:80px;">LGU Patrolled:</td>
          </tr>
        </table>
        <br><br>
        <table style="width:100%;font-family:arial,sans-serif;border:1px solid black;">
          <tr style="font-size:10px;">
            <td style="border:1px solid black;width:170px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City / Municipality</td>
            <td style="border:1px solid black;font-weight:bold;width:362px;font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.trim($queryaddress[0]['city_name']).'</td>
          </tr>
          <tr style="font-size:10px;">
            <td style="border:1px solid black;width:170px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Province</td>
            <td style="border:1px solid black;font-weight:bold;width:362px;font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.trim($queryaddress[0]['province_name']).'</td>
          </tr>
          <tr style="font-size:10px;">
            <td style="border:1px solid black;width:170px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region</td>
            <td style="border:1px solid black;font-weight:bold;width:362px;font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.trim($queryaddress[0]['rgnnumeral']).'</td>
          </tr>
        </table>
        <br><br>
        <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="width:20px;">III.</td>
            <td style="width:150px;">Violation(s) Observed:</td>
          </tr>
        </table>
        <br><br>
        <table style="width:100%;font-family:arial,sans-serif;border:1px solid black;text-align:center;">
          <tr style="font-size:10px;">
            <td style="border:1px solid black;width:110px;font-weight:bold;">Check (<span style="font-family:zapfdingbats;">3</span>) as appropriate</td>
            <td style="width:312px;font-weight:bold;">Prohibited Act</td>
            <td style="border:1px solid black;width:110px;font-weight:bold;">Section Chapter VI,<br> RA 9003</td>
          </tr>
        </table>
        <table style="width:100%;font-family:arial,sans-serif;text-align:center;">
      ';

      $ordervo = $this->db->order_by('svo.voorder','ASC');
      $queryvo = $this->Embismodel->selectdata('sweet_violations_observed AS svo','svo.*','',$ordervo);

        for($svo=0; $svo < sizeof($queryvo); $svo++){

          $voarraylist = explode(";",$querysweet[0]['violations_observed_desc']);
          if(in_array($queryvo[$svo]['section'], $voarraylist)){
            $checkifappropriate = '<span style="font-family:zapfdingbats;">3</span>';
            $br = ($queryvo[$svo]['section'] == "Sec. 48(1)" OR $queryvo[$svo]['section'] == "Sec. 48(6)" OR $queryvo[$svo]['section'] == "Sec. 48(9)") ?  "<br><br>" : "";
          }else{
            $checkifappropriate = '';
            $br = '';
          }

          $html .= '
            <tr style="font-size:10px;">
              <td style="border:1px solid black;width:110px;">'.$br.$checkifappropriate.'</td>
              <td style="border:1px solid black;width:312px;text-align:left;font-size:10px;">'.$queryvo[$svo]['prohibited_act'].'</td>
              <td style="border:1px solid black;width:110px;">'.$br.$queryvo[$svo]['section'].'</td>
            </tr>
          ';
        }


        $html .= '</table><br><br>
        <table style="width:100%;font-family:arial,sans-serif;">
            <tr style="font-size:10px;">
              <td style="width:20px;">IV.</td>
              <td style="width:100%;">Exact location and type of area where violation(s) was/were observed (fill up and check as appropriate):</td>
            </tr>
        </table><br><br>
        <table style="width:100%;font-family:arial,sans-serif;border:1px solid black;text-align:center;">
            <tr style="font-size:10px;">
              <td style="border:1px solid black;width:533px;font-weight:bold;text-align:center;font-size:10px;">LOCATION</td>
            </tr>
        </table>
        <table style="width:100%;font-family:arial,sans-serif;border:1px solid black;text-align:center;">
            <tr style="font-size:10px;">
              <td style="border-right:1px solid black;border-bottom:1px solid black;width:150px;text-align:center;font-size:10px;">Barangay</td>
              <td style="border:1px solid black;width:383;text-align:left;font-size:10px;">'.$querysweet[0]['barangay_name'].'</td>
            </tr>
            <tr style="font-size:10px;">
              <td style="border-right:1px solid black;border-bottom:1px solid black;width:150px;text-align:center;font-size:10px;">Street</td>
              <td style="border:1px solid black;width:383;text-align:left;font-size:10px;">'.$street.'</td>
            </tr>
            <tr style="font-size:10px;">
              <td style="border-right:1px solid black;width:150px;text-align:center;font-size:10px;">Geographical coordinates</td>
              <td style="border-right:1px solid black;width:191px;text-align:left;font-size:10px;">Lat: '.$querysweet[0]['latitude'].'</td>
              <td style="width:191px;text-align:left;font-size:10px;">Long: '.$querysweet[0]['longitude'].'</td>
            </tr>
        </table><br><br>
        <table style="font-weight:bold;font-size:10px;text-align:center;"><tr><td>TYPE OF AREA/PUBLIC PLACE</td></tr></table>
        <br><br>
        <table style="width:100%;font-family:arial,sans-serif;">
            <tr style="font-size:10px;">';



      $querysta = $this->db->query('SELECT `sta`.* FROM `sweet_type_of_area` AS `sta` WHERE `sta`.`toaorder` BETWEEN 1 AND 5 ORDER BY `sta`.`toaorder` ASC')->result_array();

        for ($sta=0; $sta < sizeof($querysta); $sta++) {

          $toaarraylist = explode(";",$querysweet[0]['type_of_area_desc']);

          if(in_array($querysta[$sta]['toatitle'], $toaarraylist)){
            $ifchecked = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">';
          }else{
            $ifchecked = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
          }

          $html .= '
              <td style="width:4%;">'.$ifchecked.'</td>
              <td style="width:17%;font-size:9px;">'.$querysta[$sta]['toatitle'].'</td>';
        }
          $html .= '
            </tr>
          </table>
          <br><br>
        <table style="width:100%;font-family:arial,sans-serif;">
            <tr style="font-size:10px;">';

      $querystaa = $this->db->query('SELECT `sta`.* FROM `sweet_type_of_area` AS `sta` WHERE `sta`.`toaorder` BETWEEN 6 AND 10 ORDER BY `sta`.`toaorder` ASC')->result_array();

        for ($staa=0; $staa < sizeof($querystaa); $staa++) {

          $toatwoarraylist = explode(";",$querysweet[0]['type_of_area_desc']);

          if(in_array($querystaa[$staa]['toatitle'], $toatwoarraylist)){
            $ifchecked = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">';
          }else{
            $ifchecked = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
          }

          $html .= '
              <td style="width:4%;">'.$ifchecked.'</td>
              <td style="width:17%;font-size:9px;">'.$querystaa[$staa]['toatitle'].'</td>';
        }
          $html .= '
            </tr>
          </table>';

        if($querysweet[0]['if_others_tom'] != ''){
          $ifcheckedothers = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">';
        }else{
          $ifcheckedothers = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
        }

           $html .= '
           <br><br>
          <table style="width:100%;font-family:arial,sans-serif;">
            <tr style="font-size:10px;">
              <td style="width:4%;">'.$ifcheckedothers.'</td>
              <td style="width:7%;font-size:9px;">Others:</td>
              <td style="width:50%;font-size:10px;"><u>'.$querysweet[0]['if_others_tom'].'</u></td>
            </tr>
          </table>';

      if(!empty($querysweet[0]['accessibility'])){
        if($querysweet[0]['accessibility'] == 'Yes'){
          $accessibilitycheckedy = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="15px" height="15px">';
        }else{
          $accessibilitycheckedy = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="15px" height="15px">';
        }

        if($querysweet[0]['accessibility'] == 'No'){
          $accessibilitycheckedn = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="15px" height="15px">';
        }else{
          $accessibilitycheckedn = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="15px" height="15px">';
        }
        $html .= '<br><br><br><span style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;Accessible by heavy equipment(s)?&nbsp;&nbsp;&nbsp;&nbsp;'.$accessibilitycheckedy.'&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;'.$accessibilitycheckedn.'&nbsp;&nbsp;No</span>';
      }

      $pdf->writeHTML($html, true, false, true, false, '');
      $pdf->AddPage();
          $html ='<br><br>
          <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="width:20px;">V.</td>
            <td style="width:300px;">Type of Monitoring Activity (pls. check, fill up as appropriate)</td>
           </tr>
          </table><br><br>';


        $orderstm = $this->db->order_by('stm.tomorder','ASC');
        $querystm = $this->Embismodel->selectdata('sweet_type_of_monitoring AS stm','stm.*','',$orderstm);

        for($stm=0; $stm < sizeof($querystm); $stm++){

          $arraylisttom = explode(";",$querysweet[0]['type_of_monitoring']);

          if(in_array($querystm[$stm]['tomid'], $arraylisttom)){
            $ifcheckedtom = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">';
          }else{
            $ifcheckedtom = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
          }

          if($querystm[$stm]['tomid'] == '2'){
            $dtfm = ($querysweet[0]['type_of_monitoring'] == '2') ? date('F d, Y', strtotime($querysweet[0]['date_of_first_monitoring'])) : "";
            $dtsm = ($querysweet[0]['type_of_monitoring'] == '2') ? date('F d, Y', strtotime($querysweet[0]['date_of_second_monitoring'])) : "";
            $dtlm = ($querysweet[0]['type_of_monitoring'] == '2') ? date('F d, Y', strtotime($querysweet[0]['date_of_last_monitoring'])) : "";

              $htmlva  ='<table style="width:100%;font-family:arial,sans-serif;">';
              $htmlva .='<tr style="font-size:10px;">
                          <td style="width:160px;"><ul><li>Date of first monitoring:</li></ul></td>
                          <td style="border-bottom: 1px solid black;width:170px;text-align:center;">'.$dtfm.'</td>
                          <td></td>
                        </tr>';
              if($querysweet[0]['report_number'] == 2){
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
            $dtfm = ($querysweet[0]['type_of_monitoring'] == '3') ? date('F d, Y', strtotime($querysweet[0]['date_of_first_monitoring'])) : "";
            $dtlm = ($querysweet[0]['type_of_monitoring'] == '3') ? date('F d, Y', strtotime($querysweet[0]['date_of_last_monitoring'])) : "";
            $dtn  = ($querysweet[0]['type_of_monitoring'] == '3' AND !empty($querysweet[0]['date_of_issuance_of_notice'])) ? date('F d, Y', strtotime($querysweet[0]['date_of_issuance_of_notice'])) : "";
            $nd   = ($querysweet[0]['type_of_monitoring'] == '3') ? $querysweet[0]['number_dumping'] : "";
            $na   = ($querysweet[0]['type_of_monitoring'] == '3') ? $querysweet[0]['number_activity'] : "";
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

        if($querysweet[0]['report_number'] > 1){
          $report_number = $querysweet[0]['report_number'] - 1;
          $whereattachmentsleft = $this->db->where('sfa.trans_no = "'.$querysweet[0]['trans_no'].'" AND sfa.report_number = "'.$report_number.'"');
          $joinattachmentsleft = $this->db->join('sweet_form_log AS sfl','sfl.trans_no = sfa.trans_no AND sfl.report_number = sfa.report_number');
          $queryattachmentsleft = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*,sfl.date_created AS sfldate_created','',$joinattachmentsleft,$whereattachmentsleft);
          $attachmentpathleft   = "http://iis.emb.gov.ph/iis-images/sweet_report/".date("Y", strtotime($queryattachmentsleft[0]['sfldate_created']))."/".$querysweet[0]['region']."/".$querysweet[0]['trans_no']."/".$queryattachmentsleft[0]['attachment_name'];

          $wheresweetleft = $this->db->where('sfl.trans_no = "'.$querysweet[0]['trans_no'].'" AND sfl.report_number = "'.$report_number.'"');
          $querysweetleft = $this->Embismodel->selectdata('sweet_form_log AS sfl','photo_remarks,date_patrolled','',$wheresweetleft);
        }

        $whereattachments = $this->db->where('sfa.trans_no = "'.$querysweet[0]['trans_no'].'" AND sfa.report_number = "'.$querysweet[0]['report_number'].'"');
        $queryattachments = $this->Embismodel->selectdata('sweet_form_attachments AS sfa','sfa.*','',$whereattachments);
        $attachmentpath   = "http://iis.emb.gov.ph/iis-images/sweet_report/".date("Y", strtotime($querysweet[0]['date_created']))."/".$querysweet[0]['region']."/".$querysweet[0]['trans_no']."/".$queryattachments[0]['attachment_name'];

        $attachmentpathright   = "http://iis.emb.gov.ph/iis-images/sweet_report/".date("Y", strtotime($queryattachmentsleft[0]['sfldate_created']))."/".$querysweet[0]['region']."/".$querysweet[0]['trans_no']."/".$queryattachments[0]['attachment_name'];

          $html .='
          <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="width:18px;">VI.</td>
            <td style="width:360px;">Photo documentation/pictures of the same site taken during monitoring done on</td>
            <td style="width:145px;border-bottom: 1px solid black;text-align:center;">'.date('F d, Y', strtotime($querysweet[0]['date_patrolled'])).'</td>
           </tr>
          </table><br><br>';

          if($querysweet[0]['report_number'] > 1){
            $html .='&nbsp;&nbsp;<img style="border:1px solid #000; width:260px; height: 260px;" src="'.$attachmentpathleft.'">&nbsp;<img style="border:1px solid #000; width:260px; height: 260px;" src="'.$attachmentpathright.'"><br>';

            $html .=' <table style="width:100%;font-family:arial,sans-serif;">
                       <tr style="font-size:10px;">
                        <td style="width:50%;text-align:center;"><b>Figure 1</b></td>
                        <td style="width:50%;text-align:center;"><b>Figure 2</b></td>
                       </tr>
                      </table><br><br>';

            $html .='<table style="width:100%;font-family:arial,sans-serif;">
                     <tr style="font-size:10px;">
                     <td style="width:1%;">.</td>
                      <td style="text-align:justify;width:49%;"><b>Figure 1:</b>&nbsp;<span>'.($querysweetleft[0]['photo_remarks']).'</span></td>
                      <td style="text-align:justify;width:50%;"><b>Figure 2:</b>&nbsp;<span>'.($querysweet[0]['photo_remarks']).'</span></td>
                     </tr>
                    </table><br><br>';
          }else{
            $html .='&nbsp;&nbsp;&nbsp;<img style="border:1px solid #000; width:520px; height: 260px;" src="'.$attachmentpath.'"><br>';

            $html .=' <table style="width:100%;font-family:arial,sans-serif;">
                       <tr style="font-size:10px;">
                        <td style="width:100%;text-align:center;"><b>Figure 1</b></td>
                       </tr>
                      </table><br><br>';

            $html .='<table style="width:100%;font-family:arial,sans-serif;">
                     <tr style="font-size:10px;">
                      <td style="width:1%;">.</td>
                      <td style="text-align:justify;width:99%;"><b>Figure 1:</b>&nbsp;<span>'.($querysweet[0]['photo_remarks']).'</span></td>
                     </tr>
                    </table><br><br>';
          }

          $html .='
          <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="width:25px;">VII.</td>
            <td style="width:360px;">Additional Findings / Remarks:</td>
           </tr>
          </table>
          <table style="width:100%;font-family:arial,sans-serif;">
            <tr style="font-size:10px;">
              <td style="width:280px;"><ul><li>Estimated land area covered by solid waste (sq. m.):</li></ul></td>
              <td style="border-bottom: 1px solid black;text-align:center;width:150px;">'.$querysweet[0]['total_land_area'].'</td>
              <td></td>
            </tr>';

          if($querysweet[0]['report_type'] == 'Clean'){
            $html .='
                    <tr style="font-size:10px;">
                      <td style="width:280px;"><ul><li>Final Disposal of Solid Waste and Coordinates:</li></ul></td>
                      <td style="border-bottom: 1px solid black;text-align:center;width:240px;">'.$querysweet[0]['final_disposal'].' & '.$querysweet[0]['fd_latitude'].' - '.$querysweet[0]['fd_longitude'].'</td>
                      <td></td>
                    </tr>
                    <tr style="font-size:10px;">
                      <td style="width:90px;"><ul><li>Location:</li></ul></td>
                      <td style="border-bottom: 1px solid black;text-align:center;width:339px;">'.$querysweet[0]['fd_location'].'</td>
                      <td></td>
                    </tr>';
          }

          $html .='
          </table><br><br>
          <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="text-align:justify;"><span>'.($querysweet[0]['additional_remarks']).'</span></td>
           </tr>
          </table>';


    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->AddPage();
          $html ='<br><br>
          <table style="width:100%;font-family:arial,sans-serif;">
           <tr style="font-size:10px;">
            <td style="width:25px;">VIII.</td>
            <td style="width:360px;">Actions to be undertaken:</td>
           </tr>
          </table><br><br>';

            $ordersatbu = $this->db->order_by('satbu.atbuorder','ASC');
            $querysatbu = $this->Embismodel->selectdata('sweet_actions_to_be_undertaken AS satbu','satbu.*','',$ordersatbu);

            for($satbu=0; $satbu < sizeof($querysatbu); $satbu++){

              $arraylistsatbu = explode("|",$querysweet[0]['actions_undertaken_desc']);

              if(in_array($querysatbu[$satbu]['atbutitle'], $arraylistsatbu)){
                $ifcheckedsatbu = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">';
              }else{
                $ifcheckedsatbu = '<img src="http://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
              }

               $rgnname = !empty($querysatbu[$satbu]['title_two']) ? $queryaddress[0]['rgnname'] : "";

              $html .='
              <table style="width:100%;font-family:arial,sans-serif;">
               <tr style="font-size:10px;">
                <td style="width:20px;">'.$ifcheckedsatbu.'</td>
                <td style="width:500px;">'.$querysatbu[$satbu]['atbutitle']." ".$rgnname." ".$querysatbu[$satbu]['title_two'].'<span style="color: red;">&nbsp;'.$querysatbu[$satbu]['title_three'].'</span></td>
               </tr>
              </table>';

            }
        if($querysweet[0]['status'] == 'Signed Document'){
            $html .='<br><br>
                  <table style="width:100%;font-family:arial,sans-serif;text-align:center;border: 1px solid black;">
                     <tr style="font-size:10px; ">
                      <td><br><br>Prepared and submitted by:</td>
                     </tr>
                     <tr>
                      <td style="width:100%;text-align:center;"></td>
                     </tr>
                     <tr>
                      <td style="width:100%;text-align:center;"></td>
                     </tr>';

           $wherepreparername = $this->db->where('acs.userid = "'.$querysweet[0]['userid'].'" AND acs.verified = "1"');
           $selectpreparername = $this->Embismodel->selectdata('acc_credentials AS acs','acs.title, acs.fname, acs.mname, acs.sname, acs.suffix, acs.designation','',$wherepreparername);
           $mname = (!empty($selectpreparername[0]['mname'])) ? $selectpreparername[0]['mname'][0].". " : "";
           $prefix = (!empty($selectpreparername[0]['title'])) ? $selectpreparername[0]['title']." " : "";
           $suffix = (!empty($selectpreparername[0]['suffix'])) ? " ".$selectpreparername[0]['suffix'] : "";
           $preparername = $prefix.ucwords($selectpreparername[0]['fname']." ".$mname.$selectpreparername[0]['sname']).$suffix;

           $wherepreparer = $this->db->where('oue.userid = "'.$querysweet[0]['userid'].'" AND oue.status = "Active"');
           $selectpreparer = $this->Embismodel->selectdata('office_uploads_esignature AS oue','oue.file_name, oue.swm_height, oue.swm_width, oue.swm_yaxis, oue.swm_xaxis','',$wherepreparer);


           $pxaxis = $selectpreparer[0]['swm_xaxis'];
           $pyaxis = $selectpreparer[0]['swm_yaxis'];
           $pwidth = $selectpreparer[0]['swm_width'];
           $pheight = $selectpreparer[0]['swm_height'];

           $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectpreparer[0]['file_name'].'', ($pxaxis+5), ($pyaxis-28), $pwidth, $pheight, '', '', '', false, 300, '', false, false, '', false, false, false);
           $html .= '<tr>
                      <td style="width:100%;text-align:center;"><u style="font-weight:bold;font-size:11px;">'.$preparername.'</u><br><i style="font-size:9px;">'.$selectpreparername[0]['designation'].'</i></td>
                    </tr>';
            $html .= '<tr>
                       <td style="width:100%;text-align:center;"></td>
                     </tr>';
            $html .= '<tr style="font-size:10px;">
                      <td><br>Checked and Validated by:<br></td>
                     </tr>';

           $whereevaluatorstemplatename = $this->db->where('srl.trans_no = "'.$trans_no.'" AND srl.report_number = "'.$report_number.'" GROUP BY srl.assigned_to ORDER BY srl.cnt ASC');
           $selectevaluatorstemplatename = $this->Embismodel->selectdata('sweet_route_log AS srl','srl.assigned_to, srl.name, srl.designation','',$whereevaluatorstemplatename);

           $plusy = 0;
           for ($evl=0; $evl < sizeof($selectevaluatorstemplatename); $evl++) {
             if(!empty($selectevaluatorstemplatename[$evl]['assigned_to']) AND $querysweet[0]['status'] == 'Signed Document'){
               $whereevaluatorstemplate = $this->db->where('oue.userid = "'.$selectevaluatorstemplatename[$evl]['assigned_to'].'" AND oue.status = "Active"');
               $selectevaluatorstemplate = $this->Embismodel->selectdata('office_uploads_esignature AS oue','oue.file_name, oue.swm_height, oue.swm_width, oue.swm_yaxis, oue.swm_xaxis','',$whereevaluatorstemplate);
               $exaxis = $selectevaluatorstemplate[0]['swm_xaxis'];
               $eyaxis = $selectevaluatorstemplate[0]['swm_yaxis'];
               $ewidth = $selectevaluatorstemplate[0]['swm_width'];
               $eheight = $selectevaluatorstemplate[0]['swm_height'];

               $pdf->Image('http://iis.emb.gov.ph/iis-images/e-signatures/'.$selectevaluatorstemplate[0]['file_name'].'', $exaxis, ($eyaxis+$plusy), $ewidth, $eheight, '', '', '', false, 300, '', false, false, '', false, false, false);
               $plusy = $plusy + 17;
             }

             $html .= '<tr>
                        <td style="width:100%;text-align:center;"></td>
                      </tr>';
             $html .= '<tr>
                        <td style="width:100%;text-align:center;"><u style="font-weight:bold;font-size:11px;">'.$selectevaluatorstemplatename[$evl]['name'].'</u><br><i style="font-size:9px;">'.$selectevaluatorstemplatename[$evl]['designation'].'</i></td>
                      </tr>';
           }

           $html .= '<tr>
                      <td style="width:100%;text-align:center;"><br></td>
                    </tr>
                    <tr style="font-size:10px;">
                      <td style="width:40%;"></td>
                      <td style="width:20%; border-bottom: 1px solid black;">'.date('F d, Y', strtotime($querysweet[0]['date_created'])).'</td>
                      <td style="width:40%;"></td>
                    </tr>
                    <tr style="font-size:10px;">
                      <td></td>
                      <td><b>Date</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><br></td>
                    </tr>
                  </table><br><br><br><br>';
                   if($this->session->userdata('office') == 'EMB'){
                     $html .='
                     <table style="width:100%;font-family:arial,sans-serif;">
                      <tr style="font-size:9px;">
                       <td>Copy Furnish:</td>
                      </tr>
                     </table>
                     <table style="width:100%;font-family:arial,sans-serif;">
                      <tr style="font-size:9px;">
                       <td style="width:500px;">&nbsp;&nbsp;&nbsp;-&nbsp;Regional Executive Director, Department of Environment and Natural Resources (RED DENR-'.$this->session->userdata('region').');</td>
                      </tr>
                      <tr style="font-size:9px;">
                       <td style="width:500px;">&nbsp;&nbsp;&nbsp;-&nbsp;Regional Director, Environmental Management Bureau (RD EMB-'.$this->session->userdata('region').');</td>
                      </tr>
                      <tr style="font-size:9px;">
                       <td style="width:500px;">&nbsp;&nbsp;&nbsp;-&nbsp;EMB-'.$this->session->userdata('region').' Provincial Environmental Management Units (PEMUs);</td>
                      </tr>
                      <tr style="font-size:9px;">
                       <td style="width:500px;">&nbsp;&nbsp;&nbsp;-&nbsp;EMB-'.$this->session->userdata('region').' SWM Division;</td>
                      </tr>
                     </table><br><br>';
                   }
      }
    $pdf->writeHTML($html, true, false, true, false, '');
    //Close and output PDF document
    $pdf->Output();
  }

  function form(){
    $this->load->view('travelorder/toform');
  }

}

?>
