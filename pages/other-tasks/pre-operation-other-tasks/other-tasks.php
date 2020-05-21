<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-other-tasks')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'pre-operation-other-tasks';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($po_other_task); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-th mr-3"></i><?php echo renderLang($po_other_task); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_po_other_task_edit_suc');
					renderSuccess('sys_po_other_task_add_suc');
					renderSuccess('sys_other_task_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($po_other_task_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('pre-operation-other-task-add')) { ?><a href="/add-pre-operation-other-task " class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($po_new_other_task); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($po_other_task_title); ?></th>
											<th><?php echo renderLang($po_other_task_department); ?></th>
											<th><?php echo renderLang($po_other_task_action_plan); ?></th>
											<th><?php echo renderLang($po_other_task_incharge); ?></th>
											<th><?php echo renderLang($downpayment_attachment); ?></th>
											<th><?php echo renderLang($po_other_task_date); ?></th>
											<th><?php echo renderLang($po_other_task_status); ?></th>
											<?php if (checkPermission('pre-operation-other-task-edit')) {?>
											<th class="w35"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
                                        if($_SESSION['sys_account_mode'] == "user") {

                                            $sql = $pdo->prepare("SELECT ot.attachment, ot.incharges, ot.id, title, ot.date, ot.status, d.department_code, d.department_name, created_by, account_mode FROM other_tasks ot LEFT JOIN departments d ON (ot.department_id = d.id) WHERE ot.temp_del = 0 ORDER BY ot.id ASC");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $employee_ids = explode(',', $data['incharges']);

                                                echo '<tr>';
    
                                                    // TITLE
                                                    echo '<td><a href="/add-activities-pre-operation-other-task/'.$data['id'].'">'.$data['title'].'</td>';
    
                                                    // PROJECT NAME
                                                    echo '<td>['.$data['department_code'].']'.$data['department_name'].'</td>';
    
                                                    // ACTIVITY
                                                    echo '<td><a href="" class="activity" data-id="'.$data['id'].'">Activities</a></td>';
    
                                                    // INCHARGES
                                                    echo '<td>';
                                                        foreach($employee_ids as $employee_id) {
    
                                                            $sql1 = $pdo->prepare("SELECT employee_id, firstname, lastname, id FROM employees WHERE id = :id AND temp_del = 0 LIMIT 1");
                                                            $sql1->bindParam(":id", $employee_id);
                                                            $sql1->execute();
                                                            $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                                            if($sql1->rowCount()) {
                                                                echo '<a href="/employee/'.$data1['id'].'">['.$data1['employee_id'].'] '.$data1['firstname'].' '.$data1['lastname'].'</a> <br>';
                                                            } else {
                                                                echo 'N/A';
                                                            }
    
    
                                                        }
                                                    echo '</td>';
    
                                                    // ATTACHMENT
                                                    echo '<td>';
                                                        renderAttachments($data['attachment'], 'other-task');
                                                    echo '</td>';
    
                                                    // DATE
                                                    echo '<td>'.formatDate($data['date'], true, false, false).'</td>';
    
                                                    // PROJECT NAME
                                                    echo '<td>'.renderLang($other_task_status_arr[$data['status']]).'</td>';
    
                                                    if (checkPermission('pre-operation-other-task-edit')) {
    
                                                        echo '<td><a href="/edit-pre-operation-other-task/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($op_other_task_edit_other_task).'"><i class="fa fa-pencil-alt"></i></></td>';
                                                    }
                                                    
                                                echo '</tr>';

                                            }

                                        } else {

                                            $sql = $pdo->prepare("SELECT ot.attachment, ot.incharges, ot.id, title, ot.date, ot.status, d.department_code, d.department_name, created_by, account_mode FROM other_tasks ot LEFT JOIN departments d ON (ot.department_id = d.id) WHERE ot.temp_del = 0 ORDER BY ot.id ASC");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $employee_ids = explode(',', $data['incharges']);
                                                $created_by = $data['created_by'];
                                                $account_mode = $data['account_mode'];
                                                $if_creator = $created_by == $_SESSION['sys_id'] && $account_mode == $_SESSION['sys_account_mode'] ? 1 : 0;

                                                if($if_creator || in_array($_SESSION['sys_id'], $employee_ids)) {
                                                    
                                                    echo '<tr>';
        
                                                        // TITLE
                                                        echo '<td><a href="/add-activities-pre-operation-other-task/'.$data['id'].'">'.$data['title'].'</td>';
        
                                                        // PROJECT NAME
                                                        echo '<td>['.$data['department_code'].']'.$data['department_name'].'</td>';
        
                                                        // ACTIVITY
                                                        echo '<td><a href="" class="activity" data-id="'.$data['id'].'">Activities</a></td>';
        
                                                        // INCHARGES
                                                        echo '<td>';
                                                            foreach($employee_ids as $employee_id) {
        
                                                                $sql1 = $pdo->prepare("SELECT employee_id, firstname, lastname, id FROM employees WHERE id = :id AND temp_del = 0 LIMIT 1");
                                                                $sql1->bindParam(":id", $employee_id);
                                                                $sql1->execute();
                                                                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                                                if($sql1->rowCount()) {
                                                                    echo '<a href="/employee/'.$data1['id'].'">['.$data1['employee_id'].'] '.$data1['firstname'].' '.$data1['lastname'].'</a> <br>';
                                                                } else {
                                                                    echo 'N/A';
                                                                }
        
        
                                                            }
                                                        echo '</td>';
        
                                                        // ATTACHMENT
                                                        echo '<td>';
                                                            renderAttachments($data['attachment'], 'other-task');
                                                        echo '</td>';
        
                                                        // DATE
                                                        echo '<td>'.formatDate($data['date'], true, false, false).'</td>';
        
                                                        // PROJECT NAME
                                                        echo '<td>'.renderLang($other_task_status_arr[$data['status']]).'</td>';
        
                                                        if (checkPermission('pre-operation-other-task-edit')) {
        
                                                            echo '<td><a href="/edit-pre-operation-other-task/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($op_other_task_edit_other_task).'"><i class="fa fa-pencil-alt"></i></></td>';
                                                        }
                                                        
                                                    echo '</tr>';

                                                }

                                            }

                                        }
										?>
									</tbody>
							
								</table>
							</div><!-- table-responsive -->
						</div><!-- card body -->
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- MODAL -->
	    <!-- activities -->
		<div class="modal fade" id="modal-activities">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-danger">
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

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
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

        // remove sorting in column
        $('.no-sort').each(function(){
            $(this).removeClass('sorting');
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

            $.post('/load-other-task-activities', {
                id:id
            }, function(data){
                $('#datas').html(data);
                $('#modal-activities').modal('show');
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