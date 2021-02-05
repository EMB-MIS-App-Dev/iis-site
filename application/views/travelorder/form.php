    <style>
      textarea {
        min-height: 100px;
      }
      .form-check.form-check-inline {
          margin-left: 38px;
      }
      div#header-form {
          background-color: #F8F9FC;
          color: #858796;
      }
      label.form-check-label {
          font-size: 13pt;
      }
      label {
          font-size: 10pt;
          color: #000;
      }

      span.fa.fa-undo {
          cursor: pointer;
      }

      .data-div {
        min-height: 870px;
      }
      .upload_div {
        border: 1px solid #EAECF4;
      }
      .upload_div a {
        font-size: 13px !important;
        padding: 5px;
        margin: 5px;
      }
      .card-body {
        font-size: 13px;
      }
      .modal-body {
        font-size: 14px;
      }
      .container{
        margin: 0 auto;
        width: 100px;
      }
      .error {
        font-size: 12px !important;
      }

      /* dropzone */
      div.dropzone_table {
        display: table;
        white-space: nowrap;
      }
      div.dropzone_table .file-row {
        display: table-row;
      }
      div.dropzone_table .file-row > div {
        display: table-cell;
        vertical-align: top;
      }
      div.dropzone_table .file-row:nth-child(odd) {
        background: #f9f9f9;
      }

      /* The total progress gets shown by event listeners */
      #total-progress {
        opacity: 0;
        transition: opacity 0.3s linear;
      }
      /* Hide the progress bar when finished */
      #previews .file-row.dz-success .progress {
        opacity: 0;
        transition: opacity 0.3s linear;
      }
      /* Hide the delete button initially */
      #previews .file-row .delete {
        display: none;
      }
      /* Hide the start and cancel buttons and show the delete button */
      #previews .file-row.dz-success .start,
      #previews .file-row.dz-success .cancel {
        display: none;
      }
      #previews .file-row.dz-success .delete {
        display: block;
      }
    </style>
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-plus"> </i> APPLY TRAVEL ORDER</h6>

            </div>

            <form action="<?php echo base_url(); ?>Travel/Submitform/submit_travel" method="POST" enctype="multipart/form-data">
            <!-- Card Body -->
              <div class="card-body">

                    <div class="table-responsive" style="min-height: 800px !important">
                      <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#add-transaction" role="tab" aria-controls="add-transaction" aria-selected="true">Form</a>
                        </div>
                      </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="add-transaction" role="tabpanel" aria-labelledby="add-transaction-tab">
                              <div class="row">
                                  <div class="col-md-12"><br>
                                    <label>Transaction No.:</label>
                                    <input class="form-control" name="trans_no" value="<?php echo $_SESSION['travel_trans_no_token']; ?>" readonly />
                                  </div>
                              </div>
                              <br>
                              <div class="col-xl-12 col-lg-12" style="padding:0px;">
                                <div class="trans-layout card">
                                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0"><i class="fa fa-file"></i> Travel Form</h6>
                                    <?php if($this->session->userdata('region') == 'R7'){ ?>
                                      <div style="float:right;display: flex;">
                                        <select name="travel_format" id="travel_format_id" onchange="view_travel_format(this.value);">
                                          <option value="<?php echo $this->encrypt->encode('1'); ?>">Format 1</option>
                                          <option value="<?php echo $this->encrypt->encode('2'); ?>">Format 2</option>
                                          <option value="<?php echo $this->encrypt->encode('3'); ?>">Format 3</option>
                                        </select>
                                        <div id="view_format_mdl_">
                                          <a type="button" class="btn btn-info btn-sm" target="_blank" style="font-size: 7pt;margin-left:5px;" href="https://iis.emb.gov.ph/iis-images/travel/format-1.pdf">View Format</a>
                                        </div>
                                      </div>
                                    <?php } ?>
                                  </div>
                                  <!-- Card Body -->
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-6" style="padding-left:0px;">
                                        <label>Are you travelling within your jurisdiction? <span id="requiredto">(required)</span></label>
                                        <select class="form-control" id="travel_cat_selectize" onchange="stcmpvw(this.value);" name="travel_cat" required="">
                                          <option></option>
                                          <option value="Yes">Yes (Regional)</option>
                                          <option value="No">No (National)</option>
                                        </select>
                                      </div>

                                      <div class="col-md-6" style="padding-right:0px;">
                                        <label>Are you travelling by <span id="requiredto">(required)</span></label>
                                        <select class="form-control"  id="travel_type_selectize" name="travel_type" required=""> <!-- onchange="traveltype();"  -->
                                          <option></option>
                                          <option value="Air">Air</option>
                                          <option value="Land">Land</option>
                                          <option value="Water">Water</option>
                                        </select>
                                      </div>
                                      <div id="traveltypebody"></div>
                                      <div class="col-md-12"><hr></div>

                                      <?php if($browser == 'Safari'){ $datespan = "( Date format: 'yyyy-mm-dd' )";  }else{ $datespan = ""; } ?>

                                      <div class="row">
                                        <div class="col-md-6" style="margin-top:5px;">
                                          <label>Departure Date: <?php echo $datespan; ?> <span id="requiredto">(required)</span></label>
                                          <input type="date" name="departure_date" id="departure_date" onchange="checkdate(this.value);"  placeholder="0000-00-00" class="form-control" required="">
                                        </div>
                                        <div class="col-md-6" style="margin-top:5px;">
                                          <label>Arrival Date: <?php echo $datespan; ?> <span id="requiredto">(required)</span></label>
                                          <input type="date" name="arrival_date" id="arrival_date" placeholder="0000-00-00" class="form-control" required="">
                                        </div>
                                        <div class="col-md-12" style="margin-top:10px;">
                                          <label>Official Station: <span id="requiredto">(required)</span></label>
                                          <input type="text" name="off_station" class="form-control" value="<?php echo $official_station; ?>" required="">
                                        </div>
                                        <div class="col-md-12"><hr></div>
                                          <table style="width: 100%;">
                                            <tbody>
                                              <tr>
                                                 <td>
                                                    <div class="col-md-12">
                                                      <div class="row" id="ifnotinthelistbody">
                                                        <div class="col-md-4">
                                                          <label>Destination: <span id="requiredto">(required)</span></label>
                                                          <select id="selectize_attachment" class="form-control" name="destination[]" onchange="notinthelist($(this),this.value,$('#add_more_row').val()); coordinates_lat($(this),this.value);coordinates_lon($(this),this.value);">
                                                            <option value=""></option>
                                                            <option value="ifnotinthelist">Not in the list?</option>
                                                            <optgroup label="Company / Establishment List">
                                                              <?php for($i=0; $i<sizeof($companylist); $i++){ ?>
                                                                <option value="<?php echo $companylist[$i]['company_name']; ?>"><?php echo ucwords($companylist[$i]['company_name']); ?></option>
                                                              <?php } ?>
                                                            </optgroup>
                                                          </select>
                                                        </div>
                                                        <div class="col-md-3" id="latitude">
                                                          <label>Latitude: <span id="requiredto">(required)</span></label>
                                                          <input type="text" class="form-control" disabled="">
                                                        </div>
                                                        <div class="col-md-3" id="longitude">
                                                          <label>Longitude: <span id="requiredto">(required)</span></label>
                                                          <input type="text" class="form-control" disabled="">
                                                        </div>
                                                        <div class="col-md-2">
                                                          <label>Add More Row:</label>
                                                          <select class="form-control" onchange="add_row_destination(this.value,$('#travel_cat_selectize').val());" id="add_more_row">
                                                            <?php for ($i=0; $i < 11; $i++) {
                                                              echo '<option value="'.$i.'">'.$i.'</option>';
                                                            } ?>
                                                          </select>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </td>
                                              </tr><br>
                                            </tbody>
                                          </table>
                                          <div class="col-md-12" id="add_row_destination_body"></div>
                                         <div class="col-md-12"><hr></div>
                                        <div class="col-md-12" style="margin-top:5px;">
                                          <label>Purpose of Travel: <span id="requiredto">(required)</span></label>
                                          <textarea name="purpose" class="form-control" maxlength="680" required="" placeholder="680 characters only"></textarea>
                                        </div>

                                        <div class="col-md-6" style="margin-top:10px;">
                                          <label>Per Diems/ Expenses Allowed:</label>
                                          <input type="text" name="per_diem" class="form-control">
                                        </div>

                                        <div class="col-md-6" id="notinlist_labor_body" style="margin-top:10px;">
                                          <label>Assistant or laborers Allowed: <span id="requiredto">(single / multiple selection)</span></label>
                                          <select class="form-control" name="assistant[]" id="travel_assistant_selectize" onchange="notinlist_labor(this.value);" required="">
                                            <option value=""></option>
                                            <option value="ifnotinlist_labor">Not in the list? or N/A</option>
                                            <?php for($i=0; $i<sizeof($laborers); $i++){
                                              if(!empty($laborers[$i]['mname'])){ $mname = $laborers[$i]['mname'][0].". "; }else{ $mname = ""; }
                                              if(!empty($laborers[$i]['suffix'])){ $suffix = " ".$laborers[$i]['suffix']; }else{ $suffix = ""; }
                                              $laborer_name = ucwords($laborers[$i]['fname']." ".$mname.$laborers[$i]['sname'].$suffix)
                                            ?>
                                              <option value="<?php echo $laborer_name; ?>"><?php echo $laborer_name; ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>

                                        <div class="col-md-6" style="margin-top:5px;">
                                          <label>Remarks of Special Instruction: <span id="requiredto">(required)</span></label>
                                          <input type="text" name="remarks" class="form-control" value="Back to Office Report" required="">
                                        </div>
                                        <div class="col-md-6" style="margin-top:5px;">
                                          <label>Date of Report Submission: <span id="requiredto">(required)</span></label>
                                          <input type="date" name="report_submit" class="form-control" required>
                                        </div>

                                          <div class="col-md-12" style="margin-top:10px;">
                                            <label>Upload travel supporting documents</label>
                                            <div style="display:flex">
                                              <input type="file" name="supporting_docs[]" id="supporting_docs" class="form-control" multiple>
                                              <button type="button" class="btn btn-success btn-md" onclick="touploadattachments('<?php echo $this->encrypt->encode($this->session->userdata('travel_trans_no')); ?>');" style="font-size:11px;margin-left:10px;width:20%;height:38px;"><span class="fa fa-upload"></span>&nbsp;Upload</button>
                                              <button type="button" id="viewtouploadedfilesbtn" onclick="viewtouploadedfiles('<?php echo $this->encrypt->encode($this->session->userdata('travel_trans_no')); ?>');" data-toggle='modal' data-target='#viewtouploadedfiles' class="btn btn-info btn-md" style="margin-left:10px;font-size:11px;width:20%;height:38px;<?php echo !empty($this->session->userdata('toattachmentchecker')) ? '' : 'display:none;'; ?>">
                                                <span class="fa fa-eye"></span>&nbsp;View uploaded files
                                              </button>
                                            </div>
                                            <div class="progress" id="tosupdocs" style="display:none; margin-top:5px;">
                          									  <div class="progress-bar progress-bar-striped progress-bar-animated" id="tosupdocsuploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                          											<span id="tosupdocsprogresspercentage_"></span>
                          										</div>
                          									</div>
                                          </div>

                                      </div>
                                    </div>
                                  </div><br><br><br><br><br><br>
                                  <!-- Card Body -->
                                </div>

                              </div>
                            </div>

                        </div>

                    </div>

              </div>
              <!-- Card Body -->
              <div class="card-footer">
                <div class=" float-right">
                  <span id="error_message" style="color: red; font-style: italic; font-size: 9pt; margin-right: 20px;"></span>
                  <button type="submit" id="Process" class="btn btn-success btn-icon-split"><span class="text"> <i class="fas fa-share-square"></i> Process</span></button> <br /><br />
                </div>
              </div>

            </form>

            <div class="modal fade" id="viewtouploadedfiles" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="useraccountsModalLabel">Uploaded Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                    <div class="modal-body">
                        <div id="viewtouploadedfiles_"></div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
              </div>
            </div>

            <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/fullcalendar/moment.js"></script>

            </script>
            <script type="text/javascript">
               $(document).ready( function(){
                $('#add_more_row').selectize();
                $('#selectize_destination').selectize();
                $('#travel_type_selectize').selectize();
                $('#travel_cat_selectize').selectize();
                <?php if($_SESSION['userid'] == '468'){ ?>
                  $('#travel_assistant_selectize').selectize({
                      maxItems: null
                  });
                <?php }else{ ?>
                  $('#travel_assistant_selectize').selectize();
                <?php } ?>

                $('#selectize_attachment').selectize();
              });
            </script>
