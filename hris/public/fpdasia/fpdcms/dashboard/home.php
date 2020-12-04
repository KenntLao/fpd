<?php 
session_start();
  include __DIR__."/../functions/config.php";

  if ($_COOKIE['role']!='Admin') {
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
            <h1 class="m-0 text-dark">Home</h1>
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
     
          <div class="col-sm-8">
            <?php 
            if (isset($_GET['success'])) {
              echo ' 
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>  Success!</h5>
                  Image added.
                </div>';
            }
            if (isset($_GET['success-deleted'])) {
              echo ' 
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>  Success!</h5>
                  Image deleted.
                </div>';
                }
               ?>
          </div>
          <!-- general form elements -->
          <div class="col-sm-8">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Slider</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="../functions/slider-upload.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">Image input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="home_slider_image" class="custom-file-input" accept="image/*" id="exampleInputFile" required>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
               <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-12">
            <div class="card card-danger">
              <div class="card-header">
                <div class="card-title">
                  Slider Images
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php      
                  $sql = "SELECT * FROM table_home_slider WHERE home_slider_id ORDER BY home_slider_id DESC ";
                  $result = mysqli_query($con, $sql);
                    while($fetch = mysqli_fetch_array($result)){
                          $home_slider_image = $fetch['home_slider_image'];

                  ?>
                  <div class="col-sm-8">
                    <a href="../Assets/dashboard images/slider/<?php echo $home_slider_image; ?>" data-toggle="lightbox" data-title="" data-gallery="gallery">
                      <img src="../Assets/dashboard images/slider/<?php echo $home_slider_image; ?>" class="img-fluid mb-2" alt=""/>
                    </a>
                  </div>
                  <div class="col-sm-4 m-auto">
                    <?php
                    echo '<a class="btn btn-danger" href="../functions/slider-delete.php?home_slider_id=' . $fetch['home_slider_id'] . '">Delete</a><br>';
                    ?>
                  </div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>
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