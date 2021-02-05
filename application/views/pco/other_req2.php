
  <div class="col-lg-12">
    <div class="card-body">
      <?php echo $step_header; ?>
      <br>
      <?php echo form_open_multipart('pco/application/'.$appli_id.'/'.$step, array('id' => 'other_req_form')); ?>

        <div class="row">
          <div class="col-md-12 card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary" align="center">OTHER REQUIREMENTS</h6>
            </div>
            <div class="card-body">

              <fieldset>
                <div class="row float-right">
                  <span class="set_note"> Please fill-out the required fields indicated with ( <span class="set_error">*</span> ). </span><br>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <label>Administrative Case:</label>
                    <?php
                      if(!empty(set_radio('administrative_case', '0')) || !empty(set_radio('administrative_case', '1'))) {
                        $adminc_n_check = '';
                        $adminc_y_check = '';
                      }
                      else {
                        $adminc_n_check = $adminc_n_check;
                        $adminc_y_check = $adminc_y_check;
                      }
                    ?>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="custom-control custom-radio">
                          <input type="radio" id="admncy_radio" name="administrative_case" class="custom-control-input" value="1" <?=set_radio('administrative_case', '1').' '.$adminc_y_check?> >
                          <label class="custom-control-label" for="admncy_radio">Yes</label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="custom-control custom-radio">
                          <input type="radio" id="admncn_radio" name="administrative_case" class="custom-control-input" value="0" <?=set_radio('administrative_case', '0').' '.$adminc_n_check?> >
                          <label class="custom-control-label" for="admncn_radio">No</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label>Criminal Case:</label>
                    <?php
                      if(!empty(set_radio('criminal_case', '0')) || !empty(set_radio('criminal_case', '1'))) {
                        $crimc_n_check = '';
                        $crimc_y_check = '';
                      }
                      else {
                        $crimc_n_check = $crimc_n_check;
                        $crimc_y_check = $crimc_y_check;
                      }
                    ?>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="custom-control custom-radio">
                          <input type="radio" id="crimcy_radio" name="criminal_case" class="custom-control-input" value="1" <?=set_radio('criminal_case', '1').' '.$crimc_y_check?> >
                          <label class="custom-control-label" for="crimcy_radio">Yes</label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="custom-control custom-radio">
                          <input type="radio" id="crimcn_radio" name="criminal_case" class="custom-control-input" value="0" <?=set_radio('criminal_case', '0').' '.$crimc_n_check?> >
                          <label class="custom-control-label" for="crimcn_radio">No</label>
                        </div>
                      </div>
                    </div>

                  </div>
                </div> <br>

                <div>
                  If you have any, give details of the case.
                  <textarea class="form-control" name="case_details"><?=trim(!empty(set_value('case_details')) ? set_value('case_details') : $other_req[0]['case_details'])?></textarea>
                </div> <br>

                <label>Attachments ( Please attach the requirements here )   </label> <br>
                <span style="font-size: 14px; color: red"> We only accept .pdf files with sizes not greater than 50 mb *. For a faster processing of your application, please compile documents with separated pages into one file. You may use these sites: online compiler: <a href="https://combinepdf.com/" target="_blank">Combine PDF</a> to merge them and <a href="https://topdf.com/" target="_blank">To PDF</a> to convert documents into pdf file. </span>
                <hr> <br>
<!-- asd -->
<div class="form-group erattdropzone">
                <div id="actions" class="row">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-outline-primary btn-sm fileinput-button">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Files</span>
                      </button>
                      <button type="button" class="btn btn-outline-info btn-sm start">
                        <i class="fas fa-upload"></i>
                        <span>Upload All</span>
                      </button>
                      <button type="button" class="btn btn-outline-danger btn-sm cancel">
                        <i class="fas fa-times-circle"></i>
                        <span>Remove All</span>
                      </button>
                    </div>

                    <div class="col-lg-5">
                      <!-- The global file processing state -->
                      <span class="fileupload-process">
                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                        </div>
                      </span>
                    </div>
                </div>

                <div class="table table-striped dropzone_table upload_div files" id="previews">
                    <div id="att_template" class="file-row dz-image-preview row">
                        <!-- file name, and error message -->
                        <div class="col-md-5">
                          <p class="name" data-dz-name></p>
                          <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                        <!-- file size, and progress bar -->
                        <div class="col-md-4">
                          <p class="size" data-dz-size></p>
                          <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                          </div>
                        </div>
                        <!-- file upload, remove, and delete button -->
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info btn-sm start">
                              <i class="fas fa-upload"></i>
                            </button>
                            <button data-dz-remove type="button" class="btn btn-outline-warning btn-sm cancel">
                              <i class="fas fa-window-close"></i>
                            </button>
                            <button data-dz-remove type="button" class="btn btn-outline-danger btn-sm delete">
                              <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
  </div>
<!-- asd -->
<style>
  .attach_desc{
    min-height: 60px !important;
  }
</style>
<div class="row">
  <div class="col-md-3">
    <label>Attach Files Here:</label> <br>
  </div>
  <div class="col-md-8">
    <label>Attachment Description:</label>
  </div>
  <div class="col-md-1">
    <label>Sample:</label>
  </div>
</div> <br>
<div class="row">
  <?php
    foreach ($pco_default_attachments as $key => $value) {
      if($key == 0)
      {
        echo '
          <div class="form-group col-md-3">
            <input  type="file" name="file_name[]" accept="image/*, application/pdf" >
          </div>
          <div class="form-group col-md-8">
            <input type="hidden" class="form-control" name="attach_id[]" value='.$value['attach_id'].' >
            <textarea class="form-control attach_desc">'.$value['attach_desc'].'</textarea>
          </div>
          <div class="form-group col-md-1">
            <a href="'.base_url('uploads/requirements/'.$value['sample_file']).'" target="_blank"><button type="button" class="form-control btn btn-sm btn-info"> <i class="fas fa-eye"></i> </button></a>
          </div>
        ';
      }
    }
  ?>
</div> <br> <br>

                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                  <input type="checkbox" class="custom-control-input" id="customControlInline" required>
                  <label class="custom-control-label" for="customControlInline"><i>I certify that all the information stated above and from the previous steps are true and correct.</i></label>
                </div> <br>
              </fieldset>
              <!-- Improvised Card Footer -->
              <hr />
              <div class="col-md-12">
                <button id="pco_submit" type="submit" class="btn btn-success float-right" name="other_req" ><i class="fas fa-save"></i> SAVE</button>
              </div>
              <br /><br />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

<script>

	Dropzone.autoDiscover = false;

  $(document).ready(function() {
  	//Dropzone
  	// Get the template HTML and remove it from the doumenthe template
  	var previewNode = document.querySelector("#att_template");
  	previewNode.id = "";
  	var previewTemplate = previewNode.parentNode.innerHTML;
  	previewNode.parentNode.removeChild(previewNode);

  	var myDropzone = new Dropzone("div.erattdropzone", { // Make the whole body a dropzone
  	  url: "<?php echo base_url('Dms/Dms/fileUpload'); ?>", // Set the url
  		params: {
     		appli_id: "<?php echo $appli_id; ?>",
    	},
  	  // thumbnailWidth: 80,
  	  // thumbnailHeight: 80,
  		maxFilesize: 20,
  	  parallelUploads: 20,
      acceptedFiles: "image/*,application/pdf,.docx,.doc,.xlsx,.xls",
      createImageThumbnails: false,
  	  previewTemplate: previewTemplate,
  	  autoQueue: false, // Make sure the files aren't queued until manually added
  	  previewsContainer: "#previews", // Define the container to display the previews
  	  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  	});

  	myDropzone.on("addedfile", function(file) {
  	  // Hookup the start button
  	  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
      $('#process_transaction_button').prop('disabled', true);
  	});

  	// Update the total progress bar
  	myDropzone.on("totaluploadprogress", function(progress) {
  	  document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
  	});

  	myDropzone.on("sending", function(file) {
  	  // Show the total progress bar when upload starts
  	  document.querySelector("#total-progress").style.opacity = "1";
  	  // And disable the start button
  	  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
  	});

  	// Hide the total progress bar when nothing's uploading anymore
  	myDropzone.on("queuecomplete", function(progress) {
  	  document.querySelector("#total-progress").style.opacity = "0";
      $('#process_transaction_button').prop('disabled', false);
  	});

  	// Setup the buttons for all transfers
  	// The "add files" button doesn't need to be setup because the config
  	// `clickable` has already been specified.
  	document.querySelector("#actions .start").onclick = function() {
  	  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
  	};
  	document.querySelector("#actions .cancel").onclick = function() {
  	  myDropzone.removeAllFiles(true);
  	};
  });

</script>
