    <link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://js.arcgis.com/4.16/esri/themes/light/main.css">

    <style type="text/css">
      .table-outer th, td { white-space: nowrap; }
      .table-outer div.dataTables_wrapper {
          margin: 0 auto;
      }
      #header-lgu {
          padding: 5px 5px 0px 5px;
          margin: 5px 0px 0px 0px;
          background-color: #08507E;
          /*border-top-left-radius: 3px;
          border-top-right-radius: 3px;*/
      }
      label#header-lgu-label {
          color: #FFF;
      }
      label.total_reports {
          float: right;
          margin: 6px 2px 0px 0px;
          color: #FFF;
          font-size: 8pt;
      }
      #::-webkit-scrollbar-track
      {
          -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
          background-color: #F2F2F2;
      }

      ::-webkit-scrollbar
      {
          width: 5px;
          height: 10px;
          background-color: #F2F2F2;
      }

      ::-webkit-scrollbar-thumb
      {
          background-color: #08507E;
          border: 1px solid #08507E;
      }

      .iisno{
        font-weight: bold;
        overflow: hidden !important;
      }

      .DTFC_LeftBodyLiner{
        overflow: hidden !important;
        font-weight: bold;
      }
      .DTFC_RightBodyLiner{
        overflow: hidden !important;
        font-weight: bold;
      }
    </style>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12 col-lg-12" id="chklgufeedbacks_"></div>
        <!-- DATATABLES Card -->
        <div class="col-xl-12 col-lg-12">
          <div class="trans-layout card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #FFF;">

              <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-book"></i> SWEET-ENMO REPORTS</h6>
              <div class="col-md-6" style="text-align: center; padding-right: 0px;">
                <?php if($_SESSION['sw_selectswemployee'] == 'yes'){ ?>
                <a href="#" data-toggle='modal' style="float:right;" data-target='#sw_confirmation_message' class="btn btn-success btn-sm"><i class="fas fa-file"></i>&nbsp;Create SWEET-ENMO Report</a>
                <a href="#" data-toggle='modal' style="float:right;margin-right:5px;font-size:8pt;" data-target='#createdraftnov' class="btn btn-danger btn-sm"><i class="fas fa-file"></i>&nbsp;Create NOV Letter</a>
                <?php }if($_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes'){ ?>
                <a href="#" data-toggle='modal' style="float:right; margin-right: 5px;font-size: 8pt;" data-target='#sw_settings' class="btn btn-secondary btn-sm">SWEET-ENMO SETTINGS</a>
                <?php } ?>
              </div>
            </div>

            <!-- EVALUATOR VIEW -->
            <?php if($_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['func'] == 'Regional Director'){ ?>
              <!-- Card Body -->
              <div class="card-body" style="padding: 0px 0px 0px 0px; background-color: #F0F1F4;">
                <?php if($_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['func'] == 'Regional Director'){ ?>

                  <div class="col-md-12" id="header-lgu" style="background-color: #E74A3B !important;">
                    <label id="header-lgu-label">NOV FOR APPROVAL</label>
                  </div>
                  <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                    <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                      <table id="inbox_sweet_nov_forapproval" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th> </th>
                            <th> IIS No. </th>
                            <th style="min-width: 100px;"> IIS No. </th>
                            <th> Report Number </th>
                            <th> Casehandler </th>
                            <th> Date Created </th>
                            <th> Addressed to </th>
                            <th> Designation </th>
                            <th> Subject </th>
                            <th> Date Patrolled </th>
                            <th> LGU Patrolled </th>
                            <th> Barangay </th>
                            <th> Assigned </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <?php if(!empty($check_for_action)){ ?>
                      <div class="col-md-12" id="header-lgu" style="background-color: #08507E !important;">
                        <label id="header-lgu-label">REPORT FOR EVALUATION</label>
                      </div>
                      <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                        <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                          <table id="inbox_sweet_report_evaluator" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>  </th>
                                <th style="min-width: 100px;"> IIS No. </th>
                                <th> IIS No. </th>
                                <th> Casehandler </th>
                                <th> Type of Report </th>
                                <th> Date Created </th>
                                <th> Subject </th>
                                <th> Date Patrolled </th>
                                <th> LGU Patrolled </th>
                                <th> Barangay </th>
                                <th> Violations Observed </th>
                                <th> Est. Area (sq. m.) </th>
                                <th> Type of Monitoring </th>
                                <th> Actions to be undertaken </th>
                                <th> Assigned </th>
                                <th> Status </th>
                                <th> Status </th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    <?php } ?>
                <?php } ?>

                <script type="text/javascript">

                  $(document).ready(function(){

                    <?php if($_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['func'] == 'Regional Director'){ ?>

                      var tablesearch = $('#inbox_sweet_report_evaluator').DataTable({
                            responsive: true,
                            paging: true,
                            language: {
              						    infoFiltered: "",
              								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
              						  },
                            processing: true,
                            "serverSide": true,
                            ajax: {
                                "url": "<?php echo base_url(); ?>Swm/Sweet_serverside",
                                "type": 'POST',
                                "data": { evaluator : <?php echo $this->session->userdata('userid'); ?>  },
                            },
                            // "order": [[ 3, "asc", 4, "asc"]],
                            "columnDefs": [
                              { className:"iisno","targets":[1] },
                            ],
                            scrollX: true,
                            fixedColumns:   {
                                leftColumns: 2,
                                rightColumns: 3
                            },
                            "order": [[ 6, "asc" ]],
                            "columns": [
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                      data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[1]+"&rn="+row[19]+"' target='_blank'><span class='fa fa-file'></span></a>";
                                      data += "&nbsp;<a title='View Report History - Report No: "+row['report_number']+"' href='#' onclick=view_sw_history('"+row[1]+"'); class='btn btn-info btn-sm' data-toggle='modal' data-target='#view_sw_history'><span class='fa fa-clipboard'></span> History</a>";
                                      // data += "&nbsp;<a href='#' onclick=swedit_report('"+row[1]+"'); data-toggle='modal' data-target='#edit_report' title='Edit Report' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></a>";
                                      data += "&nbsp;<a href='#' style='font-size:10pt!important;' id='sweet_process_btn'  data-toggle='modal' data-target='#process_sweetreport' title='Evaluate Report' class='btn btn-success btn-sm'><span class='fa fa-check'></span> Evaluate</a>";
                                      return data;
                                  }
                              },
                              { "data": "trans_no","searchable": true},
                              { "data": 1,"visible": false},
                              { "data": "creator_name","searchable": true},
                              { "data": "report_type","searchable": true},
                              { "data": "date_created","searchable": true},
                              { "data": "subject","searchable": true},
                              { "data": "date_patrolled","searchable": true},
                              { "data": "lgu_patrolled_name","searchable": true},
                              { "data": "barangay_name","searchable": true},
                              { "data": "violations_observed_desc","searchable": true},
                              { "data": "total_land_area","searchable": true},
                              { "data": "type_of_monitoring_desc","searchable": true},
                              { "data": "actions_undertaken_desc","searchable": true},
                              { "data": "assigned_name","searchable": true},
                              { "data": 'status',"searchable": true,"visible":false},
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                    if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                                    }else if(row['status'] == 'On-Process'){
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                                    }else{
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                                    }
                                    return data;
                                  }
                              },
                            ]

                      });

                      var searchdata = '<?php echo (!empty($_GET['search'])) ? $_GET['search'] : ''; ?>';
                      if(searchdata){
                        tablesearch.search(searchdata).draw();
                      }

                      $('#inbox_sweet_report_evaluator tbody').on( 'click', '#sweet_process_btn', function () {
                          var data = tablesearch.row( $(this).parents('tr') ).data();
                          $.ajax({
                             url:  '<?php echo base_url(); ?>Swm/Sweet_ajax/process_details',
                             method: 'POST',
                             data: { trans_no : data['trans_no'], rn : data[19] },
                             success: function(response) {
                               $("#process_sweetreport_modal").html(response);
                             }
                          });
                      } );


                          var tablenov = $('#inbox_sweet_nov_forapproval').DataTable({
                                responsive: true,
                                paging: true,
                                language: {
                  						    infoFiltered: "",
                  								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
                  						  },
                                processing: true,
                                "serverSide": true,
                                ajax: {
                                    "url": "<?php echo base_url(); ?>Swm/Sweet_serverside/novforapproval",
                                    "type": 'POST',
                                    "data": { region : "<?= $this->session->userdata('region'); ?>" },
                                },
                                // "order": [[ 3, "asc", 4, "asc"]],
                                "columnDefs": [
                                  { className:"iisno","targets":[2] },
                                ],
                                scrollX: true,
                                fixedColumns:   {
                                    leftColumns: 3,
                                    rightColumns: 2
                                },
                                // "order": [[ 6, "asc" ]],
                                "columns": [
                                  {
                                    "data": null,
                                      "render": function(data, type, row, meta){
                                          data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[0]+"&rn="+row['report_number']+"' target='_blank'><span class='fa fa-file'></span></a>";
                                          data += "&nbsp;<a href='#' style='font-size:10pt!important;' id='process_swmnovletter_btn'  data-toggle='modal' data-target='#process_swmnovletter' title='Evaluate NOV letter' class='btn btn-success btn-sm'><span class='fa fa-check'></span> Evaluate</a>";
                                          return data;
                                      }
                                  },
                                  { "data": 0,"visible": false},
                                  { "data": 1,"searchable": true},
                                  { "data": "report_number","visible": false},
                                  { "data": "name","searchable": true},
                                  { "data": "date_created","searchable": true},
                                  { "data": "address_to","searchable": true},
                                  { "data": "designation","searchable": true},
                                  { "data": "subject","searchable": true},
                                  { "data": "date_patrolled","searchable": true},
                                  { "data": "lgu_patrolled_name","searchable": true},
                                  { "data": "barangay_name","searchable": true},
                                  { "data": "assigned_name","searchable": true},
                                  {
                                    "data": null,
                                      "render": function(data, type, row, meta){
                                        if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                                          data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                                        }else if(row['status'] == 'On-Process'){
                                          data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                                        }else{
                                          data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                                        }
                                        return data;
                                      }
                                  },

                                ]
                          });

                          var searchdatanov = '<?php echo (!empty($_GET['searchnov'])) ? $_GET['searchnov'] : ''; ?>';
                          if(searchdatanov){
                            tablenov.search(searchdatanov).draw();
                          }

                          $('#inbox_sweet_nov_forapproval tbody').on( 'click', '#process_swmnovletter_btn', function () {
                              var data = tablenov.row( $(this).parents('tr') ).data();
                              $.ajax({
                                 url:  '<?php echo base_url(); ?>Swm/Sweet_ajax/procesnovletter',
                                 method: 'POST',
                                 data: { trans_no : data[0], report_number : data['report_number'], cnt : data['cnt'] },
                                 success: function(response) {
                                   $("#process_swmnovletter_modal").html(response);
                                 }
                              });
                          } );

                    <?php } ?>
                  });
                </script>
              </div>
              <div class="card-body" style="padding: 0px 0px 0px 0px; background-color: #F0F1F4;">
                <?php if($_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['func'] == 'Regional Director'){ ?>

                  <div class="col-md-12" id="header-lgu" style="background-color: #08507E !important;">
                    <label id="header-lgu-label">ALL NOTICE OF VIOLATION</label>
                  </div>
                  <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                    <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                      <table id="inbox_sweet_nov_tbl" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th> </th>
                            <th> IIS No. </th>
                            <th style="min-width: 100px;"> IIS No. </th>
                            <th> Report Number </th>
                            <th> cnt </th>
                            <th> Casehandler </th>
                            <th> Date Created </th>
                            <th> Addressed to </th>
                            <th> Designation </th>
                            <th> Subject </th>
                            <th> Date Patrolled </th>
                            <th> LGU Patrolled </th>
                            <th> Barangay </th>
                            <th> Assigned </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                  <div class="col-md-12" id="header-lgu" style="background-color: #08507E !important;">
                    <label id="header-lgu-label">
                      <?php
                        if(!empty($_GET['ch'])){
                          $wherech  = $this->db->where('sf.userid = "'.$this->encrypt->decode($_GET['ch']).'" GROUP BY sf.userid');
                          $selectch = $this->Embismodel->selectdata('sweet_form AS sf','sf.creator_name','',$wherech);
                          if($this->encrypt->decode($_GET['ch']) == 'All'){
                            $filtered_name = "ALL CASEHANDLER";
                          }else{
                            $filtered_name = strtoupper($selectch[0]['creator_name']);
                          }
                          $filtered = "ALL SWEET-ENMO REPORT - <i>filtered by</i> CASEHANDLER NAME: ".$filtered_name;
                        }else if(!empty($_GET['lgu'])){
                          $wherelgu  = $this->db->where('dc.emb_id = "'.$this->encrypt->decode($_GET['lgu']).'"');
                          $selectlgu = $this->Embismodel->selectdata('dms_company AS dc','dc.company_name','',$wherelgu);
                          if($this->encrypt->decode($_GET['lgu']) == 'All'){
                            $filtered_name = "ALL LGU";
                          }else{
                            $filtered_name = strtoupper($selectlgu[0]['company_name']);
                          }
                          $filtered = "ALL SWEET-ENMO REPORTS - <i>filtered by</i> LGU NAME: ".$filtered_name;
                        }else{
                          $filtered = "ALL SWEET-ENMO REPORTS";
                        }
                        echo $filtered;
                      ?>
                    </label>
                    <button type="button" class="btn btn-secondary btn-sm" data-toggle='modal' data-target='#filter_table_sw' style="float: right;">FILTER TABLE</button>
                    <button type="button" class="btn btn-success btn-sm" data-toggle='modal' data-target='#exportdata' style="float: right;margin-right:5px;">EXPORT TO EXCEL</button>
                    <a href="<?php echo base_url().'Swm/Sweet/Sweetmap'; ?>" target="_blank" style="float:right; margin-right: 5px;font-size: 8pt;" class="btn btn-info btn-sm"><span class="fa fa-map-marker"></span>&nbsp;MAP VIEW</a>
                  </div>

                  <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                    <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                      <table id="inbox_sweet_report_signed" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>  </th>
                            <th>  </th>
                            <th>  </th>
                            <th style="min-width: 100px;"> IIS No. </th>
                            <th> IIS No. </th>
                            <th> Casehandler </th>
                            <th> Type of Report </th>
                            <th> Date Created </th>
                            <th> Subject </th>
                            <th> Date Patrolled </th>
                            <th> LGU Patrolled </th>
                            <th> Barangay </th>
                            <th> Violations Observed </th>
                            <th> Est. Area (sq. m.) </th>
                            <th> Type of Monitoring </th>
                            <th> Actions to be undertaken </th>
                            <th> Assigned </th>
                            <th> Status </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                  <script type="text/javascript">
                    $(document).ready(function(){
                      var useriddata = '<?php echo $_SESSION['userid']; ?>';

                      var superadmin_rights = '<?php echo $superadmin_rights = (!empty($_SESSION['superadmin_rights']) ? $_SESSION['superadmin_rights']: 'no'); ?>';

                      var tablenovtbl = $('#inbox_sweet_nov_tbl').DataTable({
                        responsive: true,
                            paging: true,
                            language: {
              						    infoFiltered: "",
              								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
              						  },
                            processing: true,
                            "serverSide": true,
                            ajax: {
                                "url": "<?php echo base_url(); ?>Swm/Sweet_serverside/nov",
                                "type": 'POST',
                                "data": { region : "<?= $this->session->userdata('region'); ?>" },
                            },
                            // "order": [[ 3, "asc", 4, "asc"]],
                            "columnDefs": [
                              { className:"iisno","targets":[2] },
                            ],
                            scrollX: true,
                            fixedColumns:   {
                              leftColumns: 3,
                              rightColumns: 2
                            },
                            // "order": [[ 6, "asc" ]],
                            "columns": [
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                      data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[0]+"&rn="+row[2]+"' target='_blank'><span class='fa fa-file'></span></a>";
                                      data += "&nbsp;<a title='View NOV letter' class='btn btn-danger btn-sm' href='Letter/pdf/"+row[3]+"' target='_blank'>NOV Letter</a>";
                                      if(row['status'] == 'Returned' && row['assigned_to'] == useriddata){
                                        data += "&nbsp;<a href='#' onclick=editnovltr('"+row[0]+"','"+row[2]+"'); data-toggle='modal' data-target='#edit_nov_letter' title='Edit NOV Letter' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></a>";
                                      }
                                      if(superadmin_rights == 'yes'){
                                        data += "&nbsp;<a href='#' data-toggle='modal' onclick=removenov('"+row['cnt']+"'); data-target='#removenov' class='btn btn-danger btn-sm'>Remove</a>";
                                      }
                                      return data;
                                  }
                              },
                              { "data": 0,"visible": false},
                              { "data": 1,"searchable": true},
                              { "data": 2,"visible": false},
                              { "data": 3,"visible": false},
                              { "data": "name","searchable": true},
                              { "data": "date_created","searchable": true},
                              { "data": "address_to","searchable": true},
                              { "data": "designation","searchable": true},
                              { "data": "subject","searchable": true},
                              { "data": "date_patrolled","searchable": true},
                              { "data": "lgu_patrolled_name","searchable": true},
                              { "data": "barangay_name","searchable": true},
                              { "data": "assigned_name","searchable": true},
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                    if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                                    }else if(row['status'] == 'On-Process'){
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                                    }else{
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                                    }
                                    return data;
                                  }
                              },

                            ]
                      });
                    });
                  </script>
                <?php
                  }
                  $lguget = !empty($_GET['lgu']) ? "'".$_GET['lgu']."'" : "''";
                  $chget  = !empty($_GET['ch']) ? "'".$_GET['ch']."'" : "''";
                  if($chget == "''" && $lguget == "''"){
                    $default = "'default'";
                  }else{
                    $default = "''";
                  }
                ?>

                <script type="text/javascript">
                  $(document).ready(function(){
                    <?php if($_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['func'] == 'Regional Director'){ ?>
                      var table = $('#inbox_sweet_report_signed').DataTable({
                            responsive: true,
                            paging: true,
                            language: {
              						    infoFiltered: "",
              								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
              						  },
                            processing: true,
                            "serverSide": true,
                            ajax: {
                                "url": "<?php echo base_url(); ?>Swm/Sweet_serverside",
                                "type": 'POST',
                                "data": { evaluator : <?php echo $this->session->userdata('userid'); ?>, ch : <?php echo $chget; ?>, lgu : <?php echo $lguget; ?>, df : <?php echo $default; ?>},
                            },
                            // "order": [[ 3, "asc", 4, "asc"]],
                            "columnDefs": [
                              { className:"iisno","targets":[1] },
                            ],
                            scrollX: true,
                            fixedColumns:   {
                                leftColumns: 2,
                                rightColumns: 3
                            },
                            "order": [[ 6, "asc" ]],
                            "columns": [
                              { "data": "feedback","visible": false},
                              { "data": "feedback_seen","visible": false},
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                      data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[1]+"&rn="+row[19]+"' target='_blank'><span class='fa fa-file'></span></a>";
                                      data += "&nbsp;<a title='View Report History - Report No: "+row['report_number']+"' href='#' onclick=view_sw_history('"+row[1]+"'); class='btn btn-info btn-sm' data-toggle='modal' data-target='#view_sw_history'><span class='fa fa-clipboard'></span> History</a>";
                                      // data += "&nbsp;<a href='#' onclick=swedit_report('"+row[1]+"'); data-toggle='modal' data-target='#edit_report' title='Edit Report' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></a>";
                                      // data += "&nbsp;<a href='#' style='font-size:10pt!important;' id='sweet_process_btn'  data-toggle='modal' data-target='#process_sweetreport' title='Evaluate Report' class='btn btn-success btn-sm'><span class='fa fa-check'></span> Evaluate</a>";
                                      data += "&nbsp;<a title='View Map Location' href='../Swm/Sweet/Sweetmap?token="+row[1]+"' target='_blank' class='btn btn-info btn-sm'><span class='fa fa-map-marker'></span></a>";
                                      if((row['feedback_seen'] == '' || row['feedback_seen'] == null) && row['feedback'] > 0){
                                        data += "&nbsp;<a href='#' onclick=lgufeedbackbtn('"+row[1]+"'); data-toggle='modal' data-target='#lgufeedbackmodal' title='LGU Feedbacks' class='btn btn-primary btn-sm'><span class='fa fa-envelope'></span><b>&nbsp;"+row['feedback']+"</b></a>";
                                      }
                                      return data;
                                  }
                              },
                              { "data": "trans_no","searchable": true},
                              { "data": 1,"visible": false},
                              { "data": "creator_name","searchable": true},
                              { "data": "report_type","searchable": true},
                              { "data": "date_created","searchable": true},
                              { "data": "subject","searchable": true},
                              { "data": "date_patrolled","searchable": true},
                              { "data": "lgu_patrolled_name","searchable": true},
                              { "data": "barangay_name","searchable": true},
                              { "data": "violations_observed_desc","searchable": true},
                              { "data": "total_land_area","searchable": true},
                              { "data": "type_of_monitoring_desc","searchable": true},
                              { "data": "actions_undertaken_desc","searchable": true},
                              { "data": "assigned_name","searchable": true},
                              { "data": 'status',"searchable": true,"visible":false},
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                    if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                                    }else if(row['status'] == 'On-Process'){
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                                    }else{
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                                    }
                                    return data;
                                  }
                              },
                            ]

                      });
                    <?php } ?>
                  });
                </script>
              </div>
              <!-- Card Body -->
            <!-- EVALUATOR VIEW -->
            <?php }if($_SESSION['sw_selectswemployee'] == 'yes'){ ?>
            <!-- SWEET OFFICER VIEW -->
              <!-- Card Body -->
              <div class="card-body" style="padding: 0px 0px 0px 0px; background-color: #F0F1F4;">
                <?php if(!empty($check_for_action)){ ?>
                  <div class="col-md-12" id="header-lgu" style="background-color: #E74A3B !important;">
                    <label id="header-lgu-label">RETURNED REPORT</label>
                  </div>
                  <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                    <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                      <table id="inbox_sweet_report_returned" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>  </th>
                            <th style="min-width: 100px;"> IIS No. </th>
                            <th> IIS No. </th>
                            <th> Casehandler </th>
                            <th> Type of Report </th>
                            <th> Date Created </th>
                            <th> Subject </th>
                            <th> Date Patrolled </th>
                            <th> LGU Patrolled </th>
                            <th> Barangay </th>
                            <th> Violations Observed </th>
                            <th> Est. Area (sq. m.) </th>
                            <th> Type of Monitoring </th>
                            <th> Actions to be undertaken </th>
                            <th> Status </th>
                            <th> Assigned </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                <?php } ?>

                <div class="col-md-12" id="header-lgu" style="background-color: #E74A3B !important;">
                  <label id="header-lgu-label">NOTICE OF VIOLATION</label>
                </div>
                <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                  <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                    <table id="inbox_sweet_nov" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th> </th>
                          <th> IIS No. </th>
                          <th style="min-width: 100px;"> IIS No. </th>
                          <th> Report Number </th>
                          <th> Report Number </th>
                          <th> Casehandler </th>
                          <th> Date Created </th>
                          <th> Addressed to </th>
                          <th> Designation </th>
                          <th> Subject </th>
                          <th> Date Patrolled </th>
                          <th> LGU Patrolled </th>
                          <th> Barangay </th>
                          <th> Assigned </th>
                          <th> Status </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

              <?php for ($lgu=0; $lgu < sizeof($lgu_patrolled); $lgu++) { ?>
                  <div class="col-md-12" id="header-lgu">
                    <label id="header-lgu-label"><?php echo strtoupper($lgu_patrolled[$lgu]['lgu_patrolled_name']); ?></label>

                    <?php
                      for ($ttl=0; $ttl < sizeof($total_reports); $ttl++) {
                        $total = ($total_reports[$ttl]['lgu_patrolled_name'] == $lgu_patrolled[$lgu]['lgu_patrolled_name']) ?
                        '<label class="total_reports">TOTAL REPORTS: '.$total_reports[$ttl]['total_reports'].'</label>' : "";
                    ?>
                      <?= $total; ?>
                    <?php } ?>

                    <?php
                      for ($ttl=0; $ttl < sizeof($total_reports_rm); $ttl++) {
                        $totalrm = ($total_reports_rm[$ttl]['lgu_patrolled_name'] == $lgu_patrolled[$lgu]['lgu_patrolled_name']) ?
                        '<label class="total_reports">RM: '.$total_reports_rm[$ttl]['total_reports'].'&nbsp;|</label>' : "";
                    ?>
                      <?= $totalrm; ?>
                    <?php } ?>

                    <?php
                      for ($ttl=0; $ttl < sizeof($total_reports_va); $ttl++) {
                        $totalva = ($total_reports_va[$ttl]['lgu_patrolled_name'] == $lgu_patrolled[$lgu]['lgu_patrolled_name']) ?
                        '<label class="total_reports">VA: '.$total_reports_va[$ttl]['total_reports'].'&nbsp;|</label>' : "";
                    ?>
                      <?= $totalva; ?>
                    <?php } ?>

                    <?php
                      for ($ttl=0; $ttl < sizeof($total_reports_van); $ttl++) {
                        $totalvan = ($total_reports_van[$ttl]['lgu_patrolled_name'] == $lgu_patrolled[$lgu]['lgu_patrolled_name']) ?
                        '<label class="total_reports">VA W/ NOV: '.$total_reports_van[$ttl]['total_reports'].'&nbsp;|</label>' : "";
                    ?>
                      <?= $totalvan; ?>
                    <?php } ?>
                  </div>

                  <div id="outer-div" style="border: 1px solid #E3E6F0; padding: 10px 0px 10px 0px; background-color: #FFF; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; margin-bottom: 10px;">
                    <div class="table-responsive" style="zoom:70%;padding: 0px 10px 0px 10px;">
                      <table id="inbox_sweet_report<?= $lgu; ?>" class="table table-hover table-striped table-outer" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>  </th>
                            <th>  </th>
                            <th>  </th>
                            <th>  </th>
                            <th style="min-width: 100px;"> IIS No. </th>
                            <th> IIS No. </th>
                            <th> Casehandler </th>
                            <th> Type of Report </th>
                            <th> Date Created </th>
                            <th> Subject </th>
                            <th> Date Patrolled </th>
                            <th> LGU Patrolled </th>
                            <th> Barangay </th>
                            <th> Violations Observed </th>
                            <th> Est. Area (sq. m.) </th>
                            <th> Type of Monitoring </th>
                            <th> Actions to be undertaken </th>
                            <th> Assigned </th>
                            <th> Status </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <script type="text/javascript">
                      var table = $('#inbox_sweet_report<?= $lgu; ?>').DataTable({
                          responsive: true,
                          paging: true,
                          language: {
            						    infoFiltered: "",
            								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
            						  },
                          processing: true,
                          "serverSide": true,
                          ajax: {
                              "url": "<?php echo base_url(); ?>Swm/Sweet_serverside",
                              "type": 'POST',
                              "data": { lgu_name : "<?= $lgu_patrolled[$lgu]['lgu_patrolled_name']; ?>" },
                          },
                          // "order": [[ 3, "asc", 4, "asc"]],
                          "columnDefs": [
                            { className:"iisno","targets":[2] },
                          ],
                          scrollX: true,
                          fixedColumns:   {
                              leftColumns: 4,
                              rightColumns: 3
                          },
                          "order": [[ 6, "asc" ]],
                          "columns": [
                            { "data": "status_description","visible": false},
                            { "data": "feedback","visible": false},
                            { "data": "feedback_seen","visible": false},
                            {
                              "data": null,
                                "render": function(data, type, row, meta){
                                    data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[1]+"&rn="+row[19]+"' target='_blank'><span class='fa fa-file'></span></a>";
                                    data += "&nbsp;<a title='View Report History - Report No: "+row['report_number']+"' href='#' onclick=view_sw_history('"+row[1]+"'); class='btn btn-info btn-sm' data-toggle='modal' data-target='#view_sw_history'><span class='fa fa-clipboard'></span> History</a>";

                                    if(row['status_description'] == 'for filing / closed' || row['status_description'] == 'signed document' || row['status'] == 'Signed Document'){
                                      data += "&nbsp;<a href='#' onclick=swupdate_report('"+row[1]+"','"+row[19]+"'); data-toggle='modal' data-target='#update_sw_confirmation_message' title='Add Update Report' style='padding: 8px 10px 8px 10px;' class='btn btn-success btn-sm'><span class='fa fa-plus'></span></a>";
                                    }

                                    if(row['status_description'] != 'for filing / closed' || row['status_description'] != 'signed document' || row['status'] != 'Signed Document'){
                                      data += "&nbsp;<a href='#' onclick=swedit_report('"+row[1]+"','1'); data-toggle='modal' data-target='#edit_report' title='Edit Report' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></a>";
                                    }

                                    if((row['feedback_seen'] == '' || row['feedback_seen'] == null) && row['feedback'] > 0){
                                      data += "&nbsp;<a href='#' onclick=lgufeedbackbtn('"+row[1]+"'); data-toggle='modal' data-target='#lgufeedbackmodal' title='LGU Feedbacks' class='btn btn-primary btn-sm'><span class='fa fa-envelope'></span><b>&nbsp;"+row['feedback']+"</b></a>";
                                    }

                                    return data;
                                }
                            },
                            { "data": "trans_no","searchable": true},
                            { "data": 1,"visible": false},
                            { "data": "creator_name","searchable": true},
                            { "data": "report_type","searchable": true},
                            { "data": "date_created","searchable": true},
                            { "data": "subject","searchable": true},
                            { "data": "date_patrolled","searchable": true},
                            { "data": "lgu_patrolled_name","searchable": true},
                            { "data": "barangay_name","searchable": true},
                            { "data": "violations_observed_desc","searchable": true},
                            { "data": "total_land_area","searchable": true},
                            { "data": "type_of_monitoring_desc","searchable": true},
                            { "data": "actions_undertaken_desc","searchable": true},
                            { "data": "assigned_name","searchable": true},
                            { "data": 'status',"searchable": true,"visible":false},
                            {
                              "data": null,
                                "render": function(data, type, row, meta){
                                  if(row['status'] == 'Approved' || row['status'] == 'Signed Document'){
                                    data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/approved.gif' height='25' width='25'><span style='color:#41AD49;'>"+row['status']+"</span>";
                                  }else if(row['status'] == 'On-Process'){
                                    data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/onprocess.gif' height='25' width='25'><span style='color:#E76A24;'>"+row['status']+"</span>";
                                  }else{
                                      data = "<img src='<?php echo base_url(); ?>../iis-images/status-icons/error.png' height='25' width='25'><span style='color:red;'>Returned</span>";
                                    }
                                  return data;
                                }
                            },
                          ]
                      });
                  </script>
              <?php } ?>

                <script type="text/javascript">
                  $(document).ready(function(){
                    <?php if(!empty($check_for_action)){ ?>
                      var table = $('#inbox_sweet_report_returned').DataTable({
                            responsive: true,
                            paging: true,
                            language: {
              						    infoFiltered: "",
              								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
              						  },
                            processing: true,
                            "serverSide": true,
                            ajax: {
                                "url": "<?php echo base_url(); ?>Swm/Sweet_serverside",
                                "type": 'POST',
                                "data": { returned_report : "<?= $this->session->userdata('userid'); ?>" },
                            },
                            // "order": [[ 3, "asc", 4, "asc"]],
                            "columnDefs": [
                              { className:"iisno","targets":[1] },
                            ],
                            scrollX: true,
                            fixedColumns:   {
                                leftColumns: 2
                            },
                            "order": [[ 6, "asc" ]],
                            "columns": [
                              {
                                "data": null,
                                  "render": function(data, type, row, meta){
                                      data = "<a title='View Report' class='btn btn-danger btn-sm' href='../swm/form?token="+row[1]+"&rn="+row[19]+"' target='_blank'><span class='fa fa-file'></span></a>";
                                      data += "&nbsp;<a title='View Report History' href='#' onclick=view_sw_history('"+row[1]+"'); class='btn btn-info btn-sm' data-toggle='modal' data-target='#view_sw_history'><span class='fa fa-clipboard'></span> History</a>";
                                      data += "&nbsp;<a href='#' onclick=swedit_report('"+row[1]+"'); data-toggle='modal' data-target='#edit_report' title='Edit Report' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></a>";

                                      return data;
                                  }
                              },
                              { "data": "trans_no","searchable": true},
                              { "data": 1,"visible": false},
                              { "data": "creator_name","searchable": true},
                              { "data": "report_type","searchable": true},
                              { "data": "date_created","searchable": true},
                              { "data": "subject","searchable": true},
                              { "data": "date_patrolled","searchable": true},
                              { "data": "lgu_patrolled_name","searchable": true},
                              { "data": "barangay_name","searchable": true},
                              { "data": "violations_observed_desc","searchable": true},
                              { "data": "total_land_area","searchable": true},
                              { "data": "type_of_monitoring_desc","searchable": true},
                              { "data": "actions_undertaken_desc","searchable": true},
                              { "data": 'status',"searchable": true},
                              { "data": "assigned_name","searchable": true},
                            ]
                      });
                    <?php } ?>

                  });

                </script>
              </div>
              <!-- Card Body -->
            <!-- SWEET OFFICER VIEW -->
            <?php } ?>
          </div>



           <?php
              $swal_arr = $this->session->flashdata('swal_arr');
              if(!empty($swal_arr)) {
                echo "<script>
                  swal({
                    title: '".$swal_arr['title']."',
                    text: '".$swal_arr['text']."',
                    type: '".$swal_arr['type']."',
                    allowOutsideClick: false,
                    customClass: 'swal-wide',
                    confirmButtonClass: 'btn-success',
                    confirmButtonText: 'Confirm',
                    onOpen: () => swal.getConfirmButton().focus()
                  })
                </script>";
              }
            ?>

        </div>
      </div>
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
        chkfeedbacks();
      });
    </script>


    <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/map.min.js"></script>
