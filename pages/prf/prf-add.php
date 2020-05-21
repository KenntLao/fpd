<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prf-add')) {

		// set page
		$page = 'prf';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prf_new_prf); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-people-carry mr-3"></i><?php echo renderLang($prf_new_prf); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_add_client_err');
					renderSuccess('sys_clients_add_client_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-prf" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($contract_add_contract_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">
									
									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="prospect_id" ><?php echo renderLang($prf_project); ?></label>
											<select class="form-control select2" id="prospect_id" name="prospect_id">
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0 ORDER BY project_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    // check if already created
                                                    $exist = getField('id', 'prf', 'temp_del = 0 AND prospect_id = '.$data['id']);
                                                    if(!$exist) {
                                                        echo '<option value="'.$data['id'].'"';
                                                        if($select_val == $data['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                    }
												}
												?>
											</select>
										</div>
									</div>

									<!-- ATTACHMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($downpayment_attachment); ?></label>
										<input type="file" class="form-control" name="attachment[]" multiple="">
									</div>

								</div><!-- row -->

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><?php echo renderLang($prf_department); ?></th>
                                                    <th><?php echo renderLang($prf_job_title); ?></th>
                                                    <th><?php echo renderLang($prf_number_of_staff); ?></th>
                                                    <th><?php echo renderLang($lang_status); ?></th>
                                                </tr>
                                            </thead>
                                            <thead class="table-data">
                                                <tr class="default-row">
                                                    <td><input type="text" class="form-control border-0" name="department[]"></td>
                                                    <td><input type="text" class="form-control border-0" name="job-title[]"></td>
                                                    <td><input type="text" class="form-control border-0" name="number-of-staff[]"></td>
                                                    <td>
                                                        <select name="status[]" id="" class="form-control border-0">
                                                        <?php 
                                                            foreach($prf_status_arr as $key => $value) {
                                                                echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                            }
                                                        ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="text-right">
                                            <button href="" class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                    </div>
                                </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/prf-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($prf_save_prf); ?></button>
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
	<script>
		$(function() {

			$('.add-row').on('click', function(e){
                e.preventDefault();

                var fields = '<tr>'+$('.default-row').html()+'</tr>';
                $('.table-data').append(fields);

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