<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('amenities')) {

		// set page
		$page = 'amenities';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM amenities WHERE id = :id LIMIT 1");
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
	<title><?php echo renderLang($amenity); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="far fa-calendar-minus mr-3"></i><?php echo renderLang($amenity); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['project_name']; ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($amenities_edit_amenity_form); ?></h3>
								<div class="card-tools">
                                <button class="btn<?php echo $visitors_status_status_arr[$_data['status']]; ?>"><?php echo renderLang($amenities_arr[$_data['status']]); ?></button>
                            	</div>
							</div>
							<div class="card-body">

								<div class="table-responsive">
                                	<table class="table table-bordered">
                                        
                                        <tr>
                                            <th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
                                            <?php 
											$sql = $pdo->prepare("SELECT sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON (sp.property_id = p.id) WHERE sp.id = :sub_property_id");
											$sql->bindParam(":sub_property_id",$_data['sub_property_id']);
											$sql->execute();
											$_data2 = $sql->fetch(PDO::FETCH_ASSOC);
											?>
                                            <td><?php echo $_data2['sub_property_name']; ?> [<?php echo $_data2['property_name']; ?>]</td>
                                        </tr>
                                        <tr>
                                            <th class="w300"><?php echo renderLang($amenities_project_name); ?></th>
                                            <td><?php echo $_data['project_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($amenities_venue); ?></th>
                                            <td><?php echo $_data['venue']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($amenities_subject); ?></th>
                                            <td><?php echo $_data['subject']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($amenities_date); ?></th>
                                            <td><?php echo formatDate($_data['date']); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($amenities_time_started_end); ?></th>
                                            <td><?php echo $_data['time_started_end']; ?></td>
                                        </tr> 

                                    </table>
                            	</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/amenities" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if(checkPermission('amenity-edit')) { ?>
								<a href="/edit-amenity/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($amenities_edit_amenity); ?></a>
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