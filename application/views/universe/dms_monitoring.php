<style>
	.set_error {
		font-size: 13px;
		color: red;
	}
	table tr, td{
		padding: -10px !important;
	}
	.tttable thead {
	  display:none;
	}
</style>

<div class="container-fluid">
	<div class="row">

		<!-- DATATABLES Card -->
		<div class="col-xl-12 col-lg-12">
			<div class="trans-layout card shadow mb-4">

						<!-- Card Header - Dropdown -->
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"> <i class="fas fa-share-square"></i> DMS Monitoring</h6>

						</div>

						<!-- Card Body -->
							<div class="card-body">

										<div class="data-div ">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-user-inbox" data-toggle="tab" href="#user-inbox" role="tab" aria-controls="user-inbox" aria-selected="true">User Inbox</a>
													<!-- <a class="nav-item nav-link" id="nav-dms-manage" data-toggle="tab" href="#dms-manage" role="tab" aria-controls="dms-manage" aria-selected="false">Manage</a> -->
												</div>
											</nav>
												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="user-inbox" role="tabpanel" aria-labelledby="user-inbox-tab" >

															<div class="row">
																<div class="py-3 col-md-12">

                                  <div class="table-responsive">
                                    <table id="dms-inbox-monitoring-table" class="table table-striped table-hover" width="100%" cellspacing="0">
                                      <thead>
                                        <tr>
                                          <th>token</th>
                                          <th>Title</th>
                                          <th>First</th>
                                          <th>Middle</th>
                                          <th>Last</th>
                                          <th>Suffix</th>
                                          <th>Inbox</th>
                                          <th></th>
                                        </tr>
                                      </thead>
                                    </table>
																	</div>

                                </div>
															</div>

														</div>
														<div class="tab-pane fade show" id="dms-manage" role="tabpanel" aria-labelledby="dms-manage-tab"> </div>
												</div>
										</div>

							</div>

        </div>
      </div>
    </div>
  </div>

</div> <!-- Header Wrapper End -->

<div id="trans_region_selection" hidden>
	<select id="trans_regional_filter" class="form-control" name="trans_region_filter">
		<?php
			foreach ($region as $key => $value) {
				if($value['rgnnum'] == $user['region']) {
					echo '<option value="'.$value['rgnnum'].'" selected>'.$value['rgnname'].'</option>';
				}
				else {
					echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
				}
			}
		?>
	</select>
</div>

<script>

	$(document).ready(function() {

			var tableData = {
				'user_region': '<?php echo $user['region']; ?>',
				// 'filter': '<?php echo $trans_filter; ?>',
			};
	    var table = $('#dms-inbox-monitoring-table').DataTable({
          dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-5'><'col-sm-12 col-md-2'f><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          order: [[6, "desc"]],
	        serverSide: true,
	        processing: true,
	        responsive: true,
					language: {
						"infoFiltered": "",
					},
	        ajax: {
	            "url": "<?php echo base_url('Universe/Data_Tables/dms_monitoring'); ?>",
	            "type": 'POST',
              "data": function (d) {
                        return $.extend(d, tableData);
                    }
	        },
	        columns: [
						{ "data": "token", "searchable": false, "visible": false },
						{ "data": "title" },
						{ "data": "fname" },
						{ "data": "mname" },
						{ "data": "sname" },
						{ "data": "suffix" },
						{ "data": "total" },
						{
							"sortable": false,
							"render": function(data, type, row, meta) {
								return data = '<a id="dmsInboxMonitoringAnchor" data-toggle="modal" data-target="#dmsInboxMonitoringModal" href="#dmsInboxMonitoringModal"><i class="fas fa-info-circle"></i></a>';
							}
						}
	        ]
	    });

      if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes' || '<?php echo $_SESSION['universe_admin']; ?>' == 'yes')
      {
        $("div.region_slct").html($("div#trans_region_selection").html());
      }

      $('#trans_regional_filter').change(function() {
        tableData.user_region = $('#trans_regional_filter').val();
        table.draw();
      } );

			$('#dms-inbox-monitoring-table tbody').on('click', '#dmsInboxMonitoringAnchor', function(){
				var data = table.row( $(this).parents('tr') ).data();

		    $.ajax({
		       url: '/embis/Universe/Ajax_Data/dms_monitoring_userlist',
		       method: 'POST',
		       data: { token: data['token'] },
				   dataType: 'html',
		       success: function(data) {
		         $('#dmsInboxMonitoringModal #inbox-monitoring').html(data);
		       }
		    });
			});

	} );

</script>
