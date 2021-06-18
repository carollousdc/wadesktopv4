<?php if (!isset($_SESSION['id'])) {
  header("location: login");
}
?>
<?php
$dataUser = "";
if (isset($_SESSION['id'])) {
  $dataUser = $this->user->getUser($_SESSION['id']);
}

if (empty($dataUser->picture)) {
  ($dataUser->gender) ? $profileImage = "asset/img/avatar3.png" : $profileImage = "asset/img/avatar5.png";
} else {
  $profileImage = 'file/' . $dataUser->picture;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title id='title'><?= $engine->short_name; ?> | <?= (isset($menu->name)) ? $menu->name : $menu; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="google-site-verification" content="YZvCEggd_qGvIV2ZUlw6UiRIicMOgJ8h0nN0w8db_14" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset/admin/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="asset/admin/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="asset/admin/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="asset/admin/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="asset/admin/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="asset/admin/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="asset/admin/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="shortcut icon" href="asset/img/logo/<?= $engine->logo; ?>">
  <!-- CSS of Content -->
  <link rel="stylesheet" href="asset/admin/select2/css/select2.min.css">
  <link rel="stylesheet" href="asset/admin/chart.js/chart.min.css">
  <link rel="stylesheet" href="asset/admin/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="asset/admin/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="asset/admin/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="asset/admin/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
  <!-- Sweet Alert -->
  <link rel="stylesheet" href="asset/admin/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="asset/admin/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <link rel="stylesheet" href="asset/css/mycss.css">
  <?= isset($cssFile) ? $cssFile : ""; ?>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav" id="callnavtop">
      </ul>
      <ul class="navbar-nav ml-auto">
        <!-- <a class="nav-link" href="#">
          <span class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;Hapus</span>
        </a> -->
        <p id='time' class="h6"></p>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="dashboard" class="brand-link">
        <img src="asset/img/logo/<?= $engine->logo; ?>" alt="SAPCoRP Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $engine->name ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="file/<?= $dataUser->picture ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="profile" class="d-block"><?php echo $dataUser->firstname . " " . $dataUser->lastname; ?></a>
          </div>
        </div>
        <nav class="mt-2">
          <ul id="nav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          </ul>
        </nav>
      </div>
      <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?= (isset($masterMenu->name)) ? $masterMenu->name : "" ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= (isset($menu->link)) ? $menu->link : '' ?>"><?= (isset($menu->name)) ? $menu->name : $menu; ?></a></li>
                <li class="breadcrumb-item active">Index</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>