
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> PLANNING - MONITORING REPORT</h6>

						</div>

						<!-- Card Body -->
						<div class="card-body">

							<div class="table-responsive">
								<table id="planning_monreport_table" class="planning-table table table-hover table-striped" width="100%" cellspacing="0">
									<thead>
                    <tr>
                      <th colspan="5"></th>
                      <th colspan="3">Address/Location/Sampling/Ambient Station</th>
                      <th colspan="2">Geographical Coordinates</th>
                      <th colspan="8"></th>
                    </tr>
										<tr>
											<th>EMB ID</th>
											<th>Name of Facility/LGU/Area</th>
                      <th>PSIC Code</th>
                      <th>Project Category</th>
                      <th>Project Category</th>
                      <th>Brgy</th>
                      <th>Municipality</th>
                      <th>Province</th>
                      <th>Longitude</th>
                      <th>Latitude</th>
                      <th>trans_no</th>
                      <th>IIS Transaction</th>
                      <th>Type of Inspection</th>
                      <th>Date of Inspection</th>
                      <th>Type of Issuance</th>
                      <th>Date of Issuance</th>
                      <th>Compliance</th>
                      <th>Remarks</th>
											<th style="width: 50px">Action</th>
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

		<script>

			$(document).ready(function() {
					var tableData = {
						'start_date': '',
						'end_date': '',
					};
					var buttonsData = {
						text: '<i class="fa fas fa-file-excel"></i> Export to Excel',
						customize: function( xlsx ) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                $('row c[r^="B"], row c[r^="D"]', sheet).attr( 's', '55' );
            },
		        exportOptions: {
								modifier: {
								 // order : 'index', // 'current', 'applied','index', 'original'
								 page : 'all', // 'all', 'current'
								 // search : 'none' // 'none', 'applied', 'removed'
								},
								columns: [ 0,1,2,3,5,6,7,8,9,11,12,13,14,15,16,17 ],
		        }
			    };
			    var table = $('#planning_monreport_table').DataTable({
			        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-3'B><'col-sm-12 col-md-5'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			        buttons: [
		            $.extend( true, {}, buttonsData, {
		                extend: 'excelHtml5'
		            } ),
			        ],
			        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 500, 100, "All"]],
							order: [[1, "asc"]],
							language: {
						    "infoFiltered": "",
			          processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
			        serverSide: true,
			        processing: true,
			        responsive: true,
							// "scrollY": 500,
        			scrollX: true,
			        ajax: {
			            "url": "<?php echo base_url('Dms/Data_Tables/planning_monreport'); ?>",
			            "type": 'POST',
									"data": function ( d ) {
			                   		return  $.extend(d, tableData);
											 		},
			        },
			        columns: [
								{ "data": "emb_id"},
								{ "data": "company_name"},
								{ "data": "psi_code_no"},
								{ "data": "full_project_name", searchable: false, visible: false },
								{ "data": "project_name"},
								{ "data": "barangay_name"},
								{ "data": "city_name"},
								{ "data": "province_name"},
								{ "data": "longitude"},
								{ "data": "latitude"},
								{ "data": "trans_no", searchable: false, visible: false },
								{ "data": "token"},
								{ "data": "subject"},
								{ "data": "start_date"},
								{ data: null, render: function(){return '-';} },
								{ data: null, render: function(){return '-';} },
								{ data: null, render: function(){return '-';} },
								{ "data": "status_description"},
								{
									"sortable": false,
									"render": function(data, type, row, meta) {
										data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal' data-target='.viewTransactionModal'>View</button>&nbsp;";
										return data;
									}
								}
			        ]
			    });

				$("div.filter").html('<button id="filterbtn" class="form-control form-control-sm" type="button" data-toggle="modal" data-target=".planningReportFilterModal"><i class="fas fa-filter"></i>Filter Table<span id="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span></button>');

				$('fieldset#planning_report_filter').on('click', 'button[name="filter"]', function() {
          tableData.start_date = $('fieldset#planning_report_filter input[name="start_date"]').val();
          tableData.end_date = $('fieldset#planning_report_filter input[name="end_date"]').val();
					table.draw();
					$('#search_spinner').show();
				} );

				$('fieldset#planning_report_filter').on('click', 'button[name="reset"]', function() {
          tableData.start_date = '';
          tableData.end_date = '';
					table.draw();
					$('#search_spinner').show();
				} );

				table.on( 'draw', function () {
					$('#search_spinner').hide();
				} );

		    $('#planning_monreport_table tbody').on( 'click', '#viewbtn', function () {
		        var data = table.row( $(this).parents('tr') ).data();
						Dms.view_transaction( data['trans_no'] );
				} );
			} );

		</script>
