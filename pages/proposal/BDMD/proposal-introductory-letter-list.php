<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd')) {
	
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
	<title><?php echo renderLang($proposals_bdd); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($proposals_bdd); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php 
					renderError('sys_proposal_labor_cost_edit_err');
					renderSuccess('sys_proposal_labor_cost_add_suc');
					?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($proposals_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('proposal-bdd-add')) { ?>
                                    <a href="/add-bdmd-introductory-letter-proposal" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($add_proposal_bdd); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table id="table-data" class="table table-bordered">
                                    <thead>
										<th><?php echo renderLang($proposal_letter_prospect_name); ?></th>
										<th><?php echo renderLang($proposal_letter_services); ?></th>
										<th><?php echo renderLang($proposal_letter_sender); ?></th>
										<th><?php echo renderLang($proposal_letter_category); ?></th>
                                        <?php if(checkPermission('proposal-bdd-edit')) { ?>
                                            <th class="w35 no-sort p-0"></th>
                                        <?php } ?>
                                        <th class="w35 no-sort p-0"></th>
                                    </thead>
                                    <tbody>
									<?php 
									$sql = $pdo->prepare("SELECT pil.*, p.project_name as pName, p.reference_number as refNum FROM proposal_introductory_letters pil INNER JOIN prospecting p ON pil.prospect_id = p.id WHERE pil.temp_del = 0 AND proposal_category = 'BDD' ");
									$sql->execute();
									while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

										echo '<tr>';
											echo '<td>['.$data['refNum']."] ".$data['pName'].'</td>';
											echo '<td>'.$data['services'].'</td>';
											echo '<td>'.$data['sender'].'</td>';
											echo '<td>'.$data['proposal_category'].'</td>';

											if(checkPermission('proposal-bdd-edit')) {
												echo '<td>';
													echo '<a href="/edit-bdmd-introductory-letter-proposal/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($labor_cost_edit).'"><i class="fa fa-pencil-alt"></i></a>';
												echo '</td>';
											}

                                        echo '<td><a target="_blank" href="/print-bdmd-introductory-letter-proposal/'.$data['id'].'" class="btn btn-primary btn-xs" title="'.renderLang($labor_cost_edit).'"><i class="fa fa-print"></i></a></td>';

										echo '</tr>';
										
									}
									?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/bdmd-proposal-types" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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