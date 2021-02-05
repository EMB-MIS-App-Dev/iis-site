
		<div class="container-fluid">
			<div class="row">
				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->

						<?php // echo $user_token;?>
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> REVISIONS</h6>
							<!--  -->
							<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction </a>

						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="revisions_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
												<tr>
													<th>trans_no</th>
													<th style="width: 90px !important;">IIS No.</th>
													<th>entry</th>
													<th>route_order</th>
													<th>Main #</th>
													<th>multiprc</th>
													<th>Multi #</th>
													<th>Company Name</th>
													<th>EMB ID</th>
													<th>Subject</th>
													<th>Transaction Type</th>
													<th>rcv</th>
													<th>Status</th>
													<th>Action Taken</th>
													<th>Sender</th>
													<th>Receiver</th>
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

	<script>
		$(document).ready(function() {

				var tableData = {
					'user_region'	: '<?php echo $user_region; ?>',
					'user_token'	: '<?php echo $user_token; ?>'
				};
		    var table = $('#revisions_table').DataTable({
						// dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-5'><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
						lengthMenu: [ 10, 50, 100, 500 ],
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
		        ajax: {
		            "url": "<?php echo base_url('Dms/Data_Tables_Test/revisions'); ?>",
		            "type": 'POST',
								"data": function ( d ) {
													return  $.extend(d, tableData);
												},
		        },
		        columns: [
							{ "data": "trans_no", "visible": false },
							{ "data": "token", className: "bold" },
							{ "data": "entry", "searchable": false, "visible": false },
							{ "data": "route_order", "searchable": false, "visible": false },
							{ "data": "main_multi_cntr" },
							{ "data": "multiprc", "searchable": false, "visible": false },
							{ "data": "multi_cntr" },
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
							{ "data": "sender_name" },
							{ "data": "receiver_name" },
							{ "data": "remarks"},
							{
								"sortable": false,
								"render": function(data, type, row, meta) {
									var m_check = (row['entry'] == 2)  ? '(M)' : '';
									data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal' data-target='.viewTransactionModal'>"+m_check+"View</button>&nbsp;";

									data += "<button type='button' id='revisebtn' class='inboxrcv-btn btn btn-danger btn-sm waves-effect waves-light' data-toggle='modal' data-target='#revise'>Revise</button>&nbsp;";

									return data;
								}
							}
		        ]
		    });

				if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes') {
					$("div.region_slct").html($("div#trans_region_selection").html());
				}

				$('#trans_regional_filter').change(function() {
          tableData.user_region = $('#trans_regional_filter').val();
					table.draw();
				} );

		    $('#revisions_table tbody').on( 'click', '#viewbtn', function () {
		        var data = table.row( $(this).parents('tr') ).data();
						Dms.trans_view( data['trans_no'], data['multiprc'] );
		    } );

		    $('#revisions_table tbody').on( 'click', '#revisebtn', function () {
		        var data = table.row( $(this).parents('tr') ).data();
						var main_multi_cntr = (data['main_multi_cntr']!= null && data['main_multi_cntr']!= '') ? data['main_multi_cntr'] : '1';
						console.log('/embis/dms/documents/revise/'+data['entry']+'/'+data['trans_no']+'/'+main_multi_cntr+'/'+data['multi_cntr']);
						window.location.href = '/embis/dms/documents/revise/'+data['entry']+'/'+data['trans_no']+'/'+main_multi_cntr+'/'+data['multi_cntr'];
		 		} );

		} );
		</script>
