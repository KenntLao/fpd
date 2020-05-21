<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('users')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'users';
		
		// get ID
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
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

			// set fields from table to search on
			$fields_arr = array('uname','firstname','lastname');
			$search_placeholder = renderLang($users_username).', '.renderLang($users_firstname).', '.renderLang($users_lastname);
			require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');

			$sql_query = 'SELECT * FROM system_log WHERE user_id='.$id; // set sql statement
			require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');

			$roles_arr = getTable('roles');
			$departments_arr = getTable('departments');
			$properties_arr = getTable('properties');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $fullname.' &middot; '.renderLang($users_user); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-user-secret mr-3"></i><?php echo renderLang($users_user); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					if($_data['status'] == 2 && $_data['temp_del'] != 0) {
						$_SESSION['sys_users_err'] = renderLang($users_messages_user_deleted);
					}
					renderError('sys_users_err');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($users_user_details); ?></h3>
							<div class="card-tools">
								<?php renderProfileStatus($_data['status']); ?>
							</div>
						</div>
						<div class="card-body">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th><?php echo renderLang($users_username); ?></th>
										<td><?php echo $_data['uname']; ?></td>
										<th><?php echo renderLang($users_fullname); ?></th>
										<td><?php echo $fullname; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($roles_roles); ?></th>
										<td>
											<?php
											$user_roles_display_arr = array();
											$user_roles_arr = explode(',',$_data['role_ids']);
											foreach($user_roles_arr as $user_role) {
												if($user_role != '') {
													$data = getData($user_role,'roles');
													array_push($user_roles_display_arr,$data['role_name']);
												}
											}
											echo implode($user_roles_display_arr,', ');
											?>
										</td>
										<th><?php echo renderLang($users_last_login); ?></th>
										<td>
											<?php
											if($_data['last_login'] > 0) {
												echo date('Ymd',$_data['last_login']).' &middot; '.date('H:i:s',$_data['last_login']);
											} else {
												echo '-';
											}
											?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div><!-- card -->
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($users_user_logs); ?></h3>
						</div>
						<div class="card-body">

							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/pagination-top.php'); ?>

							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th><?php echo renderLang($system_log_user); ?></th>
											<th><?php echo renderLang($system_log_module); ?></th>
											<th><?php echo renderLang($system_log_action); ?></th>
											<th><?php echo renderLang($system_log_target); ?></th>
											<th><?php echo renderLang($system_log_change_log); ?></th>
											<th><?php echo renderLang($system_log_time_stamp); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM system_log WHERE user_id = ".$id." ORDER BY id DESC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
			
										if($sql->rowCount() == 0) {
											echo '<tr><td colspan="6">'.renderLang($lang_no_data_display).'</td></tr>';
										} else {
			
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

												$data_count++;

												echo '<tr>';

												// USER ID
												echo '<td>';
													$_data = getData($data['user_id'],'users');
													switch($_SESSION['sys_language']) {
														case 0:
															echo '['.$_data['uname'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
															break;
														case 1:
															echo '['.$_data['uname'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
															break;
													}
												echo '</td>';

												// MODULE
												echo '<td>'.renderLang(${"module_".$data['module']}).'</td>';

												// ACTION
												echo '<td>'.renderLang(${"system_log_".$data['action']}).'</td>';

												// TARGET ID
												echo '<td>';
													switch($data['module']) {

														case 'role':
															$_data = getData($data['target_id'],'roles');
															echo '<a href="/role/'.$_data['id'].'">'.$_data['role_name'].'</a>';
															break;

														case 'user':
															$_data = getData($data['target_id'],'users');
															echo '<a href="/user/'.$_data['id'].'">';
															switch($_SESSION['sys_language']) {
																case 0:
																	echo '['.$_data['uname'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
																	break;
																case 1:
																	echo '['.$_data['uname'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
																	break;
															}
															echo '</a>';
															break;

														case 'employee':
															$_data = getData($data['target_id'],'employees');
															echo '<a href="/employee/'.$_data['id'].'">';
															switch($_SESSION['sys_language']) {
																case 0:
																	echo '['.$_data['employee_id'].']<br>'.$_data['firstname'].' '.$_data['lastname'];
																	break;
																case 1:
																	echo '['.$_data['employee_id'].']<br>'.$_data['lastname'].' '.$_data['firstname'];
																	break;
															}
															echo '</a>';
															break;

														case 'department':
															$_data = getData($data['target_id'],'departments');
															echo '<a href="/department/'.$_data['id'].'">['.$_data['department_code'].']<br>'.$_data['department_name'].'</a>';
															break;

														case 'property':
															$_data = getData($data['target_id'],'properties');
															echo '<a href="/property/'.$_data['id'].'">['.$_data['property_code'].']<br>'.$_data['property_name'].'</a>';
															break;
															
													}
												echo '</td>';

												// CHANGE LOG
												echo '<td>';

													// if ACTION is UPDATE
													if($data['action'] == 'update') {

														$change_log_arr = explode(';;',$data['change_log']);
														foreach($change_log_arr as $change_log) {

															$item_arr = explode('::',$change_log);
															$changes_arr = explode('==',$item_arr[1]);
															$field_name = $item_arr[0];
															$from_val = $changes_arr[0];
															$to_val = $changes_arr[1];

															// render permissions for roles
															if($field_name == 'lang_permissions') {

																$from_val_arr = explode(',',$from_val);
																foreach($from_val_arr as $i => $from_val) {
																	foreach($permissions_arr as $permission_group) {
																		foreach($permission_group as $permission) {
																			if($permission['permission_code'] == $from_val) {
																				$from_val_arr[$i] = renderLang($permission['permission_name']);
																				break;
																			}
																		}
																	}
																}
																$from_val = implode($from_val_arr,', ');

																$to_val_arr = explode(',',$to_val);
																foreach($to_val_arr as $i => $to_val) {
																	foreach($permissions_arr as $permission_group) {
																		foreach($permission_group as $permission) {
																			if($permission['permission_code'] == $to_val) {
																				$to_val_arr[$i] = renderLang($permission['permission_name']);
																				break;
																			}
																		}
																	}
																}
																$to_val = implode($to_val_arr,', ');

															}

															// render role name
															if($field_name == 'roles_roles') {

																$from_val_arr = explode(',',$from_val);
																foreach($from_val_arr as $i => $from_val) {
																	if($from_val == '') {
																		unset($from_val_arr[$i]);
																	} else {
																		foreach($roles_arr as $role) {
																			if($from_val == $role['id']) {
																				$from_val_arr[$i] = $role['role_name'];
																				break;
																			}
																		}
																	}
																}
																$from_val = implode($from_val_arr,', ');

																$to_val_arr = explode(',',$to_val);
																foreach($to_val_arr as $i => $to_val) {
																	if($to_val == '') {
																		unset($to_val_arr[$i]);
																	} else {
																		foreach($roles_arr as $role) {
																			if($to_val == $role['id']) {
																				$to_val_arr[$i] = $role['role_name'];
																				break;
																			}
																		}
																	}
																}
																$to_val = implode($to_val_arr,', ');

															}

															// department name
															if($field_name == 'departments_department') {

																if($from_val == 0) {
																	$from_val = 'TBD';
																} else {
																	foreach($departments_arr as $department) {
																		if($from_val == $department['id']) {
																			$from_val = $department['department_name'];
																			break;
																		}
																	}
																}

																if($to_val == 0) {
																	$to_val = 'TBD';
																} else {
																	foreach($departments_arr as $department) {
																		if($to_val == $department['id']) {
																			$to_val = $department['department_name'];
																			break;
																		}
																	}
																}

															}

															// property name
															if($field_name == 'properties_property') {

																if($from_val == 0) {
																	$from_val = 'TBD';
																} else {
																	foreach($properties_arr as $property) {
																		if($from_val == $property['id']) {
																			$from_val = $property['property_name'];
																			break;
																		}
																	}
																}

																if($to_val == 0) {
																	$to_val = 'TBD';
																} else {
																	foreach($properties_arr as $property) {
																		if($to_val == $property['id']) {
																			$to_val = $property['property_name'];
																			break;
																		}
																	}
																}

															}

															// render status
															if($field_name == 'lang_status') {

																foreach($status_arr as $status) {
																	if($status[0] == $from_val) {
																		$from_val = renderLang($status[1]);
																		break;
																	}
																}

																foreach($status_arr as $status) {
																	if($status[0] == $to_val) {
																		$to_val = renderLang($status[1]);
																		break;
																	}
																}

															}

															// render gender
															if($field_name == 'employees_gender') {

																foreach($gender_arr as $gender) {
																	if($gender[0] == $from_val) {
																		$from_val = renderLang($gender[1]);
																		break;
																	}
																}

																foreach($gender_arr as $gender) {
																	if($gender[0] == $to_val) {
																		$to_val = renderLang($gender[1]);
																		break;
																	}
																}

															}

															switch($_SESSION['sys_language']) {
																case 0:
																	echo '<em>'.renderLang(${$field_name}).'</em> from <strong>'.$from_val.'</strong> to <strong>'.$to_val.'</strong><br>';
																	break;
																case 1:
																	echo renderLang(${$field_name}).'が<strong>'.$from_val.'</strong>から<strong>'.$to_val.'</strong>に変更されました。<br>';
																	break;
															}
														}

													} else {
														echo '-';
													}

												echo '</td>';

												// TIMESTAMP
												echo '<td>'.date('Ymd',$data['epoch_time']).' &middot; '.date('H:i:s',$data['epoch_time']).'</td>';

												echo '</tr>';
											}
											
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
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_users_err'] = renderLang($users_user_not_found);
			header('location: /users');

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