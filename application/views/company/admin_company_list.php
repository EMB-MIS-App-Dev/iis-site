<!-- Begin Page Content -->
  <div class="container-fluid">


    <!-- Content Row -->
    <div class="row">

      <!-- Earnings (Monthly) Card Example -->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
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
      </div> -->

      <!-- Earnings (Monthly) Card Example -->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
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
      </div> -->

      <!-- Earnings (Monthly) Card Example -->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
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
      </div> -->

      <!-- Pending Requests Card Example -->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
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
      </div> -->

    </div>

    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">COMPANY LISTS</h6>
          </div>

          <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <div class="col-xl-4" style="margin-bottom: 20px;">
                    <select class="form-control" name="region_id"  id='admin_select_region_id' required>
                      <!-- <select class="form-control" name="region_id"  id='admin_select_region_id' required> -->
                      <option value="">ALL REGION</option>
                      <?php foreach ($region_data as $key => $rgnval): ?>
                        <option value="<?php echo $rgnval['rgnnum']; ?>"><?php echo $rgnval['rgnnam']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <table class="table table-hover" id="admin_company_lists" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Emb Id</th>
                        <th>Date Registered</th>
                      <th>Company Name</th>
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
      $(document).ready(function(){
        initDataTable();
      });

      $("#admin_select_region_id").change(function(){
        initDataTable($(this).val());
      });

      function initDataTable(region = ""){
      var compright = "<?php echo $_SESSION['company_rights'] ?>";
        var table = $('#admin_company_lists').DataTable({
            responsive: true,
            paging: true,
            destroy: true,
            "serverSide": true,
            "order": [[ 0, "cnt" ]],
            "ajax": {
              "url": "<?php echo base_url(); ?>Company/Admin_complist_server_side/admin_complist_server_side_data",
              "data": {
                "rgid": region
              }
            },
            "columns": [
              { "data": "cnt","visible": false},
              { "data": "emb_id","searchable": true},
              { "data": "input_date","searchable": true},
              { "data": "company_name","searchable": true},
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
              {
                  "data": null,'className':'btn-group',
                  "render": function(data, type, row, meta){
                    if (compright == 'yes') {
                      // data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a><a class='btn btn-info btn-sm' href='#' data-controls-modal='comp_edit_data' data-backdrop='static' data-keyboard='false' data-toggle='modal' data-target='#comp_edit_data' onclick=editcompany('"+row['token']+"','"+row['project_type']+"','"+row['province_id']+"','"+row['city_id']+"')><i class='fas fa-pencil-alt'></i></a><a class='btn btn-info btn-sm' href='#' onclick=delete_company('"+row['token']+"')><i class='fa fa-trash' aria-hidden='true'></i></a>";
    data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a><a class='btn btn-info btn-sm' href='"+base_url+"/Company/Edit_company/data/"+row['company_id']+"' target='_blank'><i class='fas fa-pencil-alt'></i></a><a class='btn btn-info btn-sm' href='#' onclick=delete_company('"+row['token']+"')><i class='fa fa-trash' aria-hidden='true'></i></a>";
                    }else {
                        data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a>";
                    }

                    return data;
                  }
              },
            ]
        });

      }


        // function admin_select_region(value){
        //   $.ajax({
        //         url: base_url+"/embis/Company/Admin_complist_server_side/admin_complist_server_side_data?rgid="+value,
        //         type: 'POST',
        //         async : true,
        //         data: {"rgnnum": value},
        //         success:function(response)
        //           {
        //             console.log(response);
        //         $('#admin_company_lists').DataTable().ajax.reload();
        //           }
        //
        //     });
        // }

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
