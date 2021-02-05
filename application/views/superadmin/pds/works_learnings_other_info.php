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
    } thead {
      font-size: 14px;
    } th {
      border: 1px solid gray;
    }
  </style>

  <!-- ##################################    MODALS    ################################################################### -->

  <div class="modal fade" id="addVoluntaryWorkModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Voluntary Work</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset>
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Name & Address of Organization (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="name_address_of_organization" />
                              </div>
                              <div class="form-group">
                                <label>Inclusive Dates (mm/dd/yyyy)</label>
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
                                <label>Number of Hours</label>
                                <input type="text" class="form-control form-control-sm" name="no_of_hours" />
                              </div>
                              <div class="form-group">
                                <label>Position / Nature of Work</label>
                                <input type="text" class="form-control form-control-sm" name="position_nature_of_work" />
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnVoluntaryWork" type="button" class="btn btn-primary btn-sm">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="addLearningDevelopmentModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Learning and Development Interventions</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset>
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Title of Learning and Development Interventions / Training Programs (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="title" />
                              </div>
                              <div class="form-group">
                                <label>Inclusive Dates of Attendance (mm/dd/yyyy)</label>
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
                                <label>Number of Hours</label>
                                <input type="text" class="form-control form-control-sm" name="no_of_hours" />
                              </div>
                              <div class="form-group">
                                <label>Type of LD ( Managerial/Supervisory/Technical/etc)</label>
                                <input type="text" class="form-control form-control-sm" name="type_of_ld" />
                              </div>
                              <div class="form-group">
                                <label>Conducted / Sponsored By (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="conducted_by" />
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnLearningDevelopment" type="button" class="btn btn-primary btn-sm">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="addOtherInformationModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Other Information</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <fieldset id="educationalBackgroundFieldset">
                      <div id="edit_details_body">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label>Special Skills and Others</label>
                                <input type="text" class="form-control form-control-sm" name="skills_and_hobbies" />
                              </div>
                              <div class="form-group">
                                <label>Non-Academic Distinctions / Recognition (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="non_academic_distinctions" />
                              </div>
                              <div class="form-group">
                                <label>Membership in Association / Organization (Write in Full)</label>
                                <input type="text" class="form-control form-control-sm" name="membership" />
                              </div>
                          </div>
                      </div>
                  </fieldset>
              </div>
              <div class="modal-footer">
                  <button id="btnOtherInfo" type="button" class="btn btn-primary btn-sm">Add</button>
              </div>
          </div>
      </div>
  </div>

  <div class="col-md-12">
        <div class="card shadow">
              <div class="card-body">
                  <fieldset>
                      <legend>Voluntary Works, Learning and Development, and Other Information</legend>
                      <hr />
                      <div class="row no-gutters align-items-center justify-content-md-center">
                          <div class="col-md-10 mr-2">
                              <!-- ########################## Voluntary Work TABLE ################################### -->
                              <hr />
                              <label>Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization/s</label>
                              <hr />
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVoluntaryWorkModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                              <br /><br />
                              <div id="voluntaryWorkDataTable" class="row">
                                  <div class="table-responsive">
                                      <table class="table table-hover" width="100%">
                                          <thead style="text-align: center">
                                              <tr>
                                                <th colspan="3"></th>
                                                <th colspan="2">Inclusive Dates (mm/dd/yyyy)</th>
                                                <th colspan="3"></th>
                                              </tr>
                                              <tr>
                                                <th>id</th>
                                                <th>userid</th>
                                                <th>Name & Address of Organization (Write in Full)</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Number of Hours</th>
                                                <th>Position / Nature of Work</th>
                                                <th></th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div> <br />
                              <br />
                              <!-- ########################## Learning and Development TABLE ################################### -->
                              <hr />
                              <label>Learning and Development (L&D) Interventions / Training Programs Attended</label>
                              <hr />
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLearningDevelopmentModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                              <br /><br />
                              <div id="learningDevelopmentDataTable" class="row">
                                  <div class="table-responsive">
                                      <table class="table table-hover" width="100%">
                                          <thead style="text-align: center">
                                              <tr>
                                                <th colspan="3"></th>
                                                <th colspan="2">Inclusive Dates of Attendance (mm/dd/yyyy)</th>
                                                <th colspan="4"></th>
                                              </tr>
                                              <tr>
                                                <th>id</th>
                                                <th>userid</th>
                                                <th>Title of Learning and Development Interventions / Training Programs (Write in full)</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Number of Hours</th>
                                                <th>Type of LD (Managerial / Supervisory / Technical / etc.)</th>
                                                <th>Conducted / Sponsored By (Write in full)</th>
                                                <th></th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div> <br />
                              <br />
                              <!-- ########################## Other Information TABLE ################################### -->
                              <hr />
                              <label>Other Information</label>
                              <hr />
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOtherInformationModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                              <br /><br />
                              <div id="otherInformationDataTable" class="row">
                                  <div class="table-responsive">
                                      <table class="table table-hover" width="100%">
                                          <thead style="text-align: center">
                                              <tr>
                                                <th>id</th>
                                                <th>userid</th>
                                                <th >Special Skills and Hobbies</th>
                                                <th >Non-Academic Distinctions / Recognition</th>
                                                <th>Membership in Association / Organization (Write in full)</th>
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
  $(document).ready(function(){

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
                    url: "<?=base_url('Admin/Pds/Form_Data/delete_workpage')?>",
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

      let voluntaryWorkCols = [
          { data: "id", "searchable": false, "visible": false },
          { data: "userid", "searchable": false, "visible": false },
          { data: "name_address_of_organization" },
          { data: "inclusive_dates_from" },
          { data: "inclusive_dates_to" },
          { data: "no_of_hours" },
          { data: "position_nature_of_work" },
          { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
              data = '<a data-toggle="modal" href="#editVoluntaryWorkModal" class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
              data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
              return data;
            }
          }
      ];
      setDataTables($('#voluntaryWorkDataTable'), 'pds_voluntary_work', voluntaryWorkCols);

      let learningDevCols = [
          { data: "id", "searchable": false, "visible": false },
          { data: "userid", "searchable": false, "visible": false },
          { data: "title" },
          { data: "inclusive_dates_from" },
          { data: "inclusive_dates_to" },
          { data: "no_of_hours" },
          { data: "type_of_ld" },
          { data: "conducted_by" },
          { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
              data = '<a data-toggle="modal" href="#editLearningDevelopmentModal" class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
              data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
              return data;
            }
          }
      ];
      setDataTables($('#learningDevelopmentDataTable'), 'pds_learning_development', learningDevCols);

      let otherInfoCols = [
          { data: "id", "searchable": false, "visible": false },
          { data: "userid", "searchable": false, "visible": false },
          { data: "skills_and_hobbies" },
          { data: "non_academic_distinctions" },
          { data: "membership" },
          { data: null, searchable: false, sortable: false,
            "render": function(data, type, row, meta) {
              data = '<a data-toggle="modal" href="#editOtherInformationModal" class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
              data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
              return data;
            }
          }
      ];
      setDataTables($('#otherInformationDataTable'), 'pds_other_info', otherInfoCols);

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

      $('button#btnVoluntaryWork').click(function(){
        fieldsetSubmits('#addVoluntaryWorkModal', '#voluntaryWorkDataTable', 'pds_voluntary_work');
      });
      $('button#btnLearningDevelopment').click(function(){
        fieldsetSubmits('#addLearningDevelopmentModal', '#learningDevelopmentDataTable', 'pds_learning_development');
      });
      $('button#btnOtherInfo').click(function(){
        fieldsetSubmits('#addOtherInformationModal', '#otherInformationDataTable', 'pds_other_info');
      });

  });
</script>
