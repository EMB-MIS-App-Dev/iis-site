<script>
  // window.onload = function () {
  //     $.ajax({
  //        url: '/embis/Universe/Ajax_Data_Test/transactionsByRegionChart',
  //        method: 'POST',
  //        dataType: 'json',
  //        success: function(response){
  //          var dataPoints = [];
  //
  //          for (var i in response) {
  //             dataPoints.push( { y: response[i].data, legendText: '['+response[i].code+'] '+response[i].label, indexLabel: response[i].code+" (#percent%)- {y}" } );
  //          }
  //
  //         var transPerSecUnitChart = new CanvasJS.Chart("transByRegionChartId",
  //         {
  //         	animationEnabled: true,
  //           legend: {
  //             verticalAlign: "center",
  //             horizontalAlign: "right",
  //             maxWidth: 300
  //           },
  //           data: [
  //             {
  //               showInLegend: true,
  //               type: "doughnut",
  //               dataPoints: dataPoints,
  //               innerRadius: "50%",
  //         			percentFormatString: "#0.##",
  //             }
  //           ]
  //         });
  //         transPerSecUnitChart.render();
  //        }
  //     });
  //     $.ajax({
  //         url: '/embis/Universe/Ajax_Data_Test/transactionsByDivision',
  //         method: 'POST',
  //         dataType: 'json',
  //         success: function(response){
  //           var dataPoints = [];
  //
  //           for (var i in response) {
  //              dataPoints.push( { y: response[i].data, legendText: '['+response[i].code+'] '+response[i].label, indexLabel: response[i].code+" (#percent%)- {y}" } );
  //           }
  //
  //            var transByDivisionChart = new CanvasJS.Chart("transactionsByDivisionDiv",
  //            {
  //            	animationEnabled: true,
  //              legend: {
  //                verticalAlign: "center",
  //                horizontalAlign: "right",
  //                maxWidth: 300
  //              },
  //              data: [
  //                {
  //                  showInLegend: true,
  //                  type: "doughnut",
  //                  dataPoints: dataPoints,
  //                  innerRadius: "50%",
  //            			percentFormatString: "#0.##",
  //                }
  //              ]
  //            });
  //            transByDivisionChart.render();
  //         }
  //     });
  //     $.ajax({
  //         url: '/embis/Universe/Ajax_Data_Test/trans_by_section_unit_chart',
  //         method: 'POST',
  //         dataType: 'json',
  //         success: function(response){
  //           var dataPoints = [];
  //
  //           for (var i in response) {
  //              dataPoints.push( { y: response[i].data, legendText: '['+response[i].code+'] '+response[i].label, indexLabel: response[i].code+" (#percent%)- {y}" } );
  //           }
  //
  //            var transBySectionUnitChart = new CanvasJS.Chart("transactionsBySectionUnitDiv",
  //            {
  //            	animationEnabled: true,
  //              legend: {
  //                verticalAlign: "center",
  //                horizontalAlign: "right",
  //                maxWidth: 300
  //              },
  //              data: [
  //                {
  //                  showInLegend: true,
  //                  type: "doughnut",
  //                  dataPoints: dataPoints,
  //                  innerRadius: "50%",
  //            			percentFormatString: "#0.##",
  //                }
  //              ]
  //            });
  //            transBySectionUnitChart.render();
  //         }
  //   });
  // }
</script>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-left-primary shadow py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase my-auto">
                                  TOTAL TRANSACTIONS</div>
                              <div id="totalTransactionsDiv" class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                          </div>
                          <div class="col-auto">
                              <i class="fab fa-buffer fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-success text-uppercase my-auto">
                                DOCS ROUTED</div>
                              <div id="docsRoutedDiv" class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-danger text-uppercase my-auto">
                                  NEWLY CREATED</div>
                              <div id="docsCreatedDiv" class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                          </div>
                          <div class="col-auto">
                              <i class="far fa-file-alt fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<hr />

<div class="col-md-12">
  	<div class="card shadow mb-4">
    	  <a href="#adnvceFiltering" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="adnvceFiltering">
    	     <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-square"></i> Advance Filtering</h6>
    	  </a>
        <form action="<?=base_url('Universe/Form_Data')?>" method="post">
            <div class="collapse" id="adnvceFiltering" style="">
                <div class="card-body">
                    <div class="row">
              					<div class="col-md-4">

              						<div class="card mb-4 py-3 border-left-primary">
              							<div class="card-header">
              								Date Filter
              							</div>
                            <div class="card-body">

              								<div class="col-md-12 table-responsive">
              									<table class="table table-borderless">
              		                <tbody>
              		                  <tr>
              		                    <td colspan="3">Date Range <hr /></td>
              		                  </tr>
              		                  <tr>
              		                    <td>
              		                      Start Date: <input class="form-control form-control-sm" type="date" name="start_date" />
              		                    </td>
              		                    <td> : </td>
              		                    <td>
              		                      End Date: <input class="form-control form-control-sm" type="date" name="end_date" />
              		                    </td>
              		                  </tr>
              		                </tbody>
              		              </table>
              								</div>

                            </div>
                          </div>

              					</div>
              					<div class="col-md-4">

              						<div class="card mb-4 py-3 border-left-primary">
              							<div class="card-header">
              								Office Filter
              							</div>
                            <div class="card-body">

              								<div class="col-md-12 table-responsive">
              									<table class="table table-borderless">
              		                <tbody>
              		                  <?php if($user_func[0]['func'] == 'Director' || $_SESSION['superadmin_rights'] == 'yes') { ?>
              		                    <tr>
              		                      <td>Region</td>
              		                      <td> : </td>
              		                      <td>
              		                        <select class="form-control form-control-sm" name="region" onchange="Dms.select_region(this.value);">
              		                          <option selected value="">-All-</option>
              		                          <?php
              		                            foreach ($region as $key => $value) {
              		                              echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
              		                            }
              		                          ?>
              		                        </select>
              		                      </td>
              		                    </tr>
              		                  <?php } ?>
              		                  <?php if(in_array($user_func[0]['func'], array('Director', 'Regional Director')) || $_SESSION['superadmin_rights'] == 'yes') { ?>
              		                    <tr>
              		                      <td>Division</td>
              		                      <td> : </td>
              		                      <td>
              		                        <select id="division_id" class="form-control form-control-sm" name="division" onchange="Dms.select_division(this.value);" >
              		                          <option selected value="">--</option>
              		                          <?php
              		                            foreach ($division as $key => $value) {
              		                              echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
              		                            }
              		                          ?>
              		                        </select>
              		                      </td>
              		                    </tr>
              		                  <?php } ?>
              		                  <?php if(in_array($user_func[0]['func'], array('Director', 'Regional Director', 'Division Chief')) || $_SESSION['superadmin_rights'] == 'yes') { ?>
              		                    <tr>
              		                      <td>Section</td>
              		                      <td> : </td>
              		                      <td>
              		                        <select id="section_id" class="form-control form-control-sm" name="section" >
              		                          <option selected value="">--</option>
              		                          <?php
              		                            foreach ($section as $key => $value) {
              		                              echo '<option value="'.$value['secno'].'">'.$value['secname'].'</option>';
              		                            }
              		                          ?>
              		                        </select>
              		                      </td>
              		                    </tr>
              		                  <?php } ?>
              		                    <tr>
              		                      <td>Personnel</td>
              		                      <td> : </td>
              		                      <td>
              		                        <select class="form-control form-control-sm" name="personnel" >
              		                          <option selected value="">--</option>
              		                        </select>
              		                      </td>
              		                    </tr>
              		                </tbody>
              		              </table>
              								</div>

                            </div>
                          </div>

              					</div>
              					<div class="col-md-4">

              						<div class="card mb-4 py-3 border-left-primary">
              							<div class="card-header">
              								Transaction Filter
              							</div>
                            <div class="card-body">

              								<div class="col-md-12 table-responsive">
              									<table class="table table-borderless">
              		                <tbody>
              		                    <tr>
              		                      <td>Type</td>
              		                      <td> : </td>
              		                      <td>
              		                        <select class="form-control form-control-sm" name="personnel" >
              		                          <option selected value="">--</option>
              		                        </select>
              		                      </td>
              		                    </tr>
              		                    <tr>
              		                      <td>Status</td>
              		                      <td> : </td>
              		                      <td>
              		                        <select class="form-control form-control-sm" name="personnel" >
              		                          <option selected value="">--</option>
              		                        </select>
              		                      </td>
              		                    </tr>
              		                </tbody>
              		              </table>
              								</div>

                            </div>
                          </div>

              					</div>
              			</div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-labeled btn-success float-right"><span class="btn-label"><i class="fas fa-filter"></i></span> Filter</button><br />
                </div>
            </div>
        </form>
  	</div>
</div>
<hr />
<!-- STATS FILTERING END -->

<div class="col-md-12">
    <div class="row">
      <div class="col-md-8">
          <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase my-auto">
                                TRANSACTIONS PER MONTH</div>
                            <div style="height: 350px">
                              <canvas id="transPerMonthCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase my-auto">
                                CURRENT INBOX COUNT</div>
                            <div style="min-height: 350px; overflow: auto; position: relative">
                              <canvas id="currentInboxCountCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>
    </div>
</div>
<hr />
<div class="col-md-12">
      <div class="card shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase my-auto">
                            TRANSACTIONS PER REGION</div>
                        <div id="transByRegionChartId" style="height: 350px; width: 100%"></div>
                    </div>
                </div>
            </div>
      </div>
</div>
<hr />
<div class="col-md-12">
      <div class="card shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase my-auto">
                            TRANSACTIONS PER DIVISION</div>
                        <div id="transactionsByDivisionDiv" style="height: 350px; width: 100%"></div>
                    </div>
                </div>
            </div>
      </div>
</div>
<hr />
<div class="col-md-12">
      <div class="card shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase my-auto">
                            TRANSACTIONS PER SECTION / UNIT</div>
                        <div id="transactionsBySectionUnitDiv" style="height: 350px; width: 100%"></div>
                    </div>
                </div>
            </div>
      </div>
</div>


</div> <!-- CLOSING FOR DIV HEADER -->


<script>
    $(document).ready( function () {
      // $.ajax({
      //     url: '/embis/Universe/Ajax_Data_Test/statisticsHeader',
      //     method: 'POST',
      //     dataType: 'json',
      //     success: function(response) {
      //       $("#totalTransactionsDiv").attr("title", response.total['full']).html(response.total['short']);
      //       $("#docsRoutedDiv").attr("title", response.routed['full']).html(response.routed['short']);
      //       $("#docsCreatedDiv").attr("title", response.created['full']).html(response.created['short']);
      //    }
      // });
      // $.ajax({
      //       url: '/embis/Universe/Ajax_Data_Test/trans_per_month_chart',
      //       method: 'POST',
      //       dataType: 'json',
      //       success: function(response) {
      //         let docRouted = response.doc_routed;
      //         let transRouted = response.trans_routed;
      //         let docLabel = [];
      //         let docData = [];
      //         let transLabel = [];
      //         let transData = [];
      //
      //         for (let i in docRouted) {
      //             docLabel.push(docRouted[i].label);
      //             docData.push(docRouted[i].data);
      //         }
      //         for (let i in transRouted) {
      //             transLabel.push(transRouted[i].label);
      //             transData.push(transRouted[i].data);
      //         }
      //
      //         var transPerMonthChart = new Chart($('#transPerMonthCanvas'), {
      //             type: 'line',
      //             data: {
      //             labels: docLabel,
      //               datasets: [
      //                 {
      //                   label: 'Documents Routed',
      //                   fill: false,
      //                   borderColor: "rgb(1,0,76)",
      //                   lineTension: 0.1,
      //                   data: docData,
      //                 },
      //                 {
      //                   label: 'Transactions Routed',
      //                   fill: false,
      //                   borderColor: "rgb(225,49,67)",
      //                   lineTension: 0.1,
      //                   data: transData,
      //                 }
      //               ]
      //             },
      //             options: {
      //               maintainAspectRatio: false,
      //             }
      //         });
      //      }
      // });
      // $.ajax({
      //     url: '/embis/Universe/Ajax_Data_Test/receivedTransactionsPerPersonnel',
      //     method: 'POST',
      //     dataType: 'json',
      //     success: function(response) {
      //         let label = [];
      //         let data = [];
      //
      //         for (let i in response) {
      //           label.push(response[i].name);
      //           data.push(response[i].count);
      //         }
      //
      //         let chartdata = {
      //             aspectRatio: 2,
      //             maintainAspectRatio: true,
      //             labels: label,
      //             datasets: [
      //               {
      //                 label: '# of Transactions',
      //                 backgroundColor: "rgb(1,140,168)",
      //                 data: data,
      //               }
      //             ]
      //         };
      //
      //         var currentInboxCountChart = new Chart( $('#currentInboxCountCanvas'), {
      //             type: 'horizontalBar',
      //             data: chartdata,
      //             options: {
      //                 legend: {
      //                     display: false,
      //                 }
      //             },
      //         });
      //     }
      // });
    });
</script>
