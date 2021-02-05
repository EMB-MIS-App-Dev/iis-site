<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <div class="container-fluid">

          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <div class="col-md-12">
                      <div class="row">

                        <div class="col-md-4">
                          <h6 class="m-0 font-weight-bold text-primary">USER LIST - RESEND HWMS CREDENTIALS</h6>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-5">
                          <select class="form-control" name="" id="sort_by_id">
                            <option value="" selected disabled>SORT BY COMPANY</option>
                            <?php foreach ($sort_by_company as $key => $compval): ?>
                                <option value="<?= $compval['company_id'] ?>"><?= $compval['company_name'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="hwms_resend_email">
                      <thead>
                        <tr>
                        <th>EMB ID</th>
                        <th>COMPANY NAME</th>
                          <th>COMPANY ADDRESS</th>
                        <th>CLIENT NAME</th>
                        <th>CLIENT EMAIL</th>
                        <th>RESEND STATUS</th>
                        <th>ACTION</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                        <td colspan="7" class="dataTables_empty">Loading data from server</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
          <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Footer -->

    </div>
    <?php if ($this->session->flashdata('client_removed_est_msg') != ''): ?>
    <script type="text/javascript">
     $(document).ready(function() {
       Swal.fire({
         title: 'Successfully removed.',
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
    <script type="text/javascript">
    $('#sort_by_id').selectize();
        $(document).ready(function(){
          initDatatable();
        });
        $('#sort_by_id').on('change',function(){
          initDatatable($(this).val());
        })
        function initDatatable(company){
          var table5 = $('#hwms_resend_email').DataTable({
              responsive: true,
              paging: true,
              searching: false,
              destroy: true,
              deferRender: true,
              processing: true,
              language: {
                "infoFiltered": "",
                processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
              },
              lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
              pageLength: 10,
              "serverSide": true,
              // "order": [[ 6,"DESC" ]],
              // <th>EMB ID</th>
              // <th>CLIENT NAME</th>
              // <th>CLIENT EMAIL</th>
              // <th>RESEND STATUS</th>
              // <th>ACTION</th>
              // "ajax": "<?php //echo base_url('Company/Serverside/iis_resend_hwms_credentials');?>",
              "ajax": {
                "url": "<?php echo base_url('Company/Serverside/iis_resend_hwms_credentials');?>",
                "data": {
                  "company": company
                }
              },
              "columns": [
                { "data": 'emb_id',"searchable": true},
                { "data": 'company_name',"searchable": true},
                { "data": 'province_name',"searchable": true},
                { "data": 'client_name',"searchable": true},
                { "data": 'email',"searchable": true},
                { "data": 'status',"searchable": true},
                {
                    "data": null,'ClassName':'btn-group',
                      "render": function(data, type, row, meta){
                            data = "<a onClick='resend_hwms_email("+row['client_req_id']+")'  style='color:#000;cursor:pointer' title='resend credentials' ><i class='fa fa-paper-plane' aria-hidden='true'></i></a>";

                        return data;
                      }
                  },
              ]

          });
        }
    </script>
