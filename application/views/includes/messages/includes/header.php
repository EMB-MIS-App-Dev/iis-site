<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no">
        <title>EMB Messenger</title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-denr.png">
        <!-- Template core CSS -->
        <link href="<?php echo base_url(); ?>assetsmsgs/css/template.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/common/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/common/selectize/dist/css/selectize.bootstrap3.css" rel="stylesheet">
    </head>

    <body>

        <div class="layout">

            <!-- Navbar -->
            <div class="navigation navbar navbar-light justify-content-center py-xl-7" style="background-color: #08507E;">

                <!-- Brand -->
                <a href="#" class="d-none d-xl-block mb-6">
                    <img src="<?php echo base_url(); ?>assets/images/logo-denr.png" class="mx-auto fill-primary" data-inject-svg="" alt="" style="height: 46px;">
                </a>

                <!-- Menu -->
                <ul class="nav navbar-nav flex-row flex-xl-column flex-grow-1 justify-content-between justify-content-xl-center py-3 py-lg-0" role="tablist">

                    <!-- Invisible item to center nav vertically -->
                    <li class="nav-item d-none d-xl-block invisible flex-xl-grow-1">
                        <a class="nav-link position-relative p-0 py-xl-3" href="#" title="">
                            <i class="icon-lg fe-x"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link position-relative p-0 py-xl-3" href="<?php echo base_url(); ?>" title="Dashboard" role="tab">
                            <i class="icon-lg fa fa-home"></i>
                        </a>
                    </li>

                    <?php if($_SESSION['userid'] == '1' OR $_SESSION['userid'] == '468'){ ?>
                    <!-- Create group -->
                    <li class="nav-item mt-xl-9">
                        <a class="nav-link position-relative p-0 py-xl-3" data-toggle="tab" href="#tab-content-create-chat" onclick="crtcht();" title="Create group chat" role="tab">
                            <i class="icon-lg fe-users">+</i>
                        </a>
                    </li>
                    <?php } ?>

                    <!-- Chats -->
                    <li class="nav-item mt-xl-9">
                        <a class="nav-link position-relative p-0 py-xl-3 active" data-toggle="tab" href="#tab-content-dialogs" title="Chats" role="tab">
                            <i class="icon-lg fe-message-square"></i>
                            <div class="badge badge-dot badge-primary badge-bottom-center" id="newchatdot" style="display:none;"></div>
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="nav-item mt-xl-9">
                        <a class="nav-link position-relative p-0 py-xl-3" data-toggle="tab" href="#tab-content-user" onclick="pflvw();" title="Profile" role="tab">
                            <i class="icon-lg fe-user"></i>
                        </a>
                    </li>

                </ul>
                <!-- Menu -->

            </div>
            <!-- Navbar -->
