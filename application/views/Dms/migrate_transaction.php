
<div class="container-fluid">
	<div class="row">

		<!-- DATATABLES Card -->
		<div class="col-xl-12 col-lg-12">
			<div class="trans-layout card shadow mb-4">

				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-random"></i> MIGRATE NEW DATA</h6>
					<!-- <span class="float-right">
						<a class=""><i class="fas fa-question-circle"></i></a>
					</span> -->
				</div>

				<?php echo form_open_multipart('Dms/migrate/migrate_submit'); ?>
				<!-- Card Body -->
				<div class="card-body">

					<div class="data-div table-responsive">
						<nav>
							<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Add</a>
							</div>
						</nav>
						<input type="hidden" name="trans_no" value="<?=$trans_data[0]['trans_no']?>" readonly />
						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab"> <br />
								<span class="set_note">- Please fill-in the required fields before processing. If uncertain of the data, you may click "Save as Draft" button to save this current transaction  and continue later. -</span>
								<div class="row">
									<div class="col-md-4"><br />
										<div class="form-group">
											<label>Transaction No.:</label>
											<input class="form-control" value="<?=$trans_data[0]['token']?>" readonly />
										</div>
										<div class="form-group">
											<label>System:</label>
											<select id="sys_main" class="form-control" onchange="Dms.system_select(this.value);" name="system" >
												<option selected="" value="">--</option>
												<?php
												foreach ($system_list as $system) {
													echo '<option value="'.$system['id'].'">'.$system['name'].'</option>';
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Sub-System:</label>
											<select class="form-control" id="type" name="type" onchange="Dms.additional_inputs(this.value)" required >
												<option selected value="">--</option>
											</select>
										</div>
										<!-- DIV FOR ADDITIONAL SELECTIONS -->
										<div id="additional_inputs">
										</div>
										<!-- END OF DIV FOR ADDITIONAL SELECTIONS -->
										<div class="form-group">
											<label>Subject Name:</label>
											<textarea class="form-control" id="subject" name="subject" required><?=set_value('subject')?></textarea>
										</div>
										<div class="form-group">
											<label>Transaction Status:</label>
											<input name="status" type="hidden" value="5"/>
											<input class="form-control" value="signed document" disabled/>
										</div>
										<?php
										if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['set_confidential_tag'] == 'yes' )
										{
											?>
											<div class="form-group">
												<label title="Move your mouse over on an Option to know more details about that specific Option">Tag Document Type As: <i class="fa fa-question-circle"></i></label>
												<select class="form-control" name="tag_doc_type">
													<option selected value="" <?=set_select('tag_doc_type', '')?>>-none-</option>
													<option title="Set This Transaction's Viewing Properties to 'ONLY WITHIN ROUTED PERSONNELS' and makes it Not Viewable on All Transactions " value="1" <?=set_select('tag_doc_type', 1)?>>  Confidential</option>
													<option title="" value="2" <?=set_select('tag_doc_type', 2)?>>  For Compliance</option>
												</select>
											</div>
											<?php
										}
										?>
										<div id="for_compliance" style="display: none">
											<div class="form-group">
												<label>Due Date:</label>
												<input class="form-control" type="date" name="due_date" />
											</div>
											<div class="form-group">
												<label>Compliance Directed For:</label>
											</div>
											<div class="col-md-12" >
												<div class="form-group" >
													<label>Region:</label>
													<select id="complianceRegionSelect" class="form-control">
														<?php
														foreach ($region as $key => $value) {
															echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Division:</label>
													<select id="complianceDivisionSelect" class="form-control">
														<option></option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="qr-code">
												<?php
												echo "<label>Please copy and paste QR Code into the document to be routed:</label><br>";
												echo "<input type='hidden' class='form-control' name='qr_code' value='".$qr_code_image."' readonly>";
												echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fiis.emb.gov.ph/verify?token=".$qr_code_image."%2F&choe=UTF-8' style='width:150px;'>";
												?>
											</div>
										</div>
									</div>

									<div id="company-selection-group" class="col-md-4"> <br>
										<div class="form-group">
											<label>Company:</label>
											<button id="add_company" type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#dmsAddCompanyModal">-> Click to Add/Change Company <-</button>
										</div>
										<input type="hidden" name="company" value="<?=$company_data[0]['token']?>" readonly/>
										<div class="form-group">
											<label>Company EMB ID:</label>
											<input class="form-control" id="company_embid" value="<?=$company_data[0]['emb_id']?>" readonly />
										</div>
										<div class="form-group">
											<label>Company Name:</label>
											<textarea class="form-control" id="company_name" readonly><?=$company_data[0]['company_name']?></textarea>
										</div>
										<div class="form-group">
											<label>Establishment Name:</label>
											<textarea class="form-control" id="establishment_name" readonly><?=$company_data[0]['establishment_name']?></textarea>
										</div>
										<div class="form-group">
											<label>Address:</label>
											<textarea class="form-control" id="company_address" readonly><?php echo ucwords(trim($company_data[0]['house_no'].' '.$company_data[0]['street'].' '.$company_data[0]['barangay_name'].', '.$company_data[0]['city_name'].' '.$company_data[0]['province_name'])); ?></textarea>
										</div>
										<div class="form-group">
											<label>Project Type:</label>
											<textarea class="form-control" id="project_type" readonly><?php echo $company_data[0]['project_name']; ?></textarea>
										</div>
									</div>

									<div id="sendinfo-attachments-group" class="col-md-4"> <br>
										<div class="form-group">
											<label>Action:</label>
											<input type="hidden" name="action" value="Filed / Close." />
											<input class="form-control" value="M - Filed / Close." disabled />
										</div>
										<div class="form-group">
											<label>Remarks:</label>
											<textarea class="form-control" name="remarks"></textarea>
										</div>
										<div class="form-group">
											<label>File Location:</label>
											<input class="form-control" name="records_location" value="<?php echo (!empty($trans_data[0]['records_location'])) ? trim($trans_data[0]['records_location']) : set_value('records_location'); ?>" />
										</div>
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
												<table class="table table-sm table-striped" style="vertical-align: middle;">
													<?php
													foreach ($attachment_list as $key => $attachment) {
														$att_name = str_replace(' ', '_', trim($attachment['file_name']));
														?>
														<tr>
															<td>
																<?php
																echo "<a title='".$att_name."' href='".base_url('uploads/dms/'.date('Y').'/'.$user['region'].'/'.$attachment['trans_no'].'/'.$attachment['token'].'.'.pathinfo($att_name, PATHINFO_EXTENSION))."' target='_blank'>".$att_name."</a>";
																?>
															</td>
															<td style="display: none">
																<?php echo $attachment['token']; ?>
															</td>
															<?php if($attachment['route_order'] == $trans_data[0]['route_order']+1) { ?>
																<td style="text-align: center">
																	<!-- <button type="button" class="btn btn-outline-danger btn-sm trans-delete-uploaded">
																	<i class="fas fa-trash"></i>
																</button> -->
															</td>
														<?php } ?>
													</tr>
												<?php } ?>
											</table>
									</div>

								</div>

							</div>
						</div>

					</div>
				</div>

			</div>
			<!-- Card Footer -->
			<div class="card-footer">
				<div class=" float-right">
					<button id="process_transaction_button" type="submit" class="btn btn-success btn-icon-split"><span class="text"> <i class="far fa-check-square"></i> Migrate</span></button> <br /><br />
				</div>
			</div>
		<?=form_close();?>

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
			console.log("Selectize event: Change on sys_main");
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
			console.log("Selectize event: Change on trans_status");
		}
	});

	$("input[name='asgnto_multiple']").change(function() {
		if(this.checked) {
			$("#assignto-multiple-group").show();
			$("#assignto-group").hide();
			$("#assignto-refunc-group").hide();
		}
		else {
			$("#assignto-multiple-group").hide();
			$("#assignto-group").show();
			$("#assignto-refunc-group").show();
		}
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

	$('button#add_company').click(function(){
		($("#dmsTipsModal").data('bs.modal') || {})._isShown;	// Bootstrap 4
		$.ajax({
			url: '/embis/dms/data/ajax/add_company_modal1',
			type: 'POST',
			data: {'user_region': '<?=$user['region']?>'},
			success: function(result) {
				$('div#dmsAddCompanyModal div.modal-body').html(result);
			}
		});
	});

	if($('select[name="tag_doc_type"]').is(":visible")) {
		let thisData = $('select[name="tag_doc_type"]');
		let complianceData = $('#for_compliance');
		thisData.change(function(){
			if(thisData.val() == '2') {
				complianceData.show();
				runCompliance();
			}
			else {
				complianceData.hide();
			}
		});
	}

	function runCompliance()
	{
		if($("#complianceRegionSelect").is(':visible')) {
			let thisData = $("#complianceRegionSelect");
			let divData = $("#complianceDivisionSelect");
			thisData.change( function() {

				thisData.find('#asgnto-spinner').hide();
				thisData.find('div#assignto-group select').prop('disabled', true);
				send_group.find('span#assignto-refunc-group button').prop('disabled', true);
				$.ajax({
					url: '/embis/dms/data/ajax/get_division',
					method: 'POST',
					data: { 'selected': divData.val(), 'region': thisData.val() },
					dataType: 'html',
					success: function(response) {
						divData.html(response);
					},
					error: function(response) {
						divData.empty().html("<option value=''>-No Data-</option>");
						console.log("ERROR");
					},
				});
			}).change();
		};
	}

	//Dropzone
	// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
	var previewNode = document.querySelector("#att_template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	var myDropzone = new Dropzone("div.erattdropzone", { // Make the whole body a dropzone
		url: "<?php echo base_url('Dms/migrate/file_upload'); ?>", // Set the url
		params: {
			trans_no: "<?php echo $trans_data[0]['trans_no']; ?>",
			route_order: "<?php echo $trans_data[0]['route_order']; ?>",
			region: "<?php echo $trans_data[0]['region']; ?>",
		},
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

	// File Delete
	// $('.trans-delete-uploaded').on('click', function(){
	// 	var file_name = $.trim($(this).closest("tr").find("td:first").text());
	// 	var file_token = $.trim($(this).closest("tr").find("td:eq(1)").text());
	// 	var request = $.ajax({
	// 		url: Dms.base_url + 'Dms/fileDelete',
	// 		method: 'POST',
	// 		data: {
	// 			trans_session: "<?php echo $trans_session; ?>",
	// 			main_route_order: "<?php echo $trans_data[0]['main_route_order']; ?>",
	// 			route_order: "<?php echo $trans_data[0]['route_order']; ?>",
	// 			region: "<?php echo $trans_data[0]['region']; ?>",
	// 			file_name : file_name,
	// 			file_token : file_token,
	// 		},
	// 		success: function() {
	// 			console.log('success out');
	// 		}
	// 	});
	// 	$(this).closest("tr").hide();
	// });
});

</script>
