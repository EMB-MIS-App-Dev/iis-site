

<link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Begin Page Content -->
  <div class="container-fluid">


    <!-- Content Row -->
    <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card shadow h-10 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Processing / Not Fixed</div>
                      <div class="h5 mb-0 font-weight-bold text-info text-center">1</div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-2 col-md-6 mb-4">
        <div class="card  shadow h-10 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Open</div>
                <div class="h5 mb-0 font-weight-bold text-info text-center">1</div>
              </div>

            </div>
          </div>
        </div>
      </div>


      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-2 col-md-6 mb-4">
        <div class="card  shadow h-10 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Attended</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 font-weight-bold text-info text-center">1</div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Pending Requests Card Example -->
      <div class="col-xl-2 col-md-6 mb-4">
        <div class="card  shadow h-10 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Solved</div>
                <div class="h5 mb-0 font-weight-bold text-info text-center">18</div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-md-6 mb-4">
        <div class="card  shadow h-10 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Total</div>
                <div class="h5 mb-0 font-weight-bold text-info text-center">18</div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-6 mb-4">
        <div class="card  shadow h-10 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Pending / Cancelled</div>
                <div class="h5 mb-0 font-weight-bold text-info text-center">18</div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Content Row -->

    <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <div class="col-md-12">
                  <div class="row">
                      <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary "><span><i class="fa fa-th-list"> </i></span> Assistance</h6>
                      </div>
                      <div class="col-md-6">

                          <button class="btn btn-success btn-icon-split" data-toggle='modal' data-target='#emb_create_category_assisstance' style="float:right;margin-bottom:10px">
                              <span class="icon ">
                                Create Category
                                <i class="fa fa-plus"></i>
                              </span>
                          </button>
                      </div>
                  </div>
              </div>

            </div>
            <!-- Card Body -->
            <div class="card-body">

              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="emb_category_table_assistance" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Category name</th>
                      <th>Date Added</th>
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
      <!-- <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

            <div class="col-md-12">
              <div class="row">
                <div class="col-md-8">
                    <h6 class="m-0 font-weight-bold text-primary "><span><i class="fa fa-th-list"> </i></span> Hardware </h6>
                </div>

                <div class="col-md-4">
                  <button class="btn btn-success btn-icon-split" data-toggle='modal' data-target='#emb_create_category_borrow' style="float:right;margin-bottom:10px">
                      <span class="icon ">
                        Create Category
                        <i class="fa fa-plus"></i>
                      </span>
                  </button>
                </div>
              </div>
            </div>
          </div>
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="main_cat_hardware_table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Category name</th>
                      <th>Date Added</th>
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
      </div> -->
    </div>
   <!-- for creating category in assistance  -->
    <div class="modal fade" id="emb_create_category_assisstance" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" >
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h7 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Create Category</h7>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="<?php echo base_url('Support/Emb_support/add_assistance_category'); ?>" method="post">
                <div class="modal-body" >
                  <div class="col-md-12">
                    <label for=""> Main category:</label>
                  </div>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="main_cat_assistance" value="" required>
                  </div>
                  <div class="col-md-12">
                    <label for="">Sub category:</label>
                  </div>
                  <div class="col-md-12 subcat_cont" >
                    <input type="text" class="form-control mt-2" name="sub_cat_assistance[]" value="" required>
                  </div>
                  <div class="col-md-12" id="subcat-section">
                    <div class="row">
                      <div class="col-md-2">
                        <button type="button" name="button" class="btn btn-danger" style="margin-top: 6px;" id="subcat_cont_btn_rmv"><i class="fa fa-times"></i></button>
                        <button type="button" name="button" class="btn btn-success" style="margin-top: 6px;" id="subcat_cont_btn"><i class="fa fa-plus"></i></button>
                      </div>
                      <div class="col-md-10">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" >Save</button>
                </div>

            </form>
          </div>
      </div>
    </div>
    <!-- for updating hardware category modal -->
    <div class="modal fade" id="update_main_cat_hardware_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" >
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Edit Category - <span id="selected_main_cat_hardware"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="<?php echo base_url('Support/Emb_support/add_brand_per_hardware_cat'); ?>" method="post">
                <div class="modal-body" >
                  <div class="col-md-12">
                  <!-- <form  action="<?php //echo base_url('Support/Emb_support/add_brand_per_hardware_cat'); ?>" method="post"> -->
                    <input type="hidden" class="form-control" name="main_cat_hardware" value="" id="main_cat_hardware_id">
                  </div>
                  <div class="col-md-12">
                    <label for="">Brands:</label>
                    <select class="form-control" name="selected_brand_per_hardware" onChange="add_brand_per_hardware_cat(this.value)" id="add_brand_per_hardware_cat_id">
                        <option value="">---</option>
                        <option value="0">Add New Brand</option>
                        <option value="1">Acer</option>
                        <option value="2">Dell</option>
                    </select>
                  </div>
                    <div class="col-md-12 new-brand-row" style="display:none">
                        <div class="col-md-4">
                          <label for="">Name:</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="brand_per_hardware[]" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12" id="new-brand-section" style="display:none">
                      <div class="row">
                        <div class="col-md-6">
                          <button type="button" name="button" class="btn btn-success" style="margin-top: 6px;" id="new-brand-btn"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-6">
                          <!-- <button type="submit" name="button" class="btn btn-success" style="margin-top: 6px;float:right" id="save_new-brand">SUBMIT</button> -->
                        </div>
                      </div>
                    </div>

                  <hr>

                  <div class="col-md-12" id="model_per_brand" style="display:none">
                    <label for="">Models from <span id='selected_brand_name'></span>:</label>
                    <select class="form-control" name="" onChange="add_model_per_brand(this.value)" id="models_per_selected_brand">
                      <option value=""> --- </option>
                    </select>
                  </div>
                    <div class="col-md-12 new-model-row" style="display:none">
                        <div class="col-md-4">
                          <label for="">Model no.:</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="add_model_per_brand[]" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12" id="new-model-section" style="display:none">
                      <div class="row">
                        <div class="col-md-6">
                          <button type="button" name="button" class="btn btn-success" style="margin-top: 6px;" id="new-model-btn"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-6">
                          <!-- <button type="button" name="button" class="btn btn-success" style="margin-top: 6px;float:right" id="new-model-btn">SUBMIT</button> -->
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" >Save</button>
                </div>
            </form>
          </div>
      </div>
    </div>
    <!-- for updating assistance category modal -->
    <!-- for updating hardware category modal -->
    <div class="modal fade" id="update_main_cat_assistance_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Category - <span id="selected_main_cat_assistance"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="<?php echo base_url('Support/Emb_support/save_edited_assintance_category'); ?>" method="post">
                <div class="modal-body" >
                    <input type="hidden" class="form-control" name="main_cat_assistance" value="" id="main_cat_assistance_id" >
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-11">
                          <label for="">Category name:</label>
                          <input type="text" name="" value="" class="form-control" id="main_cat_assistance_name">
                          <input type="hidden" name="" value="" class="form-control" id="main_cat_assistance_unq_id">
                        </div>
                        <div class="col-md-1" style="bottom: -32px;">
                          <button class="btn-primary btn" type="button" name="button" style="margin-right: 19px;" onClick="update_main_cat_data()">Update</button>
                        </div>
                      </div>
                    </div>
                    <hr>
                  <!-- </div> -->
                  <div class="col-md-12" style="margin-bottom: 17px;">
                    <div class="row">
                      <div class="col-md-11">
                        <label for="">Add new sub category:</label>
                        <input type="text" name="" value="" class="form-control" id="new_sub_cat">
                      </div>
                      <div class="col-md-1" style="bottom: -32px;">
                        <button class="btn-primary btn" type="button" name="button" style="margin-right: 19px;" onClick="add_new_sub_cat_btn(this)" id="add_new_sub_cat_id">Add</button>
                      </div>
                    </div>
                  </div>
                <div class="col-md-12">
                  <span id="sub_cat_msg_id" class="bg-gradient-success form-control" style="color:white;display:none;text-align:center;margin-bottom:10px"></span>

                    <span id="sub_cat_msg_id_error" class=".bg-gradient-danger form-control" style="color:white;display:none;text-align:center;margin-bottom:10px"></span>
                </div>
                  <div class="col-md-12">

                    <table class="table table-hover" id="table_assistance_specification" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Category name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>

                    <div class="col-md-12 new-sub-cat-assistance-row" style="display:none">
                        <div class="col-md-4">
                          <label for="">Name:</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="sub-cat-assistance[]" value="" class="form-control sub-cat-assistance-class" >
                        </div>
                    </div>

                    <div class="col-md-12" id="sub-cat-assistance-section" style="display:none">
                      <div class="row">
                        <div class="col-md-6">
                          <button type="button" name="button" class="btn btn-success" style="margin-top: 6px;" id="sub-cat-assistance-btn"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-6">
                              <button type="button" name="button" class="btn btn-danger" style="margin-top: 6px;float:right" id="sub-cat-assistance-btn-remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <!-- <button type="submit" class="btn btn-primary" >Save</button> -->
                </div>
            </form>
          </div>
      </div>
    </div>

    <!-- for modal FAQs -->

      <script src="<?php echo base_url(); ?>assets/js/support.js"></script>
      <script src="<?php echo base_url(); ?>assets/common/jquery/jquery.min.js"></script>
    <script type="text/javascript">
      function edit_main_cat_assistance_id(val,el){
      $('#add_new_sub_cat_id').val(val);
      $('#selected_main_cat_assistance').text($(el).closest("tr").find("td:first-child").text());
      $('#main_cat_assistance_name').val($(el).closest("tr").find("td:first-child").text());
      $('#main_cat_assistance_unq_id').val(val);
      var table = $('#table_assistance_specification').DataTable({
        destroy:true,
        responsive: true,
        paging: true,
        deferRender: true,
        // lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
        pageLength: 10,
        processing: true,
        language: {
          "infoFiltered": "",
          processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
        },
        "serverSide": true,
          "ajax": {
            "url": "<?php echo base_url(); ?>Support/Sp_server_side/edit_main_cat_assistance",
            "data": {
              "sp_main_cat_id": val,
            }
          },
          "columns": [
            // { "data": "csdsc","searchable": true},
            {
              "data": null,
                "render": function(data, type, row, meta){
                      data = '<input type="text" class="form-control" value="'+row['csdsc']+'" onkeyup="change_subcat_ass('+row['csno']+',this)">';
                  return data;
                }
            },
            { "data": "status","searchable": true},
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if (row['status'] == 'deleted') {
                      data = "<a class='btn-primary btn' href='' style='height: 29px;font-size: 10px;'>Add FAQs</a><button class='btn-danger btn' type='button' name='button' onClick='update_sub_cat_assistance("+row['csno']+",2)'>Deactivate</button><button class='btn-primary btn' type='button' name='button' onClick='update_sub_cat_assistance("+row['csno']+",1)'>Activate</button>";
                  }else if (row['status'] == 'active') {
                      data = "<a class='btn-primary btn' href='' style='height: 29px;font-size: 10px;'>Add FAQs</a><button class='btn-danger btn' type='button' name='button' onClick='update_sub_cat_assistance("+row['csno']+",2)'>Deactivate</button><button class='btn-danger btn' type='button' name='button' onClick='update_sub_cat_assistance("+row['csno']+",3)'>Delete</button>";
                  }else {
                      data = "<a class='btn-primary btn' href='' style='height: 29px;font-size: 10px;'>Add FAQs</a><button class='btn-danger btn' type='button' name='button' onClick='update_sub_cat_assistance("+row['csno']+",3)'>Delete</button><button class='btn-primary btn' type='button' name='button' onClick='update_sub_cat_assistance("+row['csno']+",1)'>Activate</button>";

                  }

                  return data;
                }
            },
          ]
      });

    }
      $(document).ready(function(){
        $('#subcat_cont_btn_rmv').on('click',function(){
          $(this).parent().parent().parent().prev().remove()
        })
        $subcat = $('.subcat_cont').clone();
        $('#subcat_cont_btn').click(function() {
          $subcat.clone().insertBefore( $('#subcat-section') );
        });
        $newbrand = $('.new-brand-row').clone();
        $('#new-brand-btn').click(function() {
          $newbrand.clone().insertBefore( $('#new-brand-section') );
          $('.new-brand-row').show();
        });

        $newmodel = $('.new-model-row').clone();
        $('#new-model-btn').click(function() {
          $newmodel.clone().insertBefore( $('#new-model-section') );
          $('.new-model-row').show();
        });

        $new_subcat_ass = $('.new-sub-cat-assistance-row').clone();
        $('#sub-cat-assistance-btn').click(function() {
          $new_subcat_ass.clone().insertBefore( $('#sub-cat-assistance-section') );
          $('.new-sub-cat-assistance-row').show();
        });


        $('#faqs_btn_rmv').on('click',function(){
          $(this).parent().parent().parent().prev().remove()
        })
        $faqs = $('.faqs-section-row').clone();
        $('#faqs_btn').click(function() {
          $faqs.clone().insertBefore( $('#faqs-section') );
        });


          var table = $('#emb_category_table_assistance').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/emb_category_data",
              "columns": [
                { "data": "ctype","searchable": true},
                { "data": "date_added","searchable": true},
                // { "data": "status","searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['deleted'] == 1) {
                        data = 'deleted';
                      }else {
                        data = 'active';
                      }
                      return data;
                    }
                },
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['deleted'] == 1) {
                          data = '<button onClick="main_cat_ast_active_inactive('+row['cno']+',0)" class="btn-primary btn" type="button" name="button">Activate</button>';
                      }else {
                          data = '<button class="btn-primary btn" onClick="edit_main_cat_assistance_id('+row['cno']+',this)" type="button" name="button" data-toggle="modal" data-target="#update_main_cat_assistance_modal">Edit</button><button onClick="main_cat_ast_active_inactive('+row['cno']+',1)" class="btn-danger btn" type="button" name="button">Deactivate</button>';
                      }

                      return data;
                    }
                },
              ]
          });


          var table = $('#main_cat_hardware_table').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/emb_hardware_main_category",
              "columns": [
                { "data": "name","searchable": true},
                { "data": "date_added","searchable": true},
                { "data": "status","searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['deleted'] == 1) {
                          data = '<button onClick="main_cat_ast_active_inactive('+row['cno']+',0)" class="btn-primary btn" type="button" name="button">Activate</button>';
                      }else {
                          data = '<button class="btn-primary btn" onClick="edit_main_cat_assistance_id('+row['cno']+',this)" type="button" name="button"><span class="fa fa-edit" data-toggle="modal" data-target="#update_main_cat_assistance_modal"></span></button><button onClick="main_cat_ast_active_inactive('+row['cno']+',1)" class="btn-danger btn" type="button" name="button">Deactivate</button>';
                      }
                      return data;
                    }
                },
              ]
          });

        });
    </script>
