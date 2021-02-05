<style media="screen">
form#client_login label {
    font-size: 14px !important;
    color: red;
    padding-left: 10px;
}
form#client_login input {
    width: 100% !important;
    font-size: 14px !important;
}

form#est_registration label {
    font-size: 14px !important;
    color: red;
    padding-left: 10px;
}
form#est_registration input,select {
    width: 100% !important;
    font-size: 14px !important;
}

form#est_registration option {
    font-size: 14px !important;
}


form#add_new_establishment_id label {
    font-size: 14px !important;
    color: red;
    padding-left: 10px;
}

form#add_new_establishment_id label {
    font-size: 14px !important;
    color: red;
    padding-left: 10px;
}
form#add_new_establishment_id input[type="text"],select,input[type="email"] {
    width: 100% !important;
    font-size: 14px !important;
}

form#add_new_establishment_id option {
    font-size: 14px !important;
}

</style>
<div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <div class="container-fluid">
          <div class="row">
                    <!-- background: url(https://source.unsplash.com/Mv9hjnEUHR4/600x800);
          background-position: center;
          background-size: cover; -->
                    <div class="col-lg-12">
                      <div class="p-2">
                        <div class="text-center">
                          <h1 class="h4 text-gray-900 mb-4">ADD USER  - SMR  </h1>
                        </div>
                        <!-- <form class="user" id="est_registration" name="est_registration_name" action="User/save_user_data" enctype="multipart/form-data" method="post"> -->
                        <form class="user" action="<?php echo base_url() ?>Clients/Smr/save_user_data" id="est_registration" name="est_registration_name" enctype="multipart/form-data" method="post" novalidate="novalidate">

                          <div class="form-group row">
                            <div class="col-sm-6">
                              <select class="form-control" name="userid" style="border-radius: 25px;height: 48px;" id="user_list">
                                <option value="" disabled="" selected="">-SELECT USER-</option>
                                <?php foreach ($user_list as $key => $ulist): ?>
                                  <option value="<?= $ulist['userid'] ?>" ><?= $ulist['fname']." ".$ulist['sname'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                              <select class="form-control" name="role_id" >
                                <option value="" disabled="" selected="">-User Roles-</option>
                                <?php foreach ($user_roles as $key => $user_val): ?>
                                  <option value="<?= $user_val['role_id'] ?>" ><?= $user_val['role_name'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          <div class="col-sm-2 mb-3 mb-sm-0">
                            <button type="submit" class="btn btn-primary btn-user btn-block" name="button" id="save_user_data_btn">ASSIGN</button>
                          </div>
                          </div>
                          </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">ASSIGNED USERS - SMR (<?= $_SESSION['region'] ?>)</h6>
                                </div>
                                <div class="card-body">
                                  <table class="table table-striped table-bordered table-hover" id="assign_users">
                                    <thead>
                                      <tr>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>User role</th>
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
                          <div class="row">
                              <div class="col-md-12">
                                <div class="card shadow mb-4">
                                  <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">SMR List
                                  </div>
                                  <div class="card-body">

                                              <table class="table table-striped table-bordered table-hover" id="smr_submitted_list">
                                        <thead>
                                            <tr>
                                              <th></th>
                                              <th></th>
                                              <th></th>
                                              <th></th>
                                              <th></th>
                                              <th>Plant Name</th>
                                              <th>Plant Address</th>
                                              <th>Reference No</th>
                                              <th>Date Created</th>
                                              <th>Date Submitted</th>
                                              <th>Pollution Control Officer</th>
                                              <th>Status</th>
                                              <th>Date Evaluated</th>
                                              <th>Evaluator</th>
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resubmit_smr_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
          <div class="modal-header" style="background-color:#018E7F;">
            <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">Submit Smr</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="" id="resubmit_smr_msg" style="font-size: 11px;"></div>

                    <form class="" action="" method="post">


                  <input type="hidden" name="" value="" id="res_smr_id">
                    <input type="date" name="" value="" class="form-control" id='res_smr_id_date' required>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="submit_smr_with_date()">Submit</button>
            <button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
            </form>
        </div>
      </div>
    </div>
  <script type="text/javascript">
$(document).ready(function(e){
  $('#user_list').selectize();
    $("#est_registration").validate({
      rules: {
        userid: "required",
        role_id:  "required",
      },
      messages:{
        userid:     "Select user",
        role_id:     "Specify your user role",

      },
    });
    // for assign users smr
    var table = $('#assign_users').DataTable({
        responsive: true,
        paging: true,
        "serverSide": true,
        "order": [[ 0, "full_name" ]],
        "ajax": "<?php echo base_url(); ?>Clients/Smr/assign_user_list",
        "columns": [
          { "data": "full_name","searchable": true},
          { "data": "email","searchable": true},
          { "data": "role_id","searchable": true},
          {
            "data": null,
              "render": function(data, type, row, meta){
                data = "<button class='btn btn-info btn-sm' style='margin-right: 2px;' onClick=remove_smr_user_right('"+row['userid']+"')><i class='fa fa-trash' aria-hidden='true'></i></button>";
                return data;
              }
          },
        ]
    });
})

// for smr
var user_role = '<?php echo $this->session->userdata('role_id'); ?>';
var table1 = $('#smr_submitted_list').DataTable({
    responsive: true,
    paging: true,
    "serverSide": true,
    // "order": [[ 6,"DESC" ]],
    "ajax": "<?php echo base_url('Clients/Serverside/view_admin_smr_list');?>",
    "columns": [
      { "data": 'status_name',"visible": false},
      { "data": 'city_name',"visible": false},
      { "data": 'province_name',"visible": false},
      { "data": 'barangay_name',"visible": false},
      { "data": 'company_name',"visible": false},
      {
          "data": null,'ClassName':'btn-group','searchable': true,
            "render": function(data, type, row, meta){
                data = "<a href='<?php echo base_url(); ?>main/get_smr_module_data/"+row['smr_id']+"/1' target='_blank'>"+row['company_name']+"</a>";
              return data;
            }
        },
      { "data": 'province_name', "searchable": true},
      { "data": 'ref_no',"searchable": true},
      { "data": 'date_created',"searchable": true},
      { "data": 'date_submitted',"searchable": true},
      { "data": 'pco',"searchable": true},
      // { "data": 'status_name',"searchable": true},
      {
          "data": null,'ClassName':'btn-group','searchable': true,
            "render": function(data, type, row, meta){

              if (row['status_name'] == 'Deficient' ) {
                data = "<a tag='"+row['status_name']+"' data-id='"+row['status_name']+"' id='edit_btn' href='#' style='color:#000;' data-toggle='modal' data-target='#viewdeficientdataModal' onClick='Main.view_deficient("+row['smr_id']+")'>"+row['status_name']+"</a>";
              }else {
                data = row['status_name'];
              }
              return data;
            }
        },
      { "data": 'date_evaluated',"searchable": true},
      { "data": 'evaluator',"searchable": true},
      {
          "data": null,'ClassName':'btn-group',
            "render": function(data, type, row, meta){
              if (user_role == 1 ) {
                data = "<a tag='"+row['smr_id']+"' data-id='"+row['smr_id']+"' id='edit_btn' href='<?php echo base_url(); ?>main/get_smr_module_data/'"+row['smr_id']+"'/1' target='_blank' style='color:#000;'><i class='fa fa-edit fa-fw'></i></a>&nbsp;&nbsp;<a tag='"+row['smr_id']+"' data-id='"+row['smr_id']+"' id='del_btn' href='#' style='color:#000;'><i class='fa fa-trash-o fa-fw'></i></a>";
              }else {
                data = "<a data-toggle='modal' data-target='#resubmit_smr_modal'  href='' style='color:#000;' onClick='submit_smr_by_admin("+row['smr_id']+")' title='resubmit smr'><i class='fa fa-paper-plane'></i></a>";
              }
              return data;
            }
        },
    ]

});
// end smr
</script>
