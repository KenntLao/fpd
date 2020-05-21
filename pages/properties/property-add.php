<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('property-add')) {

		// set page
		$page = 'properties';
		
		// suggested property ID
        $sql = $pdo->prepare("SELECT id, reference_number FROM prospecting ORDER BY id DESC LIMIT 1");
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $curr_date = date('ymd', time());
        if($data['reference_number'] == '') {
            $property_id_suggestion = $curr_date.'0001';
        } else {
            if(strpos($data['reference_number'], '-')) {
                $num = explode('-', $data['reference_number']);
                $num = $num[0];	
                $property_id_suggestion = $curr_date.substr($num, -4) + 1;
            } else {
                $property_id_suggestion = $curr_date.substr($data['reference_number'], -4) + 1;
            }
            
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($properties_add_property); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/users.css">
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($properties_add_property); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_properties_add_err');
					renderSuccess('sys_properties_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-property">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($properties_add_property_form); ?></h3>
							</div>
							<div class="card-body">
								
								<div class="row">
									
									<!-- PROPERTY ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_add_property_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="property_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_property_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control input-readonly required<?php if($err) { echo ' is-invalid'; } ?>" id="property_id" name="property_id" placeholder="<?php echo renderLang($properties_property_id_placeholder); ?>"<?php if(isset($_SESSION['sys_properties_add_property_id_val'])) { echo ' value="'.$_SESSION['sys_properties_add_property_id_val'].'"'; } else { echo ' value="'.$property_id_suggestion.'"'; } ?> required readonly>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_add_property_id_err'].'</p>'; unset($_SESSION['sys_properties_add_property_id_err']); } ?>
										</div>
									</div>

									<!-- PROPERTY CODE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_add_property_code_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="property_code" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_property_code); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="property_code" name="property_code" placeholder="<?php echo renderLang($properties_property_code_placeholder); ?>"<?php if(isset($_SESSION['sys_properties_add_property_code_val'])) { echo ' value="'.$_SESSION['sys_properties_add_property_code_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_add_property_code_err'].'</p>'; unset($_SESSION['sys_properties_add_property_code_err']); } ?>
										</div>
									</div>

									<!-- PROPERTY NAME -->
									<div class="col-lg-6 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_add_property_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="property_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_property_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="property_name" name="property_name" placeholder="<?php echo renderLang($properties_property_name_placeholder); ?>"<?php if(isset($_SESSION['sys_properties_add_property_name_val'])) { echo ' value="'.$_SESSION['sys_properties_add_property_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_add_property_name_err'].'</p>'; unset($_SESSION['sys_properties_add_property_name_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<div class="row">

									<!-- CLIENT -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_add_client_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="client_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_client); ?></label>
											<select class="form-control select2<?php if($err) { echo ' is-invalid'; } ?>" id="client_id" name="client_id">
												<option value="0">TBD</option>
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM clients WHERE temp_del = 0 ORDER BY client_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($select_val == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$data['client_name'].'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_add_client_id_err'].'</p>'; unset($_SESSION['sys_properties_add_client_id_err']); } ?>
										</div>
									</div>

                                    <!-- CLUSTER -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="cluster"><?php echo renderLang($cluster); ?></label>
                                            <select name="cluster" id="cluster" class="form-control select2">
                                                <option value="0">TBD</option>
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM clusters WHERE temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="'.$data['id'].'">'.$data['cluster_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
								
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/properties" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($properties_add_property); ?></button>
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