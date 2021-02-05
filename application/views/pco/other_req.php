
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

                <input name="sampleeasdasd" value="1" />
                <div>
                  If you have any, give details of the case.
                  <textarea class="form-control" name="case_details"><?=trim(!empty(set_value('case_details')) ? set_value('case_details') : $other_req[0]['case_details'])?></textarea>
                </div> <br>

                <label>Attachments ( Please attach the requirements here )   </label> <br>
                <span style="font-size: 14px; color: red"> We only accept .pdf files with sizes not greater than 20 mb *. For a faster processing of your application, please compile documents with separated pages into one file. You may use these sites: online compiler: <a href="https://combinepdf.com/" target="_blank">Combine PDF</a> to merge them and <a href="https://topdf.com/" target="_blank">To PDF</a> to convert documents into pdf file. </span>
                <hr> <br>

                <style>
                  .attach_desc{
                    min-height: 60px !important;
                    background-color: white !important;
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
                      $reqrd = (in_array($value['attach_id'], array(1, 2, 3))) ? '*' : '';
                      $attched = '';
                      if(!empty($other_req_uploads))
                      {
                        foreach ($other_req_uploads as $key2 => $value2) {
                          if($value2['attach_id'] == $value['attach_id']) {
                            $attched = $value2['file_name'];
                            break;
                          }
                        }
                      }
                      if(!empty($attched)) {
                        echo '
                          <div class="form-group col-md-2">
                            <a href="'.base_url('uploads/requirements/'.$attched).'" target="_blank"><button type="button" class="form-control btn btn-sm btn-info"> <i class="fas fa-eye"></i> </button></a>
                          </div>
                          <div class="form-group col-md-1">
                            <button type="button" class="form-control btn btn-sm btn-warning"> <i class="fas fa-recycle"></i> </button>
                          </div>
                        ';
                      }
                      else {
                        echo '
                          <div class="form-group col-md-3">
                            <input type="file" name="file_name'.$key.'" accept="image/*, application/pdf" >
                          </div>
                        ';
                      }
                      echo '
                        <div class="form-group col-md-8">
                          <textarea class="form-control attach_desc" disabled>'.$value['attach_desc'].' '.$reqrd.'</textarea>
                        </div>
                        <div class="form-group col-md-1">
                          <a href="'.base_url('uploads/requirements/'.$value['sample_file']).'" target="_blank"><button type="button" class="form-control btn btn-sm btn-info"> <i class="fas fa-eye"></i> </button></a>
                        </div>
                      ';
                    }
                  ?>
                </div> <br> <br>

                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                  <input type="checkbox" class="custom-control-input" id="customControlInline" name="data_confirm" >
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
