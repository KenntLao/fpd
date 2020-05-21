<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('doc-contracts')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'contracts';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($contracts); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contracts); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_doc_contracts_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($properties_sub_property_list); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table class="table table-bordered table-condensed table-hover" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($properties_sub_property); ?></th>
                                            <?php if(checkPermission('doc-contract-edit')) { ?>
                                                <th class="w35 no-sort p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										if($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT sp.id, property_name, sub_property_name FROM sub_properties sp JOIN properties p ON(sp.property_id = p.id) WHERE p.temp_del = 0 AND sp.temp_del = 0");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
												echo '<tr>';

													// building name
													echo '<td>';
														echo '<a href="#">';
															echo $data['sub_property_name'].' ['.$data['property_name'].']';
														echo '</a>';
													echo '</td>';

													// Contract List
													echo '<td>';
														echo '<a href="/doc-contract-list/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($contract_edit_contract).'"><i class="fas fa-list-ul"></i></a>';
													echo '</td>';

												echo '</tr>';
											}

										} else {

											$property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
											$properties = explode(',', $property_ids);
											foreach($properties as $property_id) {
												$sql = $pdo->prepare("SELECT sp.id, property_name, sub_property_name FROM sub_properties sp JOIN properties p ON(sp.property_id = p.id) WHERE p.temp_del = 0 AND sp.temp_del = 0 AND p.id = :id");
												$sql->bindParam(":id", $property_id);
												$sql->execute();
												if($sql->rowCount()) {
													while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

														echo '<tr>';

															// building name
															echo '<td>';
																echo '<a href="#">';
																	echo $data['sub_property_name'].' ['.$data['property_name'].']';
																echo '</a>';
															echo '</td>';

															// Contract List
															echo '<td>';
																echo '<a href="/doc-contract-list/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($contract_edit_contract).'"><i class="fas fa-list-ul"></i></a>';
															echo '</td>';

														echo '</tr>';

													}

												}
											}

										}

											
                                        ?>
                                    </tbody>
                                </table>
                            </div>

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

        // remove sorting in column
        $('.no-sort').each(function(){
            $(this).removeClass('sorting');
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