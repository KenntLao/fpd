<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-other-task-add')) {

		// set page
		$page = 'pre-operation-other-tasks';

	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($po_new_other_task); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
							<h1><i class="fas fa-th mr-3"></i><?php echo renderLang($po_new_other_task); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_amenities_add_suc');
					?>
					
					<form method="post" action="/submit-add-pre-operation-other-task" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($po_new_other_task_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- SERVICE REQUIRED -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="department_id" ><?php echo renderLang($downpayment_project); ?></label>
											<select class="form-control select2" id="department_id" name="department_id">
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM departments WHERE temp_del = 0 ORDER BY department_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($select_val == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>['.$data['department_code'].'] '.$data['department_name'].'</option>';
												}
												?>
											</select>
										</div>
									</div>

									<!-- TITLE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="title"><?php echo renderLang($po_other_task_title); ?></label>
											<input type="text" class="form-control" id="title" name="title">
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="title"><?php echo renderLang($po_other_task_status); ?></label>
											<select name="status" id="" class="form-control">
                                                        <?php 
                                                            foreach($other_task_status_arr as $key => $value) {
                                                                echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                            }
                                                        ?>
                                            </select>
										</div>
									</div>								
									
								</div><!-- row -->

								<div class="row">

                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <div class="row">
												<div class="col-md-6"><label class="pl-1"><?php echo renderLang($po_other_task_employee_list); ?></label></div>
												<div class="col-md-6"><label class="pl-1"><?php echo renderlang($po_other_task_incharge); ?></label></div>
											</div>
                                            <select name="incharges[]" id="incharges[]" class="duallistbox" multiple>
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

                                <div class="row">

                                	<!-- ATTACHMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($downpayment_attachment); ?></label>
										<input type="file" class="form-control" name="attachment[]" multiple="">
									</div>
                                	
                                </div>

								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/pre-operation-other-tasks" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($po_other_task_save_other_task); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
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
		$(function() {

			$('#timeline').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

			$('.duallistbox').bootstrapDualListbox();
			
			$('.btn-submit-form').click(function(e) {
				e.preventDefault();
				var employee_ids = $('.employee_ids').val().join(',');
				$('#employee_ids').val(employee_ids);
				$('form').submit();
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