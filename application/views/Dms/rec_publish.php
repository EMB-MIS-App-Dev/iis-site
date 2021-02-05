
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> PUBLISHED TRANSACTIONS</h6>

							<!-- <a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a> -->

						</div>

						<!-- Card Body -->
						<div class="card-body">

							<div class="table-responsive">
								<table id="rec_publish_table" class="table table-hover table-striped" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>no</th>
											<th style="width: 130px;" id="iisno"> IIS No. </th>
											<th>mprc</th>
											<th style="width: 200px;">Company Name</th>
											<th style="width: 150px;">EMB ID</th>
											<th>Subject</th>
											<th style="width: 150px;">Transaction Type</th>
											<th>rcv</th>
											<th>Status</th>
											<th>Action Taken</th>
											<th>Sender</th>
											<th>Time/Date Forwarded</th>
											<th>Receiver</th>
											<th>Remarks</th>
											<th style="width: 50px">Action</th>
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

			    var table = $('#rec_publish_table').DataTable({
							dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-8'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							order: [[0, "desc"]],
							language: {
						    "infoFiltered": "",
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
							// "scrollY": 500,
        			"scrollX": true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Datatables/rec_publish'); ?>",
			            "type": 'POST',
									"data": { 'user_region': '<?php echo $user_region; ?>', 'filter': '<?php echo $trans_filter; ?>' },
			        },
			        // 'columnDefs': [
							// 	{
							// 			'targets': 1,
							// 			'createdCell':  function (td, cellData, rowData, row, col) {
							// 				$(td).attr('id', 'iisno');
							// 			}
							// 	}
				  		// ],
			        columns: [
								{ "data": "trans_no", "searchable": false, "visible": false},
								{ "data": "token" },
								{ "data": "multiprc", "searchable": false, "visible": false},
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
								{ "data": "sender_name",
									"render": function(data, type, row, meta) {
                    return data.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
									}
								},
								{ "data": "date_out"},
								{ "data": "receiver_name",
									"render": function(data, type, row, meta) {
										if(data) {
                      return data.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
                    }
                    else {
                      return '--';
                    }
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
										return data;
									}
								}
			        ]
			    });

				// $("div.filter").html('<button id="filterbtn" class="form-control form-control-sm" type="button" data-toggle="modal" data-target=".transFilterModal"><i class="fas fa-filter"></i> Filter Table</button>');

			    $("div.filter").on( 'click', '#filterbtn', function () {
						Dms.filter_transaction();
				} );

			    $('#rec_publish_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.view_transaction( data['trans_no'] );
				} );

				$('#rec_publish_table tbody').on( 'click', '#prcbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
			        Dms.route_transaction( data['trans_no'] );
			    } );

			} );

		</script>
