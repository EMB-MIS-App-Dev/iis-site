<div class="container-fluid">
	<div class="row">

		<!-- DATATABLES Card -->
		<div class="col-xl-12 col-lg-12">
			<div class="trans-layout card shadow mb-4">

						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> PROCESS TRANSACTION</h6>

						</div>

						<?php echo form_open_multipart('Dms/Dms/route_transaction'); ?>
						<!-- Card Body -->
							<div class="card-body">

										<div class="data-div table-responsive">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Add</a>
													<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
												</div>
											</nav>
												<input class="form-control form-control-sm" type="hidden" name="trans_no" value="<?php echo $trans_session; ?>" readonly />
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab" style="min-height: 650px">
															<div class="row">
																<div class="col-md-4"><br />
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
																					echo '<option value="'.$value['id'].'">'.($key+1).' - '.$value['name'].'</option>';
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
																			<?php
																			// if(!empty($trans_data[0]['qr_code_token'] AND ($this->session->userdata('trans_qrcode') == 'yes' OR $this->session->userdata('superadmin_rights') == 'yes'))){
																				echo "<label>Please copy and paste QR Code into the document to be routed:</label><br>";
																				echo "<input type='hidden' class='form-control' name='qr_code' value='".$trans_data[0]['qr_code_token']."' readonly>";
																				echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fiis.emb.gov.ph/verify?token=".$trans_data[0]['qr_code_token']."%2F&choe=UTF-8' style='width:150px;'>";
																			// } 
																			?>
																		</div>
																	</div>

																</div>

																<div class="col-md-4"> <br>

																	<div class="form-group">
																		<label>Company EMB ID:</label>
																		<input class="form-control form-control-sm" id="company_embid" value="<?php echo $trans_data[0]['emb_id']; ?>" readonly />
																	</div>
																	<div class="form-group">
																		<label>Company:</label><?php echo form_error('company'); ?>
																		<select id="company_list" class="form-control form-control-sm" name="company" onchange="Dms.company_details(this.value);">
																			<option selected value="">--</option>
																			<?php
																				foreach ($company_list as $value) {
																					if($value['token']==$trans_data[0]['company_token'])
																					{
																						echo '<option selected value="'.$value['token'].'"> [ '.$value['emb_id'].' ]- '.$value['company_name'].'</option>';
																					}
																					else
																					{
																						echo '<option value="'.$value['token'].'"> [ '.$value['emb_id'].' ]- '.$value['company_name'].'</option>';
																					}
																				}
																			?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Company Address:</label>
																		<textarea class="form-control form-control-sm" id="company_address" readonly><?php echo ucwords(trim($company_details[0]['house_no'].' '.$company_details[0]['street'].' '.$company_details[0]['barangay_name'].', '.$company_details[0]['city_name'].' '.$company_details[0]['province_name'])); ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Project Type:</label>
																		<textarea class="form-control form-control-sm" id="project_type" readonly><?php echo $company_details[0]['project_name']; ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Project Category:</label>
																		<textarea class="form-control form-control-sm" id="project_category" readonly><?php echo ''; ?></textarea>
																	</div>

																</div>

																<div class="col-md-4"> <br>
                                  <div id="asgnprsnl_div" class="form-group">

																		<div class="row">
																			<div class="custom-control mr-sm-3">
																				<label>Assigned to:</label>
																			</div>
																			<?php
																				if( $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['trans_multiprc'] == 'yes')
																				{
																				?>
																					<div class="custom-control custom-checkbox mr-sm-2">
																		        <input type="checkbox" class="custom-control-input" id="asgntoMultiple" name="asgnto_multiple" value="multiple">
																		        <label class="custom-control-label" for="asgntoMultiple">Multiple</label>
																		      </div>
																				<?php
																				}
																			?>
																			<div class="custom-control mr-sm-3">
																				<?php echo form_error('division'); ?><?php echo form_error('section'); ?><?php echo form_error('receiver'); ?>
																			</div>
																		</div>
																		<div id="asgnto_multiple_div" style="display: none">
																			<button type="button" class='btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.addPersonnelsModal'> Multi-Process</button>
																			<fieldset readonly>
																				<br /> <label>Selected Personnel(s):</label>
																				<div id="slctd_prsnl_div">
																					-empty-
																				</div>
																			</fieldset>
																		</div>
																		<div id="asgnto_slctn">
																			<?php
																				if($credentials[0]['secno'] == 77 || $_SESSION['rec_officer'] == 'yes' || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['trans_regionalprc'] == 'yes' || in_array($credentials[0]['secno'], array(73,165,177,190,239,284,317,2,6,151,188,246,292))) // RECORDS
																				{
																			?>
																				<select id="region_id" class="form-control form-control-sm" name="region" onchange="Dms.select_region(this.value);">
																					<?php
																						foreach ($region as $key => $value) {
																							if($value['rgnnum']==$trans_data[0]['receiver_region'])
																							{
																								echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
																							}
																							else if(empty($trans_data[0]['receiver_region']) && $value['rgnnum']==$user_region)
																							{
																								echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
																							}
																							else {
																								echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
																							}
																						}
																					?>
																				</select> <br />
																			<?php
																				}
																				else{
																					?>
																					<input id="region_id" type="hidden" value="<?php echo $trans_data[0]['receiver_region'];?>" />
																					<?php
																				}
																			?>
	                                    <select id="division_id" class="form-control form-control-sm" name="division" onchange="Dms.select_division(this.value);">
	                                      <option selected value="">--</option>
	                                      <?php
	                                        foreach ($division as $key => $value) {
	                                          echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
	                                        }
	                                      ?>
	                                    </select> <br />

	                                    <select id="section_id" class="form-control form-control-sm" name="section" onchange="Dms.select_section(this.value);">
	                                      <option selected value="">--</option>
	                                    </select> <br />

	                                    <select id="personnel_id" class="form-control form-control-sm" name="receiver" >
	                                      <option selected value="">--</option>
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
																		if($credentials[0]['secno'] == 77 || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['rec_officer'] == 'yes') // RECORDS
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
																	<div class="form-group" >
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
																								<button type="button" class="btn btn-outline-danger btn-sm trans-delete-uploaded">
																									<i class="fas fa-trash"></i>
																								</button>
																							</td>
																						<?php } ?>
																					</tr>
																				<?php } ?>
																			</table>
																		<?php } ?>
																	</div>

																</div>

															</div>
														</div>

														<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab"  style="min-height: 650px">
															<div class="row">
																<div class="col-md-12" style="text-align: center; display: inline-block">
																	<br /><h3>TRANSACTION HISTORY</h4><br />
																		<?php
									                    if(!empty($trans_history[0]['receiver_id']))
									                    {
									                    ?>
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
									                            foreach ($trans_history as $key => $value) {
									                              if($value['main_multi_cntr'] == 0)
									                              {
									                                $rcvr = (!empty(trim($value['receiver_name']))) ? $value['receiver_name'] : '--';
									                                $attach = '--';

									                                $trans_no_calculated = $value['trans_no'];
									                                if($value['date_in'] < '2020-02-16') {
									                                  $trans_no_calculated = $value['trans_no'] - 10000000;
									                                }

									                                if(!empty($attachment_view[$key]))
									                                {
									                                  if(sizeof($attachment_view[$key]) > 1)
									                                  {
									                                    $attach = "<div class='dropdown'><button class='btn btn-info btn-sm waves-effect waves-light' type='button' data-toggle='dropdown'>View <i class='far fa-caret-square-down'></i></button> <ul class='dropdown-menu'  style='max-height: 500px; overflow: auto'>";

									                                    foreach ($attachment_view[$key] as $att_key => $att_value) {
									                                      if(!empty($prnl_inthread) || in_array($user_func['func'], array('Division Chief', 'Section Chief', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
									                                      {
									                                        $attach .= "<li><a title='".$att_value['file_name']."' href='".base_url('uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'].'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION))."' target='_blank'>".$att_value['token']."</a></li>";
									                                      }
									                                      else {
									                                        $attach .= "<li>".$att_value['token']."</li>";
									                                      }
									                                    }

									                                    $attach .= "</ul></div>";
									                                  }
									                                  else {
									                                    $att_value = $attachment_view[$key][0];
									                                    if(!empty($prnl_inthread) || in_array($user_func['func'], array('Division Chief', 'Section Chief', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
									                                    {
									                                      $attach = "<a title='".$att_value['file_name']."' href='".base_url('uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'].'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION))."' target='_blank'>".$att_value['token']."</a>";
									                                    }
									                                    else {
									                                      $attach = $att_value['token'];
									                                    }
									                                  }
									                                }

									                                if( $value['route_order'] != 0 && (!empty($value['receiver_id']) || $value['status'] == 24 || $value['type'] == 83) ) {
									                                  echo "<tr>
									                                    <td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
									                                    <td>".$value['action_taken']."</td>
									                                    <td>".$value['remarks']."</td>
									                                    <td>".$from_name[$key].$value['sender_name']."</td>
									                                    <td>".$value['status_description']."</td>
									                                    <td>".$receiver_name[$key].$rcvr."</td>
									                                    <td>".date("M j Y, g:i a", strtotime($value['date_out']))."</td>
									                                    <td>".$attach."</td>
									                                  </tr>";
									                                }
									                              }
									                            }
									                          ?>
									                      </tbody>
									                    </table>
									                    <?php
									                    }
									                  ?>
									                  <?php
									                    if(!empty($multitrans_histo)) {
									                      echo '<span class="set_error">*This transaction was routed to multiple persons below*</span>';
									                      foreach ($multitrans_histo as $key => $value) {
									                        $umhist = ($value['receiver_id'] == $user_token || $value['sender_id'] == $user_token) ? 'user-multi-history' : '';
									                        $multi_key = $value['trans_no'].'_'.$value['main_route_order'].'_'.$value['main_multi_cntr'].'_'.$value['multi_cntr'];
									                        echo '
									                          <button onclick="Dms.multitrans_div($(this))" class="btn btn-default btn-sm multitrans-div '.$umhist.'" type="button" data-toggle="collapse" data-target="#multitrans_'.$multi_key.'" id="buttonassignsec">
									                            <span class="multi-name" tyle="color: white">Person '.$value['multi_cntr'].'</span>
									                            <span class="fa fa-caret-down" id="btncaretsub"></span>
									                          </button>

									                          <div class="collapse" id="multitrans_'.$multi_key.'">
									                            <div class="card card-body" style="margin-top:10px;padding-left:5px;padding-right:5px;border-color:#08507E;border-top-left-radius:0px;border-top-right-radius:0px;">
									                              <div id="multitrans_'.$multi_key.'_insert" class="row" style="padding-top:5px;padding-left:2px;padding-right:2px; text-align: center">
									                                <div class="col-md-12">- loader - </div>
									                              </div>
									                            </div>
									                          </div>
									                        ';
									                      }
									                    }
									                  ?>
																</div>
															</div>
														</div>

												</div>
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

<script type="text/javascript">

	Dropzone.autoDiscover = false;

  $(document).ready(function() {
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

	$('#company_list').selectize({
		onChange: function(value, isOnInitialize) {
			console.log("Selectize event: Change on company_list");
		}
	});

	$("input[name='asgnto_multiple']").change(function() {
	    if(this.checked) {
	        console.log('asgnto_slctn:hide');
					$("#asgnto_multiple_div").show();
					$("#asgnto_slctn").hide();
	    }
			else {
	        console.log('asgnto_slctn:show');
					$("#asgnto_multiple_div").hide();
					$("#asgnto_slctn").show();
			}
	});

	//Dropzone
	// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
	var previewNode = document.querySelector("#att_template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	var myDropzone = new Dropzone("div.erattdropzone", { // Make the whole body a dropzone
	  url: "<?php echo base_url('Dms/Dms/fileUpload'); ?>", // Set the url
		params: {
   		trans_session: "<?php echo $trans_session; ?>",
			main_route_order: "<?php echo $trans_data[0]['main_route_order']; ?>",
			route_order: "<?php echo $trans_data[0]['route_order']; ?>",
			region: "<?php echo $trans_data[0]['region']; ?>",
  	},
	  // thumbnailWidth: 80,
	  // thumbnailHeight: 80,
		maxFilesize: 20,
	  parallelUploads: 20,
		acceptedFiles: "image/*,application/pdf,.docx,.doc,.xlsx,.xls,.pptx,.ppt,.zdoc,.zsheet,.zshow",
	  previewTemplate: previewTemplate,
		timeout: 0,
	  autoQueue: false, // Make sure the files aren't queued until manually added
	  previewsContainer: "#previews", // Define the container to display the previews
	  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
	});

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

	$('.trans-delete-uploaded').on('click', function(){
		var file_name = $.trim($(this).closest("tr").find("td:first").text());
		var file_token = $.trim($(this).closest("tr").find("td:eq(1)").text());
		// console.log('<?php // echo $trans_data[0]['route_order'] ?>');
		// console.log(file_name);
		// console.log(file_token);
		// console.log('asdsd');
		var request = $.ajax({
			url: Dms.base_url + 'Dms/fileDelete',
			method: 'POST',
			data: {
				trans_session: "<?php echo $trans_session; ?>",
				main_route_order: "<?php echo $trans_data[0]['main_route_order']; ?>",
				route_order: "<?php echo $trans_data[0]['route_order']; ?>",
				// main_multi_cntr: "<?php echo $this->session->userdata('main_multi_cntr'); ?>",
				region: "<?php echo $trans_data[0]['region']; ?>",
				file_name : file_name,
				file_token : file_token,
			},
			success: function() {
				console.log('success out');
			}
		});

		// request.done(function(data) {
			// if (data.error == 1) {
				$(this).closest("tr").hide();
			// }
		// });

	});
});

</script>
