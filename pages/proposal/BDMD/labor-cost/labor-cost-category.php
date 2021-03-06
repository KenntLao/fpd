<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost')) {
	
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
	<title><?php echo renderLang($labor_cost); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($labor_cost); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
                    
                    <div class="card">
                        <div class="card-body">

							<div class="row" id="tabs">

		                        <div class="col-sm-6 col-md-4 mb-3">
		                            <div class="bg-redd p-3 h-100 position-relative rounded tab" data-href="/labor-cost-list">
		                                <div class="row">
		                                    <div class="col-8 position-relative">
		                                        <div class="bottom-left">
		                                            <h3><?php echo renderLang($labor_cost_fpd_direct_hire); ?></h3>
		                                        </div>
		                                    </div>
		                                    <div class="col-4 mx-auto">
		                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
		                                    </div>
		                                </div>
		                            </div>
		                        </div>

		                        <div class="col-sm-6 col-md-4 mb-3">
		                            <div class="bg-redd p-3 h-100 position-relative rounded tab" data-href="/outsource-labor-cost-list">
		                                <div class="row">
		                                    <div class="col-8 position-relative">
		                                        <div class="bottom-left">
		                                            <h3><?php echo renderLang($labor_cost_outsource); ?></h3>
		                                        </div>
		                                    </div>
		                                    <div class="col-4 mx-auto">
		                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
		                                    </div>
		                                </div>
		                            </div>
		                        </div>

                                <div class="col-sm-6 col-md-4 mb-3">
		                            <div class="bg-redd p-3 h-100 position-relative rounded tab" data-href="/preview-labor-cost-list">
		                                <div class="row">
		                                    <div class="col-8 position-relative">
		                                        <div class="bottom-left">
		                                            <h3><?php echo renderLang($labor_cost_preview); ?></h3>
		                                        </div>
		                                    </div>
		                                    <div class="col-4 mx-auto">
		                                        <img class="zoom" src="/assets/images/preventive-maintenance-icon/Q.png" width="100%">
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        
		                    </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/bdmd-proposal-types" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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