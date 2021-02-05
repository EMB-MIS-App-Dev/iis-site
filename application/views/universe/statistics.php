<script>
  window.onload = function () {
      let statYearTop = $('#statsYear').val();
      $.ajax({
         url: '/embis/Universe/Ajax_Data_Test/transactionsByRegionChart?year='+statYearTop,
         method: 'POST',
         dataType: 'json',
         success: function(response){
           var dataPoints = [];

           for (var i in response) {
              dataPoints.push( { y: response[i].data, legendText: '['+response[i].code+'] '+response[i].label, indexLabel: response[i].code+" (#percent%)- {y}" } );
           }

          var transPerSecUnitChart = new CanvasJS.Chart("transByRegionChartId",
          {
          	animationEnabled: true,
            legend: {
              verticalAlign: "center",
              horizontalAlign: "right",
              maxWidth: 300
            },
            data: [
              {
                showInLegend: true,
                type: "doughnut",
                dataPoints: dataPoints,
                innerRadius: "50%",
          			percentFormatString: "#0.##",
              }
            ]
          });
          transPerSecUnitChart.render();
         }
      });
      $.ajax({
          url: '/embis/Universe/Ajax_Data_Test/transactionsByDivision?year='+statYearTop,
          method: 'POST',
          dataType: 'json',
          success: function(response){
            var dataPoints = [];

            for (var i in response) {
               dataPoints.push( { y: response[i].data, legendText: '['+response[i].code+'] '+response[i].label, indexLabel: response[i].code+" (#percent%)- {y}" } );
            }

             var transByDivisionChart = new CanvasJS.Chart("transactionsByDivisionDiv",
             {
             	animationEnabled: true,
               legend: {
                 verticalAlign: "center",
                 horizontalAlign: "right",
                 maxWidth: 300
               },
               data: [
                 {
                   showInLegend: true,
                   type: "doughnut",
                   dataPoints: dataPoints,
                   innerRadius: "50%",
             			percentFormatString: "#0.##",
                 }
               ]
             });
             transByDivisionChart.render();
          }
      });
      $.ajax({
          url: '/embis/Universe/Ajax_Data_Test/trans_by_section_unit_chart?year='+statYearTop,
          method: 'POST',
          dataType: 'json',
          success: function(response){
            var dataPoints = [];

            for (var i in response) {
               dataPoints.push( { y: response[i].data, legendText: '['+response[i].code+'] '+response[i].label, indexLabel: response[i].code+" (#percent%)- {y}" } );
            }

             var transBySectionUnitChart = new CanvasJS.Chart("transactionsBySectionUnitDiv",
             {
             	animationEnabled: true,
               legend: {
                 verticalAlign: "center",
                 horizontalAlign: "right",
                 maxWidth: 300
               },
               data: [
                 {
                   showInLegend: true,
                   type: "doughnut",
                   dataPoints: dataPoints,
                   innerRadius: "50%",
             			percentFormatString: "#0.##",
                 }
               ]
             });
             transBySectionUnitChart.render();
          }
    });
  }
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
<label>Year: </label>
<select id="statsYear">
   <?php
      $date_option = 2020;
      echo $year_selected;
      while($date_option <= date('Y')) {
         if($year_selected == $date_option) {
            echo '<option value="'.$date_option.'" selected>'.$date_option.'</option>';
         }
         else {
            echo '<option value="'.$date_option.'">'.$date_option.'</option>';
         }
         $date_option += 1;
      }
   ?>
</select>
<hr />
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
                            <div class="card-body" style="height:350px; overflow: auto; position: relative">
                                <div id="currentInboxCountContainer">
                                    <canvas id="currentInboxCountCanvas"></canvas>
                                </div>
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
      let statYear = $('#statsYear').val();
      $('#statsYear').change(function(){
         let statYr = $(this);
         window.location.href = "/embis/universe/statistics?year="+statYr.val();
      });

      function calcHeight (numOfBars) {
          var maxHeightOfChart = 250;
          var minHeight = 200; //setting the min height of the bar + margin between
          var chartHeight = numOfBars * 15 > maxHeightOfChart ? 15 * numOfBars : maxHeightOfChart;
          document.getElementById("currentInboxCountContainer").style.height = chartHeight.toString()+"px";
          // console.log(chartHeight);
      }

      $.ajax({
          url: '/embis/Universe/Ajax_Data_Test/statisticsHeader?year='+statYear,
          method: 'POST',
          dataType: 'json',
          success: function(response) {
            $("#totalTransactionsDiv").attr("title", response.total['full']).html(response.total['short']);
            $("#docsRoutedDiv").attr("title", response.routed['full']).html(response.routed['short']);
            $("#docsCreatedDiv").attr("title", response.created['full']).html(response.created['short']);
         }
      });
      $.ajax({
            url: '/embis/Universe/Ajax_Data_Test/trans_per_month_chart?year='+statYear,
            method: 'POST',
            dataType: 'json',
            success: function(response) {
              let docRouted = response.doc_routed;
              let transRouted = response.trans_routed;
              let docLabel = [];
              let docData = [];
              let transLabel = [];
              let transData = [];

              for (let i in docRouted) {
                  docLabel.push(docRouted[i].label);
                  docData.push(docRouted[i].data);
              }
              for (let i in transRouted) {
                  transLabel.push(transRouted[i].label);
                  transData.push(transRouted[i].data);
              }

              var transPerMonthChart = new Chart($('#transPerMonthCanvas'), {
                  type: 'line',
                  data: {
                  labels: docLabel,
                    datasets: [
                      {
                        label: 'Documents Routed',
                        fill: false,
                        borderColor: "rgb(1,0,76)",
                        lineTension: 0.1,
                        data: docData,
                      },
                      {
                        label: 'Transactions Routed',
                        fill: false,
                        borderColor: "rgb(225,49,67)",
                        lineTension: 0.1,
                        data: transData,
                      }
                    ]
                  },
                  options: {
                    maintainAspectRatio: false,
                  }
              });
           }
      });
      $.ajax({
          url: '/embis/Universe/Ajax_Data_Test/receivedTransactionsPerPersonnel?year='+statYear,
          method: 'POST',
          dataType: 'json',
          success: function(response) {
              let label = [];
              let data = [];

              for (let i in response) {
                label.push(response[i].name);
                data.push(response[i].count);
              }

              let chartdata = {
                  labels: label,
                  datasets: [
                    {
                      label: '# of Transactions',
                      backgroundColor: "rgba(255, 99, 132, 0.2)",
                      borderColor: "rgb(255, 99, 132)",
                      borderWidth: 1,
                      // barThickness: 20,
                      data: data,
                      fill: false,
                    }
                  ]
              };

              var currentInboxCountChart = new Chart( $('#currentInboxCountCanvas'), {
                  type: 'horizontalBar',
                  data: chartdata,
                  options: {
                      scales: {
                        xAxes: [{
                          ticks: {
                              beginAtZero: true,
                              fontFamily: "'Open Sans Bold', sans-serif",
                              fontSize: 11
                          },
                          scaleLabel: {
                              display: false
                          },
                          stacked: false
                        }],
                        yAxes: [{
                          gridLines: {
                              display: false,
                              color: "#fff",
                              zeroLineColor: "#fff",
                              zeroLineWidth: 0
                          },
                          ticks: {
                              fontFamily: "'Open Sans Bold', sans-serif",
                              fontSize: 11
                          },
                          stacked: false
                        }]
                      },
                      legend: {
                          display: false,
                      }
                  },
              });
              // console.log(response.length);
              calcHeight(response.length);
          }
      });
    });
</script>
