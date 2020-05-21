<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unit-add')) {

		// set page
		$page = 'properties';
		
		// get property details
		$property_id = $_GET['pid'];
		$pid_data = getData($property_id,'properties');
		
		// get sub property details
		$sub_property_id = $_GET['spid'];
		$spid_data = getData($sub_property_id,'sub_properties');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($units_add_unit); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/properties.css">
	<link rel="stylesheet" href="/assets/css/units.css">
	
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
								<i class="fa fa-door-open mr-3"></i>
								<?php echo renderLang($units_add_unit); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $pid_data['property_name']; ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $spid_data['sub_property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $property_id; ?>"><?php echo $pid_data['property_name']; ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $sub_property_id; ?>"><?php echo $spid_data['sub_property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo renderLang($units_add_unit); ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_units_add_err');
					renderSuccess('sys_units_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>

					<!-- PROPERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $property_id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $property_id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $property_id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
								</div>
							</div>
						</div>
					</div>

					<!-- BUILDING OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card sub-property-card">
								<div class="card-body p-2">
									<a href="/sub-property/<?php echo $sub_property_id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_details); ?></a>
									<a href="/sub-property-units/<?php echo $sub_property_id; ?>" class="btn btn-primary mr-1"><i class="fa fa-door-open mr-2"></i><?php echo renderLang($units_units_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<form method="post" action="/submit-add-unit">
						
						<input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
						<input type="hidden" name="sub_property_id" value="<?php echo $sub_property_id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($units_add_unit_form); ?></h3>
								
							</div>
							<div class="card-body">
								
								<div class="row">

									<!-- UNIT NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_units_add_unit_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_unit_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="unit_name" name="unit_name" placeholder="<?php echo renderLang($units_unit_name_placeholder); ?>"<?php if(isset($_SESSION['sys_units_add_unit_name_val'])) { echo ' value="'.$_SESSION['sys_units_add_unit_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_unit_name_err'].'</p>'; unset($_SESSION['sys_units_add_unit_name_err']); } ?>
										</div>
									</div>

									<!-- UNIT TYPE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_units_add_unit_type_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_type" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_unit_type); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="unit_type" name="unit_type" required>
												<?php
												foreach($unit_type_arr as $unit_type) {
													echo '<option value="'.$unit_type[0].'"';
													if(isset($_SESSION['sys_units_add_unit_type_val'])) {
														if($_SESSION['sys_units_add_unit_type_val'] == $unit_type[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($unit_type[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_unit_type_err'].'</p>'; unset($_SESSION['sys_units_add_unit_type_err']); } ?>
										</div>
									</div>

									<!-- UNIT AREA -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_units_add_unit_area_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_area" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_unit_area); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="unit_area" name="unit_area" placeholder="<?php echo renderLang($units_unit_area_placeholder); ?>"<?php if(isset($_SESSION['sys_units_add_unit_area_val'])) { echo ' value="'.$_SESSION['sys_units_add_unit_area_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_unit_area_err'].'</p>'; unset($_SESSION['sys_units_add_unit_area_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($lang_status); ?></label>
                                            <select name="vacancy_status" id="unit-status" class="form-control">
                                                <?php 
                                                foreach($add_unit_options_arr as $key => $unit_status) {
                                                    echo '<option value="'.$key.'">'.renderLang($unit_status).'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- UNIT OWNER -->
									<div class="col-lg-3 col-md-4 unit-status unit-status-1"<?php if(isset($_SESSION['sys_units_add_vacancy_status_val'])) { if(!$_SESSION['sys_units_add_vacancy_status_val']) { echo ' style="display:block;"'; } else { echo ' style="display:none;"'; } } ?>>
										<?php $err = isset($_SESSION['sys_units_add_unit_owner_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_owner_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($unit_owners_unit_owner); ?></label>
											<select class="form-control select2<?php if($err) { echo ' is-invalid'; } ?>" id="unit_owner_id" name="unit_owner_id">
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_units_add_unit_owner_id_val'])) {
													$select_val = $_SESSION['sys_units_add_unit_owner_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM unit_owners WHERE temp_del = 0 ORDER BY lastname ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($select_val == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>';
													echo '['.$data['unit_owner_id'].'] ';
													switch($_SESSION['sys_language']) {
														case 0:
															echo $data['lastname'].', '.$data['firstname'];
															break;
														case 1:
															echo $data['lastname'].' '.$data['firstname'];
															break;
													}
													echo '</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_unit_owner_id_err'].'</p>'; unset($_SESSION['sys_units_add_unit_owner_id_err']); } ?>
										</div>
									</div>

                                </div>
								
								<div class="row">
									
									<!-- VACANT STATUS -->
									<!-- <div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_units_add_vacancy_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="vacancy_status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_vacant); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="vacancy_status" name="vacancy_status" required>
												<?php
												foreach($yesno_arr as $yesno) {
													echo '<option value="'.$yesno[0].'"';
													if(isset($_SESSION['sys_units_add_vacancy_status_val'])) {
														if($_SESSION['sys_units_add_vacancy_status_val'] == $yesno[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($yesno[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_vacancy_status_err'].'</p>'; unset($_SESSION['sys_units_add_vacancy_status_err']); } ?>
										</div>
									</div> -->
									
									<!-- VACANT TYPE -->
									<!-- <div class="col-lg-3 col-md-4 vacancy-status vacancy-status-1"<?php if(isset($_SESSION['sys_units_add_vacancy_status_val'])) { if($_SESSION['sys_units_add_vacancy_status_val']) { echo ' style="display:block;"'; } else { echo ' style="display:none;"'; } } ?>>
										<?php $err = isset($_SESSION['sys_units_add_vacancy_type_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="vacancy_type" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="vacancy_type" name="vacancy_type" required>
												<?php
												foreach($vacancy_type_arr as $vacancy_type) {
													echo '<option value="'.$vacancy_type[0].'"';
													if(isset($_SESSION['sys_units_add_vacancy_type_val'])) {
														if($_SESSION['sys_units_add_vacancy_type_val'] == $vacancy_type[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($vacancy_type[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_vacancy_type_err'].'</p>'; unset($_SESSION['sys_units_add_vacancy_type_err']); } ?>
										</div>
									</div> -->
									
								</div><!-- row -->
								
								<!-- RESIDENTIAL FORM -->
								<div class="row unit-type unit-type-0">
									
									<!-- UNIT CAPACITY -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_units_add_unit_capacity_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="unit_capacity" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_capacity); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="number" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="unit_capacity" name="unit_capacity"<?php if(isset($_SESSION['sys_units_add_unit_capacity_val'])) { echo ' value="'.$_SESSION['sys_units_add_unit_capacity_val'].'"'; } else { echo ' value="1"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_unit_capacity_err'].'</p>'; unset($_SESSION['sys_units_add_unit_capacity_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->
								
								<!-- COMMERCIAL FORM -->
								<div class="row unit-type unit-type-1 unit-type-2">
										
									<!-- COMMERCIAL UNIT TYPE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_units_add_commercial_unit_type_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="commercial_unit_type_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($units_commercial_type); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="commercial_unit_type_id" name="commercial_unit_type_id" required>
												<option value="0">TBD</option>
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_units_add_commercial_unit_type_id_val'])) {
													$select_val = $_SESSION['sys_units_add_commercial_unit_type_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM commercial_unit_types ORDER BY commercial_unit_type ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($select_val == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$data['commercial_unit_type'].'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_units_add_commercial_unit_type_id_err'].'</p>'; unset($_SESSION['sys_units_add_commercial_unit_type_id_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/sub-property-units/<?php echo $sub_property_id; ?>" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($units_save_unit); ?></button>
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
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function() {
			
			$('.duallistbox').bootstrapDualListbox();
			
			$('#unit_type').change(function() {
				var unit_type_index = $(this).val();
				$('.unit-type').hide();
				$('.unit-type-'+unit_type_index).show();
			});
            
            $('.unit-status').hide();
			$('#unit-status').change(function() {
				var unit_status = $(this).val();
				$('.unit-status').hide();
				$('.unit-status-'+unit_status).show();
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