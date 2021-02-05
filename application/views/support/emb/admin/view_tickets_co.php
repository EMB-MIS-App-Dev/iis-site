

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
                      <div class="h5 mb-0 font-weight-bold text-info text-center" id="processing"><?=$processing?></div>
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
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Open </div>
                <div class="h5 mb-0 font-weight-bold text-info text-center"><?=$open?></div>
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
                <div class="text-xs font-weight-bold text-primary text-center text-uppercase mb-1">Attended </div>
                <div class="h5 mb-0 font-weight-bold text-info text-center"><?=$attended?></div>
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
                <div class="h5 mb-0 font-weight-bold text-info text-center"><?=$solved?></div>
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
                <div class="h5 mb-0 font-weight-bold text-info text-center"><?=$total?></div>
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
                <div class="h5 mb-0 font-weight-bold text-info text-center"><?=$pending?></div>
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
            <h6 class="m-0 font-weight-bold text-primary text-center"><span><i class="fa fa-th-list"> </i></span> Ticket</h6>
            <button class="btn btn-success btn-icon-split" data-toggle='modal' data-target='#emb_create_ticket'>
                <span class="icon ">
                  Create
                  <i class="fa fa-plus"></i>
                </span>
            </button>
          </div>

          <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <div class="" id="for_assistance_table_container">
                    <table class="table table-hover" id="for_assistance_table" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Ticket #</th>
                          <th>Request Date</th>
                          <th>Category</th>
                          <th>Description</th>
                          <th>Requested By</th>
                          <th>Agent</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>

                <div class="" id="for_borrow_table_container" style="display:none">
                  <table class="table table-hover"  id="for_borrow_data_table" width="100%" cellspacing="0" >
                    <thead>
                      <tr>
                        <th colspan="8" style="border-top:0px;padding-top:0px">BORROW</th>
                      </tr>
                      <tr>
                        <th>Ticket #</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Category</th>
                        <th>Requested By</th>
                        <th>Agent</th>
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
    </div>
    <div class="modal fade add_client_data" id="emb_create_ticket" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" >Create New Ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

                <div class="modal-body" >
                <div class="tab-content" >

                  <div class="tab-pane fade active show" id="assisstance" role="tabpanel" aria-labelledby="assisstance-tab">
                      <form class="" action="<?php echo base_url('Support/Emb_support/add_new_ticket_assistance'); ?>" method="post" enctype="multipart/form-data">

                        <div class="col-md-12" style="margin: 10px;">
                          <div class="row">
                            <div class="col-md-6">
                              <label for="">Category: <p style="color:red;display:inline">(Please select the appropriate category)</p></label>
                              <select class="form-control" name="sp_category_assistance" onChange="sp_select_category(this.value)" required>
                                <option value="0">--</option>
                                <?php foreach ($sp_category_list as $key => $sp_cat_val): ?>
                                  <?php if ($sp_cat_val['cno'] == 6): ?>
                                    <option value="<?= $sp_cat_val['cno'] ?>" selected><?= $sp_cat_val['ctype'] ?></option>
                                  <?php else: ?>
                                    <option value="<?= $sp_cat_val['cno'] ?>"><?= $sp_cat_val['ctype'] ?></option>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="col-md-6" >
                              <label for="" id="sp_category_specification_label">Sub Category:</label>
                              <!-- <input type="text" class="form-control" name="sp_category_specification" value="" id="sp_category_specification"> -->
                              <select class="form-control" name="sp_category_specification" id="sp_category_specification" required>
                                <option value="" selected disabled>--</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label for="">Remarks</label>
                          <textarea name="remarks" rows="8" style="width:100%" required></textarea>
                        </div>
                        <div class="col-md-12">
                          <div class="custom-file">
                            <input type="file" name="support_attach[]" class="custom-file-input" id="uploadpermitfile" multiple>
                            <label class="custom-file-label" for="uploadpermitfile">Choose file (multiple/single)</label>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                      </form>
                  </div>
                  <div class="tab-pane fade" id="sp_borrow" role="tabpanel" aria-labelledby="sp_borrow-tab">

                    <div class="col-md-12" style="margin: 10px;">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="">Category: <p style="color:red;display:inline">(Please select the appropriate category)</p></label>
                            <select class="form-control" name="sp_category" onChange="sp_select_borrow_category(this.value)">
                              <option value="0">--</option>
                              <option value="">Computer</option

                              <option value="">Others</option>
                            </select>
                        </div>
                        <div class="col-md-6" >
                            <label for="">Brand:</label>
                            <select class="form-control" name="" >
                            <option value=""></option>
                            <option value=""></option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin: 10px;">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="">Model:</label>
                            <input type="text" class="form-control" name="" value="">
                        </div>
                        <div class="col-md-6" >
                            <label for="" >Quantity:</label>
                            <input type="number" class="form-control" name="" value="">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" >Save</button>
                    </div>
                  </div>
                  </div>


        </div>

      </div>
    </div>
   </div>
    <div class="modal fade" id="emb_supp_add_resolution" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">Add Resolution</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="emb_supp_category">Category:</label>
                    <span id="emb_supp_category"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_supp_specification">Specification:</label>
                    <span id="emb_supp_specification"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="emb_supp_staff">From:</label>
                  <span id="emb_supp_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_supp_date">Date:</label>
                    <span id="emb_supp_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="emb_supp_remarks">REMARKS:</label>
                    <textarea name="" id="emb_supp_remarks" rows="4" style="width:100%" readonly></textarea>
                    <br>
                    <div class="dropdown show"> <a class="btn btn-primary dropdown-toggle" style="width:100%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a>
                      <div class="dropdown-menu"  style="width: 100%;text-align: center;" aria-labelledby="dropdownMenuLink" id="sp_attachment_container_solved">

                      </div>
                    </div>
            </div>
            <hr>
            <form class="" action="<?php echo base_url(); ?>Support/Emb_support/submit_resolution" method="post" enctype="multipart/form-data">
              <input type="hidden" name="emb_supp_ticket_id_res" value="" id="emb_supp_ticket_id_res">
              <div class="col-md-12">
                <label for="support_resolution">RESOLUTION:</label>
                <textarea name="emb_support_resolution" id="emb_support_resolution" rows="4" style="width:100%" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary" >SUBMIT</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="emb_supp_view_ticket" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">View Ticket</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="emb_supp_category">CATEGORY:</label>
                    <span id="view_emb_supp_category"></span>
                </div>
                <div class="col-md-6">
                    <label for="view_emb_supp_specification">SPECIFICATION:</label>
                    <span id="view_emb_supp_specification"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="view_emb_supp_staff">FROM:</label>
                  <span id="view_emb_supp_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="view_emb_supp_date">DATE:</label>
                    <span id="view_emb_supp_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="view_emb_supp_remarks">REMARKS:</label>
                    <textarea  class="form-control" name="" id="view_emb_supp_remarks" rows="4" style="width:100%" readonly></textarea>
            </div>
            <div class="col-md-12">

                  <div class="col-md-12">
                      <label for="view_emb_supp_remarks">Attachment:</label>
                  </div>
                    <div class="dropdown show"> <a class="btn btn-primary dropdown-toggle" style="width:100%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="sp_attachment_container" style="width: 100%;text-align: center;"></div>
                  </div>
            </div>
            <div id="view_remarks_forward_cont" style="display:none">
                <div class="col-md-12">
                  <label for="support_resolution">Remarks from sender: <span id="sender_name"></span></span></label>
                  <textarea class="form-control" name="view_reason_pending" id="view_remarks_forward" rows="4" style="width:100%" readonly></textarea>
                </div>
            </div>

            <div id="view_resolution" style="display:none">
              <div class="col-md-12">
                <label for="support_resolution">Resolution from reciever:</label>
                <!-- <textarea  class="form-control" name="view_emb_support_resolution" id="view_emb_support_resolution" rows="4" style="width:100%" readonly></textarea> -->
                <div id="view_emb_support_resolution">

                </div>
              </div>
            </div>
            <div id="view_comment_from_staff_id" style="display:none">
                <div class="col-md-12">
                  <label for="support_resolution">Comment from sender:</label>
                  <!-- <textarea class="form-control" name="view_comment_from_staff" id="view_comment_from_staff" rows="4" style="width:100%" readonly></textarea> -->
                  <div id="view_comment_from_staff">

                  </div>
                </div>
            </div>
            <div id="view_reason_pending_id" style="display:none">
                <div class="col-md-12">
                  <label for="support_resolution">REASON:</label>
                  <textarea class="form-control" name="view_reason_pending" id="view_reason_pending" rows="4" style="width:100%" readonly></textarea>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="emb_supp_view_ticket_borrow" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">View Ticket</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="view_emb_supp_staff">From:</label>
                  <span id="borrow_view_emb_supp_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_supp_category">Category:</label>
                    <span id="borrow_view_emb_supp_category"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="view_emb_supp_date">Date Borrow:</label>
                    <span id="borrow_view_emb_borrow_date"></span>
                </div>
                <div class="col-md-6">
                    <label for="view_emb_supp_date">Return Date:</label>
                    <span id="borrow_view_emb_return_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="view_emb_supp_remarks">REMARKS:</label>
                    <textarea name="" id="borrow_view_emb_supp_remarks" rows="4" style="width:100%" readonly></textarea>
            </div>
            <div id="borrow_view_resolution" style="display:none">
                <div class="col-md-12">
                  <label for="support_resolution">RESOLUTION:</label>
                  <textarea name="view_emb_support_resolution" id="borrow_view_emb_support_resolution" rows="4" style="width:100%"></textarea>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="emb_supp_add_resolution_borrow" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">Add Resolution</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="borrow_emb_supp_staff">From:</label>
                  <span id="borrow_emb_supp_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="borrow_emb_supp_category">Category:</label>
                    <span id="borrow_emb_supp_category"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="borrow_emb_borrow_date">Borrow Date:</label>
                    <span id="borrow_emb_borrow_date"></span>
                </div>
                <div class="col-md-6">
                    <label for="borrow_emb_return_date">Expected Return Date:</label>
                    <span id="borrow_emb_return_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="borrow_emb_supp_remarks">REMARKS:</label>
                    <textarea name="" id="borrow_emb_supp_remarks" rows="4" style="width:100%" readonly></textarea>

            </div>
            <hr>
            <form class="" action="<?php echo base_url(); ?>Support/Emb_support/submit_resolution_borrow" method="post" enctype="multipart/form-data">
              <input type="text" name="borrow_emb_supp_ticket_id_res" value="" id="borrow_emb_supp_ticket_id_res">
              <div class="col-md-12">
                <label for="borrow_status">Status:</label>
                  <select class="form-control" name="borrow_status" id='borrow_status'>
                    <option value="0">----</option>
                    <option value="1">Approved</option>
                    <option value="2">Disapproved</option>
                  </select>
              </div>
              <div class="col-md-12">
                <label for="support_resolution">RESOLUTION:</label>
                <textarea name="borrow_emb_support_resolution" id="borrow_emb_support_resolution" rows="4" style="width:100%"></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary" >SUBMIT</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="emb_supp_pending_request" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">Add Reason</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="emb_supp_category">Category:</label>
                    <span id="emb_supp_pending_category"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_supp_pending_specification">Specification:</label>
                    <span id="emb_supp_pending_specification"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="emb_supp_pending_staff">From:</label>
                  <span id="emb_supp_pending_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_supp_pending_date">Date:</label>
                    <span id="emb_supp_pending_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="emb_supp_pending_remarks">REMARKS:</label>
                    <textarea name="" class="form-control" id="emb_supp_pending_remarks" rows="4" style="width:100%" readonly></textarea>
            </div>
            <hr>
            <form class="" action="<?php echo base_url(); ?>Support/Emb_support/submit_reason_pending" method="post" enctype="multipart/form-data">
              <input type="hidden" name="emb_supp_pending_ticket_id_res" value="" id="emb_supp_pending_ticket_id_res">
              <div class="col-md-12">
                <label for="emb_support_pending_reason">REASON:</label>
                <textarea name="emb_support_pending_reason" id="emb_support_pending_reason" rows="4" style="width:100%" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary" >SUBMIT</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- modal for forwarding concern to central -->
    <div class="modal fade" id="emb_supp_forward_request" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">Forward Ticket</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="emb_forward_supp_category">Category:</label>
                    <span id="emb_forward_supp_pending_category"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_forward_supp_pending_specification">Specification:</label>
                    <span id="emb_forward_supp_pending_specification"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="emb_forward_supp_pending_staff">From:</label>
                  <span id="emb_forward_supp_pending_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_forward_supp_pending_date">Date:</label>
                    <span id="emb_forward_supp_pending_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="emb_forward_supp_pending_remarks">REMARKS:</label>
                    <textarea name="" class="form-control" id="emb_forward_supp_pending_remarks" rows="4" style="width:100%" readonly></textarea>
            </div>
          <label >Attachment:</label>
            <div class="dropdown show"> <a class="btn btn-primary dropdown-toggle" style="width:100%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a>
              <div class="dropdown-menu"  style="width: 100%;text-align: center;" aria-labelledby="dropdownMenuLink" id="sp_attachment_container_solved_forward">

              </div>
            </div>
            <hr>
            <form class="" action="<?php echo base_url(); ?>Support/Emb_support/submit_reason_forward" method="post" enctype="multipart/form-data">
              <input type="hidden" name="emb_forward_supp_pending_ticket_id_res" value="" id="emb_forward_supp_pending_ticket_id_res">
              <div class="col-md-12">
                <label for="emb_forward_support_pending_reason">REMARKS:</label>
                <textarea name="emb_forward_support_pending_reason" id="emb_forward_support_pending_reason" rows="4" style="width:100%" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary" >SUBMIT</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- for adding resolution from emb staff -->
    <div class="modal fade" id="add_res_from_staff_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">View Ticket</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="emb_supp_category">Category:</label>
                    <span id="add_res_from_staff_supp_category"></span>
                </div>
                <div class="col-md-6">
                    <label for="add_res_from_staff_supp_specification">Specification:</label>
                    <span id="add_res_from_staff_supp_specification"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="add_res_from_staff_supp_staff">From:</label>
                  <span id="add_res_from_staff_supp_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="add_res_from_staff_supp_date">Date:</label>
                    <span id="add_res_from_staff_supp_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                    <label for="add_res_from_staff_supp_remarks">REMARKS:</label>
                    <textarea class="form-control" name="" id="add_res_from_staff_supp_remarks" rows="4" style="width:100%" readonly></textarea>
            </div>
            <div id="view_resolution">
              <hr>
                <div class="col-md-12">
                  <label for="support_resolution">RESOLUTION from Agent:</label>
                  <!-- <textarea class="form-control" name="add_res_from_staff_support_resolution" id="add_res_from_staff_support_resolution" rows="4" style="width:100%" readonly></textarea> -->
                  <div id="add_res_from_staff_support_resolution">

                  </div>
                </div>
            </div>
              <hr>
              <form class="" action="<?php echo base_url(); ?>/Support/Emb_support/save_comment_from_staff" method="post">
                <input type="hidden" name="add_res_from_staff_supp_ticket_ass_id" value="" id="add_res_from_staff_supp_ticket_ass_id">
              <div class="col-md-12">
                <label for="support_resolution">COMMENT:</label>
                <textarea class="form-control" name="add_res_from_staff_support_resolution" id="add_res_from_staff_support_resolution" rows="4" style="width:100%" ></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger" value="2" name="unresolved_btn">Unresolved</button>
            <button type="submit" class="btn btn-primary" value="1" name="confirm_btn">Confirm</button>
            |<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
           </form>
        </div>
      </div>
    </div>

    <!-- for forwarding to section modal -->
    <!-- modal for forwarding concern to central -->
    <div class="modal fade" id="emb_supp_forward_request_section" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#FFF;"><span style="color:white!important">Forward Ticket</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
              <span aria-hidden="true" style="color:white!important">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <label for="emb_forward_to_ch_supp_category">Category:</label>
                    <span id="emb_forward_to_ch_supp_pending_category"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_forward_to_ch_supp_pending_specification">Specification:</label>
                    <span id="emb_forward_to_ch_supp_pending_specification"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="emb_forward_to_ch_supp_pending_staff">From:</label>
                  <span id="emb_forward_to_ch_supp_pending_staff"></span>
                </div>
                <div class="col-md-6">
                    <label for="emb_forward_to_ch_supp_pending_date">Date:</label>
                    <span id="emb_forward_to_ch_supp_pending_date"></span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="emb_forward_to_ch_supp_pending_remarks">Remarks:</label>
                </div>
                <div class="col-md-6">
                    <label for="emb_forward_to_ch_supp_pending_date">From region:</label>
                      <span id="emb_forward_to_ch_region"></span>
                </div>
              </div>
            </div>
            <div  class="col-md-12">
                  <textarea name="" class="form-control" id="emb_forward_to_ch_supp_pending_remarks" rows="4" style="width:100%" readonly></textarea>
            </div>
            <div class="col-md-12">
              <label >Attachment:</label>
                <div class="dropdown show"> <a class="btn btn-primary dropdown-toggle" style="width:100%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a>
                  <div class="dropdown-menu"  style="width: 100%;text-align: center;" aria-labelledby="dropdownMenuLink" id="sp_attachment_to_ch_container_forward">

                  </div>
                </div>
            </div>

            <hr>
            <form class="" action="<?php echo base_url(); ?>Support/Emb_support/submit_forward_to_sec" method="post" enctype="multipart/form-data">
              <input type="hidden" name="ticket_ass_id" value="" id="emb_forward_to_ch_ticket_ass_id">
                <input type="hidden" name="fwrd_id" value="" id="emb_forward_to_ch_fwrd_id">
              <div class="col-md-12">
                <label>Your Remarks:</label>
                <textarea name="emb_forward_to_ch_remarks" rows="4" style="width:100%" required></textarea>
              </div>
              <div class="col-md-12">
                  <label for=""> Assigned to:</label>
              </div>
              <div class="col-md-12">
                <?php
                 get_instance()->load->helper('common_helper');
                 region_list();
                ?>
              </div>
              <br>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="supp_div" id="supp_div" required>

                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="supp_sec" id="supp_sec">
                    </select>
                  </div>
                </div>

              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary" >SUBMIT</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- for forwarding to section end -->
    <script src="<?php echo base_url(); ?>assets/js/support.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/jquery/jquery.min.js"></script>
    <style media="screen">
        h2#swal2-title {
        font-size: 0.875em;
        }
    </style>
    <?php if ($this->session->flashdata('add_new_ticket_assistance_msg') != ''): ?>
   <script type="text/javascript">
     $(document).ready(function() {
       Swal.fire({
         title: 'Ticket has been successfully added with Ticket no:',
         text: '<?php echo $this->session->flashdata('add_new_ticket_assistance_msg'); ?>',
         imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
         imageWidth: 135,
         imageHeight: 50,
         imageAlt: 'Custom image',
         })
     });
   </script>
   <?php endif; ?>
   <?php if ($this->session->flashdata('frwd_to_sec') != ''): ?>
  <script type="text/javascript">
    $(document).ready(function() {
        Swal.fire(
          'Awesome!',
          'Ticket has been successfully forwarded !',
          'success'
      )
    });
  </script>
  <?php endif; ?>
     <?php if ($this->session->flashdata('submit_resolution_msg') != ''): ?>
    <script type="text/javascript">
      $(document).ready(function() {
        Swal.fire(
            'Good job!',
            'Ticket has ben attended !',
            'success'
          )
      });
    </script>
    <?php endif; ?>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#uploadpermitfile').change(function(e){
          var files = e.target.files;
          var result = "";
          for (var i = 0; i < files.length; i++) {
              if(i>0){
                 result += ' , ';
              }
              result += files[i].name;
          }
            $('.custom-file-label').text(result);
       });

        $('#assistance_btn').on('click',function(){
          $('#borrow_btn').css({'border':'none','text-decoration':'none'});
          $(this).css({'border':'solid 1px #0A5083','text-decoration':'underline'});
          $('#for_borrow_table_container').hide();
          $('#for_assistance_table_container').show();
        })
        $('#borrow_btn').on('click',function(){
          $(this).css({'border':'solid 1px #0A5083','text-decoration':'underline'});
          $('#assistance_btn').css({'border':'none','text-decoration':'none'});
          $('#for_borrow_table_container').show();
          $('#for_assistance_table_container').hide();
        })
        // $('#sp_category_specification').selectize();
          var secno = "<?php echo $this->session->userdata('secno')?>";
          var region = "<?php echo $this->session->userdata('region')?>";
          var table = $('#for_assistance_table').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "order": [[ 0, "asc" ]],
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/for_assistance_table",

              "columns": [
                { "data": "status2","visible": false},
                { "data": "ticket_no","searchable": true},
                { "data": "ticket_date","searchable": true},
                { "data": "ctype","searchable": true},
                { "data": "csdsc","searchable": true},
                { "data": "staff","searchable": true},
                // { "data": "mis_id","searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['mis_id'] == 0) {
                        data = "Waiting";
                      }else {
                          data = row['agent'];
                      }
                      return data;
                    }
                },
                {className: "my_class",
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['forwarded'] == 1) {
                        if (row['status'] == 'open') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/> Endorsed -> CO';
                        }else if (row['status'] == 'processing') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing-forwarded';
                        }else if (row['status'] == 'attended') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended-forwarded';
                        }else if (row['status'] == 'solved') {
                            data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved-forwarded';
                        }else if (row['status'] == 'pending') {
                            data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending-forwarded';
                        }else if (row['status'] == 'unresolved') {
                            data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Unresolved"></i> Unresolved-forwarded';
                        }
                      }else if (row['forwarded'] == 2) {
                        if (row['status'] == 'open') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/> Endorsed -> CO-SECTION';
                        }else if (row['status'] == 'processing') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing-forwarded';
                        }else if (row['status'] == 'attended') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended-forwarded';
                        }else if (row['status'] == 'solved') {
                            data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved-forwarded';
                        }else if (row['status'] == 'pending') {
                            data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending-forwarded';
                        }else if (row['status'] == 'unresolved') {
                            data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Unresolved"></i> Unresolved-forwarded';
                        }
                      }else {
                        if (row['status'] == 'open') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/> Open';
                        }else if (row['status'] == 'processing') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing';
                        }else if (row['status'] == 'attended') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended';
                        }else if (row['status'] == 'solved') {
                            data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved';
                        }else if (row['status'] == 'pending') {
                            data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending';
                        }else if (row['status'] == 'unresolved') {
                            data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Unresolved"></i> Unresolved';
                        }
                      }

                      return data;
                    }
                },
                {className: "btn-group",
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['forwarded'] == 1) {
                        if (row['from_reg'] == region) {
                          if (row['status'] == 'attended') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' data-toggle='modal' data-target='#add_res_from_staff_modal' onClick=add_res_from_staff('"+row['ticket_ass_id']+"')><span class='fa fa-check' style='color:#104E91;'></span></a>";
                          }else {
                            data = "<a class='btn btn-sm' href=''data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' onClick=cancel_emb_forward_ticket('"+row['ticket_ass_id']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a>";
                          }
                        }else {
                          if (row['status'] == 'open') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='#' onClick=emb_process_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a><a class='btn btn-sm' href='#' onClick=emb_forward_ticket_to_section('"+row['ticket_ass_id']+"') ><span class='fa fa-forward' style='color:#104E91;' title='endorse to CH' data-toggle='modal' data-target='#emb_supp_forward_request_section'></span></a>";
                          }else if (row['status'] == 'processing') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"') title='View'><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='='#'' data-toggle='modal' data-target='#emb_supp_add_resolution' onClick=emb_add_resolution('"+row['ticket_ass_id']+"') ><span class='fa fa-check' style='color:#104E91' title='Mark as solved'></span></i></a><a class='btn btn-sm' href='' onClick=cancel_emb_process_ticket('"+row['ticket_ass_id']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a><a class='btn btn-sm' href=''data-toggle='modal' data-target='#emb_supp_pending_request'  onClick=pending_process_ticket_borrow('"+row['ticket_ass_id']+"') title='Mark as Pending'><i class='fas fa-clock' aria-hidden='true' style='color:#104E91' ></i></a>";
                          }else if (row['status'] == 'attended') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                          }else if (row['status'] == 'solved') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                          }else if (row['status'] == 'pending') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                          }else if (row['status'] == 'unresolved') {
                            data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='#' onClick=emb_process_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a>";
                          }
                        }

                      }else {
                        if (row['status'] == 'open') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='#' onClick=emb_process_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a><a class='btn btn-sm' href='#' onClick=emb_forward_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-forward' style='color:#104E91;' title='forward to central office' data-toggle='modal' data-target='#emb_supp_forward_request'></span></a>";
                        }else if (row['status'] == 'processing') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"') title='View'><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='='#'' data-toggle='modal' data-target='#emb_supp_add_resolution' onClick=emb_add_resolution('"+row['ticket_ass_id']+"') ><span class='fa fa-check' style='color:#104E91' title='Mark as solved'></span></i></a><a class='btn btn-sm' href='' onClick=cancel_emb_process_ticket('"+row['ticket_ass_id']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a><a class='btn btn-sm' href=''data-toggle='modal' data-target='#emb_supp_pending_request'  onClick=pending_process_ticket_borrow('"+row['ticket_ass_id']+"') title='Mark as Pending'><i class='fas fa-clock' aria-hidden='true' style='color:#104E91' ></i></a>";
                        }else if (row['status'] == 'attended') {
                          // data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                        }else if (row['status'] == 'solved') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                        }else if (row['status'] == 'pending') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                        }else if (row['status'] == 'unresolved') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='#' onClick=emb_process_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a>";
                        }
                      }
                      return data;
                    }
                },
              ]
          });
            // setInterval( function () {
            //     table.ajax.reload( null, false );
            // }, 3000);


          var table2 = $('#for_borrow_data_table').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/admin_for_borrow_table",
              "columnDefs": [
                    { className: "btn-group", "targets": [ 1 ] }
                  ],
              "columns": [
                { "data": "ticket_no","searchable": true},
                { "data": "borrow_date","searchable": true},
                { "data": "return_date","searchable": true},
                { "data": "hardware_name","searchable": true},
                { "data": "staff","searchable": true},
                // { "data": "mis_id","searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['mis_id'] == 0) {
                        data = "Waiting";
                      }else {
                          data = row['agent'];
                      }
                      return data;
                    }
                },
                {className: "my_class",
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['status'] == 'open') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/>';
                      }else if (row['status'] == 'processing') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/>';
                      }else if (row['status'] == 'solved') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Solved"/>';
                      }else if (row['status'] == 'disapproved') {
                        data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/disapproved.gif" alt="" title="Disapproved"/>';
                      }
                      return data;
                    }
                },
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['status'] == 'open') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket_borrow' onClick=emb_view_support_request_borrow('"+row['tno']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='#' onClick=emb_process_ticket_borrow('"+row['tno']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a>";
                      }else if (row['status'] == 'processing') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket_borrow' onClick=emb_view_support_request_borrow('"+row['tno']+"') title='View'><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='='#'' data-toggle='modal' data-target='#emb_supp_add_resolution_borrow' onClick=emb_supp_add_resolution_borrow('"+row['tno']+"') ><span class='fa fa-check' style='color:#104E91' title='Mark as solved'></span></i></a><a class='btn btn-sm' href='' onClick=cancel_emb_process_ticket_borrow('"+row['tno']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a>";
                      }else if (row['status'] == 'solved') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket_borrow' onClick=emb_view_support_request_borrow('"+row['tno']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                      }else if (row['status'] == 'disapproved') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket_borrow' onClick=emb_view_support_request_borrow('"+row['tno']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' onClick=cancel_emb_process_ticket_borrow('"+row['tno']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a>";
                      }
                      return data;
                    }
                },
              ]
          });

          // for getting division according to region
          $('#change_region_function').on('change',function(){
            var reg_val = $(this).val();
            $.ajax({
                  url: base_url+"/Support/Emb_support/select_division",
                  type: 'POST',
                  async : true,
                  data: {"region": region,},
                  success:function(response)
                    {
                      var html = '';
                      var data = JSON.parse(response);
                      html +='<option value="" selected disabled>Select Division</option>';
                      for (var i = 0; i < data.length; i++) {
                        html += '<option value='+data[i].divno+'>'+data[i].divname+'</option>';
                      }
                      $('#supp_div').html(html);
                    }
              });
          })
          $('#supp_div').on('change',function(){
            var div_val = $(this).val();
            $.ajax({
                  url: base_url+"/Support/Emb_support/select_section",
                  type: 'POST',
                  async : true,
                  data: {"div_val": div_val,},
                  success:function(response)
                    {
                      var html = '';
                      var data = JSON.parse(response);
                      html +='<option value="" selected disabled>Select Division</option>';
                      for (var i = 0; i < data.length; i++) {
                        html += '<option value='+data[i].secno+'>'+data[i].sect+'</option>';
                      }
                      $('#supp_sec').html(html);
                    }
              });
          })
        });
    </script>
