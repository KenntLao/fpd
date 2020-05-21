<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('service-requests')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'service-requests';
		
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
	<title><?php echo renderLang($service_requests); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-exclamation-circle mr-3"></i><?php echo renderLang($service_requests); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_service_requests_add_suc');
					renderSuccess('sys_service_requests_edit_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($service_requests_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('service-request-add')) { ?><a href="/add-service-request" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($service_requests_new_service_request); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

                        	<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($service_requests_date); ?></th>
											<th><?php echo renderLang($service_requests_unit_no); ?></th>
											<th><?php echo renderLang($service_requests_property); ?></th>
											<th><?php echo renderLang($service_requests_service); ?></th>
											<th><?php echo renderLang($service_requests_description); ?></th>
											<th><?php echo renderLang($service_requests_assessment); ?></th>
											<th><?php echo renderLang($service_requests_remarks); ?></th>
											<th><?php echo renderLang($service_requests_status); ?></th>
											<?php if(checkPermission('service-request-edit')) { ?>
											<th class="w35 no-sort p-0"></th>
											<?php } ?>
											
										</tr>
									</thead>
									<tbody>
                                        <?php
                                        if ($_SESSION['sys_account_mode'] == 'user') {
                                        	
	                                        $sql = $pdo->prepare("SELECT sr.id, sr.service, sr.date, u.unit_name, u.property_id, sr.description, sr.assessment, sr.remarks, sp.sub_property_name FROM service_requests sr LEFT JOIN units u ON(sr.unit_id = u.id) LEFT JOIN sub_properties sp ON (u.sub_property_id = sp.id) WHERE sr.temp_del = 0");
	                                        $sql->execute();
	                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)){
	                                            
	                                            echo '<tr>';
													
													// DATE
													echo '<td>'.formatDate($data['date'], true, false, false).'</td>';

													// COMPLAINANT
													echo '<td>'.$data['unit_name'].'</td>';

													// PROPERTY
													echo '<td>'.$data['sub_property_name'].' ['.(isset($data['property_id']) ? getField('property_name', 'properties', 'id = '.$data['property_id']) : 'No property').']</td>';

													// SERVICE
													echo '<td>'.renderLang($service_request_service_arr[$data['service']]).' </td>';

													// DESCRIPTION
													echo '<td>'.$data['description'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['assessment'].'</td>';

													// REMARKS
													echo '<td>'.(isset($data['remarks']) ? renderLang($service_request_remarks_arr[$data['remarks']]) : '').'</td>';

													// STATUS
													$status = getField('status','task_job_order','target_id ='.$data['id'].' AND target_category = 0');

													if (!isset($status)) {
														$status = getField('status','task_work_order','target_id ='.$data['id'].' AND target_category = 0');
														}
													
														echo '<td>'.(isset($status) ? renderLang($service_request_status_arr[$status]) : '' ).'</td>';

													if(checkPermission('service-request-edit')) {

													echo '<td><a href="/service-request/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($service_requests_edit_service_request).'"><i class="fa fa-pencil-alt"></i></a></td>';

													}

												echo '</tr>';

	                                        }
	                                    } else {

	                                    	$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                                            $sub_properties = "0";
                                            if(!empty($sub_property_ids)) {
                                                $sub_properties = implode(", ", $sub_property_ids);
                                            }

                                            $sql = $pdo->prepare("SELECT sr.id, sr.service, sr.date, u.unit_name, u.property_id, sr.description, sr.assessment, sr.remarks, sp.sub_property_name FROM service_requests sr LEFT JOIN units u ON(sr.unit_id = u.id) LEFT JOIN sub_properties sp ON (u.sub_property_id = sp.id) WHERE sr.temp_del = 0 AND sp.id IN ($sub_properties)");
	                                        $sql->execute();
	                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)){
	                                            
	                                            echo '<tr>';
													
													// DATE
													echo '<td>'.formatDate($data['date'], true, false, false).'</td>';

													// COMPLAINANT
													echo '<td>'.$data['unit_name'].'</td>';

													// PROPERTY
													echo '<td>'.$data['sub_property_name'].' ['.(isset($data['property_id']) ? getField('property_name', 'properties', 'id = '.$data['property_id']) : 'No property').']</td>';

													// SERVICE
													echo '<td>'.renderLang($service_request_service_arr[$data['service']]).' </td>';

													// DESCRIPTION
													echo '<td>'.$data['description'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['assessment'].'</td>';

													// REMARKS
													echo '<td>'.(isset($data['remarks']) ? renderLang($service_request_remarks_arr[$data['remarks']]) : '').'</td>';

													// STATUS
													$status = getField('status','task_job_order','target_id ='.$data['id'].' AND target_category = 0');

													if (!isset($status)) {
														$status = getField('status','task_work_order','target_id ='.$data['id'].' AND target_category = 0');
														}
													
														echo '<td>'.(isset($status) ? renderLang($service_request_status_arr[$status]) : '' ).'</td>';

													if(checkPermission('service-request-edit')) {

													echo '<td><a href="/service-request/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($service_requests_edit_service_request).'"><i class="fa fa-pencil-alt"></i></a></td>';

													}

												echo '</tr>';

	                                        }
	                                    }
										?>
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
                "order": [[ 0, "desc" ]]
            });

            // remove sorting in column
	        $('.no-sort').each(function(){
	            $(this).removeClass('sorting');
	        });

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
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