
  <style>
    .chart-legend li span{
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
    }

    .chart-legend{
      height:450px;
      overflow:auto;
    }

    .btn-label { position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
    .btn-labeled {margin-bottom:10px; padding-top: 0;padding-bottom: 0;}
  </style>

<!-- STATS FILTERING -->

<div class="col-xl-12 col-lg-12">
	<div class="card shadow mb-4">
	  <a href="#adnvceFiltering" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="adnvceFiltering">
	    <h6 class="m-0 font-weight-bold text-primary">Advance Filtering:</h6>
	  </a>
    <?=form_open_multipart('dms/documents/process/'.$entry.'/'.$trans_no.'/'.$zxc.'/'.$multi_cntr, array('id' => 'dms_route_form'))?>
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
  			                          <option selected value="">--</option>
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
<!-- STATS FILTERING END -->



<div class="col-xl-12 col-lg-12">
	<div class="card shadow mb-4">
    <div class="card-body">

        <div class="row">

          <div class="col-md-3">
            <div class="row h-100 d-flex">
              <div class="col-md-7 my-auto">
                  <div class="mb-0 font-weight-bold text-gray-800 mx-1">
                    <h1><?=number_format($totalTrans['count'])?></h1>
                  </div>
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transactions</div>
              </div>
              <div class="col-md-5">
                <div class="h-50">
                  <div class="my-auto">
                      <div class="mb-0 font-weight-bold text-gray-800 mx-1">
                        <h5><?=number_format($totalDocs['count'])?></h5>
                      </div>
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Docs Routed</div>
                  </div>
                </div>

                <div class="col-md-12 h-50 my-auto">
                    <div class="mb-0 font-weight-bold text-gray-800 mx-1">
                      <h5><?=number_format($createdDocs['count'])?></h5>
                    </div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Created Docs</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-5">
              <div class="col-md-12 px-1">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"> Transactions per Month</h6>

                  <div class="dropdown no-arrow">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-158px, 19px, 0px);">
                          <!-- <div class="dropdown-header">Dropdown Header:</div>
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <div class="dropdown-divider"></div> -->
                          <a class="dropdown-item" href="#">Export</a>
                          <a class="dropdown-item" href="#">Filter</a>
                      </div>
                  </div>

                </div>
                <div class="card-body" style="height: 350px">
                  <canvas id="trans_per_month_by_div_chart"></canvas>
                </div>
              </div>
          </div>

          <div class="col-md-4">
              <div class="col-md-12 px-1">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Received Transactions per Personnel</h6>
                </div>
                <div class="card-body" style="height:350px; overflow: auto; position: relative">
                    <div id="chcont">
                      <canvas id="myChart123" ></canvas>
                    </div>
                </div>
              </div>
          </div>

          <div class="col-md-6">
              <div class="col-md-12 px-1">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Transactions by Division</h6>
                </div>
                <div class="card-body" >
                    <div class="row" >
                      <!-- <div class="col-md-8"> -->
                        <canvas id="transactionsByDivision" height="300" width="750"></canvas>
                      <!-- </div> -->
                      <!-- <div class="col-md-4" style="overflow: auto">
                        <div id="js-legend-2" class="chart-legend" class=""> </div>
                      </div> -->
                    </div>
                </div>
              </div>

          </div>

          <div class="col-md-6">
            <div class="col-md-12 px-1">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transactions by Section/Unit</h6>
              </div>
              <div class="card-body" >
                  <div class="row" >
                    <div class="col-md-8">
                      <canvas id="trans_by_section_unit_chart"></canvas>
                    </div>
                    <div class="col-md-4" style="overflow: auto">
                      <div id="js-legend" class="chart-legend" class=""> </div>
                    </div>

                    <!-- <div id="chart-wrapper">
                        <canvas id="trans_by_section_unit_chart" width="400" height="400"></canvas>
                    </div> -->
                  </div>
              </div>
            </div>
          </div>

        </div>

    </div>
	</div>
</div>
<!-- STATS FILTERING END -->

</div>

<script>

  $(document).ready(function(){

    function calcHeight (numOfBars) {
        var maxHeightOfChart = 750;
        var minHeight = 200; //setting the min height of the bar + margin between
        var chartHeight = numOfBars * 30 > maxHeightOfChart ? 30 * numOfBars : maxHeightOfChart;
        document.getElementById("chcont").style.height = chartHeight.toString()+"px";
        console.log(chartHeight);
    }

    $.ajax({
      url: '/embis/Universe/Ajax_Data/total_transactions',
      method: 'POST',
      success: function(response) {
        $('#total_transactions_div span').html(response);
      }
    });

   $.ajax({
     url: '/embis/Universe/Ajax_Data/count_of_personnel',
     method: 'POST',
     success: function(response) {
       $('#count_of_personnel_div span').html(response);
     }
   });

   $.ajax({
     url: '/embis/Universe/Ajax_Data/count_of_section_unit',
     method: 'POST',
     success: function(response) {
       $('#count_of_section_unit_div span').html(response);
     }
   });

     function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var trans_by_section_unit = $.ajax({
       url: '/embis/Universe/Ajax_Data_Test/trans_by_section_unit_chart',
       method: 'POST',
       dataType: 'json',
       beforeSend: function(jqXHR, settings){
         console.log('trans_by_section_unit');
       }
     });

   trans_by_section_unit.done(function(response) {
      var label = [];
      // var code = [];
      var data = [];
      var color = [];

      for (var i in response) {
          label.push(response[i].label);
          // code.push(response[i].code);
          data.push(response[i].data);
          color.push(getRandomColor());
      }

      var trans_by_section_unit_chart = new Chart('trans_by_section_unit_chart', {
        type: 'doughnut',
        data: {
            labels: label,
            datasets: [{
                label: 'Total # of Transactions',
                data: data,
                backgroundColor: color,
            }],
        },
        options: {
          responsive: true,
          aspectRatio: 1.2,
          legend: false,
					plugins: {
            datalabels: {
              color: 'white',
  						backgroundColor: 'black',
  						borderColor: 'white',
  						borderRadius: 50,
  						borderWidth: 1,
              clamp: true,
              anchor:'end',
  						display: function(context) {
  							var dataset = context.dataset;
  							var count = dataset.data.length;
  							var value = dataset.data[context.dataIndex];
  							return value > count * 1.5;
  						},
  						// formatter: Math.round
  					}
          }
         },
      });

     document.getElementById('js-legend').innerHTML = trans_by_section_unit_chart.generateLegend();
   });

   trans_by_section_unit.fail(function(jqXHR, textStatus) {
     alert( "Request failed: " + textStatus );
   });

    var trans_by_div = $.ajax({
       url: '/embis/Universe/Ajax_Data_Test/trans_per_month_by_div_chart',
       method: 'POST',
       dataType: 'json',
       beforeSend: function(jqXHR, settings){
        $('#trans_per_month_by_div_chart').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
       }
     });

    trans_by_div.done(function(response) {
      var docRouted = response.doc_routed;
      var transRouted = response.trans_routed;
       var docLabel = [];
       var docData = [];

       var transLabel = [];
       var transData = [];

       for (var i in docRouted) {
           docLabel.push(docRouted[i].label);
           docData.push(docRouted[i].data);
       }

       for (var i in transRouted) {
           transLabel.push(transRouted[i].label);
           transData.push(transRouted[i].data);
       }

       var trans_per_month_by_div_chart = new Chart($('#trans_per_month_by_div_chart'), {
         type: 'line',
         data: {
             labels: docLabel,
             datasets: [{
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
    });

 		trans_by_div.fail(function(jqXHR, textStatus) {
 		  alert( "Request failed: " + textStatus );
 		});

    var xdata2 = $.ajax({
       url: '/embis/Universe/Ajax_Data_Test/receivedTransactionsPerPersonnel',
       method: 'POST',
       dataType: 'json',
       success: function(response) {
          var label = [];
          var data = [];

          for (var i in response) {
              label.push(response[i].name);
              data.push(response[i].count);
          }
          var chartdata = {
              // maintainAspectRatio: false,
              labels: label,
              datasets: [{
                  label: '# of Transactions',
                  backgroundColor: "rgb(1,140,168)",
                  // borderColor: "rgb(1,0,76)",
                  // borderWidth: 2,
                  data: data,
              }]
          };

          var options =
          {
            legend: {
              display: false,
            },
          }

          var ctx1 = document.getElementById('myChart123');
          var myBarChart = new Chart(ctx1, {
            type: 'horizontalBar',
            data: chartdata,
            options: options,
          });
          // calcHeight(response.length);
        }
     });

    var trans_by_division = $.ajax({
       url: '/embis/Universe/Ajax_Data_Test/transactionsByDivision',
       method: 'POST',
       dataType: 'json',
       beforeSend: function(jqXHR, settings){
         console.log('transactionsByDivision');
       }
     });

    trans_by_division.done(function(response) {

      var progress = $('#animationProgress');
       var label = [];
       // var code = [];
       var data = [];
       var color = [];

       for (var i in response) {
           label.push(response[i].label);
           // code.push(response[i].code);
           data.push(response[i].data);
           color.push(getRandomColor());
       }

       var trans_by_division = new Chart($('#transactionsByDivision'), {
         type: 'doughnut',
         data: {
             labels: label,
             datasets: [{
                 label: 'Total # of Transactions',
                 data: data,
                 backgroundColor: color,
             }]
         },
         options: {
           responsive: false,
           pieceLabel: {
              // render: 'label',
              fontColor: '#000',
              position: 'outside',
              segment: true,
              mode: 'value',
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
           legend: {
             position: 'right',
             labels: {
               boxWidth: 20
             }
           },
         },
       });

      // document.getElementById('js-legend-2').innerHTML = trans_by_division.generateLegend();
    });

    trans_by_division.fail(function(jqXHR, textStatus) {
      alert( "Request failed: " + textStatus );
    });


  });
</script>

<script src="<?=base_url('assets/common/canvas-js/canvasjs.min.js')?>"></script>
