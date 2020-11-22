<?php 
  session_start();
  include __DIR__."/../../config.php";

  if ($_COOKIE['role'] == 'Marketing') {
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
  <!-- DataTables -->
  <link rel="stylesheet" href="../admin-css/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../admin-css/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                    <a href="../../logout.php" class="btn btn-default btn-flat">Sign out</a>
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
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <?php if($data['role'] == 'Admin'){?>
                <li><a href="../home-slider/home-slider.php"><i class="fa fa-book"></i> <span>Home</span></a></li>
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
                            <a href="../services/engineering.php"><i class="fa fa-circle-o"></i>Engineering Service</a>
                        </li>
                        <li>
                            <a href="../services/coolfix.php"><i class="fa fa-circle-o"></i>Coolfix</a>
                        </li>
                    </ul>
                </li>
                <li><a href="../property-management/property-management.php"><i class="ion ion-folder"></i> <span>Properties</span></a></li>
                <li><a href="../gallery/gallery.php"><i class="fa fa-image"></i> <span>Gallery</span></a></li>
                <li><a href="../news-and-updates/news-and-updates.php"><i class="fa fa-newspaper-o"></i> <span>News and Updates</span></a></li>   
                <?php } ?>   
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book"></i> <span>Careers</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="careers.php"><i class="fa fa-circle-o"></i>Position</a></li>
                        <li><a href="applicants.php"><i class="fa fa-circle-o"></i> Applicants</a></li>
                    </ul>
                </li>
                <?php if($data['role'] == 'Admin'){ ?>
                <li><a href="../create-admin.php"><i class="ion-person-add"></i> <span>Add Admin</span></a></li>
                <?php } ?>
            </ul>
        </section>
        <!-- /.sidebar -->

    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Applicant/s<small>Control panel</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Careers</li>
            </ol>
        </section>  

        <section class="content-body" style="margin-left: 2%;">

            <div class="row">

                <div class="box box-default">

                    <div class="box-header"><h3>All Applicant</h3></div>
                    <div style="margin-left: 2%;">        
                        <a href="../../clients-print.php?type=export" class="btn btn-danger">Export</a>
                        <a href="../../clients-print.php?type=print" class="btn btn-warning">Print</a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Number</th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Files <small class="text-muted"> (click file to save)</small></th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM table_careers_application WHERE deleted_app IS NULL and careers_app_id ORDER BY careers_app_id DESC ";
                                $result = mysqli_query($con, $sql);
                                while($fetch = mysqli_fetch_array($result)){
                                $careers_app_fname = $fetch['careers_app_fname'];
                                $careers_app_lname = $fetch['careers_app_lname'];
                                $careers_app_email = $fetch['careers_app_email'];
                                $careers_app_number = $fetch['careers_app_number'];
                                $careers_app_gender = $fetch['careers_app_gender'];
                                $careers_app_position = $fetch['careers_app_position'];
                                $careers_app_file = $fetch['careers_app_file'];
                                $date_apply = $fetch['date_apply'];
                                ?>  
                                    <tr>
                                        <td>
                                            <p>
                                                <?php echo $careers_app_fname; ?> 
                                                <?php echo $careers_app_lname; ?>
                                            </p>
                                        </td>
                                        <td><?php echo $careers_app_email; ?></td>
                                        <td><?php echo $careers_app_number; ?></td>
                                        <td><?php echo $careers_app_gender; ?></td>
                                        <td><?php echo $careers_app_position; ?></td>
                                        <td>
                                            <a href="../../../career-application/<?php echo $careers_app_file ?>"><?php echo $careers_app_file ?></a>
                                        </td>
                                        <td><?php echo date('F j, Y', strtotime($date_apply)); ?></td>
                                        <td><?php echo '<a class="btn btn-danger" href="applicants-delete.php?applicant_id=' . $fetch['careers_app_id'] . '">Delete</a>'; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

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

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
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
<!-- DataTables -->
<script src="../admin-css/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../admin-css/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../admin-css/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../admin-css/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function(){
        $(document).ready(function() {
            $('#example1').DataTable();
        });
    });
</script>
</body>
</html>
