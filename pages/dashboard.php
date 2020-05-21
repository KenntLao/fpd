<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// clear sessions from forms
    clearSessions();

    // check account mode if valid
    checkAccountMode("app", $permission_message_1);
	
	// set page
	$page = 'dashboard';
	
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
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/sidebar.php');
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

                    // renderReminder('collection');
					?>
					
					<div class="row">
						
						<!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'user') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white p-3 h-100 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Pre Operations</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/My Account.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

                        <!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'employee') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white p-3 h-100 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Property Profile</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/My Account.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'user' || $_SESSION['sys_account_mode'] == 'employee') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white p-3 h-100 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Operations</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Operations.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'user') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white h-100 p-3 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Post Operations</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Post Operations.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'user') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white h-100 p-3 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Report</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Report.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'user' || $_SESSION['sys_account_mode'] == 'employee') {
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
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Helpdesk.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- ACTIVE PROPERTIES -->
						<?php
						if($_SESSION['sys_account_mode'] == 'user') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white h-100 p-3 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>Marketplace</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Marketplace.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php
						if($_SESSION['sys_account_mode'] == 'user') {
							$sql = $pdo->prepare("SELECT id, status FROM properties WHERE status = 0");
							$sql->execute();
							$active_properties = $sql->rowCount();
							?>
							<div class="col-sm-6 col-md-4 mb-3">
								<div class="bg-white h-100 p-3 position-relative">
									<div class="row">
										<div class="col-8 position-relative">
											<div class="bottom-left">
												<h3>System</h3>
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/System.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						
						<?php
						if($_SESSION['sys_account_mode'] == 'user' || $_SESSION['sys_account_mode'] == 'employee') {
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
											</div>
										</div>
										<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/icons/Settings.png" width="100%">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						
					</div><!-- row -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script>
    $(function(){
    });
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
    // load reminders
    //     $.post('/load-reminders', {

    //     }, function(data) {
    //         alert(data);
    //     });
    // // 
	</script>
</body>

</html>
<?php
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>