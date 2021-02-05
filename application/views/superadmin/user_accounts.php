
<link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<style>
  #account_rights_table_wrapper th {
    font-size: 10pt;
  }
  #account_rights_table_wrapper th, td { white-space: nowrap; }
  div.dataTables_wrapper {
      margin: 0 auto;
  }

  #user_accounts_table_wrapper th {
    font-size: 10pt;
  }

  #user_accounts_table_wrapper th, td { white-space: nowrap; }
  div.dataTables_wrapper {
      margin: 0 auto;
  }

  #trnsfr-form-header{
    text-align: center;
    background-color: #0A4F83;
    color: #FFF;
    font-weight: bold;
    height: 25px;
    margin-bottom: 0px;
  }


</style>

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Content Row -->
    <div class="row">

      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Employees</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $countactive; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">To be assigned</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $countnotassigned; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-edit fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Content Row -->

    <div class="row">
      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['access_regions'] == 'yes' || $_SESSION['access_offices'] == 'yes'){ ?>
              <h6 class="m-0 font-weight-bold text-primary">User Accounts -
                <select id="userregion_" onchange="admin_change_region($('#userregion_').val(),$('#useroffice_').val(),1);" title="Select to change region">
                  <option value="<?php echo $this->encrypt->encode($_SESSION['region']); ?>"><?php echo $_SESSION['region']; ?></option>
                  <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['access_regions'] == 'yes'){ ?>
                    <?php foreach ($regions as $key => $value): ?>
                      <option value="<?php echo $this->encrypt->encode($value['rgnnum']); ?>"><?php echo $value['rgnnum']; ?></option>
                    <?php endforeach; ?>
                  <?php } ?>
                </select>
                <?php if($_SESSION['access_offices'] == 'yes' || $_SESSION['superadmin_rights'] == 'yes'){ ?>
                  <select id="useroffice_" onchange="admin_change_region($('#userregion_').val(),$('#useroffice_').val(),1);" title="Select to change office">
                    <option value="<?php echo $this->encrypt->encode($_SESSION['office']); ?>"><?php echo $_SESSION['office']; ?></option>
                    <?php foreach ($office as $key => $value): ?>
                      <option value="<?php echo $this->encrypt->encode($value['office_code']); ?>"><?php echo $value['office_code']; ?></option>
                    <?php endforeach; ?>
                  </select>
                <?php } ?>
                <span style="color:red;font-size:7pt;"><i>*Select to change region & office*</i></span>
              </h6>
            <?php }else{ ?>
              <h6 class="m-0 font-weight-bold text-primary">User Accounts - <?php echo $_SESSION['region']; ?></h6>
            <?php } ?>

              <a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#module_updates_administrative" onclick="mdluptsadmn();" title="Module updates" style="color:#FFF;"><i class="fa fa-cogs"></i>&nbsp;Module Updates</a>

          </div>

          <?php
            if($this->session->userdata('admin_tab') == '1' || $this->session->userdata('admin_tab') == ''){
              $activeone = "active"; $activeonediv = "show active"; }
              else{ $activeone = ""; $activeonediv = ""; }
            if($this->session->userdata('admin_tab') == '2'){ $activetwo = "active"; $activetwodiv = "show active"; }
              else{ $activetwo = "";  $activetwodiv = ""; }
            if($this->session->userdata('admin_tab') == '3'){ $activethr = "active"; $activethrdiv = "show active"; }
              else{ $activethr = ""; $activethrdiv = ""; }
            if($this->session->userdata('admin_tab') == '4'){ $activefr  = "active"; $activefrdiv  = "show active"; }
              else{ $activefr  = ""; $activefrdiv  = ""; }

          ?>

          <!-- Card Body -->
            <div class="card-body">
              <ul class="nav nav-tabs" id="areaofassignment" role="tablist" style="font-size: 10pt;font-weight: 100;">
                <li class="nav-item">
                  <a class="nav-link <?php echo $activeone; ?>" id="u-tab" onclick="administrative_tab('<?php echo $this->encrypt->encode('1'); ?>');" data-toggle="tab" href="#u" role="tab" aria-controls="u" aria-selected="true">Area of Assignment</a>
                </li>
                <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo $activetwo; ?>" id="employee_records-tab" onclick="administrative_tab('<?php echo $this->encrypt->encode('2'); ?>');" data-toggle="tab" href="#employee_records" role="tab" aria-controls="employee_records" aria-selected="false">Account Credentials</a>
                </li>
                <?php } ?>
                <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo $activethr; ?>" id="account_rights-tab" onclick="administrative_tab('<?php echo $this->encrypt->encode('3'); ?>');" data-toggle="tab" href="#account_rights" role="tab" aria-controls="account_rights" aria-selected="false">Account Privileges</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo $activefr; ?>" id="list-tab" data-toggle="tab" onclick="administrative_tab('<?php echo $this->encrypt->encode('4'); ?>');" href="#list" role="tab" aria-controls="list" aria-selected="false">Options</a>
                </li>
              </ul>
              <div class="tab-content" id="areaofassignmentContent">

                <!-- Area of Assignment -->
                <div class="tab-pane fade <?php echo $activeonediv; ?>" id="u" role="tabpanel" aria-labelledby="u-tab"><br>
                  <div class="row">
                    <div class="col-md-11">
                      <input type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#designate_employee" title="Designate Functions for Employee" value="Assign Employee">
                      <input type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_rule_modal" title="Add Hierarchy of Superiors Template" value="Add Hierarchy of Superiors Template">
                      <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                        <input type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#employee_settings" title="Employe Settings" value="Employee Settings">
                      <?php } ?>
                      <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                        <input type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#transferusers" title="Exchange User Functions" value="Exchange User Functions">
                      <?php } ?>
                      <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                        <input type="button" class="btn btn-success btn-sm" onclick="trmsusrsdm();" data-toggle="modal" data-target="#transferusersdom" title="Changing Hierarchy of mutilple users or specific user" value="Change Hierarchy in bulk">
                      <?php } ?>
                    </div>
                    <div class="col-md-1">
                     <select style="font-size: 8pt;" onchange="changeview(this.value);">
                        <?php

                            if($this->session->userdata('employee_view') == '1'){
                              $selected = "selected";
                            }else{
                              $selected = "";
                            }
                            if($this->session->userdata('employee_view') == '2'){
                              $selected2 = "selected";
                            }else{
                              $selected2 = "";
                            }

                        ?>
                       <option value="<?php echo $this->encrypt->encode('3'); ?>" <?php echo $selected; ?>>Default</option>
                       <option value="<?php echo $this->encrypt->encode('1'); ?>" <?php echo $selected; ?>>View 1</option>
                       <option value="<?php echo $this->encrypt->encode('2'); ?>" <?php echo $selected2; ?>>View 2</option>
                     </select>
                    </div>
                  </div>

                  <?php if($this->session->userdata('employee_view') == '' OR $this->session->userdata('employee_view') == '1'){ ?>

                  <div id="table-responsive">
                    <table class="table table-hover table-striped table-responsive-custom" id="user_accounts_table" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>UserID</th>
                          <th>#</th>
                          <th>Prefix</th>
                          <th>First name</th>
                          <th>Middle name</th>
                          <th>Last name</th>
                          <th>Suffix</th>
                          <th>Full name</th>
                          <th>Division</th>
                          <th>Section</th>
                          <th>Designation</th>
                          <th>Status</th>
                          <th>Status</th>
                          <th style="width:15%;">Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>

                  <?php } ?>

                  <?php if($this->session->userdata('employee_view') == '' OR $this->session->userdata('employee_view') == '2'){ ?>
                  <?php if($this->session->userdata('office') == 'EMB'){ ?>
                  <div id="main_content">

                    <div style="margin-top: 10px;">

                      <?php if($director != ''){ ?>

                        <button class="btn btn-primary btn-sm" type="button" id="buttonassign">
                          Director
                        </button>

                        <div class="collapse show" id="collapserd" style="margin-top:10px;">
                          <div class="card card-body">

                          <?php if($d_desig != ''){ ?>

                              <div class="row" style="padding-left:12px;padding-right:12px;">
                                <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Name</label>
                                  <input type="text" class="form-control" value="<?php echo $d_assigned; ?>" disabled>
                                </div>
                                <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Designation</label>
                                  <input type="text" class="form-control" value="<?php echo $d_desig; ?>" disabled>
                                </div>
                                <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Plantilla Position</label>
                                  <input type="text" class="form-control" value="<?php echo $plantilla; ?>" disabled>
                                </div>
                              </div>

                          <?php } ?>

                          </div>
                        </div>

                      <?php } ?>

                      <?php if($assistant_director != ''){ ?>

                        <button class="btn btn-primary btn-sm" type="button" id="buttonassign">
                          Assistant Director
                        </button>

                        <div class="collapse show" id="collapserd" style="margin-top:10px;">
                          <div class="card card-body">

                          <?php if($ad_desig != ''){ ?>

                              <div class="row" style="padding-left:12px;padding-right:12px;">
                                <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Name</label>
                                  <input type="text" class="form-control" value="<?php echo $ad_assigned; ?>" disabled>
                                </div>
                                <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Designation</label>
                                  <input type="text" class="form-control" value="<?php echo $ad_desig; ?>" disabled>
                                </div>
                                <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Plantilla Position</label>
                                  <input type="text" class="form-control" value="<?php echo $ad_plantilla; ?>" disabled>
                                </div>
                              </div>

                          <?php } ?>

                          </div>
                        </div>

                        <?php if($_SESSION['region'] == 'CO'){ ?>
                          <?php foreach ($qrydivisionOD as $key => $value) {
                             ?>

                            <!-- ALL Div -->

                              <button onclick="dc_user_assignment(<?php echo $value['divno']; ?>);" style="color:#FFF;background-color:#535F6F;" class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapsenormala<?php echo $value['divno']; ?>"
                                aria-expanded="true" aria-controls="collapsenormala<?php echo $value['divno']; ?>" id="buttonassignsec">
                                <?php echo $value['divname']; ?>
                                <span class="fa fa-caret-down" id="btncaretsub"></span>
                                <span style="float:right;margin-right:5px;color:#FFF;"><?php echo strtoupper($value['divcode']); ?></span>
                              </button>

                                <div class="collapse" id="collapsenormala<?php echo $value['divno']; ?>">
                                  <div class="card card-body" style="margin-top:10px;padding-left:5px;padding-right:5px;border-color:#08507E;border-top-left-radius:0px;border-top-right-radius:0px;">

                                  <div id="dc_user_assignment<?php echo $value['divno']; ?>"></div>

                                </div>
                              </div>

                            <!-- ALL Div -->

                          <?php } ?>

                        <?php } ?>

                      <?php } ?>

                      <?php if($regional_director != ''){ ?>

                        <button class="btn btn-primary btn-sm" type="button" id="buttonassign">
                          Regional Director
                        </button>

                        <div class="collapse show" id="collapserd" style="margin-top:10px;">
                          <div class="card card-body">
                          <?php if($rd_desig != ''){ ?>
                            <div class="row" style="padding-left:12px;padding-right:12px;">
                              <div class="col-md-4" style="margin-top: 10px;">
                                <label id="labelname">Name</label>
                                <input type="text" class="form-control" value="<?php echo $rd_assigned; ?>" disabled>
                              </div>
                              <div class="col-md-4" style="margin-top: 10px;">
                                <label id="labelname">Designation</label>
                                <input type="text" class="form-control" value="<?php echo $rd_desig; ?>" disabled>
                              </div>
                              <div class="col-md-4" style="margin-top: 10px;">
                                  <label id="labelname">Plantilla Position</label>
                                  <input type="text" class="form-control" value="<?php echo $plantilla_rd; ?>" disabled>
                              </div>
                            </div>
                          <?php } ?>
                          </div>
                        </div>

                      <?php } ?>

                    </div>

                    <?php $div_divno = !empty($div_divno) ? $div_divno : '';
                    if(!empty($div_divno)){ ?>
                    <div style="margin-top: 20px;">
                      <button class="btn btn-primary btn-sm" type="button" id="buttonassign">
                        Divisions
                      </button>
                      <div class="collapse show" id="collapsedc">
                        <div class="card card-body" style="margin-top: 10px;">

                          <!-- ALL Region Divisions -->
                          <?php
                            foreach ($qrydivision as $key => $value) {
                          ?>

                            <!-- ALL Div -->

                              <button onclick="dc_user_assignment(<?php echo $value['divno']; ?>);" style="color:#FFF;background-color:#535F6F;" class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapsenormala<?php echo $value['divno']; ?>"
                                aria-expanded="true" aria-controls="collapsenormala<?php echo $value['divno']; ?>" id="buttonassignsec">
                                <?php echo $value['divname']; ?>
                                <span class="fa fa-caret-down" id="btncaretsub"></span>
                                <span style="float:right;margin-right:5px;color:#FFF;"><?php echo strtoupper($value['divcode']); ?></span>
                              </button>

                                <div class="collapse" id="collapsenormala<?php echo $value['divno']; ?>">
                                  <div class="card card-body" style="margin-top:10px;padding-left:5px;padding-right:5px;border-color:#08507E;border-top-left-radius:0px;border-top-right-radius:0px;">

                                  <div id="dc_user_assignment<?php echo $value['divno']; ?>"></div>

                                </div>
                              </div>

                            <!-- ALL Div -->

                          <?php } ?>

                          <!-- ALL Region Divisions -->

                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <?php } ?>
                  <?php } ?>

                </div>
                <!-- Area of Assignment -->

                <!-- Options -->
                <br>

                <!-- Options -->
                <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>

                <!-- Employee records -->
                <div class="tab-pane fade <?php echo $activetwodiv; ?>" id="employee_records" role="tabpanel" aria-labelledby="employee_records-tab">
                  <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['loginas'] == 'yes'){ ?>
                    <label style="color:#000;font-weight:bold;">Login account of:</label>
                    <select id="loginas" onchange='loginas(this.value);' class="form-control">
                      <option value=""></option>
                      <?php for ($lg=0; $lg < sizeof($employee_list_active) ; $lg++) {
                          $mname = !empty($employee_list_active[$lg]['mname']) ? $employee_list_active[$lg]['mname'][0].". " : '';
                          $suffix = !empty($employee_list_active[$lg]['suffix']) ? " ".$employee_list_active[$lg]['suffix'] : '';
                          $prefix = !empty($employee_list_active[$lg]['title']) ? $employee_list_active[$lg]['title']." " : '';
                          $name = $prefix.ucwords($employee_list_active[$lg]['fname']." ".$mname." ".$employee_list_active[$lg]['sname']).$suffix;
                        ?>
                        <optgroup label="<?php echo $employee_list_active[$lg]['func']; ?>">
                          <option value="<?php echo $this->encrypt->encode($employee_list_active[$lg]['userid']); ?>"><?php echo $name; ?></option>
                        </optgroup>
                        <?php } ?>
                    </select>
                  <?php } ?>
                  <div id="table-responsive" style="margin-top: 10px;">
                    <table class="table table-hover table-striped table-responsive-custom" id="account_credentials" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>userid</th>
                          <th>fname</th>
                          <th>mname</th>
                          <th>sname</th>
                          <th>suffix</th>
                          <th>Name</th>
                          <th>Username</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
                <!-- Employee records -->
                <?php } ?>
                <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                <!-- Account Rights -->
                <div class="tab-pane fade <?php echo $activethrdiv; ?>" id="account_rights" role="tabpanel" aria-labelledby="account_rights-tab">
                  <div class="row">
                    <div class="col-md-12">
                      <input type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_user_right" title="Add user not on list" value="Add User">
                    </div>
                  </div>
                  <div id="table-responsive" style="margin-top: 10px;">
                    <table class="table table-hover table-striped table-responsive-custom" id="account_rights_table" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>userid</th>
                          <th>fname</th>
                          <th>mname</th>
                          <th>sname</th>
                          <th>suffix</th>
                          <th>Name</th>
                          <th title="God mode">SUPER ADMIN VIEW</th>
                          <th title="Grants user to access other regions">ACC. REGIONS</th>
                          <th title="Grants user to access other offices">ACC. OFFICES</th>
                          <th title="Grants user to access or login a specific account">ACC. ACCOUNT</th>
                          <th title="Grants user to generate QR Code thru routing documents">GEN. QR CODE</th>
                          <th title="Grants user to view with QR code documents">QR CODE DOCS</th>
                          <th title="Grants user to manipulate area assignment of employees">HR/USER Acct.View</th>
                          <th title="Grants user to edit credentials and reset password">Account Credentials</th>
                          <th title="Grants user to add company">ADD Company</th>
                          <th title="Grants user to access travel order admin (Under dev)">Travel Order Admin</th>
                          <th title="Grants user to view all approved travel">All Approved T.O. SB</th>
                          <th title="Grants user to issue travel tickets">T.O. Ticket Request SB</th>
                          <th title="Assign user to be listed in 'Assistant or Laborers Allowed' field">T.O. Asst/Laborer DD</th>
                          <th title="Assign user as Chief Accountant for Travel Ticket">T.O. Chief. Accountant</th>
                          <th title="Grants user to view all attachments in DMS">View All DMS Attach.</th>
                          <th title="Grants user to approve client requests">Company Request</th>
                          <th title="Grants user to forward transaction(s) to specific region">DMS Regnl User Proc.</th>
                          <th title="Grants user to forward transaction(s) to multiple users">DMS Multi Proc.</th>
                          <th title="Grants user to Client Logs interface">Client Log</th>
                          <th title="Add user with role to SMR Admin/Evaluator">SMR Assigner</th>
                          <th title="Sets user as Records Officer for accessing Rec.Officer-Only Functions">Records Ofcr.</th>
                          <th title="Authorize user to delete transaction(s)">Delete Trans.</th>
                          <th title="Authorize user to view PAB Tab which contains all PAB Transactions">P.A.B.</th>
                          <th title="Grants user to set SWEET evaluator(s) and select LGU to specific user">ENMO Admin</th>
                          <th title="Grants user the privilege to view Monitoring Report Attachments Only">Mon.Reprts</th>
                          <th title="Grants user the privilege to view EIA Attachments Only">EIA Docs.</th>
                          <th title="Grants user the privilege to view HazWaste Attachments Only">HAZWASTE Docs.</th>
                          <th title="Grants user the privilege to view Chem Attachments Only">CHEMICAL Docs.</th>
                          <th title="incognito for ( ͡° ͜ʖ ͡°)">View Confidential Tab</th>
                          <th title="ehehe (ง ͡ʘ ͜ʖ ͡ʘ)ง ">Set/Unset Confidential Tag</th>
                          <th title="Grants user the privilege to Add Event">Add Event</th>
                          <th title="Change user role to Admin in Physical Budget System and Budget Utilization Report">PBS & BUR Admin</th>
                          <th title="Grants user the privilege to Add Bulletin Post">Add to Bulletin</th>
                          <th title="Grants user the privilege to access supports from employees">Add Admin support</th>
                          <th title="Grants user the privilege to access DMS Inbox Monitoring">Inbox Monitoring</th>
                          <th title="Grants user the privilege to access Universe Module unrestrictedly">Universe Admin</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
                <!-- Account Rights -->
                <?php } ?>

                <div class="tab-pane fade <?php echo $activefrdiv; ?>" id="list" role="tabpanel" aria-labelledby="list-tab">
                  <?php if($this->session->userdata('superadmin_rights') == 'yes'){ ?>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_detailsdv_modal">Add Division</button>
                  <?php } ?>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_details_modal">Add Section/Unit/PEMU</button>
                  <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['account_credentials_rights'] == 'yes'){ ?>
                    <button class="btn btn-danger btn-sm" style="float:right;" onclick="notapplicablesecorunit();" data-toggle="modal" data-target="#not_applicable_secorunit">Remove Section/Unit</button>
                  <?php } ?>
                  <hr>
                  <div id="table-responsive" style="margin-top: 10px;">
                    <table class="table table-hover table-striped table-responsive-custom" id="region_sections" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Secno</th>
                          <th>Division</th>
                          <th>Section/Unit/PEMU</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                    <hr>
                    <?php if($this->session->userdata('superadmin_rights') == 'yes'){ ?>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_details_plantilla_modal">Add Plantilla Position</button>
                    <?php } ?>
                    <span style="float:right;font-style:italic;color:#104E93;">Please email for Plantilla Position requests. <i class="fa fa-heart"></i></span>
                    <hr>
                    <table class="table table-hover table-striped table-responsive-custom" id="region_plantilla" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Plantilla No</th>
                          <th>Plantilla Abbreviation</th>
                          <th>Plantilla Position</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                    <hr>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_rule_modal" title="Add line of Authority">Add line of Authority</button>
                    <hr>
                    <table class="table table-hover table-striped table-responsive-custom" id="line_of_authority_table" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>fname</th>
                          <th>mname</th>
                          <th>sname</th>
                          <th>suffix</th>
                          <th>Added by</th>
                          <th>Description</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>

              </div>

            </div>
          <!-- Card Body -->

        </div>
      </div>
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

    <!-- <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script> -->


    <script type="text/javascript">
      $(document).ready(function(){

        var table = $('#region_sections').DataTable({
              responsive: true,
              paging: true,
              language: {
						    infoFiltered: "",
								processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
						  },
              processing: true,
              "serverSide": true,
              "order": [[ 1, "asc"],[ 2, "asc"] ],
              "ajax": "<?php echo base_url(); ?>Admin/Serverside/User_sections_serverside",
              "columns": [
                { "data": "secno"  ,"visible": false},
                { "data": "divname","searchable": true},
                { "data": "sect"   ,"searchable": true},
                {
                  "data": null,
                    "render": function(data, type, row, meta){

                        data = "<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_details_modal' onclick=edit_details('"+row['secno']+"');>Edit</button>";
                        if(row['cnt'] != null){
                          data += "&nbsp;<span style='color: red;'>(Added to removed list)</span>";
                        }
                      return data;
                    }
                },
              ]
          });

        var superadmin = "<?= $_SESSION['superadmin_rights']; ?>";

        var table_plantilla = $('#region_plantilla').DataTable({
          responsive: true,
          paging: true,
          language: {
            infoFiltered: "",
            processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
          },
          processing: true,
          "serverSide": true,
          "order": [[ 2, "asc"] ],
          "ajax": "<?php echo base_url(); ?>Admin/Serverside/User_plantilla_serverside",
          "columns": [
            { "data": "planpstn_id"  ,"visible": false},
            { "data": "planpstn_code","searchable": true},
            { "data": "planpstn_desc","searchable": true},
            {
              "data": null,
              "visible": superadmin,
                "render": function(data, type, row, meta){

                    data = "<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_plantilla_modal' onclick='edit_plantilla_details("+row['planpstn_id']+");'>Edit</button>";

                  return data;
                }
            },
          ]
        });

        var account_credentials = $('#account_credentials').DataTable({
            // dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'B><'col-sm-12 col-md-8'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            // buttons: [
            //   {
            //       extend: 'excelHtml5',
            //       exportOptions: {
            //           modifier: {
            //            // order : 'index', // 'current', 'applied','index', 'original'
            //            page : 'all', // 'all', 'current'
            //            // search : 'none' // 'none', 'applied', 'removed'
            //           },
            //           columns: [0, 1, 2, 3, 4, 5],
            //       }
            //   },
            // ],
            // lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
            responsive: true,
            paging: true,
            language: {
              infoFiltered: "",
              processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
            },
            processing: true,
            "serverSide": true,
            "order": [[ 1, "asc"] ],
            "ajax": "<?php echo base_url(); ?>Admin/Serverside/account_credentials_serverside",

            "columns": [
              { "data": "userid","searchable": true, "visible": false},
              { "data": "fname","searchable": true, "visible": false},
              { "data": "mname","searchable": true, "visible": false},
              { "data": "sname","searchable": true, "visible": false},
              { "data": "suffix","searchable": true, "visible": false},
              {
                "data": null,
                  "render": function(data, type, row, meta){

                      data = row['fname']+" "+row['mname']+row['sname']+row['suffix'];

                    return data;
                  }
              },
              { "data": "username","searchable": true, "visible": false},
              {
                "data": null,
                  "render": function(data, type, row, meta){
                    var qzxc = '<?php echo $_SESSION['superadmin_rights']; ?>';
                    if(qzxc == 'yes'){
                      data = "<span title='"+row['raw_password']+"'>"+row['username']+"</span>";
                    }else{
                      data = row['username'];
                    }


                    return data;
                  }
              },
              { "data": "email","searchable": true},
              {
                "data": null,
                  "render": function(data, type, row, meta){
                    var superadmin = "<?php echo $this->session->userdata('superadmin_rights'); ?>";

                    if(superadmin == 'yes'){
                      if(row[7] > 20){
                         data = "<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_account_modal' onclick=edit_account_modal_dtls('"+row['userid']+"');>Edit</button>&nbsp;<button class='btn btn-success btn-sm' href='#' onclick=resetpassword('"+row['userid']+"');>Reset Password</button>";
                      }else{
                         data = "<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_account_modal' onclick=edit_account_modal_dtls('"+row['userid']+"');>Edit</button>&nbsp;<button class='btn btn-success btn-sm' href='#' onclick=resetpassword('"+row['userid']+"');>Reset Password</button>&nbsp;<button class='btn btn-danger btn-sm' href='#' onclick=encryptpassword('"+row['userid']+"','"+row[6]+"');>Encrypt Password</button>";
                      }

                    }else{
                      data = "<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_account_modal' onclick=edit_account_modal_dtls('"+row['userid']+"');>Edit</button>&nbsp;<button class='btn btn-success btn-sm' href='#' onclick=resetpassword('"+row['userid']+"');>Reset Password</button>";
                    }

                    return data;
                  }
              },
            ]
        });

        var user_accounts_table = $('#user_accounts_table').DataTable({
            responsive: true,
            paging: true,
            language: {
              infoFiltered: "",
              processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
            },
            processing: true,
            "serverSide": true,
            "ajax": "<?php echo base_url(); ?>Admin/Serverside/user_accounts_table_serverside",
            "order": [[ 8, "asc"], [ 5, "asc"] ],
            "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
            scrollX: true,
            "columns": [
              { "data": "userid","searchable": true, "visible": false},
              { "data": 1,"searchable": true, "visible": false},
              { "data": "title","searchable": true, "visible": false},
              { "data": "fname","searchable": true, "visible": false},
              { "data": "mname","searchable": true, "visible": false},
              { "data": "sname","searchable": true, "visible": true},
              { "data": "suffix","searchable": true, "visible": false},
              {
                "data": null, "orderable": false,
                  "render": function(data, type, row, meta){
                    data = "<span title='"+row[1]+"'>"+row['title']+row['fname']+row['mname']+row['sname']+row['suffix']+"</span>";

                    return data;
                  }
              },
              { "data": "divname","searchable": true, "visible": true},
              { "data": "section","searchable": true, "visible": true},
              { "data": "designation","searchable": true, "visible": true},
              { "data": 8,"searchable": true, "visible": false},
              { "data": "verified","searchable": true, "visible": true},
              {
                "data": null,
                "sortable" : false,
                  "render": function(data, type, row, meta){
                    if(row[8] == '0'){
                      data = "<button class='btn btn-success btn-sm' href='#' data-toggle='modal' data-target='#edit_user_accounts_modal' onclick=edit_user_accounts_modal('"+row['userid']+"');>Assign</button>";
                      // data += "&nbsp;<button class='btn btn-danger btn-sm' href='#' onclick=rmvusrbtnusrlst('"+row['userid']+"');>Remove</button>";
                      data += "&nbsp;<button class='btn btn-danger btn-sm' href='#' onclick=rmvusrbtnusrlst('"+row['userid']+"');>Remove</button>";
                    }else{
                      data = "<button class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#view_user_accounts_modal' onclick=view_user_accounts_modal('"+row['userid']+"');>Hierarchy</button>&nbsp;<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_user_accounts_details_modal' onclick=edit_user_accounts_details_modal('"+row['userid']+"');>Edit Employee Details</button>";
                    }

                    return data;
                  }
              },
            ]
        });

        var line_of_authority_table = $('#line_of_authority_table').DataTable({
          responsive: true,
          paging: true,
          language: {
            infoFiltered: "",
            processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
          },
          processing: true,
          "serverSide": true,
          "order": [[ 5, "asc"] ],
          "ajax": "<?php echo base_url(); ?>Admin/Serverside/Line_of_authority_table_serverside",
          "columns": [
            { "data": "addedby"  ,"searchable": true,"visible": false},
            { "data": "fname"  ,"searchable": true,"visible": false},
            { "data": "mname","searchable": true,"visible": false},
            { "data": "sname","searchable": true,"visible": false},
            { "data": "suffix","searchable": true,"visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){
                  if(row['addedby'] == '1'){
                    data = "Administrator";
                  }else{
                    data = row['fname']+" "+row['mname']+row['sname']+row['suffix'];
                  }

                  return data;
                }
            },
            { "data": "rule_name","searchable": true},
            { "data": 5,"searchable": true,"visible": false},
            {
              "data": null,
                "render": function(data, type, row, meta){

                    data = "<button class='btn btn-info btn-sm' href='#' data-toggle='modal' data-target='#view_line_of_authority' onclick=view_line_of_authority('"+row[5]+"');>View</button>";
                    if(row['rule_name'] != 'Assistant Director'){
                      data += "&nbsp;<button class='btn btn-warning btn-sm' href='#' data-toggle='modal' data-target='#edit_line_of_authority' onclick=edit_line_of_authority('"+row[5]+"');>Edit</button>&nbsp;<button class='btn btn-danger btn-sm' href='#' data-toggle='modal' data-target='#delete_line_of_authority' onclick=delete_line_of_authority('"+row[5]+"');>Remove</button>";
                    }
                  return data;
                }
            },
          ]
        });


        var adminonly = '<?php echo $_SESSION['superadmin_rights']; ?>';

        var account_rights_table = $('#account_rights_table').DataTable({
            responsive: true,
            paging: true,
            language: {
              infoFiltered: "",
              processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />",
            },
            processing: true,
            "serverSide": true,
            "order": [[ 1, "asc"] ],
            "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
            // "ajax": "<?php echo base_url(); ?>Admin/Serverside/account_rights_serverside",
            ajax: {
                "url": "<?php echo base_url(); ?>Admin/Serverside/account_rights_serverside",
                "type": 'POST',
                "data": {  },
            },
            scrollX: true,
            "columns": [
              { "data": "userid","searchable": true, "visible": false},
              { "data": "fname","searchable": true, "visible": false},
              { "data": "mname","searchable": true, "visible": false},
              { "data": "sname","searchable": true, "visible": false},
              { "data": "suffix","searchable": true, "visible": false},

              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      data = row['fname']+" "+row['mname']+row['sname']+row['suffix'];

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                 "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['superadmin_rights'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('superadmin_rights'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('superadmin_rights'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['superadmin_rights']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                 "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['access_regions'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('access_regions'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('access_regions'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['access_regions']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                 "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['access_offices'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('access_offices'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('access_offices'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['access_offices']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                 "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['loginas'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('loginas'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('loginas'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['loginas']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                 "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['trans_qrcode'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('trans_qrcode'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('trans_qrcode'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['trans_qrcode']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                 "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['qrcode_docs'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('qrcode_docs'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('qrcode_docs'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['qrcode_docs']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['hr_rights'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('hr_rights'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('hr_rights'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['hr_rights']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['account_credentials_rights'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('account_credentials_rights'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('account_credentials_rights'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['account_credentials_rights']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['company_rights'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('company_rights'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('company_rights'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['company_rights']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['to_rights'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('to_rights'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('to_rights'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['to_rights']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['to_view_all_approved'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('to_view_all_approved'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('to_view_all_approved'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['to_view_all_approved']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['to_ticket_request'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('to_ticket_request'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('to_ticket_request'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['to_ticket_request']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['to_assistant_or_laborers'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('to_assistant_or_laborers'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('to_assistant_or_laborers'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['to_assistant_or_laborers']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['to_ticket_chief_accountant'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('to_ticket_chief_accountant'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('to_ticket_chief_accountant'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['to_ticket_chief_accountant']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              {
                "data": null,
                "sortable": false,
                // "visible" : adminonly,
                  "render": function(data, type, row, meta){

                      if(row['dms_all_view_attachment'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('dms_all_view_attachment'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('dms_all_view_attachment'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['dms_all_view_attachment']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },

              {
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){

                      if(row['client_rights'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('client_rights'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('client_rights'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['client_rights']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // Grant User - Regional Processing (DMS)
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['trans_regionalprc'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('trans_regionalprc'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('trans_regionalprc'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['trans_regionalprc']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // Grant User - Multi-Processing (DMS)
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['trans_multiprc'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('trans_multiprc'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('trans_multiprc'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['trans_multiprc']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // Clinet log
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['client_log'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('client_log'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('client_log'); ?>";
                      }

                      data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['client_log']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // for adding evaluator or admin in smr
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['add_user_rights_with_role'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('add_user_rights_with_role'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('add_user_rights_with_role'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['add_user_rights_with_role']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // Records Officer Rights
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['rec_officer'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('rec_officer'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('rec_officer'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['rec_officer']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // Transaction Deletion
                "data": null,
                "sortable": false,
               "visible" : adminonly,
                  "render": function(data, type, row, meta){
                      if(row['trans_deletion'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('trans_deletion'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('trans_deletion'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['trans_deletion']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // View PAB
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['view_pab_trans'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('view_pab_trans'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('view_pab_trans'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['view_pab_trans']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // View SWEET Settings
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['access_sweet_settings'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('access_sweet_settings'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('access_sweet_settings'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['access_sweet_settings']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // View Monitoring Report Attachments
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['view_monitoring_report'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('view_monitoring_report'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('view_monitoring_report'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['view_monitoring_report']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // View EIA Attachments
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['view_eia'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('view_eia'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('view_eia'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['view_eia']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // View hAZwASTE Attachments
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['view_haz'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('view_haz'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('view_haz'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['view_haz']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // View cHEM Attachments
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['view_chem'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('view_chem'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('view_chem'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['view_chem']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // view_confidential_tab
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['view_confidential_tab'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('view_confidential_tab'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('view_confidential_tab'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['view_confidential_tab']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // set_confidential_tag
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['set_confidential_tag'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('set_confidential_tag'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('set_confidential_tag'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['set_confidential_tag']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // add event
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['add_event'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('add_event'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('add_event'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['add_event']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // add event
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['access_pbsbur'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('access_pbsbur'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('access_pbsbur'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['access_pbsbur']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
              { // add bulletin
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                      if(row['add_bulletin'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('add_bulletin'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('add_bulletin'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['add_bulletin']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
               {  //support_admin
                 "data": null,
                 "sortable": false,
                   "render": function(data, type, row, meta){
                     console.log(row['support_admin']);
                       if(row['support_admin'] == 'no'){
                         var token = "yes";
                         var column = "<?php echo $this->encrypt->encode('support_admin'); ?>";
                       }else{
                         var token = "no";
                         var column = "<?php echo $this->encrypt->encode('support_admin'); ?>";
                       }

                         data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['support_admin']+"</option><option>"+token+"</option></select>";

                     return data;
                   }
               },
              {  //inbox_monitoring
                "data": null,
                "sortable": false,
                  "render": function(data, type, row, meta){
                    console.log(row['inbox_monitoring']);
                      if(row['inbox_monitoring'] == 'no'){
                        var token = "yes";
                        var column = "<?php echo $this->encrypt->encode('inbox_monitoring'); ?>";
                      }else{
                        var token = "no";
                        var column = "<?php echo $this->encrypt->encode('inbox_monitoring'); ?>";
                      }

                        data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['inbox_monitoring']+"</option><option>"+token+"</option></select>";

                    return data;
                  }
              },
             {  //universe_admin
               "data": null,
               "sortable": false,
                 "render": function(data, type, row, meta){
                   console.log(row['universe_admin']);
                     if(row['universe_admin'] == 'no'){
                       var token = "yes";
                       var column = "<?php echo $this->encrypt->encode('universe_admin'); ?>";
                     }else{
                       var token = "no";
                       var column = "<?php echo $this->encrypt->encode('universe_admin'); ?>";
                     }

                       data = "<select onchange=acc_rights('"+token+"','"+column+"','"+row['userid']+"');><option>"+row['universe_admin']+"</option><option>"+token+"</option></select>";

                   return data;
                 }
             },
            ]
        });


        $('#plantilla_selectize').selectize();
        $('#rank_selectize').selectize();
        $('#section_selectize_assign').selectize();
        $('#division_selectize_assign').selectize();
        $('#loginas').selectize();
        $('#edit_section_selectize').selectize();
        $('#edit_division_selectize').selectize();
        $('#edit_divname').selectize();
        $('#edit_user_accounts_details_plantilla_selectize').selectize();
        $('#edit_user_accounts_details_rank_selectize').selectize();
        $('#view_user_accounts_modal_selectize_rule').selectize();
      });


    </script>
