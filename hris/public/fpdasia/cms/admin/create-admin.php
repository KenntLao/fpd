<?php 
session_start();
  include __DIR__."/../config.php";

if ($_COOKIE['role']!='Admin') {
    header('location: ../login.php');
  }
  if(empty($_COOKIE['idname'])) { 
      header('location: ../login.php');
      exit();
  } ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../Gallery of Website/Logo/Company Logo.png" />
  <title>FPD Asia Property Services Inc.</title>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php  include __DIR__.'/admin-script.php'; ?> 
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
              <img src="admin-css/dist/img/avatars.png" class="user-image" alt="User Image">
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
                <img src="admin-css/dist/img/avatars.png" class="img-circle" alt="User Image">

                <p>
                 <?php echo $data['username']; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                 
                  <a class="btn btn-default btn-flat" href="../logout.php">Logout</a>
        
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
          <img src="admin-css/dist/img/avatars.png" class="img-circle" alt="User Image">
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
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> 
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="home-slider/home-slider.php">
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
              <a href="services/engineering.php">
                <i class="fa fa-circle-o"></i>
                Engineering Service
              </a>
            </li>
            <li>
              <a href="services/coolfix.php">
                <i class="fa fa-circle-o"></i> 
                Coolfix
              </a></li>
          </ul>
        </li>
        <li>
        <a href="property-management/property-management.php">
          <i class="ion ion-folder"></i> 
          <span>Properties</span>
        </a>
        </li>
        <li>
          <a href="gallery/gallery.php">
            <i class="fa fa-image"></i> 
            <span>Gallery</span>
          </a>
        </li>
        <li>
          <a href="news-and-updates/news-and-updates.php">
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
              <a href="careers/careers.php">
                <i class="fa fa-circle-o"></i>
                Position
              </a>
            </li>
            <li>
              <a href="careers/applicants.php">
                <i class="fa fa-circle-o"></i> 
                Applicants
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="create-admin.php">
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

      <h1>
        Add Admin
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Admin</li>
      </ol>
       <!-- Small boxes (Stat box) -->
      <div class="row">
        <form  method="post" action="create-function.php"  class="col-sm-8">
             <div class="form-group"> 
            <h3 class="text-success">
    <?php if (isset($_GET['success'])) {
    echo '  
          <div class="col-md-5" id="alerts" style=" z-index: 999; width: 90%;">
          <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>User added.</div>
          </div>';
  } ?>
              
            </h3>
              </div>
            <h2 class="text-danger">Create Admin</h2>
             <div class="form-group">
            <span>Username</span>
            <input type="name" name="username" class="form-control" required/>
            </div>
            <div class="form-group">
            <span>Role</span>
            <select class="form-control" name="role"  required>

                <option selected >Choose...</option>
                 <option value="Admin">Admin</option>
                 <option value="HR">HR</option>
                 <option value="Marketing">Marketing</option>

            </select>
            </div>
            <div class="form-group">
            <span>Password</span>
            <input type="password" name="password" class="form-control" required/>
            </div>
            <a href="create-admin.php"><input type="submit" name="create_admin" value="Create User" class="btn btn-danger"></a><br><br>
  
    </form>
      <div class="box-body">
        <table class="table table-bordered table-hover" style="background-color: white;">
          <tr>
            <th >Username</th>
            <th>Role</th>
          </tr>
    
        <?php

      $sql = "SELECT * FROM table_admin WHERE temp_del = 0 AND  id ORDER BY id DESC ";
      $result = mysqli_query($con, $sql);


        while($fetch = mysqli_fetch_array($result)){
          $username = $fetch['username'];
          $role = $fetch['role'];
    ?>
    <tr>  
          <td><?php echo $username; ?></td>
          <td><?php echo $role; ?></td>
          <?php } ?>
    </table>
    </div>
    </div>
  </div>
  </section>

   
 </div>
  </div>
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

</body>
</html>
