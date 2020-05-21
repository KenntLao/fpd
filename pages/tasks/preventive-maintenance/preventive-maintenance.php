<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('preventive-maintenance')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'preventive-maintenance';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($preventive_maintenance); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row my-3">
						<div class="col-sm-9">
							<h1><i class="fas fa-tools mr-3"></i><?php echo renderLang($preventive_maintenance); ?></h1>
						</div>
					</div>
 

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="row" id="frequency-tabs">
						
					
						
                        <?php foreach($preventive_maintenance_frequency_arr as $key => $frequency) { ?>
                          
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="bg-redd p-3 h-100 position-relative rounded" data-id="<?php echo $key; ?>">
                                    <div class="row">
                                        <div class="col-8 position-relative">
                                            <div class="bottom-left">
                                                <h3><?php echo renderLang($frequency[1]); ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-4 mx-auto">
                                            <img class="zoom" src="/assets/images/preventive-maintenance-icon/<?php echo $frequency[0]; ?>.png" width="100%">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
					
					
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script>
        $(function(){

            $('#frequency-tabs').on('click', '.bg-redd', function(){
                var id = $(this).data('id');
                window.location.href = '/frequency-preventive-maintenance/'+id;
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