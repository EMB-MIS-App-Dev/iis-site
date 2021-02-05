<main>

  <style>
    fieldset legend {
      font-size: 100%;
      font-weight: bold;
    }
    fieldset label {
      color: black;
      font-weight: 650;
    }
    fieldset label:not([for=:empty]) {
      color: red;
    }

    table {
      /* border: 1px solid gray; */
    }
    thead {
      font-size: 14px;
    }
    th {
      border: 1px solid gray;
    }
  </style>

  <!-- #####################################################    ADD MODALS    ################################################################### -->
  <div class="modal fade" id="addEducationalBackgroundModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Educational Background</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset id="educationalBackgroundFieldset">
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Level</label>
                                <select class="form-control form-control-sm" name="level" >
                                    <?php
                                      foreach ($educ_levels as $index => $level) {
                                        echo '<option value="'.$level['name'].'">'.$level['name'].'</option>';
                                      }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Name of School (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="name_of_school" />
                              </div>
                              <div class="form-group">
                                <label>Basic Education / Degree / Course (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="basic_education_degree_course" />
                              </div>
                              <div class="form-group">
                                <label>Period of Attendance	</label>
                                <div class="row">
                                    <div class="col-md-6">
                                      <label>From</label>
                                        <input type="text" class="form-control form-control-sm" name="attendance_from" />
                                    </div>
                                    <div class="col-md-6">
                                      <label>To</label>
                                        <input type="text" class="form-control form-control-sm" name="attendance_to" />
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Highest Level / Units Earned</label>
                                <input type="text" class="form-control form-control-sm" name="highest_level_unit_earned" />
                              </div>
                              <div class="form-group">
                                <label>Year Graduated</label>
                                <input type="text" class="form-control form-control-sm" name="year_graduated" />
                              </div>
                              <div class="form-group">
                                <label>Scholarship / Academic Honors Received</label>
                                <input type="text" class="form-control form-control-sm" name="scholarship_honor_received" />
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnEducBackground" type="button" class="btn btn-primary btn-sm" name="save">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="addEligibilityModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Service Eligibility</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset id="eligibilityFieldset">
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Career Service/ RA 1080 (BOARD/ BAR) Under Special Laws/ CES/ CSEE / Barangay Eligibility / Driver's License</label>
                                <input type="text" class="form-control form-control-sm" name="eligibility_description" />
                              </div>
                              <div class="form-group">
                                <label>Rating (if applicable)</label>
                                <input type="text" class="form-control form-control-sm" name="rating" />
                              </div>
                              <div class="form-group">
                                <label>Date of Examination / Conferment</label>
                                <input type="text" class="form-control form-control-sm" name="date_of_examination" />
                              </div>
                              <div class="form-group">
                                <label>Place of Examination / Conferment</label>
                                <input type="text" class="form-control form-control-sm" name="place_of_examination" />
                              </div>
                              <div class="form-group">
                                <label>License (if applicable)</label>
                                <div class="row">
                                    <div class="col-md-6">
                                      <label>Number</label>
                                        <input type="text" class="form-control form-control-sm" name="license_no" />
                                    </div>
                                    <div class="col-md-6">
                                      <label>Date of validity</label>
                                        <input type="text" class="form-control form-control-sm" name="date_of_validity" />
                                    </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnEligibility" type="button" class="btn btn-primary btn-sm" name="save">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="addWorkExperienceModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Service Eligibility</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset>
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Inclusive Dates</label>
                                <div class="row">
                                    <div class="col-md-6">
                                      <label>From</label>
                                        <input type="text" class="form-control form-control-sm" name="inclusive_dates_from" />
                                    </div>
                                    <div class="col-md-6">
                                      <label>To</label>
                                        <input type="text" class="form-control form-control-sm" name="inclusive_dates_to" />
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Position Title (Write in full/Do not abbreviate)</label>
                                <input type="text" class="form-control form-control-sm" name="position_title" />
                              </div>
                              <div class="form-group">
                                <label>Department / Agency / Office / Company (Write in full/Do not abbreviate)</label>
                                <input type="text" class="form-control form-control-sm" name="company" />
                              </div>
                              <div class="form-group">
                                <label>Monthly Salary</label>
                                <input type="text" class="form-control form-control-sm" name="monthly_salary" />
                              </div>
                              <div class="form-group">
                                <label>Salary / Job / Pay Grade (if applicable) & Step (Format "00-00")/Increment</label>
                                <input type="text" class="form-control form-control-sm" name="salary_grade_and_step" />
                              </div>
                              <div class="form-group">
                                <label>Status of Appointment</label>
                                <input type="text" class="form-control form-control-sm" name="status_of_appointment" />
                              </div>
                              <div class="form-group">
                                <label>Is it a Goverment Service?</label>
                                <div class="col-md-3">
                                  <select class="form-control form-control-sm" name="is_government">
                                      <option value="Y">Yes</option>
                                      <option value="N">No</option>
                                  </select>
                                </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnWorkExperience" type="button" class="btn btn-primary btn-sm" name="save">Add</button>
              </div>
          </div>
      </div>
  </div>

  <!-- #####################################################    EDIT MODALS    ################################################################### -->

  <div class="modal fade" id="editEducationalBackgroundModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" ><i class="far fa-edit"></i> Educational Background</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset>
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Level</label>
                                <select class="form-control form-control-sm" name="level" >
                                    <?php
                                      foreach ($educ_levels as $index => $level) {
                                        echo '<option value="'.$level['name'].'">'.$level['name'].'</option>';
                                      }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Name of School (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="name_of_school" />
                              </div>
                              <div class="form-group">
                                <label>Basic Education / Degree / Course (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="basic_education_degree_course" />
                              </div>
                              <div class="form-group">
                                <label>Period of Attendance	</label>
                                <div class="row">
                                    <div class="col-md-6">
                                      <label>From</label>
                                        <input type="text" class="form-control form-control-sm" name="attendance_from" />
                                    </div>
                                    <div class="col-md-6">
                                      <label>To</label>
                                        <input type="text" class="form-control form-control-sm" name="attendance_to" />
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Highest Level / Units Earned</label>
                                <input type="text" class="form-control form-control-sm" name="highest_level_unit_earned" />
                              </div>
                              <div class="form-group">
                                <label>Year Graduated</label>
                                <input type="text" class="form-control form-control-sm" name="year_graduated" />
                              </div>
                              <div class="form-group">
                                <label>Scholarship / Academic Honors Received</label>
                                <input type="text" class="form-control form-control-sm" name="scholarship_honor_received" />
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnEducBackground" type="button" class="btn btn-primary btn-sm">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="editEligibilityModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Service Eligibility</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset >
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Career Service/ RA 1080 (BOARD/ BAR) Under Special Laws/ CES/ CSEE / Barangay Eligibility / Driver's License</label>
                                <input type="text" class="form-control form-control-sm" name="eligibility_description" />
                              </div>
                              <div class="form-group">
                                <label>Rating (if applicable)</label>
                                <input type="text" class="form-control form-control-sm" name="rating" />
                              </div>
                              <div class="form-group">
                                <label>Date of Examination / Conferment</label>
                                <input type="text" class="form-control form-control-sm" name="date_of_examination" />
                              </div>
                              <div class="form-group">
                                <label>Place of Examination / Conferment</label>
                                <input type="text" class="form-control form-control-sm" name="place_of_examination" />
                              </div>
                              <div class="form-group">
                                <label>License (if applicable)</label>
                                <div class="row">
                                    <div class="col-md-6">
                                      <label>Number</label>
                                        <input type="text" class="form-control form-control-sm" name="license_no" />
                                    </div>
                                    <div class="col-md-6">
                                      <label>Date of validity</label>
                                        <input type="text" class="form-control form-control-sm" name="date_of_validity" />
                                    </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnEligibility" type="button" class="btn btn-primary btn-sm">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="editWorkExperienceModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Service Eligibility</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset>
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Inclusive Dates</label>
                                <div class="row">
                                    <div class="col-md-6">
                                      <label>From</label>
                                        <input type="text" class="form-control form-control-sm" name="inclusive_dates_from" />
                                    </div>
                                    <div class="col-md-6">
                                      <label>To</label>
                                        <input type="text" class="form-control form-control-sm" name="inclusive_dates_to" />
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Position Title (Write in full/Do not abbreviate)</label>
                                <input type="text" class="form-control form-control-sm" name="position_title" />
                              </div>
                              <div class="form-group">
                                <label>Department / Agency / Office / Company (Write in full/Do not abbreviate)</label>
                                <input type="text" class="form-control form-control-sm" name="company" />
                              </div>
                              <div class="form-group">
                                <label>Monthly Salary</label>
                                <input type="text" class="form-control form-control-sm" name="monthly_salary" />
                              </div>
                              <div class="form-group">
                                <label>Salary / Job / Pay Grade (if applicable) & Step (Format "00-00")/Increment</label>
                                <input type="text" class="form-control form-control-sm" name="salary_grade_and_step" />
                              </div>
                              <div class="form-group">
                                <label>Status of Appointment</label>
                                <input type="text" class="form-control form-control-sm" name="status_of_appointment" />
                              </div>
                              <div class="form-group">
                                <label>Is it a Goverment Service?</label>
                                <div class="col-md-3">
                                  <select class="form-control form-control-sm" name="is_government">
                                      <option value="Y">Yes</option>
                                      <option value="N">No</option>
                                  </select>
                                </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnWorkExperience" type="button" class="btn btn-primary btn-sm">Add</button>
              </div>
          </div>
      </div>
  </div>

  <!-- #####################################################    MODALS    ################################################################### -->
  <div class="col-md-12">
        <div class="card shadow">
              <div class="card-body">
                  <fieldset>
                      <legend>Education, Eligibility, and Work Experience</legend>
                      <hr />
                      <div class="row no-gutters align-items-center justify-content-md-center">
                          <div class="col-md-10 mr-2">
                              <hr />
                              <label>Educational Background</label>
                              <hr />
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEducationalBackgroundModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                              <br /><br />
                              <div id="educDataTable" class="row">
                                  <div class="table-responsive">
                                      <table class="table table-hover">
                                          <thead style="text-align: center">
                                              <tr>
                                                <th colspan="3"></th>
                                                <th colspan="2">Period of Attendance</th>
                                                <th colspan="3"></th>
                                                <th colspan="3"></th>
                                              </tr>
                                              <tr>
                                                <th>id</th>
                                                <th>userid</th>
                                                <th>Level</th>
                                                <th>Name of School (Write in full)</th>
                                                <th>Basic Education/Degree/Course (Write in full)</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Highest Level / Units Earned (if not graduated)</th>
                                                <th>Year Graduated</th>
                                                <th>Scholarship / Academic Honors Received</th>
                                                <th></th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div> <br />
                              <br />

                              <hr />
                              <label>Civil Service Eligibility</label>
                              <hr />
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEligibilityModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                              <br /><br />
                              <div id="eligibilityDataTable" class="row">
                                  <div class="table-responsive">
                                      <table class="table table-hover">
                                          <thead style="text-align: center">
                                              <tr>
                                                <th colspan="6"></th>
                                                <th colspan="2">License (if applicable)</th>
                                                <th></th>
                                              </tr>
                                              <tr>
                                                <th>id</th>
                                                <th>userid</th>
                                                <th>Career Service/ RA 1080 (BOARD/ BAR) Under Special Laws/ CES/ CSEE / Barangay Eligibility / Driver's License </th>
                                                <th>Rating (if applicable)</th>
                                                <th>Date of Examination / Conferment</th>
                                                <th>Place of Examination / Conferment</th>
                                                <th>Number</th>
                                                <th>Date of Validity</th>
                                                <th></th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div> <br />
                              <br />

                              <hr />
                              <label>Work Experience</label>
                              <hr />
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addWorkExperienceModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                              <br /><br />
                              <div id="workExperienceDataTable" class="row">
                                  <div class="table-responsive">
                                      <table class="table table-hover">
                                          <thead style="text-align: center">
                                              <tr>
                                                <th colspan="2"></th>
                                                <th colspan="2">Inclusive Dates (mm/dd/yy)</th>
                                                <th colspan="7"></th>
                                              </tr>
                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Position Title (Write in full/Do not abbreviate)</th>
                                                <th>Department / Agency / Office / Company (Write in full/Do not abbreviate)</th>
                                                <th>Monthly Salary</th>
                                                <th>Salary / Job / Pay Grade (if applicable) & Step (Format "00-00")/Increment</th>
                                                <th>Status of Appointment</th>
                                                <th>Is it a Goverment Service? (Y/N)</th>
                                                <th></th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div> <br />
                              <br />
                          </div>
                      </div>
                  </fieldset>
                  <hr />
                  <button class="btn btn-success float-right" type="submit">Submit and Proceed</button>
                  <br />
              </div>
        </div>
  </div>

</main>

<script>
  $(document).ready(function() {

      function setDataTables (tableID, tableData, columns) {
          let table = tableID.find('table').DataTable( {
  						lengthMenu: [ [5, 15, -1], [5, 15, "All"] ],
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
                  "url": "<?=base_url('Admin/Pds/Table_Data/')?>"+tableData,
                  "type": 'POST',
              },
              columns: columns
          } );

          tableID.find("div.search_bar").html('<input class="search_bar search_fld form-control form-control-sm" />');
          tableID.find("div.search_btn").html('<button class="search_btn search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span class="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

          tableID.find(".search_btn").on('click', function () {
            console.log(tableID.find(".search_bar").val());
    				table.settings()[0].jqXHR.abort();
    				table.search(tableID.find(".search_bar").val()).draw();
    				tableID.find('.search_spinner').show();
    				tableID.find(".search_fld").prop('disabled', true);
    			});

    			table.on( 'draw', function () {
    				tableID.find('.search_spinner').hide();
    				tableID.find(".search_fld").prop('disabled', false);
    			} );

          tableID.find('tbody').on( 'click', 'a.deletebtn', function () {
      				 var data = table.row( $(this).parents('tr') ).data();
               let confirmDelete = window.confirm("Confirm Deletion?");
               // console.log(confirmDelete);
               // console.log(data['id']);
               // console.log(tableData);

               if(confirmDelete) {
                 var request = $.ajax({
                    url: "<?=base_url('Admin/Pds/Form_Data/delete_educpage')?>",
                    method: 'POST',
                    data: { id : data['id'], table: tableData },
                    beforeSend: function(jqXHR, settings) {
                      $('#dataTable tbody').find('button[type="button"]').attr('disabled','disabled');
                    }
                 });

                 request.done(function(data) {
                   table.draw();
                   tableID.find('tbody button[type="button"]').attr('disabled',false);
                 });

                 request.fail(function(jqXHR, textStatus) {
                   alert( "Request failed: " + textStatus );
                   tableID.find('tbody button[type="button"]').attr('disabled',false);
                 });
               }
      		} );
      }

      let educCols = [
          { data: "id", "searchable": false, "visible": false },
          { data: "userid", "searchable": false, "visible": false },
          { data: "level" },
          { data: "name_of_school" },
          { data: "basic_education_degree_course" },
          { data: "attendance_from" },
          { data: "attendance_to" },
          { data: "highest_level_unit_earned" },
          { data: "year_graduated" },
          { data: "scholarship_honor_received" },
          { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
              data = '<a data-toggle="modal" href="#editEducationalBackgroundModal" class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
              data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
              return data;
            }
          }
      ];
      setDataTables($('#educDataTable'), 'pds_educational_background', educCols);

      let eligibilityCols = [
          { data: "id", "searchable": false, "visible": false },
          { data: "userid", "searchable": false, "visible": false },
          { data: "eligibility_description" },
          { data: "rating" },
          { data: "date_of_examination" },
          { data: "place_of_examination" },
          { data: "license_no" },
          { data: "date_of_validity" },
          { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
              data = '<a data-toggle="modal" href="#editEligibilityModal" class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
              data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
              return data;
            }
          }
      ];
      setDataTables($('#eligibilityDataTable'), 'pds_civil_service', eligibilityCols);

      let workExperienceCols = [
          { data: "id", "searchable": false, "visible": false },
          { data: "userid", "searchable": false, "visible": false },
          { data: "inclusive_dates_from" },
          { data: "inclusive_dates_to" },
          { data: "position_title" },
          { data: "company" },
          { data: "monthly_salary" },
          { data: "salary_grade_and_step" },
          { data: "status_of_appointment" },
          { data: "is_government" },
          { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
              data = '<a data-toggle="modal" href="#editWorkExperienceModal" class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
              data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
              return data;
            }
          }
      ];
      setDataTables($('#workExperienceDataTable'), 'pds_work_experience', workExperienceCols);

      // ############################  add educational background modal & table functionalities  ####################################### //

      function fieldsetSubmits(modalID, tableID, table) {
          let fieldsetGroup = $('div'+modalID+' fieldset');
          let dataTable = $('div'+tableID).find('table');

          let postData = {};
          fieldsetGroup.find('input, select').each(
            function (index){
              let input = $(this);
              postData[input.attr('name')] = input.val();
            }
          );

          var request = $.ajax({
             url: "<?=base_url('Admin/Pds/Form_Data/')?>"+table,
             method: 'POST',
             data: { post : postData },
             beforeSend: function(jqXHR, settings){
               fieldsetGroup.find('input').attr('disabled','disabled');
               fieldsetGroup.find('button').html('loading..').attr('disabled','disabled');
             }
          });

          request.done(function(data) {
            $('div'+tableID).find('table').DataTable().draw();
    				dataTable.find('.search_spinner').show();
    				dataTable.find(".search_fld").prop('disabled', true);

            fieldsetGroup.find('input').val('').attr('disabled', false);
            fieldsetGroup.find('button').html('Save').attr('disabled', false);

            $('div'+modalID).modal('hide');
          });

          request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
            fieldsetGroup.find('input').attr('disabled','');
            fieldsetGroup.find('button').html('loading..').attr('disabled','');
          });
      }

      $('button#btnEducBackground').click(function(){
        fieldsetSubmits('#addEducationalBackgroundModal', '#educDataTable', 'pds_educational_background');
      });
      $('button#btnEligibility').click(function(){
        fieldsetSubmits('#addEligibilityModal', '#eligibilityDataTable', 'pds_civil_service');
      });
      $('button#btnWorkExperience').click(function(){
        fieldsetSubmits('#addWorkExperienceModal', '#workExperienceDataTable', 'pds_work_experience');
      });

  });
</script>
