<style>

</style>
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-edit"> </i> REVISE TRANSACTION</h6>
						</div>
						<?php echo form_open_multipart('Dms/Dms/route_transaction', array('id' => 'trans_form')); ?>
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
														<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab"> <br />
															<span class="set_note">- Please fill-in the required fields before processing. If uncertain of the data, you may click "Save as Draft" button to save this current transaction  and continue later. -</span>
															<div class="row">
																<div class="col-md-4"><br />
																	<div class="form-group">
																		<label>Transaction No.:</label>
																		<input class="form-control form-control-sm" value="<?php echo $trans_data[0]['token']; ?>" readonly />
																	</div>
																	<div class="form-group">
																		<label>System:</label><?php echo form_error('system'); ?>
																		<select id="sys_main" class="form-control form-control-sm" onchange="Dms.system_select(this.value);" name="system" >
																			<option selected="" value="">--</option>
																			<?php
																				foreach ($system as $value) {
																					if($value['id']==$trans_data[0]['system'])
																					{
																						echo '<option selected value="'.$value['id'].'" >'.$value['name'].'</option>';
																					}
																					else
																					{
																						echo '<option value="'.$value['id'].'" >'.$value['name'].'</option>';
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
																					else {
																						if($value['id']==$trans_data[0]['type'])
																						{
																							echo '<option selected value="'.$value['id'].'" >'.$value['name'].'</option>';
																						}
																						else
																						{
																							echo '<option value="'.$value['id'].'" >'.$value['name'].'</option>';
																						}
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
																		<label>Subject:</label><?php echo form_error('subject'); ?>
																		<textarea class="form-control form-control-sm" id="subject" name="subject"><?php echo (!empty($trans_data[0]['subject'])) ? trim($trans_data[0]['subject']) : set_value('subject'); ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Transaction Status:</label><?php echo form_error('status'); ?>
																		<select class="form-control form-control-sm" id="trans_status" name="status" onchange="Dms.removeAsgnPrsnl(this.value);">
																			<option selected value="">--</option>
																			<?php
																				foreach ($status as $key => $value) {
																					if($value['id']==$trans_data[0]['status'])
																					{
																						echo '<option selected value="'.$value['id'].'" >'.($key+1).' - '.$value['name'].'</option>';
																					}
																					else
																					{
																						echo '<option value="'.$value['id'].'" '.set_select('status', $value['id']).' >'.($key+1).' - '.$value['name'].'</option>';
																					}
																				}
																			?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label title="Move your mouse over on an Option to know more details about that specific Option">Tag Document Type As: <i class="fa fa-question-circle"></i></label>
																		<select class="form-control form-control-sm" name="tag_doc_type">
																			<option selected value="">-none-</option>
																			<option title="Set This Transaction's Viewing Properties to 'ONLY WITHIN ROUTED PERSONNELS' and makes it Not Viewable on All Transactions " value="1">  Confidential</option>
																		</select>
																	</div>
																</div>

																<div class="col-md-4"> <br>

																	<div class="form-group">
																		<label>Company EMB ID:</label>
																		<input class="form-control form-control-sm" id="company_embid" value="<?php echo $trans_data[0]['emb_id']; ?>" readonly />
																	</div>
																	<div class="form-group">
																		<label>Company:</label><?php echo form_error('company'); ?>
																		<button type="button" class="btn btn-success" data-toggle="modal" data-target=".addCompanyModal" data-backdrop="static" onclick="Dms.add_trans_company(<?=$trans_session?>)">Select Company</button>
																		<input class="form-control form-control-sm" type="hidden" name="company" value="<?=$trans_data[0]['company_token']?>" />
																		<textarea id="company_display" class="form-control form-control-sm" type="text" required readonly/><?='[ '.$trans_data[0]['emb_id'].' ]- '.$trans_data[0]['company_name']?></textarea>

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
																		<label>Assigned to:</label><?php echo form_error('division'); ?><?php echo form_error('section'); ?><?php echo form_error('receiver'); ?>
																		<div id="asgn_radio_div">
																			<input type="radio" name="asgn_radio" value="single" checked/>Single
																			<input type="radio" name="asgn_radio" value="multiple" />Multiple
																			<input type="radio" name="asgn_radio" value="all_region" />All Region
																		</div>
																		<?php
																			if($credentials[0]['secno'] == 77 || $_SESSION['superadmin_rights'] == 'yes') // RECORDS
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
																		?>

																		<select id="division_id" class="form-control form-control-sm" name="division" onchange="Dms.select_division(this.value);">
																			<option selected value="">--</option>
																			<?php
																				foreach ($division as $key => $value) {
																					if($value['divno']==$trans_data[0]['receiver_division'])
																					{
																						echo '<option selected value="'.$value['divno'].'">'.$value['divname'].'</option>';
																					}
																					else {
																						echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
																					}
																				}
																			?>
																		</select> <br />

																		<select id="section_id" class="form-control form-control-sm" name="section" onchange="Dms.select_section(this.value);">
																			<option selected value="">--</option>
																			<?php
																				if(!empty($trans_data[0]['receiver_id']) && empty($trans_data[0]['receiver_section'])) {
																					echo '<option selected value="0">N/A</option>';
																				}
																				else {
																					echo '<option value="0">N/A</option>';
																				}
																				foreach ($section as $key => $value) {
																					if($value['secno']==$trans_data[0]['receiver_section'])
																					{
																						echo '<option selected value="'.$value['secno'].'">'.$value['sect'].'</option>';
																					}
																					else {
																						echo '<option value="'.$value['secno'].'">'.$value['sect'].'</option>';
																					}
																				}
																			?>
																		</select> <br />

																		<select id="personnel_id" class="form-control form-control-sm" name="receiver" >
																			<option selected value="">--</option>
																			<?php
																				if(!empty($trans_cred))
																				{
																					foreach ($trans_cred as $value) {
																						if($value['token']==$trans_data[0]['receiver_id'])
																						{
																							echo '<option selected value="'.$value['token'].'">'.ucwords($value['fname'].' '.$value['sname'].' '.$value['suffix']).'</option>';
																						}
																						else
																						{
																							echo '<option value="'.$value['token'].'">'.ucwords($value['fname'].' '.$value['sname'].' '.$value['suffix']).'</option>';
																						}
																					}
																				}
																			?>
																		</select>
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
																		<select class="form-control form-control-sm" name="action" >
																			<option selected value="">--</option>
																		<?php
																			foreach ($action as $value) {
																				if($value['text']==$trans_data[0]['action_taken'])
																				{
																					echo '<option selected value="'.$value['text'].'" >'.$value['code'].' - '.$value['text'].'</option>';
																				}
																				else
																				{
																					echo '<option value="'.$value['text'].'" '.set_select('action', $value['text']).' >'.$value['code'].' - '.$value['text'].'</option>';
																				}
																			}
																		?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Remarks:</label>
																		<textarea class="form-control form-control-sm" name="remarks"><?php echo (!empty($trans_data[0]['remarks'])) ? trim($trans_data[0]['remarks']) : set_value('remarks'); ?></textarea>
																	</div>
																	<?php
																		if($credentials[0]['secno'] == 77 || $_SESSION['superadmin_rights'] == 'yes') // RECORDS
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
																		<span class="set_note">- please upload attachment(s) before saving / processing -</span>
																		<input type="text" placeholder="wla lng towhz" name="sampsisisamp" value="" />
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
																								<button type="button" class="btn btn-outline-danger btn-sm delete" data-toggle="dltetrans_att" data-trigger="focus">
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
					                                            <td style="text-align: center">
					                                              <button type="button" class="btn btn-outline-danger btn-sm delete" data-toggle="popover" data-trigger="focus">
					                                                <i class="fas fa-trash"></i>
					                                              </button>
					                                            </td>
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
																<div class="col-md-12" style="text-align: center">
																	<br /><h3>TRANSACTION HISTORY</h4><br />
																	<table class="table table-striped" style="zoom: 90%">
																		<thead class="thead-dark">
																			<tr>
																				<th>Date</th>
																				<th>Action</th>
																				<th>From</th>
																				<th>Status</th>
																				<th>Assigned</th>
																				<th>Date Rcvd.</th>
																				<th>View</th>
																			</tr>
																		</thead>
																		<tbody>
							                        <?php
							                          foreach ($trans_history as $key => $value) {

							                              $rcvr = (!empty($value['receiver_name'])) ? $value['receiver_name'] : '--';
							                              $att_cnt = @array_count_values(array_column($attachment_view, 'route_order'))[$value['route_order']];
							                              $att = '--';

							                              $trans_no_calculated = $trans_data[0]['trans_no'];
							                              if($trans_data[0]['start_date'] < '2020-02-16') {
							                                $trans_no_calculated = $trans_data[0]['trans_no'] - 10000000;
							                              }

							                              if(!empty($att_cnt))
							                              {
							                                if($att_cnt > 1)
							                                {
							                                  $att = "<div class='btn-group float-right'><button class='btn btn-info btn-sm dropdown-toggle waves-effect waves-light' type='button' data-toggle='dropdown'>View </button>
							                                  <div class='dropdown-menu'>";
							                                      $filecount = 0;
							                                      while(count($attachment_view) != $filecount)
							                                      {
							                                        $att_name = str_replace(' ', '_', trim($attachment_view[$filecount]['file_name']));
							                                        $att .= "<a  class='dropdown-item' title='".$att_name."' href='".base_url('uploads/dms/'.date('Y').'/'.$user_region.'/'.$trans_no_calculated .'/'.$attachment_view[$filecount]['token'].'.'.pathinfo($att_name, PATHINFO_EXTENSION))."' target='_blank'>".$attachment_view[$filecount]['token']."</a>";
							                                        $filecount++;
							                                      }
							                                  $att .= "</div></div>";
							                                }
							                                else {
							                                  $att_name = str_replace(' ', '_', trim($attachment_view[0]['file_name']));
							                                  $att = "<a title='".$att_name."' href='".base_url('uploads/dms/'.date('Y').'/'.$user_region.'/'.$trans_no_calculated .'/'.$attachment_view[0]['token'].'.'.pathinfo($att_name, PATHINFO_EXTENSION))."' target='_blank'>".$attachment_view[0]['token']."</a>";
							                                }
							                              }

							                            if($value['route_order'] != 0) {
							                              echo "<tr>
							                                <td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
							                                <td>".$value['action_taken']."</td>
							                                <td>".$value['sender_name']."</td>
							                                <td>".$value['status_description']."</td>
							                                <td>".$rcvr."</td>
							                                <td>".date("M j Y, g:i a", strtotime($value['date_out']))."</td>
							                                <td>".$att."</td>
							                              </tr>";
							                            }
							                          }
							                        ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div class="tab-pane fade" id="sweet-report" role="tabpanel" aria-labelledby="sweet-report-tab"> - UNDER DEV. - </div>
														<div class="tab-pane fade" id="pco-accreditation" role="tabpanel" aria-labelledby="pco-accreditation-tab"> - UNDER DEV. - </div>

												</div>

												<div class="col-xl-12 mb-3">

												</div>

										</div>

							</div>
						<!-- Card Body -->
						<div class="card-footer">
							<div class=" float-right">
								<button id="save_draft_button" type="submit" class="btn btn-danger btn-sm btn-icon-split " name="save_draft"><span class="text"> <i class="far fa-save"></i> Save Revisions</span></button>&nbsp;&nbsp;
								<button id="process_transaction_button" type="submit" class="btn btn-danger btn-sm btn-icon-split" name="process_transaction" disabled><span class="text"> <i class="fas fa-share-square"></i> Process Revision</span></button> <br /><br />
							</div>
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
		// Selectize
		$('#sys_main').selectize({
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change");
			}
		});
		$('#company_list').selectize({
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change on company_list");
			}
		});
		$('#trans_status').selectize({
			dropdownParent: "body",
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change on company_list");
			}
		});
		$("input[name=asgn_radio]").on('click', function() {
			console.log($(this).val());
			// if($(this).val() == 'single') {
			//
			// }
		});
		$('input[name=asgn_radio]:checked').trigger("click");

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
				route_order: "<?php echo $trans_data[0]['route_order']; ?>",
				region: "<?php echo $trans_data[0]['region']; ?>",
    	},
			maxFilesize: 20,
		  parallelUploads: 20,
			acceptedFiles: "image/*,application/pdf,.docx,.doc,.xlsx,.xls",
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

		// $('[data-toggle="dltetrans_att"]').popover({
    //     placement : 'top',
    //     html : true,
    //     title : 'Delete Attachment <a href="#" class="close" data-dismiss="alert">&times;</a>',
    //     content : '<div class="media"><a href="#" class="pull-left"></a><div class="media-body"><button type="button" class="btn btn-danger">Yes</button><button type="button" class="btn btn-danger">No</button></div></div>',
    // });
		//
		// $('.popover-dismiss').popover({
		//   trigger: 'focus'
		// })


	$('.trans-delete-uploaded').on('click', function(){
		var file_name = $.trim($(this).closest("tr").find("td:first").text());
		var file_token = $.trim($(this).closest("tr").find("td:eq(1)").text());
		// console.log('<?php // echo $trans_data[0]['route_order'] ?>');
		// console.log(file_name);
		// console.log(file_token);
		// console.log('asdsd');
		$.ajax({
			url: Dms.base_url + 'Dms/fileDelete',
			method: 'POST',
			data: {
				trans_session: "<?php echo $trans_session; ?>",
				main_route_order: "<?php echo $trans_data[0]['main_route_order']; ?>",
				route_order: "<?php echo $trans_data[0]['route_order']; ?>",
				region: "<?php echo $trans_data[0]['region']; ?>",
				file_name : file_name,
				file_token : file_token,
			},
			success: function() {
				console.log('success out');
			}
    });
	});

	// $('[data-toggle="popover"]').popover({
  //   trigger : 'click',
  //   placement : 'top',
  //   html: true,
  //   content : '<textarea class="popover-textarea"></textarea>',
  //   template: '<div class="popover"><div class="arrow"></div>'+
  //             '<h3 class="popover-title"></h3><div class="popover-content">'+
  //             '</div><div class="popover-footer"><button type="button" class="btn btn-primary popover-submit">'+
  //             '<i class="icon-ok icon-white"></i></button>&nbsp;'+
  //             '<button type="button" class="btn btn-default popover-cancel">'+
  //             '<i class="icon-remove"></i></button></div></div>'
	// 	})
	// 	.on('shown', function() {
	// 	    //hide any visible comment-popover
	// 	    $("[rel=comments]").not(this).popover('hide');
	// 	    var $this = $(this);
	// 	    //attach link text
	// 	    $('.popover-textarea').val($this.text()).focus();
	// 	    //close on cancel
	// 	    $('.popover-cancel').click(function() {
	// 	        $this.popover('hide');
	// 	    });
	// 	    //update link text on submit
	// 	    $('.popover-submit').click(function() {
	// 	        $this.text($('.popover-textarea').val());
	// 	        $this.popover('hide');
	// 	    });
	// 		});

	});

</script>
