<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('department-add')) {

		// set page
		$page = 'departments';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($departments_add_department); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/users.css">
	
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
							<h1><i class="fa fa-briefcase mr-3"></i><?php echo renderLang($departments_add_department); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_departments_add_err');
					renderSuccess('sys_departments_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-department">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($departments_add_department_form); ?></h3>
							</div>
							<div class="card-body">
								
								<div class="row">

									<!-- DEPARTMENT CODE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_departments_add_department_code_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="department_code" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($departments_department_code); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="department_code" name="department_code" placeholder="<?php echo renderLang($departments_department_code_placeholder); ?>"<?php if(isset($_SESSION['sys_departments_add_department_code_val'])) { echo ' value="'.$_SESSION['sys_departments_add_department_code_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_departments_add_department_code_err'].'</p>'; unset($_SESSION['sys_departments_add_department_code_err']); } ?>
										</div>
									</div>

									<!-- DEPARTMENT NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_departments_add_department_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="department_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($departments_department_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="department_name" name="department_name" placeholder="<?php echo renderLang($departments_department_name_placeholder); ?>"<?php if(isset($_SESSION['sys_departments_add_department_name_val'])) { echo ' value="'.$_SESSION['sys_departments_add_department_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_departments_add_department_name_err'].'</p>'; unset($_SESSION['sys_departments_add_department_name_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/departments" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($departments_save_department); ?></button>
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
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>