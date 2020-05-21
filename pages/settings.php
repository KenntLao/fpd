<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// set page
	$page = 'settings';
	
	$tab_selected = 'general';
	if(isset($_SESSION['sys_settings_tab_selected'])) {
		$tab_selected = $_SESSION['sys_settings_tab_selected'];
	}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($settings_title); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
							<h1><i class="fa fa-cogs mr-3"></i><?php echo renderLang($settings_title); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-body">
							<div class="row">

								<div class="col-5 col-sm-3">
									<div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
										<a class="nav-link<?php if($tab_selected == 'general') { echo ' active'; } ?>" id="btn-general" data-toggle="pill" href="#tab-general" role="tab" aria-controls="vert-tabs-home" aria-selected="<?php if($tab_selected == 'general') { echo 'true'; } else { echo 'false'; } ?>"><i class="fa fa-user mr-2"></i><?php echo renderLang($settings_general); ?></a>
										<a class="nav-link<?php if($tab_selected == 'change-password') { echo ' active'; } ?>" id="btn-change-password" data-toggle="pill" href="#tab-change-password" role="tab" aria-controls="vert-tabs-home" aria-selected="<?php if($tab_selected == 'change-password') { echo 'true'; } else { echo 'false'; } ?>"><i class="fa fa-lock mr-2"></i><?php echo renderLang($settings_change_password); ?></a>
										<a class="nav-link<?php if($tab_selected == 'notifications') { echo ' active'; } ?>" id="btn-notifications" data-toggle="pill" href="#tab-notifications" role="tab" aria-controls="vert-tabs-home" aria-selected="<?php if($tab_selected == 'notifications') { echo 'true'; } else { echo 'false'; } ?>"><i class="fa fa-bell mr-2"></i><?php echo renderLang($settings_notifications); ?></a>
									</div>
								</div>

								<div class="col-7 col-sm-9">
									<div class="tab-content" id="vert-tabs-tabContent">
										
										<!-- GENERAL -->
										<div class="tab-pane text-left<?php if($tab_selected == 'general') { echo ' active'; } ?>" id="tab-general" role="tabpanel" aria-labelledby="change-password">
											<h4><i class="fa fa-user mr-2"></i><?php echo renderLang($settings_general); ?></h4>
											<hr>
										</div>
										
										<!-- CHANGE PASSWORD -->
										<div class="tab-pane text-left<?php if($tab_selected == 'change-password') { echo ' active'; } ?>" id="tab-change-password" role="tabpanel" aria-labelledby="change-password">
											<h4><i class="fa fa-lock mr-2"></i><?php echo renderLang($settings_change_password); ?></h4>
											<hr>
											<?php
											renderError('sys_settings_change_password_err');
											renderSuccess('sys_settings_change_password_suc');
											?>
											<form method="post" action="/update-password">
												<input type="hidden" name="tab_selected" value="change-password">
												
												<?php
												// CURRENT PASSWORD
												$curr_password_err = 0;
												if(isset($_SESSION['sys_settings_change_password_curr_password'])) { $curr_password_err = 1; }
												?>
												<div class="form-group">
													<label for="curr_password" class="mr-1<?php if($curr_password_err) { echo ' text-danger'; } ?>"><?php if($curr_password_err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($settings_current_password); ?></label> <span class="right badge badge-danger">Required</span>
													<input type="password" minlength="4" class="form-control required<?php if($curr_password_err) { echo ' is-invalid'; } ?>" id="curr_password" name="curr_password" placeholder="" required>
													<?php if($curr_password_err) { echo '<p class="text-danger mt-1">'.$_SESSION['sys_settings_change_password_curr_password'].'</p>'; unset($_SESSION['sys_settings_change_password_curr_password']); } ?>
												</div>
												
												<?php
												$new_password_err = 0;
												if(isset($_SESSION['sys_settings_change_password_new_password'])) { $new_password_err = 1; }
												?>
												<div class="form-group">
													<label for="new_password" class="mr-1<?php if($new_password_err) { echo ' text-danger'; } ?>"><?php if($new_password_err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($settings_new_password); ?></label> <span class="right badge badge-danger">Required</span>
													<input type="password" minlength="4" class="form-control required<?php if($new_password_err) { echo ' is-invalid'; } ?>" id="new_password" name="new_password" placeholder="" required>
													<?php if($new_password_err) { echo '<p class="text-danger mt-1">'.$_SESSION['sys_settings_change_password_new_password'].'</p>'; unset($_SESSION['sys_settings_change_password_new_password']); } ?>
												</div>
												
												<?php
												$confirm_new_password_err = 0;
												if(isset($_SESSION['sys_settings_change_password_confirm_new_password'])) { $confirm_new_password_err = 1; }
												?>
												<div class="form-group">
													<label for="confirm_new_password" class="mr-1<?php if($confirm_new_password_err) { echo ' text-danger'; } ?>"><?php if($confirm_new_password_err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($settings_confirm_new_password); ?></label> <span class="right badge badge-danger">Required</span>
													<input type="password" minlength="4" class="form-control required<?php if($confirm_new_password_err) { echo ' is-invalid'; } ?>" id="confirm_new_password" name="confirm_new_password" placeholder="" required>
													<?php if($confirm_new_password_err) { echo '<p class="text-danger mt-1">'.$_SESSION['sys_settings_change_password_confirm_new_password'].'</p>'; unset($_SESSION['sys_settings_change_password_confirm_new_password']); } ?>
												</div>
												
												<button class="btn btn-primary float-right"><i class="fa fa-upload mr-2"></i><?php echo renderLang($settings_update_password); ?></button>
											</form>
										</div>
										
										<!-- NOTIFICATIONS -->
										<div class="tab-pane text-left<?php if($tab_selected == 'notifications') { echo ' active'; } ?>" id="tab-notifications" role="tabpanel" aria-labelledby="notifications">
											<h4><i class="fa fa-bell mr-2"></i><?php echo renderLang($settings_notifications); ?></h4>
											<hr>
										</div>
										
									</div><!-- tab-content -->
								</div><!-- col -->

							</div><!-- row -->
						</div><!-- card-body -->
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script>
		$(function() {
			
			$('#btn-change-password').click(function() {
				$('#curr_password').focus();
			});
			
		});
	</script>
	
</body>

</html>
<?php
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>