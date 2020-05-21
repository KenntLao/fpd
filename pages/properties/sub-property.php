<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('properties')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'properties';
		
		// get ID
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM sub_properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			$property_id = $data['property_id'];
			
			// get employees under property
			$employee_ids = array();
			$sql2 = $pdo->prepare("SELECT * FROM employees WHERE sub_property_ids LIKE '%,".$id.",%' AND status = 0 ORDER BY lastname ASC");
			$sql2->execute();
			$employee_count = $sql2->rowCount();
			
			// check employee permission
			$permission_count = 0;
			if(checkPermission('employee-edit')) { $permission_count++; }
			if(checkPermission('employee-timesheet')) { $permission_count++; }
			switch($permission_count) {
				case 1: $option_col_width = 35; break;
				case 2: $option_col_width = 60; break;
				default: $option_col_width = 35; break;
			}

			// get property data of sub property
			$_data = getData($property_id,'properties');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $data['sub_property_name'].' &middot; '.renderLang($properties_sub_property); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/properties.css">
	
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
								<i class="far fa-building mr-3"></i><?php echo renderLang($properties_property); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $_data['property_name']; ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $data['sub_property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $property_id; ?>"><?php echo $_data['property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo $data['sub_property_name']; ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					if($_data['status'] == 2 && $_data['temp_del'] != 0) {
						$_SESSION['sys_sub_properties_err'] = renderLang($properties_sub_property_deleted);
					}
					renderError('sys_sub_properties_err');
					renderError('sys_sub_properties_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<!-- PROPERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $property_id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $property_id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $property_id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- BUILDING OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card sub-property-card">
								<div class="card-body p-2">
									<a href="/sub-property/<?php echo $id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_details); ?></a>
									<a href="/sub-property-units/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-door-open mr-2"></i><?php echo renderLang($units_units_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- PROPERTY DETAILS -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($properties_sub_property_details); ?></h3>
							<div class="card-tools">
								<?php renderProfileStatus($_data['status']); ?>
							</div>
						</div>
						<div class="card-body">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th class="w170"><?php echo renderLang($properties_sub_property_name); ?></th>
										<td class="w30p"><?php echo $data['sub_property_name']; ?></td>
										<th class="w170"><?php echo renderLang($properties_property_name); ?></th>
										<td class="w30p"><?php echo $_data['property_name']; ?></td>
									</tr>
									<tr>
										<th class="w170"><?php echo renderLang($properties_property_id); ?></th>
										<td><?php echo $_data['property_id']; ?></td>
										<th class="w170"><?php echo renderLang($properties_property_code); ?></th>
										<td><?php echo $_data['property_code']; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($lang_number_of_employees); ?></th>
										<td colspan="3"><?php echo number_format($employee_count,0,'.',','); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div><!-- card -->

					<!-- SUB PROPERTY EQUIPMENTS -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($properties_sub_property_building_equipments); ?></h3>
						</div>
						<div class="card-body">

                            <div class="table-responsive">
                                
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($properties_sub_property_equipment_name); ?></th>
                                            <th><?php echo renderLang($properties_sub_property_equipment_quantity); ?></th>
                                            <th><?php echo renderLang($properties_sub_property_equipment_make_model); ?></th>
                                            <th><?php echo renderLang($properties_sub_property_equipment_date_acquired); ?></th>
                                            <th><?php echo renderLang($properties_sub_property_equipment_supplier); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = $pdo->prepare("SELECT * FROM equipments WHERE sub_property_id = :id AND temp_del = 0");
                                    $sql->bindParam(":id", $id);
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td>'.$data['equipment_name'].'</td>';
                                        echo '<td>'.$data['amount'].'</td>';
                                        echo '<td>'.$data['serial_number'].'</td>';
                                        echo '<td>'.date('F j, Y', strtotime($data['date_acquired'])).'</td>';
                                        echo '<td>'.$data['supplier'].'</td>';

                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>

                            </div>

						</div>
                    </div>
                    
                    <!-- SUB PROPERTY AMENITIES -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($properties_sub_property_building_amenities); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                    <table class="table table-bordered">
                                        <thead>
                                            <th><?php echo renderLang($properties_sub_property_amenities); ?></th>
                                            <th><?php echo renderLang($properties_sub_property_amenities_description); ?></th>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM sub_properties_amenities WHERE sub_property_id = :id AND temp_del = 0");
                                        $sql->bindParam(":id", $id);
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';

                                            echo '<td>'.$data['amenity_name'].'</td>';
                                            echo '<td>'.$data['amenity_description'].'</td>';

                                            echo '</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                            </div>
                            
                        </div>
                    </div>
					
					<?php if(checkPermission('employees')) { ?>
					
						<!-- EMPLOYEES LIST -->
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($employees_employees_list); ?></h3>
							</div>
							<div class="card-body">

								<!-- DATA TABLE -->
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover with-options">
										<thead>
											<tr>
												<th><?php echo renderLang($employees_employee_id); ?></th>
												<th><?php echo renderLang($employees_lastname); ?></th>
												<th><?php echo renderLang($employees_firstname); ?></th>
												<th><?php echo renderLang($employees_middlename); ?></th>
												<th><?php echo renderLang($roles_roles); ?></th>
												<th><?php echo renderLang($departments_department); ?></th>
												<th><?php echo renderLang($lang_status); ?></th>
												<th class="w150"><?php echo renderLang($employees_last_login); ?></th>
												<th style="width:<?php echo $option_col_width; ?>px;"></th>
											</tr>
										</thead>
										<tbody>
											<?php
											if($sql2->rowCount() == 0) {
												echo '<tr><td colspan="9">'.renderLang($lang_no_data_display).'</td></tr>';
											} else {

												while($data = $sql2->fetch(PDO::FETCH_ASSOC)) {

													array_push($employee_ids,$id);

													echo '<tr>';

														// EMPLOYEE ID
														echo '<td><a href="/employee/'.$data['id'].'">'.$data['employee_id'].'</a></td>';

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

											}
											?>
										</tbody>
									</table>
								</div><!-- table-responsive -->

							</div>
						</div><!-- card -->
					
					<?php } ?>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function() {
			
			$('.duallistbox').bootstrapDualListbox();
			
			$('.btn-confirm-employees').click(function() {
				var property_id = <?php echo $id; ?>;
				var employee_ids = $('.duallistbox').val().join(',');
				loader.load('/property-manage-employees/'+property_id+'/'+employee_ids);
				showLoading();
			});
			
			// confirm employe remove
			$('.btn-property-remove-employee').click(function() {
				var property_id = <?php echo $id; ?>;
				var employee_id = $(this).attr('data-id') * 1;
				$('#modal-confirm-remove-employee a').attr('href','/property-remove-employee/'+property_id+'/'+employee_id);
			});
			
		});
	</script>
	
</body>

</html>
<?php
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_properties_err'] = renderLang($properties_sub_property_not_found);
			header('location: /properties');

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