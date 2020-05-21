<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notifications')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'notifications';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($notifications); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-bell mr-3"></i><?php echo renderLang($notifications); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($notifications_list); ?></h3>
                        </div>
                        <div class="card-body">

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data-notif" class="table table-hover table-bordered">
								
									<thead>
										<tr>
											<th><?php echo renderLang($notifications); ?></th>
											<th><?php echo renderLang($lang_date); ?></th>
										</tr>
									</thead>
									<tbody>
                                        <?php 
                                        $cache_file = $cache_dir.'/notifications.json';
                                        if(file_exists($cache_file)) {

                                            $fetch = file_get_contents($cache_file);
                                            $datas = json_decode($fetch, true);

                                        } else {
                                            
                                            $query = "SELECT * FROM notifications ORDER BY date DESC";
                                            updateCache('notifications.json', $query);

                                            $fetch = file_get_contents($cache_file);
                                            $datas = json_decode($fetch, true);
                                        }

						                if(checkPermission('notifications')) {
                                            foreach($datas as $data) {

                                                $notif_table = '';
                                                $notif_href= '';
                                                if($data['module'] == 'day-plan') {
                                                    $notif_href = '/edit-30-60-90-day-plan/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if($data['module'] == 'pre-operation-audit-QEHS') {
                                                    $notif_href = '/pre-operation-audit-checklist/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if($data['module'] == 'pre-operation-audit-TSA') {
                                                    $notif_href = '/edit-tsa-pre-operation-audit/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if($data['module'] == 'prospecting') {
                                                    $notif_href = '/edit-prospecting/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'notice-to-proceed') {
                                                    $notif_href = '/notice-to-proceed/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'billing-advice') {
                                                    $notif_href = '/downpayment/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'contract') {
                                                    $notif_href ='/contract/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'gate-pass-employee') {
                                                    $notif_href ='/gate-pass-employee/'.$data['module_id'];
                                                    $notif_table = '';
                                                }
                                                if ($data['module'] == 'visitor') {
                                                    $notif_href ='/visitor/'.$data['module_id'];
                                                    $notif_table = 'properties';
                                                }
                                                if ($data['module'] == 'prf') {
                                                    $notif_href ='/prf/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'pre-operation-audit-iad') {
                                                    $notif_href ='/add-iad-on-hand-collection';
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'pre-operation-audit-pad-pcc') {
                                                    $notif_href ='/pre-operation-audit-pad-list';
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'nni-status-completed' || $data['module'] == 'nni-it-status-completed' || $data['module'] == 'cad-information' || $data['module'] == 'nni' || $data['module'] == 'it-information' || $data['module'] == 'nni-status-endorsed' || $data['module'] == 'nni-cad-status-completed' || $data['module'] == 'nni-hr-status-completed' || $data['module'] == 'nni-cad-status-completed' || $data['module'] == 'nni-status-assigned' || $data['module'] == 'nni-status-for-execution') {
                                                    $notif_href ='/edit-nni/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if ($data['module'] == 'minutes-of-meeting') {
                                                    $notif_href ='/edit-minutes-of-meeting/'.$data['module_id'];
                                                    $notif_table = 'departments';
                                                }
                                                if ($data['module'] == 'property') {
                                                    $notif_href ='/property/'.$data['module_id'];
                                                    $notif_table = 'property';
                                                }
                                                if ($data['module'] == 'other-task') {
                                                    $href ='/pre-operation-other-tasks';
                                                    $notif_table = 'property';
                                                }
                                                if($data['module'] == 'prospecting-activity') {
                                                    $notif_href ='/prospect-activities/'.$data['module_id'];
                                                    $notif_table = 'prospecting';
                                                }
                                                if($data['module'] == 'other-task-activities') {
                                                    $notif_href = '/add-activities-pre-operation-other-task/'.$data['module_id']; 
                                                    $notif_table = 'other_tasks';
                                                }
                                                if($data['module'] == 'undeposited-collection') {
                                                    $notif_href = '/on-hand-collection/'.$data['module_id']; 
                                                    $notif_table = 'undeposited';
                                                }
                                                if($data['module'] == 'general-inspection-and-function-check' || $data['module'] == 'proper-installation-general-inspection-and-function-check' || $data['module'] == 'supply-voltage-and-load-current-reading' || $data['module'] == 'power-and-grounding-wirings') {

                                                    $notif_href = '/inspection-types/0'; 
                                                    $notif_table = 'engineering-checklist';
                                                }
                                                if($data['module'] == 'fcu-monthly-inspections') {
                                                    $notif_href = '/fcu-monthly-inspection-list'; 
                                                    $notif_table = 'fcu-monthly-inspections';
                                                }
                                                if($data['module'] == 'check-voucher') {
                                                    $notif_href = '/edit-check-voucher/'.$data['module_id'];
                                                    $notif_table = 'check-voucher';
                                                }
                                                if($data['module'] == 'daily-collection') {
                                                    $notif_href = '/daily-collection/'.$data['module_id']; 
                                                    $notif_table = 'daily-collection';
                                                }
                                                if($data['module'] == 'calibration-monitoring') {
                                                    $notif_href = '/edit-calibration/'.$data['module_id']; 
                                                    $notif_table = 'calibration';
                                                }
                                                if($data['module'] == 'calibration-plans') {
                                                    $notif_href = '/calibration-plan-edit/'.$data['module_id']; 
                                                    $notif_table = 'calibration';
                                                }
                                                if($data['module'] == 'proposal-introductory-letter') {
                                                    $notif_href = '/edit-bdmd-introductory-letter-proposal/'.$data['module_id']; 
                                                    $notif_table = 'proposal';
                                                }
                                                if($data['module'] == 'labor-cost-add' || $data['module'] == 'labor-cost-edit' || $data['module'] == 'labor-cost-returned' || $data['module'] == 'labor-cost-approved') {
                                                    $notif_href = '/edit-labor-cost/'.$data['module_id'];
                                                    $notif_table = 'labor-cost';
                                                }
                                                if ($data['module'] == 'pre-operations-audit-pad-checklist') {
                                                    $notif_href = '/pad-pre-operation-audit-checklist/'.$data['module_id'];
                                                    $notif_table = 'pre-operations-audit-pad-checklist';
                                                }
                                                if ($data['module'] == 'pre-operations-audit-pad-pcv') {
                                                    $notif_href = '/pad-pcv-pre-operation-audit-list';
                                                    $notif_table = 'pre-operations-audit-pad-pcv';
                                                }
                                                if ($data['module'] == 'pre-operations-audit-tsa') {
                                                    $notif_href = '/tsa-report-findings/'.$data['module_id'];
                                                    $notif_table = 'pre-operations-audit-tsa';
                                                }
                                                if ($data['module'] == 'operations-audit-tsa') {
                                                    $notif_href = '/tsa-operations-audit/'.$data['module_id'];
                                                    $notif_table = 'operations-audit-tsa';
                                                }
                                                if ($data['module'] == 'service-requests') {
                                                    $notif_href = '/service-request/'.$data['module_id'];
                                                    $notif_table = 'service-requests';
                                                }

                                                $notification_msg = '';

                                                if($data['source_account_mode'] == 'employee') {
                                                    $notif_code_name = getField('code_name', 'employees', 'id = '.$data['source_id']);
                                                    $notification_msg = !empty($notif_code_name) ? $notif_code_name : getFullName($data['source_id'], $data['source_account_mode']);
                                                } else {
                                                    $notification_msg = getFullName($data['source_id'], $data['source_account_mode']);
                                                }

                                                $notification_msg .= ' '.renderlang(${"notification_".$data['notification']});
                                                
                                                $notif_target = '';

                                                switch($notif_table)  {
                                                    case 'prospecting':
                                                        $notif_target = '['.getField("project_name", "prospecting", 'id = '.$data['module_id']).']';
                                                        break;
                                                    case 'departments':
                                                        $notif_target = '['.getField("department_name", "departments", 'id = '.$data['module_id']).']';
                                                        break;
                                                    case 'other_tasks': 
                                                        $notif_target = '['.getField("title", "other_tasks", 'id = '.$data['module_id']).']';
                                                        break;

                                                    // UNDEPOSITED
                                                    case 'undeposited':
                                                        $target_id = getField('property_id', 'on_hand_collection', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField("property_name", "properties", "id = ".$target_id).']';
                                                        }
                                                        break;

                                                    case 'engineering-checklist':
                                                        $target_id = getField('sub_property_id', 'task_inspection_engineering_checklist', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                                                        }
                                                        break;
                                                    case 'fcu-monthly-inspections':
                                                        $target_id = getField('sub_property_id', 'task_inspection_maintenance_fcu', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                                                        }
                                                        break;
                                                    case 'check-voucher':
                                                        $target_id = getField('property_id', 'check_voucher', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('property_name', 'properties', 'id = '.$target_id).']';
                                                        }
                                                        break;
                                                        
                                                    // DAILY COLLECTION
                                                    case 'daily-collection':
                                                        $target_id = getField('sub_property_id', 'daily_collections', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            
                                                            $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                                                            
                                                        }
                                                        break;

                                                    // CALIBRATION
                                                    case 'calibration':
                                                        $target_id = getField('sub_property_id', 'calibrations', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField("sub_property_name", "sub_properties", "id =".$target_id).']';
                                                        }
                                                        break;

                                                    // PROPOSAL
                                                    case 'proposal':
                                                        $target_id = getField('prospect_id', 'proposal_introductory_letters', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField("project_name", "prospecting", "id =".$target_id).']';
                                                        }
                                                        break;

                                                    // LABOR COST
                                                    case 'labor-cost':
                                                        $target_id = getField('prospect_id', 'labor_cost', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                                                        }
                                                        break;

                                                    // PRE OPERATIONS AUDIT PAD CHECKLIST
                                                    case 'pre-operations-audit-pad-checklist':
                                                        $target_id = getField('prospect_id', 'pre_ops_pad_checklist', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                                                        }
                                                        break;

                                                    // PRE OPERATIONS AUDIT PAD PCV
                                                    case 'pre-operations-audit-pad-pcv':
                                                        $target_id = getField('prospect_id', 'poa_pad_pcv', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                                                        }
                                                        break;

                                                    // PRE OPERATIONS AUDIT TSA
                                                    case 'pre-operations-audit-tsa':
                                                        $target_id = getField('prospect_id', 'pre_operation_audit_tsa', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                                                        }
                                                        break;

                                                    // OPERATIONS AUDIT TSA
                                                    case 'operations-audit-tsa':
                                                        $target_id = getField('prospect_id', 'operations_audit_tsa', 'id = '.$data['module_id']);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                                                        }
                                                        break;

                                                    // SERVICE REQUESTS
                                                    case 'service-requests':
                                                        $unit_id = getField('unit_id', 'service_requests', 'id = '.$data['module_id']);
                                                        $target_id = getField('sub_property_id', 'units', 'id = '.$unit_id);
                                                        if(checkVar($target_id)) {
                                                            $notif_target = '['.getField('project_name', 'prospecting', 'id = '.$target_id).']';
                                                        }
                                                        break;

                                                    default: 
                                                        $notif_target = '';
                                                        break;
                                                }

                                                $show = 0;
                                                if($_SESSION['sys_id'] == $data['user_id'] && $_SESSION['sys_account_mode'] == $data['account_mode']) {
                                                    $show = 1;
                                                }

                                                if($show) {

                                                    echo '<tr>';
    
                                                        // PHOTO
                                                        // MESSAGE
                                                        echo '<td>';
                                                            if($data['source_account_mode'] == 'user') {
    
                                                                $photo = '/assets/images/profile/default.png';
    
                                                            } else {
    
                                                                $photo = getField('photo', 'employees', 'id = '.$data['user_id']);
                                                            }
                                                            echo '<img class="direct-chat-img mr-3 bg-dark" src="'.(!empty($photo) ? $photo : '/dist/img/avatar2.png').'" alt="message user image">';
    
                                                            echo '<a href="'.$notif_href.'" class="text-muted">';
                                                            echo ''.$notification_msg.' '.$notif_target.$data['id'].'</a>';
    
                                                        echo '</td>';
    
                                                        // DATE
                                                        echo '<td>';
    
                                                            echo '<span class="direct-chat-timestamp float-right">'.formatDate($data['date'], true, false, true).'</span>';
    
                                                        echo '</td>';
    
                                                    echo '</tr>';

                                                }
						                        
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
            
            $('#table-data-notif').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[ 1, "desc" ]]
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