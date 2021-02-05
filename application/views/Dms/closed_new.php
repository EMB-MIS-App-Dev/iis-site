
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> FILED/CLOSED TRANSACTIONS</h6>


							<span class="float-right">
								<button data-toggle="modal" data-target="#dmsTipsModal" class="btn btn-sm btn-warning" title="Tips"><i class="fas fa-lightbulb"></i></button>
								<a class=""><i class="fas fa-question-circle"></i></a>
							</span>
						</div>

						<!-- Card Body -->
						<div class="card-body">

							<div class="table-responsive">
								<table id="closed_table" class="table table-hover table-striped" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>tkey</th>
											<th>trans_no</th>
											<th style="width: 90px !important;">IIS No.</th>
											<th>entry</th>
											<th>route_order</th>
											<th>main_multi_cntr</th>
											<th>multiprc</th>
											<th>Company Name</th>
											<th>EMB ID</th>
											<th>Subject</th>
											<th>Transaction Type</th>
											<th>rcv</th>
											<th>Status</th>
											<th>Action Taken</th>
											<th>Time/Date Forwarded</th>
											<th>Sender</th>
											<th>multi_cntr</th>
											<th>Remarks</th>
											<th style="width: 130px">Action</th>
										</tr>
									</thead>
								</table>
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

			    var table = $('#closed_table').DataTable({
							dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-8'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							order: [[14, "desc"]],
							language: {
						    "infoFiltered": "",
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Data_Tables/closed'); ?>",
			            "type": 'POST',
									"data": { 'user_token': '<?php echo $user_token; ?>' },
			        },
			        columns: [
								{ "data": "enc_tkey", "searchable": false, "sortable": false, "visible": false },
								{ "data": "trans_no", "visible": false, "sortable": false },
								{ "data": "token", className: "bold" },
								{ "data": "entry", "searchable": false, "visible": false },
								{ "data": "route_order", "searchable": false, "visible": false },
								{ "data": "main_multi_cntr", "searchable": false, "visible": false },
								{ "data": "multiprc", "searchable": false, "visible": false },
								{ "data": "company_name" },
								{ "data": "emb_id",
									"render": function(data, type, row, meta) {
										var embid = data.split('-');
										return "<p title='"+data+"'>"+embid[0]+"-...-"+embid[2]+"</p>";
									}
								},
								{ "data": "subject"},
								{ "data": "type_description"},
								{ "data": "receive", "searchable": false, "visible": false },
								{ "data": "status_description"},
								{ "data": "action_taken", "searchable": false, "visible": false },
								{ "data": "date_out"},
								{ "data": "sender_name"},
								{ "data": "multi_cntr", "searchable": false, "visible": false },
								{ "data": "remarks"},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										var m_check = (row['entry'] == 2)  ? '(M)' : '';
										data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal' data-target='.viewTransactionModal'>"+m_check+"View</button>&nbsp;";

										data += "<button type='button' id='unlockbtn' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#reopenTransactionModal' title='Re-Open'><i class='fas fa-lock-open'></i></button>&nbsp;";

										return data;
									}
								}
			        ]
			    });

			    $('#closed_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.view_transaction( data['trans_no'] );
						} );

						$('#closed_table tbody').on('click', '#unlockbtn', function () {
				        var data = table.row( $(this).parents('tr') ).data();
							$('#reopenTransactionDiv textarea').html(data['enc_tkey']);
							$('#reopenTransactionDiv span').html(data['token']);
						});



			} );

		</script>
