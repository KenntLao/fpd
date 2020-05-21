<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('occupants')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'occupants';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($occupants_occupants); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fa fa-users mr-3"></i><?php echo renderLang($occupants_occupants); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php 
					renderSuccess('sys_occupants_suc');
					renderError('sys_occupants_err');
					renderSuccess('sys_occupants_edit_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($occupants_occupants_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('occupant-add')) { ?><a href="/add-occupant" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($occupants_add_occupant); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped" id="table-data">
									<thead>
										<tr>
											<th><?php echo renderLang($occupants_lastname); ?></th>
											<th><?php echo renderLang($occupants_firstname); ?></th>
											<th><?php echo renderLang($occupants_gender); ?></th>
											<th><?php echo renderLang($occupants_birthdate); ?></th>
											<th class="text-center"><?php echo renderLang($occupants_age); ?></th>
											<th><?php echo renderLang($lang_citizenship_global); ?></th>
											<th><?php echo renderLang($occupants_relationship_to_tenant); ?></th>
											<th><?php echo renderLang($units_unit); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<?php if(checkPermission('occupant-edit')) { ?>
											<th style="width:35px;"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
                                        if($_SESSION['sys_account_mode'] == 'user') {

                                            $sql = $pdo->prepare("SELECT o.id, o.firstname, o.lastname, o.gender, o.birthdate, o.unit_id, o.relationship_to_tenant, o.status, c.nationality FROM occupants o LEFT JOIN countries c ON o.citizenship_id = c.num_code ORDER BY lastname ASC");
                                            $sql->execute();
                                            $data_count = $sql->rowCount();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $sql2 = $pdo->prepare("SELECT
                                                    *,
                                                    units.id AS unit_id
                                                    FROM units
                                                    LEFT JOIN sub_properties ON units.sub_property_id = sub_properties.id
                                                    LEFT JOIN properties ON units.property_id = properties.id
                                                    WHERE units.temp_del = 0 AND units.id = :unit_id");
                                                $sql2->bindParam(":unit_id", $data['unit_id']);
                                                $sql2->execute();
                                                $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                                                echo '<tr>';
                                                
                                                    // name
                                                    echo '<td><a href="/occupant/'.$data['id'].'">'.$data['lastname'].'</a></td>';
                                                    echo '<td><a href="/occupant/'.$data['id'].'">'.$data['firstname'].'</a></td>';
                                                
                                                    // gender
                                                    echo '<td>';
                                                    foreach ($gender_arr as $gender) {
                                                        if($gender[0] == $data['gender']) {
                                                            echo renderLang($gender[1]);
                                                        }
                                                    }
                                                    echo '</td>';
                                                
                                                    // birthdate
                                                    echo '<td>'.formatDate($data['birthdate']).'</td>';
                                                
                                                    // age
                                                    $age = 0;
                                                    $curr_date = time();
                                                    $birthdate = strtotime($data['birthdate']);
                                                    $age = $curr_date - $birthdate;
                                                    $age = floor($age / (365*60*60*24));
                                                    echo '<td class="text-center">'.$age.'</td>';

                                                    // CITIZENSHIP
                                                    echo '<td>'.$data['nationality'].'</td>';

                                                    // RELATION TO TENANTS
                                                    echo '<td>'.(!empty($data['relationship_to_tenant']) ? renderLang($relationship_to_tenant_arr[$data['relationship_to_tenant']]) : '' ).'</td>';

                                                    // UNIT
                                                    echo '<td>';
                                                        if($data['unit_id'] != 0) {
                                                            echo '<a href="/unit/'.$data2['unit_id'].'">'.$data2['unit_name'].' '.$data2['sub_property_name'].', '.$data2['property_name'].'</a>';
                                                        } else {
                                                            echo '<small>TBD</small>';
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
                                                
                                                    // EDIT
                                                    if(checkPermission('occupant-edit')) {
                                                        echo '<td>';
                                                            echo '<a href="/edit-occupant/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($occupants_edit_occupant).'"><i class="fa fa-pencil-alt"></i></a>';
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

                                                    $sql = $pdo->prepare("SELECT o.id, o.firstname, o.lastname, o.gender, o.birthdate, o.unit_id, o.relationship_to_tenant, o.status, c.nationality FROM occupants o LEFT JOIN countries c ON o.citizenship_id = c.num_code WHERE unit_id = :unit_id ORDER BY lastname ASC");
                                                    $sql->bindParam(":unit_id", $unit_id);
                                                    $sql->execute();
                                                    $data_count = $sql->rowCount();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        $sql2 = $pdo->prepare("SELECT
                                                            *,
                                                            units.id AS unit_id
                                                            FROM units
                                                            LEFT JOIN sub_properties ON units.sub_property_id = sub_properties.id
                                                            LEFT JOIN properties ON units.property_id = properties.id
                                                            WHERE units.temp_del = 0 AND units.id = :unit_id");
                                                        $sql2->bindParam(":unit_id", $data['unit_id']);
                                                        $sql2->execute();
                                                        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                                                        echo '<tr>';
                                                        
                                                            // name
                                                            echo '<td><a href="/occupant/'.$data['id'].'">'.$data['lastname'].'</a></td>';
                                                            echo '<td><a href="/occupant/'.$data['id'].'">'.$data['firstname'].'</a></td>';
                                                        
                                                            // gender
                                                            echo '<td>';
                                                            foreach ($gender_arr as $gender) {
                                                                if($gender[0] == $data['gender']) {
                                                                    echo renderLang($gender[1]);
                                                                }
                                                            }
                                                            echo '</td>';
                                                        
                                                            // birthdate
                                                            echo '<td>'.formatDate($data['birthdate']).'</td>';
                                                        
                                                            // age
                                                            $age = 0;
                                                            $curr_date = time();
                                                            $birthdate = strtotime($data['birthdate']);
                                                            $age = $curr_date - $birthdate;
                                                            $age = floor($age / (365*60*60*24));
                                                            echo '<td class="text-center">'.$age.'</td>';

                                                            // CITIZENSHIP
                                                            echo '<td>'.$data['nationality'].'</td>';

                                                            // RELATION TO TENANTS
                                                            echo '<td>'.renderLang($relationship_to_tenant_arr[$data['relationship_to_tenant']]).'</td>';

                                                            // UNIT
                                                            echo '<td>';
                                                                if($data['unit_id'] != 0) {
                                                                    echo '<a href="/unit/'.$data2['unit_id'].'">'.$data2['unit_name'].' '.$data2['sub_property_name'].', '.$data2['property_name'].'</a>';
                                                                } else {
                                                                    echo '<small>TBD</small>';
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
                                                        
                                                            // EDIT
                                                            if(checkPermission('occupant-edit')) {
                                                                echo '<td>';
                                                                    echo '<a href="/edit-occupant/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($occupants_edit_occupant).'"><i class="fa fa-pencil-alt"></i></a>';
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

                                                    $sql = $pdo->prepare("SELECT o.id, o.firstname, o.lastname, o.gender, o.birthdate, o.unit_id, o.relationship_to_tenant, o.status, c.nationality FROM occupants o LEFT JOIN countries c ON o.citizenship_id = c.num_code WHERE unit_id = :unit_id ORDER BY lastname ASC");
                                                    $sql->bindParam(":unit_id", $unit_id);
                                                    $sql->execute();
                                                    $data_count = $sql->rowCount();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        $sql2 = $pdo->prepare("SELECT
                                                            *,
                                                            units.id AS unit_id
                                                            FROM units
                                                            LEFT JOIN sub_properties ON units.sub_property_id = sub_properties.id
                                                            LEFT JOIN properties ON units.property_id = properties.id
                                                            WHERE units.temp_del = 0 AND units.id = :unit_id");
                                                        $sql2->bindParam(":unit_id", $data['unit_id']);
                                                        $sql2->execute();
                                                        $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                                                        echo '<tr>';
                                                        
                                                            // name
                                                            echo '<td><a href="/occupant/'.$data['id'].'">'.$data['lastname'].'</a></td>';
                                                            echo '<td><a href="/occupant/'.$data['id'].'">'.$data['firstname'].'</a></td>';
                                                        
                                                            // gender
                                                            echo '<td>';
                                                            foreach ($gender_arr as $gender) {
                                                                if($gender[0] == $data['gender']) {
                                                                    echo renderLang($gender[1]);
                                                                }
                                                            }
                                                            echo '</td>';
                                                        
                                                            // birthdate
                                                            echo '<td>'.formatDate($data['birthdate']).'</td>';
                                                        
                                                            // age
                                                            $age = 0;
                                                            $curr_date = time();
                                                            $birthdate = strtotime($data['birthdate']);
                                                            $age = $curr_date - $birthdate;
                                                            $age = floor($age / (365*60*60*24));
                                                            echo '<td class="text-center">'.$age.'</td>';

                                                            // CITIZENSHIP
                                                            echo '<td>'.$data['nationality'].'</td>';

                                                            // RELATION TO TENANTS
                                                            echo '<td>'.renderLang($relationship_to_tenant_arr[$data['relationship_to_tenant']]).'</td>';

                                                            // UNIT
                                                            echo '<td>';
                                                                if($data['unit_id'] != 0) {
                                                                    echo '<a href="/unit/'.$data2['unit_id'].'">'.$data2['unit_name'].' '.$data2['sub_property_name'].', '.$data2['property_name'].'</a>';
                                                                } else {
                                                                    echo '<small>TBD</small>';
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
                                                        
                                                            // EDIT
                                                            if(checkPermission('occupant-edit')) {
                                                                echo '<td>';
                                                                    echo '<a href="/edit-occupant/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($occupants_edit_occupant).'"><i class="fa fa-pencil-alt"></i></a>';
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