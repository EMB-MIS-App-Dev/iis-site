
		<div class="container-fluid dttable_container">
			<div class="row">
				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">
						<!-- Card Header - Dropdown -->

						<?php // echo $user_token;?>
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> PCB</h6>
						</div>

						<!-- Card Body -->
							<div class="card-body">

								<div class="row" >
									<div class="table-responsive">
										<table id="pcbTable" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
											<thead>
                        <tr>
                          <th>id</th>
                          <th>PCB ID</th>
                          <th>Inventory ID</th>
                          <th>Name of Establishment</th>
                          <th>Region</th>
                          <th>TS</th>
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


<div id="pcbTableRegionDiv" hidden>
  <select id="pcbTableRegionSelection" class="form-control">
    <option value="" selected>--</option>
    <option value="R1">R1</option>
    <option value="R2">R2</option>
    <option value="R3">R3</option>
    <option value="R4A">R4A</option>
    <option value="R4B">R4B</option>
    <option value="R5">R5</option>
    <option value="R6">R6</option>
    <option value="R7">R7</option>
    <option value="R8">R8</option>
    <option value="R9">R9</option>
    <option value="R10">R10</option>
    <option value="R11">R11</option>
    <option value="R12">R12</option>
    <option value="R13">R13</option>
    <option value="RARMM">ARMM</option>
    <option value="RCAR">CAR</option>
    <option value="RNCR">NCR</option>
  </select>
</div>

<script>
  $(document).ready(function() {

			let tableData = {
				'user_region': '<?php echo $user['region']; ?>',
			};

      let pcbTable = $('#pcbTable').DataTable( {
          dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'regionSelect'>><'col-sm-12 col-md-5'><'col-sm-12 col-md-2'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          ajax: {
              "url": '<?=base_url("Online/Pcb/pcb_data?region=").$pcb_table['region']?>',
              "dataSrc": "",
          },
          columns: [
              { "data": "id" },
              { "data": "generated_id" },
              { "data": "pcb_inventoryID", "visible": false },
              { "data": "name_of_establishment" },
              { "data": "region" },
              { "data": "ts" }
          ]
      } );

      $("div.regionSelect").html($("div#pcbTableRegionDiv").html());

      $('#pcbTableRegionSelection').change(function() {
        let rg = $('#pcbTableRegionSelection').val();
        window.location.href = '/embis/Online/Pcb?region='+rg;
      } );
  } );
</script>
