<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user credentials are remembered
// set default values from cookies
$cookie_login_value = '';
$cookie_login_password = '';
if(isset($_COOKIE['sys_user_pms'])) {
	$spooder_creds = explode('|',$_COOKIE['sys_user_pms']);
	$cookie_login_value = $spooder_creds[0];
	$cookie_login_password = $spooder_creds[1];
}
?>
<!DOCTYPE html>
<html>

<head>
	
	<!-- META -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $sitename; ?></title>
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/login.css">
	
</head>

<body class="hold-transition login-page">
	
	<!-- LOGIN BOX -->
	<div class="login-box">
		
		<!-- LOGO -->
		<div class="login-logo">
			<a href="/"><?php echo renderLang($users_user_fpdasia_user_portal); ?></a>
		</div><!-- login-logo -->
		
		<!-- CARD -->
		<div class="card">
			
			<!-- CARD BODY -->
			<div class="card-body login-card-body">
				
				<p class="login-box-msg"></p>
				
				<form action="/user-verifylog" method="post">
					
					<div class="form-group">	
					<label><?php echo renderLang($users_username); ?></label>
					<div class="input-group mb-3">
						<input type="text" id="uname" class="form-control" name="uname" placeholder="<?php echo renderLang($login_login_placeholder); ?>"<?php if($cookie_login_value != '') { echo ' value="'.$cookie_login_value.'"'; } else { if(isset($_SESSION['sys_user_login_uname'])) { echo ' value="'.$_SESSION['sys_user_login_uname'].'"'; } } ?>  required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					</div>
					
					<label><?php echo renderLang($users_password); ?></label>
					<div class="input-group mb-3">
						<input type="password" id="upass" class="form-control" name="upass" placeholder="<?php echo renderLang($login_password_placeholder); ?>"<?php if($cookie_login_password != '') { echo ' value="'.$cookie_login_password.'"'; } ?> required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>

					<?php
					renderError('sys_user_login_err');
					renderSuccess('sys_user_login_suc');
					?>
					
					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
              					<input type="checkbox" id="remember" name="remember_me" <?php echo isset($spooder_creds)? "checked": ""; ?>>
              					<label for="remember"><?php echo renderLang($login_remember_me); ?></label>
            				</div>
						</div>
						<div class="col-4">
							<button type="submit" name="submit-login" class="btn btn-primary btn-block btn-flat"><?php echo renderLang($login_sign_in); ?></button>
						</div>
					</div>
					<div class="text-center mt-3">						
						<p class="mb-0">
        					<a href="#" class=""><?php echo renderLang($users_user_forgot_password); ?></a>
      					</p>
					</div>
					
				</form>

<!--
				<p class="mb-1">
					<a href="#"><?php echo renderLang($login_forgot_password); ?></a>
				</p>
-->
				
			</div>
			
		</div><!-- card -->
		<div class="login-footer">
			<p>Business Suite - PMS by <a href="">Raianseier</a><br>Copyright 2020. All Rights Reserved.</p>
		</div>

		
	</div>
	<!-- /.login-box -->

	<!-- JAVASCRIPT -->
	<script src="/plugins/jquery/jquery.min.js"></script>
	<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/dist/js/adminlte.min.js"></script>
	<script>
		$(function() {
			
			// set uname focus if it is not blank, else focus on upass
			if($('#uname').val() == '') {
				$('#uname').focus();
			} else {
				$('#upass').focus();
			}
			
		});
	</script>

</body>

</html>