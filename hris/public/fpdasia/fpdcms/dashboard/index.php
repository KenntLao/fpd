<?php 
session_start();
  include __DIR__."/../functions/config.php";

  if ($_COOKIE['role']!='Admin' && $_COOKIE['role']!='Marketing' && $_COOKIE['role']!='HR') {
    header('location: ../login.php');
  }
  if(empty($_COOKIE['idname'])) { 

    // Print an individual cookie
      header('location: ../login.php');
  } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="shortcut icon" href="../../Gallery of Website/Logo/Company Logo.png" />

  <title>FPD Asia Property Services, Inc. | Dashboard</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-danger navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
      <li class="nav-item">
        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <i class="fas fa-user-alt"></i>
    
            </a>
            <ul class="dropdown-menu bg-danger">
              <!-- User image -->
              <li class="user-header">
                <img src="../Assets/avatars.png" class="img-circle" alt="User Image">

                <?php 
                $sql="SELECT * FROM table_admin WHERE id=".$_COOKIE['idname'];
                $result=mysqli_query($con,$sql);
                $data=mysqli_fetch_assoc($result);
                ?>

                <p><?php echo $data['username']; ?></p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
              	<div class="row">
                <div class="col-6">
                  <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="col-6">       
                  <a class="btn btn-default btn-flat" href="../logout.php">Logout</a>
                </div>
              	</div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      </li>

    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../../Gallery of Website/Logo/Company Logo.png" alt="FPD Asia Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">FPD Asia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../Assets/avatars.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        	<?php 
              $sql="SELECT * FROM table_admin WHERE id=".$_COOKIE['idname'];
              $result=mysqli_query($con,$sql);
              $data=mysqli_fetch_assoc($result); 
              ?>
          <a href="#" class="d-block"><?php echo $data['username']; ?></a>
        </div>
      </div>
        
       <?php include 'nav-side-bar.php'; ?>

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <?php 
              $sql="SELECT count(*) AS total FROM table_gallery";
              $result=mysqli_query($con,$sql);
              $data=mysqli_fetch_assoc($result);
              ?>
                <h3><?php echo $data['total']; ?></h3>

                <p>Album/s</p>
              </div>
              <div class="icon">
                <i class="ion ion-image"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php 
                $sql="SELECT count(*) AS total FROM table_careers_application";
                $result=mysqli_query($con,$sql);
                $data=mysqli_fetch_assoc($result);
                ?>
                <h3><?php echo $data['total']; ?></h3>

                <p>Applicants</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <?php 
                $sql="SELECT count(*) AS total FROM table_admin";
                $result=mysqli_query($con,$sql);
                $data=mysqli_fetch_assoc($result);
                ?>
                <h3><?php echo $data['total']; ?></h3>

                <p>Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php 
                $sql="SELECT count(enabled) AS total FROM table_job WHERE enabled='enabled'";
                $result=mysqli_query($con,$sql);
                $data=mysqli_fetch_assoc($result);
                ?>  
                <h3><?php echo $data['total']; ?></h3>

                <p>Available Position/s</p>
              </div>
              <div class="icon">
                <i class="far fa-address-card"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong><span>Powered by </span><a href="https://socialconz.com"> SocialConz Digital</a>.
    <div class="float-right d-none d-sm-inline-block">
      <strong>&copy; 2019 FPD Asia Property Services, Inc. </strong> All rights
    reserved.
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="../dist/js/pages/dashboard2.js"></script>
</body>
</html>
