<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('occupant-edit')) {

		// set page
		$page = 'occupants';
		
		// get ID
		$id = $_GET['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM occupants WHERE id = :id AND temp_del = 0 LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
			$_SESSION['sys_occupants_edit_unit_id_val'] = isset($_SESSION['sys_occupants_edit_unit_id_val']) ? $_SESSION['sys_occupants_edit_unit_id_val'] : $_data['unit_id'];
			$_SESSION['sys_occupants_edit_firstname_val'] = isset($_SESSION['sys_occupants_edit_firstname_val']) ? $_SESSION['sys_occupants_edit_firstname_val'] : $_data['firstname'];
			$_SESSION['sys_occupants_edit_middlename_val'] = isset($_SESSION['sys_occupants_edit_middlename_val']) ? $_SESSION['sys_occupants_edit_middlename_val'] : $_data['middlename'];
			$_SESSION['sys_occupants_edit_lastname_val'] = isset($_SESSION['sys_occupants_edit_lastname_val']) ? $_SESSION['sys_occupants_edit_lastname_val'] : $_data['lastname'];
			$_SESSION['sys_occupants_edit_gender_val'] = isset($_SESSION['sys_occupants_edit_gender_val']) ? $_SESSION['sys_occupants_edit_gender_val'] : $_data['gender'];
			$_SESSION['sys_occupants_edit_birthdate_val'] = isset($_SESSION['sys_occupants_edit_birthdate_val']) ? $_SESSION['sys_occupants_edit_birthdate_val'] : $_data['birthdate'];
			$_SESSION['sys_occupants_edit_civil_status_val'] = isset($_SESSION['sys_occupants_edit_civil_status_val']) ? $_SESSION['sys_occupants_edit_civil_status_val'] : $_data['civil_status'];
			$_SESSION['sys_occupants_edit_status_val'] = isset($_SESSION['sys_occupants_edit_status_val']) ? $_SESSION['sys_occupants_edit_status_val'] : $_data['status'];

			$_SESSION['sys_occupants_edit_citizenship_id_val'] = $_data['citizenship_id'];
			$_SESSION['sys_occupants_edit_relationship_to_tenant_val'] = $_data['relationship_to_tenant'];
			$_SESSION['sys_occupants_edit_social_status_val'] = $_data['social_status'];
			
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($occupants_edit_occupant); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fa fa-users mr-3"></i><?php echo renderLang($occupants_edit_occupant); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_occupants_edit_err');
					?>
					
					<form action="/sumbit-edit-occupant" method="post">

						<input type="hidden" name="occupant_id" value="<?php echo $_data['id']; ?>">
					
						<div class="card">
							<div class="card-header">
								<h3 class="card-title" class="mr-1"><?php echo renderLang($occupants_edit_occupant_form); ?></h3>
								<div class="card-tools">
									<?php if(checkPermission('occupant-delete')){ ?>
									<button class="btn btn-danger" id="delete"><i class="fa fa-trash mr-2"></i><?php echo renderLang($occupants_delete_occupant); ?></button>
									<?php } ?>
								</div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- UNIT ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_unit_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_id" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($units_unit); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="unit_id" id="unit_id" class="form-control select2 required <?php echo $err ? 'is-invalid' : ''; ?>">
												<option value="0">TBD</option>
												<?php
												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_occupants_edit_unit_id_val']) && $_SESSION['sys_occupants_edit_unit_id_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}
												?>
											</select>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_edit_unit_id_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_edit_unit_id_err']);
											?>
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="status" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($lang_status); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select id="status" name="status" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>">
												<?php
												foreach($status_arr as $status) {
												echo '<option value="'.$status[0].'" '.(isset($_SESSION['sys_occupants_edit_status_val']) && $_SESSION['sys_occupants_edit_status_val'] == $status[0] ? 'selected' : '').'>'.renderLang($status[1]).'</option>';
												}
												?>
											</select>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_edit_status_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_edit_status_err']);
											?>
										</div>
									</div>

								</div>
								<!-- .row -->

								<div class="row">

									<!-- FIRST NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_firstname_err']) ? 1:0; ?>
										<div class="form-group">
											<label for="first_name" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_firstname); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>" name="firstname" <?php echo isset($_SESSION['sys_occupants_edit_firstname_val']) ? 'value="'.$_SESSION['sys_occupants_edit_firstname_val'].'"' : ''; ?> id="first_name">
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_edit_firstname_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_edit_firstname_err']);
											?>
										</div>
									</div>

									<!-- MIDDLE NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="middle_name" class="mr-1"><?php echo renderLang($occupants_middlename); ?></label>
											<input type="text" class="form-control" name="middlename" id="middle_name" <?php echo isset($_SESSION['sys_occupants_edit_middlename_val']) ? 'value="'.$_SESSION['sys_occupants_edit_middlename_val'].'"' : ''; ?>>
										</div>
									</div>

									<!-- LAST NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="last_name" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_lastname); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required <?php echo $err ? 'is-invalid': '' ?>" name="lastname" <?php echo isset($_SESSION['sys_occupants_edit_lastname_val']) ? 'value="'.$_SESSION['sys_occupants_edit_lastname_val'].'"' : ''; ?> id="last_name">
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_edit_lastname_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_edit_lastname_err']);
											?>
										</div>
									</div>

								</div>
								<!-- .row -->

								<div class="row">

									<!-- GENDER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_gender_err']) ? 1:0; ?>
										<div class="form-group">
											<label for="gender" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_gender); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="gender" id="gender" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>">
												<?php
												foreach($gender_arr as $value) {
												echo '<option value="'.$value[0].'" '.(isset($_SESSION['sys_occupants_edit_gender_val']) && $_SESSION['sys_occupants_edit_gender_val'] == $value[0] ? 'selected' : '').'>'.renderLang($value[1]).'</option>';
												}
												?>
											</select>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1>'.$_SESSION['sys_occupants_edit_gender_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_edit_gender_err']);
											?>
										</div>
									</div>

									<!-- BIRTHDATE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_birthdate_err']) ? 1:0; ?>
										<div class="form-group">
											<label for="birthdate" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_birthdate); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right required <?php echo $err ? 'is-invalid' : ''; ?>" name="birthdate" id="birthdate" <?php echo isset($_SESSION['sys_occupants_edit_birthdate_val']) ? 'value="'.$_SESSION['sys_occupants_edit_birthdate_val'].'"' : ''; ?>>
												<?php
												echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_edit_birthdate_err'].'</p>' : '';
												unset($_SESSION['sys_occupants_edit_birthdate_err']);
												?>
											</div>
										</div>
									</div>

									<!-- CIVIL STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_edit_civil_status_err']) ? 1:0; ?>
										<div class="form-group">
											<label for="civil_status" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_civil_status); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="civil_status" id="civil_status" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>">
												<?php
												foreach($civil_status_arr as $value) {
												echo '<option value="'.$value[0].'" '.(isset($_SESSION['sys_occupants_edit_civil_status_val']) && $_SESSION['sys_occupants_edit_civil_status_val'] == $value[0] ? 'selected' : '').'>'.renderLang($value[1]).'</option>';
												}
												?>
											</select>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_edit_civil_status_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_edit_civil_status_err']);
											?>
										</div>
									</div>

								</div>
								<!-- .row -->

								<div class="row">

									<!-- CITIZENSHIP -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="citizenship_id" ><?php echo renderLang($lang_citizenship_global); ?></label>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="citizenship_id" name="citizenship_id" required>
                                        	<?php 
	                                            $sql = $pdo->prepare("SELECT num_code, nationality FROM countries");
	                                            $sql->execute();
	                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                                echo '<option '.($_SESSION['sys_occupants_edit_citizenship_id_val'] == $data['num_code'] ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
	                                            }
	                                            ?>
											</select>
										</div>
									</div>

									<!-- RELATIONSHIP TO TENANT -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="relationship_to_tenant" ><?php echo renderLang($occupants_relationship_to_tenant); ?></label>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="relationship_to_tenant" name="relationship_to_tenant">
                                        	<?php 
											foreach($relationship_to_tenant_arr as $key => $value) {
												echo '<option '.(!empty($_SESSION['sys_occupants_edit_relationship_to_tenant_val'])  && $_SESSION['sys_occupants_edit_relationship_to_tenant_val'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
											}
											?>
											</select>
										</div>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($occupants_social_status); ?></label>
                                            <select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="social_status" name="social_status">
                                            	<option value=""></option>
                                        		<?php 
												foreach($social_status_arr as $key => $value) {
												echo '<option '.(!empty($_SESSION['sys_occupants_edit_social_status_val'])  && $_SESSION['sys_occupants_edit_social_status_val'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
												}
												?>
											</select>
                                        </div>

                                    </div>
									
								</div><!-- .row -->

							</div>
							<!-- .card-body -->
							<div class="card-footer text-right">
								<a href="/occupants" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($occupants_edit_occupant); ?></button>
							</div>
						</div><!-- card -->
					
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->
	
	<!-- confirm delete -->
	<?php if(checkPermission('occupant-delete')){ ?>
	<div class="modal fade" id="modal-confirm-delete">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
				</div>
				<form action="/delete-occupant" method="post" class="ajax-form">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="modal-body">
						<p><?php echo renderLang($occupants_modal_delete_msg1); ?></p>
						<p><?php echo renderLang($occupants_modal_delete_msg2); ?></p>
						<hr>
						<div class="form-group is-invalid">
							<label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
							<input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
						</div>
						<div class="modal-error alert alert-danger"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->
	<?php } ?>

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {

			// open delete modal
			$('#delete').on('click', function(e){
				e.preventDefault();
				$('#modal-confirm-delete .modal-error').hide();
				$('#modal-confirm-delete').modal('show');
			});

			// submit delete modal
			$('form.ajax-form').on('submit', function(e){
				e.preventDefault();
				var post_url = $(this).attr('action');
				$.ajax({
					url: post_url,
					type: 'POST',
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(response){
						var response_arr = response.split(',');
						if(response_arr[0] == 1) { // val is 1
							window.location.href = '/occupants';
						} else {
							$('.modal-error')
								.html(response_arr[1]) // val is error message
								.show();
						}
					}
				});
			});

			$('#birthdate').daterangepicker({
				singleDatePicker: true,
	                locale: {
	                    format: 'YYYY-MM-DD'
	                }
			});

		});
	</script>
	
</body>

</html>
<?php
		} else { // occupant id not found
			$_SESSION['sys_occupants_err'] = renderLang($occupants_occupant_not_found);
			header('location: /occupants');
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