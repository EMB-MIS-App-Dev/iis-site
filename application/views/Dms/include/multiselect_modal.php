<div id="multiprcTransModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Multi-Process Transactions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="inbox_multiprc_transaction" action="<?php echo base_url('Dms/Form_Data/multi_process_transaction'); ?>" method="POST">
        <div class="modal-body">

          <div class="alert alert-warning alert-dismissible fade show" role="alert">
      			<span style="font-size: 14px "><b>NOTE:</b> Only Transactions marked as "RECEIVED" can be Multi-Processed. This is to Confirm that You Have Viewed and Verified the Selected Transactions to Process.</h6></span>
      			<hr style="margin: 5px">
      		</div>
              <div id="trans-list"></div>
              <div class="col-md-8 offset-md-2">
                <div class="form-group">
                  <label>Transaction Status:</label>
                  <select class="form-control form-control-sm" id="trans_status" name="status" required onchange="Dms.removeAsgnPrsnl(this.value,'<?php echo $this->encrypt->encode($trans_data[0]['token']); ?>');">
                    <option selected value="">--</option>
                    <option value="3">Active</option>
                    <option value="15">For Approval</option>
                    <option value="5">Signed Document ( Approve )</option>
                    <option value="6">Disapproved / Denied</option>
                    <!-- <option value="24">Filed / Closed</option> -->
                    <option value="34">For Filing</option>
                  </select>
                </div>

                <div id="asgnprsnl_div" class="form-group">
                  <div class="row">
                    <div class="custom-control mr-sm-3">
                      <label>Assigned to:</label>
                    </div>
                  </div>
                  <div id="assignto-group" >
                    <select class="form-control form-control" data-selected="" name="region" >
                      <?php
                        foreach ($region as $key => $value) {
                          if($value['rgnnum']==$user['region']) {
                            echo '<option selected value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                          }
                          else {
                            echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
                          }
                        }
                      ?>
                    </select> <br />

                    <select class="form-control form-control" data-selected="" name="division" >
                      <option value="" selected>-select division-</option>
                      <?php
                        foreach ($division as $key => $value) {
                          if($value['divno']==$user['divno']) {
                            echo '<option selected value="'.$value['divno'].'">'.$value['divname'].'</option>';
                          }
                          else {
                            echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
                          }
                        }
                      ?>
                    </select> <br />

                    <select class="form-control form-control" data-selected="" name="section" >
                      <option>-sec-</option>
                    </select> <br />

                    <select id="personnel_id" class="form-control form-control" data-selected="" name="receiver" required>
                      <option>-unit-</option>
                    </select>
                  </div>
                </div>
                <div id="couriertype_div" class="form-group" style="display: none">
                  <label>Courier Type:</label><?php echo form_error('courier_type'); ?>
                  <select class="form-control form-control-sm" name="courier_type">
                    <option selected value="">--</option>
                    <?php
                      foreach ($courier_type as $key => $value) {
                        echo '<option value="'.$value['id'].'">'.$value['type'].'</option>';
                      }
                    ?>
                  </select> <br />

                  <label>Tracking No.:</label>
                  <input type="text" class="form-control form-control-sm" name="tracking_no" />
                </div> <br>
                <div class="form-group">
                  <label>Action:</label>
                  <select class="form-control form-control-sm" name="action" required>
                    <option selected value="">--</option>
                    <?php
                      foreach ($action as $value) {
                        echo '<option value="'.$value['text'].'" '.set_select('action', $value['text']).'>'.$value['code'].' - '.$value['text'].'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Remarks:</label>
                  <textarea class="form-control form-control-sm" name="remarks"></textarea>
                </div>
                <?php
                  if(in_array($user['secno'], array(77,166,176,195,223,231,232,235,255,279,316)) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['rec_officer'] == 'yes') // RECORDS
                  {
                    ?>
                    <div class="form-group">
                      <label>File Location:</label><?php echo form_error('records_location'); ?>
                      <input class="form-control form-control-sm" name="records_location" value="<?php echo (!empty($trans_data[0]['records_location'])) ? trim($trans_data[0]['records_location']) : set_value('records_location'); ?>" />
                    </div>
                    <?php
                  }
                ?>
              </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-danger" ><i class="fas fa-check-circle"></i> Yes</button>
              <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i> No</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<script>

  $(document).ready(function(){
	 		var send_group = $('div#assignto-group');

	 		var region_slct = send_group.find('select[name="region"]');
	 		var division_slct = send_group.find('select[name="division"]');
	 		var section_slct = send_group.find('select[name="section"]');
	 		var receiver_slct = send_group.find('select[name="receiver"]');

	 		var region_val = '';
 			region_val = region_slct.val();

 			region_slct.change(function() {
 				send_group.find('select').prop('disabled', true);
 				region_val = $(this).val();
 				$.ajax({
 						url: '/embis/dms/data/ajax/get_division',
 						method: 'POST',
 						data: { 'selected': division_slct.data('selected'), 'region': region_val },
 						dataType: 'html',
 						success: function(response) {
 							division_slct.html(response).change();
 						},
 						error: function(response) {
 							division_slct.empty().html("<option value=''>-No Data-</option>").change();
 							console.log("ERROR");
 						},
 				});
 			});

	 		division_slct.change(function() {
	 			send_group.find('select').prop('disabled', true);
	 			var division_val = $(this).val();
	 			$.ajax({
	 					url: '/embis/dms/data/ajax/get_section',
	 					method: 'POST',
	 					data: { 'selected': section_slct.data('selected'), 'division': division_val, 'region': region_val },
	 					dataType: 'html',
	 					success: function(response) {
	 						section_slct.html(response).change();
	 					},
	 					error: function(response) {
	 						section_slct.empty().html("<option value=''>-No Data-</option>").change();
	 						console.log("ERROR");
	 					},
	 			});
	 		});

	 		section_slct.change(function() {
	 			send_group.find('select').prop('disabled', true);
	 			var section_val = $(this).val();
	 			var division_val = division_slct.val();
	 			$.ajax({
	 					url: '/embis/dms/data/ajax/get_personnel',
	 					method: 'POST',
	 					data: { 'selected': receiver_slct.data('selected'), 'section': section_val, 'division': division_val, 'region': region_val },
	 					dataType: 'html',
	 					success: function(response) {
	 						receiver_slct.html(response);
	 						send_group.find('select').prop('disabled', false);
	 					},
	 					error: function(response) {
	 						receiver_slct.empty().html("<option value=''>-No Data-</option>").change();
	 						send_group.find('select').prop('disabled', false);
	 						console.log("ERROR");
	 					},
	 			});
	 		});
  });

</script>
