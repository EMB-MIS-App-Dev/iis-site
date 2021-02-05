<!DOCTYPE html>
<html>
<head>
	<title>Travel Order</title>
	<script type="text/javascript" src="assets/js/code39.js"></script>
	<style type="text/css">
		html, body{text-align:center;font-family:times;background-color:#333333;font-size:16px;} /*arial narrow*/
		.main{text-align:center;display:inline-block;background-color:#ffffff;padding:20px;}
    	/*.frm{height:297mm;width:210mm;padding:30px;border:2px solid #000 !important;height:100%;}*/
    	.head{margin-top:-30px;}
    	table{width:100%;border-collapse:collapse;margin:auto;}
    	table td{padding:3px;}
    	.pt20{padding-top:20px;}
    	.tr{text-align:right;}
    	.tl{text-align:left;}
    	.tb{font-weight:bold;}
    	.pl10{padding-left:10px}
    	.pr10{padding-right:10px}
    	.ti{font-style:italic;}
    	.t20{font-size:20px;}
    	.bt{border-bottom:1px solid #000;}
    	.tin{text-indent:50px;}
    	hr{height: 1px;color:#000;background-color:#000;border: none}
    	@media print{
	      	html, body{-webkit-print-color-adjust:exact;height:297mm;width:210mm;font-size:18px !important;margin-top:-10px;} 
	      	.frm{border:1px solid #000 !important;height:100%;margin-top:20px;}
	    	}
	</style>
</head>

<body>
	<div class="main">
		<div class="frm">
			<img class="head" src="image/head2.jpg" width="100%">
			<br>
			<table>
				<tr class="tb t20">
					<td>TRAVEL ORDER</td>
				</tr>
				<tr>
					<td>January 10, 2019</td>
				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td class="tl" width="15%">Name</td>
					<td width="1%">:</td>
					<td width="43%" class="tl tb">Stephen Lee</td>
					<td class="tl" width="12%">Section</td>
					<td width="1%">:</td>
					<td width="28%" class="tl tb">MIS</td>
				</tr>
				<tr class="bt">
					<td class="tl">Position</td>
					<td width="1%">:</td>
					<td class="tl tb">Supervising EMS I</td>
					<td class="tl" width="12%">Division</td>
					<td width="1%">:</td>
					<td width="28%" class="tl tb">EMED</td>
				</tr>
				<tr>
					<td class="tl pt20" width="15%">Departure Date</td>
					<td class="pt20" width="1%">:</td>
					<td width="43%" class="tl tb pt20">January 10, 2019</td>
				</tr>
				<tr>
					<td class="tl" width="15%">Arrival Date</td>
					<td width="1%">:</td>
					<td width="43%" class="tl tb">January 15, 2019</td>
				</tr>
				<tr>
					<td class="tl">Official Station</td>
					<td>:</td>
					<td class="tl tb" colspan="4">EMB Central Office</td>
				</tr>
				<tr>
					<td class="tl">Destination</td>
					<td>:</td>
					<td class="tl tb" colspan="4">USA</td>
				</tr>
			</table>
			<hr>
			<p class="tl tb">Purpose of Travel:</p>
			<div style="height:200px;">
				<p class="tl tin" style="text-align:justify !important;">
				QWERTYUIO ASBDjaSBd knasd 
			</p>
			</div>
			<hr>
			<table>
				<tr>
					<td class="tl" width="30%">Per diems/Expenses Allowed</td>
					<td width="1%">:</td>
					<td class="tl tb">123</td>
				</tr>
				<tr>
					<td class="tl" width="30%">Assistant or Laborers Allowed</td>
					<td width="1%">:</td>
					<td class="tl tb">321</td>
				</tr>
			</table>
			<br>

			<table>
				<tr>
					<td class="tl tb" colspan="3">Appropriations to which travel should be charge</td>
				</tr>
				<tr>
					<td class="tl" width="30%">Remarks of Special Instruction</td>
					<td width="1%">:</td>
					<td class="tl tb">remarkssssss</td>
				</tr>
				<tr>
					<td class="tl" width="30%">Date of Submission</td>
					<td width="1%">:</td>
					<td class="tl tb">January 30, 2019</td>
				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td class="tl tb" colspan="3">Certification:</td>
				</tr>
				<tr>
					<td class="tl tin" style="text-align:justify !important;">
						This is to certify that the travel is necessary and is connected with the functions of the official/Employee and this Division/Section/Unit.
					</td>
				</tr>
			</table>
			<hr>
			<p class="tl">Approved:</p>
			<!-- <table>
				<tr style="text-align:right;">
					<?php if($appdate <= "2019-11-04"){ ?>
						<td class="tb" width="60%"><img src="image/rdesig.png"></td>
					<?php }else{ ?>
						<td class="tb"><img style="width:60%!important;" src="image/rdclaudio2.png"></td>
					<?php } ?>

					<td class="tr" width="40%" style="text-align:center;">
						<div style="margin-top:-30px;">
							<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F<?php echo"(EMB7TO".date('Y', strtotime($appdate))."R".$toid.")";?>%2F&choe=UTF-8" style="height:150px;">
							
						</div>
					</td>
				</tr>
			</table> -->
			<hr>
			<p class="tl tb" style="font-size:12px;">
				Subject to the condition that (1)official/employee concerned has no outstanding cash advance on previous travel, (2)he/she shall settle the cash advance that may be given him/her present hereto within thirty (30) Days after date of return to permanent station and, (3)other applicable provisions of COA Circular N0.96-004,dated April 19,1996.
			</p>
		</div>
	</div>
</body>
</html>