<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "my-units";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($user_portal_my_units); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/user-portal.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">

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
							<h1><i class="fas fa-grip-horizontal mr-3"></i><?php echo renderLang($user_portal_my_units); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
            </section><!-- content-header -->
            
            <!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($user_portal_unit_list); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderlang($user_portal_unit_name); ?></th>
                                            <th><?php echo renderLang($user_portal_building); ?></th>
                                            <th><?php echo renderLang($user_portal_property); ?></th>
                                            <th><?php echo renderlang($user_portal_unit_type); ?></th>
                                            <th><?php echo renderLang($user_portal_capacity); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $table = '';
                                        $on = '';
                                        $where = '';

                                        if($_SESSION['sys_account_mode'] == 'unit_owner') {
                                            $table = 'unit_owners';
                                            $on = 'ON u.unit_owner_id = t.id';
                                            $where = 'WHERE t.id = '.$_SESSION['sys_id'];
                                        } else {
                                            $table = 'unit_tenant';
                                            $on = 'ON u.id = t.unit_id LEFT JOIN tenants tn ON t.tenant_id = tn.id';
                                            $where = 't.tenant_id = '.$_SESSION['sys_id'];
                                        }

                                        $sql = $pdo->prepare("SELECT u.id, unit_name, unit_type, unit_capacity, u.property_id, u.sub_property_id FROM units u LEFT JOIN $table t ".$on." ".$where);
                                        $sql->execute();
                                        while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';

                                            echo '<td><a href="">'.$data['unit_name'].'</a></td>';

                                            echo '<td>'.getField('sub_property_name', 'sub_properties', 'id = '.$data['sub_property_id']).'</td>';

                                            echo '<td>'.getField('property_name', 'properties', 'id = '.$data['property_id']).'</td>';

                                            echo '<td>';
                                            foreach($unit_type_arr as $key => $value) {
                                                if($value[0] == $data['unit_type']) {
                                                    echo renderLang($value[1]);
                                                }
                                            }
                                            echo '</td>';

                                            echo '<td>'.$data['unit_capacity'].'</td>';

                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
        <!-- /.content-wrapper -->
        
        <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>

    </div>

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