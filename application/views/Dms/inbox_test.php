<? // #####################################################		TEST-ONLY PHP FILE			############################################## //?>
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

							</div>
						<!-- Card Body -->

					</div>

				</div>
			</div>
		</div>

	</div>

	<div id="colmn_filter_slctn" hidden>
		<select id="colmn_filter_slct" class="search_fld form-control">
			<option value="0" selected>-all-</option>
			<option value="2" >IIS No.</option>
			<option value="7" >Company Name</option>
			<option value="8" >EMB ID</option>
			<option value="9" >Subject</option>
			<option value="10" >Trans. Type</option>
			<option value="12" >Status</option>
			<option value="14" >Date Forwarded</option>
			<option value="15" >Sender</option>
		</select>
	</div>

	<script>
		$(document).ready(function() {

		    var table = $('#inbox_table').DataTable({
						dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-2'><'col-sm-12 col-md-1'<'col_filter'>><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
						lengthMenu: [ 10, 50, 100, 500 ],
						pageLength: <?php if(in_array($user_token, array('3835e2eb0efa29cd','25dde3133d1748'))) {echo 100; } else {echo 10;} ?>,
						order: [[14, "desc"]],
						select: true,
						columnDefs: [
							{
								 'orderable': false,
								 'targets': 0,
								 'checkboxes': {
										'selectRow': true
								 },
							}
						],
						select: {
								'style': 'multi',
								'selector': 'td:first-child'
								// 'selector': 'td:not(:last-child)'
						},
						language: {
					    infoFiltered: "",
							processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
					  },
		        serverSide: true,
		        processing: true,
		        responsive: true,
		        deferRender: true,
						paging: true,
						// stateSave: true
						// "scrollY": 500,
						"scrollX": true,
		        ajax: {
		            "url": "<?php echo base_url('Dms/Data_Tables/inbox'); ?>",
		            "type": 'POST',
								"data": {'user_token': '<?php echo $user_token; ?>' },
		        },
		        columns: [
							{ "data": "enc_tkey", "searchable": false, "sortable": false },
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

									if(row['receive'] != 0) {
										data += "<button type='button' id='prcbtn' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#process'>Process</button>&nbsp;";
									}
									else {
										data += "<button type='button' id='rcvbtn' class='inboxrcv-btn btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal' data-target='#receive'>Receive</button>&nbsp;";
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


		    $('#inbox_table tbody').on( 'click', '#viewbtn', function () {
		        var data = table.row( $(this).parents('tr') ).data();
						Dms.trans_view( data['trans_no'], data['multiprc'] );
		    } );

		    $('#inbox_table tbody').on( 'click', '#prcbtn', function () {
		        var data = table.row( $(this).parents('tr') ).data();
						var uniq_form = $('div#multiprcTransModal form#inbox_multiprc_transaction');
						var rows_selected = multipleSelection(uniq_form);
						if(rows_selected.length > 1) {
							$('div#multiprcTransModal').modal('show');
						}
						else {
							var main_multi_cntr = (data['main_multi_cntr']!= null && data['main_multi_cntr']!= '') ? data['main_multi_cntr'] : '1';
							window.location.href = '/embis/dms/documents/process/'+data['entry']+'/'+data['trans_no']+'/'+main_multi_cntr+'/'+data['multi_cntr'];
						}
			 } );

			 $('#inbox_table tbody').on( 'click', '#rcvbtn', function () {
 					var data = table.row( $(this).parents('tr') ).data();
					var _this = $(this);

			    var request = $.ajax({
			       url: '/embis/dms/data/ajax/receive_transaction',
			       method: 'POST',
			       data: { trans_no : data['trans_no'], entry: data['entry'], route_order: data['route_order'], main_multi_cntr: data['main_multi_cntr'], multi_cntr: data['multi_cntr'] },
					   // dataType: 'json',
			       beforeSend: function(jqXHR, settings){
			         _this.html('<span class="text">Please Wait...</span>').attr('disabled','disabled');
			         $('button.inboxrcv-btn').attr('disabled','disabled');
			       }
			    });

			    request.done(function(data) {
						// if (data.error == 1) {
							$('#save_draft_button').val('Save Status').removeAttr('disabled');
			        $('button.inboxrcv-btn').attr('disabled', '');
							table.ajax.reload(null, false);
						// }
					});

					request.fail(function(jqXHR, textStatus) {
					  alert( "Request failed: " + textStatus );
			      $('button.inboxrcv-btn').attr('disabled', '');
					});
 			 } );

			 function multipleSelection(uniq_form)
			 {
					 var rows_selected = table.column(0).checkboxes.selected();
					 // Remove added elements
					 $('input[name="multitrans_no\[\]"]', uniq_form).remove();
					 // Iterate over all selected checkboxes
					 $.each(rows_selected, function(index, rowId){
							 // Create a hidden element
								uniq_form.find('div#trans-list').append(
										$('<input>')
											 .attr('type', 'hidden')
											 .attr('name', 'multitrans_no[]')
											 .attr('readonly', 'readonly')
											 .val(rowId)
								);
					 });
					 return rows_selected;
			 }
		} );
		</script>
