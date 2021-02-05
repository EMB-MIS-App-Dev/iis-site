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
  <div class="modal fade" id="addReferenceModal" role="dialog" >
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="useraccountsModalLabel">Add Reference</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <fieldset id="addReferenceFieldset">
                  <div class="modal-body">
                        <div id="edit_details_body">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" class="form-control form-control-sm" name="name" />
                                </div>
                                <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" class="form-control form-control-sm" name="address" />
                                </div>
                                <div class="form-group">
                                  <label>Tel. No.</label>
                                  <input type="text" class="form-control form-control-sm" name="tel_no" />
                                </div>
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-sm">Save</button>
                  </div>
              </fieldset>
          </div>
      </div>
  </div>

  <div class="col-md-12">
        <div class="card shadow">
              <div class="card-body">
                  <?=form_open_multipart('Admin/Pds/Main/submit3')?>
                      <fieldset>
                          <legend>Affinities, Charges, and Social Status</legend>
                          <hr />
                          <div class="row no-gutters align-items-center justify-content-md-center">
                              <div class="col-md-10 mr-2">
                                  <hr />
                                  <label>Affinities and Charges</label>
                                  <hr />
                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,</label>
                                          <div class="col-md-12">
                                              <label>a. within the third degree?</label>
                                              <div class="row px-4">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="with_third_degree_affinity" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="with_third_degree_affinity" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>b. within the fourth degree (for Local Government Unit - Career Employees)?</label>
                                              <div class="row px-4">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="with_fourth_degree_affinity" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="with_fourth_degree_affinity" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>with <b>Yes</b> on either <b>A</b> or <b>B</b>, give details:</label>
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <textarea class="form-control" name="affinities"></textarea>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <hr />

                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>a. Have you ever been found guilty of any administrative offense?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="with_administrative_offense" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="with_administrative_offense" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details:</label>
                                              <textarea class="form-control" name="administrative_offense"></textarea>
                                          </div>
                                      </div>

                                      <div class="col-md-12 pb-4">
                                          <label>b. Have you been criminally charged before any court?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_criminally_charged" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_criminally_charged" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details:</label>
                                              <div class="row col-md-12">
                                                  <div class="col-md-2 pb-2">
                                                      <label>Date Filed:</label>
                                                  </div>
                                                  <div class="col">
                                                      <input class="form-control form-control-sm mx-4" name="date_filed" />
                                                  </div>
                                              </div>
                                              <div class="row col-md-12">
                                                  <div class="col-md-2">
                                                      <label>Status of Case/s:</label>
                                                  </div>
                                                  <div class="col">
                                                      <input class="form-control form-control-sm mx-4" name="status_of_case" />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <hr />

                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_convicted" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_convicted" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details:</label>
                                              <textarea class="form-control" name="conviction_details"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <hr />

                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="was_separated_from_service" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="was_separated_from_service" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details:</label>
                                              <textarea class="form-control" name="separated_from_service"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <hr />

                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_candidate" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_candidate" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details:</label>
                                              <textarea class="form-control" name="candidate_details"></textarea>
                                          </div>
                                      </div>

                                      <div class="col-md-12 pb-4">
                                          <label>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="has_resigned_from_government" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="has_resigned_from_government" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details:</label>
                                              <textarea class="form-control" name="resigned_government"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <hr />

                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>Have you acquired the status of an immigrant or permanent resident of another country?</label>
                                          <div class="col-md-12 pb-2">
                                              <div class="row">
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_immigrant" value="Y"/> Yes
                                                  </div>
                                                  <div class="col-md-1">
                                                      <input type="radio" name="is_immigrant" value="N" checked/> No
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>If <b>Yes</b>, give details (country):</label>
                                              <textarea class="form-control" name="immigrant_country"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <hr />

                                  <div class="row">
                                      <div class="col-md-12 pb-4">
                                          <label>Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</label>
                                          <div class="col-md-12 pb-4">
                                              <label>a. Are you a member of any indigenous group?</label>
                                              <div class="col-md-12 pb-2">
                                                  <div class="row">
                                                      <div class="col-md-1">
                                                          <input type="radio" name="is_indigenous" value="Y"/> Yes
                                                      </div>
                                                      <div class="col-md-1">
                                                          <input type="radio" name="is_indigenous" value="N" checked/> No
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <label>If <b>Yes</b>, please specify:</label>
                                                  <textarea class="form-control" name="indigenous_details"></textarea>
                                              </div>
                                          </div>
                                          <div class="col-md-12 pb-4">
                                              <label>b. Are you a person with disability?</label>
                                              <div class="col-md-12 pb-2">
                                                  <div class="row">
                                                      <div class="col-md-1">
                                                          <input type="radio" name="is_disabled" value="Y"/> Yes
                                                      </div>
                                                      <div class="col-md-1">
                                                          <input type="radio" name="is_disabled" value="N" checked/> No
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <label>If <b>Yes</b>, please specify ID no:</label>
                                                  <textarea class="form-control" name="disability_id"></textarea>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <label>c. Are you a solo parent?</label>
                                              <div class="col-md-12 pb-2">
                                                  <div class="row">
                                                      <div class="col-md-1">
                                                          <input type="radio" name="is_solo_parent" value="Y"/> Yes
                                                      </div>
                                                      <div class="col-md-1">
                                                          <input type="radio" name="is_solo_parent" value="N" checked/> No
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <label>If <b>Yes</b>, please specify ID no:</label>
                                                  <textarea class="form-control" name="solo_parent_id"></textarea>
                                              </div>
                                          </div>

                                      </div>
                                  </div>

                                  <!-- ########################## Voluntary Work TABLE ################################### -->
                                  <hr />
                                  <label>References</label>
                                  <hr />
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addReferenceModal"><i class="fas fa-plus-circle"></i> Add Row Data</button>
                                  <br /><br />
                                  <div class="row">
                                      <div class="table-responsive">
                                          <table id="dataTable" class="table table-hover" width="100%">
                                              <thead style="text-align: center">
                                                  <tr>
                                                    <th>id</th>
                                                    <th>userid</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Tel. No.</th>
                                                  </tr>
                                              </thead>
                                          </table>
                                      </div>
                                  </div> <br />

                                  <!-- ########################## Voluntary Work TABLE ################################### -->
                                  <hr />
                                  <label>Government Issued ID, and Confirmation of Details</label>
                                  <hr />
                                  <div class="row justify-content-md-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Government Issued ID:</label>
                                            <input class="form-control form-control-sm" type="text" name="government_id" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ID / License / Passport No.</label>
                                            <input class="form-control form-control-sm" type="text" name="secondary_id" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date / Place of Issuance</label>
                                            <input class="form-control form-control-sm" type="text" name="date_place_of_issuance" />
                                        </div>
                                    </div>
                                  </div> <br />

                                  <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="pds_truth_declaration" name="truth_declaration">
                                      <label class="custom-control-label" for="pds_truth_declaration">I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein. I agree that any misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal case/s against me.</label>
                                  </div>

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
              "url": "<?php echo base_url('Admin/Pds/Table_Data/pds_person_references'); ?>",
              "type": 'POST',
              // "data": function ( d ) {
              //           return  $.extend(d, tableData);
              //         },
          },
          columns: [
              { data: "id", "searchable": false, "visible": false },
              { data: "userid", "searchable": false, "visible": false },
              { data: "name" },
              { data: "address" },
              { data: "tel_no" },
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
      let fieldGroup = $('fieldset#addReferenceFieldset');
      $('div#addReferenceModal button[type="button"]').click(function() {
					let name = fieldGroup.find('input[name="name"]').val();
					let address = fieldGroup.find('input[name="address"]').val();
					let telNo = fieldGroup.find('input[name="tel_no"]').val();

          var request = $.ajax({
             url: "<?=base_url('Admin/Pds/Form_Data/pds_person_references')?>",
             method: 'POST',
             data: { name : name, address: address, tel_no: telNo },
             beforeSend: function(jqXHR, settings){
		           fieldGroup.find('input').attr('disabled','disabled');
		           fieldGroup.find('button').html('loading..').attr('disabled','disabled');
             }
          });

          request.done(function(data) {
            table.draw();
            $('#search_spinner').show();
            $(".search_fld").prop('disabled', true);

            fieldGroup.find('input').val('').attr('disabled', false);
            fieldGroup.find('button').html('Save').attr('disabled', false);

            $('#addReferenceModal').modal('hide');
      		});

      		request.fail(function(jqXHR, textStatus) {
      		  alert( "Request failed: " + textStatus );
            fieldGroup.find('input').attr('disabled','');
            fieldGroup.find('button').html('loading..').attr('disabled','');
      		});
      });

  });
</script>
