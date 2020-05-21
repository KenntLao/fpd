<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('general-inspection-and-function-check')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'inspections';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($inspection_general_inspection); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($inspection_general_inspection); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_general_inspection_checklist_add_suc');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($inspection_general_inspection_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('general-inspection-and-function-check-add')) { ?>
                                <a href="/add-general-inspection-sheet" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($inspection_add_inspection); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table class="table table-bordered table-condensed table-hover" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($feic_date); ?></th>
                                            <th><?php echo renderLang($properties_sub_property); ?></th>
                                            <th class="w35 no-sort p-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <?php
	                                    $sql = $pdo->prepare("SELECT tie.id, p.property_name, sp.sub_property_name, tie.inspected_date FROM task_inspection_engineering_checklist tie LEFT JOIN sub_properties sp ON (sp.id = tie.sub_property_id) LEFT JOIN properties p ON (p.id = sp.property_id) WHERE tie.temp_del = 0 AND category = 0 ORDER BY tie.inspected_date DESC");
	                                    $sql->execute();
	                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                    	
	                                    	echo '<tr>';

	                                    		echo '<td>'.$data['inspected_date'].'</td>';
	                                    		echo '<td><a href="/general-inspection-sheet/'.$data['id'].'">['.$data['property_name'].'] '.$data['sub_property_name'].'</a></td>';
	                                    		echo '<td></td>';

	                                    	echo '</tr>';
	                                    }
										?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/inspection-types/0" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
            "autoWidth": false
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