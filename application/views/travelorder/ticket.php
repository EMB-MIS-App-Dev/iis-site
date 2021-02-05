<link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">
  <div class="row">

    <!-- DATATABLES Card -->
    <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plane"></i> <i class="fas fa-ship"></i> TRAVEL TICKET REQUESTS</h6>
        </div>

        <!-- Card Body -->
        <div class="card-body">

          <div class="table-responsive" style="zoom:85%;">
            <table id="all_trans_travel_ticket" class="table table-hover table-striped table-responsive-custom" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width: 150px;"> IIS No. </th>
                  <th> Travel No. </th>
                  <th> Name </th>
                  <th> Departure Date </th>
                  <th> Arrival Date </th>
                  <th style="width: 200px;"> Travel Date </th>
                  <th> Destination </th>
                  <th>  </th>
                  <th> Via </th>
                  <th>  </th>
                  <th>  </th>
                  <th>  </th>
                  <th style="width: 150px;"> Status </th>
                  <th style="width: 130px;">Action</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
        <!-- Card Body -->
      </div>

    </div>

    <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plane"></i> <i class="fas fa-ship"></i> ISSUED TRAVEL TICKETS</h6>
        </div>

        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive" style="zoom:85%;">
            <table id="all_issued_trans_travel_ticket" class="table table-hover table-striped table-responsive-custom" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width: 150px;"> IIS No. </th>
                  <th> Travel No. </th>
                  <th> Name </th>
                  <th> Departure Date </th>
                  <th> Arrival Date </th>
                  <th style="width: 200px;"> Travel Date </th>
                  <th> Destination </th>
                  <th>  </th>
                  <th>  </th>
                  <th>  </th>
                  <th>  </th>
                  <th>  </th>
                  <th style="width: 150px;"> Status </th>
                  <th style="width: 130px;">Action</th>
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
      var table = $('#all_trans_travel_ticket').DataTable({
          language: {
            infoFiltered: "",
            processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
          },
          processing: true,
          responsive: true,
          paging: true,
          "serverSide": true,
          "order": [[ 3, "desc"]],
          "ajax": "<?php echo base_url(); ?>Travel/ServersideTicket",
          'columnDefs': [
            {
                'targets': 0,
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('id', 'iisno');
                }
            }
          ],
          scrollX: true,
          "columns": [
            { "data": 0,"searchable": true},
            { "data": "toid","searchable": true},
            { "data": "name","searchable": true},
            { "data": "departure_date","searchable": true,"visible": false},
            { "data": "arrival_date","searchable": true,"visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){

                    data = row['departure_date']+" - "+row['arrival_date'];

                  return data;
                }
            },
            { "data": "destination","searchable": true},
            { "data": 1,"visible": false},
            { "data": "travel_type","visible": true},
            { "data": "cnt","visible": true},
            { "data": "status","visible": false},
            { "data": "action_taken","visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if(row['status'] == 'Approved'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"/ <br>for ticket issuance</span>";
                  }else if(row['status'] == 'Signed Document'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"/ <br>for ticket issuance</span>";
                  }else if(row['status'] == 'Disapproved'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/error.png' height='25' width='25'><span style='color:red;'>"+row['status']+"</span>";
                  }else if(row['status'] == 'On-Process'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                  }
                  return data;
                }
            },
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if(row['cnt'] == null || row['cnt'] == ''){
                    data = "<a title='View Travel Information' class='btn btn-info btn-sm ' href='#' onclick=view_travel('"+row[1]+"'); data-toggle='modal' data-target='#view_travel'><span class='fa fa-eye'></span></a>&nbsp;<a title='Assign Ticket Details' class='btn btn-warning btn-sm ' href='#' onclick=ticket_travel('"+row[1]+"'); data-toggle='modal' data-target='#ticket_travel'><span class='fa fa-edit'></span></a>&nbsp;<a style='float:right;margin-right:2px;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../Travel/PrintTO/index/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";
                  }else{
                    data = "<a title='View Travel Information' class='btn btn-info btn-sm ' href='#' onclick=view_travel('"+row[1]+"'); data-toggle='modal' data-target='#view_travel'><span class='fa fa-eye'></span></a><a style='float:right;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../Travel/PrintAir/index/"+row[1]+"' target='_blank'><span class='fa fa-plane'></span></a>&nbsp;<a style='float:right;margin-right:2px;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../Travel/PrintTO/index/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";
                  }

                  return data;
                }
            },
          ]
      });

      var table = $('#all_issued_trans_travel_ticket').DataTable({
          language: {
            infoFiltered: "",
            processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
          },
          processing: true,
          responsive: true,
          paging: true,
          "serverSide": true,
          "order": [[ 3, "desc"]],
          "ajax": "<?php echo base_url(); ?>Travel/ServersideTicket/all_issued_ticket",
          'columnDefs': [
            {
                'targets': 0,
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('id', 'iisno');
                }
            }
          ],
          scrollX: true,
          "columns": [
            { "data": 0,"searchable": true},
            { "data": "toid","searchable": true},
            { "data": "name","searchable": true},
            { "data": "departure_date","searchable": true,"visible": false},
            { "data": "arrival_date","searchable": true,"visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){

                    data = row['departure_date']+" - "+row['arrival_date'];

                  return data;
                }
            },
            { "data": "destination","searchable": true},
            { "data": 1,"visible": false},
            { "data": "travel_type","visible": false},
            { "data": "cnt","visible": false},
            { "data": "status","visible": false},
            { "data": "action_taken","visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if(row['status'] == 'Approved'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/approved.gif' height='25' width='25'><span style='color:#41AD49;font-weight:bold;'>"+row['action_taken']+"</span>";
                  }else if(row['status'] == 'Signed Document'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['action_taken']+"</span>";
                  }else if(row['status'] == 'Disapproved'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/error.png' height='25' width='25'><span style='color:red;'>"+row['status']+"</span>";
                  }else if(row['status'] == 'On-Process'){
                    data = "<img src='<?php echo base_url(); ?>uploads/templates/travel/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                  }
                  return data;
                }
            },
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if(row['travel_type'] == 'Air'){
                    var traveltype = "plane";
                  }
                  if(row['travel_type'] == 'Water'){
                    var traveltype = "ship";
                  }
                    data = "<a title='View Travel Information' class='btn btn-info btn-sm ' href='#' onclick=view_travel('"+row[1]+"'); data-toggle='modal' data-target='#view_travel'><span class='fa fa-eye'></span></a>";
                  if(row['cnt'] == null || row['cnt'] == ''){
                    data += "&nbsp;<a title='Assign Ticket Details' class='btn btn-warning btn-sm ' href='#' onclick=ticket_travel('"+row[1]+"'); data-toggle='modal' data-target='#ticket_travel'><span class='fa fa-edit'></span></a>&nbsp;<a style='float:right;margin-right:2px;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../Travel/PrintTO/index/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";
                  }else{
                    data += "<a style='float:right;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../Travel/PrintAir/index/"+row[1]+"' target='_blank'><span class='fa fa-"+traveltype+"'></span></a>&nbsp;<a style='float:right;margin-right:2px;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../Travel/PrintTO/index/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";
                  }

                  return data;
                }
            },
          ]
      });
    });
</script>
