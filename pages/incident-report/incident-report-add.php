<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('incident-report-add')) {

		// set page
		$page = 'incident-reports';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($incident_report_new); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($incident_report_new); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_visitors_add_err');
					?>
					
					<form method="post" action="/submit-add-incident-report">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($incident_report_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="unit_id"><?php echo renderLang($work_orders_unit_no); ?></label>
											<select name="unit_id" id="unit_id" class="form-control select2">
											<?php 
											if ($_SESSION['sys_account_mode'] == 'user') {

												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.temp_del = 0 ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_work_incident_report_add_unit_id_val']) && $_SESSION['sys_work_incident_report_add_unit_id_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}

											} else {

												$sub_property_ids =  get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

												$sub_properties = implode(',',$sub_property_ids);

												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.temp_del = 0 AND u.sub_property_id IN ($sub_properties) ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_work_incident_report_add_unit_id_val']) && $_SESSION['sys_work_incident_report_add_unit_id_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}
											}
											?>
											</select>
											
										</div>
									</div>

									<!-- SERVICE -->
									<div class="col-lg-3 col-md-4">
										<label for="service"><?php echo renderLang($service_requests_service); ?></label>
										<select name="service" id="service" class="form-control">
											<?php 
											foreach($service_request_service_arr as $key => $value) {
												echo '<option '.(isset($_SESSION['sys_sys_service_requests_add_service_val'])  && $_SESSION['sys_sys_service_requests_add_service_val'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
											}
											?>
										</select>
									</div>

                                    <!-- incident_report_date -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($incident_report_date); ?></label>
											<input type="text" class="form-control date" name="date">
										</div>
									</div>
									
									<!-- incident_report_time -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_in"><?php echo renderLang($incident_report_time); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right " name="time_in" id="time_in">
											</div>
										</div>
									</div>

								</div>
									
								<div class="row">

									<!-- SEVERITY LEVEL  -->
									<div class="col-lg-3 col-md-4">
										<label for="severity_level"><?php echo renderLang($incident_report_severity_level); ?></label>
										<select class="form-control select2" id="severity_level" name="severity_level" <?php if(isset($_SESSION['sys_incident_report_add_severity_level_val'])) { echo ' value="'.$_SESSION['sys_incident_report_add_severity_level_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($severity_level_arr as $key => $value) {
                                            			echo '<option '.($_data['severity_level'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  						</select>
									</div>

									<!-- REMARKS  -->
									<div class="col-lg-3 col-md-4">
										<label for="remarks"><?php echo renderLang($service_requests_remarks); ?></label>
										<select class="form-control select2" id="remarks" name="remarks" <?php if(isset($_SESSION['sys_incident_report_add_remarks_val'])) { echo ' value="'.$_SESSION['sys_incident_report_add_remarks_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($service_request_remarks_arr as $key => $value) {
                                            			echo '<option '.($_data['remarks'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  						</select>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="status"><?php echo renderLang($contract_status); ?></label>
											<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_incident_report_add_status_val'])) { echo ' value="'.$_SESSION['sys_incident_report_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($service_request_status_arr as $key => $value) {
                                            			echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>	
										</div>
									</div>

									
								</div><!-- row -->

								<div class="row">

									<!-- DESCRIPTION -->
									<div class="col-lg-6 col-md-12">
										<label for="description"><?php echo renderLang($service_requests_description); ?></label>
										<textarea name="description" id="description" rows="3" class="form-control notes"><?php if(isset($_SESSION['sys_incident_report_add_description_val'])) { echo ''.$_SESSION['sys_incident_report_add_description_val'].''; } ?></textarea>
									</div>


									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/incident-reports" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($incident_report_save); ?></button>
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

			$('.date').daterangepicker({
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