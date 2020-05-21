<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('cluster-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'clusters';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($clusters_new_cluster); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($clusters_new_cluster); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_cluster_add_err');
                    ?>

                    <form action="/submit-add-cluster" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($clusters_new_cluster_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <!-- Cluster Name -->
                                    <div class="col-lg-3 col-md-4">
                                        <?php $err = isset($_SESSION['sys_cluster_add_cluster_name_err']) ? 1 : 0; ?>
                                        <div class="form-group">
                                            <label for="cluster_name" class="mr-1<?php echo $err ? ' text-danger' : '' ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($clusters_name); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <input type="text" name="cluster_name" id="cluster_name" class="form-control required<?php echo $err ? ' is-invalid' : ''; ?>">
                                            <?php 
                                            echo $err ? '<p class="error-message text-danger mt-2">'.$_SESSION['sys_cluster_add_cluster_name_err'].'</p>' : '';
                                            unset($_SESSION['sys_cluster_add_cluster_name_err']);
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Assigned -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="assigned"><?php echo renderlang($clusters_assigned); ?></label>
                                            <select name="assigned" id="assigned" class="form-control select2">
                                                <option value="0">TBD</option>
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM employees WHERE temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/clusters" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($clusters_add); ?></button>
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