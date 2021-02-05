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
            <h5>CLIENT REQUESTS </h5>
            <a target="_blank" href="<?php echo base_url(); ?>uploads/STEPS ON HOW TO APPROVED REQUESTED COMPANIES (EMB PERSONNEL) IN IIS.pdf">USER MANUAL <i class="fa fa-book" aria-hidden="true"></i></a>
          </div>
            <div class="card-body">
              <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item active">
                  <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">FOR APPROVAL</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link " id="u-tab" data-toggle="tab" href="#u" role="tab" aria-controls="u" aria-selected="false">DISAPPROVED</a>
                </li>
              </ul>


              <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                    <div class="table-responsive" style="margin-top: 10px;">

                      <table class="table table-hover" id="draft_company_lists" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Client</th>
                            <th>Establishment</th>
                            <th>Street</th>
                            <th>Baranggay</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade " id="u" role="tabpanel" aria-labelledby="u-tab">
                    <div class="table-responsive" style="margin-top: 10px;">

                      <table class="table table-hover" id="draft_company_lists_disapproved" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Client</th>
                            <th>Establishment</th>
                            <th>Street</th>
                            <th>Baranggay</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
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
    </div>

    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      var userid = '<?php echo $_SESSION['userid']; ?>'
      // console.log(userid);
      var table = $('#draft_company_lists').DataTable({
        responsive: true,
        paging: true,
        destroy: true,
        "serverSide": true,
        "order": [[ 5,"asc" ]],
        // "order": [[ 0, "est_id" ]],
        "ajax": "<?php echo base_url(); ?>Company/Serverside/view_est_list",
        "columns": [
          { "data": "client_name","searchable": true},
          { "data": "establishment","searchable": true},
          { "data": "est_street","searchable": true},
          { "data": '2',"searchable": true},
          { "data": '1',"searchable": true},
          { "data": '3',"searchable": true},
          { "data": 'status',"searchable": true},
          {
            "data": null,'ClassName':'btn-group',
            "render": function(data, type, row, meta){
              if (row['status'] == 'APPROVED') {
                  data = '';
              }else if (row['requested'] == '1') {
                if (row['status'] == 'DISAPPROVED') {
                  data = "<a class='btn btn-info btn-sm' href='#' onclick=delete_est_req('"+row['req_id']+"')><i class='fas fa-trash'></i></a>";

                }else {

                  data = "<a class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#user_id_attch' onclick=view_user_attch('"+row['client_id']+"','"+row['req_id']+"')><i class='fas fa-plus'></i></a><a class='btn btn-info btn-sm' href='#' onclick=delete_est_req('"+row['req_id']+"')><i class='fas fa-trash'></i></a>";
                }

              }else {
                if (row['status'] == 'DISAPPROVED') {
                  data = "<a class='btn btn-info btn-sm' href='#' onclick=delete_est_req('"+row['req_id']+"')><i class='fas fa-trash'></i></a>";

                }else {
                  data = "<a target='_blank' class='btn btn-info btn-sm' href='<?php echo base_url(); ?>Company/Add_drafted_company/drafted_company_data?req_id="+row['req_id']+"'><i class='fas fa-plus'></i></a><a class='btn btn-info btn-sm' href='#' onclick=delete_est_req('"+row['req_id']+"')><i class='fas fa-trash'></i></a>";

                }


              }
              // data = "<a class='btn btn-info btn-sm' href='#' onclick=view_drafted_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' target='_blank' ><span class='fa fa-eye' style='color:#FFF;'></span></a><a class='btn btn-info btn-sm' href='<?php echo base_url(); ?>Company/Add_drafted_company/drafted_company_data?fcid="+row['est_id']+"'><i class='fas fa-plus'></i></a><a data-toggle='modal' data-target='#disapprove_ficility' class='btn btn-info btn-sm' href='#' onclick=disaprove_est('"+row['est_id']+"')><i class='fa fa-times' aria-hidden='true'></i></a>";

              return data;
            }
          },
        ]
      });
      var table1 = $('#draft_company_lists_disapproved').DataTable({
        responsive: true,
        paging: true,
        destroy: true,
        "serverSide": true,
        "order": [[ 5,"asc" ]],
        // "order": [[ 0, "est_id" ]],
        "ajax": "<?php echo base_url(); ?>Company/Serverside/disapproved_company_lists",
        "columns": [
          { "data": "client_name","searchable": true},
          { "data": "establishment","searchable": true},
          { "data": "est_street","searchable": true},
          { "data": '2',"searchable": true},
          { "data": '1',"searchable": true},
          { "data": '3',"searchable": true},
        ]
      });
    });

    </script>
    <style media="screen">
    h2#swal2-title {
    font-size: 0.875em;
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
   <?php if ($this->session->flashdata('messsage') != ''): ?>
  <script type="text/javascript">
    $(document).ready(function() {
      Swal.fire({
        title: 'Company has been successfully added with EMB ID:',
        text: '<?php echo $this->session->flashdata('messsage'); ?>',  // title: 'Sweet!',
        // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
        imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
        imageWidth: 135,
        imageHeight: 50,
        imageAlt: 'Custom image',
        })
        // for validations
        // for main and branch
    });


  </script>
  <?php endif; ?>
