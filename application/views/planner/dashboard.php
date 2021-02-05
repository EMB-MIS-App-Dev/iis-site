
<div class="container-fluid">

   <div class="col-md-12">
      <div style="display:flex;background-color: #DCE3F9;padding: 8px 10px 0px 10px;width: fit-content;margin: auto;border-radius: 3px;">
         <label class="event-label"><div class="event-legend" style="background-color: #1CC88A;"></div>&nbsp;<span>In-progress</span></label>
         <label class="event-label"><div class="event-legend" style="background-color: #264159;"></div>&nbsp;<span>Completed</span></label>
         <label class="event-label"><div class="event-legend" style="background-color: #3788D8;"></div>&nbsp;<span>Upcoming Schedule(s)</span></label>
         <label class="event-label"><div class="event-legend" style="background-color: #E74A3B;"></div>&nbsp;<span>Postponed / Cancelled</span></label>
      </div>
   </div>
   <hr>

   <div class="col-md-12">
      <div class="trans-layout card shadow mb-4">
         <div class="card-body">
            <div class="row">

               <div class="col-md-3">
                  <div class="col-xl-12 col-lg-12 h-100 mb-4">
                     <div class="trans-layout card h-100 mb-4">
                        <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-th-list"></i> Calendar Filter</h6> </div> -->
                        <div class="card-body">
                           <div> </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-9">
                  <div id="calendar" class="col-centered" style="zoom:80%;"></div>
               </div>

            </div>
         </div>
      </div>
   </div>

<div class="row">
   <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> Planner List</h6>
            <button id="addScheduleButton" type="button" class="btn btn-labeled btn-success" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#addScheduleModal"><span class="btn-label"><i class="fas fa-plus"></i></span>&nbsp;Add New Event Schedule</button>
         </div>

         <?php
         echo form_open_multipart('planner/main/sample_submit');
            echo '<button type="submit">send</button>';
         echo form_close();
         ?>

         <div class="card-body">
            <div class="table-responsive">
               <table id="dataTable" class="table table-hover table-striped" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>created_by</th>
                        <th>created_date</th>
                        <th>Activities</th>
                        <th>Location</th>
                        <th>start_date</th>
                        <th>Scheduled Date</th>
                        <th>compliance</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Office _</th>
                        <th></th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>

      </div>
   </div>
</div>

</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.print.min.css" media="print">

<script type="text/javascript">
$(document).ready(function(){

   $('#addScheduleButton').click( function() {
      let button = $(this);
      var request = $.ajax({
         url: "<?=base_url('planner/ajax_data/add_new_schedule')?>",
         method: 'POST',
         beforeSend: function(jqXHR, settings){
            button.attr('disabled', true);
         }
      });

      request.done(function(data) {
         $(button.attr('data-target')).modal('show');
         $('#addScheduleModal input[name="sched_id"]').val(data);
         $('#addScheduleModal input#sched_id').val(data);
         button.attr('disabled', false);
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Request failed: " + textStatus );
         button.attr('disabled', false);
      });
   });

   $('#accountableSelectize').selectize({
      maxItems: null
   });
   $('#hostsSelectize').selectize({
      maxItems: null
   });
   $('#participantsSelectize').selectize({
      maxItems: null
   });

   $('#displayselectize').selectize();

   $('#calendar').fullCalendar({
      header:{
         left: 'prev,next today',
         center: 'title',
         right: 'month,basicWeek,basicDay',
      },
      //defaultDate: 'today',
      currentTimezone: 'Philippines', // an option!
      // height: 800,
      displayEventTime: false,
      fixedWeekCount: false,
      eventTextColor: 'white',
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: {
         url: '<?=base_url("planner/ajax_data/psched_list")?>',
         method: 'POST',
         // dataType: 'json',
      },
      eventClick: function(info) {
         let modal = $('#plannerCalendarModal');
         let scheduledDate = info.start_date;

         modal.find('#activities').html(info.title);
         modal.find('#location').html(info.location);
         if(info.end_date != null) {
            scheduledDate = info.start_date+' - '+info.end_date;
         }
         modal.find('#schedDate').val(scheduledDate);
         modal.find('#hosts').html(info.hosts);
         modal.find('#participants').html(info.participants);
         modal.find('#status').val(info.status);
         modal.find('#remarks').html(info.remarks);

         modal.modal('show');
      },
      // eventColor: "#3788D8",
      // selectable: true,
      // selectHelper: false,
      // select: function(start, end) {
      //    // $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
      //    // $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
      //    $('#ModalAdd').modal('show');
      // },
      // eventRender: function(event, element) {
      //    element.bind('dblclick', function() {
      //       $('#title').val(event.title);
      //       $('#depdate').val(event.depdate);
      //       $('#tomorrow').val(event.tomorrow);
      //       $('#color').val(event.color);
      //       $('#travel_details').modal('show');
      //       calendar_details_dashboard(event.token);
      //    });
      // },
   });

   // ########################################## DATATABLES ################################################## //
   var tableData = {
      // 'region_filter': $('#trans_regional_filter').val(),
      'user_region': '<?php echo $user_region; ?>',
      'filter': '<?php echo $trans_filter; ?>',
   };
   var table = $('#dataTable').DataTable({
      dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-2'<'region_slct'>><'col-sm-12 col-md-2'><'col-sm-12 col-md-1'<'col_filter'>><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      order: [[0, "asc"]],
      language: {
         "infoFiltered": "",
         processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
      },
      serverSide: true,
      processing: true,
      responsive: true,
      ajax: {
         "url": "<?php echo base_url('planner/table_data/psched_list'); ?>",
         "type": 'POST',
         "data": function ( d ) {
            return  $.extend(d, tableData);
         },
      },
      rowCallback: function(row, data) {
         if(data['area_scope'].search('<?=$user["region"]?>') == -1) {
            $(row).hide();
         }
      },
      columns: [
         { "data": "id" },
         { "data": "created_by", visible: false },
         { "data": "created_date", searchable: false, visible: false },
         { "data": "activities" },
         { "data": "location" },
         { "data": "start_date", searchable: false, visible: false },
         { "data": "end_date" },
         { "data": "compliance", searchable: false, visible: false },
         { "data": "status" },
         { "data": "remarks" },
         { "data": "area_scope" },
         { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
               // <a class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;
               return '<a class="deletebtn text-primary"><i class="far fa-eye"></i></a>';
            }
         }
      ]
   });
});

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.js"></script>
