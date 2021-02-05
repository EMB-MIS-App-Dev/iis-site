<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <div class="container-fluid">
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
          <!-- </div> -->
          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Client List <?= ($_SESSION['region'] == 'CO')? $_SESSION['region'] = 'NCR': $_SESSION['region']; ?></h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="client_list">
                      <thead>
                        <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No.</th>
                        <th>Action</th>
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
<script type="text/javascript">
$(document).ready(function(){
  var userlog = "<?=$this->session->userdata('userid')?>";
    var table = $('#client_list').DataTable({
        responsive: true,
        paging: true,
        "serverSide": true,
        "order": [[ 0, "full_name" ]],
        "ajax": "<?php echo base_url(); ?>Clients/Records/client_list",
        "columns": [
          { "data": "username","searchable": true},
          { "data": "full_name","searchable": true},
          { "data": "email","searchable": true},
          { "data": "contact_no","searchable": true},
          {
            "data": null,
              "render": function(data, type, row, meta){
                if (userlog == 157) {
                    data = "<button class='btn btn-info btn-sm' style='margin-right: 2px;'>View</button><button class='btn btn-info btn-sm' onClick='client_comp_list("+row['client_id']+")' data-toggle='modal' data-target='#client_comp_list_modal' style='margin-right: 2px;'>Companies</button><button class='btn btn-info btn-sm' onClick='resent_client_credentials("+row['client_id']+")'>Resend Credentials</button>";
                }else {
                    data = "<button class='btn btn-info btn-sm' onClick='resent_client_credentials("+row['client_id']+")'>Resend Credentials</button>";
                }

                return data;
              }
          },
        ]
    });



  });
</script>

<div class="modal fade" id="client_comp_list_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1121px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">CLIENTS APPROVED COMPANY - <?= ($_SESSION['region'] == 'CO')? $_SESSION['region'] = 'NCR': $_SESSION['region']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="client_comp_list_container">
          <table class="table table-striped table-bordered table-hover" id="client_list">
            <thead>
              <tr>
                <th>EMB ID</th>
                <th>COMPANY NAME</th>
                <th>CLIENT NAME</th>
                <th>CONTACT NO.</th>
                <th>EMAIL</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody id="comp_data_container">
            </tbody>
          </table>
        </div>
        <hr>
          <div class=" assign_new_comp_container">
            <div class="row">
              <div class="col-md-9">
                <select class="form-control slc_comp_val" name="new_comp" required>
                  <option value="">SELECT NEW COMPANY</option>
                  <?php foreach ($comp_per_reg as $key => $compval): ?>
                    <option value="<?php echo $compval['company_id'] ?>"><?php echo $compval['company_name']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" name="button" class="btn btn-primary" onClick="assign_comp_to_client()" id="assign_comp_to_client_id">ASSIGN</button>
              </div>
              <div class="col-md-2">
                <span id="comp_status" style="color:red;">Unassigned <button class="btn btn-danger remove_new_comp_btn" >X</button></span>
              </div>
            </div>
          </div>
          <div class="new_assign_new_comp_container"></div>
          <div class="col-md-12">
              <button type="submit" name="button" class="btn btn-primary" id="add_new_comp_html">+</button>
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<style media="screen">
#add_new_comp_html{
    margin-top: 9px;
}
.new_assign_new_comp_container .col-md-9{
    margin-top: 9px;
}
.new_assign_new_comp_container .col-md-1{
    margin-top: 9px;
}
.new_assign_new_comp_container .col-md-2{
    margin-top: 9px;
}
</style>
<script type="text/javascript">
  $(document).ready(function(e){
    $('#new_comp_id').selectize();
    $('#add_new_comp_html').on('click',function(){
      var comp_new_data = $('.assign_new_comp_container').html();
      $('.new_assign_new_comp_container').append(comp_new_data);
    });




  })
</script>
