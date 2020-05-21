<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('gate-pass-employees')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'gate-pass-employees';
		
		// set fields from table to search on
		// $fields_arr = array('client_id','client_name','contact_person');
		// $search_placeholder = renderLang($clients_client_id).', '.renderLang($clients_client_name).', '.renderLang($clients_contact_person);
		// require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		// $sql_query = 'SELECT * FROM clients'.$where; // set sql statement
		// require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($gate_pass_employees); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($gate_pass_employees); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_gate_pass_employees_suc');
					renderSuccess('sys_gate_pass_employees_add_suc');
					renderSuccess('sys_gate_pass_employees_edit_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($gate_pass_employees_list); ?></h3>
                            <div class="card-tools">
                            	<a href="/print-pass-control-employees" class="btn btn-primary" target="_blank"><i class="fa fa-print mr-1"></i><?php echo renderLang($lang_print); ?></a>
                                <a href="/export-pass-control-employees" class="btn btn-warning"><i class="fa fa-file-excel mr-1"></i><?php echo renderLang($lang_export); ?></a>
								<?php if(checkPermission('gate-pass-employee-add')) { ?><a href="/add-gate-pass-employee" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($gate_pass_employees_new_employee); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">
                        	<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($gate_pass_employees_project_name); ?></th>
											<th><?php echo renderLang($gate_pass_employees_date_employee); ?></th>
											<th><?php echo renderLang($gate_pass_employees_employee_name); ?></th>
											<th><?php echo renderLang($gate_pass_employees_purpose); ?></th>
											<th><?php echo renderLang($gate_pass_employees_person_department); ?></th>
											<th><?php echo renderLang($gate_pass_employees_time_in); ?></th>
											<th><?php echo renderLang($gate_pass_employees_time_out); ?></th>
											<?php if(checkPermission('gate-pass-employee-edit')) { ?>
											<th class="w35 no-sort p-0"></th>
											<?php } ?>
											
										</tr>
									</thead>
									<tbody>
										<?php
											if ($_SESSION['sys_account_mode'] == 'user') {
												
												$sql = $pdo->prepare("SELECT g.id, g.date, g.employee_name, g.purpose, g.time_in, g.time_out, g.person_department, g.prospect_id, g.property_id, p.property_name FROM gate_pass_employees g LEFT JOIN properties p ON (g.property_id = p.id) WHERE g.temp_del = 0 ORDER BY g.date ASC ");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

													$id = $data['id'];

													echo '<tr>';

														// Project
														if (empty($data['property_id'])) {

															$project_code = getField('reference_number','prospecting','id ='.$data['prospect_id']);
															$project_name = getField('project_name','prospecting','id ='.$data['prospect_id']);
															
															echo '<td><a href="/gate-pass-employee/'.$id.'">'.(!empty($data['prospect_id']) ? $project_name.' ['.$project_code.']' : '').'</a></td>';

														} else {

															$property_code = getField('property_id','properties','id ='.$data['property_id']);
															
															echo '<td><a href="/gate-pass-employee/'.$id.'">'.(!empty($data['property_id']) ? $data['property_name'].' ['.$property_code.']' : '').'</a></td>';

														}

														// date
														echo '<td>'.formatDate($data['date']).'</td>';

														// employee_name
														echo '<td>'.$data['employee_name'].'</td>';

														// purpose
														echo '<td>'.$data['purpose'].'</td>';

														// department/person
														echo '<td>'.$data['person_department'].'</td>';

														// time_in
														echo '<td>'.$data['time_in'].'</td>';

														// time_out
														echo '<td>'.$data['time_out'].'</td>';

														if(checkPermission('gate-pass-employee-edit')) {

														echo '<td><a href="/edit-gate-pass-employee/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($gate_pass_employees_edit_employee).'"><i class="fa fa-pencil-alt"></i></a></td>';
														}

													echo '</tr>';
												}
											} else {

												$property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];

												$properties = implode(',',$property_ids);
												
												$sql = $pdo->prepare("SELECT g.id, g.date, g.employee_name, g.purpose, g.time_in, g.time_out, g.person_department, g.prospect_id, g.property_id, p.property_name FROM gate_pass_employees g LEFT JOIN properties p ON (g.property_id = p.id) WHERE g.temp_del = 0 AND g.property_id IN ($properties) ORDER BY g.date ASC ");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

													$id = $data['id'];

													echo '<tr>';

														// Project
														if (empty($data['property_id'])) {

															$project_code = getField('reference_number','prospecting','id ='.$data['prospect_id']);
															$project_name = getField('project_name','prospecting','id ='.$data['prospect_id']);
															
															echo '<td><a href="/gate-pass-employee/'.$id.'">'.(!empty($data['prospect_id']) ? $project_name.' ['.$project_code.']' : '').'</a></td>';

														} else {

															$property_code = getField('property_id','properties','id ='.$data['property_id']);
															
															echo '<td><a href="/gate-pass-employee/'.$id.'">'.(!empty($data['property_id']) ? $data['property_name'].' ['.$property_code.']' : '').'</a></td>';

														}

														// date
														echo '<td>'.formatDate($data['date']).'</td>';

														// employee_name
														echo '<td>'.$data['employee_name'].'</td>';

														// purpose
														echo '<td>'.$data['purpose'].'</td>';

														// department/person
														echo '<td>'.$data['person_department'].'</td>';

														// time_in
														echo '<td>'.$data['time_in'].'</td>';

														// time_out
														echo '<td>'.$data['time_out'].'</td>';

														if(checkPermission('gate-pass-employee-edit')) {

														echo '<td><a href="/edit-gate-pass-employee/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($gate_pass_employees_edit_employee).'"><i class="fa fa-pencil-alt"></i></a></td>';
														}

													echo '</tr>';
												}
											}
										?>
									</tbody>
							
								</table>
							</div><!-- table-responsive -->
						</div><!-- card body -->
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
        $(function(){
            
            $('#table-data').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[ 1, "desc" ]]
            });

            // remove sorting in column
	        $('.no-sort').each(function(){
	            $(this).removeClass('sorting');
	        });
        });
    </script>
	
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