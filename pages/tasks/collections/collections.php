<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('collections')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'collections';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<div class="card">
						<div class="card-header">
							<h3></h3>
						</div>
						<div class="card-body">
						
							<div class="row" id="tabs">
						
								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/daily-collections/1">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($daily_collections_daily_collection); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded undeposited" data-href="/undeposited-list">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($collections_on_hand); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/check-vouchers">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($collections_check_vouchers); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>

								<?php if(checkPermission('daily-deposit')) { ?>
								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/daily-deposit-list">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($collections_daily_deposit); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

                                <?php if(checkPermission('daily-collection-reports')) { ?>
								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/daily-collection-reports">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($daily_collection_reports); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

                                <?php if(checkPermission('daily-collection-reports')) { ?>
								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/pdc-monitoring-list">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($pdc); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

                                <?php if(checkPermission('unidentified')) { ?>
								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/unidentified-list">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($unidentified); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

                                <?php if(checkPermission('deposit-in-transit')) { ?>
								<div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/deposit-in-transit-list">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($deposit_in_transit); ?></h3>
												</div>
											</div>
											<div class="col-4 mx-auto">
												<img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

                                <?php if(checkPermission('cancelled-collections')) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
									<div class="bg-redd p-3 h-100 position-relative rounded" data-href="/cancelled-collections">
										<div class="row">
											<div class="col-8 position-relative">
												<div class="bottom-left">
													<h3><?php echo renderLang($cancelled_collections); ?></h3>
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
						
						</div>
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
		$('#tabs').on('click', '.bg-redd', function(){

            var $this = $(this);

            window.location.href = $this.data('href');
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