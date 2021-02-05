<div class="container-fluid dttable_container">
  <div class="row">

    <!-- DATATABLES Card -->
    <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> ECC</h6>
          <div class="col-md-3" style="float:right;display:flex;padding:0px;">
            <label style="text-align: right;width:100%;margin: 7px 7px 0px 0px;font-weight: 100">Last Updated:
              <b><u><?=$data_datetime?></u></b>
            </label>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive">
              <table id="dataTable" class="table" width="100%">
                <thead>
                  <tr>
                    <th>GUID</th>
                    <th>ProjectName</th>
                    <th>Address</th>
                    <th>Municipality</th>
                    <th>Province</th>
                    <th>Region</th>
                    <th>Representative</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th>ReferenceNo</th>
                    <th>DecisionDate</th>
                    <th>RoutedToOffice</th>
                    <th>RoutedTo</th>
                    <th>CreatedDate</th>
                    <th>ProponentName</th>
                    <th>MailingAddress</th>
                    <th>ContactPerson</th>
                    <th>Expr1</th>
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
              "url": "<?php echo base_url('Online/Table_Data/ecc'); ?>",
              "type": 'POST',
              "data": function ( d ) {
                        return  $.extend(d, tableData);
                      },
          },
          columns: [
              { data: "GUID", "visible": false, "searchable": false },
              { data: "ProjectName" },
              { data: "Address" },
              { data: "Municipality" },
              { data: "Province" },
              { data: "Region" },
              { data: "Representative" },
              { data: "Designation" },
              { data: "Status" },
              { data: "ReferenceNo" },
              { data: "DecisionDate" },
              { data: "RoutedToOffice" },
              { data: "RoutedTo" },
              { data: "CreatedDate" },
              { data: "ProponentName" },
              { data: "MailingAddress" },
              { data: "ContactPerson" },
              { data: "Expr1" },
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
