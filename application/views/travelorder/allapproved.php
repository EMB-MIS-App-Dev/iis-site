    <link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <div class="container-fluid">
      <div class="row">

        <!-- DATATABLES Card -->
        <div class="col-xl-12 col-lg-12">
          <div class="trans-layout card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plane"></i> TRAVEL ORDER - All Approved</h6>
              <button type="button" class="btn btn-success btn-sm" data-toggle='modal' data-target='#exportdata' style="float: right;margin-right:5px;">EXPORT TO EXCEL</button>
            </div>

            <!-- Card Body -->
            <div class="card-body">

              <div class="table-responsive" style="zoom:80%;">
                <table id="allapproved_all_trans_travel" class="table table-hover table-striped table-responsive-custom" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: 150px;"> IIS No. </th>
                      <th style="width: 150px;"> Travel No. </th>
                      <th style="width: 150px;"> Name </th>
                      <th> Departure Date </th>
                      <th> Arrival Date </th>
                      <th style="width: 200px;"> Travel Date </th>
                      <th> Destination </th>
                      <th> Purpose </th>
                      <th>  </th>
                      <th>  </th>
                      <th>  </th>
                      <th>  </th>
                      <th>Receive</th>
                      <th style="width: 70px;">Action</th>
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


    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
          var table = $('#allapproved_all_trans_travel').DataTable({
              responsive: true,
              paging: true,
              language: {
						    infoFiltered: "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
              processing: true,
              "lengthMenu": [[100, 500, 1000], [100, 500, 1000]],
              "serverSide": true,
              "order": [[ 3, "desc", 4, "desc"]],
              "ajax": "<?php echo base_url(); ?>Travel/Serverside_allapproved",
              'columnDefs': [
                {
                    'targets': 0,
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('id', 'iisno');
                    }
                }
              ],
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
                { "data": "travel_purpose","searchable": true},
                { "data": 1,"visible": false},
                { "data": "travel_type","visible": false},
                { "data": "status","visible": false},
                { "data": "cnt","visible": false},
                { "data": "receive", "searchable": false, "visible": false},
                {
                  "data": null,
                    "render": function(data, type, row, meta){

                        data = "<a title='View Travel Information' class='btn btn-info btn-sm' href='#' onclick=view_travel('"+row[1]+"'); data-toggle='modal' data-target='#view_travel'>View</a>";
                        data += "<a style='float:right;margin-right:2px;' title='View Printable Travel' class='btn btn-danger btn-sm ' href='../travel/printto/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";
                        return data;
                    }
                },
              ]
          });

        });
    </script>

    <div class="modal fade" id="exportdata" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="useraccountsModalLabel">Please select departure date range</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action='<?php echo base_url(); ?>Travel/Exportdata' method='POST'>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <label>From:</label>
                  <input type="date" name="from_dt" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label>To:</label>
                  <input type="date" name="to_dt" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success btn-sm">Export</button>
            </div>
            </form>
        </div>
      </div>
    </div>
