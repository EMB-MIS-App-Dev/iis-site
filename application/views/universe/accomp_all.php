<style>

  #logcount_modaltb td{
    border-bottom: 1px solid black;
  }

</style>
<div class="container-fluid">
  <div class="row">


    <!-- DATATABLES Card -->
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Login Count [ <?php echo date("F d, Y"); ?> ]</h6>
        </div>
        <div class="card-body">
          <table class="table table-borderless">
            <tbody id="log_count_tbody"></tbody>
          </table>
        </div>
      </div>

      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> User Logs</h6>
        </div>


        <!-- Card Body -->
          <div class="card-body">

            <div class="row" >
              <div class="table-responsive" style="zoom: 85%">
                <table id="user_logs_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Name</th>
                      <th>Middle</th>
                      <th>Last</th>
                      <th>Suffix</th>
                      <th>Region</th>
                      <th>Log Date|Time</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

          </div>
        <!-- Card Body -->

      </div>

      <div class="trans-layout card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox"></i> User Activities</h6>

        </div>

        <!-- Card Body -->
          <div class="card-body">

            <div class="row" >
              <div class="table-responsive" style="zoom: 85%">
                <table id="uact_table" class="table table-striped table-hover" style="width: 100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>fname</th>
                      <th>mname</th>
                      <th>sname</th>
                      <th>suffix</th>
                      <th>Personnel</th>
                      <th>Region</th>
                      <th>Div.</th>
                      <th>Sec.</th>
                      <th>Trans. Status</th>
                      <th>tno</th>
                      <th>Trans #</th>
                      <th>Subject</th>
                      <th>mprc</th>
                      <th>Trans. Type</th>
                      <th>Date|Time Acted</th>
                      <th style="width: 130px">Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

          </div>
        <!-- Card Body -->

      </div>

    </div>
  </div>
</div>

<div id="hidden_slct" hidden style="display: none">
  <select class="form-control form-control-sm" name="func_list">
    <?php
      foreach ($func_list as $key => $value) {
        if($user_func[0]['cnt'] == $value['cnt']) {
          echo '<option value="'.$value['cnt'].'" selected>'.$value['div_nam'].' - '.$value['func'].'</option>';
        }
        else {
          echo '<option value="'.$value['cnt'].'">'.$value['div_nam'].' - '.$value['func'].'</option>';
        }
      }
    ?>
  </select>
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
      confirmButtonText: 'Orayts!',
      onOpen: () => swal.getConfirmButton().focus()
    })
  </script>";
}
?>
<script>

  $(document).ready(function() {

    Universe.select_region('<?php echo $user_func[0]['region']; ?>');
    Universe.select_division('<?php echo $user_func[0]['divno']; ?>');
    Universe.select_section('<?php echo $user_func[0]['secno']; ?>');

    var user_logs_table = $('#user_logs_table').DataTable({
        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'ulog_filter'>><'col-sm-12 col-md-2'B><'col-sm-12 col-md-6'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
          {
              extend: 'excelHtml5',
              exportOptions: {
                  modifier: {
                   // order : 'index', // 'current', 'applied','index', 'original'
                   page : 'all', // 'all', 'current'
                   // search : 'none' // 'none', 'applied', 'removed'
                  },
                  // columns: [ 4, 5, 6, 7, 8, 10, 12, 13 ],
              }
          },
        ],
        lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
        order: [[6, "desc"]],
        language: {
          // infoFiltered: "",
          processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
        },
        serverSide: true,
        processing: true,
        responsive: true,
        deferRender: true,
        // "scrollY": 500,
        "scrollX": true,
        ajax: {
            "url": "<?php echo base_url('Universe/Datatables/user_logs'); ?>",
            "type": 'POST',
            "data": { 'user_region': '<?php echo $user_cred['region']; ?>', 'user_func': '<?php echo $user_func; ?>' },
        },
        columns: [
          { "data": "title" },
          { "data": "fname" },
          { "data": "mname" },
          { "data": "sname" },
          { "data": "suffix" },
          { "data": "region" },
          { "data": "log_date" },
        ]
    });

		$("div.ulog_filter").html('<button id="filterbtn" class="form-control form-control-sm" type="button" data-toggle="modal" data-target=".accompFilterModal"><i class="fas fa-filter"></i> Filter Table</button>');

    var table = $('#uact_table').DataTable({
        dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'<'filter'>><'col-sm-12 col-md-1'B><'col-sm-12 col-md-2'<'function'>><'col-sm-12 col-md-5'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
          {
              extend: 'excelHtml5',
              exportOptions: {
                  modifier: {
                   // order : 'index', // 'current', 'applied','index', 'original'
                   page : 'all', // 'all', 'current'
                   // search : 'none' // 'none', 'applied', 'removed'
                  },
                  columns: [ 4, 5, 6, 7, 8, 10, 11, 13, 14 ],
              }
          },
        ],
        lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
        order: [[13, "desc"]],
        language: {
          // infoFiltered: "",
          processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
        },
        serverSide: true,
        processing: true,
        responsive: true,
        deferRender: true,
        // "scrollY": 500,
        "scrollX": true,
        ajax: {
            "url": "<?php echo base_url('Universe/Datatables/accomp_all'); ?>",
            "type": 'POST',
            "data": { 'user_region': '<?php echo $user_region; ?>', 'user_func': '<?php echo $user_func; ?>', 'ufunc': '<?php echo $user_func[0]['cnt']; ?>' },
        },
        columns: [
          { "data": "fname", "visible": false },
          { "data": "mname", "visible": false },
          { "data": "sname", "visible": false },
          { "data": "suffix", "visible": false },
          { "data": "full_name" },
          { "data": "region" },
          { "data": "division" },
          { "data": "section" },
          { "data": "status_description" },
          { "data": "trans_no", "searchable": false, "visible": false},
          { "data": "token"},
          { "data": "subject"},
          { "data": "multiprc", "searchable": false, "visible": false},
          { "data": "type_description" },
          { "data": "date_out" },
          {
            "sortable": false,
            "render": function(data, type, row, meta) {
              if(row['multiprc'] > 0) {
                data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.viewTransactionModal'>(M)View</button>&nbsp;";
              }
              else {
                data = "<button type='button' id='viewbtn' class='btn btn-info btn-sm waves-effect waves-light' data-toggle='modal'  data-target='.viewTransactionModal'>View</button>&nbsp;";
              }
              return data;
            }
          }
        ]
    });

		$("div.filter").html('<button id="filterbtn" class="form-control form-control-sm" type="button" data-toggle="modal" data-target=".accompFilterModal"><i class="fas fa-filter"></i> Filter Table</button>');
		$("div.function").html($('div#hidden_slct').html());

	    $('select[name="func_list"]').on( 'change', function () {
				window.location.href = '<?=base_url("Universe/Universe/accomp_all?ufunc=")?>'+ $('select[name="func_list"]').val();
		} );

    $('#uact_table tbody').on( 'click', '#viewbtn', function () {
        var data = table.row( $(this).parents('tr') ).data();
        Dms.view_transaction( data['trans_no'], data['multiprc'] );
    } );

    $.ajax( {
        "url": "<?php echo base_url('Dms/data/login_count'); ?>",
        "type": 'POST',
        "data": {'user_token': '<?php echo $user_token; ?>' },
        "dataType": 'json',
        "success": function(data){
          var tbody = '';
          for(var i = 0; i < data.length; i++) {
            tbody += '<tr><td><a data-target=".logCountSectionModal" data-toggle="modal" href=".logCountSectionModal" onclick="dar_logcount_click('+data[i].divno+')">'+data[i].divname+'</a></td><td>'+data[i].maxcnt+'</td></tr>';
          }

          $('#log_count_tbody').html(tbody);
        }
    } );
  } );

  function dar_logcount_click(div)
  {
    $.ajax({
        "url": "<?php echo base_url('Dms/data/login_count_modal'); ?>",
        "type": 'POST',
        "data": {'divno': div },
        "dataType": 'json',
        "success": function(data){
          var tbody = '';
          for(var i = 0; i < data.length; i++) {
            tbody += '<tr><td style="width: 25% !important" data-toggle="collapse" data-target="#accordion'+data[i].secno+'" class="clickable" onclick = "dar_logcount_accordion('+data[i].secno+', '+div+')">[ '+data[i].maxcnt+' online ]</td><td>'+data[i].sect+'</td></tr><tr><td colspan="2"><div id="accordion'+data[i].secno+'" class="collapse"></div></td></tr>';
          }

          $('#logcount_modaltb').html(tbody);
        }
    });
  }

  function dar_logcount_accordion(sec, div)
  {
    $.ajax({
          "url": "<?php echo base_url('Dms/data/login_count_accordion'); ?>",
          "type": 'POST',
          "data": {'secno': sec, 'divno': div },
          "dataType": 'json',
          "success": function(data){
            var tbody = '<table class="table table-borderless">';
            if(data) {
              for(var i = 0; i < data.length; i++) {
                tbody += '<tr><td>'+data[i].name+'</td><td>'+data[i].timestamp+'</td></tr>';
              }
            }
            else {
              tbody += '<tr><td>- no data -</td></tr>';
            }

            tbody += '</table>';

            $('#accordion'+sec).html(tbody);
          }
      });
    }
  </script>
