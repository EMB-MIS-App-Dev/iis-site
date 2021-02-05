
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> REVISIONS</h6>
						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="revise_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
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
													<th>Start Date</th>
													<th>tag</th>
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

			    var table = $('#revise_table').DataTable({
							order: [[1, "desc"]],
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
			        serverSide: true,
			        processing: true,
			        responsive: true,
            	paging: true,
							// "scrollY": 500,
        			"scrollX": true,
							language: {
						    "infoFiltered": "",
						  },
			        ajax: {
			            "url": "<?php echo base_url('Dms/Datatables/revisions'); ?>",
			            "type": 'POST',
									"data": {'user_token': '<?php echo $user_token; ?>', 'user_region': '<?php echo $user_region; ?>' },
			        },
			        columns: [
								{ "data": "trans_no", "searchable": false, "sortable": false},
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
								{ "data": "start_date"},
								{ "data": "tag_doc_type", "searchable": false, "visible": false},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.viewTransactionModal'>View</button>&nbsp;";

										if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes') {
											data += "<button type='button' id='revisebtn' class='btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#revise'>Revise</button>&nbsp;";
										}

										if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes') {
											data += "<button type='button' id='confidentialbtn' class='btn btn-success btn-sm waves-effect waves-light' title='Set to Confidential' data-toggle='modal'  data-target='.confidentialTransModal'>Confi</button>&nbsp;";
										}

										data += "<button type='button' id='deletebtn' class='btn btn-danger btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.deleteTransModal'>Delete</button>&nbsp;";

										data += "<button type='button' id='acknowledgebtn' class='btn btn-primary btn-sm waves-effect waves-light' title='Acknowledgement Letter'>AL</button>&nbsp;";
										data += "<button type='button' id='disposformbtn' class='btn btn-dark btn-sm waves-effect waves-light' title='Disposition Form'>DF</button>&nbsp;";

										return data;
									}
								}
			        ]
			    });

			    $('#revise_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.view_transaction( data['trans_no'] );
			    } );

			    $('#revise_table tbody').on( 'click', '#revisebtn', function () {
							var data = table.row( $(this).parents('tr') ).data();
							var rows_selected = multiprcCheck();

			        if(rows_selected.length > 1) {
								$('#multiprc_modal').modal('show');
							}
							else {
								$.ajax({
						       url: Dms.base_url + 'Dms/set_trans_session',
						       method: 'POST',
						       data: { trans_no : data['trans_no'] },
									 success: function() {
										 window.location.href = Dms.base_url + 'Dms/revise_transaction';
									 }
						    });
							}
			    } );

					function multiprcCheck()
					{
							var rows_selected = table.column(0).checkboxes.selected();
							// Remove added elements
							$('input[name="multi_trans_no\[\]"]', '#multi_transprc_form').remove();
							// Iterate over all selected checkboxes
							$.each(rows_selected, function(index, rowId){
									// Create a hidden element
									 $('#multi_transprc_form').append(
											 $('<input>')
													.attr('type', 'hidden')
													.attr('name', 'multi_trans_no[]')
													.attr('readonly', 'readonly')
													.val(rowId)
									 );
							});
							return rows_selected;
					}

					$('#revise_table tbody').on( 'click', '#deletebtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							var rows_selected = multidlteCheck();

							if(rows_selected.length == 0) {
								$('#multidlte_trans_form div.container').append(
										$('<input>')
											 .attr('type', 'hidden')
											 .attr('name', 'multidlte_trans_no[]')
											 .attr('readonly', 'readonly')
											 .val(data['trans_no'])
								);
							}
		    	} );

					function multidlteCheck()
					{
							var rows_selected = table.column(0).checkboxes.selected();
							// Remove added elements
							$('input[name="multidlte_trans_no\[\]"]', '#multidlte_trans_form').remove();
							// Iterate over all selected checkboxes
							$.each(rows_selected, function(index, rowId){
									// Create a hidden element
									 $('#multidlte_trans_form div.container').append(
											 $('<input>')
													.attr('type', 'hidden')
													.attr('name', 'multidlte_trans_no[]')
													.attr('readonly', 'readonly')
													.val(rowId)
									 );
							});
							return rows_selected;
					}

					$('#revise_table tbody').on( 'click', '#confidentialbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							var rows_selected = multiconfidentialCheck();

							if(rows_selected.length == 0) {
								$('#multiconfidential_trans_form div.container').append(
										$('<input>')
											 .attr('type', 'hidden')
											 .attr('name', 'multiconfidential_trans_no[]')
											 .attr('readonly', 'readonly')
											 .val(data['trans_no'])
								);
							}
		    	} );

					function multiconfidentialCheck()
					{
							var rows_selected = table.column(0).checkboxes.selected();
							// Remove added elements
							$('input[name="multiconfidential_trans_no\[\]"]', '#multiconfidential_trans_form').remove();
							// Iterate over all selected checkboxes
							$.each(rows_selected, function(index, rowId){
									// Create a hidden element
									 $('#multiconfidential_trans_form div.container').append(
											 $('<input>')
													.attr('type', 'hidden')
													.attr('name', 'multiconfidential_trans_no[]')
													.attr('readonly', 'readonly')
													.val(rowId)
									 );
							});
							return rows_selected;
					}

			    $('#revise_table tbody').on( 'click', '#acknowledgebtn', function () {
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

					$('#revise_table tbody').on( 'click', '#disposformbtn', function () {
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

			} );
			</script>
