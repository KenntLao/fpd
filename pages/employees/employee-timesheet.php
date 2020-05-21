<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('employee-timesheet')) {

		// clear sessions from forms
		clearSessions();

		// set page
		if($_SESSION['sys_account_mode'] == 'employee') {
			$page = 'employee-timesheet';
		} else {
			$page = 'employees';
		}
		
		// get user id
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM employees WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo renderLang($employees_time_sheet); ?> &middot; <?php echo $sitename; ?></title>

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
									<i class="fa fa-clock mr-3"></i><?php echo renderLang($employees_time_sheet); ?>
									<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
									<?php
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
						renderError('sys_employees_err');
						renderSuccess('sys_employees_suc');
						renderError('sys_time_err');
						renderSuccess('sys_time_suc');
						?>

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($employees_time_logs); ?></h3>
								<div class="card-tools">
									<div class="input-group" title="Select month to view timesheet">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
										</div>
										<select id="selected-month" class="form-control">
											<?php
											$month_start = 201910;
											$selected_yrmo = date('Ym',time());
											$year_val = date('Y',time());
											$month_val = date('m',time());
											for($x=$selected_yrmo;$x>=$month_start;$x--) {
												if($month_val < 1) {
													$year_val--;
													$month_val = 12;
													$x = $year_val.'12';
												}
												echo '<option value="'.$x.'">'.$x.'</option>';
												$month_val--;
											}
											?>
										</select>
									</div>
								</div><!-- card-tools -->
							</div><!-- card-header -->
							<div class="card-body">

								<!-- DATA TABLE -->
								<div class="table-responsive">
									<table id="table-data" class="table table-bordered table-striped table-hover with-options">
										<thead>
											<tr>
												<th><?php echo renderLang($employees_date); ?></th>
												<th class="text-center"><?php echo renderLang($employees_time_in); ?></th>
												<th class="text-center"><?php echo renderLang($employees_time_out); ?></th>
												<th class="text-center"><?php echo renderLang($employees_time_rendered); ?></th>
											</tr>
										</thead>
										<tbody id="employee_timesheet">
											<tr><td colspan="4">Loading...</td></tr>
										</tbody>
									</table>
								</div><!-- table-responsive -->

							</div>
						</div><!-- card -->

					</div><!-- container-fluid -->
				</section><!-- content -->

			</div>
			<!-- /.content-wrapper -->

			<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>

		</div><!-- wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
		<script>
			$(function() {
				
				// initial loading of employee timesheet
				showLoading();
				$('#employee_timesheet').load('/load-employee-timesheet/<?php echo $id; ?>/<?php echo $selected_yrmo; ?>');
				
				// load of employee timesheet for selected yrmo
				$('#selected-month').change(function() {
					showLoading();
					$('#employee_timesheet').html('<tr><td colspan="4"><img src="/assets/images/icon-loading.gif" alt="Loading..."></td></tr>');
					var yrmo = $(this).val();
					$('#employee_timesheet').load('/load-employee-timesheet/<?php echo $id; ?>/'+yrmo);
				});
				
			});
		</script>

	</body>

</html>
<?php
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_employees_err'] = renderLang($employees_employee_not_found);
			header('location: /employees');

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