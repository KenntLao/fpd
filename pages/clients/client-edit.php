<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('client-edit')) {

		// set page
		$page = 'clients';
		
		// get id
		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT * FROM clients WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			$data = $sql->fetch(PDO::FETCH_ASSOC);
			if(!isset($_SESSION['sys_clients_edit_client_id_val'])) {
				$_SESSION['sys_clients_edit_client_id_val'] = $data['client_id'];
			}
			if(!isset($_SESSION['sys_clients_edit_client_name_val'])) {
				$_SESSION['sys_clients_edit_client_name_val'] = $data['client_name'];
			}
			if(!isset($_SESSION['sys_clients_edit_contact_person_val'])) {
				$_SESSION['sys_clients_edit_contact_person_val'] = $data['contact_person'];
			}
			if(!isset($_SESSION['sys_clients_edit_contact_details_val'])) {
				$_SESSION['sys_clients_edit_contact_details_val'] = $data['contact_details'];
			}
			if(!isset($_SESSION['sys_clients_edit_status_val'])) {
				$_SESSION['sys_clients_edit_status_val'] = $data['status'];
			}
			
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($clients_edit_client); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
							<h1>
								<i class="fa fa-user-tie mr-3"></i><?php echo renderLang($clients_edit_client); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo '['.$data['client_id'].'] '.$data['client_name']; ?>
							</h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_edit_client_err');
					renderSuccess('sys_clients_edit_client_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-edit-client">
						
						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($clients_edit_client_form); ?></h3>
								<div class="card-tools">
									<?php if(checkPermission('client-delete')) { ?>
									<button type="button" class="btn btn-danger btn-confirm-delete mr-1" data-toggle="modal" data-target="#modal-confirm-delete"><i class="fa fa-trash mr-2"></i><?php echo renderLang($clients_delete_client); ?></button>
									<?php } ?>
								</div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- CLIENT ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_edit_client_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="client_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_client_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="client_id" name="client_id" placeholder="<?php echo renderLang($clients_client_id_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_edit_client_id_val'])) { echo ' value="'.$_SESSION['sys_clients_edit_client_id_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_edit_client_id_err'].'</p>'; unset($_SESSION['sys_clients_edit_client_id_err']); } ?>
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_edit_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($lang_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="status" name="status" required>
												<?php
												foreach($status_arr as $status) {
													echo '<option value="'.$status[0].'"';
													if(isset($_SESSION['sys_clients_edit_status_val'])) {
														if($_SESSION['sys_clients_edit_status_val'] == $status[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($status[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_edit_status_err'].'</p>'; unset($_SESSION['sys_clients_edit_status_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->
								
								<div class="row">

									<!-- client_name -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_edit_client_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="client_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_client_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="client_name" name="client_name" placeholder="<?php echo renderLang($clients_client_name_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_edit_client_name_val'])) { echo ' value="'.$_SESSION['sys_clients_edit_client_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_edit_client_name_err'].'</p>'; unset($_SESSION['sys_clients_edit_client_name_err']); } ?>
										</div>
									</div>

									<!-- contact_person -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_edit_contact_person_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="contact_person" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_contact_person); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="contact_person" name="contact_person" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_edit_contact_person_val'])) { echo ' value="'.$_SESSION['sys_clients_edit_contact_person_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_edit_contact_person_err'].'</p>'; unset($_SESSION['sys_clients_edit_contact_person_err']); } ?>
										</div>
									</div>
									
									<!-- contact_details -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_clients_edit_contact_details_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="contact_details" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_contact_details); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="contact_details" name="contact_details" placeholder="<?php echo renderLang($clients_contact_details_placeholder); ?>"<?php if(isset($_SESSION['sys_clients_edit_contact_details_val'])) { echo ' value="'.$_SESSION['sys_clients_edit_contact_details_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_clients_edit_contact_details_err'].'</p>'; unset($_SESSION['sys_clients_edit_contact_details_err']); } ?>
										</div>
									</div>

								</div><!-- row -->

							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/clients" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($clients_update_client); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->
	
	<!-- MODALS -->
	<!-- confirm delete -->
	<div class="modal fade" id="modal-confirm-delete">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
				</div>
				<form action="/delete-client" method="post" id="form_delete">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="modal-body">
						<p><?php echo renderLang($clients_modal_delete_msg1); ?></p>
						<p><?php echo renderLang($clients_modal_delete_msg2); ?></p>
						<hr>
						<div class="form-group is-invalid">
							<label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
							<input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
						</div>
						<div class="modal-error alert alert-danger"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button type="button" class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function() {

			var form_data;
			
			// confirm delete
			$('.btn-delete').click(function() {
				form_data = $('#form_delete').serialize();
				$('#modal_confirm_delete_upass').val('');
				$('#form_delete').submit();
			});
			$('#form_delete').submit(function(e) {
				e.preventDefault();
				var post_url = $(this).attr("action");
				$.ajax({
					url: post_url,
					type: 'POST',
					data : form_data
				}).done(function(response){
					var response_arr = response.split(',');
					if(response_arr[0] == 1) { // val is 1
						window.location.href = '/clients';
					} else {
						$('.modal-error')
							.html(response_arr[1]) // val is error message
							.show();
					}
				});
			});
			
		});
	</script>
	
</body>

</html>
<?php
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_clients_err'] = renderLang($clients_client_not_found);
			header('location: /clients');

		}
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>