
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> INBOX TRANSACTIONS</h6>

							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a>

						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="inbox_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
												<tr>
													<th>no</th>
													<th style="width: 90px;"> IIS No. </th>
													<th>Company Name</th>
													<th>EMB ID</th>
													<th>Subject</th>
													<th>Transaction Type</th>
													<th>rcv</th>
													<th>Status</th>
													<th>Action Taken</th>
													<th>Sender</th>
													<th>Remarks</th>
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
	<?php
		$swal_arr = $this->session->flashdata('swal_arr');
		if(!empty($swal_arr)) {
			echo "<script>
				swal({
					title: '".$swal_arr['title']."',
					html: '".$swal_arr['text']."',
					type: '".$swal_arr['type']."',
					allowOutsideClick: false,
					customClass: 'swal-wide',
					confirmButtonClass: 'btn-success',
					confirmButtonText: '".'<i class="fa fa-thumbs-up"></i> Great!'."',
					onOpen: () => swal.getConfirmButton().focus()
				})
			</script>";
		}
	?>
		<script>

			$(document).ready(function() {

			    var table = $('#inbox_table').DataTable({
							order: [[6, "desc"], [5, "desc"], [0, "desc"]],
			        serverSide: true,
			        processing: true,
			        responsive: true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Datatables/inbox'); ?>",
			            "type": 'POST',
									"data": {'user_token': '<?php echo $user_token; ?>' },
			        },
			        columns: [
								{ "data": "trans_no", "searchable": false, "visible": false},
								{ "data": "token" },
								{ "data": "company_name" },
								{ "data": "emb_id"},
								{ "data": "subject"},
								{ "data": "type_description"},
								{ "data": "receive", "searchable": false, "visible": false},
								{ "data": "status_description"},
								{ "data": "action_taken"},
								{ "data": "sender_name",
									"render": function(data, type, row, meta) {
										return data.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
									}
								},
								{ "data": "remarks"},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.viewTransactionModal'>View</button>&nbsp;";

										if(row['receive'] != 0) {
											if(row['type_description'] == 'TRAVEL ORDER'){
												data += "<button type='button' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal' data-target='#process_travelorder' onclick='process_travel("+row['trans_no']+");'>Process</button>&nbsp;";
											}else{
												data += "<button type='button' id='prcbtn' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#process'>Process</button>&nbsp;";
											}
										}
										else {
											data += "<button type='button' id='rcvbtn' class='btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#receive'>Receive</button>&nbsp;";
										}
										return data;
									}
								}
			        ]
			    });

			    $('#inbox_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.view_transaction( data['trans_no'] );
			    } );

			    $('#inbox_table tbody').on( 'click', '#prcbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							$.ajax({
					       url: Dms.base_url + 'Dms/set_trans_session',
					       method: 'POST',
					       data: { trans_no : data['trans_no'] },
								 success: function() {
									 window.location.href = Dms.base_url + 'Dms/route_transaction';
								 }
					    });
			    } );

			    $('#inbox_table tbody').on( 'click', '#rcvbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							var rcv = Dms.receive_transaction( $(this), data['trans_no'] );
			        if(rcv == 1) {
								setTimeout(function(){
						        table.ajax.reload(null, false);
						    }, 700);
							}
			    } );

			} );
			</script>
