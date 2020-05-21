<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($labor_cost); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($labor_cost); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($proposals_project); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $lc_prospect_ids = array();
                                        $sql = $pdo->prepare("SELECT prospect_id FROM labor_cost WHERE temp_del = 0 GROUP BY prospect_id");
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            $lc_prospect_ids[] = $data['prospect_id'];
                                        }
                                        $lc_prospects = '0';
                                        if(!empty($lc_prospect_ids)) {
                                            $lc_prospects = implode(', ', $lc_prospect_ids);
                                        }
                                        $lco_prospect_ids = array();
                                        $sql = $pdo->prepare("SELECT prospect_id FROM labor_cost_outsource WHERE temp_del = 0 GROUP BY prospect_id");
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            $lco_prospect_ids[] = $data['prospect_id'];
                                        }
                                        $lco_prospects = '0';
                                        if(!empty($lco_prospect_ids)) {
                                            $lco_prospects = implode(', ', $lco_prospect_ids);
                                        }

                                        $sql = $pdo->prepare("SELECT id, project_name FROM prospecting WHERE id IN($lc_prospects) OR id IN($lco_prospects) AND temp_del = 0 GROUP BY id");
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                                echo '<td><a href="/preview-labor-cost/'.$data['id'].'">'.$data['project_name'].'</a></td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/labor-cost-category" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
    $(function() {
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