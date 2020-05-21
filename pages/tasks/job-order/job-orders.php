<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('job-orders')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'job-order';
		
		// // set fields from table to search on
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
	<title><?php echo renderLang($job_orders_job_order); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-sticky-note mr-3"></i><?php echo renderLang($job_orders_job_order); ?></h1>
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
                            <h3 class="card-title"><?php echo renderLang($job_orders_job_order_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('job-order-add')) { ?><a href="/add-job-order" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($job_orders_add_job_order_form); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

							<?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($service_requests_unit_no); ?></th>
											<th><?php echo renderLang($tasks_date); ?></th>
											<th><?php echo renderLang($tasks_task); ?></th>
											<th><?php echo renderLang($tasks_assignment); ?></th>
											<th><?php echo renderLang($tasks_status); ?></th>
											<th><?php echo renderLang($tasks_priority); ?></th>
											<th><?php echo renderLang($tasks_activity); ?></th>
											<th><?php echo renderLang($tasks_remarks); ?></th>
											<?php if(checkPermission('job-order-edit')) { ?>
											<th class="w35"></th>
											<?php } ?>
											
										</tr>
									</thead>
									<tbody>
                                    <?php 
                                    if ($_SESSION['sys_account_mode'] == 'user') {
                                    	
	                                    $sql = $pdo->prepare("SELECT tj.id, tj.job_order_nature_specify, tj.job_order_nature, tj.job_order_date, tj.assigned, tj.status, tj.priority, tj.target_id, tj.target_category, tj.unit_id, u.property_id, u.unit_name, sp.sub_property_name FROM task_job_order tj LEFT JOIN units u ON (tj.unit_id = u.id) LEFT JOIN sub_properties sp ON (u.sub_property_id = sp.id) WHERE tj.temp_del = 0");
	                                    $sql->execute();
	                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

	                                        echo '<tr>';

	                                        $property_name = getField('property_name','properties','id = '.$data['property_id']);
	                                        
	                                        // unit
	                                        echo '<td><a href="/job-order/'.$data['id'].'">'.(checkVar($data['unit_name']) ? $data['unit_name'] : '').' '.(checkVar($data['sub_property_name']) ? $data['sub_property_name'] : '').', '.(checkVar($property_name) ? $property_name : '').'</a></td>';

	                                        // date
	                                        echo '<td>'.formatDate($data['job_order_date'], true, false, false).'</td>';
	                                        // task
	                                        $task = '';
	                                        if($data['job_order_nature'] == 3) {
	                                            $task = $data['job_order_nature_specify'];
	                                        } else {
	                                            $task = renderLang($nature_of_job_arr[$data['job_order_nature']]);
	                                        }
	                                        echo '<td>'.$task.'</td>';

	                                        // assigned
	                                        echo '<td>'.$data['assigned'].'</td>';
	                                        // STATUS
											echo '<td>'.renderLang($service_request_status_arr[$data['status']]).'</td>';
	                                        // priority
	                                        echo '<td><span class="badge badge-'.(!empty($data['priority']) ? renderLang($severity_level_color_arr[$data['priority']]) : '').'">'.(!empty($data['priority']) ? renderLang($severity_level_arr[$data['priority']]) : '').'</span></td>';
	                                        // activity
	                                        echo '<td></td>';
	                                        // remarks
	                                        echo '<td></td>';

	                                        if(checkPermission('job-order-edit')) {

	                                        echo '<td><a href="/assign-job-order/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($job_orders_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
	                                        }

	                                        echo '</tr>';
	                                    }

	                                } else {

	                                	$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

	                                	$sub_properties = implode(',',$sub_property_ids);

	                                	$sql = $pdo->prepare("SELECT tj.id, tj.job_order_nature_specify, tj.job_order_nature, tj.job_order_date, tj.assigned, tj.status, tj.priority, tj.target_id, tj.target_category, tj.unit_id, u.property_id, u.unit_name, sp.sub_property_name FROM task_job_order tj LEFT JOIN units u ON (tj.unit_id = u.id) LEFT JOIN sub_properties sp ON (u.sub_property_id = sp.id) WHERE tj.temp_del = 0 AND u.sub_property_id IN ($sub_properties)");
	                                    $sql->execute();
	                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                        echo '<tr>';

	                                        $property_name = getField('property_name','properties','id = '.$data['property_id']);
	                                        
	                                        // unit
	                                        echo '<td><a href="/job-order/'.$data['id'].'">'.(checkVar($data['unit_name']) ? $data['unit_name'] : '').' '.(checkVar($data['sub_property_name']) ? $data['sub_property_name'] : '').', '.(checkVar($property_name) ? $property_name : '').'</a></td>';
	                                        // date
	                                        echo '<td>'.formatDate($data['job_order_date'], true, false, false).'</td>';
	                                        // task
	                                        $task = '';
	                                        if($data['job_order_nature'] == 3) {
	                                            $task = $data['job_order_nature_specify'];
	                                        } else {
	                                            $task = renderLang($nature_of_job_arr[$data['job_order_nature']]);
	                                        }
	                                        echo '<td>'.$task.'</td>';

	                                        // assigned
	                                        echo '<td>'.$data['assigned'].'</td>';
	                                        // STATUS
											echo '<td>'.renderLang($service_request_status_arr[$data['status']]).'</td>';
	                                        // priority
	                                        echo '<td><span class="badge badge-'.(!empty($data['priority']) ? renderLang($severity_level_color_arr[$data['priority']]) : '').'">'.(!empty($data['priority']) ? renderLang($severity_level_arr[$data['priority']]) : '').'</span></td>';
	                                        // activity
	                                        echo '<td></td>';
	                                        // remarks
	                                        echo '<td></td>';

	                                        if(checkPermission('job-order-edit')) {

	                                        echo '<td><a href="/assign-job-order/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($job_orders_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
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