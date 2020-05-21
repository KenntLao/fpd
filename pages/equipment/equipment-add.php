<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('occupant-add')) {
	
		// clear sessions from forms
		// clearSessions();

		// set page
		$page = 'equipment';
		
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($equipments_add_equipment); ?> &middot; <?php echo $sitename; ?></title>
	
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fa fa-users mr-3"></i><?php echo renderLang($equipments_add_equipment); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <form action="" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($equipments_add_equipment_form) ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($equipments_building); ?></label>
                                            <select name="" id="" class="form-control select2">
                                            <?php
                                            $sql = $pdo->prepare("SELECT sub_property_name, property_name, sp.id FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($equipments_serial_number); ?></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($equipments_description); ?></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($equipments_date_acquired); ?></label>
                                            <input type="text" class="form-control" id="date">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($equipments_amount); ?></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($equipments_supplier); ?></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/equipments" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-plus mr-1"></i><?php echo renderLang($equipments_add_equipment); ?></button>
                            </div>
                        </div>

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

			$('#date').daterangepicker({
				singleDatePicker: true
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