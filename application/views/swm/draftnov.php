<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=1024, initial-scale=1, shrink-to-fit=no">

  <title>EMB - IIS (Integrated Information System)</title>

  <!-- <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-denr.png"> -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>favicon/favicon-16x16.png">
  <link rel="manifest" href="<?php echo base_url(); ?>favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  <link href="<?php echo base_url(); ?>assets/common/selectize/dist/css/selectize.bootstrap3.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/common/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <style media="screen">
    /* html {
      overflow: hidden;
    } */
    body{
      background-color: #EDEEF1;

    }
    .container-fluid{
      margin: 20px 20px 20px 20px;
      width: 98%;
    }
    /* view */
    .main{text-align:center;display:inline-block;background-color:#ffffff;padding:20px;height:356mm;width:221mm;zoom: 65%;}
      .frm{height:356mm;width:210mm;padding:30px;}
      .head{margin-top:-30px;}
      table{width:100%;border-collapse:collapse;margin:auto;}
      .pt20{padding-top:20px;}
      .tr{text-align:right;}
      .tl{text-align:left;}
      .tb{font-weight:bold;}
      .pl10{padding-left:10px}
      .pr10{padding-right:10px}
      .ti{font-style:italic;}
      .bt{border-bottom:1px solid #000;}
      .tu{text-decoration:underline;}
      /* .tin{text-indent:50px;} */
      /* .tin20{text-indent:20px;} */
      .tj{text-align:justify;}
      .viewbody{font-size:16px;font-family:times;text-align: center;background-color: #333333;}
    /* view */
    /* options */
    .left-tool-bar{
      background-color: #FFF;
      /* position: fixed;
      top: 50px;
      left: 50px; */
      height: 50%;
      border-radius: 5px;
    }
    .tool-header{
      padding: 10px;
      background-color: #08507E;
    }
    .label-header{
      color: #FFF;
      font-size: 15pt;
      font-weight: bold;
    }
    .tool-body{
      padding:10px 10px 0px 10px;
    }
    .tool-footer{
      padding: 10px;
      border-top: 1px solid #EDEEF1;
      margin-top: 10px;
      text-align: right;
    }
    label{
      font-size: 9pt;
    }

    .form-control{
      font-size: 8pt;
    }

    .error{
      color: red;
      font-size: 10pt;
      margin-left: 5px;
    }
    /* options */
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-7" style="height:100%;margin-bottom:15px;">
        <button type="button" class="btn btn-info" id="buttonleft" onclick="chngvw('<?php echo $this->encrypt->encode('1') ?>');" style="<?php echo $chngvws; ?>position: absolute;left: 20px;top: 5px;border-radius:50px"><span class="fa fa-arrow-left"></span></button>
        <button type="button" class="btn btn-info" id="buttonright" onclick="chngvw('<?php echo $this->encrypt->encode('2') ?>');" style="<?php echo $chngvwf; ?>position: absolute;right: 20px;top: 5px;border-radius:50px"><span class="fa fa-arrow-right"></span></button>

        <div class="viewbody" id="firstpage" style="<?php echo $chngvwf; ?>">
          <div class="main">
        		<div class="frm">
        			<img class="head" src="https://iis.emb.gov.ph/iis-images/document-header/<?php echo $selectheader[0]['file_name']; ?>" width="100%">
        			<table class="tb tl">
        				<tr>
        					<td width="6%">ID #:</td>
        					<td class="bt" width="25%"><span id="embidnv"><?php echo $embid; ?></span></td>
        					<td></td>
        				</tr>
        				<tr>
        					<td width="6%">IIS #:</td>
        					<td width="25%" class="bt"><span id="iisnv"><?php echo $iisno; ?></span></td>
        					<td></td>
        				</tr>
        			</table>
        			<br>
        			<p class="tb tl" id="dtdftd"><?php echo $ltrdt; ?></p>

        			<table class="tl">
        				<tr>
        					<td class="tb">
                    <span id="prfxltr"><?php echo $prfxltr; ?></span>
                    <span id="fnmltr"><?php echo $fnmltr; ?></span>
                    <span id="miltr"><?php echo $miltr; ?></span>
                    <span id="lnltr"><?php echo $lnltr; ?></span>
                    <span id="sfxltr"><?php echo $sfxltr; ?></span>
                  </td>
        				</tr>
        				<tr>
        					<td> <span id="desltr"><?php echo $desltr; ?></span> </td>
        				</tr>
        				<tr>
        					<td> <span id="mctyltr"><?php echo $mctyltr; ?></span> </td>
        				</tr>
        				<tr>
        					<td>Province of <span id="lguprov"><?php echo $lguprov; ?></span></td>
        				</tr>
        			</table><br>
        			<p class="tb tu">SUBJECT: NOTICE OF VIOLATION ON RA 9003 (SWEET-ENMO REPORT)</p>
        			<p class="tb tl">
        				Dear <span id="drdes"><?php echo ucwords(strtolower($desltr)); ?></span>&nbsp;<span id="drln"><?php echo ucwords(strtolower($lnltr)); ?></span>:
        			</p>
        			<p class="tl tin tj">
        				In order to strengthen the implementation of Republic Act 9003, otherwise known as the "Ecological Solid Waste Management Act of 2000",
        				the DENR-Environmental Management Bureau established the <span class="tb">SOLID WASTE ENFORCEMENT AND EDUCATORS PROGRAM - ENVIRONMENTAL MONITORING OFFICERS.</span>
        				This aims to monitor the compliance of LGUs specifically on the following prohibited acts under Chapter VI of RA 9003, or the Penal Provisions:
        			</p>
              <div id="vobdy_">
                <table border="1">
          				<thead>
                    <tr>
            					<th width="70%"><center>Prohibited Act</center></th>
            					<th width="30%"><center>Section Chapter VI, RA 9003</center></th>
            				</tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($vo[0]['section'])){ ?>
                      <?php for ($i=0; $i < sizeof($vo); $i++) { ?>
                        <tr>
                          <td class="tl pl10"><?php echo $vo[$i]['prohibited_act']; ?></td>
                          <td><?php echo $vo[$i]['section']; ?>;</td>
                        </tr>
                      <?php } ?>
                    <?php }else{ ?>
                      <tr>
                        <td class="tl pl10">-</td>
                        <td>-</td>
                      </tr>
                    <?php } ?>
                  </tbody>
          			</table>
              </div>
              <br>
        			<p class="tl tj">
        				On <span class="tb" id="datemonitored"><?php echo $datemonitored; ?></span> our <span class="tb">SWEET - EnMOs</span> spotted its  <span class="tb">violation</span> along
        				<span class="tb">Barangay road and open spaces</span> (photos attached). This is a violation of Chapter VI of RA 9003 and City/Municipal SWM Ordinance (as applicable).
        			</p>
        			<p class="tl tj">
        				In this regard, may we urge your good office to call the attention of the Barangay Captain of Barangay
        					<span class="tb" id="brgyname"><?php echo $brgyname; ?></span>.
        			</p>
        			<p class="tl tj tin">
        				To remove the said solid wastes and to closely monitor and apprehend illegal dumping of wastes within <span class="tb" id="swrmvl"><?php echo $swrmvl; ?></span>.
        				Kindly email said official report to <span class="tb tu" id="swmoe"><?php echo $swmemail; ?></span>. Please see enclosed some pictures recently taken in the affected area.
        			</p>
        			<p class="tl tj">
        				As our partner in implementing RA 9003, we look forward to your cooperation in the protection of our environment.
        			</p>
        			<p class="tl tj tin20">
        				Should any further assistance be needed, please feel free to call or fax us at <span class="tb" id="swmcinf"><?php echo $swmcontactinfo; ?></span>.
        			</p>
              <br><br>
        			<p class="tl">Very truly yours,</p>
        			<table class="tl tb">
                <tr>
        					<td><u><?php echo $rdnovname; ?></u></td>
        				</tr>
                <tr>
        					<td style="font-weight:normal;"><i><?php echo $rdnovdesignation; ?></i></td>
        				</tr>
        			</table>
        			<br>
        			<table class="tl">
        				<tr>
        					<td><span id="cc"><?php if(!empty($ccon)){ echo 'Cc:'; } ?></span></td>
        				</tr>
        				<tr>
        					<td><span id="ccon"><?php echo $ccon; ?></span></td>
        				</tr>
        				<tr>
        					<td><span id="ccoa"><?php echo $ccoa; ?></span></td>
        				</tr>
        			</table>
        		</div>
        	</div>
        </div>

        <div class="viewbody" id="secondpage" style="<?php echo $chngvws; ?>">
          <div class="main">
        		<div class="frm">
        			<img class="head" src="https://iis.emb.gov.ph/iis-images/document-header/<?php echo $selectheader[0]['file_name']; ?>" width="100%"><br><br>
              <div id="tom_">
                <table>
                  <tr>
                    <td style="width:5%;text-align:center;">I.</td>
                    <td style="text-align:left;">Type of Monitoring (pls. check, fill up as appropriate)</td>
                  </tr>
                </table>
                <table>
                  <?php for ($tm=0; $tm < sizeof($selecttom); $tm++) {
                    $ifchecked = ($selecttom[$tm]['tomid'] == $selectdatavo[0]['type_of_monitoring']) ? '<img src="https://iis.emb.gov.ph/iis-images/sweet-icons/boxchecked.png" width="25px" height="25px">' : '<img src="https://iis.emb.gov.ph/iis-images/sweet-icons/box.png" width="25px" height="25px">';
                  ?>
                  <tr>
                    <td style="padding-top: 10px;width:6%;text-align:right;"><?php echo $ifchecked; ?></td>
                    <td style="padding-top: 10px;text-align:left;"><?php echo $selecttom[$tm]['tomtitle']; ?></td>
                  </tr>
                  <?php if($selecttom[$tm]['cat'] == 'b.'){ ?>
                    <?php if(!empty($selectdatavo[0]['date_of_last_monitoring']) AND $selectdatavo[0]['type_of_monitoring'] == '2'){ ?>
                      <tr>
                        <td style="width:6%;text-align:right;"></td>
                        <td style="text-align:left;padding-left:20px;">Date of first monitoring: <?php echo  $fm = ($selectdatavo[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_first_monitoring'])).'</u>' : '_____________'; ?></td>
                      </tr>
                      <tr>
                        <td style="width:6%;text-align:right;"></td>
                        <td style="text-align:left;padding-left:20px;">Date of second monitoring: <?php echo  $sm = ($selectdatavo[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_second_monitoring'])).'</u>' : '_____________'; ?></td>
                      </tr>
                      <tr>
                        <td style="width:6%;text-align:right;"></td>
                        <td style="text-align:left;padding-left:20px;">Date of last monitoring: <?php echo  $lm = ($selectdatavo[0]['type_of_monitoring'] == '2' AND !empty($selectdatavo[0]['date_of_last_monitoring'])) ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_last_monitoring'])).'</u>' : '_____________'; ?></td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td style="width:6%;text-align:right;"></td>
                        <td style="text-align:left;padding-left:20px;">Date of first monitoring: <?php echo  $fm = ($selectdatavo[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_first_monitoring'])).'</u>' : '_____________'; ?></td>
                      </tr>
                      <tr>
                        <td style="width:6%;text-align:right;"></td>
                        <td style="text-align:left;padding-left:20px;">Date of last monitoring: <?php echo  $sm = ($selectdatavo[0]['type_of_monitoring'] == '2') ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_second_monitoring'])).'</u>' : '_____________'; ?></td>
                      </tr>
                    <?php } ?>
                  <?php } ?>
                  <?php if($selecttom[$tm]['cat'] == 'c.'){ ?>
                    <tr>
                      <td style="width:6%;text-align:right;"></td>
                      <td style="text-align:left;padding-left:20px;">Date of first monitoring: <?php echo  $fm = ($selectdatavo[0]['type_of_monitoring'] == '3') ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_first_monitoring'])).'</u>' : '_____________'; ?></td>
                    </tr>
                    <tr>
                      <td style="width:6%;text-align:right;"></td>
                      <td style="text-align:left;padding-left:20px;">Date of last monitoring: <?php echo  $lm = ($selectdatavo[0]['type_of_monitoring'] == '3' AND !empty($selectdatavo[0]['date_of_last_monitoring'])) ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_last_monitoring'])).'</u>' : '_____________'; ?></td>
                    </tr>
                    <tr>
                      <td style="width:6%;text-align:right;"></td>
                      <td style="text-align:left;padding-left:20px;">Date of issuance of last Notice: <?php echo $diln = ($selectdatavo[0]['type_of_monitoring'] == '3' AND !empty($selectdatavo[0]['date_of_issuance_of_notice'])) ? '<u>'.date('F d, Y', strtotime($selectdatavo[0]['date_of_issuance_of_notice'])).'</u>' : '_____________'; ?></td>
                    </tr>
                    <tr>
                      <td style="width:6%;text-align:right;"></td>
                      <td style="text-align:left;padding-left:20px;">Number of times <b><i>same site</i></b> is found with illegal dumping: <?php echo  $nd = ($selectdatavo[0]['type_of_monitoring'] == '3') ? '<u>'.$selectdatavo[0]['number_dumping'].'</u>' : '_____________'; ?></td>
                    </tr>
                    <tr>
                      <td style="width:6%;text-align:right;"></td>
                      <td style="text-align:left;padding-left:20px;">Number of times <b><i>same site</i></b> is found with open burning activity: <?php echo  $na = ($selectdatavo[0]['type_of_monitoring'] == '3') ? '<u>'.$selectdatavo[0]['number_activity'].'</u>' : '_____________'; ?></td>
                    </tr>

                  <?php } ?>
                  <?php } ?>
                </table>
                <br>
                <table>
                  <tr>
                    <td style="width:5%;text-align:center;">II.</td>
                    <td style="text-align:left;">Photo documentation/pictures</td>
                  </tr>
                </table>
                <img style="border:1px solid #000; width:355px; height: 355px;" src="<?php echo $attachmentleft; ?>">&nbsp;<img style="border:1px solid #000; width:355px; height: 355px;" src="<?php echo $attachmentright; ?>"><br>

                <table>
                   <tr>
                      <td style="width:50%;text-align:center;"><b>Figure 1</b></td>
                      <td style="width:50%;text-align:center;"><b>Figure 2</b></td>
                   </tr>
                </table><br>
                <table>
                   <tr>
                      <td style="vertical-align:top;width:1%;color:#FFF;">.</td>
                      <td style="vertical-align:top;text-align:justify;width:47%;"><b>Figure 1:</b>&nbsp;<span><?php echo $photo_remarks_left; ?></span></td>
                      <td style="vertical-align:top;width:1%;color:#FFF;">.</td>
                      <td style="vertical-align:top;text-align:justify;width:47%;"><b>Figure 2:</b>&nbsp;<span><?php echo $photo_remarks_right; ?></span></td>
                   </tr>
                </table><br><br>
              </div>
        		</div>
        	</div>
        </div>

      </div>
      <div class="col-md-5" style="height:100%;">
        <div class="left-tool-bar">
          <div class="tool-header">
            <label class="label-header">Create NOV letter</label>
          </div>
          <div class="tool-body">
            <form method="post">
              <div class="row">
              <div class="col-md-8">
                <label>Select unclean report transaction no.:</label><span class="error" id="error_bindletterselectize" title="This field is required."></span>
                <select class="form-control" id="bindletterselectize" onchange="bindletternv(this.value); tom(this.value);">
                  <option value="<?php echo $iisnoen; ?>"><?php echo $iisnoselectize; ?></option>
                  <?php for ($i=0; $i < sizeof($selectsweettrans); $i++) { ?>
                    <optgroup label="Month of <?php echo $selectsweettrans[$i]['month_monitoring'].' - '.$selectsweettrans[$i]['type_of_monitoring_desc'].' - '.date('F d, Y', strtotime($selectsweettrans[$i]['date_patrolled'])); ?>">
                      <option value="<?php echo $this->encrypt->encode($selectsweettrans[$i]['trans_no'].'|'.$selectsweettrans[$i]['cnt']); ?>"><?php echo $selectsweettrans[$i]['trans_no']." - ".$selectsweettrans[$i]['lgu_patrolled_name'].' - '.$selectsweettrans[$i]['barangay_name']; ?></option>
                    </optgroup>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label>Set letter date:</label><span class="error" id="error_letter_date" title="This field is required."></span>
                <input style="margin-top: -2px;" type="date" class="form-control" id="letter_date" onchange="setltrdtnv(this.value);" value="<?php echo date('Y-m-d', strtotime($ltrdt)); ?>">
              </div>
              <div class="col-md-12">
                <label>Address this letter to whom:</label>
                <span class="error" id="error_prefix" title="Prefix field is required."></span>
                <span class="error" id="error_firstname" title="First name field is required."></span>
                <span class="error" id="error_lastname" title="Last name field is required."></span>
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" id="prefix" onchange="prfxltr(this.value);" placeholder="Prefix" value="<?php echo $this->session->userdata('prfxltr'); ?>">
              </div>
              <div class="col-md-3" style="padding-left:0px;padding-right:0px;">
                <input type="text" class="form-control"id="firstname" onchange="fnmltr(this.value);" placeholder="First name" value="<?php echo $this->session->userdata('fnmltr'); ?>">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" id="middleinitial" onchange="miltr(this.value);" placeholder="M.I." value="<?php echo $this->session->userdata('miltr'); ?>">
              </div>
              <div class="col-md-3" style="padding-left:0px;padding-right:0px;">
                <input type="text" class="form-control" id="lastname" onchange="lnltr(this.value);" placeholder="Last name" value="<?php echo $this->session->userdata('lnltr'); ?>">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" id="suffix" onchange="sfxltr(this.value);" placeholder="Suffix" value="<?php echo $this->session->userdata('sfxltr'); ?>">
              </div>
              <div class="col-md-6">
                <label>Designation</label><span class="error" id="error_designation" title="This field is required."></span><span class="fa fa-info-circle" title="e.g. Mayor / Vice Mayor / City Government Office Head" style="float:right;color:#EDBC26;font-size: 9pt;margin-top: 5px;"></span>
                <input type="text" class="form-control" id="designation" onchange="desltr(this.value);" value="<?php echo $this->session->userdata('desltr'); ?>">
              </div>
              <div class="col-md-6">
                <label>Municipality / City&nbsp;</label><span class="error" id="error_lgu_name" title="This field is required."></span><span class="fa fa-info-circle" title="e.g. Municipality of Carcar / City of Cebu" style="float:right;color:#EDBC26;font-size: 9pt;margin-top: 5px;"></span>
                <input type="text" class="form-control" id="lgu_name" onchange="mctyltr(this.value);" value="<?php echo $this->session->userdata('mctyltr'); ?>">
              </div>
              <div class="col-md-12"><hr>
                <label>Span of waste removal:</label><span class="error" id="error_span_wrmvl" title="This field is required."></span>
                <input type="text" class="form-control" id="span_wrmvl" onchange="swrmvl(this.value);" value="<?php echo $swrmvl; ?>">
              </div>
              <div class="col-md-12">
                <hr>
              </div>
              <div class="col-md-6">
                <label>SWM official email:</label><span class="error" id="error_swm_oe" title="This field is required."></span>
                <input type="text" class="form-control" id="swm_oe" onchange="swmoe(this.value);" value="<?php echo $swmemail; ?>">
              </div>
              <div class="col-md-6">
                <label>SWM contact information:</label><span class="error" id="error_swm_ci" title="This field is required."></span>
                <input type="text" class="form-control" id="swm_ci" onchange="swmcinf(this.value);" value="<?php echo $swmcontactinfo; ?>">
              </div>
              <div class="col-md-12">
                <hr>
              </div>
              <div class="col-md-12">
                <label>Route this letter to / for approval of:</label>
                <?php $explodeddatart = explode('|', $this->session->userdata('swm_frapprvl')); $datarttoken =  (!empty($explodeddatart[0])) ? $this->encrypt->encode($this->session->userdata('swm_frapprvl')) : ''; $datartname = (!empty($explodeddatart[0])) ? $explodeddatart[1] : ''; ?>
                <select class="form-control" id="swm_frapprvl" onchange="swm_frapprvlfnc(this.value);">
                  <option value="<?php echo $datarttoken; ?>"><?php echo $datartname; ?></option>
                  <?php
                    for ($rt=0; $rt < sizeof($queryrouteto); $rt++) {
                    $prefix = (!empty($queryrouteto[$rt]['title'])) ? $queryrouteto[$rt]['title'].' ' : '';
                    $mname = (!empty($queryrouteto[$rt]['mname'])) ? $queryrouteto[$rt]['mname'][0].'. ' : '';
                    $suffix = (!empty($queryrouteto[$rt]['suffix'])) ? ' '.$queryrouteto[$rt]['suffix'] : '';
                    $name = $prefix.$queryrouteto[$rt]['fname'].' '.$mname.$queryrouteto[$rt]['sname'].$suffix;
                  ?>
                    <optgroup label="<?php echo $queryrouteto[$rt]['func']; ?>">
                      <option value="<?php echo $this->encrypt->encode($queryrouteto[$rt]['token'].'|'.$name); ?>"><?php echo $name; ?></option>
                    </optgroup>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-12">
                <hr>
              </div>
              <div class="col-md-12">
                <label><b>Cc:</b></label>
                <br><label>Office name:</label>
                <input type="text" class="form-control" id="office_name" onchange="ccon(this.value);" placeholder="Ombudsman Central Visayas" value="<?php echo $ccon; ?>">
              </div>
              <div class="col-md-12">
                <label>Office address:</label>
                <input type="text" class="form-control" id="office_address" onchange="ccoa(this.value);" placeholder="M. Velez St., Guadalupe, Cebu City" value="<?php echo $ccoa; ?>">
              </div>
            </div>
            </form>
          </div>
          <div class="tool-footer">
            <button type="button" class="btn btn-success btn-sm" onclick="savedata();">Submit / Route</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="<?php echo base_url(); ?>assets/common/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/common/selectize/dist/js/selectize.js"></script>

<script type="text/javascript">
  var base_url = window.location.origin+"/embis";
  $('#bindletterselectize').selectize();
  $('#swm_frapprvl').selectize();

  function bindletternv(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/bindletternv",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.iisno != '' && obj.embid != ''){
            $("#embidnv").html(obj.embid);
            $("#iisnv").html(obj.iisno);
            $("#lguprov").html(obj.lguprov);
            $("#datemonitored").html(obj.datemonitored);
            $("#brgyname").html(obj.brgyname);

        var htmldata = '<table border="1">'+
                          '<thead>'+
                            '<tr>'+
                              '<th width="70%"><center>Prohibited Act</center></th>'+
                              '<th width="30%"><center>Section Chapter VI, RA 9003</center></th>'+
                            '</tr>'+
                          '</thead>'+
                          '<tbody>';
          for (var i = 0; i < obj.vodata.length; i++) {
              htmldata += '<tr>'+
                             '<td class="tl pl10">'+obj.vodata[i].prohibited_act+'</td>'+
                             '<td>'+obj.vodata[i].section+';</td>'+
                           '</tr>';
          }
            htmldata +=   '</tbody>'+
                       '</table>';

            $('#vobdy_').html(htmldata);
        }
      }
    });
  }

  function setltrdtnv(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/setltrdtnv",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.ltrdt != ''){
            $("#dtdftd").html(obj.ltrdt);
        }
      }
    });
  }

  function prfxltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/prfxltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.prfxltr != ''){
            $("#prfxltr").html(obj.prfxltr);
        }
      }
    });
  }

  function fnmltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/fnmltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.fnmltr != ''){
            $("#fnmltr").html(obj.fnmltr);
        }
      }
    });
  }

  function miltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/miltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.miltr != ''){
            $("#miltr").html(obj.miltr);
        }
      }
    });
  }

  function lnltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/lnltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.lnltr != ''){
            $("#lnltr").html(obj.lnltr);
            $("#drln").html(obj.ulnltr);
        }
      }
    });
  }

  function sfxltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/sfxltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.sfxltr != ''){
            $("#sfxltr").html(obj.sfxltr);
        }
      }
    });
  }

  function desltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/desltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.desltr != ''){
            $("#desltr").html(obj.desltr);
            $("#drdes").html(obj.udesltr);
        }
      }
    });
  }

  function mctyltr(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/mctyltr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.mctyltr != ''){
            $("#mctyltr").html(obj.mctyltr);
        }
      }
    });
  }

  function swmoe(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/swmoe",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.swmoe != ''){
            $("#swmoe").html(obj.swmoe);
        }
      }
    });
  }

  function swrmvl(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/swrmvl",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.swrmvl != ''){
            $("#swrmvl").html(obj.swrmvl);
        }
      }
    });
  }

  function swmcinf(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/swmcinf",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.swmcinf != ''){
            $("#swmcinf").html(obj.swmcinf);
        }
      }
    });
  }

  function ccon(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/ccon",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.ccon != ''){
            $("#ccon").html(obj.ccon);
            $("#cc").html('Cc:');
        }
      }
    });
  }

  function ccoa(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/ccoa",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.ccoa != ''){
            $("#ccoa").html(obj.ccoa);
        }
      }
    });
  }

  function tom(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/tom",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $("#tom_").html(response);
      }
    });
  }

  function swm_frapprvlfnc(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/swm_frapprvlfnc",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){

      }
    });
  }

  function chngvw(token){
    $.ajax({
      url: base_url+"/Swm/Ajax/chngvw",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.chngvw == '2'){
            document.getElementById("firstpage").style.display = 'none';
            document.getElementById("secondpage").style.display = 'block';
            document.getElementById("buttonright").style.display = 'none';
            document.getElementById("buttonleft").style.display = 'block';
        }
        if(obj.chngvw == '1'){
            document.getElementById("firstpage").style.display = 'block';
            document.getElementById("secondpage").style.display = 'none';
            document.getElementById("buttonright").style.display = 'block';
            document.getElementById("buttonleft").style.display = 'none';
        }
      }
    });
  }


  function savedata(){
    var form_data = new FormData();

    // Read selected files
    form_data.append("bindletterselectize", document.getElementById('bindletterselectize').value);
    form_data.append("letter_date", document.getElementById('letter_date').value);
    form_data.append("prefix", document.getElementById('prefix').value);
    form_data.append("firstname", document.getElementById('firstname').value);
    form_data.append("middleinitial", document.getElementById('middleinitial').value);
    form_data.append("lastname", document.getElementById('lastname').value);
    form_data.append("suffix", document.getElementById('suffix').value);
    form_data.append("designation", document.getElementById('designation').value);
    form_data.append("lgu_name", document.getElementById('lgu_name').value);
    form_data.append("span_wrmvl", document.getElementById('span_wrmvl').value);
    form_data.append("swm_oe", document.getElementById('swm_oe').value);
    form_data.append("swm_ci", document.getElementById('swm_ci').value);
    form_data.append("office_name", document.getElementById('office_name').value);
    form_data.append("office_address", document.getElementById('office_address').value);
    form_data.append("routeto", document.getElementById('swm_frapprvl').value);

    // AJAX request
    $.ajax({
     url: base_url+'/Swm/Ajax/formdata',
     type: 'post',
     data: form_data,
     dataType: 'json',
     cache: false,
     contentType: false,
     processData: false,
     success: function (response) {
       if(response.postdata.status == 'success'){
         window.location.href= base_url+'/Swm/Sweet';
       }

       if(response.postdata.status == 'failed'){
         if(response.postdata.bindletterselectize == ''){
           $('#error_bindletterselectize').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_bindletterselectize').removeClass();
         }

         if(response.postdata.designation == ''){
           $('#error_designation').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_designation').removeClass();
         }

         if(response.postdata.firstname == ''){
           $('#error_firstname').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_firstname').removeClass();
         }

         if(response.postdata.lastname == ''){
           $('#error_lastname').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_lastname').removeClass();
         }

         if(response.postdata.letter_date == ''){
           $('#error_letter_date').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_letter_date').removeClass();
         }

         if(response.postdata.lgu_name == ''){
           $('#error_lgu_name').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_lgu_name').removeClass();
         }

         if(response.postdata.prefix == ''){
           $('#error_prefix').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_prefix').removeClass();
         }

         if(response.postdata.span_wrmvl == ''){
           $('#error_span_wrmvl').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_span_wrmvl').removeClass();
         }

         if(response.postdata.swm_ci == ''){
           $('#error_swm_ci').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_swm_ci').removeClass();
         }

         if(response.postdata.swm_oe == ''){
           $('#error_swm_oe').addClass("fa fa-exclamation-circle");
         }else{
           $('#error_swm_oe').removeClass();
         }

         if(response.postdata.swm_oe == '' || response.postdata.swm_ci == '' || response.postdata.span_wrmvl == '' || response.postdata.prefix == '' || response.postdata.lgu_name == '' || response.postdata.letter_date == '' || response.postdata.lastname == '' || response.postdata.firstname == ''
        || response.postdata.designation == '' || response.postdata.bindletterselectize == ''){
           alert('Please fill in required fields.');
         }
       }
     }
    });
  }


</script>
