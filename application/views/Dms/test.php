
		<div class="container-fluid">
			<div class="row">
				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->

						<?php // echo $user_token;?>
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> INBOX TRANSACTIONS</h6>
							<!--  -->
							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction </a>

						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="inbox_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
												<tr>
													<th>tkey</th>
													<th>trans_no</th>
													<th>trans_no</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>

							</div>
						<!-- Card Body -->

					</div>

				</div>
			</div>
		</div>

	</div>

	<script>
		$(document).ready(function() {

		    var table = $('#inbox_table').DataTable({
						order: [[0, "desc"]],
						language: {
					    infoFiltered: "",
							processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
					  },
		        serverSide: true,
		        processing: true,
		        responsive: true,
		        deferRender: true,
						paging: true,
						// "scrollY": 500,
						"scrollX": true,
		        ajax: {
		            "url": "<?php echo base_url('Dms/Table_Test/data_test'); ?>",
		            "type": 'POST',
		        },
		        columns: [
							{ "data": "appli_no" },
							{ "data": "test" },
							{
								"sortable": false,
								"render": function(data, type, row, meta) {
									data = "<button type='button' id='rcvbtn' class='inboxrcv-btn btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal' data-target='#receive'>Receive</button>&nbsp;";
									return data;
								}
							}
		        ]
		    });


		} );
		</script>
