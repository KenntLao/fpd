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
		
		// set fields from table to search on
		$fields_arr = array('uname','firstname','lastname');
		$search_placeholder = renderLang($users_username).', '.renderLang($users_firstname).', '.renderLang($users_lastname);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM users'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($users_users); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-user-secret mr-3"></i><?php echo renderLang($users_users); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_users_err');
					renderSuccess('sys_users_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($users_users_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('user-add')) { ?><a href="/add-user" class="btn btn-primary btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($users_add_user); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th><?php echo renderLang($users_username); ?></th>
											<th><?php echo renderLang($users_lastname); ?></th>
											<th><?php echo renderLang($users_firstname); ?></th>
											<th><?php echo renderLang($roles_roles); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<th><?php echo renderLang($users_last_login); ?></th>
											<th style="width:35px;"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM users".$where." ORDER BY uname ASC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// USER NAME
												echo '<td><a href="/user/'.$data['id'].'">'.$data['uname'].'</a></td>';

												// LASTNAME
												echo '<td>'.$data['lastname'].'</td>';

												// FIRSTNAME
												echo '<td>'.$data['firstname'].'</td>';

												// ROLES
												echo '<td>';
													$user_roles_display_arr = array();
													$user_roles_arr = explode(',',$data['role_ids']);
													foreach($user_roles_arr as $user_role) {
														if($user_role != '') {
															$_data = getData($user_role,'roles');
															array_push($user_roles_display_arr,$_data['role_name']);
														}
													}
													echo implode($user_roles_display_arr,', ');
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

													// EDIT USER
													if(checkPermission('user-edit')) {
														if($data['id'] != 1) {
															echo '<a href="/edit-user/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($users_edit_user).'"><i class="fa fa-pencil-alt"></i></a>';
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