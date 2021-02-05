<div class="wrapper">
  <!-- Left side column. contains the logo and sidebar -->
  <div class="content-wrapper">
    <!-- Main content -->

    <!-- /.content -->
    <div class="col-xl-12 col-lg-12">
      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Vehicle Travel Calendar</h6>
          <button type="button" class="m-0 btn-primary btn" name="button" data-toggle='modal' data-target='#edit_main_company'>Assign</button>
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

<div class="modal fade" id="edit_main_company" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#018E7F;">
        <h7 class="modal-title" style="color:#FFF;"> Assign Vehicle</h7>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" id="submit-vh-ticket" method="post" action="">
        <div class="col-xl-12 mb-2 mt-2">
          <div class="row">
              <div class="col-md-6">
                <label for="">Departure Date:<span style="color:red;">*</span></label>
                <input type="date" name="" value="" class="form-control" id="departure_date_vh">
              </div>
              <div class="col-md-5">
                    <label for="">Arrival Date:<span style="color:red;">*</span></label>
                <input type="date" name="" value="" class="form-control" id="arrival_date_vh">
              </div>
              <div class="col-md-1">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" style="    top: 31px;" id="search_to_btw_date">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
              </div>
          </div>
        </div>
        <hr>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                <span style="color:red;position: absolute;right: 0;top: -10px;">*</span>
                <select class="form-control" name="vehicle" id="vehicle-id">
                  <option value="" selected disabled>--Select Vehicle--</option>

                </select>
              </div>
              <div class="col-md-6">
                <span style="color:red;position: absolute;right: 0;top: -10px;">*</span>
                <select class="form-control" name="driver" id="driver-id">
                  <option value="" selected disabled>--Select Date--</option>
                </select>
              </div>
          </div>
        </div>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                <p>
                  <button class="btn btn-primary text-center" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="width:100%">
                    <i class="fa fa-eye" aria-hidden="true"></i> View list of unavaiable Driver on this date
                  </button>
                </p>
                <div class="collapse" id="collapseExample">
                  <div class="card card-body">
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <p>
                  <button class="btn btn-primary text-center" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2" style="width:100%">
                    <i class="fa fa-eye" aria-hidden="true"></i> View list of unavaiable Vehicle on this date
                  </button>
                </p>
                <div class="collapse" id="collapseExample2">
                  <div class="card card-body">
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                  </div>
                </div>
              </div>

          </div>
        </div>
        <div class="table-responsive" style="margin-top: 10px;">
          <table class="table table-hover" id="user_list" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th> <input type="checkbox" name="check_all" value="" id="select_all_staff"></th>
                <th>Employee</th>
                <th>Purpose</th>
                <th>Departure Date</th>
                <th>Arrival Date</th>
                <th>Destination</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer modal-footer-first">
        <button type="button" class="btn btn-primary" id="proceed-vh-assign">Proceed</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </form>
      <form class="" method="post" id="submit-assign-vh"  action="<?=base_url()?>Vehicle/Main/submit_assign_vh" style="display:none;margin-top: -20px!important;">

        <div class="col-md-12">
          <div class="row">
              <div class="col-md-6">
                <label for=""> Vehicle:</label>
                  <input type="text" name="vehicle" value="" id="vh-vehicle-text" class="form-control" readonly>
                <input type="hidden" name="vehicle" value="" id="vh-vehicle" class="form-control">
              </div>
              <div class="col-md-6">
                  <label for=""> Driver:</label>
                    <input type="text" name="driver" value="" id="vh-driver-text" class="form-control" readonly>
                <input type="hidden" name="driver" value="" id="vh-driver" class="form-control">
              </div>
          </div>
        </div>
        <div class="col-xl-12 mb-3">
          <div class="row">
              <div class="col-md-6">
                <label for="">Departure Date:</label>
                <input type="date" name="departure_date_vh_to" value="" class="form-control" id="departure_date_vh_to">
              </div>
              <div class="col-md-5">
                    <label for="">Arrival Date:</label>
                <input type="date" name="arrival_date_vh_to" value="" class="form-control" id="arrival_date_vh_to">
              </div>
              <div class="col-md-1">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" style="    top: 31px;" id="search_to_btw_date">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <label for=""> Passenger:</label>
                <div  id="vh-confirm">
                </div>
              </div>
              <div class="col-md-6">
                <label for=""> Destinations:</label>
                <div id="vh-destinations">
                </div>
              </div>
            </div>
        </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="prev-vh-assign">Previous</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="vehicle_details" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Vehicle Travel Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div id="vehicle_details_to_details" class="modal-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4" id="details-style">
                <label id="viewtitle">Vehicle Travel No:</label>
                <input type="text" class="form-control" disabled="" value="" id="vehicle_travel_no" readonly>
              </div>
              <div class="col-md-4" id="details-style">
                <label id="viewtitle">Departure Date:</label>
                <input type="date" class="form-control" disabled="" value="" id="selected_departure" readonly>
              </div>
              <div class="col-md-4" id="details-style">
                <label id="viewtitle">Arrival Date:</label>
                <input type="date" class="form-control" disabled="" value="" id="selected_arrival" readonly>
              </div>
            </div>

          </div>
          <div class="col-md-12" >
            <div class="row">
              <div class="col-md-6">
                <label >Driver:</label>
                    <input type="text" class="form-control" name="" value="" id="selected_driver" readonly>
              </div>
              <div class="col-md-6">
                <label>Vehicle:</label>
                    <input type="text" class="form-control" name="" value="" id="selected_vehicle" readonly>
              </div>
            </div>
          </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label id="vehicle">Passengers:</label>
                  <div id="selected_passengers_cont">
                  </div>
                </div>

                <div class="col-md-6" >
                  <label id="driver">Destinations:</label>
                  <div id="selected_dest_cont">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

    </div>
  </div>
</div>

<?php if ($this->session->flashdata('success_vh_ticket') != ''): ?>
<script type="text/javascript">
 $(document).ready(function() {
     Swal.fire(
       'Awesome!',
       'Vehicle has been successfully assigned  !',
       'success'
   )
 });
</script>
<?php endif; ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.print.min.css" media="print">


<style media="screen">
  div.dataTables_wrapper div.dataTables_processing {
   top: 5%;
  }
  th { font-size: 12px; }
  td { font-size: 11px; }
  .fc-day-grid-event {
  height: 17px;
  font-size: 13px;
  color: white !important;
  }

  div#vh-confirm input {
  margin-bottom: 5px;
  }
  div#vh-destinations input {
  margin-bottom: 5px;
  }

</style>
<script>
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
          $('#depdate').val(event.departure_date_vh_to);
          $('#tomorrow').val(event.tomorrow);
          $('#color').val(event.color);
          $('#vehicle_details').modal('show');
          vh_calendar_details_dashboard(event.id);
        });
      },
      events:
      {
        url: '<?php echo base_url(); ?>Vehicle/Main/calendar',
        method: 'POST',
      }
    });


  initDataTable();
})

$('#search_to_btw_date').on('click',function(){
  var dep_date  = $('#departure_date_vh').val();
  var arr_date  = $('#arrival_date_vh').val();
  initDataTable(dep_date,arr_date);
  $.ajax({
        url: base_url+"/Vehicle/Main/get_driver_btw_date",
        type: 'POST',
        data:{'dep_date':dep_date,'arr_date':arr_date},
        async : true,
        success:function(response)
          {
                var data = JSON.parse(response);
                // console.log(data);die();
                var avl_drivers = data.avl_drivers;
                var avl_vehicle = data.avl_vehicle;
                // var unavl_drivers = data.unavl_drivers;
                // var unavl_vehicle = data.unavl_vehicle;
                var htmldr = '';
                htmldr+="<option value='' selected disabled>--Available Driver--</option>";
                for (var i = 0; i < avl_drivers.length; i++) {
                  htmldr+="<option value="+avl_drivers[i].userid+">"+avl_drivers[i].fname+" "+avl_drivers[i].sname+"</option>";
                }

                var htmlvh = '';
                htmlvh+="<option value='' selected disabled>--Available Vehicle--</option>";
                for (var i = 0; i < avl_vehicle.length; i++) {
                  htmlvh+="<option value="+avl_vehicle[i].vhid+">"+avl_vehicle[i].type+" -"+avl_vehicle[i].color+"</option>";
                }

                $('#vehicle-id').html(htmlvh);
                $('#driver-id').html(htmldr);
          }
    });


});

function initDataTable(dep_date,arr_date){
  var table = $('#user_list').DataTable({
      responsive: true,
      paging: true,
      destroy: true,
      // ordering:false,
      serverside:true,
      deferRender: true,
      lengthMenu:[[ 5, 10, 25, 50, -1],[ 5, 10, 25, 50, "ALL"]],
      pageLength: 5,
      processing: true,
      language: {
        "infoFiltered": "",
        processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
      },
      "serverSide": false,
      // "ajax": "<?php //echo base_url(); ?>Vehicle/Serverside/emp_with_to_table",
      "ajax": {
        "url": "<?php echo base_url(); ?>Vehicle/Serverside/emp_with_to_table",
        "data": {
          "dep_date": dep_date,"arr_date":arr_date,
        }
      },
      columnDefs: [ {
           orderable: false,
           targets:   0
       } ],
     order: [[ 1, 'asc' ]],
      "columns": [

        {
          "data": null,
            "render": function(data, type, row, meta){
              data = "<input type='checkbox' name='passenger[]' value='"+row['userid']+"'> ";
              return data;
            }
        },
        { "data": "name","visible": true},
        { "data": "travel_purpose","visible": true},
        { "data": "departure_date","visible": true},
        { "data": "arrival_date","visible": true},
        { "data": "destination","visible": true},

      ]
  });
  $('#select_all_staff').on('click', function(){
    // Get all rows with search applied
    var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
 });


$("#user_list").on('change',"input[type='checkbox']",function(e){
 var users = [];
 var html = '';
 table.$('input[type="checkbox"]').each(function(){
     if (this.checked) {
       users.indexOf(this.value) === -1 ? users.push(this.value) : $(this).prop("checked",false);
     }
 });
});

$('#proceed-vh-assign').on('click',function(){
    if ($('#vehicle-id').val() == '' && $('#driver-id').val() == '') {
      alert('Please complete all the required fields !');
      return false;
    }else {
      $('#vh-destinations').empty();
      $('#vh-confirm').empty();
        $('#submit-vh-ticket').hide();
        $('.modal-footer-first').hide();
        $('#submit-assign-vh').show();
        $('#vh-vehicle').val($('#vehicle-id').val());
        $('#vh-driver').val($('#driver-id').val());
        $('#departure_date_vh_to').val($('#departure_date_vh').val());
        $('#arrival_date_vh_to').val($('#arrival_date_vh').val());
        $('#vh-vehicle-text').val($('#vehicle-id option:selected').text());
        $('#vh-driver-text').val($('#driver-id option:selected').text());
        table.$('input[type="checkbox"]').each(function(){
            if(this.checked){
                var html = ''
                html += '<input type="text" name="" value="'+table.row( this.closest('tr') ).data().name+'" class="form-control"><input type="hidden" name="'+this.name+'" value="'+this.value+'" class="form-control">'

                var html2 = ''
                html2 += '<input type="text" name="destination[]" value="'+table.row( this.closest('tr') ).data().destination+'" class="form-control">'

                 $('#vh-destinations').append(html2);
                 $('#vh-confirm').append(html);
              }
        });
    }
});

  $('#prev-vh-assign').on('click',function(){
    $('#submit-vh-ticket').show();
    $('.modal-footer-first').show();
    $('#submit-assign-vh').hide();
  });
}


// for showing vh travel details
function vh_calendar_details_dashboard(id){
  $.ajax({
        url: base_url+"/Vehicle/Main/get_vh_travel_data",
        type: 'POST',
        data:{'vh_travel_id':id},
        async : true,
        success:function(response)
          {
                var data = JSON.parse(response);
                var passengers = data.vh_passenger;
                var html_passengers = '';
                var destinations = data.vh_destinations;
                var html_dest = '';
                var vhdata = data.vh_data[0];
                for (var i = 0; i < destinations.length; i++) {
                  html_dest+='<input type="text" name="" value="'+destinations[i].destinations+'" class="form-control mt-2" readonly>';
                }
                for (var i = 0; i < passengers.length; i++) {
                  html_passengers+='<input type="text" name="" value="'+passengers[i].fname+' '+passengers[i].sname+'" class="form-control mt-2" readonly>';
                }
                $('#selected_dest_cont').html(html_dest);
                $('#selected_passengers_cont').html(html_passengers);
                $('#selected_driver').val(vhdata.driver_name);
                $('#selected_vehicle').val(vhdata.vehicle_name+"("+vhdata.color+")");
                $('#vehicle_travel_no').val(vhdata.as_ticket_no);
                $('#selected_departure').val(vhdata.departure_date_vh_to);
                $('#selected_arrival').val(vhdata.arrival_date_vh_to);
          }
    });
}

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vehicle.js"></script>
