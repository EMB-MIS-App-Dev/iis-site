
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> OUTBOX TRANSACTIONS</h6>

							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a>

						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="outbox_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
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
													<th>mprc</th>
													<th>Date</th>
													<th>Assigned</th>
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

			    var table = $('#outbox_table').DataTable({
							order: [[10, "desc"]],
							language: {
						    "infoFiltered": "",
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
							// "scrollY": 500,
        			"scrollX": true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Datatables/outbox'); ?>",
			            "type": 'POST',
									"data": {'user_token': '<?php echo $user_token; ?>' },
			        },
			        'columnDefs': [
					    {
					        'targets': 1,
					        'createdCell':  function (td, cellData, rowData, row, col) {
					           $(td).attr('id', 'iisno');
					        }
					    }
				  	],
			        columns: [
								{ "data": "trans_no", "searchable": false, "visible": false},
								{ "data": "token" },
								{ "data": "company_name" },
								{ "data": "emb_id",
									"render": function(data, type, row, meta) {
										var embid = data.split('-');
										return "<p title='"+data+"'>"+embid[0]+"-"+embid[2]+"</p>";
									}
								},
								{ "data": "subject"},
								{ "data": "type_description"},
								{ "data": "receive", "searchable": false, "visible": false},
								{ "data": "status_description"},
								{ "data": "action_taken"},
								{ "data": "multiprc", "searchable": false, "visible": false},
								{ "data": "date_out"},
								{ "data": "receiver_name",
									"render": function(data, type, row, meta) {
										return data.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
									}
								},
								{ "data": "remarks"},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										if(row['multiprc'] > 0) {
											data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.viewTransactionModal'>(M)View</button>&nbsp;";
										}
										else {
											data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.viewTransactionModal'>View</button>&nbsp;";
										}
										data += "<button type='button' id='acknowledgebtn' class='btn btn-primary btn-sm waves-effect waves-light' title='Acknowledgement Letter'>AL</button>&nbsp;";
										data += "<button type='button' id='disposformbtn' class='btn btn-dark btn-sm waves-effect waves-light' title='Disposition Form'>DF</button>&nbsp;";
										data += "<button type='button' id='disposformblnkbtn' class='btn btn-dark btn-sm waves-effect waves-light' title='Blank Disposition Form'>Blank DF</button>&nbsp;";
										// data += "<button type='button' id='recallbtn' class='btn btn-danger btn-sm waves-effect waves-light'>Recall</button>&nbsp;";
										return data;
									}
								}
			        ]
			    });

			    $('#outbox_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.trans_view( data['trans_no'] );
			    } );

			    $('#outbox_table tbody').on( 'click', '#acknowledgebtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();

							$.ajax({
					       url: Dms.base_url + 'Dms/set_trans_session',
					       method: 'POST',
					       data: { trans_no : data['trans_no'] },
								 success: function() {
									 window.open(Dms.base_url + 'Dms/acknowledgeLetter', "_blank");
								 }
					    });
			    } );

					$('#outbox_table tbody').on( 'click', '#disposformbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();

							$.ajax({
					       url: Dms.base_url + 'Dms/set_trans_session',
					       method: 'POST',
					       data: { trans_no : data['trans_no'] },
								 success: function() {
									 window.open(Dms.base_url + 'Dms/dispositionForm', "_blank");
								 }
					    });
			    } );


					$('#outbox_table tbody').on( 'click', '#disposformblnkbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();

							$.ajax({
					       url: Dms.base_url + 'Dms/set_trans_session',
					       method: 'POST',
					       data: { trans_no : data['trans_no'] },
								 success: function() {
									 window.open(Dms.base_url + 'Dms/dispositionFormBlank', "_blank");
								 }
					    });
			    } );

				// $('#outbox_table tbody').on( 'click', '#recallbtn', function () {
			   //      var data = table.row( $(this).parents('tr') ).data();
				// 		$.ajax({
				//        url: Dms.base_url + 'Dms/set_trans_session',
				//        method: 'POST',
				//        data: { trans_no : data['trans_no'] },
				// 			 success: function() {
				// 				 window.open(Dms.base_url + 'Dms/dispositionFormBlank', "_blank");
				// 			 }
				//     });
			   //  } );
			} );

		</script>
