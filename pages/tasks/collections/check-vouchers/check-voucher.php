<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('check-vouchers')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'collections';

		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT cv.*, property_name FROM check_voucher cv JOIN properties p ON(cv.property_id = p.id) WHERE cv.id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
		} else {
			$_SESSION['sys_check_voucher_edit_err'] = renderLang($lang_no_data);
			header('location: /check-vouchers');
			exit();
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections_check_voucher); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_check_voucher); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($collections_check_voucher); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-7">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th><?php echo renderLang($module_property); ?></th>
                                                <td><?php echo $_data['property_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($lang_date); ?></th>
                                                <td><?php echo formatDate($_data['date']); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($collections_check_voucher_reference_number); ?></th>
                                                <td><?php echo $_data['reference_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($collections_check_voucher_bank); ?></th>
                                                <td>
                                                    <?php 
                                                    if($_data['bank'] == 999) {
                                                        echo $_data['other_bank'];
                                                    } else {
                                                        echo renderLang($banks_arr[$_data['bank']]);
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($collections_check_voucher_amount); ?></th>
                                                <td><?php echo $_data['amount']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($collections_check_voucher_check_number); ?></th>
                                                <td><?php echo $_data['check_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($collections_check_voucher_particulars); ?></th>
                                                <td><?php echo $_data['particulars']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($collections_check_voucher_payee); ?></th>
                                                <td><?php echo $_data['payee']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/check-vouchers" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                        </div>
                    </div>

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