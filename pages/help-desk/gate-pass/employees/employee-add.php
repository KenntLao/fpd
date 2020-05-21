<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('gate-pass-employee-add')) {

		// set page
		$page = 'gate-pass-employee';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($gate_pass_employees_new_employee); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($gate_pass_employee); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<form method="post" action="/submit-add-gate-pass-employee">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($gate_pass_employees_add_employee_form); ?></h3>
							</div>
							<div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_id" class="mr-1"><?php echo renderLang($prf_project); ?></label>
                                            <select name="property_id" id="property_id" class="form-control select2 ">
                                                <?php 
                                                if($_SESSION['sys_account_mode'] == 'user') {

                                                    $sql = $pdo->prepare("SELECT property_name, property_id, id FROM properties WHERE temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['property_name'].' ['.$data['property_id'].']</option>';
                                                    }

                                                } else {

                                                    $property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];

                                                    foreach($property_ids as $property_id) {

                                                        $sql = $pdo->prepare("SELECT id, property_name, property_id FROM properties WHERE temp_del = 0 AND id = :id");
                                                        $sql->bindParam(":id", $property_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                            echo '<option value="'.$data['id'].'">'.$data['property_name'].' ['.$data['property_id'].']</option>';
                                                        }

                                                    }

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

									<!-- DATE -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($lang_date); ?></label>
											<input type="text" class="form-control input-readonly" readonly value="<?php echo formatDate(time(), true, false); ?>">
										</div>
									</div>
									
									<!-- TIME IN -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_in"><?php echo renderLang($visitors_time_in); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right input-readonly" name="time_in" id="time_in" value="<?php echo $curr_time; ?>" required readonly>
											</div>
										</div>
									</div>

									
								</div><!-- row -->

								<div class="row">

									<!-- employee_name -->
									<div class="col-lg-3 col-md-4">
										<label for="employee_name"><?php echo renderLang($gate_pass_employees_employee_name); ?></label>
										<input type="text" class="form-control" name="employee_name" <?php if(isset($_SESSION['sys_gate_pass_employee_add_employees_name_val'])) { echo ' value="'.$_SESSION['sys_gate_pass_employee_add_employees_name_val'].'"'; } ?> required>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($gate_pass_employees_purpose); ?></label>
										<input type="text" class="form-control" name="purpose" <?php if(isset($_SESSION['sys_gate_pass_employees_add_purpose_val'])) { echo ' value="'.$_SESSION['sys_gate_pass_employees_add_purpose_val'].'"'; } ?> required>
									</div>

									<!-- DEPARTMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="person_department"><?php echo renderLang($gate_pass_employees_person_department); ?></label>
										<input type="text" class="form-control" name="person_department" <?php if(isset($_SESSION['sys_gate_pass_employees_add_person_department_val'])) { echo ' value="'.$_SESSION['sys_gate_pass_employees_add_person_department_val'].'"'; } ?> required>
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/gate-pass-employees" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($gate_pass_employees_save_employee); ?></button>
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