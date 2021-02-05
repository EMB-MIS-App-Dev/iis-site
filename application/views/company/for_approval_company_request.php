<!-- <div class="alert alert-danger" role="alert" >
<b>ATTENTION:</b> This Module is under System/Server Maintenance, <b>Approving of company request is temporarily unavailable. Sorry for the inconvenience.
</div> -->
<!-- Begin Page Content -->
  <div class="container-fluid">
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
                    <span>CLIENT ESTABLISHMENT REQUESTS - <span style="color:orange">FOR APPROVAL</span></span>
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
              <div class="table-responsive">

                <table class="table table-hover" id="draft_company_lists" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Name</th>
                      <th>Establishment</th>
                      <th>Street</th>
                      <th>Baranggay</th>
                      <th>City/Municipality</th>
                      <th>Province</th>
                      <th>Date Submitted</th>
                      <th>Status</th>
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
        processing: true,
        deferRender: true,
        lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
        pageLength: 10,
        "serverSide": true,
        "order": [[ 10,"asc" ]],
        language: {
          "infoFiltered": "",
          processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
        },
        "ajax": "<?php echo base_url(); ?>Company/Serverside/view_est_list",
        "columns": [
          { "data": "username","searchable": true},
          { "data": "client_name","searchable": true},
          { "data": "establishment","searchable": true},
          { "data": "est_street","searchable": true},
          { "data": '2',"searchable": true},
          { "data": '1',"searchable": true},
          { "data": '3',"searchable": true},
          { "data": 'date_created',"searchable": true},
          { "data": 'status',"searchable": true},
          {className: "btn-group",
            "data": null,
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



              return data;
            }
          },
            { "data": 'date_created_sort',"visible": false},
        ]
      });
    });

    </script>
    <style media="screen">
    h2#swal2-title {
    font-size: 0.875em;
    }
    th { font-size: 12px; }
    td { font-size: 11px; }
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
