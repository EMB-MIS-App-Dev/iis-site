<?php
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR); // change to user
    $pdf->SetTitle('[DF] asd'); // add trans_no
    // $pdf->SetHeaderData('/iis-images/document-header/'.$header, 10, $title, PDF_HEADER_STRING);
    $pdf->SetMargins(10, 5, 10, 5); // PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, PDF_MARGIN_BOTTOM
    $pdf->SetAutoPageBreak(TRUE, 5);
    // $pdf->setFooterMargin(10);
    $pdf->SetFont('arialn', '', 12);

    $pdf->setPrintHeader(false); // remove header
    $pdf->setPrintFooter(false); // remove footer

    $pdf->AddPage('P', array('235', ''));
    $pdf->SetLineStyle( array( 'width' => 1, 'color' => array(0,0,0)));
    $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight());
    ob_start();
?>

<style>
    @media print{
      #btnprint{
        display: none;
      }
      #printpds{
        position: absolute;
        top:0;
        bottom:0;
        right:0;
        left:0;
      }
      #csid1{background-color:#696969 !important;
        -webkit-print-color-adjust: exact;
      }

      #csid1, .headall{
        background-color: gray !important;
        color:white !important;
        -webkit-print-color-adjust: exact;
      }
      .bgall, {
        background-color:#eaeaea !important;
        -webkit-print-color-adjust: exact;
      }
      #separate{color:red !important;
      -webkit-print-color-adjust: exact;
    }
      .text-hide{color:#eaeaea !important;}

      .page-break{page-break-after: always;}


    }

    #btnprint{
      border-radius:0px;
      margin-right:90px;
      margin-top: 5px;
    }
    body{
      color: black;
      font-family: "Arial Narrow", Arial, sans-serif;
    }
    .container{
      border-style:solid ;
      width:1050px;
      /*height:1650px;*/
      background-color:#fff;
    }
    #csform212{
      font-size:10px;
      margin-top:1px;
      font-weight: bold;
    }
    #pdstitle{
      text-align:center;
      font-weight:900;
      font-size:35px;
    }
    #printleg{
      font-size:11px;
      margin-top: 20px;
      margin-bottom:-20px;
    }
    #csid1{
      /*text-align:center;
      width:78px;
      margin-right: -4px;
      background-color: gray;
      color:white;
      border-color:gray;*/

    }
    #csid2{
      /*width:300px;
      text-align: right;
      border-color:black;
      /*border-left: none;*/
      border-right: none;*/
    }
    #perinfo{
      width:944px;
      border-top: ;
      border-bottom: solid 1px;
      font-size: ;

    }
    .headall{
      font-size: 16px;
      font-style: italic;
      color:white;
      border-style:solid;
      border-color:#000;
      background-color:gray;
      width:1050px;
      border-left:none;
      padding:5px;
    }
    td{
      padding-top:10px;padding-bottom: 10px;
      }

    .ti{font-style: italic;}
    .tb{font-weight:bold;}


    .bgall{
      background-color:#eaeaea !important;
      -webkit-print-color-adjust: exact;
    }
    .fontred{color:red !important;
      -webkit-print-color-adjust: exact;}
    #tbdob td{border-style: solid;}
    #hidden{color:white !important;
      -webkit-print-color-adjust: exact;}
    .tdborder{border-style:solid;}

    @media print{
      .page-break{page-break-after: always;}
      #csidnew{background-color:#696969 !important;
      -webkit-print-color-adjust: exact;}
      .NoPrnt{display: none;}
    }
    div.test {
        width: 100%;
        border-style: solid solid solid solid;
    }

</style>

<style>
    .header1 {
      font-weight:900;
      font-size:35px;
      /* text-align:center; */
    }
</style>
    <!-- <div class="test page-break" style=";background-color:#fff;"> -->
        <!-- #########################  PDS HEADER ######################### -->
        <table>
        		<tr>
        		    <td colspan="2" style="font-size:10px;font-style:italic;font-weight:bold;padding:2px 5px;"> CS FORM 212<br/>Revised 2017 </td>
        		</tr>
        		<tr>
        				<td class="header1" colspan="2" style="padding:5px 0;"> <b>PERSONAL DATA SHEET</b> </td>
        		</tr>
        		<tr>
        				<td colspan="2" style="font-size:12.5px;font-style: italic;font-weight:bold;padding:0px 1px 0px 5px;">
        					WARNING: Any misinterpretation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against
        					the person concerned.<br/><br/>
        					READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.
        					<span style="font-style:normal;font-weight:normal;">
          						Print legibly. Tick appropriate boxes and use separate sheet if necessary. Indicate N/A if not applicable. <strong>DO NO ABBREVIATE.</strong>
          						<input class="float-right" type="text" value=" (Do not fill up. For CSC use only) " id="csid2" style="width:200px;color:#000;border:1px solid #000;" readonly>
          						<input class="float-right" type="text"  id="csidnew" value="1. CS ID No." style="width:65px;background-color:#696969;border:1px solid #000;" readonly>
        					</span>
        				</td>
        		</tr>
        </table>
        <!-- #########################  END OF PDS HEADER ######################### -->
    <!-- </div> -->
<?php
    $content = ob_get_contents();
    ob_end_clean();
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->Output('output.pdf', 'I'); // default name of file on download
?>
