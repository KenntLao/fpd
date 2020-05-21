<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// clear sessions from forms
	clearSessions();
	
	// check permission to access this page or function
	if(checkPermission('clients')) {
	
		// set page
		$page = 'clients';
		
		// get id
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM clients WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			$client_name = '['.$data['client_id'].'] '.$data['client_name'];
			$client_photo = '/assets/images/profile/default.png';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $client_name; ?> &middot; <?php echo $sitename; ?></title>
	
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
								<i class="fa fa-user-tie mr-3"></i><?php echo renderLang($clients_client_profile); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $client_name; ?>
							</h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php
					if($data['status'] == 2 && $data['temp_del'] != 0) {
						$_SESSION['sys_clients_err'] = renderLang($clients_client_deleted);
					}
					renderError('sys_permission_err');
					renderError('sys_clients_err');
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
										<img class="profile-user-img img-fluid img-circle bg-gray" src="<?php echo $client_photo; ?>" alt="User profile picture">
									</div>
									<h3 class="profile-username text-center"><?php echo $client_name; ?></h3>
									<p class="text-muted text-center">Client</p>
									<ul class="list-group list-group-unbordered mb-3">
										<li class="list-group-item">
											<b><?php echo renderLang($lang_status); ?></b>
											<a class="float-right">
												<?php
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
												?>
											</a>
										</li>
										<li class="list-group-item">
											<b><?php echo renderLang($clients_client_id); ?></b> <a class="float-right"><?php echo $data['client_id']; ?></a>
										</li>
									</ul>
								</div>
							</div>

							<!-- PROPERTIES -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-building mr-2"></i><?php echo renderLang($clients_assigned_properties); ?></h3>
								</div>
								<div class="card-body">
									<?php
									$client_id = $data['client_id'];
									$sql = $pdo->prepare("SELECT * FROM properties WHERE client_id = :client_id");
									$sql->bindParam(":client_id",$id);
									$sql->execute();
									while($_data = $sql->fetch(PDO::FETCH_ASSOC)) {
										echo $_data['property_name'];
									}
									if($sql->rowCount() == 0) {
										echo renderLang($clients_no_assigned_properties);
									}
									?>
								</div>
							</div>
							
						</div>
						
						<!-- RIGHT COLUMN -->
						<div class="col-md-9">
							<div class="card">
								<div class="card-header p-2">
									<ul class="nav nav-pills">
										<li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab"><?php echo renderLang($clients_client_details); ?></a></li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										
										<!-- PERSONAL -->
										<div class="active tab-pane" id="personal">
											
											<h3><?php echo renderLang($clients_client_details); ?></h3>
											
											<div class="table-responsive">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<th><?php echo renderLang($clients_client_name); ?></th>
															<td><?php echo $data['client_name']; ?></td>
														</tr>
														<tr>
															<th class="w120"><?php echo renderLang($clients_contact_person); ?></th>
															<td><?php echo $data['contact_person']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($clients_contact_details); ?></th>
															<td><?php echo $data['contact_details']; ?></td>
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
			$_SESSION['sys_clients_err'] = renderLang($clients_client_not_found);
			header('location: /clients');

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