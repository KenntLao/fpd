<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-visitors";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($visitors_new_visitor); ?> &middot; <?php echo $sitename; ?></title>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($visitors_new_visitor); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_visitors_add_err');
					?>
					
					<form method="post" action="/submit-user-visitor-add">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($visitors_add_visitor_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

                                    <!-- DATE -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($lang_date); ?></label>
											<input type="text" class="form-control input-readonly" readonly value="<?php echo formatDate(time(), true, false); ?>">
										</div>
									</div>
									
									<!-- TIME IN -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_in"><?php echo renderLang($visitors_time_in); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right input-readonly" name="time_in" id="time_in" value="<?php echo $curr_time; ?>" required readonly>
											</div>
										</div>
									</div>

									<!-- TIME OUT -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_out"><?php echo renderLang($visitors_time_out); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right" name="time_out">
											</div>
										</div>
									</div>

									<!-- NAME OF VISITORS -->
									<div class="col-lg-3 col-md-4">
										<label for="name_of_visitor"><?php echo renderLang($visitors_name_of_visitor); ?></label>
										<input type="text" class="form-control" name="name_of_visitor" required>
									</div>

									<!-- COMPANY / ADDRESS -->
									<div class="col-lg-3 col-md-4">
										<label for="company_address"><?php echo renderLang($visitors_company_address); ?></label>
										<input type="text" class="form-control" name="company_address" required>
									</div>

									<!-- PERSON TO VISIT -->
									<div class="col-lg-3 col-md-4">
										<label for="person_to_visit"><?php echo renderLang($visitors_person_to_visit); ?></label>
										<input type="text" class="form-control" name="person_to_visit" required>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($visitors_purpose); ?></label>
										<input type="text" class="form-control" name="purpose" required>
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/user-visitors" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($visitors_save_visitor); ?></button>
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