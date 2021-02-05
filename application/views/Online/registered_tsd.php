		<div class="container-fluid dttable_container">
			<div class="row">
				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->

						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> Hazwaste - Treater</h6>
		          <div class="col-md-3" style="float:right;display:flex;padding:0px;">
		            <label style="text-align: right;width:100%;margin: 7px 7px 0px 0px;font-weight: 100">Last Updated:
		              <b><u><?=$data_datetime?></u></b>
		            </label>
		          </div>
						</div>

						<!-- Card Body -->
							<div class="card-body">

									<div class="table-responsive">
										<table id="dataTable" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
                        <tr>
													<th>Application ID</th>
													<th>Case Handler</th>
													<th>Region</th>
													<th>Province</th>
													<th>Sub Type</th>
													<th>Application Type</th>
													<th>Date Application Received</th>
													<th>Expiry Date</th>
													<th>Reference Code</th>
													<th>Date Approved</th>
													<th>Company</th>
													<th>Establishment Name</th>
													<th>Addess</th>
													<th>Latitude</th>
													<th>Longitude</th>

													<th>PCO Name</th>
													<th>PCO Accreditaion No</th>
													<th>PCO Date of Accreditation</th>
													<th>PCO Email</th>
													<th>PCO Tel. No.</th>
													<th>PCO no_employee</th>

													<th>Permit Name</th>
													<th>Permit No.</th>
													<th>Date Issued</th>
													<th>Date of Expiry</th>
													<th>Place of Issuance</th>

							            <th>Waste Code</th>
							            <th>Waste Description</th>
													<th>Category</th>
													<th>Treatment Method</th>
													<th>Descrption Method</th>
													<th>Capacity</th>
													<th>Residual Management</th>
													<th>Total Storage</th>
													<th>Operating Conditions</th>
													<th>Pollution Control</th>
													<th>Name of Disposal</th>
													<th>Disposal Address</th>
													<th>Disposal Facility</th>
                        </tr>
											</thead>
										</table>
									</div>

							</div>
						<!-- Card Body -->

					</div>

				</div>
			</div>
		</div>
</div>

<div id="regionSelectionDiv" hidden>
  <select id="regionSelect" class="form-control">
    <option selected value="">-all-</option>
    <?php
    for($i = 0; $i < count($region_selection); $i++) {
        echo '<option value="'.$region_selection[$i].'">'.$region_selection[$i].'</option>';
      }
    ?>
  </select>
</div>

<script>
  $(document).ready(function() {
			let tableData = {
				'selected_region': '<?=$user['region']?>',
			};

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
					ajax: {
							"url": '<?=base_url("Online/Table_Data/registered_tsd")?>',
							"type": 'POST',
							"data": function ( d ) {
												return  $.extend(d, tableData);
											},
					},
					columns: [
						{ "data": "application_id" },
						{ "data": "case_handler" },
						{ "data": "region" },
						{ "data": "province" },
						{ "data": "sub_type" },
						{ "data": "application_type" },
						{ "data": "date_application_recieved" },
						{ "data": "expiry_date" },
						{ "data": "reference_code" },
						{ "data": "date_approved" },
						{ "data": "company" },
						{ "data": "establish_name" },
						{ "data": "address" },
						{ "data": "latitude" },
						{ "data": "longitude" },
						{ "data": "pco_name" },
						{ "data": "pco_accreditation_no" },
						{ "data": "pco_date_of_accreditation" },
						{ "data": "pco_email" },
						{ "data": "pco_tel_number" },
						{ "data": "no_employee", "searchable": false, "visible": false },
						{ "data": "permit_name" },
						{ "data": "permit_no" },
						{ "data": "permit_date_issued" },
						{ "data": "permit_date_expiry" },
						{ "data": "place_of_issuance" },
            { "data": "waste_code",
							"render": function(data, type, row, meta) {
					      return "<span title='"+data+"'>"+data.slice(0, 15)+"..</span>";
					    }
						},
            { "data": "waste_description",
							"render": function(data, type, row, meta) {
					      return "<span title='"+data+"'>"+data.slice(0, 15)+"..</span>";
					    }
						},
						{ "data": "category" },
						{ "data": "treatment_method" },
            { "data": "description_method",
							"render": function(data, type, row, meta) {
					      return "<span title='"+data+"'>"+data.slice(0, 15)+"..</span>";
					    }
						},
						{ "data": "capacity" },
						{ "data": "residual_management", "searchable": false, "visible": false },
						{ "data": "total_storage" },
						{ "data": "operating_condition" },
						{ "data": "polution_control" },
						{ "data": "name_of_disposal" },
						{ "data": "disposal_address" },
						{ "data": "disposal_capacity" },
					]
			} );

			$("div.search_bar").html('<input class="search_fld form-control form-control-sm" id="search_bar" />');
			$("div.search_btn").html('<button id="search_btn" class="search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span id="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

			if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes')
			{
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
  } );
</script>
