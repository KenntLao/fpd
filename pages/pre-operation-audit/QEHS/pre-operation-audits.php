<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-QEHS')) {

    $page = 'pre-operation-audit';
    
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
	<title><?php echo renderLang($pre_operation_audits); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audits); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pre_operation_audit_edit_suc');
                    renderError('sys_pre_operation_audit_QEHS_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($pre_operation_audit_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('pre-operation-audit-QEHS-add')) { ?><a href="/add-pre-operation-audit" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($pre_operation_audit_add); ?></a><?php } ?>
                                </div>
                            </div>
                        <div class="card-body">
                            
                            
                            <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                       <tr>
                                            <th><?php echo renderLang($pre_operation_audit_project); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_auditee); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_date_of_audit); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_auditors); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_department); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <?php if(checkPermission('pre-operation-audit-QEHS-edit')) { ?>
                                            <th class="w35"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $sql = $pdo->prepare("SELECT reference_number, poa.id, project_name, auditee, date_of_audit, auditors, department, poa.status FROM pre_operation_audit poa LEFT JOIN prospecting p ON(poa.prospect_id = p.id) WHERE poa.temp_del = 0");
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td><a href="/pre-operation-audit-checklist/'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';
                                        echo '<td>'.$data['auditee'].'</td>';
                                        echo '<td>'.date('Y-m-d', strtotime($data['date_of_audit'])).'</td>';
                                        
                                        // auditors
                                        echo '<td>';
                                        $employee_ids = explode(',', $data['auditors']);
                                        foreach($employee_ids as $employee_id) {

                                            $sql1 = $pdo->prepare("SELECT employee_id, firstname, lastname, id FROM employees WHERE id = :id AND temp_del = 0 LIMIT 1");
                                            $sql1->bindParam(":id", $employee_id);
                                            $sql1->execute();
                                            $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                            if($sql1->rowCount()) {
                                                echo '<a href="/employee/'.$data1['id'].'">['.$data1['employee_id'].'] '.$data1['firstname'].' '.$data1['lastname'].'</a> <br>';
                                            } else {
                                                echo 'N/A';
                                            }


                                        }
                                        echo '</td>';

                                        echo '<td>'.$data['department'].'</td>';

                                        echo '<td><span class="badge badge-'.$audit_status_color_arr[$data['status']].'">'.renderLang($audit_status_arr[$data['status']]).'</span></td>';

                                        // EDIT
                                        if(checkPermission('pre-operation-audit-QEHS-edit')) {
                                        echo '<td><a href="/edit-pre-operation-audit-checklist/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($notice_to_proceed_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';

                                        echo '</tr>';
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/pre-operation-audit-departments" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                        </div>
                    </div>

                </div>

			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function(){

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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