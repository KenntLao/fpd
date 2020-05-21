<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('gate-pass-employees')) {

		// set page
		$page = 'gate-pass-employees';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT g.id, g.date, g.employee_name, g.purpose, g.time_in, g.time_out, g.person_department, g.prospect_id, g.property_id, p.property_name FROM gate_pass_employees g LEFT JOIN properties p ON (g.property_id = p.id) WHERE g.temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($gate_pass_employee); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($gate_pass_employee); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['employee_name']; ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_gate_pass_employees_add_suc');
					?>

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($gate_pass_employees_details); ?></h3>
							</div>
							<div class="card-body">

								<div class="table-responsive">
                                	<table class="table table-bordered">
                                        <tr>
                                            <th class="w300"><?php echo renderLang($gate_pass_employees_project_name); ?></th>
	                                		<?php 
											if (empty($_data['property_id'])) {

												$project_code = getField('reference_number','prospecting','id ='.$_data['prospect_id']);
												
												echo '<td>'.(!empty($_data['prospect_id']) ? $_data['property_name'].' ['.$project_code.']' : '').'</td>';

											} else {

												$property_code = getField('property_id','properties','id ='.$_data['property_id']);
												
												echo '<td>'.(!empty($_data['property_id']) ? $_data['property_name'].' ['.$property_code.']' : '').'</td>';

											}
											?>
                                        </tr>
                                        <tr>
                                            <th class="w300"><?php echo renderLang($gate_pass_employees_employee_name); ?></th>
                                            <td><?php echo $_data['employee_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($gate_pass_employees_purpose); ?></th>
                                            <td><?php echo $_data['purpose']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($gate_pass_employees_date_employee); ?></th>
                                            <td><?php echo  formatDate($_data['date']); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($gate_pass_employees_time_in); ?></th>
                                            <td><?php echo $_data['time_in']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($gate_pass_employees_time_out); ?></th>
                                            <td><?php echo $_data['time_out']; ?></td>
                                        </tr>                                	
                                    </table>
                            	</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/gate-pass-employees" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if(checkPermission('gate-pass-employee-edit')) { ?>
								<a href="/edit-gate-pass-employee/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($gate_pass_employees_edit_employee); ?></a>
								<?php } ?>
							</div>
						</div><!-- card -->
					
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
				singleDatePicker: true
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