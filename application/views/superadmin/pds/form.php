
<html>
  <head>
    	<title>PDS</title>
      <!-- <link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
      <!-- <link href="<?php echo base_url(); ?>assets/common/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
      <link href="<?php echo base_url(); ?>assets/css/pds.css" rel="stylesheet" type="text/css">
      <script src="<?php echo base_url(); ?>assets/common/jquery/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/common/bootstrap/js/bootstrap.bundle.min.js"></script>
  </head>

  <body id="main_body" style="background-color:#2b2b2b">
    <center>
      <?php
          function setValue($val, $set="N/A") {
              return !empty(trim($val)) ? trim($val) : $set;
          }
      ?>
      <div style="width:1080px;background-color:#fff;padding-top:15px;padding-bottom:15px;">
      	<div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">

            <!-- #########################  PDS HEADER ######################### -->
        		<table>
          			<tr>
        				    <td colspan="2" style="font-size:10px;font-style:italic;font-weight:bold;padding:2px 5px;"> CS FORM 212<br/>Revised 2017 </td>
          			</tr>
          			<tr>
            				<td colspan="2" style="padding:0;font-weight:900;font-size:35px;text-align:center;"> PERSONAL DATA SHEET </td>
          			</tr>
          			<tr>
            				<td colspan="2" style="font-size:12.5px;font-style: italic;font-weight:bold;padding:0px 1px 0px 5px;">
            					WARNING: Any misinterpretation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against
            					the person concerned.<br/>
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

            <!--end page 1-->
      			<table>
          			<tr> <td colspan="4" class="headall" style="font-weight:bold;">&nbsp;I. PERSONAL INFORMATION</td> </tr>
          			<tr>
          				<td class="bgall" style="width:18%;font-size:12px;padding:7px 7px 7px 5px !important;border-right:solid;background-color:#eaeaea;"> 2. SURNAME </td>
          				<td colspan="3" style="font-size:12px;font-weight:bold;padding:7px 7px 7px 5px !important;border-bottom:solid;"> <?=$personal_info->surname?> </td>
          			</tr>
          			<tr>
          				<td class="bgall" style="width:18%;font-size:12px;padding:7px 7px 7px 5px !important;border-right:solid;background-color:#eaeaea;"> <span style="padding-left:14px;">FIRST NAME</span> </td>
          				<td style="width: 65%;font-size:12px;font-weight:bold;padding:7px 7px 7px 5px !important;border-right:solid;"> <?=$personal_info->first_name?> </td>
          				<td colspan="2" class="bgall" style="width:17%;font-size:10px;padding-top:0px;background-color:#eaeaea;border-right:solid;">
          					NAME EXTENSION(JR., SR.) <font size="2"> <b> <?=$personal_info->name_extension?> </b></font>
          				</td>
          			</tr>
          			<tr>
          				<td class="bgall" style="width:18%;font-size:12px;padding:7px 7px 7px 5px !important;border-bottom:solid;border-right:solid;background-color:#eaeaea;"> <span style="padding-left:14px;">MIDDLE NAME</span> </td>
          				<td colspan="3" style="font-size:12px;font-weight:bold;padding:7px 7px 7px 5px !important;border-top:solid;border-bottom:solid;"> <?=$personal_info->middle_name?> </td>
          			</tr>
            </table>

            <table id="tbsdob" style="width:1043px;">
                <tr>
            				<td class="bgall" style="width:18.1%;font-size:12px;padding:0px 0px 0px 5px !important;border-right:solid;">
            					3. DATE OF BIRTH
            					<span style="font-size:13px">(mm/dd/yyyy)</span>
            				</td>
            				<td style="width:25%;text-align:center;font-size:12px;border-right:solid;">
                      <b><?=date('m/d/Y', strtotime($personal_info->date_of_birth))?> </b>
                    </td>
            				<td class="bgall" style="width:25%;font-size:12px;padding:0px 0px 0px 5px !important;border-right:solid;">
                      16. CITIZENSHIP </br>
                    </td>
            				<td colspan="2" style="font-size:12px;padding:0px 0px 0px 5px !important;border-right:solid;">
            					<input type="checkbox" name="cit1" <?=($personal_info->citizenship==1)?'checked':''?> > Filipino
                      <input type="checkbox" name="cit2" style="margin-left:25px;margin-top:10px;" <?=($personal_info->citizenship!=1)?'checked':''?>> Dual Citizenship </br>
                      <span style="margin-left:110px;">
            						<input type="checkbox" name="birth" style="" > by birth &nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="birth" style="" > by naturalization
                      </span>
            				</td>
          			</tr>
          			<tr >
          				<td class="bgall tdborder" style="border-left:none;font-size:12px;padding: 5px !important;">4. PLACE OF BIRTH</td>
          				<td class="tdborder" style="border-left:none;font-size:12px;padding:5px;text-align:center;"><b><?=$personal_info->place_of_birth?></b></td>
          				<td class="bgall " style="font-size:12px;padding:5px;text-align:center;border-right:solid;">If holder of dual citizenship,</td>
          				<td colspan="2" style="font-size:12px;padding:5px;text-align:center;border-right:solid;text-indent:20px;">Pls. indicate country:</td>
          			</tr>
          			<tr >
          				<td class="bgall " style="border-right: solid;font-size:12px;padding:0px 0px 0px 5px !important;">5. SEX</td>
          				<td class="" style="border-right:solid;font-size:12px;padding:5px;">
          					<input type="checkbox" name="" style="" <?=($personal_info->sex=='M')?'checked':''?>> Male
                    <span style="padding-left:65px;"><input type="checkbox" name="" style="" <?=($personal_info->sex=='F')?'checked':''?>> Female</span>
                  </td>
          				<td class="bgall " style="font-size:12px;padding:5px;text-align:center;border-right:solid;">please indicate the details.</td>
          				<td colspan="2" style="font-size:12px;padding:5px;text-align:center;border-right:solid;"> <?=$personal_info->indicate_country?> </td>
          			</tr>
      		</table>
      		<table style="width:1043px;" >
              <tr>
                  <?php
                    switch ($personal_info->civil_status) {
                      case 'SINGLE': $single = 'checked'; break;
                      case 'MARRIED': $married = 'checked'; break;
                      case 'WIDOWED': $widowed = 'checked'; break;
                      case 'SEPARATED': $separated = 'checked'; break;
                      default: $others = 'checked'; break; // OTHERS
                    }
                  ?>
                  <td class="bgall tdborder" style="width:18%;border-left:none;border-bottom:none;font-size:12px;padding:0px 0px 0px 5px !important;">6. CIVIL STATUS</td>
                  <td rowspan="2" class="tdborder" style="width:25%;border-left:none;border-bottom:none;font-size:12px;padding:0px 0px 0px 5px !important;">
                  	<input type="checkbox" name="" style="" <?=$single?>> Single
                    <span style="padding-left:60px;"><input type="checkbox" name="" style="" <?=$married?>> Married</span><br>
                    <input type="checkbox" name="" style="" <?=$widowed?>> Widowed
                    <span style="padding-left:43px;"><input type="checkbox" name="" style="" <?=$separated?>> Separated</span><br>
                    <input type="checkbox" name="" style="" <?=$others?>> Other/s:
                  </td>
                  <td class="bgall" style="width:16.91%;font-size:12px;padding:0px 0px 0px 5px !important;border-right:solid;border-top:solid;border-bottom:none;"> 17. RESIDENTIAL ADDRESS </td>
                  <td style="width:20%;font-size:12px;padding:0px !important;border-top:solid;text-align:center;">
                   	<span style="text-decoration:underline;"> <?=$residential->house_block_lot_no?> </span>
                   <br>
                   <span style="font-style:italic;font-weight:bold;">House/Block/Lot No.</span>
                  </td>
                  <td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;padding:0px !important;">
                  	<span style="text-decoration: underline;"> <?=$residential->street?> </span>
                   <br>
                   <span style="font-style:italic;font-weight:bold;">Street</span>
                  </td>
              </tr>
        			<tr>
          				<td class="bgall" style="width:18%;border-left:none;border-right:solid;font-size:12px;padding:5px;"></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;padding:5px;border-right:solid;"> </td>
          				<td style="width:20%;font-size:12px;padding:5px;border-top:solid;text-align: center;">
          				 	<span style="text-decoration: underline;"> <?=$residential->subdivision_village?> </span> <br>
                    <span style="font-style:italic;font-weight:bold;">Subdivision/Village</span>.
          				</td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;padding:0px !important;">
          					<span style="text-decoration: underline;"> <?=$residential->barangay?> </span> <br>
          		      <span style="font-style:italic;font-weight:bold;">Barangay</span>
          				</td>
        			</tr>
        			<tr>
          				<td class="bgall" style="width:18%;border-left:none;border-top:solid;border-right:solid;font-size:12px;padding:0px 0px 0px 5px !important;">7. HEIGHT (m)</td>
          				<td class="tdborder" style="width:25%;border-left:none;border-bottom:none;border-top:solid;font-size:12px;padding:5px;text-align:center;"><b><?=$personal_info->height?></b></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;padding:5px;border-right:solid;"> </td>
          				<td style="width:20%;font-size:12px;border-top:solid;text-align: center;padding:0px !important;">
          				 	<span style="text-decoration: underline;"> <?=$residential->city_municipality?> </span> <br>
          		      <span style="font-style:italic;font-weight:bold;">City/Municipality</span>
          				</td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;padding:0px 0px 0px 5px !important;">
          					<span style="text-decoration: underline;"> <?=$residential->province?> </span> <br>
      			        <span style="font-style:italic;font-weight:bold;">Province</span>
          				</td>
        			</tr>
        			<tr>
          				<td class="bgall" style="width:18%;border-left:none;border-top:solid;border-right:solid;font-size:12px;padding:7px 7px 7px 5px !important;">8. WEIGHT (kg)</td>
          				<td class="tdborder" style="width:25%;border-left:none;border-bottom:none;border-top:solid;font-size:12px;text-align:center;padding:0px 0px 0px 5px !important;"><b><?=$personal_info->weight?></b></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;border-right:solid;text-align:center;">ZIP CODE</td>
          				<td style="width:20%;font-size:12px;border-top:solid;text-align:center;padding:0px 0px 0px 5px !important;"> <?=$residential->zip_code?> </td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;"></td>
        			</tr>
      				<tr>
          				<td class="bgall tdborder" style="width:18%;border-left:none;border-bottom:solid;font-size:12px;padding:0px 0px 0px 5px !important;">9. BLOOD TYPE</td>
          				<td class="tdborder" style="width:25%;border-left:none;border-bottom:solid;font-size:12px;padding:5px;text-align:center;"><b><?=$personal_info->blood_type?></b></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;padding:5px;border-right:solid;border-top:solid;border-bottom:none;"> 18. PERMANENT ADDRESS </td>
          				<td style="width:20%;font-size:12px;padding:0px !important;border-top:solid;text-align: center;">
          				 	<span style="text-decoration:underline;"> <?=$permanent->house_block_lot_no?> </span> <br>
      			        <span style="font-style:italic;font-weight:bold;">House/Block/Lot No.</span>
          				</td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;padding:0px !important;">
          					<span style="text-decoration: underline;"> <?=$permanent->street?> </span> <br>
      			        <span style="font-style:italic;font-weight:bold;">Street</span>
          				</td>
        			</tr>
        			<tr>
          				<td class="bgall" style="width:18%;border-left:none;border-right:solid;font-size:12px;padding:0px 0px 0px 5px !important;">10. GSIS ID</td>
          				<td class="tdborder" style="width:25%;border-left:none;border-bottom:none;border-top:none;font-size:12px;padding:0px !important;text-align:center;"><b><?=setValue($personal_info->gsis_id)?></b></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;padding:0px !important;border-right:solid;"> </td>
          				<td style="width:20%;font-size:12px;padding:0px !important;border-top:solid;text-align: center;">
            				 	<span style="text-decoration: underline;"> <?=$permanent->subdivision_village?> </span> <br>
        				      <span style="font-style:italic;font-weight:bold;">Subdivision/Village</span>.
          				</td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;padding:0px !important;">
            					<span style="text-decoration: underline;"> <?=$permanent->barangay?> </span> <br>
          			      <span style="font-style:italic;font-weight:bold;">Barangay</span>
          				</td>
        			</tr>
        			<tr>
          				<td class="bgall" style="width:18%;border-left:none;border-top:solid;border-right:solid;font-size:12px;padding:5px;">11. PAG-IBIG ID NO.</td>
          				<td class="tdborder" style="width:25%;border-left:none;border-bottom:none;border-top:solid;font-size:12px;padding:5px;text-align:center;"><b><?=setValue($personal_info->pag_ibig_id)?></b></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;padding:5px;border-right:solid;"> </td>
          				<td style="width:20%;font-size:12px;padding:0px !important;border-top:solid;text-align: center;">
            				 	<span style="text-decoration: underline;"><?=$permanent->city_municipality?> </span> <br>
            		      <span style="font-style:italic;font-weight:bold;">City/Municipality</span>
          				</td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;padding:0px !important">
                			<span style="text-decoration: underline;"> <?=$permanent->province?> </span> <br>
                      <span style="font-style:italic;font-weight:bold;">Province</span>
          				</td>
        			</tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="width:18%;border-left:none;border-top:solid;border-right:solid;font-size:12px;padding:5px !important;">12. PHILHEALTH NO.</td>
          				<td class="tdborder" style="width:25%;border-left:none;border-bottom:none;border-top:solid;font-size:12px;padding:0px !important;text-align:center;"><b><?=setValue($personal_info->philhealth_no)?></b></td>
          				<td class="bgall" style="width:16.91%;font-size:12px;padding:0px !important;border-right:solid;text-align:center;">ZIP CODE</td>
          				<td style="width:20%;font-size:12px;padding:7px !important;border-top:solid;text-align:center;"> <?=$permanent->zip_code?> </td>
          				<td style="width:20%;font-size:12px;border-right:solid;border-top:solid;text-align: center;"></td>
        			</tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:7px 7px 7px 5px !important;border-right:solid;background-color:#eaeaea;">
          					<span>13. SSS NO. </span>
          				</td>
          				<td style="font-size:12px;padding:5px;border-right:solid;text-align:center;"><b><?=setValue($personal_info->sss_no)?></b></td>
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;background-color:#eaeaea;"> <span>19. TELEPHONE NO. </span> </td>
          				<td style="font-size:12px;padding:5px;border-right:none;text-align:center;"><b><?=setValue($personal_info->telephone_no)?></b></td>
          				<td style="font-size:12px;padding:5px;border-right:none;text-align:center;"></td>
        			</tr>
        			<tr style="border-bottom:solid;">
            			<td class="bgall" style="font-size:12px;padding:7px 7px 7px 5px !important;border-right:solid;background-color:#eaeaea;">
            				<span>14. TIN NO. </span>
            			</td>
            			<td style="font-size:12px;padding:5px;border-right:solid;text-align:center;"><b><?=setValue($personal_info->tin_no)?></b></td>
            			<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;background-color:#eaeaea;">
            				<span>20. MOBILE NO. </span>
            			</td>
            			<td style="font-size:12px;padding:5px;border-right:none;text-align:center;"><b><?=setValue($personal_info->cellphone_no)?></b></td>
            			<td style="font-size:12px;padding:5px;border-right:none;text-align:center;"></td>
        			</tr>
        			<tr>
          				<td class="bgall" style="font-size:12px;padding:7px 7px 7px 5px !important;border-right:solid;background-color:#eaeaea;">
          					<span>15. AGENCY EMPLOYEE NO. </span>
          				</td>
          				<td style="font-size:12px;padding:5px;border-right:solid;text-align:center;"><b><?=setValue($personal_info->agency_employee_no)?></b></td>
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;background-color:#eaeaea;">
          					<span>21. EMAIL ADDRESS(if any) </span>
          				</td>
          				<td style="font-size:12px;padding:5px;border-right:none;text-align:center;"><b><?=setValue($personal_info->email_address)?></b></td>
          				<td style="font-size:12px;padding:5px;border-right:none;text-align:center;"></td>
        			</tr>
      		</table>
      		<!--start family bg-->
          <?php
              function child_birthdate($birthdate='') {
                  return (!empty($birthdate) && $birthdate != '') ? date('m/d/Y', strtotime($birthdate)) : '';
              }
          ?>
      		<table style="width:1043px;">
        			<tr>
        			    <td colspan="5" class="headall" style="font-weight:bold;">II. FAMILY BACKGROUND</td>
        			</tr>
        			<tr style="">
          				<td class="bgall" style="width:18% !important;font-size:12px;padding:5px;border-right:solid;border-bottom:none;">22. SPOUSE'S SURNAME</td>
          				<td colspan="2" style="width:42% !important;padding:5px;border-style:solid;font-size:12px;"><b><?=setValue($family->spouse_surname)?></b></td>
          				<td class="bgall" style="width:30% !important;font-size:12px;padding:5px;border-style:solid;">23. NAME of CHILDREN (Write full name and list all)</td>
          				<td class="bgall" style="width:10% !important;font-size:12px;padding:5px;text-align:center;border-style:solid;">DATE OF BIRTH (mm/dd/yyyy) </td>
        			</tr>
        	    <tr style="">
            			<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;border-top:none;border-bottom:none;text-indent:20px;">FIRST NAME</td>
            			<td style="width:28% !important;padding:5px;border-style:solid;font-size:12px;"><b><?=setValue($family->spouse_first_name)?></b></td>
            			<td class="bgall" style="font-size:12px;width:14%!important;padding:0 5px;border-style:solid;">
            				<span style="font-size:10px !important;vertical-align:top;">NAME EXTENSION(JR.,SR)</span> <b><?=setValue($family->spouse_first_name)?></b>
            			</td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"><b><?=$children[0]['name']?></b></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><b><?=child_birthdate($children[0]['date_of_birth'])?></b></td>
          		</tr>
        			<tr style="">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">MIDDLE NAME</td>
          				<td colspan="2" style="padding:5px;width:36%;border-style:solid;font-size:12px;"><b><?=setValue($family->spouse_middle_name)?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"><b><?=$children[1]['name']?></b></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><b><?=child_birthdate($children[1]['date_of_birth'])?></b></td>
              </tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;border-top:solid;text-indent:20px;">OCCUPATION</td>
          				<td colspan="2" style="padding:5px;width:36%;border-right:solid;font-size:12px;"><b><?=setValue($family->spouse_occupation)?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[2]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[2]['date_of_birth'])?></td>
              </tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;">EMPLOYER/BUSINESS NAME</td>
          				<td colspan="2" style="padding:5px;width:36%;border-right:solid;font-size:12px;"><b><?=setValue($family->employer_business_name)?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[3]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[3]['date_of_birth'])?></td>
              </tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">BUSINESS ADDRESS</td>
          				<td colspan="2" style="padding:5px;border-right:solid;font-size:12px;"><b><?=setValue($family->business_address)?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[4]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[4]['date_of_birth'])?></td>
              </tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">TELEPHONE NO.</td>
          				<td colspan="2" style="padding:5px;border-right:solid;font-size:12px;"><b><?=setValue($family->telephone_no)?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[5]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[5]['date_of_birth'])?></td>
              </tr>

        			<tr style="">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;">24. FATHER'S SURNAME</td>
          				<td colspan="2" style="padding:5px;border-style:solid;font-size:12px;"><b><?=setValue($family->father_surname)?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[6]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><b><?=child_birthdate($children[6]['date_of_birth'])?></b></td>
              </tr>
        			<tr style="">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">FIRST NAME</td>
          				<td style="padding:5px;border-style:solid;font-size:12px;"><b><?=$family->father_first_name?></b></td>

            			<td class="bgall" style="font-size:12px;width:14%!important;padding:0 5px;border-style:solid;">
            				<span style="font-size:10px !important;vertical-align:top;">NAME EXTENSION(JR.,SR)</span> <b><?=setValue($family->father_name_extension)?></b>
            			</td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[7]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[7]['date_of_birth'])?></td>
              </tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">MIDDLE NAME</td>
          				<td colspan="2" style="padding:5px;border-right:solid;font-size:12px;"><b><?=$family->father_middle_name?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[8]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[8]['date_of_birth'])?></td>
              </tr>

        			<tr style="">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;">25. MOTHER'S MAIDEN NAME</td>
          				<td colspan="2" style="padding:5px;border-style:solid;font-size:12px;"></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[9]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[9]['date_of_birth'])?></td>
              </tr>
        			<tr style="">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">SURNAME</td>
          				<td colspan="2" style="padding:5px;border-style:solid;font-size:12px;"><b><?=$family->mother_surname?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[10]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[10]['date_of_birth'])?></td>
              </tr>
        			<tr style="">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">FIRST NAME</td>
          				<td colspan="2" style="padding:5px;border-style:solid;font-size:12px;"><b><?=$family->mother_first_name?></b></td>
                  <td style="font-size:12px;padding:5px;border-style:solid;"> <?=$children[11]['name']?></td>
                  <td style="font-size:12px;padding:5px;text-align:center;border-style:solid;"><?=child_birthdate($children[11]['date_of_birth'])?></td>
              </tr>
        			<tr style="border-bottom:solid;">
          				<td class="bgall" style="font-size:12px;padding:5px;border-right:solid;text-indent:20px;">MIDDLE NAME</td>
          				<td colspan="2" style="padding:5px;border-right:solid;font-size:12px;"><b><?=$family->mother_middle_name?></b></td>
          				<td class="bgall" colspan="2" style="font-size:12px;color:red !important;padding:5px;font-style:italic;text-align:center;">(Continue on separate sheet if necessary)</td>
        			</tr>
      		</table>
      		<!--end family bg-->
          <?php
              function educ_background($val='') {
                return (!empty($val) && $val != '') ? strtoupper($val) : 'N/A';
              }
          ?>
          <table>
              <thead>
            			<tr class="headall" style="border-top: none;border-right: none"> <th colspan="8" class=""> &nbsp;III. EDUCATIONAL BACKGROUND </th> </tr>
                  <tr style="background-color:#eaeaea;">
              				<th class="bgall" style="font-size:12px;padding:5px;width:18%;font-weight: normal">26. </th>
              				<th class="bgall" rowspan="2" style="border-left:solid;border-right:solid;font-size:12px;padding:5px;text-align:center;width:24% !important;font-weight: normal">NAME OF SCHOOL <br/>(Write in full)</th>
              				<th class="bgall" rowspan="2" style="font-size:12px;padding:5px;border-right:solid;text-align:center;width:21% !important;font-weight: normal">BASIC EDUCATION/DEGREE/COURSE <br/>(Write in full)</th>
              				<th class="bgall" style="font-size:12px;padding:5px;text-align:center;border-bottom:solid;border-right:solid;width:15% !important;font-weight: normal" colspan="2">PERIOD OF ATTENDANCE</th>
              				<th class="bgall" rowspan="2" style="font-size:12px;padding:5px;border-right:solid;text-align:center;width:10% !important;font-weight: normal">HIGHEST LEVEL/<br/>UNITS EARNED<br/>(if not graduated)</th>
              				<th class="bgall" rowspan="2" style="font-size:12px;padding:5px;border-right:solid;text-align:center;font-weight: normal">YEAR GRADUATED</th>
              				<th class="bgall" rowspan="2" style="font-size:11px;padding:1px;text-align:center;font-weight: normal">SCHOLARSHIP/<br />ACADEMIC HONORS RECEIVED</th>
            			</tr>
            			<tr style="background-color:#eaeaea;">
              				<th class="bgall" style="text-align:center;font-size:12px;padding:5px;width:120px;font-weight: normal">LEVEL</th>
              				<th class="bgall" style="font-size:12px;border-right:solid;text-align:center;font-weight: normal">From</th>
              				<th class="bgall" style="font-size:12px;border-right:solid;text-align:center;font-weight: normal">To</th>
            			</tr>
              </thead>

        			<!--ele-->
      				<tr style="font-size: 12px">
          				<td class="bgall" style="padding:10px;border-top:solid;border-right:solid;background-color:#eaeaea;">ELEMENTARY</td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['name_of_school'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['basic_education_degree_course'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['attendance_from'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['attendance_to'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['highest_level_unit_earned'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['year_graduated'])?></b></td>
          				<td style="text-align:center;border-top:solid;font-size:100%; padding: 0"><b><?=educ_background($elementary[0]['scholarship_honor_received'])?></b></td>
        			</tr>
        			<!--ele-->
        			<!--sec-->
      				<tr style="font-size: 12px">
          				<td class="bgall" style="padding:10px;border-top:solid;border-right:solid;background-color:#eaeaea;">SECONDARY</td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['name_of_school'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['basic_education_degree_course'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['attendance_from'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['attendance_to'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['highest_level_unit_earned'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['year_graduated'])?></b></td>
          				<td style="text-align:center;border-top:solid;font-size:100%; padding: 0"><b><?=educ_background($secondary[0]['scholarship_honor_received'])?></b></td>
        			</tr>
        			<!--sec-->
        			<!--voc-->
      				<tr style="font-size: 12px">
          				<td class="bgall" style="padding:10px;border-top:solid;border-right:solid;background-color:#eaeaea;">VOCATIONAL / TRADE COURSE</td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['name_of_school'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['basic_education_degree_course'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['attendance_from'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['attendance_to'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['highest_level_unit_earned'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['year_graduated'])?></b></td>
          				<td style="text-align:center;border-top:solid;font-size:100%; padding: 0"><b><?=educ_background($vocational[0]['scholarship_honor_received'])?></b></td>
        			</tr>
        			<!--voc-->
        			<!--col-->
      				<tr style="font-size: 12px">
          				<td class="bgall" style="padding:10px;border-top:solid;border-right:solid;background-color:#eaeaea;">COLLEGE</td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['name_of_school'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['basic_education_degree_course'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['attendance_from'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['attendance_to'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['highest_level_unit_earned'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['year_graduated'])?></b></td>
          				<td style="text-align:center;border-top:solid;font-size:100%; padding: 0"><b><?=educ_background($college[0]['scholarship_honor_received'])?></b></td>
        			</tr>
        			<!--col-->
        			<!--gra-->
      				<tr style="font-size: 12px">
          				<td class="bgall" style="padding:10px;border-top:solid;border-right:solid;background-color:#eaeaea;">GRADUATE STUDIES</td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['name_of_school'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['basic_education_degree_course'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['attendance_from'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['attendance_to'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['highest_level_unit_earned'])?></b></td>
          				<td style="text-align:center;border-top:solid;border-right:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['year_graduated'])?></b></td>
          				<td style="text-align:center;border-top:solid;font-size:100%; padding: 0"><b><?=educ_background($graduate_studies[0]['scholarship_honor_received'])?></b></td>
        			</tr>
        			<!--gra-->
        			<tr style="background-color:#eaeaea;">
          				<td class="bgall" id="separate" colspan="8" style="text-align:center;border-top:solid;color:red;border-color:black;font-size:12px;font-style:italic;padding:1px">(Continue on separate sheet if necessary)</td>
        			</tr>
        			<tr style="border-top:solid;">
          				<td style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;padding:3px">SIGNATURE</td>
          				<td colspan="4" style="border-right:solid;font-weight: bold;font-style:italic;text-align:center;padding:3px"></td>
          				<td style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;padding:3px">DATE</td>
          				<td colspan="2" style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;padding:3px"><?=date("F j Y")?></td>
        			</tr>
        			<tr>
        				<td class="bgall" colspan="8" style="text-align:center;border-top:solid;border-color:black;font-size:12px;text-align:right;font-style:italic;padding:2px 5px">
        				CS FORM 212 (Revised 2017)Page 1 of 4</td>
        			</tr>
      		</table>
      	</div>
        <!--start page 2-->
        <div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">
      		<table>
              <thead>
      						<tr> <th colspan="12" class="headall" style="border-top:none;border-right:none;"> &nbsp;IV. CIVIL SERVICE ELIGIBILITY </th> </tr>
              </thead>
      				<tr style="background-color:#eaeaea;">
      						<td rowspan="2" class="bgall" style="font-size:12px;padding:5px;text-align:center;border-style:solid;border-right:solid;border-left:none;width:400px;">
      							27. CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE <br/>
      							BARANGAY ELIGIBILITY/DRIVER'S LICENSE
      						</td>
      						<td rowspan="2" class="bgall" style="width:10% !important;font-size:12px;text-align:center;padding:5px;border-right:solid;">RATING <br/><small>(If Applicable)</small></td>
      						<td rowspan="2" class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;width:100px;">DATE OF EXAMINATION/ CONFERMENT</td>
      						<td rowspan="2" class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;width:300px;">PLACE OF EXAMINATION / CONFERMENT</td>
      						<td colspan="2" class="bgall" style="font-size:12px;text-align:center;padding:5px;">LICENSE(if applicable)</td>
      				</tr>
      				<tr style="background-color:#eaeaea;">
      						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-top:solid;width:100px;">NUMBER</td>
      						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-left:solid;border-top:solid;">Date of Validity</td>
      				</tr>
              <?php
                  for($i = 0; $i < 7; $i++) {
                      if(!empty($eligibility[$i])) {
                        echo '<tr style="font-size:12px; ">
                      						<td style="text-align:left;border-right:solid;border-top:solid;font-size:100%;padding: 5px"><center>'.$eligibility[$i]['eligibility_description'].'</center></td>
                      						<td style="text-align:center;border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$eligibility[$i]['rating'].'</td>
                      						<td style="text-align:center;border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$eligibility[$i]['date_of_examination'].'</td>
                      						<td style="text-align:left;border-right:solid;border-top:solid;font-size:100%;padding: 5px"><center>'.$eligibility[$i]['place_of_examination'].'</center></td>
                      						<td style="text-align:center;border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$eligibility[$i]['license_no'].'</td>
                      						<td style="text-align:center;border-top:solid;font-size:100%;padding: 5px">'.date('m/d/Y', strtotime($eligibility[$i]['date_of_validity'])).'</td>
                      				</tr>';
                      }
                      else if($i == 0 && empty($eligibility)) {
                          echo '<tr>
                        						<td style="font-size:12px;text-align:left;padding:10px;border-right:solid;border-top:solid;"><center>N/A</center></td>
                        						<td style="font-size:12px;text-align:center;padding:10px;border-right:solid;border-top:solid;">N/A</td>
                        						<td style="font-size:12px;text-align:center;padding:10px;border-right:solid;border-top:solid;">N/A</td>
                        						<td style="font-size:12px;text-align:left;padding:10px;border-right:solid;border-top:solid;"><center>N/A</center></td>
                        						<td style="font-size:12px;text-align:center;padding:10px;border-right:solid;border-top:solid;">N/A</td>
                        						<td style="font-size:12px;text-align:center;padding:10px;border-top:solid;">N/A</td>
                        				</tr>';
                      }
                      else {
                        echo '<tr style="">
                      						<td style="padding: 14px ;font-size:12px;text-align:left;padding:14px;border-right:solid;border-top:solid;"><center></center></td>
                      						<td style="font-size:12px;text-align:center;padding:14px;border-right:solid;border-top:solid;"></td>
                      						<td style="font-size:12px;text-align:center;padding:14px;border-right:solid;border-top:solid;"></td>
                      						<td style="font-size:12px;text-align:left;padding:14px;border-right:solid;border-top:solid;"><center></center></td>
                      						<td style="font-size:12px;text-align:center;padding:14px;border-right:solid;border-top:solid;"></td>
                      						<td style="font-size:12px;text-align:center;padding:14px;border-top:solid;"></td>
                      				</tr>';
                      }
                  }
              ?>
      				<tr class="" style="background-color:#eaeaea;border-bottom:solid;border-top:solid;">
                  <td colspan="6" class="bgall" style="font-size:12px;font-style:italic;text-align:center;color:red;padding:5px;border-color:black;">(Continue on separate sheet if necessary)</td>
      				</tr>
          </table>
      		<table>
              <thead>
                  <tr>
                      <th colspan="12" class="headall" style="border-top:none;border-right:none;">
                          &nbsp;V. WORK EXPERIENCE <br/>
                          <span style="font-weight:normal;font-size:12px;">
                            (Include private employment.  Start from your current work) Description of duties should be indicated in the attached Work Experience sheet.
                          </span>
                      </th>
                  </tr>
              </thead>
      				<tr>
      		        <td colspan="2" class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;background-color:#eaeaea;">
                    28. INCLUSIVE DATES <br/>(mm/dd/yyyy)
      			      </td>
          				<td rowspan="2" style="font-size:12px;text-align:center;padding:5px;width:220px;border-right:solid;background-color:#eaeaea;">
          					POSITION TITLE <br/>(Write in full/Do not abbreviate)
          				</td>
        					<td rowspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;background-color:#eaeaea;">
          					DEPARTMENT/AGENCY/OFFICE/COMPANY<br/>(Write in full/Do not abbreviate)
          				</td>
        					<td rowspan="2" style="font-size:12px;text-align:center;width:80px;padding:5px;border-right:solid;background-color:#eaeaea;">
          					MONTHLY SALARY
          				</td>
          				<td rowspan="2" style="font-size:9px;text-align:center;width:80px;padding:5px;border-right:solid;background-color:#eaeaea;">
          					SALARY/JOB PAY GRADE(If Applicable)& STEP(Format"00-0")/INCREMENT
          				</td>
        					<td rowspan="2" style="font-size:12px;text-align:center;width:80px;padding:5px;border-right:solid;background-color:#eaeaea;">
          					STATUS OF APPOINTMENT
          				</td>
        					<td rowspan="2" style="font-size:12px;text-align:center;width:80px;;padding:5px;border-right:solid;background-color:#eaeaea;">
          					GOV'T SERVICE (Y/N)
          				</td>
              </tr>
        			<tr>
        					<td class="bgall" style="font-size:12px;text-align:center;padding:5px;width:80px;border-top:solid;border-right:solid;background-color:#eaeaea;"> From </td>
          				<td class="bgall" style="font-size:12px;text-align:center;width:80px;padding:5px;border-top:solid;border-right:solid;background-color:#eaeaea;"> To </td>
        			</tr>
      				<?php
                  for($i = 0; $i < 27; $i++) {
                      if(!empty($work_experience[$i])) {
                        echo '<tr style="font-size:12px;text-align:center">
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['inclusive_dates_from'].'<font color="white">1</font></td>
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['inclusive_dates_to'].'</td>
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['position_title'].'</td>
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['company'].'</td>
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['monthly_salary'].'</td>
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['salary_grade_and_step'].'</td>
                        					<td style="border-right:solid;border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['status_of_appointment'].'</td>
                        					<td style="border-top:solid;font-size:100%;padding: 0">'.$work_experience[$i]['is_government'].'</td>
                      				</tr>';
                      }
                      else if(count($work_experience) == 1 && empty($work_experience[0])) {
                        echo '<tr>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-right:solid;border-top:solid;">N/A</td>
                        					<td style="font-size:12px;text-align:center;padding:11px;border-top:solid;">N/A</td>
                      				</tr>';
                      }
                      else {
                        echo '<tr>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-right:solid;border-top:solid;"></td>
                        					<td style="font-size:12px;text-align:center;padding:15px;border-top:solid;"></td>
                      				</tr>';
                      }
                  }
              ?>
        			<tr>
      				    <td colspan="8" class="bgall" style="font-size:12px;text-align:center;font-style:italic;color:red;padding:5px;border-right:solid;border-top:solid;border-color:black;background-color:#eaeaea;">
                      (Continue on separate sheet if necessary)
                  </td>
        			</tr>
        			<tr style="border-top:solid;">
          				<td colspan="2" style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;">SIGNATURE</td>
          				<td colspan="2" style="border-right:solid;font-weight: bold;font-style:italic;text-align:center;"></td>
          				<td colspan="2" style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;">DATE</td>
          				<td colspan="2" style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;"><?=date("F j Y")?></td>
        			</tr>
        			<tr>
          				<td class="bgall" colspan="8" style="text-align:center;border-top:solid;border-right:solid;border-color:black;font-size:12px;text-align:right;font-style:italic;">
          			      CS FORM 212 (Revised 2017)Page 2 of 4
                  </td>
        			</tr>
      		</table>
        </div>
      <!--end page 2-->

        <!--start page 3-->
        <div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">
      			<table>
      				<thead>
                  <tr>
        							<th colspan="6" class="headall" style="border-top:none;border-right:none;">
        								&nbsp;VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S
        							</th>
                  </tr>
      				</thead>
      				<tr >
      						<td class="bgall" rowspan="2" style="font-size:12px;text-align:center;padding:5px;">29. </td>
      						<td class="bgall" rowspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;">NAME &amp; ADDRESS OF ORGANIZATION<br/>(Write in full)</td>
      						<td class="bgall" colspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;">INCLUSIVE DATES<br/>(mm/dd/yyyy)</td>
      						<td class="bgall" rowspan="2"style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:100px;">NUMBER OF HOURS</td>
      						<td class="bgall" rowspan="2" style="font-size:12px;text-align:center;padding:5px;border-top:solid;">POSITION / NATURE OF WORK</td>
      				</tr>
      				<tr >
      						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:100px;">From</td>
      						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:100px;">To</td>
      				</tr>
      				<?php
                for($i = 0; $i < 7; $i++) {
                    if(!empty($voluntary_work[$i])) {
                        echo '<tr style="font-size:12px;text-align:center">
                      						<td  colspan="2" style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$voluntary_work[$i]['name_address_of_organization'].'</td>
                      						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$voluntary_work[$i]['inclusive_dates_from'].'</td>
                      						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$voluntary_work[$i]['inclusive_dates_to'].'</td>
                      						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$voluntary_work[$i]['no_of_hours'].'</td>
                      						<td  style="border-top:solid;font-size:100%;padding: 5px">'.$voluntary_work[$i]['position_nature_of_work'].'</td>
                    					</tr>';
                    }
                    else if($i == 0 && empty($voluntary_work)) {
                        echo '<tr style="font-size:12px;text-align:center">
                                  <td  colspan="2" style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                                  <td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                                  <td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                                  <td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                                  <td  style="border-top:solid;font-size:100%;padding: 5px">N/A</td>
                              </tr>';
                    }
                    else {
                        echo '<tr>
                                  <td  colspan="2" style="padding:13px;border-right:solid;border-top:solid;font-size:100%"></td>
                                  <td  style="padding:13px;border-right:solid;border-top:solid;font-size:100%"></td>
                                  <td  style="padding:13px;border-right:solid;border-top:solid;font-size:100%"></td>
                                  <td  style="padding:13px;border-right:solid;border-top:solid;font-size:100%"></td>
                                  <td  style="padding:13px;border-top:solid;font-size:100%"></td>
                              </tr>';
                    }
                }
              ?>
      				<tr>
      			      <td class="bgall" colspan="6" style="font-size:12px;font-style:italic;text-align:center;color:red;padding:5px;border-right:solid;border-top:solid;border-color:black;">(Continue on separate sheet if necessary)</td>
      				</tr>
      			</table>		<!--start trainings-->
      			<table>
                <thead>
      				     <tr>
        							<th colspan="12" class="headall" style="border-right:none;">
        								&nbsp;VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED<br/>
        								<small style="font-weight:normal;font-size:12px;">
        									(Start from the most recent L&D training program and include only the relevant L&D training taken for the last five(5) years for the Division Chief/Executive/Managerial positions)
        								</small>
        							</th>
      	           </tr>
                </thead>
      					<tr >
        						<td class="bgall" rowspan="2" style="font-size:12px;padding:14px 0px 0px 5px;border-top:solid;vertical-align:top;">30. </td>
        						<td class="bgall" rowspan="2" style="font-size:11px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:405px;">
        							TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS <br>
        							(Write in full)
        						</td>
        						<td class="bgall" colspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;">INCLUSIVE DATES<br/>(mm/dd/yyyy)</td>
        						<td class="bgall" rowspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:100px;">NUMBER OF HOURS</td>
        						<td class="bgall" rowspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;">TYPE OF LD (Managerial/<br/>Supervisory/<br/>Technical/etc.)</td>
        						<td class="bgall" rowspan="2" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:210px;">CONDUCTED/SPONSORED BY <br/> (Write in full)</td>
      					</tr>
      					<tr >
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:100px;">From</td>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:100px;">To</td>
      					</tr>
        				<?php
                  for($i = 0; $i < 20; $i++) {
                      if(!empty($learning_development[$i])) {
                          echo '<tr style="font-size:12px;text-align:center">
                        						<td  colspan="2" style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$learning_development[$i]['title'].'</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$learning_development[$i]['inclusive_dates_from'].'</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$learning_development[$i]['inclusive_dates_to'].'</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$learning_development[$i]['no_of_hours'].'</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$learning_development[$i]['type_of_ld'].'</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$learning_development[$i]['conducted_by'].'</td>
                      					</tr>';
                      }
                      else if(count($learning_development) == 1 && empty($learning_development[0])) {
                          echo '<tr style="font-size:12px;text-align:center">
                        						<td  colspan="2" style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                        						<td  style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">N/A</td>
                      					</tr>';
                      }
                      else {
                          echo '<tr>
                        						<td  colspan="2" style="font-size:12px;padding:14px;border-right:solid;border-top:solid;"></td>
                        						<td  style="font-size:12px;padding:14px;border-right:solid;border-top:solid;"></td>
                        						<td  style="font-size:12px;padding:14px;border-right:solid;border-top:solid;"></td>
                        						<td  style="font-size:12px;padding:14px;border-right:solid;border-top:solid;"></td>
                        						<td  style="font-size:12px;padding:14px;border-right:solid;border-top:solid;"></td>
                        						<td  style="font-size:12px;padding:14px;border-right:solid;border-top:solid;"></td>
                      					</tr>';
                      }
                  }
                ?>
      					<tr>
        						<td class="bgall" colspan="7" style="font-size:12px;font-style:italic;text-align:center;color:red;padding:5px;border-right:solid;border-top:solid;border-color:black;">
                      (Continue on separate sheet if necessary)
                    </td>
      					</tr>
      			</table>		<!--start other info-->
      			<table style="width:1045px;">
          			<tr>
            				<thead>
              					<th colspan="12" class="headall" style="">
              						&nbsp;VIII.  OTHER INFORMATION
              					</th>
            				</thead>
          			</tr>
      					<tr>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-top:solid;width:20px;">31.</td>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:">SPECIAL SKILLS and HOBBIES</td>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-top:solid;width:20px;vertical-align: top;">32.</td>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:350px;">NON-ACADEMIC DISTINCTIONS / RECOGNITION<br/>(Write in full)</td>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-top:solid;width:20px;vertical-align: top;">33.</td>
        						<td class="bgall" style="font-size:12px;text-align:center;padding:5px;border-right:solid;border-top:solid;width:380px;">MEMBERSHIP IN ASSOCIATION/ORGANIZATION<br/>(Write in full)</td>
      		      </tr>
                <?php
                  for($i = 0; $i < 7; $i++) {
                      if(!empty($other_info[$i])) {
                        echo '<tr style="font-size:12px">
                                <td colspan="2" style=";border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$other_info[$i]['skills_and_hobbies'].'</td>
                                <td colspan="2" style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$other_info[$i]['non_academic_distinctions'].'</td>
                                <td colspan="2" style="border-right:solid;border-top:solid;font-size:100%;padding: 5px">'.$other_info[$i]['membership'].'</td>
                            </tr>';
                      }
                      else if($i == 0 && empty($other_info)) {
                        echo '<tr style="font-size:12px;text-align:center">
                                <td colspan="2" style="padding:5px;border-right:solid;border-top:solid;">N/A</td>
                                <td colspan="2" style="padding:5px;border-right:solid;border-top:solid;">N/A</td>
                                <td colspan="2" style="padding:5px;border-right:solid;border-top:solid;">N/A</td>
                            </tr>';
                      }
                      else {
                          echo '<tr style="font-size:12px;">
                                  <td colspan="2" style="padding:13px;border-right:solid;border-top:solid;"></td>
                                  <td colspan="2" style="padding:13px;border-right:solid;border-top:solid;"></td>
                                  <td colspan="2" style="padding:13px;border-right:solid;border-top:solid;"></td>
                              </tr>';
                      }
                  }
                ?>
      					<tr>
        						<td class="bgall" colspan="6" style="font-size:12px;font-style:italic;text-align:center;color:red;padding:5px;border-right:solid;border-top:solid;border-color:black;">
                      (Continue on separate sheet if necessary)
                    </td>
      					</tr>
      			</table>
      			<table style="width:1045px;">
        				<tr style="border-top:solid;">
        					<td style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;width:255px;">SIGNATURE</td>
        					<td style="border-right:solid;text-align:center;width:380px;"></td>
        					<td style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;width:200px;">DATE</td>
        					<td colspan="2" style="background-color:#eaeaea;border-right:solid;font-weight: bold;font-style:italic;text-align:center;"><?=date("F j Y")?></td>
        				</tr>
      			</table>
      			<table style="width:1045px;">
        				<tr>
          					<td class="bgall" style="text-align:center;border-top:solid;border-color:black;border-right:solid;font-size:12px;text-align:right;font-style:italic;">
            					CS FORM 212 (Revised 2017)Page 3 of 4
                    </td>
        				</tr>
      			</table>
        </div>
      	<!--end page 3-->
      <!--start page 4-->
        <div class="page-break" style="border-style:solid;width:1047px;background-color:#fff;">
        		<!--questa-->
            <?php
              function isYes($val) {
                return $val == 'Y' ? '<i class="far fa-check-square"></i>' : '<i class="far fa-square"></i>';
              }
              function isNo($val) {
                return $val == 'N' ? '<i class="far fa-check-square"></i>' : '<i class="far fa-square"></i>';
              }
            ?>
            <style>
                table.p3 td {
                  padding: 3px;
                }
            </style>
            <table class="p3" style="font-size: 12px; padding:2px !important">
                <colgroup>
                  <col class="bgall" style="width:3%;padding:5px;vertical-align:top;" />
                  <col class="bgall" style="width:62%;padding:2px;border-right:solid;" />
                  <col style="width:35%;padding:2px" />
                </colgroup>
                <tr>
                    <td>34.</td>
                    <td> Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed, </td>
                    <td></td>
                </tr>
                <tr>
            				<td></td>
            				<td>a. within the third degree?</td>
            				<td>
                      <span style="margin-left:30px"><?=isYes($affinities['with_third_degree_affinity'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['with_third_degree_affinity'])?>  NO</span>
                    </td>
                </tr>
            		<tr>
            				<td></td>
            				<td> b. within the fourth degree (for Local Government Unit-Career Employees)? </td>
            				<td>
                      <span style="margin-left:30px"><?=isYes($affinities['with_fourth_degree_affinity'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['with_fourth_degree_affinity'])?>  NO</span>
                    </td>
            		</tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details:</td>
                </tr>
                <tr style="border-bottom:solid">
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px;">
                    <?=!empty($affinities['affinities'])?$affinities['affinities']:'__________________________________________________'?>
                  </td>
                </tr>

            		<tr>
            			<td>35</td>
            			<td>a. Have you ever been found guilty of any administrative offense?</td>
                  <td>
                    <span style="margin-left:30px"><?=isYes($affinities['with_administrative_offense'])?>  YES</span>
                    <span style="margin-left:80px"><?=isNo($affinities['with_administrative_offense'])?>  NO</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details:</td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px;border-bottom:solid">
                    <?=!empty($affinities['administrative_offense'])?$affinities['administrative_offense']:'__________________________________________________'?>
                  </td>
                </tr>
            		<tr>
            			<td></td>
            			<td>b. Have you been criminally charged before any court?</td>
                  <td>
                    <span style="margin-left:30px"><?=isYes($affinities['is_criminally_charged'])?>  YES</span>
                    <span style="margin-left:80px"><?=isNo($affinities['is_criminally_charged'])?>  NO</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details:</td>
                </tr>
                <tr >
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 20px">Date Filed: <?=!empty($affinities['date_filed'])?$affinities['date_filed'] :'______________________________________'?></td>
                </tr>
                <tr style="border-bottom:solid">
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 20px">Status of Case/s: <?=!empty($affinities['status_of_case'])?$affinities['status_of_case'] :'______________________________________'?></td>
                </tr>

                <tr>
                    <td>36.</td>
                    <td> Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal? </td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['is_convicted'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['is_convicted'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details:</td>
                </tr>
                <tr style="border-bottom:solid">
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px;border-bottom:solid">
                    <?=!empty($affinities['conviction_details'])?$affinities['conviction_details']:'__________________________________________________'?>
                  </td>
                </tr>

                <tr>
                    <td>37.</td>
                    <td>Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['was_separated_from_service'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['was_separated_from_service'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details:</td>
                </tr>
                <tr style="border-bottom:solid">
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px;border-bottom:solid">
                    <?=!empty($affinities['separated_from_service'])?$affinities['separated_from_service']:'__________________________________________________'?>
                  </td>
                </tr>

                <tr>
                    <td>38.</td>
                    <td>a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['is_candidate'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['is_candidate'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details: <?=!empty($affinities['candidate_details'])?$affinities['candidate_details']:'___________________________________'?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['has_resigned_from_government'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['has_resigned_from_government'])?>  NO</span>
                    </td>
                </tr>
                <tr style="border-bottom:solid">
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details: <?=!empty($affinities['resigned_government'])?$affinities['resigned_government']:'___________________________________'?></td>
                </tr>

                <tr>
                    <td>39.</td>
                    <td>Have you acquired the status of an immigrant or permanent resident of another country?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['is_immigrant'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['is_immigrant'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, give details(country):</td>
                </tr>
                <tr style="border-bottom:solid">
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px;"><?=!empty($affinities['immigrant_country'])?$affinities['immigrant_country']:'__________________________________________________'?></td>
                </tr>

                <tr>
                    <td>40.</td>
                    <td>Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>a. Are you a member of any indigenous group?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['is_indigenous'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['is_indigenous'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, please specify: <?=!empty($affinities['indigenous_details'])?$affinities['indigenous_details']:'___________________________________'?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Are you differently abled?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['is_disabled'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['is_disabled'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, please specify ID No: <?=!empty($affinities['disability_id'])?$affinities['disability_id']:'___________________________________'?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>c. Are you a solo parent?</td>
                    <td>
                      <span style="margin-left:30px"><?=isYes($affinities['is_solo_parent'])?>  YES</span>
                      <span style="margin-left:80px"><?=isNo($affinities['is_solo_parent'])?>  NO</span>
                    </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2" style="padding-left: 10px">If YES, please specify ID No: <?=!empty($affinities['solo_parent_id'])?$affinities['solo_parent_id']:'___________________________________'?></td>
                </tr>
            </table>

      			<table id="ref">
      				<tr style="border-top:solid;">
      					<td colspan="6" class="bgall" style="border-right:solid; font-size:12px;padding:5px;"> 41. REFERENCES
                  <font style="color:red;" class="fontred">(Person not related by consanguinity or affinity to applicant / appointee)</font>
                </td>
      				</tr>
      				<tr style="border-top:solid;width:1043px;">
      					<td class="bgall" id="name" style="font-size:12px;text-align:center;padding:5px;border-right:solid;width:30% !important;">NAME</td>
      					<td class="bgall" id="add" style="font-size:12px;text-align:center;padding:5px;border-right:solid;">ADDRESS</td>
      					<td class="bgall" id="tel" style="font-size:12px;text-align:center;padding:5px;border-right:solid;width:12.2% !important;">TEL. NO.</td>
      					<td rowspan="6" colspan="5" style="font-size:10px;padding:5px; width:500px !important;">
      						<div id="pic" style="padding:10px 0;width:132.2px;height:170px;text-align:center;margin:auto;border:1px solid #000;">
                      ID picture taken within <br> the last  6 months <br> 3.5 cm. X 4.5 cm <br> (passport size)
      								<br/>
      								With full and handwritten <br> name tag and signature over <br> printed name
      								<br/>
      								Computer generated <br> or photocopied picture <br> is not acceptable
      								<!-- <img class="" src="attach/127amPARPAN/PARPAN, A.jpg" width="132.2" height="145" style="border:1px solid black;margin-top:-163px;" alt="My Photo" /> -->
      						</div>
      						<p align="center" style="padding-top:10px;"> PHOTO </p>
      					</td>
      				</tr>
              <?php
                for($i = 0; $i < 3; $i++) {
                    if(!empty($references[$i])) {
                      echo '<tr style="border-top:solid;">
                      					<td style="font-size:12px;padding:5px !important;border-right:solid;width:350px;text-align:center;"><b>'.$references[$i]['name'].'</b></td>
                      					<td style="font-size:12px;padding:5px;border-right:solid;width:380px;text-align:center;"><b>'.$references[$i]['address'].'</b></td>
                      					<td style="font-size:12px;padding:5px;border-right:solid;width:140px;text-align:center;"><b>'.$references[$i]['tel_no'].'</b></td>
                    				</tr>';
                    }
                    else if($i == 0 && empty($references)) {
                      echo ' <tr style="border-top:solid;">
                      					<td style="font-size:12px;padding:5px;border-right:solid;width:350px;"><font color="white">N/A</font></td>
                      					<td style="font-size:12px;padding:5px;border-right:solid;width:380px;">N/A</td>
                      					<td style="font-size:12px;padding:5px;border-right:solid;width:140px;">N/A</td>
                    				</tr>';
                    }
                    else {
                      echo ' <tr style="border-top:solid;">
                      					<td style="font-size:12px;padding:14px;border-right:solid;width:350px;"><font color="white"></font></td>
                      					<td style="font-size:12px;padding:14px;border-right:solid;width:380px;"></td>
                      					<td style="font-size:12px;padding:14px;border-right:solid;width:140px;"></td>
                    				</tr>';
                    }
                }
              ?>
      				<tr style="border-top:solid;border-bottom:solid;">
      					<td colspan="3" class="bgall" style="font-size:14px;padding:5px 5px 25px 5px;border-bottom:none;">
                  42. I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein. <br/>
                  I agree that any misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal case/s against me. <br/>
      					</td>
      				</tr>
      			</table>

      		  <table style="width:1045px;">
      				<tr>
      					<td colspan="7"></td>
      				</tr>
      				<tr style="border-top:solid;border-style:none;">
      					<td style="border-top:none;border-bottom:none;border-left:none;border-right:solid;width:10px !important;"></td>
      					<td rowspan="2" class="bgall"  style="border-top:solid;text-align:center;border-right:solid;width:250px;font-size:12px;">
      						Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)
      						PLEASE INDICATE ID Number and Date of Issuance
      					</td>
      					<td style="border-top:none;border-right:solid;width:10px;"></td>
      					<td style="border-top:solid;border-right:solid;width:350px;"></td>
      					<td style="border-top:none;border-right:solid;width:7px;"></td>
      					<td style="border-top:solid;border-right:solid;width:150px;"></td>
      					<td style="border-top:none;width:10px;"></td>
      				</tr>
      				<tr style="border-top:solid;border-style:none;">
      					<td style="border-top:solid;border-style:none;border-right:solid;width:10px !important;"></td>
      					<!-- <td style="border-style:solid;width:250px;font-size:12px;"></td> -->
      					<td style="border-right:solid;width:10px;"></td>
      					<td style="border-right:solid;width:350px;"></td>
      					<td style="border-right:solid;width:7px;"></td>
      					<td style="border-right:solid;width:150px;"></td>
      					<td style="width:10px;"></td>
      				</tr>
      				<tr style="border-top:solid;border-style:none;">
      					<td style="border-top:solid;border-style:none;border-right:none;width:10px !important;"></td>
      					<td style="border-style:solid;padding:10px 10px 10px 0px;width:250px;font-size:12px;">
      						Government Issued ID: <b><?=$affinities['government_id']?></b></td>
      					<td style="border-right:solid;width:10px;"></td>
      					<td class="bgall" style="width:350px;border-style: solid;text-align:center;font-size:12px;">Signature (Sign inside the box)</td>
      					<td style="border-right:solid;width:7px;"></td>
      					<td style="border-right:solid;"></td>
      					<td style="width:10px;"></td>
      				</tr>
      				<tr style="border-top:solid;border-style:none;">
      					<td style="border-top:solid;border-style:none;border-right:solid;width:10px !important;"></td>
      					<td style="border-right:solid;width:250px;font-size:12px;">
      						ID/License/Passport No.: <b><?=$affinities['secondary_id']?></b></td>
      					<td style="border-right:solid;width:10px;"></td>
      					<td style="border-right:solid;width:350px;text-align:center;"><?=date("F j Y")?></td>
      					<td style="border-right:solid;width:7px;"></td>
      					<td style="border-right:solid;width:150px;"></td>
      					<td style="width:10px;"></td>
      				</tr>
      				<tr style="border-top:solid;border-style:none;">
      					<td style="border-top:solid;border-style:none;border-right:solid;width:10px !important;"></td>
      					<td style="border-style:solid;width:250px;font-size:12px;">Date/Place of Issuance: <b><?=$affinities['date_place_of_issuance']?></b></td>
      					<td style="border-right:solid;width:10px;"></td>
      					<td class="bgall" style="border-style:solid;width:350px;text-align:center;font-size:12px;">Date Accomplished</td>
      					<td style="border-right:solid;width:7px;"></td>
      					<td class="bgall" style="border-style:solid;width:150px;font-size:12px;text-align:center;">Right Thumbmark</td>
      					<td style="width:10px;"></td>
      				</tr>
      				<tr style="border-top:solid;border-style:none;">
      					<td style="border-top:solid;border-style:none;border-right:none;width:10px !important;"></td>
      					<td style="border-right:none;border-left:none;width:250px;padding:1px;"></td>
      					<td style="border-right:none;width:10px;"></td>
      					<td style="border-right:none;border-left:none;width:350px;"></td>
      					<td style="border-right:none;border-left:none;width:7px;"></td>
      					<td style="border-right:none;width:150px;"></td>
      					<td style="width:10px;"></td>
      				</tr>
      				<tr>
      					<td colspan="7" style="border-top:solid;font-size:12px;padding:10px;text-indent:15px;">
      						SUBSCRIBED AND SWORN to before me this __________________________, affiant exhibiting his/her validly issued government ID as indicated above.
      					</td>
      				</tr>
      			</table>

      			<table style="width:1045px;">
      				<tr>
      					<td style="width:30%;"></td>
      					<td style="width:40%;border-style:solid;text-align:center;padding:45px;"></td>
      					<td style="width:30%;"></td>
      				</tr>
      				<tr>
      					<td style="width:30%;"></td>
      					<td class="bgall" style="width:40%;border-style:solid;text-align:center;font-size:12px;padding:0px;">Person Administering Oath</td>
      					<td style="width:30%;"></td>
      				</tr>
      				<tr>
      					<td colspan="3"></td>
      				</tr>
      				<tr>
      					<td colspan="3" style="font-size:11px;text-align:right;border-top:solid;font-style:italic;padding:5px;">CS FORM 212 (Revised 2005),  Page 4 of 4</td>
      				</tr>
      			</table>

        </div>

      </div><!--end outline-->

    </center>
  </body>

</html>
