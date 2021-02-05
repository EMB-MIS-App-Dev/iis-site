<!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">COMPANY LISTS</h6>
                <button type="button" class="btn-primary" name="button" data-toggle='modal' data-target='#comp_export_modal'>EXPORT</button>
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
    <div class="modal fade" id="comp_export_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
          <div class="modal-header" style="background-color:#018E7F;">
            <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">EXPORT TO EXCEL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="" action="<?=base_url()?>Company/Company_list/export_companies_per_region" method="post">
          <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <center><span>Start: </span><input type="input" class="form-control" name="expo_start" required=""></center>
                </div>
                <div class="col-md-6">
                  <center><span>Range (number of entries): </span><input type="input" class="form-control" name="expo_end" required=""></center>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >SUBMIT</button>
          </div>
              </form>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
      var compright = "<?php echo $_SESSION['company_rights'] ?>";
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
              processing: true,
              language: {
                "infoFiltered": "",
                processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
              },
              "serverSide": true,
              "order": [[ 0, "cnt" ]],
              "ajax": "<?php echo base_url(); ?>Company/Complist_server_side/complist_server_side_data",
              "columns": [
                { "data": "cnt","visible": false},
                { "data": "emb_id","searchable": true},
                { "data": "input_date","searchable": true},
                { "data": "company_name","searchable": true},
                  { "data": "establishment_name","searchable": true},
                { "data": "province_name","searchable": true},
                {"data":"category", "searchable": true,
                },
                {"data":"project_name","searchable": true,
                  "render":function(data, type, row, meta){
                    var str  = row['project_name'];
                    if (str.length > 10)
                      str = str.substr(0, 30) + '...';
                      return str;
                  }
                },
                {className: "btn-group",
                  "data": null,targets: "_all",
                    "render": function(data, type, row, meta){
                      if (compright == 'yes') {
                          data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a><a class='btn btn-info btn-sm' href='"+base_url+"Company/Edit_company/data/"+row['company_id']+"' target='_blank'><i class='fas fa-pencil-alt'></i></a><a class='btn btn-info btn-sm' href='#' onclick=delete_company('"+row['token']+"')><i class='fa fa-trash' aria-hidden='true'></i></a>";

                      }else {
                          data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a>";
                      }

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
         })
     });
   </script>
   <?php endif; ?>
