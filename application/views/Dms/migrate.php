
<style>
.table-responsive {
	font-size: 13px
}
</style>
<!-- TRANSACTION ADD -->
<div id="migrateNewData" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Migration of New Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('Dms/migrate/migrate_new_data'); ?>" method="POST">
        <div class="modal-body">
            <center><h6 style="color: #000; margin:30px 0px 30px 0px;">Are you sure you want to migrate new data?</h6></center>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-success" name="create_trans_btn" >Yes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" >No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="container-fluid row ">

	<div class="col-xl-12 col-lg-12">
		<div class="trans-layout card shadow mb-4">

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-random"></i> MIGRATE DATA</h6>
				<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#migrateNewData' title='ADD'> <i class="fa fa-plus"> </i>  Migrate New Data</a>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table id="dataTable" class="table table-hover table-striped" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>no</th>
								<th style="width: 90px;"> IIS No. </th>
								<th>Company Name</th>
								<th>EMB ID</th>
								<th>Subject</th>
								<th>Transaction Type</th>
								<th>rcv</th>
								<th>status id</th>
								<th>Status</th>
								<th>Action Taken</th>
								<th>Sender</th>
								<th>Remarks</th>
								<th>Records Location</th>
								<th>Time/Date Closed</th>
								<th style="width: 130px">Action</th>
							</tr>
						</thead>
					</table>
				</div>
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
		'user_region': '<?php echo $user_region; ?>',
		'filter': '<?php echo $trans_filter; ?>',
	};
	var table = $('#dataTable').DataTable({
		dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-4'><'col-sm-12 col-md-1'<'col_filter'>><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
			"url": "<?php echo base_url('Dms/Data_Tables/migrate'); ?>",
			"type": 'POST',
			"data": function ( d ) {
				return  $.extend(d, tableData);
			},
		},
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
			 { "data": "status", "searchable": false, "visible": false},
			 { "data": "status_description"},
			 { "data": "action_taken"},
			 { "data": "sender_name",
				 "render": function(data, type, row, meta) {
					 return data.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
				 }
			 },
			 { "data": "remarks"},
			 { "data": "records_location" },
			 { "data": "date_out"},
			 {
				 "sortable": false,
				 "render": function(data, type, row, meta) {
					 data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal' data-target='.viewTransactionModal'>View</button>&nbsp;";
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

	$('#dataTable tbody').on( 'click', '#viewbtn', function () {
		var data = table.row( $(this).parents('tr') ).data();
		$('#view_transaction_modal').html('<div class="d-flex justify-content-center"> <div class="spinner-border" role="status"> <span class="sr-only">Loading...</span> </div> </div>');
		Dms.trans_view( data['trans_no'] );
	} );
} );
</script>
