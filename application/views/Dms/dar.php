		<style>

			#logcount_modaltb td{
				border-bottom: 1px solid black;
			}

		</style>
		<div class="container-fluid">
			<div class="row">


				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Login Count [ <?php echo date("F d, Y"); ?> ]</h6>
            </div>
            <div class="card-body">
              <table class="table table-borderless">
								<tbody id="log_count_tbody"></tbody>
							</table>
            </div>
          </div>
					<div class="col-xl-8 col-lg-7">
						<div class="card shadow mb-4">
							<!-- Card Header - Dropdown -->
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">Monthly Transaction Graph</h6>
							</div>
							<!-- Card Body -->
							<div class="card-body">
								<div class="chart-area">
									<canvas id="myAreaChart"></canvas>
								</div>
							</div>
						</div>
					</div>

					<!-- Pie Chart -->
					<div class="col-xl-4 col-lg-5">
						<div class="card shadow mb-4">
							<!-- Card Header - Dropdown -->
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary"><?php echo date("l - F d, Y"); ?></h6>

							</div>
							<!-- Card Body -->
							<div class="card-body" style="padding-right:0px!important;">

							</div>
						</div>
					</div>

					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> User Activities</h6>

						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive" style="zoom: 85%">
										<table id="uact_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
												<tr>
													<th>id</th>
													<th>fname</th>
													<th>mname</th>
													<th>sname</th>
													<th>suffix</th>
													<th>Personnel</th>
													<th>Div.</th>
													<th>Sec.</th>
													<th>Action Taken</th>
													<th>tno</th>
													<th>Trans #</th>
													<th>mprc</th>
													<th>Trans. Type</th>
													<th>Date|Time Acted</th>
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
					text: '".$swal_arr['text']."',
					type: '".$swal_arr['type']."',
					allowOutsideClick: false,
					customClass: 'swal-wide',
					confirmButtonClass: 'btn-success',
					confirmButtonText: 'Orayts!',
					onOpen: () => swal.getConfirmButton().focus()
				})
			</script>";
		}
	?>
		<script>

			$(document).ready(function() {
				var table = $('#uact_table').DataTable({
						order: [[0, "desc"]],
						language: {
							"infoFiltered": "",
						},
						serverSide: true,
						processing: true,
						responsive: true,
						// "scrollY": 500,
						"scrollX": true,
						ajax: {
								"url": "<?php echo base_url('Dms/Datatables/dar'); ?>",
								"type": 'POST',
								"data": { 'user_region': '<?php echo $user_region; ?>', 'user_func': '<?php echo $user_func; ?>' },
						},
						columns: [
							{ "data": "dar_id", "searchable": false, "visible": false },
							{ "data": "fname", "visible": false },
							{ "data": "mname", "visible": false },
							{ "data": "sname", "visible": false },
							{ "data": "suffix", "visible": false },
							{ "data": "full_name" },
							{ "data": "division" },
							{ "data": "section" },
							{ "data": "action" },
							{ "data": "trans_no", "searchable": false, "visible": false},
							{ "data": "token"},
							{ "data": "multiprc", "searchable": false, "visible": false},
							{ "data": "type_description" },
							{ "data": "date_in" },
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

				$('#uact_table tbody').on( 'click', '#viewbtn', function () {
						var data = table.row( $(this).parents('tr') ).data();
						Dms.view_transaction( data['trans_no'], data['multiprc'] );
				} );

				$.ajax({
						"url": "<?php echo base_url('Dms/data/login_count'); ?>",
						"type": 'POST',
						"data": {'user_token': '<?php echo $user_token; ?>' },
						"dataType": 'json',
						"success": function(data){
							var tbody = '';
							for(var i = 0; i < data.length; i++) {
								tbody += '<tr><td><a data-target=".logCountSectionModal" data-toggle="modal" href=".logCountSectionModal" onclick="dar_logcount_click('+data[i].divno+')">'+data[i].divname+'</a></td><td>'+data[i].maxcnt+'</td></tr>';
							}

							$('#log_count_tbody').html(tbody);
						}
				});
			} );

			function dar_logcount_click(div)
			{
				$.ajax({
						"url": "<?php echo base_url('Dms/data/login_count_modal'); ?>",
						"type": 'POST',
						"data": {'divno': div },
						"dataType": 'json',
						"success": function(data){
							var tbody = '';
							for(var i = 0; i < data.length; i++) {
								tbody += '<tr><td data-toggle="collapse" data-target="#accordion'+data[i].secno+'" class="clickable" onclick = "dar_logcount_accordion('+data[i].secno+', '+div+')">[ '+data[i].maxcnt+' online ] '+data[i].sect+'</td></tr><tr><td><div id="accordion'+data[i].secno+'" class="collapse"></div></td></tr>';
							}

							$('#logcount_modaltb').html(tbody);
						}
				});
			}

			function dar_logcount_accordion(sec, div)
			{
				$.ajax({
							"url": "<?php echo base_url('Dms/data/login_count_accordion'); ?>",
							"type": 'POST',
							"data": {'secno': sec, 'divno': div },
							"dataType": 'json',
							"success": function(data){
								var tbody = '<table class="table table-borderless">';
								if(data) {
									for(var i = 0; i < data.length; i++) {
										tbody += '<tr><td>'+data[i].name+'</td><td>'+data[i].timestamp+'</td></tr>';
									}
								}
								else {
									tbody += '<tr><td>- no data -</td></tr>';
								}

								tbody += '</table>';

								$('#accordion'+sec).html(tbody);
							}
					});
				}
			</script>
