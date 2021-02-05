<link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="container-fluid">
  <div class="row">

    <!-- DATATABLES Card -->
    <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plane"></i> TRAVEL ORDER - For RED's Approval</h6>
        </div>

        <!-- Card Body -->
        <div class="card-body">

          <div class="table-responsive" style="zoom:80%;">
            <table id="forapproval_all_trans_travel" class="table table-hover table-responsive-custom" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width: 200px;"> IIS No. </th>
                  <th> Travel No. </th>
                  <th> Name </th>
                  <th> Departure Date </th>
                  <th> Arrival Date </th>
                  <th style="width: 200px;"> Travel Date </th>
                  <th> Destination </th>
                  <th style="width: 400px;"> Purpose </th>
                  <th>  </th>
                  <th>  </th>
                  <th>  </th>
                  <th>  </th>
                  <th>Receive</th>
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

<script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
      var table = $('#forapproval_all_trans_travel').DataTable({
          responsive: true,
          paging: true,
          language: {
            "infoFiltered": "",
          },
          "serverSide": true,
          "order": [[ 3, "asc", 4, "asc"]],
          "ajax": "<?php echo base_url(); ?>Travel/Serverside_forapproval/red",
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
                  data ="<a title='View Travel Information' class='btn btn-info btn-sm' href='#' onclick=view_travel('"+row[1]+"'); data-toggle='modal' data-target='#view_travel'>View</a>";
                  data += "&nbsp;<a title='View Printable Travel' class='btn btn-danger btn-sm' href='../PrintTO/index/"+row[1]+"' target='_blank'><span class='fa fa-file'></span></a>";

                    return data;
                }
            },
          ]
      });

      $('#forapproval_all_trans_travel tbody').on( 'click', '#rcvbtntravel', function () {
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
