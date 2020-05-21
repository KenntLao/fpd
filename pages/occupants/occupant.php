<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// clear sessions from forms
	clearSessions();
	
	// check permission to access this page or function
	if(checkPermission('occupants')) {
	
		// set page
		$page = 'occupants';
		
		// get id
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT id, firstname, civil_status, middlename, lastname, gender, status, birthdate, social_status, relationship_to_tenant, unit_id, nationality FROM occupants o JOIN countries c ON (o.citizenship_id = c.num_code) WHERE id = :id LIMIT 1");
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
			$occupant_name = $fullname;
			
			$occupant_photo = '/assets/images/profile/default.png';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $occupant_name; ?> &middot; <?php echo $sitename; ?></title>
	
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
								<i class="far fa-address-card mr-3"></i><?php echo renderLang($occupants_occupant_profile); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $occupant_name; ?>
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
						$_SESSION['sys_occupants_err'] = renderLang($occupants_occupant_deleted);
					}
					renderError('sys_permission_err');
					renderError('sys_occupants_err');
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
										<img class="profile-user-img img-fluid img-circle bg-gray" src="<?php echo $occupant_photo; ?>" alt="User profile picture">
									</div>
									<h3 class="profile-username text-center"><?php echo $fullname; ?></h3>
									<p class="text-muted text-center"><?php echo renderLang($occupants_occupant); ?></p>
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
									</ul>
								</div>
							</div>

							<!-- UNITS -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-building mr-2"></i><?php echo renderLang($units_unit); ?></h3>
								</div>
								<div class="card-body">
								<?php 
								$sql = $pdo->prepare("SELECT u.id, sub_property_name, unit_name, property_name FROM units u LEFT JOIN sub_properties sp ON(u.sub_property_id = sp.id) LEFT JOIN properties p ON(u.property_id = p.id) WHERE u.id = :unit_id");
								$sql->bindParam(":unit_id", $data['unit_id']);
								$sql->execute();
								while($data2 = $sql->fetch(PDO::FETCH_ASSOC)) {
									echo '<a href="/unit/'.$data2['id'].'">'.$data2['unit_name'].' '.$data2['sub_property_name'].', '.$data2['property_name'].'</a><br>';
								}
								?>
								</div>
							</div>
							
						</div>
						
						<!-- RIGHT COLUMN -->
						<div class="col-md-9">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><?php echo renderLang($occupants_occupant_information); ?></h3>
								</div>
								<div class="card-body">

									<div class="table-responsive">
										<table class="table table-bordered">
											<tbody>
												<tr>
													<th class="w120"><?php echo renderLang($occupants_lastname); ?></th>
													<td><?php echo $data['lastname']; ?></td>
												</tr>
												<tr>
													<th><?php echo renderLang($occupants_firstname); ?></th>
													<td><?php echo $data['firstname']; ?></td>
												</tr>
												<tr>
													<th><?php echo renderLang($occupants_middlename); ?></th>
													<td><?php echo $data['middlename']; ?></td>
												</tr>
												<tr>
													<th><?php echo renderLang($occupants_gender); ?></th>
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
												<?php 
													$age = 0;
													$curr_date = time();
													$birthdate = strtotime($data['birthdate']);
													$age = $curr_date - $birthdate;
													$age = floor($age / (365*60*60*24));
													if($age > 1) {
														$age = $age.' years old';
													} else {
														$age = $age.' year old';
													}
												?>
													<th><?php echo renderLang($occupants_birthdate); ?></th>
													<td><?php echo formatDate($data['birthdate']); ?> (<?php echo $age; ?>)</td>
												</tr>
												<tr>
													<th><?php echo renderLang($occupants_civil_status); ?></th>
													<td>
													<?php 
													foreach($civil_status_arr as $value) {
														if($value[0] == $data['civil_status']) {
															echo renderLang($value[1]);
														}
													}
													?>
													</td>
												</tr>
												<tr>
													<th><?php echo renderLang($lang_citizenship_global); ?></th>
													<td><?php echo $data['nationality']; ?></td>
												</tr>
												<tr>
													<th><?php echo renderLang($occupants_relationship_to_tenant); ?></th>
													<td><?php echo (!empty($data['relationship_to_tenant']) ? renderLang($relationship_to_tenant_arr[$data['relationship_to_tenant']]) : '' ); ?></td>
												</tr>
												<tr>
													<th><?php echo renderLang($occupants_social_status); ?></th>
													<td><?php echo (!empty($data['social_status']) ? renderLang($social_status_arr[$data['social_status']]) : '' ); ?></td>
												</tr>
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
						
						
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
			$_SESSION['sys_occupants_err'] = renderLang($occupants_occupant_not_found);
			header('location: /occupants');

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