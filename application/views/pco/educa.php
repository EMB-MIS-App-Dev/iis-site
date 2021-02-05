
  <div class="col-lg-12">
    <div class="card-body">
      <?php echo $step_header; ?>
      <br>
      <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'educational_attainment_form')); ?>
        <!-- <form method="POST" onsubmit="Pco.showLoading()" enctype="multipart/form-data"> -->
        <div class="row">

          <div class="col-md-12 card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
              <div>
                <!-- <button id="btn_edit" type="button" class="btn btn-success float-left"> <i class="far fa-edit"></i> Edit </button> -->
                <h6 class="m-0 font-weight-bold text-primary" align="center">EDUCATIONAL ATTAINMENT</h6>
              </div>
            </div>
            <div class="card-body" id="educ_attain">
              <fieldset>
                <div class="row float-right">
                  <span class="set_note"> Please fill-out the required fields indicated with ( <span class="set_error">*</span> ). Put N/A if not applicable.</span><br>
                </div>
                <br> <br>
                <hr />
                <label>License Details</label>
                <hr />
                <div class="row">
                  <div class="col-md-6">
                    <label>Have received Professional License? <span> * </span> </label>
                    <?php
                      if(!empty(set_radio('received_prof_license', '0')) || !empty(set_radio('received_prof_license', '1'))) {
                        $proflncse_n_check = '';
                        $proflncse_y_check = '';
                      }
                      else {
                        $proflncse_n_check = $proflncse_n_check;
                        $proflncse_y_check = $proflncse_y_check;
                      }
                    ?>
                    <!-- onclick="pcoProfLicense(this.value);" -->
                    <div class="row">
                      <div class="col-md-4">
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="rcvd_profl_n_radio" name="received_prof_license" value="0" <?=set_radio('received_prof_license', '0').' '.$proflncse_n_check?> >
                          <label class="custom-control-label" for="rcvd_profl_n_radio">No</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="rcvd_profl_y_radio" name="received_prof_license" value="1" <?=set_radio('received_prof_license', '1').' '.$proflncse_y_check?> >
                          <label class="custom-control-label" for="rcvd_profl_y_radio">Yes</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> <br>

                <div id="proflic_div" >
                  <div class="row" >
                    <div class="col-md-8">
                      <label>Type of Professional License received : <span> * </span> </label>
                      <textarea class="form-control" name="type_of_license" ><?=trim(!empty(set_value('type_of_license')) ? set_value('type_of_license') : $educational_attainment[0]['type_of_license'])?></textarea>
                    </div>
                  </div> <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label>PRC License No.: <span> * </span> </label>
                      <input class="form-control" type="text" name="prc_license_no" value="<?=trim(!empty(set_value('prc_license_no')) ? set_value('prc_license_no') : $educational_attainment[0]['prc_license_no'])?>">
                    </div>
                    <div class="col-md-4">
                      <label>Date Issued: <span> * </span> </label>
                      <input class="form-control" type="date" name="date_issued" value="<?=trim(!empty(set_value('date_issued')) ? set_value('date_issued') : $educational_attainment[0]['date_issued'])?>">
                    </div>
                    <div class="col-md-4">
                      <label>Validity: <span> * </span> </label>
                      <input class="form-control" type="text" name="validity" value="<?=trim(!empty(set_value('validity')) ? set_value('validity') : $educational_attainment[0]['validity'])?>">
                    </div>
                  </div> <br>

                </div>

                <hr />
                <label>Educational Background</label>
                <hr  />

                <button type="button" class="btn btn-primary" data-target=".educAttainModal" data-toggle="modal"> <i class="fas fa-plus"></i> Add New Row- </button> <br><br>

                <button type="button" class="btn btn-primary" onclick="var inshere_div = document.createElement('tr'); inshere_div.innerHTML = document.getElementById('toins').innerHTML; document.getElementById('inshere').appendChild(inshere_div);"> <i class="fas fa-plus"></i> Add New Row </button> <br><br>

                <div class="table-responsive" >
                  <table class="table table-bordered ">
                    <thead>
                      <tr>
                        <th style="width: 5%"></th>
                        <th>School <span> * </span> </th>
                        <th>Address <span> * </span> </th>
                        <th>Inclusive Dates <span> * </span> </th>
                        <th>Degree / Units Earned <span> * </span> </th>
                      </tr>
                    </thead>
                    <tbody id="inshere">
                      <?php
                        if( !empty($educ_attainment) ) {
                          foreach ($educ_attainment as $key => $value) {
                            echo ' <tr>
                              <td></td>
                              <td><textarea class="form-control" type="text" name="school[]" >'.$value['school'].'</textarea></td>
                              <td><textarea class="form-control" type="text" name="address[]" >'.$value['address'].'</textarea></td>
                              <td><textarea class="form-control" type="text" name="inclusive_date[]" >'.$value['inclusive_date'].'</textarea></td>
                              <td><textarea class="form-control" type="text" name="degree_units_earned[]" >'.$value['degree_units_earned'].'</textarea></td>
                            </tr> ';
                          }
                        }
                        else {
                          echo '<tr>
                            <td></td>
                            <td><textarea class="form-control" type="text" name="school[]" autofocus ></textarea></td>
                            <td><textarea class="form-control" type="text" name="address[]" ></textarea></td>
                            <td><textarea class="form-control" type="text" name="inclusive_date[]" ></textarea></td>
                            <td><textarea class="form-control" type="text" name="degree_units_earned[]" ></textarea></td>
                          </tr> ';
                        }
                      ?>
                      <tr>
                        <td><button class="btn btn-danger" onclick="this.closest('tr').remove();" title="remove"><i class="fas fa-minus"></i></button></td>
                        <td><textarea class="form-control" type="text" name="school[]"></textarea></td>
                        <td><textarea class="form-control" type="text" name="address[]"></textarea></td>
                        <td><textarea class="form-control" type="text" name="inclusive_date[]"></textarea></td>
                        <td><textarea class="form-control" type="text" name="degree_units_earned[]"></textarea></td>
                      </tr>
                    </tbody>
                      <tr id="toins" style="display: none">
                        <td><button class="btn btn-danger" onclick="this.closest('tr').remove();" title="remove"><i class="fas fa-minus"></i></button></td>
                        <td><textarea class="form-control" type="text" name="school[]"></textarea></td>
                        <td><textarea class="form-control" type="text" name="address[]"></textarea></td>
                        <td><textarea class="form-control" type="text" name="inclusive_date[]"></textarea></td>
                        <td><textarea class="form-control" type="text" name="degree_units_earned[]"></textarea></td>
                      </tr>
                  </table>
                </div>
              </fieldset>
              <!-- Improvised Card Footer -->
              <hr />
              <div class="col-md-12">
                <button id="pco_submit" type="submit" class="btn btn-success float-right" name="educ_attainment" ><i class="fas fa-save"></i> SAVE</button>
              </div>
              <br /><br />
            </div>
          </div>

        </div>
      </form>
    </div>

    </div>
  </div>

<script>

  $(document).ready(function(){

  		var table = $('#pco_application_table').DataTable({
  	    order: [[0, "desc"]],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    		// pageLength: -1,
  			language: {
  				infoFiltered: "",
  				processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
  			},
  			deferRender: true,
  			paging: true,
  			serverSide: true,
  			processing: true,
  			responsive: true,
  			ajax: {
  					"url": "<?php echo base_url('Pco/Datatables/application'); ?>",
  					"type": 'POST',
  					"data": {'user_id': '<?=$user_id?>' },
  			},
  			columns: [
  	      { "data": "appli_id" },
  				{ "data": "user_id", "visible": false, "searchable": false },
  	      { "data": "appli_token",
  	        "render": function(data, type, row, meta) {
  	            if(data != 0) {
  	              return data;
  	            }
  	            else {
  	              return data = ' -draft-';
  	            }
  	        }
  	      },
  	      { "data": "step",},
  	      { "data": "step",
  	        "sortable": false,
  	        "render": function(data, type, row, meta) {
  	          switch(data)
  	          {
  	            case '1': data = 'Step 1: Basic Information'; break;
  	            case '2': data = 'Step 2: Company Details'; break;
  	            case '3': data = 'Step 3: Educational Attainment'; break;
  	            case '4': data = 'Step 4: Work Experience'; break;
  	            case '5': data = 'Step 5: Trainings/Seminars Attended'; break;
  	            case '6': data = 'Step 6: Other Requirements'; break;
  	            case '7': data = 'For EMB 7 Evaluation'; break;
  	            case '8': data = 'For Payment'; break;
  	            case '9': data = 'To Edit / Update'; break;
  	            case '10': data = 'Lacking PCO Training'; break;
  	            case '11': data = 'Approved / For Certification'; break;
  	            case '12': data = 'Re-Open'; break;
  	            case '13': data = 'Disapproved'; break;
  	            case '14': data = 'Closed/Deleted'; break;
  	            case '15': data = 'For Claiming'; break;
  	            case '16': data = 'Draft Application'; break;
  	            case '17': data = 'Claimed'; break;
  	            default: data = ' '; break;
  	          }
  	          return data;
  	        }
  	      },
  	      { "data": "stat_id"},
  	      { "data": "status", "visible": false, "searchable": false },
  	      { "data": "action" },
  	      { "data": "remarks" },
  	      { "data": "date_submitted" },
  	      {
            "sortable": false,
            "render": function(data, type, row, meta) {
                data = "<button type='button' id='update' class='btn btn-warning btn-sm waves-effect waves-light' title='Update'><i class='far fa-edit'></i></button>&nbsp;";
                return data;
            }
  	      }
  	    ]
  	  });

  		$('#asdasd').click(function(){
  			table.ajax.reload();
  		});
  });

  $('input[name="received_prof_license"]', '#educational_attainment_form').change(function(){
    if($('input[name="received_prof_license"]:checked').val() == 1) {
      $('div#proflic_div').show();
    }
    else {
      $('div#proflic_div').hide();
    }
  }).change();
</script>
