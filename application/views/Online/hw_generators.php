
		<div class="container-fluid dttable_container">
			<div class="row">
				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> Hazwaste - Generators</h6>
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
														<th>ID</th>
														<th>Case Handler</th>
														<th>Region</th>
														<th>Province</th>
														<th>Reference Code</th>
														<th>Sub Type</th>
														<th>Accepted At</th>
														<th>Date Issued</th>
														<th>Company</th>
														<th>Address</th>
														<th>Latitude</th>
														<th>Longitude</th>
														<th>PCO Name</th>
														<th>Accreditation No.</th>
														<th>Date of Accreditation</th>
														<th>PCO Email</th>
														<th>Tel. No.</th>
														<th>no_employee</th>
														<th>Code</th>
														<th>PSIC No.</th>
														<th>Descriptions</th>
														<th>Details</th>
														<th>Catalogue</th>
														<th>Nature</th>
														<th>Waste Management Practice</th>
														<th>Products</th>
														<th>Services</th>
														<th>Nature Business</th>
														<th>Permit Name</th>
														<th>Permit No.</th>
														<th>Permit Date Issued</th>
														<th>Permit Date Expiry</th>
														<th>Place of Issuance</th>
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
							"url": '<?=base_url("Online/Table_Data/hw_generators")?>',
							"type": 'POST',
							"data": function ( d ) {
												return  $.extend(d, tableData);
											},
					},
					columns: [
						{ "data": "id" },
						{ "data": "case_handler" },
						{ "data": "region" },
						{ "data": "province" },
						{ "data": "reference_code" },
						{ "data": "sub_type" },
						{ "data": "accepted_at" },
						{ "data": "date_issued" },
						{ "data": "company" },
						{ "data": "address" },
						{ "data": "latitude" },
						{ "data": "longitude" },
						{ "data": "pco_name" },
						{ "data": "pco_accreditation_no" },
						{ "data": "pco_date_of_accreditation" },
						{ "data": "pco_email" },
						{ "data": "telephone_number" },
						{ "data": "no_employee", "searchable": false, "visible": false },
						{ "data": "code" },
						{ "data": "psic_no" },
						{ "data": "description" },
						{ "data": "details" },
						{ "data": "catalogue" },
						{ "data": "nature" },
						{ "data": "waste_mgmt_practice" },
						{ "data": "products" },
						{ "data": "services" },
						{ "data": "nature_business" },
						{ "data": "permit_name" },
						{ "data": "permit_no" },
						{ "data": "permit_date_issued" },
						{ "data": "permit_date_expiry" },
						{ "data": "place_of_issuance" },
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
