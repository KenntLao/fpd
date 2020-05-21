<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('work-order-add')) {

	$page = 'work-orders';

	$id = $_GET['id'];

	
	// suggested client ID
    $sql = $pdo->prepare("SELECT two.id, u.id, two.target_id, two.employee_id, two.status, two.work_order_description, sr.unit_id, two.work_order_nature, two.work_order_date, two.work_order_no  FROM task_work_order two LEFT JOIN service_requests sr ON (two.target_id = sr.id) LEFT JOIN units u ON (sr.unit_id = u.id) LEFT JOIN employees e ON e.id = two.employee_id  WHERE two.id = :id LIMIT 1");
    $sql->bindParam(":id", $id);
	$sql->execute();
    $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
    $err = 0;

    $_SESSION['sys_assign_work_order_add_work_order_nature_val'] = $_data['work_order_nature'];
    $_SESSION['sys_assign_work_order_add_unit_val'] = $_data['unit_id'];
    $_SESSION['sys_assign_work_order_add_assigned_val'] = $_data['employee_id'];
	

	
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($work_orders_work_order_edit); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($work_orders_work_order_edit); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['work_order_no']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

					<?php 
					renderError('sys_assign_work_order_add_err');
					?>

					<form action="/submit-assign-work-order" method="post">

						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="hidden" name="target_id" value="<?php echo $_data['target_id'] ?>">

						<div class="card">
							<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($work_orders_add_work_order_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">
									
									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="status"><?php echo renderLang($contract_status); ?></label>
											<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_contract_add_status_val'])) { echo ' value="'.$_SESSION['sys_contract_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($service_request_status_arr as $key => $value) {
                                            			echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>	
										</div>
									</div>

								</div>

								<div class="row">
									
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_assign_work_order_add_work_order_no_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="work-order-no" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($work_orders_work_order_no); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required <?php echo $err ? 'is-required' : ''; ?>" id="work-order-no" value="<?php echo $_data['work_order_no']; ?>" name="work-order-no" readonly>
											<?php 
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_assign_work_order_add_work_order_no_err'].'</p>' : '';
											unset($_SESSION['sys_assign_work_order_add_work_order_no_err']);
											?>
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_assign_work_order_add_date_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="date" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($work_orders_date); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required <?php echo $err ? 'is-required' : ''; ?>" id="date" name="date" <?php echo isset($_SESSION['sys_assign_work_order_add_date_val']) ? 'value="'.$_SESSION['sys_assign_work_order_add_date_val'].'"' : 'value="'.formatDate($_data['work_order_date'], true, false, false).'"';  ?> >
											<?php 
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_assign_work_order_add_date_err'].'</p>' : '';
											unset($_SESSION['sys_assign_work_order_add_date_err']);
											?>
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_assign_work_order_add_assigned_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="assign" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($work_orders_Assign_to); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="assigned" id="" class="form-control select2 required" id="assign">
												<?php 
												$sql = $pdo->prepare('SELECT * FROM employees WHERE temp_del = 0');
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_assign_work_order_add_assigned_val']) && $_SESSION['sys_assign_work_order_add_assigned_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">';
													echo $data['firstname'].(isset($data['middlename']) ? ' '.$data['middlename'].' ' : '').$data['lastname'];
													echo '</option>';
												}
												?>
											</select>
											<?php 
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_assign_work_order_add_assigned_err'].'</p>' : '';
											unset($_SESSION['sys_assign_work_order_add_assigned_err']);
											?>
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_assign_work_order_add_work_order_nature_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="date" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($work_orders_nature_of_the_job); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="work_order_nature" id="nature" class="form-control required">
											<?php 
											foreach($nature_of_job_arr as $key => $value) {
												echo '<option '.(isset($_SESSION['sys_assign_work_order_add_work_order_nature_val'])  && $_SESSION['sys_assign_work_order_add_work_order_nature_val'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
											}
											?>
											</select>
											<?php 
											echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_assign_work_order_add_work_order_nature_err'].'</p>' : '';
											unset($_SESSION['sys_assign_work_order_add_work_order_nature_err']);
											?>
										</div>
									</div>

									<div class="col-lg-3 col-md-4 <?php echo isset($_SESSION['sys_assign_work_order_add_work_order_nature_val']) && $_SESSION['sys_assign_work_order_add_work_order_nature_val'] == 3 ? '' : 'd-none'; ?> specify">
										<div class="form-group">
											<label for="specify"><?php echo renderLang($work_orders_specify); ?></label>
											<input type="text" class="form-control" name="specify" id="specify" value="<?php echo isset($_SESSION['sys_assign_work_order_add_work_order_nature_specify_val']) ? $_SESSION['sys_assign_work_order_add_work_order_nature_specify_val'] : ''; ?>">
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-lg-6 col-md-12">
										<label for="job_particulars"><?php echo renderLang($work_orders_job_particulars); ?></label>
										<textarea name="job_particulars" id="job_particulars" rows="3" class="form-control notes"><?php echo $_data['work_order_description']; ?></textarea>
									</div>

								</div>

								<div class="row mt-2">
											
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="unit"><?php echo renderLang($work_orders_unit_no); ?></label>
											<select name="unit" id="unit" class="form-control select2">
											<?php 
											if ($_SESSION['sys_account_mode'] == 'user') {

												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.temp_del = 0 ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_assign_work_order_add_unit_val']) && $_SESSION['sys_assign_work_order_add_unit_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}

											} else {

												$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

	                                			$sub_properties = implode(',',$sub_property_ids);

												$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.temp_del = 0 AND u.sub_property_id IN ($sub_properties) ORDER BY unit_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.(isset($_SESSION['sys_assign_work_order_add_unit_val']) && $_SESSION['sys_assign_work_order_add_unit_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].' '.$data['sub_property_name'].', '.$data['property_name'].'</option>';
												}
											}
											?>
											</select>
											
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="request" class="mr-1"><?php echo renderLang($work_orders_requested_by); ?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select name="requested_by" id="request" class="form-control select2 required">
												<?php 
	                                            $sql = $pdo->prepare("SELECT complainant, account_type FROM service_requests");
	                                            $sql->execute();
	                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                            	if ($data['account_type'] == 'user') {

	                                                	echo '<option value="'.$data['complainant'].'">'.(checkVar($data['complainant']) ? getField('uname','users','id = '.$data['complainant']) : 'unknown').' ['.$data['account_type'].']</option>';
	                                            	} else {

	                                            		echo '<option value="'.$data['complainant'].'">'.(checkVar($data['complainant']) ? getField('firstname','employees','id = '.$data['complainant']).''.getField('lastname','employees','id = '.$data['complainant']) : 'unknown').' ['.$data['account_type'].']</option>';

	                                            	}
	                                            }
	                                            ?>
												
											</select>
										</div>
									</div>

								</div>
								

							</div>
							<div class="card-footer text-right">
								<a href="/work-orders" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
								<button type="submit" class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($work_orders_work_order_update); ?></button>
							</div>
						</div>

					</form>

				</div>

			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function(){

			// set requested by based on unit
			var unit_id = $('#unit').val();

			//$.post('/work-order-options', {
			//	unit_id:unit_id
			//}, function(data){
			//	$('#request').html(data);
			//});

			$('#unit').on('change', function(){

				unit_id = $(this).val();

				$.post('/work-order-options', {
					unit_id:unit_id
				}, function(data){
					$('#request').html(data);
				});
			});

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

			// add specify field others is selected
			$('#nature').on('change', function(){

				var val = $(this).val();

				if(val == 3) {

					$('.specify').removeClass('d-none');

				} else {

					$('.specify').addClass('d-none');

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