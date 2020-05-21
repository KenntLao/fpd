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
			
			// get employees under property
			$employee_ids = array();
			$sql2 = $pdo->prepare("SELECT * FROM employees WHERE property_ids LIKE '%,".$id.",%' AND status = 0 ORDER BY lastname ASC");
			$sql2->execute();
			$employee_count = $sql2->rowCount();
			
			// get sub properties
			$sql3 = $pdo->prepare("SELECT * FROM sub_properties WHERE property_id = ".$id." ORDER BY sub_property_name ASC");
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
					?>
					
					<!-- PROOERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
                                    <a href="/property-summary/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-list mr-2"></i><?php echo renderLang($properties_property_summary); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- PROPERTY DETAILS -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></h3>
							<div class="card-tools">
								<?php renderProfileStatus($data['status']); ?>
								<?php if(checkPermission('property-edit')) { ?><a href="/edit-property/<?php echo $id; ?>" class="btn btn-primary btn-md ml-1"><i class="fa fa-pencil-alt mr-2"></i><?php echo renderLang($properties_edit_property); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th class="w170"><?php echo renderLang($properties_property_id); ?></th>
										<td class="w30p"><?php echo $data['property_id']; ?></td>
										<th class="w170"><?php echo renderLang($properties_property_code); ?></th>
										<td class="w30p"><?php echo $data['property_code']; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($properties_property_name); ?></th>
										<td colspan="3"><?php echo $data['property_name']; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($lang_number_of_employees); ?></th>
										<td><?php echo number_format($employee_count,0,'.',','); ?></td>
										<th><?php echo renderLang($properties_number_of_sub_properties); ?></th>
										<td><?php echo number_format($sub_property_count,0,'.',','); ?></td>
									</tr>
								</tbody>
							</table>
							
							<table class="table table-bordered mt-4">
								<tbody>
									<tr>
										<th class="w170"><?php echo renderLang($clients_client); ?></th>
										<td colspan="3">
											<?php
											$_data = getData($data['client_id'],'clients');
											echo $_data['client_name'];
											?>
										</td>
									</tr>
									<tr>
										<th class="w170"><?php echo renderLang($clients_contact_person); ?></th>
										<td class="w30p"><?php echo $_data['contact_person']; ?></td>
										<th class="w170"><?php echo renderLang($clients_contact_details); ?></th>
										<td class="w30p"><?php echo $_data['contact_details']; ?></td>
									</tr>
								</tbody>
							</table>
							
							<table class="table table-bordered mt-4">
								<tbody>
									<tr>
										<th class="w170">Residential</th>
										<td class="w30p" colspan="3"><?php echo number_format($residential_unit_count,0,'.',','); ?></td>
									</tr>
									<tr>
										<th class="w170">Occupied (Unit Owners)</th>
										<td class="w30p"><?php echo number_format($occupied_unit_owners,0,'.',','); ?></td>
										<th class="w170">Occupied (Tenants)</th>
										<td class="w30p"><?php echo number_format($occupied_tenants,0,'.',','); ?></td>
									</tr>
								</tbody>
							</table>
							
							<table class="table table-bordered mt-4">
								<tbody>
									<tr>
										<th class="w170">Commercial</th>
										<td class="w30p" colspan="3"><?php echo number_format($commercial_unit_count,0,'.',','); ?></td>
									</tr>
									<tr>
										<th class="w170"></th>
										<td class="w30p"></td>
										<th class="w170"></th>
										<td class="w30p"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div><!-- card -->
					
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