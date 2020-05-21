<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calibrations')) {

    $page = 'calibration';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($calibration_equipment_calibration_monitoring); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/assets/css/preventive-maintenance.css">
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($calibration_equipment_calibration_monitoring); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid" id="tabs">

                    <div class="row">
						
						<?php if (checkPermission('calibration-plans')) { ?>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/calibration-plans">
                                <div class="row">
                                    <div class="col-8 position-relative">
                                        <div class="bottom-left">
                                            <h3><?php echo renderLang($calibration_plans); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-4 mx-auto">
                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/D.png" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
						
						<?php if (checkPermission('calibration-monitoring')) { ?>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/calibration-list">
                                <div class="row">
                                    <div class="col-8 position-relative">
                                        <div class="bottom-left">
                                            <h3><?php echo renderLang($calibration_monitoring); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-4 mx-auto">
                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/D.png" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

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
	<script>
		$(function(){

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            
            $('#tabs').on('click', '.bg-redd', function(){

                var href = $(this).data('id');

                window.location.href = href;

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