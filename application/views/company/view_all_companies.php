<!-- Begin Page Content -->
  <div class="container-fluid">


    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">VIEW ALL REGISTERED COMPANIES</h6>
          </div>

          <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="region_company_lists" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Emb Id</th>
                      <th>Date Registered</th>
                      <th>Company Name</th>
                        <th>Establishment Name</th>
                      <th>Location</th>
                      <th>Company Category</th>
                      <!-- <th>Company Category</th> -->
                      <th>Project Type</th>

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
    <script type="text/javascript">
      var compright = "<?php echo $_SESSION['company_rights'] ?>";
      var static_user = "<?php echo $_SESSION['userid'] ?>";
      var base_url = "<?php echo base_url() ?>";
      $(document).ready(function(){
        $('table:first tr').each(function() {
         var lasttd=  $(this).find(':last-child').addClass('btn-group');
  //your cod
          });
          var table = $('#region_company_lists').DataTable({
              responsive: true,
              paging: true,
              deferRender: true,
              lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
              pageLength: 10,
              "serverSide": true,
              "order": [[ 0, "cnt" ]],
              "ajax": "<?php echo base_url(); ?>Company/Complist_server_side/view_all_complist_server_side_data",
              "columns": [
                { "data": "cnt","visible": false},
                { "data": "emb_id","searchable": true},
                { "data": "input_date","searchable": true},
                { "data": "company_name","searchable": true},
                  { "data": "establishment_name","searchable": true},
                { "data": "province_name","searchable": true},
                {"data":"category", "searchable": true,
                // {"data":"input_date", "searchable": true,
                },
                {"data":"project_name","searchable": true,
                  "render":function(data, type, row, meta){
                    var str  = row['project_name'];
                    if (str.length > 10)
                      str = str.substr(0, 30) + '...';
                      return str;
                  }
                },
                {
                  "data": null,'ClassName':'btn-group',targets: "_all",
                    "render": function(data, type, row, meta){
                       data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a><a class='btn btn-info btn-sm' href='"+base_url+"Company/Edit_company/data/"+row['company_id']+"' target='_blank'><i class='fas fa-pencil-alt'></i></a>";

                      return data;
                    }
                },
              ]
          });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <?php if ($this->session->flashdata('messsage') != ''): ?>
   <script type="text/javascript">
     $(document).ready(function() {
       Swal.fire({
         icon: 'success',
         title: 'Done!',
         text: '<?php echo $this->session->flashdata('messsage'); ?>',  // title: 'Sweet!',
         // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
         // imageUrl: 'https://unsplash.it/400/200',
         // imageWidth: 400,
         // imageHeight: 200,
         // imageAlt: 'Custom image',
         })
     });
   </script>
   <?php endif; ?>
