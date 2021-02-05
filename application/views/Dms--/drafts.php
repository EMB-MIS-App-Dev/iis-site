
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file"></i> DRAFT TRANSACTIONS</h6>

							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a>

						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="draft_table" class="table table-striped " style="width: 100%" cellspacing="0">
											<thead>
												<tr style="border: 1px white">
													<th>no</th>
													<th> IIS No. </th>
													<th>Company Name</th>
													<th>EMB ID</th>
													<th>Subject</th>
													<th>Transaction Type</th>
													<th>Status</th>
													<th>Action Taken</th>
													<!-- <th>Sender</th> -->
													<th>Assigned</th>
													<th>Remarks</th>
													<!-- <th>Region</th> -->
													<th style="width: 130px">Action</th>
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

			    var table = $('#draft_table').DataTable({
							order: [[0, "desc"]],
			        serverSide: true,
			        processing: true,
			        responsive: true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Datatables/drafts'); ?>",
			            "type": 'POST',
									"data": {'user_token': '<?php echo $user_token; ?>', 'user_region': '<?php echo $user_region; ?>' },
			        },
			        columns: [
								{ "data": "trans_no", "searchable": false, "visible": false},
								{ "data": "token" },
								{ "data": "company_name" },
								{ "data": "emb_id"},
								{ "data": "subject"},
								{ "data": "type_description"},
								{ "data": "status_description"},
								{ "data": "action_taken"},
								// { "data": "sender_id"},
								{ "data": "receiver_name",
									"render": function(data, type, row, meta) {
										return data.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
									}
								},
								{ "data": "remarks"},
								// { "data": "region_name"},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										data = "<button type='button' id='updatebtn' class='btn btn-warning btn-sm waves-effect waves-light'>Update</button>&nbsp;";

										return data;
									}
								}
			        ]
			    });

			    $('#draft_table tbody').on( 'click', '#updatebtn', function () {
		        var data = table.row( $(this).parents('tr') ).data();
						$.ajax({
				       url: Dms.base_url + 'Dms/set_trans_session',
				       method: 'POST',
				       data: { trans_no : data['trans_no'] },
							 success: function() {
								 window.location.href = Dms.base_url + 'Dms/update_transaction';
							 }
				    });
			    } );

			} );

		</script>
