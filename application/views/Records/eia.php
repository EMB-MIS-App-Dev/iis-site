
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> PERMIT - EIA</h6>

						</div>

						<!-- Card Body -->
						<div class="card-body">

							<div class="table-responsive" style="zoom: 90%">
								<table id="eia_table" class="table table-hover table-striped" width="100%" cellspacing="0">
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
											<th>DateTime Forwarded</th>
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

	<div hidden id="eiatype_selection">
		<select id="eia_slctd" class="form-control" name="eia_slct" >
			<?php
				foreach ($system_type as $key => $value) {
					echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
				}
			?>
		</select>
	</div>

		<script>

			$(document).ready(function() {
					var tableData = {
						'type': $('#eia_slctd').val(),
						'start_date': $('input[name="start_date"]').val(),
						'end_date': $('input[name="end_date"]').val(),
					};
			    var table = $('#eia_table').DataTable({
							dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-3'<'type'>><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-5'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							order: [[11, "desc"]],
							language: {
						    "infoFiltered": "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
							// "scrollY": 500,
        			"scrollX": true,
			        ajax: {
			            "url": "<?php echo base_url('Records/Datatables/permits'); ?>",
			            "type": 'POST',
									"data": function ( d ) {
			                   		return  $.extend(d, tableData);
											 		},
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
								{ "data": "trans_no", "visible": false},
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

				$("div.filter").html('<button id="filterbtn" class="form-control form-control-sm" type="button" data-toggle="modal" data-target=".filterModal"><i class="fas fa-filter"></i> Filter Table</button>');

				$("div.type").html($('#eiatype_selection').html());

		    $('#eia_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.view_transaction( data['trans_no'] );
				} );

				$('#eia_slctd').change(function() {
          tableData.type = $('#eia_slctd').val();
					table.draw();
				} );

				$('#permitfilter_reset').on('click', function() {
          tableData.start_date = '';
          tableData.end_date = '';
					table.draw();
				} );

				$('#permitfilter').on('click', function() {
          tableData.start_date = $('input[name="start_date"]').val();
          tableData.end_date = $('input[name="end_date"]').val();
					table.draw();
				} );

			} );


		</script>
