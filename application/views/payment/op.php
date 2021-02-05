

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
									<label>Select an Item</label>
									<select class="form-control" name="item_id" >
										<option value="" selected>-</option>
										<?php
										foreach ($item_list as $key => $item) {
											echo '<option value="'.$item['id'].'">'.$item['item_desciption'].'</option>';
										}
										?>
									</select>
								</div>
								<hr />
								<div class="form-group">
									<div class="row col-md-12">
										<div class="col-md-3">
											<label>Item ID</label>
											<input id="itemId" class="form-control" value="--" disabled />
										</div>
										<div class="col-md-6">
											<label>Item Description</label>
											<input id="itemDesc" class="form-control" value="--" disabled />
										</div>
										<div class="col-md-3
										">
										<label>Fund Code</label>
										<input id="fundCode" class="form-control" value="--" disabled />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row col-md-12">
									<div class="col-md-4">
										<label>Account No.</label>
										<input id="accountNo" class="form-control" value="--" disabled />
									</div>
									<div class="col-md-4">
										<label>Amount <b>per item</b></label>
										<input id="itemAmount" class="allowed-input form-control" type="number" step=".01" value="0" name="item_amount" />
									</div>
									<div class="col-md-4">
										<label>Total Number of Items</label>
										<input class="allowed-input form-control" type="number" min="1" value="1" name="item_count" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-sm" name="save">Add</button>
				</div>
			</fieldset>
		</div>
	</div>
</div>
<!-- #####################################################    MODALS    ################################################################### -->

<div class="col-md-12" style="width: 90%; margin: auto">
	<div class="card shadow">
		<div class="card-body">
			<?=form_open_multipart('payment/main/op_submit', array('id' => 'opForm'))?>
			<fieldset>
				<!-- <legend>Family Background</legend> -->
				<hr />
				<div class="row no-gutters align-items-center justify-content-md-center">
					<div class="col-md-10 mr-2">
						<hr />
						<label>Order of Payment Details</label>
						<hr />
						<div class="row my-auto">
								<div class="row justify-content-md-center col-md-12">
									<div class="col-md-4"> Order of Payment No. </div>
									<div class="col-md-1"> : </div>
									<div class="col-md-4"><?= $user['region'].date('Y')?> - <span id="categorySpan">__</span> - <?=$op_no?></div>
								</div>
								<div class="row justify-content-md-center col-md-12">
									<div class="col-md-4"> Category Type </div>
									<div class="col-md-1"> : </div>
									<div class="col-md-4">
										<select id="categoryType" class="form-control form-control-sm" name="category" required>
											<option value="" selected>_ _</option>
											<?php
												foreach ($categories as $key => $category) {
													echo '<option value="'.strtoupper($category['category']).'">'.$category['category'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="row justify-content-md-center col-md-12">
									<div class="col-md-4"> Transaction No. </div>
									<div class="col-md-1"> : </div>
									<div class="col-md-4"> <input class="form-control form-control-sm" name="trans_no" /> </div>
								</div>
								<div class="row justify-content-md-center col-md-12">
									<div class="col-md-4"> Date </div>
									<div class="col-md-1"> : </div>
									<div class="col-md-4"><?=date('F j, Y')?></div>
								</div>
						</div> <br />
						<div class="row">
							<div class="col-md-12">
								<label>Company / Proponent / Payor Name</label>
								<input class="form-control form-control-sm" name="proponent" />
							</div>
						</div> <br />
						<div class="row">
							<div class="col-md-12">
								<label>Address</label>
								<textarea class="form-control form-control-sm" name="address"></textarea>
							</div>
						</div> <br />
						<hr />
						<label>Item Details</label>
						<hr />
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
						<br /> <br />
						<div class="row">
							<div class="table-responsive">
								<table id="dataTable" class="table table-hover" width="100%">
									<thead>
										<tr style="text-align: center">
											<th>id</th>
											<th>op_no</th>
											<th>account_no</th>
											<th>Item Description</th>
											<th>No. of Items</th>
											<th>Fund Code</th>
											<th>Item Amount</th>
											<th>Total Amount</th>
											<th></th>
										</tr>
									</thead>
								</table>
							</div>
						</div> <br />
						<br />
					</div>
				</div>
			</fieldset>
			<hr />
			<button id="btnSubmit" class="btn btn-success float-right" type="button">Submit</button>
			<br />
			<?=form_close()?>
		</div>
	</div>
</div>
</div>

</div> <!-- Header Wrapper End -->

<script>
$(document).ready(function(){

	$("#btnSubmit").click(function () {
		$('#opForm').submit();
	});

	$('select[name="item_id"]').change( function() {
		let val = $(this);
		let itemGroup = $('div#addItemModal fieldset');

		var request = $.ajax({
			url: "<?=base_url('payment/ajax_data/item_details')?>",
			method: 'POST',
			dataType: 'json',
			data: { item : val.val() },
			success: function(data){
				if(data != '' && data != null) {
					itemGroup.find('#itemId').val(data.id);
					itemGroup.find('#itemDesc').val(data.item_desciption);
					itemGroup.find('#fundCode').val(data.fund_code);
					itemGroup.find('#accountNo').val(data.account_no);
					itemGroup.find('#itemAmount').val(data.amount);
				}
				else {
					itemGroup.find('#itemId').val('--');
					itemGroup.find('#itemDesc').val('--');
					itemGroup.find('#fundCode').val('--');
					itemGroup.find('#accountNo').val('--');
					itemGroup.find('#itemAmount').val(0);
				}
			}
		});
	});

	$('#categoryType').change(function(){
		let cat = $(this);
		if(cat.val() != '' && cat.val() != null) {
			$('#categorySpan').html(cat.val());
		}
		else {
			$('#categorySpan').html('_ _');
		}
	});

	let table = $('#dataTable').DataTable( {
		dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-1'<'region_slct'>><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
		language: {
			"infoFiltered": "",
			processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
		},
		serverSide: true,
		processing: true,
		responsive: true,
		scrollX: true,
		ordering: false,
		ajax: {
			"url": "<?php echo base_url('payment/table_data/op_selected_items'); ?>",
			"type": 'POST',
			"data": { op_no: '<?=$op_no?>' },
		},
		columns: [
			{ data: "id", searchable: false, visible: false },
			{ data: "op_no", searchable: false, visible: false },
			{ data: "account_no", searchable: false, visible: false },
			{ data: "item_desc" },
			{ data: "item_count" },
			{ data: "fund_code" },
			{ data: "item_amount" },
			{ data: "item_total_amount" },
			{ data: null, searchable: false, sortable: false,
				"render": function(data, type, row, meta) {
					return '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
				}
			}
		]
	} );

	$("div.search_bar").html('<input class="search_fld form-control form-control-sm" id="search_bar" />');
	$("div.search_btn").html('<button id="search_btn" class="search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span id="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

	if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes') {
		$("div.region_slct").html($("div#regionSelectionDiv").html());
	}

	$("#search_btn").on('click', function () {
		table.settings()[0].jqXHR.abort()
		table.search($("#search_bar").val()).draw();
		$('#search_spinner').show();
		$(".search_fld").prop('disabled', true);
	});

	table.on( 'draw', function () {
		$('#search_spinner').hide();
		$(".search_fld").prop('disabled', false);
	} );

	$('#regionSelect').change(function() {
		tableData.selected_region = $(this).val();
		table.draw();
	} );


	$('#addItemModal button[name="save"]').click( function() {
		let fieldsetGroup = $('div#addItemModal fieldset');
		let postData = {op_no : '<?=$op_no?>'};

		fieldsetGroup.find('input, select').each(
			function (index){
				let input = $(this);
				postData[input.attr('name')] = input.val();
			}
		);

		var request = $.ajax({
			url: "<?=base_url('payment/form_data/op_selected_items')?>",
			method: 'POST',
			data: { post : postData },
			beforeSend: function(jqXHR, settings){
				fieldsetGroup.find('input').attr('disabled','disabled');
				fieldsetGroup.find('button').html('loading..').attr('disabled','disabled');
			}
		});

		request.done(function(data) {
			table.draw();
			$('#search_spinner').show();
			$(".search_fld").prop('disabled', true);

			fieldsetGroup.find('input.allowed-input').val('').attr('disabled', false);
			fieldsetGroup.find('button').html('Add').attr('disabled', false);
			console.log(data);
			if(data != '' && data != null) {
				fieldsetGroup.find('input[name="item_count"]').val(1);
				fieldsetGroup.find('input[name="item_amount"]').val(0);
				$('div#addItemModal').modal('hide');
			}
		});

		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			fieldsetGroup.find('input.allowed-input').attr('disabled','');
			fieldsetGroup.find('button').html('loading..').attr('disabled','');
		});
	});

	$('#dataTable tbody').on( 'click', 'a.deletebtn', function () {
		var data = table.row( $(this).parents('tr') ).data();
		let confirmDelete = window.confirm("Confirm Deletion?");
		console.log(confirmDelete);

		if(confirmDelete) {
			var request = $.ajax({
				url: "<?=base_url('payment/form_data/delete_op_selected_items')?>",
				method: 'POST',
				data: { id : data['id'], op_no : data['op_no'] },
				beforeSend: function(jqXHR, settings) {
					$('#dataTable tbody').find('button[type="button"]').attr('disabled','disabled');
				}
			});

			request.done(function(data) {
				table.settings()[0].jqXHR.abort()
				table.draw();
				$('#dataTable tbody').find('button[type="button"]').attr('disabled',false);
			});

			request.fail(function(jqXHR, textStatus) {
				alert( "Request failed: " + textStatus );
				$('#dataTable tbody').find('button[type="button"]').attr('disabled',false);
			});
		}
	} );
})
</script>
