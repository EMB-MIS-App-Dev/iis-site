<?php
// phpinfo();
// #####################################################		TEST-ONLY PHP FILE			############################################## //?>

<style>
	.table-responsive {
		font-size: 13px;
	}
	.dt-token {
		width: 30% !important
	}
</style>
<div class="container-fluid">
	<div class="row">

		<div class="col-xl-12 col-lg-12">
			<div class="trans-layout card  mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-import"></i> Outbox Transactions</h6>
					<a class="btn btn-outline-dark" href="#" data-toggle='modal' data-target='#add_transaction_confirm' title='ADD'> <i class="fa fa-plus"> </i>  Add Transaction</a>
				</div>

				<div class="card-body">
					<div class="table-responsive">
						<table id="outbox_table" class="table table-striped table-hover table-bordered" style="width: 100% !important; border: 1px solid gray" cellspacing="0">
							<thead>
								<tr>
									<th>no</th>
									<th> IIS No. </th>
									<!-- <th>Company Name</th>
									<th>EMB ID</th>
									<th>Subject</th>
									<th>Transaction Type</th>
									<th>rcv</th>
									<th>Status</th>
									<th>Action Taken</th>
									<th>mprc</th>
									<th>Date</th>
									<th>Assigned</th>
									<th>Remarks</th>
									<th style="width: 130px">Action</th> -->
								</tr>
							</thead>
						</table>
					</div>
				</div>

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

	var table = $('#outbox_table').DataTable({
		// order: [[0, 'desc'], [1, 'asc']],
		language: {
			"infoFiltered": "",
		},
		serverSide: true,
		processing: true,
		responsive: true,
		ajax: {
			url: "<?=base_url('Dms/Table_Test/outbox_test')?>",
			type: 'POST',
			dataType: 'json',
			data: {'user_token': '<?=$user_token?>' },
		},
		columns: [
			{ "data": "trans_no" },
			{ "data": "token" },
		]
	});

$('#outbox_table tbody').on( 'click', '#viewbtn', function () {
	var data = table.row( $(this).parents('tr') ).data();
	Dms.trans_view( data['trans_no'] );
} );

$('#outbox_table tbody').on( 'click', '#acknowledgebtn', function () {
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

$('#outbox_table tbody').on( 'click', '#disposformbtn', function () {
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


$('#outbox_table tbody').on( 'click', '#disposformblnkbtn', function () {
	var data = table.row( $(this).parents('tr') ).data();

	$.ajax({
		url: Dms.base_url + 'Dms/set_trans_session',
		method: 'POST',
		data: { trans_no : data['trans_no'] },
		success: function() {
			window.open(Dms.base_url + 'Dms/dispositionFormBlank', "_blank");
		}
	});
} );

// $('#outbox_table tbody').on( 'click', '#recallbtn', function () {
//      var data = table.row( $(this).parents('tr') ).data();
// 		$.ajax({
//        url: Dms.base_url + 'Dms/set_trans_session',
//        method: 'POST',
//        data: { trans_no : data['trans_no'] },
// 			 success: function() {
// 				 window.open(Dms.base_url + 'Dms/dispositionFormBlank', "_blank");
// 			 }
//     });
//  } );
} );

</script>
