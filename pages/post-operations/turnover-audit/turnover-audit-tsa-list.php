<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('turnover-audits')) {

    $page = 'turnover-audit';
    
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
	<title><?php echo renderLang($turnover_audit); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($turnover_audit); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pre_operation_audit_tsa_suc');
                    renderError('sys_operations_audit_tsa_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($turnover_audit_list); ?></h3>
                            <div class="card-tools">
                                <?php if(checkPermission('audits')) { ?><a href="/add-tsa-turnover-audit" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($turnover_audit_add); ?></a><?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="table-data" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($operation_audit_project); ?></th>
                                            <th><?php echo renderLang($operation_audit_date_of_audit); ?></th>
                                            <th><?php echo renderLang($operation_audit_tsa_date_presented_to_board); ?></th>
                                            <th><?php echo renderLang($operation_audit_tsa_building_picture); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <?php if(checkPermission('pre-operation-audit-TSA-edit')) { ?>
                                            <th class="w35 p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										$sql = $pdo->prepare("SELECT * FROM operations_audit_tsa WHERE temp_del = 0");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											echo '<tr>';
												echo '<td>'.getField('project_name', 'prospecting', 'id = '.$data['prospect_id']).'</td>';
												echo '<td>'.$data['date_of_audit'].'</td>';
												echo '<td>'.formatDate($data['date_presented']).'</td>';
												echo '<td></td>';
												echo '<td></td>';
												echo '<td><a href="/turnover-audit-tsa/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($downpayment_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
											echo '</tr>';
											
										}
										?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/turnover-audits" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
	<script>
		$(function(){

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			}); 

            $('#table-data').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
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