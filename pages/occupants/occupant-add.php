<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('occupant-add')) {
	
		// clear sessions from forms
		// clearSessions();

		// set page
		$page = 'occupants';

		if(isset($_GET['id'])) {
			
			$_SESSION['sys_occupants_add_unit_id_val'] = $_GET['id'];
		}
		
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($occupants_add_occupant); ?> &middot; <?php echo $sitename; ?></title>
	
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fa fa-users mr-3"></i><?php echo renderLang($occupants_add_occupant); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_occupants_add_err');
					?>
					
					<form action="/submit-add-occupant" method="post">
					
						<div class="card">
							<div class="card-header">
								<h3 class="card-title" class="mr-1"><?php echo renderLang($occupants_add_occupant_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- UNIT ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_add_unit_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_id" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($units_unit); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="unit_id" id="unit_id" class="form-control select2 required  <?php echo $err ? 'is-invalid' : ''; ?>">
												<option value="0">TBD</option>
												<?php 
												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_occupants_add_unit_id_val']) && $_SESSION['sys_occupants_add_unit_id_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}
												?>
											</select>
											<?php 
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_add_unit_id_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_add_unit_id_err']);
											?>
										</div>
									</div>

								</div>

								<div class="row">

									<!-- FIRST NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_add_firstname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="firstname" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_firstname); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>" id="firstname" name="firstname" <?php echo isset($_SESSION['sys_occupants_add_firstname_val']) ? 'value="'.$_SESSION['sys_occupants_add_firstname_val'].'"' : ''; ?> required>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_add_firstname_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_add_firstname_err']);
											?>
										</div>
									</div>

									<!-- MIDDLE NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="middle_name" class="mr-1"><?php echo renderLang($occupants_middlename); ?></label>
											<input type="text" class="form-control" name="middlename" id="middle_name" <?php echo isset($_SESSION['sys_occupants_add_middlename_val']) ? 'value="'.$_SESSION['sys_occupants_add_middlename_val'].'"' : ''; ?>>
										</div>
									</div>

									<!-- LAST NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_add_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="last_name" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_lastname); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required <?php echo $err ? 'is-invalid': '' ?>" name="lastname" <?php echo isset($_SESSION['sys_occupants_add_lastname_val']) ? 'value="'.$_SESSION['sys_occupants_add_lastname_val'].'"' : ''; ?> id="last_name">
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_add_lastname_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_add_lastname_err']);
											?>
										</div>
									</div>

								</div>
								<!-- .row -->

								<div class="row">

									<!-- GENDER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_add_gender_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="gender" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_gender); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="gender" id="gender" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>">
												<?php
												foreach($gender_arr as $value) {
												echo '<option value="'.$value[0].'" '.(isset($_SESSION['sys_occupants_add_gender_val']) && $_SESSION['sys_occupants_add_gender_val'] == $value[0] ? 'selected' : '').'>'.renderLang($value[1]).'</option>';
												}
												?>
											</select>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1>'.$_SESSION['sys_occupants_add_gender_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_add_gender_err']);
											?>
										</div>
									</div>

									<!-- BIRTHDATE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_add_birthdate_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="birthdate" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_birthdate); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right required <?php echo $err ? 'is-invalid' : ''; ?>" name="birthdate" id="birthdate" <?php echo isset($_SESSION['sys_occupants_add_birthdate_val']) ? 'value="'.$_SESSION['sys_occupants_add_birthdate_val'].'"' : ''; ?>>
												<?php
												echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_add_birthdate_err'].'</p>' : '';
												unset($_SESSION['sys_occupants_add_birthdate_err']);
												?>
											</div>
										</div>
									</div>

									<!-- CIVIL STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_occupants_add_civil_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="civil_status" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($occupants_civil_status); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="civil_status" id="civil_status" class="form-control required <?php echo $err ? 'is-invalid' : ''; ?>">
												<?php
												foreach($civil_status_arr as $value) {
												echo '<option value="'.$value[0].'" '.(isset($_SESSION['sys_occupants_add_civil_status_val']) && $_SESSION['sys_occupants_add_civil_status_val'] == $value[0] ? 'selected' : '').'>'.renderLang($value[1]).'</option>';
												}
												?>
											</select>
											<?php
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_occupants_add_civil_status_err'].'</p>' : '';
											unset($_SESSION['sys_occupants_add_civil_status_err']);
											?>
										</div>
									</div>

								</div>
								<!-- .row -->

								<div class="row">
									
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

									<!-- RELATIONSHIP TO TENANT -->
									<div class="col-lg-3 col-md-4 col-sm-2">
										
										<div class="form-group">
											<label for="relationship_to_tenant" class="mr-1"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($occupants_relationship_to_tenant); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="relationship_to_tenant" name="relationship_to_tenant">
												<?php 
                                        			foreach($relationship_to_tenant_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
											</select>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="social_status"><?php echo renderLang($occupants_social_status); ?></label>
                                            <select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="social_status" name="social_status">
												<option value=""></option>
												<?php 
                                        			foreach($social_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
											</select>
                                        </div>
                                    </div>

								</div><!-- row -->

							</div>
							<!-- .card-body -->
							<div class="card-footer text-right">
								<a href="/occupants" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($occupants_save_occupant); ?></button>
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