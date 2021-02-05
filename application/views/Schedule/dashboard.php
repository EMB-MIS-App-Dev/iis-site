<style media="screen">
  .fc-content:hover{
    background-color: inherit;
  }
  .tooltip{
      position:absolute;
      z-index:1020;
      display:block;
      visibility:visible;
      padding:5px;
      font-size:11px;
      opacity:0;
      filter:alpha(opacity=0)
  }
  .tooltip-inner{
      max-width:200px;
      padding:3px 8px;
      color:#fff;
      text-align:center;
      text-decoration:none;
      background-color:#000;
      -webkit-border-radius:4px;
      -moz-border-radius:4px;
      border-radius:4px;
  }
</style>
<div class="container-fluid">
  <div class="row">
    <?php for ($c=0; $c < sizeof($chkdatesched); $c++) { ?>
      <?php if($chkdatesched[$c]['date_schedule'] == date('Y-m-d')){ ?>
        <?php
          if($chkdatesched[$c]['sched_status'] == 'success' AND $chkdatesched[$c]['date_schedule'] ==  date('Y-m-d')){
            $alertcolor = "success";
          }else if($chkdatesched[$c]['sched_status'] == 'success' AND $chkdatesched[$c]['date_schedule'] !=  date('Y-m-d')){
            $alertcolor = "success";
          }else if($chkdatesched[$c]['sched_status'] == 'postponed'){
            $alertcolor = "danger";
          }else{
            $alertcolor = "primary";
          }
        ?>
        <div class="col-md-12">
          <div class="alert alert-<?php echo $alertcolor; ?>" role="alert">
            You have a schedule today: <b><?php echo $chkdatesched[$c]['subject']; ?></b>
            <?php if(empty($chkdatesched[$c]['sched_status']) AND $chkdatesched[$c]['date_schedule'] ==  date('Y-m-d') AND $chkdatesched[$c]['creator'] == $this->session->userdata('userid')){ ?>
            <button type="button" class="btn btn-success btn-sm" style="float:right;margin-right:5px;"  onclick="startsched('<?php echo $this->encrypt->encode($chkdatesched[$c]['cnt']); ?>');">Start Activity</button>
            <?php } ?>
            <button type="button" class="btn btn-info btn-sm" style="float:right;margin-right:5px;" onclick="schedule_details('<?php echo $this->encrypt->encode($chkdatesched[$c]['cnt']); ?>'); sched_status('<?php echo $this->encrypt->encode($chkdatesched[$c]['cnt']); ?>');" data-toggle="modal" data-target="#view_schedule">View Schedule</button>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
    <div class="col-md-12">
      <div style="display:flex;background-color: #DCE3F9;padding: 8px 10px 0px 10px;width: fit-content;margin: auto;border-radius: 3px;">
        <label style="display:flex;"><div style="height: 10px;width: 50px;margin-top:5px;background-color: #1CC88A;"></div><span style="color:#000;">&nbsp;In-progress</span></label>
        <label style="display:flex;margin-left:10px;"><div style="height: 10px;width: 50px;margin-top:5px;background-color: #264159;"></div><span style="color:#000;">&nbsp;Completed</span></label>
        <label style="display:flex;margin-left:10px;"><div style="height: 10px;width: 50px;margin-top:5px;background-color: #3788D8;"></div><span style="color:#000;">&nbsp;Upcoming Schedule(s)</span></label>
        <label style="display:flex;margin-left:10px;"><div style="height: 10px;width: 50px;margin-top:5px;background-color: #E74A3B;"></div><span style="color:#000;">&nbsp;Postponed / Cancelled</span></label>
      </div><hr>
    </div>

    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">National Schedules</h6>
          <i style="color:orange;" class="fa fa-info-circle" title="Double click event to view details"></i>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <div id="allschedule_calendar"  style="zoom:80%;"></div>
          </div>
        <!-- Card Body -->
      </div>
    </div>
    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><?php echo $_SESSION['region']; ?> Schedules</h6>
          <i style="color:orange;" class="fa fa-info-circle" title="Double click event to view details"></i>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <div id="schedule_calendar"  style="zoom:80%;"></div>
          </div>
        <!-- Card Body -->
      </div>
    </div>
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">My Schedules</h6>
          <?php if($_SESSION['add_event'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes'){ ?>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create_schedule"><i class="fa fa-plus"></i>&nbsp;Create Schedule</button>
          <?php } ?>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <div id="myschedule_calendar" class="col-centered" style="zoom:80%;"></div>
          </div>
        <!-- Card Body -->
      </div>
    </div>
    <?php if($chkaccntable > 0){ ?>
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Tag as Accountable</h6>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <div class="table-responsive" style="zoom:80%;">
              <table id="accountablescheds" class="table table-hover table-striped" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th> cnt </th>
                    <th> Date </th>
                    <th> Subject </th>
                    <th> Location </th>
                    <th> Remarks </th>
                    <th> Action </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        <!-- Card Body -->
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<?php
  $swal_arr = $this->session->flashdata('swal_arr');
  if(!empty($swal_arr)) {
    echo "<script>
      swal({
        title: '".$swal_arr['title']."',
        text: '".$swal_arr['text']."',
        type: '".$swal_arr['type']."',
        allowOutsideClick: false,
        customClass: 'swal-wide',
        confirmButtonClass: 'btn-success',
        confirmButtonText: 'Confirm',
        onOpen: () => swal.getConfirmButton().focus()
      })
    </script>";
  }
?>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.print.min.css" media="print">

<script type="text/javascript">
  $(document).ready(function(){
        $('#schedule_calendar').fullCalendar({
          header:{
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay',
          },
          //defaultDate: 'today',
          currentTimezone: 'Philippines', // an option!
          height: 800,
          displayEventTime: false,
          fixedWeekCount: false,
          contentHeight: 'auto',

          eventTextColor: 'white',
          editable: false,
          eventLimit: true, // allow "more" link when too many events
          selectable: true,
          selectHelper: false,
          select: function(start, end){
            $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
            $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
            $('#ModalAdd').modal('show');

          },
          eventRender: function(event, element) {
            // $(element).tooltip({title: event.title});
            element.bind('dblclick', function() {
              $('#title').val(event.title);
              $('#color').val(event.color);
              $('#view_schedule').modal('show');
              schedule_details(event.cnt);
              sched_status(event.cnt);
            });
          },
          events:
          {
            url: '<?php echo base_url(); ?>Schedule/Dashboard/calendar',
            method: 'POST',
          }

        });

        $('#allschedule_calendar').fullCalendar({
          header:{
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay',
          },
          //defaultDate: 'today',
          currentTimezone: 'Philippines', // an option!
          height: 800,
          displayEventTime: false,
          fixedWeekCount: false,
          contentHeight: 'auto',

          eventTextColor: 'white',
          editable: false,
          eventLimit: true, // allow "more" link when too many events
          selectable: true,
          selectHelper: false,
          select: function(start, end){
            $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
            $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
            $('#ModalAdd').modal('show');
          },
          eventRender: function(event, element) {
            // $(element).tooltip({title: event.title});
            element.bind('dblclick', function() {
              $('#title').val(event.title);
              $('#color').val(event.color);
              $('#view_schedule').modal('show');
              schedule_details(event.cnt);
              sched_status(event.cnt);
            });
          },
          events:
          {
            url: '<?php echo base_url(); ?>Schedule/Dashboard/nationalcalendar',
            method: 'POST',
          }

        });

        $('#myschedule_calendar').fullCalendar({
          header:{
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay',
          },

          //defaultDate: 'today',
          currentTimezone: 'Philippines', // an option!
          height: 800,
          displayEventTime: false,
          fixedWeekCount: false,
          contentHeight: 'auto',

          eventTextColor: 'white',
          editable: false,
          eventLimit: true, // allow "more" link when too many events
          selectable: true,
          selectHelper: false,
          select: function(start, end){
            $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
            $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
            $('#ModalAdd').modal('show');
          },
          eventRender: function(event, element) {
            // $(element).tooltip({title: event.title});
            element.bind('dblclick', function() {
              $('#title').val(event.title);
              $('#color').val(event.color);
              $('#view_schedule').modal('show');
              schedule_details(event.cnt);
              sched_status(event.cnt);
            });
          },
          events:
          {
            url: '<?php echo base_url(); ?>Schedule/Dashboard/my_schedules',
            method: 'POST',
          }

        });
 <?php if($chkaccntable > 0){ ?>
        var table = $('#accountablescheds').DataTable({
            responsive: true,
            paging: true,
            language: {
              "infoFiltered": "",
            },
            "serverSide": true,
            // "order": [[ 4, "desc"]],
            "ajax": "<?php echo base_url(); ?>Schedule/Serverside",
            "columns": [
              { "data": "cnt","visible": false},
              { "data": "date_schedule","searchable": true},
              { "data": "subject","searchable": true},
              { "data": "location","searchable": true},
              { "data": "remarks","searchable": true},
              {
                "data": null,
                  "render": function(data, type, row, meta){
                     data = '<button type="button" class="btn btn-info btn-sm" onclick=schedule_details("'+row['cnt']+'"); data-toggle="modal" data-target="#view_schedule">View Schedule</button>';
                    return data;
                  }
              },
            ]
        });
 <?php } ?>
    });


</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.js"></script>
