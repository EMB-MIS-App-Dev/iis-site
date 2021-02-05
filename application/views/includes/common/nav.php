<?php if($this->session->userdata('real_user') != ''){ ?>
  <button type="button" class="btn btn-danger btn-sm" style="float:right;position:fixed;z-index:99;left:50%;border-top-left-radius:0px;border-top-right-radius:0px;" onclick=loginas('<?php echo $this->encrypt->encode($this->session->userdata('real_user')); ?>');>Return to Previous Account</button>
<?php } ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">
    <?php
      if(!empty($_SESSION['userid']) && !empty($_SESSION['acc_options'])) {
        if($_SESSION['acc_options']['sys_theme'] == 'christmas') {
          echo '<div id="santa"><img src = "'.base_url().'uploads/santa.gif" width = "100px" height ="100px"></div>';
        }
        else if($_SESSION['acc_options']['sys_theme'] == 'halloween') {
          echo '<div id="halloween"><img src = "'.base_url().'uploads/can.gif" width = "100px" height ="100px" style="margin-right:150px">  <img src = "'.base_url().'uploads/witch.gif" width = "100px" height ="100px"></div>';
        }

      }
    ?>


    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <div class="input-group">
          <!-- <span style="font-size: 9pt;font-style:italic;">For comments and technical concerns, please email r7support@emb.gov.ph</span> -->
      </div>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
          </a>
          <!-- Dropdown - Messages -->
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

    <?php if($_SESSION['to_ticket_request'] == 'yes'){ ?>
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger badge-counter" id="totalnotif"></span>
          </a>
          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
              Notifications
            </h6>
        <?php if ($this->session->userdata('userid') == '1'): ?>
          <a class="dropdown-item d-flex align-items-center" href="<?= base_url()?>/Company/Company_list/draft_company_list">
            <div class="mr-3">
              <div class="icon-circle bg-primary" style="height: auto!important;width: auto!important;padding: 2px 9px 3px 10px;">
                <span class=""  style="color:white;font-size: 12px;"> <?= $this->session->userdata('compcnt') ?></span>
              </div>
            </div>
            <div id='userdatacont'>
              <span class="font-weight-bold">CLIENT REQUESTS</span>
            </div>
          </a>
        <?php endif; ?>
      </div>
      </li>
    <?php } ?>

    <!-- ################################################      PLANNING SCHEDULER      ##################################################### -->
     <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                           <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                           <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                           <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li>
     <?php } ?>

    <?php if ($this->session->userdata('userid') == 157): ?>
         <div class="input-group">
           <?php
           get_instance()->load->helper('common_helper');
           echo region_list();
            ?>
         </div>
    <?php endif; ?>
        <div class="topbar-divider d-none d-sm-block"></div>


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name']; ?></span>
            <img class="img-profile rounded-circle" src="<?php echo $this->session->userdata('user_photo'); ?>">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo base_url('Usersettings/Usersettings/settings'); ?>">
              <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
              Option
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo base_url(); ?>Index/logout_user">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>
      <?php if($_SESSION['userid'] == '468'){ ?>
        <style media="screen">
          .float-chat-box {
            border:2px solid #c1c5d7;
            border-radius: 50px;
            height: 3rem;
            width: 3rem;
            max-height: 3rem;
            max-width: 3rem;
            min-height: 3rem;
            min-width: 3rem;
          }

          div.dvfltcl{
            position: fixed;
            top: auto;
            left: auto;
            bottom: 70px;
            right: 20px;
            width: 25%!important;
            max-width: 400px!important;
            min-width: 400px!important;
            height: auto;
            transform: translateZ(0);
            z-index: 101108;
          }
          .fltdvcntntt{
            font-size: 9pt;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-width: 200px;
            padding: 5px;
            background-color: #124E97;
            color: #FFF;
            border-radius: 5px;
          }
          .fltdvcntntw{
            font-size: 9pt;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-width: 200px;
            padding: 5px;
            background-color: #EEEFF2;
            color: #000;
            border-radius: 5px;
          }
          .dvfltcb{
            padding:0px 0px 10px 0px;
          }
          .dvfltrw{
            padding: 0px 5px 0px 5px;
          }
          .chat-lawas{
            max-height: 300px;
            overflow: scroll;
            overflow-x: hidden;
            padding-top: 10px;
            min-height: 300px;
          }

          #angmahiwagangmensahe_{
            background-color: #FFF;
            padding: 0px 10px 5px 10px;
            border: 1px solid #c1c5d7;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            max-width: 50%;
            overflow-x: scroll;
            position: fixed;
            top: auto;
            left: auto;
            bottom: 18px;
            right: 90px;
            height: auto;
            transform: translateZ(0);
            z-index: 101108;
            display: flex;
          }
          #float-chat-box-a-tag{
            margin: 5px 5px 0px 0px;
            flex: 0 0 65%;
            height: 3.5rem;
            width: 3.5rem;
            max-height: 3.5rem;
            max-width: 3.5rem;
            min-height: 3.5rem;
            min-width: 3.5rem;
          }
          #angmahiwagangmensahe_::-webkit-scrollbar-track
          {
          	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
          	background-color: #F5F5F5;
          }

          #angmahiwagangmensahe_::-webkit-scrollbar
          {
            height:5px;
          	width: 5px;
          	background-color: #F5F5F5;
          }

          #angmahiwagangmensahe_::-webkit-scrollbar-thumb
          {
          	background-color: #0C4F88;
          	border: 2px solid #0C4F88;
          }
        </style>

          <div id="angmahiwagangmensahe_"></div>
          <div style="position: fixed;top: auto;left: auto;bottom: 30px;right: 30px;width: auto;height: auto;transform: translateZ(0);z-index: 101108;">
            <a type="button" href="<?php echo base_url().'Messages'; ?>" class="btn btn-info btn-lg btn-circle" style="color:#FFF;background-color:#1A4CA9;border:none;"><span class="fa fa-envelope"></span></a>
          </div>
          <div class="col-xl-4 col-lg-5 dvfltcl" id="dvfltcl"></div>

      <?php } ?>

    </nav>



    <!-- /.container-fluid -->
    <style media="screen">
    @keyframes halloween{
        0% {

        right: 0%;
        transform: rotateY(0deg);
      }

      49% {
        transform: rotateY(0deg);
      }

      50% {
          right: 100%;
        transform: rotateY(180deg);
      }

      99% {
        transform: rotateY(180deg);
      }
        100% {
        right: 0%;
        transform: rotateY(0deg);
      }
    }
    @keyframes santa{
        0% {

        left: 0%;
        transform: rotateY(0deg);
      }

      49% {
        transform: rotateY(0deg);
      }

      50% {
          left: 100%;
        transform: rotateY(180deg);
      }

      99% {
        transform: rotateY(180deg);
      }
        100% {
        left: 0%;
        transform: rotateY(0deg);
      }
    }

    #halloween img{
          float: left;
          position: absolute;
          margin: 0px;
          z-index: 99999;
          width: 100px;
          transform: scale(1.5, 1.5);
          animation-name: halloween;
          animation-duration: 100s;
          animation-iteration-count: infinite;
          animation-timing-function: ease-in;
          pointer-events: none;
    }

    #santa img{
          float: left;
          position: absolute;
          margin: 0px;
          z-index: 99999;
          width: 100px;
          transform: scale(1.5, 1.5);
          animation-name: santa;
          animation-duration: 100s;
          animation-iteration-count: infinite;
          animation-timing-function: ease-in;
          pointer-events: none;
    }


          </style>
    <!-- <div class="container-fluid">
      <div class="alert alert-danger" role="alert" >
        <b>ATTENTION:</b> The Integrated Information System (IIS) will undergo System/Server Maintenance and Storage Expansion today, <b>January 13, 2021</b> at <b>12:00 noon</b>. Please close and finish all transactions before the said schedule to avoid data loss. Sorry for the inconvenience.
      </div>
    </div> -->

    <!-- <div class="alert alert-danger" role="alert" >
      <b>ATTENTION:</b> There is currently ongoing maintenance on the DMS Module. During this time, functions like creation and processing of IIS Transactions are unavailable, but Viewing Function is still available. Unavailable Functions are expected to be back by <b>July 1, 2020, 8:00 a.m.</b>
    </div> -->

    <!-- <div class="container-fluid">
      <div class="alert alert-warning" role="alert" >
        <b>NOTICE:</b> The Document Management System (DMS) module will undergo System Updating, <b>November 06, 2020</b>, at 10:00 p.m. to 10:30 p.m., subject to change upon further notice. Access to the said module will temporarily be denied. Please close and finish all transactions before the said schedule to avoid data loss. Sorry for the inconvenience. <b><span id="timer_cntdwn1">-</span></b>
        <p style="background-color: rgb(253,243,216) !important">
          <p>Reminding the following users to please finish any ongoing transactions with DMS before the time expires:</p>
          <ul>
            <li> Belly C. Cabeso </li>
            <li>Josephine T. Sagun</li>
            <li>Raquel Smith C. Ortega</li>
            <li>Lady Christine N. Alfonso</li>
            <li>Lady Princess M. Marquez</li>
            <li>Dulce D. Hufancia</li>
            <li>Marissa D. Malabana</li>
            <li>Rolando Z. Capistrano</li>
            <li>Jumar S. Tabita</li>
          </ul>
        </p>
      </div>
    </div> -->

    <!-- End of Topbar -->
</head>
<body>
