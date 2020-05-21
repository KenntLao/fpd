<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('client-add')) {

		// set page
		$page = 'clients';
		
		// suggested client ID
		$sql = $pdo->prepare("SELECT id, client_id FROM clients ORDER BY id DESC LIMIT 1");
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($data['client_id'] == '') {
			$client_id_suggestion = '1001';
		} else {
			$client_id_suggestion = $data['client_id'] + 1;
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($clients_add_client); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-user-tie mr-3"></i><?php echo renderLang($clients_add_client); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_add_client_err');
					renderSuccess('sys_clients_add_client_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-client">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($clients_add_client_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- CLIENT ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_add_client_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="client_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_client_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="client_id" name="client_id" placeholder="<?php echo renderLang($clients_client_id_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_add_client_id_val'])) { echo ' value="'.$_SESSION['sys_clients_add_client_id_val'].'"'; } else { echo ' value="'.$client_id_suggestion.'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_add_client_id_err'].'</p>'; unset($_SESSION['sys_clients_add_client_id_err']); } ?>
										</div>
									</div>

									<!-- CLIENT NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_add_client_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="client_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_client_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="client_name" name="client_name" placeholder="<?php echo renderLang($clients_client_name_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_add_client_name_val'])) { echo ' value="'.$_SESSION['sys_clients_add_client_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_add_client_name_err'].'</p>'; unset($_SESSION['sys_clients_add_client_name_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<div class="row">

									<!-- CONTACT PERSON -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_add_contact_person_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="contact_person" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_contact_person); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="contact_person" name="contact_person" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_add_contact_person_val'])) { echo ' value="'.$_SESSION['sys_clients_add_contact_person_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_add_contact_person_err'].'</p>'; unset($_SESSION['sys_clients_add_contact_person_err']); } ?>
										</div>
									</div>

									<!-- CONTACT DETAILS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_add_contact_details_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="contact_details" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_contact_details); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="contact_details" name="contact_details" placeholder="<?php echo renderLang($clients_contact_details_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_add_contact_details_val'])) { echo ' value="'.$_SESSION['sys_clients_add_contact_details_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_add_contact_details_err'].'</p>'; unset($_SESSION['sys_clients_add_contact_details_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/clients" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($clients_save_client); ?></button>
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