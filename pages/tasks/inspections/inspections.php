<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('inspection-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'inspections';
		
		// set fields from table to search on
		$fields_arr = array('client_id','client_name','contact_person');
		$search_placeholder = renderLang($clients_client_id).', '.renderLang($clients_client_name).', '.renderLang($clients_contact_person);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM clients'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($inspection); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row my-3">
						<div class="col-sm-9">
							<h1><i class="fas fa-search mr-3"></i><?php echo renderLang($inspection); ?></h1>
						</div>
						<div class="col-sm mt-1">
							<div class=" float-sm-right">
								<div class="card-tools">
									<div class="form-group mx-1">
										<select class="form-control select2">
                    					<option selected="selected">Not Completed</option>
                    					<option>Enhancement</option>
                    					<option>Medium</option>
                  						</select>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_err');
					renderSuccess('sys_clients_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($inspection_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('client-add')) { ?><a href="/inspection-sheet" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($inspection_add_inspection); ?></a><?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

                            <!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($tasks_task); ?></th>
											<th><?php echo renderLang($tasks_assignment); ?></th>
											<th><?php echo renderLang($tasks_date); ?></th>
											<th><?php echo renderLang($tasks_status); ?></th>
											<th><?php echo renderLang($tasks_priority); ?></th>
											<th><?php echo renderLang($tasks_activity); ?></th>
											<th><?php echo renderLang($tasks_remarks); ?></th>
											
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Sample Task</td>
											<td>Guiller Dela Cruz</td>
											<td>December 20, 2020</td>
											<td>Ongoing</td>
											<td>Medium</td>
											<td>N/A</td>
											<td>N/A</td>
										</tr>
										<tr>
											<td>Sample Task</td>
											<td>Guiller Dela Cruz</td>
											<td>December 20, 2020</td>
											<td>Ongoing</td>
											<td>Medium</td>
											<td>N/A</td>
											<td>N/A</td>
										</tr>
										<tr>
											<td>Sample Task</td>
											<td>Guiller Dela Cruz</td>
											<td>December 20, 2020</td>
											<td>Ongoing</td>
											<td>Medium</td>
											<td>N/A</td>
											<td>N/A</td>
										</tr>
										<tr>
											<td>Sample Task</td>
											<td>Guiller Dela Cruz</td>
											<td>December 20, 2020</td>
											<td>Ongoing</td>
											<td>Medium</td>
											<td>N/A</td>
											<td>N/A</td>
										</tr>
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