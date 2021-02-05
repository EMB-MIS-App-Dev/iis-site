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

  <!-- #####################################################    MODALS    ################################################################### -->
  <div class="modal fade" id="addChildrenModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Add Child</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <fieldset id="addChildrenFieldset">
                  <div class="modal-body">
                        <div id="edit_details_body">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Name of Child</label>
                                  <input type="text" class="form-control form-control-sm" name="name" />
                                </div>
                                <div class="form-group">
                                  <label>Date of Birth</label>
                                  <input type="date" class="form-control form-control-sm" name="date_of_birth" />
                                </div>
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-sm" name="save">Save</button>
                  </div>
              </fieldset>
          </div>
      </div>
  </div>

  <div class="modal fade" id="editChildrenModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title"><i class="far fa-edit"></i> Edit Child</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <fieldset>
                  <input type="hidden" name="id" />
                  <div class="modal-body">
                        <div id="edit_details_body">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Name of Child</label>
                                  <input type="text" class="form-control form-control-sm" name="name" />
                                </div>
                                <div class="form-group">
                                  <label>Date of Birth</label>
                                  <input type="date" class="form-control form-control-sm" name="date_of_birth" />
                                </div>
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-sm" name="edit"><i class="far fa-edit"></i> Edit</button>
                  </div>
              </fieldset>
          </div>
      </div>
  </div>

  <div class="col-md-12">
        <div class="card shadow">
              <div class="card-body">
                  <?=form_open_multipart('Admin/Pds/Main/submit2')?>
                      <fieldset>
                          <legend>Family Background</legend>
                          <hr />
                          <div class="row no-gutters align-items-center justify-content-md-center">
                              <div class="col-md-10 mr-2">
                                  <hr />
                                  <label>Father's Name</label>
                                  <hr />
                                  <div class="row">
                                      <div class="col-md-3">
                                        <label>Surname</label>
                                        <input class="form-control form-control-sm" name="father_surname" />
                                      </div>
                                      <div class="col-md-4">
                                        <label>First Name</label>
                                        <input class="form-control form-control-sm" name="father_first_name" />
                                      </div>
                                      <div class="col-md-3">
                                        <label>Middle Name</label>
                                        <input class="form-control form-control-sm" name="father_middle_name" />
                                      </div>
                                      <div class="col-md-2">
                                        <label>Suffix (Jr, Sr, etc.)</label>
                                        <input class="form-control form-control-sm" name="father_name_extension" />
                                      </div>
                                  </div> <br />
                                  <hr />
                                  <label>Mother's <b>Maiden</b> Name</label>
                                  <hr />
                                  <div class="row">
                                      <div class="col-md-4">
                                        <label>Surname</label>
                                        <input class="form-control form-control-sm" name="mother_surname" />
                                      </div>
                                      <div class="col-md-4">
                                        <label>First Name</label>
                                        <input class="form-control form-control-sm" name="mother_first_name" />
                                      </div>
                                      <div class="col-md-4">
                                        <label>Middle Name</label>
                                        <input class="form-control form-control-sm" name="mother_middle_name" />
                                      </div>
                                  </div> <br />
                                  <hr />
                                  <label>Spouse's Information</label>
                                  <hr />
                                  <div class="row">
                                      <div class="col-md-3">
                                        <label>Surname</label>
                                        <input class="form-control form-control-sm" name="spouse_surname" />
                                      </div>
                                      <div class="col-md-4">
                                        <label>First Name</label>
                                        <input class="form-control form-control-sm" name="spouse_first_name" />
                                      </div>
                                      <div class="col-md-3">
                                        <label>Middle Name</label>
                                        <input class="form-control form-control-sm" name="spouse_middle_name" />
                                      </div>
                                      <div class="col-md-2">
                                        <label>Suffix (Jr, Sr, etc.)</label>
                                        <input class="form-control form-control-sm" name="spouse_name_extension" />
                                      </div>
                                  </div> <br />
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Occupation</label>
                                              <input class="form-control form-control-sm" type="text" name="spouse_occupation" />
                                          </div>
                                          <div class="form-group">
                                              <label>Business Address</label>
                                              <input class="form-control form-control-sm" type="text" name="business_address" />
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Employer/Business Name</label>
                                              <input class="form-control form-control-sm" type="text" name="employer_business_name" />
                                          </div>
                                          <div class="form-group">
                                              <label>Employer/Business Telephone No.</label>
                                              <input class="form-control form-control-sm" type="text" name="telephone_no" />
                                          </div>
                                      </div>
                                  </div> <br />
                                  <hr />
                                  <label>Children's Information</label>
                                  <hr />
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChildrenModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                                  <br /> <br />
                                  <div class="row">
                                      <div class="table-responsive">
                                          <table id="dataTable" class="table table-hover" width="100%">
                                              <thead>
                                                  <tr style="text-align: center">
                                                    <th></th>
                                                    <th></th>
                                                    <th>Name of Children</th>
                                                    <th>Date of Birth</th>
                                                    <th>dateformat</th>
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
                  <?=form_close()?>
              </div>
        </div>
  </div>

</main>

<script>
  $(document).ready(function() {

      // ########################################### CHILDREN DATA TABLES ######################################################## //
			// let tableData = {
			// 	'selected_region': '<?=$user['region']?>',
			// };

      let table = $('#dataTable').DataTable( {
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
              "url": "<?php echo base_url('Admin/Pds/Table_Data/pds_children'); ?>",
              "type": 'POST',
              // "data": function ( d ) {
              //           return  $.extend(d, tableData);
              //         },
          },
          columns: [
              { data: "id", "searchable": false, "visible": false },
              { data: "userid", "searchable": false, "visible": false },
              { data: "name" },
              { data: "date_of_birth" },
              { data: "date_of_birth", visible: false, searchable: false, sortable: false },
              { data: null, searchable: false, sortable: false,
								"render": function(data, type, row, meta) {
                  data = '<a class="editbtn text-warning"><i class="far fa-edit"></i></a>&nbsp;';
                  data += '<a class="deletebtn text-danger"><i class="far fa-trash-alt"></i></a>';
                  return data;
                }
              }
          ]
      } );

      $("div.search_bar").html('<input class="search_fld form-control form-control-sm" id="search_bar" />');
      $("div.search_btn").html('<button id="search_btn" class="search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span id="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

			if('<?php echo $_SESSION['superadmin_rights']; ?>' == 'yes')
			{
				$("div.region_slct").html($("div#regionSelectionDiv").html());
			}

			$("#search_btn").on('click', function () {
				table.settings()[0].jqXHR.abort()
				table.search($("#search_bar").val()).draw();
				$('#search_spinner').show();
				$(".search_fld").prop('disabled', true);
			});

			table.on( 'draw', function () {
				$('#search_spinner').hide();
				$(".search_fld").prop('disabled', false);
			} );

			$('#regionSelect').change(function() {
        tableData.selected_region = $(this).val();
				table.draw();
			} );

      // ###############################  ADD CHILD SCRIPT  ############################################# //
      $('div#addChildrenModal button[name="save"]').click(function() {
          let childGroup = $('fieldset#addChildrenFieldset');
					let childName = childGroup.find('input[name="name"]').val();
					let childBirthDate = childGroup.find('input[name="date_of_birth"]').val();

          var request = $.ajax({
             url: "<?=base_url('Admin/Pds/Form_Data/pds_children')?>",
             method: 'POST',
             data: { name : childName, date_of_birth: childBirthDate },
             beforeSend: function(jqXHR, settings){
		           childGroup.find('input').attr('disabled','disabled');
		           childGroup.find('button').html('loading..').attr('disabled','disabled');
             }
          });

          request.done(function(data) {
            table.draw();
            $('#search_spinner').show();
            $(".search_fld").prop('disabled', true);

            childGroup.find('input').val('').attr('disabled', false);
            childGroup.find('button').html('Save').attr('disabled', false);

            $('#addChildrenModal').modal('hide');
      		});

      		request.fail(function(jqXHR, textStatus) {
      		  alert( "Request failed: " + textStatus );
            childGroup.find('input').attr('disabled','');
            childGroup.find('button').html('loading..').attr('disabled','');
      		});
      });

	    $('#dataTable tbody').on( 'click', 'a.editbtn', function () {
  				 var data = table.row( $(this).parents('tr') ).data();
           let editModal = $('#editChildrenModal');

           editModal.modal('show');
           editModal.find('fieldset input[name="id"]').val(data['id']);
           editModal.find('fieldset input[name="name"]').val(data['name']);
           editModal.find('fieldset input[name="date_of_birth"]').val(data['date_of_birth']);
  		} );

	    $('#dataTable tbody').on( 'click', 'a.deletebtn', function () {
  				 var data = table.row( $(this).parents('tr') ).data();
           let confirmDelete = window.confirm("Confirm Deletion?");
           console.log(confirmDelete);

           let editModal = $('#editChildrenModal');

           if(confirmDelete) {
             var request = $.ajax({
                url: "<?=base_url('Admin/Pds/Form_Data/delete_pds_children')?>",
                method: 'POST',
                data: { id : data['id'] },
                beforeSend: function(jqXHR, settings) {
                  $('#dataTable tbody').find('button[type="button"]').attr('disabled','disabled');
                }
             });

             request.done(function(data) {
               table.draw();
               $('#dataTable tbody').find('button[type="button"]').attr('disabled',false);
             });

             request.fail(function(jqXHR, textStatus) {
               alert( "Request failed: " + textStatus );
               $('#dataTable tbody').find('button[type="button"]').attr('disabled',false);
             });
           }
  		} );

      $('div#editChildrenModal button[name="edit"]').click(function() {
          let editModal = $('#editChildrenModal');
          var request = $.ajax({
             url: "<?=base_url('Admin/Pds/Form_Data/update_pds_children')?>",
             method: 'POST',
             data: { id : editModal.find('fieldset input[name="id"]').val(), name : editModal.find('fieldset input[name="name"]').val(), date_of_birth: editModal.find('fieldset input[name="date_of_birth"]').val() },
             beforeSend: function(jqXHR, settings){
               editModal.find('input').attr('disabled','disabled');
               editModal.find('button').html('loading..').attr('disabled','disabled');
             }
          });

          request.done(function(data) {
            table.draw();
            $('#search_spinner').show();
            $(".search_fld").prop('disabled', true);

            editModal.find('input').val('').attr('disabled', false);
            editModal.find('button').html('Save').attr('disabled', false);

            $('#editChildrenModal').modal('hide');
          });

          request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
            editModal.find('input').attr('disabled','');
            editModal.find('button').html('loading..').attr('disabled','');
          });
      });

  });
</script>
