<style>
	.set_error {
		font-size: 13px;
		color: red;
	}
	table tr, td{
		padding: -10px !important;
	}
	.tttable thead {
	  display:none;
	}
</style>

<div class="container-fluid">
	<div class="row">

		<!-- DATATABLES Card -->
		<div class="col-xl-12 col-lg-12">
			<div class="trans-layout card shadow mb-4">

						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> DMS Options</h6>

						</div>

						<!-- Card Body -->
							<div class="card-body">

										<div class="data-div ">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-dms-options" data-toggle="tab" href="#dms-options" role="tab" aria-controls="dms-options" aria-selected="true">Options</a>
													<a class="nav-item nav-link" id="nav-dms-manage" data-toggle="tab" href="#dms-manage" role="tab" aria-controls="dms-manage" aria-selected="false">Manage</a>
												</div>
											</nav>
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="dms-options" role="tabpanel" aria-labelledby="dms-options-tab" >

															<?php echo form_open_multipart('dms/settings/options'); ?>
																<div class="row">

																	<div class="col-md-12">
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
																							<option value="draft">Drafts Tab (Default)</option>
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
																							<option value="outbox">Outbox Tab (Default)</option>
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
																							<option value="outbox">Outbox Tab (Default)</option>
		                                          <option <?php echo $draft_prc['all_transactions']; ?> value="all_transactions">All Transactions Tab</option>
		                                          <option <?php echo $draft_prc['inbox']; ?> value="inbox">Inbox Tab</option>
		                                          <option <?php echo $draft_prc['draft']; ?> value="draft">Drafts Tab</option>
		                                        </select>
		    																	</div>

		                                    </div>
		                                  </div>

		                                </div>
																	</div>
																	<hr />
																	<div class="col-md-12 card-footer">
																		<button type="submit" class="btn btn-success btn-icon-split float-right" name="process_transaction"><span class="text"><i class="fas fa-file-o"></i> Save</span></button><br /><br />
																	</div>
																</div>

															</form>
														</div>

														<div class="tab-pane fade show" id="dms-manage" role="tabpanel" aria-labelledby="dms-manage-tab">
															<div class="row">

																<div class="col-md-6"><br />
                                  <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                      <h6 class="m-0 font-weight-bold text-primary">
																				<span>Systems</span>
																				<a class="float-right" data-target=".systemModal" data-toggle="modal" title="Add DMS System"><i class="fas fa-plus"></i></a>
																			</h6>
                                    </div>
                                    <div class="card-body">

																			<div class="table-responsive" style="height: 450px">
																				<table id="systems_table" class="tttable table table-hover" width="100%" cellspacing="0" style="max-height: 400px">
																					<thead>
																						<tr>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																						</tr>
																					</thead>
																				</table>
    																	</div>

                                    </div>
                                  </div>
                                </div>

																<div class="col-md-6"><br />
                                  <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                      <h6 class="m-0 font-weight-bold text-primary">
																				<span>Sub-Systems</span>
																				<a class="float-right" data-target=".subSystemModal" data-toggle="modal" title="Add DMS Sub-System"><i class="fas fa-plus"></i></a>
																			</h6>

                                    </div>
                                    <div class="card-body">

																			<div class="table-responsive" style="height: 450px">
																				<table id="sub_systems_table" class="tttable table table-hover" width="100%" cellspacing="0">
																					<thead>
																						<tr>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																							<th></th>
																						</tr>
																					</thead>
																				</table>
																			</div>

                                    </div>
                                  </div>
                                </div>

																<div class="col-md-12"><br />
                                  <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                      <h6 class="m-0 font-weight-bold text-primary">Sub-Types</h6>
                                    </div>
                                    <div class="card-body">

																			<div class="table-responsive" style="height: 450px">
																				<table id="sub_type_table" class="table table-hover" width="100%" cellspacing="0">
																					<thead>
																						<tr>
																							<th>id</th>
																							<th>Name</th>
																							<th>Title</th>
																							<th>header</th>
																							<th>sysid</th>
																							<th>ssysid</th>
																							<th>subcat1</th>
																							<th></th>
																						</tr>
																					</thead>
																				</table>
																			</div>

                                    </div>
                                  </div>
                                </div>
															</div>
														</div>

												</div>
										</div>

							</div>

        </div>
      </div>
    </div>
  </div>

</div> <!-- Header Wrapper End -->


<script>

	$(document).ready(function() {

	    var table = $('#systems_table').DataTable({
					dom: 'f',
    			paging:   false,
					info: false,
	        serverSide: true,
	        processing: true,
	        responsive: true,
	        ajax: {
	            "url": "<?php echo base_url('Dms/Data_Tables/system'); ?>",
	            "type": 'POST',
	        },
					columnDefs: [
						{ className:"id","targets":[1] },
					],
	        columns: [
						{ "data": "id" }, //
						{ "data": "system_code" },
						{ "data": "name", "sortable": false},
						{ "data": "system_order", "searchable": false, "visible": false},
						{
							"sortable": false,
							"render": function(data, type, row, meta) {
								data = '<a href="#" class="btn btn-sm btn-hover btn-default" title="Edit"><i class="far fa-edit"></i></a>&nbsp;<a id="show_subsys" class="btn btn-sm btn-hover btn-default" title="Show Sub-System"><i class="fas fa-angle-double-right"></i></a>';
								return data;
							}
						}
	        ]
	    });

	    $('#systems_table tbody').on( 'click', '#show_subsys', function () {
	        var data = table.row( $(this).parents('tr') ).data();
					sub_sys_tableData.sysid = data['id'];
					sub_sys_table.draw();
	    } );

			var sub_sys_tableData = {
				'sysid': '',
			};

			var sub_sys_table = $('#sub_systems_table').DataTable({
					dom: 'f',
					order: [[4, "asc"], [5, "asc"], [3, "desc"], [0, "asc"]],
    			paging: false,
					info: false,
	        serverSide: true,
	        processing: true,
	        responsive: true,
	        ajax: {
	            "url": "<?php echo base_url('Dms/Data_Tables/sub_system'); ?>",
	            "type": 'POST',
							"data": function ( d ) {
												return  $.extend(d, sub_sys_tableData);
											},
	        },
	        columns: [
						{ "data": "id"},
						{ "data": "name"},
						{
							"data": "header",
							"render": function(data, type, row, meta) {
								data = (data == 1) ? '<span title="This Sub-System is a Header">H</span>' : '';
								return data;
							}
						},
						{ "data": "header", "searchable": false, "visible": false },
						{ "data": "sysid", "searchable": false, "visible": false},
						{ "data": "ssysid", "searchable": false, "visible": false},
						{ "data": "sys_show", "searchable": false, "visible": false},
						{
							"data": null,
							"render": function(data, type, row, meta) {
								data = '<a href="#" class="btn btn-sm btn-hover btn-default" title="Edit"><i class="far fa-edit"></i></a>&nbsp;<a id="show_subtype" class="btn btn-sm btn-hover btn-default" title="Show Sub-System Types"><i class="fas fa-angle-double-right"></i></a>';
								return data;
							}
						}
	        ]
	    });

	    $('#sub_systems_table tbody').on( 'click', '#show_subtype', function () {
	        var data = sub_sys_table.row( $(this).parents('tr') ).data();
					sub_type_tableData.ssysid = data['id'];
					sub_type_table.draw();
	    } );

			var sub_type_tableData = {
				'ssysid': '',
			};

			var sub_type_table = $('#sub_type_table').DataTable({
					dom: 'f',
    			paging:   false,
					info: false,
	        serverSide: true,
	        processing: true,
	        responsive: true,
	        ajax: {
	            "url": "<?php echo base_url('Dms/Data_Tables/subsys_types'); ?>",
	            "type": 'POST',
							"data": function ( d ) {
												return  $.extend(d, sub_type_tableData);
											},
	        },
	        columns: [
						{ "data": "id", "searchable": false, "visible": false},
						{ "data": "dsc", "sortable": false},
						{ "data": "title", "sortable": false},
						{ "data": "header", "searchable": false, "visible": false},
						{ "data": "sysid", "searchable": false, "visible": false},
						{ "data": "ssysid", "searchable": false, "visible": false},
						{ "data": "subcat1", "searchable": false, "visible": false},
						{
							"sortable": false,
							"render": function(data, type, row, meta) {
								data = '<a href="#" class="btn btn-sm btn-hover btn-default" title="Edit"><i class="far fa-edit"></i></a>&nbsp;<a href="#" class="btn btn-sm btn-hover btn-default" title="Show Sub-System"><i class="fas fa-angle-double-right"></i></a>';
								return data;
							}
						}
	        ]
	    });

	} );

</script>
