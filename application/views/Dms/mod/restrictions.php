
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> TRANSFER TRANSACTIONS</h6>
						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="trans_transfer_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
												<tr>
													<th>EMB ID</th>
													<th>Company Name</th>
													<th>psi_code_no</th>
													<th>Project Type</th>
													<th>barangay_name</th>
													<th>city_name</th>
													<th>province_name</th>
													<th>Address</th>
													<th>longitude</th>
													<th>latitude</th>
													<th>Trans. Count</th>
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

		<!-- TRANSACTION ADD -->
		<div class="modal fade transferTransByCompanyModal" role="dialog">
		  <div class="modal-dialog modal-lg" >
		    <div class="modal-content">

		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Transfer Transactions by Company</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form action="<?php echo base_url('Dms/Form_Data/transfer_trans_company'); ?>" method="POST">
						<center><h6 style="color: red; margin:30px 0px 15px 0px;">*This function transfers ALL transactions from the selected company to the other. Please handle with care.</h6></center>
		        <div class="modal-body"></div>
		        <div class="modal-footer">
		          <div class="row">
		            <div class="col-md-12">
		              <button type="submit" class="btn btn-success" name="ttrnscomp_confirm" >Transfer</button>
		              <button type="button" class="btn btn-secondary" data-dismiss="modal" >cancel</button>
		            </div>
		          </div>
		        </div>
		      </form>

		    </div>
		  </div>
		</div>

	</div>

		<script>

			$(document).ready(function() {

			    var table = $('#trans_transfer_table').DataTable({
							order: [[1, "asc"]],
			        serverSide: true,
			        processing: true,
			        responsive: true,
            	paging: true,
							// scrollY: 500,
        			scrollX: true,
							language: {
						    infoFiltered: "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
			        ajax: {
			            "url": "<?php echo base_url('Dms/Data_Tables/file_transfer'); ?>",
			            "type": 'POST',
									"data": { 'user_region': '<?php echo $user_region; ?>' },
			        },
			        columns: [
								{ "data": "emb_id" },
								{ "data": "company_name" },
								{ "data": "psi_code_no", visible: false, searchable: false },
								{ "data": "project_name" },
								{ "data": "barangay_name", visible: false, searchable: false },
								{ "data": "city_name", visible: false, searchable: false },
								{ "data": "province_name", visible: false, searchable: false },
								{ data: null,
									searchable: false,
									render: function(data, type, row, meta) {
										data = row['barangay_name']+' '+row['city_name']+', '+row['province_name'];
										return data;
									}
							 	},
								{ "data": "longitude", visible: false, searchable: false },
								{ "data": "latitude", visible: false, searchable: false },
								{ "data": "tno_cnt" },
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										data = "<button type='button' id='trnsfrbtn' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.transferTransByCompanyModal' title='Tranfer'><i class='fas fa-exchange-alt'></i></button>&nbsp;";
										return data;
									}
								}
			        ]
			    });

			    $('#trans_transfer_table tbody').on( 'click', '#trnsfrbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.add_company_modal();
			    } );

			    $('#trans_transfer_table tbody').on( 'click', '#revisebtn', function () {
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

					$('#trans_transfer_table tbody').on( 'click', '#deletebtn', function () {
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

					$('#trans_transfer_table tbody').on( 'click', '#confidentialbtn', function () {
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

			    $('#trans_transfer_table tbody').on( 'click', '#acknowledgebtn', function () {
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

					$('#trans_transfer_table tbody').on( 'click', '#disposformbtn', function () {
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
