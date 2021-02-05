<!DOCTYPE html>
<html>

<head>
	<title>ECC</title>
 	<meta charset="utf-8">
 	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
 	<meta name="viewport" content="width=1024, initial-scale=1, shrink-to-fit=no">
 	<style type="text/css">
	 	body{background-color:gray;font-family:times;}
	 	/* #head{width:6.3in;height:1.2in;margin-left:85px;} */
	 	#head{max-width: 100%; max-height: 100%; padding-top: 12px}
	 	#container{background-color:#ffffff;width:8.27in;margin:auto;margin-bottom:5px;height:297mm;}/*height:11.69in;*/
	 	#main{width:5.80in;margin:auto;padding-left:20px; margin-bottom: 50px }/*height:9.5in;*/
		.hc{width:7in;height:1.4in; margin:auto;}
		.subj{font-family: "Times New Roman"; font-weight: bold; text-align: center; font-size: 20px}
	 	.ul{text-decoration:underline;}
	 	.up{text-transform:uppercase;}
	 	.tb{font-weight:bold;}
	 	.tn{font-weight:normal;}
	 	.ti50{text-indent:50px;}
	 	.tj{text-align: justify; line-height: 1.4;}
	 	.fs9{font-size:9px;}
	 	.footer {width:6.2in; height:1in; text-align:center; position:fixed; bottom:0; display:none;}

	 	#btprint{ background-color:green;color:#fff;text-align:center;display:inline-block; }

		@page {
		  size: A4;
		}
		@media print {
		  .footer {
		    position: fixed;
		    bottom: 0;
		    margin-left:-40px !important;
		    margin-bottom:1px !important;
		    display:block;
		    page-break-after:always;
		  }

  	 	#foot{width: 100%; max-height: 100%; object-fit: contain}
		  /* #foot1{color: red;} */
 			/* #foot2{color: #004ad6;} */
		  #note, #btprint{ display:none; }
		}
 	</style>
</head>

<?php
	$type_details = $trans_data[0]['type_description'];
	if($trans_data[0]['system'] == 4) {
		$type_details = $trans_data[0]['type_description'].' Application';
	}

	// print_r($trans_log); exit;
?>

<body>
	<center><button id="btprint" onclick="myFunction()" >Print this page</button> <p class="ti" id="note">Note: Print in A4 Size only</p></center>
	<div id="container">
		<div class="hc">
			<img class="head" src="<?php echo base_url('../iis-images/document-header/'.$header); ?>" width="100%">
		</div>
		<br><br><br>
		<div id="main">
			<p class="subj"> ACKNOWLEDGEMENT RECEIPT </p>
			<br />
			<p><?php echo $today = date("F d, Y"); ?></p>
			<br>
			<p>Greetings!</p>
			<p class="tj">This is to Acknowledge Receipt of your <?php echo $type_details; ?> with the Subject : <?php echo trim($trans_data[0]['subject']);?>, submitted on <?php echo date("F d, Y, g:ia", strtotime($trans_log[0]['date_out'])); ?>.</p>
			<br />
			<p class="tj">Your transaction has been tagged as IIS No. <?php echo $trans_data[0]['token']; ?> with Company ID <?php echo $trans_data[0]['emb_id']; ?>. For follow-ups, you may provide the given details.</p>
			<p class="tj">For further inquiries, you may contact our designated EMB Office in your area from Monday to Friday 8:00 a.m. to 5:00 p.m. office hours, or email us at recordsco@emb.gov.ph.</p>
			<p class="tj">Please be guided accordingly.</p>
			<p class="tj">Thank you.</p>
			<br><br><br><br>
			<div>
				<img align="right" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F<?php echo $trans_data[0]['trans_no']; ?>%2F&choe=UTF-8" style="height:100px; z-index: 999; display: block; margin-top: -30px">
				<!-- <p>
					<p><strong>ENGR. WILLIAM P. CUÑADO</strong><br>
						<span>Regional Director</span>
					</p>
				</p> -->
			</div>
			<br> <br>
			<div class="footer">
				<!-- <p id="foot1">* This notice is online-generated with tracking number <?php // echo $trans_data[0]['trans_no']; ?>. *</p> -->
				<!-- <p id="foot2"><strong>Diliman, Quezon City, Philippines, 1101</strong> <br>
						Tel. Nos. (+6332) 3469426,3453905 Telefax No.3461647 <br>
						Email: <strong>emb_regionseven@yahoo.com.ph</strong>
				</p> -->
				<?php
					if(!empty($footer)) {
					?>
						<img align="left" src="<?php echo base_url('../iis-images/document-footer/'.$footer[0]['file_name']); ?>" id="foot">
					<?php
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	function myFunction() {
	  window.print();
	}
</script>
