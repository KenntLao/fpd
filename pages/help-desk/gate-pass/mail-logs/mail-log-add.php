<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('mail-log-add')) {

		// set page
		$page = 'mail-logs';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($mail_logs_new_mail_log); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($mail_logs_new_mail_log); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_mail_logs_add_err');
					?>
					
					<form method="post" action="/submit-add-mail-log">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($mail_logs_add_visitor_form); ?></h3>
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

									<!-- REFERENCE NUMBER-->
									<div class="col-lg-3 col-md-4">
										<label for="reference_number"><?php echo renderLang($mail_logs_reference_number); ?></label>
										<input type="text" class="form-control" name="reference_number" <?php if(isset($_SESSION['sys_mail_logs_add_reference_number_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_add_reference_number_val'].'"'; } ?> required>
									</div>

                                    <!-- DATE RECEIVED -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date_received"><?php echo renderLang($mail_logs_date_received); ?></label>
											<input type="text" class="form-control date" name="date_received">
										</div>
									</div>

									<!-- ADDRESSEE -->
									<div class="col-lg-3 col-md-4">
										<label for="addressee"><?php echo renderLang($mail_logs_addressee); ?></label>
										<input type="text" class="form-control" name="addressee" <?php if(isset($_SESSION['sys_mail_logs_add_addressee_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_add_addressee_val'].'"'; } ?> required>
									</div>

								</div>
								
								<div class="row">

									<!-- SENDER -->
									<div class="col-lg-3 col-md-4">
										<label for="sender"><?php echo renderLang($mail_logs_sender); ?></label>
										<input type="text" class="form-control" name="sender" <?php if(isset($_SESSION['sys_mail_logs_add_sender_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_add_sender_val'].'"'; } ?> required>
									</div>

									<!-- DATE SENT -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date_sent"><?php echo renderLang($mail_logs_date_sent); ?></label>
											<input type="text" class="form-control date" name="date_sent">
										</div>
									</div>

									<!-- REMARKS -->
									<div class="col-lg-3 col-md-4">
										<label for="remarks"><?php echo renderLang($mail_logs_remarks); ?></label>
										<input type="text" class="form-control" name="remarks" <?php if(isset($_SESSION['sys_mail_logs_add_remarks_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_add_remarks_val'].'"'; } ?> >
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/mail-logs" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($mail_logs_save_mail_log); ?></button>
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

			$('.date').daterangepicker({
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