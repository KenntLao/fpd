<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd') || checkPermission('proposal-esd') || checkPermission('proposal-pod')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($proposals); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($proposals); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="row" id="tabs">

                        <?php if(checkPermission('proposal-bdd')) { ?>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <div class="bg-redd p-3 h-100 position-relative rounded tab" data-href="/bdmd-proposal-types">
                                <div class="row">
                                    <div class="col-8 position-relative">
                                        <div class="bottom-left">
                                            <h3><?php echo renderLang($proposals_bdmd); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-4 mx-auto">
                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('proposal-esd')) { ?>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <div class="bg-redd p-3 h-100 position-relative rounded tab" data-href="/esd-proposal-types">
                                <div class="row">
                                    <div class="col-8 position-relative">
                                        <div class="bottom-left">
                                            <h3><?php echo renderLang($proposals_esd); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-4 mx-auto">
                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(checkPermission('proposal-pod')) { ?>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <div class="bg-redd p-3 h-100 position-relative rounded tab" data-href="/pod-proposals">
                                <div class="row">
                                    <div class="col-8 position-relative">
                                        <div class="bottom-left">
                                            <h3><?php echo renderLang($proposals_pod); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-4 mx-auto">
                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
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

        // redirect
        $('#tabs').on('click', '.tab', function(){
            var href = $(this).data('href');
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