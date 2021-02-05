
  <div class="col-lg-12">
    <div class="card-body">
      <?php echo $step_header; ?>
      <br>

        <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'work_exp_form')); ?>
          <div class="row">

            <div class="col-md-12 card shadow mb-4 border-left-primary">
              <div class="card-header py-3">
                <div>
                  <h6 class="m-0 font-weight-bold text-primary" align="center">WORK EXPERIENCE</h6>
                </div>
              </div>
              <div class="card-body">
                <fieldset>
                  <div class="row float-right">
                    <span class="set_note"> Please fill-out the required fields indicated with ( <span class="set_error">*</span> ). Put N/A if not applicable. </span><br>
                  </div>
                  <br><br>

                  <button type="button" class="btn btn-primary" data-target=".addWorkExpModal" data-toggle="modal"> <i class="fas fa-plus"></i> Add New Row </button> <br><br>
                  <input type="text" name="work_exp_chkempty" value="<?=$work_exp_chkempty?>"/>

                  <div class="table-responsive" >
                    <table id="work_exp_table" class="table table-bordered ">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Company <span> * </span> </th>
                          <th>Position <span> * </span> </th>
                          <th>Inclusive Dates <span> * </span> </th>
                          <th>Status of Employment <span> * </span> </th>
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
                  <button id="pco_submit" type="submit" class="btn btn-success float-right" name="work_exp" ><i class="fas fa-save"></i> SAVE</button>
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

  		var table = $('#work_exp_table').DataTable({
  	    order: [[5, "asc"]],
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
  					"url": "<?php echo base_url('Pco/Datatables/work_exp'); ?>",
  					"type": 'POST',
  					"data": {'user_id': '<?=$user_id?>' },
  			},
  			columns: [
  				{ "data": "user_id", "visible": false, "searchable": false },
  	      { "data": "company" },
  	      { "data": "position" },
  	      { "data": "inclusive_date" },
  	      { "data": "employment_status" },
  	      { "data": "cnt", "visible": false, "searchable": false },
  	      {
            "sortable": false,
            "render": function(data, type, row, meta) {
                data = "<button type='button' id='editbtn' class='btn btn-warning btn-sm waves-effect waves-light' title='Edit' data-target='.editWorkExpModal' data-toggle='modal'><i class='far fa-edit'></i></button>&nbsp;";
                return data;
            }
  	      }
  	    ]
  	  });

      // EDIT MODAL VALUES
  	  $('#work_exp_table tbody').on( 'click', '#editbtn', function () {
  	    var data = table.row( $(this).parents('tr') ).data();
        $.ajax({
           url: '<?=base_url("Pco/Data/edit_wrkxp_html")?>',
           method: 'POST',
           data: { user_id: data['user_id'], cnt: data['cnt'] },
           success: function(data) {
             $('#editwrkxp_div').html(data);
           }
        });
  	  });

      // $('button[name="add_work_exp_btn"], button[name="edit_work_exp_btn"]').click(function() {
      //   var _this = $(this);
      //   var frm = _this.parents("form");
      //   console.log(frm.parents('div.modal').html());
      // });

      $('button[name="add_work_exp_btn"], button[name="edit_work_exp_btn"]').click(function() {
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
    				$('#save_draft_button').val('Save Status').removeAttr('disabled');
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
    		  _this.val('Save Status').removeAttr('disabled');
    		});

    		return false;
      });

  });

</script>
