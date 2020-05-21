<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('roles')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'roles';
		
		// set fields from table to search on
		$fields_arr = array('role_name');
		$search_placeholder = renderLang($roles_role_name);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM roles'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($roles_roles); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-id-badge mr-3"></i><?php echo renderLang($roles_roles); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_roles_err');
					renderSuccess('sys_roles_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($roles_roles_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('role-add')) { ?><a href="/add-role" class="btn btn-primary btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($roles_add_role); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th><?php echo renderLang($roles_role_name); ?></th>
											<th><?php echo renderLang($lang_permissions); ?></th>
											<th><?php echo renderLang($lang_number_of_users); ?></th>
											<?php if(checkPermission('role-edit')) { ?>
											<th style="width:35px;"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM roles".$where." ORDER BY role_name ASC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// ROLE NAME
												echo '<td><a href="/role/'.$data['id'].'">'.$data['role_name'].'</a></td>';

												// DISPLAY PERMISSIONS
												echo '<td>';

													// all permission granted
													if($data['permissions'] == 'all') {

														echo renderLang($all_permissions);

													} else { // selected permissions granted

														// convert to role permissions array
														$role_permissions_arr = explode(',',$data['permissions']);

														// loop permissions group list
														foreach($permissions_arr as $permission_group) {

															// reset counter to determin first permission for permission group
															$ctr = 0;

															// set DIV for division of permission group
															echo '<div class="permissions-group">';

																// loop permissions inside permission group
																foreach($permission_group as $permission) {

																	// loop for role permission
																	foreach($role_permissions_arr as $role_permission) {

																		// compare role code for each role permission to get role name
																		if($permission['permission_code'] == $role_permission) {

																			// check counter to print division of permission using dot
																			if($ctr > 0) {
																				echo ' &middot; ';
																			}

																			// display role name
																			echo '<span title="'.renderLang($permission['permission_description']).'">'.renderLang($permission['permission_name']).'</span>';

																			// increase counter
																			$ctr++;

																			break; // stop loop
																		}

																	} // end loop for role permissions

																} // end loop for permissions inside group

															// close group permission div
															echo '</div>';

														} // end loop for group list

													} // end else

												echo '</td>'; // end display permissions

												// NUMBER OF USERS
												echo '<td>';

													// get from USERS table
													$sql2 = $pdo->prepare("SELECT id, role_ids, temp_del FROM users WHERE role_ids LIKE '%,".$id.",%' AND temp_del=0");
													$sql2->execute();
													$users_ctr = $sql2->rowCount();

													// get from EMPLOYEES table
													$sql2 = $pdo->prepare("SELECT id, role_ids, temp_del FROM employees WHERE role_ids LIKE '%,".$id.",%' AND temp_del=0");
													$sql2->execute();
													$employees_ctr = $sql2->rowCount();

													echo number_format($users_ctr + $employees_ctr,0,'.',',');

												echo '</td>';

												// OPTIONS
												echo '<td>';

													// EDIT ROLE
													if(checkPermission('role-edit')) {
														if($data['id'] != 1) {
															echo '<a href="/edit-role/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($roles_edit_role).'"><i class="fa fa-pencil-alt"></i></a>';
														}
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