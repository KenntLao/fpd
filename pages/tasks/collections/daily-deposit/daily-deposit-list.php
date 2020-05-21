<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-deposit')) {
	
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
	<title><?php echo renderLang($collections_daily_deposit); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_daily_deposit); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_daily_deposit_err');
                    renderSuccess('sys_daily_deposit_add_suc');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($collections_daily_deposit_list); ?></h3>
                            <div class="card-tools">
                            <?php if(checkPermission('daily-deposit-add')) { ?>
                                <a href="/add-daily-deposit/<?php echo formatDate(time(), true); ?>-0" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($collections_daily_deposit_add); ?></a>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderlang($lang_date); ?></th>
                                            <th><?php echo renderLang($module_property); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <th><?php echo renderLang($lang_attachments); ?></th>
                                            <?php if(checkPermission('daily-deposit-edit')) { ?>
                                            <th class="w35 no-sort p-0"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($_SESSION['sys_account_mode'] == 'user') {

                                            $sql = $pdo->prepare("SELECT dd.id, deposit_date, sub_property_name, property_name, dd.sub_property_id, recorded_date, dd.status FROM daily_deposit dd LEFT JOIN sub_properties sp ON(dd.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE dd.temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';
                                                    // deposit date
                                                    echo '<td><a href="/daily-deposit/'.$data['id'].'">'.$data['recorded_date'].'</a></td>';
                                                    // property
                                                    echo '<td>'.$data['sub_property_name'].' ['.$data['property_name'].']</td>';
                                                    // status
                                                    echo '<td><span class="badge badge-'.$daily_deposit_status_color_arr[$data['status']].'">'.renderLang($daily_deposit_status_arr[$data['status']]).'</span></td>';
                                                    // attachments
                                                    echo '<td>';
                                                        $sql1 = $pdo->prepare("SELECT * FROM daily_deposit_reference WHERE deposit_id = :id");
                                                        $sql1->bindParam(":id", $data['id']);
                                                        $sql1->execute();
                                                        while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                            renderAttachments($data1['attachments'], 'daily-deposit');
                                                        }
                                                    echo '</td>';

                                                    if(checkPermission('daily-deposit-edit')) {
                                                        // edit
                                                        echo '<td>';
                                                            if($data['status'] == 0) {
                                                                echo '<a href="/edit-daily-deposit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
                                                            }
                                                        echo '</td>';
                                                    }
                                                    
                                                echo '</tr>';
                                            }

                                        } else { // employees

                                            // get clusters of user
											$cluster_ids = getClusterIDs($_SESSION['sys_id']);

                                            // no cluster
											if(empty($cluster_ids)) {

                                                $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
												$sub_properties = explode(',', $sub_property_ids);
												foreach($sub_properties as $sub_property_id) {

                                                    $sql = $pdo->prepare("SELECT dd.id, deposit_date, sub_property_name, property_name, dd.sub_property_id, recorded_date, dd.status FROM daily_deposit dd LEFT JOIN sub_properties sp ON(dd.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE dd.temp_del = 0 AND dd.sub_property_id = :sub_property_id");
                                                    $sql->bindParam(":sub_property_id", $sub_property_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';
                                                        // deposit date
                                                        echo '<td><a href="/daily-deposit/'.$data['id'].'">'.$data['recorded_date'].'</a></td>';
                                                        // property
                                                        echo '<td>'.$data['sub_property_name'].' ['.$data['property_name'].']</td>';
                                                        // status
                                                        echo '<td><span class="badge badge-'.$daily_deposit_status_color_arr[$data['status']].'">'.renderLang($daily_deposit_status_arr[$data['status']]).'</span></td>';
                                                        // attachments
                                                        echo '<td>';
                                                            $sql1 = $pdo->prepare("SELECT * FROM daily_deposit_reference WHERE deposit_id = :id");
                                                            $sql1->bindParam(":id", $data['id']);
                                                            $sql1->execute();
                                                            while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                renderAttachments($data1['attachments'], 'daily-deposit');
                                                            }
                                                        echo '</td>';
    
                                                        if(checkPermission('daily-deposit-edit')) {
                                                            // edit
                                                            echo '<td>';
                                                                if($data['status'] == 0) {
                                                                    echo '<a href="/edit-daily-deposit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
                                                                }
                                                            echo '</td>';
                                                        }
                                                        
                                                    echo '</tr>';
                                                    }

                                                }

                                            } else { // has cluster

                                                // get all properties under cluster
												$property_ids = array();
												$sub_property_ids = array();
												foreach($cluster_ids as $cluster_id) {
													// get properties under cluster
													$property_ids = getClusterProperties($cluster_id);

													// get all sub_properties under property
													foreach($property_ids as $property_id) {
														$sql = $pdo->prepare("SELECT id FROM sub_properties WHERE property_id = :property_id AND temp_del = 0");
														$sql->bindParam(":property_id", $property_id);
														$sql->execute();
														if($sql->rowCount()) {
															while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																$sub_property_ids[] = $data['id'];
															}
														}
													}
												}

												foreach($sub_property_ids as $sub_property_id) {

                                                    $sql = $pdo->prepare("SELECT dd.id, deposit_date, sub_property_name, property_name, dd.sub_property_id, recorded_date, dd.status FROM daily_deposit dd LEFT JOIN sub_properties sp ON(dd.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE dd.temp_del = 0 AND dd.sub_property_id = :sub_property_id");
                                                    $sql->bindParam(":sub_property_id", $sub_property_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';
                                                            // deposit date
                                                            echo '<td><a href="/daily-deposit/'.$data['id'].'">'.$data['recorded_date'].'</a></td>';
                                                            // property
                                                            echo '<td>'.$data['sub_property_name'].' ['.$data['property_name'].']</td>';
                                                            // status
                                                            echo '<td><span class="badge badge-'.$daily_deposit_status_color_arr[$data['status']].'">'.renderLang($daily_deposit_status_arr[$data['status']]).'</span></td>';
                                                            // attachments
                                                            echo '<td>';
                                                                $sql1 = $pdo->prepare("SELECT * FROM daily_deposit_reference WHERE deposit_id = :id");
                                                                $sql1->bindParam(":id", $data['id']);
                                                                $sql1->execute();
                                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                    renderAttachments($data1['attachments'], 'daily-deposit');
                                                                }
                                                            echo '</td>';
        
                                                            if(checkPermission('daily-deposit-edit')) {
                                                                // edit
                                                                echo '<td>';
                                                                    if($data['status'] == 0) {
                                                                        echo '<a href="/edit-daily-deposit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
                                                                    }
                                                                echo '</td>';
                                                            }
                                                            
                                                        echo '</tr>';
                                                    }

                                                }

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
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
  	<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
    $(function(){

        $('#table-data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(e) {
            e.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
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