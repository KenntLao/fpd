<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-visitors";


	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

	$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM visitors WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($visitor); ?> &middot; <?php echo $sitename; ?></title>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($visitor); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['name_of_visitor']; ?>
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
								<h3 class="card-title"><?php echo renderLang($visitors_details); ?></h3>
								<div class="card-tools">
                                <button class="btn<?php echo $visitors_status_status_arr[$_data['status']]; ?>"><?php echo renderLang($visitors_status_arr[$_data['status']]); ?></button>
                            	</div>
							</div>
							<div class="card-body">

								<div class="table-responsive">
                                	<table class="table table-bordered">
                                        <tr>
                                            <th class="w300"><?php echo renderLang($visitors_name_of_visitor); ?></th>
                                            <td><?php echo $_data['name_of_visitor']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($visitors_company_address); ?></th>
                                            <td><?php echo $_data['company_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($visitors_person_to_visit); ?></th>
                                            <td><?php echo $_data['person_to_visit']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($visitors_purpose); ?></th>
                                            <td><?php echo $_data['purpose']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo renderLang($visitors_time_in); ?></th>
                                            <td><?php echo $_data['time_in']; ?></td>
                                        </tr> 
                                        <tr>
                                            <th><?php echo renderLang($visitors_time_out); ?></th>
                                            <td><?php echo $_data['time_out']; ?></td>
                                        </tr>

                                    </table>
                            	</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/visitors" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
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
	} else { // invalid account mode

		// logout to current session
		session_destroy();
		session_start();
		
		$_SESSION['sys_user_login_err'] = renderLang($permission_message_1); // "You are not authorized to access this page. Please login first."
		header('location: /user-login');
	
	}

} else { // no session found, redirect to login page
	
	$_SESSION['sys_user_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /user-login');
	
}
?>