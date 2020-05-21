<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('service-provider-add')) {

		// set page
		$page = 'service-providers';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($service_providers_new_service_provider); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($service_providers_new_service_provider); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_service_providers_add_err');
					?>
					
					<form method="post" action="/submit-add-service-provider">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($service_providers_add_service_provider_form); ?></h3>
							</div>
							<div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 ">
                                                <?php 
                                                if($_SESSION['sys_account_mode'] == 'user') {

                                                    $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                    }

                                                } else {

                                                    $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                                                    foreach($sub_property_ids as $sub_property_id) {

                                                        $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                        $sql->bindParam(":id", $sub_property_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                            echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                        }

                                                    }

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>

								<div class="row">

									<!-- Name of the Company -->
									<div class="col-lg-3 col-md-4">
										<label for="name_of_the_company"><?php echo renderLang($service_providers_name_of_the_company); ?></label>
										<input type="text" class="form-control" name="name_of_the_company" <?php if(isset($_SESSION['sys_service_providers_add_name_of_the_company_val'])) { echo ' value="'.$_SESSION['sys_service_providers_add_name_of_the_company_val'].'"'; } ?> >
									</div>

									<!-- Services -->
									<div class="col-lg-3 col-md-4">
										<label for="services"><?php echo renderLang($service_providers_services); ?></label>
										<input type="text" class="form-control" name="services" <?php if(isset($_SESSION['sys_service_providers_add_services_val'])) { echo ' value="'.$_SESSION['sys_service_providers_add_services_val'].'"'; } ?> >
									</div>

									<!-- Contact Person-->
									<div class="col-lg-3 col-md-4">
										<label for="contact_person"><?php echo renderLang($service_providers_contact_person); ?></label>
										<input type="text" class="form-control" name="contact_person" <?php if(isset($_SESSION['sys_service_providers_add_contact_person_val'])) { echo ' value="'.$_SESSION['sys_service_providers_add_contact_person_val'].'"'; } ?> >
									</div>
									

								</div><!-- row -->

								<div class="row">
									
									<!-- Mobile Number -->
									<div class="col-lg-3 col-md-4">
										<label for="mobile_number"><?php echo renderLang($service_providers_mobile_number); ?></label>
										<input type="text" class="form-control" name="mobile_number" <?php if(isset($_SESSION['sys_service_providers_add_mobile_number_val'])) { echo ' value="'.$_SESSION['sys_service_providers_add_mobile_number_val'].'"'; } ?> >
									</div>

									<!-- Landline Number -->
									<div class="col-lg-3 col-md-4">
										<label for="landline_number"><?php echo renderLang($service_providers_landline_number); ?></label>
										<input type="text" class="form-control" name="landline_number" <?php if(isset($_SESSION['sys_service_providers_add_landline_number_val'])) { echo ' value="'.$_SESSION['sys_service_providers_add_landline_number_val'].'"'; } ?> >
									</div>

									<!-- Email Address -->
									<div class="col-lg-3 col-md-4">
										<label for="email_address"><?php echo renderLang($service_providers_email_address); ?></label>
										<input type="text" class="form-control" name="email_address" <?php if(isset($_SESSION['sys_service_providers_add_email_address_val'])) { echo ' value="'.$_SESSION['sys_service_providers_add_email_address_val'].'"'; } ?> >
									</div>


								</div><!-- row -->


								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/service-providers" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($service_providers_save_service_provider); ?></button>
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
	<script>
		$(function() {

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