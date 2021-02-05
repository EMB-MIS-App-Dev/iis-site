<?php
	// if($user_token == '515e12d4a186a84') {
	// 	echo "<a title='Bulk Download' href='".base_url('Dms/Dms/sampdlasdsad')."' target='_blank'><i class='fa fa-download'></i> sampfcknfull bulk dl</a>";
	// }
?>
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> ALL TRANSACTIONS</h6>

							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a>

						</div>

						<!-- Card Body -->
						<div class="card-body">

							<div class="table-responsive">
								<table id="all_trans_table" class="table table-hover table-striped" width="100%" cellspacing="0">
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

	<div id="trans_region_selection" hidden>
		<select id="trans_regional_filter" class="form-control" name="trans_region_filter">
			<?php
				foreach ($region as $key => $value) {
					if($value['rgnnum'] == $user_region) {
						echo '<option value="'.$value['rgnnum'].'" selected>'.$value['rgnname'].'</option>';
					}
					else {
						echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
					}
				}
			?>
		</select>
	</div>

	<div id="colmn_filter_slctn" hidden>
		<select id="colmn_filter_slct" class="search_fld form-control">
			<option value="0" selected>-all-</option>
			<option value="1" >IIS No.</option>
			<option value="3" >Comp. Name</option>
			<option value="4" >EMB ID</option>
			<option value="5" >Subject</option>
			<option value="6" >Trans. Type</option>
			<option value="8" >Status</option>
			<option value="9" >Action</option>
			<option value="10" >Sender</option>
			<option value="12" >Receiver</option>
		</select>
	</div>

		<script>

			$(document).ready(function() {

					var tableData = {
						// 'region_filter': $('#trans_regional_filter').val(),
						'user_region': '<?php echo $user_region; ?>',
						'filter': '<?php echo $trans_filter; ?>',
					};
			    var table = $('#all_trans_table').DataTable({
							dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-2'><'col-sm-12 col-md-1'<'col_filter'>><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							order: [[11, "desc"]],
							language: {
						    "infoFiltered": "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
							// "scrollY": 500,
        			"scrollX": true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Data_Tables/all_transactions'); ?>",
			            "type": 'POST',
									"data": function ( d ) {
			                   		return  $.extend(d, tableData);
											 		},
			        },
			        columns: [
								{ "data": "trans_no", "searchable": false, "visible": false},
								{ "data": "token" },
								{ "data": "multiprc", "searchable": false, "visible": false},
								{ "data": "company_name" },
								{ "data": "emb_id",
									"render": function(data, type, row, meta) {
										var embid = data.split('-');
										return "<p title='"+data+"'>"+embid[0]+"-...-"+embid[2]+"</p>";
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

				$("div.filter").html('<button id="filterbtn" class="form-control form-control-sm" type="button" data-toggle="modal" data-target=".transFilterModal"><i class="fas fa-filter"></i> Filter Table</button>');

				$("div.col_filter").html($("div#colmn_filter_slctn").html());
				$("div.search_bar").html('<input class="search_fld form-control form-control-sm" id="search_bar" />');
				$("div.search_btn").html('<button id="search_btn" class="search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span id="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

				$("#search_btn").on('click', function () {
					table.settings()[0].jqXHR.abort()
					if($("#colmn_filter_slct").val() != 0) {
					  table.search($("#search_bar").val()).draw();
					  table.column($("#colmn_filter_slct").val()).search($('#search_bar').val()).draw();
					}
					else {
					  table.search($("#search_bar").val()).draw();
					}
					$('#search_spinner').show();
					$(".search_fld").prop('disabled', true);
				});

				table.on( 'draw', function () {
					$('#search_spinner').hide();
					$(".search_fld").prop('disabled', false);
				} );

				if('<?php echo $user_token; ?>' == '2895e2156175ba42' || '<?php echo $user_token; ?>' == '2435e21155d1a1b5' || '<?php echo $user_token; ?>' == '1965e1ebd3d5c4af' || '<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes')
				{
					$("div.region_slct").html($("div#trans_region_selection").html());
				}

				$('#trans_regional_filter').change(function() {
          tableData.user_region = $('#trans_regional_filter').val();
					table.draw();
				} );

			    $('#all_trans_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							$('#view_transaction_modal').html('<div class="d-flex justify-content-center"> <div class="spinner-border" role="status"> <span class="sr-only">Loading...</span> </div> </div>');
							Dms.trans_view( data['trans_no'] );
				} );

				$('#all_trans_table tbody').on( 'click', '#prcbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
			        Dms.route_transaction( data['trans_no'] );
			    } );

				$('#filterbtn').click(function () {
		        Dms.filter_transaction();
		    } );

			} );

		</script>
