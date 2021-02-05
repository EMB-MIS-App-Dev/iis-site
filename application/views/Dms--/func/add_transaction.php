
		<div class="container-fluid">
			<div class="row">

				<!-- DATATABLES Card -->
				<div class="col-xl-12 col-lg-12">
					<div class="trans-layout card shadow mb-4">

            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-plus"> </i> ADD NEW TRANSACTION</h6>

            </div>

						<?php echo form_open_multipart('Dms/Dms/add_transaction'); ?>
              <!-- Card Body -->
              <div class="card-body">

                    <div class="data-div table-responsive">
                      <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Add</a>
                          <!-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#sweet-report" role="tab" aria-controls="sweet-report" aria-selected="false">Sweet</a>
                          <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#pco-accreditation" role="tab" aria-controls="pco-accreditation" aria-selected="false">PCO</a> -->
                        </div>
                      </nav>
                        <input class="form-control" type="hidden" name="trans_no" value="<?php echo $trans_data[0]['trans_no']; ?>" readonly />
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab">
                              <div class="row">
                                <div class="col-md-4"><br />
                                  <div class="form-group">
                                    <label>Transaction No.:</label>
                                    <input class="form-control" value="<?php echo $trans_data[0]['token']; ?>" readonly />
                                  </div>
                                  <div class="form-group">
                                    <label>System:</label><?php echo form_error('system'); ?>
                                    <select id="sys_main" class="form-control" onchange="Dms.system_select(this.value);" name="system">
                                      <option selected="" value="">--</option>
                                      <?php
                                        foreach ($system as $value) {
                                          echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Sub-System:</label><?php echo form_error('type'); ?>
                                    <select class="form-control" id="type" name="type" onchange="Dms.additional_inputs(this.value)">
                                        <option selected value="">--</option>
                                    </select>
                                  </div>
                                  <!-- DIV FOR ADDITIONAL SELECTIONS -->
                                    <div id="additional_inputs">
                                    </div>
                                  <!-- END OF DIV FOR ADDITIONAL SELECTIONS -->
                                  <div class="form-group">
                                    <label>Subject Name:</label><?php echo form_error('subject'); ?>
                                    <textarea class="form-control" id="subject" name="subject"><?php echo set_value('subject'); ?></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label>Transaction Status:</label><?php echo form_error('status'); ?>
                                    <select class="form-control" id="trans_status" name="status">
                                      <option selected value="">--</option>
                                      <?php
                                        foreach ($status as $key => $value) {
                                          echo '<option value="'.$value['id'].'" '.set_select('status', $value['id']).'>'.($key+1).' - '.$value['name'].'</option>';
                                        }
                                      ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-4"> <br>

                                  <div class="form-group">
                                    <label>Company EMB ID:</label>
                                    <input class="form-control" id="company_embid" value="" readonly />
                                  </div>
                                  <div class="form-group">
                                    <label>Company:</label><?php echo form_error('company'); ?>
                                    <select id="company_list" class="form-control" name="company" onchange="Dms.company_details(this.value);">
                                      <option selected value="">--</option>
                                      <?php
                                        foreach ($company_list as $value) {
                                          echo '<option value="'.$value['token'].'" >'.$value['company_name'].'</option>';
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Company Address:</label>
                                    <textarea class="form-control" id="company_address" readonly></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label>Project Type:</label>
                                    <textarea class="form-control" id="project_type" readonly></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label>Project Category:</label>
                                    <textarea class="form-control" id="project_category" readonly></textarea>
                                  </div>

                                </div>

                                <div class="col-md-4"> <br>
                                  <div class="form-group">
                                    <label>Assigned to:</label><?php echo form_error('receiver'); ?>
                                    <select class="form-control" name="division" onchange="Dms.select_division(this.value);">
                                      <option selected value="">--</option>
                                      <?php
                                        foreach ($division as $key => $value) {
                                          echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
                                        }
                                      ?>
                                    </select> <br />

                                    <select id="section_id" class="form-control" name="section" onchange="Dms.select_section(this.value);">
                                      <option selected value="">--</option>
                                    </select> <br />

                                    <select id="personnel_id" class="form-control" name="receiver" >
                                      <option selected value="">--</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Action:</label><?php echo form_error('action'); ?>
                                    <select class="form-control" name="action" >
                                      <option selected value="">--</option>
                                    <?php
                                      foreach ($action as $value) {
                                        echo '<option value="'.$value['text'].'" '.set_select('action', $value['text']).'>'.$value['code'].' - '.$value['text'].'</option>';
                                      }
                                    ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label>Remarks:</label><?php echo form_error('remarks'); ?>
                                    <textarea class="form-control" name="remarks"><?php echo set_value('remarks'); ?></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label>Attachment:</label><?php // echo form_error('attachment'); ?>
                                    <input class="form-control" type="file" name="attachment[]" multiple />
                                  </div>
                                </div>

                              </div>
                            </div>
                            <div class="tab-pane fade" id="sweet-report" role="tabpanel" aria-labelledby="sweet-report-tab">...</div>
                            <div class="tab-pane fade" id="pco-accreditation" role="tabpanel" aria-labelledby="pco-accreditation-tab">...</div>

                        </div>

                        <div class="col-xl-12 mb-3">

                        </div>

                    </div>

              </div>
              <!-- Card Footer -->
              <div class="card-footer">
                <div class=" float-right">

                  <button id="save_draft_button" type="submit" class="btn btn-success btn-icon-split " name="save_draft"><span class="text"> <i class="far fa-save"></i> Save as Draft</span></button>&nbsp;&nbsp;

                  <button id="process_transaction_button" type="submit" class="btn btn-success btn-icon-split" name="process_transaction" ><span class="text"> <i class="fas fa-share-square"></i> Process</span></button> <br /><br />
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

  </div> <!-- Header Wrapper End -->

<script type="text/javascript">

  $(document).ready(function() {
    $('#sys_main').selectize({
      onChange: function(value, isOnInitialize) {
        console.log("Selectize event: Change on sys_main");
      }
    });

    $('#company_list').selectize({
      onChange: function(value, isOnInitialize) {
        console.log("Selectize event: Change on company_list");
      }
    });

    // $('#trans_status').selectize({
    //   onChange: function(value, isOnInitialize) {
    //     console.log("Selectize event: Change on trans_status");
    //   },
    // });
  });

</script>
