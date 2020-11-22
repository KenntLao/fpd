<?php 
session_start();
  include __DIR__."/../config.php";

  if ($_COOKIE['role'] =='Marketing') {
    header('location: ../login.php');
  }
  if(empty($_COOKIE['idname'])) { 

      // Print an individual cookie
      header('location: ../login.php');
  } ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../Gallery of Website/Logo/Company Logo.png" />
  <title>FPD Asia Property Services Inc.</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php  include('admin-script.php') ?> 
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
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
<?php if($data['role'] == 'Admin'){ ?>
       <li><a href="home-slider/home-slider.php"><i class="fa fa-book"></i> <span>Home</span></a></li>
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
              <a href="../services/engineering.php">
                <i class="fa fa-circle-o"></i>
                Engineering Service
              </a>
            </li>
            <li>
              <a href="../services/coolfix.php">
                <i class="fa fa-circle-o"></i> 
                Coolfix
              </a></li>
          </ul>
        </li>
       <li><a href="property-management/property-management.php"><i class="ion ion-folder"></i> <span>Properties</span></a></li>
        <li><a href="gallery/gallery.php"><i class="fa fa-image"></i> <span>Gallery</span></a></li>
        <li><a href="news-and-updates/news-and-updates.php"><i class="fa fa-newspaper-o"></i> <span>News and Updates</span></a></li>
<?php } ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Careers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="careers/careers.php"><i class="fa fa-circle-o"></i>Position</a></li>
            <li><a href="careers/applicants.php"><i class="fa fa-circle-o"></i> Applicants</a></li>
          </ul>
        </li>
<?php if($data['role'] == 'Admin'){  ?>
        <li><a href="create-admin.php"><i class="ion-person-add"></i> <span>Add Admin</span></a></li>
<?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol><br><br><br>
      <div class="row">
        <?php 

 
  
  $result = mysqli_query($con,"SELECT * FROM table_admin WHERE id=".$_COOKIE['idname']."") or die(mysqli_error());
  $fetch=mysqli_fetch_assoc($result);
    if(isset($_POST['submit'])) {

        $username_new=$_POST['username'];
  
    $sql=mysqli_query($con," UPDATE table_admin SET username='$username_new' WHERE id=".$_COOKIE['idname']."");
          
        }?>
        <?php

  if (count($_POST) > 0) {
      $result = mysqli_query($con, "SELECT * from table_admin WHERE id='" . $_COOKIE['idname'] . "'");
      $fetch = mysqli_fetch_array($result);
      $currentPassword=md5($_POST["currentPassword"]);

    if ($currentPassword== $fetch["password"]) {
        mysqli_query($con, "UPDATE table_admin set password='" . md5($_POST["newPassword"]) . "' WHERE id='" . $_COOKIE["idname"] . "'");
        $message = "Password Changed";
    } else
        $message = "Current Password is not correct";
}
?>

<script>
function validatePassword() {
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.currentPassword;
newPassword = document.frmChange.newPassword;
confirmPassword = document.frmChange.confirmPassword;

if(!currentPassword.value) {
  currentPassword.focus();
  document.getElementById("currentPassword").innerHTML = "required";
  output = false;
}
else if(!newPassword.value) {
  newPassword.focus();
  document.getElementById("newPassword").innerHTML = "required";
  output = false;
}
else if(!confirmPassword.value) {
  confirmPassword.focus();
  document.getElementById("confirmPassword").innerHTML = "required";
  output = false;
}
if(newPassword.value != confirmPassword.value) {
  newPassword.value="";
  confirmPassword.value="";
  newPassword.focus();
  document.getElementById("confirmPassword").innerHTML = "not same";
  output = false;
}   
return output;
}
</script>
  <div class="col-md-9">
    <form name="frmChange" method="post" action=""  onSubmit="return validatePassword()">
            <h2 class="text-danger"><?php if(isset($message)) { echo $message; } ?></h2>
             <div class="form-group">
            <span>Username</span>
            <input type="name" name="username" value="<?=$fetch['username']?>" class="form-control" />
            </div>
            <div class="form-group">
            <span>Current Password</span>
            <input type="password" name="currentPassword" class="form-control" />
            </div>
            <div class="form-group">
            <span>New Password</span>
            <input type="password" name="newPassword"  class="form-control" />
            </div>
            <div class="form-group">
            <span>Confirm Password</span>
            <input type="password" name="confirmPassword"  class="form-control" />
            </div>
            <input type="submit" name="submit" value="Update Profile" class="btn btn-danger">
  
    </form>
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
