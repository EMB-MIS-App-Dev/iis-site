<html>
<head>
	<title>PDS</title>

  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="css/style.css" rel="stylesheet">
	<link href="css/style-responsive.css" rel="stylesheet" /> -->
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

	<link href="pdsform.css" rel="stylesheet" media="all">

	<style type="text/css">
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
	</style>
</head>

<body style="background-color:#2b2b2b">

<center>

<div style="width:1080px;background-color:#fff;padding-top:15px;padding-bottom:15px;"><!--outline-->
<!--start page 1-->
	<div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">

	<!--start header-->
		<table style="width:1043px;">
			<tr>
				<td colspan="2" style="font-size:10px;font-style:italic;font-weight:bold;padding-left:5px;">CS FORM 212 <br/>Revised 2017</td>
			</tr>
			<tr>
				<td colspan="2" style="padding:20px;font-weight:900;font-size:35px;text-align:center;">
					PERSONAL DATA SHEET
				</td>
			</tr>
			<tr>
				<td colspan="2" style="font-size:12.5px;font-style: italic;font-weight:bold;padding:0px 1px 0px 5px;">
					WARNING: Any misinterpretation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against
					the person concerned.<br/><br/>
					READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.
					<br>
					<span style="font-style:normal;font-weight:normal;">
						Print legibly. Tick appropriate boxes and use separate sheet if necessary. Indicate N/A if not applicable.
						<strong>DO NO ABBREVIATE.</strong>
						<input class="pull-right" type="text" value=" (Do not fill up. For CSC use only) " id="csid2" style="width:200px;color:#000;border:1px solid #000;">
						<input class="pull-right" type="text"  id="csidnew" value="1. CS ID No." style="width:65px;background-color:#696969;border:1px solid #000;">
					</span>

				</td>
			</tr>

		</table>
	<!--end header-->

	<!--end page 1-->
		<?php require_once 'hrpds/nam.php'; ?>
		<?php require_once 'hrpds/inf1.php'; ?>
		<?php require_once 'hrpds/inf2.php'; ?>
		<?php require_once 'hrpds/inf3.php'; ?>
		<?php require_once 'hrpds/inf4.php'; ?>
		<?php require_once 'hrpds/fam.php'; ?>
		<?php require_once 'hrpds/edu.php'; ?>

	</div>

<!--start page 2-->
<div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">

		<!-- civil -->
		<?php require 'hrpds/civ.php'; ?>
		<!-- work -->
		<?php require 'hrpds/xp.php'; ?>

</div>
<!--end page 2-->

<!--start page 3-->
<div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">

		<!--start vol work-->
		<?php require 'hrpds/vol.php'; ?>
		<!--start trainings-->
		<?php require 'hrpds/sem.php'; ?>
		<!--start other info-->
		<?php require 'hrpds/oth.php'; ?>

</div>
	<!--end page 3-->

<!--start page 4-->
<div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">

		<!--quest-->
		<?php require 'hrpds/que.php'; ?>
		<!--ref-->
		<?php require 'hrpds/ref.php'; ?>
		<!--ctc-->
		<?php require 'hrpds/ctc.php'; ?>

</div>

		<!--work 2-->
		<?php require 'hrpds/xp2.php'; ?>
		<!--work 3-->
		<?php require 'hrpds/xp3.php'; ?>

		<!--start vol work-->
		<?php require 'hrpds/vol2.php'; ?>

		<!--start trainings-->
		<?php require 'hrpds/sem2.php'; ?>
		<!--start trainings-->
		<?php require 'hrpds/sem3.php'; ?>
		<!--start trainings-->
		<?php require 'hrpds/sem4.php'; ?>

		<!--start other info-->
		<?php //require 'hrpds/oth2.php'; ?>
		<!--start other info-->
		<?php //require 'hrpds/oth3.php'; ?>
		<!--start other info-->
		<?php //require 'hrpds/oth4.php'; ?>

</div><!--end outline-->
</center>
</body>

</html>
