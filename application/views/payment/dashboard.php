
<style>
   table {
      font-size: 13px
   }
   table thead {
      font-size: 14px
   }
</style>

<div class="container-fluid row col-md-12">

   <div class="col-xl-12 col-lg-12">
      <div class="form-group">
         <?=form_open_multipart("payment/main/op_create")?>
         <button type="submit" class="btn btn-labeled btn-success"> <span class="btn-label"><i class="fas fa-plus"></i></span>ADD NEW ORDER OF PAYMENT</button>
         <?=form_close()?>
      </div>

      <div class="trans-layout card shadow mb-4">

         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks"></i> ORDER OF PAYMENT</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="dataTable" class="table" width="100%">
                  <thead>
                     <tr>
                        <th>OP #</th>
                        <th>Transaction #</th>
                        <th>Type</th>
                        <th>Region</th>
                        <th>emb_user_id</th>
                        <th>Proponent Name</th>
                        <th>Plant Address</th>
                        <th>Account No.</th>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Date</th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>

      </div>

   </div>
</div>

<div id="regionSelectionDiv" hidden>
   <select id="regionSelect" class="form-control">
      <option selected value="">-all-</option>
      <?php
      for($i = 0; $i < count($region_selection); $i++) {
         if($region_selection[$i]['rgnnum'] == $user['region']) {
            echo '<option selected value="'.$region_selection[$i]['rgnnum'].'">'.$region_selection[$i]['rgnnam'].'</option>';
         }
         else {
            echo '<option value="'.$region_selection[$i]['rgnnum'].'">'.$region_selection[$i]['rgnnam'].'</option>';
         }
      }
      ?>
   </select>
</div>

<script>
$(document).ready(function() {

   let tableData = {
      'selected_region': '<?=$user['region']?>',
   };

   let table = $('#dataTable').DataTable( {
      dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-1'<'region_slct'>><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      language: {
         "infoFiltered": "",
         processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
      },
      serverSide: true,
      processing: true,
      responsive: true,
      scrollX: true,
      ajax: {
         "url": "<?php echo base_url('payment/table_data/order_of_payment'); ?>",
         "type": 'POST',
         "data": function ( d ) {
            return  $.extend(d, tableData);
         },
      },
      columns: [
         { data: "op_number" },
         { data: "trans_no" },
         { data: "trans_type" },
         { data: "region" },
         { data: "emb_user_id" },
         { data: "proponent_name" },
         { data: "plant_address" },
         { data: "account_no" },
         { data: "item_count" },
         { data: "amount" },
         { data: "date" },
      ]
   } );

   $("div.search_bar").html('<input class="search_fld form-control form-control-sm" id="search_bar" />');
   $("div.search_btn").html('<button id="search_btn" class="search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span id="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

   if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes')
   {
      $("div.region_slct").html($("div#regionSelectionDiv").html());
   }

   $("#search_btn").on('click', function () {
      table.settings()[0].jqXHR.abort()
      table.search($("#search_bar").val()).draw();
      $('#search_spinner').show();
      $(".search_fld").prop('disabled', true);
   });

   table.on( 'draw', function () {
      $('#search_spinner').hide();
      $(".search_fld").prop('disabled', false);
   } );

   $('#regionSelect').change(function() {
      tableData.selected_region = $(this).val();
      table.draw();
   } );

} );
</script>
