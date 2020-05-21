<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('30-60-90-days')) {
	
		// clear sessions from forms
		// clearSessions();

		// set page
		$page = 'day-plans';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT * FROM day_plan WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);

        // redirect if data is deleted
        if($_data['temp_del'] != 0 || !$sql->rowCount()) {
            $_SESSION['sys_day_plan_err'] = 'Data has been deleted';
            header('location: /30-60-90-day-plans');
            exit();
        }
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($day_plans_details); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1>
                                <i class="far fa-calendar-alt mr-3"></i><?php echo renderLang($day_plans_details); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']); ?>
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
                                <h3 class="card-title"><?php echo renderLang($day_plans_details); ?></h3>
                                <div class="card-tools">
                                    <button class="btn btn-info"><i class="fa fa-print mr-1"></i><?php echo renderLang($lang_print); ?></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <!-- default status temporary -->
                                <input type="hidden" name="status" value="0">

                                <div class="row mb-5">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="deployment"><?php echo renderLang($day_plans_date_of_deployment); ?></label>
                                            <input type="text" id="deployment" class="form-control input-readonly" readonly value="<?php echo date('Y-m-d', strtotime($_data['deployment_date'])); ?>">
                                        </div>
                                    </div>

                                </div>

                                <?php 
                                foreach($day_plans_arr as $days) { 

                                $symbol = explode('.', $days[0]);    
                                ?>
                                <p class="text-center">
                                    <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $symbol[0]; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $symbol[0].'. '; echo renderLang($days[1]); ?></button>
                                </p>
                                <div class="collapse" id="tab-<?php echo $symbol[0]; ?>">

                                    <div class="card card-body">

                                        <div class="row">
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-group">
                                                    <label for=""><?php echo renderLang($day_plans_to_be_accomplished_by); ?></label>
                                                    <input type="text" class="form-control input-readonly" readonly value="<?php echo date('Y-m-d', strtotime(getField('to_be_accomplished_date', 'day_plan_days', 'day_plan_id = '.$id.' AND day_category = '.$symbol[1]))); ?>">
                                                </div>
                                                
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo renderLang($day_plans_date); ?></th>
                                                                <th><?php echo renderLang($day_plans_action); ?></th>
                                                                <th><?php echo renderLang($day_plans_department_responsible); ?></th>
                                                                <th><?php echo renderLang($day_plans_remarks); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table-data">

                                                            <?php 
                                                            $sql = $pdo->prepare("SELECT * FROM day_plan_days WHERE day_plan_id = :day_plan_id AND day_category = :category");
                                                            $sql->bindParam(":day_plan_id", $id);
                                                            $sql->bindParam(":category", $symbol[1]);
                                                            $sql->execute();
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                echo '<tr>';
                                                                
                                                                echo '<td><input type="text" class="form-control input-readonly border-0" value="'.formatDate($data['plan_date']).'" readonly></td>';

                                                                echo '<td><p>'.$data['plan_action'].'</p></td>';

                                                                echo '<td><p>'.getField('department_code', 'departments', 'id='.$data['department_id']).' ['.getField('department_name', 'departments', 'id='.$data['department_id']).']</p></td>';

                                                                echo '<td><input type="text" class="form-control input-readonly border-0" value="'.$data['plan_remarks'].'" readonly></td>';

                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                    </div>    

                                </div>

                                <?php } ?>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/30-60-90-day-plans" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <a href="/edit-30-60-90-day-plan/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-upload mr-1"></i> <?php echo renderLang($day_plans_edit); ?></a>
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