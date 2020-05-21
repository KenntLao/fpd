<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prf')) {

		// set page
		$page = 'prf';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT  prf.id, project_name, p.reference_number, p.project_name FROM prf JOIN prospecting p ON prf.prospect_id=p.id WHERE prf.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prf_new_prf); ?> &middot; <?php echo $sitename; ?></title>
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
							<h1><i class="fas fa-people-carry mr-3"></i><?php echo renderLang($prf); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['project_name']; ?>
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
								<h3 class="card-title"><?php echo renderLang($prf_details); ?></h3>
							</div>
							<div class="card-body">

								<div class="table-responsive">
                                	<table class="table table-bordered">
                                        <tr>
                                            <th class="w300"><?php echo renderLang($prf_project); ?></th>
                                            <td>[<?php echo $_data['reference_number']; ?>] <?php echo $_data['project_name']; ?></td>
                                        </tr>
                                    </table>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th><?php echo renderLang($prf_department); ?></th>
                                            <th><?php echo renderLang($prf_job_title); ?></th>
                                            <th><?php echo renderLang($prf_number_of_staff); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                        </tr>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM prf_departments WHERE prf_id = :id");
                                        $sql->bindParam(":id", $id);
                                        $sql->execute();
                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';

                                            echo '<td>'.$data['department'].'</td>';
                                            echo '<td>'.$data['job_title'].'</td>';
                                            echo '<td>'.$data['number_of_staff'].'</td>';
                                            echo '<td><span class="badge'.$btn_prf_status_arr[$data['status']].'">'.renderLang($prf_status_arr[$data['status']]).'</span></td>';

                                            echo '</tr>';
                                        }
                                        ?>
                                    </table>
                            	</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/prf-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if(checkPermission('prf-edit')) { ?>
								<a href="/edit-prf/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-pencil-alt mr-1"></i><?php echo renderLang($prf_edit_prf); ?></a>
								<?php } ?>
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
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>