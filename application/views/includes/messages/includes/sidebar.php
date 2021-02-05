<!-- Sidebar -->
<div class="sidebar">
    <div class="tab-content h-100" role="tablist">
        <div class="tab-pane fade h-100" id="tab-content-create-chat" role="tabpanel">
            <div class="d-flex flex-column h-100">
              <form action="<?php echo base_url(); ?>Messages/View/creategroup" method="POST" enctype="multipart/form-data">
                <div class="hide-scrollbar">
                    <div class="container-fluid py-6">

                        <!-- Title -->
                        <h2 class="font-bold mb-6">Create group</h2>
                        <!-- Title -->

                        <div id="createchat_"></div>

                    </div>
                </div>

                <!-- Button -->
                <div class="pb-6">
                    <div class="container-fluid">
                        <button type="submit" class="btn btn-lg btn-primary btn-block" type="submit">Create group</button>
                    </div>
                </div>
              </form>
            </div>
        </div>

        <div class="tab-pane fade h-100 show active" id="tab-content-dialogs" role="tabpanel">
            <div class="d-flex flex-column h-100">

                <div class="hide-scrollbar">
                    <div class="container-fluid py-6">

                        <!-- Title -->
                        <h2 class="font-bold mb-6">Messages
                          <div class="avatar mr-5" style="float:right;">
                            <img class="avatar-img" style="border: 4px solid #0D98C7;" src="<?php echo $this->session->userdata('user_photo'); ?>">
                          </div>
                        </h2>
                        <!-- Title -->

                        <?php if($_SESSION['userid'] == '1'){ ?>
                        <!-- Search -->
                        <form class="mb-6">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" placeholder="Search for messages or users..." aria-label="Search for messages or users...">
                                <div class="input-group-append">
                                    <button class="btn btn-lg btn-ico btn-secondary btn-minimal" type="submit">
                                        <i class="fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- Search -->
                        <?php } ?>

                        <!-- Favourites -->
                        <div class="text-center hide-scrollbar d-flex my-7" data-horizontal-scroll="">
                            <?php
                              for ($ou=0; $ou < sizeof($queryusers); $ou++) {
                                $datetime = date("Y-m-d H:i");
                                $date = date("Y-m-d");
                                $currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
                                $mname = (!empty($queryusers[$ou]['mname'])) ? $queryusers[$ou]['mname'][0].". " : "";
                                $suffix = (!empty($queryusers[$ou]['suffix'])) ? " ".$queryusers[$ou]['suffix'] : "";
                                $prefix = (!empty($queryusers[$ou]['title'])) ? $queryusers[$ou]['title']." " : "";
                                $userphoto = (!empty($queryusers[$ou]['user_photo'])) ? base_url().'uploads/profilepictures/'.$queryusers[$ou]['token'].'/'.$queryusers[$ou]['user_photo'] : base_url().'assets/images/default-user.png';
                            ?>
                            <a href="<?php echo base_url()."Messages/View/chkifcnvexst/".$this->encrypt->encode($queryusers[$ou]['userid']."||".'Single'); ?>" class="d-block text-reset mr-7 mr-lg-6">
                              <?php if ((date('H:i', strtotime($currenttimeminus5minutes)) < date('H:i', strtotime($queryusers[$ou]['timestamp']))) AND (date('Y-m-d', strtotime($queryusers[$ou]['timestamp'])) == $date)) { ?>
                                <div class="avatar avatar-sm avatar-online mb-3">
                              <?php }else{ ?>
                                <div class="avatar avatar-sm mb-3">
                              <?php } ?>
                                  </style>
                                    <img class="avatar-img" src="<?php echo $userphoto; ?>">
                                </div>
                                <div class="small" title="<?php echo ($prefix.$queryusers[$ou]['fname']." ".$mname.$queryusers[$ou]['sname'].$suffix); ?>">
                                  <?php echo $intlnam = ($queryusers[$ou]['userid'] == '1') ? "ADMIN" : strtoupper($queryusers[$ou]['fname'][0].$queryusers[$ou]['mname'][0].$queryusers[$ou]['sname'][0]); ?></div>
                            </a>
                            <?php } ?>
                        </div>
                        <!-- Favourites -->

                        <!-- Chats -->
                        <nav class="nav d-block list-discussions-js mb-n6" id="kilid_">
                        </nav>
                        <!-- Chats -->

                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade h-100" id="tab-content-user" role="tabpanel">
            <div class="d-flex flex-column h-100">

                <div class="hide-scrollbar">
                    <div class="container-fluid py-6">

                        <!-- Title -->
                        <h2 class="font-bold mb-6">Profile</h2>
                        <!-- Title -->

                        <div id="prflvw_"></div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Sidebar -->
