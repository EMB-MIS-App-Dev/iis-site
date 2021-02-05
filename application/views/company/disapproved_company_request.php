<!-- Begin Page Content -->
  <div class="container-fluid">


    <!-- Content Row -->


    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->

          <!-- Card Body -->
          <div class="card-header">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-5">
                    <span>CLIENT REQUESTS - <span style="color:red">DISAPPROVED</span></span>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-3">
                  <a style="float: right;" target="_blank" href="<?php echo base_url(); ?>uploads/STEPS ON HOW TO APPROVED REQUESTED COMPANIES (EMB PERSONNEL) IN IIS.pdf">USER MANUAL <i class="fa fa-book" aria-hidden="true"></i></a>
                </div>
              </div>

            </div>
          </div>
            <div class="card-body">
              <table class="table table-hover" id="draft_company_lists_disapproved"  cellspacing="0">
                <thead>
                  <tr>
                    <th>Evaluator</th>
                    <th>Client</th>
                    <th>Establishment</th>
                    <th>Street</th>
                    <th>Baranggay</th>
                    <th>City/Municipality</th>
                    <th>Province</th>
                    <th>Date submitted</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
      </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      var userid = '<?php echo $_SESSION['userid']; ?>'
      var table1 = $('#draft_company_lists_disapproved').DataTable({
        responsive: true,
        paging: true,
        deferRender: true,
        lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
        pageLength: 10,
        processing:true,
        language: {
          "infoFiltered": "",
          processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
        },
        "serverSide": true,
        "order": [[ 9,"asc" ]],
        // "order": [[ 0, "est_id" ]],
        "ajax": "<?php echo base_url(); ?>Company/Serverside/disapproved_company_lists",
        "columns": [
          { "data": "fname","searchable": true},
          { "data": "client_name","searchable": true},
          { "data": "establishment","searchable": true},
          { "data": "est_street","searchable": true},
          { "data": '2',"searchable": true},
          { "data": '1',"searchable": true},
          { "data": '3',"searchable": true},
          { "data": 'date_created',"searchable": true},
          {
            "data": null,'ClassName':'btn-group',targets: "_all",
              "render": function(data, type, row, meta){
                data = "<a class='btn btn-info btn-sm' href='#'  data-toggle='modal' data-target='#view_disapprove_client_request' onclick=view_disapprove_client_request('"+row['req_id']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a>";
                return data;
              }
          },
            { "data": 'date_created_sort',"visible": false},
        ]
      });
    });

    </script>
