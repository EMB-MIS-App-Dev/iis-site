<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <div class="col-md-2">
              <h6 class="m-0 font-weight-bold text-primary">COMPANY LISTS</h6>
            </div>
            <div class="col-md-2" >
                <button type="button" name="button" class="btn-primary btn">Add main company</button>
            </div>
            <div class="col-md-8">

            </div>
          </div>
          <!-- <div class="card-body" id="selected_company">

          </div> -->

          <div class="col-md-12" style="margin-top:10px">
            <div class="row" id="selected_company">
            </div>
          </div>

          <!-- Card Body -->
          <div class="col-xl-4" style="margin-top: 20px;">
              <select class="form-control" name="region_id"  id='admin_select_region_id' required>
                <!-- <select class="form-control" name="region_id"  id='admin_select_region_id' required> -->
                <option value="">ALL REGION</option>
                <?php foreach ($region_data as $key => $rgnval): ?>
                  <option value="<?php echo $rgnval['rgnnum']; ?>"><?php echo $rgnval['rgnnam']; ?></option>
                <?php endforeach; ?>
              </select>
          </div>
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="admin_company_lists" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><input type="checkbox" name="check_all" value="" id="select_all_company"></th>
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

    <style media="screen">
        div.dataTables_wrapper div.dataTables_processing {
         top: 5%;
        }
        th { font-size: 12px; }
        td { font-size: 11px; }
    </style>
    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
    // for getting data of selected companies

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
            columnDefs: [ {
                 orderable: false,
                 targets:   0
             } ],
           order: [[ 1, 'asc' ]],
            "columns": [
              {
                "data": null,
                  "render": function(data, type, row, meta){
                    data = "<input type='checkbox' name='' value='"+row['company_id']+"'> ";
                    return data;
                  }
              },

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
                        data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a><a class='btn btn-info btn-sm' href='"+base_url+"/Company/Edit_company/data/"+row['company_id']+"' target='_blank'><i class='fas fa-pencil-alt'></i></a><a class='btn btn-info btn-sm' href='#' onclick=delete_company('"+row['token']+"')><i class='fa fa-trash' aria-hidden='true'></i></a>";
                    }else {
                        data = "<a class='btn btn-info btn-sm' href='#' onclick=view_company('"+row['token']+"') data-toggle='modal' data-target='#comp_view_data' ><span class='fa fa-eye' style='color:#FFF;'></span></a>";
                    }

                    return data;
                  }
              },
            ]
        });

        $('#select_all_company').on('click', function(){
          var rows = table.rows({ 'search': 'applied' }).nodes();
          $('input[type="checkbox"]', rows).prop('checked', this.checked);
       });

       $("#admin_company_lists").change("input[type='checkbox']",function(e){
        var html = '';
        var company_id = $('input[name^=companies]').map(function(idx, elem) {
          return $(elem).val();
        }).get();

        console.log(company_id);
        table.$('input[type="checkbox"]').each(function(){
            if(this.checked){
              html += '<div class="col-md-5" style="margin-bottom:10px"><input type="text" name="" value="'+table.row( this.closest('tr') ).data().company_name+'" class="form-control"><input type="hidden" name="companies[]" value="'+this.value+'" class="form-control"></div><div class="col-md-1"><button type="button" name="button" class="btn-danger btn"><i class="fa fa-times" aria-hidden="true"></i></button></div>'
              $('#selected_company').append(html);
              }
        });
              // if (this.checked) {
              //
              // }else {
              //   var html = ''
              //       html += '<div class="col-md-5" style="margin-bottom:10px"><input type="text" name="" value="'+table.row( this.closest('tr') ).data().company_name+'" class="form-control"><input type="hidden" name="'+this.name+'" value="'+this.value+'" class="form-control"></div><div class="col-md-1"><button type="button" name="button" class="btn-danger btn"><i class="fa fa-times" aria-hidden="true"></i></button></div>'
              //       $('#selected_company').append(html);
              //
              // }
          // });
       });
      }




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
