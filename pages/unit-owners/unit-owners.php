<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unit-owners')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'unit-owners';
        // page url
        $page_href = "unit-owners";

        $fields_arr = array('unit_owner_id','firstname','middlename','lastname'); // fields to search
        $search_placeholder = renderLang($unit_owners_unit_owner_id).', '.renderLang($unit_owners_lastname).', '.renderLang($unit_owners_firstname).', '.renderLang($unit_owners_middlename); // search placeholder
        // set search
        include($_SERVER['DOCUMENT_ROOT']."/includes/common/search-config.php");
        
        // get total row
        $total_row = 0; 
        if($_SESSION['sys_account_mode'] == 'user') { // users
            $total_row = getField('count(id)', 'unit_owners', 'temp_del = 0 '.$where);
        } else { // employees
            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

            // get unit all unit owner id under sub property
            $unit_owner_ids = array();
            foreach($sub_property_ids as $sub_property_id) {
                $sql = $pdo->prepare("SELECT unit_owner_id FROM units WHERE sub_property_id = :sub_property_id AND temp_del = 0");
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->execute();
                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $unit_owner_ids[] = $data['unit_owner_id'];
                }
            }
            $unit_owners = '';
            if(!empty($unit_owner_ids)) {
                $unit_owners = implode(", ", $unit_owner_ids);
            }

            $sql = $pdo->prepare("SELECT count(id) FROM unit_owners u LEFT JOIN countries c ON citizenship_id = c.num_code WHERE u.id IN($unit_owners) $where ORDER BY unit_owner_id ASC");
            $sql->bindParam(":unit_owner_id", $unit_owner_id);
            $sql->execute();
            if($sql->rowCount()) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $total_row = $data['count(id)'];
            }
        }
        // set pagination
        include($_SERVER['DOCUMENT_ROOT']."/includes/common/pagination-config.php");
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($unit_owners_unit_owners); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-user-circle mr-3"></i><?php echo renderLang($unit_owners_unit_owners); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_unit_owners_err');
					renderSuccess('sys_unit_owners_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($unit_owners_unit_owners_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('unit-owner-add')) { ?>
								<!-- <button class="btn btn-success text-white" id="import"><i class="fa fa-download mr-1"></i><?php echo renderLang($lang_import); ?></button> -->
								<a href="/add-unit-owner" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($unit_owners_add_unit_owner); ?></a>
								<?php } ?>
							</div>
						</div>
						<div class="card-body">

                            <?php include($_SERVER['DOCUMENT_ROOT']."/includes/common/search-filter.php"); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover with-options" id="table-data">
									<thead>
										<tr>
											<th><?php echo renderLang($unit_owners_unit_owner_id); ?></th>
											<th><?php echo renderLang($unit_owners_lastname); ?></th>
											<th><?php echo renderLang($unit_owners_firstname); ?></th>
											<th><?php echo renderLang($unit_owners_middlename); ?></th>
											<th><?php echo renderLang($lang_citizenship_global); ?></th>
											<th><?php echo renderLang($units_units); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<th class="w150"><?php echo renderLang($unit_owners_last_login); ?></th>
											<?php if(checkPermission('unit-owner-edit')) { ?>
											<th class="w35 p-0"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
                                        $data_count = 0;
                                        $count = 0;
                                        if($_SESSION['sys_account_mode'] == 'user') {

                                            $sql = $pdo->prepare("SELECT id, firstname, middlename, lastname, gender, birthdate, status, nationality, last_login, unit_owner_id FROM unit_owners u LEFT JOIN countries c ON citizenship_id = c.num_code WHERE u.temp_del = 0 $where ORDER BY unit_owner_id ASC LIMIT ".$qry_start.", ".$qry_limit);
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $data_count++;
                                                $id = $data['id'];

                                                echo '<tr>';

                                                    // unit_owner ID
                                                    echo '<td><a href="/unit-owner/'.$data['id'].'">'.$data['unit_owner_id'].'</a></td>';

                                                    // LAST NAME
                                                    echo '<td>'.$data['lastname'].'</td>';

                                                    // FIRST NAME
                                                    echo '<td>'.$data['firstname'].'</td>';

                                                    // MIDDLE NAME
                                                    echo '<td>'.$data['middlename'].'</td>';

                                                    // CITIZENSHIP
                                                    echo '<td>'.$data['nationality'].'</td>';
                                                
                                                    // UNITS
                                                    echo '<td>';
                                                        $sql2 = $pdo->prepare("SELECT
                                                        *
                                                        FROM units
                                                        LEFT JOIN properties ON units.property_id = properties.id
                                                        LEFT JOIN sub_properties ON units.sub_property_id = sub_properties.id
                                                        WHERE unit_owner_id = ".$id."
                                                        ORDER BY units.property_id ASC, units.sub_property_id ASC, unit_name ASC
                                                        ");
                                                        $sql2->execute();
                                                        while($_data = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                            echo $_data['unit_name'].' '.$_data['sub_property_name'].', '.$_data['property_name'].'<br>';
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

                                                    // OPTIONS
                                                    if(checkPermission('unit-owner-edit')) {
                                                        echo '<td>';

                                                            // EDIT unit_owner
                                                            if(checkPermission('unit-owner-edit')) {
                                                                echo '<a href="/edit-unit-owner/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($unit_owners_edit_unit_owner).'"><i class="fa fa-pencil-alt"></i></a>';
                                                            }

                                                        echo '</td>'; // end options
                                                    }

                                                echo '</tr>';
                                            }

                                        } else { // employee

                                            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                                            // get unit all unit owner id under sub property
                                            $unit_owner_ids = array();
                                            foreach($sub_property_ids as $sub_property_id) {
                                                $sql = $pdo->prepare("SELECT unit_owner_id FROM units WHERE sub_property_id = :sub_property_id AND temp_del = 0");
                                                $sql->bindParam(":sub_property_id", $sub_property_id);
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    $unit_owner_ids[] = $data['unit_owner_id'];
                                                }
                                            }

                                            $unit_owners = '';
                                            if(!empty($unit_owner_ids)) {
                                                $unit_owners = implode(", ", $unit_owner_ids);
                                            }
                                                
                                            $sql = $pdo->prepare("SELECT u.id, firstname, middlename, lastname, gender, birthdate, status, nationality, last_login, unit_owner_id FROM unit_owners u LEFT JOIN countries c ON citizenship_id = c.num_code WHERE u.id IN ($unit_owners) AND u.temp_del = 0 $where ORDER BY unit_owner_id ASC LIMIT ".$qry_start.", ".$qry_limit);
                                            $sql->bindParam(":unit_owner_id", $unit_owner_id);
                                            $sql->execute();
                                            if($sql->rowCount()) {

                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    $data_count++;
                                                    $id = $data['id'];
    
                                                    echo '<tr>';

                                                        // unit_owner ID
                                                        echo '<td><a href="/unit-owner/'.$data['id'].'">'.$data['unit_owner_id'].'</a></td>';

                                                        // LAST NAME
                                                        echo '<td>'.$data['lastname'].'</td>';

                                                        // FIRST NAME
                                                        echo '<td>'.$data['firstname'].'</td>';

                                                        // MIDDLE NAME
                                                        echo '<td>'.$data['middlename'].'</td>';

                                                        // CITIZENSHIP
                                                        echo '<td>'.$data['nationality'].'</td>';
                                                    
                                                        // UNITS
                                                        echo '<td>';
                                                            $sql2 = $pdo->prepare("SELECT
                                                            *
                                                            FROM units
                                                            LEFT JOIN properties ON units.property_id = properties.id
                                                            LEFT JOIN sub_properties ON units.sub_property_id = sub_properties.id
                                                            WHERE unit_owner_id = ".$id."
                                                            ORDER BY units.property_id ASC, units.sub_property_id ASC, unit_name ASC
                                                            ");
                                                            $sql2->execute();
                                                            while($_data = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                                echo $_data['unit_name'].' '.$_data['sub_property_name'].', '.$_data['property_name'].'<br>';
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

                                                        // OPTIONS
                                                        if(checkPermission('unit-owner-edit')) {
                                                            echo '<td>';

                                                                // EDIT unit_owner
                                                                if(checkPermission('unit-owner-edit')) {
                                                                    echo '<a href="/edit-unit-owner/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($unit_owners_edit_unit_owner).'"><i class="fa fa-pencil-alt"></i></a>';
                                                                }

                                                            echo '</td>'; // end options
                                                        }

                                                    echo '</tr>';
                                                        
                                                }
                                            }

                                        }
										?>
									</tbody>
								</table>
							</div><!-- table-responsive -->

                            <?php include($_SERVER['DOCUMENT_ROOT']."/includes/common/pagination.php"); ?>
							
						</div>
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <!-- MODALS -->
	<!-- import -->
	<div class="modal fade" id="modal-import">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($lang_import); ?></h4>
				</div>
				<form action="/import-unit-owners" method="post" id="form_import">
					<div class="modal-body">
                        
                        <div class="row">

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for=""><?php echo renderLang($lang_excel_file); ?></label>
                                    <input type="file" name="unit_owner_file" accept=".csv" class="form-control" required>
                                    <small class="text-muted">Please upload file with .csv format only.</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <small>The format of the csv file should be:</small>
                                <p>firstname | middlename | lastname | gender | civil status | birthdate | citizenship</p>
                            </div>

                        </div>
                        <div class="form-alert"></div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button class="btn btn-primary"><i class="fa fa-check mr-2"></i><?php echo renderLang($lang_import); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
        $(function(){

            $('#table-data').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
            });

            $('#import').on('click', function(e){
                e.preventDefault();

                $('#modal-import').modal('show');

            });

            $('#form_import').on('submit', function(e){
                e.preventDefault();

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(response){
						if(response == 'success') {
                            window.location.reload();
                        } else if(response == 'error') {
                            $('#form-alert').html('');
                        }

                        alert(response);
					}
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