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
	<title><?php echo renderLang($labor_cost_outsource); ?> &middot; <?php echo $sitename; ?></title>
	
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
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($labor_cost_outsource); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_labor_cost_outsource_add_suc');
                    renderError('sys_labor_cost_outsource_edit_err');
                    renderSuccess('sys_labor_cost_outsource_edit_suc');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($labor_cost_outsource_list); ?></h3>
                            <div class="card-tools">
                            <?php if(checkPermission('proposal-bdd-labor-cost-add')) { ?>
                                <a href="/add-outsource-labor-cost" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($labor_cost_add); ?></a>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table class="table table-bordered table-hover table-condensed" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($proposals_project); ?></th>
                                            <th><?php echo renderLang($labor_cost_total_monthly_labor_cost); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <?php if(checkPermission('proposal-bdd-labor-cost-edit')) { ?>
                                                <th class="w35 no-sort p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT lco.*, p.project_name FROM labor_cost_outsource lco JOIN prospecting p ON(lco.prospect_id = p.id) WHERE lco.temp_del = 0 AND labor_cost_category = 'BDD' AND lco.parent_version = 0");
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                            $total_monthly_lc = checkVar($data['round_up_total']) ? $data['round_up_total'] : $data['total_montly_labor_cost'];
                                            $id = $data['id'];
                                            $status = $data['status'];
                                            $latest_version = $data['version'];

                                            $sql1 = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE parent_version = :id AND temp_del = 0 AND prospect_id = :prospect_id ORDER BY version DESC");
                                            $sql1->bindParam(":id", $data['id']);
                                            $sql1->bindParam(":prospect_id", $data['prospect_id']);
                                            $sql1->execute();
                                            if($sql1->rowCount()) {
                                                $_data = $sql1->fetch(PDO::FETCH_ASSOC);
                                                $total_monthly_lc = checkVar($_data['round_up_total']) ? $_data['round_up_total'] : $_data['total_montly_labor_cost'];
                                                $id = $_data['id'];
                                                $status = $_data['status'];
                                                $latest_version = $_data['version'];
                                            }

                                            $version = $status != 3 ? 'v'.$latest_version : renderLang($labor_cost_final);

                                            echo '<tr>';
                                                echo '<td>';
                                                    echo '<a href="/outsource-labor-cost/'.$data['id'].'">'.$data['project_name'].' '.$version.'</a>';
                                                echo '</td>';
                                                echo '<td>';
                                                    echo $total_monthly_lc;
                                                echo '</td>';
                                                echo '<td>';
                                                    echo '<span class="badge badge-'.$labor_cost_status_color_arr[$status].'">'.renderLang($labor_cost_status_arr[$status]).'</span>';
                                                echo '</td>';
                                                
                                                if(checkPermission('proposal-bdd-labor-cost-edit')) {
                                                    echo '<td>';
                                                        echo '<a href="/edit-outsource-labor-cost/'.$id.'" class="btn btn-success btn-xs" title="'.renderLang($labor_cost_edit).'"><i class="fa fa-pencil-alt"></i></a>';
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