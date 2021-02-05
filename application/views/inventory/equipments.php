

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
            <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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

            </div> -->
            <!-- Card Body -->
            <!-- <div class="card-body">

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

            </div> -->

          </div>
        </div>
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
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
          <!-- Card Body -->
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
      </div>
    </div>
   <!-- for creating category in assistance  -->
    <div class="modal fade" id="emb_create_category_assisstance" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" >
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Create new Category - Assistance</h5>
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
                    <input type="text" class="form-control" name="main_cat_assistance" value="">
                  </div>
                  <div class="col-md-12">
                    <label for="">Sub category:</label>
                  </div>
                  <div class="col-md-12 subcat_cont" style="margin-top:10px">
                    <input type="text" class="form-control " name="sub_cat_assistance[]" value="">
                  </div>
                  <div class="col-md-12" id="subcat-section">
                    <div class="row">
                      <div class="col-md-2">
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
    <!-- for creating category in borrow  -->
    <div class="modal fade" id="emb_create_category_borrow" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" >
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Create new Category - Hardware</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="<?php echo base_url('Support/Emb_support/add_hardware_category'); ?>" method="post">
                <div class="modal-body" >
                  <div class="col-md-12">
                    <label for="">Category: (e.g) - MONITOR,KEYBOARD,PRINTER</label>
                    <input type="text" class="form-control" name="main_cat_hardware" value="">
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
      <div class="modal-dialog modal-lg" role="document" >
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Edit Category - <span id="selected_main_cat_assistance"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="<?php echo base_url('Support/Emb_support/save_edited_assintance_category'); ?>" method="post">
                <div class="modal-body" >
                  <!-- <div class="col-md-12"> -->
                  <!-- <form  action="<?php //echo base_url('Support/Emb_support/add_brand_per_hardware_cat'); ?>" method="post"> -->
                    <input type="hidden" class="form-control" name="main_cat_assistance" value="" id="main_cat_assistance_id">
                  <!-- </div> -->
                  <div class="col-md-12">
                    <label for="">CATEGORY SPECIFICATIONS:</label>
                    <select class="form-control" name="sub_cat_assistance_list" onChange="add_sub_cat_assistance(this.value)" id="add_subcat_per_assistance_main_cat">
                        <option value="" disabled selected>---</option>
                    </select>
                  </div>

                    <div class="col-md-12 new-sub-cat-assistance-row" style="display:none">
                        <div class="col-md-4">
                          <label for="">Name:</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="sub-cat-assistance[]" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12" id="sub-cat-assistance-section" style="display:none">
                      <div class="row">
                        <div class="col-md-6">
                          <button type="button" name="button" class="btn btn-success" style="margin-top: 6px;" id="sub-cat-assistance-btn"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-6">
                          <!-- <button type="submit" name="button" class="btn btn-success" style="margin-top: 6px;float:right" id="save_new-brand">SUBMIT</button> -->
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
      <script src="<?php echo base_url(); ?>assets/js/support.js"></script>
    <!-- <script src="<?php //echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php //echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script> -->
    <!-- <script src="<?php //echo base_url(); ?>assets/js/support.js"></script> -->
      <!-- <script src="<?php //echo base_url(); ?>assets/js/support.js"></script> -->
        <script src="<?php echo base_url(); ?>assets/common/jquery/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
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


          var table = $('#emb_category_table_assistance').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/emb_category_data",
              "columns": [
                { "data": "ctype","searchable": true},
                { "data": "date_added","searchable": true},
                { "data": "status","searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      data = "<a class='btn btn-sm' onClick=edit_main_cat_assistance('"+row['cno']+"') href=''   data-toggle='modal' data-target='#update_main_cat_assistance_modal'><span class='fa fa-edit' style='color:#104E91;'></span></a>";

                      return data;
                    }
                },
              ]
          });
          var table1 = $('#main_cat_hardware_table').DataTable({
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
                      data = "<a class='btn btn-sm' onClick=edit_main_cat_hardware('"+row['sp_hardware_id']+"') href=''   data-toggle='modal' data-target='#update_main_cat_hardware_modal'><span class='fa fa-edit' style='color:#104E91;'></span></a>";

                      return data;
                    }
                },
              ]
          });
        // $('#save_new-brand').on('click',function(){
        //   var theArray = new Array();
        //     var i=0;
        //     jQuery('.chkval').each(function(){
        //         if(jQuery(this).prop('checked'))
        //         {
        //             theArray[i] = jQuery(this).val();
        //             i++;
        //         }
        //     });
        // })
        });
    </script>
