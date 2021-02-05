
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> RECORDS</h6>
						</div>
						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="records_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
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

					var tableData = {
						// 'region_filter': $('#trans_regional_filter').val(),
						'user_token': '<?php echo $user_token; ?>',
						'user_region': '<?php echo $user_region; ?>',
						'filter': '<?php echo $trans_filter; ?>',
					};
			    var table = $('#records_table').DataTable({
							// dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-5'><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							order: [[13, "desc"]],
							language: {
						    infoFiltered: "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
			        deferRender: true,
							// "scrollY": 500,
        			"scrollX": true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Data_Tables/records'); ?>",
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
								{ "data": "records_location",
									"render": function(data, type, row, meta) {
										if('<?php echo $user_func["secno"]; ?>' == 77 || '<?php echo $user_func["secno"]; ?>' == 166  || '<?php echo $user_func["secno"]; ?>' == 176  || '<?php echo $user_func["secno"]; ?>' == 195  || '<?php echo $user_func["secno"]; ?>' == 223  || '<?php echo $user_func["secno"]; ?>' == 231 || '<?php echo $user_func["secno"]; ?>' == 232  || '<?php echo $user_func["secno"]; ?>' == 235  || '<?php echo $user_func["secno"]; ?>' == 255  || '<?php echo $user_func["secno"]; ?>' == 27 || '<?php echo $user_func["secno"]; ?>' == 316 || '<?php echo $_SESSION['superadmin_rights'] ; ?>' == 'yes' || '<?php echo $_SESSION['rec_officer'] ; ?>' == 'yes') {
											return data;
										} else {
											return '<i class="fas fa-eye-slash"></i>';
										}
									}
								},
								{ "data": "date_out"},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal' data-target='.viewTransactionModal'>View</button>&nbsp;";
										if('<?php echo $user_func["secno"]; ?>' == 77 || '<?php echo $_SESSION['superadmin_rights'] ; ?>' == 'yes' || '<?php echo $_SESSION['rec_officer'] ; ?>' == 'yes') {
											data += "<button id='updtebtn' type='button' class='btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal' data-target='.updateRecordsModal'>Update</button>&nbsp;";
										}
										return data;
									}
								}
			        ]
			    });

					if('<?php echo $user_token; ?>' == '2895e2156175ba42' || '<?php echo $user_token; ?>' == '2435e21155d1a1b5' || '<?php echo $user_token; ?>' == '1965e1ebd3d5c4af' || '<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes')
					{
						$("div.region_slct").html($("div#trans_region_selection").html());
					}

					$('#trans_regional_filter').change(function() {
	          tableData.user_region = $('#trans_regional_filter').val();
						table.draw();
					} );

			    $('#records_table tbody').on( 'click', '#viewbtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							Dms.view_transaction( data['trans_no'] );
			    } );

					$('#records_table tbody').on( 'click', '#updtebtn', function () {
			        var data = table.row( $(this).parents('tr') ).data();
							$('.updateRecordsModal input#transrec_no').val( data['trans_no'] );
							$('.updateRecordsModal span#transrec_token').html( data['token'] );
			    } );

			} );
			</script>
