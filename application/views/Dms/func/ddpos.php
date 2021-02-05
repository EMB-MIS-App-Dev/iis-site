<?php
// tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR); // change to user
$obj_pdf->SetTitle('[DF] '.$trans[0]['token']); // add trans_no
// $obj_pdf->SetHeaderData('/iis-images/document-header/'.$header, 10, $title, PDF_HEADER_STRING);
$obj_pdf->SetMargins(10, 5, 10, 5); // PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, PDF_MARGIN_BOTTOM
$obj_pdf->SetAutoPageBreak(TRUE, 5);
// $obj_pdf->setFooterMargin(10);
$obj_pdf->SetFont('times', '', 12);

$obj_pdf->setPrintHeader(false); // remove header
$obj_pdf->setPrintFooter(false); // remove footer

$obj_pdf->AddPage('P', array('235', ''));
ob_start();

// $data['trans'] = $trans;
// $data['trans_log'] = $trans_log;

  ?>

  <style type="text/css">
    .main{text-align:center;display:inline-block;background-color:#ffffff;padding:20px;}
       table.ttbb{width:100%;border-collapse:collapse;margin:auto;}
      /* .pt20{padding-top:20px;} */
      /* .tr{text-align:right;} */
      .tl{text-align:left;}
      /* .wr{word-wrap: break-word;} */
      /* .pl10{padding-left:10px} */
      /* .pr10{padding-right:10px} */
      /* .ti{font-style:italic;} */
      /* .tin100{text-indent:100px;} */
      /* .tin50{text-indent:50px;} */
      /* .tu{text-decoration:underline;} */
      .tc{text-align:center;}
      /* .tdh{text-align:center; height: 23px !important;} */
      /* .tj{text-align: justify;} */
      /* .bb{border-bottom:1px solid #000000;} */
      /* .mr200{margin-right:200px;} */
      /* .tblr{font-size:9px; word-wrap: break-word;} */
      /* .f12{font-size:8px;} */
       /* hr{height: 1px;color: #000;background-color: #000;border: none;} */
      .tbl1 tr td:nth-child(1), .tbl1 tr td:nth-child(3){ text-align: center}
    }
  </style>
  <img class="head" style="margin-top:-30px;" src="/iis-images/document-header/<?=$header;?>">
  <p style="text-align: center;">DISPOSITION FORM</p>
  <br>
  <table>
    <tr>
      <td width="10%" style="font-weight:bold;">Doc. Date</td>
      <td width="1%">:</td>
      <td width="20%" class="tl"><?=$trans[0]['start_date'];?></td>
      <td width="65%" rowspan="2" class="wr"><span style="font-weight:bold;">Company Name 	</span>: <?=$trans[0]['company_name'];?></td>
      <td rowspan="2" class="tr">
        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F<?php echo $trans[0]['token']; ?>%2F&choe=UTF-8" alt="QRCODE" width="50px" height="50px">
      </td>
    </tr>
    <tr>
      <td width="10%" style="font-weight:bold;">IIS No.</td>
      <td width="1%">:</td>
      <td width="20%" class="tl"><?=$trans[0]['token'];?></td>
      <td></td>
    </tr>
  </table>
  <hr>
  <table>
    <tr>
      <td width="15%" style="font-weight:bold;">Subject / Title:</td>
      <td style="font-size: 10px"><?=$trans[0]['subject'];?></td>
    </tr>
  <!-- 	<tr>
      <td class="bb pt20">Sample only Subject / Title Status of Serviceability of Distributed PPEx in 2011 </td>
    </tr> -->
  </table>
  <hr>
  <p class="tl tj" style="font-size:10px;"><span class="tu" style="font-weight:bold;">TO: All Officials/Personnel Concerned:</span> <br>Please accomplish and route this properly with the corresponding attached communication/documents. The Official or employee in-charge to whom this document is routed shall act promptly and expeditiously without discrimination as prescribed in the SECSIME or within fifteen (15) working days from receipt thereof, failure to do is punishable by LAW under RA 6713 and negligence to Memorandum Circular No. 44 issued by the Office of the President of the Philippines "Directing all Government Agencies and Instrumentalities, including government-owned or controlled corporations to respond to all public requests and concerns within 15 days (15 from the receipt thereof)</p>
  <p class="tl f12">For strict compliance.</p>
  <table border="1" id="tbroute" class="ttbb">
    <tr style="text-align: center">
      <td colspan="5" >ROUTED</td>
    </tr>
    <tr >
      <td width="15%" class="tc"><span style="font-weight:bold;">BY</span> <br> <span class="f12">(Official Code/ <br> Sender Initial)</span></td>
      <td width="15%" class="tc"><span style="font-weight:bold;">DATE</span> <br><span class="f12">(mm/dd/yy)</span></td>
      <td width="15%" class="tc"><span style="font-weight:bold;">TO</span> <br> <span class="f12">(Official Code/ <br> Receiver Initial)</span></td>
      <td width="15%" class="tc"><span style="font-weight:bold;">TIME</span> <br><span class="f12">(AM/PM)</span></td>
      <td width="40%" class="tc"><span style="font-weight:bold;">ACTION / REMARKS / STATUS</span></td>
    </tr>
    <?php
      $i = 17;
      while ($i > 0) {
        echo '<tr class="tc tdh">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>';
        $i--;
      }
    ?>
  </table>
  <p class="tl" style="font-weight:bold;">Use code for comment/instruction and desired action:</p>
  <table class="tl" style="font-size:10px;">
  <tr>
    <td>A - For information / guidance / reference</td>
    <td>D - For comments / recommendations</td>
    <td>G - Pls. take up with me</td>
    <td>J - Pls. draft answer memo</td>
  </tr>
  <tr>
    <td>B - Pls. appropriatte action</td>
    <td>E - Pls. immediate investigation</td>
    <td>H - Pls. Attach supporting papers</td>
    <td>K - Pls. for approval</td>
  </tr>
  <tr>
    <td>C - For initial/signature</td>
    <td>F - For study/evaluation</td>
    <td>I - Pls. release/file</td>
    <td>L - Update stat of code</td>
  </tr>
  </table>
  <p class="tl ti tj" style="font-size:12px; font-weight:bold"><span class="tu">Important Reminder !</span> <br> Do not tamper. Continue on separate sheet if necessary. Attach this always with the document to be routed as this shall form an integral part of the document process.</p>

<?php

  $content = ob_get_contents();
  ob_end_clean();
  // $obj_pdf->writeHTML($content, true, 0, true, 0);
  $obj_pdf->writeHTML($content, true, false, true, false, '');
  $obj_pdf->Output('output.pdf', 'I'); // default name of file on download
?>
