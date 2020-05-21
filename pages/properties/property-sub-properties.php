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

		$sql = $pdo->prepare("SELECT * FROM properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// get sub properties
			$sql3 = $pdo->prepare("SELECT * FROM sub_properties WHERE property_id = ".$id." AND temp_del = 0 ORDER BY sub_property_name ASC");
			$sql3->execute();
			$sub_property_count = $sql3->rowCount();
			
			// get sub properties
			$residential_unit_count = 0;
			$commercial_unit_count = 0;
			$occupied_unit_owners = 0;
			$occupied_tenants = 0;
			$sql4 = $pdo->prepare("SELECT * FROM units WHERE property_id = ".$id);
			$sql4->execute();
			while($data4 = $sql4->fetch(PDO::FETCH_ASSOC)) {
				if($data4['unit_type'] == 0) {
					$residential_unit_count++;
				} else {
					$commercial_unit_count++;
				}
			}
			
			// get data
			$properties_arr = getTable('properties');
			$sub_properties_arr = getTable('sub_properties');
			
			// check employee permission
			$permission_count = 0;
			if(checkPermission('employee-edit')) { $permission_count++; }
			if(checkPermission('employee-timesheet')) { $permission_count++; }
			switch($permission_count) {
				case 1: $option_col_width = 35; break;
				case 2: $option_col_width = 60; break;
				default: $option_col_width = 35; break;
			}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $data['property_name'].' &middot; '.renderLang($properties_property); ?> &middot; <?php echo $sitename; ?></title>

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
								<?php echo $data['property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item active"><?php echo $data['property_name']; ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					if($data['status'] == 2 && $data['temp_del'] != 0) {
						$_SESSION['sys_properties_err'] = renderLang($properties_property_deleted);
					}
					renderError('sys_sub_properties_err');
					renderError('sys_sub_properties_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					renderSuccess('sys_sub_properties_add_suc');
					?>
					
					<!-- PROOERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
                                    <a href="/property-summary/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-list mr-2"></i><?php echo renderLang($properties_property_summary); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<?php if(checkPermission('sub-properties')) { ?>
					
					<!-- BUILDINGS LIST -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></h3>
							<?php if(checkPermission('sub-property-add')) { ?>
							<div class="card-tools">
								<?php if(checkPermission('properties')) { ?><a href="/add-sub-property/<?php echo $id; ?>" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($properties_add_sub_property); ?></a><?php } ?>
							</div>
							<?php } ?>
						</div>
						<div class="card-body">

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover with-options">
									<thead>
										<tr>
											<th><?php echo renderLang($properties_sub_property_name); ?></th>
											<th class="text-center"><?php echo renderLang($units_units); ?></th>
											<?php if(checkPermission('sub-property-edit')) { ?>
											<th style="width:35px;"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
										if($sql3->rowCount() == 0) {
											echo '<tr><td colspan="8">'.renderLang($lang_no_data_display).'</td></tr>';
										} else {

											while($data3 = $sql3->fetch(PDO::FETCH_ASSOC)) {

												echo '<tr>';

													// BUILDING NAME
													echo '<td><a href="/sub-property/'.$data3['id'].'">'.$data3['sub_property_name'].'</a></td>';
												
													// UNITS
													echo '<td class="text-center">';
														$sub_property_id = $data3['id'];
														$sql4 = $pdo->prepare("SELECT sub_property_id FROM units WHERE sub_property_id = ".$sub_property_id);
														$sql4->execute();
														echo '<a href="/sub-property-units/'.$sub_property_id.'">'.$sql4->rowCount().'</a>';
													echo '</td>';

													if(checkPermission('sub-property-edit')) {
														// OPTIONS
														echo '<td><a href="/edit-sub-property/'.$data3['id'].'" class="btn btn-success btn-xs" title="'.renderLang($properties_edit_sub_property).'"><i class="fa fa-pencil-alt"></i></a></td>'; // end options
													}
												
												echo '</tr>';
											}

										}
										?>
									</tbody>
								</table>
							</div><!-- table-responsive -->

						</div>
					</div>
					
					<?php } ?>
					
					
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->
	
	<!-- ADD EMPLOYEE -->
	<div class="modal fade" id="modal-manage-employee">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Manage Employees</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<div class="row">
									<div class="col-md-6"><label class="pl-1">Unassigned</label></div>
									<div class="col-md-6"><label class="pl-1">Assigned</label></div>
								</div>
								<select class="duallistbox" multiple="multiple">
									<?php
									// get employees
									$sql2 = $pdo->prepare("SELECT * FROM employees WHERE status = 0 ORDER BY lastname ASC");
									$sql2->execute();
									while($data = $sql2->fetch(PDO::FETCH_ASSOC)) {
										echo '<option value="'.$data['id'].'"';
										if(in_array($data['id'],$employee_ids)) {
											echo ' selected';
										}
										echo '>';
											switch($_SESSION['sys_language']) {
												case 0:
													$fullname = $data['firstname'].' '.$data['lastname'];
													break;
												case 1:
													$fullname = $data['lastname'].' '.$data['firstname'];
													break;
											}
											$employee_name = '['.$data['employee_id'].'] '.$fullname;
											echo $employee_name;
										echo '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Cancel</button>
					<a href="#" class="btn btn-primary btn-confirm-employees"><i class="fa fa-check mr-2"></i>Confirm</a>
				</div>
			</div>
		</div>
	</div>
	
	<!-- CONFIRM REMOVE EMPLOYEE -->
	<div class="modal fade" id="modal-confirm-remove-employee">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h4 class="modal-title">Confirm Remove Employee</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to remove this employee from this property?</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Cancel</button>
					<a href="#" class="btn btn-danger"><i class="fa fa-check mr-2"></i>Confirm Remove Employee</a>
				</div>
			</div>
		</div>
	</div>

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
			$_SESSION['sys_properties_err'] = renderLang($properties_property_not_found);
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