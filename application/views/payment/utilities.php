

<?php
if($fvalid_error == 1) {
	?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<span style="font-size: 14px "><b>NOTE:</b> Please Fill-in the EMPTY Field(s), Cannot Proceed.</span>
		<hr style="margin: 5px">
		<p><?php echo validation_errors(); ?></p>

		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php
}
?>
<style>
.table-responsive {
	font-size: 13px
}
</style>
<div class="container-fluid">

	<!-- #####################################################    MODALS    ################################################################### -->
	<div class="modal fade" id="addCategoriesModal" role="dialog" >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add OP Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<fieldset>
					<div class="modal-body">
						<div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Category</label>
									<input class="form-control" name="category" />
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success btn-sm" name="save">Save</button>
					</div>
				</fieldset>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addItemModal" role="dialog" >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Item</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<fieldset>
					<div class="modal-body">
						<div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Item Description</label>
									<input class="form-control" name="item_desciption" />
								</div>
								<div class="form-group">
									<label>Fund Code</label>
									<input class="form-control" name="fund_code" />
								</div>
								<div class="form-group">
									<label>Account No.</label>
									<input class="form-control" name="account_no" />
								</div>
								<div class="form-group">
									<label>Amount</label>
									<input class="form-control" name="amount" />
								</div>
								<!-- <div class="form-group">
									<label>Region</label>
									<input class="form-control" name="region" />
								</div> -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success btn-sm" name="save">Save</button>
					</div>
				</fieldset>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addSignatoriesModal" role="dialog" >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Signatory</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<fieldset>
					<div class="modal-body">
						<div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Person</label>
									<input class="form-control" name="name" />
								</div>
								<div class="form-group">
									<label>Title</label>
									<input class="form-control" name="title" />
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success btn-sm" name="save">Save</button>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	<!-- #####################################################    MODALS    ################################################################### -->

	<div class="col-md-12" style="width: 90%; margin: auto">
		<div class="card shadow">
			<div class="card-body">
				<fieldset>
					<!-- <legend>Family Background</legend> -->
					<hr />
					<div class="row no-gutters align-items-center justify-content-md-center">
						<div class="col-md-10 mr-2">

							<hr />
							<label>ORDER OF PAYMENT CATEGORIES</label>
							<hr />
							<button type="button" class="btn btn-labeled btn-primary" data-toggle="modal" data-target="#addCategoriesModal"> <span class="btn-label"><i class="fas fa-plus"></i></span> ADD CATEGORY</button>
							<br /> <br />
							<div id="categoriesDataTable" class="row">
								<div class="table-responsive">
									<table class="table table-hover" width="100%">
										<thead>
											<tr style="text-align: center">
												<th>#</th>
												<th>Category</th>
												<th></th>
											</tr>
										</thead>
									</table>
								</div>
							</div> <br />

							<hr />
							<label>ITEM DETAILS</label>
							<hr />
							<button type="button" class="btn btn-labeled btn-primary" data-toggle="modal" data-target="#addItemModal"> <span class="btn-label"><i class="fas fa-plus"></i></span> ADD ITEM</button>
							<br /> <br />
							<div id="itemsDataTable" class="row">
								<div class="table-responsive">
									<table class="table table-hover" width="100%">
										<thead>
											<tr style="text-align: center">
												<th>#</th>
												<th>Item Description</th>
												<th>Fund Code</th>
												<th>Account No.</th>
												<th>Amount</th>
												<th>Region</th>
												<th></th>
											</tr>
										</thead>
									</table>
								</div>
							</div> <br />

							<hr />
							<label>SIGNATORIES</label>
							<hr />
							<button type="button" class="btn btn-labeled btn-primary" data-toggle="modal" data-target="#addSignatoriesModal"> <span class="btn-label"><i class="fas fa-plus"></i></span> ADD SIGNATORY</button>
							<br /> <br />
							<div id="signatoriesDataTable" class="row">
								<div class="table-responsive">
									<table class="table table-hover" width="100%">
										<thead>
											<tr style="text-align: center">
												<th>#</th>
												<th>user_id</th>
												<th>Name</th>
												<th>Title</th>
												<th>Region</th>
												<th></th>
											</tr>
										</thead>
									</table>
								</div>
							</div> <br />
						</div>
					</div>
				</fieldset>
				<br />
			</div>
		</div>
	</div>
</div>

</div> <!-- Header Wrapper End -->

<script>
$(document).ready(function(){

	function setDataTables (tableID, tableData, columns) {
		let table = tableID.find('table').DataTable( {
			lengthMenu: [ [5, 15, -1], [5, 15, "All"] ],
			dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-1'<'region_slct'>><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			language: {
				"infoFiltered": "",
				processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
			},
			serverSide: true,
			processing: true,
			responsive: true,
			scrollX: true,
			ajax: {
				"url": "<?=base_url('payment/table_data/')?>"+tableData,
				"type": 'POST',
			},
			columns: columns
		} );

		tableID.find("div.search_bar").html('<input class="search_bar search_fld form-control form-control-sm" />');
		tableID.find("div.search_btn").html('<button class="search_btn search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span class="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

		tableID.find(".search_btn").on('click', function () {
			console.log(tableID.find(".search_bar").val());
			table.settings()[0].jqXHR.abort();
			table.search(tableID.find(".search_bar").val()).draw();
			tableID.find('.search_spinner').show();
			tableID.find(".search_fld").prop('disabled', true);
		});

		table.on( 'draw', function () {
			tableID.find('.search_spinner').hide();
			tableID.find(".search_fld").prop('disabled', false);
		} );

		tableID.find('tbody').on( 'click', 'a.deletebtn', function () {
			var data = table.row( $(this).parents('tr') ).data();
			let confirmDelete = window.confirm("Confirm Deletion?");

			if(confirmDelete) {
				var request = $.ajax({
					url: "<?=base_url('payment/form_data/delete_utilities')?>",
					method: 'POST',
					data: { id : data['id'], table: tableData },
					beforeSend: function(jqXHR, settings) {
						$('#dataTable tbody').find('button[type="button"]').attr('disabled','disabled');
					}
				});

				request.done(function(data) {
					table.draw();
					tableID.find('tbody button[type="button"]').attr('disabled',false);
				});

				request.fail(function(jqXHR, textStatus) {
					alert( "Request failed: " + textStatus );
					tableID.find('tbody button[type="button"]').attr('disabled',false);
				});
			}
		} );
	}

	let opCategoriesCols = [
		{ data: "id" },
		{ data: "category" },
		{ data: null, searchable: false, sortable: false,
			"render": function(data, type, row, meta) {
				// <a class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;
				return '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
			}
		}
	];
	setDataTables($('#categoriesDataTable'), 'op_categories', opCategoriesCols);

	let opItemsCols = [
		{ data: "id", visible: false, searchable: false },
		{ data: "item_desciption" },
		{ data: "fund_code" },
		{ data: "account_no" },
		{ data: "amount" },
		{ data: "region" },
		{ data: null, searchable: false, sortable: false,
			"render": function(data, type, row, meta) {
				// <a class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;
				return '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
			}
		}
	];
	setDataTables($('#itemsDataTable'), 'op_item_list', opItemsCols);

	let opSignatoriesCols = [
		{ data: "id", visible: false, searchable: false },
		{ data: "user_id", searchable: false, visible: false },
		{ data: "name" },
		{ data: "title" },
		{ data: "region" },
		{ data: null, searchable: false, sortable: false,
			"render": function(data, type, row, meta) {
				// <a class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;
				return '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
			}
		}
	];
	setDataTables($('#signatoriesDataTable'), 'op_signatories', opSignatoriesCols);

	// ############################  add educational background modal & table functionalities  ####################################### //

	function fieldsetSubmits(modalID, tableID, table) {
		let fieldsetGroup = $('div'+modalID+' fieldset');
		let dataTable = $('div'+tableID).find('table');

		let postData = {};
		fieldsetGroup.find('input, select').each(
			function (index){
				let input = $(this);
				postData[input.attr('name')] = input.val();
			}
		);

		var request = $.ajax({
			url: "<?=base_url('payment/form_data/')?>"+table,
			method: 'POST',
			data: { post : postData },
			beforeSend: function(jqXHR, settings){
				fieldsetGroup.find('input').attr('disabled','disabled');
				fieldsetGroup.find('button').html('loading..').attr('disabled','disabled');
			}
		});

		request.done(function(data) {
			$('div'+tableID).find('table').DataTable().draw();
			dataTable.find('.search_spinner').show();
			dataTable.find(".search_fld").prop('disabled', true);

			fieldsetGroup.find('input').val('').attr('disabled', false);
			fieldsetGroup.find('button').html('Save').attr('disabled', false);

			$('div'+modalID).modal('hide');
		});

		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			fieldsetGroup.find('input').attr('disabled','');
			fieldsetGroup.find('button').html('loading..').attr('disabled','');
		});
	}

	$('#addCategoriesModal button[name="save"]').click(function(){
		fieldsetSubmits('#addCategoriesModal', '#categoriesDataTable', 'op_categories');
	});
	$('#addItemModal button[name="save"]').click(function(){
		fieldsetSubmits('#addItemModal', '#itemsDataTable', 'op_item_list');
	});
	$('#addSignatoriesModal button[name="save"]').click(function(){
		fieldsetSubmits('#addSignatoriesModal', '#signatoriesDataTable', 'op_signatories');
	});

});
</script>
