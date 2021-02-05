

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
            <h6 class="m-0 font-weight-bold text-primary text-center"><span><i class="fa fa-th-list"> </i></span> Ticket - staff</h6>
            <button class="btn btn-success btn-icon-split" data-toggle='modal' data-target='#staff_emb_create_ticket'>
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


              </div>
            </div>
        </div>
      </div>
    </div>
<!-- for assistance modal -->
    <div class="modal fade add_client_data" id="staff_emb_create_ticket" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#018E7F;">
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel" ><i class="fa fa-pencil"></i>Create new ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

                <div class="modal-body" >
                <div class="tab-content" >

                  <div class="tab-pane fade active show" id="assisstance" role="tabpanel" aria-labelledby="assisstance-tab">
                        <form class="" action="<?php echo base_url('Support/Emb_support/add_new_ticket_assistance'); ?>" method="post" enctype="multipart/form-data">

                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6">
                              <label for="">Category: <p style="color:red;display:inline">(Please select the appropriate category)</p></label>
                              <select class="form-control" name="sp_category_assistance" onChange="sp_select_category(this.value)" required>
                                <option value="">--</option>
                                <?php foreach ($sp_category_list as $key => $sp_cat_val): ?>
                                    <option value="<?= $sp_cat_val['cno'] ?>"><?= $sp_cat_val['ctype'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="col-md-6" >
                              <label for="" id="sp_category_specification_label">Others:</label>
                              <select class="form-control" name="sp_category_specification" id="sp_category_specification" required>
                                <option value="" selected disabled>--</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label for="">Remarks:</label>
                          <textarea name="remarks" rows="8" style="width:100%" required></textarea>
                        </div>
                        <div class="col-md-12">
                          <div class="custom-file">
                            <input type="file" name="support_attach[]" class="custom-file-input" id="uploadpermitfile" multiple>
                            <label class="custom-file-label" for="uploadpermitfile">Choose file (multiple/single)</label>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6">
                              <input type="radio" name="option_forward" value="1" checked>
                              <label for="">TO MIS</label>
                            </div>
                            <div class="col-md-6">
                              <input type="radio" name="option_forward" value="2">
                              <label for="">TO OTHER SECTION</label>
                            </div>
                          </div>
                        </div>
                        <div id="cont_sec_container" style="display:none" class="mb-3">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6">
                                <select class="form-control" name="supp_div" id="supp_div" required>
                                  <option value="" selected disabled>--SELECT DIVISION--</option>
                                  <?php foreach ($divisions as $key => $dival): ?>
                                    <option value="<?=$dival['divno']?>"><?=$dival['divname']?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <select class="form-control" name="supp_sec" id="supp_sec" required>
                                  <option value="" selected disabled>--SELECT SECTION--</option>
                                  <?php foreach ($sections as $key => $secval): ?>
                                        <option value="<?=$secval['secno']?>"><?=$secval['sect']?></option>
                                  <?php endforeach; ?>
                                </select>
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
                   <label for="emb_supp_category">Category:</label>
                   <span id="view_emb_supp_category"></span>
               </div>
               <div class="col-md-6">
                   <label for="view_emb_supp_specification">Specification:</label>
                   <span id="view_emb_supp_specification"></span>
               </div>
             </div>
           </div>
           <div class="col-md-12">
             <div class="row">
               <div class="col-md-6">
                 <label for="view_emb_supp_staff">From:</label>
                 <span id="view_emb_supp_staff"></span>
               </div>
               <div class="col-md-6">
                   <label for="view_emb_supp_date">Date:</label>
                   <span id="view_emb_supp_date"></span>
               </div>
             </div>
           </div>
           <div class="col-md-12">
                   <label for="view_emb_supp_remarks">REMARKS:</label>
                   <textarea class="form-control" name="" id="view_emb_supp_remarks" rows="4" style="width:100%" readonly></textarea>

                   <!-- <div class="dropdown show"> <a class="btn btn-primary dropdown-toggle" style="width:100%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a>
                     <div class="dropdown-menu"  style="width: 100%;text-align: center;" aria-labelledby="dropdownMenuLink" id="sp_attachment_container">
                     </div>
                 </div> -->
           </div>
           <div class="col-md-12">
                   <label for="view_emb_supp_remarks">Attachment:</label>
                   <div class="dropdown show"> <a class="btn btn-primary dropdown-toggle" style="width:100%" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file" aria-hidden="true"></i> </a>
                     <div class="dropdown-menu"  style="width: 100%;text-align: center;" aria-labelledby="dropdownMenuLink" id="sp_attachment_container">
                     </div>
                 </div>
           </div>
           <div id="view_resolution" style="display:none">
             <hr>
               <div class="col-md-12">
                 <label for="support_resolution">RESOLUTION:</label>
                 <!-- <textarea class="form-control" name="view_emb_support_resolution" id="view_emb_support_resolution" rows="4" style="width:100%" readonly></textarea> -->
                 <div id="view_emb_support_resolution">

                 </div>
               </div>
           </div>
           <div id="view_comment_from_staff_id" style="display:none">
             <hr>
               <div class="col-md-12">
                 <label for="support_resolution">COMMENT:</label>
                 <!-- <textarea class="form-control" name="view_comment_from_staff" id="view_comment_from_staff" rows="4" style="width:100%" readonly></textarea> -->
                 <div id='view_comment_from_staff'>

                 </div>
               </div>
           </div>
           <div id="view_reason_pending_id" style="display:none">
             <hr>
               <div class="col-md-12">
                 <label for="support_resolution">REASON:</label>
                 <textarea class="form-control" name="view_reason_pending" id="view_reason_pending" rows="4" style="width:100%" readonly></textarea>
               </div>
           </div>
           <div id="view_remarks_forward_cont" style="display:none">
               <div class="col-md-12">
                 <label for="support_resolution">Remarks from sender: <span id="sender_name"></span></span></label>
                 <textarea class="form-control" name="view_reason_pending" id="view_remarks_forward" rows="4" style="width:100%" readonly></textarea>
               </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
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
          text: '<?php echo $this->session->flashdata('add_new_ticket_assistance_msg'); ?>',  // title: 'Sweet!',
          // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
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


        $('#for_assistance_table tr:last td:last').addClass('btn-group');
        var table = $('#for_assistance_table').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/staff_for_assistance_table",
              "columns": [
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
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/> Endorsed - CO';
                        }else if (row['status'] == 'processing') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing - CO';
                        }else if (row['status'] == 'attended') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended - CO';
                        }else if (row['status'] == 'solved') {
                            data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved (forwarded)';
                        }else if (row['status'] == 'pending') {
                            data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending (forwarded)';
                        }else if (row['status'] == 'unresolved') {
                            data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Unresolved"></i> Unresolved (forwarded)';
                        }
                      }else if (row['forwarded'] == 2) {
                        if (row['status'] == 'open') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/> Endorsed (CO-SECTION)';
                        }else if (row['status'] == 'processing') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing (CO-SECTION)';
                        }else if (row['status'] == 'attended') {
                          data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended (CO-SECTION)';
                        }else if (row['status'] == 'solved') {
                            data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved-CO';
                        }else if (row['status'] == 'pending') {
                            data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending (forwarded)';
                        }else if (row['status'] == 'unresolved') {
                            data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Unresolved"></i> Unresolved-CO';
                        }
                      }else {
                          if (row['status'] == 'open') {
                            data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/open.gif" alt="" title="Open"/> Open';
                          }else if (row['status'] == 'processing') {
                            data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing';
                          }else if (row['status'] == 'attended') {
                            data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended';
                          }
                          else if (row['status'] == 'solved') {
                            data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved';
                          }else if (row['status'] == 'pending') {
                            data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending';
                          }else if (row['status'] == 'unresolved') {
                            data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Pending"></i> Unresolved';
                          }
                      }

                      return data;
                    }
                },
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                      if (row['status'] == 'open') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                      }else if (row['status'] == 'processing') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                      }else if (row['status'] == 'attended') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' data-toggle='modal' data-target='#add_res_from_staff_modal' onClick=add_res_from_staff('"+row['ticket_ass_id']+"')><span class='fa fa-check' style='color:#104E91;'></span></a>";
                      }else if (row['status'] == 'solved') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                      }else if (row['status'] == 'pending') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                      }else if (row['status'] == 'unresolved') {
                        data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                      }
                      return data;
                    }
                },
              ]
          });
          //for ticket forwarding option
          $("input[type='radio'][name='option_forward']").click(function() {
            var value = $(this).val();
            if (value == 1) {
              $('#cont_sec_container').hide();
              $('#get_div_by_region').removeAttr('required');
              $('#supp_div').removeAttr('required');
              $('#supp_sec').removeAttr('required');
            }else {
              $('#cont_sec_container').show();
              $('#get_div_by_region').attr('required','required');
              $('#supp_div').attr('required','required');
              $('#supp_sec').attr('required','required');
            }
          });
        });
    </script>
