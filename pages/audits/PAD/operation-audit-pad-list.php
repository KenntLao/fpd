<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-PAD')) {

    $page = 'operation-audit';
    
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
	<title><?php echo renderLang($operation_audit); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($operation_audit_pad); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pre_operation_audit_pad_suc');
                    renderError('sys_pre_operation_audit_pad_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($operation_audit_pad_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('pre-operation-audit-PAD-add')) { ?><a href="/operation-audit-pad-categories" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($operation_audit_add); ?></a><?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($pre_operation_audit_project); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_categories); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <?php if(checkPermission('pre-operation-audit-PAD-edit')) { ?>
                                            <th class="w35"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // CHECKLIST
                                    $sql = $pdo->prepare("SELECT reference_number, project_name, ppc.id FROM poa_pad_checklist ppc LEFT JOIN prospecting p ON(ppc.prospect_id = p.id) WHERE ppc.temp_del = 0");
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td><a href="">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';
                                        echo '<td>'.strtoupper(renderLang($pre_operation_audit_pad_checklist)).'</td>';
                                        echo '<td></td>';
                                        echo '<td><a href="/edit-pad-operation-audit/'.$data['id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></a></td>';

                                        echo '</tr>';
                                    }

                                    // PCC
                                    $sql = $pdo->prepare("SELECT reference_number, project_name, pcc.id, pcc.category FROM poa_pad_pcc pcc LEFT JOIN prospecting p ON(pcc.prospect_id = p.id) WHERE pcc.temp_del = 0 AND pcc.category = 'operations'");
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td><a href="">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';
                                        echo '<td>'.strtoupper(renderLang($pre_operation_audit_pad_pcc)).'</td>';
                                        echo '<td></td>';
                                        echo '<td><a href="/edit-pad-pcc-operation-audit/'.$data['id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></a></td>';

                                        echo '</tr>';
                                    }

                                    // PCV
                                    $sql = $pdo->prepare("SELECT reference_number, project_name, pcv.id, pcv.category FROM poa_pad_pcv pcv LEFT JOIN prospecting p ON(pcv.prospect_id = p.id) WHERE pcv.temp_del = 0 AND pcv.category = 'operations'");
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td><a href="">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';
                                        echo '<td>'.strtoupper(renderLang($pre_operation_audit_pad_pcv)).'</td>';
                                        echo '<td></td>';
                                        echo '<td><a href="/edit-pad-pcv-operation-audit/'.$data['id'].'" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i></a></td>';

                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/audits" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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