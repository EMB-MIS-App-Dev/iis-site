						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-edit"> </i> EDIT TRANSACTION</h6>

						</div>
<style>
	textarea {
		min-height: 100px;
	}
</style>
						<form id="input_transaction_form" action="" method="POST" enctype="multipart/form-data">
						<!-- Card Body -->
							<div class="card-body">

										<div class="table-responsive" style="min-height: 800px !important">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Add</a>
													<!-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#sweet-report" role="tab" aria-controls="sweet-report" aria-selected="false">Sweet</a>
													<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#pco-accreditation" role="tab" aria-controls="pco-accreditation" aria-selected="false">PCO</a> -->
												</div>
											</nav>
												<input class="form-control" type="hidden" name="trans_no" value="<?php echo $trans_no; ?>" readonly />
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab">
															<div class="row">
																<div class="col-md-4"><br />
																	<div class="form-group">
																		<label>Transaction No.:</label>
																		<input class="form-control" value="<?php echo $trans_no; ?>" readonly />
																	</div>
																	<div class="form-group">
																		<label>System:</label>
																		<select id="sys_main" class="form-control" onchange="Dms.system_select(this.value);" name="system" >
																			<option selected="" value="">--</option>
																			<?php
																				foreach ($system as $value) {
																					if($value['id']==$trans_data[0]['system'])
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
																	<div class="form-group">
																		<label>Sub-System:</label>
																		<select class="form-control" id="type" name="type" onchange="Dms.additional_inputs(this.value)">
																			<option selected="" value="">--</option>
																			<?php
																				foreach ($trans_type as $value) {
																					if($value['id']==$trans_data[0]['type'])
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
																		</div>
																	<!-- END OF DIV FOR ADDITIONAL SELECTIONS -->
																	<div class="form-group">
																		<label>Subject:</label>
																		<textarea class="form-control" id="subject" name="subject"><?php echo trim($trans_data[0]['subject']); ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Transaction Status:</label>
																		<select class="form-control" id="trans_status" name="status">
																			<option selected value="">--</option>
																			<?php
																				foreach ($status as $key => $value) {
																					if($value['id']==$trans_data[0]['status'])
																					{
																						echo '<option selected value="'.$value['id'].'">'.($key+1).' - '.$value['name'].'</option>';
																					}
																					else
																					{
																						echo '<option value="'.$value['id'].'">'.($key+1).' - '.$value['name'].'</option>';
																					}
																				}
																			?>
																		</select>
																	</div>
																</div>

																<div class="col-md-4"> <br>

																	<div class="form-group">
																		<label>Company EMB ID:</label>
																		<input class="form-control" id="company_embid" value="<?php echo $trans_data[0]['emb_id']; ?>" readonly />
																	</div>
																	<div class="form-group">
																		<label>Company:</label>
																		<select id="company_list" class="form-control" name="company" onchange="Dms.company_details(this.value);">
																			<option selected value="">--</option>
																			<?php
																				foreach ($company_list as $value) {
																					if($value['company_id']==$trans_data[0]['company_id'])
																					{
																						echo '<option selected value="'.$value['company_id'].'">'.$value['company_name'].'</option>';
																					}
																					else
																					{
																						echo '<option value="'.$value['company_id'].'">'.$value['company_name'].'</option>';
																					}
																				}
																			?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Company Address:</label>
																		<textarea class="form-control" id="company_address" readonly><?php echo ucwords(trim($company_details[0]['house_no'].' '.$company_details[0]['street'].' '.$company_details[0]['barangay_name'].', '.$company_details[0]['city_name'].' '.$company_details[0]['province_name'])); ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Project Type:</label>
																		<textarea class="form-control" id="project_type" readonly><?php echo $company_details[0]['project_name']; ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Project Category:</label>
																		<textarea class="form-control" id="project_category" readonly><?php echo ''; ?></textarea>
																	</div>

																</div>

																<div class="col-md-4"> <br>
																	<div class="form-group">
																		<label>Assigned to:</label>
																		<select class="form-control" name="division" onchange="Dms.select_division(this.value);">
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

																		<select id="section_id" class="form-control" name="section" onchange="Dms.select_section(this.value);">
																			<option selected value="">--</option>
																			<?php
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

																		<select id="personnel_id" class="form-control" name="receiver" >
																			<option selected value="">--</option>
																			<?php
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
																			?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Action:</label>
																		<select class="form-control" name="action" >
																			<option selected value="">--</option>
																		<?php
																			foreach ($action as $value) {
																				if($value['text']==$trans_data[0]['action_taken'])
																				{
																					echo '<option selected value="'.$value['text'].'">'.$value['code'].' - '.$value['text'].'</option>';
																				}
																				else
																				{
																					echo '<option value="'.$value['text'].'">'.$value['code'].' - '.$value['text'].'</option>';
																				}
																			}
																		?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Remarks:</label>
																		<textarea class="form-control" name="remarks"><?php echo trim($trans_data[0]['remarks']); ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Attachment:</label>
																		<input class="form-control" type="file" name="attachment[]" multiple />
																	</div>
																</div>

															</div>
														</div>
														<div class="tab-pane fade" id="sweet-report" role="tabpanel" aria-labelledby="sweet-report-tab"> - UNDER DEV. - </div>
														<div class="tab-pane fade" id="pco-accreditation" role="tabpanel" aria-labelledby="pco-accreditation-tab"> - UNDER DEV. - .</div>

												</div>

												<div class="col-xl-12 mb-3">

												</div>

										</div>

							</div>
						<!-- Card Body -->
						<div class="card-footer">
							<div class=" float-right">
<!-- onclick="Dms.save_draft_data();" -->
								<button id="save_draft_button" type="submit" class="btn btn-success btn-icon-split " formaction="<?php echo base_url('Dms/Dms/save_draft_data'); ?>"><span class="text"> <i class="far fa-save"></i> Save as Draft</span></button>&nbsp;&nbsp;
								<!-- onclick="Dms.process_transaction();" -->
								<button id="process_transaction_button" type="submit" class="btn btn-success btn-icon-split" formaction="<?php echo base_url('Dms/Dms/process_transaction'); ?>"><span class="text"> <i class="fas fa-share-square"></i> Process</span></button> <br /><br />
							</div>
						</div>
					</form>

  <script type="text/javascript">

	  $(document).ready(function() {
			// $('#save_draft_button').on('submit', function (e){
			// 	e.preventDefault();
			// })
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
				onChange: function(value, isOnInitialize) {
					console.log("Selectize event: Change on trans_status");
				}
			});
		});

  </script>
