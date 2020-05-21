<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('tenants')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'tenants';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($tenants_tenants); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	
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
							<h1><i class="far fa-address-card mr-3"></i><?php echo renderLang($tenants_tenants); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_tenants_err');
					renderSuccess('sys_tenants_suc');
					renderError('sys_time_err');
                    renderSuccess('sys_time_suc');
					renderSuccess('sys_tenants_edit_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($tenants_tenants_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('tenant-add')) { ?><a href="/add-tenant" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($tenants_add_tenant); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover with-options">
									<thead>
										<tr>
											<th><?php echo renderLang($tenants_tenant_id); ?></th>
											<th><?php echo renderLang($tenants_lastname); ?></th>
											<th><?php echo renderLang($tenants_firstname); ?></th>
											<th><?php echo renderLang($tenants_middlename); ?></th>
											<th><?php echo renderLang($lang_citizenship_global); ?></th>
											<th><?php echo renderLang($tenants_relationship_to_owner); ?></th>
											<th><?php echo renderLang($properties_property); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<th class="w150"><?php echo renderLang($tenants_last_login); ?></th>
											<?php if(checkPermission('tenant-edit')) { ?>
											<th style="width:35px;"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
                                        $data_count = 0;
                                        if($_SESSION['sys_account_mode'] == 'user') {

                                            $sql = $pdo->prepare("SELECT t.id, status, last_login, t.tenant_id, lastname, middlename, firstname, relationship_to_owner, social_status, nationality, ut.unit_id FROM tenants t LEFT JOIN countries ON citizenship_id = num_code LEFT JOIN unit_tenants ut ON(ut.tenant_id = t.id) WHERE t.temp_del = 0 ORDER BY tenant_id ASC");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $data_count++;
                                                $id = $data['id'];

                                                echo '<tr>';

                                                    // tenant ID
                                                    echo '<td><a href="/tenant/'.$data['id'].'">'.$data['tenant_id'].'</a></td>';

                                                    // LAST NAME
                                                    echo '<td>'.$data['lastname'].'</td>';

                                                    // FIRST NAME
                                                    echo '<td>'.$data['firstname'].'</td>';

                                                    // MIDDLE NAME
                                                    echo '<td>'.$data['middlename'].'</td>';

                                                    // CITIZENSHIP
                                                    echo '<td>'.$data['nationality'].'</td>';

                                                    // RELATION TO OWNER
                                                    echo '<td>'.(!empty($data['relationship_to_owner']) ? renderLang($relationship_to_owner_arr[$data['relationship_to_owner']]) : '' ).'</td>';
                                                
                                                    // PROPERTIES
                                                    echo '<td>';
                                                        if(checkVar($data['unit_id'])) {
                                                            $sub_property_id = getField('sub_property_id', 'units', 'id = '.$data['unit_id']);
                                                            $property_id = getField('property_id', 'units', 'id = '.$data['unit_id']);
                                                            $unit_name = getField('unit_name', 'units', 'id = '.$data['unit_id']);
                                                            if(checkVar($unit_name)) {

                                                                $property_name = getField('property_name', 'properties', 'id = '.$property_id);
                                                                $sub_property_name = getField('sub_property_name', 'sub_properties', 'id = '.$sub_property_id);
                                                                echo $unit_name.', '.$sub_property_name.', '.$property_name;

                                                            }
                                                        }
                                                    echo '</td>';

                                                    // STATUS
                                                    echo '<td>';
                                                        foreach($status_arr as $status) {
                                                            if($status[0] == $data['status']) {
                                                                switch($data['status']) {
                                                                    case 0:
                                                                        echo '<span class="text-success">'.renderLang($status[1]).'</span>';
                                                                        break;
                                                                    case 1:
                                                                        echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
                                                                        break;
                                                                }
                                                            }
                                                        }
                                                    echo '</td>';

                                                    // LAST LOGIN
                                                    echo '<td>';
                                                        if($data['last_login'] > 0) {
                                                            echo date('Ymd',$data['last_login']).' &middot; '.date('H:i:s',$data['last_login']);
                                                        } else {
                                                            echo '-';
                                                        }
                                                    echo '</td>';

                                                    // EDIT tenant
                                                    if(checkPermission('tenant-edit')) {
                                                        echo '<td>';
                                                                echo '<a href="/edit-tenant/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($tenants_edit_tenant).'"><i class="fa fa-pencil-alt"></i></a>';
                                                        echo '</td>';
                                                    }

                                                echo '</tr>';
                                            }

                                        } else { // employee
                                            
                                            // get clusters of user
                                            $cluster_ids = getClusterIDs($_SESSION['sys_id']);
                                            
                                            // no cluster
											if(empty($cluster_ids)) {

                                                $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                $sub_properties = explode(',', $sub_property_ids);
                                                
                                                // get unit all unit owner id under sub property
                                                $unit_ids = array();
												foreach($sub_properties as $sub_property_id) {
                                                    $sql = $pdo->prepare("SELECT id FROM units WHERE sub_property_id = :sub_property_id AND temp_del = 0");
                                                    $sql->bindParam(":sub_property_id", $sub_property_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        $unit_ids[] = $data['id'];
                                                    }
                                                }

                                                foreach($unit_ids as $unit_id) {
                                                    $sql = $pdo->prepare("SELECT t.id, status, last_login, t.tenant_id, lastname, middlename, firstname, relationship_to_owner, social_status, nationality, ut.unit_id FROM tenants t LEFT JOIN countries ON citizenship_id = num_code LEFT JOIN unit_tenants ut ON(ut.tenant_id = t.id) WHERE ut.unit_id = :unit_id AND t.temp_del = 0 ORDER BY tenant_id ASC");
                                                    $sql->bindParam(":unit_id", $unit_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        $data_count++;
                                                        $id = $data['id'];

                                                        echo '<tr>';

                                                            // tenant ID
                                                            echo '<td><a href="/tenant/'.$data['id'].'">'.$data['tenant_id'].'</a></td>';

                                                            // LAST NAME
                                                            echo '<td>'.$data['lastname'].'</td>';

                                                            // FIRST NAME
                                                            echo '<td>'.$data['firstname'].'</td>';

                                                            // MIDDLE NAME
                                                            echo '<td>'.$data['middlename'].'</td>';

                                                            // CITIZENSHIP
                                                            echo '<td>'.$data['nationality'].'</td>';

                                                            // RELATION TO OWNER
                                                            echo '<td>'.renderLang($relationship_to_owner_arr[$data['relationship_to_owner']]).'</td>';
                                                        
                                                            // PROPERTIES
                                                            echo '<td>';
                                                                if(checkVar($data['unit_id'])) {
                                                                    $sub_property_id = getField('sub_property_id', 'units', 'id = '.$data['unit_id']);
                                                                    $property_id = getField('property_id', 'units', 'id = '.$data['unit_id']);
                                                                    $unit_name = getField('unit_name', 'units', 'id = '.$data['unit_id']);
                                                                    if(checkVar($unit_name)) {

                                                                        $property_name = getField('property_name', 'properties', 'id = '.$property_id);
                                                                        $sub_property_name = getField('sub_property_name', 'sub_properties', 'id = '.$sub_property_id);
                                                                        echo $unit_name.', '.$sub_property_name.', '.$property_name;
                                                                        
                                                                    }
                                                                }
                                                            echo '</td>';

                                                            // STATUS
                                                            echo '<td>';
                                                                foreach($status_arr as $status) {
                                                                    if($status[0] == $data['status']) {
                                                                        switch($data['status']) {
                                                                            case 0:
                                                                                echo '<span class="text-success">'.renderLang($status[1]).'</span>';
                                                                                break;
                                                                            case 1:
                                                                                echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
                                                                                break;
                                                                        }
                                                                    }
                                                                }
                                                            echo '</td>';

                                                            // LAST LOGIN
                                                            echo '<td>';
                                                                if($data['last_login'] > 0) {
                                                                    echo date('Ymd',$data['last_login']).' &middot; '.date('H:i:s',$data['last_login']);
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            echo '</td>';

                                                            // EDIT tenant
                                                            if(checkPermission('tenant-edit')) {
                                                                echo '<td>';
                                                                        echo '<a href="/edit-tenant/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($tenants_edit_tenant).'"><i class="fa fa-pencil-alt"></i></a>';
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
                                                
                                                // get unit all unit owner id under sub property
                                                $unit_ids = array();
												foreach($sub_property_ids as $sub_property_id) {
                                                    $sql = $pdo->prepare("SELECT id FROM units WHERE sub_property_id = :sub_property_id AND temp_del = 0");
                                                    $sql->bindParam(":sub_property_id", $sub_property_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        $unit_ids[] = $data['id'];
                                                    }
                                                }

                                                
                                                foreach($unit_ids as $unit_id) {
                                                    $sql = $pdo->prepare("SELECT t.id, status, last_login, t.tenant_id, lastname, middlename, firstname, relationship_to_owner, social_status, nationality, ut.unit_id FROM tenants t LEFT JOIN countries ON citizenship_id = num_code LEFT JOIN unit_tenants ut ON(ut.tenant_id = t.id) WHERE ut.unit_id = :unit_id AND t.temp_del = 0 ORDER BY tenant_id ASC");
                                                    $sql->bindParam(":unit_id", $unit_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        $data_count++;
                                                        $id = $data['id'];

                                                        echo '<tr>';

                                                            // tenant ID
                                                            echo '<td><a href="/tenant/'.$data['id'].'">'.$data['tenant_id'].'</a></td>';

                                                            // LAST NAME
                                                            echo '<td>'.$data['lastname'].'</td>';

                                                            // FIRST NAME
                                                            echo '<td>'.$data['firstname'].'</td>';

                                                            // MIDDLE NAME
                                                            echo '<td>'.$data['middlename'].'</td>';

                                                            // CITIZENSHIP
                                                            echo '<td>'.$data['nationality'].'</td>';

                                                            // RELATION TO OWNER
                                                            echo '<td>'.renderLang($relationship_to_owner_arr[$data['relationship_to_owner']]).'</td>';
                                                        
                                                            // PROPERTIES
                                                            echo '<td>';
                                                                if(checkVar($data['unit_id'])) {
                                                                    $sub_property_id = getField('sub_property_id', 'units', 'id = '.$data['unit_id']);
                                                                    $property_id = getField('property_id', 'units', 'id = '.$data['unit_id']);
                                                                    $unit_name = getField('unit_name', 'units', 'id = '.$data['unit_id']);
                                                                    if(checkVar($unit_name)) {
        
                                                                        $property_name = getField('property_name', 'properties', 'id = '.$property_id);
                                                                        $sub_property_name = getField('sub_property_name', 'sub_properties', 'id = '.$sub_property_id);
                                                                        echo $unit_name.', '.$sub_property_name.', '.$property_name;
                                                                        
                                                                    }
                                                                }
                                                            echo '</td>';

                                                            // STATUS
                                                            echo '<td>';
                                                                foreach($status_arr as $status) {
                                                                    if($status[0] == $data['status']) {
                                                                        switch($data['status']) {
                                                                            case 0:
                                                                                echo '<span class="text-success">'.renderLang($status[1]).'</span>';
                                                                                break;
                                                                            case 1:
                                                                                echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
                                                                                break;
                                                                        }
                                                                    }
                                                                }
                                                            echo '</td>';

                                                            // LAST LOGIN
                                                            echo '<td>';
                                                                if($data['last_login'] > 0) {
                                                                    echo date('Ymd',$data['last_login']).' &middot; '.date('H:i:s',$data['last_login']);
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            echo '</td>';

                                                            // EDIT tenant
                                                            if(checkPermission('tenant-edit')) {
                                                                echo '<td>';
                                                                        echo '<a href="/edit-tenant/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($tenants_edit_tenant).'"><i class="fa fa-pencil-alt"></i></a>';
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
							</div><!-- table-responsive -->
							
						</div>
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
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