<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('user-add')) {

		// set page
		$page = 'users';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($users_add_user); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-user-secret mr-3"></i><?php echo renderLang($users_add_user); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_users_add_err');
					renderSuccess('sys_users_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-user">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($users_add_user_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- USERNAME -->
									<div class="col-lg-3 col-md-4 col-sm-2">
										<?php $err = isset($_SESSION['sys_users_add_uname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="uname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($users_username); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="uname" name="uname" placeholder="<?php echo renderLang($users_username_placeholder); ?>"<?php if(isset($_SESSION['sys_users_add_uname_val'])) { echo ' value="'.$_SESSION['sys_users_add_uname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_users_add_uname_err'].'</p>'; unset($_SESSION['sys_users_add_uname_err']); } ?>
										</div>
									</div>

								</div><!-- row -->

								<hr>
								
								<div class="row">

									<!-- FIRSTNAME -->
									<div class="col-lg-3 col-md-4 col-sm-2">
										<?php $err = isset($_SESSION['sys_users_add_firstname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="firstname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($users_firstname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="firstname" name="firstname" placeholder="<?php echo renderLang($users_firstname_placeholder); ?>"<?php if(isset($_SESSION['sys_users_add_firstname_val'])) { echo ' value="'.$_SESSION['sys_users_add_firstname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_users_add_firstname_err'].'</p>'; unset($_SESSION['sys_users_add_firstname_err']); } ?>
										</div>
									</div>

									<!-- LASTNAME -->
									<div class="col-lg-3 col-md-4 col-sm-2">
										<?php $err = isset($_SESSION['sys_users_add_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="lastname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($users_lastname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="lastname" name="lastname" placeholder="<?php echo renderLang($users_lastname_placeholder); ?>"<?php if(isset($_SESSION['sys_users_add_lastname_val'])) { echo ' value="'.$_SESSION['sys_users_add_lastname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_users_add_lastname_err'].'</p>'; unset($_SESSION['sys_users_add_lastname_err']); } ?>
										</div>
									</div>

								</div><!-- row -->

								<hr>
								
								<!-- ROLES -->
								<?php
								$roles_val = '';
								$roles_val_arr = array();
								$err = isset($_SESSION['sys_users_add_roles_err']) ? 1 : 0;
								?>
								<div class="form-group">
									<h4<?php if($err) { echo ' class="text-danger"'; } ?>><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } ?><?php echo renderLang($roles_roles); ?> <span class="right badge badge-danger ml-1" style="font-size:10px;"><?php echo renderLang($label_required); ?></span></h4>
									<input type="text" id="role_ids" class="required" name="role_ids"<?php if(isset($_SESSION['sys_users_add_roles_val'])) { echo ' value="'.$_SESSION['sys_users_add_roles_val'].'"'; $roles_val = $_SESSION['sys_users_add_roles_val']; } ?> required>
									<?php if($err) { echo '<p class="text-danger mt-1">'.$_SESSION['sys_users_add_roles_err'].'</p>'; unset($_SESSION['sys_users_add_roles_err']); } ?>
								</div>
								<ul class="roles-list">
									<?php
									if($roles_val != '') {
										$roles_val_arr = explode(',',$roles_val);
									}
									$sql = $pdo->prepare("SELECT * FROM roles WHERE id<>1 AND temp_del=0 ORDER BY role_name ASC");
									$sql->execute();
									$roles_count = $sql->rowCount();
									$roles_group_count_max = floor($roles_count/4);
									$roles_group_counter = 0;
									while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
										$btn_design = 'btn-default';
										if(in_array($data['id'],$roles_val_arr)) {
											$btn_design = 'btn-success';
										}
										echo '<li><a href="#" class="btn '.$btn_design.' btn-sm" data-permission-code="'.$data['id'].'" title="'.$data['role_name'].'">'.$data['role_name'].'</a></li>';
									}
									?>
								</ul>

								<button class="btn btn-default clear mt-2 btn-clear-roles"><i class="fa fa-times mr-2"></i><?php echo renderLang($users_clear_roles); ?></button>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/users" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($users_add_user); ?></button>
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
	<script>
		$(function() {
			
			// populate roles
			$('.roles-list li a').click(function(e) {
				e.preventDefault();
				
				$(this).toggleClass('btn-default').toggleClass('btn-success');
				
				var roles = '';
				var roles_arr = [];
				
				$('.roles-list li a').each(function() {
					if($(this).hasClass('btn-success')) {
						roles_arr.push($(this).attr('data-permission-code'));
					}
				});
				
				var roles_val = roles_arr.join(',');
				$('#role_ids').val(roles_val);
				
				// required badge toggle
				if(roles_val == '') {
					$('h4 .badge').addClass('badge-danger').removeClass('badge-success');
				} else {
					$('h4 .badge').addClass('badge-success').removeClass('badge-danger');
				}
			});
			
			// clear roles
			$('.btn-clear-roles').click(function(e) {
				e.preventDefault();
				$('.roles-list li a').removeClass('btn-success').addClass('btn-default');
				$('#role_ids').val('');
				$('h4 .badge').addClass('badge-danger').removeClass('badge-success');
			});
			
		});
	</script>
	
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