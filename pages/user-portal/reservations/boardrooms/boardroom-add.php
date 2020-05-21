<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-boardrooms";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($boardrooms_new_reservation); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/user-portal.css">
	
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
							<h1><i class="far fa-calendar-minus mr-3"></i><?php echo renderLang($boardrooms_new_reservation); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_boardroom_add_suc');
					?>
					
					<form method="post" action="/submit-user-boardroom-add">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($boardrooms_new_reservation_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- TIME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time"><?php echo renderLang($boardrooms_time); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right" name="time" id="time"<?php if(isset($_SESSION['sys_user_boardroom_add_time_val'])) { echo ' value="'.$_SESSION['sys_user_boardroom_add_time_val'].'"'; } ?>>
											</div>
										</div>
									</div>
					
									<!-- department -->
									<div class="col-lg-3 col-md-4">
										<label for="department"><?php echo renderLang($boardrooms_department); ?></label>
										<input type="text" class="form-control" name="department" <?php if(isset($_SESSION['sys_user_boardroom_add_department_val'])) { echo ' value="'.$_SESSION['sys_user_boardroom_add_department_val'].'"'; } ?>>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($boardrooms_purpose); ?></label>
										<input type="text" class="form-control" name="purpose" <?php if(isset($_SESSION['sys_user_boardroom_add_purpose_val'])) { echo ' value="'.$_SESSION['sys_user_boardroom_add_purpose_val'].'"'; } ?> >
									</div>

									
								</div><!-- row -->

								<div class="row">

									<!-- RESERVED BY -->
									<div class="col-lg-3 col-md-4">
										<label for="reserved_by"><?php echo renderLang($boardrooms_reserved_by); ?></label>
										<input type="text" class="form-control" name="reserved_by" <?php if(isset($_SESSION['sys_user_boardroom_add_reserved_by_val'])) { echo ' value="'.$_SESSION['sys_user_boardroom_add_reserved_by_val'].'"'; } ?> >
									</div>

									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/user-boardrooms" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($boardrooms_save_reservation); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>

	
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