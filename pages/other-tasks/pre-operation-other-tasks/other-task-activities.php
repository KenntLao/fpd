
<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-other-tasks')) {

		// set page
		$page = 'pre-operation-other-tasks';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT ot.id, title, department_code, department_name FROM other_tasks ot JOIN departments d ON (ot.department_id = d.id) WHERE ot.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);

        $ot_id = $_data['id'];
        
        $err = 0;

		$current_date = date('Y-m-d');

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($po_other_task_activity); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>

    <style>
    .table-data tr td {
        padding: 0px;
    }
    </style>
	
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
                                <i class="fas fa-th mr-3"></i><?php echo renderLang($po_other_task_activity); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['department_code']; ?>
                               	<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['title']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<form method="post" action="/submit-add-activities-pre-operation-other-task" enctype="multipart/form-data">

						<input type="hidden" name="id" value="<?php echo $ot_id; ?>">
					
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($po_other_task_activity_form); ?></h3>
							</div>
							<div class="card-body">

                            	<div class="table-responsive">
                                    <div class="text-right mb-2">
                                        <button data-code="OT" class="btn btn-info add-row" type="button"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
	                                        <th><?php echo renderLang($po_other_task_date); ?></th>
	                                        <th><?php echo renderLang($po_other_task_remarks); ?></th>
											<th><?php echo renderLang($other_task_action_taken); ?></th>
                                            <th></th>
	                                        <th><?php echo renderLang($po_other_task_timeline); ?></th>
											<th><?php echo renderLang($downpayment_attachment); ?></th>
                                    	</thead>
	                                    <tbody class="table-data">
	                                        <?php 
                                                $sql = $pdo->prepare("SELECT * FROM other_task_activities WHERE other_task_id = :id ORDER BY id DESC");
                                                $sql->bindParam(":id", $ot_id);
                                                $sql->execute();
                                                $act_num = 1;
                                                $act_count = $sql->rowCount() ? $sql->rowCount() : 0;
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

													$if_editable = formatDate($current_date) == formatDate($data['date']) ? 1 : 0;
                                                                
                                                    echo '<tr>';

                                                        echo '<input type="hidden" name="ot_id[]" value="'.$data['id'].'">';

                                                        // date
                                                        echo '<td>';
                                                            echo '<input type="text" class="form-control border-0 input-readonly" name="OT_date[]" value="'.formatDate($data['date']).'" readonly>';
                                                        echo '</td>';

                                                        // remarks
                                                        echo '<td>';
                                                            if(checkVar($data['remarks_by'])) {
                                                                $can_edit_remarks = 0;

                                                                // check if the same user
                                                                if($data['remarks_by'] == $_SESSION['sys_id'] && $data['remarks_by_account_mode'] == $_SESSION['sys_account_mode']) {
                                                                    $can_edit_remarks = 1;
                                                                }

                                                            } else {
                                                                $can_edit_remarks = 1;
                                                            }
                                                            echo '<textarea name="OT_remarks[]" rows="2" class="form-control notes border-0" '.($if_editable ? $can_edit_remarks ? '' : 'readonly' : 'readonly').'>'.$data['remarks'].'</textarea>';
                                                            echo '<span>';
                                                                if(checkVar($data['remarks_by_account_mode']) && $data['remarks_by_account_mode'] == 'employee') {
                                                                    $name = getField('code_name', 'employees', 'id = '.$data['remarks_by']);
                                                                    $name = checkVar($name) ? $name : getFullName($data['remarks_by'], 'employee');
                                                                    echo '- '.$name;
                                                                } else if(checkVar($data['remarks_by_account_mode']) && $data['remarks_by_account_mode'] == 'user') {
                                                                    $name = getFullName($data['remarks_by'], 'user');
                                                                    echo '- '.$name;
                                                                }
                                                            echo '</span>';
                                                        echo '</td>';
                                                        
                                                        // action taken
                                                        echo '<td>';
                                                            if(checkVar($data['action_taken_by_account_mode'])) {

                                                                $can_edit = 0;

                                                                if($data['action_taken_by_account_mode'] == $_SESSION['sys_account_mode'] && $data['action_taken_by'] == $_SESSION['sys_id']) {
                                                                    $can_edit = 1;
                                                                }

                                                            } else {

                                                                $can_edit = 1;

                                                            }
                                                            echo '<textarea name="action_taken" class="form-control notes border-0 '.($can_edit ? 'action-taken' : '').'" readonly data-id="'.$data['id'].'">'.$data['action_taken'].'</textarea>';
                                                            echo '<span>';
                                                                if(checkVar($data['action_taken_by_account_mode']) && $data['action_taken_by_account_mode'] == 'employee') {
                                                                    $name = getField('code_name', 'employees', 'id = '.$data['action_taken_by']);
                                                                    $name = checkVar($name) ? $name : getFullName($data['action_taken_by'], 'employee');
                                                                    echo '- '.$name;
                                                                } else if(checkVar($data['action_taken_by_account_mode']) && $data['action_taken_by_account_mode'] == 'user') {
                                                                    $name = getFullName($data['action_taken_by'], 'user');
                                                                    echo '- '.$name;
                                                                }
                                                            echo '</span>';
                                                        echo '</td>';
                                                        
                                                        // comments
                                                        echo '<td class="text-center">';
                                                            echo '<button class="btn btn-primary mt-2 comments" data-id="'.$data['id'].'">';
                                                                echo renderLang($lang_messages);
                                                                $account_seen = ','.$_SESSION['sys_id'].':'.$_SESSION['sys_account_mode'].',';
                                                                $comment_count = getField('count(id)', 'comments', 'module = "other-task" AND module_type = "other_task_'.$data['id'].'" AND module_id = '.$id.' AND (seen_by NOT LIKE "%'.$account_seen.'%" OR seen_by IS NULL)');
                                                                if(checkVar($comment_count)) {
                                                                    echo '<span class="badge badge-danger ml-2">'.$comment_count.'</span>';
                                                                }
                                                            echo '</button>';
                                                        echo '</td>';

                                                        // timeline
                                                        echo '<td>';
                                                            echo '<input type="text" class="form-control '.($if_editable ? 'date' : 'input-readonly').' border-0" name="OT_timeline[]" value="'.(checkVar($data['timeline']) ? formatDate($data['timeline']) != '1970-01-01' ? formatDate($data['timeline']) : date('Y-m-d') : date('Y-m-d')).'" '.($if_editable ? '' : 'readonly').'>';
                                                        echo '</td>';

                                                        // ATTACHMENT
                                                        echo '<td>';
                                                            renderAttachments($data['activity_attachment'], 'other-task-activities');
                                                            echo '<input type="file" class="form-control border-0" name="OT_attachment[]" >';
                                                        echo '</td>';

                                                    echo '</tr>';

                                                    echo '<input type="hidden" name="OT_code[]" value="'.$data['code'].'">';

                                                    $act_num++;
                                            	}
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
								
							</div><!-- card-body -->

							<div class="card-footer text-right">
								<a href="/pre-operation-other-tasks" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderlang($lang_save); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <!-- action taken -->
	<div class="modal fade" id="modal-action-taken">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?php echo renderLang($other_task_update_action_taken); ?></h4>
				</div>
					<div class="modal-body">

						<div class="row">

							<div class="col-12">
								<div class="form-group">
									<label for="update_action_taken"><?php echo renderLang($other_task_action_taken); ?></label>
									<textarea name="action-taken" id="update_action_taken" class="form-control notes"></textarea>
								</div>
							</div>
												
						</div>
												
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button class="btn btn-primary" id="save-action-taken"><i class="fa fa-upload mr-2"></i><?php echo renderLang($other_task_save_action_taken); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>

    <!-- Comments -->
    <div class="modal fade" id="modal-comments">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($lang_remarks); ?></h4>
				</div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">

                            <div class="card direct-chat direct-chat-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo renderLang($lang_comments); ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="direct-chat-messages">
                                    </div>
                                </div>
                                <div class="card-footer">
                                        <form action="" method="post" id="checklist-comment-form" autocomplete="off">
                                            <div class="input-group">
                                                <input type="text" name="comment" placeholder="" class="form-control">
                                                <span class="input-group-append">
                                                    <button id="add-comment" class="btn btn-primary">Send</button>
                                                </span>
                                            </div>
                                            <p id="err_msg" class="error-message text-danger mt-1"></p>
                                        </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_close); ?></button>
                </div>
			</div>
		</div>
	</div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {

            // load comments
                var activity_id;
                $('body').on('click', '.comments', function(e){
                    e.preventDefault();
                    var $this = $(this);

                    activity_id = $(this).data('id');
                    var module_id = <?php echo $id; ?>;

                    $.post('/render-other-task-comments', {
                        activity_id:activity_id, module_id:module_id
                    }, function(data){
                        $('#modal-comments').find('.direct-chat-messages').html(data);
                    }).done(function(){
                        $('#modal-comments').modal('show');
                        $this.find('span').html('0');
                    });
                });

                $('#checklist-comment-form').on('submit', function(e){
                    e.preventDefault();

                    var comment = $(this).find('input[name="comment"]').val();
                    var module = 'other-task';
                    var module_type = "other_task_"+activity_id;
                    var module_id = <?php echo $id; ?>;

                    $.post('/add-comment', {
                        comment:comment, module:module, 
                        module_type:module_type, module_id:module_id
                    }, function(data){
                        
                        $.post('/render-other-task-comments', {
                            activity_id:activity_id, module_id:module_id
                        }, function(data){
                            $('#modal-comments').find('.direct-chat-messages').html(data);
                        });

                    });

                    $(this).find('input[name="comment"]').val('');

                });
            // 

            var num = [];
            num['OT'] = <?php echo $act_count < 1 ? '0' : $act_count + 1; ?>;
            $('.add-row').on('click', function(e){
                e.preventDefault();

                var code = $(this).data('code');

                num[code]++;

                var row_fields = '<input type="hidden" name="ot_id[]" value="0"><td><input type="text" class="form-control border-0 input-readonly" name="'+code+'_date[]" value="<?php echo date('Y-m-d'); ?>" readonly></td><td><textarea name="'+code+'_remarks[]" rows="2" class="form-control notes border-0"></textarea></td><td></td><td></td><td><input type="text" class="form-control date border-0" name="'+code+'_timeline[]"></td><td><input type="file" class="form-control" name="'+code+'_attachment[]" ></td>';

                $(this).closest('.table-responsive').find('.table-data').prepend('<tr>'+row_fields+'</tr><input type="hidden" name="'+code+'_code[]" value="'+code+'<?php echo $ot_id; ?>'+num[code]+'">');

                $('.date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
						locale: {
							format: 'YYYY-MM-DD'
						}
                    });
                });

            });

			$('.date').each(function(){
				$(this).daterangepicker({
					singleDatePicker: true,
					locale: {
						format: 'YYYY-MM-DD'
					}
				});
			});

			// action taken modal
			var id;
			$('body').on('click', '.action-taken', function(){

				id = $(this).data('id');
				
				var action_taken = $(this).val();

				$('#update_action_taken').val(action_taken);

				$('#modal-action-taken').modal('show');

			});

			// save action taken
			$('#save-action-taken').on('click', function(e){
				e.preventDefault();

				var action_taken = $('#update_action_taken').val();
				
				$.post('/save-action-taken', {
					id:id, action_taken:action_taken
				}, function(data) {
					if(data == 'success') {
						window.location.reload();
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