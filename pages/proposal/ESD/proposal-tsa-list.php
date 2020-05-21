<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-esd')) {
	
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
	<title><?php echo renderLang($generic_proposal_esd); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($esd_technical_and_safety_audit); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_generic_proposal_esd_add_suc');
                    renderError('sys_esd_generic_proposal_edit_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($proposals_esd_list); ?></h3>
                            <div class="card-tools">
                            <?php if(checkPermission('proposal-esd-add')) { ?>
                                <a href="/esd-tsa-proposal-add" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($generic_proposal_esd_add); ?></a>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table id="table-data" class="table table-bordered">
                                    <thead>
                                        <th><?php echo renderLang($proposals_generic_esd_reference_number); ?></th>
                                        <th><?php echo renderlang($lang_date); ?></th>
                                        <th><?php echo renderLang($proposals_generic_esd_subject); ?></th>
                                        <th><?php echo renderLang($proposals_generic_esd_client); ?></th>
                                        <th class="w55 text-center"><?php echo renderLang($lang_status); ?></th>
                                        <?php if(checkPermission('proposal-esd-edit')) { ?>
                                            <th class="w35 no-sort p-0"></th>
                                        <?php } ?>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM proposal_esd_tsa WHERE temp_del = 0 ORDER BY id DESC");
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                                echo '<td>';
                                                    echo '<a href="/esd-tsa-edit/'.$data['id'].'">'.$data['reference_number'].'</a>';
                                                echo '</td>';
                                                echo '<td>';
                                                    echo formatDate($data['date']);
                                                echo '</td>';
                                                echo '<td>';
                                                    echo $data['letter_subject'];
                                                echo '</td>';
                                                echo '<td>';
                                                    echo $data['clientName'];
                                                echo '</td>';
                                                echo '<td class="text-center">';
                                                    echo '<span class="badge badge-'.$proposal_esd_status_color_arr[$data['status']].'">'.renderLang($proposal_esd_status_arr[$data['status']]).'</span>';
                                                echo '</td>';
                                                if(checkPermission('proposal-esd-edit')) {
                                                    // edit
                                                    echo '<td>';
                                                        echo '<a href="/esd-tsa-edit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($proposals_edit).'"><i class="fa fa-pencil-alt"></i></a>';
                                                        echo '<a href="/esd-generic-tsa-proposal-print/'.$data['id'].'" class="btn btn-danger btn-xs" title="'.renderLang($proposals_print).'"><i class="fa fa-print"></i></a>';
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
                            <a href="/esd-proposal-types" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
            "order": [[ 0, "desc" ]]
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