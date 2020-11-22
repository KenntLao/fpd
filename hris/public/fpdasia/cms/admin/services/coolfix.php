<?php
  session_start();
  include __DIR__."/../../config.php";

  if ($_COOKIE['role']!='Admin') {
    header('location: ../../login.php');
  }
    if(empty($_COOKIE['idname'])) { 
      header('location: ../../login.php');
  } 
 ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <link rel="shortcut icon" href="../../../Gallery of Website/Logo/Company Logo.png" />
  <title>FPD Asia Property Services Inc.</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../admin-css/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admin-css/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../admin-css/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin-css/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../admin-css/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../admin-css/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../admin-css/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../admin-css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../admin-css/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../admin-css/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini fixed">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">FPD</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">FPD Asia</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../admin-css/dist/img/avatars.png" class="user-image" alt="User Image">
               <?php 
              $sql="SELECT * FROM table_admin WHERE id=".$_COOKIE['idname'];
              $result=mysqli_query($con,$sql);
              $data=mysqli_fetch_assoc($result);
              
              ?>
              <span class="hidden-xs"><?php echo $data['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../admin-css/dist/img/avatars.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $data['username']; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="../profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="../../logout.php">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../admin-css/dist/img/avatars.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <?php 
              $sql="SELECT * FROM table_admin WHERE id=".$_COOKIE['idname'];
              $result=mysqli_query($con,$sql);
              $data=mysqli_fetch_assoc($result);
              
              ?>
          <p><?php echo $data['username']; ?></p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="../dashboard.php">
            <i class="fa fa-dashboard"></i> 
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="../home-slider/home-slider.php">
            <i class="fa fa-book"></i> 
            <span>Home</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> 
            <span>Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="engineering.php">
                <i class="fa fa-circle-o"></i>
                Engineering Service
              </a>
            </li>
            <li>
              <a href="coolfix.php">
                <i class="fa fa-circle-o"></i> 
                Coolfix
              </a></li>
          </ul>
        </li>
        <li>
        <a href="../property-management/property-management.php">
          <i class="ion ion-folder"></i> 
          <span>Properties</span>
        </a>
        </li>
        <li>
          <a href="../gallery/gallery.php">
            <i class="fa fa-image"></i> 
            <span>Gallery</span>
          </a>
        </li>
        <li>
          <a href="../news-and-updates/news-and-updates.php">
            <i class="fa fa-newspaper-o"></i> 
            <span>News and Updates</span>
          </a>
        </li>  
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> 
            <span>Careers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../careers/careers.php">
                <i class="fa fa-circle-o"></i>
                Position
              </a>
            </li>
            <li>
              <a href="../careers/applicants.php">
                <i class="fa fa-circle-o"></i> 
                Applicants
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="../create-admin.php">
            <i class="ion-person-add"></i> 
            <span>Add Admin</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="text-danger">
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Coolfix</li>
      </ol>
    </section>

  <!-- form gallery upload start -->
  <section class="content">
    <div class="row">
  
 <form action="coolfix-upload.php" method="post" enctype="multipart/form-data" name="addroom">
  <?php if (isset($_GET['success'])) {
    echo '  
<div class="col-md-5" id="alerts" style=" z-index: 999; width: 50%;">
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Success!</h4>Image added.</div>
</div>';
  } ?>
 <div class="form-group col-md-10">
    <label class="text-left font-weight-bold">Coolfix Icon</label>
    <input type="file" name="c_icon" class="form-control bg-light" placeholder="Image">
  </div>
  <div class="form-group col-md-10">
    <label class="text-left font-weight-bold">Coolfix Name</label>
    <input type="name" name="c_name" class="form-control bg-light">
  </div>

  <div class="form-group col-md-10">
    <label class="text-left font-weight-bold">Coolfix Description</label>
    <textarea type="text" name="c_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 120px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
  </div>



  <div class="form-group col-md-10">
  <button type="submit" class="btn btn-danger px-5" name="submit" value="Upload">Upload</button>
</div>
</form>   
    
      <div class="box-body">
        <table class="table table-bordered table-hover" style="background-color: white;">
          <tr>
            <th>Icon</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
    
        <?php

      $sql = "SELECT * FROM table_coolfix WHERE c_deleted IS NULL and c_id ORDER BY c_id DESC ";
      $result = mysqli_query($con, $sql);


        while($fetch = mysqli_fetch_array($result)){
          $c_icon = $fetch['c_icon'];
          $c_name = $fetch['c_name'];
          $c_description = $fetch['c_description'];
    ?>
    <tr><td width="auto">
          <img src="coolfix-image/<?php echo $c_icon; ?>" width="auto"></td>
          <td><h4><?php echo $c_name; ?></h4>
          <p><?php echo $c_description; ?></p></td>

    <?php
          echo '<td><a class="btn btn-danger" href=news-and-updates-delete-function.php?c_id=' . $fetch['c_id'] . '">Delete</a>';
          echo '<a class="btn btn-primary" href="engineering-edit.php?c_id=' . $fetch['c_id'] . '">Edit</a></td></tr>';
              }
    ?>
    </table>
    </div>
    </div>
  </section>
  </div>

  <!-- form gallery upload end -->
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <span>Powered by </span><a href="https://socialconz.com"> SocialConz Digital</a>.
    </div>
    <strong>&copy; 2019 FPD Asia Property Services, Inc. </strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../admin-css/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../admin-css/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../admin-css/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../admin-css/bower_components/raphael/raphael.min.js"></script>
<script src="../admin-css/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../admin-css/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../admin-css/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../admin-css/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../admin-css/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../admin-css/bower_components/moment/min/moment.min.js"></script>
<script src="../admin-css/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../admin-css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../admin-css/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../admin-css/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../admin-css/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../admin-css/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../admin-css/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../admin-css/dist/js/demo.js"></script>

</body>
</html>
