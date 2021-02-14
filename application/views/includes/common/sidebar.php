<style>
  @media only screen and (max-width: 767px) {
    #image-logo{
      display:none;
    }
    #image-logo-denr{
      display:block !important;
    }
  }

  @media only screen and (max-width: 450px) {
    nav.navbar.navbar-expand.navbar-light.bg-white.topbar.mb-4.static-top.shadow {
      /* position: fixed; */
      z-index: 999;
    }
  }

  #image-logo-denr{
      display:none;
  }
</style>
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #08507E;">
<!-- Sidebar -->

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>index/dashboard" style="background-color:#FFF;">
    <!-- <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['func']; ?></div> -->

    <img id="image-logo" src="<?php echo base_url(); ?>assets/images/logo-iis.png" alt="logo" style="height:50px;"></img>
    <span style="color: #326DDE;font-size: 17pt;font-family: sans-serif;letter-spacing: -1px;font-weight: bold;">EMB</span>
    <span style="color: #FE9E38;font-size: 17pt;font-family: sans-serif;letter-spacing: 0px;font-weight: bold;">IIS</span>

    <img id="image-logo-denr" src="<?php echo base_url(); ?>assets/images/logo-denr.png" alt="logo-denr" style="width:50px;height:50px;"></img>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="<?php echo base_url(); ?>dashboard">
      <i class="fas fa-fw fa-square"></i>
      <span>Dashboard</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="<?php echo base_url(); ?>ssoenrollment">
      <i class="fas fa-fw fa-edit"></i>
      <span>SSO Systems</span></a>
  </li>

    <hr class="sidebar-divider my-0">
    <!-- <li class="nav-item"> -->
      <!-- <a class="nav-link" target="_blank" href="<?php echo base_url(); ?>Support/Emb_support">
        <i class="fa fa-phone" aria-hidden="true"></i>
        <span>Support</span></a>
      </li> -->
      <?php if ($this->session->userdata('userid') == 157 || $this->session->userdata('userid') == 125 || $this->session->userdata('userid') == 3612 || $this->session->userdata('userid') == 51 || $this->session->userdata('userid') == 119 || $this->session->userdata('userid') == 3878) : ?>
        <?php if ($this->session->userdata('support_admin') == 'yes'): ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_supp" aria-expanded="true" aria-controls="collapse_supp">
            <i class="fas fa-fw fa-users"></i>
              <span>Support</span>
              <span class="badge badge-danger badge-counter spc_" style="right: unset!important;">
              </span>
          </a>
          <div id="collapse_supp" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="<?php echo base_url(); ?>Support/Emb_support"><span>Support list</span>
                <span class="badge badge-danger badge-counter spc_" style="right: unset!important;">
                </span>
              </a>

              <a class="collapse-item" href="<?php echo base_url(); ?>Support/Emb_support/support_utility_list">Support Utilities</a>
            </div>
          </div>
        </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>Support/Emb_support"  aria-expanded="true" aria-controls="collapse_supp">
              <i class="fas fa-fw fa-users"></i>
                <span>Support</span>
            </a>
          </li>
      <?php endif; ?>
      <?php endif; ?>

  <hr class="sidebar-divider">

  <?php if($this->session->userdata('office') == 'EMB' AND ($this->session->userdata('superadmin_rights') == 'yes' OR $this->session->userdata('region') == 'CO' OR $this->session->userdata('region') == 'R7')){ ?>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>schedule/dashboard">
        <i class="fas fa-fw fa-calendar"></i>
        <span>Calendar of Events</span>
        <span class="badge badge-danger badge-counter" style="right: unset!important;" id="msc_">
          <?php
            // get_instance()->load->helper('common_helper');
            // $mysched = myschedules();
            // echo ($mysched > 0) ? $mysched : 0;
          ?>
        </span>
      </a>
    </li>
    <hr class="sidebar-divider">
  <?php } ?>


    <?php if($this->session->userdata('superadmin_rights') == 'yes') { ?>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url('planner/main')?>">
          <i class="far fa-calendar-alt"></i>
          <span>Planning Scheduler</span>
          <!-- <span class="badge badge-danger badge-counter" style="right: unset!important;" id="msc_">
          </span> -->
        </a>
      </li>
      <hr class="sidebar-divider">
    <?php } ?>

    <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['hr_rights'] == 'yes'){ ?>
      <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['hr_rights'] == 'yes'){ ?>
    <!-- HUMAN RESOURCE -->
      <div class="sidebar-heading">
        <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
          Super Administrator
        <?php }else if($_SESSION['hr_rights'] == 'yes'){ ?>
          Account Manager
        <?php } ?>
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-users"></i>
            <span>Account Manager</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>administrative/userlist">User Accounts</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>administrative/uploads">File Uploads</a>
          </div>
        </div>
      </li>
     <?php } ?>
      <hr class="sidebar-divider">
    <?php } ?>
  <!-- HUMAN RESOURCE -->

<!-- HRIS -->
<?php if($this->session->userdata('region') == 'CO' OR $this->session->userdata('region') == 'R7') { ?>
  <div class="sidebar-heading">
    HUMAN RESOURCE SYSTEM
  </div>
  <?php if($this->session->userdata('superadmin_rights') == 'yes') { ?>
  <li class="nav-item">
    <a class="nav-link" href="<?=base_url('Admin/Pds/Main')?>">
      <i class="fas fa-fw fa-user"></i>
      <span>Employee Details</span>
    </a>
  </li>
<?php } ?>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebio" aria-expanded="true" aria-controls="collapsebio">
      <i class="fas fa-fw fa-calendar"></i>
        <span>Biometrics Data</span>
    </a>
    <div id="collapsebio" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?php echo base_url(); ?>dtr/dashboard">Daily Time Record</a>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
<?php } ?>

  <?php if($this->session->userdata('office') == 'EMB'){ ?>
    <div class="sidebar-heading">
      Document Management System
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dmsSidebarCollapse" aria-expanded="true" aria-controls="dmsSidebarCollapse">
        <i class="fas fa-file-import"></i>
        <span>Documents</span>
        <span class="badge badge-danger badge-counter" style="right: unset!important;" id="rtc_">
          <?php
            // if($_SESSION['superadmin_rights'] == 'yes') {
              // get_instance()->load->helper('common_helper');
              // echo received_transaction_count();
            // }
          ?>
        </span>
      </a>
      <div id="dmsSidebarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <?php
            if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['view_pab_trans'] == 'yes')
            {
              echo '<a class="collapse-item" href="'.base_url('Dms/Dms/pab_view').'">PABS</a>';
            }
            if($_SESSION['superadmin_rights'] == 'yes')
            {
              echo '<a class="collapse-item" href="'.base_url('Dms/Dms/tracker').'">Tracker</a>';
            }

            if( in_array($_SESSION['secno'], array(3,113,115,118,119,120,153,180,181,325) ) || $_SESSION['divno'] == 3 || $_SESSION['superadmin_rights'] == 'yes' )
            {
              // PLANNING
              echo '<hr style="margin: 10px 0 10px 0;"/>';
              echo '<h5 class="collapse-header">Planning:</h5>';
              echo '<a style="margin: 0 0 0 10px;" class="collapse-item" href="'.base_url('dms/documents/planning/monreport').'">Monitoring Report</a>';
              echo '<a style="margin: 0 0 0 10px;" class="collapse-item" href="'.base_url('dms/documents/planning/permreport').'">Permitting Report</a>';
              echo '<hr style="margin: 10px 0 10px 0;"/>';
            }
            if($_SESSION['superadmin_rights'] == 'yes')
            {
              // DENR OFFICE
              echo '<h5 class="collapse-header">DENR Office:</h5>';
              echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Dms/Dms/denr_trans').'">All Transactions</a>';
              echo '<hr style="margin: 10px 0 10px 0;"/>';
            }

            if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['view_confidential_tab'] == 'yes' || $_SESSION['func'] == 'Director' || $_SESSION['func'] == 'Assistant Director')
            {
              echo '<a class="collapse-item" href="'.base_url('Dms/Dms/confidential').'">Confidential</a>';
            }
          ?>
          <a class="collapse-item" href="<?=base_url('dms/documents/all')?>">All Transactions
          <a class="collapse-item" href="<?=base_url('dms/documents/inbox')?>">Inbox
            <span class="badge badge-danger badge-counter" style="right: unset!important;" id="rtc2_">
            <?php //get_instance()->load->helper('common_helper'); echo received_transaction_count(); ?>
            </span></a>
          <a class="collapse-item" href="<?=base_url('dms/documents/outbox')?>">Outbox
          <a class="collapse-item" href="<?php echo base_url('Dms/Dms/drafts');?>">Drafts</a>
          <a class="collapse-item" href="<?php echo base_url('dms/documents/filed-closed');?>">Filed/Closed</a>
          <!-- <a class="collapse-item" href="<?php // echo base_url('Dms/Dms/records');?>">Records</a> -->
          <?php
            if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['trans_deletion'] == 'yes')
            {
              echo '<hr style="margin: 10px 0 10px 0;"/>';
              echo '<h5 class="collapse-header">Dev. Tools:</h5>';
              if($_SESSION['superadmin_rights'] == 'yes') {
                echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Dms/Dms/dttb_sample').'">Nation-Wide View</a>';
                echo '<a style="margin: 0 0 0 10px;" class="collapse-item" href="'.base_url('dms/documents/devtools/filetransfer').'">Transfer Transactions</a>';
              }
              echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('dms/documents/revisions').'">Revisions</a>';
              echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Dms/Dms/deleted_trans').'">Deleted</a>';
              echo '<hr style="margin: 10px 0 10px 0;"/>';
            }

            echo '<h5 class="collapse-header">Settings:</h5>';
            echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Usersettings/Usersettings/settings').'">Options</a>';

            if($_SESSION['superadmin_rights'] == 'yes')
            {
              if($_SESSION['token'] == '515e12d4a186a84')
              {
                echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('dms/custom/test/debug/settings/dlup').'">Upload</a>';
                echo '<a style="margin: 0 0 0 10px;" class="collapse-item" href="'.base_url('dms/custom/test/debug/settings/options').'">Options</a>';
              }
              echo '<hr style="margin: 10px 0 10px 0;"/>';
            }
          ?>
        </div>
      </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#recordsSidebarCollapse" aria-expanded="true" aria-controls="recordsSidebarCollapse">
        <i class="fas fa-folder-plus"></i>
        <span>Records</span>
      </a>
      <div id="recordsSidebarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="<?php echo base_url('Dms/Dms/records');?>">Records Listing</a>
          <?php
            if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['rec_officer'] == 'yes' || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['trans_regionalprc'] == 'yes' || in_array( $this->session->userdata('secno'), array(77,73,165,177,190,239,284,317,2,6,151,188,246,292))) {
               echo '<a class="collapse-item" href="'.base_url('dms/documents/migrate').'">Migrate Data</a>';
            }
          ?>
          <!-- <a class="collapse-item" href="<?php echo base_url('Smr/records');?>">SMR Records</a> -->
          <!-- <a class="collapse-item" href="<?php echo base_url('Clients/Records');?>">Client lists</a> -->
          <?php
            // if($_SESSION['superadmin_rights'] == 'yes') {
              echo '<hr style="margin: 10px 0 10px 0;"/>';
              echo '<h5 class="collapse-header">Published:</h5>';
              echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Dms/Dms/publish_mc').'">Memo. Circ.</a>';
              echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Dms/Dms/publish_so').'">Special Order</a>';
              echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Dms/Dms/publish_dao').'">DENR Admin. Order</a>';
            // }
            echo '<hr style="margin: 10px 0 10px 0;"/>';
            echo '<h5 class="collapse-header">Permits:</h5>';
            echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Records/Index/eia').'">EIA</a>';
            echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Records/Index/air_water').'">Air/Water</a>';
            echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Records/Index/chemical').'">Chemical</a>';
            echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Records/Index/hazwaste').'">HazWaste</a>';
            echo '<hr style="margin: 10px 0 10px 0;"/>';
          ?>
        </div>
      </div>
    </li>

    <?php if($this->session->userdata('userid') == '468' OR $this->session->userdata('userid') == '376' OR $this->session->userdata('userid') == '247' OR $this->session->userdata('userid') == '62' OR $this->session->userdata('userid') == '20' OR $this->session->userdata('userid') == '42' OR $this->session->userdata('secno') == '94' OR $this->session->userdata('superadmin_rights') == 'yes' OR $this->session->userdata('divno') == '12'){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#administrativeSidebarCollapse" aria-expanded="true" aria-controls="administrativeSidebarCollapse">
          <i class="fas fa-book"></i>
          <span>Administrative System</span>
        </a>
        <div id="administrativeSidebarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#administrativeSidebarCollapse">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url().'ptaasapiauth?token='.$this->session->userdata('token'); ?>">Physical TAA System</a>
            <?php if($this->session->userdata('userid') == '468' OR $this->session->userdata('userid') == '376' OR $this->session->userdata('userid') == '247' OR $this->session->userdata('userid') == '62' OR $this->session->userdata('userid') == '20' OR $this->session->userdata('userid') == '42' OR $this->session->userdata('secno') == '94' OR $this->session->userdata('superadmin_rights') == 'yes'){ ?>
            <a class="collapse-item" href="<?php echo base_url().'burapiauth?token='.$this->session->userdata('token'); ?>">Budget Utilization Report</a>
            <?php } ?>
            <hr style="margin: 10px 0 10px 0;"/>
            <h5 class="collapse-header">INVENTORY:</h5>
              <a class="collapse-item" href="<?php echo base_url(); ?>/Inventory/Equipments">Equipment</a>
              <a class="collapse-item" href="">Supplies</a>
          </div>
        </div>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url().'ptaasapiauth?token='.$this->session->userdata('token'); ?>">
          <i class="fas fa-fw fa-book"></i>
          <span>Physical TAA System</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url().'burapiauth?token='.$this->session->userdata('token'); ?>">
          <i class="fas fa-fw fa-book"></i>
          <span>Budget Utilization Report</span></a>
      </li> -->
    <?php } ?>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#companycollaps" aria-expanded="true" aria-controls="collapseTwo">
          <!-- <i class="fas fa-fw fa-archway"></i> -->
          <i class="far fa-building"></i>
          <span>Company</span>
            <?php if ($_SESSION['client_rights'] == 'yes'): ?>
              <span class="badge badge-danger badge-counter" style="right: unset!important;" id="crc_">
                  <?php
                 // get_instance()->load->helper('common_helper');
                 //  echo company_request_notification();
                 ?>
             </span>
          <?php endif; ?>
        </a>

        <div id="companycollaps" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php
              if($_SESSION['superadmin_rights'] == 'yes') {
                echo '<a class="collapse-item" href="'.base_url('Company/Map').'">Map</a>';
              }
            ?>
            <?php if ( $_SESSION['company_rights'] == 'yes'): ?>
              <a class="collapse-item" href="<?php echo base_url(); ?>Company/Add_company">Add Company</a>
              <?php else: ?>
            <?php endif; ?>
            <?php if ($_SESSION['region'] === 'CO' || $_SESSION['userid'] == '1'): ?>
                <a class="collapse-item" href="<?php echo base_url(); ?>Company/Company_list/admin_complist_serverside">Company List</a>
                <?php else: ?>
                  <a class="collapse-item" href="<?php echo base_url(); ?>company/company_list">Company List</a>
            <?php endif; ?>
              <hr style="margin: 10px 0 10px 0;"/>
              <h5 class="collapse-header">COMPANY REQUEST:</h5>
              <a  style="margin: 0 0 0 20px;" class="collapse-item" href="<?php echo base_url(); ?>company/disapproved">DISAPPROVED</a>
              <?php if ($_SESSION['client_rights'] == 'yes'): ?>
              <a  style="margin: 0 0 0 20px;" class="collapse-item" href="<?php echo base_url(); ?>company/for_approval">FOR APPROVAL
                <span class="badge badge-danger badge-counter" style="right: unset!important;" id="crc2_"><?php //echo company_request_notification(); ?></span></a>
              <a  style="margin: 0 0 0 20px;" class="collapse-item" href="<?php echo base_url(); ?>company/approved">APPROVED</a>
              <!-- <hr style="margin: 10px 0 10px 0;"/> -->

              <!-- <a class="collapse-item" href="<?php //echo base_url(); ?>Company/Company_list/draft_company_list">Company Request
                <span class="badge badge-danger badge-counter" style="right: unset!important;"><?php //echo company_request_notification();
                ?></span>
              </a> -->
              <!-- <a class="collapse-item" style="overflow: auto;" href="<?php //echo base_url(); ?>Clients/Clients">HWMS Utilities (resend credentials)</a> -->
            <?php endif; ?>
            <!-- <a class="collapse-item" href="<?php echo base_url(); ?>Company/Representative/">Representative</a>
    	      <a class="collapse-item" href="<?php echo base_url(); ?>Company/Project_type/">Project Type</a> -->
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clientscollaps" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-archway"></i>
            <span>Client System</span>
          </a>
          <div id="clientscollaps" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php if ( $_SESSION['add_user_rights_with_role'] == 'yes'): ?>
                <a class="collapse-item" href="<?php echo base_url(); ?>Clients/Smr">SMR Utilities</a>
              <?php endif; ?>
              <a class="collapse-item" href="<?php echo base_url(); ?>client/lists">Client List</a>
              <!-- <a class="collapse-item" href="<?php echo base_url(); ?>Company/Representative/">Representative</a>
              <a class="collapse-item" href="<?php echo base_url(); ?>Company/Project_type/">Project Type</a> -->
            </div>
          </div>
        </li>

        <?php if($_SESSION['superadmin_rights'] == 'yes') { ?>
           <li class="nav-item">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#orderPaymentList" aria-expanded="true" aria-controls="collapseTwo">
                 <i class="fas fa-money-bill-wave-alt"></i>
                 <span>Payment System</span>
               </a>
               <div id="orderPaymentList" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?=base_url('payment/main/utilities')?>">Utilities</a>
                    <a class="collapse-item" href="<?=base_url('payment/main')?>">Order of Payment</a>
                 </div>
               </div>
            </li>
         <?php } ?>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#universeSidebarCollapse" aria-expanded="true" aria-controls="universeSidebarCollapse">
          <!-- <i class="fab fa-galactic-senate"></i> -->
          <i class="fas fa-globe-asia"></i>
          <span>Universe</span>
        </a>
        <div id="universeSidebarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url('Universe/Universe/permitting');?>">Permitting</a>
            <!-- <a class="collapse-item" href="#">Monitoring</a>
            <a class="collapse-item" href="#">OD/ORD</a>
            <a class="collapse-item" href="#">EEIU</a>
            <a class="collapse-item" href="#">Administrative</a>
            <a class="collapse-item" href="#">Finance</a>
            <a class="collapse-item" href="#">Legal</a>
            <a class="collapse-item" href="#">LAB/BAC/Others</a> -->
            <?php
              if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['universe_admin'] == 'yes')
              {
                echo '<a class="collapse-item" href="#">Daily Report</a>';
                echo '<hr style="margin: 10px 0 10px 0;"/>';
                echo '<h5 class="collapse-header">Online Sites Data:</h5>';
                echo '<a class="collapse-item" href="'.base_url("Online/Pcb").'">PCB</a>';
                echo '<a class="collapse-item" href="'.base_url("Online/Main/ecc").'">ECC</a>';
                echo '<a class="collapse-item" href="'.base_url("Online/Main/transporter").'">Transporter</a>';
                echo '<a class="collapse-item" href="'.base_url("Online/Main/registered_tsd").'">Treater</a>';
                echo '<a class="collapse-item" href="'.base_url("Online/Main/hw_generators").'">Generators</a>';
              }
              echo '<hr style="margin: 10px 0 10px 0;"/>';
              echo '<h5 class="collapse-header">Accomplishments:</h5>';
              echo '<a style="margin: 0 0 0 12px;" class="collapse-item" href="'.base_url('Universe/Universe/accomp_all').'">Summary</a>';
              echo '<hr style="margin: 10px 0 10px 0;"/>';

              echo '<h5 class="collapse-header">Statistics:</h5>';
              echo '<a style="margin: 0 0 0 12px;" class="collapse-item" href="'.base_url('universe/statistics').'">Dashboard</a>';

              if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['inbox_monitoring'] == 'yes' || $_SESSION['universe_admin'] == 'yes')
              {
                echo '<a style="margin: 0 0 0 12px;" class="collapse-item" href="'.base_url('universe/dms-monitoring').'">Inbox Monitoring</a>';
                echo '<div class="collapse-divider"></div>';
              }
              // personal > daily
              // All
              // Section Summary
              // Division Summary
              // Regional Summary
            ?>
          </div>
        </div>
      </li>
  <?php } ?>
    <?php if ($_SESSION['tofunc'] == 'yes') { ?>
      <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['to_ticket_request'] == "yes" || $_SESSION['to_view_all_approved'] == "yes" || $_SESSION['to_approver'] == "yes"){ ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#toSidebarCollapse" aria-expanded="true" aria-controls="toSidebarCollapse">
            <i class="fas fa-fw fa-plane"></i>
            <span>Travel Order</span>
            <span class="badge badge-danger badge-counter" style="right: unset!important;" id="toc_">
              <?php
                // get_instance()->load->helper('common_helper');
                // $tocount = to_total_count();
                // echo ($tocount > 0) ? $tocount : 0;
              ?>
            </span>
          </a>
          <div id="toSidebarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#toSidebarCollapse">
            <div class="bg-white py-2 collapse-inner rounded">

              <a class="collapse-item" href="<?php echo base_url('travel/dashboard');?>">My Travel Order</a>

              <?php if($_SESSION['to_approver'] == "yes"){ ?>
                <a class="collapse-item" href="<?php echo base_url('travel/forapproval');?>">
                  <span>For Approval</span>
                  <span class="badge badge-danger badge-counter" style="float:right;margin-top:3px;" id="tofa_">
                    <?php
                        // get_instance()->load->helper('common_helper');
                        // $tocount = to_forapproval();
                        // echo ($tocount > 0) ? $tocount : 0;
                    ?>
                  </span>
                </a>

              <?php } ?>

              <?php if($_SESSION['func'] == 'Regional Director' AND $_SESSION['region'] == 'R7'){ ?>
                <a class="collapse-item" href="<?php echo base_url('travel/forapprovalred');?>">
                  <span>For RED's Approval</span>
                </a>
              <?php } ?>

              <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['to_view_all_approved'] == "yes"){ ?>
              <a class="collapse-item" href="<?php echo base_url('travel/allapproved');?>">All Approved TO</a>
              <?php } ?>

              <?php if($_SESSION['superadmin_rights'] == 'yes' || $_SESSION['to_ticket_request'] == "yes"){ ?>
              <a class="collapse-item" href="<?php echo base_url('travel/ticket');?>">
                <span>Ticket Requests</span>
                <span class="badge badge-danger badge-counter" style="float:right;margin-top:3px;" id="tot_">
                  <?php
                    // get_instance()->load->helper('common_helper');
                    // $toticketcount = to_ticketrequest();
                    // echo ($toticketcount > 0) ? $toticketcount : 0;
                  ?>
                </span>
              </a>
              <?php } ?>

            </div>
          </div>
        </li>
      <?php }else{ ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>travel/dashboard">
            <i class="fas fa-fw fa-plane"></i>
            <span>Travel Order</span></a>
        </li>
      <?php } ?>

    <?php } ?>
<?php if($this->session->userdata('office') == 'EMB'){ ?>
    <?php if($_SESSION['superadmin_rights'] == 'yes'  OR $_SESSION['sw_selectevaluator'] == 'yes' OR $_SESSION['sw_selectswemployee'] == 'yes' OR $_SESSION['access_sweet_settings'] == 'yes' OR $_SESSION['func'] == 'Regional Director' OR $this->session->userdata('divno') == '13'){ ?>
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#swmsidebarCollapse" aria-expanded="true" aria-controls="swmsidebarCollapse">
            <!-- <i class="fas fa-fw fa-book"></i> -->
            <i class="fas fa-recycle"></i>
            <span>SWM</span>
            <?php if($_SESSION['sw_selectevaluator'] == 'yes'){ ?>
              <span class="badge badge-danger badge-counter" style="right: unset!important;" id="sfc_">
                <?php
                    // get_instance()->load->helper('common_helper');
                    // $swmforapprovalcount = swm_forapproval_cnt();
                    // echo ($swmforapprovalcount > 0) ? $swmforapprovalcount : 0;
                ?>
              </span>
            <?php } ?>
          </a>
          <div id="swmsidebarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#swmsidebarCollapse">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php if($this->session->userdata('divno') != '14'){ ?>
                <a class="collapse-item" href="<?php echo base_url('swm/dashboard');?>">SWEET-ENMO</a>
              <?php } ?>
              <?php if($this->session->userdata('superadmin_rights') == 'yes' OR $this->session->userdata('userid') == '601' OR $this->session->userdata('divno') == '13'){ ?>
                <a class="collapse-item" href="<?php echo base_url('swm/reports');?>">ALL ENMO REPORTS</a>
              <?php } ?>
            </div>
          </div>
      </li>
    <?php } ?>

    <?php if($_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['qrcode_docs'] == 'yes'){ ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>iisqrcode">
          <i class="fas fa-fw fa-qrcode"></i>
          <span>IIS with QR Code</span></a>
      </li>
    <?php } ?>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Others
    </div>
    <?php if($_SESSION['superadmin_rights'] == 'yes' OR $_SESSION['client_log'] == 'yes'){ ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>Logs">
          <i class="fas fa-fw fa-users"></i>
          <span>Visitor's Log</span></a>
      </li>
    <?php } ?>
    <?php if($_SESSION['region'] == 'R7') { ?>
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#otherSitesCollapse" aria-expanded="true" aria-controls="otherSitesCollapse">
            <i class="fas fa-fw fa-book"></i>
            <span>Other Sites</span>
          </a>
          <div id="otherSitesCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h5 class="collapse-header">External:</h5>
              <a class="collapse-item" href="http://7.emb.gov.ph/emb7is/" target="_blank" title="WORK-FROM-HOME ACCESS">EMB7IS (WFH Access)</a>
              <a class="collapse-item" href="http://7.emb.gov.ph/smr/" target="_blank">[OLD] SMR</a>
              <a class="collapse-item" href="https://iis.emb.gov.ph/smr/" target="_blank">[NEW] SMR</a>
              <a class="collapse-item" href="http://7.emb.gov.ph/emb/" target="_blank">[OLD] ER</a>
              <a class="collapse-item" href="http://7.emb.gov.ph:93/records" target="_blank">[OLD] Records</a>
              <a class="collapse-item" href="http://7.emb.gov.ph:5000" target="_blank">File Server</a>
              <a class="collapse-item" href="https://iis.emb.gov.ph/crs/" target="_blank">CRS</a>
              <hr style="margin: 10px 0 10px 0;"/>
              <h5 class="collapse-header">Internal:</h5>
              <a class="collapse-item" href="http://192.168.100.10/emb7is" target="_blank" title="IN-THE-OFFICE ACCESS">EMB7IS (ITO Access)</a>
              <a class="collapse-item" href="http://192.168.100.7:93/records" target="_blank" title="IN-THE-OFFICE ACCESS">RECORDS (ITO Access)</a>

              <?php
                // echo '';
                // echo '';
                // echo '<a style="margin: 0 0 0 20px;" class="collapse-item" href="'.base_url('Universe/Universe/accomp_all').'">Summary</a>';
                // echo '<hr style="margin: 10px 0 10px 0;"/>';
                // echo '<div class="collapse-divider"></div>';
              ?>
            </div>
          </div>
      </li>
    <?php } ?>

    <?php if($this->session->userdata('office') == 'EMB'){ ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>downloadables">
        <i class="fa fa-download" aria-hidden="true"></i>
        <span>Downloadables </span></a>
      </li>
    <?php } ?>

    <?php if($this->session->userdata('region') == 'R7'){ ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>vehicle/tickets">
        <i class="fa fa-car" aria-hidden="true"></i>
        <span>Vehicle</span></a>
      </li>
    <?php } ?>
      <!-- Divider -->
<?php } ?>
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url(); ?>PhotoGallery">
  <i class='far fa-image'></i>
  <span>Gallery</span></a>
</li>
  <hr class="sidebar-divider">
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->
