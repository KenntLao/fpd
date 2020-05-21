<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// clear sessions from forms
	clearSessions();
	
	// check permission to access this page or function
	if(checkPermission('unit-owners')) {
	
		// set page
		$page = 'unit-owners';
		
		// get id
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT id, lastname, middlename, firstname, status, gender, birthdate, unit_owner_id, last_login, nationality, civil_status, photo FROM unit_owners JOIN countries ON citizenship_id = num_code WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			switch($_SESSION['sys_language']) {
				case 0:
					$fullname = $data['firstname'].' '.$data['lastname'];
					break;
				case 1:
					$fullname = $data['lastname'].' '.$data['firstname'];
					break;
			}
			$unit_owner_name = '['.$data['unit_owner_id'].'] '.$fullname;
			
			if($data['photo'] == '') {
				if($data['gender'] == 0) {
					$unit_owner_photo = '/dist/img/avatar2.png';
				} else {
					$unit_owner_photo = '/dist/img/avatar5.png';
				}
			} else {
				$unit_owner_photo = '/assets/images/profile/'.$data['photo'];
			}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $unit_owner_name; ?> &middot; <?php echo $sitename; ?></title>
	
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
								<i class="far fa-address-card mr-3"></i><?php echo renderLang($unit_owners_unit_owner_profile); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $unit_owner_name; ?>
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
						$_SESSION['sys_unit_owners_err'] = renderLang($unit_owners_unit_owner_deleted);
					}
					renderError('sys_permission_err');
					renderError('sys_unit_owners_err');
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
										<img class="profile-user-img img-fluid img-circle" src="<?php echo $unit_owner_photo; ?>" alt="User profile picture">
									</div>
									<h3 class="profile-username text-center"><?php echo $fullname; ?></h3>
									<p class="text-muted text-center">Unit Owner</p>
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
											<b><?php echo renderLang($unit_owners_unit_owner_id); ?></b> <a class="float-right"><?php echo $data['unit_owner_id']; ?></a>
										</li>
									</ul>
								</div>
							</div>

							<!-- PROPERTIES -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_properties); ?></h3>
								</div>
								<div class="card-body">
									<?php
									$properties_arr = array();
									$sql2 = $pdo->prepare("SELECT
										property_name,
										unit_name,
										units.property_id AS property_id_db
										FROM units
										LEFT JOIN properties ON units.property_id = properties.id
										WHERE unit_owner_id = ".$id."
										ORDER BY property_name ASC
										");
									$sql2->execute();
									if($sql2->rowCount() > 0) {
										while($_data = $sql2->fetch(PDO::FETCH_ASSOC)) {
											$property_link = '<a href="/property/'.$_data['property_id_db'].'">'.$_data['property_name'].'</a>';
											if(!in_array($property_link,$properties_arr)) {
												array_push($properties_arr,$property_link);
											}
										}
									} else {
										echo renderLang($unit_owners_no_properties_associated);
									}
									echo implode(', ',$properties_arr);
									?>
								</div>
							</div>
							
						</div>
						
						<!-- RIGHT COLUMN -->
						<div class="col-md-9">
							<div class="card">
								<div class="card-header p-2">
									<ul class="nav nav-pills">
										<li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab"><?php echo renderLang($unit_owners_personal); ?></a></li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										
										<!-- PERSONAL -->
										<div class="active tab-pane" id="personal">
											
											<h3><?php echo renderLang($unit_owners_personal); ?></h3>
											
											<div class="table-responsive">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<th class="w120"><?php echo renderLang($unit_owners_lastname); ?></th>
															<td><?php echo $data['lastname']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($unit_owners_firstname); ?></th>
															<td><?php echo $data['firstname']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($unit_owners_middlename); ?></th>
															<td><?php echo $data['middlename']; ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($unit_owners_gender); ?></th>
															<td>
																<?php
																foreach($gender_arr as $gender) {
																	if($gender[0] == $data['gender']) {
																		echo renderLang($gender[1]);
																	}
																}
																?>
															</td>
														</tr>
														<tr>
															<th><?php echo renderLang($unit_owners_civil_status); ?></th>
															<td>
																<?php
																foreach($civil_status_arr as $civil_status) {
																	if($civil_status[0] == $data['civil_status']) {
																		echo renderLang($civil_status[1]);
																	}
																}
																?>
															</td>
														</tr>
														<tr>
															<th><?php echo renderLang($unit_owners_birthdate); ?></th>
															<td><?php echo formatDate($data['birthdate']); ?></td>
														</tr>
														<tr>
															<th><?php echo renderLang($lang_citizenship_global); ?></th>
															<td><?php echo $data['nationality']; ?></td>
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
			$_SESSION['sys_unit_owners_err'] = renderLang($unit_owners_unit_owner_not_found);
			header('location: /unit_owners');

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