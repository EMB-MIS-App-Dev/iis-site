

<link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Begin Page Content -->
  <div class="container-fluid">


    <!-- Content Row -->
    <div class="row">

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">CLIENT INQUIRIES </h6>
            <!-- <button class="btn btn-success btn-icon-split" data-toggle='modal' data-target='#main_ticket'>
                <span class="icon text-white-50">
                  <i class="fa fa-plus"></i>
                </span>
            </button> -->
          </div>

          <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="user_accounts" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Ticket #</th>
                      <th>Client</th>
                      <th>Email</th>
                      <th>Contact #</th>
                      <th>STATUS</th>
                      <th>AGENT</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>

            </div>

        </div>
      </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/support.js"></script> -->
      <!-- <script src="<?php echo base_url(); ?>assets/js/support.js"></script> -->
    <script type="text/javascript">
      $(document).ready(function(){
          $('#user_accounts tr:last td:last').addClass('btn-group');
          var table = $('#user_accounts').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/sp_server_side_data",
              "columnDefs": [
                    { className: "btn-group", "targets": [ 6 ] }
                  ],
              "columns": [
                { "data": "supp_ticket_id","searchable": true},
                { "data": "name","searchable": true},
                { "data": "email","searchable": true},
                { "data": "contact_no","searchable": true},
                {className: "my_class",
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['status'] == 'open') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/>';
                      }else if (row['status'] == 'processing') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/>';
                      }else if (row['status'] == 'solved') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Solved"/>';
                      }
                      return data;
                    }
                },
                { "data": "emb_emp_id","searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['status'] == 'open') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#supp_view_ticket' onClick=view_support_request('"+row['support_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' onClick=process_ticket('"+row['support_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a>";
                      }else if (row['status'] == 'processing') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#supp_view_ticket' onClick=view_support_request('"+row['support_id']+"') title='View'><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' data-toggle='modal' data-target='#supp_add_resolution' onClick=add_resolution('"+row['support_id']+"') ><span class='fa fa-check' style='color:#104E91' title='Mark as solved'></span></i></a><a class='btn btn-sm' href='' onClick=cancel_process_ticket('"+row['support_id']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a>";
                      }else if (row['status'] == 'solved') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#res_supp_view_ticket' onClick=res_view_support_request('"+row['support_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' onClick=send_message_to_client()><span class='fa fa-envelope' style='color:#104E91;'></span></a>";
                      }
                      return data;
                    }
                },
              ]
          });

        });
    </script>
