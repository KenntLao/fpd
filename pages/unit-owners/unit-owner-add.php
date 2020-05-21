<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unit-owner-add')) {

		// set page
		$page = 'unit-owners';
		
		// suggested unit owner ID
		$sql = $pdo->prepare("SELECT id, unit_owner_id FROM unit_owners ORDER BY id DESC LIMIT 1");
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($data['unit_owner_id'] == '') {
			$unit_owner_id_suggestion = '100001';
		} else {
			$unit_owner_id_suggestion = $data['unit_owner_id'] + 1;
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($unit_owners_add_unit_owner); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="far fa-user-circle mr-3"></i><?php echo renderLang($unit_owners_add_unit_owner); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_unit_owners_add_err');
					renderSuccess('sys_unit_owners_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-unit-owner">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($unit_owners_add_unit_owner_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- UNIT OWNER ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_unit_owner_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_owner_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_unit_owner_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="unit_owner_id" name="unit_owner_id" placeholder="<?php echo renderLang($unit_owners_unit_owner_id_placeholder); ?>" <?php echo 'value="'.$unit_owner_id_suggestion.'"'; ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_unit_owner_id_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_unit_owner_id_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<hr>
								
								<h4><?php echo renderLang($unit_owners_unit_personal_information); ?></h4>
								
								<div class="row">

									<!-- FIRSTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_firstname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="firstname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_firstname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="firstname" name="firstname" placeholder="<?php echo renderLang($unit_owners_firstname_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_add_firstname_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_add_firstname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_firstname_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_firstname_err']); } ?>
										</div>
									</div>

									<!-- MIDDLENAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_middlename_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="middlename" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_middlename); ?></label>
											<input type="text" class="form-control<?php if($err) { echo ' is-invalid'; } ?>" id="middlename" name="middlename" placeholder="<?php echo renderLang($unit_owners_middlename_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_add_middlename_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_add_middlename_val'].'"'; } ?>>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_middlename_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_middlename_err']); } ?>
										</div>
									</div>

									<!-- LASTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="lastname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_lastname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="lastname" name="lastname" placeholder="<?php echo renderLang($unit_owners_lastname_placeholder); ?>"<?php if(isset($_SESSION['sys_unit_owners_add_lastname_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_add_lastname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_lastname_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_lastname_err']); } ?>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- GENDER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_gender_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="gender" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_gender); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="gender" name="gender" required>
												<?php
												foreach($gender_arr as $gender) {
													echo '<option value="'.$gender[0].'"';
													if(isset($_SESSION['sys_unit_owners_add_gender_val'])) {
														if($_SESSION['sys_unit_owners_add_gender_val'] == $gender[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($gender[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_gender_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_gender_err']); } ?>
										</div>
									</div>

									<!-- CIVIL STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_civil_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="civil_status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_civil_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="civil_status" name="civil_status" required>
												<?php
												foreach($civil_status_arr as $civil_status) {
													echo '<option value="'.$civil_status[0].'"';
													if(isset($_SESSION['sys_unit_owners_add_civil_status_val'])) {
														if($_SESSION['sys_unit_owners_add_civil_status_val'] == $civil_status[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($civil_status[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_civil_status_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_civil_status_err']); } ?>
										</div>
									</div>

									<!-- BIRTH DATE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_unit_owners_add_birthdate_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="birthdate" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_birthdate); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="birthdate" id="birthdate"<?php if(isset($_SESSION['sys_unit_owners_add_birthdate_val'])) { echo ' value="'.$_SESSION['sys_unit_owners_add_birthdate_val'].'"'; } ?> required>
											</div>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_unit_owners_add_birthdate_err'].'</p>'; unset($_SESSION['sys_unit_owners_add_birthdate_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->

								<div class="row">
									
									<!-- CITIZENSHIP -->
									<div class="col-lg-3 col-md-4">
										
										<div class="form-group">
											<label for="citizenship_id" class="mr-1"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($lang_citizenship_global); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="citizenship" name="citizenship_id" required>
                                            <?php 
                                            $sql = $pdo->prepare("SELECT num_code, nationality FROM countries");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option '.($data['num_code'] == 608 ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
                                            }
                                            ?>
											</select>
										</div>
									</div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="parking"><?php echo renderLang($unit_owners_parking); ?></label>
                                            <input type="text" class="form-control" name="parking" id="parking" value="<?php echo isset($_SESSION['sys_unit_owners_add_parking_val']) ? $_SESSION['sys_unit_owners_add_parking_val'] : ''; ?>">
                                            <?php unset($_SESSION['sys_unit_owners_add_parking_val']); ?>
                                        </div>
                                    </div>

								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/unit-owners" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($unit_owners_save_unit_owner); ?></button>
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
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>