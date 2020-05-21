<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'operation-audit';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($audits_corrective_action_plan_list); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($audits_corrective_action_plan_list); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_corrective_action_plan_add_suc');
                    renderError('sys_corrective_action_plan_edit_err');
                    renderSuccess('sys_corrective_action_plan_edit_suc');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($audits_corrective_action_plan_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('operation-audit-IAD-add')) { ?>
                                    <a href="/add-corrective-action-plan" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($audits_corrective_action_plan_add); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($audits_project); ?></th>
                                            <th><?php echo renderLang($audits_iad_reference_no); ?></th>
                                            <th><?php echo renderLang($lang_attachments); ?></th>
                                            <?php if(checkPermission('operation-audit-IAD-edit')) { ?>
                                                <th class="w35 p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if($_SESSION['sys_account_mode'] == "user") {
                                            $sql = $pdo->prepare("SELECT iac.id, iac.reference_number, property_name, iac.attachments FROM iad_audit_correctives iac JOIN properties p ON(iac.property_id = p.id) WHERE iac.temp_del = 0");
                                            $sql->execute();
                                        } else {
                                            $property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];
                                            $properties = "0";
                                            if(!empty($property_ids)) {
                                                $properties = implode(", ", $property_ids);
                                            }
                                            $sql = $pdo->prepare("SELECT iac.id, iac.reference_number, property_name, iac.attachments FROM iad_audit_correctives iac JOIN properties p ON(iac.property_id = p.id) WHERE iac.property_id IN($properties) AND iac.temp_del = 0");
                                            $sql->execute();
                                        }

                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';

                                                echo '<td>';
                                                    echo '<a href="">'.$data['property_name'].'</a>';
                                                echo '</td>';

                                                echo '<td>';
                                                    echo $data['reference_number'];
                                                echo '</td>';

                                                echo '<td>';
                                                    renderAttachments($data['attachments'], 'corrective-action-plan');
                                                echo '</td>';

                                                if(checkPermission('operation-audit-IAD-edit')) {
                                                    echo '<td>';
                                                        echo '<a href="/edit-corrective-action-plan/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($audits_iad_corrective_action_plan_edit).'"><i class="fa fa-pencil-alt"></i></a>';
                                                    echo '</td>';
                                                }

                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/operations-audit-iad-categories" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                        </div>
                    </div>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
    $(function(){
        // ekko lightbox
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