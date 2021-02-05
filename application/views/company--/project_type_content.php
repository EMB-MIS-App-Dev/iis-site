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
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $project_name[0]['project_name']; ?></h6>
          </div>

          <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="company_lists" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Emb Id:</th>
                      <th>Company Name:</th>
                      <th>Location:</th>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
    $(document).ready(function () {
      var table = $('#company_lists').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax":{
          "url": "<?php echo base_url('Company/Project_type/project_type_content') ?>",
          "dataType": "json",
          "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
             },
          "columns": [
            { "data": "emb_id" },
            // { "data": "company_name" },
            {
            "data": "company_name",
            "render": function(data, type, row, meta){
              console.log(row);
            // console.log(url);
            if(type === 'display'){
            // data = '<a href="'+table.ajax.url()+'proid?='+row['proid']+'">' + data + '</a>';
            data = '<a href="<?php echo base_url('Company/Company_details?compid=') ?>'+row['company_id']+'">' + data + '</a>';
            }
            return data;
            }
          },
            { "data": "location" }
          ]

	    });
    });
</script>
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
