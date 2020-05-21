<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prospecting')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'prospecting';
		
		// set fields from table to search on
		$fields_arr = array('client_id','client_name','contact_person');
		$search_placeholder = renderLang($clients_client_id).', '.renderLang($clients_client_name).', '.renderLang($clients_contact_person);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$sql_query = 'SELECT * FROM clients'.$where; // set sql statement
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');

		$propect_category = $_GET['id'];
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prospecting); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
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
							<h1><i class="fa fa-binoculars mr-3"></i><?php echo renderLang($prospecting); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<span class="text-uppercase"><?php echo renderLang($prospecting_category_arr[$propect_category]); ?></span>
							</h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_prospecting_err');
					renderSuccess('sys_prospecting_add_suc');
					renderSuccess('sys_prospecting_edit_suc');
					?>
					
					<div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($prospect_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('prospecting-add')) { ?><a href="/add-prospecting-<?php echo renderLang($prospecting_category_arr[$propect_category]); ?>" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($prospecting_new_leads); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

                            <?php // require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-prospecting.php'); ?>

                            <!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="data-table" class="table table-hover table-bordered">
									<thead>
										<tr>
											<th><?php echo renderLang($prospecting_reference_number); ?></th>
                                            <th><?php echo renderLang($prospecting_name_company); ?></th>
                                            <th><?php echo renderlang($prospecting_service_required); ?></th>
											<th><?php echo renderLang($prospecting_action_plan); ?></th>
											<th><?php echo renderLang($prospecting_source); ?></th>
                                            <th><?php echo renderLang($prospecting_referred_by); ?></th>
											<th><?php echo renderLang($prospecting_date); ?></th>
											<th><?php echo renderLang($prospecting_status); ?></th>
											<?php if(checkPermission('prospecting-edit')) { ?>
											<th class="w35 p-0"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody id="table-data">
                                    <?php
                                    $esd_where = ''; 
                                    if($propect_category == 1) {
                                        if($_SESSION['sys_account_mode'] == 'employee') {
                                            $esd_where = "AND created_by = ".$_SESSION['sys_id'].' AND account_mode = "'.$_SESSION['sys_account_mode'].'"';
                                        }
                                    }
                                    $sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status <> 3 AND prospecting_category = :prospecting_category $esd_where ORDER BY reference_number DESC");
                                    $sql->bindParam(":prospecting_category", $propect_category);
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        
                                        echo '<tr>';

                                        echo '<td><a href="/prospect-activities/'.$data['id'].'">'.$data['reference_number'].'</a></td>';
                                        echo '<td>'.$data['project_name'].'</td>';
                                        
                                        if($propect_category == 0) {
                                            echo '<td>'.renderLang($prospecting_service_required_arr[$data['service_required']]).'</td>';
                                        } else {
                                            echo '<td>'.renderLang($prospecting_esd_service_required_arr[$data['service_required']]).'</td>';
                                        }
                                        
                                        echo '<td>';
                                        $sql1 = $pdo->prepare("SELECT id, activity_category, activity_status FROM prospecting_activities WHERE prospect_id = :id ORDER BY id DESC");
                                        $sql1->bindParam(":id", $data['id']);
                                        $sql1->execute();
                                        if($sql1->rowCount()) {

                                            $done = array();

                                            $data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                                            echo '<a href="" class="activity" data-id="'.$data['id'].'">'.renderLang($prospect_activity_arr[$data1['activity_category']]).'</a>';

                                        } else {
                                            echo renderLang($prospecting_no_activities_yet);
                                        }

                                        echo '</td>';
                                        echo '<td>'.renderLang($prospecting_lead_received_through_arr[$data['lead_received_through']]).'</td>';
                                        echo '<td>'.$data['referred_by'].'</td>';
                                        echo '<td>'.date('Y-m-d', $data['date']).'</td>';
                                        echo '<td>';
                                            if($data['status'] == 2 || $data['status'] == 4) {
                                                echo '<a href="" class="declined" data-remarks="'.$data['declined_remarks'].'">'.renderLang($prospect_status_arr[$data['status']]).'</a>';
                                            } else {
                                               echo renderLang($prospect_status_arr[$data['status']]);
                                            }
                                        echo '</td>';

                                        if(checkPermission('prospecting-edit')) {
                                        echo '<td><a href="/edit-prospecting/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($prospecting_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';
                                        }

                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
							</div><!-- table-responsive -->

							<div class="row">
								<div class="col-12">
									<p>
										<?php 
										foreach($prospect_status_arr as $key => $status) {
											$count = getField("count(id)", "prospecting", "status = ".$key." AND temp_del = 0 AND prospecting_category = ".$propect_category);
											echo renderLang($status).':<span class="ml-2 mr-2 font-weight-bold">'.$count.'</span>';
										}
										?>
									</p>
								</div>
							</div>

                        </div>
                        <div class="card-footer text-right">
								<a href="/prospecting-departments" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
							</div>
					</div><!-- card -->

					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
    </div><!-- wrapper -->
    
    <!-- MODAL -->
    <!-- activities -->
	<div class="modal fade" id="modal-activities">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($prospecting_activities); ?></h4>
				</div>
                <div class="modal-body">

                    <div id="datas"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_close); ?></button>
                </div>
			</div>
		</div>
	</div><!-- modal -->

    <!-- remarks -->
    <div class="modal fade" id="modal-declined-remarks">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($prospecting_declined_remarks); ?></h4>
				</div>
                <div class="modal-body">

                    <p class="text-justify" id="declined-remarks"></p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_close); ?></button>
                </div>
			</div>
		</div>
	</div><!-- modal -->

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
    $(function(){

        $('#data-table').DataTable({
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

        $('#table-data').on('click', '.activity', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            $.post('/load-prospect-activities', {
                id:id
            }, function(data){
                $('#datas').html(data);
                $('#modal-activities').modal('show');
            });

        });

        // declined remarks
        $('#table-data').on('click', '.declined', function(e){
            e.preventDefault();

            var remarks = $(this).data('remarks');

            $('#modal-declined-remarks').find('#declined-remarks').html(remarks);

            $('#modal-declined-remarks').modal('show');

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