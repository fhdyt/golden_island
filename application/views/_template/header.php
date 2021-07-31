<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GMS
    <?php
    foreach (menu_list() as $row) {
      if ($row->APLIKASI_LINK == $this->uri->segment('1')) {
        echo " | " . $row->APLIKASI_NAMA;
      } else {
        echo "";
      }
    }
    ?>
  </title>
  <link href="<?php echo base_url(); ?>assets/favicon.png" rel="icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/flag-icon-css/css/flag-icon.min.css">
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>assets/theme/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>assets/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/theme/dist/js/adminlte.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/theme/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/theme/plugins/inputmask/jquery.inputmask.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/sweetalert.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jquery.mask.min.js" charset="utf-8"></script>
  <!-- <style>
    [class*=sidebar-dark-] {
      background-color: #000000;
    }

    [class*=sidebar-dark] .brand-link {
      border-bottom: 1px solid #000000;
    }
  </style> -->
  <style>
    .loader {
      border: 10px solid #f3f3f3;
      border-radius: 80%;
      border-top: 10px solid #343A40;
      border-bottom: 10px solid #343A40;
      width: 80px;
      height: 80px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    #loader-wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1000;
      background-color: rgba(255, 255, 255, 0.8);

      bottom: 0;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      padding: 0 0px;

    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div id="loader-wrapper">
    <h2><i class="fas fa-3x fa-sync-alt fa-spin"></i></h2>
  </div>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link menu-btn" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url(); ?>uploads/perusahaan/<?= $this->session->userdata('PERUSAHAAN_KODE') ?>.png" class="user-image " alt="User Image">
            <span class="d-none d-md-inline"><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></span>
          </a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <a class="nav-link btn-bantuan"><i class="fas fa-question-circle"></i> <?= $this->lang->line('bantuan'); ?></a>
        </li> -->
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= base_url(); ?>pengaturan" class="nav-link"><i class="fas fa-user-cog"></i> <?= $this->lang->line('pengaturan'); ?></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
          <?php
          if ($this->session->userdata('USER_BAHASA') == "bahasa") {
            $flag = "id";
            $bahasa = "Bahasa";
          } else {
            $flag = "us";
            $bahasa = "English";
          }
          ?>
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="flag-icon flag-icon-<?= $flag; ?>"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right p-0">
            <a href="#" class="dropdown-item" lang="bahasa" onclick="ganti_bahasa('bahasa')">
              <i class="flag-icon flag-icon-id mr-2"></i> Bahasa
            </a>
            <a href="#" class="dropdown-item" lang="bahasa" onclick="ganti_bahasa('english')">
              <i class="flag-icon flag-icon-us mr-2"></i> English
            </a>

          </div>
        </li>
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url(); ?>uploads/user/<?= detail_user()[0]->USER_FOTO ?>" class="user-image " alt="User Image">
            <span class="d-none d-md-inline"><?= $this->session->userdata('USER_NAMA') ?></span>
          </a>
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <!-- <span class="badge badge-danger navbar-badge">3</span> -->
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>login/logout" role="button">
            <i class="fas fa-sign-out-alt"></i> <?= $this->lang->line('keluar'); ?>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo base_url(); ?>" class="brand-link">
        <img src="<?php echo base_url(); ?>assets/header.png" alt="AdminLTE Logo" class="brand-image">
        <span class="brand-text font-weight-light"><b>GMScloud</b></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>dashboard" class="nav-link <?php if ($this->uri->segment(1) == "dashboard") {
                                                                              echo "active";
                                                                            } ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <?php
            foreach (menu_list() as $row) {
              if ($row->APLIKASI_LINK == $this->uri->segment('1')) {
                $nav = "menu-open";
              } else {
                $nav = "";
              }
            ?>
              <!-- <li class="nav-header"><?php echo $row->APLIKASI_NAMA; ?></li> -->
              <li class="nav-item <?= $nav; ?> mb-2">
                <a href="#" class="nav-link">
                  <i class="nav-icon <?php echo $row->APLIKASI_ICON; ?>"></i>
                  <p>
                    <?php echo $row->APLIKASI_NAMA; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <?php foreach ($row->MENU as $menu) {
                    if ($menu->MENU_LINK == $this->uri->segment('2')) {
                      $active = "active";
                    } else {
                      $active = "";
                    }
                  ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url(); ?><?php echo $row->APLIKASI_LINK; ?>/<?php echo $menu->MENU_LINK; ?>" class="nav-link <?= $active; ?>">
                        <i class="far fa-circle"></i>
                        <!-- <i class="<?php echo $menu->MENU_ICON; ?>"></i> -->
                        <p><?= $menu->MENU_NAMA; ?></p>
                      </a>
                    </li>
                  <?php
                  }
                  ?>
                </ul>

              </li>

            <?php } ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>