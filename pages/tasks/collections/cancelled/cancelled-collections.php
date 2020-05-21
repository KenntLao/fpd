<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('cancelled-collections')) {
	
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
	<title><?php echo renderLang($cancelled_collections); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($cancelled_collections); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_cancelled_collection_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($cancelled_collections_form); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
											<th><?php echo renderLang($daily_collections_daily_collection_unit); ?></th>
                                            <th><?php echo renderLang($cancelled_collections_reference); ?></th>
                                            <th><?php echo renderLang($lang_date); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <th class="p-0 w35"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT sub_property_name, property_name, cc.id, dc.unit_id, dc.voucher_type, or_number, ar_number, pr_number, dc.collection_date, cc.status FROM cancelled_collection  cc JOIN daily_collections dc ON(cc.collection_id = dc.id) JOIN sub_properties sp ON(dc.sub_property_id = sp.id) JOIN properties p ON(sp.property_id = p.id) WHERE dc.temp_del = 0");
                                        $sql->execute();
                                        if($sql->rowCount()) {
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';
                                                    // property
                                                    echo '<td>';
                                                        echo '<a href="/cancelled-collection/'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</a>';
                                                    echo '</td>';
                                                    // units
                                                    echo '<td>';
                                                        $unit_ids = explode(",", $data['unit_id']);
                                                        $unit_names = array();
                                                        if(!empty($unit_ids)) {
                                                            foreach($unit_ids as $unit_id) {
                                                                $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                if(checkVar($unit_name)) {
                                                                    $unit_names[] = $unit_name;
                                                                } else {
                                                                    $unit_names[] = $unit_id;
                                                                }
                                                            }
                                                        }
                                                        echo implode(", ", $unit_names);
                                                    echo '</td>';
                                                    // reference
                                                    echo '<td>';
                                                        echo renderLang($reference_number_arr[$data['voucher_type']]);
                                                        if ($data['voucher_type'] == 1) {
                                                            echo ' ['.$data['ar_number'].']';
                                                        }
                                                        if ($data['voucher_type'] == 2) {
                                                            echo ' ['.$data['or_number'].']';
                                                        }
                                                        if ($data['voucher_type'] == 3) {
                                                            echo ' ['.$data['pr_number'].']';
                                                        }
                                                    echo '</td>';

                                                    echo '<td>';
                                                        echo formatDate($data['collection_date']);
                                                    echo '</td>';

                                                    echo '<td>';
                                                        echo '<span class="badge badge-'.$cancelled_collection_status_color_arr[$data['status']].'">'.renderLang($cancelled_collection_status_arr[$data['status']]).'</span>';
                                                    echo '</td>';

                                                    echo '<td>';
                                                        echo '';
                                                    echo '</td>';

                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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