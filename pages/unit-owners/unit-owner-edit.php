<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unit-owner-edit')) {

		// set page
		$page = 'unit-owners';
		
		// get id
		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT * FROM unit_owners WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			$data = $sql->fetch(PDO::FETCH_ASSOC);
			if(!isset($_SESSION['sys_unit_owners_edit_unit_owner_id_val'])) {
				$_SESSION['sys_unit_owners_edit_unit_owner_id_val'] = $data['unit_owner_id'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_firstname_val'])) {
				$_SESSION['sys_unit_owners_edit_firstname_val'] = $data['firstname'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_middlename_val'])) {
				$_SESSION['sys_unit_owners_edit_middlename_val'] = $data['middlename'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_lastname_val'])) {
				$_SESSION['sys_unit_owners_edit_lastname_val'] = $data['lastname'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_gender_val'])) {
				$_SESSION['sys_unit_owners_edit_gender_val'] = $data['gender'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_civil_status_val'])) {
				$_SESSION['sys_unit_owners_edit_civil_status_val'] = $data['civil_status'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_birthdate_val'])) {
				$_SESSION['sys_unit_owners_edit_birthdate_val'] = $data['birthdate'];
			}
			if(!isset($_SESSION['sys_unit_owners_edit_status_val'])) {
				$_SESSION['sys_unit_owners_edit_status_val'] = $data['status'];
			}
            $_SESSION['sys_unit_owners_edit_citizenship_id_val'] = $data['citizenship_id'];
            if(!isset($_SESSION['sys_unit_owners_edit_parking_val'])) {
                $_SESSION['sys_unit_owners_edit_parking_val'] = $data['parking'];
            }
			
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($unit_owners_edit_unit_owner); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1>
								<i class="far fa-user-circle mr-3"></i><?php echo renderLang($unit_owners_edit_unit_owner); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php
								echo '['.$data['unit_owner_id'].'] ';
								switch($_SESSION['sys_language']) {
									case 0:
										echo $data['firstname'].' '.$data['lastname'];
										break;
									case 1:
										echo $data['lastname'].' '.$data['firstname'];
										break;
								}
								?>
							</h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_unit_owners_edit_err');
					renderSuccess('sys_unit_owners_edit_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-edit-unit-owner">
						
						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($unit_owners_edit_unit_owner_form); ?></h3>
								<div class="card-tools">
									<?php if(checkPermission('unit-owner-delete')) { ?>
									<button type="button" class="btn btn-danger btn-confirm-delete mr-1" data-toggle="modal" data-target="#modal-confirm-delete"><i class="fa fa-trash mr-2"></i><?php echo renderLang($unit_owners_delete_unit_owner); ?></button>
									<?php } ?>
								</div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- UNIT OWNER ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_unit_owner_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_owner_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_unit_owner_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="unit_owner_id" name="unit_owner_id" placeholder="<?php echo renderLang($unit_owners_unit_owner_id_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_edit_unit_owner_id_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_edit_unit_owner_id_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_unit_owner_id_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_unit_owner_id_err']); } ?>
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($lang_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="status" name="status" required>
												<?php
												foreach($status_arr as $status) {
													echo '<option value="'.$status[0].'"';
													if(isset($_SESSION['sys_unit_owners_edit_status_val'])) {
														if($_SESSION['sys_unit_owners_edit_status_val'] == $status[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($status[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_status_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_status_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->

								<hr>

								<h4><?php echo renderLang($unit_owners_unit_personal_information); ?></h4>
								
								<div class="row">

									<!-- FIRSTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_firstname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="firstname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_firstname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="firstname" name="firstname" placeholder="<?php echo renderLang($unit_owners_firstname_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_edit_firstname_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_edit_firstname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_firstname_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_firstname_err']); } ?>
										</div>
									</div>

									<!-- MIDDLENAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_middlename_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="middlename" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_middlename); ?></label>
											<input type="text" class="form-control<?php if($err) { echo ' is-invalid'; } ?>" id="middlename" name="middlename" placeholder="<?php echo renderLang($unit_owners_middlename_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_edit_middlename_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_edit_middlename_val'].'"'; } ?>>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_middlename_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_middlename_err']); } ?>
										</div>
									</div>
									
									<!-- LASTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="lastname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_lastname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="lastname" name="lastname" placeholder="<?php echo renderLang($unit_owners_lastname_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_edit_lastname_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_edit_lastname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_lastname_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_lastname_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<div class="row">

									<!-- GENDER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_gender_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="gender" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_gender); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="gender" name="gender" required>
												<?php
												foreach($gender_arr as $gender) {
													echo '<option value="'.$gender[0].'"';
													if(isset($_SESSION['sys_unit_owners_edit_gender_val'])) {
														if($_SESSION['sys_unit_owners_edit_gender_val'] == $gender[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($gender[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_gender_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_gender_err']); } ?>
										</div>
									</div>

									<!-- CIVIL STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_civil_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="civil_status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_civil_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="civil_status" name="civil_status" required>
												<?php
												foreach($civil_status_arr as $civil_status) {
													echo '<option value="'.$civil_status[0].'"';
													if(isset($_SESSION['sys_unit_owners_edit_civil_status_val'])) {
														if($_SESSION['sys_unit_owners_edit_civil_status_val'] == $civil_status[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($civil_status[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_gender_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_gender_err']); } ?>
										</div>
									</div>
									
									<!-- BIRTH DATE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_edit_birthdate_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="birthdate" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_birthdate); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="birthdate" id="birthdate"<?php if(isset($_SESSION['sys_unit_owners_edit_birthdate_val'])) { echo ' value="'.formatDate($_SESSION['sys_unit_owners_edit_birthdate_val']).'"'; } ?> required>
											</div>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_edit_birthdate_err'].'</p>'; unset($_SESSION['sys_unit_owners_edit_birthdate_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->
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
	                                                echo '<option '.($_SESSION['sys_unit_owners_edit_citizenship_id_val'] == $data['num_code'] ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
	                                            }
	                                            ?>
											</select>
										</div>
									</div>

                                    <!-- PARKING -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="parking"><?php echo renderLang($unit_owners_parking); ?></label>
                                            <input type="text" class="form-control" name="parking" id="parking" value="<?php echo isset($_SESSION['sys_unit_owners_edit_parking_val']) ? $_SESSION['sys_unit_owners_edit_parking_val'] : ''; ?>">
                                            <?php unset($_SESSION['sys_unit_owners_edit_parking_val']); ?>
                                        </div>
                                    </div>

								</div>

							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/unit-owners" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($unit_owners_update_unit_owner); ?></button>
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
				<form action="/delete-unit-owner" method="post" id="form_delete">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="modal-body">
						<p><?php echo renderLang($unit_owners_modal_delete_msg1); ?></p>
						<p><?php echo renderLang($unit_owners_modal_delete_msg2); ?></p>
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
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {
			
			$('#birthdate').daterangepicker({
				singleDatePicker: true,
	                locale: {
	                    format: 'YYYY-MM-DD'
	                }
			});

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
						window.location.href = '/unit-owners';
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
			$_SESSION['sys_unit_owners_err'] = renderLang($unit_owners_unit_owner_not_found);
			header('location: /unit-owners');

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