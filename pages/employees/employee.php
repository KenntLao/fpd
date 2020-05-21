<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// clear sessions from forms
	clearSessions();
	
	// check permission to access this page or function
	if(checkPermission('employees')) {
	
		// set page
		$page = 'employees';
		
		// get id
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM employees WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
			
			switch($_SESSION['sys_language']) {
				case 0:
					$fullname = $_data['firstname'].' '.$_data['lastname'];
					break;
				case 1:
					$fullname = $_data['lastname'].' '.$_data['firstname'];
					break;
			}
			$employee_name = '['.$_data['employee_id'].'] '.$fullname;
			
			if($_data['photo'] == '') {
				if($_data['gender'] == 0) {
					$employee_photo = '/dist/img/avatar2.png';
				} else {
					$employee_photo = '/dist/img/avatar5.png';
				}
			} else {
				$employee_photo = '/assets/images/profile/'.$_data['photo'];
			}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $employee_name; ?> &middot; <?php echo $sitename; ?></title>
	
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
								<i class="fa fa-users mr-3"></i><?php echo renderLang($employees_employee_profile); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $employee_name; ?>
							</h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php
					if($_data['status'] == 2 && $_data['temp_del'] != 0) {
						$_SESSION['sys_employees_err'] = renderLang($employees_employee_deleted);
					}
					renderError('sys_permission_err');
					renderError('sys_employees_err');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="row">
						
						<!-- LEFT COLUMN -->
						<div class="col-md-3">

							<!-- Profile Image -->
							<div class="card card-primary card-outline">
								<div class="card-body box-profile">
									<div class="text-center">
										<img class="profile-user-img img-fluid img-circle" src="<?php echo $employee_photo; ?>" alt="User profile picture">
									</div>
									<h3 class="profile-username text-center"><?php echo $fullname; ?></h3>
									<p class="text-muted text-center">
										<?php
										$employee_roles_display_arr = array();
										$employee_roles_arr = explode(',',$_data['role_ids']);
										foreach($employee_roles_arr as $employee_role) {
											if($employee_role != '') {
												$data = getData($employee_role,'roles');
												array_push($employee_roles_display_arr,$data['role_name']);
											}
										}
										echo implode($employee_roles_display_arr,', ');
										?>
									</p>
									<ul class="list-group list-group-unbordered mb-3">
										<li class="list-group-item">
											<b><?php echo renderLang($lang_status); ?></b>
											<a class="float-right">
												<?php
												foreach($status_arr as $status) {
													if($status[0] == $_data['status']) {
														switch($data['status']) {
															case 0:
																echo '<span class="text-success">'.renderLang($status[1]).'</span>';
																break;
															case 1:
																echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
																break;
														}
													}
												}
												?>
											</a>
										</li>
										<li class="list-group-item">
											<b><?php echo renderLang($employees_employee_id); ?></b> <a class="float-right"><?php echo $_data['employee_id']; ?></a>
										</li>
										<li class="list-group-item">
											<b><?php echo renderLang($departments_department); ?></b>
											<a class="float-right">
												<?php
												if($_data['department_id'] != 0) {
													$data = getData($_data['department_id'],'departments');
													echo $data['department_name'];
												} else {
													echo '<small>TBD</small>';
												}
												?>
											</a>
										</li>
									</ul>
								</div>
							</div>

							<!-- PROPERTIES -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_assigned_properties); ?></h3>
								</div>
								<div class="card-body">
									<?php
									$employee_properties_display_arr = array();
									$employee_properties_arr = explode(',',$_data['property_ids']);
									foreach($employee_properties_arr as $employee_role) {
										if($employee_role != '') {
											$data = getData($employee_role,'properties');
											array_push($employee_properties_display_arr,'<a href="/property/'.$data['id'].'">'.$data['property_name'].'</a>');
										}
									}
									echo implode($employee_properties_display_arr,', ');
									?>
								</div>
							</div>
							
						</div>
						
						<!-- RIGHT COLUMN -->
						<div class="col-md-9">
							<div class="card">
								<div class="card-header p-2">
									<ul class="nav nav-pills">
										<li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab"><?php echo renderLang($employees_personal); ?></a></li>
										<li class="nav-item"><a class="nav-link" href="#employement" data-toggle="tab"><?php echo renderLang($employees_employment); ?></a></li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										
										<!-- PERSONAL -->
										<div class="active tab-pane" id="personal">
											
											<h3><?php echo renderLang($employees_personal); ?></h3>
											
											<div class="table-responsive">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<th class="w120"><?php echo renderLang($employees_lastname); ?></th>
															<td><?php echo $_data['lastname']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($employees_firstname); ?></th>
															<td><?php echo $_data['firstname']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($employees_middlename); ?></th>
															<td><?php echo $_data['middlename']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($employees_gender); ?></th>
															<td>
																<?php
																foreach($gender_arr as $gender) {
																	if($gender[0] == $_data['gender']) {
																		echo renderLang($gender[1]);
																	}
																}
																?>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											
										</div>
										
										<!-- EMPLOYEMENT -->
										<div class="tab-pane" id="employement">
											
											<h3><?php echo renderLang($employees_employment); ?></h3>
											
											<div class="table-responsive">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<th class="w120"><?php echo renderLang($employees_position); ?></th>
															<td>
																<?php
																$employee_roles_display_arr = array();
																$employee_roles_arr = explode(',',$_data['role_ids']);
																foreach($employee_roles_arr as $employee_role) {
																	if($employee_role != '') {
																		$data = getData($employee_role,'roles');
																		array_push($employee_roles_display_arr,$data['role_name']);
																	}
																}
																echo implode($employee_roles_display_arr,', ');
																?>
															</td>
														</tr>
														<tr>
															<th><?php echo renderLang($departments_department); ?></th>
															<td>
																<?php
																if($_data['department_id'] != 0) {
																	$data = getData($_data['department_id'],'departments');
																	echo '<a href="/department/'.$data['id'].'">'.$data['department_name'].'</a>';
																} else {
																	echo '<small>TBD</small>';
																}
																?>
															</td>
														</tr>
														<tr>
															<th><?php echo renderLang($properties_properties); ?></th>
															<td>
																<?php
																$employee_properties_display_arr = array();
																$employee_properties_arr = explode(',',$_data['property_ids']);
																foreach($employee_properties_arr as $employee_role) {
																	if($employee_role != '') {
																		$data = getData($employee_role,'properties');
																		array_push($employee_properties_display_arr,'<a href="/property/'.$data['id'].'">'.$data['property_name'].'</a>');
																	}
																}
																echo implode($employee_properties_display_arr,', ');
																?>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											
										</div>
										
									</div><!-- tab-content -->
								</div><!-- card-body -->
							</div>
						</div><!-- col -->
						
					</div><!-- row -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	
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