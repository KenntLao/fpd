<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-portal";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($dashboard_dashboard); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/dashboard.css">
	<style type="text/css">
	/* Bottom left text */
	.bottom-left {
	  position: absolute;
	  bottom: 3px;
	  left: 16px;
	}
	.see-more{
		color: #EF1B27FF;
	}
	.see-more:hover{
		color: #f24049;
	}
	.zoom {
	  transition: transform 1s;
	}
	.zoom:hover {
	  -ms-transform: scale(1.5); /* IE 9 */
	  -webkit-transform: scale(1.5); /* Safari 3-8 */
	  transform: scale(1.1); 
	}
	</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-grip-horizontal mr-3"></i><?php echo renderLang($dashboard_dashboard); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php
					renderError('sys_permission_err');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="row">
						
						<!-- ACTIVE PROPERTIES -->
						<?php
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white p-3 h-100 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>My Account</h3>
												<a class="see-more" href="">SEE MORE</a>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/My Account.png" width="100%">
										</div>
									</div>
								</div>
							</div>

						<!-- CUSTOMER SERVICE -->
						<?php
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white h-100 p-3 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Customer Service</h3>
												<a class="see-more" href="">SEE MORE</a>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Helpdesk.png" width="100%">
										</div>
									</div>
								</div>
							</div>

						<!-- SETTINGS-->
						<?php
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white h-100 p-3 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Settings</h3>
												<a class="see-more" href="">SEE MORE</a>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Settings.png" width="100%">
										</div>
									</div>
								</div>
							</div>


				
						
					</div><!-- row -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script>
		// get the highest height
      var hi = 0;
      $('.h-00').each(function(){
        var h = $(this).height();
        if(h > hi){
          hi = h;
        }    
      });
    // 
    // set the height to all class
      $('.h-00').each(function(){
        $(this).height(hi);
      });
	</script>
</body>

</html>
<?php 
	} else { // invalid account mode

		// logout to current session
		session_destroy();
		session_start();
		
		$_SESSION['sys_user_login_err'] = renderLang($permission_message_1); // "You are not authorized to access this page. Please login first."
		header('location: /user-login');
	
	}

} else { // no session found, redirect to login page
	
	$_SESSION['sys_user_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /user-login');
	
}
?>