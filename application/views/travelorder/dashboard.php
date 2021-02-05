    <link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="container-fluid">
      <div class="row">

        <!-- DATATABLES Card -->
        <div class="col-xl-12 col-lg-12">
          <div class="trans-layout card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plane"></i> TRAVEL ORDER</h6>
              <?php if($this->session->userdata('designation') != 'Regional Executive Director'){ ?>
              <div class="col-md-6" style="text-align: center; padding-right: 0px;">
                <a href="#" data-toggle='modal' style="float:right;" data-target='#confirmation_message' class="btn btn-success btn-sm"><i class="fas fa-plane"></i>&nbsp;Apply Travel Order</a>
                <a href="#" data-toggle='modal' style="float:right; margin-right: 5px;" onclick="add_travel_report();" data-target='#travel_report' class="btn btn-success btn-sm"><i class="fas fa-plus"></i>&nbsp;Add Travel Report</a>
              </div>
              <?php } ?>
            </div>

            <!-- Card Body -->
            <div class="card-body">

              <div class="table-responsive" style="zoom:80%;">
                <table id="all_trans_travel" class="table table-hover table-striped table-responsive-custom" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th> multiprc </th>
                      <th> receive </th>
                      <th style="width: 150px;"> IIS No. </th>
                      <th style="width: 150px;"> Travel No. </th>
                      <th> Departure Date </th>
                      <th> Arrival Date </th>
                      <th style="width: 100px;"> Travel Date </th>
                      <th> Destination </th>
                      <th style="width: 400px;"> Purpose </th>
                      <th>  </th>
                      <th>  </th>
                      <th>  </th>
                      <th> Status </th>
                      <th style="width: 100px;"> Status </th>
                      <th>  </th>
                      <th style="width: 150px;">Action</th>
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

    <?php
      $swal_arr = $this->session->flashdata('swal_arr');
      if(!empty($swal_arr)) {
        echo "<script>
          swal({
            title: '".$swal_arr['title']."',
            text: '".$swal_arr['text']."',
            type: '".$swal_arr['type']."',
            allowOutsideClick: false,
            customClass: 'swal-wide',
            confirmButtonClass: 'btn-success',
            confirmButtonText: 'Confirm',
            onOpen: () => swal.getConfirmButton().focus()
          })
        </script>";
      }
    ?>


    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript">
      $(document).ready(function(){
          var table = $('#all_trans_travel').DataTable({
              responsive: true,
              paging: true,
              language: {
						    infoFiltered: "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
              processing: true,
              "serverSide": true,
              "order": [[ 4, "desc"]],
              "ajax": "<?php echo base_url(); ?>Travel/ServersideTO",
              'columnDefs': [
                {
                    'targets': 2,
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('id', 'iisno');
                    }
                }
              ],
              "columns": [
                { "data": "multiprc","searchable": true,"visible": false},
                { "data": "receive","searchable": true,"visible": false},
                { "data": 0,"searchable": true},
                { "data": "toid","searchable": true},
                { "data": "departure_date","searchable": true,"visible": true},
                { "data": "arrival_date","searchable": true,"visible": true},
                {
                  "data": null,"visible": false,
                    "render": function(data, type, row, meta){

                        data = row['departure_date']+" - "+row['arrival_date'];

                      return data;
                    }
                },
                { "data": "destination","searchable": true},
                { "data": "travel_purpose","searchable": true},
                { "data": 1,"visible": false},
                { "data": "travel_type","visible": false},
                { "data": "status","visible": false},
                { "data": "cnt","visible": false},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                        data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                      }else if(row['status'] == 'Disapproved'){
                        data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/error.png' height='25' width='25'><span style='color:red;'>"+row['status']+"</span>";
                      }else if(row['status'] == 'On-Process'){
                        data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                      }
                      return data;
                    }
                },
                { "data": "status_description","visible": false},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                          data ="<a title='View Travel Information' class='btn btn-info btn-sm' href='#' onclick=view_travel('"+row[1]+"'); data-toggle='modal' data-target='#view_travel'>View</a>";
                        if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                            data += "&nbsp;<a title='View Printable Travel' class='btn btn-danger btn-sm' href='../travel/printto/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";

                            if(row['cnt'] != null){ //if with ticket
                              data += "&nbsp;&nbsp;<a title='View Printable Travel' class='btn btn-danger btn-sm' href='../Travel/PrintAir/index/"+row[1]+"' target='_blank'><span class='fa fa-plane'></span></a>";
                            }

                            if(row['travel_report_route_no'] != ''){
                              data += '<div class="dropdown"><button class="btn btn-info btn-sm dropdown-toggle" style="font-size:10pt; margin-top:5px;" onclick=trvlrprtattchmnt("'+row[1]+'","'+row[0]+'","'+row['travel_report_route_no']+'"); type="button" data-toggle="dropdown">Travel Report<span class="caret"></span></button><ul class="dropdown-menu action"><div id="trvlrprtattchmntbody'+row[0]+'"></div></ul></div>';
                            }

                        }else{
                          if(row['status_description'] == 'signed document'){
                            data += "&nbsp;<a title='View Printable Travel' class='btn btn-danger btn-sm' href='../travel/printto/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";
                          }
                        }

                        if(row['status'] == 'Disapproved' && row['action_taken'] != 'Acknowledged'){
                            if(row['receive'] == 0){
                              data += "&nbsp;<button type='button' id='rcvbtn' style='font-size:10pt;' class='btn btn-primary btn-sm waves-effect waves-light' data-toggle='modal'  data-target='#receive'>Receive</button>&nbsp;";
                            }else{
                              data += "&nbsp;<a type='button' id='processtravelorder' class='btn btn-success btn-sm waves-effect waves-light' data-toggle='modal' data-target='#process_travelorder' onclick='process_travel("+row['er_no']+");'>Acknowledge</a>";
                            }
                        }

                        return data;
                    }
                },
              ]
          });
          $('#all_trans_travel tbody').on( 'click', '#rcvbtn', function () {
  						var data = table.row( $(this).parents('tr') ).data();
  						var rcv = receive_transaction_travel( $(this), data['er_no'] );
  			        if(rcv == 1) {
  								setTimeout(function(){
  						        table.ajax.reload(null, false);
  						    }, 700);
  							}
  				 } );
        });
    </script>
