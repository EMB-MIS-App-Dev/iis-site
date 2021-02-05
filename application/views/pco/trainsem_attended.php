
    <div class="col-lg-12">
      <div class="card-body">
        <?php echo $step_header; ?>
        <br>
        <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'trainsem_attended_form')); ?>
          <div class="row">

            <div class="col-md-12 card shadow mb-4 border-left-primary">
              <div class="card-header py-3">
                <div>
                  <h6 class="m-0 font-weight-bold text-primary" align="center">TRAININGS / SEMINARS ATTENDED</h6>
                </div>
              </div>
              <div class="card-body">
                <fieldset>
                  <div class="row float-right">
                    <span class="set_note"> Please fill-out the required fields indicated with ( <span class="set_error">*</span> ). Put N/A if not applicable. </span><br>
                  </div>
                  <br>



                  <div class="row">
                    <div class="col-md-6">
                      <label>Have you taken the forty hours PCO training? <span> * </span> </label>
                      <?php
                        if(!empty(set_radio('qualified', '0')) || !empty(set_radio('qualified', '1'))) {
                          $quality_n_check = '';
                          $quality_y_check = '';
                        }
                        else {
                          $quality_n_check = $quality_n_check;
                          $quality_y_check = $quality_y_check;
                        }
                      ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="npcotrain_radio" name="pco_training" value="0" <?=set_radio('pco_training', '0').' '.$quality_n_check?> >
                            <label class="custom-control-label" for="npcotrain_radio">No</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="ypcotrain_radio" name="pco_training" value="1" <?=set_radio('pco_training', '1').' '.$quality_y_check?> >
                            <label class="custom-control-label" for="ypcotrain_radio">Yes</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <br>

                  <button type="button" class="btn btn-primary" data-target=".addTrainSemAttendedModal" data-toggle="modal"> <i class="fas fa-plus"></i> Add New Row </button> <br><br>
                  <input type="text" name="tsatnd_record_check" value="<?=$tsatnd_record_check?>"/>

                  <div class="table-responsive" >
                    <table id="ts_attend_table" class="table table-bordered ">
                      <thead>
                        <tr>
                          <th></th>
                          <th>qualified <span> * </span> </th>
                          <th>Title <span> * </span> </th>
                          <th>Venue <span> * </span> </th>
                          <th>Conductor <span> * </span> </th>
                          <th>Date Conducted <span> * </span> </th>
                          <th>No. of Hours <span> * </span> </th>
                          <th>Certificate No. <span> * </span> </th>
                          <th>cnt</th>
                          <th>action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>

                </fieldset>
                <!-- Improvised Card Footer -->
                <hr />
                <div class="col-md-12">
                  <button id="pco_submit" type="submit" class="btn btn-success float-right" name="trainsem_attended" ><i class="fas fa-save"></i> SAVE</button>
                </div>
                <br /><br />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

<script>
  $(document).ready(function(){
  		var table = $('#ts_attend_table').DataTable({
  	    order: [[0, "asc"]],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
  			language: {
  				infoFiltered: "",
  				processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
  			},
  			deferRender: true,
  			paging: true,
  			serverSide: true,
  			processing: true,
  			responsive: true,
        // autoWidth: false,
  			ajax: {
  					"url": "<?php echo base_url('Pco/Datatables/trainsem_attended'); ?>",
  					"type": 'POST',
  					"data": {'user_id': '<?=$user_id?>' },
  			},
  			columns: [
  				{ "data": "user_id", "visible": false, "searchable": false },
  	      { "data": "qualified", "visible": false, "searchable": false },
  	      { "data": "title" },
  	      { "data": "venue" },
  	      { "data": "conductor" },
  	      { "data": "date_conducted" },
  	      { "data": "no_hours" },
  	      { "data": "cert_no" },
  	      { "data": "cnt", "visible": false, "searchable": false },
  	      {
            "sortable": false,
            "render": function(data, type, row, meta) {
                data = "<button type='button' id='editbtn' class='btn btn-warning btn-sm waves-effect waves-light' title='Edit' data-target='.editTrainSemAttendedModal' data-toggle='modal'><i class='far fa-edit'></i></button>&nbsp;";
                return data;
            }
  	      }
  	    ]
  	  });

      // EDIT MODAL VALUES
  	  $('#ts_attend_table tbody').on( 'click', '#editbtn', function () {
  	    var data = table.row( $(this).parents('tr') ).data();
        $.ajax({
           url: '<?=base_url("Pco/Data/edit_tsatnd_html")?>',
           method: 'POST',
           data: { user_id: data['user_id'], cnt: data['cnt'] },
           success: function(data) {
             $('#edittsatnd_div').html(data);
           }
        });
  	  });

      $('button[name="add_ts_attend_btn"], button[name="edit_ts_attend_btn"]').click(function() {
      // $('form#estdetailsform').submit( function() {
        // e.preventDefault();
        var _this = $(this);
        var frm = _this.parents("form");

    		var request = $.ajax({
    			url: frm.attr('action'),
    			type: frm.attr('method'),
    			data: frm.serialize(),
    			// dataType: 'json',
    			beforeSend: function(jqXHR, settings) {
            _this.html('<span class="text">Saving...</span>').attr('disabled','disabled');
            frm.children('fieldset').prop('disabled', true);
          }
    		});

    		request.done(function(data) {
    			if (data.result) {
            _this.attr('disabled',false);
    				_this.val('Add').removeAttr('disabled');
    			}
    			else {
            table.ajax.reload();
            _this.attr('disabled',false);
            frm.parents('div.modal').modal("hide");
            frm.children('fieldset').prop('disabled', false);
    			}
    		});

    		request.fail(function(jqXHR, textStatus) {
    		  alert( "Request failed: " + textStatus );
          _this.attr('disabled',false);
          frm.children('fieldset').prop('disabled', false);
    		  _this.val('Add').removeAttr('disabled');
    		});

    		return false;
      });
  });
</script>
