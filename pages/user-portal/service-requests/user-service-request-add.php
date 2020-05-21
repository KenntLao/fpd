<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-service-requests";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($service_requests_new_service_request); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fas fa-exclamation-circle mr-3"></i><?php echo renderLang($service_requests_new_service_request); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_complaints_add_suc');
					?>
					
					<form method="post" action="/submit-user-service-request-add">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($service_requests_add_service_request_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">


									<!-- SERVICE -->
									<div class="col-lg-3 col-md-4">
										<label for="service"><?php echo renderLang($service_requests_service); ?></label>
										<select name="service" id="service" class="form-control">
											<?php 
											foreach($service_request_service_arr as $key => $value) {
												echo '<option '.(isset($_SESSION['sys_sys_service_requests_add_service_val'])  && $_SESSION['sys_sys_service_requests_add_service_val'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
											}
											?>
										</select>
									</div>

								</div>
									
								<div class="row">

									<!-- DESCRIPTION -->
									<div class="col-lg-6 col-md-12">
										<label for="description"><?php echo renderLang($service_requests_description); ?></label>
										<textarea name="description" id="description" rows="3" class="form-control notes"><?php if(isset($_SESSION['sys_sys_service_requests_add_description_val'])) { echo ''.$_SESSION['sys_sys_service_requests_add_description_val'].''; } ?></textarea>
									</div>


									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/user-service-requests" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($service_requests_save_service_request); ?></button>
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
				singleDatePicker: true
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