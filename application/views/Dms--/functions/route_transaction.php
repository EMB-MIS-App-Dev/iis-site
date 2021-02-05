
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> PROCESS TRANSACTION</h6>

						</div>
<style>
	textarea {
		min-height: 100px;
	}
</style>
						<form id="input_transaction_form" action="" method="POST" enctype="multipart/form-data">
						<!-- Card Body -->
							<div class="card-body">

										<div class="table-responsive">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Add</a>
													<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
												</div>
											</nav>
												<input class="form-control" type="hidden" name="trans_no" value="<?php echo $trans_no; ?>" readonly />
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab" style="min-height: 650px">
															<div class="row">
																<div class="col-md-4"><br />
																	<div class="form-group">
																		<label>Transaction No.:</label>
																		<input class="form-control" value="<?php echo $trans_no; ?>" readonly />
																	</div>
																	<div class="form-group">
																		<label>System:</label>
																		<select id="sys_main" class="form-control" onchange="Dms.system_select(this.value);" name="system" tabindex="1" required>
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
																		<select class="form-control" id="type" name="type" required>
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
																		<label>Subject Name:</label>
																		<textarea class="form-control" id="subject" name="subject" required><?php echo trim($trans_data[0]['subject']); ?></textarea>
																	</div>
																	<div class="form-group">
																		<label>Transaction Status:</label>
																		<select class="form-control" id="trans_status" name="status" required>
																			<option selected value="">--</option>
																			<?php
																				foreach ($status as $key => $value) {
																					echo '<option value="'.$value['id'].'">'.($key+1).' - '.$value['name'].'</option>';
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
																		<select id="company_list" class="form-control" name="company" required>
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
																		<textarea class="form-control" id="company_address" readonly></textarea>
																	</div>
																</div>

																<div class="col-md-4"> <br>
																	<div class="form-group">
																		<label>Assigned to:</label>
																		<!-- <select class="form-control" name="division" onchange="Dms.select_division(this.value);"> -->
																			<!-- <option selected value=""></option> -->
																			<?php
																				// foreach ($division as $key => $value) {
																				// 	echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
																				// }
																			?>
																		<!-- </select> <br />

																		<select id="section_id" class="form-control" name="section" onchange="Dms.select_section(this.value);">
																			<option selected value=""></option>
																		</select> <br /> -->
																		<select class="form-control" name="receiver" required>
																			<option selected value="">--</option>
																			<?php
																				foreach ($trans_cred as $value) {
																					echo '<option value="'.$value['token'].'">'.ucwords($value['fname'].' '.$value['sname'].' '.$value['suffix']).'</option>';
																				}
																			?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Action:</label>
																		<select class="form-control" name="action" required>
																			<option selected value="">--</option>
																			<?php
																				foreach ($action as $value) {
																					echo '<option value="'.$value['text'].'">'.$value['code'].' - '.$value['text'].'</option>';
																				}
																			?>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Remarks:</label>
																		<textarea class="form-control" name="remarks"></textarea>
																	</div>
																	<div class="form-group">
																		<label>Attachment:</label>
																		<input class="form-control" name="attachment[]" type="file" multiple />
																	</div>
																</div>

															</div>
														</div>

														<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab"  style="min-height: 650px">
															<div class="row">
																<div class="col-md-12" style="text-align: center">
																	<br /><h3>TRANSACTION HISTORY</h4><br />
																	<table class="table table-striped" style="zoom: 85%">
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
																						if($value['route_order'] == $attachment_view[0]['route_order'])
																						{
																							if(count($attachment_view) > 1)
																							{
																								$att = "<div class='dropdown'><button class='btn btn-info btn-sm waves-effect waves-light' type='button' data-toggle='dropdown'>View <i class='far fa-caret-square-down'></i></button>
				                                        <ul class='dropdown-menu'>";
				                                            $filecount = 1;
				                                            while(count($value) != $filecount)
				                                            {
				                                              $att .= "<li><a href='".base_url('uploads/dms/'.date('Y').'/CO/'.$trans_no.'/'.$attachment_view[$key]['file_name'])."' target='_blank'>File</a></li>";
				                                              $filecount++;
				                                            }
				                                        $att .= "</ul></div>";
																							}
																							else {
																								$att = "<a href='".base_url('uploads/dms/'.date('Y').'/CO/'.$trans_no.'/'.$attachment_view[0]['file_name'])."' target='_blank'><button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light'>View</button></a>";
																							}
																						}
																						else {
																							$att = '--';
																						}

																						if($value['receiver_id'] != '') {
																							echo "<tr>
																								<td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
																								<td>".$value['action_taken']."</td>
																								<td>".$value['sender_name']."</td>
																								<td>".$value['status_description']."</td>
																								<td>".$value['receiver_name']."</td>
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

												</div>
										</div>

							</div>
						<!-- Card Body -->
						<div class="card-footer">
							 <!-- onclick="Dms.process_transaction();" -->
							<button id="process_transaction_button" type="submit" class="btn btn-success btn-icon-split float-right" formaction="<?php echo base_url('Dms/Dms/process_transaction'); ?>"><span class="text"><i class="fas fa-share-square"></i> Process</span></button><br /><br />
						</div>

					</form>

  <script type="text/javascript">

	  $(document).ready(function() {
  	$('#sys_main').selectize({
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change");
			}
		});

  	$('#trans_status').selectize({
			onChange: function(value, isOnInitialize) {
				console.log("Selectize event: Change");
			}
		});
	});

  </script>
