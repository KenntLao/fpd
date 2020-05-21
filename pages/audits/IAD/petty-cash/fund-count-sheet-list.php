<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-add')) {
	
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
	<title><?php echo renderLang($petty_cash_revolving_fund_list); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($petty_cash_revolving_fund_list); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_fund_count_sheet_add_suc');
                    renderError('sys_fund_count_sheet_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($petty_cash_revolving_fund_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('operation-audit-IAD-add')) { ?>
                                    <a href="/add-fund-count-sheet" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($petty_cash_fund_count_sheet_add); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($audits_project); ?></th>
                                            <th><?php echo renderLang($pre_operation_audit_pcc_counted_by); ?></th>
                                            <th><?php echo renderLang($audits_status); ?></th>
                                            <?php if(checkPermission('operation-audit-IAD-edit')) { ?>
                                                <th class="w35 p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $tbl_fields = "fcs.id, property_name, counted_by, account_mode, fcs.status";
                                        if($_SESSION['sys_account_mode'] == "user") {
                                            $sql = $pdo->prepare("SELECT $tbl_fields FROM fund_count_sheet fcs JOIN properties p ON(fcs.property_id = p.id) WHERE fcs.temp_del = 0 AND p.temp_del = 0");
                                            $sql->execute();
                                        } else {
                                            $property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];
                                            $properties = "0";
                                            if(!empty($property_ids)) {
                                                $properties = implode(", ", $property_ids);
                                            }
                                            $sql = $pdo->prepare("SELECT $tbl_fields FROM fund_count_sheet fcs JOIN properties p ON(fcs.property_id = p.id) WHERE fcs.temp_del = 0 AND p.temp_del = 0 AND fcs.property_id IN($properties)");
                                            $sql->execute();
                                        }
                                        
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';

                                                echo '<td>';
                                                    echo '<a href="/fund-count-sheet/'.$data['id'].'">'.$data['property_name'].'</a>';
                                                echo '</td>';

                                                echo '<td>';
                                                    echo getFullName($data['counted_by'], $data['account_mode']);
                                                echo '</td>';

                                                echo '<td>';
                                                    echo '<span class="badge badge-'.$iad_audit_petty_cash_status_color[$data['status']].'">'.renderLang($iad_audit_petty_cash_status[$data['status']]).'</span>';
                                                echo '</td>';

                                                if(checkPermission('operation-audit-IAD-edit')) {
                                                    echo '<td>';
                                                        echo '<a href="/edit-fund-count-sheet/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($petty_cash_fund_count_sheet_edit).'"><i class="fa fa-pencil-alt"></i></a>';
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