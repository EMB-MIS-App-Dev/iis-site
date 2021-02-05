
<style>
#addScheduleModal label {
   color: black;
}
#addScheduleModal table {
   font-size: 13px;
   /* border: 1px solid black; */
}
#addScheduleModal table thead {
   text-align: center;
}
#addScheduleModal a[role="button"] {
   font-size: 10px
}
#addScheduleModal .card-footer button {
   font-size: 12px
}
#addScheduleModal .table-responsive {
   padding: 10px !important;
}
#addScheduleModal .box-body div.card {
   border-top: 3px solid gray;
   border-bottom: 3px solid gray
}
</style>
<!-- #####################################################    MODALS    ################################################################### -->
<div class="modal fade" id="addScheduleModal" role="dialog" >
   <div class="modal-dialog modal-lg" role="document" style="max-width: 70%">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="useraccountsModalLabel">Add New Event Schedule</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <?=form_open_multipart('planner/main/submit')?>
         <div class="modal-body">
            <div id="edit_details_body">
               <div class="col-md-12">
                  <div class="form-group">
                     <label>Activity ID</label>
                     <input type="hidden" name="sched_id" value="1" />
                     <input id="sched_id" class="form-control form-control-sm" value="1" readonly/>
                  </div>

                  <div class="form-group">
                     <label>Activities</label>
                     <textarea class="form-control form-control-sm" name="activities" placeholder="e.g Division Meeting, Planning, etc.." required></textarea>
                  </div>

                  <div class="form-group">
                     <label>Location</label>
                     <textarea class="form-control form-control-sm" name="location" placeholder="e.g Conference Room, Web App, etc.." required></textarea>
                  </div>

                  <div class="form-group">
                     <label>Scheduled Date</label>
                     <div class="row col-md-12" style="text-align:center">
                        <div class=" col-md-6">
                           <label>From:</label> <input class="form-control" type="datetime-local" name="start_date" required/>
                        </div>
                        <div class=" col-md-6">
                           <label>To:</label> <input class="form-control" type="datetime-local" name="end_date"/>
                        </div>
                     </div>
                  </div>

                  <div>
                     <div class="form-group collapse-group">
                        <div class="box-head">
                           <label>Accountable</label>
                           <a class="float-right btn btn-sm btn-primary" href="#accountableCollapse" data-toggle="collapse" role="button"> <i class="fas fa-plus"></i> Add</a>
                        </div>
                        <div id="accountableCollapse" class="collapse box-body">
                           <fieldset style="border-bottom: 1px solid gray">
                              <select name="user_func" hidden> <option value="Accountable" selected></option> </select>
                              <div class="card mb-4">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Region</label>
                                             <select class="form-control region" name="region"> </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6"> </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Division</label>
                                             <select class="form-control division" name="division">
                                                <option selected value="">- Select Region First -</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Section</label>
                                             <select class="form-control section" name="section">
                                                <option selected value="">- Select Division First -</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label>Personnel</label>
                                             <select class="form-control personnel" name="personnel">
                                                <option selected value="">- Select Section First -</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card-footer bg-transparent py-0">
                                    <button type="button" class="btn btn-success btn-sm my-1" name="add_personnel"><i class="fas fa-plus"></i> Add as Accountable/s</button>
                                 </div>
                              </div>
                           </fieldset>
                        </div>
                        <div id="accountableDataTable">
                           <div class="table-responsive">
                              <table class="table table-striped" width="100%" cellspacing="0">
                                 <thead>
                                    <tr>
                                       <th>id</th>
                                       <th>user_id</th>
                                       <th>Name</th>
                                       <th>div_no</th>
                                       <th>Division</th>
                                       <th>sec_no</th>
                                       <th>Section</th>
                                       <th>Region</th>
                                       <th>onevent_status</th>
                                       <th>user_func</th>
                                       <th></th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>

                     <div class="form-group collapse-group">
                        <div class="box-head">
                           <label>Host</label>
                           <a class="float-right btn btn-sm btn-primary" href="#hostsCollapse" data-toggle="collapse" role="button"> <i class="fas fa-plus"></i> Add</a>
                        </div>
                        <div id="hostsCollapse" class="collapse box-body">
                           <fieldset style="border-bottom: 1px solid gray">
                              <select name="user_func" hidden> <option value="Host" selected></option> </select>
                              <div class="card mb-4">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Region</label>
                                             <select class="form-control region" name="region"> </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6"> </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Division</label>
                                             <select class="form-control division" name="division">
                                                <option selected value="">- Select Region First -</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Section</label>
                                             <select class="form-control section" name="section">
                                                <option selected value="">- Select Division First -</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label>Personnel</label>
                                             <select class="form-control personnel" name="personnel">
                                                <option selected value="">- Select Section First -</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card-footer bg-transparent py-0">
                                    <button type="button" class="btn btn-success btn-sm my-1" name="add_personnel"><i class="fas fa-plus"></i> Add as Accountable/s</button>
                                 </div>
                              </div>
                           </fieldset>
                        </div>
                        <div id="hostsDataTable">
                           <div class="table-responsive">
                              <table class="table table-striped" width="100%">
                                 <thead>
                                    <tr>
                                       <th>id</th>
                                       <th>user_id</th>
                                       <th>Name</th>
                                       <th>div_no</th>
                                       <th>Division</th>
                                       <th>sec_no</th>
                                       <th>Section</th>
                                       <th>Region</th>
                                       <th>onevent_status</th>
                                       <th>user_func</th>
                                       <th></th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>

                     <div class="form-group collapse-group">
                        <div class="box-head">
                           <label>Participants</label>
                           <a class="float-right btn btn-sm btn-primary" href="#participantsCollapse" data-toggle="collapse" role="button"> <i class="fas fa-plus"></i> Add</a>
                        </div>
                        <div id="participantsCollapse" class="collapse box-body">
                           <fieldset style="border-bottom: 1px solid gray">
                              <select name="user_func" hidden> <option value="Participant" selected></option> </select>
                              <div class="card mb-4">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Region</label>
                                             <select class="form-control region" name="region"> </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6"> </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Division</label>
                                             <select class="form-control division" name="division">
                                                <option selected value="">- Select Region First -</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Section</label>
                                             <select class="form-control section" name="section">
                                                <option selected value="">- Select Division First -</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label>Personnel</label>
                                             <select class="form-control personnel" name="personnel">
                                                <option selected value="">- Select Section First -</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card-footer bg-transparent py-0">
                                    <button type="button" class="btn btn-success btn-sm my-1" name="add_personnel"><i class="fas fa-plus"></i> Add as Accountable/s</button>
                                 </div>
                              </div>
                           </fieldset>
                        </div>
                        <div id="participantsDataTable">
                           <div class="table-responsive">
                              <table class="table table-striped" width="100%">
                                 <thead>
                                    <tr>
                                       <th>id</th>
                                       <th>user_id</th>
                                       <th>Name</th>
                                       <th>div_no</th>
                                       <th>Division</th>
                                       <th>sec_no</th>
                                       <th>Section</th>
                                       <th>Region</th>
                                       <th>onevent_status</th>
                                       <th>user_func</th>
                                       <th></th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Remarks</label>
                     <textarea class="form-control form-control-sm" name="remarks"></textarea>
                  </div>
                  <div class="form-group">
                     <label>Activity Area Scope</label>
                     <select id="areaScopeSelectize" class="form-control" name="area_scope[]" required>
                        <option value="">--</option>
                        <option value="CO">CO - Central Office</option>
                        <?php
                        // foreach ($region_list as $key => $region) {
                        //    echo '<option value="'.$region['rgnnum'].'">'.$region['rgnnam'].'</option>';
                        // }
                        ?>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-sm" name="save"><i class="fas fa-plus"></i> Save</button>
         </div>
         <?=form_close();?>
      </div>
   </div>
</div>

<div class="modal fade" id="plannerCalendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Schedule Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label>Activities</label>
               <textarea id="activities" class="form-control" readonly></textarea>
            </div>
            <div class="form-group">
               <label>Location</label>
               <textarea id="location" class="form-control" readonly></textarea>
            </div>
            <div class="form-group">
               <label>Scheduled Date</label>
               <input id="schedDate" class="form-control" value="" readonly/>
            </div>
            <div class="form-group">
               <label>Host(s)</label>
               <div class="col-md-12" id="hosts" style="overflow-y: scroll;padding: 0px;max-height: 500px !important;"> </div>
            </div>
            <div class="form-group">
               <label>Participant(s)</label>
               <div class="col-md-12" id="participants" style="overflow-y: scroll;padding: 0px;max-height: 500px !important;"> </div>
            </div>
            <div class="form-group">
               <label>Status</label>
               <input id="status" class="form-control" value="" readonly/>
            </div>
            <div class="form-group">
               <label>Remarks</label>
               <textarea id="remarks" class="form-control" readonly></textarea>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- #####################################################    MODALS    ################################################################### -->

<script>
$(document).ready(function() {

      // $('#areaScopeSelectize').selectize({
      //    maxItems: null
      // });
   $('#addScheduleModal').on('shown.bs.modal', function () {
      let tableCols =[
         { data: "id", "searchable": false, "visible": false },
         { data: "user_id", "searchable": false, "visible": false },
         { data: "full_name" },
         { data: "div_no", "searchable": false, "visible": false },
         { data: "div_name" },
         { data: "sec_no", "searchable": false, "visible": false },
         { data: "sec_name" },
         { data: "region" },
         { data: "onevent_status", "searchable": false, "visible": false },
         { data: "user_func", "searchable": false, "visible": false },
         { data: null, searchable: false, sortable: false,
           "render": function(data, type, row, meta) {
             return '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
           }
         }
      ];
      let postTableData =  { sched_id: $('input[name="sched_id"]').val() };
      let sched_id = $('#addScheduleModal input[name="sched_id"]').val();

      setDataTables('accountableDataTable', 'accountable', tableCols, postTableData);
      setDataTables('hostsDataTable', 'hosts', tableCols, postTableData);
      setDataTables('participantsDataTable', 'participants', tableCols, postTableData);

      initUserDesignationGroups($('#addScheduleModal fieldset'));

      $('fieldset button[name="add_personnel"]').click( function() {
         let fieldsetGroup = $(this).parents('fieldset');
         let collapseGroup = $(this).parents('div.collapse-group');
         let dataTable = fieldsetGroup.find('table');
         let postData = {};

         fieldsetGroup.find('select').each(
            function (index){
               let input = $(this);
               postData[input.attr('name')] = input.val();
            }
         );
         console.log(postData);
         var request = $.ajax({
            url: "<?=base_url('planner/form_data/psched_userlist')?>",
            method: 'POST',
            data: { post : postData, sched_id : sched_id },
            beforeSend: function(jqXHR, settings){
               fieldsetGroup.find('input').attr('disabled','disabled');
               fieldsetGroup.find('button').attr('disabled','disabled');
            }
         });

         request.done(function(data) {
            collapseGroup.find('table').DataTable().draw();
            dataTable.find('.search_spinner').show();
            dataTable.find(".search_fld").prop('disabled', true);

            fieldsetGroup.find('input').val('').attr('disabled', false);
            fieldsetGroup.find('button').attr('disabled', false);
         });

         request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
            // fieldsetGroup.find('input').attr('disabled','');
            // fieldsetGroup.find('button').attr('disabled','');
                        fieldsetGroup.find('input').val('').attr('disabled', false);
                        fieldsetGroup.find('button').attr('disabled', false);
         });
      });
   });

});
</script>
