<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('employees')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'employees';
		
		// set fields from table to search on
		$fields_arr = array('employee_id','firstname','middlename','lastname');
		$search_placeholder = renderLang($employees_employee_id).', '.renderLang($employees_firstname).', '.renderLang($employees_middlename).', '.renderLang($employees_lastname);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM employees'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
		
		// check employee permission
		$permission_count = 0;
		if(checkPermission('employee-edit')) { $permission_count++; }
		if(checkPermission('employee-timesheet')) { $permission_count++; }
		switch($permission_count) {
			case 1: $option_col_width = 35; break;
			case 2: $option_col_width = 60; break;
			default: $option_col_width = 35; break;
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($employees_employees); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-users mr-3"></i><?php echo renderLang($employees_employees); ?></h1>
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
							<h3 class="card-title"><?php echo renderLang($employees_employees_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('employee-add')) { ?><a href="/add-employee" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($employees_add_employee); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover with-options">
									<thead>
										<tr>
											<th><?php echo renderLang($employees_employee_id); ?></th>
                                            <th><?php echo renderLang($employees_code_name); ?></th>
											<th><?php echo renderLang($employees_lastname); ?></th>
											<th><?php echo renderLang($employees_firstname); ?></th>
											<th><?php echo renderLang($employees_middlename); ?></th>
											<th><?php echo renderLang($roles_roles); ?></th>
											<th><?php echo renderLang($departments_department); ?></th>
											<th><?php echo renderLang($properties_property); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<th class="w150"><?php echo renderLang($employees_last_login); ?></th>
											<th style="width:<?php echo $option_col_width; ?>px;"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM employees".$where." ORDER BY employee_id ASC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// EMPLOYEE ID
                                                echo '<td><a href="/employee/'.$data['id'].'">'.$data['employee_id'].'</a></td>';
                                                
                                                // CODE NAME
                                                echo '<td>'.$data['code_name'].'</td>';

												// LAST NAME
												echo '<td>'.$data['lastname'].'</td>';

												// FIRST NAME
												echo '<td>'.$data['firstname'].'</td>';

												// MIDDLE NAME
												echo '<td>'.$data['middlename'].'</td>';

												// ROLES
												echo '<td>';
													$employee_roles_display_arr = array();
													$employee_roles_arr = explode(',',$data['role_ids']);
													foreach($employee_roles_arr as $employee_role) {
														if($employee_role != '') {
															$_data = getData($employee_role,'roles');
															array_push($employee_roles_display_arr,$_data['role_name']);
														}
													}
													echo implode($employee_roles_display_arr,', ');
												echo '</td>';
											
												// DEPARTMENT
												echo '<td>';
													if($data['department_id'] != 0) {
														$_data = getData($data['department_id'],'departments');
														echo '<a href="/department/'.$_data['id'].'">'.$_data['department_name'].'</a>';
													} else {
														echo '<small>TBD</small>';
													}
												echo '</td>';
											
												// PROPERTIES
												echo '<td>';
													$employee_properties_display_arr = array();
													$employee_properties_arr = explode(',',$data['property_ids']);
													foreach($employee_properties_arr as $employee_role) {
														if($employee_role != '') {
															$_data = getData($employee_role,'properties');
															array_push($employee_properties_display_arr,'<a href="/property/'.$_data['id'].'">'.$_data['property_name'].'</a>');
														}
													}
													echo implode($employee_properties_display_arr,', ');
												echo '</td>';

												// STATUS
												echo '<td>';
													foreach($status_arr as $status) {
														if($status[0] == $data['status']) {
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
												echo '</td>';

												// LAST LOGIN
												echo '<td>';
													if($data['last_login'] > 0) {
														echo date('Ymd',$data['last_login']).' &middot; '.date('H:i:s',$data['last_login']);
													} else {
														echo '-';
													}
												echo '</td>';

												// OPTIONS
												echo '<td>';
											
													// EDIT EMPLOYEE
													if(checkPermission('employee-edit')) {
														echo '<a href="/edit-employee/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($employees_edit_employee).'"><i class="fa fa-pencil-alt"></i></a>';
													}
											
													// VIEW EMPLOYEE TIMESHEET
													if(checkPermission('employee-timesheet')) {
														echo '<a href="/employee-timesheet/'.$data['id'].'" class="btn btn-warning btn-xs text-white" title="'.renderLang($employees_view_employee_timesheet).'"><i class="fa fa-clock"></i></a>';
													}

												echo '</td>'; // end options

											echo '</tr>';
										}
										?>
									</tbody>
								</table>
							</div><!-- table-responsive -->
							
							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/pagination-bottom.php'); ?>
							
						</div>
					</div><!-- card -->
					
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
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>