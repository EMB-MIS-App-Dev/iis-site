<?php
  // if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") { redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); exit; }
  if(empty($_SESSION['userid'])){ echo "<script>alert('Your session has expired. Please relogin.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; } ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=1024, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>EMB - IIS (Integrated Information System)</title>

  <!-- <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-denr.png"> -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>favicon/favicon-16x16.png">
  <link rel="manifest" href="<?php echo base_url(); ?>favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/common/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->
  <link href="<?php echo base_url(); ?>assets/css/font-googleapis.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/common/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/system.css" rel="stylesheet">
  <?php
    if(!empty($_SESSION['userid']) && !empty($_SESSION['acc_options'])) {
      if($_SESSION['acc_options']['sys_theme'] == 'dark') {
        echo '<link href="'.base_url('assets/css/dark.css').'" rel="stylesheet">';
      }
      else if($_SESSION['acc_options']['sys_theme'] == 'dark2') {
        echo '<link href="'.base_url('assets/css/dark2.css').'" rel="stylesheet">';
      }
      else if($_SESSION['acc_options']['sys_theme'] == 'christmas') {
        echo '<link href="'.base_url('assets/css/xmas.css').'" rel="stylesheet"> <canvas id="xmas_canvas"></canvas>';
        echo '<div id="olaf_gif_div"><img id="olaf_gif" src="'.base_url('assets/images/themes/christmas/olaf3.gif').'" /></div>';
      }
      else if($_SESSION['acc_options']['sys_theme'] == 'halloween') {
        echo '<link href="'.base_url('assets/css/halloween.css').'" rel="stylesheet">';
        echo '<div id="dancing_bones_gif_div"><img id="dancing_bones_gif" src="'.base_url('assets/images/themes/halloween/dancing_bones.gif').'" /></div>';
      }

      if($_SESSION['acc_options']['sys_theme'] == 'halloween') {
        ?>
        <style>
          #content-wrapper{
            background-image: url('<?=base_url()?>uploads/halloween-background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            width: 100%;
            position: relative;
          }
        </style>
        <?php
      }

      if($_SESSION['acc_options']['sys_theme'] == 'christmas') {
        ?>
        <style >
          nav.navbar.navbar-expand.navbar-light.bg-white.topbar.mb-4.static-top.shadow {
            background-image: url('<?=base_url()?>assets/images/themes/christmas/snow.gif');
          }
          a.sidebar-brand.d-flex.align-items-center.justify-content-center {
            background-image: url('<?=base_url()?>assets/images/themes/christmas/snow.gif');
          }
          #content-wrapper{
            background-image: url('<?=base_url()?>assets/images/themes/christmas/xmas_bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            width: 100%;
            position: relative;
          }
        </style>
        <?php
      }
    }
  ?>
  <link href="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/common/selectize/dist/css/selectize.bootstrap3.css" rel="stylesheet">

  <!-- Custom styles for -->
  <link href="<?php echo base_url(); ?>assets/common/datatables/plugins/FixedColumns/css/fixedColumns.bootstrap4.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/common/datatables/plugins/Select-1.2.6/css/select.bootstrap4.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/common/datatables/plugins/CheckTable/css/dataTables.checkboxes.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/common/dropzone/dropzone.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/common/sweetalert2/css/sweetalert2.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/common/datatables/plugins/Buttons-1.5.4/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/common/datatables/plugins/Buttons-1.5.4/css/buttons.dataTables.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/common/chart.js/Chart.js-2.9.4//Chart.min.css" rel="stylesheet">
  <style media="screen">

  </style>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
