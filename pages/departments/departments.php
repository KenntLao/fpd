<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('departments')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'departments';
		
		// set fields from table to search on
		$fields_arr = array('department_code','department_name');
		$search_placeholder = renderLang($departments_department_code).', '.renderLang($departments_department_name);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM departments'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($departments_departments); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-briefcase mr-3"></i><?php echo renderLang($departments_departments); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_departments_err');
					renderSuccess('sys_departments_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($departments_departments_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('department-add')) { ?><a href="/add-department" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($departments_add_department); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th><?php echo renderLang($departments_department_code); ?></th>
											<th><?php echo renderLang($departments_department_name); ?></th>
											<th><?php echo renderLang($lang_number_of_employees); ?></th>
											<th style="width:35px;"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM departments".$where." ORDER BY department_code ASC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// DEPARTMENT CODE
												echo '<td><a href="/department/'.$data['id'].'">'.$data['department_code'].'</a></td>';

												// DEPARTMENT NAME
												echo '<td><a href="/department/'.$data['id'].'">'.$data['department_name'].'</a></td>';

												// NUMBER OF USERS
												echo '<td>';

													// get from EMPLOYEES table
													$sql2 = $pdo->prepare("SELECT id, department_id, temp_del FROM employees WHERE department_id = ".$id." AND temp_del=0");
													$sql2->execute();
													$employees_ctr = $sql2->rowCount();

													echo number_format($employees_ctr,0,'.',',');

												echo '</td>';

												// OPTIONS
												echo '<td>';

													// EDIT DEPARTMENT
													if(checkPermission('department-edit')) {
														echo '<a href="/edit-department/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($departments_edit_department).'"><i class="fa fa-pencil-alt"></i></a>';
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