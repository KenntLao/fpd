<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('incident-reports')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'incident-reports';

	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($incident_report); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
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
							<h1><i class="fas fa-dumpster-fire mr-3"></i><?php echo renderLang($incident_report); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($incident_report_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('incident-report-add')) { ?><a href="/add-incident-report" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($incident_report_new); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

                        	<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-contract.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($service_requests_unit_no); ?></th>
											<th><?php echo renderLang($incident_report_date); ?></th>
											<th><?php echo renderLang($incident_report_time); ?></th>
											<th><?php echo renderLang($incident_report_remarks); ?></th>
											<th><?php echo renderLang($incident_report_severity_level); ?></th>
											<th><?php echo renderLang($incident_report_status); ?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										if ($_SESSION['sys_account_mode'] == 'user') {

	                                        $sql = $pdo->prepare("SELECT ir.severity_level, ir.id, ir.service, ir.incident_date, ir.incident_time, u.unit_name, u.property_id, ir.description, ir.remarks, sp.sub_property_name FROM incident_reports ir LEFT JOIN units u ON(ir.unit_id = u.id) LEFT JOIN sub_properties sp ON (u.sub_property_id = sp.id) WHERE ir.temp_del = 0 ");
	                                        $sql->execute();
	                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)){
	                                            
	                                            echo '<tr>';

	                                            	$property_name = getField('property_name','properties','id = '.$data['property_id']);

													// UNIT NO
													echo '<td>'.$data['unit_name'].' '.$data['sub_property_name'].' ['.$property_name.']</td>';

													// DATE
													echo '<td>'.formatDate($data['incident_date'], true, false, false).'</td>';

													// TIME
													echo '<td>'.$data['incident_time'].'</td>';

													// REMARKS
													echo '<td>'.(isset($data['remarks']) ? renderLang($service_request_remarks_arr[$data['remarks']]) : '').'</td>';

													// SEVERITY LEVEL
													echo '<td>'.renderLang($severity_level_arr[$data['severity_level']]).'</td>';
													
													// SERVICE
													//echo '<td>'.renderLang($service_request_service_arr[$data['service']]).' </td>';

													// PROPERTY
													//echo '<td>['.$data['unit_name'].'] '.(isset($data['property_id']) ? getField('property_name', 'properties', 'id = '.$data['property_id']) : 'No property').'</td>';
													
													// STATUS
													$status = getField('status','task_job_order','target_id ='.$data['id'].' AND target_category = 1');

													if (!isset($status)) {
	                                                    $status = getField('status','task_work_order','target_id ='.$data['id'].' AND target_category = 1');
	                                                }
													
	                                                echo '<td>'.renderLang($service_request_status_arr[$status]).'</td>';

												echo '</tr>';

	                                        }
	                                    } else {

	                                    	$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

	                                		$sub_properties = implode(',',$sub_property_ids);

	                                		$sql = $pdo->prepare("SELECT ir.severity_level, ir.id, ir.service, ir.incident_date, ir.incident_time, u.unit_name, u.property_id, ir.description, ir.remarks, sp.sub_property_name FROM incident_reports ir LEFT JOIN units u ON(ir.unit_id = u.id) LEFT JOIN sub_properties sp ON (u.sub_property_id = sp.id) WHERE ir.temp_del = 0  AND u.sub_property_id IN ($sub_properties)");
	                                        $sql->execute();
	                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)){
	                                            
	                                            echo '<tr>';

	                                            	$property_name = getField('property_name','properties','id = '.$data['property_id']);

													// UNIT NO
													echo '<td>'.$data['unit_name'].' '.$data['sub_property_name'].' ['.$property_name.']</td>';

													// DATE
													echo '<td>'.formatDate($data['incident_date'], true, false, false).'</td>';

													// TIME
													echo '<td>'.$data['incident_time'].'</td>';

													// REMARKS
													echo '<td>'.(isset($data['remarks']) ? renderLang($service_request_remarks_arr[$data['remarks']]) : '').'</td>';

													// SEVERITY LEVEL
													echo '<td>'.renderLang($severity_level_arr[$data['severity_level']]).'</td>';
													
													// SERVICE
													//echo '<td>'.renderLang($service_request_service_arr[$data['service']]).' </td>';

													// PROPERTY
													//echo '<td>['.$data['unit_name'].'] '.(isset($data['property_id']) ? getField('property_name', 'properties', 'id = '.$data['property_id']) : 'No property').'</td>';
													
													// STATUS
													$status = getField('status','task_job_order','target_id ='.$data['id'].' AND target_category = 1');

													if (!isset($status)) {
	                                                    $status = getField('status','task_work_order','target_id ='.$data['id'].' AND target_category = 1');
	                                                }
													
	                                                echo '<td>'.renderLang($service_request_status_arr[$status]).'</td>';

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
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
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