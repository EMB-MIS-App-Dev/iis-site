<style>
  .fc-center {
    color: #000;
  }
  #onlinescroll::-webkit-scrollbar-track
  {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
  }

  #onlinescroll::-webkit-scrollbar
  {
    width: 5px;
    background-color: #F5F5F5;
  }

  #onlinescroll::-webkit-scrollbar-thumb
  {
    background-color: #0C4F88;
    border: 2px solid #0C4F88;
  }
  #onlinescroll{
    overflow: scroll;overflow-x: hidden;padding-top:0px!important;
  }
</style>

<?php if ($supportdata[0]['staff'] == $this->session->userdata('userid')): ?>
  <?php if (count($supportdata) > 0): ?>
    <div class="alert alert-success" role="alert" style="position: absolute;z-index: 99999;right: 0;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
      <h4 class="alert-heading">Reminder !</h4>
      <p>Your ticket has been attended with ticket no <?=$supportdata[0]['ticket_no']?>. Click this <a href="<?php echo base_url(); ?>/Support/Emb_support/?sp_ticket_no=<?=$this->encrypt->encode($supportdata[0]['ticket_no'])?>">link</a> for more details </p>
      <hr>
    </div>
  <?php endif; ?>

<?php endif; ?>
    <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Content Row -->
        <!-- Content Row -->

        <div class="row">
          <style media="screen">
            .bulletin_notif{
              background-color: red;
              border-radius: 50px;
              color: #FFF;
              font-size: 7pt;
              font-weight: 900;
              padding: 2px 5px 2px 5px;
              position: absolute;
            }
          </style>
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <ul class="nav nav-tabs" id="bulletin" role="tablist" style="border:0px;font-weight: 100;">

                    <li class="nav-item">
                      <a class="nav-link active" id="regional-tab" data-toggle="tab" href="#regional" role="tab" aria-controls="regional"
                        aria-selected="false" onclick="localbltnsn();">Local Bulletin

                          <?php if($bulletinnotif[0]['bulletin_count_regional'] > 0){ echo '<span class="bulletin_notif" id="bulletin_notifr" style="margin-top: -8px;">'.$bulletinnotif[0]['bulletin_count_regional'].'</span>'; } ?>

                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="national-tab" data-toggle="tab" href="#national" role="tab" aria-controls="national"
                        aria-selected="true" onclick="ntlbltnsn();">National Bulletin

                          <?php if($bulletinnotif[0]['bulletin_count_national'] > 0){ echo '<span class="bulletin_notif" id="bulletin_notifn" style="margin-top: -8px;">'.$bulletinnotif[0]['bulletin_count_national'].'</span>'; } ?>

                      </a>
                    </li>
                  </ul>
                </h6>

                  <?php //if($this->session->userdata('add_bulletin') == 'yes' OR $this->session->userdata('superadmin_rights') == 'yes'){ ?>
                    <button type="button" data-toggle="modal" data-target="#addtobulletin" class="btn btn-success btn-sm" onclick="createnewinbulletin();checkdraft();">Add to Bulletin</button>
                  <?php //} ?>
                  <!-- modal -->
                  <div class="modal fade" id="addtobulletin" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content" style="border: none;">
                        <div class="modal-header">
                          <h5 class="modal-title" id="useraccountsModalLabel">Add New to Bulletin</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12" id="bulletincnt_">
                                <input type="hidden" id="bulletincnt" class="form-control" value="<?php echo $this->encrypt->encode(''); ?>">
                              </div>
                              <div class="col-md-12">
                                <label>* What: (Subject)</label>
                                <!-- <input type="text" class="form-control" id="bulletintitle"> -->
                                <textarea id="bulletintitle" class="form-control" rows="8" cols="50"></textarea>
                              </div>
                              <div class="col-md-8">
                                <label>Where: (Venue)</label>
                                <input type="text" class="form-control" id="bulletinwhere">
                              </div>
                              <div class="col-md-4">
                                <label>When: (Date/Time Applicable)</label>
                                <input type="datetime-local" class="form-control" placeholder="mm/dd/yyyy hh:mm am/pm" id="bulletinwhen">
                              </div>
                              <div class="col-md-12" style="display:flex;">
                                <div class="col-md-6" style="padding:0px;">
                                  <label>* Attachment(s):</label>
                                </div>
                                <div class="col-md-6" style="padding:0px;text-align:right;">
                                  <input type="checkbox" id="visibletonational" value="<?php echo $this->encrypt->encode('national'); ?>">
                                  <label>Visible to National</label>
                                </div>
                              </div>
                              <div class="col-md-12" style="display:flex;">
                                <input type="file" class="form-control" name="bulletinfiles[]" id="bulletinfiles" multiple>
                                <button type="button" class="btn btn-warning btn-sm" title="Upload file(s)" onclick="bulletinupload($('#bulletincnt').val());" style="margin-left: 5px;width:5%;"><span class="fa fa-upload"></span></button>
                              </div>
                              <div class="col-md-12">
                                <div class="progress" id="bulletinfiles_" style="display:none; margin-top:5px;">
                                  <div class="progress-bar progress-bar-striped progress-bar-animated" id="bulletinfilesprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <span id="bulletinfilesprogresspercentage_" style=""></span>
                                  </div>
                                </div>
                              </div>
                              <input type="hidden" id="attachmentcounter_" class="form-control" value="<?php echo $this->encrypt->encode('0'); ?>">
                              <div class="col-md-12" id="uploadedfilesbulletin_" style="max-height: 400px;overflow-y:scroll;"></div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-md" style="float:right;" onclick="publishtobulletin($('#bulletincnt').val(),$('#bulletintitle').val(),$('#attachmentcounter_').val(),$('#bulletinwhere').val(),$('#bulletinwhen').val());"><span class="fa fa-sticky-note"></span>&nbsp;Post</button>
                          </div>
                      </div>
                    </div>
                  </div>
                  <!-- modal -->


              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div class="chart-area">


                    <div class="tab-content" id="bulletinContent">
                      <div class="tab-pane fade" id="national" role="tabpanel" aria-labelledby="national-tab">
                        <div id="table-responsive" style="margin:0px;zoom:80%;">
                          <table class="table table-hover table-striped table-responsive-custom" id="national_bulletin_table" width="100%" cellspacing="0" style="font-weight: 100;">
                            <thead>
                              <tr>
                                <th>cnt</th>
                                <th>Posted on</th>
                                <th>Posted on</th>
                                <th>Subject Inner</th>
                                <th>Subject</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade show active" id="regional" role="tabpanel" aria-labelledby="regional-tab">
                        <div id="table-responsive" style="margin:0px;zoom:80%;">
                          <table class="table table-hover table-striped table-responsive-custom" id="regional_bulletin_table" width="100%" cellspacing="0" style="font-weight: 100;">
                            <thead>
                              <tr>
                                <th>cnt</th>
                                <th>Posted on</th>
                                <th>Posted on</th>
                                <th>Subject Inner</th>
                                <th>Subject</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>
                    </div>


                </div>
              </div>
            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="padding-bottom: 25px !important;padding-top: 25px !important;">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo date("l - F d, Y"); ?></h6>

                <?php if($this->session->userdata('superadmin_rights') == 'yes'){ ?>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewallonlineusers" onclick="viewallonlineusers();">View all online users</a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewallonlineusers_smr" onclick="viewallonlineusers_smr();">View all online users SMR</a>

                      <!-- <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a> -->
                    </div>
                  </div>
                  <div class="modal fade" id="viewallonlineusers" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content" style="border: none;">
                        <div class="modal-header">
                          <h5 class="modal-title" id="useraccountsModalLabel">All Online Users</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <div class="modal-body">
                              <style media="screen">
                              #viewallonlineusers_::-webkit-scrollbar-track
                              {
                                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                                background-color: #F5F5F5;
                              }

                              #viewallonlineusers_::-webkit-scrollbar
                              {
                                width: 5px;
                                background-color: #F5F5F5;
                              }

                              #viewallonlineusers_::-webkit-scrollbar-thumb
                              {
                                background-color: #0C4F88;
                                border: 2px solid #0C4F88;
                              }
                              #viewallonlineusers_{
                                overflow: scroll;overflow-x: hidden;padding-top:0px!important;
                                height: 500px;
                              }
                              </style>
                              <div id="viewallonlineusers_"></div>
                          </div>
                          <div class="modal-footer"></div>
                      </div>
                    </div>
                  </div>
                  <!-- view all online users smr -->
                  <div class="modal fade" id="viewallonlineusers_smr" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content" style="border: none;">
                        <div class="modal-header">
                          <h5 class="modal-title" id="useraccountsModalLabel">All Online Users SMR <span id="total_online_smr_user"></span></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <div class="modal-body">
                              <style media="screen">
                              #viewallonlineusers_::-webkit-scrollbar-track
                              {
                                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                                background-color: #F5F5F5;
                              }

                              #viewallonlineusers_::-webkit-scrollbar
                              {
                                width: 5px;
                                background-color: #F5F5F5;
                              }

                              #viewallonlineusers_::-webkit-scrollbar-thumb
                              {
                                background-color: #0C4F88;
                                border: 2px solid #0C4F88;
                              }
                              #viewallonlineusers_{
                                overflow: scroll;overflow-x: hidden;padding-top:0px!important;
                                height: 500px;
                              }
                              </style>
                              <div id="viewallonlineusers_smr_container"></div>
                          </div>
                          <div class="modal-footer"></div>
                      </div>
                    </div>
                  </div>
                <?php } ?>

              </div>
              <!-- Card Body -->
              <div class="card-body" style="padding-right:0px!important;">
                <div class="chart-pie pt-4 pb-2" id="onlinescroll">
                  <?php if($_SESSION['userid'] != ''){ ?>
                    <div class="row">
                      <?php
                        for ($ol=0; $ol < sizeof($selectonlineusers); $ol++) {
                            $datetime = date("Y-m-d H:i");
                            $date = date("Y-m-d");
                            $currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
                            $mname  = !empty($selectonlineusers[$ol]['mname']) ? $selectonlineusers[$ol]['mname'][0].". " : "";
                            $suffix = !empty($selectonlineusers[$ol]['suffix']) ? " ".$selectonlineusers[$ol]['suffix'] : "";
                            $ifn   = utf8_encode(strtolower($selectonlineusers[$ol]['fname']." ".$mname.$selectonlineusers[$ol]['sname']));
                            $rplc   = str_replace('Ã±', '&ntilde;', $ifn);
                            $name = ucwords(str_replace('ã±', '&ntilde;', $rplc)).$suffix;
                            if ((date('H:i', strtotime($currenttimeminus5minutes)) < date('H:i', strtotime($selectonlineusers[$ol]['timestamp']))) AND (date('Y-m-d', strtotime($selectonlineusers[$ol]['timestamp'])) == $date)) {
                        ?>
                          <div class="col-md-1">
                            <span class="fa fa-circle" style="font-size:10pt;color:#4BCB20;"></span>
                          </div>
                          <div class="col-md-11">
                            <label style="color:#050505;"><?php echo $name; ?></label>
                          </div>
                        <?php } ?>
                      <?php } ?>
                      <?php
                        for ($ol=0; $ol < sizeof($selectofflineusers); $ol++) {
                            $datetime = date("Y-m-d H:i");
                            $date = date("Y-m-d");
                            $currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
                            $mname  = !empty($selectofflineusers[$ol]['mname']) ? $selectofflineusers[$ol]['mname'][0].". " : "";
                            $suffix = !empty($selectofflineusers[$ol]['suffix']) ? " ".$selectofflineusers[$ol]['suffix'] : "";
                            $ifn   = utf8_encode(strtolower($selectofflineusers[$ol]['fname']." ".$mname.$selectofflineusers[$ol]['sname']));
                            $rplc   = str_replace('Ã±', '&ntilde;', $ifn);
                            $name = ucwords(str_replace('ã±', '&ntilde;', $rplc)).$suffix;
                            $datimeofuser = !empty(date('H:i', strtotime($selectofflineusers[$ol]['timestamp']))) ? date('H:i', strtotime($selectofflineusers[$ol]['timestamp'])) : "00:00";
                            $datimeofusertitle = !empty($selectofflineusers[$ol]['timestamp']) ? date('M d, Y - l, h:i a', strtotime($selectofflineusers[$ol]['timestamp'])) : "";
                            if (((date('Y-m-d', strtotime($date)) != date('Y-m-d', strtotime($selectofflineusers[$ol]['timestamp']))) OR (date('H:i', strtotime($currenttimeminus5minutes)) > $datimeofuser))) {
                        ?>
                          <div class="col-md-1">
                            <span class="fa fa-circle" style="font-size:10pt;color:#70757A;"></span>
                          </div>
                          <div class="col-md-11">
                            <label style="color:#858FB1;" title="Last activity: <?php echo $datimeofusertitle; ?>"><?php echo $name; ?></label>
                          </div>
                        <?php } ?>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-circle" style="color:#4BCB20;"></i>&nbsp;Online
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle" style="color:#70757A;"></i>&nbsp;Offline
                  </span>
                </div>
              </div>
            </div>
          </div>
          <?php if ($this->session->userdata('userid') == 157 || $this->session->userdata('userid') == 125 || $this->session->userdata('userid') == 1554): ?>

            <div class="col-xl-12 col-lg-12">
              <div class="trans-layout card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ticket - test only</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <table class="table table-hover" id="sec_support_table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Ticket #</th>
                        <th>Request Date</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Case Handler</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- Card Body -->
              </div>
            </div>
          <?php endif; ?>
          <div class="col-xl-12 col-lg-12">
            <div class="trans-layout card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Travel Calendar</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div id="calendar" class="col-centered" style="zoom:80%;"></div>
              </div>
              <!-- Card Body -->
            </div>
          </div>

        </div>

      </div>


      <style media="screen">
      #sec_support_table div.dataTables_wrapper div.dataTables_processing {
       top: 5%;
      }
      #sec_support_table th { font-size: 12px; }
      #sec_support_table td { font-size: 11px; }
      </style>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.print.min.css" media="print">

      <script type="text/javascript">
        $(document).ready(function(){
              $('#calendar').fullCalendar({
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
                  element.bind('dblclick', function() {
                    $('#title').val(event.title);
                    $('#depdate').val(event.depdate);
                    $('#tomorrow').val(event.tomorrow);
                    $('#color').val(event.color);;
                    $('#travel_details').modal('show');
                    calendar_details_dashboard(event.token);
                  });
                },
                events:
                {
                  url: '<?php echo base_url(); ?>Travel/Dashboard/calendar',
                  method: 'POST',
                }
                // '<?php echo base_url(); ?>Travel/Dashboard/calendar_data',

              });
          });

          var national_bulletin_table = $('#national_bulletin_table').DataTable({
            responsive: true,
            paging: true,
            language: {
              "infoFiltered": "",
            },
            "serverSide": true,
            pageLength : 4,
            "bLengthChange": false,
            "bInfo" : false,
            "order": [[ 1, "desc"] ],
            "ajax": "<?php echo base_url(); ?>Bulletin/Serverside/bulletinn",
            "columns": [
              { "data": "cnt", "visible": false},
              { "data": "datetime_posted", "visible": false},
              { "data": 4, "visible": true, "sortable": false},
              { "data": "title", "visible": false},
              {
                "data": null,
                  "render": function(data, type, row, meta){
                      var title = row['title'];
                      if(row[2]  > 50){
                        data = "<span title='"+row['title']+"'>"+title.substring(0,50)+"...</span>";
                      }else{
                        data = "<span title='"+row['title']+"'>"+row['title']+"</span>";
                      }

                    return data;
                  }
              },
              {
                "data": null,
                  "render": function(data, type, row, meta){

                      data = "<button class='btn btn-info btn-sm' href='#' style='height: 30px; width: 100%;' data-toggle='modal' data-target='#Viewbulletinmdl' onclick=viewbulletindetails('"+row['cnt']+"');bulletinoptions('"+row['cnt']+"');ntlbltnsn();>View</button>";

                    return data;
                  }
              },
            ]
          });

          var regional_bulletin_table = $('#regional_bulletin_table').DataTable({
            responsive: true,
            paging: true,
            language: {
              "infoFiltered": "",
            },
            "serverSide": true,
            pageLength : 4,
            "bLengthChange": false,
            "bInfo" : false,
            "order": [[ 1, "desc"] ],
            "ajax": "<?php echo base_url(); ?>Bulletin/Serverside/bulletinr",
            "columns": [
              { "data": "cnt", "visible": false},
              { "data": "datetime_posted", "visible": false},
              { "data": 4, "visible": true, "sortable": false},
              { "data": "title", "visible": false},
              {
                "data": null,
                  "render": function(data, type, row, meta){
                      var title = row['title'];
                      if(row[2]  > 50){
                        data = "<span title='"+row['title']+"'>"+title.substring(0,50)+"...</span>";
                      }else{
                        data = "<span title='"+row['title']+"'>"+row['title']+"</span>";
                      }

                    return data;
                  }
              },
              {
                "data": null,
                  "render": function(data, type, row, meta){

                      data = "<button class='btn btn-info btn-sm' href='#' style='height: 30px; width: 100%;' data-toggle='modal' data-target='#Viewbulletinmdl' onclick=viewbulletindetails('"+row['cnt']+"');bulletinoptions('"+row['cnt']+"');localbltnsn();>View</button>";

                    return data;
                  }
              },
            ]
          });

          var tablesec = $('#sec_support_table').DataTable({
                responsive: true,
                paging: true,
                "serverSide": true,
                "ajax": "<?php echo base_url(); ?>Support/Sp_server_side/sec_support_table",
                "columns": [
                  { "data": "ticket_no","searchable": true},
                  { "data": "ticket_date","searchable": true},
                  { "data": "ctype","searchable": true},
                  { "data": "csdsc","searchable": true},
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
                            data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/processing.gif" alt="" title="Processing"/> Processing (forwarded)';
                          }else if (row['status'] == 'attended') {
                            data = '<img style="width:25px" src="https://iis.emb.gov.ph/embis/uploads/gif/approved.gif" alt="" title="Attended"/> Attended (forwarded)';
                          }else if (row['status'] == 'solved') {
                              data = '<i class="fas fa-thumbs-up text-primary" title="Solved"></i> Solved (forwarded)';
                          }else if (row['status'] == 'pending') {
                              data = '<i class="fa fa-hourglass" style="color:red" aria-hidden="true"  title="Pending"></i> Pending (forwarded)';
                          }else if (row['status'] == 'unresolved') {
                              data = '<i class="fa fa-times" style="color:red" aria-hidden="true"  title="Unresolved"></i> Unresolved (forwarded)';
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
                          data = "<a class='btn btn-sm' href=''  data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' onClick=emb_process_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a>";
                        }else if (row['status'] == 'processing') {
                          data = "<a class='btn btn-sm' href=''  data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"') title='View'><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='='#'' data-toggle='modal' data-target='#emb_supp_add_resolution' onClick=emb_add_resolution('"+row['ticket_ass_id']+"') ><span class='fa fa-check' style='color:#104E91' title='Mark as solved'></span></i></a><a class='btn btn-sm' href=''  onClick=cancel_emb_process_ticket('"+row['ticket_ass_id']+"') title='Cancel'><span class='fa fa-window-close' style='color:#104E91'></span></a><a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_pending_request'  onClick=pending_process_ticket('"+row['ticket_ass_id']+"') title='Mark as Pending'><i class='fas fa-clock' aria-hidden='true' style='color:#104E91' ></i></a>";
                        }else if (row['status'] == 'attended') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                        }else if (row['status'] == 'solved') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                        }else if (row['status'] == 'pending') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a>";
                        }else if (row['status'] == 'unresolved') {
                          data = "<a class='btn btn-sm' href='' data-toggle='modal' data-target='#emb_supp_view_ticket' onClick=emb_view_support_request('"+row['ticket_ass_id']+"')><span class='fa fa-eye' style='color:#104E91;'></span></a><a class='btn btn-sm' href='' onClick=emb_process_ticket('"+row['ticket_ass_id']+"') ><span class='fa fa-cog' style='color:#104E91;' title='Troubleshoot'></span></a>";
                        }

                        return data;
                      }
                  },
                ]
            });

      </script>

      <script type="text/javascript">
        $(document).ready(function(){
          bltnppot();
          function bltnppot(){
            $.ajax({
              url: base_url+"/Index/bltnppot",
              type: 'POST',
              async : true,
              data: { },
              success:function(response){
                var obj = JSON.parse(response);
                if(obj.status == 'show'){
                  $('#Viewbulletinmdl').modal('show');
                  viewbulletindetails(obj.token);
                  bulletinoptions(obj.token,obj.origin);
                }
              }
            });
          }
        });
      </script>

      <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/moment.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.js"></script>

      <!-- Travel Order Details -->
        <div class="modal fade" id="travel_details" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="useraccountsModalLabel">Travel Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div id="travel-order-modal-details" class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
          </div>
        </div>
      <!-- Travel Order Details -->


      <div class="modal fade" id="Viewbulletinmdl" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="useraccountsModalLabel">ANNOUNCEMENT</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div id="bulletin-details_" class="modal-body"></div>
              <div class="modal-footer">
                <div id="bulletinoptions_" class="row"></div>
              </div>
          </div>
        </div>
      </div>

<!-- for support modal case handler -->

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
                <label for="view_emb_supp_remarks">Remarks:</label>
                <textarea  class="form-control" name="" id="view_emb_supp_remarks" rows="4" style="width:100%" readonly></textarea>
        </div>
        <div class="col-md-12">
            <label for="sp_attachment_container">Attachment:</label>
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
<!-- for adding resolution from case handler support -->
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
                <label for="emb_supp_remarks">Remarks:</label>
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
<!-- for setting as pending from case handler  -->
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
                <label for="emb_supp_pending_remarks">Remarks:</label>
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
