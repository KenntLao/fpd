<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('clients')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'clients';
		
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
	<title><?php echo renderLang($clients_clients); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-user-tie mr-3"></i><?php echo renderLang($clients_clients); ?></h1>
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
							<h3 class="card-title"><?php echo renderLang($clients_clients_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('client-add')) { ?><a href="/add-client" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($clients_add_client); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover with-options">
									<thead>
										<tr>
											<th><?php echo renderLang($clients_client_id); ?></th>
											<th><?php echo renderLang($clients_client_name); ?></th>
											<th><?php echo renderLang($clients_contact_person); ?></th>
											<th><?php echo renderLang($clients_contact_details); ?></th>
											<th><?php echo renderLang($properties_property); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<?php if(checkPermission('client-edit')) { ?>
											<th style="width:35px;"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM clients".$where." ORDER BY client_id ASC LIMIT ".$sql_start.",".$numrows);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// client ID
												echo '<td><a href="/client/'.$data['id'].'">'.$data['client_id'].'</a></td>';

												// CLIENT NAME
												echo '<td>'.$data['client_name'].'</td>';
											
												// CONTACT PERSON
												echo '<td>'.$data['contact_person'].'</td>';
											
												// LAST NAME
												echo '<td>'.$data['contact_details'].'</td>';
											
												// PROPERTIES
												echo '<td>';
													$client_id = $data['client_id'];
													$sql2 = $pdo->prepare("SELECT * FROM properties WHERE client_id = :client_id");
													$sql2->bindParam(":client_id",$id);
													$sql2->execute();
													while($_data = $sql2->fetch(PDO::FETCH_ASSOC)) {
														echo '<a href="/property/'.$_data['id'].'">'.$_data['property_name'].'</a>';
													}
													if($sql2->rowCount() == 0) {
														echo '<small>TBD</small>';
													}
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

												// OPTIONS
												echo '<td>';
												
											
													// EDIT CLIENT
													if(checkPermission('client-edit')) {
														echo '<a href="/edit-client/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($clients_edit_client).'"><i class="fa fa-pencil-alt"></i></a>';
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