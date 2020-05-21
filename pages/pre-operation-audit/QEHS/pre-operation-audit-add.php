<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-QEHS-add')) {

	$page = 'pre-operation-audit';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pre_operation_audit_add); ?> &middot; <?php echo $sitename; ?></title>
	
    <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <form action="/submit-add-pre-operation-audit" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="department" value="QEHS">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="project_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                            <select name="project_id" id="project_id" class="form-control select2">
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM prospecting WHERE status = 3 AND prospecting_category = 0 AND temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="auditee"><?php echo renderLang($pre_operation_audit_auditee); ?></label>
                                            <input type="text" class="form-control" name="auditee" id="auditee">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date"><?php echo renderLang($pre_operation_audit_date_of_audit); ?></label>
                                            <input type="text" class="form-control" name="date_of_audit" id="date">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="auditors"><?php echo renderLang($pre_operation_audit_auditors); ?></label>
                                            <select name="auditors[]" id="auditors[]" class="duallistbox" multiple>
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM employees WHERE temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    $full_name = $data['firstname'].' '.$data['lastname'];
                                                    echo '<option value="'.$data['id'].'">'.$full_name.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pre-operation-audits" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($pre_operation_audit_save_audit_checklist); ?></button>
                            </div>
                        </div>
                    
                    </form>

                </div>

			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function(){

			$('.duallistbox').bootstrapDualListbox();

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