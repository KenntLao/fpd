<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-amenities";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($amenities_new_reservation); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="far fa-calendar-minus mr-3"></i><?php echo renderLang($amenities_new_reservation); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					
					?>
					
					<form method="post" action="/submit-user-amenity-add">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($amenities_new_reservation_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($amenities_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date" id="date"<?php if(isset($_SESSION['sys_amenities_add_date_val'])) { echo ' value="'.$_SESSION['sys_amenities_add_date_val'].'"'; } ?> required>
											</div>
										</div>
									</div>

					
									<!-- venue -->
									<div class="col-lg-3 col-md-4">
										<label for="venue"><?php echo renderLang($amenities_venue); ?></label>
										<input type="text" class="form-control" name="venue" <?php if(isset($_SESSION['sys_amenities_add_venue_val'])) { echo ' value="'.$_SESSION['sys_amenities_add_venue_val'].'"'; } ?>>
									</div>

									<!-- SUBJECT -->
									<div class="col-lg-3 col-md-4">
										<label for="subject"><?php echo renderLang($amenities_subject); ?></label>
										<input type="text" class="form-control" name="subject" <?php if(isset($_SESSION['sys_amenities_add_subject_val'])) { echo ' value="'.$_SESSION['sys_amenities_add_subject_val'].'"'; } ?> >
									</div>

									
								</div><!-- row -->

								<div class="row">

									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<label for="project_name"><?php echo renderLang($amenities_project_name); ?></label>
										<input type="text" class="form-control" name="project_name" <?php if(isset($_SESSION['sys_amenities_add_project_name_val'])) { echo ' value="'.$_SESSION['sys_amenities_add_project_name_val'].'"'; } ?> >
									</div>

									<!-- TIME STARTED/END -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_started_end"><?php echo renderLang($amenities_time_started_end); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right" name="time_started_end" id="time_started_end"<?php if(isset($_SESSION['sys_amenities_add_time_started_end_val'])) { echo ' value="'.$_SESSION['sys_amenities_add_time_started_end_val'].'"'; } ?>>
											</div>
										</div>
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/user-amenities" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($amenities_save_reservation); ?></button>
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
	<script>
		$(function() {

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
			});
			
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