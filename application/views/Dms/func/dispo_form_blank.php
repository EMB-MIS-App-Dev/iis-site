<html>
<head>
	<title>Disposition Form</title>
	<style type="text/css">
		html, body{text-align:center;font-family:times;background-color:#333333;font-size:16px;} /*arial narrow*/
		.main{text-align:center;display:inline-block;background-color:#ffffff;padding:20px;}
    	.frm{height:300mm;width:210mm !important;padding:30px;} /*border:1px solid #000;*/
    	.head{margin-top:-30px;}
    	 table{width:100%;border-collapse:collapse;margin:auto;}
    	.pt20{padding-top:20px;}
    	.tr{text-align:right;}
    	.tl{text-align:left;}
    	.tb{font-weight:bold;}
			.wr{word-wrap: break-word;}
    	.pl10{padding-left:10px}
    	.pr10{padding-right:10px}
    	.ti{font-style:italic;}
    	.tin100{text-indent:100px;}
    	.tin50{text-indent:50px;}
    	.tu{text-decoration:underline;}
    	.tc{text-align:center;}
			.tdh{text-align:center; height: 23px !important;}
    	.tj{text-align: justify;}
    	.bb{border-bottom:1px solid #000000;}
    	.mr200{margin-right:200px;}
    	.tblr{font-size:13px; word-wrap: break-word;}
    	.f12{font-size:12px;}
    	.f14{font-size:14px;}
    	 hr{height: 1px;color: #000;background-color: #000;border: none;}
			.tbl1 tr td:nth-child(1), .tbl1 tr td:nth-child(3){ text-align: center}
    	}
    	@media print{
	      	html, body{-webkit-print-color-adjust:exact;height:350mm !important;width:210mm !important;font-size:18px !important;}
    	    .frm{height:350mm !important;width:210mm !important;border:1px solid #000;}
	    	}
    	@page {
			margin: 0;
		}
	</style>
	  <link href="<?php echo base_url(); ?>assets/common/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="main">
		<div class="frm">
			<img class="head" src="<?php echo base_url('../iis-images/document-header/'.$header); ?>" width="100%">
			<p class="tb tc">DISPOSITION FORM</p>
			<div style="border:1px solid #000000;font-size:8px; display:none">
				<table class="tbl1" style="font-size:12px;">
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Office of the Director (OD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Climate Change Division (CCD)</td>
				</tr>
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Legal Division (LD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Environmental Impact Assessment Mgt. Division (EIAMD)</td>
				</tr>
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Planning Policy &#38; Program Devt. Division (PPPDD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Environmental Education &#38; Information Division (EEID)</td>
				</tr>
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Administrative &#38; Finance Management Division (AFMD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Bids and Awards Committee Secretariat (BACS)</td>
				</tr>
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Environmental Research &#38; Lab Services Division (ERLSD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Manila Bay Office (MBO)</td>
				</tr>
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Environmental Quality Division (EQD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Philippine Environment Partnership Program (PEPP)</td>
				</tr>
				<tr>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Solid Waste Mgt. Division (SWMD)</td>
					<td width="2%"><i class="far fa-square"></i></td>
					<td width="48%">Philippine Ozone Desk (POD)</td>
				</tr>
			</table>
			</div>
			<br>
			<table>
				<tr>
					<td width="10%" class="tb">Doc. Date</td>
					<td width="1%">:</td>
					<td width="20%" class="tl"><?php echo date('F d, Y', strtotime($trans_log[0]['date_in'])); ?></td>
					<td width="65%" rowspan="2" class="wr"><span class="tb">Company Name 	</span>: <?php echo $trans_data[0]['company_name']; ?></td>
					<td rowspan="2" class="tr">
						<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F<?php echo $trans_data[0]['token']; ?>%2F&choe=UTF-8" alt="QRCODE" width="50px" height="50px">
					</td>
				</tr>
				<tr>
					<td width="10%" class="tb">IIS No.</td>
					<td width="1%">:</td>
					<td width="20%" class="tl"><?php echo $trans_data[0]['token']; ?></td>
					<td></td>
				</tr>
			</table>
			<hr>
			<table>
				<tr>
					<td width="15%" class="tb">Subject / Title:</td>
					<td class="f14 tl"><?php echo $trans_data[0]['subject']; ?></td>
				</tr>
			<!-- 	<tr>
					<td class="bb pt20">Sample only Subject / Title Status of Serviceability of Distributed PPEx in 2011 </td>
				</tr> -->
			</table>
			<hr>
			<p class="tl tj" style="font-size:12px;"><span class="tb tu">TO: All Officials/Personnel Concerned:</span> <br>Please accomplish and route this properly with the corresponding attached communication/documents. The Official or employee in-charge to whom this document is routed shall act promptly and expeditiously without discrimination as prescribed in the SECSIME or within fifteen (15) working days from receipt thereof, failure to do is punishable by LAW under RA 6713 and negligence to Memorandum Circular No. 44 issued by the Office of the President of the Philippines "Directing all Government Agencies and Instrumentalities, including government-owned or controlled corporations to respond to all public requests and concerns within 15 days (15 from the receipt thereof)</p>
			<p class="tl f12">For strict compliance.</p>
			<table border="1" id="tbroute">
				<tr style="text-align: center">
					<td colspan="5" class="tb">ROUTED</td>
				</tr>
				<tr>
					<td width="15%" class="tc"><span class="tb">BY</span> <br> <span class="f12">(Official Code/ <br> Sender Initial)</span></td>
					<td width="15%" class="tc"><span class="tb">DATE</span> <br><span class="f12">(mm/dd/yy)</span></td>
					<td width="15%" class="tc"><span class="tb">TO</span> <br> <span class="f12">(Official Code/ <br> Receiver Initial)</span></td>
					<td width="15%" class="tc"><span class="tb">TIME</span> <br><span class="f12">(AM/PM)</span></td>
					<td width="40%" class="tc"><span class="tb">ACTION / REMARKS / STATUS</span></td>
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
			<p class="tl tb">Use code for comment/instruction and desired action:</p>
			<table class="tl" style="font-size:12px;">
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
			<p class="tl tb ti tj" style="font-size:12px;"><span class="tu">Important Reminder !</span> <br> Do not tamper. Continue on separate sheet if necessary. Attach this always with the document to be routed as this shall form an integral part of the document process.</p>
		</div>
	</div>
</body>
</html>
