<?php
	if($fvalid_error == 1) {
		?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<span style="font-size: 14px "><b>NOTE:</b> Please Fill-in the EMPTY Field(s), Cannot Proceed.</span>
			<hr style="margin: 5px">
		  <p><?php echo validation_errors(); ?></p>

			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php
	}
?>
<style>
 button#process_transaction_button {
	 margin-right: 150px;

 }
</style>
	<div class="container-fluid">
		<div class="row">
			<!-- DATATABLES Card -->
			<div class="col-xl-12 col-lg-12">
				<div class="trans-layout card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

						<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> PROCESS TRANSACTION</h6>

					</div>
					<?php $zxc = !empty($main_multi_cntr)?$main_multi_cntr:1; echo form_open_multipart('dms/documents/process/'.$entry.'/'.$trans_no.'/'.$zxc.'/'.$multi_cntr, array('id' => 'dms_route_form')); ?>
						<!-- Card Body -->
						<div class="card-body">
							<div class="data-div table-responsive">
								<nav>
									<div class="nav nav-tabs" id="nav-tab" role="tablist">
										<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Transaction</a>
										<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
									</div>
								</nav>
									<div class="tab-content" id="nav-tabContent">
											<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab" style="min-height: 650px">
												<div class="row">
													<input type="hidden" name="enc_key" value="<?=$enc_key?>" />
													<div id="transaction-details-group" class="col-md-4"><br />
														<div class="form-group">
															<label>Transaction No.:</label>
															<input class="form-control form-control-sm" value="<?php echo $trans_data[0]['token']; ?>" readonly />
														</div>
														<div class="form-group">
															<label>System:</label><?php echo form_error('system'); ?>
															<select id="sys_main" class="form-control form-control-sm" onchange="Dms.system_select(this.value);" name="system">
																<option selected="" value="">--</option>
																<?php
																	foreach ($system as $value) {
																		if($value['id']==$trans_data[0]['system'])
																		{
																			echo '<option selected value="'.$value['id'].'" '.set_select('system', $value['id'], TRUE).'>'.$value['name'].'</option>';
																		}
																		else
																		{
																			echo '<option value="'.$value['id'].'" '.set_select('system', $value['id']).'>'.$value['name'].'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<div class="form-group">
															<label>Sub-System:</label><?php echo form_error('type'); ?>
															<select class="form-control form-control-sm" id="type" name="type" onchange="Dms.additional_inputs(this.value)">
																<option selected="" value="">--</option>
																<?php
																	foreach ($trans_type as $value) {

																		if($value['header'] == 1)
										              	{
										               		echo '<optgroup label="'.$value['name'].'">';
										              	}
																		else if($value['id']==$trans_data[0]['type'])
																		{
																			echo '<option selected value="'.$value['id'].'">'.$value['name'].'</option>';
																		}
																		else
																		{
																			echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<!-- DIV FOR ADDITIONAL SELECTIONS -->
															<div id="additional_inputs">
																<?php
																	if(!empty($system_types)) {
																		echo $add_input;
																	}
																?>
															</div>
														<!-- END OF DIV FOR ADDITIONAL SELECTIONS -->
														<div class="form-group">
															<label>Subject Name:</label><?php echo form_error('subject'); ?>
															<textarea class="form-control form-control-sm" id="subject" name="subject"><?php echo trim($trans_data[0]['subject']); ?></textarea>
														</div>
														<div class="form-group">
															<label>Transaction Status:</label><?php echo form_error('status'); ?>
															<select class="form-control form-control-sm" id="trans_status" name="status" onchange="Dms.removeAsgnPrsnl(this.value,'<?php echo $this->encrypt->encode($trans_data[0]['token']); ?>');">
																<option selected value="">--</option>
																<?php
																	foreach ($status as $key => $value) {
																		if($value['id'] == 3) {
																			echo '<option value="'.$value['id'].'" selected>'.($key+1).' - '.$value['name'].'</option>';
																		}
																		else {
																			echo '<option value="'.$value['id'].'">'.($key+1).' - '.$value['name'].'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<?php
															if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['set_confidential_tag'] == 'yes' )
															{
																?>
																<div class="form-group">
																	<label title="Move your mouse over on an Option to know more details about that specific Option">Tag Document Type As: <i class="fa fa-question-circle"></i></label>
																	<select class="form-control form-control-sm" name="tag_doc_type">
																		<option selected value="" <?php echo set_select('tag_doc_type', '')?>>-none-</option>
																		<option title="Set This Transaction's Viewing Properties to 'ONLY WITHIN ROUTED PERSONNELS' and makes it Not Viewable on All Transactions " value="1" <?php echo set_select('tag_doc_type', 1)?>>  Confidential</option>
																	</select>
																</div>
																<?php
															}
														?>
														<div class="form-group">
															<div class="qr-code">
																<?php if(!empty($trans_data[0]['qr_code_token'] AND ($this->session->userdata('trans_qrcode') == 'yes' OR $this->session->userdata('superadmin_rights') == 'yes'))){
																	echo "<label>Please copy and paste QR Code into the document to be routed:</label><br>";
																	echo "<input type='hidden' class='form-control' name='qr_code' value='".$trans_data[0]['qr_code_token']."' readonly>";
																	echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fiis.emb.gov.ph/verify?token=".$trans_data[0]['qr_code_token']."%2F&choe=UTF-8' style='width:150px;'>";
																} ?>
															</div>
														</div>

													</div>

													<div id="company-selection-group" class="col-md-4"> <br>
														<div class="form-group">
															<label>Company:</label><?php echo form_error('company'); ?>
															<button id="add_company" type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#dmsAddCompanyModal">-> Click to Add/Change Company <-</button>
														</div>
														<input type="hidden" name="company" value="<?=$trans_data[0]['company_token']?>" readonly/>
														<div class="form-group">
															<label>Company EMB ID:</label>
															<input class="form-control form-control-sm" id="company_embid" value="<?php echo $trans_data[0]['emb_id']; ?>" readonly />
														</div>
														<div class="form-group">
															<label>Company Name:</label>
															<textarea class="form-control form-control-sm" id="company_name" readonly><?php echo $company_details[0]['company_name']; ?></textarea>
														</div>
														<div class="form-group">
															<label>Establishment Name:</label>
															<textarea class="form-control form-control-sm" id="establishment_name" readonly><?php echo $company_details[0]['establishment_name']; ?></textarea>
														</div>
														<div class="form-group">
															<label>Address:</label>
															<textarea class="form-control form-control-sm" id="company_address" readonly><?php echo ucwords(trim($company_details[0]['house_no'].' '.$company_details[0]['street'].' '.$company_details[0]['barangay_name'].', '.$company_details[0]['city_name'].' '.$company_details[0]['province_name'])); ?></textarea>
														</div>
														<div class="form-group">
															<label>Project Type:</label>
															<textarea class="form-control form-control-sm" id="project_type" readonly><?php echo $company_details[0]['project_name']; ?></textarea>
														</div>
													</div>

													<div id="sendinfo-attachments-group" class="col-md-4"> <br>
                            <div id="asgnprsnl_div" class="form-group">
															<div class="row">
																<div class="custom-control mr-sm-3">
																	<label>Assigned to:</label>
																	<div id="asgnto-spinner" class="spinner-border spinner-border-sm" role="status" style="display: none"> <span class="sr-only">Loading...</span> </div>
																</div>
																<div class="col-md-12 align-bottom" style="padding-bottom: 5px">
																	<?php
																		if( $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['trans_multiprc'] == 'yes')
																		{
																			?>
																			<span>
																					<input id="asgntoMultiple" type="checkbox" name="asgnto_multiple" value="multiple"/>
																					<label for="asgntoMultiple">Multiple</label>
																			</span>
																			<?php
																		}
																	?>
																	<span id="assignto-refunc-group">
																		<button id="asgn_recall" type="button" class="btn btn-sm btn-info float-right" style="margin: 0 5px" >Recall</button>
																		<button id="asgn_revert" type="button" class="btn btn-sm btn-info float-right" title="Return to Sender">Revert</button>
																	</span>
																</div>
															</div>
															<div id="assignto-multiple-group" style="display: none"> <!--asgnto_multiple_div-->
																<div class="form-group">
																	<button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" data-target=".addPersonnelsModal">MULTI-RECEIVER PROCESS</button>
																</div>
																<!-- FOR BACK-END VALIDATION USE ONLY, UP LATER -->
																<!-- <input type="text" name="asgnto_multiple_input" value="1"></input> -->
																<div class="form-group">
																	<fieldset style="border: 1px solid grey; padding: 10px; text-align: center; margin-bottom: 0px" readonly >
																		<label style="font-weight: bold">Selected Personnels:</label>
																		<hr style="margin-top: 0px">
																		<div id="slctd_prsnl_div">
																			-empty-
																		</div>
																	</fieldset>
																</div>
															</div>
															<div id="assignto-group"> <!--asgnto_slctn-->
																<select class="form-control form-control-sm" data-selected="<?=!empty(set_value('region')) ? set_value('region') : 0?>" name="region">
																	<?php
																		foreach ($region as $key => $value) {
																			if($value['rgnnum']==$user['region']) {
																				echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
																			}
																			else {
																				echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
																			}
																		}
																	?>
																</select> <br />

                                <select class="form-control form-control-sm" data-selected="<?=!empty(set_value('division')) ? set_value('division') : 0?>" name="division">
																	<option value="" selected>-select division-</option>
							                    <?php
							                      foreach ($division as $key => $value) {
							                        if($value['divno']==$user['divno']) {
							                          echo '<option selected value="'.$value['divno'].'">'.$value['divname'].'</option>';
							                        }
							                        else {
							                          echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
							                        }
							                      }
							                    ?>
                                </select> <br />

                                <select class="form-control form-control-sm" data-selected="<?=!empty(set_value('section')) ? set_value('section') : 0?>" name="section">
																	<option>-sec-</option>
                                </select> <br />

                                <select id="personnel_id" class="form-control form-control-sm" data-selected="<?=!empty(set_value('receiver')) ? set_value('receiver') : 0?>" name="receiver" >
																	<option>-unit-</option>
                                </select>
															</div>
                            </div>
														<div id="couriertype_div" class="form-group" style="display: none">
															<label>Courier Type:</label><?php echo form_error('courier_type'); ?>
															<select class="form-control form-control-sm" name="courier_type">
																<option selected value="">--</option>
																<?php
																	foreach ($courier_type as $key => $value) {
																		echo '<option value="'.$value['id'].'">'.$value['type'].'</option>';
																	}
																?>
															</select> <br />

															<label>Tracking No.:</label><?php echo form_error('tracking_no'); ?>
															<input type="text" class="form-control form-control-sm" name="tracking_no" />
														</div>
														<div class="form-group">
															<label>Action:</label><?php echo form_error('action'); ?>
															<select class="form-control form-control-sm" name="action">
																<option selected value="">--</option>
																<?php
																	foreach ($action as $value) {
																		echo '<option value="'.$value['text'].'" '.set_select('action', $value['text']).'>'.$value['code'].' - '.$value['text'].'</option>';
																	}
																?>
															</select>
														</div>
														<div class="form-group">
															<label>Remarks:</label><?php echo form_error('remarks'); ?>
															<textarea class="form-control form-control-sm" name="remarks"></textarea>
														</div>
														<?php
															if(in_array($user['secno'], array(77,166,176,195,223,231,232,235,255,279,316)) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['rec_officer'] == 'yes') // RECORDS
															{
																?>
																<div class="form-group">
																	<label>File Location:</label><?php echo form_error('records_location'); ?>
																	<input class="form-control form-control-sm" name="records_location" value="<?php echo (!empty($trans_data[0]['records_location'])) ? trim($trans_data[0]['records_location']) : set_value('records_location'); ?>" />
																</div>
																<?php
															}
														?>
														<div class="form-group erattdropzone">
															<label>Attachment:</label><span class="set_note"> (max. 20mb / file)</span><?php echo form_error('attachment'); ?><br />
															<span class="set_note">* please upload attachment(s) before saving / processing *</span>

															<div id="actions" class="row">
															    <div class="col-md-12">
																		<button type="button" class="btn btn-outline-primary btn-sm fileinput-button">
																			<i class="fas fa-plus-circle"></i>
																			<span>Add Files</span>
																		</button>
																		<button type="button" class="btn btn-outline-info btn-sm start">
																			<i class="fas fa-upload"></i>
																			<span>Upload All</span>
																		</button>
																		<button type="button" class="btn btn-outline-danger btn-sm cancel">
																			<i class="fas fa-times-circle"></i>
																			<span>Remove All</span>
																		</button>
															    </div>

															    <div class="col-lg-5">
															      <!-- The global file processing state -->
															      <span class="fileupload-process">
															        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
															          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
															        </div>
															      </span>
															    </div>
															</div>

															<div class="table table-striped dropzone_table upload_div files" id="previews">
															    <div id="att_template" class="file-row dz-image-preview row">
																			<!-- file name, and error message -->
																			<div class="col-md-5">
																				<p class="name" data-dz-name></p>
																				<strong class="error text-danger" data-dz-errormessage></strong>
																			</div>
																			<!-- file size, and progress bar -->
																			<div class="col-md-4">
																				<p class="size" data-dz-size></p>
																				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
																					<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
																				</div>
																			</div>
																			<!-- file upload, remove, and delete button -->
																			<div class="col-md-3">
																					<button type="button" class="btn btn-outline-info btn-sm start">
																						<i class="fas fa-upload"></i>
																					</button>
																					<button data-dz-remove type="button" class="btn btn-outline-warning btn-sm cancel">
																						<i class="fas fa-window-close"></i>
																					</button>
																					<button data-dz-remove type="button" class="btn btn-outline-danger btn-sm delete">
																						<i class="fas fa-trash"></i>
																					</button>
															        </div>
															    </div>
															</div>
														</div>
														<div id="prev-attachment-div" class="form-group" >
															<label>Previously Uploaded:</label><br />
															<?php if($attachments) { ?>
																<table class="table table-sm table-striped" style="vertical-align: middle;">
																	<?php
																		foreach ($attachments as $key => $value) {
																			$att_name = str_replace(' ', '_', trim($value['file_name']));
																	?>
																		<tr>
																			<td>
																				<?php
																					echo "<a title='".$att_name."' href='".base_url('uploads/dms/'.date('Y').'/'.$user_region.'/'.$value['trans_no'].'/'.$value['token'].'.'.pathinfo($att_name, PATHINFO_EXTENSION))."' target='_blank'>".$att_name."</a>";
																				?>
																			</td>
																			<td style="display: none">
																				<?php echo $value['token']; ?>
																			</td>
																			<?php if($value['route_order'] == $trans_data[0]['route_order']+1) { ?>
																				<td style="text-align: center">
																					<!-- <button type="button" class="btn btn-outline-danger btn-sm trans-delete-uploaded">
																						<i class="fas fa-trash"></i>
																					</button> -->
																				</td>
																			<?php } ?>
																		</tr>
																	<?php } ?>
																</table>
															<?php } ?>
														</div>

													</div>

												</div>
											</div> <!-- Tab- add-transaction End -->

											<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab"  style="min-height: 650px">
												<div class="row">
													<div class="col-md-12" style="text-align: center; display: inline-block">
														<br /><h3>TRANSACTION HISTORY</h4><br />
						                    <table class="table table-striped" style="zoom: 87% !important">
						                      <thead class="thead-dark">
						                        <tr>
						                          <th>Date Rcvd/Created</th>
						                          <th>Action</th>
						                          <th style="min-width: 5% !important; width: 17% !important">Remarks</th>
						                          <th>From</th>
						                          <th>Status</th>
						                          <th>Assigned</th>
						                          <th>Date Forwarded</th>
						                          <th>View Attachment</th>
						                        </tr>
						                      </thead>
						                      <tbody>
						                          <?php
						                            $trns_date = date('Y', strtotime($trans_data[0]['start_date']));
																				$attach_path = 'uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'];

																					$attached_file = '--';
																				// HISTORY
																				foreach ($history['trans_history'] as $index => $sub_value) {

																						$attached_file = '--';
																					foreach ($sub_value as $key => $value) {
																						$attached_file = '--';
																						$rcvr = (!empty(trim($value['receiver_name']))) ? $value['receiver_name'] : '--';
																						// MAGIC-MAGIC FOR ATTACHMENTS
																						$trans_no_calculated = $value['trans_no'];
																						if($value['date_in'] < '2020-02-16') {
																							$trans_no_calculated = $value['trans_no'] - 10000000;
																						}
																						// ATTACHMENTS
																						if(count($history['attachments'][$index][$key]) > 1) { // MULTIPLE
																							$attached_file = "<div class='dropdown'><button class='btn btn-info btn-sm waves-effect waves-light' type='button' data-toggle='dropdown'>View <i class='far fa-caret-square-down'></i></button> <ul class='dropdown-menu'  style='max-height: 500px; overflow: auto'>";
																							foreach ($history['attachments'][$index][$key] as $att_key => $att_value) {
																								$full_path = $attach_path.'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION);
																								$attached_file .= "<li><a title='".$att_value['file_name']."' href='".base_url($full_path)."' target='_blank'>".$att_value['token']."</a></li>";
																							}
					                                    $attached_file .= "</ul></div>";
																						}
																						else if(!empty($history['attachments'][$index][$key])) { // SINGLE
																							$full_path = $attach_path.'/'.$trans_no_calculated.'/'.$history['attachments'][$index][$key][0]['token'].'.'.pathinfo($history['attachments'][$index][$key][0]['file_name'], PATHINFO_EXTENSION);
																							$attached_file = "<a title='".$history['attachments'][$index][$key][0]['file_name']."' href='".base_url($full_path)."' target='_blank'>".$history['attachments'][$index][$key][0]['token']."</a>";
																						}
																						$dt_snt = (!empty($value['date_out']) && $value['date_out'] != '0000-00-00 00:00:00') ? date("M j Y, g:i a", strtotime($value['date_out'])) : '--';
																						// TABLE ROW DISPLAY
																						if($value['multiprc']==1) {echo "<tr><td colspan='8' style='text-align:center; color: red'>* Routed to Multiple Person *</td></tr>";break;}
																						echo "<tr>
																							<td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
																							<td>".$value['action_taken']."</td>
																							<td>".$value['remarks']."</td>
																							<td>".$history['ds_sender'][$index][$key].' -'.$value['sender_name']."</td>
																							<td>".$value['status_description']."</td>
																							<td>".$history['ds_receiver'][$index][$key].' -'.$rcvr."</td>
																							<td>".$dt_snt."</td>
																							<td>".$attached_file."</td>
																						</tr>";
																					}
																				}
						                          ?>
						                      </tbody>
						                    </table>
						                    <?php
						                    // }
						                  ?>
													</div>
												</div>
											</div>

									</div><!-- Nav- AllTabContents End -->
							</div>

						</div>
						<!-- Card Body -->
						<div class="card-footer">
							 <!-- onclick="Dms.process_transaction();" -->
							<button id="process_transaction_button" type="submit" class="btn btn-success btn-icon-split float-right" name="process_transaction"><span class="text"><i class="fas fa-share-square"></i> Process</span></button><br /><br />
						</div>

					</form>

	      </div>
	    </div>
	  </div>
	</div>

</div> <!-- Header Wrapper End -->

<script>

	$(document).ready(function(){

		$('#sys_main').selectize({
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change");
			}
		});

		$('#trans_status').selectize({
			dropdownParent: "body",
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change on trans_status");
			}
		});

		$("input[name='asgnto_multiple']").change(function() {
	    if(this.checked) {
				$("#assignto-multiple-group").show();
				$("#assignto-group").hide();
	    }
			else {
				$("#assignto-multiple-group").hide();
				$("#assignto-group").show();
			}
		});

		$('button#add_company').click(function(){
			$.ajax({
	         url: '/embis/dms/data/ajax/add_company_modal1',
	         type: 'POST',
					 data: {'user_region': '<?=$user['region']?>'},
	         success: function(result) {
	             $('div#dmsAddCompanyModal div.modal-body').html(result);
	         }
	     });
		});

		var send_group = $('div#sendinfo-attachments-group');

		var region_slct = send_group.find('div#assignto-group select[name="region"]');
		var division_slct = send_group.find('div#assignto-group select[name="division"]');
		var section_slct = send_group.find('div#assignto-group select[name="section"]');
		var receiver_slct = send_group.find('div#assignto-group select[name="receiver"]');

		var rgn_dslctd = region_slct.data('selected');
		var div_dslctd = division_slct.data('selected');
		var sec_dslctd = section_slct.data('selected');
		var rcv_dslctd = receiver_slct.data('selected');

		var region_val = '';
		if(region_slct.is(':visible')) {
			region_val = region_slct.val();

			region_slct.change(function() {
				$('#asgnto-spinner').show();
				send_group.find('div#assignto-group select').prop('disabled', true);
				send_group.find('span#assignto-refunc-group button').prop('disabled', true);
				region_val = $(this).val();
				$.ajax({
						url: '/embis/dms/data/ajax/get_division',
						method: 'POST',
						data: { 'selected': div_dslctd, 'region': region_val },
						dataType: 'html',
						success: function(response) {
							division_slct.html(response).change();
						},
						error: function(response) {
							division_slct.empty().html("<option value=''>-No Data-</option>").change();
							console.log("ERROR");
						},
				});
			}).change();
		}

		division_slct.change(function() {
			$('#asgnto-spinner').show();
			send_group.find('div#assignto-group select').prop('disabled', true);
			send_group.find('span#assignto-refunc-group button').prop('disabled', true);
			var division_val = $(this).val();
			$.ajax({
					url: '/embis/dms/data/ajax/get_section',
					method: 'POST',
					data: { 'selected': sec_dslctd, 'division': division_val, 'region': region_val },
					dataType: 'html',
					success: function(response) {
						section_slct.html(response).change();
					},
					error: function(response) {
						section_slct.empty().html("<option value=''>-No Data-</option>").change();
						console.log("ERROR");
					},
			});
		});

		section_slct.change(function() {
			$('#asgnto-spinner').show();
			send_group.find('div#assignto-group select').prop('disabled', true);
			send_group.find('span#assignto-refunc-group button').prop('disabled', true);
			var section_val = $(this).val();
			var division_val = division_slct.val();
			$.ajax({
					url: '/embis/dms/data/ajax/get_personnel',
					method: 'POST',
					data: { 'selected': rcv_dslctd, 'section': section_val, 'division': division_val, 'region': region_val },
					dataType: 'html',
					success: function(response) {
						receiver_slct.html(response);
						$('#asgnto-spinner').hide();
						send_group.find('div#assignto-group select').prop('disabled', false);
						send_group.find('span#assignto-refunc-group button').prop('disabled', false);
					},
					error: function(response) {
						receiver_slct.empty().html("<option value=''>-No Data-</option>").change();
						$('#asgnto-spinner').hide();
						send_group.find('div#assignto-group select').prop('disabled', false);
						send_group.find('span#assignto-refunc-group button').prop('disabled', false);
						console.log("ERROR");
					},
			});
		});

		$('#asgn_recall').click(function(){
			div_dslctd = '<?=$recall[0]['receiver_divno']?>';
			sec_dslctd = '<?=$recall[0]['receiver_secno']?>';
			rcv_dslctd = '<?=$recall[0]['receiver_id']?>';

			if(div_dslctd != '') {
		    region_slct.val('<?=$recall[0]['receiver_region']?>').trigger('change');
			}
		});

		$('#asgn_revert').click(function(){
			div_dslctd = '<?=$revert[0]['divno']?>';
			sec_dslctd = '<?=$revert[0]['secno']?>';
			rcv_dslctd = '<?=$revert[0]['token']?>';

			region_slct.val('<?=$revert[0]['region']?>').trigger('change');
		});

		//Dropzone
		Dropzone.autoDiscover = false;
		// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
		var previewNode = document.querySelector("#att_template");
		previewNode.id = "";
		var previewTemplate = previewNode.parentNode.innerHTML;
		previewNode.parentNode.removeChild(previewNode);

		var myDropzone = new Dropzone( "div.erattdropzone", { // Make the whole body a dropzone
		  url: '/embis/dms/data/ajax/file_upload', // Set the url
			params: { enc_key: "<?php echo $enc_key; ?>", route_order: "<?php echo $trans_data[0]['route_order']; ?>", },
			maxFilesize: 20,
		  parallelUploads: 20,
			acceptedFiles: "image/*,application/pdf,.docx,.doc,.xlsx,.xls,.pptx,.ppt,.zdoc,.zsheet,.zshow",
		  previewTemplate: previewTemplate,
			timeout: 0,
		  autoQueue: false, // Make sure the files aren't queued until manually added
		  previewsContainer: "#previews", // Define the container to display the previews
		  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
		} );
		myDropzone.on("addedfile", function(file) {
		  // Hookup the start button
		  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
				$('#process_transaction_button').prop('disabled', true);
		});
		// Update the total progress bar
		myDropzone.on("totaluploadprogress", function(progress) {
		  document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
		});
		myDropzone.on("sending", function(file) {
		  // Show the total progress bar when upload starts
		  document.querySelector("#total-progress").style.opacity = "1";
		  // And disable the start button
		  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
		});
		// Hide the total progress bar when nothing's uploading anymore
		myDropzone.on("queuecomplete", function(progress) {
		  document.querySelector("#total-progress").style.opacity = "0";
		  $('#process_transaction_button').prop('disabled', false);
		});
		// Setup the buttons for all transfers
		// The "add files" button doesn't need to be setup because the config
		// `clickable` has already been specified.
		document.querySelector("#actions .start").onclick = function() {
		  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
		};
		document.querySelector("#actions .cancel").onclick = function() {
		  myDropzone.removeAllFiles(true);
		};

		$('.trans-delete-uploaded').on('click', function() {
			var _this = $(this);
			var file_name = $.trim(_this.closest("tr").find("td:first").text());
			var file_token = $.trim(_this.closest("tr").find("td:eq(1)").text());
			var request = $.ajax({
				url: Dms.base_url + 'Dms/fileDelete', // /embis/dms/data/ajax/file_delete
				method: 'POST',
				data: { enc_key: "<?php echo $enc_key; ?>", route_order: "<?php echo $trans_data[0]['route_order']; ?>", file_name : file_name, file_token : file_token, },
				success: function() {
					// add syntax for -display on .success-notice span
					console.log('SUCCESS');
				},
				error: function(response) {
					// add syntax for -display on .error-delete span
					console.log("ERROR");
				},
			});

			// request.done(function(data) {
				// if (data.error == 1) {
					_this.closest("tr").hide();
				// }
			// });

		});
	}); // DOCUMENT READY END
</script>
