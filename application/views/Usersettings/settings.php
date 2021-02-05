<style>
	.set_error {
		font-size: 13px;
		color: red;
	}
</style>

<div class="container-fluid">
	<div class="row">

		<!-- DATATABLES Card -->
		<div class="col-xl-12 col-lg-12">
			<div class="trans-layout card shadow mb-4">

						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> User System Options</h6>

						</div>

						<?php echo form_open_multipart('Usersettings/Usersettings/set_settings'); ?>
						<!-- Card Body -->
							<div class="card-body">

										<div class="data-div ">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#dms-options" role="tab" aria-controls="dms-options" aria-selected="true">All</a>
													<!-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a> -->
												</div>
											</nav>
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="dms-options" role="tabpanel" aria-labelledby="dms-options-tab" style="min-height: 500px">
															<div class="row">

																<div class="col-md-4"><br />

                                  <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                      <h6 class="m-0 font-weight-bold text-primary">System Settings</h6>
                                    </div>
                                    <div class="card-body">

                                      <div class="form-group">
    																		<label>Theme :</label>
																					<?php
																						$dark = '';
																						$dark2 = '';
																						$halloween = '';
																						switch ($acc_options[0]['sys_theme']) {
																							case 'dark': $dark = 'selected'; break;
																							case 'dark2': $dark2 = 'selected'; break;
																							case 'halloween': $halloween = 'selected'; break;
																							case 'christmas': $christmas = 'selected'; break;
																							default: break;
																						}
																					?>
                                        <select class="form-control" name="sys_theme">
																					<option value="">Light (Default)</option>
                                          <option <?php echo $dark; ?> value="dark">Dark</option>
                                          <option <?php echo $dark2; ?> value="dark2">Dark v2</option>
                                          <option <?php echo $halloween; ?> value="halloween">Halloween</option>
                                          <option <?php echo $christmas; ?> value="christmas">Christmas</option>
                                        </select>
    																	</div>

                                    </div>
                                  </div>

                                </div>
																<div class="col-md-4"><br />

                                  <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                      <h6 class="m-0 font-weight-bold text-primary">DMS Redirections</h6>
                                    </div>
                                    <div class="card-body">

                                      <div class="form-group">
    																		<label>Save As Draft :</label>
																					<?php
																						$save_draft['outbox'] = '';
																						$save_draft['all_transactions'] = '';
																						$save_draft['inbox'] = '';
																						switch ($acc_options[0]['save_draft']) {
																							case 'outbox': $save_draft['outbox'] = 'selected'; break;
																							case 'all_transactions': $save_draft['all_transactions'] = 'selected'; break;
																							case 'inbox': $save_draft['inbox'] = 'selected'; break;
																							default: break;
																						}
																					?>
                                        <select class="form-control" name="save_draft">
																					<option value="">Drafts Tab (Default)</option>
                                          <option <?php echo $save_draft['outbox']; ?> value="outbox">Outbox Tab</option>
                                          <option <?php echo $save_draft['all_transactions']; ?> value="all_transactions">All Transactions Tab</option>
                                          <option <?php echo $save_draft['inbox']; ?> value="inbox">Inbox Tab</option>
                                        </select>
    																	</div>

                                      <div class="form-group">
    																		<label>Inbox Tab ( Process / Route ) :</label>
																					<?php
																						$inbox_prc['outbox'] = '';
																						$inbox_prc['all_transactions'] = '';
																						$inbox_prc['inbox'] = '';
																						switch ($acc_options[0]['inbox_prc']) {
																							case 'outbox': $inbox_prc['outbox'] = 'selected'; break;
																							case 'all_transactions': $inbox_prc['all_transactions'] = 'selected'; break;
																							case 'inbox': $inbox_prc['inbox'] = 'selected'; break;
																							default: break;
																						}
																					?>
                                        <select class="form-control" name="inbox_prc">
																					<option value="">Outbox Tab (Default)</option>
                                          <option <?php echo $inbox_prc['all_transactions']; ?> value="all_transactions">All Transactions Tab</option>
                                          <option <?php echo $inbox_prc['inbox']; ?> value="inbox">Inbox Tab</option>
                                          <option <?php echo $inbox_prc['draft']; ?> value="draft">Drafts Tab</option>
                                        </select>
    																	</div>

                                      <div class="form-group">
    																		<label>Drafts Tab ( Process / Route ) : </label>
																					<?php
																						$draft_prc['outbox'] = '';
																						$draft_prc['all_transactions'] = '';
																						$draft_prc['inbox'] = '';
																						switch ($acc_options[0]['draft_prc']) {
																							case 'outbox': $draft_prc['outbox'] = 'selected'; break;
																							case 'all_transactions': $draft_prc['all_transactions'] = 'selected'; break;
																							case 'inbox': $draft_prc['inbox'] = 'selected'; break;
																							default: break;
																						}
																					?>
                                        <select class="form-control" name="draft_prc">
																					<option value="">Outbox Tab (Default)</option>
                                          <option <?php echo $draft_prc['all_transactions']; ?> value="all_transactions">All Transactions Tab</option>
                                          <option <?php echo $draft_prc['inbox']; ?> value="inbox">Inbox Tab</option>
                                          <option <?php echo $draft_prc['draft']; ?> value="draft">Drafts Tab</option>
                                        </select>
    																	</div>

                                    </div>
                                  </div>

                                </div>
															</div>
														</div>

														<!-- <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab"  style="min-height: 650px">
															<div class="row">
															</div>
														</div> -->

												</div>
										</div>

							</div>
						<!-- Card Body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-success btn-icon-split float-right" name="process_transaction"><span class="text"><i class="fas fa-file-o"></i> Save</span></button><br /><br />
						</div>

					</form>

        </div>
      </div>
    </div>
  </div>

</div> <!-- Header Wrapper End -->
