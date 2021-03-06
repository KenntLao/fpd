<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('service-request-add')) {

		// set page
		$page = 'service-requests';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($service_requests); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-exclamation-circle mr-3"></i><?php echo renderLang($service_requests_new_service_request); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_complaints_add_suc');
					?>
					
					<form method="post" action="/submit-add-service-request">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($service_requests_add_service_request_form); ?></h3>
							</div>
							<div class="card-body">


								<div class="row">


									<!-- SERVICE  -->
									<div class="col-lg-3 col-md-4">
										<label for="service"><?php echo renderLang($service_requests_service); ?></label>
										<select class="form-control select2" id="service" name="service" <?php if(isset($_SESSION['sys_service_requests_add_service_val'])) { echo ' value="'.$_SESSION['sys_service_requests_add_service_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($service_request_service_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  						</select>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="unit"><?php echo renderLang($work_orders_unit_no); ?></label>
											<select name="unit" id="unit" class="form-control select2">
											<?php 
											if ($_SESSION['sys_account_mode'] == 'user') {

												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.temp_del = 0 ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_work_order_add_unit_val']) && $_SESSION['sys_work_order_add_unit_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}

											} else {

												$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                                                $sub_properties = "0";
                                                if(!empty($sub_property_ids)) {
                                                    $sub_properties = implode(", ", $sub_property_ids);
                                                }

                                                $sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.temp_del = 0 AND u.sub_property_id IN ($sub_properties) ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_work_order_add_unit_val']) && $_SESSION['sys_work_order_add_unit_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}

											}
											?>
											</select>
											
										</div>
									</div>


									<!-- ASSESSMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="assessment"><?php echo renderLang($service_requests_assessment); ?></label>
										<input type="text" class="form-control" name="assessment" <?php if(isset($_SESSION['sys_service_requests_add_assessment_val'])) { echo ' value="'.$_SESSION['sys_service_requests_add_assessment_val'].'"'; } ?> required>
									</div>

									<!-- REMARKS  -->
									<div class="col-lg-3 col-md-4">
										<label for="remarks"><?php echo renderLang($service_requests_remarks); ?></label>
										<select class="form-control select2" id="remarks" name="remarks" <?php if(isset($_SESSION['sys_service_requests_edit_remarks_val'])) { echo ' value="'.$_SESSION['sys_service_requests_edit_remarks_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($service_request_remarks_arr as $key => $value) {
                                            			echo '<option '.($_data['remarks'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  						</select>
									</div>
									
								</div>
									
								<div class="row">

									<!-- DESCRIPTION -->
									<div class="col-lg-6 col-md-12">
										<label for="description"><?php echo renderLang($service_requests_description); ?></label>
										<textarea name="description" id="description" rows="3" class="form-control notes"><?php if(isset($_SESSION['sys_service_requests_add_description_val'])) { echo ''.$_SESSION['sys_service_requests_add_description_val'].''; } ?></textarea>
									</div>


									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/service-requests" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($service_requests_save_service_request); ?></button>
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

			$('#date').daterangepicker({
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