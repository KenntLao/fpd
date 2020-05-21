<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('tenant-add')) {

		// set page
		$page = 'tenants';
		
		// suggested tenant ID
		$sql = $pdo->prepare("SELECT id, tenant_id FROM tenants ORDER BY id DESC LIMIT 1");
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($data['tenant_id'] == '') {
			$tenant_id_suggestion = '1001';
		} else {
			$tenant_id_suggestion = $data['tenant_id'] + 1;
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($tenants_add_tenant); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="far fa-address-card mr-3"></i><?php echo renderLang($tenants_add_tenant); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_tenants_add_err');
					renderSuccess('sys_tenants_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-tenant">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($tenants_add_tenant_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- TENANT ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_tenants_add_tenant_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="tenant_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_tenant_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="tenant_id" name="tenant_id" placeholder="<?php echo renderLang($tenants_tenant_id_placeholder); ?>"<?php if(isset($_SESSION['sys_tenants_add_tenant_id_val'])) { echo ' value="'.$_SESSION['sys_tenants_add_tenant_id_val'].'"'; } else { echo ' value="'.$tenant_id_suggestion.'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_tenants_add_tenant_id_err'].'</p>'; unset($_SESSION['sys_tenants_add_tenant_id_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<div class="row">

									<!-- FIRSTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_tenants_add_firstname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="firstname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_firstname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="firstname" name="firstname" placeholder="<?php echo renderLang($tenants_firstname_placeholder); ?>"<?php if(isset($_SESSION['sys_tenants_add_firstname_val'])) { echo ' value="'.$_SESSION['sys_tenants_add_firstname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_tenants_add_firstname_err'].'</p>'; unset($_SESSION['sys_tenants_add_firstname_err']); } ?>
										</div>
									</div>

									<!-- MIDDLENAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_tenants_add_middlename_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="middlename" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_middlename); ?></label>
											<input type="text" class="form-control<?php if($err) { echo ' is-invalid'; } ?>" id="middlename" name="middlename" placeholder="<?php echo renderLang($tenants_middlename_placeholder); ?>"<?php if(isset($_SESSION['sys_tenants_add_middlename_val'])) { echo ' value="'.$_SESSION['sys_tenants_add_middlename_val'].'"'; } ?>>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_tenants_add_middlename_err'].'</p>'; unset($_SESSION['sys_tenants_add_middlename_err']); } ?>
										</div>
									</div>

									<!-- LASTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_tenants_add_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="lastname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_lastname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="lastname" name="lastname" placeholder="<?php echo renderLang($tenants_lastname_placeholder); ?>"<?php if(isset($_SESSION['sys_tenants_add_lastname_val'])) { echo ' value="'.$_SESSION['sys_tenants_add_lastname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_tenants_add_lastname_err'].'</p>'; unset($_SESSION['sys_tenants_add_lastname_err']); } ?>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- GENDER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_tenants_add_gender_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="gender" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_gender); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="gender" name="gender" required>
												<?php
												foreach($gender_arr as $gender) {
													echo '<option value="'.$gender[0].'"';
													if(isset($_SESSION['sys_tenants_add_gender_val'])) {
														if($_SESSION['sys_tenants_add_gender_val'] == $gender[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($gender[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_tenants_add_gender_err'].'</p>'; unset($_SESSION['sys_tenants_add_gender_err']); } ?>
										</div>
									</div>

									<!-- BIRTH DATE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_tenants_add_birthdate_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="birthdate" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_birthdate); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="birthdate" id="birthdate"<?php if(isset($_SESSION['sys_tenants_add_birthdate_val'])) { echo ' value="'.$_SESSION['sys_tenants_add_birthdate_val'].'"'; } ?> required>
											</div>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_tenants_add_birthdate_err'].'</p>'; unset($_SESSION['sys_tenants_add_birthdate_err']); } ?>
										</div>
									</div>
									
									<!-- CITIZENSHIP -->
									<div class="col-lg-3 col-md-4 col-sm-2">
										
										<div class="form-group">
											<label for="citizenship_id" class="mr-1"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($lang_citizenship_global); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="citizenship_id" name="citizenship_id" required>
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

                                </div><!-- row -->
                                
                                <div class="row">
									
									<!-- SOCIAL STATUS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="social_status"><?php echo renderLang($occupants_social_status); ?></label>
                                            <select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="social_status" name="social_status" >
												<option value=""></option>
												<?php 
                                        			foreach($social_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
											</select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
											<label for="relationship_to_owner" class="mr-1"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($tenants_relationship_to_owner); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="relationship_to_owner" name="relationship_to_owner">
												<?php 
                                        			foreach($relationship_to_owner_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
											</select>
                                        </div>
                                    </div>

                                    <!-- PARKING -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="parking"><?php echo renderLang($tenants_parking); ?></label>
                                            <input type="text" class="form-control" name="parking" id="parking" value="<?php echo isset($_SESSION['sys_tenants_add_parking_val']) ? $_SESSION['sys_tenants_add_parking_val'] : ''; ?>">
                                            <?php unset($_SESSION['sys_tenants_add_parking_val']); ?>
                                        </div>
                                    </div>
                                    
                                </div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/tenants" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($tenants_save_tenant); ?></button>
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