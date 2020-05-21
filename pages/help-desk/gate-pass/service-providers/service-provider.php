<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('service-providers')) {

		// set page
		$page = 'service-providers';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM service_providers WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($service_provider); ?> &middot; <?php echo $sitename; ?></title>
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($service_provider); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['name_of_the_company']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($service_providers_details); ?></h3>
							</div>
							<div class="card-body">

								<div class="table-responsive">
                                	<table class="table table-bordered">
                                        <tr>
                                            <th class="w300"><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
                                            <?php 
											$sql = $pdo->prepare("SELECT sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON (sp.property_id = p.id) WHERE sp.id = :sub_property_id");
											$sql->bindParam(":sub_property_id",$_data['sub_property_id']);
											$sql->execute();
											$_data2 = $sql->fetch(PDO::FETCH_ASSOC);
											?>
                                            <td><?php echo $_data2['sub_property_name']; ?> [<?php echo $_data2['property_name']; ?>]</td>
                                        </tr>
                                        <tr>
                                            <th class="w300"><?php echo renderLang($service_providers_name_of_the_company); ?></th>
                                            <td><?php echo $_data['name_of_the_company']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($service_providers_services); ?></th>
                                            <td><?php echo $_data['services']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($service_providers_contact_person); ?></th>
                                            <td><?php echo $_data['contact_person']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($service_providers_mobile_number); ?></th>
                                            <td><?php echo $_data['mobile_number']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($service_providers_landline_number); ?></th>
                                            <td><?php echo $_data['landline_number']; ?></td>
                                        </tr> 
                                        <tr>
                                            <th><?php echo renderLang($service_providers_email_address); ?></th>
                                            <td><?php echo $_data['email_address']; ?></td>
                                        </tr>

                                    </table>
                            	</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/service-providers" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if(checkPermission('service-provider-edit')) { ?>
								<a href="/edit-service-provider/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($service_providers_edit_service_provider); ?></a>
								<?php } ?>
							</div>
						</div><!-- card -->
					
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