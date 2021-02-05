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

	<div class="container-fluid">
		<div class="row">
			<!-- DATATABLES Card -->
			<div class="col-xl-12 col-lg-12">
				<div class="trans-layout card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

						<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> PROCESS TRANSACTION</h6>

					</div>
					<?php $zxc = !empty($main_multi_cntr)?$main_multi_cntr:1; echo form_open_multipart('dms', array('id' => 'dms_route_form')); ?>
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

													<div id="sendinfo-attachments-group" class="col-md-4"> <br>
                            <div id="asgnprsnl_div" class="form-group">
															<div class="row">
																<div class="custom-control mr-sm-3">
																	<label>Assigned to:</label>
																	<div id="asgnto-spinner" class="spinner-border spinner-border-sm" role="status" style="display: none"> <span class="sr-only">Loading...</span> </div>
																	<div class="custom-control custom-checkbox mr-sm-2">
																		<input type="checkbox" class="custom-control-input" id="asgntoMultiple" name="asgnto_multiple" value="multiple">
																		<label class="custom-control-label" for="asgntoMultiple">Multiple</label>
																	</div>
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

													</div>

												</div>
											</div> <!-- Tab- add-transaction End -->

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

		var region_val = '';
		if(region_slct.is(':visible')) {
			region_val = region_slct.val();

			region_slct.change(function() {
				$('#asgnto-spinner').show();
				send_group.find('div#assignto-group select').prop('disabled', true);
				region_val = $(this).val();
				$.ajax({
						url: '/embis/dms/data/ajax/get_division',
						method: 'POST',
						data: { 'selected': division_slct.data('selected'), 'region': region_val },
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
			var division_val = $(this).val();
			$.ajax({
					url: '/embis/dms/data/ajax/get_section',
					method: 'POST',
					data: { 'selected': section_slct.data('selected'), 'division': division_val, 'region': region_val },
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
			var section_val = $(this).val();
			var division_val = division_slct.val();
			$.ajax({
					url: '/embis/dms/data/ajax/get_personnel',
					method: 'POST',
					data: { 'selected': receiver_slct.data('selected'), 'section': section_val, 'division': division_val, 'region': region_val },
					dataType: 'html',
					success: function(response) {
						receiver_slct.html(response);
						$('#asgnto-spinner').hide();
						send_group.find('div#assignto-group select').prop('disabled', false);
					},
					error: function(response) {
						receiver_slct.empty().html("<option value=''>-No Data-</option>").change();
						$('#asgnto-spinner').hide();
						send_group.find('div#assignto-group select').prop('disabled', false);
						console.log("ERROR");
					},
			});
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
